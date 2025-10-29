$(document).ready(function () {
    listarAreas();

    $("#btnNuevo").click(function () {
        $("#formArea")[0].reset();
        $("#id_area").val("");
        $("#modalArea .modal-title").text("Registrar Área");
        $("#modalArea").modal("show");
    });

    $("#formArea").on("submit", function (e) {
        e.preventDefault();
        guardarArea();
    });
});

function listarAreas() {
    $('#tabla_areas').DataTable({
        ajax: {
            url: "../../controller/area.php?op=listar",
            type: "GET",
            dataSrc: "data"
        },
        destroy: true,
        columns: [
            { data: "id_area" },
            { data: "nombre" },
            { data: "descripcion" },
            { data: "estado" },
            {
                data: "id_area",
                render: function (data) {
                    return `
                        <button class="btn btn-sm btn-warning me-1" onclick="editarArea(${data})">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarArea(${data})">
                            <i class="ri-delete-bin-line"></i>
                        </button>`;
                }
            }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" }
    });
}

function guardarArea() {
    const id_area = $("#id_area").val();
    const op = id_area ? "actualizar" : "insertar";

    $.ajax({
        url: `../../controller/area.php?op=${op}`,
        type: "POST",
        data: {
            id_area,
            nombre: $("#nombre").val(),
            descripcion: $("#descripcion").val(),
            activo: $("#activo").is(":checked") ? 1 : 0
        },
        success: function (response) {
            const res = JSON.parse(response);
            if (res.status === "success") {
                $("#modalArea").modal("hide");
                $('#tabla_areas').DataTable().ajax.reload();
                Swal.fire("Éxito", res.message, "success");
            } else {
                Swal.fire("Error", "Ocurrió un problema al guardar", "error");
            }
        }
    });
}

function editarArea(id) {
    $.post("../../controller/area.php?op=obtener", { id_area: id }, function (data) {
        $("#modalArea .modal-title").text("Editar Área");
        $("#id_area").val(data.id_area);
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#activo").prop("checked", data.activo == 1);
        $("#modalArea").modal("show");
    }, "json");
}

function eliminarArea(id) {
    Swal.fire({
        title: "¿Eliminar área?",
        text: "Esta acción no se puede deshacer.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("../../controller/area.php?op=eliminar", { id_area: id }, function (res) {
                const data = JSON.parse(res);
                if (data.status === "success") {
                    $('#tabla_areas').DataTable().ajax.reload();
                    Swal.fire("Eliminado", data.message, "success");
                } else {
                    Swal.fire("Error", "No se pudo eliminar", "error");
                }
            });
        }
    });
}
