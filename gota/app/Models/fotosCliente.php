<?php

namespace App\Models;

use CodeIgniter\Model;

class fotosCliente extends Model
{
    protected $table      = 'fotos_cliente';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['id_cliente','ruta'];

}
