<?php

$site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
 

//$del_q = "DELETE from hre_search_data";
//$del_res = mysql_query($del_q);  

$main_query = "select cm.company_id as company_id, cm.company_name as company_name,cm.company_website as company_website,pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.personal_image as personal_image,mm.move_id as move_id,mm.title as title,
pm.level as level, pm.level_order as level_order
from hre_personal_master as pm,
hre_company_master as cm,
hre_movement_master as mm
where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id group by personal_id";
$main_res = mysql_query($main_query);        
        
//echo "<br>Before while";
while($indRow = mysql_fetch_array($main_res))
{
    //echo "<br>within while";
    $company_id = $indRow['company_id'];
    $company_name = $indRow['company_name'];
    $company_website = $indRow['company_website'];
    $personal_id = $indRow['personal_id'];
    $first_name = $indRow['first_name'];
    $middle_name = $indRow['middle_name'];
    $last_name = $indRow['last_name'];
    $personal_image = $indRow['personal_image'];
    $move_id = $indRow['move_id'];
    $title = $indRow['title'];
    $level = $indRow['level'];
    $level_order = $indRow['level_order'];
    
    $insert_q = "";
    $insert_q = "INSERT into hre_search_data(company_id,company_name,company_website,personal_id,first_name,middle_name,last_name,personal_image,move_id,title,level,level_order) values('$company_id','$company_name','$company_website','$personal_id','$first_name','$middle_name','$last_name','$personal_image','$move_id','$title','$level','$level_order')";
    
    //echo "<br>insert_q: ".$insert_q;
    
    $main_ins = mysql_query($insert_q);
}
?>

