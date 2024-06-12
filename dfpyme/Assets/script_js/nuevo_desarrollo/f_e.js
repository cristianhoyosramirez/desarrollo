
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


function sendInvoiceDian(id_fact) {

    var url = document.getElementById("url").value;

    $.ajax({
        data: {
            id_fact
        },
        url: url +
            "/" +
            "reportes/retrasmistir",
        type: "post",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                $('#resultado_consultado').html(resultado.datos)



            }
        },
    });
    
}