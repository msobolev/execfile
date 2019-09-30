<!-- <link rel="stylesheet" href="../css/home_style.css" /> -->
<link rel="stylesheet" href="../css/admin_style.css" />
<style>
.form-row    
{
    margin-bottom:10px;
}
</style>
<script language="javascript">
function check_mandatory()
{
    var start_date = document.getElementById('start_date').value;
    if(start_date == '')
    {
        alert("Start date is mandatory field");
        return false;
    }    
}
</script>
<?php
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
 */


/*
if(isset($_GET['datee']))
    $mydate = $_GET['datee'];
else
    $mydate = '2018-10-20';

echo "<br>Mydate:".$mydate;

$month = date("m",strtotime($mydate));
echo "<br>Month:".$month;
die();
*/

require('../functions.php');
require('../config.php');

require('admin_header.php');

//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

$btn_val = "User Invoice";
$action = "update";
$user_details = array();

$user_id = $_GET['user_id'];

//if((isset($_POST['field-name']) && $_POST['field-name'] != '') && (isset($_POST['field-email']) && $_POST['field-email'] != ''))

 
//echo "<pre>GET:";   print_r($_GET);   echo "</pre>";
//echo "<pre>POST:";   print_r($_POST);   echo "</pre>";
if(isset($_GET['action']) && $_GET['action'] == 'update')
{
    
    
    //echo "<br>Within If one";
    $start_date = $_POST['start_date'];
    
    $amount = $_POST['amount'];
    $method = $_POST['method'];
    
    
    
    
    $month = "";
    if($start_date != '')
    {    
        $month = date("m",strtotime($start_date));
        $year = date("y",strtotime($start_date));
    }

    //$start_date = date("Y-m-d", strtotime($start_date));
    $pdf_file = $_FILES['pdf_file']['tmp_name'];
    $custom_file_name = $user_id."-invoice-".$month."-".$year.".pdf";
    $destination_image = '../invoices/' . $custom_file_name;
    //echo "<br>destination_image:".$destination_image;
    //echo "<br>pdf_file:".$pdf_file;
    if($pdf_file!='')
    {
        //echo "<br>Within If two";
        if(is_uploaded_file($pdf_file))
        {
            //echo "<br>Within If three";
            if(move_uploaded_file($pdf_file , $destination_image))
            {
                //echo "<br>Within If four";
                    $insert_query = "INSERT into exec_invoices(user_id,pdf_file,start_date,amount,method,file_uploaded) values('$user_id','$custom_file_name','$start_date','$amount','$method','1')";
                //echo "<br>insert_query: ".$insert_query; 
                    $insert_result = com_db_query($insert_query);
                
                
                
            }
        }
    }
    else
    {    
        $insert_query = "INSERT into exec_invoices(user_id,pdf_file,start_date,amount,method,starting_point) values('$user_id','','$start_date','$amount','$method','1')";
        //echo "<br>insert_query: ".$insert_query; 
        $insert_result = com_db_query($insert_query);
    }    
    
}
?>
<h2 style="padding-left:20px;">Add User Invoice</h2>

<?PHP
if($msg != '')
{    
?>
    <h3><?=$msg?></h3>
<?PHP
}
?>
<div style="padding-left:20px;" class="form-sing-up">
    <form action="?action=<?=$action?>&user_id=<?=$user_id?>" method="post"  enctype="multipart/form-data" onsubmit="return check_mandatory();">
        <input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>">
        <div class="form-body form-company">
            <div class="form-row">
                <label for="field-name" class="form-label hidden">First Name </label>

                <div class="form-controls">
                    <i class="ico-user"></i>    <!-- user for mysqli $user_details->first_name -->
                    <input type="file" class="field" name="pdf_file" id="pdf_file" value="<?=$user_details['first_name']?>">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Start Date</label>

                <div class="form-controls">
                    <input type="text" class="field" name="start_date" id="start_date" placeholder="Start Date">&nbsp(Format:yyyy-mm-dd)
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Amount</label>

                <div class="form-controls">
                    <input type="text" class="field" name="amount" id="amount" placeholder="Amount">
                </div><!-- /.form-controls -->
            </div><!-- /.form-row -->
            
            <!--
            <div class="form-row">
                <label for="field-email" class="form-label hidden">Payment Method</label>

                <div class="form-controls">
                    <select name="payment_method" id="payment_method" style="width:173px;">
                            <option <?PHP //if($payment_method == 'credit_card') echo "selected"; else echo ""; ?> value="credit_card">Credit Card</option>
                            <option <?PHP //if($payment_method == 'wire_transfer') echo "selected"; else echo ""; ?> value="wire_transfer">Wire Transfer</option>
			</select>
                </div>
            </div>
            -->
            
            
            
            
        </div><!-- /.form-body -->

        <div class="form-actions">
            <input type="submit" value="Update" class="form-btn"> <!--  onclick="return filter_email();" -->
        </div><!-- /.form-actions -->
    </form>
    
    
    <?PHP
    $user_invoices_query = "select * from exec_invoices where user_id = '".$user_id."' and starting_point = 0 order by start_date desc;";
    //echo "<br>user_query: ".$user_query; 
    $user_invoices_result = com_db_query($user_invoices_query);
    $invoice_count = com_db_num_rows($user_invoices_result);
    if($invoice_count > 0)
    {
        ?>
        <br><br>
        <h2 style="padding-left:20px;">User Invoice</h2>
        <table style="margin-bottom:50px;border:1px solid #CCCCCC;" width="70%" cellpadding="5">
            <tr>
                <th>Start Date</th>
                <th>PDF File</th>
            </tr> 
            <?PHP
        
        
        //for($i=0;$i<$invoice_count;$i++)
        while($invoice_row = com_db_fetch_row($user_invoices_result))
        {
            //echo "<pre>invoice_row";   print_r($invoice_row);   echo "</pre>";
    ?>
            <tr>
                <td style="text-align: center;"><?=$invoice_row[3]?></td>
                <td style="text-align: center;">
                    <!-- <a href="http://www.execfile.com/invoices/<?=$invoice_row[1]?>"> -->
                        <?=$invoice_row[1]?>
                    <!-- </a></td> -->
            </tr>    
    
    <?PHP
        }
    ?>
    </table>
    <?PHP    
    }
    ?>
</div><!-- /.form-sing-up -->