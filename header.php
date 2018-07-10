<!DOCTYPE html>
<html lang="en">
    <head>
<?PHP
//$root_path = "http://45.55.139.16/ver2/";
$root_path = "https://www.execfile.com/ver2/";
$time1 = microtime(true);
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
      source: "get_searchnow_data.php",
      
      select: function( event, ui ) { 
          //alert(ui.item.value);
            //alert(ui.item.value);
            var rec_val = ui.item.value;
            var first_five = rec_val.substring(0, 5);
            
            var personal_pic_root = $("#personal_pic_root").val();
            
            //alert("First_five: "+first_five);
            if(first_five == 'pers_')
            {    
                event.preventDefault();
                
                var rec_lbl = ui.item.label;
                $("#developer").val(rec_lbl);   
                rec_lbl = rec_lbl.replace(" ", "_");
                //$("#text").val ("foo");
                //alert("Rec_lbl: "+rec_lbl);
                //window.location.href = "http://www.hrexecsonthemove.com/"+rec_lbl+"_Exec_"+rec_val;
                //var p_link = "http://www.hrexecsonthemove.com/"+rec_lbl+"_Exec_"+rec_val;
                var p_link = personal_pic_root+rec_lbl+"_Exec_"+rec_val;
                window.open(p_link,'_blank');
                
            }
            else
            {
                window.location.href = "http://www.execfile.com/home.php?funtion=hr&searchnow="+rec_val;
            }    
            //$("#developer").val(ui.item.label);
        }
         
      //source: "autop/get_searchnow_data.php"
      //source: "autop/demo_cities.php"
    });
  });


$(function() {
    
    $( "#city" ).autocomplete({
      //source: availableTags
      source: "get_cities_data.php",
      
      select: function(value, data){
          if (typeof data == "undefined") {
                      //emitMessage('You selected: ' + value + "<br/>");
                      console.log("IF VAL: "+value);
          } else {
              //emitMessage('You selected: ' + data.item.value + "<br/>");
              console.log("ELSE VAL: "+data.item.value);
              
            var this_city = data.item.value;  
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
            
            var mweb = $('#mweb').val();
            //alert("MWEB:"+mweb);
            window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+this_city+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;  
              
          }
        }
      
      
      
      
    });
  });
  
  
  
/*  
$(function() {
    
    $( "#city" ).autocomplete({
      //source: availableTags
      source: "get_cities_data.php",
      select: function(value, data){
          alert(value);
        }
      }
    });
  });  
*/  


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
            var mweb = $('#mweb').val();
            //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&industries="+hidden_industries+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size;
            window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&industries="+hidden_industries+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size+"&mweb"+mweb;
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
            
            var mweb = $('#mweb').val();
            
            var org = '';
            if(type == 'all' || type == 'All')
                org = "&org=0";
            
            //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&searchnow="+searchnow+"&industries="+hidden_industires+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size;
            //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&searchnow="+searchnow+"&industries="+hidden_industires+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size+"&org=1";
           
            window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&searchnow="+searchnow+"&industries="+hidden_industires+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size+org;
        }    
    }    
}


