<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title><?='HREXECsonthemove.com ::';?> <?=$PageTitle;?></title>
    <meta name="keywords" content="<?=$PageKeywords?>" />
    <meta name="description" content="<?=$PageDescription?>" />

</head>
<body>

<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

require('functions_sitemap.php');
require('config.php');

com_db_connect() or die('Unable to connect to database server!');
$data = array();

if(isset($_GET['limit']) && $_GET['limit'] != '')
    $limit = $_GET['limit'];
$data = get_all_data('','speaking',$limit);
$base_url = "http://hr.execfile.com/";

//echo "<pre>data: ";   print_r($data);   echo "</pre>";
$c = 1;
foreach($data as $ind=>$data_arr)
{    
    //echo "<pre>data_arr: ";   print_r($data_arr);   echo "</pre>";
    $first_name = $data_arr['first_name'];
    //echo "<br>first_name: ".$first_name;
    $detail_page_url = create_url($data_arr['first_name'],$data_arr['last_name'],$data_arr['title'],$data_arr['company_name'],$data_arr['id'],'speaking');
    //echo "<br>detail_page_url: ".$detail_page_url;
    
    ?>
    <?PHP //echo $c;?><a href="<?=$detail_page_url?>"><?=$data_arr['first_name']?> <?=$data_arr['last_name']?></a>
    <br>
    <?PHP
    //$c++;
}    
?>

<!--
<a href="http://hr.execfile.com/Director_of_Human_Resources_Roku_details_jobs_703">Job</a>
<br>
<a href="http://hr.execfile.com/Mark_Bocianski_Senior_Vice_President_Global_Talent_Organization_Development_HP_Enterprises_details_speaking_1360">Speaking</a>
<br>
<a href="http://hr.execfile.com/Kari_Heerdt_Determining_Which_Private_Exchange_is_Best_for_Your_Organization_A_Case_Study_MSC_Industrial_Direct_details_awards_741">Job</a>
<br>
<a href="http://hr.execfile.com/Jim_Bertoluzzi_Director_Human_Resources_Tauck_details_speaking_2085">Job</a>
<br>
<a href="http://hr.execfile.com/Robyn_Alper_Senior_Director_Human_Resources_Starwood_Hotels_and_Resorts_details_speaking_2086">Job</a>
<br>
<a href="http://hr.execfile.com/Jodie_Griffith_Human_Resources_Recruiter_Intermed_Longcreek_details_speaking_2090">Job</a>
-->


</body>
</html>