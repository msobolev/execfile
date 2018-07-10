<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<script language="javascript">
function check_pw()
{
    var new_password = document.getElementById('new_password').value;
    var re_password = document.getElementById('re_password').value;
    if(new_password != re_password)
    {
        document.getElementById('new_password').focus();
        alert("The password you typed in should match. Please try again.");
        return false;
    }    
}
</script>    
<?PHP
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
com_db_connect_hre2() or die('Unable to connect to database server!');
$admin_email = com_db_GetValue("select admin_email from exec_admin");



//echo "<pre>GET:";   print_r($_GET);   echo "</pre>";

if(isset($_POST['ChangePassword']) && $_POST['ChangePassword'] == 1)
{
    
    $new_password = $_POST['new_password'];
    $re_password = $_POST['re_password'];
    
    if($new_password == $re_password)
    {    
    
        $user_id = $_POST['user_id'];
        //$user_update = "UPDATE " . TABLE_USER . "  set password = '$pass'  where user_id = '".$uID."'";
        //$user_update = "UPDATE " . TABLE_USER . "  set password = md5('$pass')  where user_id = '".$uID."'";
        $user_update = "UPDATE " . TABLE_USER . "  set password = '$new_password'  where user_id = '".$user_id."'";
        
        //echo "<br>user_update:".$user_update;
        
        com_db_query($user_update);


        $reset_update = "UPDATE exec_user_forgot_password set password_updated = 1  where user_email = '".$_POST['user_email']."'";
        com_db_query($reset_update);

        //$url = "my-change-password.php?msg=Your password successfully change";
        $url = "https://www.execfile.com/login.php";
        com_redirect($url);
    }    
}


if(isset($_GET['upc']) && $_GET['upc'] != '')
{
    $forgot_pw_result = com_db_query("select * from exec_user_forgot_password where unique_hash ='".$_GET['upc']."'");
    $forgot_pw_row = com_db_fetch_array($forgot_pw_result);
    
    $user_email = $forgot_pw_row['user_email'];
    
    if($forgot_pw_row['password_updated'] == 1)
    {
        $msg = "Password Reset link expired.";
    }    
    else
    {    
        $user_result = com_db_query("select * from ".TABLE_USER." where email ='".$user_email."'");
        $user_row = com_db_fetch_array($user_result);
    
        $password_updated = $forgot_pw_row['password_updated'];
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
    <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Reset Password</h1>

    <div class="form-sing-up">
        <form action="reset_password.php" method="post" onsubmit="return check_pw();">
            <input type="hidden" name="user_id" id="user_id" value="<?=$user_row['user_id']?>">
            <input type="hidden" name="user_email" id="user_email" value="<?=$user_row['email']?>">
            <div class="form-body">
                
                <!--
                <div class="form-row">
                    <label for="field-name" class="form-label hidden">Name </label>

                    <div sty class="form-controls">
                        <i class="ico-user"></i>
                        <?=$user_row['first_name']?>" "<?=$user_row['last_name']?>
                    </div>
                </div>
                -->

                <div class="form-row">
                    <label for="field-name" class="form-label hidden">New Password </label>
                    <div class="form-controls">
                        <i class="ico-user"></i>
                        <input style="border:1px solid #CCCCCC;" type="password" class="field" name="new_password" id="new_password" value="" placeholder="New Password" required>
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->


                <div class="form-row">
                    <label for="field-email" class="form-label hidden">Work Email</label>

                    <div class="form-controls">
                        <i class="ico-mail"></i>
                        <input style="border:1px solid #CCCCCC;" type="password" class="field" name="re_password" id="re_password" value="" placeholder="Re-type Password">
                    </div><!-- /.form-controls -->
                </div><!-- /.form-row -->
            </div><!-- /.form-body -->

            <div class="form-actions">
                <input type="hidden" id="ChangePassword" name="ChangePassword" value="1">
                <input type="submit" value="Save" class="form-btn"> <!--  onclick="return filter_email();" -->
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