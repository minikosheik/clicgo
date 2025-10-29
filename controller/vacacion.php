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

    case "consultar_dias_restantes":
        $conectar = new Conectar();
        $cn = $conectar->Conexion();

        $id_empleado = $_POST["id_empleado"];

        $sql = "SELECT TOP 1 
                    (dias_totales - dias_tomados) AS dias_restantes
                FROM vacaciones_periodos
                WHERE id_empleado = ?
                ORDER BY anio_inicio DESC";

        $stmt = $cn->prepare($sql);
        $stmt->execute([$id_empleado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo json_encode(["status" => "success", "dias_restantes" => $row["dias_restantes"]]);
        } else {
            echo json_encode(["status" => "error", "message" => "Sin periodo registrado"]);
        }
    break;
}
?>
