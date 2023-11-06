<table class="table table-striped table-hover">
    <thead class="table-dark">
        <tr>
            <td scope="col">Cantidad</th>
            <td scope="col">Código</th>
            <td scope="col">Producto</th>
            <td scope="col">Valor unitario </th>
            <td scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productos as $detalle) { ?>
            <tr>
                <td ><?php echo $detalle['cantidad'] ?></th>
                <td ><?php echo $detalle['codigo'] ?></td>
                <td><?php echo $detalle['descripcion'] ?></td>
                <td><?php echo "$ ".number_format($detalle['total'], 0, ',', '.') ?></td>
                <td><?php echo "$ ".number_format($detalle['total']*$detalle['cantidad'], 0, ',', '.') ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>