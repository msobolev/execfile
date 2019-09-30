<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
//include("includes/configuration.php");

include("config.php");


$exec = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$exec) or die ("ERROR: Database not found ");

function getPersonalDetails($personalId,$site)
{
    if($site == 'cto')
    {
        $personalDb = "cto_personal_master";
    }    
    elseif($site == 'hre')
    {
        $personalDb = "hre_personal_master";
    }
    elseif($site == 'clo')
    {
        $personalDb = "clo_personal_master";
    }
    elseif($site == 'cmo')
    {
        $personalDb = "cmo_personal_master";
    }
    
    
    
    $getPersonal = "SELECT personal_id,first_name,middle_name,last_name,email from ".$personalDb." where personal_id = $personalId";
    $personalResult = mysql_query($getPersonal);
    
    while ($personalRow = mysql_fetch_array($personalResult))
    {
        return $personalRow;
    }        
}


function getting_email_pattern($fn,$mn,$ln,$e_domain,$c_email)
{
    //$fn = "faraz";
    //$mn = "haf";
    //$ln = "aleem";
    //$e_domain = "@nxb.com.pk";
    //$c_email = $_GET['email'];//"faraz.aleem@nxb.com.pk";

    $fn = strtolower($fn);
    $mn = strtolower($mn);
    $ln = strtolower($ln);
    $e_domain = strtolower($e_domain);
    $c_email = strtolower($c_email);
    
    
    $c_email = trim($c_email);

    $first_name_initial = substr($fn, 0, 1);
    $middle_name_initial = substr($mn, 0, 1);
    $last_name_initial = substr($ln, 0, 1);
    $e_domain = "@".$e_domain;

    //echo "<br>first_name: ".$fn.":";
    //echo "<br>middle_name: ".$mn.":";
    //echo "<br>last_name: ".$ln.":";
    //echo "<br>email_domain: ".$e_domain.":";
    //echo "<br>email_to_check: ".$c_email.":";
    //echo $fn.".".$ln.$e_domain .'=='. $c_email;

    //echo "<br><br>".$fn.".".$ln.$e_domain;

    //echo "<br>first_name_initial: ".$first_name_initial;
    //echo "<br>ln: ".$ln;
    //echo "<br>first_name_initial: ".$first_name_initial;


    $pattern = '';
    if($first_name_initial.$ln.$e_domain == $c_email)
    {
            $pattern = 1;
    }
    elseif($fn.".".$ln.$e_domain == $c_email)
    {
            //echo "<br><br>In two: ".$fn.".".$ln.$e_domain;
            $pattern = 2;
    }
    elseif($fn.$e_domain == $c_email)
    {
            $pattern = 3;
    }
    elseif($fn.$last_name_initial.$e_domain == $c_email)
    {
            $pattern = 4;
    }
    elseif($fn."_".$ln.$e_domain == $c_email)
    {
            $pattern = 5;
    }
    elseif($ln.$e_domain == $c_email)
    {
            $pattern = 6;
    }
    elseif($fn.$ln.$e_domain == $c_email)
    {
            $pattern = 7;
    }
    elseif($ln.$first_name_initial.$e_domain == $c_email)
    {
            $pattern = 8;
    }
    elseif($first_name_initial.".".$ln.$e_domain == $c_email)
    {
            $pattern = 9;
    }
    elseif($ln.".".$fn.$e_domain == $c_email)
    {
            $pattern = 10;
    }
    elseif($last_name_initial.$fn.$e_domain == $c_email)
    {
            $pattern = 11;
    }
    elseif($fn."-".$ln.$e_domain == $c_email)
    {
            $pattern = 12;
    }
    elseif($first_name_initial.$first_name_initial.$ln.$e_domain == $c_email)
    {
            $pattern = 13;
    }
    elseif($first_name_initial.substr($fn, 0, 2).$e_domain == $c_email)
    {
            $pattern = 14;
    }
    elseif($first_name_initial.substr($fn, 0, 5).$e_domain == $c_email)
    {
            $pattern = 15;
    }
    elseif($first_name_initial.substr($fn, 0, 4).$e_domain == $c_email)
    {
            $pattern = 16;
    }
    elseif($first_name_initial.substr($fn, 0, 3).$e_domain == $c_email)
    {
            $pattern = 17;
    }
    elseif($first_name_initial.substr($fn, 0, 7).$e_domain == $c_email)
    {
            $pattern = 18;
    }
    elseif($first_name_initial.substr($fn, 0, 6).$e_domain == $c_email)
    {
            $pattern = 19;
    }
    elseif($ln."_".$fn.$e_domain == $c_email)
    {
            $pattern = 20;
    }
    elseif($fn.".".$middle_name_initial.".".$ln.$e_domain == $c_email)
    {
            $pattern = 21;
    }
    elseif($fn."_".$middle_name_initial."_".$ln.$e_domain == $c_email)
    {
            $pattern = 22;
    }
    elseif($ln.".".$first_name_initial == $c_email)
    {
            $pattern = 23;
    }
    elseif($ln."_".substr($fn, 0, 2) == $c_email)
    {
            $pattern = 24;
    }
    elseif($first_name_initial."_".$ln == $c_email)
    {
            $pattern = 25;
    }
    elseif($first_name_initial.$last_name_initial == $c_email)
    {
            $pattern = 26;
    }
    elseif($first_name_initial.$middle_name_initial.$last_name_initial == $c_email)
    {
            $pattern = 27;
    }
    return $pattern;
}



