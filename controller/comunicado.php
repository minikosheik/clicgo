<?php
require_once("../config/conexion.php");
require_once("../models/Comunicado.php");
$comunicado = new Comunicado();

switch ($_GET["op"]) {

    case "listar":
        echo json_encode(["data" => $comunicado->listar()]);
    break;

    case "guardar":
        $titulo = $_POST["titulo"];
        $descripcion = $_POST["descripcion"];
        $imagen = null;

        if (!empty($_FILES["imagen"]["name"])) {
            // Crear subcarpeta por año y mes (ej: 2025-10)
            $subcarpeta = date("Y-m");
            $carpeta = realpath(__DIR__ . "/../public") . "/uploads/" . $subcarpeta;

            // Crear la carpeta si no existe
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            // Generar nombre seguro para el archivo
            $nombreArchivo = uniqid("comunicado_") . "_" . preg_replace('/[^A-Za-z0-9_\.-]/', '_', $_FILES["imagen"]["name"]);
            $rutaDestino = $carpeta . "/" . $nombreArchivo;

            // Mover el archivo subido
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
                $imagen = "public/uploads/" . $subcarpeta . "/" . $nombreArchivo;
            } else {
                echo json_encode(["status" => "error", "msg" => "❌ No se pudo guardar la imagen en el servidor"]);
                exit;
            }
        }

        // Insertar o actualizar comunicado
        if (empty($_POST["id_comunicado"])) {
            $comunicado->insertar($titulo, $descripcion, $imagen);
            echo json_encode(["status" => "success", "msg" => "✅ Comunicado agregado correctamente"]);
        } else {
            $id = $_POST["id_comunicado"];
            $comunicado->actualizar($id, $titulo, $descripcion, $imagen);
            echo json_encode(["status" => "success", "msg" => "✅ Comunicado actualizado correctamente"]);
        }
    break;

    case "eliminar":
        $comunicado->eliminar($_POST["id"]);
        echo json_encode(["status" => "success", "msg" => "Comunicado eliminado"]);
    break;

    case "obtener":
        echo json_encode($comunicado->obtener($_POST["id"]));
    break;

    case "listar_publicos":
        $datos = $comunicado->listar_publicos();
        echo json_encode($datos);
    break;

}
?>
