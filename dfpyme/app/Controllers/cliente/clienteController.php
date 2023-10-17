<?php

namespace App\Controllers\cliente;

use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    public $db;
    public function __construct()
    {

        $this->db = \Config\Database::connect();
    }
    public function index()
    {
        if (!isset($_POST['palabraClave'])) {
            $clientes = model('clientesModel')->orderBy('id', 'desc')->find();
        } else {
            $search = $_POST['palabraClave'];
            $clientes = model('clientesModel')->clientes($search);
        }
        $response = array();
        foreach ($clientes as $detalle) {
            $response[] = array(
                "id" => $detalle['nitcliente'],
                "text" => $detalle['nombrescliente']
            );
        }
        echo json_encode($response);
    }

    public function agregar()
    {


        if (
            !$this->validate([
                'tipo_persona' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'identificacion' => [
                    'rules' => 'required|is_unique[cliente.nitcliente]',
                    'errors' => [
                        'required' => 'Dato necesario',
                        'is_unique' => 'Registro ya existe',
                    ],
                ],
                'dv' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'nombres' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'apellidos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'razon_social' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesarios',
                    ],
                ],
                'nombre_comercial' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'direccion' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'departamento' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'ciudad' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'municipios' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'codigo_postal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'correo_electronico' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'telefono' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'impuestos' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
                'responsabilidad_fiscal' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Dato necesario',
                    ],
                ],
            ])
        ) {
            $errors = $this->validator->getErrors();
            echo json_encode(['code' => 0, 'error' => $errors]);
        } else {

            $id_ciudad = $this->request->getPost('ciudad');

            $code = model('municipiosModel')->select('code')->where('id', $this->request->getPost('municipios'))->first();


            /*  $data = [
                'nitcliente' => '25170832',
                'idregimen' => 1,
                'nombrescliente' => 'liliana',
                'telefonocliente' => '3113155025',
                'celularcliente' => '3113155025',
                'emailcliente' => 'cc',
                'idciudad' =>  319,
                'direccioncliente' => 'san clemewnte',
                'estadocliente' => true,
                'idtipo_cliente' => $_POST['tipo_ventas'],
                'id_clasificacion' => $_POST['clasificacion'],
                'name' => $_POST['nombres'],
                'last_name' => $_POST['apellidos'],
                'dv' => $_POST['dv'],
                'type_person' => $_POST['tipo_persona'],
                'type_document' => $_POST['tipo_documento'],
                'name_comercial' => $_POST['nombre_comercial'],
                'is_customer' => true
            ]; */
            $data = [
                'nitcliente' => $_POST['identificacion'],
                'idregimen' => $_POST['regimen'],
                'nombrescliente' => $_POST['nombres'],
                'telefonocliente' => $_POST['telefono'],
                'celularcliente' => $_POST['telefono'],
                'emailcliente' => $_POST['correo_electronico'],
                'idciudad' =>  $id_ciudad,
                'direccioncliente' => $_POST['direccion'],
                'estadocliente' => true,
                'idtipo_cliente' => $_POST['tipo_ventas'],
                'id_clasificacion' => $_POST['clasificacion'],
                'name' => $_POST['nombres'],
                'last_name' => $_POST['apellidos'],
                'dv' => $_POST['dv'],
                'type_person' => $_POST['tipo_persona'],
                'type_document' => $_POST['tipo_documento'],
                'name_comercial' => $_POST['nombre_comercial'],
                'is_customer' => true
            ];

            $insert = model('clientesModel')->insert($data);


            $model = model('ciudadModel');
            $ciudad = $model->set('code', $code['code']);
            $ciudad = $model->set('code_postal', $_POST['codigo_postal']);
            $ciudad = $model->where('idciudad', $id_ciudad);
            $ciudad = $model->update();

            $descripcion_impuesto = model('impuestosModel')->select('descripcion')->where('codigo', $_POST['impuestos'])->first();

            $impuestos = [
                'nit_cliente' => $_POST['identificacion'],
                'codigo' => $_POST['impuestos'],
                'nombre' => 'No aplica',
                'descripcion' => $descripcion_impuesto['descripcion']
            ];


            $insertar_impuestos = model('detallesTributariosModel')->insert($impuestos);


            

            $returnData = array(
                "code" => 1,
                "cliente"=>$_POST['identificacion']." ".$_POST['nombres']." ".$_POST['apellidos'],
                "nit_cliente"=>$_POST['identificacion']
             
            );
            echo  json_encode($returnData);
        }



        /*  $nit = $_POST['cedula'];
        //$nit=12345678901;
        $miCadena = (string)$nit;
        $existe_cliente = model('clientesModel')->select('nitcliente')->where('nitcliente', $miCadena)->first();


        if (empty($existe_cliente)) {
            $ciudad = $_POST['municipio_cliente'];
            if ($ciudad == 0) {
                $muni = model('empresaModel')->select('idciudad')->first();
                $municipio = $muni['idciudad'];
            }
            if ($ciudad != 0) {
                $municipio = $ciudad;
            }
            $data = [
                'nitcliente' => $_POST['cedula'],
                'idregimen' => $_POST['regimen_cliente'],
                'nombrescliente' => $_POST['nombres_cliente'],
                'telefonocliente' => $_POST['telefono_cliente'],
                'celularcliente' => $_POST['celular_cliente'],
                'emailcliente' => $_POST['email_cliente'],
                'idciudad' => $municipio,
                'direccioncliente' => $_POST['direccion_cliente'],
                'estadocliente' => true,
                'idtipo_cliente' => $_POST['tipo_cliente'],
                'id_clasificacion' => $_POST['clasificacion_cliente']
            ];
           
            $insert = model('clientesModel')->insert($data);
            if ($insert) {
                $ultimo_id_cliente = model('clientesModel')->insertID;
                $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('id', $ultimo_id_cliente)->first();
                $nit_cliente = model('clientesModel')->select('nitcliente')->where('id', $ultimo_id_cliente)->first();
                $returnData = array(
                    "resultado" => 0,
                    "nombres_cliente" => $nombre_cliente['nombrescliente'],
                    "nit_cliente" => $nit_cliente['nitcliente']
                );
                echo  json_encode($returnData);
            }
        }
        if (!empty($existe_cliente)) {

            $returnData = array(
                "resultado" => 1, //Falta plata  
            );
            echo  json_encode($returnData);
        } */
    }

    public function clientes_autocompletado()
    {
        $returnData = array();
        $valor = $this->request->getVar('term');


        $resultado = model('clientesModel')->clientes($valor);

        if (!empty($resultado)) {
            foreach ($resultado as $row) {
                $data['value'] =  number_format($row['nitcliente'], 0, ',', '.') . " " . "/" . " " . $row['nombrescliente'];
                $data['nit_cliente'] = $row['nitcliente'];


                array_push($returnData, $data);
            }
            echo json_encode($returnData);
        } else {
            $data['value'] = "No hay resultados";
            array_push($returnData, $data);
            echo json_encode($returnData);
        }
    }

    function todos_los_clientes()
    {
        $valor_buscado = $_GET['search']['value'];
        //$valor_buscado = 'CLIE';

        $sql_count = '';
        $sql_data = '';


        $table_map = [
            0 => 'id',
            1 => 'nitcliente',
            2 => 'nombrescliente',
            3 => 'descripcionestado',
            4 => 'fecha_factura_venta',
            5 => 'horafactura_venta',
            6 => 'fechalimitefactura_venta',
        ];


        $sql_count = "SELECT
                        COUNT(id) AS total
                        FROM
                    cliente
                    inner join regimen on cliente.idregimen = regimen.idregimen 
                    ";

        $sql_data = " SELECT *
        FROM
            cliente
            inner join regimen on cliente.idregimen = regimen.idregimen
            ";
        $condition = "";
        if (!empty($valor_buscado)) {

            $condition .= " WHERE cliente.nitcliente ILIKE '%" . $valor_buscado . "%'";
            $condition .= " OR cliente.nombrescliente ILIKE '%" . $valor_buscado . "%'";
        }

        $sql_count = $sql_count . $condition;
        $sql_data = $sql_data . $condition;

        $total_count = $this->db->query($sql_count)->getRow();

        $sql_data .= " ORDER BY " . $table_map[$_GET['order'][0]['column']] . " " . $_GET['order'][0]['dir'] . " " . "LIMIT " . $_GET['length'] . " OFFSET " . $_GET['start'];

        $datos = $this->db->query($sql_data)->getResultArray();


        if (!empty($datos) && !empty($total_count)) {

            foreach ($datos as $detalle) {
                $sub_array = array();
                $sub_array[] = $detalle['nitcliente'];
                $sub_array[] = $detalle['nombrescliente'];
                $sub_array[] = $detalle['celularcliente'];
                $sub_array[] = $detalle['direccioncliente'];
                $sub_array[] = $detalle['nombreregimen'];




                $sub_array[] = '<a  class="btn btn-success btn-icon "  onclick="editar_cliente(' . $detalle['id'] . ')"  >
                                   Editar </a>    ';
                $data[] = $sub_array;
            }

            $json_data = [
                //'draw' => intval($this->request->getGEt(index: 'draw')),
                'draw' => intval($this->request->getGEt(index: 'draw')),
                'recordsTotal' => $total_count->total,
                'recordsFiltered' => $total_count->total,
                'data' => $data,

            ];
            echo  json_encode($json_data);
        } else {
            $sub_array = array();
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $sub_array[] = 'NO HAY DATOS ';
            $data[] = $sub_array;
            $json_data = [
                //'draw' => intval($this->request->getGEt(index: 'draw')),
                'draw' => intval($this->request->getGEt(index: 'draw')),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => $data,

            ];
            echo  json_encode($json_data);
        }
    }

    function tabla_todos_los_clientes()
    {
        $regimen = model('regimenModel')->orderBy('idregimen', 'desc')->findAll();
        $tipo_cliente = model('tipoClienteModel')->orderBy('id', 'asc')->findAll();
        $clasificacion_cliente = model('clasificacionClienteModel')->orderBy('id', 'asc')->findAll();
        $departamento = model('departamentoModel')->select('*')->where('idpais', 49)->find();
        $id_departamento_empresa = model('empresaModel')->select('iddepartamento')->first();
        $id_ciudad_empresa = model('empresaModel')->select('idciudad')->first();
        $ciudad = model('municipiosModel')->select('nombreciudad')->where('idciudad', $id_ciudad_empresa['idciudad'])->first();
        $municipios = model('municipiosModel')->findAll();


        return view('clientes/listado', [
            'regimen' => $regimen,
            'tipo_cliente' => $tipo_cliente,
            'clasificacion_cliente' => $clasificacion_cliente,
            'departamentos' => $departamento,
            "id_departamento" => $id_departamento_empresa['iddepartamento'],
            "id_ciudad" => $id_ciudad_empresa['idciudad'],
            "ciudad" => $ciudad['nombreciudad'],
        ]);
    }

    function nuevo_cliente()
    {

        if (!$this->validate([
            'identificacion_cliente' => [
                'rules' => 'required|is_unique[cliente.nitcliente]',
                'errors' => [
                    'required' => 'Dato necesario',
                    'is_unique' => 'Identificación ya existe '

                ]
            ],
            'nombres_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'regimen_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'tipo_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'clasificacion_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
        ])) {
            $errors = $this->validator->getErrors();
            echo json_encode([
                'code' => 0,
                'error' => $errors
            ]);
        } else {



            $data = [
                'nitcliente' => $_POST['identificacion_cliente'],
                'idregimen' => $_POST['regimen_cliente'],
                'nombrescliente' => $_POST['nombres_cliente'],
                'telefonocliente' => $_POST['telefono_cliente'],
                'celularcliente' => $_POST['celular_cliente'],
                'emailcliente' => $_POST['e-mail'],
                'idciudad' => $_POST['municipios'],
                'direccioncliente' => $_POST['direccion_cliente'],
                'estadocliente' => true,
                'idtipo_cliente' => $_POST['tipo_cliente'],
                'id_clasificacion' => $_POST['clasificacion_cliente']
            ];

            $insert = model('clientesModel')->insert($data);
            if ($insert) {
                echo json_encode(['code' => 1, 'msg' => 'Usuario creado']);
            }
        }
    }

    function editar_cliente()
    {
        //$id_cliente = 61;
        $id_cliente = $_POST['id_cliente'];
        $datos_cliente = model('clientesModel')->select('*')->where('id', $id_cliente)->first();
        $regimen = model('regimenModel')->orderBy('idregimen', 'desc')->findAll();
        $tipo_cliente = model('tipoClienteModel')->orderBy('id', 'asc')->findAll();
        $clasificacion_cliente = model('clasificacionClienteModel')->orderBy('id', 'asc')->findAll();
        $departamento = model('departamentoModel')->select('*')->where('idpais', 49)->find();
        $id_departamento_empresa = model('empresaModel')->select('iddepartamento')->first();
        $id_ciudad_empresa = model('empresaModel')->select('idciudad')->first();
        $ciudad = model('municipiosModel')->select('nombreciudad')->where('idciudad', $id_ciudad_empresa['idciudad'])->first();
        $municipios = model('municipiosModel')->findAll();


        $returnData = array(
            "resultado" => 1,
            "datos_cliente" => view('clientes/formulario_editar_cliente', [
                'regimen' => $regimen,
                'tipo_cliente' => $tipo_cliente,
                'clasificacion_cliente' => $clasificacion_cliente,
                'departamentos' => $departamento,
                "id_departamento" => $id_departamento_empresa['iddepartamento'],
                "id_ciudad" => $id_ciudad_empresa['idciudad'],
                "ciudad" => $ciudad['nombreciudad'],
                "datos_cliente" => $datos_cliente
            ])
        );
        echo  json_encode($returnData);
    }

    function actualizar_datos_cliente()
    {
        if (!$this->validate([
            'nombres_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'regimen_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'tipo_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'clasificacion_cliente' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
        ])) {
            $errors = $this->validator->getErrors();
            echo json_encode([
                'code' => 0,
                'error' => $errors
            ]);
        } else {



            $data = [
                'nitcliente' => $_POST['identificacion_cliente'],
                'idregimen' => $_POST['regimen_cliente'],
                'nombrescliente' => $_POST['nombres_cliente'],
                'telefonocliente' => $_POST['telefono_cliente'],
                'celularcliente' => $_POST['celular_cliente'],
                'emailcliente' => $_POST['e-mail'],
                'idciudad' => $_POST['municipios'],
                'direccioncliente' => $_POST['direccion_cliente'],
                'estadocliente' => true,
                'idtipo_cliente' => $_POST['tipo_cliente'],
                'id_clasificacion' => $_POST['clasificacion_cliente']
            ];



            $model = model('clientesModel');
            $cliente = $model->set($data);
            $cliente = $model->where('id', $_POST['id_cliente']);
            $cliente = $model->update();



            if ($cliente) {
                echo json_encode(['code' => 1, 'msg' => 'Usuario creado']);
            }
        }
    }
}
