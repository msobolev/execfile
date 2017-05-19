<?PHP
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
//ini_set('session.cookie_domain', 'execfile.com');
session_start();
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>"; 


function check_session()
{
if (!$_SESSION['sess_is_user'] || !$_SESSION['sess_user_id'])
    {
        header('Location: ' . 'index.php');
        exit;
    } 
    
}
check_session();
$total_count_without_where = 0;

$movement_count = 0;
$appointment_count = 0;
$speaking_count = 0;
$media_count = 0;
$publication_count = 0;
$award_count = 0;
$funding_count = 0;
$job_count = 0;


$speaking_last_id_db = '';
$funding_last_id_db = '';

$base_url = "http://hr.execfile.com/";

$login_page_flow = 0;
if(isset($_GET['login_page_flow']) && $_GET['login_page_flow'] == 1)
    $login_page_flow = 1;


include("header.php"); 
//echo "<br>login_page_flow: ".$login_page_flow;
//die("<br>FA");
//echo "<br>SITE: ".$_SESSION['site'];
//if((strpos($_SERVER['HTTP_REFERER'],'login.php') > -1 || $login_page_flow == 1) && $_GET['def_l'] != '1')
// Updated on 12 Apr 2017
if($_SESSION['site'] != 'hr' && ($type == 'all' || $type == '') && $revenue == '' && $employee_size == '' && $industries == '' && $states_para == '' && $city == '' && $zip == '' && $from_date_initial == '' && $to_date_initial == '' && $_GET['companyval'] == '' && $_GET['searchnow'] == '')
{
    //echo "<br>FAR Within home if";
    //$all_data_count = '89926'; //65543'; //$total_count_without_where;
    if($_SESSION['site'] == 'cmo' || $_SESSION['site'] == 'cfo' || $_SESSION['site'] == 'clo' || $_SESSION['site'] == 'cto' || $_SESSION['site'] == 'ciso' || $_SESSION['site'] == 'cso')
    {
        //echo "<br>Within if 2";
        $table_company_master = "hre_company_master";
        if($func == '' || $func == 'hr')
            {
                $table_personal_master          = "hre_personal_master";
                $table_movement_master          = "hre_movement_master";
            }
            elseif($func == 'cto' || $func == 'ciso')
            {
                $table_personal_master          = "cto_personal_master";
                $table_movement_master          = "cto_movement_master";
                if($func == 'ciso')	
                {
                        $ciso_cl = " and ciso_user = 1";
                }
            }
            elseif($func == 'cfo')
            {
                $table_personal_master          = "cfo_personal_master";
                $table_movement_master          = "cfo_movement_master";
            }
            elseif($func == 'cmo'  || $func == 'cso')
            {
                $table_personal_master          = "cmo_personal_master";
                $table_movement_master          = "cmo_movement_master";
                if($func == 'cso')	
                {
                    $cso_cl = " and cmo_user = 1";
                }

            }
            elseif($func == 'clo')
            {
                $table_personal_master          = "clo_personal_master";
                $table_movement_master          = "clo_movement_master";
            }
        
        
        
    //    $all_data_count = count($all_data);; 
        $c_query = "select count(*) as t_c from $table_company_master as cm,
        $table_movement_master as mm,
        $table_personal_master as pm
        where cm.company_id = mm.company_id and
        mm.personal_id = pm.personal_id $ciso_cl $cso_cl;";
        
        //echo "<br>FAR Q: ".$c_query;
        
        $c_res = mysql_query($c_query);
        $count_row = mysql_fetch_array($c_res);
        $all_data_count = $count_row['t_c'];
        //echo "<br>FAR All data count: ".$all_data_count;
    }
    /*
    else
    {
        //echo "<br>Within else";
        $c_query = "select count(distinct mm.personal_id) as t_c from hre_company_master as cm,
        hre_movement_master as mm,
        hre_personal_master as pm
        where cm.company_id = mm.company_id and
        mm.personal_id = pm.personal_id;";
        
        $c_res = mysql_query($c_query);
        $count_row = mysql_fetch_array($c_res);
        $all_data_count = $count_row['t_c'];
        
    } 
     */   
}

