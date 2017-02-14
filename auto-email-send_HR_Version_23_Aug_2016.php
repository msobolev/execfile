<?php 

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


define("TABLE_PERSONAL_AWARDS","hre_personal_awards");
define("TABLE_PERSONAL_BOARD","hre_personal_board");
define("TABLE_PERSONAL_MEDIA_MENTION","hre_personal_media_mention");
define("TABLE_PERSONAL_PUBLICATION","hre_personal_publication");
define("TABLE_PERSONAL_SPEAKING","hre_personal_speaking");
define("TABLE_COMPANY_JOB_INFO","hre_company_job_info");
define("TABLE_COMPANY_FUNDING","hre_company_funding");


define("TABLE_USER","exec_user");
//define("TABLE_ALERT_SEND_INFO","hre_personal_awards");


define("TABLE_MOVEMENT_MASTER","hre_movement_master");
define("TABLE_PERSONAL_MASTER","hre_personal_master");
define("TABLE_COMPANY_MASTER","hre_company_master");
define("TABLE_MANAGEMENT_CHANGE","hre_management_change");

define("TABLE_SOURCE","hre_source");

define("TABLE_STATE","hre_state");
define("TABLE_COUNTRIES","hre_countries");
define("TABLE_INDUSTRY","hre_industry");
define("TABLE_REVENUE_SIZE","hre_revenue_size");

define("TABLE_EMPLOYEE_SIZE","hre_employee_size");
define("TABLE_PERSONAL_FILTER_ONOFF","hre_personal_filter_onoff");
define("TABLE_ALERT_SEND","hre_alert_send");
define("TABLE_ALERT","exec_alert");

define("TABLE_ALERT_SEND_INFO","hre_alert_send_info");
define("TABLE_MAILER_ERROR","");

define("HTTP_SERVER","https://www.hrexecsonthemove.com/");
define("DIR_WS_HTTP_FOLDER","");

define("HTTP_SERVER_EXEC","http://www.execfile.com/");

$site_company_address = '40 West 38th street, 5th Floor';
$site_company_state = 'New York';
$site_company_zip = 'NY 10018';

// TODO AFter completion of jobs and funding
// must remove code with 'FAR UNDO MUST'
// remove user_id check from main first alert query , search it with '_alert'


// TEST CASES
// Add multiple jobs of same company

chdir(dirname( __FILE__ ));
//include("includes/include-top-cron.php");
include("functions.php");
include("config.php");
//echo "<br>CTO URL: ".HTTP_CTO_URL;
//die();

?>
<style>
#header_logos img
{	
	position:absolute; 
	margin:auto; 
	top:0px; 
	right:0px; 
	bottom:0px; 
	left:0px;
}
</style>
<?PHP

function modify_url($comp_url)
{
    //echo "<br><br><br>comp_url: ".$comp_url;
    if(substr($comp_url,0,11) == 'http://www.')
    {
        $comp_url = substr($comp_url,7,strlen($comp_url));
    }
    elseif(substr($comp_url,0,7) == 'http://')
    {
        //echo "<br>in http: ".substr($comp_url,7,strlen($comp_url));
        $comp_url = substr($comp_url,7,strlen($comp_url));
    }
    elseif(substr($comp_url,0,8) == 'https://')
    {
        $comp_url = substr($comp_url,8,strlen($comp_url));
    }
    
    if(substr($comp_url,0,4) != 'www.')
    {
        $comp_url = 'www.'.$comp_url;
        //echo "<br>appending www ".$comp_url;
    }
    return $comp_url;
}


function sortBySubkey(&$array, $subkey, $sortType = SORT_DESC) 
{
    foreach ($array as $subarray) {
        $keys[] = $subarray[$subkey];
    }
    array_multisort($keys, $sortType, $array);
}


function addDate($days){
$date = date('Y-m-j');
$duration=$days.' day';
$newdate = strtotime ( $duration , strtotime ( $date ) ) ;
$newdate = date ( 'Y-m-j' , $newdate );
return $newdate;
}




// Setting this variable so that user can receive salesforce button in alert emails
$_GET['show_sf'] = 1;

$debug = $_GET['debug'];


//period between 30 days ago and 30 days in the future. doc 2014-06-18 cto
$future_date=addDate('30');
$before_date=subDate('30');
//========================================================================



$exp_date = date('Y-m-d');


require_once('PHPMailer/class.phpmailer.php');

$mail                = new PHPMailer();


$mail->IsSMTP(); // telling the class to use SMTP

$mail->SMTPAuth      = true;                  // enable SMTP authentication

$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent

$mail->Host          = "smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net

$mail->Port          = 80;    // 25 465               // 26 set the SMTP port for the GMAIL server

//$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Username      = "rts_email_sent@hrexecsonthemove.com"; // SMTP account username

$mail->Password      = "rts0214";        // SMTP account password

//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
$mail->SetFrom('msobolev@execfile.com', 'Execfile.com');

//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo("msobolev@execfile.com", 'Execfile.com');


$mail->Subject       = "are these your potential clients?";

com_db_connect_hre2() or die('Unable to connect to database server!');


$awardsQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_AWARDS	." where personal_id>0 and  awards_date>'".$before_date."' and awards_date<'".$future_date."' and status=0";
if($debug == 1)
    echo "<br>First Awards Q: ".$awardsQuery;
$awardsResult = com_db_query($awardsQuery);

$awardsStr = '';

while($aRow = com_db_fetch_array($awardsResult)){

    if ($awardsStr=='')
    {
        $awardsStr = $aRow['personal_id'];
    }
    else
    {
        $awardsStr .= ','.$aRow['personal_id'];
    }
}

$boardQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_BOARD." where personal_id>0 and board_date>'".$before_date."' and board_date<'".$future_date."'  and status=0";

$boardResult = com_db_query($boardQuery);

$boardStr = '';

while($bRow = com_db_fetch_array($boardResult)){

    if ($boardStr==''){

        $boardStr = $bRow['personal_id'];

    }else{

        $boardStr .= ','.$bRow['personal_id'];
    }
}

$mediaQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_MEDIA_MENTION." where personal_id>0 and pub_date>'".$before_date."' and  pub_date<'".$future_date."' and status=0";
if($debug == 1)
    echo "<br>First Media mention Q: ".$mediaQuery;
$mediaResult = com_db_query($mediaQuery);

$mediaStr = '';

while($mRow = com_db_fetch_array($mediaResult)){

    if ($mediaStr==''){

        $mediaStr = $mRow['personal_id'];

    }else{

        $mediaStr .= ','.$mRow['personal_id'];

    }

}

$publicationQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_PUBLICATION." where personal_id>0 and publication_date>'".$before_date."' and  publication_date <'".$future_date."' and status=0";

$publicationResult = com_db_query($publicationQuery);

$pubStr = '';

while($pRow = com_db_fetch_array($publicationResult)){

    if ($pubStr==''){

        $pubStr = $pRow['personal_id'];

    }else{

        $pubStr .= ','.$pRow['personal_id'];

    }

}

$speaker_before_date = date('Y-m-j');

//$speakingQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_SPEAKING." where personal_id>0 and event_date >'". $before_date ."' and event_date <'". $future_date ."'  and status=0";
$speakingQuery = "select distinct(personal_id) from ".TABLE_PERSONAL_SPEAKING." where personal_id>0 and event_date >'". $speaker_before_date ."' and event_date <'". $future_date ."'  and status=0";
echo "<br>speakingQuery: ".$speakingQuery;

$speakingResult = com_db_query($speakingQuery);

$speakingStr = '';

while($sRow = com_db_fetch_array($speakingResult)){

    if ($speakingStr==''){

        $speakingStr = $sRow['personal_id'];

    }else{

        $speakingStr .= ','.$sRow['personal_id'];

    }

}
echo "<br>speakingStr: ".$speakingStr;


//FAR UNCOMMENT For jobs and fundings

$jobsQuery = "select distinct(cj.company_id) from ".TABLE_COMPANY_JOB_INFO	." cj where  cj.add_date>'".$before_date."' and cj.add_date<'".$future_date."' and status=0";
if($debug == 1)
	echo "<br>jobsQuery: ".$jobsQuery."<br>";
$jobsResult = com_db_query($jobsQuery);

$jobsStr = '';

while($jRow = com_db_fetch_array($jobsResult)){

    if ($jobsStr==''){

        $jobsStr = $jRow['company_id'];

    }else{

        $jobsStr .= ','.$jRow['company_id'];

    }

}

if($debug == 1)
    echo "<br>jobsStr: ".$jobsStr."<br>";



$fundingsQuery = "select distinct(cf.company_id) from ".TABLE_COMPANY_FUNDING	." cf where  cf.funding_date>'".$before_date."' and cf.funding_date<'".$future_date."'";
if($debug == 1)
    echo "<br>fundingsQuery: ".$fundingsQuery."<br>";
$fundingsResult = com_db_query($fundingsQuery);

$fundingsStr = '';

while($fRow = com_db_fetch_array($fundingsResult)){

    if ($fundingsStr==''){

        $fundingsStr = $fRow['company_id'];

    }else{

        $fundingsStr .= ','.$fRow['company_id'];

    }

}
if($debug == 1)
    echo "<br>fundingsStr: ".$fundingsStr."<br>";

//if ($link) mysql_select_db("exec");
//com_db_connect() or die('Unable to connect to database server!');
//$alert_query = "select a.* from " . TABLE_ALERT . " as a, ".TABLE_USER." as u where a.user_id=u.user_id and u.status=0 and a.exp_date >'".date('Y-m-d'). "' and alert_date <= '".date('Y-m-d')."'   and a.status=0 and a.delivery_schedule <>'No Updates' and a.user_id = 422";//limit 0,20
$alert_query = "select a.* from " . TABLE_ALERT . " as a, ".TABLE_USER." as u where a.user_id=u.user_id and u.status=1 and a.exp_date >'".date('Y-m-d'). "' and alert_date <= '".date('Y-m-d')."'   and a.status=0 and a.delivery_schedule <>'No Updates'";//limit 0,20
if($debug == 1)
	echo "<br><br>===================================<br><br>alert_query: ".$alert_query ;
$alert_result = com_db_query($alert_query);

//com_db_connect_hre2() or die('Unable to connect to database server!');
$addLeadText = "Add&nbsp;as&nbsp;a&nbsp;Lead&#013;(Only&nbsp;for&nbsp;Ent&nbsp;license)";

