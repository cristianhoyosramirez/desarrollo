<?php $session = session(); ?>
<?php $user_session = session(); ?>
<?= $this->extend('template/home') ?>

<?= $this->section('title') ?>
Ventas
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>

<div class="card container">
    <div class="card-body">
        <input type="hidden" value="<?php echo $user_session->id_usuario ?>" id="id_usuario">
        <div class="row">

            <div class="col">
                <label for="" class="form-label">Criterio de consulta </label>
                <input type="hidden" id="opcion_seleccionada" value=2>
                <input type="hidden" id="url" value="<?php echo base_url() ?>">
                <select name="criterio_consulta" id="criterio_consulta" class="form-select" onchange="seleccionCambiada(this.value)">
                    <!--  <option value="1">NÚMERO</option> -->
                    <option value="2" selected>TIPO DE DOCUMENTO</option> <!-- Corrección: Añadido 'selected' -->
                    <option value="3">CLIENTE</option>
                </select>
                <span id="error_de_seleccion" class="text-danger"></span>
            </div>

            <div class="col" style="display:block" id="tipo_de_documento">
                <label for="" class="form-label">Tipo de documento </label>
                <select name="tipo_documento" id="tipo_documento" class="form-select" onchange="limpiar_error_documento()">

                    <?php foreach ($estado as $detalle) : ?>
                        <option value="<?php echo $detalle['idestado'] ?>" <?php if ($detalle['idestado'] == 5) : ?>selected <?php endif; ?>><?php echo $detalle['descripcionestado'] ?> </option>
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
                <div class="input-group input-group-flat">
                    <input type="text" class="form-control" id="buscar_cliente" name="buscar_cliente">
                    <span class="input-group-text">
                        <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiar_busqueda()"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M18 6l-12 12" />
                                <path d="M6 6l12 12" />
                            </svg>
                        </a>
                    </span>
                </div>
                <span id="error_cliente" class="text-danger"></span>
            </div>


            <!--     <div class="col">

                <label for="" class="form-label">Período</label>
                <select name="" id="periodo_tiempo" name="periodo" class="form-select">

                    <option value="">DESDE EL INICIO </option>
                    <option value="">FECHA  </option>
                    <option value="">ENTRE FECHAS </option>
                </select>

            </div> -->

            <div class="col" style="display:block" id="periodo">
                <div class="row">

                    <div class="col">
                        <label for="" class="form-label">Desde </label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" id="fecha_inicial">
                    </div>
                    <div class="col">
                        <label for="" class="form-label">Hasta </label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d') ?>" id="fecha_final">
                    </div>

                </div>
            </div>
            <div class="col" id="periodo">
                <label for="" class="form-label text-light">Periodo </label>
                <button type="button" class="btn btn-primary" onclick="buscar()">Buscar</button>
            </div>
        </div>
        <br>

        <div id="data_table_ventas">


            <table class="table" id="consulta_ventas">
                <thead class="table-dark">
                    <tr>

                        <td>Fecha </th>
                        <td>Nit cliente </th>
                        <td>Cliente</th>
                        <td>Documento</th>
                        <td>Valor </th>
                        <td>Tipo documento</th>
                        <td>Acción </th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>

        </div>

        <br>

        <div id="resultado_consultado"></div>
        <div class="row justify-content-end">

            <div class="col-md-4 col-lg-4" style="display: none;">
                <a href="#" class="card card-link card-link-pop bg-primary-lt">
                    <div class="card-body">
                        <h3 class="card-title">TOTAL ABONOS </h3>
                    </div>
                </a>
            </div>
            <div class="col-md-4 col-lg-4" style="display: none;">
                <a href="#" class="card card-link card-link-pop bg-primary-lt">
                    <div class="card-body">

                        <h3 class="card-title">TOTAL CRÉDITO </h3>
                    </div>
                </a>
            </div>

            <div class="col-md-4 col-lg-4">
                <a href="#" class="card card-link card-link-pop bg-primary-lt">
                    <div class="card-body">


                        <h4 class="card-title text-center">TOTAL DOCUMENTOS </h4>
                        <h3 class="card-title text-center" id="total_documentos">TOTAL DOCUMENTOS </h3>
                    </div>
                </a>
            </div>

        </div>
    </div>
