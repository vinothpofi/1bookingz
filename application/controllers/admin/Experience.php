<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Experience management
 * Experience mentioned as 'Experience'
 * @author Teamtweaks
 *
 */
class Experience extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation', 'image_lib', 'resizeimage', 'email'));
		$this->load->model('experience_model');
		if ($this->checkPrivileges('Experience', $this->privStatus) == FALSE) {
			redirect('admin');
		}
		$id = $this->uri->segment(4, 0);
		$this->data['basics'] = 0;
		$this->data['language'] = 0;
		$this->data['organization'] = 0;
		$this->data['exp_title'] = 0;
		$this->data['timing'] = 0;
		$this->data['tagline'] = 0;
		$this->data['photos'] = 0;
		$this->data['what_we_do'] = 0;
		$this->data['where_will_be'] = 0;
		$this->data['where_will_meet'] = 0;
		$this->data['what_will_provide'] = 0;
		$this->data['notes'] = 0;
		$this->data['about_you'] = 0;
		$this->data['guest_req'] = 0;
		$this->data['group_size'] = 0;
		$this->data['price'] = 0;
		$this->data['cancel_policy'] = 0;
		$this->data['seo'] = 0;
		if ($id != '') {
			$condition = array('experience_id' => $id);
			$all_details = $this->experience_model->get_all_details(EXPERIENCE, $condition);
			$data = $all_details->row();
			if (!empty($data)) {
				if ($data->exp_type != '' && ($data->total_hours != '' || $data->date_count != '') && $data->type_id != '') {
					$this->data['basics'] = 1;
				}
				if ($data->language_list != '') {
					$this->data['language'] = 1;
				}
				if ($data->organization != '' && $data->organization_des != '') {
					$this->data['organization'] = 1;
				}
				if ($data->experience_title != '') {
					$this->data['organization'] = 1;
					$this->data['exp_title'] = 1;
				}
				$dat_date = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_DATES, ' where experience_id=' . $id);
				$shedule_timing = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_TIMING, ' where experience_id=' . $id);
				if ($dat_date->num_rows() > 0 && $shedule_timing->num_rows() > 0) {
					$this->data['timing'] = 1;
				}
				if ($data->exp_tagline != '') {
					$this->data['tagline'] = 1;
				}
				$dat_img = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_PHOTOS, ' where product_id=' . $id . ' and product_image !=""');
				if ($dat_img->num_rows() > 0) {
					$this->data['photos'] = 1;
				}
				if ($data->what_we_do != '') {
					$this->data['photos'] = 1;
					$this->data['what_we_do'] = 1;
				}
				if ($data->location_description != '') {
					$this->data['where_will_be'] = 1;
				}
				if ($data->location != '') {
					$this->data['where_will_meet'] = 1;
				}
				$loc_data = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_ADDR, ' where experience_id=' . $id);
				if ($loc_data->num_rows() > 0) {
					$this->data['where_will_meet'] = 1;
				}
				if ($data->kit_content != '') {
					$this->data['what_will_provide'] = 1;
				}
				if ($data->note_to_guest != '') {
					$this->data['notes'] = 1;
				}
				if ($data->about_host != '') {
					$this->data['about_you'] = 1;
				}
				if ($data->about_host != '') {
					$this->data['about_you'] = 1;
				}
				if ($data->guest_requirement != '') {
					$this->data['guest_req'] = 1;
				}
				if ($data->group_size != '') {
					$this->data['group_size'] = 1;
				}
				if ($data->price > 0) {
					$this->data['price'] = 1;
				}
				if ($data->cancel_policy != '') {
					$this->data['cancel_policy'] = 1;
				}
				if ($data->meta_title != '') {
					$this->data['seo'] = 1;
				}
			}
		}
	}

	/**
	 *
	 * This function loads experience type list page
	 */

	public function experienceTypeList()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Experience Type List';
			$this->data['experienceList'] = $this->experience_model->view_experienceType_details_manage();
			$this->load->view('admin/experience/experienceTypeList', $this->data);
		}
	}

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
            
            $getGuestEmail=$this->product_model->get_all_details(USERS,array('id'=>$guestid));
            $theEmail_is=$getGuestEmail->row()->email;      
            //echo $theEmail_is; exit;          
            $hostEmailQry = $this->product_model->get_commission_track_id($sid); 
            $product_id = $hostEmailQry->row()->vehicle_id;         
            $hostEmail = $hostEmailQry->row()->host_email;

            $this->data['hostEmail'] = $hostEmail;          
            $this->data['bookid'] = $sid;
            $this->data['vehicle_type'] = $hostEmailQry->row()->vehicle_type; 

            $rental_booking_details= $this->product_model->get_unpaid_reviewcommission_tracking_details($hostEmail,$sid);       
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
                    if($rentals['dispute_by']=='Host')
                    {
                        if($rentals['user_currencycode']!=$admin_currencyCode)
                        {
                            $re_payable=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['paid_cancel_amount'],$currencyCronId);
                        }
                        else
                        {
                            $re_payable=$rentals['paid_cancel_amount'];
                        }
                    }
                    else
                    {
                        //echo $rentals['cancel_percentage']; exit;
                        if ($rentals['cancel_percentage']!='100')
                        {    
                            //echo $rentals['user_currencycode'].'|'.$admin_currencyCode;       //For moderate and Flexible
                            if($rentals['user_currencycode']!=$admin_currencyCode)
                                {
                                    if(!empty($currencyPerUnitSeller))
                                    {
                                        $rentals['subtot']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['subtotal'],$currencyCronId);
                                        //customised_currency_conversion($currencyPerUnitSeller,$rentals['subtotal']);
                                        $rentals['secdep']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['secDeposit'],$currencyCronId);
                                        //customised_currency_conversion($currencyPerUnitSeller,$rentals['secDeposit']);
                                        $cancel_amount_toHost = $rentals['subtot']/100 * $rentals['cancel_percentage'];
                                        $cancel_amount=$rentals['subtot']-$cancel_amount_toHost; //to guest
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
                    }
                        $payableAmount =  $re_payable; 
                    }
                }           
            //payableAmount
            $this->data['payableAmount'] = $payableAmount;
            $this->data['GuestEmail'] = $theEmail_is;
            $this->load->view('admin/experience/add_admin_payment',$this->data);
        }
    }
    public function add_admin_payment_manual(){
        /*Array ( [hostEmail] => testhost@mailinator.com [bookid] => VE1500024 [transaction_id] => 123456 [amount] => 410.00 [balance_due] => testguest@mailinator.com [vehicle_type] => 4 )  */
        
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
        
        $rental_booking_details= $this->experience_model->get_unpaid_reviewcommission_tracking($this->input->post('hostEmail'),$this->input->post('bookid'));
        /*print_r($rental_booking_details); exit;
        Array ( [0] => Array ( [id] => 51 [host_email] => testhost@mailinator.com [rental_type] => 4 [booking_no] => VE1500024 [total_amount] => 410.00 [subtotal] => 200 [guest_fee] => 10.00 [host_fee] => 0.00 [cancel_percentage] => 10 [paid_cancel_amount] => 410 [paid_canel_status] => 0 [booking_walletUse] => 0.00 [listing_walletUse] => 0.00 [payable_amount] => 400.00 [commission_paid_id] => 0 [paid_status] => no [dateAdded] => 2018-08-13 12:10:35 [dispute_by] => Host [disputer_id] => 71 [vehicle_id] => 14 [currencycode] => USD [currencyPerUnitSeller] => 1.00 [secDeposit] => 100.00 [user_currencycode] => USD [currency_cron_id] => 113 [subTotal] => 200 ) ) */
        //$vehicle_type = $this->input->post('vehicle_type'); 
        $payableAmount = 0;
        $admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
        if(count($rental_booking_details) != 0){ 
            foreach($rental_booking_details as $rentals){
                $currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
                
                if($rentals['dispute_by']=='Host')
                {
                    if($rentals['currencycode']!=$admin_currencyCode){
                        $re_payable = currency_conversion($pro->user_currencycode, $admin_currency_code, $rentals['paid_cancel_amount'],$rentals['currency_cron_id']);
                    }
                    else
                    {
                        $re_payable = $rentals['paid_cancel_amount'];
                    }
                }
                else
                {
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
                }
                                    
                $payableAmount = $re_payable;
                $payableAmountCommi =  $rentals['subtotal']/100 * $rentals['cancel_percentage'];
                
            }
        }

        
            $dataArr = array(
                'customer_email'    =>  $this->input->post('hostEmail'),
                'transaction_id'    =>  $this->input->post('transaction_id'),
                'amount'            => $payableAmount, //in usd
                'status'            => '2',
                'pay_status'        =>"paid" 
            );
            $this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
            
            $this->db->update(EXP_COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$this->input->post('bookid')));

            redirect('admin/experience_dispute/cancel_booking_payment');
        }
    }
    public function add_pay_form_host()
    {
        if ($this->checkLogin('A') == '')
        {
            redirect('admin');
        }
        else {
            $this->data['heading'] = 'Add Experience Host payment';
            
            $sid = $this->uri->segment(4,0);
            $guestid = $this->uri->segment(5,0);
            
            $getGuestEmail=$this->product_model->get_all_details(USERS,array('id'=>$guestid));
            $theEmail_is=$getGuestEmail->row()->email;      
            //echo $theEmail_is; exit;          
            $hostEmailQry = $this->experience_model->get_commission_track_id($sid); 
            $product_id = $hostEmailQry->row()->vehicle_id;         
            $hostEmail = $hostEmailQry->row()->host_email;

            $this->data['hostEmail'] = $theEmail_is;          
            $this->data['bookid'] = $sid;
            // $this->data['vehicle_type'] = $hostEmailQry->row()->vehicle_type; 

            $rental_booking_details= $this->experience_model->get_unpaid_reviewcommission_tracking_details($hostEmail,$sid);       
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
                    if($rentals['dispute_by']=='Host')
                    {
                        if($rentals['user_currencycode']!=$admin_currencyCode)
                        {
                            $re_payable=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['paid_cancel_amount'],$currencyCronId);
                        }
                        else
                        {
                            $re_payable=$rentals['paid_cancel_amount'];
                        }
                    }
                    else
                    {
                        //echo $rentals['cancel_percentage']; exit;
                        

                        //
                    }
                        $payableAmount =  $re_payable; 
                    }
                }           
            //payableAmount
            $this->data['payableAmount'] = $payableAmount;
          //  echo $payableAmount;exit();
            $this->data['GuestEmail'] = $theEmail_is;
            $this->load->view('admin/experience_host_cancel/add_admin_payment',$this->data);
        }
    }
    public function paypal_Cancelpayment_property()
    {
        /*print_r($this->input->post()); exit;Array ( [amount_from_db] => 680 [vehicle_type] => 4 [amount_to_pay] => 680 [GuestEmail] => testrmisys@gmail.com [booking_number] => VE1500023 [hostEmail] => nagoor@pofitec.com [guestPayPalEmail] => nagoorbuyers@gmail.com ) */
        if ($this->checkLogin('A') == '')
        {
            redirect('admin');
        }
        else
        {       
            $this->load->library('paypal_class');
           // $vehicle_type = $this->input->post('vehicle_type'); 
            $return_url = base_url().'admin/experience/paypal_cancelAmount_success_property';
            $cancel_url = base_url().'admin/experience/paypal_cancelAmount_cancel_property'; 
            $notify_url = base_url().'admin/experience/paypal_cancelAmount_notify_property';
            $item_name = $this->config->item('email_title').' Cancel Vehicle Booking Payment';
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
            $this->paypal_class->add_field('custom', $guestEmail.'|'.$totalAmount.'|'.$BookingNumber.'|'.$vehicle_type); /*Custom Values*/
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
        $vehicle_type = $custom_values[3];
        $this->data['mc_gross'] = $_REQUEST['mc_gross']; 
        $this->data['currency_code'] = $_REQUEST['mc_currency'];
        $dataArr = array(
                        'customer_email'    =>$this->data['guestEmail'],
                        'transaction_id'    =>$this->data['txn_id'],
                        'amount'            =>$paypal_amount,
                        'status'            =>2,
                        'pay_status'        =>'paid'
                        );

        $this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
        $this->db->update(EXP_COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$booking_number));
        $this->setErrorMessage('success','Host Cancel Booking Payment is completed');
        redirect('admin/experience_dispute/cancel_booking_payment');

        
    }
   public function paypal_cancelAmount_cancel_property()
    {
        $this->setErrorMessage('error','Cancel Property Booking Payment is Failed');
        
        redirect('admin/experience_dispute/cancel_booking_payment');
    }
    public function paypal_cancelAmount_notify_property(){
        $this->setErrorMessage('error','From Paypal ipn');
        //$type = end($this->uri->segments);
        redirect('admin/experience_dispute/cancel_booking_payment');
    }
	/**
	 *
	 *This function shows Active,InActive and booked Experiences
	 */
	public function display_exp_dashboard()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			/**Active inactive Experience**/
			$query = "SELECT * FROM " . EXPERIENCE . " WHERE status !='2'";
			$this->data['ExpDetails'] = $this->experience_model->ExecuteQuery($query);
			/**To get most viewed Experiences**/
			$this->data['MostViewed'] = $this->experience_model->get_mostViewed_experiences();
			/**Booked count of Experiences**/
			$this->data['BookedCount'] = $this->experience_model->booked_experiences();
			$this->load->view('admin/experience/display_exp_dashboard', $this->data);
		}
	}

	/**
	 *
	 * This function loads add experience type page
	 */
	public function addExperienceType_from()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Add Experience Type ';
			$this->load->view('admin/experience/add_experience_type', $this->data);
		}
	}

	/**
	 *
	 * Function to insert new experience type
	 */
	public function saveExperienceType()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$experience_title = ucfirst($this->input->post('experience_title'));
			//$experience_title_ar = $this->input->post('experience_title_ar');								
			$experience_description = $this->input->post('experience_description');
		//	$experience_description_ar = $this->input->post('experience_description_ar');			
			$check = array('experience_title' => $experience_title);	
			//$check_ar = array('experience_title_ar' => $experience_title_ar);		
			$duplicate_name = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $check);			
			//$duplicate_name_ar = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $check_ar);
			if ($duplicate_name->num_rows() > 0) {
				$this->setErrorMessage('error', 'Experience Title already exists');
				redirect('admin/experience/addExperienceType_from/' . $experience_id);
			} 
			// elseif($duplicate_name_ar->num_rows()> 0){
			// 	$this->setErrorMessage('error', 'Experience Title in Arabic already exists');
			// 	redirect('admin/experience/addExperienceType_from/' . $experience_id);
			// }
			else {
				$excludeArr = array("status");
				$dataArr = array('experience_title' => $experience_title, 'experience_description' => $experience_description,  'status' => 'Active');

                foreach(language_dynamic_enable("experience_description","") as $dynlang) {
                $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
                 }
                 foreach(language_dynamic_enable("experience_title","") as $dynlang) {
                $dataArr=array_merge($dataArr,array($dynlang[1] => ucfirst($this->input->post($dynlang[1]))));
                 }
                //print_r($dataArr);exit();
				$this->db->insert(EXPERIENCE_TYPE, $dataArr);
				$this->setErrorMessage('success', 'Experience saved successfully');
				redirect('admin/experience/experienceTypeList');
			}
		}
	}

	/**
	 *
	 * This function loads the edit experience type form
	 */
	public function edit_experienceType_form()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Edit Category Type';
			$experience_id = $this->uri->segment(4, 0);
			$condition = array('id' => $experience_id);
			$this->data['experience_details'] = $this->experience_model->view_experienceType($condition);
			if ($this->data['experience_details']->num_rows() == 1) {
				$this->load->view('admin/experience/edit_experienceType', $this->data);
			} else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function Edit Exprience Type
	 */
	public function EditExperienceType()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$experience_id = $this->input->post('experience_id');
			$experience_title = ucfirst($this->input->post('experience_title'));
			//$experience_title_ar = $this->input->post('experience_title_ar');
			$experience_description = $this->input->post('experience_description');
			//$experience_description_ar = $this->input->post('experience_description_ar');			
			// $check = array('experience_title' => $experience_title, 'id !=' => $experience_id);
   //          foreach(language_dynamic_enable("experience_title","") as $dynlang) {
   //              $check=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
   //               }
			// //$check_ar = array('experience_title_ar' => $experience_title_ar, 'id !=' => $experience_id);
			// $duplicate_name = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $check);
			// //$duplicate_name_ar = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $check_ar);

			// if ($duplicate_name->num_rows() > 0) {
			// 	$this->setErrorMessage('error', 'Experience Category already exists');
			// 	redirect('admin/experience/edit_experienceType_form/' . $experience_id);
			// }
			// elseif($duplicate_name_ar->num_rows() > 0){
			// 	$this->setErrorMessage('error', 'Experience Category Arabic already exists');
			// 	redirect('admin/experience/edit_experienceType_form/'. $experience_id);
			// }

			// else {
				$condition = array('id' => $experience_id);
				$excludeArr = array("status");
				$dataArr = array('experience_title' => $experience_title, 'experience_description' => $experience_description,'status' => 'Active');

				foreach(language_dynamic_enable("experience_description","") as $dynlang) {
               	$dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
           		 }
                 foreach(language_dynamic_enable("experience_title","") as $dynlang) {
                $dataArr=array_merge($dataArr,array($dynlang[1] => ucfirst($this->input->post($dynlang[1]))));
                 }
                // print_r($dataArr);exit();
				$this->experience_model->edit_experienceType($dataArr, $condition);
				$this->setErrorMessage('success', 'Experience Category updated successfully');
				redirect('admin/experience/experienceTypeList');
			// }
		}
	}

	/**
	 *
	 * This function loads the experience type view page
	 */
	public function view_experienceType()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'View Experience Type';
			$experience_id = $this->uri->segment(4, 0);
			$condition = array('id' => $experience_id);
			$this->data['experience_details'] = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $condition);
			if ($this->data['experience_details']->num_rows() == 1) {
				$this->load->view('admin/experience/view_experienceType', $this->data);
			} else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function delete the exprience type record from db
	 */
	public function delete_experienceType()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$experience_id = $this->uri->segment(4, 0);
			$condition = array('id' => $experience_id);
			$this->experience_model->commonDelete(EXPERIENCE_TYPE, $condition);
			$this->setErrorMessage('success', 'Experience Type deleted successfully');
			redirect('admin/experience/experienceTypeList');
		}
	}

	/**
	 *
	 * This function change the attribute status, delete the experience type record
	 */
	public function change_experience_type_status_global()
	{
		if ($this->input->post('checkboxID') != '') {
			if ($this->input->post('checkboxID') == '0') {
				redirect('admin/experience/add_experience_form/0');
			} else {
				redirect('admin/experience/add_experience_form/' . $this->input->post('checkboxID'));
			}
		} else {
			if (count($this->input->post('checkbox_id')) > 0 && $this->input->post('statusMode') != '') {
				$this->experience_model->activeInactiveCommon(EXPERIENCE_TYPE, 'id');
				if (strtolower($this->input->post('statusMode')) == 'delete') {
					$this->setErrorMessage('success', 'Records deleted successfully');
				} else {
					$this->setErrorMessage('success', 'Records status changed successfully');
				}
				redirect('admin/experience/experienceTypeList');
			}
		}
	}

	/* Experience type status change starts */
	public function change_experienceType_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$product_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $product_id);
			$this->experience_model->update_details(EXPERIENCE_TYPE, $newdata, $condition);
			$this->setErrorMessage('success', 'Experience Type Status Changed Successfully');
			redirect('admin/experience/experienceTypeList');
		}
	}

	/*  Experience starts */
	public function experienceList()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$name_filter = $_GET['experience_name_filter_val'];
			//echo "string";exit();
			$this->data['heading'] = 'Experience List';
			/*-----------------------*/
			$this->load->library('pagination');
			$limit_per_page = 20;
			if($name_filter == ''){
						$Total_properties = $this->db->select('experience_id')->get(EXPERIENCE)->num_rows();
					}
					else {
						$Total_properties = $this->db->select('experience_id')->where('experience_title LIKE "%'. addslashes($name_filter).'%"')->get(EXPERIENCE)->num_rows();
					//	echo $name_filter.$Total_properties;exit();
					}

			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$config['base_url'] = base_url() . 'admin/experience/experienceList';
			$config['total_rows'] = $Total_properties;
			$config['per_page'] = $limit_per_page;
			$config['uri_segment'] = 4;
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['first_link'] = '<< ';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = ' >>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$this->data["links"] = $this->pagination->create_links();
			/*-----------------------*/
			$condition = 'where u.status="Active" or u.status="Inactive" or p.user_id=0 group by cit.name order by p.added_date desc';
			if($name_filter == ''){
			$this->data['experienceList'] = $this->experience_model->get_allthe_details($_GET['status'], $_GET['city'], $_GET['id'], $limit_per_page, $start_index);
		}
		else {
				$this->data['experienceList'] = $this->experience_model->get_allthe_details_filt($_GET['status'], $_GET['city'], $_GET['id'], $limit_per_page, $start_index, $name_filter);
				//echo "<pre>";
		//	print_r($this->data['experienceList']->result());exit();
		}
			
			foreach ($this->data['experienceList']->result() as $row) {
				$expId = $row->experience_id;
			}
			$this->data['userdetails'] = $this->experience_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
			$this->data['options'] = $this->experience_model->get_search_options($condition);
			$this->load->view('admin/experience/display_experience_list', $this->data);
		}
	}

	/*** mail publish/Unpublish ***/
	public function publish_mail()
	{
		/* Admin Mail function */
		//$username = username
		$email = $_POST['email'];
		$firstname = $_POST['firstname'];
		$newsid = '51';
		$template_values = $this->experience_model->get_newsletter_template_details($newsid);
		if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
			$sender_email = $this->data['siteContactMail'];
			$sender_name = $this->data['siteTitle'];
		} else {
			$sender_name = $template_values['sender_name'];
			$sender_email = $template_values['sender_email'];
		}
		//$cfmurl = 'Host has approved your property and it is showing in listing page.';
		$logo_mail = $this->data['logo'];
		$email_values = array(
			'from_mail_id' => $sender_email,
			'to_mail_id' => $email,
			'subject_message' => $template_values ['news_subject'],
			'body_messages' => $message
		);
		$reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail);
		//print_r($this->data['logo']);
		$message = $this->load->view('newsletter/AdminExperienceApprove' . $newsid . '.php', $reg, TRUE);
		//send mail
		$this->load->library('email');
		$this->email->from($email_values['from_mail_id'], $sender_name);
		$this->email->to($email_values['to_mail_id']);
		$this->email->subject($email_values['subject_message']);
		$this->email->set_mailtype("html");
		$this->email->message($message);
		try {
			$this->email->send();
			$returnStr ['msg'] = 'Successfully registered';
			$returnStr ['success'] = '1';
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		redirect('admin/product/display_product_list');
		/* Admin Mail function End */
	}

	public function unpublish_mail()
	{
		/* Admin Mail function */
		$email = $_POST['email'];
		$firstname = $_POST['firstname'];
		$newsid = '52';
		$template_values = $this->experience_model->get_newsletter_template_details($newsid);
		if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
			$sender_email = $this->data['siteContactMail'];
			$sender_name = $this->data['siteTitle'];
		} else {
			$sender_name = $template_values['sender_name'];
			$sender_email = $template_values['sender_email'];
		}
		//$cfmurl = 'Host has approved your property and it is showing in listing page.';
		$logo_mail = $this->data['logo'];
		$email_values = array(
			'from_mail_id' => $sender_email,
			'to_mail_id' => $email,
			'subject_message' => $template_values ['news_subject'],
			'body_messages' => $message
		);
		$reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail);
		//print_r($this->data['logo']);
		$message = $this->load->view('newsletter/AdminExperienceUnapproved' . $newsid . '.php', $reg, TRUE);
		//send mail
		$this->load->library('email');
		$this->email->from($email_values['from_mail_id'], $sender_name);
		$this->email->to($email_values['to_mail_id']);
		$this->email->subject($email_values['subject_message']);
		$this->email->set_mailtype("html");
		$this->email->message($message);
		try {
			$this->email->send();
			$returnStr ['msg'] = 'Successfully registered';
			$returnStr ['success'] = '1';
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		redirect('admin/product/display_product_list');
		/* Admin Mail function End */
	}




	/*****/
	/* add and edit experience starts */
	public function add_experience_form()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			if ($this->uri->segment(4, 0) == '')
				$this->data['heading'] = 'Add New Experience';
			else
				$this->data['heading'] = 'Edit Experience';
			$product_id = $this->data['Product_id'] = $this->uri->segment(4, 0);
			$this->data['productAddressData'] = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $product_id));
			$this->data['listDetail'] = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
			// $this->data['listTypeValues'] = $this->db->select('lt.*,lc.*')->from('fc_listing_types as lt')->join('fc_listing_child as lc','lc.parent_id = lt.id','left')->get();
			$this->data['productOldAddress'] = $this->experience_model->get_old_address($product_id);
			//Rental Address
			$this->data['RentalCountry'] = $this->experience_model->get_all_details(COUNTRY_LIST, array('status' => 'Active'), array(array('field' => 'name', 'type' => 'asc')));
			$this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
			$this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
			$this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname,email', USERS, 'where status="Active" ');
			//currency list
			$this->data['currencyList'] = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
			//	$this->data['getCommonFacilityDetails'] = $this->product_model->getCommonFacilityDetails();
			//	$this->data['getPropertyType'] = $this->product_model->getPropertyType();
			//	$this->data['getExtraFacilityDetails'] = $this->product_model->getExtraFacilityDetails();
			//	$this->data['getSpecialFeatureFacilityDetails'] = $this->product_model->getSpecialFeatureFacilityDetails();
			//$this->data['getHomeSafetyFacilityDetails'] = $this->product_model->getHomeSafetyFacilityDetails();
			$this->data['imgDetail'] = $this->experience_model->get_images($product_id);
			//$this->data['membershipplan']=$this->product_model->getMembershipPackage();
			//$listIdArr=array();
		}
		$languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
		$this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
		$this->data['experienceTypeList'] = $this->experience_model->view_experienceType_details();
		/*edit form code*/
		$id = $this->uri->segment(4, 0);
		$hotel_id = $this->uri->segment(4);
		if ($hotel_id != '') {
			/*$condition=array('id'=>$hotel_id);
			$condition = array(TOUR.'.id' => $hotel_id);*/
			//$this->data['product_details']=$this->tour_model->display_tour_list($condition);
			$this->data['product_details'] = $this->experience_model->view_product1($hotel_id);
			if ($this->data['product_details']->num_rows() > 0) {
				if ($this->data['product_details']->row()->language_list != '') {
					$this->data['language_list'] = $this->experience_model->ExecuteQuery("select language_name from " . LANGUAGES_KNOWN . " where language_code in (" . $this->data['product_details']->row()->language_list . ") ");
				}
			}
			$condition = array('experience_id' => $hotel_id);
			$this->data['date_details'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
			$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
		}
		$this->load->library('googlemaps');
		$config['center'] = '37.4419, -122.1419';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '37.429, -122.1419';
		$marker['draggable'] = true;
		$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$this->data['map'] = $this->googlemaps->create_map();
		$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
		$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
		$this->load->view('admin/experience/add_experience', $this->data);
	}

	/**
	 *
	 *Function to add and edit experience 
	 */
	public function add_experience_form_new($id = '')
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			if ($this->uri->segment(4, 0) == '') {
				$this->data['heading'] = 'Experience';
			} else {
				$this->data['heading'] = 'Experience';
			}
            $this->data['lang_count'] = $this->experience_model->get_all_details(LANGUAGES, array('status'=>'Active','dynamic_lang'=>'1'))->num_rows();
			$product_id = $this->data['Product_id'] = $this->uri->segment(4, 0);
			$this->data['productAddressData'] = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $product_id));
			$this->data['listDetail'] = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
			$this->data['productOldAddress'] = $this->experience_model->get_old_address($product_id);
			/*Rental Address*/
			$this->data['RentalCountry'] = $this->experience_model->get_all_details(COUNTRY_LIST, array('status' => 'Active'), array(array('field' => 'name', 'type' => 'asc')));
			$this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
			$this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
			$this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname,email', USERS, 'where status="Active" and host_status=0');
			/*currency list*/
			$this->data['currencyList'] = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
			$this->data['imgDetail'] = $this->experience_model->get_images($product_id);
		}
		$languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
		$this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
		$this->data['experienceTypeList'] = $this->experience_model->view_experienceType_details();
		/*edit form code*/
		$id = $this->uri->segment(4, 0);
		$hotel_id = $this->uri->segment(4);
		if ($hotel_id != '') {
			$this->data['product_details'] = $this->experience_model->view_product1($hotel_id);
			if ($this->data['product_details']->num_rows() > 0) {
				if ($this->data['product_details']->row()->language_list != '') {
					$this->data['language_list'] = $this->experience_model->ExecuteQuery("select language_name from " . LANGUAGES_KNOWN . " where language_code in (" . $this->data['product_details']->row()->language_list . ") ");
				}
			}
			$condition = array('experience_id' => $hotel_id);
			$this->data['date_details'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
			$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
			$this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$hotel_id");
			if ($this->data['listDetail']->row()->currency != '') {
				$currentCurrency = $this->product_model->get_all_details(CURRENCY, array('currency_type' => $this->data['listDetail']->row()->currency));
				$this->data['currentCurrency'] = $currentCurrency->row()->currency_symbols;
				$this->data['currentCurrency_type'] = $currentCurrency->row()->currency_type;
			}
			$date_time_details = $this->experience_model->get_date_time_details($product_id);
			$this->data['date_details'] = $date_time_details;
		}
		$this->load->library('googlemaps');
		$config['center'] = '37.4419, -122.1419';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '37.429, -122.1419';
		$marker['draggable'] = true;
		$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$this->data['map'] = $this->googlemaps->create_map();
		$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
		$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
		$this->data['id'] = $id;
		$minimum_stay = $this->experience_model->get_data_minimum_stay();
		$this->data['minimum_stay'] = $minimum_stay->result();
		$currentCurrency = $this->experience_model->get_all_details(CURRENCY, array('status'=>'Active'));
		$this->data['currentCurrency_all'] = $currentCurrency->result();
		$this->load->view('admin/experience/add_experience_new', $this->data);
	}

	/**
	 *
	 * This function update languages
	 */
	public function update_languages()
	{
		$excludeArr = array('languages', 'languages_known');
		$inputArr['language_list'] = implode(',', $this->input->post('languages_known'));
		$condition = array('experience_id' => $this->input->post('expID'));
		$this->experience_model->update_details(EXPERIENCE, array('language_list' => $inputArr['language_list']), $condition);
		$this->db->select('*');
		$this->db->from(LANGUAGES_KNOWN);
		$this->db->where_in('language_code', $this->input->post('languages_known'));
		$languages = $this->db->get();
		$returnStr = '';
		foreach ($languages->result() as $lang) {
			$returnStr .= '<li id="' . $lang->language_code . '">' . $lang->language_name . '<small><span class="text-normal remove cursor_pointer" href="javascript:void(0);" onclick="delete_languages(this,' . $lang->language_code . ')"> <i class="fa fa-times" aria-hidden="true"></i></span></small></li>';
		}
		echo $returnStr;
	}

	/**
	 *
	 * This function delete languages
	 */
	public function delete_languages()
	{
		$experience_id = $this->input->post('experience_id');
		$languages_known_query = 'SELECT language_list FROM ' . EXPERIENCE . ' WHERE experience_id=' . $experience_id;
		$languages_known = $this->experience_model->ExecuteQuery($languages_known_query);
		$languages = explode(',', $languages_known->row()->language_list);
		$position = array_search($this->input->post('language_code'), $languages);
		unset($languages[$position]);
		$excludeArr = array('languages', 'language_code');
		$inputArr['language_list'] = implode(',', $languages);
		$condition = array('experience_id' => $experience_id);
		$this->experience_model->update_details(EXPERIENCE, array('language_list' => $inputArr['language_list']), $condition);
		echo json_encode(array('status_code' => 1));
	}

	/**
	 *
	 * This function add new experience
	 */
	public function add_experience_new()
	{
		$dat_count = $this->input->post('total_count_date');
		$time_count = $this->input->post('total_count_time');
		$experience_type = $this->input->post('experience_type');
		$currency = $this->session->userdata('currency_type');
		$type_id = $this->input->post('type_id');
		$user_id = $this->input->post('user_id');
		if ($experience_type == '2') {
			$date_count = 1;
			$total_hours = $time_count;
		} else {
			$date_count = $dat_count;
			$total_hours = '';
		}
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$data = array(
				'type_id' => $type_id,
				'exp_type' => $experience_type,
				'date_count' => $date_count,
				'total_hours' => $total_hours,
				'user_id' => $user_id,
				'currency' => '',
				'status' => '0'
			);
			$this->experience_model->simple_insert(EXPERIENCE, $data);
			$getInsertId = $this->experience_model->get_last_insert_id();
			$this->experience_model->update_details(USERS, array('is_experienced' => '1'), array('id' => $id));
			$this->setErrorMessage('success', 'Experience Basic details saved successfully');
			echo json_encode(array("id" => $getInsertId, "status" => 1));
		}
	}

	public function add_org_details($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$organization = $this->input->post('organization');
			//$organization_ar = $this->input->post('organization_ar');
			$organization_des = $this->input->post('organization_des');
			//$organization_des_ar = $this->input->post('organization_des_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'organization' => $organization,
				//'organization_ar' => $organization_ar,
				'organization_des' => $organization_des,
				//'organization_des_ar' => $organization_des_ar
			);

			foreach(language_dynamic_enable("organization","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("organization_des","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Experience Organization details saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_exp_details($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$experience_title = $this->input->post('experience_title');
		//	$experience_title_ar = $this->input->post('experience_title_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'experience_title' => $experience_title,
				//'experience_title_ar' => $experience_title_ar
			);

			foreach(language_dynamic_enable("experience_title","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Experience title saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_tagline_experience($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$exp_tagline = $this->input->post('exp_tagline');
			//$exp_tagline_ar = $this->input->post('exp_tagline_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'exp_tagline' => $exp_tagline,
				//'exp_tagline_ar' => $exp_tagline_ar
			);


			foreach(language_dynamic_enable("exp_tagline","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Experience tagline saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_exp_video_url($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$video_url = $this->input->post('video_url');
			$condition = array('experience_id' => $expid);
			$data = array(
				'video_url' => $video_url
			);
			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_what_we_do($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$what_we_do = $this->input->post('what_we_do');
			//$what_we_do_ar = $this->input->post('what_we_do_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'what_we_do' => $what_we_do,
				//'what_we_do_ar' => $what_we_do_ar
			);

			foreach(language_dynamic_enable("what_we_do","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_where_we_will_be($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$location_description = $this->input->post('location_description');
			//$location_description_ar = $this->input->post('location_description_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'location_description' => $location_description,
				//'location_description_ar' => $location_description_ar
			);

			foreach(language_dynamic_enable("location_description","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_note_to_guest($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$note_to_guest = $this->input->post('note_to_guest');
			//$note_to_guest_ar = $this->input->post('note_to_guest_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'note_to_guest' => $note_to_guest,
				//'note_to_guest_ar' => $note_to_guest_ar
			);

			foreach(language_dynamic_enable("note_to_guest","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_about_host($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$about_host = $this->input->post('about_host');
			//$about_host_ar = $this->input->post('about_host_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'about_host' => $about_host
			);
            foreach(language_dynamic_enable("about_host","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_guest_requirement($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$guest_requirement = $this->input->post('guest_requirement');
			//$guest_requirement_ar = $this->input->post('guest_requirement_ar');
			$condition = array('experience_id' => $expid);
			$data = array(
				'guest_requirement' => $guest_requirement,
				//'guest_requirement_ar' => $guest_requirement_ar
			);

			foreach(language_dynamic_enable("guest_requirement","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_group_size($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$group_size = $this->input->post('group_size');
			$condition = array('experience_id' => $expid);
			$data = array(
				'group_size' => $group_size
			);
			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_price($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$price = $this->input->post('price');
			$currency = $this->input->post('currency');
			$condition = array('experience_id' => $expid);
			$data = array(
				'currency' => $currency,
				'price' => $price
			);
			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->experience_model->update_details(EXPERIENCE_DATES, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
			//redirect('admin/experience/add_experience_form_new/'.$expid.'#cancel_policy_tab');
		} else {
			redirect('admin');
		}
	}

	public function add_cancel_policy($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$cancel_policy = $this->input->post('cancel_policy');
			$cancel_policy_des = $this->input->post('cancel_policy_des');
			//$cancel_policy_des_ar = $this->input->post('cancel_policy_des_ar');
			$security_deposit = $this->input->post('sec_deposit');
			if ($cancel_policy == 'Strict') {
				$cancel_percentage = 100; //100% Amount to host
			} else {
				$cancel_percentage = $this->input->post('cancel_percentage');
			}
			$condition = array('experience_id' => $expid);
			$data = array(
				'cancel_policy' => $cancel_policy,
				'cancel_policy_des' => $cancel_policy_des,
			//	'cancel_policy_des_ar' => $cancel_policy_des_ar,
				'cancel_percentage' => $cancel_percentage,
				'security_deposit' => $security_deposit,
				//'status'=>'1'
			);

			foreach(language_dynamic_enable("cancel_policy_des","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_seo($exp_id = '')
	{
		if ($this->checkLogin('A') != '') {
			$meta_title = $this->input->post('meta_title');
			//$meta_title_ar = $this->input->post('meta_title_ar');
			$meta_keword = $this->input->post('meta_keyword');
			//$meta_keword_ar = $this->input->post('meta_keyword_ar');
			$meta_description = $this->input->post('meta_description');
		//	$meta_description_ar = $this->input->post('meta_description_ar');
			$condition = array('experience_id' => $exp_id);
			$data = array(
				'meta_title' => $meta_title,
				//'meta_title_ar' => $meta_title_ar,
				'meta_keyword' => $meta_keword,
				//'meta_keyword_ar' => $meta_keword_ar,
				'meta_description' => $meta_description,
				//'meta_description_ar' => $meta_description_ar
			);
			$userArr = array(
				'is_experienced' => '1'
			);
			$getUser = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $exp_id));
			$user_id = $getUser->row()->user_id;
			if ($user_id != '') {
				$user_condition = array('id' => $user_id);
				$this->experience_model->update_details(USERS, $userArr, $user_condition);
			}

			foreach(language_dynamic_enable("meta_title","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("meta_keyword","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("meta_description","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->experience_model->update_details(EXPERIENCE, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function get_new_timesheet()
	{
		///schedule_hours_
		if ($this->checkLogin('A') != '') {
			$exp_dates_id = $this->input->post('date_id');
			$condition = array('id' => $exp_dates_id);
			$res_data = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
			$date = $res_data->row();
			$condition1 = array('exp_dates_id' => $exp_dates_id);//all timing -active/inactive
			$res_data1 = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition1);
			$date_time = $res_data1->result();
			$disable_date = '';
			if (!empty($date_time)) {
				foreach ($date_time as $dat_time) {
					$disable_date .= '<input class="scheduled_date_exists" type="hidden" value="' . $dat_time->schedule_date . '">';
				}
			}
			$str = '';
			$str = '<tr id="child_create_' . $exp_dates_id . '" class="child_create_' . $exp_dates_id . '">';
			$str .= '<td colspan="3">';
			$str .= '<form id="new_time_sheet_' . $exp_dates_id . '" name="new_time_sheet_' . $exp_dates_id . '" class="form_container left_label listingInfo" accept-charset="UTF-8">';
			$str .= $disable_date;
			$str .= '<input type="hidden" id="experience_id_' . $exp_dates_id . '" name="experience_id" value="' . $date->experience_id . '">';
			$str .= '<input type="hidden" id="from_date_' . $exp_dates_id . '" name="from_date" value="' . $date->from_date . '">';
			$str .= '<input type="hidden" id="to_date_' . $exp_dates_id . '" name="to_date" value="' . $date->to_date . '">';
			//$str.='<input type="hidden" id="exp_dates_id_'.$exp_dates_id.'" name="exp_dates_id" value="'.$exp_dates_id.'">';
			$str .= '<input type="hidden" name="exp_dates_id" value="' . $exp_dates_id . '">';
			$str .= '<div class="square_box" id="new_timesheet_' . $exp_dates_id . '">';
			$str .= '<div class="error_msg" id="new_form_error_msg_' . $exp_dates_id . '"></div>';
			$same_day = '';
			if ($date->from_date == $date->to_date) {
				$str .= '<p>Date <span class="req"><small>*</small></span>  <input type="text" name="schedule_date" autocomplete="off" id="schedule_date_' . $exp_dates_id . '" class="dev_multi_schedule_date input_class" value="' . $date->to_date . '" onclick="setDatepickerHere()" readonly style="width:40%;"></p>';
				$same_day = 1;
			} else {
				$str .= '<p>Date <span class="req"><small>*</small></span>  <input type="text" name="schedule_date" autocomplete="off" id="schedule_date_' . $exp_dates_id . '" class="dev_multi_schedule_date input_class" value="" onclick="setDatepickerHere()" style="width:40%;"></p>';
			}
			$str .= '<p>Time <span class="req"><small>*</small></span> <input type="text" class="dev_time input_class" id="star_time_' . $exp_dates_id . '" name="start_time" value="" style="width:40%;" onkeypress="return return_false_fun(event)" onchange="assign_to_time_hour(' . $exp_dates_id . ');" >&nbsp;-&nbsp;&nbsp;&nbsp;';
			$str .= '<input class="dev_time input_class" id="end_time_' . $exp_dates_id . '" name="end_time" type="text" value="" style="width:40%;" onkeypress="return return_false_fun(event)"';
			//$str .= ($same_day == 1) ? "readOnly" : "";
			$str .= ' >';
			$str .= '</p>';	

			$str .= '<p>Title <span class="req"><small>*</small></span> <input name="title" type="text" value="" style="width:100%;" id="title_' . $exp_dates_id . '" class="input_class"  onkeydown="word_count(this)"><span class="small_label"><span id="title_' . $exp_dates_id . '_char_count"></span> </span></p>';
			
			

			$str .= '<p>Description <span class="req"><small>*</small></span><textarea  name="description" id="description_' . $exp_dates_id . '" onkeydown="description_count(this)"></textarea><span class="small_label"><span id="description_' . $exp_dates_id . '_char_count"></span> </span></p>';


                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                    


          //  foreach(language_dynamic_enable("title","") as $dynlang) {

            $str .= '<p>Title ('.$data->name.') <span class="req"><small>*</small></span> <input name="title_'.$data->lang_code.'" type="text" value="" style="width:100%;" id="title_'.$data->lang_code.'_' . $exp_dates_id . '" class="input_class"  onkeydown="word_count(this)"><span class="small_label"><span id="title_'.$data->labg_code.'_'  . $exp_dates_id . '_char_count"></span> </span></p>';
        //    }
 			
 			//foreach(language_dynamic_enable("description","") as $dynlang){			

			$str .= '<p>Description('.$data->name.') <span class="req"><small>*</small></span><textarea  name="description_'.$data->lang_code.'" id="description_'.$data->lang_code.'_' . $exp_dates_id . '" onkeydown="description_count(this)"></textarea><span class="small_label"><span id="description_'.$data->lang_code.'_'  . $exp_dates_id . '_char_count"></span> </span></p>';

			}
        }

			$str .= '<p class="text-right"><button class="btn btn-sm btn-success" id="add_time_sheet_' . $exp_dates_id . '" type="button" onclick="add_time_sheet(' . $exp_dates_id . ')">Submit</button>&nbsp;<button class="btn btn-default btn-sm" id="add_time_sheet_' . $exp_dates_id . '" type="button" onclick="cancel_time_sheet(' . $exp_dates_id . ')">Cancel</button></p>';
			$str .= '</div>';
			$str .= '</form>';
			$str .= '</td>';
			$str .= '</tr>';
			echo $str;
		} else {
			redirect('admin');
		}
	}

	public function get_timesheets()
	{
		if ($this->checkLogin('A') != '') {
			$exp_dates_id = $this->input->post('date_id');
			$status = $this->input->post('status');
			$condition = array('exp_dates_id' => $exp_dates_id);
			$res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
			$data = $res_data->result();
			//echo $this->db->last_query();
			//print_r($data);
			$str = '<tr id="child_view_' . $exp_dates_id . '" class="child_' . $exp_dates_id . '">';
			if (count($data) > 0) {
				$str .= '<td colspan="3" style="padding:0;">';
				$str .= '<table class="table table-striped">';
				$str .= '<thead><th>Scheduled Date</th><th>Time</th><th>Title</th><th>Action</th></thead>';
				foreach ($data as $time) {
					$str .= '<tr id="first_child_' . $time->id . '">';
					$str .= '<td><input type="hidden" value="' . $time->schedule_date . '" class="dev_multi_schedule_date_new">' . $time->schedule_date . '</td>';
					$str .= '<td>' . date('h:i A', strtotime($time->start_time)) . '-' . date('h:i A', strtotime($time->end_time)) . '</td>';
					$str .= '<td>' . $time->title . '</td><td>';
					if ($status != 'booked') {
						$str .= '<i class="fa fa-pencil-square-o cursor_pointer" aria-hidden="true" title="edit" onclick="edit_time_sheet(' . $time->id . ',' . $exp_dates_id . ')"></i>&nbsp';
						$str .= '<i class="fa fa-times cursor_pointer" aria-hidden="true" onclick="remove_time_sheet(' . $time->id . ')" title="delete time schedule"></i>&nbsp;&nbsp;';
						if ($time->status == 1) {
							$active_str = "Active";
						} else {
							$active_str = "Inactive";
						}
						$str .= '<span class="" title="change status"><a class="btn-sm" href="javascript:void(0);" onclick="change_timing_status(' . $time->id . ',this,' . $exp_dates_id . ');">' . $active_str . '</a></span>&nbsp;</td></tr>';
					} else {
						$str .= 'Booked';
					}
					/*$str.='<form id="time_sheet_'.$time->id.'" name="time_sheet_'.$time->id.'">';
				$str.='<input type="hidden" name="id" value="'.$time->id.'">';
				$str.='<div class="square_box" id="timesheet_'.$time->id.'">';

				$str.='<p class="text-right"><i class="fa fa-pencil-square-o" aria-hidden="true" onclick="edit_time_sheet('.$time->id.')"></i>&nbsp;<i class="fa fa-undo" aria-hidden="true" onclick="undo_timesheet('.$time->id.');"></i>&nbsp;<i class="fa fa-times" aria-hidden="true" onclick="remove_time_sheet('.$time->id.')"></i>&nbsp;</p>';
				$str.='<p>schedule_date : '.$time->schedule_date.'</p>';
				$str.='<p>Time  <input type="text" class="dev_time" name="start_time" value="'.$time->start_time.'" >&nbsp;-&nbsp;<input class="dev_time" name="end_time" type="text" value="'.$time->end_time.'"></p>';
				$str.='<p>title  <input name="title" type="text" value="'.$time->title.'" style="width:100%;"></p>';
				$str.='<p>description<textarea name="description">'.$time->description.'</textarea></p>';
				$str.='<p class="text-right"><button class="next-btn btn-sm" id="update_time_sheet_'.$time->id.'" type="button" style="display:none;width: 70px;color: #fff;" onclick="update_time_sheet('.$time->id.')">Update</button></p>';
				$str.='</div>';
				$str.='</form>';*/
				}
				$str .= '</table>';
				$str .= '</td>';
			} else {
				$str .= '<td colspan="3">';
				$str .= 'No schedule found..';
				$str .= '</td>';
			}
			$str .= '</tr>';
			echo $str;
		} else {
			redirect('admin');
		}
	}

	public function view_timesheet_forStatus()
	{
		if ($this->checkLogin('A') != '') {
			$exp_dates_id = $this->input->post('date_id');
			$status = $this->input->post('status_is');
			$condition = array('exp_dates_id' => $exp_dates_id);
			$res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
			$data = $res_data->result();
			$str = '<tr id="child_view_' . $exp_dates_id . '" class="child_' . $exp_dates_id . '">';
			if (count($data) > 0) {
				$str .= '<td colspan="3" style="padding:0;">';
				$str .= '<table class="table table-striped">';
				$str .= '<thead><th>Scheduled Date</th><th>Time</th><th>Title</th><th>Action</th></thead>';
				foreach ($data as $time) {
					$str .= '<tr id="first_child_' . $time->id . '">';
					$str .= '<td><input type="hidden" value="' . $time->schedule_date . '" class="dev_multi_schedule_date_new">' . $time->schedule_date . '</td>';
					$str .= '<td>' . date('h:i A', strtotime($time->start_time)) . '-' . date('h:i A', strtotime($time->end_time)) . '</td>';
					$str .= '<td>' . $time->title . '</td>
				<td>';
					$str .= '<span class="" title="change status">' . $status . '</span>&nbsp;  </td></tr>';
				}
				$str .= '</table>';
				$str .= '</td>';
			} else {
				$str .= '<td colspan="3">';
				$str .= 'No schedule found..';
				$str .= '</td>';
			}
			$str .= '</tr>';
			echo $str;
		} else {
			redirect('admin');
		}
	}

	public function add_timesheet()
	{
		if ($this->checkLogin('A') != '') {
			$start_time = $this->input->post('start_time');
			$schedule_date = $this->input->post('schedule_date');
			$end_time = $this->input->post('end_time');
			$title = $this->input->post('title');
			//$title_ar = $this->input->post('title_ar');

			$description = $this->input->post('description');
			//$description_ar = $this->input->post('description_ar');
			$experience_id = $this->input->post('experience_id');
			$exp_dates_id = $this->input->post('exp_dates_id');
			$datArr = array('experience_id' => $experience_id, 'start_time' => $start_time, 'end_time' => $end_time, 'schedule_date' => $schedule_date, 'title' => $title, 'description' => $description, 'exp_dates_id' => $exp_dates_id);

			foreach(language_dynamic_enable("title","") as $dynlang) {
               $datArr=array_merge($datArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
			foreach(language_dynamic_enable("description","") as $dynlang) {
               $datArr=array_merge($datArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }


			$res = $this->db->insert(EXPERIENCE_TIMING, $datArr);
			echo $res;
		} else {
			redirect();
		}
	}

	public function change_timing_status()
	{
		if ($this->checkLogin('A') != '') {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$exp_date_id = $this->input->post('exp_date_id');
			$condition = array('id' => $id);
			$data = array(
				'status' => $status
			);
			$res = $this->experience_model->update_details(EXPERIENCE_TIMING, $data, $condition);
			//echo $this->db->last_query();
			//echo $res."dd";
			//exit;
			if ($status == '0') {
				//if($res==true){
				$shedule_timing = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_TIMING, ' where experience_id=' . $exp_date_id . ' and status="1"');//active
				/*echo '||';
				echo $this->db->last_query();
				echo $shedule_timing->num_rows();*/
				if ($shedule_timing->num_rows() == 0) {
					// make date as inactive
					$status_d = '1';
					$condition_1 = array('id' => $exp_date_id);
					$data_1 = array(
						'status' => $status_d
					);
					//$res1=$this->experience_model->update_details(EXPERIENCE_DATES,$data_1,$condition_1);
					//echo $this->db->last_query();
					echo '2';
				} else {
					echo $res;
				}
				//}
			}
		} else {
			redirect('admin');
		}
	}

	public function change_date_status()
	{
		if ($this->checkLogin('A') != '') {
			$id = $this->input->post('id');
			$status = $this->input->post('status');
			$condition = array('id' => $id);
			$data = array(
				'status' => $status
			);
			$res = $this->experience_model->update_details(EXPERIENCE_DATES, $data, $condition);
			//echo $this->db->last_query();
			echo $res;
		} else {
			redirect('admin');
		}
	}

	public function update_timesheet()
	{
		if ($this->checkLogin('A') != '') {
			$start_time = $this->input->post('start_time');
			$end_time = $this->input->post('end_time');
			$title = $this->input->post('title');
			//$title_ar = $this->input->post('title_ar');
			$description = $this->input->post('description');
			//$description_ar = $this->input->post('description_ar');
			$id = $this->input->post('id');
			$schedule_date = $this->input->post('schedule_date');
			$condn = array('id' => $id);
			$dataArr = array('status' => '1', 'start_time' => $start_time, 'end_time' => $end_time, 'title' => $title, 'description' => $description, 'schedule_date' => $schedule_date);

			foreach(language_dynamic_enable("title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("description","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }


			$res = $this->experience_model->update_details(EXPERIENCE_TIMING, $dataArr, $condn);
    		echo "succ";
		} else {
			redirect('admin');
		}
	}

	public function delete_timesheet()
	{
		if ($this->checkLogin('A') != '') {
			$id = $this->input->post('id');
			$condn = array('id' => $id);
			/*$dataArr=array('status'=>'2');
			$res=$this->experience_model->update_details(EXPERIENCE_TIMING,$dataArr,$condn);
			*/
			$this->db->where('id', $id);
			$this->db->delete(EXPERIENCE_TIMING);
			echo $res;
		} else {
			redirect('admin');
		}
	}

	public function todateCalculate()
	{
		$from_date = $this->input->post('from_date');
		$date_count = $this->input->post('date_count');
		$tot_date = $date_count - 1;
		if ($date_count > 1)
			$to_date = date("Y-m-d", strtotime('+' . $tot_date . ' days', strtotime($from_date)));
		else
			$to_date = date("Y-m-d", strtotime($from_date));
		echo $to_date;
	}

	public function add_timing_row()
	{
		$rowId = $this->input->post('rowID') + 1;
		$date_count = $this->input->post('date_count');
		$from_date = $this->input->post('from_date');
		$schedule_date = '';
		if ($date_count > 1) {
			$schedule_date .= '<input type="text" class="dev_multi_schedule_date col-sm-2"  id="schedule_date' . $rowId . '" name="schedule_date[]" onclick="setDatepickerHere()" onkeypress="return isNumber(event)" />';
		} else {
			$schedule_date .= ' <input type="text" class="dev_multi_schedule_date dev_schedule_date col-sm-2"  id="schedule_date' . $rowId . '" name="schedule_date[]" value="' . $from_date . '" onkeypress="return isNumber(event)" readonly />';
		}
		echo '<div class="removeBlock"><div class="exp-addpanel">
				<div style="display:block; overflow:hidden;">
				 <div class="col-md-6">
				 <label>Date</label>
				' . $schedule_date . '
                  </div>
                  </div>
                   <div class="col-md-6">
				    <label>Start Time</label>
					<input type="text" class="dev_time" name="start_time[]" onkeypress="return isNumber(event)"   value="" required />
					 </div>

                    <div class="col-md-6">
                    <label>End Time</label>
					<input type="text" class="dev_time"  name="end_time[]" onkeypress="return isNumber(event)" value="" required />
						 </div>

						 <div class="col-md-12 exp-full">
					<label>Title</label>
					<input type="text" class="" name="schedule_title[]"  value="" required />

						 </div>

						 <div class="col-md-12">
					<label>Description</label>
					<textarea class="" name="schedule_description[]" required ></textarea>
				 </div>
				</div>
				<div class="exp-addicon minus-button"><button type="button" class="btn1"><i class="fa fa fa-minus-circle" aria-hidden="true"></i></button></div></div>

				<div class="exp-addicon"><button type="button" class="" id="add_timing_btn_' . $rowId . '" onclick="add_timing_row(' . $rowId . ')" ><span class="add-timeing">Add new Timeing</span><i class="fa fa-plus-circle" aria-hidden="true"></i></button></div>';
	}

	public function save_date_schedule_timing()
	{

		$experience_id = $this->input->post('experience_id');
		$dates_id = $this->input->post('dates_id');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$schedule_title = $this->input->post('schedule_title');
		$schedule_title_ar = $this->input->post('schedule_title_ar');
		$schedule_description = $this->input->post('schedule_description');
		$schedule_description_ar = $this->input->post('schedule_description_ar');
		$schedule_date = $this->input->post('schedule_date');
		//print_r($schedule_description);exit;
		//echo $schedule_description;exit;
		$length = count($start_time);
		$this->db->where('exp_dates_id', $dates_id);
		$this->db->delete(EXPERIENCE_TIMING);
		$inserted_dates = array();
		for ($i = 0; $i < $length; $i++) {
			if (($start_time[$i] != '' && $end_time[$i] != '') && ($start_time[$i] != '00:00' && $end_time[$i] != '00:00')) {
				if (!(in_array($schedule_date[$i], $inserted_dates))) {
					$dataArr = array('exp_dates_id' => $dates_id,
						'experience_id' => $experience_id,
						'schedule_date' => $schedule_date[$i],
						'start_time' => $start_time[$i],
						'end_time' => $end_time[$i],
						'title' => $schedule_title[$i],
						'title_ar' => $schedule_title_ar[$i],
						'description' => $schedule_description[$i] != '' ? $schedule_description[$i] : '',
						'description_ar' => $schedule_description_ar[$i] != '' ? $schedule_description_ar[$i] : '',
						'status' => '1'
					);
					$condition = array('exp_dates_id' => $dates_id, 'experience_id' => $experience_id, 'schedule_date' => $schedule_date[$i], 'start_time' => $start_time[$i]);
					$time_details = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
					if ($time_details->num_rows() > 0) {
						$condn = array('id' => $time_details->row()->id);
						$this->experience_model->update_details(EXPERIENCE_TIMING, $dataArr, $condn);
					} else {
						$sel_q = "select * from " . EXPERIENCE_TIMING . " where experience_id='" . $experience_id . "' and schedule_date='" . $schedule_date[$i] . "' and (((start_time BETWEEN '" . $start_time[$i] . "' and '" . $end_time[$i] . "') or (end_time BETWEEN '" . $start_time[$i] . "' and '" . $end_time[$i] . "')))";
						//exit;
						$checkValid = $this->experience_model->ExecuteQuery($sel_q);
						if ($checkValid->num_rows() == 0)
							$this->experience_model->simple_insert(EXPERIENCE_TIMING, $dataArr);
					}
				}
			}
			$inserted_dates[] = $schedule_date[$i];
		}
		$message = array('case' => '2');
		echo json_encode($message);
	}

	public function delete_timing_row()
	{
		$row_id = $this->input->post('row_id');
		$this->db->where('id', $row_id);
		$this->db->delete(EXPERIENCE_TIMING);
		echo 'success';
	}

	public function saveDates()
	{
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$date_count = $this->input->post('date_count');
		$experience_id = $this->input->post('experience_id');
		$price = $this->input->post('price');
		$currency = $this->input->post('currency');
		$experience_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $experience_id));
		if ($experience_details->num_rows() > 0) {
			$price = $experience_details->row()->price;
			$currency = $experience_details->row()->currency;
		}
		$checkDatesExist = $this->experience_model->ExecuteQuery("select id from " . EXPERIENCE_DATES . " where  ((from_date BETWEEN '" . $from_date . "' and '" . $to_date . "') or (to_date BETWEEN '" . $from_date . "' and '" . $to_date . "')) and experience_id='" . $experience_id . "'");
		//0-active;//1-active
		if ($checkDatesExist->num_rows() > 0) {
			$message = array('case' => '3');
		} else {
			$dataArr = array(
				'experience_id' => $experience_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'price' => $price,
				'currency' => $currency,
				'created_at' => date('Y-m-d H:i:s'),
				'status' => '0'
			);
			$this->db->insert(EXPERIENCE_DATES, $dataArr);
			$insert_id = $this->db->insert_id();
			//$this->db->insert(EXPERIENCE_TIMING, array('exp_dates_id' => $insert_id,'experience_id'=> $experience_id));
			$message = array('case' => '1', 'date_id' => $insert_id);
		}
		echo json_encode($message);
	}

	public function get_timesheets_for_edit()
	{
		if ($this->checkLogin('A') != '') {
			$id = $this->input->post('id');
			$condition = array('id' => $id);
			$res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
			$data = $res_data->result();
			//echo $this->db->last_query();
			//print_r($data);
			$str = '<tr id="grand_child_edit_' . $id . '" class="grand_hild_edit_' . $id . '">';
			foreach ($data as $time) {
				$str .= '<td colspan="4">';
				$str .= '<form id="time_sheet_' . $time->id . '" name="time_sheet_' . $time->id . '" class="form_container left_label listingInfo" accepet-charset="UTF-8">';
				$str .= '<input type="hidden" name="id" value="' . $time->id . '">';
				$str .= '<input type="hidden" id="experience_id_' . $time->id . '" name="experience_id" value="' . $time->experience_id . '">';
				$str .= '<div class="square_box" id="timesheet_' . $time->id . '">';
				$str .= '<div class="error_msg" id="edit_form_error_msg_' . $time->id . '"></div>';
				$str .= '<p>Date <span class="req"><small>*</small></span>  <input type="text" class="dev_multi_schedule_date input_class" onclick="setDatepickerHere()" id="schedule_date_' . $time->id . '" name="schedule_date" value="' . $time->schedule_date . '" style="width:40%;"></p>';
				$str .= '<p>Time <span class="req"><small>*</small></span> <input type="text" class="dev_time input_class" name="start_time" value="' . $time->start_time . '" style="width:40%;" onkeypress="return return_false_fun(event)" onchange="assign_to_time_hour_edit(' . $time->id . ',' . $time->exp_dates_id . ');" >&nbsp;-&nbsp;&nbsp;&nbsp;<input class="dev_time input_class" name="end_time" type="text" value="' . $time->end_time . '" style="width:40%;" onkeypress="return return_false_fun(event)"></p>';

				$str .= '<p>Title <span class="req"><small>*</small></span> <input name="title" onkeydown="word_count(this)" id="title_' . $time->id . '" type="text" value="' . $time->title . '" style="width:100%;" class="input_class"><span class="small_label"><span id="title_' . $time->id . '_char_count">';
				$str .= '</span> </span></p>';
				

				$str .= '<p>Description <span class="req"><small>*</small></span><textarea onkeydown="description_count(this)" name="description" id="description_' . $time->id . '">' . $time->description . '</textarea> <span class="small_label"><span id="description_' . $time->id . '_char_count">';
				$str .= '</span> </span></p>';

                     $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){

             //   foreach(language_dynamic_enable("title", "") as $dynlang){  

                $str .= '<p>Title in '.$data->name.'<span class="req"><small>*</small></span> <input name="title_'.$data->lang_code.'" onkeydown="word_count(this)" id="title_'.$data->lang_code.'_' . $time->id . '" type="text" value="' . $time->{'title_'.$data->lang_code} . '" style="width:100%;" class="input_class"><span class="small_label"><span id="title_' . $time->id . '_char_count">';
                $str .= '</span> </span></p>';

               // }

				//foreach(language_dynamic_enable("description", "") as $dynlang){  
				$str .= '<p>Description in '.$data->name.'<span class="req"><small>*</small></span><textarea onkeydown="description_count(this)" name="description_'.$data->lang_code.'" id="description_'.$data->lang_code.'_'. $time->id . '">' . $time->{'description_'.$data->lang_code} . '</textarea> <span class="small_label"><span id="description_' . $time->id . '_char_count">';
				$str .= '</span> </span></p>';
				}
            }

				$str .= '<p class="text-right"><button class="btn btn-success btn-sm" id="update_time_sheet_' . $time->id . '" type="button" onclick="update_time_sheet(' . $time->id . ',' . $time->exp_dates_id . ')">Update</button>&nbsp;&nbsp;<button class="btn btn-default btn-sm" id="reset_time_sheet_' . $time->id . '" type="button" >Reset</button>&nbsp;&nbsp;<button class="btn btn-default btn-sm" id="reset_time_sheet_' . $time->id . '" type="reset" onclick="cancel_time_sheet_grand_child(' . $time->id . ')">Cancel</button></p>';
				$str .= '</div>';
				$str .= '</form>';
				$str .= '</td>';
			}
			$str .= '</tr>';
			echo $str;
		} else {
			redirect('admin');
		}
	}

	/* new-add and edit experience ends */
	/* update experienec starts */
	public function UpdateExperience()
	{
		/*image upload end */
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$product_data = array();
			$facility_list = array();
			$dataArr = array();
			$product_name = $this->input->post('product_title');
			$product_id = $this->input->post('prdiii');
			$currency = $this->input->post('currency');
			if ($product_name == '') {
				$this->setErrorMessage('error', 'Experience title required');
				echo "<script>window.history.go(-1)</script>";
				exit();
			}
			$price = $this->input->post('price');
			// convert admin currncy to product currency
			if ($this->data['admin_currency_code'] != $currency)
				$price = convertCurrency($this->data['admin_currency_code'], $currency, $price);
			else
				$price = $price;
			if ($price == '') {
				$this->setErrorMessage('error', 'Price required');
				echo "<script>window.history.go(-1)</script>";
				exit();
			} else if ($price <= 0) {
				$this->setErrorMessage('error', 'Price must be greater than zero');
				echo "<script>window.history.go(-1)</script>";
				exit();
			}
			if ($product_id == '') {
				$old_product_details = array();
				$condition = array('experience_title' => $product_name);
			} else {
				$old_product_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
				$condition = array('experience_title' => $product_name, 'experience_id !=' => $product_id);
			}
			$address_detail = array(
				'address' => $this->input->post('address'),
				'country' => $this->input->post('country'),
				'state' => $this->input->post('state'),
				'city' => $this->input->post('city'),
				'street' => $this->input->post('street'),
				'zip' => $this->input->post('post_code'),
				'lat' => $this->input->post('latitude'),
				'lang' => $this->input->post('longitude'),
				'experience_id' => $this->input->post('prdiii')
			);
			$address_check = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $product_id));
			if ($address_check->num_rows() != 0) {
				$this->experience_model->update_details(EXPERIENCE_ADDR, $address_detail, array('experience_id' => $product_id));
			} else {
				$this->experience_model->simple_insert(EXPERIENCE_ADDR, $address_detail);
			}
			$upadte_text = array(
				"experience_description" => $this->input->post("experience_description"),
				"short_description" => $this->input->post("short_description"),
				"location_description" => $this->input->post('location_description'),
				"meta_title" => $this->input->post('meta_title'),
				"meta_keyword" => $this->input->post('meta_keyword'),
				"meta_description" => $this->input->post('meta_description'),
				"group_size" => $this->input->post('group_size'),
				"guest_requirement" => $this->input->post('guest_requirement'),
				"cancel_policy" => $this->input->post('cancellation_policy'),
			);
			$this->experience_model->update_details(EXPERIENCE, $upadte_text, array("experience_id" => $product_id));
			$id = $this->input->post('prdiii');
			$price_range = '';
			$ImageName = '';
			$datestring = "%Y-%m-%d %h:%i:%s";
			$time = time();
			if ($this->data['admin_currency_code'] != $currency) {
				$security_deposit = convertCurrency($this->data['admin_currency_code'], $currency, $this->input->post('security_deposit'));
			} else {
				$security_deposit = $this->input->post('security_deposit');
			}
			if ($product_id == '') {
				$inputArr = array(
					'user_id' => $this->input->post('user_id'),
					'cancel_policy' => $this->input->post('cancellation_policy'),
					'security_deposit' => $security_deposit,
				);
			} else {
				$inputArr = array(
					'user_id' => $this->input->post('user_id'),
					'cancel_policy' => $this->input->post('cancellation_policy'),
					'security_deposit' => $security_deposit,
				);
			}
			$condition = array('experience_id' => $product_id);
			$inputArr1 = array('group' => 'Seller', 'is_experienced' => '1');
			$condition1 = array('id' => $this->input->post('user_id'));
			$this->experience_model->update_details(EXPERIENCE, $inputArr, $condition);
			$this->experience_model->update_details(USERS, $inputArr1, $condition1);
			//echo $this->db->last_query();
			//$this->setErrorMessage('success','Host added successfully');
			$condition1 = array('experience_id' => $product_id);
			$inputArr1 = array(
				'experience_id' => $product_id,
				'country' => $this->input->post('country'),
				'state' => $this->input->post('state'),
				'city' => $this->input->post('city'),
				'zip' => $this->input->post('post_code'),
				'street' => $this->input->post('apt'),
				'address' => $this->input->post('address'),
				'lat' => $this->input->post('latitude'),
				'lang' => $this->input->post('longitude')
			);
			$this->product_model->update_details(EXPERIENCE_ADDR, $inputArr1, $condition1);
			redirect('admin/experience/experienceList');
		}
	}
	/* update experience ends */
	/* update experience tab by tab in admin panel */
	//General info update
	public function savetab1()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			//print_r($_POST);exit;
			$user_id = $this->input->post('user_id');
			$pro_id = $this->input->post('pro_id');
			$price = $this->input->post('price');
			$security_deposit = $this->input->post('security_deposit');
			$currency = $this->input->post('currency');
			$type_id = $this->input->post('type_id');
			$date_count = $this->input->post('date_count');
			$experience_title = $this->input->post('experience_title');
			//print_r($_POST);exit;
			//currency conversion
			/*
			if($this->data['admin_currency_code']!=$currency){
				$price = convertCurrency($this->data['admin_currency_code'],$currency,$this->input->post('price'));
			}else{
				$price = $this->input->post('price') ;
			}

			if($this->data['admin_currency_code']!=$currency){
				$security_deposit = convertCurrency($this->data['admin_currency_code'],$currency,$this->input->post('security_deposit'));
			}else{
				$security_deposit = $this->input->post('security_deposit') ;
			}
			*/
			$cancel_policy = $this->input->post('cancellation_policy');
			$status = $this->input->post('status');
			//$this->data['getGrouoName'] = $this->experience_model->get_all_details(USERS,array('id'=>$pro_id));
			//$dataArr = array('user_id' => $user_id,'type_id'=> $type_id,'price' => $price,'currency'=>$currency, 'security_deposit'=>$security_deposit,'cancel_policy'=>$cancellation_policy,'status'=>$status);
			//$dataArr = array('user_id' => $user_id,'type_id'=> $type_id,'price' => $price,'currency'=>$currency,'date_count'=> $date_count, 'security_deposit'=>$security_deposit,'cancel_policy'=>$cancellation_policy,'status'=>$status);
			$dataArr = array('user_id' => $user_id, 'type_id' => $type_id,
				'experience_title' => $experience_title,
				'price' => $price, 'currency' => $currency,
				'security_deposit' => $security_deposit,
				'cancel_policy' => $cancellation_policy,
				'status' => $status, 'date_count' => $date_count
			);
			$dataArr1 = array('group' => 'Seller', 'is_experienced' => '1');
			$condtion1 = array('id' => $user_id);
			$this->db->where('experience_id', $pro_id)->update(EXPERIENCE, $dataArr);
			//echo $this->db->last_query();
			$this->experience_model->update_details(USERS, $dataArr1, $condtion1); // for Creating Host
			//print_r($this->db->last_query());
			$returnArr['resultval'] = 'Updated';
			echo json_encode($returnArr);
		}
	}
	//General info update ends
	//location
	public function savetab4()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			if ($this->input->post('pro_id') != '') {
				$pro_id = $this->input->post('pro_id');
			} else {
				$pro_id = $this->input->post('edit_pro_id');
			}
			$location = $this->input->post('location');
			$country = $this->input->post('country');
			$state = $this->input->post('state');
			$city = $this->input->post('city');
			$apt = $this->input->post('apt');
			$post_code = $this->input->post('post_code');
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			if ($latitude == null || $latitude == '') {
				$latitude = '0';
			}
			if ($longitude == null || $longitude == '') {
				$longitude = '0';
			}
			$dataArr = array('address' => $location, 'street' => $apt, 'city' => $city, 'state' => $state, 'country' => $country, 'lang' => $longitude, 'lat' => $latitude, 'zip' => $post_code);
			//$dataArr1 = array('country' => $country, 'state'=>$state, 'city'=>$city, 'zip'=>$post_code, 'address' => $location, 'latitude'=>$latitude, 'longitude'=>$longitude);
			$product_id = array('experience_id' => $pro_id);
			$data = array_merge($dataArr, $product_id);
			$check = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $pro_id));
			if ($check->num_rows() > 0) {
				$this->experience_model->update_details(EXPERIENCE_ADDR, $dataArr, array('experience_id' => $pro_id));
			} else {
				$this->experience_model->simple_insert(EXPERIENCE_ADDR, $data);
			}
			//$this->db->where('experience_id',$pro_id)->update(EXPERIENCE_ADDR,$dataArr);
			//echo $this->db->last_query();
			$this->db->where('experience_id', $pro_id)->update(EXPERIENCE, array('location' => $location));
			$returnArr['resultval'] = 'Updated';
			echo json_encode($returnArr);
		}
	}

	//group and guest details
	public function savetab5()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			if ($this->input->post('pro_id') != '') {
				$pro_id = $this->input->post('pro_id');
			} else {
				$pro_id = $this->input->post('edit_pro_id');
			}
			$experience_description = $this->input->post('experience_description');
			$short_description = $this->input->post('short_description');
			$location_description = $this->input->post('location_description');
			$dataArr = array('experience_description' => $experience_description, 'short_description' => $short_description, 'location_description' => $location_description);
			$this->db->where('experience_id', $pro_id)->update(EXPERIENCE, $dataArr);
			$returnArr['resultval'] = 'Updated';
			echo json_encode($returnArr);
		}
	}

	//group and guest details
	public function savetab6()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			if ($this->input->post('pro_id') != '') {
				$pro_id = $this->input->post('pro_id');
			} else {
				$pro_id = $this->input->post('edit_pro_id');
			}
			$group_size = $this->input->post('space');
			$guest_requirement = $this->input->post('guest_requirement');
			$dataArr = array('group_size' => $group_size, 'guest_requirement' => $guest_requirement);
			$this->db->where('experience_id', $pro_id)->update(EXPERIENCE, $dataArr);
			$returnArr['resultval'] = 'Updated';
			echo json_encode($returnArr);
		}
	}

	/* update experience tab by tab in admin panel */
	//delete single date
	public function delete_date($date_id, $expId)
	{
		//delete experience date
		$this->db->where('id', $date_id);
		$this->db->delete(EXPERIENCE_DATES);
		// delete time schedule
		$this->db->where('exp_dates_id', $date_id);
		$this->db->delete(EXPERIENCE_TIMING);
		redirect('admin/experience/add_experience_form_new/' . $expId . "#timing_tab");
	}

	/* get timing of perticulae date */
	public function get_timing()
	{
		$experience_id = $this->input->post('experience_id');
		$date_id = $this->input->post('date_id');
		$i = 0;
		//echo $experience_id;
		$sel_timing = "select * from " . EXPERIENCE_TIMING . " where exp_dates_id='" . $date_id . "' and experience_id='" . $experience_id . "'";
		$sel_res = $this->experience_model->ExecuteQuery($sel_timing);
		//echo $sel_res->num_rows();
		if ($sel_res->num_rows() > 0) {
			foreach ($sel_res->result() as $timing) {
				echo '
					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="user_id">Schedule Date<span class="req">*</span></label>
								<div class="form_input">
									<input type="text" class="dev_multi_schedule_date large" name="schedule_date[]"  value="' . $timing->schedule_date . '" onclick="setDatepickerHere()" onkeypress="return isNumber(event)" required/>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="user_id">Start Time<span class="req">*</span></label>
								<div class="form_input">
									<input type="text" class="dev_time large" name="start_time[]"  value="' . $timing->start_time . '" onkeypress="return isNumber(event)" required/>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="user_id">End Time <span class="req">*</span></label>
								<div class="form_input">
									<input type="text" class="dev_time large"  name="end_time[]" value="' . $timing->end_time . '" onkeypress="return isNumber(event)" required />				
								</div>
							</div>
						</li>
						<li>	

							<div class="form_grid_12">
								<label class="field_title" for="user_id">Title <span class="req">*</span></label>
								<div class="form_input">
									<input type="text" class=" large" name="schedule_title[]"  value="' . $timing->title . '" required />	
								</div>
							</div>
						</li>
						<li>	
							<div class="form_grid_12">
								<label class="field_title" for="user_id">Description <span class="req">*</span></label>
								<div class="form_input">
									<textarea rows="8" style="width: 370px; height: 100px; z-index: auto; position: relative; line-height: 13px; font-size: 13px; transition: none; background: transparent !important;" class="large tipTop valid" name="schedule_description[]" required >' . $timing->description . '</textarea>
								</div>
							</div>
						</li>
						<li class="exp-button">

							<button type="button" class="btn_small" id="add_timing_btn" onclick="delete_timing_row(' . $timing->id . ')" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Delete</button>
						</li>
					</ul>

				 ';
				$i++;
			}
		}
		if ($sel_res->num_rows() == 0) {
			$i = 1;
		}
		echo '<li><div class="exp-button"><button type="button" class="btn_small" id="add_timing_btn_' . $i . '" onclick="add_timing_row(' . $i . ')" ><i class="fa fa-plus-circle" aria-hidden="true"></i>Add new Timing</button></div></li>';
	}

	/* add new row for schadule timing  */
	public function updateDates()
	{
		$date_id = $this->input->post('date_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$date_count = $this->input->post('date_count');
		$experience_id = $this->input->post('experience_id');
		$price = $this->input->post('price');
		$currency = $this->input->post('currency');
		$experience_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $experience_id));
		if ($experience_details->num_rows() > 0) {
			$price = $experience_details->row()->price;
			$currency = $experience_details->row()->currency;
		}
		$checkDatesExist = $this->experience_model->ExecuteQuery("select id from " . EXPERIENCE_DATES . " where  ((from_date BETWEEN '" . $from_date . "' and '" . $to_date . "') or (to_date BETWEEN '" . $from_date . "' and '" . $to_date . "')) and experience_id='" . $experience_id . "' and status='1' and id!='$date_id' ");
		if ($checkDatesExist->num_rows() > 0) {
			$message = array('case' => '3');
		} else {
			$dataArr = array(
				'experience_id' => $experience_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'price' => $price,
				'currency' => $currency,
				'created_at' => date('Y-m-d H:i:s'),
				'status' => '1'
			);
			$this->db->where('id', $date_id);
			$this->db->update(EXPERIENCE_DATES, $dataArr);
			$message = array('case' => '1', 'date_id' => $date_id);
		}
		echo json_encode($message);
	}

	/* delete kit */
	public function delete_kit_package()
	{
		//exit();
		$id = $this->uri->segment(4);
		$product_id = $this->uri->segment(5);
		$this->setErrorMessage('success', 'Item is deleted successfully');
		$this->db->where('id', $id)->delete(EXPERIENCE_GUIDE_PROVIDES);
		redirect('admin/experience/add_experience_form_new/' . $product_id . '#what_you_will_provide_tab');
	}
	/* delete kit ends */
	/*  Delete experience image starts */
	public function deleteProductImage()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$prdID = $this->input->post('prdID');
			$photo_details = $this->db->select('*')->from(EXPERIENCE_PHOTOS)->where('id', $prdID)->get();
			foreach ($photo_details->result() as $image_name) {
				$gambar = $image_name->product_image;
				unlink("images/experience/" . $gambar);
			}
			/*Image Unlink*/
			$this->product_model->commonDelete(EXPERIENCE_PHOTOS, array('id' => $prdID));
			$returnArr['resultval'] = $prdID;
			echo json_encode($returnArr);
		}
	}
	/* Delete experience image ends */
	/* Image adding popup starts */
	public function dragimageuploadinsert()
	{
		$val = $this->uri->segment(4, 0);
		$this->data['prod_id'] = $val;
		$this->load->view('admin/experience/dragndrop', $this->data);
		//$this->load->view('site/product/photos_listing');
	}

	/** image upload */
	public function InsertProductImage1($prd_id)
	{
		$prd_id = $this->input->post('prdiii');
		if ($this->config->item('s3_bucket_name') != '' && $this->config->item('s3_access_key') != '' && $this->config->item('s3_secret_key') != '') $aws = 'Yes'; else $aws = 'No';
		if ($aws == 'Yes') {
			$totalCount = count($_FILES['files']['name']);
			$nameArr = $_FILES['files']['name'];
			$sizeArr = $_FILES['files']['size'];
			$tmpArr = $_FILES['files']['tmp_name'];
			$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
			for ($i = 0; $i < $totalCount; $i++) {
				$name = $nameArr[$i];
				$size = $sizeArr[$i];
				$tmp = $tmpArr[$i];
				$ext = $this->getExtension($name);
				if (strlen($name) > 0) {
					if (in_array($ext, $valid_formats)) {
						$s3_bucket_name = $this->config->item('s3_bucket_name');
						$s3_access_key = $this->config->item('s3_access_key');
						$s3_secret_key = $this->config->item('s3_secret_key');
						include('amazon/s3_config.php');
						//Rename image name.
						$actual_image_name = time() . "." . $ext;
						if ($s3->putObjectFile($tmp, $bucket, $actual_image_name, S3::ACL_PUBLIC_READ)) {
							$s3file = 'http://' . $bucket . '.s3.amazonaws.com/' . $actual_image_name;
							mysql_query("INSERT INTO " . EXPERIENCE_PHOTOS . " (product_image,product_id) VALUES('$s3file','$prd_id')");
							$filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $s3file);
							$this->experience_model->simple_insert(EXPERIENCE_PHOTOS, $filePRoductUploadData);
						}
					}
				}
			}
			//redirect('admin/experience/add_experience_form/'.$prd_id.'/image');
			redirect('admin/experience/add_experience_form_new/' . $prd_id . '#photos_tab');
		} else {
			$uploaddir = "images/experience/";    //a directory inside
			$uploaddir_resize = "images/experience/resize/";
			foreach ($_FILES['files']['name'] as $name => $value) {
				$filename = stripslashes($_FILES['files']['name'][$name]);
				$size = filesize($_FILES['files']['tmp_name'][$name]);
				$width_height = getimagesize($_FILES['files']['tmp_name'][$name]);
				$image_name = time() . $filename;
				$newname = $uploaddir . $image_name;
				if (move_uploaded_file($_FILES['files']['tmp_name'][$name], $newname)) {
					/*compress and Resize*/
					$source_photo = 'images/experience/' . $image_name . '';
					$dest_photo = $newname;
					$this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
					$option1 = $this->getImageShape(360, 580, $source_photo);
					$resizeObj1 = new Resizeimage($source_photo);
					$resizeObj1->resizeImage(360, 580, $option1);
					$resizeObj1->saveImage($uploaddir_resize . $image_name, 100);
					/*compress and Resize*/
					$time = time();
					$timeImg = time();
					@copy($filename, './server/php/experience/mobile/' . $timeImg . $filename);
					$target_file = $uploaddir . $image_name;
					$imageName = $timeImg . $filename;
					$option = $this->getImageShape(500, 350, $target_file);
					$resizeObj = new Resizeimage($target_file);
					$resizeObj->resizeImage(500, 350, $option);
					$resizeObj->saveImage($uploaddir . 'mobile/' . $imageName, 100);
					$this->ImageCompress($uploaddir . 'mobile/' . $imageName);
					@copy($uploaddir . 'mobile/' . $imageName, $uploaddir . 'mobile/' . $imageName);
					$filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $image_name, 'mproduct_image' => $imageName);
					$this->experience_model->simple_insert(EXPERIENCE_PHOTOS, $filePRoductUploadData);
				}
			}
			//redirect('admin/experience/add_experience_form/'.$prd_id.'/image');
			redirect('admin/experience/add_experience_form_new/' . $prd_id . '#photos_tab');
		}
	}

	public function getExtension($str)
	{
		$i = strrpos($str, ".");
		if (!$i) {
			return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str, $i + 1, $l);
		return $ext;
	}

	/* Image adding  popup ends */
	/*  View Experience starts */
	public function view_experience()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'View Experience';
			$product_id = $this->uri->segment(4, 0);
			$condition = array('id' => $product_id);
			//$this->data['product_details'] = $this->experience_model->get_all_details(PRODUCT,$condition);
			$this->data['product_details'] = $this->experience_model->view_experience_details("where p.experience_id='$product_id' and p.status!='2' group by p.experience_id");
			//print_r($this->data['product_details']->row() );exit;
			$condition = array('experience_id' => $product_id);
			$this->data['date_details'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
			if ($this->data['product_details']->num_rows() == 1) {
				$this->data['catList'] = $this->experience_model->get_cat_list($this->data['product_details']->row()->type_id);
				$this->data['prd_adrs'] = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $product_id));
				$this->data['RentalCountry'] = $this->experience_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->country), array('field' => 'name', 'type' => 'asc'));
				$this->data['RentalState'] = $this->experience_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->state));
				$this->data['RentalCity'] = $this->experience_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->city));
				$this->data['listNameCnt'] = $this->experience_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
				$this->data['RentalState'] = $this->experience_model->get_all_details(STATE_TAX, array('status' => 'Active'));
				$this->data['RentalCity'] = $this->experience_model->get_all_details(CITY, array('status' => 'Active'));
				$this->data['userdetails'] = $this->experience_model->get_selected_fields_records('id,firstname,lastname', USERS, 'where status="Active" ');
				$this->data['imgDetail'] = $this->experience_model->get_images($product_id);
				$this->load->library('googlemaps');
				$config['center'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
				$config['zoom'] = 'auto';
				$this->googlemaps->initialize($config);
				$marker = array();
				$marker['position'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
				$marker['draggable'] = true;
				$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
				$this->googlemaps->add_marker($marker);
				$this->data['map'] = $this->googlemaps->create_map();
				//languages selected
				if ($this->data['product_details']->row()->language_list != '') {
					$languages_known_query = "SELECT * FROM " . LANGUAGES_KNOWN . " where language_code in (" . $this->data['product_details']->row()->language_list . ")";
					$this->data['languages_list'] = $this->experience_model->ExecuteQuery($languages_known_query);
					//print_r($this->data['languages_list']->num_rows());
				} else {
					$this->data['languages_list'] = '';
				}
				//Guide provides
				$condition = array('experience_id' => $product_id);
				$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
				$this->data["listDetail"] = $this->data["product_details"];
				$this->load->view('admin/experience/view_experience', $this->data);
			} else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * Function to change individual experience status
	 */
	public function change_experience_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$product_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? '0' : '1';
			$newdata = array('status' => $status);
			$condition = array('experience_id' => $product_id);
			$this->experience_model->update_details(EXPERIENCE, $newdata, $condition);
			//NO MAIL FUNCTION
			$this->setErrorMessage('success', 'Experience Status Changed Successfully');
			redirect('admin/experience/experienceList');
		}
	}

	/* bulk status change starts */
	public function change_experience_status_global()
	{
		if ($this->input->post('checkboxID') != '') {
			if ($this->input->post('checkboxID') == '0') {
				redirect('admin/experience/add_experience_form/0');
			} else {
				redirect('admin/experience/add_experience_form/' . $this->input->post('checkboxID'));
			}
		} else {
           // print_r($_POST);exit();
			//if (count($this->input->post('checkbox_id')) > 0 && $this->input->post('statusMode') != '') {
				$this->experience_model->activeInactiveExperience(EXPERIENCE, 'experience_id');
				//echo $this->db->last_query();
				//exit;
				if (strtolower($this->input->post('statusMode')) == 'delete') {
					$this->setErrorMessage('success', 'Records deleted successfully');
				} else {
					$this->setErrorMessage('success', 'Records status changed successfully');
				}
				redirect('admin/experience/experienceList');
			//}
		}
	}

	/* bulk status change ends */
	/*  experience delete starts  */
	public function delete_experience()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$product_id = $this->uri->segment(4, 0);
			$condition = array('id' => $product_id);
			$old_product_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
			/*

			$this->experience_model->commonDelete(EXPERIENCE,$condition);
			$this->experience_model->commonDelete(EXPERIENCE_PHOTOS,array('product_id' => $product_id));
			$this->experience_model->commonDelete(EXPERIENCE_ADDR,array('experience_id' => $product_id));

			$this->experience_model->commonDelete(EXPERIENCE_DATES,array('experience_id' => $product_id));
			$this->experience_model->commonDelete(EXPERIENCE_TIMING,array('experience_id' => $product_id));
			$this->experience_model->commonDelete(EXPERIENCE_GUIDE_PROVIDES,array('experience_id' => $product_id));
			$this->experience_model->commonDelete(EXPERIENCE_ADDR,array('product_id' => $product_id));
			*/
			//to avoid invalid data display in previous orders page,delete query is avoided instead of that 'experience status' of experience  only changes  ;
			$newdata = array('status' => '2');
			$condition = array('experience_id' => $product_id);
			$this->experience_model->update_details(EXPERIENCE, $newdata, $condition);
			/*Image Unlink*/
			// $photo_details = $this->db->select('*')->from(EXPERIENCE_PHOTOS)->where('product_id',$product_id)->get();
			// foreach($photo_details->result() as $image_name){
			// 	$gambar= $image_name->product_image;
			// 	unlink("server/php/experience/".$gambar);
			// 	unlink("server/php/experience/resize/".$gambar);
			// 	unlink("server/php/experience/mobile/".$gambar);
			// }
			/*Image Unlink*/
			$this->experience_model->update_details(EXPERIENCE_PHOTOS, $newdata, array('status' => 'Delete'));
			$this->experience_model->update_details(EXPERIENCE_ADDR, $newdata, $condition);
			$this->experience_model->update_details(EXPERIENCE_DATES, $newdata, $condition);
			$this->experience_model->update_details(EXPERIENCE_TIMING, $newdata, $condition);
			$this->experience_model->update_details(EXPERIENCE_GUIDE_PROVIDES, $newdata, $condition);
			//$this->experience_model->commonDelete(PRODUCT_BOOKING,array('product_id' => $product_id));
			//$this->experience_model->commonDelete(SCHEDULE,array('id' => $product_id));
			$this->setErrorMessage('success', 'Experience deleted successfully');
			redirect('admin/experience/experienceList');
		}
	}

	/* Experience delete ends */
	/* featured experience starts */
	public function ChangeFeaturedExperience()
	{
		$ingIDD = $this->input->post('imgId');
		$FtrId = $this->input->post('FtrId');
		$currentPage = $this->input->post('cpage');
		$dataArr = array('featured' => $FtrId);
		$condition = array('experience_id' => $ingIDD);
		$this->experience_model->update_details(EXPERIENCE, $dataArr, $condition);
		echo $result = ($FtrId == 1) ? 'Featured' : 'Unfeatured';
		//echo $result=$FtrId;
	}

	/**
	 *
	 *function to update featured experienceType starts
	 */
	public function ChangeFeaturedExperienceType()
	{
		$ingIDD = $this->input->post('imgId');
		$FtrId = $this->input->post('FtrId');
		$currentPage = $this->input->post('cpage');
		$dataArr = array('featured' => $FtrId);
		$condition = array('id' => $ingIDD);
		$this->experience_model->update_details(EXPERIENCE_TYPE, $dataArr, $condition);
		echo $result = ($FtrId == 1) ? 'Featured' : 'Unfeatured';
	}

	public function customerExcelExport()
	{
		$sortArr = array('field' => 'id', 'type' => 'desc');
		$condition = array();
		$UserDetails = $this->experience_model->view_experience_details('where u.status="Active" or p.user_id=0 group by p.experience_id order by p.added_date desc');
		$data['getCustomerDetails'] = $UserDetails->result_array();
		//print_r($data['getCustomerDetails']);
		foreach ($data['getCustomerDetails'] as $row) {
			$expId = $row['experience_id'];
			$sel_price = "select min(price) as min_price from " . EXPERIENCE_DATES . " where experience_id ='" . $row['experience_id'] . "' and status='1'";
			$priceData = $this->experience_model->ExecuteQuery($sel_price);
			if ($priceData->num_rows() > 0)
				$data['price'][$expId] = $priceData->row()->min_price;
			else
				$data['price'][$expId] = 0;
		}
		// print_r($data['price']);
		$this->load->view('admin/experience/customerExportExcel', $data);
	}

	/* excel export starts */
	/* experience add & edit  ajax function */
	public function OtherDetailInsert()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$title = $this->input->post('val');
			$catID = $this->input->post('catID');
			$chk = $this->input->post('chk');
			$condition = array('experience_id' => $catID);
			/*no currency conversion needed ; admin will process with same experience currency rather than admin currency for this add/edit experience only */
			/*
			if($chk=='price')
			{
				$productData = $this->product_model->get_all_details(EXPERIENCE,$condition)->row();
				if($productData->currency != $this->data['admin_currency_code'])
				{
					$title = convertCurrency($this->data['admin_currency_code'],$productData->currency,$title);
				}
			}	*/
			$dataArr = array($chk => $title);
			$excludeArr = array('title', 'catID', 'chk');
			if ($chk == 'price') {
				$this->product_model->update_details(EXPERIENCE, array($chk => $title), array('experience_id' => $catID));
			} else {
				$this->product_model->update_details(EXPERIENCE, array($chk => $title), array('experience_id' => $catID));
			}
			$returnArr['resultval'] = $catID . "title" . $chk;
			echo json_encode($returnArr);
		}
	}

	public function saveDetailPage()
	{
		$catID = $this->input->post('catID');
		$title = $this->input->post('title');
		$chk = $this->input->post('chk');
		$this->product_model->update_details(EXPERIENCE, array($chk => $title), array('experience_id' => $catID));
		$this->setErrorMessage('success', 'Successfully saved!');
	}

	public function saveAdminDetailPage()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$condition = '';
			$catID = $this->input->post('catID');
			if ($catID == 0) {
				$title = $this->input->post('title');
				//$dataArr = array( 'experience_title' => $title);
				$dataArr = array('date_count' => $title);
				$excludeArr = array('title', 'catID', 'chk');
				$this->experience_model->commonInsertUpdate(EXPERIENCE, 'insert', $excludeArr, $dataArr, $condition);
				$returnArr['resultval'] = $insert_id = $this->db->insert_id();
				$inputArr = array('experience_id' => $insert_id);
				$this->experience_model->commonInsertUpdate(EXPERIENCE_ADDR, 'insert', $excludeArr, $inputArr, $condition);
				echo json_encode($returnArr);
			} else {
				/*$returnArr['resultval']=$catID;
				echo json_encode($returnArr);
				*/
				$condition = array('experience_id' => $catID);
				$title = $this->input->post('title');
				$dataArr = array('experience_title' => $title);
				$excludeArr = array('title', 'catID', 'chk');
				$this->experience_model->commonInsertUpdate(EXPERIENCE, 'update', $excludeArr, $dataArr, $condition);
				$returnArr['resultval'] = $catID;
				echo json_encode($returnArr);
			}
		}
	}

	/**To Update Experience Category**/
	public function UpdateExp_Category()
	{
		$typeId = $this->input->post('category_id');
		$expId = $this->input->post('exp_id');
		$booked = array('booking_status' => 'Booked');
		$data = $this->experience_model->get_booked_exp_details($booked, $expId);
		if ($data->num_rows() == 0) {
			$this->experience_model->update_details(EXPERIENCE, array('type_id' => $typeId), array('experience_id' => $expId));
			echo "success";
		} else {
			echo "fail";
		}
	}

	public function UpdateExp_Owner()
	{
		$user_id = $this->input->post('user_id');
		$expId = $this->input->post('exp_id');
		$booked = array('booking_status' => 'Booked');
		$data = $this->experience_model->get_booked_exp_details($booked, $expId);
		if ($data->num_rows() == 0) {
			$this->experience_model->update_details(EXPERIENCE, array('user_id' => $user_id), array('experience_id' => $expId));
			$condition = array('user_id' => $user_id);
			$exp_for_user = $this->experience_model->get_all_details(EXPERIENCE, $condition);
			if ($exp_for_user->num_rows() == 0) {
				$this->experience_model->update_details(USERS, array('is_experienced' => '0'), array('id' => $user_id, 'is_experienced' => '1'));
			} else {
				if ($exp_for_user->num_rows() == 1) {
					$this->experience_model->update_details(USERS, array('is_experienced' => '1'), array('id' => $user_id, 'is_experienced' => '0'));
				}
			}
			echo "success";
		} else {
			echo "fail";
		}
	}



	/* experience add & edit  ajax function ends  */
	/* Experience Ends */
}

/* End of file experience.php */
/* Location: ./application/controllers/admin/experience.php */
