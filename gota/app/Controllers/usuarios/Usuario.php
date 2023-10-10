<?php

namespace App\Controllers\usuarios;

use App\Controllers\BaseController;

class Usuario extends BaseController
{
    public $db;

    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }
    public function index()
    {

        return view('usuarios/usuarios');
    }

    function crearUsuario()
    {

        if (!$this->validate([
            'crear_usuario' => [
                'rules' => 'required|is_unique[rutas.nombre]',
                'errors' => [
                    'required' => 'Dato requerido',
                    'is_unique' => 'Registro ya existe'
                ],
            ],
            'pass_usuario' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato requerido',
                ],
            ],
            'rol' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato requerido',
                ],
            ],
            'rutas' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato requerido',
                ],
            ],
            'id_tercero' => [
                'rules' => 'is_unique[usuarios.id_tercero]',
                'errors' => [
                    'is_unique' => 'Tercero ya tiene usuario ',
                ],
            ],
        ])) {
            $errors = $this->validator->getErrors();
            echo json_encode(['code' => 0, 'error' => $errors]);
        } else {

            $data = [
                'id_tercero' => $this->request->getPost('id_tercero'),
                'usuario' => $this->request->getPost('crear_usuario'),
                'password' => password_hash($this->request->getVar('pass_usuario'), PASSWORD_DEFAULT),
                'id_rol' => $this->request->getPost('rol'),
                'id_ruta' => $this->request->getPost('rutas')
            ];

            $insert = model('Usuario')->insert($data);
            if ($insert) {
                echo json_encode(['code' => 1, 'msg' => 'Ruta creada']);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'No se pudo crear la ruta ']);
            }
        }
    }

    function login()
    {
        /**
         * Datos de usuario desde el formulario 
         */
        $usu = $this->request->getPost('usuario');
        $clave = $_POST['pass'];

        $usuario = model('Usuario')->getUsuario($usu);


        if ($usuario != null) {
            if (password_verify($clave, $usuario[0]['password'])) {

                $data = [
                    'numero_de_accesos' =>  $usuario[0]['numero_de_accesos'] + 1
                ];

                $usuar = model('Usuario');
                $usuarios = $usuar->set($data);
                $usuarios = $usuar->where('id', $usuario[0]['id_usuario']);
                $usuarios = $usuar->update();

                $debido_cobrar = model('PlanPagos')->get_debido_cobrar($usuario[0]['id_usuario'], date('Y-m-d'));

                $accesos =  model('Usuario')->select('numero_de_accesos')->where('id', $usuario[0]['id_usuario'])->first();

                $datosSesion = [
                    'id_usuario' => $usuario[0]['id_usuario'],
                    'nombre' => $usuario[0]['nombre'],
                    'rol' => $usuario[0]['rol'],
                    'id_rol' => $usuario[0]['id_rol'],
                    'debido_cobrar' => $debido_cobrar[0]['debido_cobrar'],
                    'logged_in' => TRUE,
                    'accesos' => $accesos['numero_de_accesos']
                ];
                $sesion = session();
                $sesion->set($datosSesion);
                $sesion->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url('home'))->with('mensaje', 'Bienvenido');
            } else {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url())->with('mensaje', 'Clave errada');
            }
        } else {
            $session = session();
            $session->setFlashdata('iconoMensaje', 'success');
            return redirect()->to(base_url())->with('mensaje', 'Usuario no existe');
        }
    }

    function getUsuarios()
    {

        $valor_buscado = $_POST['search']['value'];;

        $table_map = [
            0 => 'id',
            1 => 'nombres',
            2 => 'rol',
        ];

        $sql_count = "SELECT count(id) as total from usuarios";

        $sql_data = "SELECT
            usuarios.id,
            terceros.nombres,
            roles.nombre as rol,
            usuario
        FROM
        `usuarios`
        INNER JOIN terceros ON terceros.id = usuarios.id_tercero
        INNER JOIN roles ON usuarios.id_rol=roles.id
        AND usuarios.estado=1
        ";
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

            $sub_array[] = $detalle['nombres'];
            $sub_array[] = $detalle['rol'];
            $sub_array[] = $detalle['usuario'];
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

    function cambiar_clave()
    {

        if (!$this->validate([
            'clave' => [
                'rules' => 'required|min_length[6]|max_length[8]',
                'errors' => [
                    'required' => 'Dato requerido',
                    'min_length'=>'Mímimo debe ser 6 caracteres',
                    'max_length'=>'Máximo 8 caracteres'
                ],
            ],
            'confirmar_clave' => [
                'rules' => 'required|matches[clave]',
                'errors' => [
                    'required' => 'Dato requerido',
                    'matches'=>'Los password no coinciden'
                ],
            ],
        ])) {
           
            //return redirect()->back()->with('errors', $this->validator->getErrors())->withInput();
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            

        } else {

            $data = [
                
                'password' => password_hash($this->request->getVar('clave'), PASSWORD_DEFAULT),
                
            ];

         

            $model = model('Usuario');
            $usuario = $model->set($data);
            $usuario = $model->where('id', $this->request->getVar('id_usuario'));
            $usuario = $model->update();
            if ($usuario) {
                $session = session();
                $session->setFlashdata('iconoMensaje', 'success');
                return redirect()->to(base_url())->with('mensaje', 'Cambio éxitoso ingresa de nuevo por favor ');
            } else {
                echo json_encode(['code' => 0, 'msg' => 'No se pudo crear la ruta ']);
            }
        }
    }
}
