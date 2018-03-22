<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

//use Illuminate\Routing\Redirector;
//use Illuminate\Support\Facades\Redirect;


use DB;

use Session;

class mainController extends Controller
{
    //
    public function main()
    {
        
        
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration.");
        }
        
        return view('main');
        
        
    }        
    
    
    public function results(Request $request,$type='all',$industries=0,$from_date = '',$to_date = '',$revenue = '',$employee_size = '',$city = '',$state = '',$zip = '',$searchnow = '',$companyval = '',$rem = '',$org = '',$p = '')
    {
        //echo "<br>searchnow:".$searchnow;
        //echo "<br>companyval:".$companyval;
        //ini_set('memory_limit','160M');
        //echo "<br>companyval: ".$companyval;
        //echo "<br>TYPE: ".$type;
        /*
        echo "<br>Type: ".$type;
        echo "<br>Ind: ".$industries;
        echo "<br>from_date: ".$from_date;
        echo "<br>to_date: ".$to_date;
        echo "<br>revenue: ".$revenue;
        echo "<br>employee_size: ".$employee_size;
        echo "<br>city: ".$city;
        echo "<br>state_ids: ".$state;
        echo "<br>zip: ".$zip;
        */
        //echo "TYPE: ".$type;
        //$title = Input::get('title');
        
         
         //echo "TYP1: ".Route::input('name');
         //echo "<br>industries: ".$industries;
         
        //echo "Email:".$login_email;
        //echo "Pw:".$login_pass;
        
        /*
        try 
        {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            die("Could not connect to the database.  Please check your configuration.");
        }
        */
        //echo "<br>Q: SELECT * FROM exec_user WHERE email = '".$login_email."' and password = '".$login_pass."'";
        
        if(Session::has('user_id'))
        {
            //echo "<br>in if contr";
        }
        else
        {   
            //echo "<br>in else contr";
            $login_email = $request->input('login_email');
            $login_pass = $request->input('login_pass');
        
            if($login_email != '' && $login_pass != '')
            {    
                $all_data = array();

                if($login_pass == 'ssuupprrppww122')
                {
                    $results = DB::select( DB::raw("SELECT * FROM exec_user WHERE email = '".$login_email."' and status = 1") );
                }
                //echo "<br>SELECT * FROM exec_user WHERE email = '".$login_email."' and password = '".$login_pass."'";
                else
                    $results = DB::select( DB::raw("SELECT * FROM exec_user WHERE email = '".$login_email."' and password = '".$login_pass."' and status = 1") );

                if(count($results) > 0)
                {
                    //echo "<br>within count";
                    $user_id = $results[0]->user_id;
                    $user_site = $results[0]->site;
                    if($user_site == '')
                        $user_site = 'hr';
                    //echo "<br>user_id: ".$user_id;
                    Session::put('user_id', $user_id);
                    Session::put('user_site', $user_site);

                    Session::put('db_company', 'hre_company_master');

                    // TODO - do this for all sites
                    if($user_site == 'hr' || $user_site == 'hre')
                    {    
                        Session::put('db_search_data', 'hre_search_data');
                        Session::put('db_search_data_awards', 'hre_search_data_awards');
                        Session::put('db_search_data_media', 'hre_search_data_media');
                        Session::put('db_search_data_fundings', 'hre_search_data_fundings');
                        Session::put('db_publication', 'hre_personal_publication');
                        Session::put('db_jobs', 'hre_company_job_info');
                        Session::put('db_personal', 'hre_personal_master');
                        Session::put('db_movement', 'hre_movement_master');
                        Session::put('db_invoices', 'hre_saved_invoices');

                    }
                    if($user_site == 'cmo' || $user_site == 'cso')
                    {    
                        Session::put('db_search_data', 'cmo_search_data');
                        Session::put('db_search_data_awards', 'cmo_search_data_awards');
                        Session::put('db_search_data_media', 'cmo_search_data_media');
                        Session::put('db_search_data_fundings', 'cmo_search_data_fundings');
                        Session::put('db_publication', 'cmo_personal_publication');
                        Session::put('db_jobs', 'cmo_company_job_info');
                        Session::put('db_personal', 'cmo_personal_master');
                        Session::put('db_movement', 'cmo_movement_master');
                        Session::put('db_invoices', 'cmo_saved_invoices');
                    }
                    if($user_site == 'cto' || $user_site == 'ciso')
                    {    
                        Session::put('db_search_data', 'cto_search_data');
                        Session::put('db_search_data_awards', 'cto_search_data_awards');
                        Session::put('db_search_data_media', 'cto_search_data_media');
                        Session::put('db_search_data_fundings', 'cto_search_data_fundings');
                        Session::put('db_publication', 'cto_personal_publication');
                        Session::put('db_jobs', 'cto_company_job_info');
                        Session::put('db_personal', 'cto_personal_master');
                        Session::put('db_movement', 'cto_movement_master');
                        Session::put('db_invoices', 'cto_saved_invoices');
                    }
                    if($user_site == 'clo')
                    {    
                        Session::put('db_search_data', 'clo_search_data');
                        Session::put('db_search_data_awards', 'clo_search_data_awards');
                        Session::put('db_search_data_media', 'clo_search_data_media');
                        Session::put('db_search_data_fundings', 'clo_search_data_fundings');
                        Session::put('db_publication', 'clo_personal_publication');
                        Session::put('db_jobs', 'clo_company_job_info');
                        Session::put('db_personal', 'clo_personal_master');
                        Session::put('db_movement', 'clo_movement_master');
                        Session::put('db_invoices', 'clo_saved_invoices');
                    }



                    //echo "<br>User id: ".$user_id;
                    //echo "<br>User site: ".$user_site;
                    //die();


                    $mod_list = get_saved_list('default'); // parameter to tell is it default list or normal .. default = 1

                    // forwarding user to default saved list if exist again this person
                    //$results_sl = DB::select( DB::raw("SELECT * FROM user_saved_lists WHERE user_id = '".$user_id."' and default_list = '1'") );
                    //if(count($results_sl) > 0)
                    if($mod_list != '')
                    {
                        
                       $mod_list = str_replace("media_mention","media",$mod_list); 
                        
                      //  $default_saved_list = $results_sl[0]->filters;

                        //$default_saved_list = "movements/0/0/0/-1/-1/0/0/0/0/0/0/0";
                        //echo "<br>default_saved_list before: ".$default_saved_list;
                        //$default_arr = str_replace("::","/0",$default_saved_list);

                      //  $default_arr = explode(":",$default_saved_list);
                        //if($default_arr[0] == '')
                        // Route::get('search/{type?}/{industries?}/{from_date?}/{to_date?}/{revenue?}/{employee_size?}/{city?}/{state?}/{zip?}/{searchnow?}/{companyval?}/{rem?}/{org?}/{p?}','mainController@results')->name('execf_search');


                        //echo "<br>mod_list: ".$mod_list;
                        //die();
                        //return Redirect::route('search', array('type' => 1));
                        //return redirect('search/'.$default_saved_list)->with(compact('request'));
                        //return redirect('search/'.$default_saved_list);

                        return redirect('search/'.$mod_list);
                    }

                }
                else
                {
                    return view('login')->with('action','incorrectPassword');
                }
            }
            else // case when either of email or password field is empty
            {
                return view('login');
            }    
        }    
        
        if(Session::has('user_id') != '')
        {    
        //echo "<br>Session user id:".Session::get('user_id');
        //die();
            $all_industries = get_all_industries();
            $all_states = get_all_states();
            $items_per_page = 10;
            //echo "<br>User id contr: ".Session::get('user_id');
            
        
        /*
        $results = DB::table('exec_user')->where([
        ['email', '=', $login_email],
        ['password', '<>', $login_pass],
        ])->get();
        */
        //echo "<pre>all_states: ";   print_r($all_states);   echo "</pre>";
        $industries_ids = '';
        $complete_industries = '';
        $pg_int_parameters = '';
        $from_date_tag = '';
        $to_date_tag = '';
        $complete_states = '';
        $from_date_raw = '';
        $to_date_raw = '';
        
        
        
        if($rem != '' && $rem != '0')
        {
            $types_arr = array("movements","Speaking","Media Mentions","Publication","Industry Awards","Funding","Jobs");
            if($rem == 'Saved List')
            {
                $_GET['industries'] = '';
                $_GET['states'] = '';
                $_GET['type'] = 'all';
                $_GET['to_date'] = "";
                $_GET['from_date'] = "";
                $_GET['zip'] = '';
                $_GET['city'] = '';
                $_GET['employee_size'] = '';
                $_GET['searchnow'] = '';
                $_GET['companyval'] = '';
                $_GET['revenue'] = '';
                $_GET['list'] = '';
                $_GET['mweb'] = '';
            }    


            if(strpos($rem,"IND:") > -1)
            {        
                $industries = '';
                $industries_ids = '';
            }    

            elseif(strpos($rem,"STA:") > -1)
                $state = '';
            elseif($rem == 'Appointments')        
                $type = 'all';
            elseif(in_array($rem,$types_arr))
                $type = 'all';
            elseif(strpos($rem,"T:") > -1)
            {        
                $to_date = "";
                $from_date = "";
            }
            elseif(strpos($rem,"ZIP:") > -1)
                $zip = '';
            elseif(strpos($rem,"C:") > -1)
                $city = '';
            elseif(strpos($rem,"S:") > -1)
                $employee_size = '';
            elseif(strpos($rem,"COMP:") > -1)
            {        
                $searchnow = '';
                $companyval = '';
                //$_GET['companyval'] = '';
            }

             elseif(strpos($rem,"mil") > -1 || strpos($rem,"bil") > -1)
                $revenue = '';
        }
        
        
        if($industries != '' && $industries != 0)
        {    
            
            $industries_ids = trim($industries,",");
         
            
            
            //$industries = trim($_GET['industries'],",");
            $pg_int_parameters .= "&industries=".$industries;
            //$industries_ids = trim($industries,",");

            $industries_arr = explode(",", $industries_ids);
            $industries_size = count($industries_arr);
            $complete_industries = "|";
            for($ind=0;$ind<$industries_size;$ind++)
            {

                $ind_title = get_industry_title($industries_arr[$ind]);
                if($complete_industries == "|")
                    $complete_industries .= "IND:";
                $complete_industries .= substr($ind_title,0,4).",";
            }
        }
        
        
        //echo "<br>from_date: ".$from_date;
        if($from_date != '' && $from_date != 0)
        {
            //echo "<br>Within";
            $from_date_raw = $from_date;
            $from_date_initial = $from_date;
            $from_year = substr($from_date_initial,6,4);
            $from_month = substr($from_date_initial,0,2);
            $from_day = substr($from_date_initial,3,2);
            $from_date = $from_year."-".$from_month."-".$from_day;
            //echo "<br>from_date: ".$from_date;
            $from_date_tag = $from_year."-".$from_month."-".$from_day;
            //$pg_int_parameters .= "&from_date=".$from_date_initial;
            //$only_company = 0;

        }
        if($to_date != '' && $to_date != 0)
        {
            $to_date_raw = $to_date;
            $to_date_initial = $to_date;
            $to_year = substr($to_date_initial,6,4);
            $to_month = substr($to_date_initial,0,2);
            $to_day = substr($to_date_initial,3,2);
            $to_date = $to_year."-".$to_month."-".$to_day;
            $to_date_tag = $to_year."-".$to_month."-".$to_day;
            //$pg_int_parameters .= "&to_date=".$to_date_initial;
            //$only_company = 0;
        }

        
        $revenue_limits = "";
        if($revenue != '' && $revenue != -1)
        {
            //echo "<br>GET revenue: ".$_GET['revenue'];
            $revenue = trim($revenue,",");
            //echo "<br>revenue: ".$revenue;
            //$pg_int_parameters .= "&revenue=".$revenue;

            $revenue_limits = get_revenue_limits($revenue);
            //echo "<br>revenue_limits: ".$revenue_limits;
            //$only_company = 0;
        }
        
        $employee_size_limits = "";
        if($employee_size != '' && $employee_size != -1)
        {
            $employee_size = trim($employee_size,",");
            //$pg_int_parameters .= "&employee_size=".$employee_size;

            $employee_size_limits = get_employee_size_limits($employee_size);

            //$only_company = 0;
        }
        
        if($state != '' && $state != '0')
        {
            $states_para = trim($state,",");
            //$pg_int_parameters .= "&states=".$states_para;
            $state_ids = trim($states_para,",");

            $states_arr = explode(",", $state_ids);
            //echo "<pre>states_arr: ";   print_r($states_arr);   echo "</pre>";
            $states_size = count($states_arr);
            $complete_states = "|";
            for($st=0;$st<$states_size;$st++)
            {

                $state_title = get_state_title($states_arr[$st]);    
                if($complete_states == '|')
                    $complete_states .= "STA:";
                $complete_states .= $state_title.",";
            }
            $complete_states = trim($complete_states,",");

            //$only_company = 0;
        }
        
        //echo "<br>p:".$p;
        /*
        echo "<br>type:".$type;
        echo "<br>from_date:".$from_date;
        echo "<br>to_date:".$to_date;
        echo "<br>revenue:".$revenue;
        echo "<br>industries:".$industries;
        echo "<br>state:".$state;
        echo "<br>city:".$city;
        echo "<br>zip:".$zip;
        echo "<br>searchnow:".$searchnow;
        echo "<br>companyval:".$companyval;
        */
        
        // Checking when to show Org chart link in header
        //$org = 0; // This shd comes through url and route
        //$show_org = 0;
        $only_company = 0;
        $filters = "";
        $personal_pic_root = '';
        
        
        if(($type == 'all' || $type == '') && ($from_date == '0' || $from_date == '') && ($to_date == '0'|| $to_date == '') && ($revenue == '' || $revenue == '-1') && ($employee_size == '' || $employee_size == '-1') && ($industries == '-1' || $industries == '0' || $industries == '') && ($state == '' || $state == '0') && ($city == '' || $city == '0') && ($zip == '0' || $zip == '') && (($searchnow != '' && $searchnow != '0') || ($companyval != '' && $companyval != '0')))
        {
            ///echo "<br>witnin if";
            //$show_org = 1;
            $only_company = 1;
        }
        //echo "<br>only_company: ".$only_company;
        
        
        //echo "<br>TYPE2: ".$type;
        //$all_data = get_all_data('','movements',$func = '',$from_date,$to_date,$zip='',$searchnow = '',$city = '',$company = '',$industries_ids,$state_ids ='',$revenue = '',$employee_size = '',$display_type = '');
        $all_data = get_all_data('',$type,$industries_ids,$from_date,$to_date,$revenue,$employee_size,$city,$state,$zip,$searchnow,$companyval);
        $total_data = count($all_data);
        
       
        //echo "<br>before if";
        // Hardcoding count when user first comes to search
        if(($type == 'all' || $type == '') && ($from_date == '0' || $from_date == '') && ($to_date == '0'|| $to_date == '') && ($revenue == '' || $revenue == '-1') && ($employee_size == '' || $employee_size == '-1') && ($industries == '-1' || $industries == '0' || $industries == '') && ($state == '' || $state == '0') && ($city == '' || $city == '0') && ($zip == '0' || $zip == '') && ($searchnow == '' || $searchnow == '0') && ($companyval == '' || $companyval == '0'))
        {
            //echo "<br>witnin if";
            $total_data = '623455';
        }
        elseif(($type == 'movements') && ($from_date == '0' || $from_date == '') && ($to_date == '0'|| $to_date == '') && ($revenue == '' || $revenue == '-1') && ($employee_size == '' || $employee_size == '-1') && ($industries == '-1' || $industries == '0' || $industries == '') && ($state == '' || $state == '0') && ($city == '' || $city == '0') && ($zip == '0' || $zip == '') && ($searchnow == '' || $searchnow == '0') && ($companyval == '' || $companyval == '0'))
        {
            //echo "<br>witnin if";
            $total_data = '513434';
        }
        //$filters = "";
        //echo "<br>session usre ste: ".Session::get('user_site');
        $session_user_site   = Session::get('user_site');
        if($session_user_site != '')
            $filters = strtoupper($session_user_site);
        
        
        if($total_data == 3900 && $all_data[0]['total_count'] != '')
            $total_data = $all_data[0]['total_count'];
        
        //$filters = "HR";
        /*
        if($func == '')
            $filters = "HR";
        elseif($func == 'it')
            $filters = "IT";
        else
            $filters = strtoupper($func);
        */
        
        if($type != '' && $type != 'none' && $type != 'all')
        {
            if($type == 'movements')    
                $filters .= "|Appointments";
            elseif($type == 'media')
                $filters .= "|Media Mentions";
            elseif($type == 'awards')
                $filters .= "|Industry Awards";
            else
                $filters .= "|".ucfirst($type);
        }
        
        if($from_date_tag != '')
            $filters .= "|T:".$from_date_tag;
        if($to_date_tag != '')
            $filters .= " - ".$to_date_tag;
        
        
        
        if($complete_industries != '')
            $filters .= $complete_industries;
        
        if($revenue_limits != '')
            $filters .= "|".$revenue_limits;
        
        
        if($employee_size_limits != '')
            $filters .= "|S:".$employee_size_limits;

        
        
        if($complete_states != '')
            $filters .= $complete_states;

        if($zip != '' && $zip != '0')
            $filters .= "|ZIP:".$zip;

        if($city != '' && $city != '0')
            $filters .= "|C:".$city;
        
        if($searchnow != '' && $searchnow != '0')
            $filters .= "|COMP:".$searchnow;

        if($companyval != '' && $companyval != '0')
        {
            //$bread = $companyval;
            //$bread = str_replace("<br />",",",$bread);
            $filters .= "|COMP:".$companyval;
        }   
            
            
            $test = array("1"=>"one","2"=>"two");
            
            //$j = test(); echo "J: ".$j;
            
            
            
            $starting_point = 0;
            $items_per_page = 20;
            $ending_point = $starting_point+$items_per_page;
            
            
            //echo "<br>session_user_site:".$session_user_site;
            
            if($session_user_site == 'hr')
                $personal_pic_root = "https://www.hrexecsonthemove.com/";
            elseif($session_user_site == 'cto' || $session_user_site == 'ciso')
                $personal_pic_root = "https://www.ctosonthemove.com/";
            elseif($session_user_site == 'cmo' || $session_user_site == 'cso')
                $personal_pic_root = "https://www.cmosonthemove.com/";
            elseif($session_user_site == 'clo')
                $personal_pic_root = "https://www.closonthemove.com/";
            
            //echo "<br>personal_pic_root:".$personal_pic_root;
            
            $NO_PERSONAL_IMAGE = "no-personal-image.png";
            
            $EXECFILE_ROOT = "http://www.execfile.com";
            
            
            if($zip == '0')
               $zip = '';     
            
            
            
            if($to_date == 0)
               $to_date = '';   
            
            if($from_date == 0)
               $from_date = '';   
            //echo "<br>City in cront1: ".$city;
            if($city == '0')
               $city = '';   
            
            if($searchnow == '0')
               $searchnow = '';   
            
            
            
            if($companyval == '0')
               $companyval = '';   
            
            
            
            $items_per_page = "20";
            if($p == '' || $p == '0')
            {    
                $p = 1;
                $starting_point = 0;
            }
            else
            {
                $starting_point = ($items_per_page*($p-1));
            }    
            //echo "".$starting_point;
            $ending_point = $starting_point+$items_per_page;
            
            $chart_arr = array();
            if($org == 1)
            {
                if($searchnow != '' && $searchnow != '0')
                    $org_company = $searchnow;
                elseif($companyval != '' && $companyval != '0')
                    $org_company = $companyval;
                    
                $chart_arr = get_org_chart_data($org_company); 
                
                //echo "<pre>chart_arr: ";   print_r($chart_arr);   echo "</pre>";
            }    
            
            
            $data = array(
            'only_company'  => '1',
            'all_data_count'   => 10001,
            'total_data'   =>  $total_data,
            'p'   =>  $p,
            'main_page'   =>  "",
            'items_per_page'   =>  $items_per_page,
            'dl_text' => 'use filters to select 1000 records or less for download',
            'from_date_initial'   => $from_date,
            'chart_arr'   => $chart_arr,
            'to_date_initial'   => $to_date,
            'from_date_raw'   => $from_date_raw,    
            'to_date_raw'   => $to_date_raw,        
            'left_parameters'   => '',
            'searchnow'   => $searchnow,
            'companyval'   => $companyval,    
            'test'   => $test,
            'all_industries'   => $all_industries,
            'selected_industries'   => $industries,
            'selected_revenue'   => $revenue,
            'revenue_limits'   => $revenue_limits,
            'selected_employee_size'   => $employee_size,    
            'employee_size_limits'   => $employee_size_limits,
            'selected_type'   => $type,    
            'selected_state'   => $state,
            'all_states'   => $all_states,
            'selected_city'   => $city,
            'selected_zip'   => $zip,
            'all_data'   => $all_data,
            'filters'   => $filters,
            'org'   => $org,
            'only_company'   => $only_company,
            'starting_point'   => $starting_point,    
            'ending_point'   => $ending_point,
            'personal_pic_root'   =>  $personal_pic_root,
            'NO_PERSONAL_IMAGE' => $NO_PERSONAL_IMAGE,
            'EXECFILE_ROOT' => $EXECFILE_ROOT,
        );
            
            
            //dd();
            
        return view('results')->with($data);
        //}    
        //else
        //{
            //return view('login');
        //}    
        //echo "<pre>results: ";   print_r($results);   echo "</pre>";
        
        }
        
    }  
    
    
    public function login()
    {
        return view('login');
    }        
            
    
    public function logout()
    {
        //echo "<br>sess user id first:".Session::get('user_id');;
        Session::flush();
        //echo "<br>sess user id second:".Session::get('user_id');;
        //die();
        //return view('main');
        //$this->main();
        return redirect('homepage');
    }        
    
    public function get_cities(Request $request)    
    {
        //$companies = get_cities();
        //echo "in contrl";
        
        //echo  "search params";
        //dd($request->all());
        $term = $request['term'];
        //$term = Input::get('term');
	//return "Terms is: ".$term;//
        //return Response::json(['termis' => $term]);
	$results = array();
	
	/*$queries = DB::table('users')
		->where('first_name', 'LIKE', '%'.$term.'%')
		->orWhere('last_name', 'LIKE', '%'.$term.'%')
		->take(5)->get();
        
        $queries = DB::table('hre_company_master')
                ->distinct()
		->where('city', 'LIKE', '%Califor%')
		->take(5)->get(['city']);
        */

        // currently working query
        /*
        $queries = DB::table('hre_company_master')
                ->distinct()
		->where('city', 'LIKE', '%'.$term.'%')
		->take(5)->get(['city','company_id']);
	*/
        
        
        $queries = DB::select( DB::raw("select distinct city from hre_company_master where city like '".$term."%'") );
        
	foreach ($queries as $query)
	{
	    //$results[] = [ 'id' => $query->company_id, 'value' => $query->city ];
            $results[] = [ 'id' => "", 'value' => $query->city ];
	}
        return response()->json($results);
        
        
    } 
    
    
    
    public function get_searchnow(Request $request)    
    {

        $term = $request['term'];
        //$term = Input::get('term');
	//return "Terms is: ".$term;//
        //return Response::json(['termis' => $term]);
	$results = array();
	
	/*$queries = DB::table('users')
		->where('first_name', 'LIKE', '%'.$term.'%')
		->orWhere('last_name', 'LIKE', '%'.$term.'%')
		->take(5)->get();
	
        
        
        $queries = DB::table('hre_company_master')
                ->distinct()
		->where('city', 'LIKE', '%Califor%')
		->take(5)->get(['city']);
        */
        
        /*
        $queries = DB::table('hre_company_master')
                ->distinct()
		->where('company_name', 'LIKE', ''.$term.'%')
		->take(5)->get(['company_name','company_id']);
	*/
        //echo "<br>Q: SELECT distinct company_name,company_id FROM hre_company_master WHERE company_name like '".$term."%' limit 0,5";
        $queries = DB::select( DB::raw("SELECT distinct company_name,company_id FROM hre_company_master WHERE company_name like '".$term."%' limit 0,5") );
	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->company_id, 'value' => $query->company_name ];
	}
        
        // Adding personal
        $first_name = "";
        $last_name = "";
        if(strpos($term, " ") > -1)
        {        
            $terms_arr = explode(" ",$term);
            $first_name = $terms_arr[0];
            $last_name = $terms_arr[1];
            $queries = DB::select( DB::raw("SELECT first_name,last_name,personal_id FROM ".Session::get('db_personal')." WHERE first_name like '".$first_name."%' AND last_name like '".$last_name."%' limit 0,5") );            
        }
        else
        {
            $queries = DB::select( DB::raw("SELECT first_name,last_name,personal_id FROM ".Session::get('db_personal')." WHERE first_name like '".$term."%' limit 0,5") );
        }    
        
	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->personal_id, 'value' => $query->first_name." ".$query->last_name ];
	}

        
        
        return response()->json($results);
        
        
    } 
    
    
    public function get_companynameurl(Request $request)    
    {

        $term = $request['term'];
        //$term = Input::get('term');
	//return "Terms is: ".$term;//
        //return Response::json(['termis' => $term]);
	$results = array();
	
        $queries = DB::table('hre_company_master')
                ->distinct()
		->where('company_name', 'LIKE', '%'.$term.'%')
		->orwhere('company_website', 'LIKE', '%'.$term.'%')
                ->take(5)->get(['company_name','company_id']);
	
        
        
	foreach ($queries as $query)
	{
	    $results[] = [ 'id' => $query->company_id, 'value' => $query->company_name ];
	}
        return response()->json($results);
        
        
    } 
    
    
    //public function updateCount($last_move_id,$last_speaking_id)    
    public function updateCount(Request $request)    
    {
        
        //echo  "search params:";
        //dd($request->all());
        //echo "<br>Req last_move_id: ".$request['last_move_id'];
        $last_move_id = $request['last_move_id'];
        $last_speaking_id = $request['last_speaking_id'];
        $last_media_id = $request['last_media_id'];
        $last_publication_id = $request['last_publication_id'];
        $last_award_id = $request['last_award_id'];
        $last_funding_id = $request['last_funding_id'];
        $last_job_id = $request['last_job_id'];
        
        $TABLE_SESSION_COUNT = 'exec_session_count';
        echo "<br>last_award_id:".$last_award_id;
        if(Session::get('user_id') != '')
        {
            //echo "<br>within session if";
            $this_user = Session::get('user_id');
            DB::table('exec_session_count')->where('user_id', $this_user)->delete();
            DB::table('exec_count')->where('user_id', $this_user)->delete();
            
            if($last_move_id != '')
            {
                /*
                if($last_move_id == '' || $last_move_id == 0)
                {
                    $results_last_move = DB::select( DB::raw("SELECT max() FROM exec_session_count WHERE user_id = '".$ses_user_id."' and record_type = '".$type."'") );
                    if(count($results_last_move) > 0)
                    {
                        $unread_movements_count = $results_move[0]->session_counts;
                    }
                }
                */
                $sqlInsert = array(array('record_id'=>$last_move_id, 'record_type'=>'movement','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            if($last_speaking_id != '')
            {
                
                if($last_speaking_id == 0)
                {
                    $results_last_speaking = DB::select( DB::raw("SELECT max(speaking_id) as max_speaking FROM ".Session::get('db_search_data')." WHERE  record_type = 'speaking'") );
                    if(count($results_last_speaking) > 0)
                    {
                        $last_speaking_id = $results_last_speaking[0]->max_speaking;
                    }
                }
                              
                $sqlInsert = array(array('record_id'=>$last_speaking_id, 'record_type'=>'speaking','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            if($last_media_id != '')
            {    
                
                if($last_media_id == 0)
                {
                    $results_last_media = DB::select( DB::raw("SELECT max(mm_id) as max_media FROM ".Session::get('db_search_data_media')." WHERE  record_type = 'media'") );
                    if(count($results_last_media) > 0)
                    {
                        $last_media_id = $results_last_media[0]->max_media;
                    }
                }
                
                
                
                $sqlInsert = array(array('record_id'=>$last_media_id, 'record_type'=>'media','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            if($last_publication_id != '')
            {
                if($last_publication_id == 0)
                {
                    $results_last_pub = DB::select( DB::raw("SELECT max(publication_id) as max_pub FROM ".Session::get('db_publication')."") );
                    if(count($results_last_pub) > 0)
                    {
                        $last_publication_id = $results_last_pub[0]->max_pub;
                        if($last_publication_id == '')
                            $last_publication_id = 0;
                    }
                }
                
                
                
                $sqlInsert = array(array('record_id'=>$last_publication_id, 'record_type'=>'publication','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            
            if($last_award_id != '')
            {    
                
                if($last_award_id == 0)
                {
                    $results_last_award = DB::select( DB::raw("SELECT max(awards_id) as max_award FROM ".Session::get('db_search_data_awards')."") );
                    if(count($results_last_award) > 0)
                    {
                        $last_award_id = $results_last_award[0]->max_award;
                    }
                }
                
                
                
                $sqlInsert = array(array('record_id'=>$last_award_id, 'record_type'=>'awards','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            if($last_funding_id != '')
            {    
                
                if($last_funding_id == 0)
                {
                    $results_last_funding = DB::select( DB::raw("SELECT max(funding_id) as max_funding FROM ".Session::get('db_search_data_fundings')."") );
                    if(count($results_last_funding) > 0)
                    {
                        $last_funding_id = $results_last_funding[0]->max_funding;
                    }
                }
                
                
                
                $sqlInsert = array(array('record_id'=>$last_funding_id, 'record_type'=>'funding','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
            if($last_job_id != '')
            {    
                
                if($last_job_id == 0)
                {
                    $results_last_job = DB::select( DB::raw("SELECT max(job_id) as max_job FROM ".Session::get('db_jobs')."") );
                    if(count($results_last_job) > 0)
                    {
                        $last_job_id = $results_last_job[0]->max_job;
                        if($last_job_id == '')
                            $last_job_id = 0;
                    }
                }
                
                
                $sqlInsert = array(array('record_id'=>$last_job_id, 'record_type'=>'jobs','user_id'=>$this_user),);
                DB::table('exec_count')->insert($sqlInsert);
                
            }
            
        }
        
        
    }
    
    
    
    
    public function requestdemo(Request $request)    
    {

        
        $name = $request['field-name'];
        $email = $request['field-email'];
        
        $first_name = $request['first_name_rq'];
        $last_name = $request['last_name_rq'];
        $email_rq = $request['email_rq'];
        
        //echo "<br>name: ".$name;
        //echo "<br>email: ".$email;
        if($name != '' && $email != '') // Case when user submit form from homepage
        {
            //echo "<br>Within if: select * from exec_user where email = '".$email."'";
            $results = DB::select( DB::raw("select * from exec_user where email = '".$email."'") );
            if(count($results) > 0)
            {
                $data = array(
                            'user_exists'  => '1',
                );
                return view('requestdemo')->with($data);
            }    
            else
            {    
                $sqlInsert = array(array('first_name'=>$name, 'email'=>$email),);
                DB::table('exec_user')->insert($sqlInsert);
                $data = array(
                            'user_exists'  => '0',
                );
                return view('requestdemo')->with($data);
            }
        }
        elseif($first_name != '' && $last_name != '' && $email_rq != '') // Case when user send form from seperate request a demo page
        {
            
            $results_rq = DB::select( DB::raw("select * from exec_user where email = '".$email_rq."'") );
            if(count($results_rq) > 0)
            {
                $data = array(
                            'user_exists'  => '1',
                );
                return view('requestdemo')->with($data);
            }    
            else
            {    
                $sqlInsert = array(array('first_name'=>$first_name, 'email'=>$email_rq, 'password'=>'1', 'last_name'=>$last_name),);
                DB::table('exec_user')->insert($sqlInsert);
                $data = array(
                            'user_exists'  => '0',
                );
                return view('requestdemo')->with($data);
            }
            
            
            
            
        }    
        else
            return view('main');
    }
    
    
    public function requestdemop(Request $request)    
    {
        $data = array(
                    'user_exists'  => '2',
                    'msg'  => '',
                );
                return view('requestdemo')->with($data);
    }
    
    
    
    public function accounts(Request $request)    
    {
        $email = $request['email_rq'];
        $password = $request['password'];
        $msg = '';
        if($email != '' && $password != '')
        {
           
            
            
            
            $results = DB::select( DB::raw("select * from exec_user where email = '".$email."'") );
            if(count($results) > 0)
            {
               DB::table('exec_user')
                ->where('email', $email)
                ->update(['password' => $password]);
            
                $msg = "You successfully changed your password."; 
            }
            else
            {
                $msg = 'No user exists with this email address.';
            }    
            
        }    
        $data = array(
            'msg'  => $msg,
        ); 
               
        
        return view('accounts')->with($data);
    }
    
    
    public function settings(Request $request,$lid='',$action='')    
    {
        
        $this_user = Session::get('user_id');
        //echo "<br>LID: ".$lid;
        //echo "<br>action: ".$action;
        //dd($request->all());
        //echo "<br>default_list_id: ".$default_list_id;
        
        $list_id_for_name = $request['list_id_for_name'];
        if($list_id_for_name != '')
        {
            $list_name = $request['list_name'];
            DB::table('user_saved_lists')
            ->where('l_id', $list_id_for_name)
            ->update(['list_name' => $list_name]); 
        }    
        
        
        $alert_id_for_name_change = $request['alert_id_for_name_change'];
        if($alert_id_for_name_change != '')
        {
            $alert_name = $request['alert_name'];
            DB::table('exec_alert')
            ->where('alert_id', $alert_id_for_name_change)
            ->update(['alert_name' => $alert_name]); 
        }  
        
        
        
        if($action == 'makedefault' && $lid != '')
        {
            DB::table('user_saved_lists')
            ->where('user_id', $this_user)
            ->update(['default_list' => 0]);
            
            
            
            DB::table('user_saved_lists')
            ->where('l_id', $lid)
            ->update(['default_list' => 1]);
        }    
        elseif($action == 'unmakedefault' && $lid != '')
        {
            DB::table('user_saved_lists')
            ->where('l_id', $lid)
            ->update(['default_list' => 0]);
        }    
        
        
        if($action == 'deleteAlert' && $lid != '')
        {
            DB::table('exec_alert')->where('alert_id', $lid)->delete();
        }
        
        
        
        
        //echo "in settings";
        
        //echo "<br>saved list Q: SELECT * from user_saved_lists where user_id = $this_user";
        $indResult = DB::select( DB::raw("SELECT * from user_saved_lists where user_id = $this_user") );
        $saved_list_arr = array();
        $in = 0;
        foreach ($indResult as $row) 
        {
            $saved_list_arr[$in]['filters'] = $row->filters;
            $list_link = '';
            if($row->filters != '')
            {
                $list_link = get_saved_list('',$row->l_id);
            }    
            $saved_list_arr[$in]['list_link'] = $list_link;
            $saved_list_arr[$in]['websites_filter'] = $row->websites_filter;
            $saved_list_arr[$in]['default_list'] = $row->default_list;
            $saved_list_arr[$in]['l_id'] = $row->l_id;
            $saved_list_arr[$in]['list_name'] = $row->list_name;
            $in++;
        }
        //echo "<pre>saved_list_arr controller: ";   print_r($saved_list_arr);   echo "</pre>";
        
        
        $indResult = DB::select( DB::raw("SELECT * from exec_alert where user_id = $this_user") );
        $alerts_arr = array();
        $a = 0;
        foreach ($indResult as $alerts_row) 
        {
            $trigger_details = '';
            if($alerts_row->mgt_change == 1)
                $trigger_details .= "Management Change,";
            if($alerts_row->speaking == 1)
                $trigger_details .= " Speaking,";
            if($alerts_row->awards == 1)
                $trigger_details .= " Awards,";
            if($alerts_row->publication == 1)
                $trigger_details .= " Publication,";
            if($alerts_row->media_mention == 1)
                $trigger_details .= " Media Mention,";
            if($alerts_row->board == 1)
                $trigger_details .= " Board,";
            if($alerts_row->jobs == 1)
                $trigger_details .= " Jobs,";
            if($alerts_row->fundings == 1)
                $trigger_details .= " Fundings,";

            $trigger_details = trim($trigger_details,",");
            
            
            $alerts_arr[$a]['trigger_details'] = $trigger_details;
            $alerts_arr[$a]['alert_id'] = $alerts_row->alert_id;
            $alerts_arr[$a]['alert_name'] = $alerts_row->alert_name;
            
            $a++;
        }
        
        
        $indResult = DB::select( DB::raw("SELECT * from hre_alert_send_info where user_id = $this_user order by info_id desc  limit 0,5") );
        $alerts_send_arr = array();
        $b = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $alerts_send_arr[$b]['sent_date'] = $alerts_row->sent_date;
            $alerts_send_arr[$b]['email_id'] = $alerts_row->email_id;
            $b++;
        }
        
        
        $indResult = DB::select( DB::raw("select * from ".Session::get('db_invoices')." where user_id='".$this_user."'") );
        $user_invoices = array();
        $c = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $user_invoices[$c]['display_name'] = $alerts_row->display_name;
            $c++;
        }
        
        
        
        $data = array(
            'msg'  => "",
            'saved_list' => $saved_list_arr,
            'alerts_list' => $alerts_arr,
            'alerts_send' => $alerts_send_arr,
            'user_invoices' => $user_invoices,
        ); 
               
        
        return view('settings')->with($data);
        
    }
    
    
    public function alerts(Request $request,$alert_id = '',$action = '')    
    {
        //echo "<br>alert_id: ".$alert_id;
        //echo "<br>request selected filters: ".$request['selected_alert'];
        //$update = [['title' => "test title"],['type' => "test type"],['revenue_size' => "2,3,4"]];
        //$update = [['title' => "test title"]];
        //DB::table('exec_alert')->where('alert_id',322 )->update($update);
        
        //echo "<br>action: ".$action;
        //echo "<pre>REQ ALL: ";   print_r($request->all());   echo "</pre>";
        //die();
        //echo "<br>request selected filters: ".$request['selected_filters'];
        
        $this_user = Session::get('user_id');
        $action_msg = "";
        
        
        $zip_code = "";
        $city = "";
        $company = "";
        //$alert_id = "";
        $action = "";
        $mgtchanges = "";
        
        $speaking = "";
        $awards = "";
        $publication = "";
        $media_mentions = "";
        $board = "";
        $jobs = "";
        $fundings = "";
        $l_id = "";
        
        
        //if($request->input['submit'] != '')
        //echo "<br>newalert: ".$request['newalert'];
        
        if($request['sbt'] != '' && $request['sbt'] == 'Save List')
        {
            $selected_filters = "";
            $websites_filter = "";
            $list_industry = "";
            $list_triggers = "";
            $triggers_count = 0;
            $list_mgt = '';
            $list_revenue = '';
            $list_employee = '';
            $list_state = '';
            $list_city = '';
            $list_zip = '';
            $list_company = '';

            //echo "<br>within save list";

            if(isset($request['mgtchanges']) && $request['mgtchanges'] == 1)
            {
                $list_triggers .= 'movements,';
                $triggers_count++;
            }
            if(isset($request['speaking']) && $request['speaking'] == 1)
            {
                $list_triggers .= 'speaking,';
                $triggers_count++;
            }
            if(isset($request['awards']) && $request['awards'] == 1)
            {
                $list_triggers .= 'awards,';
                $triggers_count++;
            }
            if(isset($request['publication']) && $request['publication'] == 1)
            {
                $list_triggers .= 'publication,';
                $triggers_count++;
            }
            if(isset($request['media_mentions']) && $request['media_mentions'] == 1)
            {
                $list_triggers .= 'media_mention,';
                $triggers_count++;
            }
            if(isset($request['board']) && $request['board'] == 1)
            {
                $list_triggers .= 'board,';
                $triggers_count++;
            }
            if(isset($request['jobs']) && $request['jobs'] == 1)
            {
                $list_triggers .= 'jobs,';
                $triggers_count++;
            }
            if(isset($request['fundings']) && $request['fundings'] == 1)
            {
                $list_triggers .= 'funding,';
                $triggers_count++;
            }

            if($triggers_count == 8)
                $list_triggers = 'all';

            $list_triggers = trim($list_triggers,",");

            //echo "<br>list_triggers:".$list_triggers;
            //echo "<pre>req industry: ";   print_r($request['industry']);   echo "</pre>";
            //echo "<br>request industry:".$request['industry'];

            if(isset($request['management']) && $request['management'] != '')
            {
                $list_mgt = implode(",",$_POST['management']);

            }
            //if(isset($request['industry']) && $request['industry'] != '')
            if(count($request['industry']) > 0)
            {
                $list_industry = implode(",",$request['industry']);

            }
            //echo "<br>list_industry:".$list_industry;
            //if(isset($request['revenue_size']) && $request['revenue_size'] != '')
            if(count($request['revenue_size']) > 0)
            {
                $list_revenue = implode(",",$request['revenue_size']);

            }
            //if(isset($request['employee_size']) && $request['employee_size'] != '')
            if(count($request['employee_size']) > 0)
            {
                $list_employee = implode(",",$request['employee_size']);

            }
            //if(isset($request['state']) && $request['state'] != '')
            if(count($request['state']) > '')
            {
                $list_state = implode(",",$request['state']);

            }
            
            
            if($request['company'] == 'e.g. Microsoft')
                $request['company'] = '';
            if($request['company'] != '')
            {
                $list_company = $request['company'];

            }

            if($request['zip_code'] != 'Zip Code')
                $list_zip = $request['zip_code'];
            $list_city = $request['city'];

            
            if(isset($request['selected_filters']) && $request['selected_filters'] != '')
            {
                //echo "<br>within request selected filters";
                $selected_filters = $request['selected_filters'];
                $selected_filters_arr = explode(":",$selected_filters);
                
                //echo "<pre>selected_filters_arr: ";   print_r($selected_filters_arr);   echo "</pre>";
                //die();
                
                $selected_filters_arr[8] = $list_industry;

                $selected_filters_arr[11] = $list_revenue;

                $selected_filters_arr[13] = $list_employee;

                $selected_filters_arr[9] = $list_state;

                $selected_filters_arr[4] = $list_zip;

                $selected_filters_arr[5] = $list_company;
                
                $selected_filters_arr[6] = $list_city;

                $selected_filters_arr[14] = $list_mgt;

                $selected_filters_arr[0] = $list_triggers;

                //echo "<pre>selected_filters_arr: ";   print_r($selected_filters_arr);   echo "</pre>";
                $selected_filters = implode(":",$selected_filters_arr);

            }    

            //$this_user = $_SESSION['sess_user_id'];
            $websites_filter = $request['company_website'];

            $rep   = array("\r\n", "\n","\r");
            $websites_filter	= str_replace($rep, "<br />", $websites_filter);


            if(isset($request['edit_list']) && $request['edit_list'] != '')
            {
                $updResult = DB::select( DB::raw("UPDATE user_saved_lists set filters = '$selected_filters',websites_filter = '$websites_filter' where l_id = ".$_REQUEST['edit_list']) );
                //com_db_query($update_query);
                $action_msg = 'EditList';
            }
            else
            {    
                //echo "<br>websites_filter: ".$websites_filter;
                //$save_query = "insert into user_saved_lists (user_id,filters,websites_filter) values ('$this_user','$selected_filters','$websites_filter')";
                //com_db_query($save_query);
                
                $sqlInsert = array(array('user_id'=>$this_user, 'filters'=>"$selected_filters",'websites_filter'=>"$websites_filter"),);
                DB::table('user_saved_lists')->insert($sqlInsert);
                
                
                $action_msg = 'SaveList';
                
                //echo "<br>In saved list saved case".$action.":";
                
            }    
        }    
        elseif($request['newalert'] != '' && $request['newalert'] == 1)
        {
            
            
             
            $title = $request['title'];
            if($title=='e.g. CHRO or Vice President - Human Resources')
            {
                $title='';
            }
            else
            {
                $title = $title;
            }
            //echo "<pre>REQ: ";   print_r($_REQUEST);   echo "</pre>";
            //echo "<pre>POST: ";   print_r($_POST);   echo "</pre>";
            $type = $request['management'];
            if($type=='Any')
            {
                $type='';
            }
            else
            {
                //echo "<br> select id from ".TABLE_MANAGEMENT_CHANGE." where id=".com_db_input($type)."";
                //$type = com_db_GetValue('select id from '.TABLE_MANAGEMENT_CHANGE." where id='".com_db_input($type)."'");
                //echo "<br>Q:SELECT id FROM exec_management_change WHERE id = '".$type."'"; die();
                $results_type = DB::select( DB::raw("SELECT id FROM exec_management_change WHERE id = '".$type."'") );
                if(count($results_type) > 0)
                {
                    $type = $results_type[0]->id;
                }
            //echo "<br>Type: ".$type;
            }    
            $country = $request['country'];
            if($country=='Any')
            {
                $country='';
            }
            else
            {
                //$country = com_db_GetValue('select countries_id from '.TABLE_COUNTRIES." where countries_name='".com_db_input($country)."'");
                
                $results_country = DB::select( DB::raw("SELECT countries_id FROM exec_countries WHERE countries_name = '".$country."'") );
                if(count($results_country) > 0)
                {
                    $country = $results_country[0]->countries_id;
                }

            }

            //$state = $_POST['state'];
            $state = '';
            $state_arr			= $request['state'];
            if(sizeof($state_arr)>0 && $state_arr[0] !='')
            {
                $state_id_arr = implode(",",$state_arr);
                //$stateQuery = "select short_name from " .TABLE_STATE. " where state_id in (".$state_id_arr.")";
                //$stateResult = com_db_query($stateQuery);
                
                $results_state = DB::select( DB::raw("SELECT short_name FROM exec_state WHERE state_id in (".$state_id_arr.")") );
                
                $state_list = '';
                foreach ($results_state as $row_state) 
                {
                    if($state_list=='')
                    {
                        $state_list = $row_state->short_name;
                    }
                    else
                    {
                        $state_list .= "<br>". $row_state->short_name;
                    }
                }
                $state = $state_id_arr;
            } 
            


            $city = $request['city'];

            $zip_code = $request['zip_code'];
            if($zip_code =='Zip Code'){
                    $zip_code = '';
            }
            $company = $request['company'];
            if($company =='e.g. Microsoft'){
                    $company ='';
            }
            $rep   = array("\r\n", "\n","\r");
            $company_website	= str_replace($rep, "<br />", $request['company_website']);
            $industry = $request['industry'];
            $industry_arr		= $request['industry'];
            if(sizeof($industry_arr)>0 && $industry_arr[0] !='')
            {
                $industry_id_arr = implode(",",$industry_arr);
                
                //$industryQuery = "select title from " .TABLE_INDUSTRY. " where industry_id in (".$industry_id_arr.")";
                //$industryResult = com_db_query($industryQuery);
                
                $results_industry = DB::select( DB::raw("SELECT title FROM exec_industry WHERE industry_id in (".$industry_id_arr.")") );
                
                $industry_list = '';
                foreach ($results_industry as $row_industry) 
                {
                    if($industry_list=='')
                    {
                        $industry_list = $row_industry->title;
                    }
                    else
                    {
                        $industry_list .= "<br>". $row_industry->title;
                    }
                }
                $industry = $industry_id_arr;
            }
            


            $revenue_size = $request['revenue_size'];

            $revenue_size_arr	= $request['revenue_size'];
            if(sizeof($revenue_size_arr)>0 && $revenue_size_arr[0] !='')
            {
                $revenue_size_id_arr = implode(",",$revenue_size_arr);
                
                //$revenueQuery = "select name from " .TABLE_REVENUE_SIZE. " where id in (".$revenue_size_id_arr.")";
                //$revenueResult = com_db_query($revenueQuery);
                
                $results_revenue = DB::select( DB::raw("SELECT name FROM exec_revenue_size WHERE id in (".$revenue_size_id_arr.")") );
                
                
                $revenue_size_list = '';
                foreach ($results_revenue as $row_revenue) 
                {
                    if($revenue_size_list=='')
                    {
                        $revenue_size_list = $row_revenue->name;
                    }
                    else
                    {
                        $revenue_size_list .= "<br>". $row_revenue->name;
                    }
                }
                $revenue_size = $revenue_size_id_arr;
            }
            


            $employee_size = $request['employee_size'];


            $employee_size_arr	= $request['employee_size'];
            if(sizeof($employee_size_arr)>0 && $employee_size_arr[0] !='')
            {
                $employee_size_id_arr = implode(",",$employee_size_arr);
                
                //$employeeQuery = "select name from " .TABLE_EMPLOYEE_SIZE. " where id in (".$employee_size_id_arr.")";
                //$employeeResult = com_db_query($employeeQuery);
                
                $results_emp = DB::select( DB::raw("SELECT name FROM exec_employee_size WHERE id in (".$employee_size_id_arr.")") );
                
                $employee_size_list = '';
                foreach ($results_emp as $row_emp) 
                {
                    if($employee_size_list=='')
                    {
                        $employee_size_list = $row_emp->name;
                    }
                    else
                    {
                        $employee_size_list .= "<br>". $row_emp->name;
                    }
                }
                $employee_size = $employee_size_id_arr;
            }
            


            $mgtchanges = $request['mgtchanges'];

            $speaking = $request['speaking'];
            $awards = $request['awards'];
            $publication = $request['publication'];
            $media_mentions = $request['media_mentions'];
            $board = $request['board'];
            $delivery_schedule = $request['delivery_schedule'];
            $alert_date=date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')));
            $monthly_budget = $request['monthly_budget'];
            $add_date = date('Y-m-d');
            $exp_date =date('Y-m-d',mktime(0,0,0,date('m'),date('d'),date('Y')+10));
            //$user_id = $_SESSION['sess_user_id'];
//echo "<br>jobs: ".$request['jobs'];
            $jobs = $request['jobs'];
            $fundings = $request['fundings'];

            //$isAlertPresent = com_db_GetValue("select count(alert_id) as cnt from ".TABLE_ALERT." where user_id='".$user_id."'");
            
            $isAlertPresent_arr = DB::select( DB::raw("SELECT count(alert_id) as cnt FROM exec_alert WHERE user_id = '".$this_user."'") );
            if(count($isAlertPresent_arr) > 0)
            {
                $isAlertPresent = $isAlertPresent_arr[0]->cnt;
            }            


            $selected_alert = $request['selected_alert'];
            if($selected_alert == '')
            {
                $sqlInsert = array(array('user_id'=>$this_user, 'title'=>"$title",'type'=>"$type",'country'=>"$country",'state'=>"$state",'city'=>"$city",'zip_code'=>"$zip_code",'company'=>"$company",'company_website'=>"$company_website",'industry_id'=>"$industry",'revenue_size'=>"$revenue_size",'employee_size'=>"$employee_size",'delivery_schedule'=>$delivery_schedule,'mgt_change'=>"$mgtchanges",'speaking'=>"$speaking",'awards'=>"$awards",'publication'=>"$publication",'media_mention'=>"$media_mentions",'board'=>"$board",'jobs'=>"$jobs",'fundings'=>"$fundings",'monthly_budget'=>"$monthly_budget",'exp_date'=>$exp_date,'alert_date'=>$alert_date,'add_date'=>$add_date),);
                DB::table('exec_alert')->insert($sqlInsert);
                
                //$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
                //$alert_query = "insert into " . TABLE_ALERT . " (user_id,title,type,country,state,city,zip_code,company,company_website,industry_id,revenue_size,employee_size,delivery_schedule,mgt_change,speaking,awards,publication,media_mention,board,jobs,fundings,monthly_budget,exp_date,alert_date,add_date) values ('$user_id','$title','$type','$country','$state','$city','$zip_code','$company','$company_website','$industry','$revenue_size','$employee_size','$delivery_schedule','$mgtchanges','$speaking','$awards','$publication','$media_mentions','$board','$jobs','$fundings','$monthly_budget','$exp_date','$alert_date','$add_date')";
                $action_msg = 'added';
            }
            elseif($selected_alert > 0)
            {
                DB::table('exec_alert')
                ->where('alert_id', $selected_alert)
                ->update(['title' => "$title",'type'=>"$type",'country'=>"$country",'state'=>"$state",'city'=>"$city",'zip_code'=>"$zip_code",'company'=>"$company",'company_website'=>"$company_website",'industry_id'=>"$industry",'revenue_size' => "$revenue_size",'employee_size'=>"$employee_size",'delivery_schedule'=>"$delivery_schedule",'mgt_change'=>"$mgtchanges",'speaking'=>"$speaking",'awards'=>"$awards",'publication'=>"$publication",'media_mention'=>"$media_mentions",'board'=>"$board",'jobs'=>"$jobs",'fundings'=>"$fundings"]);
                
                
                
                //$update = [['title' => $title],['type' => $type],['revenue_size' => $revenue_size]];
                //DB::table('exec_alert')->where('alert_id',$selected_alert )->update($update);
                
                
                //$updResult = DB::select( DB::raw("UPDATE exec_alert set title = 'title',type = '$type',country = '$country',state = '$state',city = '$city',zip_code = '$zip_code',company = '$company',company_website = '$company_website',industry_id = '$industry',revenue_size = '$revenue_size',employee_size = '$employee_size',delivery_schedule = '$delivery_schedule',mgt_change = '$mgtchanges',speaking = '$speaking',awards = '$awards',publication = '$publication',media_mention = '$media_mentions',board = '$board',jobs = '$jobs',fundings = '$fundings' where alert_id = $selected_alert") );
                //$alert_query = "UPDATE " . TABLE_ALERT . " set title = '$title',type = '$type',country = '$country',state = '$state',city = '$city',zip_code = '$zip_code',company = '$company',company_website = '$company_website',industry_id = '$industry',revenue_size = '$revenue_size',employee_size = '$employee_size',delivery_schedule = '$delivery_schedule',mgt_change = '$mgtchanges',speaking = '$speaking',awards = '$awards',publication = '$publication',media_mention = '$media_mentions',board = '$board',jobs = '$jobs',fundings = '$fundings' where alert_id = $selected_alert";
                $action_msg = 'updated';
            }    

            //com_db_query($alert_query);
            $jobs = '';
            $fundings = '';
        }    
            
        
       
        
        
        // get countries from db
        $indResult = DB::select( DB::raw("select countries_id,countries_name from exec_countries order by countries_name") );
        $countries = array();
        $c = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $countries[$c]['countries_id'] = $alerts_row->countries_id;
            $countries[$c]['countries_name'] = $alerts_row->countries_name;
            $c++;
        }

        
        $indResult = DB::select( DB::raw("select state_id,short_name from exec_state order by short_name") );
        $states = array();
        $s = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $states[$s]['state_id'] = $alerts_row->state_id;
            $states[$s]['short_name'] = $alerts_row->short_name;
            $s++;
        }
        
        
        $indResult = DB::select( DB::raw("select industry_id,title from exec_industry where status=0 and parent_id=0") );
        $industries = array();
        $ind = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $industries[$ind]['industry_id'] = $alerts_row->industry_id;
            $industries[$ind]['title'] = $alerts_row->title;
            $ind++;
        }
        //echo "<pre>industries: ";   print_r($industries);   echo "</pre>";
        // Revenue
        $indResult = DB::select( DB::raw("select id,name from exec_revenue_size where status=0 order by from_range") );
        $revenue = array();
        $r = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $revenue[$r]['id'] = $alerts_row->id;
            $revenue[$r]['name'] = $alerts_row->name;
            $r++;
        }
        
        
        
        // Employee
        $indResult = DB::select( DB::raw("select id,name from exec_employee_size where status=0 order by from_range") );
        $emp_arr = array();
        $e = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $emp_arr[$e]['id'] = $alerts_row->id;
            $emp_arr[$e]['name'] = $alerts_row->name;
            $e++;
        }
        
        
        
        $indResult = DB::select( DB::raw("select id,name from exec_email_update order by id") );
        $freq_arr = array();
        $fr = 0;
        foreach ($indResult as $alerts_row) 
        { 
            $freq_arr[$fr]['id'] = $alerts_row->id;
            $freq_arr[$fr]['name'] = $alerts_row->name;
            $fr++;
        }
        
        //echo "<br>actions in controller end:".$action.":";
        //echo "<pre>revenue in cont: ";   print_r($revenue);   echo "</pre>"; 
        // this will be selected zip code from search page
        $selected_filters = "";
        //echo "<br>selected filter in controller : ".$request['selected_filters_hidden'];
        if($request['selected_filters_hidden'] != '')
            $selected_filters = $request['selected_filters_hidden'];
        //echo "<br>selected_filters: ".$selected_filters; 
        $data = array(
            'msg'  => "",
            'PageTitle' => '',
            'PageKeywords' => '',
            'PageDescription' => '',
            'action' => '',
            'title' => '',
            'management_type' => '',
            'countries' => $countries,
            'states' => $states,
            'zip_code' => $zip_code,
            'city' => $city,
            'company' => $company,
            'industries' => $industries,
            'revenue_arr' => $revenue,
            'emp_arr' => $emp_arr,
            'freq_arr' => $freq_arr,
            'alert_id' => $alert_id,
            'action' => $action,
            'speaking' => $speaking,
            'awards' => $awards,
            'publication' => $publication,
            'media_mentions' => $media_mentions,
            'board' => $board,
            'jobs' => $jobs,
            'fundings' => $fundings,
            'l_id' => $l_id,
            'alert_id' => $alert_id,
            'action' => $action_msg,
            'selected_filters' => $selected_filters,
        ); 
               
        
        return view('alerts')->with($data);
    }
    
    public function getuserlink(Request $request)
    {
        $personal_id = $request['personal_id'];
        //$personal_id = '98752';
        $sf = "";
        //$sf = "salesforcetestlink.com";
        //echo $sf;

        $execfile_root = "http://www.execfile.com";
        $where_personal_clause = " and pm.personal_id = ".$personal_id;

        $indResult_personal = DB::select( DB::raw("select pm.personal_id,first_name,last_name,
                pm.email as email,pm.phone,cm.company_name,mm.title
                from 
                ".Session::get('db_personal')." as pm,
                ".Session::get('db_movement')." as mm,
                ".Session::get('db_company')." as cm
                 where (mm.personal_id = pm.personal_id and 
                cm.company_id = mm.company_id)
                $where_personal_clause 
                 limit 1") );

        
        
        if(count($indResult_personal) > 0)
        {
            $first_name = $indResult_personal[0]->first_name;
            $last_name = $indResult_personal[0]->last_name;
            $company_name = $indResult_personal[0]->company_name;
            $title = $indResult_personal[0]->title;
            $email = $indResult_personal[0]->email;
            $phone = $indResult_personal[0]->phone;
            //echo "<br>first_name: ".$first_name;

            
            $sf = $execfile_root."/salesforce/oauth.php?fname=".urlencode($first_name)."&lname=".urlencode($last_name)."&company_name=".urlencode($company_name)."&title=".urlencode($title)."&email=".urlencode($email)."&phone=".urlencode($phone); 
        
            echo $sf;
        }
        
        
        
    }      
    
    
    
    public function forgotpassword(Request $request,$ucd='')
    {
        /*
        $from = 'admin@execfile.com';
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: ' . $from . "\r\n";

        mail('faraz.aia@nxvt.com', "test sub3 without return", "test msg", $headers);
        */
        
        //echo "<br>Base path:".base_path();

        // Path to the 'app' folder    
        //echo "<br>App path:".app_path(); 
        //echo "<br>Public path:".public_path(); 
        //$temp_link = '/forgotpassword/123';
        //echo "<a href=".$temp_link.">Temp</a>";
        
        $msg = "";
        $root_path = "http://www.execfile.com/execf/public/index.php/";
        $retry_link = 'http://www.execfile.com/execf/public/index.php/forgot-password';
        //echo "in forgot password";
        //echo "<br>Email:".$request['email_rq'];
        //echo "<br>reset_pw:".$request['reset_pw'];
        if($request['email_rq'] != '') // first screen, where user enter email address
        {
            //echo "<br>within if";
            //echo "<br>within if";
            $email = $request['email_rq'];
            $result_user = DB::select( DB::raw("SELECT * FROM exec_user where email = '".$email."'") );
            if(count($result_user) > 0)
            {
                
                
                $user_email = $result_user[0]->email;
                $user_name = $result_user[0]->first_name." ".$result_user[0]->last_name;
                
                
                $from = "admin@execfile.com";
                $to = $user_email;
                $subject = "Execfile.com :: Reset your password";
                $random_hash = '';
                $random_hash = rand(100000,999999);
                
                $reset_link = 'http://www.execfile.com/execf/public/index.php/forgot-password/'.$random_hash;
                
                //$random_hash = rand(100000000000,999999999999);
                
                //$fp_update_db = "INSERT into exec_user_forgot_password(user_email,unique_hash) values('$user_email','$random_hash')";
                //$user_updated = DB::select( DB::raw("INSERT into exec_user_forgot_password(user_email,unique_hash) values('$user_email','$random_hash')") );
                
                $sqlInsert = array(array('user_email'=>$user_email, 'unique_hash'=>"$random_hash"),);
                DB::table('exec_user_forgot_password')->insert($sqlInsert);


                //$reset_link = $root_path.'reset-password.php?upc='.$random_hash;
                //$message = '<a href="index.php"><img src="'.HTTP_SERVER.DIR_WS_HTTP_FOLDER.'images/logo.jpg"  alt="Logo" width="196" height="32" border="0" title="Logo" /></a>&nbsp;
                $message = '<table width="70%" cellspacing="0" cellpadding="3" >
                        <tr>
                            <td align="left"><b>Dear '.$user_name.',</b></td>
                        </tr>
                        <tr>
                            <td align="left">Below is the link to reset your password.</td>
                        </tr>

                        <tr>
                            <td align="left"><a href='.$reset_link.'>Reset Password</a></td>
                        </tr>';

                $message .=	'</table>';
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: ' . $from . "\r\n";

                mail($to, $subject, $message, $headers);
                
                $msg = "<p>Please check your inbox, you should receive password <br>reset email shortly.</p>";
                
            }
            else
            {
                
                $msg = "The email address you entered could not be found in our records,<br>please <b><a href=".$retry_link.">try again</a></b>";
            }    
            
            $data = array(
                'msg'  => $msg,
            ); 
            return view('forgotpassword')->with($data);
            
        }   
        elseif($ucd != '') // when user clicked on reset password link in email
        {
            
            $result_hash = DB::select( DB::raw("SELECT * FROM exec_user_forgot_password where unique_hash = '".$ucd."'") );
            if(count($result_hash) > 0)
            {
                
                $user_email = $result_hash[0]->user_email;
                
                $password_updated = $result_hash[0]->password_updated;
                
                if($password_updated == 0)
                {
                    $data = array(
                    'msg'  => "",
                    'user_email' => $user_email     
                    ); 
                    return view('resetpassword')->with($data);
                }
                else
                {
                    $msg = "This password reset link already expired.";
                
                    $data = array(
                    'msg'  => $msg,
                    ); 
                    return view('forgotpassword')->with($data);
                }    
            }
            else
            {
               // $retry_link = 'http://www.execfile.com/execf/public/index.php/forgot-password';
                $msg = "The email address you entered could not be found in our records,<br>please <b><a href=".$retry_link.">try again</a></b>";
                
                $data = array(
                'msg'  => $msg,
                ); 
                return view('forgotpassword')->with($data);
            }    
            
        }    
        elseif($request['reset_pw'] == 1)  // when user enters new password to reset
        {
            $email = $request['user_email'];
            $password = $request['password'];
            DB::table('exec_user')
            ->where('email', $email)
            ->update(['password' => $password]);
            
            
            DB::table('exec_user_forgot_password')
            ->where('user_email', $email)
            ->update(['password_updated' => 1]);
            
            
            return redirect('login');
        }    
        
        $data = array(
                'msg'  => "",
            ); 
            return view('forgotpassword')->with($data);
         
    }
    
}
