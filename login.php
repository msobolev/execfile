<?php
//include("includes/include-top.php");
$action = $_REQUEST['action'];
$login_email = $_REQUEST['login_email'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title><?=$PageTitle;?></title>
<meta name="keywords" content="<?=$PageKeywords?>" />
<meta name="description" content="<?=$PageDescription?>" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<link href="css/login.css" rel="stylesheet" type="text/css" />


</head>
<script type="text/javascript">
function ClassChangeFocus(divid){
    document.getElementById(divid).className="loginboxdivFocus";
}
function ClassChangeBlur(divid){
    document.getElementById(divid).className="loginboxdiv";
}
function ShowSignUpButton(){
    var email_status=true;
    var email = document.getElementById('login_email').value;
    var pass = document.getElementById('login_pass').value;
    if(email !=''){
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
               if(reg.test(email) == false) {
                       email_status=false;
               }
    }
    if(email !='' && email_status && pass !=''){
            document.getElementById('submit_dutton').innerHTML='<input name="image" value="Sign Up" src="images/blue-signin-buttn.jpg"  alt="Sign Up" style="border: 0px none;" type="image">';
    }else{
            document.getElementById('submit_dutton').innerHTML='<img src="images/gray-signin-buttn.jpg"  alt="Sign Up" title="Sign Up" style="border: 0px none;" />';
    }
}
</script>
<body onload="<?PHP if($action==''){echo "document.getElementById('login_email').focus();";}//elseif($action=='Login'){echo "document.getElementById('login_pass').focus();";}?>">
<div class="main-popup">

<!--    
<div class="logo">
    <a href="<?=HTTP_SERVER?>index.php"></a>
</div>
-->    

<div class="top-logo"><a href="index.php"><img src="css/images/new-logo.png" width="336" height="61" alt="" title="" border="0" /></a></div>    
    
    

<div class="round-box-top"><img src="images/top-shadow.jpg" width="460" height="18"  alt="" title="" /></div>
<div class="round-box">
    <form name="frm_login" method="post" action="res-process.php?action=UserLogin">
        <div class="inner-field-box">
            <div class="text">
            <div id="email_message" style="display:<?PHP if($action=='LoginEmail' || $action=='LoginEmailPassword'){echo 'block;';}else{ echo 'none;';} ?>">The email is not recognized.&nbsp;<a href="index.php#joind_100s">New user?</a></div>Email
            </div>
		
            <div class="field">
            <div id="loginbox_email" <?PHP if($action=='LoginEmail' || $action=='LoginEmailPassword'){echo 'class="loginboxdiv_error"';}else{ echo 'class="loginboxdiv"';} ?>>
            <input class="loginbox" name="login_email" id="login_email" type="text" value="<?=$login_email?>" onfocus="ClassChangeFocus('loginbox_email');"  onblur="ClassChangeBlur('loginbox_email');"/> <!-- onkeyup="ShowSignUpButton();" -->
            </div>
            </div> 
		
            <div class="text">
                <div style="display:<?PHP if($action=='LoginPassword' || $action=='LoginEmailPassword' || $action=='concurrent'){echo 'block;';}else{ echo 'none;';} ?>">Incorrect password. Try again?</div>Password		
            </div>
		
            <div class="field1">
                <div id="loginbox_password" <?PHP if($action=='LoginPassword' || $action=='LoginEmailPassword' || $action=='concurrent'){echo 'class="loginboxdiv_error"';}else{ echo 'class="loginboxdiv"';} ?>>
                    <input class="loginbox" name="login_pass" id="login_pass" type="password" autocomplete="off" onfocus="ClassChangeFocus('loginbox_password');" onblur="ClassChangeBlur('loginbox_password');" /> <!--  onkeyup="ShowSignUpButton();" -->
                </div>
            </div>
		
        
                
            <div class="field">
            <!-- <div class="blue-text-left blue-text"><a href="<?=HTTP_SERVER?>forgot-password.php">Forgot Your Password?</a><a href="<?=HTTP_SERVER?>provide-contact-information.php" class="padding-left">New User?</a></div> -->
            </div>


            <div id="submit_dutton" class="buttn-gray">
                <input name="image" value="Sign Up" src="images/blue-signin-buttn.jpg"  alt="Sign Up" style="border: 0px none;" type="image">
                <!-- <img src="images/gray-signin-buttn.jpg"  alt="Sign Up" title="Sign Up" style="border: 0px none;" /> -->
            </div>
        </div> 
    </form>
</div>

<div class="round-box-bottom"><img src="images/bottom-shadow.jpg" width="460" height="18"  alt="" title="" /></div>


<div class="bottom-coppyright-text">© <?=date("Y");?> Execfile. All rights reserved.</div>

</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47246974-1', 'hrexecsonthemove.com');
  ga('send', 'pageview');

</script>



</body>
</html>
