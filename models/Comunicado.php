<?php
class Comunicado extends Conectar {

    public function listar() {
        $conectar = parent::Conexion();
        $sql = "SELECT * FROM comunicados ORDER BY fecha_publicacion DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertar($titulo, $descripcion, $imagen) {
        $conectar = parent::Conexion();
        $sql = "INSERT INTO comunicados (titulo, descripcion, imagen) VALUES (?, ?, ?)";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$titulo, $descripcion, $imagen]);
        return $stmt;
    }

    public function actualizar($id, $titulo, $descripcion, $imagen = null) {
        $conectar = parent::Conexion();
        if ($imagen) {
            $sql = "UPDATE comunicados SET titulo=?, descripcion=?, imagen=? WHERE id_comunicado=?";
            $params = [$titulo, $descripcion, $imagen, $id];
        } else {
            $sql = "UPDATE comunicados SET titulo=?, descripcion=? WHERE id_comunicado=?";
            $params = [$titulo, $descripcion, $id];
        }
        $stmt = $conectar->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function eliminar($id) {
        $conectar = parent::Conexion();
        $sql = "DELETE FROM comunicados WHERE id_comunicado=?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id]);
        return $stmt;
    }

    public function obtener($id) {
        $conectar = parent::Conexion();
        $sql = "SELECT * FROM comunicados WHERE id_comunicado=?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function listar_publicos() {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "SELECT id_comunicado, titulo, descripcion, imagen, fecha_publicacion
                FROM comunicados
                ORDER BY fecha_publicacion DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
