<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Execfile</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />


<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="<? //=DIR_JS?>validation.js" language="javascript"></script> -->


<link rel="stylesheet" href="<?PHP echo asset('home_style.css'); ?>" type="text/css" >
<link rel="stylesheet" href="<?PHP echo asset('home_style_tags.css'); ?>" type="text/css" >

<script language="javascript">
function show_all_alerts()
{
    //document.getElementsByClassName('hide_row').style.display = 'block';
    var max_id = document.getElementById("max_alert_id").value;
    for(var c=6;c<max_id;c++)
    {
        if(document.getElementById('hide_col1_'+c))
        {    
            document.getElementById('hide_col1_'+c).style.display = 'table-cell';
            document.getElementById('hide_col2_'+c).style.display = 'table-cell';
        }    
    }    
}

function makeDefault(list_id,url)
{
    var lfckv = document.getElementById("cb_"+list_id).checked;
    //alert(lfckv);
    //return false;
    
    //settings.php?l_id=".$list_row['l_id']
    if(lfckv)
        window.location.href = url+"/settings/"+list_id+"/makedefault";
    else
        window.location.href = url+"/settings/"+list_id+"/unmakedefault";
}
</script>   

</head>
<body class="blue_body">
<div>
<div style="margin:0px auto;width:990px;">    
    <div style="padding-top:0px;margin-top:8px;">
        <a href="{{ url('search') }}" class="logo"></a>
        <!-- <h1 style="padding-left:0px;"><a href="home.php?funtion=hr"><img width="257" height="24" src="css/images/new-logo.png"></a></h1> -->
    </div>

    <div class="content_div" style="margin-top:20px;">

    <?PHP    
        if($msg != '')    
    {    
    ?>

    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }
    else
    { 
        if(1 == 2)
        {    
    ?>
            <div class="intro-content" style="width:400px;margin: 0 auto;">
            <!-- <h3 style="text-align:left;width:100%;padding:0px 0px 15px 0px;margin:0px;">Request A Demo</h3> -->
            <h1 style="width:600px;margin-bottom: 15px;font-size:53px;">Subscription</h1>

                <div class="form-sing-up">
                    <form action="settings.php" method="post">
                        <div class="form-body">
                            <div style="color:white;" class="form-row">
                                <label for="field-email" class="form-label hidden">Work Email</label>
                                <input <?PHP if($level == 'basic') echo "checked";?> type="radio" name="subscription" value="basic"> Basic<br>
                                <input <?PHP if($level == 'standard') echo "checked";?> type="radio" name="subscription" value="standard"> Standard<br>
                                <input <?PHP if($level == 'professional') echo "checked";?> type="radio" name="subscription" value="professional"> Professional
                            </div><!-- /.form-row -->
                        </div><!-- /.form-body -->

                        <div class="form-actions">
                            <input type="hidden" id="request_demo_flag" name="request_demo_flag" value="1">
                            <input type="submit" value="Upgrade" class="form-btn"> <!--  onclick="return filter_email();" -->
                        </div><!-- /.form-actions -->
                    </form>
                </div><!-- /.form-sing-up -->

            </div><!-- /.intro-content -->
    <?PHP
        }
    }

    
// Saved list  
$saved_list_count = count($saved_list);

//echo "<pre>saved_list: ";   print_r($saved_list);   echo "</pre>";


