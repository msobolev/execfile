<?php

function file_get_contents_curl($url) {
      $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);       

    $data = curl_exec($ch);
    curl_close($ch);
      echo $data;
}
$html = file_get_contents_curl('http://www.crunchbase.com/organization/magic-leap', FILE_USE_INCLUDE_PATH);

echo "<br>html: ".$html;


preg_match("/<title>(.+)<\/title>/siU", $html, $matches);
echo "<br><br>Title : ".$title = $matches[1];

die();



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// http://www.eremedia.com/events/sourcecon/spring/
// http://www.prweb.com/releases/2015/04/prweb12628461.htm?utm_content=buffer5ebf3&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer


require_once('simple_html_dom.php');
require_once('url_to_absolute.php');
//$html = file_get_html('http://www.prweb.com/releases/2015/04/prweb12628461.htm?utm_content=buffer5ebf3&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer');

//$html = file_get_html('http://www.eremedia.com/events/sourcecon/spring/?utm_content=buffer9fbb3&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer');

//$html = file_get_html('http://www.hreonline.com/HRE/view/story.jhtml?id=534358465');

//$html = file_get_html('http://www.workforce.com/articles/21624-the-jerk-at-work-could-be-a-perk');

//$html = file_get_html('http://dailyfunder.com/magazine/march-april-2014-issue-2/');

//$html = file_get_html('http://www.crunchbase.com/organization/magic-leap');


$userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13';

$base = 'http://www.crunchbase.com/organization/magic-leap';
$curl = curl_init();

curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);

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




//get all category links
/*
foreach($html_base->find('a') as $element) {
    echo "<pre>";
    print_r( $element->href );
    echo "</pre>";
}

$html_base->clear(); 
unset($html_base);
*/


//die();
/////////////
/////// below is working
//////////////


//echo "<pre>html: ";   print_r($html);   echo "</pre>";

//$html = file_get_html('http://wvutoday.wvu.edu/n/2015/09/23/four-to-be-inducted-into-wvu-business-school-s-roll-of-distinguished-alumni');

//$url = "http://www.streetinsider.com/Press+Releases/CVS+Health+Receives+Best+Employers+for+Healthy+Lifestyles%C2%AE+Award+from+National+Business+Group+on+Health/10659199.html";

//$url = "https://www.conference-board.org/conferences/conferencedetail.cfm?conferenceid=2782";

//$url = "https://www.crunchbase.com/organization/magic-leap";

//$html = file_get_html($url);

echo "<br>URL: ".$url;
//echo "<br>HTML: ".$html;
preg_match("/<title>(.+)<\/title>/siU", $html, $matches);
echo "<br><br>Title : ".$title = $matches[1];

//get and display what you need:
//echo "Title : ".$title = $nodes->item(0)->nodeValue;


//echo "<br><br><br>Content: ".file_get_html('http://www.eremedia.com/events/sourcecon/spring/')->plaintext; 
echo "<br><br><br>Content: ".$html->plaintext; 

$plain_array = str_split($html->plaintext);
echo "<pre>plain_array: ";   print_r($plain_array);   echo "</pre>";



//echo "<br><br><br>";




/*
$img_c = 0;
$first_img = "";
foreach($html->find('img') as $element) 
{
    //if($img_c == 0)
    //{    
        $first_img =  $element->src;
        $img_c++;
        echo "<br>".$first_img;
    //}    
}
*/



foreach($html->find('img') as $element) 
{
    echo "<br><br><br>Element src: ".$element->src;
    echo "<br>".url_to_absolute($url, $element->src), "\n";
}




 echo "<br><br><br>Image: ".$first_img;


/*
foreach($html->find('h1') as $element) 
{
    echo $element->src, "<br>";
}
*/

?>