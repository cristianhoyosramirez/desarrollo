<?php

namespace App\Libraries;

class tipo_consulta
{
    /**
     * Calcular imuestos
     * @param   $cod(igo_interno
     * 
     */
    public function consulta($fecha_inicial, $fecha_final, $tipo_documento)
    {

        $sql_count = '';
        $sql_data = '';


        if ($tipo_documento != 5) {

            if ($tipo_documento != 2) {
                $sql_count = "SELECT 
                            COUNT(pagos.id) AS total
                    FROM
                     pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = $tipo_documento";

                $sql_data = "SELECT
                        id,
                        fecha,
                        documento,
                        total_documento,
                        id_factura,
                        id_estado,
                        nit_cliente,
                        id_estado,
                        id_factura
                    FROM
                    pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = $tipo_documento";
            }
            if ($tipo_documento == 2) {
                $sql_count = "SELECT 
                            COUNT(pagos.id) AS total
                    FROM
                     pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = 2  ";

                $sql_data = "SELECT
                        id,
                        fecha,
                        documento,
                        total_documento,
                        id_factura,
                        id_estado,
                        nit_cliente,
                        id_estado,
                        id_factura
                    FROM
                    pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = 2  and saldo > 0  ";
            }
            if ($tipo_documento == 9) {
                $sql_count = "SELECT 
                            COUNT(pagos.id) AS total
                    FROM
                     pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = 2 and saldo > 0 ";

                $sql_data = "SELECT
                        id,
                        fecha,
                        documento,
                        total_documento,
                        id_factura,
                        id_estado,
                        nit_cliente,
                        id_estado,
                        id_factura
                    FROM
                    pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' AND id_estado = 2  ";
            }
        }
        if ($tipo_documento == 5) {

            $sql_count = "SELECT 
                            COUNT(pagos.id) AS total
                    FROM
                     pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ";



            $sql_data = "SELECT
                        id,
                        fecha,
                        documento,
                        total_documento,
                        id_factura,
                        id_estado,
                        nit_cliente,
                        id_estado,
                        id_factura
                    FROM
                    pagos where fecha BETWEEN '$fecha_inicial' AND '$fecha_final' ";
        }

        return array('sql_count' => $sql_count, 'sql_data' => $sql_data);

    }
}
