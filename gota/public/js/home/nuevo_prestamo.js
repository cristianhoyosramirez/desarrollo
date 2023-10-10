$('#frm_prestamos').submit(function (e) {
  e.preventDefault();
  var form = this;
  let button = document.querySelector("#btnPrestamo");
  button.disabled = true;
  $.ajax({
    url: $(form).attr('action'),
    method: $(form).attr('method'),
    data: new FormData(form),
    processData: false,
    dataType: 'json',
    contentType: false,
    beforeSend: function () {
      $(form).find('span.error-text').text('');
      button.disabled = false;
    },
    success: function (data) {
      if ($.isEmptyObject(data.error)) {
        if (data.code == 1) {
          $("#modal_crear_prestamo").modal("hide");
          $(form)[0].reset();
          //$('#example').DataTable().ajax.reload(null, false);
          $('#plan_pagos').html(data.tabla_amortizacion)
          $('#prestamos_usuario').html(data.datos)
          $('#modal_tabla_amortizacion').modal('show');
          $('#clientes').html('');


          let pago = document.getElementById("pago");
          pago.style.display = "none";



          const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Generación correcta '
          })


        } else {
          $('#error_cliente').html('Cliente tiene prestamo activo , primero debe cancelar el crédito actual ')
        }
      } else {
        $.each(data.error, function (prefix, val) {
          $(form).find('span.' + prefix + '_error').text(val);
        });
      }
    }
  });
});