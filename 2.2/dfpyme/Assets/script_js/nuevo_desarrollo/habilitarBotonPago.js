function habilitarBotonPago() {
    // Obtén el valor seleccionado del select
    let select = document.getElementById("documento").value;
    let nombre_cliente = document.getElementById("nombre_cliente").value;
    let nit_cliente = document.getElementById("nit_cliente").value;

    if (select == 8) {

        if (nit_cliente == 22222222) {

            $('#nombre_cliente').val('222222222222 CONSUMIDOR FINAL');
            $('#nit_cliente').val('222222222222');
            $('#error_documento').html('')
        }

        if (nit_cliente != 22222222) {
            $('#nombre_cliente').val(nit_cliente + " " + nombre_cliente)
            $('#nit_cliente').val(nit_cliente);
        }
    }



}