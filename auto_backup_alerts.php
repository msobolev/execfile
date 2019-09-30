<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include("config.php");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

$alertDb = 'exec_alert';
$alertDbBackup = 'exec_alert_backup';

$delQuery = "DELETE from $alertDbBackup";
$del_res = mysql_query($delQuery,$exec); 

//echo "<br>SELECT * FROM $alertDb  ";

$getAlerts = mysql_query("SELECT * FROM $alertDb  ",$exec); // select all content		
while ($alertRow = mysql_fetch_array($getAlerts, MYSQL_ASSOC) ) 
{		
    //mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$hre); // insert one row into new table
    //$ins_q = "INSERT INTO $alertDb()
    //        values(".$row['move_id'].",".$row['personal_id'].",".$row['company_id'].",'".mysql_real_escape_string($row['title'])."','".mysql_real_escape_string($row['headline'])."','".$row['effective_date']."','".$row['announce_date']."','".mysql_real_escape_string($row['full_body'])."','".mysql_real_escape_string($row['link'])."','".mysql_real_escape_string($row['short_url'])."','".mysql_real_escape_string($row['what_happened'])."','".mysql_real_escape_string($row['source_id'])."','".mysql_real_escape_string($row['movement_type'])."','".mysql_real_escape_string($row['more_link'])."','".mysql_real_escape_string($row['not_current'])."','".mysql_real_escape_string($row['create_by'])."','".mysql_real_escape_string($row['admin_id'])."','".mysql_real_escape_string($row['movement_url'])."','".mysql_real_escape_string($row['sitemap_status'])."','".mysql_real_escape_string($row['add_date'])."','".mysql_real_escape_string($row['status'])."','".mysql_real_escape_string($row['source_bulk_upload'])."')";
    
    //echo "<br>INSERT INTO $alertDbBackup (".implode(", ",array_keys($alertRow)).") VALUES ('".implode("', '",array_values($alertRow))."')";
    
    mysql_query("INSERT INTO $alertDbBackup (".implode(", ",array_keys($alertRow)).") VALUES ('".implode("', '",array_values($alertRow))."')",$exec); // insert one row into new table
   
}
mysql_close($exec);


