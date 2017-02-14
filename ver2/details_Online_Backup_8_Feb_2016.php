<?PHP 
session_start();
include("header.php"); 
$id = $_GET['id'];
$type = $_GET['type'];

$all_data = get_all_data($id,$type);
$all_data_count = count($all_data);

//echo "<pre>all_data: ";   print_r($all_data);   echo "</pre>";
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>";

$show_other_content = 0;
if(isset($_GET['sc']) && $_GET['sc'] == 1)
    $show_other_content = 1;
$outer_div_style = '';
$other_content = '';
if($show_other_content == 1)
{
    $outer_div_style = 'border:1px solid #ced7df;border-radius:8px;margin-bottom:60px;float:left;';
    
    $other_content = '<div style=float:left;width:150px;margin-left:45px;><img src=https://buffer.com/dashboard/safeimage?width=100&height=100&url=https%3A%2F%2Fwww.conference-board.org%2Fimages%2Fproducts%2Fconferences%2Fsponsorlogo%2FAppirio_mobile_05112015.png&hash=944525aa54c1a47c8a1453d9f350df69></div><div style=float:left;width:75%;margin-bottom:25px;font-weight:700;>16th Annual Talent Management Strategies Conference<br><span style=font-size:12px;color:#59626a;font-weight:400;font-size:13px;>Innovation and Insights: Megatrends in Talent Management</span></div>';
}

?>
    <div class="main">
        <?PHP //include("left.php"); ?>
        <div class="content" style="width:990px;margin:0 auto;padding-left:0px;">
            <section class="section-primary" style="max-width:990px;">
                <div class="section-body" style="padding-top:20px;<?=$outer_div_style?>">
                    <ul class="articles">
                        <?PHP
                        //echo "<br>ID: ".$id;
                        //echo "<br>Type: ".$type;
                        //$all_data = get_all_data($id,$type);
                        $i = 0;
                        //echo "<pre>";   print_r($all_data);   echo "</pre>";
                        //echo "<br>title: ".$all_data[$i]['title'];    
                        if($type == 'movements')
                            show_movements($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['move_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['movement_type'],$all_data[$i]['more_link'],$all_data[$i]['personal_image'],$personal_pic_root,'',1);
                        elseif($type == 'awards')
                            show_awards($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['awards_title'],$all_data[$i]['awards_given_by'],$all_data[$i]['awards_date'],$all_data[$i]['awards_link'],$personal_pic_root,'',1);
                        elseif($type == 'speaking')
                            show_speaking($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['event'],$all_data[$i]['speaking_link'],$all_data[$i]['event_date'],$personal_pic_root,'read',1);
                        if($type == 'media_mention')
                            show_media($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['publication'],$all_data[$i]['more_link'],$all_data[$i]['media_link'],$all_data[$i]['pub_date'],$personal_pic_root,'read',1);
                        if($type == 'publication')
                            show_publication($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['move_title'],$all_data[$i]['link'],$all_data[$i]['publication_date'],$personal_pic_root,'read',1);
                        if($type == 'funding')
                            show_funding($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['funding_id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['funding_source'],$all_data[$i]['funding_amount'],$all_data[$i]['funding_date'],$personal_pic_root,'read',1);
                        if($type == 'jobs')
                            show_job($all_data[$i]['first_name'],$all_data[$i]['last_name'],$all_data[$i]['id'],$all_data[$i]['personal_id'],$all_data[$i]['company_id'],$all_data[$i]['company_logo'],$all_data[$i]['company_name'],$all_data[$i]['title'],$all_data[$i]['email'],$all_data[$i]['phone'],$all_data[$i]['personal_image'],$all_data[$i]['job_title'],$all_data[$i]['post_date'],$all_data[$i]['source'],$personal_pic_root,$company_pic_root,$all_data[$i]['show_state'],1);
                        
                        ?>
                    </ul>
                    
                    
                    <?=$other_content?>
                    
                    
                </div><!-- /.section-body -->   
                
                
                
                
                
                
            </section><!-- /.section-primary -->
        </div><!-- /.content -->
    </div><!-- /.main -->    
    
    <div class="footer_links" style="text-align:center;width:100%;color:#8899a6;font-size:14px;position: fixed;bottom: 30px;">
                    
                    © <?=date("Y");?> Execfile&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a target="_blank" href="https://www.hrexecsonthemove.com/why-cto.html">About</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <a href="#">Help</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                    <a href="terms.php">Terms</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="privacy.php">Privacy</a>
                </div><br>
    
    
    <?PHP
//echo "<br>details_pos bottom : ".$details_pos;
if($details_pos > -1)
{
    ?>
    <script language="javascript">
        $(".content").css("padding-top", "10px");
        //$(".content").css("padding-left", "250px");
    </script>    
    <?PHP
}    


?>