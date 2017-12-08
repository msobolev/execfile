<!DOCTYPE html>
<html lang="en">
    <head>  
        <meta charset="utf-8" />
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExecFile</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/images/favicon.ico') }}" />
    <!-- Vendor Styles -->
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <!-- App Styles -->
        
        

<link rel="stylesheet" href="<?PHP echo asset('style.css'); ?>" type="text/css" >

<link rel="stylesheet" href="<?PHP echo asset('/js/vendor/jquery-ui-1.11.4.custom/jquery-ui.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('/js/vendor/DropKick-master/build/css/dropkick.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('/js/vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.css'); ?>" type="text/css" >



<script src="{{ asset('/js/vendor/jquery-1.11.3.min.js') }}"></script>
<script src="{{ asset('/js/vendor/jquery-ui-1.11.4.custom/jquery-ui.js') }}"></script>
<script src="{{ asset('/js/vendor/jquery-ui-1.11.4.custom/jquery.ui.touch-punch.min.js') }}"></script>
<script src="{{ asset('/js/vendor/DropKick-master/build/js/dropkick.min.js') }}"></script>
<script src="{{ asset('/js/vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('/js/vendor/jquery.query-object.js') }}"></script>


<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
{{-- <link rel="stylesheet" href="/resources/demos/style.css"> --}}

<script> 
    var $base_url = "{!! url('/') !!}";
    
    /*var $search_url = "{!! route('execf_search') !!}";*/
        //var $search_url = "{!! url('/search') !!}";

</script>

<script src="{{ asset('/js/functions.js') }}"></script>

 <script>
     

$(function() {
    $("#movement_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','movements');
    });
  });
     
     
$(function() {
    $("#speaking_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','speaking');
    });
  });   
  
  
  $(function() {
    $("#media_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','media');
    });
  });   
     
 
  $(function() {
    $("#publication_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','publication');
    });
  }); 
 
     
  $(function() {
    $("#award_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','awards');
    });
  }); 
  
  
  $(function() {
    $("#funding_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','funding');
    });
  }); 
  
  $(function() {
    $("#jobs_type").click(function(e) { 
      e.preventDefault(); // if desired...
      // other methods to call...
      var link = get_parameters('alert_type','jobs');
    });
  }); 
     
     
     
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
      source: "{!! url('get_searchnow_data') !!}",
      
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
                var p_link = personal_pic_root+rec_lbl+"_Exec_"+rec_val;
                //window.open(p_link,'_blank');
                
            }
            else
            {
                //window.location.href = "http://www.execfile.com/home.php?funtion=hr&searchnow="+rec_val;
            }    
            //$("#developer").val(ui.item.label);
        }
         
      //source: "autop/get_searchnow_data.php"
      //source: "autop/demo_cities.php"
    });
  });     
     
     
$(function() {
    $( "#field-company-name" ).autocomplete({
      //source: availableTags
      source: "{!! url('get_all_company_data') !!}"
    });
});
       
     
     
     
     
 $(function() {
    
    $( "#city" ).autocomplete({
      //source: availableTags
      source: "{!! url('get_cities_data') !!}",
      //source: "get_cities_data",
      //alert("in auto complete");
      select: function(value, data){
          if (typeof data == "undefined") {
                      //emitMessage('You selected: ' + value + "<br/>");
                      //console.log("IF VAL: "+value);
                      //alert("IF VAL: "+value);
          } else {
              //emitMessage('You selected: ' + data.item.value + "<br/>");
              //console.log("ELSE VAL: "+data.item.value);
              //alert("ELSE VAL: "+data.item.value);
              
            //alert("her");
          }
        }
    });
  });    
     
     
     
function CreateAlert()
{
    document.frmCreateAlert.submit();
}
     
     
     
function markRead(current_user_id)
{
    var last_move_id = $('#last_move_id').val();  
    var last_speaking_id = $('#last_speaking_id').val();
    //alert("Last Move ID: "+last_move_id );
    var last_media_id = $('#last_media_id').val();
    var last_publication_id = $('#last_publication_id').val();
    var last_award_id = $('#last_award_id').val();
    var last_funding_id = $('#last_funding_id').val();
    var last_job_id = $('#last_job_id').val(); 
    
    $.ajax({
    //method: "POST",
    url: "{!! url('updateCount') !!}",
    data: { last_move_id: last_move_id,last_speaking_id: last_speaking_id,last_media_id: last_media_id,last_publication_id: last_publication_id,last_award_id: last_award_id,last_funding_id: last_funding_id,last_job_id: last_job_id }
    //data: { last_move_id: last_move_id,last_speaking_id: last_speaking_id}
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
     

function getSalesForceLink(personal_id)
{
    //alert("PERSONAL ID: "+personal_id); return false;
    //$.ajax({url: "getuser.php?p_id="+personal_id, success: function(result)
    $.ajax({
        url: "{!! url('getuser') !!}",
        data: { personal_id: personal_id },
        success: function(result)
        { 
            //alert("Result: "+result);
            //console.log("SF LINK:"+result);
            window.location.href = result; //"http://stackoverflow.com";
        }
    });
}


     
     
function call_link(val)
{
    var link = get_parameters('org',val);
}
 
 
     
function ResultDownload()
{
    document.frmResultDownload.submit();
}    
     
     
 //update_search_type(sel_type)
 //{
 //   var link = get_parameters('alert_type',sel_type);
 //}
     
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
            
            var link = get_parameters('companyval',searchnow);
            
            /*
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
                window.location.href = "http://www.execfile.com/home.php?function=hr&company="+searchnow+"&org=1";
            }    
            else
            {
                //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&companyval="+searchnow+"&states="+hidden_states+"&industries="+industries+"&city="+city_val+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
                window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&companyval="+searchnow+"&states="+hidden_states+"&industries="+industries+"&city="+city_val+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;
            } 
            */    
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
            
            var link = get_parameters('searchnow',searchnow);
            
            /*
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
                org = "&org=1";
           
            window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&searchnow="+searchnow+"&industries="+hidden_industires+"&revenue="+hidden_revenue+"&states="+hidden_states+"&city="+city_val+"&employee_size="+hidden_employee_size+org;
            */
        }    
    }    
}
  
  
  
  
     
function update_search()
{ 
    
    
    var industries = '';
    $("input:checkbox[class=industry_chk]:checked").each(function () 
    {
    
        var selected_industry = $(this).attr("id");
        var industry_id = selected_industry.replace("field-", "");
        industries += industry_id+",";
    });      
    
    var link = get_parameters('ind',industries);
    
    
    /*
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
    //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&industries="+industries+"&states="+hidden_states+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&companyval="+companyval+"&mweb="+mweb;
    */
   //var test = '1';
    //window.location.href = "{{URL::to('search/movements/"+test+"')}}"
    //window.location.href = "http://www.execfile.com/execf/public/index.php/search/movements/"+industries;
    //window.location.href = "/search/movements/"+industries;  
    //console.log("LINK: "+link);
    
    //window.location.href = link;  
    //return;
}


function cityKeyPress(e)
{ 
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var city_val = $('#city').val();
        if(city_val != '')
        {
            var link = get_parameters('city',city_val);
            
            //window.location.href = "http://45.55.139.16/ver2/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size;
            //window.location.href = "http://www.execfile.com/home.php?from_date="+from_date+"&to_date="+to_date+"&type="+type+"&zip="+zip_val+"&city="+city_val+"&states="+hidden_states+"&industries="+industries+"&revenue="+hidden_revenue+"&employee_size="+hidden_employee_size+"&mweb="+mweb;
        }    
    }    
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
    //   alert("States: "+states); return false;
    var link = get_parameters('state',states);
    
    
    /*
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
    */    
}

function zipKeyPress(e)
{
    e = e || window.event;
    if (e.keyCode == 13)
    {
        var zip_val = $('#zip').val();
        if(zip_val != '')
        {    
            var link = get_parameters('zip',zip_val);
                
            /*    
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
            */
        }    
    }    
}


