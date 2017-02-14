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


$base_url = "http://hr.execfile.com/";

$login_page_flow = 0;
if(isset($_GET['login_page_flow']) && $_GET['login_page_flow'] == 1)
    $login_page_flow = 1;


include("header.php"); 
//echo "<br>login_page_flow: ".$login_page_flow;
//die("<br>FA");
if(strpos($_SERVER['HTTP_REFERER'],'login.php') > -1 || $login_page_flow == 1)
{
    $all_data_count = '65543'; //$total_count_without_where;
}
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>"; die();
//echo "<br>Total_count_without_where: ".$total_count_without_where;


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
        
        <input type="hidden" name="hidden_complete_url" id="hidden_complete_url" value="<?=$_SERVER['REQUEST_URI']?>">
        <?PHP
        if($_GET['org'] == 1)
        {
            
        $chart_arr = get_org_chart_data($_GET['company']);    
        echo "<pre>chart_arr: ";   print_r($chart_arr);   echo "</pre>";    
            
            
        ?>    
        <div class="content" style="padding-left:323px;margin-bottom:100px;">
            <div style="padding-bottom:500px;" class="tree well">
                
                
                <?PHP
                $level_1_first = 0;
                $level_2_first = 0;
                $level_3_first = 0;
                if(count($chart_arr) > 0)
                {    
                    foreach($chart_arr as $personal_id => $chart_data)
                    {    
                        
                        if(strlen($chart_data['title']) > 20)
                        $chart_data['title'] = substr($chart_data['title'],0,20);
                    
                        if(strlen($chart_data['company_name']) > 20)
                        $chart_data['company_name'] = substr($chart_data['company_name'],0,20)."..";
                        
                        
                
                        if($chart_data['level'] == 1)
                        {
                            if($level_1_first == 0)
                            {
                        ?>    
                            <ul>
                            <?PHP
                                
                            }
                            
                            
                            if($level_1_first > 0)
                            {
                            ?>
                                <!-- <li>
                                    <span>
                                        <i style="border:none;" class="icon-folder-open">
                                            <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                                        </i>
                                    </span> 
                                    <a href=""><?=$chart_data['first_name']?> <?=$chart_data['last_name']?> at <?=$chart_data['title']?>  <?=$chart_data['company_name']?></a>
                                </li> -->        
                            <?php
                            }
                            ?>
                                
                                
                                <li>
                                    <span>
                                        <i style="border:none;" class="icon-folder-open">
                                            <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                                        </i>
                                    </span> 
                                    <a href=""><?=$chart_data['first_name']?> <?=$chart_data['last_name']?> as <?=$chart_data['title']?> at <?=$chart_data['company_name']?></a>
                        
                        <?PHP
                            if($level_1_first == 0)
                            {
                                $level_1_first++;
                            }
                        
                        }
                        if($chart_data['level'] == 2)
                        {
                            if($level_2_first == 0)
                            {
                                echo "<ul>";
                                $level_2_first++;
                            }    
                        ?>
                            <li>
                                <span>
                                    <i class="icon-minus-sign">
                                        <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                                    </i>
                                </span> 
                                <a href=""><?=$chart_data['first_name']?> <?=$chart_data['last_name']?> as <?=$chart_data['title']?> at <?=$chart_data['company_name']?></a>
                        <?PHP            
                        }
                        if($chart_data['level'] == 3)
                        {
                            if($level_3_first == 0)
                            {
                                echo "<ul>";
                                $level_3_first++;
                            } 
                        ?>
                            <li>
                                <span>
                                    <i class="icon-leaf">
                                        <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                                    </i>
                                </span> 
                                <a href=""><?=$chart_data['first_name']?> <?=$chart_data['last_name']?> as <?=$chart_data['title']?> at <?=$chart_data['company_name']?></a>
                            </li>    
                                
                                
                        <?PHP    
                        }
                        
                    }
                    echo "</ul></li></ul>";
                }
                ?>
                
                
                
                
                <?PHP
                if(1 == 2)
                {    
                ?>
                <ul>
                    <li>
                        <span>
                            <i style="border:none;" class="icon-folder-open">
                            <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                            </i>
                        </span> 
                        <a href="">Goes somewhere</a>
                        <ul>
                            
                            
                            <!--
                            <li>
                                <span><i class="icon-minus-sign"></i> Child</span> 
                                <a href="">Goes somewhere</a>
                                <ul>
                                    <li>
                                        <span><i class="icon-leaf"></i> Grand Child</span> <a href="">Goes somewhere</a>
                                    </li>
                                </ul>
                            </li>
                            -->
                            
                            
                            <li>
                                <span><i class="icon-minus-sign"></i> Faraz parent 2</span>
                                <a href="">Goes somewhere</a>
                            </li>
                            
                            
                            <li>
                                <span><i class="icon-minus-sign"></i> Child</span> 
                                <a href="">Goes somewhere</a>
                                <ul>
                                    <li>
                                        <span><i class="icon-leaf"></i> Grand Child</span> 
                                        <a href="">Goes somewhere</a>
                                    </li>
                                    <li>
                                        <span><i class="icon-minus-sign"></i> Grand Child</span> 
                                        <a href="">Goes somewhere</a>
                                        
                                        <!--    
                                        <ul>
                                            <li>
                                                    <span><i class="icon-minus-sign"></i> Great Grand Child</span> <a href="">Goes somewhere</a>
                                                        <ul>
                                                            <li>
                                                                    <span><i class="icon-leaf"></i> Great great Grand Child</span> <a href="">Goes somewhere</a>
                                                            </li>
                                                            <li>
                                                                    <span><i class="icon-leaf"></i> Great great Grand Child</span> <a href="">Goes somewhere</a>
                                                            </li>
                                                         </ul>
                                            </li>
                                            
                                            
                                            <!--
                                            <li>
                                                    <span><i class="icon-leaf"></i> Great Grand Child</span> <a href="">Goes somewhere</a>
                                            </li>
                                            <li>
                                                    <span><i class="icon-leaf"></i> Great Grand Child</span> <a href="">Goes somewhere</a>
                                            </li>
                                           
                                        </ul>
                                         -->
                                    </li>
                                    <li>
                                            <span><i class="icon-leaf"></i> Grand Child</span> <a href="">Goes somewhere</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    
                    <!--
                    <li>
                        <span><i class="icon-folder-open"></i> Parent2</span> <a href="">Goes somewhere</a>
                        <ul>
                            <li>
                                    <span><i class="icon-leaf"></i> Child</span> <a href="">Goes somewhere</a>
                                    </li>
                                </ul>
                    </li>
                    -->
                </ul>
                
                <?PHP
                }
                ?>
                
                
                
            </div>


            <?PHP
            //echo "<br>Company: ".$_GET['company'];
            
            //$chart_arr = get_org_chart_data($_GET['company']);
            //echo "<pre>chart_arr: ";   print_r($chart_arr);   echo "</pre>";
            if(1 == 2)
            {    
                foreach($chart_arr as $personal_id => $chart_data)
            {    
            ?>
            <div style="display:block;float:left;width:100%">
                <?PHP
                if($chart_data['level'] == 1)
                {    
                ?>
                    <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                    <?=$chart_data['first_name']?> <?=$chart_data['last_name']?>  <?=$chart_data['title']?> at <?=$chart_data['company_name']?>  
                    <div class="verticle-line"></div>
                <?PHP
                }
                ?>
                    
                <?PHP
                if($chart_data['level'] == 2)
                {    
                ?>
                    <div style="float:left;width:100%;">
                        <div style="width:10%;float:left;margin-left:35px;" class="horizontal-line"></div>
                        <div style="float:left;width:75%;margin-top:-35px;">
                            <img src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                            <?=$chart_data['first_name']?> <?=$chart_data['last_name']?> at <?=$chart_data['title']?>  <?=$chart_data['company_name']?>
                            
                            <div class="verticle-line"></div>
                        </div>
                        
                    </div>    
                <?PHP
                }
                ?>    
                
                <?PHP
                if($chart_data['level'] == 3)
                {    
                ?>
                    <div style="float:left;width:100%;">
                        <div style="width:10%;float:left;margin-left:158px;" class="horizontal-line"></div>
                        <div style="float:left;width:65%;margin-top:-35px;">
                            
                                <img style="float:left;display:block;margin-right:8px;" src="no-personal-image.png" height="80" width="80" alt="" class="article-avatar">
                            
                                <p style="width:485px;float:left;margin-bottom:0px;"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?>  <?=$chart_data['title']?> at <?=$chart_data['company_name']?> </p>
                                
                            
                            <div style="margin-left:-87px;min-height:150px;" class="verticle-line"></div>
                            
                        </div>    
                    </div>    
                <?PHP
                }
                ?>    
                    
                    
            </div>    
            <?PHP
            }
            }
            ?>
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
                                $filters = ucfirst($func);
                            
                            
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
                                $filters .= "|COMP:".$companyval;
                            
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
                        
                        
                        if($all_data[$k]['type'] == 'speaking')
                        {
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
                        
                        if($all_data[$k]['type'] == 'funding')
                        {
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
                    
                    $last_move_id = $max_move_id;  //$first_speaking_arr[0];        
                    $last_speaking_id = $max_speaking_id;  //$first_speaking_arr[0];
                    $last_media_id = $max_media_id;  //$first_media_arr[0];
                    $last_publication_id = $max_publication_id; //$first_publication_arr[0];
                    $last_award_id = $max_award_id; //$first_award_arr[0];
                    $last_funding_id = $max_funding_id; //$first_funding_arr[0];
                    $last_job_id =  $max_job_id;  //$first_job_arr[0];
                    
                    
                    
                    
                    //echo "<br>last_media_id: ".$last_media_id;
                    //echo "<br>max_media_id: ".$max_media_id;
                    
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
                            show_movements($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['move_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['movement_type'],$all_data[$i]['more_link'],$all_data[$i]['personal_image'],$personal_pic_root,$all_data[$i]['add_date']);
                        }
                        if($all_data[$i]['type'] == 'funding')
                        {
                            show_funding($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['funding_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['funding_source'],$all_data[$i]['funding_amount'],$all_data[$i]['funding_date'],$personal_pic_root,$all_data[$i]['add_date'],$all_data[$i]['show_state']);
                        }
                        if($all_data[$i]['type'] == 'jobs')
                        {
                            show_job($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['job_title'],$all_data[$i]['post_date'],$all_data[$i]['source'],$personal_pic_root,$all_data[$i]['add_date'],$company_pic_root,$all_data[$i]['show_state']);
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
                    <!--
                        <a href="#" class="btn-prev">
                            <i class="ico-arrow-left"></i>
                            <span>Prev page</span>
                        </a>

                        <a href="#" class="btn-next">
                            <span>Next page</span>
                            <i class="ico-arrow-right"></i>
                        </a>
                    -->
                    <?PHP
                    //echo "<br>pg_int_parameters: ".$pg_int_parameters;
                    echo number_pages($main_page, $p, $total_data, 0, $items_per_page,'&login_page_flow='.$login_page_flow .'&items_per_page='.$items_per_page.$pg_int_parameters);
                    ?>
                </div><!-- /.section-foot -->
                
                <!-- 
                <div class="footer_links" style="text-align:center;width:100%;color:#8899a6;font-size:14px;">
                    
                    © <?=date("Y");?> Execfile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#">About</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#">Help</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#">Terms</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#">Privacy</a>
                </div><br>
                -->
                
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


//echo "<br>Count: ".$total_read;
/*
$tab_col = "(record_type,record_id,user_id)";
$ins_val = '';
for($i=0;$i<=$total_read;$i++)
{
    $rec_type = "movement";
    //INSERT INTO tbl_name (a,b,c) VALUES(1,2,3),(4,5,6),(7,8,9);
    $ins_move_val .= "('".$rec_type."',".$read_movements[$i].",".$current_user."),";
}
if($ins_move_val != '')
{    
    $ins_val = trim($ins_val,",");
    
    $move_ins_query = "INSERT INTO ".TABLE_COUNT."$tab_col values".$ins_move_val;
    //echo "<br>move_ins_query: ".$move_ins_query;
    $ins_move = mysql_query($move_ins_query);
}    
*/
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>";

//echo "<br>unread_publication_count: ".$unread_publication_count;

if(strpos($_SERVER['HTTP_REFERER'],'login.php') > -1)
{    
    //echo "<br>In If";
    
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
    
    update_user_counts($unread_movements_count,$unread_speaking_count,$unread_media_count,$unread_award_count,$unread_publication_count,$unread_funding_count,$unread_job_count);
}
else
{
    //echo "<br>In else";
    
    $unread_movements_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'movement'");
    
    //echo "<br>In else";
    
    $unread_speaking_count = com_db_GetValue("select session_counts from ".TABLE_SESSION_COUNT." where user_id='".$_SESSION['sess_user_id']."' and record_type = 'speaking'");
    
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
    
    
    /*
    if($_GET['type'] == 'movements')
    {
        $unread_movements_count = $movement_count;
    } 
    
    if($_GET['type'] == 'speaking')
    {
        $unread_speaking_count = $speaking_count;
    } 
    
    if($_GET['type'] == 'media')
    {
        $unread_media_count = $media_count;
    } 
    
    if($_GET['type'] == 'publication')
    {
        $unread_publication_count = $publication_count;
    } 
    
    if($_GET['type'] == 'awards')
    {
        $unread_award_count = $award_count;
    } 
    
    if($_GET['type'] == 'funding')
    {
        $unread_funding_count = $funding_count;
    }
    
    if($_GET['type'] == 'jobs')
    {
        $unread_job_count = $job_count;
    }
    */
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