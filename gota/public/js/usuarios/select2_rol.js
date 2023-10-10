$(document).ready(function () {
  var url = document.getElementById("url").value;
  $('#rol').select2({
    minimumResultsForSearch: -1,
    placeholder: "Seleccione",
    language: "es",
    theme: "bootstrap-5",
    allowClear: true,
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