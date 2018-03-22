<?PHP 
session_start();
//echo "<br>HTTP_REFERER: ".$_SERVER['HTTP_REFERER'];

$show_image = 0;
if($_SERVER['HTTP_REFERER'] != '' && strpos($_SERVER['HTTP_REFERER'],'http://execfile.com') > -1)
{
    $show_image = 1;
}    
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

//$test_content = "Four to be inducted into WVU business school's Roll of Distinguished Alumni West Virginia University A-Z Site Index Campus Map Jobs Directory WVU Home WVUToday Search: WVUToday Students Community Faculty Research Arts Health Sciences Sports Media Center Home / Press Releases Four to be inducted into WVU business school's Roll of Distinguished Alumni September 23rd, 2015 Print Four outstanding Mountaineers will be honored and inducted into the West Virginia University College of Business and Economics’ prestigious Roll of Distinguished Alumni in early October. This year’s inductees are William C. Bayless, Jr., president, co-founder and CEO , American Campus Communities, Austin, Texas; Marc A. Chini, executive vice president, Human Resources, Synchrony Financial, Stamford, Connecticut; Andrew D. Peters, chief safety officer and senior vice president of AECOM , Century City, California; and Penelope F. Roll, chief financial officer, Ares Capital Corporation, New York, New York. An induction ceremony and luncheon will be held during WVU Homecoming Weekend Friday, Oct. 9, at 11:30 a.m. at the Erickson Alumni Center. “Perhaps the best thing about the B&E Roll of Distinguished Alumni is that we get to recognize a new group of people who are simply outstanding in their respective fields,” said B&E Interim Dean Nancy McIntyre. “This year’s inductees are superstars, and it’s so gratifying to see B&E graduates who have risen to be among the best of the best.” William C. Bayless, Jr. is president, CEO and co-founder of American Campus Communities, the nation’s largest developer, owner and manager of high-quality student housing communities. Bayless also serves on the ACC board of directors. He earned a Bachelor of Science in Business Administration (BSBA) in marketing from B&E in 1986, where he first began constructing his career in the student housing industry as a dishwasher, grill cook, night desk attendant and resident assistant at Summit Hall. In 1993, Bayless relocated his family to Austin, Texas, where he co-founded ACC . ACC owns and third-party manages more than 200 properties throughout the United States and Canada, and has more than 3,000 employees. It has served as the developer for Lincoln Hall on the Evansdale Campus, the Honors College on the downtown campus and the new College Park Apartments. The company also owns property in Sunnyside that it is currently developing into a modern, 536-bed student community. Marc A. Chini is executive vice president and human resources leader of Synchrony Financial, where he leverages his deep human resources experience amassed during his 30-year career. As HR leader, he advocates for strong programs to support employees such as providing training opportunities for continued growth. Marc joined Synchrony Financial in 2014 from GE where he was vice president of human resources, covering business development, commercial communications, IT, legal, sourcing, HR and global talent recruitment reporting to General Electric Company. Chini earned a BSBA degree and a Master of Science in Human Resources and Industrial Relations from WVU . Chini was also EVP , human resources, for NBC Universal, a global media company before moving to GE Corporate with the sale of NBC Universal. Marc’s earlier career roles included HR roles at McGraw-Edison and Liberty Life. Chini was elected to and currently serves on the WVU Foundation Board of Directors, as well. Andrew D. Peters is chief safety officer for AECOM , a $19 billion, fully integrated infrastructure and support services firm with the ability to design, build, finance and operate infrastructure assets globally. Peters is responsible for AECOM ’s worldwide Safety, Health and Environment programs and oversees all existing safety capabilities residing in the company’s global operations. Peters brings more than 35 years of experience in safety management, loss prevention and human resources from the mining, heavy construction and construction equipment industries. He also ensures that AECOM ’s selected consultants, partners and contractors have effective safety and loss prevention programs, providing a safe workplace during design, procurement and construction. Peters earned a BSBA degree in marketing from West Virginia University and a Master of Science in personnel administration and labor relations from St. Francis University. Penelope F. Roll is a native of Summersville, West Virginia and a 1988 graduate of B&E with a BSBA degree in accounting. Roll currently serves as executive vice president and chief financial officer of Ares Management L.P.’s Direct Lending Group and chief financial officer of Ares Capital Corporation. Prior to joining Ares, she was the chief financial officer of Allied Capital Corporation and started her career at KPMG , LLP, both in Washington, D.C. Roll currently serves on the WVU Foundation Board of Directors and the College of Business and Economics’ Visiting Committee. While at WVU , she was a member of Chi Omega sorority, Beta Alpha Psi, Beta Gamma Sigma, Mountain Honorary and the 4-H Club. She was also named Miss Mountaineer in 1987. This is the fifth class to be inducted into the B&E Roll of Distinguished Alumni, with the first four classes including a total of 22 inductees. The award was initiated in 2011 to commemorate B&E’s 60th Anniversary Celebration. Nominees must meet specific criteria: in addition to being alumni of the College, they must be at least 10 years post-degree, and have distinguished themselves by success in business or life at the regional, national or international level. Inductees are representative of the tremendous successes of B&E’s graduates. For more on the B&E Roll of Distinguished Alumni and to view current and past inductees, please visit http://be.wvu.edu/distinguished_alumni/index.htm. For further information on the WVU College of Business and Economics, visit www.be.wvu.edu. -WVU- mm/09/23/15 CONTACT : Patrick Gregg, WVU College of Business and Economics 304.293.5131; Patrick.Gregg@mail.wvu.edu Follow @WVUToday on Twitter. Tags: CollegeofBusinessandEconomics	Related Stories PepsiCo VP, B&E alum opens spring B&E speaker series February 18 WVU study: Merging West Virginia's local health departments may generate more revenue Business Index shows little hope for West Virginia economy in the near term Expert in international economics named Milan Puskar Dean of the College of Business and Economics at West Virginia University Tennessee town seeks advice of WVU student MBA team who charted revitalization plan for Fairmont WVU Experts: Faculty available to discuss 2016 State of the State Address   Media William Bayless, Jr. Download Full Size Marc Chini Download Full Size Andrew Peters Download Full Size Penelope Roll Download Full Size University Relations/News 48 Donley St. 4th Floor, Marina Tower P.O. Box 6688 Morgantown, WV 26506-6688 Email: John Bolt Phone: 304-293-6997 © 2016 West Virginia University. Last modified: April 14, 2015. Site design by University Relations, Web. West Virginia University is an Equal Opportunity/Affirmative Action Institution. Google+ WVUToday MyAccess Mountaineer Trak WVU Alert Give iTunes U WVU on Facebook WVU on Twitter WVU on YouTube Explore the hills of WVU with Foursquare MIX ";
//$after_substr = substr($test_content,0,450); 
//echo "<br><br>after_substr: ".$after_substr; 
//die();


