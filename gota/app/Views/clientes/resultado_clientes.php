<!-- Page header -->

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
                <form class="row g-3" id="frmCrearCliente" action="<?php base_url() ?>clientes/crear_cliente" method="POST">
                    <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $user_session->id_usuario; ?>">
                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Numero identificacion</label>
                        <input type="text" class="form-control" id="identificacion" name="identificacion">
                        <span class="text-danger error-text identificacion_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="inputEmail4" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                        <span class="text-danger error-text nombre_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label for="inputPassword4" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion">
                        <span class="text-danger error-text direccion_error"></span>
                    </div>
                    <div class="col-4">
                        <label for="inputAddress" class="form-label">Telefóno</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                        <span class="text-danger error-text telefono_error"></span>
                    </div>
                    <div class="col-4">
                        <label for="inputAddress2" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="col-md-4">
                        <label for="inputCity" class="form-label">Referencia personal</label>
                        <input type="text" class="form-control" id="referencia" name="referencia">

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-green" id="btnCrearCliente">Guardar</button>
                        <button type="button" class="btn btn-red" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url() ?>public/js/clientes/crear_cliente.js"></script><!-- Abre un modal en el home para la creacion de un nuevo cliente  -->


<script>
    function buscar_cliente(valor) {

        let url = document.getElementById("url").value;

        $.ajax({
            data: {
                valor
            },
            url: url + "/" + "clientes/get_clientes",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {

                    $('#list_clientes').html(resultado.clientes)
                }
            },
        });


    }
</script>