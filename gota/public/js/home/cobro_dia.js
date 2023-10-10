function cobro_dia() {

    let div = document.getElementById("cobros_dia");
    div.style.display = "block";

    let div2 = document.getElementById("home");
    div2.style.display = "none";

    let url = document.getElementById("url").value;
    let usuario = document.getElementById("id_de_usuario").value;
    $.ajax({
     data: {usuario},
      url: url + "/" + "prestamos/get_del_dia",
      type: "POST",
      success: function(resultado) {
        var resultado = JSON.parse(resultado);
        if (resultado.resultado == 1) {

          $('#prestamos_del_dia').html(resultado.prestamos)
        }
      },
    });

  }