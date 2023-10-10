<!-- Page header -->
<style>
    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        /* Cambia el color de fondo según tus preferencias */
        color: #fff;
        /* Cambia el color de texto según tus preferencias */
        cursor: pointer;
        border: 1px solid #007bff;
        /* Cambia el color del borde según tus preferencias */
        border-radius: 5px;
        /* Añade bordes redondeados según tus preferencias */
    }

    .custom-file-upload:hover {
        background-color: #0056b3;
        /* Cambia el color de fondo al pasar el cursor por encima según tus preferencias */
    }
</style>
<br>

<div id="listado_clientes">

    <?php if (!empty($clientes)) { ?>
        <?php foreach ($clientes as $detalle) { ?>

            <div class="card">
                <div class="row g-0 cursor-pointer" onclick="detalle_cliente(<?php echo  $detalle['id'] ?>)">
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
                                    <div class="mt-3 list-inline list-inline-dots mb-0 text-muted d-sm-block ">
                                        <div class=""><!-- Download SVG icon from http://tabler-icons.io/i/building-community -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5"></path>
                                                <path d="M9 4v13"></path>
                                                <path d="M15 7v5.5"></path>
                                                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z"></path>
                                                <path d="M19 18v.01"></path>
                                            </svg>
                                            <?php echo $detalle['direccion'] ?>
                                        </div>
                                        <div class="list-inline-item"><!-- Download SVG icon from http://tabler-icons.io/i/license -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                            </svg>
                                            <?php echo $detalle['telefono'] ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        <?php } ?>
    <?php } ?>

    <?php if (empty($clientes)) { ?>
        <div class="container">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>No hay clientes creados. </strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    <?php } ?>
</div>

<?php $user_session = session(); ?>
<!-- Modal -->
<div class="modal fade" id="modal_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <form class="card" id="frmCrearCliente" action="<?php base_url() ?>clientes/crear_cliente" method="POST" enctype="multipart/form-data">
                        <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $user_session->id_usuario; ?>">

                        <div class="card-body">
                            <div class="mb-3">

                                <!--  <div class="col-auto">
                                        <span class="avatar avatar-md cursor-pointer" style="background-image: url(<?php echo base_url() ?>/public/dist/img/foto.png)"></span>
                                    </div> -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Numero identificación</label>
                                            <input type="text" class="form-control" id="identificacion" name="identificacion">
                                            <span class="text-danger error-text identificacion_error"></span>
                                            <span class="text-danger" id="cliente_creado"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputEmail4" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre">
                                            <span class="text-danger error-text nombre_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Dirección casa </label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                        <span class="text-danger error-text direccion_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Dirección negocio </label>
                                        <input type="text" class="form-control" id="direccion_negocio" name="direccion_negocio">
                                        <span class="text-danger error-text direccion_negocio_error"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputAddress" class="form-label">Telefóno </label>
                                            <input type="text" class="form-control" id="telefono" name="telefono">
                                            <span class="text-danger error-text telefono_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputAddress" class="form-label">Telefóno negocio</label>
                                            <input type="text" class="form-control" id="telefono_negocio" name="telefono_negocio">
                                            <span class="text-danger error-text telefono_negocio_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputAddress2" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email">
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Referencia personal</label>
                                            <input type="text" class="form-control" id="referencia" name="referencia">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Telefono referencia</label>
                                            <input type="text" class="form-control" id="referencia_telefono" name="referencia_telefono" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Dirección referecia</label>
                                            <input type="text" class="form-control" id="referencia_direccion" name="referencia_direccion" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="foto_dni" class="custom-file-upload">
                                                Tomar foto
                                            </label>
                                            <input type="file" class="form-control" id="foto_dni" name="foto_dni" accept="image/*" capture="user">
                                            <span class="text-danger error-text foto_dni_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Foto cliente</label>
                                            <input type="file" class="form-control" id="foto_cliente" name="foto_cliente" accept="image/*" capture="user">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Foto casa</label>
                                            <input type="file" class="form-control" id="foto_casa" name="foto_casa" accept="image/*" capture="user">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Foto negocio</label>
                                            <input type="file" class="form-control" id="foto_negocio" name="foto_negocio" accept="image/*" capture="user">
                                            <span class="text-danger error-text foto_negocio_error"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="inputCity" class="form-label">Foto servio público </label>
                                            <input type="file" class="form-control" id="foto_servicio_publico" name="foto_servicio_publico" accept="image/*" capture="user">
                                            <span class="text-danger error-text foto_servicio_publico_error"></span>
                                        </div>
                                    </div>
                                    <!--  <label for="tomar-foto" class="custom-file-upload">
                                        Tomar foto
                                    </label>
                                    <input type="file" id="tomar-foto" accept="image/*,video/*" capture="user"> -->



                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">

                            <button type="submit" class="btn btn-green" id="btnCrearCliente">Guardar</button>
                            <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url() ?>public/js/clientes/crear_cliente.js"></script><!-- Abre un modal en el home para la creacion de un nuevo cliente  -->
<script src="<?= base_url() ?>public/js/clientes/buscar_cliente.js"></script><!-- Abre un modal en el home para la creacion de un nuevo cliente  -->