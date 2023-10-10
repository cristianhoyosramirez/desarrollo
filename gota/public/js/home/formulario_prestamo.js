function nuevo_prestamo() {

  let div = document.getElementById("nuevo_prestamo");
  div.style.display = "block";

  let div2 = document.getElementById("home");
  div2.style.display = "none";

  //let cliente = document.getElementById("nombre");
  //cliente.focus()

  let url = document.getElementById("url").value;
  let usuario = document.getElementById("id_de_usuario").value;
  $.ajax({
    data: { usuario },
    url: url + "/" + "prestamos/get_prestamos_usuario",
    type: "POST",
    success: function (resultado) {
      var resultado = JSON.parse(resultado);
      if (resultado.resultado == 1) {

        $('#prestamos_usuario').html(resultado.datos)
      }
    },
  });

}