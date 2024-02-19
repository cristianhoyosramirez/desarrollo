<div class="card mb-3">
    <div class="card-header">
        <h3 class="card-title text-center text-primary w-100"><?php echo $titulo ?> </h3>
    </div>
    <div class="list-group list-group-flush list-group-hoverable" style="max-height: 350px; overflow-y: auto;">




        <br>

        <table class="table">
            <thead class="table-dark">
                <tr>
                    <td scope="col">Nit cliente</th>
                    <td scope="col">Cliente</th>
                    <td scope="col">Fecha </th>
                    <td scope="col">Documento</th>
                    <td scope="col">Valor </th>
                    <td scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentos as $detalle) : ?>

                    <?php $nombre_cliente = model('clientesModel')->select('nombrescliente')->where('nitcliente', $detalle['nit_cliente'])->first(); ?>

                    <tr>
                        <td><?php echo $detalle['nit_cliente'] ?></th>
                        <td><?php echo $nombre_cliente['nombrescliente'] ?></td>
                        <td><?php echo $detalle['fecha'] ?></td>
                        <td><?php echo $detalle['numero'] ?></td>
                        <td><?php echo "$ " . number_format($detalle['total'], 0, ",", ".") ?></td>
                        <td>
                            <button type="button" class="btn btn-outline-success btn-icon w-10" onclick="sendInvoice(<?php echo $detalle['id'] ?>)"><!-- Download SVG icon from http://tabler-icons.io/i/arrows-down-up -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="17" y1="3" x2="17" y2="21" />
                                    <path d="M10 18l-3 3l-3 -3" />
                                    <line x1="7" y1="21" x2="7" y2="3" />
                                    <path d="M20 6l-3 -3l-3 3" />
                                </svg></button>
                            <button type="button" class="btn btn-outline-success btn-icon w-10" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tooltip on bottom" onclick="imprimir_electronica(<?php echo $detalle['id'] ?>)"><!-- Download SVG icon from http://tabler-icons.io/i/printer -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" />
                                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" />
                                    <rect x="7" y="13" width="10" height="8" rx="2" />
                                </svg> </button>
                            <button type="button" class="btn btn-outline-secondary btn-icon w-10" onclick="detalle_f_e(<?php echo $detalle['id'] ?>)"><!-- Download SVG icon from http://tabler-icons.io/i/eyeglass -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M8 4h-2l-3 10" />
                                    <path d="M16 4h2l3 10" />
                                    <line x1="10" y1="16" x2="14" y2="16" />
                                    <path d="M21 16.5a3.5 3.5 0 0 1 -7 0v-2.5h7v2.5" />
                                    <path d="M10 16.5a3.5 3.5 0 0 1 -7 0v-2.5h7v2.5" />
                                </svg></button>

                            <?php if ($detalle['pdf_url'] != "") {
                            ?>

                                <a href="<?php echo $detalle['pdf_url'];  ?>" target="_blank" class="cursor-pointer">
                                    <img title="Descargar pdf " src="<?php echo base_url() ?>/Assets/img/pdf.png" width="40" height="40" />
                                </a>

                            <?php  } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>

    </div>
</div>


<script>
    let invoice = {
        id: 0,
        dian_status: "",
        order_reference: ""
    }
    let erroresp = {
        errors: []
    };
    let Error = {
        error: ""
    };

    async function sendInvoice(iddoc) {
        invoice.id = iddoc;
        $("#id_de_factura").val(iddoc);
        $("#barra_progreso").modal("show");

        let url = new URL("http://localhost:5000/api/Invoice/id");
        //let url = new URL("http://localhost:3000/api");
        url.search = new URLSearchParams({
            id: iddoc
        });
        const response = await fetch(url, {
            method: "GET"
        });
        const data = await response.json();
        if (response.status === 200) {
            invoice = JSON.parse(JSON.stringify(data, null, 2));

            //alert('Fact No ' + invoice.id + ' ' + invoice.order_reference + ' ' + invoice.dian_status);
            //console.log('Fact No ' + invoice.order_reference + ' ' + invoice.dian_status);

            // $("#barra_progreso").modal("hide");
            $("#id_factura").val(invoice.id);
            $("#barra_de_progreso").hide();
            $("#respuesta_dian").show();
            $("#opciones_dian").show();
            $("#texto_dian").html(invoice.order_reference + ' ' + invoice.dian_status);


        } else if (response.status === 400) { // Advertencia
            erroresp = JSON.parse(JSON.stringify(data, null, 2));
            //console.log(erroresp.errors[0].error);
            //alert(erroresp.errors[0].error);
            $("#barra_de_progreso").hide();
            $("#respuesta_dian").show();
            $("#error_dian").show();
            $("#texto_dian").html(erroresp.errors[0].error);
            $("#id_factura").val(invoice.id);
        } else {
            Error = JSON.parse(JSON.stringify(data, null, 2)); //Error Api 
            //alert(Error.error);
            $("#barra_de_progreso").hide();
            $("#respuesta_dian").show();
            $("#error_dian").show();
            $("#texto_dian").html('Respuesta DIAN: ' + erroresp.errors[0].error);
            $("#id_factura").val(invoice.id);
        }

    }
</script>


<script>
    function imprimir_electronica(id_factura) {

        var url = document.getElementById("url").value;

        $.ajax({
            data: {
                id_factura, // Incluye el número de factura en los datos
            },
            url: url + "/" + "pedidos/impresion_factura_electronica",
            type: "POST",
            success: function(resultado) {
                var resultado = JSON.parse(resultado);
                if (resultado.resultado == 1) {



                }
            },
        });

    }
</script>