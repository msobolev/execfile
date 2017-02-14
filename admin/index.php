<?php
session_start();

/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/
require('../functions.php');
require('../config.php');
require('admin_header.php');

?>
<style>
.header_text    
{
    font-weight:bold;
}
</style>
<?PHP


if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'password_forgotten.php') { 
   com_admin_check_login(); 
}
//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$msg = "";
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    //echo "<br>  within edit";
    $user_id = $_GET['user_id'];
    delete_user($user_id);
    $msg = "User deleted.";
    //echo "<pre>user_details: ";   print_r($user_details);   echo "</pre>";
    //add_user($name,$email);
}  


$all_users = get_all_registered_users();
//echo "<pre>all_users: ";   print_r($all_users);   echo "</pre>";

if($msg != '')
{    
?>
<h3><?=$msg?></h3>
<?PHP
}
?>


<h2>List of Registered Users</h2>

<table cellpadding="5" width="100%" style="border:1px solid #CCCCCC;"> 
    <tr>
        <td class="header_text" width="300">Name</td>
        <td class="header_text" width="300">Email</td>
        <td class="header_text" width="100">Status</td>
        <td class="header_text" width="100">Type</td>
        <td class="header_text"  width="200">Action</td>
    </tr>
    
    <?PHP
    foreach($all_users as $user_id => $user_data)
    {    
    ?>
    <tr>
        <td><?=$user_data['first_name']?></td>
        <!-- <td><? //=$user_data['last_name']?></td> -->
        <td><?=$user_data['email']?></td>
        <td>
        <?PHP
            if($user_data['status'] == 1)
                echo "Active";
            else
                echo "Deactive";
        ?>
        </td>
        <td><?=$user_data['form_type']?></td>
        <td>
            <a href="users.php?action=edit&user_id=<?=$user_id?>">Edit</a>
            &nbsp;&nbsp;
            <a href="index.php?action=delete&user_id=<?=$user_id?>">Delete</a>
        </td>
    </tr>    
    <?PHP
    }
    ?>
</table>