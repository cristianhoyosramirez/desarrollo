<?php

namespace App\Controllers\reportes;

require APPPATH . "Controllers/mike42/autoload.php";

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        //$fecha_inicial = $this->request->getPost('fecha_inicial');
        $fecha_inicial = '2023-11-16';
        //$fecha_final = $this->request->getPost('fecha_final');
        $fecha_final = '2023-11-16';



        //$id_facturas_pos = model('pagosModel')->get_id_pos($fecha_inicial, $fecha_final);
        $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
        //$id_facturas_electronicas = model('pagosModel')->get_id_electronicas($fecha_inicial, $fecha_final);
    
        $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
        $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
        $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);

        $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);

        if (!empty($id_facturas)) {
            $returnData = [
                'resultado' => 1, //No hay resultados
                'datos' => view('consultas/tabla_costos', [
                    'id_facturas' => $id_facturas,
                    'total_costo' => $total_costo[0]['total_costo'],
                    'total_ico' => $total_ico[0]['total_ico'],
                    'total_iva' => $total_iva[0]['total_iva'],
                    'total_venta' => $total_venta[0]['total_venta'],
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
        //$fecha_inicial = '2023-11-01';
        $fecha_final = $this->request->getPost('fecha_final');
        //$fecha_final = '2023-11-08';



        //$id_facturas_pos = model('pagosModel')->get_id_pos($fecha_inicial, $fecha_final);
        $id_facturas = model('pagosModel')->get_id($fecha_inicial, $fecha_final);
        //$id_facturas_electronicas = model('pagosModel')->get_id_electronicas($fecha_inicial, $fecha_final);

        $total_costo = model('pagosModel')->get_costo_total($fecha_inicial, $fecha_final);
        $total_ico = model('pagosModel')->get_ico_total($fecha_inicial, $fecha_final);
        $total_iva = model('pagosModel')->get_iva_total($fecha_inicial, $fecha_final);
        $total_venta = model('pagosModel')->get_venta_total($fecha_inicial, $fecha_final);

        if (!empty($id_facturas)) {
            $returnData = [
                'resultado' => 1, //No hay resultados
                'datos' => view('consultas/tabla_ventas', [
                    'id_facturas' => $id_facturas,
                    'total_costo' => $total_costo[0]['total_costo'],
                    'total_ico' => $total_ico[0]['total_ico'],
                    'total_iva' => $total_iva[0]['total_iva'],
                    'total_venta' => $total_venta[0]['total_venta'],
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
                "base_ico"=>number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                "base_iva"=>number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "total_impuesto"=>number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
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
            return redirect()->to(base_url('reportes/reporte_ventas'))->with('mensaje', 'No hay datos para el rango de fechas  ');
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
                "base_ico"=>"$ " . number_format($total_venta[0]['total_venta'] - ($total_ico[0]['total_ico']), 0, ",", "."),
                "base_iva"=>"$ " . number_format($total_venta[0]['total_venta'] - ($total_iva[0]['total_iva']), 0, ",", "."),
                "total_impuesto"=>"$ " . number_format(($total_ico[0]['total_ico'] + $total_iva[0]['total_iva']), 0, ",", ".")
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

    function editar_apertura()
    {

        $id_apertura = $this->request->getPost('id_apertura');
        $returnData = [
            'resultado' => 1,

        ];
        echo json_encode($returnData);
    }
}
