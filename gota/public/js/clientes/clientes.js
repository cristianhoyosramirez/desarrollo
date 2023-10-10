function clientes() {
    let cliente = document.getElementById("listado_clientes");
    cliente.style.display = "block";

    let home = document.getElementById("home");
    home.style.display = "none";

    let url = document.getElementById("url").value;
    
    let usuario = document.getElementById("id_de_usuario").value;
    $.ajax({
        data: {usuario},
        url: url + "/" + "clientes/index",
        type: "POST",
        success: function (resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                $('#list_clientes').html(resultado.clientes)
            }
        },
    });

}