$(document).ready(function () {
    let url = document.getElementById("url").value;
    $('#example').DataTable({
        serverSide: true,
        processing: true,
        "language": {
            "decimal": "",
            "emptyTable": "No hay datos",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(Filtro de _MAX_ total registros)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar",
            "zeroRecords": "No se encontraron coincidencias",
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Próximo",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar orden de columna ascendente",
                "sortDescending": ": Activar orden de columna desendente"
            }

        },
        ajax: {
            url: url + '/prestamos/getTodos',
            type: 'post',
        },
        "createdRow": function (row, data, dataIndex) {
            if (data[3] == '0') {
                $(row).addClass('bg-lime-lt text-dark');
            }
        },

    });
});