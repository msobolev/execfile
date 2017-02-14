<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<?PHP
if(!isset($_SESSION['sess_username']))
{
    header('Location: http://execfile.com/index.php#joind_100s');
}
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

//echo "<pre>_SESSION: ";   print_r($_SESSION);   echo "</pre>";   
$this_user = $_SESSION['sess_user_id'];
if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    
    $subscription = $_POST['subscription'];
    
    com_db_query("UPDATE ".TABLE_USER." set level='".$subscription."' where user_id = ".$this_user);	
    $msg = "You successfully changed your subscription.";  
    
    
    /*
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
    */
}


$user_query = "select level from " . TABLE_USER ." where user_id = ".$this_user;
    //echo "<br>user_query: ".$user_query; 
$user_result = com_db_query($user_query);
$user_row = com_db_fetch_array($user_result);
$level = $user_row['level'];


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
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Subscription</h1>

    <div class="form-sing-up">
        <form action="settings.php" method="post">
            <div class="form-body">


                <div style="color:white;" class="form-row">
                    <label for="field-email" class="form-label hidden">Work Email</label>

                    <input <?PHP if($level == 'basic') echo "checked";?> type="radio" name="subscription" value="basic"> Basic<br>
                    <input <?PHP if($level == 'standard') echo "checked";?> type="radio" name="subscription" value="standard"> Standard<br>
                    <input <?PHP if($level == 'professional') echo "checked";?> type="radio" name="subscription" value="professional"> Professional
                    
                </div><!-- /.form-row -->
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                <input type="submit" value="Upgrade" class="form-btn"> <!--  onclick="return filter_email();" -->
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