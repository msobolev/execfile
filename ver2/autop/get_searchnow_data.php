<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include("../config.php");
include("../functions.php");

$companies = get_companies();

echo "<pre>companies: ";   print_r($companies);   echo "</pre>";

$cities = array("New York","Los Angeles","Los Vegas","Houston");


echo json_encode($cities);

?>