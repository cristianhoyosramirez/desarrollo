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
    'id_apertura'
    
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
   
}