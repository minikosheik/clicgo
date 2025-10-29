<?php
require_once("../config/conexion.php");
require_once("../models/Area.php");

$area = new Area();

switch ($_GET["op"]) {

    case "listar":
        $datos = $area->listar_areas();
        echo json_encode(["data" => $datos]);
        break;

    case "insertar":
        $area->insertar_area($_POST["nombre"], $_POST["descripcion"], $_POST["activo"]);
        echo json_encode(["status" => "success", "message" => "Área registrada correctamente"]);
        break;

    case "actualizar":
        $area->actualizar_area($_POST["id_area"], $_POST["nombre"], $_POST["descripcion"], $_POST["activo"]);
        echo json_encode(["status" => "success", "message" => "Área actualizada correctamente"]);
        break;

    case "eliminar":
        $area->eliminar_area($_POST["id_area"]);
        echo json_encode(["status" => "success", "message" => "Área eliminada correctamente"]);
        break;

    case "obtener":
        $data = $area->obtener_area($_POST["id_area"]);
        echo json_encode($data);
        break;
}
?>
