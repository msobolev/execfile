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
/*
if($action == 'UserSearchResult' || $_SESSION['sess_action']=='UserSearchResult')
{
    echo "<br>In if";
	if($action == 'UserSearchResult'){
		$first_name	= $_POST['sfirst_name'];
		$last_name	= $_POST['slast_name'];
		$title		= $_POST['stitle'];
		$company	= $_POST['scompany'];
		$status		= $_POST['sstatus'];
		$level		= $_POST['slevel'];
		$form_date	= $_POST['from_date'];
		$to_date	= $_POST['to_date'];
		
		$_SESSION['sess_first_name'] = $first_name;
		$_SESSION['sess_last_name'] = $last_name;
		$_SESSION['sess_title'] = $title;
		$_SESSION['sess_company'] = $company;
		$_SESSION['sess_status'] = $status;
		$_SESSION['sess_level'] = $level;
		$_SESSION['sess_form_date'] = $form_date;
		$_SESSION['sess_to_date'] = $to_date;
		$_SESSION['sess_action'] = $action;
	}else{
		$first_name	= $_SESSION['sess_first_name'];
		$last_name	= $_SESSION['sess_last_name'];
		$title		= $_SESSION['sess_title'];
		$company	= $_SESSION['sess_company'];
		$status		= $_SESSION['sess_status'];
		$level		= $_SESSION['sess_level'];
		$form_date	= $_SESSION['sess_form_date'];
		$to_date	= $_SESSION['sess_to_date'];
	}
	$search_qry='';
	if($first_name!=''){
		$search_qry .= " first_name like '".$first_name."%'";
	}
	if($last_name!=''){
		if($search_qry==''){
			$search_qry .= " last_name like '".$last_name."%'";
		}else{
			$search_qry .= " and last_name like '".$last_name."%'";
		}	
	}
	if($title!=''){
		if($search_qry==''){
			$search_qry .= " title ='".$title."'";
		}else{
			$search_qry .= " and title ='".$title."%'";
		}	
	}
	if($company!=''){
		if($search_qry==''){
			$search_qry .= " company_name = '".$company."'";
		}else{
			$search_qry .= " and company_name = '".$company."'";
		}	
	}
	
	if($status!=''){
		if($search_qry==''){
			$search_qry .= " status = '".$status."'";
		}else{
			$search_qry .= " and status = '".$status."'";
		}	
	}
	if($level!=''){
		if($search_qry==''){
			$search_qry .= " level = '".$level."'";
		}else{
			$search_qry .= " and level = '".$level."'";
		}	
	}
	if($from_date!='' && strlen($from_date)==10 && $to_date !='' && strlen($to_date)==10){
		$fdt = explode('/',$from_date);
		$fdate = $fdt[2].'-'.$fdt[0].'-'.$fdt[1];
		$tdt = explode('/',$to_date);
		$tdate = $tdt[2].'-'.$tdt[0].'-'.$tdt[1];
		if($search_qry==''){
			$search_qry .= " res_date >= '".$fdate."' and res_date <='".$tdate."'";
		}else{
			$search_qry .= " and res_date >= '".$fdate."' and res_date <='".$tdate."'";
		}	
	}
	if($search_qry==''){
		$sql_query = "select * from " . TABLE_USER . " order by user_id desc";
	}else{
		$sql_query = "select * from " . TABLE_USER . " where ". $search_qry." order by user_id desc";
	}

}
else
{
*/	
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
    
    
    
    //$sql_query = "select * from " . TABLE_USER . " $where_clause order by user_id desc";
    //$sql_query = "select * from " . TABLE_USER . " $where_clause order by user_id desc";
    
    $sql_query = "select * from " . TABLE_USER . " $where_clause and (site = '' || site = 'hr') and status = 1 order by user_id desc";
    
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

    switch ($action) {
		
	  case 'delete':
	   		
			com_db_query("delete from " . TABLE_USER . " where user_id = '" . $uID . "'");
			$_SESSION['sess_action']='';
		 	com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("User deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$user_id = $_POST['nid'];
			$_SESSION['sess_action']='';
			for($i=0; $i< sizeof($user_id) ; $i++){
				com_db_query("delete from " . TABLE_USER . " where user_id = '" . $user_id[$i] . "'");
			}
		 	com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("User deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_USER . " where user_id = '" . $uID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name=com_db_output($data_edit['first_name']);
			$last_name=com_db_output($data_edit['last_name']);
			$title=com_db_output($data_edit['title']);
			$company=com_db_output($data_edit['company_name']);
			$phone = com_db_output($data_edit['phone']);
			$email=com_db_output($data_edit['email']);
			$password = com_db_output($data_edit['password']);
			$rdt = explode('-',$data_edit['res_date']);
			$reg_date = date('m/d/Y',mktime(0,0,0,$rdt[1],$rdt[2],$rdt[0]));
			$edt = explode('-',$data_edit['exp_date']);
			$exp_date = date('m/d/Y',mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
			$sub_status = $data_edit['status'];
			$subscription_id = $data_edit['subscription_id'];
			$_SESSION['sess_action']='';
		break;	
		
		case 'editsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$last_name = com_db_input($_POST['last_name']);
			$title = com_db_input($_POST['title']);
			$company_name = com_db_input($_POST['company_name']);
			$phone = com_db_input($_POST['phone']);
			$email = com_db_input($_POST['email']);
			$password = com_db_input($_POST['password']);
			$modify_date = date('Y-m-d');
			$rdt = $_POST['reg_date'];
			if($rdt !='' && strlen($rdt)==10){
				$rdt = explode('/',$rdt);
				$reg_date = date('Y-m-d',mktime(0,0,0,$rdt[0],$rdt[1],$rdt[2]));
			}else{
				$reg_date = '';
			}
			$edt = $_POST['exp_date'];
			if($edt !='' && strlen($edt)==10){
				$edt = explode('/',$edt);
				$exp_date = date('Y-m-d',mktime(0,0,0,$edt[0],$edt[1],$edt[2]));
			}else{
				$exp_date = '';
			}
			$sub_status = $_POST['sub_status'];
			$subscription_id = $_POST['subscription_id'];
			if($subscription_id=='1'){
				$sub_level='Free';
			}else{
				$sub_level='Paid';
			}
			
			$Free_Paid = com_db_GetValue("select level from " .TABLE_USER." where user_id='".$uID."'");
			
			$query = "update " . TABLE_USER . " set first_name = '" . $first_name . "',  last_name = '" . $last_name . "', title = '" . $title . "', company_name = '".$company_name."', phone = '".$phone."', email='".$email."', password = '" . $password ."', modify_date = '".$modify_date."', exp_date='".$exp_date."',res_date='".$reg_date."',subscription_id='".$subscription_id."', status='".$sub_status."', level ='".$sub_level."'  where user_id = '" . $uID . "'";
			com_db_query($query);
			
			if($Free_Paid != $sub_level){
				$query = "update " . TABLE_USER . " set payment_by = 'Admin' where user_id = '" . $uID . "'";
				com_db_query($query);
				com_db_query("insert into ".TABLE_ADMIN_PAYMENT_RECIVE."(user_id,level,date_time,add_date)values('$uID','$sub_level','".time()."','".date('Y_m-d')."')");
			}
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=". $p ."&uID=" . $uID . "&selected_menu=user&msg=" . msg_encode("User update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$first_name = com_db_input($_POST['first_name']);
			$last_name = com_db_input($_POST['last_name']);
			$title = com_db_input($_POST['title']);
			$company_name = com_db_input($_POST['company_name']);
			$phone = com_db_input($_POST['phone']);
			$email = com_db_input($_POST['email']);
			$password = com_db_input($_POST['password']);
			$exp_date = date('Y-m-d',mktime(0,0,0,date("m"),date("d"),date("Y")+5));
			
			$added = date('Y-m-d');
			$_SESSION['sess_action']='';
			$query = "insert into " . TABLE_USER . " (first_name, last_name, title, company_name, phone, email, password, subscription_id, exp_date, res_date, referring_links, accept, status) values ('$first_name', '$last_name', '$title','$company_name','$phone','$email','$password','1','$exp_date','$added','Admin','1','0')";
			com_db_query($query);
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=" . $p . "&selected_menu=user&msg=" . msg_encode("New news added successfully"));
		 
		break;	
	/*	
	case 'detailes':
			
			$query_edit=com_db_query("select * from " . TABLE_USER . " where user_id = '" . $uID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			
			$first_name = com_db_output($data_edit['first_name']);
			$last_name = com_db_output($data_edit['last_name']);
			$title = com_db_output($data_edit['title']);
			$company_name = com_db_output($data_edit['company_name']);
			$phone = com_db_output($data_edit['phone']);
			$email = com_db_output($data_edit['email']);
			$password = com_db_output($data_edit['password']);
			$subscription_name = com_db_GetValue("select subscription_name from " . TABLE_SUBSCRIPTION . " where sub_id = '". $data_edit['subscription_id'] ."'");
			$add_date =explode('-',$data_edit['res_date']);
			$post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));
			$rdt = explode('-',$data_edit['res_date']);
			$reg_date = date('m/d/Y',mktime(0,0,0,$rdt[1],$rdt[2],$rdt[0]));
			$edt = explode('-',$data_edit['exp_date']);
			$exp_date = date('m/d/Y',mktime(0,0,0,$edt[1],$edt[2],$edt[0]));
			if($data_edit['status']==0){
				$sub_status='Active';
			}else{
				$sub_status='Not Active';
			}	
			$sub_level=$data_edit['level'];
			$_SESSION['sess_action']='';
			
		break;	
        */        
                
	case 'activate':
     		
	   		$status=$_GET['status'];
			if($status==0){
				$query = "update " . TABLE_USER . " set status = '1' where user_id = '" . $uID . "'";
			}else{
				$query = "update " . TABLE_USER . " set status = '0' where user_id = '" . $uID . "'";
			}	
			com_db_query($query);
			$_SESSION['sess_action']='';
	  		com_redirect("user.php?p=". $p ."&uID=" . $uID . "&selected_menu=user&msg=" . msg_encode("User update successfully"));
			
		break;
	case 'AlertConfirm':
     		
	   /*	$title 				= $_POST['title'];
		if($title =='Type in the Title'){$title ='';}
		$management 		= $_POST['management'];
		$country			= $_POST['country'];
		$state				= $_POST['state'];
		$city				= $_POST['city'];
		if($city =='Type in the City'){$city ='';}
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Type in the Zip code'){	$zip_code='';}
		$company			= $_POST['company'];
		if($company =='Type in the Company Name'){$company='';}
		$industry			= $_POST['industry'];
		$revenue_size		= $_POST['revenue_size'];
		$employee_size		= $_POST['employee_size'];
		$delivery_schedule 	= $_POST['delivery_schedule'];
		$monthly_budget		= $_POST['monthly_budget'];*/
		$title 				= $_POST['title'];
		if($title =='Type in the Title'){$title ='';}
		$management 		= $_POST['management'];
		if($management>0){
			$management_type = com_db_output(com_db_GetValue("select name from " .TABLE_MANAGEMENT_CHANGE. " where id='".$management."'"));
		}
		$country			= $_POST['country'];
		//$state				= $_POST['state'];
		if($country>0){
			$country_name = com_db_output(com_db_GetValue("select countries_name from " .TABLE_COUNTRIES. " where countries_id='".$country."'"));
		}
		$state_arr			= $_POST['state'];
		if(sizeof($state_arr)>0 && $state_arr[0] !=''){
			$state_id_arr = implode(",",$state_arr);
			$stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
			$stateResult = com_db_query($stateQuery);
			$state_list = '';
			while($stateRow = com_db_fetch_array($stateResult)){
				if($state_list==''){
					$state_list = $stateRow['short_name'];
				}else{
					$state_list .= "<br>". $stateRow['short_name'];
				}
			}
		}
		
		$city				= $_POST['city'];
		if($city =='Type in the City'){$city ='';}
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Type in the Zip code'){	$zip_code='';}
		$company			= $_POST['company'];
		if($company =='Type in the Company Name'){$company='';}
		//$industry			= $_POST['industry'];
		//$revenue_size		= $_POST['revenue_size'];
		//$employee_size		= $_POST['employee_size'];
		//$delivery_schedule 	= $_POST['delivery_schedule'];
		$industry_arr		= $_POST['industry'];
		if(sizeof($industry_arr)>0 && $industry_arr[0] !=''){
			$industry_id_arr = implode(",",$industry_arr);
			$industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
			$industryResult = com_db_query($industryQuery);
			$industry_list = '';
			while($industryRow = com_db_fetch_array($industryResult)){
				if($industry_list==''){
					$industry_list = $industryRow['title'];
				}else{
					$industry_list .= "<br>". $industryRow['title'];
				}
			}
		}
		$revenue_size_arr	= $_POST['revenue_size'];
		if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !=''){
			$revenue_size_id_arr = implode(",",$revenue_size_arr);
			$revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
			$revenueResult = com_db_query($revenueQuery);
			$revenue_size_list = '';
			while($revenueRow = com_db_fetch_array($revenueResult)){
				if($revenue_size_list==''){
					$revenue_size_list = $revenueRow['name'];
				}else{
					$revenue_size_list .= "<br>". $revenueRow['name'];
				}
			}
		}
		
		$employee_size_arr	= $_POST['employee_size'];
		if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !=''){
			$employee_size_id_arr = implode(",",$employee_size_arr);
			$employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
			$employeeResult = com_db_query($employeeQuery);
			$employeee_size_list = '';
			while($employeeRow = com_db_fetch_array($employeeResult)){
				if($employee_size_list==''){
					$employee_size_list = $employeeRow['name'];
				}else{
					$employee_size_list .= "<br>". $employeeRow['name'];
				}
			}
		}
		
		$delivery_schedule 	= $_POST['delivery_schedule'];
		$_SESSION['sess_action']='';	
		break;	
	case 'CreateAlert':
     	
	   	$title 				= $_POST['title'];
		if($title =='Type in the Title'){$title ='';}
		$management 		= $_POST['management'];
		if($management>0){
			$management_type = com_db_output(com_db_GetValue("select name from " .TABLE_MANAGEMENT_CHANGE. " where id='".$management."'"));
		}
		$country			= $_POST['country'];
		//$state				= $_POST['state'];
		if($country>0){
			$country_name = com_db_output(com_db_GetValue("select countries_name from " .TABLE_COUNTRIES. " where countries_id='".$country."'"));
		}
		$state_arr			= $_POST['state'];
		if(sizeof($state_arr)>0 && $state_arr[0] !=''){
			$state_id_arr = implode(",",$state_arr);
			$stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
			$stateResult = com_db_query($stateQuery);
			$state_list = '';
			while($stateRow = com_db_fetch_array($stateResult)){
				if($state_list==''){
					$state_list = $stateRow['short_name'];
				}else{
					$state_list .= "<br>". $stateRow['short_name'];
				}
			}
		}
		
		$city				= $_POST['city'];
		if($city =='Type in the City'){$city ='';}
		$zip_code			= $_POST['zip_code'];
		if($zip_code =='Type in the Zip code'){	$zip_code='';}
		$company			= $_POST['company'];
		if($company =='Type in the Company Name'){$company='';}
		//$industry			= $_POST['industry'];
		//$revenue_size		= $_POST['revenue_size'];
		//$employee_size		= $_POST['employee_size'];
		//$delivery_schedule 	= $_POST['delivery_schedule'];
		$industry_arr		= $_POST['industry'];
		if(sizeof($industry_arr)>0 && $industry_arr[0] !=''){
			$industry_id_arr = implode(",",$industry_arr);
			$industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
			$industryResult = com_db_query($industryQuery);
			$industry_list = '';
			while($industryRow = com_db_fetch_array($industryResult)){
				if($industry_list==''){
					$industry_list = $industryRow['title'];
				}else{
					$industry_list .= "<br>". $industryRow['title'];
				}
			}
		}
		$revenue_size_arr	= $_POST['revenue_size'];
		if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !=''){
			$revenue_size_id_arr = implode(",",$revenue_size_arr);
			$revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
			$revenueResult = com_db_query($revenueQuery);
			$revenue_size_list = '';
			while($revenueRow = com_db_fetch_array($revenueResult)){
				if($revenue_size_list==''){
					$revenue_size_list = $revenueRow['name'];
				}else{
					$revenue_size_list .= "<br>". $revenueRow['name'];
				}
			}
		}
		
		$employee_size_arr	= $_POST['employee_size'];
		if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !=''){
			$employee_size_id_arr = implode(",",$employee_size_arr);
			$employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
			$employeeResult = com_db_query($employeeQuery);
			$employeee_size_list = '';
			while($employeeRow = com_db_fetch_array($employeeResult)){
				if($employee_size_list==''){
					$employee_size_list = $employeeRow['name'];
				}else{
					$employee_size_list .= "<br>". $employeeRow['name'];
				}
			}
		}
		
		$delivery_schedule 	= $_POST['delivery_schedule'];
		$monthly_budget		= $_POST['monthly_budget'];
		$_SESSION['sess_action']='';
		break;		
	case 'CreateAlertBack':
		$title 				= $_POST['title'];
		$management 		= $_POST['management'];
		$country			= $_POST['country'];
		
		$state_id_arr		= explode(",", $_POST['state']);
		$city				= $_POST['city'];
		$zip_code			= $_POST['zip_code'];
		$company			= $_POST['company'];
		
		$industry_id_arr		= explode(",",$_POST['industry']);
		$revenue_size_id_arr	= explode(",", $_POST['revenue_size']);
		
		$employee_size_id_arr	= explode(",",$_POST['employee_size']);
		
		$delivery_schedule 	= $_POST['delivery_schedule'];
				
		$monthly_budget		= $_POST['monthly_budget'];
		break;
    }
	


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

