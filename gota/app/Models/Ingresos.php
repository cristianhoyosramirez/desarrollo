<?php

namespace App\Models;

use CodeIgniter\Model;

class Ingresos extends Model
{
    protected $table      = 'ingresos_adicionales';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['fecha','id_usuario','valor','concepto'];

}
