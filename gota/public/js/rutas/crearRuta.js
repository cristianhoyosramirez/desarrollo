$('#crear_ruta').submit(function (e) {
  e.preventDefault();
  var form = this;
  let button = document.querySelector("#btnCrearRuta");
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
          $("#modal-report").modal("hide");

          $(form)[0].reset();
          $('#example').DataTable().ajax.reload(null, false);

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
            title: 'Ruta creada  '
          })
        } else {
          alert(data.msg);
        }
      } else {
        let button = document.querySelector("#btnCrearRuta");
        button.disabled = false;
        document.getElementById('nombre').focus();
        $.each(data.error, function (prefix, val) {
          $(form).find('span.' + prefix + '_error').text(val);
        });

      }
    }
  });
});