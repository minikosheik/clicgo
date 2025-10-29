$(document).ready(function () {

    // ===========================
    // 1️⃣ Inicializar DataTable
    // ===========================
    var tabla = $("#tabla_fecha").DataTable({
        ajax: {
            url: "../../controller/fecha.php?op=listar",
            type: "POST",
            dataType: "json",
            dataSrc: "data"
        },
        columns: [
            { data: "fecha" },
            { data: "dia_semana" },
            { data: "descripcion" },
            { data: "tipo" },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-danger eliminar" data-id="${row.id_festivo}">
                            <i class="bx bx-trash"></i>
                        </button>
                    `;
                },
                className: "text-center"
            }
        ],
        order: [[0, "asc"]],
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
    });

    // ===========================
    // 2️⃣ Mostrar modal al crear nueva fecha
    // ===========================
    $("#btnNuevaFecha").on("click", function () {
        $("#form_fecha")[0].reset();
        $("#modalFechaLabel").text("Nueva Fecha No Laborable");
        $("#modalFecha").modal("show");
    });

    // ===========================
    // 3️⃣ Guardar nueva fecha
    // ===========================
    $("#form_fecha").on("submit", function (e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: "../../controller/fecha.php?op=insertar",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Guardado",
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $("#modalFecha").modal("hide");
                    tabla.ajax.reload();
                } else {
                    Swal.fire("Error", response.message || "No se pudo guardar la fecha", "error");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire("Error", "Ocurrió un problema al guardar la fecha", "error");
            }
        });
    });

    // ===========================
    // 4️⃣ Eliminar fecha
    // ===========================
    $(document).on("click", ".eliminar", function () {
        var id_festivo = $(this).data("id");

        Swal.fire({
            title: "¿Estás seguro?",
            text: "Esta fecha se eliminará del calendario de días no laborables.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../controller/fecha.php?op=eliminar",
                    type: "POST",
                    data: { id_festivo: id_festivo },
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Eliminado",
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        tabla.ajax.reload();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire("Error", "No se pudo eliminar la fecha", "error");
                    }
                });
            }
        });
    });
});
