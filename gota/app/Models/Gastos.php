<?php

namespace App\Models;

use CodeIgniter\Model;

class Gastos extends Model
{
    protected $table      = 'gastos';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['fecha','hora','fecha_y_hora','id_usuario','id_apertura','valor'];

}
