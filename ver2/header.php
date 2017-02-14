<!DOCTYPE html>
<html lang="en">
    <head>
<?PHP
$root_path = "http://45.55.139.16/ver2/";
?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExecFile</title>
    <link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />
    <!-- Vendor Styles -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!-- App Styles -->
    <link rel="stylesheet" href="vendor/jquery-ui-1.11.4.custom/jquery-ui.css" />
    <link rel="stylesheet" href="vendor/DropKick-master/build/css/dropkick.css" />
    <link rel="stylesheet" href="vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.css" />
    <link rel="stylesheet" href="css/style.css" />

    <!-- Vendor JS -->
    <script src="<?=$root_path?>vendor/jquery-1.11.3.min.js"></script>
    <script src="<?=$root_path?>vendor/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
    <script src="<?=$root_path?>vendor/jquery-ui-1.11.4.custom/jquery.ui.touch-punch.min.js"></script>
    <script src="<?=$root_path?>vendor/DropKick-master/build/js/dropkick.min.js"></script>
    <script src="<?=$root_path?>vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.js"></script>
    
    <script src="<?=$root_path?>vendor/jquery.query-object.js"></script>
    
    
<!-- https://github.com/xoxco/jQuery-Tags-Input -->
    <!-- App JS -->

<script src="js/functions.js"></script>
    
  <!-- Auto Complete starts   -->
  <!-- https://jqueryui.com/autocomplete/ -->
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
      <script>
  $(function() {
    var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#developer" ).autocomplete({
      //source: availableTags
      source: "get_searchnow_data.php"
      //source: "autop/get_searchnow_data.php"
      //source: "autop/demo_cities.php"
    });
  });


$(function() {
    
    $( "#city" ).autocomplete({
      //source: availableTags
      source: "get_cities_data.php"
    });
  });


$(function() {
    $( "#field-company-name" ).autocomplete({
      //source: availableTags
      source: "get_all_company_data.php"
    });
});
  
  
function zipKeyPress(e)
{
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var zip_val = $('#zip').val();
        if(zip_val != '')
        {    
            var from_date = $("#from").val();
            var to_date = $("#to").val();
            var type = $("#type").val();
            var hidden_industries = '';
            if ($("#hidden_industires").val() != '')
            {
                hidden_industries = $("#hidden_industires").val();
            }
        
            var hidden_revenue = $("#hidden_revenue").val();
            var hidden_states = '';
            if ($("#hidden_states").val() != '')
            {
                hidden_states = $("#hidden_states").val();
            }
            var city_val = $('#city').val();
            var hidden_employee_size = $("#hidden_employee_size").val();
        
            window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&industries="+hidden_industries+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size;
        }    
    }    
}

function searchKeyPress(e)
{
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var searchnow = $('#developer').val();
        //alert("HERE Search now : "+searchnow);
        if(searchnow != '')
        {    
            var from_date = $("#from").val();
            var to_date = $("#to").val();
            var type = "all";
            var hidden_industires = '';
            if ($("#type").val() != '')
            {
                type = $("#type").val();
            }
            
            
            if ($("#hidden_industires").val() != '')
            {
                hidden_industires = $("#hidden_industires").val();
            }
            var hidden_revenue = $("#hidden_revenue").val();
            var hidden_states = '';
            if ($("#hidden_states").val() != '')
            {
                hidden_states = $("#hidden_states").val();
            }
            var city_val = $('#city').val();
            var hidden_employee_size = $("#hidden_employee_size").val();
            
            
            window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&searchnow="+searchnow+"&industries="+hidden_industires+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size;
        }    
    }    
}


