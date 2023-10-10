$("#nombre").autocomplete({
  source: function(request, response) {
      var url = document.getElementById("url").value;
      $.ajax({
          type: "POST",
          url: url + "autocompletar/cliente",
          data: {
              term: request.term,
          },
          success: response,
          dataType: "json",
      });
  },
  appendTo: "#modal_crear_prestamo"
}, {
  minLength: 1,
}, {
  select: function(event, ui) {
      $("#nombre").val(ui.item.nombre);
      $("#id_cliente").val(ui.item.id);
      $('#monto').focus();
  },
});