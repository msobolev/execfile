<?php
session_start();
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>"; 
//echo "<pre>session: ";   print_r($_SESSION['sess_username']);   echo "</pre>"; 

//echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>"; 
//echo "<pre>POST: ";   print_r($_POST);   echo "</pre>"; 
//echo "<br>selected_filters_hidden ONE: ".$_POST['selected_filters_hidden'];
$sfh = $_POST['selected_filters_hidden'];
$filter_arr = explode(":",$_POST['selected_filters_hidden']);

//echo "<br>sfh:".$sfh;
//echo "<pre>FILTER: ";   print_r($filter_arr);   echo "</pre>"; 

include("header-content-page.php");
include("config.php");
include("functions.php");
com_db_connect_hre2() or die('Unable to connect to database server!');
recordTraffic('create_alert');
$company_website = "";

if(isset($_GET['l_id']) && $_GET['l_id'] != '')
{
    $listQuery = "select * from user_saved_lists where l_id = ".$_GET['l_id'];
    $listResult = com_db_query($listQuery);
    $this_list_arr = com_db_fetch_array($listResult);
    $sfh = $this_list_arr['filters'];
    $company_website = $this_list_arr['websites_filter'];
    
    $company_website = str_replace("<br />","\n",$company_website);
    
    
    $filter_arr = explode(":",$sfh);
    $list_name = $this_list_arr['list_name'];
    
}


if(!isset($_SESSION['sess_username']))
{
    //echo "  witninn";
    header('Location: http://execfile.com/index.php#joind_100s');
}
//die();
$action = $_REQUEST['action'];



if($_SESSION['sess_user_id'] == '')
{
    //com_redirect("index.php");
}    

//if($filter_arr[4] != '')
//    $zip_code_arr = get_state_title($filter_arr[9]);

if($filter_arr[4] != '')
    $zip_code = $filter_arr[4];

$company = $filter_arr[5];
$city = $filter_arr[6];
if($company_website == '')
    $company_website = $filter_arr[7];
$industry_ids = $filter_arr[8];
$state_ids =  $filter_arr[9];
$revenue =  $filter_arr[10];
$employee_size = $filter_arr[11];
//$company_website = '';

//echo "<br>company_website:".$company_website;
//echo "<br>company:".$company;
//echo "<br>Strpos:".strpos($company_website,'www.').":";
//if($company_website != '' && (strpos($company_website,'www.') < 0 || strpos($company_website,'www.') == ''))
$company_website = trim($company_website);
$first_four = substr($company_website, 0, 4);
//if(strpos($company_website,'www.') < 0 || strpos($company_website,'www.') == '')
if($first_four != 'www.')
{
    //echo "<br>within one";
    //if(strpos($company_website,'www.') != 0)
    //{    
        //echo "<br>within two";
        $company = $company_website;
        $company_website = '';
    //}    
}        
//echo "<br>company AFTER:".$company;


if(strpos($state_ids,',') > -1)
{
    $state_id_arr = explode(",",$state_ids);
}        
else
    $state_id_arr[] = $state_ids;

//echo "<pre>filter_arr ARR";   print_r($filter_arr);   echo "</pre>";
//echo "<br>employee_size: ".$employee_size;
//echo "<br>revenue: ".$revenue;
//echo "<pre>industry_id_arr ARR";   print_r($employee_size);   echo "</pre>";

if(strpos($industry_ids,',') > -1)
{
    $industry_id_arr = explode(",",$industry_ids);
}        
else
    $industry_id_arr[] = $industry_ids;


if(strpos($employee_size,',') > -1)
{
    $employee_size_id_arr = explode(",",$employee_size);
    
}        
else
    $employee_size_id_arr[] = $employee_size;


//echo "<br>revenue:".$revenue;
if(strpos($revenue,',') > -1)
{
    $revenue_size_id_arr = explode(",",$revenue);
    
    // New code
    //$revenue_size_id_arr[0] = $revenue_size_id_arr[0]+2;
    
    
    $new_revenue_id = "";
    if($revenue_size_id_arr[0] < $revenue_size_id_arr[1])
    {
        $initial_revenue_id = 2;
        //for($r=$revenue_limits[0];$r<=$revenue_limits[1];$r++)
        for($r=$revenue_size_id_arr[0];$r<$revenue_size_id_arr[1];$r++)
        {
            $new_revenue_id = $r+$initial_revenue_id;
            $revenue_ids[] = $new_revenue_id;
        }
    }
}        
else
    $revenue_size_id_arr[] = $revenue;
