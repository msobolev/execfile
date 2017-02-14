<?php
//$cto = mysql_connect("ctou2.db.5330536.hostedresource.com","ctou2","wTjP!399RD") or die("Database ERROR ");

$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");


// below are actually EXEC DB connection
$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");



//mysql_query("insert into hre_company_update_info (page_name,start_date_time) values ('company-other-update','".date("Y-m-d : H:i:s")."')",$hre);
//$update_id= mysql_insert_id($hre);
//State

//company_job_info
mysql_query("TRUNCATE TABLE `cto_company_job_info`",$hre);
//$cjiResult = mysql_query("select * from cto_company_job_info",$cto);
$cjiResult = mysql_query("select * from cto_company_job_info as cj,cto_company_job_website as cw where cj.company_id = cw.company_id and cw.website = 'cto'",$cto);
while($cjiRow = mysql_fetch_array($cjiResult))
{
    //mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
    $job_result = mysql_query("INSERT INTO cto_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values('".$cjiRow['job_id']."','".$cjiRow['company_id']."','".$cjiRow['job_title']."','".$cjiRow['description']."','".$cjiRow['location']."','".$cjiRow['post_date']."','".$cjiRow['add_date']."','".$cjiRow['modify_date']."','".$cjiRow['status']."','".$cjiRow['source']."'".")",$hre);	
    if (!$job_result) 
    {
        mysql_query("INSERT INTO cto_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
    }
}


//adding funding info from CTOS to this site
mysql_query("TRUNCATE TABLE `cto_company_funding`",$hre);
//echo "<br><br>Funding: select * from cto_company_funding as cf,cto_company_funding_website as cw where cf.company_id = cw.company_id and website like 'cto'";
//$cfResult = mysql_query("select * from cto_company_funding as cf,cto_company_funding_website as cw where cf.company_id = cw.company_id and website like 'cto'",$cto);

// Below query updated on 2nd Jan 2017
$cfResult = mysql_query("select * from cto_company_funding as cf,cto_company_funding_website as cw where cf.funding_id = cw.funding_id and website like 'cto'",$cto);
while($cfRow = mysql_fetch_array($cfResult))
{
    mysql_query("INSERT INTO cto_company_funding (funding_id,company_id,funding_date,funding_amount,funding_source,funding_add_date,status)values(".'"'.$cfRow['funding_id'].'","'.$cfRow['company_id'].'","'.$cfRow['funding_date'].'","'.$cfRow['funding_amount'].'","'.$cfRow['funding_source'].'","'.$cfRow['funding_add_date'].'","'.$cfRow['status'].'"'.")",$hre);
}


//mysql_query("update hre_company_update_info set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'",$hre);

mysql_close($cto);
mysql_close($hre);

?>