<?php
require_once(__DIR__ . "/../config/conexion.php");

class Solicitud extends Conectar {

    /* ===========================================================
       LISTAR SOLICITUDES
    ============================================================ */
    public function listar_solicitudes() {
        $conectar = parent::Conexion();

        $sql = "SELECT s.id_solicitud, e.numero_nomina, 
                       CONCAT(e.nombre, ' ', e.apellido) AS empleado,
                       s.tipo, s.fecha_inicio, s.fecha_fin,
                       s.dias_habiles, s.motivo, s.estado, 
                       CONCAT(j.nombre, ' ', j.apellido) AS jefe
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                LEFT JOIN empleados j ON s.id_autoriza = j.id_empleado
                ORDER BY s.fecha_solicitud DESC";

        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       LISTAR SOLICITUDES POR USUARIO
    ============================================================ */
    public function listar_por_empleado($id_empleado) {
        $conectar = parent::Conexion();

        $sql = "SELECT s.id_solicitud,
                    s.tipo,
                    s.fecha_inicio,
                    s.fecha_fin,
                    s.dias_habiles,
                    s.motivo,
                    s.estado,
                    s.fecha_solicitud
                FROM solicitudes s
                INNER JOIN empleados e ON s.numero_nomina = e.numero_nomina
                WHERE s.id_empleado = ?
                ORDER BY s.fecha_solicitud DESC";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       INSERTAR SOLICITUD
    ============================================================ */
    public function insertar_solicitud($id_empleado, $tipo, $fecha_inicio, $fecha_fin, $motivo) {
        $conectar = parent::Conexion();

        try {
            // Validar orden de fechas
            if (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
                throw new Exception("La fecha final no puede ser anterior a la fecha de inicio.");
            }

            // 1. Obtener número de nómina
            $sql_nomina = "SELECT numero_nomina FROM empleados WHERE id_empleado = ?";
            $stmt_nomina = $conectar->prepare($sql_nomina);
            $stmt_nomina->execute([$id_empleado]);
            $row_nomina = $stmt_nomina->fetch(PDO::FETCH_ASSOC);

            if (!$row_nomina) {
                throw new Exception("Empleado no encontrado para la solicitud.");
            }

            $numero_nomina = $row_nomina["numero_nomina"];

            // 2. Calcular días hábiles con el SP
            $dias_habiles = 0;

            try {
                $sqlDias = "EXEC sp_calcular_dias_habiles ?, ?";
                $stmtDias = $conectar->prepare($sqlDias);
                $stmtDias->execute([$fecha_inicio, $fecha_fin]);
                $result = $stmtDias->fetch(PDO::FETCH_ASSOC);

                if ($result) {
                    if (isset($result["dias_habiles"])) {
                        $dias_habiles = (int)$result["dias_habiles"];
                    } else {
                        // fallback: tomar la primera columna devuelta por el SP
                        $dias_habiles = (int)array_values($result)[0];
                    }
                }
            } catch (Exception $eSP) {
                // Esto captura errores como "tabla no existe", etc.
                error_log("❌ Error en sp_calcular_dias_habiles: " . $eSP->getMessage());
                throw new Exception("Hubo un problema al calcular los días hábiles. Consulta con TI.");
            }

            if ($dias_habiles <= 0) {
                throw new Exception("El rango seleccionado no contiene días hábiles válidos.");
            }

            // 3. Insertar solicitud
            $sql = "INSERT INTO solicitudes 
                    (numero_nomina, id_empleado, tipo, fecha_inicio, fecha_fin, dias_habiles, motivo, estado, fecha_solicitud)
                    VALUES (?, ?, ?, ?, ?, ?, ?, 'Pendiente', GETDATE())";

            $stmt = $conectar->prepare($sql);
            $stmt->execute([
                $numero_nomina,
                $id_empleado,
                $tipo,
                $fecha_inicio,
                $fecha_fin,
                $dias_habiles,
                $motivo
            ]);

            // 4. (Opcional) Enviar correo al jefe aquí si quieres
            //    pero por ahora asumimos que esto lo hace tu controlador
            //    después de llamar a este método con éxito.

            error_log("✅ Solicitud guardada. Empleado $id_empleado, $dias_habiles día(s) hábil(es).");

            return [
                "status" => "success",
                "message" => "Solicitud registrada correctamente",
                "dias_habiles" => $dias_habiles
            ];

        } catch (Exception $e) {
            error_log("❌ insertar_solicitud error: " . $e->getMessage());
            return [
                "status" => "error",
                "message" => $e->getMessage()
            ];
        }
    }

    /* ===========================================================
       LISTAR SOLICITUDES POR JEFE
    ============================================================ */
    public function listar_por_jefe($id_jefe) {
        $conectar = parent::Conexion();

        $sql = "
            SELECT 
                s.id_solicitud,
                e.id_empleado,
                (e.nombre + ' ' + e.apellido) AS empleado,
                s.tipo,
                CONVERT(VARCHAR(10), s.fecha_inicio, 103) AS fecha_inicio,
                CONVERT(VARCHAR(10), s.fecha_fin, 103) AS fecha_fin,
                s.dias_habiles, -- ✅ usar el valor real calculado por el SP
                s.motivo,
                s.estado
            FROM solicitudes s
            INNER JOIN empleados e ON s.id_empleado = e.id_empleado
            WHERE e.id_jefe = ?
            ORDER BY s.fecha_inicio DESC
        ";

        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_jefe]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
       OBTENER SOLICITUDES
    ============================================================ */
    public function obtener_solicitud($id_solicitud) {
        $conectar = parent::Conexion();
        $sql = "SELECT s.*, e.nombre + ' ' + e.apellido AS empleado, r.nombre AS rol
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                INNER JOIN roles r ON e.id_rol = r.id_rol
                WHERE s.id_solicitud = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_solicitud]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   /* ===========================================================
       ACTUALIZAR ESTADO (AUTORIZAR / RECHAZAR)
    ============================================================ */
    public function actualizar_estado($id_solicitud, $estado, $observaciones = null, $tipo_permiso = null) {
        $conectar = parent::Conexion();
        $sql = "UPDATE solicitudes 
                SET estado = ?, 
                    observaciones_jefe = ?, 
                    tipo_permiso = ?, 
                    fecha_autorizacion = GETDATE(),
                    id_jefe_autoriza = ?
                WHERE id_solicitud = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$estado, $observaciones, $tipo_permiso, $_SESSION["id_empleado"], $id_solicitud]);
    }

