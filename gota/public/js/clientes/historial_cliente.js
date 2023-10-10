function historial_cliente(id_c_x_c, id_cliente) {
    let url = document.getElementById("url").value;

    $.ajax({
      data: {
        id_c_x_c,
        id_cliente
      },
      url: url + "/" + "prestamos/cuotasPrestamo",
      type: "POST",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {

          var miModal = new bootstrap.Modal(document.getElementById("modal_tabla_amortizacion"));
          miModal.show();

          $("#pago_minimo").val(resultado.pago_minimo)
          $("#plan_pagos").html(resultado.tabla_amortizacion)

        }
      },
    });
  }