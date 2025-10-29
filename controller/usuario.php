<?php
require_once("../config/conexion.php");
require_once("../models/Usuario.php");

$usuario = new Usuario();

switch ($_GET["op"]) {

    /* ===========================================================
       LISTAR USUARIOS
    ============================================================ */
    case "listar":
        $datos = $usuario->listar_usuarios();
        $data = array();

        foreach ($datos as $row) {
            $data[] = array(
                "id_empleado"     => $row["id_empleado"],
                "numero_nomina"   => $row["numero_nomina"],
                "nombre_completo" => $row["nombre"] . " " . $row["apellido"],
                "fecha_nacimiento" => $row["fecha_nacimiento"],
                "puesto"          => $row["puesto"],
                "area"            => $row["area"],
                "correo"          => $row["correo"],
                "rol"             => $row["rol"],
                "fecha_ingreso"   => $row["fecha_ingreso"],
                "estatus"         => ($row["activo"] == 1)
                    ? '<span class="badge bg-success">Activo</span>'
                    : '<span class="badge bg-danger">Inactivo</span>',
                "acciones" => '
                    <button type="button" onClick="editar(' . $row["id_empleado"] . ');" class="btn btn-sm btn-warning">
                        <i class="bx bx-edit"></i>
                    </button>
                    <button type="button" onClick="eliminar(' . $row["id_empleado"] . ');" class="btn btn-sm btn-danger">
                        <i class="bx bx-trash"></i>
                    </button>
                '
            );
        }

        echo json_encode(["data" => $data]);
        break;


    /* ===========================================================
       INSERTAR USUARIO
    ============================================================ */
    case "insertar":
        $usuario->insertar_usuario(
            $_POST["numero_nomina"],
            $_POST["nombre"],
            $_POST["apellido"],
            $_POST["fecha_nacimiento"],
            $_POST["puesto"],
            $_POST["correo"],
            $_POST["contrasena"],
            $_POST["fecha_ingreso"],
            ($_POST["id_jefe"] !== "" ? $_POST["id_jefe"] : NULL),
            $_POST["id_rol"],
            $_POST["id_area"]
        );

        echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente"]);
        break;


    /* ===========================================================
       OBTENER USUARIO POR ID
    ============================================================ */
    case "obtener":
        $datos = $usuario->obtener_usuario($_POST["id_empleado"]);
        echo json_encode($datos);
        break;


    /* ===========================================================
       ACTUALIZAR USUARIO
    ============================================================ */
    case "actualizar":
        $usuario->actualizar_usuario(
            $_POST["numero_nomina"],      // ✅ 1° — número de nómina
            $_POST["id_empleado"],        // ✅ 2° — ID empleado
            $_POST["nombre"],
            $_POST["apellido"],
            $_POST["fecha_nacimiento"],
            $_POST["puesto"],
            $_POST["correo"],
            ($_POST["id_jefe"] !== "" ? $_POST["id_jefe"] : NULL),
            $_POST["id_rol"],
            $_POST["id_area"],
            $_POST["activo"]
        );

        echo json_encode(["status" => "success", "message" => "Usuario actualizado correctamente"]);
    break;
    /* ===========================================================
       ELIMINAR (DESACTIVAR) USUARIO
    ============================================================ */
    case "eliminar":
        $usuario->eliminar_usuario($_POST["id_empleado"]);
        echo json_encode(["status" => "success", "message" => "Usuario desactivado correctamente"]);
        break;


    /* ===========================================================
       CAMBIAR CONTRASEÑA
    ============================================================ */
    case "cambiar_contrasena":
        $usuario->cambiar_contrasena($_POST["id_empleado"], $_POST["nueva_contrasena"]);
        echo json_encode(["status" => "success", "message" => "Contraseña actualizada correctamente"]);
        break;


    /* ===========================================================
       LISTAR JEFE DIRECTO
    ============================================================ */
    case "listar_jefes":
        $datos = $usuario->listar_jefes();
        $data = array();

        foreach ($datos as $row) {
            $data[] = array(
                "id_empleado" => $row["id_empleado"],
                "nombre_completo" => $row["nombre_completo"]
            );
        }

        echo json_encode($data);
        break;


    /* ===========================================================
       LISTAR AREAS
    ============================================================ */
    case "listar_areas":
        $datos = $usuario->listar_areas();
        $data = array();

        foreach ($datos as $row) {
            $data[] = array(
                "id_area" => $row["id_area"],
                "nombre"  => $row["nombre"]
            );
        }

        echo json_encode($data);
        break;


    /* ===========================================================
       RESPUESTA DEFAULT
    ============================================================ */
    default:
        echo json_encode(["error" => "Operación no válida"]);
        break;
}
?>
