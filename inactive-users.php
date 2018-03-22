<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include("config.php");

//include("config.php");
//include("functions.php");
require_once('PHPMailer/class.phpmailer.php');

$from_admin = 'ms@hrexecsonthemove.com';
$mail                = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
$mail->Port          = 80;    // 25 465               // 26 set the SMTP port for the GMAIL server
//$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Username      = EMAIL_ADDRESS; //"misha.sobolev@execfile.com";   //"rts_email_sent@hrexecsonthemove.com"; // SMTP account username
$mail->Password      = EMAIL_PASSWORD; //"ryazan";  //"rts0214";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
$mail->SetFrom('ms@hrexecsonthemove.com', 'hrexecsonthemove.com');
//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo($from_admin, 'hrexecsonthemove.com');
$mail->Subject       = "List of Inactive Users on Execfile";



function subDate($days)
{
    $date = date('Y-m-j');
    $duration='-'.$days.' day';
    $newdate = strtotime ( $duration , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-j' , $newdate );
    return $newdate;
}


$hre = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$hre) or die ("ERROR: Database not found ");

//com_db_connect_hre2() or die('Unable to connect to database server!');


$before_date = subDate('1');

//$before_date = '2015-11-07';

$q = "select first_name,last_name,email,add_date from exec_user where status = 0 and add_date > '".$before_date."'";
echo "<br>Q: ".$q;
//$companyResult = mysql_query("select first_name,last_name,email,add_date from exec_user where status = 0 and add_date > '".$before_date."'");

$companyResult = mysql_query($q,$hre);

$user_rows = mysql_num_rows($companyResult);

//echo "<br>select first_name,last_name,email,res_date from exec_user where status = 0 and res_date > '".$before_date."'";
//echo "<br>Q: $q<br>";
//echo "<br><br>";
$cnt = 0;

if($user_rows > 0)
{    
    $msg = "Below is list of inactive user on Execfile since Yesterday:<br><br>";
    while($companyRow = mysql_fetch_array($companyResult))
    {
        //echo "<br>Within";
        $first_name = $companyRow['first_name'];
        $last_name = $companyRow['last_name'];
        $email = $companyRow['email'];
        $res_date = $companyRow['add_date'];

        $msg .= "<br>Name: ".$first_name." ".$last_name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Email: ".$email."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Registration Date: ".$res_date;

    }
    echo "MSG: ".$msg;

    $emailContent = $msg;
    //$email = 'faraz.aia@nxvt.com';
    $email = 'misha.sobolev@gmail.com';

    $user_first_name = 'faraz';

    $mail->MsgHTML($emailContent);

    $mail->AddAddress($email, $user_first_name);
    $mail->AddCC("faraz.aia@nxvt.com", "");
    if(!$mail->Send()) 
    {
        echo $str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
        //$inserError = "insert into ".TABLE_MAILER_ERROR."(str_error,email,alert_id,add_date) values('$str_error','$email','$alert_id','".date("Y-m-d")."')";
        //com_db_query($inserError);

    }
     else {
         //echo "<br><br>Email send";
    }
    $mail->ClearAddresses();

}

?>