<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<?PHP
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
com_db_connect() or die('Unable to connect to database server!');

//echo "<pre>_SESSION: ";   print_r($_SESSION);   echo "</pre>";   

if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    $this_user = $_SESSION['sess_user_id'];
    $email = $_POST['email_rq'];
    $password = $_POST['password'];
    
    
    $user_query = "select * from " . TABLE_USER ." where email = '".$email."' and user_id = ".$this_user;
    //echo "<br>user_query: ".$user_query; 
    $user_result = com_db_query($user_query);
    if($user_result)
    {
        $row_count = com_db_num_rows($user_result);
        if($row_count > 0)
        {
            com_db_query("UPDATE ".TABLE_USER." set password='".$password."' where email ='".$email."' and user_id = ".$this_user);	
            $msg = "You successfully changed your password.";            
        }
        else
        {
            $msg = "No user exists with this email address.";            
        }    
    }
    else
    {
        $msg = "No user exists with this email address.";            
    }    
    //add_user($first_name,$email,1,$last_name,'Request a demo');
    //$msg = "You successfully changed your password.";
}

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
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Accounts</h1>

    <div class="form-sing-up">
        <form action="accounts.php" method="post" onsubmit="return filter_email('email_rq');">
            <div class="form-body">

                


                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Work Email</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;" type="email" class="field" name="email_rq" id="email_rq" value="" placeholder="Work Email">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                
                
                <div class="form-row">
                    <label for="field-name" class="form-label hidden">Password </label>
                    <div class="form-controls">
                        <i class="ico-user"></i>
                        <input style="border:1px solid #CCCCCC;" type="password" class="field" name="password" id="password" value="" placeholder="Password" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
                
                
                
                
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                <input type="submit" value="Change Password" class="form-btn"> <!--  onclick="return filter_email();" -->
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