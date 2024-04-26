<?php

namespace App\Models;

use CodeIgniter\Model;

class pagosModel extends Model
{
    protected $table      = 'pagos';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = [
        'fecha',
        'hora',
        'documento',
        'valor',
        'propina',
        'total_documento',
        'efectivo',
        'transferencia',
        'total_pago',
        'id_usuario_facturacion',
        'id_mesero',
        'id_estado',
        'id_apertura',
        'recibido_efectivo',
        'recibido_transferencia',
        'cambio',
        'id_factura',
        'saldo',
        'nit_cliente',
        'id_pedido'
    ];

    public function set_ventas_pos($id_apertura)
    {
        $datos = $this->db->query("
    SELECT
    SUM(total_documento) as valor
    FROM
        pagos
    WHERE
        id_apertura = $id_apertura AND id_estado = 1
    ");
        return $datos->getResultArray();
    }
  /*   public function set_ventas_electronicas($id_apertura)
    {
        $datos = $this->db->query("
    SELECT
    SUM(total) as valor
    FROM
        kardex
    WHERE
        id_apertura = $id_apertura AND id_estado = 8
    ");
        return $datos->getResultArray();
    } */
 public function set_ventas_electronicas($id_apertura)
    {
        $datos = $this->db->query("
        SELECT
        SUM(total_documento) as valor
        FROM
            pagos
        WHERE
            id_apertura = $id_apertura AND id_estado = 8
    ");
        return $datos->getResultArray();
    } 

    function get_id($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' 
 ");
        return $datos->getResultArray();
    }
    function get_base_iva($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(total - iva) AS base_iva
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND iva > 0 AND ico = 0
 ");
        return $datos->getResultArray();
    }
    function get_base_ico($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(total - ico) AS base_ico
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND ico > 0 AND iva = 0
 ");
        return $datos->getResultArray();
    }
    function get_id_pos($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and id_estado=1
 ");
        return $datos->getResultArray();
    }






    function get_id_electronicas($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
    SELECT
        id_factura
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and id_estado=8
 ");
        return $datos->getResultArray();
    }

    function get_costo_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(costo*cantidad) AS total_costo
        FROM
         kardex
        WHERE
            fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }

    function get_ico_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(ico) AS total_ico
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }

