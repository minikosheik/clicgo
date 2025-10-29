<?php
// Iniciar sesión solo si no existe
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ============================================================
   VERIFICAR SI EXISTE SESIÓN
============================================================ */
if (!isset($_SESSION["id_empleado"]) || !isset($_SESSION["rol"])) {
    // No hay sesión iniciada, redirigir al login
    header("Location: ../../index.php");
    exit();
}

/* ============================================================
   CONTROL DE ACCESO POR ROL (AUTOMÁTICO)
============================================================ */
$ruta_actual = str_replace("\\", "/", $_SERVER["PHP_SELF"]); // Normaliza rutas con /

/*
    Estructura esperada de rutas:

    /ClicGo/views/admin/...         → solo administrador
    /ClicGo/views/jefe/...          → solo jefe
    /ClicGo/views/usuario/...       → solo usuario
    /ClicGo/views/mtnusuario/...    → solo administrador
    /ClicGo/views/mtnfecha/...      → solo administrador
    /ClicGo/views/solicitud/...     → usuario, jefe, administrador
    /ClicGo/views/solicitudjefes/...→ jefe, administrador
*/

/* === Rol ADMINISTRADOR === */
if ($_SESSION["rol"] == "administrador") {
    // puede acceder a todo, excepto vistas ajenas
    // no se bloquea nada
}

/* === Rol JEFE === */
elseif ($_SESSION["rol"] == "jefe") {
    // Bloquea rutas exclusivas de admin
    if (strpos($ruta_actual, "/mtnusuario/") !== false ||
        strpos($ruta_actual, "/mtnfecha/") !== false ||
        strpos($ruta_actual, "/admin/") !== false) {
        header("Location: ../jefe/index.php");
        exit();
    }
}

/* === Rol USUARIO === */
elseif ($_SESSION["rol"] == "usuario") {
    // Bloquea todo excepto su vista y solicitudes
    if (strpos($ruta_actual, "/admin/") !== false ||
        strpos($ruta_actual, "/mtnusuario/") !== false ||
        strpos($ruta_actual, "/mtnfecha/") !== false ||
        strpos($ruta_actual, "/solicitudjefes/") !== false ||
        strpos($ruta_actual, "/jefe/") !== false) {
        header("Location: ../usuario/index.php");
        exit();
    }
}

/* ============================================================
   OPCIONAL: RENOVAR SESIÓN (anti timeout)
============================================================ */
if (!isset($_SESSION["last_activity"])) {
    $_SESSION["last_activity"] = time();
} elseif (time() - $_SESSION["last_activity"] > 3600) { // 1 hora inactivo
    session_unset();
    session_destroy();
    header("Location: ../../index.php?timeout=1");
    exit();
}
$_SESSION["last_activity"] = time();
?>
