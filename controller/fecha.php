<?php
require_once("../config/conexion.php");
require_once("../models/Fecha.php");

$fecha = new Fecha();

switch ($_GET["op"]) {

    /* ===========================================================
       1️⃣ LISTAR FECHAS
    ============================================================ */
    case "listar":
        $anio = isset($_POST["anio"]) ? $_POST["anio"] : date("Y");
        $datos = $fecha->listar_fechas($anio);

        $data = array();
        foreach ($datos as $row) {
            $data[] = array(
                "id_festivo"   => isset($row["id_festivo"]) ? $row["id_festivo"] : null,
                "fecha"        => $row["fecha"],
                "dia_semana"   => $row["dia_semana"],
                "descripcion"  => $row["descripcion"],
                "tipo"         => $row["tipo"]
            );
        }

        echo json_encode(["data" => $data]);
        break;

    /* ===========================================================
       2️⃣ INSERTAR NUEVA FECHA
    ============================================================ */
    case "insertar":
        $fecha_valor = $_POST["fecha"] ?? null;
        $descripcion = $_POST["descripcion"] ?? null;
        $tipo = $_POST["tipo"] ?? "Interno";

        if ($fecha_valor && $descripcion) {
            $resultado = $fecha->insertar_fecha($fecha_valor, $descripcion, $tipo);

            if ($resultado) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Fecha registrada correctamente"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "No se pudo registrar la fecha"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Faltan datos obligatorios"
            ]);
        }
        break;

    /* ===========================================================
       3️⃣ ELIMINAR FECHA
    ============================================================ */
    case "eliminar":
        $id_festivo = $_POST["id_festivo"] ?? null;

        if ($id_festivo) {
            $resultado = $fecha->eliminar_fecha($id_festivo);

            if ($resultado) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Fecha eliminada correctamente"
                ]);
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "No se pudo eliminar la fecha"
                ]);
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "ID no válido"
            ]);
        }
        break;

    /* ===========================================================
       4️⃣ (Opcional) OBTENER DETALLE DE UNA FECHA
    ============================================================ */
    case "obtener":
        $id_festivo = $_POST["id_festivo"] ?? null;
        if ($id_festivo) {
            $sql = "SELECT * FROM dias_festivos WHERE id_festivo = ?";
            $conectar = (new Conectar())->Conexion();
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$id_festivo]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
        }
        break;
}
?>
