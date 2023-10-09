<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;


class Inventarios extends BaseController
{
    public function ingreso()
    {
        return view('inventarios/ingreso');
    }

    function ingreso_inventario()
    {
        $codigo_producto = $this->request->getPost('id_producto');
        $cantidad = $this->request->getPost('cantidad');

        $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $codigo_producto)->first();

        $actualizar = model('inventarioModel')->set('cantidad_inventario', $cantidad_inventario['cantidad_inventario'] + $cantidad)->where('codigointernoproducto', $codigo_producto)->update();

        if ($actualizar) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('producto/lista_de_productos'))->with('mensaje', 'Ingreso de producto éxitoso');
        }
    }

    function buscar(){
        $producto = $this->request->getPost('valor');

   
        $productos = model('inventarioModel')->producto($producto);

        $returnData = array(
            "resultado" => 1,
            'productos'=>view('pedido/productos',[
                'productos'=>$productos
            ])
        );
        echo  json_encode($returnData);

    }
}
