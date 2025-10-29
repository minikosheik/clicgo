<?php
class InfoGeneral extends Conectar {

    // 📋 Listar imágenes
    public function listar() {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "SELECT id_info, imagen, fecha_publicacion 
                FROM informacion_general 
                ORDER BY fecha_publicacion DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ➕ Insertar nueva imagen
    public function insertar($imagen) {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "INSERT INTO informacion_general (imagen, fecha_publicacion)
                VALUES (?, GETDATE())";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$imagen]);
    }

    // ✏️ Actualizar imagen existente
    public function actualizar($id_info, $imagen) {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "UPDATE informacion_general SET imagen = ? WHERE id_info = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$imagen, $id_info]);
    }

    // 🗑 Eliminar imagen
    public function eliminar($id_info) {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "DELETE FROM informacion_general WHERE id_info = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_info]);
    }
}
