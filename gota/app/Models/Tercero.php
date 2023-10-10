<?php

namespace App\Models;

use CodeIgniter\Model;

class Tercero extends Model
{
    protected $table      = 'terceros';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['tipo_identificacion', 'numero_identificacion', 'nombres', 'direccion', 'telefono', 'email', 'estado'];

    public function buscar_terceros($termino)
    {
        $datos = $this->db->query("
            SELECT
            id,
            nombres,
            numero_identificacion
        FROM
            terceros
        WHERE
            numero_identificacion LIKE '%$termino%' or  nombres LIKE '%$termino%' ;

          ");
        return $datos->getResultArray();
    }
}
