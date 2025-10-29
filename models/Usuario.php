<?php
require_once(__DIR__ . "/../config/conexion.php");

class Usuario extends Conectar {

    /* ===========================================================
       LOGIN
    ============================================================ */
    public function login($correo, $contrasena) {
            $conectar = parent::Conexion();
            parent::set_names();

            $sql = "SELECT e.id_empleado, e.numero_nomina, e.nombre, e.apellido, e.contrasena_hash, 
                        e.correo, e.fecha_ingreso, r.id_rol, r.nombre AS rol
                    FROM empleados e
                    INNER JOIN roles r ON e.id_rol = r.id_rol
                    WHERE e.correo = ?";

            $stmt = $conectar->prepare($sql);
            $stmt->execute([$correo]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado && password_verify($contrasena, $resultado["contrasena_hash"])) {
                // Crear la sesión
                $_SESSION["id_empleado"] = $resultado["id_empleado"];
                $_SESSION["numero_nomina"] = $resultado["numero_nomina"];
                $_SESSION["nombre"] = $resultado["nombre"] . " " . $resultado["apellido"];
                $_SESSION["correo"] = $resultado["correo"];
                $_SESSION["fecha_ingreso"] = $resultado["fecha_ingreso"];
                $_SESSION["id_rol"] = $resultado["id_rol"];
                $_SESSION["rol"] = $resultado["rol"];

                // 👇 Ejecutar el mantenimiento automático de periodos
                $this->actualizar_periodo_vacacional($resultado["id_empleado"]);

                return true;
            } else {
                return false;
            }
        }

    /* ===========================================================
    ACTUALIZAR PERIODO VACACIONAL AL INICIAR SESIÓN
    ============================================================ */
    public function actualizar_periodo_vacacional($id_empleado) {
        $conectar = parent::Conexion();
        $sql = "EXEC sp_generar_periodos_vacacionales";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
    }

    /* ===========================================================
       LISTAR USUARIOS
    ============================================================ */
    public function listar_usuarios() {
        $conectar = parent::Conexion();

        $sql = "SELECT 
                    e.id_empleado,
                    e.numero_nomina,
                    e.nombre,
                    e.apellido,
                    e.fecha_nacimiento,
                    e.puesto,
                    e.correo,
                    e.fecha_ingreso,
                    e.activo,
                    r.nombre AS rol,
                    a.nombre AS area
                FROM empleados e
                INNER JOIN roles r ON e.id_rol = r.id_rol
                LEFT JOIN areas a ON e.id_area = a.id_area
                ORDER BY e.id_empleado DESC";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       OBTENER UN USUARIO
    ============================================================ */
    public function obtener_usuario($id_empleado) {
        $conectar = parent::Conexion();

        $sql = "SELECT * FROM empleados WHERE id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       INSERTAR NUEVO USUARIO
    ============================================================ */
    public function insertar_usuario($numero_nomina, $nombre, $apellido, $puesto, $fecha_nacimiento, $correo, $contrasena, $fecha_ingreso, $id_jefe, $id_rol, $id_area) {
        $conectar = parent::Conexion();

        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "INSERT INTO empleados (numero_nomina, nombre, apellido, fecha_nacimiento, puesto, correo, contrasena_hash, fecha_ingreso, id_jefe, id_rol, id_area, activo)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([$numero_nomina, $nombre, $apellido, $puesto, $fecha_nacimiento, $correo, $contrasena_hash, $fecha_ingreso, $id_jefe, $id_rol, $id_area]);
    }

    /* ===========================================================
       ACTUALIZAR USUARIO EXISTENTE
    ============================================================ */
    public function actualizar_usuario($numero_nomina, $id_empleado, $nombre, $apellido, $fecha_nacimiento, $puesto, $correo, $id_jefe, $id_rol, $id_area, $activo) {
        $conectar = parent::Conexion();

        $sql = "UPDATE empleados 
        SET numero_nomina = ?, nombre = ?, apellido = ?, fecha_nacimiento = ?, puesto = ?, correo = ?, 
            id_jefe = ?, id_rol = ?, id_area = ?, activo = ?
        WHERE id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$numero_nomina, $nombre, $apellido, $fecha_nacimiento, $puesto, $correo, $id_jefe, $id_rol, $id_area, $activo, $id_empleado]);
    }

    /* ===========================================================
       ELIMINAR (DESACTIVAR) USUARIO
    ============================================================ */
    public function eliminar_usuario($id_empleado) {
        $conectar = parent::Conexion();
        $sql = "UPDATE empleados SET activo = 0 WHERE id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
    }

    /* ===========================================================
       CAMBIAR CONTRASEÑA
    ============================================================ */
    public function cambiar_contrasena($id_empleado, $nueva_contrasena) {
        $conectar = parent::Conexion();
        $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);

        $sql = "UPDATE empleados SET contrasena_hash = ? WHERE id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$hash, $id_empleado]);
    }

    /* ===========================================================
       LISTAR JEFES ACTIVOS
    ============================================================ */
    public function listar_jefes() {
        $conectar = parent::Conexion();
        $sql = "SELECT id_empleado, nombre + ' ' + apellido AS nombre_completo
                FROM empleados
                WHERE id_rol = 2 AND activo = 1";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       LISTAR AREAS ACTIVAS
    ============================================================ */
    public function listar_areas() {
        $conectar = parent::Conexion();
        $sql = "SELECT id_area, nombre FROM areas WHERE activo = 1 ORDER BY nombre ASC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       OBTENER UN USUARIO POR ID
    ============================================================ */
    public function obtener_usuario_por_id($id_empleado) {
        $conectar = parent::Conexion();
        $sql = "SELECT 
                e.id_empleado,
                e.numero_nomina,
                e.nombre,
                e.apellido,
                e.correo,
                e.puesto,
                e.fecha_nacimiento,
                e.fecha_ingreso,
                r.nombre AS rol,
                a.nombre AS area,
                CONCAT(j.nombre, ' ', j.apellido) AS jefe
            FROM empleados e
            INNER JOIN roles r ON e.id_rol = r.id_rol
            LEFT JOIN areas a ON e.id_area = a.id_area
            LEFT JOIN empleados j ON e.id_jefe = j.id_empleado
            WHERE e.id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
