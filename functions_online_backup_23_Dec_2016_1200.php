<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//UNDO FA

function get_hr_complete_data()
{
    $hre = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    
    /*
    $main_query = "SELECT * 
        FROM (
        SELECT ps.add_date AS add_date,  'speaking' as record_type,speaking_id AS col1, first_name AS col2,last_name as col4,personal_image as col5,event as col6,event_date as col7,'' as col8 
        FROM hre_personal_master as pm,hre_personal_speaking as ps
        UNION ALL 
        SELECT pa.add_date AS add_date,  'award' as record_type,awards_id AS col1, first_name AS col2,last_name as col4,personal_image as col5,pa.awards_title as col6,pa.awards_given_by as col7,pa.awards_date as col8
        FROM hre_personal_master as pm,hre_personal_awards as pa
        )a
        ORDER BY add_date DESC 
        LIMIT 0 , 10";
    */
    
    $main_query = "SELECT * 
        FROM (
        SELECT ps.add_date AS add_date,  'speaking' as record_type,speaking_id AS col1, first_name AS col2,last_name as col4,personal_image as col5,event as col6,event_date as col7,'' as col8 
        FROM hre_personal_master as pm,hre_personal_speaking as ps
        UNION 
        SELECT pa.add_date AS add_date,  'award' as record_type,awards_id AS col1, first_name AS col2,last_name as col4,personal_image as col5,pa.awards_title as col6,pa.awards_given_by as col7,pa.awards_date as col8
        FROM hre_personal_master as pm,hre_personal_awards as pa
        )a
        ORDER BY add_date DESC 
        LIMIT 0 , 10";
    
    
    echo "<br>main_query: ".$main_query; die();
    $indResult = mysql_query($main_query);
    
    
    
    while($indRow = mysql_fetch_array($indResult))
    {
        echo "<br>".$type = $indRow['record_type'];
    }
    die();
    
}


// Define the custom sort function
function custom_sort($a,$b) 
{
    //return trim($a['add_date'])>trim($b['add_date']);
    return trim($a['add_date'])<trim($b['add_date']);
}


function type_sort($a,$b) 
{
    //return trim($a['add_date'])>trim($b['add_date']);
    return trim($a['type'])<trim($b['type']);
}


function update_user_counts($unread_movements_count,$unread_speaking_count,$unread_media_count,$unread_award_count,$unread_publication_count,$unread_funding_count,$unread_job_count)
{
    if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
    {    
        $this_user = $_SESSION['sess_user_id'];
        
        //echo "<br>DELETE INSERT<br>";
        //echo "DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user;
        //echo "<br>";
        //echo "INSERT INTO ".TABLE_COUNT."(user_count,record_type,user_id) values('".$unread_movements_count."',record_type='movement',user_id = ".$this_user.")";
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='movement' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_movements_count.",'movement',".$this_user.")");	
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='speaking' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_speaking_count.",'speaking',".$this_user.")");	
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='media' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_media_count.",'media',".$this_user.")");	
        
        //com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='media' and user_id = ".$this_user);	
        //com_db_query("INSERT INTO ".TABLE_COUNT."(user_count,record_type,user_id) values(".$unread_media_count.",'media',".$this_user.")");	
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='awards' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_award_count.",'awards',".$this_user.")");	
        
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='publication' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_publication_count.",'publication',".$this_user.")");	
        
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='funding' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_funding_count.",'funding',".$this_user.")");	
        
        
        com_db_query("DELETE FROM ".TABLE_SESSION_COUNT." where record_type='jobs' and user_id = ".$this_user);	
        com_db_query("INSERT INTO ".TABLE_SESSION_COUNT."(session_counts,record_type,user_id) values(".$unread_job_count.",'jobs',".$this_user.")");	
        
        
        /*
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='speaking' and user_id = ".$this_user);	
        com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_speaking_count."' where record_type='speaking' and user_id = ".$this_user);	
        
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user);	
        $media_update = com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_media_count."' where record_type='media' and user_id = ".$this_user);	
        //echo "<br>media_update: ".$media_update;
        
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user);	
        com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_award_count."' where record_type='awards' and user_id = ".$this_user);	
        
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user);	
        com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_publication_count."' where record_type='publication' and user_id = ".$this_user);	
        
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user);	
        com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_funding_count."' where record_type='funding' and user_id = ".$this_user);	
        
        com_db_query("DELETE FROM ".TABLE_COUNT." where record_type='movement' and user_id = ".$this_user);	
        com_db_query("UPDATE ".TABLE_COUNT." set user_count='".$unread_job_count."' where record_type='jobs' and user_id = ".$this_user);	
        */ 
        
        
        //com_db_query("INSERT INTO ".TABLE_COUNT."(record_type,user_id,user_count) values('movement','".$this_user."','".$unread_movements_count."') set user_count='".$unread_movements_count."' where record_type='movement' and user_id = ".$this_user);	
        
        
    }    
}





