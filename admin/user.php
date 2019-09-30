<?php
//require('includes/include_top.php');
require('../functions.php');
require('../config.php');
com_db_connect_hre2() or die('Unable to connect to database server!');
require('admin_header.php');
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 10;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$this_root_path = "https://www.execfile.com";
//echo "<br>After form submit";

if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'search')
{
    $where_clause = ' where 1=1 ';
    if(isset($_REQUEST['status']) && $_REQUEST['status'] != '' && $_REQUEST['status'] != 'All')
    {
        $where_clause .= " and status = ".$_REQUEST['status'];
    }    
    
    if(isset($_REQUEST['site']) && $_REQUEST['site'] != '' && $_REQUEST['site'] != 'All')
    {
        if($_REQUEST['site'] == 'hr')
        {    
            $where_clause .= " and (site = '".$_REQUEST['site']."') OR site = ''";
        }
        else
        {    
            $where_clause .= " and site = '".$_REQUEST['site']."'";
        }    
    }
    
    if(isset($_REQUEST['by_domain']) && $_REQUEST['by_domain'] != '')
    {
        $where_clause .= " and email like '%".$_REQUEST['by_domain']."%'";
    } 
    
    
    //$sql_query = "select * from " . TABLE_USER . " $where_clause order by user_id desc";
    $sql_query = "select * from " . TABLE_USER . " $where_clause order by user_id desc";
    
    //$sql_query = "select * from " . TABLE_USER . " $where_clause and (site = '' || site = 'hr') and status = 1 order by user_id desc";
    
    $_SESSION['sess_action']='';
//}


/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'user.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
//echo "<br>sql_query: ".$sql_query;
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/

}

$uID = (isset($_GET['uID']) ? $_GET['uID'] : $select_data[0]);