//echo "<br>home all_data_count : ".$all_data_count;
    

$add_date = date('Y-m-d');
$this_user_for_log = $_SESSION['sess_user_id'];
$search_history = "insert into ". TABLE_SEARCH_HISTORY . " (user_id,search_type,search_string,first_name,last_name,title,management,country,state,city,zip_code,company,company_website,industry,revenue_size,employee_size,speaking,awards,publication,media_mention,board,time_period,from_date,to_date,tot_search_result,add_date)
		values('$this_user_for_log','$search_type','$search_string','$first_name','$last_name','$title','$management','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$speaking','$awards','$publication','$media_mentions','$board','$time_period','$from_date','$to_date','$tot_search_result','$add_date')";
com_db_query($search_history);


?>

<style>
    .tree {
        
    margin-left:-85px;    
    margin-top:-65px;
        
    min-height:20px;
    padding:19px;
    margin-bottom:20px;
    /*background-color:#fbfbfb; */
    -webkit-border-radius:4px;
    -moz-border-radius:4px;
    /*
    border:1px solid #999;
    border-radius:4px;
    */
    -webkit-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow:inset 0 1px 1px rgba(0, 0, 0, 0.05)
}
.tree li {
    list-style-type:none;
    margin:0;
    padding:10px 5px 0 5px;
    position:relative
}
.tree li::before, .tree li::after {
    content:'';
    left:-20px;
    position:absolute;
    right:auto
}
.tree li::before {
    border-left:1px dashed #808080;
    bottom:50px;
    height:100%;
    top:0;
    width:1px
}
.tree li::after {
    border-top:1px dashed #808080;
    /*height:20px; */
    height:20px;
    top:25px;
    width:25px
}
.tree li span {
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    /*border:1px solid #999;
    border-radius:5px;*/
    display:inline-block;
    padding:3px 8px;
    text-decoration:none
}
.tree li.parent_li>span {
    cursor:pointer
}
.tree>ul>li::before, .tree>ul>li::after {
    border:0
}
.tree li:last-child::before {
    /*height:30px */
    height:26px    
}
.tree li.parent_li>span:hover, .tree li.parent_li>span:hover+ul li span {
    background:#eee;
    border:1px solid #94a0b4;
    color:#000
}


.tree ul
{padding-left:65px;}


:not(.tree) {
  
}


