<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;


class Inventarios extends BaseController
{

    public $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function ingreso()
    {
        return view('inventarios/ingreso');
    }

    function ingreso_inventario()
    {
        $codigo_producto = $this->request->getPost('id_producto');
        $cantidad = $this->request->getPost('cantidad_entrada');

        $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $codigo_producto)->first();

        $actualizar = model('inventarioModel')->set('cantidad_inventario', $cantidad_inventario['cantidad_inventario'] + $cantidad)->where('codigointernoproducto', $codigo_producto)->update();

        if ($actualizar) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('inventario/ingreso'))->with('mensaje', 'Ingreso de producto éxitoso');
        }
    }
    function salida_inventario()
    {
        $codigo_producto = $this->request->getPost('id_producto');
        $cantidad = $this->request->getPost('cantidad_entrada');

        $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $codigo_producto)->first();

        $actualizar = model('inventarioModel')->set('cantidad_inventario', $cantidad_inventario['cantidad_inventario'] - $cantidad)->where('codigointernoproducto', $codigo_producto)->update();

        if ($actualizar) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('inventario/ingreso'))->with('mensaje', 'Ingreso de producto éxitoso');
        }
    }


    public function salida()
    {
        return view('inventarios/salida');
    }


    function buscar()
    {
        $producto = $this->request->getPost('valor');


        $productos = model('inventarioModel')->producto($producto);

        $returnData = array(
            "resultado" => 1,
            'productos' => view('pedido/productos', [
                'productos' => $productos
            ])
        );
        echo  json_encode($returnData);
    }

    function  exportar_inventario()
    {

        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();

        $options->set(array('isRemoteEnable' => true));
        $dompdf->setOptions($options);

        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

        $productos = model('productoModel')->productos();
        $total_inventario = model('productoModel')->total_inventario();

        $dompdf->loadHtml(view('producto/pdf', [
            "nombre_comercial" => $datos_empresa[0]['nombrecomercialempresa'],
            "nombre_juridico" => $datos_empresa[0]['nombrejuridicoempresa'],
            "nit" => $datos_empresa[0]['nitempresa'],
            "nombre_regimen" => $regimen['nombreregimen'],
            "direccion" => $datos_empresa[0]['direccionempresa'],
            "nombre_ciudad" => $nombre_ciudad['nombreciudad'],
            "nombre_departamento" => $nombre_departamento['nombredepartamento'],
            "productos" => $productos,
            "total_inventario" => "$" . number_format($total_inventario[0]['total_inventario'], 0, ',', '.')

        ]));

        $options = $dompdf->getOptions();
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream("Reporte de producto.pdf", array("Attachment" => true));
    }

    function productos_borrados()
    {
        $id_pedido = $this->request->getPost('id_pedido');

        $productos = model('productosBorradosModel')->get_productos_borrados($id_pedido);

        $returnData = array(
            "resultado" => 1,
            "productos" => view('consultas/detalle_productos_borrados', [
                'productos' => $productos
            ]),

        );
        echo  json_encode($returnData);
    }

    function productos_subcategoria()
    {

       // $productos = model('subCategoriaModel')->get_productos($this->request->getPost('id_subcategoria'));
        $productos = model('subCategoriaModel')->get_productos_sub_categoria($this->request->getPost('id_subcategoria'));

        $items = view('pedido/productos_sub_categoria', [
            'productos' => $productos,
        ]);

        $returnData = array(
            "resultado" => 1,
            "productos" => $items


        );
        echo  json_encode($returnData);
    }

    function reporte_meseros()
    {
        $id_mesero = $this->request->getPost('id_mesero');

        $fecha_inicial = $this->request->getPost('fecha_inicial');
        $fecha_final = $this->request->getPost('fecha_final');

        //$ventas=model('pagosModel')->

        $returnData = array(
            "resultado" => 1,
        );
        echo  json_encode($returnData);
    }

    function entradas_salidas()
    {
        $returnData = array();
        $valor = $this->request->getVar('term');
        //$valor = 'a';

        $resultado = model('productoModel')->autoComplete($valor);

        if (!empty($resultado)) {
            foreach ($resultado as $row) {
                $cantidad_producto = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $row['codigointernoproducto'])->first();


                if (empty($cantidad_producto)) {
                    $inventario = [
                        'codigointernoproducto' => $row['codigointernoproducto'],
                        'idvalor_unidad_medida' => 3,
                        'idcolor' => 0,
                        'cantidad_inventario' => 0
                    ];

                    $insert = model('inventarioModel')->insert($inventario);

                    $cantidad = 0;
                }

                if (!empty($cantidad_producto)) {
                    $cantidad = $cantidad_producto['cantidad_inventario'];
                }


                $data['value'] =  $row['codigointernoproducto'] . " " . "/" . " " . $row['nombreproducto'];
                $data['id_producto'] = $row['codigointernoproducto'];
                $data['nombre_producto'] = $row['nombreproducto'];
                $data['valor_venta'] = $row['valorventaproducto'];
                //$data['cantidad'] = $cantidad_producto['cantidad_inventario'];
                $data['cantidad'] = $cantidad;
                // $data=['cantidad']=$cantidad_producto['cantidad_inventario'];
                array_push($returnData, $data);
            }
            echo json_encode($returnData);
        } else {
            $data['value'] = "No hay resultados";
            array_push($returnData, $data);
            echo json_encode($returnData);
        }
    }



    public function por_defecto()
    {

        $sql_count = '';
        $sql_data = '';

        $fecha_inicial = date('Y-m-d');
        $fecha_final = date('Y-m-d');




        $table_map = [
            0 => 'id',
            1 => 'nitcliente',
            2 => 'nombrescliente',
            3 => 'descripcionestado',
            4 => 'fecha_factura_venta',
            5 => 'horafactura_venta',
            6 => 'fechalimitefactura_venta',
        ];

        $temp_sql_count = "SELECT
                    COUNT(factura_venta.id) AS total
                FROM
                    factura_venta
                INNER JOIN cliente ON factura_venta.nitcliente = cliente.nitcliente
                INNER JOIN estado ON factura_venta.idestado = estado.idestado WHERE  fecha_factura_venta BETWEEN '$fecha_inicial' AND '$fecha_final' ";

        $temp_sql_data = " SELECT
                        factura_venta.id,
                        factura_venta.nitcliente,
                        cliente.nombrescliente,
                        descripcionestado,
                        fecha_factura_venta,
                        horafactura_venta,
                        fechalimitefactura_venta,
                        numerofactura_venta,
                        fechalimitefactura_venta,
                        valor_factura,saldo
                    FROM
                        factura_venta
                    INNER JOIN cliente ON factura_venta.nitcliente = cliente.nitcliente
                    INNER JOIN estado ON factura_venta.idestado = estado.idestado WHERE fecha_factura_venta BETWEEN '$fecha_inicial' AND '$fecha_final' ";

        $condition = "";

        if (!empty($valor_buscado)) {
            $condition .= " AND descripcionestado ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR cliente.nombrescliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR factura_venta.nitcliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR numerofactura_venta ILIKE '%" . $valor_buscado . "%'";
        }

        $sql_count = $temp_sql_count;
        $sql_data = $temp_sql_data;
        $sql_count = $sql_count . $condition;
        $sql_data = $sql_data . $condition;
        $total_count = $this->db->query($sql_count)->getRow();
        $sql_data .= " ORDER BY " . $table_map[$_GET['order'][0]['column']] . " " . $_GET['order'][0]['dir'] . " " . "LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];


        $datos = $this->db->query($sql_data)->getResultArray();

        if (!empty($datos) && !empty($total_count->total)) {

            foreach ($datos as $detalle) {
                $sub_array = array();
                $sub_array[] = number_format($detalle['nitcliente'], 0, ",", ".");
                $sub_array[] = $detalle['nombrescliente'];
                $sub_array[] = $detalle['descripcionestado'];
                $sub_array[] = $detalle['numerofactura_venta'];
                $sub_array[] = $detalle['fecha_factura_venta'];
                $sub_array[] = $detalle['fechalimitefactura_venta'];
                $sub_array[] = "$" . number_format($detalle['valor_factura'], 0, ",", ".");
                $sub_array[] = "$" . number_format($detalle['saldo'], 0, ",", ".");
                //$sub_array[] = date("g:i a", strtotime($detalle['horafactura_venta']));
                $sub_array[] = '<a  class="btn btn-primary btn-icon " title="Imprimir copia " onclick="imprimir_duplicado_factura(' . $detalle['id'] . ')" >
                <!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><rect x="7" y="13" width="10" height="8" rx="2" /></svg></a>  
            <a  class="btn bg-muted-lt btn-icon " title="Ver detalle" onclick="detalle_de_factura(' . $detalle['id'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg></a>
            <a  class="btn bg-green-lt btn-icon " title="Realizar pago " onclick="abonos_a_cartera(' . $detalle['nitcliente'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg></a>
            <a  class="btn bg-muted-lt-lt btn-icon " title="Ver pago " onclick="detalle_de_factura(' . $detalle['id'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/eyeglass-2 -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 4h-2l-3 10v2.5" /><path d="M16 4h2l3 10v2.5" /><line x1="10" y1="16" x2="14" y2="16" /><circle cx="17.5" cy="16.5" r="3.5" /><circle cx="6.5" cy="16.5" r="3.5" /></svg></a>
            <a  class="btn bg-green-lt btn-icon "  onclick="detalle_de_factura(' . $detalle['id'] . ')"  ><!-- Download SVG icon from http://tabler-icons.io/i/pencil -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" /><line x1="13.5" y1="6.5" x2="17.5" y2="10.5" /></svg></a>
            <a onclick="abono_credito(' . $detalle['id'] . ')"  class="btn btn-primary  btn-icon" ><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg> </a> ';
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
    }

    function exportar_excel()
    {


        $productos = model('productoModel')->get_todos_productos();

        $datos_empresa = model('empresaModel')->findAll();


        return view('inventarios/excel', [
            'productos' => $productos,
            'datos_empresa' => $datos_empresa
        ]);
    }
    function reporte_ventas()
    {
        model('reporteProductoModel')->truncate();
        $fecha_inicial = $this->request->getPost('fecha_inicial');
        $fecha_final = $this->request->getPost('fecha_final');

        // $fecha_inicial = "2024-03-01";
        //$fecha_final = "2024-03-30";

        $inicial = $fecha_inicial;
        $final = $fecha_final;

        if (empty($fecha_inicial) &&  empty($fecha_final)) {

            $min_id = model('pagosModel')->selectMin('id')->first();
            $max_id = model('pagosModel')->selectMax('id')->first();

            $temp_fecha_ini = model('pagosModel')->select('fecha')->where('id', $min_id['id'])->first();
            $temp_fecha_fin = model('pagosModel')->select('fecha')->where('id', $max_id['id'])->first();

            $inicial = $temp_fecha_ini['fecha'];
            $final = $temp_fecha_fin['fecha'];
        }

        $resultado = model('kardexModel')->resultado_suma_entre_fechas($inicial, $final);

        if (!empty($resultado)) {

            $validar_tabla_reporte_producto = model('reporteProductoModel')->findAll();
            $categorias = model('productoFacturaVentaModel')->kardex_categorias($inicial, $final);


            $devoluciones = model('devolucionModel')->resutado_suma_entre_fechas($inicial, $final);
            $total_devoluciones = model('devolucionModel')->total($inicial, $final);

            if (empty($validar_tabla_reporte_producto)) {

                foreach ($resultado as $detalle) {
                    $productos_suma = model('kardexModel')->reporte_suma_cantidades($inicial, $final, $detalle['total'], $detalle['codigo']);
                    $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $detalle['codigo'])->first();
                    $codigocategoria = model('productoModel')->select('codigocategoria')->where('codigointernoproducto', $detalle['codigo'])->first();

                    $data = [
                        'cantidad' => round($productos_suma[0]['cantidad']),
                        'nombre_producto' => $nombre_producto['nombreproducto'],
                        'precio_venta' => round($productos_suma[0]['total'] / $productos_suma[0]['cantidad']),
                        'valor_total' => $productos_suma[0]['total'],
                        'id_categoria' => $codigocategoria['codigocategoria'],
                        'codigo_interno_producto' => $detalle['codigo']
                    ];
                    $insert = model('reporteProductoModel')->insert($data);
                }
            }
            $productos = view('producto/datos_consulta_producto', [
                //'datos_productos' => $resultado,
                'categorias' => $categorias,
                'fecha_inicial' => $inicial,
                'fecha_final' => $final,
                //'total' => "$" . number_format($total[0]['total'], 0, ",", "."),
                'devoluciones' => $devoluciones,
                'total_devoluciones' => "$" . number_format($total_devoluciones[0]['total'], 0, ",", "."),
                'hora_inicial' => 0,
                'hora_final' => 0
            ]);


            $returnData = [
                'resultado' => 0,
                'datos' => $productos
            ];
            echo json_encode($returnData);
        } else if (empty($resultado)) {
            $returnData = [
                'resultado' => 2,
                
            ];
            echo json_encode($returnData);
        }
    }

    function export_pdf(){

        $dompdf = new Dompdf();

        $options = $dompdf->getOptions();

        $options->set(array('isRemoteEnable' => true));
        $dompdf->setOptions($options);

        $id_categoria=model('reporteProductoModel')->categorias();

        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

       //dd($datos_empresa);

        $dompdf->loadHtml(view('reportes/pdf_producto', [
            'categorias'=>$id_categoria,
            'datos_empresa' => $datos_empresa,
            'regimen' => $regimen['nombreregimen'],
            'nombre_ciudad' => $nombre_ciudad['nombreciudad'],
            'nombre_departamento' => $nombre_departamento['nombredepartamento'],
            'nombre_comercial'=>$datos_empresa[0]['nombrecomercialempresa'],
            'nombre_juridico'=>$datos_empresa[0]['nombrejuridicoempresa'],
            'nit'=>$datos_empresa[0]['nitempresa'],
            'nombre_regimen'=>$regimen['nombreregimen'],
            'direccion'=>$datos_empresa[0]['direccionempresa'],
        ]));
        
        $options = $dompdf->getOptions();
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->stream("Reporte de producto.pdf", array("Attachment" => true));
    }
}
