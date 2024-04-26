<?php

namespace App\Controllers\configuracion;

use App\Controllers\BaseController;

class Configuracion extends BaseController
{

    public $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }
    public function mesero()
    {
        $configuracion_mesero = model('configuracionPedidoModel')->select('mesero_pedido')->first();

        return view('configuracion/meseros', [
            'requiere_mesero' => $configuracion_mesero['mesero_pedido']
        ]);
    }

    function actualizar_mesero()
    {
        $valor = $this->request->getPost('valor');

        $model = model('configuracionPedidoModel');
        $configuracion = $model->set('mesero_pedido', $valor);
        $configuracion = $model->update();

        if ($configuracion) {
            $returnData = array(
                "resultado" => 1,

            );
            echo  json_encode($returnData);
        }
    }

    function propina()
    {
        $porcentaje = model('configuracionPedidoModel')->select('valor_defecto_propina')->first();
        return view('configuracion/propina', [
            'porcetaje_propina' => $porcentaje['valor_defecto_propina']
        ]);
    }

    function configuracion_propina()
    {

        if (!$this->validate([
            'porcentaje' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Dato necesario',
                    'numeric' => 'Debe ser un registro numerico '

                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $valor = $this->request->getPost('propina');

        $model = model('configuracionPedidoModel');
        $configuracion = $model->set('propina', $valor);
        $configuracion = $model->set('valor_defecto_propina', $this->request->getPost('porcentaje'));
        $configuracion = $model->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('pedidos/mesas'))->with('mensaje', 'Configuración de propina correcta ');
    }

    function estacion_trabajo()
    {

        $cajas = model('cajaModel')->findAll();
        $impresoras = model('impresorasModel')->findAll();

        return view('configuracion/estacion_trabajo', [
            'cajas' => $cajas,
            'impresoras' => $impresoras
        ]);
    }

    function actualizar_caja()
    {
        $data = [
            'id_impresora' => $this->request->getPost('id_impresora')
        ];

        // $num_fact = model('pedidoModel');
        $caja =  model('cajaModel')->set($data)->where('idcaja', $this->request->getPost('id_caja'))->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('pedidos/mesas'))->with('mensaje', 'Asignación de impresora correcto  ');
    }

    function sub_categoria()
    {
        $subcategoria = model('configuracionPedidoModel')->select('sub_categoria')->first();
        return view('configuracion/subcategoria', [
            'sub_categoria' => $subcategoria['sub_categoria']
        ]);
    }

    /*   function actualizar_sub_categoria()
    {


        $valor = $this->request->getPost('valor');

        $model = model('configuracionPedidoModel');
        $configuracion = $model->set('sub_categoria', $valor);
        $configuracion = $model->update();

        if ($configuracion) {
            $returnData = array(
                "resultado" => 1,

            );
            echo  json_encode($returnData);
        }
    } */

    function crear_sub_categoria()
    {
        $sub_categorias = model('subCategoriaModel')->find();

        $categorias = model('categoriasModel')->where('permitir_categoria', 'true')->orderBy('nombrecategoria', 'asc')->findAll();

       

        $id_categorias = model('categoriasModel')->sub_categorias();

      

        return view('configuracion/sub_categoria', [
            'id_categorias' => $id_categorias,
            'categorias' => $categorias
        ]);
    }

    function editar_sub_categoria()
    {
        $id_categoria = $this->request->getPost('valor');

        $subcategoria = model('subCategoriaModel')->where('id', $id_categoria)->first();

        $categorias = model('categoriasModel')->where('permitir_categoria', 'true')->orderBy('nombrecategoria', 'asc')->findAll();


        $returnData = array(
            "resultado" => 1,
            "subcategoria" => view('configuracion/editar_sub_categoria', [
                'subcategoria' => $subcategoria,
                'categorias' => $categorias,
                'id_categoria' => $id_categoria
            ])

        );
        echo  json_encode($returnData);
    }


    function actualizar_sub_categoria()
    {
        $id_categoria = $this->request->getPost('valor');
        $categoria = $this->request->getPost('categoria');
        //$id_categoria = 'true';
        $nombre = $this->request->getPost('nombre');

        $model = model('subCategoriaModel');
        $actualizar = $model->set('nombre', $nombre);
        $actualizar = $model->set('id_categoria', $categoria);
        $actualizar = $model->where('id', $id_categoria);
        $actualizar = $model->update();


        $subcategoria = model('subCategoriaModel')->find();

        $returnData = array(
            "resultado" => 1,
            "subcategorias" => view('configuracion/lista_sub_categorias', [
                'sub_categorias' => $subcategoria
            ])

        );
        echo  json_encode($returnData);
    }
    function eliminar_sub_categoria()
    {
        $id_categoria = $this->request->getPost('valor');

        $model = model('subCategoriaModel');
        $actualizar = $model->where('id', $id_categoria);
        $actualizar = $model->delete();

        $subcategoria = model('subCategoriaModel')->find();

        $returnData = array(
            "resultado" => 1,
            "subcategorias" => view('configuracion/lista_sub_categorias', [
                'sub_categorias' => $subcategoria
            ])

        );
        echo  json_encode($returnData);
    }

    function actualizar_estado_sub_categoria()
    {

        $valor = $this->request->getPost('valor');

        $model = model('configuracionPedidoModel');
        $actualizar = $model->set('sub_categoria', $valor);
        $actualizar = $model->update();

        $subcategoria = model('subCategoriaModel')->find();

        $returnData = array(
            "resultado" => 1,
        );
        echo  json_encode($returnData);
    }

    function tipos_de_factura()
    {

        // $facturas=model('estadoModel')->find()->orderBy('orden','asc');
        $facturas = model('estadoModel')->orderBy('idestado', 'asc')->find();


        return view('tipos_de_factura/facturas', [
            'tipo_factura' => $facturas
        ]);
    }

    function actualizar_estado()
    {
        $id_estado = $this->request->getPost('id_estado');
        $descripcion = $this->request->getPost('descripcion');
        $estado = $this->request->getPost('estado');
        $orden = $this->request->getPost('orden');
        $consulta = $this->request->getPost('consulta');

        $data = [
            'descripcionestado' => $descripcion,
            'estado' => $estado,
            'orden' => $orden,
            'consulta'=>$consulta
        ];

        //var_dump($data);  exit();
        /*   $data = [
            'descripcionestado' => $descripcion,
            'estado' => $estado,
            'orden' => $orden
        ]; */


        $model = model('estadoModel')->set($data)->where('idestado', $id_estado)->update();


        if ($model) {
            $returnData = array(
                "resultado" => 1,
            );
            echo  json_encode($returnData);
        }
    }


    public function consulta_factura_electronica()
    {
        $valor_buscado = $_GET['search']['value'];
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

            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first();
            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] =  $nombre_cliente['nombrescliente'];
            $sub_array[] = $detalle['documento'];
            $sub_array[] = "$ " . number_format($detalle['total_documento'], 0, ",", ".");
            $tipo_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $detalle['id_estado'])->first();

            $sub_array[] = $tipo_documento['descripcionestado'];
            if ($detalle['id_estado'] == 8) {
                $pdf = model('facturaElectronicaModel')->select('transaccion_id')->where('id', $detalle['id_factura'])->first();

                if (empty($pdf['transaccion_id'])) {
                    $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Trasmitir " onclick="sendInvoice(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="17" y1="3" x2="17" y2="21" />
                                    <path d="M10 18l-3 3l-3 -3" />
                                    <line x1="7" y1="21" x2="7" y2="3" />
                                    <path d="M20 6l-3 -3l-3 3" />
                                </svg></a> 

            <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
            

        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $detalle['id_factura'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>';
                }
                if (!empty($pdf['transaccion_id'])) {

                    $pdf_url = model('facturaElectronicaModel')->select('pdf_url')->where('id', $detalle['id_factura'])->first();

                    $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Trasmitir " onclick="sendInvoice(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="17" y1="3" x2="17" y2="21" />
                                    <path d="M10 18l-3 3l-3 -3" />
                                    <line x1="7" y1="21" x2="7" y2="3" />
                                    <path d="M20 6l-3 -3l-3 3" />
                                </svg></a> 
            

            <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
            

        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $detalle['id_factura'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
        
        
<a href="' . $pdf_url['pdf_url'] . '" target="_blank" class="cursor-pointer">
    <img title="Descargar pdf" src="' . base_url() . '/Assets/img/pdf.png" width="40" height="40" />
</a>';
                }
            }
            if ($detalle['id_estado'] != 8) {

                $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_duplicado_factura(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>  
        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_de_factura(' . $detalle['id'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
        
         ';
            }
            $data[] = $sub_array;
        }

        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
        ];

        echo  json_encode($json_data);
    }


    public function consulta_document()
    {
        $valor_buscado = $_GET['search']['value'];
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

            $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first();
            $sub_array[] = $detalle['fecha'];
            $sub_array[] = $detalle['nit_cliente'];
            $sub_array[] =  $nombre_cliente['nombrescliente'];
            $sub_array[] = $detalle['documento'];
            $sub_array[] = "$ " . number_format($detalle['total_documento'], 0, ",", ".");
            $tipo_documento = model('estadoModel')->select('descripcionestado')->where('idestado', $detalle['id_estado'])->first();

            $sub_array[] = $tipo_documento['descripcionestado'];
            if ($detalle['id_estado'] == 8) {
                $pdf = model('facturaElectronicaModel')->select('transaccion_id')->where('id', $detalle['id_factura'])->first();

                if (empty($pdf['transaccion_id'])) {
                    $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Trasmitir " onclick="sendInvoice(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="17" y1="3" x2="17" y2="21" />
                                    <path d="M10 18l-3 3l-3 -3" />
                                    <line x1="7" y1="21" x2="7" y2="3" />
                                    <path d="M20 6l-3 -3l-3 3" />
                                </svg></a> 

            <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
            

        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $detalle['id_factura'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>';
                }
                if (!empty($pdf['transaccion_id'])) {

                    $pdf_url = model('facturaElectronicaModel')->select('pdf_url')->where('id', $detalle['id_factura'])->first();

                    $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Trasmitir " onclick="sendInvoice(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="17" y1="3" x2="17" y2="21" />
                                    <path d="M10 18l-3 3l-3 -3" />
                                    <line x1="7" y1="21" x2="7" y2="3" />
                                    <path d="M20 6l-3 -3l-3 3" />
                                </svg></a> 
            

            <a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_electronica(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>
            

        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_f_e(' . $detalle['id_factura'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
        
        
<a href="' . $pdf_url['pdf_url'] . '" target="_blank" class="cursor-pointer">
    <img title="Descargar pdf" src="' . base_url() . '/Assets/img/pdf.png" width="40" height="40" />
</a>';
                }
            }
            if ($detalle['id_estado'] != 8) {

                $sub_array[] = '<a  class="btn btn-outline-success btn-icon " title="Imprimir copia " onclick="imprimir_duplicado_factura(' . $detalle['id_factura'] . ')" >
            <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>  
        <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_de_factura(' . $detalle['id'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
        
         ';
            }
            $data[] = $sub_array;
        }

        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
        ];

        echo  json_encode($json_data);
    }

    function borrar_remisiones(){
        $remsiones=model('configuracionPedidoModel')->select('borrar_remisiones')->first();

        return view('configuracion/remisiones', [
            'remisiones'=>$remsiones['borrar_remisiones']
        ]);
    }

    function actualizar_remisiones(){
        
        $valor = $this->request->getPost('valor');

        if ($valor== 1){
            $permitir=true;
        }
        if ($valor== 0){
            $permitir=false;
        }

        $actualizar = model('configuracionPedidoModel')->set('borrar_remisiones',$permitir)->update();

        $returnData = array(
            
            "resultado" => 1
        );
        echo  json_encode($returnData);

    }
}
