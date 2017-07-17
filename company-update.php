<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);


//$cto = mysql_connect("10.132.233.131","ctou2","wTjP!399RD") or die("Database ERROR ");
//$cto = mysql_connect("10.132.233.131","ctou2","fAPs321az") or die("Database ERROR ");
$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");


$hre_original = mysql_connect("10.132.225.160","hre2","htXP%th@71",TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db("hre2",$hre_original) or die ("ERROR: Database not found ");


/*$cto = mysql_connect("localhost","root","") or die("Database ERROR ");
mysql_select_db("cto",$cto) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","",TRUE) or die("Database ERROR ");
mysql_select_db("cto_hre",$hre) or die ("ERROR: Database not found ");*/

//mysql_query("insert into hre_company_update_info (page_name,start_date_time) values ('company-update','".date("Y-m-d : H:i:s")."')",$hre);
//$update_id= mysql_insert_id($hre);



//Company table update
$companyResult = mysql_query("select * from cto_company_update_info where exec_status=0",$cto);
//echo "<br>companyResult: select * from cto_company_update_info where exec_status=0";
//echo "<br>";
$cnt = 0;
while($companyRow = mysql_fetch_array($companyResult))
{
    //echo "<br>Within while";
    $cnt++;
    $query = str_replace('cto_company_master','hre_company_master', $companyRow['query_string']);
    
    //echo "<br>Query: ".$query;
    mysql_query($query,$hre);
    
    $cinfo_id = $companyRow['cinfo_id'];
    mysql_query("update cto_company_update_info set exec_status='1' where cinfo_id='".$cinfo_id."'",$cto);
}
//movement table data update that is deleted company delete to the ceo movement_master table all same company_id


//echo "<br>Movement Update: select * from cto_movement_update_info where exec_status=0";
/*
$moveResult = mysql_query("select * from cto_movement_update_info where exec_status=0",$cto);
while($moveRow = mysql_fetch_array($moveResult)){
	$query = str_replace('cto_movement_master','hre_movement_master', $moveRow['query_string']);
	
        //echo "<br>Query: ".$query;
        
        mysql_query($query,$hre);
	$cinfo_id = $moveRow['cinfo_id'];
        //echo "<br>cinfo_id: ".$cinfo_id;
	mysql_query("update hre_movement_update_info set exec_status='1' where cinfo_id='".$cinfo_id."'",$cto);
}
*/
//mysql_query("update hre_company_update_info set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'",$hre);

// COPYING OF MOVEMENT TABLE
/*
$L1 = mysql_connect('localhost', 'user1', 'pass1');
$DB1 = mysql_select_db('database1', $L1);   

$L2 = mysql_connect('localhost', 'user2', 'pass2');
$DB2 = mysql_select_db('database2', $L2);   
*/

/*
$keyfield = "move_id";
echo "<br>SELECT * FROM hre_movement_master";
$re=mysql_query("SELECT * FROM hre_movement_master LIMIT 0,6",$hre_original);
echo "<br>RE: ".count($re);
while($i=mysql_fetch_assoc($re))
{
    echo "<pre>I before: ";   print_r($i);  echo "</pre>";
    foreach($i as $ke => $va)
    {
        $va = mysql_real_escape_string($va);
    }    
    echo "<pre>I after: ";   print_r($i);  echo "</pre>";
    $u=array();
    foreach($i as $k=>$v) if($k!=$keyfield) $u[]="$k='$v'";
    $ins_query = "INSERT INTO hre_movement_master (".implode(',',array_keys($i)).") VALUES ('".implode("','",$i)."') ON DUPLICATE KEY UPDATE ".implode(',',$u);
    echo "<br>ins_query: ".$ins_query;
    mysql_query("INSERT INTO hre_movement_master (".implode(',',array_keys($i)).") VALUES ('".implode("','",$i)."') ON DUPLICATE KEY UPDATE ".implode(',',$u),$hre) or die(mysql_error());
}
*/


$table='hre_movement_master';

$del_q = "DELETE from $table";
$del_res = mysql_query($del_q,$hre); 

$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre_original)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$hre); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table ",$hre_original); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) 
{		
    //mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$hre); // insert one row into new table
    $ins_q = "INSERT INTO $table(move_id,personal_id,company_id,title,headline,effective_date,announce_date,full_body,link,short_url,what_happened,source_id,movement_type,more_link,not_current,create_by,admin_id,movement_url,sitemap_status,add_date,status,source_bulk_upload)
            values(".$row['move_id'].",".$row['personal_id'].",".$row['company_id'].",'".mysql_real_escape_string($row['title'])."','".mysql_real_escape_string($row['headline'])."','".$row['effective_date']."','".$row['announce_date']."','".mysql_real_escape_string($row['full_body'])."','".mysql_real_escape_string($row['link'])."','".mysql_real_escape_string($row['short_url'])."','".mysql_real_escape_string($row['what_happened'])."','".mysql_real_escape_string($row['source_id'])."','".mysql_real_escape_string($row['movement_type'])."','".mysql_real_escape_string($row['more_link'])."','".mysql_real_escape_string($row['not_current'])."','".mysql_real_escape_string($row['create_by'])."','".mysql_real_escape_string($row['admin_id'])."','".mysql_real_escape_string($row['movement_url'])."','".mysql_real_escape_string($row['sitemap_status'])."','".mysql_real_escape_string($row['add_date'])."','".mysql_real_escape_string($row['status'])."','".mysql_real_escape_string($row['source_bulk_upload'])."')";

    mysql_query($ins_q,$hre);
}



mysql_close($cto);
mysql_close($hre);
//mysql_close($hre_original);

echo $cnt;

?>
