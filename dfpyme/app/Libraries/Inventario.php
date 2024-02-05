<?php

namespace App\Libraries;

class Inventario
{
    /**
     * Calcular imuestos
     * @param   $cod(igo_interno
     * 
     */
    public function actualizar_inventario($codigointerno, $id_tipo_inventario, $cantidad)
    {


        if ($id_tipo_inventario == 1) {
            $cantidad_inventario = model('inventarioModel')->select('cantidad_inventario')->where('codigointernoproducto', $codigointerno)->first();
            $inventario_final = $cantidad_inventario['cantidad_inventario'] - $cantidad;

            $data = [
                'cantidad_inventario' => $inventario_final,

            ];
            $model = model('inventarioModel');
            $actualizar = $model->set($data);
            $actualizar = $model->where('codigointernoproducto', $codigointerno);
            $actualizar = $model->update();
        } elseif ($id_tipo_inventario == 3) {

            $producto_fabricado = model('productoFabricadoModel')->select('*')->where('prod_fabricado', $codigointerno)->find();

            foreach ($producto_fabricado as $detall) {
                $descontar_de_inventario = $cantidad * $detall['cantidad'];

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
    }
}
