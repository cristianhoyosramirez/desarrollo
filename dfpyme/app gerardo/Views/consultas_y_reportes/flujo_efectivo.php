<?php $user_session = session(); ?>
<?= $this->extend('template/consultas_reportes') ?>
<?= $this->section('title') ?>
REPORTE DE VENTAS DIARIAS
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>
<!--Star Breadcum-->
<div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Facturación</a></li>
                    <li class="breadcrumb-item"><a href="#">Facturación</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-auto ms-lg-auto">
            <p class="text-primary h3">GENERAR REPORTE DE MOVIMIENTO DE EFECTIVO EN PERIODO DE TIEMPO </p>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
        </div>
    </div>
</div>

<div class="card container">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Desde</label>
                <input type="date" class="form-control" id="fecha_inicial" value="<?php echo date('Y-m-d') ?>"> <br>
                <button type="button" onclick="reporte_movimiento_efectivo()" class="btn btn-success">Generar reporte</button>
            </div>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Hasta </label>
                <input type="date" class="form-control" id="fecha_final" value="<?php echo date('Y-m-d') ?>">
            </div>

        </div>
        <input type="hidden" value="<?= base_url() ?>" id="url"> <br>
        <div id="reporte_flujo_efectivo">

        </div>

    </div>
</div>

<?= $this->endSection('content') ?>