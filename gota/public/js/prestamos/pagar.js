function pagar(id) {

    let url = document.getElementById("url").value;

    $.ajax({
      data: {
        id
      },
      url: url + "prestamos/pagar",
      type: "POST",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {

          let botones = document.getElementById("modal_footer");
          botones.style.display = "none";

          let pago = document.getElementById("pago");
          pago.style.display = "block";

          var miModal = new bootstrap.Modal(document.getElementById("modal_tabla_amortizacion"));
          miModal.show();

          $("#plan_pagos").html(resultado.tabla_pagos)
          $("#nombres").html(resultado.nombre_cliente)
          $("#pago_minimo").val(resultado.pago_minimo)
          $("#c_x_c").val(resultado.id_c_x_c)
          $("#cuotas_atrasadas").html(resultado.cuotas_atrasadas)

        

        }
      },
    });

  }