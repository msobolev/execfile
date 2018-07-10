<!-- <link rel="stylesheet" href="../css/home_style.css" /> -->
<link rel="stylesheet" href="../css/admin_style.css" />
<style>
.form-row    
{
    margin-bottom:10px;
}
</style>
<?php
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
 */

require('../functions.php');
require('../config.php');

require('admin_header.php');

//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

$btn_val = "Update Admin Email";
$action = "update";
$user_details = array();

//echo "<pre>GET:";   print_r($_GET);   echo "</pre>";
if(isset($_GET['action']) && $_GET['action'] == 'update')
{
    $email = $_POST['email'];
    //$user_id = $_POST['user_id'];
   
    $msg = "Admin email updated.";
   // $user_details = get_user($user_id);
    //$btn_val = "Update User";
    //$action = "update";
    
    $query = "update exec_admin set admin_email = '" . $email ."'";
    //echo "query:".$query;
    com_db_query($query);
}

$email = com_db_GetValue("select admin_email from exec_admin");
//echo "<br>email:".$email;
?>
<h2 style="padding-left:20px;">Update Email Password</h2>

<?PHP
if($msg != '')
{    
?>
    <h3 style="padding-left:20px;"><?=$msg?></h3>
<?PHP
}
?>

<div style="padding-left:20px;" class="form-sing-up">
    <form action="?action=<?=$action?>" method="post">
        <div class="form-body form-company">
            <div class="form-row">
                <label for="field-name" class="form-label hidden">Admin Email</label>

                <div class="form-controls">
                    <i class="ico-user"></i>    <!-- user for mysqli $user_details->first_name -->
                    <input type="text" class="field" name="email" id="email" value="<?=$email?>" placeholder="Email" size="35">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
        </div><!-- /.form-body -->

        <div class="form-actions">
            <input type="submit" value="Update" class="form-btn"> 
        </div><!-- /.form-actions -->
    </form>
</div><!-- /.form-sing-up -->