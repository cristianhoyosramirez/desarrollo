<tr>
    <?php foreach ($categorias as $detalle) { ?>

        <input type="hidden" name="codigo_categoria" value="<?php echo $detalle['codigocategoria'] ?>">
<tr>
    <td> <input type="text" value="<?php echo $detalle['nombrecategoria'] ?>" class="form-control"  onkeyup="actualizar_categoria(event, this.value,<?php echo $detalle['codigocategoria'] ?>)"  placeholder="Cambiar el nombre de la categoria "></td>
    <td>
        <select class="form-select" id="estado_categoria" name="estado_categoria" onchange="estado_categoria(this.options[this.selectedIndex].value,<?php echo $detalle['codigocategoria'] ?>)">
            <option value="true" <?php if ($detalle['permitir_categoria'] == 't') : ?>selected <?php endif; ?>>
                <p class="text-success">ACTIVA</p>
            </option>
            <option value="false" <?php if ($detalle['permitir_categoria'] == 'f') : ?>selected <?php endif; ?>>
                <p class="text-success">INACTIVA</p>
            </option>
        </select>
    </td>
    <td>
        <div class="row">
            <div class="col-md-6">
                <select class="form-select" id="id_impresora" name="id_impresora" onchange="asociar_impresora(this.options[this.selectedIndex].value,<?php echo $detalle['codigocategoria'] ?>)">
                    <?php foreach ($impresoras as $detalles) { ?>
                        <?php if (empty($detalle['impresora'])) { ?>
                            <option>CATEGORIA NO TIENE IMPRESORA ASOCIADA </option>
                        <?php } ?>
                        <option value="<?php echo $detalles['id'] ?>" <?php if ($detalles['id'] == $detalle['impresora']) : ?>selected <?php endif; ?>><?php echo "Cód:" . " " . $detalles['id'] . "-" . $detalles['nombre'] ?></option>
                    <?php } ?>
                </select>

            </div>
        </div>
    </td>
</tr>

<?php } ?>
</tr>