</script>




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


</head>
<body>

{{-- This is how to access variable HERE: {{ $all_data_count }} --}}
{{-- config('constants.personal_pic_root') --}}

<?PHP
//echo "<br>Complete: ".Request::fullUrl();
$this_page_url = Request::fullUrl();
$last_parameter = strrpos($this_page_url, "/");
$this_page_url = substr($this_page_url,0,$last_parameter);

//echo "<br>url link name: ".url('');
//echo "<br>public path: ".public_path();
$root_path = url('');
//echo "<br>App url: ".$pub_path;
//echo "<pre>TEST: ";   print_r($test);   echo "</pre>";   
?>

<!-- /left starts -->  
<div class="sidebar">
    <ul class="widgets">
        <li class="widget widget-search">
            <div class="widget-head">
                <span class="ico-widget">
                    <i class="ico-search"></i>
                </span>
                <h3 class="widget-title">Search</h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

            <?PHP
            $display_searchnow = '';
            if($searchnow != '' && $searchnow != '0')
                $display_searchnow = 'style=display:block;';
            
            ?>
            <div class="widget-body"  <?=$display_searchnow?> >
                <div class="search">
                    <div class="ui-widget form-search">
                        
                        <label for="developer" class="hidden">Search </label>
                        <input id="developer" placeholder="Select Now" class="search-field" value="<?=$searchnow?>" onkeypress="return searchKeyPress(event);">
                        <!-- </form>  -->
                    </div>
                </div><!-- /.search -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li class="widget widget-function">
            <div class="widget-head">
                <span class="ico-widget">
                    <i class="ico-function"></i>
                </span>

                <h3 class="widget-title">
                    Function
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

            <div class="widget-body">
                <nav class="widget-nav">
                    <ul>
                        <li>
                            <a href="{{ url('search') }}">
                                @if(Session::get('user_site') == 'hr')
                                    HR
                                @elseif(Session::get('user_site') == 'cto')    
                                    CTO
                                @elseif(Session::get('user_site') == 'cmo')    
                                    CMO
                                @elseif(Session::get('user_site') == 'clo')    
                                    CLO
                                @elseif(Session::get('user_site') == 'ciso')    
                                    CISO
                                @elseif(Session::get('user_site') == 'cso')    
                                    CSO    
                                @endif    
                            
                            </a>
                        </li>
                    
                    </ul>
                </nav><!-- /.widget-nav -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li class="widget widget-alerts">
            <div class="widget-head">
                    <span class="ico-widget">
                            <i class="ico-bell-white"></i>
                    </span>

                    <h3 class="widget-title">
                            Alert Type
                    </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

           
            <div class="widget-body">
                <ul class="list-alerts">
                    <li>
                        <a id="movement_type" href="#">Appointments<span id="movements_unread_count"></span></a>
                        
                    </li>
                    <li>
                        <a id="speaking_type" href="#">Speaking<span id="speaking_unread_count"></span></a> 
                    </li>
                    <li>
                        <a id="media_type" href="#">Media Mentions<span id="media_unread_count"></span></a>
                    </li>
                    <li>
                        <a id="publication_type" href="#">Publications<span id="publication_unread_count"></span></a>
                    </li>
                    <li>
                        <a id="award_type" href="#">Industry Awards<span id="award_unread_count"></span></a>
                    </li>
                    <li>
                        <a id="funding_type" href="#">Funding<span id="funding_unread_count"></span></a>
                        
                    </li>
                    <li>
                        <a id="jobs_type" href="#">Jobs<span id="job_unread_count"></span></a>
                    </li>
                    <!--
                    <li>
                        <a href="#">Conferences</a>
                    </li>
                    -->
                </ul><!-- /.list-alerts -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li id="timeframe_left" class="widget widget-calendar">
            <div id="date_tab"  class="widget-head">
                <span class="ico-widget">
                    <i class="ico-calendar"></i>
                </span>

                <h3 class="widget-title">
                    Timeframe
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->
            
            <?PHP
            $timeframe_display = "";
            if($from_date_initial != '' || $to_date_initial != '')
            {    
                $timeframe_display = 'style=display:block;';
            } 
            ?>
            
            
            <div  id="date_tab_body" class="widget-body" <?=$timeframe_display?>>
                <div class="calendar-holder">
                    <i class="ico-calendar-small"></i>
                    <label class="calendar-label "for="from" >From:</label>
                    <input type="text" id="from" name="from" value="<?=$from_date_raw?>">
                </div><!-- /.calendar-holder -->
                <div class="calendar-holder">
                    <i class="ico-calendar-small"></i>
                    <label class="calendar-label "for="to">To:</label>
                    <input type="text" id="to" name="to" value="<?=$to_date_raw?>">
                </div><!-- /.calendar-holder -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li class="widget widget-slider">
            <div id="company_tab"  class="widget-head">
                <span class="ico-widget">
                    <i class="ico-building"></i>
                </span>

                <h3 class="widget-title">
                    Company
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

            
            <?PHP
            /*echo "<br>companyval: ".$companyval;
            echo "<br>selected_industries: ".$selected_industries;
            echo "<br>selected_revenue: ".$selected_revenue;
            echo "<br>selected_employee_size: ".$selected_employee_size;
             */
            $company_display = "";
            if($companyval != '' || ($selected_industries != '' && $selected_industries != '0')  || ($selected_revenue != '' && $selected_revenue != '-1')  || ($selected_employee_size != '' && $selected_employee_size != '-1'))
            {    
                $company_display = 'style=display:block;';
            } 
            ?>
           
            
            <div  class="widget-body" <?=$company_display?>>
                <div class="form-company">
                    
                    <div class="form-body">
                        <div class="form-row">
                            <label for="field-company-name" class="form-label  hidden">Company Name/URL</label>
                            <div class="form-controls">
                                <input type="text" class="field" name="field-company-name" id="field-company-name" value="<?=$companyval?>" placeholder="Company Name/URL"  onkeypress="return companyKeyPress(event);">
                            </div><!-- /.form-controls -->
                        </div><!-- /.form-row -->

                        <div class="checkbox-holder">
                            <ul class="list-checkboxes">
                               
                                
                                
                                
                                
                                @foreach ($all_industries as $industry_id => $industry_data)
                                
                                    <?PHP
                                    $ind_checked = '';
                                    //echo "<br>selected_state: ".$selected_state;
                                    //echo "<pre>all_states:";   print_r($all_states);   echo "</pre>";
                                    $ind_arr = explode(",",$selected_industries);
                                    if(in_array($industry_id,$ind_arr))
                                    {        
                                        $ind_checked = "checked";
                                    }
                                    //echo "<br>state_checked: ".$state_checked;
                                    ?>
                                
                                
                                    @if($industry_data['parent_id'] == 0)
                                        <strong class="list-checkboxes-title"><?=$industry_data['title']?></strong><!-- /.list-checkboxes-title -->
                                    @endif
                                
                                    <li>
                                        <div class="checkbox">
                                            <input <?=$ind_checked?> type="checkbox" class="industry_chk" name="field-<?=$industry_id?>" id="field-<?=$industry_id?>" onclick="update_search()">
                                            <label class="form-label label-check" for="field-<?=$industry_id?>"><?=$industry_data['title']?></label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                @endforeach
                                
                                
                            </ul><!-- /.list-checkboxes -->	
                        </div><!-- /.checkbox-holder -->
                        
                        <?PHP 
                        //echo "<br>selected_revenue: ".$selected_revenue; 
                        //die();
                        if($selected_revenue != '' && $selected_revenue != '-1')
                        {
                            $revenue_arr = explode(",", $selected_revenue);
                            $set_vall = '4'; 
                        }    
                        else
                        {    
                            $set_vall = ''; 
                        }   
                        //echo "<pre>revenue_arr: ";   print_r($revenue_arr);   echo "</pre>"; die();

                        if($selected_employee_size != '' && $selected_employee_size != '-1')
                        {
                            $employee_size_arr = explode(",", $selected_employee_size);
                            $set_vall_emp = '4'; 
                        }    
                        else
                        {    
                            $set_vall_emp = ''; 
                        }   
                        ?>  
                        
                        <div class="sliders">
                            <div class="slider-holder">
                                <p>
                                    <label for="amount" class="slider-label">Revenue</label>
                                    <input type="text" id="amount" class="slider-input" value="0 - > $1 bil">
                                </p>
                                                 
                                <?PHP $set_val_slider = 1; ?>                            
                                <div id="slider-range_<?php echo $set_val_slider;?>" class="slider-range" data-truevalues="0, $1 mil, $10 mil, $50 mil, $100 mil, $250 mil, $500 mil, $1 bil, > $1 bil" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
                                <?php
                                    if(!empty($set_vall)){ 
                                        $saved_values = [intval($revenue_arr[0]),intval($revenue_arr[1])]; //$set_vall
                                        //$saved_values = [2,4]; //$set_vall    
                                        //$true_saved_values = [$100 mil,$500 mil];
                                    }else{
                                        $saved_values = [0, 8];
                                    }
                                ?>   
                                <script type="text/javascript">
                                    $slider_id = "slider-range_<?php echo $set_val_slider;?>";
                                    $slider_saved_values = "<?php echo json_encode($saved_values); ?>";
                                    
                                    //console.log($slider_saved_values);
                                    $('#'+ $slider_id).slider({
                                        orientation: 'horizontal',
                                        range: true,
                                        min: 0,
                                        max: 8,
                                        /*values: [2, 5],*/
                                        values: $.parseJSON($slider_saved_values)
                                    });
                                    //$('#slider-range_1').val('very');
                                </script>
  
                            </div><!-- /.slider-holder -->

                            <div class="slider-holder">
                                <p>
                                    <label for="amount2" class="slider-label">Employees</label>
                                    <input type="text" id="amount2" class="slider-input" value="1 - >100K">
                                </p>
                                <div id="slider-range-secondary_<?php echo $set_val_slider;?>" class="slider-range" data-truevalues="0, 25, 100, 250, 1k, 10k, 50k, 100k, > 100k" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
                                <!-- <div id="slider-range-secondary_<?php echo $set_val_slider;?>" class="slider-range" data-truevalues="0, 25, 100, 250, 1k, 10k, 50k, 100k, > 100k" data-values="1, 2, 3, 4, 5, 6, 7, 8, 8"></div> -->
                                <?php
                                    if(!empty($set_vall_emp)){ 
                                        $saved_values_emp = [intval($employee_size_arr[0]),intval($employee_size_arr[1])]; //$set_vall
                                        //$true_saved_values = [$100 mil,$500 mil];
                                    }else{
                                        $saved_values_emp = [0, 8];
                                    }
                                ?>   
                                <script type="text/javascript">
                                    $slider_id_emp = "slider-range-secondary_<?php echo $set_val_slider;?>";
                                    $slider_saved_values_emp = "<?php echo json_encode($saved_values_emp); ?>";
                                   
                                   
                                    //console.log($slider_saved_values);
                                    $('#'+ $slider_id_emp).slider({
                                        orientation: 'horizontal',
                                        range: true,
                                        min: 0,
                                        max: 8,
                                        /*values: [2, 5],*/
                                        values: $.parseJSON($slider_saved_values_emp)
                                    });
                                    //$('#slider-range_1').val('very');
                                </script>
  
                            
                            
                            
                            </div><!-- /.slider-holder -->
                        </div><!-- /.sliders -->
                    </div><!-- /.form-body -->
                    
                </div><!-- /.form-company -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li class="widget widget-location">
            <div class="widget-head">
                <span class="ico-widget">
                    <i class="ico-location"></i>
                </span>

                <h3 class="widget-title">
                    Location
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

           <?PHP
            //echo "<pre>GET: ";   print_r($_GET);   echo "</pre>";
            $location_display = "";
            $location_only_display = "";
            
            if(($selected_city != '' && $selected_city != '0') || ($selected_state != '' && $selected_state != '0') || ($selected_zip != '' && $selected_zip != '0'))
            {    
                $location_display = 'style=display:block;';
                $location_only_display = 'display:block;';
            } 
            ?>
            
            <div class="widget-body" <?=$location_display?>>
                <div class="form-location">
                    
                        <div class="form-body">
                            <div class="form-row">
                                <label for="city" class="form-label">City</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-city" id="city" value="{{ $selected_city }}" onkeypress="return cityKeyPress(event);">
                                </div><!-- /.form-controls -->
                            </div><!-- /.form-row -->
                            
                            
                            
                            <!-- state selectbox starts -->
                            <div class="widget-body" style="padding:17px 5px;<?=$location_only_display?>">
                                <div class="form-company">
                                    
                                    <div class="form-body">
                                        <div class="checkbox-holder">
                                            <ul class="list-checkboxes">
                                                <strong class="list-checkboxes-title">State</strong><!-- /.list-checkboxes-title -->
                                                
                                                
                                                @foreach ($all_states as $state_id => $short_name)
                                                
                                                
                                                <?PHP
                                                $state_checked = '';
                                                //echo "<br>selected_state: ".$selected_state;
                                                //echo "<pre>all_states:";   print_r($all_states);   echo "</pre>";
                                                $states_arr = explode(",",$selected_state);
                                                if(in_array($state_id,$states_arr))
                                                {        
                                                    $state_checked = "checked";
                                                }
                                                //echo "<br>state_checked: ".$state_checked;
                                                ?>
                                                
                                                <li>
                                                    <div class="checkbox">
                                                        <input <?=$state_checked?> type="checkbox" class="state_chk" name="state-<?=$state_id?>" id="state-<?=$state_id?>"  onclick="update_state_search()">
                                                        <label class="form-label label-check" for="state-<?=$state_id?>"><?=$short_name?></label>
                                                    </div>
                                                </li>
                                                @endforeach
                                            </ul><!-- /.list-checkboxes -->	


                                        </div><!-- /.checkbox-holder -->


                                    </div><!-- /.form-body -->
                                    <!-- </form> -->
                                </div><!-- /.form-company -->
                            </div><!-- /.widget-body -->   
                            <!-- state selectbox ends -->
     

                            <div class="form-row">
                                <label for="field-zip" class="form-label">ZIp</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-zip" id="zip" value="{{ $selected_zip }}"  onkeypress="return zipKeyPress(event);" >
                                </div><!-- /.form-controls -->
                            </div><!-- /.form-row -->
                        </div><!-- /.form-body -->
                    
                </div><!-- /.fomr-location -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->
    </ul><!-- /.widgets -->
