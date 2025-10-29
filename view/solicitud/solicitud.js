$(document).ready(function () {

    /* ===========================================================
       1️⃣ Inicializar tabla de solicitudes
    ============================================================ */
    $(document).ready(function () {
        $("#tabla_mis_solicitudes").DataTable({
            ajax: {
                url: "../../controller/solicitud.php?op=listar_por_empleado",
                type: "POST",
                dataType: "json",
                dataSrc: "data"
            },
            columns: [
                { data: "id_solicitud" },
                { data: "tipo" },
                { data: "fecha_inicio" },
                { data: "fecha_fin" },
                { data: "dias_habiles" },
                { data: "motivo" },
                { data: "estado" },
                { data: "fecha_solicitud" }
            ],
            responsive: true,
            order: [[0, "desc"]],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
    });


        /* ===========================================================
       3️⃣ Abrir modal nueva solicitud
    ============================================================ */
    $("#btnNuevaSolicitud").on("click", function () {
        $("#form_solicitud")[0].reset();
        $("#id_solicitud").val("");
        $("#modalSolicitudLabel").text("Nueva Solicitud");
        $("#modalSolicitud").modal("show");
    });


    /* ===========================================================
       4️⃣ Enviar solicitud (crear)
    ============================================================ */
    $("#form_solicitud").on("submit", function (e) {
        e.preventDefault();

        // Validaciones básicas
        const fechaInicio = $("#fecha_inicio").val();
        const fechaFin = $("#fecha_fin").val();

        if (fechaInicio > fechaFin) {
            Swal.fire({
                icon: "warning",
                title: "Fechas inválidas",
                text: "La fecha final no puede ser menor a la inicial."
            });
            return;
        }

        $.ajax({
            url: "../../controller/solicitud.php?op=insertar",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function (data) {
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: data.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                $("#modalSolicitud").modal("hide");
                tabla_mis_solicitudes.ajax.reload();
            },
            error: function (xhr) {
                console.error("Error al guardar:", xhr.responseText);
                Swal.fire("Error", "No se pudo guardar la solicitud", "error");
            }
        });
    });


    /* ===========================================================
       5️⃣ Autorizar solicitud
    ============================================================ */
    $(document).on("click", ".autorizar", function () {
        const id_solicitud = $(this).data("id");
        Swal.fire({
            title: "¿Autorizar esta solicitud?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, autorizar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../controller/solicitud.php?op=actualizar_estado",
                    type: "POST",
                    data: {
                        id_solicitud: id_solicitud,
                        estado: "Autorizado",
                        id_autoriza: 1, // por ahora fijo, después se obtiene del $_SESSION
                        observaciones: "Autorizado por el jefe"
                    },
                    dataType: "json",
                    success: function (data) {
                        Swal.fire("Listo", data.message, "success");
                        tabla.ajax.reload();
                    }
                });
            }
        });
    });


    /* ===========================================================
       6️⃣ Rechazar solicitud
    ============================================================ */
    $(document).on("click", ".rechazar", function () {
        const id_solicitud = $(this).data("id");

        Swal.fire({
            title: "Rechazar solicitud",
            input: "text",
            inputLabel: "Motivo del rechazo",
            inputPlaceholder: "Ingrese una observación",
            showCancelButton: true,
            confirmButtonText: "Rechazar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                $.ajax({
                    url: "../../controller/solicitud.php?op=actualizar_estado",
                    type: "POST",
                    data: {
                        id_solicitud: id_solicitud,
                        estado: "Rechazado",
                        id_autoriza: 1, // temporal
                        observaciones: result.value
                    },
                    dataType: "json",
                    success: function (data) {
                        Swal.fire("Rechazada", data.message, "info");
                        tabla.ajax.reload();
                    }
                });
            }
        });
    });

});
