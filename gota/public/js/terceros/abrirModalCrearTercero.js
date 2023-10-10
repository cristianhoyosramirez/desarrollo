function abrir_modal_crear_tercero() {
    let url = document.getElementById("url").value;
    let operacion = 1;
    $.ajax({
      data: {
        operacion
      },
      url: url + "terceros/cargar_modal",
      type: "POST",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {
          $(document).ready(function() {
            var url = document.getElementById("url").value;
            $('#tipos_de_identificacion').select2({
              minimumResultsForSearch: -1,
              width: '100%',
              language: "es",
              theme: "bootstrap-5",
              allowClear: false,
              dropdownParent: $('#modal_terceros'),
              language: {
                noResults: function() {
                  return "No hay resultado";
                },
                searching: function() {
                  return "Buscando..";
                }
              },
              ajax: {
                url: url + "identificaciones/get_todos",
                type: "post",
                dataType: 'json',
                delay: 200,
                data: function(params) {
                  return {
                    palabraClave: params.term // search term
                  };
                },
                processResults: function(response) {
                  return {
                    results: response
                  };
                },
                cache: true
              },
            });
          });
          $('#modal_terceros').modal('show');
          $('#crud_terceros').html(resultado.datos)
        }
      }
    })
  }