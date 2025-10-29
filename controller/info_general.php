<?php
require_once("../config/conexion.php");
require_once("../models/InfoGeneral.php");

$info = new InfoGeneral();

switch ($_GET["op"]) {

    // 📄 Listar imágenes
    case "listar":
        $datos = $info->listar();
        echo json_encode($datos);
    break;

    // 💾 Guardar (insertar o actualizar)
    case "guardar":
        $imagen = "";

        if (!empty($_FILES["imagen"]["name"])) {
            // Crear subcarpeta por año y mes (ej: 2025-10)
            $subcarpeta = date("Y-m");
            $carpeta = realpath(__DIR__ . "/../public") . "/uploads/" . $subcarpeta;

            // Crear la carpeta si no existe
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            // Nombre seguro del archivo
            $nombreLimpio = preg_replace('/[^A-Za-z0-9_\.-]/', '_', basename($_FILES["imagen"]["name"]));
            $nombreArchivo = uniqid("info_") . "_" . $nombreLimpio;
            $rutaDestino = $carpeta . "/" . $nombreArchivo;

            // Mover archivo
            if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino)) {
                $imagen = "public/uploads/" . $subcarpeta . "/" . $nombreArchivo;
            } else {
                echo json_encode(["status" => "error", "msg" => "❌ No se pudo guardar la imagen."]);
                exit;
            }
        }

        if (empty($_POST["id_info"])) {
            $info->insertar($imagen);
            echo json_encode(["status" => "success", "msg" => "✅ Imagen agregada correctamente"]);
        } else {
            $id = $_POST["id_info"];
            $info->actualizar($id, $imagen);
            echo json_encode(["status" => "success", "msg" => "✅ Imagen actualizada correctamente"]);
        }
    break;

    // 🗑 Eliminar imagen
    case "eliminar":
        $info->eliminar($_POST["id_info"]);
        echo json_encode(["status" => "success", "msg" => "🗑 Imagen eliminada correctamente"]);
    break;
}
