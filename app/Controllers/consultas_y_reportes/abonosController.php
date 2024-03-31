<?php

namespace App\Controllers\consultas_y_reportes;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

use \DateTime;
use \DateTimeZone;


class AbonosController extends BaseController
{
    public function saldo_factura()
    {

        $id_factura = $this->request->getPost('id_factura');
        //$tipo_factura = model('pagosModel')->select('id_estado')->where('id', $id_factura)->first();
        $saldo = model('pagosModel')->select('saldo')->where('id_factura', $id_factura)->first();
        $valor = model('pagosModel')->select('valor')->where('id_factura', $id_factura)->first();
        $documento = model('pagosModel')->select('documento')->where('id_factura', $id_factura)->first();

        $returnData = array(
            "saldo" => number_format($saldo['saldo'], 0, ",", "."),
            "valor_factura" => number_format($valor['valor'], 0, ",", "."),
            "numero_factura" => $documento['documento'],
            "id_factura" => $id_factura,
            "resultado" => 1,
        );
        echo  json_encode($returnData);
    }
    /*   public function saldo_factura()
    {
    
        $id_factura = $this->request->getPost('id_factura');
        $tipo_factura = model('facturaVentaModel')->select('idestado')->where('id', $id_factura)->first();

        if ($tipo_factura['idestado'] == 2 or  $tipo_factura['idestado'] == 6) {

            $saldo = model('facturaVentaModel')->select('saldo')->where('id', $id_factura)->first();
            $valor_factura = model('facturaVentaModel')->select('valor_factura')->where('id', $id_factura)->first();
            $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();

            if ($saldo['saldo'] > 0) {

                $returnData = array(
                    "saldo" => number_format($saldo['saldo'], 0, ",", "."),
                    "valor_factura" => number_format($valor_factura['valor_factura'], 0, ",", "."),
                    "numero_factura" => $numero_factura['numerofactura_venta'],
                    "id_factura" => $id_factura,
                    "resultado" => 1,
                );
                echo  json_encode($returnData);
            } else if ($saldo['saldo'] == 0) {
                $returnData = array(
                    "resultado" => 1
                );
                echo  json_encode($returnData);
            }
        }

        if ($tipo_factura['idestado'] == 1 or  $tipo_factura['idestado'] == 7) {
            $returnData = array(
                "resultado" => 1
            );
            echo  json_encode($returnData);
        }
    } */


    function actualizar_saldo()
    {

        $efectivo = $this->request->getPost('efectivo');
        $transaccion = $this->request->getPost('transaccion');
         $id_factura = $this->request->getPost('id_factura'); 
        $abono = $this->request->getPost('abono');
        // $saldo = $this->request->getPost('saldo');
        $saldo = model('pagosModel')->select('saldo')->where('id_factura', $id_factura)->first();
        
        $id_usuario = $this->request->getPost('id_usuario');


        $resultado = $efectivo + $transaccion;

        $saldo_actualizado = $saldo['saldo'] - $abono;

        $data = [
            'saldo' => $saldo_actualizado,
        ];
        $model = model('pagosModel');
        $actualizar = $model->set($data);
        $actualizar = $model->where('id_factura', $id_factura);
        $actualizar = $model->update();


        // $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $id_factura)->first();
        $numero_factura = model('pagosModel')->select('documento')->where('id_factura', $id_factura)->first();

        if ($actualizar) {

            $fecha = DateTime::createFromFormat('U.u', microtime(TRUE));
            $fecha->setTimeZone(new DateTimeZone('America/Bogota'));
            $fecha_y_hora = $fecha->format('Y-m-d H:i:s.u');

            $factura_forma_pago_efectivo = [

                'numerofactura_venta' => $numero_factura['documento'],
                'idusuario' => $id_usuario,
                'idcaja' => 1,
                'idforma_pago' => 1,
                'fechafactura_forma_pago' => date('Y-m-d'),
                'hora' => date("H:i:s"),
                'valorfactura_forma_pago' => $efectivo,
                'idturno' => 1,
                'valor_pago' => $efectivo,
                'id_factura' => $id_factura,
                'fecha_y_hora_forma_pago' => $fecha_y_hora
            ];

            $factura_forma_pago_transaccion = [
                'numerofactura_venta' => $numero_factura['documento'],
                'idusuario' => $id_usuario,
                'idcaja' => 1,
                'idforma_pago' => 4,
                'fechafactura_forma_pago' => date('Y-m-d'),
                'hora' => date("H:i:s"),
                'valorfactura_forma_pago' => $transaccion,
                'idturno' => 1,
                'valor_pago' => $transaccion,
                'id_factura' => $id_factura,
                'fecha_y_hora_forma_pago' => $fecha_y_hora
            ];



            if ($efectivo > 0) {

                $insert_efectivo = model('facturaFormaPagoModel')->insert($factura_forma_pago_efectivo);

                $consecutivo_ingreso = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', 32)->first();

                $nit_cliente = model('facturaVentaModel')->select('nitcliente')->where('id', $id_factura)->first();

                $ingreso = [
                    'numero' => $consecutivo_ingreso['numeroconsecutivo'],
                    'concepto' => 'ABONO A FACTURA NUMERO ' . $numero_factura['documento'],
                    'tipo' => 1,
                    'id_relacion' => 0,
                    'fecha' => date('Y-m-d'),
                    'valor' => $abono,
                    'estado' => 'TRUE',
                    'saldo' => $saldo_actualizado,
                    'nitcliente' => $nit_cliente['nitcliente'],
                    'idcaja' => 1,
                    'idusuario' => $id_usuario

                ];

                $insert_ingreso = model('ingresoModel')->insert($ingreso);
                $id_ingreso = model('ingresoModel')->where('idusuario', $id_usuario)->insertID;
                $ingreso_efectivo = [
                    'idingreso' => $id_ingreso,
                    'idformapago' => 1,
                    'valor' => $efectivo,
                ];


                $insertar_forma_pago = model('ingresoFormaPagoModel')->insert($ingreso_efectivo);

                $data = [
                    'numeroconsecutivo' => $consecutivo_ingreso['numeroconsecutivo'] + 1,
                ];
                $model = model('consecutivosModel');
                $actualizar = $model->set($data);
                $actualizar = $model->where('idconsecutivos', 32);
                $actualizar = $model->update();


                $returnData = array(

                    "resultado" => 1,
                    "id_ingreso" => $id_ingreso
                );
                echo  json_encode($returnData);
            }

            if ($transaccion > 0) {

                $insert_transaccion = model('facturaFormaPagoModel')->insert($factura_forma_pago_transaccion);

                $returnData = array(

                    "resultado" => 1
                );
                echo  json_encode($returnData);
            }


            if ($transaccion > 0 and $efectivo > 0) {
                $insert_efectivo = model('facturaFormaPagoModel')->insert($factura_forma_pago_efectivo);
                $insert_transaccion = model('facturaFormaPagoModel')->insert($factura_forma_pago_transaccion);
                $returnData = array(

                    "resultado" => 1
                );
                echo  json_encode($returnData);
            }
        }
    }


