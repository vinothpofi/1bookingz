<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('dashboard_model');
    }
    
    
   	public function index()
   	{	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/dashboard/admin_dashboard');
		}
	}
	public function change_seller_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'InActive' : 'Active';
			$newdata = array('status' => $status);
			// if ($status == 'Rejected') {
			// 	$newdata['group'] = 'User';
			// } else if ($status == 'Approved') {
			// 	$newdata['group'] = 'Seller';
			// }
			$condition = array('id' => $user_id);
			$this->dashboard_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	public function admin_dashboard()
	{
    if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else { 
			/* get dashboard values start*/

			/* Get user count start*/
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			
			if($rep->row()->admin_rep_code==''){
			    //, 'email !=' => ''
				$UserWhereCondition = array('group'=>'User');
			}else{
			    //, 'email !=' => ''
				$rep_code = $rep->row()->admin_rep_code;
				$UserWhereCondition = array('group'=>'User','rep_code'=>$rep_code);
			}
						
			$userTableName = USERS;
			$userFieldName = 'id';
			
						 										
			$totalUserCounts = $this->dashboard_model->getCountDetails($userTableName,$userFieldName,$UserWhereCondition);

			/*newly added*/
            $totalUserCounts_s = $this->dashboard_model->get_all_details(USERS,array('group'=>'User'))->num_rows();
			$activeUserCounts = $this->dashboard_model->get_all_details(USERS,array('status'=>'Active','group'=>'User'))->num_rows();
			$InactiveUserCounts = $this->dashboard_model->get_all_details(USERS,array('status'=>'Inactive','group'=>'User'))->num_rows();

			$totalHostCounts = $this->dashboard_model->get_all_details(USERS,array('group'=>'Seller'))->num_rows();
			$activeHostCounts = $this->dashboard_model->get_all_details(USERS,array('status'=>'Active','group'=>'Seller'))->num_rows();
            $InactiveHostCounts = $this->dashboard_model->get_all_details(USERS,array('status'=>'Inactive','group'=>'Seller'))->num_rows();

            $this->data['totalUserCounts_s']=$totalUserCounts_s;
            $this->data['activeUserCounts']=$activeUserCounts;
            $this->data['InactiveUserCounts']=$InactiveUserCounts;

            $this->data['totalHostCounts']=$totalHostCounts;
            $this->data['activeHostCounts']=$activeHostCounts;
            $this->data['InactiveHostCounts']=$InactiveHostCounts;

            /*newly added*/

			
			/* last 24 hours user record start */			
						
			$getTodayUsersCount = $this->dashboard_model->getTodayUsersCount($userTableName,$userFieldName,$UserWhereCondition);
			
			
												
			/* last 30 days user record start */
					
			$thismonthUserCounts = $this->dashboard_model->getThisMonthCount($userTableName,$userFieldName,$UserWhereCondition);	
			
				

			/* last year user record start */
					
			$thisyearUserCounts = $this->dashboard_model->getLastYearCount($userTableName,$userFieldName,$UserWhereCondition);
					
						
			/* get recent users list start*/
			if($rep->row()->admin_rep_code=='')
			{
				$recentUserWhereCondition = array('status'=>'Active','group'=>'User', 'email !=' => '');
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$recentUserWhereCondition = array('status'=>'Active','group'=>'User','rep_code'=>$rep_code, 'email !=' => '');
			}
			$userOrderBy = 'desc';
			$userLimit = "3";
			$getRecentUsersList = $this->dashboard_model->getRecentDetails($userTableName,$userFieldName,$userOrderBy,$userLimit,$recentUserWhereCondition);
			

			/* get total seller count start */			
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if($rep->row()->admin_rep_code=='')
			{
				$sellerWhereCondition = array('group'=>'Seller', 'status'=>'Active','email !=' => '', 'host_status' => 0);
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$sellerWhereCondition = array('group'=>'Seller','status'=>'Active','rep_code'=>$rep_code, 'email !=' => '', 'host_status' => 0);
			}
			
			$getTotalSellerCount = $this->dashboard_model->getCountDetails($userTableName,$userFieldName,$sellerWhereCondition);
			
			
			/* last 24 hours user record start */	
			
			$getTodaySellerCount = $this->dashboard_model->getTodayUsersCount($userTableName,$userFieldName,$sellerWhereCondition);
 

 
			/* last 30 days user record start */
					
			$thismonthsellerCounts = $this->dashboard_model->getThisMonthCount($userTableName,$userFieldName,$sellerWhereCondition);	

			
			 
			/* last year user record start */
					
			$thisyearsellerCounts = $this->dashboard_model->getLastYearCount($userTableName,$userFieldName,$sellerWhereCondition);

			

			/* get recent sellers list start*/
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			$rep_type = $rep->row()->admin_rep_type;
			
			if($rep->row()->admin_rep_code=='')
			{				
				$recentsellerWhereCondition = array('status'=>'Active','host_status' => 0,'group'=>'Seller');
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$recentsellerWhereCondition = array('status'=>'Active','host_status' => 0,'group'=>'Seller','rep_code'=>$rep_code);
			}
			
			$userOrderBy = 'desc';
			$userLimit = "3";
			$getRecentSellerList = $this->dashboard_model->getRecentDetails($userTableName,$userFieldName,$userOrderBy,$userLimit,$recentsellerWhereCondition);
						
				
			/* get total product count start*/
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep_un_sellerid = $rep->row()->admin_rep_code;			
			$get_rep = $this->dashboard_model->get_seller($rep_un_sellerid);
						
			
			$condition = array();
			$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
			if($rep_code!=''){
				$productcondition = 'where u.status="Active" and u.rep_code="'.$rep_code.'" group by p.id order by p.created desc';
			}else{	
				$productcondition = 'where u.status="Active" or p.user_id=0 group by p.id order by p.created desc';
			}
			
			$prd_details = $this->dashboard_model->view_product_details($productcondition);
			$getTotalProductCount = $prd_details->num_rows();
				
			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			$rep_type = $rep->row()->admin_rep_type;
			
			if($rep->row()->admin_rep_code=='')
			{				
				$productWhereCondition = array();
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$productWhereCondition = array();
			}		
			$productTableName = PRODUCT;
			$productFieldName = '*';
					
			/* last 24 hours user record start */	
			if($rep->row()->admin_rep_code=='')
			{
				$getTodayProductCount = $this->dashboard_model->getTodayPropertyCount($productTableName,$productFieldName,$productWhereCondition);
				
			}
			else
			{
				$getTodayProductCount = $this->dashboard_model->getTodayPropertyrepCount($productTableName,$productFieldName,$productWhereCondition);
					
			}
					
			/* last 30 days user record start */
			if($rep->row()->admin_rep_code=='')
			{		
				$thismonthpropertyCounts = $this->dashboard_model->getThisMonthPropertyCount($productTableName,$productFieldName,$productWhereCondition);
				
			}
			else
			{
				$thismonthpropertyCounts = $this->dashboard_model->getThisMonthPropertyrepCount($productTableName,$productFieldName,$productWhereCondition);
			}
			/* last year user record start */
			if($rep->row()->admin_rep_code=='')
			{		
				$thisyearpropertyCounts = $this->dashboard_model->getLastYearProertyCount($productTableName,$productFieldName,$productWhereCondition);
				
				
			}
			else
			{
				$thisyearpropertyCounts = $this->dashboard_model->getLastYearProertyrepCount($productTableName,$productFieldName,$productWhereCondition);
			}
			/* get total experience count start*/
if ($this->data['experienceExistCount'] > 0) {
			$experiencecondition = array();
			$rep_code=ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');			
			if($rep_code!=''){
				$experiencecondition = 'where u.status="Active" or p.user_id=0 and u.rep_code="'.$rep_code.'" ';
			}else{	
				$experiencecondition = 'where u.status="Active" or p.user_id=0 ';
			}


			$exp_details = $this->dashboard_model->view_experience_count($experiencecondition);
			
			$getTotalexperienceCount= $exp_details->num_rows();



			$rep = $this->dashboard_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			$rep_type = $rep->row()->admin_rep_type;
			
			if($rep->row()->admin_rep_code=='')
			{				
				$experienceWhereCondition = array();
			}
			else
			{
				$rep_code = $rep->row()->admin_rep_code;
				$experienceWhereCondition = array('rep_code'=>$rep_code);
			}		

			$experienceTableName = EXPERIENCE;
			$experienceFieldName = 'experience_id';
					
			/* last 24 hours user record start */	
			if($rep->row()->admin_rep_code=='')
			{
				$getTodayexperienceCount = $this->dashboard_model->getTodayexperienceCount($experienceTableName,$experienceFieldName,$experienceWhereCondition); 
				
				
			}
			else
			{
				$getTodayexperienceCount = $this->dashboard_model->getTodayexperiencerepCount($experienceTableName,$experienceFieldName,$experienceWhereCondition); 
			}
			/* last 30 days user record start */
			if($rep->row()->admin_rep_code=='')
			{		
				$thismonthexperienceCounts = $this->dashboard_model->getThisMonthexperienceCount($experienceTableName,$experienceFieldName,$experienceWhereCondition);	
				
				
			}
			else
			{
				$thismonthexperienceCounts = $this->dashboard_model->getThisMonthexperiencerepCount($experienceTableName,$experienceFieldName,$experienceWhereCondition);
			}
			/* last year user record start */
			if($rep->row()->admin_rep_code=='')
			{		
				$thisyearexperienceCounts = $this->dashboard_model->getLastYearexperienceCount($experienceTableName,$experienceFieldName,$experienceWhereCondition);
				
			}
			else
			{
				$thisyearexperienceCounts = $this->dashboard_model->getLastYearexperiencerepCount($experienceTableName,$experienceFieldName,$experienceWhereCondition);
			}
			$getexperienceOrderDetails = $this->dashboard_model->getDashboardexperienceOrderDetails();
			}		
			/* get dashboard values end*/
						
			
			/* get recent orders details start*/		
			
			$getrentalOrderDetails = $this->dashboard_model->getDashboardOrderDetails();
			
			
			/* get users login type details */

			$totaluserscount = $this->dashboard_model->totaluserscount();
			$getnormaluserscount = $this->dashboard_model->getnormaluserscount();
			$getlinkedinuserscount = $this->dashboard_model->getlinkedinuserscount();
			$getfacebookuserscount = $this->dashboard_model->getfacebookuserscount();
			//echo $getfacebookuserscount;exit();
			$getgoogleuserscount = $this->dashboard_model->getgoogleuserscount();

						
			/*Assign dashboard values to view start */	
			
			$data = array('totalUserCounts'=>$totalUserCounts,'todayUserCounts'=>$getTodayUsersCount,'getRecentUsersList'=>$getRecentUsersList,'thismonthUserCounts'=>$thismonthUserCounts,'thisyearUserCounts'=>$thisyearUserCounts,'getTotalexperienceCount'=>$getTotalexperienceCount,'getTodayexperienceCount'=>$getTodayexperienceCount,'thismonthexperienceCounts'=>$thismonthexperienceCounts,'thisyearexperienceCounts'=>$thisyearexperienceCounts,'getTodayProductCount'=>$getTodayProductCount,'thismonthpropertyCounts'=>$thismonthpropertyCounts,'thisyearpropertyCounts'=>$thisyearpropertyCounts,'getTotalSellerCount'=>$getTotalSellerCount,'getTodaySellerCount'=>$getTodaySellerCount,'thismonthsellerCounts'=>$thismonthsellerCounts,'thisyearsellerCounts'=>$thisyearsellerCounts,'getTotalGiftCardCount'=>$getTotalGiftCardCount,'getTotalSubscriberCount'=>$getTotalSubscriberCount,'heading'=>'Dashboard','getrentalOrderDetails'=>$getrentalOrderDetails,'getexperienceOrderDetails'=>$getexperienceOrderDetails,'getRecentSellerList'=>$getRecentSellerList,'getTotalProductCount'=>$getTotalProductCount,'rep_type'=>$rep_type,'TodayPropertyCount'=>$getTodayPropertyCount,'ThisMonthPropertyCount'=>$getThisMonthPropertyCount,'getLastYearProertyCount'=>$getLastYearProertyCount,'getnormaluserscount'=>$getnormaluserscount,'getlinkedinuserscount'=>$getlinkedinuserscount,'getfacebookuserscount'=>$getfacebookuserscount,'getgoogleuserscount'=>$getgoogleuserscount,'totaluserscount'=>$totaluserscount); 
			
			$this->data = array_merge($data,$this->data); 
			$heading = array('heading'=>'Dashboard');
			$this->data = array_merge($this->data,$heading);
			
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');

			$this->load->view('admin/adminsettings/dashboard',$this->data);				
			/*Assign dashboard values to view end */
		}	
	}
}