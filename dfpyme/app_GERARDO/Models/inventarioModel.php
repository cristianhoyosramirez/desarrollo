<?php

namespace App\Models;

use CodeIgniter\Model;

class inventarioModel extends Model
{
    protected $table      = 'inventario';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['codigointernoproducto', 'idvalor_unidad_medida','idcolor', 'cantidad_inventario'];
}
