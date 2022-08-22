<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token) {
        
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion() {

        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '99e5aa93d6898c';
        $mail->Password = '0059e4c919342c';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML 
        $mail->isHTML(true);
        $mail->CharSet = 'utf-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . "</strong> Has creado tu cuenta en AppSalon, confirma tu cuenta presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href= 'http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        // Enviar el Email
        $mail->send();
    }

    public function enviarIntrucciones() {
        // Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '99e5aa93d6898c';
        $mail->Password = '0059e4c919342c';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece tu contraseña';

        // Set HTML 
        $mail->isHTML(true);
        $mail->CharSet = 'utf-8';
        
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu contraseña, sigue el siguiente enlace para hacerlo.</p>";
        $contenido .= "<p>Presiona aqui: <a href= 'http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        // Enviar el Email
        $mail->send();
    }
}

?>