</div><!-- /.sidebar -->
<!-- /left starts -->  



<?PHP
$user_site = Session::get('user_site');
$user_id = Session::get('user_id');
if($selected_industries == 0)
    $selected_industries_dl = '';
else
    $selected_industries_dl = trim($selected_industries,",");


if($selected_state == 0)
    $selected_state_dl = '';
else
    $selected_state_dl = trim($selected_state,",");


if($selected_revenue == -1)
    $selected_revenue_dl = '';
else
    $selected_revenue_dl = trim($selected_revenue,",");

if($selected_employee_size == -1)
    $selected_employee_size_dl = '';
else
    $selected_employee_size_dl = trim($selected_employee_size,",");


$form_hidden_values = $selected_type.":".$user_site.":".$from_date_initial.":".$to_date_initial.":".$selected_zip.":".$searchnow.":".$selected_city.":".$companyval.":".$selected_industries_dl.":".$selected_state_dl.":".$selected_revenue_dl.":".$selected_employee_size_dl;

//echo "<br>selected_city: ".$selected_city;
//echo "<br>form_hidden_values: ".$form_hidden_values;

//$form_hidden_values = 'speaking'.":".'hr';
?>




<!-- /header starts -->  

<div class="wrapper">
    
    <header class="header">
        <a href="#" class="btn-menu"><span></span></a>
        <a href="{{ url('search') }}" class="logo">Execfile</a>
        <a href="" class="logo-mobile hidden-ds">Execfile</a>
        <div class="header-inner">  
            
            <a href="#" title="Mark All As Read" class="check-btn" onclick="javascript:markRead('<?=$user_id?>');">
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
                    
                    if($org == 1)
                        $org_chart_class = "class=blue";
                    else
                        $feed_class = "class=blue";
                ?>
                <li <?=$feed_class?> style="color:white;"><a onclick="call_link('0')" href="javascript:void(0)">Feed</a></li>
                <li <?=$org_chart_class?> style="color:white;"><a onclick="call_link('1')" href="javascript:void(0)">Org Chart</a></li>
                
                <?PHP
                }    
                ?>
                
            </nav>
            
            <nav class="nav-utilities">
                <ul>
                    <li class="download-holder">
                        <form name="frmResultDownload" method="post" action="http://www.execfile.com/download-result.php">
                            <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                        </form>
                        
                        {{-- <form name="frmCreateAlert" method="post" action="alerts"> --}}
                        {!! Form::open(['url' => 'alerts','name'=>'frmCreateAlert'])   !!}
                            {{ csrf_field() }} 
                            <input type="hidden" name="selected_filters_hidden" value="<?=$form_hidden_values?>">
                        </form>
                        
                        
                        <?PHP
                        if($total_data > 1000)
                        {    
                        ?>
                        <a href="#" title="<?=$dl_text?>" class="download"> 
                        <?PHP
                        }
                        else
                        {    
                        ?>
                        <a href="#" title="Download" class="download" onclick="javascript:ResultDownload();">    
                        <?PHP
                        }
                        ?>
                        <span>
                            <i class="ico-download"></i>
                        </span>    
                        <strong class="hidden-ds">
                                $dl_text
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
                                    <li><a id="accounts_link" href="{{ url('accounts') }}">Account</a></li>
                                    <li><a id="settings_link" href="{{ url('settings') }}">Settings</a></li>
                                    <li id="logout_li"><a id="logout_link" href="{{ url('logout') }}">Logout</a></li>
                                </ul>
                            </div><!-- /.dropdown -->
                        </li>
                    </ul>
                </nav><!-- /.nav-utilities -->        
            
            
        </div>    
    </header>
