<?php
require_once(__DIR__ . "/../config/conexion.php");

class Fecha extends Conectar {

    /* ===========================================================
       LISTAR FECHAS
    ============================================================ */
    public function listar_fechas() {
        $conectar = parent::Conexion();

        $sql = "SELECT * FROM v_dias_no_laborables WHERE anio = 2025";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     /* ===========================================================
       INSERTAR NUEVA FECHA
    ============================================================ */
    public function insertar_fecha($fecha, $descripcion, $tipo = 'Interno') {
        $conectar = parent::Conexion();
        parent::set_names();

        try {
            $sql = "INSERT INTO dias_festivos (fecha, descripcion, tipo) VALUES (?, ?, ?)";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$fecha, $descripcion, $tipo]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al insertar fecha: " . $e->getMessage());
            return false;
        }
    }

     /* ===========================================================
       ELIMINAR FECHA
    ============================================================ */
    public function eliminar_fecha($id_festivo) {
        $conectar = parent::Conexion();
        parent::set_names();

        try {
            $sql = "DELETE FROM dias_festivos WHERE id_festivo = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$id_festivo]);
            return true;
        } catch (PDOException $e) {
            error_log("Error al eliminar fecha: " . $e->getMessage());
            return false;
        }
    }
}
?>