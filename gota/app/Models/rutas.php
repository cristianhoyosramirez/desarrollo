<?php

namespace App\Models;

use CodeIgniter\Model;

class rutas extends Model
{
    protected $table      = 'rutas';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'cuentas_activas', 'cuentas_atrasadas', 'cuentas_al_dia', 'cartera_atrasada', 'debido_cobrar','valor_ruta','estado'];
   
   

}
