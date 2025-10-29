<?php
session_start();
if ($_SESSION["rol"] != "administrador") {
    header("Location: ../../index.php");
    exit();
}
?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
<head>
    <meta charset="utf-8">
    <title>ClicGo | Comunicados</title>
    <?php include_once("../mainhead/head.php"); ?>
    <link href="../../public/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div id="layout-wrapper">
    <?php include_once("../mainheader/header.php"); ?>
    <?php include_once("../mainnav/nav.php"); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <h4 class="mb-3">Gestión de Comunicados</h4>

                <button class="btn btn-primary mb-3" id="btn-nuevo"><i class="mdi mdi-plus"></i> Nuevo Comunicado</button>

                <table id="tabla_comunicados" class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <?php include_once("../footer/footer.php"); ?>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalComunicado" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form id="form_comunicado" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title">Comunicado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
            <input type="hidden" name="id_comunicado" id="id_comunicado">
            <div class="col-md-12">
                <label>Título</label>
                <input type="text" class="form-control" name="titulo" id="titulo" required>
            </div>
            <div class="col-md-12">
                <label>Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" rows="3"></textarea>
            </div>
            <div class="col-md-12">
                <label>Imagen</label>
                <input type="file" class="form-control" name="imagen" id="imagen">
                <small class="text-muted">Formatos: JPG, PNG.</small>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?php include_once("../mainjs/js.php"); ?>
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="comunicado.js"></script>
</body>
</html>
