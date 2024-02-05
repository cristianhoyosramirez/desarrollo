<?php $session = session(); ?>
<?php $user_session = session(); ?>
<?= $this->extend('template/home') ?>

<?= $this->section('title') ?>
Ventas
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="card container">
    <div class="card-body">

        <div class="row">

            <div class="col">
                <label for="" class="form-label">Criterio de consulta </label>
                <input type="hidden" id="opcion_seleccionada">
                <input type="hidden" id="url" value="<?php echo base_url() ?>">
                <select name="criterio_consulta" id="criterio_consulta" class="form-select" onchange="seleccionCambiada(this.value)">
                    <option value="">Selecciona un criterio </option>
                    <option value="1">Número</option>
                    <option value="2">Tipo de documento</option>
                    <option value="3">Cliente</option>
                </select>
                <span id="error_de_seleccion" class="text-danger"></span>

            </div>

            <div class="col" style="display:none" id="tipo_de_documento">
                <label for="" class="form-label">Tipo de documento </label>
                <select name="tipo_documento" id="tipo_documento" class="form-select" onchange="limpiar_error_documento()">
                    <option value="">Selecciona un tipo de documento</option>
                    <?php foreach ($estado as $detalle) : ?>

                        <option value="<?php echo $detalle['idestado'] ?>"><?php echo $detalle['descripcionestado'] ?></option>

                    <?php endforeach ?>
                </select>

                <span id="error_tipo_documento" class="text-danger"></span>


            </div>

            <div class="col" id="numero" style="display:none">
                <label for="" class="form-label">Numero </label>

                <input type="text" class="form-control" id="numero_factura" name="numero_factura">
                <span id="error_numero" class="text-danger"></span>
            </div>

            <div class="col" style="display:none" id="cliente">
                <label for="" class="form-label">Cliente </label>
                <input type="hidden" id="nit_cliente" name="nit_cliente">
                <input type="text" class="form-control" id="buscar_cliente" name="buscar_cliente">
                <span id="error_cliente" class="text-danger"></span>
            </div>


            <div class="col" style="display:none" id="periodo">
                <div class="row">

                    <div class="col">
                        <label for="" class="form-label">Desde </label>
                        <input type="date" class="form-control" value="" id="fecha_inicial">
                    </div>
                    <div class="col">
                        <label for="" class="form-label">Hasta </label>
                        <input type="date" class="form-control" value="" id="fecha_final">
                    </div>

                </div>
            </div>
            <div class="col" id="periodo">
                <label for="" class="form-label text-light">Periodo </label>
                <button type="button" class="btn btn-primary" onclick="buscar()">Buscar</button>
            </div>
        </div>

        <br>

        <div id="resultado_consultado"></div>



    </div>
</div>

<script>
    function limpiar_error_documento() {
        $('#error_tipo_documento').html('')
    }
</script>




<script>
    function buscar() {
        var url = document.getElementById("url").value;
        var opcion = document.getElementById("opcion_seleccionada").value;
        var fecha_inicial = document.getElementById("fecha_inicial").value;
        var fecha_final = document.getElementById("fecha_final").value;
        var tipo_documento = document.getElementById("tipo_documento").value;
        var numero_factura = document.getElementById("numero_factura").value;
        var nit_cliente = document.getElementById("nit_cliente").value;

        if (opcion == "") {
            $('#error_de_seleccion').html('No hay seleccionado un criterio de búsqueda ')
        }
        if (opcion != "") {

            if (opcion == 1) {

                if (numero_factura == "") {
                    $('#error_numero').html('No se ha definido número de documento')
                }
                if (numero_factura != "") {

                    $.ajax({
                        data: {
                            numero_factura
                        },
                        url: url +
                            "/" +
                            "eventos/numero_documento",
                        type: "post",
                        success: function(resultado) {
                            var resultado = JSON.parse(resultado);
                            if (resultado.resultado == 1) {

                                $('#resultado_consultado').html(resultado.datos)



                            }
                        },
                    });
                }
            }
            if (opcion == 2) {
                if (tipo_documento == "") {
                    $('#error_tipo_documento').html('No hay documento seleccionado ')
                }
                if (tipo_documento != "") {

                    $.ajax({
                        data: {
                            tipo_documento,
                            fecha_inicial,
                            fecha_final
                        },
                        url: url +
                            "/" +
                            "eventos/consultar_documento",
                        type: "post",
                        success: function(resultado) {
                            var resultado = JSON.parse(resultado);
                            if (resultado.resultado == 1) {

                                $('#resultado_consultado').html(resultado.datos)



                            }
                        },
                    });
                }
            }
        }
        if (opcion == 3) {
            if (nit_cliente == "") {
                $('#error_cliente').html('No se ha definido un cliente')

            }
            if (nit_cliente != "") {
                $.ajax({
                    data: {
                        nit_cliente,
                        tipo_documento,
                        fecha_inicial,
                        fecha_final
                    },
                    url: url +
                        "/" +
                        "eventos/get_cliente",
                    type: "post",
                    success: function(resultado) {
                        var resultado = JSON.parse(resultado);
                        if (resultado.resultado == 1) {

                            $('#resultado_consultado').html(resultado.datos)



                        }
                    },
                });

            }
        }
    }
</script>

<script>
    function seleccionCambiada(opcion) {
        $('#error_de_seleccion').html('')
        if (opcion == 1) {
            $("#numero").show();
            $("#cliente").hide();
            $("#tipo_de_documento").hide();
            $("#periodo").hide();
        }

        if (opcion == 2) {
            $("#numero").hide();
            $("#cliente").hide();
            $("#tipo_de_documento").show();
            $("#periodo").show();
        }
        if (opcion == 3) {
            $("#numero").hide();
            $("#cliente").show();
            $("#tipo_de_documento").show();
            $("#periodo").show();
        }

        $('#opcion_seleccionada').val(opcion);

    }
</script>


<?= $this->endSection('content') ?>