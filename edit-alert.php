<?php
session_start();
?>
<script src="js/form_functions.js"></script>
<?PHP
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
if(!isset($_SESSION['sess_username']))
{
    header('Location: http://execfile.com/index.php#joind_100s');
}
//include("header-content-page.php");
include("blue_header.php");
include("config.php");
include("functions.php");
   
//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

//echo "<pre>_SESSION: ";   print_r($_SESSION);   echo "</pre>";   
$this_user = $_SESSION['sess_user_id'];

//echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";   

if(isset($_POST['name_sbt']) && $_POST['name_sbt'] == 'Save' && $_POST['this_alert_id'] != '')
{
    $upd_alert_q = "UPDATE exec_alert set alert_name = '".$_POST['alert_name']."' where alert_id = ".$_POST['this_alert_id'];
    //echo "<br>upd_alert_q: ".$upd_alert_q;
    com_db_query($upd_alert_q);
} 


$user_query = "select * from " . TABLE_ALERT ." where alert_id = ".$this_user;
//echo "<br>user_query: ".$user_query; 
$user_result = com_db_query($user_query);
$user_row = com_db_fetch_array($user_result);
//$level = $user_row['level'];


    //if($_POST['request_demo_flag'] == 1)
    if($msg != '')    
    {    
    ?>
    <div class="intro-content" style="width:722px;margin: 0 auto;">
        <h1 style="font-size:53px;margin-top:100px;"><?=$msg?></h1>
    </div><!-- /.intro-content -->    
    <?PHP
    }
    else
    { 
        echo "<h1 style=\"margin-bottom: 15px;font-size:53px;\">Edit Alert</h1>";
        echo "<table cellpadding=5 cellspacing=0 width=95% style=\"color:white;\">";
        echo "<tr><th width=60 style=text-align:left;>ID</th><th style=text-align:left;>Triggers</th><th width=20 0>Name</th><th>Action</th></tr>";
        echo "</table>";
    }



include("blue_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>