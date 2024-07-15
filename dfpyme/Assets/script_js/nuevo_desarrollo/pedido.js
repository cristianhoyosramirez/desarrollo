function pedido(id_mesa, nombre_mesa) {



    const cardHeader = document.getElementById('myCardHeader');
    if (cardHeader) {
        cardHeader.classList.remove('border-1', 'bg-indigo-lt');
    }
    const img = document.getElementById('img_ventas_directas');

    if (img) {
        img.style.display = 'none';
    }

    const mesa = document.getElementById('mesa_pedido');
    mesa.style.display = 'block';

    const pedid = document.getElementById('pedido_mesa');
    const mesero = document.getElementById('nombre_mesero');
    if (pedid) {
        pedid.textContent = 'Pedido:';
    }

    if (mesero) {
        mesero.style.display = 'block';

    }
    if (mesa) {
        mesa.textContent = 'Mesa:';

    }
    limpiar_todo();
    let requiere_mesero = document.getElementById("requiere_mesero").value;
    let tipo_usuario = document.getElementById("tipo_usuario").value;
    let tipo_pedido = document.getElementById("tipo_pedido").value;

    if (requiere_mesero == "t" && (tipo_usuario == 1 || tipo_usuario == 0)) {
        $("#modal_meseros").modal("show");

    }
    $("#lista_todas_las_mesas").modal("hide");
    $('#mesasOffcanvas').offcanvas('hide');



    if (tipo_pedido == "computador") {
        let mesas = document.getElementById("todas_las_mesas");
        mesas.style.display = "none";
    }

    let pedido = document.getElementById("pedido");
    pedido.style.display = "block";

    let productos = document.getElementById("productos");
    productos.style.display = "block";

    if (tipo_pedido == "computador") {
        let lista_categorias = document.getElementById("lista_categorias");
        lista_categorias.style.display = "block";
    }

    $('#id_mesa_pedido').val(id_mesa);
    $('#mesa_pedido').html(nombre_mesa);
    $("#producto").attr("readonly", false);
    $("#producto").focus();
}
