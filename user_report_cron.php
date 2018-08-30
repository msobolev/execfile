<?php
//require('includes/include_top.php');
require('functions.php');
require('config.php');
com_db_connect_hre2() or die('Unable to connect to database server!');
//require('admin_header.php');
$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 500;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
$this_root_path = "https://www.execfile.com";
//echo "<br>After form submit";
	
    //echo "<pre>POST: ";   print_r($_REQUEST);   echo "</pre>";
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
    
    
    
    $sql_query = "select * from " . TABLE_USER . " $where_clause and status = 1 order by user_id desc ";
    
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


$uID = (isset($_GET['uID']) ? $_GET['uID'] : $select_data[0]);

$output = "";   


$output .= '<table width="100%">
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
		
		<td width="10" align="left" valign="top">&nbsp;</td>
                <td width="769" align="left" valign="top">';
?>
<?php if(($action == '') || ($action == 'save') || ($action == 'UserSearch') || ($action == 'UserSearchResult')){				

    $output .= '<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="user.php?action=alldelete&selected_menu=user" method="post">
                            <table width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="22" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
                                    
                                    <td width="149" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Name</span> </td>
                                    <td width="120" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Email</span> </td>
                                    <td width="30" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Function</span> </td>
                                    <td width="78" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Alert</span> </td>
                                    <td width="78" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Login</span> </td>
                                    <td width="75" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Download</span></td>
                                    <td width="74" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Tot. Search</span></td>
                                    <td width="74" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td> 
                                </tr>';
			
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
                                
                                $last_14_days_searches_q = "select count(user_id) from " . TABLE_SEARCH_HISTORY . " where user_id='".$data_sql['user_id']."' and add_date  >= DATE(NOW()) - INTERVAL 14 DAY";
                                $last_14_days_searches = com_db_GetValue($last_14_days_searches_q);

                                
                                $last_14_days_opened_q = "select count(user_id) from " . TABLE_ALERT_SEND_INFO . " AS a, exec_alert_tracker AS t where user_id='".$data_sql['user_id']."' AND a.email_id = t.alert_email_id AND FROM_UNIXTIME( sent_date ) >= DATE( NOW( ) ) - INTERVAL 14 DAY";
                                $last_14_days_opened = com_db_GetValue($last_14_days_opened_q);

                                
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
                                     
                            $output .= '<tr>
				<td style="'.$backgroundColor.' height="30" align="center" valign="middle" class="right-border-left">'.$i.'</td>
				<td style="'.$backgroundColor.'" height="30" align="left" valign="middle" class="right-border-text">'.com_db_output($data_sql['first_name']).' '.com_db_output($data_sql['last_name']).'</td>
				<td style="'.$backgroundColor.'" height="30" align="left" valign="middle" class="right-border-text">'.com_db_output($data_sql['email']).'</td>
                                    <td style="'.$backgroundColor.'" height="30" align="left" valign="middle" class="right-border-text">'.$data_sql['site'].'</td>
				<td style="'.$backgroundColor.'" height="30" align="center" valign="middle" class="right-border-text" style="text-align:center;">
                                    '.$this_user_alerts.'
				</td>
                                <td style="'.$backgroundColor.'" height="30" align="center" valign="middle" class="right-border">'.$this_user_login.'</td>
				<td style="'.$backgroundColor.'" height="30" align="left" valign="middle" class="right-border">'.$this_user_download.'</td>
				<td style="'.$backgroundColor.'" height="30" align="left" valign="middle" class="right-border">'.$this_user_search.'</td>
                                <td style="'.$backgroundColor.'" height="30" align="center" valign="middle" class="right-border">'.$added_date.'</td>
                                
                            </tr>'; 
			
			$i++;
                            }
			
			}
		
                    $output .= '</table> 
		</form>
		
		</td>
          </tr>
        </table>
</td>
      </tr>
    </table></td>
  </tr>
</table>';
  
}



require_once('PHPMailer/class.phpmailer.php');
$mail                = new PHPMailer();
$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth      = true;                  // enable SMTP authentication
$mail->SMTPKeepAlive = true;                  // SMTP connection will not close after each email sent
$mail->Host          = "smtpout.secureserver.net"; //"smtpout.secureserver.net"; // sets the SMTP server relay-hosting.secureserver.net smtpout.secureserver.net
$mail->Port          = 25;//80;    // 25 465               // 26 set the SMTP port for the GMAIL server
//$mail->Username      = "rts_email_sent@ctosonthemove.com"; // SMTP account username
$mail->Username      = "msobolev@execfile.com"; //misha.sobolev@execfile.com"; //rts_email_sent@hrexecsonthemove.com"; // SMTP account username
$mail->Password      = "ryazan"; //"rts0214";        // SMTP account password
//$mail->SetFrom('rts_email_sent@ctosonthemove.com', 'ctosonthemove.com');
$mail->SetFrom('msobolev@execfile.com', 'Execfile.com');
//$mail->AddReplyTo('ms@ctosonthemove.com', 'ctosonthemove.com');
$mail->AddReplyTo("msobolev@execfile.com", 'Execfile.com');
$mail->Subject       = "Customer status";

$email = "misha.sobolev@gmail.com";
//$email = "faraz.aia@nxvt.com";
$user_first_name = "Faraz";

$mail->MsgHTML($output);
$mail->AddAddress($email, $user_first_name);
$mail->Send();











?>