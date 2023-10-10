<?php

namespace App\Models;

use CodeIgniter\Model;

class Cliente extends Model
{
    protected $table      = 'cliente';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['id_tercero', 'telefono_de_contacto', 'referencia_personal', 'id_usuario', 'direccion_negocio', 
    'telefono_negocio',
    'imagen_dni','imagen_cliente','imagen_casa','imagen_negocio','imagen_servicio'
];

    public function buscar_cliente($termino)
    {
        $datos = $this->db->query("
            SELECT
                terceros.nombres,
                cliente.id AS id_cliente,
                terceros.numero_identificacion
        FROM
            `cliente`
        INNER JOIN terceros ON cliente.id_tercero = terceros.id
        WHERE
            terceros.nombres LIKE '%$termino%' OR nombres LIKE '%$termino%';
          ");
        return $datos->getResultArray();
    }

    public function clientes($usuario)
    {
        $datos = $this->db->query("
        SELECT
            cliente.id,
            terceros.nombres,
            terceros.numero_identificacion,
            terceros.direccion,
            terceros.telefono,
            imagen_cliente
        FROM
            cliente
        INNER JOIN terceros ON cliente.id_tercero = terceros.id and terceros.estado=1 and cliente.estado=1 and id_usuario = $usuario ORDER BY cliente.id DESC ;
          ");
        return $datos->getResultArray();
    }
    public function get_nombres($id_cliente)
    {
        $datos = $this->db->query("
        SELECT
            terceros.nombres
        FROM
            cliente
        INNER JOIN terceros ON cliente.id_tercero = terceros.id
        WHERE
            cliente.id = $id_cliente;
          ");
        return $datos->getResultArray();
    }

    public function get_clientes($valor)
    {
        $datos = $this->db->query("
        SELECT
            cliente.id,
            terceros.nombres,
            terceros.numero_identificacion,
            terceros.direccion,
            terceros.telefono
        FROM
            cliente
        INNER JOIN terceros ON cliente.id_tercero = terceros.id AND terceros.estado = 1 AND cliente.estado = 1 AND id_usuario =8
        WHERE
            terceros.nombres LIKE '%$valor%'
        ORDER BY
        cliente.id
        DESC;
          ");
        return $datos->getResultArray();
    }

    function detalle($id_cliente)
    {
        $datos = $this->db->query("
        SELECT
            *
        FROM
            cliente
        INNER JOIN terceros ON cliente.id_tercero = terceros.id
        WHERE
            cliente.id = $id_cliente AND cliente.estado = 1 AND terceros.estado = 1;
          ");
        return $datos->getResultArray();
    }
}
