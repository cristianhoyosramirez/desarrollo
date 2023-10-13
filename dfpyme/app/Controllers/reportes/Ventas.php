<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;

class Ventas extends BaseController
{
    public function ventas()
    {
        $id_apertura = $this->request->getPost('id_apertura');
        //$id_apertura = 25;
        $movimientos = model('pagosModel')->where('id_apertura', $id_apertura)->orderBy('id', 'asc')->findAll();
        $ventas_pos = model('pagosModel')->set_ventas_pos($id_apertura);
        $ventas_electronicas = model('pagosModel')->set_ventas_electronicas($id_apertura);
        $propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $id_apertura)->findAll();
        $efectivo = model('pagosModel')->selectSum('recibido_efectivo')->where('id_apertura', $id_apertura)->findAll();
        $transferencia = model('pagosModel')->selectSum('recibido_transferencia')->where('id_apertura', $id_apertura)->findAll();
        $cambio = model('pagosModel')->selectSum('cambio')->where('id_apertura', $id_apertura)->findAll();

        $valor = model('pagosModel')->selectSum('valor')->where('id_apertura', $id_apertura)->findAll();
        $total_documento = model('pagosModel')->selectSum('total_documento')->where('id_apertura', $id_apertura)->findAll();

        $returnData = array(
            "movimientos" => view('reportes/ventas', [
                'movimientos' => $movimientos
            ]),
            "resultado" => 1,
            "ventas_pos" => "$" . number_format($ventas_pos[0]['valor'], 0, ",", "."),
            "ventas_electronicas" => "$" . number_format($ventas_electronicas[0]['valor'], 0, ",", "."),
            "propinas" => "$" . number_format($propinas[0]['propina'], 0, ",", "."),
            "efectivo" => "$" . number_format($efectivo[0]['recibido_efectivo'], 0, ",", "."),
            "transferencia" => "$" . number_format($transferencia[0]['recibido_transferencia'], 0, ",", "."),
            "total_ingresos" => "$" . number_format(($transferencia[0]['recibido_transferencia'] + $efectivo[0]['recibido_efectivo']) - $cambio[0]['cambio'], 0, ",", "."),
            "valor" => "$" . number_format($valor[0]['valor'], 0, ",", "."),
            "total_documento" => "$" . number_format($total_documento[0]['total_documento'], 0, ",", "."),
            "cambio" => "$" . number_format($cambio[0]['cambio'], 0, ",", ".")
        );
        echo  json_encode($returnData);
    }

    function consolidado_ventas()
    {

        $id_apertura = $this->request->getPost('id_apertura');

        $ventas_electronicas = model('pagosModel')->set_ventas_electronicas($id_apertura);
        $ventas_pos = model('pagosModel')->set_ventas_pos($id_apertura);


        $returnData = array(
            "resultado" => 1,
            "ventas_electronicas" => "$" . number_format($ventas_electronicas[0]['valor'], 0, ",", "."),
            "ventas_pos" => "$" . number_format($ventas_pos[0]['valor'], 0, ",", "."),
            "total" => " $" . number_format($ventas_pos[0]['valor'] + $ventas_electronicas[0]['valor'], 0, ",", ".")
        );
        echo  json_encode($returnData);
    }


    function retiros()
    {
        $id_apertura = $this->request->getPost('id_apertura');


        $retiros = model('retiroFormaPagoModel')->where('id_apertura', $id_apertura)->findAll();
        $total_retiros = model('retiroFormaPagoModel')->selectSum('valor')->where('id_apertura', $id_apertura)->findAll();

        $returnData = array(
            "resultado" => 1,
            "retiros" => view('consultas/retiros', [
                'retiros' => $retiros,
                'total_retiros' => $total_retiros[0]['valor']
            ])

        );
        echo  json_encode($returnData);
    }
    function devoluciones()
    {
        $id_apertura = $this->request->getPost('id_apertura');


        $devoluciones = model('detalleDevolucionVentaModel')->where('id_apertura', $id_apertura)->findAll();

        $total_devoluciones = model('detalleDevolucionVentaModel')->selectSum('valor_total_producto')->where('id_apertura', $id_apertura)->findAll();

        $returnData = array(
            "resultado" => 1,
            "devoluciones" => view('consultas/devoluciones', [
                'devoluciones' => $devoluciones,
                "total_devoluciones" => $total_devoluciones[0]['valor_total_producto']
            ]),


        );
        echo  json_encode($returnData);
    }
}
