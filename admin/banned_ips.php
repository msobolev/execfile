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

//echo "<pre>GET: ";   print_r($_GET);   echo "</pre>";
//echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";

if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    if(isset($_GET['id']) && $_GET['id'] != '')
    {
        $delIp = "DELETE from exec_banned_ips where b_id = '".$_GET['id']."'";
        $delResult = com_db_query($delIp); 
        $msg = "Banned IP deleted";
    }    
}

if(isset($_GET['action']) && $_GET['action'] == 'add')
{
    if(isset($_POST['new_ip']) && $_POST['new_ip'] != '')
    {
        $insertIp = "insert into exec_banned_ips(banned_ip) values('".$_POST['new_ip']."')";
        $insertResult = com_db_query($insertIp); 
        $msg = "Banned IP added";
    }    
}

if($msg != '')
{    
?>
<h3 style="padding-left:20px;"><?=$msg?></h3>
<?PHP
}
?>


<!-- <h2 style="float:left;width:100%;">Banned IPs</h2> -->

<table align="center" cellpadding="5" width="800" style="border:1px solid #CCCCCC;"> 
    
    <tr>
        <td style="text-align:center;padding-top:22px;" colspan="3" height="20px">
            <h3>
                <b style="font-size:15px;">Add IP:</b>
                <form action="banned_ips.php?action=add" method="post">
                    <input type="text" name="new_ip" id="new_ip">&nbsp;&nbsp;
                    <input type="submit" value="Add">
                </form>    
            </h3>
        </td>
    </tr>
    
    <tr>
        <td colspan="3"><h2>Banned IPs</h2></td>
    </tr>
    
    <tr>
        <td class="header_text" width="300">IP Address</td>
        <td class="header_text">Action</td>
    </tr>
    <?PHP
    $indResult = com_db_query("select * FROM exec_banned_ips;"); 
        
    while($indRow = com_db_fetch_array($indResult))
    {
    ?>
    <tr>
        <td width=300"><?=$indRow['banned_ip']?></td>
        <td><a href="banned_ips.php?action=delete&id=<?=$indRow['b_id']?>">Delete</a></td>
    <?PHP
    }
    ?>
    </tr>    
    
</table>