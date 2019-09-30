<?php
session_start();
//include("includes/include-top.php");

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

include("config.php");
include("functions.php");

//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

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
//echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
//die();

if(isset($_REQUEST['sbt']) && $_REQUEST['sbt'] == 'Save List')
{
    //echo "<br>within";
    $selected_filters = "";
    $websites_filter = "";
    $list_industry = "";
    $list_triggers = "";
    $triggers_count = 0;
    
    $list_employee = '';
    $list_state = '';
    $list_zip = '';
    $list_mgt = '';
    $title_level = "";
   // echo "<pre>POST:";   print_r($_POST);   echo "</pre>";
    //echo "<pre>REQ:";   print_r($_REQUEST);   echo "</pre>";
    
    if(isset($_POST['chief_title_level']) && $_POST['chief_title_level'] == 'chief')
        $title_level .= 'chief,';
    if(isset($_POST['vp_title_level']) && $_POST['vp_title_level'] == 'vp')
        $title_level .= 'vp,';
    if(isset($_POST['director_title_level']) && $_POST['director_title_level'] == 'director')
        $title_level .= 'director,';

    //echo "<br>title_level:".$title_level;
    
   //die(); 
    if(isset($_POST['mgtchanges']) && $_POST['mgtchanges'] == 1)
    {
        $list_triggers .= 'movements,';
        $triggers_count++;
    }
    if(isset($_POST['speaking']) && $_POST['speaking'] == 1)
    {
        $list_triggers .= 'speaking,';
        $triggers_count++;
    }
    if(isset($_POST['awards']) && $_POST['awards'] == 1)
    {
        $list_triggers .= 'awards,';
        $triggers_count++;
    }
    if(isset($_POST['publication']) && $_POST['publication'] == 1)
    {
        $list_triggers .= 'publication,';
        $triggers_count++;
    }
    if(isset($_POST['media_mentions']) && $_POST['media_mentions'] == 1)
    {
        $list_triggers .= 'media_mention,';
        $triggers_count++;
    }
    if(isset($_POST['board']) && $_POST['board'] == 1)
    {
        $list_triggers .= 'board,';
        $triggers_count++;
    }
    if(isset($_POST['jobs']) && $_POST['jobs'] == 1)
    {
        $list_triggers .= 'jobs,';
        $triggers_count++;
    }
    if(isset($_POST['fundings']) && $_POST['fundings'] == 1)
    {
        $list_triggers .= 'funding,';
        $triggers_count++;
    }
    
    if($triggers_count == 8)
        $list_triggers = 'all';
    
    $list_triggers = trim($list_triggers,",");
    
    
    if(isset($_POST['management']) && $_POST['management'] != '')
    {
        $list_mgt = implode(",",$_POST['management']);
        
    }
    if(isset($_POST['industry']) && $_POST['industry'] != '')
    {
        $list_industry = implode(",",$_POST['industry']);
        
    }
    if(isset($_POST['revenue_size']) && $_POST['revenue_size'] != '')
    {
        $list_revenue = implode(",",$_POST['revenue_size']);
        echo "<br>list_revenue:".$list_revenue;
        
    }
    if(isset($_POST['employee_size']) && $_POST['employee_size'] != '')
    {
        $list_employee = implode(",",$_POST['employee_size']);
        
    }
    if(isset($_POST['state']) && $_POST['state'] != '')
    {
        $list_state = implode(",",$_POST['state']);
        
    }
    
    if($_POST['zip_code'] != 'Zip Code')
        $list_zip = $_POST['zip_code'];
    $list_city = $_POST['city'];
    
    //echo "<br>list_industry: ".$list_industry;
    if(isset($_POST['selected_filters']) && $_POST['selected_filters'] != '')
    {
        $selected_filters = $_POST['selected_filters'];
        
        //echo "<br>selected_filters:".$selected_filters;
        
        $selected_filters_arr = explode(":",$selected_filters);
        //echo "<pre>selected_filters_arr: ";   print_r($selected_filters_arr);   echo "</pre>";
        //die();
        $selected_filters_arr[8] = $list_industry;
        
        // Updated on 4 june 2018
        //if($selected_filters_arr[11] != '')
        //{    
        
        
        // $selected_filters_arr[11] contains raw revenue value
        // $list_revenue value get updating above from alert page revenue field
        // if value in alert page revenue field is same then 
        // raw revenue after conversion should be same as db revenue
        // otherwise user updated revenue field on alert page
        // and hence we need to use that value instead of raw revenue value
        $db_revenue = get_db_reveunue_against_raw($selected_filters_arr[11]);
        if($db_revenue != $list_revenue)
            $selected_filters_arr[11] = $list_revenue; // put updated revenue value
        // if same then automatically revenue value is entered after explode above
                
        //}    
        
        //$selected_filters_arr[10] = $list_revenue;
        
        $selected_filters_arr[13] = $list_employee;
        
        $selected_filters_arr[9] = $list_state;
        
        $selected_filters_arr[4] = $list_zip;
        
        $selected_filters_arr[6] = $list_city;
        
        $selected_filters_arr[14] = $list_mgt;
        
        $selected_filters_arr[0] = $list_triggers;
        
        
        //Updated on 7th Sept 2018 to handle title levels
        $selected_filters_arr[15] = $title_level;
        
        
        $selected_filters = implode(":",$selected_filters_arr);
         //echo "<br>selected_filters after implode:".$selected_filters;
    }    
    
    $insert_list_name_val = "";
    $update_list_name = "";
    if(isset($_POST['list_name']) && $_POST['list_name'] != '')
    {    
        $update_list_name = ",list_name='".$_POST['list_name']."'";
        $insert_list_name_val = $_POST['list_name'];
    }
    
    $this_user = $_SESSION['sess_user_id'];
    $websites_filter = $_REQUEST['company_website'];
    
    $rep   = array("\r\n", "\n","\r");
    $websites_filter	= str_replace($rep, "<br />", $websites_filter);
    
    
    $ranQuery = "";
    if(isset($_REQUEST['edit_list']) && $_REQUEST['edit_list'] != '')
    {
        //echo "<br>In if";
        $update_query = "UPDATE user_saved_lists set filters = '$selected_filters',websites_filter = '$websites_filter' $update_list_name where l_id = ".$_REQUEST['edit_list'];
         //echo "<br>update_query:".$update_query;
        com_db_query($update_query);
        $action_msg = 'EditList';
        $ranQuery = $update_query;
    }
    else
    {    
        //echo "<br>In else";
        //echo "<br>websites_filter: ".$websites_filter;
        $save_query = "insert into user_saved_lists (user_id,filters,websites_filter,list_name) values ('$this_user','$selected_filters','$websites_filter','$insert_list_name_val')";
        //echo "<br>save_query:".$save_query;
        com_db_query($save_query);
        $action_msg = 'SaveList';
        $ranQuery = $save_query;
    }    
    //die("2");
    
    $new_exec = mysqli_connect("10.132.233.66","cfo2","cV!kJ201Ze","hre2") or die("Database 3 ERROR ");
    mysqli_query($new_exec,$ranQuery);
    mysqli_close($new_exec);
    
    
    $url = 'alert.php?action='.$action_msg;
    com_redirect($url);
    
}


