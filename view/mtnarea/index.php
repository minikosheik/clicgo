<?php
session_start();
if (!isset($_SESSION["rol"])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark">
<head>
    <meta charset="utf-8" />
    <title>ClicGo | Mantenimiento de Áreas</title>
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

                <div class="row mb-4">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold text-primary mb-0">
                            <i class="ri-building-line me-2"></i>Administrar Áreas
                        </h3>
                        <button class="btn btn-primary" id="btnNuevo">
                            <i class="ri-add-line"></i> Nueva Área
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="tabla_areas" class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="modalArea" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Registrar Área</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="formArea">
                                <div class="modal-body">
                                    <input type="hidden" id="id_area" name="id_area">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion"></textarea>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                                        <label class="form-check-label" for="activo">Activo</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php include_once("../footer/footer.php"); ?>
    </div>
</div>

<?php include_once("../mainjs/js.php"); ?>
<script src="../../public/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../public/assets/libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<script src="area.js"></script>
</body>
</html>
