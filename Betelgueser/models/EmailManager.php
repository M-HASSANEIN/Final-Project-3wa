<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



class EmailManager
{
    protected $mail;
    
    public function __construct($email,$subject,$body)
    {
        
     
        //Instantiation and passing `true` enables exceptions
        $this->mail = new PHPMailer(true);
            
        try {
            //Server settings
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = 'betelgueser.hurgada@gmail.com';                     //SMTP username
            $this->mail->Password   = 'Bet@2020';                               //SMTP password
            $this->mail->SMTPSecure = "TLS";         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $this->mail->setFrom('betelgueser.hurgada@gmail.com', 'BETELGUESER');
            $this->mail->addAddress($email);     //Add a recipient
            /*$this->mail->addAddress('ellen@example.com');       */         //Name is optional
            $this->mail->addReplyTo('betelgueser.hurgada@gmail.com', 'Information');
            /* $this->mail->addCC('cc@example.com');
            $this->mail->addBCC('bcc@example.com'); */
        
            //Attachments
            /*$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $this->mail->send();
            $error ='Message has been sent';
        } catch (Exception $e) {
            $error= "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
       
       
    }
}    