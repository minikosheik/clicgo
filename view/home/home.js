$(document).ready(function () {
    cargarComunicados();
    cargarAniversarios();
    cargarEventos();
    cargarCumpleanios();
});


/* =========================
   🎉 ANIVERSARIOS
========================= */
function cargarAniversarios() {
    $.ajax({
        url: "../../controller/home.php?op=listar_aniversarios",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let html = "";
            data.forEach(a => {
                let fecha = new Date(a.fecha_ingreso);
                html += `
                    <li class="list-group-item ps-0">
                        <div class="row align-items-center g-3">
                            <div class="col-auto">
                                <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                    <div class="text-center">
                                        <h5 class="mb-0">${fecha.getDate()}</h5>
                                        <div class="text-muted">${fecha.toLocaleString('es-MX', { month: 'short' })}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <h6 class="mb-1">${a.empleado}</h6>
                                <p class="text-muted mb-0">Cumple ${a.anios} año(s) de servicio</p>
                            </div>
                        </div>
                    </li>`;
            });
            $(".card-body ul.list-group").html(html || "<li class='list-group-item text-center text-muted'>Sin aniversarios este mes</li>");
        }
    });
}

/* =========================
   📅 EVENTOS
========================= */
function cargarEventos() {
    $.ajax({
        url: "../../controller/home.php?op=listar_eventos_mes",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let html = "";
            data.forEach(ev => {
                html += `
                    <tr>
                        <td>${ev.empleado ?? '—'}</td>
                        <td>${ev.fecha_inicio}${ev.fecha_fin ? ' al ' + ev.fecha_fin : ''}</td>
                        <td><span class="badge ${ev.tipo === 'Vacaciones' ? 'bg-success' : ev.tipo === 'Permiso' ? 'bg-warning' : 'bg-info'}">${ev.tipo}</span></td>
                    </tr>`;
            });
            $(".table tbody").html(html || "<tr><td colspan='3' class='text-center text-muted'>No hay eventos registrados</td></tr>");
        }
    });
}

/* =========================
   🎂 CUMPLEAÑOS DEL MES
========================= */
function cargarCumpleanios() {
    $.ajax({
        url: "../../controller/home.php?op=listar_cumpleanios",
        type: "GET",
        dataType: "json",
        success: function (data) {
            let html = "";

            if (data.length === 0) {
                html = `<li class="list-group-item text-center text-muted">
                            No hay cumpleaños este mes 🎈
                        </li>`;
            } else {
                data.forEach(c => {
                    html += `
                        <li class="list-group-item ps-0">
                            <div class="row align-items-center g-3">
                                <div class="col-auto">
                                    <div class="avatar-sm p-1 py-2 h-auto bg-light rounded-3">
                                        <div class="text-center">
                                            <h5 class="mb-0">${c.dia}</h5>
                                            <div class="text-muted">${c.mes.substring(0,3)}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1">${c.empleado}</h6>
                                    <p class="text-muted mb-0">🎉 ¡Feliz cumpleaños!</p>
                                </div>
                            </div>
                        </li>`;
                });
            }

            $("#lista-cumpleanios").html(html);
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar cumpleaños:", error);
        }
    });
}
