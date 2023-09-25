function pedido(id_mesa, nombre_mesa) {

    let requiere_mesero = document.getElementById("requiere_mesero").value;

    if(requiere_mesero=="t"){
        $('#id_mesa_actualizar').val(id_mesa)
        $("#modal_meseros").modal("show");
    }

    $('#lista_todas_las_mesas').modal('hide');
    let mesas = document.getElementById("todas_las_mesas");
    mesas.style.display = "none";

    let pedido = document.getElementById("pedido");
    pedido.style.display = "block";


    let productos = document.getElementById("productos");
    productos.style.display = "block";



    let lista_categorias = document.getElementById("lista_categorias");
    lista_categorias.style.display = "block";



    $('#id_mesa_pedido').val(id_mesa)
    $('#mesa_pedido').html('Mesa: '+nombre_mesa)
    //$('#id_mesa_pedido').val(id_mesa)

    $("#producto").attr("readonly", false);
    $("#producto").focus();

}