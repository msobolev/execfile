<?PHP
session_start(); 
ob_start();
//header('Location:https://www.execfile.com/execf/public/index.php/homepage');
?>
<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>ExecFile</title>

	<link rel="shortcut icon" type="image/x-icon" href="css/home_images/favicon.ico" />
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

	<!-- Vendor Styles -->

	<!-- App Styles -->
        <link rel="stylesheet" href="css/home_style_tags.css" />
	<link rel="stylesheet" href="css/home_style.css" />

	<!-- Vendor JS -->
	<script src="vendor/jquery-1.11.3.min.js"></script>

	<!-- App JS -->
	<script src="js/home_functions.js"></script>
        
        <script language="javascript">
            
        /*    
        $('#req_demo_btn_top').click(function(e) 
        { 
            alert("HHHH");
            e.stopPropagation(); 
        });
        */    
            
            
            //$("#req_demo_btn_top").click(function() 
            
            function change_focus()
            {
                $( "#rdf_top" ).show();
                document.getElementById("first_name_rq").focus();
            }
            
            
            function req_demo_block()
            {
                var disp = $('#rdf_top').css('display');
                //alert("DISP: "+disp);
                if(disp == 'none')
                {
                    $( "#rdf_top" ).show();
                }
                else
                    $( "#rdf_top" ).hide();
           } 
            

            function show_form(form_id)
            {
                form_id = '';
               // alert("FORM ID: "+form_id);
               var element_id = 'rdf_top_'+form_id;
               //alert("Element_id: "+element_id);
                var disp = $('#rdf_top_'+form_id).css('display');
                
                if(disp == 'none')
                {
                    //alert("IN IF");
                    $( "#rdf_top_"+form_id).show();
                }
                else
                {
                    //alert("IN ELSE");
                    $( "#rdf_top_"+form_id).hide();
                }    
           } 




            
            function filter_email(email_id)
            {
                //alert("Email ID:"+email_id);
                //alert("in filter email");
                
                var banned_domain_array = ["@gmail.", "@hotmail.", "@yahoo.","@aol.com","@msn."];
                var email = document.getElementById(email_id).value;
                //var email = email_id;
       // alert("EMAIL: "+email);
                var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                
                //alert("REG.TEST: "+reg.test(email));
                
                if(reg.test(email)==false)
                {
                   // alert("IN IF");
                    document.getElementById(email_id).focus();
                    return false;
                }
                else
                {
                    //alert("IN ELSE");
                    var start_position = email.indexOf('@');
                    var email_part = email.substring(start_position);
                    var end_position = email_part.indexOf('.');
                    var find_part = email_part.substring(0,end_position+1);
                    var pemail = banned_domain_array;//[banned_domain_array];
                    //alert("Find_part: "+find_part);
                    var email_result = include(pemail, find_part);
                    if(email_result)
                    {
                        //alert("IN ELSE IF");
                        //alert("Enter your Work Email Address");
                        //document.getElementById('div_email_status').innerHTML='Enter your Work Email Address';
                        document.getElementById(email_id).focus();
                        return false;
                    }
                    else
                    {
                        //alert("IN ELSE ELSE");
                        return true;
                    }    
                }
            }
            
            
            function include(arr, obj) 
            {
                var arrLen = arr.length;		
                for(var i=0; i<arrLen; i++) 
                {
                    if (arr[i].toUpperCase() == obj.toUpperCase()) return true;
                }
            }
            
            
            function thisFormSubmit(fname,lname,email_id,form_id)
            {   
                /*
                oForm = document.getElementById(formName);
                first_name_rq = oForm.elements["first_name_rq"].value;
                alert("FIRST NAME: "+first_name_rq);
                return false;
                */
               
               
                var first_name = document.getElementById(fname).value; //document.getElementById('first_name_rd').value;
                //alert("First Name: "+first_name);        
                var last_name = document.getElementById(lname).value;
                var email = document.getElementById(email_id).value;
                if(first_name != '' && last_name != '' && email != '')
                {
                    var email_validation = filter_email(email_id);
                    //alert("VALIDATION:"+email_validation); return false;
                    //alert("submiting");
                    if(email_validation)
                        document.getElementById(form_id).submit();
                }
                else
                    alert("Fill all fields.");
                   
            }
            
        </script>
        
