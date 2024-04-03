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
}
