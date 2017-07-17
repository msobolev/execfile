<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
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
$mail->Username      = "misha.sobolev@execfile.com";   //"rts_email_sent@hrexecsonthemove.com"; // SMTP account username
$mail->Password      = "ryazan";  //"rts0214";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
$mail->SetFrom('ms@hrexecsonthemove.com', 'hrexecsonthemove.com');
//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo($from_admin, 'hrexecsonthemove.com');
$mail->Subject       = "CISO Active Users activity details";



function subDate($days)
{
    $date = date('Y-m-j');
    $duration='-'.$days.' day';
    $newdate = strtotime ( $duration , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-j' , $newdate );
    return $newdate;
}


$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

//com_db_connect_hre2() or die('Unable to connect to database server!');


$before_date = subDate('1');

//$before_date = '2015-11-07';

$q = "select * from exec_user $where_clause where (site = 'ciso') and status = 1 order by user_id desc";
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
    $msg = "Below is CISO active user activity details on Execfile:<br><br>";
    
    $msg .= "<table>";
    $msg .= "<tr><th width=200>Name</th><th width=200>Email</th><th width=150>Total Alerts Today</th><th width=150>Total Alert Start</th><th width=150>Total Login</th><th width=150>Total Download</th><th width=150>Total Searches</th></tr>";
    
    while($companyRow = mysql_fetch_array($companyResult))
    {
        $first_name = $companyRow['first_name'];
        $last_name = $companyRow['last_name'];
        $email = $companyRow['email'];
        //$tot_alert = com_db_GetValue("select count(alert_id) as cnt from hre_alert where user_id='".$companyRow['user_id']."'");
        
        //echo "<br>Q: select count(alert_id) as cnt from hre_alert where user_id='".$companyRow['user_id']."'";
        

        /*
        $tot_alert_set = mysql_query("select count(alert_id) as alert_cnt from exec_alert where user_id='".$companyRow['user_id']."'",$hre);
        $alert_set_data = mysql_fetch_assoc($tot_alert_set);
        $alert_set_count = $alert_set_data['alert_cnt'];
        */
        
        
        $tot_alert = mysql_query("select count(alert_id) as cnt from hre_alert_send_info where user_id='".$companyRow['user_id']."'",$hre);
        $alert_data = mysql_fetch_assoc($tot_alert);
        $alert_count = $alert_data['cnt'];
        
        echo "<br>Today Q: select count(alert_id) as cnt from hre_alert_send_info where user_id='".$companyRow['user_id']."' and DATE(FROM_UNIXTIME(sent_date)) = CURDATE()";
        $tot_alert_today = mysql_query("select count(alert_id) as cnt from hre_alert_send_info where user_id='".$companyRow['user_id']."' and DATE(FROM_UNIXTIME(sent_date)) = CURDATE()",$hre);
        $alert_data_today = mysql_fetch_assoc($tot_alert_today);
        $alert_count_today = $alert_data_today['cnt'];
        
        
        
        
        //com_db_GetValue("select count(user_id) from " . TABLE_LOGIN_HISTORY . " where user_id='".$data_sql['user_id']."'");
        $tot_login = mysql_query("select count(user_id) as login_cnt from hre_login_history where user_id='".$companyRow['user_id']."'",$hre);
        $login_data = mysql_fetch_assoc($tot_login);
        $login_count = $login_data['login_cnt'];
        
        
        $tot_dl = mysql_query("select count(user_id) as dl_cnt from hre_download where user_id='".$companyRow['user_id']."'",$hre);
        $dl_data = mysql_fetch_assoc($tot_dl);
        $dl_count = $dl_data['dl_cnt'];
        
        
        $tot_search = mysql_query("select count(user_id) as search_cnt from hre_search_history where user_id='".$companyRow['user_id']."'",$hre);
        $search_data = mysql_fetch_assoc($tot_search);
        $search_count = $search_data['search_cnt'];
        
        
        $msg .= "<tr><td>".$first_name." ".$last_name."</td><td>".$email."</td><td align=center>".$alert_count_today."</td><td align=center>".$alert_count."</td><td align=center>".$login_count."</td><td align=center>".$dl_count."</td><td align=center>".$search_count."</td></tr>";

    }
    
    $msg .= "</table>";
    
    echo "MSG: ".$msg;
//die();
    $emailContent = $msg;
    //$email = 'faraz.aia@nxvt.com';
    $email = 'misha.sobolev@gmail.com';

    $user_first_name = 'faraz';

    $mail->MsgHTML($emailContent);

    $mail->AddAddress($email, $user_first_name);

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