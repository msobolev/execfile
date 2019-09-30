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
recordTraffic('request_demo');

$admin_email = com_db_GetValue("select admin_email from exec_admin");
if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    $first_name = $_POST['first_name_rq'];
    $last_name = $_POST['last_name_rq'];
    $email = $_POST['email_rq'];
    
    if(strpos($email,'@') > -1)
    {
        $check_user = "select * from " .TABLE_USER." where email = '".$email."'";
        //echo "<br>check_user: ".$check_user;
        $check_user_rs = com_db_query($check_user);
        $check_user_rows = com_db_num_rows($check_user_rs);
        //echo "<br>check_user_rows: ".$check_user_rows;
        //die();
        if($check_user_rows > 0)
        {
            header("Location: request_demo.php?sf=2");
        }    
        else
        {    
            $nameValidation = nameValidation($first_name);
            

            if($nameValidation == 0)
            {
                $msg = add_user($first_name,$email,1,$last_name,'Request a demo');
            }
            else
            {
                $msg = "Name is invalid.";
            }    
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
}

if(isset($_GET['sf']) && $_GET['sf'] == 1)
{
    $msg = "Thank you for signing up! One of our representatives will be in touch with you shortly to get you started.";
}
elseif(isset($_GET['sf']) && $_GET['sf'] == 2)
{
    $msg = "User with this email address already exists.";
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
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Request A Demo</h1>

    <div class="form-sing-up">
        <form action="request-demo.html" method="post" onsubmit="return filter_email('email_rq');">
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
                        <input style="border:1px solid #CCCCCC;" type="email" class="field" name="email_rq" id="email_rq" value="" placeholder="Work Email">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                <input type="submit" value="Request A Demo" class="form-btn"> <!--  onclick="return filter_email();" -->
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