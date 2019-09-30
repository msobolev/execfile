<?php
//set_time_limit(-1);

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

include("config.php");

$site = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
mysql_select_db(HR_DATABASE,$site) or die ("ERROR: Database not found ");
 

if(1 == 1)
{    

//$del_sp_q = "DELETE from hre_search_data where record_type LIKE 'speaking'";
//$del_sp_res = mysql_query($del_sp_q);  
//echo "<br>HERE";
//if(1 == 1)
//{
    $del_q = "DELETE from hre_search_data";
    $del_res = mysql_query($del_q);  
    
    
    
    
    /*
    $main_query = "select cm.company_logo,cm.company_id as company_id, cm.company_name as company_name,cm.company_website as company_website,pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.personal_image as personal_image,mm.move_id as move_id,mm.title as title,
    pm.level as level, pm.level_order as level_order,pm.email,pm.phone,pm.about_person,cm.about_company,
    mm.headline,mm.source_id,mm.movement_type,mm.add_date,mm.announce_date,mm.more_link,mm.effective_date,mm.full_body,mm.what_happened,
    cm.company_revenue,cm.company_employee,cm.company_industry,cm.ind_group_id,cm.industry_id,cm.city,cm.state,cm.country,cm.zip_code,cm.address,cm.address2
    hre_company_master as cm,
    hre_movement_master as mm,
    hre_management_change as m,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    revenue_size as r,
    hre_employee_size as e
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id 
    and mm.movement_type=m.id and mm.source_id=so.id
     cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id
    group by personal_id";
    */
    
if(1 == 1)
{    
    $main_query = "select cm.company_logo,cm.company_id as company_id, cm.company_name as company_name,cm.company_website as company_website,pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.personal_image as personal_image,mm.move_id as move_id,mm.title as title,
    pm.level as level, pm.level_order as level_order,pm.email,pm.phone,pm.about_person,cm.about_company,
    mm.headline,mm.source_id,mm.movement_type,mm.add_date,mm.announce_date,mm.more_link,mm.effective_date,mm.full_body,mm.what_happened,
    cm.company_revenue,cm.company_employee,cm.company_industry,cm.ind_group_id,cm.industry_id,cm.city,cm.state,cm.country,cm.zip_code,cm.address,cm.address2,cm.company_urls,pm.linkedin_link,pm.twitter_link,mm.status as move_status
    from hre_personal_master as pm,
    hre_company_master as cm,
    hre_movement_master as mm
    where cm.company_id = mm.company_id and pm.personal_id = mm.personal_id
    ";
    //group by personal_id
    //echo "<br>main_query: ".$main_query;
    
    $main_res = mysql_query($main_query);        

    //echo "<br>Before while";
    while($indRow = mysql_fetch_array($main_res))
    {
        //echo "<br>within while";
        $company_id = $indRow['company_id'];
        $company_name = mysql_real_escape_string($indRow['company_name']);
        $company_website = $indRow['company_website'];
        $company_logo = $indRow['company_logo'];
        $personal_id = $indRow['personal_id'];
        $first_name = mysql_real_escape_string($indRow['first_name']);
        $middle_name = mysql_real_escape_string($indRow['middle_name']);
        $last_name = mysql_real_escape_string($indRow['last_name']);
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
        $zip_code = mysql_real_escape_string($indRow['zip_code']);
        
        $about_person = mysql_real_escape_string($indRow['about_person']);
        $about_company = mysql_real_escape_string($indRow['about_company']);
        $effective_date = $indRow['effective_date'];
        $headline = $indRow['headline'];
        $full_body = $indRow['full_body'];
        $what_happened = mysql_real_escape_string($indRow['what_happened']);
        
        $company_urls = $indRow['company_urls'];
        
        $linkedin_link = $indRow['linkedin_link'];
        $twitter_link = $indRow['twitter_link'];
        
        $move_status = $indRow['move_status'];
        
        
        $insert_q = "";
        $insert_q = "INSERT into hre_search_data(company_id,company_name,company_website,company_logo,personal_id,first_name,middle_name,last_name,email,phone,personal_image,move_id,title,level,level_order,source_id,movement_type,add_date,announce_date,more_link,company_revenue,company_employee,company_industry,ind_group_id,industry_id,city,state,country,zip_code,address,address2,about_person,about_company,effective_date,headline,full_body,what_happened,company_urls,linkedin_link,twitter_link,move_status) values('$company_id','$company_name','$company_website','$company_logo','$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$move_id','$title','$level','$level_order','$source_id','$movement_type','$add_date','$announce_date','$more_link','$company_revenue','$company_employee','$company_industry','$ind_group_id','$industry_id','$city','$state','$country','$zip_code','$address','$address2','$about_person','$about_company','$effective_date','$headline','$full_body','$what_happened','$company_urls','$linkedin_link','$twitter_link','$move_status')";

        //if($personal_id == '68661')
        //    echo "<br><br>Ins Q: ".$insert_q;
        //echo "<br><br>insert_q: ".$insert_q;

        $main_ins = mysql_query($insert_q);
    }
//}

}
//die();


$speaking_query = "SELECT pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.email,pm.phone,pm.personal_image as personal_image,ps.speaking_id,ps.speaking_link,ps.event,ps.event_date,ps.topic,ps.add_date,ps.role as role,pm.linkedin_link,pm.twitter_link,ps.event_id
        from hre_personal_master as pm,
        hre_personal_speaking as ps 
        where pm.personal_id = ps.personal_id";

// beoing company =  and pm.personal_id in (199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098)
//echo "<br>speaking_query: ".$speaking_query;

$speaking_res = mysql_query($speaking_query);        
$speaking_rows = mysql_num_rows($speaking_res);
//echo "<br><br>speaking_rows: ".$speaking_rows;
//echo "<br>HERE 2";
while($speakingRow = mysql_fetch_array($speaking_res))
{
    $personal_id = $speakingRow['personal_id'];
    
    $this_company_row = array();
    $this_company_id = "";
    $this_company_name = "";
    $this_company_website = "";
    
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website,
    m.name as mgt_change_name,so.source as source_name,s.short_name as state_name,cm.state as state,cm.address,cm.address2,cm.city,cm.zip_code,
    cm.industry_id as industry_id,i.title as industry_name,r.name as revenue_name,e.name as employee_size_name,mm.title as title,
    cm.company_revenue,cm.company_employee
    FROM hre_company_master as cm,
    hre_personal_master as pm,
    hre_movement_master as mm, 
    hre_management_change as m,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    hre_revenue_size as r,
    hre_employee_size as e
    where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and
    mm.movement_type=m.id and mm.source_id=so.id and
    cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id
    and pm.personal_id = $personal_id";
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
        
        $this_company_address = $this_company_row['address'];
        $this_company_address2 = $this_company_row['address2'];
        $this_company_city = $this_company_row['city'];
        $this_company_zip_code = $this_company_row['zip_code'];
        
        $mgt_change_name = $this_company_row['mgt_change_name'];
        $source_name = $this_company_row['source_name'];
        $state_name = $this_company_row['state_name'];
        $industry_name = $this_company_row['industry_name'];
        $revenue_name = $this_company_row['revenue_name'];
        $employee_size_name = $this_company_row['employee_size_name'];
        
        $title = $this_company_row['title'];
        $industry_id = $this_company_row['industry_id'];
        
        $state = $this_company_row['state'];
        
        $company_revenue = $this_company_row['company_revenue'];
        $company_employee = $this_company_row['company_employee'];
        
    }    
    //echo "<br>this_company_id: ".$this_company_id;
    //echo "<br>this_company_name: ".$this_company_name;
    
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
    
    $linkedin_link = $speakingRow['linkedin_link'];
    $twitter_link = $speakingRow['twitter_link'];
    $event_id = $speakingRow['event_id'];
    
    
    $insert_speaking_q = "";
    $insert_speaking_q = "INSERT into hre_search_data(personal_id,first_name,middle_name,last_name,email,phone,personal_image,speaking_id,speaking_link,event,event_date,topic,add_date,record_type,company_id,company_name,company_website,role,mgt_change_name,source_name,state_name,industry_name,revenue_name,employee_size_name,address,address2,city,zip_code,title,state,industry_id,company_revenue,company_employee,linkedin_link,twitter_link,event_id) values('$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$speaking_id','$speaking_link','$event','$event_date','$topic','$add_date','speaking','$this_company_id','$this_company_name','$this_company_website','$role','$mgt_change_name','$source_name','$state_name','$industry_name','$revenue_name','$employee_size_name','$this_company_address','$this_company_address2','$this_company_city','$this_company_zip_code','$title','$state','$industry_id','$company_revenue','$company_employee','$linkedin_link','$twitter_link','$event_id')";
    
    //echo "<br><br>insert_q: ".$insert_speaking_q;
    //echo "<br>insert_speaking_q: ".$insert_speaking_q;
    $main_speaking = mysql_query($insert_speaking_q);
}



