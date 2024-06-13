<?php

namespace App\Controllers\reportes;

use App\Controllers\BaseController;
use App\Libraries\data_table;
use App\Libraries\tipo_consulta;

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

        $sql_data .= " ORDER BY " . $table_map[$_GET['order'][0]['column']] . " " . $_GET['order'][0]['dir'] . " " . "LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];

        $datos = $this->db->query($sql_data)->getResultArray();
        $data = [];

        foreach ($datos as $detalle) {
            $sub_array = array();

            $costo = model('kardexModel')->selectSum('costo')->where('id_factura', $detalle['id_factura'])->findAll();
            $iva = model('kardexModel')->selectSum('iva')->where('id_factura', $detalle['id_factura'])->findAll();
            $inc = model('kardexModel')->selectSum('ico')->where('id_factura', $detalle['id_factura'])->findAll();

            if ($detalle['id_factura'] == 8) {
                $temp_documento = model('facturaElectronicaModel')->select('numero')->where('id', $detalle['id_factura'])->first();
                $documento = $temp_documento['numero'];
            }

            if($detalle['id_factura'] != 8){
                $documento=$detalle['documento'];
            }

            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first();
            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] =  $nombre_cliente['nombrescliente'];
            // $sub_array[] = $detalle['documento'];
            $sub_array[] = $documento;
            $tipo_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $detalle['id_estado'])->first();

            $sub_array[] = $tipo_documento['descripcionestado'];
            $sub_array[] = number_format($detalle['total_documento'] - ($iva[0]['iva'] + $inc[0]['ico']), 0, ",", ".");
            $sub_array[] = "$ " . number_format($iva[0]['iva'], 0, ",", ".");
            // $sub_array[] = number_format($detalle['total_documento'] - ($iva[0]['iva'] + $inc[0]['ico']), 0, ",", ".");
            //$sub_array[] = number_format($iva[0]['iva'], 0, ",", ".");
            $sub_array[] = number_format($inc[0]['ico'], 0, ",", ".");
            $sub_array[] = number_format($detalle['total_documento'], 0, ",", ".");


            $data[] = $sub_array;
        }
        $total_venta = model('pagosModel')->selectSum('valor')->where('id_apertura', $apertura)->findAll();
        /*  $total_venta_iva_5 = model('kardexModel')->total_venta_iva_5($apertura);  //Total de la venta con impuestos 
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
        } */

        $iva = model('kardexModel')->get_iva_reportes($apertura);
        $inc = model('kardexModel')->get_inc_reportes($apertura);



        $costo = model('pagosModel')->total_costo($apertura);
        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
            'total_venta' => "$ " . number_format($total_venta[0]['valor'], 0, ",", "."),
            'impuestos' => view('impuestos/impuestos', [
                'iva' => $iva,
                'inc' => $inc,
                'apertura' => $apertura
            ])
            /* 'base_iva_19' => number_format($base_iva_019, 0, ",", "."),
            'iva_19' => 0,
            'base_iva_5' => number_format($base_iva_5, 0, ",", "."),
            'iva_5' => number_format($iva_5, 0, ",", "."),
            'inc' => number_format($venta_inc[0]['inc'], 0, ",", "."),
            'base_inc' => number_format($total_venta_inc[0]['total'] - $venta_inc[0]['inc'], 0, ",", "."),
            'costo' => number_format($costo[0]['costo'], 0, ",", ".") */
        ];

        echo  json_encode($json_data);
    }

    /*   function sendDian() {
        $id_factura = $this->request->getPost('id_factura');

        //

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.dataico.com/direct/dataico_api/v2/invoices/018f4647-c964-8371-a675-b1f5857912f2',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>'{
            "send_dian": true,
            "send_email": true,
            "email": "fe.puntodeventa@cafedecolombia.com"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'auth-token: 128495aa9e987e5b8d4d55cf6aa256f6'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    } */
    function sendDian()
    {
        $id_factura = $this->request->getPost('id_factura');
        //$id_factura = 951;

        $nit_cliente = model('facturaElectronicaModel')->select('nit_cliente')->where('id', $id_factura)->first();

        $email = model('clientesModel')->select('emailcliente')->where('nitcliente', $nit_cliente['nit_cliente'])->first();
        $transaccion_id = model('facturaElectronicaModel')->select('transaccion_id')->where('id', $id_factura)->first();

        $auto_token = model('credencialesWebServerModel')->select('auth_token')->first();

        $request_body = array(
            "send_dian" => true,
            "send_email" => true,
            "email" => $email['emailcliente']
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.dataico.com/direct/dataico_api/v2/invoices/' . $transaccion_id['transaccion_id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($request_body),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'auth-token: ' . $auto_token['auth_token']
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }




    function retrasmistir()
    {
        $id_factura = $this->request->getPost('id_factura');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.dataico.com/direct/dataico_api/v2/invoices/018f4647-c964-8371-a675-b1f5857912f2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "auth-token: 128495aa9e987e5b8d4d55cf6aa256f6"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    function estado_dian()
    {
        $valor_buscado = $_GET['search']['value'];
        $estado_dian = $this->request->getGet('estado_dian');
        //$estado_dian = 1;

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
                        COUNT(id) AS total
                        FROM
                        documento_electronico where id_status= $estado_dian";

        $sql_data = "SELECT documento_electronico.id,
        fecha,
        nit_cliente,
        cliente.nombrescliente,
        numero AS documento,
        neto AS total_documento
        FROM documento_electronico
        INNER JOIN cliente ON documento_electronico.nit_cliente = cliente.nitcliente
        WHERE id_status= $estado_dian";



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

        $sql_data .= " ORDER BY " . $table_map[$_GET['order'][0]['column']] . " " . $_GET['order'][0]['dir'] . " " . "LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];

        $datos = $this->db->query($sql_data)->getResultArray();

        $data = [];

        $accion = new data_table();



        foreach ($datos as $detalle) {
            $sub_array = array();

            /*         $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first();
            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] =  $nombre_cliente['nombrescliente'];

            if ($detalle['id_estado'] == 8) {
                $documento = model('facturaElectronicaModel')->select('numero')->where('id', $detalle['id_factura'])->first();
                $numero_documento = $documento['numero'];
            }

            if ($detalle['id_estado'] != 8) {
                $numero_documento = $detalle['documento'];
            }
            $sub_array[] = $numero_documento;
            $sub_array[] = "$ " . number_format($detalle['total_documento'], 0, ",", ".");
            $tipo_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $detalle['id_estado'])->first();

            $sub_array[] = $tipo_documento['descripcionestado'];
 */

            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] = $detalle['nombrescliente'];
            $sub_array[] = $detalle['documento'];
            $sub_array[] = number_format($detalle['total_documento'], 0, ",", ".");

            $sub_array[] = "FACTURA ELECTRONICA";
            $acciones = $accion->row_data_table(8, $detalle['id']);

            $sub_array[] = $acciones;


            $data[] = $sub_array;
        }




        //$total_ventas = model('pagosModel')->total_venta($id_apertura[0]['id']);

        /*   $dian_aceptado = model('facturaElectronicaModel')->dian_ceptado($id_apertura[0]['id']);
        $dian_no_enviado = model('facturaElectronicaModel')->dian_no_enviado($id_apertura[0]['id']);
        $dian_rechazado = model('facturaElectronicaModel')->dian_rechazado($id_apertura[0]['id']);
        $dian_error = model('facturaElectronicaModel')->dian_error($id_apertura[0]['id']); */

        $total_venta = model('facturaElectronicaModel')->selectSum('neto')->where('id_status', $estado_dian)->findAll();


        $dian_aceptado = model('facturaElectronicaModel')->selectCount('id')->where('id_status', 2)->findAll();
        $dian_no_enviado = model('facturaElectronicaModel')->selectCount('id')->where('id_status', 1)->findAll();
        $dian_rechazado = model('facturaElectronicaModel')->selectCount('id')->where('id_status', 3)->findAll();
        $dian_error = model('facturaElectronicaModel')->selectCount('id')->where('id_status', 4)->findAll();

        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
            'total' => "$ " . number_format($total_venta[0]['neto'], 0, ",", "."),
            'dian_aceptado' => $dian_aceptado[0]['id'],
            'dian_no_enviado' => $dian_no_enviado[0]['id'],
            'dian_rechazado' => $dian_rechazado[0]['id'],
            'dian_error' => $dian_error[0]['id'],

        ];

        echo  json_encode($json_data);
    }

    function actualizar_pagos()
    {

        $efectivo = $this->request->getPost('efectivo_factura');
        $transferencia = $this->request->getPost('transferencia_factura');

        $efectivo = str_replace('.', '', $efectivo);
        $transferencia = str_replace('.', '', $transferencia);

        $id = $this->request->getPost('id');

        $pagos = [
            'efectivo' => $efectivo,
            'transferencia' => $transferencia,
            'total_pago' => $efectivo + $transferencia,
            'recibido_efectivo' => $efectivo,
            'recibido_transferencia' => $transferencia,
        ];
        $pagos = model('pagosModel')->set($pagos)->where('id', $id)->update();

        if ($pagos) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('consultas_y_reportes/consultas_caja'))->with('mensaje', 'Actualización correcta ');
        }
    }

    function datos_pagos()
    {
        $id = $this->request->getPost('id');
        $pagos = model('pagosModel')->pagos($id);

        $returnData = array(
            "resultado" => 1,
            "efectivo" => number_format($pagos[0]['efectivo'], 0, ",", "."),
            "transferencia" => number_format($pagos[0]['transferencia'], 0, ",", "."),
            "id" => $id,

        );
        echo  json_encode($returnData);
    }

    function ver_productos_eliminanados(){
        $productos_eliminados=model('productoModel')->get_productos_borrados();

        $returnData = array(
            "resultado" => 1, //Falta plata  
            "productos" => view('producto/eliminados',[
                'productos'=>$productos_eliminados
            ]), //Falta plata  
        );
        echo  json_encode($returnData);

    }
}