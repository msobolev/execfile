<?PHP
session_start();
function check_session()
{
if (!$_SESSION['sess_is_user'] || !$_SESSION['sess_user_id'])
    {
        header('Location: ' . 'index.php');
        exit;
    } 
    
}
check_session();

// todo 
// change page name in makedefault js function




$base_url = "http://hr.execfile.com/";
$login_page_flow = 0;

$root_url = "http://www.execfile.com/";

include("header.php"); 
com_db_connect_hre2();
recordTraffic('settings');
?>
<link rel="stylesheet" href="css/new_accounts_settings.css" />
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

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
    //alert("List ID:"+list_id); return false;
    
    //var lfckv = document.getElementById("cb_"+list_id).checked;
    
    //if(lfckv)
        window.location.href = "http://www.execfile.com/new_settings.php?l_id="+list_id;
    //else
    //    window.location.href = "http://www.execfile.com/new_settings.php?ul_id="+list_id;
}


function show_name_form(alert_id)
{
    document.getElementById('alert_name_form_'+alert_id).style.display = 'block';
    document.getElementById('alert_name_'+alert_id).style.display = 'none';
}

/*
function submit_form(e)
{
    alert(e.which);
}
*/
</script>    



<?PHP
$user_id = $_SESSION['sess_user_id'];

