<?php

require_once('PHPMailer/class.phpmailer.php');
$mail                = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtp.gmail.com"; //"smtpout.secureserver.net"; //"smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
$mail->Port          = "587";//25;//80;    // 25 465               // 26 set the SMTP port for the GMAIL server
//$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Username      = "ms@hrexecsonthemove.com"; //"msobolev@execfile.com"; //misha.sobolev@execfile.com"; //rts_email_sent@hrexecsonthemove.com"; // SMTP account username
$mail->Password      = "borabora2190";   // "ryazan"; //"rts0214";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');

//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo("msobolev@execfile.com", 'Execfile.com');
$mail->Subject       = "are these your potential clients?";

$mail->SMTPDebug      = 2;
$mail->SMTPSecure = 'tls'; 

$emailContent = "Test message";
$emailDetails = "Email details";


$mail->MsgHTML($emailContent);
$mail->AddAddress("test-knrkg@mail-tester.com", "Faraz");
$emailContent =$emailContent;
$emailDetails =$emailDetails;
$mail->Subject       = "potential clients?";
$mail->Send();





?>