<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanPagos extends Model
{
  protected $table      = 'plan_pagos';
  // Uncomment below if you want add primary key
  // protected $primaryKey = 'id';
  protected $allowedFields = [
    'id_cxc', 'id_cliente', 'id_usuario',
    'id_ruta', 'fecha_vencimiento', 'fecha_pago', 'hora_pago', 'valor_cuota',
    'dias_atraso', 'estado', 'fecha_y_hora_pago', 'numero_cuota', 'saldo_cuota','valor_pago'
  ];

  public function datos_cuotas($id_cxc)
  {
    $datos = $this->db->query("
        SELECT
        id,
        valor_cuota,
        numero_cuota,
        dias_atraso,
        fecha_vencimiento,
        fecha_pago,
        saldo_cuota
    FROM
      `plan_pagos`
    WHERE
      id_cxc='$id_cxc';

          ");
    return $datos->getResultArray();
  }
  public function dias_atraso_cxc($id_cxc,)
  {
    $datos = $this->db->query("
    SELECT
      max(`dias_atraso`) as dias_atraso
  FROM
    `plan_pagos`
  WHERE
    id_cxc = $id_cxc
  ORDER BY
    `dias_atraso` ASC ;

          ");
    return $datos->getResultArray();
  }
  public function cuotas_pendietes($id_cxc)
  {
    $datos = $this->db->query("
    SELECT
    COUNT(id) as cuotas_pendientes
    FROM
      `plan_pagos`
    WHERE
      `saldo_cuota`>0 and id_cxc=$id_cxc;

          ");
    return $datos->getResultArray();
  }
  public function saldo_prestamo($id_cxc)
  {
    $datos = $this->db->query("
    SELECT
    sum(`saldo_cuota`) as saldo_prestamo
FROM
    `plan_pagos`
WHERE
    `saldo_cuota`>0 and id_cxc=$id_cxc;
");
    return $datos->getResultArray();
  }

  public function get_debido_cobrar($id_usuario, $fecha)
  {
    $datos = $this->db->query("
    SELECT
      SUM(saldo_cuota) as debido_cobrar
    FROM
      `plan_pagos`
    WHERE
      `fecha_vencimiento` <= '$fecha' AND `id_usuario` = $id_usuario AND `saldo_cuota` > 0 ;

          ");
    return $datos->getResultArray();
  }
  public function saldo($id_c_x_x, $id_cliente, $id_usuario)
  {
    $datos = $this->db->query("
    SELECT
    SUM(`saldo_cuota`) as saldo
FROM
    `plan_pagos`
WHERE
    `id_cxc` = $id_c_x_x AND `id_cliente` = $id_cliente AND `saldo_cuota` > 0 AND `id_usuario` = $id_usuario ;

          ");
    return $datos->getResultArray();
  }

  public function pago_minimo($id_c_x_x, $fecha)
  {
    $datos = $this->db->query("
    SELECT
      SUM(saldo_cuota) AS pago_minimo
    FROM
      `plan_pagos`
    WHERE
      `fecha_vencimiento` <= '$fecha' AND id_cxc = $id_c_x_x  AND `saldo_cuota`> 0 ;

          ");
    return $datos->getResultArray();
  }

  public function fecha_final($id_c_x_x, $id_usuario)
  {
    $datos = $this->db->query("
    SELECT
      MAX(fecha_vencimiento) as fecha_vencimiento
    FROM
      `plan_pagos`
    WHERE
      id_cxc= $id_c_x_x AND id_usuario=$id_usuario ;
    ");
    return $datos->getResultArray();
  }



  public function abonos($id_c_x_c)
  {
    $datos = $this->db->query("
    SELECT
      `id`,
      `saldo_cuota`
    FROM
      `plan_pagos`
    WHERE
    `saldo_cuota`> 0 and `estado`= 1 and `id_cxc`= $id_c_x_c;
    ");
    return $datos->getResultArray();
  }


  
}
