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


include("functions.php");

//$all_data = get_hr_complete_data();

$all_data = get_hr_all_data();

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

	<div class="main">
		<div class="sidebar">
			<ul class="widgets">
				<li class="widget widget-search">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-search"></i>
						</span>
		
						<h3 class="widget-title">Search</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<div class="search">
							<div class="ui-widget">
								  <form class="form-search">
								  <label for="developer" class="hidden">Search </label>
								  <input id="developer" placeholder="Select Now" class="search-field">
								  </form>
								</div>
							</div><!-- /.search -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
				
				<li class="widget widget-function">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-function"></i>
						</span>
		
						<h3 class="widget-title">
							Funciton
						</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<nav class="widget-nav">
							<ul>
								<li>
									<a href="#">HR</a>
								</li>
								
								<li>
									<a href="#">Finance</a>
								</li>
								
								<li>
									<a href="#">Marketing</a>
								</li>
								
								<li>
									<a href="#">IT</a>
								</li>
								
								<li>
									<a href="#">Legal</a>
								</li>
							</ul>
						</nav><!-- /.widget-nav -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
				
				<li class="widget widget-alerts">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-bell-white"></i>
						</span>
		
						<h3 class="widget-title">
							Alert Type
						</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<ul class="list-alerts">
							<li>
								<a href="#">
									Appointments
		
									<span>6</span>
								</a>
							</li>
							
							<li>
								<a href="#">Speaking</a>
							</li>
							
							<li>
								<a href="#">Media Mentions</a>
		
								<span>3</span>
							</li>
							
							<li>
								<a href="#">Publications</a>
							</li>
							
							<li>
								<a href="#">Industry Awards</a>
							</li>
							
							<li>
								<a href="#">Funding</a>
								<span>3</span>
							</li>
							
							<li>
								<a href="#">Jobs</a>
							</li>
							
							<li>
								<a href="#">Conferences</a>
							</li>
						</ul><!-- /.list-alerts -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
				
				<li class="widget widget-calendar">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-calendar"></i>
						</span>
		
						<h3 class="widget-title">
							Timeframe
						</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<div class="calendar-holder">
							<i class="ico-calendar-small"></i>
							
							<label class="calendar-label "for="from" >From:</label>
							<input type="text" id="from" name="from">
						</div><!-- /.calendar-holder -->
						<div class="calendar-holder">
							<i class="ico-calendar-small"></i>

							<label class="calendar-label "for="to">To:</label>
							<input type="text" id="to" name="to">
						</div><!-- /.calendar-holder -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
				
				<li class="widget widget-slider">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-building"></i>
						</span>
		
						<h3 class="widget-title">
							Company
						</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<div class="form-company">
							<form action="#" method="post">
								
								<div class="form-body">
									<div class="form-row">
										<label for="field-company-name" class="form-label  hidden">Company Name/URL</label>
										
										<div class="form-controls">
											<input type="text" class="field" name="field-company-name" id="field-company-name" value="" placeholder="Company Name/URL">
										</div><!-- /.form-controls -->
									</div><!-- /.form-row -->
		
									
									<div class="checkbox-holder">
										<ul class="list-checkboxes">
										
										<strong class="list-checkboxes-title">Industry</strong><!-- /.list-checkboxes-title -->
										
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-agriculture" id="field-agriculture">
													
													<label class="form-label label-check" for="field-agriculture">Agriculture</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-business-ervices" id="field-business-ervices">
													
													<label class="form-label label-check" for="field-business-ervices">Business Services</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-chambers" id="field-chambers">
													
													<label class="form-label label-check" for="field-chambers">Chambers</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-cities" id="field-cities">
													
													<label class="form-label label-check" for="field-cities">Cities, Towns &amp; Municipalities</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-construction" id="field-construction">
													
													<label class="form-label label-check" for="field-construction">Construction</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-consumer-services" id="field-consumer-services">
													
													<label class="form-label label-check" for="field-consumer-services">Consumer-services</label>
												</div><!-- /.checkbox -->
											</li>
										</ul><!-- /.list-checkboxes -->	
										
										<ul class="list-checkboxes">
										
										<strong class="list-checkboxes-title">Non-profit</strong><!-- /.list-checkboxes-title -->
										
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-agriculture" id="field-agriculture">
													
													<label class="form-label label-check" for="field-agriculture">Agriculture</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-business-ervices" id="field-business-ervices">
													
													<label class="form-label label-check" for="field-business-ervices">Business Services</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-chambers" id="field-chambers">
													
													<label class="form-label label-check" for="field-chambers">Chambers</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-cities" id="field-cities">
													
													<label class="form-label label-check" for="field-cities">Cities, Towns &amp; Municipalities</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-construction" id="field-construction">
													
													<label class="form-label label-check" for="field-construction">Construction</label>
												</div><!-- /.checkbox -->
											</li>
											
											<li>
												<div class="checkbox">
													<input type="checkbox" name="field-consumer-services" id="field-consumer-services">
													
													<label class="form-label label-check" for="field-consumer-services">Consumer-services</label>
												</div><!-- /.checkbox -->
											</li>
										</ul><!-- /.list-checkboxes -->
									</div><!-- /.checkbox-holder -->
		
									<div class="sliders">
										<div class="slider-holder">
											<p>
											  <label for="amount" class="slider-label">Revenue</label>
											  										
											  <input type="text" id="amount" class="slider-input" value="0 - $50 mil">
											</p>
											
											<div id="slider-range" class="slider-range" data-truevalues="0, $1 mil, $10 mil, $50 mil, $100 mil, $250 mil, $500 mil, $1 bil, > $1 bil" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
										</div><!-- /.slider-holder -->

										<div class="slider-holder">
											<p>
											  <label for="amount2" class="slider-label">Employees</label>
											  										
											  <input type="text" id="amount2" class="slider-input" value="0 - 250">
											</p>
											
											<div id="slider-range-secondary" class="slider-range" data-truevalues="0, 25, 100, 250, 1k, 10k, 50k, 100k, > 100k" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
										</div><!-- /.slider-holder -->
									</div><!-- /.sliders -->
								</div><!-- /.form-body -->
							</form>
						</div><!-- /.form-company -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
				
				<li class="widget widget-location">
					<div class="widget-head">
						<span class="ico-widget">
							<i class="ico-location"></i>
						</span>
		
						<h3 class="widget-title">
							Location
						</h3><!-- /.widget-title -->
					</div><!-- /.widget-head -->
					
					<div class="widget-body">
						<div class="form-location">
							<form action="#" method="post">
								<div class="form-body">
									<div class="form-row">
										<label for="field-city" class="form-label">City</label>
										
										<div class="form-controls">
											<input type="text" class="field" name="field-city" id="field-city" value="">
										</div><!-- /.form-controls -->
									</div><!-- /.form-row -->
		
									<div class="form-row">
										<label for="field-state" class="form-label">State</label>
										
										<div class="form-controls">
											<select name="field-state" class="select dropkick" id="field-state">
												<option value="">Any</option>
											</select>
										</div><!-- /.form-controls -->
									</div><!-- /.form-row -->
									
									<div class="form-row">
										<label for="field-zip" class="form-label">ZIp</label>
										
										<div class="form-controls">
											<input type="text" class="field" name="field-zip" id="field-zip" value="">
										</div><!-- /.form-controls -->
									</div><!-- /.form-row -->
								</div><!-- /.form-body -->
							</form>
						</div><!-- /.fomr-location -->
					</div><!-- /.widget-body -->
				</li><!-- /.widget -->
			</ul><!-- /.widgets -->
		</div><!-- /.sidebar -->
		
		<div class="content">
			<section class="section-primary">
				<header class="section-head">
					 <form class="form-tags">
					      <p>
					      	<label class="form-label hidden">Tags</label>

					     	<input id="tags_1" type="text" class="tags" value="HR,Appointments,May 2014 – May 2015,Business Services,Rev $10 - $50 million" />
					 	 </p>
					 </form>
				
					<p class="records">4,324 records</p>
				</header><!-- /.section-head -->
				
				<div class="section-body">
					<ul class="articles">
						<li class="article">
							<ul class="list-checkboxes">
								<li>
									<div class="checkbox">
										<input type="checkbox" name="field-1#" id="field-1#">
										
										<label class="form-label" for="field-1#">1#</label>
									</div><!-- /.checkbox -->
								</li>
							</ul><!-- /.list-checkboxes -->
							
							<span class="ico-article">
								<i class="ico-arrow-up-blue"></i>
							</span>

							<div class="article-image">
								<img src="css/images/temp/article-avatar1.png" height="80" width="80" alt="" class="article-avatar">
							</div><!-- /.article-image -->
							
							<div class="article-content">
								<p>Dan Lifferth was Appointed as Senior Vice President of Human Resources at 1st Source Bank.</p>

								<div class="socials">
									<ul>
										<li>
											<a href="#" class="note">
												<i class="ico-note"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="upload">
												<i class="ico-upload"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="salesforce">
												<i class="ico-salesforce"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="twitter">
												<i class="ico-twitter"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="linkedin">
												<i class="ico-linkedin"></i>
											</a>
										</li>
									</ul>
								</div><!-- /.socials -->
							</div><!-- /.article-content -->
							
							<div class="article-actions">
								<a href="#" class="btn btn-primary">
								<!-- <a href="mailto:'.$email_row['email'].'?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" > -->	
                                                                    <span>Email now</span>
									
									<i class="ico-arrow-right"></i>
								</a>
							</div><!-- /.article-actions -->
						</li><!-- /.article -->
						
                                                
                                                <?PHP
                                                foreach($speaking_arr as $id=>$data_arr)
                                                { 
                                                    $converted_date = date("M d, Y", strtotime($data_arr['event_date']));
                                                ?>
                                                
                                                
						<li class="article">
                                                    <ul class="list-checkboxes">
                                                        <li>
                                                            <div class="checkbox">
                                                                <input type="checkbox" name="field-2#" id="field-2#">

                                                                <label class="form-label" for="field-2#">1#</label>
                                                            </div><!-- /.checkbox -->
                                                        </li>
                                                    </ul><!-- /.list-checkboxes -->
							
                                                    <span class="ico-article">
                                                        <i class="ico-microphone"></i>
                                                    </span>

                                                    <div class="article-image">
                                                        <?PHP
                                                        if($data_arr['personal_image'] != '')
                                                        {    
                                                        ?>
                                                            <img src="https://www.ctosonthemove.com/personal_photo/small/<?=$data_arr['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                                        <?PHP
                                                        }
                                                        else
                                                        {    
                                                        ?>
                                                            <img src="css/images/temp/article-avatar2.png" height="80" width="80" alt="" class="article-avatar">
                                                        <?PHP
                                                        }
                                                        ?>
                                                    </div><!-- /.article-image -->
							
                                                    <div class="article-content">
                                                        <p><?=$data_arr['first_name']?> <?=$data_arr['last_name']?> scheduled to speak at <?=$data_arr['event']?> on <?=$converted_date?></p>

                                                        <div class="socials">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" class="note">
                                                                        <i class="ico-note"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="upload">
                                                                        <i class="ico-upload"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="salesforce">
                                                                        <i class="ico-salesforce"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="twitter">
                                                                        <i class="ico-twitter"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="linkedin">
                                                                        <i class="ico-linkedin"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.socials -->
                                                    </div><!-- /.article-content -->
							
                                                    <div class="article-actions">
                                                        <a href="#" class="btn btn-primary">
                                                            <span>Email now</span>
                                                            <i class="ico-arrow-right"></i>
                                                        </a>
                                                    </div><!-- /.article-actions -->
						</li><!-- /.article -->
						
                                                <?PHP
                                                }
                                                ?>
                                                
                                                
                                                <?PHP
                                                foreach($awards_arr as $id=>$data_arr)
                                                { 
                                                    $converted_date = date("M d, Y", strtotime($data_arr['awards_date']));
                                                ?>
                                                
						<li class="article">
                                                    <ul class="list-checkboxes">
                                                        <li>
                                                            <div class="checkbox">
                                                                <input type="checkbox" name="field-3#" id="field-3#">

                                                                <label class="form-label" for="field-3#">1#</label>
                                                            </div><!-- /.checkbox -->
                                                        </li>
                                                    </ul><!-- /.list-checkboxes -->
							
                                                    <span class="ico-article">
                                                            <i class="ico-cup"></i>
                                                    </span>

                                                    <div class="article-image">
                                                    <?PHP
                                                    if($data_arr['personal_image'] != '')
                                                    {    
                                                    ?>
                                                        <img src="https://www.ctosonthemove.com/personal_photo/small/<?=$data_arr['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                                    <?PHP
                                                    }
                                                    else
                                                    {    
                                                    ?>
                                                        <img src="css/images/temp/article-avatar3.png" height="80" width="80" alt="" class="article-avatar">
                                                    <?PHP
                                                    }
                                                    ?>
                                                    </div><!-- /.article-image -->
							
                                                    <div class="article-content">
                                                        <p><?=$data_arr['first_name']?> <?=$data_arr['last_name']?> received <?=$data_arr['awards_title']?> from <?=$data_arr['awards_given_by']?> on <?=$converted_date?></p>

                                                        <div class="socials">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" class="note">
                                                                        <i class="ico-note"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="upload">
                                                                        <i class="ico-upload"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="salesforce">
                                                                        <i class="ico-salesforce"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="twitter">
                                                                        <i class="ico-twitter"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="linkedin">
                                                                        <i class="ico-linkedin"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.socials -->
                                                    </div><!-- /.article-content -->
							
                                                    <div class="article-actions">
                                                        <a href="#" class="btn btn-primary">
                                                            <span>Email now</span>

                                                            <i class="ico-arrow-right"></i>
                                                        </a>
                                                    </div><!-- /.article-actions -->
						</li><!-- /.article -->
						
                                                <?PHP
                                                }
                                                ?>
                                                
                                                
                                                <?PHP
                                                foreach($media_arr as $id=>$data_arr)
                                                { 
                                                    $converted_date = date("M d, Y", strtotime($data_arr['pub_date']));
                                                ?>
                                                
                                                
						<li class="article">
                                                    <ul class="list-checkboxes">
                                                        <li>
                                                            <div class="checkbox">
                                                                <input type="checkbox" name="field-4#" id="field-4#">

                                                                <label class="form-label" for="field-4#">1#</label>
                                                            </div><!-- /.checkbox -->
                                                        </li>
                                                    </ul><!-- /.list-checkboxes -->

                                                    <span class="ico-article">
                                                        <i class="ico-newspaper"></i>
                                                    </span>

                                                    <div class="article-image">
                                                    <?PHP
                                                    if($data_arr['personal_image'] != '')
                                                    {    
                                                    ?>
                                                        <img src="https://www.ctosonthemove.com/personal_photo/small/<?=$data_arr['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                                    <?PHP
                                                    }
                                                    else
                                                    {    
                                                    ?>        
                                                        <img src="css/images/temp/article-avatar4.png" height="80" width="80" alt="" class="article-avatar">
                                                    <?PHP
                                                    }
                                                    ?>
                                                    </div><!-- /.article-image -->

                                                    <div class="article-content">
                                                        <p><?=$data_arr['first_name']?> <?=$data_arr['last_name']?> was quoted by <?=$data_arr['publication']?> on <?=$converted_date?></p>

                                                        <div class="socials">
                                                            <ul>
                                                                <li>
                                                                    <a href="#" class="note">
                                                                        <i class="ico-note"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="upload">
                                                                        <i class="ico-upload"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="salesforce">
                                                                        <i class="ico-salesforce"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="twitter">
                                                                        <i class="ico-twitter"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#" class="linkedin">
                                                                        <i class="ico-linkedin"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div><!-- /.socials -->
                                                    </div><!-- /.article-content -->

                                                    <div class="article-actions">
                                                        <a href="#" class="btn btn-primary">
                                                            <span>Email now</span>

                                                            <i class="ico-arrow-right"></i>
                                                        </a>
                                                    </div><!-- /.article-actions -->
						</li><!-- /.article -->
						
                                                
                                                <?PHP
                                                }
                                                ?>
                                                
                                                
                                                
						<li class="article">
							<ul class="list-checkboxes">
								<li>
									<div class="checkbox">
										<input type="checkbox" name="field-5#" id="field-5#">
										
										<label class="form-label" for="field-5#">1#</label>
									</div><!-- /.checkbox -->
								</li>
							</ul><!-- /.list-checkboxes -->
							
							<span class="ico-article">
								<i class="ico-book"></i>
							</span>

							<div class="article-image">
								
								<img src="css/images/temp/article-avatar5.png" height="80" width="80" alt="" class="article-avatar">
							</div><!-- /.article-image -->
							
							<div class="article-content">
								<p>Percy Morgan published “How HR Works” in “Human Resource Executive” on 6/16/2015</p>

								<div class="socials">
									<ul>
										<li>
											<a href="#" class="note">
												<i class="ico-note"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="upload">
												<i class="ico-upload"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="salesforce">
												<i class="ico-salesforce"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="twitter">
												<i class="ico-twitter"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="linkedin">
												<i class="ico-linkedin"></i>
											</a>
										</li>
									</ul>
								</div><!-- /.socials -->
							</div><!-- /.article-content -->
							
							<div class="article-actions">
								<a href="#" class="btn btn-primary">
									<span>Email now</span>
									
									<i class="ico-arrow-right"></i>
								</a>
							</div><!-- /.article-actions -->
						</li><!-- /.article -->
						
						<li class="article article-secondary">
							<ul class="list-checkboxes">
								<li>
									<div class="checkbox">
										<input type="checkbox" name="field-6#" id="field-6#">
										
										<label class="form-label" for="field-6#">1#</label>
									</div><!-- /.checkbox -->
								</li>
							</ul><!-- /.list-checkboxes -->

							<span class="ico-article">
								<i class="ico-cash"></i>
							</span>

							
							<div class="article-content-secondary">
								<a href="#" class="logo-cashstar">Cashstar</a>
								
								<div class="article-inner-secondary">
									<p>CashStar raised M on 08/05/2015</p>
									
									<div class="socials">
											
											<ul>
												<li>
													<a href="#" class="note">
														<i class="ico-note"></i>
													</a>
												</li>
												
												<li>
													<a href="#" class="upload"><i class="ico-upload"></i></a>
												</li>
											</ul>
									</div><!-- /.socials-secondary -->
								</div><!-- /.article-inner-secondary -->
							</div><!-- /.article-content-secondary -->

							<div class="article-inner">
								<div class="article-image">
									<a href="#">
										<img src="css/images/temp/article-avatar6.png" height="80" width="80" alt="" class="article-avatar">
									</a>
								</div><!-- /.article-image -->
								
								<div class="article-content">
									<p>Ben Kaplan, Chief Executive Officer at CashStar, <br/> is the decision maker</p>
								
									<div class="socials">
										<ul>
											<li>
												<a href="#" class="salesforce">
													<i class="ico-salesforce"></i>
												</a>
											</li>
											
											<li>
												<a href="#" class="twitter">
													<i class="ico-twitter"></i>
												</a>
											</li>
											
											<li>
												<a href="#" class="linkedin">
													<i class="ico-linkedin"></i>
												</a>
											</li>
										</ul>
									</div><!-- /.socials -->
								</div><!-- /.article-content -->
							</div><!-- /.article-inner -->
							
							<div class="article-actions">
								<a href="#" class="btn btn-primary">
									<span>Email now</span>
									
									<i class="ico-arrow-right"></i>
								</a>
							</div><!-- /.article-actions -->
						</li><!-- /.article -->
						
						<li class="article">
							<ul class="list-checkboxes">
								<li>
									<div class="checkbox">
										<input type="checkbox" name="field-7#" id="field-7#">
										
										<label class="form-label" for="field-7#">1#</label>
									</div><!-- /.checkbox -->
								</li>
							</ul><!-- /.list-checkboxes -->
							
							<span class="ico-article">
								<i class="ico-forma"></i>
							</span>

							<div class="article-image">
								
								<img src="css/images/temp/article-avatar7.png" height="80" width="80" alt="" class="article-avatar">
							</div><!-- /.article-image -->
							
							<div class="article-content">
								<p>Coca-Cola looking to hire CHRO in Atlanta, GA– published on 6/15/2015</p>

								<div class="socials">
									<ul>
										<li>
											<a href="#" class="note">
												<i class="ico-note"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="upload">
												<i class="ico-upload"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="twitter">
												<i class="ico-twitter"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="linkedin">
												<i class="ico-linkedin"></i>
											</a>
										</li>
									</ul>
								</div><!-- /.socials -->
							</div><!-- /.article-content -->
							
							<div class="article-actions">
								<a href="#" class="btn btn-primary btn-secondary">
									<span>Apllay now</span>
									
									<i class="ico-arrow-right"></i>
								</a>
							</div><!-- /.article-actions -->
						</li><!-- /.article -->
						
						<li class="article">
							<ul class="list-checkboxes">
								<li>
									<div class="checkbox">
										<input type="checkbox" name="field-8#" id="field-8#">
										
										<label class="form-label" for="field-8#">1#</label>
									</div><!-- /.checkbox -->
								</li>
							</ul><!-- /.list-checkboxes -->
							
							<span class="ico-article ico-article-secondary">
								<i class="ico-desk"></i>
							</span>

							<div class="article-image">
								
								<img src="css/images/temp/article-avatar8.png" height="80" width="80" alt="" class="article-avatar">
							</div><!-- /.article-image -->
							
							<div class="article-content">
								<p>HCI Talent Acquisition taking place in New York on 6/15/2015, convening CHROs in North America</p>

								<div class="socials">
									<ul>
										<li>
											<a href="#" class="note">
												<i class="ico-note"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="upload">
												<i class="ico-upload"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="twitter">
												<i class="ico-twitter"></i>
											</a>
										</li>
										
										<li>
											<a href="#" class="linkedin">
												<i class="ico-linkedin"></i>
											</a>
										</li>
									</ul>
								</div><!-- /.socials -->
							</div><!-- /.article-content -->
							
							<div class="article-actions">
								<a href="#" class="btn btn-primary ">
									<span>Register now</span>
									
									<i class="ico-arrow-right"></i>
								</a>

								<a href="#" class="btn btn-primary btn-secondary">
									<span>Sponsor</span>
									
									<i class="ico-arrow-right"></i>
								</a>
							</div><!-- /.article-actions -->
						</li><!-- /.article -->
					</ul><!-- /.articles -->
				</div><!-- /.section-body -->

				<div class="section-foot">
					<a href="#" class="btn-prev">
						<i class="ico-arrow-left"></i>

						<span>Prev page</span>
					</a>

					<a href="#" class="btn-next">
						<span>Next page</span>
						
                                                <?PHP
                                                $main_page = "home.php";
                                                $p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
                                                $items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
                                                $total_data = "";
                                                
                                                
                                                 //echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&items_per_page='.$items_per_page);
                                                ?>
                                                
						<i class="ico-arrow-right"></i>
					</a>
				</div><!-- /.section-foot -->
			</section><!-- /.section-primary -->
		</div><!-- /.content -->
	</div><!-- /.main -->

</div><!-- /.wrapper -->
</body>
</html>
