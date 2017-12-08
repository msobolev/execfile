<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Execfile</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="<? //=DIR_JS?>validation.js" language="javascript"></script> -->


<link rel="stylesheet" href="css/home_style.css" />
<link rel="stylesheet" href="css/home_style_tags.css" />
<script src="js/form_functions.js"></script>

</head>
<body class="blue_body">
<div>
<div style="margin:0px auto;width:990px;">    
    <div style="padding-top:0px;margin-top:8px;">
        <a href="execf/public/index.php/homepage" class="logo"></a>
        <!-- <h1 style="padding-left:0px;"><a href="home.php?funtion=hr"><img width="257" height="24" src="css/images/new-logo.png"></a></h1> -->
    </div>

    <div class="content_div" style="margin-top:20px;">

<?PHP


include("config.php");
include("functions.php");
   
//com_db_connect() or die('Unable to connect to database server!');
//echo "<br>Before contact form send";
if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    //echo "<br>Within contact form send";
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
    $mail->Subject       = "Contact us form submitted on Execfile";

    
    
    
    
    
    
    
    
    
    
    $invalid = 0;
    $first_name = $_POST['first_name_rq'];
    
    if (preg_match('~[0-9]+~', $first_name)) 
    {
        $invalid = 1;
    }
    
    
    $last_name = $_POST['last_name_rq'];
    if (preg_match('~[0-9]+~', $last_name)) 
    {
        $invalid = 1;
    }
    
    //echo "<br>Invalid:".$invalid;
    if($invalid == 0)
    {    
        //echo "<br>within valid success";
        $email = $_POST['email_rq'];
        $form_message = $_POST['message'];
        //add_user($first_name,$email,1,$last_name,'Request a demo');
        $msg = "Thank you for contacting us!";

        //$newLine = "\r\n";
        $newLine = "<br><br>";
        $message = "First Name: ".$first_name.$newLine;
        $message .= "Last Name: ".$last_name.$newLine;
        $message .= "Email: ".$email.$newLine;
        $message .= "Message: ".$form_message.$newLine;

        //$to      = 'faraz.aia@nxvt.com';//'msobolev@execfile.com'; //'faraz.aleem@nxb.com.pk';
        //$subject = 'Contact us form submitted on Execfile';
        //$message = 'hello';
        /*
        $headers = 'From: faraz.aia@nxvt.com' . "\r\n" .
            'Reply-To: webmaster@execfile.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        */
        //echo "<br>To: ".$to;
        //echo "<br>subject: ".$subject;
        //echo "<br>message :".$message;
        //echo "<br>To:".$to;

        //mail($to,$subject,$message, $headers);
        
        
        
        
        $emailContent = $message;
        //$email = 'faraz.aia@nxvt.com';
        $email = 'msobolev@execfile.com';
        //$email = 'faraz.aia@nxvt.com';

        $user_first_name = 'faraz';

        $mail->MsgHTML($emailContent);

        $mail->AddAddress($email, $user_first_name);

        if(!$mail->Send()) 
        {
            //echo $str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;
            //$inserError = "insert into ".TABLE_MAILER_ERROR."(str_error,email,alert_id,add_date) values('$str_error','$email','$alert_id','".date("Y-m-d")."')";
            //com_db_query($inserError);

        }
         else {
             //echo "<br><br>Email send";
        }
        $mail->ClearAddresses();
        
        
        
        
        
        
        
        
    }
    //mail($to, $subject, $message, $headers);
    //print_r(error_get_last());
    
}

if(isset($_GET['sf']) && $_GET['sf'] == 1)
{
    $msg = "Thank you for signing up! One of our representative will be in touch with you shortly to get you started.";
}

?>



    <?PHP 
    //if($_POST['request_demo_flag'] == 1)
    if($msg != '')    
    {    
    ?>
    <div class="intro-content" style="width:772px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;margin-left:45px;"><?=$msg?></h1>
    </div>    
    <?PHP
    }
    else
    {    
    ?>
    <div class="intro-content" style="width:400px;margin: 0 auto;">
    <!-- <h3 style="text-align:left;width:100%;padding:0px 0px 15px 0px;margin:0px;">Request A Demo</h3> -->
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Contact Us</h1>

    <div class="form-sing-up">
        <form action="contact-us.php" method="post" onsubmit="return filter_email('email_rq');">
            <div class="form-body">
                <div class="form-row">
                    <label for="field-name" class="form-label hidden">Name </label>

                    <div class="form-controls">
                        <i class="ico-user"></i>
                        <input style="border:1px solid #CCCCCC;" type="text" class="field" name="first_name_rq" id="first_name_rq" value="" placeholder="First Name" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->


                <div class="form-row">
                    <label for="field-name" class="form-label hidden">Name </label>
                    <div class="form-controls">
                        <i class="ico-user"></i>
                        <input style="border:1px solid #CCCCCC;" type="text" class="field" name="last_name_rq" id="last_name_rq" value="" placeholder="Last Name" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->


                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Work Email</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;" type="email" class="field" name="email_rq" id="email_rq" value="" placeholder="Work Email" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                
                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Message</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <textarea style="border:1px solid #CCCCCC;height:145px;" class="field" name="message" id="message" value="" placeholder="Message" required></textarea>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                
                
                
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                <input type="submit" value="Send" class="form-btn"> <!--  onclick="return filter_email();" -->
            </div><!-- /.form-actions -->
        </form>
    </div><!-- /.form-sing-up -->
    </div><!-- /.intro-content -->
    <?PHP
    }
    ?>
    



<?php      
include("blue_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>