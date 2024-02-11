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
                            <button type="button" class="btn btn-outline-success" onclick="sendInvoice(<?php echo $detalle['id'] ?>)">Trasmitir</button>
                            <button type="button" class="btn btn-outline-success" onclick="imprimir_electronica(<?php echo $detalle['id'] ?>)">Imprimir copia </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="detalle_f_e(<?php echo $detalle['id'] ?>)">Detalle</button>
                            <?php if ($detalle['pdf_url'] != "") {
                            ?>
                                <div class="col-12 col-md-2">

                                    <a href="<?php echo $detalle['pdf_url'];  ?>" target="_blank" class="cursor-pointer">
                                        <img title="Descargar pdf " src="<?php echo base_url() ?>/Assets/img/pdf.png" width="40" height="40" />
                                    </a>
                                </div>
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

        //let url = new URL("http://localhost:5000/api/Invoice/id");
        let url = new URL("http://localhost:3000/api");
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