if(isset($_POST['alert_name_id']) && $_POST['alert_name_id'] != '')
{
    $upd_alert_q = "UPDATE exec_alert set alert_name = '".$_POST['alert_name']."' where alert_id = ".$_POST['alert_name_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_alert_q);
} 



if(isset($_GET['ul_id']) && $_GET['ul_id'] != '')
{
    $unc_undef_q = "UPDATE user_saved_lists set default_list = 0 where user_id = ".$user_id;
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($unc_undef_q);
}



if(isset($_GET['l_id']) && $_GET['l_id'] != '')
{
    $upd_undef_q = "UPDATE user_saved_lists set default_list = 0 where user_id = ".$user_id;
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_undef_q);
    
    
    $upd_def_q = "UPDATE user_saved_lists set default_list = 1 where l_id = ".$_GET['l_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_def_q);
}

if(isset($_GET['del_alert_id']) && $_GET['del_alert_id'] != '')
{
    $del_alert_q = "DELETE FROM exec_alert where alert_id = ".$_GET['del_alert_id'];
    //echo "<br>del_alert_q: ".$del_alert_q;
    com_db_query($del_alert_q);
}    
?>
<div class="main">
    <div class="content content--update">
        <section class="section-widgets">
            <header class="section__head">
                    <h2>Settings</h2>
            </header><!-- /.section__head -->
				
            <div class="section__body">
                <div class="cols">
                    <div class="col col--1of2">
                        <div class="widget-table widget-table--alt">
                            <header class="widget__head">
                                    <h3>My Alerts Emails:</h3>
                            </header><!-- /.widget__head -->
                            
                            <?PHP
                            $send_alerts_q = "SELECT alert_id,sent_date,email_id from hre_alert_send_info where user_id = $user_id order by info_id desc";
                            //$send_alerts_q = "SELECT * from hre_alert_send_info as s,exec_alert as a where a.alert_id = s.alert_id and a.user_id = $user_id order by info_id desc";
                            //echo "<br>my_alerts_q: ".$my_alerts_q;
                            $send_alerts_res = com_db_query($send_alerts_q);
                            $send_alerts_rows = com_db_num_rows($send_alerts_res);
                            ?>
                            <div class="widget__body">
                                <div class="widget__body-inner">
                                    <ul class="list-long">
                                        <?PHP
                                        $alert_send_counter = 1;
                                        if($send_alerts_rows > 0)
                                        {
                                            while($send_alerts_row = com_db_fetch_array($send_alerts_res))
                                            {
                                                
                                                // Getting alert name
                                                $alert_name = "";
                                                $alert_id = $send_alerts_row['alert_id'];
                                                $alert_name_q = "SELECT alert_name from exec_alert where alert_id = $alert_id";
                                                //$send_alerts_q = "SELECT * from hre_alert_send_info as s,exec_alert as a where a.alert_id = s.alert_id and a.user_id = $user_id order by info_id desc";
                                                //echo "<br>my_alerts_q: ".$my_alerts_q;
                                                $alert_name_res = com_db_query($alert_name_q);
                                                $alert_name_rows = com_db_num_rows($alert_name_res);
                                                if($alert_name_rows > 0)
                                                {    
                                                    $alert_row = com_db_fetch_array($alert_name_res);
                                                    $alert_name = $alert_row['alert_name'];
                                                }
                                                
                                                
                                                
                                                $alert_date = gmdate("d/m/Y", $send_alerts_row['sent_date']);
                                                
                                        ?>
                                        <li>
                                            <strong><?=$alert_send_counter?></strong>

                                            <p><?=$alert_date?></p>
                                            
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <p><?=substr($alert_name,0,25)?></p>
                                            
                                            <a class="btn-alt" target=blank href=alert-email-show.php?emailid=<?=$send_alerts_row['email_id']?>>View</a>
                                        </li>
                                        <?PHP
                                                $alert_send_counter++;
                                            }
                                        }    
                                        ?>
                                        


                                    </ul><!-- /.list-alerts -->
                                </div><!-- /.widget__body-inner -->
                            </div><!-- /.widget__body -->
                        </div><!-- /.widget-table -->
                    </div><!-- /.col col-/-1of2 -->

                    <div class="col col--1of2">
                        <div class="section__inner">
                            <div class="widget-table widget-table--alt">
                                <header class="widget__head">
                                        <h3>My Alerts:</h3>
                                </header><!-- /.widget__head -->

                                <?PHP
                                $my_alerts_q = "SELECT alert_name,alert_id from exec_alert where user_id = $user_id";
                                //echo "<br>my_alerts_q: ".$my_alerts_q;
                                $my_alerts_res = com_db_query($my_alerts_q);
                                $alerts_rows = com_db_num_rows($my_alerts_res);
                                ?>
                                
                                
                                
                                
                                
                                <div class="widget__body">
                                    <div class="widget__body-inner widget__body-inner--size-2">
                                        <ul class="list-long list-long--alt">
                                            <?PHP
                                            $alerts_counter = 1;
                                            if($alerts_rows > 0)
                                            {
                                                while($alerts_row = com_db_fetch_array($my_alerts_res))
                                                {
                                                    if($alerts_row['alert_name'] != '')
                                                        $alert_name = substr($alerts_row['alert_name'],0,12);
                                                    else
                                                        $alert_name = "Alert $alerts_counter";
                                                    
                                                    $alert_name = trim($alert_name);
                                            ?>
                                            
                                                    <li>
                                                        <strong><?=$alerts_counter?></strong>
                                                        <p id="alert_name_<?=$alerts_row['alert_id']?>">
                                                            <a href="javascript:void(0)"><span onclick="show_name_form('<?=$alerts_row['alert_id']?>')"><?=$alert_name?></span></a>
                                                            
                                                            
                                                            <a href="#">
                                                                <img src="css/images/edit.svg" alt="">
                                                            </a>
                                                        </p>
                                                        <form method="post" id="alert_name_form_<?=$alerts_row['alert_id']?>" style="display:none;"><input type="hidden" name="alert_name_id" id="alert_name_id" value="<?=$alerts_row['alert_id']?>"><input style="width:160px;" name="alert_name" id="alert_name" type="text"> <!--  onkeyup="submit_form(event)" -->  <!-- <span class="btn-alt">Update</span>--></form>
                                                        
                                                        
                                                        <aside class="list__aside">
                                                            <a href="alert.php?alert_id=<?=$alerts_row['alert_id']?>" class="btn-alt">Edit</a>

                                                            <a href="?del_alert_id=<?=$alerts_row['alert_id']?>" class="btn-alt btn-alt--dark">Delete</a>
                                                        </aside><!-- /.list__aside -->
                                                        
                                                        
                                                        
                                                        
                                                    </li>
                                            <?PHP
                                                    $alerts_counter++;
                                                }
                                            }    
                                            ?>
                                        </ul><!-- /.list-alerts -->
                                    </div><!-- /.widget__body-inner widget__body-inner-/-size-2 -->
                                </div><!-- /.widget__body -->
                        </div><!-- /.widget-table -->

                        <div class="widget-table widget-table--alt">
                                <header class="widget__head">
                                        <h3>My Saved Lists:</h3>
                                </header><!-- /.widget__head -->
                                
                                <?PHP
                                $my_saved_list_q = "SELECT * from user_saved_lists where user_id = $user_id";
                                //echo "<br>my_alerts_q: ".$my_alerts_q;
                                $my_saved_list_res = com_db_query($my_saved_list_q);
                                $saved_list_rows = com_db_num_rows($my_saved_list_res);
                                ?>
                                

                                <div class="widget__body">
                                        <div class="widget__body-inner widget__body-inner--size-3">
                                                <ul class="list-long list-long--radios">
                                                    
                                                    
                                                    <?PHP
                                                    $saved_list_counter = 1;
                                                    if($saved_list_rows > 0)
                                                    {
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

                                                            // Updated on 7th Sept 2018 to handle title levels
                                                            $title_level = $filter_arr[15];

                                                            $mweb = "";
                                                            if($list_row['websites_filter'] != '')
                                                            {
                                                                $mweb = $list_row['l_id'];
                                                            }  
                                                            $list = $list_row['l_id'];
                                                            $list_link = $root_url."home.php?from_date=&to_date=&type=$this_type&zip=$zip_code&city=$city&industries=$industry_ids&states=$state_ids&revenue=$revenue&employee_size=$employee_size&companyval=&title_level=$title_level&mweb=$mweb&list=$list";
                                                            $list_name = $list_row['list_name'];
                                                            
                                                            if($list_name == '')
                                                            {
                                                                $list_name = "List ".$saved_list_counter;
                                                            }    
                                                            
                                                            $default_list = $list_row['default_list'];
                                                        
                                                            $checked = "";
                                                            if($default_list == 1)
                                                            {
                                                                $checked = "checked";
                                                            //    echo "<a href=settings.php?l_id=".$list_row['l_id'].">";
                                                            }
                                                        
                                                            
                                                            
                                                    ?>
                                                    
                                                    <li>
                                                        <strong><?=$saved_list_counter?></strong>

                                                        <p>
                                                            <a href="<?=$list_link?>"><?=$list_name?></a>

                                                            <a href="<?=$root_url?>alert.php?l_id=<?=$list_row['l_id']?>">
                                                                <img src="css/new_images/edit.svg" alt="">
                                                            </a>
                                                        </p>

                                                        <aside class="list__aside">
                                                            <div class="radio-alt">
                                                                <input  id="radio-default-1" type="radio"  name="radio-default" <?=$checked?> />  <!--  -->

                                                                <label onclick="makeDefault('<?=$list_row['l_id']?>')" for="radio-default-1">
                                                                        <span>Make default</span>

                                                                        <span>Default</span>
                                                                </label>
                                                            </div><!-- /.radio -->
                                                        </aside><!-- /.list__aside -->
                                                    </li>
                                                <?PHP
                                                    $saved_list_counter++;
                                                    }
                                                }
                                                ?>
                                                        
                                                </ul><!-- /.list-alerts -->
                                        </div><!-- /.widget__body-inner widget__body-inner-/-size-3 -->
                                </div><!-- /.widget__body -->
                        </div><!-- /.widget-table -->
                    </div><!-- /.section__inner -->
                </div><!-- /.col col-/-1of2 -->
                </div><!-- /.cols -->
            </div><!-- /.section__body -->
			</section><!-- /.section-widgets -->
		</div><!-- /.content -->
    
    
    
    
    
    
</div><!-- /.main -->
    
<?PHP 
include("footer.php"); 
?>
