<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Fechas No Laborables</title>
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

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Mantenimiento de Días No Laborables</h4>
                                <button type="button" id="btnNuevaFecha" class="btn btn-success btn-sm">
                                    <i class="ri-add-circle-line align-middle"></i> Nueva Fecha
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla_fecha" class="table table-bordered table-striped align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Día de la Semana</th>
                                                <th>Descripción</th>
                                                <th>Tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div><!-- end card-body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- container-fluid -->
        </div><!-- End Page-content -->

        <!-- ========== footer ========== -->
        <?php include_once("../footer/footer.php"); ?> 
    </div><!-- end main content -->
</div><!-- END layout-wrapper -->

<!-- ================== MODAL: FECHA ================== -->
<div class="modal fade" id="modalFecha" tabindex="-1" aria-labelledby="modalFechaLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalFechaLabel">Nueva Fecha No Laborable</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="form_fecha">
        <div class="modal-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Tipo</label>
              <select class="form-select" id="tipo" name="tipo" required>
                <option value="">Seleccione...</option>
                <option value="Interno">Interno</option>
                <option value="Oficial">Oficial</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-12">
              <label class="form-label">Descripción</label>
              <input type="text" class="form-control" id="descripcion" name="descripcion" required>
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

<!-- JS personalizado -->
<script src="fecha.js"></script>
</body>
</html>