</div>    
             


<!-- /header ends -->  
<?PHP
//echo "<br>Base apath: ".base_path();

$all_data_count = count($all_data);
//echo "<br>all_data_count: ".$all_data_count;
//$last_move_index = $last_move_index-1;
//echo "<br>last_move_index in view:".$last_move_index;
//echo "<pre>all data";   print_r($all_data);   echo "</pre>"; die();
?>


<div class="main">
    <input type="hidden" name="hidden_industires" id="hidden_industires" value="<?=$selected_industries?>">
    
    <input type="hidden" name="hidden_states" id="hidden_states" value="">
    <input type="hidden" name="hidden_employee_size" id="hidden_employee_size" value="<?=$selected_employee_size?>">
    <input type="hidden" name="hidden_revenue" id="hidden_revenue" value="<?=$selected_revenue?>">
    <input type="hidden" name="hidden_zip" id="hidden_zip" value="">
    <input type="hidden" name="hidden_state" id="hidden_state" value="<?=$selected_state?>">
    <input type="hidden" name="hidden_city" id="hidden_city" value="">
        
    <input type="hidden" name="type" id="type" value="<?=$selected_type?>">
    <input type="hidden" name="root_path" id="root_path" value="<?=$root_path?>">
    
    <input type="hidden" name="employee_size_limits" id="employee_size_limits" value="<?=$employee_size_limits?>">    
    <input type="hidden" name="revenue_limits" id="revenue_limits" value="<?=$revenue_limits?>">    
    
    
    <div class="content" style="padding-left:323px;">
        
        @if($only_company == 1 && $org == 1)    
        
        
            <div style="padding-bottom:500px;" class="tree well">
                
                
                <?PHP
                // Todo - need to set pic root on basis of user site in session
                $pic_root            = "https://www.hrexecsonthemove.com/";
                $hr_root_link = "https://www.hrexecsonthemove.com/";    
                $previousLevel = '';
                
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
                        {    
                            //$per_img = "no-personal-image.png";
                            $per_img = asset('/images/no-personal-image.png');
                        }    
                        else
                        {    
                            //$per_img = "https://www.hrexecsonthemove.com/personal_photo/thumb/".$chart_data['personal_image'];
                            $per_img = $personal_pic_root."personal_photo/thumb/".$chart_data['personal_image'];
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
                            <a href="<?=$personal_pic_root?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?> at <?=$chart_data['company_name']?>
                        
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
                                <a href="<?=$personal_pic_root?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
                            
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
                                <a href="<?=$personal_pic_root?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
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
                                
                                <a href="<?=$personal_pic_root?><?=$hr_link?>"><?=$chart_data['first_name']?> <?=$chart_data['last_name']?></a> is <?=$p_title?>
                            
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

        @else
        <section class="section-primary">
            <header class="section-head" style="min-width:900px;left:333px;">
                <form class="form-tags">
                    <p>
                        <label class="form-label hidden">Tags</label>
                        <input id="tags_1" type="text" class="tags" value="<?=$filters?>" />
                    </p>
                </form>

                <p class="records"><? //=$all_data_count?><?=$total_data?> records</p>
            </header><!-- /.section-head -->

            <div class="section-body">
                <ul class="articles">

                <?PHP
                //echo "<pre>all data";   print_r($all_data);   echo "</pre>"; die();

                $TWITTER_SHARE_ROOT = "https://twitter.com/share?";
                $share_text = '';
                $LINKEDIN_SHARE_ROOT = 'https://www.linkedin.com/shareArticle?';

                // TODO THIS SHD B BASED ON SITE URL
                $profile_root_link = "https://www.hrexecsonthemove.com/";

                $unread_movements_count = 0; 
                $unread_speaking_count = 0;
                $unread_media_count = 0;
                $unread_award_count = 0;
                $unread_publication_count = 0;
                $unread_funding_count = 0;
                $unread_job_count = 0;


                $max_move_id = 0; // Getting max move id to update count when all read is clicked
                $max_speaking_id = 0; // Getting max move id to update count when all read is clicked
                $max_media_id = 0;
                $max_award_id = 0;
                $max_pub_id = 0;
                $max_funding_id = 0;
                $max_job_id = 0;
                ?>

                    @if($all_data_count > 0)    
                        @for ($k = 0; $k < $all_data_count; $k++)
                            @if($all_data[$k]['type'] == 'movement')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_movements_count++; ?>
                                @endif     


                                @if($all_data[$k]['id'] > $max_move_id)
                                    <?PHP $max_move_id = $all_data[$k]['id']; ?>
                                @endif

                            @endif   


                            @if($all_data[$k]['type'] == 'speaking')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_speaking_count++; ?>
                                @endif  
                                
                                
                                @if($all_data[$k]['id'] > $max_speaking_id)
                                    <?PHP $max_speaking_id = $all_data[$k]['id']; ?>
                                @endif
                                
                            @endif   


                            @if($all_data[$k]['type'] == 'media_mention')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_media_count++; ?>
                                @endif
                                
                                @if($all_data[$k]['id'] > $max_media_id)
                                    <?PHP $max_media_id = $all_data[$k]['id']; ?>
                                @endif
                            @endif   



                            @if($all_data[$k]['type'] == 'awards')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_award_count++; ?>
                                @endif    
                                
                                @if($all_data[$k]['id'] > $max_award_id)
                                    <?PHP $max_award_id = $all_data[$k]['id']; ?>
                                @endif
                            @endif  

                            @if($all_data[$k]['type'] == 'publication')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_publication_count++; ?>
                                @endif     
                                
                                @if($all_data[$k]['id'] > $max_pub_id)
                                    <?PHP $max_pub_id = $all_data[$k]['id']; ?>
                                @endif
                            @endif  


                            @if($all_data[$k]['type'] == 'funding')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_funding_count++; ?>
                                @endif     
                                
                                @if($all_data[$k]['id'] > $max_funding_id)
                                    <?PHP $max_funding_id = $all_data[$k]['id']; ?>
                                @endif
                            @endif

                            @if($all_data[$k]['type'] == 'jobs')

                                @if($all_data[$k]['show_state'] == 'unread')
                                    <?PHP $unread_job_count++; ?>
                                @endif     
                                
                                @if($all_data[$k]['id'] > $max_job_id)
                                    <?PHP $max_job_id = $all_data[$k]['id']; ?>
                                @endif
                            @endif
                        @endfor 
                        
                        <?PHP
                        //echo "<br>unread_speaking_count ONE:".$unread_speaking_count;
                        //echo "<pre>jobs: ";   print_r($all_data); echo "</pre>";
                        
                        
                        //$tt = "Chief People Officer at Wendy`s";
                        //echo "<br>htmlentities:".htmlentities($tt, ENT_QUOTES);
                        //echo "<br>urlencode:".urlencode($tt);
                        ?>
                        
                        {{ Form::hidden('last_move_id', $max_move_id,array('id'=>'last_move_id')) }}
                        {{ Form::hidden('last_speaking_id', $max_speaking_id,array('id'=>'last_speaking_id')) }}
                        {{ Form::hidden('last_media_id', $max_media_id,array('id'=>'last_media_id')) }}
                        {{ Form::hidden('last_award_id', $max_award_id,array('id'=>'last_award_id')) }}
                        {{ Form::hidden('last_publication_id', $max_pub_id,array('id'=>'last_publication_id')) }}
                        {{ Form::hidden('last_funding_id', $max_funding_id,array('id'=>'last_funding_id')) }}
                        {{ Form::hidden('last_job_id', $max_job_id,array('id'=>'last_job_id')) }}
                        
                        @for ($i = $starting_point; $i < $ending_point; $i++)
                            @if(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'movement')
                            <li class="article">


                                @if($all_data[$i]['show_state'] == 'unread')

                                <ul class="list-checkboxes">
                                    <li>
                                        <div class="checkbox">
                                            <input type="checkbox" name="field-1#" id="field-1#">
                                            <label class="form-label" for="field-1#">1#</label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                </ul><!-- /.list-checkboxes -->
                                @endif    
                                <span class="ico-article">
                                    <i class="ico-arrow-up-blue"></i>
                                </span>

                                <div class="article-image">
                                <?PHP

                                $movement_text = "";
                                if($all_data[$i]['movement_type'] == 1)
                                    $movement_text = " Appointed ";
                                elseif($all_data[$i]['movement_type'] == 2)
                                    $movement_text = " Promoted";

                                $share_text = "";
                                $share_text = "Congrats ".trim($all_data[$i]['first_name'])." ". trim($all_data[$i]['last_name'])." on ".$movement_text." as ".$all_data[$i]['title']." at ".$all_data[$i]['company_name'];  //$all_data[$i]['company_name']


                                $personal_image = $all_data[$i]['personal_image'];

                                if($personal_image != '')
                                    $pic_src = $personal_pic_root."personal_photo/small/".$personal_image;
                                else
                                {
                                    $pic_src = asset('/images/no-personal-image.png');
                                    //$pic_src = '/images/no-personal-image.png';//NO_PERSONAL_IMAGE;
                                }    

                                $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['title'],$all_data[$i]['company_name'],$all_data[$i]['move_id'],'movements');
                                $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];
                                $sf = $EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); 

                                $pricing_link = '';
                                ?>
                                    <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                </div><!-- /.article-image -->

                                <?PHP
                                $width = 'width:63%;';

                                if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
                                    $width = 'width:63%;';


                                $mod_t = $all_data[$i]['title'];
                                if(strlen($mod_t) > 90)
                                    $mod_t = substr($mod_t, 0, 90);


                                $movement_text = "";
                                if($all_data[$i]['movement_type'] == 1)
                                    $movement_text = " Appointed ";
                                elseif($all_data[$i]['movement_type'] == 2)
                                    $movement_text = " Promoted";

                                ?>
                                <div class="article-content" style="<?=$width?>">
                                    <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?></a> was <?=$movement_text?> as <?=$mod_t?> at <?=$all_data[$i]['company_name']?>
                                    <?PHP
                                    if($all_data[$i]['add_date'] != '')
                                        echo "- ".date("m.d.Y",strtotime($all_data[$i]['add_date'])).".";
                                    ?>

                                    </p>
                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$personal_pic_root.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>


                                            @if($all_data[$i]['more_link'] != '')


                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['more_link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>
                                            @endif

                                            <li>
                                                <a target="_blank" href="<?=$sf?>" class="salesforce">
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>text=<?=urlencode($share_text)?>&url=<?=$all_data[$i]['more_link']?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>

                                            </li>


                                            @if($all_data[$i]['more_link'] != '')


                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['more_link']?>&title=<?=urlencode($share_text)?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                            @endif

                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                        </li><!-- /.article -->

                        @elseif(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'speaking')
                            <li class="article">
                            
                                @if($all_data[$i]['show_state'] == 'unread')                    
                                <ul class="list-checkboxes">
                                    <li>
                                        <div class="checkbox">
                                            <input type="checkbox" name="field-2#" id="field-2#">

                                            <label class="form-label" for="field-2#">1#</label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                </ul><!-- /.list-checkboxes -->
                                @endif
                            
                                <span class="ico-article">
                                    <i class="ico-microphone"></i>
                                </span>

                                <div class="article-image">
                                    <?PHP
                                    
                                    $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['title'],$all_data[$i]['company_name'],$all_data[$i]['id'],'speaking');


                                    $converted_date = date("m.d.Y", strtotime($all_data[$i]['event_date'])); 
                                    $personalURL = "";
                                    $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];


                                    $share_text = "";
                                    $share_text = trim($all_data[$i]['first_name'])." ".trim($all_data[$i]['last_name'])." is scheduled to speak at ".$all_data[$i]['event']." on ".$converted_date;  //$all_data[$i]['company_name']


                                    if($all_data[$i]['personal_image'] != '')
                                    {    
                                    ?>
                                        <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                    else
                                    {
                                        $no_pic_src = asset('/images/no-personal-image.png');
                                    ?>
                                        <a href="<?=$detail_page_url?>"><img src="<?=$no_pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                    ?>
                                </div><!-- /.article-image -->
                                <?PHP
                                
                                $width = 'width:85%;';
                                //if($ind == 1)
                                if(Session::get('user_id') != '')
                                    $width = 'width:63%;';
                                ?>
                                <div class="article-content" style="<?=$width?>">
                                    <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?></a> scheduled to speak at <?=$all_data[$i]['event']?> on <?=$converted_date?>
                                        <?PHP
                                        //if($add_date != '')
                                        //    echo "- (".date("m.d.Y",strtotime($add_date)).")";
                                    ?></p>
                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$personal_pic_root.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>

                                            
                                            @if($all_data[$i]['speaking_link'] != '')
                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['speaking_link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a  onclick="getSalesForceLink('<?=$all_data[$i]['personal_id']?>')" href="javascript:void(0)" class="salesforce"> 
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>text=<?=$share_text?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['speaking_link']?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <?PHP

                                if(Session::get('user_id') != '') 
                                {    
                                ?>
                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your speaking" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                }
                                ?>
                        </li><!-- /.article -->

                        @elseif(isset($all_data[$i]['type']) && ($all_data[$i]['type'] == 'media' || $all_data[$i]['type'] == 'media_mention'))
                            <li class="article">

                                <?PHP
                                //echo "<pre>all_data:";   print_r($all_data);   echo "</pre>"; die();
                                $personalURL = "";
                                $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];
                                //if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_media_read_clicked'] != 1)
                                //{    
                                ?>
                                @if($all_data[$i]['show_state'] == 'unread')  
                                    <ul class="list-checkboxes">
                                        <li>
                                            <div class="checkbox">
                                                <input type="checkbox" name="field-4#" id="field-4#">
                                                <label class="form-label" for="field-4#">1#</label>
                                            </div><!-- /.checkbox -->
                                        </li>
                                    </ul><!-- /.list-checkboxes -->
                                @endif
                                <?PHP
                                //}
                                ?>


                                <span class="ico-article">
                                    <i class="ico-newspaper"></i>
                                </span>

                                <div class="article-image">

                                    <?PHP
                                    $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['title'],$all_data[$i]['company_name'],$all_data[$i]['id'],'media');    
                                    //$detail_page_url = create_url($first_name,$last_name,$title,$company_name,$speaking_id,'media');

                                    //if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                                    //{

                                    //}   
                                    //else
                                    //    $personal_image = '';


                                    if($all_data[$i]['personal_image'] != '')
                                    { 
                                    ?>
                                        <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                    else
                                    {
                                        $pic_src = asset('/images/no-personal-image.png');
                                    ?>    
                                        <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                    ?>
                                </div><!-- /.article-image -->



                                <?PHP
                                $pub_date = date("m-d-Y", strtotime($all_data[$i]['pub_date']));

                                $share_text = "";
                                $share_text = trim($all_data[$i]['first_name'])." ". trim($all_data[$i]['last_name'])." was quoted by ".$all_data[$i]['publication']." ".$all_data[$i]['media_link'];  //$all_data[$i]['company_name']


                                //echo "<br>Session user: ".session('user_id');
                                //echo "<br>Ses: ".Session::get('user_id');
                                $width = 'width:85%;';
                                //$value = session('user_id');
                                //if($ind == 1)
                                if(Session::get('user_id') != '')
                                    $width = 'width:63%;';
                                ?>
                                <div class="article-content" style="<?=$width?>">
                                    <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?></a> was quoted by <?=$all_data[$i]['publication']?> on <?=trim($pub_date)?><?PHP
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
                                            if($all_data[$i]['media_link'] != '')
                                            {    
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['media_link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>
                                            <?PHP
                                            }
                                            ?>

                                            <li>
                                                <a  onclick="getSalesForceLink('<?=$all_data[$i]['personal_id']?>')" href="javascript:void(0)" class="salesforce"> 
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['media_link']?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->


                                <?PHP
                                //if($ind == 0)
                                //if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '') 
                                //{    
                                ?>
                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your media mention" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                //}
                                ?>


                            </li><!-- /.article -->

                        @elseif(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'publication')    

                        <?PHP
                            $personalURL = "";
                            $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];

                            $sf = "";
                            $sf = $EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['move_title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).

                            $share_text = "";
                            $share_text = $all_data[$i]['first_name']." ". $all_data[$i]['last_name']." authored ".$all_data[$i]['title']." ".$all_data[$i]['link'];  //$all_data[$i]['company_name']
                            ?>
                            <li class="article">
                                <?PHP
                                //echo "<br>mark_read_clicked: ".$_SESSION['mark_read_clicked'];
                                //if($show_state == 'unread' && $_SESSION['mark_read_clicked'] != 1 && $_SESSION['mark_pub_read_clicked'] != 1)
                                //{    
                                ?>

                                @if($all_data[$i]['show_state'] == 'unread')  
                                    <ul class="list-checkboxes">
                                        <li>
                                            <div class="checkbox">
                                                <input type="checkbox" name="field-5#" id="field-5#">
                                                <label class="form-label" for="field-5#">1#</label>
                                            </div><!-- /.checkbox -->
                                        </li>
                                    </ul><!-- /.list-checkboxes -->
                                @endif    
                                <?PHP
                               // }
                                ?>


                                <span class="ico-article">
                                        <i class="ico-book"></i>
                                </span>

                                <div class="article-image">
                                <?PHP
                                $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['title'],$all_data[$i]['company_name'],$all_data[$i]['id'],'publication');
                                //$detail_page_url = create_url($first_name,$last_name,$title,$company_name,$publication_id,'publication');


                                //if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                                //{

                                //}   
                                //else
                                //    $personal_image = '';



                                if($all_data[$i]['personal_image'] != '')
                                {    
                                ?>
                                    <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar"></a>
                                <?PHP
                                }
                                else
                                {
                                    $pic_src = asset('/images/no-personal-image.png');
                                ?>    
                                    <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                <?PHP
                                }
                                ?>
                                </div><!-- /.article-image -->


                                <?PHP
                                $publication_date = date("m-d-Y", strtotime($all_data[$i]['publication_date']));
                                $width = 'width:85%;';
                                    //if($ind == 1)
                                    if(Session::get('user_id') != '')
                                        $width = 'width:63%;';
                                ?>
                                <div class="article-content" style="<?=$width?>">
                                    <p><a href="<?=$personal_pic_root.$personalURL?>"><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?></a> published "<?=$all_data[$i]['title']?>" on <?=$all_data[$i]['publication_date']?><?PHP
                                        //if($add_date != '')
                                        //    echo ". (".date("m-d-Y",strtotime($add_date)).")";
                                    ?></p>

                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$personal_pic_root.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$sf?>" class="salesforce">
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['link']?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->


                                <?PHP
                                //if($ind == 0)
                                if(Session::get('user_id') != '')     
                                {    
                                ?>

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your publication" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                }
                                ?>

                            </li><!-- /.article -->     



                         @elseif(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'awards')       


                        <?PHP
                            $converted_date = date("M d, Y", strtotime($all_data[$i]['awards_date']));

                            $first_name = $all_data[$i]['first_name'];
                            $last_name = $all_data[$i]['last_name'];
                            $personal_id = $all_data[$i]['personal_id'];

                            $personalURL = "";
                            $personalURL = trim($first_name).'_'.trim($last_name).'_Exec_'.$personal_id;

                            $sf = "";
                            $sf = $EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); 

                            $share_text = "";
                            $share_text = "Congrats ".$first_name." ". $last_name." on ".$all_data[$i]['awards_title']." ".$all_data[$i]['awards_link'];  //$all_data[$i]['company_name']
                        ?>

                            <li class="article">
                                
                                @if($all_data[$i]['show_state'] == 'unread')    
                                <ul class="list-checkboxes">
                                    <li>
                                        <div class="checkbox">
                                            <input type="checkbox" name="field-3#" id="field-3#">
                                            <label class="form-label" for="field-3#">1#</label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                </ul><!-- /.list-checkboxes -->
                                @endif
                                

                                <span class="ico-article">
                                    <i class="ico-cup"></i>
                                </span>

                                <div class="article-image">
                                <?PHP

                                //if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                               // {

                                //}   
                                //else
                                //    $personal_image = '';




                                if($all_data[$i]['personal_image'] != '')
                                    $pic_src = $personal_pic_root."personal_photo/small/".$all_data[$i]['personal_image'];
                                else
                                    $pic_src = asset('/images/no-personal-image.png');

                                $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['awards_title'],$all_data[$i]['company_name'],$all_data[$i]['id'],'awards');
                                //$detail_page_url = create_url($first_name,$last_name,$awards_title,$company_name,$awards_id,'awards');

                                //if($all_data[$i]['personal_image'] != '')
                                //{    
                                ?>
                                    <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                <?PHP
                                //}
                                //else
                                //{    
                                ?>
                                  <!--   <img src="<?=$NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar"> -->
                                <?PHP
                                //}
                                ?>
                                </div><!-- /.article-image -->


                                <?PHP
                                $width = 'width:85%;';
                                //if($ind == 1)
                                if(Session::get('user_id') != '')
                                    $width = 'width:63%;';

                                $awards_title = trim($all_data[$i]['awards_title']);
                                //echo "<br>awards_title before: ".$awards_title;

                                $awards_title_lower = strtolower($all_data[$i]['awards_title']);

                                $aw_pos = '';
                                $aw_pos = strpos($awards_title_lower,"award");
                                //echo "<br>aw_pos:".$aw_pos."::";
                                if($aw_pos === false)
                                {
                                    //echo "<br>within if";
                                    $aws_pos = strpos($awards_title_lower,"awards");
                                    //echo "<br>aws_pos:".$aws_pos."::";
                                    if($aws_pos === false)
                                    {
                                        $awards_title = $awards_title." award";    
                                    }    
                                }    


                                ?>

                                <div class="article-content" style="<?=$width?>">
                                    <p>
                                        <a href="<?=$personal_pic_root.$personalURL?>"><?=$first_name?> <?=$last_name?></a> received <?=$all_data[$i]['awards_title']?> from <?=$all_data[$i]['awards_given_by']?> on <?=trim($converted_date)?><?PHP
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
                                            if($all_data[$i]['awards_link'] != '')
                                            {    
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['awards_link']?>" class="upload">
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
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>text=<?=$share_text?>&original_referer=&nbsp;" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['awards_link']?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <?PHP
                                //echo "IND:".$ind.":";
                                //if($ind == 0)
                                if(Session::get('user_id') != '') 
                                {    
                                ?>

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your industry award" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                }
                                ?>


                            </li><!-- /.article -->   


                            @elseif(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'funding')       

                            <?PHP
                            $dim_url = "";
                            $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $all_data[$i]['company_name']).'_Company_'.$all_data[$i]['company_id'];

                            $sf = "";
                            $sf = $EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).

                            $share_text = "";
                            //$share_text = $all_data[$i]['company_name']." raised ".$all_data[$i]['funding_amount']." and ".$all_data[$i]['first_name']." ".$all_data[$i]['last_name']." is the decision maker";
                            $share_text = $all_data[$i]['company_name']." raised ".$all_data[$i]['funding_amount']." in Funding &url=".$all_data[$i]['funding_source'];

                            ?>
                            <li class="article article-secondary">

                                @if($all_data[$i]['show_state'] == 'unread')
                                    <ul class="list-checkboxes">
                                        <li>
                                            <div class="checkbox">
                                                <input type="checkbox" name="field-6#" id="field-6#">
                                                <label class="form-label" for="field-6#">1#</label>
                                            </div><!-- /.checkbox -->
                                        </li>
                                    </ul><!-- /.list-checkboxes -->
                                @endif
                                <span class="ico-article">
                                    <i class="ico-cash"></i>
                                </span>

                                <?PHP
                                $funding_date = date("m.d.Y", strtotime($all_data[$i]['funding_date']));
                                //echo "<pre>all_data: ";   print_r($all_data);   echo "</pre>";
                                ?>
                                <div class="article-content-secondary">
                                    <!-- <a href="#" class="logo-cashstar">Cashstar</a> -->
                                    <a href="#" class="logo-cashstar"><img src="https://www.ctosonthemove.com/company_logo/thumb/<?=$all_data[$i]['company_logo']?>"></a>
                                    <div class="article-inner-secondary">
                                        <p><?=$all_data[$i]['company_name']?> raised <?=$all_data[$i]['funding_amount']?> on <?=$all_data[$i]['funding_date']?></p>
                                        <div class="socials">
                                            <ul>
                                                <li>
                                                    <a target="_blank" href="<?=$profile_root_link.$dim_url?>" class="note">
                                                        <i class="ico-note"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a target="_blank" href="<?=$all_data[$i]['funding_source']?>" class="upload"><i class="ico-upload"></i></a>
                                                </li>
                                            </ul>
                                        </div><!-- /.socials-secondary -->
                                    </div><!-- /.article-inner-secondary -->
                                </div><!-- /.article-content-secondary -->

                                <div class="article-inner">
                                    <div class="article-image">
                                        <a href="#">
                                            <?PHP

                                            //if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                                            //{

                                            //}   
                                            //else
                                            //    $personal_image = '';


                                            $detail_page_url = create_url($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['title'],$all_data[$i]['company_name'],$all_data[$i]['funding_id'],'funding');
                                            //$detail_page_url = create_url($first_name,$last_name,$title,$company_name,$funding_id,'funding');

                                            if($all_data[$i]['personal_image'] != '')
                                            {    
                                            ?>
                                                <a href="<?=$detail_page_url?>"><img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar"></a>
                                            <?PHP
                                            }
                                            else
                                            {
                                                $pic_src = asset('/images/no-personal-image.png');
                                            ?>   
                                                <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                            <?PHP
                                            }
                                           ?>         
                                        </a>
                                    </div><!-- /.article-image -->


                                    <?PHP
                                    $width = 'width:85%;';
                                    //if($ind == 1)
                                    if(Session::get('user_id') != '')
                                        $width = 'width:63%;';
                                    ?>

                                    <div class="article-content" style="<?=$width?>">
                                        <p><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?>, <?=$all_data[$i]['title']?> at <?=$all_data[$i]['company_name']?>, is the decision maker</p>

                                        <div class="socials">
                                            <ul>
                                                <li>
                                                    <a href="<?=$sf?>" class="salesforce">
                                                        <i class="ico-salesforce"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>text=<?=$share_text?>" class="twitter">
                                                        <i class="ico-twitter"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['funding_source']?>" class="linkedin">
                                                        <i class="ico-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div><!-- /.socials -->
                                    </div><!-- /.article-content -->
                                </div><!-- /.article-inner -->


                                <?PHP
                                //if($ind == 0)
                                if(Session::get('user_id') != '') 
                                {    
                                ?>

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your company funding" target="_blank" class="btn btn-primary">
                                    <!--	<a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                }
                                ?>


                            </li><!-- /.article -->

                        @elseif(isset($all_data[$i]['type']) && $all_data[$i]['type'] == 'jobs')       
                        <?PHP    
                            if(Session::get('user_site') != '')
                            {    
                                $base_site = Session::get('user_site');
                                if($base_site == 'it' || $base_site == 'ciso' || $base_site == 'cto')
                                    $profile_root_link = "https://www.ctosonthemove.com/";

                                elseif($base_site == 'cfo')
                                    $profile_root_link = "https://www.cfosonthemove.com/";

                                elseif($base_site == 'cmo' || $base_site == 'cso')
                                    $profile_root_link = "https://www.cmosonthemove.com/";

                                elseif($base_site == 'clo')
                                    $profile_root_link = "https://www.closonthemove.com/";
                                //if($base_site == 'hr')
                                //    $profile_root_link = "https://www.hrexecsonthemove.com/";
                                else
                                    $profile_root_link = "https://www.hrexecsonthemove.com/";
                            }   
                            $company_pic_root = "https://www.ctosonthemove.com/";



                            $dim_url = "";
                            $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $all_data[$i]['company_name']).'_Company_'.$all_data[$i]['company_id'];


                            $share_text = "";
                            $share_text = $all_data[$i]['company_name']." looking to hire ".$all_data[$i]['job_title']." in ".$all_data[$i]['location']." ".$all_data[$i]['source'];  //$all_data[$i]['company_name']
                            $post_date = date("m-d-Y", strtotime($all_data[$i]['post_date']));
                        ?>
                            <li class="article">

                                @if($all_data[$i]['show_state'] == 'unread')


                                <ul class="list-checkboxes">
                                    <li>
                                        <div class="checkbox">
                                            <input type="checkbox" name="field-7#" id="field-7#">
                                            <label class="form-label" for="field-7#">1#</label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                </ul><!-- /.list-checkboxes -->

                                @endif


                                <span class="ico-article">
                                    <i class="ico-forma"></i>
                                </span>

                                <div class="article-image">

                                    <?PHP
                                    $detail_page_url = create_job_url($all_data[$i]['job_title'],$all_data[$i]['company_name'],$all_data[$i]['id'],'jobs');


                                    if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],"execfile.com") > -1)
                                    {

                                    }   
                                    else
                                        $company_logo = '';


                                    //echo "<br>detail_page_url: ".$detail_page_url;
                                    if($all_data[$i]['company_logo'] != '')
                                    {    
                                    ?>
                                        <a href="<?=$detail_page_url?>"><img src="<?=$company_pic_root?>/company_logo/org/<?=$all_data[$i]['company_logo']?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                    else
                                    {
                                        $pic_src = asset('/images/no-personal-image.png');
                                    ?>   
                                        <a href="<?=$detail_page_url?>"><img src="<?=$pic_src?>" height="80" width="80" alt="" class="article-avatar"></a>
                                    <?PHP
                                    }
                                   ?> 
                                </div><!-- /.article-image -->


                                <?PHP
                                $width = 'width:85%;';
                                    //if($ind == 1)
                                    if(Session::get('user_id') != '')
                                        $width = 'width:63%;';
                                ?>
                                <div class="article-content" style="<?=$width?>">
                                    <p><?=$all_data[$i]['company_name']?> looking to hire <?=$all_data[$i]['job_title']?> in <?=$all_data[$i]['location']?>– published on <?=$all_data[$i]['post_date']?><?PHP
                                        if($all_data[$i]['add_date'] != '')
                                            echo ". (".date("m-d-Y",strtotime($all_data[$i]['add_date'])).")";
                                    ?></p>

                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a href="<?=$profile_root_link.$dim_url?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>
                                            <?PHP
                                            if($all_data[$i]['source'] != '')
                                            {    
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['source']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>
                                            <?PHP
                                            }
                                            ?>


                                            <li>
                                                <a target="_blank" href="<?=$TWITTER_SHARE_ROOT?>&text=<?=$share_text?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>


                                            <?PHP
                                            if($all_data[$i]['source'] != '')
                                            {    
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?=$LINKEDIN_SHARE_ROOT?>url=<?=$all_data[$i]['source']?>" class="linkedin">
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
                                if(Session::get('user_id') != '')
                                {    
                                ?>

                                <div class="article-actions">
                                    <a href="<?=$all_data[$i]['source']?>" class="btn btn-primary btn-secondary">
                                        <span>Apply now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                                <?PHP
                                }
                                ?>

                            </li><!-- /.article -->
                        @endif
                        
                        
                        
                        

                        @endfor
                    @endif



                </ul><!-- /.articles -->
            </div><!-- /.section-body -->

            <div class="section-foot">
                
                <?PHP
                
                //echo "<br>unread_speaking_count ONE PT ONE:".$unread_speaking_count;
                
                $from_date_pgint = ''; 
                $to_date_pgint = ''; 
                $selected_revenue_pgint = '';
                $selected_employee_size_pgint = '';
                $selected_city_pgint = ''; 
                $selected_state_pgint = '';
                $selected_zip_pgint = '';
                $companyval_pgint = '';
                $searchnow_pgint = '';
                $selected_industries_pgint = '';

                if($from_date_raw == '')
                    $from_date_pgint = 0;
                else
                    $from_date_pgint = $from_date_raw;

                if($to_date_raw == '')
                    $to_date_pgint = 0;
                else
                    $to_date_pgint = $to_date_raw;

                if($selected_industries == '')
                    $selected_industries_pgint = 0;
                else
                    $selected_industries_pgint = $selected_industries;

                if($selected_revenue == '')
                    $selected_revenue_pgint = -1;
                else
                    $selected_revenue_pgint = $selected_revenue;

                if($selected_employee_size == '')
                    $selected_employee_size_pgint = -1;
                else
                    $selected_employee_size_pgint = $selected_employee_size;


                if($selected_city == '')
                    $selected_city_pgint = 0;
                else
                    $selected_city_pgint = $selected_city;

                if($selected_state == '')
                    $selected_state_pgint = 0;
                else
                    $selected_state_pgint = $selected_state;

                if($selected_zip == '')
                    $selected_zip_pgint = 0;
                else
                    $selected_zip_pgint = $selected_zip;

                if($companyval == '')
                    $companyval_pgint = 0;
                else
                    $companyval_pgint = $companyval;


                if($searchnow == '')
                    $searchnow_pgint = 0;
                else
                    $searchnow_pgint = $searchnow;




                $root_path = url('');
                $pg_int_url = $root_path."/search/".$selected_type."/".$selected_industries_pgint."/".$from_date_pgint."/".$to_date_pgint."/".$selected_revenue_pgint."/".$selected_employee_size_pgint."/".$selected_city_pgint."/".$selected_state_pgint."/".$selected_zip_pgint."/".$searchnow_pgint."/".$companyval_pgint."/0/0";
                //$pg_int_url = $root_path."/search/".$selected_type."/".$selected_industries."/".$from_date_pgint."/".$to_date_pgint."/".$selected_revenue_pgint."/".$selected_employee_size_pgint."/".$selected_city_pgint."/".$selected_state_pgint."/".$selected_zip_pgint;


                //echo "<br>pg_int_url: ".$pg_int_url;
                //echo "<br>Base apath: ".url('');
                //echo "<br>this_page_url: ".$this_page_url;
                //echo "<br>p: ".$p;
                //echo "<br>total_data: ".$total_data;
                //echo "<br>items_per_page: ".$items_per_page;


                //echo number_pages($this_page_url, $p, $total_data, 0, $items_per_page,''.'');
                echo number_pages($pg_int_url, $p, $total_data, 0, $items_per_page,'');
                ?>
            </div><!-- /.section-foot -->



        </section><!-- /.section-primary -->


        @endif

    
        </div><!-- /.content -->    
                        
    
</div>

<?PHP
//echo "<br>strpos: ".$_SERVER['HTTP_REFERER']; //strpos($_SERVER['HTTP_REFERER'],'login.php');
if(strpos($_SERVER['HTTP_REFERER'],'/login') > -1)
{
    //echo "<br>withhin if after login:".$unread_speaking_count;  
    /*
    $unread_movements_count = $unread_movements_count;
    $unread_speaking_count = $unread_speaking_count;
    $unread_media_count = $unread_media_count;
    $unread_award_count = $award_count;
    $unread_publication_count = $publication_count;
    $unread_funding_count = $funding_count;
    $unread_job_count = $job_count;
    */
  
    update_user_counts($unread_movements_count,$unread_speaking_count,$unread_media_count,$unread_award_count,$unread_publication_count,$unread_funding_count,$unread_job_count);
}        

else
{
    //echo "<br>withhin else after login";  
    $unread_movements_count = get_count('movement');
    if($unread_movements_count == '')
        $unread_movements_count = 0;
    
    $unread_speaking_count = get_count('speaking');
    if($unread_speaking_count == '')
        $unread_speaking_count = 0;
    
    $unread_media_count = get_count('media');
    if($unread_media_count == '')
        $unread_media_count = 0;
    
    $unread_award_count = get_count('awards');
    if($unread_award_count == '')
        $unread_award_count = 0;
    
    $unread_publication_count = get_count('publication');
    if($unread_publication_count == '')
        $unread_publication_count = 0;
    
    $unread_funding_count = get_count('funding');
    if($unread_funding_count == '')
        $unread_funding_count = 0;
    
    $unread_job_count = get_count('jobs');
    if($unread_job_count == '')
        $unread_job_count = 0;
    //echo "<br>withhin else";  
}


//echo "<br>unread_speaking_count TWO:".$unread_speaking_count;

?>
<script>
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

</body>
</html>