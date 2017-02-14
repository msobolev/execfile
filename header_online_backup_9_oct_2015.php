<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>ExecFile</title>

	<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />

	<!-- Vendor Styles -->
	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600,600italic,700' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
	<!-- App Styles -->
	<link rel="stylesheet" href="vendor/jquery-ui-1.11.4.custom/jquery-ui.css" />
	<link rel="stylesheet" href="vendor/DropKick-master/build/css/dropkick.css" />
	<link rel="stylesheet" href="vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.css" />
	<link rel="stylesheet" href="css/style.css" />

	<!-- Vendor JS -->
	<script src="vendor/jquery-1.11.3.min.js"></script>
	<script src="vendor/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
	<script src="vendor/jquery-ui-1.11.4.custom/jquery.ui.touch-punch.min.js"></script>
	<script src="vendor/DropKick-master/build/js/dropkick.min.js"></script>
	<script src="vendor/jQuery-Tags-Input-master/dist/jquery.tagsinput.min.js"></script>

	<!-- App JS -->
	<script src="js/functions.js"></script>
</head>
<body>
<?PHP
// http://45.55.139.16/ver2/home.php

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);


define("EXECFILE_ROOT","http://45.55.139.16/");

define("NO_PERSONAL_IMAGE","no-personal-image.png");

$main_page = "home.php";
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 10;
$total_data = "";

//$no_personal_image = "no-personal-image.png";  //"no-personal-image.gif";

$profile_root_link = "https://www.hrexecsonthemove.com/";
//$twitter_share_link = "https://twitter.com/share?url=https://www.execfile.com";
$twitter_share_link = "https://twitter.com/share?";
//$linkedin_share_link = "https://www.linkedin.com/cws/share?url=https://www.execfile.com";
$linkedin_share_link = "https://www.linkedin.com/cws/share?";
//https://www.linkedin.com/cws/share?url=http%3A%2F%2Fgoogle.com


include("functions.php");

//$all_data = get_hr_complete_data();



//$speaking_arr = get_hr_data('speaking');
//$awards_arr = get_hr_data('awards');
//$media_arr = get_hr_data('media');
//die();
?>
    
    
<div class="wrapper">
	<header class="header">
		<a href="#" class="btn-menu">
			<span></span>
		</a>

		<a href="#" class="logo">Execfile</a>

		<a href="#" class="logo-mobile hidden-ds">Execfile</a>

		<div class="header-inner">
			<a href="#" title="Mark All As Read" class="check-btn">
				<i class="ico-check"></i>

				<span class="hidden-ds">Mark All As Read"</span>
			</a>
			
			<nav class="nav-utilities">
			
				<ul>
					<li class="download-holder">
						<a href="#" title="Download" class="download">
							<span>
								<i class="ico-download"></i>
							</span>

							<strong class="hidden-ds">download</strong>
						</a>
					</li>
					
					<li  class="alert-holder">
						<a href="#" title="Create Alert" class="alert-notice">
							<span>
								<i class="ico-bell"></i>
							</span>

							<strong class="hidden-ds">Create Alert</strong>
						</a>	
					</li>
					
					<li class="hasdropdown">
						<a href="#">
							<i class="ico-cog"></i>
						</a>

						<div class="dropdown">
							<ul>
								<li>
									<a href="#">Account</a>
								</li>
								
								<li>
									<a href="#">Settings</a>
								</li>
								
								<li>
									<a href="#">Logout</a>
								</li>
							</ul>
						</div><!-- /.dropdown -->
					</li>
				</ul>
			</nav><!-- /.nav-utilities -->
		</div><!-- /.header-inner -->
	</header><!-- /.header -->