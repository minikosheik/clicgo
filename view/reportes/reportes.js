$(document).ready(function () {
    cargarTabla();

    $("#filtro-mes, #filtro-tipo").change(function () {
        $("#tabla-reportes").DataTable().ajax.reload();
    });
});

/* ===============================
   📊 Cargar tabla con filtros + Exportación
=============================== */
function cargarTabla() {
    $("#tabla-reportes").DataTable({
        responsive: true,
        dom: '<"d-flex justify-content-between align-items-center mb-2"Bf>rtip',
        buttons: [
            {
                extend: "excelHtml5",
                text: '<i class="bx bx-file me-1"></i> Excel',
                titleAttr: "Exportar a Excel",
                className: "btn btn-success btn-sm",
                title: "Reporte de Solicitudes - ClicGo",
                filename: "reporte_solicitudes_clicgo",
                exportOptions: { columns: ":visible" }
            },
            {
                extend: "pdfHtml5",
                text: '<i class="bx bxs-file-pdf me-1"></i> PDF',
                titleAttr: "Exportar a PDF",
                className: "btn btn-danger btn-sm",
                title: "Reporte de Solicitudes - ClicGo",
                filename: "reporte_solicitudes_clicgo",
                orientation: "landscape",
                pageSize: "A4",
                customize: function (doc) {
                    doc.styles.tableHeader.fontSize = 10;
                    doc.styles.tableBodyEven.alignment = "center";
                    doc.styles.tableBodyOdd.alignment = "center";
                    doc.defaultStyle.fontSize = 9;
                },
                exportOptions: { columns: ":visible" }
            },
            {
                extend: "print",
                text: '<i class="bx bx-printer me-1"></i> Imprimir',
                titleAttr: "Imprimir tabla",
                className: "btn btn-primary btn-sm",
                title: "Reporte de Solicitudes - ClicGo",
                exportOptions: { columns: ":visible" }
            }
        ],
        ajax: {
            url: "../../controller/reportes.php?op=listar",
            type: "GET",
            data: function (d) {
                d.mes = $("#filtro-mes").val();
                d.tipo = $("#filtro-tipo").val();
            },
            dataSrc: "data"
        },
        columns: [
            { data: "id_solicitud" },
            { data: "nomina" },
            {
                data: null,
                render: function (data, type, row) {
                return `${row.empleado} ${row.apellido}`;
                }
            },
            { data: "tipo" },
            { data: "fecha_inicio" },
            { data: "fecha_fin" },
            { data: "dias_habiles" },
            { data: "motivo" },
            {
                data: "estado",
                render: function (data) {
                    switch (data) {
                        case "Autorizado":
                            return '<span class="badge bg-success">Autorizado</span>';
                        case "Rechazado":
                            return '<span class="badge bg-danger">Rechazado</span>';
                        default:
                            return '<span class="badge bg-warning text-dark">En proceso</span>';
                    }
                }
            }
        ],
        order: [[0, "desc"]],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        destroy: true
    });
}
