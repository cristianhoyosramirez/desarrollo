$(document).ready(function () {
  var url = document.getElementById("url").value;
  $('#rutas').select2({
    minimumResultsForSearch: -1,
    width: '100%',
    placeholder: "Seleccione",
    language: "es",
    theme: "bootstrap-5",
    allowClear: false,
    dropdownParent: $('#modal_crear_usuario'),
    language: {
      noResults: function () {
        return "No hay resultado";
      },
      searching: function () {
        return "Buscando..";
      }
    }
  });
});