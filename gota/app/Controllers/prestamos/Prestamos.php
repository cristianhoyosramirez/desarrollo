<?php

namespace App\Controllers\prestamos;

use App\Controllers\BaseController;
use \DateTime;
use \DateTimeZone;


class Prestamos extends BaseController
{
  public $db;

  public function __construct()
  {

    $this->db = \Config\Database::connect();
  }
  public function index()
  {

    return view('cobros_del_dia/cobros_del_dia');
  }


  function get_del_dia()
  {

    /**
     * 1. Consultar el id de la cuenta por cobrar y la fecha antes de la fecha actual 
     * 
     */

    $usuario = $this->request->getPost('usuario');
    //$usuario = 8;

    /**
     * Registros de la tabla plan pagos para calcular los dias de atraso de cada cuota y se llaman por usuario y el saldo cuota debe ser mayor a
     * cero y los dias de atraso mayor a cero 
     */

    $cuotoas_con_saldo = model('CuentasPorCobrar')->actualizar_dias_atraso($usuario, date('Y-m-d'));

    /**
     * Actualizacion de la columna dias de atraso en la tabla plan pagos 
     */
    foreach ($cuotoas_con_saldo as $detalle) {

      $dias_atraso = model('Calendario')->dias_atraso($detalle['fecha_vencimiento'], date('Y-m-d'));

      $data = [
        'dias_atraso' => $dias_atraso[0]['total'] - 1
      ];

      $plan_pago = model('PlanPagos');
      $plan_pago = $plan_pago->set($data);
      $plan_pago = $plan_pago->where('id', $detalle['id']);
      $plan_pago = $plan_pago->update();
    }

    /**
     * id de las cuentas por cobrar desde la tabla plan de pagos 
     */

    $id_c_x_c = model('CuentasPorCobrar')->actualizar_dias_atraso_c_x_c($usuario, date('Y-m-d'));
    //dd($id_c_x_c);
    foreach ($id_c_x_c as $detalle) {

      $dias_atraso = model('PlanPagos')->dias_atraso_cxc($detalle['id_cxc']);
      $cuotas_pendientes = model('PlanPagos')->cuotas_pendietes($detalle['id_cxc']);
      $saldo_prestamo = model('PlanPagos')->saldo_prestamo($detalle['id_cxc']);

      $data = [
        'dias_atraso' => $dias_atraso[0]['dias_atraso'],
        'cuotas_pendientes' => $cuotas_pendientes[0]['cuotas_pendientes'],
        'saldo_prestamo' => $saldo_prestamo[0]['saldo_prestamo']
      ];

      $c_x_c = model('CuentasPorCobrar');
      $c_x_c = $c_x_c->set($data);
      $c_x_c = $c_x_c->where('id', $detalle['id_cxc']);
      $c_x_c = $c_x_c->update();
    }


    $c_x_c_diarias = model('CuentasPorCobrar')->c_x_c_diarias(date('Y-m-d'), $usuario);
    $returnData = array(
      "resultado" => 1,
      "prestamos" => view('prestamos/c_x_c_diarias', [
        'c_x_c' => $c_x_c_diarias,
        'id_usuario' => $usuario
      ])
    );
    echo  json_encode($returnData);
  }
  function get_prestamos_usuario()
  {

    $get_prestamos_usuario = model('CuentasPorCobrar')->get_prestamos_usuario($this->request->getPost('usuario'));
    $returnData = array(
      "datos" => view('prestamos/listado_prestamos_usuario', [
        'prestamos' => $get_prestamos_usuario
      ]), //Falta plata  
      "resultado" => 1
    );
    echo  json_encode($returnData);
  }


  function listar()
  {
    return view('prestamos/prestamos');
  }