function companyKeyPress(e)
{
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var searchnow = $('#field-company-name').val();
        //alert("HERE Search now : "+searchnow);
        if(searchnow != '')
        {    
            var from_date = $("#from").val();
            var to_date = $("#to").val();
            var type = "all";
            var zip_val = $('#zip').val();
            if ($("#type").val() != '')
            {
                type = $("#type").val();
            }    
            var hidden_states = '';
            if ($("#hidden_states").val() != '')
            {
                hidden_states = $("#hidden_states").val();
            }
            
            var city_val = $('#city').val();
            var industries = $('#hidden_industires').val();
            
            var hidden_revenue = $("#hidden_revenue").val();
            var hidden_employee_size = $("#hidden_employee_size").val();
            
            window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&companyval="+searchnow+"&states="+hidden_states+"&industries="+industries+"&city="+city_val+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
        }    
    }    
}

function cityKeyPress(e)
{ 
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var city_val = $('#city').val();
        if(city_val != '')
        {    
            var from_date = $("#from").val();
            var to_date = $("#to").val();
            var type = "all";
            var zip_val = $('#zip').val();
            if ($("#type").val() != '')
            {
                type = $("#type").val();
            }    
            var hidden_states = '';
            if ($("#hidden_states").val() != '')
            {
                hidden_states = $("#hidden_states").val();
            }
            var city_val = $('#city').val();
            var industries = $('#hidden_industires').val();
            
            var hidden_revenue = $("#hidden_revenue").val();
            var hidden_employee_size = $("#hidden_employee_size").val();
            
            window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
        }    
    }    
}



function update_search()
{
    var industries = '';
    $("input:checkbox[class=industry_chk]:checked").each(function () 
    {
        //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
        var selected_industry = $(this).attr("id");
        var industry_id = selected_industry.replace("field-", "");
        industries += industry_id+",";
    });        
    //alert("Industries: "+industries);
    var from_date = $("#from").val();
    var to_date = $("#to").val();
    var zip_val = $('#zip').val();
    var type = "all";
    if ($("#type").val() != '')
    {
        type = $("#type").val();
    }
    var hidden_states = '';
    if ($("#hidden_states").val() != '')
    {
        hidden_states = $("#hidden_states").val();
    }
    var city_val = $('#city').val();
    var hidden_revenue = $("#hidden_revenue").val();
    var hidden_employee_size = $("#hidden_employee_size").val();
    
    window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
}


function update_state_search()
{
    
    var states = '';
    $("input:checkbox[class=state_chk]:checked").each(function () 
    {
        //alert("Id: " + $(this).attr("id") + " Value: " + $(this).val());
        var selected_states = $(this).attr("id");
        var state_id = selected_states.replace("state-", "");
        states += state_id+",";
    });        
    //alert("States: "+states);
    var from_date = $("#from").val();
    var to_date = $("#to").val();
    var zip_val = $('#zip').val();
    var type = "all";
    if ($("#type").val() != '')
    {
        type = $("#type").val();
    }    
    var city_val = $('#city').val();
    var industries = $('#hidden_industires').val();
    
    var hidden_revenue = $("#hidden_revenue").val();
    var hidden_employee_size = $("#hidden_employee_size").val();
    
    window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
        
}


function markRead(current_user_id)
{
    var last_move_id = $('#last_move_id').val();  
    var last_speaking_id = $('#last_speaking_id').val();
    var last_media_id = $('#last_media_id').val();
    
    var last_publication_id = $('#last_publication_id').val();
    var last_award_id = $('#last_award_id').val();
    var last_funding_id = $('#last_funding_id').val();
    //alert("Funding ID: "+last_funding_id); return false;
    var last_job_id = $('#last_job_id').val();
    
    $.ajax({
    method: "POST",
    url: "updateCount.php",
    data: { last_move_id: last_move_id,last_speaking_id: last_speaking_id,last_media_id: last_media_id,last_publication_id: last_publication_id,last_award_id: last_award_id,last_funding_id: last_funding_id,last_job_id: last_job_id }
    
    //alert("URL+DATA: "+url+data);    
        
    })
    .done(function( msg ) 
    {
        //alert( "Data: " + data );
        //alert( "Data Saved: " + msg );
        $("#movements_unread_count").hide();
        $("#speaking_unread_count").hide();
        $("#media_unread_count").hide();
        $("#publication_unread_count").hide();
        $("#award_unread_count").hide();
        $("#funding_unread_count").hide();
        $("#job_unread_count").hide();
    });
    
    
    
    if(current_user_id > 0)
    {
        $(".list-checkboxes").hide();
        $(".ico-check").hide();
    }    
}


