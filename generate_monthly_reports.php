<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);



//echo "<br>File hr:".file_exists('reports/h1r-11-2018.xls');
//echo "<br>File cmo:".file_exists('reports/cmo-11-2018.xls');
//die();

//$myfile = fopen("testfile.xls", "w");
//$data = "fara,z\tCh'h\nsecondline";        


function remove_invalid_chars($text)
{
    $find[] = 'â€œ'; // left side double smart quote
    $find[] = 'â€'; // right side double smart quote
    $find[] = 'â€˜'; // left side single smart quote
    $find[] = 'â€™'; // right side single smart quote
    $find[] = 'â€¦'; // elipsis
    $find[] = 'â€”'; // em dash
    $find[] = 'â€“'; // en dash

    $replace[] = '"';
    $replace[] = '"';
    $replace[] = "'";
    $replace[] = "'";
    $replace[] = "...";
    $replace[] = "-";
    $replace[] = "-";

    $text = str_replace($find, $replace, $text);
    
    $text = strip_tags($text);
    
    //$text = str_replace("&"," and ",$text);
    $text = str_replace("&","&#38;",$text);
    
    $text = str_replace("&nbsp;"," ",$text);
    
    //$text = str_replace("â€”","",$text);
    //$text = str_replace("`","'",$text);
    
    
    $text = str_replace("\t","",$text);
    $text = str_replace("\n","",$text);
    
    
    return $text;
    
}


function com_db_output($string) {
	return stripslashes($string);
}




//fwrite($myfile,$data);
//die();        


include("config.php");
include("common_functions.php");

$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ");
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");


// Sending Email to particular site users
$from = 'misha.sobolev@execfile.com';//'msobolev@execfile.com';
if(1 == 2)
{    
    $site = 'hr';
    $siteName = 'HRExecsOnTheMove';
    
    //$from = 'admin@closonthemove.com';//misha.sobolev@execfile.com';
    //$allSiteUsers = "select user_id,email,first_name from exec_user where (site = '' OR site = '".$site."') and status = 1 and user_id in (3437,3401,3400,3399);";
    
    $allSiteUsers = "select user_id,email,first_name from exec_user where  status = 1 and email = 'faraz.aia@nxvt.com';";
    
    echo "<br>allSiteUsers:".$allSiteUsers;

    $allSiteUsersResults = mysql_query($allSiteUsers);

    $allSiteUsersRows = mysql_num_rows($allSiteUsersResults);

    echo "<br>allSiteUsersRows:".$allSiteUsersRows;

    if($allSiteUsersRows > 0)
    {
        while($siteUserRow = mysql_fetch_array($allSiteUsersResults))
        {
            $siteUserId = $siteUserRow['user_id'];
            $siteUserEmail = $siteUserRow['email'];
            $siteUserName = $siteUserRow['first_name'];

            $subject = "Your monthly report is ready";


            $mailBody = 'Hi '.$siteUserName.','."<br><br>".'

            Your monthly report with management changes and other events concerning IT executives is ready.'."<br><br>".'

            You can access it at: <a href=https://www.execfile.com/login.php?os=stng>www.execfile.com/login.php?os=stng'."</a><br><br>".'

            I hope this is helpful.'."<br><br>".'

            -Misha Sobolev!'."<br><b>".'
            CTOsOnTheMove'."</b><br><br><br>";


            //echo "<br><br>siteUserEmail:".$siteUserEmail;
            //echo "<br>mailBody:".$mailBody;
            //send_email($siteUserEmail, $subject, $mailBody, $from);

            //send_email($from,$siteUserEmail, $subject, $mailBody );

            // Uncomment below
            //$siteUserEmail = "faraz.aia@nxvt.com";
            send_email_smtp($from,$siteUserEmail, $subject, $mailBody );

            //sendEmail('msobolev@execfile.com','faraz.aia@nxvt.com','Monthly Report',$mailBody);


            // Sending email starts
            /*    
            require_once('PHPMailer/class.phpmailer.php');
            $mail                = new PHPMailer();
            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPAuth      = true;                  // enable SMTP authentication
            $mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent


            $mail->Host          = "smtpout.secureserver.net";
            $mail->Port          = 25; 
            $mail->Username      = "misha.sobolev@execfile.com";//msobolev@execfile.com";//"misha.sobolev@execfile.com";
            $mail->Password      = "borabora2190";//"ryazan";

            echo "<br>From:".$from;

            $mail->AddReplyTo($from, 'Execfile.com');
            //$mail->SetFrom('msobolev@execfile.com', 'Execfile.com');
            $mail->SetFrom($from, 'Execfile.com');
            $mail->Subject       = $subject;


            $body = $mailBody;
            //$email = $siteUserEmail;
            $user_first_name = "";

            $mail->MsgHTML($body);
            $mail->AddAddress($siteUserEmail, $user_first_name);

            if(!$mail->Send())
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                // Sending email ends

            */    

            
           
            $reportSendEmail = "INSERT into exec_monthly_report_email(email,user_id,send_date) values('".$siteUserEmail."','".$siteUserId."',now())";
            echo "<br>reportSendEmail:".$reportSendEmail;
            $reportSendEmailResult = mysql_query($reportSendEmail);
             
            
        }        
    }    
}

