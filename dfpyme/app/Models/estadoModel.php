<?php

namespace App\Models;

use CodeIgniter\Model;

class estadoModel extends Model
{
    protected $table      = 'estado';
    // Uncomment below if you want add primary key
   // protected $primaryKey = 'id';
   protected $allowedFields = [' descripcionestado'];
   
}