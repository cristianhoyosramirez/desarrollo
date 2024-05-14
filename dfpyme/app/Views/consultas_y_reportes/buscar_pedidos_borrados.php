<?php $user_session = session(); ?>
<?= $this->extend('template/consultas_reportes') ?>
<?= $this->section('title') ?>
BUSCAR PEDIDOS BORRADOS
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">

        </div>
    </div>
</div>
<br>
<!--Sart row-->
<div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Salones</a></li>
                    <li class="breadcrumb-item"><a href="#">Mesas</a></li>
                    <li class="breadcrumb-item"><a href="#">Usuarios</a></li>
                    <li class="breadcrumb-item"><a href="#">Empresa</a></li>
                </ol>
            </nav>
        </div>

        <div class="col-lg-auto ms-lg-auto">
            <p class="text-primary h3">BUSCAR PEDIDOS BORRADOS EN UN PERIODO DE TIEMPO </p>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
        </div>
    </div>
</div>
<div class="card container">

    <br>
    <div class="card-body">

        <!--  <form class="row g-3" id="formulario_movimiento_caja" action="<?= base_url('consultas_y_reportes/pedidos_borrados') ?>" method="POST">
            <div class="col-3">

                <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" name="fecha_inicial">
            </div>
            <div class="col-3">

                <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" name="fecha_final">
            </div>

            <div class="col-3">
                <button type="submit" class="btn btn-primary">Buscar </button>
            </div>


        </form> -->
        <div class="row">
            <label for="" class="form-label">Período</label>
            <div class="col-2">
                <select class="form-select" id="periodo_fechas">

                    <option value="1">Desde el inicio </option>
                    <option value="2">Fecha </option>
                    <option value="3">Periodo </option>
                </select>
            </div>

        </div>
        <br>


        <table class="table" id="pedidos_borrados">
            <thead class="table-dark">
                <tr>
                    <td scope="col">Fecha eliminación</th>
                    <td scope="col">Hora eliminación</th>
                    <td scope="col">Fecha creación</th>
                    <td scope="col">Número pedido</th>
                    <td scope="col">Valor pedido</th>
                    <td scope="col">Usuario creación</th>
                    <td scope="col">Usuario eliminación</th>
                    <td scope="col">Accion
                        </th>
                </tr>
            </thead>
            <tbody>



            </tbody>
        </table>

        <div class="row">
            <div class="col-10"></div>
            <div class="col-2">

                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="chart-sparkline chart-sparkline-square" id="sparkline-orders"></div>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium ">
                                    Total
                                </div>
                                <div class="text-muted ">
                                    <span id="total_pedidos"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

<input type="hidden" value="<?php  echo base_url() ?>" id="url">
<!-- Modal -->
<div class="modal fade" id="productos_borrados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Productos borrados </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="resultado_productos_borrados"></div>
            </div>
           
        </div>
    </div>
</div>



<?= $this->endSection('content') ?>