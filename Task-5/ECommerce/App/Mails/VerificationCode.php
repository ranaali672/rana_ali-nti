<?php
namespace App\Mails;
use App\Mails\Mail;

class VerificationCode extends Mail {
    public string $mailFromName = 'NTI Ecommerce';
    public function send()
    {
        try {
            //Recipients
            $this->mail->setFrom($this->mailFrom, $this->mailFromName);
            $this->mail->addAddress($this->mailTo);     //Add a recipient
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->Body    =  $this->body;        
            $this->mail->send();
            return true;
            // echo 'Message has been sent';
        } catch (\Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }
}

