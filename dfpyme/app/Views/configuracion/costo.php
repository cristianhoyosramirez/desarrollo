<?php $session = session(); ?>
<?= $this->extend('template/template') ?>
<?= $this->section('title') ?>
Reporte de costos
<?= $this->endSection('title') ?>

<?= $this->section('content') ?>
<!-- Select 2 -->
<link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    /* Estilo para el botón de exportación a Excel */
    .buttons-excel {
        background-color: #4CAF50;
        /* Color de fondo */
        color: white;
        /* Color del texto */
        border: none;
        /* Quitar borde */
        padding: 10px 20px;
        /* Añadir espacio alrededor del texto */
        cursor: pointer;
        /* Cambiar el cursor al pasar por encima */
        border-radius: 5px;
        /* Añadir esquinas redondeadas */
        font-size: 16px;
        /* Tamaño de la fuente */
    }

    /* Estilo para el botón de exportación a Excel al pasar el ratón por encima */
    .buttons-excel:hover {
        background-color: #45a049;
        /* Cambiar color de fondo al pasar el ratón por encima */
    }
</style>
<!-- Jquery date picker  -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/Assets/plugin/calendario/jquery-ui-1.12.1.custom/jquery-ui.css">
<!-- Data tables -->
<link href="<?= base_url() ?>/Assets/plugin/data_tables/bootstrap.min.css" />
<link href="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.css" />
<!-- Select 2 -->
<link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>/Assets/plugin/select2/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<div class="container">
    <p class="text-center text-primary h3">INFORME COSTO DE VENTA </p>

    <div class="my-4"></div> <!-- Added space between the title and date inputs -->
    <!-- Agregar una barra de progreso -->







    <div class="row">
        <input type="hidden" id="url" value="<?php echo base_url() ?>">


        <div id="entre_fechas" class="col-12">
            <div class="row">
                <div class="col-3">
                    <label for="">Período</label>
                    <select class="form-select" id="periodo" onchange="select_periodo(this.value)">
                        <option></option>
                        <option value="1">Desde el inicio </option>
                        <option value="2">Fecha </option>
                        <option value="3">Periodo </option>
                    </select>
                </div>
                <div class="col-md-2" id="inicial" style="display:none">
                    <label for="fecha_inicial">Fecha inicial </label>

                    <div class="input-group input-group-flat">
                        <input type="text" class="form-control" id="fecha_inicial">
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiar_campo('fecha_inicial')"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-md-2" id="final" style="display:none">
                    <label for="fecha_final">Fecha final </label>
                    <div class="input-group input-group-flat">
                        <input type="text" class="form-control" id="fecha_final">
                        <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Limpiar campo" data-bs-toggle="tooltip" onclick="limpiar_campo('fecha_final')"><!-- Download SVG icon from http://tabler-icons.io/i/x -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M18 6l-12 12" />
                                    <path d="M6 6l12 12" />
                                </svg>
                            </a>
                        </span>
                    </div>
                </div>
                <div class="col-1" id="boton_consulta"> <br>
                    <button type="button" class="btn btn-outline-primary btn-icon" onclick="buscar()" title="Buscar datos" data-bs-toggle="tooltip">
                        Buscar
                    </button>
                </div>
                <div class="col-4">
                    <p class="text-red" id="error_fecha"></p>
                </div>
                <!--    <div class="col-md-2 text-end"><br>
                    <form action="<?= base_url('reportes/exportar_reporte_costo_excel') ?>" method="POST">
                        <input type="hidden" id="inicial" name="inicial">
                        <input type="hidden" id="final" name="final">
                        <button class="btn btn-outline-success" type="submit" title="Exportar a Excel" data-bs-toggle="tooltip">Excel </button>
                    </form>
                </div>
                <div class="col-md-1 text-start"><br>

                    

                    <form action="<?= base_url('reportes/exportar_reporte_costo') ?>" method="POST">
                        <input type="hidden" id="inicial" name="inicial" >
                        <input type="hidden" id="final" name="final">
                        <button class="btn btn-outline-danger" type="submit" title="Exportar a PDF" data-bs-toggle="tooltip">PDF</button>
                    </form>
                </div> -->
            </div>

        </div>


    </div>
    <div class="row">
        <div class="col-3"><span class="h3">Fecha inicial:</span> <span class="text-primary h3 " id="fecha_inicial_reporte"></span>
        </div>

        <div class="col-3 text-dark"><span class="h3">Fecha final:</span> <span class="text-primary h3" id="fecha_final_reporte"></span>
        </div>
        <div class="col-6">

        </div>
    </div>

    <div id="processing-bar" style="display: none;">
        <p class="text-primary h3">Procesando petición</p>
        <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
        </div>
    </div>
    <div class="my-3"></div> <!-- Added space between the buttons and the table -->

    <table class="table table-striped table-hover" id="consulta_costo">
        <thead class="table-dark">
            <tr>
                <td>Fecha</th>
                <td>Nit cliente</th>
                <td>Cliente</th>
                <td>Documento</th>
                <td>Valor</th>
                <td>Tipo documento</th>
                <td>Costo</th>
                <td>Base </th>
                <td>IVA</th>
                <td>INC</th>

            </tr>
        </thead>
        <tbody id="datos_costos">

        </tbody>
    </table>

