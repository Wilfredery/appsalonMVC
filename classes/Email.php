<?php

    namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

    class Email {

        public $nombre;
        public $email;
        public $token;

        public function __construct($nombre, $email, $token) {
            $this->email = $email;
            $this->nombre = $nombre;
            $this->token = $token;
        }

        public function confirmarToken() {
            //Crear el objeto de email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];

            $mail->setFrom('cuenta@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            //Set HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p>Hola <Strong>" .$this->nombre. "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presianando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='".$_ENV['PROJECT_URL']."/confirmar?token=". $this->token. "'>Confirmar Cuenta</a> </p>";
            $contenido .= "<p>Ignotar el mensaje si no solicitaste este mensaje.</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
        }

        public function enviarInst() {
            //Crear el objeto de email
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
            
            $mail->setFrom('cuenta@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Restablecer el password';
            
            //Set HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            
            $contenido = "<html>";
            $contenido .= "<p>Hola <Strong>" .$this->nombre. "</strong> Haz solicitado restablecer tu password. Darle click al siguiente enlace.</p>";
            $contenido .= "<p>Presiona aquí: <a href='".$_ENV['PROJECT_URL']."/recuperar?token=". $this->token. "'>Reestablecer cuenta.</a> </p>";
            $contenido .= "<p>Ignotar el mensaje si no solicitaste este mensaje.</p>";
            $contenido .= "</html>";
            
            $mail->Body = $contenido;
            
            //Enviar el mail
            $mail->send();
        }
    }
?>