//echo "<br>revenue: ".$revenue;
//echo "<pre>revenue_size_id_arr ARR";   print_r($revenue_size_id_arr);   echo "</pre>";



//echo "<br>revenue: ".$revenue;
//echo "<pre>revenue_size_id_arr ARR";   print_r($revenue_size_id_arr);   echo "</pre>";
//echo "<pre>revenue_id ARR";   print_r($revenue_ids);   echo "</pre>";

//$employee_size_id_arr

//echo "<br>zip_code: ".$zip_code;
//com_db_connect() or die('Unable to connect to database server!');
//echo "<pre>industry_id_arr ONE: ";   print_r($industry_id_arr);   echo "</pre>";

$submit_btn = "Create Alert";
if(isset($_GET['alert_id']) && $_GET['alert_id'] != '')
{
    //echo "Alert id: ".$_GET['alert_id'];
    $alertQuery = "select * from ".TABLE_ALERT." where alert_id = ".$_GET['alert_id'];
    $alertResult = com_db_query($alertQuery);
    $this_alert_arr = com_db_fetch_array($alertResult);
    $mgtchanges = $this_alert_arr['mgt_change'];
    $speaking = $this_alert_arr['speaking'];
    $awards = $this_alert_arr['awards'];
    $media_mentions = $this_alert_arr['media_mention'];
    $publication = $this_alert_arr['publication'];
    $board = $this_alert_arr['board'];
    $jobs = $this_alert_arr['jobs'];
    $fundings = $this_alert_arr['fundings'];
    
    $employee_size = $this_alert_arr['employee_size'];
    $employee_size_id_arr = explode(",",$employee_size);
    
    $industry_id = $this_alert_arr['industry_id'];
    $industry_id_arr = explode(",",$industry_id);
    
    $state_ids = $this_alert_arr['state'];
    $state_id_arr = explode(",",$state_ids);
    
    $zip_code = $this_alert_arr['zip_code'];
    $city = $this_alert_arr['city'];
    $company = $this_alert_arr['company'];
    $company_website = $this_alert_arr['company_website'];
    
    $revenue = $this_alert_arr['revenue_size'];
    $revenue_size_id_arr = explode(",",$revenue);
    $revenue_ids = $revenue_size_id_arr;
    $raw_revenue = $this_alert_arr['raw_revenue'];
    
    $delivery_schedule = $this_alert_arr['delivery_schedule'];
    
    $management_type = $this_alert_arr['type'];
    
    $chief_level = $this_alert_arr['chief_level'];
    $vp_level = $this_alert_arr['vp_level'];
    $director_level = $this_alert_arr['director_level'];
    
    $hide_submit_button = $this_alert_arr['hide_submit_button'];
    
    $submit_btn = "Update Alert";
    
    // case when user comes from setting page, $sfh is not set in that case
    //$sfh = $type.":".$func.":".$from_date.":".$to_date.":".$zip.":".$searchnow.":".$city.":".$companyval.":".$industries_ids.":".$state_ids.":".$revenue.":".$employee_size;
    
    $type_p = $mgtchanges.",".$speaking.",".$awards.",".$media_mentions.",".$publication.",".$board.",".$jobs.",".$fundings;
    $func_p = 'hr';
    $from_date_p = '';
    $to_date_p = '';
    $zip_p = $zip_code;
    $searchnow_p = '';
    $city_p = $city;
    $companyval_p = '';
    $industries_ids_p = $industry_id;
    $state_ids_p = $state_ids;
    $revenue_p = $revenue;
    $employee_size_p = $employee_size;
    //$sfh = $type_p.":".$func_p.":".$from_date_p.":".$to_date_p.":".$zip_p.":".$searchnow_p.":".$city_p.":".$companyval_p.":".$industries_ids_p.":".$state_ids_p.":".":".$revenue_p.":".$employee_size_p;
    $sfh = $type_p.":".$func_p.":".$from_date_p.":".$to_date_p.":".$zip_p.":".$searchnow_p.":".$city_p.":".$companyval_p.":".$industries_ids_p.":".$state_ids_p.":".":".$raw_revenue.":".$employee_size_p;
    
}  
echo "<br>sfh:".$sfh;

//echo "<pre>";   print_r($revenue_ids);   echo "</pre>";   