//$headers = @get_headers("http://www.bizjournals.com/twincities/news/2016/03/04/best-buy-adds-to-c-suite-with-new-hr-chief.html");
//echo "<pre>headers: ";   print_r($headers);   echo "</pre>";


//$doc = new DOMDocument(); 
//$dd = $doc->loadHTMLFile("http://www.bizjournals.com/twincities/news/2016/03/04/best-buy-adds-to-c-suite-with-new-hr-chief.html");
//echo "<pre>dd: ";   print_r($dd);   echo "</pre>";

//include("header.php");

// Header starts
?>
<!DOCTYPE html>
<html lang="en">
    <head>
<?PHP
 
session_start();
//echo "<br>Session site:".$_SESSION["this_user_site"];

include("config.php");
include("functions.php");
$root_path = "http://45.55.139.16/ver2/";
define("EXECFILE_ROOT","http://www.execfile.com");

define("NO_PERSONAL_IMAGE","no-personal-image.png");
$profile_root_link = "https://www.hrexecsonthemove.com/";
$personal_pic_root = "https://www.hrexecsonthemove.com/";



// Getting paraments from url Starts
$dim_url = explode('/', $_SERVER['REQUEST_URI']);
$personal_url =$dim_url[sizeof($dim_url)-1];
$personal_arr = explode("_",$personal_url);
$persize = sizeof($personal_arr);
$id = $personal_arr[$persize-1];
$type = $personal_arr[$persize-2];
$exec_demo = $personal_arr[$persize-4];
if($exec_demo == 'clo')
{
    $exec_demo = 'ed';
    $_SESSION['site'] = 'clo';
}    
elseif($exec_demo == 'cmo')
{
    $exec_demo = 'ed';
    $_SESSION['site'] = 'cmo';
}
elseif($exec_demo == 'ciso')
{
    $exec_demo = 'ed';
    $_SESSION['site'] = 'cto';
}
//echo "Ses site: ".$_SESSION['site'];



