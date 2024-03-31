<?php

namespace App\Controllers\administracion_impresora;

use App\Controllers\BaseController;

class impresionFacturaController extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    public function impresion_factura()
    {
        $impresoras = model('impresorasModel')->select('*')->find();
        $id_impresora = model('impresionFacturaModel')->select('id_impresora')->first();

        if (!empty($id_impresora)) {
            return view('impresion_factura/impresion_factura', [
                'impresoras' => $impresoras,
                'id_impresora' => $id_impresora['id_impresora']
            ]);
        } else {
            return view('impresion_factura/asignar_impresora', [
                'impresoras' => $impresoras,
                'resultado' => 0
            ]);
        }
    }

    public function asignar_impresora_facturacion()
    {
        $id_impresora = $_POST['id_impresora'];

        $fk_impresora = model('impresionFacturaModel')->select('id_impresora')->first();

        if (!empty($fk_impresora['id_impresora'])) {
            $data = [
                'id_impresora' =>  $id_impresora
            ];


            $impresor = model('impresionFacturaModel');
            $impresora = $impresor->set($data);
            $impresora = $impresor->where('id', 1);
            $impresora = $impresor->update();

            if ($impresora) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url('administracion_impresora/impresion_factura'))->with('mensaje', 'Asignacion de impresora para apertura de cajon correcta ');
            } else {
            }
        }
        if (empty($fk_impresora['id_impresora'])) {
            $data = [
                'id_impresora' => $id_impresora
            ];
            $insert = model('impresionFacturaModel')->insert($data);
            if ($insert) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url('administracion_impresora/impresion_factura'))->with('mensaje', 'Asignacion de impresora para apertura de cajon correcta ');
            }
        }
    }

    function configuracion_pedido()
    {
        $configuracion_pedido = model('configuracionPedidoModel')->select('agregar_item')->first();
        return view('caja/configuracion_pedido', [
            'configuracion' => $configuracion_pedido['agregar_item']
        ]);
    }

    function actualizar_configuracion_pedido()
    {
        $estado = $this->request->getPost('actualizar_pedido');

        $pedidos = model('pedidoModel')->findAll();

        if (empty($pedidos)) {

            $data = [
                'agregar_item' => $estado
            ];

            $num_fact = model('configuracionPedidoModel');
            $numero_factura = $num_fact->set($data);
            $numero_factura = $num_fact->where('id', 1);
            $numero_factura = $num_fact->update();

            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('pedidos/mesas'))->with('mensaje', 'Actualizacion correcta ');
        } else if (!empty($pedidos)) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'info');
            return redirect()->to(base_url('pedidos/mesas'))->with('mensaje', 'Antes de realizar esta accion primero se deben de cerrar los pedidos actuales ');
        }
    }
}
