<?php

namespace App\Controllers\factura_electronica;

use App\Controllers\BaseController;

class FacturaElectronica extends BaseController
{
    public function index()
    {
        return view('home/home');
    }

    function pre_factura()
    {
        $id_regimen = model('empresaModel')->select('idregimen')->first();
        $usuario = $this->request->getPost('usuario');
        //$usuario = 6;

        $numer = model('cajaModel')->select('consecutivo_factura_electronica')->first();

        $numero = $numer['consecutivo_factura_electronica'] + 1;
        $valor_total = model('pedidoPosModel')->select('valor_total')->where('fk_usuario', $usuario)->first();
        $id_resolucion = model('resolucionElectronicaModel')->select('id')->first();

        $data = [
            'nit_cliente' => $this->request->getPost('nit_cliente'),
            //'nit_cliente' => '222222222222',
            'estado' => false,
            'tipo' => 'INVOIC',
            'tipo_factura' => '01',
            'tipo_operacion' => '10',
            'tipo_ambiente' => '1',
            'id_status' => 1,
            //'numero' => $numero,
            'fecha' => date('Y-m-d'),
            'hora' => date("H:i:s"),
            'fecha_limite' => date('Y-m-d'),
            'numero_items' => 0,
            'total' => $valor_total['valor_total'],
            'neto' => $valor_total['valor_total'],
            'moneda' => 'COP',
            'id_resolucion' => 0,
            'metodo_pago' => 1,
            'medio_pago' => '10',
            'fecha_pago' => date('Y-m-d'),
            'version_ubl' => 'UBL 2.1',
            'version_dian' => 'DIAN 2.1',
            'transaccion_id' => '',
            'id_caja' => 1,
            'cancelled' => false
        ];

        //$insert = model('facturaElectronicaModel')->insert($data);

        $insert = model('facturaElectronicaModel')->insertar($data);

        $id_fact = model('facturaElectronicaModel')->selectMax('id')->first();

        $id_factura = $id_fact['id'];

        $numero_pedido = model('pedidoPosModel')->select('id')->where('fk_usuario', $usuario)->first();
        $productos = model('productoPedidoPosModel')->where('pk_pedido_pos', $numero_pedido['id'])->find();

        $item = array();
        $valor_antes_de_ico = "";
        $impuesto_al_consumo = "";
        $ico = "";
        $iva = "";
        $precio_unitario = "";
        if ($id_regimen['idregimen'] == 1) {  // Empresa con impuestos 

            if ($insert) {

                foreach ($productos as $detalle) {
                    /**
                     * Datos del producto y se traen desde la tabla producto 
                     */

                    $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                    $costo = model('productoModel')->select('precio_costo')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                    $aplica_ico = model('productoModel')->select('aplica_ico')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();

                    if ($aplica_ico['aplica_ico'] == 't') { // El producto tiene IMPUESTO DE BARES Y RESTAURANTES   

                        /**
                         * Calcular el ICO 
                         */
                        $id_ico_producto = model('productoModel')->select('id_ico_producto')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                        $porcentaje_ico = model('icoConsumoModel')->select('valor_ico')->where('id_ico', $id_ico_producto)->first();
                        $valor_ico = ($porcentaje_ico['valor_ico'] / 100) + 1;
                        $valor_antes_de_ico = $detalle['valor_unitario'] / $valor_ico;
                        $precio_unitario = $valor_antes_de_ico;
                        $ico = $porcentaje_ico['valor_ico'];
                        $iva = 0;

                        $insertar = model('itemFacturaElectronicaModel')->set_item_factura($id_factura, $detalle['codigointernoproducto'], $nombre_producto, $detalle['cantidad_producto'], $costo, $iva, $ico, $precio_unitario, $detalle['valor_unitario']);
                        //$id_factura, $codigo_interno, $nombre_producto, $cantidad, $costo, $iva, $ico, $precio_unitario, $total


                    } else if ($aplica_ico['aplica_ico'] == 'f') {  // El producto no tiene pero hay que calcularle el IVA 

                        $id_iva = model('productoModel')->select('idiva')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                        $porcentaje_iva = model('ivaModel')->select('valoriva')->where('idiva ', $id_iva['idiva'])->first();

                        $valor_porcentaje_iva = ($porcentaje_iva['valoriva'] / 100) + 1;
                        $valor_antes_de_iva  = $detalle['valor_unitario'] / $valor_porcentaje_iva;
                        $precio_unitario = $detalle['valor_unitario'] - $valor_antes_de_iva;
                        $ico = 0;
                        $iva = $porcentaje_iva['valoriva'];
                        $insertar = model('itemFacturaElectronicaModel')->set_item_factura($id_factura, $detalle['codigointernoproducto'], $nombre_producto, $detalle['cantidad_producto'], $costo, $iva, $ico, $valor_antes_de_iva, $detalle['valor_unitario']);
                    }
                }
            }
        } else if (($id_regimen['idregimen'] == 2)) {  //Empresa no responsabel de impuestos 

            $valor_antes_de_ico = 0;
            $impuesto_al_consumo = 0;
            $ico = 0;
            $iva = 0;

            foreach ($productos as $detalle) {
                $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                $costo = model('productoModel')->select('precio_costo')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();

                $insertar = model('itemFacturaElectronicaModel')->set_item_factura($id_factura, $detalle['codigointernoproducto'], $nombre_producto, $detalle['cantidad_producto'], $costo, $iva, $ico, $detalle['valor_unitario'], $detalle['valor_total']);
            }
        }
        if ($insert) {
            /**
             * Borrar los productos del pedido 
             */
            $borrar_producto_pedido = model('productoPedidoPosModel')->where('pk_pedido_pos', $numero_pedido['id']);
            $borrar_producto_pedido->delete();

            /**
             * Borrar el pedido 
             */

            $borrar_producto_pedido = model('pedidoPosModel')->where('id', $numero_pedido['id']);
            $borrar_producto_pedido->delete();

            $returnData = array(
                "resultado" => 1, //Falta plata  
            );
            echo  json_encode($returnData);
        }
    }
}
