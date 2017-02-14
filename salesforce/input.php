<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// https://www.hrexecsonthemove.com/salesforce/input.php?first_name=haf&last_name=fiz&company_name=iaa
// https://www.hrexecsonthemove.com/salesforce/input.php?first_name=haf&last_name=fiz

$fn = $_GET['first_name'];
$ln = $_GET['last_name'];
//$fn = $_GET['company_name'];

?>


<a href="oauth.php?fname=<?=$fn?>&lname=<?=$ln?>">Click to add data in salesforce account as lead</a>