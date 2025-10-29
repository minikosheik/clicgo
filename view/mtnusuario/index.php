<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Usuarios</title>
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
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header align-items-center d-flex">
                                        <h4 class="card-title mb-0 flex-grow-1">Mantenimiento de Usuarios</h4>
                                        <button type="button" id="btnNuevoUsuario" class="btn btn-success btn-sm">
                                            <i class="ri-add-circle-line align-middle"></i> Nuevo Usuario
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <div class="br-section-wrapper">
                                            <div class="table-wrapper">
                                                <table id="tabla_usuarios" class="table table-bordered" style="width:100%">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Número de nómina</th> <!-- 🔹 Nueva columna -->
                                                            <th>Nombre</th>
                                                            <th>Fecha de Nacimiento</th>
                                                            <th>Puesto</th>
                                                            <th>Área</th>
                                                            <th>Correo</th>
                                                            <th>Rol</th>
                                                            <th>Fecha de ingreso</th>
                                                            <th>Estatus</th>
                                                            <th>Acciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div><!-- end card-body -->
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div>
                </div><!-- end page title -->
            </div><!-- container-fluid -->
        </div><!-- End Page-content -->

        <!-- ========== footer ========== -->
        <?php include_once("../footer/footer.php"); ?> 
    </div><!-- end main content -->
</div><!-- END layout-wrapper -->

<!-- ================== MODAL: USUARIO ================== -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="modalUsuarioLabel">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="form_usuario">
        <div class="modal-body">
          <input type="hidden" id="id_empleado" name="id_empleado">

          <!-- 🔹 Número de nómina -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Número de nómina</label>
              <input type="text" class="form-control" id="numero_nomina" name="numero_nomina" placeholder="Ej: EMP045" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Puesto</label>
              <input type="text" class="form-control" id="puesto" name="puesto" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Apellido</label>
              <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
          </div>

          <div class="col-md-6">
              <label class="form-label fw-bold">Fecha de Nacimiento</label>
              <input type="date" class="form-control" name="fecha_nacimiento" id="fecha_nacimiento">
            </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Área</label>
              <select class="form-select" id="id_area" name="id_area" required>
                <option value="">Seleccione área...</option>
              </select>
            </div>
            
            <div class="col-md-6">
              <label class="form-label">Rol</label>
              <select class="form-select" id="id_rol" name="id_rol" required>
                <option value="">Seleccione...</option>
                <option value="1">Usuario</option>
                <option value="2">Jefe</option>
                <option value="3">Administrador</option>
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Correo</label>
              <input type="email" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Contraseña</label>
              <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="••••••••">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Fecha de ingreso</label>
              <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Jefe directo</label>
              <select class="form-select" id="id_jefe" name="id_jefe">
                <option value="">Seleccione jefe...</option>
              </select>
            </div>
          </div>

          <div class="row mb-3" id="estadoUsuario" style="display:none;">
            <div class="col-md-6">
              <label class="form-label">Estatus</label>
              <select class="form-select" id="activo" name="activo">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
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
<script src="usuario.js"></script>
</body>
</html>
