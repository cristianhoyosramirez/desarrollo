<?php

namespace App\Models;

use CodeIgniter\Model;

class FacturaPropinaModel extends Model
{
    protected $table      = 'factura_propina';
    // Uncomment below if you want add primary key
   // protected $primaryKey = 'id';
    protected $allowedFields = ['estado','valor_propina','id_factura'];
   
}