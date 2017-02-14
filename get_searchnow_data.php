<?php
session_start();
include("config.php");
include("functions.php");

$companies = get_companies();

//$companies = array('New York','Los Angeles','Los Vegas','Houston');

//echo "<pre>companies: ";   print_r($companies);   echo "</pre>";
// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
// Rudimentary search
$matches = array();
//foreach($cities as $city)

$ind = 0;

foreach($companies as $id=>$city)
{
    //echo "<br>city:".$city;
    if(stripos($city, $term) !== false)
    {
        // Add the necessary "value" and "label" fields and append to result set
        $city['value'] = $city;
        //$city['label'] = "{$city['city']}, {$city['state']} {$city['zip']}";
        $city['label'] = "{$city} ";
        
        
        
        
        $matches[$ind]['value'] = $id;
        $matches[$ind]['label'] = $city;
        $ind++;
    }
}

//echo "<pre>matches: ";   print_r($matches);   echo "</pre>";

// Truncate, encode and return the results
$matches = array_slice($matches, 0, 10);

//echo "<pre>matches: ";   print_r($matches);   echo "</pre>";
echo json_encode($matches);
//echo json_encode($cities);

?>