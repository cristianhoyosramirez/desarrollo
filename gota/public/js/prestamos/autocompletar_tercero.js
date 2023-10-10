$("#nombre").autocomplete({
    source: function(request, response) {
      var url = document.getElementById("url").value;
      $.ajax({
        type: "POST",
        url: url + "autocompletar/identificacion",
        data: {
          term: request.term,
        },
        success: response,
        dataType: "json",
      });
    },
    appendTo: "#modal_crear_prestamo",
  }, {
    minLength: 1,
  }, {
    select: function(event, ui) {
      $("#numero_documento").val(ui.item.value);
      $("#nombre").val(ui.item.nombre);
      $("#id_tercero").val(ui.item.id);
      $('#crear_usuario').focus();
    },
  });