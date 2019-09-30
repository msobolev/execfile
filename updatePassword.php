<?php
include("config.php");

$email = $_GET['email'];
$pass = $_GET['pass'];


$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

$updatePass = "UPDATE ".TABLE_USER." set password = md5('$pass') where email = '$email'";
$result = mysql_query($updatePass,$exec);

?>