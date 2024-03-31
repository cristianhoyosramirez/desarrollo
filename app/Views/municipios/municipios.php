<select class="form-select" aria-label="Default select example">
 
<?php foreach ($municipios as $detalle){?>

    <option value="<?php echo $detalle['id']?>"><?php echo $detalle['code']."-". $detalle['nombre'] ?></option>

    <?php }?>
</select>