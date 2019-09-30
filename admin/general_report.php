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

if(isset($_GET['period']) && $_GET['period'] == 'day')
{
    $period = "day";
}
elseif(isset($_GET['period']) && $_GET['period'] == 'weekly')
{
    $period = "weekly";
}
elseif(isset($_GET['period']) && $_GET['period'] == 'monthly')
{
    $period = "monthly";
}
else
{
    $period = "day";
}    


$all_users = get_general_report($period);
//echo "<pre>all_users: ";   print_r($all_users);   echo "</pre>";

if($msg != '')
{    
?>
<h3><?=$msg?></h3>
<?PHP
}
?>


<h2 style="float:left;width:400px;">General Traffic Report</h2>

<table cellpadding="5" width="100%" style="border:1px solid #CCCCCC;"> 
    
    <tr>
        <td style="text-align:center;padding-top:22px;" colspan="3" height="20px"><h3>
            <b>Time Period:</b>
            <a style="text-decoration:underline;" href="http://execfile.com/admin/general_report.php?period=day"><b>Day</b></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a style="text-decoration:underline;" href="http://execfile.com/admin/general_report.php?period=weekly"><b>Weekly</b></a>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <a style="text-decoration:underline;" href="http://execfile.com/admin/general_report.php?period=monthly"><b>Monthly</b></a>
            </h3>
        </td>
    </tr>    
    
    
    <tr>
        <td class="header_text" width="300">IP Address</td>
        <td class="header_text" width="100">Visit Date</td>
        <td class="header_text" width="300">Visit Page</td>
        
    </tr>
    
    <?PHP
    foreach($all_users as $record_id => $report_data)
    {    
    ?>
    <tr>
        
        <td width=300"><?=$report_data['user_ip']?></td>
        <td><?=$report_data['visited_date']?></td>
        <?PHP
        $basePath = "https://www.execfile.com/";
        if($report_data['visited_page'] == 'homepage')
        {
            $pagePath = $basePath;
        }  
        elseif($report_data['visited_page'] == 'create_alert')
        {
            $pagePath = $basePath."alert.php";
        }  
        elseif($report_data['visited_page'] == 'search')
        {
            $pagePath = $basePath."home.php?funtion=hr";
        } 
        elseif($report_data['visited_page'] == 'accounts')
        {
            $pagePath = $basePath."accounts.php";
        }
        elseif($report_data['visited_page'] == 'settings')
        {
            $pagePath = $basePath."settings.php";
        }
        elseif($report_data['visited_page'] == 'request_demo')
        {
            $pagePath = $basePath."request-demo.html";
        }
        ?>
        <td><?=$pagePath?></td>
        <?PHP
        }
        ?>
    </tr>    
    
</table>