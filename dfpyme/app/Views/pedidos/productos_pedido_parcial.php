<div class="table-responsive">
    <table class="table table-vcenter card-table table  table-hover table-border">

        <thead class="table-dark">
            <tr>
                <td scope="col">Producto </th>
                <td scope="col">Cantidad</th>
                <td scope="col">Cantidad a pagar </th>
                
            </tr>
        </thead>

        <tbody>

            <?php foreach ($productos as $detalle) { ?>

                <tr>
                    <td style="width: 200px;">
                        <?php echo $detalle['nombreproducto']; ?>

                    </td>

                    <td>
                        <input type="text" class=" form-control " value="<?php echo $detalle['cantidad_producto'] ?>"    readonly>

                    </td>

                    <td> <input type="text" class="form-control" onkeyup="actualizar_cantidad_partir_factura(this.value,<?php echo $detalle['id_tabla_producto'] ?>,<?php echo $detalle['cantidad_producto'] ?>)"></td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>