function companyKeyPress(e)
{
    e = e || window.event;
    if (e.keyCode == 13)
    { 
        var searchnow = $('#field-company-name').val();
        searchnow = searchnow.replace("&", "##");
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
            var mweb = $('#mweb').val();
            
            if(from_date == '' && to_date == '' && type == 'all' && zip_val == '' && city_val == '' && industries == '' && hidden_states == '' && hidden_revenue == '' && hidden_employee_size == '')
            {
                //window.location.href = "http://www.execfile.com/home.php?function=hr&company="+searchnow+"&org=1";
                window.location.href = "http://www.execfile.com/home.php?function=hr&company="+searchnow+"";
            }    
            else
            {
                //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&companyval="+searchnow+"&states="+hidden_states+"&industries="+industries+"&city="+city_val+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
                window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&companyval="+searchnow+"&states="+hidden_states+"&industries="+industries+"&city="+city_val+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;
            }    
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
            
            var mweb = $('#mweb').val();
            
            //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
            window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;
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
    var companyval = "";
    if ($("#field-company-name").val() != '')
    {
        companyval = $("#field-company-name").val();
    }

    var city_val = $('#city').val();
    var hidden_revenue = $("#hidden_revenue").val();
    var hidden_employee_size = $("#hidden_employee_size").val();
    var mweb = $('#mweb').val();
    // window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&companyval="+companyval+"&mweb="+mweb;
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
    var mweb = $('#mweb').val();
    //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
    window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;
        
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
    //alert("last_speaking_id ID: "+last_speaking_id); 
    $.ajax({
    method: "POST",
    url: "updateCount.php",
    data: { last_move_id: last_move_id,last_speaking_id: last_speaking_id,last_media_id: last_media_id,last_publication_id: last_publication_id,last_award_id: last_award_id,last_funding_id: last_funding_id,last_job_id: last_job_id }
    
    //alert("URL+DATA: "+url+data);    
        
    })
    .done(function( msg ) 
    {
        //alert("URL+DATA: "+data); 
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
        $(".article .list-checkboxes").hide();
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

//define("EXECFILE_ROOT","http://45.55.139.16/");
define("EXECFILE_ROOT","http://www.execfile.com");

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


//echo "<pre>SESSION Before: ";   print_r($_SESSION);   echo "</pre>";
// Code for combined site users - June 2018
if($_SESSION['combine_site'] == 'cto/ciso')
{    
    if(isset($_GET['func']) && $_GET['func'] == 'ciso')
    {
        $_SESSION['site'] = 'ciso';
    }
    elseif(isset($_GET['func']) && $_GET['func'] == 'cto')
    {
        $_SESSION['site'] = 'cto';
    }
}


$func = $_SESSION['site'];

//echo "<pre>SESSION Atfer: ";   print_r($_SESSION);   echo "</pre>";



if(isset($_GET['rem']) && $_GET['rem'] != '')
{
    $types_arr = array("movements","Speaking","Media Mentions","Publication","Industry Awards","Funding","Jobs");

    
    if($_GET['rem'] == 'Saved List')
    {
        $_GET['industries'] = '';
        $_GET['states'] = '';
        $_GET['type'] = 'all';
        $_GET['to_date'] = "";
        $_GET['from_date'] = "";
        $_GET['zip'] = '';
        $_GET['city'] = '';
        $_GET['employee_size'] = '';
        $_GET['searchnow'] = '';
        $_GET['companyval'] = '';
        $_GET['revenue'] = '';
        $_GET['list'] = '';
        $_GET['mweb'] = '';
    }    
    
    
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

$only_company = 0;

if(isset($_GET['from_date']) && $_GET['from_date'] != '')
{
    $from_date_initial = $_GET['from_date'];
    $from_year = substr($from_date_initial,6,4);
    $from_month = substr($from_date_initial,0,2);
    $from_day = substr($from_date_initial,3,2);
    $from_date = $from_year."-".$from_month."-".$from_day;
    $pg_int_parameters .= "&from_date=".$from_date_initial;
    
    $only_company = 0;
    
}
if(isset($_GET['to_date']) && $_GET['to_date'] != '')
{
    $to_date_initial = $_GET['to_date'];
    $to_year = substr($to_date_initial,6,4);
    $to_month = substr($to_date_initial,0,2);
    $to_day = substr($to_date_initial,3,2);
    $to_date = $to_year."-".$to_month."-".$to_day;
    $pg_int_parameters .= "&to_date=".$to_date_initial;
    
    $only_company = 0;
}

//echo "<br>only_company ONE: ".$only_company;
if(isset($_GET['zip']) && $_GET['zip'] != '')
{
    $zip = $_GET['zip'];
    $pg_int_parameters .= "&zip=".$zip;
    
    $only_company = 0;
}

if(isset($_GET['searchnow']) && $_GET['searchnow'] != '')
{
    $searchnow = $_GET['searchnow'];
    $pg_int_parameters .= "&searchnow=".$searchnow;
    
    $only_company = 1;
}
//echo "<br>only_company ONE ONE: ".$only_company;
//echo "<br>companyval: ".$_GET['companyval'];
$_GET['companyval'] = str_replace("##","&",$_GET['companyval']);
//echo "<br>companyval: ".$_GET['companyval'];
if(isset($_GET['companyval']) && $_GET['companyval'] != '')
{
    $companyval = $_GET['companyval'];
    $pg_int_parameters .= "&companyval=".$companyval;
}
//echo "<br>only_company ONE TWO: ".$only_company;
if(isset($_GET['company']) && $_GET['company'] != '')
{
    $companyval = $_GET['company'];
    $pg_int_parameters .= "&company=".$companyval;
}

if(isset($_GET['city']) && $_GET['city'] != '')
{
    $city = $_GET['city'];
    $pg_int_parameters .= "&city=".$city;
    
    $only_company = 0;
}
//echo "<br>only_company TWO: ".$only_company;
if(isset($_GET['industries']) && $_GET['industries'] != '')
{
    
    $industries = trim($_GET['industries'],",");
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
    
    $only_company = 0;
}
//echo "<br>complete_industries: ".$complete_industries;

if(isset($_GET['states']) && $_GET['states'] != '')
{
    $states_para = trim($_GET['states'],",");
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
    
    $only_company = 0;
}

$revenue_limits = "";
if(isset($_GET['revenue']) && $_GET['revenue'] != '')
{
    //echo "<br>GET revenue: ".$_GET['revenue'];
    $revenue = trim($_GET['revenue'],",");
    //echo "<br>revenue: ".$revenue;
    $pg_int_parameters .= "&revenue=".$revenue;

    $revenue_limits = get_revenue_limits($revenue);
    //echo "<br>revenue_limits: ".$revenue_limits;
    $only_company = 0;
}

$employee_size_limits = "";
if(isset($_GET['employee_size']) && $_GET['employee_size'] != '')
{
    $employee_size = trim($_GET['employee_size'],",");
    $pg_int_parameters .= "&employee_size=".$employee_size;

    $employee_size_limits = get_employee_size_limits($employee_size);
    
    $only_company = 0;
}

if(isset($_GET['companyval']) && $_GET['companyval'] != '')
{
    $only_company = 1;
    
}

if(isset($_GET['company']) && $_GET['company'] != '')
{
    $only_company = 1;
    // added on 23 may 2018
    if($_GET['companyval'] == '' && $_GET['company'] != '')
        $_GET['companyval'] = $_GET['company'];
    
}
include("left.php"); 
//echo "<br>only_company THREE: ".$only_company;
if(isset($_GET['type']) && $_GET['type'] != '' && $_GET['type'] != 'all')
{    
    $type = trim($_GET['type']);
    $pg_int_parameters .= "&type=".$type;
    $only_company = 0;
}    
else
{    
    $type = "all";
}

if(isset($_GET['list']) && $_GET['list'] != '')
{
    $pg_int_parameters .= "&list=".$_GET['list'];
    
}


//if(isset($_GET['func']) && $_GET['func'] != '')
if(isset($_SESSION['site']) && $_SESSION['site'] != '')
{    
    $func = $_SESSION['site'];
    //echo "<br>func: ".$func;
    $pg_int_parameters .= "&func=".$func;

    if($func == 'cto' || $func == 'ciso')
        $personal_pic_root = "https://www.ctosonthemove.com/";

    if($func == 'cfo')
        $personal_pic_root = "https://www.cfosonthemove.com/";

    if($func == 'cmo' || $func == 'cso')
        $personal_pic_root = "https://www.cmosonthemove.com/";

    if($func == 'clo')
        $personal_pic_root = "https://www.closonthemove.com/";
    if($func == 'hr')
        $personal_pic_root = "https://www.hrexecsonthemove.com/";
}    
else
{    
    $func = "";
    $personal_pic_root = "https://www.hrexecsonthemove.com/";
}    
$company_pic_root = "https://www.ctosonthemove.com/";

//echo "<br>personal_pic_root TWO: ".$personal_pic_root;

if ($_SESSION['sess_user_id'] !='' and $_SESSION['sess_user_id'] > 0 )
{
    $log_history_update = "update ".TABLE_LOGIN_HISTORY." set last_respond_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$_SESSION['sess_user_id']."'";
    //echo "<br>log_history_update: ".$log_history_update;
    mysql_query($log_history_update);
}

//echo "<br>only_company: ".$only_company;


$home_pos = strpos($_SERVER['REQUEST_URI'],"home.php");
$filtered_count = '';
if($home_pos > 0)
{    
    if($_GET['mweb'] != '')
    {
        $pg_int_parameters .= "&mweb=".$_GET['mweb'];
        $filter_websites_q = mysql_query("select websites_filter from user_saved_lists where l_id='".$_GET['mweb']."'");
        $filter_row = mysql_fetch_array($filter_websites_q);
        $filter_websites = $filter_row['websites_filter'];
        $companyval = $filter_websites;
        //echo "<pre>"; print_r (explode("\n",$filter_websites));   echo "</pre>";
        
       
    }    
    //echo "<br>filter_websites: ".$filter_websites;
    //echo "<br>Func: ".$func;
    //echo "<br>revenue: ".$revenue;
    //echo "<br>Filtered count First: ".$filtered_count;
    $all_data = get_all_data('',"$type",$func,$from_date,$to_date,$zip,$searchnow,$city,$companyval,$industries_ids,$state_ids,$revenue,$employee_size);
    
    $all_data_count = count($all_data);
    //echo "<br>all_data_count ONE: ".$all_data_count;
    //echo "<br>TYPE:".$type.":";
    if(($type == 'all' || $type == '') && $revenue == '' && $employee_size == '' && $industries == '' && $states_para == '' && $city == '' && $zip == '' && $from_date_initial == '' && $to_date_initial == '' && $_GET['companyval'] == '' && $_GET['searchnow'] == '')
    {
        //echo "<br>FAR In if";
        $all_data_count = $all_data_count;
        //echo "<br>all_data_count: ".$all_data_count;
        
        if($_SESSION['site'] == 'hr') // This block added when user unselect single selected filter and then it shd show hardcoded count
            $all_data_count = '89926'; //'65543';
    }    
    else
    {   
        //echo "<br>FAR In else: ".$filtered_count;
        if($filtered_count != '' && $filtered_count != 0)
        {
            //echo "<br>in else if";
            $all_data_count = $filtered_count;
        }    
    }
}
//echo "<br>all_data_count TWO: ".$all_data_count;
//echo "<br>Session site: ".$_SESSION['site'];
//echo "<br>GET: ".$_GET['def_l'];
//echo "<br>HTTP_REFERER: ".$_SERVER['HTTP_REFERER'];
// alert.php , account.php , settings.php
// This is also done in home file,but i need to do it here also to make user unable to download when user comes to search first time from login
//if(strpos($_SERVER['HTTP_REFERER'],'login.php') > -1 || strpos($_SERVER['HTTP_REFERER'],'accounts.php') > -1 || strpos($_SERVER['HTTP_REFERER'],'settings.php') > -1 || strpos($_SERVER['HTTP_REFERER'],'alert.php') > -1)
if((strpos($_SERVER['HTTP_REFERER'],'login.php') > -1 || strpos($_SERVER['HTTP_REFERER'],'accounts.php') > -1 || strpos($_SERVER['HTTP_REFERER'],'alert.php') > -1) && $_GET['def_l'] != '1')        
{   //echo "<br>within if";    
    $all_data_count = '89926'; //'65543'; 
    
    
}    
//echo "<br>All data count: ".$all_data_count;
//die();

//
//$form_hidden_values = $type.":".$func.":".$from_date.":".$to_date.":".$zip.":".$searchnow.":".$city.":".$companyval.":".$industries_ids.":".$state_ids.":".":".$revenue.":".":".$employee_size;
$form_hidden_values = $type.":".$func.":".$from_date.":".$to_date.":".$zip.":".$searchnow.":".$city.":".$companyval.":".$industries_ids.":".$state_ids.":".$revenue.":".$employee_size;
//echo "<br>form_hidden_values: ".$form_hidden_values;
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
<input type="hidden" name="personal_pic_root" id="personal_pic_root" value="<?=$personal_pic_root?>">    

<input type="hidden" name="employee_size_limits" id="employee_size_limits" value="<?=$employee_size_limits?>">    

<input type="hidden" name="revenue_limits" id="revenue_limits" value="<?=$revenue_limits?>">    



<div class="wrapper">
    <?PHP
    if($hide_header == 0)
    {    
    ?>
    <header class="header">
        <a href="#" class="btn-menu">
            <span></span>
        </a>
        <a href="home.php?funtion=hr" class="logo">Execfile</a>
        <a href="home.php?funtion=hr" class="logo-mobile hidden-ds">Execfile</a>
            <div class="header-inner">
                <a href="#" title="Mark All As Read" class="check-btn" onclick="javascript:markRead('<?=$current_user_id?>');">
                    <i class="ico-check"></i>
                    <span class="hidden-ds">Mark All As Read"</span>
                </a>

                <nav style="float:left;margin-left:365px;list-style:none;" class="nav-feedorg">
                <?PHP
                //echo "<br>only_company: ".$only_company;
                if($only_company == 1)
                {  
                    //$_GET['org'] = 1;
                    $feed_class = "";
                    $org_chart_class = "";
                    if($_GET['org'] == 1)
                        $org_chart_class = "class=blue";
                    else
                        $feed_class = "class=blue";
                ?>
                <li <?=$feed_class?> style="color:white;"><a href="home.php?from_date=&to_date=&type=all&zip=&companyval=<?=$_GET['company']?>&states=&industries=&city=&revenue=&employee_size=&searchnow=<?=$_GET['searchnow']?>">Feed</a></li>
                <li <?=$org_chart_class?> style="color:white;"><a href="home.php?funtion=hr&org=1&company=<?=$_GET['companyval']?>&searchnow=<?=$_GET['searchnow']?>">Org Chart</a></li>
                <?PHP
                }
                ?>
                </nav>
                
                
                <nav class="nav-utilities">

                    <ul>
                        
                        
                        <li class="download-holder">
                            
                            <form name="frmResultDownload" method="post" action="download-result.php">
                                <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                            </form>
                            
                            
                            
                            <form name="frmCreateAlert" method="post" action="alert.php">
                                <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                            </form>
                            
                            <?PHP
                            if($all_data_count > 1000)
                            {
                                $dl_text = "use filters to select 1000 records or less for download";
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
                            <!-- <a href="alert.php" title="Create Alert" class="alert-notice" > -->
                            <a href="#" title="Create Alert" class="alert-notice"  onclick="javascript:CreateAlert();">
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