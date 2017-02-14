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

if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    $email = $_POST['email_rq'];
    add_user($first_name,$email,1,$last_name,'User Requested for Real Time Update');
    $msg = "Thank you! We've added your email to our distribution list for the HR execs updates. One of our representatives will get in touch with your shortly to explore which option will fit your needs best.";
    
    $email_message = "Below are details of user who requested for real time updates:";
    $email_message .= "\r\nEmail: ".$email; 
    
    $headers = 'From: info@execfile.com' . "\r\n" .
    'Reply-To: info@execfile.com' . "\r\n" ;
    
    // Send
    // misha.sobolev@execfile.com
    mail('misha.sobolev@execfile.com', 'Real Time Updates User', $email_message,$headers);
}
    //if($_POST['request_demo_flag'] == 1)
    if($msg != '')    
    {    
    ?>
    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:44px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }
    else
    {    
    ?>
    <div class="intro-content" style="width:600px;margin: 0 auto;"> <!-- 400px ->
    <!-- <h3 style="text-align:left;width:100%;padding:0px 0px 15px 0px;margin:0px;">Request A Demo</h3> -->
    <h1 style="width:592px;margin-bottom: 15px;font-size:33px;text-align:center;"><br>Want to receive real time updates when HR execs get appointments, speak at events, receive industry awards or get mentioned in press?<br><br> Type in your work email below:</h1>

    <div class="form-sing-up" style="margin-left:113px;">
        <form action="real_time_updates_HR.php" method="post" onsubmit="return filter_email('email_rq');">
            <div class="form-body">

                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Work Email</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;width:75%;" type="email" class="field" name="email_rq" id="email_rq" value="" placeholder="Work Email">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                <input style="width:75%;" type="submit" value="Get Real Time Updates" class="form-btn"> <!--  onclick="return filter_email();" -->
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