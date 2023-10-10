<?php $user_session = session(); ?>
<!-- Modal -->
<div class="modal fade" id="modal_ingresos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Ingresos adicionales </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-1" action="<?php echo base_url() ?>ingresos/crear" method="POST">
          <div class="col-md-6">
            <label for="inputEmail4" class="form-label">Concepto </label>
            <input type="hidden" value="<?php echo $user_session->id_usuario ?>" name="id_usuario">

            <input type="text" class="form-control" id="concepto" name="concepto">
          </div>
          <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Valor </label>
            <input type="number" class="form-control" id="valor" name="valor">
          </div>

          <br>
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-success me-md-2" type="submit">Guardar </button>
            <button class="btn btn-danger" type="button">Cancelar </button>
          </div>
          <div class="col-12">
            <div class="form-check">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>