if(isset($_GET['limit']) && $_GET['limit'] != '')
    $limit = $_GET['limit'];
else
    $limit = "10";


$getCompanies = "SELECT COUNT( * ) AS movementCount, cm.company_id, GROUP_CONCAT( pm.email ) personalEmails, GROUP_CONCAT( pm.personal_id ) as personalIds, cm.email_domain as email_domain
FROM cto_movement_master AS mm, cto_personal_master AS pm, hre_company_master AS cm
WHERE cm.company_id = mm.company_id
AND pm.personal_id = mm.personal_id
AND pm.email_verified =  ''
AND (cm.email_pattern_id = 0 || cm.email_pattern_id = '')
AND (cm.most_likely_email_pattern = 0 || cm.most_likely_email_pattern = '')
GROUP BY cm.company_id
ORDER BY movementCount DESC Limit $limit;";

echo "<br>getCompanies:".$getCompanies;

$companyResult = mysql_query($getCompanies,$exec);

while ($companyRow = mysql_fetch_array($companyResult))
{
    $personalIds = $companyRow['personalIds'];
    $emailDomain = $companyRow['email_domain'];
    $companyId = $companyRow['company_id'];
    
    
    echo "<br><br><br><br>Email Domain:".$emailDomain;
    echo "<br>Personal_emails:".$companyRow['personalEmails'];
    echo "<br>Personal_ids:".$personalIds;
    echo "<br>Company ID:".$companyId;
    
    $personalIdsArr = explode(",",$personalIds); // CTO
    
    $getHrPersonal = "select group_concat(pm.personal_id) as hrPersonals from hre_company_master as cm,
    hre_personal_master as pm,hre_movement_master as mm 
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id
    and mm.company_id = $companyId
    ";
    
    echo "<br>getHrPersonal:".$getHrPersonal;
    
    $hrPersonalResult = mysql_query($getHrPersonal,$exec);
    $hrPersonalRow = mysql_fetch_array($hrPersonalResult);
    $hrPersonals = $hrPersonalRow['hrPersonals'];

    echo "<br>hrPersonals:".$hrPersonals;
    
    $personalIdsHrArr = explode(",",$hrPersonals); // HR

    
    $getCloPersonal = "select group_concat(pm.personal_id) as cloPersonals from hre_company_master as cm,
    clo_personal_master as pm,clo_movement_master as mm 
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id
    and mm.company_id = $companyId
    ";
    
    echo "<br>getCloPersonal:".$getCloPersonal;
    
    $cloPersonalResult = mysql_query($getCloPersonal,$exec);
    $cloPersonalRow = mysql_fetch_array($cloPersonalResult);
    $cloPersonals = $cloPersonalRow['cloPersonals'];

    echo "<br>cloPersonals:".$cloPersonals;
    
    $personalIdsCloArr = explode(",",$cloPersonals); // CLO
    
    
    
    $getCmoPersonal = "select group_concat(pm.personal_id) as cmoPersonals from hre_company_master as cm,
    cmo_personal_master as pm,cmo_movement_master as mm 
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id
    and mm.company_id = $companyId
    ";
    
    echo "<br>getCmoPersonal:".$getCmoPersonal;
    
    $cmoPersonalResult = mysql_query($getCmoPersonal,$exec);
    $cmoPersonalRow = mysql_fetch_array($cmoPersonalResult);
    $cmoPersonals = $cmoPersonalRow['cmoPersonals'];

    echo "<br>cmoPersonals:".$cmoPersonals;
    
    $personalIdsCmoArr = explode(",",$cmoPersonals); // CLO



    //die();
    
    //echo "<pre>";   print_r($personalIdsArr);   echo "</pre>";
    
    
    $pattern1Count=0;
    $pattern2Count=0;
    $pattern3Count=0;
    $pattern4Count=0;
    $pattern5Count=0;
    $pattern6Count=0;
    $pattern7Count=0;
    $pattern8Count=0;
    $pattern9Count=0;
    $pattern10Count=0;
    $pattern11Count=0;
    $pattern12Count=0;
    $pattern13Count=0;
    $pattern14Count=0;
    $pattern15Count=0;
    $pattern16Count=0;
    $pattern17Count=0;
    $pattern18Count=0;
    $pattern19Count=0;
    $pattern20Count=0;
    $pattern21Count=0;
    $pattern22Count=0;
    $pattern23Count=0;
    $pattern24Count=0;
    $pattern25Count=0;
    $pattern26Count=0;
    $pattern27Count=0;
    $pattern28Count=0;
    $pattern29Count=0;
    
    $personalDetailsArr = array();
    $totalCompanyEailsCount = 0;
    
    foreach($personalIdsArr as $index => $personalId)
    {
        $personalDetailsArr[] = getPersonalDetails($personalId,'cto');
        
    }    
    
    
    foreach($personalIdsHrArr as $index => $personalId)
    {
        $personalDetailsArr[] = getPersonalDetails($personalId,'hre');
        
    }
    
    foreach($personalIdsCloArr as $index => $personalId)
    {
        $personalDetailsArr[] = getPersonalDetails($personalId,'clo');
        
    }
    foreach($personalIdsCmoArr as $index => $personalId)
    {
        $personalDetailsArr[] = getPersonalDetails($personalId,'cmo');
        
    }
    
    
    //echo "<pre>personalDetails:";   print_r($personalDetails);   echo "</pre>";
    
    foreach($personalDetailsArr as $index => $personalDetails)
    {
        echo "<br>first_name:".$personalDetails['first_name'];
        echo "<br>middle_name:".$personalDetails['middle_name'];
        echo "<br>last_name:".$personalDetails['last_name'];
        //echo "<br>email_domain:".$email_domain;
        echo "<br>email:".$personalDetails['email'];
        
        $new_pattern_id = getting_email_pattern($personalDetails['first_name'],$personalDetails['middle_name'],$personalDetails['last_name'],$emailDomain,$personalDetails['email']);
        echo "<br>new_pattern_id:".$new_pattern_id;
        
        if($new_pattern_id == 1)
            $pattern1Count++;
        if($new_pattern_id == 2)
            $pattern2Count++;
        if($new_pattern_id == 3)
            $pattern3Count++;
        if($new_pattern_id == 4)
            $pattern4Count++;
        if($new_pattern_id == 5)
            $pattern5Count++;
        if($new_pattern_id == 6)
            $pattern6Count++;
        if($new_pattern_id == 7)
            $pattern7Count++;
        if($new_pattern_id == 8)
            $pattern8Count++;
        if($new_pattern_id == 9)
            $pattern9Count++;
        if($new_pattern_id == 10)
            $pattern10Count++;
        if($new_pattern_id == 11)
            $pattern11Count++;
        if($new_pattern_id == 12)
            $pattern12Count++;
        if($new_pattern_id == 13)
            $pattern13Count++;
        if($new_pattern_id == 14)
            $pattern14Count++;
        if($new_pattern_id == 15)
            $pattern15Count++;
        if($new_pattern_id == 16)
            $pattern16Count++;
        if($new_pattern_id == 17)
            $pattern17Count++;
        if($new_pattern_id == 18)
            $pattern18Count++;
        if($new_pattern_id == 19)
            $pattern19Count++;
        if($new_pattern_id == 20)
            $pattern20Count++;
        if($new_pattern_id == 21)
            $pattern21Count++;
        if($new_pattern_id == 22)
            $pattern22Count++;
        if($new_pattern_id == 23)
            $pattern23Count++;
        if($new_pattern_id == 24)
            $pattern24Count++;
        if($new_pattern_id == 25)
            $pattern25Count++;
        if($new_pattern_id == 26)
            $pattern26Count++;
        if($new_pattern_id == 27)
            $pattern27Count++;
        if($new_pattern_id == 28)
            $pattern28Count++;
        if($new_pattern_id == 29)
            $pattern29Count++;
        
        $totalCompanyEailsCount++;
        
    }    
    
    echo "<br>totalCompanyEailsCount".$totalCompanyEailsCount;
    echo "<br>pattern2Count".$pattern2Count;
    
    
    $pattern1Percent = ($pattern1Count/$totalCompanyEailsCount)*100;
    $pattern2Percent = ($pattern2Count/$totalCompanyEailsCount)*100;
    $pattern3Percent = ($pattern3Count/$totalCompanyEailsCount)*100;
    $pattern4Percent = ($pattern4Count/$totalCompanyEailsCount)*100;
    $pattern5Percent = ($pattern5Count/$totalCompanyEailsCount)*100;
    $pattern6Percent = ($pattern6Count/$totalCompanyEailsCount)*100;
    $pattern7Percent = ($pattern7Count/$totalCompanyEailsCount)*100;
    $pattern8Percent = ($pattern8Count/$totalCompanyEailsCount)*100;
    $pattern9Percent = ($pattern9Count/$totalCompanyEailsCount)*100;
    $pattern10Percent = ($pattern10Count/$totalCompanyEailsCount)*100;
    $pattern11Percent = ($pattern11Count/$totalCompanyEailsCount)*100;
    $pattern12Percent = ($pattern12Count/$totalCompanyEailsCount)*100;
    $pattern13Percent = ($pattern13Count/$totalCompanyEailsCount)*100;
    $pattern14Percent = ($pattern14Count/$totalCompanyEailsCount)*100;
    $pattern15Percent = ($pattern15Count/$totalCompanyEailsCount)*100;
    $pattern16Percent = ($pattern16Count/$totalCompanyEailsCount)*100;
    $pattern17Percent = ($pattern17Count/$totalCompanyEailsCount)*100;
    $pattern18Percent = ($pattern18Count/$totalCompanyEailsCount)*100;
    $pattern19Percent = ($pattern19Count/$totalCompanyEailsCount)*100;
    $pattern20Percent = ($pattern20Count/$totalCompanyEailsCount)*100;
    $pattern21Percent = ($pattern21Count/$totalCompanyEailsCount)*100;
    $pattern22Percent = ($pattern22Count/$totalCompanyEailsCount)*100;
    $pattern23Percent = ($pattern23Count/$totalCompanyEailsCount)*100;
    $pattern24Percent = ($pattern24Count/$totalCompanyEailsCount)*100;
    $pattern25Percent = ($pattern25Count/$totalCompanyEailsCount)*100;
    $pattern26Percent = ($pattern26Count/$totalCompanyEailsCount)*100;
    $pattern27Percent = ($pattern27Count/$totalCompanyEailsCount)*100;
    $pattern28Percent = ($pattern28Count/$totalCompanyEailsCount)*100;
    $pattern29Percent = ($pattern29Count/$totalCompanyEailsCount)*100;
    
    
    $mostLikelyPattern = "";
    if($pattern1Percent > 70)
        $mostLikelyPattern = 1;
    elseif($pattern2Percent > 70)
        $mostLikelyPattern = 2;
    elseif($pattern3Percent > 70)
        $mostLikelyPattern = 3;
    elseif($pattern4Percent > 70)
        $mostLikelyPattern = 4;
    elseif($pattern5Percent > 70)
        $mostLikelyPattern = 5;
    elseif($pattern6Percent > 70)
        $mostLikelyPattern = 6;
    elseif($pattern7Percent > 70)
        $mostLikelyPattern = 7;
    elseif($pattern8Percent > 70)
        $mostLikelyPattern = 8;
    elseif($pattern9Percent > 70)
        $mostLikelyPattern = 9;
    elseif($pattern10Percent > 70)
        $mostLikelyPattern = 10;
    elseif($pattern11Percent > 70)
        $mostLikelyPattern = 11;
    elseif($pattern12Percent > 70)
        $mostLikelyPattern = 12;
    elseif($pattern13Percent > 70)
        $mostLikelyPattern = 13;
    elseif($pattern14Percent > 70)
        $mostLikelyPattern = 14;
    elseif($pattern15Percent > 70)
        $mostLikelyPattern = 15;
    elseif($pattern16Percent > 70)
        $mostLikelyPattern = 16;
    elseif($pattern17Percent > 70)
        $mostLikelyPattern = 17;
    elseif($pattern18Percent > 70)
        $mostLikelyPattern = 18;
    elseif($pattern19Percent > 70)
        $mostLikelyPattern = 19;
    elseif($pattern20Percent > 70)
        $mostLikelyPattern = 20;
    elseif($pattern21Percent > 70)
        $mostLikelyPattern = 21;
    elseif($pattern22Percent > 70)
        $mostLikelyPattern = 22;
    elseif($pattern23Percent > 70)
        $mostLikelyPattern = 23;
    elseif($pattern24Percent > 70)
        $mostLikelyPattern = 24;
    elseif($pattern25Percent > 70)
        $mostLikelyPattern = 25;
    elseif($pattern26Percent > 70)
        $mostLikelyPattern = 26;
    elseif($pattern27Percent > 70)
        $mostLikelyPattern = 27;
    elseif($pattern28Percent > 70)
        $mostLikelyPattern = 28;
    elseif($pattern29Percent > 70)
        $mostLikelyPattern = 29;
    
    
    
    echo "<br>pattern1Percent:".$pattern1Percent;
    echo "<br>pattern2Percent:".$pattern2Percent;
    echo "<br>pattern3Percent:".$pattern3Percent;
    echo "<br>pattern4Percent:".$pattern4Percent;
    echo "<br>pattern6Percent:".$pattern5Percent;
    echo "<br>pattern6Percent:".$pattern6Percent;
    echo "<br>pattern7Percent:".$pattern7Percent;
    echo "<br>pattern8Percent:".$pattern8Percent;
    echo "<br>pattern9Percent:".$pattern9Percent;
    echo "<br>pattern10Percent:".$pattern10Percent;
    echo "<br>pattern11Percent:".$pattern11Percent;
    echo "<br>pattern12Percent:".$pattern12Percent;
    echo "<br>pattern13Percent:".$pattern13Percent;
    echo "<br>pattern14Percent:".$pattern14Percent;
    echo "<br>pattern15Percent:".$pattern15Percent;
    echo "<br>pattern16Percent:".$pattern16Percent;
    echo "<br>pattern17Percent:".$pattern17Percent;
    echo "<br>pattern18Percent:".$pattern18Percent;
    echo "<br>pattern19Percent:".$pattern19Percent;
    echo "<br>pattern20Percent:".$pattern20Percent;
    echo "<br>pattern21Percent:".$pattern21Percent;
    echo "<br>pattern22Percent:".$pattern22Percent;
    echo "<br>pattern23Percent:".$pattern23Percent;
    echo "<br>pattern24Percent:".$pattern24Percent;
    echo "<br>pattern25Percent:".$pattern25Percent;
    echo "<br>pattern26Percent:".$pattern26Percent;
    echo "<br>pattern27Percent:".$pattern27Percent;
    echo "<br>pattern28Percent:".$pattern28Percent;
    echo "<br>pattern29Percent:".$pattern29Percent;
    
    
    if($mostLikelyPattern != '')
    {    
        $updateCompany = "UPDATE cto_company_master set most_likely_email_pattern = $mostLikelyPattern where company_id = $companyId";
        echo "<br>updateCompany:".$updateCompany;
        //mysql_query($updateCompany);
        
        //echo "<br>insert into cto_company_update_info(page_name,query_string,add_date) values('most-likely-script','".addslashes($updateCompany)."','".date("Y-m-d:H:i:s")."')";
        
        //mysql_query("insert into cto_company_update_info(page_name,query_string,add_date) values('most-likely-script','".addslashes($updateCompany)."','".date("Y-m-d:H:i:s")."')");
        
        
    }    
    
    
    /*
        
        echo "<pre>personalDetails:";   print_r($personalDetails);   echo "</pre>";
        
        echo "<br>first_name:".$personalDetails['first_name'];
        echo "<br>middle_name:".$personalDetails['middle_name'];
        echo "<br>last_name:".$personalDetails['last_name'];
        //echo "<br>email_domain:".$email_domain;
        echo "<br>email:".$personalDetails['email'];
        
        $new_pattern_id = getting_email_pattern($personalDetails['first_name'],$personalDetails['middle_name'],$personalDetails['last_name'],$emailDomain,$personalDetails['email']);
        echo "<br>new_pattern_id:".$new_pattern_id;
        
        if($new_pattern_id == 1)
            $pattern1Count++;
        if($new_pattern_id == 2)
            $pattern2Count++;
        if($new_pattern_id == 3)
            $pattern3Count++;
        if($new_pattern_id == 4)
            $pattern4Count++;
        if($new_pattern_id == 5)
            $pattern5Count++;
        if($new_pattern_id == 6)
            $pattern6Count++;
        if($new_pattern_id == 7)
            $pattern7Count++;
        if($new_pattern_id == 8)
            $pattern8Count++;
        if($new_pattern_id == 9)
            $pattern9Count++;
        if($new_pattern_id == 10)
            $pattern10Count++;
        if($new_pattern_id == 11)
            $pattern11Count++;
        if($new_pattern_id == 12)
            $pattern12Count++;
        if($new_pattern_id == 13)
            $pattern13Count++;
        if($new_pattern_id == 14)
            $pattern14Count++;
        if($new_pattern_id == 15)
            $pattern15Count++;
        if($new_pattern_id == 16)
            $pattern16Count++;
        if($new_pattern_id == 17)
            $pattern17Count++;
        if($new_pattern_id == 18)
            $pattern18Count++;
        if($new_pattern_id == 19)
            $pattern19Count++;
        if($new_pattern_id == 20)
            $pattern20Count++;
        if($new_pattern_id == 21)
            $pattern21Count++;
        if($new_pattern_id == 22)
            $pattern22Count++;
        if($new_pattern_id == 23)
            $pattern23Count++;
        if($new_pattern_id == 24)
            $pattern24Count++;
        if($new_pattern_id == 25)
            $pattern25Count++;
        if($new_pattern_id == 26)
            $pattern26Count++;
        if($new_pattern_id == 27)
            $pattern27Count++;
        if($new_pattern_id == 28)
            $pattern28Count++;
        if($new_pattern_id == 29)
            $pattern29Count++;
        
        
        $totalCompanyEailsCount++;
        
    }    
    
    $pattern1Percent = ($pattern1Count/$totalCompanyEailsCount)*100;
    $pattern2Percent = ($pattern2Count/$totalCompanyEailsCount)*100;
    $pattern3Percent = ($pattern3Count/$totalCompanyEailsCount)*100;
    $pattern4Percent = ($pattern4Count/$totalCompanyEailsCount)*100;
    $pattern5Percent = ($pattern5Count/$totalCompanyEailsCount)*100;
    $pattern6Percent = ($pattern6Count/$totalCompanyEailsCount)*100;
    $pattern7Percent = ($pattern7Count/$totalCompanyEailsCount)*100;
    $pattern8Percent = ($pattern8Count/$totalCompanyEailsCount)*100;
    $pattern9Percent = ($pattern9Count/$totalCompanyEailsCount)*100;
    $pattern10Percent = ($pattern10Count/$totalCompanyEailsCount)*100;
    $pattern11Percent = ($pattern11Count/$totalCompanyEailsCount)*100;
    $pattern12Percent = ($pattern12Count/$totalCompanyEailsCount)*100;
    $pattern13Percent = ($pattern13Count/$totalCompanyEailsCount)*100;
    $pattern14Percent = ($pattern14Count/$totalCompanyEailsCount)*100;
    $pattern15Percent = ($pattern15Count/$totalCompanyEailsCount)*100;
    $pattern16Percent = ($pattern16Count/$totalCompanyEailsCount)*100;
    $pattern17Percent = ($pattern17Count/$totalCompanyEailsCount)*100;
    $pattern18Percent = ($pattern18Count/$totalCompanyEailsCount)*100;
    $pattern19Percent = ($pattern19Count/$totalCompanyEailsCount)*100;
    $pattern20Percent = ($pattern20Count/$totalCompanyEailsCount)*100;
    $pattern21Percent = ($pattern21Count/$totalCompanyEailsCount)*100;
    $pattern22Percent = ($pattern22Count/$totalCompanyEailsCount)*100;
    $pattern23Percent = ($pattern23Count/$totalCompanyEailsCount)*100;
    $pattern24Percent = ($pattern24Count/$totalCompanyEailsCount)*100;
    $pattern25Percent = ($pattern25Count/$totalCompanyEailsCount)*100;
    $pattern26Percent = ($pattern26Count/$totalCompanyEailsCount)*100;
    $pattern27Percent = ($pattern27Count/$totalCompanyEailsCount)*100;
    $pattern28Percent = ($pattern28Count/$totalCompanyEailsCount)*100;
    $pattern29Percent = ($pattern29Count/$totalCompanyEailsCount)*100;
    
    
    $mostLikelyPattern = "";
    if($pattern1Percent > 70)
        $mostLikelyPattern = 1;
    elseif($pattern2Percent > 70)
        $mostLikelyPattern = 2;
    elseif($pattern3Percent > 70)
        $mostLikelyPattern = 3;
    elseif($pattern4Percent > 70)
        $mostLikelyPattern = 4;
    elseif($pattern5Percent > 70)
        $mostLikelyPattern = 5;
    elseif($pattern6Percent > 70)
        $mostLikelyPattern = 6;
    elseif($pattern7Percent > 70)
        $mostLikelyPattern = 7;
    elseif($pattern8Percent > 70)
        $mostLikelyPattern = 8;
    elseif($pattern9Percent > 70)
        $mostLikelyPattern = 9;
    elseif($pattern10Percent > 70)
        $mostLikelyPattern = 10;
    elseif($pattern11Percent > 70)
        $mostLikelyPattern = 11;
    elseif($pattern12Percent > 70)
        $mostLikelyPattern = 12;
    elseif($pattern13Percent > 70)
        $mostLikelyPattern = 13;
    elseif($pattern14Percent > 70)
        $mostLikelyPattern = 14;
    elseif($pattern15Percent > 70)
        $mostLikelyPattern = 15;
    elseif($pattern16Percent > 70)
        $mostLikelyPattern = 16;
    elseif($pattern17Percent > 70)
        $mostLikelyPattern = 17;
    elseif($pattern18Percent > 70)
        $mostLikelyPattern = 18;
    elseif($pattern19Percent > 70)
        $mostLikelyPattern = 19;
    elseif($pattern20Percent > 70)
        $mostLikelyPattern = 20;
    elseif($pattern21Percent > 70)
        $mostLikelyPattern = 21;
    elseif($pattern22Percent > 70)
        $mostLikelyPattern = 22;
    elseif($pattern23Percent > 70)
        $mostLikelyPattern = 23;
    elseif($pattern24Percent > 70)
        $mostLikelyPattern = 24;
    elseif($pattern25Percent > 70)
        $mostLikelyPattern = 25;
    elseif($pattern26Percent > 70)
        $mostLikelyPattern = 26;
    elseif($pattern27Percent > 70)
        $mostLikelyPattern = 27;
    elseif($pattern28Percent > 70)
        $mostLikelyPattern = 28;
    elseif($pattern29Percent > 70)
        $mostLikelyPattern = 29;
    
    
    
    if($mostLikelyPattern != '')
    {    
        $updateCompany = "UPDATE cto_company_master set most_likely_email_pattern = $mostLikelyPattern where company_id = $companyId";
        echo "<br>updateCompany:".$updateCompany;
        mysql_query($updateCompany);
        
        echo "<br>insert into cto_company_update_info(page_name,query_string,add_date) values('most-likely-script','".addslashes($updateCompany)."','".date("Y-m-d:H:i:s")."')";
        
        mysql_query("insert into cto_company_update_info(page_name,query_string,add_date) values('most-likely-script','".addslashes($updateCompany)."','".date("Y-m-d:H:i:s")."')");
        
        
    }    
    
    
    
    
    
    
    
    
    
    
    
    
    echo "<br>pattern1Percent:".$pattern1Percent;
    echo "<br>pattern2Percent:".$pattern2Percent;
    echo "<br>pattern3Percent:".$pattern3Percent;
    echo "<br>pattern4Percent:".$pattern4Percent;
    echo "<br>pattern6Percent:".$pattern5Percent;
    echo "<br>pattern6Percent:".$pattern6Percent;
    echo "<br>pattern7Percent:".$pattern7Percent;
    echo "<br>pattern8Percent:".$pattern8Percent;
    echo "<br>pattern9Percent:".$pattern9Percent;
    echo "<br>pattern10Percent:".$pattern10Percent;
    echo "<br>pattern11Percent:".$pattern11Percent;
    echo "<br>pattern12Percent:".$pattern12Percent;
    echo "<br>pattern13Percent:".$pattern13Percent;
    echo "<br>pattern14Percent:".$pattern14Percent;
    echo "<br>pattern15Percent:".$pattern15Percent;
    echo "<br>pattern16Percent:".$pattern16Percent;
    echo "<br>pattern17Percent:".$pattern17Percent;
    echo "<br>pattern18Percent:".$pattern18Percent;
    echo "<br>pattern19Percent:".$pattern19Percent;
    echo "<br>pattern20Percent:".$pattern20Percent;
    echo "<br>pattern21Percent:".$pattern21Percent;
    echo "<br>pattern22Percent:".$pattern22Percent;
    echo "<br>pattern23Percent:".$pattern23Percent;
    echo "<br>pattern24Percent:".$pattern24Percent;
    echo "<br>pattern25Percent:".$pattern25Percent;
    echo "<br>pattern26Percent:".$pattern26Percent;
    echo "<br>pattern27Percent:".$pattern27Percent;
    echo "<br>pattern28Percent:".$pattern28Percent;
    echo "<br>pattern29Percent:".$pattern29Percent;
    */
}        