<!--     <div class="row">
        <div class="col-9"></div>
        <div class="col-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="chart-sparkline chart-sparkline-square" id="sparkline-orders"></div>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium text-center">
                                Total venta
                            </div>
                            <div class="text-muted text-center">
                                <span id="total_venta_costo"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <br>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <td>Costo</td>
                <td scope="col">BASE IVA 0 </td>
                <td scope="col">IVA 0</td>
                <td scope="col">BASE IVA 19 </td>
                <td scope="col">IVA 19</td>
                <td scope="col">BASE IVA 5</td>
                <td scope="col">IVA 5</td>
                <td scope="col">BASE INC 8</td>
                <td scope="col">INC</td>

                <td scope="col">VALOR VENTA</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td id="costo"></td>
                <td>0</td>
                <td>0</td>
                <td>
                    <p id="base_iva_19">
                        </th>
                <td>
                    <p id="iva_19">
                </td>
                <td>
                    <p id="base_iva_5">
                </td>
                <td>
                    <p id="iva_5">
                </td>
                <td>
                    <p id="base_inc">
                </td>
                <td>
                    <p id="inc">
                </td>
                <td>
                    <p id="valor_venta">
                </td>

            </tr>
        </tbody>
    </table>

</div>


</div>
<!-- jQuery -->
<script src="<?= base_url() ?>/Assets/js/jquery-3.5.1.js"></script>
<!-- jQuery UI -->
<script src="<?= base_url() ?>/Assets/plugin/jquery-ui/jquery-ui.js"></script>
<!-- Sweet alert -->
<script src="<?php echo base_url(); ?>/Assets/plugin/sweet-alert2/sweetalert2@11.js"></script>

<!-- Data tables -->
<script src="<?= base_url() ?>/Assets/plugin/data_tables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>/Assets/plugin/data_tables/dataTables.bootstrap5.min.js"></script>

<!--select2 -->
<script src="<?php echo base_url(); ?>/Assets/plugin/select2/select2.min.js"></script>

<!-- DataTables Buttons 
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>-->

<script>
    function select_periodo(periodo) {

        var inicial = document.getElementById("inicial");
        var final = document.getElementById("final");

        if (periodo == 1) {
            inicial.style.display = "none";
            final.style.display = "none";

            document.getElementById('fecha_inicial').value = '';
            document.getElementById('fecha_final').value = '';

        }
        if (periodo == 2) {
            inicial.style.display = "block";
            final.style.display = "none";
            document.getElementById('fecha_final').value = '';
        }
        if (periodo == 3) {
            inicial.style.display = "block";
            final.style.display = "block";

            document.getElementById('fecha_inicial').value = '';
            document.getElementById('fecha_final').value = '';
        }

    }
</script>

<script>
    $("#periodo").select2({
        width: "100%",
        language: "es",
        theme: "bootstrap-5",
        allowClear: false,
        placeholder: "Seleccionar un rango ",
        minimumResultsForSearch: -1,
        language: {
            noResults: function() {
                return "No hay resultado";
            },
            searching: function() {
                return "Buscando..";
            }
        },

    });
</script>


