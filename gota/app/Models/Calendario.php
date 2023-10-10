<?php

namespace App\Models;

use CodeIgniter\Model;

class Calendario extends Model
{
    protected $table      = 'calendario';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['fecha', 'dia', 'cobrable'];

    public function fechas_de_cobro($fecha_inicio, $fecha_fin, $limite)
    {
        $datos = $this->db->query("
        SELECT 
             fecha, 
              cobrable, 
              dia 
        FROM 
            calendario 
        WHERE 
            fecha BETWEEN '$fecha_inicio' 
        AND '$fecha_fin' 
        AND cobrable = 1 
      order by 
      fecha asc 
      LIMIT $limite
          
          ");
        return $datos->getResultArray();
    }
    public function dias_atraso($fecha_inicial, $fecha_final)
    {
        $datos = $this->db->query("
        SELECT
        COUNT(id) as total 
        FROM
            calendario
        WHERE
        `fecha` BETWEEN '$fecha_inicial' AND '$fecha_final' AND `cobrable` = 1
          
          ");
        return $datos->getResultArray();
    }
}
