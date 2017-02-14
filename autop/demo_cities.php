<?php
// http://af-design.com/blog/2010/05/12/using-jquery-uis-autocomplete-to-populate-a-form/


// Data could be pulled from a DB or other source
/*
$cities = array(
	array('city'=>'New York'),
	array('city'=>'Los Angeles'),
        array('city'=>'Los Vegas'),
	array('city'=>'Chicago'),
	array('city'=>'Houston'),
	array('city'=>'Phoenix'),
	array('city'=>'Philadelphia'),
	array('city'=>'San Antonio'),
	
);
 
*/

//$cities = array('New York','Los Angeles','Los Vegas','Houston');

$cities[1] = "New York";
$cities[2] = "Los Angeles";
$cities[3] = "Los Vegas";
$cities[4] = "Houston";
$cities[5] = "Lahore1";
$cities[6] = "Lahore2";



// Cleaning up the term
$term = trim(strip_tags($_GET['term']));
// Rudimentary search
$matches = array();
foreach($cities as $id=>$city)
{
    //echo "<br>City:".$city;
    
    if(stripos($city, $term) !== false)
    {
        // Add the necessary "value" and "label" fields and append to result set
        $city['value'] = $city;
        //$city['label'] = "{$city['city']}, {$city['state']} {$city['zip']}";
        $city['label'] = "{$city} ";
        $matches[] = $city;
    }
}
// Truncate, encode and return the results
$matches = array_slice($matches, 0, 5);
print json_encode($matches);


?>