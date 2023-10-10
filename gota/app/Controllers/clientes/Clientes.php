<?php

namespace App\Controllers\clientes;

use App\Controllers\BaseController;

class Clientes extends BaseController
{
  public $db;

  public function __construct()
  {

    $this->db = \Config\Database::connect();
  }

  public function index()
  {

    $clientes = model('Cliente')->clientes($this->request->getPost('usuario'));


    $returnData = array(
      "resultado" => 1,
      "clientes" => view('clientes/listado', [
        'clientes' => $clientes
      ])
    );
    echo  json_encode($returnData);
  }
  function getClientes()
  {

    $valor_buscado = $_POST['search']['value'];;

    $table_map = [
      0 => 'id',
      1 => 'numero_identificacion',
      2 => 'nombres'
    ];

    $sql_count = "SELECT count(id) as total from cliente";

    $sql_data = "SELECT
                  cliente.id as id ,
                  terceros.nombres as nombre,
                  terceros.numero_identificacion as identificacion 
                FROM
                  cliente
                INNER JOIN terceros ON terceros.id = cliente.id_tercero";
    $condition = "";


    if (!empty($valor_buscado)) {

      $condition .= "'%" . $valor_buscado . "%'";
    }

    $sql_count = $sql_count . $condition;
    $sql_data = $sql_data . $condition;

    $total_count = $this->db->query($sql_count)->getRow();

    $sql_data .= " ORDER BY " . $table_map[$_POST['order'][0]['column']] . " " . $_POST['order'][0]['dir'] . " " . "LIMIT " . $_POST['length'] . " OFFSET " . $_POST['start'];

    $datos = $this->db->query($sql_data)->getResultArray();

    foreach ($datos as $detalle) {
      $sub_array = array();

      $sub_array[] = $detalle['id'];
      $sub_array[] = $detalle['nombre'];
      $sub_array[] = $detalle['identificacion'];

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


 
  function crear_cliente()
  {
    if (!$this->validate([
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
      /*  'foto_dni' => [
        'rules' => 'uploaded[foto_dni]|mime_in[foto_dni,image/jpg,image/jpeg,image/gif,image/png]',
        'errors' => [
          'uploaded' => 'Dato requerido',
          'mime_in' => 'No es una foto '
        ],
      ],
      'foto_servicio_publico' => [
        'rules' => 'uploaded[foto_servicio_publico]|mime_in[foto_servicio_publico,image/jpg,image/jpeg,image/gif,image/png]',
        'errors' => [
          'uploaded' => 'Dato requerido',
          'mime_in' => 'No es una foto '
        ],
      ],
      'foto_negocio' => [
        'rules' => 'uploaded[foto_negocio]|mime_in[foto_negocio,image/jpg,image/jpeg,image/gif,image/png]',
        'errors' => [
          'uploaded' => 'Dato requerido',
          'mime_in' => 'No es una foto '
        ],
      ], */



    ])) {
      $errors = $this->validator->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {

      $foto_dni = $this->request->getFile('foto_dni');
      $foto_cliente = $this->request->getFile('foto_cliente');
      $foto_casa = $this->request->getFile('foto_casa');
      $foto_negocio = $this->request->getFile('foto_negocio');
      $foto_servicio_publico = $this->request->getFile('foto_servicio_publico');

      $id_tercero = "";
      $id = model('Tercero')->select('id')->where('numero_identificacion', $this->request->getVar('identificacion'))->first();



      if (empty($id['id'])) {  //El tercero no esta creado por ende se inserta el tabla terceros y se crea el cliente 

        $data_terceros = [
          'tipo_identificacion' => 1,
          'numero_identificacion' => $this->request->getVar('identificacion'),
          'nombres' => $this->request->getVar('nombre'),
          'direccion' => $this->request->getVar('direccion'),
          'telefono' => $this->request->getVar('telefono'),
          'email' => $this->request->getVar('email'),
          'estado' => 1
        ];
        $insert = model('Tercero')->insert($data_terceros);
        $id_tercero = model('Tercero')->insertID;

        $data = [
          'id_tercero' => $id_tercero,
          'telefono_de_contacto' => $this->request->getVar('telefono'),
          'referencia_personal' => $this->request->getVar('referencia'),
          'estado' => 1,
          'id_usuario' => $this->request->getPost('id_usuario'),
          'direccion_negocio' => $this->request->getPost('direccion_negocio'),
          'telefono_negocio' => $this->request->getPost('telefono_negocio')
        ];

        $insert = model('Cliente')->insert($data);

        $id_cliente = model('Cliente')->insertID;



        /* if ($foto_dni->isValid()) {
          $newName =  $id_tercero . "." . $foto_dni->getExtension();
          //$ruta_imagen = base_url() . '/public/img/dni/'  . $newName;
          $ruta_imagen = base_url() . '/images/dni/'  . $newName;

          $foto_dni->move('images/dni', $newName);
          $data = [
            'imagen_dni' => $newName
          ];
          $model = model('Cliente');
          $dni = $model->set($data);
          $dni = $model->where('id', $id_cliente);
          $dni = $model->update();
        }


        if ($foto_cliente->isValid()) {
          $newName =  $id_tercero . "." . $foto_cliente->getExtension();
          $ruta_imagen = base_url() . 'images/clientes'  . $newName;
          $foto_cliente->move('images/clientes', $newName);

          $data = [
            'imagen_cliente' => $newName
          ];
          $model = model('Cliente');
          $dni = $model->set($data);
          $dni = $model->where('id', $id_cliente);
          $dni = $model->update();
        }

        if ($foto_casa->isValid()) {
          $newName =  $id_tercero . "." . $foto_casa->getExtension();
          $ruta_imagen = base_url() . '/images/casa/'  . $newName;
          $foto_casa->move('images/casa', $newName);

          $data = [
            'imagen_casa' => $newName
          ];
          $model = model('Cliente');
          $dni = $model->set($data);
          $dni = $model->where('id', $id_cliente);
          $dni = $model->update();
        }

        if ($foto_negocio->isValid()) {
          $newName =  $id_tercero . "." . $foto_negocio->getExtension();
          $ruta_imagen = base_url() . '/images/negocio/'  . $newName;


          $foto_negocio->move('images/negocio', $newName);

          $data = [
            'imagen_negocio' => $newName
          ];
          $model = model('Cliente');
          $dni = $model->set($data);
          $dni = $model->where('id', $id_cliente);
          $dni = $model->update();
        }


        if ($foto_servicio_publico->isValid()) {
          $newName =  $id_tercero . "." . $foto_servicio_publico->getExtension();
          $ruta_imagen = base_url() . '/images/servicio/'  . $newName;

          $file_headers = @get_headers($ruta_imagen);
          if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            $foto_servicio_publico->move('images/servicio', $newName);
          }

          $data = [
            'imagen_servicio' => $newName
          ];
          $model = model('Cliente');
          $dni = $model->set($data);
          $dni = $model->where('id', $id_cliente);
          $dni = $model->update();
        } */

        $clientes = model('Cliente')->clientes($this->request->getPost('id_usuario'));

        $returnData = array(
          "code" => 1,
          "clientes" => view('clientes/listado', [
            'clientes' => $clientes
          ]),
          'id_cliente' => $id_cliente
        );
        echo  json_encode($returnData);
      } else if (!empty($id['id'])) {

        $existe_cliente = model('Cliente')->select('id')->where('id_tercero', $id['id'])->first();

        if (empty($existe_cliente)) {

          $data = [
            'id_tercero' => $id['id'],
            'telefono_de_contacto' => $this->request->getVar('telefono'),
            'referencia_personal' => $this->request->getVar('referencia'),
            'estado' => 1,
            'id_usuario' => $this->request->getPost('id_usuario'),
            'direccion_negocio' => $this->request->getPost('direccion_negocio'),
            'telefono_negocio' => $this->request->getPost('telefono_negocio')
          ];

          $insert = model('Cliente')->insert($data);


         /*  if ($foto_dni->isValid()) {
            $newName =  $id['id'] . "." . $foto_dni->getExtension();
            //$ruta_imagen = base_url() . '/public/img/dni/'  . $newName;
            $ruta_imagen = base_url() . '/images/dni/'  . $newName;



            $foto_dni->move('images/dni', $newName);
            $data = [
              'imagen_dni' => $newName
            ];
            $model = model('Cliente');
            $dni = $model->set($data);
            $dni = $model->where('id_tercero', $id['id']);
            $dni = $model->update();
          }


          if ($foto_cliente->isValid()) {
            $newName =  $id['id'] . "." . $foto_cliente->getExtension();
            $ruta_imagen = base_url() . 'images/clientes'  . $newName;
            $foto_cliente->move('images/clientes', $newName);

            $data = [
              'imagen_cliente' => $newName
            ];
            $model = model('Cliente');
            $dni = $model->set($data);
            $dni = $model->where('id_tercero', $id['id']);
            $dni = $model->update();
          }
          if ($foto_casa->isValid()) {
            $newName =  $id['id'] . "." . $foto_casa->getExtension();
            $ruta_imagen = base_url() . '/images/casa/'  . $newName;
            $foto_casa->move('images/casa', $newName);

            $data = [
              'imagen_casa' => $newName
            ];
            $model = model('Cliente');
            $dni = $model->set($data);
            $dni = $model->where('id_tercero', $id['id']);
            $dni = $model->update();
          }

          if ($foto_negocio->isValid()) {
            $newName =  $id['id'] . "." . $foto_negocio->getExtension();
            $ruta_imagen = base_url() . '/images/negocio/'  . $newName;


            $foto_negocio->move('images/negocio', $newName);

            $data = [
              'imagen_negocio' => $newName
            ];
            $model = model('Cliente');
            $dni = $model->set($data);
            $dni = $model->where('id_tercero',  $id['id']);
            $dni = $model->update();
          }

          if ($foto_servicio_publico->isValid()) {
            $newName =  $id['id'] . "." . $foto_servicio_publico->getExtension();
            $ruta_imagen = base_url() . '/images/servicio/'  . $newName;

            $file_headers = @get_headers($ruta_imagen);
            if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
              $foto_servicio_publico->move('images/servicio', $newName);
            }

            $data = [
              'imagen_servicio' => $newName
            ];
            $model = model('Cliente');
            $dni = $model->set($data);
            $dni = $model->where('id_tercero', $id['id']);
            $dni = $model->update();
          } */

          $clientes = model('Cliente')->clientes($this->request->getPost('id_usuario'));
          $returnData = array(
            "code" => 1,
            "clientes" => view('clientes/listado', [
              'clientes' => $clientes
            ]),
            'id_cliente' => $id['id']

          );
          echo  json_encode($returnData);
        }
        if (!empty($existe_cliente)) {  //El cliente existe y por lo tanto no se puede volver a crear 
          $returnData = array(
            "code" => 0,
          );
          echo  json_encode($returnData);
        }
      }
    }
  } 





  function fotos()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (isset($_FILES['capturedImage'])) {
        $uploadDirectory = 'uploads/'; // Especifica el directorio donde deseas guardar las imágenes subidas

        // Obtén el ID del cliente desde la solicitud (ajusta esto según tu estructura)
        $clientID = $_POST['id_cliente']; // Asegúrate de que 'id_cliente' coincida con el nombre del campo en tu formulario

        // Genera un nombre único para la imagen utilizando uniqid y la extensión del archivo
        $uniqueName = uniqid() . '_' . str_replace("captured_image", "", basename($_FILES['capturedImage']['name']));
        $uploadedFile = $uploadDirectory . $uniqueName;



        if (move_uploaded_file($_FILES['capturedImage']['tmp_name'], $uploadedFile)) {

          $data = [
            'id_cliente' => $_POST['id_cliente'],
            'ruta' => $uniqueName
          ];

          $insert = model('fotosCliente')->insert($data);
          $fotos =  model('fotosCliente')->where('id_cliente',$clientID)->findAll();

          $response = array(
            'resultado' => 1,
            'imagenes' => view('clientes/imagenes',[
              'fotos'=>$fotos
            ])
          );
          echo json_encode($response);


        } else {
          echo 'Error uploading image.';
        }
      } else {
        $response = array('resultado' => 0);
        echo json_encode($response);
      }
    } else {
      echo 'Invalid request.';
    }
  }





  function get_clientes()
  {
    $clientes = model('Cliente')->get_clientes($this->request->getPost('valor'));

    $returnData = array(
      "resultado" => 1,
      "clientes" => view('clientes/resultado_clientes', [
        'clientes' => $clientes
      ])
    );
    echo  json_encode($returnData);
  }

  function detalle()
  {
    $id_cliente = $this->request->getPost('id');


    $detalle_cliente = model('Cliente')->detalle($id_cliente);

    $returnData = array(
      "resultado" => 1,
      "cliente" => view('clientes/detalle', [
        'cliente' => $detalle_cliente
      ])
    );
    echo  json_encode($returnData);
  }
}
