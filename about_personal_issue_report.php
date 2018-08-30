<?php
require('functions.php');
require('config.php');
//com_db_connect_hre2() or die('Unable to connect to database server!');

$site = mysql_connect("localhost","root","ecbu4!!exlmnnb",TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");


//echo "<br>POS:".strpos('christopher rott is senior vice president human resources at healthpro rehabilitation management services','healthpro rehabilitation management services');
//die();

$func = 'hr';

$table_company_master           = "hre_company_master";
if($func == '' || $func == 'hr')
{

    $table_personal_master          = "hre_personal_master";
    $table_movement_master          = "hre_movement_master";
}
elseif($func == 'cto' || $func == 'ciso')
{
    $table_personal_master          = "cto_personal_master";
    $table_movement_master          = "cto_movement_master";
}
elseif($func == 'cfo')
{
    $table_personal_master          = "cfo_personal_master";
    $table_movement_master          = "cfo_movement_master";

}
elseif($func == 'cmo'  || $func == 'cso')
{
    $table_personal_master          = "cmo_personal_master";
    $table_movement_master          = "cmo_movement_master";
}
elseif($func == 'clo')
{
    $table_personal_master          = "clo_personal_master";
    $table_movement_master          = "clo_movement_master";


}
    
$personal_ids = "";
//$get_persoanl_mul_move = "select count(distinct company_id) as move_count,personal_id from $table_movement_master where personal_id = 1071 group by personal_id having move_count > 1 limit 0,88000";
$get_persoanl_mul_move = "select count(distinct company_id) as move_count,personal_id from $table_movement_master group by personal_id having move_count > 1 limit 0,500";
echo "<br><br><br><br><br>Q1:".$get_persoanl_mul_move;
$mul_move_rs = mysql_query($get_persoanl_mul_move,$site);
//echo "<pre>mul_move_rs:";   print_r($mul_move_rs);   echo "</pre>";
while($indRow = mysql_fetch_array($mul_move_rs))
{
    
    //echo "<pre>indRow:";   print_r($indRow);   echo "</pre>";
    
    $get_personal_detail = "SELECT pm.first_name,pm.last_name,mm.title,pm.personal_id, mm.move_id, cm.company_name, about_person
            FROM hre_company_master AS cm, $table_movement_master AS mm, $table_personal_master AS pm
            WHERE cm.company_id = mm.company_id
            AND pm.personal_id = mm.personal_id
            and pm.personal_id = ".$indRow['personal_id']."
            ORDER BY move_id DESC limit 1;";
    //echo "<br>Q2:".$get_personal_detail;
    $details_rs = mysql_query($get_personal_detail,$site);
    $details = mysql_fetch_array($details_rs);
    
    
    //$pos_at = strpos($details['about_person'],' at ');
    //$comp_name_from_abt = substr($details['about_person'],$pos_at,strpos($details['about_person'],'.'));
    //$temp_first_line = ""
    
    //echjo "<br>Dot pos:";
    //$first_line_db = substr($details['about_person'],0,strpos($details['about_person'],' at'));
    //echo "<br>comp_name_from_abt:".$comp_name_from_abt;
    
    //$first_line = trim(strtolower($details['first_name']." ".$details['last_name']." is the ".$details['title']." at "));
    $first_line = trim(strtolower($details['first_name']." ".$details['last_name']." is "));
    
    
    $dot_pos = strpos($details['about_person'],".");
    $first_line_with_comp = substr(strtolower($details['about_person']),0,$dot_pos);
    
    $first_line_with_comp_original = substr($details['about_person'],0,$dot_pos);
    
    //$first_line_with_comp = trim(strtolower($details['first_name']." ".$details['last_name']." is the ".$details['title']." at ".$details['company_name']));
    
    
    //echo "<br>first_line:".$first_line;
    
    $abt_person = trim(strtolower($details['about_person']));
    
     echo "<br><br><br><pre>details:";   print_r($details);   echo "</pre>";
    //echo "<br>strpos:".strpos($first_line,$abt_person);
    
    if(strpos($abt_person,$first_line) > -1)
    {   
        $latest_company = strtolower($details['company_name']);
       
        echo "<br>abt_person:".$abt_person;
        echo "<br>first_line:".$first_line;
        echo "<br>first_line_with_comp:".$first_line_with_comp.":";
        echo "<br>latest company:".$latest_company;
        //echo "<br>Matching::::::";
        
        $current_comp_pos = "";
        $current_comp_first_pos = "";
        
        $current_comp_pos = strpos($first_line_with_comp,$latest_company);
        
        // second case when only first string of company is present in abt person field
        $first_string_company_pos = strpos($latest_company,' ');
        
        if($first_string_company_pos > -1)
        {
            $first_string_company = substr($latest_company,0,$first_string_company_pos);
            echo "<br>first_string_company_pos:".$first_string_company_pos;
            echo "<br>first_string_company:".$first_string_company;
        
            $current_comp_first_pos = strtolower(strpos($first_line_with_comp,$first_string_company));
        }
        else
            $current_comp_first_pos = strtolower(strpos($first_line_with_comp,$latest_company));
        
        echo "<br>current_comp_pos:".$current_comp_pos;
        echo "<br>current_comp_first_pos:".$current_comp_first_pos;
        
        //if($current_comp_pos == '')
        //    $personal_ids .= $details['personal_id'].",";
        //if($first_string_company_pos > -1 && $current_comp_first_pos == '')
        if($current_comp_first_pos == '')            
        {    
            
            
            $previous_move = "SELECT mm.title, cm.company_name
            FROM hre_company_master AS cm, $table_movement_master AS mm
            WHERE cm.company_id = mm.company_id
            and mm.personal_id = ".$details['personal_id']."
            ORDER BY move_id DESC limit 1,1;";
            
            echo "<br>previous_move:".$previous_move;
            
            $previous_rs = mysql_query($previous_move,$site);
            $previous = mysql_fetch_array($previous_rs);
            
            
            $previous_move_abt_bio = $details['first_name']." ".$details['last_name']." is ".$previous['title']." at ".$previous['company_name'];
            $previous_move_abt_bio_the = $details['first_name']." ".$details['last_name']." is the ".$previous['title']." at ".$previous['company_name'];
            echo "<br>previous_move_abt_bio:".$previous_move_abt_bio.":";
            echo "<br>previous_move_abt_bio_the:".$previous_move_abt_bio_the.":";
            //echo "<br>detail title:".$details['title'].":";
            $correct_bio = "";
            $correct_bio = $details['first_name']." ".$details['last_name']." is ".$details['title']." at ".$details['company_name'];
            echo "<br>correct_bio:".$correct_bio.":";
            if($previous_move_abt_bio == trim($first_line_with_comp_original))
            {
                echo "<br>update this: ".$details['personal_id'];
                
                $new_abt_bio = str_replace($previous_move_abt_bio,$correct_bio,$details['about_person']);
                $personal_ids .= $details['personal_id'].",";
            }    
            elseif($previous_move_abt_bio_the == trim($first_line_with_comp_original))
            {
                $new_abt_bio = str_replace($previous_move_abt_bio_the,$correct_bio,$details['about_person']);
                echo "<br>update this: ".$details['personal_id'];
                $personal_ids .= $details['personal_id'].",";
            } 
            
            echo "<br>new_abt_bio: ".$new_abt_bio;
        }    
        
        
        
        //echo "<br>current_comp_pos:".$current_comp_pos;
        
            //$personal_ids .= $details['personal_id'].",";
    }        
}

/*
$personal_ids = trim($personal_ids,",");
$personal_ids_arr = explode(",",$personal_ids);

echo "<pre>personal_ids_arr:";   print_r($personal_ids_arr);   echo "</pre>";

foreach($personal_ids_arr as $index=>$personal_data)
{
    $personal_arr = explode(":",$personal_data);
    echo "<pre>personal_arr:";   print_r($personal_arr);   echo "</pre>";    
    
    
    
    $previous_move = "SELECT pm.first_name,pm.last_name,mm.title, cm.company_name
            FROM hre_company_master AS cm, $table_movement_master AS mm
            WHERE cm.company_id = mm.company_id
            and mm.personal_id = ".$personal_id."
            ORDER BY move_id DESC limit 1,1;";
    
    
}    
*/



echo "<br>personal_ids:".$personal_ids;
?>