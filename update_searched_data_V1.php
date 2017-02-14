<?php

$site = mysql_connect("localhost","root","mydevsql129",TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db("hre2",$site) or die ("ERROR: Database not found ");
 


if(1 == 1)
{
    $del_q = "DELETE from hre_search_data";
    $del_res = mysql_query($del_q);  

    $main_query = "select cm.company_logo,cm.company_id as company_id, cm.company_name as company_name,cm.company_website as company_website,pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.personal_image as personal_image,mm.move_id as move_id,mm.title as title,
    pm.level as level, pm.level_order as level_order,pm.email,pm.phone,pm.about_person,cm.about_company,
    mm.headline,mm.source_id,mm.movement_type,mm.add_date,mm.announce_date,mm.more_link,mm.effective_date,mm.full_body,mm.what_happened,
    cm.company_revenue,cm.company_employee,cm.company_industry,cm.ind_group_id,cm.industry_id,cm.city,cm.state,cm.country,cm.zip_code,cm.address,cm.address2
    from hre_personal_master as pm,
    hre_company_master as cm,
    hre_movement_master as mm
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id group by personal_id";
    
    //echo "<br>main_query: ".$main_query;
    
    $main_res = mysql_query($main_query);        

    //echo "<br>Before while";
    while($indRow = mysql_fetch_array($main_res))
    {
        //echo "<br>within while";
        $company_id = $indRow['company_id'];
        $company_name = $indRow['company_name'];
        $company_website = $indRow['company_website'];
        $company_logo = $indRow['company_logo'];
        $personal_id = $indRow['personal_id'];
        $first_name = $indRow['first_name'];
        $middle_name = $indRow['middle_name'];
        $last_name = $indRow['last_name'];
        $personal_image = $indRow['personal_image'];
        
        $personal_email = $indRow['email'];
        $personal_phone = $indRow['phone'];
        
        $move_id = $indRow['move_id'];
        $title = $indRow['title'];
        $level = $indRow['level'];
        $level_order = $indRow['level_order'];

        //$headline = $indRow['headline'];
        $source_id = $indRow['source_id'];
        $movement_type = $indRow['movement_type'];
        $add_date = $indRow['add_date'];
        $announce_date = $indRow['announce_date'];
        $more_link = $indRow['more_link'];

        $company_revenue = $indRow['company_revenue'];
        $company_employee = $indRow['company_employee'];
        $company_industry = $indRow['company_industry'];
        $ind_group_id = $indRow['ind_group_id'];
        $industry_id = $indRow['industry_id'];
        $city = $indRow['city'];
        $state = $indRow['state'];
        $country = $indRow['country'];
        $address = $indRow['address'];
        $address2 = $indRow['address2'];
        $zip_code = $indRow['zip_code'];
        
        $about_person = $indRow['about_person'];
        $about_company = $indRow['about_company'];
        $effective_date = $indRow['effective_date'];
        $headline = $indRow['headline'];
        $full_body = $indRow['full_body'];
        $what_happened = $indRow['what_happened'];
        
        $insert_q = "";
        $insert_q = "INSERT into hre_search_data(company_id,company_name,company_website,company_logo,personal_id,first_name,middle_name,last_name,email,phone,personal_image,move_id,title,level,level_order,source_id,movement_type,add_date,announce_date,more_link,company_revenue,company_employee,company_industry,ind_group_id,industry_id,city,state,country,zip_code,address,address2,about_person,about_company,effective_date,headline,full_body,what_happened) values('$company_id','$company_name','$company_website','$company_logo','$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$move_id','$title','$level','$level_order','$source_id','$movement_type','$add_date','$announce_date','$more_link','$company_revenue','$company_employee','$company_industry','$ind_group_id','$industry_id','$city','$state','$country','$zip_code','$address','$address2','$about_person','$about_company','$effective_date','$headline','$full_body','$what_happened')";

        //if($personal_id == '68661')
        //    echo "<br><br>Ins Q: ".$insert_q;
        //echo "<br><br>insert_q: ".$insert_q;

        $main_ins = mysql_query($insert_q);
    }
}

$speaking_query = "SELECT pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.email,pm.phone,pm.personal_image as personal_image,ps.speaking_id,ps.speaking_link,ps.event,ps.event_date,ps.topic,ps.add_date,ps.role as role
        from hre_personal_master as pm,
        hre_personal_speaking as ps 
        where pm.personal_id = ps.personal_id";

// beoing company =  and pm.personal_id in (199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098)
//echo "<br>speaking_query: ".$speaking_query;

$speaking_res = mysql_query($speaking_query);        

while($speakingRow = mysql_fetch_array($speaking_res))
{
    $personal_id = $speakingRow['personal_id'];
    
    $this_company_row = array();
    $this_company_id = "";
    $this_company_name = "";
    $this_company_website = "";
    
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website FROM hre_company_master as cm,hre_personal_master as pm,hre_movement_master as mm where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and pm.personal_id = $personal_id";
    //echo "<br><br>getting_company_query: ".$getting_company_query;
    $comp_res = mysql_query($getting_company_query);        
    $comp_rows = mysql_num_rows($comp_res);
    //echo "<br><br>comp_rows: ".$comp_rows;
    if($comp_rows > 0)
    {
        $this_company_row = mysql_fetch_array($comp_res);
        $this_company_id = $this_company_row['company_id'];
        $this_company_name = $this_company_row['company_name'];
        $this_company_website = $this_company_row['company_website'];
    }    
    
    
    $first_name = $speakingRow['first_name'];
    $middle_name = $speakingRow['middle_name'];
    $last_name = $speakingRow['last_name'];
    $personal_image = $speakingRow['personal_image'];
    $personal_email = $speakingRow['email'];
    $personal_phone = $speakingRow['phone'];
    
    $add_date = $speakingRow['add_date'];
    $speaking_id = $speakingRow['speaking_id'];
    $speaking_link = $speakingRow['speaking_link'];
    $event = $speakingRow['event'];
    $event_date = $speakingRow['event_date'];
    $role = $speakingRow['role'];
    $topic = $speakingRow['topic'];
    
    $insert_speaking_q = "";
    $insert_speaking_q = "INSERT into hre_search_data(personal_id,first_name,middle_name,last_name,email,phone,personal_image,speaking_id,speaking_link,event,event_date,topic,add_date,record_type,company_id,company_name,company_website,role) values('$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$speaking_id','$speaking_link','$event','$event_date','$topic','$add_date','speaking','$this_company_id','$this_company_name','$this_company_website','$role')";
    
    //echo "<br><br>insert_q: ".$insert_speaking_q;
    //echo "<br>insert_speaking_q: ".$insert_speaking_q;
    $main_speaking = mysql_query($insert_speaking_q);
}

?>

