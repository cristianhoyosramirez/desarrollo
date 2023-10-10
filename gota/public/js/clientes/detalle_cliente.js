function detalle_cliente(id) {
    let url = document.getElementById("url").value;

    $.ajax({
        data: {
            id
        },
        url: url + "clientes/detalle",
        type: "POST",
        success: function (resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                let botones = document.getElementById("modal_footer");
                botones.style.display = "none";

                let pago = document.getElementById("pago");
                pago.style.display = "none";

                $('#clientes').html('');

                var miModal = new bootstrap.Modal(document.getElementById("modal_tabla_amortizacion"));
                miModal.show();


                $("#plan_pagos").html(resultado.cliente)


            }
        },
    });

}