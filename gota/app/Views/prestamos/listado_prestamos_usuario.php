<br>
<?php if (!empty($prestamos)) { ?>
    <?php foreach ($prestamos as $detalle) { ?>
        <?php if (empty($detalle['imagen_cliente'])) : ?>
            <div class="card">
                <div class="row g-0 cursor-pointer" onclick="detalle_credito(event,<?php echo $detalle['id'] ?>)">
                    <div class="col-auto">
                        <div class="card-body">
                            <div class="avatar avatar-md" style="background-image: url(<?php echo base_url() ?>/public/dist/img/hombre.png )"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body ps-0">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-0"><?php echo $detalle['nombres'] ?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="mt-3 list-inline list-inline-dots mb-0 text-muted d-sm-block d-none">
                                        <div class="list-inline-item"><!-- Download SVG icon from http://tabler-icons.io/i/building-community -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                <path d="M9 4v13"></path>
                                                <path d="M15 7v5.5"></path>
                                                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                                                <path d="M19 18v.01"></path>
                                            </svg>
                                            <?php echo " VALOR PRESTADO: " . $detalle['valor_prestamo'] ?>
                                        </div>
                                        <div class="list-inline-item"><!-- Download SVG icon from http://tabler-icons.io/i/license -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                            </svg>
                                            <?php echo "FECHA PRIMER CUOTA " . $detalle['fecha_inicio'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <?php endif ?>


        <?php if (!empty($detalle['imagen_cliente'])) : ?>
            <div class="card">
                <div class="row g-0 cursor-pointer" onclick="detalle_credito(event,<?php echo $detalle['id'] ?>)">
                    <div class="col-auto">
                        <div class="card-body">
                            <div class="avatar avatar-md" style="background-image: url(<?php echo base_url() ?>/images/clientes/<?php echo $detalle['imagen_cliente'] ?> )"></div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body ps-0">
                            <div class="row">
                                <div class="col">
                                    <h3 class="mb-0"><?php echo $detalle['nombres'] ?></h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    <div class="mt-3 list-inline list-inline-dots mb-0 text-muted d-sm-block ">

                                        <div class="list-inline-ite">
                                            <?php echo "FECHA PRIMER CUOTA " . $detalle['fecha_inicio'] . "</br>" ?>
                                            <?php echo " VALOR PRESTADO: " . "$" . number_format($detalle['valor_prestamo'], 0, ",", ".") ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <?php endif ?>




    <?php } ?>
<?php } ?>

<?php if (empty($prestamos)) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>No hay prestamos </strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="modal_crear_prestamo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo prestamo </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php $user_session = session(); ?>
                <form class="row g-3" action="<?php base_url() ?>prestamos/generarPrestamo" method="POST" id="frm_prestamos">
                    <div class="col-md-4">
                        <label class="form-label">Cliente </label>
                        <div class="input-group input-group-flat">
                            <input type="hidden" value="<?php echo $user_session->id_usuario; ?>" name="id_usuario">
                            <input type="hidden" id="id_cliente" name="id_cliente">
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Buscar por nombre o identificación" onkeyup="saltar(event,'crear_usuario')">

                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="reset_inputs('nombre')"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M18 6l-12 12" />
                                        <path d="M6 6l12 12" />
                                    </svg>
                                </a>
                            </span>
                            <!--   <a class="btn btn-indigo btn-icon" title="Crear cliente" data-bs-toggle="tooltip" type="button" onclick="modal_crear_tercero()" >
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M16 19h6"></path>
                                    <path d="M19 16v6"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                </svg></a> -->
                        </div>
                        <span class="text-danger error-text nombre_error" id="error_cliente"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputPassword4" class="form-label">Monto solicitado </label>
                        <div class="input-icon mb-3">
                            <input type="text" class="form-control" id="monto" name="monto" inputmode="numeric">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="inputAddress" class="form-label">Detalle</label>
                        <div class="input-icon mb-3">
                            <input type="text" class="form-control" id="detalle" name="detalle">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="inputAddress2" class="form-label">Intereses</label>
                        <div class="input-icon mb-3">
                            <input type="number" class="form-control" id="intereses" name="intereses">
                            <span class="input-icon-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </span>
                        </div>
                        <span class="text-danger error-text intereses_error"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Tipo prestamo</label>
                        <select id="inputState" class="form-select">
                            <option selected>Nuevo</option>
                            <option>Renovación</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="inputAddress" class="form-label">Plazo</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="plazo" name="plazo" onkeyup="cuota(this.value)">

                            <select class="form-select" id="frecuencia" name="frecuencia">
                                <option selected>Dias</option>
                                <option value="1">Semana</option>
                                <option value="2">Quincena</option>
                                <option value="3">Mes</option>
                            </select>
                        </div>
                        <span class="text-danger error-text frecuencia_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="inputAddress2" class="form-label">valor cuota</label>
                        <input type="text" class="form-control" id="valor_cuota" name="valor_cuota" readonly="readonly">
                    </div>
                    <div class="col-md-4">
                        <br>
                        <label class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                            <span class="form-check-label">Aplicar mora</span>
                        </label>
                    </div>
                    <div class="col-md-4">

                        <select class="form-select" aria-label="Default select example">
                            <option selected>Frecuencia de pago </option>
                            <option value="1">De lunes a Sabado </option>
                            <option value="2">De Lunes a viernes </option>
                        </select>
                    </div>


                    <div class="row g-2 align-items-center">
                        <div class="col-3 col-sm-8 col-md-2 col-xl py-3">

                        </div>
                        <div class=" col-3 py-3">
                            <button class="btn btn-green  w-100" id="btnPrestamo">
                                Crear
                            </button>
                        </div>
                        <div class="col-3 py-3">
                            <button class="btn btn-red  w-100">
                                Cancelar
                            </button>
                        </div>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>public/js/clientes/autocompletar_cliente_prestamo.js"></script>
<script src="<?= base_url() ?>public/js/home/nuevo_prestamo.js"></script>

<script>
    function cuota(dias) {


        let monto = document.getElementById("monto").value;
        let montoSinPuntos = monto.replace(/\./g, '');
     
        let intereses = document.getElementById("intereses").value;
        let plazo = document.getElementById("plazo").value;

        interes = (parseInt(montoSinPuntos) * parseInt(intereses)) / parseInt(100)

        

        //val_cuota = (parseFloat(monto) / parseInt(plazo)) + interes
        val_cuota = (parseInt(montoSinPuntos) + parseInt(interes)) /plazo
        console.log(val_cuota);
        $('#valor_cuota').val(val_cuota.toLocaleString('es-CO'))


    }
</script>

<script>
    const monto = document.querySelector("#monto");

    function formatNumber(n) {
        // Elimina cualquier carácter que no sea un número
        n = n.replace(/\D/g, "");
        // Formatea el número
        return n === "" ? n : parseFloat(n).toLocaleString('es-CO');
    }

    monto.addEventListener("input", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });
</script>