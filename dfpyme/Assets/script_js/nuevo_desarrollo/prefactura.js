function prefactura(id) {

    let url = document.getElementById("url").value;
    let id_mesa = document.getElementById("id_mesa_pedido").value;
    $.ajax({
        data: {

            id_mesa,

        },
        url: url + "/" + "pedidos/prefactura",
        type: "POST",
        success: function(resultado) {
            var resultado = JSON.parse(resultado);
            if (resultado.resultado == 1) {
  
                sweet_alert('success','Impresión de prefactura')
               
            }
        },
    });

}