function productos_categoria(id_categoria) {

    let url = document.getElementById("url").value;

    $.ajax({
        data: {
            id_categoria
        },
        url: url + "/" + "pedidos/productos_categoria",
        type: "POST",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {

                $('#productos_categoria').html(resultado.productos)
                $('#lista_categorias').html(resultado.lista_categoria)
            }
        },
    });


}