</script>
<!-- Auto Complete ends   -->

</head>
<body>
<?PHP
// http://45.55.139.16/ver2/home.php

ini_set('memory_limit','2048M');

define("EXECFILE_ROOT","http://45.55.139.16/");

define("NO_PERSONAL_IMAGE","no-personal-image.png");

$main_page = "home.php";
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 10;
$total_data = "";

$current_user_id = "";
//$_SESSION['user_id'] = 1;
if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
{
    $current_user_id = $_SESSION['sess_user_id'];
}    

$profile_root_link = "https://www.hrexecsonthemove.com/";
//$twitter_share_link = "https://twitter.com/share?url=https://www.execfile.com";
//$twitter_share_link = "https://twitter.com/share?";
//$linkedin_share_link = "https://www.linkedin.com/cws/share?url=https://www.execfile.com";
//$linkedin_share_link = "https://www.linkedin.com/cws/share?";
//https://www.linkedin.com/cws/share?url=http%3A%2F%2Fgoogle.com

include("config.php");
include("functions.php");


if(isset($_GET['rem']) && $_GET['rem'] != '')
{
    $types_arr = array("movements","Speaking","Media Mentions","Publication","Industry Awards","Funding","Jobs");

    if(strpos($_GET['rem'],"IND:") > -1)
        $_GET['industries'] = '';

    elseif(strpos($_GET['rem'],"STA:") > -1)
        $_GET['states'] = '';
    elseif($_GET['rem'] == 'Appointments')        
        $_GET['type'] = 'all';
    elseif(in_array($_GET['rem'],$types_arr))
        $_GET['type'] = 'all';
    elseif(strpos($_GET['rem'],"T:") > -1)
    {        
        $_GET['to_date'] = "";
        $_GET['from_date'] = "";
    }
    elseif(strpos($_GET['rem'],"ZIP:") > -1)
        $_GET['zip'] = '';
    elseif(strpos($_GET['rem'],"C:") > -1)
        $_GET['city'] = '';
    elseif(strpos($_GET['rem'],"S:") > -1)
        $_GET['employee_size'] = '';
    elseif(strpos($_GET['rem'],"COMP:") > -1)
    {        
        $_GET['searchnow'] = '';
        $_GET['companyval'] = '';
    }

     elseif(strpos($_GET['rem'],"mil") > -1 || strpos($_GET['rem'],"bil") > -1)
        $_GET['revenue'] = '';
}
        
$pg_int_parameters = "";
if(isset($_GET['from_date']) && $_GET['from_date'] != '')
{
    $from_date_initial = $_GET['from_date'];
    $from_year = substr($from_date_initial,6,4);
    $from_month = substr($from_date_initial,0,2);
    $from_day = substr($from_date_initial,3,2);
    $from_date = $from_year."-".$from_month."-".$from_day;
    $pg_int_parameters .= "&from_date=".$from_date_initial;
    
    
    
}
if(isset($_GET['to_date']) && $_GET['to_date'] != '')
{
    $to_date_initial = $_GET['to_date'];
    $to_year = substr($to_date_initial,6,4);
    $to_month = substr($to_date_initial,0,2);
    $to_day = substr($to_date_initial,3,2);
    $to_date = $to_year."-".$to_month."-".$to_day;
    $pg_int_parameters .= "&to_date=".$to_date_initial;
}


if(isset($_GET['zip']) && $_GET['zip'] != '')
{
    $zip = $_GET['zip'];
    $pg_int_parameters .= "&zip=".$zip;
}

