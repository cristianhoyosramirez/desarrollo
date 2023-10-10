<?php

namespace App\Controllers\terceros;

use App\Controllers\BaseController;

class Terceros extends BaseController
{

  public $db;

  public function __construct()
  {

    $this->db = \Config\Database::connect();
  }
  public function index()
  {
    return view('terceros/terceros');
  }


  function cargar_modal()
  {
    $operacion = $this->request->getPost('operacion');
    if ($operacion == 1) {
      $returnData = array(
        "resultado" => 1,
        "datos" => view('terceros/formularios/crear_tercero'), //Carga un formulario de solo creacion y lo pega en el modal  ,

      );
      echo  json_encode($returnData);
    }
  }

  function getTerceros()
  {

    $valor_buscado = $_POST['search']['value'];;

    $table_map = [
      0 => 'id',
      1 => 'numero_identificacion',
      2 => 'nombres',
      3 => 'direccion',
    ];

    $sql_count = "SELECT count(id) as total from terceros";

    $sql_data = "SELECT
            id,
            numero_identificacion,
            nombres,
            direccion
         FROM
            terceros";
    $condition = "";



    if (!empty($valor_buscado)) {

      $condition .= " WHERE nombres LIKE '%" . $valor_buscado . "%'";
    }

    $sql_count = $sql_count . $condition;
    $sql_data = $sql_data . $condition;
 
    $total_count = $this->db->query($sql_count)->getRow();

    $sql_data .= " ORDER BY " . $table_map[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " " . "LIMIT " . $_POST['length'] . " OFFSET " . $_POST['start'];

    $datos = $this->db->query($sql_data)->getResultArray();

    foreach ($datos as $detalle) {
      $sub_array = array();
      $sub_array[] = $detalle['numero_identificacion'];
      $sub_array[] = $detalle['nombres'];
      $sub_array[] = $detalle['direccion'];
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

  function crearTerceros()
  {
    if (!$this->validate([
      'tipos_de_identificacion' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
      'identificacion' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
      'nombre' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
      'direccion' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
      'telefono' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
    ])) {
      $errors = $this->validator->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {

      $data = [
        'tipo_identificacion' => $this->request->getPost('tipos_de_identificacion'),
        'numero_identificacion' => $this->request->getPost('identificacion'),
        'nombres' => $this->request->getPost('nombre'),
        'direccion' => $this->request->getPost('direccion'),
        'telefono' => $this->request->getPost('telefono'),
      ];

     
      $insert = model('Tercero')->insert($data);
      if ($insert) {
        echo json_encode(['code' => 1, 'msg' => 'Ruta creada']);
      } else {
        echo json_encode(['code' => 0, 'msg' => 'No se pudo crear la ruta ']);
      }
    }
  }
}
