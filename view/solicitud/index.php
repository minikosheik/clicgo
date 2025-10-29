<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Solicitudes</title>
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
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Mantenimiento de Solicitudes</h4>
                                <button type="button" id="btnNuevaSolicitud" class="btn btn-success btn-sm">
                                    <i class="ri-add-circle-line align-middle"></i> Nueva Solicitud
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla_mis_solicitudes" class="table table-bordered table-hover align-middle">
                                        <thead class="table-light">
                                            <tr>
                                                <th>No. Solicitud</th>
                                                <th>Tipo</th>
                                                <th>Inicio</th>
                                                <th>Fin</th>
                                                <th>Días Solicitados</th>
                                                <th>Motivo</th>
                                                <th>Estado</th>
                                                <th>Fecha de Solicitud</th>
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

        <!-- ========== footer ========== -->
        <?php include_once("../footer/footer.php"); ?> 
    </div><!-- end main content -->
</div><!-- END layout-wrapper -->


<!-- ================== MODAL: NUEVA SOLICITUD ================== -->
<div class="modal fade" id="modalSolicitud" tabindex="-1" aria-labelledby="modalSolicitudLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalSolicitudLabel">Nueva Solicitud</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="form_solicitud">
  <div class="modal-body">
    <input type="hidden" id="id_solicitud" name="id_solicitud">

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Tipo de solicitud</label>
        <select class="form-select" id="tipo" name="tipo" required>
          <option value="">Seleccione...</option>
          <option value="Entrada">Entrada</option>
          <option value="Salida">Salida</option>
          <option value="Vacaciones">Vacaciones</option>
          <option value="Permiso">Permiso</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Fecha inicio</label>
        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Fecha fin</label>
        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Motivo</label>
        <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-success">Guardar</button>
  </div>
</form>

    </div>
  </div>
</div>
<!-- ================== FIN MODAL ================== -->

<!-- ========== JS ========== -->
<?php include_once("../mainjs/js.php"); ?> 
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<!-- Tu JS personalizado -->
<script src="solicitud.js"></script>

</body>
</html>
