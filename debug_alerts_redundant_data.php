<?php

include("config.php");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

$alert_query = "select * from hre_alert_send_info where user_id = 3571 order by info_id desc";
$alert_result = mysql_query($alert_query,$exec); 


while($alert_row = mysql_fetch_array($alert_result)){
    
    $email_id = $alert_row['email_id'];
    
    echo "<br><br><a href=http://www.execfile.com/alert-email-show.php?emailid=$email_id>".gmdate("Y-m-d", $alert_row['sent_date'])."</a>";
    
    
}

?>