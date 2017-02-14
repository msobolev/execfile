<?php
require_once 'config.php';

$_SESSION['sf_fn'] = $_GET['fname'];
$_SESSION['sf_ln'] = $_GET['lname'];

$company_name = "";
$title = "";
$email = "";
        
if(isset($_GET['company_name']) && $_GET['company_name'] != '')
    $company_name = $_GET['company_name'];

if(isset($_GET['title']) && $_GET['title'] != '')
{    
    $title = $_GET['title'];
    $title = str_replace("&","and",$title);
}    

if(isset($_GET['email']) && $_GET['email'] != '')
    $email = $_GET['email'];

if(isset($_GET['phone']) && $_GET['phone'] != '')
    $phone = $_GET['phone'];


//echo "<pre>SESSION: ";   print_r($_SESSION);   echo "</pre>";
//die();


//$state .= $_GET['fname'].":".$_GET['lname']; // Working
$state .= $_GET['fname'].":".$_GET['lname'].":".$company_name.":".$title.":".$email.":".$phone;
//$state .= "&sf_fn=".$_GET['fname']."&sf_ln=".$_GET['lname'];

//echo "<br>state: ".$state;
//die();

$auth_url = LOGIN_URI
        . "/services/oauth2/authorize?response_type=code&client_id="
        . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT_URI)."&state=".$state;

//echo "<br>auth_url: ".$auth_url; die();

header('Location: ' . $auth_url);
?>