function get_all_data($id='',$type='',$func = '',$from_date = '',$to_date='',$zip='',$searchnow = '',$city = '',$company = '',$industries_ids = '',$state_ids ='',$revenue = '',$employee_size = '',$display_type = '')
{
    //echo "<br>searchnow: ".$id;
    //echo "<br>Type: ".$type;
    
    //echo "<br>LAST PAGE: ".$_SERVER['HTTP_REFERER'];
    //$show_time = 1;
    global $total_count_without_where;
    global $movement_count;
    //global $appointment_count;
    global $speaking_count;
    global $media_count;
    global $publication_count;
    global $award_count;
    global $funding_count;
    global $job_count;
    global $login_page_flow;
    global $filtered_count;
    
    global $speaking_last_id_db;
    //$total_count_without_where = 104;
    //echo "<pre>SERVER: ";   print_r($_SERVER);   echo "</pre>";
    //echo "<br>HTTP_REFERER: ".$_SERVER['HTTP_REFERER'];/home.php?
    //if(strpos($_SERVER['HTTP_REFERER'],'login.php') > -1)
    //if(strpos($_SERVER['HTTP_REFERER'],'.com/home.php') > -1)
    $sort_by_add_dates = 0;
    if((strpos($_SERVER['HTTP_REFERER'],'login.php') > -1 || $login_page_flow == 1)  && $_GET['def_l'] != '1')
    {
        $login_page_flow = 1;
        //echo "<br>login_page_flow within func: ".$login_page_flow; 
        $from_date  =   subDate('5');
        //$from_date = '2016-01-05';
        $to_date = date('Y-m-j');   //'2016-01-25';
        
        $count_date_range = "";
        
        $sort_by_add_dates = 1;
        
    }        
    
    $count_lower_limit = subDate('90');
    $future_30_days  =   addDate('30');
    //die();
    //echo "<br>from_date: ".$from_date;
    //echo "<br>to_date: ".$to_date;
    
    
    //com_db_connect() or die('Unable to connect to database server!');
    com_db_connect_hre2() or die('Unable to connect to database server!');
    
    $move_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'");
    //echo "<br>FAR move_last_id_db: ".$move_last_id_db; 
    //echo "<br>Speaking last id Q: select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'";
    $speaking_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'");
    //echo "<br>speaking_last_id_db: ".$speaking_last_id_db; die();
    
    $media_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'media'");
    
    $awards_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'awards'");
    
    $publication_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'publication'");
    
    $funding_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'funding'");
    
    $jobs_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'jobs'");
    //echo "<br>Funding Q: select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'funding'";
    //echo "<br>Funding_last_id_db: ".$funding_last_id_db;
    
    //$func = 'cmo';
    
    
    if($func == '' || $func == 'hr')
    {
        //echo "<br>In HR";
        // Below line commented on 23 May 2016
        //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
        //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        // Execfile file DB configuration
        $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        
        $table_personal_master          = "hre_personal_master";
        $table_personal_speaking        = "hre_personal_speaking";
        $table_movement_master          = "hre_movement_master";
        $table_company_master           = "hre_company_master";
        $table_personal_awards          = "hre_personal_awards";
        $table_personal_media_mention   = "hre_personal_media_mention";
        $table_personal_publication     = "hre_personal_publication";
        $table_management_change        = "hre_management_change";
        $table_company_job              = "hre_company_job_info";
        $table_company_funding          = "hre_company_funding";
        $table_company_industry         = "hre_industry";
        $table_company_state            = "hre_state";
        
        $table_search_data            = "hre_search_data";
        
    }
    elseif($func == 'cto' || $func == 'ciso')
    {
        //$site = mysql_connect(CTO_SERVER_IP,CTO_DB_USER_NAME,CTO_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
        //mysql_select_db("ctou2",$site) or die ("ERROR: Database not found ");
        //echo "<br>In CTO";
        $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "cto_personal_master";
        $table_personal_speaking        = "cto_personal_speaking";
        $table_movement_master          = "cto_movement_master";
        $table_company_master           = "hre_company_master";
        $table_personal_awards          = "cto_personal_awards";
        $table_personal_media_mention   = "cto_personal_media_mention";
        $table_personal_publication     = "cto_personal_publication";
        $table_management_change        = "hre_management_change";
        $table_company_job              = "cto_company_job_info";
        $table_company_funding          = "cto_company_funding";
        $table_company_industry         = "hre_industry";
        $table_company_state            = "hre_state";
        
        $table_search_data            = "cto_search_data";
    }
    elseif($func == 'cfo')
    {
        
        //$site = mysql_connect("10.132.233.66","cfo2","cV!kJ201Ze",TRUE) or die("Database ERROR ");
        //mysql_select_db("cfo2",$site) or die ("ERROR: Database not found ");
        
        $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "cfo_personal_master";
        $table_personal_speaking        = "cfo_personal_speaking";
        $table_movement_master          = "cfo_movement_master";
        $table_company_master           = "hre_company_master";
        $table_personal_awards          = "cfo_personal_awards";
        $table_personal_media_mention   = "cfo_personal_media_mention";
        $table_personal_publication     = "cfo_personal_publication";
        $table_management_change        = "hre_management_change";
        $table_company_job              = "cfo_company_job_info";
        $table_company_funding          = "cfo_company_funding";
        $table_company_industry         = "hre_industry";
        $table_company_state            = "hre_state";
        
        $table_search_data            = "cfo_search_data";
    }
    elseif($func == 'cmo'  || $func == 'cso')
    {
        //echo "<br>In CMO";
        //$site = mysql_connect("10.132.232.238","cmo1","mocos!cm123",TRUE) or die("Database ERROR ");
        //mysql_select_db("cmo1",$site) or die ("ERROR: Database not found ");
        
        $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        
        $table_personal_master          = "cmo_personal_master";
        $table_personal_speaking        = "cmo_personal_speaking";
        $table_movement_master          = "cmo_movement_master";
        $table_company_master           = "hre_company_master"; //"cmo_company_master";
        $table_personal_awards          = "cmo_personal_awards";
        $table_personal_media_mention   = "cmo_personal_media_mention";
        $table_personal_publication     = "cmo_personal_publication";
        $table_management_change        = "cmo_management_change";
        $table_company_job              = "cmo_company_job_info";
        $table_company_funding          = "cmo_company_funding";
        $table_company_industry         = "hre_industry"; //"cmo_industry";
        $table_company_state            = "hre_state"; //cmo_state";
        
        $table_search_data            = "cmo_search_data";
    }
    elseif($func == 'clo')
    {
        //$site = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
        //mysql_select_db("clo2",$site) or die ("ERROR: Database not found ");
        
        $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "clo_personal_master";
        $table_personal_speaking        = "clo_personal_speaking";
        $table_movement_master          = "clo_movement_master";
        $table_company_master           = "hre_company_master";
        $table_personal_awards          = "clo_personal_awards";
        $table_personal_media_mention   = "clo_personal_media_mention";
        $table_personal_publication     = "clo_personal_publication";
        $table_management_change        = "clo_management_change";
        $table_company_job              = "clo_company_job_info";
        $table_company_funding          = "clo_company_funding";
        $table_company_industry         = "hre_industry";
        $table_company_state            = "hre_state";
        
        $table_search_data            = "clo_search_data";
    }
    
    
    $data_arr = array();
    $data = 0;
    
    
    $revenue_ids = "";
    $revenue_clause = "";
    
    $state_clause = "";
    $industries_clause = "";
    
    if($revenue != '')        
    {
        if(strpos($revenue,",") > -1)
        {        
            $revenue_limits = explode(",", $revenue);

            $new_revenue_id = "";
            if($revenue_limits[0] < $revenue_limits[1])
            {
                $initial_revenue_id = 2;
                for($r=$revenue_limits[0];$r<=$revenue_limits[1];$r++)
                {
                    $new_revenue_id = $r+$initial_revenue_id;
                    $revenue_ids .= $new_revenue_id.",";
                }
            }
            $revenue_ids = trim($revenue_ids,","); 
        }
        else
            $revenue_ids = $revenue;
        $revenue_clause .= " and company_revenue in (".$revenue_ids.")";
    } 

    
    if($zip != '')
    {
        $zip_clause = " and zip_code = '".$zip."'";
    }
    
    if($city != '')
    {
        $city_clause = " and city = '".$city."'";
    }

    if($searchnow != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        
        //$company_personal_clause = " and cm.company_name = '".$searchnow."'";
        
        $personal_name_arr = explode(" ",$searchnow);
        $searched_first_name = trim($personal_name_arr[0]);
        if($personal_name_arr[1] != '')
            $company_personal_clause = " and (company_name = '".$searchnow."' OR (first_name = '".$searched_first_name."' and last_name = '".$personal_name_arr[1]."'))";
         else    
            $company_personal_clause = " and (company_name = '".$searchnow."' OR first_name = '".$searched_first_name."')";
        
      //  if($type == '')
      //      $type = 'all';
    }
    
    if($company != '')
    {    
        $web_arr = array();
        $web_arr = explode("<br />",$company);
        if(count($web_arr) > 0)
        {
            $company_personal_clause = " and (company_website in (";
            foreach($web_arr as $ind => $web_value)
            {
                //$array = preg_split('/\s*\R\s*/m', trim($web_value), NULL, PREG_SPLIT_NO_EMPTY);

                $web_value = nl2br($web_value);
                //echo "<br>web_value: ".$web_value;
                $web_value = trim($web_value);
                //$web_value = str_replace('<br>','',$web_value);
                $company_personal_clause .= "'".$web_value."',"; 
            }
            $company_personal_clause .= ")";
            $company_personal_clause = str_replace(',)',')',$company_personal_clause);
            
            
            
            $company_personal_clause .= " or company_urls in (";
            foreach($web_arr as $ind => $web_value)
            {
                //$array = preg_split('/\s*\R\s*/m', trim($web_value), NULL, PREG_SPLIT_NO_EMPTY);

                $web_value = nl2br($web_value);
                //echo "<br>web_value: ".$web_value;
                $web_value = trim($web_value);
                //$web_value = str_replace('<br>','',$web_value);
                $company_personal_clause .= "'".$web_value."',"; 
            }
            $company_personal_clause .= ")";
            $company_personal_clause = str_replace(',)',')',$company_personal_clause);
            
            
            
            $company_personal_clause .= ")";
            
            
            
            //$company_personal_clause .= " or company_name in (";
            //foreach($web_arr as $ind => $web_value)
            //{
                //$array = preg_split('/\s*\R\s*/m', trim($web_value), NULL, PREG_SPLIT_NO_EMPTY);

             //   $web_value = nl2br($web_value);
                //echo "<br>web_value: ".$web_value;
             //   $web_value = trim($web_value);
                //$web_value = str_replace('<br>','',$web_value);
            //    $company_personal_clause .= "'".$web_value."',"; 
            //}
            //$company_personal_clause .= ")";
            
            $company_personal_clause = str_replace(',)',')',$company_personal_clause);
            //$company_personal_clause = str_replace('<br>','',$company_personal_clause);
        }    
        elseif($company != '')
        {
            //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
            $company_personal_clause = " and (company_name = '".$company."' || company_website = '".$company."' || company_urls = '".$company."')";
        }
    }    
    //echo "<br>industries_ids FIRST: ".$industries_ids;
    
    if($industries_ids != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $industries_clause = " and industry_id in (".$industries_ids.")";
    }
    //echo "<br>industries_clause FIRST: ".$industries_clause;
    if($state_ids != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $state_clause = " and state in (".$state_ids.")";
    }

    // Employee Size
    $employee_size_ids = "";
    $employee_size_clause = "";
    if($employee_size != '')        
    {
        $employee_size_limits = explode(",", $employee_size);

        $new_employee_size_id = "";
        if($employee_size_limits[0] < $employee_size_limits[1])
        {
            //$initial_revenue_id = 0;
            for($r=$employee_size_limits[0];$r<=$employee_size_limits[1];$r++)
            {
                $new_employee_size_id = $r;
                $employee_size_ids .= $new_employee_size_id.",";
            }
        }
        $employee_size_ids = trim($employee_size_ids,","); 
        $employee_size_clause .= " and company_employee in (".$employee_size_ids.")";
    }
    
    
    $ciso_clause = "";
    if($func == 'ciso')
    {
        $ciso_clause = " and ciso_user = 1";
    } 
    
    $cso_clause = "";
    if($func == 'cso')
    {
        $cso_clause = " and cmo_user = 1";
    } 
    
    
    
    if($type == 'movements' || $type == 'all' || strpos($type,"movements") > -1)        
    {
        //$limit_clause = " LIMIT 0,200";
        if($city != '' || $company != '' || $industries_ids != '' || $state_ids != '' || $revenue != '' || $employee_size != '' || $to_date != '' || $from_date != ''|| $zip != '')
            $limit_clause = "";
        $limit_clause = " LiMIT 30";
        if($display_type == 'file')
            $limit_clause = " LIMIT 0,500";
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and move_id = ".$id;
        
        
        $from_date_clause = "";
        $to_date_clause = "";
        //$zip_clause = "";
        $city_clause = "";
        //$industries_clause = "";
        //$state_clause = "";  
        
        
        if($sort_by_add_dates == 1)
        {
            //$from_date_clause = " and add_date >= '".$from_date."'";
            //$to_date_clause = " and add_date <= '".$to_date."'";
            
            $from_date_clause = " and effective_date >= '".$count_lower_limit."'";
            $to_date_clause = " and effective_date <= '".$to_date."'";
        }
        else
        {    
            if($from_date != '')
            {
                //$from_date_clause = " and announce_date >= '".$from_date."'";
                $from_date_clause = " and effective_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                //$to_date_clause = " and announce_date <= '".$to_date."'";
                $to_date_clause = " and effective_date <= '".$to_date."'";
            }
        } 
        
        if($_GET['rem'] == 'Saved List')
        {
            $from_date_clause = " and effective_date >= '".$count_lower_limit."'";
            $to_date_clause = " and effective_date <= '".$to_date."'";
        }    
        
        
        //$order_by = " order by mm.announce_date desc";
        //$order_by = " order by move_id desc";
        $order_by = " order by effective_date desc";
        
        if($zip != '')
        {
            $zip_clause = " and zip_code = '".$zip."'";
        } 
        
        //if($revenue_clause == '' && $zip_clause == '')
        
        //echo "<br>move_last_id_db: ".$move_last_id_db;
        
        if($move_last_id_db == '')
        {
            if($count_lower_limit != '')
            {    
                //$move_count_date_clause = "  and announce_date >= '".$count_lower_limit."' and announce_date <= '".$to_date."'";
                //$move_count_date_clause = "  and effective_date >= '".$count_lower_limit."' and effective_date <= '".$to_date."'";
            }

            /*
            $indMoveCountResult = mysql_query("SELECT count(*) as total_move_count
                FROM 
                ".$table_personal_master." AS pm, 
                ".$table_company_master." AS cm, 
                ".$table_movement_master." AS mm,
                ".$table_management_change." as mc,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (
                mm.company_id = cm.company_id
                AND mm.personal_id = pm.personal_id
                AND mm.movement_type = mc.id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                and mm.movement_type in (1,2)  $move_count_date_clause
                ");
            */
            //echo "<br><br>movement count: SELECT count(*) as total_move_count FROM ".$table_search_data." where movement_type in (1,2) $ciso_clause $cso_clause $move_count_date_clause";
            $indMoveCountResult = mysql_query("SELECT count(*) as total_move_count FROM ".$table_search_data." where movement_type in (1,2) $ciso_clause $cso_clause $move_count_date_clause",$site);

            /*
            if(!$indMoveCountResult)
            {
                echo "<br><br>Mysql Error: ".mysql_error();
            }    
            else
            {
                echo "<br>Query working";
            }    
            */
            
            
            $indMoveCountRow = mysql_fetch_array($indMoveCountResult);
            //echo "<pre>indMoveCountRow: ";   print_r($indMoveCountRow);   echo "</pre>";
            $movement_count = $indMoveCountRow['total_move_count'];
        }
        //echo "<br>Count Query: SELECT count(*) as total_move_count FROM hre_search_data where movement_type in (1,2) $move_count_date_clause";
        //echo "<br>movement_count: ".$movement_count;
        
        /*
        echo "<br><br>Move count q: SELECT count(*) as total_move_count
                FROM 
                ".$table_personal_master." AS pm, 
                ".$table_company_master." AS cm, 
                ".$table_movement_master." AS mm,
                ".$table_management_change." as mc,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (
                mm.company_id = cm.company_id
                AND mm.personal_id = pm.personal_id
                AND mm.movement_type = mc.id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                and mm.movement_type in (1,2)  $move_count_date_clause";
        */
        
        
        $company_fields = ",about_company, '' as company_name,company_website,company_revenue,company_employee,address,address2,city,zip_code,state,industry_id"; 
            
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        //if($industries_clause != '' || $state_clause != '')
        //{
                $company_related_fields = ",title as industry_title,'' as state_short";
                //$company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs";
                //$company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id";
        //}
        
        
        /*        
        $indResult = mysql_query("SELECT SQL_CALC_FOUND_ROWS pm.personal_id,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,pm.email as email,pm.phone".$company_fields.",mm.title,mm.movement_type,
            mm.more_link,mm.announce_date as add_date,mm.effective_date,mm.source_id,mm.headline,
            mm.full_body,mm.short_url,mm.what_happened,pm.about_person,mm.full_body,mm.short_url
            ".$company_related_fields." FROM 
            ".$table_personal_master." AS pm, 
            ".$table_company_master." AS cm, 
            ".$table_movement_master." AS mm,
            ".$table_management_change." as mc
            ".$company_related_table."
            WHERE (
            mm.company_id = cm.company_id
            AND mm.personal_id = pm.personal_id
            AND mm.movement_type = mc.id  $company_related_joins) 
            and mm.movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause    
            $order_by $limit_clause");
        */
        
        /*        
         echo "<br>Movement Query: SELECT SQL_CALC_FOUND_ROWS personal_id,move_id,first_name, last_name,
            personal_image,email,phone".$company_fields.",title,movement_type,
            more_link,announce_date as announce_date,effective_date as add_date,effective_date,source_id,headline,
            '' as full_body,'' as short_url,what_happened,about_person,full_body,'' as short_url,
            company_name,company_logo
            FROM $table_search_data
            WHERE 
            movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause $ciso_clause $cso_clause    
            $order_by $limit_clause"; 
        die();       
        */        
                
        $msc = microtime(true);     
                
        //echo "<br>zip_clause before movement: ".$zip_clause;
         $indResult = mysql_query("SELECT SQL_CALC_FOUND_ROWS personal_id,move_id,first_name, last_name,
            personal_image,email,phone".$company_fields.",title,movement_type,
            more_link,announce_date as announce_date,effective_date as add_date,effective_date,source_id,headline,
            '' as full_body,'' as short_url,what_happened,about_person,full_body,'' as short_url,
            company_name,company_logo
            FROM $table_search_data
            WHERE 
            movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause $ciso_clause $cso_clause    
            $order_by $limit_clause");       
           
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo $msc . ' s MOVEMENT'; // in seconds
        
        
        $num_speaking_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_speaking_row = mysql_fetch_array($num_speaking_result);
            $filtered_count = $num_speaking_row['total_speaking_rows']; 
        
            //echo "<br>filtered_count: ".$filtered_count;
            
        /*
         echo "Movement Query:SELECT SQL_CALC_FOUND_ROWS personal_id,move_id,first_name, last_name,
            personal_image,email,phone".$company_fields.",title,movement_type,
            more_link,announce_date as announce_date,effective_date as add_date,effective_date,source_id,headline,
            '' as full_body,'' as short_url,what_happened,about_person,full_body,'' as short_url,
            company_name,company_logo
            FROM $table_search_data
            WHERE 
            movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause $ciso_clause $cso_clause    
            $order_by $limit_clause";
        */
         
        
        while($indRow = mysql_fetch_array($indResult))
        {
            //echo "<br>Within";
            //echo "<br>Move id: ".$indRow['move_id'];   
            $data_arr[$data]['id'] = $indRow['move_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['move_id'] = $indRow['move_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];

            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['state_id'] = $indRow['state'];
            
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['add_date'] = $indRow['add_date'];
            $data_arr[$data]['more_link'] = $indRow['more_link'];
            $data_arr[$data]['movement_type'] = $indRow['movement_type'];
            $data_arr[$data]['type'] = 'movement';
            
            $data_arr[$data]['announce_date'] = $indRow['announce_date'];
            $data_arr[$data]['effective_date'] = $indRow['effective_date'];
            $data_arr[$data]['source_id'] = $indRow['source_id'];
            $data_arr[$data]['headline'] = $indRow['headline'];
            $data_arr[$data]['full_body'] = $indRow['full_body'];
            $data_arr[$data]['short_url'] = $indRow['short_url'];
            $data_arr[$data]['what_happened'] = $indRow['what_happened'];
            $data_arr[$data]['about_person'] = $indRow['about_person'];
            $data_arr[$data]['about_company'] = $indRow['about_company'];
            $data_arr[$data]['industry_id'] = $indRow['industry_id'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            
            if($move_last_id_db == '')
            {
                //echo "<br>FAR in if when db value is empty:".$movement_count;
                $data_arr[$data]['show_state'] = 'unread';
                //$movement_count++;
                //echo "&nbsp;&nbsp;&nbsp;&nbsp;FAR movement_count: ".$movement_count;
            }    
            else
            {    
                //echo "<br>FAR in else Row move_id: ".$indRow['move_id'];
                if($indRow['move_id'] <= $move_last_id_db)
                {
                    //echo "<br>FAR marking read";
                    $data_arr[$data]['show_state'] = 'read';
                }    
                else
                {    
                    //echo "<br>FAR marking unread";
                    $data_arr[$data]['show_state'] = 'unread';
                    $movement_count++;
                }    
            }
            $data++;
        }    
        //$time2 = microtime(true);
        //echo 'script execution time: ' . ($time2 - $time1);
    }
    //echo "<pre>data_arr after movement: ";   print_r($data_arr); echo "</pre>"; 
    
    
    // SPEAKING
    if($type == 'speaking' || ($type == 'all' && $_GET['p'] > 1) || strpos($type,"speaking") > -1)
    {    
        $default_speaking_limit = ' limit 30';
        if($display_type = 'file')
            $default_speaking_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        
        //echo "<br>to_date: ".$to_date;
        //echo "<br>to_date_clause: ".$to_date_clause;
        
        //echo "<br>from_date_clause: ".$from_date_clause;
        //echo "<br>future_30_days: ".$future_30_days;
        
        //if($sort_by_add_dates == 1)
        if(($from_date == '' && $to_date == '') || $login_page_flow == 1)    
        {
            //echo "<br>Witnin if";
            if($to_date == '')
                $to_date = date('Y-m-j'); 
            //$from_date_clause = " and add_date >= '".$from_date."'";
            //$to_date_clause = " and add_date <= '".$to_date."'";
            
            //$from_date_clause = " and event_date >= '".$to_date."'";
            $to_date_clause = " and event_date <= '".$future_30_days."'";
        }
        else
        {    
            //echo "<br>within else";
            if($from_date != '')
            {
                $from_date_clause = " and event_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                $to_date_clause = " and event_date <= '".$to_date."'";
            }    
        }
        //echo "<br>to_date: ".$to_date;
        //echo "<br>to_date_clause: ".$to_date_clause;
        
        
        if($zip != '')
        {
            $zip_clause = " and zip_code = '".$zip."'";
        } 
        
        if($id != '')
            $where_personal_clause = " and speaking_id = ".$id;
        
        
        if($move_last_id_db == '' || $move_last_id_db == '0')
        {
            /*
            if($count_lower_limit != '')
            {    
                $count_date_clause = "  and event_date >= '".$count_lower_limit."' and ps.event_date <= '".$to_date."'";
            }
            */

            //echo "<br>within speaking empty if";
            $company_fields = ",cm.about_company, cm.company_name,cm.company_website, 
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code";
        
            
            // Count Query
            $indCountResult = mysql_query("select count(*) as total_speaking_count
                from ".$table_personal_speaking." as ps,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs    
                where (ps.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
                 $ciso_clause $cso_clause $count_date_clause");
            $indCountRow = mysql_fetch_array($indCountResult);
            $speaking_count = $indCountRow['total_speaking_count'];
            
            //echo "<br>Direct speaking id q: SELECT max(speaking_id) as max_speaking_id from $table_personal_speaking";
            //$max_speaking_id_q = mysql_query("SELECT max(speaking_id) as max_speaking_id from $table_personal_speaking");
            //$maxSpeakingRow = mysql_fetch_array($max_speaking_id_q);
            //$max_speaking_id_direct = $maxSpeakingRow['max_speaking_id'];
            //echo "<br>max_speaking_id_direct: ".$max_speaking_id_direct;
        }
        /*
        echo "<br>select count(*) as total_speaking_count
            from ".$table_personal_speaking." as ps,
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs    
            where (ps.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
             $count_date_clause";
        */
        //echo "<br>total_speaking_count: ".$total_speaking_count;
        
        // $indResult = mysql_query(
        
        
        $file_select_vals = "";
        $file_joins = "";
        $file_where = "";
        if($display_type = 'file') // Need to join with other tables to get data for download file
        {
            //$file_select_vals = ",r.name as revenue_name";
            //$file_joins = ",hre_revenue_size as r";
            //$file_where = " and r.id = sd.company_revenue ";
        }        
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != '')
        {
            $company_related_fields = ",mm.move_id,ci.title as industry_title,cs.short_name as state_short,cm.company_name,mm.title,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            $company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            $company_related_fields = "";
        }
        
        /*
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS pm.personal_id,ps.speaking_link,first_name,last_name,
            personal_image,pm.email as email,pm.phone,speaking_id,event,event_date,
            ps.add_date as add_date,ps.role,
            ps.topic $company_related_fields
            from ".$table_personal_speaking." as ps,
            ".$table_personal_master." as pm
            ".$company_related_table."    
             where (ps.personal_id = pm.personal_id  $company_related_joins)
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by ps.speaking_id order by speaking_id desc  $default_speaking_limit");
        */
        
        /*
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS pm.personal_id,ps.speaking_link,first_name,last_name,
            personal_image,pm.email as email,pm.phone,speaking_id,event,event_date,
            ps.add_date as add_date,ps.role,
            ps.topic $company_related_fields
            from ".$table_personal_speaking." as ps,
            ".$table_personal_master." as pm
            ".$company_related_table."    
             where (ps.personal_id = pm.personal_id  $company_related_joins)
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by ps.speaking_id order by speaking_id desc  $default_speaking_limit");
        */
        
        $msc = microtime(true); 
        
        // Query that will be used when single search table beeing used
        //echo "<br>zip_clause: ".$zip_clause;
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,company_name,company_website,address,address2,city,zip_code,
            sd.add_date,role,revenue_name,employee_size_name,state_name,industry_name,source_name,mgt_change_name,title,
            topic $company_related_fields $file_select_vals
            from $table_search_data as sd  
            $file_joins
             where record_type = 'speaking'
            $where_personal_clause $file_where $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            group by speaking_id order by event_date desc  $default_speaking_limit");
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s SPEAKING'; // in seconds
        
        
        /*
        echo "<br>Speaking Query: select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,company_name,company_website,address,address2,city,zip_code,
            sd.add_date,role,revenue_name,employee_size_name,state_name,industry_name,source_name,mgt_change_name,title,
            topic $company_related_fields $file_select_vals
            from $table_search_data as sd  
            $file_joins
             where record_type = 'speaking'
            $where_personal_clause $file_where $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            group by speaking_id order by event_date desc  $default_speaking_limit";
        */
        
        
        
        /* Original Query
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS mm.move_id,pm.personal_id,ps.speaking_link,first_name,last_name,
            personal_image,pm.email as email,pm.phone,speaking_id,event,event_date,
            ps.add_date as add_date,cm.company_name,mm.title,cm.company_revenue,
            cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,ps.role,
            ps.topic,cm.company_website,ci.title as industry_title,cs.short_name as state_short
            from ".$table_personal_speaking." as ps,
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs    
            where (ps.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by ps.speaking_id order by speaking_id desc  $default_speaking_limit",$site);
         */
            
            //echo "<br>company_related_fields: ".$company_related_fields;
            
        /*
            echo "<br><br>Speaking Query: select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,company_name,company_website,address,address2,city,zip_code,
            sd.add_date,role,revenue_name,employee_size_name,state_name,industry_name,source_name,mgt_change_name,title,
            topic $company_related_fields $file_select_vals
            from $table_search_data as sd  
            $file_joins
             where record_type = 'speaking'
            $where_personal_clause $file_where $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by speaking_id order by event_date desc  $default_speaking_limit";
         */  
            
            //$num_speaking_query = "SELECT FOUND_ROWS() as total_rows";
            //$num_speaking_result = com_db_query($num_speaking_query);
            
            //$num_speaking_query = "SELECT FOUND_ROWS() as total_rows";
            $num_speaking_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_speaking_row = mysql_fetch_array($num_speaking_result);
            $filtered_count = $num_speaking_row['total_speaking_rows'];
        
            //echo "<br>filtered_count: ".$filtered_count;    
            //die("<br>FA");
        
        /*
        echo "<br>SPEAKING QUERY: select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,
            add_date,role,
            topic $company_related_fields
            from hre_search_data   
             where record_type = 'speaking'
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by speaking_id order by speaking_id desc  $default_speaking_limit";
        */
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['move_id'] = $indRow['move_id'];
            $data_arr[$data]['id'] = $indRow['speaking_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['event'] = $indRow['event'];
            $data_arr[$data]['event_date'] = $indRow['event_date'];
            $data_arr[$data]['speaking_link'] = $indRow['speaking_link'];
            $data_arr[$data]['add_date'] = $indRow['event_date'];
            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['type'] = 'speaking';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            
            $data_arr[$data]['role'] = $indRow['role'];
            $data_arr[$data]['topic'] = $indRow['topic'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            //$data_arr[$data]['max_speaking_id_direct'] = $max_speaking_id_direct;
            $data_arr[$data]['revenue_name'] = $indRow['revenue_name'];
            $data_arr[$data]['employee_size_name'] = $indRow['employee_size_name'];
            $data_arr[$data]['state_name'] = $indRow['state_name'];
            $data_arr[$data]['industry_name'] = $indRow['industry_name'];
            $data_arr[$data]['source_name'] = $indRow['source_name'];
            $data_arr[$data]['mgt_change_name'] = $indRow['mgt_change_name'];
            
            $last_speaking_id = "";
            
            if($speaking_last_id_db == '' || $move_last_id_db == '0')
            {
                $data_arr[$data]['show_state'] = 'unread';
                //$speaking_count++;
            }    
            else
            {   
                //echo "<br>In else row speaking id: ".$indRow['speaking_id'];
                //echo "<br>speaking_last_id_db: ".$speaking_last_id_db;
                if($indRow['speaking_id'] <= $speaking_last_id_db)
                {
                    //echo "<br>marking read";
                    $data_arr[$data]['show_state'] = 'read';
                }    
                else
                {    
                    //echo "<br>marking unread";
                    $data_arr[$data]['show_state'] = 'unread';
                    $speaking_count++;
                }    
            
                //if($indRow['speaking_id'] > $last_speaking_id)
                //    $max_speaking_id = $indRow['speaking_id'];
            
                //$last_speaking_id = $indRow['speaking_id'];
            }
            
            $data++;
        }
        //echo "<br>OP Func speaking_count: ".$speaking_count;
        //die("After speaking");
        
    }   
    
    // AWARDS
    if($type == 'awards' || $type == 'all' || strpos($type,"awards") > -1)
    { 
        $default_awards_limit = ' limit 30';
        
        if($display_type = 'file')
            $default_awards_limit = '';
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and awards_id = ".$id;
        
        $from_date_clause = "";
        $to_date_clause = "";
        
        
        if($sort_by_add_dates == 1)
        {
            //$from_date_clause = " and pa.add_date >= '".$from_date."'";
            //$to_date_clause = " and pa.awards_date <= '".$to_date."'";
            
            $to_date_clause = " and awards_date <= '".$to_date."'";
        }
        else
        {  
        
            if($from_date != '')
            {
                //$from_date_clause = " and pa.awards_date >= '".$from_date."'";
                $from_date_clause = " and awards_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                //$to_date_clause = " and pa.awards_date <= '".$to_date."'";
                $to_date_clause = " and awards_date <= '".$to_date."'";
            }
        }    
        if($zip != '')
        {
            //$zip_clause = " and cm.zip_code = '".$zip."'";
            $zip_clause = " and zip_code = '".$zip."'";
        } 
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        
        //if($industries_clause != '' || $state_clause != '')
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != '' || $display_type = 'file') //  || $display_type = 'file'
        {
            //$company_related_fields = ",ci.title as industry_title,cs.short_name as state_short,cm.company_name,mm.title,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            //$company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            //$company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            
            $company_related_fields = ",title as industry_title,state_name as state_short,company_name,title,company_revenue,company_employee,address,address2,city,zip_code,company_website";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            $company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
        }
        
        //echo "<br>awards_last_id_db : ".$awards_last_id_db;
        if($awards_last_id_db == '')
        {
            if($count_lower_limit != '')
            {    
                //$awards_count_date_clause = "  and pa.awards_date >= '".$count_lower_limit."' and pa.awards_date <= '".$to_date."'";
            }


            // Count Query
            $indAwardsCountResult = mysql_query("select COUNT(DISTINCT awards_id) as  total_award_count
                from ".$table_personal_awards." as pa,
                ".$table_personal_master ." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (pa.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
                 $ciso_clause $cso_clause $awards_count_date_clause");
            $indAwardsCountRow = mysql_fetch_array($indAwardsCountResult);
            //$total_award_count = $indAwardsCountRow['total_award_count'];
            $award_count = $indAwardsCountRow['total_award_count'];
        }
        
        $msc = microtime(true); 
        
        // Query applied on multiple DB tables
        /*
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS pm.personal_id,pa.awards_link,first_name,last_name,
            personal_image,pm.email as email,awards_id,pa.awards_title,pa.awards_given_by,
            pa.awards_date,pa.add_date as add_date,pm.phone $company_related_fields
            from ".$table_personal_awards." as pa,
            ".$table_personal_master ." as pm
            ".$company_related_table."
            where (pa.personal_id = pm.personal_id $company_related_joins)
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause
            group by awards_id $default_awards_limit order by awards_date desc");
        */
        
        
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS personal_id,awards_link,first_name,last_name,
            personal_image,email as email,awards_id,awards_title,awards_given_by,
            awards_date,add_date as add_date,phone $company_related_fields
            from hre_search_data_awards
            where (record_type = 'awards')
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause
            group by awards_id $default_awards_limit order by awards_date desc");
        
        
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s AWARDS'; // in seconds
        
        
        /*
        echo "<br>AWARD QUERY: select SQL_CALC_FOUND_ROWS personal_id,awards_link,first_name,last_name,
            personal_image,email as email,awards_id,awards_title,awards_given_by,
            awards_date,add_date as add_date,phone $company_related_fields
            from hre_search_data_awards
            where (record_type = 'awards')
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause
            group by awards_id $default_awards_limit order by awards_date desc";
        */
        
        
        $num_awards_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_awards_row = mysql_fetch_array($num_awards_result);
            $filtered_count = $num_awards_row['total_speaking_rows'];
        
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['id'] = $indRow['awards_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            //$data_arr[$indRow['awards_id']]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['awards_title'] = $indRow['awards_title'];
            $data_arr[$data]['awards_given_by'] = $indRow['awards_given_by'];
            $data_arr[$data]['awards_date'] = $indRow['awards_date'];
            $data_arr[$data]['add_date'] = $indRow['awards_date'];
            $data_arr[$data]['awards_link'] = $indRow['awards_link'];
            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['type'] = 'awards';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            if($awards_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                //$award_count++;
            }    
            else
            {    
                if($indRow['awards_id'] <= $awards_last_id_db)
                    $data_arr[$data]['show_state'] = 'read';
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $award_count++;
                }    
            }
            $data++;
        }
    }    
        

    // MEDIA MENTIONS
    if($type == 'media' || $type == 'media_mention' || $type == 'all' || strpos($type,"media_mention") > -1)
    {
        $default_media_limit = ' limit 30';
        if($display_type = 'file')
            $default_media_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        
        if($sort_by_add_dates == 1)
        {
            //$from_date_clause = " and pmm.add_date >= '".$from_date."'";
            //$to_date_clause = " and pmm.pub_date <= '".$to_date."'";
            $to_date_clause = " and pub_date <= '".$to_date."'";
        }
        else
        {  
            if($from_date != '')
            {
                //$from_date_clause = " and pmm.pub_date >= '".$from_date."'";
                $from_date_clause = " and pub_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                //$to_date_clause = " and pmm.pub_date <= '".$to_date."'";
                $to_date_clause = " and pub_date <= '".$to_date."'";
            }
        }    
        if($zip != '')
        {
            //$zip_clause = " and cm.zip_code = '".$zip."'";
            $zip_clause = " and zip_code = '".$zip."'";
        }
        
        if($id != '')
        {    
            //$where_personal_clause = " and pmm.mm_id = ".$id;
            $where_personal_clause = " and mm_id = ".$id;
        }    
        
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        
        //if($industries_clause != '' || $state_clause != '')
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != '' || $display_type = 'file')  //  || $display_type = 'file'
        {
            //$company_related_fields = ",ci.title as industry_title,state_name as state_short,mm_id,cm.company_name,mm.title,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            //$company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            //$company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            
            $company_related_fields = ",title as industry_title,state_name as state_short,mm_id,company_name,title,company_revenue,company_employee,address,address2,city,zip_code,company_website";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            
            $company_related_joins = " and company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            
        }
        
        if($media_last_id_db == '')
        {
            if($count_lower_limit != '')
            {    
                //$media_count_date_clause = "  and pmm.pub_date >= '".$count_lower_limit."' and pmm.pub_date <= '".$to_date."'";
            }

            // Count Query
            $indMediaCountResult = mysql_query("select COUNT(DISTINCT mm_id) as total_media_count
                from ".$table_personal_media_mention." as pmm,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (pmm.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                  $ciso_clause $cso_clause $media_count_date_clause");
            $indMediaCountRow = mysql_fetch_array($indMediaCountResult);
            //$total_media_count = $indMediaCountRow['total_media_count'];
            $media_count = $indMediaCountRow['total_media_count'];
        }
        
        /*
        echo "<br>Media count Q: select count(*) as total_media_count
                from ".$table_personal_media_mention." as pmm,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (pmm.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                  $ciso_clause $cso_clause $media_count_date_clause";
         
        echo "<br>Media count: ".$media_count;
        */
        
        $msc = microtime(true);  
        // Below query being used when there are multiple db tables
        /*
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS pm.personal_id,pm.phone,pmm.media_link,first_name,last_name,
            personal_image,pm.email as email,pmm.quote,pmm.publication,pmm.pub_date,pmm.mm_id,
            pmm.add_date as add_date $company_related_fields
            from ".$table_personal_media_mention." as pmm,
            ".$table_personal_master." as pm
            ".$company_related_table."
            where (pmm.personal_id = pm.personal_id $company_related_joins) $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause $where_personal_clause $ciso_clause $cso_clause
            GROUP BY mm_id order by pub_date desc $default_media_limit");
        */
        
        
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS personal_id,phone,media_link,first_name,last_name,
            personal_image,email as email,quote,publication,pub_date,mm_id,
            add_date as add_date $company_related_fields
            from hre_search_data_media
            where record_type = 'media' $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause $where_personal_clause $ciso_clause $cso_clause
            GROUP BY mm_id order by pub_date desc $default_media_limit");
        
        
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s MEDIA'; // in seconds
        
        
        /*
        echo "<br><br>Media Query: select SQL_CALC_FOUND_ROWS personal_id,phone,media_link,first_name,last_name,
            personal_image,email as email,quote,publication,pub_date,mm_id,
            add_date as add_date $company_related_fields
            from hre_search_data_media
            where record_type = 'media' $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause $where_personal_clause $ciso_clause $cso_clause
            GROUP BY mm_id order by pub_date desc $default_media_limit";
        */
        //die();
         
        
        
        
        $num_media_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_media_row = mysql_fetch_array($num_media_result);
            $filtered_count = $num_media_row['total_speaking_rows'];
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['id'] = $indRow['mm_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['publication'] = $indRow['publication'];
            $data_arr[$data]['quote'] = $indRow['quote'];
            $data_arr[$data]['pub_date'] = $indRow['pub_date'];
            $data_arr[$data]['media_link'] = $indRow['media_link'];
            $data_arr[$data]['add_date'] = $indRow['pub_date'];
            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['type'] = 'media_mention';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            if($media_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                //$media_count++;
            }    
            else
            {    
                if($indRow['mm_id'] <= $media_last_id_db)
                    $data_arr[$data]['show_state'] = 'read';
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $media_count++;
                }    
            }
            
            $data++;
        }
    }

    
    // PUBLICATION
    if($type == 'publication' || $type == 'all' || strpos($type,"publication") > -1)
    {
        $default_pub_limit = ' limit 30';
        if($display_type = 'file')
            $default_pub_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        
        
        if($sort_by_add_dates == 1)
        {
            //$from_date_clause = " and ppp.publication_date >= '".$from_date."'";
            $to_date_clause = " and ppp.publication_date <= '".$to_date."'";
        }
        else
        { 
            if($from_date != '')
            {
                $from_date_clause = " and ppp.publication_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                $to_date_clause = " and ppp.publication_date <= '".$to_date."'";
            }
        }    
        if($zip != '')
        {
            $zip_clause = " and cm.zip_code = '".$zip."'";
        } 
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and publication_id = ".$id;
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        
        //if($industries_clause != '' || $state_clause != '')
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != ''  || $display_type = 'file')    
        {
            $company_related_fields = ",ci.title as industry_title,cs.short_name as state_short,mm.title as move_title,cm.company_name,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm ";
            $company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
        }
        
        if($publication_last_id_db == '')
        {
            if($count_lower_limit != '')
            {    
                $pub_count_date_clause = "  and ppp.publication_date >= '".$count_lower_limit."' and ppp.publication_date <= '".$to_date."'";
            }

            $total_publication_count = 0;
            //echo "<br>publication_last_id_db: ".$publication_last_id_db;

            $indPublicationCountResult = mysql_query("select  count(*) as total_publication_count
                from ".$table_personal_publication." as ppp,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (ppp.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                 $ciso_clause $cso_clause $pub_count_date_clause");
            $indPublicationCountRow = mysql_fetch_array($indPublicationCountResult);
            //$total_publication_count = $indPublicationCountRow['total_publication_count'];
            $publication_count = $indPublicationCountRow['total_publication_count'];
        }
        
        /*
        echo "<br>Pub CountQuery : select  count(*) as total_publication_count
            from ".$table_personal_publication." as ppp,
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs
            where (ppp.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
             $pub_count_date_clause";
        */
        
        
        $msc = microtime(true);
        $indResult = mysql_query("select SQL_CALC_FOUND_ROWS pm.personal_id,ppp.link,first_name,last_name,personal_image,
            pm.email as email,publication_id,ppp.title,ppp.publication_date,ppp.add_date as add_date,
            pm.phone $company_related_fields
            from ".$table_personal_publication." as ppp,
            ".$table_personal_master." as pm
            ".$company_related_table."
            where (ppp.personal_id = pm.personal_id $company_related_joins) $from_date_clause $to_date_clause $zip_clause $revenue_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause  $where_personal_clause $ciso_clause $cso_clause 
            group by personal_id order by publication_date desc $default_pub_limit");
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
	echo "<br><br>".$msc . ' s PUBLICATION'; // in seconds
        
        /*
        echo "<br>Pub Query: select SQL_CALC_FOUND_ROWS pm.personal_id,ppp.link,first_name,last_name,personal_image,
            pm.email as email,publication_id,ppp.title,ppp.publication_date,ppp.add_date as add_date,
            pm.phone $company_related_fields
            from ".$table_personal_publication." as ppp,
            ".$table_personal_master." as pm
            ".$company_related_table."
            where (ppp.personal_id = pm.personal_id $company_related_joins) $from_date_clause $to_date_clause $zip_clause $revenue_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause  $where_personal_clause  
            group by personal_id order by publication_date desc $default_pub_limit";
        */
        
        $num_speaking_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_speaking_row = mysql_fetch_array($num_speaking_result);
            $filtered_count = $num_speaking_row['total_speaking_rows'];
        
        
        
        while($indRow = mysql_fetch_array($indResult))
        {
            //if($pub_c == 0 && $publication_last_id_db == '')
            //{    
            //    $publication_last_id_db = $indRow['publication_id'];
            //}
            
            $data_arr[$data]['id'] = $indRow['publication_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['publication_date'] = $indRow['publication_date'];
            $data_arr[$data]['link'] = $indRow['link'];
            $data_arr[$data]['add_date'] = $indRow['publication_date'];
            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['move_title'] = $indRow['move_title'];
            $data_arr[$data]['type'] = 'publication';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            if($publication_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                $publication_count++;
                //echo "<br>In if";
                //$total_publication_count++;
                
            }    
            else
            {    
                if($indRow['publication_id'] <= $publication_last_id_db)
                {    
                    $data_arr[$data]['show_state'] = 'read';
                    //echo "<br>In else if";
                }    
                else
                {
                    //$total_publication_count++;
                    $data_arr[$data]['show_state'] = 'unread';
                    $publication_count++;
                    //echo "<br>In else else";
                }    
            }
            
            $data++;
        }
    }  
    //echo "<br>pub_c: ".$pub_c;    
     //die("pub end");
        
    
    // funding
    if($type == 'funding' || $type == 'all' || strpos($type,"funding") > -1)
    {
        $default_speaking_limit = ' limit 30';
        if($display_type = 'file')
            $default_speaking_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        
        if($sort_by_add_dates == 1)
        {
            //$from_date_clause = " and cf.funding_add_date >= '".$from_date."'";
            $to_date_clause = " and cf.funding_add_date <= '".$to_date."'";
        }
        else
        { 
            if($from_date != '')
            {
                $from_date_clause = " and cf.funding_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                $to_date_clause = " and cf.funding_date <= '".$to_date."'";
            }
        }    
        if($zip != '')
        {
            $zip_clause = " and cm.zip_code = '".$zip."'";
        }
        
        if($id != '')
            $where_personal_clause = " and funding_id = ".$id;
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        /*
        if($industries_clause != '' || $state_clause != '')
        {
            $company_related_fields = ",ci.title as industry_title,cs.short_name as state_short";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs";
            $company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id";
        }
        */
        
        
        
        if($funding_last_id_db == '')
        {
            /*
            if($count_lower_limit != '')
            {    
                $funding_count_date_clause = "  and cf.funding_date >= '".$count_lower_limit."' and cf.funding_date <= '".$to_date."'";
            }
            */
            /*
            echo "<br>Funding query: SELECT  count(*) as total_funding_count
                FROM 
                ".$table_personal_master." AS pm, 
                ".$table_company_master." AS cm, 
                ".$table_movement_master." AS mm,
                ".$table_company_funding." as cf,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (
                mm.company_id = cm.company_id
                AND mm.personal_id = pm.personal_id
                AND cm.company_id = cf.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id
                and add_to_funding = 1)";
            */


            $indFundingCountResult = mysql_query("SELECT  count(*) as total_funding_count
                FROM 
                ".$table_personal_master." AS pm, 
                ".$table_company_master." AS cm, 
                ".$table_movement_master." AS mm,
                ".$table_company_funding." as cf,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (
                mm.company_id = cm.company_id
                AND mm.personal_id = pm.personal_id
                AND cm.company_id = cf.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id
                 $ciso_clause $cso_clause and add_to_funding = 1) $funding_count_date_clause
                ");
            $indFundingCountRow = mysql_fetch_array($indFundingCountResult);
            //$total_funding_count = $indFundingCountRow['total_funding_count'];
            $funding_count = $indFundingCountRow['total_funding_count'];
        }
        
        $msc = microtime(true);  
        $indResult = mysql_query("SELECT SQL_CALC_FOUND_ROWS pm.personal_id,cf.funding_source,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,cm.company_logo,
            pm.email as email,pm.phone,cm.company_name, mm.title,mm.movement_type,cf.funding_id,cf.funding_amount,
            cf.funding_source,cf.funding_add_date as add_date,cf.funding_date as funding_date,pm.add_to_funding,
            cm.company_id $company_related_fields,
            cm.company_revenue,cm.company_employee,cm.industry_id as industry_id,cm.company_website,cm.address,cm.address2,cm.city,
            cm.state as state_id,cm.zip_code
            FROM 
            ".$table_personal_master." AS pm, 
            ".$table_company_master." AS cm, 
            ".$table_movement_master." AS mm,
            ".$table_company_funding." as cf
            ".$company_related_table."
            WHERE (
            mm.company_id = cm.company_id
            AND mm.personal_id = pm.personal_id
            AND cm.company_id = cf.company_id $company_related_joins 
            and add_to_funding = 1 $from_date_clause $to_date_clause $zip_clause $where_personal_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            $revenue_clause) order by funding_add_date desc $default_speaking_limit");
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s FUNDING'; // in seconds
        
        
        /*
        echo "QUERY: SELECT SQL_CALC_FOUND_ROWS pm.personal_id,cf.funding_source,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,cm.company_logo,
            pm.email as email,pm.phone,cm.company_name, mm.title,mm.movement_type,cf.funding_id,cf.funding_amount,
            cf.funding_source,cf.funding_add_date as add_date,cf.funding_date as funding_date,pm.add_to_funding,
            cm.company_id $company_related_fields,
            cm.company_revenue,cm.company_employee,cm.industry_id as industry_id,cm.company_website,cm.address,cm.address2,cm.city,
            cm.state as state_id,cm.zip_code
            FROM 
            ".$table_personal_master." AS pm, 
            ".$table_company_master." AS cm, 
            ".$table_movement_master." AS mm,
            ".$table_company_funding." as cf
            ".$company_related_table."
            WHERE (
            mm.company_id = cm.company_id
            AND mm.personal_id = pm.personal_id
            AND cm.company_id = cf.company_id $company_related_joins 
            and add_to_funding = 1 $from_date_clause $to_date_clause $zip_clause $where_personal_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause    
            $revenue_clause) order by funding_add_date desc $default_speaking_limit";
        */ 
        //die();
        

        
        $num_speaking_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
        $num_speaking_row = mysql_fetch_array($num_speaking_result);
        $filtered_count = $num_speaking_row['total_speaking_rows'];
        

        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['id'] = $indRow['move_id'];
            $data_arr[$data]['funding_id'] = $indRow['funding_id'];
            $data_arr[$data]['personal_id'] = $indRow['personal_id'];
            $data_arr[$data]['first_name'] = $indRow['first_name'];
            $data_arr[$data]['last_name'] = $indRow['last_name'];
            $data_arr[$data]['personal_image'] = $indRow['personal_image'];
            $data_arr[$data]['company_logo'] = $indRow['company_logo'];
            $data_arr[$data]['email'] = $indRow['email'];
            $data_arr[$data]['phone'] = $indRow['phone'];

            $data_arr[$data]['company_id'] = $indRow['company_id'];
            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            
            $data_arr[$data]['funding_amount'] = $indRow['funding_amount'];
            $data_arr[$data]['funding_amount'] = $indRow['funding_amount'];
            $data_arr[$data]['funding_date'] = $indRow['funding_date'];
            $data_arr[$data]['funding_source'] = $indRow['funding_source'];
            $data_arr[$data]['title'] = $indRow['title'];
            //$data_arr[$data]['add_date'] = $indRow['add_date'];
            $data_arr[$data]['add_date'] = $indRow['funding_date'];//funding_add_date
            $data_arr[$data]['type'] = 'funding';
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['industry_id'] = $indRow['industry_id'];
            $data_arr[$data]['state_id'] = $indRow['state_id'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            if($funding_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
            }    
            else
            {    
                if($indRow['funding_id'] <= $funding_last_id_db)
                    $data_arr[$data]['show_state'] = 'read';
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $funding_count++;
                }    
            }
            $data++;
        }
    }
    
    // Jobs
    if($type == 'jobs' || $type == 'all' || strpos($type,"jobs") > -1)
    {
        $default_speaking_limit = ' limit 30';
        if($display_type = 'file')
            $default_speaking_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        
        if($sort_by_add_dates == 1)
        {
            $from_date_clause = " and cj.add_date >= '".$from_date."'";
            $to_date_clause = " and cj.add_date <= '".$to_date."'";
        }
        else
        { 
            if($from_date != '')
            {
                $from_date_clause = " and cj.post_date >= '".$from_date."'";
            }        
            if($to_date != '')
            {
                $to_date_clause = " and cj.post_date <= '".$to_date."'";
            }
        }    
        if($zip != '')
        {
            $zip_clause = " and cm.zip_code = '".$zip."'";
        }
        if($id != '')
            $where_personal_clause = " and job_id = ".$id;
        
        if($searchnow != '')
            $company_personal_clause = " and (company_name = '".$searchnow."')";
        if($company != '') 
            $company_personal_clause = " and (company_name = '".$company."' || company_website = '".$company."' )";
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        /*
        if($industries_clause != '' || $state_clause != '')
        {
            $company_related_fields = ",ci.title as industry_title,cs.short_name as state_short";
            $company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs";
            $company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id";
        }
        */
        
        //echo "<br>jobs_last_id_db: ".$jobs_last_id_db;
        if($jobs_last_id_db == '' || $jobs_last_id_db == '0')
        {
            // Below clause was added to get last 90 days job count
            /*
            if($count_lower_limit != '')
            {    
                $job_count_date_clause = "  and cj.post_date >= '".$count_lower_limit."' and cj.post_date <= '".$to_date."'";
            }
            */
            
            //echo "<br>Within job count query";
            
            
            $indJobCountResult = mysql_query("SELECT count(*) as total_job_count
                FROM 
                ".$table_company_master." as cm, 
                ".$table_company_job." as cj,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (cm.company_id = cj.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                 $job_count_date_clause");
            $indJobCountRow = mysql_fetch_array($indJobCountResult);
            //$total_job_count = $indJobCountRow['total_job_count'];
            $job_count = $indJobCountRow['total_job_count'];
        }
        
        // Job count query in case when user doesnt have previous count in DB
        /*
        echo "<br>Job count query: SELECT count(*) as total_job_count
                FROM 
                ".$table_company_master." as cm, 
                ".$table_company_job." as cj,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (cm.company_id = cj.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                 $job_count_date_clause ";
        */
        
        //echo "<br>job_count: ".$job_count;
        $msc = microtime(true); 
        $indResult = mysql_query("SELECT SQL_CALC_FOUND_ROWS cj.job_id,cm.company_id,cm.company_logo,cm.company_name, 
            cj.post_date,cj.add_date as add_date,cj.job_title,cj.location,cj.source,cm.company_website,
            cm.company_revenue,cm.industry_id,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.state as state_id,
            cm.phone $company_related_fields
            FROM 
            ".$table_company_master." as cm, 
            ".$table_company_job." as cj
            ".$company_related_table." 
            WHERE (cm.company_id = cj.company_id $company_related_joins)  $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause 
            $state_clause $employee_size_clause $where_personal_clause order by job_id desc   
             $default_speaking_limit ");
        
        $num_speaking_result = mysql_query("SELECT FOUND_ROWS() as total_speaking_rows");
            $num_speaking_row = mysql_fetch_array($num_speaking_result);
            $filtered_count = $num_speaking_row['total_speaking_rows'];
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s JOB'; // in seconds    
            
            
        /*
        echo "Job query: SELECT SQL_CALC_FOUND_ROWS cj.job_id,cm.company_id,cm.company_logo,cm.company_name, 
            cj.post_date,cj.add_date as add_date,cj.job_title,cj.location,cj.source,cm.company_website,
            cm.company_revenue,cm.industry_id,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.state as state_id,
            cm.phone $company_related_fields
            FROM 
            ".$table_company_master." as cm, 
            ".$table_company_job." as cj
            ".$company_related_table." 
            WHERE (cm.company_id = cj.company_id $company_related_joins)  $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $ciso_clause $cso_clause
            $state_clause $employee_size_clause $where_personal_clause order by job_id desc   
             $default_speaking_limit";  
        */    
        
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['id'] = $indRow['job_id'];
            $data_arr[$data]['company_id'] = $indRow['company_id'];
            $data_arr[$data]['company_logo'] = $indRow['company_logo'];

            $data_arr[$data]['company_name'] = $indRow['company_name'];
            $data_arr[$data]['phone'] = $indRow['phone'];
            $data_arr[$data]['job_title'] = $indRow['job_title'];
            $data_arr[$data]['location'] = $indRow['location'];
            $data_arr[$data]['source'] = $indRow['source'];
            $data_arr[$data]['post_date'] = $indRow['post_date'];

            $data_arr[$data]['add_date'] = $indRow['post_date'];
            $data_arr[$data]['type'] = 'jobs';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['industry_id'] = $indRow['industry_id'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            $data_arr[$data]['state_id'] = $indRow['state_id'];
            
            if($jobs_last_id_db == '' || $jobs_last_id_db == '0')
            {
                //echo "<br>In if";
                $data_arr[$data]['show_state'] = 'unread';
                //$job_count++; // Added on 23 june 2016
            }    
            else
            {    
                //echo "<br>In else";
                //echo "<br>Ind job id: ".$indRow['job_id'];
                //echo "<br>jobs_last_id_db: ".$jobs_last_id_db;
                if($indRow['job_id'] <= $jobs_last_id_db)
                    $data_arr[$data]['show_state'] = 'read';
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $job_count++;
                }    
            }
            //echo "<br>job_count: ".$job_count;
            $data++;
        }
    }
   
    $total_count_without_where = $total_speaking_count+$total_award_count+$total_media_count+$total_publication_count+$total_move_count+$total_funding_count+$total_job_count;
    
    /*
    echo "<br>total_speaking_count: ".$total_speaking_count;
    echo "<br>total_award_count: ".$total_award_count;
    echo "<br>total_media_count: ".$total_media_count;
    echo "<br>total_pub_count: ".$total_publication_count;
    echo "<br>total_move_count: ".$total_move_count;
    echo "<br>total_funding_count: ".$total_funding_count;
    echo "<br>total_job_count: ".$total_job_count;
    */
    
    // Commented below line on 20 May 2016
    //com_db_connect() or die('Unable to connect to database server!');
    
    //com_db_query("DELETE FROM ".TABLE_COUNT." where user_id = ".$_SESSION['sess_user_id']);
    //com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('movement','".$_SESSION['sess_user_id']."','".$last_move_id."')");	
     
    //echo "<pre>data_arr before sort: ";   print_r($data_arr); echo "</pre>"; 
    usort($data_arr, "custom_sort");    
    //echo "<pre>data_arr after sort: ";   print_r($data_arr); echo "</pre>";
    return $data_arr;
}


function get_all_states()
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    //com_db_connect() or die('Unable to connect to database server!');
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    $data = 0;
    
    $indResult = mysql_query("SELECT state_id,short_name FROM hre_state LIMIT 0,100");

    while($indRow = mysql_fetch_array($indResult))
    {
        //$data_arr[$data]['state_id'] = $indRow['state_id'];
        //$data_arr[$data]['short_name'] = $indRow['short_name'];
        $data_arr[$indRow['state_id']] = $indRow['short_name'];
        //$data++;
    }
    //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}

function get_all_industries()
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    //$conn = com_db_connect_hre2() or die('Unable to connect to database server!');
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    
    $data = 0;
    //echo "<br>Industry: SELECT industry_id,parent_id,title FROM hre_industry";
    $indResult = mysql_query("SELECT industry_id,parent_id,title FROM hre_industry");
//echo "<br>Before while";
    while($indRow = mysql_fetch_array($indResult))
    {
        //echo "<br>Within while";
        //$data_arr[$data]['state_id'] = $indRow['state_id'];
        //$data_arr[$data]['short_name'] = $indRow['short_name'];
        $data_arr[$indRow['industry_id']]['parent_id'] = $indRow['parent_id'];
        $data_arr[$indRow['industry_id']]['title'] = $indRow['title'];
        //$data++;
    }
    //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}

function get_hr_data($rec_type)
{
    $cto = mysql_connect(CTO_SERVER_IP,CTO_DB_USER_NAME,CTO_DB_PASSWORD) or die("Database ERROR ".mysql_error());
    mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");        
    $data_arr = array();
    
    if($rec_type == 'speaking')
    {
        $indResult = mysql_query("select first_name,last_name,personal_image,speaking_id,event,event_date from cto_personal_speaking as ps,
                                    cto_personal_master as pm where ps.personal_id = pm.personal_id
                                 limit 0,5",$cto);
        while($indRow = mysql_fetch_array($indResult))
        {
            //$speaking = $indRow['event'];
            $data_arr[$indRow['speaking_id']]['id'] = $indRow['speaking_id'];
            $data_arr[$indRow['speaking_id']]['first_name'] = $indRow['first_name'];
            $data_arr[$indRow['speaking_id']]['last_name'] = $indRow['last_name'];
            $data_arr[$indRow['speaking_id']]['personal_image'] = $indRow['personal_image'];
            $data_arr[$indRow['speaking_id']]['event'] = $indRow['event'];
            $data_arr[$indRow['speaking_id']]['event_date'] = $indRow['event_date'];
            $data_arr[$indRow['speaking_id']]['type'] = 'speaking';
        }
        //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    }
    elseif($rec_type == 'awards')
    {
    
        $indResult = mysql_query("select first_name,last_name,personal_image,awards_id,pa.awards_title,pa.awards_given_by,pa.awards_date from cto_personal_awards as pa,
                                cto_personal_master as pm where pa.personal_id = pm.personal_id
                             limit 0,5",$cto);
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$indRow['awards_id']]['id'] = $indRow['awards_id'];
            $data_arr[$indRow['awards_id']]['first_name'] = $indRow['first_name'];
            $data_arr[$indRow['awards_id']]['last_name'] = $indRow['last_name'];
            $data_arr[$indRow['awards_id']]['personal_image'] = $indRow['personal_image'];
            //$data_arr[$indRow['awards_id']]['personal_image'] = $indRow['personal_image'];
            $data_arr[$indRow['awards_id']]['awards_title'] = $indRow['awards_title'];
            $data_arr[$indRow['awards_id']]['awards_given_by'] = $indRow['awards_given_by'];
            $data_arr[$indRow['awards_id']]['awards_date'] = $indRow['awards_date'];
            $data_arr[$indRow['awards_id']]['type'] = 'awards';
        }
        //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    }
    elseif($rec_type == 'media')
    {
    
        $indResult = mysql_query("select first_name,last_name,personal_image,mm_id,pmm.publication,pmm.pub_date from cto_personal_media_mention as pmm,
                                cto_personal_master as pm where pmm.personal_id = pm.personal_id
                             limit 0,5",$cto);
        
        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$indRow['mm_id']]['id'] = $indRow['mm_id'];
            $data_arr[$indRow['mm_id']]['first_name'] = $indRow['first_name'];
            $data_arr[$indRow['mm_id']]['last_name'] = $indRow['last_name'];
            $data_arr[$indRow['mm_id']]['personal_image'] = $indRow['personal_image'];
            
            $data_arr[$indRow['mm_id']]['publication'] = $indRow['publication'];
            $data_arr[$indRow['mm_id']]['pub_date'] = $indRow['pub_date'];
            
            $data_arr[$indRow['mm_id']]['type'] = 'publication';
        }
        //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    }
    return $data_arr;
}



function get_industry_title($industry_id)
{
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $indResult = mysql_query("SELECT title FROM hre_industry where industry_id = ".$industry_id);
    //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
    $ind_title = '';
    $indRow = mysql_fetch_array($indResult);
    {
        //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
        $ind_title = $indRow['title'];
    }
    return $ind_title;
}


function get_state_title($state_id)
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $indResult = mysql_query("SELECT short_name FROM hre_state where state_id = ".$state_id);
    //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
    $ind_title = '';
    $indRow = mysql_fetch_array($indResult);
    {
        //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
        $state_title = $indRow['short_name'];
    }
    return $state_title;
}


function get_revenue_limits($revenue)
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    if(strpos($revenue,",") > -1)
    {        
    
        $revenue = trim($revenue,",");
        $revenue_arr = explode(",", $revenue);
        $db_id = 2;
        $lower_revenue = $revenue_arr[0]+$db_id;
        $upper_revenue = $revenue_arr[1]+$db_id;

        if($lower_revenue > 9)
            $lower_revenue = 9;
        if($upper_revenue > 9)
            $upper_revenue = 9;


        //echo "<pre>revenue_arr: ";   print_r($revenue_arr);   echo "</pre>";

        if($revenue_arr[0] == 0)
            $lower_limit = '0';
        elseif($revenue_arr[0] == 1)
            $lower_limit = '$1 mil';
        elseif($revenue_arr[0] == 2)
            $lower_limit = '$10 mil';
        elseif($revenue_arr[0] == 3)
            $lower_limit = '$50 mil';
        elseif($revenue_arr[0] == 4)
            $lower_limit = '$100 mil';
        elseif($revenue_arr[0] == 5)
            $lower_limit = '$250 mil';
        elseif($revenue_arr[0] == 6)
            $lower_limit = '$500 mil';
        elseif($revenue_arr[0] == 7)
            $lower_limit = '$1 bil';
        //elseif($revenue_arr[0] == 8)
        //    $lower_limit = '$0';


        if($revenue_arr[1] == 0)
            $upper_limit = '0';
        elseif($revenue_arr[1] == 1)
            $upper_limit = '$1 mil';
        elseif($revenue_arr[1] == 2)
            $upper_limit = '$10 mil';
        elseif($revenue_arr[1] == 3)
            $upper_limit = '$50 mil';
        elseif($revenue_arr[1] == 4)
            $upper_limit = '$100 mil';
        elseif($revenue_arr[1] == 5)
            $upper_limit = '$250 mil';
        elseif($revenue_arr[1] == 6)
            $upper_limit = '$500 mil';
        elseif($revenue_arr[1] == 7)
            $upper_limit = '$1 bil';
        //elseif($revenue_arr[1] == 8)
        //    $lower_limit = '$0';

        if($revenue_arr[0] == 8 || $revenue_arr[1] == 8)
            $revenue_limits = "> $1 bil";
        else
            $revenue_limits = $lower_limit." - ".$upper_limit;
    }
    else
    {
        if($revenue == 0)
            $lower_limit = '0';
        elseif($revenue == 1)
            $lower_limit = '$1 mil';
        elseif($revenue == 2)
            $lower_limit = '$10 mil';
        elseif($revenue == 3)
            $lower_limit = '$50 mil';
        elseif($revenue == 4)
            $lower_limit = '$100 mil';
        elseif($revenue == 5)
            $lower_limit = '$250 mil';
        elseif($revenue == 6)
            $lower_limit = '$500 mil';
        elseif($revenue == 7)
            $lower_limit = '$1 bil';
        
        $revenue_limits = $lower_limit;
    }    
    return $revenue_limits;
    
}



function get_employee_size_limits($employee_size)
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $employee_size = trim($employee_size,",");
    //echo "<br>employee_size: ".$employee_size;
    $employee_size_arr = explode(",", $employee_size);
    //echo "<pre>employee_size_arr: ";   print_r($employee_size_arr);   echo "</pre>";
    
    if($employee_size_arr[0] == 0)
        $lower_revenue = $employee_size_arr[0];
    else    
        $lower_revenue = $employee_size_arr[0]+1;
    
    $upper_revenue = $employee_size_arr[1];
    
    if($lower_revenue == 0)
        $lower_limit = 0;
    else
    {    
        $indResult = mysql_query("SELECT name FROM hre_employee_size where id = ".$lower_revenue);
        $indRow = mysql_fetch_array($indResult);
        {
            $lower_limit = $indRow['name'];
            
            $hif_pos = strpos($lower_limit,'-');
            if($hif_pos > -1)
            {
                $lower_limit = substr($lower_limit,0,$hif_pos);
            }
            
            //if($employee_size_arr[0] == 0)
            //    $lower_limit = 0;
            
            if($lower_revenue == 1)
                $lower_limit = 25;
            
        }
    }
    
    $indResult = mysql_query("SELECT name FROM hre_employee_size where id = ".$upper_revenue);
    $indRow = mysql_fetch_array($indResult);
    {
        $upper_limit = $indRow['name'];
        
        $hif_u_pos = strpos($upper_limit,'-');
        if($hif_u_pos > -1)
        {
            $upper_limit = substr($upper_limit,$hif_u_pos+1,strlen($upper_limit));
        } 
        
    }
    $employee_size = $lower_limit." - ".$upper_limit;
    return $employee_size;
    
    
}


function get_revenue_value($revenue)
{
    $revenue_real = "";
    if($revenue == 2)
        $revenue_real = '$0-1 Million';
    elseif($revenue == 3)
        $revenue_real = '$1-10 Million';
    elseif($revenue == 4)
        $revenue_real = '$10-50 Million';
    elseif($revenue == 5)
        $revenue_real = '$50-100 Million';
    elseif($revenue == 6)
        $revenue_real = '$100-250 Million';
    elseif($revenue == 7)
        $revenue_real = '$250-500 Million';
    elseif($revenue == 8)
        $revenue_real = '$500M-1 Billion';
    elseif($revenue == 9)
        $revenue_real = '> $1 Billion';
    return $revenue_real;
}

function get_emp_size_value($emp_size)
{
    $revenue_real = "";
    if($emp_size == 1)
        $revenue_real = '0-25';
    elseif($emp_size == 2)
        $revenue_real = '25-100';
    elseif($emp_size == 3)
        $revenue_real = '100-250';
    elseif($emp_size == 4)
        $revenue_real = '250-1000';
    elseif($emp_size == 5)
        $revenue_real = '1K-10K';
    elseif($emp_size == 6)
        $revenue_real = '10K-50K';
    elseif($emp_size == 7)
        $revenue_real = '50K-100K';
    elseif($revenue == 8)
        $revenue_real = '>100K';
    return $revenue_real;
}


function get_source_value($emp_size)
{
    $revenue_real = "";
    if($emp_size == 1)
        $revenue_real = 'Press Release';
    elseif($emp_size == 2)
        $revenue_real = 'News';
    elseif($emp_size == 3)
        $revenue_real = 'Blog';
    elseif($emp_size == 4)
        $revenue_real = 'SEC Filing';
    
    elseif($emp_size == 6)
        $revenue_real = 'Job Post';
    elseif($emp_size == 7)
        $revenue_real = 'Company Announcement';
    
    return $revenue_real;
}


function selectComboBox($sql,$selected_id,$database_source)
{
    //echo "<br>SQL: ".$sql; 
	$exe_query = com_db_query($sql);
	while($data_sql = com_db_fetch_row($exe_query)){
		if($selected_id == $data_sql[0]){
			$selected_str = ' selected="selected"';
		}else{
			$selected_str = '';
		}
		$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[1].'</option>' . "\r\n";
	}
	return 	$all_option;
}

function MultiSelectionComboBox($sql,$selected_id_arr){
	$exe_query = com_db_query($sql);
	while($data_sql = com_db_fetch_row($exe_query)){
		if(in_array($data_sql[0],$selected_id_arr)){
			$selected_str = ' selected="selected"';
		}else{
			$selected_str = '';
		}
		$all_option .= '<option value="'.$data_sql[0].'" '.$selected_str.'>'.$data_sql[1].'</option>' . "\r\n";
	}
	return 	$all_option;
}


function create_url($first_name = '',$last_name = '',$title = '',$company_name = '',$movement_id = '',$record_type = '')
{
    global $base_url;
    
    if(strlen($title) > 100)
        $title = substr($title,0,100);
    
    $created_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($first_name))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($last_name))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($title))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($company_name)).'_details_'.$record_type."_".$movement_id;
    $created_url = $base_url.$created_url; 
    return $created_url;
}        



function create_job_url($title = '',$company_name = '',$movement_id = '',$record_type = '')
{
    global $base_url;
    if(strlen($title) > 100)
        $title = substr($title,0,100);
    $created_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($title))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($company_name)).'_details_'.$record_type."_".$movement_id;
    $created_url = $base_url.$created_url; 
    return $created_url;
} 



function show_movements($first_name,$last_name,$movement_id,$personal_id,$company_name,$title,$email,$phone,$movement_type,$more_link,$personal_image,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    
    $sf = "";
    $personalURL = "";
    //$converted_date = date("M d, Y", strtotime($all_data[$i]['awards_date']));
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 

    $movement_text = "";
    if($movement_type == 1)
        $movement_text = " Appointed ";
    elseif($movement_type == 2)
        $movement_text = " Promoted";

    $share_text = "";
    $share_text = "Congrats ".$first_name." ". $last_name." on ".$movement_type." as ".$title." at ".$company_name;  //$all_data[$i]['company_name']
?>

    <li class="article">
        
        <?PHP
        if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_move_read_clicked'] != 1)
        {    
        ?> 
        
        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-1#" id="field-1#">
                    <label class="form-label" for="field-1#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <?PHP
        }
        ?>
        
        
        <span class="ico-article">
            <i class="ico-arrow-up-blue"></i>
        </span>

        <div class="article-image">
        <?PHP
        
        
        if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
        {

        }   
        else
            $personal_image = '';
        
        
        if($personal_image != '')
            $pic_src = $personal_pic_root."personal_photo/small/".$personal_image;
        else
            $pic_src = NO_PERSONAL_IMAGE;
        
        
        $detail_page_url = create_url($first_name,$last_name,$title,$company_name,$movement_id,'movements');
        //if($personal_image != '')
        //{    
        ?>
            <!-- <a href="details.php?id=<?=$movement_id?>&type=movements"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        //}
        //else
        //{    
        ?>    
           <!--  <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"> -->
        <?PHP
        //}
        ?>
        </div><!-- /.article-image -->
        
        <?PHP
        $width = 'width:85%;';
        //if($ind == 1)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
            $width = 'width:63%;';
        ?>
        <div class="article-content" style="<?=$width?>">
            <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> was <?=$movement_text?> as <?=$title?> at <?=$company_name?>
            <?PHP
            if($add_date != '')
                echo "- ".date("m.d.Y",strtotime($add_date)).".";
            ?>
            
            </p>
            <div class="socials">
                <ul>
                    <li>
                        <a target="_blank" href="<?=$personal_pic_root.$personalURL?>" class="note">
                            <i class="ico-note"></i>
                        </a>
                    </li>

                    <?PHP
                    if($more_link != '')
                    {    
                    ?>

                    <li>
                        <a target="_blank" href="<?=$more_link?>" class="upload">
                            <i class="ico-upload"></i>
                        </a>
                    </li>
                    <?PHP
                    }
                    ?>

                    <li>
                        <a target="_blank" href="<?=$sf?>" class="salesforce">
                            <i class="ico-salesforce"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>text=<?=$share_text?>&url=<?=$more_link?>" class="twitter">
                            <i class="ico-twitter"></i>
                        </a>

                        <!--
                         <a href="https://twitter.com/intent/tweet" class="twitter-share-button twitter">
                            <i class="ico-twitter"></i>
                        </a>   
                        -->    

                    </li>

                    <?PHP
                    if($more_link != '')
                    {    
                    ?>
                    
                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$more_link?>&title=<?=$share_text?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                    <?PHP
                    }
                    ?>
                    
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->

        
        <?PHP
        //echo "IND:".$ind.":";
        
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')    
        {    
        ?>
        
        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
            <!-- <a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" > -->	
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
        
        
        
    </li><!-- /.article -->

<?PHP
  
}


function show_awards($first_name,$last_name,$awards_id,$personal_id,$company_name,$title,$email,$phone,$personal_image,$awards_title,$awards_given_by,$awards_date,$awards_link,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    $profile_root_link = "https://www.hrexecsonthemove.com/";
    
    $converted_date = date("M d, Y", strtotime($awards_date));

    $personalURL = "";
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 

    $share_text = "";
    $share_text = "Congrats ".$first_name." ". $last_name." on ".$awards_title." ".$awards_link;  //$all_data[$i]['company_name']
?>

    <li class="article">
        <?PHP
        if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_award_read_clicked'] != 1)
        {    
        ?>
        
        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-3#" id="field-3#">
                    <label class="form-label" for="field-3#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->
        
        <?PHP
        }
        ?>
        
        <span class="ico-article">
            <i class="ico-cup"></i>
        </span>

        <div class="article-image">
        <?PHP
        
        if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
        {

        }   
        else
            $personal_image = '';
        
        
        
        
        if($personal_image != '')
            $pic_src = $personal_pic_root."personal_photo/small/".$personal_image;
        else
            $pic_src = NO_PERSONAL_IMAGE;
        
        $detail_page_url = create_url($first_name,$last_name,$awards_title,$company_name,$awards_id,'awards');
        
        //if($all_data[$i]['personal_image'] != '')
        //{    
        ?>
            <!-- <a href="details.php?id=<?=$awards_id?>&type=awards"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        //}
        //else
        //{    
        ?>
          <!--   <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"> -->
        <?PHP
        //}
        ?>
        </div><!-- /.article-image -->

        
        <?PHP
        $width = 'width:85%;';
        //if($ind == 1)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
            $width = 'width:63%;';
        
        $awards_title = trim($awards_title);
        //echo "<br>awards_title before: ".$awards_title;
        $aw_pos = '';
        $aw_pos = strpos($awards_title,"award");
        
        if($aw_pos === false)
        {
            $aws_pos = strpos($awards_title,"awards");
            if($aws_pos === false)
            {
                $awards_title = $awards_title." award";    
            }    
        }    
        
        //echo "<br>strpos: ".strpos($awards_title,"award");
        
        if(strpos($awards_title,"award") < 0 || strpos($awards_title,"award") == '')
            $awards_title = $awards_title." award";    
        
        
        //elseif(strpos($awards_title,"awards") < 0 || strpos($awards_title,"awards") == '')
        //    $awards_title = $awards_title." award";    
        //echo "<br>awards_title after: ".$awards_title;
        ?>
        
        <div class="article-content" style="<?=$width?>">
            <p>
                <a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> received <?=$awards_title?> from <?=$awards_given_by?> on <?=trim($converted_date)?><?PHP
                //if($add_date != '')
                //    echo ". (".date("m-d-Y",strtotime($add_date)).")";
                ?>
            </p>

            <div class="socials">
                <ul>
                    <li>
                        <a target="_blank" href="<?=$personal_pic_root.$personalURL?>" class="note">
                            <i class="ico-note"></i>
                        </a>
                    </li>
                    <?PHP
                    if($awards_link != '')
                    {    
                    ?>
                    <li>
                        <a target="_blank" href="<?=$awards_link?>" class="upload">
                            <i class="ico-upload"></i>
                        </a>
                    </li>
                    <?PHP
                    }
                    ?>
                    
                    
                    <li>
                        <a target="_blank" href="<?=$sf?>" class="salesforce">
                            <i class="ico-salesforce"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>text=<?=$share_text?>&original_referer=&nbsp;" class="twitter">
                            <i class="ico-twitter"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$awards_link?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->

        <?PHP
        //echo "IND:".$ind.":";
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '') 
        {    
        ?>
        
        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your industry award" target="_blank" class="btn btn-primary">
            <!-- <a href="#" class="btn btn-primary"> -->
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
        
        
    </li><!-- /.article --> 
<?PHP    
}



function show_speaking($first_name,$last_name,$speaking_id,$personal_id,$company_name,$title,$email,$phone,$personal_image,$event,$speaking_link,$event_date,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    if(isset($_SESSION['site']) && $_SESSION['site'] != '')
    {    
        $base_site = $_SESSION['site'];
        if($base_site == 'it')
            $profile_root_link = "https://www.ctosonthemove.com/";

        elseif($base_site == 'cfo')
            $profile_root_link = "https://www.cfosonthemove.com/";

        elseif($base_site == 'cmo')
            $profile_root_link = "https://www.cmosonthemove.com/";

        elseif($base_site == 'clo')
            $profile_root_link = "https://www.closonthemove.com/";
        //if($base_site == 'hr')
        //    $profile_root_link = "https://www.hrexecsonthemove.com/";
        else
            $profile_root_link = "https://www.hrexecsonthemove.com/";
    }
    
    
    //$profile_root_link = "https://www.hrexecsonthemove.com/";
    
    //$converted_date = date("M d, Y", strtotime($event_date));
    $converted_date = date("m.d.Y", strtotime($event_date)); 
    $personalURL = "";
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 

    $share_text = "";
    $share_text = $first_name." ".$last_name." is scheduled to speak at ".$event." on ".$converted_date;  //$all_data[$i]['company_name']
?>
    <li class="article">
    <?PHP
    if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_speaking_read_clicked'] != 1)
    {    
    ?>    
        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-2#" id="field-2#">

                    <label class="form-label" for="field-2#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

    <?PHP
    }
    ?>
        <span class="ico-article">
            <i class="ico-microphone"></i>
        </span>

        <div class="article-image">
            <?PHP
            
            //echo "<br>HTTP_REFERER: ".$_SERVER['HTTP_REFERER'];
            
            if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
            {
                
            }   
            else
                $personal_image = '';
            
            //echo "<br>personal_pic_root: ".$personal_pic_root;
            //echo "<br>personal_image: ".$personal_image;
            
            
            $detail_page_url = create_url($first_name,$last_name,$title,$company_name,$speaking_id,'speaking');
            
            if($personal_image != '')
            {    
            ?>
                <!-- <a href="details.php?id=<?=$speaking_id?>&type=speaking"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a>
            <?PHP
            }
            else
            {    
            ?>
                <!-- <a href="details.php?id=<?=$speaking_id?>&type=speaking"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                <a href="<?=$detail_page_url?>"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a>
            <?PHP
            }
            ?>
        </div><!-- /.article-image -->
        <?PHP
        //echo "<br>add_date:".$add_date.":";
        $width = 'width:85%;';
        //if($ind == 1)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
            $width = 'width:63%;';
        ?>
        <div class="article-content" style="<?=$width?>">
            <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> scheduled to speak at <?=$event?> on <?=$converted_date?>
                <?PHP
                //if($add_date != '')
                //    echo "- (".date("m.d.Y",strtotime($add_date)).")";
            ?></p>
            <div class="socials">
                <ul>
                    <li>
                        <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                            <i class="ico-note"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=$speaking_link?>" class="upload">
                            <i class="ico-upload"></i>
                        </a>
                    </li>

                    <li>
                        <!-- <a href="<?=$sf?>" class="salesforce"> -->
                        <a  onclick="getSalesForceLink('<?=$personal_id?>')" href="javascript:void(0)" class="salesforce"> 
                            <i class="ico-salesforce"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>text=<?=$share_text?>" class="twitter">
                            <i class="ico-twitter"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$speaking_link?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->
        
        <?PHP
        //echo "IND:".$ind.":";
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '') 
        {    
        ?>
        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your speaking" target="_blank" class="btn btn-primary">
            <!-- <a href="#" class="btn btn-primary"> -->
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
    </li><!-- /.article -->
<?PHP    
}


function show_media($first_name,$last_name,$speaking_id,$personal_id,$company_name,$title,$email,$phone,$personal_image,$publication,$more_link,$media_link,$pub_date,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    if(isset($_SESSION['site']) && $_SESSION['site'] != '')
    {    
        $base_site = $_SESSION['site'];
        if($base_site == 'it')
            $profile_root_link = "https://www.ctosonthemove.com/";

        elseif($base_site == 'cfo')
            $profile_root_link = "https://www.cfosonthemove.com/";

        elseif($base_site == 'cmo')
            $profile_root_link = "https://www.cmosonthemove.com/";

        elseif($base_site == 'clo')
            $profile_root_link = "https://www.closonthemove.com/";
        //if($base_site == 'hr')
        //    $profile_root_link = "https://www.hrexecsonthemove.com/";
        else
            $profile_root_link = "https://www.hrexecsonthemove.com/";
    }   
    
    
    
    //$profile_root_link = "https://www.hrexecsonthemove.com/";
    
    $personalURL = "";
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); //."&phone=".urlencode($sf_phone).

    $share_text = "";
    $share_text = $first_name." ". $last_name." was quoted by ".$publication." ".$media_link;  //$all_data[$i]['company_name']
    
    //$pub_date = date('m-d-Y',strtotime($pub_date));
    
?>
<li class="article">

    <?PHP
    if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_media_read_clicked'] != 1)
    {    
    ?>
    <ul class="list-checkboxes">
        <li>
            <div class="checkbox">
                <input type="checkbox" name="field-4#" id="field-4#">
                <label class="form-label" for="field-4#">1#</label>
            </div><!-- /.checkbox -->
        </li>
    </ul><!-- /.list-checkboxes -->
    <?PHP
    }
    ?>


    <span class="ico-article">
        <i class="ico-newspaper"></i>
    </span>

    <div class="article-image">

        <?PHP
        //echo "<br>personal_image: ".$personal_image;
        //echo "<br>personal_pic_root: ".$personal_pic_root;
        //echo "<br>HTTP_REFERER: ".$_SERVER['HTTP_REFERER'];
        
        $detail_page_url = create_url($first_name,$last_name,$title,$company_name,$speaking_id,'media');
        
        if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
        {

        }   
        else
            $personal_image = '';
        
        
        if($personal_image != '')
        { 
        ?>
            <!-- <a href="details.php?id=<?=$speaking_id?>&type=media_mention"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        }
        else
        {      
        ?>    
            <!-- <a href="details.php?id=<?=$speaking_id?>&type=media_mention"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        }
        ?>
    </div><!-- /.article-image -->

    
    
    <?PHP
    $pub_date = date("m-d-Y", strtotime($pub_date));
    
    $width = 'width:85%;';
        //if($ind == 1)
    if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
        $width = 'width:63%;';
    ?>
    <div class="article-content" style="<?=$width?>">
        <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> was quoted by <?=$publication?> on <?=trim($pub_date)?><?PHP
            //if($add_date != '')
            //    echo ". (".date("m-d-Y",strtotime($add_date)).")";
            ?>
        </p>    
        <div class="socials">
            <ul>
                <li>
                    <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                        <i class="ico-note"></i>
                    </a>
                </li>


                <?PHP
                if($more_link != '')
                {    
                ?>
                <li>
                    <a target="_blank" href="<?=$more_link?>" class="upload">
                        <i class="ico-upload"></i>
                    </a>
                </li>
                <?PHP
                }
                ?>


                <li>
                    <!-- <a target="_blank" href="<?=$sf?>" class="salesforce"> -->
                    <a  onclick="getSalesForceLink('<?=$personal_id?>')" href="javascript:void(0)" class="salesforce"> 
                        <i class="ico-salesforce"></i>
                    </a>
                </li>

                <li>
                    <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                        <i class="ico-twitter"></i>
                    </a>
                </li>

                <li>
                    <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$media_link?>" class="linkedin">
                        <i class="ico-linkedin"></i>
                    </a>
                </li>
            </ul>
        </div><!-- /.socials -->
    </div><!-- /.article-content -->

    
    <?PHP
    //if($ind == 0)
    if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '') 
    {    
    ?>
    <div class="article-actions">
        <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your media mention" target="_blank" class="btn btn-primary">
        <!-- <a href="#" class="btn btn-primary"> -->
            <span>Email now</span>
            <i class="ico-arrow-right"></i>
        </a>
    </div><!-- /.article-actions -->
    <?PHP
    }
    ?>
    
    
</li><!-- /.article -->
<?PHP
}




function show_funding($first_name,$last_name,$funding_id,$personal_id,$company_id,$company_logo,$company_name,$title,$email,$phone,$personal_image,$funding_source,$funding_amount,$funding_date,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    
    if(isset($_SESSION['site']) && $_SESSION['site'] != '')
    {    
        $base_site = $_SESSION['site'];
        if($base_site == 'it')
            $profile_root_link = "https://www.ctosonthemove.com/";

        elseif($base_site == 'cfo')
            $profile_root_link = "https://www.cfosonthemove.com/";

        elseif($base_site == 'cmo')
            $profile_root_link = "https://www.cmosonthemove.com/";

        elseif($base_site == 'clo')
            $profile_root_link = "https://www.closonthemove.com/";
        //if($base_site == 'hr')
        //    $profile_root_link = "https://www.hrexecsonthemove.com/";
        else
            $profile_root_link = "https://www.hrexecsonthemove.com/";
    }
    
    //$profile_root_link = "https://www.hrexecsonthemove.com/";
    
    $dim_url = "";
    $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $company_name).'_Company_'.$company_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); //."&phone=".urlencode($sf_phone).

    $share_text = "";
    //$share_text = $all_data[$i]['company_name']." raised ".$all_data[$i]['funding_amount']." and ".$all_data[$i]['first_name']." ".$all_data[$i]['last_name']." is the decision maker";
    $share_text = $company_name." raised ".$funding_amount." in Funding &url=".$funding_source;

    ?>
    <li class="article article-secondary">


        <?PHP
        if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_funding_read_clicked'] != 1)
        {    
        ?> 

        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-6#" id="field-6#">
                    <label class="form-label" for="field-6#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <?PHP
        }
        ?>

        <span class="ico-article">
            <i class="ico-cash"></i>
        </span>

        <?PHP
        $funding_date = date("m.d.Y", strtotime($funding_date));
        //echo "<pre>all_data: ";   print_r($all_data);   echo "</pre>";
        ?>
        <div class="article-content-secondary">
            <!-- <a href="#" class="logo-cashstar">Cashstar</a> -->
            <a href="#" class="logo-cashstar"><img src="https://www.ctosonthemove.com/company_logo/thumb/<?=$company_logo?>"></a>
            <div class="article-inner-secondary">
                <p><?=$company_name?> raised <?=$funding_amount?> on <?=$funding_date?></p>
                <div class="socials">
                    <ul>
                        <li>
                            <a target="_blank" href="<?=$profile_root_link.$dim_url?>" class="note">
                                <i class="ico-note"></i>
                            </a>
                        </li>

                        <li>
                            <a target="_blank" href="<?=$funding_source?>" class="upload"><i class="ico-upload"></i></a>
                        </li>
                    </ul>
                </div><!-- /.socials-secondary -->
            </div><!-- /.article-inner-secondary -->
        </div><!-- /.article-content-secondary -->

        <div class="article-inner">
            <div class="article-image">
                <a href="#">
                    <?PHP
                    
                    if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                    {

                    }   
                    else
                        $personal_image = '';
                    
                    
                    
                    $detail_page_url = create_url($first_name,$last_name,$title,$company_name,$funding_id,'funding');
                    
                    if($personal_image != '')
                    {    
                    ?>
                        <!-- <a href="details.php?id=<?=$funding_id?>&type=funding"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                        <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a>
                    <?PHP
                    }
                    else
                    {    
                    ?>   
                        <!-- <a href="details.php?id=<?=$funding_id?>&type=funding"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                        <a href="<?=$detail_page_url?>"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a>
                    <?PHP
                    }
                   ?>         
                </a>
            </div><!-- /.article-image -->
            
            
            <?PHP
            $width = 'width:85%;';
            //if($ind == 1)
            if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
                $width = 'width:63%;';
            ?>

            <div class="article-content" style="<?=$width?>">
                <p><?=$first_name?> <?=$last_name?>, <?=$title?> at <?=$company_name?>, is the decision maker</p>

                <div class="socials">
                    <ul>
                        <li>
                            <a href="<?=$sf?>" class="salesforce">
                                <i class="ico-salesforce"></i>
                            </a>
                        </li>

                        <li>
                            <!-- <a href="<?=$twitter_share_link?>text=<?=$share_text?>&url=<?=$funding_source?>" class="twitter"> -->
                            <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>text=<?=$share_text?>" class="twitter">
                                <i class="ico-twitter"></i>
                            </a>
                        </li>

                        <li>
                            <!-- <a href="<?=$linkedin_share_link?>summary=fddffs&url=<?=$all_data[$i]['funding_source']?>" class="linkedin"> -->
                            <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$funding_source?>" class="linkedin">
                                <i class="ico-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div><!-- /.socials -->
            </div><!-- /.article-content -->
        </div><!-- /.article-inner -->

        
        <?PHP
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '') 
        {    
        ?>
        
        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your company funding" target="_blank" class="btn btn-primary">
            <!--	<a href="#" class="btn btn-primary"> -->
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
        
        
    </li><!-- /.article -->
<?PHP    
}


