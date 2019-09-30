<?PHP
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
*/

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

$base_url = "http://hr.execfile.com/";
$login_page_flow = 0;



//echo "<pre>session:";   print_r($_SESSION);   echo "</pre>";
$user_site = $_SESSION['site'];
if($user_site == '')
    $user_site = 'hr';
//die();

include("header.php"); 
com_db_connect_hre2();

recordTraffic('accounts');
//com_db_connect_hre2() or die('Unable to connect to database server!');

//$site = mysql_connect("localhost","root","ecbu4!!exlmnnb",TRUE) or die("Database ERROR ".mysql_error());
//mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");


//echo "<pre>";   print_r($_SESSION);   echo "</pre>";

function this_user_invoices($user_id,$invoice_table)
{
    $invoice_dates = array();
    //$find_invoices_query = com_db_query("select * from ".TABLE_INVOICES." where user_id='".$_SESSION['sess_user_id']."' and appear_date <= now()");
    
    //echo "<br>select * from $invoice_table where user_id  = '".$user_id."'";
    
    $find_invoices_query = com_db_query("select * from $invoice_table where user_id  = '".$user_id."'");
    if($find_invoices_query)
    {
        $invoice_num = com_db_num_rows($find_invoices_query);
        //echo "".;
        if($invoice_num > 0)
        {
            //$invoice_row = com_db_fetch_array($find_invoices_query);
            while ($invoice_row = com_db_fetch_row($find_invoices_query)) 
            {        
                //echo "<pre>invoice_row: ";	print_r($invoice_row);	echo "</pre>";
                
                $display_name = $invoice_row[3]; // 'display_name'
                
                $invoice_dates[] = $display_name;
                
            }
        }
    }
    //echo "<pre>invoice_dates: ";	print_r($invoice_dates);	echo "</pre>";
    return $invoice_dates;
}



$user_id = $_SESSION['sess_user_id'];
$user_site = $_SESSION['site'];
if(isset($_POST['edit_account']) && $_POST['edit_account'] == 1)
{
    
    $email = $_POST['user_email'];
    
    if($email != '')
    {
        com_db_query("UPDATE ".TABLE_USER." set email='".$email."' where user_id = ".$user_id);	
        //$msg = "You successfully changed your password.";            
    }        
    
    
    $new_password = $_POST['new_pass'];
    $re_new_password = $_POST['re_new_pass'];
    if($new_password != '' && $re_new_password != '')
    {
        if($new_password == $re_new_password)
            com_db_query("UPDATE ".TABLE_USER." set password='".$new_password."' where user_id = ".$user_id);	
    }
    
    
    /*
    $user_query = "select * from " . TABLE_USER ." where email = '".$email."' and user_id = ".$this_user;
    //echo "<br>user_query: ".$user_query; 
    $user_result = com_db_query($user_query);
    if($user_result)
    {
        $row_count = com_db_num_rows($user_result);
        if($row_count > 0)
        {
            com_db_query("UPDATE ".TABLE_USER." set password='".$password."' where email ='".$email."' and user_id = ".$this_user);	
            $msg = "You successfully changed your password.";            
        }
        else
        {
            $msg = "No user exists with this email address.";            
        }    
    }
    else
    {
        $msg = "No user exists with this email address.";            
    }
    
     */    
    //add_user($first_name,$email,1,$last_name,'Request a demo');
    //$msg = "You successfully changed your password.";
}


if(isset($_POST['edit_image']) && $_POST['edit_image'] == 1)
{
    //echo "<pre>";   print_r($_FILES);   echo "</pre>";
    
    $image = $_FILES['fileInput']['tmp_name'];
    //echo "<br>Image:".$image;
    if($image!='')
    {
        //echo "<br>within if one";
        if(is_uploaded_file($image))
        {
            //echo "<br>within if two";
            $org_img = $_FILES['fileInput']['name'];
            $exp_file = explode("." , $org_img);
            $get_ext = $exp_file[count($exp_file) - 1];
            //echo "<br>get_ext:".$get_ext;
            if(strtolower($get_ext)=="jpg" || strtolower($get_ext)=="gif" || strtolower($get_ext)=="jpeg" || strtolower($get_ext)=="png")
            {
                //echo "<br>within if three";
                $new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);

                //echo "<br>new_exp_file:".$new_exp_file;

                $org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
                $destination_image = 'personal_photo/' . $org_image_name;
                if(move_uploaded_file($image , $destination_image))
                {
                 
                    //echo "<br>within if four";
                    
                    //$query = "INSERT into hre_temp_personal_photo(row_id,image_name) values('2','".$org_image_name."') ";
                    //com_db_query($query);
                }
            }	
        }	
    }
    
    
    
}



