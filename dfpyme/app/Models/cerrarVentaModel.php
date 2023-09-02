<?php

namespace App\Models;

use CodeIgniter\Model;
use app\Libraries\CalcularImpuestos;

class cerrarVentaModel extends Model
{
    protected $table      = 'bancos';
    // Uncomment below if you want add primary key
    // protected $primaryKey = 'id';
    protected $allowedFields = ['nombre'];

    function producto_pedido($productos, $factura_venta, $numero_pedido, $numero_factura, $fecha_y_hora)
    {


        foreach ($productos as $detalle) {
            /* Datos del producto */
            $valor_venta_producto = model('productoModel')->select('valorventaproducto')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $codigo_categoria = model('productoModel')->select('codigocategoria')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $id_ico_producto = model('productoModel')->select('id_ico_producto')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $id_tipo_inventario = model('productoModel')->select('id_tipo_inventario')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $aplica_ico = model('productoModel')->select('aplica_ico')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();


            /* Calcular el impuesto al consumo*/
            $valor_imco = model('icoConsumoModel')->select('valor_ico')->where('id_ico', $id_ico_producto)->first();
            $valor_ico = ($valor_imco['valor_ico'] / 100) + 1;
            $valor_antes_de_ico = $detalle['valor_unitario'] / $valor_ico;
            $valor_venta_real = $valor_antes_de_ico;
            $impuesto_al_consumo = $detalle['valor_unitario'] - $valor_venta_real;

            if ($valor_imco['valor_ico'] == 0) {
                $valor_unitario = $valor_venta_producto['valorventaproducto'];
            }

            if ($valor_imco['valor_ico'] != 0) {
                $val_uni = $valor_venta_producto['valorventaproducto'] / $valor_ico;
                $valor_unitario = $valor_venta_producto['valorventaproducto'] - $val_uni;
            }

            $id_medida = model('productoMedidaModel')->select('idvalor_unidad_medida')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $total = model('productoPedidoModel')->select('valor_total')->where('id', $detalle['id'])->first();

            $precio_costo = model('productoModel')->select('precio_costo')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $id_factura = $factura_venta;

            $numero_factura = model('pedidoModel')->select('numero_factura')->where('id', $numero_pedido)->first();

            /**
             * Consultar el tipo de inventario y descontarlo
             */

            if ($id_tipo_inventario['id_tipo_inventario'] == 1) {
                $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();

                $inventario_final = $cantidad_inventario['cantidad_inventario'] - $detalle['cantidad_producto'];

                $data = [
                    'cantidad_inventario' => $inventario_final,

                ];
                $model = model('inventarioModel');
                $actualizar = $model->set($data);
                $actualizar = $model->where('codigointernoproducto', $detalle['codigointernoproducto']);
                $actualizar = $model->update();
            } elseif ($id_tipo_inventario['id_tipo_inventario'] == 3) {

                $producto_fabricado = model('productoFabricadoModel')->select('*')->where('prod_fabricado', $detalle['codigointernoproducto'])->find();

                foreach ($producto_fabricado as $detall) {
                    $descontar_de_inventario = $detalle['cantidad_producto'] * $detall['cantidad'];

                    $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $detall['prod_proceso'])->first();

                    $data = [
                        'cantidad_inventario' => $cantidad_inventario['cantidad_inventario'] - $descontar_de_inventario,

                    ];

                    $model = model('inventarioModel');
                    $actualizar = $model->set($data);
                    $actualizar = $model->where('codigointernoproducto', $detall['prod_proceso']);
                    $actualizar = $model->update();
                }
            }
            /* Impuesto iva */
            $id_iva = model('productoModel')->select('idiva')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            $porcentaje_iva = model('ivaModel')->select('valoriva')->where('idiva ', $id_iva['idiva'])->first();

            if ($porcentaje_iva['valoriva'] == 0) {
                $valor_unitario = $valor_venta_producto['valorventaproducto'];
                $valor_venta_real = $detalle['valor_unitario'];
                $iva = 0;
            }
            if ($porcentaje_iva['valoriva'] != 0) {
                $valor_porcentaje_iva = ($porcentaje_iva['valoriva'] / 100) + 1;
                $valor_unitario = $valor_venta_producto['valorventaproducto'] / $valor_porcentaje_iva;
                $valor_venta_real = $detalle['valor_unitario'] / $valor_porcentaje_iva;
                $iva = $detalle['valor_unitario'] - $valor_venta_real;
            }

            $numero_factura = model('pedidoModel')->select('numero_factura')->where('id', $numero_pedido)->first();

            /**
             * Consultar el tipo de inventario y descontarlo
             */
            $id_tipo_inventario = model('productoModel')->select('id_tipo_inventario')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
            if ($id_tipo_inventario['id_tipo_inventario'] == 1) {
                $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $detalle['codigointernoproducto'])->first();
                $inventario_final = $cantidad_inventario['cantidad_inventario'] - $detalle['cantidad_producto'];

                $data = [
                    'cantidad_inventario' => $inventario_final,

                ];
                $model = model('inventarioModel');
                $actualizar = $model->set($data);
                $actualizar = $model->where('codigointernoproducto', $detalle['codigointernoproducto']);
                $actualizar = $model->update();
            } elseif ($id_tipo_inventario['id_tipo_inventario'] == 3) {

                $producto_fabricado = model('productoFabricadoModel')->select('*')->where('prod_fabricado', $detalle['codigointernoproducto'])->find();


                foreach ($producto_fabricado as $detall) {
                    $descontar_de_inventario = $detalle['cantidad_producto'] * $detall['cantidad'];

                    $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $detall['prod_proceso'])->first();

                    $data = [
                        'cantidad_inventario' => $cantidad_inventario['cantidad_inventario'] - $descontar_de_inventario,

                    ];

                    $model = model('inventarioModel');
                    $actualizar = $model->set($data);
                    $actualizar = $model->where('codigointernoproducto', $detall['prod_proceso']);
                    $actualizar = $model->update();
                }
            }
            $producto_factura_venta = [
                'numerofactura_venta' => $numero_factura,
                'codigointernoproducto' => $detalle['codigointernoproducto'],
                'cantidadproducto_factura_venta' => $detalle['cantidad_producto'],
                'valorunitarioproducto_factura_venta' => $valor_unitario,
                'idmedida' => $id_medida['idvalor_unidad_medida'],
                'idcolor' => 0,
                'valor_descuento' => 0, //pendiente de ajuste
                'valor_recargo' => 0,
                'valor_iva' => $porcentaje_iva['valoriva'],
                'retorno' => false,
                'valor' => 0,
                'costo' => $precio_costo['precio_costo'],
                'id_factura' => $factura_venta,
                'valor_venta_real' =>  $valor_venta_real,
                'impoconsumo' => 0,
                'total' => $total['valor_total'],
                'valor_ico' => $valor_imco, //
                'impuesto_al_consumo' => $impuesto_al_consumo,
                'iva' => $iva,
                'id_iva' => $id_iva['idiva'],
                'aplica_ico' => $aplica_ico['aplica_ico'],
                'valor_total_producto' => $detalle['valor_unitario'],
                'fecha_y_hora_venta' => date("Y-m-d H:i:s"),
                'saldo' => 0,
                'fecha_y_hora_venta' => $fecha_y_hora,
                'fecha_venta' => date('Y-m-d'),
                'id_categoria' => $codigo_categoria['codigocategoria']
            ];

            $insertar = model('productoFacturaVentaModel')->insert($producto_factura_venta);
        }
    }


    function actualiar_pedido_consecutivos($numero_pedido,$numero_factura,$consecutivo)
    {
        $num_fact = model('pedidoModel');
        $numero_factura = $num_fact->set($numero_factura);
        $numero_factura = $num_fact->where('id', $numero_pedido);
        $numero_factura = $num_fact->update();

        $model = model('consecutivosModel');
        $numero_factura = $model->set($consecutivo);
        $numero_factura = $model->where('idconsecutivos', 8);
        $numero_factura = $model->update();
    }
}
