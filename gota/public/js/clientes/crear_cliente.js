$('#frmCrearCliente').submit(function (e) {
    e.preventDefault();
    var form = this;
    let button = document.querySelector("#btnCrearCliente");
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
                    $("#modal_cliente").modal("hide");
                    $("#modal_fotos").modal("show");

                    $('#id_cliente').val(data.id_cliente)

                    //$(form)[0].reset();
                    //$('#list_clientes').html(data.clientes)
                    //$("#modal_cliente").modal("show");
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
                        title: 'Tercero creado exitosamente '
                    })





                } else {
                    alert(data.msg);
                }
            } else {
                $.each(data.error, function (prefix, val) {
                    $(form).find('span.' + prefix + '_error').text(val);
                });
            }
        }
    });
});





const canvasTag = document.getElementById("theCanvas");
btnFotosCliente.addEventListener("click", async () => {
    const dataURL = canvasTag.toDataURL();
    const blob = await dataURLtoBlob(dataURL);
    const data = new FormData();

    // Agregar la imagen
    data.append("capturedImage", blob, "capturedImage.png");

    // Agregar el ID del cliente
    let id_cliente = document.getElementById("id_cliente").value;
    data.append("id_cliente", id_cliente);

    // Obtener la URL del servidor
    let url = document.getElementById("url").value;

    // Obtén la imagen capturada
    const fotoCapturada = document.getElementById("fotoCapturada");
    console.log(fotoCapturada.src);
    // Verifica si hay una foto


    $.ajax({
        type: "POST",
        url: url + 'clientes/fotos',
        data: data,
        processData: false, // Evita que jQuery procese los datos
        contentType: false, // Evita que jQuery establezca el encabezado "Content-Type"
        success: function (resultado) {

            var resultado = JSON.parse(resultado);

            if (resultado.resultado == 1) {
                $('#fotos_cliente').html(resultado.imagenes)
                const canvas = document.getElementById("theCanvas");
                const context = canvas.getContext("2d");

                // Limpia el canvas
                context.clearRect(0, 0, canvas.width, canvas.height);

                // Obtén la imagen capturada
                const fotoCapturada = document.getElementById("fotoCapturada");

                // Limpia la imagen
                fotoCapturada.src = "";

                const btnFotosCliente = document.getElementById("btnFotosCliente");
                btnFotosCliente.disabled = true;
            }

        },
        error: function (error) {
            console.error("Error en la solicitud:", error);
        }
    });

});

async function dataURLtoBlob(dataURL) {
    const arr = dataURL.split(",");
    const mime = arr[0].match(/:(.*?);/)[1];
    const bstr = atob(arr[1]);
    const n = bstr.length;
    const u8arr = new Uint8Array(n);
    for (let i = 0; i < n; i++) {
        u8arr[i] = bstr.charCodeAt(i);
    }
    return new Blob([u8arr], { type: mime });
}