function show_job($first_name,$last_name,$job_id,$personal_id,$company_id,$company_logo,$company_name,$title,$email,$phone,$personal_image,$job_title,$post_date,$source,$personal_pic_root,$company_pic_root,$add_date = '',$show_state='',$ind=0)
{
    $profile_root_link = "https://www.hrexecsonthemove.com/";
    
    $dim_url = "";
    $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $company_name).'_Company_'.$company_id;


    $share_text = "";
    $share_text = $company_name." looking to hire ".$job_title." in ".$location." ".$source;  //$all_data[$i]['company_name']
    $post_date = date("m-d-Y", strtotime($post_date));
?>
    <li class="article">

        <?PHP
        if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_job_read_clicked'] != 1)
        {    
        ?>


        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-7#" id="field-7#">
                    <label class="form-label" for="field-7#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <?PHP
        }
        ?>


        <span class="ico-article">
            <i class="ico-forma"></i>
        </span>

        <div class="article-image">

            <?PHP
            $detail_page_url = create_job_url($job_title,$company_name,$job_id,'jobs');
            
            
            if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
            {

            }   
            else
                $company_logo = '';

            
            
            if($company_logo != '')
            {    
            ?>
                <!-- <a href="details.php?id=<?=$job_id?>&type=jobs"><img src="<?=$company_pic_root?>/company_logo/org/<?=$company_logo?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                <a href="<?=$detail_page_url?>"><img src="<?=$company_pic_root?>/company_logo/org/<?=$company_logo?>" height="80" width="80" alt="" class="article-avatar"></a>
            <?PHP
            }
            else
            {    
            ?>   
                <!-- <a href="details.php?id=<?=$job_id?>&type=jobs"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a> -->
                <a href="<?=$detail_page_url?>"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a>
            <?PHP
            }
           ?> 
        </div><!-- /.article-image -->

        
        <?PHP
        $width = 'width:85%;';
            //if($ind == 1)
            if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
                $width = 'width:63%;';
        ?>
        <div class="article-content" style="<?=$width?>">
            <p><?=$company_name?> looking to hire <?=$job_title?> in <?=$location?>– published on <?=$post_date?><?PHP
                if($add_date != '')
                    echo ". (".date("m-d-Y",strtotime($add_date)).")";
            ?></p>

            <div class="socials">
                <ul>
                    <li>
                        <a href="<?=$profile_root_link.$dim_url?>" class="note">
                            <i class="ico-note"></i>
                        </a>
                    </li>
                    <?PHP
                    if($source != '')
                    {    
                    ?>
                    <li>
                        <a target="_blank" href="<?=$source?>" class="upload">
                            <i class="ico-upload"></i>
                        </a>
                    </li>
                    <?PHP
                    }
                    ?>


                    <li>
                        <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                            <i class="ico-twitter"></i>
                        </a>
                    </li>

                    
                    <?PHP
                    if($source != '')
                    {    
                    ?>
                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$source?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                    <?PHP
                    }
                    ?>
                    
                    
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->

        <?PHP
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')     
        {    
        ?>
        
        <div class="article-actions">
            <a href="<?=$source?>" class="btn btn-primary btn-secondary">
                <span>Apply now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
        
    </li><!-- /.article -->
    <?PHP
}




