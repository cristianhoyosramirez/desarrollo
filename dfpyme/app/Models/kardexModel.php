<?php

namespace App\Models;

use CodeIgniter\Model;

class kardexModel extends Model
{
    protected $table      = 'kardex';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['idcompra', 'codigo', 'idusuario', 'idconcepto', 'numerodocumento', 'fecha', 'hora', 'cantidad', 'valor', 'total', 'fecha_y_hora_factura_venta', 'id_categoria', 'id_apertura', 'valor_unitario'];

    public function get_productos($id_apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT
        valor_unitario,
        codigo,id_categoria
    FROM
        kardex
    WHERE
        id_apertura = $id_apertura
        
        ");
        return $datos->getResultArray();
    }
    public function get_total($id_apertura, $valor_unitario, $codigo)
    {
        $datos = $this->db->query("
        SELECT
            SUM(total) AS total, sum(cantidad) as cantidad
        FROM
            kardex
        WHERE
            id_apertura = $id_apertura AND codigo = '$codigo' AND valor_unitario = $valor_unitario
        ");
        return $datos->getResultArray();
    }
    public function get_categorias($id_apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT
            id_categoria
        FROM
            kardex
        WHERE
        id_apertura = '$id_apertura'
        ");
        return $datos->getResultArray();
    }
    public function get_total_categoria($id_categoria)
    {
        $datos = $this->db->query("
        SELECT
            SUM(valor_total) AS total
        FROM
            reporte_ventas_producto_categorias
        WHERE
            id_categoria=$id_categoria
        ");
        return $datos->getResultArray();
    }
}
