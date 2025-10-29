<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

/**
 * Envía un correo con soporte HTML y plantilla.
 *
 * @param string $destinatario   Correo del receptor
 * @param string $asunto         Asunto del correo
 * @param string $plantilla      Archivo HTML en view/email/
 * @param array  $datos          Variables {{nombre}} → valor
 * @return bool
 */
function enviarCorreo($destinatario, $asunto, $plantilla, $datos = []) {
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';   // ✅ Corrige acentos, emojis y ñ
    $mail->Encoding = 'base64'; // ✅ Envía texto UTF-8 limpio

    try {

        $mail->SMTPDebug = 2;
        $mail->Debugoutput = function($str, $level) {
            error_log("SMTP DEBUG [$level]: $str");
        };

        // === Configuración SMTP para Gmail ===
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'clicgo.amsa@gmail.com'; // 👈 Tu cuenta Gmail
        $mail->Password   = 'sgovrgezvtytetuo'; // ⚠️ Usa Contraseña de aplicación
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Gmail usa TLS en 587
        $mail->Port       = 587;
        $mail->CharSet = 'UTF-8';   // ✅ Corrige acentos, emojis y ñ
        $mail->Encoding = 'base64'; // ✅ Envía texto UTF-8 limpio

        // === Datos del remitente y destinatario ===
        $mail->setFrom('clicgo.amsa@gmail.com', 'ClicGo Notificaciones');
        $mail->addAddress($destinatario);
        $mail->isHTML(true);
        $mail->Subject = $asunto;

        // === Cargar plantilla HTML ===
        $rutaPlantilla = __DIR__ . "/../view/email/" . $plantilla;
        if (!file_exists($rutaPlantilla)) {
            throw new Exception("❌ La plantilla {$plantilla} no existe en view/email/");
        }

        $html = file_get_contents($rutaPlantilla);

        // Reemplazar variables dinámicas {{nombre}} por sus valores
        foreach ($datos as $clave => $valor) {
            $html = str_replace("{{{$clave}}}", htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'), $html);
        }

        // Cuerpo alternativo de texto plano (para clientes sin HTML)
        $textoPlano  = "Notificación de ClicGo\n\n";
        $textoPlano .= strip_tags(str_replace(["<br>", "<br/>", "<br />"], "\n", $html));
        $textoPlano .= "\n\n-----------------------------------\n";
        $textoPlano .= "Este correo fue generado automáticamente por ClicGo.";

        $mail->Body    = $html;
        $mail->AltBody = $textoPlano;

        $mail->send();
        return true;

    } catch (Exception $e) {
            error_log("Error al enviar correo: " . $e->getMessage());
        return false;
    }
}
?>