if($_SESSION['site'] == '' || $_SESSION['site'] == 'hr')
{
    $personal_pic_root            = "https://www.hrexecsonthemove.com/";
}
elseif($_SESSION['site'] == 'cto' || $_SESSION['site'] == 'ciso')
{
    $personal_pic_root            = "https://www.ctosonthemove.com/";
    
}
elseif($_SESSION['site'] == 'cfo')
{
    $personal_pic_root            = "https://www.cfosonthemove.com/";
    
}
elseif($_SESSION['site'] == 'cmo'  || $_SESSION['site'] == 'cso')
{
    $personal_pic_root            = "https://www.cmosonthemove.com/";
    
}
elseif($_SESSION['site'] == 'clo')
{
    $personal_pic_root            = "https://www.closonthemove.com/";
    
}


$company_pic_root = "https://www.ctosonthemove.com/"; 
$hr_dot = "http://hr.execfile.com/"; 


//echo "<br>personal_pic_root: ".$personal_pic_root;
//if($exec_demo = 'ed')
//    $_SESSION['exec_demo'] = 1;
if($type == 'media')
    $type = "media_mention";

if(isset($_GET['st']) && $_GET['st'] != '')
    $_SESSION['site'] = $_GET['st'];






// Getting paraments from url Ends
//echo "<br>ID: ".$id;
//echo "<br>TYPE: ".$type;

//$id = $_GET['id'];
//$type = "movements"; //$_GET['type'];

//echo "<pre>SESSION: ";   print_r($_SESSION);   echo "</pre>";
/*
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}
*/
//echo "<br>ID: ".$id;
//echo "<br>TYPE: ".$type;
//echo "<br>SITE: ".$_SESSION['site'];
$all_data = get_all_data($id,$type,$_SESSION['site']);
$all_data_count = count($all_data);

//echo "<pre>all_data: ";   print_r($all_data);   echo "</pre>";
//echo "<br>FirstName: ".$all_data[0]['first_name'];


if($all_data[0]['title'] == '')
{
    $missing_data = get_missing_data($all_data[0]['personal_id']);
    if($missing_data['company_name'] != '')
        $all_data[0]['company_name'] = $missing_data['company_name'];
    
    if($missing_data['title'] != '')
        $all_data[0]['title'] = $missing_data['title'];
    
    if($missing_data['company_website'] != '')
        $all_data[0]['company_website'] = $missing_data['company_website'];
    
} 


$comp_domain_name='';
if($all_data[0]['company_website'] !='')
{
    $comp   = array("http://wwww.", "www.","https://www.","http://","https://");
    $comp_domain_name = str_replace($comp,'',$all_data[0]['company_website']);
    $comp_domain_name =' @'. $comp_domain_name;
}

   
//echo "<pre>missing_data: ";   print_r($missing_data);   echo "</pre>";

$PageTitle = com_db_output($all_data[0]['first_name']).' '.com_db_output($all_data[0]['last_name']).' | '.preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array(' ', ' ', ' '),com_db_output($all_data[0]['company_name'])).' | Email, '.com_db_output($all_data[0]['title']).', '.$comp_domain_name;
//$movement_type = $personal_row['movement_type'];
$PageKeywords=com_db_output($all_data[0]['first_name']).' '.com_db_output($all_data[0]['last_name']).', '.com_db_output($all_data[0]['company_name']).', Email, '.com_db_output($all_data[0]['title']).', '.$comp_domain_name.', bio, e-mail, executive, phone, address, addresses';
$PageDescription=com_db_output($all_data[0]['first_name']).' '.com_db_output($all_data[0]['last_name']).' is '.com_db_output($all_data[0]['title']).' of '.com_db_output($all_data[0]['company_name']).'. Execfile profile includes an email address, @url, linkedin, biography';


