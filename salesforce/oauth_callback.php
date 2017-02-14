<?php
require_once 'config.php';

session_start();

$token_url = LOGIN_URI . "/services/oauth2/token";

$code = $_GET['code'];

$lead_data_arr = explode(":",$_GET['state']);
$_SESSION['sf_fn'] = urldecode($lead_data_arr[0]);
$_SESSION['sf_ln'] = urldecode($lead_data_arr[1]);

$_SESSION['sf_cn'] = urldecode($lead_data_arr[2]);
$_SESSION['sf_title'] = urldecode($lead_data_arr[3]);
$_SESSION['sf_email'] = $lead_data_arr[4];
$_SESSION['sf_phone'] = $lead_data_arr[5];


$code = $_GET['code'];

if (!isset($code) || $code == "") {
    die("Error - code parameter missing from request!");
}

//$state .= "&sf_fn=".$_GET['fname']."&sf_ln=".$_GET['lname'];


$params = "code=" . $code
    . "&grant_type=authorization_code"
    . "&client_id=" . CLIENT_ID
    . "&client_secret=" . CLIENT_SECRET
    . "&redirect_uri=" . urlencode(REDIRECT_URI);


//$params .= $state;




$curl = curl_init($token_url);
curl_setopt($curl, CURLOPT_HEADER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

$json_response = curl_exec($curl);

$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ( $status != 200 ) {
    die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
}

curl_close($curl);

$response = json_decode($json_response, true);

//echo "<pre>response: ";   print_r($response);   echo "</pre>";



$access_token = $response['access_token'];
$instance_url = $response['instance_url'];



if (!isset($access_token) || $access_token == "") {
    die("Error - access token missing from response!");
}

if (!isset($instance_url) || $instance_url == "") {
    die("Error - instance URL missing from response!");
}

$_SESSION['access_token'] = $access_token;
$_SESSION['instance_url'] = $instance_url;

//$_SESSION['sf_fn'] = $response['sf_fn'];
//$_SESSION['sf_ln'] = $response['sf_ln'];

// Undo below
header( 'Location: demo_rest.php' ) ;
?>

