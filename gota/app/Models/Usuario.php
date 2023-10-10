<?php

namespace App\Models;

use CodeIgniter\Model;

class Usuario extends Model
{
    protected $table      = 'usuarios';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_tercero', 'usuario', 'password', 'id_rol', 'id_ruta',
        'numero_de_accesos'
    ];



    public function getUsuario($usuario)
    {
        $datos = $this->db->query("
        SELECT
            usuarios.id AS id_usuario,
            terceros.nombres as nombre,
            id_rol,
            password,
            roles.nombre as rol,
            numero_de_accesos
        FROM
            `usuarios`
        INNER JOIN terceros ON usuarios.id_tercero = terceros.id
        INNER JOIN roles on usuarios.id_rol=roles.id
        WHERE
            usuario = '$usuario' AND usuarios.estado = 1 AND terceros.estado = 1
         ");
        return $datos->getResultArray();
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function cobradores()
    {
        $datos = $this->db->query("
        SELECT
            terceros.nombres,
            usuarios.id
        FROM
            usuarios
        INNER JOIN terceros ON terceros.id = usuarios.id_tercero
    WHERE
        id_rol = 3 and usuarios.estado=1 and terceros.estado=1
         ");
        return $datos->getResultArray();
    }
}