function show_publication($first_name,$last_name,$publication_id,$personal_id,$company_name,$title,$email,$phone,$personal_image,$move_title,$link,$publication_date,$personal_pic_root,$add_date = '',$show_state='',$ind=0)
{
    
    if(isset($_SESSION['site']) && $_SESSION['site'] != '')
    {    
        $base_site = $_SESSION['site'];
        if($base_site == 'it')
            $profile_root_link = "https://www.ctosonthemove.com/";

        elseif($base_site == 'cfo')
            $profile_root_link = "https://www.cfosonthemove.com/";

        elseif($base_site == 'cmo')
            $profile_root_link = "https://www.cmosonthemove.com/";

        elseif($base_site == 'clo')
            $profile_root_link = "https://www.closonthemove.com/";
        //if($base_site == 'hr')
        //    $profile_root_link = "https://www.hrexecsonthemove.com/";
        else
            $profile_root_link = "https://www.hrexecsonthemove.com/";
    }
    
    
    //$profile_root_link = "https://www.hrexecsonthemove.com/";
    
    $personalURL = "";
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($move_title)."&email=".urlencode($email)."&phone=".urlencode($phone); //."&phone=".urlencode($sf_phone).

    $share_text = "";
    $share_text = $first_name." ". $last_name." authored ".$title." ".$link;  //$all_data[$i]['company_name']


    ?>
    <li class="article">
        <?PHP
        //echo "<br>mark_read_clicked: ".$_SESSION['mark_read_clicked'];
        if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_pub_read_clicked'] != 1)
        {    
        ?>


        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-5#" id="field-5#">
                    <label class="form-label" for="field-5#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <?PHP
        }
        ?>


        <span class="ico-article">
                <i class="ico-book"></i>
        </span>

        <div class="article-image">
        <?PHP
        
        $detail_page_url = create_url($first_name,$last_name,$title,$company_name,$publication_id,'publication');
        
        
        if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
        {

        }   
        else
            $personal_image = '';
        
        
        
        if($personal_image != '')
        {    
        ?>
            <!-- <a href="details.php?id=<?=$publication_id?>&type=publication"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$personal_image?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        }
        else
        {    
        ?>    
            <!-- <a href="details.php?id=<?=$publication_id?>&type=publication"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a> -->
            <a href="<?=$detail_page_url?>"><img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"></a>
        <?PHP
        }
        ?>
        </div><!-- /.article-image -->

        
        <?PHP
        $publication_date = date("m-d-Y", strtotime($publication_date));
        $width = 'width:85%;';
            //if($ind == 1)
            if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
                $width = 'width:63%;';
        ?>
        <div class="article-content" style="<?=$width?>">
            <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> published "<?=$title?>" on <?=$publication_date?><?PHP
                //if($add_date != '')
                //    echo ". (".date("m-d-Y",strtotime($add_date)).")";
            ?></p>

            <div class="socials">
                <ul>
                    <li>
                        <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                            <i class="ico-note"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=$link?>" class="upload">
                            <i class="ico-upload"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=$sf?>" class="salesforce">
                            <i class="ico-salesforce"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                            <i class="ico-twitter"></i>
                        </a>
                    </li>

                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$link?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->

        
        <?PHP
        //if($ind == 0)
        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')     
        {    
        ?>
        
        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your publication" target="_blank" class="btn btn-primary">
            <!-- <a href="#" class="btn btn-primary"> -->
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
        <?PHP
        }
        ?>
        
    </li><!-- /.article -->    
<?PHP    
}