</div>






<script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/f_e.js"></script>
<script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/imprimir_electronica.js"></script>

<script>
    function limpiar_busqueda() {
        $('#nit_cliente').val('')
        $('#buscar_cliente').val('')
        $('#buscar_cliente').focus()
    }
</script>


<script>
    function abono_credito(id_factura) {
        var url = document.getElementById("url").value;
        $.ajax({
            data: {
                id_factura,
            },
            url: url + "/" + "consultas_y_reportes/saldo_factura",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {
                    $('#abono_a_factura').html('Abono a factura :' + resultado.numero_factura)
                    $('#valor_factura_credito').val(resultado.valor_factura)
                    $('#saldo_factura_credito').val(resultado.saldo)
                    $('#id_factura_credito').val(resultado.id_factura)

                    myModal = new bootstrap.Modal(
                        document.getElementById("abono_factura"), {}
                    );
                    myModal.show();
                }
                if (resultado.resultado == 0) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'info',
                        title: 'Cliente no tiene saldo cartera '
                    })

                }
            },
        });

    }

    $(function() {
        $("#abono_factura").on("shown.bs.modal", function(e) {
            $("#abono_factura_credito").focus();
        });
    });


    const abonar_a_factura =
        document.querySelector("#valor_abono_factura_credito");

    function formatNumber(n) {
        n = String(n).replace(/\D/g, "");
        return n === "" ? n : Number(n).toLocaleString();
    }
    abonar_a_factura.addEventListener("keyup", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });

    const abonar_a_factura_transaccion =
        document.querySelector("#valor_abono_factura_credito_transaccion");

    function formatNumber(n) {
        n = String(n).replace(/\D/g, "");
        return n === "" ? n : Number(n).toLocaleString();
    }
    abonar_a_factura_transaccion.addEventListener("keyup", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });


    function saltar(e, id) {
        // Obtenemos la tecla pulsada
        (e.keyCode) ? k = e.keyCode: k = e.which;

        // Si la tecla pulsada es enter (codigo ascii 13)
        if (k == 13) {
            // Si la variable id contiene "submit" enviamos el formulario
            if (id == "submit") {
                document.forms[0].submit();
            } else {
                // nos posicionamos en el siguiente input
                document.getElementById(id).focus();
            }
        }
        saldo_factura_credito
    }



    function cambio_efectivo_credito() {

        //var saldo_pendiente = document.getElementById("saldo_factura_credito").value;
        var saldo_pendiente = document.getElementById("abono_factura_credito").value;
        var saldo = parseInt(saldo_pendiente.replace(/[.]/g, ""));

        var pago_efectivo = document.getElementById("valor_abono_factura_credito").value;
        var pago_transaccion = document.getElementById("valor_abono_factura_credito_transaccion").value;


        var efectivo = parseInt(pago_efectivo.replace(/[.]/g, ""));
        var transaccion = parseInt(pago_transaccion.replace(/[.]/g, ""));
        var temp = parseInt(efectivo) + parseInt(transaccion);
        var res = parseInt(temp - saldo);
        resultado = res.toLocaleString();
        document.getElementById("cambio_abono_factura_credito").value = resultado;

    }

    function guardar_Abono() {


        var url = document.getElementById("url").value;
        var id_usuario = document.getElementById("id_usuario").value;
        var id_factura = document.getElementById("id_factura_credito").value;
        var efecti = document.getElementById("valor_abono_factura_credito").value;
        var efectivo = efecti.replace(/[.]/g, "");
        var transa = document.getElementById("valor_abono_factura_credito_transaccion").value;
        var transaccion = transa.replace(/[.]/g, "");

        var saldo_pendiente = document.getElementById("abono_factura_credito").value;
        var saldo = parseInt(saldo_pendiente.replace(/[.]/g, ""));

        var abono_cliente = document.getElementById("abono_factura_credito").value;
        var abono = parseInt(abono_cliente.replace(/[.]/g, ""));



        var resultado = parseInt(efectivo) + parseInt(transaccion)

        if (resultado < saldo) {
            $('#abono_credito_falta_plata').html('FALTA DINERO')

        } else if (resultado >= saldo) {



            $.ajax({
                data: {
                    efectivo,
                    transaccion,
                    id_factura,
                    abono,
                    saldo,
                    id_usuario
                },
                url: url + "/" + "consultas_y_reportes/actualizar_saldo",
                type: "POST",
                success: function(resultado) {
                    var resultado = JSON.parse(resultado);

                    if (resultado.resultado == 0) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'info',
                            title: 'No hay pedido para cagar una nota '
                        })
                    }
                    if (resultado.resultado == 1) {


                        $('#abono_factura').modal('hide');
                        $('#id_factura_credito').val('');
                        $('#saldo_factura_credito').val('0');
                        $('#valor_abono_factura_credito').val('0');
                        $('#valor_abono_factura_credito_transaccion').val('0');
                        $('#cambio_abono_factura_credito').val('0');
                        $('#abono_factura_credito').val('0');

                        mytable = $('#consulta_ventas').DataTable();
                        mytable.draw();

                        Swal.fire({
                            icon: "success",
                            title: "Abono realizado con éxito",
                            confirmButtonText: "Imprimir comprobante de ingreso",
                            confirmButtonColor: "#2AA13D",
                            showDenyButton: true,
                            denyButtonText: `No imprimir`,
                            denyButtonColor: "#C13333",
                            reverseButtons: true,
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                (id_ingreso = resultado.id_ingreso),
                                $.ajax({
                                    data: {
                                        id_ingreso,
                                    },
                                    url: url + "/" + "consultas_y_reportes/imprimir_ingreso",
                                    type: "POST",
                                    success: function(resultado) {
                                        var resultado = JSON.parse(resultado);

                                        if (resultado.resultado == 0) {
                                            $("#creacion_cliente_factura_pos").modal(
                                                "hide"
                                            );
                                            Swal.fire({
                                                icon: "success",
                                                title: "Cliente agregado",
                                            });
                                        }
                                        if (resultado.resultado == 1) {
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: 'top-end',
                                                showConfirmButton: false,
                                                timer: 3000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                }
                                            })

                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Impresón de factura correcta'
                                            })
                                        }
                                    },
                                });
                            } else if (result.isDenied) {
                                Swal.fire({
                                    icon: "info",
                                    confirmButtonText: "Aceptar",
                                    confirmButtonColor: "#2AA13D",
                                    title: "No se imprime la factura crédito",
                                });
                            }
                        });



                    }
                },
            });
        }
    }



    const abonar_a_factura_credit =
        document.querySelector("#abono_factura_credito");

    function formatNumber(n) {
        n = String(n).replace(/\D/g, "");
        return n === "" ? n : Number(n).toLocaleString();
    }
    abonar_a_factura_credit.addEventListener("keyup", (e) => {
        const element = e.target;
        const value = element.value;
        element.value = formatNumber(value);
    });



    function abono_efectivo_credito() {
        var saldo_pendiente = document.getElementById("saldo_factura_credito").value;
        var saldo = parseInt(saldo_pendiente.replace(/[.]/g, ""));

        var abono_cliente = document.getElementById("abono_factura_credito").value;
        var abono = parseInt(abono_cliente.replace(/[.]/g, ""));

        if (abono > saldo) {
            $('#abono_mayor_que_saldo').html('El abono supera el saldo ')
        }



    }
</script>


<script>
    function limpiar_error_documento() {
        $('#error_tipo_documento').html('')
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