</head>
<body>
<?PHP

/*
$myString = $_GET['s'];//"sdfdsfds23";
if (preg_match('~[0-9]+~', $myString)) 
{
    echo "YES DIGITS";
}
else
    echo "NO DIGITS";
 */
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

include("config.php");
include("functions.php");
com_db_connect_hre2() or die('Unable to connect to database server!');
if(isset($_GET['action']) && $_GET['action'] == 'logout')
{
    $logout_id = com_db_GetValue("select login_id from " . TABLE_LOGIN_HISTORY. " where user_id='".$_SESSION['sess_user_id']."' and add_date ='".date('Y-m-d')."' order by login_id desc");
    
    $logout_query = "update " . TABLE_LOGIN_HISTORY . " set logout_time ='" .time()."', log_status='Logout' where login_id='".$logout_id."'";
    com_db_query($logout_query);
    
    session_destroy();
    
    
    com_redirect("index.php");
}



$log_history_query="select * from " .TABLE_LOGIN_HISTORY." where last_respond_time >0 and add_date = '".date('Y-m-d')."' and log_status='Login'";
$log_history_result = com_db_query($log_history_query);
while($log_history_row = com_db_fetch_array($log_history_result))
{
    //echo "<br>User ID: ".$log_history_row['user_id'];
    //echo "<br>last_respond_time: ".$log_history_row['last_respond_time'];
    
    if($log_history_row['last_respond_time'] > 0)
    $tot_off_time = time()-$log_history_row['last_respond_time'];
    //echo "<br>tot_off_time: ".$tot_off_time;
    if($tot_off_time > 600)
    {
        $log_history_update = "update ".TABLE_LOGIN_HISTORY." set log_status='Logout', logout_time='".time()."' where add_date = '".date('Y-m-d')."' and log_status='Login' and user_id='".$log_history_row['user_id']."'";
        com_db_query($log_history_update);
    }
}

//echo "<pre>";   print_r($_SESSION);   echo "</pre>";

//$this_site = mysql_connect(EXEC_SERVER_IP,EXEC_DB_USER_NAME,EXEC_DB_PASSWORD,TRUE) or die("Database ERROR ".mysql_error());
//mysql_select_db("exec",$this_site) or die ("ERROR: Database not found ");

//com_db_connect() or die('Unable to connect to database server!');


if((isset($_POST['field-name']) && $_POST['field-name'] != '') && (isset($_POST['field-email']) && $_POST['field-email'] != ''))
{
    $name = $_POST['field-name'];
    $email = $_POST['field-email'];
    
    
    $check_user = "select * from " .TABLE_USER." where email = '".$email."'";
    //echo "<br>check_user: ".$check_user;
    $check_user_rs = com_db_query($check_user);
    $check_user_rows = com_db_num_rows($check_user_rs);
    //echo "<br>check_user_rows: ".$check_user_rows;
    //die();
    if($check_user_rows > 0)
    {
        header("Location: request_demo.php?sf=2");
    }    
    else
    {    
        add_user($name,$email);
        header("Location: request_demo.php?sf=1");
    }
    
    

}   


if(isset($_POST['request_demo_flag']) && $_POST['request_demo_flag'] == 1)
{
    $first_name = $_POST['first_name_rq'];
    $last_name = $_POST['last_name_rq'];
    $email = $_POST['email_rq'];
    add_user($first_name,$email,1,$last_name,'Request a demo');
}
?>
   
