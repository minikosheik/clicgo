<?php require_once("../../config/seguridad.php"); ?>

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
  <meta charset="utf-8">
  <title>ClicGo | Administración de Solicitudes</title>
  <?php include_once("../mainhead/head.php"); ?>
</head>
<body>
<div id="layout-wrapper">
<?php include_once("../mainheader/header.php"); ?>
<?php include_once("../mainnav/nav.php"); ?>

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">

      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title mb-0">📋 Administración de Solicitudes</h4>
        </div>
        <div class="card-body">
          <table id="tabla-admin" class="table table-bordered table-hover align-middle">
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
  </div>

  <!-- 🧩 Modal Editar Solicitud -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalEditarLabel"><i class="bx bx-edit"></i> Editar Solicitud</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <form id="formEditar">
          <input type="hidden" id="id_solicitud" name="id_solicitud">

          <div class="row g-3">
            <div class="col-md-6">
              <label for="empleado" class="form-label fw-bold">Empleado</label>
              <input type="text" class="form-control" id="empleado" name="empleado" readonly>
            </div>

            <div class="col-md-6">
              <label for="tipo" class="form-label fw-bold">Tipo de Solicitud</label>
              <select class="form-select" id="tipo" name="tipo">
                <option value=""></option>
                <option value="Entrada">Entrada</option>
                <option value="Salida">Salida</option>
                <option value="Vacaciones">Vacaciones</option>
                <option value="Permiso">Permiso</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="fecha_inicio" class="form-label fw-bold">Fecha Inicio</label>
              <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
            </div>

            <div class="col-md-6">
              <label for="fecha_fin" class="form-label fw-bold">Fecha Fin</label>
              <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
            </div>

            <div class="col-md-12">
              <label for="motivo" class="form-label fw-bold">Motivo</label>
              <textarea class="form-control" id="motivo" name="motivo" rows="3"></textarea>
            </div>

            <div class="col-md-6">
              <label for="estado" class="form-label fw-bold">Estado</label>
              <select class="form-select" id="estado" name="estado">
                <option value="En proceso">En proceso</option>
                <option value="Autorizado">Autorizado</option>
                <option value="Rechazado">Rechazado</option>
              </select>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarCambios">
          <i class="bx bx-save"></i> Guardar cambios
        </button>
      </div>
    </div>
  </div>
</div>
  <?php include_once("../footer/footer.php"); ?>
</div>

<?php include_once("../mainjs/js.php"); ?>

<!-- DataTables + Buttons -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script src="solicitudes_admin.js"></script>
</body>
</html>
