<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Autorización de Solicitudes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ========== Head Page ========== -->
    <?php include_once("../mainhead/head.php"); ?>

    <!-- DataTables -->
    <link href="../../public/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="layout-wrapper">

    <!-- Header y Nav -->
    <?php include_once("../mainheader/header.php"); ?>
    <?php include_once("../mainnav/nav.php"); ?>

    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Título -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Solicitudes de mi equipo</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla_autorizaciones" class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Empleado</th>
                                                <th>Tipo</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Días</th>
                                                <th>Motivo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

            </div><!-- container-fluid -->
        </div><!-- End Page-content -->

        <?php include_once("../footer/footer.php"); ?> 
    </div><!-- end main content -->
</div><!-- END layout-wrapper -->

<!-- Modal Detalle -->
<div class="modal fade" id="modalDetalle" tabindex="-1" aria-labelledby="modalDetalleLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalDetalleLabel">Detalle de Solicitud</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">

        <input type="hidden" id="det_id" name="det_id">
        <!-- 🔔 Banner dinámico -->
        <div id="detalleBanner" class="alert alert-info text-center fw-bold mb-3" style="display:none;"></div>

        <div id="detalleContenido" class="p-3 border rounded bg-light">
          <div class="row">
            <div class="col-md-6">
              <p><strong>Empleado:</strong> <span id="det_empleado"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Tipo:</strong> <span id="det_tipo"></span></p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <p><strong>Inicio:</strong> <span id="det_inicio"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Fin:</strong> <span id="det_fin"></span></p>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <p><strong>Días hábiles:</strong> <span id="det_dias"></span></p>
            </div>
            <div class="col-md-6">
              <p><strong>Motivo:</strong> <span id="det_motivo"></span></p>
            </div>
          </div>

          <p><strong>Estado actual:</strong> <span id="det_estado" class="badge bg-info"></span></p>

          <!-- Sección adicional para permisos -->
          <div id="seccionPermiso" class="mt-3" style="display:none;">
            <label class="form-label fw-bold">Tipo de permiso:</label>
            <select class="form-select" id="tipo_permiso">
              <option value="">Seleccione...</option>
              <option value="Con goce de sueldo">Con goce de sueldo</option>
              <option value="Sin goce de sueldo">Sin goce de sueldo</option>
              <option value="A cuenta de vacaciones">A cuenta de vacaciones</option>
            </select>
          </div>

          <!-- Observaciones -->
          <div class="mt-3">
            <label class="form-label fw-bold">Observaciones del jefe:</label>
            <textarea class="form-control" id="observaciones_jefe" rows="3" placeholder="Escriba observaciones o comentarios..."></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
  <?php if (isset($_SESSION["rol"]) && strtolower($_SESSION["rol"]) == "jefe") { ?>
    <div id="acciones_jefe" style="display: none;">
        <button type="button" class="btn btn-danger" id="btnRechazar">
            <i class="bx bx-x"></i> Rechazar
        </button>
        <button type="button" class="btn btn-success" id="btnAutorizar">
            <i class="bx bx-check"></i> Autorizar
        </button>
    </div>
  <?php } ?>
  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
</div>
    </div>
  </div>
</div>
<!-- Fin Modal Detalle -->

<!-- JS -->
<?php include_once("../mainjs/js.php"); ?>
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="solicitudjefes.js"></script>
</body>
</html>
