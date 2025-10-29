<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="../../public/assets/images/users/user-dummy-img.jpg"
                                alt="Avatar del usuario">
                            <span class="text-start ms-xl-2">
                                <!-- Nombre del usuario logeado -->
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">
                                    <?= isset($_SESSION["nombre"]) ? htmlspecialchars($_SESSION["nombre"]) : "Invitado"; ?>
                                </span>
                                <!-- Rol del usuario -->
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    <?= isset($_SESSION["rol"]) ? ucfirst(htmlspecialchars($_SESSION["rol"])) : ""; ?>
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="../../logout.php">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">Cerrar sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