<div class="wrapper">
    <div class="bar">
        <div class="shell">
            <nav class="nav-access">
                <ul>
                    <li>
                        <?PHP
                        //echo "<pre>SS:";   print_r($_SESSION);   echo "</pre>";
                        if(isset($_SESSION['sess_user_id']) && $_SESSION['sess_user_id'] != '')
                        {    
                        ?>
                        <a href="index.php?action=logout">Log Out</a>
                        <?PHP
                        }
                        else
                        {    
                        ?>
                        <a href="login.php">Login</a>
                        <?PHP
                        }
                        ?>
                    </li>

                    
                    <?PHP
                    if(!isset($_SESSION['sess_user_id']))
                    {    
                    ?>
                    <li class="blue">
                        <a href="#joind_100s">Sign Up</a>
                    </li>
                    <?PHP
                    }
                    ?>
                    
                </ul>
            </nav><!-- /.nav-access -->
        </div><!-- /.shell -->
    </div><!-- /.bar -->
    <header class="header">
        <div class="shell">
            <a href="#" class="logo"></a>
	
            <nav class="nav">
                <ul>
                    <li class="current">
                        <a href="#how_it">How It Works</a>
                    </li>

                    <li>
                        <a href="#clients">Clients</a>
                    </li>
                    <li ><a href="request-demo.html">Request a Demo</a></li> <!-- onclick="req_demo_block()" -->
                        <!-- <a  href="">Request a Demo</a> -->
                    
                </ul>
            </nav><!-- /.nav -->
	
            <a href="#" class="btn-menu">
                <span></span>
            </a>
        </div><!-- /.shell -->
    </header><!-- /.header -->

    
    <div id="rdf_top" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
        <?PHP
        $first_name_field_name = "first_name_rq";
        $last_name_field_name = "last_name_rq";
        $email_field_name = "email_rq";
        $form_id = "request_demo_form";
        include("request_demo_form.php");
        ?>
    </div>    
    
    
    
	<div class="container">
		<div class="intro">
			<div class="shell">
				<div class="intro-head">
					<h1>A Unified Social Selling Platform for B2B <br> Inside Sales Teams</h1>
				</div><!-- /.intro-head -->
				
				<div class="intro-inner">
                                    <div class="intro-content">
                                        <h3>Get a 5x jump in email response rate with real time sales triggers:</h3>

                                        <div class="form-sing-up">
                                            <form action="index.php" method="post" onsubmit="return filter_email('field-email-1');">
                                                    <div class="form-body">
                                                            <div class="form-row">
                                                                    <label for="field-name" class="form-label hidden">Name </label>

                                                                    <div class="form-controls">
                                                                            <i class="ico-user"></i>

                                                                            <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name">
                                                                    </div><!-- /.form-controls -->
                                                            </div><!-- /.form-row -->

                                                            <div class="form-row">
                                                                <label for="field-email" class="form-label hidden">Work Email</label>

                                                                <div class="form-controls">
                                                                    <i class="ico-mail"></i>
                                                                    <input type="email" class="field" name="field-email" id="field-email-1" value="" placeholder="Work Email">
                                                                </div><!-- /.form-controls -->
                                                            </div><!-- /.form-row -->
                                                    </div><!-- /.form-body -->

                                                    <div class="form-actions">
                                                            <input type="submit" value="Sign Up Now" class="form-btn"> <!--  onclick="return filter_email();" -->
                                                    </div><!-- /.form-actions -->
                                            </form>
                                        </div><!-- /.form-sing-up -->
                                    </div><!-- /.intro-content -->
					
					<div class="intro-image">
						<img src="css/home_images/temp/intro-image1.png" alt="">
					</div><!-- /.intro-image -->	
				</div><!-- /.intro-inner -->
			</div><!-- /.shell -->
		</div><!-- /.intro -->

		<section class="section section-primary">
			<div class="shell">
				<div class="section-head">
					<h3 id="trusted_by">Trusted By Inside Sales Teams at Leading Enterprises</h3>
				</div><!-- /.section-head -->
				
				<div class="section-body">
					<ul class="list-logos">
						<li>
							<img src="css/home_images/temp/logo-garther1.png" alt="">
						</li>
						
						<li>
							<img src="css/home_images/temp/logo-grovo.png" alt="">
						</li>
						
						<li>
							<img src="css/home_images/temp/logo-glg.png" alt="">
						</li>
						
						<li>
							<img src="css/home_images/temp/logo-ddi.png" alt="">
						</li>
						
						<li>
							<img src="css/home_images/temp/logo-graebel.png" alt="">
						</li>
						
						<li>
							<img src="css/home_images/temp/logo-skill-survey1.png" alt="">
						</li>
					</ul><!-- /.list-logos -->
				</div><!-- /.section-body -->
			</div><!-- /.shell -->
		</section><!-- /.section section-primary -->

		<section class="section section-secondary">
			<div class="shell">
				<div class="section-head">
					<h4> Join 100s of SDRs and Inside Sales Reps who increase their outbound email response rate on prospecting campaigns by 5x or more: </h4>
				</div><!-- /.section-head -->

				<div class="section-body">
					<div class="form-sing-up-primary">
						<form action="index.php" method="post" onsubmit="return filter_email('field-email-2');">
							<div class="form-body">
								<div class="form-row">
									<div class="form-col">
										<label for="field-name" class="form-label hidden">1#</label>
										
										<div class="form-controls">
											<i class="ico-user"></i>

											<input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name">
										</div><!-- /.form-controls -->
									</div><!-- /.form-col -->

									<div class="form-col">
										<label for="field-email" class="form-label hidden">2#</label>
										
										<div class="form-controls">
											<i class="ico-mail"></i>

											<input type="email" class="field" name="field-email" id="field-email-2" value="" placeholder="Work Email">
										</div><!-- /.form-controls -->
									</div><!-- /.form-col -->

									<div class="form-col">
										<div class="form-actions">
											<input type="submit" value="Sign Up Now" class="form-btn">
										</div><!-- /.form-actions -->
									</div><!-- /.form-col -->
								</div><!-- /.form-row -->
							</div><!-- /.form-body -->
						</form>
					</div><!-- /.form-sing-up-primary -->
				</div><!-- /.section-body -->
			</div><!-- /.shell -->
		</section><!-- /.section section-secondary -->

		<section class="section section-primary">
                    <div class="shell">
                        <div class="section-content">
                            <h4>Did you know that any contact list (including your house list in your CRM) goes obsolete at a rate of 30% a year? </h4>
                            <p>Yes, that’s right! Your prospects change roles within their companies, resign, retire, switch companies, get fired or move laterally. Every day. And if you think all of that gets updated in LinkedIn in real time, then think again. </p>
                            <p>We track more than 15000 news sources for press releases, company announcements, SEC filings, social media to deliver these delta highlights to you. We believe in perishability of insight and you will get the freshest, most actionable leads.</p>
                            <a  id="request_demo_2" href="request-demo.html" class="btn btn-primary">Request A Demo</a>  <!-- onclick="change_focus()"   onclick="show_form('two')" -->
                        </div><!-- /.section-content -->

                        <div class="section-image">
                            <img src="css/home_images/temp/image1.png" alt="">
                        </div><!-- /.section-image -->
                    
                    
                        <div id="rdf_top_two" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
                            <?PHP
                            $first_name_field_name = "first_name_rq_two";
                            $last_name_field_name = "last_name_rq_two";
                            $email_field_name = "email_rq_two";
                            $form_id = "request_demo_form_two";
                            include("request_demo_form.php");
                            ?>
                        </div>
                        
                        
                    
                    </div><!-- /.shell -->
		</section><!-- /.section section-primary -->

                
                
                 
                
                
                
		<section class="section section-teritary">
			<div class="shell">
				<div class="section-image">
					<img src="css/home_images/temp/image2.png" alt="">
				</div><!-- /.section-image -->
				
				<div class="section-content">
					<h4>Do You Know What Makes Your Prospects Respond? When You Talk About Them You Can Get up to 5x Higher Response Rate.</h4>

					<p>And we provide the speaking points! You will receive real time updates when your clients get appointed or promoted to key executive roles (with their updated emails), speak at events, receive industry awards, raise funding, get quoted by press, publish articles and books, and more.</p>

					<p>So you will never run out of prospects to reach out to and topics to open your conversation with. This will get you up to 5x higher response rate on your outreach.</p>

					<a  href="request-demo.html" class="btn btn-primary">Request A Demo</a> <!-- onclick="show_form('three')" -->
				</div><!-- /.section-content -->
                                
                                
                                
                                <div id="rdf_top_three" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
                                    <?PHP
                                    $first_name_field_name = "first_name_rq_three";
                                    $last_name_field_name = "last_name_rq_three";
                                    $email_field_name = "email_rq_three";
                                    $form_id = "request_demo_form_three";
                                    include("request_demo_form.php");
                                    ?>
                                </div>
                                
                                
                                
                                
                                
			</div><!-- /.shell -->
		</section><!-- /.section section-teritary -->

		<section class="section section-primary">
			<div class="shell">
				<div class="section-content">
					<h4>We Walk an Extra Mile in Your Shoes. So You Don’t Have to.</h4>

					<p>Persuasion isn’t an easy skill to master. Lucky for you, we do the heavy lifting for you there. Not only we uncover important events in lives of your prospects that are top of mind for them, not only we append industry taxonomy, company size and geo data so that you can precision target your prospects, not only we append new contact details making these insights instantly actionable for you…</p>

					<p>We also help draft the messaging both email and phone based on best practices, hacks and tactics that you will not learn in a book. </p>

					<a href="request-demo.html" class="btn btn-primary">Request A Demo</a> <!-- onclick="show_form('four')"  -->
				</div><!-- /.section-content -->
                                
                                
                                
                                
                                
				
				<div class="section-image section-image-primary">
					<img src="css/home_images/temp/image3.png" alt="">
				</div><!-- /.section-image -->
                                
                                <div id="rdf_top_four" style="float:left;width:100%;text-align:left;padding:20px;color:white;display:none;">
                                    <?PHP
                                    $first_name_field_name = "first_name_rq_four";
                                    $last_name_field_name = "last_name_rq_four";
                                    $email_field_name = "email_rq_four";
                                    $form_id = "request_demo_form_four";
                                    include("request_demo_form.php");
                                    ?>
                                </div>    
                                
                                
                                
                                
			</div><!-- /.shell -->
		</section><!-- /.section section-primary -->

		<section class="section section-secondary">
			<div class="shell">
				<div class="section-head">
					<h4> Join 100s of SDRs and Inside Sales Reps who increase their outbound email response rate on prospecting campaigns by 5x or more: </h4>
				</div><!-- /.section-head -->

				<div class="section-body">
					<div class="form-sing-up-primary">
						<form action="index.php"  method="post"  onsubmit="return filter_email('field-email-3');">
							<div class="form-body">
								<div class="form-row">
									<div class="form-col">
										<label for="field-name" class="form-label hidden">1#</label>
										
										<div class="form-controls">
											<i class="ico-user"></i>

											<input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name">
										</div><!-- /.form-controls -->
									</div><!-- /.form-col -->

									<div class="form-col">
										<label for="field-email" class="form-label hidden">2#</label>
										
										<div class="form-controls">
											<i class="ico-mail"></i>

											<input type="email" class="field" name="field-email" id="field-email-3" value="" placeholder="Work Email">
										</div><!-- /.form-controls -->
									</div><!-- /.form-col -->

									<div class="form-col">
										<div class="form-actions">
											<input type="submit" value="Sign Up Now" class="form-btn">
										</div><!-- /.form-actions -->
									</div><!-- /.form-col -->
								</div><!-- /.form-row -->
							</div><!-- /.form-body -->
						</form>
					</div><!-- /.form-sing-up-primary -->
				</div><!-- /.section-body -->
			</div><!-- /.shell -->
		</section><!-- /.section section-secondary -->

		<section class="section section-primary section-work">
			<div class="shell">
				<div class="section-head">
					<h4 id="how_it">How It Works:</h4>
				</div><!-- /.section-head -->
				
				<div class="section-content">
					<ul class="list-numbers">
						<li>We track over 15K news sources for events important to your prospects so that you don’t have to invest in all the expensive and un-actionable subscriptions.</li>
				
						<li>We clean the data (entity extraction, disambiguation, de-duping and validation) so you never need to wonder if the insight is relevant.</li>
				
						<li>We enrich the data by appending industry taxonomy, company size, and geo location data so you can focus on your target prospects with high precision.</li>
				
						<li>We deliver the insights to you in an easy-to-use format so you can be engaging with your prospects with no friction so you can get a 5x+ lift in your response rate!</li>
					</ul><!-- /.list-numbers -->
				</div><!-- /.section-content -->
				
				<div class="section-image">
                                    <img src="css/home_images/temp/image4.png" alt="">
				</div><!-- /.section-image section-image-primary -->
			</div><!-- /.shell -->
		</section><!-- /.section section-primary  section-work -->

		<section class="section section-quaternary">
                    <div class="shell">
                        <div class="section-head">
                            <h4 id="clients">Don’t take our word for everything, take the words of our clients:</h4>
                        </div><!-- /.section-head -->

                        <div class="section-content">
                            <ul class="testimonials">
                                <li class="testimonial">
                                    <div class="testimonial-logo" style="padding-top:5px;">
                                        <img src="css/home_images/temp/logo-gartner.png" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ Keeping our database of contacts and prospects up to date is of critical importance. ExecFile's real time notifications are an integral piece of that process. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar">
                                        <img src="css/home_images/temp/penkoff.jpg" alt="" class="testimonial-image">

                                        <strong class="testimonial-author">Gregory P.</strong>
                                    </div><!-- /.testimonial-avatar -->
                                </li><!-- /.testimonial -->

                                <li class="testimonial" style="width:35%;">
                                    <div class="testimonial-logo">
                                        <img src="css/home_images/temp/logo-skill-survey.png" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ ExecFile file delivered on every promise. We find daily alerts particularly helpful. One of the recent ones helped us engage a prospect we've been chasing for months. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar">
                                        <img src="css/home_images/temp/fuhr-2.png" alt="" class="testimonial-image">
                                        <strong class="testimonial-author">Scott F.</strong>
                                    </div><!-- /.testimonial-avatar -->
                                </li><!-- /.testimonial -->

                                <li class="testimonial" style="width:27%;">
                                    <div class="testimonial-logo" style="padding-top:9px;">
                                        <img style="max-width:none;margin-top:-2px;margin-left:-34px;width:276px;" src="css/home_images/temp/logo-mindtree.png" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ We got our money worth in three months on the annual subscription. Can't recommend the service more. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar" style="padding-top:3px;">
                                        <img src="css/home_images/temp/kaul-1.png" alt="" class="testimonial-image">
                                        <strong class="testimonial-author">Vikram K.</strong>
                                    </div><!-- /.testimonial-avatar -->
                                </li><!-- /.testimonial -->
                            </ul><!-- /.testimonials -->
                        </div><!-- /.section-content -->
                    </div><!-- /.shell -->
		</section><!-- /.section section-quaternary -->

            <section class="section section-secondary">
                <div class="shell">
                    <div class="section-head">
                        <h4 id="joind_100s"> Join 100s of SDRs and Inside Sales Reps who increase their outbound email response rate on prospecting campaigns by 5x or more: </h4>
                    </div><!-- /.section-head -->

                    <div class="section-body">
                        <div class="form-sing-up-primary">
                            <form action="index.php"  method="post"  onsubmit="return filter_email('field-email-4');">
                                <div class="form-body">
                                    <div class="form-row">
                                        <div class="form-col">
                                            <label for="field-name" class="form-label hidden">1#</label>

                                            <div class="form-controls">
                                                <i class="ico-user"></i>

                                                <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name">
                                            </div><!-- /.form-controls -->
                                        </div><!-- /.form-col -->

                                        <div class="form-col">
                                            <label for="field-email" class="form-label hidden">2#</label>

                                            <div class="form-controls">
                                                <i class="ico-mail"></i>

                                                <input type="email" class="field" name="field-email" id="field-email-4" value="" placeholder="Work Email">
                                            </div><!-- /.form-controls -->
                                        </div><!-- /.form-col -->

                                        <div class="form-col">
                                            <div class="form-actions">
                                                <input type="submit" value="Sign Up Now" class="form-btn">
                                            </div><!-- /.form-actions -->
                                        </div><!-- /.form-col -->
                                    </div><!-- /.form-row -->
                                </div><!-- /.form-body -->
                            </form>
                        </div><!-- /.form-sing-up-primary -->
                    </div><!-- /.section-body -->
                </div><!-- /.shell -->
            </section><!-- /.section section-secondary -->
	</div><!-- /.container -->
	<footer class="footer">
            <div class="shell">
                <div class="footer-cols">
                        <div class="footer-col footer-col-1of3">
                            <h5>Company</h5>

                            <ul class="list-links">
                                <li>
                                    <a href="#trusted_by">Customers</a>
                                </li>
                                <!--
                                <li>
                                    <a onclick="change_focus()"  href="#">Request A Demo</a>
                                </li>
                                -->
                                <li>
                                    <a href="blog">Blog</a>
                                </li>

                                <li>
                                    <a href="#how_it">About Us</a>
                                </li>
                            </ul><!-- /.list-links -->
                        </div><!-- /.footer-col footer-col-1of3 -->

                        <div class="footer-col footer-col-1of3">
                            <h5>Support</h5>

                            <ul class="list-links">
                                <li>
                                    <a href="contact-us.html">Contact us</a>
                                </li>

                                <li>
                                    <a href="request-demo.html">Schedule a Demo</a>
                                </li>

                                <li>
                                    <a href="terms.html">Terms of Service</a>
                                </li>
                            </ul><!-- /.list-links -->
                        </div><!-- /.footer-col footer-col-1of3 -->

                        <div class="footer-col footer-col-1of3">
                            <h5>Get in touch</h5>

                            <ul class="list-links">
                                <li>
                                    <a href="#">Connect on LinkedIn</a>
                                </li>

                                <li>
                                    <a href="https://twitter.com/Exec_File">Connect on Twitter</a>
                                </li>

                                <li>
                                    <a href="https://www.facebook.com/ExecFile-710717822397575/">Connect on Facebook</a>
                                </li>
                                    <!--
                                    <li>
                                        <a href="#">Read our Blog</a>
                                    </li>
                                    -->
                            </ul><!-- /.list-links -->
                        </div><!-- /.footer-col footer-col-1of3 -->
                </div><!-- /.footer-cols -->

                <div class="footer-bar">
                    <p class="copyright"><?=date("Y");?> &copy; ExecFile. All Rights Reserved.</p><!-- /.copyright -->
                </div><!-- /.footer-bar -->		

            </div><!-- /.shell -->
	</footer><!-- /.footer -->
    </div><!-- /.wrapper -->
</body>
</html>
<?PHP
ob_end();
?>