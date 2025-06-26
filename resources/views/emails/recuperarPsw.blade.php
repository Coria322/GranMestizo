<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #eee5da; color: #333; padding: 2rem; margin: 0;">
    <div style="background-color: white; border-radius: 10px; box-shadow: 0 0 10px #ccc; padding: 2rem; max-width: 600px; margin: auto;">
        
        <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ $message->embed(public_path('imgs/Logomex.png')) }}" alt="El Gran Mestizo" style="height: 80px;">
        </div>

        <h2 style="font-size: 20px; color: #262424; margin-top: 0;">Recuperación de Contraseña</h2>

        <p style="font-size: 16px;">Recibimos una solicitud para restablecer tu contraseña. Si no fuiste tú, puedes ignorar este correo.</p>
        <p style="font-size: 16px;">Haz clic en el botón para cambiarla:</p>

        <div style="text-align: center;">
            <a href="{{ $link }}" 
               style="display: inline-block; margin: 20px auto 0 auto; padding: 12px 28px; background-color: #a24e3d; color: white; text-decoration: none; border-radius: 10px; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 18px; font-weight: bold; box-shadow: 0 4px 4px rgba(0,0,0,0.25); letter-spacing: 0.5px;">
                Cambiar contraseña
            </a>
        </div>

        <p style="margin-top: 30px; font-size: 14px; color: #777;">Este enlace expirará en 60 minutos.</p>

        <p style="font-size: 12px; color: #aaa; text-align: center; margin-top: 40px;">
            © {{ date('Y') }} El Gran Mestizo · Todos los derechos reservados
        </p>
    </div>
</body>
</html>
