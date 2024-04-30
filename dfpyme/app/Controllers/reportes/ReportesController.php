<?php

namespace App\Controllers\reportes;
use App\Controllers\BaseController;

class ReportesController extends BaseController
{
    public $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function data_table_ventas()
    {
        //$valor_buscado = $_GET['search']['value'];
        $id_apertura = model('aperturaModel')->selectMax('id')->findAll();
        $apertura = $id_apertura[0]['id'];

        $sql_count = '';
        $sql_data = '';

        $table_map = [
            0 => 'id',
            1 => 'fecha',
            2 => 'nit_cliente',
            3 => 'nombrescliente',
            4 => 'documento',
            5 => 'total_documento',

        ];

        $sql_count = "SELECT 
                            COUNT(pagos.id) AS total
                    FROM
                    pagos where id_apertura=$apertura";

        $sql_data = "SELECT
                    id,
                    fecha,
                    documento,
                    total_documento,
                    id_factura,
                    id_estado,
                    nit_cliente,
                    id_estado,
                    id_factura
                FROM
                    pagos where id_apertura=$apertura";

        $condition = "";

        if (!empty($valor_buscado)) {
            $condition .= " AND cliente.nitcliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR descripcionestado ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR cliente.nombrescliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR factura_venta.nitcliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR numerofactura_venta ILIKE '%" . $valor_buscado . "%'";
        }

        $sql_count .= $condition;
        $sql_data .= $condition;

        $total_count = $this->db->query($sql_count)->getRow();

        // $sql_data .= " ORDER BY " . $table_map[$_GET['order'][0]['column']] . " " . $_GET['order'][0]['dir'] . " " . "LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];

        $datos = $this->db->query($sql_data)->getResultArray();
        $data = [];

        foreach ($datos as $detalle) {
            $sub_array = array();

            $costo = model('kardexModel')->selectSum('costo')->where('id_factura', $detalle['id_factura'])->findAll();
            $iva = model('kardexModel')->selectSum('iva')->where('id_factura', $detalle['id_factura'])->findAll();
            $inc = model('kardexModel')->selectSum('ico')->where('id_factura', $detalle['id_factura'])->findAll();

            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first();
            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] =  $nombre_cliente['nombrescliente'];
            $sub_array[] = $detalle['documento'];
            $sub_array[] = "$ " . number_format($detalle['total_documento'], 0, ",", ".");
            $tipo_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $detalle['id_estado'])->first();

            $sub_array[] = $tipo_documento['descripcionestado'];
            $sub_array[] = "$ " . number_format($costo[0]['costo'], 0, ",", ".");
            $sub_array[] = number_format($detalle['total_documento'] - ($iva[0]['iva'] + $inc[0]['ico']), 0, ",", ".");
            $sub_array[] = number_format($iva[0]['iva'], 0, ",", ".");
            $sub_array[] = number_format($inc[0]['ico'], 0, ",", ".");


            $data[] = $sub_array;
        }
        $total_venta = model('pagosModel')->selectSum('total_documento')->where('id_apertura', $apertura)->findAll();
        $total_venta_iva_5 = model('kardexModel')->total_venta_iva_5($apertura);  //Total de la venta con impuestos 
        $venta_iva_5 = model('kardexModel')->venta_iva_5($apertura);  // Total del valor del iva 5 % 


        $base_iva_19 = model('kardexModel')->selectSum('iva')->where('valor_iva', 19)->findAll();
        $base_iva_5 = model('kardexModel')->selectSum('iva')->where('valor_iva', 5)->findAll();

        $total_venta_inc = model('kardexModel')->total_venta_inc($apertura);
        $venta_inc = model('kardexModel')->venta_inc($apertura);

        if (empty($base_iva_19[0]['iva'])) {
            $base_iva_019 = 0;
            $iva_19 = 0;
        }
        if (!empty($base_iva_19[0]['iva'])) {
            $base_iva_019 = $total_venta[0]['total_documento'] - $base_iva_19[0]['iva'];
        }

        if (empty($base_iva_5[0]['iva'])) {
            $base_iva_5 = 0;
            $iva_5 = 0;
        }
        if (!empty($base_iva_5[0]['iva'])) {
            //$base_iva_5 = $total_venta_iva_5[0]['total'] - $base_iva_5[0]['iva'];
            $base_iva_5 = $total_venta_iva_5[0]['total'] - $venta_iva_5[0]['iva'];
            $iva_5 = $venta_iva_5[0]['iva'];
        }


        $costo = model('pagosModel')->total_costo($apertura);
        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
            'total_venta' => number_format($total_venta[0]['total_documento'], 0, ",", "."),
            'base_iva_19' => number_format($base_iva_019, 0, ",", "."),
            'iva_19' => 0,
            'base_iva_5' => number_format($base_iva_5, 0, ",", "."),
            'iva_5' => number_format($iva_5, 0, ",", "."),
            'inc' => number_format($venta_inc[0]['inc'], 0, ",", "."),
            'base_inc' => number_format($total_venta_inc[0]['total'] - $venta_inc[0]['inc'], 0, ",", "."),
            'costo'=>number_format($costo[0]['costo'], 0, ",", ".")
        ];

        echo  json_encode($json_data);
    }
}