//echo "<br>media_mentions: ".$media_mentions;
?>
<style>
.ico-executive    
{
    margin-bottom:0px;
}
</style>
<script language="javascript">
function sub_save_list()
{
    document.getElementById("frm_save_list").submit();
}
</script>


    <div class="email-alert" style="padding-top:85px;">
        <div class="page-head" style="padding-top:0px;">
            <div class="shell">
                

                <h2>Create an Email Alert</h2>
            </div><!-- /.shell -->
        </div><!-- /.page-head -->	

        <div class="main">
            <div class="shell">
            <?PHP
                if($action == 'added')
                {    
                    
                ?>
                <h4 style="color:red;">Alert Created.</h4>
                <?PHP
                }
                elseif($action == 'updated')
                {    
                    
                ?>
                <h4 style="color:red;">Alert Updated.</h4>
                <?PHP
                }
                elseif($action == 'SaveList')
                {    
                    
                ?>
                <h4 style="color:red;">List Saved.</h4>
                <?PHP
                }
                elseif($action == 'EditList')
                {    
                    
                ?>
                <h4 style="color:red;">List Updated.</h4>
                <?PHP
                }
                $country = "223";
                ?>
                <div class="alert-form">
                <?PHP if($action =='' || $action == 'AlertBack' || $action == 'added' || $action == 'updated'  || $action == 'SaveList' || $action == 'EditList'){ ?>
                    <!-- <script type="text/javascript" src="selectuser.js" language="javascript"></script> -->
                    <!-- <form name="frm_alert" id="frm_alert" method="post" action="alert.php?action=ReadAlert"> -->
                    <form name="frm_alert" id="frm_alert" method="post" action="alert-pro.php?action=AlertCreate">
                    <div class="form-content clearfix">
                            <div class="fcol fcol2 h490">
                                <h3 class="ico-executive">Chose Executive</h3>
                                <div class="form-content">
                                    <div class="fields">
                                        
                                        <?PHP
                                        if(isset($_GET['l_id']) && $_GET['l_id'] != '')
                                        {    
                                        ?>
                                        <div class="row"><label style="width:121px;">List Name</label><input style="width:260px;height:35px;margin-left:22px;" name="list_name" type="text" id="list_name" title="" value="<?PHP if($list_name==''){echo '';}else{echo $list_name;}?>" class="field" /></div><!-- /.row -->
                                        <?PHP
                                        }
                                        ?>
                                        
                                        <div class="row">
                                            <label>Title:</label>
                                            <!-- <input style="height:35px;width:260px;margin-left:12px;" type="text" name="title" id="title" title="e.g. CHRO or Vice President - Human Resources" value="<?PHP //if($title==''){echo 'e.g. CHRO or Vice President - Human Resources';}else{echo $title;}?>" class="field" /> -->
                                            <input style="position: relative;top:2px;" type="checkbox" value="chief"  name="chief_title_level" id="chief_title_level" <?PHP if($chief_level == 1) echo "checked"; ?> />
                                            <label style="text-align:left;margin-left:0px;width:50px;" for="mgtchanges">C Level</label>
                                            &nbsp;&nbsp;
                                            <input style="position: relative;top:2px;" type="checkbox" value="vp"  name="vp_title_level" id="vp_title_level" <?PHP if($vp_level == 1) echo "checked"; ?> />
                                            <label style="text-align:left;margin-left:0px;width:58px;" for="mgtchanges">VP Level</label>
                                            &nbsp;&nbsp;
                                            <input style="position: relative;top:2px;" type="checkbox" value="director"  name="director_title_level" id="director_title_level" <?PHP if($director_level == 1) echo "checked"; ?> />
                                            <label style="text-align:left;margin-left:0px;width:78px;" for="mgtchanges">Director Level</label>
                                            
                                        </div>
                                        <div class="row"><label style="width:133px;" class="posr-label-select">Management<br /> Change Type:</label>
                                            <select class="chosen-select" style="width:260px;" name="management" id="management">
                                                <option value="">Any</option>
                                                <option <?PHP if($management_type == 1) echo "selected"; ?> value="1">Appointment</option>
                                                <option <?PHP if($management_type == 2) echo "selected"; ?> value="2">Lateral Move</option>
                                                <option <?PHP if($management_type == 3) echo "selected"; ?> value="3">Promotion</option>
                                            </select>
                                        </div><!-- /.row -->
                                    </div><!-- /.fields -->
                                </div><!-- /.form-content -->

                                <h3 class="ico-executive">Chose location</h3>
                                <div class="fields">
                                    <div class="row"><label>Country</label>
                                        <select class="chosen-select" name="country" id="country" style="width:260px;">
                                            <?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country,$internal)?>
                                        </select>
                                    </div><!-- /.row -->



                                    <div style="display:block; float:left;width:100%;">
                                        <!-- <div class="row select140" style="display:block; float:left;width:161px;text-align:right;"> -->
                                        <span class="row select140">
                                            <label style="width:162px;">State</label>
                                        </span>
                                        <!-- <div style="display:block; float:left;width:200px;margin-bottom:10px;margin-left:4px;"> -->
                                        <span>
                                            <select class="chosen-select" name="state[]" id="state" multiple data-placeholder="Any" style="height:80px;padding-left:5px;">
                                                <option value="">Any</option>
                                                <?=MultiSelectionComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state_id_arr)?>
                                            </select>
                                        </span>
                                        <!-- <div style="display:block; float:left;"> -->
                                       

                                    <span style="margin-left:5px;">
                                        <!-- <input style="margin-left:0px;width: 90px;height: 35px;margin-top: 6px;" name="zip_code" type="text" id="zip_code" title="Zip Code" value="<?PHP if($zip_code==''){echo 'Zip Code';}else{echo $zip_code;}?>" class="field field110 field110a" /> -->
                                        <input style="margin-left:8px;width: 90px;height: 35px;margin-top: 6px;" name="zip_code" type="text" id="zip_code" title="Zip Code" value="<?PHP if($zip_code==''){echo 'Zip Code';}else{echo $zip_code;}?>" class="field field110 field110a" />
                                    </span><!-- /.row -->    
                                    
                                    
                                    <div class="row"><label>City</label><input style="width:260px;height:35px;" name="city" type="text" id="city" title="" value="<?=$city?>" class="field" /></div><!-- /.row -->
                                
                                    
                                </div>     
                                    
                                    
                                </div><!-- /.fields -->
                            </div><!-- /.fcol fcol2 -->	

                            <div class="fcol fcol2 h490">
                                <h3 class="ico-company">Chose Company</h3>
                                <div class="fields">
                                    <div class="row"><label style="width:121px;">Company Name</label><input style="width:260px;height:35px;" name="company" type="text" id="company" title="e.g. Microsoft" value="<?PHP if($company==''){echo 'e.g. Microsoft';}else{echo $company;}?>" class="field" /></div><!-- /.row -->
                                    <div class="row row-textarea" style=""><label class="posr-label-textarea" style="padding-right:10px;">Paste URLs (up to 25)<br />of companies you'd <br />like to track</label>
                                        <textarea name="company_website" id="company_website" class="field-textarea"><?=$company_website?></textarea>
                                    </div><!-- /.row -->
                                    <div class="row" style="padding-top:0px;"><label style="width:125px;">Industry</label>
                                        <?PHP 	$indQuery = "select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id=0";
                                        $indResult = com_db_query($indQuery);
                                        ?>
                                        <?PHP
                                        //echo "<br>indQuery: ".$indQuery;
                                        //echo "<pre>industry_id_arr: ";   print_r($industry_id_arr);   echo "</pre>";
                                        ?>
                                        
                                        
                                        
                                        
                                        <select class="chosen-select" style="margin-left:6px;width:260px;" name="industry[]" id="industry" multiple data-placeholder="Any">
                                        
                                            <?PHP while($indRow = com_db_fetch_array($indResult)){ ?>
                                            <optgroup label="<?=com_db_output($indRow['title'])?>">
                                        <?=MultiSelectionComboBox("select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id='".$indRow['industry_id']."'",$industry_id_arr)?>
                                            </optgroup> 
                                            <?PHP } ?>
                                         </select> 
                                        </div><!-- /.row -->
                                        <?PHP
                                        //echo "<br>Query: select id,name from ".TABLE_REVENUE_SIZE." where status=0 order by from_range",$revenue_size_id_arr
                                        ?>
                                        <div class="row"><label style="width:128px;">Size ($ Revenue)</label>
                                            <select class="chosen-select" style="margin-left:3px;width:260px;" name="revenue_size[]" id="revenue_size" multiple data-placeholder="Any">
                                                <?=MultiSelectionComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status=0 order by from_range",$revenue_ids)?> <!-- $revenue_size_id_arr -->
                                            </select>
                                        </div><!-- /.row -->
                                <div class="row"><label style="width:128px;">Size (Employees)</label>
                                    <select class="chosen-select" style="width:260px;margin-left:3px" name="employee_size[]" id="employee_size" multiple data-placeholder="Any">
                                        <?=MultiSelectionComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status=0 order by from_range",$employee_size_id_arr)?>
                                    </select>
                                </div><!-- /.row -->
                            </div><!-- /.fields -->
                        </div><!-- /.fcol fcol2 -->	

                    </div><!-- /.form-content -->
                    <div class="form-bottom clearfix">
                        
                        <?PHP
                        //echo "<br>Action: ".$_GET['action'];

                        if($filter_arr[0] == 'speaking' || strpos($filter_arr[0],"speaking") > -1)
                            $speaking = '1';
                        
                        if($filter_arr[0] == 'awards' || strpos($filter_arr[0],"awards") > -1)
                            $awards = '1';
                        
                        if($filter_arr[0] == 'publication' || strpos($filter_arr[0],"publication") > -1)
                            $publication = '1';
                        
                        if($filter_arr[0] == 'media' || $filter_arr[0] == 'media_mention' || strpos($filter_arr[0],"media_mention") > -1)
                            $media_mentions = '1';
                        
                        if($filter_arr[0] == 'board' || strpos($filter_arr[0],"board") > -1)
                            $board = '1';
                        
                        
                        
                        if($filter_arr[0] == 'funding' || strpos($filter_arr[0],"funding") > -1)
                            $fundings = '1';
                        
                        if($filter_arr[0] == 'jobs' || strpos($filter_arr[0],"jobs") > -1)
                            $jobs = '1';
                        
                        //echo "<br>mgtchanges FIRST: ".$mgtchanges;
                        
                        
                        if($_GET['alert_id'] != '')
                        {
                            
                        }    
                        else
                        {    
                            if($_GET['action'] == '')
                                $mgtchanges = 1;
                            else
                            if($mgtchanges == 1)
                                $mgtchanges = 1;
                            else
                                $def_check = "";
                        }    
                        //echo "<br>mgtchanges SECOND: ".$mgtchanges;
                        ?>
                        
                        <div class="fcol fcol2 h220" style="height:274px;">
                            <h3 class="ico-engagement">Chose Engagement Triggers</h3>
                            <div class="row row-checkboxes">
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="mgtchanges" id="mgtchanges" <?PHP if($mgtchanges==1){echo 'checked="checked"';}else{echo '';}?> /><label style="text-align:left;margin-left:5px;" for="mgtchanges">Management Changes</label></div><!-- /.checkbox -->                                        
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="speaking" id="speaking" <?PHP if($speaking==1){echo 'checked="checked"';}else{echo '';}?> /><label style="text-align:left;margin-left:5px;" for="speaking">Speaking Engagements</label></div><!-- /.checkbox -->
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="awards" id="awards" <?PHP if($awards==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="awards">Industry Awards</label></div><!-- /.checkbox -->
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="publication" id="publication" <?PHP if($publication==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="publication">Publications</label></div><!-- /.checkbox -->
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="media_mentions" id="media_mentions" <?PHP if($media_mentions==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="media_mentions">Media Mentions</label></div><!-- /.checkbox -->
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="board" id="board" <?PHP if($board==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="board">Board Appointments</label></div><!-- /.checkbox -->

                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="jobs" id="jobs" <?PHP if($jobs==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="jobs">Jobs</label></div> <!-- /.checkbox -->
                                <div class="checkbox-holder clearfix"><input style="position: relative;top:2px;" type="checkbox" value="1"  name="fundings" id="fundings" <?PHP if($fundings==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="fundings">Fundings</label></div>  <!-- /.checkbox -->
                            </div><!-- /.row -->
                        </div><!-- /.fcol fcol2 -->

                        <div class="fcol fcol2 h220">
                            <h3 class="ico-frequency">Chose Frequency</h3>
                            <div class="row pt25"><label>Deliver email alerts</label>
                                <select class="chosen-select" name="delivery_schedule" id="delivery_schedule">
                                    <?=selectComboBox("select name,name from ".TABLE_EMAIL_UPDATE." order by id",$delivery_schedule)?>
                                </select>
                            </div><!-- /.row -->
                            <div class="row clearfix"><input name="sbt" type="submit" value="<?=$submit_btn?>" class="submit" /></div><!-- /.row -->
                        
                        
                            <!-- <div style="padding-top:0px;" class="row clearfix"><span onclick="sub_save_list()"><input type="button" value="Save List" class="submit" /></span></div> -->
                            <div style="padding-top:0px;" class="row clearfix"><input name="sbt" type="submit" value="Save List" class="submit" /></div>
                        
                        </div><!-- /.fcol fcol2 -->
                        
                        
                        &nbsp;&nbsp;
                        <input style="position: relative;top:2px;" type="checkbox" value="1"  name="remove_email_btn" id="remove_email_btn" <?PHP if($hide_submit_button == 1) echo "checked"; ?> />
                        <label style="text-align:left;margin-left:0px;width:50px;" for="remove_email_btn">Remove Email button</label>
                        &nbsp;&nbsp;
                        
                        
                        
                        
                        
                        
                    </div><!-- /.form-bottom -->
                    <input type="hidden" name="selected_alert" id="selected_alert" value="<?=$_GET['alert_id']?>">
                    <input type="hidden" name="selected_filters" id="selected_filters" value="<?=$sfh?>" >
                    <input type="hidden" name="edit_list" id="edit_list" value="<?=$_GET['l_id']?>" >
                    
                </form>
                    
                    
                <!--    
                <form name="frm_save_list" id="frm_save_list" method="post" action="alert.php?action=SaveList">
                    <input type="hidden" name="selected_filters" id="selected_filters" value="<?=$sfh?>" >
                </form>    
                -->    
                    
                    <?PHP  
                
                }
                    elseif($action=='ReadAlert')
                    { ?>
                        <table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td align="left" valign="top" style="font-size:20px;padding:10px 0 0 10px;">Confirm Your Email Alert</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Executive:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                         
                          <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Title:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$title?> </td>
                              </tr>
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Management Change Type:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$management_type?></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Location:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Country:</td>
                              <td width="251" align="left" valign="top" class="list-field-text"><?=$country_name?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">State:</td>
                              <td width="251"  align="left" valign="top" class="list-field-text"><?=$state_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">City:</td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$city?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Zip Code: </td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$zip_code?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Company:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Company:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Include urls of companies <br /> 
                              you'd like to track:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company_website?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$industry_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size ($Revenue):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$revenue_size_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size (Employees):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$employee_size_list?></td>
                            </tr>
                            
                            
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Jobs:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($jobs==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
							
							
							
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Fundings:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($fundings==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            
                            
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Person:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Speaking:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><? if($speaking==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry Awards</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><? if($awards==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Publications:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($publication==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Media Mentions:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($media_mentions==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Board Appointments:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($board==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Frequency and Budget:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                           
                              <tr>
                                <td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td width="232" height="27" align="left" valign="middle" class="list-field-text">Email Alerts will be delivered:</td>
                                         <td width="251"  align="left" valign="top" class="list-field-text"><?=$delivery_schedule?></td>
                                    </tr>
                                </table></td>
                              </tr>
                                                  
                              <tr>
                               <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                                <table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" valign="top">
                                      <form name="frmAlertBack" id="frmAlertBack" method="post" action="alert.php?action=AlertBack">
                                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
                                            
                                            <input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
                                            <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                            
                                        </td></tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">
                                            <a href="javascript:FormValueSubmit('frmAlertBack');"> Back</a>
                                        
                                        </td>
                                        </tr>
                                       </table>	
                                       </form>
                                      </td>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td align="center" valign="top">
                                         <form name="frmAlertConfirm" id="frmAlertConfirm" method="post" action="alert-pro.php?action=AlertCreate">
                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
                                            
                                            <input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
                                            <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">	
                                            <a href="javascript:FormValueSubmit('frmAlertConfirm');"> Confirm</a>
                                            </td>
                                            </tr>
                                        </table>	
                                      </form>
                                      </td>
                                    </tr>
                                  </table>
                            </td>
                        </tr>
                
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
			  <?PHP } ?>   
				</div><!-- /.alert-form -->
			</div><!-- /.shell -->
		</div><!-- /.main -->		
	</div><!-- /.email-alert -->

            
<script language="javascript">
    $(".chosen-select").chosen();
</script>    
            
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>