<?php
require_once(__DIR__ . "/../config/conexion.php");

class Perfil extends Conectar {

    public function obtener_datos_usuario($numero_nomina) {
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
                j.nombre + ' ' + j.apellido AS jefe
            FROM empleados e
            INNER JOIN roles r ON e.id_rol = r.id_rol
            LEFT JOIN areas a ON e.id_area = a.id_area
            LEFT JOIN empleados j ON e.id_jefe = j.id_empleado
            WHERE e.id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$numero_nomina]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function calcular_dias_vacaciones($fecha_ingreso) {
        $fecha_actual = new DateTime();
        $fecha_inicio = new DateTime($fecha_ingreso);
        $antiguedad = $fecha_inicio->diff($fecha_actual)->y;

        if ($antiguedad == 0) return 0;
        if ($antiguedad == 1) return 12;
        if ($antiguedad == 2) return 14;
        if ($antiguedad == 3) return 16;
        if ($antiguedad == 4) return 18;
        if ($antiguedad >= 5) return 20 + (floor(($antiguedad - 5) / 5) * 2);
    }

    public function obtener_dias_tomados($numero_nomina) {
        $conectar = parent::Conexion();
        $sql = "SELECT ISNULL(SUM(dias_habiles), 0) AS dias_tomados
                FROM solicitudes
                WHERE numero_nomina = ? AND estado = 'Autorizada'";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$numero_nomina]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row["dias_tomados"];
    }
}
?>
