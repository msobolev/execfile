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

            
            
            
            <?PHP
            $searchnow_display = "";
            if($_GET['searchnow'] != '')
            {    
                $searchnow_display = 'style=display:block;';
            } 
            ?>
            
            <div class="widget-body" <?=$searchnow_display?>>
                <div class="search">
                    <div class="ui-widget form-search">
                        <!-- <form class="form-search"> -->
                        <label for="developer" class="hidden">Search </label>
                        <input id="developer" placeholder="Select Now" class="search-field" value="<?=$_GET['searchnow']?>" onkeypress="return searchKeyPress(event);">
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
                            <a href="home.php?">
                            <?PHP
                            if($_SESSION['site'] == 'cmo')
                            {    
                            ?>
                                CMO
                            <?PHP
                            }
                            elseif($_SESSION['site'] == 'cto')
                            {    
                            ?>
                                CTO
                            <?PHP
                            }
                            elseif($_SESSION['site'] == 'ciso')
                            {    
                            ?>
                                CISO
                            <?PHP
                            }
                            elseif($_SESSION['site'] == 'cso')
                            {    
                            ?>
                                CSO
                            <?PHP
                            }
                            elseif($_SESSION['site'] == 'cfo')
                            {    
                            ?>
                                CFO
                            <?PHP
                            }
                            elseif($_SESSION['site'] == 'clo')
                            {    
                            ?>
                                CLO
                            <?PHP
                            }
                            else
                            {    
                            ?>
                                HR
                            <?PHP
                            }
                            ?>
                            </a>
                        </li>
                    <!--    
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
                    -->
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
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=movements<?=$left_parameters?>">Appointments<span id="movements_unread_count"></span></a>
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=speaking<?=$left_parameters?>">Speaking<span id="speaking_unread_count"></span></a> 
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=media<?=$left_parameters?>">Media Mentions<span id="media_unread_count"></span></a>
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=publication<?=$left_parameters?>">Publications<span id="publication_unread_count"></span></a>
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=awards<?=$left_parameters?>">Industry Awards<span id="award_unread_count"></span></a>
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=funding<?=$left_parameters?>">Funding<span id="funding_unread_count"></span></a>
                        
                    </li>
                    <li>
                        <a href="home.php?from_date=<?=$from_date_initial?>&to_date=<?=$to_date_initial?>&type=jobs<?=$left_parameters?>">Jobs<span id="job_unread_count"></span></a>
                    </li>
                    <!--
                    <li>
                        <a href="#">Conferences</a>
                    </li>
                    -->
                </ul><!-- /.list-alerts -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->

        <li id="timeframe_left" class="widget widget-calendar">
            <div class="widget-head">
                <span class="ico-widget">
                    <i class="ico-calendar"></i>
                </span>

                <h3 class="widget-title">
                    Timeframe
                </h3><!-- /.widget-title -->
            </div><!-- /.widget-head -->
            <?PHP
            $timeframe_display = "";
            if($from_date_initial != '' && $to_date_initial != '')
            {    
                $timeframe_display = 'style=display:block;';
            } 
            ?>
            
            <div class="widget-body" <?=$timeframe_display?>>
                <div class="calendar-holder">
                    <i class="ico-calendar-small"></i>
                    <label class="calendar-label "for="from" >From:</label>
                    <input type="text" id="from" name="from" value="<?=$from_date_initial?>">
                </div><!-- /.calendar-holder -->
                <div class="calendar-holder">
                    <i class="ico-calendar-small"></i>
                    <label class="calendar-label "for="to">To:</label>
                    <input type="text" id="to" name="to" value="<?=$to_date_initial?>">
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

            
            
            
            <?PHP
            $company_display = "";
            if($_GET['companyval'] != '' || $_GET['industries'] != ''  || $_GET['revenue'] != ''  || $_GET['employee_size'] != '')
            {    
                $company_display = 'style=display:block;';
            } 
            ?>
            
            <div class="widget-body" <?=$company_display?>>
                <div class="form-company">
                    <!-- <form action="#" method="post"> -->
                    <div class="form-body">
                        <div class="form-row">
                            <label for="field-company-name" class="form-label  hidden">Company Name/URL</label>
                            <div class="form-controls">
                                <input type="text" class="field" name="field-company-name" id="field-company-name" value="<?=$companyval?>" placeholder="Company Name/URL"  onkeypress="return companyKeyPress(event);">
                            </div><!-- /.form-controls -->
                        </div><!-- /.form-row -->

                        <div class="checkbox-holder">
                            <ul class="list-checkboxes">
                                <?PHP
                                if(isset($_GET['industries']) && $_GET['industries'] != '')
                                {
                                    //$industries = trim($_GET['industries'],",");
                                    $industries = $_GET['industries'];
                                }    
                                foreach($all_industries as $industry_id => $industry_data)
                                { 
                                    if($industry_data['parent_id'] == 0)
                                    {    
                                ?>
                                    <strong class="list-checkboxes-title"><?=$industry_data['title']?></strong><!-- /.list-checkboxes-title -->
                                <?PHP
                                        $search_industry_id = "";
                                        $search_industry_id = $industry_id.",";
                                    }
                                    $checked = "";

                                    if(strpos($industries,$industry_id.",") > -1)
                                    {        
                                       $checked = "checked";
                                    }
                                ?>
                                    <li>
                                        <div class="checkbox">
                                            <input <?=$checked?> type="checkbox" class="industry_chk" name="field-<?=$industry_id?>" id="field-<?=$industry_id?>" onclick="update_search()">
                                            <label class="form-label label-check" for="field-<?=$industry_id?>"><?=$industry_data['title']?></label>
                                        </div><!-- /.checkbox -->
                                    </li>
                                <?PHP
                                }
                                ?>
                            </ul><!-- /.list-checkboxes -->	
                        </div><!-- /.checkbox-holder -->

                        <div class="sliders">
                            <div class="slider-holder">
                                <p>
                                    <label for="amount" class="slider-label">Revenue</label>
                                    <input type="text" id="amount" class="slider-input" value="0 - > $1 bil">
                                </p>
                                <?PHP $set_vall = 6; ?>                            
                                <div id="slider-range" class="slider-range" data-truevalues="0, $1 mil, $10 mil, $50 mil, $100 mil, $250 mil, $500 mil, $1 bil, > $1 bil" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
                            </div><!-- /.slider-holder -->

                            <div class="slider-holder">
                                <p>
                                    <label for="amount2" class="slider-label">Employees</label>
                                    <input type="text" id="amount2" class="slider-input" value="1 - >100K">
                                </p>
                                <div id="slider-range-secondary" class="slider-range" data-truevalues="0, 25, 100, 250, 1k, 10k, 50k, 100k, > 100k" data-values="0, 1, 2, 3, 4, 5, 6, 7, 8"></div>
                            </div><!-- /.slider-holder -->
                        </div><!-- /.sliders -->
                    </div><!-- /.form-body -->
                    <!-- </form> -->
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

            <?PHP
            //echo "<pre>GET: ";   print_r($_GET);   echo "</pre>";
            $location_display = "";
            
            $location_only_display = "";
            
            if($_GET['city'] != '' || $_GET['states'] != '' || $_GET['zip'] != '')
            {    
                $location_display = 'style=display:block;';
                $location_only_display = 'display:block;';
            } 
             
             
            ?>
            
            
            <div class="widget-body" <?=$location_display?>>
                <div class="form-location">
                    <!-- <form action="#" method="post"> -->
                        <div class="form-body">
                            <div class="form-row">
                                <label for="city" class="form-label">City</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-city" id="city" value="<?=$_GET['city']?>" onkeypress="return cityKeyPress(event);">
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
                            <div class="widget-body" style="padding:17px 5px;<?=$location_only_display?>">
                                <div class="form-company">
                                    <!-- <form action="#" method="post"> -->
                                    <div class="form-body">
                                        <div class="checkbox-holder">
                                            <ul class="list-checkboxes">
                                                <strong class="list-checkboxes-title">State</strong><!-- /.list-checkboxes-title -->
                                                <?PHP
                                                if(isset($_GET['states']) && $_GET['states'] != '')
                                                {
                                                    //$industries = trim($_GET['industries'],",");
                                                    $states = $_GET['states'];
                                                } 
                                                $states_arr = explode(",",$_GET['states']);
                                                foreach($all_states as $state_id => $short_name)
                                                {
                                                    //echo "<br>short_id: ".$state_id;
                                                    //echo "<br>short_name: ".$short_name;
                                                    $state_checked = "";
                                                    
                                                    
                                                    //if(strpos($states,$state_id.",") > -1)
                                                    if(in_array($state_id,$states_arr))
                                                    {        
                                                       $state_checked = "checked";
                                                    }
                                                    
                                                ?>
                                                <li>
                                                    <div class="checkbox">
                                                        <input <?=$state_checked?> type="checkbox" class="state_chk" name="state-<?=$state_id?>" id="state-<?=$state_id?>"  onclick="update_state_search()">
                                                        <label class="form-label label-check" for="state-<?=$state_id?>"><?=$short_name?></label>
                                                    </div>
                                                </li>
                                                <?PHP
                                                }
                                                ?>
                                            </ul><!-- /.list-checkboxes -->	


                                        </div><!-- /.checkbox-holder -->


                                    </div><!-- /.form-body -->
                                    <!-- </form> -->
                                </div><!-- /.form-company -->
                            </div><!-- /.widget-body -->   
                            <!-- state selectbox ends -->
                            
                            <?PHP
                            //echo "<pre>GET: ";   print_r($_GET);   echo "</pre>";
                            ?>

                            <div class="form-row">
                                <label for="field-zip" class="form-label">ZIp</label>
                                <div class="form-controls">
                                    <input type="text" class="field" name="field-zip" id="zip" value="<?=$_GET['zip']?>"  onkeypress="return zipKeyPress(event);" >
                                </div><!-- /.form-controls -->
                            </div><!-- /.form-row -->
                        </div><!-- /.form-body -->
                    <!-- </form> -->
                </div><!-- /.fomr-location -->
            </div><!-- /.widget-body -->
        </li><!-- /.widget -->
    </ul><!-- /.widgets -->
</div><!-- /.sidebar -->
                
                
                
                