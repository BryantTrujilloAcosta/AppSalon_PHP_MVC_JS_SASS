<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this -> email = $email;
        $this -> nombre = $nombre;
        $this -> token = $token;
    }

    public function enviarConfirmacion(){
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '58d709d5ffbd8c';
        $mail->Password = '7a7737809f22be';

        $mail->setFrom('cuenta@salon.com');
        $mail->addAddress('cuentas@salon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = '<html>';
        $contenido .= '<p><strong>Hola ' . $this->nombre . '</strong></p>';
        $contenido .= '<p>Has creado tu cuenta en AppSalon, solo debes confirmarla presionando el siguiente enlace</p>';
        $contenido .= '<p>Presiona aquí: <a href="http://localhost:3000/confirmar-cuenta?token=' . $this->token . '">Confirmar Cuenta</a></p>';
        $contenido .= '<p>Si no creaste esta cuenta, puedes ignorar este mensaje</p>';
        $contenido .= '</html>';

        $mail->Body = $contenido;
        //enviar el email
        $mail->send();

        
    }
}
?>