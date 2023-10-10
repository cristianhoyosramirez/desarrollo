<?php

namespace App\Controllers\cobrador;
use App\Controllers\BaseController;

class Cobrador extends BaseController
{
    public function index()
    {
        //return view('welcome_message');
        //return view('login/login');
        return view('home/home');
    }

    function apertura(){
        $cobradores=model('Usuario')->cobradores();
        return view('cobrador/apertura',[
            'cobradores'=>$cobradores
        ]);
    }

    function generar_apertura(){
        $data=[
              'id_cobrador'=>$this->request->getPost('id_cobrador'),
              'valor_apertura'=>$this->request->getPost('base'),
              'fecha_apertura'=>date('Y-m-d'),
              'hora_apertura'=>date('Y-m-d'),
              'hora_y_hora_apertura'=>date('Y-m-d')
        ];
  
       

    }

    function ingresos(){

        $returnData = array(
            "resultado" => 1,
            "cliente" => view('clientes/detalle')
          );
          echo  json_encode($returnData);

    }

}
