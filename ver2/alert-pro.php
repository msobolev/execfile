<?php
session_start();
//include("includes/include-top.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include("config.php");
include("functions.php");

com_db_connect() or die('Unable to connect to database server!');

$action = $_GET['action'];

//$_SESSION['sess_user_id'] = 1;
$subscriptionID = "";
$alertPermition = "";
/*
//Admin Address start
$adminInfo = "select * from ". TABLE_ADMIN_SETTINGS ." where setting_id ='1'";
$adminResult = com_db_query($adminInfo);
$adminRow = com_db_fetch_array($adminResult);

$from_admin = $adminRow['site_email_from'];
$to_admin = $adminRow['site_email_address'];
		 
$site_owner_name = com_db_output($adminRow['site_owner_name']);
$site_owner_position = com_db_output($adminRow['site_owner_position']);

$site_domain_name = com_db_output($adminRow['site_domain_name']);
$site_phone_number = com_db_output($adminRow['site_phone_number']);
$site_company_address = com_db_output($adminRow['site_company_address']);
$site_company_city  = com_db_output($adminRow['site_company_city']);
$site_company_state = com_db_output($adminRow['site_company_state']);
$site_company_zip = com_db_output($adminRow['site_company_zip']);

$fromEmailSent='<table border="0" cellpadding="0" cellspacing="0">
					<tr><td align="left">'.$site_owner_name.'</td></tr>
					<tr><td align="left">'.$site_owner_position.'</td></tr>
					<tr><td align="left">'.$site_domain_name.'</td></tr>
					<tr><td align="left">'.$site_company_address.'</td></tr>
					<tr><td align="left">'.$site_company_city.', '.$site_company_state.'</td></tr>
					<tr><td align="left">'.$site_company_zip.'</td></tr>
					<tr><td align="left">'.$site_phone_number.'</td></tr>
					<tr><td align="left">'.$from_admin.'</td></tr>
				</table>';

//end

   
 */
				
if($action == 'AlertCreate'){ 
	$title = $_POST['title'];
	if($title=='e.g. HR and Human Capital Executives'){
		$title='';
	}else{
		$title = com_db_input($title);
	}
	$type = $_POST['management'];
	if($type=='Any'){
		$type='';
	}else{
		$type = com_db_GetValue('select id from '.TABLE_MANAGEMENT_CHANGE." where name='".com_db_input($type)."'");
	}
	$country = $_POST['country'];
	if($country=='Any'){
		$country='';
	}else{
		$country = com_db_GetValue('select countries_id from '.TABLE_COUNTRIES." where countries_name='".com_db_input($country)."'");
	}
	
	//$state = $_POST['state'];
        $state = '';
        $state_arr			= $_POST['state'];
        if(sizeof($state_arr)>0 && $state_arr[0] !=''){
                $state_id_arr = implode(",",$state_arr);
                $stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
                $stateResult = com_db_query($stateQuery);
                $state_list = '';
                while($stateRow = com_db_fetch_array($stateResult)){
                        if($state_list==''){
                                $state_list = $stateRow['short_name'];
                        }else{
                                $state_list .= "<br>". $stateRow['short_name'];
                        }
                }
        } 
        $state = $state_id_arr;
        
        
	$city = $_POST['city'];
	
	$zip_code = $_POST['zip_code'];
	if($zip_code =='Zip Code'){
		$zip_code = '';
	}
	$company = $_POST['company'];
	if($company =='e.g. Microsoft'){
		$company ='';
	}
	$rep   = array("\r\n", "\n","\r");
	$company_website	= str_replace($rep, "<br />", $_POST['company_website']);
	$industry = $_POST['industry'];
        $industry_arr		= $_POST['industry'];
		if(sizeof($industry_arr)>0 && $industry_arr[0] !=''){
			$industry_id_arr = implode(",",$industry_arr);
			$industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
			$industryResult = com_db_query($industryQuery);
			$industry_list = '';
			while($industryRow = com_db_fetch_array($industryResult)){
				if($industry_list==''){
					$industry_list = $industryRow['title'];
				}else{
					$industry_list .= "<br>". $industryRow['title'];
				}
			}
		}
        $industry = $industry_id_arr;
                
        
        $revenue_size = $_POST['revenue_size'];
        
        $revenue_size_arr	= $_POST['revenue_size'];
        if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !='')
        {
                $revenue_size_id_arr = implode(",",$revenue_size_arr);
                $revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
                $revenueResult = com_db_query($revenueQuery);
                $revenue_size_list = '';
                while($revenueRow = com_db_fetch_array($revenueResult)){
                        if($revenue_size_list==''){
                                $revenue_size_list = $revenueRow['name'];
                        }else{
                                $revenue_size_list .= "<br>". $revenueRow['name'];
                        }
                }
        }
        $revenue_size = $revenue_size_id_arr;
        
        
	$employee_size = $_POST['employee_size'];
        
        
        $employee_size_arr	= $_POST['employee_size'];
        if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !=''){
                $employee_size_id_arr = implode(",",$employee_size_arr);
                $employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
                $employeeResult = com_db_query($employeeQuery);
                $employeee_size_list = '';
                while($employeeRow = com_db_fetch_array($employeeResult)){
                        if($employee_size_list==''){
                                $employee_size_list = $employeeRow['name'];
                        }else{
                                $employee_size_list .= "<br>". $employeeRow['name'];
                        }
                }
        }
        $employee_size = $employee_size_id_arr;
        
        
        
        
	$speaking = $_POST['speaking'];
	$awards = $_POST['awards'];
	$publication = $_POST['publication'];
	$media_mentions = $_POST['media_mentions'];
	$board = $_POST['board'];
	$delivery_schedule = $_POST['delivery_schedule'];
	$alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
	$monthly_budget = $_POST['monthly_budget'];
	$add_date = date('Y-m-d');
	$exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
	$user_id = $_SESSION['sess_user_id'];
        
        $jobs = $_POST['jobs'];
	$fundings = $_POST['fundings'];
	
	$isAlertPresent = com_db_GetValue("select count(alert_id) as cnt from ".TABLE_ALERT." where user_id='".$user_id."'");
	//$subscriptionID = com_db_GetValue("select subscription_id from ".TABLE_USER." where user_id='".$user_id."'");
	//$alertPermition = com_db_GetValue("select custom_alerts from ".TABLE_SUBSCRIPTION." where sub_id='".$subscriptionID."'");
	
        
	//$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
        $alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
	com_db_query($alert_query);
	$alert_id = com_db_insert_id();
	
        $url = 'alert.php?action=added';
            com_redirect($url);
}

?>