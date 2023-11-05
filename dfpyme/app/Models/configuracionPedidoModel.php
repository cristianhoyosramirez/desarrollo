<?php

namespace App\Models;

use CodeIgniter\Model;

class configuracionPedidoModel extends Model
{
    protected $table      = 'configuracion_pedido';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['agregar_item','propina','mesero_pedido','valor_defecto_propina'];
}
