<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<script language="javascript">
function show_all_alerts()
{
    //document.getElementsByClassName('hide_row').style.display = 'block';
    var max_id = document.getElementById("max_alert_id").value;
    for(var c=6;c<max_id;c++)
    {
        if(document.getElementById('hide_col1_'+c))
        {    
            document.getElementById('hide_col1_'+c).style.display = 'block';
            document.getElementById('hide_col2_'+c).style.display = 'block';
        }    
    }    
}

function makeDefault(list_id)
{
    var lfckv = document.getElementById("cb_"+list_id).checked;
    //alert(lfckv);
    //return false;
    
    //settings.php?l_id=".$list_row['l_id']
    if(lfckv)
        window.location.href = "http://www.execfile.com/settings.php?l_id="+list_id;
    else
        window.location.href = "http://www.execfile.com/settings.php?ul_id="+list_id;
}
</script>    
<?PHP
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
if(!isset($_SESSION['sess_username']))
{
    header('Location: http://execfile.com/index.php#joind_100s');
}
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");


function this_user_invoices($user_id,$invoice_table)
{
    $invoice_dates = array();
    //$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='".$_SESSION['sess_user_id']."' and appear_date <= now()");
    
    //echo "select * from hre_saved_invoices where user_id='".$_SESSION['sess_user_id']."'";
    
    $find_invoices_query = mysql_query("select * from $invoice_table where user_id='".$user_id."'");
    if($find_invoices_query)
    {
        $invoice_num = mysql_num_rows($find_invoices_query);
        if($invoice_num > 0)
        {
            //$invoice_row = com_db_fetch_array($find_invoices_query);
            while ($invoice_row = mysql_fetch_array($find_invoices_query)) 
            {        
                $display_name = $invoice_row['display_name'];
                $invoice_dates[] = $display_name;
            }
        }
    }
    //echo "<pre>invoice_dates: ";	print_r($invoice_dates);	echo "</pre>";
    return $invoice_dates;
}



//echo "<pre>_SESSION: ";   print_r($_SESSION);   echo "</pre>";   
//$hre = mysql_connect("10.132.225.160","hre2","htXP%th@71") or die("Database ERROR ");
//$hre = mysql_connect("10.132.225.160","hre2","yTmcds1@#dab133") or die("Database ERROR ");
//mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");


$user_invoices = array();

$user_site_query = mysql_query("select * from exec_user where user_id='".$_SESSION['sess_user_id']."'");
$get_usersite_res = mysql_query($user_site_query);
$num_of_usr_site = mysql_num_rows($get_usersite_res);
if($num_of_usr_site > 0)
{
    $this_usr_site = $user_row['site'];
    if($this_usr_site == 'hr')
        $invoice_table = 'hre_saved_invoices';
    elseif($this_usr_site == 'cmo')
        $invoice_table = 'cmo_saved_invoices';
    elseif($this_usr_site == 'clo')
        $invoice_table = 'clo_saved_invoices';
    elseif($this_usr_site == 'cto')
        $invoice_table = 'cto_saved_invoices';


    $get_user_q = "SELECT user_id from hre_user where email = '".strtolower($_SESSION['sess_email'])."'";
    $get_user_res = mysql_query($get_user_q);
    $num_of_usr = mysql_num_rows($get_user_res);
    if($num_of_usr > 0)
    {    
        $user_row = mysql_fetch_array($get_user_res, MYSQL_ASSOC);
        $this_usr = $user_row['user_id'];
        //echo "<pre>user_row: ";   print_r($user_row);   echo "</pre>";   
        $user_invoices = this_user_invoices($user_row['user_id'],$invoice_table);
        //echo "<pre>this_user_invoices: ";   print_r($this_user_invoices);   echo "</pre>";   
    }
}

//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');


$this_user = $_SESSION['sess_user_id'];


if(isset($_GET['ul_id']) && $_GET['ul_id'] != '')
{
    $unc_undef_q = "UPDATE user_saved_lists set default_list = 0 where user_id = ".$this_user;
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($unc_undef_q);
}

if(isset($_GET['l_id']) && $_GET['l_id'] != '')
{
    $upd_undef_q = "UPDATE user_saved_lists set default_list = 0 where user_id = ".$this_user;
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_undef_q);
    
    
    $upd_def_q = "UPDATE user_saved_lists set default_list = 1 where l_id = ".$_GET['l_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_def_q);
}


//echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";   

if(isset($_POST['name_sbt']) && $_POST['name_sbt'] == 'Save' && $_POST['this_alert_id'] != '')
{
    $upd_alert_q = "UPDATE exec_alert set alert_name = '".$_POST['alert_name']."' where alert_id = ".$_POST['this_alert_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_alert_q);
} 


if(isset($_POST['list_name_sbt']) && $_POST['list_name_sbt'] == 'Save' && $_POST['this_list_id'] != '')
{
    $upd_list_q = "UPDATE user_saved_lists set list_name = '".$_POST['list_name']."' where l_id = ".$_POST['this_list_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_list_q);
} 


if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    
    $subscription = $_POST['subscription'];
    
    com_db_query("UPDATE ".TABLE_USER." set level='".$subscription."' where user_id = ".$this_user);	
    $msg = "You successfully changed your subscription.";  
    
    
   
}


$user_query = "select level from " . TABLE_USER ." where user_id = ".$this_user;
    //echo "<br>user_query: ".$user_query; 
$user_result = com_db_query($user_query);
$user_row = com_db_fetch_array($user_result);
$level = $user_row['level'];


    if($msg != '')    
    {    
    ?>

    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }

    
// Saved list  
    
$my_saved_list_q = "SELECT * from user_saved_lists where user_id = $this_user";
//echo "<br>my_alerts_q: ".$my_alerts_q;
$my_saved_list_res = com_db_query($my_saved_list_q);
$saved_list_rows = com_db_num_rows($my_saved_list_res);

//echo "<br>saved_list_rows: ".$saved_list_rows;
if($saved_list_rows > 0)
{ 
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Saved List</h1>";
    echo "<table width=90% cellpadding=5 cellspacing=0 style=\"color:white;\">";
    echo "<tr><th style=text-align:left; width=630>Lists</th><th style=text-align:left;>Names</th><th style=text-align:left; width=145>Action</th></tr>";
    //echo "<tr><th width=60 style=text-align:left;>Links</th></tr>";
    $list_c = 1;
    while($list_row = com_db_fetch_array($my_saved_list_res))
    {
        
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
        $filter_arr = explode(":",$list_row['filters']);

        $this_type = $filter_arr[0];
        $zip_code = $filter_arr[4];

        $company = $filter_arr[5];
        $city = $filter_arr[6];
        $company_website = $filter_arr[7];
        $industry_ids = $filter_arr[8];
        $state_ids =  $filter_arr[9];
        $revenue =  $filter_arr[11];
        $employee_size = $filter_arr[13];
        
        $mweb = "";
        if($list_row['websites_filter'] != '')
        {
            $mweb = $list_row['l_id'];
        }  
        $list = $list_row['l_id'];
        $list_link = "http://www.execfile.com/home.php?from_date=&to_date=&type=$this_type&zip=$zip_code&city=$city&industries=$industry_ids&states=$state_ids&revenue=$revenue&employee_size=$employee_size&companyval=&mweb=$mweb&list=$list";
        $list_name = $list_row['list_name'];
        
        $default_list = $list_row['default_list'];
        
        //echo "<br><a href=$list_link>".$list_row['filters']."</a>";
        echo "<tr>"; 
        echo "<td><a href=$list_link>List ".$list_c."</td>";
        
        
        echo "<td width=210>";
        echo "<form method=post><input type=hidden name=this_list_id id=this_list_id value=".$list_row['l_id']."><input style=\"width:150px;color:black;\" type=text name=list_name id=list_name value=\"$list_name\">&nbsp;<input style=\"color:black;\" type=submit name=list_name_sbt id=list_name_sbt value=Save></form>";
        echo "</td>";
        echo "<td width=230>&nbsp;&nbsp;";
        echo "<a href=alert.php?l_id=".$list_row['l_id'].">";
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
        echo "<input $checked type=checkbox id=cb_".$list_row['l_id']." onclick=makeDefault('".$list_row['l_id']."')>&nbsp;Make it Default";
        //if($default_list != 1)
        //{ 
        //    echo "</a>";
        //}
        //else
        //    echo "</b>";
        echo "</td>";
        echo "</tr>";
        $list_c++;
    }
    echo "</table>"; 
     
}    
    
    
$user_id = $this_user;//1963;//2053;
$my_alerts_q = "SELECT * from exec_alert where user_id = $user_id";
//echo "<br>my_alerts_q: ".$my_alerts_q;
$my_alerts_res = com_db_query($my_alerts_q);
$alerts_rows = com_db_num_rows($my_alerts_res);

//echo "<br>number rows: ".$alerts_rows;
//$alerts_rows = 0;
if($alerts_rows > 0)
{    
    //$alerts_row = mysql_fetch_array($my_alerts_res);
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">My Alerts</h1>";
    echo "<table cellpadding=5 cellspacing=0 width=95% style=\"color:white;\">";
    echo "<tr><th width=60 style=text-align:left;>ID</th><th style=text-align:left;>Triggers</th><th width=20 0>Name</th><th>Action</th></tr>";
    while($alerts_row = com_db_fetch_array($my_alerts_res))
    {
        
        $trigger_details = '';
        if($alerts_row['mgt_change'] == 1)
            $trigger_details .= "Management Change,";
        if($alerts_row['speaking'] == 1)
            $trigger_details .= " Speaking,";
        if($alerts_row['awards'] == 1)
            $trigger_details .= " Awards,";
        if($alerts_row['publication'] == 1)
            $trigger_details .= " Publication,";
        if($alerts_row['media_mention'] == 1)
            $trigger_details .= " Media Mention,";
        if($alerts_row['board'] == 1)
            $trigger_details .= " Board,";
        if($alerts_row['jobs'] == 1)
            $trigger_details .= " Jobs,";
        if($alerts_row['fundings'] == 1)
            $trigger_details .= " Fundings,";
        
        $trigger_details = trim($trigger_details,",");
        $alert_name = $alerts_row['alert_name'];
        
        echo "<tr><td>";
        echo $alerts_row['alert_id'];
        echo "</td><td>$trigger_details</td>";

        echo "<td width=195>";
        echo "<form method=post><input type=hidden name=this_alert_id id=this_alert_id value=".$alerts_row['alert_id']."><input style=\"width:150px;color:black;\" type=text name=alert_name id=alert_name value=\"$alert_name\">&nbsp;<input style=\"color:black;\" type=submit name=name_sbt id=name_sbt value=Save></form>";
        echo "</td>";
        
        echo "<td>";
        echo "&nbsp;&nbsp;&nbsp;";
        echo "<a href=my-alerts.php?del_alert_id=".$alerts_row['alert_id'].">Delete</a>";
        echo "&nbsp;&nbsp;&nbsp;";
        echo "<a href=alert.php?alert_id=".$alerts_row['alert_id'].">Edit</a>";
        echo "</td>";
        
        echo "</tr>";
        //echo "<br>".$alerts_row;
        //echo "<pre>alerts_row: ";   print_r($alerts_row);   echo "</pre>";
    }
    echo "</table>";
}    

if(1 == 1)
{    
    $send_alerts_q = "SELECT * from hre_alert_send_info where user_id = $user_id order by info_id desc";
    //echo "<br>my_alerts_q: ".$my_alerts_q;
    $send_alerts_res = com_db_query($send_alerts_q);
    $send_alerts_rows = com_db_num_rows($send_alerts_res);
    //echo "<br>send_alerts_rows: ".$send_alerts_rows;

    $alerts_c = 1;
    
    echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Alert Emails</h1>";
    echo "<table cellpadding=5 cellspacing=0 width=95% style=\"color:white;margin-bottom:75px;\">";
    echo "<tr><th width=60 style=text-align:left;>Date</th><th style=text-align:left;>Action</th></tr>";
    
    while($send_alerts_row = com_db_fetch_array($send_alerts_res))
    {
        $disp = "";
        $hidden_class = "";
        
          
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
        echo "<tr><td $hidden_id_one style=text-align:left;$disp>".gmdate("Y-m-d", $send_alerts_row['sent_date'])."</td><td $hidden_id_two style=text-align:left;$disp><a target=blank href=alert-email-show.php?emailid=".$send_alerts_row['email_id'].">View</a></td></tr>";
        //echo "</div>";
        $alerts_c++;
    }  
    echo "<input type=hidden name=max_alert_id id=max_alert_id value=$alerts_c>";
    echo "</table>";
}



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








include("blue_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>