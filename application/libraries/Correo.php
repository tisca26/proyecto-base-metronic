<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Correo
{
    protected $CI;
    private $usr_mail;
    private $usr_pass;
    private $host;
    private $port;
    private $secure;
    private $debug;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->usr_mail = "ventas@okan.capital";
        $this->usr_pass = "Ventas123!";
        $this->host = "mail.okan.capital";
        $this->port = "25";
        $this->secure = "";
        $this->debug = "0";
    }

    public function enviar_correo_json($receptor = '',$asunto = '', $mensaje = '')
    {
        session_cache_limiter('nocache');
        header('Expires: ' . gmdate('r', 0));

        header('Content-type: application/json');
        require_once('phpmailer/PHPMailerAutoload.php');

        $mail = new PHPMailer();
        try {

            $mail->SMTPDebug = $this->debug;                                 // Debug Mode
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            $mail->IsSMTP();                                         // Set mailer to use SMTP
            $mail->Host = $this->host;                       // Specify main and backup server
            $mail->SMTPAuth = true;                                  // Enable SMTP authentication
            $mail->Username = $this->usr_mail;                    // SMTP username
            $mail->Password = $this->usr_pass;                              // SMTP password
            $mail->SMTPSecure = $this->secure;                               // Enable encryption, 'ssl' also accepted
            $mail->Port = $this->port;                                       // TCP port to connect to

            $mail->AddAddress($receptor);                                   // Add another recipient

            $mail->SetFrom($this->usr_mail, EMPRESA_NOMBRE . ' Email');
            $mail->AddReplyTo($this->usr_mail, EMPRESA_NOMBRE . ' Email');

            $mail->IsHTML(true);                                  // Set email format to HTML

            $mail->CharSet = 'UTF-8';

            $mail->Subject = $asunto;
            $mail->Body = $mensaje;

            $mail->Send();
            $arrResult = array('response' => 'success');

        } catch (phpmailerException $e) {
            $arrResult = array('response' => 'error', 'errorMessage' => $e->errorMessage());
        } catch (Exception $e) {
            $arrResult = array('response' => 'error', 'errorMessage' => $e->getMessage());
        }

        if ($this->debug == 0) {
            echo json_encode($arrResult);
        }
    }
}