$del_q_media = "DELETE from hre_search_data_media";
    $del_res_media = mysql_query($del_q_media);  
    


$media_query = "SELECT pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.email,pm.phone,pm.personal_image as personal_image,pa.mm_id,pa.media_link,pa.quote,pa.pub_date,pa.publication,pa.add_date,pm.linkedin_link,pm.twitter_link
        from hre_personal_master as pm,
        hre_personal_media_mention as pa 
        where pm.personal_id = pa.personal_id";

// beoing company =  and pm.personal_id in (199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098)
//echo "<br>media_query: ".$media_query;

$media_res = mysql_query($media_query);        
$media_rows = mysql_num_rows($media_res);
//echo "<br><br>media_rows: ".$media_rows;
//echo "<br>HERE 2";
while($mediaRow = mysql_fetch_array($media_res))
{
    $personal_id = $mediaRow['personal_id'];
    
    $this_company_row = array();
    $this_company_id = "";
    $this_company_name = "";
    $this_company_website = "";
    
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website,
    m.name as mgt_change_name,so.source as source_name,s.short_name as state_name,cm.state as state,cm.address,cm.address2,cm.city,cm.zip_code,
    cm.industry_id as industry_id,i.title as industry_name,r.name as revenue_name,e.name as employee_size_name,mm.title as title,cm.company_revenue,cm.company_employee
    FROM hre_company_master as cm,
    hre_personal_master as pm,
    hre_movement_master as mm, 
    hre_management_change as m,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    hre_revenue_size as r,
    hre_employee_size as e
    where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and
    mm.movement_type=m.id and mm.source_id=so.id and
    cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id
    and pm.personal_id = $personal_id";
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
        
        $this_company_address = $this_company_row['address'];
        $this_company_address2 = $this_company_row['address2'];
        $this_company_city = $this_company_row['city'];
        $this_company_zip_code = $this_company_row['zip_code'];
        
        $mgt_change_name = $this_company_row['mgt_change_name'];
        $source_name = $this_company_row['source_name'];
        $state_name = $this_company_row['state_name'];
        $industry_name = $this_company_row['industry_name'];
        $revenue_name = $this_company_row['revenue_name'];
        $employee_size_name = $this_company_row['employee_size_name'];
        
        $title = $this_company_row['title'];
        $industry_id = $this_company_row['industry_id'];
        
        $state = $this_company_row['state'];
        
        $company_revenue = $this_company_row['company_revenue'];
        $company_employee = $this_company_row['company_employee'];
    }    
    
    
    $first_name = $mediaRow['first_name'];
    $middle_name = $mediaRow['middle_name'];
    $last_name = $mediaRow['last_name'];
    $personal_image = $mediaRow['personal_image'];
    $personal_email = $mediaRow['email'];
    $personal_phone = $mediaRow['phone'];
    
    $add_date = $mediaRow['add_date'];
    $mm_id = $mediaRow['mm_id'];
    $media_link = $mediaRow['media_link'];
    $publication = $mediaRow['publication'];
    $quote = $mediaRow['quote'];
    $pub_date = $mediaRow['pub_date'];
    //$role = $mediaRow['role'];
    //$topic = $mediaRow['topic'];
    
    $linkedin_link = $mediaRow['linkedin_link'];
    $twitter_link = $mediaRow['twitter_link'];
    
    
    $insert_media_q = "";
    $insert_media_q = "INSERT into hre_search_data_media(personal_id,first_name,middle_name,last_name,email,phone,personal_image,mm_id,media_link,publication,pub_date,quote,add_date,record_type,company_id,company_name,company_website,mgt_change_name,source_name,state_name,industry_name,revenue_name,employee_size_name,address,address2,city,zip_code,title,state,industry_id,company_revenue,company_employee,linkedin_link,twitter_link) values('$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$mm_id','$media_link','$publication','$pub_date','$quote','$add_date','media','$this_company_id','$this_company_name','$this_company_website','$mgt_change_name','$source_name','$state_name','$industry_name','$revenue_name','$employee_size_name','$this_company_address','$this_company_address2','$this_company_city','$this_company_zip_code','$title','$state','$industry_id','$company_revenue','$company_employee','$linkedin_link','$twitter_link')";
    
    //echo "<br><br>insert_q: ".$insert_media_q;
    //echo "<br>insert_speaking_q: ".$insert_speaking_q;
    $main_media = mysql_query($insert_media_q);
}



