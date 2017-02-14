<?php
session_start();
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
//echo "<pre>session: ";   print_r($_SESSION);   echo "</pre>"; die();
$action = $_REQUEST['action'];

include("header-content-page.php");
include("config.php");
include("functions.php");

if($_SESSION['sess_user_id'] == '')
{
    //com_redirect("index.php");
}    


//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

?>	 
    <div class="email-alert" style="padding-top:85px;">
        <div class="page-head" style="padding-top:0px;">
            <div class="shell">
                

                <h2>Create an Email Alert</h2>
            </div><!-- /.shell -->
        </div><!-- /.page-head -->	

        <div class="main">
            <div class="shell">
            <?PHP
                if($action == 'added')
                {    
                    
                ?>
                <h4 style="color:red;">Alert Created.</h4>
                <?PHP
                }
                ?>
                <div class="alert-form">
                <?PHP if($action =='' || $action == 'AlertBack' || $action == 'added'){ ?>
                    <script type="text/javascript" src="selectuser.js" language="javascript"></script>
                    <!-- <form name="frm_alert" id="frm_alert" method="post" action="alert.php?action=ReadAlert"> -->
                    <form name="frm_alert" id="frm_alert" method="post" action="alert-pro.php?action=AlertCreate">
                    <div class="form-content clearfix">
                            <div class="fcol fcol2 h490">
                                <h3 class="ico-executive">Chose Executive</h3>
                                <div class="form-content">
                                    <div class="fields">
                                        <div class="row"><label>Title:</label><input style="height:35px;width:260px;margin-left:12px;" type="text" name="title" id="title" title="e.g. HR and Human Capital Executives" value="<?PHP if($title==''){echo 'e.g. HR and Human Capital Executives';}else{echo $title;}?>" class="field" /></div><!-- /.row -->
                                        <div class="row"><label style="width:133px;" class="posr-label-select">Management<br /> Change Type:</label>
                                            <select class="chosen-select" style="width:260px;" name="management" id="management">
                                                <option value="">Any</option>
                                                <option value="1">Appointment</option>
                                                <option value="2">Lateral Move</option>
                                                <option value="3">Promotion</option>
                                            </select>
                                        </div><!-- /.row -->
                                    </div><!-- /.fields -->
                                </div><!-- /.form-content -->

                                <h3 class="ico-executive">Chose location</h3>
                                <div class="fields">
                                    <div class="row"><label>Country</label>
                                        <select class="chosen-select" name="country" id="country" style="width:260px;">
                                            <?=selectComboBox("select countries_id,countries_name from ".TABLE_COUNTRIES." order by countries_name",$country,$internal)?>
                                        </select>
                                    </div><!-- /.row -->



                                    <div style="display:block; float:left;width:100%;">
                                        <!-- <div class="row select140" style="display:block; float:left;width:161px;text-align:right;"> -->
                                        <span class="row select140">
                                            <label style="width:162px;">State</label>
                                        </span>
                                        <!-- <div style="display:block; float:left;width:200px;margin-bottom:10px;margin-left:4px;"> -->
                                        <span>
                                            <select class="chosen-select" name="state[]" id="state" multiple data-placeholder="Any" style="width:260px; height:80px;padding-left:5px;">
                                                <option value="">Any</option>
                                                <?=MultiSelectionComboBox("select state_id,short_name from ".TABLE_STATE." order by short_name",$state_id_arr)?>
                                            </select>
                                        </span>
                                        <!-- <div style="display:block; float:left;"> -->
                                    </div>    

                                    <span style="margin-left:165px;">
                                        <!-- <input style="margin-left:0px;width: 90px;height: 35px;margin-top: 6px;" name="zip_code" type="text" id="zip_code" title="Zip Code" value="<?PHP if($zip_code==''){echo 'Zip Code';}else{echo $zip_code;}?>" class="field field110 field110a" /> -->
                                        <input style="margin-left:8px;width: 260px;height: 35px;margin-top: 6px;" name="zip_code" type="text" id="zip_code" title="Zip Code" value="<?PHP if($zip_code==''){echo 'Zip Code';}else{echo $zip_code;}?>" class="field" />
                                    </span><!-- /.row -->    

                                    <div class="row"><label>City</label><input style="width:260px;height:35px;" name="city" type="text" id="city" title="" value="<?=$city?>" class="field" /></div><!-- /.row -->
                                </div><!-- /.fields -->
                            </div><!-- /.fcol fcol2 -->	

                            <div class="fcol fcol2 h490" style="height:553px;">
                                <h3 class="ico-company">Chose Company</h3>
                                <div class="fields">
                                        <div class="row"><label style="width:121px;">Company Name</label><input style="width:260px;height:35px;" name="company" type="text" id="company" title="e.g. Microsoft" value="<?PHP if($company==''){echo 'e.g. Microsoft';}else{echo $company;}?>" class="field" /></div><!-- /.row -->
                                        <div class="row row-textarea" style=""><label class="posr-label-textarea" style="padding-right:10px;">Paste URLs (up to 25)<br />of companies you'd <br />like to track</label>
                                                <textarea name="company_website" id="company_website" class="field-textarea"><?=$company_website?></textarea>
                                        </div><!-- /.row -->
                                        <div class="row" style="padding-top:0px;"><label style="width:125px;">Industry</label>
                                                <?PHP 	$indQuery = "select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id=0";
                                                $indResult = com_db_query($indQuery);
                                                ?>
                                                <select class="chosen-select" style="margin-left:6px;width:260px;" name="industry[]" id="industry" multiple data-placeholder="Any">
                                                    <? while($indRow = com_db_fetch_array($indResult)){ ?>
                                                    <optgroup label="<?=com_db_output($indRow['title'])?>">
                                                        <?=MultiSelectionComboBox("select industry_id,title from ".TABLE_INDUSTRY." where status=0 and parent_id='".$indRow['industry_id']."'",$industry_id_arr)?>
                                                    </optgroup>
                                                    <? } ?>
                                                 </select>
                                        </div><!-- /.row -->
                                        <div class="row"><label style="width:128px;">Size ($ Revenue)</label>
                                                <select class="chosen-select" style="margin-left:3px;width:260px;" name="revenue_size[]" id="revenue_size" multiple data-placeholder="Any">
                                                        <?=MultiSelectionComboBox("select id,name from ".TABLE_REVENUE_SIZE." where status=0 order by from_range",$revenue_size_id_arr)?>
                                                </select>
                                        </div><!-- /.row -->
                                        <div class="row"><label style="width:128px;">Size (Employees)</label>
                                                <select class="chosen-select" style="width:260px;margin-left:3px" name="employee_size[]" id="employee_size" multiple data-placeholder="Any">
                                                        <?=MultiSelectionComboBox("select id,name from ".TABLE_EMPLOYEE_SIZE." where status=0 order by from_range",$employee_size_id_arr)?>
                                                </select>
                                        </div><!-- /.row -->
                                </div><!-- /.fields -->
                            </div><!-- /.fcol fcol2 -->	

                    </div><!-- /.form-content -->
                    <div class="form-bottom clearfix">
                            <div class="fcol fcol2 h220" style="height:248px;">
                                    <h3 class="ico-engagement">Chose Engagement Triggers</h3>
                                    <div class="row row-checkboxes">
                                            <div><input type="checkbox" value="1" name="speaking" id="speaking" <?PHP if($speaking==1){echo 'checked="checked"';}else{echo '';}?> /><label style="text-align:left;margin-left:5px;width:80%;" for="speaking">Speaking Engagements</label></div><!-- /.checkbox -->
                                            <div><input type="checkbox" value="1" name="awards" id="awards" <?PHP if($awards==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="awards">Industry Awards</label></div><!-- /.checkbox -->
                                            <div><input type="checkbox" value="1" name="publication" id="publication" <?PHP if($publication==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="publication">Publications</label></div><!-- /.checkbox -->
                                            <div><input type="checkbox" value="1" name="media_mentions" id="media_mentions" <?PHP if($media_mentions==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="media_mentions">Media Mentions</label></div><!-- /.checkbox -->
                                            <div><input type="checkbox" value="1" name="board" id="board" <?PHP if($board==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="board">Board Appointments</label></div><!-- /.checkbox -->

                                            <div><input type="checkbox" value="1" name="jobs" id="jobs" <?PHP if($jobs==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="jobs">Jobs</label></div> <!-- /.checkbox -->
                                            <div><input type="checkbox" value="1" name="fundings" id="fundings" <?PHP if($fundings==1){echo 'checked="checked"';}else{echo '';}?>/><label style="text-align:left;margin-left:5px;" for="fundings">Fundings</label></div>  <!-- /.checkbox -->
                                    </div><!-- /.row -->
                            </div><!-- /.fcol fcol2 -->

                            <div class="fcol fcol2 h220">
                                    <h3 class="ico-frequency">Chose Frequency</h3>
                                    <div class="row pt25"><label>Deliver email alerts</label>
                                            <select class="chosen-select" name="delivery_schedule" id="delivery_schedule">
                                                    <?=selectComboBox("select name,name from ".TABLE_EMAIL_UPDATE." order by id",$delivery_schedule)?>
                                            </select>
                                    </div><!-- /.row -->
                                    <div class="row clearfix"><input type="submit" value="Create Alert" class="submit" /></div><!-- /.row -->
                            </div><!-- /.fcol fcol2 -->
                    </div><!-- /.form-bottom -->
            </form>
                    <?PHP  
                
                    }
                    elseif($action=='ReadAlert')
                    { ?>
			  		<table width="673" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                          <td align="left" valign="top" style="font-size:20px;padding:10px 0 0 10px;">Confirm Your Email Alert</td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                          <td align="center" valign="top"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Executive:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                         
                          <table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Title:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$title?> </td>
                              </tr>
                              <tr>
                                <td width="232" height="27" align="left" valign="middle" class="list-field-text">Management Change Type:</td>
                                <td width="250" align="left" valign="top" class="list-field-text"><?=$management_type?></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Location:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Country:</td>
                              <td width="251" align="left" valign="top" class="list-field-text"><?=$country_name?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">State:</td>
                              <td width="251"  align="left" valign="top" class="list-field-text"><?=$state_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">City:</td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$city?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="middle" class="list-field-text">Zip Code: </td>
                              <td width="251" height="27" align="left" valign="middle" class="list-field-text"><?=$zip_code?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Company:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Company:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Include urls of companies <br /> 
                              you'd like to track:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><?=$company_website?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$industry_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size ($Revenue):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$revenue_size_list?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Size (Employees):</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><?=$employee_size_list?></td>
                            </tr>
                            
                            
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Jobs:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($jobs==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
							
							
							
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Fundings:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($fundings==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            
                            
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Person:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="3" cellspacing="0">
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Speaking:</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><? if($speaking==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Industry Awards</td>
                              <td width="247" height="27" align="left" valign="top" class="list-field-text"><? if($awards==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Publications:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($publication==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Media Mentions:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($media_mentions==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                            <tr>
                              <td width="232" height="27" align="left" valign="top" class="list-field-text">Board Appointments:</td>
                              <td width="247"  align="left" valign="top" class="list-field-text"><? if($board==1){echo '<img src="css_new/images/check.png" alt="" />';}else{echo '<img src="css_new/images/red-cross.gif" alt="" />';}?></td>
                            </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><img src="images/specer.gif" width="1" height="35" alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="left" valign="top" class="alert-page-content-heading-text">Chose Frequency and Budget:</td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><img src="images/line.gif" width="673" height="19"  alt="" title="" /></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle"><table width="490" border="0" align="center" cellpadding="0" cellspacing="0">
                           
                              <tr>
                                <td align="left" valign="top"><table width="490" border="0" align="center" cellpadding="2" cellspacing="0">
                                    <tr>
                                        <td width="232" height="27" align="left" valign="middle" class="list-field-text">Email Alerts will be delivered:</td>
                                         <td width="251"  align="left" valign="top" class="list-field-text"><?=$delivery_schedule?></td>
                                    </tr>
                                </table></td>
                              </tr>
                                                  
                              <tr>
                               <td align="left" valign="top"><img src="images/specer.gif" width="1" height="8" alt="" title="" /></td>
                              </tr>
                          </table></td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="center" valign="middle">
                                <table width="214" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td align="center" valign="top">
                                      <form name="frmAlertBack" id="frmAlertBack" method="post" action="alert.php?action=AlertBack">
                                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
                                            
                                            <input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
                                            <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                            
                                        </td></tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">
                                            <a href="javascript:FormValueSubmit('frmAlertBack');"> Back</a>
                                        
                                        </td>
                                        </tr>
                                       </table>	
                                       </form>
                                      </td>
                                      <td align="center" valign="top">&nbsp;</td>
                                      <td align="center" valign="top">
                                         <form name="frmAlertConfirm" id="frmAlertConfirm" method="post" action="alert-pro.php?action=AlertCreate">
                                        <table border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr><td>
                                            <input type="hidden" name="title" value="<?=$title?>"/>
                                            <input type="hidden" name="management" id="management" value="<?=$management?>"/>
                                            <input type="hidden" name="country" id="country" value="<?=$country?>"/>
                                            <input type="hidden" name="state" id="state" value="<?=$state_id_arr?>"/>
                                            <input type="hidden" name="city" id="city" value="<?=$city?>"/>
                                            <input type="hidden" name="zip_code" id="zip_code" value="<?=$zip_code?>"/>
                                            <input type="hidden" name="company" id="company" value="<?=$company?>"/>
                                            <input type="hidden" name="company_website" id="company_website" value="<?=$_POST['company_website'];?>"/>
                                            <input type="hidden" name="industry" id="industry" value="<?=$industry_id_arr?>"/>
                                            <input type="hidden" name="revenue_size" id="revenue_size" value="<?=$revenue_size_id_arr?>"/>
                                            <input type="hidden" name="employee_size" id="employee_size" value="<?=$employee_size_id_arr?>"/>
                                            <input type="hidden" name="speaking" id="speaking" value="<?=$speaking?>"/>
                                            <input type="hidden" name="awards" id="awards" value="<?=$awards?>"/>
                                            <input type="hidden" name="publication" id="publication" value="<?=$publication?>"/>
                                            <input type="hidden" name="media_mentions" id="media_mentions" value="<?=$media_mentions?>"/>
                                            <input type="hidden" name="board" id="board" value="<?=$board?>"/>
                                            <input type="hidden" name="delivery_schedule" id="delivery_schedule" value="<?=$delivery_schedule?>"/>
                                            
                                            <input type="hidden" name="jobs" id="jobs" value="<?=$jobs?>"/>
                                            <input type="hidden" name="fundings" id="fundings" value="<?=$fundings?>"/>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td align="center" valign="top" class="more_bottom">	
                                            <a href="javascript:FormValueSubmit('frmAlertConfirm');"> Confirm</a>
                                            </td>
                                            </tr>
                                        </table>	
                                      </form>
                                      </td>
                                    </tr>
                                  </table>
                            </td>
                        </tr>
                
                        <tr>
                          <td align="center" valign="middle">&nbsp;</td>
                        </tr>
                      </table>
			  <?PHP } ?>   
				</div><!-- /.alert-form -->
			</div><!-- /.shell -->
		</div><!-- /.main -->		
	</div><!-- /.email-alert -->

            
<script language="javascript">
    $(".chosen-select").chosen();
</script>    
            
<?php      
include(DIR_INCLUDES."footer-content-page.php");
?>