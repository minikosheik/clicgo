<?php
session_start();
if (!isset($_SESSION["rol"])) {
    header("Location: ../../index.php");
    exit();
}
?>
<!doctype html>
<html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>ClicGo | Mi Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                
                <!-- TÍTULO -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h3 class="fw-bold text-primary mb-0">
                            <i class="ri-user-3-line me-2"></i>Mi Perfil
                        </h3>
                        <p class="text-muted">Consulta tu información personal y saldo de vacaciones.</p>
                    </div>
                </div>

                <!-- SECCIÓN DE INFORMACIÓN PERSONAL -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ri-id-card-line fs-4 text-primary me-2"></i>
                        <h5 class="mb-0">Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <div id="perfil-info" class="row gy-3">
                            <div class="col-md-6 col-lg-4">
                                <p><strong>Nombre:</strong> <span id="perfil-nombre">—</span></p>
                                <p><strong>Fecha de Nacimiento:</strong> <span id="perfil-cumpleanos">—</span></p>
                                <p><strong>Puesto:</strong> <span id="perfil-puesto">—</span></p>
                                <p><strong>Área:</strong> <span id="perfil-area">—</span></p>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <p><strong>Correo:</strong> <span id="perfil-correo">—</span></p>
                                <p><strong>Fecha de ingreso:</strong> <span id="perfil-fecha">—</span></p>
                                <p><strong>Rol:</strong> <span id="perfil-rol">—</span></p>
                                <p><strong>Jefe:</strong> <span id="perfil-jefe">—</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARDS DE RESUMEN -->
                <div class="row mb-4" id="resumen-vacaciones">
                    <div class="col-md-4">
                        <div class="card mini-stats-wid border-start border-success shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-4">
                                        <i class="ri-sun-line"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Días Totales</p>
                                    <h4 class="mb-0" id="dias-totales">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid border-start border-warning shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-4">
                                        <i class="ri-flight-takeoff-line"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Tomados</p>
                                    <h4 class="mb-0" id="dias-tomados">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mini-stats-wid border-start border-primary shadow-sm">
                            <div class="card-body d-flex align-items-center">
                                <div class="flex-shrink-0 avatar-sm me-3">
                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                        <i class="ri-calendar-check-line"></i>
                                    </span>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Disponibles</p>
                                    <h4 class="mb-0" id="dias-disponibles">0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TABLA DE VACACIONES -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light d-flex align-items-center">
                        <i class="ri-calendar-2-line fs-4 text-primary me-2"></i>
                        <h5 class="mb-0">Vacaciones por periodo</h5>
                    </div>
                    <div class="card-body">
                        <table id="tabla_vacaciones" class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Periodo</th>
                                    <th>Días Totales</th>
                                    <th>Tomados</th>
                                    <th>Disponibles</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
<script src="perfil.js"></script>
</body>
</html>
