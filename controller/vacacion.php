<?php
require_once("../config/conexion.php");
require_once("../models/Vacacion.php");

$vacacion = new Vacacion();

switch ($_GET["op"]) {

    /* ===========================================================
       LISTAR VACACIONES POR EMPLEADO
    ============================================================ */
    case "listar_por_empleado":
        session_start();
        $id_empleado = $_SESSION["id_empleado"];
        $datos = $vacacion->listar_vacaciones_por_empleado($id_empleado);
        echo json_encode(["data" => $datos]);
    break;
}
?>
