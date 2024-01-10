<?php


namespace App\Models;

use CodeIgniter\Model;

class productosBorradosModel extends Model
{
    protected $table      = 'productos_borrados';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['codigointernoproducto', 'cantidad','fecha_eliminacion','hora_eliminacion','usuario_eliminacion','pedido'];

    public function getProductosBorrados($fecha_inicial, $fecha_final)
    {
        $datos = $this->db->query("
        SELECT  
        usuario_sistema.nombresusuario_sistema,producto.nombreproducto, fecha_eliminacion,hora_eliminacion,productos_borrados.codigointernoproducto, cantidad
        FROM productos_borrados 
        inner join usuario_sistema on productos_borrados.usuario_eliminacion =usuario_sistema.idusuario_sistema 
        inner join producto on productos_borrados.codigointernoproducto =producto.codigointernoproducto
        where fecha_eliminacion between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }

}
