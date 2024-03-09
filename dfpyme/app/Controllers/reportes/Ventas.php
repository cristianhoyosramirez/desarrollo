<?php

namespace App\Controllers\reportes;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class Ventas extends BaseController
{

    public $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    public function ventas()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        //$id_apertura = 56;
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
                'movimientos' => $movimientos,
                "id_apertura" => $id_apertura
            ]),
            "resultado" => 1,
            "ventas_pos" => "$" . number_format($ventas_pos[0]['valor'], 0, ",", "."),
            "ventas_electronicas" => "$" . number_format($ventas_electronicas[0]['valor'], 0, ",", "."),
            "propinas" => "$" . number_format($propinas[0]['propina'], 0, ",", "."),
            "efectivo" => "$" . number_format($efectivo[0]['recibido_efectivo'], 0, ",", "."),
            "transferencia" => "$" . number_format($transferencia[0]['recibido_transferencia'], 0, ",", "."),
            "total_ingresos" => "$" . number_format(($transferencia[0]['recibido_transferencia'] + $efectivo[0]['recibido_efectivo']) - $cambio[0]['cambio'], 0, ",", "."),
            "valor" => "$" . number_format($valor[0]['valor'], 0, ",", "."),
            //"total_documento" => "$" . number_format($total_documento[0]['total_documento'], 0, ",", "."),
            "total_documento" => "$" . number_format($ventas_pos[0]['valor'] + $ventas_electronicas[0]['valor'], 0, ",", "."),
            "cambio" => "$" . number_format($cambio[0]['cambio'], 0, ",", "."),

        );
        echo  json_encode($returnData);
    }

    public function exportar_excel()
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


        return view('reportes/excel_ventas', [
            'movimientos' => $movimientos,
            "ventas_pos" => "$" . number_format($ventas_pos[0]['valor'], 0, ",", "."),
            "ventas_electronicas" => "$" . number_format($ventas_electronicas[0]['valor'], 0, ",", "."),
            "propinas" => "$" . number_format($propinas[0]['propina'], 0, ",", "."),
            "efectivo" => "$" . number_format($efectivo[0]['recibido_efectivo'], 0, ",", "."),
            "transferencia" => "$" . number_format($transferencia[0]['recibido_transferencia'], 0, ",", "."),
            "total_ingresos" => "$" . number_format(($transferencia[0]['recibido_transferencia'] + $efectivo[0]['recibido_efectivo']) - $cambio[0]['cambio'], 0, ",", "."),
            "valor" => "$" . number_format($valor[0]['valor'], 0, ",", "."),
            "total_documento" => "$" . number_format($total_documento[0]['total_documento'], 0, ",", "."),
            "cambio" => "$" . number_format($cambio[0]['cambio'], 0, ",", "."),
        ]);
        /*  "resultado" => 1,
            "ventas_pos" => "$" . number_format($ventas_pos[0]['valor'], 0, ",", "."),
            "ventas_electronicas" => "$" . number_format($ventas_electronicas[0]['valor'], 0, ",", "."),
            "propinas" => "$" . number_format($propinas[0]['propina'], 0, ",", "."),
            "efectivo" => "$" . number_format($efectivo[0]['recibido_efectivo'], 0, ",", "."),
            "transferencia" => "$" . number_format($transferencia[0]['recibido_transferencia'], 0, ",", "."),
            "total_ingresos" => "$" . number_format(($transferencia[0]['recibido_transferencia'] + $efectivo[0]['recibido_efectivo']) - $cambio[0]['cambio'], 0, ",", "."),
            "valor" => "$" . number_format($valor[0]['valor'], 0, ",", "."),
            "total_documento" => "$" . number_format($total_documento[0]['total_documento'], 0, ",", "."),
            "cambio" => "$" . number_format($cambio[0]['cambio'], 0, ",", "."), */
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

    function productos_borrados()
    {

        $productos = model('productosBorradosModel')->getProductosBorrados(date('Y-m-d'), date('Y-m-d'));

        return view('consultas/productos_borrados', [
            'productos' => $productos
        ]);
    }
    function datos_productos_borrados()
    {

        $productos = model('productosBorradosModel')->getProductosBorrados(date('Y-m-d'), date('Y-m-d'));


        $returnData = [
            'resultado' => 1, //No hay resultados
            'productos' => view('consultas/get_productos_borrados', [
                'productos' => $productos
            ])

        ];
        echo json_encode($returnData);
    }

    function reporte_costo()
    {
        return view('configuracion/costo');
    }

    function reporte_ventas()
    {
        return view('configuracion/ventas');
    }

    function datos_reporte_costo()
    {
        $fecha_inicial = $this->request->getPost('fecha_inicial');
        //$fecha_inicial = '2023-11-16';
        $fecha_final = $this->request->getPost('fecha_final');
        //$fecha_final = '2023-11-16';



        //$id_facturas_pos = model('pagosModel')->get_id_pos($fecha_inicial, $fecha_final);
        $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
        //$id_facturas_electronicas = model('pagosModel')->get_id_electronicas($fecha_inicial, $fecha_final);

        $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
        $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
        $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);

        $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);

        $base_iva = model('pagosModel')->get_base_iva($fecha_inicial, $fecha_final);
        $base_ico = model('pagosModel')->get_base_ico($fecha_inicial, $fecha_final);



        if (!empty($id_facturas)) {
            $returnData = [
                'resultado' => 1, //No hay resultados
                'datos' => view('consultas/tabla_costos', [
                    'id_facturas' => $id_facturas,
                    'total_costo' => $total_costo[0]['total_costo'],
                    'total_ico' => $total_ico[0]['total_ico'],
                    'total_iva' => $total_iva[0]['total_iva'],
                    'total_venta' => $total_venta[0]['total_venta'],
                    "total_base" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", "."),
                    "fecha_inicial" => $fecha_inicial,
                    "fecha_final" => $fecha_final,
                    //"base_ico" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                    "base_ico" => number_format($base_ico[0]['base_ico'], 0, ",", "."),
                    // "base_iva" => number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                    "base_iva" => number_format($base_iva[0]['base_iva'], 0, ",", "."),
                    "total_impuesto" => number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
                ]),
                'fecha_inicial' => $fecha_inicial,
                'fecha_final' => $fecha_final
            ];
            echo json_encode($returnData);
        }
        if (empty($id_facturas)) {
            $returnData = [
                'resultado' => 0, //No hay resultados

            ];
            echo json_encode($returnData);
        }
    }
    function datos_reporte_ventas()
    {
        $fecha_inicial = $this->request->getPost('fecha_inicial');
        //$fecha_inicial = '2023-11-30';
        $fecha_final = $this->request->getPost('fecha_final');
        //$fecha_final = '2023-11-30';



        //$id_facturas_pos = model('pagosModel')->get_id_pos($fecha_inicial, $fecha_final);
        $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
        //$id_facturas_electronicas = model('pagosModel')->get_id_electronicas($fecha_inicial, $fecha_final);

        $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
        $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
        $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
        $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);


        $base_iva = model('pagosModel')->get_base_iva($fecha_inicial, $fecha_final);
        $base_ico = model('pagosModel')->get_base_ico($fecha_inicial, $fecha_final);



        if (!empty($id_facturas)) {
            $returnData = [
                'resultado' => 1, //No hay resultados
                'datos' => view('consultas/tabla_ventas', [
                    'id_facturas' => $id_facturas,
                    'total_costo' => $total_costo[0]['total_costo'],
                    'total_ico' => $total_ico[0]['total_ico'],
                    'total_iva' => $total_iva[0]['total_iva'],
                    'total_venta' => $total_venta[0]['total_venta'],
                    "base_ico" => number_format($base_ico[0]['base_ico'], 0, ",", "."),
                    "base_iva" => number_format($base_iva[0]['base_iva'], 0, ",", "."),
                ]),
                'fecha_inicial' => $fecha_inicial,
                'fecha_final' => $fecha_final
            ];
            echo json_encode($returnData);
        }
        if (empty($id_facturas)) {
            $returnData = [
                'resultado' => 0, //No hay resultados

            ];
            echo json_encode($returnData);
        }
    }
    public function exportar_reporte_costo()
    {
        $dompdf = new Dompdf();

        // Configuración de opciones
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        // Obtener datos de la empresa
        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

        // Fecha inicial y final (puedes obtenerlas del formulario)
        $fecha_inicial = $this->request->getPost('inicial');
        $fecha_final = $this->request->getPost('final');

        if (empty($fecha_inicial) or empty($fecha_final)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
            return redirect()->to(base_url('reportes/reporte_costo'))->with('mensaje', 'No hay datos para el rango de fechas  ');
        }

        if (!empty($fecha_inicial) and !empty($fecha_final)) {
            // Obtener datos para el informe
            $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
            $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
            $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
            $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
            //$total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $base_iva = model('pagosModel')->get_base_iva($fecha_inicial, $fecha_final);
            $base_ico = model('pagosModel')->get_base_ico($fecha_inicial, $fecha_final);

            // Cargar vista para el informe
            $html = view('consultas/pdf_costos', [
                'id_facturas' => $id_facturas,
                'total_costo' => number_format($total_costo[0]['total_costo'], 0, ",", "."),
                'total_ico' =>  number_format($total_ico[0]['total_ico'], 0, ",", "."),
                'total_iva' => number_format($total_iva[0]['total_iva'], 0, ",", "."),
                'total_venta' => number_format($total_venta[0]['total_venta'], 0, ",", "."),
                "nombre_comercial" => $datos_empresa[0]['nombrecomercialempresa'],
                "nombre_juridico" => $datos_empresa[0]['nombrejuridicoempresa'],
                "nit" => $datos_empresa[0]['nitempresa'],
                "nombre_regimen" => $regimen['nombreregimen'],
                "direccion" => $datos_empresa[0]['direccionempresa'],
                "nombre_ciudad" => $nombre_ciudad['nombreciudad'],
                "nombre_departamento" => $nombre_departamento['nombredepartamento'],
                "total_base" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", "."),
                "fecha_inicial" => $fecha_inicial,
                "fecha_final" => $fecha_final,
                //"base_ico" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                //"base_iva" => number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "base_ico" => number_format($base_ico[0]['base_ico'], 0, ",", "."),
                "base_iva" => number_format($base_iva[0]['base_iva'], 0, ",", "."),
                "total_impuesto" => number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
            ]);

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Establecer el tamaño del papel a 'letter'
            $dompdf->setPaper('letter', 'portrait');

            // Renderizar el PDF
            $dompdf->render();

            // Descargar el PDF
            $dompdf->stream("Reporte_de_costos.pdf", array("Attachment" => true));
        }
    }
    public function exportar_reporte_costo_excel()
    {



        // Obtener datos de la empresa
        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

        // Fecha inicial y final (puedes obtenerlas del formulario)
        $fecha_inicial = $this->request->getPost('inicial');
        $fecha_final = $this->request->getPost('final');

        if (empty($fecha_inicial) or empty($fecha_final)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
            return redirect()->to(base_url('reportes/reporte_costo'))->with('mensaje', 'No hay datos para el rango de fechas  ');
        }

        if (!empty($fecha_inicial) and !empty($fecha_final)) {
            // Obtener datos para el informe
            $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
            $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
            $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
            $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
            //$total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $base_iva = model('pagosModel')->get_base_iva($fecha_inicial, $fecha_final);
            $base_ico = model('pagosModel')->get_base_ico($fecha_inicial, $fecha_final);

            // Cargar vista para el informe
            return view('consultas/excel_costos', [
                'id_facturas' => $id_facturas,
                'total_costo' => number_format($total_costo[0]['total_costo'], 0, ",", "."),
                'total_ico' =>  number_format($total_ico[0]['total_ico'], 0, ",", "."),
                'total_iva' => number_format($total_iva[0]['total_iva'], 0, ",", "."),
                'total_venta' => number_format($total_venta[0]['total_venta'], 0, ",", "."),
                "nombre_comercial" => $datos_empresa[0]['nombrecomercialempresa'],
                "nombre_juridico" => $datos_empresa[0]['nombrejuridicoempresa'],
                "nit" => $datos_empresa[0]['nitempresa'],
                "nombre_regimen" => $regimen['nombreregimen'],
                "direccion" => $datos_empresa[0]['direccionempresa'],
                "nombre_ciudad" => $nombre_ciudad['nombreciudad'],
                "nombre_departamento" => $nombre_departamento['nombredepartamento'],
                "total_base" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", "."),
                "fecha_inicial" => $fecha_inicial,
                "fecha_final" => $fecha_final,
                //"base_ico" => number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                //"base_iva" => number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "base_ico" => number_format($base_ico[0]['base_ico'], 0, ",", "."),
                "base_iva" => number_format($base_iva[0]['base_iva'], 0, ",", "."),
                "total_impuesto" => number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
            ]);

            // Cargar el HTML en Dompdf

        }
    }
    public function exportar_reporte_ventas()
    {
        $dompdf = new Dompdf();

        // Configuración de opciones
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf->setOptions($options);

        // Obtener datos de la empresa
        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

        // Fecha inicial y final (puedes obtenerlas del formulario)
        $fecha_inicial = $this->request->getPost('inicial');
        $fecha_final = $this->request->getPost('final');

        if (empty($fecha_inicial) or empty($fecha_final)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
            return redirect()->to(base_url('reportes/reportes_ventas'))->with('mensaje', 'No hay datos para el rango de fechas  ');
        }

        if (!empty($fecha_inicial) and !empty($fecha_final)) {
            // Obtener datos para el informe
            $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
            $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
            $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
            $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
            //$total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);

            // Cargar vista para el informe
            $html = view('consultas/pdf_ventas', [
                'id_facturas' => $id_facturas,
                'total_costo' => "$ " . number_format($total_costo[0]['total_costo'], 0, ",", "."),
                'total_ico' => "$ " . number_format($total_ico[0]['total_ico'], 0, ",", "."),
                'total_iva' => "$ " . number_format($total_iva[0]['total_iva'], 0, ",", "."),
                'total_venta' => "$ " . number_format($total_venta[0]['total_venta'], 0, ",", "."),
                "nombre_comercial" => $datos_empresa[0]['nombrecomercialempresa'],
                "nombre_juridico" => $datos_empresa[0]['nombrejuridicoempresa'],
                "nit" => $datos_empresa[0]['nitempresa'],
                "nombre_regimen" => $regimen['nombreregimen'],
                "direccion" => $datos_empresa[0]['direccionempresa'],
                "nombre_ciudad" => $nombre_ciudad['nombreciudad'],
                "nombre_departamento" => $nombre_departamento['nombredepartamento'],
                "total_base" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico'] - $total_iva[0]['total_iva']), 0, ",", "."),
                "fecha_inicial" => $fecha_inicial,
                "fecha_final" => $fecha_final,
                "base_ico" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                "base_iva" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "total_impuesto" => "$ " . number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
            ]);

            // Cargar el HTML en Dompdf
            $dompdf->loadHtml($html);

            // Establecer el tamaño del papel a 'letter'
            $dompdf->setPaper('letter', 'portrait');

            // Renderizar el PDF
            $dompdf->render();

            // Descargar el PDF
            $dompdf->stream("Reporte_de_ventas.pdf", array("Attachment" => true));
        }
    }
    public function exportar_reporte_ventas_excel()
    {




        // Obtener datos de la empresa
        $datos_empresa = model('empresaModel')->find();
        $id_regimen = $datos_empresa[0]['idregimen'];
        $regimen = model('regimenModel')->select('nombreregimen')->where('idregimen', $id_regimen)->first();
        $nombre_ciudad = model('ciudadModel')->select('nombreciudad')->where('idciudad', $datos_empresa[0]['idciudad'])->first();
        $nombre_departamento = model('departamentoModel')->select('nombredepartamento')->where('iddepartamento', $datos_empresa[0]['iddepartamento'])->first();

        // Fecha inicial y final (puedes obtenerlas del formulario)
        $fecha_inicial = $this->request->getPost('inicial');
        $fecha_final = $this->request->getPost('final');

        if (empty($fecha_inicial) or empty($fecha_final)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'warning');
            return redirect()->to(base_url('reportes/reportes_ventas'))->with('mensaje', 'No hay datos para el rango de fechas  ');
        }

        if (!empty($fecha_inicial) and !empty($fecha_final)) {
            // Obtener datos para el informe
            $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
            $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
            $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
            $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
            //$total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);
            $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);

            // Cargar vista para el informe
            return view('consultas/excel_ventas', [
                'id_facturas' => $id_facturas,
                'total_costo' => "$ " . number_format($total_costo[0]['total_costo'], 0, ",", "."),
                'total_ico' => "$ " . number_format($total_ico[0]['total_ico'], 0, ",", "."),
                'total_iva' => "$ " . number_format($total_iva[0]['total_iva'], 0, ",", "."),
                'total_venta' => "$ " . number_format($total_venta[0]['total_venta'], 0, ",", "."),
                "nombre_comercial" => $datos_empresa[0]['nombrecomercialempresa'],
                "nombre_juridico" => $datos_empresa[0]['nombrejuridicoempresa'],
                "nit" => $datos_empresa[0]['nitempresa'],
                "nombre_regimen" => $regimen['nombreregimen'],
                "direccion" => $datos_empresa[0]['direccionempresa'],
                "nombre_ciudad" => $nombre_ciudad['nombreciudad'],
                "nombre_departamento" => $nombre_departamento['nombredepartamento'],
                "total_base" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico'] - $total_iva[0]['total_iva']), 0, ",", "."),
                "fecha_inicial" => $fecha_inicial,
                "fecha_final" => $fecha_final,
                "base_ico" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                "base_iva" => "$ " . number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "total_impuesto" => "$ " . number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
            ]);
        }
    }

    function editar_apertura()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        $valor_apertura = model('aperturaModel')->select('valor')->where('id', $id_apertura)->first();
        $returnData = [
            'resultado' => 1,
            'valor' => number_format($valor_apertura['valor'], 0, ',', '.'),
            'id_apertura' => $id_apertura

        ];
        echo json_encode($returnData);
    }

    function cambiar_valor_apertura()
    {

        $id_apertura = $this->request->getPost('id_de_apertura');

        $data = [
            'valor' => str_replace(".", "", $this->request->getPost('nuevoValor'))
        ];

        $model = model('aperturaModel');
        $actualizar = $model->set($data);
        $actualizar = $model->where('id', $id_apertura);
        $actualizar = $model->update();


        /*   $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('consultas_y_reportes/datos_consultas_caja_por_fecha'))->with('mensaje', 'Edicion de apertura correcto  '); */

        $ultimo_apertura = model('aperturaModel')->selectMax('id')->first();
        $ultimo_id = $ultimo_apertura['id'];

        $estado = "";
        $movimientos = "";
        $fecha_cierre = "";
        $ingresos_efectivo = "";
        $ingresos_transaccion = "";
        $efectivo_cierre = "";
        $transaccion_cierre = "";
        $devoluciones = "";
        $retiros = "";
        $saldo = "";
        $propinas = "";

        $tiene_cierre = model('cierreModel')->select('fecha')->where('idapertura', $ultimo_id)->first();
        $fecha_apertura = model('aperturaModel')->select('fecha')->where('id', $ultimo_id)->first();
        $valor_apertura = model('aperturaModel')->select('valor')->where('id', $ultimo_id)->first();
        $fecha_y_hora_apertura = model('aperturaModel')->select('fecha_y_hora_apertura')->where('id', $ultimo_id)->first();

        $aperturas = model('aperturaModel')->findAll();

        if (!empty($aperturas)) {

            if (empty($tiene_cierre)) {
                $estado = "ABIERTA";
                $cierre = 'Sin cierre';

                $ingresos = model('pagosModel')->selectSum('efectivo')->where('id_apertura', $ultimo_apertura['id'])->findAll();
                $ingresos_efectivo = $ingresos[0]['efectivo'];

                $temp_propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $ultimo_apertura['id'])->findAll();
                $propinas = $temp_propinas[0]['propina'];


                $transaccion = model('pagosModel')->selectSum('transferencia')->where('id_apertura', $ultimo_apertura['id'])->findAll();
                $ingresos_transaccion = $transaccion[0]['transferencia'];


                $valor_cierre = 0;
                $devolucion_venta = model('detalleDevolucionVentaModel')->selectSum('valor_total_producto')->where('id_apertura', $ultimo_apertura['id'])->findAll();

                if (empty($devolucion_venta)) {
                    $devoluciones = 0;
                } else if (!empty($devolucion_venta)) {
                    $devoluciones = $devolucion_venta[0]['valor_total_producto'];
                }
                //$total_retiros = model('retiroFormaPagoModel')->total_retiros($fecha_y_hora_apertura['fecha_y_hora_apertura'], date('Y-m-d H:i:s'));
                $total_retiros = model('retiroFormaPagoModel')->selectSum('valor')->where('id_apertura', $ultimo_apertura['id'])->findAll();


                if (empty($total_retiros[0]['valor'])) {
                    $retiros = 0;
                }
                if (!empty($total_retiros[0]['valor'])) {
                    $retiros = $total_retiros[0]['valor'];
                }

                $efectivo_cierre = 0;
                $transaccion_cierre = 0;
                $saldo = 0;

                //$diferencia = ($efectivo_cierre + $transaccion_cierre) - (($ingresos_transaccion + $ingresos_efectivo + $valor_apertura['valor']) - ($retiros + $devoluciones));
                $diferencia =  (($ingresos_transaccion + $ingresos_efectivo + $valor_apertura['valor']) - ($retiros + $devoluciones)) - ($efectivo_cierre + $transaccion_cierre);
            }
            if (!empty($tiene_cierre)) {

                $estado = 'CERRADA';
                $fecha_cierre = model('cierreModel')->select('fecha')->where('idapertura', $ultimo_id)->first();
                $cierre = $fecha_cierre['fecha'];

                $fecha_y_hora_cierre = model('cierreModel')->select('fecha_y_hora_cierre')->where('idapertura', $ultimo_id)->first();
                $efectivo = model('pagosModel')->selectSum('efectivo')->where('id_apertura', $ultimo_id)->findAll();
                if (empty($efectivo)) {
                    $ingresos_efectivo = 0;
                } else if (!empty($efectivo)) {
                    $ingresos_efectivo = $efectivo[0]['efectivo'];
                }

                $transaccion = model('pagosModel')->selectSum('transferencia')->where('id_apertura', $ultimo_id)->findAll();
                if (empty($transaccion)) {
                    $ingresos_transaccion = 0;
                } else if (!empty($transaccion)) {
                    $ingresos_transaccion = $transaccion[0]['transferencia'];
                }
                $valor_cierre = 0;
                $devolucion_venta = model('devolucionModel')->sumar_devoluciones($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_cierre['fecha_y_hora_cierre']);


                if (empty($devolucion_venta)) {
                    $devoluciones = 0;
                } else if (!empty($devolucion_venta)) {
                    $devoluciones = $devolucion_venta[0]['total_devoluciones'];
                }
                $id_cierre = model('cierreModel')->select('id')->where('idapertura', $ultimo_id)->first();
                $efectivo = model('cierreFormaPagoModel')->cierre_efectivo($id_cierre['id']);
                $transaccion = model('cierreFormaPagoModel')->cierre_transaccion($id_cierre['id']);

                if (!empty($efectivo)) {
                    $efectivo_cierre = $efectivo[0]['valor'];
                }
                if (empty($efectivo)) {
                    $efectivo_cierre = 0;
                }
                if (empty($transaccion)) {
                    $transaccion_cierre = 0;
                }
                if (!empty($transaccion)) {
                    $transaccion_cierre = $transaccion[0]['valor'];
                }

                $total_retiros = model('retiroFormaPagoModel')->total_retiros($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_cierre['fecha_y_hora_cierre']);

                if (empty($total_retiros[0]['total_retiros'])) {
                    $retiros = 0;
                }
                if (!empty($total_retiros[0]['total_retiros'])) {
                    $retiros = $total_retiros[0]['total_retiros'];
                }


                $temp_propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $ultimo_id)->findAll();
                $propinas = $temp_propinas[0]['propina'];
                $diferencia =  (($ingresos_transaccion + $ingresos_efectivo + $valor_apertura['valor']) - ($retiros + $devoluciones)) - ($efectivo_cierre + $transaccion_cierre);
            }



            return view('consultas_y_reportes/datos_consultas_caja', [
                'estado' => $estado,
                'fecha_apertura' => $fecha_apertura['fecha'],
                'fecha_cierre' => $cierre,
                'valor_apertura' => "$" . number_format($valor_apertura['valor'], 0, ",", "."),
                'ingresos_efectivo' =>  "$" . number_format(($ingresos_efectivo + $ingresos_transaccion) - $propinas, 0, ",", "."),
                'ingresos_transaccion' =>  "$" . number_format($ingresos_transaccion, 0, ",", "."),
                'total_ingresos' =>  "$" . number_format(($ingresos_transaccion + $ingresos_efectivo) + $valor_apertura['valor'], 0, ",", "."),
                'efectivo_cierre' => "$" . number_format($efectivo_cierre, 0, ",", "."),
                'transaccion_cierre' => "$" . number_format($transaccion_cierre, 0, ",", "."),
                'total_cierre' => "$" . number_format($efectivo_cierre + $transaccion_cierre, 0, ",", "."),
                'devoluciones' => "$" . number_format($devoluciones, 0, ",", "."),
                'retiros' => "$" . number_format($retiros, 0, ",", "."),
                'propinas' => "$" . number_format($propinas, 0, ",", "."),
                'retirosmasdevoluciones' => "$" . number_format($retiros + $devoluciones, 0, ",", "."),
                'saldo_caja' => "$" . number_format(($valor_apertura['valor'] + $ingresos_efectivo + $ingresos_transaccion) - ($retiros + $devoluciones), 0, ",", "."),
                'diferencia' => "$" . number_format($diferencia, 0, ",", "."),
                'id_apertura' => $ultimo_id,
                'estado' => 1
            ]);
        }
    }
    function editar_cierre_efectivo()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        $id_cierre = model('cierreModel')->select('id')->where('idapertura', $id_apertura)->first();

        if (!empty($id_cierre)) {


            /*          $valor_cierre = model('cierreFormaPagoModel')->select('valor')->where('idcierre', $id_cierre['id'])->first();
            $valor_cierre = model('cierreFormaPagoModel')->select('valor')->where('idpago', 1)->first(); */


            $valor_cierre = model('cierreFormaPagoModel')->cierre_efectivo($id_cierre['id']);


            $returnData = [
                'resultado' => 1,
                'id_cierre' => $id_cierre['id'],
                'valor_cierre' =>  number_format($valor_cierre[0]['valor'], 0, ",", "."),
                'id_forma_pago' => 1,
                'titulo' => 'Editar cierre efectivo '
            ];
            echo json_encode($returnData);
        }
        if (empty($id_cierre)) {

            $returnData = [
                'resultado' => 0,

            ];
            echo json_encode($returnData);
        }
    }
    function editar_cierre_transaccion()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        $id_cierre = model('cierreModel')->select('id')->where('idapertura', $id_apertura)->first();

        if (!empty($id_cierre)) {

            /* $valor_cierre = model('cierreFormaPagoModel')->select('valor')->where('idcierre', $id_cierre['id'])->first();
            $valor_cierre = model('cierreFormaPagoModel')->select('valor')->where('idpago', 4)->first(); */

            $valor_cierre = model('cierreFormaPagoModel')->cierre_transaccion($id_cierre['id']);

            $returnData = [
                'resultado' => 1,
                'id_cierre' => $id_cierre['id'],
                'valor_cierre' =>  number_format($valor_cierre[0]['valor'], 0, ",", "."),
                'id_forma_pago' => 4,
                'titulo' => 'Editar cierre efectivo '
            ];
            echo json_encode($returnData);
        }
        if (empty($id_cierre)) {

            $returnData = [
                'resultado' => 0,

            ];
            echo json_encode($returnData);
        }
    }

    function cambiar_valor_cierre_efectivo()
    {

        $valor_cierre = $this->request->getPost('nuevoCierre');
        $id_cierre = $this->request->getPost('id_cierre');
        $id_apertura = model('cierreModel')->select('idapertura')->where('id', $id_cierre)->first();

        $id_forma_pago = $this->request->getPost('id_forma_pago');

        $fecha_apertura = model('aperturaModel')->select('fecha')->where('id', $id_apertura['idapertura'])->first();
        $valor_apertura = model('aperturaModel')->select('valor')->where('id', $id_apertura['idapertura'])->first();
        $fecha_y_hora_apertura = model('aperturaModel')->select('fecha_y_hora_apertura')->where('id', $id_apertura['idapertura'])->first();

        $data = [
            'valor' => str_replace(".", "", $valor_cierre)
        ];

        $model = model('cierreFormaPagoModel');
        $actualizar = $model->set($data);
        $actualizar = $model->where('idcierre', $id_cierre);
        $actualizar = $model->where('idpago', $id_forma_pago);
        $actualizar = $model->update();



        $estado = 'CERRADA';
        $fecha_cierre = model('cierreModel')->select('fecha')->where('idapertura', $id_apertura['idapertura'])->first();
        $cierre = $fecha_cierre['fecha'];

        $fecha_y_hora_cierre = model('cierreModel')->select('fecha_y_hora_cierre')->where('idapertura', $id_apertura['idapertura'])->first();
        $efectivo = model('pagosModel')->selectSum('efectivo')->where('id_apertura', $id_apertura['idapertura'])->findAll();
        if (empty($efectivo)) {
            $ingresos_efectivo = 0;
        } else if (!empty($efectivo)) {
            $ingresos_efectivo = $efectivo[0]['efectivo'];
        }

        $transaccion = model('pagosModel')->selectSum('transferencia')->where('id_apertura', $id_apertura['idapertura'])->findAll();
        if (empty($transaccion)) {
            $ingresos_transaccion = 0;
        } else if (!empty($transaccion)) {
            $ingresos_transaccion = $transaccion[0]['transferencia'];
        }
        $valor_cierre = 0;
        $devolucion_venta = model('devolucionModel')->sumar_devoluciones($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_cierre['fecha_y_hora_cierre']);


        if (empty($devolucion_venta)) {
            $devoluciones = 0;
        } else if (!empty($devolucion_venta)) {
            $devoluciones = $devolucion_venta[0]['total_devoluciones'];
        }
        $id_cierre = model('cierreModel')->select('id')->where('idapertura', $id_apertura['idapertura'])->first();
        $efectivo = model('cierreFormaPagoModel')->cierre_efectivo($id_cierre['id']);
        $transaccion = model('cierreFormaPagoModel')->cierre_transaccion($id_cierre['id']);

        if (!empty($efectivo)) {
            $efectivo_cierre = $efectivo[0]['valor'];
        }
        if (empty($efectivo)) {
            $efectivo_cierre = 0;
        }
        if (empty($transaccion)) {
            $transaccion_cierre = 0;
        }
        if (!empty($transaccion)) {
            $transaccion_cierre = $transaccion[0]['valor'];
        }

        $total_retiros = model('retiroFormaPagoModel')->total_retiros($fecha_y_hora_apertura['fecha_y_hora_apertura'], $fecha_y_hora_cierre['fecha_y_hora_cierre']);

        if (empty($total_retiros[0]['total_retiros'])) {
            $retiros = 0;
        }
        if (!empty($total_retiros[0]['total_retiros'])) {
            $retiros = $total_retiros[0]['total_retiros'];
        }


        $temp_propinas = model('pagosModel')->selectSum('propina')->where('id_apertura', $id_apertura['idapertura'])->findAll();
        $propinas = $temp_propinas[0]['propina'];
        $diferencia =  (($ingresos_transaccion + $ingresos_efectivo + $valor_apertura['valor']) - ($retiros + $devoluciones)) - ($efectivo_cierre + $transaccion_cierre);




        return view('consultas_y_reportes/datos_consultas_caja', [
            'estado' => $estado,
            'fecha_apertura' => $fecha_apertura['fecha'],
            'fecha_cierre' => $cierre,
            'valor_apertura' => "$" . number_format($valor_apertura['valor'], 0, ",", "."),
            'ingresos_efectivo' =>  "$" . number_format(($ingresos_efectivo + $ingresos_transaccion) - $propinas, 0, ",", "."),
            'ingresos_transaccion' =>  "$" . number_format($ingresos_transaccion, 0, ",", "."),
            'total_ingresos' =>  "$" . number_format(($ingresos_transaccion + $ingresos_efectivo) + $valor_apertura['valor'], 0, ",", "."),
            'efectivo_cierre' => "$" . number_format($efectivo_cierre, 0, ",", "."),
            'transaccion_cierre' => "$" . number_format($transaccion_cierre, 0, ",", "."),
            'total_cierre' => "$" . number_format($efectivo_cierre + $transaccion_cierre, 0, ",", "."),
            'devoluciones' => "$" . number_format($devoluciones, 0, ",", "."),
            'retiros' => "$" . number_format($retiros, 0, ",", "."),
            'propinas' => "$" . number_format($propinas, 0, ",", "."),
            'retirosmasdevoluciones' => "$" . number_format($retiros + $devoluciones, 0, ",", "."),
            'saldo_caja' => "$" . number_format(($valor_apertura['valor'] + $ingresos_efectivo + $ingresos_transaccion) - ($retiros + $devoluciones), 0, ",", "."),
            'diferencia' => "$" . number_format($diferencia, 0, ",", "."),
            'id_apertura' => $id_apertura['idapertura'],
            'estado' => 1
        ]);
    }



    public function data_table_reporte_costo()
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
            $sub_array[] = number_format($costo[0]['costo'], 0, ",", ".");
            $sub_array[] = number_format($detalle['total_documento'] - ($iva[0]['iva'] + $inc[0]['ico']), 0, ",", ".");
            $sub_array[] = number_format($iva[0]['iva'], 0, ",", ".");
            $sub_array[] = number_format($inc[0]['ico'], 0, ",", ".");


            $data[] = $sub_array;
        }
        $total_venta = model('pagosModel')->selectSum('total_documento')->where('id_apertura', $apertura)->findAll();
        $base_iva_19 = model('kardexModel')->selectSum('iva')->where('valor_iva', 19)->findAll();
        if (empty($base_iva_19[0]['iva'])) {
            $base_iva_019 = 0;
            $iva_19=0;
        }
        if (!empty($base_iva_19[0]['iva'])) {
            $base_iva_019 = $total_venta[0]['total_documento'] - $base_iva_19[0]['iva'];
        }



        $json_data = [
            'draw' => intval($this->request->getGEt(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,
            'total_venta' => number_format($total_venta[0]['total_documento'], 0, ",", "."),
            'base_iva_19' => number_format($base_iva_019, 0, ",", "."),
            'iva_19'=>0
            
        ];

        echo  json_encode($json_data);
    }
}
