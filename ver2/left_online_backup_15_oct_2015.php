<?PHP
$all_states = get_all_states();
$all_industries = get_all_industries();
//echo "<pre>all_industries: ";   print_r($all_industries);   echo "</pre>";
?>
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
                    <div class="ui-widget form-search">
                        <!-- <form class="form-search"> -->
                        <label for="developer" class="hidden">Search </label>
                        <input id="developer" placeholder="Select Now" class="search-field" onkeypress="return searchKeyPress(event);">
                        <!-- </form>  -->
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
                    Function
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->

            <div class="widget-body">
                <nav class="widget-nav">
                    <ul>
                        <li>
                            <a href="home.php?">HR</a>
                        </li>

                        <li>
                            <a href="home.php?func=cfo">Finance</a>
                        </li>

                        <li>
                            <a href="home.php?func=cmo">Marketing</a>
                        </li>

                        <li>
                            <a href="home.php?func=it">IT</a>
                        </li>

                        <li>
                            <a href="home.php?func=clo">Legal</a>
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

            <?PHP
            $left_parameters = "";
            if(isset($_GET['func']) && $_GET['func'] != '')
            {
                $left_parameters .= "&func=".$_GET['func'];
            }    
            ?>
            
            <div class="widget-body">
                <ul class="list-alerts">
                    <li>
                        <a href="home.php?type=movements<?=$left_parameters?>">Appointments<span>6</span></a>
                    </li>
                    <li>
                        <a href="home.php?type=speaking<?=$left_parameters?>">Speaking</a> 
                    </li>
                    <li>
                        <a href="home.php?type=media<?=$left_parameters?>">Media Mentions</a>
                        <span>3</span>
                    </li>
                    <li>
                        <a href="home.php?type=publication<?=$left_parameters?>">Publications</a>
                    </li>
                    <li>
                        <a href="home.php?type=awards<?=$left_parameters?>">Industry Awards</a>
                    </li>
                    <li>
                        <a href="home.php?type=funding<?=$left_parameters?>">Funding</a>
                        <span>3</span>
                    </li>
                    <li>
                        <a href="home.php?type=jobs<?=$left_parameters?>">Jobs</a>
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
                    <input type="text" id="from" name="from" value="<?=$from_date?>">
                </div><!-- /.calendar-holder -->
                <div class="calendar-holder">
                    <i class="ico-calendar-small"></i>
                    <label class="calendar-label "for="to">To:</label>
                    <input type="text" id="to" name="to" value="<?=$to_date?>">
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
                                    <input type="text" class="field" name="field-company-name" id="field-company-name" value="" placeholder="Company Name/URL"  onkeypress="return companyKeyPress(event);">
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
                    <!-- <form action="#" method="post"> -->
                        <div class="form-body">
                            <div class="form-row">
                                <label for="city" class="form-label">City</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-city" id="city" value="" onkeypress="return cityKeyPress(event);">
                                </div><!-- /.form-controls -->
                            </div><!-- /.form-row -->
                            
                            
                            
                            <!--
                            <div class="form-row">
                                <label for="field-state" class="form-label">State</label>
                                <div class="form-controls">
                                    <select name="field-state" class="select dropkick" id="field-state">
                                        <option value="">Any</option>
                                    </select>
                                </div>
                            </div>
                            -->
                            
                            
                            <!-- state selectbox starts -->
                            <div class="widget-body" style="padding:17px 5px;">
                                <div class="form-company">
                                    <form action="#" method="post">
                                        <div class="form-body">



                                            <div class="checkbox-holder">
                                                <ul class="list-checkboxes">
                                                    <strong class="list-checkboxes-title">State</strong><!-- /.list-checkboxes-title -->
                                                    <?PHP
                                                    foreach($all_states as $state_id => $short_name)
                                                    {
                                                        //echo "<br>short_id: ".$state_id;
                                                        //echo "<br>short_name: ".$short_name;
                                                    ?>
                                                    <li>
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="field-<?=$short_name?>" id="field-<?=$short_name?>">
                                                            <label class="form-label label-check" for="field-<?=$short_name?>"><?=$short_name?></label>
                                                        </div>
                                                    </li>
                                                    <?PHP
                                                    }
                                                    ?>
                                                </ul><!-- /.list-checkboxes -->	


                                            </div><!-- /.checkbox-holder -->


                                        </div><!-- /.form-body -->
                                    </form>
                                </div><!-- /.form-company -->
                            </div><!-- /.widget-body -->   
                            <!-- state selectbox ends -->
                            
                            

                            <div class="form-row">
                                <label for="field-zip" class="form-label">ZIp</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-zip" id="zip" value=""  onkeypress="return zipKeyPress(event);" >
                                </div><!-- /.form-controls -->
                            </div><!-- /.form-row -->
                        </div><!-- /.form-body -->
                    <!-- </form> -->
                </div><!-- /.fomr-location -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->
    </ul><!-- /.widgets -->
</div><!-- /.sidebar -->
                
                
                
                