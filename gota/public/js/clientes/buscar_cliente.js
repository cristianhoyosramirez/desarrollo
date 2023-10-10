function buscar_cliente(valor) {

    let url = document.getElementById("url").value;

    $.ajax({
        data: {
            valor
        },
        url: url + "/" + "clientes/get_clientes",
        type: "POST",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                $('#list_clientes').html(resultado.clientes)
            }
        },
    });


}