<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include("functions.php");
include("config.php");
require('fpdf/fpdf.php');
include("common_functions.php");


com_db_connect_hre2() or die('Unable to connect to database server!');

$font_family = 'Arial';
$font_size = '10';
$break_height_big = '9';
$break_height = '5';


$invoice_static_details = com_db_query("select * from hre_invoices_static_details");
$invoiceStaticRow = com_db_fetch_row($invoice_static_details);
echo "<pre>invoiceStaticRow:";   print_r($invoiceStaticRow);   echo "</pre>";
$site_website = $invoiceStaticRow[1];
$site_address = $invoiceStaticRow[2];
$site_city = $invoiceStaticRow[3];
$site_zip_code = $invoiceStaticRow[4];
$payable_to_name = $invoiceStaticRow[7];

$from_name = $invoiceStaticRow[5];
$from_title = $invoiceStaticRow[6];

echo "<br>From Name:".$from_name;
echo "<br>From Title:".$from_title;




$user_invoices_query = "select * from exec_invoices as i, exec_user as u where i.user_id = u.user_id and i.starting_point = 1";
//echo "<br>user_query: ".$user_query; 
$user_invoices_result = com_db_query($user_invoices_query);
$invoice_count = com_db_num_rows($user_invoices_result);
if($invoice_count > 0)
{
    while($invoice_row = com_db_fetch_row($user_invoices_result))
    {
        
        //if($invoice_row[3])
        
        //echo "<pre>invoice_row:";   print_r($invoice_row);   echo "</pre>";
        //die();
        $invoice_start_date = $invoice_row[3];
        $user_id = $invoice_row[2];
        
        $user_email = $invoice_row[12];
        
        $to_name = $invoice_row[5];
        
        $start_month = date("m",strtotime($invoice_start_date));
        
        $start_day = date("d",strtotime($invoice_start_date));
        $start_year = date("y",strtotime($invoice_start_date));
        
        echo "<br>start_month:".$start_month;
        $todays_month = date('m');
        echo "<br>todays_month:".$todays_month;
        
        $first_invoice = $user_id."-invoice-".$start_month."-".$start_year.".pdf";
        
        
        $d1 = new DateTime($invoice_start_date);
        $d2 = new DateTime(date("Y-m-d"));
        //$d2 = new DateTime($due_date);
        $no_of_months = $d1->diff($d2)->m;
        $interval = $d1->diff($d2);
        $diff_y = $d1->diff($d2)->y;

        if($diff_y > 0 && $no_of_months != 12)
        {
            $months_in_years = 12*$diff_y;
            $no_of_months = $no_of_months+$months_in_years;
        }


        echo "<br>only years: ".$diff_y;
        echo "<br>no of months: ".$no_of_months."<br>";
        
        
        for($i=0;$i<=$no_of_months;$i++)
        {
            $next_month = $start_month+$i;
            $check_already_invoice = $user_id."-invoice-".$next_month."-".$start_year.".pdf";
            
            echo "<br>check_already_invoice: ".$check_already_invoice."<br>";
            
            if(file_exists('invoices/'.$check_already_invoice))
            {        
                echo "<br>Exists: ".$check_already_invoice ;
            }    
            else
            {    
                echo "<br>first_invoice:".$first_invoice;
                echo "<br>check_already_invoice:".$check_already_invoice;
                
                $file_name = $check_already_invoice;
                
                
                //echo "<br>Don't Exists: ".$check_already_invoice ;
                
                
                
                $due_date = $start_day."/".$next_month."/20".$start_year;
                
                // Todo - update these values 
                $invoice_no = "111";
                $to_title = "Temp Title";
                $to_company_name = "NBB"; 
                $to_address = "455";
                $to_city = "LHR";
                $to_state = "PUN";
                $to_zip_code = "54333";
                $payment_method = 'credit_card';
                $payment_amount = '477';
                
                // Generating Invoice
                $output = "";
                    $output .= "<html>";
                    $output .= "<body style=font-size:10pt;>";
                    //$output .= "<div width=300px align=center style=\"\"><span style=\"color:#CDCDCD;font-size:24px;\">".$site_website."</span><br><strong>INVOICE # $invoice_no</strong></div><br>";

                    //$output .= "<div width=300px align=center><span style=color:#CDCDCD;font-size:24px;><font size=24px>".$site_website."</font></span><br><br><strong>INVOICE # $invoice_no</strong></div><br>";
                    $output .= "<center><span style=font-size:17px;color:#999999>".$site_website."</span><hr><br><b>INVOICE # $invoice_no</b></center><br>";
                    $output .= "<b>TO:</b><br><br>";
                    if($to_name != '')
                        $output .= "$to_name<br>";
                    if($to_title != '')
                        $output .= "$to_title<br>";	
                    if($to_company_name != '')	
                        $output .= "$to_company_name<br>";
                    if($to_address != '')		
                        $output .= "$to_address<br>";
                    if($to_city != '')		
                        $output .= "$to_city, ";
                    if($to_state != '')		
                        $output .= "$to_state";
                    if($to_zip_code != '')		
                        $output .= " $to_zip_code<br>";	

                   

                    $output .= "<div style=\"float:left;width:400px;border:none;\"><br><br><b>FROM:</b><br>";
                    if($from_name != '')
                        $output .= "<br>".$from_name."";
                    if($from_title != '')
                        $output .= "<br>".$from_title."";
                    if($site_website != '')
                        $output .= "<br>".$site_website."";
                    if($to_address != '')
                        $output .= "<br>".$to_address."";
                   if($to_city != '')
                        $output .= "<br>".$to_city.", ".$to_state." ".$to_zip_code."";

                    $output .= "</div>";
                    $output .= "<div style=\"float:left;width=150;height:300px;border:none;\">";
                    // Tdoo - undo
                    //$output .= "<img border=0 width=166 height=145 src=https://www.hrexecsonthemove.com/vsword/img1.jpg>";
                    $output .= "</div>";


                    //$output .= "<div style=\"float:left;border:1px solid;width=100%;\">";

                    $output .= "<br><b>RE:</b><br><br>";
                    //echo "Subscription to $site_website - ".date("M")." ".date("o");
                    $output .= "Subscription to $site_website - ".$month." ".$year;
                    $output .= "<br><br><b>PAYMENT AMOUNT:</b><br>";
                    $output .= "<br>US$".$payment_amount." / month";
                    $output .= "<br><br><b>PAYMENT DUE:</b><br><br>";
                    $output .= $due_date."";
                    $output .= "<br><br><b>PAYMENT METHOD:</b><br><br>";
                    $output .= str_replace("_"," ",$payment_method)."";
                    $output .= "<br><br><b>PAYABLE TO:</b><br><br>";
                    if($payable_to_name != '')
                        $output .= $payable_to_name."<br>";
                    if($site_address != '')
                        $output .= $site_address."<br>";
                    if($site_city != '')
                        $output .= $site_city.", ";
                    if($site_zip_code != '')
                        $output .= $site_zip_code;
                    $output .= "<br><br><b>SUBSCRIPTION LEVEL:</b><br><br>Premium Subscription, including:<br>";
                    $output .= "<br>- Full Search functionality of CHROs, and other HR executives on the sales lead database";
                    $output .= "<br>- Full download  functionality";
                    $output .= "<br>- 1 monthly summary update on management changes among CHROs, VPs and Directors of HR";
                    $output .= "<br><br><br><br><br><br><br><center>".$site_website."<br>".$site_address."<br>".$site_city.", ".$site_zip_code."</center>";
                    //$output .= "</div>";
                    $output .= "</body>";
                    $output .= "</html>";
                    echo "<br><br>Output: ".$output;
                
                    $pdf = new FPDF();
                    $pdf->AddPage();


                    $pdf->SetTextColor(36,36,36);
                    $pdf->SetFont($font_family,'',17);
                    $pdf->Cell(0,0,$site_website,0,0,'C');
                    $pdf->SetLineWidth(1);
                    $pdf->line(0,14,500,14);

                    $pdf->SetTextColor(0,0,0);
                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Ln($break_height_big);
                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'INVOICE # '.$invoice_no,0,0,'C');
                    $pdf->Ln($break_height_big);
                    $pdf->SetFont($font_family,'',$font_size);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'TO:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,$to_name,0,0,'L');
                    $pdf->Ln($break_height);


                    $pdf->Cell(0,0,$to_title,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$to_company_name,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$to_address,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$to_city.', '.$to_state." ".$to_zip_code,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Ln($break_height_big);


                    
                    $pdf->Image('images/invoice_paid.jpg',140,50,0,0,'JPG');
                    




                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'FROM:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,$from_name,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$from_title,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$site_website,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$to_address,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$to_city.", ".$to_state." ".$to_zip_code,0,0,'L');

                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'RE:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,'Subscription to '.$site_website." - ".date("M")." ".date("o"),0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'PAYMENT AMOUNT:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,'US$'.$payment_amount,0,0,'L');
                    //$pdf->Ln($break_height);

                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'PAYMENT DUE:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,$due_date,0,0,'L');
                    $pdf->Ln($break_height_big);

                    //$pdf->Ln($break_height_big);
                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'PAYMENT METHOD:',0,0,'L');
                    //$pdf->Ln($break_height);

                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,str_replace("_"," ",$payment_method),0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'PAYABLE TO:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,$payable_to_name,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,$site_address,0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0, $site_city.", ".$site_zip_code,0,0,'L');


                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'B',$font_size);
                    $pdf->Cell(0,0,'SUBSCRIPTION LEVEL:',0,0,'L');
                    $pdf->Ln($break_height_big);

                    $pdf->SetFont($font_family,'',$font_size);
                    $pdf->Cell(0,0,'Premium Subscription, including:',0,0,'L');

                    $pdf->Ln($break_height_big);

                    $pdf->Cell(0,0,'- Full Search functionality of CHROs, and other HR executives on the sales lead database',0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,'- Full download  functionality',0,0,'L');
                    $pdf->Ln($break_height);

                    $pdf->Cell(0,0,'- 1 monthly summary update on management changes among CHROs, VPs and Directors of HR',0,0,'L');
                    $pdf->Ln($break_height);


                    $pdf->Ln('20');

                    $pdf->SetLineWidth(1);
                    $pdf->line(40,257,170,257);

                    $pdf->Cell(0,0,$site_website,0,0,'C');
                    $pdf->Ln($break_height);
                    $pdf->Cell(0,0,$site_address,0,0,'C');
                    $pdf->Ln($break_height);
                    $pdf->Cell(0,0,$site_city.", ".$site_zip_code,0,0,'C');
                    $pdf->Ln($break_height);

                    $filename = "/var/www/html/invoices/$file_name";
                    //file_put_contents($filename, $output);
                    $pdf->Output('F',$filename);
                
                
                
                /*
                if (!copy('invoices/'.$first_invoice, 'invoices/'.$check_already_invoice)) 
                {
                    echo "failed to copy";
                }
                else
                {
                */    
                    $db_start_date = $start_year."-".$next_month."-".$start_day;
                    
                    $insert_query = "INSERT into exec_invoices(user_id,pdf_file,start_date) values('$user_id','$check_already_invoice','$db_start_date')";
                    //echo "<br>insert_query: ".$insert_query; 
                    $insert_result = com_db_query($insert_query);
                    
                    
                    
                    $mailBody = 'Hi '.$to_name.','."\n\n".'

                    Your most recent invoice is now available for your records.'."\n\n".'

                    To view or download, please login to your www.execfile.com account, click on the gear wheel icon in the top right corner and select "Account".'."\n\n".'

                    Thank you!'."\n\n".'

                    -Misha Sobolev'."\n\n\n".'


                    Best regards,'."\n".'
                    Misha Sobolev'."\n".'
                    HRExecsOnTheMove'."\n".'
                    646.812.6814';


                    $success = sendEmail('msobolev@execfile.com',$user_email,'Invoice',$mailBody);
                    if (!$success) {
                    $errorMessage = error_get_last()['message'];
                    }
                    else
                        echo "<br>Mail send";
                    
                    
                //}    

            }
            //if(file_)
            
            
        }
        
        //$invoice_row[3]
    }
}

?>

