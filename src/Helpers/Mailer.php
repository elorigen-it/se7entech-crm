<?php
namespace Se7entech\Contractnew\Helpers;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $attachments = [];

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
        $this->attachments[] = $path;
        $this->mail->addAttachment($path);
    }
    public function send(){
        require __DIR__ . '/../../config/config.php';
        
        $resendApiKey = getenv('RESEND_API_KEY') ?: ($_ENV['RESEND_API_KEY'] ?? ($_SERVER['RESEND_API_KEY'] ?? null));
        if (!empty($resendApiKey)) {
            $resendFromEmail = getenv('RESEND_FROM_EMAIL') ?: ($_ENV['RESEND_FROM_EMAIL'] ?? ($_SERVER['RESEND_FROM_EMAIL'] ?? ''));
            $resendFromName = getenv('RESEND_FROM_NAME') ?: ($_ENV['RESEND_FROM_NAME'] ?? ($_SERVER['RESEND_FROM_NAME'] ?? ''));
            
            $fromEmail = !empty($resendFromEmail) ? $resendFromEmail : $this->from;
            $fromName = !empty($resendFromName) ? $resendFromName : $this->fromName;
            
            $fromField = !empty($fromName) ? "$fromName <$fromEmail>" : $fromEmail;
            
            $toEmails = [];
            if (is_array($this->to)) {
                foreach ($this->to as $address) {
                    if (is_array($address)) {
                        $toEmails[] = $address['email'];
                    } else {
                        $toEmails[] = $address;
                    }
                }
            } else {
                $toEmails[] = $this->to;
            }
            
            $ccEmails = [];
            if (is_array($this->toCC)) {
                foreach ($this->toCC as $address) {
                    if (is_array($address)) {
                        $ccEmails[] = $address['email'];
                    } else {
                        $ccEmails[] = $address;
                    }
                }
            }
            
            $bccEmails = [];
            if (is_array($this->toCCO)) {
                foreach ($this->toCCO as $address) {
                    if (is_array($address)) {
                        $bccEmails[] = $address['email'];
                    } else {
                        $bccEmails[] = $address;
                    }
                }
            }
            
            $resendAttachments = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $path) {
                    if (file_exists($path)) {
                        $resendAttachments[] = [
                            'content' => base64_encode(file_get_contents($path)),
                            'filename' => basename($path),
                        ];
                    }
                }
            }
            
            $payload = [
                'from' => $fromField,
                'to' => $toEmails,
                'subject' => $this->subject,
                'html' => $this->content,
            ];
            
            if (!empty($ccEmails)) {
                $payload['cc'] = $ccEmails;
            }
            if (!empty($bccEmails)) {
                $payload['bcc'] = $bccEmails;
            }
            if (!empty($resendAttachments)) {
                $payload['attachments'] = $resendAttachments;
            }
            
            $ch = curl_init('https://api.resend.com/emails');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $resendApiKey,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            
            // Bypass SSL certificate verification on local/Windows environments to avoid cURL Code 0 errors
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errNo = curl_errno($ch);
            $errStr = curl_error($ch);
            curl_close($ch);
            
            if ($httpCode >= 200 && $httpCode < 300) {
                return true;
            } else {
                $errMsg = "Message could not be sent. Resend API Error: Code {$httpCode}.";
                if ($errNo) {
                    $errMsg .= " cURL Error ({$errNo}): {$errStr}.";
                }
                $errMsg .= " Response: " . $response;
                return $errMsg;
            }
        }

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