//die();
// Only Sending notification email

//$sites = array('ciso');
$sites = array('hr','cto','clo','ciso');
$from = 'misha.sobolev@execfile.com';//'msobolev@execfile.com';
$subject = "Your monthly report is ready";



if(1 == 2)
{    
    foreach($sites as $site)
    {

        if($site == 'hr')
        {
            $siteShort = "HR";
            $siteName = 'HRExecsOnTheMove';
        }    

        elseif($site == 'ciso')
        {
            $siteShort = "IT Security";
            $siteName = 'CISOsOnTheMove';

        }
        elseif($site == 'ciso')
        {    
            $siteShort = "IT Security";
            $siteName = 'CISOsOnTheMove';
        }    
        elseif($site == 'cto')
        {
            $siteShort = "IT";
            $siteName = 'CTOsOnTheMove';
        }
        elseif($site == 'clo')
        {
            $siteShort = "Legal";
            $siteName = 'CLOsOnTheMove';
        }  


        $subject = "Your monthly report is ready";
        // Sending email informing about monthly report
        $allSiteUsers = "select user_id,email,first_name from exec_user where site = '".$site."' and status = 1";
        echo "<br>allSiteUsers:".$allSiteUsers;
        $allSiteUsersResults = mysql_query($allSiteUsers);

        $allSiteUsersRows = mysql_num_rows($allSiteUsersResults);

        if($allSiteUsersRows > 0)
        {
            while($siteUserRow = mysql_fetch_array($allSiteUsersResults))
            {
                $siteUserId = $siteUserRow['user_id'];
                $siteUserEmail = $siteUserRow['email'];
                $siteUserName = $siteUserRow['first_name'];


                $mailBody = 'Hi '.$siteUserName.','."<br><br>".'

                Your monthly report with management changes and other events concerning '.$siteShort.' executives is ready.'."<br><br>".'

                You can access it at: <a href=https://www.execfile.com/login.php?os=stng>www.execfile.com/login.php?os=stng'."</a><br><br>".'

                I hope this is helpful.'."<br><br>".'

                -Misha Sobolev!'."<br><b>$siteName</b><br><br><br>";


                echo "<br><br>Site:".$site;
                echo "<br>siteUserEmail:".$siteUserEmail;
                echo "<br>Mail Body:".$mailBody;

                send_email_smtp($from,$siteUserEmail, $subject, $mailBody );
                //sendEmail('msobolev@execfile.com','faraz.aia@nxvt.com','Monthly Report',$mailBody);

                $reportSendEmail = "INSERT into exec_monthly_report_email(email,user_id,send_date) values('".$siteUserEmail."','".$siteUserId."',now())";
                echo "<br>reportSendEmail:".$reportSendEmail;
                $reportSendEmailResult = mysql_query($reportSendEmail);
                //die();
            }
        }
    }
}


