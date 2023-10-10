function modal_crear_tercero() {
    var url = document.getElementById("url").value;
    $.ajax({
      url: url + "/" + "terceros/cargar_modal",
      type: "POST",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {
          $('#operaciones').html(resultado.datos)
        }
      }
    })
  }