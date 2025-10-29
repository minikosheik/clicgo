$(document).ready(function () {
    var tabla = $("#tabla_autorizaciones").DataTable({
        ajax: {
            url: "../../controller/solicitud.php?op=listar_por_jefe",
            type: "POST",
            dataSrc: "data"
        },
        columns: [
            { data: "id_solicitud" },
            { data: "empleado" },
            { data: "tipo" },
            { data: "fecha_inicio" },
            { data: "fecha_fin" },
            { data: "dias_habiles" },
            { data: "motivo" },
            { data: "estado" },
            { data: "acciones" }
        ],
        responsive: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" },

        // 🟡 Validación visual de días
        createdRow: function (row, data, dataIndex) {
            if (data.tipo && data.tipo.toLowerCase().includes("vacaciones")) {
                // ✅ Corregido: nombre del archivo del controlador (vacaciones.php)
                $.ajax({
                    url: "../../controller/vacacion.php?op=consultar_dias_restantes",
                    type: "POST",
                    data: { id_empleado: data.id_empleado },
                    dataType: "json",
                    success: function (res) {
                        if (res.status === "success") {
                            const restantes = parseInt(res.dias_restantes);
                            const solicitados = parseInt(data.dias_habiles);

                            // Tooltip informativo
                            const tooltip = `Solicitó ${solicitados} día(s) — Tiene ${restantes} disponible(s)`;

                            // Igual a saldo disponible → Amarillo
                            if (solicitados === restantes) {
                                $("td", row).eq(5)
                                    .addClass("bg-warning text-dark fw-bold")
                                    .attr("title", tooltip);
                            }

                            // Excede saldo → Rojo
                            if (solicitados > restantes) {
                                $("td", row).eq(5)
                                    .addClass("bg-danger text-white fw-bold")
                                    .attr("title", tooltip);
                            }

                            // Aún tiene días → Verde tenue
                            if (solicitados < restantes) {
                                $("td", row).eq(5)
                                    .addClass("bg-success-subtle text-success fw-bold")
                                    .attr("title", tooltip);
                            }
                        }
                    }
                });
            }
        }
    });

    // 🔹 Ver detalle
    $(document).on("click", ".btn-detalle", function () {
        var id_solicitud = $(this).data("id");

        $.ajax({
            url: "../../controller/solicitud.php?op=detalle",
            type: "POST",
            data: { id_solicitud: id_solicitud },
            dataType: "json",
            success: function (data) {
                if (data.status === "success") {
                    let s = data.solicitud;
                    let banner = $("#detalleBanner");
                    banner.show();

                    let mensaje = "";
                    let clase = "alert-info";

                    switch (s.estado.toLowerCase()) {
                        case "en proceso":
                        case "pendiente":
                            mensaje = `🔔 Solicitud de ${s.tipo.toLowerCase()} — pendiente de autorización`;
                            clase = "alert-info";
                            $("#acciones_jefe").show();
                            break;

                        case "autorizado":
                            mensaje = `✅ Solicitud de ${s.tipo.toLowerCase()} autorizada`;
                            clase = "alert-success";
                            $("#acciones_jefe").hide();
                            break;

                        case "rechazado":
                            mensaje = `❌ Solicitud de ${s.tipo.toLowerCase()} rechazada`;
                            clase = "alert-danger";
                            $("#acciones_jefe").hide();
                            break;

                        default:
                            mensaje = `ℹ️ Solicitud de ${s.tipo.toLowerCase()}`;
                            clase = "alert-secondary";
                            $("#acciones_jefe").hide();
                    }

                    banner.removeClass().addClass(`alert text-center fw-bold ${clase}`).text(mensaje);

                    if (s.tipo && s.tipo.toLowerCase().includes("permiso")) {
                        $("#seccionPermiso").show();
                    } else {
                        $("#seccionPermiso").hide();
                        $("#tipo_permiso").val("");
                    }

                    $("#det_id").val(s.id_solicitud);
                    $("#det_empleado").text(s.empleado);
                    $("#det_tipo").text(s.tipo);
                    $("#det_inicio").text(s.fecha_inicio);
                    $("#det_fin").text(s.fecha_fin);
                    $("#det_dias").text(s.dias_habiles);
                    $("#det_motivo").text(s.motivo);
                    $("#det_estado").text(s.estado)
                        .removeClass().addClass("badge bg-" + (s.estado === "En proceso" ? "info" : s.estado === "Autorizado" ? "success" : "danger"));

                    $("#modalDetalle").data("id", s.id_solicitud);
                    $("#observaciones_jefe").val("");
                    $("#modalDetalle").modal("show");
                } else {
                    Swal.fire("Error", data.message, "error");
                }
            },
            error: function () {
                Swal.fire("Error", "No se pudo cargar el detalle", "error");
            }
        });
    });

    // 🔸 Autorizar
    $("#btnAutorizar").on("click", function () {
        const id = $("#det_id").val();
        const observaciones = $("#observaciones_jefe").val();
        const tipo_permiso = $("#tipo_permiso").val();

        $.ajax({
            url: "../../controller/solicitud.php?op=autorizar",
            type: "POST",
            data: { id_solicitud: id, observaciones, tipo_permiso },
            dataType: "json",
            success: function (res) {
                if (res.status === "success") {
                    Swal.fire("Éxito", res.message, "success");
                    $("#modalDetalle").modal("hide");
                    $("#tabla_autorizaciones").DataTable().ajax.reload(null, false);
                } else {
                    Swal.fire("Error", res.message, "error");
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire("Error", "No se pudo autorizar la solicitud", "error");
            }
        });
    });

    // 🔸 Rechazar
    $("#btnRechazar").on("click", function () {
        const id = $("#det_id").val();
        const observaciones = $("#observaciones_jefe").val();

        if (!id) {
            Swal.fire("Error", "No se pudo identificar la solicitud", "error");
            return;
        }

        Swal.fire({
            title: "¿Está seguro?",
            text: "Esta solicitud será rechazada.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, rechazar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "../../controller/solicitud.php?op=rechazar",
                    type: "POST",
                    data: { id_solicitud: id, observaciones },
                    dataType: "json",
                    success: function (res) {
                        Swal.fire("Rechazada", res.message, "success");
                        $("#modalDetalle").modal("hide");
                        $("#tabla_autorizaciones").DataTable().ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        Swal.fire("Error", "No se pudo rechazar la solicitud", "error");
                    }
                });
            }
        });
    });
});
