<?php

namespace Home\CmsMini\Service;

use Exception;
use Home\CmsMini\App;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mailer
{
    private PHPMailer $mail;

    public function compose(): self
    {
        $this->mail = new PHPMailer(true);
        $this->mail->Host       = App::config()->mail->host;
        $this->mail->Port       = App::config()->mail->port;
        $this->mail->Username   = App::config()->mail->username;
        $this->mail->Password   = App::config()->mail->password;
        $this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        $this->mail->SMTPAuth   = true;
        $this->mail->SMTPSecure = 'tls';
        $this->mail->CharSet    = "utf-8";
        $this->mail->SMTPDebug  = 0;
        $this->mail->isSMTP();
        
        $this->setFrom(
            App::config()->mail->from->email,
            App::config()->mail->from->name,
        );

        return $this;
    }

    public function setFrom(string $email, string $name): self
    {
        $this->mail->setFrom($email, $name);

        return $this;
    }

    public function setTo(string $email, string $name): self
    {
        $this->mail->addAddress($email, $name);

        return $this;
    }

    public function setSubject(string $subject): self
    {
        $this->mail->Subject = $subject;

        return $this;
    }

    public function setTextBody(string $message): self
    {
        $this->mail->isHTML(false);
        $this->mail->Body = $message;

        return $this;
    }

    public function setHtmlBody(string $tempalate, array $data = []): self
    {
        $tempalate = MAIL . "/{$tempalate}.php";
        
        if (!file_exists($tempalate)) {
            throw new Exception("Template not exists: $tempalate");
        }

        extract($data);

        ob_start();
        include $tempalate;
        $this->mail->Body = ob_get_clean();
        $this->mail->isHTML(true);

        return $this;
    }

    public function send(): void
    {
        $this->mail->send();
    }
}