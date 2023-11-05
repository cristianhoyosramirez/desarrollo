<?php

namespace App\Controllers\login;

use App\Controllers\BaseController;

class loginController extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    public function login()
    {

        if (!$this->validate([
            'pin' => [
                'rules' => 'required|is_not_unique[usuario_sistema.pinusuario_sistema]|max_length[4]',
                'errors' => [
                    'required' => 'El pin es requerido',
                    'is_not_unique' => 'Pin inexistente',
                    'max_length'=>'Longitud máxima de 4 digitos'

                ]
            ],

        ])) {
            return redirect()->to(base_url('/'))->withInput()->with('errors', $this->validator->getErrors());
        }


        $pin = $this->request->getVar('pin');
        $usuario = model('usuariosModel')->select('*')->where('pinusuario_sistema', $pin)->first();
        $tipo_permiso=model('tipoPermisoModel')->select('*')->where('idusuario_sistema',$usuario['idusuario_sistema'])->find();

        if ($usuario) {
            $datosSesion = [
                'id_usuario' => $usuario['idusuario_sistema'],
                'usuario' => $usuario['usuariousuario_sistema'],
                'nombre_usuario' => $usuario['nombresusuario_sistema'],
                'logged_in' => TRUE,
                'tipo'=>$usuario['idtipo'],
                'tipo_permiso'=>$tipo_permiso
            ];
            $sesion = session();
            $sesion->set($datosSesion);
            return redirect()->to(base_url('mesas/todas_las_mesas'));
        } else {
            $datosSesion = [
                'id_usuario' => $usuario['idusuario_sistema'],
                'usuario' => $usuario['usuariousuario_sistema'],
                'nombre_usuario' => $usuario['nombresusuario_sistema'],
                'logged_in' => FALSE,
                'tipo'=>$usuario['idtipo']
            ];
            $sesion = session();
            $sesion->set($datosSesion);
            return redirect()->to(base_url('/'))->withInput()->with('errors', $this->validator->getErrors());
        }
    }
    public function closeSesion()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url() . '/');
    }
}
