<!-- Modal -->
<div class="modal fade" id="modal_meseros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    <p id="texto_mesero">Seleccione mesero</p>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="meseros">
                <input type="hidden" id="id_mesa_actualizar">

                <div id="lista_meseros">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-10">
                            </div>
                            <div class="col-12 col-md-2 mt-2 mt-md-0 text-md-start">
                                <button type="button" class="btn btn-outline-yellow" onclick="agregar_mesero()">Agregar mesero</button>
                            </div>
                        </div>

                    </div>

                    <div class="my-3"></div>
                    <div class="row container">
                        <?php $count = 0; ?>
                        <?php foreach ($meseros as $detalle) : ?>
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2" onclick="meseros(<?php echo $detalle['idusuario_sistema']  ?>)" class="cursor-pointer">
                                <a href="#" class="card card-link card-link-pop bg-primary-lt">
                                    <div class="card-body text-center"><?php echo $detalle['nombresusuario_sistema']; ?></div>
                                </a>
                            </div>
                            <?php $count++; ?>
                            <?php if ($count % 4 == 0) : ?> <!-- Insert a line break after every 4 buttons on small screens -->
                                <div class="w-100 d-md-none"></div>
                            <?php elseif ($count % 6 == 0) : ?> <!-- Insert a line break after every 6 buttons on medium screens -->
                                <div class="w-100 d-lg-none"></div>
                            <?php endif; ?>
                        <?php endforeach ?>
                    </div>

                </div>
            </div>
            <div class="my-1"></div>
            <div class="container" id="crear_meseros" style="display: none;">
                <form class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Nombres y apellidos</label>
                        <input type="email" class="form-control" id="nombre" name="nombre" onkeyup="limpiar_campo()">
                        <p id="error_nombre" class="text-danger"></p>
                    </div>
                    <div class="col-md-6"><br>
                        <button type="button" class="btn btn-primary" onclick="crear_mesero()">Crear mesero</button>
                    </div>
                </form>
            </div>
            <div class="my-2"></div>


        </div>
    </div>
</div>
</div>


<script>
    function agregar_mesero() {
        var lista_meseros = document.getElementById("meseros");
        lista_meseros.style.display = "none";

        var crear_meseros = document.getElementById("crear_meseros");
        crear_meseros.style.display = "block";
        $('#texto_mesero').html('Crear mesero')
    }
</script>

<script>
    function crear_mesero() {
        let url = document.getElementById("url").value;
        let nombre = document.getElementById("nombre").value;
        let id_mesa = document.getElementById("id_mesa_pedido").value;
        if (nombre != "") {
            $.ajax({
                data: {
                    nombre,
                    id_mesa
                },
                url: url + "/" + "pedidos/crear_mesero",
                type: "POST",
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);
                    if (resultado.resultado == 1) {

                        $("#modal_meseros").modal("hide");
                        $("#nombre_mesero").html('Mesero: ' + resultado.nombre);
                        var lista_meseros = document.getElementById("meseros");
                        lista_meseros.style.display = "block";

                        var crear_meseros = document.getElementById("crear_meseros");
                        crear_meseros.style.display = "none";



                    }
                },
            });
        }
        if (nombre == "") {
            $('#error_nombre').html('Dato necessario ')
        }
    }
</script>

<script>
    function limpiar_campo() {
        $('#error_nombre').html('');
    }
</script>