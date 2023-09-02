function cambio(valor) { //Se recibe un un valor desde el formulario de pagos 
    var res = 0;
    let pago = 0;

    $('#valor_pago_error').html('')

    efectivoFormat = valor.replace(/[.]/g, ""); //Se quita el punto del valor recibido 

    let valorAsignado = efectivoFormat === "" ? 0 : parseInt(efectivoFormat); // Validamos que si valor esta vacio le asigne un cero 

    var valor_venta = document.getElementById("valor_total_a_pagar").value; // El valor de la venta 
    var efectivo = valorAsignado; // Valor sin punto o en caso de haber llegado vacio cero 


    let transaccion = document.getElementById("transaccion");
    let valor_t = transaccion.value;

    // Asigna un valor predeterminado de cero si "valor" está vacío
    let banco = valor_t === "" ? 0 : parseInt(valor_t);

    sub_total = parseInt(efectivo) + parseInt(banco);
    res = parseInt(sub_total) - parseInt(valor_venta);
    resultado = res.toLocaleString('es-CO');

    if (res > 0) {
        $('#cambio').html('Cambio: $' + resultado)
    }

    $('#pago').html('Valor pago: $' + sub_total.toLocaleString('es-CO'))


}