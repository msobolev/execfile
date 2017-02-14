<?php
//$cto = mysql_connect("ctou2.db.5330536.hostedresource.com","ctou2","wTjP!399RD") or die("Database ERROR ");

$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");

// below are actually EXEC DB connection
$hre = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ");
mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");





/*$cto = mysql_connect("localhost","root","") or die("Database ERROR ");
mysql_select_db("cto",$cto) or die ("ERROR: Database not found ");

$hre = mysql_connect("localhost","root","",TRUE) or die("Database ERROR ");
mysql_select_db("cto_hre",$hre) or die ("ERROR: Database not found ");*/

//mysql_query("insert into hre_company_update_info (page_name,start_date_time) values ('company-other-update','".date("Y-m-d : H:i:s")."')",$hre);
//$update_id= mysql_insert_id($hre);
//State
mysql_query("TRUNCATE TABLE `hre_state`",$hre);
$stateResult = mysql_query("select * from cto_state",$cto);
while($stateRow = mysql_fetch_array($stateResult)){
	mysql_query("INSERT INTO hre_state (state_id,country_id,state_name,short_name)values(".'"'.$stateRow['state_id'].'","'.$stateRow['country_id'].'","'.$stateRow['state_name'].'","'.$stateRow['short_name'].'"'.")",$hre);
}

//countries
mysql_query("TRUNCATE TABLE `hre_countries`",$hre);
$countryResult = mysql_query("select * from cto_countries",$cto);
while($countryRow = mysql_fetch_array($countryResult)){
	mysql_query("INSERT INTO hre_countries (countries_id,countries_name,countries_iso_code_2,countries_iso_code_3)values(".'"'.$countryRow['countries_id'].'","'.$countryRow['countries_name'].'","'.$countryRow['countries_iso_code_2'].'","'.$countryRow['countries_iso_code_3'].'"'.")",$hre);
}

//employee_size
mysql_query("TRUNCATE TABLE `hre_employee_size`",$hre);
$esResult = mysql_query("select * from cto_employee_size",$cto);
while($esRow = mysql_fetch_array($esResult)){
	mysql_query("INSERT INTO hre_employee_size (id,name,from_range,to_range,add_date,modify_date,status)values(".'"'.$esRow['id'].'","'.$esRow['name'].'","'.$esRow['from_range'].'","'.$esRow['to_range'].'","'.$esRow['add_date'].'","'.$esRow['modify_date'].'","'.$esRow['status'].'"'.")",$hre);
}
//revenue_size
mysql_query("TRUNCATE TABLE `hre_revenue_size`",$hre);
$rsResult = mysql_query("select * from cto_revenue_size",$cto);
while($rsRow = mysql_fetch_array($rsResult)){
	mysql_query("INSERT INTO hre_revenue_size (id,name,from_range,to_range,add_date,modify_date,status)values(".'"'.$rsRow['id'].'","'.$rsRow['name'].'","'.$rsRow['from_range'].'","'.$rsRow['to_range'].'","'.$rsRow['add_date'].'","'.$rsRow['modify_date'].'","'.$rsRow['status'].'"'.")",$hre);
}

//industry
mysql_query("TRUNCATE TABLE `hre_industry`",$hre);
$indResult = mysql_query("select * from cto_industry",$cto);
while($indRow = mysql_fetch_array($indResult)){
	mysql_query("INSERT INTO hre_industry (industry_id,parent_id,title,content,add_date,status)values(".'"'.$indRow['industry_id'].'","'.$indRow['parent_id'].'","'.$indRow['title'].'","'.$indRow['content'].'","'.$indRow['add_date'].'","'.$indRow['status'].'"'.")",$hre);
}

//company_job_info
mysql_query("TRUNCATE TABLE `hre_company_job_info`",$hre);
//$cjiResult = mysql_query("select * from cto_company_job_info",$cto);
$cjiResult = mysql_query("select * from cto_company_job_info as cj,cto_company_job_website as cw where cj.company_id = cw.company_id and cw.website = 'HR'",$cto);
while($cjiRow = mysql_fetch_array($cjiResult)){
	//mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
	$job_result = mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values('".$cjiRow['job_id']."','".$cjiRow['company_id']."','".$cjiRow['job_title']."','".$cjiRow['description']."','".$cjiRow['location']."','".$cjiRow['post_date']."','".$cjiRow['add_date']."','".$cjiRow['modify_date']."','".$cjiRow['status']."','".$cjiRow['source']."'".")",$hre);	
	if (!$job_result) {
		mysql_query("INSERT INTO hre_company_job_info (job_id,company_id,job_title,description,location,post_date,add_date,modify_date,status,source)values(".'"'.$cjiRow['job_id'].'","'.$cjiRow['company_id'].'","'.$cjiRow['job_title'].'","'.$cjiRow['description'].'","'.$cjiRow['location'].'","'.$cjiRow['post_date'].'","'.$cjiRow['add_date'].'","'.$cjiRow['modify_date'].'","'.$cjiRow['status'].'","'.$cjiRow['source'].'"'.")",$hre);
	}
}


//company_job_info to add to demo emails
mysql_query("TRUNCATE TABLE `hre_demo_jobs_info`",$hre);
$cjidResult = mysql_query("select * from cto_company_job_website where website like 'HR'",$cto);
while($cjidRow = mysql_fetch_array($cjidResult)){
	mysql_query("INSERT INTO hre_demo_jobs_info (company_id) values(".'"'.$cjidRow['company_id'].'"'.")",$hre);
}


//company_funding_info to add to demo emails
mysql_query("TRUNCATE TABLE `hre_demo_fundings_info`",$hre);
$cfidResult = mysql_query("select * from cto_company_funding_website where website like 'HR'",$cto);
while($cfidRow = mysql_fetch_array($cfidResult)){
	mysql_query("INSERT INTO hre_demo_fundings_info (company_id) values(".'"'.$cfidRow['company_id'].'"'.")",$hre);
}

//adding funding info from CTOS to this site
mysql_query("TRUNCATE TABLE `hre_company_funding`",$hre);
$cfResult = mysql_query("select * from cto_company_funding",$cto);
while($cfRow = mysql_fetch_array($cfResult)){
	mysql_query("INSERT INTO hre_company_funding (funding_id,company_id,funding_date,funding_amount,funding_source,funding_add_date,status)values(".'"'.$cfRow['funding_id'].'","'.$cfRow['company_id'].'","'.$cfRow['funding_date'].'","'.$cfRow['funding_amount'].'","'.$cfRow['funding_source'].'","'.$cfRow['funding_add_date'].'","'.$cfRow['status'].'"'.")",$hre);
}


//company_job_info to add to executive demo emails
mysql_query("TRUNCATE TABLE `hre_demo_executive_jobs_info`",$hre);
$cejResult = mysql_query("select * from cto_company_executive_job_website where website like 'HR'",$cto);
while($cejRow = mysql_fetch_array($cejResult)){
	mysql_query("INSERT INTO hre_demo_executive_jobs_info (company_id) values(".'"'.$cejRow['company_id'].'"'.")",$hre);
}




//mysql_query("update hre_company_update_info set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'",$hre);

mysql_close($cto);
mysql_close($hre);

?>