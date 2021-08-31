<?php

namespace Home\CmsMini\Service;

use Home\CmsMini\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    protected PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->Host       = App::$config->mail->host;
        $this->mail->Port       = App::$config->mail->port;
        $this->mail->Username   = App::$config->mail->username;
        $this->mail->Password   = App::$config->mail->password;
        $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        $this->mail->SMTPAuth   = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->CharSet    = "utf-8";
        $this->mail->SMTPDebug  = 0;
        $this->mail->isSMTP();
        $this->mail->setFrom(
            App::$config->mail->from->email,
            App::$config->mail->from->name
        );
    }

    public function setAddress(string $email, string $name): void
    {
        $this->mail->addAddress($email, $name);
    }

    public function setSubject(string $subject): void
    {
        $this->mail->Subject = $subject;
    }

    public function setText(string $message): void
    {
        $this->mail->isHTML(false);
        $this->mail->Body = $message;
    }

    public function setHtml(string $tempalate, array $data = []): void
    {
        extract($data);
        $tempalate = MAIL . "/{$tempalate}.php";
        ob_start();
        include $tempalate;
        $this->mail->Body = ob_get_clean();
        $this->mail->isHTML(true);
    }

    public function send(): void
    {
        $this->mail->send();
    }
}