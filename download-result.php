<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
session_start();
ob_start();
include("config.php");
include("functions.php");
$filter_arr = explode(":",$_POST['selected_filters_hidden']);
$all_data_count = "";
$all_data = get_all_data('',$filter_arr[0],$filter_arr[1],$filter_arr[2],$filter_arr[3],$filter_arr[4],$filter_arr[5],$filter_arr[6],$filter_arr[7],$filter_arr[8],$filter_arr[9],$filter_arr[10],$filter_arr[11],"file");
$all_data_count = count($all_data);
//echo "<pre>all_data DL: ";   print_r($all_data);   echo "</pre>";  
$speaking_array = array();
$awards_array = array();
$publication_array = array();
$media_array = array();
$movement_array = array();
$funding_array = array();
$jobs_array = array();
        
$speaking_count = 0;
$awards_count = 0;
$publication_count = 0;
$media_count = 0;
$movement_count = 0;
$funding_count = 0;
$jobs_count = 0;

$country = 'United States';
//$movement_type = 'Appointments';


$download_info_query = "insert into " . TABLE_DOWNLOAD . "(user_id,add_date) values ('".$_SESSION['sess_user_id']."','".date('Y-m-d')."')";
com_db_query($download_info_query);


for($v=0;$v<=$all_data_count;$v++)
{
    if($all_data[$v]['type'] == 'speaking')
    {
        $speaking_array[$speaking_count]['personal_id'] = $all_data[$v]['personal_id'];
        $speaking_array[$speaking_count]['title'] = $all_data[$v]['title'];
        $speaking_array[$speaking_count]['speaking_link'] = $all_data[$v]['speaking_link'];
        $speaking_array[$speaking_count]['event'] = $all_data[$v]['event'];
        $speaking_array[$speaking_count]['event_date'] = $all_data[$v]['event_date'];
        $speaking_array[$speaking_count]['company_name'] = $all_data[$v]['company_name'];
        $speaking_array[$speaking_count]['company_website'] = $all_data[$v]['company_website'];
        
        $comp_revenue = "";
        if($all_data[$v]['revenue_name'] != '')
            $comp_revenue = $all_data[$v]['revenue_name'];
        elseif($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        
        if($all_data[$v]['employee_size_name'] != '')
            $comp_emp_size = $all_data[$v]['employee_size_name'];
        elseif($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        
        $speaking_array[$speaking_count]['company_revenue'] = $comp_revenue;
        $speaking_array[$speaking_count]['company_employee'] = $comp_emp_size;
        $speaking_array[$speaking_count]['address'] = $all_data[$v]['address'];
        $speaking_array[$speaking_count]['address2'] = $all_data[$v]['address2'];
        $speaking_array[$speaking_count]['city'] = $all_data[$v]['city'];
        $speaking_array[$speaking_count]['zip_code'] = $all_data[$v]['zip_code'];
        $speaking_array[$speaking_count]['email'] = $all_data[$v]['email'];
        $speaking_array[$speaking_count]['phone'] = $all_data[$v]['phone'];
        $speaking_array[$speaking_count]['first_name'] = $all_data[$v]['first_name'];
        $speaking_array[$speaking_count]['last_name'] = $all_data[$v]['last_name'];
        
        $speaking_array[$speaking_count]['role'] = $all_data[$v]['role'];
        $speaking_array[$speaking_count]['topic'] = $all_data[$v]['topic'];
        
        if($all_data[$v]['industry_name'] != '')
            $speaking_array[$speaking_count]['industry_title'] = $all_data[$v]['industry_name'];
        else
            $speaking_array[$speaking_count]['industry_title'] = $all_data[$v]['industry_title'];
        
        if($all_data[$v]['state_name'] != '')
            $speaking_array[$speaking_count]['state_short'] = $all_data[$v]['state_name'];
        else
            $speaking_array[$speaking_count]['state_short'] = $all_data[$v]['state_short'];
        $speaking_count++;
    }
    elseif($all_data[$v]['type'] == 'awards')
    {
        $awards_array[$awards_count]['personal_id'] = $all_data[$v]['personal_id'];
        $awards_array[$awards_count]['title'] = $all_data[$v]['title'];
        $awards_array[$awards_count]['awards_link'] = $all_data[$v]['awards_link'];
        $awards_array[$awards_count]['awards_title'] = $all_data[$v]['awards_title'];
        $awards_array[$awards_count]['awards_date'] = $all_data[$v]['awards_date'];
        
        $comp_revenue = "";
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        if($comp_revenue == '')
            $comp_revenue = $all_data[$v]['revenue_name'];
        
        
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        if($comp_emp_size == '')
            $comp_emp_size = $all_data[$v]['employee_size_name'];
        
        
        $awards_array[$awards_count]['company_name'] = $all_data[$v]['company_name'];
        $awards_array[$awards_count]['company_website'] = $all_data[$v]['company_website'];
        $awards_array[$awards_count]['company_revenue'] = $comp_revenue;
        $awards_array[$awards_count]['company_employee'] = $comp_emp_size;
        $awards_array[$awards_count]['address'] = $all_data[$v]['address'];
        $awards_array[$awards_count]['address2'] = $all_data[$v]['address2'];
        $awards_array[$awards_count]['city'] = $all_data[$v]['city'];
        $awards_array[$awards_count]['zip_code'] = $all_data[$v]['zip_code'];
        $awards_array[$awards_count]['email'] = $all_data[$v]['email'];
        $awards_array[$awards_count]['phone'] = $all_data[$v]['phone'];
        $awards_array[$awards_count]['first_name'] = $all_data[$v]['first_name'];
        $awards_array[$awards_count]['last_name'] = $all_data[$v]['last_name'];
        
        $awards_array[$awards_count]['awards_title'] = $all_data[$v]['awards_title'];
        $awards_array[$awards_count]['awards_given_by'] = $all_data[$v]['awards_given_by'];
        $awards_array[$awards_count]['awards_date'] = $all_data[$v]['awards_date'];
        $awards_array[$awards_count]['awards_link'] = $all_data[$v]['awards_link'];
        
        $awards_array[$awards_count]['industry_title'] = $all_data[$v]['industry_title'];
        $awards_array[$awards_count]['state_short'] = $all_data[$v]['state_short'];
        
        $awards_count++;
    }
    
    elseif($all_data[$v]['type'] == 'publication')
    {
        $publication_array[$publication_count]['personal_id'] = $all_data[$v]['personal_id'];
        $publication_array[$publication_count]['title'] = $all_data[$v]['title'];
        $publication_array[$publication_count]['awards_link'] = $all_data[$v]['awards_link'];
        $publication_array[$publication_count]['awards_title'] = $all_data[$v]['awards_title'];
        $publication_array[$publication_count]['awards_date'] = $all_data[$v]['awards_date'];
        
        $comp_revenue = "";
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        
        $publication_array[$publication_count]['company_name'] = $all_data[$v]['company_name'];
        $publication_array[$publication_count]['company_website'] = $all_data[$v]['company_website'];
        $publication_array[$publication_count]['company_revenue'] = $comp_revenue;
        $publication_array[$publication_count]['company_employee'] = $comp_emp_size;
        $publication_array[$publication_count]['address'] = $all_data[$v]['address'];
        $publication_array[$publication_count]['address2'] = $all_data[$v]['address2'];
        $publication_array[$publication_count]['city'] = $all_data[$v]['city'];
        $publication_array[$publication_count]['zip_code'] = $all_data[$v]['zip_code'];
        $publication_array[$publication_count]['email'] = $all_data[$v]['email'];
        $publication_array[$publication_count]['phone'] = $all_data[$v]['phone'];
        $publication_array[$publication_count]['first_name'] = $all_data[$v]['first_name'];
        $publication_array[$publication_count]['last_name'] = $all_data[$v]['last_name'];
        
        $publication_array[$publication_count]['title'] = $all_data[$v]['title'];
        $publication_array[$publication_count]['publication_date'] = $all_data[$v]['publication_date'];
        $publication_array[$publication_count]['link'] = $all_data[$v]['link'];
        
        $publication_array[$publication_count]['industry_title'] = $all_data[$v]['industry_title'];
        $publication_array[$publication_count]['state_short'] = $all_data[$v]['state_short'];
        $publication_count++;
    }
    
    
    elseif($all_data[$v]['type'] == 'media_mention')
    {
        $media_array[$media_count]['title'] = $all_data[$v]['title'];
        
        $comp_revenue = "";
        //echo "<br>company_employee id: ".$all_data[$v]['company_revenue'];
        //echo "<br>revenue_name: ".$all_data[$v]['revenue_name'];
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        if($comp_revenue == '')
            $comp_revenue = $all_data[$v]['revenue_name'];
        
        
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        if($comp_emp_size == '')
            $comp_emp_size = $all_data[$v]['employee_size_name'];
        
        
        
        $media_array[$media_count]['personal_id'] = $all_data[$v]['personal_id'];
        $media_array[$media_count]['company_name'] = $all_data[$v]['company_name'];
        $media_array[$media_count]['company_website'] = $all_data[$v]['company_website'];
        $media_array[$media_count]['company_revenue'] = $comp_revenue;
        $media_array[$media_count]['company_employee'] = $comp_emp_size;
        $media_array[$media_count]['address'] = $all_data[$v]['address'];
        $media_array[$media_count]['address2'] = $all_data[$v]['address2'];
        $media_array[$media_count]['city'] = $all_data[$v]['city'];
        $media_array[$media_count]['zip_code'] = $all_data[$v]['zip_code'];
        $media_array[$media_count]['email'] = $all_data[$v]['email'];
        $media_array[$media_count]['phone'] = $all_data[$v]['phone'];
        $media_array[$media_count]['first_name'] = $all_data[$v]['first_name'];
        $media_array[$media_count]['last_name'] = $all_data[$v]['last_name'];
        
        $media_array[$media_count]['pub_date'] = $all_data[$v]['pub_date'];
        $media_array[$media_count]['quote'] = $all_data[$v]['quote'];
        $media_array[$media_count]['publication'] = $all_data[$v]['publication'];
        $media_array[$media_count]['media_link'] = $all_data[$v]['media_link'];
        
        $media_array[$media_count]['industry_title'] = $all_data[$v]['industry_title'];
        $media_array[$media_count]['state_short'] = $all_data[$v]['state_short'];
        
        $media_count++;
    }
    
    
    elseif($all_data[$v]['type'] == 'movement')
    {
        $comp_revenue = "";
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        
        $m_source = "";
        if($all_data[$v]['source_id'] != '')
            $m_source = get_source_value($all_data[$v]['source_id']);
        
        if($all_data[$v]['movement_type'] == 1)
            $movement_type = 'Appointment';
        elseif($all_data[$v]['movement_type'] == 2)
            $movement_type = 'Promotion';
        //echo "<br>Movement_type: ".$movement_type;
        
        $movement_array[$movement_count]['personal_id'] = $all_data[$v]['personal_id'];
        $movement_array[$movement_count]['title'] = $all_data[$v]['title'];
        
        $movement_array[$movement_count]['company_name'] = $all_data[$v]['company_name'];
        $movement_array[$movement_count]['company_website'] = $all_data[$v]['company_website'];
        $movement_array[$movement_count]['company_revenue'] = $comp_revenue;
        $movement_array[$movement_count]['company_employee'] = $comp_emp_size;
        $movement_array[$movement_count]['address'] = $all_data[$v]['address'];
        $movement_array[$movement_count]['address2'] = $all_data[$v]['address2'];
        $movement_array[$movement_count]['city'] = $all_data[$v]['city'];
        $movement_array[$movement_count]['zip_code'] = $all_data[$v]['zip_code'];
        $movement_array[$movement_count]['email'] = $all_data[$v]['email'];
        $movement_array[$movement_count]['phone'] = $all_data[$v]['phone'];
        $movement_array[$movement_count]['first_name'] = $all_data[$v]['first_name'];
        $movement_array[$movement_count]['last_name'] = $all_data[$v]['last_name'];
        
        $movement_array[$movement_count]['announce_date'] = $all_data[$v]['announce_date'];
        $movement_array[$movement_count]['effective_date'] = $all_data[$v]['effective_date'];
        $movement_array[$movement_count]['source'] = $m_source;
        $movement_array[$movement_count]['headline'] = $all_data[$v]['headline'];
        $movement_array[$movement_count]['full_body'] = $all_data[$v]['full_body'];
        $movement_array[$movement_count]['short_url'] = $all_data[$v]['short_url'];
        $movement_array[$movement_count]['movement_type'] = $movement_type;
        $movement_array[$movement_count]['what_happened'] = $all_data[$v]['what_happened'];
        $movement_array[$movement_count]['about_person'] = $all_data[$v]['about_person'];
        $movement_array[$movement_count]['about_company'] = $all_data[$v]['about_company'];
        $movement_array[$movement_count]['more_link'] = $all_data[$v]['more_link'];
        
        $ind_title = "";
        if($all_data[$v]['industry_id'] != '')
        {
            $ind_title = get_industry_title($all_data[$v]['industry_id']);
        }
        $movement_array[$movement_count]['industry_title'] = $ind_title;
        

        $comp_state = "";
        if($all_data[$v]['state_id'] != '')
        {
            $comp_state = get_state_title($all_data[$v]['state_id']);
        }
        $movement_array[$movement_count]['state_short'] = $comp_state;
        
        //$movement_array[$movement_count]['state_short'] = $all_data[$v]['state_short'];
        
        $movement_count++;
    }
    
    elseif($all_data[$v]['type'] == 'funding')
    {
        $comp_revenue = "";
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        if($comp_revenue == '')
            $comp_revenue = $all_data[$v]['revenue_name'];
        
        
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        if($comp_emp_size == '')
            $comp_emp_size = $all_data[$v]['employee_size_name'];
        
        $funding_array[$funding_count]['personal_id'] = $all_data[$v]['personal_id'];
        $funding_array[$funding_count]['company_name'] = $all_data[$v]['company_name'];
        $funding_array[$funding_count]['company_website'] = $all_data[$v]['company_website'];
        $funding_array[$funding_count]['company_revenue'] = $comp_revenue;
        $funding_array[$funding_count]['company_employee'] = $comp_emp_size;
        $funding_array[$funding_count]['address'] = $all_data[$v]['address'];
        $funding_array[$funding_count]['address2'] = $all_data[$v]['address2'];
        $funding_array[$funding_count]['city'] = $all_data[$v]['city'];
        $funding_array[$funding_count]['zip_code'] = $all_data[$v]['zip_code'];
        $funding_array[$funding_count]['email'] = $all_data[$v]['email'];
        $funding_array[$funding_count]['phone'] = $all_data[$v]['phone'];
        $funding_array[$funding_count]['first_name'] = $all_data[$v]['first_name'];
        $funding_array[$funding_count]['last_name'] = $all_data[$v]['last_name'];
        
        $funding_array[$funding_count]['title'] = $all_data[$v]['title'];
        
        $funding_array[$funding_count]['funding_amount'] = $all_data[$v]['funding_amount'];
        $funding_array[$funding_count]['funding_date'] = $all_data[$v]['funding_date'];
        $funding_array[$funding_count]['funding_source'] = $all_data[$v]['funding_source'];
        
        $funding_array[$funding_count]['industry_title'] = $all_data[$v]['industry_title'];
        
        $ind_title = "";
        if($all_data[$v]['industry_id'] != '')
        {
            $ind_title = get_industry_title($all_data[$v]['industry_id']);
        }
        $funding_array[$funding_count]['industry_title'] = $ind_title;
        
        
        
        $comp_state = "";
        if($all_data[$v]['state_id'] != '')
        {
            $comp_state = get_state_title($all_data[$v]['state_id']);
        }
        $funding_array[$funding_count]['state_short'] = $comp_state;
        
        
        
        //$funding_array[$funding_count]['state_short'] = $all_data[$v]['state_short'];
        
        $funding_count++;
    }
    
    elseif($all_data[$v]['type'] == 'jobs')
    {
        $comp_revenue = "";
        if($all_data[$v]['company_revenue'] != '')
            $comp_revenue = get_revenue_value($all_data[$v]['company_revenue']);
        //echo "<br>company_employee: ".$all_data[$v]['company_employee'];
        $comp_emp_size = "";
        if($all_data[$v]['company_employee'] != '')
            $comp_emp_size = get_emp_size_value($all_data[$v]['company_employee']);
        
        $jobs_array[$jobs_count]['personal_id'] = $all_data[$v]['personal_id'];
        $jobs_array[$jobs_count]['company_name'] = $all_data[$v]['company_name'];
        $jobs_array[$jobs_count]['phone'] = $all_data[$v]['phone'];
        $jobs_array[$jobs_count]['company_website'] = $all_data[$v]['company_website'];
        $jobs_array[$jobs_count]['company_revenue'] = $comp_revenue;
        $jobs_array[$jobs_count]['company_employee'] = $comp_emp_size;
        $jobs_array[$jobs_count]['address'] = $all_data[$v]['address'];
        $jobs_array[$jobs_count]['address2'] = $all_data[$v]['address2'];
        $jobs_array[$jobs_count]['city'] = $all_data[$v]['city'];
        $jobs_array[$jobs_count]['zip_code'] = $all_data[$v]['zip_code'];
        $jobs_array[$jobs_count]['email'] = $all_data[$v]['email'];
        $jobs_array[$jobs_count]['phone'] = $all_data[$v]['phone'];
        //$jobs_array[$jobs_count]['first_name'] = $all_data[$v]['first_name'];
        //$jobs_array[$jobs_count]['last_name'] = $all_data[$v]['last_name'];
        
        $jobs_array[$jobs_count]['job_title'] = $all_data[$v]['job_title'];
        $jobs_array[$jobs_count]['location'] = $all_data[$v]['location'];
        $jobs_array[$jobs_count]['post_date'] = $all_data[$v]['post_date'];
        $jobs_array[$jobs_count]['source'] = $all_data[$v]['source'];
        
        $jobs_array[$jobs_count]['industry_title'] = $all_data[$v]['industry_title'];
        $ind_title = "";
        if($all_data[$v]['industry_id'] != '')
        {
            $ind_title = get_industry_title($all_data[$v]['industry_id']);
        }
        $jobs_array[$jobs_count]['industry_title'] = $ind_title;
        
        
        $comp_state = "";
        if($all_data[$v]['state_id'] != '')
        {
            $comp_state = get_state_title($all_data[$v]['state_id']);
        }
        $jobs_array[$jobs_count]['state_short'] = $comp_state;
        
        $jobs_count++;
    }
    
}
//die();
//echo "<pre>awards_array: ";   print_r($awards_array);   echo "</pre>"; die();

$speaking_count = count($speaking_array);
$awards_count = count($awards_array);
$publication_count = count($publication_array);
$media_count = count($media_array);
$movement_count = count($movement_array);
$jobs_count = count($jobs_array);

require('php_xls.php');
$xls=new PHP_XLS();                  //create excel object
$xls->AddSheet('sheet 1');      //add a work sheet
$xls->SetActiveStyle('center');
$xlsRow = 4;
if($speaking_count > 0)
{    
    $xls->Text($xlsRow,1,"S P E A K I N G");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    $xls->Text($xlsRow,18,"Event Date");
    $xls->Text($xlsRow,19,"Role");
    $xls->Text($xlsRow,20,"Topic");
    $xls->Text($xlsRow,21,"Event");
    $xls->Text($xlsRow,22,"Link");
    //$xls->Text($xlsRow,23,"Industry ID");
    $xlsRow++;
    for($sp=0;$sp<$speaking_count;$sp++)
    {
        $xls->Text($xlsRow,1,$speaking_array[$sp]['personal_id']);
        $xls->Text($xlsRow,2,$speaking_array[$sp]['first_name']);
        $xls->Text($xlsRow,3,$speaking_array[$sp]['last_name']);
        $xls->Text($xlsRow,4,$speaking_array[$sp]['title']);
        $xls->Text($xlsRow,5,$speaking_array[$sp]['email']);
        $xls->Text($xlsRow,6,$speaking_array[$sp]['phone']);
        $xls->Text($xlsRow,7,$speaking_array[$sp]['company_name']);
        $xls->Text($xlsRow,8,$speaking_array[$sp]['company_website']);
        $xls->Text($xlsRow,9,$speaking_array[$sp]['company_revenue']);
        $xls->Text($xlsRow,10,$speaking_array[$sp]['company_employee']);
        $xls->Text($xlsRow,11,$speaking_array[$sp]['industry_title']);
        $xls->Text($xlsRow,12,$speaking_array[$sp]['address']);
        $xls->Text($xlsRow,13,$speaking_array[$sp]['address2']);
        $xls->Text($xlsRow,14,$speaking_array[$sp]['city']);
        $xls->Text($xlsRow,15,$speaking_array[$sp]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$speaking_array[$sp]['zip_code']);
        $xls->Text($xlsRow,18,$speaking_array[$sp]['event_date']);
        $xls->Text($xlsRow,19,$speaking_array[$sp]['role']);
        $xls->Text($xlsRow,20,$speaking_array[$sp]['topic']);
        $xls->Text($xlsRow,21,$speaking_array[$sp]['event']);
        $xls->Text($xlsRow,22,$speaking_array[$sp]['speaking_link']);
        //$xls->Text($xlsRow,23,$speaking_array[$sp]['industry_id']);
        $xlsRow++;
    }
}  


if($awards_count > 0)
{
    
    $xls->Text($xlsRow,1,"A W A R D S");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    
    $xls->Text($xlsRow,18,"Awards Date");
    $xls->Text($xlsRow,19,"Awards Title");
    $xls->Text($xlsRow,20,"Award Given By");
    $xls->Text($xlsRow,21,"Link");
    
    $xlsRow++;
    for($aw=0;$aw<$awards_count;$aw++)
    {
        $xls->Text($xlsRow,1,$awards_array[$aw]['personal_id']);
        $xls->Text($xlsRow,2,$awards_array[$aw]['first_name']);
        $xls->Text($xlsRow,3,$awards_array[$aw]['last_name']);
        $xls->Text($xlsRow,4,$awards_array[$aw]['title']);
        $xls->Text($xlsRow,5,$awards_array[$aw]['email']);
        $xls->Text($xlsRow,6,$awards_array[$aw]['phone']);
        $xls->Text($xlsRow,7,$awards_array[$aw]['company_name']);
        $xls->Text($xlsRow,8,$awards_array[$aw]['company_website']);
        $xls->Text($xlsRow,9,$awards_array[$aw]['company_revenue']);
        $xls->Text($xlsRow,10,$awards_array[$aw]['company_employee']);
        $xls->Text($xlsRow,11,$awards_array[$aw]['industry_title']);
        $xls->Text($xlsRow,12,$awards_array[$aw]['address']);
        $xls->Text($xlsRow,13,$awards_array[$aw]['address2']);
        $xls->Text($xlsRow,14,$awards_array[$aw]['city']);
        $xls->Text($xlsRow,15,$awards_array[$aw]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$awards_array[$aw]['zip_code']);
        
        $xls->Text($xlsRow,18,$awards_array[$aw]['awards_date']);
        $xls->Text($xlsRow,19,$awards_array[$aw]['awards_title']);
        $xls->Text($xlsRow,20,$awards_array[$aw]['awards_given_by']);
        $xls->Text($xlsRow,21,$awards_array[$aw]['awards_link']);
        $xlsRow++;
    }
}

if($publication_count > 0)
{
    $xlsRow++;
    $xls->Text($xlsRow,1,"P U B L I C A T I O N S");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    									
    $xls->Text($xlsRow,18,"Date");
    $xls->Text($xlsRow,19,"Title");
    $xls->Text($xlsRow,20,"Link");
    
    $xlsRow++;
    for($pu=0;$pu<$publication_count;$pu++)
    {
        $xls->Text($xlsRow,1,$publication_array[$pu]['personal_id']);
        $xls->Text($xlsRow,2,$publication_array[$pu]['first_name']);
        $xls->Text($xlsRow,3,$publication_array[$pu]['last_name']);
        $xls->Text($xlsRow,4,$publication_array[$pu]['title']);
        $xls->Text($xlsRow,5,$publication_array[$pu]['email']);
        $xls->Text($xlsRow,6,$publication_array[$pu]['phone']);
        $xls->Text($xlsRow,7,$publication_array[$pu]['company_name']);
        $xls->Text($xlsRow,8,$publication_array[$pu]['company_website']);
        $xls->Text($xlsRow,9,$publication_array[$pu]['company_revenue']);
        $xls->Text($xlsRow,10,$publication_array[$pu]['company_employee']);
        $xls->Text($xlsRow,11,$publication_array[$pu]['industry_title']);
        $xls->Text($xlsRow,12,$publication_array[$pu]['address']);
        $xls->Text($xlsRow,13,$publication_array[$pu]['address2']);
        $xls->Text($xlsRow,14,$publication_array[$pu]['city']);
        $xls->Text($xlsRow,15,$publication_array[$pu]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$publication_array[$pu]['zip_code']);
        
        $xls->Text($xlsRow,18,$publication_array[$pu]['publication_date']);
        $xls->Text($xlsRow,19,$publication_array[$pu]['title']);
        $xls->Text($xlsRow,20,$publication_array[$pu]['link']);
        
        $xlsRow++;
    }
}


if($media_count > 0)
{
    $xlsRow++;
    $xls->Text($xlsRow,1,"M E D I A    M E N T I O N");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    									
    $xls->Text($xlsRow,18,"Date");
    $xls->Text($xlsRow,19,"Quote");
    $xls->Text($xlsRow,20,"Publication");
    $xls->Text($xlsRow,21,"Link");
    
    $xlsRow++;
    for($mm=0;$mm<=$media_count;$mm++)
    {
        $xls->Text($xlsRow,1,$media_array[$mm]['personal_id']);
        $xls->Text($xlsRow,2,$media_array[$mm]['first_name']);
        $xls->Text($xlsRow,3,$media_array[$mm]['last_name']);
        $xls->Text($xlsRow,4,$media_array[$mm]['title']);
        $xls->Text($xlsRow,5,$media_array[$mm]['email']);
        $xls->Text($xlsRow,6,$media_array[$mm]['phone']);
        $xls->Text($xlsRow,7,$media_array[$mm]['company_name']);
        $xls->Text($xlsRow,8,$media_array[$mm]['company_website']);
        $xls->Text($xlsRow,9,$media_array[$mm]['company_revenue']);
        $xls->Text($xlsRow,10,$media_array[$mm]['company_employee']);
        $xls->Text($xlsRow,11,$media_array[$mm]['industry_title']);
        $xls->Text($xlsRow,12,$media_array[$mm]['address']);
        $xls->Text($xlsRow,13,$media_array[$mm]['address2']);
        $xls->Text($xlsRow,14,$media_array[$mm]['city']);
        $xls->Text($xlsRow,15,$media_array[$mm]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$media_array[$mm]['zip_code']);
        
        $xls->Text($xlsRow,18,$media_array[$mm]['pub_date']);
        $xls->Text($xlsRow,19,$media_array[$mm]['quote']);
        $xls->Text($xlsRow,20,$media_array[$mm]['publication']);
        $xls->Text($xlsRow,21,$media_array[$mm]['media_link']);
        
        $xlsRow++;
    }
}



if($movement_count > 0)
{
    $xlsRow++;
    $xls->Text($xlsRow,1,"M A N A G E M E N T      C H A N G E S");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    
    $xls->Text($xlsRow,18,"Announce Date");
    $xls->Text($xlsRow,19,"Effective Date");
    $xls->Text($xlsRow,20,"Source");
    $xls->Text($xlsRow,21,"Headline");
    $xls->Text($xlsRow,22,"Full Body");
    $xls->Text($xlsRow,23,"Short Url");
    $xls->Text($xlsRow,24,"Movement Type");
    $xls->Text($xlsRow,25,"What Happened");
    $xls->Text($xlsRow,26,"About Person");
    $xls->Text($xlsRow,27,"About Company");
    $xls->Text($xlsRow,28,"More Link");
    
    $xlsRow++;
    for($mo=0;$mo<$movement_count;$mo++)
    {
        $xls->Text($xlsRow,1,$movement_array[$mo]['personal_id']);
        $xls->Text($xlsRow,2,$movement_array[$mo]['first_name']);
        $xls->Text($xlsRow,3,$movement_array[$mo]['last_name']);
        $xls->Text($xlsRow,4,$movement_array[$mo]['title']);
        $xls->Text($xlsRow,5,$movement_array[$mo]['email']);
        $xls->Text($xlsRow,6,$movement_array[$mo]['phone']);
        $xls->Text($xlsRow,7,$movement_array[$mo]['company_name']);
        $xls->Text($xlsRow,8,$movement_array[$mo]['company_website']);
        $xls->Text($xlsRow,9,$movement_array[$mo]['company_revenue']);
        $xls->Text($xlsRow,10,$movement_array[$mo]['company_employee']);
        $xls->Text($xlsRow,11,$movement_array[$mo]['industry_title']);
        $xls->Text($xlsRow,12,$movement_array[$mo]['address']);
        $xls->Text($xlsRow,13,$movement_array[$mo]['address2']);
        $xls->Text($xlsRow,14,$movement_array[$mo]['city']);
        $xls->Text($xlsRow,15,$movement_array[$mo]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$movement_array[$mo]['zip_code']);
        $xls->Text($xlsRow,18,$movement_array[$mo]['announce_date']);
        $xls->Text($xlsRow,19,$movement_array[$mo]['effective_date']);
        $xls->Text($xlsRow,20,$movement_array[$mo]['source']);
        $xls->Text($xlsRow,21,$movement_array[$mo]['headline']);
        $xls->Text($xlsRow,22,$movement_array[$mo]['full_body']);
        $xls->Text($xlsRow,23,$movement_array[$mo]['short_url']);
        $xls->Text($xlsRow,24,$movement_array[$mo]['movement_type']);
        $xls->Text($xlsRow,25,$movement_array[$mo]['what_happened']);
        $xls->Text($xlsRow,26,$movement_array[$mo]['about_person']);
        $xls->Text($xlsRow,27,$movement_array[$mo]['about_company']);
        $xls->Text($xlsRow,28,$movement_array[$mo]['more_link']);
        
        $xlsRow++;
    }
}


if($funding_count > 0)
{
    $xlsRow++;
    $xls->Text($xlsRow,1,"F U N D I N G S");
    $xlsRow=$xlsRow+2;
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"First Name");
    $xls->Text($xlsRow,3,"Last Name");
    $xls->Text($xlsRow,4,"Title");
    $xls->Text($xlsRow,5,"E-Mail");
    $xls->Text($xlsRow,6,"Phone");
    $xls->Text($xlsRow,7,"Company Name");
    $xls->Text($xlsRow,8,"Company Website");
    $xls->Text($xlsRow,9,"Company Size Revenue");
    $xls->Text($xlsRow,10,"Company Size Employees");
    $xls->Text($xlsRow,11,"Company Industry");
    $xls->Text($xlsRow,12,"Address");
    $xls->Text($xlsRow,13,"Address 2");
    $xls->Text($xlsRow,14,"City");
    $xls->Text($xlsRow,15,"State");
    $xls->Text($xlsRow,16,"Country");
    $xls->Text($xlsRow,17,"Zip Code");
    
    $xls->Text($xlsRow,18,"Funding Amount");
    $xls->Text($xlsRow,19,"Funding Date");
    $xls->Text($xlsRow,20,"Funding Source");
    
    $xlsRow++;
    for($fu=0;$fu<=$funding_count;$fu++)
    {
        $xls->Text($xlsRow,1,$funding_array[$fu]['personal_id']);
        $xls->Text($xlsRow,2,$funding_array[$fu]['first_name']);
        $xls->Text($xlsRow,3,$funding_array[$fu]['last_name']);
        $xls->Text($xlsRow,4,$funding_array[$fu]['title']);
        $xls->Text($xlsRow,5,$funding_array[$fu]['email']);
        $xls->Text($xlsRow,6,$funding_array[$fu]['phone']);
        $xls->Text($xlsRow,7,$funding_array[$fu]['company_name']);
        $xls->Text($xlsRow,8,$funding_array[$fu]['company_website']);
        $xls->Text($xlsRow,9,$funding_array[$fu]['company_revenue']);
        $xls->Text($xlsRow,10,$funding_array[$fu]['company_employee']);
        $xls->Text($xlsRow,11,$funding_array[$fu]['industry_title']);
        $xls->Text($xlsRow,12,$funding_array[$fu]['address']);
        $xls->Text($xlsRow,13,$funding_array[$fu]['address2']);
        $xls->Text($xlsRow,14,$funding_array[$fu]['city']);
        $xls->Text($xlsRow,15,$funding_array[$fu]['state_short']);
        $xls->Text($xlsRow,16,$country);
        $xls->Text($xlsRow,17,$funding_array[$fu]['zip_code']);
        
        $xls->Text($xlsRow,18,$funding_array[$fu]['funding_amount']);
        $xls->Text($xlsRow,19,$funding_array[$fu]['funding_date']);
        $xls->Text($xlsRow,20,$funding_array[$fu]['funding_source']);
        
        $xlsRow++;
    }
}


if($jobs_count > 0)
{
    $xlsRow++;
    $xls->Text($xlsRow,1,"J O B S");
    $xlsRow=$xlsRow+2;
    //$xls->Text($xlsRow,1,"First Name");
    //$xls->Text($xlsRow,2,"Last Name");
    //$xls->Text($xlsRow,3,"Title");
    //$xls->Text($xlsRow,4,"E-Mail");
    $xls->Text($xlsRow,1,"Personal Unique ID");
    $xls->Text($xlsRow,2,"Company Name");
    $xls->Text($xlsRow,3,"Phone");
    
    $xls->Text($xlsRow,4,"Company Website");
    $xls->Text($xlsRow,5,"Company Size Revenue");
    $xls->Text($xlsRow,6,"Company Size Employees");
    $xls->Text($xlsRow,7,"Company Industry");
    $xls->Text($xlsRow,8,"Address");
    $xls->Text($xlsRow,9,"Address 2");
    $xls->Text($xlsRow,10,"City");
    $xls->Text($xlsRow,11,"State");
    $xls->Text($xlsRow,12,"Country");
    $xls->Text($xlsRow,13,"Zip Code");
    
    $xls->Text($xlsRow,14,"Job Title");
    $xls->Text($xlsRow,15,"Job Location");
    $xls->Text($xlsRow,16,"Job Post Date");
    $xls->Text($xlsRow,17,"Job Source");
    
    $xlsRow++;
    for($jo=0;$jo<=$jobs_count;$jo++)
    {
        //$xls->Text($xlsRow,1,$jobs_array[$jo]['first_name']);
        //$xls->Text($xlsRow,2,$jobs_array[$jo]['last_name']);
        $xls->Text($xlsRow,1,$jobs_array[$jo]['personal_id']);
        $xls->Text($xlsRow,2,$jobs_array[$jo]['company_name']);
        //$xls->Text($xlsRow,3,$jobs_array[$jo]['title']);
        //$xls->Text($xlsRow,4,$jobs_array[$jo]['email']);
        $xls->Text($xlsRow,3,$jobs_array[$jo]['phone']);
        
        $xls->Text($xlsRow,4,$jobs_array[$jo]['company_website']);
        $xls->Text($xlsRow,5,$jobs_array[$jo]['company_revenue']);
        $xls->Text($xlsRow,6,$jobs_array[$jo]['company_employee']);
        
        //$xls->Text($xlsRow,7,$jobs_array[$jo]['industry_title']);
        $xls->Text($xlsRow,7,$jobs_array[$jo]['industry_title']);
        
        $xls->Text($xlsRow,8,$jobs_array[$jo]['address']);
        $xls->Text($xlsRow,9,$jobs_array[$jo]['address2']);
        $xls->Text($xlsRow,10,$jobs_array[$jo]['city']);
        $xls->Text($xlsRow,11,$jobs_array[$jo]['state_short']);
        $xls->Text($xlsRow,12,$country);
        $xls->Text($xlsRow,13,$jobs_array[$jo]['zip_code']);
        
        $xls->Text($xlsRow,14,$jobs_array[$jo]['job_title']);
        $xls->Text($xlsRow,15,$jobs_array[$jo]['location']);
        $xls->Text($xlsRow,16,$jobs_array[$jo]['post_date']);
        $xls->Text($xlsRow,17,$jobs_array[$jo]['source']);
        
        $xlsRow++;
    }
}


ob_end_clean();
$xls->Output('search-result-'. date('m-d-Y') . '.xls');	
ob_end_flush(); 
?>