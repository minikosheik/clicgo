<?php
require_once("config/email.php");

$ok = enviarCorreo(
    "aaron.lugo@rolan.com",
    "📧 Prueba de correo Gmail - ClicGo",
    "nueva_solicitud.php",
    [
        "jefe_nombre" => "Aaron Lugo",
        "usuario_nombre" => "Judith",
        "motivo" => "Prueba de envío desde Gmail",
        "fecha_inicio" => "2025-10-22",
        "fecha_fin" => "2025-10-25",
        "fecha_solicitud" => date("d/m/Y"),
        "anio" => date("Y")
    ]
);

echo $ok ? "✅ Correo enviado correctamente" : "❌ Error al enviar correo";
?>
