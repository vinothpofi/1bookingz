<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Dispute extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('review_model','experience_model'));
		if ($this->checkPrivileges('Review',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the dispute list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/review/display_dispute_list');
		}
	}
	
	/**
	 * 
	 * This function loads the dispute list page
	 */
	public function display_dispute_list()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else {
			$this->data['heading'] = 'Rental Dispute List';
			$condition = array();
			$this->data['reviewList'] = $this->review_model->get_all_dispute_details();	
			$this->load->view('admin/dispute/display_dispute',$this->data);
		}
	}

	/**
	 *
	 * This function loads cancel booking list page
	 */
	public function cancel_booking_list()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else {
			$this->data['time_val'] = date('Y-m-d');
			$this->data['heading'] = 'Rental Cancel booking list';
			$condition = array();
			$this->data['disputecancelbooking'] = $this->review_model->get_all_dispute_cancel_booking();	
			$this->load->view('admin/dispute/display_cancel_booking',$this->data);
		}
	}
	
	/**
	 *
	 * This function loads cancel booking list
	 */
	public function cancel_booking_payment()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Rental Cancellation Payments';
			$condition = array('cancelled','Yes');
			$CustomerDetails = $this->product_model->get_all_cancelled_users();
			
			
			foreach($CustomerDetails->result() as $customer)
			{
                $booking_no = $customer->Bookingno;
				$cancel[] = $this->product_model->get_all_commission_tracking_user($booking_no);
				//$this->data['paypalData'][$HostEmail] = $customer->paypal_email;							
			}
			$this->data['trackingDetails'] = $cancel;
			// echo "<pre>";
			// print_r($this->data['trackingDetails']); exit;
			$this->load->view('admin/dispute/display_cancel_payment_lists',$this->data);
		}
	}
	
	/**
	 *
	 * This function loads experience payment list
	 */
	public function cancel_experience_booking_payment()
	{	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			
			$this->data['heading'] = 'Experience Cancellation Payments';
			
			$condition = array('cancelled','Yes');
			$CustomerDetails = $this->review_model->get_all_experienced_cancelled_users();		
			
			foreach($CustomerDetails->result() as $customer)
			{
				$customer_id = $customer->id;
				$cancel[] = $this->review_model->get_all_experience_commission_tracking($customer_id);
				$this->data['paypalData'][$HostEmail] = $customer->paypal_email;				
			}

			$this->data['trackingDetails'] = $cancel;
			$this->load->view('admin/dispute/display_experience_cancel_payment_lists',$this->data);
		}
	}

	/**
	 *
	 * This function start Paypal integration  
	 */
	public function paypal_Cancelpayment_property()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{		
			$this->load->library('paypal_class');
			$return_url = base_url().'admin/dispute/paypal_cancelAmount_success_property';
			$cancel_url = base_url().'admin/dispute/paypal_cancelAmount_cancel_property'; 
			$notify_url = base_url().'admin/dispute/paypal_cancelAmount_notify_property';	
			$item_name = $this->config->item('email_title').' Cancel Property Booking Payment';
			$totalAmount = $this->input->post('amount_to_pay');
			$guestEmail = $this->input->post('GuestEmail');			
			$BookingNumber = $this->input->post('booking_number');
			$guestPayPalEmail = $this->input->post('guestPayPalEmail');
            $loginUserId = $this->checkLogin('A');
			$quantity = 1;
			$paypal_settings=unserialize($this->config->item('payment_0'));
			$paypal_settings=unserialize($paypal_settings['settings']);

			if($paypal_settings['mode'] == 'sandbox')
			{
				$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
			}
			else
			{
				$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
			}

			$ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";
			$logo = base_url().'images/logo/'.$this->data['logo_img'];

			$this->paypal_class->add_field('currency_code', 'USD'); 
			$this->paypal_class->add_field('image_url',$logo);
			$this->paypal_class->add_field('business',trim($guestPayPalEmail)); /* Business Email -for pay to guest*/
			$this->paypal_class->add_field('return',$return_url); /*Return URL*/
			$this->paypal_class->add_field('cancel_return', $cancel_url); /*Cancel URL*/
			$this->paypal_class->add_field('notify_url', $notify_url); /*Notify url*/
			$this->paypal_class->add_field('custom', $guestEmail.'|'.$totalAmount.'|'.$BookingNumber); /*Custom Values*/
			$this->paypal_class->add_field('item_name', $item_name); /*Product Name*/
			$this->paypal_class->add_field('user_id', $loginUserId);
			$this->paypal_class->add_field('quantity', $quantity);  /*Quantity*/
			$this->paypal_class->add_field('amount', $totalAmount); /*Price*/
			$this->paypal_class->submit_paypal_post(); 
		}
	}
	
	
		public function paypal_cancelAmount_success_property(){
		
		$this->data['txn_id'] = $_REQUEST['txn_id'];
		$custom_values = explode('|',$_REQUEST['custom']);
        $this->data['guestEmail'] = $custom_values[0];
        $paypal_amount = $custom_values[1];
        $booking_number = $custom_values[2];

       $this->data['mc_gross'] = $_REQUEST['mc_gross']; 
       $this->data['currency_code'] = $_REQUEST['mc_currency'];
       $dataArr = array(
				'customer_email'	=>$this->data['guestEmail'],
				'transaction_id'	=>$this->data['txn_id'],
				'amount'			=>$paypal_amount,
				'status' 			=>1,
				'pay_status' 		=>'paid'
			);
		
			$this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
			$this->db->update(COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$booking_number));
			$this->setErrorMessage('success','Cancel Property Booking Payment is competed');
			redirect('admin/dispute/cancel_booking_payment');

		
	}
	
	
	
	 function paypal_cancelAmount_cancel_property(){
     	$this->setErrorMessage('error','Cancel Property Booking Payment is Failed');
		redirect('admin/dispute/cancel_booking_payment');

     }
	 
	 
	  public function paypal_cancelAmount_notify_property(){
		 
		$this->setErrorMessage('error','From Paypal ipn');
		redirect('admin/dispute/cancel_booking_payment');
		 
	 }
	
	/**
	 *
	 * function to start paypal integration
	 */
	public function paypal_payment_CancelAmount()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			$this->load->library('paypal_class');
			$return_url = base_url().'admin/dispute/paypal_cancelAmount_success';
			$cancel_url = base_url().'admin/dispute/paypal_cancelAmount_cancel';
			$notify_url = base_url().'admin/dispute/paypal_cancelAmount_notify';
			$item_name = $this->config->item('email_title').' Cancel Experience Booking Payment';
			$totalAmount = $this->input->post('amount_to_pay');
			$guestEmail = $this->input->post('GuestEmail');
			$BookingNumber = $this->input->post('booking_number');
			$guestPayPalEmail = $this->input->post('guestPayPalEmail');
            $loginUserId = $this->checkLogin('A');
			$quantity = 1;
			$paypal_settings=unserialize($this->config->item('payment_0'));
			$paypal_settings=unserialize($paypal_settings['settings']);

			if($paypal_settings['mode'] == 'sandbox')
			{
				$this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';  
			}
			else
			{
				$this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr'; 
			}

			$ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";
			$logo = base_url().'images/logo/'.$this->data['logo_img'];
			$this->paypal_class->add_field('currency_code', 'USD'); 
			$this->paypal_class->add_field('image_url',$logo);
			$this->paypal_class->add_field('business',trim($guestPayPalEmail));
			$this->paypal_class->add_field('return',$return_url); 
			$this->paypal_class->add_field('cancel_return', $cancel_url);
			$this->paypal_class->add_field('notify_url', $notify_url);
			$this->paypal_class->add_field('custom', $guestEmail.'|'.$totalAmount.'|'.$BookingNumber); 
			$this->paypal_class->add_field('item_name', $item_name);
			$this->paypal_class->add_field('user_id', $loginUserId);
			$this->paypal_class->add_field('quantity', $quantity);
			$this->paypal_class->add_field('amount', $totalAmount);
			$this->paypal_class->submit_paypal_post(); 
		}
	}
	
	public function paypal_cancelAmount_success(){
		
		$this->data['txn_id'] = $_REQUEST['txn_id'];
		$custom_values = explode('|',$_REQUEST['custom']);
        $this->data['guestEmail'] = $custom_values[0];
        $paypal_amount = $custom_values[1];
        $booking_number = $custom_values[2];

       $this->data['mc_gross'] = $_REQUEST['mc_gross']; 
       $this->data['currency_code'] = $_REQUEST['mc_currency'];
       $dataArr = array(
				'customer_email'	=>$this->data['guestEmail'],
				'transaction_id'	=>$this->data['txn_id'],
				'amount'			=>$paypal_amount,
				'status' 			=>2,
				'pay_status' 		=>'paid'
			);
		
			$this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
			$this->db->update(EXP_COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$booking_number));
			$this->setErrorMessage('success','Cancel Experience Booking Payment is competed');
			redirect('admin/dispute/cancel_experience_booking_payment');

		
	}
	
	 function paypal_cancelAmount_cancel(){

     	$this->setErrorMessage('error','Cancel Experience Booking Payment is Failed');
		redirect('admin/dispute/cancel_experience_booking_payment');

     }
	 
	 public function paypal_cancelAmount_notify(){
		 
		$this->setErrorMessage('error','From Paypal ipn');
		redirect('admin/dispute/cancel_experience_booking_payment');
		 
	 }
	
	/**
	 *
	 * This function loads admin payament form
	 */
	public function add_pay_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else {
			$this->data['heading'] = 'Add admin payment';
			
			$sid = $this->uri->segment(4,0);
			$guestid = $this->uri->segment(5,0);
			
			$getGuestEmail=$this->review_model->get_all_details(USERS,array('id'=>$guestid));
			$theEmail_is=$getGuestEmail->row()->email;			
			$hostEmailQry = $this->review_model->get_commission_track_id($sid);
			$product_id = $hostEmailQry->row()->prd_id;
			$hostEmail = $hostEmailQry->row()->host_email;
				
			$this->data['hostEmail'] = $hostEmail;			
			$this->data['bookid'] = $sid;
			
			$rental_booking_details= $this->review_model->get_unpaid_commission_tracking($hostEmail,$sid);			
			$payableAmount = 0;			
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
			
			if(count($rental_booking_details) != 0)
			{ 
				foreach($rental_booking_details as $rentals)
				{					
					//echo $rentals['user_currencycode'].'|'.$rentals['currency_cron_id'].'<br>';
					$currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
					//echo $currencyPerUnitSeller;
					if($rentals['currency_cron_id']=='' || $rentals['currency_cron_id']==0) { $currencyCronId='';} else { $currencyCronId=$rentals['currency_cron_id']; }
					if ($rentals['cancel_percentage']!='100')
					{	 
						//echo $rentals['user_currencycode'].'|'.$admin_currencyCode;		//For moderate and Flexible
						if($rentals['user_currencycode']!=$admin_currencyCode)
							{
								if(!empty($currencyPerUnitSeller))
								{
									$rentals['subTotal']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['subtotal'],$currencyCronId);
									//customised_currency_conversion($currencyPerUnitSeller,$rentals['subtotal']);
									$rentals['secdep']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['secDeposit'],$currencyCronId);
									//customised_currency_conversion($currencyPerUnitSeller,$rentals['secDeposit']);
									$cancel_amount_toHost = $rentals['subTotal']/100 * $rentals['cancel_percentage'];
									$cancel_amount=$rentals['subTotal']-$cancel_amount_toHost; //to guest
									$cancel_amountWithSecDeposit=$cancel_amount+$rentals['secdep']; //to guest
									$re_payable= $cancel_amountWithSecDeposit;
								}
								else
								{
								$re_payable=0;
								}
							}
							else
							{
								$cancel_amount_toHost = $rentals['subTotal']/100 * $rentals['cancel_percentage'];
								$cancel_amount=$rentals['subTotal']-$cancel_amount_toHost; //to guest
								$cancel_amountWithSecDeposit=$cancel_amount+$rentals['secDeposit'];
								$re_payable= $cancel_amountWithSecDeposit;
							}
					
					}
					else
					{ 
				
				//If Strict Means only Sec Deposit to Guest
							if($rentals['user_currencycode']!=$admin_currencyCode)
							{
								if(!empty($currencyPerUnitSeller))
								{
									 $strict_amount=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['secDeposit']);//customised_currency_conversion($currencyPerUnitSeller,$rentals['secDeposit']);
									$re_payable= $strict_amount; 	
								}
								else
								{
									$re_payable=0;
								}
							}
							else
							{
								$strict_amount = $rentals['secDeposit'];
								$re_payable = $strict_amount; 
								
								
							}
						
					}
						$payableAmount =  $re_payable; 
					}
				}			
			
			$this->data['payableAmount'] = $payableAmount;
			$this->data['GuestEmail'] = $theEmail_is;
			$this->load->view('admin/dispute/add_admin_payment',$this->data);
		}
	}


	public function add_experience_pay_form()
	{		
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Add admin payment';			
			$sid = $this->uri->segment(4,0);			
			$hostEmailQry = $this->review_model->get_exp_commission_track_id($sid);
			$product_id = $hostEmailQry->row()->prd_id;
			$hostEmail = $hostEmailQry->row()->host_email;

			$this->data['hostEmail'] = $hostEmail;
			$this->data['guestEmail'] = $hostEmailQry->row()->email;
			$this->data['bookid'] = $sid;

			$rental_booking_details= $this->review_model->get_unpaid_exp_commission_tracking($hostEmail,$sid);			
			$payableAmount = 0;			
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
			
			if(count($rental_booking_details) != 0){ 
				foreach($rental_booking_details as $rentals)
				{					
					$currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
					if($rentals['currency_cron_id']==0 || $rentals['currency_cron_id']==''){ $currencyCronId=''; } else { $currencyCronId=$rentals['currency_cron_id'];}
					//echo $rentals['user_currencycode'].'!='.$admin_currencyCode.'<br>';
					if($rentals['user_currencycode']!=$admin_currencyCode){
						if(!empty($currencyPerUnitSeller))
						{
							//$rentals['cancel_amt']=customised_currency_conversion($currencyPerUnitSeller,$rentals['paid_cancel_amount']);
							$rentals['cancel_amt']=currency_conversion($rentals['user_currencycode'],$admin_currencyCode,$rentals['paid_cancel_amount'],$currencyCronId);
							
							$cancel_amount_toGuest=$rentals['cancel_amt'];
							$re_payable= $cancel_amount_toGuest;
						}
						else
						{
						$re_payable=0;
						}
					}else{
						$cancel_amount_toGuest = $rentals['paid_cancel_amount'];				
						$re_payable=$cancel_amount_toGuest;
					}										
					$payableAmount =  $re_payable; 
					}
				}			
			
			$this->data['payableAmount'] = $payableAmount;
			$this->load->view('admin/dispute/add_experience_admin_payment',$this->data);
		}
	}
	
	
	
	public function add_admin_payment_manual(){
		
		
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
		
		$rental_booking_details= $this->review_model->get_unpaid_commission_tracking($this->input->post('hostEmail'),$this->input->post('bookid'));
		
			$payableAmount = 0;
			
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
			
			//print_r($rental_booking_details);
			
			if(count($rental_booking_details) != 0){ 
				foreach($rental_booking_details as $rentals){
					$currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
					
					
					if($rentals['currencycode']!=$admin_currencyCode){
						if(!empty($currencyPerUnitSeller))
						{
							$rentals['subtot']=customised_currency_conversion($currencyPerUnitSeller,$rentals['subtotal']);
							
							$cancel_amount_toGuest = $rentals['subtot']/100 * $rentals['cancel_percentage'];
							$cancel_amount = $rentals['subtot']-$cancel_amount_toGuest;
							$re_payable=$cancel_amount;
						}
						else
						{
						$re_payable=0;
						}
					}else{
						$cancel_amount_toGuest = $rentals['subtotal']/100 * $rentals['cancel_percentage'];
						$cancel_amount = $rentals['subtotal']-$cancel_amount_toGuest;
						$re_payable=$cancel_amount;
			
					}
										
					$payableAmount = $re_payable;
					$payableAmountCommi =  $rentals['subtotal']/100 * $rentals['cancel_percentage'];
					
				}
			}

		
			$dataArr = array(
				'customer_email'	=>	$this->input->post('balance_due'),
				'transaction_id'	=>	$this->input->post('transaction_id'),
				'amount'		 	=>$payableAmount, //in usd
				'pay_status'		=>"paid" 
			);
	
			$this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
			//$this->db->update(COMMISSION_TRACKING, array('paid_canel_status'=>'1','paid_cancel_amount'=>$payableAmountCommi), array('booking_no'=>$this->input->post('bookid')));
			$this->db->update(COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$this->input->post('bookid')));

			redirect('admin/dispute/cancel_booking_payment');
		}
	}

	/**
	 *
	 * function to make admin manual payment
	 */
	public function add_exp_admin_payment_manual(){
		
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			$rental_booking_details= $this->review_model->get_unpaid_exp_commission_tracking($this->input->post('hostEmail'),$this->input->post('bookid'));	
			$payableAmount = 0;			
			$admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
			
			if(count($rental_booking_details) != 0)
			{ 
				foreach($rental_booking_details as $rentals)
				{
					$currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];

					if($rentals['currencycode']!=$admin_currencyCode){
						if(!empty($currencyPerUnitSeller))
						{
							$rentals['cancel_amount']=currency_conversion($rentals['currencycode'],$admin_currencyCode,$rentals['paid_cancel_amount'],$rentals['currency_cron_id']);//customised_currency_conversion($currencyPerUnitSeller,$rentals['paid_cancel_amount']);
							$cancel_amount_toGuest = $rentals['cancel_amount'];
							$re_payable=$cancel_amount_toGuest;
						}
						else
						{
						$re_payable=0;
						}
					}else{
						$cancel_amount_toGuest = $rentals['paid_cancel_amount'];
						$re_payable=$cancel_amount_toGuest;
					}										
					$payableAmount = $re_payable;
				}
			}
		
			$dataArr = array(
				'customer_email'	=>	$this->input->post('balance_due'),
				'transaction_id'	=>	$this->input->post('transaction_id'),
				'amount'			=> $payableAmount,
				'status'			=> 2,
				'pay_status' 		=> 'paid'
			);
		
			$this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
			$this->db->update(EXP_COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$this->input->post('bookid')));
			redirect('admin/dispute/cancel_experience_booking_payment');
		}
	}

	/**
	 * 
	 * This function loads the testimonials dashboard
	 */
	public function display_testimonials_dashboard(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Testimonials Dashboard';
			$condition = array();
			$grouptestimonials=array('c.renter_id');
			$grouporder=array('u.testimonials_count'=>'DESC');
			
			$this->data['testimonialsList'] = $this->review_model->get_testimonialsAll_details($grouptestimonials,$grouporder);
			$grouptestimonials=array('c.rental_id');
			$grouporder=array('p.testimonials_count'=>'DESC');
			$this->data['TopRentalList'] = $this->review_model->get_testimonialsAll_details($grouptestimonials,$grouporder);
			
	
			
			
			$this->load->view('admin/testimonials/display_testimonials_dashboard',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new testimonials form
	 */
	public function add_testimonials_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Contact';
			$this->load->view('admin/testimonials/add_testimonials',$this->data);
		}
	}
	/**
	 * 
	 * This function insert and edit a user
	 */
	public function insertEditTestimonials(){
	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$testimonials_id = $this->input->post('testimonials_id');
			$testimonials_name = $this->input->post('title');
			$seourl = url_title($testimonials_name, '-', TRUE);
			if ($testimonials_id == ''){
				$condition = array('title' => $testimonials_name);
				$duplicate_name = $this->review_model->get_all_details(TESTIMONIALS,$condition);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','Testimonial name already exists');
					redirect('admin/testimonials/add_testimonials_form');
				}
			}
			$excludeArr = array("testimonials_id");
			
			
			$testimonials_data=array();
			
			$inputArr = array();
			$datestring = "%Y-%m-%d %H:%M:%S";
			$time = time();
			if ($testimonials_id == ''){
				$testimonials_data = array(
					'dateAdded'	=>	mdate($datestring,$time),
				);
			}
			$dataArr = array_merge($inputArr,$testimonials_data);
			$condition = array('id' => $testimonials_id);
			if ($testimonials_id == ''){
				$this->review_model->commonInsertUpdate(TESTIMONIALS,'insert',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Testimonial added successfully');
			}else {
				
				$this->review_model->commonInsertUpdate(TESTIMONIALS,'update',$excludeArr,$dataArr,$condition);
				$this->setErrorMessage('success','Testimonial updated successfully');
			}
			redirect('admin/testimonials/display_testimonials_list');
		}
	}
	
	/**
	 * 
	 * This function loads the edit user form
	 */
	public function edit_testimonials_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Contact';
			$testimonials_id = $this->uri->segment(4,0);
			$condition = array('id' => $testimonials_id);
			$this->data['testimonials_details'] = $this->review_model->get_all_details(TESTIMONIALS,$condition);
			if ($this->data['testimonials_details']->num_rows() == 1){
				$this->load->view('admin/testimonials/edit_testimonials',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function change the user status
	 
	 change_testimonials_status_global
	 */
	public function change_review_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			//echo $status;die;
			if($status=='Active'){
				$GetReviewDetails=$this->review_model->get_all_details(REVIEW,$condition);
				
				if($GetReviewDetails->row()->user_id > 0 && $GetReviewDetails->row()->user_id != ''){
					$GetUserDetails=$this->review_model->get_all_details(USERS,array('id' => $GetReviewDetails->row()->user_id));
					$GetRentalDetails=$this->review_model->get_all_details(PRODUCT,array('id' => $GetReviewDetails->row()->product_id));
					if($GetUserDetails->row()->email != ''){
						$newsid='15';
						$template_values=$this->review_model->get_newsletter_template_details($newsid);
						
						$subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
						$adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'title'=>$GetReviewDetails->row()->title,'review'=>$GetReviewDetails->row()->review,'rateVal'=>$GetReviewDetails->row()->rateVal,'email_id'=>$GetReviewDetails->row()->email,'nickname'=>$GetReviewDetails->row()->nickname,'full_name'=>$GetReviewDetails->row()->full_name,'date_arrival'=>$GetReviewDetails->row()->date_arrival,'location'=>$GetReviewDetails->row()->location,'user_type'=>$GetReviewDetails->row()->user_type,'rental_id'=>$GetReviewDetails->row()->product_id,'rental_name'=>$GetRentalDetails->row()->product_name,'user_id'=>$GetReviewDetails->row()->user_id,'reviewer_id'=>$GetReviewDetails->row()->reviewer_id,'owner_name'=>ucfirst($GetUserDetails->row()->first_name));
						extract($adminnewstemplateArr);
						//$ddd =htmlentities($template_values['news_descrip'],null,'UTF-8');
						$header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";
						
						$message .= '<!DOCTYPE HTML>
							<html>
							<head>
							<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
							<meta name="viewport" content="width=device-width"/><body>';
						include('./newsletter/registeration'.$newsid.'.php');	
						
						$message .= '</body>
							</html>';
						
						if($template_values['sender_name']=='' && $template_values['sender_email']==''){
							$sender_email=$this->data['siteContactMail'];
							$sender_name=$this->data['siteTitle'];
						}else{
							$sender_name=$template_values['sender_name'];
							$sender_email=$template_values['sender_email'];
						}
						//add inbox from mail 
						$this->review_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$GetUserDetails->row()->email,'mailsubject'=>$subject,'description'=>stripslashes($message)));
				
						$email_values = array('mail_type'=>'html',
											'from_mail_id'=>$sender_email,
											'mail_name'=>$sender_name,
											'to_mail_id'=>$GetUserDetails->row()->email,
											'subject_message'=>$template_values['news_subject'],
											'body_messages'=>$message
											);
						$email_send_to_common = $this->review_model->common_email_send($email_values);
					}
				}
			}
			$this->review_model->update_details(REVIEW,$newdata,$condition);
			$this->setErrorMessage('success','Review Status Changed Successfully');
			redirect('admin/review/display_review_list');
		}
	}
	
	/**
	 * 
	 * This function loads the dispute view page
	 */
	public function view_dispute()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'View Rental Dispute';
			$booking_no = $this->uri->segment(4,0);
			$this->data['review_details'] = $this->review_model->get_dispute_details($booking_no);
			if ($this->data['review_details']->num_rows() > 0)
			{
				$this->load->view('admin/dispute/view_dispute',$this->data);
			}
			else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function loads cancel booking list page
	 */
	public function view_cancel_booking()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'View Rental Cancel';
			$booking_no = $this->uri->segment(4,0);
			$this->data['review_details'] = $this->review_model->get_dispute_details($booking_no);
			if ($this->data['review_details']->num_rows() > 0){
				$this->load->view('admin/dispute/view_cancel_booking',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 *
	 * This function Accept cancel booking dispute
	 */
	public function Cancel_Book($disputeId,$booking_no,$cancel_booking_id)
	{	
			$condition = array('id' => $disputeId,'cancel_status' => $cancel_booking_id);
			$data  = array('status' =>'Accept');
			$disputeData  = $this->review_model->get_all_details(DISPUTE,$condition);
			
			$this->review_model->update_details(DISPUTE,$data,$condition);
			
			$getBookedDate =  $this->review_model->ExecuteQuery("select DATE(checkin) as checkinDate ,DATE(checkout) as checkoutDate from ".RENTALENQUIRY." where Bookingno='".$booking_no."'")->row();

			//Update Rental Enquiry for cancel accept
			$UpdateArr=array('cancelled'=>'Yes');
			$Condition=array('Bookingno'=>$booking_no);
			$this->product_model->update_details(RENTALENQUIRY,$UpdateArr,$Condition);
		
			$schedule_q = $this->review_model->get_all_details(SCHEDULE,array('id'=>$disputeData->row()->prd_id));
			$sched = $schedule_q->row()->data;
		
			$data = json_decode($sched, true);
			foreach ($data as $key => $entry) 
			{
		
		    if ($key>= $getBookedDate->checkinDate && $key<=$getBookedDate->checkoutDate)  {
		      //echo  $data[$key]['status'] = "available";
		       if($entry['status'] != 'available')
               {
                 unset($data[$key]);
               }
             //  unset($data[$key]);
		    $up_Q =  "delete from bookings WHERE the_date='".$key."' and PropId=".$disputeData->row()->prd_id;
			$this->review_model->ExecuteQuery($up_Q);
			
		    }
		}
		
		$nw_schedule = json_encode($data);
		$up_Q =  "UPDATE schedule SET data='".$nw_schedule."' WHERE id=".$disputeData->row()->prd_id;
		$this->review_model->ExecuteQuery($up_Q);
		
		/* Start - Update RentalEnquiry and Commission Tracking*/
		$UpdateArr=array('cancelled'=>'Yes');
		$Condition=array('prd_id'=>$disputeData->row()->prd_id,
						'user_id'=>$disputeData->row()->user_id,
						'Bookingno'=>$disputeData->row()->booking_no);

		$this->review_model->update_details(RENTALENQUIRY,$UpdateArr,$Condition);	
		$getEnquiryDet=$this->review_model->get_all_details(RENTALENQUIRY,array('Bookingno'=>$disputeData->row()->booking_no));
		
		$TheSubTot=$getEnquiryDet->row()->subTotal;
		$SecDeposit=$getEnquiryDet->row()->secDeposit;
		$CancelPercentage=$getEnquiryDet->row()->cancel_percentage;
		$CancelPercentAmt=$TheSubTot/100*$CancelPercentage;
		$cancel_amount_toGuest=$TheSubTot-$CancelPercentAmt;
		
		if($getEnquiryDet->row()->cancel_percentage!="100"){ //For Moderate,Flexible
			$CancelAmountWithSecDeposit=$cancel_amount_toGuest+$SecDeposit;
		}else{  //For Strict
			$CancelAmountWithSecDeposit=$SecDeposit;
		}
		$UpdateCommissionArr=array('paid_cancel_amount'=>$CancelAmountWithSecDeposit);
		/*$TheSubTot=$getEnquiryDet->row()->subTotal;
		$CancelPercentage=$getEnquiryDet->row()->cancel_percentage;
		$CancelAmount=$TheSubTot/100*$CancelPercentage;
		$UpdateCommissionArr=array('paid_cancel_amount'=>$CancelAmount);*/
		
		
		$ConditionCommission=array('booking_no'=>$disputeData->row()->booking_no);
		$this->review_model->update_details(COMMISSION_TRACKING,$UpdateCommissionArr,$ConditionCommission);
		//$this->review_model->update_details(COMMISSION_TRACKING,$UpdateCommissionArr,$ConditionCommission);
		/* End - Update RentalEnquiry and Commission Tracking*/
		
									               
		/*Mail To Guest Start*/

		$condition = array (
		'id' =>$disputeData->row()->disputer_id
		);
		$hostDetails = $this->review_model->get_all_details( USERS, $condition );
		
		$uid = $hostDetails->row ()->id;
		$hostname = $hostDetails->row()->user_name;
		$host_email = $hostDetails->row()->email;

		/*GetCustomerDetails*/
		$condition = array (
		'id' => $disputeData->row()->user_id
		);

		$custDetails = $this->review_model->get_all_details( USERS, $condition );
		$cust_name = $custDetails->row()->user_name;
		$cust_email = $custDetails->row()->email;
	 
			$newsid='57'; 
			$template_values=$this->review_model->get_newsletter_template_details($newsid);
			if($template_values['sender_name']=='' && $template_values['sender_email']=='')
			{
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}
			else
			{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
                         
             $email_values = array('mail_type'=>'html',
			       'from_mail_id'=>$sender_email,
					'to_mail_id'=> $cust_email,
					'subject_message'=>$template_values ['news_subject'],
					
			);  

			$reg = array ('name' => 'Accepted','host_name'=>$hostname,'cus_name'=>$cust_name,'logo' => $this->data['logo']);

			 $message = $this->load->view('newsletter/ToGuestAcceptRejection'.$newsid.'.php',$reg,TRUE);
                        $this->load->library('email'); 
                        $this->email->set_mailtype($email_values['mail_type']);
                        $this->email->from($email_values['from_mail_id'], $sender_name);
                        $this->email->to($email_values['to_mail_id']);
                        $this->email->subject($email_values['subject_message']);
                        $this->email->message($message); 
                       try{
                        $this->email->send();
							
							if($this->lang->line('mail_send_success') != '') 
							{ 
								$message = stripslashes($this->lang->line('mail_send_success')); 
							} 
							else 
							{
								$message = "mail send success";
							}
							$this->setErrorMessage ( 'success',$message );
							
                        }catch(Exception $e){
                        echo $e->getMessage();

			}
			/*Mail To Guest End*/
		
			$this->setErrorMessage('success','Cancel booking accepted successfully');
			redirect('admin/dispute/cancel_booking_list');		

	}

	/**
	 *
	 * This function reject cancel booking dispute
	 */
	function rejectBooking($disputeId,$booking_no,$cancel_booking_id)
	{
			
			$condition = array('id' => $disputeId,'cancel_status' => $cancel_booking_id);
			$data  = array('status' =>'Reject');
			$ok = $this->review_model->update_details(DISPUTE,$data,$condition);
		
			/* Mail to Guest Start*/	
            $newsid='58';
			$template_values=$this->review_model->get_newsletter_template_details($newsid);

			if($template_values['sender_name']=='' && $template_values['sender_email']==''){
				$sender_email=$this->data['siteContactMail'];
				$sender_name=$this->data['siteTitle'];
			}
			else{
				$sender_name=$template_values['sender_name'];
				$sender_email=$template_values['sender_email'];
			} 
 		
		$getdisputeDetails = $this->review_model->get_all_details(DISPUTE,$condition);
		
		/*GetHostDetails*/
		$condition = array (
		'id' => $getdisputeDetails->row()->disputer_id
		);
		$hostDetails = $this->review_model->get_all_details( USERS, $condition );
		
		$uid = $hostDetails->row ()->id;
		$hostname = $hostDetails->row()->user_name;
		$host_email = $hostDetails->row()->email;
		
		
		/*GetCustomerDetails*/
		$condition = array (
		'id' => $getdisputeDetails->row()->user_id
		);
		
		$custDetails = $this->review_model->get_all_details( USERS, $condition );
		$cust_name = $custDetails->row()->user_name;
		$email = $custDetails->row()->email;
		
		/*GetProductDetails*/
		$condition = array (
		'id' => $getdisputeDetails->row()->prd_id
		);
		$prdDetails = $this->review_model->get_all_details( PRODUCT, $condition );
		$prd_title = $prdDetails->row()->product_title;
		
            $email_values = array(
					'from_mail_id'=>$sender_email,
					'to_mail_id'=> $email,
					'subject_message'=>$template_values ['news_subject'],
					'body_messages'=>$message
			);  
			
			$reg= array('host_name' => $hostname,'cust_name'=>$cust_name,'prd_title'=>$prd_title,'logo' => $this->data['logo']);	
            $message = $this->load->view('newsletter/ToGuestRejectCancelBooking'.$newsid.'.php',$reg,TRUE);
			
            /*send mail*/
            $this->load->library('email',$config);
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message);  
						
				   try{
					$this->email->send();
					$returnStr ['msg'] = 'Successfully registered';
						$returnStr ['success'] = '1';
					}catch(Exception $e){
					echo $e->getMessage();
					}                 
                        
            /* Mail to Guest End*/
		
			echo 'success';
			$this->setErrorMessage('success','Cancel booking rejected successfully');
			redirect('admin/dispute/cancel_booking_list');				
	}

	public function accept_dispute(){
		$disputeId = $this->uri->segment(4);
		$booking_no = $this->uri->segment(5);

		$condition = array('id' => $disputeId);

		$disputeData  = $this->review_model->get_all_details(DISPUTE,$condition);
		//print_r($disputeData->row());
		$data  = array('status' =>'Accept');
		
		$this->review_model->update_details(DISPUTE,$data,$condition);


		$getBookedDate =  $this->review_model->ExecuteQuery("select DATE(checkin) as checkinDate ,DATE(checkout) as checkoutDate from ".RENTALENQUIRY." where Bookingno='".$booking_no."'")->row();
		
		$schedule_q = $this->review_model->get_all_details(SCHEDULE,array('id'=>$disputeData->row()->prd_id));
		
		
		$sched = $schedule_q->row()->data;
		//print_r($schedule_q->result());
		//make 
		$data = json_decode($sched, true);
		
		foreach ($data as $key => $entry) {
			//echo $key;
		    if ($key>= $getBookedDate->checkinDate && $key<=$getBookedDate->checkoutDate)  {
		      echo  $data[$key]['status'] = "available";
		       unset($data[$key]);

		      $up_Q =  "delete from bookings WHERE the_date='".$key."' and PropId=".$disputeData->row()->prd_id;
			$this->review_model->ExecuteQuery($up_Q);
			//echo $this->db->last_query();
		    }
		}
		//echo $this->db->last_query();
		$nw_schedule = json_encode($data);

		$up_Q =  "UPDATE schedule SET data='".$nw_schedule."' WHERE id=".$disputeData->row()->prd_id;
		$this->review_model->ExecuteQuery($up_Q);
//exit;
		$this->setErrorMessage('success','Dispute accepted successfully');
		redirect('admin/dispute/display_dispute_list');
	}
	/* malar-10/07/2017 - dispute accept ends */

	/* malar-10/07/2017 - dispute reject starts   */
	function reject_dispute(){
		$disputeId = $this->uri->segment(4);

		$condition = array('id' => $disputeId);

		$data  = array('status' =>'Reject');
		
		$this->review_model->update_details(DISPUTE,$data,$condition);


		$this->setErrorMessage('success','Dispute rejected successfully');
		redirect('admin/dispute/display_dispute_list');

	}
	/* malar-10/07/2017 - dispute reject ends   */

	/**
	 * 
	 * This function delete the user record from db
	 */
	public function delete_review(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$id = $this->uri->segment(4,0);
			$condition = array('id' => $id);
			$this->review_model->commonDelete(REVIEW,$condition);
			$this->setErrorMessage('success','Review deleted successfully');
			redirect('admin/review/display_review_list');
		}
	}
	
	/**
	 * 
	 * This function change the user status, delete the user record
	 */
	public function change_review_status_global(){
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->review_model->activeInactiveCommon(REVIEW,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Review records deleted successfully');
			}else {
				$this->setErrorMessage('success','Review records status changed successfully');
			}
			redirect('admin/review/display_review_list');
		}
	}
}

/* End of file testimonials.php */
/* Contact: ./application/controllers/admin/testimonials.php */