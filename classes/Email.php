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
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Port = 2525;
            $mail->Username = 'd5a8935c585bc4';
            $mail->Password = '6c35b810746349';

            $mail->setFrom('cuenta@appsalon.com');
            $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
            $mail->Subject = 'Confirma tu cuenta';

            //Set HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $contenido = "<html>";
            $contenido .= "<p>Hola <Strong>" .$this->nombre. "</strong> Has creado tu cuenta en App Salon, solo debes confirmarla presianando el siguiente enlace</p>";
            $contenido .= "<p>Presiona aquí: <a href='http://localhost:3000/confirmar?token=". $this->token. "'>Confirmar Cuenta</a> </p>";
            $contenido .= "<p>Ignotar el mensaje si no solicitaste este mensaje.</p>";
            $contenido .= "</html>";

            $mail->Body = $contenido;

            //Enviar el mail
            $mail->send();
        }
    }
?>