    function get_iva_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(iva) AS total_iva
    FROM
        kardex
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }
    function get_venta_total($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT
        SUM(valor) AS total_venta
    FROM
        pagos
    WHERE
        fecha BETWEEN '$fecha_inicial' AND '$fecha_final'
 ");
        return $datos->getResultArray();
    }
    function get_min_id($id_apertura)
    {

        $datos = $this->db->query("
        select min(id) as id from pagos where id_apertura=$id_apertura and id_estado =1
 ");
        return $datos->getResultArray();
    }
    function get_min_id_electronico($id_apertura)
    {

        $datos = $this->db->query("
        select min(id) as id from pagos where id_apertura=$id_apertura and id_estado =8
 ");
        return $datos->getResultArray();
    }
    function get_max_id_electronico($id_apertura)
    {

        $datos = $this->db->query("
        select max(id) as id from pagos where id_apertura=$id_apertura and id_estado =8
 ");
        return $datos->getResultArray();
    }
    function get_max_id($id_apertura)
    {

        $datos = $this->db->query("
        select max(id) as id from pagos where id_apertura=$id_apertura and id_estado =1
 ");
        return $datos->getResultArray();
    }
    function get_total_registros($id_apertura)
    {

        $datos = $this->db->query("
        select count(id) as total_registros from pagos where id_apertura=$id_apertura and id_estado =1
 ");
        return $datos->getResultArray();
    }
    function get_total_registros_electronicos($id_apertura)
    {

        $datos = $this->db->query("
        select count(id) as total_registros from pagos where id_apertura=$id_apertura and id_estado =8
 ");
        return $datos->getResultArray();
    }
    function get_ventas_mesero($fecha, $id_mesero)
    {

        $datos = $this->db->query("
        select sum(total_documento) as total_venta from pagos where fecha between '$fecha' and '$fecha' and id_mesero = $id_mesero
 ");
        return $datos->getResultArray();
    }
    function get_total_ventas_mesero($fecha, $id_mesero)
    {

        $datos = $this->db->query("
        select count(id) as numero_ventas from pagos where fecha between '$fecha' and '$fecha' and id_mesero = $id_mesero
 ");
        return $datos->getResultArray();
    }
    function get_id_mesero($fecha)
    {

        $datos = $this->db->query("
        select DISTINCT(id_mesero) from pagos where fecha between '$fecha' and '$fecha'
 ");
        return $datos->getResultArray();
    }
    function get_ventas_credito($consulta)
    {

        $datos = $this->db->query("
       $consulta
        ");
        return $datos->getResultArray();
    }
    function get_documento($documento)
    {

        $datos = $this->db->query("
        select * from pagos where documento = '$documento'
        ");
        return $datos->getResultArray();
    }
    function get_saldo($id_estado)
    {

        $datos = $this->db->query("
            select sum (saldo) as saldo  from pagos where saldo > 0 and id_estado=$id_estado
        ");
        return $datos->getResultArray();
    }


    public function fiscal_iva($id_apertura)
    {
        $datos = $this->db->query("
        SELECT DISTINCT ( valor_iva )
        FROM   kardex
        WHERE  id_apertura=$id_apertura
        AND aplica_ico = 'false' and id_estado = 8 
        ");
        return $datos->getResultArray();
    }
    public function total_venta($id_apertura)
    {
        $datos = $this->db->query("
        select sum(total_documento) as total from pagos where id_apertura= $id_apertura
        ");
        return $datos->getResultArray();
    }
    public function total_venta_fecha($fecha_inicial, $fecha_final)
    {
        $datos = $this->db->query("
            select sum(total_documento) as total  from pagos where fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function total_venta_fecha_estado($fecha_inicial, $fecha_final, $id_estado)
    {

        $datos = $this->db->query("
            select sum(total_documento) as total  from pagos where fecha between '$fecha_inicial' and '$fecha_final' and id_estado=$id_estado
        ");
        return $datos->getResultArray();
    }
    public function total_venta_costo($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("
        SELECT 
        sum(total_documento) AS total
        FROM
        pagos where fecha between '$fecha_inicial' and '$fecha_final'
        ");
        return $datos->getResultArray();
    }
    public function c_x_c($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("SELECT
                                         SUM(total_documento) AS total_por_cobrar
                                    FROM
                                        pagos
                                    WHERE
                                        fecha BETWEEN '$fecha_inicial' AND '$fecha_final' and id_estado = 2 
        ");
        return $datos->getResultArray();
    }
    public function c_x_c_generales()
    {

        $datos = $this->db->query("SELECT
                                         SUM(total_documento) AS total_por_cobrar
                                    FROM
                                        pagos
                                    WHERE
                                         id_estado = 2 
        ");
        return $datos->getResultArray();
    }
    public function abonos($fecha_inicial, $fecha_final)
    {

        $datos = $this->db->query("SELECT
                                    (total_documento - saldo) AS pagos_recibidos
                                FROM
                                    pagos
                                WHERE
                                    id_estado = 2 AND fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ");
        return $datos->getResultArray();
    }
    public function abonos_generales()
    {

        $datos = $this->db->query("SELECT
                                    (total_documento - saldo) AS pagos_recibidos
                                FROM
                                    pagos where id_estado=2 
                                 ");
        return $datos->getResultArray();
    }
    
    public function ventas_contado($id_apertura)
    {

        $datos = $this->db->query("SELECT
        SUM(total_documento) AS total
    FROM
        pagos
    WHERE
        id_apertura = $id_apertura AND id_estado = 1
                                 ");
        return $datos->getResultArray();
    }
}
