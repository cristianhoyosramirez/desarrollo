<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;
use \DateTime;
use \DateTimeZone;



class CerrarVenta extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    public function cerrar_venta()
    {

        /* 
        $numero_pedido = 189;

        $efectivo = 200000;
        $transaccion = 200000;
        $valor_venta = 400000;
        $nit_cliente = 22222222;
        $id_usuario = 6;
        $estado = 1;
        $descuento = 0;
        $id_mesa = 95;
        $propina = 0;
        $numero_pedid = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $numero_pedido = $numero_pedid['id'];
        $tipo_pago = 1; */
        //$total_pagado = 300000;

        /**
         * Datos de formulario cerrar venta 
         */


        $id_mesa = $this->request->getPost('id_mesa');
        $pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();
        $numero_pedido = $pedido['id'];
        $efectivo = $_POST['efectivo'];
        $transaccion = $_POST['transaccion'];
        $valor_venta = $_POST['valor_venta'];
        $nit_cliente = $_POST['nit_cliente'];
        $id_usuario = $_POST['id_usuario'];
        $estado = $_POST['estado'];
        $propina = $_POST['propina_Format'];
        $descuento = 0;
        $tipo_pago = $_POST['tipo_pago'];



        $alerta_facturacion = "";
        /**
         * Datos dian
         */
        $id_dian = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', '6')->first();
        $numero_facturas = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', '8')->first();
        $alerta = model('dianModel')->select('alerta_facturacion')->where('iddian', $id_dian['numeroconsecutivo'])->first();
        $rango_final = model('dianModel')->select('rangofinaldian')->where('iddian', $id_dian['numeroconsecutivo'])->first();
        $fecha_dian  = model('dianModel')->select('vigencia')->where('iddian', $id_dian['numeroconsecutivo'])->first();
        $prefijo_factura = model('dianModel')->select('inicialestatica')->where('iddian', $id_dian['numeroconsecutivo'])->first();
        $serie = model('consecutivosModel')->select('numeroconsecutivo')->where('idconsecutivos', '14')->first();

        /**
         * Calcular la vigencia de la resolucion por fechas 
         */

        $fecha_actual = new DateTime(date('Y-m-d'));
        $dian = new DateTime($fecha_dian['vigencia']);
        $diferencia_fecha = $fecha_actual->diff($dian);

        /**
         * En caso de que la alerta de facturas faltante este vacia por defecto asignamos 200 
         */
        if (!empty($alerta)) {
            $alerta_facturacion = $alerta['alerta_facturacion'];
        }
        if (empty($alerta)) {
            $alerta_facturacion = 200;
        }
        /**
         * Calcualar cuantas se pueden facturar 
         */
        $facturas_sin_alerta = $rango_final['rangofinaldian'] - $alerta_facturacion;

        /**
         * Fecha y hora actual 
         */
        $fecha = date("Y-m-d ");
        $hora = date("H:i:s");


        /**
         * Datos del pedido
         */

        $valor_total = model('pedidoModel')->select('valor_total')->where('fk_mesa', $id_mesa)->first();
        $observaciones_genereles = model('pedidoModel')->select('nota_pedido')->where('fk_mesa', $id_mesa)->first();
        $fk_usuario_mesero = model('pedidoModel')->select('fk_usuario')->where('fk_mesa', $id_mesa)->first();

        $saldo = '';
        if ($estado == 1 or $estado == 7) {
            $saldo = 0;
        }
        if ($estado == 2 or $estado == 6) {
            $saldo = $valor_total['valor_total'];
        }

        $fech = DateTime::createFromFormat('U.u', microtime(TRUE));
        $fech->setTimeZone(new DateTimeZone('America/Bogota'));
        $fecha_y_hora = $fech->format('Y-m-d H:i:s.u');


        $facturas_restantes = $rango_final['rangofinaldian'] - $numero_facturas['numeroconsecutivo'];

        if ($numero_facturas['numeroconsecutivo'] <= $rango_final['rangofinaldian'] and $diferencia_fecha->format('%R%a') >= 0) {  // Se puede facturar esta bien la fecha y la numeracion

            $serie_update  = $serie['numeroconsecutivo'] + 1;
            $incremento = model('consecutivosModel')->update_serie($serie_update);
            $factura_venta = model('facturaVentaModel')->factura_venta(
                $prefijo_factura['inicialestatica'] . "-" . $numero_facturas['numeroconsecutivo'],
                $nit_cliente,
                $id_usuario,
                $estado,
                $hora,
                $fecha,
                $serie['numeroconsecutivo'],
                $id_dian['numeroconsecutivo'],
                $observaciones_genereles['nota_pedido'],
                $fk_usuario_mesero['fk_usuario'],
                $saldo,
                $valor_total['valor_total'],
                $id_mesa,
                $numero_pedido,
                $fecha_y_hora,
                $descuento,
                $propina
            );

            //Guardar la propina 
            $data = [
                'estado' => $estado,
                'valor_propina' => $propina,
                'id_factura' => $factura_venta
            ];

            $propina_factura = model('FacturaPropinaModel')->insert($data);

            $consecutivo = ['numeroconsecutivo' => $numero_facturas['numeroconsecutivo'] + 1];
            $numero_factura = ['numero_factura' => $prefijo_factura['inicialestatica'] . "-" . $numero_facturas['numeroconsecutivo']];

            $actualiar_pedido_consecutivos =   model('cerrarVentaModel')->actualiar_pedido_consecutivos($numero_pedido, $numero_factura, $consecutivo);

            if ($tipo_pago == 1) {
                $productos = model('productoPedidoModel')->where('numero_de_pedido', $numero_pedido)->find();
                //Insertar en la tabla producto factura_venta 
                $insertar_productos = model('cerrarVentaModel')->producto_pedido($productos, $factura_venta, $numero_pedido, $prefijo_factura['inicialestatica'] . "-" . $numero_facturas['numeroconsecutivo'], $fecha_y_hora, $tipo_pago, $id_usuario);
            }


            if ($tipo_pago == 0) {

                $productos = model('partirFacturaModel')->get_productos($numero_pedido);
                $insertar_productos = model('cerrarVentaModel')->producto_pedido($productos, $factura_venta, $numero_pedido, $prefijo_factura['inicialestatica'] . "-" . $numero_facturas['numeroconsecutivo'], $fecha_y_hora, $tipo_pago, $id_usuario);
            }

            if ($efectivo > 1) {
                //Insertar en la tabla factura venta 
                $forma_pago_efectivo = model('facturaFormaPagoModel')->factura_forma_pago(
                    $prefijo_factura['inicialestatica'] . "-" . $numero_factura['numero_factura'], //Numero de factura 
                    $id_usuario, // id de l usuario
                    1, // id_forma_pago 1 = efectivo 
                    $fecha,
                    $hora,
                    $efectivo,
                    $efectivo, // con cuanto pagan en efectivo la factura 
                    $factura_venta, // id de la factura 
                    $fecha_y_hora
                );
            }

            if ($transaccion > 1) {
                $forma_pago_transaccion = model('facturaFormaPagoModel')->factura_forma_pago(
                    $prefijo_factura['inicialestatica'] . "-" . $numero_factura['numero_factura'], //Numero de factura 
                    $id_usuario, // id de l usuario
                    4, // id_forma_pago 1 = efectivo 
                    $fecha,
                    $hora,
                    $transaccion,
                    $transaccion, // con cuanto pagan en efectivo la factura 
                    $factura_venta, // id de la factura 
                    $fecha_y_hora
                );
            }
            if ($tipo_pago == 1) {  // si el tipo de pago es 1 quiere decir que se factura el pedido completo 
                // borrar productos del pedido 
                $borrar_producto_pedido = model('productoPedidoModel')->where('numero_de_pedido', $numero_pedido);
                $borrar_producto_pedido->delete();

                //Borrar el pedido 
                $borrar_producto_pedido = model('pedidoModel')->where('id', $numero_pedido);
                $borrar_producto_pedido->delete();
            }
            if ($tipo_pago == 0) {  // Si el tipo de pago es 0 es un pago parcial se debe borrar la tabla partir factura y actualizar la tabla pedido 
                $borrar_partir_factura = model('partirFacturaModel')->where('numero_de_pedido', $numero_pedido);
                $borrar_partir_factura->delete();

                $total = model('productoPedidoModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido)->findAll();

                $model = model('pedidoModel');
                $actualizar = $model->set('valor_total', $total[0]['valor_total']);
                $actualizar = $model->where('id', $numero_pedido);
                $actualizar = $model->update();
            }
            $mensaje = "";


            if ($numero_facturas['numeroconsecutivo'] >= $facturas_sin_alerta and $diferencia_fecha->format('%R%a') > 0) {
                $mensaje = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Le quedan ' . $facturas_restantes . ' facturas restantes.</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            if ($numero_facturas['numeroconsecutivo'] >= $facturas_sin_alerta and $diferencia_fecha->format('%R%a') == 0) {
                $mensaje = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Le quedan ' . $facturas_restantes . ' facturas y hoy se vence por fecha.</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            }
            if ($numero_facturas['numeroconsecutivo'] < $facturas_sin_alerta) {
                $mensaje = "";
            }

            $mesas = model('mesasModel')->orderBy('id', 'ASC')->findAll();

            $productos_pedido = model('productoPedidoModel')->producto_pedido($numero_pedido);
            $valor_pedido = model('pedidoModel')->select('valor_total')->where('fk_mesa', $id_mesa)->first();
            $nombre_mesa = model('mesasModel')->select('nombre')->where('id', $id_mesa)->first();

            if ($tipo_pago == 0) {
                $returnData = array(
                    "id_factura" => $factura_venta,
                    "resultado" => 1,
                    "total" => "$ " . number_format($valor_venta, 0, ",", "."),
                    "valor_pago" => "$ " . number_format($efectivo + $transaccion, 0, ",", "."),
                    "cambio" => "$ " . number_format(($efectivo + $transaccion) - $valor_venta, 0, ",", "."),
                    "mensaje" => $mensaje,
                    "mesas" => view('pedidos/todas_las_mesas_lista', [
                        "mesas" => $mesas,
                    ]),
                    "productos" => view('pedidos/productos_pedido', [
                        "productos" => $productos_pedido,
                        "pedido" => $numero_pedido
                    ]),
                    "id_mesa" => $id_mesa,
                    "valor_pedio" => "$ " . number_format($valor_pedido['valor_total'], 0, ",", "."),
                    "nombre_mesa" => $nombre_mesa['nombre'],
                    "pedido" => $pedido['id'],
                    "tipo_pago" => $tipo_pago


                );

                echo  json_encode($returnData);
            }


            if ($tipo_pago == 1) {

                $returnData = array(
                    "id_factura" => $factura_venta,
                    "resultado" => 1,
                    "total" => "$ " . number_format($valor_venta, 0, ",", "."),
                    "valor_pago" => "$ " . number_format($efectivo + $transaccion, 0, ",", "."),
                    "cambio" => "$ " . number_format(($efectivo + $transaccion) - $valor_venta, 0, ",", "."),
                    "mensaje" => $mensaje,
                    "mesas" => view('pedidos/todas_las_mesas_lista', [
                        "mesas" => $mesas,
                    ]),
                    "tipo_pago" => $tipo_pago
                );

                echo  json_encode($returnData);
            }
        } else if ($numero_facturas['numeroconsecutivo'] > $rango_final['rangofinaldian'] and $diferencia_fecha->format('%R%a') >= 0) {  // No se puede facturar por que la numeracion esta vencida 

            $returnData = array(

                "resultado" => 0,
                "mensaje" => "No es posible facturar, resolucion pos vencida por numeracion"

            );
            echo  json_encode($returnData);
        } else if ($numero_facturas['numeroconsecutivo'] < $rango_final['rangofinaldian'] and $diferencia_fecha->format('%R%a') < 0) { // No se puede facturar por fecha vencida 

            $returnData = array(

                "resultado" => 0,
                "mensaje" => "No es posible facturar resolucion pos, vencidad por fecha"

            );
            echo  json_encode($returnData);
        } else if ($numero_facturas['numeroconsecutivo'] > $rango_final['rangofinaldian'] and $diferencia_fecha->format('%R%a') < 0) { // No se puede facturar por fecha y numeracion 

            $returnData = array(

                "resultado" => 0,
                "mensaje" => "No es posible facturar resolucion pos, vencidad por fecha y numeracion"

            );
            echo  json_encode($returnData);
        }
    }
}
