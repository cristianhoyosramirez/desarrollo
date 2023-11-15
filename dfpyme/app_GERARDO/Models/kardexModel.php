<?php

namespace App\Models;

use CodeIgniter\Model;

class kardexModel extends Model
{
    protected $table      = 'kardex';
    // Uncomment below if you want add primary key
   // protected $primaryKey = 'id';
    protected $allowedFields = ['idcompra','codigo','idusuario','idconcepto','numerodocumento','fecha','hora','cantidad','valor','total','fecha_y_hora_factura_venta'];
   
}