?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
    <title><?=$PageTitle;?></title>
    <meta property="og:type" content="profile"/>
    <meta property="og:title" content="<?=com_db_output($all_data[0]['first_name']).' '.com_db_output($all_data[0]['last_name'])?>"/>
    <meta property="og:url" content="<?=$hr_dot.$personal_url;?>"/>
	
    <meta name="keywords" content="<?=$PageKeywords?>" />
    <meta name="description" content="<?=$PageDescription?>" />
    <meta property="profile:first_name" content="<?=com_db_output($all_data[0]['first_name'])?>"/>
    <meta property="profile:last_name" content="<?=com_db_output($all_data[0]['last_name'])?>"/>
    
    
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
  
  </head>
<body>
  
  
<?PHP


?>
    
<h1 style="margin:0px auto; width:990px;margin-top:55px;"><a href="index.php"><img style="margin-left:55px;" width="257" height="24" src="css/images/new-logo.png"></a></h1>    
<?PHP

// Header ends






require_once('simple_html_dom.php');
require_once('url_to_absolute.php');





//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>";


 



$show_other_content = 1;
if(isset($_GET['sc']) && $_GET['sc'] == 1)
    $show_other_content = 1;
$outer_div_style = '';
$other_content = '';

$ec_title = "";
$ec_desc = "";

$img_c = 0;
$first_img = "";


function get_https($url)
{
    //$base = 'http://www.crunchbase.com/organization/magic-leap';
    $base = $url;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $base);
    curl_setopt($curl, CURLOPT_REFERER, $base);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $str = curl_exec($curl);
    curl_close($curl);

    // Create a DOM object
    $html = new simple_html_dom();
    // Load HTML from a string
    $html->load($str);
    return $html;
}


