function habilitarBotonPago() {
    // Obtén el valor seleccionado del select
    var select = document.getElementById("documento");
    let nombre_cliente = document.getElementById("nombre_cliente");
    let nit_cliente = document.getElementById("nit_cliente");

    var seleccion = select.value;

    if (seleccion == 8) {
    
        $('#nombre_cliente').val('222222222222 CONSUMIDOR FINAL');
        $('#nit_cliente').val('222222222222');
        $('#error_documento').html('')
    }
}