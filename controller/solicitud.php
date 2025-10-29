<?php
require_once("../config/conexion.php");
require_once("../models/Solicitud.php");
require_once("../config/email.php"); // 👈 Importa función enviarCorreo()

$solicitud = new Solicitud();

switch ($_GET["op"]) {

    /* ===========================================================
       LISTAR SOLICITUDES
    =========================================================== */
    case "listar":
        $datos = $solicitud->listar_solicitudes();
        echo json_encode(["data" => $datos]);
    break;

     /* ===========================================================
       INSERTAR NUEVA SOLICITUD
    =========================================================== */
    case "insertar":
        session_start();
        $id_empleado = $_SESSION["id_empleado"];

        $solicitud->insertar_solicitud(
            $id_empleado,
            $_POST["tipo"],
            $_POST["fecha_inicio"],
            $_POST["fecha_fin"],
            $_POST["motivo"]
        );

        // === Obtener datos para el correo ===
        $info = $solicitud->obtener_datos_para_correo($id_empleado);

        if ($info && !empty($info["correo_jefe"])) {
            $datosCorreo = [
                "jefe_nombre"     => $info["nombre_jefe"],
                "usuario_nombre"  => $info["nombre_empleado"],
                "motivo"          => $_POST["motivo"],
                "fecha_inicio"    => $_POST["fecha_inicio"],
                "fecha_fin"       => $_POST["fecha_fin"],
                "fecha_solicitud" => date("d/m/Y"),
                "anio"            => date("Y")
            ];

            enviarCorreo(
                $info["correo_jefe"],
                "Nueva solicitud registrada - ClicGo",
                "nueva_solicitud.php",
                $datosCorreo
            );
        }

        echo json_encode(["status" => "success", "message" => "Solicitud registrada y notificada correctamente."]);
    break;

    /* ===========================================================
       ACTUALIZAR ESTADO GENERAL (usado en jefe)
    =========================================================== */
    case "actualizar_estado":
        $id_solicitud  = $_POST["id_solicitud"];
        $nuevo_estado  = $_POST["estado"];
        $observaciones = $_POST["observaciones"] ?? null;
        $tipo_permiso  = $_POST["tipo_permiso"] ?? null;

        $solicitud->actualizar_estado($id_solicitud, $nuevo_estado, $observaciones, $tipo_permiso);

        // === Envío de correo al empleado ===
        $correoUsuario   = $solicitud->obtenerCorreoUsuario($id_solicitud);
        $datosSolicitud  = $solicitud->obtener_solicitud($id_solicitud);
        $nombreJefe      = $_SESSION["nombre_empleado"] ?? "Tu jefe";
        $color_estado    = ($nuevo_estado == "Autorizado") ? "#28a745" : "#dc3545";
        $estado_legible  = ($nuevo_estado == "Autorizado") ? "autorizada ✅" : "rechazada ❌";

        if ($correoUsuario) {
            $datosCorreo = [
                "usuario_nombre" => $datosSolicitud["empleado"] ?? "Empleado",
                "jefe_nombre" => $nombreJefe,
                "estado" => $estado_legible,
                "motivo" => $datosSolicitud["motivo"] ?? "",
                "comentario" => $observaciones ?? "Sin comentarios",
                "color_estado" => $color_estado,
                "anio" => date("Y")
            ];

            enviarCorreo(
                $correoUsuario,
                "Tu solicitud ha sido {$estado_legible} - ClicGo",
                "solicitud_respuesta.php",
                $datosCorreo
            );
        }

        echo json_encode(["status" => "success", "message" => "Estado actualizado correctamente."]);
    break;

    /* ===========================================================
       LISTAR POR EMPLEADO
    =========================================================== */
    case "listar_por_empleado":
        session_start();
        $id_empleado = $_SESSION["id_empleado"];
        $datos = $solicitud->listar_por_empleado($id_empleado);

        $data = [];
        foreach ($datos as $row) {
            $data[] = [
                "id_solicitud" => $row["id_solicitud"],
                "tipo"         => $row["tipo"],
                "fecha_inicio" => $row["fecha_inicio"],
                "fecha_fin"    => $row["fecha_fin"],
                "dias_habiles" => $row["dias_habiles"],
                "motivo"       => $row["motivo"],
                "estado"       => match ($row["estado"]) {
                    "Autorizado" => '<span class="badge bg-success">Autorizado</span>',
                    "Rechazado"  => '<span class="badge bg-danger">Rechazado</span>',
                    default       => '<span class="badge bg-warning text-dark">En proceso</span>'
                },
                "fecha_solicitud" => $row["fecha_solicitud"]
            ];
        }

        echo json_encode(["data" => $data]);
    break;

    /* ===========================================================
       LISTAR POR JEFE
    =========================================================== */
    case "listar_por_jefe":
        session_start();
        $id_jefe = $_SESSION["id_empleado"];

        $datos = $solicitud->listar_por_jefe($id_jefe);
        $data = [];

        foreach ($datos as $row) {
            $acciones = '
                <div class="btn-group" role="group">
                    <button class="btn btn-info btn-sm btn-detalle"
                        data-id="'.$row["id_solicitud"].'"
                        title="Ver Detalle">
                        <i class="bx bx-search"></i>
                    </button>
                </div>
            ';

            $data[] = [
                "id_solicitud" => $row["id_solicitud"],
                "empleado"     => $row["empleado"],
                "tipo"         => $row["tipo"],
                "fecha_inicio" => $row["fecha_inicio"],
                "fecha_fin"    => $row["fecha_fin"],
                "dias_habiles" => $row["dias_habiles"],
                "motivo"       => $row["motivo"],
                "estado"       => $row["estado"],
                "acciones"     => $acciones
            ];
        }

        echo json_encode(["data" => $data]);
    break;

    /* ===========================================================
       DETALLE DE SOLICITUD
    =========================================================== */
    case "detalle":
        $id_solicitud = $_POST["id_solicitud"];
        $datos = $solicitud->obtener_solicitud($id_solicitud);

        if ($datos) {
            echo json_encode(["status" => "success", "solicitud" => $datos]);
        } else {
            echo json_encode(["status" => "error", "message" => "No se encontró la solicitud."]);
        }
    break;

    /* ===========================================================
       AUTORIZAR SOLICITUD
    =========================================================== */
    case "autorizar":
        $id_solicitud = $_POST["id_solicitud"];
        $observaciones = $_POST["observaciones"] ?? "";
        $tipo_permiso = $_POST["tipo_permiso"] ?? "";

       session_start(); // por si acaso no estaba ya

        $id_jefe_autoriza = $_SESSION["id_empleado"]; // el jefe logueado

        $resultado = $solicitud->autorizar_solicitud(
            $id_solicitud,
            $observaciones,
            $tipo_permiso,
            $id_jefe_autoriza
        );

        // === Enviar correo al usuario ===
        if ($resultado && isset($resultado["correo_empleado"])) {
            $datosCorreo = [
                "usuario_nombre"  => $resultado["nombre_empleado"],
                "estado"          => "✅ AUTORIZADA",
                "color_estado"    => "#198754",
                "tipo_permiso"    => $resultado["tipo_permiso"],
                "fecha_inicio"    => $resultado["fecha_inicio"],
                "fecha_fin"       => $resultado["fecha_fin"],
                "fecha_solicitud" => $resultado["fecha_solicitud"],
                "observaciones"   => $observaciones,
                "anio"            => date("Y")
            ];

            enviarCorreo(
                $resultado["correo_empleado"],
                "Tu solicitud fue autorizada - ClicGo",
                "respuesta_solicitud.php",
                $datosCorreo
            );
        }

        echo json_encode(["status" => "success", "message" => "Solicitud autorizada y notificada."]);
    break;

    /* ===========================================================
       RECHAZAR SOLICITUD
    =========================================================== */
    case "rechazar":
        $id_solicitud = $_POST["id_solicitud"];
        $observaciones = $_POST["observaciones"] ?? "";

        session_start();

        $id_jefe_autoriza = $_SESSION["id_empleado"];

        $resultado = $solicitud->rechazar_solicitud(
            $id_solicitud,
            $observaciones,
            $id_jefe_autoriza
        );

        if ($resultado["status"] === "success" && !empty($resultado["correo_empleado"])) {
            $datosCorreo = [
                "usuario_nombre"  => $resultado["nombre_empleado"],
                "estado"          => "❌ RECHAZADA",
                "color_estado"    => "#dc3545",
                "tipo_permiso"    => $resultado["tipo_permiso"],
                "fecha_inicio"    => $resultado["fecha_inicio"],
                "fecha_fin"       => $resultado["fecha_fin"],
                "fecha_solicitud" => $resultado["fecha_solicitud"],
                "observaciones"   => $resultado["observaciones"],
                "anio"            => date("Y")
            ];

            enviarCorreo(
                $resultado["correo_empleado"],
                "Tu solicitud fue rechazada - ClicGo",
                "respuesta_solicitud.php",
                $datosCorreo
            );
        }

        echo json_encode(["status" => "success", "message" => "Solicitud rechazada correctamente."]);
    break;

     /* ===========================================================
    LISTAR TODAS SOLICITUDES (solo administrador)
    =========================================================== */
    case "listar_todas":
        session_start();
        if ($_SESSION["rol"] !== "administrador") {
            echo json_encode(["status" => "error", "message" => "Acceso denegado"]);
            exit();
        }

        $datos = $solicitud->listar_solicitudes_todas();
        echo json_encode(["data" => $datos]);
    break;

    /* ===========================================================
    ELIMINAR SOLICITUD (solo administrador)
    =========================================================== */
    case "eliminar":
        session_start();
        if ($_SESSION["rol"] !== "administrador") {
            echo json_encode(["status" => "error", "message" => "Acceso denegado"]);
            exit();
        }

        $id_solicitud = $_POST["id_solicitud"];
        $solicitud->eliminar_solicitud($id_solicitud);
        echo json_encode(["status" => "success", "message" => "Solicitud eliminada correctamente"]);
    break;
    
    /* ===========================================================
    ACTUALIZAR SOLICITUD (solo administrador)
    =========================================================== */
    case "editar":
        session_start();
        if (!isset($_SESSION["rol"]) || strtolower($_SESSION["rol"]) !== "administrador") {
            echo json_encode(["status" => "error", "message" => "Acceso denegado"]);
            exit();
        }

        $id_solicitud = $_POST["id_solicitud"];
        $tipo = $_POST["tipo"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $motivo = $_POST["motivo"];
        $estado = $_POST["estado"];

        $resultado = $solicitud->editar_solicitud($id_solicitud, $tipo, $fecha_inicio, $fecha_fin, $motivo, $estado);
        echo json_encode($resultado);
    break;
}
?>