while($alert_row = com_db_fetch_array($alert_result)){

    echo "<br>speaking: ".$alert_row['speaking']."<br>";
    //if($alert_row['title'] == '' && $alert_row['type'] == '' && $alert_row['country'] == '' && $alert_row['state'] == '' && $alert_row['city'] == '' && $alert_row['zip_code'] == '' && $alert_row['company'] == '' && $alert_row['company_website'] == '' && $alert_row['industry'] == '' && $alert_row['revenue_size'] == '' && $alert_row['employee_size'] == '')
    if($alert_row['speaking'] != '0' || $alert_row['awards'] != '0' || $alert_row['publication'] != '0' || $alert_row['media_mention'] != '0' || $alert_row['board'] != '0')
    {
        $only_triggers = 1;
    }   
    else
        $only_triggers = 0;
            
    echo "<br>only_triggers: ".$only_triggers."<br>";        
            
            
            
    if($debug == 1)
        echo "<br><br><br><br><br>alert_id: ".$alert_row['alert_id'];
    $user_email = com_db_GetValue("select email from " .TABLE_USER . " where user_id='".$alert_row['user_id']."'");
    $user_first_name = com_db_GetValue("select first_name from " .TABLE_USER . " where user_id='".$alert_row['user_id']."'");
    $alert_create_date = $alert_row['add_date'];
		 //for user
                  
    if($debug == 1)
          echo "<br><br>sent_contact_id Query: select contact_id,job_id,funding_id,personal_id from " .TABLE_ALERT_SEND_INFO." where alert_id='".$alert_row['alert_id']."' and user_id='".$alert_row['user_id']."'";

    //$sent_contact_result = com_db_query("select contact_id,job_id,funding_id,personal_id from " .TABLE_ALERT_SEND_INFO." where alert_id='".$alert_row['alert_id']."' and user_id='".$alert_row['user_id']."'");
    $sent_contact_result = com_db_query("select contact_id,job_id,funding_id,personal_id from " .TABLE_ALERT_SEND_INFO." where user_id='".$alert_row['user_id']."'");

    $sent_contact_id='';
    $sent_personal_id = '';

    while($sent_contact_row = com_db_fetch_array($sent_contact_result)){

        if($sent_contact_id=='' && $sent_contact_row['contact_id'] !=''){

              $sent_contact_id = $sent_contact_row['contact_id'];	

        }elseif($sent_contact_row['contact_id'] !=''){

              $sent_contact_id .=','.$sent_contact_row['contact_id'];

        }	



        // jobs
        if($sent_job_id=='' && $sent_contact_row['job_id'] !=''){

              $sent_job_id = $sent_contact_row['job_id'];	

        }elseif($sent_contact_row['job_id'] !=''){

              $sent_job_id .=','.$sent_contact_row['job_id'];

        }	


        // fundings
        if($sent_funding_id=='' && $sent_contact_row['funding_id'] !=''){

              $sent_funding_id = $sent_contact_row['funding_id'];	

        }elseif($sent_contact_row['funding_id'] !=''){

              $sent_funding_id .=','.$sent_contact_row['funding_id'];

        }	


        if($sent_personal_id=='' && $sent_contact_row['personal_id'] !=''){

              $sent_personal_id = $sent_contact_row['personal_id'];	

        }elseif($sent_contact_row['personal_id'] !=''){

              $sent_personal_id .=','.$sent_contact_row['personal_id'];

        }

    }
    if($debug == 1)
        echo "<br><br>sent_contact_id FIRST: ".$sent_contact_id;


    if($debug == 1)
        echo "<br><br>sent_personal_id FIRST: ".$sent_personal_id;

		  
		  
    $message ='';

    $message_info = '';

    $alert_metch_str='';

    if($alert_row['title'] !=''){

            $alert_metch_str = " mm.title='".$alert_row['title']."'";

    }

    if($alert_row['type'] !=''){

            if($alert_metch_str==''){

                  $alert_metch_str = " mm.movement_type='".$alert_row['type']."'";

            }else{

                  $alert_metch_str .=" and mm.movement_type='".$alert_row['type']."'";

            }

    }

    if($alert_row['country'] !=''){

           if($alert_metch_str==''){

                   $alert_metch_str ="cm.country='".$alert_row['country']."'";

           }else{

                   $alert_metch_str .=" and cm.country='".$alert_row['country']."'";

           }

    }

    if($alert_row['state'] !=''){

        if($alert_metch_str==''){

             $alert_metch_str =" cm.state in (".$alert_row['state'].")";

        }else{

             $alert_metch_str .=" and cm.state in (".$alert_row['state'].")";

        }

    }

    if($alert_row['city'] !='' || $alert_row['zip_code'] !='' ){

        if($alert_metch_str=='')
        {
            if($alert_row['city'] !='' && $alert_row['zip_code'] !=''){
                $alert_metch_str =" ( cm.city='".$alert_row['city']."' or cm.zip_code='".$alert_row['zip_code']."')";
            }elseif($alert_row['city'] !=''){
                $alert_metch_str =" ( cm.city='".$alert_row['city']."')";
            }elseif($alert_row['zip_code'] !=''){
                $alert_metch_str = " ( cm.zip_code='".$alert_row['zip_code']."')";
            }
        }
        else
        {
            if($alert_row['city'] !='' && $alert_row['zip_code'] !=''){
                $alert_metch_str .=" and ( cm.city='".$alert_row['city']."' or cm.zip_code='".$alert_row['zip_code']."')";
            }elseif($alert_row['city'] !=''){
                $alert_metch_str .=" and ( cm.city='".$alert_row['city']."')";
            }elseif($alert_row['zip_code'] !=''){
                $alert_metch_str .=" and ( cm.zip_code='".$alert_row['zip_code']."')";
            }
        }
    }

		  //Company Name start

    $company_name_str ='';

    if($alert_row['company'] !=''){

           $company_name_str = " cm.company_name='".$alert_row['company']."'";

    }

    //Company website start

    $company_website_str='';

    if($alert_row['company_website'] !=''){

        $webArr = explode("<br />",$alert_row['company_website']);

        $webStr='';

        $comp_url_limit = 200;
        if(sizeof($webArr) > 200)
            $loop_limit = $comp_url_limit;
        else
            $loop_limit = sizeof($webArr);
        
        //for($wb=0; $wb < sizeof($webArr); $wb++){
        for($wb=0; $wb < $loop_limit; $wb++){

            
            $webArr[$wb] = trim($webArr[$wb]);
            if(substr($webArr[$wb],0,4) != 'www.')
            {        
                $webArr[$wb] = modify_url($webArr[$wb]);
            }
            echo "<br>After url modification: ".$webArr[$wb];
            
            if($webStr =='')
            {
                $webStr = " (cm.company_website like '%".$webArr[$wb]."') ";
            }
            else
            {
                $webStr .= " or (cm.company_website like '%".$webArr[$wb]."') ";
            }

        }

        if($webStr !=''){

            $company_website_str =  " (".$webStr.") ";

        } 

    }

		  //Company Employee size, Revenue size and Industry start

    $company_emp_rev_ind_str='';

    if($alert_row['industry_id'] !=''){
        if($company_emp_rev_ind_str==''){
             $company_emp_rev_ind_str =" cm.industry_id in (".$alert_row['industry_id'].")";
        }else{
             $company_emp_rev_ind_str .=" and cm.industry_id in (".$alert_row['industry_id'].")";
        }
    }

    if($alert_row['revenue_size'] !=''){
        if($company_emp_rev_ind_str==''){
            $company_emp_rev_ind_str =" cm.company_revenue in (".$alert_row['revenue_size'].")";
        }else{
            $company_emp_rev_ind_str .=" and cm.company_revenue in (".$alert_row['revenue_size'].")";
        }
    }

    if($alert_row['employee_size'] !=''){
        if($company_emp_rev_ind_str==''){
             $company_emp_rev_ind_str =" cm.company_employee in (".$alert_row['employee_size'].")";
        }else{
             $company_emp_rev_ind_str .=" and cm.company_employee in (".$alert_row['employee_size'].")";
        }

    }

    //Company information

    if($company_name_str !='' || $company_emp_rev_ind_str !='' || $company_website_str !='')
    {
        $company_all_str = '';
        if($company_name_str !=''){
            $company_all_str = '('.$company_name_str.')';
        }

        if($company_website_str !=''){
            if($company_all_str ==''){
                $company_all_str = '('.$company_website_str.')';
            }else{
                $company_all_str .= ' or ('.$company_website_str.')';
            }
        }

        if($company_emp_rev_ind_str !='')
        {
            if($company_all_str ==''){
            $company_all_str = '('.$company_emp_rev_ind_str.')';
            }else{
                $company_all_str .= ' or ('.$company_emp_rev_ind_str.')';
            }
        }

        if($alert_metch_str==''){
            $alert_metch_str = ' ( '.$company_all_str.' ) ';
        }else{
            $alert_metch_str .= " and ( ".$company_all_str.' ) ';
        }
    }

		  //Triggers 5 start

    $triggers='';

    if($debug == 1)
        echo "<br>Alert award value:".$alert_row['awards'];

    if($alert_row['awards'] ==1 && $awardsStr !=''){
        if($triggers==''){
            $triggers =" (pm.personal_id in (".$awardsStr."))";
        }else{
            $triggers .=" or (pm.personal_id in (".$awardsStr."))";  
        }
    }
    if($alert_row['board'] ==1 && $boardStr !=''){
            if($triggers==''){
                $triggers =" (pm.personal_id in (".$boardStr."))";
            }else{
                $triggers .=" or (pm.personal_id in (".$boardStr."))";  
            }

    }

    if($alert_row['media_mention'] ==1 && $mediaStr !=''){
        if($triggers==''){
            $triggers =" (pm.personal_id in (".$mediaStr."))";
        }else{
            $triggers .=" or (pm.personal_id in (".$mediaStr."))";  
        }
    }

    if($alert_row['publication'] ==1 && $pubStr !=''){
        if($triggers==''){
            $triggers =" (pm.personal_id in (".$pubStr."))";
        }else{
            $triggers .=" or (pm.personal_id in (".$pubStr."))";  
        }
    }
    echo "<br>alert row speaking: ".$alert_row['speaking'];
    echo "<br>speakingStr: ".$speakingStr;
    if($alert_row['speaking'] ==1 && $speakingStr !='')
    {
        if($triggers=='')
        {
            $triggers =" (pm.personal_id in (".$speakingStr."))";
        }
        else
        {
            $triggers .=" or (pm.personal_id in (".$speakingStr."))";  
        }
    }
		  
    // FAR TODO - jobs and funds
    /*
    if($alert_row['jobs'] ==1 && $jobsStr !='')
    {

            if($triggers==''){

                  $triggers =" (cm.company_id in (".$jobsStr."))";

            }else{

                  $triggers .=" or (cm.company_id in (".$jobsStr."))";  

            }

    }

    if($alert_row['fundings'] ==1 && $fundingsStr !='')
    {

            if($triggers==''){

                  $triggers =" (cm.company_id in (".$fundingsStr."))";

            }else{

                  $triggers .=" or (cm.company_id in (".$fundingsStr."))";  

            }

    }

    */
    echo "<br>triggers: ".$triggers;

    if($triggers!='')
    {
        if($alert_metch_str=='')
        {
            $alert_metch_str = ' ( '.$triggers.' ) ';
        }
        else
        {
            $alert_metch_str .= " and ( ".$triggers.' ) ';

        }
    }

    //Triggers 5 end
    if($alert_row['add_date'] == date("Y-m-d")){
           $movement_add_date = " mm.add_date <'".date("Y-m-d")."'";
    }else{
           $movement_add_date = " mm.add_date >='".$alert_row['previous_date']."' and mm.add_date < '".date("Y-m-d")."'";
    }

    $effective_date_within_60day = date("Y-m-d",mktime(0,0,0,date("m"),(date("d")-60),date("Y"))); 

    $email_query1 = "select mm.move_id,mm.personal_id,mm.title,mm.movement_type,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
        pm.first_name,pm.middle_name,pm.last_name,pm.personal_image,pm.email,pm.phone,pm.about_person,cm.company_name,
        cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
        cm.fax,cm.about_company,m.name as movement_name,so.source as source,
        s.short_name as state,ct.countries_name as country,i.title as company_industry,
        r.name as company_revenue,e.name as company_employee,cm.company_logo,'' as job_id,'' as funding_id,cm.company_id,1 as res_type from " 
        .TABLE_MOVEMENT_MASTER. " as mm, "
        .TABLE_PERSONAL_MASTER. " as pm, "
        .TABLE_COMPANY_MASTER. " as cm, " 
        .TABLE_MANAGEMENT_CHANGE." as m, "
        .TABLE_SOURCE." as so, "
        .TABLE_STATE." as s, "
        .TABLE_COUNTRIES." as ct, "
        .TABLE_INDUSTRY." as i, "
        .TABLE_REVENUE_SIZE." as r, "
        .TABLE_EMPLOYEE_SIZE." as e    
        where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_url <>'' and mm.movement_type=m.id and mm.source_id=so.id and effective_date > '".$effective_date_within_60day."' and ".$movement_add_date.") 
        and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id)";				



    $email_query2 = "select mm.move_id,mm.personal_id,mm.title,mm.movement_type,mm.announce_date,mm.what_happened,mm.movement_url,mm.effective_date,mm.announce_date,mm.headline,mm.full_body,mm.short_url,mm.more_link,
        pm.first_name,pm.middle_name,pm.last_name,pm.personal_image,pm.email,pm.phone,pm.about_person,cm.company_name,
        cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
        cm.fax,cm.about_company,m.name as movement_name,so.source as source,
        s.short_name as state,ct.countries_name as country,i.title as company_industry,
        r.name as company_revenue,e.name as company_employee,cm.company_logo,'' as job_id, '' as 'funding_id',cm.company_id,1 as res_type  from " 
        .TABLE_MOVEMENT_MASTER. " as mm, "
        .TABLE_PERSONAL_MASTER. " as pm, "
        .TABLE_COMPANY_MASTER. " as cm, " 
        .TABLE_MANAGEMENT_CHANGE." as m, "
        .TABLE_SOURCE." as so, "
        .TABLE_STATE." as s, "
        .TABLE_COUNTRIES." as ct, "
        .TABLE_INDUSTRY." as i, "
        .TABLE_REVENUE_SIZE." as r, "
        .TABLE_EMPLOYEE_SIZE." as e    
        where (mm.company_id=cm.company_id and mm.personal_id=pm.personal_id and mm.status ='0' and mm.movement_url <>'' and mm.movement_type=m.id and mm.source_id=so.id) 
        and (cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id)";	
        echo "<br>triggers: ".$triggers;                                    
        $email_query3 = "SELECT pm.personal_id,pm.first_name,pm.middle_name,pm.last_name,pm.personal_image FROM "
        .TABLE_PERSONAL_MASTER. " as pm "; 
                    
                    
    //if($debug == 1)
        //	echo "<br><br>sent_personal_id FIRST: ".$sent_personal_id;
                    
    
    $email_query3 .= " where 1= 1 and (".$triggers.")";
    $limit_by_clause = " limit 0,10";   
		  //Personal Photo and email checking on/off
    $pfQuery = "select * from ".TABLE_PERSONAL_FILTER_ONOFF." where filter_onoff='ON'";
    $pfResult = com_db_query($pfQuery);
    $pfString='';
    while($pfRow = com_db_fetch_array($pfResult))
    {
        if($pfRow['filter_name']=='Personal Image Checking' &&  $pfRow['filter_onoff']=='ON')
        {
            if($pfString=='')
            {
                $pfString = ' pm.personal_image <> ""';
            }
            else
            {
                $pfString .= ' and pm.personal_image <> ""';
            }

        }
        elseif($pfRow['filter_name']=='Personal Email Checking' &&  $pfRow['filter_onoff']=='ON')
        {
            if($pfString==''){
                   $pfString = ' (pm.email<>"" and pm.email<>"n/a" and pm.email<>"N/A")';
            }else{
                   $pfString .= ' and (pm.email<>"" and pm.email<>"n/a" and pm.email<>"N/A")';
            }
        }
    }
    if($pfString !=''){
        $email_query2 = $email_query2 . " and (".$pfString.")"; 
        $email_query1 = $email_query1; 
    }

	 
    echo "<br>only_triggers: ".$only_triggers;
    if($only_triggers == 1)
    {

        if($sent_personal_id != '')
        {
            $email_query = $email_query3 .' and  personal_id not in ('. $sent_personal_id.')';
        }    
        else
            $email_query = $email_query3;
        $email_query .= $limit_by_clause;
    }
    else
    {    
        if($alert_metch_str =='')
        {
            $email_query = $email_query1;
        }
        elseif($alert_metch_str !='' && $triggers=='')
        {
            $email_query = $email_query1." and ".$alert_metch_str;

        }
        elseif($alert_metch_str !='' && $triggers !='')
        {
            $email_query = $email_query2." and ".$alert_metch_str;
        }

        // Added By FA to stop bulk movement uploads going in alerts email
        $email_query .= ' and source_bulk_upload != 1 '; 
                   
        // FAR UNDO MUST
        //$sent_contact_id = '';
        //$sent_job_id = '';
        //$sent_funding_id = '';
		  
        $move_id_not_in = '';
        if($sent_contact_id == '')
        {
            //$email_query = $email_query." order by mm.move_id desc limit 0,10";
            $email_query = $email_query;
        }
        else
        {
            $sent_contact_id = trim($sent_contact_id,",");
            //$email_query = $email_query .' and  mm.move_id not in ('. $sent_contact_id.') order by mm.move_id desc limit 0,10';
            $email_query = $email_query .' and  move_id not in ('. $sent_contact_id.')';
            //$move_id_not_in = ' and move_id not in ('. $sent_contact_id.')';
        }

        if($debug == 1)
              echo "<br><br>sent_contact_id TWO: ".$sent_contact_id;

        //$order_by_clause = " order by move_id desc";
        $order_by_clause = " order by company_id desc";
		  
        if($alert_row['jobs'] == 1)
        {

            /*if(sizeof($header_company_id_arr) > 0)
            {
                    $header_company_ids = implode($header_company_id_arr,",");
            }	
            */
            $email_query .= " UNION select '' as move_id,'' as personal_id,'' as title,'' as movement_type,'' as announce_date,'' as what_happened,'' as movement_url,'' as effective_date,'' as announce_date,'' as headline,'' as full_body,'' as short_url,'' as more_link,
              '' as first_name,'' as middle_name,'' as last_name,'' as personal_image,'' as email,'' as phone,'' as about_person,cm.company_name,
              cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
              cm.fax,cm.about_company,'' as movement_name,'' as source,
              '' as state,'' as country,'' as company_industry,
              '' as company_revenue,'' as company_employee,cm.company_logo,cj.job_id as 'job_id','' as funding_id,cm.company_id,2 as res_type from " 
              .TABLE_COMPANY_MASTER. " as cm, " 
              .TABLE_COMPANY_JOB_INFO." as cj 
              where (cm.company_id=cj.company_id )"; 

            if($jobsStr != '')
            {
                $email_query .= " and cm.company_id in (".$jobsStr.")";
            }	

            if($sent_job_id != '')
            {
                $email_query .= " and cj.job_id not in (".$sent_job_id.")";
            }						

        }
			
        if($alert_row['fundings'] == 1)
        {
            $email_query .= " UNION select '' as move_id,'' as personal_id,'' as title,'' as movement_type,'' as announce_date,'' as what_happened,'' as movement_url,'' as effective_date,'' as announce_date,'' as headline,'' as full_body,'' as short_url,'' as more_link,
            '' as first_name,'' as middle_name,'' as last_name,'' as personal_image,'' as email,'' as phone,'' as about_person,cm.company_name,
            cm.company_website,cm.address,cm.address2,cm.city,cm.zip_code,cm.phone as cphone,
            cm.fax,cm.about_company,'' as movement_name,'' as source,
            '' as state,'' as country,'' as company_industry,
            '' as company_revenue,'' as company_employee,cm.company_logo,'' as 'job_id',cf.funding_id as funding_id,cm.company_id,3 as res_type from " 
            .TABLE_COMPANY_MASTER. " as cm, " 
            .TABLE_COMPANY_FUNDING." as cf 
            where (cm.company_id=cf.company_id)"; 

            if($fundingsStr != '')
            {
                $email_query .= " and cm.company_id in (".$fundingsStr.")";
            }

            if($sent_funding_id != '')
            {
                $email_query .= " and cf.funding_id not in (".$sent_funding_id.")";
            }		
        }
		  
        $email_query .= $order_by_clause;
        $email_query .= $limit_by_clause;
    }  
    //echo '<br><br>FAR UNDO : '.$email_query .'<br>'; 
    if($debug == 1)
        echo '<br><br>FAR UNDO : '.$email_query .'<br>'; 
    //die();
    $email_result = com_db_query($email_query);
    if($email_result)
    {
        $numRows = com_db_num_rows($email_result);
    }

    $total_contact_id='';
    $total_job_id='';
    $total_funding_id='';
    $user_id = $alert_row['user_id'];
    $alert_id = $alert_row['alert_id'];
    $email_alert_id = $user_id.'_'.$alert_id.'_'.time();
    if($debug == 1)
        echo '<br>FAR UNDO numRows : '.$numRows .'<br>';

    if($numRows>0 && $user_email !='')
    {
        $messageHead = '<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eaeaea">
        <tr>
        <td align="center" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" class="w320">
                <tr>
                    <td align="center">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
                            <tr>
                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div style="font-size:0pt; line-height:0pt; height:45px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="45" style="height:45px" alt="" /></div></td>
                                <td class="column2"><div class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left">Having trouble viewing this email? <a href="'.HTTP_SERVER_EXEC.DIR_WS_HTTP_FOLDER.'alert-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">View it in your browser</span></a></div></td>
                                <td align="right" class="column2">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
                                            <td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER_EXEC.DIR_WS_HTTP_FOLDER.'alert-email-show.php?emailid='.$email_alert_id.'" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Online version</span></a></td>
                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="17"></td>	
                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="8"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet1.jpg" alt="" border="0" width="2" height="3" /></td>
                                            <td class="top" style="color:#7a7a7a; font-family:Arial; font-size:11px; line-height:18px; text-align:left"><a href="mailto:<Please enter your friend email id?subject=Congrats&amp;body=Congrats%20on%20your%20recent%20appointment" target="_blank" class="link-top" style="color:#5c97d8; text-decoration:underline"><span class="link-top" style="color:#5c97d8; text-decoration:underline">Forward to a friend</span></a></td>
                                            </tr>
                                    </table>
                                </td>
                                <td class="mobile-space" style="font-size:0pt; line-height:0pt; text-align:left"></td>
                            </tr>
                        </table>
                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#cfcfcf; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'/images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                    </td>
                </tr>
            </table>
            <div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                <tr>
                    <td align="center">
                        <table width="650" border="0" cellspacing="0" cellpadding="0" class="w320">
                            <tr>
                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php" target="_blank"><img src="http://execfile.com/css/images/new-logo.png" width="336" height="61" alt="" border="0" /></a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                <tr>
                    <td align="center">
                        <table width="660" border="0" cellspacing="0" cellpadding="0" class="w320">
                            <tr>
                                <td align="center">';
                                    $personal_id_with_trigger='';	
                                    $cnt=1;
                                    $messageSrt='';
                                    $messageEmailStr='';
                                    $messageEmail='';	
                                    $person_info = array();
                                    $person_id_info = array();
                                    $header_company_id_arr = array();
                                    $header_funding_company_id_arr = array();
                                    $person_sorting = 0;
                                    $jobs_sorting = 0;
                                    $fundings_sorting = 0;

                                    $total_personal_id = "";

                                    $p=0;			
                                    while($email_row = com_db_fetch_array($email_result))
                                    {

                                        if($email_row['move_id'] != '')
                                        {
                                            if($total_contact_id=='')
                                            {	
                                                $total_contact_id = $email_row['move_id'];
                                            }
                                            else
                                            {
                                                $total_contact_id .=",". $email_row['move_id'];
                                            }
                                        } 
				  
                                        if($email_row['job_id'] != '')
                                        {
                                            if($total_job_id=='')
                                            {	
                                                $total_job_id = $email_row['job_id'];
                                            }
                                            else
                                            {
                                                $total_job_id .=",". $email_row['job_id'];

                                            }	
                                        }	  
                                        // echo "<br>FAR Undo total_job_id TOP : ".$total_job_id;
				  
                                        if($email_row['funding_id'] != '')
                                        {
                                            if($total_funding_id=='')
                                            {	
                                                $total_funding_id = $email_row['funding_id'];
                                            }
                                            else
                                            {
                                                $total_funding_id .=",". $email_row['funding_id'];
                                            }	
                                        }
                                        //echo "<br>Only trigger before personal id : ".$only_triggers;
                                        if($only_triggers == 1)
                                        {
                                            if($total_personal_id=='')
                                            {	
                                                $total_personal_id = $email_row['personal_id'];
                                            }
                                            else
                                            {
                                                $total_personal_id .=",". $email_row['personal_id'];
                                            }

                                        }    

                                        $person_id = $email_row['personal_id'];
                                        $pFirstName = trim(com_db_output($email_row['first_name']));
                                        $pLastName = trim(com_db_output($email_row['last_name']));	
                                        $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

					if($debug == 1)
					{					
                                            echo "<br><br><br><br><br>Move id: ".$email_row['move_id'];
                                            echo "<br>effective_date_within_60day: ".$effective_date_within_60day;
                                            echo "<br>email_row effective_date: ".$email_row['effective_date'];
					}
					
                                        if($email_row['effective_date'] > $effective_date_within_60day)
                                        {
                                            if($debug == 1)
						echo "<br>Within if effective date wala";

                                            if($email_row['movement_type']==1){
                                                $movement = ' was Appointed as ';

                                            }elseif($email_row['movement_type']==2){
                                                $movement = ' was Promoted to ';
                                            }elseif($email_row['movement_type']==3){
                                                $movement = ' Retired as ';
                                            }elseif($email_row['movement_type']==4){
                                                $movement = ' Resigned as '; 
                                            }elseif($email_row['movement_type']==5){
                                                $movement = ' was Terminated as ';
                                            }elseif($email_row['movement_type']==6){
                                                $movement = ' was Appointed to ';
                                            }elseif($email_row['movement_type']==7){
                                                $movement = ' Job Opening ';
                                            }

                                        $movement_url = HTTP_SERVER.$email_row['movement_url'];	
                                        $heading = com_db_output($email_row['first_name'].' '.$email_row['last_name'].$movement.$email_row['title'].' at '.$email_row['company_name']);
                                        $personal_image = $email_row['personal_image'];
                                        if($personal_image !=''){
                                          $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;
                                        }else{
                                          $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';
                                        }
					  

                                        if($email_row['more_link'] =='')
                                        {
                                            
                                            $sf = "";
                                            if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                            {    
                                                // FA Todo SF , add title , company name , email
                                                 
                                                $sf_company_name = $email_row['company_name'];
                                                $sf_title = $email_row['title'];
                                                $sf_email = $email_row['email'];
                                                
                                                $sf_phone = $email_row['phone'];
                                                
                                                //$email_row['title']
                                                //$email_row['email']
                                                //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($email_row['first_name'])."&lname=".urlencode($email_row['last_name'])."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                            }
                                            
                                            
                                            
                                            
                                            
                                            
                                            $messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                                                            <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                                                '.$heading.'
                                                                <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td align="left">
                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                    <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
                                                                                    '.$sf.'
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td align="right" width="170" class="btn-container">
                                                                <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                                                    <tr>
                                                                        <td>
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                                                <tr>
                                                                                    <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                                                        <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                                                    </td>
                                                                                    <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                        //if($cnt<=5){
                                            if($cnt<=15)
                                            {
                                                $messageEmailStr .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                                                                    <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                                                        '.$heading.'
                                                                        <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                            <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>
                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
                                                                                             '.$sf.'
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" width="170" class="btn-container">
                                                                        <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                                                        <tr>
                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                                                                <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                                                            </td>
                                                                                            <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                            }
                                        }
                                        else
                                        {
                                            // Salesforce button for Appointments and Promotions
                                            $sf = "";
                                            if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                            {    
                                                // FA Todo SF , add title , company name , email
                                                 
                                                $sf_company_name = $email_row['company_name'];
                                                $sf_title = $email_row['title'];
                                                $sf_email = $email_row['email'];
                                                
                                                $sf_phone = $email_row['phone'];
                                                
                                                //$email_row['title']
                                                //$email_row['email']
                                                //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($email_row['first_name'])."&lname=".urlencode($email_row['last_name'])."&company_name=".urlencode($sf_company_name)."&title=".urlencode($sf_title)."&email=".urlencode($sf_email)."&phone=".urlencode($sf_phone)."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                            }
                                             
                                            $messageSrt .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                    <tr>
                                                        <td>
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                                                                    <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                                                        '.$heading.'
                                                                        <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                                                        <tr>
                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                            <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$email_row['more_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                            '.$sf.'    
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                    <td align="right" width="170" class="btn-container">
                                                                        <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                                                            <tr>
                                                                                <td>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                                                        <tr>
                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                                                            <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                                                             </td>
                                                                                            <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                                                        </tr>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
						</table>

                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';

                                                //if($cnt<=5){
                                                if($cnt<=15)
                                                {
                                                    // FA NEED TO ADD SALESFORCE BUTTON HERE
                                                    $messageEmailStr .='<table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                        <tr>
                                                            <td>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                                                                        <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                                                            '.$heading.'
                                                                            <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="left">
                                                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                                                <tr>
                                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                    <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$email_row['more_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
                                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                    '.$sf.'    
                                                                                                </tr>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                        </td>

                                                                        <td align="right" width="170" class="btn-container">
                                                                            <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                                                                <tr>
                                                                                    <td>
                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                                                            <tr>
                                                                                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                                                                <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                                                                 </td>
                                                                                                <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                                }
                                        }
                                        $cnt++;
                                    }

				  
                                    $job_id = $email_row['job_id'];
                                    $funding_id = $email_row['funding_id'];	
                                    if($debug == 1)
                                    {
                                        //echo "<br><br>FAR Email row job_id : ".$email_row['job_id'];
                                        echo "<br><br>FAR email row company_id : ".$email_row['company_id'];
                                        echo "<br>FAR alert row jobs : ".$alert_row['jobs'];
                                        echo "<br>FAR alert row fundings : ".$alert_row['fundings'];
                                        echo "<br>FAR email row res type : ".$email_row['res_type'];
                                        echo "<br>FAR Email row job_id : ".$job_id;
                                        echo "<br>FAR Email row funding_id : ".$funding_id;
                                        echo "<br>FAR person_id : ".$person_id;
                                        echo "<br>FAR awardsStr : ".$awardsStr;
                                        echo "<br>FAR boardStr : ".$boardStr;
                                        echo "<br>FAR mediaStr : ".$mediaStr;
                                        echo "<br>FAR pubStr : ".$pubStr;
                                        echo "<br>FAR speakingStr : ".$speakingStr;

                                    }	
					// Block to add person images in header row ENDS
                                    $trigger_person = 0;
                                    if(strpos($awardsStr,$person_id) > -1)
                                            $trigger_person = 1;
                                    elseif(strpos($boardStr,$person_id) > -1)
                                            $trigger_person = 1;
                                    elseif(strpos($mediaStr,$person_id) > -1)
                                            $trigger_person = 1;		
                                    elseif(strpos($pubStr,$person_id) > -1)
                                            $trigger_person = 1;
                                    elseif(strpos($speakingStr,$person_id) > -1)
                                            $trigger_person = 1;	

                                    if($debug == 1)
                                        echo "<pre>person_id_info STARTS:";	print_r($person_id_info);	echo "</pre>";

					
                                    // persons sorting order range = 1 - 20
                                    // jobs sorting order range = 21 - 40
                                    // fundings sorting order range = 41 - 60
					
                                    if(sizeof($person_id_info)==0)
                                    {
                                        if($debug == 1)
                                            echo "<br>FAR Within empty person_id_info array";
                                        //if($alert_row['jobs'] == 1)
                                        if($job_id == '' && $funding_id == '')
                                        {
                                            if($debug == 1)
                                                echo "<br>FAR Within empty job_id and funding_id";
                                            if($trigger_person == 1)
                                            {
                                                if($debug == 1)
                                                    echo "<br>FAR In trigger person";
                                                $person_info[$p]['type'] = "Person";
                                                if($debug == 1)
                                                    echo "<br>FAR berfore adding person in person id info array :$person_id:";
                                                $person_id_info[] = $person_id;
                                                $personal_image = $email_row['personal_image'];
                                                if($personal_image !=''){
                                                    $person_info[$p]['pimage'] = $personal_image;
                                                }
                                                else
                                                {
                                                    //$person_info[$p]['pimage'] = "https://www.ctosonthemove.com/personal_photo/small/no_image_information.png:HEIGHT:80";  //'no_image_information.png';
                                                    $person_info[$p]['pimage'] = "no_image_information.png";  //'no_image_information.png';
                                                }

                                                $person_info[$p]['purl'] = $personalURL;
                                                $person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
                                                $person_info[$p]['sorter'] = $person_sorting;
                                                $person_sorting++;
                                                $p++;
                                            }
                                            elseif($email_row['effective_date'] > $effective_date_within_60day)
                                            {
                                                if($debug == 1)
                                                    echo "<br>FAR In person move";
                                                $person_info[$p]['type'] = "Person";
                                                if($debug == 1)
                                                    echo "<br>FAR berfore adding person in person id info array :$person_id:";
                                                $person_id_info[] = $person_id;

                                                $personal_image = $email_row['personal_image'];

                                                if($personal_image !=''){
                                                    $person_info[$p]['pimage'] = $personal_image;
                                                }else{
                                                    $person_info[$p]['pimage'] = 'no_image_information.png';
                                                }

                                                $person_info[$p]['purl'] = $personalURL;

                                                $person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
                                                $person_info[$p]['sorter'] = $person_sorting;
                                                $person_sorting++;
                                                $p++;
                                            }	
                                        }
                                        elseif($job_id != '')
                                        {
                                            //cm.company_id
                                            if($debug == 1)
                                                    echo "<br>FAR In job";
                                            $person_info[$p]['type'] = "Company";
                                            $header_company_id_arr[] = $email_row['company_id'];
                                            //$person_id_info[] = $job_id;
                                            if($debug == 1)
                                                    echo "<br>FAR berfore adding company in person id info array :".$email_row['company_id'].":";
                                            $person_id_info[] = $email_row['company_id'];
                                            $personal_image = $email_row['company_logo'];

                                            //$org_personal_image_path = HTTP_SERVER.'company_logo/org/'.$personal_image;
                                            $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;


                                            $company_logo_resized = getImageXY($org_personal_image_path,80);

                                            if($personal_image !='')
                                            {
                                                $person_info[$p]['pimage'] = $company_logo_resized;  //$personal_image;
                                            }
                                            else
                                            {
                                                //$person_info[$p]['pimage'] = "https://www.ctosonthemove.com/personal_photo/small/no_image_information.png:HEIGHT:80";  //'no_image_information.png';
                                                $person_info[$p]['pimage'] = "no_image_information.png";  //'no_image_information.png';
                                            }

                                            $comp_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($email_row['company_name'])).'_Company_'.$email_row['company_id'];
                                            $person_info[$p]['purl'] = $comp_url;	
                                            $person_info[$p]['pname'] = substr($email_row['company_name'],0,12);

                                            $person_info[$p]['sorter'] = $jobs_sorting;
                                            $jobs_sorting++;

                                            $p++;
                                        }
                                        elseif($funding_id != '')
                                        {	
                                            if($debug == 1)
                                                    echo "<br>FAR In funding";
                                            $person_info[$p]['type'] = "Company";
                                            //cm.company_id
                                            $header_funding_company_id_arr[] = $email_row['company_id'];
                                            //$person_id_info[] = $funding_id;
                                            if($debug == 1)
                                                    echo "<br>FAR berfore adding company in person id info array :".$email_row['company_id'].":";
                                            $person_id_info[] = $email_row['company_id'];

                                            $personal_image = $email_row['company_logo'];

                                            $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;

                                            $company_logo_resized = getImageXY($org_personal_image_path,80);

                                            if($personal_image !='')
                                            {
                                                $person_info[$p]['pimage'] = $company_logo_resized; //$personal_image;
                                            }
                                            else
                                            {
                                                //$person_info[$p]['pimage'] = "https://www.ctosonthemove.com/personal_photo/small/no_image_information.png:HEIGHT:80";  //'no_image_information.png';
                                                $person_info[$p]['pimage'] = "no_image_information.png";  //'no_image_information.png';
                                            }

                                            $comp_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($email_row['company_name'])).'_Company_'.$email_row['company_id'];
                                            $person_info[$p]['purl'] = $comp_url;
                                            $person_info[$p]['pname'] = substr($email_row['company_name'],0,12);
                                            $person_info[$p]['sorter'] = $fundings_sorting;
                                            $fundings_sorting++;
                                            $p++;
                                        }
                                    }
                                    elseif(!in_array($person_id,$person_id_info) && !in_array($email_row['company_id'],$person_id_info))
                                    {
                                        if($debug == 1)
                                            echo "<br>FAR Within Non-empty person_id_info array";
                                        if($job_id == '' && $funding_id == '')
                                        {
                                            if($debug == 1)
                                                echo "<br>FAR Within empty job_id and funding_id";
                                            if($trigger_person == 1)
                                            {
                                                if($debug == 1)
                                                        echo "<br>FAR In trigger";
                                                $person_info[$p]['type'] = "Person";
                                                if($debug == 1)	
                                                        echo "<br>FAR berfore adding person in person id info array ESLE If :$person_id:";
                                                $person_id_info[] = $person_id;

                                                $personal_image = $email_row['personal_image'];

                                                if($personal_image !=''){

                                                        $person_info[$p]['pimage'] = $personal_image;

                                                }else{

                                                        $person_info[$p]['pimage'] = 'no_image_information.png';

                                                }

                                                $person_info[$p]['purl'] = $personalURL;

                                                $person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);

                                                $person_info[$p]['sorter'] = $person_sorting;
                                                $person_sorting++;

                                                $p++;
                                            }
                                            elseif($email_row['effective_date'] > $effective_date_within_60day)
                                            {	
                                                if($debug == 1)
                                                        echo "<br>FAR In move person";
                                                $person_info[$p]['type'] = "Person";
                                                if($debug == 1)
                                                        echo "<br>FAR berfore adding person in person id info array ESLE If :$person_id:";
                                                $person_id_info[] = $person_id;

                                                $personal_image = $email_row['personal_image'];

                                                if($personal_image !=''){

                                                        $person_info[$p]['pimage'] = $personal_image;

                                                }else{

                                                        $person_info[$p]['pimage'] = 'no_image_information.png';
                                                }

                                                $person_info[$p]['purl'] = $personalURL;
                                                $person_info[$p]['pname'] = substr($pFirstName.' '.$pLastName,0,12);
                                                $person_info[$p]['sorter'] = $person_sorting;
                                                $person_sorting++;
                                                $p++;
                                            }	
                                        }
                                        elseif($job_id != '')
                                        {
                                            if($debug == 1)
                                                    echo "<br>FAR In job";
                                            $person_info[$p]['type'] = "Company";
                                            $header_company_id_arr[] = $email_row['company_id'];
                                            if($debug == 1)
                                                    echo "<br>FAR berfore adding company in person id info array ESLE If :".$email_row['company_id'].":";
                                            $person_id_info[] = $email_row['company_id'];
                                            $personal_image = $email_row['company_logo'];

                                            $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;
                                            $company_logo_resized = getImageXY($org_personal_image_path,80);

                                            if($personal_image !='')
                                            {
                                                $person_info[$p]['pimage'] = $company_logo_resized; //$personal_image;
                                            }
                                            else
                                            {
                                                //$person_info[$p]['pimage'] = "https://www.ctosonthemove.com/personal_photo/small/no_image_information.png:HEIGHT:80";  //'no_image_information.png';
                                                $person_info[$p]['pimage'] = "no_image_information.png";  //'no_image_information.png';
                                            }
                                            $comp_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($email_row['company_name'])).'_Company_'.$email_row['company_id'];
                                            $person_info[$p]['purl'] = $comp_url;

                                            $person_info[$p]['pname'] = substr($email_row['company_name'],0,12);//substr($pFirstName.' '.$pLastName,0,12);
                                            $person_info[$p]['sorter'] = $jobs_sorting;
                                            $jobs_sorting++;
                                            $p++;

                                        }
                                        elseif($funding_id != '')
                                        {
                                            if($debug == 1)
                                                    echo "<br>FAR In funding";
                                            $person_info[$p]['type'] = "Company";
                                            $header_funding_company_id_arr[] = $email_row['company_id'];
                                            if($debug == 1)
                                                    echo "<br>FAR berfore adding company in person id info array ESLE If :".$email_row['company_id'].":";
                                            $person_id_info[] = $email_row['company_id'];
                                            $personal_image = $email_row['company_logo'];

                                            $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;
                                            $company_logo_resized = getImageXY($org_personal_image_path,80);

                                            if($personal_image !='')
                                            {
                                                $person_info[$p]['pimage'] = $company_logo_resized; //$personal_image;
                                            }
                                            else
                                            {
                                                //$person_info[$p]['pimage'] = "https://www.ctosonthemove.com/personal_photo/small/no_image_information.png:HEIGHT:80";  //'no_image_information.png';
                                                $person_info[$p]['pimage'] = "no_image_information.png";  //'no_image_information.png';
                                            }

                                            $comp_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($email_row['company_name'])).'_Company_'.$email_row['company_id'];	
                                            $person_info[$p]['purl'] = $comp_url;

                                            $person_info[$p]['pname'] = substr($email_row['company_name'],0,12);//substr($pFirstName.' '.$pLastName,0,12);
                                            $person_info[$p]['sorter'] = $fundings_sorting;
                                            $fundings_sorting++;
                                            $p++;

                                        }
                                        if($debug == 1)
                                            echo "<pre>person_id_info ENDS:";	print_r($person_id_info);	echo "</pre>";
                                    }
                                    if($debug == 1)
                                        echo "<pre>person_info :";	print_r($person_info);	echo "</pre>";
					
                                    if($triggers !='')
                                    {
                                        if($personal_id_with_trigger =='')
                                        {
                                            $personal_id_with_trigger = $email_row['personal_id'];
                                        }
                                        else
                                        {
                                            $personal_id_with_trigger .= ",".$email_row['personal_id'];
                                        }

                                    }

				}//end while
				
				if($debug == 1)
				{
                                    echo "<pre>header_company_id_arr :";	print_r($header_company_id_arr);	echo "</pre>";
                                    echo "<pre>header_funding_company_id_arr :";	print_r($header_funding_company_id_arr);	echo "</pre>";
                                    echo "<pre>person_info :";	print_r($person_info);	echo "</pre>";
				}
				
                                // Sorting header array so that person comes first
                                sortBySubkey($person_info, 'type');
                                echo "<pre>person_info AFter sort :";	print_r($person_info);	echo "</pre>";
                                
				//$person_info = array_reverse($person_info);
				$totPerson = sizeof($person_info);

				$table1 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>';
				for($q=0;$q<4;$q++)
                                {
                                    if($person_info[$q]['pname'] !='')
                                    {
                                        $table1 .='<td valign="top" >';

                                        //$table1 .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;display: table-cell;vertical-align: middle;position:relative;">';
                                        $table1 .='<table cellpadding="0" cellspacing="0"><tr><td width="80" height="80" style="line-height:0px;">';
                                        //if($alert_row['jobs'] == 1)$person_info[$p]['type'] = "Company";
                                        if($person_info[$q]['type'] == 'Company')
                                        {
                                            $img_arr = explode(":HEIGHT:",$person_info[$q]['pimage']);
                                            //echo "<pre>img_arr :";	print_r($img_arr);	echo "</pre>";
                                            $table1 .='<a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
                                        }
                                        else
                                        {
                                            if($debug == 1)
                                            {    
                                                echo "<br><br>Personal image 0-4";   
                                                echo "<br>HTTP SERVER: ".HTTP_SERVER;
                                                echo "<br>DIR_WS_HTTP FOLDER: ".DIR_WS_HTTP_FOLDER;
                                            }    
                                            $table1 .='<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                                        }
                                        //$table1 .='</div>';

                                        $table1 .='</td></tr><tr><td height="20">';
                                        $table1 .='<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
                                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                        $table1 .='</td></tr></table>';
                                        $table1 .='</td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';

                                    }
                                    else
                                    {
                                        $table1 .='<td valign="top">
                                        <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
                                            &nbsp;
                                        </div>
                                        <div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center;>&nbsp;</div>
                                        <div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
                                        </td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
                                    }
				}
				$table1 .= '</tr>
                            </table>';

			   $table2 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>';
				for($q=4;$q<8;$q++)
                                {
                                    if($person_info[$q]['pname'] !='')
                                    {
                                        $table2 .='<td valign="top">';
                                        //$table2 .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;display: table-cell;vertical-align: middle;position:relative;"> ';
                                        $table2 .='<table  cellpadding="0" cellspacing="0"><tr><td width="80" height="80" style="line-height:0px;">';
                                        //if($alert_row['jobs'] == 1)
                                        if($person_info[$q]['type'] == 'Company')
                                        {
                                            $img_arr = explode(":HEIGHT:",$person_info[$q]['pimage']);
                                            //echo "<pre>img_arr :";	print_r($img_arr);	echo "</pre>";
                                            $table2 .='<a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
                                        }
                                        else
                                        {
                                            if($debug == 1)
                                            {    
                                                echo "<br><br>Personal image 4-8";   
                                                echo "<br>HTTP SERVER: ".HTTP_SERVER;
                                                echo "<br>DIR_WS_HTTP FOLDER: ".DIR_WS_HTTP_FOLDER;
                                            } 
                                            $table2 .='<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                                        }
                                        //$table2 .='</div>';
                                        $table2 .='</td></tr><tr><td height="20">';
                                        $table2 .='<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>
                                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                        $table2 .='</td></tr></table>';
                                        $table2 .='</td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';

                                    }
                                    else
                                    {
                                        $table2 .='<td valign="top">
                                            <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
                                            &nbsp;
                                            </div>
                                            <div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center;>&nbsp;</div>
                                            <div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
                                        </td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
                                    }
				}
				$table2 .= '</tr>
                            </table>';	

                            $table3 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>';

				for($q=8;$q<12;$q++)
                                {

                                    if($person_info[$q]['pname'] !='')
                                    {
                                        $table3 .='<td valign="top">';

                                        //$table3 .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;display: table-cell;vertical-align: middle;position:relative;"> ';
                                        $table3 .='<table  cellpadding="0" cellspacing="0"><tr><td width="80" height="80" style="line-height:0px;">';
                                        //if($alert_row['jobs'] == 1)
                                        if($person_info[$q]['type'] == 'Company')
                                        {
                                                $img_arr = explode(":HEIGHT:",$person_info[$q]['pimage']);
                                                $table3 .='<a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
                                        }
                                        else
                                        {
                                            if($debug == 1)
                                            {    
                                                echo "<br><br>Personal image 8-12";   
                                                echo "<br>HTTP SERVER: ".HTTP_SERVER;
                                                echo "<br>DIR_WS_HTTP FOLDER: ".DIR_WS_HTTP_FOLDER;
                                            } 
                                                $table3 .='<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                                        }	
                                        //$table3 .='</div>';
                                        $table3 .='</td></tr><tr><td height="20">';
                                        $table3 .='<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>';

                                        $table3 .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                        $table3 .='</td></tr></table>';
                                        $table3 .='</td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
                                    }
                                    else
                                    {

                                        $table3 .='<td valign="top">
                                            <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
                                                    &nbsp;
                                            </div>
                                            <div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:19px; text-align:center;>&nbsp;</div>
                                            <div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
                                        </td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
                                    }

				}

				$table3 .= '</tr></table>';
                                

                                $table4 = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
        			<tr>';
// SPACING DONE UNTIL HERE
				for($q=12;$q<16;$q++)
                                {
                                    if($person_info[$q]['pname'] !='')
                                    {
                                        $table4 .='<td valign="top">';

                                        //$table4 .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;height:80px;display: table-cell;vertical-align: middle;position:relative;"> ';
                                        $table4 .='<table  cellpadding="0" cellspacing="0"><tr><td width="80" height="80" style="line-height:0px;">';
                                        //if($alert_row['jobs'] == 1)
                                        if($person_info[$q]['type'] == 'Company')
                                        {
                                            $img_arr = explode(":HEIGHT:",$person_info[$q]['pimage']);
                                            $table4 .='<a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a>';
                                        }
                                        else
                                        {
                                            if($debug == 1)
                                            {    
                                                echo "<br><br>Personal image 12-16";   
                                                echo "<br>HTTP SERVER: ".HTTP_SERVER;
                                                echo "<br>DIR_WS_HTTP FOLDER: ".DIR_WS_HTTP_FOLDER;
                                            } 
                                            $table4 .='<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$person_info[$q]['purl'].'" target="_blank"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$person_info[$q]['pimage'].'" alt="" border="0" width="80" height="80" /></a>';
                                        }
                                        //$table4 .='</div>';
                                        $table4 .='</td></tr><tr><td height="20">';
                                        $table4 .='<div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center; background-color:#333333">'.$person_info[$q]['pname'].'</div>';

                                        $table4 .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>';
                                                $table4 .='</td></tr></table>';
                                        $table4 .='</td>';

                                        $table4 .='<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';

                                    }
                                    else
                                    {

                                        $table4 .='<td valign="top">
                                        <div class="img" style="font-size:0pt; line-height:0pt; text-align:left;width:80px;">
                                        &nbsp;
                                        </div>
                                        <div class="thumb-name" style="color:#ffffff; font-family:Arial; font-size:11px; line-height:17px; text-align:center;>&nbsp;</div>
                                        <div style="font-size:0pt; line-height:0pt; height:1px; ">&nbsp;</div>
                                        </td>
                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"></td>';
                                    }

				}

				$table4 .= '</tr></table>';
				

				if($totPerson<=8)
                                {

                                    $perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td valign="top" class="column">
                                            '.$table1.'
                                        </td>
                                        <td valign="top" class="column">
                                            '.$table2.'
                                        </td>
                                    </tr>

                                 </table>';

				}
                                elseif($totPerson>8)
                                {

                                    $perImgName = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td valign="top" class="column">
                                                '.$table1.'
                                            </td>
                                            <td valign="top" class="column">
                                                '.$table2.'
                                            </td>
                                        </tr>
                                        <tr>
                                           <td valign="top" class="column">
                                              '.$table3.'
                                           </td>
                                           <td valign="top" class="column">
                                              '.$table4.'
                                           </td>
                                        </tr>
                                     </table>';

				}

				

				$person_image_name = '<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                                        <tr>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                            <td>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333">
                                                    <tr>
                                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                        <div style="font-size:0pt; line-height:0pt; height:11px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="11" style="height:11px" alt="" /></div>
                                                        </td>
                                                        <td class="h1" style="color:#ffffff; font-family:Arial; font-size:20px; line-height:24px; text-align:left; font-weight:normal">Reach out and engage your clients and prospects now:</td>
                                                    </tr>
                                                </table>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#ffffff" class="w320">
                                                    <tr><td>'.$perImgName.'</td></tr>
                                                </table>
                                            </td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                        </tr>

                                    </table>

                                    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>';

				if($messageSrt!='')
                                {
                                    $message .= $person_image_name.'<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                                            <tr>
                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                                <td>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

                                            <tr>
                                                <td>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                        <tr>
                                                            <td>
                                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
                                                                    <tr>
                                                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                                            <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
                                                                        </td>
                                                                        <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Appointments and Promotions</td>
                                                                    </tr>
                                                                </table>
                                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                    '.$messageSrt.'
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                </tr>
                            </table>
                            <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
                            <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
                            $messageEmail .=  $person_image_name.'<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                                    <tr>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                            <tr>
                                                                <td>
                                                                    <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
                                                                        <tr>
                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                                                    <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
                                                                            </td>
                                                                            <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Appointments and Promotions</td>
                                                                        </tr>

                                                                    </table>
                                                                    <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                        '.$messageEmailStr.'
                                                                    </td>
                                                                </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                        <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                    </tr>
                                </table>
                                <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
                                <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';;

                            }
                            else
                            {
                                $message .= $person_image_name;
                                $messageEmail .= $person_image_name;
                            }

				
                            // far todo - add $company_id_with_trigger by first creating $personal_id_with_trigger and then adding here
                            // add new block for adding jobs and funding in email body
                            //if($triggers !='' && $personal_id_with_trigger !=''){
                            if($triggers !='' && $personal_id_with_trigger !='')
                            {
                                //for personal speaking 
                                $personal_id_with_trigger = trim($personal_id_with_trigger,",");
                                //$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_SPEAKING." ps, ".TABLE_PERSONAL_MASTER." pm where ps.personal_id=pm.personal_id and ps.event_date >'".$before_date."' and  ps.event_date <'".$future_date."' and ps.personal_id in (".$personal_id_with_trigger.") order by ps.add_date desc";	
                                $psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_SPEAKING." ps, ".TABLE_PERSONAL_MASTER." pm where ps.personal_id=pm.personal_id and ps.event_date >'".$speaker_before_date."' and  ps.event_date <'".$future_date."' and ps.personal_id in (".$personal_id_with_trigger.") order by ps.add_date desc";	

                                if($debug == 1)
                                    echo "<br>Personal engagement Q:".$psQuery;

                                $psResult = com_db_query($psQuery);	

                                if($psResult)
                                {
                                    $psNumRow = com_db_num_rows($psResult);	
                                    if($psNumRow>0)
                                    {
                                        $message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                                                <tr>
                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
                                                            <tr>
                                                                <td>
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                                        <tr>
                                                                            <td>
                                                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">
                                                                                        <tr>
                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                                                                <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
                                                                                            </td>
                                                                                            <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Speaking Engagements</td>
                                                                                        </tr>
                                                                                    </table>';
                                                                    $messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">
                                                                            <tr>
                                                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
                                                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                                                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                                                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                                                                                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                                                                                    <td>
                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">
                                                                                            <tr>
                                                                                                <td>
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

                                                                                                                    <tr>

                                                                                                                        <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>
                                                                                                                            <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>
                                                                                                                            </td>

                                                                                                                            <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Speaking Engagements</td>

                                                                                                                    </tr>

                                                                                                            </table>';

                                                                    $sp=1;

                                                                    while($psRow = com_db_fetch_array($psResult)){


                                                                                    $person_id = $psRow['personal_id'];

                                                                                    $pFirstName = com_db_output($psRow['first_name']);

                                                                                    $pLastName = com_db_output($psRow['last_name']);	

                                                                                    $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                                                                                    $pEmailAdd = com_db_output($psRow['email']);	

                                                                                    $event_date = $psRow['event_date'];

                                                                                    $edt = explode('-',$event_date);

                                                                                    if($psRow['role']=='Speaker' || $psRow['role']=='Panelist'){

                                                                                            $speakingRole = 'speak';

                                                                                    }else{

                                                                                            $speakingRole = $psRow['role'];

                                                                                    }

                                                                                    if($event_date=='0000-00-00'){

                                                                                            $speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']);

                                                                                    }elseif($event_date > date("Y-m-d")){

                                                                                            $speaking = ' scheduled to '.$speakingRole.' at '.com_db_output($psRow['event']).' on '.date("M j, Y",mktime(0,0,0,$edt[1],$edt[2],$edt[0]));

                                                                                    }else{

                                                                                            $speaking = ' scheduled to ' .$speakingRole.' at the '.com_db_output($psRow['event']);

                                                                                    }

                                                                                    $personal_image = $psRow['personal_image'];

                                                                                    if($personal_image !=''){

                                                                                      $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;

                                                                                    }else{

                                                                                      $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

                                                                                    }


                                                                                    $sf = "";
                                                                                    if($_GET['show_sf'] == 1) // Speaking Engagements Section
                                                                                    {    

                                                                                        $get_sf_details = "SELECT cm.company_name as sf_cname,mm.title as cf_title,pm.phone as phone FROM ".TABLE_PERSONAL_MASTER." as pm,"
                                                                                        .TABLE_COMPANY_MASTER." as cm,"
                                                                                        .TABLE_MOVEMENT_MASTER." as mm
                                                                                        where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id
                                                                                        and pm.personal_id = ".$person_id;

                                                                                        $sf_res = com_db_query($get_sf_details);
                                                                                        $sf_row = com_db_fetch_array($sf_res);
                                                                                        $sf_company_name = urlencode($sf_row['sf_cname']);
                                                                                        $sf_title = urlencode($sf_row['cf_title']);
                                                                                        $sf_phone = urlencode($sf_row['phone']);
                                                                                        echo "<br><br>Speaking engagement query: ".$get_sf_details;
                                                                                        echo "<br><br>sf_title: ".$sf_title;
                                                                                        echo "<br>pEmailAdd: ".$pEmailAdd;
                                                                                        //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                                                        $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".$sf_company_name."&title=".$sf_title."&email=".$pEmailAdd."&phone=".$sf_phone."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                                                                    }   



                                                                                    if($psRow['speaking_link'] !=''){

                                                                                        $message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                            <tr>

                                                                                                                <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

                                                                                                                <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                        '.$pFirstName.' '.$pLastName.' '.$speaking.'

                                                                                                                        <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                <tr>

                                                                                                                                        <td align="left">

                                                                                                                                                <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                        <tr>

                                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$psRow['speaking_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

                                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                '.$sf.'    
                                                                                                                                                        </tr>

                                                                                                                                                </table>

                                                                                                                                        </td>

                                                                                                                                </tr>

                                                                                                                        </table>

                                                                                                                </td>

                                                                                                                <td align="right" width="170" class="btn-container">

                                                                                                                        <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

                                                                                                                                <tr>

                                                                                                                                        <td>

                                                                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

                                                                                                                                                        <tr>

                                                                                                                                                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

                                                                                                                                                                </div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

                                                                                                                                                                </td>

                                                                                                                                                                <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=Congrats&amp;body=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

                                                                                                                                                        </tr>

                                                                                                                                                </table>

                                                                                                                                        </td>

                                                                                                                                </tr>

                                                                                                                        </table>

                                                                                                                </td>
                                                                                                            </tr>

                                                                                                            </table>

                                                                                                                                    </td>

                                                                                                                            </tr>

                                                                                                                    </table>';

                                                                                            //if($sp<=5){
                                        if($sp<=15){
                                        $messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                                                                <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                                                    '.$pFirstName.' '.$pLastName.' '.$speaking.'
                                                                    <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                        <tr>
                                                                            <td align="left">
                                                                                <table border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                                        <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                        <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                                        <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$psRow['speaking_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
                                                                                        <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                        '.$sf.'    
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>

                                                                <td align="right" width="170" class="btn-container">

                                                                        <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

                                                                                <tr>

                                                                                        <td>

                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

                                                                                                        <tr>

                                                                                                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

                                                                                                                </div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

                                                                                                                </td>

                                                                                                                <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=Congrats&amp;body=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

                                                                                                        </tr>

                                                                                                </table>

                                                                                        </td>

                                                                                </tr>

                                                                        </table>

                                                                </td>

                                                        </tr>

                                                                                        </table>

                                                                                </td>

                                                                        </tr>

                                                                </table>';

                                        }

                                                                                    }else{

                                                                                            $message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="20">

                                                                                                                            <tr>

                                                                                                                                    <td>

                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                    <tr>

                                                                                                                                                            <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

                                                                                                                                                            <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                                                                    '.$pFirstName.' '.$pLastName.' '.$speaking.'

                                                                                                                                                                    <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                            <tr>

                                                                                                                                                                                    <td align="left">

                                                                                                                                                                                            <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                                                    <tr>

                                                                                                                                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                                                            <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

                                                                                                                                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

                                                                                                                                                                                                    </tr>

                                                                                                                                                                                            </table>

                                                                                                                                                                                    </td>

                                                                                                                                                                            </tr>

                                                                                                                                                                    </table>

                                                                                                                                                            </td>

                                                                                                                                                            <td align="right" width="170" class="btn-container">

                                                                                                                                                                    <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

                                                                                                                                                                            <tr>

                                                                                                                                                                                    <td>

                                                                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

                                                                                                                                                                                                    <tr>

                                                                                                                                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

                                                                                                                                                                                                            </div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

                                                                                                                                                                                                            </td>

                                                                                                                                                                                                            <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

                                                                                                                                                                                                    </tr>

                                                                                                                                                                                            </table>

                                                                                                                                                                                    </td>

                                                                                                                                                                            </tr>

                                                                                                                                                                    </table>

                                                                                                                                                            </td>

                                                                                                                                                    </tr>

                                                                                                                                            </table>

                                                                                                                                    </td>

                                                                                                                            </tr>

                                                                                                                    </table>';

                                                                                            //if($sp<=5){
                                                                                            if($sp<=15){    

                                                                                            $messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="20">

                                                                                                                            <tr>

                                                                                                                                    <td>

                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                    <tr>

                                                                                                                                                            <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

                                                                                                                                                            <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                                                                    '.$pFirstName.' '.$pLastName.' '.$speaking.'

                                                                                                                                                                    <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                            <tr>

                                                                                                                                                                                    <td align="left">

                                                                                                                                                                                            <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                                                    <tr>

                                                                                                                                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                                                            <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                                                                            <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

                                                                                                                                                                                                            <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

                                                                                                                                                                                                    </tr>

                                                                                                                                                                                            </table>

                                                                                                                                                                                    </td>

                                                                                                                                                                            </tr>

                                                                                                                                                                    </table>

                                                                                                                                                            </td>

                                                                                                                                                            <td align="right" width="170" class="btn-container">

                                                                                                                                                                    <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

                                                                                                                                                                            <tr>

                                                                                                                                                                                    <td>

                                                                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

                                                                                                                                                                                                    <tr>

                                                                                                                                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

                                                                                                                                                                                                            </div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

                                                                                                                                                                                                            </td>

                                                                                                                                                                                                            <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$psRow['email'].'?subject=Congrats&amp;body=I noticed you are speaking at an industry event and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

                                                                                                                                                                                                    </tr>

                                                                                                                                                                                            </table>

                                                                                                                                                                                    </td>

                                                                                                                                                                            </tr>

                                                                                                                                                                    </table>

                                                                                                                                                            </td>

                                                                                                                                                    </tr>

                                                                                                                                            </table>

                                                                                                                                    </td>

                                                                                                                            </tr>

                                                                                                                    </table>';

                                                                                            }

                                                                                    }

                                                                            $sp++;

                                                                    }



                                                            $message .=' 	</td>

                                                                                                                                            </tr>

                                                                                                                                    </table>

                                                                                                                            </td>

                                                                                                                    </tr>

                                                                                                            </table>

                                                                                                    </td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                            </tr>

                                                                                    </table>

                                                                                    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                    <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';

                                                            $messageEmail .='</td>

                                                                                                                                            </tr>

                                                                                                                                    </table>

                                                                                                                            </td>

                                                                                                                    </tr>

                                                                                                            </table>

                                                                                                    </td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                            </tr>

                                                                                    </table>

                                                                                    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                    <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	

                                                            }

                                                     }

						

							//for personal Media Mentions

							$pmmQuery = "select pmm.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_MEDIA_MENTION." pmm, ".TABLE_PERSONAL_MASTER." pm where pmm.personal_id=pm.personal_id and pmm.pub_date>'".$before_date."' and  pmm.pub_date<'".$future_date."' and  pmm.personal_id in (".$personal_id_with_trigger.") order by pmm.add_date desc";	

							$pmmResult = com_db_query($pmmQuery);	

							if($pmmResult){

							$pmmNumRow = com_db_num_rows($pmmResult);	

							if($pmmNumRow>0){

								$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																			

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Media Mentions</td>

																					</tr>

																				</table>';

								$messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																			

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Media Mentions</td>

																					</tr>

																				</table>';												

																				

						  			$med=1;

									while($pmmRow = com_db_fetch_array($pmmResult)){

										$person_id = $pmmRow['personal_id'];

										$pFirstName = com_db_output($pmmRow['first_name']);

										$pLastName = com_db_output($pmmRow['last_name']);	

										
                                                                                $pEmailAdd = com_db_output($pmmRow['email']);	
                                                                                
                                                                                $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

										$pub_date = $pmmRow['pub_date'];

										$pdt = explode('-',$pub_date);

										if($pub_date=='0000-00-00'){

											$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']);

										}elseif($pub_date < date("Y-m-d")){

											$media_mention = ' was quoted by '.com_db_output($pmmRow['publication']).' on '.date("M j, Y",mktime(0,0,0,$pdt[1],$pdt[2],$pdt[0]));

										}else{

											$media_mention = ' is "' .com_db_output($pmmRow['quote']).'" by '.com_db_output($pmmRow['publication']);

										}

										$personal_image = $pmmRow['personal_image'];

										if($personal_image !=''){

										  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;

										}else{

										  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

										}
                                                                                
                                                                                
                                                                                if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                                                                {    
                                                                                    //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                                                    $get_sf_details = "SELECT cm.company_name as sf_cname,mm.title as cf_title,pm.phone as phone FROM ".TABLE_PERSONAL_MASTER." as pm,"
                                                                                    .TABLE_COMPANY_MASTER." as cm,"
                                                                                    .TABLE_MOVEMENT_MASTER." as mm
                                                                                    where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id
                                                                                    and pm.personal_id = ".$person_id;

                                                                                    $sf_res = com_db_query($get_sf_details);
                                                                                    $sf_row = com_db_fetch_array($sf_res);
                                                                                    $sf_company_name = urlencode($sf_row['sf_cname']);
                                                                                    
                                                                                    $sf_phone = urlencode($sf_row['phone']);
                                                                                    
                                                                                    $sf_title = urlencode($sf_row['cf_title']);
                                                                                    $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".$sf_company_name."&title=".$sf_title."&email=".$pEmailAdd."&phone=".$sf_phone."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                                                                } 
                                                                                
                                                                                
                                                                                
										if($pmmRow['media_link'] !=''){

											$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    					 <table width="100%" border="0" cellspacing="0" cellpadding="20">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0">

																		<tr>

																			<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																			<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																				'.$pFirstName.' '.$pLastName.' '.$media_mention.'

																				<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																				<table width="100%" border="0" cellspacing="0" cellpadding="0">

																					<tr>

																						<td align="left">

																							<table border="0" cellspacing="0" cellpadding="0">

																								<tr>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																									<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pmmRow['media_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																			<td align="right" width="170" class="btn-container">

																				<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																					<tr>

																						<td>

																							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																								<tr>

																									<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																									</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																									</td>

																									<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=Congrats&amp;body=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>';

											if($med <= 5){

											$messageEmail .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    					 <table width="100%" border="0" cellspacing="0" cellpadding="20">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0">

																		<tr>

																			<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																			<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																				'.$pFirstName.' '.$pLastName.' '.$media_mention.'

																				<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																				<table width="100%" border="0" cellspacing="0" cellpadding="0">

																					<tr>

																						<td align="left">

																							<table border="0" cellspacing="0" cellpadding="0">

																								<tr>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																									<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pmmRow['media_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                                                                                                                        '.$sf.'    
																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																			<td align="right" width="170" class="btn-container">

																				<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																					<tr>

																						<td>

																							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																								<tr>

																									<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																									</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																									</td>

																									<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>';	

											}

										}else{

											$message .=	'<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    					 <table width="100%" border="0" cellspacing="0" cellpadding="20">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0">

																		<tr>

																			<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																			<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																				'.$pFirstName.' '.$pLastName.' '.$media_mention.'

																				<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																				<table width="100%" border="0" cellspacing="0" cellpadding="0">

																					<tr>

																						<td align="left">

																							<table border="0" cellspacing="0" cellpadding="0">

																								<tr>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																									<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																			<td align="right" width="170" class="btn-container">

																				<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																					<tr>

																						<td>

																							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																								<tr>

																									<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																									</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																									</td>

																									<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>';

											if($med <= 5){

											$messageEmail .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    					 <table width="100%" border="0" cellspacing="0" cellpadding="20">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0">

																		<tr>

																			<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																			<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																				'.$pFirstName.' '.$pLastName.' '.$media_mention.'

																				<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																				<table width="100%" border="0" cellspacing="0" cellpadding="0">

																					<tr>

																						<td align="left">

																							<table border="0" cellspacing="0" cellpadding="0">

																								<tr>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																									<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																									<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																									<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>
                                                                                                                                                                                                        
																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																			<td align="right" width="170" class="btn-container">

																				<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																					<tr>

																						<td>

																							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																								<tr>

																									<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																									</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																									</td>

																									<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pmmRow['email'].'?subject=I noticed you were recently quoted in media and decided to reach out." target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																								</tr>

																							</table>

																						</td>

																					</tr>

																				</table>

																			</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>';	

											}			

										}

									

									$med++;

									}

								$message .=' 								</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>

													</td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

												</tr>

											</table>

											<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

											

											<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	

								$messageEmail .=' 								</td>

																		</tr>

																	</table>

																</td>

															</tr>

														</table>

													</td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

												</tr>

											</table>

											<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

											

											<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';			

								}

						 	}

							//for personal Industry Awards

							$paQuery = "select pa.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_AWARDS." pa, ".TABLE_PERSONAL_MASTER." pm where pa.personal_id=pm.personal_id and pa.awards_date>'".$before_date."' and pa.awards_date<'".$future_date."' and  pa.personal_id in (".$personal_id_with_trigger.") order by pa.add_date desc";	
                                                        if($debug == 1)
                                                            echo "<br><br>Awards Q: ".$paQuery;
							$paResult = com_db_query($paQuery);	

							if($paResult){

							$paNumRow = com_db_num_rows($paResult);	

							if($paNumRow>0){

								$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

											<tr>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td>

													<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																	<tr>

																		<td>

																			

																			<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																				<tr>

																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																					<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																					</td>

																					<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Industry Awards</td>

																				</tr>

																			</table>';

						  		$messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

											<tr>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td>

													<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																	<tr>

																		<td>

																			

																			<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																				<tr>

																					<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																					<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																					</td>

																					<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Industry Awards</td>

																				</tr>

																			</table>';

								$ind=1;

								while($paRow = com_db_fetch_array($paResult)){

                                                                    $person_id = $paRow['personal_id'];

                                                                    $pFirstName = com_db_output($paRow['first_name']);

                                                                    $pLastName = com_db_output($paRow['last_name']);	

                                                                    $personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

                                                                    $awards_date = $paRow['awards_date'];
                                                                    
                                                                    $pEmailAdd = $paRow['email'];

                                                                    $adt = explode('-',$awards_date);

                                                                    $personal_image = $paRow['personal_image'];

                                                                    if($personal_image !=''){

                                                                      $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;

                                                                    }else{

                                                                      $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

                                                                    }

                                                                    $awards = ' received a "'.com_db_output($paRow['awards_title']).'" award from '.com_db_output($paRow['awards_given_by']);



                                                                                
                                                                    $sf = "";
                                                                    if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                                                    {    

                                                                        $get_sf_details = "SELECT cm.company_name as sf_cname,mm.title as cf_title,pm.phone as phone FROM ".TABLE_PERSONAL_MASTER." as pm,"
                                                                        .TABLE_COMPANY_MASTER." as cm,"
                                                                        .TABLE_MOVEMENT_MASTER." as mm
                                                                        where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id
                                                                        and pm.personal_id = ".$person_id;

                                                                        $sf_res = com_db_query($get_sf_details);
                                                                        $sf_row = com_db_fetch_array($sf_res);
                                                                        $sf_company_name = urlencode($sf_row['sf_cname']);
                                                                        
                                                                        $sf_phone = urlencode($sf_row['phone']);
                                                                        
                                                                        $sf_title = urlencode($sf_row['cf_title']);
                                                                        echo "<br><br>Speaking engagement query: ".$get_sf_details;
                                                                        echo "<br><br>sf_title: ".$sf_title;
                                                                        echo "<br>pEmailAdd: ".$pEmailAdd;
                                                                        //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                                        $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".$sf_company_name."&title=".$sf_title."&email=".$pEmailAdd."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                                                    }
                                                                                
                                                                                
                                                                                
                                                                                
                                                                                
                                                                                

										if($paRow['awards_link'] !=''){

											$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="20">

                                                                                                <tr>

                                                                                                        <td>

                                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                        <tr>

                                                                                                                                <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

                                                                                                                                <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                                        '.$pFirstName.' '.$pLastName.' '.$awards.'

                                                                                                                                        <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                <tr>

                                                                                                                                                        <td align="left">

                                                                                                                                                                <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                        <tr>

                                                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                                <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$paRow['awards_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

                                                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                        </tr>

                                                                                                                                                                </table>

                                                                                                                                                        </td>

                                                                                                                                                </tr>

                                                                                                                                        </table>

                                                                                                                                </td>

                                                                                                                                <td align="right" width="170" class="btn-container">

                                                                                                                            <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

                                                                                                                                <tr>

                                                                                                                                    <td>

                                                                                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

                                                                                                                                            <tr>

                                                                                                                                                <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

                                                                                                                                                </div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

                                                                                                                                                </td>

                                                                                                                                                <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

                                                                                                                                            </tr>

                                                                                                                                    </table>

                                                                                                                                </td>

                                                                                                                            </tr>

                                                                                                                        </table>

                                                                                                                    </td>

                                                                                                                </tr>

                                                                                                            </table>

                                                                                                        </td>

                                                                                            </tr>

                                                                                        </table>';

											//if($ind<=5){
                                                                                        if($ind<=15){    

											$messageEmail .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$awards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$paRow['awards_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                                                                                                                '.$sf.'    
																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

											}

										}else{

											$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$awards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

											//if($ind<=5){
                                                                                        if($ind<=15){

											$messageEmail .= '<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$awards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

					

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$paRow['email'].'?subject=Congrats&amp;body=Congrats on your recent award" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

											}

										}

										

									$ind++;	

									}

									

								$message .=' </td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>

												</td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

											</tr>

											</table>

											<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

											

											<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	

								$messageEmail .=' </td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>

												</td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

											</tr>

											</table>

											<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

											

											<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';			

								}

						 	}

							//for personal publication

							$ppQuery = "select pp.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_PUBLICATION." pp, ".TABLE_PERSONAL_MASTER." pm where pp.personal_id=pm.personal_id and pp.publication_date>'".$before_date."' and  pp.publication_date <'".$future_date."' and pp.personal_id in (".$personal_id_with_trigger.") order by pp.add_date desc";	

							$ppResult = com_db_query($ppQuery);	

							if($ppResult){

							$ppNumRow = com_db_num_rows($ppResult);	

							if($ppNumRow>0){

								$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																				

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Publications</td>

																					</tr>

																				</table>';

						  

						  		$messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																				

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

											

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Publications</td>

																					</tr>

																				</table>';

								$pub=1;												

								while($ppRow = com_db_fetch_array($ppResult)){

									$person_id = $ppRow['personal_id'];

									$pFirstName = com_db_output($ppRow['first_name']);

									$pLastName = com_db_output($ppRow['last_name']);
                                                                        
                                                                        $pEmailAdd = com_db_output($ppRow['email']);

									$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

									

									$publication = ' wrote "'.com_db_output($ppRow['title']).'"';

									$personal_image = $ppRow['personal_image'];

									if($personal_image !=''){

									  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;

									}else{

									  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

									}
                                                                        
                                                                        $sf = "";
                                                                        if($_GET['show_sf'] == 1) // Speaking Engagements Sectopm
                                                                        {    

                                                                            $get_sf_details = "SELECT cm.company_name as sf_cname,mm.title as cf_title,pm.phone as phone FROM ".TABLE_PERSONAL_MASTER." as pm,"
                                                                            .TABLE_COMPANY_MASTER." as cm,"
                                                                            .TABLE_MOVEMENT_MASTER." as mm
                                                                            where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id
                                                                            and pm.personal_id = ".$person_id;

                                                                            $sf_res = com_db_query($get_sf_details);
                                                                            $sf_row = com_db_fetch_array($sf_res);
                                                                            $sf_company_name = urlencode($sf_row['sf_cname']);
                                                                            
                                                                            $sf_phone = urlencode($sf_row['phone']);
                                                                            
                                                                            $sf_title = urlencode($sf_row['cf_title']);
                                                                            echo "<br><br>Speaking engagement query: ".$get_sf_details;
                                                                            echo "<br><br>sf_title: ".$sf_title;
                                                                            echo "<br>pEmailAdd: ".$pEmailAdd;
                                                                            //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                                            $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".$sf_company_name."&title=".$sf_title."&email=".$pEmailAdd."&phone=".$sf_phone."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                                                        }
                                                                        
                                                                        

									if($ppRow['link'] !=''){

										$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

													<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holderimg-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$publication.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$ppRow['link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                                                                                                                '.$sf.'                
																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

										//if($pub<=5){
                                                                                if($pub<=15){    

										$messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

													<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$publication.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$ppRow['link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                                                                                                                '.$sf.'    

                                                                                                                                                                                        </tr>
                                                                                                                                                                                        
																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=Congrats&amp;body=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';	

										}

									}else{

										$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

													 <table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$publication.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

										//if($pub<=5){
                                                                                if($pub<=15){    

										$messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

													 <table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$publication.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$ppRow['email'].'?subject=Congrats&amp;body=I saw you recent publication and decided to reach out" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';	

										}

									}

								$pub++;	

								}

							$message .=' 	</td>

																</tr>

															</table>

														</td>

													</tr>

												</table>

											</td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

										</tr>

									</table>

									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

									

									<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>

									';

							$messageEmail .=' 							</td>

																</tr>

															</table>

														</td>

													</tr>

												</table>

											</td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

											<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

										</tr>

									</table>

									<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

									

									<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>

									';				

							}

						 }

							//for personal Board Appointments

							$pbQuery = "select pb.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_PERSONAL_BOARD." pb, ".TABLE_PERSONAL_MASTER." pm where pb.personal_id=pm.personal_id  and pb.board_date>'".$before_date."' and pb.board_date<'".$future_date."' and pb.personal_id in (".$personal_id_with_trigger.") order by pb.add_date desc";	

							$pbResult = com_db_query($pbQuery);	

							if($pbResult){

							$pbNumRow = com_db_num_rows($pbResult);	

							if($pbNumRow>0){

								$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Board Appointments</td>

																					</tr>

																				</table>';

						 		$messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

												<tr>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

													<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

													<td>

														<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

															<tr>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																		<tr>

																			<td>

																				<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																					<tr>

																						<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																						<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																						</td>

																						<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Board Appointments</td>

																					</tr>

																				</table>';

								$app=1;																				

								while($pbRow = com_db_fetch_array($pbResult)){

									$person_id = $pbRow['personal_id'];

									$pFirstName = com_db_output($pbRow['first_name']);

									$pLastName = com_db_output($pbRow['last_name']);	
                                                                        
                                                                        $pEmailAdd = com_db_output($pbRow['email']);	

									$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;

									

									$boards = ' was appointed as a member of "'.com_db_output($pbRow['board_info']).'"';

									$personal_image = $pbRow['personal_image'];

									if($personal_image !=''){

									  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;

									}else{

									  $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

									}
                                                                        
                                                                        
                                                                        $sf = "";
                                                                        if($_GET['show_sf'] == 1) // Speaking Engagements Section
                                                                        {    

                                                                            $get_sf_details = "SELECT cm.company_name as sf_cname,mm.title as cf_title,pm.phone as phone FROM ".TABLE_PERSONAL_MASTER." as pm,"
                                                                            .TABLE_COMPANY_MASTER." as cm,"
                                                                            .TABLE_MOVEMENT_MASTER." as mm
                                                                            where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id
                                                                            and pm.personal_id = ".$person_id;

                                                                            $sf_res = com_db_query($get_sf_details);
                                                                            $sf_row = com_db_fetch_array($sf_res);
                                                                            $sf_company_name = urlencode($sf_row['sf_cname']);
                                                                            
                                                                            $sf_phone = urlencode($sf_row['phone']);
                                                                            
                                                                            $sf_title = urlencode($sf_row['cf_title']);
                                                                            echo "<br><br>Speaking engagement query: ".$get_sf_details;
                                                                            echo "<br><br>sf_title: ".$sf_title;
                                                                            echo "<br>pEmailAdd: ".$pEmailAdd;
                                                                            //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
                                                                            $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($pFirstName)."&lname=".urlencode($pLastName)."&company_name=".$sf_company_name."&title=".$sf_title."&email=".$pEmailAdd."&phone=".$sf_phone."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
                                                                        } 
                                                                        
                                                                        

									if($pbRow['board_link'] !=''){

										$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    				<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$boards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pbRow['board_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats&amp;body=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

										//if($app<=5){
                                                                                if($app<=15){    

										$messageEmail .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    				<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$boards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$pbRow['board_link'].'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                                                                                                                                                '.$sf.'            
																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats&amp;body=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

										}

									}else{

										$message .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    				<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$boards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';

										//if($app<=5){
                                                                                if($app<=15){    

										$messageEmail .='<div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                    				<table width="100%" border="0" cellspacing="0" cellpadding="20">

														<tr>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="0">

																	<tr>

																		<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>

																		<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

																			'.$pFirstName.' '.$pLastName.' '.$boards.'

																			<div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>

				

																			<table width="100%" border="0" cellspacing="0" cellpadding="0">

																				<tr>

																					<td align="left">

																						<table border="0" cellspacing="0" cellpadding="0">

																							<tr>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

																								<td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

																								<td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"></td>

																								<td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																		<td align="right" width="170" class="btn-container">

																			<table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">

																				<tr>

																					<td>

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div>

																								</div><div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>

																								</td>

																								<td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$pbRow['email'].'?subject=Congrats&amp;body=Congrats on your recent Board appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>

																							</tr>

																						</table>

																					</td>

																				</tr>

																			</table>

																		</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>';	

										}

									}

								$app++;	

								}

							$message .=' 								</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>

												</td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

											</tr>

										</table>

										<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

										

										<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	

							$messageEmail .=' 								</td>

																	</tr>

																</table>

															</td>

														</tr>

													</table>

												</td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

												<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

											</tr>

										</table>

										<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

										

										<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';				

							}

						 }	
						 
						 
						 // FAR for jobs and fundings
						 
						 
						 
							
							
							
							
							
						 
						 
						 

					}



					if($debug == 1)
					{
						echo "<pre>header_funding_company_id_arr at end :";	print_r($header_funding_company_id_arr);	echo "</pre>";
						 
						echo "<pre>header_company_id_arr at end :";	print_r($header_company_id_arr);	echo "</pre>";
					}	
							if(sizeof($header_company_id_arr) > 0)
							{
                                                            $header_company_ids = implode($header_company_id_arr,",");
                                                            //$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_COMPANY_JOB_INFO." cj, ".TABLE_COMPANY_MASTER." cm where cj.company_id=cj.company_id and cj.add_date >'".$before_date."' and  ps.event_date <'".$future_date."' and cj.company_id in (".$jobsStr.") order by cj.add_date desc";	
                                                            //$joQuery = "select cj.job_id,cm.company_name,company_logo,cj.job_title,cj.source,cm.company_id from ".TABLE_COMPANY_JOB_INFO." cj, ".TABLE_COMPANY_MASTER." cm where cj.company_id=cm.company_id and cm.company_id in (".$header_company_ids.") order by cj.add_date desc";	
                                                            $joQuery = "select cj.job_id,cm.company_name,company_logo,cj.job_title,cj.source,cm.company_id from ".TABLE_COMPANY_JOB_INFO." cj, ".TABLE_COMPANY_MASTER." cm where cj.company_id=cm.company_id and cm.company_id in (".$header_company_ids.") order by cm.company_id desc";	
                                                            if($debug == 1)
                                                                echo "<br>joQuery: ".$joQuery;
                                                            $jResult = com_db_query($joQuery);	

                                                            if($jResult){

                                                                $jNumRow = com_db_num_rows($jResult);	

                                                                if($jNumRow>0){

                                                                            $message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

                                                                                                            <tr>

                                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                                    <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                                    <td>

                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

                                                                                                                                    <tr>

                                                                                                                                            <td>



                                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

                                                                                                                                                            <tr>

                                                                                                                                                                    <td>



                                                                                                                                                                            <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>



                                                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

                                                                                                                                                                                    <tr>

                                                                                                                                                                                            <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

                                                                                                                                                                                                    <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

                                                                                                                                                                                            </td>

                                                                                                                                                                                            <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Speaking Engagements</td>

                                                                                                                                                                                    </tr>

                                                                                                                                                                            </table>';

                                                                            $messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

                                                                                                                    <tr>

                                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                                            <td>

                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

                                                                                                                                            <tr>

                                                                                                                                                    <td>



                                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

                                                                                                                                                                    <tr>

                                                                                                                                                                            <td>



                                                                                                                                                                                    <div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>



                                                                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

                                                                                                                                                                                            <tr>

                                                                                                                                                                                                    <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

                                                                                                                                                                                                            <div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

                                                                                                                                                                                                    </td>

                                                                                                                                                                                                    <td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Jobs</td>

                                                                                                                                                                                            </tr>

                                                                                                                                                                                    </table>';

                                                                            $sp=1;

                                                                            while($jRow = com_db_fetch_array($jResult))
                                                                            {
                                                                                $company_id = $jRow['company_id'];
                                                                                $company_name = com_db_output($jRow['company_name']);
                                                                                $job_title = com_db_output($jRow['job_title']);	
                                                                                $job_source = com_db_output($jRow['source']);	
                                                                                $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($jRow['company_name'])).'_Company_'.$company_id;			
                                                                                $personalURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($jRow['company_name'])).'_Company_'.$company_id;			
                                                                                //$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
                                                                                //$event_date = $jRow['event_date'];
                                                                                //$edt = explode('-',$event_date);

                                                                                $personal_image = $jRow['company_logo'];
                                                                                if($personal_image !=''){
                                                                                    $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;
                                                                                    $company_logo_resized = getImageXY($org_personal_image_path,80);
                                                                                    //$personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'company_logo/small/'.$personal_image;
                                                                                    $personal_image_path = $company_logo_resized;

                                                                                }else{

                                                                                    $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

                                                                                }
                                                                                $message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="20">
                                                                                        <tr>
                                                                                            <td>
                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                    <tr>';

                                                                                                        //$message .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>';
                                                                                                        //$message .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank">"'.$personal_image_path.'"</a></td>';
                                                                                                        $img_arr = explode(":HEIGHT:",$personal_image_path);
                                                                                                        $message .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;vertical-align:middle;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto;top:0px;right:0px;bottom:0px;left:0px;"  /></a></td>';

                                                                                                        $message .=' <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                '.$company_name.' is looking to hire '.$job_title.'

                                                                                                                <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                        <tr>

                                                                                                                                <td align="left">

                                                                                                                                        <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                            <tr>

                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$job_source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

                                                                                                                                                <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                            </tr>

                                                                                                                                        </table>

                                                                                                                                </td>

                                                                                                                        </tr>

                                                                                                                </table>

                                                                                                        </td>

                                                                                                        <td align="right" width="170" class="btn-container">

                                                                                                        </td>

                                                                                                    </tr>
                                                                                                </table>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </table>';

                                                                                    //if($sp<=5){
                                                                                    if($sp<=10){

                                                                                    $messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="20">

                                                                                                                    <tr>

                                                                                                                            <td>

                                                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                            <tr>';
                                                                                                                                                    $img_arr = explode(":HEIGHT:",$personal_image_path);
                                                                                                                                                    //$messageEmail .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$personal_image_path.'" alt="" border="0" width="81" height="81" /></a></td>';
                                                                                                                                                    $messageEmail .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;display: table-cell;vertical-align: middle;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a></td>';

                                                                                                                                                    $messageEmail .=' <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">

                                                                                                                                                            '.$company_name.' is looking to hire '.$job_title.'

                                                                                                                                                            <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>



                                                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                    <tr>

                                                                                                                                                                            <td align="left">

                                                                                                                                                                                    <table border="0" cellspacing="0" cellpadding="0">

                                                                                                                                                                                            <tr>

                                                                                                                                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>

                                                                                                                                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                                                    <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>

                                                                                                                                                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$job_source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>

                                                                                                                                                                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>

                                                                                                                                                                                            </tr>

                                                                                                                                                                                    </table>

                                                                                                                                                                            </td>

                                                                                                                                                                    </tr>

                                                                                                                                                            </table>

                                                                                                                                                    </td>

                                                                                                                                                    <td align="right" width="170" class="btn-container">



                                                                                                                                                    </td>

                                                                                                                                            </tr>

                                                                                                                                    </table>

                                                                                                                            </td>

                                                                                                                    </tr>

                                                                                                            </table>';

                                                                                    }
                                                                                    $sp++;
                                                                            }



                                                                    $message .=' 	</td>

                                                                                                                                                    </tr>

                                                                                                                                            </table>

                                                                                                                                    </td>

                                                                                                                            </tr>

                                                                                                                    </table>

                                                                                                            </td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                                    </tr>

                                                                                            </table>

                                                                                            <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                            <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';

                                                                    $messageEmail .='</td>

                                                                                                                                                    </tr>

                                                                                                                                            </table>

                                                                                                                                    </td>

                                                                                                                            </tr>

                                                                                                                    </table>

                                                                                                            </td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

                                                                                                            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

                                                                                                    </tr>

                                                                                            </table>

                                                                                            <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>

                                                                                            <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	

                                                                    }

                                                             }

                                                    }
						 
							
							
							if(sizeof($header_funding_company_id_arr) > 0)
							{
								$header_funding_company_ids = implode($header_funding_company_id_arr,",");
								//$psQuery = "select ps.*,pm.first_name,pm.last_name,pm.email,pm.personal_image from ".TABLE_COMPANY_JOB_INFO." cj, ".TABLE_COMPANY_MASTER." cm where cj.company_id=cj.company_id and cj.add_date >'".$before_date."' and  ps.event_date <'".$future_date."' and cj.company_id in (".$jobsStr.") order by cj.add_date desc";	
								//$fQuery = "select cf.funding_id,cm.company_name,company_logo,cf.funding_date,cf.funding_amount,funding_source,cm.company_id from ".TABLE_COMPANY_FUNDING." cf, ".TABLE_COMPANY_MASTER." cm where cf.company_id=cm.company_id and cm.company_id in (".$header_funding_company_ids.") order by cf.funding_date desc";	
								$fQuery = "select cf.funding_id,cm.company_name,company_logo,cf.funding_date,cf.funding_amount,funding_source,cm.company_id from ".TABLE_COMPANY_FUNDING." cf, ".TABLE_COMPANY_MASTER." cm where cf.company_id=cm.company_id and cm.company_id in (".$header_funding_company_ids.") order by cm.company_id desc";	
								if($debug == 1)
									echo "<br>Funding fQuery: ".$fQuery;
								$fResult = com_db_query($fQuery);	

								if($fResult){

									$fNumRow = com_db_num_rows($fResult);	

									if($fNumRow>0){

										$message .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

													<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

														<tr>

															<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

															<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

															<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

															<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

															<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

															<td>

																<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

																	<tr>

																		<td>

																		

																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																				<tr>

																					<td>

																						

																						<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

													

																						<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																							<tr>

																								<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																									<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																								</td>

																								<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Recent Funding</td>

																							</tr>

																						</table>';

										$messageEmail .='<div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_top.jpg" alt="" border="0" width="660" height="5" /></div></div>

														<table width="100%" border="0" cellspacing="0" cellpadding="0" class="w320">

															<tr>

																<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>

																<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>

																<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>

																<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>

																<td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>

																<td>

																	<table width="100%" border="0" cellspacing="0" cellpadding="1" bgcolor="#c7c7c7">

																		<tr>

																			<td>

																			

																				<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">

																					<tr>

																						<td>

																							

																							<div style="font-size:0pt; line-height:0pt; height:1px; background:#4785ca; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>

														

																							<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#5f9bde">

																								<tr>

																									<td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="20"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div>

																										<div style="font-size:0pt; line-height:0pt; height:4px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="4" style="height:4px" alt="" /></div>

																									</td>

																									<td class="h2" style="color:#ffffff; font-family:Arial; font-size:18px; line-height:22px; text-align:left; font-weight:bold">Recent Funding</td>

																								</tr>

																							</table>';

$sp=1;

while($fRow = com_db_fetch_array($fResult))
{

    

    $company_id = $fRow['company_id'];
    $company_name = com_db_output($fRow['company_name']);
    $fdt = explode('-',com_db_output($fRow['funding_date']));
    $funding_date = 	$fdt[1].'/'.$fdt[2].'/'.$fdt[0];
    //$funding_date = com_db_output($fRow['funding_date']);	
    $funding_amount = com_db_output($fRow['funding_amount']);	
    $funding_source = com_db_output($fRow['funding_source']);	
    $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($fRow['company_name'])).'_Company_'.$company_id;			
    $personalURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), com_db_output($fRow['company_name'])).'_Company_'.$company_id;			

    //$personalURL = trim($pFirstName).'_'.trim($pLastName).'_Exec_'.$person_id;
    //$event_date = $jRow['event_date'];
    //$edt = explode('-',$event_date);

    // Getting decision maker
    $fundingPersonQuery = "SELECT pm.personal_id,pm.first_name,pm.last_name,pm.email,pm.personal_image,mm.title,cm.company_name,pm.phone as phone from
    ".TABLE_COMPANY_MASTER." as cm,
    ".TABLE_MOVEMENT_MASTER." as mm,
    ".TABLE_PERSONAL_MASTER." as pm
    where (cm.company_id = mm.company_id and mm.personal_id = pm.personal_id) and pm.add_to_funding = 1 and cm.company_id = $company_id";

    echo "<br>fundingPersonQuery: ".$fundingPersonQuery;

    $fundingPersonResult = com_db_query($fundingPersonQuery);	
    
    $person_first_name = '';
    $fundingPersonNumRow = 0;
    if($fundingPersonResult)
    {
        $fundingPersonNumRow = com_db_num_rows($fundingPersonResult);	
        echo "<br>fundingPersonNumRow: ".$fundingPersonNumRow;
        if($fundingPersonNumRow > 0)
        {
            $fundingPersonRow = com_db_fetch_array($fundingPersonResult);
            $person_first_name = $fundingPersonRow['first_name'];
            $person_last_name = $fundingPersonRow['last_name'];
            $person_email = $fundingPersonRow['email'];
            
            $person_phone = $fundingPersonRow['phone'];
            
            $personal_id = $fundingPersonRow['personal_id'];
            $person_funding_title = $fundingPersonRow['title'];
            $company_name_funding = $fundingPersonRow['company_name'];

            $personalFundingURL = trim($person_first_name).'_'.trim($person_last_name).'_Exec_'.$personal_id;
            $personal_image = $fundingPersonRow['personal_image'];
            if($personal_image !='')
            {
                $personal_funding_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/'.$personal_image;
            }
            else
            {
                $personal_funding_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';
            }
        }
    }

    $personal_image = $fRow['company_logo'];
    if($personal_image !='')
    {
        $org_personal_image_path = HTTP_CTO_URL.'company_logo/org/'.$personal_image;
        $company_logo_resized = getImageXY($org_personal_image_path,80);	
        //$personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'company_logo/small/'.$personal_image;
        $personal_image_path = $company_logo_resized;
    }
    else
    {

      $personal_image_path = HTTP_SERVER.DIR_WS_HTTP_FOLDER.'personal_photo/small/no_image_information.png';

    }

    
    $sf = "";
    if($_GET['show_sf'] == 1)
    {
        if($person_first_name != '')
        {    
            //echo "<pre>psRow:";   print_r($psRow);   echo "</pre>"; die();
            // FA todo sf     add company name
            $sf = "<td width=70></td><td class=links><a href=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."salesforce/oauth.php?fname=".urlencode($person_first_name)."&lname=".urlencode($person_last_name)."&company_name=".urlencode($company_name_funding)."&title=".urlencode($person_funding_title)."&email=".$person_email."&phone=".$person_phone."><img width=18px height=18px title=".$addLeadText." src=".HTTP_SERVER.DIR_WS_HTTP_FOLDER."images/salesforce.png></a></td>";
        }    
    }
    
    
												

$message .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>';
                    $img_arr = explode(":HEIGHT:",$personal_image_path);
                    //$message .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank">"'.$personal_image_path.'"</a></td>';
                    $message .='<td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;vertical-align:middle;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="" border="0" width="80" style="margin:auto;top:0px;right:0px;bottom:0px;left:0px;"  /></a></td>';
                    $message .='<td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                '.$company_name.' raised '.$funding_amount.' on '.$funding_date.'
                                <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="left">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                    <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$funding_source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
                                                    <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div>'.$sf.'</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right" width="170" class="btn-container"></td>
                        </tr>
                </table>
            </td>
        </tr>
    </table>';
    if($sp<=10)
    {
           
        $messageEmail .=' <div style="font-size:0pt; line-height:0pt; height:1px; background:#d8d8d8; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
            <table width="100%" border="0" cellspacing="0" cellpadding="20">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>';
                                $img_arr = explode(":HEIGHT:",$personal_image_path);
                                $messageEmail .=' <td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;height:80px;position:relative;display: table-cell;vertical-align: middle;" valign="top" width="105"><a id="header_logos" href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalURL.'" target="_blank"><img src="'.$img_arr[0].'" height="'.$img_arr[1].'" alt="Logo" border="0" width="80" style="position:absolute; margin:auto; top:0px; right:0px; bottom:0px; left:0px;"  /></a></td>
                                    <td class="text" style="color:#000000; font-family:Arial; font-size:15px; line-height:20px; text-align:left">
                                        '.$company_name.' raised '.$funding_amount.' on '.$funding_date.'
                                            <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left">
                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                <tr>
                                                                    <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$dim_url.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Details</span></a></td>
                                                                        <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                        <td class="spacing" style="font-size:0pt; line-height:0pt; text-align:left" width="89"></td>
                                                                        <td class="links" style="color:#ffffff; font-family:Arial; font-size:14px; line-height:18px; text-align:left"><a href="'.$funding_source.'" target="_blank" class="link-u" style="color:#4f81bd; text-decoration:underline"><span class="link-u" style="color:#4f81bd; text-decoration:underline">Source</span></a></td>
                                                                        <td class="img-right" style="font-size:0pt; line-height:0pt; text-align:right" width="15"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/bullet2.jpg" alt="" border="0" width="10" height="7" /></div></td>
                                                                        '.$sf.'
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="right" width="170" class="btn-container">
                                            </td>
                                        </tr>
                                    </table>
                            </td>
                    </tr>';


                    if($fundingPersonNumRow > 0)
                    {
                        echo "<br>Adding decision maker to funding";
                        $messageEmail .='<tr><td><table><tr><td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;padding-top:14px;" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalFundingURL.'" target="_blank"><img src="'.$personal_funding_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                            <td style="font-family:Arial; font-size:15px;">'.$person_first_name.' '.$person_last_name.', '.$person_funding_title.' at '.$company_name_funding.', is the decision maker</td>
                            <td width="175" align="right">
                                <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                <tr>
                                                    <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                        <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTPS_SITE_URL.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                    </td>
                                                    <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$person_email.'?subject=Congrats&amp;body=Congrats on your recent funding" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td></tr></table></td></tr>';
                        
                        
                        $message .='<table><tr><td class="img-holder" style="font-size:0pt; line-height:0pt; text-align:left;padding-top:14px;" valign="top" width="105"><a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.$personalFundingURL.'" target="_blank"><img src="'.$personal_funding_image_path.'" alt="" border="0" width="81" height="81" /></a></td>
                            <td style="font-family:Arial; font-size:15px;">'.$person_first_name.' '.$person_last_name.', '.$person_funding_title.' at '.$company_name_funding.', is the decision maker</td>
                            <td width="175" align="right">
                                <table border="0" cellspacing="0" cellpadding="1" bgcolor="#dd9c0d">
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#fcb20e">
                                                <tr>
                                                    <td class="img" style="font-size:0pt; line-height:0pt; text-align:left" width="1"><div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:47px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="47" style="height:47px" alt="" /></div></div>
                                                        <div style="font-size:0pt; line-height:0pt;" class="mobile-br-30"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                                                    </td>
                                                    <td class="btn" style="color:#ffffff; font-family:Arial; font-size:16px; line-height:20px; text-align:center" width="125"><a href="mailto:'.$person_email.'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="link2" style="color:#ffffff; text-decoration:none"><span class="link2" style="color:#ffffff; text-decoration:none">Email Now &rsaquo;</span></a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td></tr></table>';
                        
                        
                        
                    }
                    $messageEmail .=' </table>';
                }
                $sp++;
            }
            $message .='</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</td>
            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
            <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
        </tr>
    </table>
    <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
            <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';
            $messageEmail .='</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#dbdbdb"></td>
                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e0e0e0"></td>
                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e4e4e4"></td>
                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e7e7e7"></td>
                <td class="shadow" style="font-size:0pt; line-height:0pt; text-align:left" width="1" bgcolor="#e9e9e9"></td>
            </tr>
        </table>
        <div class="img" style="font-size:0pt; line-height:0pt; text-align:left"><div class="hide-for-mobile"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/box_bottom.jpg" alt="" border="0" width="660" height="5" /></div></div>
        <div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>';	
        }
    }
}
					
$messageFooter = '<div style="font-size:0pt; line-height:0pt; height:20px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="20" style="height:20px" alt="" /></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="font-size:0pt; line-height:0pt; height:35px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="35" style="height:35px" alt="" /></div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#333333" class="w320">
            <tr>
                <td class="footer" style="color:#adadad; font-family:Arial; font-size:12px; line-height:18px; text-align:center">
                    <div class="hide-for-mobile">
                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#d2d2d2; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                        <div style="font-size:0pt; line-height:0pt; height:1px; background:#ffffff; "><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="1" style="height:1px" alt="" /></div>
                    </div>
                    <div style="font-size:0pt; line-height:0pt; height:30px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="30" style="height:30px" alt="" /></div>
                    <strong style="font-size: 15px; line-height: 19px; color:#e0e0e0">Actionable Information Advisory Inc., '.$site_company_address.', '.$site_company_state.', '. $site_company_zip.'</strong>
                    <div style="font-size:0pt; line-height:0pt; height:10px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="10" style="height:10px" alt="" /></div>
                    This newsletter was sent to you from Execfile.<br />
                    Rather not receive our newsletter anymore? <a href="mailto:unsub@alertfetch.com?subject=unsubscribe" target="_blank" class="link3-u" style="color:#adadad; text-decoration:underline"><span class="link3-u" style="color:#adadad; text-decoration:underline">Unsubscribe instantly</span></a>.
                    <div class="hide-for-mobile"><div style="font-size:0pt; line-height:0pt; height:50px"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="50" style="height:50px" alt="" /></div></div>
                    <div style="font-size:0pt; line-height:0pt;" class="mobile-br-25"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/empty.gif" width="1" height="0" alt="" /></div>
                </td>
            </tr>
        </table>
        </td>
    </tr>
</table>';

					

					$emailDetails = $messageHead.$message.$messageFooter;	

					$emailContent = $messageHead.$messageEmail.$messageFooter;	



		  		  //echo $message;
				  if($debug == 1)
				  {
					echo "<br>user_email: ". $user_email;
					echo "<br>user_first_name: ". $user_first_name;
					echo "<br>emailContent: ". $emailContent;
				}	

			  	  $email = $user_email;

				  $mail->MsgHTML($emailContent);

				  $mail->AddAddress($email, $user_first_name);

				 

				  $user_id = $alert_row['user_id'];

				  $alert_id = $alert_row['alert_id'];

				  $emailContent =com_db_input($emailContent);

				  $emailDetails =com_db_input($emailDetails);

				  $email_id = $email_alert_id;

				  $sent_date = time();

				  if($debug == 1)
				  {
					echo "<br>FAR Undo total_job_id: ".$total_job_id;
					echo "<br>FAR Undo total_funding_id: ".$total_funding_id;
				  }
				  
                                  if($alert_row['alert_name'] != '')
                                  {
                                      $mail->Subject       = $alert_row['alert_name']." - are these your potential clients?";
                                  }    

				  if(!$mail->Send()) {

					$str_error ="Mailer Error (" . str_replace("@", "&#64;", $email) . ') ' . $mail->ErrorInfo;

					$inserError = "insert into ".TABLE_MAILER_ERROR."(str_error,email,alert_id,add_date) values('$str_error','$email','$alert_id','".date("Y-m-d")."')";

					com_db_query($inserError);

				  } else {

					  $alert_info_query = "INSERT INTO " . TABLE_ALERT_SEND_INFO . "(user_id,alert_id,contact_id,job_id,funding_id,personal_id,email_content,email_details,email_id,sent_date) values('".$user_id."','". $alert_id."','".$total_contact_id."','".$total_job_id."','".$total_funding_id."','".$total_personal_id."','".$emailContent."','$emailDetails','$email_id','".$sent_date."')";	
					//echo "<br>alert_info_query: ".$alert_info_query;	
					  com_db_query($alert_info_query);

					  //For next Date

					  $next_alert_date='';

					  $alert_id = $alert_id;

					  if($alert_row['delivery_schedule']=='Daily' && $alert_row['alert_date'] <= date('Y-m-d')){

							$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+1,date('Y')));

							$previous_date = $alert_row['alert_date'];

					  }elseif($alert_row['delivery_schedule']=='Weekly' && ($alert_row['alert_date'] == date('Y-m-d') || $alert_row['alert_date'] < date('Y-m-d',mktime(0,0,0,date('m'),date('d') - 6,date('Y'))))){

							$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m'),date('d')+7,date('Y')));

							$previous_date = $alert_row['alert_date'];

					  }elseif($alert_row['delivery_schedule']=='Monthly' && ($alert_row['alert_date'] == date('Y-m-d') || $alert_row['alert_date'] < date('Y-m-d',mktime(0,0,0,date('m')-1,date('d')+1,date('Y'))))){

							$next_alert_date = date('Y-m-d',mktime(0,0,0,date('m')+1,date('d'),date('Y')));

							$previous_date = $alert_row['alert_date'];

					  }

					  if($next_alert_date !=''){

						 com_db_query("update ".TABLE_ALERT." set previous_date='".$previous_date."', alert_date='".$next_alert_date."' where alert_id='".$alert_id."'");

					  }

				  }

				  // Clear all addresses and attachments for next loop

				  $mail->ClearAddresses();

				  $mail->ClearAttachments();

			  

		}

	}



com_db_query("insert into ".TABLE_ALERT_SEND ."(send_date,send_time,send_date_time) values('".date('Y-m-d')."','".date('H:i:s')."','".time()."')");



echo '<strong>Auto email send compiled</strong>';



?>

