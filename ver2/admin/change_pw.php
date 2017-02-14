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
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../functions.php');
require('../config.php');

require('admin_header.php');

com_db_connect() or die('Unable to connect to database server!');

$btn_val = "Add User";
$action = "update";
$user_details = array();

//if((isset($_POST['field-name']) && $_POST['field-name'] != '') && (isset($_POST['field-email']) && $_POST['field-email'] != ''))

 

if(isset($_GET['action']) && $_GET['action'] == 'update')
{
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['field-email'];
    $password = $_POST['password'];
    
    //$user_id = $_POST['user_id'];
    update_admin($first_name,$last_name,$email,$password);
    $msg = "Admin details updated.";
   // $user_details = get_user($user_id);
    //$btn_val = "Update User";
    //$action = "update";
}
$user_details = get_admin();
?>
<h2>Change Password</h2>

<?PHP
if($msg != '')
{    
?>
    <h3><?=$msg?></h3>
<?PHP
}
?>

<div class="form-sing-up">
    <form action="?action=<?=$action?>" method="post" onsubmit="return filter_email('field-email-1');">
        <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>">
        <div class="form-body form-company">
            <div class="form-row">
                <label for="field-name" class="form-label hidden">First Name </label>

                <div class="form-controls">
                    <i class="ico-user"></i>    <!-- user for mysqli $user_details->first_name -->
                    <input type="text" class="field" name="first_name" id="first_name" value="<?=$user_details['first_name']?>" placeholder="Name">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            
            <div class="form-row">
                <label for="field-name" class="form-label hidden">Last Name </label>

                <div class="form-controls">
                    <i class="ico-user"></i>
                    <input type="text" class="field" name="last_name" id="last_name" value="<?=$user_details['last_name']?>" placeholder="Name">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            

            <div class="form-row">
                <label for="field-email" class="form-label hidden">Username</label>

                <div class="form-controls">
                    <i class="ico-mail"></i>
                    <input type="text" class="field" name="field-email" id="field-email-1" value="<?=$user_details['email']?>" placeholder="Email">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Password</label>

                <div class="form-controls">
                    <input type="password" class="field" name="password" id="password" value="<?=$user_details['password']?>" placeholder="Password">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            
        </div><!-- /.form-body -->

        <div class="form-actions">
            <input type="submit" value="Update" class="form-btn"> <!--  onclick="return filter_email();" -->
        </div><!-- /.form-actions -->
    </form>
</div><!-- /.form-sing-up -->