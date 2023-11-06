<?php

namespace App\Models;

use CodeIgniter\Model;

class inventarioModel extends Model
{
    protected $table      = 'inventario';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['codigointernoproducto', 'idvalor_unidad_medida', 'idcolor', 'cantidad_inventario'];




    public function producto($valor)
    {
        $datos = $this->db->query("
        SELECT
        *
    FROM
        producto
    WHERE
        nombreproducto ILIKE '%$valor%' order by nombreproducto asc;
         ");
        return $datos->getResultArray();
    }
}
