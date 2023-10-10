<?php

namespace App\Controllers\ingresos;

use App\Controllers\BaseController;

class Ingresos extends BaseController
{
    public function set_ingreso()
    {
        $data = [
            'fecha' => date('Y-m-d'),
            'id_usuario' => $this->request->getPost('id_usuario'),
            'valor' => $this->request->getPost('valor'),
            'concepto' => $this->request->getPost('concepto')
        ];

        $insert = model('Ingresos')->insert($data);

        if ($insert) {
            $user_session = session();
            $user_session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('home'))->with('mensaje', 'Ingreso creado ');
        }
    }
    public function set_egresos()
    {
        $data=['fecha'=>date('Y-m-d'),
        'hora',
        'fecha_y_hora',
        'id_usuario',
        'id_apertura',
        'valor'];

        /* $insert = model('Gastos')->insert($data);

        if ($insert) {
            $user_session = session();
            $user_session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url('home'))->with('mensaje', 'Gasto creado ');
        } */
    }
}
