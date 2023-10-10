<?php $user_session = session();  ?>
<form class="row g-3" action="<?php echo base_url() ?>usuarios/cambiar_clave" method="POST">

    <input type="hidden" value="<?php echo $user_session->id_usuario ?>" id="id_usuario" name="id_usuario">
    <div class="col-md-6">
        <label for="inputEmail4" class="form-label">Nueva clave </label>
        <input type="password" class="form-control" id="clave" name="clave" autocomplete="off" value="<?= old('clave') ?>">
        <br>
        <div class="text-danger"><?= session('errors.clave') ?></div>
    </div>
    <div class="col-md-6">
        <label for="inputPassword4" class="form-label">Confirmar clave </label>
        <input type="password" class="form-control" id="confirmar_clave" autocomplete="off" name="confirmar_clave" value="<?= old('confirmar_clave') ?>">
        <br>
        <div class="text-danger"><?= session('errors.confirmar_clave') ?></div>
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