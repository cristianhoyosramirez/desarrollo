<?php

namespace App\Models;

use CodeIgniter\Model;

class CuentasPorCobrar extends Model
{
    protected $table      = 'c_x_c';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_cliente', 'id_ruta', 'id_usuario',
        'numero_cuotas', 'valor_prestamo', 'valor_cuota', 'cuotas_atrasadas', 'cuotas_al_dia',
        'fecha_inicio', 'fecha_final', 'fecha_creacion', 'dias_atraso', 'saldo_prestamo', 'tipo_prestamo',
        'frecuencia', 'cuotas_pendientes'
    ];

    public function actualizar_dias_atraso($usuario, $fecha)
    {
        $datos = $this->db->query("
        SELECT
            id,
            fecha_vencimiento
        FROM
            plan_pagos
        WHERE
            fecha_vencimiento <= '$fecha' and id_usuario=$usuario and saldo_cuota > 0 
        ORDER BY 
             id
        ASC
      ");
        return $datos->getResultArray();
    }
    public function c_x_c_diarias($fecha, $usuario)
    {
        $datos = $this->db->query("
        SELECT
        c_x_c.id as id_c_x_c,
        terceros.nombres,
        terceros.id as id_terceros,
        c_x_c.id as id_c_x_c,
        dias_atraso,
        cliente.imagen_cliente
    FROM
        c_x_c
    INNER JOIN cliente ON c_x_c.id_cliente = cliente.id
    INNER JOIN terceros ON terceros.id = cliente.id_tercero
    WHERE
        cuotas_pendientes > 0 AND c_x_c.id_usuario = $usuario and saldo_prestamo>0 and fecha_creacion!='$fecha'
    ORDER BY
        c_x_c.id
    ASC
      ");
        return $datos->getResultArray();
    }

    public function actualizar_dias_atraso_c_x_c($usuario, $fecha)
    {
        $datos = $this->db->query("
        SELECT DISTINCT
            (id_cxc)
        FROM
            `plan_pagos`
        WHERE
            id_usuario = $usuario AND fecha_vencimiento <= '$fecha'  AND saldo_cuota > 0
      ");
        return $datos->getResultArray();
    }
    public function get_prestamos_usuario($usuario)
    {
        $datos = $this->db->query("
        SELECT
            c_x_c.id,
            terceros.nombres,
            valor_prestamo,
            fecha_creacion,
            fecha_inicio,
            saldo_prestamo,
            cliente.imagen_cliente
        FROM
            c_x_c
        INNER JOIN cliente ON c_x_c.id_cliente = cliente.id
        INNER JOIN terceros ON terceros.id = cliente.id_tercero
        WHERE
            c_x_c.id_usuario = $usuario and `saldo_prestamo`> 0
        ORDER BY
          id DESC
      ");
        return $datos->getResultArray();
    }

    public function cuenta($id)
    {
        $datos = $this->db->query("
        SELECT
            c_x_c.id,
            terceros.nombres,
            valor_cuota,
            dias_atraso,
            id_cliente,
            fecha_inicio as fecha_inicial,
            fecha_final,
            numero_cuotas,
            valor_prestamo,
            valor_cuota,
            saldo_prestamo,
            cuotas_atrasadas,
            cuotas_al_dia
        FROM
            c_x_c
        INNER JOIN cliente ON c_x_c.id_cliente = cliente.id
        INNER JOIN terceros ON terceros.id = cliente.id_tercero
        WHERE
            c_x_c.id = $id
      ");
        return $datos->getResultArray();
    }

    function nombre_cliente($id_cxc)
    {
        $datos = $this->db->query("
        SELECT
            terceros.nombres
        FROM
            `c_x_c`
        INNER JOIN cliente ON cliente.id = c_x_c.id_cliente
        INNER JOIN terceros ON cliente.id_tercero = terceros.id
        WHERE
        c_x_c.id = $id_cxc
      ");
        return $datos->getResultArray();
    }
    function cuotas_atraso($id_cxc)
    {
        $datos = $this->db->query("
        SELECT
            COUNT(id) as cuotas_atrasadas
        FROM
            `plan_pagos`
        WHERE
            `id_cxc` = $id_cxc AND `dias_atraso` >= 1
      ");
        return $datos->getResultArray();
    }
}