$del_q_awards = "DELETE from hre_search_data_awards";
$del_res_awards = mysql_query($del_q_awards);  
    
    
  
    
$awards_query = "SELECT pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,pm.email,pm.phone,pm.personal_image as personal_image,pa.awards_id,pa.awards_link,pa.awards_title,pa.awards_date,pa.awards_given_by,pa.add_date,pm.linkedin_link,pm.twitter_link
        from hre_personal_master as pm,
        hre_personal_awards as pa 
        where pm.personal_id = pa.personal_id";

// beoing company =  and pm.personal_id in (199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098)
//echo "<br>awards_query: ".$awards_query;

$awards_res = mysql_query($awards_query);        
$awards_rows = mysql_num_rows($awards_res);
//echo "<br><br>media_rows: ".$media_rows;
//echo "<br>HERE 2";
while($awardsRow = mysql_fetch_array($awards_res))
{
    $personal_id = $awardsRow['personal_id'];
    
    $this_company_row = array();
    $this_company_id = "";
    $this_company_name = "";
    $this_company_website = "";
    
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website,
    m.name as mgt_change_name,so.source as source_name,s.short_name as state_name,cm.state as state,cm.address,cm.address2,cm.city,cm.zip_code,
    cm.industry_id as industry_id,i.title as industry_name,r.name as revenue_name,e.name as employee_size_name,mm.title as title,cm.company_revenue,cm.company_employee
    FROM hre_company_master as cm,
    hre_personal_master as pm,
    hre_movement_master as mm, 
    hre_management_change as m,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    hre_revenue_size as r,
    hre_employee_size as e
    where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and
    mm.movement_type=m.id and mm.source_id=so.id and
    cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id
    and pm.personal_id = $personal_id order by mm.effective_date limit 0,1";
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
        
        $this_company_address = $this_company_row['address'];
        $this_company_address2 = $this_company_row['address2'];
        $this_company_city = $this_company_row['city'];
        $this_company_zip_code = $this_company_row['zip_code'];
        
        $mgt_change_name = $this_company_row['mgt_change_name'];
        $source_name = $this_company_row['source_name'];
        $state_name = $this_company_row['state_name'];
        $industry_name = $this_company_row['industry_name'];
        $revenue_name = $this_company_row['revenue_name'];
        $employee_size_name = $this_company_row['employee_size_name'];
        
        $title = $this_company_row['title'];
        $industry_id = $this_company_row['industry_id'];
        
        $state = $this_company_row['state'];
        
        $company_revenue = $this_company_row['company_revenue'];
        $company_employee = $this_company_row['company_employee'];
    }    
    
    
    $first_name = $awardsRow['first_name'];
    $middle_name = $awardsRow['middle_name'];
    $last_name = $awardsRow['last_name'];
    $personal_image = $awardsRow['personal_image'];
    $personal_email = $awardsRow['email'];
    $personal_phone = $awardsRow['phone'];
    
    $add_date = $awardsRow['add_date'];
    $awards_id = $awardsRow['awards_id'];
    $awards_link = $awardsRow['awards_link'];
    $awards_title = $awardsRow['awards_title'];
    $awards_given_by = $awardsRow['awards_given_by'];
    $awards_date = $awardsRow['awards_date'];
    //$role = $mediaRow['role'];
    //$topic = $mediaRow['topic'];
    
    $linkedin_link = $awardsRow['linkedin_link'];
    $twitter_link = $awardsRow['twitter_link'];
    
    $insert_awards_q = "";
    $insert_awards_q = "INSERT into hre_search_data_awards(personal_id,first_name,middle_name,last_name,email,phone,personal_image,awards_id,awards_link,awards_title,awards_date,awards_given_by,add_date,record_type,company_id,company_name,company_website,mgt_change_name,source_name,state_name,industry_name,revenue_name,employee_size_name,address,address2,city,zip_code,title,state,industry_id,company_revenue,company_employee,linkedin_link,twitter_link) values('$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$awards_id','$awards_link','$awards_title','$awards_date','$awards_given_by','$add_date','awards','$this_company_id','$this_company_name','$this_company_website','$mgt_change_name','$source_name','$state_name','$industry_name','$revenue_name','$employee_size_name','$this_company_address','$this_company_address2','$this_company_city','$this_company_zip_code','$title','$state','$industry_id','$company_revenue','$company_employee','$linkedin_link','$twitter_link')";
    
    //echo "<br><br>insert_q: ".$insert_media_q;
    //echo "<br>insert_speaking_q: ".$insert_speaking_q;
    $main_awards = mysql_query($insert_awards_q);
}




}



