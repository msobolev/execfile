<?php

include("config.php");


$cmo = mysql_connect("10.132.232.238","cmo1","aqwdfr1$&dgcmoobq",TRUE) or die("Database ERROR ");
mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

$personal_not_added = array();


$table='cmo_personal_master';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2

//echo "<br>SELECT * FROM $table where company_website = 'www.boeing.com' limit 0,10";

//$result = mysql_query("SELECT * FROM $table where personal_id in ( 199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098 ) limit 0,10",$hre); // select all content		
$result = mysql_query("SELECT * FROM $table where status = 0",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
    //echo "<pre>ROW:";   print_r($row);   echo "</pre>";
    
    
    if($row['email_verified'] = 'Yes' && $row['personal_image'] != '')
        $alert_priority = "1";
    else
        $alert_priority = "2";
    
    //echo "<br><br>Query: INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";
    //$p_res = mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".mysql_real_escape_string(implode("', '",array_values($row)))."')",$exec); // insert one row into new table
    $p_res = mysql_query("INSERT INTO $table (personal_id,first_name,middle_name,last_name,email,email_verified,phone,personal_image,add_date,level,level_order,add_to_funding,about_person,cmo_user,linkedin_link,twitter_link,alert_priority) VALUES (".$row['personal_id'].",'".addslashes($row['first_name'])."','".addslashes($row['middle_name'])."','".addslashes($row['last_name'])."','".addslashes($row['email'])."','".addslashes($row['email_verified'])."','".addslashes($row['phone'])."','".addslashes($row['personal_image'])."','".addslashes($row['add_date'])."','".addslashes($row['level'])."','".addslashes($row['level_order'])."','".addslashes($row['add_to_funding'])."','".addslashes($row['about_person'])."','".$row['ciso_user']."','".$row['linkedin_link']."','".$row['twitter_link']."','".$alert_priority."')",$exec); // insert one row into new table
    
    //echo "<br>Query: INSERT INTO $table (personal_id,first_name,middle_name,about_person) VALUES (".$row['personal_id'].",'".addslashes($row['first_name'])."','".addslashes($row['last_name'])."','".addslashes($row['about_person'])."')";
    
    if(!$p_res)
    {
        //$personal_not_added[] = implode(",",$row);
        //$personal_not_added[] = "INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";
    }    
}
//echo "<pre>";   print_r($personal_not_added);   echo "</pre>";

$table='cmo_personal_speaking';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}



$table='cmo_personal_publication';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cmo_personal_media_mention';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cmo_personal_awards';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cmo_personal_board';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


mysql_close($cmo);
mysql_close($exec);

?>