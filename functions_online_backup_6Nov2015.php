<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


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


function get_all_data($id='',$type='',$func = '',$from_date = '',$to_date='',$zip='',$searchnow = '',$city = '',$company = '',$industries_ids = '',$state_ids ='',$revenue = '',$employee_size = '',$display_type = '')
{
    //echo "<br>searchnow: ".$searchnow;
    
    com_db_connect() or die('Unable to connect to database server!');
    $move_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'");
    //echo "<br>move_last_id_db: ".$move_last_id_db; die();
    
    if($func == '')
    {
        $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
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
        
    }
    elseif($func == 'it')
    {
        $site = mysql_connect(CTO_SERVER_IP,CTO_DB_USER_NAME,CTO_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
        mysql_select_db("ctou2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "cto_personal_master";
        $table_personal_speaking        = "cto_personal_speaking";
        $table_movement_master          = "cto_movement_master";
        $table_company_master           = "cto_company_master";
        $table_personal_awards          = "cto_personal_awards";
        $table_personal_media_mention   = "cto_personal_media_mention";
        $table_personal_publication     = "cto_personal_publication";
        $table_management_change        = "cto_management_change";
        $table_company_job              = "cto_company_job_info";
        $table_company_funding          = "cto_company_funding";
        $table_company_industry         = "cto_industry";
        $table_company_state            = "cto_state";
    }
    elseif($func == 'cfo')
    {
        $site = mysql_connect("10.132.233.66","cfo2","cV!kJ201Ze",TRUE) or die("Database ERROR ");
        mysql_select_db("cfo2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "cfo_personal_master";
        $table_personal_speaking        = "cfo_personal_speaking";
        $table_movement_master          = "cfo_movement_master";
        $table_company_master           = "cfo_company_master";
        $table_personal_awards          = "cfo_personal_awards";
        $table_personal_media_mention   = "cfo_personal_media_mention";
        $table_personal_publication     = "cfo_personal_publication";
        $table_management_change        = "cfo_management_change";
        $table_company_job              = "cfo_company_job_info";
        $table_company_funding          = "cfo_company_funding";
        $table_company_industry         = "cfo_industry";
        $table_company_state            = "cfo_state";
    }
    elseif($func == 'cmo')
    {
        $site = mysql_connect("10.132.232.238","cmo1","mocos!cm123",TRUE) or die("Database ERROR ");
        mysql_select_db("cmo1",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "cmo_personal_master";
        $table_personal_speaking        = "cmo_personal_speaking";
        $table_movement_master          = "cmo_movement_master";
        $table_company_master           = "cmo_company_master";
        $table_personal_awards          = "cmo_personal_awards";
        $table_personal_media_mention   = "cmo_personal_media_mention";
        $table_personal_publication     = "cmo_personal_publication";
        $table_management_change        = "cmo_management_change";
        $table_company_job              = "cmo_company_job_info";
        $table_company_funding          = "cmo_company_funding";
        $table_company_industry         = "cmo_industry";
        $table_company_state            = "cmo_state";
    }
    elseif($func == 'clo')
    {
        $site = mysql_connect("10.132.233.67","clo2","dtBO#7310",TRUE) or die("Database ERROR".mysql_error());
        mysql_select_db("clo2",$site) or die ("ERROR: Database not found ");
        
        $table_personal_master          = "clo_personal_master";
        $table_personal_speaking        = "clo_personal_speaking";
        $table_movement_master          = "clo_movement_master";
        $table_company_master           = "clo_company_master";
        $table_personal_awards          = "clo_personal_awards";
        $table_personal_media_mention   = "clo_personal_media_mention";
        $table_personal_publication     = "clo_personal_publication";
        $table_management_change        = "clo_management_change";
        $table_company_job              = "clo_company_job_info";
        $table_company_funding          = "clo_company_funding";
        $table_company_industry         = "clo_industry";
        $table_company_state            = "clo_state";
    }
    
    
    $data_arr = array();
    $data = 0;
    
    
    $revenue_ids = "";
    $revenue_clause = "";
    if($revenue != '')        
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
        $revenue_clause .= " and company_revenue in (".$revenue_ids.")";
    } 

    
    if($zip != '')
    {
        $zip_clause = " and cm.zip_code = '".$zip."'";
    }

    if($city != '')
    {
        $city_clause = " and cm.city = '".$city."'";
    }

    if($searchnow != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $company_personal_clause = " and cm.company_name = '".$searchnow."'";
    }

    if($company != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $company_personal_clause = " and (cm.company_name = '".$company."' || cm.company_website = '".$company."' )";
    }

    if($industries_ids != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $industries_clause = " and cm.industry_id in (".$industries_ids.")";
    }

    if($state_ids != '')
    {
        //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
        $state_clause = " and cm.state in (".$state_ids.")";
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
    
    // SPEAKING
    if($type == 'speaking' || $type == 'all')
    {    
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and ps.event_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and ps.event_date <= '".$to_date."'";
        }    
        
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        } 
        
        $indResult = mysql_query("select mm.move_id,pm.personal_id,ps.speaking_link,first_name,last_name,
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
            $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by ps.speaking_id",$site);
        
        /*
        echo "<br>SPEAKING QUERY: select pm.personal_id,ps.speaking_link,first_name,last_name,
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
            $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause    
            group by ps.speaking_id";
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
            $data_arr[$data]['add_date'] = $indRow['add_date'];
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
            $data++;
        }
    }   
    
    // AWARDS
    if($type == 'awards' || $type == 'all')
    { 
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and awards_id = ".$id;
        
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and pa.awards_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and pa.awards_date <= '".$to_date."'";
        }
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        } 
        
        $indResult = mysql_query("select pm.personal_id,pa.awards_link,first_name,last_name,
            personal_image,pm.email as email,awards_id,pa.awards_title,pa.awards_given_by,
            pa.awards_date,pa.add_date as add_date,pm.phone,cm.company_name,mm.title,
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,
            cm.company_website,ci.title as industry_title,cs.short_name as state_short 
            from ".$table_personal_awards." as pa,
            ".$table_personal_master ." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs
            where (pa.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause
            group by awards_id",$site);
        
        
        
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
            $data_arr[$data]['add_date'] = $indRow['add_date'];
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
            $data++;
        }
    }    
        

    // MEDIA MENTIONS
    if($type == 'media' || $type == 'all')
    {
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and pmm.pub_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and pmm.pub_date <= '".$to_date."'";
        }
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        } 
        
        $indResult = mysql_query("select pm.personal_id,pmm.media_link,first_name,last_name,
            personal_image,pm.email as email,mm_id,pmm.publication,pmm.pub_date,
            pmm.add_date as add_date,cm.company_name,mm.title,pm.phone,
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,
            cm.company_website,pmm.quote,ci.title as industry_title,cs.short_name as state_short
            from ".$table_personal_media_mention." as pmm,
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs
            where (pmm.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause
            GROUP BY mm_id",$site);
        
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
            $data_arr[$data]['add_date'] = $indRow['add_date'];
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
            $data++;
        }
    }
    
    // PUBLICATION
    if($type == 'publication' || $type == 'all')
    {
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and ppp.publication_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and ppp.publication_date <= '".$to_date."'";
        }
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        } 
        
        $indResult = mysql_query("select pm.personal_id,ppp.link,first_name,last_name,personal_image,
            pm.email as email,publication_id,ppp.title,ppp.publication_date,ppp.add_date as add_date,
            mm.title as move_title,cm.company_name,pm.phone,
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,
            cm.company_website,ci.title as industry_title,cs.short_name as state_short 
            from ".$table_personal_publication." as ppp,
            ".$table_personal_master." as pm,
            ".$table_movement_master." as mm,
            ".$table_company_master." as cm,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs
            where (ppp.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
            cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) $from_date_clause $to_date_clause $zip_clause $revenue_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause    
            group by personal_id",$site);
        
        while($indRow = mysql_fetch_array($indResult))
        {
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
            $data_arr[$data]['add_date'] = $indRow['add_date'];
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
            $data++;
        }
    }  
    //echo "<br>ZIP: ".$zip;    
    // movements
    //if(($searchnow != '' || $city != '' || $company != '' || $industries_ids != '' || $state_ids != '' || $revenue != '' || $employee_size != '' || $to_date != '' || $from_date != ''|| $zip != '') && ($type == 'movements' || $type == 'all'))
    if($type == 'movements' || $type == 'all')        
    {
        //$limit_clause = " LIMIT 0,200";
        if($city != '' || $company != '' || $industries_ids != '' || $state_ids != '' || $revenue != '' || $employee_size != '' || $to_date != '' || $from_date != ''|| $zip != '')
            $limit_clause = "";
        $limit_clause = "";
        if($display_type == 'file')
            $limit_clause = " LIMIT 0,200";
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and mm.move_id = ".$id;
        
        
        $from_date_clause = "";
        $to_date_clause = "";
        $zip_clause = "";
        $city_clause = "";
        $industries_clause = "";
        $state_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and mm.announce_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and mm.announce_date <= '".$to_date."'";
        }
         
        //$order_by = " order by mm.announce_date desc";
        $order_by = "";
        
        $indResult = mysql_query("SELECT pm.personal_id,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,pm.email as email,pm.phone, cm.company_name,cm.company_website, 
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,mm.title,mm.movement_type,
            mm.more_link,mm.announce_date as add_date,mm.effective_date,mm.source_id,mm.headline,
            mm.full_body,mm.short_url,mm.what_happened,pm.about_person,mm.full_body,mm.short_url,
            cm.about_company,ci.title as industry_title,cs.short_name as state_short FROM 
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
            and mm.movement_type = 1 $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause    
            $order_by $limit_clause",$site);
        
        
        /*
         echo "Query:SELECT pm.personal_id,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,pm.email as email,pm.phone, cm.company_name,cm.company_website, 
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,mm.title,mm.movement_type,
            mm.more_link,mm.announce_date as add_date,mm.effective_date,mm.source_id,mm.headline,
            mm.full_body,mm.short_url,mm.what_happened,pm.about_person,mm.full_body,mm.short_url,
            cm.about_company,ci.title as industry_title,cs.short_name as state_short FROM 
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
            and mm.movement_type = 1 $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause    
            $order_by $limit_clause";
        */
        
        while($indRow = mysql_fetch_array($indResult))
        {
            
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
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            
            
            if($indRow['move_id'] < $move_last_id_db)
                $data_arr[$data]['show_state'] = 'read';
            else
                $data_arr[$data]['show_state'] = 'unread';
            
            if($indRow['move_id'] > $last_move_id)
                $max_move_id = $indRow['move_id'];
            
            $last_move_id = $indRow['move_id'];
            $data++;
        }    
    }    
    //$data_arr[$data]['max_move_id'] = $max_move_id;
    //$data++;
    
    
    
    
    // funding
    if($type == 'funding' || $type == 'all')
    {
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and cf.funding_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and cf.funding_date <= '".$to_date."'";
        }
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        }
        
        $indResult = mysql_query("SELECT pm.personal_id,cf.funding_source,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,cm.company_logo,
            pm.email as email,pm.phone,cm.company_name, mm.title,mm.movement_type,cf.funding_amount,
            cf.funding_source,cf.funding_add_date as add_date,cf.funding_date as funding_date,pm.add_to_funding,
            cm.company_id,ci.title as industry_title,cs.short_name as state_short,
            cm.company_revenue,cm.company_employee,cm.company_website,cm.address,cm.address2,cm.city,
            cm.zip_code
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
            and add_to_funding = 1 $from_date_clause $to_date_clause $zip_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause    
            $revenue_clause )",$site);
        
        /*
        echo "QUERY: SELECT pm.personal_id,cf.funding_source,mm.move_id,pm.first_name, pm.last_name,
            pm.personal_image,cm.company_logo,
            pm.email as email,pm.phone,cm.company_name, mm.title,mm.movement_type,cf.funding_amount,
            cf.funding_source,cf.funding_add_date as add_date,cf.funding_date as funding_date,pm.add_to_funding,
            cm.company_id,ci.title as industry_title,cs.short_name as state_short,
            cm.company_revenue,cm.company_employee,cm.company_website,cm.address,cm.address2,cm.city,
            cm.zip_code
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
            and add_to_funding = 1 $from_date_clause $to_date_clause $zip_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause    
            $revenue_clause )";
        die();
        */


        while($indRow = mysql_fetch_array($indResult))
        {
            $data_arr[$data]['id'] = $indRow['move_id'];
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
            $data_arr[$data]['funding_date'] = $indRow['funding_date'];
            $data_arr[$data]['funding_source'] = $indRow['funding_source'];
            $data_arr[$data]['title'] = $indRow['title'];
            $data_arr[$data]['add_date'] = $indRow['add_date'];
            $data_arr[$data]['type'] = 'funding';
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            $data++;
        }
    }
    
    // Jobs
    if($type == 'jobs' || $type == 'all')
    {
        $from_date_clause = "";
        $to_date_clause = "";
        if($from_date != '')
        {
            $from_date_clause = " and cj.post_date >= '".$from_date."'";
        }        
        if($to_date != '')
        {
            $to_date_clause = " and cj.post_date <= '".$to_date."'";
        }
        if($zip != '')
        {
            $zip_clause = " and cm.zip = '".$zip."'";
        }
        
        $indResult = mysql_query("SELECT cj.job_id,cm.company_id,cm.company_logo,cm.company_name, 
            cj.post_date,cj.add_date as add_date,cj.job_title,cj.location,cj.source,cm.company_website,
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,
            cm.phone,ci.title as industry_title,cs.short_name as state_short
            FROM 
            ".$table_company_master." as cm, 
            ".$table_company_job." as cj,
            ".$table_company_industry." as ci,
            ".$table_company_state." as cs
            WHERE (cm.company_id = cj.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)  $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause    
            ",$site);

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

            $data_arr[$data]['add_date'] = $indRow['add_date'];
            $data_arr[$data]['type'] = 'jobs';
            
            $data_arr[$data]['company_website'] = $indRow['company_website'];
            $data_arr[$data]['company_revenue'] = $indRow['company_revenue'];
            $data_arr[$data]['company_employee'] = $indRow['company_employee'];
            $data_arr[$data]['address'] = $indRow['address'];
            $data_arr[$data]['address2'] = $indRow['address2'];
            $data_arr[$data]['city'] = $indRow['city'];
            $data_arr[$data]['zip_code'] = $indRow['zip_code'];
            $data_arr[$data]['industry_title'] = $indRow['industry_title'];
            $data_arr[$data]['state_short'] = $indRow['state_short'];
            $data++;
        }
    }
    
    com_db_connect() or die('Unable to connect to database server!');
    com_db_query("INSERT into ".TABLE_COUNT."(record_type,user_id,record_id) values('movement','".$_SESSION['sess_user_id']."','".$last_move_id."')");	
     
    //echo "<pre>data_arr before: ";   print_r($data_arr); echo "</pre>"; die();
    usort($data_arr, "custom_sort");    
    //echo "<pre>data_arr after: ";   print_r($data_arr); echo "</pre>";
    return $data_arr;
}


function get_all_states()
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");

    $data = 0;
    
    $indResult = mysql_query("SELECT state_id,short_name FROM hre_state LIMIT 0,100",$site);

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
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");

    $data = 0;
    
    $indResult = mysql_query("SELECT industry_id,parent_id,title FROM hre_industry",$site);

    while($indRow = mysql_fetch_array($indResult))
    {
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
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $indResult = mysql_query("SELECT title FROM hre_industry where industry_id = ".$industry_id,$site);
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
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $indResult = mysql_query("SELECT short_name FROM hre_state where state_id = ".$state_id,$site);
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
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
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
    
    if(1 == 2)
    {    
        $indResult = mysql_query("SELECT name FROM hre_revenue_size where id = ".$lower_revenue,$site);
        //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
        $ind_title = '';
        $indRow = mysql_fetch_array($indResult);
        {
            if(strpos($indRow['name'], "-") > -1)
            {
                $revenue_lower_first = explode("-", $indRow['name']);   
                $lower_limit = $revenue_lower_first[0];
            }
            else
                $lower_limit = $indRow['name'];
        }

        $indResult = mysql_query("SELECT name FROM hre_revenue_size where id = ".$upper_revenue,$site);
        //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
        $ind_title = '';
        $indRow = mysql_fetch_array($indResult);
        {
            //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
            //$upper_limit = $indRow['name'];
            if(strpos($indRow['name'], "-") > -1)
            {
                $revenue_upper_first = explode("-", $indRow['name']);   
                $upper_limit = $revenue_upper_first[0];
            }
            else
                $upper_limit = $indRow['name'];


        }
    }    
    
    if($revenue_arr[0] == 8 || $revenue_arr[1] == 8)
        $revenue_limits = "> $1 bil";
    else
        $revenue_limits = $lower_limit." - ".$upper_limit;
    return $revenue_limits;
    
}



function get_employee_size_limits($employee_size)
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    
    $employee_size = trim($employee_size,",");
    //echo "<br>employee_size: ".$employee_size;
    $employee_size_arr = explode(",", $employee_size);
    //echo "<pre>employee_size_arr: ";   print_r($employee_size_arr);   echo "</pre>";
    
    $lower_revenue = $employee_size_arr[0];
    $upper_revenue = $employee_size_arr[1];
    
    if($lower_revenue == 0)
        $lower_limit = 0;
    else
    {    
        $indResult = mysql_query("SELECT from_range FROM hre_employee_size where id = ".$lower_revenue,$site);
        $indRow = mysql_fetch_array($indResult);
        {
            $lower_limit = $indRow['from_range'];
        }
    }
    
    $indResult = mysql_query("SELECT to_range FROM hre_employee_size where id = ".$upper_revenue,$site);
    $indRow = mysql_fetch_array($indResult);
    {
        $upper_limit = $indRow['to_range'];
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
    //echo "<br>SQL: ".$sql; die();
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

function show_movements($first_name,$last_name,$movement_id,$personal_id,$company_name,$title,$email,$phone,$movement_type,$more_link,$personal_image,$personal_pic_root)
{
    $sf = "";
    $personalURL = "";
    //$converted_date = date("M d, Y", strtotime($all_data[$i]['awards_date']));
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 

    $movement_text = "";
    if($movement_type == 1)
        $movement_text = " appointed ";
    elseif($movement_type == 2)
        $movement_text = " promoted";

    $share_text = "";
    $share_text = "Congrats ".$first_name." ". $last_name." on ".$movement_type." as ".$title." at ".$company_name;  //$all_data[$i]['company_name']
?>

    <li class="article">
        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-1#" id="field-1#">
                    <label class="form-label" for="field-1#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <span class="ico-article">
            <i class="ico-arrow-up-blue"></i>
        </span>

        <div class="article-image">
        <?PHP
        if($personal_image != '')
            $pic_src = $personal_pic_root."personal_photo/small/".$personal_image;
        else
            $pic_src = NO_PERSONAL_IMAGE;
        
        //if($personal_image != '')
        //{    
        ?>
            <a href="details.php?id=<?=$movement_id?>&type=movements"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
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

        <div class="article-content">
            <p><?=$first_name?> <?=$last_name?> was Appointed as <?=$title?> at <?=$company_name?>.</p>

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

                    <li>
                        <a target="_blank" href="<?=LINKEDIN_SHARE_ROOT?>url=<?=$more_link?><?=$share_text?>" class="linkedin">
                            <i class="ico-linkedin"></i>
                        </a>
                    </li>
                </ul>
            </div><!-- /.socials -->
        </div><!-- /.article-content -->

        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
            <!-- <a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" > -->	
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
    </li><!-- /.article -->

<?PHP
  
}


function show_awards($first_name,$last_name,$awards_id,$personal_id,$company_name,$title,$email,$phone,$personal_image,$awards_title,$awards_given_by,$awards_date,$awards_link,$personal_pic_root)
{
    $converted_date = date("M d, Y", strtotime($awards_date));

    $personalURL = "";
    $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

    $sf = "";
    $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 

    $share_text = "";
    $share_text = "Congrats ".$first_name." ". $last_name." on ".$awards_title." ".$awards_link;  //$all_data[$i]['company_name']
?>

    <li class="article">
        <ul class="list-checkboxes">
            <li>
                <div class="checkbox">
                    <input type="checkbox" name="field-3#" id="field-3#">
                    <label class="form-label" for="field-3#">1#</label>
                </div><!-- /.checkbox -->
            </li>
        </ul><!-- /.list-checkboxes -->

        <span class="ico-article">
            <i class="ico-cup"></i>
        </span>

        <div class="article-image">
        <?PHP
        
        if($personal_image != '')
            $pic_src = $personal_pic_root."personal_photo/small/".$personal_image;
        else
            $pic_src = NO_PERSONAL_IMAGE;
        
        //if($all_data[$i]['personal_image'] != '')
        //{    
        ?>
            <a href="details.php?id=<?=$awards_id?>&type=awards"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
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

        <div class="article-content">
            <p><?=$first_name?> <?=$last_name?> received <?=$awards_title?> from <?=$awards_given_by?> on <?=$converted_date?></p>

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

        <div class="article-actions">
            <a href="mailto:<?=$email?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
            <!-- <a href="#" class="btn btn-primary"> -->
                <span>Email now</span>
                <i class="ico-arrow-right"></i>
            </a>
        </div><!-- /.article-actions -->
    </li><!-- /.article --> 
<?PHP    
}


function get_companies()
{
    $site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    $table_company_master = "hre_company_master";
    $table_personal_master = "hre_personal_master";
    
    
    
    $indResult = mysql_query("select cm.company_name,cm.company_id
        FROM ".$table_company_master." as cm
        ",$site); 
        
        
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr[] = $indRow['company_name'];
    }
    
      
     
    $indResult = mysql_query("select first_name,last_name FROM ".$table_personal_master."",$site); 
    while($indRow = mysql_fetch_array($indResult))
    {
        $data_arr[] = $indRow['first_name']." ".$indRow['last_name'];
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


function add_user($name,$email)
{
    com_db_query("INSERT into ".TABLE_USER."(first_name,email,add_date) values('".$name."','".$email."','".date("Y-m-d:H:i:s")."')");	
}        

// Redirect to another page or site
 function com_redirect($url) {
    header('Location: ' . $url);
    exit;
  }






/**********  DB Connection *********************/
function com_db_connect($server = EXEC_SERVER_IP, $username = EXEC_DB_USER_NAME, $password = EXEC_DB_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;
      $$link = mysql_connect($server, $username, $password);

    if ($$link) mysql_select_db($database);

    return $$link;
  }

  
  
function com_db_query($query) 
{
 
	
	$qid = mysql_query($query);

	if (!$qid) {
		
			echo "<h2>Can't execute query</h2>";
			echo "<pre>" . htmlspecialchars($query) . "</pre>";
			echo "<p><b>MySQL Error</b>: ", mysql_error();
			echo "<p>This script cannot continue, terminating.";
			die();
	}

	return $qid;
}  
  
  
function com_db_fetch_row($qid) {
	return mysql_fetch_row($qid);
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

	return mysql_num_rows($qid);
}

function com_db_insert_id() {

	return mysql_insert_id();
}
  
function com_db_fetch_array($qid,$param = MYSQL_ASSOC) {

	return mysql_fetch_array($qid,$param);
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


?>

