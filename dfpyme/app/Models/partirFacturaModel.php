<?php

namespace App\Models;

use CodeIgniter\Model;

class partirFacturaModel extends Model
{
    protected $table      = 'partir_factura';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['numero_de_pedido', 'cantidad_producto', 'valor_unitario', 'valor_total', 'codigointernoproducto', 'id_tabla_producto_pedido', 'fk_usuario','nombre_producto','id_tabla_producto'];

    public function productos($numero_pedido)
    {
        $datos = $this->db->query("
        SELECT
            partir_factura.id,
            numero_de_pedido,
            cantidad_producto,
            valor_unitario,
            valor_total,
            partir_factura.codigointernoproducto,
            producto.nombreproducto,
            id_tabla_producto
        FROM
            partir_factura
        INNER JOIN producto ON partir_factura.codigointernoproducto = producto.codigointernoproducto
        WHERE
            numero_de_pedido =$numero_pedido
        ");
        return $datos->getResultArray();
    }
}
