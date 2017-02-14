<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<?PHP
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
//com_db_connect() or die('Unable to connect to database server!');

if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    $first_name = $_POST['first_name_rq'];
    $last_name = $_POST['last_name_rq'];
    $email = $_POST['email_rq'];
    $form_message = $_POST['message'];
    //add_user($first_name,$email,1,$last_name,'Request a demo');
    $msg = "Thank you for contacting us!";
    
    $newLine = "\r\n";
    $message = "First Name: ".$first_name.$newLine;
    $message .= "Last Name: ".$last_name.$newLine;
    $message .= "Email: ".$email.$newLine;
    $message .= "Message: ".$form_message.$newLine;
    
    $to      = 'msobolev@execfile.com'; //'faraz.aleem@nxb.com.pk';
    $subject = 'Contact us form submitted on Execfile';
    //$message = 'hello';
    $headers = 'From: faraz.aia@nxvt.com' . "\r\n" .
        'Reply-To: webmaster@execfile.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    //echo "<br>To: ".$to;
    //echo "<br>subject: ".$subject;
    //echo "<br>message :".$message;
    //echo "<br>To:".$to;
    
    mail($to,$subject,$message, $headers);
    
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
        <form action="contact.php" method="post" onsubmit="return filter_email('email_rq');">
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