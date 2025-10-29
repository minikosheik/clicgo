<?php
require_once("../config/conexion.php");
require_once("../models/Solicitud.php");

$solicitud = new Solicitud();

switch ($_GET["op"]) {

    /* =====================================================
       📋 LISTAR SOLICITUDES (con filtros)
    ===================================================== */
    case "listar":
        $mes = isset($_GET["mes"]) ? $_GET["mes"] : "";
        $tipo = isset($_GET["tipo"]) ? $_GET["tipo"] : "";

        $datos = $solicitud->listar_reporte($mes, $tipo);
        echo json_encode(["data" => $datos]);
    break;

}
?>