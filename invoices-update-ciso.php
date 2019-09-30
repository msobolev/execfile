<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


//include("includes/configuration.php");
include("config.php");

$ciso = mysql_connect("162.243.211.147","ctou2","sonhgbu33!@tyui","ctou2") or die("Database ERROR: ".mysql_error());
mysql_select_db("ctou2",$ciso) or die ("ERROR: Database not found ");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");






$ciso_static_table = 'ciso_invoices_static_details';
$cto_static_table = 'cto_invoices_static_details';
$result = mysql_query("DELETE FROM $ciso_static_table  ",$exec);
//$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
//mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $cto_static_table  ",$ciso); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $ciso_static_table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}






$ciso_table = 'ciso_invoices';
$cto_table = 'cto_invoices';

$user_table='cto_user';

$result = mysql_query("DELETE FROM $ciso_table  ",$exec);

//$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cto)); // get structure from table on server 1
//mysql_query(" $tableinfo[1] ",$ciso); // use found structure to make table on server 2
//$result = mysql_query("SELECT * FROM $cto_table",$ciso); // select all content		
//echo "<pre>result:";   print_r($result);   echo "</pre>";
$result = mysql_query("SELECT * FROM $cto_table  ",$ciso); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) 
{		
    $email = "";
    //echo "<br><br>User id:".$row['user_id'];
    if($row['user_id'] != '')
    {    
        $user_email_q = "select email from ".$user_table." where user_id = ".$row['user_id'];
        echo "<br>user_email_q id:".$user_email_q;
        $email_result_rs = mysql_query($user_email_q,$ciso);
        $email_user = mysql_fetch_array($email_result_rs);
        $email = $email_user['email'];
    }
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','".$email."')";
    
    mysql_query("INSERT INTO $ciso_table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','".$email."')",$exec); // insert one row into new table
    
}





$cto_saved_table='cto_saved_invoices';
$ciso_saved_table='ciso_saved_invoices';
$result = mysql_query("DELETE FROM $ciso_saved_table  ",$exec);
//$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
//mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $cto_saved_table  ",$ciso); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";
    
       mysql_query("INSERT INTO $ciso_saved_table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}





















if(1 == 2)
{    

include("includes/configuration.php");
//include("config.php");


$ciso = mysql_connect("162.243.211.147","ctou2","sonhgbu33!@tyui","ctou2") or die("Database ERROR: ".mysql_error());
mysql_select_db("ctou2",$ciso) or die ("ERROR: Database not found ");

$cto = mysql_connect(DB_SERVER,DB_SERVER_USERNAME,DB_SERVER_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(DB_DATABASE,$cto) or die ("ERROR: Database not found ");


echo "<pre>ciso:";   print_r($ciso);   echo "</pre>";
echo "<pre>cto:";   print_r($cto);   echo "</pre>";

$personal_not_added = array();


$table='ciso_invoices_static_details';
$result = mysql_query("DELETE FROM $table  ",$cto);

//echo mysql_errno($cto) . ": " . mysql_error($cto) . "\n";


//$rs_static = mysql_query("SHOW CREATE TABLE $table  ",$ciso);
//echo "<pre>RS STATIC:";   print_r($rs_static);   echo "</pre>";

echo "SELECT * FROM $table  ";
//$tableinfo = mysql_fetch_array($rs_static); // get structure from table on server 1
//mysql_query(" $tableinfo[1] ",$cto); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$ciso); // select all content		
echo "<pre>RESULT:";   print_r($result);   echo "</pre>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       //mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$cto); // insert one row into new table
}


$table='ciso_invoices';
$user_table='clo_user';
$result = mysql_query("DELETE FROM $table  ",$cto);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$ciso)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$cto); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$ciso); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','test.com')";
    //echo "<pre>"; print_r($row);    echo "</pre>"; die();
    $email = "";
    //echo "<br><br>User id:".$row['user_id'];
    if($row['user_id'] != '')
    {    
        $user_email_q = "select email from ".$user_table." where user_id = ".$row['user_id'];
        echo "<br>user_email_q id:".$user_email_q;
        $email_result_rs = mysql_query($user_email_q,$ciso);
        $email_user = mysql_fetch_array($email_result_rs);
        $email = $email_user['email'];
    }
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','".$email."')";
    
    mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).",email) VALUES ('".implode("', '",array_values($row))."','".$email."')",$cto); // insert one row into new table
}

$table='ciso_saved_invoices';
$result = mysql_query("DELETE FROM $table  ",$cto);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$ciso)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$cto); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$ciso); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
    
    //echo "<br>INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')";
    
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$cto); // insert one row into new table
}






mysql_close($ciso);
mysql_close($cto);
}



?>