    /* ===========================================================
    AUTORIZAR SOLICITUD (con validación y descuento de vacaciones)
    =========================================================== */
    public function autorizar_solicitud($id_solicitud, $observaciones, $tipo_permiso = null, $id_jefe_autoriza) {
        $conectar = parent::Conexion();

        try {
            // 1️⃣ Obtener información de la solicitud
            $sqlInfo = "SELECT id_empleado, tipo, dias_habiles, fecha_inicio, fecha_fin, fecha_solicitud
                        FROM solicitudes WHERE id_solicitud = ?";
            $stmt = $conectar->prepare($sqlInfo);
            $stmt->execute([$id_solicitud]);
            $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$solicitud) {
                return ["status" => "error", "message" => "No se encontró la solicitud."];
            }

            $id_empleado = $solicitud["id_empleado"];
            $tipo = strtolower(trim($solicitud["tipo"]));
            $dias = intval($solicitud["dias_habiles"]);

            // 2️⃣ Validar días disponibles si aplica vacaciones
            if ($tipo === "vacaciones" || $tipo_permiso === "A cuenta de vacaciones") {

                $sqlPeriodo = "SELECT TOP 1 id_periodo, dias_tomados, dias_otorgados,
                                    (dias_otorgados - dias_tomados) AS dias_restantes
                            FROM vacaciones_periodos
                            WHERE id_empleado = ?
                            ORDER BY periodo_inicio DESC";
                $stmtP = $conectar->prepare($sqlPeriodo);
                $stmtP->execute([$id_empleado]);
                $periodo = $stmtP->fetch(PDO::FETCH_ASSOC);

                if (!$periodo) {
                    return ["status" => "error", "message" => "El empleado no tiene un periodo de vacaciones registrado."];
                }

                if ($dias > $periodo["dias_restantes"]) {
                    return [
                        "status" => "error",
                        "message" => "El empleado solo tiene {$periodo['dias_restantes']} días disponibles."
                    ];
                }
            }

            // 3️⃣ Marcar solicitud como Autorizada
            $sqlUpdate = "UPDATE solicitudes
                        SET estado = 'Autorizado',
                            observaciones_jefe = ?,
                            tipo_permiso = ?,
                            fecha_autorizacion = GETDATE(),
                            id_autoriza = ?
                        WHERE id_solicitud = ?";
            $stmtU = $conectar->prepare($sqlUpdate);
            $stmtU->execute([$observaciones, $tipo_permiso, $id_jefe_autoriza, $id_solicitud]);

            // 4️⃣ Descontar vacaciones si aplica
            if (($tipo === "vacaciones" || $tipo_permiso === "A cuenta de vacaciones") && isset($periodo)) {
                $nuevoTomados = $periodo["dias_tomados"] + $dias;
                if ($nuevoTomados > $periodo["dias_otorgados"]) {
                    $nuevoTomados = $periodo["dias_otorgados"];
                }

                $sqlVac = "UPDATE vacaciones_periodos
                        SET dias_tomados = ?
                        WHERE id_periodo = ?";
                $stmtV = $conectar->prepare($sqlVac);
                $stmtV->execute([$nuevoTomados, $periodo["id_periodo"]]);
            }

            // 5️⃣ Info para correo
            $sqlEmpleado = "SELECT 
                                e.nombre AS nombre_empleado,
                                e.apellido,
                                e.correo AS correo_empleado,
                                j.nombre AS nombre_jefe,
                                j.correo AS correo_jefe
                            FROM empleados e
                            LEFT JOIN empleados j ON e.id_jefe = j.id_empleado
                            WHERE e.id_empleado = ?";
            $stmtE = $conectar->prepare($sqlEmpleado);
            $stmtE->execute([$id_empleado]);
            $empleado = $stmtE->fetch(PDO::FETCH_ASSOC);

            return [
                "status"          => "success",
                "message"         => "Solicitud autorizada correctamente",
                "nombre_empleado" => trim(($empleado["nombre_empleado"] ?? "") . " " . ($empleado["apellido"] ?? "")),
                "correo_empleado" => $empleado["correo_empleado"] ?? "",
                "nombre_jefe"     => $empleado["nombre_jefe"] ?? "",
                "correo_jefe"     => $empleado["correo_jefe"] ?? "",
                "tipo_permiso"    => $solicitud["tipo"],
                "fecha_inicio"    => $solicitud["fecha_inicio"],
                "fecha_fin"       => $solicitud["fecha_fin"],
                "fecha_solicitud" => $solicitud["fecha_solicitud"]
            ];

        } catch (Exception $e) {
            error_log("❌ Error en autorizar_solicitud: " . $e->getMessage());
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    /* ===========================================================
    RECHAZAR SOLICITUD
    =========================================================== */
    public function rechazar_solicitud($id_solicitud, $observaciones, $id_jefe_autoriza) {
        $conectar = parent::Conexion();

        try {
            // 1️⃣ Cambiar estado a Rechazado
            $sql = "UPDATE solicitudes 
                    SET estado = 'Rechazado',
                        observaciones_jefe = ?,
                        fecha_autorizacion = GETDATE(),
                        id_autoriza = ?
                    WHERE id_solicitud = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$observaciones, $id_jefe_autoriza, $id_solicitud]);

            // 2️⃣ Info completa para correo
            $sqlDatos = "SELECT 
                            s.tipo AS tipo_permiso,
                            s.fecha_inicio,
                            s.fecha_fin,
                            s.fecha_solicitud,
                            e.nombre AS nombre_empleado,
                            e.apellido,
                            e.correo AS correo_empleado,
                            j.nombre AS nombre_jefe,
                            j.correo AS correo_jefe
                        FROM solicitudes s
                        INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                        LEFT JOIN empleados j ON e.id_jefe = j.id_empleado
                        WHERE s.id_solicitud = ?";
            $stmt2 = $conectar->prepare($sqlDatos);
            $stmt2->execute([$id_solicitud]);
            $info = $stmt2->fetch(PDO::FETCH_ASSOC);

            if (!$info) {
                return ["status" => "error", "message" => "No se encontró la solicitud."];
            }

            return [
                "status"          => "success",
                "message"         => "Solicitud rechazada correctamente",
                "nombre_empleado" => trim(($info["nombre_empleado"] ?? "") . " " . ($info["apellido"] ?? "")),
                "correo_empleado" => $info["correo_empleado"] ?? "",
                "nombre_jefe"     => $info["nombre_jefe"] ?? "",
                "correo_jefe"     => $info["correo_jefe"] ?? "",
                "tipo_permiso"    => $info["tipo_permiso"] ?? "",
                "fecha_inicio"    => $info["fecha_inicio"] ?? "",
                "fecha_fin"       => $info["fecha_fin"] ?? "",
                "fecha_solicitud" => $info["fecha_solicitud"] ?? "",
                "observaciones"   => $observaciones
            ];

        } catch (Exception $e) {
            error_log("❌ Error en rechazar_solicitud: " . $e->getMessage());
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }


