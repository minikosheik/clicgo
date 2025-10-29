<?php
require_once("../../config/seguridad.php");
?>

<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
<meta charset="utf-8" />
<title>ClicGo | Mantenimiento de Información General</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php include_once("../mainhead/head.php"); ?>
<link href="../../public/assets/libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<style>
    .gallery-img {
        width: 50%;
        height: 100px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        transition: transform 0.2s;
    }
    .gallery-img:hover {
        transform: scale(1.03);
    }
</style>
</head>

<body>
<div id="layout-wrapper">

    <?php include_once("../mainheader/header.php"); ?>
    <?php include_once("../mainnav/nav.php"); ?>

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                
                <!-- ENCABEZADO -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">Información General</h4>
                                <button class="btn btn-primary btn-sm" id="btnNuevaImagen" data-bs-toggle="modal" data-bs-target="#modalInfo">
                                    <i class="mdi mdi-plus"></i> Agregar Imagen
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="tabla_info" class="table table-bordered align-middle table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Imagen</th>
                                                <th>Fecha Publicación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php include_once("../footer/footer.php"); ?>
    </div>
</div>

<!-- MODAL AGREGAR / EDITAR -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form_info_general" enctype="multipart/form-data">
        <input type="hidden" id="id_info" name="id_info">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="modalInfoLabel">Agregar Imagen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="imagen" class="form-label">Seleccionar imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
          </div>
          <div id="preview" class="text-center mt-3"></div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- JS -->
<?php include_once("../mainjs/js.php"); ?>
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="mtninfo.js"></script>
</body>
</html>