<?php if(($action == '') || ($action == 'save') || ($action == 'UserSearch') || ($action == 'UserSearchResult')){	?>			

                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                        <tr>
                            <td align="center" valign="middle" class="right">
                                <form id="filters_frm" method="post" action="user.php">
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="16%" align="left" valign="middle" class="heading-text">User Manager</td>
                                        <td width="43%" align="left" valign="middle" class="message"><?=$msg?></td>
                                        <td width="40%">
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
                                        </td>
                                        <!--
                                        <td width="4%" align="right" valign="middle"><a href="#"><img src="images/search-icon.jpg" border="0" width="25" height="28"  alt="Search User" title="Search User" onclick="UserSearch('UserSearch');"  /></a></td>
                                        <td width="6%" align="left" valign="middle" class="nav-text">Search</td>
                                        <td width="4%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add User" title="Add User" onclick="window.location='user.php?action=add&selected_menu=user'"  /></a></td>
                                        <td width="7%" align="left" valign="middle" class="nav-text">Add New </td>
                                        <td width="4%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete User" title="Delete User" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                                        <td width="6%" align="left" valign="middle" class="nav-text">Delete</td>
                                        -->
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
                                
                                
                               
                                /*
                                echo "<br><br><br>last_14_days_download:".$last_14_days_download;
                                echo "<br>last_14_days_searches:".$last_14_days_searches;
                                echo "<br>last_14_days_opened:".$last_14_days_opened;
                                echo "<br>this_user_alerts:".$this_user_alerts;
                                echo "<br>this_user_download:".$this_user_download;
                                echo "<br>this_user_search:".$this_user_search;
                                echo "<br>user_id:".$data_sql['user_id'];
                                */
                                
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
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-bottom:170px;">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?php echo admin_number_pages($main_page, $p, $total_data, 8, $items_per_page,'&site='.$_REQUEST['site'].'&status='.$_REQUEST['status']);?>		  
          </tr>
        </table></td>
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