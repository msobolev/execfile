<?php
function send_email_smtp($from,$to, $subject, $mailBody)
{
    require_once('PHPMailer/class.phpmailer.php');
    $mail                = new PHPMailer();
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth      = true;                  // enable SMTP authentication
    $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent


    $mail->Host          = "smtpout.secureserver.net";
    $mail->Port          = 25; 
    $mail->Username      = "misha.sobolev@execfile.com";//"misha.sobolev@execfile.com";
    $mail->Password      = "borabora2190";//"ryazan";
    
    $mail->AddReplyTo($from, 'Execfile.com');
    //$mail->SetFrom('msobolev@execfile.com', 'Execfile.com');
    $mail->SetFrom($from, 'Execfile.com');
    $mail->Subject       = $subject;
    
    
    $body = $mailBody;
    $email = $to;
    $user_first_name = "";
    
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $user_first_name);
    
    $mail->Send();        
    
}

function sendEmail($from,$to,$subject,$msg)
{
    $headers = "From: $from" . "\r\n";
    


    // send email
    $success = mail($to,$subject,$msg,$headers);
    
    
    if (!$success) {
        $errorMessage = error_get_last()['message'];
    }
    else
        echo "<br>Mail send";
}



function send_email($to, $subject, $message, $from)
{

    $headers  = 'MIME-Version: 1.0' . "\r\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    $headers .= 'From: ' . $from . "\r\n";

    return mail($to, $subject, $message, $headers);

}



?>

