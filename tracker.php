<?php
//THIS RETURNS THE IMAGE
header('Content-Type: image/gif');
readfile('tracking.gif');
//THIS IS THE SCRIPT FOR THE ACTUAL TRACKING

include("functions.php");
include("config.php");
com_db_connect_hre2() or die('Unable to connect to database server!');

//$date = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
//$txt = $date.",". $_SERVER['REMOTE_ADDR']."_".$_REQUEST['email'];
//$myfile = file_put_contents('t_log.txt', $txt.PHP_EOL , FILE_APPEND);

//$_GET['last_inserted_alert'] = 18998;

//$updating_db = "UPDATE exec_alert_tracker set email_opened = 1 where info_id = '".$_GET['last_inserted_alert']."'";
$inserting_db = "INSERT into exec_alert_tracker(alert_email_id) values('".$_GET['last_inserted_alert']."')";
com_db_query($inserting_db);
exit;
?>