if(1 == 1)
{    
    
    $del_q_fundings = "DELETE from hre_search_data_fundings";
    $del_res_fundings = mysql_query($del_q_fundings);
    
    
    
    //$del_q_fundings = "DELETE from hre_search_data_fundings";
    //$del_res_fundings = mysql_query($del_q_fundings);
    //echo "<br>After deleting";
    
$funding_query = "SELECT cm.company_id,cm.company_logo,pm.personal_id as personal_id, pm.first_name, pm.middle_name,pm.last_name,
    pm.email,pm.phone,pm.personal_image as personal_image,cf.funding_id,cf.funding_source,
    cf.funding_amount,cf.funding_date,cf.funding_add_date,mm.title,pm.linkedin_link,pm.twitter_link
        from hre_personal_master as pm,
        hre_movement_master as mm,
        hre_company_master as cm,
        hre_company_funding as cf
        where mm.personal_id = pm.personal_id and cm.company_id = mm.company_id
        and cm.company_id = cf.company_id and pm.add_to_funding = 1";

// beoing company =  and pm.personal_id in (199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098)
//echo "<br>funding_query: ".$funding_query;

$fundings_res = mysql_query($funding_query);        
$fundings_rows = mysql_num_rows($fundings_res);
//echo "<br><br>media_rows: ".$media_rows;
//echo "<br>HERE 2";
while($fundingsRow = mysql_fetch_array($fundings_res))
{
    $company_id = $fundingsRow['company_id'];
    
    $this_company_row = array();
    $this_company_id = "";
    $this_company_name = "";
    $this_company_website = "";
    
    
    /*
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website,
    m.name as mgt_change_name,so.source as source_name,s.short_name as state_name,cm.state as state,cm.address,cm.address2,cm.city,cm.zip_code,
    cm.industry_id as industry_id,i.title as industry_name,r.name as revenue_name,e.name as employee_size_name,mm.title as title
    FROM hre_company_master as cm,
    hre_personal_master as pm,
    hre_movement_master as mm, 
    hre_management_change as m,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    hre_revenue_size as r,
    hre_employee_size as e
    where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id and
    mm.movement_type=m.id and mm.source_id=so.id and
    cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and cm.company_revenue=r.id and cm.company_employee=e.id
    and cm.company_id = $company_id";
      
     */
    
    $getting_company_query = "SELECT cm.company_id,cm.company_name,cm.company_website,cm.company_logo,
    so.source as source_name,s.short_name as state_name,cm.state as state,cm.address,cm.address2,cm.city,cm.zip_code,
    cm.industry_id as industry_id,i.title as industry_name,r.name as revenue_name,e.name as employee_size_name,cm.company_employee,cm.company_revenue
    FROM hre_company_master as cm,
    hre_source as so,
    hre_state as s,
    hre_countries as ct,
    hre_industry as i,
    hre_revenue_size as r,
    hre_employee_size as e
    where cm.state=s.state_id and cm.country=ct.countries_id and cm.industry_id=i.industry_id and 
    cm.company_revenue=r.id and cm.company_employee=e.id
    and cm.company_id = $company_id";
    
    //echo "<br><br><br><br>getting_company_query: ".$getting_company_query;
    $comp_res = mysql_query($getting_company_query);        
    $comp_rows = mysql_num_rows($comp_res);
    //echo "<br><br>comp_rows: ".$comp_rows;
    if($comp_rows > 0)
    {
        $this_company_row = mysql_fetch_array($comp_res);
        $this_company_id = $this_company_row['company_id'];
        $this_company_name = $this_company_row['company_name'];
        $this_company_website = $this_company_row['company_website'];
        $this_company_logo = $this_company_row['company_logo'];
        
        $this_company_address = $this_company_row['address'];
        $this_company_address2 = $this_company_row['address2'];
        $this_company_city = $this_company_row['city'];
        $this_company_zip_code = $this_company_row['zip_code'];
        
        $mgt_change_name = $this_company_row['mgt_change_name'];
        $source_name = $this_company_row['source_name'];
        $state_name = $this_company_row['state_name'];
        $industry_name = $this_company_row['industry_name'];
        $revenue_name = $this_company_row['revenue_name'];
        $employee_size_name = $this_company_row['employee_size_name'];
        
        $title = $this_company_row['title'];
        $industry_id = $this_company_row['industry_id'];
        
        $state = $this_company_row['state'];
        
        $company_employee = $this_company_row['company_employee'];
        $company_revenue = $this_company_row['company_revenue'];
        
        //echo "<br><br>company_employee: ".$company_employee;
    }    
    
    
    $personal_id = $fundingsRow['personal_id'];
    $first_name = $fundingsRow['first_name'];
    $middle_name = $fundingsRow['middle_name'];
    $last_name = $fundingsRow['last_name'];
    $personal_image = $fundingsRow['personal_image'];
    $personal_email = $fundingsRow['email'];
    $personal_phone = $fundingsRow['phone'];
    
    $title = $fundingsRow['title'];
    
    $add_date = $fundingsRow['add_date'];
    $funding_id = $fundingsRow['funding_id'];
    $funding_source = $fundingsRow['funding_source'];
    $funding_amount = $fundingsRow['funding_amount'];
    $funding_date = $fundingsRow['funding_date'];
    $funding_add_date = $fundingsRow['funding_add_date'];
    
    $linkedin_link = $fundingsRow['linkedin_link'];
    $twitter_link = $fundingsRow['twitter_link'];
    
    
    //$role = $mediaRow['role'];
    //$topic = $mediaRow['topic'];
    
    
    $insert_fundings_q = "";
    $insert_fundings_q = "INSERT into hre_search_data_fundings(personal_id,first_name,middle_name,last_name,email,phone,personal_image,funding_id,funding_source,funding_amount,funding_date,funding_add_date,record_type,company_id,company_name,company_website,company_logo,mgt_change_name,source_name,state_name,industry_name,revenue_name,employee_size_name,address,address2,city,zip_code,title,state,industry_id,company_employee,company_revenue,linkedin_link,twitter_link) values('$personal_id','$first_name','$middle_name','$last_name','$personal_email','$personal_phone','$personal_image','$funding_id','$funding_source','$funding_amount','$funding_date','$funding_add_date','fundings','$this_company_id','$this_company_name','$this_company_website','$this_company_logo','$mgt_change_name','$source_name','$state_name','$industry_name','$revenue_name','$employee_size_name','$this_company_address','$this_company_address2','$this_company_city','$this_company_zip_code','$title','$state','$industry_id','$company_employee','$company_revenue','$linkedin_link','$twitter_link')";
    
    //echo "<br>insert_q: ".$insert_fundings_q;
    //echo "<br>insert_speaking_q: ".$insert_speaking_q;
    $main_fundings = mysql_query($insert_fundings_q);
}


}


//echo "<br>HERE 3";
?>