function get_missing_data($personal_id)
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $indResult = mysql_query("SELECT cm.company_website,cm.company_name,mm.title FROM hre_personal_master as pm,hre_movement_master as mm,hre_company_master as cm where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and pm.personal_id = ".$personal_id." order by move_id desc",$site);
    //echo "<br>SELECT cm.company_name,mm.title FROM hre_personal_master as pm,hre_movement_master as mm,hre_company_master as cm where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and pm.personal_id = $personal_id";
    $return_data = array();
    $indRow = mysql_fetch_array($indResult);
    {
        //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
        $return_data['company_name'] = $indRow['company_name'];
        $return_data['title'] = $indRow['title'];
        $return_data['company_website'] = $indRow['company_website'];
    }
    return $return_data;
}





function get_companies()
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $table_company_master = "hre_company_master";
    if(isset($_SESSION['site']) && $_SESSION['site'] == 'hr')
    {  
        $table_personal_master = "hre_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'cto')
    {  
        $table_personal_master = "cto_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'ciso')
    {  
        $table_personal_master = "cto_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'cso')
    {  
        $table_personal_master = "cmo_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'clo')
    {  
        $table_personal_master = "clo_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'cfo')
    {  
        $table_personal_master = "cfo_personal_master";
    }
    elseif(isset($_SESSION['site']) && $_SESSION['site'] == 'cmo')
    {  
        $table_personal_master = "cmo_personal_master";
    }
    
    
    $indResult = mysql_query("select cm.company_name,cm.company_id
        FROM ".$table_company_master." as cm
        ",$site); 
        
        
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr[$indRow['company_name']] = $indRow['company_name'];
    }
    
      
     
    $indResult = mysql_query("select personal_id,first_name,last_name FROM ".$table_personal_master."",$site); 
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr['pers_'.$indRow['personal_id']] = $indRow['first_name']." ".$indRow['last_name'];
    }
    
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function get_companies_with_url()
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    $table_company_master = "hre_company_master";
    $table_personal_master = "hre_personal_master";
    
    $indResult = mysql_query("select cm.company_name,cm.company_website,cm.company_id
        FROM ".$table_company_master." as cm
        ",$site); 
        
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr[] = $indRow['company_name'];
        $data_arr[] = $indRow['company_website'];
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function get_all_registered_users()
{
    $indResult = com_db_query("select * FROM ".TABLE_USER." where level != 'admin'"); 
    $data_arr = array();    
    //while($indRow = mysql_fetch_array($indResult))
    while($indRow = com_db_fetch_array($indResult))
    {
        $data_arr[$indRow['user_id']]['user_id'] = $indRow['user_id'];
        $data_arr[$indRow['user_id']]['first_name'] = $indRow['first_name'];
        $data_arr[$indRow['user_id']]['last_name'] = $indRow['last_name'];
        $data_arr[$indRow['user_id']]['email'] = $indRow['email'];
        $data_arr[$indRow['user_id']]['status'] = $indRow['status'];
        $data_arr[$indRow['user_id']]['form_type'] = $indRow['form_type'];
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function get_user($user_id)
{
    $indResult = com_db_query("select * FROM ".TABLE_USER." where user_id = ".$user_id); 
    $data_arr = array();    
    //while($indRow = mysql_fetch_array($indResult))
    while($indRow = com_db_fetch_array($indResult))
    {
        $data_arr['user_id'] = $indRow['user_id'];
        $data_arr['first_name'] = $indRow['first_name'];
        $data_arr['last_name'] = $indRow['last_name'];
        $data_arr['email'] = $indRow['email'];
        $data_arr['status'] = $indRow['status'];
        $data_arr['password'] = $indRow['password'];
        $data_arr['site'] = $indRow['site'];
        $data_arr['text_only'] = $indRow['text_only'];
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function get_admin()
{
    $indResult = com_db_query("select * FROM ".TABLE_USER." where level = 'admin'"); 
    $data_arr = array();    
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr['user_id'] = $indRow['user_id'];
        $data_arr['first_name'] = $indRow['first_name'];
        $data_arr['last_name'] = $indRow['last_name'];
        $data_arr['email'] = $indRow['email'];
        $data_arr['password'] = $indRow['password'];
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function update_admin($first_name,$last_name,$email,$password)
{
    com_db_query("UPDATE ".TABLE_USER." set first_name='".$first_name."',last_name='".$last_name."',email='".$email."',password='".$password."' where level='admin'");	
}


function delete_user($user_id)
{
    $delResult = com_db_query("DELETE FROM ".TABLE_USER." where user_id = ".$user_id); 
}



function get_cities()
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    $table_company_master = "hre_company_master";
    
    $indResult = mysql_query("select distinct city FROM ".$table_company_master."",$site); 
        
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr[] = $indRow['city'];
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    return $data_arr;
}


function add_user($name,$email,$password,$status,$last_name = '',$form_type = '',$text_only = '',$site = '')
{
    //com_db_query("INSERT into ".TABLE_USER."(first_name,email,status,add_date) values('".$name."','".$email."','".$status."','".date("Y-m-d:H:i:s")."')");	
    com_db_query("INSERT into ".TABLE_USER."(first_name,email,password,status,last_name,form_type,add_date,text_only,site) values('".$name."','".$email."','".$password."','".$status."','".$last_name."','".$form_type."','".date("Y-m-d:H:i:s")."','".$text_only."','".$site."')");	    
} 


function update_user($name,$email,$password,$status,$user_id,$user_site,$text_only)
{
    com_db_query("UPDATE ".TABLE_USER." set first_name='".$name."',email='".$email."',status='".$status."',password='".$password."',site='".$user_site."',text_only='".$text_only."' where user_id=".$user_id);	
} 

// Redirect to another page or site
 function com_redirect($url) {
    header('Location: ' . $url);
    exit;
  }






/**********  DB Connection *********************/
function com_db_connect($server = EXEC_SERVER_IP, $username = EXEC_DB_USER_NAME, $password = EXEC_DB_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $link;
    // Just use mysql_connect in below line
    //$link = mysql_connect($server, $username, $password,"exec"); 
    $link = mysqli_connect($server, $username, $password,"exec");  
      
    
    if (!$link) 
    {
        
        $message = "Execfile Website is Down";
        // Send
        mail('faraz_aleem@hotmail.com', 'Execfile Website Down', $message);
        
        
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
      
      
    if ($link) mysql_select_db($database);
    return $link;
}


function com_db_connect_hre2($server = EXEC_SERVER_IP, $username = EXEC_DB_USER_NAME, $password = EXEC_DB_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $link;
    // Just use mysql_connect in below line
    //$link = mysql_connect($server, $username, $password,"exec"); 
    $link = mysqli_connect($server, $username, $password,"hre2");  
      
    
    
    
    
    
    if (!$link) 
    {
        $message = "Execfile Website is Down";
        // Send
        mail('faraz.aia@nxvt.com', 'Execfile Website Down', $message);
        //die("HERE");
        
        
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
      
      
    if ($link) mysql_select_db($database);
    return $link;
}
  
  
function com_db_query($query) 
{
     global $link; // Uncomment it for mysqli
     
    // Below line for old mysql 
    //$qid = mysql_query($query);
    
    //echo "<br>query : ".$query;
    // Below to use for mysqli
    
    $qid = $link->query($query);
    //echo "<br>Num Rows: ".$qid->num_rows;
    /*
    while ($row = $qid->fetch_row()) 
    {
        //printf("%s (%s,%s)\n", $row[0], $row[1], $row[2]);
        echo "<pre>ROW: ";   print_r($row);   echo "</pre>";
    }
    */

    if (!$qid) 
    {

        echo "<h2>Can't execute query</h2>";
        echo "<pre>" . htmlspecialchars($query) . "</pre>";
        echo "<p><b>MySQL Error</b>: ", mysql_error();
        echo "<p>This script cannot continue, terminating.";
        die();
    }

    return $qid;
}  
  
  
function com_db_fetch_row($qid) {
    //return mysql_fetch_row($qid);
    return $qid->fetch_row();
}  
  
function com_db_output($string) {
	return stripslashes($string);
}  
  
function com_db_GetValue($sql){
	$exe_query = com_db_query($sql);
	$num_row=com_db_num_rows($exe_query);
	if($num_row > 0){
		$data=com_db_fetch_row($exe_query);
		return $data[0];
	}else{
		return '';
	}
}

function com_db_input($string) {
    return addslashes($string);
}

function com_db_num_rows($qid) {

	// return mysql_num_rows($qid);  // For older mysql
        return $qid->num_rows;
}

function com_db_insert_id() {

	return mysql_insert_id();
}
  
function com_db_fetch_array($qid,$param = MYSQL_ASSOC) {

	//return mysql_fetch_array($qid,$param); // For older mysql
        return $qid->fetch_array();
}


  
/**********  Pagination *********************/
function number_pages($main_page, $page_now, $total_items, $max_pages = "15", $max_per_page = "25", $extra = "")
{
	
	$max_pages--;
	$total_pages = (int) floor($total_items/$max_per_page);
	if(($total_items % $max_per_page)) {
		$total_pages++;
	}

	$low_page = $page_now - floor($max_pages/2);
	if($low_page < 1) {
		$low_page = 1;
	}
	$high_page = $low_page + $max_pages;
	if($high_page > $total_pages) {
		$high_page = $total_pages;
		if($total_pages > $max_pages) {
			$low_page = $high_page - $max_pages;
		}
	}
	
	//$output = "Pages :";
        $output = "";
	if ($total_pages > 1) {
		if($page_now > 1)
		{
			
			//$output.='<a  href="'. $main_page.'?p='.($page_now-1).$extra .'">&lt;&lt; Prev Page</a>';
                        $output.='<a class=btn-prev href="'. $main_page.'?p='.($page_now-1).$extra .'"><i class=ico-arrow-left></i><span>Prev Page</span></a>';
			
		} else {
			
			//$output.='&nbsp;&lt;&lt; Previous';
                        //$output.='Previous';
		}
		
		
			//$output.='<p>';
		
		for($i=$low_page;$i<=$high_page;$i++) {
			if($i==$page_now)
			{
				$output.='<a href="#" class="active">' . $i . '</a>';
			} else {
				if($i > $total_pages) {
					$output .= " ".$i;
				} else {
					$output.='<a href="'.$main_page.'?p='.$i.$extra.'">'.$i.'</a>';
				}
			}
		}
		//$output= substr($output,0, -1);
		
		//$output.='</p>';
		
		if($page_now<$total_pages)
		{
			//$output.='<a href="'.$main_page.'?p='.($page_now+1).$extra. '">Next &gt;&gt;</a>';
                        $output.='<a class=btn-next href="'.$main_page.'?p='.($page_now+1).$extra. '"><span>Next page</span><i class=ico-arrow-right></i></a>';
			
		} else {
			//$output.='Next &gt;&gt;';
                        $output.='';
		}
		return $output;
	} 
}


function admin_number_pages($main_page, $page_now, $total_items, $max_pages = "15", $max_per_page = "25", $extra = "")
{
	

	$max_pages--;
	$total_pages = (int) floor($total_items/$max_per_page);
	if(($total_items % $max_per_page)) {
		$total_pages++;
	}

	$low_page = $page_now - floor($max_pages/2);
	if($low_page < 1) {
		$low_page = 1;
	}
	$high_page = $low_page + $max_pages;
	if($high_page > $total_pages) {
		$high_page = $total_pages;
		if($total_pages > $max_pages) {
			$low_page = $high_page - $max_pages;
		}
	}
	
	
	$output = "";
	if ($total_pages > 1) {
		if($page_now > 1)
		{
			//$output.="Page [<a href='".$main_page."?p=1".$extra."'>1</a>] &nbsp;&nbsp;";
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong><a href='".$main_page."?p=".($page_now-1).$extra."'>&lt;&lt;Prev</a></strong></td>";
			
			//$output.="<a href='".$main_page."?p=".($page_now-1).$extra."'>&laquo; Prev</a> &nbsp;&nbsp;";
		} else {
			//$output.="<font class=pagelink>Page [1]  &nbsp;&nbsp; &laquo; prev &nbsp;&nbsp;</font>";
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong>&lt;&lt;Prev</a></strong></td>";
			
			
		}
		for($i=$low_page;$i<=$high_page;$i++) {
			if($i==$page_now)
			{
				$output.="<td width='15' align='center' valign='middle' class='pagination-text'><a href='#' class='active'>" . $i . "</a></td>";
			} else {
				if($i > $total_pages) {
					$output .= " ".$i." |";
				} else {
					//$output.=" <a href='".$main_page."?p=".$i.$extra."' class=pagelink>".$i."</a> |";
					$output.="<td width='15' align='center' valign='middle' class='pagination-text'><a href='".$main_page."?p=".$i.$extra."'>".$i."</a></td>";
				}
			}
		}
		//$output= substr($output,0, -1);
		if($page_now<$total_pages)
		{
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong><a href='".$main_page."?p=".($page_now+1).$extra."'>Next&gt;&gt;</a></strong></td>";
			//$output.="&nbsp;&nbsp; <a href='".$main_page."?p=".($page_now+1).$extra."'> Next &raquo;</a> ";
			//$output.= "&nbsp;&nbsp; <a href='".$main_page."?p=".$total_pages.$extra."'>[$total_pages]</a>";
		} else {
			//$output.="&nbsp;&nbsp; Next &raquo; &nbsp;&nbsp; [$total_pages]";
			
			$output.="<td align='center' valign='middle' class='pagination-next-prev-text'><strong>Next&gt;&gt;</strong></td>";
		}
		return $output;
	} 
}






//Check Admin login
function com_admin_check_login() {
  //global $PHP_SELF, $login_groups_id;
  if (!$_SESSION['login_id']){
    com_redirect('login.php');
  } else {
	//$filename = basename( $PHP_SELF );
  }  
}

function subDate($days){
$date = date('Y-m-j');
$duration='-'.$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}


function addDate($days){
$date = date('Y-m-j');
$duration='+'.$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}


function get_salesforce_link($personal_id)
{
 //echo "<br>Personal_id: ".$personal_id;  
    $execfile_root = "http://www.execfile.com";
    $table_personal_master          = "hre_personal_master";
    $table_personal_speaking        = "hre_personal_speaking";
    $table_movement_master          = "hre_movement_master";
    $table_company_master           = "hre_company_master";
    $table_personal_awards          = "hre_personal_awards";
    $table_personal_media_mention   = "hre_personal_media_mention";
    $table_personal_publication     = "hre_personal_publication";
    $table_management_change        = "hre_management_change";
    $table_company_job              = "hre_company_job_info";
    $table_company_funding          = "hre_company_funding";
    $table_company_industry         = "hre_industry";
    $table_company_state            = "hre_state";
    
    
    
    
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
   
    $where_personal_clause = " and pm.personal_id = ".$personal_id;
    
    $indResult = mysql_query("select pm.personal_id,first_name,last_name,
            pm.email as email,pm.phone,cm.company_name,mm.title
            from 
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm
             where (mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id)
            $where_personal_clause 
             limit 1",$site);
    /*
    echo "<br>Q: select pm.personal_id,first_name,last_name,
            pm.email as email,pm.phone,cm.company_name,mm.title
            from 
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm
             where (mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id)
            $where_personal_clause 
             limit 1";
    */

    while($indRow = mysql_fetch_array($indResult))
    {
        //$data_arr[$data]['move_id'] = $indRow['move_id'];
        
        $first_name = $indRow['first_name'];
        $last_name = $indRow['last_name'];
        $company_name = $indRow['company_name'];
        $title = $indRow['title'];
        $email = $indRow['email'];
        $phone = $indRow['phone'];
        //echo "<br>first_name: ".$first_name;
        
        $sf = "";
        $sf = $execfile_root."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 
        //$sf = "/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 
        echo $sf;
    }
    
    
    
}


function get_org_chart_data($company)
{
    $table_personal_master          = "hre_personal_master";
    $table_movement_master          = "hre_movement_master";
    $table_company_master           = "hre_company_master";
    
    //$hre = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    //echo "<pre>HRE: ";   print_r($hre);echo "</pre>";
    
    $site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $chart_arr = array(); 
    
    /*
    $get_personal = "select pm.personal_id,pm.first_name,pm.last_name,pm.level,pm.personal_image,cm.company_name,mm.title from ".$table_personal_master." as pm,"
            .$table_movement_master." as mm,"
            .$table_company_master." as cm
            where (pm.personal_id = mm.personal_id and cm.company_id = mm.company_id) and cm.company_website = '".$company."' order by level asc,level_order ASC";
    */
    
    
    /*
     Below query working fine when we have level_oder in number 
     */
    
    /*
    $max_level_q = "select max(level) as max_level from ".$table_personal_master." as pm,"
            .$table_movement_master." as mm,"
            .$table_company_master." as cm
            where  (pm.personal_id = mm.personal_id and cm.company_id = mm.company_id) and cm.company_website = '".$company."' order by level_order asc";
    */
    
    
    if($_SESSION['site'] == '' || $_SESSION['site'] == 'hr')
    {
        $table_name            = "hre_search_data";
    }
    elseif($_SESSION['site'] == 'cto' || $_SESSION['site'] == 'ciso')
    {
        $table_name            = "cto_search_data";
    }
    elseif($_SESSION['site'] == 'cfo')
    {
        $table_name            = "cfo_search_data";
    }
    elseif($_SESSION['site'] == 'cmo'  || $_SESSION['site'] == 'cso')
    {
        $table_name            = "cmo_search_data";
    }
    elseif($_SESSION['site'] == 'clo')
    {
        $table_name            = "clo_search_data";
    }
    
    
    $ciso_clause = "";
    if($_SESSION['site'] == 'ciso')
    {
        $ciso_clause = " and ciso_user = 1";
    } 
    
    $cso_clause = "";
    if($_SESSION['site'] == 'cso')
    {
        $cso_clause = " and cmo_user = 1";
    } 
    
    
    //$table_name = 'hre_search_data';
    
    $max_level_q = "select max(level) as max_level from ".$table_name." where company_website = '".$company."' || company_name = '".$company."' || company_urls = '".$company."'";
    //echo "<br>max_level_q: ".$max_level_q;
    $get_max_level = mysql_query($max_level_q);
    
    /*
     
    {
        die("<br><br>Invalid query First: " . mysql_error());
    }
    */
    
    $maxRow = mysql_fetch_array($get_max_level);
    $max_level = $maxRow['max_level'];
    
    
    //$max_level = 3;
    //echo "<br>max_level: ".$max_level;
    
    
    
    //$hre = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
    
    /*
    $get_personal_q = "select pm.personal_id,pm.first_name,pm.last_name,pm.level,pm.level_order,pm.personal_image,cm.company_name,mm.title from ".$table_personal_master." as pm,"
            .$table_movement_master." as mm,"
            .$table_company_master." as cm
            where  (pm.personal_id = mm.personal_id and cm.company_id = mm.company_id) and cm.company_website = '".$company."' order by level_order asc";
    */
    
    //$get_personal_q = "select d.`personal_id`,d.`first_name`,d.`last_name`,d.`level`,d.`level_order`,d.`personal_image`,d.`company_name`,d.`title` from `hre_search_data` AS d where d.`company_website` like '$company' order by level_order asc"; 
    $get_personal_q = "SELECT personal_id,first_name,last_name,level,level_order,personal_image,company_name,title FROM ".$table_name." WHERE (company_website =  '".$company."' || company_name = '".$company."'  || company_urls = '".$company."')  $ciso_clause $cso_clause ORDER BY level_order ASC LIMIT 0 , 30";
       
    //echo "<br>get_personal_q: ".$get_personal_q;
    //die();
    
    $output_level = "";
    $output_level_a = "";
    $output_level_b = "";
    $level_2 = 51; 
    $no_level = 2000;
    //echo "<br>get_personal: ".$get_personal;
    
    $get_personal_res = mysql_query($get_personal_q);
    //var_dump($get_personal_res);
    //die();
    /*
    if (!$get_personal_res) 
    {
        die("<br><br>Invalid query Secod: " . mysql_error());
    }
    */
    
    
    
    while($pRow = mysql_fetch_array($get_personal_res))
    {
        //if($pRow['level'] == 0)
        //    $pRow['level'] = 3;
       
        if($pRow['level'] == '' || $pRow['level'] == 0)
        {    
            $pRow['level'] = $max_level;
            //if($pRow['level_order'] == '')
            //{
            //    $pRow['level_order'] = 'z';
            //}    
        }
        
        if($pRow['level'] > 0 || 1 == 1)
        {    
            //echo "<br>Level: ".$pRow['level'];
            $personal_id = $pRow['personal_id'];
            $first_name = $pRow['first_name'];
            $last_name = $pRow['last_name'];
            $title = $pRow['title'];
            $company_name = $pRow['company_name'];
            $level = $pRow['level'];
            $level_order = $pRow['level_order'];
            $personal_image = $pRow['personal_image'];
            //$chart_arr[] = "*img:*".$personal_image."*".$first_name." ".$last_name." ".$title." ".$company_name."".$level;
            $chart_arr[$personal_id]['personal_id'] = $personal_id;
            $chart_arr[$personal_id]['first_name'] = $first_name;
            $chart_arr[$personal_id]['last_name'] = $last_name;
            $chart_arr[$personal_id]['title'] = $title;
            $chart_arr[$personal_id]['company_name'] = $company_name;
            $chart_arr[$personal_id]['level'] = $level;
            $chart_arr[$personal_id]['level_order'] = $level_order;
            $chart_arr[$personal_id]['personal_image'] = $personal_image;
            //$chart_arr[]
            
            
            if($level == 1)
            {
                $output_level = 1;
            }
            
            if($level == 2)
            {
                if($level_order == 'a')
                {
                   $output_level = $level_2;
                   $output_level_a = $output_level;
                   $level_2 = $level_2+200;
                }  
                
                if($level_order == 'b')
                {
                   $output_level = $level_2;
                   $output_level_b = $output_level;
                   $level_2 = $level_2+200;
                   $output_level_b = $level_2;
                }  
                
            }    
            
            
            if($level == 3)
            {
                if($level_order == 'a')
                {
                   $output_level_a = $output_level_a+2;
                   $output_level = $output_level_a;
                }  
                
                if($level_order == 'b')
                {
                   $output_level_b = $output_level_b+2;
                   $output_level = $output_level_b;
                }  
                
            }
            
            if($level == '')
            {
                $output_level = $no_level;
                $no_level = $no_level+2; 
            }
            $chart_arr[$personal_id]['generated_level'] = $output_level;
             
            
        }
        
    }
    //echo "<pre>chart_arr:";   print_r($chart_arr);   echo "</pre>";
    //    die();
    return $chart_arr;
}
?>

