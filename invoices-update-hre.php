<?php

include("config.php");


$hre = mysql_connect("10.132.225.160","hre2","yTmcds1@#dab133") or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

$personal_not_added = array();


$table='hre_invoices_static_details';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='hre_invoices';
$user_table='hre_user';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','test.com')";
    //echo "<pre>"; print_r($row);    echo "</pre>"; die();
    $email = "";
    if($row['user_id'] != '')
    {    
        $user_email_q = "select email from ".$user_table." where user_id = ".$row['user_id'];
        $email_result_rs = mysql_query($user_email_q,$hre);
        $email_user = mysql_fetch_array($email_result_rs);
        $email = $email_user['email'];
    }
    mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','".$email."')",$exec); // insert one row into new table
}

$table='hre_saved_invoices';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}






mysql_close($hre);
mysql_close($exec);

?>