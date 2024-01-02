<div class="row">
    
    <div class="col">
        <label for="" class="form-label">Nombre sub categoria </label>
        <input type="text" class="form-control" name="nombre_categoria" id="nombre_categoria" value="<?php echo $subcategoria['nombre'] ?>">
    </div>

</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-outline-success" onclick="actualizar_categoria(<?php echo $subcategoria['id'] ?>)">Guardar</button>
    <button type="button" class="btn btn-outline-red" data-bs-dismiss="modal">Cancelar </button>
</div>