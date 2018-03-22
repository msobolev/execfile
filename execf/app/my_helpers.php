<?php
function test()
{
    $i = 1;
    return $i;
}


function subDate($days)
{
    $date = date('Y-m-j');
    $duration='-'.$days.' day';
    $newdate = strtotime ( $duration , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-j' , $newdate );
    return $newdate;
}


function addDate($days)
{
    $date = date('Y-m-j');
    $duration='+'.$days.' day';
    $newdate = strtotime ( $duration , strtotime ( $date ) ) ;
    $newdate = date ( 'Y-m-j' , $newdate );
    return $newdate;
}



function get_all_industries()
{
    $indResult = DB::select( DB::raw("SELECT * FROM hre_industry WHERE status = 0") );
    //echo "<pre>indResult: ";   print_r($indResult);   echo "</pre>";
    $data_arr = array();
    
    foreach ($indResult as $ind) 
    {
        
        //echo "<pre>ind: ";   print_r($ind);   echo "</pre>";
        $ind_id = $ind->industry_id;
        //$data_arr[$indRow['industry_id']]['parent_id'] = $indRow['parent_id'];
        
        $data_arr[$ind_id]['parent_id'] = $ind->parent_id; 
        $data_arr[$ind_id]['title'] = $ind->title;
    }
    return $data_arr;
    
    
}


function get_all_states()
{
    $indResult = DB::select( DB::raw("SELECT state_id,short_name FROM hre_state LIMIT 0,100") );
    //echo "<pre>indResult: ";   print_r($indResult);   echo "</pre>";
    $data_arr = array();
    
    foreach ($indResult as $ind) 
    {
        $state_id = $ind->state_id;
        $data_arr[$state_id] = $ind->short_name; 
        
    }
    return $data_arr;
    
    
}


function get_industry_title($industry_id)
{
    
    $indResult = DB::select( DB::raw("SELECT title FROM hre_industry where industry_id = $industry_id") );
    //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
    $data_arr = array();
    foreach ($indResult as $ind) 
    {
        //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
        $ind_title = $ind->title;
    }
    return $ind_title;
}


function get_state_title($state_id)
{
    $indResult = DB::select( DB::raw("SELECT short_name FROM hre_state where state_id = $state_id") );
    //echo "<br>SELECT title FROM hre_industry where industry_id = ".$industries_arr[$ind];
    $ind_title = '';
    //$indRow = mysql_fetch_array($indResult);
    foreach ($indResult as $ind) 
    {
        //echo "<pre>indRow: ";   print_r($indRow);   echo "</pre>"; 
        $state_title = $ind->short_name;
    }
    return $state_title;
}




function get_revenue_limits($revenue)
{
    //$site = mysql_connect(HR_SERVER_IP,HR_DB_USER_NAME,HR_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
    //mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
    //echo "<br>revenue in func: ".$revenue;
    if(strpos($revenue,",") > -1)
    {        
        //echo "<br>in if";
        $revenue = trim($revenue,",");
        $revenue_arr = explode(",", $revenue);
        $db_id = 0;
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
        elseif($revenue_arr[0] == 8)
            $lower_limit = '> $1 bil';


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
        elseif($revenue_arr[1] == 8)
            $upper_limit = '> $1 bil';

        //if($revenue_arr[0] == 8 || $revenue_arr[1] == 8)
        if($revenue_arr[0] == 8 && $revenue_arr[1] == 8)
            $revenue_limits = "> $1 bil";
        else
            $revenue_limits = $lower_limit." - ".$upper_limit;
        
        //echo "<br>Lower limit : ".$lower_limit;
        //echo "<br>Upper limit : ".$upper_limit;
        
    
        
    }
    else
    {
        //echo "<br>in else";
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
        
        //$indResult = DB::select( DB::raw("SELECT state_id,short_name FROM hre_state LIMIT 0,100") );
        
        
        
        $indResult = DB::select( DB::raw("SELECT name FROM hre_employee_size where id = $lower_revenue") );
        //$indRow = mysql_fetch_array($indResult);
        foreach ($indResult as $ind) 
        {
            $lower_limit = $ind->name;
            
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
    
    //$indResult = mysql_query("SELECT name FROM hre_employee_size where id = ".$upper_revenue);
    $indResult = DB::select( DB::raw("SELECT name FROM hre_employee_size where id = $upper_revenue") );
    //$indRow = mysql_fetch_array($indResult);
    foreach ($indResult as $ind) 
    {
        $upper_limit = $ind->name;
        
        $hif_u_pos = strpos($upper_limit,'-');
        if($hif_u_pos > -1)
        {
            $upper_limit = substr($upper_limit,$hif_u_pos+1,strlen($upper_limit));
        } 
        
    }
    $employee_size = $lower_limit." - ".$upper_limit;
    return $employee_size;
    
    
}



function get_all_data($id='',$type='',$industries_ids = '',$from_date = '',$to_date='',$revenue = '',$employee_size = '',$city = '',$state_ids ='',$zip='',$searchnow = '',$company = '',$display_type = '')
{
    /*
    echo "<br><br>Type: ".$type;
    echo "<br>Ind: ".$industries_ids;
    echo "<br>from_date: ".$from_date;
    echo "<br>to_date: ".$to_date;
    echo "<br>revenue: ".$revenue;
    echo "<br>employee_size: ".$employee_size;
    echo "<br>city: ".$city;
    echo "<br>state_ids: ".$state_ids;
    echo "<br>zip: ".$zip;
    echo "<br>company: ".$company;
    echo "<br>searchnow: ".$searchnow;
    
     */
    //echo "<br>Searchnow: ".$searchnow;
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
    
    //global $speaking_last_id_db;
    
    $total_award_count = 0;
    $total_speaking_count = 0;
    $total_media_count = 0;
    $total_publication_count = 0;
    $total_move_count = 0;
    $total_funding_count = 0;
    $total_job_count = 0;
    
    $sort_by_add_dates = 0;
    $industries_clause_pub = '';
    
    $session_user_id     = Session::get('user_id');
    $session_user_site   = Session::get('user_site');
    
    //echo URL::previous(); die();
    //echo "<pre>";   print_r($_SERVER);   echo "</pre>"; die();
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
    
    
    //$move_rs = DB::table('exec_count')->select('record_id')->where('user_id', 2051)->first();
    //$move_last_id_db = $move_rs->record_id;
    
/*    
$awards_last_id_db = DB::table('exec_count')
            ->whereColumn([
                ['user_id',  '2051'],
                ['record_type', 'awards']
            ])->get();
 */   

    //$award_rs = DB::table('exec_count')->select('record_id')->where(['user_id', 2051],['record_type', 'awards'])->first();
    //$awards_last_id_db = $award_rs->record_id;
    
    $move_last_id_db = '';
    $speaking_last_id_db = '';
    $awards_last_id_db = '';
    $media_last_id_db = '';
    $publication_last_id_db = '';
    $funding_last_id_db = '';
    $jobs_last_id_db = '';
    
    $last_move_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='movement'") );
    if(count($last_move_result) > 0)
        $move_last_id_db = $last_move_result[0]->record_id;
    
    $last_speaking_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='speaking'") );
    if(count($last_speaking_result) > 0)
        $speaking_last_id_db = $last_speaking_result[0]->record_id;
    //echo "<br>speaking_last_id_db ONE:".$speaking_last_id_db;
    
    $last_award_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='awards'") );
    if(count($last_award_result) > 0)
    $awards_last_id_db = $last_award_result[0]->record_id;
    
    $last_media_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='media'") );
    if(count($last_media_result) > 0)
        $media_last_id_db = $last_media_result[0]->record_id;
    
    
    
    $last_pub_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='publication'") );
    if(count($last_pub_result) > 0)
    {    
        $publication_last_id_db = $last_pub_result[0]->record_id;
    }
    
    $last_funding_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='funding'") );
    if(count($last_funding_result) > 0)
    {    
        //echo "<pre>publication_last_id_db arr:";   print_r($last_pub_result);   echo "</pre>"; die();
        $funding_last_id_db = $last_funding_result[0]->record_id;
    }
    
    $last_job_result = DB::select( DB::raw("SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='jobs'") );
    if(count($last_job_result) > 0)
    {    
        //echo "<pre>publication_last_id_db arr:";   print_r($last_pub_result);   echo "</pre>"; die();
        $jobs_last_id_db = $last_job_result[0]->record_id;
    }
    //echo "<br>Q: SELECT record_id from exec_count where user_id = ".$session_user_id." and record_type='movement'";
    //echo "<br>move_last_id_db: ".$move_last_id_db;
    
    
    //$move_rs = DB::table('exec_count')->select('record_id')->where('user_id', 2051)->first();
    //$move_last_id_db = $move_rs->record_id;
    
    //$move_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'");
    //$speaking_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'");
    //$media_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'media'");
    //$awards_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'awards'");
    //$publication_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'publication'");
    //$funding_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'funding'");
    //$jobs_last_id_db = com_db_GetValue("select record_id from ".TABLE_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'jobs'");
    
    //echo "<br>FUNC: ".$func;
    
    // TODO - need to get it from session
    
    if($session_user_site != '')
        $func = $session_user_site;
    else    
        $func = 'hr';
    
    if($func == '' || $func == 'hr')
    {
        
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
        
        $table_search_data_awards            = "hre_search_data_awards";
        $table_search_data_media            = "hre_search_data_media";
        $table_search_data_fundings            = "hre_search_data_fundings";
        
    }
    elseif($func == 'cto' || $func == 'ciso')
    {
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
        
        $table_search_data_awards            = "cto_search_data_awards";
        $table_search_data_media            = "cto_search_data_media";
        $table_search_data_fundings            = "cto_search_data_fundings";
    }
    elseif($func == 'cfo')
    {
        
       
        
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
        
        $table_search_data_awards            = "cfo_search_data_awards";
        $table_search_data_media            = "cfo_search_data_media";
        $table_search_data_fundings            = "cfo_search_data_fundings";
    }
    elseif($func == 'cmo'  || $func == 'cso')
    {
        
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
        
        $table_search_data_awards            = "cmo_search_data_awards";
        $table_search_data_media            = "cmo_search_data_media";
        $table_search_data_fundings            = "cmo_search_data_fundings";
    }
    elseif($func == 'clo')
    {
        
        
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
        
        $table_search_data_awards            = "clo_search_data_awards";
        $table_search_data_media            = "clo_search_data_media";
        $table_search_data_fundings            = "clo_search_data_fundings";
    }
    
    
    
    
    
    $data_arr = array();
    $data = 0;
    
    $city_clause = "";
    $revenue_ids = "";
    $revenue_clause = "";
    
    $state_clause = "";
    $industries_clause = "";
    $company_personal_clause = "";
    $from_date_clause = "";
    $count_date_clause = "";
    $zip_clause = "";
    
    if($revenue != '' && $revenue > -1)        
    {
        if(strpos($revenue,",") > -1)
        {        
            $revenue_limits = explode(",", $revenue);

            $new_revenue_id = "";
            if($revenue_limits[0] < $revenue_limits[1])
            {
                $initial_revenue_id = 2;
                //for($r=$revenue_limits[0];$r<=$revenue_limits[1];$r++)
                for($r=$revenue_limits[0];$r<$revenue_limits[1];$r++)
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

    //echo "<br>Zip:".$zip;
    if($zip != '' && $zip != '0')
    {
        //echo "   within";
        $zip_clause = " and zip_code = '".addslashes($zip)."'";
    }
    
    if($city != '' && $city != '0')
    {
        $city_clause = " and city = '".addslashes($city)."'";
    }

    if($searchnow != '' && $searchnow != '0')
    {
        $searchnow = str_replace("'","''",$searchnow);
        $personal_name_arr = explode(" ",$searchnow);
        $searched_first_name = trim($personal_name_arr[0]);
        //echo "<br>COUNT: ".count($personal_name_arr);
        if(count($personal_name_arr) > 1)
        {   
            if($personal_name_arr[1] != '')
            {    
                
                $company_personal_clause = " and (company_name LIKE '%".$searchnow."%' OR (first_name = '".$searched_first_name."' and last_name = '".$personal_name_arr[1]."'))";
                
                if(sizeof($personal_name_arr) == 3)
                {    
                    $company_personal_clause = " and (company_name LIKE '%".$searchnow."%' OR (first_name = '".$searched_first_name."' and last_name = '".$personal_name_arr[1]." ".$personal_name_arr[2]."') OR (first_name = '".$personal_name_arr[0]." ".$personal_name_arr[1]."' and last_name = '".$personal_name_arr[2]."') OR (first_name = '".$personal_name_arr[0]."' and middle_name = '".$personal_name_arr[1]."' and last_name = '".$personal_name_arr[2]."'))";
                } 
                if(sizeof($personal_name_arr) == 4)
                {    
                    $company_personal_clause = " and (company_name LIKE '%".$searchnow."%' OR (first_name = '".$personal_name_arr[0]." ".$personal_name_arr[1]."' and middle_name = '".$personal_name_arr[2]."' and last_name = '".$personal_name_arr[3]."'))";
                } 
                
                //$company_personal_clause = " and (company_name = '".$searchnow."' OR (first_name = '".$searched_first_name."' and last_name = '".$personal_name_arr[1]."'))";
            }    
            else    
            {    
                $company_personal_clause = " and (company_name LIKE '%".$searchnow."%' OR first_name = '".$searched_first_name."')";
            }    
        }
        else
        {
            $company_personal_clause = " and (company_name LIKE '%".$searchnow."%' OR first_name = '".$searched_first_name."' OR last_name = '".$searched_first_name."')";
        }    
    }
    //echo "<br>company_personal_clause: ".$company_personal_clause;
    if($company != '' && $company != '0')
    {    
        
        $company = str_replace("'","''",$company);
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
            $company_personal_clause .= " or company_name like ('%$company%')";
            $company_personal_clause .= ")";
            $company_personal_clause = str_replace(',)',')',$company_personal_clause);
            //$company_personal_clause = str_replace('<br>','',$company_personal_clause);
        }    
        elseif($company != '' && $company != '0')
        {
            $company_personal_clause = " and (company_name LIKE '%".$company."%' || company_website = '".$company."' || company_urls = '".$company."')";
        }
    }    
    
    
    if($industries_ids != '')
    {
        $industries_clause = " and industry_id in (".$industries_ids.")";
    }
    //echo "<br>industries_clause FIRST: ".$industries_clause;
    if($state_ids != '' && $state_ids != '0')
    {
        $state_ids = trim($state_ids,',');
        $state_clause = " and state in (".$state_ids.")";
    }

    // Employee Size
    $employee_size_ids = "";
    $employee_size_clause = "";
    if($employee_size != '' && $employee_size > -1)        
    {
        $employee_size_limits = explode(",", $employee_size);

        $new_employee_size_id = "";
        if($employee_size_limits[0] < $employee_size_limits[1])
        {
            //$initial_revenue_id = 0;
            for($r=$employee_size_limits[0]+1;$r<=$employee_size_limits[1];$r++)
            {
                $new_employee_size_id = $r;
                $employee_size_ids .= $new_employee_size_id.",";
            }
        }
        
        
        if($employee_size_limits[0] < $employee_size_limits[1])
        {    
            if($employee_size_limits[1] - $employee_size_limits[0] == 1)
                $employee_size_clause .= " and company_employee in (".$employee_size_limits[1].")";
            else
            {    
                $employee_size_ids = trim($employee_size_ids,","); 
                $employee_size_clause .= " and company_employee in (".$employee_size_ids.")";
            }
            
        }
    }
    
    
    $ciso_clause = "";
    if($func == 'ciso')
    {
        $ciso_clause = " and ciso_user = 1";
    }
    elseif($func == 'cto')
    {
        $ciso_clause = " and ciso_user = 0";
    }
            
    
    $cso_clause = "";
    if($func == 'cso')
    {
        $cso_clause = " and cmo_user = 1";
    }
    elseif($func == 'cmo')
    {
        $ciso_clause = " and cmo_user = 0";
    }
    /*
    if($zip != '' && $zip != 0)
    {
        $zip_clause = " and zip_code = '".$zip."'";
    } 
    */
    //echo "<br>Type in fun: ".$type;
    $limit_clause = '';
    $show_time = 0;
    if($type == 'movements' || $type == 'all' || $type == '0' || strpos($type,"movements") > -1)        
    {
        //$limit_clause = " LIMIT 0,200";
        if($city != '' || $company != '' || $industries_ids != '' || $state_ids != '' || $revenue != '' || $employee_size != '' || $to_date != '' || $from_date != ''|| $zip != '')
            $limit_clause = "";
        
        //$limit_clause = " LiMIT 300";
        $limit_clause = " LiMIT 900";
        if($display_type == 'file')
            $limit_clause = " LIMIT 0,1000";
        //else
        //    $limit_clause = "";
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and move_id = ".$id;
        
        $from_date_clause = "";
        $to_date_clause = "";
        
        if($sort_by_add_dates == 1)
        {
            $from_date_clause = " and effective_date >= '".$count_lower_limit."'";
            $to_date_clause = " and effective_date <= '".$to_date."'";
        }
        else
        {    
            if($from_date != '' && $from_date != 0)
            {
                $from_date_clause = " and effective_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != 0)
            {
                $to_date_clause = " and effective_date <= '".$to_date."'";
            }
        } 
        
        /*
         * need to uncomment and make it working in laravel
        if($_GET['rem'] == 'Saved List')
        {
            $from_date_clause = " and announce_date >= '".$count_lower_limit."'";
            $to_date_clause = " and announce_date <= '".$to_date."'";
        }    
        */
        
        //$order_by = " order by mm.announce_date desc";
        //$order_by = " order by move_id desc";
        $order_by = " order by effective_date desc";
        
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
        
    
                
        //echo "<br>industries_clause TWO: ".$industries_clause;        
         //       echo "<br>within 2.5";
        $invalid_title = "and lower(title) not like 'chief executive officer' and lower(title) not like 'Founder and Chief Executive Officer'";        
               // echo "<br>within 2.6";
        $msc = microtime(true);     
        //echo "<br>within 2.7";
                //$limit_clause = " limit 0,2";
        //echo "<br>zip_clause before movement: ".$zip_clause;
         $indResult = DB::select( DB::raw("SELECT SQL_CALC_FOUND_ROWS personal_id,move_id,first_name, last_name,
            personal_image,email,phone".$company_fields.",title,movement_type,
            more_link,announce_date as announce_date,effective_date as add_date,effective_date,source_id,headline,
            '' as full_body,'' as short_url,what_happened,about_person,full_body,'' as short_url,
            company_name,company_logo
            FROM $table_search_data
            WHERE 
            movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause $ciso_clause $cso_clause    
            $invalid_title
            $order_by $limit_clause") );       //$limit_clause
        
         //echo "<br>within 3";
        /* 
         echo "<br>Q: SELECT SQL_CALC_FOUND_ROWS personal_id,move_id,first_name, last_name,
            personal_image,email,phone".$company_fields.",title,movement_type,
            more_link,announce_date as announce_date,effective_date as add_date,effective_date,source_id,headline,
            '' as full_body,'' as short_url,what_happened,about_person,full_body,'' as short_url,
            company_name,company_logo
            FROM $table_search_data
            WHERE 
            movement_type in (1,2) $where_personal_clause $from_date_clause $to_date_clause 
            $zip_clause $company_personal_clause $city_clause $industries_clause $state_clause
            $revenue_clause $employee_size_clause $ciso_clause $cso_clause    
            $invalid_title
            $order_by $limit_clause";
        */ 
         
         
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo $msc . ' s MOVEMENT'; // in seconds
        
        $move_unread_count = 0;
        
        
        $num_speaking_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
        $filtered_count = $num_speaking_result[0]->total_speaking_rows;
        //echo "<br>filtered_count: ".$filtered_count;
        foreach ($indResult as $row) 
        {
            $data_arr[$data]['id'] = $row->move_id;
            $data_arr[$data]['personal_id'] = $row->personal_id;
            $data_arr[$data]['move_id'] = $row->move_id;
            $data_arr[$data]['first_name'] = $row->first_name;
            $data_arr[$data]['last_name'] = $row->last_name;
            $data_arr[$data]['personal_image'] = $row->personal_image;
            $data_arr[$data]['email'] = $row->email;
            $data_arr[$data]['phone'] = $row->phone;

            $data_arr[$data]['company_name'] = $row->company_name;
            $data_arr[$data]['company_website'] = $row->company_website;
            $data_arr[$data]['company_revenue'] = $row->company_revenue;
            $data_arr[$data]['company_employee'] = $row->company_employee;
            $data_arr[$data]['address'] = $row->address;
            $data_arr[$data]['address2'] = $row->address2;
            $data_arr[$data]['city'] = $row->city;
            $data_arr[$data]['zip_code'] = $row->zip_code;
            $data_arr[$data]['state_id'] = $row->state;
            
            $data_arr[$data]['title'] = $row->title;
            $data_arr[$data]['add_date'] = $row->add_date;
            $data_arr[$data]['more_link'] = $row->more_link;
            $data_arr[$data]['movement_type'] = $row->movement_type;
            $data_arr[$data]['type'] = 'movement';
            
            $data_arr[$data]['announce_date'] = $row->announce_date;
            $data_arr[$data]['effective_date'] = $row->effective_date;
            $data_arr[$data]['source_id'] = $row->source_id;
            $data_arr[$data]['headline'] = $row->headline;
            $data_arr[$data]['full_body'] = $row->full_body;
            $data_arr[$data]['short_url'] = $row->short_url;
            $data_arr[$data]['what_happened'] = $row->what_happened;
            $data_arr[$data]['about_person'] = $row->about_person;
            $data_arr[$data]['about_company'] = $row->about_company;
            $data_arr[$data]['industry_id'] = $row->industry_id;
            $data_arr[$data]['industry_title'] = '';//$row->industry_title; TODO
            $data_arr[$data]['state_short'] = '';//$row->state_short; TODO
            $data_arr[$data]['total_count'] = $filtered_count;
            
            if($move_last_id_db == '' || $move_last_id_db == '0')
            {
                $data_arr[$data]['show_state'] = 'unread';
                $data_arr[$data]['unread_count'] = $move_unread_count+1;
            }    
            else
            {    
                if($row->move_id <= $move_last_id_db)
                {
                    $data_arr[$data]['show_state'] = 'read';
                }    
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $data_arr[$data]['unread_count'] = $move_unread_count+1;
                }    
            }
            
            $data++;
        }    
        //$time2 = microtime(true);
        //echo 'script execution time: ' . ($time2 - $time1);
       
        //View::share( 'last_move_index', $last_move_index );
    }
    //echo "<pre>data_arr after movement: ";   print_r($data_arr); echo "</pre>"; 
    
    //echo "<br>speaking_last_id_db TWO:".$speaking_last_id_db;
    //echo "<br>filtered_count a: ".$filtered_count;
    // SPEAKING
    //echo "<br>Before speaking";
    //echo "<br>speaking_last_id_db ONE:".$speaking_last_id_db;
    if($type == 'speaking' || ($type == 'all') || ($display_type == 'file' && (strpos($type,"speaking") > -1) || $type == 'all'))
    {    
        //echo "<br>Within speaking";
        $default_speaking_limit = ' limit 30';
        if($display_type = 'file')
            $default_speaking_limit = '';
        
        $to_date_clause = "";

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
            if($from_date != '' && $from_date != 0)
            {
                $from_date_clause = " and event_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != 0)
            {
                $to_date_clause = " and event_date <= '".$to_date."'";
            }    
        }
        //echo "<br>to_date: ".$to_date;
        //echo "<br>to_date_clause: ".$to_date_clause;
        
        
        
        $where_personal_clause = '';
        if($id != '')
            $where_personal_clause = " and speaking_id = ".$id;
        
        
        if($move_last_id_db == '' || $move_last_id_db == '0')
        {

            //echo "<br>within speaking empty if";
            $company_fields = ",cm.about_company, cm.company_name,cm.company_website, 
            cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code";
        
            $indCountResult = DB::select( DB::raw("select count(*) as total_speaking_count
                from ".$table_search_data." 
                where record_type = 'speaking'
                 $ciso_clause $cso_clause $count_date_clause $from_date_clause $to_date_clause") );
            
            //$indCountRow = mysql_fetch_array($indCountResult);
            foreach ($indCountResult as $rowC) 
                $speaking_count = $rowC->total_speaking_count;
            
            // Below check is added on 17th Aug
            // Case when user clicked on read and next time he login, he still get count from above Query which is wrong
            if($speaking_last_id_db > 0)
                $speaking_count = 0;
            
        }
       
        
        
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
        

        
        $msc = microtime(true); 
        
        // Query that will be used when single search table beeing used
        //echo "<br>zip_clause: ".$zip_clause;
        $indResult = DB::select( DB::raw("select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,company_name,company_website,address,address2,city,zip_code,
            sd.add_date,role,revenue_name,employee_size_name,state_name,industry_name,source_name,mgt_change_name,title,
            topic,company_revenue,company_employee $company_related_fields $file_select_vals
            from $table_search_data as sd  
            $file_joins
             where record_type = 'speaking'
            $where_personal_clause $file_where $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            group by speaking_id order by event_date desc  $default_speaking_limit") );
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s SPEAKING'; // in seconds
        
        /*
        echo "<br>SPEAKING Q: select SQL_CALC_FOUND_ROWS personal_id,speaking_link,first_name,last_name,
            personal_image,email,phone,speaking_id,event,event_date,company_name,company_website,address,address2,city,zip_code,
            sd.add_date,role,revenue_name,employee_size_name,state_name,industry_name,source_name,mgt_change_name,title,
            topic,company_revenue,company_employee $company_related_fields $file_select_vals
            from $table_search_data as sd  
            $file_joins
             where record_type = 'speaking'
            $where_personal_clause $file_where $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause
            $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            group by speaking_id order by event_date desc  $default_speaking_limit";
        */    
            //$num_speaking_query = "SELECT FOUND_ROWS() as total_rows";
            //$num_speaking_result = com_db_query($num_speaking_query);
            
            //$num_speaking_query = "SELECT FOUND_ROWS() as total_rows";
            $num_speaking_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
            //$num_speaking_row = mysql_fetch_array($num_speaking_result);
            $filtered_count = $num_speaking_result[0]->total_speaking_rows+$filtered_count;
        
            //echo "<br>filtered_count: ".$filtered_count;    
            //die("<br>FA");
       
        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $row) 
        {
            //$data_arr[$data]['move_id'] = $row->move_id;
            $data_arr[$data]['id'] = $row->speaking_id;
            $data_arr[$data]['personal_id'] = $row->personal_id;
            $data_arr[$data]['first_name'] = $row->first_name;
            $data_arr[$data]['last_name'] = $row->last_name;
            $data_arr[$data]['personal_image'] = $row->personal_image;
            $data_arr[$data]['email'] = $row->email;
            $data_arr[$data]['phone'] = $row->phone;
            $data_arr[$data]['event'] = $row->event;
            $data_arr[$data]['event_date'] = $row->event_date;
            $data_arr[$data]['speaking_link'] = $row->speaking_link;
            $data_arr[$data]['add_date'] = $row->event_date;
            $data_arr[$data]['company_name'] = $row->company_name;
            $data_arr[$data]['title'] = $row->title;
            $data_arr[$data]['type'] = 'speaking';
            
            $data_arr[$data]['company_website'] = $row->company_website;
            $data_arr[$data]['company_revenue'] = $row->company_revenue;
            $data_arr[$data]['company_employee'] = $row->company_employee;
            $data_arr[$data]['address'] = $row->address;
            $data_arr[$data]['address2'] = $row->address2;
            $data_arr[$data]['city'] = $row->city;
            $data_arr[$data]['zip_code'] = $row->zip_code;
            $data_arr[$data]['email'] = $row->email;
            $data_arr[$data]['phone'] = $row->phone;
            
            $data_arr[$data]['role'] = $row->role;
            $data_arr[$data]['topic'] = $row->topic;
            //$data_arr[$data]['industry_title'] = $row->industry_title;
            //$data_arr[$data]['state_short'] = $row->state_short;
            //$data_arr[$data]['max_speaking_id_direct'] = $max_speaking_id_direct;
            $data_arr[$data]['revenue_name'] = $row->revenue_name;
            $data_arr[$data]['employee_size_name'] = $row->employee_size_name;
            $data_arr[$data]['state_name'] = $row->state_name;
            $data_arr[$data]['industry_name'] = $row->industry_name;
            $data_arr[$data]['source_name'] = $row->source_name;
            $data_arr[$data]['mgt_change_name'] = $row->mgt_change_name;
            
            $last_speaking_id = "";
            //echo "<br>speaking_last_id_db: ".$speaking_last_id_db;
            //echo "<br>move_last_id_db: ".$move_last_id_db;
            if($speaking_last_id_db == '' || $speaking_last_id_db == '0')
            {
                //echo "<br>In if";
                $data_arr[$data]['show_state'] = 'unread';
                //$speaking_count++;
                //echo "<br>Speaking ID unread: ".$row->speaking_id."  ".$data_arr[$data]['show_state'];
            }    
            else
            {   
                //echo "<br>In else";
                //echo "<br>In else row speaking id: ".$row->speaking_id;
                //echo "<br>speaking_last_id_db: ".$speaking_last_id_db;
                if($row->speaking_id <= $speaking_last_id_db)
                {
                    //echo "<br>In else if";
                    //echo "<br>marking read";
                    $data_arr[$data]['show_state'] = 'read';
                    //echo "<br>Speaking ID read in else if: ".$row->speaking_id."  ".$data_arr[$data]['show_state'];
                }    
                else
                {    
                    //echo "<br>In else else";
                    //echo "<br>marking unread";
                    $data_arr[$data]['show_state'] = 'unread';
                    $speaking_count++;
                    //echo "<br>Speaking ID unread in else else: ".$row->speaking_id."  ".$data_arr[$data]['show_state'];
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
    //die();
    //echo "<br>filtered_count b: ".$filtered_count;
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
        
            if($from_date != '' && $from_date != '0')
            {
                //$from_date_clause = " and pa.awards_date >= '".$from_date."'";
                $from_date_clause = " and awards_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != '0')
            {
                //$to_date_clause = " and pa.awards_date <= '".$to_date."'";
                $to_date_clause = " and awards_date <= '".$to_date."'";
            }
        }    
        
        $awards_count_date_clause = '';
        
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        
        //if($industries_clause != '' || $state_clause != '')
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != '' || $display_type = 'file') //  || $display_type = 'file'
        {
            //$company_related_fields = ",ci.title as industry_title,cs.short_name as state_short,cm.company_name,mm.title,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            //$company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            //$company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            
            $company_related_fields = ",title as industry_title,state_name as state_short,company_name,title,company_revenue,company_employee,address,address2,city,zip_code,company_website,revenue_name,employee_size_name";
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
            $indAwardsCountResult = DB::select( DB::raw("select COUNT(DISTINCT awards_id) as  total_award_count
                from ".$table_personal_awards." as pa,
                ".$table_personal_master ." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (pa.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id)
                 $ciso_clause $cso_clause $awards_count_date_clause") );
            //$indAwardsCountRow = mysql_fetch_array($indAwardsCountResult);
            //$total_award_count = $indAwardsCountRow['total_award_count'];
            $award_count = $indAwardsCountResult[0]->total_award_count;
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
        
        
        $indResult = DB::select( DB::raw("select SQL_CALC_FOUND_ROWS personal_id,awards_link,first_name,last_name,
            personal_image,email as email,awards_id,awards_title,awards_given_by,
            awards_date,add_date as add_date,phone $company_related_fields
            from $table_search_data_awards
            where (record_type = 'awards')
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause
            group by awards_id $default_awards_limit order by awards_date desc") ); 
        
        
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s AWARDS'; // in seconds
        
        
        /*
        echo "<br>AWARD QUERY: select SQL_CALC_FOUND_ROWS personal_id,awards_link,first_name,last_name,
            personal_image,email as email,awards_id,awards_title,awards_given_by,
            awards_date,add_date as add_date,phone $company_related_fields
            from $table_search_data_awards
            where (record_type = 'awards')
            $where_personal_clause $from_date_clause $to_date_clause $zip_clause
            $revenue_clause $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause
            group by awards_id $default_awards_limit order by awards_date desc";
        */
        
        
        $num_awards_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
            //$num_awards_row = mysql_fetch_array($num_awards_result);
        $filtered_count = $num_awards_result[0]->total_speaking_rows+$filtered_count;
        
            
        //echo "<br>num_awards_row: ".$num_awards_row['total_speaking_rows'];
        //echo "<br>filtered_count c: ".$filtered_count;
            
        
        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $row) 
        {
            $data_arr[$data]['id'] = $row->awards_id;
            $data_arr[$data]['personal_id'] = $row->personal_id;
            $data_arr[$data]['first_name'] = $row->first_name;
            $data_arr[$data]['last_name'] = $row->last_name;
            $data_arr[$data]['personal_image'] = $row->personal_image;
            $data_arr[$data]['email'] = $row->email;
            $data_arr[$data]['phone'] = $row->phone;
            //$data_arr[$indRow['awards_id']]['personal_image'] = $row->personal_image;
            $data_arr[$data]['awards_title'] = $row->awards_title;
            $data_arr[$data]['awards_given_by'] = $row->awards_given_by;
            $data_arr[$data]['awards_date'] = $row->awards_date;
            $data_arr[$data]['add_date'] = $row->awards_date;
            $data_arr[$data]['awards_link'] = $row->awards_link;
            $data_arr[$data]['company_name'] = $row->company_name;
            $data_arr[$data]['title'] = $row->title;
            $data_arr[$data]['type'] = 'awards';
            
            $data_arr[$data]['company_website'] = $row->company_website;
            $data_arr[$data]['company_revenue'] = $row->company_revenue;
            $data_arr[$data]['company_employee'] = $row->company_employee;
            $data_arr[$data]['address'] = $row->address;
            $data_arr[$data]['address2'] = $row->address2;
            $data_arr[$data]['city'] = $row->city;
            $data_arr[$data]['zip_code'] = $row->zip_code;
            $data_arr[$data]['email'] = $row->email;
            $data_arr[$data]['phone'] = $row->phone;
            $data_arr[$data]['industry_title'] = $row->industry_title;
            $data_arr[$data]['state_short'] = $row->state_short;
            
            $data_arr[$data]['revenue_name'] = $row->revenue_name;
            $data_arr[$data]['employee_size_name'] = $row->employee_size_name;
            
            if($awards_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                //$award_count++;
            }    
            else
            {    
                if($row->awards_id <= $awards_last_id_db)
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
        
    //echo "<br>filtered_count c: ".$filtered_count;
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
            if($from_date != '' && $from_date != '0')
            {
                //$from_date_clause = " and pmm.pub_date >= '".$from_date."'";
                $from_date_clause = " and pub_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != '0')
            {
                //$to_date_clause = " and pmm.pub_date <= '".$to_date."'";
                $to_date_clause = " and pub_date <= '".$to_date."'";
            }
        }    
        
        
        $where_personal_clause = '';
        if($id != '')
        {    
            //$where_personal_clause = " and pmm.mm_id = ".$id;
            $where_personal_clause = " and mm_id = ".$id;
        }    
        
        $media_count_date_clause = '';
        $award_count = '';
        
        $company_related_fields = "";
        $company_related_table = "";
        $company_related_joins = "";
        
        
        //if($industries_clause != '' || $state_clause != '')
        if($industries_clause != '' || $state_clause != '' || $zip_clause != '' || $revenue_clause != '' || $city_clause != '' || $company_personal_clause != '' || $industries_clause != '' || $state_clause != '' || $employee_size_clause != '' || $display_type = 'file')  //  || $display_type = 'file'
        {
            //$company_related_fields = ",ci.title as industry_title,state_name as state_short,mm_id,cm.company_name,mm.title,cm.company_revenue,cm.company_employee,cm.address,cm.address2,cm.city,cm.zip_code,cm.company_website";
            //$company_related_table = " ,".$table_company_industry." as ci,".$table_company_state." as cs,".$table_movement_master." as mm,".$table_company_master." as cm";
            //$company_related_joins = " and cm.company_industry = ci.industry_id and cm.state=cs.state_id and mm.personal_id = pm.personal_id and cm.company_id = mm.company_id";
            
            
            $company_related_fields = ",industry_name as industry_title,state_name as state_short,mm_id,company_name,title,company_revenue,company_employee,address,address2,city,zip_code,company_website,revenue_name,employee_size_name";
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
            $indMediaCountResult = DB::select( DB::raw("select COUNT(DISTINCT mm_id) as total_media_count
                from ".$table_personal_media_mention." as pmm,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (pmm.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                  $ciso_clause $cso_clause $media_count_date_clause") );
            
            if(count($indMediaCountResult) > 0)
                $award_count = $indMediaCountResult[0]->total_media_count;
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
       
        
        $indResult = DB::select( DB::raw("select SQL_CALC_FOUND_ROWS personal_id,phone,media_link,first_name,last_name,
            personal_image,email as email,quote,publication,pub_date,mm_id,
            add_date as add_date $company_related_fields
            from $table_search_data_media
            where record_type = 'media' $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause $where_personal_clause $ciso_clause $cso_clause
            GROUP BY mm_id order by pub_date desc $default_media_limit") );
/*
        echo "<br>Q: select SQL_CALC_FOUND_ROWS personal_id,phone,media_link,first_name,last_name,
            personal_image,email as email,quote,publication,pub_date,mm_id,
            add_date as add_date $company_related_fields
            from $table_search_data_media
            where record_type = 'media' $from_date_clause $to_date_clause
            $revenue_clause $zip_clause $city_clause $company_personal_clause $industries_clause
            $state_clause $employee_size_clause $where_personal_clause $ciso_clause $cso_clause
            GROUP BY mm_id order by pub_date desc $default_media_limit";
   */     
        
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s MEDIA'; // in seconds
        
        
        $num_media_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
        //$num_media_row = mysql_fetch_array($num_media_result);
        $filtered_count = $num_media_result[0]->total_speaking_rows+$filtered_count;
        
        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $indRow)
        {
            $data_arr[$data]['id'] = $indRow->mm_id;
            $data_arr[$data]['personal_id'] = $indRow->personal_id;
            $data_arr[$data]['first_name'] = $indRow->first_name;
            $data_arr[$data]['last_name'] = $indRow->last_name;
            $data_arr[$data]['personal_image'] = $indRow->personal_image;
            $data_arr[$data]['email'] = $indRow->email;
            $data_arr[$data]['phone'] = $indRow->phone;
            $data_arr[$data]['publication'] = $indRow->publication;
            $data_arr[$data]['quote'] = $indRow->quote;
            $data_arr[$data]['pub_date'] = $indRow->pub_date;
            $data_arr[$data]['media_link'] = $indRow->media_link;
            $data_arr[$data]['add_date'] = $indRow->pub_date;
            $data_arr[$data]['company_name'] = $indRow->company_name;
            $data_arr[$data]['title'] = $indRow->title;
            $data_arr[$data]['type'] = 'media_mention';
            
            $data_arr[$data]['company_website'] = $indRow->company_website;
            $data_arr[$data]['company_revenue'] = $indRow->company_revenue;
            $data_arr[$data]['company_employee'] = $indRow->company_employee;
            $data_arr[$data]['address'] = $indRow->address;
            $data_arr[$data]['address2'] = $indRow->address2;
            $data_arr[$data]['city'] = $indRow->city;
            $data_arr[$data]['zip_code'] = $indRow->zip_code;
            $data_arr[$data]['email'] = $indRow->email;
            $data_arr[$data]['phone'] = $indRow->phone;
            $data_arr[$data]['industry_title'] = $indRow->industry_title;
            $data_arr[$data]['state_short'] = $indRow->state_short;
            
            $data_arr[$data]['revenue_name'] = $indRow->revenue_name;
            $data_arr[$data]['employee_size_name'] = $indRow->employee_size_name;
            
            if($media_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                //$media_count++;
            }    
            else
            {    
                if($indRow->mm_id <= $media_last_id_db)
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

    //echo "<br>filtered_count d: ".$filtered_count;
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
            if($from_date != '' && $from_date != '0')
            {
                $from_date_clause = " and ppp.publication_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != '0')
            {
                $to_date_clause = " and ppp.publication_date <= '".$to_date."'";
            }
        }    
        
        
        $where_personal_clause = "";
        if($id != '')
            $where_personal_clause = " and publication_id = ".$id;
        
        
        if($industries_ids != '')
        {
            //$company_personal_clause = " and cm.company_name = '".$searchnow."' || pm.first_name = '".$searchnow."' ||  pm.last_name = '".$searchnow."'";
            $industries_clause_pub = " and cm.industry_id in (".$industries_ids.")";
        }
        
        
        
        
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

            $indPublicationCountResult = DB::select( DB::raw("select  count(*) as total_publication_count
                from ".$table_personal_publication." as ppp,
                ".$table_personal_master." as pm,
                ".$table_movement_master." as mm,
                ".$table_company_master." as cm,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                where (ppp.personal_id = pm.personal_id and mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                 $ciso_clause $cso_clause $pub_count_date_clause") );
            
            if(count($indPublicationCountResult) > 0)
            {    
                //$indPublicationCountRow = mysql_fetch_array($indPublicationCountResult);
                //$total_publication_count = $indPublicationCountRow['total_publication_count'];
                $publication_count = $indPublicationCountResult[0]->total_publication_count;
            }    
        }
        
        //echo "<br>industries_clause: ".$industries_clause;
        $msc = microtime(true);
        $indResult = DB::select( DB::raw("select SQL_CALC_FOUND_ROWS pm.personal_id,ppp.link,first_name,last_name,personal_image,
            pm.email as email,publication_id,ppp.title,ppp.publication_date,ppp.add_date as add_date,
            pm.phone $company_related_fields
            from ".$table_personal_publication." as ppp,
            ".$table_personal_master." as pm
            ".$company_related_table."
            where (ppp.personal_id = pm.personal_id $company_related_joins) $from_date_clause $to_date_clause $zip_clause $revenue_clause
            $city_clause $company_personal_clause $industries_clause_pub $state_clause $employee_size_clause  $where_personal_clause $ciso_clause $cso_clause 
            group by personal_id order by publication_date desc $default_pub_limit") );
        
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
            $city_clause $company_personal_clause $industries_clause_pub $state_clause $employee_size_clause  $where_personal_clause $ciso_clause $cso_clause 
            group by personal_id order by publication_date desc $default_pub_limit";
        */
        //echo "<br>filtered_count dd: ".$filtered_count;
        $num_speaking_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
        //$num_speaking_row = mysql_fetch_array($num_speaking_result);
        $filtered_count = $num_speaking_result[0]->total_speaking_rows+$filtered_count;
        
        
        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $indRow)         
        {
            $data_arr[$data]['id'] = $indRow->publication_id;
            $data_arr[$data]['personal_id'] = $indRow->personal_id;
            $data_arr[$data]['first_name'] = $indRow->first_name;
            $data_arr[$data]['last_name'] = $indRow->last_name;
            $data_arr[$data]['personal_image'] = $indRow->personal_image;
            $data_arr[$data]['email'] = $indRow->email;
            $data_arr[$data]['phone'] = $indRow->phone;
            $data_arr[$data]['title'] = $indRow->title;
            $data_arr[$data]['publication_date'] = $indRow->publication_date;
            $data_arr[$data]['link'] = $indRow->link;
            $data_arr[$data]['add_date'] = $indRow->publication_date;
            $data_arr[$data]['company_name'] = $indRow->company_name;
            $data_arr[$data]['move_title'] = $indRow->move_title;
            $data_arr[$data]['type'] = 'publication';
            
            $data_arr[$data]['company_website'] = $indRow->company_website;
            $data_arr[$data]['company_revenue'] = $indRow->company_revenue;
            $data_arr[$data]['company_employee'] = $indRow->company_employee;
            $data_arr[$data]['address'] = $indRow->address;
            $data_arr[$data]['address2'] = $indRow->address2;
            $data_arr[$data]['city'] = $indRow->city;
            $data_arr[$data]['zip_code'] = $indRow->zip_code;
            $data_arr[$data]['industry_title'] = $indRow->industry_title;
            $data_arr[$data]['state_short'] = $indRow->state_short;
            
            if($publication_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
                $publication_count++;
                //echo "<br>In if";
                //$total_publication_count++;
                
            }    
            else
            {    
                if($indRow->publication_id <= $publication_last_id_db)
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
        
    //echo "<br>filtered_count e: ".$filtered_count;
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
            //$to_date_clause = " and cf.funding_add_date <= '".$to_date."'";
            $to_date_clause = " and funding_add_date <= '".$to_date."'";
        }
        else
        { 
            if($from_date != '' && $from_date != '0')
            {
                //$from_date_clause = " and cf.funding_date >= '".$from_date."'";
                $from_date_clause = " and funding_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != '0')
            {
                //$to_date_clause = " and cf.funding_date <= '".$to_date."'";
                $to_date_clause = " and funding_date <= '".$to_date."'";
            }
        }    
        
        $where_personal_clause = '';
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

            // Count with multiple DB tables
            /*
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
            */
            
            // Count with single DB table
            $indFundingCountResult = DB::select( DB::raw("SELECT  count(*) as total_funding_count
                FROM 
                $table_search_data_fundings
                WHERE ( record_type = 'fundings'
                
                 $ciso_clause $cso_clause) 
                ") );
            
            
            
            
            //$indFundingCountRow = mysql_fetch_array($indFundingCountResult);
            //$total_funding_count = $indFundingCountRow['total_funding_count'];
            
            if(count($indFundingCountResult) > 0)
                $funding_count = $indFundingCountResult[0]->total_funding_count;
            
            /*
            echo "<br><br>Funding Count: SELECT  count(*) as total_funding_count
                FROM 
                $table_search_data_fundings
                WHERE ( record_type = 'fundings'
                 $ciso_clause $cso_clause) $funding_count_date_clause";
                
            */
            
        }
        
        $msc = microtime(true);  
        
        
        /*
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
        */
        
        
        $indResult = DB::select( DB::raw("SELECT SQL_CALC_FOUND_ROWS personal_id,funding_source,move_id,
            first_name, last_name,
            personal_image,company_logo,
            email as email,phone,company_name, title,movement_type,funding_id,funding_amount,
            funding_source,funding_add_date as add_date,funding_date as funding_date,
            company_id $company_related_fields,
            company_revenue,company_employee,industry_id as industry_id,company_website,address,address2,
            city,state as state_id,zip_code,revenue_name,employee_size_name
            FROM 
            $table_search_data_fundings
            WHERE ( record_type = 'fundings'
            $from_date_clause $to_date_clause $zip_clause $where_personal_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            $revenue_clause) group by funding_id order by funding_add_date desc $default_speaking_limit") ); 
        
        
        
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s FUNDING'; // in seconds
        
        
        /*
        echo "<br><br>FUNDING QUERY: SELECT SQL_CALC_FOUND_ROWS personal_id,funding_source,move_id,
            first_name, last_name,
            personal_image,company_logo,
            email as email,phone,company_name, title,movement_type,funding_id,funding_amount,
            funding_source,funding_add_date as add_date,funding_date as funding_date,
            company_id $company_related_fields,
            company_revenue,company_employee,industry_id as industry_id,company_website,address,address2,
            city,state as state_id,zip_code,revenue_name,employee_size_name
            FROM 
            $table_search_data_fundings
            WHERE ( record_type = 'fundings'
            $from_date_clause $to_date_clause $zip_clause $where_personal_clause
            $city_clause $company_personal_clause $industries_clause $state_clause $employee_size_clause $ciso_clause $cso_clause    
            $revenue_clause) group by funding_id order by funding_add_date desc $default_speaking_limit";
        */ 
        //die();
        

        
        $num_speaking_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );
        //$num_speaking_row = mysql_fetch_array($num_speaking_result);
        if(count($num_speaking_result) > 0)
            $filtered_count = $num_speaking_result[0]->total_speaking_rows+$filtered_count;
        

        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $indRow) 
        {
            $data_arr[$data]['id'] = $indRow->move_id;
            $data_arr[$data]['funding_id'] = $indRow->funding_id;
            $data_arr[$data]['personal_id'] = $indRow->personal_id;
            $data_arr[$data]['first_name'] = $indRow->first_name;
            $data_arr[$data]['last_name'] = $indRow->last_name;
            $data_arr[$data]['personal_image'] = $indRow->personal_image;
            $data_arr[$data]['company_logo'] = $indRow->company_logo;
            $data_arr[$data]['email'] = $indRow->email;
            $data_arr[$data]['phone'] = $indRow->phone;

            $data_arr[$data]['company_id'] = $indRow->company_id;
            $data_arr[$data]['company_name'] = $indRow->company_name;
            $data_arr[$data]['company_website'] = $indRow->company_website;
            $data_arr[$data]['address'] = $indRow->address;
            $data_arr[$data]['address2'] = $indRow->address2;
            $data_arr[$data]['city'] = $indRow->city;
            $data_arr[$data]['company_revenue'] = $indRow->company_revenue;
            $data_arr[$data]['company_employee'] = $indRow->company_employee;
            $data_arr[$data]['zip_code'] = $indRow->zip_code;
            
            $data_arr[$data]['funding_amount'] = $indRow->funding_amount;
            $data_arr[$data]['funding_amount'] = $indRow->funding_amount;
            $data_arr[$data]['funding_date'] = $indRow->funding_date;
            $data_arr[$data]['funding_source'] = $indRow->funding_source;
            $data_arr[$data]['title'] = $indRow->title;
            //$data_arr[$data]['add_date'] = $indRow['add_date'];
            $data_arr[$data]['add_date'] = $indRow->funding_date;//funding_add_date
            $data_arr[$data]['type'] = 'funding';
           // $data_arr[$data]['industry_title'] = $indRow->industry_title;
            $data_arr[$data]['industry_id'] = $indRow->industry_id;
            $data_arr[$data]['state_id'] = $indRow->state_id;
           // $data_arr[$data]['state_short'] = $indRow->state_short;
            
            $data_arr[$data]['revenue_name'] = $indRow->revenue_name;
            $data_arr[$data]['employee_size_name'] = $indRow->employee_size_name;
            
            
            if($funding_last_id_db == '')
            {
                $data_arr[$data]['show_state'] = 'unread';
            }    
            else
            {    
                if($indRow->funding_id <= $funding_last_id_db)
                    $data_arr[$data]['show_state'] = 'read';
                else
                {    
                    $data_arr[$data]['show_state'] = 'unread';
                    $funding_count++;
                }    
            }
            //echo "<br>Funding ID: ".$indRow['funding_id']."     Add Date: ".$data_arr[$data]['add_date'];
            $data++;
        }
    }
    
    //echo "<br>filtered_count f: ".$filtered_count;
    // Jobs
    if($type == 'jobs' || $type == 'all' || strpos($type,"jobs") > -1)
    {
        $default_speaking_limit = ' limit 30';
        if($display_type = 'file')
            $default_speaking_limit = '';
        $from_date_clause = "";
        $to_date_clause = "";
        $where_personal_clause = "";
        
        if($sort_by_add_dates == 1)
        {
            $from_date_clause = " and cj.add_date >= '".$from_date."'";
            $to_date_clause = " and cj.add_date <= '".$to_date."'";
        }
        else
        { 
            if($from_date != '' && $from_date != '0')
            {
                $from_date_clause = " and cj.post_date >= '".$from_date."'";
            }        
            if($to_date != '' && $to_date != '0')
            {
                $to_date_clause = " and cj.post_date <= '".$to_date."'";
            }
        }
        
        /*
        if($zip != '' && $zip != '0')
        {
            $zip_clause = " and cm.zip_code = '".$zip."'";
        }
         * 
         */
        if($id != '')
            $where_personal_clause = " and job_id = ".$id;
        
        if($searchnow != '' && $searchnow != '0')
            $company_personal_clause = " and (company_name = '".$searchnow."')";
        if($company != '' && $company != '0') 
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
            
            
            $indJobCountResult = DB::select( DB::raw("SELECT count(*) as total_job_count
                FROM 
                ".$table_company_master." as cm, 
                ".$table_company_job." as cj,
                ".$table_company_industry." as ci,
                ".$table_company_state." as cs
                WHERE (cm.company_id = cj.company_id and cm.company_industry = ci.industry_id and cm.state=cs.state_id) 
                 ") );
            //$indJobCountRow = mysql_fetch_array($indJobCountResult);
            //$total_job_count = $indJobCountRow['total_job_count'];
            if(count($indJobCountResult) > 0)
                $job_count = $indJobCountResult[0]->total_job_count;
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
        $indResult = DB::select( DB::raw("SELECT SQL_CALC_FOUND_ROWS cj.job_id,cm.company_id,cm.company_logo,cm.company_name, 
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
             $default_speaking_limit") ); 
        /*
        echo "<br>Q: SELECT SQL_CALC_FOUND_ROWS cj.job_id,cm.company_id,cm.company_logo,cm.company_name, 
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
             $default_speaking_limit";
        */
        
        $num_speaking_result = DB::select( DB::raw("SELECT FOUND_ROWS() as total_speaking_rows") );  
        //    $num_speaking_row = mysql_fetch_array($num_speaking_result);
        if(count($num_speaking_result) > 0)
            $filtered_count = $num_speaking_result[0]->total_speaking_rows+$filtered_count;
        
        $msc = microtime(true)-$msc; 
        if($show_time == 1)
            echo "<br><br>".$msc . ' s JOB'; // in seconds    
            
        
        //while($indRow = mysql_fetch_array($indResult))
        foreach ($indResult as $indRow) 
        {
            $data_arr[$data]['id'] = $indRow->job_id;
            $data_arr[$data]['company_id'] = $indRow->company_id;
            $data_arr[$data]['company_logo'] = $indRow->company_logo;

            $data_arr[$data]['company_name'] = $indRow->company_name;
            $data_arr[$data]['phone'] = $indRow->phone;
            $data_arr[$data]['job_title'] = $indRow->job_title;
            $data_arr[$data]['location'] = $indRow->location;
            $data_arr[$data]['source'] = $indRow->source;
            $data_arr[$data]['post_date'] = $indRow->post_date;

            $data_arr[$data]['add_date'] = $indRow->post_date;
            $data_arr[$data]['type'] = 'jobs';
            
            $data_arr[$data]['company_website'] = $indRow->company_website;
            $data_arr[$data]['company_revenue'] = $indRow->company_revenue;
            $data_arr[$data]['company_employee'] = $indRow->company_employee;
            $data_arr[$data]['address'] = $indRow->address;
            $data_arr[$data]['address2'] = $indRow->address2;
            $data_arr[$data]['city'] = $indRow->city;
            $data_arr[$data]['zip_code'] = $indRow->zip_code;
            $data_arr[$data]['industry_id'] = $indRow->industry_id;
            //$data_arr[$data]['industry_title'] = $indRow->industry_title;
            //$data_arr[$data]['state_short'] = $indRow->state_short;
            $data_arr[$data]['state_id'] = $indRow->state_id;
            
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
                if($indRow->job_id <= $jobs_last_id_db)
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
   
    //echo "<br>filtered_count g: ".$filtered_count;
    $total_count_without_where = $total_speaking_count+$total_award_count+$total_media_count+$total_publication_count+$total_move_count+$total_funding_count+$total_job_count;
    //echo "<br>filtered_count fun bt: ".$filtered_count;
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



function custom_sort($a,$b) 
{
    //return trim($a['add_date'])>trim($b['add_date']);
    return trim($a['add_date'])<trim($b['add_date']);
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
                        $output.='<a class=btn-prev href="'. $main_page.'/'.($page_now-1).$extra .'"><i class=ico-arrow-left></i><span>Prev Page</span></a>';
			
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
					$output.='<a href="'.$main_page.'/'.$i.$extra.'">'.$i.'</a>';
				}
			}
		}
		//$output= substr($output,0, -1);
		
		//$output.='</p>';
		
		if($page_now<$total_pages)
		{
			//$output.='<a href="'.$main_page.'?p='.($page_now+1).$extra. '">Next &gt;&gt;</a>';
                        $output.='<a class=btn-next href="'.$main_page.'/'.($page_now+1).$extra. '"><span>Next page</span><i class=ico-arrow-right></i></a>';
			
		} else {
			//$output.='Next &gt;&gt;';
                        $output.='';
		}
		return $output;
	} 
}




function update_user_counts($unread_movements_count,$unread_speaking_count,$unread_media_count,$unread_award_count,$unread_publication_count,$unread_funding_count,$unread_job_count)
{
    $TABLE_SESSION_COUNT = 'exec_session_count';
    if(Session::get('user_id') != '')
    {    
        $this_user = Session::get('user_id');

        //$appointment_arr = array('id'=>$this_user,'record_type'=>'movement');
        
        //DB::table('exec_session_count')->where($appointment_arr)->update(['votes' => 1]);
        
        
        DB::table('exec_session_count')->where('user_id', $this_user)->delete();

        $sqlInsert = array(array('session_counts'=>$unread_movements_count, 'record_type'=>'movement','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);

        $sqlInsert = array(array('session_counts'=>$unread_speaking_count, 'record_type'=>'speaking','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);
        
        $sqlInsert = array(array('session_counts'=>$unread_media_count, 'record_type'=>'media','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);

        $sqlInsert = array(array('session_counts'=>$unread_award_count, 'record_type'=>'awards','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);

        $sqlInsert = array(array('session_counts'=>$unread_publication_count, 'record_type'=>'publication','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);
        
        $sqlInsert = array(array('session_counts'=>$unread_funding_count, 'record_type'=>'funding','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);
        
        $sqlInsert = array(array('session_counts'=>$unread_job_count, 'record_type'=>'jobs','user_id'=>$this_user),);
        DB::table('exec_session_count')->insert($sqlInsert);
        
        
    }    
}

function get_count($type)
{
    $ses_user_id = Session::get('user_id');
    //echo "<br>ses_user_id: ".$ses_user_id;
    //echo "<br>SELECT * FROM exec_session_count WHERE user_id = '".$ses_user_id."' and record_type = '".$type."'";
    $results_move = DB::select( DB::raw("SELECT * FROM exec_session_count WHERE user_id = '".$ses_user_id."' and record_type = '".$type."'") );
    
    //echo "<pre>results_move: ";   print_r($results_move);   echo "</pre>";
    $unread_movements_count = '';
    if(count($results_move) > 0)
    {
        $unread_movements_count = $results_move[0]->session_counts;
    }
    //echo "<br>unread_movements_count: ".$unread_movements_count;
    return $unread_movements_count;
}



function get_cities()
{
    $table_company_master = "hre_company_master";
    $indResult = DB::select( DB::raw("select distinct city FROM ".$table_company_master."") );
    foreach ($indResult as $indRow) 
    {
        $data_arr[] = $indRow->city;
    }
    //echo "<pre>data arr: ";   print_r($data_arr);   echo "</pre>";
    $companies = $data_arr;
    $term = trim(strip_tags($_GET['term']));
    // Rudimentary search
    $matches = array();
    //foreach($cities as $city)
    foreach($companies as $id=>$city)
    {
        //echo "<br>city:".$city;
        if(stripos($city, $term) !== false)
        {
            // Add the necessary "value" and "label" fields and append to result set
            $city['value'] = $city;
            //$city['label'] = "{$city['city']}, {$city['state']} {$city['zip']}";
            $city['label'] = "{$city} ";
            $matches[] = $city;
        }
    }
    // Truncate, encode and return the results
    $matches = array_slice($matches, 0, 10);


    echo json_encode($matches);
}


function get_org_chart_data($company)
{
    $table_personal_master          = Session::get('db_personal');//"hre_personal_master";
    $table_movement_master          = Session::get('db_movement'); //"hre_movement_master";
    $table_company_master           = Session::get('db_company'); //"hre_company_master";
    
    $chart_arr = array(); 
    
    
    
    //if($_SESSION['site'] == '' || $_SESSION['site'] == 'hr')
    //{
        $table_name            = Session::get('db_search_data'); //"hre_search_data";
    //}
    /*    
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
    */
    
    $ciso_clause = "";
    /*if($_SESSION['site'] == 'ciso')
    {
        $ciso_clause = " and ciso_user = 1";
    }
     * 
     */
    
    
    
    $cso_clause = "";
    /*
    if($_SESSION['site'] == 'cso')
    {
        $cso_clause = " and cmo_user = 1";
    } 
    else
    {
        $cso_clause = " and cmo_user = 0";
    } 
    */
    //$table_name = 'hre_search_data';
    
   
    
    //$get_personal_q = "select d.`personal_id`,d.`first_name`,d.`last_name`,d.`level`,d.`level_order`,d.`personal_image`,d.`company_name`,d.`title` from `hre_search_data` AS d where d.`company_website` like '$company' order by level_order asc"; 
    //$get_personal_q = "SELECT company_id,personal_id,first_name,last_name,level,level_order,personal_image,company_name,title FROM ".$table_name." WHERE (company_website =  '".$company."' || company_name = '".$company."'  || company_urls = '".$company."')  $ciso_clause $cso_clause ORDER BY level_order ASC LIMIT 0 , 30";

    $get_comp_result = DB::select( DB::raw("select max(level) as max_level from ".$table_name." where company_website = '".$company."' || company_name = '".$company."' || company_urls = '".$company."'") );
    if(count($get_comp_result) > 0)
        $max_level = $get_comp_result[0]->max_level;
    

    $output_level = "";
    $output_level_a = "";
    $output_level_b = "";
    $level_2 = 51; 
    $no_level = 2000;
    //echo "<br>get_personal: ".$get_personal;
    $get_comp_result = DB::select( DB::raw("SELECT company_id,personal_id,first_name,last_name,level,level_order,personal_image,company_name,title FROM ".$table_name." WHERE (company_website =  '".$company."' || company_name = '".$company."'  || company_urls = '".$company."')  $ciso_clause $cso_clause ORDER BY level_order ASC LIMIT 0 , 30") );
    
    //while($pRow = mysql_fetch_array($get_personal_res))
    foreach ($get_comp_result as $pRow) 
    {
        if($pRow->level == '' || $pRow->level == 0)
        {    
            $pRow->level = $max_level;
        }
        
        if($pRow->level > 0 || 1 == 1)
        {    
            //echo "<br>Level: ".$pRow['level'];
            
            //$get_current_comp = "select company_id from $table_name where personal_id = ".$pRow['personal_id']." order by move_id desc limit 0,1";
            $get_current_res = DB::select( DB::raw("select company_id from $table_name where personal_id = ".$pRow->personal_id." order by move_id desc limit 0,1") );
            //$get_current_res = mysql_query($get_current_comp);
            //$cRow = mysql_fetch_array($get_current_res);
            $company_id = $get_current_res[0]->company_id;
            
            
            if($company_id == $pRow->company_id)
            {
                $personal_id = $pRow->personal_id;
                $first_name = $pRow->first_name;
                $last_name = $pRow->last_name;
                $title = $pRow->title;
                $company_name = $pRow->company_name;
                $level = $pRow->level;
                $level_order = $pRow->level_order;
                $personal_image = $pRow->personal_image;
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
        
    }
    //echo "<pre>chart_arr:";   print_r($chart_arr);   echo "</pre>";
    //    die();
    return $chart_arr;
}


function get_saved_list($list_type = '',$list_id = '')
{
    $mod_list = "";
    $def_clause = "";
    $list_clause = "";
    $user_id     = Session::get('user_id');
    
    if($list_type == 'default')
        $def_clause = "and default_list = 1";
    
    if($list_id != '')
        $list_clause = "and l_id = $list_id";
    
    $results_sl = DB::select( DB::raw("SELECT * FROM user_saved_lists WHERE user_id = '".$user_id."' $def_clause $list_clause") );
    if(count($results_sl) > 0)
    {
        $default_saved_list = $results_sl[0]->filters;
        $default_arr = explode(":",$default_saved_list);
        // only zip movements:hr:::77010:::::::::   4th location is zip
        // only state movements:hr::::::::2::::   9th location is state
        // only industry movements:hr:::::::17:::::   8th location is industry
        // only revenue movements:hr:::::::::0,1:2:: 10th location is revenue
        // only employee size movements:hr:::::::::::7,8:  12th location is employee size

        if($default_arr[0] == '') // type ie movement speaking etc
            $default_arr[0] = 'all';

        if($default_arr[2] == '') // from date
            $default_arr[2] = '0';

        if($default_arr[3] == '') // to date
            $default_arr[3] = '0';

        if($default_arr[10] == '') // revenue
            $default_arr[10] = -1;

        if($default_arr[12] == '') // employee_size
            $default_arr[12] = -1;

        if($default_arr[5] == '')
            $default_arr[5] = '0';

        if($default_arr[8] == '') // industry
            $default_arr[8] = '0';

        if($default_arr[9] == '') // state
            $default_arr[9] = '0';

        if($default_arr[4] == '') // zip code
            $default_arr[4] = '0';

        if($default_arr[6] == '')
            $default_arr[6] = '0';

        if($default_arr[7] == '') // company val
            $default_arr[7] = '0';

        if($default_arr[6] == '') // city
            $default_arr[6] = '0';
        else
            $default_arr = str_replace(" ","%20",$default_arr);
        
        //echo "<br>6th ind: ".$default_arr[6];
        //$mod_list = $default_arr[0]."/".$default_arr[8]."/".$default_arr[2]."/".$default_arr[3]."/".$default_arr[10]."/".$default_arr[12]."/".$default_arr[6]."/".$default_arr[9]."/".$default_arr[4]."/0/".$default_arr[7]."/0/0";    
        $mod_list = $default_arr[0]."/".$default_arr[8]."/0/0/".$default_arr[10]."/".$default_arr[12]."/".$default_arr[6]."/".$default_arr[9]."/".$default_arr[4]."/".$default_arr[5]."/".$default_arr[7]."/0/0";    

    }
    return $mod_list;
}


function create_job_url($title = '',$company_name = '',$movement_id = '',$record_type = '')
{
    //echo "<br>base_url: ".$base_url;
    //global $base_url;
    $base_url = "http://hr.execfile.com/";
    if(strlen($title) > 100)
        $title = substr($title,0,100);
    $created_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($title))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($company_name)).'_details_'.$record_type."_".$movement_id;
    $created_url = $base_url.$created_url; 
    return $created_url;
}

function create_url($first_name = '',$last_name = '',$title = '',$company_name = '',$movement_id = '',$record_type = '')
{
    $base_url = "http://hr.execfile.com/";
    
    if(strlen($title) > 100)
        $title = substr($title,0,100);
    
    $created_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($first_name))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($last_name))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($title))."_".preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($company_name)).'_details_'.$record_type."_".$movement_id;
    $created_url = $base_url.$created_url; 
    return $created_url;
} 


function com_db_output($string) {
	return stripslashes($string);
}  
?>



