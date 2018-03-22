<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?PHP
$current_page = 'alert.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?PHP if($current_page!='movement.php'){echo 'Execfile.com ::';}?> <?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />


<link rel="stylesheet" href="<?PHP echo asset('style.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('chosen.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('style-search-alert.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('ui-lightness/jquery-ui-1.10.3.custom.min.css'); ?>" type="text/css" >

    
<?php if($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='alert.php'){ ?>
<?php if($current_page=='alert.php'){ ?>
<style>
	#chooseidm011{
	background: url("css/images/select-arrow.png") no-repeat scroll 140px center #FFFFFF;
    width: 164px !important;
	}
	#choosedrop011 {
		width: 164px !important;
	}
</style>
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">

<script src="{{ asset('/js/jquery-1.7.2.min.js') }}"></script>
<script src="{{ asset('/js/jquery.radios.checkboxes.js') }}"></script>
<script src="{{ asset('/js/chosen.jquery.js') }}"></script>
<script src="{{ asset('/js/validation.js') }}"></script>


<script type="text/javascript">
	 $(function() {
	$( "#downloadbtn" ).mouseover(function() {
		$('#downloadshow').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow" ).mouseover(function() {
			$('#downloadshow').css({'display':'block'});
			});
			$( "#downloadshow" ).mouseout(function() {
			$('#downloadshow').css({'display':'none'});
			});
		$('#downloadshow').css({'display':'none'});
	});
	/* alert */
	$( "#setupalertbtn" ).mouseover(function() {
		$('#downloadshow1').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow1" ).mouseover(function() {
			$('#downloadshow1').css({'display':'block'});
			});
			$( "#downloadshow1" ).mouseout(function() {
			$('#downloadshow1').css({'display':'none'});
			});
		$('#downloadshow1').css({'display':'none'});
	});
	
	});
</script>
<?php } ?>

</head>
<body>
<!-- <img src="http://ad.retargeter.com/px?id=61366&amp;t=2" width="1" height="1" /> -->

<div class="header">
    <div class="shell">
        <h1 style="padding-left:0px;"><a href="{{ url('search') }}"><img width="336" height="61" src="{{ asset('/images/new-logo.png') }}"></a></h1>

    </div>
    <!-- /shell -->
</div>

<?php
//echo "<br>actions in view:".$action.":";
$mgtchanges = '';
$sfh = "";
$filter_arr = array(); 

$company_website = "";

if(isset($l_id) && $l_id != '')
{
    $listQuery = "select * from user_saved_lists where l_id = ".$_GET['l_id'];
    $listResult = com_db_query($listQuery);
    $this_list_arr = com_db_fetch_array($listResult);
    $sfh = $this_list_arr['filters'];
    $company_website = $this_list_arr['websites_filter'];
    
    $company_website = str_replace("<br />","\n",$company_website);
    
    
    $filter_arr = explode(":",$sfh);
    
}


if(Session::get('user_id') == '')
{
    //echo "  witninn";
    header('Location: http://execfile.com/index.php#joind_100s');
}

//echo "<pre>selected_filters: ";   print_r($selected_filters);   echo "</pre>";
//die();

$state_id_arr = array();
$industry_id_arr = array();
$employee_size_id_arr = array();
$revenue_size_id_arr = array();
$revenue_ids = array();


