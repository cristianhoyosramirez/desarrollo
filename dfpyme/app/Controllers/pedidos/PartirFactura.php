<?php

namespace App\Controllers\pedidos;

use App\Controllers\BaseController;

class PartirFactura extends BaseController
{
    public function index()
    {
        return view('home/home');
    }


    function partir_factura()
    {
        $id_tabla_partir_factura = $_REQUEST['id'];
        $cantidad = $_REQUEST['cantidad'];  //Se refiere al pago parcial 
        $cantidad_producto = $_REQUEST['cantidad_producto'];
        $id_mesa = $_REQUEST['id_mesa'];
        $numero_pedido = model('pedidoModel')->select('id')->where('fk_mesa', $id_mesa)->first();

        $valor_unitario = model('productoPedidoModel')->select('valor_unitario')->where('id', $id_tabla_partir_factura)->first();
        $codigo_interno = model('productoPedidoModel')->select('codigointernoproducto')->where('id', $id_tabla_partir_factura)->first();
        $nombre_producto = model('productoModel')->select('nombreproducto')->where('codigointernoproducto', $codigo_interno['codigointernoproducto'])->first();

        if ($cantidad_producto >= $cantidad) {
            $data = [
                'numero_de_pedido' => $numero_pedido['id'],
                'cantidad_producto' => $cantidad,
                'valor_unitario' => $valor_unitario['valor_unitario'],
                'valor_total' => $valor_unitario['valor_unitario'] * $cantidad,
                'codigointernoproducto' => $codigo_interno['codigointernoproducto'],
                'nombre_producto' => $nombre_producto['nombreproducto'],
                'id_tabla_producto' => $id_tabla_partir_factura

            ];

            $insertar = model('partirFacturaModel')->insert($data);

            if ($insertar) {

                $numero_pedido = $numero_pedido['id'];
                $producto_partir_factura = model('partirFacturaModel')->productos($numero_pedido);

                /*  $productos = view('partir_factura/partir_factura', [
                'productos' => $producto_partir_factura
            ]);

            $valor_total = model('partirFacturaModel')->select('valor_total')->where('id', $id_tabla_partir_factura)->first();
            $numero_pedido = model('partirFacturaModel')->select('numero_de_pedido')->where('id', $id_tabla_partir_factura)->first();

            $valor_total_pedido = model('partirFacturaModel')->selectSum('valor_total')->where('numero_de_pedido', $numero_pedido)->find(); */

                $returnData = array(
                    "resultado" => 1,
                    // "cantidad" => $cantidad,
                    //"valor_total_producto" => "$" . number_format($valor_total['valor_total'], 0, ",", "."),
                    /*   "valor_total_pedido" => "$" . number_format($valor_total_pedido[0]['valor_total'], 0, ",", "."),
                "productos" => $productos */
                );
                echo  json_encode($returnData);
            }
        }else{
            $returnData = array(
                "resultado" => 0,
                // "cantidad" => $cantidad,
                //"valor_total_producto" => "$" . number_format($valor_total['valor_total'], 0, ",", "."),
                /*   "valor_total_pedido" => "$" . number_format($valor_total_pedido[0]['valor_total'], 0, ",", "."),
            "productos" => $productos */
            );
            echo  json_encode($returnData);
        }
    }
}
