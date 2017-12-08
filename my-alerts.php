<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

include("config.php");
include("functions.php");

//com_db_connect_hre2() or die('Unable to connect to database server!');


$site = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$site) or die ("ERROR: Database not found ");



//echo "<pre>";   print_r($_GET);   echo "</pre>";

if(isset($_GET['del_alert_id']) && $_GET['del_alert_id'] != '')
{
    $del_alert_q = "DELETE FROM exec_alert where alert_id = ".$_GET['del_alert_id'];
    //echo "<br>del_alert_q: ".$del_alert_q;
    mysql_query($del_alert_q);
}    


if(isset($_POST['name_sbt']) && $_POST['name_sbt'] == 'Save' && $_POST['this_alert_id'] != '')
{
    $upd_alert_q = "UPDATE exec_alert set alert_name = '".$_POST['alert_name']."' where alert_id = ".$_POST['this_alert_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    mysql_query($upd_alert_q);
}    


$user_id = 2053;//1963;//2053;
$my_alerts_q = "SELECT * from exec_alert where user_id = $user_id";
$my_alerts_res = mysql_query($my_alerts_q);
$alerts_rows = mysql_num_rows($my_alerts_res);

//echo "<br>number rows: ".$alerts_rows;

if($alerts_rows > 0)
{    
    //$alerts_row = mysql_fetch_array($my_alerts_res);
    echo "<h2>My Alerts</h2>";
    echo "<table cellpadding=5 cellspacing=0 width=95% style=\"border:1px solid #CCCCCC\">";
    echo "<tr><th width=60>ID</th><th>Triggers</th><th width=20 0>Name</th><th>Action</th></tr>";
    while($alerts_row = mysql_fetch_array($my_alerts_res))
    {
        
        $trigger_details = '';
        if($alerts_row['mgt_change'] == 1)
            $trigger_details .= "Management Change,";
        if($alerts_row['speaking'] == 1)
            $trigger_details .= " Speaking,";
        if($alerts_row['awards'] == 1)
            $trigger_details .= " Awards,";
        if($alerts_row['publication'] == 1)
            $trigger_details .= " Publication,";
        if($alerts_row['media_mention'] == 1)
            $trigger_details .= " Media Mention,";
        if($alerts_row['board'] == 1)
            $trigger_details .= " Board,";
        if($alerts_row['jobs'] == 1)
            $trigger_details .= " Jobs,";
        if($alerts_row['fundings'] == 1)
            $trigger_details .= " Fundings,";
        
        $trigger_details = trim($trigger_details,",");
        $alert_name = $alerts_row['alert_name'];
        
        echo "<tr><td>";
        echo $alerts_row['alert_id'];
        echo "</td><td>$trigger_details</td>";

        echo "<td>";
        echo "<form method=post><input type=hidden name=this_alert_id id=this_alert_id value=".$alerts_row['alert_id']."><input type=text name=alert_name id=alert_name value=\"$alert_name\"><input type=submit name=name_sbt id=name_sbt value=Save></form>";
        echo "</td>";
        
        echo "<td>";
        echo "<a href=my-alerts.php?del_alert_id=".$alerts_row['alert_id'].">Delete</a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</td>";
        
        echo "</tr>";
        //echo "<br>".$alerts_row;
        //echo "<pre>alerts_row: ";   print_r($alerts_row);   echo "</pre>";
    }
    echo "</table>";
}    
?>