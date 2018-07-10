<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<?PHP
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
com_db_connect_hre2() or die('Unable to connect to database server!');
$admin_email = com_db_GetValue("select admin_email from exec_admin");
if(isset($_POST['forgot_pw']) && $_POST['forgot_pw'] == 1)
{
    $email = $_POST['email'];
    
    
    $check_user = "select * from " .TABLE_USER." where email = '".$email."'";
    //echo "<br>check_user: ".$check_user;
    $check_user_rs = com_db_query($check_user);
    $check_user_rows = com_db_num_rows($check_user_rs);
    //echo "<br>check_user_rows: ".$check_user_rows;
    //die();
    if($check_user_rows == 0)
    {
        //header("Location: forgot_password.php");
        $msg = "The email address you entered could not be found in our records, 
            please <a href=forgot_password.php>try again</a>. <a href=request-demo.html>New User?</a>";
    }    
    else
    {    
        
        require_once('PHPMailer/class.phpmailer.php');

        $from_admin = 'ms@hrexecsonthemove.com';
        $mail                = new PHPMailer();
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth      = true;                  // enable SMTP authentication
        $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
        $mail->Host          = "smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
        $mail->Port          = 80;    // 25 465               // 26 set the SMTP port for the GMAIL server
        //$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
        $mail->Username      = "msobolev@execfile.com";   //"rts_email_sent@hrexecsonthemove.com"; // SMTP account username
        $mail->Password      = "ryazan";  //"rts0214";        // SMTP account password
        //$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
        $mail->SetFrom('ms@hrexecsonthemove.com', 'hrexecsonthemove.com');
        //$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
        $mail->AddReplyTo($from_admin, 'hrexecsonthemove.com');
        $mail->Subject       = "Forgot Password";
        
        
        
        $user_row = com_db_fetch_array($check_user_rs);
        $user_name = $user_row['first_name']." ".$user_row['last_name'];
        
        
        $reset_link = '';
        $random_hash = '';
        //$random_hash = rand(100000000000,999999999999);
        $random_hash = rand(100000,999999);
        $fp_update_db = "INSERT into exec_user_forgot_password(user_email,unique_hash) values('$email','$random_hash')";

        //echo "<br>fp_update_db:".$fp_update_db;

        $fp_update_result = com_db_query($fp_update_db);

        $reset_link = '/reset_password.php?upc='.$random_hash;
        //$message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;';
        $message = '<table width="70%" cellspacing="0" cellpadding="3" >
            <tr>
                <td align="left"><b>Dear '.$user_name.',</b></td>
            </tr>
            <tr>
                <td align="left">Below is the link to reset your password.</td>
            </tr>

            <tr>
                <td align="left"><a href=https://www.execfile.com'.$reset_link.'>Reset Password</a></td>
            </tr>';

        $message .=	'</table>';
        
        
        
        //@send_email($to, $subject, $message, $from_admin); 
    $user_first_name = "";
    $emailContent = $message;
    $mail->MsgHTML($emailContent);

    $mail->AddAddress($email, $user_first_name);

    $mail->Send();
    
    $msg = "Please check your inbox, you should receive password reset email shortly.";    
        
        /*    
        $msg = "Thank you! One of our representatives will be in touch with you shortly.";

        $email_message = "Below are details of request a demo user:";
        $email_message .= "\r\nFirst Name: ".$first_name; 
        $email_message .= "\r\nLast Name: ".$last_name; 
        $email_message .= "\r\nEmail: ".$email; 

        $headers = 'From: info@execfile.com' . "\r\n" .
        'Reply-To: info@execfile.com' . "\r\n" ;

        // Send
        mail($admin_email, 'Request A Demo User', $email_message,$headers);
        //mail('faraz.aia@nxvt.com', 'Request A Demo User', $email_message,$headers);
        
        $todays = date('Y-m-d');
        $add_query = "INSERT into exec_forms(form_data,form_date,form_type) values('".$email_message."','".$todays."','request_demo')";
        //echo "query:".$query;
        com_db_query($add_query);
        */   

    }
    
}
    


if(isset($_GET['sf']) && $_GET['sf'] == 1)
{
    $msg = "Please check your inbox, you should receive password reset email shortly.";
}

?>



    <?PHP 
    //if($_POST['request_demo_flag'] == 1)
    if($msg != '')    
    {    
    ?>
    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }
    else
    {    
    ?>
    <div class="intro-content" style="width:400px;margin: 0 auto;">
    <!-- <h3 style="text-align:left;width:100%;padding:0px 0px 15px 0px;margin:0px;">Request A Demo</h3> -->
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Forgot Password</h1>

    <div class="form-sing-up">
        <form action="forgot_password.php" method="post" onsubmit="return filter_email('email');">
            <div class="form-body">
                <div class="form-row">
                    <label for="field-name" class="form-label hidden">Name </label>

                    <!--
                    <div class="form-controls">
                        Type in your email address, associated with your profile
                    </div>
                    -->
                    <div class="form-controls">
                        <i class="ico-user"></i>
                        <input style="border:1px solid #CCCCCC;" type="text" class="field" name="email" id="email" value="" placeholder="Type in your email address" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="forgot_pw" name="forgot_pw" value="1">
                <input type="submit" value="Send" class="form-btn"> <!--  onclick="return filter_email();" -->
            </div><!-- /.form-actions -->
        </form>
    </div><!-- /.form-sing-up -->
    </div><!-- /.intro-content -->
    <?PHP
    }

include("blue_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>