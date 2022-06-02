<?php

namespace App\Mails;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    protected string $mailTo;
    protected string $subject;
    protected string $body;
    protected  PHPMailer $mail;
    protected string $mailFrom = 'NTImay2022@gmail.com';
    private string $password = '01004411210';
    private string $host = 'smtp.gmail.com';

    public function __construct(string $mailTo, string $subject, string $body)
    {
        $this->mailTo = $mailTo;
        $this->subject = $subject;
        $this->body = $body;
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = $this->host;                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = $this->mailFrom;                     //SMTP username
        $this->mail->Password   = $this->password;                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }
}
