<?php

namespace App\Libraries;

require APPPATH . "Controllers/mike42/autoload.php";

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class impresion
{
    /**
     * Calcular imuestos
     * @param   $cod(igo_interno
     * 
     */
    function imprimir_cuadre_caja($id_apertura)
    {


        //$id_apertura = $id_apertura;
        $id_apertura = 19;

        $id_impresora = model('impresionFacturaModel')->select('id_impresora')->first();
        $datos_empresa = model('empresaModel')->datosEmpresa();

        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
        $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");
        $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
        $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombreregimen'] . "\n");
        $printer->text("\n");

        $fecha_apertura = model('aperturaModel')->select('fecha')->where('id', $id_apertura)->first();
        $hora_apertura = model('aperturaModel')->select('hora')->where('id', $id_apertura)->first();

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("**CUADRE DE CAJA** \n");

        $printer->text("Fecha apertura:  " . $fecha_apertura['fecha'] . " " . date("g:i a", strtotime($hora_apertura['hora'])) . "\n");


        $cierre = model('cierreModel')->select('fecha')->where('idapertura', $id_apertura)->first();

        if (!empty($cierre)) {
            $hora = model('cierreModel')->select('hora')->where('idapertura', $id_apertura)->first();
            $printer->text("Fecha cierre:    " . $cierre['fecha'] . " " . date("g:i a", strtotime($hora['hora'])) . "\n");
        }
        if (empty($cierre)) {
            $printer->text("Fecha cierre:    Sin cierre " . "\n");
        }




        $printer->text("Caja N° : 1 \n");

        $printer->text("\n");

        $valor_apertura = model('aperturaModel')->select('valor')->where('id', $id_apertura)->first();
        $printer->text("Valor apertura: " . "        $ " . number_format($valor_apertura['valor'], 0, ",", ".") . "\n");
        $ventas_pos = model('pagosModel')->set_ventas_pos($id_apertura);

        $ventas_electronicas = model('pagosModel')->set_ventas_electronicas($id_apertura);
        $propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $id_apertura)->findAll();
        $printer->text("Ventas pos: " . "            $ " . number_format($ventas_pos[0]['valor'], 0, ",", ".") . "\n");
        $printer->text("Valor electrónicas: "  .  "    $ " . number_format($ventas_electronicas[0]['valor'], 0, ",", ".") . "\n");
        $printer->text("Propinas: "  .  "              $ " . number_format($propinas[0]['propina'], 0, ",", ".") . "\n");

        $printer->text("\n");

        $printer->text("-----------------------------------------------\n ");
        $printer->text("INGRESOS \n ");
        $printer->text("-----------------------------------------------\n ");
        $printer->text("\n");



        $ingresos_efectivo = model('pagosModel')->selectSum('efectivo')->where('id_apertura', $id_apertura)->findAll();
        $efectivo = $ingresos_efectivo[0]['efectivo'];
        $ingresos_transaccion = model('pagosModel')->selectSum('transferencia')->where('id_apertura', $id_apertura)->findAll();
        $propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $id_apertura)->findAll();

        //dd($efectivo);
        $printer->text("Ingresos efectivo:      " . "$ " . number_format($ingresos_efectivo[0]['efectivo'], 0, ",", ".") . "\n");
        $printer->text("Ingresos transacción: " . "  $ " . number_format($ingresos_transaccion[0]['transferencia'], 0, ",", ".") . "\n");
        //$total_ingresos = model('facturaFormaPagoModel')->total_ingresos($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_actual);
        $printer->text("Total ingresos          " . "$ " . number_format(($ingresos_efectivo[0]['efectivo']  + $valor_apertura['valor']), 0, ",", ".") . "\n");


        $printer->text("\n");

        $printer->text("------------------------------------------------\n ");
        $printer->text("RETIROS \n");
        $printer->text("------------------------------------------------\n ");
        $retiros = model('retiroModel')->select('*')->where('id_apertura', $id_apertura)->findAll();

        $printer->text("\n");
        foreach ($retiros as $detalle) {
            $printer->text("FECHA: " . $detalle['fecha'] . " " . date("g:i a", strtotime($detalle['hora'])) . "\n");
            $concepto = model('retiroFormaPagoModel')->select('concepto')->where('idretiro', $detalle['id'])->first();
            $printer->text("CONCEPTO:" . $concepto['concepto'] . "\n");
            $valor = model('retiroFormaPagoModel')->select('valor')->where('idretiro', $detalle['id'])->first();
            $printer->text("VALOR:" . "$" . number_format($valor['valor'], 0, ",", ".") . "\n");
            $printer->text("\n");
        }



        $temp_retiros = 0;
        $total_retiros = 0;
        foreach ($retiros as $detalle) {
            $valor = model('retiroFormaPagoModel')->select('valor')->where('idretiro', $detalle['id'])->first();
            $temp_retiros = $temp_retiros + $valor['valor'];
            $total_retiros = $temp_retiros;
        }

        $printer->text("Total retiros: " . "         $ " . number_format($total_retiros, 0, ",", ".") . "\n");

        $printer->text("\n");

        $printer->text("------------------------------------------------\n ");
        $printer->text("DEVOLUCIONES \n");
        $printer->text("------------------------------------------------\n ");
        $printer->text("\n");

        $devolucion_venta = model('devolucionModel')->where('id_apertura', $id_apertura)->findAll();


        $temp_devoluciones = 0;
        $total_devoluciones = 0;

        foreach ($devolucion_venta as $detalle) {

            $printer->text("FECHA:" . $detalle['fecha'] . " " . date("g:i a", strtotime($detalle['hora'])) . "\n");
            $codigo_interno_producto = model('detalleDevolucionVentaModel')->select('codigo')->where('id_devolucion_venta', $detalle['id'])->first();
            $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $codigo_interno_producto['codigo'])->first();
            $printer->text("PRODUCTO: " . $nombre_producto['nombreproducto'] . "\n");
            $valor = model('devolucionVentaEfectivoModel')->select('valor')->where('iddevolucion', $detalle['id'])->first();
            $printer->text("VALOR " . "$" . number_format($valor['valor'], 0, ",", ".") . "\n");
            $printer->text("\n");


            $temp_devoluciones = $temp_devoluciones + $valor['valor'];
            $total_devoluciones = $temp_devoluciones;
        }

        $printer->text("Total devoluciones:" . "     $ " . number_format($total_devoluciones, 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->text("------------------------------------------------\n");
        $printer->text("Ingresos-retiros-devoluciones \n");
        $printer->text("------------------------------------------------\n");

        $printer->text("Ingresos+apertura " . "      $ " . number_format($ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'], 0, ",", ".") . "\n");

        $printer->text("(-) Total retiros: " . "     $ " . number_format($total_retiros, 0, ",", ".") . "\n");
        $printer->text("(-) Total devoluciones:" . " $ " . number_format($total_devoluciones, 0, ",", ".") . "\n");

        $temp = $ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'];
        $total_caja = $total_retiros + $total_devoluciones;
        $total_en_caja = $temp - $total_caja;

        $printer->text("(=) Efectivo en caja:   $ " . number_format($total_en_caja, 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->text("-----------------------------------------------\n");
        $printer->text("Cierre de caja \n");
        $printer->text("-----------------------------------------------\n");
        //$printer->text("Efectivo en caja   " . "     $ " . number_format($total_en_caja, 0, ",", ".") . " \n");


        $id_cierre = model('cierreModel')->select('id')->where('idapertura', $id_apertura)->first();

        if (!empty($id_cierre)) {
            $valor_cierre_efectivo_usuario = model('cierreFormaPagoModel')->valor_cierre_efectivo_usuario($id_cierre['id']);
        }



        if (empty($valor_cierre_efectivo_usuario)) {
            $cierre_usuario = 0;
        }
        if (!empty($valor_cierre_efectivo_usuario)) {
            $cierre_usuario =  $valor_cierre_efectivo_usuario[0]['valor'];
        }

        $printer->text("\n");

        if (empty($ingresos_transaccion)) {
            $transaccion = 0;
        }

        if (!empty($ingresos_transaccion)) {
            $transaccion = $ingresos_transaccion[0]['transferencia'];
        }


        $printer->text("Efectivo: " . "              $ " . number_format($total_en_caja, 0, ",", ".") . "\n");
        $printer->text("Transacciones: " . "         $ " . number_format($transaccion, 0, ",", ".") . "\n\n");
        if (!empty($id_cierre)) {
            $valor_cierre_transaccion_usuari = model('cierreFormaPagoModel')->valor_cierre_transaccion_usuario($id_cierre['id']);
        }


        if (empty($valor_cierre_transaccion_usuari)) {
            $valor_cierre_transaccion_usuario = 0;
        }
        if (!empty($valor_cierre_transaccion_usuari)) {
            $valor_cierre_transaccion_usuario = $valor_cierre_transaccion_usuari[0]['valor'];
        }

        $printer->text("Cierre efectivo  " . "       $ " .  number_format($cierre_usuario, 0, ",", ".") .  "\n");
        $printer->text("Cierre transacciones  " . "  $ " .  number_format($valor_cierre_transaccion_usuario, 0, ",", ".") .  "\n\n");

        if ($total_en_caja > $cierre_usuario) {
        $printer->text("Diferencia efectivo  " . "   $ " . number_format(($total_en_caja) - $cierre_usuario, 0, ",", ".") . "\n");
        }
        if ($total_en_caja < $cierre_usuario) {
        $printer->text("Diferencia efectivo  " . "   $ " . number_format(($cierre_usuario) - $total_en_caja , 0, ",", ".") . "\n");
        }


        $printer->text("Diferencia transaccion  " . "$ " . number_format($transaccion - $valor_cierre_transaccion_usuario, 0, ",", ".") . "\n");

        $printer->text("\n");

        if ($total_en_caja > $cierre_usuario) {
            $printer->text("TOTAL DIFERENCIAS  " . "     $ " . number_format((($total_en_caja) - $cierre_usuario) + ($transaccion - $valor_cierre_transaccion_usuario), 0, ",", ".") . "\n");
        }
        if ($total_en_caja < $cierre_usuario) {
            $printer->text("TOTAL DIFERENCIAS  " . "     $ " . number_format((($cierre_usuario ) - $total_en_caja ) + ($transaccion - $valor_cierre_transaccion_usuario), 0, ",", ".") . "\n");
        }
        $printer->text("\n");

        $printer->feed(1);
        $printer->cut();

        $printer->close();
    }


    function imprimir_factura_electronica($id_factura)
    {
        //$id_factura = $this->request->getPost('id_factura');
        $id_factura = $id_factura;
        //$id_factura = 24;
        $id_impresora = model('cajaModel')->select('id_impresora')->first();
        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);

        $id_estado = model('facturaElectronicaModel')->select('id_status')->where('id', $id_factura)->first();
        $numero = model('facturaElectronicaModel')->select('numero')->where('id', $id_factura)->first();




        if ($id_estado['id_status'] == 1) {
            $estado = "PENDIENTE";
        }
        if ($id_estado['id_status'] == 2) {
            $estado = "FIRMADO";
        }

        $nit_cliente = model('facturaElectronicaModel')->select('nit_cliente')->where('id', $id_factura)->first();
        $nombres_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $direccion = model('clientesModel')->select('direccioncliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $telefono = model('clientesModel')->select('telefonocliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $email = model('clientesModel')->select('emailcliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();


        $datos_empresa = model('empresaModel')->datosEmpresa();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
        $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");
        $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
        $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
        $printer->text("Responsable de IVA – INC\n");
        /*  $printer->text($datos_empresa[0]['nombreregimen'] . "\n"); */
        $printer->text("\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("ORDEN DE PEDIDO  " . $numero['numero'] . "\n");
        $printer->text("TIPO DE VENTA:   ELECTRÓNICA DE CONTADO \n");
        $printer->text("FECHA:           " . date('Y-m-d') . "\n");
        $printer->text("CAJA:            1"  . "\n");
        $printer->text("CAJERO:          Usuario administrador"  . "\n");
        $printer->text("\n");
        $items = model('itemFacturaElectronicaModel')->where('id_de', $id_factura)->findAll();

        $printer->text("---------------------------------------------" . "\n");
        $printer->text("CLIENTE:         " . $nombres_cliente['nombrescliente'] . "\n");
        $printer->text("NIT :            " . $nit_cliente['nit_cliente']  . "\n");
        $printer->text("DIRECCIÓN:       " . $direccion['direccioncliente']  . "\n");
        $printer->text("TELEFÓNO         " . $telefono['telefonocliente'] . "\n");
        $printer->text("EMAIL:           " . $email['emailcliente'] . "\n");


        $printer->text("---------------------------------------------" . "\n");
        $printer->text("CÓDIGO    DESCRIPCIÓN   VALOR UNITARIO    TOTAL" . "\n");
        $printer->text("---------------------------------------------" . "\n");




        foreach ($items as $productos) {

            $printer->setTextSize(1, 1);
            $printer->text("Cod." . $productos['codigo'] . "      " . $productos['descripcion'] . "\n");
            $printer->text("Cant. " . $productos['cantidad'] . "      " . "$" . number_format($productos['neto'], 0, ',', '.') . "                   " . "$" . number_format($productos['total'], 0, ',', '.') . "\n");
            if (!empty($productos['nota_producto'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("NOTAS:\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text($productos['nota_producto'] . "\n");
            }

            $printer->text("\n");
        }

        $inc = model('kardexModel')->get_total_inc($id_factura);
        $iva = model('kardexModel')->get_total_iva($id_factura);



        $total =  model('pagosModel')->select('total_documento')->where('id_factura', $id_factura)->first();
        $total =  model('pagosModel')->select('total_documento')->where('id_factura', $id_factura)->first();
        $transferencia =  model('pagosModel')->select('recibido_transferencia')->where('id_factura', $id_factura)->first();
        $efectivo =  model('pagosModel')->select('recibido_efectivo')->where('id_factura', $id_factura)->first();

        $sub_total = $total['total_documento'] - ($inc[0]['total_inc'] + $iva[0]['total_iva']);




        $printer->text("_______________________________________________ \n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("SUB TOTAL:" .    number_format($sub_total, 0, ",", ".") . "\n");
        $printer->text("INC:"    .     number_format($inc[0]['total_inc'], 0, ",", ".") . "\n");
        $printer->text("IVA:"    .     number_format($iva[0]['total_iva'], 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->setTextSize(2, 1);
        $printer->text("TOTAL:      " . "$ " . number_format($total['total_documento'], 0, ",", ".") . "\n");
        $printer->text("\n");
        $printer->setTextSize(1, 1);

        if ($efectivo['recibido_efectivo'] > 0) {
            $printer->text("Efectivo:" . "$ " . number_format($efectivo['recibido_efectivo'], 0, ",", ".")  . "\n");
        }
        if ($transferencia['recibido_transferencia'] > 0) {
            $printer->text("Transferencia:" . "$ " . number_format($transferencia['recibido_transferencia'], 0, ",", ".") . "\n");
        }

        //$printer->text("Cambio:."" ."\n");




        $printer->text("_______________________________________________ \n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("ACTIVIDAD ECONÓMICA 1063;4719 \n");
        $printer->text("NO CONTRIBUYENTES DE RENTA  \n");
        $printer->text("NO SUJETO A RETENCIÓN  \n");
        $printer->text("GRAN CONTRIBUYENTE  \n");
        $printer->text("AGENTE RETENEDOR IVA \n");
        $printer->text("DOMICILIO PRINCIPAL: CALLE 73 NO. 8 - 13  \n");
        $printer->text("BOGOTÁ - COLOMBIA. \n");
        $printer->text("_______________________________________________ \n");
        $total = model('facturaElectronicaModel')->select('total')->where('id', $id_factura)->first();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("IMPRESO POR SOFTWARE DFPYME INTREDETE. \n");
        $printer->text("NIT: 901448365-5\n");
        $printer->text("\n");

        $printer->feed(1);
        $printer->cut();

        $printer->close();

        $returnData = array(
            "resultado" => 1
        );
        echo  json_encode($returnData);
    }


    function impresion_factura_electronica($id_factura)
    {
        //$id_factura = $this->request->getPost('id_factura');

        $id_factura = $id_factura;
        $id_impresora = model('cajaModel')->select('id_impresora')->first();
        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();
        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);
        $printer = new Printer($connector);

        $id_estado = model('facturaElectronicaModel')->select('id_status')->where('id', $id_factura)->first();
        $numero = model('facturaElectronicaModel')->select('numero')->where('id', $id_factura)->first();

        $fecha = model('facturaElectronicaModel')->select('fecha')->where('id', $id_factura)->first();
        $hora = model('facturaElectronicaModel')->select('hora')->where('id', $id_factura)->first();


        if ($id_estado['id_status'] == 1) {
            $estado = "PENDIENTE";
        }
        if ($id_estado['id_status'] == 2) {
            $estado = "FIRMADO";
        }

        $nit_cliente = model('facturaElectronicaModel')->select('nit_cliente')->where('id', $id_factura)->first();
        $nombres_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $direccion = model('clientesModel')->select('direccioncliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $telefono = model('clientesModel')->select('telefonocliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $email = model('clientesModel')->select('emailcliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();


        $datos_empresa = model('empresaModel')->datosEmpresa();
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
        $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
        $printer->text("NIT: " . $datos_empresa[0]['nitempresa'] . "\n");
        $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
        $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
        $printer->text("Responsable de IVA – INC\n\n");
        /*  $printer->text($datos_empresa[0]['nombreregimen'] . "\n"); */
        $printer->text("ACTIVIDAD ECONÓMICA 1063;4719 \n");
        $printer->text("NO CONTRIBUYENTES DE RENTA  \n");
        $printer->text("NO SUJETO A RETENCIÓN  \n");
        $printer->text("GRAN CONTRIBUYENTE  \n");
        $printer->text("AGENTE RETENEDOR IVA \n");
        $printer->text("COMITE DEPARTAMENTAL DE CAFETEROS DE RISARALDA  \n");
        $printer->text("CR 9 No 36-43 PEREIRA RISARALDA  \n");;
        $printer->text("\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("FACTURA ELECTRÓNICA DE VENTA NÚMERO: " . $numero['numero'] . "\n");
        $printer->text("TIPO DE VENTA:   ELECTRÓNICA DE CONTADO \n");
        /* $printer->text("FECHA Y HORA DE GENERACIÓN: " . $fecha['fecha'] ." ".$hora['hora'] ."\n"); */
        $printer->text("FECHA GENERACIÓN: " . $fecha['fecha'] . "      HORA: " . $hora['hora'] . "\n");
        $printer->text("FECHA VALIDACIÓN: " . $fecha['fecha'] . "      HORA: " . $hora['hora'] . "\n");
        /* $printer->text("FECHA Y HORA DE VALIDACIÓN :" . $fecha['fecha'] ." ".$hora['hora'] ."\n"); */
        $printer->text("CAJA:            1"  . "\n");
        $printer->text("CAJERO:          Usuario administrador"  . "\n");
        $printer->text("\n");
        //$items = model('itemFacturaElectronicaModel')->where('id_de', $id_factura)->findAll();
        $items = model('kardexModel')->get_productos_factura($id_factura);

        $printer->text("---------------------------------------------" . "\n");
        $printer->text("CLIENTE:     " . $nombres_cliente['nombrescliente'] . "\n");
        $printer->text("NIT/CC:      " . $nit_cliente['nit_cliente']  . "\n");
        $printer->text("DIRECCIÓN:   " . $direccion['direccioncliente']  . "\n");
        $printer->text("TELEFÓNO    " . $telefono['telefonocliente'] . "\n");
        $printer->text("EMAIL:       " . $email['emailcliente'] . "\n");


        $printer->text("---------------------------------------------" . "\n");
        $printer->text("CÓDIGO  DESCRIPCIÓN  VALOR UNITARIO  TOTAL   IMP" . "\n");
        $printer->text("---------------------------------------------" . "\n");

        $qrtext = 'prueba';




        foreach ($items as $productos) {

            $printer->setTextSize(1, 1);
            $printer->text("Cod." . $productos['codigo'] . "      " . $productos['descripcion'] . "\n");

            if ($productos['aplica_ico'] == 't') {
                $impuesto = $productos['valor_ico'];
            }
            if ($productos['aplica_ico'] == 'f') {
                $impuesto = $productos['valor_iva'];
            }



            $printer->text("Cant. " . $productos['cantidad'] . "      " . "$" . number_format($productos['neto'], 0, ',', '.') . "                   " . "$" . number_format($productos['total'], 0, ',', '.') . " " .  $productos['valor_ico'] . "%" . "\n");
            if (!empty($productos['nota_producto'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->text("NOTAS:\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text($productos['nota_producto'] . "\n");
            }

            $printer->text("\n");
        }

        $inc = model('kardexModel')->get_total_inc($id_factura);
        $iva = model('kardexModel')->get_total_iva($id_factura);



        $total =  model('pagosModel')->select('total_documento')->where('id_factura', $id_factura)->first();
        $total =  model('pagosModel')->select('total_documento')->where('id_factura', $id_factura)->first();
        $transferencia =  model('pagosModel')->select('recibido_transferencia')->where('id_factura', $id_factura)->first();
        $efectivo =  model('pagosModel')->select('recibido_efectivo')->where('id_factura', $id_factura)->first();

        $sub_total = $total['total_documento'] - ($inc[0]['total_inc'] + $iva[0]['total_iva']);

        function formatValue($label, $value)
        {
            // Ajusta el tamaño de la etiqueta para que sea uniforme
            $label = str_pad($label, 15, ' ', STR_PAD_RIGHT);
            // Formatea el valor como moneda
            $formatted_value =  number_format($value, 0, ",", ".");
            // Calcula el espacio necesario para alinear los valores
            $spaces = str_repeat(' ', 40 - strlen($label) - strlen($formatted_value));
            return $label . $spaces . $formatted_value . "\n";
        }

        $printer->text("_______________________________________________ \n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text(formatValue("SUB TOTAL:", $sub_total));
        $printer->text(formatValue("INC:", $inc[0]['total_inc']));
        $printer->text(formatValue("IVA :", $iva[0]['total_iva']));

        $printer->text("\n");
        $printer->setTextSize(2, 1);
        $printer->text("TOTAL:      " . "$ " . number_format($total['total_documento'], 0, ",", ".") . "\n");
        $printer->text("\n");
        $printer->setTextSize(1, 1);

        $printer->text(str_pad("PAGO EFECTIVO:", 40, " ")  . number_format($efectivo['recibido_efectivo'], 0, ",", ".") . "\n");

        if ($transferencia['recibido_transferencia'] > 0) {
            $printer->text(str_pad("PAGO TRANSFERENCIA :", 40, " ") . "$ " . number_format($transferencia['recibido_transferencia'], 0, ",", ".") . "\n");
        }

        $cambio = model('pagosModel')->select('cambio')->where('id_factura', $id_factura)->first();

        $printer->text(str_pad("CAMBIO:", 40, " ") . $cambio['cambio'] . "\n");


        $printer->text("_______________________________________________ \n\n");
        $total = model('facturaElectronicaModel')->select('total')->where('id', $id_factura)->first();

        $inc_tarifa = model('kardexModel')->get_inc_calc($id_factura);
        $iva_tarifa = model('kardexModel')->get_iva_calc($id_factura);

        $items = model('kardexModel')->selectCount('id')->where('id_factura', $id_factura)->findAll();
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Numero de items: " . $items[0]['id'] .  "\n");
        $printer->text("_______________________________________________ \n");
        if (!empty($inc_tarifa)) {

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("** DISCRIMINACIÓN DE TARIFAS DE INC **   \n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            /*   $printer->text("TARIFA          BASE/INC          VENTA   \n");

             foreach($inc_tarifa as $detalle ){
                $inc = model('kardexModel')->get_tarifa_ico($id_factura,$detalle['valor_ico']);
                $printer->text($inc_tarifa[0]['valor_ico']." %        ".  number_format(($total['total']-$inc[0]['inc']   ), 0, ",", ".").  "   " .number_format($total['total'], 0, ",", ".").   "\n");
             } */

            $printer->text(str_pad("TARIFA", 15, " ") . str_pad("BASE/INC", 15, " ") . "VENTA\n");

            foreach ($inc_tarifa as $detalle) {
                $inc = model('kardexModel')->get_tarifa_ico($id_factura, $detalle['valor_ico']);

                $tarifa = $inc_tarifa[0]['valor_ico'] . " %";
                $base_inc = number_format(($total['total'] - $inc[0]['inc']), 0, ",", ".");
                $venta = number_format($total['total'], 0, ",", ".");

                $printer->text(str_pad($tarifa, 15, " ") . str_pad($base_inc, 15, " ") . $venta . "\n");
            }
        }


        if (!empty($iva_tarifa)) {

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("** DISCRIMINACIÓN DE TARIFAS DE IVA **   \n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            /*   $printer->text("TARIFA          BASE/INC          VENTA   \n");

             foreach($inc_tarifa as $detalle ){
                $inc = model('kardexModel')->get_tarifa_ico($id_factura,$detalle['valor_ico']);
                $printer->text($inc_tarifa[0]['valor_ico']." %        ".  number_format(($total['total']-$inc[0]['inc']   ), 0, ",", ".").  "   " .number_format($total['total'], 0, ",", ".").   "\n");
             } */

            $printer->text(str_pad("TARIFA", 15, " ") . str_pad("BASE/IVA", 15, " ") . "VENTA\n");

            foreach ($iva_tarifa as $detalle) {
                $iva = model('kardexModel')->get_tarifa_iva($id_factura, $detalle['valor_iva']);

                $tarifa = $iva_tarifa[0]['valor_iva'] . " %";
                $base_iva = number_format(($total['total'] - $iva[0]['iva']), 0, ",", ".");
                $venta = number_format($total['total'], 0, ",", ".");

                $printer->text(str_pad($tarifa, 15, " ") . str_pad($base_iva, 15, " ") . $venta . "\n");
            }
        }

        $id_resolucion = model('facturaElectronicaModel')->select('id_resolucion')->where('id', $id_factura)->first();

        //dd( $id_resolucion  )


        $datos_resolucion = model('resolucionElectronicaModel')->where('id', $id_resolucion['id_resolucion'])->first();

        $printer->text("\n");
        $printer->text("Resolución DIAN No " . $datos_resolucion['numero'] . " de " . $datos_resolucion['date_begin'] . "\n");
        $printer->text("del " . $datos_resolucion['number_begin'] . " al " . $datos_resolucion['number_end'] . " prefijo " . $datos_resolucion['prefijo'] . "\n");
        $printer->text("\n");

        $qr = model('facturaElectronicaModel')->select('qrcode')->where('id', $id_factura)->first();
        $cufe = model('facturaElectronicaModel')->select('cufe')->where('id', $id_factura)->first();
        //$printer->qrCode($qr['qrcode']);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Representación gráfica de factura electrónica \n");

        $printer->text("número: " . $numero['numero'] . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->qrCode($qr['qrcode'], Printer::QR_ECLEVEL_L, 4);
        $printer->text("\n");

        $printer->text("CUFE: \n" . $cufe['cufe'] . "\n");

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("_______________________________________________ ");
        $printer->text("\n");
        $printer->text("IMPRESO POR SOFTWARE DFPYME INTREDETE. \n");
        $printer->text("NIT: 901448365-5\n");
        $printer->text("\n");


        $printer->feed(1);
        $printer->cut();

        $printer->close();

        $returnData = array(
            "resultado" => 1
        );
        echo  json_encode($returnData);
    }


    public function imprimir_factura($id_factura)
    {

        // $id_factura = 57069;

        $id_factura = $id_factura;

        $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();

        $regimen = model('empresaModel')->select('idregimen')->first();

        if (!empty($numero_factura['numerofactura_venta'])) {

            $numero_factura['numerofactura_venta'];


            $fecha_factura_venta = model('facturaVentaModel')->select('fecha_factura_venta')->where('id', $id_factura)->first();
            $hora_factura_venta = model('facturaVentaModel')->select('horafactura_venta')->where('id', $id_factura)->first();
            $id_usuario = model('facturaVentaModel')->select('idusuario_sistema')->where('id', $id_factura)->first();
            $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario['idusuario_sistema'])->first();
            $datos_empresa = model('empresaModel')->datosEmpresa();

            $nit_cliente = model('facturaVentaModel')->select('nitcliente')->where('id', $id_factura)->first();
            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente['nitcliente'])->first();

            $id_impresora = model('cajaModel')->select('id_impresora')->first();

            $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();

            $connector = new WindowsPrintConnector($nombre_impresora['nombre']);

            $printer = new Printer($connector);

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 2);
            $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
            $printer->setTextSize(1, 1);
            $printer->text($datos_empresa[0]['nombrejuridicoempresa'] . "\n");
            $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");
            $printer->text($datos_empresa[0]['direccionempresa'] . "  " . $datos_empresa[0]['nombreciudad'] . " " . $datos_empresa[0]['nombredepartamento'] . "\n");
            $printer->text("TELEFONO:" . $datos_empresa[0]['telefonoempresa'] . "\n");
            $printer->text($datos_empresa[0]['nombreregimen'] . "\n");
            //$printer->text(" Responsable de IVA – INC \n");
            $printer->text("\n");


            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $estado_factura = model('facturaVentaModel')->estado_factura($id_factura);

            if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 2) {
                $printer->text("FACTURA DE VENTA: " . $numero_factura['numerofactura_venta'] . "\n");
            }

            if ($estado_factura[0]['idestado'] == 7) {
                $printer->text("REMISION : " . $numero_factura['numerofactura_venta'] . "\n");
            }



            $printer->text("TIPO DE VENTA:" . $estado_factura[0]['descripcionestado'] . "\n");

            $printer->text("FECHA:" . " " . $fecha_factura_venta['fecha_factura_venta'] . "  " . date("g:i a", strtotime($hora_factura_venta['horafactura_venta'])) . "\n");
            if ($estado_factura[0]['idestado'] == 2) {
                $printer->text("FECHA LIMITE:" . $estado_factura[0]['fechalimitefactura_venta'] . "\n");
            }
            $printer->text("CAJA : 1" . "\n");
            $printer->text("CAJERO: " . $nombre_usuario['nombresusuario_sistema'] . "\n");

            $printer->text("---------------------------------------------" . "\n");
            $printer->text("CLIENTE :" . " " . $nombre_cliente['nombrescliente'] . "\n");
            $printer->text("NIT     :" . " " . number_format($nit_cliente['nitcliente'], 0, ",", ".") . "\n");
            $printer->text("---------------------------------------------" . "\n");
            $printer->text("CODIGO    DESCRIPCION   VALOR UNITARIO    TOTAL" . "\n");
            $printer->text("---------------------------------------------" . "\n");



            $items = model('productoFacturaVentaModel')->getProductosFacturaVentaModel($id_factura);

            foreach ($items as $detalle) {
                $valor_venta = $detalle['total'] / $detalle['cantidadproducto_factura_venta'];
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->text("Cod." . $detalle['codigointernoproducto'] . "      " . $detalle['nombreproducto'] . "\n");
                $printer->text("Cant. " . $detalle['cantidadproducto_factura_venta'] . "      " . "$" . number_format($valor_venta, 0, ',', '.') . "                   " . "$" . number_format($detalle['total'], 0, ',', '.') . "\n");
            }

            $cantidad_iva = model('productoFacturaVentaModel')->impuestos($id_factura);

            $iva_temp = 0;
            $ico_temp = 0;
            $venta_real_temp = 0;




            foreach ($cantidad_iva  as $detalle) {
                $iva = $detalle['cantidadproducto_factura_venta'] * $detalle['iva'];
                $impuesto_al_consumo = $detalle['cantidadproducto_factura_venta'] * $detalle['impuesto_al_consumo'];
                $total_iva = $iva + $iva_temp;
                $iva_temp = $total_iva;

                $total_ico = $impuesto_al_consumo + $ico_temp;
                $ico_temp = $total_ico;

                $sub_total = $detalle['valor_venta_real'] * $detalle['cantidadproducto_factura_venta'];

                $sub_totales = $sub_total + $venta_real_temp;
                $venta_real_temp = $sub_totales;
            }

            //echo $total_iva."</br>";


            $printer->text("---------------------------------------------" . "\n");
            $total = model('productoFacturaVentaModel')->selectSum('total')->where('id_factura', $id_factura)->find();
            $printer->setJustification(Printer::JUSTIFY_RIGHT);


            $impuesto_saludable = model('productoFacturaVentaModel')->get_impuesto_saluidable($id_factura);

            if ($regimen['idregimen'] == 1) {

                if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 2) {

                    $printer->text("SUB TOTAL :" . "$" . number_format($total[0]['total'] - ($total_ico - $total_iva) - $impuesto_saludable[0]['total_impuesto_saludable'], 0, ",", ".") . "\n");


                    if ($total_iva != 0) {
                        $printer->text("IVA       :" . "$" . number_format($total_iva, 0, ",", ".") . "\n");
                    }

                    if ($total_ico) {
                        $printer->text("IMPUESTO AL CONSUMO :" . "$" . number_format($total_ico, 0, ",", ".") . "\n");
                    }
                }
            }




            $descuento = model('facturaVentaModel')->select('descuento')->where('id', $id_factura)->first();
            $printer->text("DESCUENTO :" . "$" . number_format($descuento['descuento'], 0, ",", ".") . "\n");

            $propina = model('facturaVentaModel')->select('propina')->where('id', $id_factura)->first();
            $printer->text("PROPINA :" . "$" . number_format($propina['propina'], 0, ",", ".") . "\n\n");
            $printer->setTextSize(2, 2);
            $printer->text("TOTAL :" . "$" . number_format(($total[0]['total'] - $descuento['descuento']) + $propina['propina'], 0, ",", ".") . "\n\n");

            $efectivo = model('facturaFormaPagoModel')->selectSum('valor_pago')->where('id_factura', $id_factura)->find();
            $printer->setTextSize(1, 1);
            $id_forma_pago = model('facturaFormaPagoModel')->id_forma_pago($id_factura);
            $temp_cambio = 0;
            foreach ($id_forma_pago as $forma_pago) {
                $id_forma_pago = model('facturaFormaPagoModel')->id_forma_pago($id_factura);
                $nombre_forma_pago = model('facturaFormaPagoModel')->nombre_forma_pago($forma_pago['idforma_pago']);
                $valor_forma_pago = model('facturaFormaPagoModel')->valor_forma_pago($forma_pago['idforma_pago'], $id_factura);

                if ($valor_forma_pago[0]['valor_pago'] > 0) {
                    $printer->text($nombre_forma_pago[0]['nombreforma_pago'] . ":  $" . number_format($valor_forma_pago[0]['valor_pago'], 0, ",", ".") . "\n");
                }
            }
            if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 7) {
                $printer->text("CAMBIO: " . "$" . number_format($efectivo[0]['valor_pago'] - (($total[0]['total'] - $descuento['descuento']) + $propina['propina']), 0, ",", ".") . "\n");
                $printer->text("-----------------------------------------------" . "\n");
            }


            $regimen = model('empresaModel')->select('idregimen')->first();

            if ($regimen['idregimen'] == 1) {
                if ($estado_factura[0]['idestado'] == 1 or $estado_factura[0]['idestado'] == 2) {
                    $tarifa_iva = model('productoFacturaVentaModel')->tarifa_iva($id_factura);
                    if (!empty($tarifa_iva)) {
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->setTextSize(1, 1);
                        $printer->text("**DISCRIMINACION TARIFAS DE IVA** \n");
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                        $printer->text("TARIFA    VENTA       BASE/IMP         IVA" . "\n");
                        foreach ($tarifa_iva as $iva) {
                            $datos_iva = model('productoFacturaVentaModel')->base_iva($iva['valor_iva'], $id_factura);
                            if (!empty($datos_iva)) {
                                $printer->text($iva['valor_iva'] . "%" . "          " . "$" . number_format($datos_iva[0]['compra'], 0, ",", ".") . "   " . "$" . number_format($datos_iva[0]['base'] * $datos_iva[0]['cantidadproducto_factura_venta'], 0, ",", ".") . "    " . "$" . number_format($datos_iva[0]['compra'] - ($datos_iva[0]['base'] * $datos_iva[0]['cantidadproducto_factura_venta']), 0, ",", ".") . "\n");
                            }
                        }
                    }

                    $tarifa_ico = model('productoFacturaVentaModel')->tarifa_ico($id_factura);



                    if (!empty($tarifa_ico)) {
                        $printer->text("\n");
                        $printer->setJustification(Printer::JUSTIFY_CENTER);
                        $printer->setTextSize(1, 1);
                        $printer->text("**DISCRIMINACION TARIFAS DE IPO CONSUMO** \n");
                        $printer->setJustification(Printer::JUSTIFY_LEFT);
                        $printer->text("TARIFA   BASE/IMP        INC     TOTAL" . "\n");


                        foreach ($tarifa_ico as $ico) {
                            //  $printer->text($iva['valor_iva']."%". "\n");


                            $total_compra = model('productoFacturaVentaModel')->total_compra($ico['valor_ico'], $id_factura);

                            $base_ico = model('productoFacturaVentaModel')->base_ico($ico['valor_ico'], $id_factura);

                            if ($total_compra[0]['compra'] >= 100000) {
                                $printer->text($ico['valor_ico'] . "%      " .  "$" . number_format(($total_compra[0]['compra'] - ($base_ico[0]['base']) - $impuesto_saludable[0]['total_impuesto_saludable']), 0, ",", ".") . "        " . "$" . number_format($base_ico[0]['base'], 0, ",", ".") . "       $" . number_format($total_compra[0]['compra'], 0, ",", ".") . "\n");
                            }
                            if ($total_compra[0]['compra'] < 100000) {
                                $printer->text($ico['valor_ico'] . "%" . "       " . "$ " . number_format($total_compra[0]['compra'] - ($base_ico[0]['base']), 0, ",", ".") . "      " . "   $" . number_format($base_ico[0]['base'], 0, ",", ".") . "    $" . number_format($total_compra[0]['compra'], 0, ",", ".") . "\n");
                            }
                        }
                    }


                    // if ($estado_factura[0]['descripcionestado'] == 1 or $estado_factura[0]['descripcionestado'] == 2) {
                    $id_registro_dian = model('consecutivosModel')->select('numeroconsecutivo')->Where('idconsecutivos', 6)->first();


                    // $prefijo_factura = model('consecutivosModel')->select('numeroconsecutivo')->where('conceptoconsecutivo =', 'FacturaPrefijo')->first();
                    $prefijo_factura = model('dianModel')->select('inicialestatica')->where('iddian ', $id_registro_dian['numeroconsecutivo'])->first();

                    $id_resolucion_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('conceptoconsecutivo =', 'IdRegistroDian')->first();

                    $factura_prefijo = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', $id_resolucion_dian['numeroconsecutivo'])->first();

                    $fecha_dian = model('dianModel')->select('fechadian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                    $rango_inicial = model('dianModel')->select('rangoinicialdian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                    $rango_final = model('dianModel')->select('rangofinaldian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                    $texto_inicial = model('dianModel')->select('texto_inicial')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                    $texto_final = model('dianModel')->select('texto_final')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();

                    $numero_resolucion_dian = model('dianModel')->select('numeroresoluciondian')->where('iddian', $id_resolucion_dian['numeroconsecutivo'])->first();
                    $printer->text("\n");
                    $printer->setJustification(Printer::JUSTIFY_LEFT);
                    $printer->setTextSize(1, 1);
                    $printer->text($texto_inicial['texto_inicial'] . $numero_resolucion_dian['numeroresoluciondian'] . " de" . " " . $fecha_dian['fechadian'] . "\n");
                    $printer->text($texto_final['texto_final'] . " Del " . $rango_inicial['rangoinicialdian'] . " al " . " "  . $rango_final['rangofinaldian'] . " " . "Prefijo " . $prefijo_factura['inicialestatica'] . "\n\n");
                }
            }

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->setTextSize(1, 1);
            $fk_usuario_mesero = model('facturaVentaModel')->select('fk_usuario_mesero')->where('id', $id_factura)->first();
            $nombreusuario_sistema = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $fk_usuario_mesero['fk_usuario_mesero'])->first();
            $printer->text("ATENDIDO POR:" . $nombreusuario_sistema['nombresusuario_sistema'] . "\n");

            $observaciones_genereles = model('facturaVentaModel')->select('observaciones_generales')->where('id', $id_factura)->first();
            $fk_mesa = model('facturaVentaModel')->select('fk_mesa')->where('id', $id_factura)->first();
            $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $fk_mesa['fk_mesa'])->first();
            if (!empty($nombre_mesa['nombre'])) {
                $printer->text("MESA:" . $nombre_mesa['nombre'] . "\n");
            }
            if (empty($nombre_mesa['nombre'])) {
                $printer->text("MESA: VENTAS DE MOSTRADOR" . "\n");
            }

            if (!empty($observaciones_genereles['observaciones_generales'])) {
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->setTextSize(1, 2);
                $printer->text("OBSERVACIONES GENERALES\n");
                $printer->setJustification(Printer::JUSTIFY_LEFT);
                $printer->setTextSize(1, 1);
                $printer->text($observaciones_genereles['observaciones_generales'] . "\n");
            }

            $printer->text("-----------------------------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(1, 1);
            $printer->text("IMPRESO POR SOFTWARE DFPYME INTREDETE" . "\n");
            $printer->text("NIT: 901448365-5" . "\n");

            $printer->text("-----------------------------------------------" . "\n");
            $printer->text("GRACIAS POR SU VISITA " . "\n");

            $printer->feed(1);
            $printer->cut();
            //$printer->pulse();
            $printer->close();

            $returnData = array(
                "resultado" => 1, //Falta plata 
                "tabla" => view('factura_pos/tabla_reset_factura')
            );
            echo  json_encode($returnData);
        }
    }

    function imprimir_comprobnate_transferencia($id_factura, $transferencia, $efectivo, $total)
    {

        $id_impresora = model('cajaModel')->select('id_impresora')->first();
        $nombre_impresora = model('impresorasModel')->select('nombre')->where('id', $id_impresora['id_impresora'])->first();

        $connector = new WindowsPrintConnector($nombre_impresora['nombre']);

        $datos_empresa = model('empresaModel')->datosEmpresa();
        $id_impresora = model('cajaModel')->select('id_impresora')->first();

        $id_factura = $id_factura;

        $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();

        $fecha_factura_venta = model('facturaVentaModel')->select('fecha_factura_venta')->where('id', $id_factura)->first();
        $hora_factura_venta = model('facturaVentaModel')->select('horafactura_venta')->where('id', $id_factura)->first();
        $id_usuario = model('facturaVentaModel')->select('idusuario_sistema')->where('id', $id_factura)->first();

        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(1, 1);
        $printer->text("SOPORTE TRANSFERENCIA\n");
        $printer->text($datos_empresa[0]['nombrecomercialempresa'] . "\n");
        //$printer->text($datos_empresa[0]['representantelegalempresa'] . "\n");
        $printer->text("NIT :" . $datos_empresa[0]['nitempresa'] . "\n");

        $printer->text("\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->setTextSize(1, 1);
        $printer->text("FACTURA DE VENTA:" . $numero_factura['numerofactura_venta'] . "\n");
        $printer->text("FECHA:" . " " . $fecha_factura_venta['fecha_factura_venta'] . "  " . $hora_factura_venta['horafactura_venta'] . "\n");

        $printer->text("TOTAL :" . "$" . number_format($total, 0, ",", ".") . "\n\n");
        $efectivo = "";
        if (!empty($movimientos_efectivo[0]['valor_pago'])) {
            //$printer->text("EFECTIVO :" . "$" . number_format($movimientos_efectivo[0]['valorfactura_forma_pago'], 0, ",", ".") . "\n");
            $efectivo = $movimientos_efectivo[0]['valor_pago'];
        }
        if (empty($movimientos_efectivo[0]['valor_pago'])) {
            //$printer->text("EFECTIVO :" . "$" . number_format($movimientos_efectivo[0]['valorfactura_forma_pago'], 0, ",", ".") . "\n");
            $efectivo = 0;
        }
        $printer->setTextSize(1, 1);
        $printer->text("Pago efectivo  :" . "$" . number_format($efectivo, 0, ",", ".") . "\n");
        $printer->text("Pago transferencia :" . "$" . number_format($transferencia, 0, ",", ".") . "\n");
        $printer->text("Cambio :" . "$" . number_format(($transferencia + $efectivo) - $total, 0, ",", ".") . "\n\n\n");

        $printer->text("Nota:____________________________________" . "\n\n");
        $printer->setTextSize(1, 1);
        $printer->text("Nombre:_________________________________ \n\n");
        $printer->text("Identificación:__________________________ \n\n");
        $printer->text("Teléfono:________________________________\n\n");


        $printer->feed(1);
        $printer->cut();
        $printer->pulse();
        $printer->close();
    }
}
