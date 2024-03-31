<?php

namespace App\Models;

use CodeIgniter\Model;

class facturaElectronicaModel extends Model
{
    protected $table      = 'documento_electronico';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'nit_cliente',
        'estado',
        'tipo',
        'tipo_factura',
        'tipo_operacion',
        'tipo_ambiente',
        'id_status',
        'numero',
        'fecha',
        'hora',
        'fecha_limite',
        'numero_items',
        'total',
        'neto',
        'moneda',
        'id_resolucion',
        'metodo_pago',
        'medio_pago',
        'fecha_pago',
        'version_ubl',
        'version_dian',
        'transaccion_id',
        'id_caja',
        'cancelled',
        'fecha_y_hora_factura_venta',
        'id_apertura',
        'propina',
        'id_apertura',
        'qrcode',
        'cufe',
        'pdf_url',
        'nota'
    ];

    public function insertar($datos) {
        $Nombres = $this->db->table('documento_electronico');
        $Nombres->insert($datos);

        return $this->db->insertID(); 
    }
}
