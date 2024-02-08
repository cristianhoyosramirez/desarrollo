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
        return view('configuracion/sub_categoria', [
            'sub_categorias' => $sub_categorias
        ]);
    }

    function editar_sub_categoria()
    {
        $id_categoria = $this->request->getPost('valor');

        $subcategoria = model('subCategoriaModel')->where('id', $id_categoria)->first();

        $returnData = array(
            "resultado" => 1,
            "subcategoria" => view('configuracion/editar_sub_categoria', [
                'subcategoria' => $subcategoria
            ])

        );
        echo  json_encode($returnData);
    }


    function actualizar_sub_categoria()
    {
        $id_categoria = $this->request->getPost('valor');
        //$id_categoria = 'true';
        $nombre = $this->request->getPost('nombre');

        $model = model('subCategoriaModel');
        $actualizar = $model->set('nombre', $nombre);
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

    function tipos_de_factura(){

       // $facturas=model('estadoModel')->find()->orderBy('orden','asc');
        $facturas=model('estadoModel')->orderBy('orden','asc')->find();

    
        return view('tipos_de_factura/facturas',[
            'tipo_factura'=>$facturas
        ]);
    }
}
