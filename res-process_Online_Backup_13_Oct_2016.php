<?php 
session_start();
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);



//include("includes/include-top.php");

include("config.php");
include("functions.php");
//com_db_connect() or die('Unable to connect to database server!');
com_db_connect_hre2() or die('Unable to connect to database server!');

$action = $_GET['action'];

//
if($action == 'UserLogin')
{
    $login_email = $_POST['login_email'];
    $login_pass	= $_POST['login_pass'];

    $login_email_lower = strtolower($login_email);

    if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $login_email_lower)){ 
        $url = "login.php?action=LoginEmail&login_email=".$login_email;
        com_redirect($url);
     }

    if($login_email == 'michael.gallagher@emindful.com') // Quick fix for user with email address michael.gallagher@emindful.com 
    {
        $activate_this_user_query = "update " . TABLE_USER . " set status = '0' where email='michael.gallagher@emindful.com'";
        com_db_query($activate_this_user_query);
    }


    //$user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$login_email_lower."' and status='0'";
    $user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$login_email_lower."' and status = 1";

    //echo "<br>user_query: ".$user_query; 

    $user_result = com_db_query($user_query);
    if($user_result)
    {
        $row_count = com_db_num_rows($user_result);
        if($row_count > 0)
        {
            $user_row = com_db_fetch_array($user_result);
            $user_name = $user_row['first_name'] .' ' . $user_row['last_name'];
            $user_email = $user_row['email'];
            $password_db = $user_row['password'];

            //echo "<br>login_pass: ".$login_pass;
            //echo "<br>password_db: ".$password_db;
            //die();
            if(strtoupper($login_pass) == strtoupper($password_db))
            {
                /*
                if(isset($_COOKIE['loginsessionid']))
                {
                    com_db_query("update ".TABLE_LOGIN_HISTORY." set logout_time ='" .time()."', log_status='Logout' where session_id='".$_COOKIE['loginsessionid']."'");
                }
                */
                /*
                $user_is_login = com_db_GetValue("select login_id from " . TABLE_LOGIN_HISTORY . " where user_id='".$user_row['user_id']."' and log_status='Login' and add_date='".date('Y-m-d')."' order by login_id desc");
                if($user_is_login){

                    $admin_mail_result =com_db_query("select * from " .TABLE_AUTORESPONDERS. " where type='Admin' and autoresponder_for='User attempted to concurrently login with the same login/password'");
                    $admin_mail_row = com_db_fetch_array($admin_mail_result);
                    $subject = "HREXECsonthemove.com :: ".$admin_mail_row['subject'];
                    $admin_body1 = com_db_output($admin_mail_row['body1']);
                    $admin_body2 = com_db_output($admin_mail_row['body2']);

                    $message = '<a href="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
                      <table width="70%" cellspacing="0" cellpadding="3" >

                        <tr>
                                <td align="left" colspan="2">'.$admin_body1." ".$admin_body2.'</td> 
                        </tr>
                        <tr>
                                <td align="left"><b>Name:</b></td>
                                <td align="left">'.$user_row['first_name'].' '.$user_row['last_name'].'</td>
                        </tr>
                        <tr>
                                <td align="left"><b>Email:</b></td>
                                <td align="left">'.$user_row['email'].'</td>
                        </tr>
                        <tr>
                                <td align="left" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                                <td align="left" colspan="2">'.$fromEmailSent.'</td>
                        </tr>';

                    $message .=	'</table>';

                    @send_email($to_admin, $subject, $message, $user_email);
                    $url = "concurrent-logins.php";
                    com_redirect($url);	
                }
                 */			

                
                $cookie_name = "user_state";
                $cookie_value = "loggedin";
                setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
                
          
                
                $_SESSION['sess_is_user'] = 1;
                $_SESSION['sess_user_id'] = $user_row['user_id'];
                $_SESSION['sess_username'] = $user_name;
                $_SESSION['sess_payment'] = 'Complited';
                
                if($user_row['site'] == '')
                    $user_row['site'] = 'hr';
                
                $_SESSION['site'] = $user_row['site'];
                
                $user_id = $user_row['user_id'];
                $add_date = date("Y-m-d");
                $login_time = time();
                $logout_time =0;
                $log_status = 'Login';

                $session_id = session_id();
                setcookie("loginsessionid", $session_id, time()+3600);
                //$sql_login_query = "insert into " . TABLE_LOGIN_HISTORY . " (user_id,add_date,login_time,logout_time,session_id,log_status) values('$user_id','$add_date','$login_time','$logout_time','$session_id','$log_status')";
                //com_db_query($sql_login_query);

                $user_level = $user_row['level'];
                $payment_by = $user_row['payment_by'];

                /*
                    if($user_level=='')
                    {
                        com_redirect("choose-user-subscription.php?res_id=".$user_id);
                    }
                    elseif($user_level=='Paid')
                    {
                        $isPayment	= com_db_GetValue("select payment_id from ".TABLE_PAYMENT." where payment_type='Registration' and user_id='".$user_id."'");
                        if($isPayment=='' && $payment_by =='Admin'){
                                com_redirect("advance-search.php");
                        }elseif($isPayment=='' && $payment_by =='User'){
                                $_SESSION['sess_payment'] = 'Not Complited';
                                com_redirect("provide-contact-information.php?action=back&resID=".$user_id);
                        }else{
                                com_redirect("advance-search.php");
                        }
                    }
                    else
                    {
                */
                        //com_redirect("advance-search.php");
                    //com_redirect("home.php?funtion=hr");
                    com_redirect("home.php?funtion=".$_SESSION['site']);
                    
                    //com_redirect("http://hr.execfile.com/home.php?funtion=hr");
                    ?>
                <script language="javascript">
                //target.window.location='http://hr.execfile.com/home.php?funtion=hr';
                </script>
                <?PHP

                //}	
            }
            $url = "login.php?action=LoginPassword&login_email=".$login_email;
            com_redirect($url);
        }
        else
        {
            $url = "login.php?action=LoginEmail&login_email=".$login_email;
            com_redirect($url);
        }
    }
    else
    {
        $url = "login.php?action=LoginEmailPassword";
        com_redirect($url);	
    }
}


?>