<p>Factura electrónica de venta número  </p>
<p>Cliente </p>
<p>Fecha de factura </p>


<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <td scope="col">Código</th>
            <td scope="col">Cantidad</th>

            <td scope="col">Producto</th>
            <td scope="col">Valor unitario </th>
            <td scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $detalle) { ?>
            <tr>
                <td><?php echo $detalle['codigo'] ?></td>
                <td><?php echo $detalle['cantidad'] ?></th>

                <td><?php echo $detalle['descripcion'] ?></td>
                <td><?php echo "$ " . number_format($detalle['precio_unitario'], 0, ',', '.') ?></td>
                <td><?php echo "$ " . number_format($detalle['total'] , 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>