elseif($action == 'AlertCreate')
{ 
    
    $title = trim($_POST['title']);
    if($title=='e.g. CHRO or Vice President - Human Resources')
    {
        $title='';
    }
    else
    {
        $title = com_db_input($title);
    }
    //echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
    //$revenew_raw_arr = explode(" ",$_REQUEST['selected_filters']);
    
    if(isset($_POST['remove_email_btn']) && $_POST['remove_email_btn'] == 1)
        $hide_email_btn = 1;
    else
        $hide_email_btn = 0;
    //die();
    //echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";
    $type = $_POST['management'];
    if($type=='Any')
    {
        $type='';
    }
    else
    {
        //echo "<br> select id from ".TABLE_MANAGEMENT_CHANGE." where id=".com_db_input($type)."";
        $type = com_db_GetValue('select id from '.TABLE_MANAGEMENT_CHANGE." where id='".com_db_input($type)."'");
    }
    //echo "<br>Type: ".$type;
    
    $country = $_POST['country'];
    if($country=='Any')
    {
        $country='';
    }
    else
    {
        $country = com_db_GetValue('select countries_id from '.TABLE_COUNTRIES." where countries_name='".com_db_input($country)."'");
    }

    //$state = $_POST['state'];
    $state = '';
    $state_arr			= $_POST['state'];
    if(sizeof($state_arr)>0 && $state_arr[0] !='')
    {
        $state_id_arr = implode(",",$state_arr);
        $stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
        $stateResult = com_db_query($stateQuery);
        $state_list = '';
        while($stateRow = com_db_fetch_array($stateResult))
        {
            if($state_list=='')
            {
                $state_list = $stateRow['short_name'];
            }
            else
            {
                $state_list .= "<br>". $stateRow['short_name'];
            }
        }
    } 
    $state = $state_id_arr;


    $city = trim($_POST['city']);

    $zip_code = $_POST['zip_code'];
    if($zip_code =='Zip Code'){
            $zip_code = '';
    }
    $company = trim($_POST['company']);
    if($company =='e.g. Microsoft'){
            $company ='';
    }
    $rep   = array("\r\n", "\n","\r");
    $company_website	= str_replace($rep, "<br />", $_POST['company_website']);
    $industry = $_POST['industry'];
    $industry_arr		= $_POST['industry'];
    if(sizeof($industry_arr)>0 && $industry_arr[0] !='')
    {
        $industry_id_arr = implode(",",$industry_arr);
        $industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
        $industryResult = com_db_query($industryQuery);
        $industry_list = '';
        while($industryRow = com_db_fetch_array($industryResult))
        {
            if($industry_list=='')
            {
                $industry_list = $industryRow['title'];
            }
            else
            {
                $industry_list .= "<br>". $industryRow['title'];
            }
        }
    }
    $industry = $industry_id_arr;

    
    $selected_filters_raw = explode(":", $_POST['selected_filters']);
    //echo "<pr>selected_filters_raw: ";   print_r($selected_filters_raw);   echo "</pre>";
    $revenue_size_raw = $selected_filters_raw[10];
    //$revenue_size_raw = implode(",", $_POST['revenue_size']);
    $revenue_size = $_POST['revenue_size'];
    //echo "<br>FA revenue_size_raw:".$revenue_size_raw;
    //echo "<br>FA revenue_size before:".$revenue_size;
    //echo "<pre>bfore revenue_size: ";   print_r($revenue_size);   echo "</pre>";
    //die();
    $revenue_size_arr	= $_POST['revenue_size'];
    if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !='')
    {
        $revenue_size_id_arr = implode(",",$revenue_size_arr);
        $revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
        $revenueResult = com_db_query($revenueQuery);
        $revenue_size_list = '';
        while($revenueRow = com_db_fetch_array($revenueResult))
        {
            if($revenue_size_list=='')
            {
                $revenue_size_list = $revenueRow['name'];
            }
            else
            {
                $revenue_size_list .= "<br>". $revenueRow['name'];
            }
        }
    }
    $revenue_size = $revenue_size_id_arr;
    //echo "<br>FA revenue_size after:".$revenue_size;

    $employee_size = $_POST['employee_size'];


    $employee_size_arr	= $_POST['employee_size'];
    if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !='')
    {
        $employee_size_id_arr = implode(",",$employee_size_arr);
        $employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
        $employeeResult = com_db_query($employeeQuery);
        $employeee_size_list = '';
        while($employeeRow = com_db_fetch_array($employeeResult))
        {
            if($employee_size_list=='')
            {
                $employee_size_list = $employeeRow['name'];
            }
            else
            {
                $employee_size_list .= "<br>". $employeeRow['name'];
            }
        }
    }
    $employee_size = $employee_size_id_arr;

    
    $chief_level = "";
    $vp_level = "";
    $director_level = "";
    
    //echo "<br>chief_title_level:".$_POST['chief_title_level'];
    //echo "<br>vp_title_level:".$_POST['vp_title_level'];
    //echo "<br>director_title_level:".$_POST['director_title_level'];
    //die();
    //if(isset($_POST['title_level']) && $_POST['title_level'] != '')
    //{
        if(strpos($_POST['chief_title_level'],'chief') > -1)
            $chief_level = 1;
        if(strpos($_POST['vp_title_level'],'vp') > -1)
            $vp_level = 1;
        if(strpos($_POST['director_title_level'],'director') > -1)
            $director_level = 1;
                
    //}
    
    
    
    

    $mgtchanges = $_POST['mgtchanges'];

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

    // Added on 5th March to handle alerts for ciso/clo bundle user
    $alert_site = "";
    if(strpos($_SESSION['combine_site'],'/') > -1)
    {
        if($_SESSION['site'] != '')
            $alert_site = $_SESSION['site'];
    }        
    
    $selected_alert = $_POST['selected_alert'];
    if($selected_alert == '')
    {
        //$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
        $alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,mgt_change,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date,raw_revenue,chief_level,vp_level,director_level,alert_site,hide_submit_button) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$mgtchanges','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date','$revenue_size_raw','$chief_level','$vp_level','$director_level','$alert_site','$hide_email_btn')";
        $action_msg = 'added';
    }
    elseif($selected_alert > 0)
    {
        $alert_query = "UPDATE " . TABLE_ALERT . " set title = '$title',type = '$type',country = '$country',state = '$state',city = '$city',zip_code = '$zip_code',company = '$company',company_website = '$company_website',industry_id = '$industry',revenue_size = '$revenue_size',employee_size = '$employee_size',delivery_schedule = '$delivery_schedule',mgt_change = '$mgtchanges',speaking = '$speaking',awards = '$awards',publication = '$publication',media_mention = '$media_mentions',board = '$board',jobs = '$jobs',fundings = '$fundings',chief_level='$chief_level',vp_level='$vp_level',director_level='$director_level',hide_submit_button='$hide_email_btn' where alert_id = $selected_alert";
        $action_msg = 'updated';
    }    
    //echo "<br>FA alert_query:".$alert_query;
    //die();  
    com_db_query($alert_query);
    $alert_id = com_db_insert_id();

    // Adding alert to next Execfile
    $new_exec = mysqli_connect("10.132.233.66","cfo2","cV!kJ201Ze","hre2") or die("Database 3 ERROR ");
    mysqli_query($new_exec,$alert_query);
    mysqli_close($new_exec);
    
    
    
    $url = 'alert.php?action='.$action_msg;
    com_redirect($url);
}

?>