<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$cmo = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
mysql_select_db("clo2",$cmo) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");


$table='clo_movement_master';
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cmo)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$hre); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cmo); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$hre); // insert one row into new table
}



mysql_close($cmo);
mysql_close($hre);

?>