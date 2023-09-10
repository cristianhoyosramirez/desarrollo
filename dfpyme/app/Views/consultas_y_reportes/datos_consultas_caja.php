<?php $user_session = session(); ?>
<?= $this->extend('template/consultas_reportes') ?>
<?= $this->section('title') ?>
MOVIMIENTO DE CAJA
<?= $this->endSection('title') ?>
<?= $this->section('content') ?>
<style>
    /* CSS personalizado para cambiar el color de fondo en hover */
    .table-hover tbody tr:hover {
        background-color: #ECEFFD;
        /* Cambia este valor al color que desees en hover */
        /* También puedes agregar estilos adicionales, como el color de texto */
        color: #333;
        /* Cambia este valor al color que desees para el texto en hover */
    }
</style>

<div id="crud_apertura">
    <input type="hidden" value="<?php echo base_url() ?>" id="url">
    <div class="card-body">

        <div class="row ">
            <div class="col-4">
                <h2 class="page-title">
                    Cuadre de caja
                </h2>
            </div>
            <div class="col">
                <p id="fecha_apertura">Fecha apertura: <?php echo $fecha_apertura ?></p>
            </div>
            <div class="col">
                <p id="fecha_cierre">Fecha cierre: <?php echo $fecha_cierre ?></p>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="#" class="btn btn-outline-indigo" onclick="reporte_propinas()">
                            Propinas
                        </a>
                    </span>
                    <span class="d-none d-sm-inline">
                        <a href="#" class="btn btn-outline-green" onclick="imprimir_movimientos(<?php echo $id_apertura ?>)">
                            Imprimir
                        </a>
                    </span>
                    <span class="d-none d-sm-inline">
                        <form action="<?= base_url('consultas_y_reportes/reporte_de_ventas') ?>" method="POST" target="_blank">
                            <input type="hidden" value="pantalla" name="tipo_reporte" id="tipo_reporte">
                            <input type="hidden" name="id_apertura" value="<?php echo $id_apertura ?>" id="id_apertura">
                            <button type="button" class="btn btn-outline-warning btn-icon" onclick="reporte_ventas()">Ventas</button>
                        </form>
                    </span>
                    <form action="<?= base_url('consultas_y_reportes/informe_fiscal_desde_caja') ?>" method="POST">
                        <input type="hidden" name="id_apertura" value="<?php echo $id_apertura ?>" id="id_aperturas">
                        <button type="button" class="btn btn-outline-dark btn-icon" target="_blank" onclick="fiscal()">Fiscal </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-md-12 col-lg-5">
                <div class="card" style="height: calc(25rem + 12px)">
                    <div class="card-header">
                        <h3 class="card-title">Movimiento de caja</h3>
                    </div>
                    <div class="card card-body-scrollable card-body-scrollable-shadow">
                        <table class="table table-vcenter table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <td>Apertura</th>
                                    <td>Cierre</th>
                                </tr>
                            </thead>
                            <tbody id="aperturas">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="row">
                    <div class="card-header">
                        <h3 class="card-title">Ingresos</h3>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card ">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-up" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M13.5 16h-9.5a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v7.5"></path>
                                                <path d="M19 22v-6"></path>
                                                <path d="M22 19l-3 -3l-3 3"></path>
                                                <path d="M7 20h5"></path>
                                                <path d="M9 16v4"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-mediu">
                                            Apertura
                                        </div>
                                        <div class="text-muted">
                                            <p id="valor_apertura"> <?php echo $valor_apertura ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-currency-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2"></path>
                                                <path d="M12 3v3m0 12v3"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Efectivo
                                        </div>
                                        <div class="text-muted">
                                            <p id="valor_efectivo"> <?php echo $ingresos_efectivo ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-yellow text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrows-up-down" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 3l0 18"></path>
                                                <path d="M10 6l-3 -3l-3 3"></path>
                                                <path d="M20 18l-3 3l-3 -3"></path>
                                                <path d="M17 21l0 -18"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Tranferencia
                                        </div>
                                        <div class="text-muted">
                                            <p id="valor_transferencia"><?php echo $ingresos_transaccion ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sum" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 16v2a1 1 0 0 1 -1 1h-11l6 -7l-6 -7h11a1 1 0 0 1 1 1v2"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Total Ingreso
                                        </div>
                                        <div class="text-muted">
                                            <p id="total_ingresos"><?php echo $total_ingresos ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h4 class="card-title">Salidas</h4>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M20 12l-10 0"></path>
                                                <path d="M20 12l-4 4"></path>
                                                <path d="M20 12l-4 -4"></path>
                                                <path d="M4 4l0 16"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Retiro
                                        </div>
                                        <div class="text-muted">
                                            <p id="retiros"> <?php echo $retiros ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left-bar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M21 12h-18"></path>
                                                <path d="M6 9l-3 3l3 3"></path>
                                                <path d="M21 9v6"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Devoluci&oacute;n
                                        </div>
                                        <div class="text-muted">
                                            <p id="devoluciones"> <?php echo $devoluciones ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-yellow text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-ramp-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M7 3l0 8.707"></path>
                                                <path d="M11 7l-4 -4l-4 4"></path>
                                                <path d="M17 14l4 -4l-4 -4"></path>
                                                <path d="M7 21a11 11 0 0 1 11 -11h3"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Ret + Devo
                                        </div>
                                        <div class="text-muted">
                                            <p id="ret_dev"> <?php echo $retirosmasdevoluciones ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-desktop-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M13 16h-9a1 1 0 0 1 -1 -1v-10a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v5.5"></path>
                                                <path d="M7 20h6.5"></path>
                                                <path d="M9 16v4"></path>
                                                <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                                <path d="M19 21v1m0 -8v1"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Valor caja
                                        </div>
                                        <div class="text-muted">
                                            <p id="saldo_caja"> <?php echo $saldo_caja ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Cierre de caja</h3>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-blue text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-imac-dollar" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M13 17h-9a1 1 0 0 1 -1 -1v-12a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v6.5"></path>
                                                <path d="M3 13h11"></path>
                                                <path d="M8 21h5"></path>
                                                <path d="M10 17l-.5 4"></path>
                                                <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5"></path>
                                                <path d="M19 21v1m0 -8v1"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            C Efectivo
                                        </div>
                                        <div class="text-muted">
                                            <p id="cierre_efectivo"> <?php echo $efectivo_cierre ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-bank" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 21l18 0"></path>
                                                <path d="M3 10l18 0"></path>
                                                <path d="M5 6l7 -3l7 3"></path>
                                                <path d="M4 10l0 11"></path>
                                                <path d="M20 10l0 11"></path>
                                                <path d="M8 14l0 3"></path>
                                                <path d="M12 14l0 3"></path>
                                                <path d="M16 14l0 3"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            C Bancos
                                        </div>
                                        <div class="text-muted">
                                            <p id="cierre_bancos"><?php echo $transaccion_cierre ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-yellow text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/users -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-sum" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M18 16v2a1 1 0 0 1 -1 1h-11l6 -7l-6 -7h11a1 1 0 0 1 1 1v2"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Total
                                        </div>
                                        <div class="text-muted">
                                            <p id="total_cierre"><?php echo $total_cierre ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-diff" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                <path d="M12 10l0 4"></path>
                                                <path d="M10 12l4 0"></path>
                                                <path d="M10 17l4 0"></path>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <div class="font-weight-medium">
                                            Diferencia
                                        </div>
                                        <div class="text-muted">
                                            <p id="diferencia"> <?php echo $diferencia ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <!-- info-->
            </div>
        </div>





    </div>
