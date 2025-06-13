<?php
namespace Se7entech\Contractnew\Helpers;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    public function __construct($from, $fromName, $to, $toName, $subject, $content, $altContent = null, $smtpUser = false, $smtpPass = false, $toCC=false, $toCCO=false){
        $this->mail = new PHPMailer(true);
        $this->mail->CharSet = "UTF-8";
        $this->mail->AddCustomHeader("List-Unsubscribe: <mailto:admin@se7entech.net?subject=Unsubscribe>, <https://crm.se7entech.net/unsubscribe.php>");
        $this->from = $from;
        $this->fromName = $fromName;
        $this->to = $to;
        $this->toCC = $toCC;
        $this->toCCO = $toCCO;
        $this->toName = $toName;
        $this->subject = $subject;
        $this->content = $content;
        $this->altContent = $altContent;
        $this->smtpUser = $smtpUser;
        $this->smtpPass = $smtpPass;
    }

    public function addAttachment($path){
        $this->mail->addAttachment($path);
    }
    public function send(){
        require __DIR__ . '/../../config/config.php';
        try {
            //Server settings
            $this->mail->SMTPDebug = false;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = $smtp_host;         //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = ($this->smtpUser) ? $this->smtpUser : $smtp_default_username;             //SMTP username
            $this->mail->Password   = ($this->smtpPass) ? $this->smtpPass : $smtp_default_password;                         //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $this->mail->WordWrap = 50;

            //Recipients
            $this->mail->setFrom(($this->smtpUser) ? $this->smtpUser : 'no-reply@se7entech.net', 'Se7entech');
            if(is_array($this->to)){
                foreach($this->to as $address){
                    if(is_array($address)){
                        $this->mail->addAddress($address['email'], $address['name']);
                    }else{
                        $this->mail->addAddress($address, $this->toName);     //Add a recipient
                    }
                }
            }else{
                $this->mail->addAddress($this->to, $this->toName);     //Add a recipient
            }
            if(is_array($this->toCC)){
                foreach($this->toCC as $address){
                    if(is_array($address)){
                        $this->mail->AddCC($address['email'], $address['name']);
                    }
                }
            }
            if(is_array($this->toCCO)){
                foreach($this->toCCO as $address){
                    if(is_array($address)){
                        $this->mail->AddBCC ($address['email'], $address['name']);
                    }
                }
            }
            $this->mail->addReplyTo(($this->smtpUser) ? $this->smtpUser : 'webmaster1@se7entech.net', 'Se7entech');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');
        
            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $this->subject;
            $this->mail->Body    = $this->content;
            $this->mail->AltBody = $this->altContent;
        
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