?>
@if($saved_list_count > 0) 
<?PHP            
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Saved List</h1>";
    echo "<table width=90% cellpadding=5 cellspacing=0 style=\"color:white;\">";
    echo "<tr><th style=text-align:left; width=630>Lists</th><th style=text-align:left;>Names</th><th style=text-align:left; width=145>Action</th></tr>";
    //echo "<tr><th width=60 style=text-align:left;>Links</th></tr>";
    $list_c = 1;
    
    //echo "<br>URL: ".app('');
    //echo "<br>URL: ".url("/settings/5");
    ?>
    @for ($i = 0; $i < $saved_list_count; $i++)
    <?PHP
        $zip_code = "";
        $company = "";
        $city = "";
        $company_website = "";
        $industry_ids = "";
        $state_ids = "";
        $revenue = "";
        $employee_size = "";
        $list_link = "";
        $list = "";
        //echo "<br>".$list_row['filters'];
        
        if($saved_list[$i]['filters'] != '')
        {    
            $filter_arr = explode(":",$saved_list[$i]['filters']);
    //echo "<pre>filter_arr: ";   print_r($filter_arr);   echo "</pre>";

            $this_type = $filter_arr[0];
            $zip_code = $filter_arr[4];

            $company = $filter_arr[5];
            $city = $filter_arr[6];
            $company_website = $filter_arr[7];
            $industry_ids = $filter_arr[8];
            $state_ids =  $filter_arr[9];
            $revenue =  $filter_arr[11];
            $employee_size = $filter_arr[13];
        }
        $mweb = "";
        if($saved_list[$i]['websites_filter'] != '')
        {
            $mweb = $saved_list[$i]['l_id'];
        }  
        $list = $saved_list[$i]['l_id'];
        
        //$list_link = "http://www.execfile.com/home.php?from_date=&to_date=&type=$this_type&zip=$zip_code&city=$city&industries=$industry_ids&states=$state_ids&revenue=$revenue&employee_size=$employee_size&companyval=&mweb=$mweb&list=$list";
        $list_link = url('search/'.$saved_list[$i]['list_link']);

                
        $list_name =$saved_list[$i]['list_name'];
        
        $default_list = $saved_list[$i]['default_list'];
        
        //echo "<br><a href=$list_link>".$list_row['filters']."</a>";
        echo "<tr>"; 
        echo "<td><a href=$list_link>List ".$list_c."</td>";
        
        
        echo "<td width=210>";
        //echo "<form method=post>";
        ?>
        {!! Form::open(['url' => 'settings'])   !!}
        <?PHP    
        echo "<input type=hidden name=list_id_for_name id=list_id_for_name value=".$saved_list[$i]['l_id']."><input style=\"width:150px;color:black;\" type=text name=list_name id=list_name value=\"$list_name\">&nbsp;<input style=\"color:black;\" type=submit name=list_name_sbt id=list_name_sbt value=Save>";
        //echo "</form>";
        ?>
        {!! Form::close()   !!}
        <?PHP
        echo "</td>";
        echo "<td width=230>&nbsp;&nbsp;";
        echo "<a href=alert.php?l_id=".$saved_list[$i]['l_id'].">";
        echo "Edit";
        echo "</a>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $checked = "";
        if($default_list == 1)
        {
            $checked = "checked";
        //    echo "<a href=settings.php?l_id=".$list_row['l_id'].">";
        }
        //else
        //    echo "<b>";
        echo "<input $checked type=checkbox id=cb_".$saved_list[$i]['l_id']." onclick=makeDefault('".$saved_list[$i]['l_id']."','".url('')."')>&nbsp;Make it Default";
        //if($default_list != 1)
        //{ 
        //    echo "</a>";
        //}
        //else
        //    echo "</b>";
        echo "</td>";
        echo "</tr>";
        $list_c++;
        
    ?>
    @endfor
    <?PHP
    echo "</table>"; 
    
    
?>
@endif
<?PHP
    
$alerts_count = count($alerts_list);    
    
