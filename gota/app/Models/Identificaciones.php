<?php

namespace App\Models;

use CodeIgniter\Model;

class Identificaciones extends Model
{
    protected $table      = 'tipos_identificacion';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];

}
