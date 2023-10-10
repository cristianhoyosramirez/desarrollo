<?php

namespace App\Controllers\rutas;

use App\Controllers\BaseController;

class Rutas extends BaseController
{
    public $db;

    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return view('rutas/rutas');
    }
    function crearRuta()
    {

        if (!$this->validate([
            'nombre' => [
                'rules' => 'required|is_unique[rutas.nombre]',
                'errors' => [
                    'required' => 'Dato requerido',
                    'is_unique'=>'Registro ya existe'
                ],
            ],
        ])) {
            $errors = $this->validator->getErrors();
            echo json_encode(['code' => 0, 'error' => $errors]);
        } else {

            $data = [
                'nombre' => $this->request->getPost('nombre'),
            ];

            $insert = model('rutas')->insert($data);
            if ($insert) {
                echo json_encode(['code' => 1, 'msg' => 'Ruta creada']);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'No se pudo crear la ruta ']);
            }
        }
    }

    function getRutas()
    {

        $valor_buscado = $_POST['search']['value'];;

        $table_map = [
            0 => 'nombre',
            1 => 'cuentas_activas',
            2 => 'cuentas_atrasadas',
            3 => 'cuentas_al_dia',
        ];

        $sql_count = "SELECT count(id) as total from rutas";

        $sql_data = "SELECT
            nombre,
            cuentas_activas,
            cuentas_atrasadas,
            cuentas_al_dia
         FROM
            rutas";
        $condition = "";



        if (!empty($valor_buscado)) {

            $condition .= "'%" . $valor_buscado . "%'";
        }

        $sql_count = $sql_count . $condition;
        $sql_data = $sql_data . $condition;

        $total_count = $this->db->query($sql_count)->getRow();

        // $sql_data .= " ORDER BY " . $table_map[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " " . "LIMIT " . $_POST['length'] . " OFFSET " . $_POST['start'];
        $sql_data .= " ORDER BY " . $table_map[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " " . "LIMIT " . $_POST['length'] . " OFFSET " . $_POST['start'];

        $datos = $this->db->query($sql_data)->getResultArray();

        foreach ($datos as $detalle) {
            $sub_array = array();

            $sub_array[] = $detalle['nombre'];
            //$sub_array[] = $detalle['cuentas_activas'];
            //$sub_array[] = $detalle['cuentas_atrasadas'];
            //$sub_array[] = $detalle['cuentas_al_dia'];
            //$sub_array[] = '<a  class="btn btn-green w-100 "  onclick="pr()"  >Editar</a>  <a   class="btn btn-red w-100 " >Delete</a>';
            $sub_array[] = '   <div class="col-12">
            <div class="row  align-items-center">
              <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                <a href="#" class="btn btn-green w-100">
                  Editar
                </a>
              </div>
              <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
                <a href="#" class="btn btn-red w-100">
                  Eliminar
                </a>
              </div>

            </div>
          </div>';
            $data[] = $sub_array;
        }

        $json_data = [
            'draw' => intval($this->request->getPost(index: 'draw')),
            'recordsTotal' => $total_count->total,
            'recordsFiltered' => $total_count->total,
            'data' => $data,

        ];
        echo  json_encode($json_data);
    }
}