//include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("User will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			document.getElementById(user_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			document.getElementById(user_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var user_id='user_id-'+ i;
			if(document.getElementById(user_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('user_id-1').focus();
		return false;
	} else {
		var agree=confirm("User will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "user.php?selected_menu=user";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="User will be active. \n Do you want to continue?";
	}else{
		var msg="User will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "user.php?selected_menu=user&uID=" + nid + "&p=" + p ;
}

function UserSearch(){
	window.location ='user.php?action=UserSearch&selected_menu=user';
}
function PaymentShow(pi){
	document.getElementById(pi).style.display='block';
}
function PaymentClose(pi){
	document.getElementById(pi).style.display='none';
}


function handleSelect(elm)
{
    //window.location = elm.value;
    document.getElementById("filters_frm").submit();
}




function show_all_alerts()
{
    //document.getElementsByClassName('hide_row').style.display = 'block';
    var max_id = document.getElementById("max_alert_id").value;
    //alert("MAX ID: "+max_id);
    for(var c=6;c<max_id;c++)
    {
        if(document.getElementById('hide_col1_'+c))
        {    
            document.getElementById('hide_col1_'+c).style.display = 'block';
            //document.getElementById('hide_col2_'+c).style.display = 'block';
        }    
    }    
}
</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
		<?php
		//include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
                <td width="769" align="left" valign="top">
                    
                    <form style="margin-top:30px;" id="filters_frm" method="post" action="user.php?action=search">
                        
                        
                        Status:&nbsp;
                        <select id="status" name="status" onchange="javascript:handleSelect(this)">
                            <option>All</option>
                            <option <?PHP if($_REQUEST['status'] == '1') echo "selected"; else echo ""; ?> value="1">Active</option>
                            <option <?PHP if($_REQUEST['status'] == '0') echo "selected"; else echo ""; ?> value="0">Inactive</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Vertical:&nbsp;
                        <select id="site" name="site" onchange="javascript:handleSelect(this)">
                            <option>All</option>
                            <option <?PHP if($_REQUEST['site'] == 'hr') echo "selected"; else echo ""; ?> value="hr">HR</option>
                            <option <?PHP if($_REQUEST['site'] == 'cmo') echo "selected"; else echo ""; ?> value="cmo">CMO</option>
                            <option <?PHP if($_REQUEST['site'] == 'cto') echo "selected"; else echo ""; ?> value="cto">CTO</option>
                            <option <?PHP if($_REQUEST['site'] == 'ciso') echo "selected"; else echo ""; ?> value="ciso">CISO</option>
                            <option <?PHP if($_REQUEST['site'] == 'cso') echo "selected"; else echo ""; ?> value="cso">CSO</option>
                            <option <?PHP if($_REQUEST['site'] == 'cfo') echo "selected"; else echo ""; ?> value="cfo">CFO</option>
                            <option <?PHP if($_REQUEST['site'] == 'clo') echo "selected"; else echo ""; ?> value="clo">CLO</option>
                        </select>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        
                        Email Address or Domain:&nbsp;
                        <input type="text" name="by_domain" id="by_domain" value="<?=$_REQUEST['by_domain']?>"><input type="submit" value="Seearch">
                    </form>
                    
                    
                    
<?php 
//if(($action == '') || ($action == 'save') || ($action == 'UserSearch') || ($action == 'UserSearchResult')){	
if(($action == 'save') || ($action == 'search') || ($action == 'UserSearch') || ($action == 'UserSearchResult')){	
?>			

                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="center" valign="middle" class="right">
                                <form id="filters_frm" method="post" action="user.php">
                                    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="16%" align="left" valign="middle" class="heading-text">User Manager</td>
                                            <td width="43%" align="left" valign="middle" class="message"><?=$msg?></td>
                                            <td width="40%">
                                                
                                            </td>

                                        </tr>
                                    </table>
                                </form>
                            </td>
                        </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="user.php?action=alldelete&selected_menu=user" method="post">
                            <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
                                    <!--
                                    <td width="31" height="30" align="center" valign="middle" class="right-border">
                                        <input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" />
                                    </td>
                                    -->
                                    <td width="189" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
                                    <!-- <td width="99" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Subscription</span> </td> -->
                                    <td width="138" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Alert</span> </td>
                                    <td width="78" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Login</span> </td>
                                    <td width="105" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Download</span></td>
                                    <td width="84" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Search</span></td>
                                    <td width="74" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td> 
                                <!--    <td width="141" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td> -->
                                </tr>
			<?php
			//echo "<br>total_data: ".$total_data;
			if($total_data>0) 
                        {
                            $i=1;
                            while ($data_sql = com_db_fetch_array($exe_data)) 
                            {
				//$added_date = $data_sql['res_date'];
                                $added_date = $data_sql['add_date'];
				$status = $data_sql['status'];
                                $subscription_name = "";
				//$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id='".$data_sql['subscription_id']."'");
				$tot_alert = com_db_GetValue("select count(alert_id) as cnt from " .TABLE_ALERT ." where user_id='".$data_sql['user_id']."'");
			
                                
                                $this_user_alerts = com_db_GetValue("select count(user_id) from " . TABLE_ALERT_SEND_INFO . " where user_id='".$data_sql['user_id']."'");
                                $this_user_login = com_db_GetValue("select count(user_id) from " . TABLE_LOGIN_HISTORY . " where user_id='".$data_sql['user_id']."'");
                                $this_user_download = com_db_GetValue("select count(user_id) from " . TABLE_DOWNLOAD . " where user_id='".$data_sql['user_id']."'");
                                $this_user_search = com_db_GetValue("select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$data_sql['user_id']."'");
                                
                                
                                $this_user_opened_older_14_days = "select count(user_id) from " . TABLE_ALERT_SEND_INFO . " AS a, exec_alert_tracker AS t where user_id='".$data_sql['user_id']."' AND a.email_id = t.alert_email_id AND FROM_UNIXTIME( sent_date ) < DATE( NOW( ) ) - INTERVAL 14 DAY";
                                
                                $this_user_download_older_14_days_q = "select count(user_id) from " . TABLE_DOWNLOAD . " where user_id='".$data_sql['user_id']."' and add_date  <= DATE(NOW()) - INTERVAL 14 DAY";
                                $this_user_download_older_14_days = com_db_GetValue($this_user_download_older_14_days_q);
                                
                                $this_user_searches_older_14_days_q = "select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$data_sql['user_id']."' and add_date  < DATE(NOW()) - INTERVAL 14 DAY";
                                $this_user_searches_older_14_days = com_db_GetValue($this_user_searches_older_14_days_q);
                                
                                
                                $last_14_days_download_q = "select count(user_id) from " . TABLE_DOWNLOAD . " where user_id='".$data_sql['user_id']."' and add_date  >= DATE(NOW()) - INTERVAL 14 DAY";
                                $last_14_days_download = com_db_GetValue($last_14_days_download_q);
                                //echo "<br><br>last_14_days_download:".$last_14_days_download;
                                //echo "<br>last_14_days_download_q:".$last_14_days_download_q;

                                
                                $last_14_days_searches_q = "select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$data_sql['user_id']."' and add_date  >= DATE(NOW()) - INTERVAL 14 DAY";
                                $last_14_days_searches = com_db_GetValue($last_14_days_searches_q);
                                //echo "<br>last_14_days_searches:".$last_14_days_searches;
                                //echo "<br>last_14_days_searches_q:".$last_14_days_searches_q;
                                
                                $last_14_days_opened_q = "select count(user_id) from " . TABLE_ALERT_SEND_INFO . " AS a, exec_alert_tracker AS t where user_id='".$data_sql['user_id']."' AND a.email_id = t.alert_email_id AND FROM_UNIXTIME( sent_date ) >= DATE( NOW( ) ) - INTERVAL 14 DAY";
                                $last_14_days_opened = com_db_GetValue($last_14_days_opened_q);
                                //echo "<br>last_14_days_opened:".$last_14_days_opened;
                                //echo "<br>last_14_days_opened_q:".$last_14_days_opened_q;
                                
                                //echo "<br>this_user_alerts:".$this_user_alerts;
                                //echo "<br>this_user_download:".$this_user_download;
                                //echo "<br>this_user_search:".$this_user_search;
                                
                                $backgroundColor = "";
                                $parameter_count = 0;
                                $parameter_count_older = 0;
                                if($last_14_days_download > 0)
                                    $parameter_count++;
                                if($last_14_days_searches > 0)
                                    $parameter_count++;
                                if($last_14_days_opened > 0)
                                    $parameter_count++;
                                
                                
                                if($this_user_opened_older_14_days > 0)
                                    $parameter_count_older++;
                                if($this_user_download_older_14_days > 0)
                                    $parameter_count_older++;
                                if($this_user_searches_older_14_days > 0)
                                    $parameter_count_older++;
                                
                                
                                //if($last_14_days_download > 0 && $last_14_days_searches > 0 && $last_14_days_opened > 0)
                                if($parameter_count > 1)
                                    $backgroundColor = "background-color:#A8FF33";
                                elseif($parameter_count_older > 1)   // elseif($this_user_alerts == 0 && $this_user_download == 0 && $this_user_search == 0)
                                    $backgroundColor = "background-color:yellow";
                                elseif($this_user_alerts == 0 && $this_user_download == 0 && $this_user_search == 0) //elseif($this_user_alerts > 0  && $this_user_download > 0 && $this_user_search > 0)
                                    $backgroundColor = "background-color:red";
                                //echo "<br>backgroundColor:".$backgroundColor;
                            ?>          
                            <tr>
				<td style="<?=$backgroundColor?>" height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td style="<?=$backgroundColor?>" height="30" align="left" valign="middle" class="right-border-text"><a href="user.php?action=detailes&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name'])?></a></td>
				
				<td style="<?=$backgroundColor?>" height="30" align="center" valign="middle" class="right-border-text" style="text-align:center;">
                                    <a href="user.php?action=TotalAlert&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=$this_user_alerts?></a>
				</td>
                                <td style="<?=$backgroundColor?>" height="30" align="center" valign="middle" class="right-border"><a href="user.php?action=TotalLogin&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=$this_user_login?></a></td>
				<td style="<?=$backgroundColor?>" height="30" align="left" valign="middle" class="right-border"><a href="user.php?action=TotalDownload&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=$this_user_download?></a></td>
				<td style="<?=$backgroundColor?>" height="30" align="left" valign="middle" class="right-border"><a href="user.php?action=TotalSearch&selected_menu=user&uID=<?=$data_sql['user_id'];?>"><?=$this_user_search?></a></td>
                                <td style="<?=$backgroundColor?>" height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
                                
                            </tr> 
			<?php
			$i++;
                            }
			}
			?>     
                    </table> 
		</form>
		</td>
          </tr>
        </table>
</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-bottom:170px;">
            <tr>
                <td width="666" align="right" valign="top">
                    <table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
                        <tr>
                            <?php echo admin_number_pages($main_page, $p, $total_data, 8, $items_per_page,'&site='.$_REQUEST['site'].'&status='.$_REQUEST['status']);?>		  
                        </tr>
                    </table>
                </td>
                <td width="314" align="center" valign="bottom">&nbsp;</td>
            </tr>
    </table></td>
  </tr>
  
<?php }
elseif($action=='TotalLogin'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Login Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
		 <?php
		 $login_result = com_db_query("select * from " .TABLE_LOGIN_HISTORY . " where user_id='".$uID."'");
		 if($login_result){
		 	$login_num = com_db_num_rows($login_result);
		 }else{
		 	$login_num=0;
		 }
		 ?>
         	 
          <table width="55%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="23%" align="left" class="page-text" valign="top"><span class="right-box-title-text">Date</span></td>
			  <td width="24%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Login Time</span></td>	
			  <td width="25%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Logout Time</span></td>
			  <td width="28%" align="left" valign="top" class="page-text"><span class="right-box-title-text">Access Time</span></td>
			</tr>
			<?PHP if($login_num > 0){
				while($login_row = com_db_fetch_array($login_result)){
				$login_time = $login_row['login_time'];
				$logout_time = $login_row['logout_time'];
				$acc_hour = 0;
				$acc_min = '00';
				if($logout_time > 0){
				$acc_time = $logout_time -  $login_time;
				$acc_hour = floor($acc_time/3600);
				$acc_min =floor(floor($acc_time%3600)/60);
				if(strlen($acc_min)==1){
						$acc_min = '0'.$acc_min;
					}
				}
			?>
			<tr>
			  <td width="23%" align="left" class="page-text" valign="top"><?=$login_row['add_date']?></td>
			  <td width="24%" align="left" valign="top" class="page-text"><?=date('H:i',$login_time)?></td>	
			  <td width="25%" align="left" valign="top" class="page-text"><?=date('H:i',$logout_time)?></td>
			  <td width="28%" align="left" valign="top" class="page-text"><?=$acc_hour.'-'.$acc_min?></td>
			</tr>
			<?PHP 		} 
				}else{	?>
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<?PHP } ?>	
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
			    <td align="left" valign="top">&nbsp;</td>
			    <td align="left" valign="top">&nbsp;</td>
			</tr>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}

elseif($action=='TotalDownload'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Download Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         <?php
		 $download_result = com_db_query("select * from " .TABLE_DOWNLOAD . " where user_id='".$uID."'");
		 if($download_result){
		 	$download_num = com_db_num_rows($download_result);
		 }else{
		 	$download_num=0;
		 }
		 ?>
          <table width="20%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="2" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="14%" align="left" valign="top"><span class="right-box-title-text">#</span></td>
			  <td width="86%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Date</span></td>	
			</tr>
			<?PHP if($download_num > 0){
				$dd=1;
				while($download_row = com_db_fetch_array($download_result)){
				$download_date = $download_row['add_date'];
			?>
		
			<tr>
			  <td width="14%" align="left" valign="top" class="left-box-text"><?=$dd;?></td>
			  <td width="86%" align="left" valign="top" class="left-box-text"><a href="javascript:popupDownload('popup-download.php?dID=<?=$download_row['download_id']?>')"><?=$download_date?></a></td>	
			 
			</tr>
			<?PHP 	$dd++;
					} 
				}else{	?>
			<tr>
			  <td colspan="2" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<?PHP } ?>	
			
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
			</tr>

			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}
elseif($action=='TotalSearch'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Search Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         	 
           <?php
		 $search_result = com_db_query("select * from " .TABLE_SEARCH_HISTORY . " where user_id='".$uID."'");
		 if($search_result){
		 	$search_num = com_db_num_rows($search_result);
		 }else{
		 	$search_num=0;
		 }
		 ?>
          <table width="55%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="10%" align="left" valign="top"><span class="right-box-title-text">#</span></td>
			  <td width="20%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Date</span></td>	
			  <td width="30%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Search Type</span></td>
			  <!-- <td width="40%" align="left" valign="top"><span class="right-box-title-text">&nbsp;&nbsp;Search Details</span></td> -->
			</tr>
			<?PHP if($search_num > 0){
				$ss=1;
				while($search_row = com_db_fetch_array($search_result)){
				$search_date = $search_row['add_date'];
				if($search_row['search_type'] =='Search'){
					$search_type='Search';
				}else{
					$search_type='Advance Search';
				}
			?>
		
			<tr>
                            <td width="10%" align="left" valign="top" class="left-box-text"><?=$ss;?></td>
                            <td width="20%" align="left" valign="top" class="left-box-text"><?=$search_date?></td>	
                            <td width="30%" align="left" valign="top" class="left-box-text"><?=$search_type?></td>
                            <!--
                            <td width="40%" align="left" valign="top" class="left-box-text">
			  	<?PHP //if($search_type=='Search'){
				 	//	echo $search_row['search_string'];
				   //}else{
					?>
			  		<a href="javascript:popupSearch('popup-search.php?sID=<?=$search_row['search_id']?>')">Advance Search Details</a>
			  	<?PHP// } ?>	
                            </td>
                            -->
			</tr>
			<?PHP 	$ss++;
					} 
				}else{	?>
			<tr>
			  <td colspan="4" align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<?PHP } ?>	
			
			<tr>
				<td align="left" valign="top">&nbsp;</td> 
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
				<td align="left" valign="top">&nbsp;</td>
				<td align="left" valign="top">&nbsp;</td>
			</tr>

			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}
elseif($action=='TotalAlert'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">User Manager :: Alerts Send Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
         <?php
		 $download_result = com_db_query("select * from " .TABLE_ALERT_SEND_INFO . " where user_id='".$uID."' order by info_id desc;");
		 if($download_result){
		 	$download_num = com_db_num_rows($download_result);
		 }else{
		 	$download_num=0;
		 }
		 ?>
          <table width="70%" align="left" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td align="left" class="page-text" valign="top">&nbsp;</td>
			</tr>
			<tr>
                            <td>
                                <table width="100%">
                                    <tr>
                                        <td width="14%" align="left" valign="top"><span class="right-box-title-text">#</span></td>
                                        <td width="35%" align="left" valign="top"><span class="right-box-title-text">Date</span></td>	
                                        <td width="20%" align="left" valign="top"><span class="right-box-title-text">Opened</span></td>	
                                        <td width="25%" align="left" valign="top"><span class="right-box-title-text">Email ID</span></td>	
                                    </tr>
                                </table>
                            </td>
                        </tr>    
			<?PHP 
                        if($download_num > 0)
                        {
                            $dd=1;
                            while($download_row = com_db_fetch_array($download_result))
                            {
				$download_date = $download_row['sent_date'];
                                $download_date = gmdate("Y-m-d", $download_date);
                                
                                $this_email_id = $download_row['email_id'];
                                $tracking_result = com_db_query("select * from exec_alert_tracker where alert_email_id='".$this_email_id."'");
                                if($tracking_result)
                                {
                                    $tracking_num = com_db_num_rows($tracking_result);
                                    if($tracking_num > 0)
                                    {
                                        $email_opened = 1;
                                    }
                                    else
                                        $email_opened = 0;
                                }
                                else
                                {
                                    $tracking_num = 0;
                                    $email_opened = 0;
                                }
                                
			?>
			<tr>
                            <?PHP
                            $disp = "";
                            $hidden_class = "";


                            if($dd > 5)
                            {
                                $disp = 'display:none;';
                                $hidden_id_one = "id=hide_col1_".$dd;
                                $hidden_id_two = "id=hide_col2_".$dd;

                                if($dd == 6)
                                {
                                    echo "<tr><td style=padding-top:10px;padding-bottom:10px;cursor:pointer; onclick=show_all_alerts(); colspan=2><b><u>Show More</u></b></td></tr>";
                                    //echo "<div $hidden_class style=$disp>";
                                }    

                            }  
                            ?>
                            
                            
                            <td style="<?=$disp?>" <?=$hidden_id_one?> align="left" valign="top" class="left-box-text">
                                <table width="100%">
                                    <tr>
                                        <td width="14%"><?=$dd;?></td>
                                        <!-- <td align="left" valign="top" class="left-box-text"><a href="javascript:popupDownload('popup-download.php?dID=<?=$download_row['download_id']?>')"><?=$download_date?></a></td> -->	 
                                        <td width="35%" align="left" valign="top" class="left-box-text"><?=$download_date?></a></td>
                                        <td width="20%" align="left" valign="top" class="left-box-text">(<?=$email_opened?>)</td>
                                        <td width="25%" align="left" valign="top" class="left-box-text"><a href="<?=$this_root_path?>/alert-email-show.php?emailid=<?=$this_email_id?>" >Link</td>
                                    </tr>
                                </table>
                            </td>    
                        </tr>
			<?PHP
                        
                                  
                        
                        
                                $dd++;
                            } 
                        }
                        else
                        {	?>
			<tr>
			  <td  align="left" class="page-text" valign="top">Record not found</td>
			</tr>
			<?PHP } 
                        
                        
                        echo "<input type=hidden name=max_alert_id id=max_alert_id value=$dd>";
                        
                        ?>	
			<tr>
                            <td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='user.php?p=<?=$p;?>&uID=<?=$uID;?>&selected_menu=user'" /></td>
			</tr>

			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php

}
?>