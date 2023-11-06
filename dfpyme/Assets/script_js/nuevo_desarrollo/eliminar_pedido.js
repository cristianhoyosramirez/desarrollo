function eliminar_pedido() {
    let url = document.getElementById("url").value
    var id_mesa = document.getElementById("id_mesa_pedido").value;
    if (id_mesa == "") {
        sweet_alert('warning', 'No hay pedido ')
    } else if (id_mesa != "") {

        Swal.fire({
            title: 'Seguro de eliminar el pedido ',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#2AA13D',
            cancelButtonColor: '#D63939',
            focusConfirm: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: url + "/" + "pedidos/eliminacion_de_pedido", // Cambia esto a tu script PHP para insertar en la base de datos
                    data: {
                        id_mesa,
                    }, // Pasar los datos al script PHP
                    success: function (resultado) {
                        var resultado = JSON.parse(resultado);
                        if (resultado.resultado == 1) {
                            limpiar_todo();
                            sweet_alert('success', 'Pedido eliminado')

                            $("#todas_las_mesas").html(resultado.mesas);
                            $("#val_pedido").html(0);
                            let mesas = document.getElementById("todas_las_mesas");
                            mesas.style.display = "block";

                            let lista_categorias = document.getElementById("lista_categorias");
                            lista_categorias.style.display = "none";

                            $("#producto").attr("readonly", true);
                            

                        }
                    },
                });
            }
        })
    }
}