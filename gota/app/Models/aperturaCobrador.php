<?php

namespace App\Models;

use CodeIgniter\Model;

class aperturaCobrador extends Model
{
    protected $table      = 'apertura_cobrador';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario','fecha_apertura','hora_apertura','fecha_y_hora_apertura'];

}
