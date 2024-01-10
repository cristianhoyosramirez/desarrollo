<?php

namespace App\Models;

use CodeIgniter\Model;

class clientesModel extends Model
{
    protected $table      = 'cliente';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'nitcliente', 'idregimen', 'nombrescliente', 'telefonocliente',
        'celularcliente', 'emailcliente', 'idciudad', 'direccioncliente', 'estadocliente',
        'idtipo_cliente', 'punto', 'id_clasificacion','name','last_name','dv','type_person','type_document','name_comercial','is_customer'
    ];

    public function clientes($valor)
    {
        $datos = $this->db->query("
         SELECT
        nitcliente,nombrescliente,id
    FROM
        cliente
    WHERE
        nombrescliente ILIKE '%$valor%' or nitcliente  ILIKE '%$valor%' order by id desc;
         ");
        return $datos->getResultArray();
    }
}
