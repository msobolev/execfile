<?PHP include("header.php"); ?>
    <div class="main">
        <?PHP
        $pg_int_parameters = "";
        if(isset($_GET['from_date']) && $_GET['from_date'] != '')
        {
            $from_date_initial = $_GET['from_date'];
            $from_year = substr($from_date_initial,6,4);
            $from_month = substr($from_date_initial,0,2);
            $from_day = substr($from_date_initial,3,2);
            $from_date = $from_year."-".$from_month."-".$from_day;
            $pg_int_parameters .= "&from_date=".$from_date_initial;
        }
        if(isset($_GET['to_date']) && $_GET['to_date'] != '')
        {
            $to_date_initial = $_GET['to_date'];
            $to_year = substr($to_date_initial,6,4);
            $to_month = substr($to_date_initial,0,2);
            $to_day = substr($to_date_initial,3,2);
            $to_date = $to_year."-".$to_month."-".$to_day;
            $pg_int_parameters .= "&to_date=".$to_date_initial;
        }
        
        
        if(isset($_GET['zip']) && $_GET['zip'] != '')
        {
            $zip = $_GET['zip'];
            $pg_int_parameters .= "&zip=".$zip;
        }
        
        if(isset($_GET['searchnow']) && $_GET['searchnow'] != '')
        {
            $searchnow = $_GET['searchnow'];
            $pg_int_parameters .= "&searchnow=".$searchnow;
        }
        
        if(isset($_GET['companyval']) && $_GET['companyval'] != '')
        {
            $companyval = $_GET['companyval'];
            $pg_int_parameters .= "&companyval=".$companyval;
        }
        
        
        if(isset($_GET['city']) && $_GET['city'] != '')
        {
            $city = $_GET['city'];
            $pg_int_parameters .= "&city=".$searchnow;
        }
        
        if(isset($_GET['industries']) && $_GET['industries'] != '')
        {
            $industries = $_GET['industries'];
            $pg_int_parameters .= "&industries=".$industries;
            $industries_ids = trim($industries,",");
        }
        
        
        if(isset($_GET['states']) && $_GET['states'] != '')
        {
            $states_para = $_GET['states'];
            $pg_int_parameters .= "&states=".$states_para;
            $state_ids = trim($states_para,",");
        }
        
        if(isset($_GET['revenue']) && $_GET['revenue'] != '')
        {
            $revenue = $_GET['revenue'];
            
            $pg_int_parameters .= "&revenue=".$revenue;
        }
        
        include("left.php"); 
        
        
        if(isset($_GET['type']) && $_GET['type'] != '')
        {    
            $type = trim($_GET['type']);
            $pg_int_parameters .= "&type=".$type;
        }    
        else
        {    
            $type = "all";
        }
        
        if(isset($_GET['func']) && $_GET['func'] != '')
        {    
            $func = $_GET['func'];
            $pg_int_parameters .= "&func=".$func;
            
            if($func == 'it')
                $personal_pic_root = "https://www.ctosonthemove.com/";
            
            if($func == 'cfo')
                $personal_pic_root = "https://www.cfosonthemove.com/";
            
            if($func == 'cmo')
                $personal_pic_root = "https://www.cmosonthemove.com/";
            
            if($func == 'clo')
                $personal_pic_root = "https://www.closonthemove.com/";
        }    
        else
        {    
            $func = "";
            $personal_pic_root = "https://www.hrexecsonthemove.com/";
        }    
        $company_pic_root = "https://www.ctosonthemove.com/";
        
        
        
        //echo "<br>pg_int_parameters: ".$pg_int_parameters;
        
        //$all_data = get_all_data('',"$type");
        $all_data = get_all_data('',"$type",$func,$from_date,$to_date,$zip,$searchnow,$city,$companyval,$industries_ids,$state_ids);
        $all_data_count = count($all_data);
        //echo "<br>all_data_count: ".$all_data_count;
        ?>
        <input type="hidden" name="type" id="type" value="<?=$_GET['type']?>">
        <input type="hidden" name="hidden_industires" id="hidden_industires" value="<?=$_GET['industries']?>">
        <input type="hidden" name="hidden_states" id="hidden_states" value="<?=$states_para?>">
        
        <div class="content" style="padding-left:323px;">
            <section class="section-primary">
                <header class="section-head" style="min-width:900px;left:333px;">
                    <form class="form-tags">
                        <p>
                            <label class="form-label hidden">Tags</label>
                            
                            <?PHP
                            if($func == '')
                                $filters = "HR";
                            elseif($func == 'it')
                                $filters = "IT";
                            else
                                $filters = ucfirst($func);
                            
                            
                            if($type != '')
                            {
                                if($type == 'movements')    
                                    $filters .= ",Appointments";
                                else
                                    $filters .= ",".ucfirst($type);
                            }
                            
                            if($from_date != '')
                                $filters .= ",".$from_date;
                            if($to_date != '')
                                $filters .= " - ".$to_date;
                            
                            ?>
                            <input id="tags_1" type="text" class="tags" value="<?=$filters?>" /> 
                            <!-- <input id="tags_1" type="text" class="tags" value="HR,Appointments,May 2014 – May 2015,Business Services,Rev $10 - $50 million" /> -->
                        </p>
                    </form>

                    <p class="records"><?=$all_data_count?> records</p>
                </header><!-- /.section-head -->

                <div class="section-body">
                    <ul class="articles">
                    <?PHP
                    //foreach($speaking_arr as $id=>$data_arr)
                    if($p == 1)
                    {    
                        $starting_point = 0;
                    }    
                    else
                    {
                        $starting_point = ($items_per_page*($p-1));
                    }    
                    $ending_point = $starting_point+$items_per_page;
                    //foreach($all_data as $id=>$data_arr)

                    //echo "<br>starting_point:".$starting_point;
                    //echo "<br>starting_point:".$ending_point;
                    $total_data = count($all_data);

                    for($i=$starting_point;$i<$ending_point;$i++)
                    { 

                        if($all_data[$i]['type'] == 'speaking')
                        {
                            $converted_date = date("M d, Y", strtotime($all_data[$i]['event_date']));

                            $personalURL = "";
                            $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];

                            $sf = "";
                            $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); 
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
                                    if($all_data[$i]['personal_image'] != '')
                                    {    
                                    ?>
                                        <img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                    <?PHP
                                    }
                                    else
                                    {    
                                    ?>
                                        <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
                                    <?PHP
                                    }
                                    ?>
                                </div><!-- /.article-image -->

                                <div class="article-content">
                                    <p><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?> scheduled to speak at <?=$all_data[$i]['event']?> on <?=$converted_date?></p>
                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['speaking_link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?=$sf?>" class="salesforce">
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$twitter_share_link?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$linkedin_share_link?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                            </li><!-- /.article -->
                            <?PHP
                            }
                            if($all_data[$i]['type'] == 'awards')
                            {
                                
                                show_awards($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['awards_title'],$all_data[$i]['awards_given_by'],$all_data[$i]['awards_date'],$all_data[$i]['awards_link'],$personal_pic_root);
                            
                            }
                            //foreach($awards_arr as $id=>$data_arr)
                            //{ 
                            if($all_data[$i]['type'] == 'movement')
                            {
                                //echo "<br>Title: ".$all_data[$i]['title'];
                                show_movements($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['move_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['movement_type'],$all_data[$i]['more_link'],$all_data[$i]['personal_image'],$personal_pic_root);
                               ?> 
                        <?PHP
                            }
                            if($all_data[$i]['type'] == 'funding')
                            {
                                //$personalURL = "";
                                //$converted_date = date("M d, Y", strtotime($all_data[$i]['awards_date']));
                                //$personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];

                                $dim_url = "";
                                $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $all_data[$i]['company_name']).'_Company_'.$all_data[$i]['company_id'];

                                $sf = "";
                                $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).

                                $share_text = $all_data[$i]['company_name']." raised ".$all_data[$i]['funding_amount']." and ".$all_data[$i]['first_name']." ".$all_data[$i]['last_name']." is the decision maker";

                            ?>
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
                                    <!-- <a href="#" class="logo-cashstar">Cashstar</a> -->
                                    <a href="#" class="logo-cashstar"><img src="https://www.ctosonthemove.com/company_logo/thumb/<?=$all_data[$i]['company_logo']?>"></a>
                                    <div class="article-inner-secondary">
                                        <p><?=$all_data[$i]['company_name']?> raised <?=$all_data[$i]['funding_amount']?> on <?=$all_data[$i]['funding_date']?></p>
                                        <div class="socials">
                                            <ul>
                                                <li>
                                                    <a target="_blank" href="<?=$profile_root_link.$dim_url?>" class="note">
                                                        <i class="ico-note"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a target="_blank" href="<?=$all_data[$i]['funding_source']?>" class="upload"><i class="ico-upload"></i></a>
                                                </li>
                                            </ul>
                                        </div><!-- /.socials-secondary -->
                                    </div><!-- /.article-inner-secondary -->
                                </div><!-- /.article-content-secondary -->

                                <div class="article-inner">
                                    <div class="article-image">
                                        <a href="#">
                                            <?PHP
                                            if($all_data[$i]['personal_image'] != '')
                                            {    
                                            ?>
                                                <img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                            <?PHP
                                            }
                                            else
                                            {    
                                            ?>   
                                                <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
                                            <?PHP
                                            }
                                           ?>         
                                        </a>
                                    </div><!-- /.article-image -->

                                    <div class="article-content">
                                        <p><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?>, <?=$all_data[$i]['title']?> at <?=$all_data[$i]['company_name']?>, is the decision maker</p>

                                        <div class="socials">
                                            <ul>
                                                <li>
                                                    <a href="<?=$sf?>" class="salesforce">
                                                        <i class="ico-salesforce"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a href="<?=$twitter_share_link?>text=<?=$share_text?>&url=<?=$all_data[$i]['funding_source']?>" class="twitter">
                                                        <i class="ico-twitter"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <!-- <a href="<?=$linkedin_share_link?>summary=fddffs&url=<?=$all_data[$i]['funding_source']?>" class="linkedin"> -->
                                                    <a href="http://www.linkedin.com/shareArticle?mini=true&title=tttttt&url=<?=$all_data[$i]['funding_source']?>&summary=summm&source=" class="linkedin">
                                                        <i class="ico-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div><!-- /.socials -->
                                    </div><!-- /.article-content -->
                                </div><!-- /.article-inner -->

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your funding round." target="_blank" class="btn btn-primary">
                                    <!--	<a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                            </li><!-- /.article -->

                        <?PHP
                            }
                            if($all_data[$i]['type'] == 'jobs')
                            {
                                //$personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];
                                //$sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).
                                //$converted_date = date("M d, Y", strtotime($all_data[$i]['awards_date']));

                                $dim_url = "";
                                $dim_url = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''), $all_data[$i]['company_name']).'_Company_'.$all_data[$i]['company_id'];
                            ?>
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

                                        <?PHP
                                        if($all_data[$i]['company_logo'] != '')
                                        {    
                                        ?>
                                            <img src="<?=$company_pic_root?>/company_logo/org/<?=$all_data[$i]['company_logo']?>" height="80" width="80" alt="" class="article-avatar">
                                        <?PHP
                                        }
                                        else
                                        {    
                                        ?>   
                                            <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
                                        <?PHP
                                        }
                                       ?> 
                                    </div><!-- /.article-image -->

                                    <div class="article-content">
                                        <p><?=$all_data[$i]['company_name']?> looking to hire <?=$all_data[$i]['job_title']?> in <?=$all_data[$i]['location']?>– published on <?=$all_data[$i]['post_date']?></p>

                                        <div class="socials">
                                            <ul>
                                                <li>
                                                    <a href="<?=$profile_root_link.$dim_url?>" class="note">
                                                        <i class="ico-note"></i>
                                                    </a>
                                                </li>
                                                <?PHP
                                                if($all_data[$i]['source'] != '')
                                                {    
                                                ?>
                                                <li>
                                                    <a target="_blank" href="<?=$all_data[$i]['source']?>" class="upload">
                                                        <i class="ico-upload"></i>
                                                    </a>
                                                </li>
                                                <?PHP
                                                }
                                                ?>
                                                

                                                <li>
                                                    <a target="_blank" href="<?=$twitter_share_link?>" class="twitter">
                                                        <i class="ico-twitter"></i>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a target="_blank" href="<?=$linkedin_share_link?>" class="linkedin">
                                                        <i class="ico-linkedin"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div><!-- /.socials -->
                                    </div><!-- /.article-content -->

                                    <div class="article-actions">
                                        <a href="<?=$all_data[$i]['source']?>" class="btn btn-primary btn-secondary">
                                            <span>Apply now</span>
                                            <i class="ico-arrow-right"></i>
                                        </a>
                                    </div><!-- /.article-actions -->
                                </li><!-- /.article -->

                            <?PHP
                            }

                            if($all_data[$i]['type'] == 'publication')
                            {
                                $personalURL = "";
                                $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];

                                $sf = "";
                                $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['move_title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).

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
                                <?PHP
                                if($all_data[$i]['personal_image'] != '')
                                {    
                                ?>
                                    <img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                <?PHP
                                }
                                else
                                {    
                                ?>    
                                    <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
                                <?PHP
                                }
                                ?>
                                </div><!-- /.article-image -->

                                <div class="article-content">
                                    <p><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?> published "<?=$all_data[$i]['title']?>" on <?=$all_data[$i]['publication_date']?></p>

                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$sf?>" class="salesforce">
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$twitter_share_link?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$linkedin_share_link?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                            </li><!-- /.article -->
                            <?PHP    
                            }
                            if($all_data[$i]['type'] == 'media_mention')
                            {
                                $personalURL = "";
                                $personalURL = trim($all_data[$i]['first_name']).'_'.trim($all_data[$i]['last_name']).'_Exec_'.$all_data[$i]['personal_id'];

                                $sf = "";
                                $sf = EXECFILE_ROOT."/salesforce/oauth.php?fname=".urlencode($all_data[$i]['first_name'])."&lname=".urlencode($all_data[$i]['last_name'])."&company_name=".urlencode($all_data[$i]['company_name'])."&title=".urlencode($all_data[$i]['title'])."&email=".urlencode($all_data[$i]['email'])."&phone=".urlencode($all_data[$i]['phone']); //."&phone=".urlencode($sf_phone).

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
                                    if($all_data[$i]['personal_image'] != '')
                                    {    
                                    ?>
                                        <img src="<?=$personal_pic_root?>personal_photo/small/<?=$all_data[$i]['personal_image']?>" height="80" width="80" alt="" class="article-avatar">
                                    <?PHP
                                    }
                                    else
                                    {    
                                    ?>    
                                        <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
                                    <?PHP
                                    }
                                    ?>
                                </div><!-- /.article-image -->

                                <div class="article-content">
                                    <p><?=$all_data[$i]['first_name']?> <?=$all_data[$i]['last_name']?> was quoted by <?=$all_data[$i]['publication']?> on <?=$all_data[$i]['pub_date']?></p>

                                    <div class="socials">
                                        <ul>
                                            <li>
                                                <a target="_blank" href="<?=$profile_root_link.$personalURL?>" class="note">
                                                    <i class="ico-note"></i>
                                                </a>
                                            </li>


                                            <?PHP
                                            if($all_data[$i]['more_link'] != '')
                                            {    
                                            ?>
                                            <li>
                                                <a target="_blank" href="<?=$all_data[$i]['more_link']?>" class="upload">
                                                    <i class="ico-upload"></i>
                                                </a>
                                            </li>
                                            <?PHP
                                            }
                                            ?>


                                            <li>
                                                <a target="_blank" href="<?=$sf?>" class="salesforce">
                                                    <i class="ico-salesforce"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$twitter_share_link?>" class="twitter">
                                                    <i class="ico-twitter"></i>
                                                </a>
                                            </li>

                                            <li>
                                                <a target="_blank" href="<?=$linkedin_share_link?>" class="linkedin">
                                                    <i class="ico-linkedin"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div><!-- /.socials -->
                                </div><!-- /.article-content -->

                                <div class="article-actions">
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                            </li><!-- /.article -->
                            <?PHP
                            }
                        }
                        if(1 == 2)
                        {    
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
                                    <img src="<?=NO_PERSONAL_IMAGE?>" height="80" width="80" alt="" class="article-avatar">
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
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                    <!-- <a href="#" class="btn btn-primary"> -->
                                        <span>Email now</span>
                                        <i class="ico-arrow-right"></i>
                                    </a>
                                </div><!-- /.article-actions -->
                            </li><!-- /.article -->
                            <?PHP
                                }

                            ?>



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
                                    <a href="mailto:<?=$all_data[$i]['email']?>?subject=Congrats&amp;body=Congrats on your appointment" target="_blank" class="btn btn-primary">
                                    <!--	<a href="#" class="btn btn-primary"> -->
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

                            <?PHP
                            }
                            ?>

                    </ul><!-- /.articles -->
                </div><!-- /.section-body -->

                <div class="section-foot">
                    <!--
                        <a href="#" class="btn-prev">
                            <i class="ico-arrow-left"></i>
                            <span>Prev page</span>
                        </a>

                        <a href="#" class="btn-next">
                            <span>Next page</span>
                            <i class="ico-arrow-right"></i>
                        </a>
                    -->
                    <?PHP
                    //echo "<br>pg_int_parameters: ".$pg_int_parameters;
                    echo number_pages($main_page, $p, $total_data, 0, $items_per_page,'&items_per_page='.$items_per_page.$pg_int_parameters);
                    ?>
                </div><!-- /.section-foot -->
            </section><!-- /.section-primary -->
        </div><!-- /.content -->
    </div><!-- /.main -->

<?PHP include("footer.php"); ?>


<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));</script>


</html>