?>
    <div class="main">
        <?PHP //include("left.php"); ?>
        <div class="content" style="width:990px;margin:0 auto;padding-left:0px;padding-top:10px;">
            <section class="section-primary" style="max-width:990px;">
                <div class="section-body" style="padding-top:20px;<?=$outer_div_style?>">
                    <ul class="articles">
                        <?PHP
                        //echo "<br>ID: ".$id;
                        //echo "<br>Type: ".$type;
                        //$all_data = get_all_data($id,$type);
                        $i = 0;
                        //echo "<pre>";   print_r($all_data);   echo "</pre>";
                        //echo "<br>title: ".$all_data[$i]['title'];    
                        if($type == 'movements')
                        {
                            if($show_other_content == 1)
                            {
                                //echo "<br>more_link: ".$all_data[$i]['more_link'];
                                $this_source = trim($all_data[$i]['more_link']);
                                //echo "<br>this_source: ".$this_source;
                                $starting_url_part = substr($this_source,0,5);
                                //echo "<br>starting_url_part: ".$starting_url_part;
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                {    
                                    //echo "<br>in else";
                                    //$html = file_get_html($all_data[$i]['more_link']);
                                    //$html = file_get_contents($all_data[$i]['more_link']);
                                    //$html = str_get_html(file_get_contents($all_data[$i]['more_link']));
                                    
                                    //$html = get_https(file_get_contents($all_data[$i]['more_link']));
                                    $html = file_get_html($all_data[$i]['more_link']);
                                    
                                }
                                //echo "<br>HTML STR: ".$html;
                                //echo "<pre>html: ";   print_r($html);   echo "</pre>";
                                
                            }    
                            show_movements($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['move_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['movement_type'],$all_data[$i]['more_link'],$all_data[$i]['personal_image'],$personal_pic_root,'',1);
                        }    
                        elseif($type == 'awards')
                        {
                            if($show_other_content == 1)
                            {
                                $this_source = trim($all_data[$i]['awards_link']);
                                $starting_url_part = substr($this_source,0,5);
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                    $html = file_get_html($all_data[$i]['awards_link']);
                                
                            }   
                            show_awards($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['awards_title'],$all_data[$i]['awards_given_by'],$all_data[$i]['awards_date'],$all_data[$i]['awards_link'],$personal_pic_root,'',1);
                        }
                        //
                        elseif($type == 'speaking')
                        {
                            if($show_other_content == 1)
                            {
                                $this_source = trim($all_data[$i]['speaking_link']);
                                $starting_url_part = substr($this_source,0,5);
                                
                                //echo "<br>this_source: ".$this_source;
                                
                                
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                    $html = file_get_html($all_data[$i]['speaking_link']);
                                
                                
                                //echo "<br>HTML: ".$html;
                                
                                
                            } 
                            show_speaking($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['event'],$all_data[$i]['speaking_link'],$all_data[$i]['event_date'],$personal_pic_root,'','read',1);
                        }
                        if($type == 'media_mention')
                        {
                            if($show_other_content == 1)
                            {
                                $this_source = trim($all_data[$i]['media_link']);
                                $starting_url_part = substr($this_source,0,5);
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                    $html = file_get_html($all_data[$i]['media_link']);
                                
                            } 
                            show_media($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['publication'],$all_data[$i]['media_link'],$all_data[$i]['media_link'],$all_data[$i]['pub_date'],$personal_pic_root,'','read',1);
                        }
                        if($type == 'publication')
                        {    
                            if($show_other_content == 1)
                            {
                                $this_source = trim($all_data[$i]['link']);
                                $starting_url_part = substr($this_source,0,5);
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                    $html = file_get_html($all_data[$i]['link']);
                                
                            } 
                            show_publication($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['move_title'],$all_data[$i]['link'],$all_data[$i]['publication_date'],$personal_pic_root,'','read',1);
                        }
                        if($type == 'funding')
                        {   
                            if($show_other_content == 1)
                            {
                                $funding_source = trim($all_data[$i]['funding_source']);
                                $starting_url_part = substr($funding_source,0,5);
                                if($starting_url_part == 'https')
                                    $html = get_https($all_data[$i]['funding_source']);
                                else    
                                    $html = file_get_html($all_data[$i]['funding_source']);
                                
                            } 
                            show_funding($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['funding_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['funding_source'],$all_data[$i]['funding_amount'],$all_data[$i]['funding_date'],$personal_pic_root,'read',1);
                        }
                        if($type == 'jobs')
                        {   
                            if($show_other_content == 1)
                            {
                                $this_source = trim($all_data[$i]['source']);
                                $starting_url_part = substr($this_source,0,5);
                                if($starting_url_part == 'https')
                                    $html = get_https($this_source);
                                else
                                    $html = file_get_html($all_data[$i]['source']);
                                
                            } 
                            show_job($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['job_title'],$all_data[$i]['post_date'],$all_data[$i]['source'],$personal_pic_root,$company_pic_root,"",$all_data[$i]['show_state'],1);
                        }
                        ?>
                    </ul>
                    
                    <?PHP
                    //echo "<br>show_other_content: ".$show_other_content;
                    //echo "<pre>html: ";   print_r($html);   echo "</pre>";
                    if($show_other_content == 1)
                    {
                        if($html != '' )
                        {
                            $complete_plaintext = "";
                            //echo "<br><br><br>Content:::".$html->plaintext.":::"; 
                            $complete_plaintext = trim($html->plaintext);
                            $complete_plaintext = preg_replace('/\s+/', ' ',$complete_plaintext);
                            
                            $ec_desc = substr($complete_plaintext,0,450); 
                            
                            //$ec_desc = preg_replace("/<div>(.*?)<\/div>/", "$1", $ec_desc);
                            
                            $ec_desc = preg_replace('/\<[\/]{0,1}div[^\>]*\>/i', '', $ec_desc);
                            
                            //$plain_array = str_split($ec_desc);
                            //echo "<pre>plain_array: ";   print_r($plain_array);   echo "</pre>";
                            
                            preg_match("/<title>(.+)<\/title>/siU", $html, $matches);
                            //echo "Title : ".$title = $matches[1];
                            $ec_title = $matches[1];
                            $moved_pos = "";
                            //echo "<br>POS: ".strpos($ec_desc,'Jobvite Oops, we must have moved it. 404 Error ');
                            $moved_pos = strpos($ec_desc,'Jobvite Oops, we must have moved it. 404 Error ');
                            
                            $init = substr($ec_desc,0,36);
                            
                            //echo "<br>init:".$init.":";
                            if($ec_title != "Pardon Our Interruption" && $init != 'Jobvite Oops, we must have moved it.')
                            {
                                
                           
                                //echo "<br><br>ec_desc_2:::".$complete_plaintext.":::"; 
                                //echo "<br>substr length: ".strlen($complete_plaintext); 

                                //$plain_array = str_split($complete_plaintext);
                                //echo "<pre>plain_array: ";   print_r($plain_array);   echo "</pre>";

                                

                                foreach($html->find('img') as $element) 
                                {
                                    if($img_c == 0)
                                    {    
                                        $img_c++;
                                        $first_img = url_to_absolute($url, $element->src);

                                        if($first_img == '')
                                            $img_c = 0;
                                    }    
                                }


                                $outer_div_style = 'border:1px solid #ced7df;border-radius:8px;margin-bottom:60px;float:left;width:89%;margin-left:50px;';

                                $other_content = '<div style=float:left;width:100px;margin:20px 15px 0px 30px;>';

                            //echo "<br>ec_desc: ".$ec_desc;
                            //$first_img = "http://the-tma.org/strategic-recruitment/files/2011/10/sitehead.png";
                            //$ec_title = "TMA's 2016 Talent Acquisition Summit — March 10-11, 2016, Dallas, Texas. —";
                            //$ec_desc = "MA's 2016 Talent Acquisition Summit — March 10-11, 2016, Dallas, Texas. —TMA's 2016 Talent Acquisition Summit — March 10-11, 2016, Dallas, Texas. 2016 Talent Acquisition SummitTMA's 2016 Talent Acquisition Summit — March 10-11, 2016, Dallas, Texas. Register Brochure Agenda Speakers Partners Venue & Pricing Home Event Home About the Event TMA Home";


                                if($first_img != '')
                                    $other_content .= '<img width=100 src='.$first_img.'>';
                                $other_content .= '</div><div style=float:left;width:75%;margin-bottom:10px;font-weight:700;margin-top:8px;>'.$ec_title.'<br><span style=font-size:12px;color:#59626a;font-weight:400;font-size:13px;>'.$ec_desc.'</span></div>';
                            }
                        }
                        
                        //echo "<br>first_img: ".$first_img;
                        //echo "<br>ec_title: ".$ec_title;
                        //echo "<br>ec_desc: ".$ec_desc;
                        
                    }
                    ?>
                    
                    
                    <div style="<?=$outer_div_style?>">
                        <?=$other_content?>
                    </div>    
                    
                    
                </div><!-- /.section-body -->   
                
                
                
                
                
                
            </section><!-- /.section-primary -->
        </div><!-- /.content -->
    </div><!-- /.main -->    
    
    <div class="footer_links" style="text-align:center;width:100%;color:#8899a6;font-size:14px;position: fixed;bottom: 30px;">
                    
                    © <?=date("Y");?> Execfile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a target="_blank" href="https://www.hrexecsonthemove.com/why-cto.html">About</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <a href="#">Help</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                    <a href="terms.html">Terms</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="privacy.html">Privacy</a>
                </div><br>
    
    
    <?PHP
//echo "<br>details_pos bottom : ".$details_pos;
if($details_pos > -1)
{
    ?>
    <script language="javascript">
        $(".content").css("padding-top", "10px");
        //$(".content").css("padding-left", "250px");
    </script>    
    <?PHP
}    


?>