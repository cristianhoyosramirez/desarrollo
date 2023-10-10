<?php $user_session = session(); ?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <?= $this->include('favicon') ?>
    <title>Bienvenidos al sistema de recaudo </title>
    <!-- CSS files -->
    <link href="<?php echo base_url() ?>/public/dist/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="<?php echo base_url() ?>/public/dist/css/css.css" rel="stylesheet" />

</head>

<body>
    <script src="<?php echo base_url() ?>/public/dist/js/demo-theme.min.js?1684106062"></script>
    <div class="page">
        <?= $this->include('layout/header') ?>
        <?= $this->include('layout/navbar') ?>
        <div class="page-wrapper">
            <!-- Page body -->
            <div class="page-body">
                <input type="hidden" value="<?php echo base_url(); ?>" id="url">

                <div class="card container">
                    <div class="card-body">
                        <form action="<?= base_url('cobrador/generar_apertura') ?>" method="POST">
                            <input type="hidden" value="<?php echo $user_session->id_usuario; ?>" name="id_usuario">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="inputEmail4" class="form-label">Cobrador </label>
                                    <select class="form-select select2" name="id_cobrador" id="id_cobrador">
                                        <option value="">Seleccione</option>
                                        <?php foreach ($cobradores as $detalle) { ?>
                                            <option value="<?php echo $detalle['id'] ?>"><?php echo $detalle['nombres'] ?> </option>
                                        <?php } ?>
                                    </select>
                                    <div class="text-danger"><?= session('errors.salon') ?></div>
                                </div>
                                <div class="col-md-4">
                                    <label for="inputEmail4" class="form-label">Base </label>
                                    <input type="number" class="form-control" name="base" id="base">
                                    <div class="text-danger"><?= session('errors.nombre') ?></div>
                                </div>

                            </div>
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary w-md"><i class="mdi mdi-plus"></i> Generar apertura </button>
                            </div>
                        </form>
                    </div>
                </div>




            </div>
            <!-- ../Page body -->
        </div>

        <!-- Tabler Core -->
        <script src="<?php echo base_url() ?>/public/dist/js/tabler.min.js?1684106062" defer></script>
















</body>

</html>