</div>

</div>
<?= $this->include('consultas_y_reportes/modal_editar_apertura') ?>
<?= $this->include('consultas_y_reportes/modal_total_ingresos_efectivo') ?>
<?= $this->include('consultas_y_reportes/modal_total_ingresos_transaccion') ?>
<?= $this->include('consultas_y_reportes/modal_consulta_cierres') ?>
<?= $this->include('consultas_y_reportes/modal_retiros') ?>
<?= $this->include('consultas_y_reportes/modal_editar_cierre_efectivo') ?>
<?= $this->include('consultas_y_reportes/modal_editar_cierre_transaccion') ?>
<?= $this->include('caja/modal_edicion_retiro') ?>

<!-- Modal -->
<div class="modal fade" id="propinas" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Reporte de propinas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="tabla_propinas"></div>
            </div>

        </div>
    </div>
</div>
<script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/sweet_alert.js"></script>
<script>
    function reporte_propinas() {
        let url = document.getElementById("url").value;
        let id_apertura = document.getElementById("id_apertura").value;

        $.ajax({
            data: {
                id_apertura
            },
            url: url + "/" + "pedidos/reporte_propinas",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {

                    $('#tabla_propinas').html(resultado.propinas)
                    $("#propinas").modal("show");

                    sweet_alert('success', 'Registros encontrados  ');
                }
            },
        });

    }
</script>


<?= $this->endSection('content') ?>