if(isset($_GET['searchnow']) && $_GET['searchnow'] != '')
{
    $searchnow = $_GET['searchnow'];
    $pg_int_parameters .= "&searchnow=".$searchnow;
}

if(isset($_GET['companyval']) && $_GET['companyval'] != '')
{
    $companyval = $_GET['companyval'];
    $pg_int_parameters .= "&companyval=".$companyval;
}


if(isset($_GET['city']) && $_GET['city'] != '')
{
    $city = $_GET['city'];
    $pg_int_parameters .= "&city=".$searchnow;
}

if(isset($_GET['industries']) && $_GET['industries'] != '')
{
    $industries = $_GET['industries'];
    $pg_int_parameters .= "&industries=".$industries;
    $industries_ids = trim($industries,",");

    $industries_arr = explode(",", $industries_ids);
    $industries_size = count($industries_arr);
    $complete_industries = "|";
    for($ind=0;$ind<$industries_size;$ind++)
    {

        $ind_title = get_industry_title($industries_arr[$ind]);
        if($complete_industries == "|")
            $complete_industries .= "IND:";
        $complete_industries .= substr($ind_title,0,4).",";
    }
}
//echo "<br>complete_industries: ".$complete_industries;

if(isset($_GET['states']) && $_GET['states'] != '')
{
    $states_para = $_GET['states'];
    $pg_int_parameters .= "&states=".$states_para;
    $state_ids = trim($states_para,",");

    $states_arr = explode(",", $state_ids);
    //echo "<pre>states_arr: ";   print_r($states_arr);   echo "</pre>";
    $states_size = count($states_arr);
    $complete_states = "|";
    for($st=0;$st<$states_size;$st++)
    {

        $state_title = get_state_title($states_arr[$st]);    
        if($complete_states == '|')
            $complete_states .= "STA:";
        $complete_states .= $state_title.",";
    }
    $complete_states = trim($complete_states,",");
}

$revenue_limits = "";
if(isset($_GET['revenue']) && $_GET['revenue'] != '')
{
    $revenue = $_GET['revenue'];
    $pg_int_parameters .= "&revenue=".$revenue;

    $revenue_limits = get_revenue_limits($revenue);
}

$employee_size_limits = "";
if(isset($_GET['employee_size']) && $_GET['employee_size'] != '')
{
    $employee_size = $_GET['employee_size'];
    $pg_int_parameters .= "&employee_size=".$employee_size;

    $employee_size_limits = get_employee_size_limits($employee_size);
}

include("left.php"); 

if(isset($_GET['type']) && $_GET['type'] != '')
{    
    $type = trim($_GET['type']);
    $pg_int_parameters .= "&type=".$type;
}    
else
{    
    $type = "all";
}

if(isset($_GET['func']) && $_GET['func'] != '')
{    
    $func = $_GET['func'];
    $pg_int_parameters .= "&func=".$func;

    if($func == 'it')
        $personal_pic_root = "https://www.ctosonthemove.com/";

    if($func == 'cfo')
        $personal_pic_root = "https://www.cfosonthemove.com/";

    if($func == 'cmo')
        $personal_pic_root = "https://www.cmosonthemove.com/";

    if($func == 'clo')
        $personal_pic_root = "https://www.closonthemove.com/";
}    
else
{    
    $func = "";
    $personal_pic_root = "https://www.hrexecsonthemove.com/";
}    
$company_pic_root = "https://www.ctosonthemove.com/";

//echo "<br>pg_int_parameters: ".$pg_int_parameters;
//$all_data = get_all_data('',"$type");

//echo "<br>SErver: ".$_SERVER['REQUEST_URI']; die();
$home_pos = strpos($_SERVER['REQUEST_URI'],"home.php");
//echo "<br>home_pos: ".$home_pos; 
$filtered_count = '';
if($home_pos > 0)
{    
    //echo "    within";
    //echo "<br>state_ids: ".$state_ids;
    $all_data = get_all_data('',"$type",$func,$from_date,$to_date,$zip,$searchnow,$city,$companyval,$industries_ids,$state_ids,$revenue,$employee_size);
    $all_data_count = count($all_data);
    if($filtered_count != '')
        $all_data_count = $filtered_count;
}
//die();
//echo "<br>all_data_count: ".$all_data_count;

