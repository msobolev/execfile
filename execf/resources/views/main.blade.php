<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Execfile</title>
        <link rel="stylesheet" href="<?PHP echo asset('home_style.css'); ?>" type="text/css" >
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    </head>    
    <body>
    
    <div class="wrapper">
    <div class="bar">
        <div class="shell">
            <nav class="nav-access">
                <ul>
                    <li>
                        
                        <a href="login">Login</a>
                        
                        
                    </li>

                    
                    
                    <li class="blue">
                        <a href="#joind_100s">Sign Up</a>
                    </li>
                    
                    
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
                    <li ><a href="requestdemop">Request a Demo</a></li> <!-- onclick="req_demo_block()" -->
                        <!-- <a  href="">Request a Demo</a> -->
                    
                </ul>
            </nav><!-- /.nav -->
	
            <a href="#" class="btn-menu">
                <span></span>
            </a>
        </div><!-- /.shell -->
    </header><!-- /.header -->

    
    <div id="rdf_top" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
       
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
                                            {{-- <form action="index.php" method="post" onsubmit="return filter_email('field-email-1');">  --}}
                                            {!! Form::open(['url' => 'requestdemo'])   !!}
                                                <div class="form-body">
                                                    <div class="form-row">
                                                        <label for="field-name" class="form-label hidden">Name </label>

                                                        <div class="form-controls">
                                                            <i class="ico-user"></i>

                                                            {{-- <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name"> --}}
                                                            {!! Form::text('field-name',null,['class' => 'field','placeholder' => 'Name']) !!}
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
                                            
                                            {{ csrf_field() }}    
                                            {!! Form::close()   !!}    
                                        
                                        </div><!-- /.form-sing-up -->
                                    </div><!-- /.intro-content -->
					
					<div class="intro-image">
                                            
                                            <img src="{{ asset('/images/intro-image1.png') }}" >
						
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
                                                    <img src="{{ asset('/images/logo-garther1.png') }}" alt="">
						</li>
						
						<li>
							<img src="{{ asset('/images/logo-grovo.png') }}" alt="">
						</li>
						
						<li>
							<img src="{{ asset('/images/logo-glg.png') }}" alt="">
						</li>
						
						<li>
							<img src="{{ asset('/images/logo-ddi.png') }}" alt="">
						</li>
						
						<li>
							<img src="{{ asset('/images/logo-graebel.png') }}" alt="">
						</li>
						
						<li>
							<img src="{{ asset('/images/logo-skill-survey1.png') }}" alt="">
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
                                {{-- <form action="index.php" method="post" onsubmit="return filter_email('field-email-2');"> --}}
                                {!! Form::open(['url' => 'requestdemo'])   !!}
                                    <div class="form-body">
                                        <div class="form-row">
                                            <div class="form-col">
                                                <label for="field-name" class="form-label hidden">1#</label>

                                                <div class="form-controls">
                                                        <i class="ico-user"></i>

                                                        {{-- <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name"> --}}
                                                        {!! Form::text('field-name',null,['class' => 'field','placeholder' => 'Name']) !!}
                                                </div><!-- /.form-controls -->
                                            </div><!-- /.form-col -->

                                            <div class="form-col">
                                                    <label for="field-email" class="form-label hidden">2#</label>

                                                    <div class="form-controls">
                                                            <i class="ico-mail"></i>

                                                            {{-- <input type="email" class="field" name="field-email" id="field-email-2" value="" placeholder="Work Email"> --}}
                                                            {!! Form::email('field-email',null,['id' => 'field-email','class' => 'field','placeholder' => 'Work Email']) !!}
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
                            <a  id="request_demo_2" href="requestdemop" class="btn btn-primary">Request A Demo</a>  <!-- onclick="change_focus()"   onclick="show_form('two')" -->
                        </div><!-- /.section-content -->

                        <div class="section-image">
                            <img src="{{ asset('/images/image1.png') }}" alt="">
                        </div><!-- /.section-image -->
                    
                    
                        <div id="rdf_top_two" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
                            
                        </div>
                        
                        
                    
                    </div><!-- /.shell -->
		</section><!-- /.section section-primary -->

                
                
                 
                
                
                
		<section class="section section-teritary">
			<div class="shell">
				<div class="section-image">
					<img src="{{ asset('/images/image2.png') }}" alt="">
				</div><!-- /.section-image -->
				
				<div class="section-content">
					<h4>Do You Know What Makes Your Prospects Respond? When You Talk About Them You Can Get up to 5x Higher Response Rate.</h4>

					<p>And we provide the speaking points! You will receive real time updates when your clients get appointed or promoted to key executive roles (with their updated emails), speak at events, receive industry awards, raise funding, get quoted by press, publish articles and books, and more.</p>

					<p>So you will never run out of prospects to reach out to and topics to open your conversation with. This will get you up to 5x higher response rate on your outreach.</p>

					<a  href="requestdemop" class="btn btn-primary">Request A Demo</a> <!-- onclick="show_form('three')" -->
				</div><!-- /.section-content -->
                                
                                
                                
                                <div id="rdf_top_three" style="float:left;width:100%;text-align:right;padding:20px;color:white;display:none;">
                                    
                                </div>
                                
                                
                                
                                
                                
			</div><!-- /.shell -->
		</section><!-- /.section section-teritary -->

		<section class="section section-primary">
			<div class="shell">
				<div class="section-content">
					<h4>We Walk an Extra Mile in Your Shoes. So You Don’t Have to.</h4>

					<p>Persuasion isn’t an easy skill to master. Lucky for you, we do the heavy lifting for you there. Not only we uncover important events in lives of your prospects that are top of mind for them, not only we append industry taxonomy, company size and geo data so that you can precision target your prospects, not only we append new contact details making these insights instantly actionable for you…</p>

					<p>We also help draft the messaging both email and phone based on best practices, hacks and tactics that you will not learn in a book. </p>

					<a href="requestdemop" class="btn btn-primary">Request A Demo</a> <!-- onclick="show_form('four')"  -->
				</div><!-- /.section-content -->
                                
                                
                                
                                
                                
				
				<div class="section-image section-image-primary">
					<img src="{{ asset('/images/image3.png') }}" alt="">
				</div><!-- /.section-image -->
                                
                                <div id="rdf_top_four" style="float:left;width:100%;text-align:left;padding:20px;color:white;display:none;">
                                    
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
						{{-- <form action="index.php"  method="post"  onsubmit="return filter_email('field-email-3');"> --}}
                                                    {!! Form::open(['url' => 'requestdemo'])   !!}
							<div class="form-body">
								<div class="form-row">
									<div class="form-col">
										<label for="field-name" class="form-label hidden">1#</label>
										
										<div class="form-controls">
											<i class="ico-user"></i>

											{{-- <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name"> --}}
                                                                                        {!! Form::text('field-name',null,['class' => 'field','placeholder' => 'Name']) !!}
										</div><!-- /.form-controls -->
									</div><!-- /.form-col -->

									<div class="form-col">
										<label for="field-email" class="form-label hidden">2#</label>
										
										<div class="form-controls">
											<i class="ico-mail"></i>

											{{-- <input type="email" class="field" name="field-email" id="field-email-3" value="" placeholder="Work Email"> --}}
                                                                                        {!! Form::email('field-email',null,['id' => 'field-email','class' => 'field','placeholder' => 'Work Email']) !!}
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
                                    <img src="{{ asset('/images/image4.png') }}" alt="">
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
                                        <img src="{{ asset('/images/logo-gartner.png') }}" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ Keeping our database of contacts and prospects up to date is of critical importance. ExecFile's real time notifications are an integral piece of that process. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar">
                                        <img src="{{ asset('/images/penkoff.jpg') }}" alt="" class="testimonial-image">

                                        <strong class="testimonial-author">Gregory P.</strong>
                                    </div><!-- /.testimonial-avatar -->
                                </li><!-- /.testimonial -->

                                <li class="testimonial" style="width:35%;">
                                    <div class="testimonial-logo">
                                        <img src="{{ asset('/images/logo-skill-survey.png') }}" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ ExecFile file delivered on every promise. We find daily alerts particularly helpful. One of the recent ones helped us engage a prospect we've been chasing for months. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar">
                                        <img src="{{ asset('/images/fuhr-2.png') }}" alt="" class="testimonial-image">
                                        <strong class="testimonial-author">Scott F.</strong>
                                    </div><!-- /.testimonial-avatar -->
                                </li><!-- /.testimonial -->

                                <li class="testimonial" style="width:27%;">
                                    <div class="testimonial-logo" style="padding-top:9px;">
                                        <img style="max-width:none;margin-top:-2px;margin-left:-34px;width:276px;" src="{{ asset('/images/logo-mindtree.png') }}" alt="">
                                    </div><!-- /.testimonial-logo -->

                                    <div class="testimonial-content">
                                        <blockquote>“ We got our money worth in three months on the annual subscription. Can't recommend the service more. ”</blockquote>
                                    </div><!-- /.testimonial-content -->

                                    <div class="testimonial-avatar" style="padding-top:3px;">
                                        <img src="{{ asset('/images/kaul-1.png') }}" alt="" class="testimonial-image">
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
                            {{-- <form action="index.php"  method="post"  onsubmit="return filter_email('field-email-4');"> --}}
                            {!! Form::open(['url' => 'requestdemo'])   !!}
                                <div class="form-body">
                                    <div class="form-row">
                                        <div class="form-col">
                                            <label for="field-name" class="form-label hidden">1#</label>

                                            <div class="form-controls">
                                                <i class="ico-user"></i>

                                                {{-- <input type="text" class="field" name="field-name" id="field-name" value="" placeholder="Name"> --}}
                                                {!! Form::text('field-name',null,['class' => 'field','placeholder' => 'Name']) !!}
                                            </div><!-- /.form-controls -->
                                        </div><!-- /.form-col -->

                                        <div class="form-col">
                                            <label for="field-email" class="form-label hidden">2#</label>

                                            <div class="form-controls">
                                                <i class="ico-mail"></i>

                                                {{-- <input type="email" class="field" name="field-email" id="field-email-4" value="" placeholder="Work Email"> --}}
                                                {!! Form::email('field-email',null,['id' => 'field-email','class' => 'field','placeholder' => 'Work Email']) !!}
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
                                    <a href="\contact-us.php">Contact us</a>
                                </li>

                                <li>
                                    <a href="requestdemop">Schedule a Demo</a>
                                </li>

                                <li>
                                    <a href="\termscondition.php">Terms of Service</a>
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
                    <p class="copyright"> &copy; ExecFile. All Rights Reserved.</p><!-- /.copyright -->
                </div><!-- /.footer-bar -->		

            </div><!-- /.shell -->
	</footer><!-- /.footer -->
    </div><!-- /.wrapper -->
    
    
    
    
    
    
    
    
    
    </body>
</html>    