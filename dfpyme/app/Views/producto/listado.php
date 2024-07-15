<?= $this->extend('template/producto') ?>
<?= $this->section('title') ?>
LISTADO DE PRODUCTOS
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>



<br>
<!--Sart row-->
<!-- <div class="container">
    <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
            <div class="row">
                <div class="col">

                    <a class="btn  btn-outline-success btn-icon  " title="Exportar a Excel " data-bs-toggle="tooltip" type="submit">Productos Borrados </a>
                </div>
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
</div> -->

<div class="container">
    <div class="row">
        <div class="col-1">
            <a class="nav-link"><img style="cursor:pointer;" src="<?php echo base_url(); ?>/Assets/img/atras.png" width="20" height="20" onClick="history.go(-1);" title="Sección anterior"></a>
        </div>

        <div class="col-5">
            <p class="text-primary h3 text-center">LISTA GENERAL DE PRODUCTOS </p>
        </div>
        <div class="col-2 text-end">
            <a class="btn  btn-outline-success btn-icon  " title="Ver productos borrados " data-bs-toggle="tooltip" onclick="productos_eliminandos()">Productos inactivos </a>
        </div>
        <div class="col-1 text-start">
            <form action="<?php echo base_url() ?>/inventario/exportar_excel" method="get">
                <button class="btn  btn-outline-success btn-icon  w-100 " title="Exportar a Excel" data-bs-toggle="tooltip" type="submit">Excel</button>
            </form>
        </div>
        <div class="col-1 text-start">
            <form action="<?php echo base_url() ?>/inventario/exportar" method="get">
                <button class="btn  btn-outline-red btn-icon w-100  " title="Exportar a PDF" data-bs-toggle="tooltip" type="submit">Pdf</button>
            </form>
        </div>
        <div class="col">
            <a onclick="agregar_producto()" class="btn btn-outline-warning btn-icon" title="Agregar producto " data-bs-toggle="tooltip">Agregar producto</a>
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


<!-- Modal -->
<div class="modal fade" id="productos_eliminados" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="eliminados"></div>
            </div>
           
        </div>
    </div>
</div>

<script>
    function productos_eliminandos() {

        let url = document.getElementById("url").value;

        $.ajax({

            url: url + "/" + "reportes/ver_productos_eliminanados",
            type: "GET",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {

                    $('#eliminados').html(resultado.productos);
                    $("#productos_eliminados").modal("show");

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-start',
                        showConfirmButton: false,
                        timer: 900,
                        timerProgressBar: false,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseleave', Swal.resumeTimer);
                        }
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Registros encontrados'
                    });
                }
            },
        });
    }
</script>

<?= $this->endSection('content') ?>
<!-- end row -->
<script>
    function informacion_tributaria() {

    }
</script>