<?php

namespace App\Controllers\configuracion;

use App\Controllers\BaseController;

class Configuracion extends BaseController
{
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

    function propina(){
        return view('configuracion/propina');
    }

    function configuracion_propina(){
        $valor = $this->request->getPost('propina');

        $model = model('configuracionPedidoModel');
        $configuracion = $model->set('propina', $valor);
        $configuracion = $model->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('pedidos/mesas'))->with('mensaje', 'Configuración de propina correcta ');
    }
}
