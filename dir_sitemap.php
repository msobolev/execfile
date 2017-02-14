<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//Newly create main Sitemap

$added=date('Y-m-d');
//$url_query = "select page_name,sitemap_order from " .TABLE_META_TAG ." where sitemap_order <>'' order by sitemap_order";
//$url_result = com_db_query($url_query);

// execfile starts
require('functions_sitemap.php');
require('config.php');

com_db_connect() or die('Unable to connect to database server!');
$data = array();

$limit = "";
if(isset($_GET['limit']) && $_GET['limit'] != '')
    $limit = $_GET['limit'];
$data = get_all_data('','movements',$limit);  // speaking
$base_url = "http://hr.execfile.com/";
//execfile ends





//if($url_result){
	$file_name = 'sitemapallpage_appointment_'.$limit.'.xml';
	$sitemap_name = 'sitemapallpage_appointment_'.$limit.'.xml';
	$fp=fopen($file_name,"w");
	$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
				'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
	
        /*
        $tot_url .= "<url>
					<loc>".HTTP_SITE_URL."</loc>
					<lastmod>".date('Y-m-d')."</lastmod>
					<changefreq>daily</changefreq>
					<priority>0.0</priority>
				 </url>\n";
          
         */
	//while($url_row = com_db_fetch_array($url_result))
        foreach($data as $ind=>$data_arr)
        {
            $detail_page_url = create_url($data_arr['first_name'],$data_arr['last_name'],$data_arr['title'],$data_arr['company_name'],$data_arr['id'],'speaking');
            
            
            $tot_url .= "<url>
                <loc>".$detail_page_url."</loc>
                <lastmod>".date('Y-m-d')."</lastmod>
                <changefreq>daily</changefreq>
        
         </url>\n";
	}
			
	$tot_url .= '</urlset>';
	fwrite($fp, $tot_url);
	fclose($fp);
//}
			
$tot_url .= '</sitemapindex>';
fwrite($fp, $tot_url);
fclose($fp);
	
//mysql_query("update ".TABLE_CRONJOB_INFO." set end_date_time='".date("Y-m-d : H:i:s")."' where id='".$update_id."'");

?>