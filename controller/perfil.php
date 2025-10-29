<?php
require_once("../config/conexion.php");
require_once("../models/Vacacion.php");
require_once("../models/Usuario.php");

$vacacion = new Vacacion();
$usuario = new Usuario();

session_start();

switch ($_GET["op"]) {
    case "datos_perfil":
        $id_empleado = $_SESSION["id_empleado"] ?? null;

        if (!$id_empleado) {
            echo json_encode(["error" => "No hay sesión activa"]);
            exit;
        }

        // Obtener información del usuario
        $info = $usuario->obtener_usuario_por_id($id_empleado);

        // Obtener vacaciones por periodo
        $vacaciones = $vacacion->listar_vacaciones_por_empleado($id_empleado);

        echo json_encode([
            "usuario" => $info,
            "vacaciones" => $vacaciones
        ]);
        break;
}
?>
