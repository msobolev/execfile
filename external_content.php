<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once("simple_html_dom.php");

//use curl to get html content
function getHTML($url,$timeout)
{
       $ch = curl_init($url); // initialize curl with given url
       curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]); // set  useragent
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // write the response to a variable
       curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects if any
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout); // max. seconds to execute
       curl_setopt($ch, CURLOPT_FAILONERROR, 1); // stop when it encounters an error
       return @curl_exec($ch);
}
$html=getHTML("http://www.eremedia.com/events/sourcecon/spring/?utm_content=buffer9fbb3&utm_medium=social&utm_source=facebook.com&utm_campaign=buffer",10);
// Find all images on webpage

//echo "<pre>HTML: ";   print_r($html);   echo "</pre>";


foreach($html->find("img") as $element)
{    
    //echo $element->src . '<br>';
}

die("FA4");


// Find all links on webpage
foreach($html->find("a") as $element)
echo $element->href . '<br>';

?>