<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");


// comapny id = 5806 not been copies from CTO to Execfile movement table

$table='cto_movement_master';

$del_q = "DELETE from $table";
$del_res = mysql_query($del_q,$hre); 

$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$cto)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$hre); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$cto); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) 
{		
    //mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$hre); // insert one row into new table
    $ins_q = "INSERT INTO $table(move_id,personal_id,company_id,title,headline,effective_date,announce_date,full_body,link,short_url,what_happened,source_id,movement_type,more_link,not_current,create_by,admin_id,movement_url,sitemap_status,add_date,status,source_bulk_upload)
            values(".$row['move_id'].",".$row['personal_id'].",".$row['company_id'].",'".mysql_real_escape_string($row['title'])."','".mysql_real_escape_string($row['headline'])."','".$row['effective_date']."','".$row['announce_date']."','".mysql_real_escape_string($row['full_body'])."','".mysql_real_escape_string($row['link'])."','".mysql_real_escape_string($row['short_url'])."','".mysql_real_escape_string($row['what_happened'])."','".mysql_real_escape_string($row['source_id'])."','".mysql_real_escape_string($row['movement_type'])."','".mysql_real_escape_string($row['more_link'])."','".mysql_real_escape_string($row['not_current'])."','".mysql_real_escape_string($row['create_by'])."','".mysql_real_escape_string($row['admin_id'])."','".mysql_real_escape_string($row['movement_url'])."','".mysql_real_escape_string($row['sitemap_status'])."','".mysql_real_escape_string($row['add_date'])."','".mysql_real_escape_string($row['status'])."','".mysql_real_escape_string($row['source_bulk_upload'])."')";
    
    //echo "<br>ins_q: ".$ins_q;
    mysql_query($ins_q,$hre);
}



mysql_close($cto);
mysql_close($hre);

?>