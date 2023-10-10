<?php $user_session = session(); ?>
<!-- Modal -->
<div class="modal fade" id="modal_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" id="frmCrearCliente" action="<?php base_url() ?>clientes/crear_cliente" method="POST">
        <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $user_session->id_usuario; ?>">  
        <div class="col-md-4">
            <label for="inputEmail4" class="form-label">Numero identificacion</label>
            <input type="text" class="form-control" id="identificacion" name="identificacion">
            <span class="text-danger error-text identificacion_error"></span>
          </div>

          <div class="col-md-4">
            <label for="inputEmail4" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre">
            <span class="text-danger error-text nombre_error"></span>
          </div>

          <div class="col-md-4">
            <label for="inputPassword4" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion">
            <span class="text-danger error-text direccion_error"></span>
          </div>
          <div class="col-4">
            <label for="inputAddress" class="form-label">Telefóno</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
            <span class="text-danger error-text telefono_error"></span>
          </div>
          <div class="col-4">
            <label for="inputAddress2" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email">
            <span class="text-danger error-text email_error"></span>
          </div>
          <div class="col-md-4">
            <label for="inputCity" class="form-label">Referencia personal</label>
            <input type="text" class="form-control" id="referencia" name="referencia">

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-green" id="btnCrearCliente">Guardar</button>
            <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>