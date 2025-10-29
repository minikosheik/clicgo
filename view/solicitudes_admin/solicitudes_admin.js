$(document).ready(function () {
    const tabla = $("#tabla-admin").DataTable({
        ajax: {
            url: "../../controller/solicitud.php?op=listar_todas",
            type: "GET",
            dataSrc: "data"
        },
        columns: [
            { data: "id_solicitud" },
            {
                data: null,
                render: d => `${d.empleado} ${d.apellido}`
            },
            { data: "tipo" },
            { data: "fecha_inicio" },
            { data: "fecha_fin" },
            { data: "dias_habiles" },
            { data: "motivo" },
            {
                data: "estado",
                render: e => {
                    if (e === "Autorizado") return '<span class="badge bg-success">Autorizado</span>';
                    if (e === "Rechazado") return '<span class="badge bg-danger">Rechazado</span>';
                    return '<span class="badge bg-warning text-dark">En proceso</span>';
                }
            },
            {
                data: null,
                render: d => `
                    <div class="btn-group">
                        <button class="btn btn-warning btn-sm btn-editar" data-id="${d.id_solicitud}">
                            <i class="bx bx-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-eliminar" data-id="${d.id_solicitud}">
                            <i class="bx bx-trash"></i>
                        </button>
                    </div>`
            }
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
        buttons: [
            { extend: "excelHtml5", text: "Excel", className: "btn btn-success btn-sm" },
            { extend: "pdfHtml5", text: "PDF", className: "btn btn-danger btn-sm" }
        ],
        responsive: true,
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" }
    });

    // 🟠 Editar: Cargar datos en el modal
    $(document).on("click", ".btn-editar", function () {
        const data = tabla.row($(this).parents("tr")).data();
        $("#id_solicitud").val(data.id_solicitud);
        $("#empleado").val(`${data.empleado} ${data.apellido}`);
        $("#tipo").val(data.tipo);
        $("#fecha_inicio").val(data.fecha_inicio);
        $("#fecha_fin").val(data.fecha_fin);
        $("#motivo").val(data.motivo);
        $("#estado").val(data.estado);
        $("#modalEditar").modal("show");
    });

    // 🟢 Guardar cambios
    $("#btnGuardarCambios").on("click", function () {
        const datos = $("#formEditar").serialize();
        $.post("../../controller/solicitud.php?op=editar", datos, function (response) {
            const res = JSON.parse(response);
            alert(res.message);
            if (res.status === "success") {
                $("#modalEditar").modal("hide");
                tabla.ajax.reload();
            }
        });
    });

    // 🔴 Eliminar solicitud
    $(document).on("click", ".btn-eliminar", function () {
        const id = $(this).data("id");
        if (confirm("¿Seguro que deseas eliminar esta solicitud?")) {
            $.post("../../controller/solicitud.php?op=eliminar", { id_solicitud: id }, function (response) {
                const res = JSON.parse(response);
                alert(res.message);
                if (res.status === "success") tabla.ajax.reload();
            });
        }
    });
});