</style>


    <div class="main">

        <input type="hidden" name="type" id="type" value="<?=$_GET['type']?>">
        <input type="hidden" name="hidden_industires" id="hidden_industires" value="<?=$_GET['industries']?>">
        <input type="hidden" name="hidden_states" id="hidden_states" value="<?=$states_para?>">
        <input type="hidden" name="hidden_employee_size" id="hidden_employee_size" value="<?=$_GET['employee_size']?>">
        <input type="hidden" name="hidden_revenue" id="hidden_revenue" value="<?=$_GET['revenue']?>">
        <input type="hidden" name="hidden_zip" id="hidden_zip" value="<?=$_GET['zip']?>">
        <input type="hidden" name="hidden_city" id="hidden_city" value="<?=$_GET['city']?>">
        <input type="hidden" name="mweb" id="mweb" value="<?=$_GET['mweb']?>">
        
        <input type="hidden" name="hidden_complete_url" id="hidden_complete_url" value="<?=$_SERVER['REQUEST_URI']?>">
        <?PHP
        //echo "<br>only_company: ".$only_company;
        //if($only_company == 1)
        //echo "<br>ORG: ".$_GET['org'];        
        if($_GET['org'] == 1)
        {
        $hr_root_link = "https://www.hrexecsonthemove.com/";    
        
        $org_company = "";
        if($_GET['company'] != '')
            $org_company = $_GET['company'];
        elseif($_GET['searchnow'] != '')
            $org_company = $_GET['searchnow'];
        
        //$chart_arr = get_org_chart_data($_GET['company']); 
        $chart_arr = get_org_chart_data($org_company); 
        //echo "<pre>chart_arr: ";   print_r($chart_arr);   echo "</pre>";    
        
        //echo "<br>Site: ".$_SESSION['site'];
        
        
        if($_SESSION['site'] == '' || $_SESSION['site'] == 'hr')
        {
            $pic_root            = "https://www.hrexecsonthemove.com/";
        }
        elseif($_SESSION['site'] == 'cto' || $_SESSION['site'] == 'ciso')
        {
            $pic_root            = "https://www.ctosonthemove.com/";
            $hr_root_link = "https://www.ctosonthemove.com/";
        }
        elseif($_SESSION['site'] == 'cfo')
        {
            $pic_root            = "https://www.cfosonthemove.com/";
            $hr_root_link = "https://www.cfosonthemove.com/";
        }
        elseif($_SESSION['site'] == 'cmo'  || $_SESSION['site'] == 'cso')
        {
            $pic_root            = "https://www.cmosonthemove.com/";
            $hr_root_link = "https://www.cmosonthemove.com/";
        }
        elseif($_SESSION['site'] == 'clo')
        {
            $pic_root            = "https://www.closonthemove.com/";
            $hr_root_link = "https://www.closonthemove.com/";
        }
        
        
        
        $level_arr = array();
        foreach($chart_arr as $p_id => $c_data)
        {
            $level_arr[] = $c_data['level'];
        }    
        
        //echo "<pre>level_arr: ";   print_r($level_arr);   echo "</pre>";    
            
        ?>    
        <div class="content" style="padding-left:323px;margin-bottom:100px;">
            <div style="padding-bottom:500px;" class="tree well">
                
                
                <?PHP
                $level_1_first = 0;
                $level_2_first = 0;
                $level_3_first = 0;
                $loop_iteration = 0;
                if(count($chart_arr) > 0)
                {    
                    if($loop_iteration == 0)
                    {
                        
                        echo "<ul>";
                        echo "<li>";
                    }
                    
                    foreach($chart_arr as $personal_id => $chart_data)
                    {    
                        //$nextLevel = next($chart_data['level']);
                        
                        if($chart_data['personal_image'] == '')
                            $per_img = "no-personal-image.png";
                        else
                        {    
                            //$per_img = "https://www.hrexecsonthemove.com/personal_photo/thumb/".$chart_data['personal_image'];
                            $per_img = $pic_root."personal_photo/thumb/".$chart_data['personal_image'];
                        }
                        
                        $hr_link = trim($chart_data['first_name']).'_'.trim($chart_data['last_name']).'_Exec_'.$chart_data['personal_id'];
                        
                        $nextData = next($chart_data);
                        //echo "<pre>nextData: "; print_r($nextData);   echo "</pre>";
                        
                        
                        //if(strlen($chart_data['title']) > 20)
                        //$chart_data['title'] = substr($chart_data['title'],0,20);
                    
                        //if(strlen($chart_data['company_name']) > 20)
                        //$chart_data['company_name'] = substr($chart_data['company_name'],0,20)."..";
                        
                        //if($chart_data['level'] == 1)
                        
                        $p_title = $chart_data['title'];
                        if(strlen($p_title) > 80)
                            $p_title = substr($p_title, 0, 80);
                        
                        
                        if($loop_iteration == 0)
                        {
                        ?>

                            <span>
                                <i style="border:none;" class="icon-folder-open">
                                    <img src="<?=$per_img?>" height="80" width="80" alt="" class="article-avatar">
                                </i>
                            </span> 
                            <a href="<?=$hr_root_link?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?> at <?=$chart_data['company_name']?>
                        
                        <?PHP
                        $loop_iteration++;
                        }
                        else
                        {
                            if($previousLevel > $chart_data['level']) // 1
                            {
                               echo "</li>"; 
                               echo "</ul>";
                               echo "</li>";
                               echo "<li>";
                               ?>
                                <span>
                                    <i style="border:none;" class="icon-folder-open">
                                        <img src="<?=$per_img?>" height="80" width="80" alt="" class="article-avatar">
                                    </i>
                                </span> 
                                <a href="<?=$hr_root_link?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
                            
                                <?PHP
                            }   
                            
                            elseif($previousLevel < $chart_data['level']) // 2
                            {
                                echo "<ul>";
                                echo "<li>";
                                ?>
                                <span>
                                    <i style="border:none;" class="icon-folder-open">
                                        <img src="<?=$per_img?>" height="80" width="80" alt="" class="article-avatar">
                                    </i>
                                </span> 
                                <a href="<?=$hr_root_link?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
                                <?PHP
                                
                            }
                            elseif($previousLevel == $chart_data['level']) // 2
                            {
                                echo "</li>";
                                echo "<li>";
                                ?>
                                <span>
                                    <i style="border:none;" class="icon-folder-open">
                                        <img src="<?=$per_img?>" height="80" width="80" alt="" class="article-avatar">
                                    </i>
                                </span> 
                                
                                <a href="<?=$hr_root_link?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
                                <?PHP
                                echo "</li>";
                            }
                            $previousLevel = $chart_data['level'];
                            
                        }    
                    }
                    echo "</ul></li></ul>";
                }
                ?>
                
            </div>

        </div>
        <?PHP    
        }   
        else
        {    
        ?>
        <div class="content" style="padding-left:323px;">
            <section class="section-primary">
                <header class="section-head" style="min-width:900px;left:333px;">
                    <form class="form-tags">
                        <p>
                            <label class="form-label hidden">Tags</label>
                            
                            <?PHP
                            if($func == '')
                                $filters = "HR";
                            elseif($func == 'it')
                                $filters = "IT";
                            else
                                $filters = strtoupper($func);
                            
                            if($_GET['list'] != '' || $_GET['mweb'] != '')
                            {
                                $filters .= "|Saved List";
                            }
                            else
                            {    
                                if($type != '' && $type != 'none' && $type != 'all')
                                {
                                    if($type == 'movements')    
                                        $filters .= "|Appointments";
                                    elseif($type == 'media')
                                        $filters .= "|Media Mentions";
                                    elseif($type == 'awards')
                                        $filters .= "|Industry Awards";
                                    else
                                        $filters .= "|".ucfirst($type);
                                }

                                if($from_date != '')
                                    $filters .= "|T:".$from_date;
                                if($to_date != '')
                                    $filters .= " - ".$to_date;

                                if($revenue_limits != '')
                                    $filters .= "|".$revenue_limits;

                                //echo "<br>complete_industries: ".$complete_industries;

                                if($complete_industries != '')
                                    $filters .= $complete_industries;

                                if($employee_size_limits != '')
                                    $filters .= "|S:".$employee_size_limits;

                                if($complete_states != '')
                                    $filters .= $complete_states;

                                if($zip != '')
                                    $filters .= "|ZIP:".$zip;

                                if($city != '')
                                    $filters .= "|C:".$city;

                                if($searchnow != '')
                                    $filters .= "|COMP:".$searchnow;

                                if($companyval != '')
                                {
                                    $bread = $companyval;
                                    $bread = str_replace("<br />",",",$bread);
                                    $filters .= "|COMP:".$bread;
                                }    
                            }
                            ?>
                            <input id="tags_1" type="text" class="tags" value="<?=$filters?>" /> 
                            <!-- <input id="tags_1" type="text" class="tags" value="HR,Appointments,May 2014 – May 2015,Business Services,Rev $10 - $50 million" /> -->
                        </p>
                    </form>

                    <p class="records"><?=$all_data_count?> records</p>
                </header><!-- /.section-head -->

                <div class="section-body">
                    <ul class="articles">
                    <?PHP
                    //foreach($speaking_arr as $id=>$data_arr)
                    if($p == 1)
                    {    
                        $starting_point = 0;
                    }    
                    else
                    {
                        $starting_point = ($items_per_page*($p-1));
                    }    
                    $ending_point = $starting_point+$items_per_page;
                    //foreach($all_data as $id=>$data_arr)

                    //echo "<br>starting_point:".$starting_point;
                    //echo "<br>starting_point:".$ending_point;
                    $total_data = count($all_data);

                    
                    $read_movements = array();
                    $unread_movements = array();
                    $first_move_arr = array();
                    $first_move_count = 0;
                    $unread_movements_count = 0;
                    $last_move_id = 0;
                    
                    //$unread_movements_count = 7;
                    $unread_speaking_count = 0;
                    $first_speaking_count = 0;
                    $first_speaking_arr = array();
                    
                    // Media mention variables
                    $unread_media_count = 0;
                    $unread_media = array();
                    $first_media_arr = array();
                    $first_media_count = 0;

                    
                    $unread_publication_count = 0;
                    $unread_publication = array();
                    $first_publication_arr = array();
                    $first_publication_count = 0;


                    $unread_award_count = 0;
                    $unread_award = array();
                    $first_award_arr = array();
                    $first_award_count = 0;

                    $unread_funding_count = 0;
                    $unread_funding = array();
                    $first_funding_arr = array();
                    $first_funding_count = 0;

                    $unread_job_count = 0;
                    $unread_job = array();
                    $first_job_arr = array();
                    $first_job_count = 0;
                    
                    
                    $max_speaking_id = '';
                    $last_speaking_id = 0;
                    
                    $last_job_id = '';
                    $max_job_id = 0;

                    $max_funding_id = '';
                    $last_funding_id = 0;
                    
                    
                    $last_award_id = '';
                    $max_award_id = 0;
                    
                    $last_media_id = '';
                    $max_media_id = 0;
                    
                    $last_publication_id = '';
                    $max_publication_id = 0;

                    //echo "<pre>";   print_r($all_data);   echo "</pre>";
                    //echo "<br>OP before loop speaking_count: ".$speaking_count;
                    
                    for($k=0;$k<$total_data;$k++)
                    {
                        if($all_data[$k]['type'] == 'movement')
                        {
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                //echo "<br><br>ann da:".$all_data[$k]['add_date'];
                                $now = time(); // or your date as well
                                $your_date = strtotime($all_data[$k]['add_date']);
                                $datediff = $now - $your_date;
                                $days_between = floor($datediff/(60*60*24));  
                                //echo "<br>Days: ".$days_between;
                                if($days_between < 90)
                                {    
                                    $unread_movements_count++;
                                    $unread_movements[] =  $all_data[$k]['move_id'];
                                }    
                            }
                            
                            $first_move_arr[$first_move_count] =  $all_data[$k]['id'];
                            $first_move_count++;
                            
                            
                            if($all_data[$k]['id'] > $last_move_id && $all_data[$k]['id'] > $max_move_id)
                                $max_move_id = $all_data[$k]['id'];
                            $last_move_id = $all_data[$k]['id'];
                            
                        } 
                        $speaking_inc = 0;
                        //echo "<br>:::::Type : ".$all_data[$k]['type'];
                        if($all_data[$k]['type'] == 'speaking')
                        {
                            $speaking_inc = 1;
                            $max_speaking_id_direct = $all_data[$k]['max_speaking_id_direct'];
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_speaking_count++;
                                $unread_speaking[] =  $all_data[$k]['id'];
                            }
                            
                            $first_speaking_arr[$first_speaking_count] =  $all_data[$k]['id'];
                            $first_speaking_count++;
                            
                            //echo "<br><br>".$all_data[$k]['id'].' > ' .$last_speaking_id;
                            if($all_data[$k]['id'] > $last_speaking_id && $all_data[$k]['id'] > $max_speaking_id)
                                $max_speaking_id = $all_data[$k]['id'];
                            $last_speaking_id = $all_data[$k]['id'];
                            //echo ":::::max speaking id : ".$max_speaking_id;
                        }
                        
                        
                        if($all_data[$k]['type'] == 'media_mention')
                        {
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_media_count++;
                                $unread_media[] =  $all_data[$k]['id'];
                            }
                            
                            $first_media_arr[$first_media_count] =  $all_data[$k]['id'];
                            $first_media_count++;
                            
                            
                            if($all_data[$k]['id'] > $last_media_id && $all_data[$k]['id'] > $max_media_id)
                                $max_media_id = $all_data[$k]['id'];
                            $last_media_id = $all_data[$k]['id'];
                            
                        }
                        
                        if($all_data[$k]['type'] == 'publication')
                        {
                            //echo "<br>within pub: ".$all_data[$k]['type'];
                            //echo "<br>show_state: ".$all_data[$k]['show_state'];
                            //echo "<br>id: ".$all_data[$k]['id'];
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_publication_count++;
                                $unread_publication[] =  $all_data[$k]['id'];
                            }
                            
                            $first_publication_arr[$first_publication_count] =  $all_data[$k]['id'];
                            $first_publication_count++;
                            
                            if($all_data[$k]['id'] > $last_publication_id && $all_data[$k]['id'] > $max_publication_id)
                                $max_publication_id = $all_data[$k]['id'];
                            $last_publication_id = $all_data[$k]['id'];
                            
                            //echo "<br>last_publication_id: ".$last_publication_id;
                            //echo "<br>max_publication_id: ".$max_publication_id;
                        }
                        
                        if($all_data[$k]['type'] == 'awards')
                        {
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_award_count++;
                                $unread_award[] =  $all_data[$k]['id'];
                            }
                            
                            $first_award_arr[$first_award_count] =  $all_data[$k]['id'];
                            $first_award_count++;
                            
                            if($all_data[$k]['id'] > $last_award_id && $all_data[$k]['id'] > $max_award_id)
                                $max_award_id = $all_data[$k]['id'];
                            $last_award_id = $all_data[$k]['id'];
                            
                            
                        }
                        $funding_inc = 0;
                        if($all_data[$k]['type'] == 'funding')
                        {
                            $funding_inc = 1;
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_funding_count++;
                                $unread_funding[] =  $all_data[$k]['id'];
                            }
                            
                            $first_funding_arr[$first_funding_count] =  $all_data[$k]['funding_id'];
                            $first_funding_count++;
                            
                            if($all_data[$k]['funding_id'] > $last_funding_id && $all_data[$k]['funding_id'] > $max_funding_id)
                                $max_funding_id = $all_data[$k]['funding_id'];
                            $last_funding_id = $all_data[$k]['funding_id'];
                            
                        }
                        
                        if($all_data[$k]['type'] == 'jobs')
                        {
                            if($all_data[$k]['show_state'] == 'unread')
                            {
                                $unread_job_count++;
                                $unread_job[] =  $all_data[$k]['id'];
                            }
                            
                            $first_job_arr[$first_job_count] =  $all_data[$k]['id'];
                            $first_job_count++;
                            
                            if($all_data[$k]['id'] > $last_job_id && $all_data[$k]['id'] > $max_job_id)
                                $max_job_id = $all_data[$k]['id'];
                            $last_job_id = $all_data[$k]['id'];
                        }
                    }
                    
                    //echo "<br>speaking_inc: ".$speaking_inc;
                    if($speaking_inc == 0 && $speaking_last_id_db == '')
                    {
                        $max_speaking_id_q = mysql_query("SELECT max(speaking_id) as max_speaking_id from hre_personal_speaking");
                        $maxSpeakingRow = mysql_fetch_array($max_speaking_id_q);
                        $max_speaking_id_direct = $maxSpeakingRow['max_speaking_id'];
                        $max_speaking_id = $max_speaking_id_direct;
                    }
                    else
                        $max_speaking_id = $speaking_last_id_db;
                    //echo "<br>max speaking id : ".$max_speaking_id;
                    
                    
                    if($funding_inc == 0 && $funding_last_id_db == '')
                    {
                        $max_funding_id_q = mysql_query("SELECT max(funding_id) as max_funding_id from hre_company_funding");
                        $maxFundingRow = mysql_fetch_array($max_funding_id_q);
                        $max_funding_id_direct = $maxFundingRow['max_funding_id'];
                        $max_funding_id = $max_funding_id_direct;
                    }
                    else
                        $max_funding_id = $funding_last_id_db;
                    
                    
                    //echo "<br>max speaking id TWO: ".$max_speaking_id;
                    $last_move_id = $max_move_id;  //$first_speaking_arr[0];        
                    $last_speaking_id = $max_speaking_id;  //$first_speaking_arr[0];
                    $last_media_id = $max_media_id;  //$first_media_arr[0];
                    $last_publication_id = $max_publication_id; //$first_publication_arr[0];
                    $last_award_id = $max_award_id; //$first_award_arr[0];
                    $last_funding_id = $max_funding_id; //$first_funding_arr[0];
                    $last_job_id =  $max_job_id;  //$first_job_arr[0];
                    

                    
                    for($i=$starting_point;$i<$ending_point;$i++)
                    { 
                        if($all_data[$i]['type'] == 'speaking')
                        {
                            show_speaking($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['event'],$all_data[$i]['speaking_link'],$all_data[$i]['event_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'media')
                        {
                            show_media($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['event'],$all_data[$i]['speaking_link'],$all_data[$i]['event_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'awards')
                        {
                            show_awards($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['awards_title'],$all_data[$i]['awards_given_by'],$all_data[$i]['awards_date'],$all_data[$i]['awards_link'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }

                        if($all_data[$i]['type'] == 'movement')
                        {
                            show_movements($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['move_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['movement_type'],$all_data[$i]['more_link'],$all_data[$i]['personal_image'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'funding')
                        {
                            show_funding($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['funding_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['funding_source'],$all_data[$i]['funding_amount'],$all_data[$i]['funding_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'jobs')
                        {
                            show_job($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['job_title'],$all_data[$i]['post_date'],$all_data[$i]['source'],$personal_pic_root,"https://www.ctosonthemove.com/",$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }

                        if($all_data[$i]['type'] == 'publication')
                        {
                            show_publication($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['move_title'],$all_data[$i]['link'],$all_data[$i]['publication_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'media_mention')
                        {
                            show_media($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['publication'],$all_data[$i]['media_link'],$all_data[$i]['media_link'],$all_data[$i]['pub_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                    }
                        
                        //echo "<br>unread_media_count: ".$unread_media_count;
                        ?>

                    </ul><!-- /.articles -->
                </div><!-- /.section-body -->

                <div class="section-foot">
                    
                    <?PHP
                    //echo "<br>pg_int_parameters: ".$pg_int_parameters;
                    echo number_pages($main_page, $p, $total_data, 0, $items_per_page,'&login_page_flow='.$login_page_flow .'&items_per_page='.$items_per_page.$pg_int_parameters);
                    ?>
                </div><!-- /.section-foot -->
                
               
                
            </section><!-- /.section-primary -->
        </div><!-- /.content -->
        <?PHP
        }
        ?>
    </div><!-- /.main -->
<?PHP
//echo "<br>last_move_id: ".$last_move_id;
?>
    
<input type="hidden" name="last_move_id" id="last_move_id" value="<?=$last_move_id?>">        
<input type="hidden" name="last_speaking_id" id="last_speaking_id" value="<?=$last_speaking_id?>">    
<input type="hidden" name="last_media_id" id="last_media_id" value="<?=$last_media_id?>">    
<input type="hidden" name="last_award_id" id="last_award_id" value="<?=$last_award_id?>">    
<input type="hidden" name="last_publication_id" id="last_publication_id" value="<?=$last_publication_id?>">    
<input type="hidden" name="last_funding_id" id="last_funding_id" value="<?=$last_funding_id?>">    
<input type="hidden" name="last_job_id" id="last_job_id" value="<?=$last_job_id?>">    
    
<?PHP include("footer.php"); 
//echo "<br>last_media_id: ".$last_media_id;
//echo "<pre>read_movements: ";   print_r($read_movements);   echo "</pre>";
$total_read = count($read_movements);

//echo "<br>FAR speaking_count bottom: ".$movement_count;
if(strpos($_SERVER['HTTP_REFERER'],'login.php') > -1)
{    
    //echo "<br>FAR in IF bottom";
    $unread_movements_count = $movement_count;
    $unread_speaking_count = $speaking_count;
    $unread_media_count = $media_count;
    $unread_award_count = $award_count;
    $unread_publication_count = $publication_count;
    $unread_funding_count = $funding_count;
    $unread_job_count = $job_count;
    //echo "<br>Unread_media_count: ".$unread_media_count;
    
    if($unread_movements_count == 0)
        $_SESSION['mark_move_read_clicked'] = 1;

    if($unread_speaking_count == 0)
    $_SESSION['mark_speaking_read_clicked'] = 1;

        
    if($unread_media_count == 0)
        $_SESSION['mark_media_read_clicked'] = 1;


    if($unread_award_count == 0)
        $_SESSION['mark_award_read_clicked'] = 1;

    if($unread_publication_count == 0)
        $_SESSION['mark_pub_read_clicked'] = 1;
    
    if($unread_funding_count == 0)
        $_SESSION['mark_funding_read_clicked'] = 1;
    
    if($unread_job_count == 0)
        $_SESSION['mark_jobs_read_clicked'] = 1;
    
    //echo "<br>unread_speaking_count: ".$unread_speaking_count;
    update_user_counts($unread_movements_count,$unread_speaking_count,$unread_media_count,$unread_award_count,$unread_publication_count,$unread_funding_count,$unread_job_count);
}
else
{
    //echo "<br>FAR in ELSE bottom: select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'";
    //echo "<br>In else";
    $unread_movements_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'");
    //echo "<br>FAR In else movement count : ".$unread_movements_count;
    
    //echo "<br>Speaking unread Q: select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'";
    $unread_speaking_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'");
    //echo "<br>From session: ".$unread_speaking_count;
    $unread_media_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'media'");
    
    $unread_award_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'awards'");
    
    $unread_publication_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'publication'");
    
    $unread_funding_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'funding'");
    
    $unread_job_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'jobs'");
    
    if($unread_movements_count == '')
        $unread_movements_count = 0;
    
    if($unread_speaking_count == '')
        $unread_speaking_count = 0;
    
    if($unread_media_count == '')
        $unread_media_count = 0;
    
    if($unread_award_count == '')
        $unread_award_count = 0;
    
    if($unread_publication_count == '')
        $unread_publication_count = 0;
    
    if($unread_funding_count == '')
        $unread_funding_count = 0;
    
    if($unread_job_count == '')
        $unread_job_count = 0;
    
}    
?>


<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));</script>


</html>
<script>
//console.log('<?=$unread_movements_count?>');
//alert('<?=$unread_movements_count?>');
$('#movements_unread_count').html('<?=$unread_movements_count?>');
$('#speaking_unread_count').html('<?=$unread_speaking_count?>');
$('#media_unread_count').html('<?=$unread_media_count?>');
$('#award_unread_count').html('<?=$unread_award_count?>');
$('#publication_unread_count').html('<?=$unread_publication_count?>');
$('#funding_unread_count').html('<?=$unread_funding_count?>');
$('#job_unread_count').html('<?=$unread_job_count?>');



$(function () {
    $('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Collapse this branch');
    $('.tree li.parent_li > span').on('click', function (e) {
        var children = $(this).parent('li.parent_li').find(' > ul > li');
        if (children.is(":visible")) {
            children.hide('fast');
            $(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
        } else {
            children.show('fast');
            $(this).attr('title', 'Collapse this branch').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
        }
        e.stopPropagation();
    });
});



</script>

<?PHP
//if($_GET['employee_size'] != '')
//{    
?>
<script>

var employee_size_limits_val = $('#employee_size_limits').val();
//alert("employee_size_limits: "+employee_size_limits_val);
if(employee_size_limits_val != '')
{
    //alert('within if');
    $('#amount2').val(employee_size_limits_val);
}    
    
    
 
 
var revenue_limits_val = $('#revenue_limits').val();
//alert("employee_size_limits: "+employee_size_limits_val);
if(revenue_limits_val != '')
{
    //alert('within if');
    $('#amount').val(revenue_limits_val);
} 



$( "#company_tab" ).click(function() { 

    //$('#date_tab_body').css('display','block').delay(800);
    //$('#date_tab_body').slideDown(1300).delay(1400);
        
});    
    
        
    
</script>
<?PHP
//}
?>