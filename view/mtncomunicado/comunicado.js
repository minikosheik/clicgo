$(document).ready(function () {
    listarComunicados();

    $("#btn-nuevo").click(function () {
        $("#form_comunicado")[0].reset();
        $("#id_comunicado").val("");
        $("#modalComunicado").modal("show");
    });

    $("#form_comunicado").submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: "../../controller/comunicado.php?op=guardar",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (resp) {
                let data = JSON.parse(resp);
                if (data.status === "success") {
                    Swal.fire("Éxito", data.msg, "success");
                    $("#modalComunicado").modal("hide");
                    $("#tabla_comunicados").DataTable().ajax.reload();
                } else {
                    Swal.fire("Error", "No se pudo guardar", "error");
                }
            }
        });
    });
});

function listarComunicados() {
    $('#tabla_comunicados').DataTable({
        ajax: {
            url: "../../controller/comunicado.php?op=listar",
            type: "GET",
            dataSrc: "data"
        },
        destroy: true,
        columns: [
            { data: "id_comunicado" },
            { data: "titulo" },
            { data: "descripcion" },
            {
                data: "imagen",
                render: function (data) {
                    return data ? `<img src='../../${data}' width='60' class='rounded'/>` : '';
                }
            },
            { data: "fecha_publicacion" },
            {
                data: null,
                render: function (data) {
                    return `
                        <button class="btn btn-warning btn-sm" onclick="editar(${data.id_comunicado})"><i class="mdi mdi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminar(${data.id_comunicado})"><i class="mdi mdi-delete"></i></button>`;
                }
            }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" }
    });
}

function editar(id) {
    $.post("../../controller/comunicado.php?op=obtener", { id: id }, function (data) {
        let c = JSON.parse(data);
        $("#id_comunicado").val(c.id_comunicado);
        $("#titulo").val(c.titulo);
        $("#descripcion").val(c.descripcion);
        $("#modalComunicado").modal("show");
    });
}

function eliminar(id) {
    Swal.fire({
        title: "¿Eliminar comunicado?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/comunicado.php?op=eliminar", { id: id }, function (resp) {
                let data = JSON.parse(resp);
                Swal.fire("Eliminado", data.msg, "success");
                $("#tabla_comunicados").DataTable().ajax.reload();
            });
        }
    });
}
