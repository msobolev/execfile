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



if(isset($_GET['f_id']) && $_GET['f_id'] != '')
{
    $sql_query = "select * from exec_forms where f_id = ".$_GET['f_id']."";
    $exe_data = com_db_query($sql_query);
    $data_sql = com_db_fetch_array($exe_data);
    $form_data = $data_sql['form_data'];
    
    echo "";
    ?>
    <table align="center" cellpadding="5" width="80%" style="border:1px solid #CCCCCC;">
        
        <tr>
            <td><br><a style="color:blue;" href=email_details.php>Go Back</a><br><br></td>
        </tr>
        
        <tr>
            <td><?=nl2br($form_data)?><br><br></td>
        </tr>    
    </table>    
    <?PHP
    
    
}    
else
{    
    $sql_query = "select * from exec_forms order by f_id desc";
    $exe_data = com_db_query($sql_query);
    $numRows = com_db_num_rows($exe_data);

    if($msg != '')
    {    
    ?>
    <h3><?=$msg?></h3>
    <?PHP
    }
    ?>


    <h2 style="padding-left:20px;">List of Emails Submitted</h2>

    <table align="center" cellpadding="5" width="80%" style="border:1px solid #CCCCCC;"> 
        <tr>
            <td class="header_text" width="300">Type</td>
            <td class="header_text" width="300">Email</td>
            <td class="header_text" width="100">Date</td>
        </tr>

        <?PHP
        if($numRows>0) 
        {
            while ($data_sql = com_db_fetch_array($exe_data)) 
            {
        ?>  
                <tr>
                    <td><?=$data_sql['form_type']?></td>
                    <td><a href="email_details.php?f_id=<?=$data_sql['f_id']?>">Details</a></td>
                    <td><?=$data_sql['form_date']?></td>
                </tr>    

        <?PHP
            }
        }
        ?>
    </table>
<?PHP
}
?>