<?php

namespace App\Models;

use CodeIgniter\Model;

class kardexModel extends Model
{
    protected $table      = 'kardex';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'idcompra', 'codigo', 'idusuario', 'idconcepto', 'numerodocumento', 'fecha', 'hora',
        'cantidad', 'valor', 'total', 'fecha_y_hora_factura_venta', 'id_categoria', 'id_apertura', 'valor_unitario', 'id_factura', 'costo',
        'ico', 'iva', 'id_estado','valor_ico','valor_iva','aplica_ico'
    ];

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
    public function get_factutras_pos($id_factura)
    {
        $datos = $this->db->query("
        SELECT * FROM kardex WHERE id_factura = $id_factura;
        ");
        return $datos->getResultArray();
    }
    public function get_costo($id_factura)
    {
        $datos = $this->db->query("
        select sum (costo * cantidad) as costo from kardex where id_factura=$id_factura
        ");
        return $datos->getResultArray();
    }
    public function get_ico($id_factura)
    {
        $datos = $this->db->query("
        select sum (ico) as ico from kardex where id_factura=$id_factura
        ");
        return $datos->getResultArray();
    }
    public function get_iva($id_factura)
    {
        $datos = $this->db->query("
        select sum (iva) as iva from kardex where id_factura=$id_factura
        ");
        return $datos->getResultArray();
    }
    public function get_inc($id_apertura)
    {
        $datos = $this->db->query("
        select sum(ico) as total  from kardex where id_apertura=$id_apertura and id_estado=1
        ");
        return $datos->getResultArray();
    }
    public function total_inc($id_apertura)
    {
        $datos = $this->db->query("
        select sum(total) as total  from kardex where id_apertura=$id_apertura and id_estado=1 and aplica_ico=true
        ");
        return $datos->getResultArray();
    }
    public function ventas_contado($id_apertura)
    {
        $datos = $this->db->query("
        select sum(total) as total  from kardex where id_apertura=$id_apertura and id_estado=1
        ");
        return $datos->getResultArray();
    }

    public function get_iva_fiscal($id_apertura, $valor_iva)
    {
        $datos = $this->db->query("
            select sum(total) as total from kardex where id_apertura = $id_apertura and id_estado = 1 and valor_iva = $valor_iva 
        ");
        return $datos->getResultArray();
    }
}
