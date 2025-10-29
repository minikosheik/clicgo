<?php
class Home extends Conectar {

    // 📰 COMUNICADOS
    public function listar_comunicados() {
        $conectar = parent::Conexion();
        $sql = "SELECT id_comunicado, titulo, descripcion, imagen, fecha_publicacion
                FROM comunicados
                WHERE activo = 1
                ORDER BY fecha_publicacion DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🎉 ANIVERSARIOS DEL MES
    public function listar_aniversarios() {
        $conectar = parent::Conexion();
        $sql = "SELECT id_empleado, 
                       nombre + ' ' + apellido AS empleado, 
                       fecha_ingreso,
                       DATEDIFF(YEAR, fecha_ingreso, GETDATE()) AS anios
                FROM empleados
                WHERE MONTH(fecha_ingreso) = MONTH(GETDATE())
                ORDER BY DAY(fecha_ingreso)";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 📅 EVENTOS DEL MES
    public function listar_eventos_mes() {
        $conectar = parent::Conexion();
        $sql = "SELECT 
                s.id_solicitud,
                CONCAT(e.nombre, ' ', e.apellido) AS empleado,
                s.tipo,
                FORMAT(s.fecha_inicio, 'dd/MM/yyyy') AS fecha_inicio,
                FORMAT(s.fecha_fin, 'dd/MM/yyyy') AS fecha_fin
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                WHERE 
                s.estado = 'Autorizado'
                AND s.tipo IN ('Vacaciones', 'Permiso')
                AND (
                s.fecha_inicio BETWEEN DATEADD(DAY, -3, GETDATE()) AND DATEADD(DAY, 7, GETDATE())
                OR s.fecha_fin BETWEEN DATEADD(DAY, -3, GETDATE()) AND DATEADD(DAY, 7, GETDATE())
                )
                ORDER BY s.fecha_inicio ASC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar imágenes de Información General
    public function listarInfoGeneral() {
                $conectar = parent::Conexion();
                parent::set_names();

                $sql = "SELECT id_info, imagen, fecha_publicacion 
                        FROM informacion_general 
                        ORDER BY fecha_publicacion DESC";
                $stmt = $conectar->prepare($sql);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar Cumpleaños
    public function listar_cumpleanios() {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "SELECT id_empleado,
                    nombre + ' ' + apellido AS empleado,
                    DAY(fecha_nacimiento) AS dia,
                    DATENAME(MONTH, fecha_nacimiento) AS mes
                FROM empleados
                WHERE MONTH(fecha_nacimiento) = MONTH(GETDATE())
                ORDER BY DAY(fecha_nacimiento)";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
}
?>