?>
@if($alerts_count > 0)
<?PHP   
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">My Alerts</h1>";
    echo "<table cellpadding=5 cellspacing=0 width=95% style=\"color:white;\">";
    echo "<tr><th width=60 style=text-align:left;>ID</th><th style=text-align:left;>Triggers</th><th width=20 0>Name</th><th>Action</th></tr>";
    
    ?>
    @for ($j = 0; $j < $alerts_count; $j++)
    <?PHP
    
        $alert_name = $alerts_list[$j]['alert_name'];
        
        echo "<tr><td>";
        echo $alerts_list[$j]['alert_id'];
        echo "</td><td>".$alerts_list[$j]['trigger_details']."</td>";

        echo "<td width=220>";
        //echo "<form method=post>";
        ?>
        {!! Form::open(['url' => 'settings'])   !!}
        <?PHP
        echo "<input type=hidden name=alert_id_for_name_change id=alert_id_for_name_change value=".$alerts_list[$j]['alert_id']."><input type=hidden name=this_alert_id id=this_alert_id value=".$alerts_list[$j]['alert_id']."><input style=\"width:150px;color:black;\" type=text name=alert_name id=alert_name value=\"$alert_name\">&nbsp;<input style=\"color:black;\" type=submit name=name_sbt id=name_sbt value=Save>";
        ?>
        {!! Form::close()   !!}
        <?PHP
        //echo "</form>";
        echo "</td>";
        
        echo "<td>";
        echo "&nbsp;&nbsp;&nbsp;";
        //echo "<a href=settings/".$alerts_list[$j]['alert_id']."/deleteAlert>Delete</a>";
        echo "<a href=".url('settings/'.$alerts_list[$j]['alert_id'].'/deleteAlert').">Delete</a>";
        echo "&nbsp;&nbsp;&nbsp;";
        //echo "<a href=alert.php?alert_id=".$alerts_list[$j]['alert_id'].">Edit</a>";
        echo "<a href=".url('alerts/'.$alerts_list[$j]['alert_id'].'/editAlert').">Edit</a>";
        echo "</td>";
        
        echo "</tr>";
        //echo "<br>".$alerts_row;
        //echo "<pre>alerts_row: ";   print_r($alerts_row);   echo "</pre>";
    ?>
    @endfor
    <?PHP
    echo "</table>";
    ?>
@endif    
<?PHP    
    

   //echo "<pre>alerts_send: ";    print_r($alerts_send);    echo "</pre>";
    $alerts_send_count = count($alerts_send);
?>
@if($alerts_send_count > 0)
<?PHP
    $alerts_c = 1;
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Alert Emails</h1>";
    echo "<table border=0 cellpadding=5 cellspacing=0 width=95% style=\"color:white;margin-bottom:75px;\">";
    echo "<tr><th width=660 style=text-align:left;>Date</th><th style=text-align:left;>Action</th></tr>";
    ?>
    @for ($k = 0; $k < $alerts_send_count; $k++)
    <?PHP
    {
        $disp = "";
        $hidden_class = "";
        $hidden_id_one = "";
        $hidden_id_two = "";
          
        if($alerts_c > 5)
        {
            $disp = 'display:none;';
            $hidden_id_one = "id=hide_col1_".$alerts_c;
            $hidden_id_two = "id=hide_col2_".$alerts_c;
            
            if($alerts_c == 6)
            {
                echo "<tr><td style=padding-top:10px;padding-bottom:10px;cursor:pointer; onclick=show_all_alerts(); colspan=2><b><u>Show More</u></b></td></tr>";
                //echo "<div $hidden_class style=$disp>";
            }    
                    
        }    
        echo "<tr><td $hidden_id_one style=text-align:left;$disp>".gmdate("Y-m-d", $alerts_send[$k]['sent_date'])."</td><td $hidden_id_two style=text-align:left;$disp><a target=blank href=/alert-email-show.php?emailid=".$alerts_send[$k]['email_id'].">View</a></td></tr>";
        //echo "</div>";
        $alerts_c++;
    }
    ?>
    @endfor
    <?PHP
    echo "<input type=hidden name=max_alert_id id=max_alert_id value=$alerts_c>";
    echo "</table>";
    
?>
@endif
<?PHP
    




if(sizeof($user_invoices) > 0)
{
    $sequence = 0;
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Invoices</h1>";
    echo "<table cellpadding=5 cellspacing=0 width=95% style=\"color:white;margin-bottom:75px;\">";
    //echo "<tr><th width=160 style=text-align:left;>Invoices</th></tr>";
    
    for($j=0;$j<sizeof($user_invoices);$j++)
    {
    ?>
        <tr><td><a target="_blank" href="https://www.hrexecsonthemove.com/vsword/invoices/<?=$this_usr?>_<?=$user_invoices[$j]?>.pdf">Invoice for <?=$user_invoices[$j]?></a></td></tr>
         
    <?PHP
    }
    echo "</table>";
}

?>
    </div>
</div>
</div>