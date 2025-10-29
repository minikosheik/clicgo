<?php
require_once("../../config/seguridad.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables base
$rol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : "sin_rol";
$nombre = isset($_SESSION["nombre"]) ? $_SESSION["nombre"] : "Invitado";
?>
<!-- ========== NAVBAR ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="#" class="logo logo-dark">
            <span class="logo-sm">
                <img src="../../public/assets/images/logo-sm.png" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="../../public/assets/images/logo-dark.png" alt="" height="50">
            </span>
        </a>
        <a href="#" class="logo logo-light">
            <span class="logo-sm">
                <img src="../../public/assets/images/logo-sm.png" alt="" height="40">
            </span>
            <span class="logo-lg">
                <img src="../../public/assets/images/logo-light.png" alt="" height="70">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
                id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menú Principal</span></li>

                <!-- ======= Opción: Home (visible para todos) ======= -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="../home/index.php">
                        <i class="ri-home-4-line"></i> <span>Inicio</span>
                    </a>
                </li>

                <!-- ===================================================
                     SECCIÓN ADMINISTRADOR
                =================================================== -->
                <?php if ($rol === "administrador") { ?>
                <li class="menu-title"><span>Administración</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../mtnusuario/index.php">
                        <i class="ri-user-settings-line"></i> <span>Usuarios</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../mtnarea/index.php">
                        <i class="ri-apps-2-line"></i> <span>Áreas</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../mtncomunicado/index.php">
                        <i class="ri-pages-line"></i> <span>Comunicados</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../mtninfo/index.php">
                        <i class="ri-pages-line"></i> <span>Informacion General</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../mtnfecha/index.php">
                        <i class="ri-calendar-2-line"></i> <span>Días no laborables</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../solicitudes_admin/index.php">
                        <i class="ri-bar-chart-line"></i> <span>Solicitudes</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../reportes/index.php">
                        <i class="ri-bar-chart-line"></i> <span>Reportes de Solicitudes</span>
                    </a>
                </li>
                
                <?php } ?>

                <!-- ===================================================
                     SECCIÓN JEFE
                =================================================== -->
                <?php if ($rol === "jefe") { ?>
                <li class="menu-title"><span>Solicitudes</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../solicitud/index.php">
                        <i class="ri-file-list-line"></i><span>Solicitudes Personales</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../solicitudjefes/index.php">
                        <i class="ri-file-list-line"></i><span>Solicitudes de mi Equipo</span>
                    </a>
                </li>

                <li class="menu-title"><span>Mi Perfil</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../perfil/index.php">
                        <i class="ri-user-3-line"></i> <span>Mi Perfil</span>
                    </a>
                </li>

                <?php } ?>

                <!-- ===================================================
                     SECCIÓN USUARIO
                =================================================== -->
                <?php if ($rol === "usuario") { ?>
                <li class="menu-title"><span>Solicitudes Personales</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../solicitud/index.php">
                        <i class="ri-file-list-line"></i> <span>Solicitudes Personales</span>
                    </a>
                </li>
                <?php } ?>

                <!-- ===================================================
                     OPCIONES COMUNES (todos los roles)
                =================================================== -->
                <?php if ($rol === "usuario") { ?>
                
                <li class="menu-title"><span>Mi Perfil</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="../perfil/index.php">
                        <i class="ri-user-3-line"></i> <span>Mi Perfil</span>
                    </a>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
