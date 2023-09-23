<!-- Modal -->
<div class="modal fade" id="modal_meseros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">
                    <p id="texto_mesero">Seleccione mesero</p>
                </h1>

            </div>
            <div class="modal-body" id="meseros">
                <input type="hidden" id="id_mesa_actualizar">

                <div id="lista_meseros">
                    <div class="container">
                        <div class="row">
                            <div class="col-10">
                            </div>
                            <div class="col-2">

                                <button type="button" class="btn btn-outline-yellow" onclick="agregar_mesero()">Agregar mesero </button>

                            </div>

                        </div>
                    </div>

                    <div class="my-3"></div>
                    <div class="row container">
                        <?php $count = 0; ?>
                        <?php foreach ($meseros as $detalle) : ?>
                            <div class="col-sm-4 col-md-2 col-xs-6 " onclick="meseros(<?php echo $detalle['idusuario_sistema']  ?>)" class="cursor-pointer">
                                <a href="#" class="card card-link card-link-pop bg-primary-lt">
                                    <div class="card-body text-center"><?php echo $detalle['nombresusuario_sistema']; ?></div>
                                </a>
                            </div>
                            <?php $count++; ?>
                            <?php if ($count % 6 == 0) : ?> <!-- Insert a line break after every 6 buttons -->
                                <div class="w-100 my-2"></div>
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
                        <input type="email" class="form-control" id="nombre" name="nombre">
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
</script>