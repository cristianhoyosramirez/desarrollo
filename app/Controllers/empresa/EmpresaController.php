<?php

namespace App\Controllers\empresa;

use App\Controllers\BaseController;

class EmpresaController extends BaseController
{
    public function datos()
    {
        $regimen = model('regimenModel')->orderBy('idregimen', 'asc')->findAll();
        $departamentos = model('departamentoModel')->select('*')->where('idpais', 49)->findAll();
        $municipios = model('ciudadModel')->findAll();
        $datos_empresa = model('empresaModel')->findAll();

        return view('empresa/datos', [
            'regimen' => $regimen,
            'departamentos' => $departamentos,
            'datos_empresa' => $datos_empresa,
            'municipios' => $municipios
        ]);
    }


    function actualizar_datos()
    {

        $data = [
            'nitempresa' => $this->request->getPost('nit_empresa'),
            'idregimen' => $this->request->getPost('id_regimen'),
            'nombrecomercialempresa' => $this->request->getPost('razon_social'),
            'nombrejuridicoempresa' => $this->request->getPost('nombre_comercial'),
            'telefonoempresa' => $this->request->getPost('telefono'),
            'celularempresa' => '0',
            'faxempresa' => '0',
            'emailempresa' => '0',
            'pagwebempresa' => '0',
            'representantelegalempresa' => $this->request->getPost('representante_legal'),
            'iddepartamento' => $this->request->getPost('departamento'),
            'idciudad' => $this->request->getPost('municipio'),
            'direccionempresa' => $this->request->getPost('direccion'),
            'estadoempresa' => 'true',
            'descripcion' => '0',
            'recauda_iva' => 'false'
        ];

        $empresa = model('empresaModel');
        $datos_empresa = $empresa->set($data);
        $datos_empresa = $empresa->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('empresa/datos'))->with('mensaje', 'Datos almacenados éxitosamente');
    }

    function resolucion_facturacion()
    {
        $id_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', 6)->first();
        $resoluciones_dian = model('resolucionDianModel')->findAll();
        return view('empresa/resolucion_facturacion', [
            'resoluciones_dian' => $resoluciones_dian,
            'id_dian' => $id_dian['numeroconsecutivo']
        ]);
    }


    function consecutivos()
    {
        $consecutivos = model('consecutivosModel')->orderBy('idconsecutivos ', 'asc')->findAll();
        return view('consecutivos/listado', [
            'consecutivos' => $consecutivos
        ]);
    }


    function guardar_resolucion_facturacion()
    {
        if (!$this->validate([
            'numero_dian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                    'is_unique' => 'Documento ya existe'

                ]
            ],
            'fecha_dian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'prefijo_dian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                    'is_unique' => 'Usuario ya existe'
                ]
            ],
            'numero_inicial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'numero_final' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'vigencia' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'numero_final' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'texto_inicial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'tipo_de_solicitud' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'alerta' => [
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
                'numeroresoluciondian' => '1233',
                'fechadian' => $this->request->getPost('fecha_dian'),
                'rangoinicialdian' => $this->request->getPost('numero_inicial'),
                'rangofinaldian' => $this->request->getPost('numero_final'),
                'texto_inicial' => $this->request->getPost('texto_inicial'),
                'inicialestatica' => $this->request->getPost('prefijo_dian'),
                'finalestatica' => $this->request->getPost('prefijo_dian'),
                'texto_final' => $this->request->getPost('texto_final'),
                'id_modalidad' => $this->request->getPost('modalidad_dian'),
                'vigencia' => $this->request->getPost('fecha_caducidad'),
                'id_caja' => 1,
                'vigencia_mes' => $this->request->getPost('vigencia'),
                'alerta_facturacion' => $this->request->getPost('alerta')
            ];
            /* $data = [
                'numeroresoluciondian' => $this->request->getPost('numero_dian'),
                'fechadian' => $this->request->getPost('fecha_dian'),
                'rangoinicialdian' => $this->request->getPost('numero_inicial'),
                'rangofinaldian' => $this->request->getPost('numero_final'),
                'texto_inicial' => $this->request->getPost('texto_inicial'),
                'inicialestatica' => $this->request->getPost('prefijo_dian'),
                'finalestatica' => $this->request->getPost('prefijo_dian'),
                'texto_final' => $this->request->getPost('texto_final'),
                'id_modalidad' => $this->request->getPost('modalidad_dian'),
                'vigencia' => $this->request->getPost('fecha_caducidad'),
                'id_caja' => 1,
                'vigencia_mes' => $this->request->getPost('vigencia'),
                'alerta_facturacion' => $this->request->getPost('alerta')
            ]; */


            $insert = model('dianModel')->insert($data);
   
           
            if ($insert) {

                $data = [
                    'numeroconsecutivo' => $this->request->getPost('prefijo_dian'),
                ];

                $model = model('consecutivosModel');
                $consecutivo = $model->set($data);
                $consecutivo = $model->where('idconsecutivos', 7);
                $consecutivo = $model->update();

                $resoluciones_dian = model('resolucionDianModel')->findAll();
                $id_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', 6)->first();

                echo json_encode([
                    'code' => 1,
                    'resoluciones' => view('empresa/tbody_resolucion_facturacion', [
                        'resoluciones_dian' => $resoluciones_dian,
                        'id_dian' => $id_dian['numeroconsecutivo']
                    ]),
                ]);
            } else {
                echo json_encode(['code' => 0, 'msg' => 'No se pudo crear ']);
            }
        }
    }

    function actualizar_consecutivos()
    {

        $data = [
            'numeroconsecutivo' => $this->request->getPost('valor_consecutivo'),
        ];

        $model = model('consecutivosModel');
        $consecutivo = $model->set($data);
        $consecutivo = $model->where('idconsecutivos', $this->request->getPost('id_consecutivos'));
        $consecutivo = $model->update();

        if ($consecutivo) {
            $returnData = array(
                "resultado" => 0, //No hay pedido 
            );
            echo  json_encode($returnData);
        }
    }


    function municipios()
    {

      //$this->request->getPost('id_departamento'); exit();

        $returnData = array(
            "resultado" => 1, //No hay pedido 
            "municipios" => view('municipios/municipios', [
                'municipios' => model('ciudadModel')->select('*')->where('iddepartamento',$this->request->getPost('id_departamento') )->findAll()
            ])
        );
        echo  json_encode($returnData);
    }

    function actualizar_nombre_cuenta()
    {


        $data = [
            'nombre_cuenta' => $this->request->getPost('nombre_cuenta'),
        ];

        $model = model('cuentaRetiroModel');
        $consecutivo = $model->set($data);
        $consecutivo = $model->where('id', $this->request->getPost('id_cuenta'));
        $consecutivo = $model->update();

        $returnData = array(
            "resultado" => 1
        );
        echo  json_encode($returnData);
    }

    function datos_resolucion_facturacion()
    {
        $datos_resolucion = model('dianModel')->select('*')->where('iddian', $_POST['id_resolucion'])->first();

        $returnData = array(
            "resultado" => 1,
            'resolucion' => view('empresa/formulario_editar_resolucion', [
                'datos_resolucion' => $datos_resolucion,
                'id_resolucion' => $_POST['id_resolucion']
            ])
        );
        echo  json_encode($returnData);
    }

    function actualizar_resolucion_facturacion()
    {
        if (!$this->validate([
            'numero_dian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'fecha_dian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'numero_inicial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'numero_final' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'vigencia' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'numero_final' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'texto_inicial' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'tipo_de_solicitud' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Dato necesario',
                ]
            ],
            'alerta' => [
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
                'numeroresoluciondian' => $this->request->getPost('numero_dian'),
                'fechadian' => $this->request->getPost('fecha_dian'),
                'rangoinicialdian' => $this->request->getPost('numero_inicial'),
                'rangofinaldian' => $this->request->getPost('numero_final'),
                'inicialestatica' => $this->request->getPost('prefijo_dian'),
                'finalestatica' => $this->request->getPost('prefijo_dian'),
                'texto_inicial' => $this->request->getPost('texto_inicial'),
                'texto_final' => $this->request->getPost('tipo_de_solicitud'),
                'id_modalidad' => $this->request->getPost('modalidad_dian'),
                'vigencia' => $this->request->getPost('fecha_caducidad'),
                'id_caja' => 1,
                'vigencia_mes' => $this->request->getPost('vigencia'),
                'alerta_facturacion' => $this->request->getPost('alerta')
            ];

            $model = model('dianModel');
            $dian = $model->set($data);
            $dian = $model->where('iddian', $_POST['id_resolucion']);
            $dian = $model->update();

            if ($dian) {
                $resoluciones_dian = model('resolucionDianModel')->findAll();
               
                echo json_encode([
                    'code' => 1,
                    'resoluciones' => view('empresa/tbody_resolucion_facturacion', [
                        'resoluciones_dian' => $resoluciones_dian,
                        'id_dian'=>$_POST['id_resolucion']
                    ])

                ]);
            }
        }
    }
    function activacion_resolucion_facturacion()
    {
        $id_dian = $this->request->getPost('id_resolucion');
        $datos_resolucion = model('dianModel')->findAll();

        $ultima_id = model('facturaVentaModel')->selectMax('id')->first();

        $numero_factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $ultima_id['id'])->first();

        echo json_encode([
            'texto' => $datos_resolucion[0]['texto_inicial'] . "-" . $datos_resolucion[0]['inicialestatica'] . " desde " . $datos_resolucion[0]['inicialestatica'] . " hasta " . $datos_resolucion[0]['rangofinaldian'] . " fecha " . $datos_resolucion[0]['fechadian'] . " vigencia 6 meses ",
            'resultado' => 1,
            'numero_factura' => $numero_factura['numerofactura_venta'],
            'prefijo' => $datos_resolucion[0]['inicialestatica'],
            'id_dian' => $id_dian
        ]);
    }

    function activar_resolucion_dian()
    {
        $id_dian = $this->request->getPost('id_dian_guardar');
        $numeracion_factura = $this->request->getPost('continuacion_factura');

        $id_dian = [
            'numeroconsecutivo' => $id_dian
        ];
        $model = model('consecutivosModel');
        $actualizar_cantidad = $model->set($id_dian);
        $actualizar_cantidad = $model->where('idconsecutivos', 6);
        $actualizar_cantidad = $model->update();

        $consecutivos = [
            'numeroconsecutivo' => $numeracion_factura
        ];

        $model = model('consecutivosModel');
        $actualizar_cantidad = $model->set($consecutivos);
        $actualizar_cantidad = $model->where('idconsecutivos', 8);
        $actualizar_cantidad = $model->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('empresa/resolucion_facturacion'))->with('mensaje', 'Activacion de resolucion exitosa ');
    }

    function comprobante_transaccion()
    {
        return view('empresa/configuracion_impresion_transferencias');
    }

    function configuracion_impresion()
    {
        $impresion = $this->request->getVar('impresion');

        $data = [
            'imp_comprobante_transferencia' => $impresion

        ];

        $model = model('cajaModel');
        $actualizar = $model->set($data);
        $actualizar = $model->where('numerocaja', 1);
        $actualizar = $model->update();

        $session = session();
        $session->setFlashdata('iconoMensaje', 'success');
        return redirect()->to(base_url('home'))->with('mensaje', 'Configuración exitosa');
    }
}
