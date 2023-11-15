<?php

namespace App\Models;

use CodeIgniter\Model;

class empresaModel extends Model
{
    protected $table      = 'empresa';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [ 'nitempresa',
    'idregimen',
    'nombrecomercialempresa',
    'nombrejuridicoempresa',
    'telefonoempresa',
    'celularempresa',
    'faxempresa',
    'emailempresa',
    'pagwebempresa',
    'representantelegalempresa',
    'iddepartamento',
    'idciudad',
    'direccionempresa',
    'estadoempresa',
    'descripcion',
    'recauda_iva'];

    public function datosEmpresa()
    {
        $datos = $this->db->query("
        SELECT
        nombreregimen,
        nitempresa,
        nombrecomercialempresa,
        telefonoempresa,
        emailempresa,
        pagwebempresa,
        direccionempresa,
        representantelegalempresa,
        nombrejuridicoempresa,
        ciudad.nombreciudad,
        departamento.nombredepartamento
    FROM
    empresa
    inner join regimen on empresa.idregimen=regimen.idregimen
    inner join ciudad on ciudad.idciudad =empresa.idciudad
    inner join departamento on departamento.iddepartamento =empresa.iddepartamento

        ");
        return $datos->getResultArray();
    }
}
