<?php

namespace App\Libraries;

class tipo_consulta
{
    public function consulta($fecha_inicial, $fecha_final, $tipo_documento, $nit_cliente = null)
    {
        $where_clause = "WHERE fecha BETWEEN '$fecha_inicial' AND '$fecha_final'";

        if ($tipo_documento != 5) {
            $where_clause .= " AND id_estado = $tipo_documento";

            if ($tipo_documento == 2) {
                $where_clause .= " AND saldo > 0";
            }
        }

        if ($nit_cliente !== null) {
            $where_clause .= " AND nit_cliente = '$nit_cliente'";
        }

        $sql_count = "SELECT COUNT(id) AS total FROM pagos $where_clause";

        $sql_data = "SELECT 
                        id,
                        fecha,
                        documento,
                        valor as total_documento,
                        id_factura,
                        id_estado,
                        nit_cliente,
                        id_estado,
                        id_factura,
                        saldo
                    FROM
                        pagos
                    $where_clause";

        return array('sql_count' => $sql_count, 'sql_data' => $sql_data);
    }

    public function consulta_cliente($fecha_inicial, $fecha_final, $tipo_documento, $nit_cliente)
    {
        $consulta = $this->consulta($fecha_inicial, $fecha_final, $tipo_documento, $nit_cliente);
        return $consulta;
    }
}
