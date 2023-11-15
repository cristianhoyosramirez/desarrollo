<?php

namespace App\Models;

use CodeIgniter\Model;

class detalleDevolucionVentaModel extends Model
{
    protected $table      = 'detalle_devolucion_venta';
    // Uncomment below if you want add primary key
   // protected $primaryKey = 'id';
    protected $allowedFields = ['id_devolucion_venta','codigo', 'idmedida', 'idcolor','valor','descuento','iva','cantidad','impoconsumo','ico','valor_total_producto','fecha_y_hora_venta','fecha_venta'];
   
}