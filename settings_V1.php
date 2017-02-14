<?php
session_start();

//include("header-content-page.php");
include("static_header.php");
include("config.php");
include("functions.php");

   
com_db_connect() or die('Unable to connect to database server!');
?>	 
<div>
    

 </div>
<?php      
include("static_footer.php");
//include(DIR_INCLUDES."footer-content-page.php");
?>