$form_hidden_values = $type.":".$func.":".$from_date.":".$to_date.":".$zip.":".$searchnow.":".$city.":".$companyval.":".$industries_ids.":".$state_ids.":".":".$revenue.":".":".$employee_size;

//echo "REQUEST_URI: ".$_SERVER['REQUEST_URI'];
$details_pos = strpos($_SERVER['REQUEST_URI'],'details.php');
$details_html_pos = strpos($_SERVER['REQUEST_URI'],'details_');
$hide_header = 0; 
if($details_pos > -1 || $details_html_pos > -1)
{
    $hide_header = 1;
    ?>
    <script language="javascript">
        //$(".header").hide();
        $(".sidebar").hide();  
        //alert("here");
        $(".content").css("padding-top", "10px");
    </script>    
    <?PHP
}    
?>
    
<div class="wrapper">
    <?PHP
    if($hide_header == 0)
    {    
    ?>
    <header class="header">
        <a href="#" class="btn-menu">
            <span></span>
        </a>
        <a href="index.php" class="logo">Execfile</a>
        <a href="index.php" class="logo-mobile hidden-ds">Execfile</a>
            <div class="header-inner">
                <a href="#" title="Mark All As Read" class="check-btn" onclick="javascript:markRead('<?=$current_user_id?>');">
                    <i class="ico-check"></i>
                    <span class="hidden-ds">Mark All As Read"</span>
                </a>

                <nav class="nav-utilities">

                    <ul>
                        <li class="download-holder">
                            
                            <form name="frmResultDownload" method="post" action="download-result.php">
                                <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                            </form>    
                            
                            <?PHP
                            if($all_data_count > 500)
                            {
                                $dl_text = "use filters to select 500 records or less for download";
                                ?>
                                <a href="#" title="<?=$dl_text?>" class="download"> 
                                <?PHP
                            } 
                            else
                            {
                                $dl_text = "download";
                                ?>
                                <a href="#" title="Download" class="download" onclick="javascript:ResultDownload();"> 
                                <?PHP
                            }    
                            ?>
                            
                            
                            
                                <span>
                                    <i class="ico-download"></i>
                                </span>
                                 <!--
                                <span>
                                    <form name="frmResultDownload" method="post" action="download-result.php">
                                        <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                                        <a href="javascript:ResultDownload();"><i class="ico-download"></i></a>
                                    </form>
                                </span>
                                 -->
                                <strong class="hidden-ds">
                                    <?=$dl_text?>
                                </strong>
                             </a> 
                        </li>

                        <li  class="alert-holder">
                            <a href="alert.php" title="Create Alert" class="alert-notice">
                                <span>
                                    <i class="ico-bell"></i>
                                </span>
                                <strong class="hidden-ds">Create Alert</strong>
                            </a>	
                        </li>

                        <li class="hasdropdown">
                            <a href="#">
                                <i class="ico-cog"></i>
                            </a>

                            <div class="dropdown">
                                <ul>
                                    <li><a id="accounts_link" href="accounts.php">Account</a></li>
                                    <li><a id="settings_link" href="settings.php">Settings</a></li>
                                    <li id="logout_li"><a id="logout_link" href="index.php?action=logout">Logout</a></li>
                                </ul>
                            </div><!-- /.dropdown -->
                        </li>
                    </ul>
                </nav><!-- /.nav-utilities -->
            </div><!-- /.header-inner -->
    </header><!-- /.header -->
    
    <?PHP
    }
 else {
    ?>
    <h1 style="margin:0px auto; width:990px;margin-top:55px;"><a href="index.php"><img style="margin-left:55px;" width="257" height="24" src="css/images/new-logo.png"></a></h1>
    <?PHP
    }
    ?>