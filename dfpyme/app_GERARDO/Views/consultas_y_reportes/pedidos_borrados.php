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
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td scope="col">Fecha eliminación</th>
                    <td scope="col">Hora eliminación</th>
                    <td scope="col">Fecha creación</th>
                    <td scope="col">Pedido </th>
                    <td scope="col">Valor pedido </th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedidos_borrados as $detalle) { ?>
                    <tr>
                        <td><?php echo $detalle['fecha_eliminacion'] ?></th>
                        <td><?php echo $detalle['hora_eliminacion'] ?></th>
                        <td><?php echo $detalle['fecha_creacion'] ?></th>
                        <td><?php echo $detalle['numero_pedido'] ?></th>
                        <td><?php echo "$" . number_format($detalle['valor_pedido']) ?></th>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>

    </div>
</div>

<?= $this->endSection('content') ?>