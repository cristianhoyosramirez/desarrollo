function total() {
    var precio = document.getElementById("precio_devolucion").value;
    var cantidad = document.getElementById("cantidad_devolucion").value;
    var precioFormat = precio.replace(/[.]/g, "");

    res = parseInt(precioFormat) * parseInt(cantidad);

    resultado = res.toLocaleString();
    $("#total_devolucion").val(resultado);

}