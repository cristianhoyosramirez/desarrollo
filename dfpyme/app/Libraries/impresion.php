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


        $id_apertura = $id_apertura;


        //$id_apertura = 1053;

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


        $printer->text("Ventas pos: " . "            $ " . number_format($ventas_pos[0]['valor'], 0, ",", ".") . "\n");
        $printer->text("Valor electrónicas: "  .  "    $ " . number_format($ventas_electronicas[0]['valor'], 0, ",", ".") . "\n");

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

        $printer->text("Ingresos+apertura " . "      $ " . number_format($ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'] , 0, ",", ".") . "\n");

        $printer->text("(-) Total retiros: " . "     $ " . number_format($total_retiros, 0, ",", ".") . "\n");
        $printer->text("(-) Total devoluciones:" . " $ " . number_format($total_devoluciones, 0, ",", ".") . "\n");

        $temp = $ingresos_efectivo[0]['efectivo'] + $valor_apertura['valor'] ;
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
        $printer->text("Diferencia efectivo  " . "   $ " . number_format(($total_en_caja ) - $cierre_usuario, 0, ",", ".") . "\n");
        $printer->text("Diferencia transaccion  " . "$ " . number_format($transaccion - $valor_cierre_transaccion_usuario, 0, ",", ".") . "\n");

        $printer->text("\n");

        $printer->text("TOTAL DIFERENCIAS  " . "     $ " . number_format((($total_en_caja ) - $cierre_usuario) + ($transaccion - $valor_cierre_transaccion_usuario), 0, ",", ".") . "\n");

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
        /*  $path = 'images/';                                              
        $qrcode = $path .  12 . ".png";
        QRcode::png($qrtext, $qrcode, 'H', 10, 10); */



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



        /*  $printer->text("_______________________________________________ \n");
        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $printer->text("SUB TOTAL:" .   "$ " . number_format($sub_total, 0, ",", ".") . "\n");
        $printer->text("INC:"    .     "$ " . number_format($inc[0]['total_inc'], 0, ",", ".") . "\n");
        $printer->text("IVA :"    .     "$ " . number_format($iva[0]['total_iva'], 0, ",", ".") . "\n");
        $printer->text("DESCUENTO:      $ 0\n");
        $printer->text("PROPINA:        $ 0\n"); */


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

        /*       if ($efectivo['recibido_efectivo'] > 0) {
            $printer->text("Pago efectivo:" . "$ " . number_format($efectivo['recibido_efectivo'], 0, ",", ".")  . "\n");
        }
        if ($transferencia['recibido_transferencia'] > 0) {
            $printer->text("Pago transferencia:" . "$ " . number_format($transferencia['recibido_transferencia'], 0, ",", ".") . "\n");
        }

        $cambio = model('pagosModel')->select('cambio')->where('id_factura', $id_factura)->first();

        $printer->text("Cambio:" . $cambio['cambio'] . "\n"); */





        $printer->text(str_pad("PAGO EFECTIVO:", 40, " ")  . number_format($efectivo['recibido_efectivo'], 0, ",", ".") . "\n");

        if ($transferencia['recibido_transferencia'] > 0) {
            $printer->text(str_pad("PAGO TRANSFERENCIA :", 40, " ") . "$ " . number_format($transferencia['recibido_transferencia'], 0, ",", ".") . "\n");
        }

        $cambio = model('pagosModel')->select('cambio')->where('id_factura', $id_factura)->first();

        $printer->text(str_pad("CAMBIO:", 40, " ") . $cambio['cambio'] . "\n");

        /*$printer->text("_______________________________________________ \n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
         $printer->text("ACTIVIDAD ECONÓMICA 1063;4719 \n");
        $printer->text("NO CONTRIBUYENTES DE RENTA  \n");
        $printer->text("NO SUJETO A RETENCIÓN  \n");
        $printer->text("GRAN CONTRIBUYENTE  \n");
        $printer->text("AGENTE RETENEDOR IVA \n");
          $printer->text("DOMICILIO PRINCIPAL: CALLE 73 NO. 8 - 13  \n");
        $printer->text("BOGOTÁ - COLOMBIA. \n"); */
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


}
