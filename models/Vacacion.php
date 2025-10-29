<?php
require_once(__DIR__ . "/../config/conexion.php");

class Vacacion extends Conectar {

    /* ===========================================================
       LISTAR VACACIONES POR EMPLEADO
    ============================================================ */
    public function listar_vacaciones_por_empleado($id_empleado)
    {
        $conectar = parent::Conexion();
        parent::set_names();

        $sql = "SELECT 
                    FORMAT(periodo_inicio, 'dd/MM/yyyy') + ' - ' + FORMAT(periodo_fin, 'dd/MM/yyyy') AS periodo,
                    dias_otorgados AS dias_totales,
                    dias_tomados,
                    (dias_otorgados - dias_tomados) AS dias_disponibles,
                    CASE 
                        WHEN (dias_otorgados - dias_tomados) > 0 THEN 'Activo'
                        ELSE 'Agotado'
                    END AS estado
                FROM vacaciones_periodos
                WHERE id_empleado = ?
                ORDER BY periodo_inicio DESC";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
