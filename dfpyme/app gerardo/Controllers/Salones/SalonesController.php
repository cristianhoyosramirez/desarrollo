<?php

namespace App\Controllers\Salones;

use App\Controllers\BaseController;

class SalonesController extends BaseController
{
    /**
     * Consulta los registros de la tablas salones , datos correspondientes a la informacion de los salones
     */
    public function index()
    {
        $salones = model('salonesModel')->orderBy('id', 'asc')->find();
        return view('salones/listado', [
            'salones' => $salones
        ]);
    }
    /**
     * Formulario para obtener informacion de un nuevo salon 
     */
    public function datos_iniciales()
    {
        return view('salones/datos_iniciales');
    }
    /**
     * Relacion de salones y mesas 
     */
    public function salones()
    {

        $salones = model('salonesModel')->orderBy('id', 'asc')->find();
        $categorias = model('categoriasModel')->where('permitir_categoria', true)->find();

        return view('salones/salones', [
            'salones' => $salones,
            'categorias' => $categorias
        ]);
    }

    /***
     * Consulta de los salones creados 
     * @param $id_salon{integer} 
     * devuelve la vista salones/mesas con las mesas correspondiente al $id_salon
     */
    public function salon_mesas()
    {

        $id_salon = $_POST['id_salon'];

        //$mesas_salon = model('mesasModel')->where('fk_salon', $id_salon)->orderBy('id', 'asc')->findAll();
        $mesas_salon = model('mesasModel')->mesas_salon($id_salon);

        if (!empty($mesas_salon)) {

            $mesas = view('salones/mesas', [
                'mesas' => $mesas_salon
            ]);
            $returnData = array(
                "mesas" => $mesas,
                "resultado" => 1,


            );
            echo  json_encode($returnData);
        } else {
            $returnData = array(
                "resultado" => 0
            );
            echo  json_encode($returnData);
        }
    }


    public function save()
    {
        if (!$this->validate([
            'nombre' => [
                'rules' => 'required|is_unique[salones.nombre]',
                'errors' => [
                    'required' => 'Dato necesario',
                    'is_unique' => 'Registro duplicado'
                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre' => $this->request->getVar('nombre'),
        ];
        $insert = model('salonesModel')->insert($data);
        if ($insert) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('salones/list'))->with('mensaje', 'Creación correcta');
        } else {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'error');
            return redirect()->to(base_url('salones/list'))->with('mensaje', 'Hubo errores');
        }
    }

    public function editar()
    {
        $id = $_POST['id'];
        $salon = model('salonesModel')->where('id', $id)->first();
        $nombre_salon = $salon['nombre'];
        $id_salon = $salon['id'];
        return view('salones/editar', [
            'id_salon' => $id_salon,
            'nombre_salon' => $nombre_salon,
        ]);
    }
    public function actualizar()
    {
        if (!$this->validate([
            'id' => [
                'rules' => 'required|is_not_unique[salones.id]',
                'errors' => [
                    'is_unique' => 'Registro no válido'
                ]
            ],
            'nombre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $id = $_POST['id'];
        $nombre = model('salonesModel')->select('nombre')->where('id =', $id)->first();
        $existe_nombre = model('salonesModel')->select('nombre')->where('id !=', $id)->find();

      /*   foreach ($existe_nombre as $detalle) {
            if ($detalle['nombre'] == $nombre['nombre']) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'error');
                return redirect()->to(base_url('salones/list'))->with('mensaje', 'Nombre de salon ya existe');
            }
        } */
        $data = [
            'nombre' => $this->request->getVar('nombre'),
        ];
        $id = trim($this->request->getVar('id'));
        $model = model('salonesModel');
        $actualizar = $model->set($data);
        $actualizar = $model->where('id', $id);
        $actualizar = $model->update();
        if ($actualizar) {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('salones/list'))->with('mensaje', 'Actualización correcta');
        } else {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'error');
            return redirect()->to(base_url('salones/listado'))->with('mensaje', 'HUBO ERRORES DURANTE LA ACTUALIZACIÓN');
        }
    }
}
