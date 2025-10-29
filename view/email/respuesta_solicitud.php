<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Respuesta a solicitud</title>
<style>
body { font-family: Arial, sans-serif; background: #f6f6f6; padding: 20px; color: #333; }
.container { background: white; border-radius: 8px; padding: 25px; max-width: 600px; margin: auto; box-shadow: 0 3px 8px rgba(0,0,0,0.1); }
h2 { color: #0056b3; margin-bottom: 10px; }
.status { font-weight: bold; color: {{color_estado}}; }
.footer { margin-top: 25px; font-size: 13px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
</style>
</head>
<body>
<div class="container">
    <h2>📬 Respuesta a tu Solicitud</h2>
    <p><strong>Estimado(a):</strong> {{usuario_nombre}}</p>
    <p>Tu solicitud registrada el {{fecha_solicitud}} ha sido:</p>

    <p class="status">{{estado}}</p>
    <p><strong>Observaciones:</strong> {{observaciones}}</p>

    <p><strong>Tipo de permiso:</strong> {{tipo_permiso}}</p>
    <p><strong>Fechas:</strong> del {{fecha_inicio}} al {{fecha_fin}}</p>

    <div class="footer">
        © {{anio}} ClicGo Notificaciones<br>
        Este correo se generó automáticamente, por favor no responda.
    </div>
</div>
</body>
</html>
