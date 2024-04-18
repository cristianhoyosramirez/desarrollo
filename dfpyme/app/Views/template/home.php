<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?= $this->renderSection('title') ?>&nbsp;-&nbsp;DF PYME</title>
    <!-- CSS files -->
    <link href="<?= base_url() ?>/Assets/css/tabler.min.css" rel="stylesheet" />
    <!-- Select 2 -->
    <link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <!-- Data tables -->
    <link href="<?= base_url() ?>/Assets/plugin/data_tables/bootstrap.min.css" />
    <link href="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.css" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>/Assets/img/favicon.png">
    <!-- Jquery-ui -->
    <link href="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.css" rel="stylesheet">

    <!-- Data tables -->
    <link href="<?= base_url() ?>/Assets/plugin/data_tables/bootstrap.min.css" />
    <link href="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.css" />
</head>
<?php $session = session(); ?>

<body>
    <div class="wrapper">
        <?= $this->include('layout/header_mesas') ?>


        <div class="page-wrapper">
            <div class="container-xl">
            </div>
            <div class="page-body">
                <?= $this->renderSection('content') ?>
                <?= $this->include('pedidos/modal_trasmision_electronica') ?>
                <?= $this->include('modal_abono_factura/modal_detalle_factura') ?>
                <?= $this->include('ventanas_modal_duplicado_factura/detalle_factura') ?>
                <?= $this->include('modal_abono_factura/abono') ?>
            </div>
            <?= $this->include('layout/footer') ?>
        </div>
        <!-- Libs JS -->
        <!-- Tabler Core -->
        <script src="<?= base_url() ?>/Assets/js/tabler.min.js"></script>
        <!-- J QUERY -->
        <script src="<?= base_url() ?>/Assets/js/jquery-3.5.1.js"></script>
        <!-- Sweet alert -->
        <script src="<?php echo base_url(); ?>/Assets/plugin/sweet-alert2/sweetalert2@11.js"></script>

        <!-- jQuery-ui -->
        <script src="<?php echo base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.js"></script>

        <!--select2 -->
        <script src="<?php echo base_url(); ?>/Assets/plugin/select2/select2.min.js"></script>

        <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/nueva_factura.js"></script>
        <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/detalle_f_e.js"></script>
        <script src="<?= base_url() ?>/Assets/script_js/nuevo_desarrollo/sweet_alert_start.js"></script>
        <script src="<?= base_url() ?>/Assets/script_js/duplicado_factura/imprimir_duplicado_factura.js"></script>
        <script src="<?= base_url() ?>/Assets/script_js/duplicado_factura/detalle_factura.js"></script>


        <!-- Data tables -->
        <script src="<?= base_url() ?>/Assets/plugin/data_tables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.js"></script>


        <script>
            function limpiar() {
                document.getElementById("abono_factura_credito").addEventListener("keydown", function(event) {
                    if (event.key === "Backspace") {
                        limpiar(); // Llama a la función limpiar solo si se presiona Backspace

                        $('#abono_mayor_que_saldo').html('')
                    }
                });
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




                if ($.fn.DataTable.isDataTable('#consulta_ventas')) {
                    $('#consulta_ventas').DataTable().destroy();
                }


                if (opcion == "") {

                    /*       $.ajax({
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
                          }); */


                    $('#consulta_ventas').DataTable({
                        serverSide: true,
                        processing: true,
                        searching: false,
                        order: [
                            [0, 'desc']
                        ],
                        language: {
                            decimal: "",
                            emptyTable: "No hay datos",
                            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                            infoEmpty: "Mostrando 0 a 0 de 0 registros",
                            infoFiltered: "(Filtro de _MAX_ total registros)",
                            infoPostFix: "",
                            thousands: ",",
                            lengthMenu: "Mostrar _MENU_ registros",
                            loadingRecords: "Cargando...",
                            processing: "Procesando...",
                            search: "Buscar",
                            zeroRecords: "No se encontraron coincidencias",
                            paginate: {
                                first: "Primero",
                                last: "Ultimo",
                                next: "Próximo",
                                previous: "Anterior"
                            },
                            aria: {
                                sortAscending: ": Activar orden de columna ascendente",
                                sortDescending: ": Activar orden de columna desendente"
                            }
                        },
                        ajax: {
                            url: '<?php echo base_url() ?>' + "/eventos/consultar_documento",
                            data: function(d) {
                                return $.extend({}, d, {
                                    // documento: documento,
                                    fecha_inicial: fecha_inicial,
                                    fecha_final: fecha_final
                                });
                            },
                            dataSrc: function(json) {
                                /*  $('#saldo_total').html(json.total);
                                 $('#saldo_cliente').html(json.saldo);
                                 $('#pagos_factura').html(json.pagos); */


                                $('#saldo').html(json.saldo_pendiente_por_cobrar);
                                $('#abonos').html(json.abonos);
                                $('#total_documentos').html(json.total);
                                $('#total_ventas').html(json.titulo);
                                return json.data;
                            }
                        },
                        columnDefs: [{
                            targets: [4],
                            orderable: false
                        }]
                    });




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
                        if (tipo_documento == 8) {

                            $('#consulta_ventas').DataTable({
                                serverSide: true,
                                processing: true,
                                searching: false,
                                order: [
                                    [0, 'desc']
                                ],
                                language: {
                                    decimal: "",
                                    emptyTable: "No hay datos",
                                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                                    infoFiltered: "(Filtro de _MAX_ total registros)",
                                    infoPostFix: "",
                                    thousands: ",",
                                    lengthMenu: "Mostrar _MENU_ registros",
                                    loadingRecords: "Cargando...",
                                    processing: "Procesando...",
                                    search: "Buscar",
                                    zeroRecords: "No se encontraron coincidencias",
                                    paginate: {
                                        first: "Primero",
                                        last: "Ultimo",
                                        next: "Próximo",
                                        previous: "Anterior"
                                    },
                                    aria: {
                                        sortAscending: ": Activar orden de columna ascendente",
                                        sortDescending: ": Activar orden de columna desendente"
                                    }
                                },
                                ajax: {
                                    url: '<?php echo base_url() ?>' + "/eventos/consultar_documento",
                                    data: function(d) {
                                        return $.extend({}, d, {
                                            // documento: documento,
                                            fecha_inicial: fecha_inicial,
                                            fecha_final: fecha_final
                                        });
                                    },
                                    dataSrc: function(json) {
                                        /* $('#saldo_total').html(json.total);
                                        $('#saldo_cliente').html(json.saldo);
                                        $('#pagos_factura').html(json.pagos); */



                                        $('#saldo').html(json.saldo_pendiente_por_cobrar);
                                        $('#abonos').html(json.abonos);
                                        $('#total_documentos').html(json.total);
                                        $('#total_ventas').html(json.titulo);


                                        return json.data;
                                    }
                                },
                                columnDefs: [{
                                    targets: [4],
                                    orderable: false
                                }]
                            });
                        }

                        if (tipo_documento != 8) {




                            $('#consulta_ventas').DataTable({
                                serverSide: true,
                                processing: true,
                                searching: false,
                                order: [
                                    [0, 'desc']
                                ],
                                language: {
                                    decimal: "",
                                    emptyTable: "No hay datos",
                                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                                    infoFiltered: "(Filtro de _MAX_ total registros)",
                                    infoPostFix: "",
                                    thousands: ",",
                                    lengthMenu: "Mostrar _MENU_ registros",
                                    loadingRecords: "Cargando...",
                                    processing: "Procesando...",
                                    search: "Buscar",
                                    zeroRecords: "No se encontraron coincidencias",
                                    paginate: {
                                        first: "Primero",
                                        last: "Ultimo",
                                        next: "Próximo",
                                        previous: "Anterior"
                                    },
                                    aria: {
                                        sortAscending: ": Activar orden de columna ascendente",
                                        sortDescending: ": Activar orden de columna desendente"
                                    }
                                },
                                ajax: {
                                    url: '<?php echo base_url() ?>' + "/eventos/consultar_de_tipo_documento",
                                    data: function(d) {
                                        return $.extend({}, d, {
                                            tipo_documento: tipo_documento,
                                            fecha_inicial: fecha_inicial,
                                            fecha_final: fecha_final
                                        });
                                    },
                                    dataSrc: function(json) {
                                        $('#c_x_c').html(json.cuentas_por_cobrar);
                                        $('#abonos').html(json.abonos);
                                        $('#saldo').html(json.saldo_pendiente);
                                        $('#total_documentos').html(json.total);

                                        return json.data;
                                    }
                                },
                                columnDefs: [{
                                    targets: [4],
                                    orderable: false
                                }]
                            });
                        }

                    }
                }
                if (opcion == 3) {
                    if (nit_cliente == "") {
                        $('#error_cliente').html('No se ha definido un cliente')

                    }
                    if (nit_cliente != "") {
                        /*  $.ajax({
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
                         }); */

                        $('#consulta_ventas').DataTable({
                            serverSide: true,
                            processing: true,
                            searching: false,
                            order: [
                                [0, 'desc']
                            ],
                            language: {
                                decimal: "",
                                emptyTable: "No hay datos",
                                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                                infoFiltered: "(Filtro de _MAX_ total registros)",
                                infoPostFix: "",
                                thousands: ",",
                                lengthMenu: "Mostrar _MENU_ registros",
                                loadingRecords: "Cargando...",
                                processing: "Procesando...",
                                search: "Buscar",
                                zeroRecords: "No se encontraron coincidencias",
                                paginate: {
                                    first: "Primero",
                                    last: "Ultimo",
                                    next: "Próximo",
                                    previous: "Anterior"
                                },
                                aria: {
                                    sortAscending: ": Activar orden de columna ascendente",
                                    sortDescending: ": Activar orden de columna desendente"
                                }
                            },
                            ajax: {
                                url: '<?php echo base_url() ?>' + "/eventos/consultar_cliente",
                                data: function(d) {
                                    return $.extend({}, d, {
                                        tipo_documento: tipo_documento,
                                        fecha_inicial: fecha_inicial,
                                        fecha_final: fecha_final,
                                        nit_cliente: nit_cliente
                                    });
                                },
                                dataSrc: function(json) {
                                    $('#saldo_total').html(json.total);
                                    $('#saldo_cliente').html(json.saldo);
                                    $('#pagos_factura').html(json.pagos);
                                    return json.data;
                                }
                            },
                            columnDefs: [{
                                targets: [4],
                                orderable: false
                            }]
                        });

                    }
                }
            }
        </script>






        <script>
            $(document).ready(function() {
                $('#consulta_ventas').DataTable({
                    serverSide: true,
                    processing: true,
                    searching: false,
                    order: [
                        [0, 'desc']
                    ],
                    language: {
                        decimal: "",
                        emptyTable: "No hay datos",
                        info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 a 0 de 0 registros",
                        infoFiltered: "(Filtro de _MAX_ total registros)",
                        infoPostFix: "",
                        thousands: ",",
                        lengthMenu: "Mostrar _MENU_ registros",
                        loadingRecords: "Cargando...",
                        processing: "Procesando...",
                        search: "Buscar",
                        zeroRecords: "No se encontraron coincidencias",
                        paginate: {
                            first: "Primero",
                            last: "Ultimo",
                            next: "Próximo",
                            previous: "Anterior"
                        },
                        aria: {
                            sortAscending: ": Activar orden de columna ascendente",
                            sortDescending: ": Activar orden de columna desendente"
                        }
                    },
                    ajax: {
                        url: '<?php echo base_url() ?>' + "/eventos/tipo_documento",
                        data: function(d) {
                            return $.extend({}, d, {
                                // documento: documento,
                                // fecha_inicial: fecha_inicial,
                                // fecha_final: fecha_final
                            });
                        },
                        dataSrc: function(json) {
                            //$('#saldo_total').html(json.total);
                            $('#saldo').html(json.saldo_pendiente_por_cobrar);
                            $('#abonos').html(json.abonos);
                            $('#total_documentos').html(json.total);
                            $('#total_ventas').html(json.titulo);

                            if (json.abonos_sin_punto > 0) {
                                var div = document.getElementById("pagos_recibidos");
                                div.style.display = "block";
                            }
                            if (json.saldo_pendiente_por_cobrar_sin_punto > 0) {
                                var div = document.getElementById("saldo_pendiente_pago");
                                div.style.display = "block";
                            }


                            return json.data;
                        }
                    },
                    columnDefs: [{
                        targets: [4],
                        orderable: false
                    }]
                });
            });
        </script>

        <script>
            $("#buscar_cliente").autocomplete({
                source: function(request, response) {
                    var url = document.getElementById("url").value;
                    $.ajax({
                        type: "POST",
                        url: url + "/" + "clientes/clientes_autocompletado",
                        data: request,
                        success: response,
                        dataType: "json",
                    });
                },
                appendTo: "#finalizar_venta",
            }, {
                minLength: 1,
            }, {
                select: function(event, ui) {
                    // $("#id_cliente_factura_pos").val(ui.item.value);
                    //$("#clientes_factura_pos").val(ui.item.nit_cliente);
                    $("#nit_cliente").val(ui.item.nit_cliente);
                    $("#buscar_cliente").val(ui.item.value);

                    return false;
                    //$('#buscar_cliente').val(''); 
                },
            });
        </script>



        <script>
            $("#periodo_tiempo").select2({
                width: "100%",
                //placeholder: "Definir el periodo de tiempo",
                language: "es",
                theme: "bootstrap-5",
                allowClear: false,
                minimumResultsForSearch: -1,
            });
            $("#criterio_consulta").select2({
                width: "100%",
                placeholder: "Seleccione un criterio de consulta",
                language: "es",
                theme: "bootstrap-5",
                allowClear: false,
                minimumResultsForSearch: -1,
            });
            $("#tipo_documento").select2({
                width: "100%",
                placeholder: "Seleccione un documento",
                language: "es",
                theme: "bootstrap-5",
                allowClear: false,
                minimumResultsForSearch: -1,
            });
        </script>

        <script>
            let mensaje = "<?php echo $session->getFlashdata('mensaje'); ?>";
            let iconoMensaje = "<?php echo $session->getFlashdata('iconoMensaje'); ?>";
            if (mensaje != "") {

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
                    icon: iconoMensaje,
                    title: mensaje,
                })

            }
        </script>
</body>

</html>