function agregar_nota(id_producto) {
    
    $('#id_producto_pedido').val(id_producto)
    let url = document.getElementById("url").value;

    $.ajax({
        data: {
            id_producto,
        },
        url: url + "/" + "pedidos/consultar_nota",
        type: "POST",
        success: function (resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {
     
                $("#agregar_nota").modal("show");
                $("#nota_producto_pedido").val(resultado.nota);
               
            }
        },
    });
}