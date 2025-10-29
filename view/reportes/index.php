<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Reportes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========== Head Page ========== -->
    <?php include_once("../mainhead/head.php"); ?>
    <!-- DataTables -->
    <link href="../../public/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="layout-wrapper">
    <!-- ========== Header Menu ========== -->
    <?php include_once("../mainheader/header.php"); ?>
    <!-- ========== Nav Menu ========== -->
    <?php include_once("../mainnav/nav.php"); ?>

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                            <h4 class="card-title mb-2">📊 Reporte de Solicitudes</h4>
                            <div class="d-flex gap-2 align-items-center">
                                <select id="filtro-mes" class="form-select form-select-sm">
                                <option value="">-- Todos los meses --</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                                </select>

                                <select id="filtro-tipo" class="form-select form-select-sm">
                                <option value="">-- Todos los tipos --</option>
                                <option value="Vacaciones">Vacaciones</option>
                                <option value="Permiso">Permiso</option>
                                <option value="A cuenta de vacaciones">A cuenta de vacaciones</option>
                                <option value="Incapacidad">Incapacidad</option>
                                <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="tabla-reportes" class="table table-striped table-bordered nowrap w-100">
                            <thead>
                                <tr>
                                <th>No. Solicitud</th>
                                <th>No. de Nomina</th>
                                <th>Empleado</th>
                                <th>Tipo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Días</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>

            </div><!-- container-fluid -->
        </div><!-- End Page-content -->

        <!-- ========== footer ========== -->
        <?php include_once("../footer/footer.php"); ?> 
    </div><!-- end main content -->
</div><!-- END layout-wrapper -->

<!-- ========== JS ========== -->
<?php include_once("../mainjs/js.php"); ?> 
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<!-- ✅ jQuery primero -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- ✅ DataTables núcleo -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- ✅ Extensión Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<!-- ✅ Librerías de exportación -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<!-- ✅ Script personalizado -->
<script src="reportes.js"></script>

</body>
</html>
