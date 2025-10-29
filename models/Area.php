<?php
require_once("../config/conexion.php");

class Area extends Conectar {

    public function listar_areas() {
        $conectar = parent::Conexion();
        $sql = "SELECT id_area, nombre, descripcion, 
                       CASE WHEN activo = 1 THEN 'Activo' ELSE 'Inactivo' END AS estado
                FROM areas
                ORDER BY nombre ASC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar_area($nombre, $descripcion, $activo = 1) {
        $conectar = parent::Conexion();
        $sql = "INSERT INTO areas (nombre, descripcion, activo)
                VALUES (?, ?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $activo]);
    }

    public function obtener_area($id_area) {
        $conectar = parent::Conexion();
        $sql = "SELECT * FROM areas WHERE id_area = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_area]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar_area($id_area, $nombre, $descripcion, $activo) {
        $conectar = parent::Conexion();
        $sql = "UPDATE areas 
                SET nombre = ?, descripcion = ?, activo = ?
                WHERE id_area = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$nombre, $descripcion, $activo, $id_area]);
    }

    public function eliminar_area($id_area) {
        $conectar = parent::Conexion();
        $sql = "DELETE FROM areas WHERE id_area = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_area]);
    }
}
?>
