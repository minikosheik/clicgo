$(document).ready(function () {
    cargarPerfil();
    inicializarTablaVacaciones();
});

/* =============================
   CARGAR PERFIL COMPLETO
============================= */
function cargarPerfil() {
    $.ajax({
        url: "../../controller/perfil.php?op=datos_perfil",
        type: "GET",
        dataType: "json",
        success: function (data) {
            if (data.usuario) {
                const u = data.usuario;

                // --- Cargar datos en la sección de información personal ---
                $("#perfil-nombre").text(`${u.nombre} ${u.apellido}`);
                $("#perfil-puesto").text(u.puesto ?? "—");
                $("#perfil-area").text(u.area ?? "—");
                $("#perfil-correo").text(u.correo);
                $("#perfil-fecha").text(formatearFecha(u.fecha_ingreso));
                $("#perfil-cumpleanos").text(formatearFecha(u.fecha_nacimiento));
                $("#perfil-rol").text(u.rol);
                $("#perfil-jefe").text(u.jefe);

                // --- Cargar vacaciones ---
                if (data.vacaciones && data.vacaciones.length > 0) {
                    cargarTablaVacaciones(data.vacaciones);
                    actualizarResumenVacaciones(data.vacaciones);
                } else {
                    limpiarResumenVacaciones();
                }
            } else {
                $("#perfil-info").html(`<p class="text-danger">Error al cargar datos del usuario.</p>`);
                limpiarResumenVacaciones();
            }
        },
        error: function (xhr) {
            console.error("Error al cargar perfil:", xhr.responseText);
            limpiarResumenVacaciones();
        }
    });
}

/* =============================
   FORMATEAR FECHA
============================= */
function formatearFecha(fecha) {
    if (!fecha) return "";
    const d = new Date(fecha);
    return d.toLocaleDateString("es-MX", {
        year: "numeric",
        month: "long",
        day: "numeric",
    });
}

/* =============================
   INICIALIZAR DATATABLE
============================= */
function inicializarTablaVacaciones() {
    $('#tabla_vacaciones').DataTable({
        destroy: true,
        responsive: true,
        paging: true,
        searching: true,
        language: { url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json" },
        columns: [
            { data: "periodo" },
            { data: "dias_totales" },
            { data: "dias_tomados" },
            { data: "dias_disponibles" },
            {
                data: "estado",
                render: function (data, type, row) {
                    const estado = data ? data : (row.dias_disponibles > 0 ? 'Activo' : 'Agotado');
                    const clase = estado === 'Activo' ? 'bg-success' : 'bg-danger';
                    return `<span class="badge ${clase}">${estado}</span>`;
                }
            }
        ]
    });
}

/* =============================
   CARGAR DATOS A TABLA
============================= */
function cargarTablaVacaciones(data) {
    const tabla = $('#tabla_vacaciones').DataTable();
    tabla.clear().rows.add(data).draw();
}

/* =============================
   ACTUALIZAR RESUMEN (CARDS)
============================= */
function actualizarResumenVacaciones(vacaciones) {
    let totales = 0, tomados = 0, disponibles = 0;

    vacaciones.forEach(v => {
        totales += parseInt(v.dias_totales || 0);
        tomados += parseInt(v.dias_tomados || 0);
        disponibles += parseInt(v.dias_disponibles || 0);
    });

    $("#dias-totales").text(totales);
    $("#dias-tomados").text(tomados);
    $("#dias-disponibles").text(disponibles);
}

/* =============================
   LIMPIAR RESUMEN SI NO HAY DATOS
============================= */
function limpiarResumenVacaciones() {
    $("#dias-totales").text(0);
    $("#dias-tomados").text(0);
    $("#dias-disponibles").text(0);
}
