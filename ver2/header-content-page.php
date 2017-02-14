<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?PHP
$current_page = 'alert.php';
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?PHP if($current_page!='movement.php'){echo 'HREXECsonthemove.com ::';}?> <?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />
<link href="css/style.css" rel="stylesheet" type="text/css" />

<?php if($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='alert.php'){ ?>
<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.10.3.custom.min.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/chosen.css" type="text/css" media="all" />
<link rel="stylesheet" href="css/style-search-alert.css" type="text/css" media="all" />
<?php if($current_page=='alert.php'){ ?>
<style>
	#chooseidm011{
	background: url("css/images/select-arrow.png") no-repeat scroll 140px center #FFFFFF;
    width: 164px !important;
	}
	#choosedrop011 {
		width: 164px !important;
	}
</style>
<?php } ?>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css' />

<script src="js/jquery-1.7.2.min.js" type="text/javascript"></script>

<script src="js/jquery.radios.checkboxes.js" type="text/javascript"></script>
<script src="js/chosen.jquery.js" type="text/javascript"></script>
<script src="js/functions.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=DIR_JS?>validation.js" language="javascript"></script>
<script type="text/javascript">
	 $(function() {
	$( "#downloadbtn" ).mouseover(function() {
		$('#downloadshow').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow" ).mouseover(function() {
			$('#downloadshow').css({'display':'block'});
			});
			$( "#downloadshow" ).mouseout(function() {
			$('#downloadshow').css({'display':'none'});
			});
		$('#downloadshow').css({'display':'none'});
	});
	/* alert */
	$( "#setupalertbtn" ).mouseover(function() {
		$('#downloadshow1').css({'display':'block'});
	}).mouseout(function() {
		$( "#downloadshow1" ).mouseover(function() {
			$('#downloadshow1').css({'display':'block'});
			});
			$( "#downloadshow1" ).mouseout(function() {
			$('#downloadshow1').css({'display':'none'});
			});
		$('#downloadshow1').css({'display':'none'});
	});
	
	});
</script>
<?php } ?>

</head>
<body>
<!-- <img src="http://ad.retargeter.com/px?id=61366&amp;t=2" width="1" height="1" /> -->
<?php 
if($_SESSION['sess_user_id'] =='' && ($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='ITExecutivesDirectory.php' || $current_page=='logout.php' || $current_page=='contact-us.php' || $current_page=='team.php' || $current_page=='why-cto.php' || $current_page=='partners.php' || $current_page=='press-news.php' || $current_page=='white-paper.php' || $current_page=='faq.php' || $current_page=='executives-list.php' || $current_page=='company-list.php')){
?>
<script type="text/javascript" src="//www.hellobar.com/hellobar.js"></script>
<?php }
?>
<div class="header">
    <div class="shell">
    	<?php if($current_page=='advance-search.php' || $current_page=='search-result.php' || $current_page=='alert.php'){ ?>
        <!-- <h1 id="new-logo" style="padding-left:0px;"><a href="<?=HTTP_SERVER?>index.php">CTOs on the Move</a></h1> -->
        <h1 style="padding-left:0px;"><a href="home.php?funtion=hr"><img width="336" height="61" src="css/images/new-logo.png"></a></h1>
		<?php }else{ ?>
        <h1><a href="index.php"><img src="css/images/new-logo.png"></a></h1>
        <?php } 
        if(1 == 2)
        {    
        ?>
        <div class="header-right">
            <div id="navigation">
               <ul>
                    <?php if($current_page !='index.php'){ ?>
                    <li><a href="<?=HTTP_SERVER?>index.php">Home</a></li>
                    <?php } ?>
                    <li><a href="<?=HTTP_SERVER?>advance-search.php">Search</a></li>
                    <li><a href="<?=HTTP_SERVER?>team.html">About Us</a></li>
                    <?php if($_SESSION['sess_is_user'] == 1){ ?>
                    <li><?=$_SESSION['sess_username']?>:&nbsp;<a href="<?=HTTP_SERVER?>my-profile.php">Profile</a></li>
                    <li><a href="<?=HTTP_SERVER?>logout.php" class="btn"><span>Log Out</span></a></li>
                    <?php }else{ ?>
                    <li><a href="<?=HTTP_SERVER?>pricing.html">Pricing</a></li>
                    <li><a href="<?=HTTP_SERVER?>login.php" class="btn"><span>Login</span></a></li>
                    <?php } ?>
                </ul>
             </div>
            <!-- /navigation -->
        </div>
        <?PHP
        }
        ?>
        <!-- /header-right -->
    </div>
    <!-- /shell -->
</div>

