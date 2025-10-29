<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Nueva solicitud registrada</title>
<style>
body { font-family: Arial, sans-serif; background: #f6f6f6; padding: 20px; color: #333; }
.container { background: white; border-radius: 8px; padding: 25px; max-width: 600px; margin: auto; box-shadow: 0 3px 8px rgba(0,0,0,0.1); }
h2 { color: #0056b3; margin-bottom: 10px; }
p { line-height: 1.5; }
.footer { margin-top: 25px; font-size: 13px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
</style>
</head>
<body>
<div class="container">
    <h2>📩 Nueva Solicitud de Permiso</h2>
    <p><strong>Jefe(a):</strong> {{jefe_nombre}}</p>
    <p>El colaborador <strong>{{usuario_nombre}}</strong> ha registrado una nueva solicitud de permiso en el sistema <strong>ClicGo</strong>.</p>

    <p><strong>Motivo:</strong> {{motivo}}</p>
    <p><strong>Fechas:</strong> del {{fecha_inicio}} al {{fecha_fin}}</p>
    <p><strong>Registrada el:</strong> {{fecha_solicitud}}</p>

    <p>Por favor ingrese al <link rel="stylesheet" href="http://localhost/ClicGo/index.php">sistema</link> para revisarla y tomar acción.</p>

    <div class="footer">
        © {{anio}} ClicGo Notificaciones<br>
        Este correo se generó automáticamente, por favor no responda.
    </div>
</div>
</body>
</html>
