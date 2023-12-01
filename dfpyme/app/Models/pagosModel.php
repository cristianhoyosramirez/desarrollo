<?php

namespace App\Models;

use CodeIgniter\Model;

class pagosModel extends Model
{
    protected $table      = 'pagos';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'fecha',
        'hora',
        'documento',
        'valor',
        'propina',
        'total_documento',
        'efectivo',
        'transferencia',
        'total_pago',
        'id_usuario_facturacion',
        'id_mesero',
        'id_estado',
        'id_apertura',
        'recibido_efectivo',
        'recibido_transferencia',
        'cambio',
        'id_factura'
    ];

    public function set_ventas_pos($id_apertura)
    {
        $datos = $this->db->query("
    SELECT
    SUM(valor) as valor
    FROM
        pagos
    WHERE
        id_apertura = $id_apertura AND id_estado = 1
    ");
        return $datos->getResultArray();
    }
    public function set_ventas_electronicas($id_apertura)
    {
        $datos = $this->db->query("
    SELECT
    SUM(valor) as valor
    FROM
        pagos
    WHERE
        id_apertura = $id_apertura AND id_estado = 8
    ");
        return $datos->getResultArray();
    }

    function get_id($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' 
 ");
        return $datos->getResultArray();
    }
    function get_base_iva($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(total - iva) AS base_iva
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND iva > 0 AND ico = 0
 ");
        return $datos->getResultArray();
    } 
    function get_base_ico($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(total - ico) AS base_ico
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND ico > 0 AND iva = 0
 ");
        return $datos->getResultArray();
    } 
    function get_id_pos($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and id_estado=1
 ");
        return $datos->getResultArray();
    }






    function get_id_electronicas($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and id_estado=8
 ");
        return $datos->getResultArray();
    }

    function get_costo_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(costo*cantidad) AS total_costo
        FROM
         kardex
        WHERE
            fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }

    function get_ico_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(ico) AS total_ico
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }

    function get_iva_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(iva) AS total_iva
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }
    function get_venta_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(valor) AS total_venta
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }
}
