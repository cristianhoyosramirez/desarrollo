<?= $this->extend('template/producto') ?>
<?= $this->section('title') ?>
LISTADO DE PRODUCTOS
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>


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
    </div>
</div>
<br>
<!--Sart row-->
<div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
            <div class="row">
                <div class="col">
                    <form action="<?php echo base_url() ?>/inventario/exportar_excel" method="get">
                        <button class="btn  btn-outline-success btn-icon w-100 " title="Exportar a Excel " data-bs-toggle="tooltip" type="submit">Excel</button>
                    </form>
                </div>
                <div class="col">
                    <form action="<?php echo base_url() ?>/inventario/exportar" method="get">
                        <button class="btn  btn-outline-red btn-icon w-100 " title="Exportar a PDF" data-bs-toggle="tooltip" type="submit">Pdf</button>
                    </form>
                </div>
                <div class="col">
                    <a onclick="agregar_producto()" class="btn btn-outline-warning btn-icon" title="Agregar producto " data-bs-toggle="tooltip">Agregar producto</a>
                </div>
                <div class="col">

                </div>

            </div>

        </div>

        <div class="col-lg-auto ms-lg-auto">
            <p class="text-primary h3">LISTA GENERAL DE PRODUCTOS </p>
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <input type="hidden" id="url" value="<?php echo base_url() ?>">
                    <table id="example" class="table">
                        <thead class="table-dark">
                            <td>Categoria </th>
                            <td>Código interno </th>
                            <td>Nombre producto</th>
                            <td>Cantidad</td>
                            <td>Valor venta </th>
                            <td>Acciones</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?= $this->include('modal_producto/crear_producto') ?>
<?= $this->include('modal_producto/edicion_de_producto') ?>
<?= $this->include('producto/modal_categoria') ?>

<?= $this->endSection('content') ?>
<!-- end row -->
<script>
    function informacion_tributaria() {

    }
</script>