if($selected_filters != '')
{        
    $selected_filters_arr = explode(":",$selected_filters);
    //echo "<pre>selected_filters_arr: ";   print_r($selected_filters_arr);   echo "</pre>";
    if(count($selected_filters_arr) > 0)
    {    
        
        if($selected_filters_arr[0] == 'awards')
            $awards = '1';
        if($selected_filters_arr[0] == 'speaking')
            $speaking = '1';
        if($selected_filters_arr[0] == 'publication')
            $publication = '1';
        if($selected_filters_arr[0] == 'media')
            $media_mentions = '1';
        if($selected_filters_arr[0] == 'board')
            $board = '1';
        if($selected_filters_arr[0] == 'jobs')
            $jobs = '1';
        if($selected_filters_arr[0] == 'funding')
            $fundings = '1';
        
        
        
        if($selected_filters_arr[4] != '')
            $zip_code = $selected_filters_arr[4];

        $company = $selected_filters_arr[5];
        $city = $selected_filters_arr[6];
        if($company_website == '')
            $company_website = $selected_filters_arr[7];
        $industry_ids = $selected_filters_arr[8];
        $state_ids =  $selected_filters_arr[9];
        $revenue =  $selected_filters_arr[10];
        $employee_size = $selected_filters_arr[11];
        if($company_website != '')
        {    
            $company_website = trim($company_website);
            $first_four = substr($company_website, 0, 4);

            //echo "<br>company: ".$company;

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
        }    
        //echo "<br>company AFTER:".$company;


        if(strpos($state_ids,',') > -1)
        {
            $state_id_arr = explode(",",$state_ids);
        }        
        else
            $state_id_arr[] = $state_ids;


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



        if(strpos($revenue,',') > -1)
        {
            $revenue_size_id_arr = explode(",",$revenue);

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
    }
}

$submit_btn = "Create Alert";
if($alert_id != '')
{
    //echo "Alert id: ".$_GET['alert_id'];
    //echo "<br>within alert edit";
    $alertResult = DB::select( DB::raw("select * from exec_alert where alert_id='".$alert_id."'") );
    //$industries = array();
    $ind = 0;
    foreach ($alertResult as $this_alert_arr) 
    {
        //$edit_alert_row->industry_id	
        $mgtchanges = $this_alert_arr->mgt_change;
        $speaking = $this_alert_arr->speaking;
        $awards = $this_alert_arr->awards;
        $media_mentions = $this_alert_arr->media_mention;
        $publication = $this_alert_arr->publication;
        $board = $this_alert_arr->board;
        $jobs = $this_alert_arr->jobs;
        $fundings = $this_alert_arr->fundings;

        $employee_size = $this_alert_arr->employee_size;
        $employee_size_id_arr = explode(",",$employee_size);

        $industry_id = $this_alert_arr->industry_id;
        $industry_id_arr = explode(",",$industry_id);

        $state_ids = $this_alert_arr->state;
        $state_id_arr = explode(",",$state_ids);

        $zip_code = $this_alert_arr->zip_code;
        $city = $this_alert_arr->city;
        $company = $this_alert_arr->company;
        $company_website = $this_alert_arr->company_website;

        $revenue = $this_alert_arr->revenue_size;
        $revenue_ids = explode(",",$revenue);

        $delivery_schedule = $this_alert_arr->delivery_schedule;

        $management_type = $this_alert_arr->type;

        $submit_btn = "Update Alert";        

    }
}  

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
            //echo "<br>Action in view:".$action.":";
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
                    
                    {!! Form::open(['url' => 'alerts'])   !!}
                    
                    <div class="form-content clearfix">
                            <div class="fcol fcol2 h490">
                                <h3 class="ico-executive">Chose Executive</h3>
                                <div class="form-content">
                                    <div class="fields">
                                        <div class="row"><label>Title:</label><input style="height:35px;width:260px;margin-left:12px;" type="text" name="title" id="title" title="e.g. CHRO or Vice President - Human Resources" value="<?PHP if($title==''){echo 'e.g. CHRO or Vice President - Human Resources';}else{echo $title;}?>" class="field" /></div><!-- /.row -->
                                        <div class="row"><label style="width:133px;" class="posr-label-select">Management<br /> Change Type:</label>
                                            <select class="chosen-select" style="width:260px;" name="management" id="management">
                                                <option value="">Any</option>
                                                <option <?PHP if($management_type == 1) echo "selected"; ?> value="1">Appointment</option>
                                                <option <?PHP if($management_type == 6) echo "selected"; ?> value="6">Lateral Move</option>
                                                <option <?PHP if($management_type == 2) echo "selected"; ?> value="2">Promotion</option>
                                            </select>
                                        </div><!-- /.row -->
                                    </div><!-- /.fields -->
                                </div><!-- /.form-content -->

                                <h3 class="ico-executive">Chose location</h3>
                                <div class="fields">
                                    <div class="row"><label>Country</label>
                                        <select class="chosen-select" name="country" id="country" style="width:260px;">
                                        @for ($i = 0; $i < count($countries); $i++)
                                            
                                                <?PHP
                                                if($countries[$i]['countries_id'] == 223)
                                                    $selected_s_str = ' selected="selected"';
                                                else
                                                    $selected_s_str = '';
                                                ?>
                                        
                                        
                                            <option <?=$selected_s_str?> value="{{ $countries[$i]['countries_id'] }}"><?=$countries[$i]['countries_name']?></option>
                                        @endfor    
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
                                                <option style="font-family:arial, 'sans-serif';" value="">Any</option>
                                                @for ($j = 0; $j < count($states); $j++)
                                                
                                                <?PHP
                                                if(in_array($states[$j]['state_id'],$state_id_arr))
                                                    $selected_s_str = ' selected="selected"';
                                                else
                                                    $selected_s_str = '';
                                                ?>
                                                
                                                    <option <?=$selected_s_str?> value="{{ $states[$j]['state_id'] }}"><?=$states[$j]['short_name']?></option>
                                                @endfor
                                            </select>
                                        </span>
                                        <!-- <div style="display:block; float:left;"> -->
                                       

                                    <span style="margin-left:5px;">
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
                                        <?PHP
                                        //echo "<pre>industry_id_arr: ";   print_r($industry_id_arr);   echo "</pre>"; 
                                        //echo "<br>count industries: ".count($industries);
                                        ?>
                                        <select class="chosen-select" style="margin-left:6px;width:260px;" name="industry[]" id="industry" multiple data-placeholder="Any">

                                            
                                        @for ($k = 0; $k < count($industries); $k++)
                                            <optgroup label="<?=$industries[$k]['title']?>">
                                            <?PHP 
                                                $indResult = DB::select( DB::raw("select industry_id,title from exec_industry where status=0 and parent_id='".$industries[$k]['industry_id']."'") );
                                                //$industries = array();
                                                $ind = 0;
                                                foreach ($indResult as $alerts_row) 
                                                {
                                                    
                                                    if(in_array($alerts_row->industry_id,$industry_id_arr))
                                                    {
                                                        $selected_str = ' selected="selected"';
                                                        //echo "<br>In selected_str: ".$data_sql[0];
                                                    }
                                                    else
                                                    {
                                                        $selected_str = '';
                                                    }
                                                ?>
                                                    <option <?=$selected_str?> value="{{ $alerts_row->industry_id  }}">{{ $alerts_row->title  }}</option>
                                                <?PHP
                                                }                                        
                                            ?>    
                                            </optgroup> 
                                        @endfor
                                        </select>
                                        
                                    
                                    
                                        </div><!-- /.row -->
                                        
                                        <?PHP
                                        $selected_r_str = '';
                                        //echo "<pre>revenue_arr: ";   print_r($revenue_arr);   echo "</pre>";
                                        //echo "<pre>revenue_ids: ";   print_r($revenue_ids);   echo "</pre>";
                                        ?>
                                        
                                        <div class="row"><label style="width:128px;">Size ($ Revenue)</label>
                                            <select class="chosen-select" style="margin-left:3px;width:260px;" name="revenue_size[]" id="revenue_size" multiple data-placeholder="Any">
                                                
                                                @for ($l = 0; $l < count($revenue_arr); $l++)
                                                    <?PHP
                                                    if(in_array($revenue_arr[$l]['id'],$revenue_ids))
                                                        $selected_r_str = ' selected="selected"';
                                                    else
                                                        $selected_r_str = '';
                                                    ?>
                                                
                                                    
                                                    <option <?=$selected_r_str?> value="{{ $revenue_arr[$l]['id'] }}">{{ $revenue_arr[$l]['name'] }}</option>
                                                @endfor
                                            </select>
                                        </div><!-- /.row -->
                                <div class="row"><label style="width:128px;">Size (Employees)</label>
                                    
                                    <select class="chosen-select" style="width:260px;margin-left:3px" name="employee_size[]" id="employee_size" multiple data-placeholder="Any">
                                        @for ($m = 0; $m < count($emp_arr); $m++)
                                        
                                        <?PHP
                                        if(in_array($emp_arr[$m]['id'],$employee_size_id_arr))
                                            $selected_e_str = ' selected="selected"';
                                        else
                                            $selected_e_str = '';
                                        ?>
                                        
                                        
                                        
                                            <option <?=$selected_e_str?> value="{{ $emp_arr[$m]['id'] }}">{{ $emp_arr[$m]['name'] }}</option>
                                        @endfor
                                    </select>
                                </div><!-- /.row -->
                            </div><!-- /.fields -->
                        </div><!-- /.fcol fcol2 -->	

                    </div><!-- /.form-content -->
                    <div class="form-bottom clearfix">
                        
                        <?PHP
                        
                        //echo "<br>Action: ".$_GET['action'];
                        //echo "<br>Filter arr: ".count($filter_arr);  
                        //die();
                        if(count($filter_arr) > 0)
                        {    
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
                        }
                        //echo "<br>jobs FIRST: ".$jobs;
                        
                        
                        if($alert_id != '')
                        {
                            
                        }    
                        else
                        {    
                            if($action == '')
                                $mgtchanges = 1;
                            else
                            if($mgtchanges == 1)
                                $mgtchanges = 1;
                            else
                                $def_check = "";
                        }    
                        
                        
                        if($speaking == 1 || $awards == 1 || $publication == 1 || $media_mentions == 1 || $board == 1 || $fundings == 1 || $jobs == 1)
                                $mgtchanges = 0;
                        //echo "<br>selected_filters is :".$selected_filters;
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
                                    @for ($n = 0; $n < count($freq_arr); $n++)
                                        <option value="{{ $freq_arr[$n]['id'] }}">{{ $freq_arr[$n]['name'] }}</option>
                                    @endfor
                                </select>
                            </div><!-- /.row -->
                           
                          
                            
                            
                            <div class="row clearfix">
                                {{ Form::hidden('newalert', '1') }}
                                {{ Form::hidden('selected_filters', $selected_filters) }}
                                <input name="sbt" type="submit" value="<?=$submit_btn?>" class="submit" />
                            </div><!-- /.row -->
                          
                        
                            <!-- <div style="padding-top:0px;" class="row clearfix"><span onclick="sub_save_list()"><input type="button" value="Save List" class="submit" /></span></div> -->
                            <div style="padding-top:0px;" class="row clearfix"><input name="sbt" type="submit" value="Save List" class="submit" /></div>
                        
                        </div><!-- /.fcol fcol2 -->
                        
                    </div><!-- /.form-bottom -->
                    <input type="hidden" name="selected_alert" id="selected_alert" value="<?=$alert_id?>">
                    
                    <input type="hidden" name="edit_list" id="edit_list" value="<?=$l_id?>" >
                
                {{ csrf_field() }}  
                {!! Form::close() !!}
                    
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
            