//$sites = array('hr','cto','clo','ciso');
//$sites = array('ciso');
//$sites = array('hr','cto','clo');
if(1 == 1)
{    
    foreach($sites as $site)
    {

        $tableCompanyMaster = "hre_company_master";
        if($site == 'hr')
        {

            $tablePersonalMaster = "hre_personal_master";
            $tableMovementMaster = "hre_movement_master";


            $tablePersonalAwards = "hre_personal_awards";
            $tablePersonalMedia = "hre_personal_media_mention";

            $tablePersonalPublication = "hre_personal_publication";

            $tablePersonalSpeaking = "hre_personal_speaking";
            $tableCompanyFunding = "hre_company_funding";

            $siteShort = "HR";
            $siteName = 'HRExecsOnTheMove';
        }    

        elseif($site == 'cto' || $site == 'ciso')
        {

            $tablePersonalMaster = "cto_personal_master";
            $tableMovementMaster = "cto_movement_master";


            $tablePersonalAwards = "cto_personal_awards";
            $tablePersonalMedia = "cto_personal_media_mention";

            $tablePersonalPublication = "cto_personal_publication";
            $tablePersonalSpeaking = "cto_personal_speaking";
            $tableCompanyFunding = "cto_company_funding";

            
            if($site == 'cto')
            {
                $siteShort = "IT";
                $siteName = 'CTOsOnTheMove';
            }    
            elseif($site == 'ciso')
            {    
                $siteShort = "IT Security";
                $siteName = 'CISOsOnTheMove';
            }    

        }    
        elseif($site == 'clo')
        {

            $tablePersonalMaster = "clo_personal_master";
            $tableMovementMaster = "clo_movement_master";


            $tablePersonalAwards = "clo_personal_awards";
            $tablePersonalMedia = "clo_personal_media_mention";
            $tablePersonalPublication = "clo_personal_publication";
            $tablePersonalSpeaking = "clo_personal_speaking";
            $tableCompanyFunding = "clo_company_funding";

            $siteShort = "Legal";
            $siteName = 'CLOsOnTheMove';
        }    



        $lastMonth = date('m', strtotime('-2 days'));
        $lastDateOfMonth = date('d', strtotime('-2 days'));
        $year = date('Y', strtotime('-2 days'));

        $twoMonthsOld = $lastMonth-1;
        // Undo below
        //$twoMonthsOld = "12";
        
        $firstDateOfReport = "$year-0".$twoMonthsOld."-01";
        // Undo below
        //$firstDateOfReport = "2019-02-01";
        
        $LastDateOfReport = "$year-".$lastMonth."-".$lastDateOfMonth;

        // delete last lien
        //$LastDateOfReport = "2019-02-28";
        
        
        echo "<br>lastMonth:".$lastMonth;
        echo "<br>firstDateOfReport:".$firstDateOfReport;
        echo "<br>LastDateOfReport:".$LastDateOfReport;
        echo "<br>twoMonthsOld:".$twoMonthsOld;
        
        //2012-08-15

        $report_of_month = $lastMonth."-".$year;


        $fileName = "$site-$lastMonth-$year.xls";
        echo "<br>fileName:".$fileName;
        //die();
        // delete below 2 line
        //$fileName = "$site-02-$year.xls";
        //$report_of_month = "02-".$year;
        
        //if(!file_exists('reports/'.$site.'-'.$report_of_month.'.xls') == 1)
        if(!file_exists('reports/'.$fileName))
        {
            $outputFile = fopen("reports/".$fileName, "w");
            //$last_30_days = date('Y-m-d', strtotime('-30 days'));

            $data = "\n\n\n\n";
            $cisoClause = "";
            $previousMonthOldDate = $twoMonthsOld.'-2019';

            $lastMonthMovementsQuery = "SELECT GROUP_CONCAT( move_ids )  as move_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthMovementsQuery:".$lastMonthMovementsQuery;
            $lastMonthMovementsResults = mysql_query($lastMonthMovementsQuery);
            $lastMonthMovementRow = mysql_fetch_array($lastMonthMovementsResults);
            $lastMonthMovements = $lastMonthMovementRow['move_ids'];
            $lastMonthClause = '';

            if($lastMonthMovements != '')
                $lastMonthClause = " and move_id not in ($lastMonthMovements) ";

            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";



            $getMovementsQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as company_industry,s.short_name as state,c.countries_name as country,ma.name as movement_name from ".
            $tablePersonalMaster." as pm,"
            .$tableMovementMaster." as mm,"
            .$tableCompanyMaster." as cm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i,
            hre_source as so,
            exec_management_change as ma    
            where pm.personal_id = mm.personal_id and cm.company_id = mm.company_id 
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry 
            and so.id = mm.source_id
            and ma.id = mm.movement_type 
            and mm.effective_date >='".$firstDateOfReport."' and mm.effective_date <='".$LastDateOfReport."' $lastMonthClause $cisoClause";

            echo "<br>getMovementsQuery:".$getMovementsQuery;

            //die("after movements");
            $movementsResults = mysql_query($getMovementsQuery);

            $movementsRows = mysql_num_rows($movementsResults);

            echo "<br>movementsRows:".$movementsRows;

            $move_ids = "";
            if($movementsRows > 0)
            {

                $data .= "M A N A G E M E N T      C H A N G E S\n\n";
                $data .= "";


                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";

                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";

                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";
                $data .= "Announce Date\t";
                $data .= "Effective Date\t";
                $data .= "Source\t";
                //$data .= "Headline\t";
                //$data .= "Full Body\t";
                $data .= "Short Url\t";
                $data .= "Movement Type\t";
                $data .= "What Happened\t";
                $data .= "About Person\t";
                $data .= "Source Link\n";


                while($movementRow = mysql_fetch_array($movementsResults))
                {
                    //echo "<pre>movementRow:";   print_r($movementRow);   echo "</pre>";
                    $move_id = com_db_output($movementRow['move_id']);
                    $personal_id = remove_invalid_chars(com_db_output($movementRow['personal_id']));
                    $first_name = remove_invalid_chars(com_db_output($movementRow['first_name']));
                    $last_name = remove_invalid_chars(com_db_output($movementRow['last_name']));
                    $movement_title = remove_invalid_chars(com_db_output($movementRow['movement_title']));
                    $email = remove_invalid_chars(com_db_output($movementRow['email']));
                    $phone = remove_invalid_chars(com_db_output($movementRow['phone']));
                    $company_name = remove_invalid_chars(com_db_output($movementRow['company_name']));
                    $company_website = remove_invalid_chars(com_db_output($movementRow['company_website']));
                    $company_revenue = com_db_output($movementRow['company_revenue']);
                    $company_employee = com_db_output($movementRow['company_employee']);
                    $company_industry = com_db_output($movementRow['company_industry']);
                    $address = remove_invalid_chars(com_db_output($movementRow['address']));
                    $address2 = remove_invalid_chars(com_db_output($movementRow['address2']));
                    $city = remove_invalid_chars(com_db_output($movementRow['city']));
                    $state = remove_invalid_chars(com_db_output($movementRow['state']));
                    $country = remove_invalid_chars(com_db_output($movementRow['country']));
                    $zip_code = remove_invalid_chars(com_db_output($movementRow['zip_code']));

                    $announce_date = $movementRow['announce_date'];
                    $adate = explode('-',$announce_date);
                    $announce_date = $adate[1].'/'.$adate[2].'/'.$adate[0];

                    $effective_date = $movementRow['effective_date'];
                    $edate = explode('-',$effective_date);
                    $effective_date = $edate[1].'/'.$edate[2].'/'.$edate[0];

                    $source = com_db_output($movementRow['source']);
                    //$headline = remove_invalid_chars(com_db_output($movementRow['headline']));
                    //$full_body = str_replace('<br />','&&&', $movementRow['full_body']);
                    //$full_body = remove_invalid_chars(com_db_output($full_body));
                    $short_url = com_db_output($movementRow['short_url']);
                    $movement_name = com_db_output($movementRow['movement_name']);
                    $what_happened = remove_invalid_chars(com_db_output(strip_tags($movementRow['what_happened'])));
                    $about_person = remove_invalid_chars(com_db_output(strip_tags($movementRow['about_person'])));

                    $more_link = com_db_output($movementRow['more_link']);


                    $about_person = trim($about_person);
                    $what_happened = trim($what_happened);

                    $data .= "$personal_id\t";
                    $data .= "$first_name\t";
                    $data .= "$last_name\t";
                    $data .= "$movement_title\t";
                    $data .= "$email\t";
                    $data .= "$phone\t";

                    $data .= "$company_name\t";
                    $data .= "$company_website\t";
                    $data .= "$company_revenue\t";
                    $data .= "$company_employee\t";
                    $data .= "$company_industry\t";
                    $data .= "$address\t";
                    $data .= "$address2\t";
                    $data .= "$city\t";
                    $data .= "$state\t";
                    $data .= "$country\t";
                    $data .= "$zip_code\t";
                    $data .= "$announce_date\t";
                    $data .= "$effective_date\t";
                    $data .= "$source\t";
                    //$data .= "$headline\t";
                    //$data .= "$full_body\t";
                    $data .= "$short_url\t";
                    $data .= "$movement_name\t";



                    //$data .= '"'.$what_happened.'"'."\t";
                    $data .= "$what_happened\t";

                    $data .= "$about_person\t";
                    $data .= "$more_link\n";

                    $move_ids .= $move_id.",";

                }
                $move_ids = trim($move_ids,",");
                //$xls->Output('Montrhly-Report-'. date('m-d-Y') . '.xls');	
                //file_put_contents("pricelists/example.xls",$data);
            }    


            $lastMonthAwardsQuery = "SELECT GROUP_CONCAT( award_ids )  as award_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthAwardsQuery:".$lastMonthAwardsQuery;
            $lastMonthAwardsResults = mysql_query($lastMonthAwardsQuery);
            $lastMonthAwardRow = mysql_fetch_array($lastMonthAwardsResults);
            $lastMonthAwards = $lastMonthAwardRow['award_ids'];
            $lastMonthAwardClause = '';

            if($lastMonthAwards != '')
                $lastMonthAwardClause = " and awards_id not in ($lastMonthAwards) ";


            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";


            $getAwardsQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state_short,c.countries_name as country from ".$tablePersonalAwards." as pw,"
            .$tablePersonalMaster." as pm,"
            .$tableMovementMaster." as mm,"
            .$tableCompanyMaster." as cm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i
            where pm.personal_id = pw.personal_id 
            and cm.company_id = mm.company_id
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry 
            and pm.personal_id = mm.personal_id
            and pw.awards_date >='".$firstDateOfReport."'  and pw.awards_date <='".$LastDateOfReport."' $lastMonthAwardClause $cisoClause";

            echo "<br><br>getAwardsQuery:".$getAwardsQuery;



            $awardsResults = mysql_query($getAwardsQuery);

            $awardsRows = mysql_num_rows($awardsResults);
            $award_ids = "";
            if($awardsRows > 0)
            {
                $data .= "\n\nA W A R D S\n\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Awards Date\t";
                $data .= "Awards Title\t";
                $data .= "Award Given By\t";
                $data .= "Source Link\n";


                while($awardRow = mysql_fetch_array($awardsResults))
                {

                    $award_id = $awardRow['personal_id'];

                    $data .= $awardRow['personal_id']."\t";
                    $data .= $awardRow['first_name']."\t";
                    $data .= $awardRow['last_name']."\t";
                    $data .= $awardRow['movement_title']."\t";
                    $data .= $awardRow['email']."\t";
                    $data .= $awardRow['phone']."\t";


                    $data .= $awardRow['company_name']."\t";
                    $data .= $awardRow['company_website']."\t";
                    $data .= $awardRow['company_revenue']."\t";
                    $data .= $awardRow['company_employee']."\t";
                    $data .= $awardRow['industry_title']."\t";
                    $data .= $awardRow['address']."\t";
                    $data .= $awardRow['address2']."\t";
                    $data .= $awardRow['city']."\t";
                    $data .= $awardRow['state_short']."\t";
                    $data .= $awardRow['country']."\t";
                    $data .= $awardRow['zip_code']."\t";


                    $data .= $awardRow[4]."\t"; //awards_Date
                    $data .= $awardRow[2]."\t"; // awards_title
                    $data .= $awardRow[3]."\t"; // awards_given_by
                    $data .= $awardRow['awards_link']."\n";


                    $award_ids .= $award_id.",";

                }
                $award_ids = trim($award_ids,",");
            }



            $lastMonthMediaQuery = "SELECT GROUP_CONCAT( media_ids )  as media_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthMediaQuery:".$lastMonthMediaQuery;
            $lastMonthMediaResults = mysql_query($lastMonthMediaQuery);
            $lastMonthMediaRow = mysql_fetch_array($lastMonthMediaResults);
            $lastMonthMedia = $lastMonthMediaRow['media_ids'];
            $lastMonthMediaClause = '';

            if($lastMonthMedia != '')
                $lastMonthMediaClause = " and mm_id not in ($lastMonthMedia)";


            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";


            $getMediaQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state_short,c.countries_name as country from ".$tablePersonalMedia." as pw,"
            .$tablePersonalMaster." as pm," 
            .$tableMovementMaster." as mm,"
            .$tableCompanyMaster." as cm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i
            where pm.personal_id = pw.personal_id 
            and cm.company_id = mm.company_id
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry 
            and pm.personal_id=mm.personal_id
            and pw.pub_date >='".$firstDateOfReport."'  and pw.pub_date <='".$LastDateOfReport."' $lastMonthMediaClause $cisoClause";

            echo "<br><br>getMediaQuery:".$getMediaQuery;


            $mediaResults = mysql_query($getMediaQuery);

            $mediaRows = mysql_num_rows($mediaResults);
            $media_ids = "";
            if($mediaRows > 0)
            {

                $data .= "\n\nM E D I A    M E N T I O N\n\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Date\t";
                $data .= "Quote\t";
                $data .= "Publication\t";
                $data .= "Source Link\n";



                while($mediaRow = mysql_fetch_array($mediaResults))
                {
                    //echo "<pre>mediaRow:";   print_r($mediaRow);   echo "</pre>";

                    $media_id = $mediaRow['mm_id'];
                    $data .= $mediaRow['personal_id']."\t";
                    $data .= $mediaRow['first_name']."\t";
                    $data .= $mediaRow['last_name']."\t";
                    $data .= $mediaRow['movement_title']."\t";
                    $data .= $mediaRow['email']."\t";
                    $data .= $mediaRow['phone']."\t";


                    $data .= $mediaRow['company_name']."\t";
                    $data .= $mediaRow['company_website']."\t";
                    $data .= $mediaRow['company_revenue']."\t";
                    $data .= $mediaRow['company_employee']."\t";
                    $data .= $mediaRow['industry_title']."\t";
                    $data .= $mediaRow['address']."\t";
                    $data .= $mediaRow['address2']."\t";
                    $data .= $mediaRow['city']."\t";
                    $data .= $mediaRow['state_short']."\t";
                    $data .= $mediaRow['country']."\t";
                    $data .= $mediaRow['zip_code']."\t";


                    $data .= $mediaRow['pub_date']."\t";
                    $data .= $mediaRow['quote']."\t";
                    $data .= $mediaRow['publication']."\t";
                    $data .= $mediaRow['media_link']."\n";

                    $media_ids .= $media_id.",";
                }
                $media_ids = trim($media_ids,",");
            }



            $lastMonthSpeakingQuery = "SELECT GROUP_CONCAT( speaking_ids )  as speaking_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthSpeakingQuery:".$lastMonthSpeakingQuery;
            $lastMonthSpeakingResults = mysql_query($lastMonthSpeakingQuery);
            $lastMonthSpeakingRow = mysql_fetch_array($lastMonthSpeakingResults);
            $lastMonthSpeaking = $lastMonthSpeakingRow['speaking_ids'];
            $lastMonthSpeakingClause = '';

            if($lastMonthSpeaking != '')
                $lastMonthSpeakingClause = " and speaking_id not in ($lastMonthSpeaking)";


            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";


            $getSpeakingQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state_short,c.countries_name as country from ".$tablePersonalSpeaking." as pw,"
            .$tablePersonalMaster." as pm," 
            .$tableMovementMaster." as mm,"
            .$tableCompanyMaster." as cm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i
            where pm.personal_id = pw.personal_id 
            and cm.company_id = mm.company_id
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry 
            and pm.personal_id=mm.personal_id
            and pw.event_date >='".$firstDateOfReport."'  and pw.event_date <='".$LastDateOfReport."' $lastMonthSpeakingClause $cisoClause";

            echo "<br><br>getSpeakingQuery:".$getSpeakingQuery;


            $speakingResults = mysql_query($getSpeakingQuery);

            $speakingRows = mysql_num_rows($speakingResults);
            $speaking_ids = "";
            if($speakingRows > 0)
            {

                $data .= "\n\nS P E A K I N G\n\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Event Date\t";
                $data .= "Role\t";
                $data .= "Topic\t";
                $data .= "Event\t";
                $data .= "Source Link\n";



                while($speakingRow = mysql_fetch_array($speakingResults))
                {
                    $speaking_id = $speakingRow['speaking_id'];
                    $data .= $speakingRow['personal_id']."\t";
                    $data .= $speakingRow['first_name']."\t";
                    $data .= $speakingRow['last_name']."\t";
                    $data .= $speakingRow['movement_title']."\t";
                    $data .= $speakingRow['email']."\t";
                    $data .= $speakingRow['phone']."\t";


                    $data .= $speakingRow['company_name']."\t";
                    $data .= $speakingRow['company_website']."\t";
                    $data .= $speakingRow['company_revenue']."\t";
                    $data .= $speakingRow['company_employee']."\t";
                    $data .= $speakingRow['industry_title']."\t";
                    $data .= $speakingRow['address']."\t";
                    $data .= $speakingRow['address2']."\t";
                    $data .= $speakingRow['city']."\t";
                    $data .= $speakingRow['state_short']."\t";
                    $data .= $speakingRow['country']."\t";
                    $data .= $speakingRow['zip_code']."\t";


                    $data .= $speakingRow['event_date']."\t";
                    $data .= $speakingRow['role']."\t";
                    $data .= $speakingRow['topic']."\t";
                    $data .= $speakingRow['event']."\t";
                    $data .= $speakingRow['speaking_link']."\n";

                    $speaking_ids .= $speaking_id.",";

                }
                $speaking_ids = trim($speaking_ids,",");
            }




            $lastMonthPublicationQuery = "SELECT GROUP_CONCAT( publication_ids )  as publication_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthPublicationQuery:".$lastMonthPublicationQuery;
            $lastMonthPublicationResults = mysql_query($lastMonthPublicationQuery);
            $lastMonthPublicationRow = mysql_fetch_array($lastMonthPublicationResults);
            $lastMonthPublication = $lastMonthPublicationRow['publication_ids'];
            $lastMonthPublicationClause = '';

            if($lastMonthPublication != '')
                $lastMonthPublicationClause = " and publication_id not in ($lastMonthPublication)";

            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";


            $getPublicationQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state_short,c.countries_name as country from ".$tablePersonalPublication." as pb,"
            .$tablePersonalMaster." as pm,"
            .$tableMovementMaster." as mm,"
            .$tableCompanyMaster." as cm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i
            where pm.personal_id = pb.personal_id 
            and cm.company_id = mm.company_id
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry
            and pm.personal_id = mm.personal_id
            and pb.publication_date >='".$firstDateOfReport."'  and pb.publication_date <='".$LastDateOfReport."' $lastMonthPublicationClause $cisoClause";

            echo "<br><br>getPublicationQuery:".$getPublicationQuery;


            $publicationResults = mysql_query($getPublicationQuery);

            $publicationRows = mysql_num_rows($publicationResults);

            $publication_ids = '';
            if($publicationRows > 0)
            {

                $data .= "\n\nP U B L I C A T I O N S\n\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Date\t";
                $data .= "Title\t";
                $data .= "Source Link\n";



                while($publicationRow = mysql_fetch_array($publicationResults))
                {
                    $publication_id = $publicationRow['personal_id'];
                    $data .= $publicationRow['personal_id']."\t";
                    $data .= $publicationRow['first_name']."\t";
                    $data .= $publicationRow['last_name']."\t";
                    $data .= $publicationRow['movement_title']."\t";
                    $data .= $publicationRow['email']."\t";
                    $data .= $publicationRow['phone']."\t";


                    $data .= $publicationRow['company_name']."\t";
                    $data .= $publicationRow['company_website']."\t";
                    $data .= $publicationRow['company_revenue']."\t";
                    $data .= $publicationRow['company_employee']."\t";
                    $data .= $publicationRow['industry_title']."\t";
                    $data .= $publicationRow['address']."\t";
                    $data .= $publicationRow['address2']."\t";
                    $data .= $publicationRow['city']."\t";
                    $data .= $publicationRow['state_short']."\t";
                    $data .= $publicationRow['country']."\t";
                    $data .= $publicationRow['zip_code']."\t";


                    $data .= $publicationRow['event_date']."\t";
                    $data .= $publicationRow['role']."\t";
                    $data .= $publicationRow['topic']."\t";
                    $data .= $publicationRow['event']."\t";
                    $data .= $publicationRow['speaking_link']."\n";

                    $publication_ids .= $publication_id.",";
                }
                $publication_ids = trim($publication_ids,",");
            }



            $lastMonthFundingQuery = "SELECT GROUP_CONCAT( funding_ids )  as funding_ids
            FROM exec_monthly_reports
            WHERE DATE =  '".$previousMonthOldDate."' and site = '".$site."'";
            echo "<br>lastMonthFundingQuery:".$lastMonthFundingQuery;
            $lastMonthFundingResults = mysql_query($lastMonthFundingQuery);
            $lastMonthFundingRow = mysql_fetch_array($lastMonthFundingResults);
            $lastMonthFunding = $lastMonthFundingRow['funding_ids'];
            $lastMonthFundingClause = '';

            if($lastMonthFunding != '')
                $lastMonthFundingClause = " and funding_id not in ($lastMonthFunding)";


            if($site == 'ciso')
                $cisoClause = " and pm.ciso_user = 1";

            $getFundingQuery = "SELECT *,mm.title as movement_title,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state,c.countries_name as country from ".$tableCompanyFunding." as cf,"
            .$tableCompanyMaster." as cm," 
            .$tablePersonalMaster." as pm,"
            .$tableMovementMaster." as mm,
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i
            where cm.company_id = cf.company_id  
            and mm.personal_id = pm.personal_id
            and cm.company_id = mm.company_id
            and r.id = cm.company_revenue
            and e.id = cm.company_employee
            and s.state_id = cm.state
            and c.countries_id = cm.country
            and i.industry_id = cm.company_industry 
            and cf.funding_date >='".$firstDateOfReport."'  and cf.funding_date <='".$LastDateOfReport."' $lastMonthFundingClause $cisoClause GROUP BY funding_id";

            echo "<br><br>getFundingQuery:".$getFundingQuery;


            $fundingResults = mysql_query($getFundingQuery);

            $fundingRows = mysql_num_rows($fundingResults);
            $funding_ids = "";
            if($fundingRows > 0)
            {

                $data .= "\n\nF U N D I N G S\n\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Funding Amount\t";
                $data .= "Funding Date\t";
                $data .= "Funding Source\n";



                while($fundingRow = mysql_fetch_array($fundingResults))
                {
                    $funding_id = $fundingRow['funding_id'];

                    $data .= $fundingRow['personal_id']."\t";
                    $data .= $fundingRow['first_name']."\t";
                    $data .= $fundingRow['last_name']."\t";
                    $data .= $fundingRow['movement_title']."\t";
                    $data .= $fundingRow['email']."\t";
                    $data .= $fundingRow['phone']."\t";


                    $data .= $fundingRow['company_name']."\t";
                    $data .= $fundingRow['company_website']."\t";
                    $data .= $fundingRow['company_revenue']."\t";
                    $data .= $fundingRow['company_employee']."\t";
                    $data .= $fundingRow['industry_title']."\t";
                    $data .= $fundingRow['address']."\t";
                    $data .= $fundingRow['address2']."\t";
                    $data .= $fundingRow['city']."\t";
                    $data .= $fundingRow['state']."\t";
                    $data .= $fundingRow['country']."\t";
                    $data .= $fundingRow['zip_code']."\t";


                    $data .= $fundingRow['funding_amount']."\t";
                    $data .= $fundingRow['funding_date']."\t";
                    $data .= $fundingRow['funding_source']."\n";
                    $funding_ids .= $funding_id.",";
                }
                $funding_ids = trim($funding_ids,",");
            }


            /*
            $getFundingQuery = "SELECT *,r.name as company_revenue,e.name as company_employee,i.title as industry_title,s.short_name as state,c.countries_name as country,ma.name as movement_name from ".$tablePersonalFunding." as cf,"
            .$tableCompanyMaster." as cm, 
            exec_revenue_size as r,
            exec_employee_size as e,
            exec_state as s,
            exec_countries as c,
            exec_industry as i,
            hre_source as so,
            exec_management_change as ma
            where cm.company_id = cf.company_id and cf.funding_date >='".$firstDateOfReport."'  and pw.funding_date <='".$LastDateOfReport."'";

            echo "<br><br>getFundingQuery:".$getFundingQuery;


            $fundingResults = mysql_query($getFundingQuery);

            $fundingRows = mysql_num_rows($fundingResults);

            if($fundingRows > 0)
            {

                $data .= "\n\n\nF U N D I N G S\n";
                $data .= "Personal Unique ID\t";
                $data .= "First Name\t";
                $data .= "Last Name\t";
                $data .= "Title\t";
                $data .= "E-Mail\t";
                $data .= "Phone\t";


                $data .= "Company Name\t";
                $data .= "Company Website\t";
                $data .= "Company Size Revenue\t";
                $data .= "Company Size Employees\t";
                $data .= "Company Industry\t";
                $data .= "Address\t";
                $data .= "Address 2\t";
                $data .= "City\t";
                $data .= "State\t";
                $data .= "Country\t";
                $data .= "Zip Code\t";

                $data .= "Date\t";
                $data .= "Title\t";
                $data .= "Source Link\t";



                while($fundingRow = mysql_fetch_array($fundingResults))
                {
                    $data .= $fundingRow['personal_id'];
                    $data .= $fundingRow['first_name'];
                    $data .= $fundingRow['last_name'];
                    $data .= $fundingRow['title'];
                    $data .= $fundingRow['email'];
                    $data .= $fundingRow['phone'];


                    $data .= $fundingRow['company_name'];
                    $data .= $fundingRow['company_website'];
                    $data .= $fundingRow['company_revenue'];
                    $data .= $fundingRow['company_employee'];
                    $data .= $fundingRow['industry_title'];
                    $data .= $fundingRow['address'];
                    $data .= $fundingRow['address2'];
                    $data .= $fundingRow['city'];
                    $data .= $fundingRow['state'];
                    $data .= $fundingRow['country'];
                    $data .= ['zip_code'];


                    $data .= $fundingRow['funding_amount'];
                    $data .= $fundingRow['funding_date'];
                    $data .= $fundingRow['funding_source'];

                }
            }

            */
            fwrite($outputFile,$data);
            
            $saveQuery = "INSERT into exec_monthly_reports(move_ids,speaking_ids,award_ids,publication_ids,media_ids,funding_ids,job_ids,site,date) VALUES('$move_ids','$speaking_ids','$award_ids','$publication_ids','$media_ids','$funding_ids','','$site','$report_of_month')";
                $saveResults = mysql_query($saveQuery);

                echo "<br><br><a href=reports/".$fileName.">Download</a>";
            
            
            if(1 == 2)
            {
                $subject = "Your monthly report is ready";
                // Sending email informing about monthly report
                $allSiteUsers = "select user_id,email,first_name from exec_user where site = '".$site."' and status = 1";
                echo "<br>allSiteUsers:".$allSiteUsers;
                $allSiteUsersResults = mysql_query($allSiteUsers);

                $allSiteUsersRows = mysql_num_rows($allSiteUsersResults);
                echo "<br>allSiteUsersRows:".$allSiteUsersRows;
                if($allSiteUsersRows > 0)
                {
                    while($siteUserRow = mysql_fetch_array($allSiteUsersResults))
                    {
                        $siteUserId = $siteUserRow['user_id'];
                        $siteUserEmail = $siteUserRow['email'];
                        $siteUserName = $siteUserRow['first_name'];


                        $mailBody = 'Hi '.$siteUserName.','."<br><br>".'

                        Your monthly report with management changes and other events concerning '.$siteShort.' executives is ready.'."<br><br>".'

                        You can access it at: <a href=https://www.execfile.com/login.php?os=stng>www.execfile.com/login.php?os=stng'."</a><br><br>".'

                        I hope this is helpful.'."<br><br>".'

                        -Misha Sobolev!'."<br><b>$siteName</b><br><br><br>";


                        //sendEmail('msobolev@execfile.com',$siteUserEmail,'Monthly Report',$mailBody);
                        
                        send_email_smtp($from,$siteUserEmail, $subject, $mailBody );
                        

                        $reportSendEmail = "INSERT into exec_monthly_report_email(email,user_id,send_date) values('".$siteUserEmail."','".$siteUserId."',now())";
                        echo "<br>reportSendEmail:".$reportSendEmail;
                        $reportSendEmailResult = mysql_query($reportSendEmail);
                        //die();
                    }
                }
            }
        }    

    }
}
?>