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
        'ico', 'iva', 'id_estado', 'valor_ico', 'valor_iva', 'aplica_ico', 'id_pedido'
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
    public function get_iva_fiscales($id_apertura, $valor_iva)
    {
        $datos = $this->db->query("
        SELECT
        SUM(iva) as iva
        FROM
        kardex
        WHERE
        id_apertura = $id_apertura AND valor_iva = $valor_iva AND id_estado = 1
        
        ");
        return $datos->getResultArray();
    }
    public function get_iva_electronico($id_apertura, $valor_iva)
    {
        $datos = $this->db->query("
        SELECT
        SUM(iva) as iva
        FROM
        kardex
        WHERE
        id_apertura = $id_apertura AND valor_iva = $valor_iva AND id_estado = 8
        
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
    public function get_inc_electronico($id_apertura)
    {
        $datos = $this->db->query("
        select sum(ico) as total  from kardex where id_apertura=$id_apertura and id_estado=8
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
    public function total_inc_electronico($id_apertura)
    {
        $datos = $this->db->query("
        select sum(total) as total  from kardex where id_apertura=$id_apertura and id_estado=8 and aplica_ico=true
        ");
        return $datos->getResultArray();
    }
    /*   public function ventas_contado_electronicas($id_apertura)
    {
        $datos = $this->db->query("
        select sum(total) as total  from kardex where id_apertura=$id_apertura and id_estado=8
        ");
        return $datos->getResultArray();
    } */
    public function ventas_contado_electronicas($id_apertura)
    {
        $datos = $this->db->query("
        SELECT sum(total_documento) AS total
        FROM pagos
        WHERE id_apertura=$id_apertura
        AND id_estado=8
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
    public function total_iva_electronico($id_apertura, $valor_iva)
    {
        $datos = $this->db->query("
            select sum(total) as total from kardex where id_apertura = $id_apertura and id_estado = 8 and valor_iva = $valor_iva 
        ");
        return $datos->getResultArray();
    }
    public function get_inc_calc($id_factura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT ( valor_ico )
        FROM   kardex
        WHERE  id_factura =$id_factura
               AND aplica_ico = true 
        ");
        return $datos->getResultArray();
    }
    public function get_total_inc($id_factura)
    {
        $datos = $this->db->query("
        SELECT sum ( ico ) as total_inc
        FROM   kardex
        WHERE  id_factura =$id_factura
               AND aplica_ico = true 
        ");
        return $datos->getResultArray();
    }
    public function get_iva_calc($id_factura)
    {
        $datos = $this->db->query("
        select distinct (valor_iva ) from kardex where id_factura = $id_factura and aplica_ico= false
        ");
        return $datos->getResultArray();
    }
    public function get_total_iva($id_factura)
    {
        $datos = $this->db->query("
        select sum (iva ) as total_iva from kardex where id_factura = $id_factura and aplica_ico= false
        ");
        return $datos->getResultArray();
    }


    public function get_tarifa_ico($id_factura, $valor_ico)
    {
        $datos = $this->db->query("
        select sum (ico) as inc from kardex where id_factura = $id_factura and valor_ico = $valor_ico
        ");
        return $datos->getResultArray();
    }
    public function get_tarifa_iva($id_factura, $valor_iva)
    {
        $datos = $this->db->query("
        select sum (iva) as iva from kardex where id_factura = $id_factura and valor_iva = $valor_iva
        ");
        return $datos->getResultArray();
    }
    public function get_productos_factura($id_factura)
    {
        $datos = $this->db->query("
        SELECT producto.nombreproducto AS descripcion,
        cantidad,
        codigo,
        valor_unitario AS neto,
        valor_ico,
        valor_iva,
        kardex.aplica_ico,
        total
 FROM kardex
 INNER JOIN producto ON producto.codigointernoproducto = kardex.codigo
 WHERE id_factura= $id_factura
        ");
        return $datos->getResultArray();
    }


    public function fiscal_ico($id_apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT ( valor_ico )
        FROM   kardex
        WHERE  id_apertura=$id_apertura
        AND aplica_ico = 'true'  and id_estado = 8 
        ");
        return $datos->getResultArray();
    }

    public function temp_categoria($id_apertura)
    {
        $datos = $this->db->query("
            select distinct(id_categoria) from kardex where id_apertura = $id_apertura
        ");
        return $datos->getResultArray();
    }
    public function temp_categoria_productos($id_categoria, $id_apertura)
    {
        $datos = $this->db->query("
        SELECT kardex.codigo, SUM(kardex.cantidad) AS cantidad, producto.nombreproducto 
        FROM kardex 
        INNER JOIN producto ON kardex.codigo = producto.codigointernoproducto 
        WHERE id_categoria = '$id_categoria' AND id_apertura = $id_apertura 
        GROUP BY kardex.codigo, producto.nombreproducto
        ORDER BY producto.nombreproducto ASC;
        ");
        return $datos->getResultArray();
    }

    public function total_venta_iva_5($id_apertura)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        SELECT SUM (total) as total
        FROM kardex
        WHERE valor_iva= 5
          AND id_apertura = $id_apertura
        ");
        return $datos->getResultArray();
    }
    public function total_venta_iva_5_costo($fecha_inicial, $fecha_final)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        SELECT SUM (total) as total
        FROM kardex
        WHERE valor_iva= 5
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function total_venta_iva_19_costo($fecha_inicial, $fecha_final)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        SELECT SUM (total) as total
        FROM kardex
        WHERE valor_iva= 19
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function total_venta_inc_costo($fecha_inicial, $fecha_final)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        SELECT SUM (total) as total
        FROM kardex
        WHERE valor_ico= 8
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function total_venta_inc($id_apertura, $inc)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        select sum (total )as total from kardex where valor_ico= $inc and id_apertura =  $id_apertura and aplica_ico='true'
        ");
        return $datos->getResultArray();
    }
    public function venta_inc($id_apertura)  //Total de la venta con impuestos 
    {
        $datos = $this->db->query("
        select sum (ico )as inc from kardex where valor_ico= 8 and id_apertura =  $id_apertura and aplica_ico='true'
        ");
        return $datos->getResultArray();
    }
    public function venta_iva_5($id_apertura)  // Total del valor del iva 5 % 
    {
        $datos = $this->db->query("
        SELECT SUM (iva) as iva
        FROM kardex
        WHERE valor_iva= 5
          AND id_apertura = $id_apertura
        ");
        return $datos->getResultArray();
    }
    public function venta_iva_5_costo($fecha_inicial, $fecha_final)  // Total del valor del iva 5 % 
    {
        $datos = $this->db->query("
        SELECT SUM (iva) as iva
        FROM kardex
        WHERE valor_iva= 5
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function venta_iva_19_costo($fecha_inicial, $fecha_final)  // Total del valor del iva 5 % 
    {
        $datos = $this->db->query("
        SELECT SUM (iva) as iva
        FROM kardex
        WHERE valor_iva= 19
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function venta_inc_costo($fecha_inicial, $fecha_final)  // Total del valor del iva 5 % 
    {
        $datos = $this->db->query("
        SELECT SUM (ico) as inc
        FROM kardex
        WHERE valor_ico= 8
        and 
        fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }

    public function resultado_suma_entre_fechas($fecha_inicial, $fecha_final)  // Total del valor del iva 5 % 
    {
        $datos = $this->db->query("
        SELECT DISTINCT 
                total,
                codigo,
                valor
            FROM   kardex
            WHERE  fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and idcompra=0 and idconcepto=10
        ");
        return $datos->getResultArray();
    }

    public function reporte_suma_cantidades($fecha_inicial, $fecha_final, $valor_unitario, $codigointernoproducto)
    {
        $datos = $this->db->query("
        SELECT SUM(total) as valor_total,
            SUM(cantidad) as cantidad,
            total
        FROM   kardex
        WHERE  fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
        AND total = $valor_unitario
        AND codigo = '$codigointernoproducto' 
        GROUP BY kardex.total
        ");
        return $datos->getResultArray();
    }
    public function get_iva_reportes($apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT valor_iva AS iva
        FROM   kardex
        WHERE  aplica_ico = 'false'
        AND id_apertura = $apertura
        ");
        return $datos->getResultArray();
    }
    public function get_inc_reportes($apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT valor_ico AS inc
        FROM   kardex
        WHERE  aplica_ico = 'true'
        AND id_apertura = $apertura
        ");
        return $datos->getResultArray();
    }
    public function get_producto($codigo)
    {
        $datos = $this->db->query("
        SELECT id
        FROM kardex
        WHERE codigo = '$codigo'
        ");
        return $datos->getResultArray();
    }
}
