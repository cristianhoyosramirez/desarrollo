<?php if (!empty($id_facturas)) { ?>
    <?php foreach ($id_facturas as $valor) {    ?>
        <?php
        $productos = model('kardexModel')->get_factutras_pos($valor['id_factura']);
        $costo_total = 0;
        $ico_total = 0;
        $iva_total = 0;


        $numero_factura = model('pagosModel')->select('documento')->where('id_factura', $valor['id_factura'])->first();
        $fecha_factura = model('pagosModel')->select('fecha')->where('id_factura', $valor['id_factura'])->first();
        $venta = model('pagosModel')->select('valor')->where('id_factura', $valor['id_factura'])->first();
        $id_estado = model('pagosModel')->select('id_estado')->where('id_factura', $valor['id_factura'])->first();

        if ($id_estado['id_estado'] == 1) {
            $nit = model('facturaVentaModel')->select('nitcliente')->where('id', $valor['id_factura'])->first();
            $factura = model('facturaVentaModel')->select('numerofactura_venta')->where('id', $valor['id_factura'])->first();
            $numero_factura = $factura['numerofactura_venta'];
            $nit_cliente = $nit['nitcliente'];
            $estado = "POS";
        }

        if ($id_estado['id_estado'] == 8) {
            $nit = model('facturaElectronicaModel')->select('nit_cliente')->where('id', $valor['id_factura'])->first();
            $factura = model('facturaElectronicaModel')->select('numero')->where('id', $valor['id_factura'])->first();
            $numero_factura = $factura['numero'];
            $nit_cliente = $nit['nit_cliente'];
            $estado = "ELECTRÓNICA";
        }
        $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $nit_cliente)->first();



        ?>

        <?php foreach ($productos as $detalle) {

            $costo = model('kardexModel')->select('costo')->where('id_factura', $detalle['id_factura'])->first();
            $ico = model('kardexModel')->select('ico')->where('id_factura', $detalle['id_factura'])->first();
            $iva = model('kardexModel')->select('iva')->where('id_factura', $detalle['id_factura'])->first();
            //$valor_costo=$costo['precio_costo']+$valor_costo;
            $costo_total += $costo['costo'] * $detalle['cantidad'];
            $ico_total += $ico['ico'];
            $iva_total += $iva['iva'];

        ?>
            <?php $total_productos = model('kardexModel')->selectSum('total')->where('id_factura', $valor['id_factura'])->findAll(); ?>
            <?php $base = $total_productos[0]['total'] - $ico_total ?>
            <tr>
                <td><?php echo $nit_cliente ?></td>
                <td><?php echo $nombre_cliente['nombrescliente'] ?></td>
                <td><?php echo $estado ?></td>
                <td><?php echo $numero_factura ?></td>
                <td><?php echo $fecha_factura['fecha'] ?></td>
                <td><?php echo "$ " . number_format($costo_total, 0, ",", ".") ?> </td>
                <td><?php echo "$ " . number_format($base, 0, ",", "."); ?></td>
                <td><?php echo "$ " . number_format($iva_total, 0, ",", ".") ?> </td>
                <td><?php echo "$ " . number_format($ico_total, 0, ",", ".") ?> </td>
                <td><?php echo "$ " . number_format($venta['valor'], 0, ",", ".") ?> </td>

            </tr>

        <?php } ?>
    <?php } ?>

    <div>

    </div>



    <tr class="table-dark">

        <td>Total costo </td>
        <td><?php echo "$ " . number_format($total_costo, 0, ",", ".") ?></td>
        <td>Total base</td>
        <td><?php echo  $tota_ventas = "$ " . number_format($total_venta - ($total_ico - $total_iva), 0, ",", ".")  ?> </td>
        <td>Total IVA</td>
        <td><?php echo "$ " . number_format($total_iva, 0, ",", ".")  ?></td>
        <td>Total ICO</td>
        <td><?php echo "$ " . number_format($total_ico, 0, ",", ".")  ?></td>
        <td>Total venta</td>
        <td><?php echo "$ " . number_format($total_venta, 0, ",", ".")  ?></td>
    </tr>
<?php } ?>