<script>
    $(document).ready(function() {
        // Muestra el modal cuando comienza la solicitud AJAX
        /*   $(document).ajaxStart(function() {
              $('#processing-bar').show();
          });

          // Oculta el modal cuando todas las solicitudes AJAX se completan
          $(document).ajaxStop(function() {
              $('#processing-bar').hide();
          }); */

        var dataTable = $('#consulta_costo').DataTable({
            serverSide: true,
            processing: true,
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5' // Agregar el botón de exportar a Excel
            ],
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
                url: '<?php echo base_url() ?>' + "/reportes/data_table_reporte_costo",
                data: function(d) {
                    return $.extend({}, d, {
                        // documento: documento,
                        // fecha_inicial: fecha_inicial,
                        // fecha_final: fecha_final
                    });
                },
                dataSrc: function(json) {
                    $('#base_iva_19').html(json.base_iva_19);
                    $('#iva_19').html(json.iva_19);
                    $('#base_iva_5').html(json.base_iva_5);
                    $('#iva_5').html(json.iva_5);
                    $('#valor_venta').html(json.total_venta);
                    //$('#total_venta_costo').html(json.total_venta);
                    $('#base_inc').html(json.base_inc);
                    $('#inc').html(json.inc);
                    $('#costo').html(json.costo);
                    $('#fecha_inicial_reporte').html(json.fecha_inicial);
                    $('#fecha_final_reporte').html(json.fecha_final);
                    return json.data;
                },
            },
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
        });
    });
</script>






<script>
    let mensaje = "<?php echo $session->getFlashdata('mensaje'); ?>";
    let iconoMensaje = "<?php echo $session->getFlashdata('iconoMensaje'); ?>";
    if (mensaje != "") {

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            //position: 'bottom-end',
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
            title: mensaje
        })


    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var input = document.getElementById('fecha_inicial');
        var input2 = document.getElementById('fecha_final');
        var parrafo = document.getElementById('error_fecha');

        // Función para borrar el párrafo
        function borrarParrafo() {
            parrafo.textContent = ""; // o parrafo.innerHTML = "";
        }

        // Evento clic en el input
        input.addEventListener('click', borrarParrafo);

        // Evento de escritura en el input
        input.addEventListener('input', borrarParrafo);


        // Eventos clic y escritura para el input2
        input2.addEventListener('click', borrarParrafo);
        input2.addEventListener('input', borrarParrafo);
    });
</script>
<script>
    function limpiar_campo(campo) {
        $('#' + campo).val('');
    }
</script>


<script>
    $(function() {
        var dateFormat = "yy-mm-dd"; // Cambia el formato de fecha a "yy-mm-dd"

        var from = $("#fecha_inicial").datepicker({
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            dateFormat: dateFormat, // Establece el nuevo formato de fecha
            onClose: function(selectedDate) {
                to.datepicker("option", "minDate", selectedDate);
            }
        });

        var to = $("#fecha_final").datepicker({
            changeMonth: true,
            numberOfMonths: 1,
            changeYear: true,
            dateFormat: dateFormat, // Establece el nuevo formato de fecha
            onClose: function(selectedDate) {
                from.datepicker("option", "maxDate", selectedDate);
            }
        });

        // Export to Excel and PDF functionality
        $('#exportExcelBtn').click(function() {
            // Agrega tu código para exportar a Excel aquí
        });

        $('#exportPdfBtn').click(function() {
            // Agrega tu código para exportar a PDF aquí
        });
    });
</script>



<script>
    function buscar() {

        if ($.fn.DataTable.isDataTable('#consulta_costo')) {
            $('#consulta_costo').DataTable().destroy();
        }

        var url = document.getElementById("url").value;
        var fecha_inicial = document.getElementById("fecha_inicial").value;
        var fecha_final = document.getElementById("fecha_final").value;

        // Validación de fechas no vacías
        /*  if (fecha_inicial === '' || fecha_final === '') {
             $('#error_fecha').html('Ingresa ambas fechas ')
             return;
         } */

        var dataTable = $('#consulta_costo').DataTable({
            serverSide: true,
            processing: true,
            searching: false,
            dom: 'Bfrtip',
            buttons: [
                'excelHtml5' // Agregar el botón de exportar a Excel
            ],
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
                url: '<?php echo base_url() ?>' + "/reportes/datos_reporte_costo",
                data: function(d) {
                    return $.extend({}, d, {
                        // documento: documento,
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final
                    });
                },
                dataSrc: function(json) {
                    $('#base_iva_19').html(json.base_iva_19);
                    $('#iva_19').html(json.iva_19);
                    $('#base_iva_5').html(json.base_iva_5);
                    $('#iva_5').html(json.iva_5);
                    $('#valor_venta').html(json.total_venta);
                    $('#base_inc').html(json.base_inc);
                    $('#inc').html(json.inc);
                    $('#fecha_inicial_reporte').html(json.fecha_inicial);
                    $('#fecha_final_reporte').html(json.fecha_final);
                    $('#costo').html(json.costo);
                    return json.data;
                },
            },
            columnDefs: [{
                targets: [4],
                orderable: false
            }]
        });



    }
</script>


<?= $this->endSection('content') ?>