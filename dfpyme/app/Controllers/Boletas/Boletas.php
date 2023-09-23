<?php

namespace App\Controllers\Boletas;

use App\Controllers\BaseController;

require APPPATH . "Controllers/phpqrcode/qrlib.php";

use QRcode;



class Boletas extends BaseController
{
    public function boletas()
    {

        $localidad = model('localidadModel')->where('estado',true)->findAll();
        return view('boletas/boletas', [
            'localidad' => $localidad
        ]);
    }


    function set_boletas()
    {



        if (!$this->validate([
            'clientes_factura_pos' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'localidad' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $nombre_localidad = model('localidadModel')->select('nombre')->where('id', $_POST['localidad'])->first();



        $data = [

            'nitcliente' => $_POST['id_cliente_factura_pos'],
            'fecha_generacion' => date('Y-m-d'),
            'hora_generacion' => date("H:i:s"),
            'estado' => 'Generada',
            'fecha_ingreso' => date('Y-m-d'),
            'hora_ingreso' => date("H:i:s"),
            'observaciones' => '',
            'localidad' => $nombre_localidad['nombre']
        ];


        $insert = model('BoletasModel')->insert($data);


        //$ultimoID = model('BoletasModel')->insertID();

        $ultimoID = (string) model('BoletasModel')->insertID();

        $qrtext = $ultimoID;

        $path = 'images/';
        $qrcode = $path .  $qrtext . ".png";
        $qrimage = time() . ".png";

        $model = model('boletasModel');
        $numero_factura = $model->set('nombre_qr', $qrtext . ".png");
        $numero_factura = $model->where('id', $ultimoID);
        $numero_factura = $model->update();


        if ($_POST['localidad'] != "General") {
            /* $borrar_localidad = model('localidadModel')->where('id', $_POST['localidad']);
            $borrar_localidad->delete(); */

            $num_fact = model('localidadModel');
            $numero_factura = $num_fact->set('estado', 'f');
            $numero_factura = $num_fact->where('id', $_POST['localidad']);
            $numero_factura = $num_fact->update();
        }



        QRcode::png($qrtext, $qrcode, 'H', 10, 10);



        return view('boletas/listado');
    }


    function consultar_boleta()
    {
        return view('boletas/consultar_codigo');
    }


    function cliente()
    {


        $data = [
            'nitcliente' => $this->request->getPost('cedula'),
            'idregimen' => 2,
            'nombrescliente' => $this->request->getPost('nombre'),
            'telefonocliente' => $this->request->getPost('telefono'),
            'celularcliente' => $this->request->getPost('telefono'),
            'emailcliente' => "",
            'idciudad' => 317,
            'direccioncliente' => "",
            'estadocliente' => true,
            'idtipo_cliente' => 1,
            'punto' => 0,
            'id_clasificacion' => 1
        ];


        $insert = model('clientesModel')->insert($data);


        $returnData = array(
            "resultado" => 1, //Falta plata 
            "nit_cliente" => $this->request->getPost('cedula'),
            "nombre_cliente" => $this->request->getPost('nombre')
        );
        echo  json_encode($returnData);
    }
}