$user_query = "select first_name,last_name,email from " . TABLE_USER ." where user_id = '".$user_id."'";
//echo "<br>user_query: ".$user_query; 
$user_result = com_db_query($user_query);


$row_count = com_db_num_rows($user_result);
//echo "<br>row_count:".$row_count;

//if($row_count > 0)
//{
    
    $user_row = com_db_fetch_row($user_result); 
    
    //echo "<pre>user row:";   print_r($user_row);   echo "</pre>";
    $first_name = $user_row[0];
    $last_name = $user_row[1];
    $email = $user_row[2];
//}

?>
<link rel="stylesheet" href="css/new_accounts_settings.css" />
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

        <script src="js/new_functions.js"></script> 
        
<style>
    .section-large .section__head h2 { margin-bottom: 0; font-family: 'Open Sans'; font-size: 36px; letter-spacing: 0.03em; }
.section-large .section__head h2 + h2 { display: none; }

.section-large .section__head h2 span { font-size: 36px; color: #14c2ed; font-weight: 400; }

</style>
<script language="javascript">
    
   function chooseFile() {
      $("#fileInput").click();
   }


function sumbitImageForm()
{
    //alert("heree");
    //document.getElementById(form_id).submit();
    //$(".uploadimage").submit();
    $("#image_form").submit();
}


function show_heading()
{
    document.getElementById('account_editing').style.display = 'block';
    //document.getElementById('account_').style.display = 'none';
}


function hide_heading()
{
    document.getElementById('account_editing').style.display = 'none';
    //document.getElementById('account_').style.display = 'none';
}


</script>    
<div class="main">
    
    <div class="content content--update">
			<section class="section-large">
				<header class="section__head">
					<h2 id="account_">
						Account

						<a onclick="show_heading()" href="#" class="btn-alt js-class" data-type="add" data-target=".section-large" data-class="section-large--edit">Edit</a>
					</h2>
					
					<h2 id="account_editing">
						Account /

						<span>Editing</span>
					</h2>
				</header><!-- /.section__head -->

				<div class="widget-account">
					<div class="widget__image">
						<div style="display:none;" class="widget__icon">
							<img src="css/images/account.svg" alt="" width="60">

                                                        
                                                        <!-- My code -->
                                                        <form method="post" name="image_form" id="image_form">
                                                            <div style="height:0px;overflow:hidden">
                                                                <input onchange="sumbitImageForm()" type="file" id="fileInput" name="fileInput" />
                                                            </div>
                                                        
                                                            <span  onclick="chooseFile();"></span>
                                                            <input type="hidden" id="edit_image" name="edit_image" value="1">
                                                        </form>
						</div><!-- /.widget__icon -->
					</div><!-- /.widget__image -->

					<div class="widget__content">
						<div class="widget__entry">
							<h4>Name:</h4>
						
							<p><?=$first_name?> <?=$last_name?></p>
						
							<h4>Subscription:</h4>
						
							<p>Basic</p>
						</div><!-- /.widget__entry -->
						
						<div class="widget__entry">
							<h4>Email:</h4>
						
							<p><?=$email?></p>
						
							<h4>Password:</h4>
						
							<p>**********</p>
						</div><!-- /.widget__entry -->
					</div><!-- /.widget__content -->

					<div class="widget__content">
						<div class="form-small">
							<form action="?" method="post">
                                                            <div class="form__row">
                                                                    <label for="field-112#" class="form__label">Email:</label>

                                                                    <div class="form__controls">
                                                                            <input type="email" class="field" name="user_email" id="field-112#" value="" placeholder="Enter your email">
                                                                    </div><!-- /.form__controls -->
                                                            </div><!-- /.form__row -->

                                                            <div class="form__row">
                                                                    <label for="new_pass" class="form__label">Password:</label>

                                                                    <div class="form__controls">
                                                                        <input type="password" class="field" name="new_pass" id="new_pass" value="" placeholder="Type new password">
                                                                        <input type="password" class="field" name="re_new_pass" id="re_new_pass" value="" placeholder="Re-type new password">
                                                                    </div><!-- /.form__controls -->
                                                            </div><!-- /.form__row -->

                                                            <div class="form__actions">
                                                                    <button type="submit" class="btn-alt form__btn">Save</button>

                                                                    <a onclick="hide_heading()" href="#" class="js-class" data-type="remove" data-target=".section-large" data-class="section-large--edit">Cancel</a>
                                                            </div><!-- /.form__actions -->
							<input type="hidden" id="edit_account" name="edit_account" value="1">
                                                        </form>
						</div><!-- /.form -->
					</div><!-- /.widget__content -->
				</div><!-- /.widget-account -->

                                
                                
                                <?PHP
                                 
                                    
                                    if($user_site == 'hr' || $user_site == '')
                                    {    
                                        $invoice_table = 'hre_saved_invoices';
                                        $invoice_user_table = 'hre_invoices';
                                        $file_base = "https://www.hrexecsonthemove.com/";
                                    }  
                                    elseif($user_site == 'ciso')
                                    {    
                                        $invoice_table = 'ciso_saved_invoices';
                                        $invoice_user_table = 'ciso_invoices';
                                        $file_base = "https://www.cisosonthemove.com/";
                                    } 
                                    elseif($user_site == 'cmo')
                                    {    
                                        $invoice_table = 'cmo_saved_invoices';
                                        $invoice_user_table = 'cmo_invoices';
                                        $file_base = "https://www.cmossonthemove.com/";
                                    }    
                                    elseif($user_site == 'clo')
                                    {    
                                        $invoice_table = 'clo_saved_invoices';
                                        $invoice_user_table = 'clo_invoices';
                                        $file_base = "https://www.closonthemove.com/";
                                    }    
                                    elseif($user_site == 'cto')
                                    {    
                                        $invoice_table = 'cto_saved_invoices';
                                        $invoice_user_table = 'cto_invoices';
                                        $file_base = "https://www.ctosonthemove.com/";
                                    }    
                                    
                                    
                                    
                                    
                                    
                                        $get_user_q = "SELECT user_id from ".$invoice_user_table." where email = '".strtolower($_SESSION['sess_email'])."'";
                                        //echo "<br>get_user_q: ".$get_user_q;
                                        $get_user_res = com_db_query($get_user_q);
                                        $num_of_usr = com_db_num_rows($get_user_res);
                                        //echo "<br>num_of_usr: ".$num_of_usr;
                                        //if($num_of_usr > 0)
                                        //{    
                                        $user_row = com_db_fetch_row($get_user_res, MYSQL_ASSOC);
                                        //echo "<pre>user row: ";   print_r($user_row);   echo "</pre>";   
                                        $this_usr = $user_row[0];
                                        //$this_usr_email = $user_row[1];
                                        //echo "<br>this_usr_email: ".$this_usr_email;
                                        //echo "<pre>user_row: ";   print_r($user_row);   echo "</pre>";   

                                        /*
                                        $user_invoices = this_user_invoices($this_usr,$invoice_table);
                                        echo "<pre>this_user_invoices: ";   print_r($user_invoices);   echo "</pre>";   
                                        $invoices_count = count($user_invoices);
                                        echo "<br>invoices_count: ".$invoices_count;

                                         */

                                        //echo "<br>this_usr:".$this_usr;
                                        if($this_usr != '')
                                            $all_invoice = "select user_id, start_date AS sd, pdf_file,'from_exec' AS server from exec_invoices where user_id = ".$user_id." UNION select user_id, display_name AS sd, invoice_file,'from_other' AS server from $invoice_table where user_id  = '".$this_usr."' ORDER BY sd DESC "; // getting invoices from execfile DB with execfile user_id
                                        else
                                            $all_invoice = "select user_id, start_date AS sd, pdf_file,'from_exec' AS server from exec_invoices where user_id = ".$user_id.""; // getting invoices from execfile DB with execfile user_id
                                        //echo "<br>all_invoice:".$all_invoice;
                                        //die();
                                        //$find_invoices_query = com_db_query("select * from $invoice_table where user_id  = '".$this_usr."'");
                                        $find_invoices_query = com_db_query($all_invoice);
                                        $invoice_num = com_db_num_rows($find_invoices_query);
                                        //echo "<br>invoice_num:".$invoice_num;

                                        if($invoice_num > 0)
                                        {
                                        ?>
                                            <div style="margin-bottom:25px;" class="widget-table">
                                                <header class="widget__head">
                                                    <h3>Invoices:</h3>
                                                </header><!-- /.widget__head -->

                                                <div class="widget__body">
                                                    <div class="widget__body-inner">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th>Date</th>
                                                                    <!-- <th>Total</th> -->
                                                                    <th>Invoice</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>

                                                            <?PHP
                                                            $invoice_counter = 1;
                                                            //while($invoice_row = com_db_fetch_array($invoices_res))
                                                            //while($invoice_row = $user_invoices)
                                                            while ($invoice_row = com_db_fetch_row($find_invoices_query)) 
                                                            {
                                                                $server = $invoice_row[3];
                                                                if($server == 'from_exec')
                                                                    $file_real_base = 'https://www.execfile.com/invoices/';
                                                                elseif($server == 'from_other')
                                                                    $file_real_base = $file_base."vsword/invoices/";


                                                                //echo "<pre>invoice_row: ";   print_r($invoice_row);   echo "</pre>";   
                                                                //echo "<br>file_real_base:".$file_real_base;

                                                                //echo "<br><br>file_real_base:".$file_real_base.$invoice_row[2];
                                                                //echo "<br>File Exists:".file_exists("/var/www/html/vsword/invoices/".$invoice_row[2]);
                                                                //if(file_exists($file_real_base.$invoice_row[2]))
                                                                //{        

                                                            ?>
                                                                <tr>
                                                                    <td width="50"><?=$invoice_counter?></td>
                                                                    <td width="160">
                                                                    <?PHP
                                                                        $invoice_date = '';
                                                                        if($invoice_row[1] != '0000-00-00')
                                                                            echo date('m/d/y',strtotime($invoice_row[1])); // date
                                                                        else
                                                                            echo "";
                                                                    ?>
                                                                    </td> <!-- 11/4/2018 -->
                                                                    <!-- <td>$767.00</td> -->
                                                                    <td>
                                                                        <img src="css/images/paperclip.svg" alt="" width="14">
                                                                        <a href="<?=$file_real_base?><?=$invoice_row[2]?>">download</a>
                                                                    </td>
                                                                </tr>
                                                            <?PHP

                                                                $invoice_counter++;
                                                                //}
                                                            }
                                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /.widget__body-inner -->
                                                </div><!-- /.widget__body -->
                                            </div><!-- /.widget-table -->
                                    <?PHP
                                    }
                                    //}
                                
                                
                                
                                
                                
                                    //if($user_site == 'hr' || $user_site == '')
                                    //{
                                
                                    $report_file_real_base = 'https://www.execfile.com/reports/';
                                    //$all_reports = "select * from exec_reports where user_id = ".$user_id." "; // getting invoices from execfile DB with execfile user_id

                                    $all_reports .= "select * from exec_monthly_reports where site = '".$user_site."' order by r_id desc;";

                                    //echo "<br>all_reports:".$all_reports;
                                    //die();
                                    //$find_invoices_query = com_db_query("select * from $invoice_table where user_id  = '".$this_usr."'");
                                    $find_reports_query = com_db_query($all_reports);
                                    $reports_num = com_db_num_rows($find_reports_query);

//echo "<br>reports_num:".$reports_num;
                                    if($reports_num > 0)
                                    {
                                        $reports_counter = 1;
                                    ?>
                                        <div style="margin-bottom:25px;"  class="widget-table">
                                            <header class="widget__head">
                                                <h3>Monthly Reports:</h3>
                                            </header><!-- /.widget__head -->

                                            <div class="widget__body">
                                                <div class="widget__body-inner">
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th>Date</th>
                                                                <!-- <th>Total</th> -->
                                                                <th>Report</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>

                                                        <?PHP
                                                        while ($report_row = com_db_fetch_array($find_reports_query)) 
                                                        {

                                                            //echo "<pre>report_row:";   print_r($report_row);   echo "</pre>";
                                                            $report_file_name = $user_site.'-'.$report_row['date'].".xls";
                                                            if(file_exists('reports/'.$report_file_name))
                                                            {
                                                        ?>

                                                                <tr>
                                                                    <td><?=$reports_counter?></td>
                                                                    <td>
                                                                    <?PHP
                                                                        //echo date('m/y',strtotime($report_row['date'])); // date
                                                                        echo str_replace("-","/",$report_row['date']); // date
                                                                    ?>
                                                                    </td> <!-- 11/4/2018 -->
                                                                    <!-- <td>$767.00</td> -->
                                                                    <td>
                                                                        <img src="css/images/paperclip.svg" alt="" width="14">
                                                                         <a href="<?=$report_file_real_base?><?=$report_file_name?>">download</a>
                                                                    </td>
                                                                </tr>
                                                        <?PHP
                                                                $reports_counter++;
                                                            }
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div><!-- /.widget__body-inner -->
                                        </div><!-- /.widget__body -->
                                    </div><!-- /.widget-table -->


                                    <?PHP
                                    }    
                                
                                
                                
                                
                                //}
                                
                                ?>
			</section><!-- /.section-large -->
		</div><!-- /.content -->
    
    
</div><!-- /.main -->
    
<?PHP 
include("footer.php"); 
?>
