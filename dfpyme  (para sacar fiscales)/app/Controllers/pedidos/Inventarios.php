<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;


class Inventarios extends BaseController
{
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

    /*  function exportar_inventario()
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

        $options = $dompdf->getOptions();
        $dompdf->setPaper('letter');
        $dompdf->render();
        $dompdf->loadHtml(view('producto/pdf',));
        $dompdf->stream("Reporte de productos.pdf", array("Attachment" => true));
    } */

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
}
