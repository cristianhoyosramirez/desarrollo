<?php $user_session = session(); ?>




<div class="card container">
  <div class="body">
    <br>
    <form class="row g-1" action="<?php  echo base_url()?>ingresos/gastos" method="POST">
      <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Concepto </label>
        <input type="text" class="form-control" id="conceto" name="concepto" autofocus>
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