    /* ===========================================================
    OBTENER CORREO DEL JEFE
    =========================================================== */
    public function obtenerCorreoJefe($id_empleado) {
        $conectar = parent::Conexion();
        $sql = "SELECT u2.correo
                FROM empleados u1
                INNER JOIN empleados u2 ON u1.id_jefe = u2.id_empleado
                WHERE u1.id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['correo'] : null;
    }

    /* ===========================================================
    OBTENER CORREO DEL USUARIO
    =========================================================== */
    public function obtenerCorreoUsuario($id_solicitud) {
        $conectar = parent::Conexion();
        $sql = "SELECT e.correo
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                WHERE s.id_solicitud = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_solicitud]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['correo'] : null;
    }

    /* ===========================================================
    OBTENER EL NOMBRE DEL EMPLEADO
    =========================================================== */
    public function obtenerNombreEmpleado($id_empleado) {
        $conectar = parent::Conexion();
        $sql = "SELECT CONCAT(nombre, ' ', apellido) AS nombre
                FROM empleados WHERE id_empleado = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$id_empleado]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['nombre'] : "Empleado";
    }

    /* ===========================================================
    OBTENER DATOS PARA EL ENVIO DE CORREO
    =========================================================== */
    public function obtener_datos_para_correo($id_empleado) {
        $conectar = parent::conexion();

        $sql = "SELECT 
                    e.nombre AS nombre_empleado,
                    e.correo AS correo_empleado,
                    j.nombre AS nombre_jefe,
                    j.correo AS correo_jefe
                FROM empleados e
                INNER JOIN empleados j ON e.id_jefe = j.id_empleado
                WHERE e.id_empleado = ?";

        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id_empleado);
        $query->execute();

        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
    LISTAR SOLICITUDES EN VISTA REPORTE
    =========================================================== */
    public function listar_reporte($mes = "", $tipo = "") {
        $conectar = parent::Conexion();
        parent::set_names();

        // Construir filtro dinámico
        $where = " WHERE 1=1 ";

        if (!empty($mes)) {
            $where .= " AND MONTH(s.fecha_solicitud) = ? ";
        }

        if (!empty($tipo)) {
            $where .= " AND s.tipo = ? ";
        }

        $sql = "SELECT 
                    s.id_solicitud,
                    e.numero_nomina AS nomina,
                    e.nombre AS empleado,
                    e.apellido AS apellido,
                    s.tipo,
                    CONVERT(VARCHAR, s.fecha_inicio, 103) AS fecha_inicio,
                    CONVERT(VARCHAR, s.fecha_fin, 103) AS fecha_fin,
                    s.dias_habiles,
                    s.motivo,
                    s.estado,
                    CONVERT(VARCHAR, s.fecha_solicitud, 103) AS fecha_solicitud
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                $where
                ORDER BY s.fecha_solicitud DESC";

        $stmt = $conectar->prepare($sql);

        // Vincular parámetros dinámicamente
        $params = [];
        if (!empty($mes)) $params[] = $mes;
        if (!empty($tipo)) $params[] = $tipo;

        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ===========================================================
    LISTAR TODAS LAS SOLICITUDES (Solo administrador)
    =========================================================== */
    public function listar_solicitudes_todas() {
        $conectar = parent::Conexion();
        $sql = "SELECT 
                    s.id_solicitud,
                    e.nombre AS empleado,
                    e.apellido AS apellido,
                    s.tipo,
                    s.fecha_inicio,
                    s.fecha_fin,
                    s.dias_habiles,
                    s.motivo,
                    s.estado,
                    s.fecha_solicitud
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                ORDER BY s.id_solicitud DESC";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

/* ===========================================================
    ELIMINAR SOLICITUDES (Solo administrador)
    =========================================================== */
    public function eliminar_solicitud($id_solicitud) {
        $conectar = parent::Conexion();
        $sql = "DELETE FROM solicitudes WHERE id_solicitud = ?";
        $stmt = $conectar->prepare($sql);
        return $stmt->execute([$id_solicitud]);
    }

    /* ===========================================================
    EDITAR SOLICITUDES (Solo administrador)
    =========================================================== */
    public function editar_solicitud($id_solicitud, $tipo, $fecha_inicio, $fecha_fin, $motivo, $estado) {
        $conectar = parent::Conexion();

        try {
            $sql = "UPDATE solicitudes
                    SET tipo = ?, 
                        fecha_inicio = ?, 
                        fecha_fin = ?, 
                        motivo = ?, 
                        estado = ?
                    WHERE id_solicitud = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$tipo, $fecha_inicio, $fecha_fin, $motivo, $estado, $id_solicitud]);

            return ["status" => "success", "message" => "Solicitud actualizada correctamente"];
        } catch (Exception $e) {
            return ["status" => "error", "message" => "Error al actualizar: " . $e->getMessage()];
        }
    }

    public function solicitudes_home() {
        $conectar = parent::Conexion();
        $sql = "SELECT e.nombre, 
                e.apellido, 
                s.fecha_inicio, 
                s.fecha_fin, 
                s.tipo 
                FROM solicitudes s
                INNER JOIN empleados e ON s.id_empleado = e.id_empleado
                WHERE s.tipo in ('Vacaciones', 'Permiso')
                AND s.estado = 'Autorizado'";
        $stmt = $conectar->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
?>
