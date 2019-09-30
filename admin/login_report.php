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

<script type="text/javascript">
function handleSelect(elm)
{
    //window.location = elm.value;
    document.getElementById("filters_frm").submit();
}
    
</script>
<?PHP


if (basename($_SERVER['PHP_SELF']) != 'login.php' && basename($_SERVER['PHP_SELF']) != 'password_forgotten.php') { 
   com_admin_check_login(); 
}
//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

$msg = "";

$status_clause = "";

//echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";

if(isset($_POST['user_status']) && $_POST['user_status'] != '2')
{
    $status_clause = " and status = '".$_POST['user_status']."'";
}


if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    //echo "<br>  within edit";
    $user_id = $_GET['user_id'];
    delete_user($user_id);
    $msg = "User deleted.";
    //echo "<pre>user_details: ";   print_r($user_details);   echo "</pre>";
    //add_user($name,$email);
}  


$all_users = get_login_report($status_clause);
//echo "<pre>all_users: ";   print_r($all_users);   echo "</pre>";

if($msg != '')
{    
?>
<h3><?=$msg?></h3>
<?PHP
}
?>


<h2 style="float:left;width:400px;">Users Login Report</h2>

<table cellpadding="5" width="100%" style="border:1px solid #CCCCCC;"> 
    <tr>
        
        <td class="header_text" width="300">Email</td>
        <td class="header_text" width="100">IP Address</td>
        <td class="header_text" width="100">Date Of Login</td>
        <td class="header_text" width="100">Result</td>
        
    </tr>
    
    <?PHP
    foreach($all_users as $user_id => $user_data)
    {    
    ?>
    <tr>
        <td style="width:400px; word-break: break-all;"><?=$user_data['user_email']?></td>
        <td width=300"><?=$user_data['user_ip']?></td>
        <td><?=$user_data['add_date']?></td>
        <td><?=$user_data['status']?></td>
    </tr>    
    <?PHP
    }
    ?>
</table>