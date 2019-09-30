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
    
    
    
    
    $login_email = secure_input($_POST['login_email']);
    $login_pass	= secure_input($_POST['login_pass']);
    $currentDate = date('Y-m-d');
    $userIp = getRealIpAddr();
    
    $getLogin = "select count(*) as loginAttempts from exec_login_log where user_email = '".$login_email."' and add_date = '".$currentDate."' and user_ip = '$userIp' and status != 'success'";
    $loginRes = com_db_query($getLogin);
    $loginRow = com_db_fetch_array($loginRes);
    $loginAttempts = $loginRow['loginAttempts'];
    
    $login_email_lower = strtolower($login_email);
    
    
    $addLoginLog = "insert into exec_login_log(user_email,user_password,user_ip,add_date) values('$login_email','$login_pass','$userIp','$currentDate')";
    com_db_query($addLoginLog);
    //$lastLogin = com_db_insert_id();
    $lastLogin = mysqli_insert_id($link);
    
    
    // user from cmos shd b logged in
    // updated on 
    $cmo_user = 0;
    $cmo_test_user = 0;
    $hr_test_user = 0;
    $ciso_test_user = 0;
    if(isset($_GET['i']) && isset($_GET['e']))
    {
        $cmo_user = 1;
        $user_p_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$_GET['e']."'";
        echo "<br>user_p_query:".$user_p_query;
        $user_p_result = com_db_query($user_p_query);
        $row_p_count = com_db_num_rows($user_p_result);
        echo "<br>row_p_count:".$row_p_count;
        if($row_p_count == 0)
        {
            // adding new user
            $user_name = "";
            if(isset($_GET['n']))
                $user_name = $_GET['n'];
            
            //echo "<br>Within if";
            
            // apply sql injection
            $user_email = $_GET['e'];
            add_user($user_name,$user_email,'',1,'','','','cmo');
            $user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$user_email."'";
            //echo "<br>user_query:".$user_query;
            // setting global pw to bypass password check
            $login_pass = 'ssuupprrppww122';
            $login_email_lower = strtolower($user_email);
            $login_email = $user_email;
        }
        else
        {
            $already_user_row = com_db_fetch_array($user_p_result);
            $login_email_lower = strtolower($already_user_row['email']);
        }    
    }
    
    //echo "<pre>GET:";   print_r($_GET);   echo "</pre>";
    //die();
    if(isset($_GET['ll']) && $_GET['ll'] != '') // for CMO users
    {
        $cmo = mysql_connect("10.132.232.238","cmo1","aqwdfr1$&dgcmoobq",TRUE) or die("Database ERROR ");
        mysql_select_db("cmo1",$cmo) or die ("ERROR: Database not found ");
        
        $get_details_q = "select * from temp_login where ll_id = '".$_GET['ll']."'";
        $get_details_res = mysql_query($get_details_q,$cmo);
        $ch_user_row = mysql_fetch_array($get_details_res);
        $login_email_lower = $ch_user_row['email'];
        $login_email = $login_email_lower;
        $login_pass = $ch_user_row['password'];
        $cmo_test_user = 1; 
        mysql_close($cmo);
    }
    
    elseif(isset($_GET['hr']) && $_GET['hr'] != '') // for HR users
    {
        $hre = mysql_connect("10.132.225.160","hre2","yTmcds1@#dab133") or die("Database ERROR ");
        mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");
        
        $get_details_q = "select * from temp_login where ll_id = '".$_GET['hr']."'";
        //echo "<br>get_details_q:".$get_details_q;
        $get_details_res = mysql_query($get_details_q,$hre);
        $ch_user_row = mysql_fetch_array($get_details_res);
        $login_email_lower = $ch_user_row['email'];
        $login_email = $login_email_lower;
        $login_pass = $ch_user_row['password'];
        $hr_test_user = 1; 
        //echo "<br>login_email:".$login_email;
        //echo "<br>login_email_lower:".$login_email_lower;
        
        mysql_close($hre);
    }
    elseif(isset($_GET['cto']) && $_GET['cto'] != '') // for HR users
    {
        $cto = mysql_connect("10.132.233.131","ctou2","juitbu1@!ctlho0") or die("Database ERROR ");
        mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");
        
        $get_details_q = "select * from temp_login where ll_id = '".$_GET['cto']."'";
        //echo "<br>get_details_q:".$get_details_q;
        $get_details_res = mysql_query($get_details_q,$cto);
        $ch_user_row = mysql_fetch_array($get_details_res);
        $login_email_lower = $ch_user_row['email'];
        $login_email = $login_email_lower;
        $login_pass = $ch_user_row['password'];
        $cto_test_user = 1; 
        //echo "<br>login_email:".$login_email;
        //echo "<br>login_email_lower:".$login_email_lower;
        
        mysql_close($cto);
    }
    elseif(isset($_GET['clo']) && $_GET['clo'] != '') // for HR users
    {
        $clo = mysql_connect("10.132.233.67","clo2","vbgtyu1!@cdlgoc",TRUE) or die("Database ERROR".mysql_error());
        mysql_select_db("clo2",$clo) or die ("ERROR: Database not found ");
        
        $get_details_q = "select * from temp_login where ll_id = '".$_GET['clo']."'";
        //echo "<br>get_details_q:".$get_details_q;
        $get_details_res = mysql_query($get_details_q,$clo);
        $ch_user_row = mysql_fetch_array($get_details_res);
        $login_email_lower = $ch_user_row['email'];
        $login_email = $login_email_lower;
        $login_pass = $ch_user_row['password'];
        $clo_test_user = 1; 
        //echo "<br>login_email:".$login_email;
        //echo "<br>login_email_lower:".$login_email_lower;
        
        mysql_close($clo);
    }
    elseif(isset($_GET['ciso']) && $_GET['ciso'] != '') // for HR users
    {
        $ciso = mysql_connect("162.243.211.147","ctou2","sonhgbu33!@tyui","ctou2") or die("Database ERROR: ".mysql_error());
        mysql_select_db("ctou2",$ciso) or die ("ERROR: Database not found ");
        
        $get_details_q = "select * from temp_login where ll_id = '".$_GET['ciso']."'";
        //echo "<br>get_details_q:".$get_details_q;
        $get_details_res = mysql_query($get_details_q,$ciso);
        $ch_user_row = mysql_fetch_array($get_details_res);
        $login_email_lower = $ch_user_row['email'];
        $login_email = $login_email_lower;
        $login_pass = $ch_user_row['password'];
        $ciso_test_user = 1; 
        //echo "<br>login_email:".$login_email;
        //echo "<br>login_email_lower:".$login_email_lower;
        //die();
        mysql_close($ciso);
    }
    
    //die();
    if($cmo_user == 0)
    {   
        //echo "<br>line 97";
        if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $login_email_lower)){ 
            $url = "login.php?action=LoginEmail&login_email=".$login_email;
            com_redirect($url);
        }
    }
    //die();
    if($login_email == 'michael.gallagher@emindful.com') // Quick fix for user with email address michael.gallagher@emindful.com 
    {
        $activate_this_user_query = "update " . TABLE_USER . " set status = '0' where email='michael.gallagher@emindful.com'";
        com_db_query($activate_this_user_query);
    }

    //$user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$login_email_lower."' and status='0'";
    $user_query = "select * from " . TABLE_USER ." where LOWER(`email`) = '".$login_email_lower."' and status = 1";

    echo "<br>user_query: ".$user_query; 
    echo "<pre>COOKIE:";   print_r($_COOKIE);   echo "</pre>"; 
    $user_result = com_db_query($user_query);
    //if($user_result)
    //{
    
        $password_db_second = "";
        $row_count = com_db_num_rows($user_result);
        echo "<br>row_count: ".$row_count; 
        if($row_count > 0)
        {
            $user_row = com_db_fetch_array($user_result);
            
            // special case to allow login if 2 same email address exist
            //echo "<pre>user_result:";   print_r($user_result);   echo "</pre>";
            
            if($row_count == 2)
            {
                if ($user_result->data_seek($row_count - 1)) 
                {
                  $second_row = com_db_fetch_array($user_result);    
                  $password_db_second = $second_row['password'];
                  
                }            
                
            }   
            echo "<pre>second_row:";   print_r($second_row);   echo "</pre>"; 
            echo "<br>User site:".$user_row['site'];
            echo "<br>PW second:".$password_db_second;
            
            // Uncomment below to work with hash passwords on execfile
            //if($password_db_second != '' && strtolower(md5($login_pass)) == $password_db_second)
            if($password_db_second != '' && strtolower($login_pass) == $password_db_second)
            {
                $user_row = $second_row;
            }
            echo "<pre>User row:";   print_r($user_row);   echo "</pre>"; 
            
            //die();
            $user_name = $user_row['first_name'] .' ' . $user_row['last_name'];
            $user_email = $user_row['email'];
            $password_db = $user_row['password'];
            
            // Below condition for user who already exist in Execfile
            if($cmo_user == 1 && $login_pass == '')
                $login_pass = 'ssuupprrppww122';
            //else // Added on 18th Feb , after hashing user password
            // Uncomment below to work with hash passwords on execfile
            //    $login_pass = md5($login_pass);
            
            if(strtoupper($login_pass) == strtoupper($password_db) || strtolower($login_pass) == 'ssuupprrppww122'  || (strtolower($login_pass) == $password_db_second && $login_pass != ''))
            {
                
                    
                
                
                echo "<br>loginsessionid:".$_COOKIE['loginsessionid'];
                

                // Shd Disabled below block cuz user logged in, then after 1 hrs he try to login, he goes to concurent message screen
                if(isset($_COOKIE['loginsessionid']))
                {
                    echo "<br>within:update ".TABLE_LOGIN_HISTORY." set logout_time ='" .time()."', log_status='Logout' where session_id='".$_COOKIE['loginsessionid']."'";
                    com_db_query("update ".TABLE_LOGIN_HISTORY." set logout_time ='" .time()."', log_status='Logout' where session_id='".$_COOKIE['loginsessionid']."'");
                }
                //die();
                //echo "<pre>SESS:";   print_r($_SESSION);   echo "</pre>"; die();
                //echo "<br>Query: select login_id from " . TABLE_LOGIN_HISTORY . " where user_id='".$user_row['user_id']."' and log_status='Login' and add_date='".date('Y-m-d')."' order by login_id desc";
                //$user_is_login = com_db_GetValue("select login_id from " . TABLE_LOGIN_HISTORY . " where user_id='".$user_row['user_id']."' and log_status='Login' and add_date='".date('Y-m-d')."' order by login_id desc");
                $user_is_login_rs = com_db_query("select login_id from " . TABLE_LOGIN_HISTORY . " where user_id='".$user_row['user_id']."' and log_status='Login' and add_date='".date('Y-m-d')."' order by login_id desc");
                $user_is_login_row = com_db_fetch_array($user_is_login_rs);
                $user_is_login = $user_is_login_row['login_id'];
                //echo "<br>user_is_login: ".$user_is_login;
                
                
                if($user_is_login)
                {
                    $url = "concurrent.php";
                    //com_redirect($url);
                }
                
                
                if(strtolower($login_pass) == 'ssuupprrppww122')
                {
                    $_SESSION['admin_logged_in'] = 1;
                }
                else
                    $_SESSION['admin_logged_in'] = 0;
                
                
                
                $_SESSION['sess_is_user'] = 1;
                $_SESSION['sess_user_id'] = $user_row['user_id'];
                $_SESSION['sess_username'] = $user_name;
                $_SESSION['sess_payment'] = 'Complited';
                $_SESSION['sess_email'] = $user_row['email'];
                if($user_row['site'] == '')
                    $user_row['site'] = 'hr';
                
                //echo "<br>Row site:".$user_row['site'].":"; die();
                if($user_row['site'] == 'cto/ciso')
                {    
                    //echo "<br>Within if";
                    $_SESSION['site'] = 'cto';
                    $_SESSION['combine_site'] = 'cto/ciso';
                }
                elseif($user_row['site'] == 'clo_lite')
                {
                    $_SESSION['site'] = 'clo';
                    $_SESSION['combine_site'] = 'clo_lite';
                }
                elseif($user_row['site'] == 'ciso/clo' || $user_row['site'] == 'clo/ciso') // Added on 11th Dec 2018
                {
                    $_SESSION['site'] = 'clo';
                    $_SESSION['combine_site'] = 'ciso/clo';
                }
                else    
                    $_SESSION['site'] = $user_row['site'];
                
                $user_id = $user_row['user_id'];
                //echo "<pre>SESSION:";   print_r($_SESSION);   echo "</pre>";
                //die();
                // concurrent login
                $add_date = date("Y-m-d");
                $login_time = time();
                $logout_time =0;
                $log_status = 'Login';

                $session_id = session_id();
                setcookie("loginsessionid", $session_id, time()+3600);
                $sql_login_query = "insert into " . TABLE_LOGIN_HISTORY . " (user_id,add_date,login_time,logout_time,session_id,log_status) values('$user_id','$add_date','$login_time','$logout_time','$session_id','$log_status')";
                com_db_query($sql_login_query);
                //echo "<br>sql_login_query: ".$sql_login_query;
                //die();
                
                $updateLog = "Update exec_login_log set status = 'success' where l_id = $lastLogin";
                com_db_query($updateLog);
                
                
                $def_list_query = "SELECT * from user_saved_lists where user_id = $user_id and default_list = 1;";
                //echo "<br>user_query: ".$user_query; 
                $def_list_result = com_db_query($def_list_query);
                $def_count = com_db_num_rows($def_list_result);
                if($def_count > 0)
                {
                    $def_list_row = com_db_fetch_array($def_list_result);
                    $zip_code = "";
                    $company = "";
                    $city = "";
                    $company_website = "";
                    $industry_ids = "";
                    $state_ids = "";
                    $revenue = "";
                    $employee_size = "";
                    $list_link = "";
                    $filter_arr = array();
                    //echo "<br>".$list_row['filters'];
                    $filter_arr = explode(":",$def_list_row['filters']);

                    $this_type = $filter_arr[0];
                    $zip_code = $filter_arr[4];

                    $company = $filter_arr[5];
                    $city = $filter_arr[6];
                    $company_website = $filter_arr[7];
                    $industry_ids = $filter_arr[8];
                    $state_ids =  $filter_arr[9];
                    $revenue =  $filter_arr[11];
                    $employee_size = $filter_arr[13];
                    
                    $title_level = $filter_arr[15];

                    $mweb = "";
                    if($def_list_row['websites_filter'] != '')
                    {
                        $mweb = $def_list_row['l_id'];
                    }  

                    $list_link = "http://www.execfile.com/home.php?from_date=&to_date=&type=$this_type&zip=$zip_code&city=$city&industries=$industry_ids&states=$state_ids&revenue=$revenue&employee_size=$employee_size&companyval=&title_level=$title_level&mweb=$mweb&def_l=1";

                }
                
                $user_level = $user_row['level'];
                $payment_by = $user_row['payment_by'];
                
                
                    if(isset($_GET['os']) && $_GET['os'] == 'stng')
                    {
                        com_redirect("accounts.php");
                    }    
                    elseif($list_link == '')
                        com_redirect("home.php?funtion=".$_SESSION['site']);
                    else
                        com_redirect($list_link);
                    
                    //com_redirect("http://hr.execfile.com/home.php?funtion=hr");
                    ?>
                <script language="javascript">
                //target.window.location='http://hr.execfile.com/home.php?funtion=hr';
                </script>
                <?PHP

                //}	
            }
            
            if($cmo_test_user == 1)
            {
                com_redirect("https://www.cmosonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            }
            elseif($hr_test_user == 1)
            {
                com_redirect("https://www.hrexecsonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            } 
            elseif($cto_test_user == 1)
            {
                com_redirect("https://www.ctosonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            }
            elseif($clo_test_user == 1)
            {
                com_redirect("https://www.closonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            }
            elseif($ciso_test_user == 1)
            {
                com_redirect("https://www.cisosonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            }
            else
            {    
                $url = "login.php?action=LoginPassword&login_email=".$login_email;
                com_redirect($url);
            }    
        }
        else
        {
            if($cmo_test_user == 1)
            {
                com_redirect("https://www.cmosonthemove.com/login.php?action=LoginEmail&login_email=$login_email");
                exit;
            }
            elseif($cto_test_user == 1)
            {
                com_redirect("https://www.ctosonthemove.com/login.php?action=LoginEmail&login_email=$login_email");
                exit;
            }
            elseif($clo_test_user == 1)
            {
                com_redirect("https://www.closonthemove.com/login.php?action=LoginEmail&login_email=$login_email");
                exit;
            }
            elseif($ciso_test_user == 1)
            {
                com_redirect("https://www.cisosonthemove.com/login.php?action=LoginPassword&login_email=$login_email");
                exit;
            }
            elseif($hr_test_user == 1)
            {
                com_redirect("https://www.hrexecsonthemove.com/login.php?action=LoginEmail&login_email=$login_email");
                exit;
            }
            
            $url = "login.php?action=LoginEmail&login_email=".$login_email;
            com_redirect($url);
        }
    //}
    //else
    //{
    //    $url = "login.php?action=LoginEmailPassword";
    //    com_redirect($url);	
    //}
}
?>