    function imprimir_ingreso()
    {
        $id_ingreso = $_REQUEST['id_ingreso'];
        $datos_empresa = model('empresaModel')->datosEmpresa();
        $connector = new WindowsPrintConnector('FACTURACION');
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
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("FECHA:" . date('Y-m-d') . "\n");
        $id_usuario = model('ingresoModel')->select('idusuario')->where('id', $id_ingreso)->first();
        $nombre_usuario = model('usuariosModel')->select('nombresusuario_sistema')->where('idusuario_sistema', $id_usuario)->first();
        $printer->text("CAJERO(A):" . $nombre_usuario['nombresusuario_sistema'] . "\n");
        $numero_ingreso = model('ingresoModel')->select('numero')->where('id', $id_ingreso)->first();
        $printer->text("COMPROBANTE DE INGRESO N°" . $numero_ingreso['numero'] . "\n");
        $printer->text("--------------------------------------------\n");
        $printer->text("\n");
        $nit_tercero = model('ingresoModel')->select('nitcliente')->where('id', $id_ingreso)->first();
        $nombre_tercero = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_tercero['nitcliente'])->first();
        $printer->text("RECIBIDO DE :" . $nombre_tercero['nombrescliente'] . "\n");
        $printer->text("NIT O CC :" . number_format($nit_tercero['nitcliente'], 0, ",", ".") . "\n");

        $printer->text("\n");
        $printer->text("\n");
        $concepto_ingreso = model('ingresoModel')->select('concepto')->where('id', $id_ingreso)->first();
        $printer->text($concepto_ingreso['concepto'] . "\n");


        $printer->setJustification(Printer::JUSTIFY_RIGHT);
        $total = model('ingresoModel')->select('valor')->where('id', $id_ingreso)->first();
        $printer->text("TOTAL ABONO :     " . "$" . number_format($total['valor'], 0, ",", ".") . "\n");
        $efectivo = model('ingresoFormaPagoModel')->select('valor')->where('idingreso', $id_ingreso)->first();
        $printer->text("PAGO CON :  " . "$" . number_format($efectivo['valor'], 0, ",", ".") . "\n");
        $saldo = model('ingresoModel')->select('saldo')->where('id', $id_ingreso)->first();

        $printer->text("SALDO CARTERA:     " . "$" . number_format($saldo['saldo'], 0, ",", ".") . "\n");

        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("FIRMA      ----------------------------------- \n\n");
        $printer->text("C.C O NIT: ----------------------------------- \n\n");
        $printer->text("FECHA:     ----------------------------------- \n\n");

        $printer->feed(1);
        $printer->cut();

        $printer->close();
    }
}
