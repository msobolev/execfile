<?php
//$cto = mysql_connect("ctou2.db.5330536.hostedresource.com","ctou2","wTjP!399RD") or die("Database ERROR ");
include("config.php");

$cto = mysql_connect("10.132.233.131","ctou2","juitbu1@!ctlho0") or die("Database ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");


$cmo = mysql_connect("10.132.232.238","cmo1","aqwdfr1$&dgcmoobq",TRUE) or die("Database ERROR ");
mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");


// below are actually EXEC DB connection
$hre = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$hre) or die ("ERROR: Database not found ");





/*$cto = mysql_connect("localhost","root","") or die("Database ERROR ");
mysql_select_db("cto",$cto) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","",TRUE) or die("Database ERROR ");
mysql_select_db("cto_hre",$hre) or die ("ERROR: Database not found ");*/

//mysql_query("insert into hre_company_update_info (page_name,start_date_time) values ('company-other-update','".date("Y-m-d : H:i:s")."')",$hre);
//$update_id= mysql_insert_id($hre);
//State

//company_job_info
mysql_query("TRUNCATE TABLE `cmo_company_job_info`",$hre);
//$cjiResult = mysql_query("select * from cto_company_job_info",$cto);
$cjiResult = mysql_query("select * from cto_company_job_info as cj,cto_company_job_website as cw where cj.company_id = cw.company_id and cw.website = 'cmo'",$cto);
while($cjiRow = mysql_fetch_array($cjiResult))
{
    //mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
    $job_result = mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values('".$cjiRow['job_id']."','".$cjiRow['company_id']."','".$cjiRow['job_title']."','".$cjiRow['description']."','".$cjiRow['location']."','".$cjiRow['post_date']."','".$cjiRow['add_date']."','".$cjiRow['modify_date']."','".$cjiRow['status']."','".$cjiRow['source']."'".")",$hre);	
    if (!$job_result) 
    {
        //echo "<br>INSERT INTO cmo_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")<br>";
        mysql_query("INSERT INTO cmo_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
    }
}


//adding funding info from CTOS to this site
mysql_query("TRUNCATE TABLE `cmo_company_funding`",$hre);
//$cfResult = mysql_query("select * from cto_company_funding as cf,cto_company_funding_website as cw where cf.company_id = cw.company_id and website like 'cmo'",$cto);
$cfResult = mysql_query("select cf.funding_id,cf.company_id,cf.funding_date,cf.funding_amount,cf.funding_source,cf.funding_add_date,cf.status from cto_company_funding as cf,cto_company_funding_website as cw where cf.company_id = cw.company_id and website like 'cmo' group by cf.funding_id",$cto); // Updated on 12Apr 2017
//echo "<br>Main fundng Q: select cf.funding_id,cf.company_id,cf.funding_date,cf.funding_amount,cf.funding_source,cf.funding_add_date,cf.status from cto_company_funding as cf,cto_company_funding_website as cw where cf.company_id = cw.company_id and website like 'cmo' and cf.company_id = 80580 group by cf.funding_id";
while($cfRow = mysql_fetch_array($cfResult))
{
   // echo "<br>Funding insert: INSERT INTO cmo_company_funding (funding_id,company_id,funding_date,funding_amount,funding_source,funding_add_date,status)values(".'"'.$cfRow['funding_id'].'","'.$cfRow['company_id'].'","'.$cfRow['funding_date'].'","'.$cfRow['funding_amount'].'","'.$cfRow['funding_source'].'","'.$cfRow['funding_add_date'].'","'.$cfRow['status'].'"'.")";
    mysql_query("INSERT INTO cmo_company_funding (funding_id,company_id,funding_date,funding_amount,funding_source,funding_add_date,status)values(".'"'.$cfRow['funding_id'].'","'.$cfRow['company_id'].'","'.$cfRow['funding_date'].'","'.$cfRow['funding_amount'].'","'.$cfRow['funding_source'].'","'.$cfRow['funding_add_date'].'","'.$cfRow['status'].'"'.")",$hre);
}



//invoices
mysql_query("TRUNCATE TABLE `cmo_saved_invoices`",$hre);
$cfResult = mysql_query("select * from cmo_saved_invoices",$cmo);
while($cfRow = mysql_fetch_array($cfResult)){
    //echo "<br>INSERT INTO hre_banned_domain (domain_id,domain_name,add_date,status)values(".'"'.$cfRow['domain_id'].'","'.$cfRow['domain_name'].'","'.$cfRow['add_date'].'","'.$cfRow['status'].'"'.")";
    mysql_query("INSERT INTO cmo_saved_invoices (i_id,user_id,invoice_file,display_name)values(".'"'.$cfRow['i_id'].'","'.$cfRow['user_id'].'","'.$cfRow['invoice_file'].'","'.$cfRow['display_name'].'"'.")",$hre);
}


//mysql_query("update hre_company_update_info set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'",$hre);

mysql_close($cto);
mysql_close($hre);

?>