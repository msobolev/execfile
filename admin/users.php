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
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require('../functions.php');
require('../config.php');

require('admin_header.php');

//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');


$btn_val = "Add User";
$action = "add";
//if((isset($_POST['field-name']) && $_POST['field-name'] != '') && (isset($_POST['field-email']) && $_POST['field-email'] != ''))
if(isset($_GET['action']) && $_GET['action'] == 'add')
{
    $name = $_POST['field-name'];
    $email = $_POST['field-email'];
    $status = $_POST['user_status'];
    $new_password = $_POST['new_password'];
    $text_only = $_POST['text_only'];
    $user_site = $_POST['user_site'];
    add_user($name,$email,$new_password,$status,'','',$text_only,$user_site);
    $msg = "User added.";
}    

$user_details = array();
if(isset($_GET['action']) && $_GET['action'] == 'edit')
{
    //echo "<br>  within edit";
    
    $user_id = $_GET['user_id'];
    $user_details = get_user($user_id);
    $btn_val = "Update User";
    $action = "update";
    //echo "<pre>user_details: ";   print_r($user_details);   echo "</pre>";
    //add_user($name,$email);
}  

if(isset($_GET['action']) && $_GET['action'] == 'update')
{
    //echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
    //die();
    $text_only = "";
    $name = $_POST['field-name'];
    $email = $_POST['field-email'];
    $status = $_POST['user_status'];
    $password_db = $_POST['new_password'];
    $user_site = $_POST['user_site'];
    
    $text_only = $_POST['text_only'];
    
    $user_id = $_POST['user_id'];
    update_user($name,$email,$password_db,$status,$user_id,$user_site,$text_only);
    $msg = "User updated.";
    $user_details = get_user($user_id);
    $btn_val = "Update User";
    $action = "update";
    //echo "<pre>user_details: ";   print_r($user_details);   echo "</pre>";
}  
?>
<h2 style="padding-left:20px;"><?=$btn_val?></h2>

<?PHP
if($msg != '')
{    
?>
    <h3><?=$msg?></h3>
<?PHP
}
?>

<div style="padding-left:20px;" class="form-sing-up">
    <form action="?action=<?=$action?>" method="post" onsubmit="return filter_email('field-email-1');">
        <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>">
        <div class="form-body form-company">
            <div class="form-row">
                <label for="field-name" class="form-label hidden">Full Name </label>

                <div class="form-controls">
                    <i class="ico-user"></i>
                    <input type="text" class="field" name="field-name" id="field-name" value="<?=$user_details['first_name']?>" placeholder="Name">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->

            <div class="form-row">
                <label for="field-email" class="form-label hidden">Work Email</label>

                <div class="form-controls">
                    <i class="ico-mail"></i>
                    <input type="email" class="field" name="field-email" id="field-email-1" value="<?=$user_details['email']?>" placeholder="Work Email">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Password</label>

                <div class="form-controls">
                    <i class="ico-mail"></i>
                    <input type="password" class="field" name="new_password" id="new_password" value="<?=$user_details['password']?>" placeholder="">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Status</label>

                <div class="form-controls">
                    <select name="user_status" id="user_status" style="width:173px;">
                        <option <?PHP if($user_details['status'] == 1) echo "selected"; else echo ""; ?> value="1">Active</option>
                        <option <?PHP if($user_details['status'] == 0) echo "selected"; else echo ""; ?> value="0">Deactivated</option>
                    </select>    
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Site</label>

                <div class="form-controls">
                    <select name="user_site" id="user_site" style="width:173px;">
                        <option <?PHP if($user_details['site'] == 'hr') echo "selected"; else echo ""; ?> value="hr">HR</option>
                        <option <?PHP if($user_details['site'] == 'cmo') echo "selected"; else echo ""; ?> value="cmo">CMO</option>
                        <option <?PHP if($user_details['site'] == 'cto') echo "selected"; else echo ""; ?> value="cto">CTO</option>
                        <option <?PHP if($user_details['site'] == 'ciso') echo "selected"; else echo ""; ?> value="ciso">CISO</option>
                        <option <?PHP if($user_details['site'] == 'cso') echo "selected"; else echo ""; ?> value="cso">CSO</option>
                        <option <?PHP if($user_details['site'] == 'clo') echo "selected"; else echo ""; ?> value="clo">CLO</option>
                        <option <?PHP if($user_details['site'] == 'cfo') echo "selected"; else echo ""; ?> value="cfo">CFO</option>
                        <option <?PHP if($user_details['site'] == 'cto/ciso') echo "selected"; else echo ""; ?> value="cto/ciso">CTO/CISO</option>
                        <option <?PHP if($user_details['site'] == 'clo_lite') echo "selected"; else echo ""; ?> value="clo_lite">CLO Lite</option>
                    </select>    
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            <div class="form-row">
                <!-- <label for="field-email" class="form-label hidden">Text Only</label> -->

                <div class="form-controls">
                    <?PHP
                    if($user_details['text_only'] == '1')
                        $txt_only_chk = 'checked';
                    else
                        $txt_only_chk = '';
                    ?>
                    <input <?=$txt_only_chk?> type="checkbox" name="text_only" id="text_only" value="1" >&nbsp;Text Only
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
        </div><!-- /.form-body -->

        <div class="form-actions">
            <input type="submit" value="<?=$btn_val?>" class="form-btn"> <!--  onclick="return filter_email();" -->
        </div><!-- /.form-actions -->
    </form>
</div><!-- /.form-sing-up -->