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
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre_original)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$hre); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre_original); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$hre); // insert one row into new table
}



mysql_close($cto);
mysql_close($hre);
//mysql_close($hre_original);

echo $cnt;

?>
