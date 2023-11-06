<!-- Modal -->
<div class="modal fade" id="agregar_nota" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Agregar nota producto </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <input type="hidden" id="id_producto_pedido">
                <textarea class="form-control" id="nota_producto_pedido" rows="3" placeholder="Escriba la nota del producto ejemplo: Hamburgesa sin cebolla "></textarea>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="actualizar_nota()" >Guardar </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar </button>
            </div>
        </div>
    </div>
</div>