  function getTodos()
  {

    $valor_buscado = $_POST['search']['value'];;

    $table_map = [
      0 => 'id_plan_pagos',
      1 => 'nombre_tercero',
      2 => 'nombre_ruta',
      3 => 'fecha_vencimiento',
      3 => 'valor_cuota',
      3 => 'estado',
      3 => 'dias_atraso',
    ];

    $sql_count = "SELECT count(id) as total from plan_pagos";

    $sql_data = "SELECT
    plan_pagos.id AS id_plan_pagos,
    terceros.nombres as nombre_tercero,
    rutas.nombre as nombre_ruta, 
    fecha_vencimiento,
    valor_cuota,
    plan_pagos.estado,
    dias_atraso
FROM
    plan_pagos
INNER JOIN terceros ON terceros.id = plan_pagos.id_cliente
INNER JOIN rutas on rutas.id =plan_pagos.id_ruta
      ";
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

      $sub_array[] = $detalle['nombre_tercero'];
      $sub_array[] = $detalle['valor_cuota'];
      $sub_array[] = $detalle['fecha_vencimiento'];
      $sub_array[] = $detalle['dias_atraso'];

      $sub_array[] = '   <div class="col-12">
        <div class="row  align-items-center">
          <div class="col-6 col-sm-4 col-md-2 col-xl-auto py-3">
            <a href="#" class="btn btn-green w-100">
              Pagar 
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


  function abrirModal()
  {
    $operacion = $_REQUEST['operacion'];
    if ($operacion == 1) {
      $returnData = array(
        "datos" => view('prestamos/formulario_crear_prestamo'), //Falta plata  
        "resultado" => 1
      );
      echo  json_encode($returnData);
    }
  }

  function generar_prestamo()
  {

    if (!$this->validate([
      'monto' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido'
        ],
      ],
      'intereses' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ],
      'frecuencia' => [
        'rules' => 'required',
        'errors' => [
          'required' => 'Dato requerido',
        ],
      ]
    ])) {
      $errors = $this->validator->getErrors();
      echo json_encode(['code' => 0, 'error' => $errors]);
    } else {


      $tiene_prestamos = model('CuentasPorCobrar')->select('id')->where('id_cliente', $this->request->getVar('id_cliente'))->first();

      if (empty($tiene_prestamos)) {

        //$valor_prestamo = $this->request->getVar('monto');
        $valor_prestamo = str_replace(".", "", $this->request->getVar('monto'));
        $intereses = $this->request->getVar('intereses');
        $plazo = $this->request->getVar('plazo');

        $intereses = ($valor_prestamo * $intereses) / 100;

        $prestamo_mas_interes = ($valor_prestamo / $plazo) + ($intereses / $plazo);

        $valor_cuota = $prestamo_mas_interes;

        $fecha_inicial = date("Y-m-d", strtotime(date('Y-m-d') . "+ 1 days"));
        $fecha_final = model('Calendario')->selectMax('fecha')->first();

        $fechas_de_cobro = model('Calendario')->fechas_de_cobro($fecha_inicial, $fecha_final['fecha'], $plazo);
        $id_ruta = model('Usuario')->select('id_ruta')->where('id', $this->request->getVar('id_usuario'))->first();

        $data = [
          'id_cliente' => $this->request->getVar('id_cliente'),
          'id_ruta' => $id_ruta['id_ruta'],
          'id_usuario' => $this->request->getVar('id_usuario'),
          'numero_cuotas' => $plazo,
          'valor_prestamo' => $valor_prestamo,
          'valor_cuota' => $valor_cuota,
          'fecha_inicio' => $fecha_inicial,
          'fecha_final' => $fecha_final,
          'fecha_creacion' => date('Y-m-d'),
          'saldo_prestamo' => $valor_prestamo,
          'tipo_prestamo' => 1,
          'frecuencia' => 1,
          'cuotas_pendientes' => $plazo
        ];

        $insert = model('CuentasPorCobrar')->insert($data);
        $ultimoId = model('CuentasPorCobrar')->insertID;
        $tabla_amortizacion = array();
        $numero_cuota = 1;
        foreach ($fechas_de_cobro as $detalle) {
          $data['fecha'] =  $detalle['fecha'];
          $data['fk_tercero'] = $this->request->getVar('id_tercero_prestamo');
          array_push($tabla_amortizacion, $data);

          $plan_pago = [
            'id_cxc' => $ultimoId,
            'id_cliente' => $this->request->getVar('id_cliente'),
            'id_usuario' => $this->request->getVar('id_usuario'),
            'id_ruta' => $id_ruta['id_ruta'],
            'fecha_vencimiento' => $detalle['fecha'],
            'valor_cuota' => $valor_cuota,
            'numero_cuota' => $numero_cuota,
            'saldo_cuota' => $valor_cuota
          ];
          $numero_cuota = $numero_cuota + 1;
          $insertar = model('PlanPagos')->insert($plan_pago);
        }

        $nombre_cliente = model('Cliente')->get_nombres($this->request->getVar('id_cliente'));
        $fecha_finalizacion = model('PlanPagos')->fecha_final($ultimoId, $this->request->getVar('id_usuario'));
        $get_prestamos_usuario = model('CuentasPorCobrar')->get_prestamos_usuario($this->request->getPost('id_usuario'));

        $returnData = array(
          "code" => 1,
          "tabla_amortizacion" => view('prestamos/tabla_amortizacion', [
            'detalle_prestamo' => $tabla_amortizacion,
            'valor_cuota' => "$" . number_format($valor_cuota, 0, ",", "."),
            'monto_solicitado' => number_format($valor_prestamo, 0, ",", "."),
            'numero_de_cuotas' => $this->request->getVar('plazo_en_dias'),
            'fecha_inicio' => $fecha_inicial,
            'fecha_finalizacion' => $fecha_finalizacion[0]['fecha_vencimiento'],
            'nombres_cliente' => $nombre_cliente[0]['nombres']
          ]),
          "datos" => view('prestamos/listado_prestamos_usuario', [
            'prestamos' => $get_prestamos_usuario
          ]),

        );
        echo  json_encode($returnData);
      }
    }
    if (!empty($tiene_prestamos)) {

      $returnData = array(
        "code" => 0,
      );
      echo  json_encode($returnData);
    }
  }

  /*   function cuotas_prestamo()
  {

    $datos_cuotas = model('PlanPagos')->datos_cuotas($this->request->getPost('id_c_x_c'), $this->request->getPost('id_cliente'));
    $nombre_cliente = model('Cliente')->get_nombres($this->request->getPost('id_cliente'));

    $pago_minimo = model('PlanPagos')->pago_minimo($this->request->getPost('id_c_x_c'), $this->request->getPost('id_cliente'), date('Y-m-d'));

    $returnData = array(
      "resultado" => 1,
      "tabla_amortizacion" => view('prestamos/c_x_c_tabla_cliente', [
        'datos_cuotas' => $datos_cuotas,
        'nombre_cliente' => $nombre_cliente[0]['nombres']

      ]),
      'pago_minimo' => number_format($pago_minimo[0]['pago_minimo'], 0, ",", "."),
      'id_c_x_c' => $this->request->getPost('id_c_x_c')
    );
    echo  json_encode($returnData);
  } */

  /**
   * Abonos a cartera desde el formulario viene el id del usuario , id de la cuenta por cobrar 
   * el pago 
   *
   * @return void
   */
  function abonar(): void
  {
    /**
     * Fecha y hora 
     */
    $fecha = DateTime::createFromFormat('U.u', microtime(TRUE));
    $fecha->setTimeZone(new DateTimeZone('America/Bogota'));
    $fecha_y_hora = $fecha->format('Y-m-d H:i:s.u');
    $hora = $fecha->format('H:i:s.u');
    /**
     * Datos desde el formulario POST 
     */
    $id_c_x_c = $this->request->getPost('id_c_x_c');

    $id_usuario = $this->request->getPost('usuario');

    $pago = $this->request->getPost('pago');
    //  Consultar la cuotas vencidas 
    $plan_pago = model('PlanPagos')->abonos($id_c_x_c);
    $tem_pago = 0;

    foreach ($plan_pago as $detalle) {

      $tem_pago = $pago;

      if ($tem_pago > 0) {
        if ($tem_pago  > $detalle['saldo_cuota']) {

          $abono = $tem_pago - $detalle['saldo_cuota'];

          $pago = $abono;

          $data = [
            'saldo_cuota' => 0,
            'fecha_pago' => date('Y-m-d'),
            'hora_pago' => $hora

          ];

          $saldo = model('PlanPagos');
          $abono_cuota = $saldo->set($data);
          $abono_cuota = $saldo->where('id', $detalle['id']);
          $abono_cuota = $saldo->update();
        }

        if ($tem_pago  < $detalle['saldo_cuota']) {

          $abono = $tem_pago - $detalle['saldo_cuota'];

          $pago = $abono;

          $data = [
            'saldo_cuota' => $tem_pago,
            'fecha_pago' => date('Y-m-d'),
            'hora_pago' => $hora

          ];

          $saldo = model('PlanPagos');
          $abono_cuota = $saldo->set($data);
          $abono_cuota = $saldo->where('id', $detalle['id']);
          $abono_cuota = $saldo->update();
        }

        if ($tem_pago  == $detalle['saldo_cuota']) {

          $abono = $tem_pago - $detalle['saldo_cuota'];

          $pago = $abono;
          $data = [
            'saldo_cuota' => 0,
            'fecha_pago' => date('Y-m-d'),
            'hora_pago' => $hora

          ];

          $saldo = model('PlanPagos');
          $abono_cuota = $saldo->set($data);
          $abono_cuota = $saldo->where('id', $detalle['id']);
          $abono_cuota = $saldo->update();
        }
      }

      $dias_atraso = model('PlanPagos')->dias_atraso_cxc($id_c_x_c);
      $dias_atraso = model('PlanPagos')->dias_atraso_cxc($id_c_x_c);
      $cuotas_pendientes = model('PlanPagos')->cuotas_pendietes($id_c_x_c);
      $saldo_prestamo = model('PlanPagos')->saldo_prestamo($id_c_x_c);

      $data = [
        'dias_atraso' => $dias_atraso[0]['dias_atraso'],
        'cuotas_pendientes' => $cuotas_pendientes[0]['cuotas_pendientes'],
        'saldo_prestamo' => $saldo_prestamo[0]['saldo_prestamo']
      ];

      $c_x_c = model('CuentasPorCobrar');
      $c_x_c = $c_x_c->set($data);
      $c_x_c = $c_x_c->where('id', $id_c_x_c);
      $c_x_c = $c_x_c->update();
    }
    $c_x_c_diarias = model('CuentasPorCobrar')->c_x_c_diarias(date('Y-m-d'), $id_usuario);
    $total_abono = $this->request->getPost('pago');

    $nombre_cliente = model('CuentasPorCobrar')->nombre_cliente($id_c_x_c);

    $debido_cobrar = model('PlanPagos')->get_debido_cobrar($id_usuario, date('Y-m-d'));

    $returnData = array(
      "resultado" => 1,
      "prestamos" => view('prestamos/c_x_c_diarias', [
        'c_x_c' => $c_x_c_diarias,
        'id_usuario' => $id_usuario
      ]),
      'abono' => "$" . number_format($total_abono, 0, ",", "."),
      'nombre_cliente' => $nombre_cliente[0]['nombres'],
      'debido_cobrar' => "Debido cobrar " . "$" . number_format($debido_cobrar[0]['debido_cobrar'], 0, ",", ".")
    );
    echo  json_encode($returnData);
  }

  function pagar()
  {
    $id_c_x_c = $this->request->getPost('id');

    $cuenta = model('CuentasPorCobrar')->cuenta($id_c_x_c);
    $cuotas_atraso = model('CuentasPorCobrar')->cuotas_atraso($id_c_x_c);
    

    $cuotas = model('PlanPagos')->datos_cuotas($id_c_x_c);
    $pago_minimo = model('PlanPagos')->pago_minimo($id_c_x_c, date('Y-m-d'));
    $returnData = array(
      "resultado" => 1,
      "tabla_pagos" => view('prestamos/c_x_c_tabla_cliente', [
        'datos_cuotas' => $cuotas,
      ]),
      /*  'nombre_cliente' => $cuenta[0]['nombres'],
      'monto_solicitado' => "$" . number_format($cuenta[0]['valor_prestamo'], 0, ",", "."),
      'plazo' => $cuenta[0]['numero_cuotas'],
      'valor_cuota' => "$" . number_format($cuenta[0]['valor_cuota'], 0, ",", "."),
      'fecha_inicial' => $cuenta[0]['fecha_inicial'],
      'fecha_final' => $cuenta[0]['fecha_final'],
      'saldo' => "$" . number_format($cuenta[0]['saldo_prestamo'], 0, ",", "."),
      'cuotas_atrasadas' => $cuenta[0]['cuotas_atrasadas'],
      'cuotas_al_dia' => $cuenta[0]['cuotas_al_dia'],
      'cuotas_faltantes' => $cuenta[0]['numero_cuotas'] - $cuenta[0]['cuotas_al_dia'], */
      'pago_minimo' => number_format($pago_minimo[0]['pago_minimo'], 0, ",", "."),
      'id_c_x_c' => $id_c_x_c,
      'nombre_cliente' => $cuenta[0]['nombres'],
      'cuotas_atrasadas'=>"Cuotas atrasadas: ".$cuotas_atraso[0]['cuotas_atrasadas']

    );
    echo  json_encode($returnData);
  }

  function detalle()
  {
    $id_c_x_c = $this->request->getPost('id');
    $cuenta = model('CuentasPorCobrar')->cuenta($id_c_x_c);
    $valor_pago = model('planPagos')->selectSum('valor_pago')->where('id_cxc ', $id_c_x_c)->findAll();


    $returnData = array(
      "resultado" => 1,
      "tabla_pagos" => view('prestamos/detalle_prestamo', [
        'nombre_cliente' => $cuenta[0]['nombres'],
        'monto_solicitado' => "$" . number_format($cuenta[0]['valor_prestamo'], 0, ",", "."),
        'plazo' => $cuenta[0]['numero_cuotas'],
        'valor_cuota' => "$" . number_format($cuenta[0]['valor_cuota'], 0, ",", "."),
        'fecha_inicial' => $cuenta[0]['fecha_inicial'],
        'fecha_final' => $cuenta[0]['fecha_final'],
        'saldo' => "$" . number_format($cuenta[0]['saldo_prestamo'], 0, ",", "."),
        'cuotas_atrasadas' => $cuenta[0]['cuotas_atrasadas'],
        'cuotas_al_dia' => $cuenta[0]['cuotas_al_dia'],
        'cuotas_faltantes' => $cuenta[0]['numero_cuotas'] - $cuenta[0]['cuotas_al_dia'],
        'valor_pago' => $valor_pago
      ]),
      'numero_prestamo' => $id_c_x_c
    );
    echo  json_encode($returnData);
  }
}
