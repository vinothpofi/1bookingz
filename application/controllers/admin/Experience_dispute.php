<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Experience_dispute extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model(array('experience_dispute_model','experience_model'));
		if ($this->checkPrivileges('Review',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
	public function index(){	
	if ($this->checkLogin('A') == ''){
		redirect('admin');
	}else {
		redirect('admin/experience_dispute/display_experience_dispute_list');
	}
	}
	
	/**
	 * 
	 * This function loads the testimonials list page
	 */
	public function display_experience_dispute_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Experience Cancel List';
			$condition = array();
			$this->data['expdispList'] = $this->experience_dispute_model->get_all_exp_dispute_details();	
			// echo "<pre>";
			// print_r($this->data['expdispList']->result());exit;
			$this->load->view('admin/experience_dispute/experience_display_dispute',$this->data);
		}
	}
	public function cancel_booking_payment()
    {
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }
        else
        {
           
            $this->data['heading'] = 'Experience Host Cancellation Payments';
            $condition = array('cancelled','Yes');
            $CustomerDetails = $this->experience_model->get_all_cancelled_users();  
     //        echo "<pre>";  
     // print_r($CustomerDetails->result()); exit;
            //echo $this->db->last_query; exit;
            foreach($CustomerDetails->result() as $customer)
            {
                $customer_id = $customer->Bookingno;
                $cancel[] = $this->experience_model->get_all_commission_tracking($customer_id);    
                //$this->data['paypalData'][$HostEmail] = $customer->paypal_email;                            
            }

           //  echo "<pre>";
           // print_r($cancel);exit();
            $this->data['trackingDetails'] = $cancel;
            // echo "<pre>";
            //  print_r($this->data['trackingDetails']);exit();
            //$this->data['vehicle_type'] = $type;
//echo "string";exit();
            $this->load->view('admin/experience/display_cancel_payment_lists_exp_host',$this->data);
        }
    }
	
	/**
	 * 
	 * This function loads the user view page
	 */
	public function view_exp_dispute(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Experience Cancel';
			$booking_no = $this->uri->segment(4,0);
			$this->data['expdispute_details'] = $this->experience_dispute_model->get_exp_dispute_details($booking_no);
			if ($this->data['expdispute_details']->num_rows() > 0){
				$this->load->view('admin/experience_dispute/view_experience_dispute',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/* malar-10/07/2017 - exp dispute accept starts */

	public function accept_dispute(){
		$disputeId = $this->uri->segment(4);
		$booking_no = $this->uri->segment(5);

		$condition = array('id' => $disputeId);

		$disputeData  = $this->experience_dispute_model->get_all_details('fc_experience_dispute',$condition);
		//print_r($disputeData->row());
		$data  = array('status' =>'Accept');
		
		$this->experience_dispute_model->update_details('fc_experience_dispute',$data,$condition);

		$this->setErrorMessage('success','Dispute accepted successfully');
		redirect('admin/experience_dispute/display_experience_dispute_list');
	}
	/* malar-10/07/2017 - exp dispute accept ends */

	/* malar-10/07/2017 - exp dispute reject starts   */
	function reject_dispute(){
		$disputeId = $this->uri->segment(4);

		$condition = array('id' => $disputeId);

		$data  = array('status' =>'Reject');
		
		$this->experience_dispute_model->update_details('fc_experience_dispute',$data,$condition);


		$this->setErrorMessage('success','Dispute rejected successfully');
		redirect('admin/experience_dispute/display_experience_dispute_list');

	}
	/* malar-10/07/2017 -exp dispute reject ends   */
	
	/*cancel booking list*/
	public function cancel_exp_booking_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Cancel Experience booking list';
			$condition = array();
			$this->data['expdisputecancelbooking'] = $this->experience_dispute_model->get_all_expdispute_cancel_booking();	
			$this->load->view('admin/experience_dispute/exp_display_cancel_booking',$this->data);
		}
	}
	
	public function view_exp_cancel_booking()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Experience Dispute';
			$booking_no = $this->uri->segment(4,0);
			$this->data['expcancel_details'] = $this->experience_dispute_model->get_cancel_dispute_details($booking_no);
			if ($this->data['expcancel_details']->num_rows() > 0){
				$this->load->view('admin/experience_dispute/view_exp_cancel_booking',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/*Accept cancel booking dispute*/
		public function Cancel_Book($disputeId,$booking_no,$cancel_booking_id)
		{
			
			$condition = array('id' => $disputeId,'cancel_status' => $cancel_booking_id);
			
			$data  = array('status' =>'Accept');
			$disputeData  = $this->experience_dispute_model->get_all_details(DISPUTE,$condition);
			
			$this->experience_dispute_model->update_details(DISPUTE,$data,$condition);
			
		
			$this->setErrorMessage('success','Cancel booking accepted successfully');
			redirect('admin/experience_dispute/cancel_exp_booking_list');
			
		}
	function rejectBooking($disputeId,$booking_no,$cancel_booking_id)
	{
			
			$condition = array('id' => $disputeId,'cancel_status' => $cancel_booking_id);

			$data  = array('status' =>'Reject');
			
			$ok = $this->experience_dispute_model->update_details(DISPUTE,$data,$condition);
		

			echo 'success';
			$this->setErrorMessage('success','Cancel booking rejected successfully');
			redirect('admin/experience_dispute/cancel_exp_booking_list');
				
		}
	/* malar-10/07/2017 - dispute accept starts 
	
	 * 
	 * This function change the user status, delete the user record
	 */
	public function change_expdispute_status_global(){
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->experience_dispute_model->activeInactiveCommon(EXPERIENCE_DISPUTE,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Review records deleted successfully');
			}else {
				$this->setErrorMessage('success','Review records status changed successfully');
			}
			redirect('admin/experience_dispute/display_experience_dispute_list');
		}
	}
	
	

	
	
}
/**
/* End of file testimonials.php */
/* Contact: ./application/controllers/admin/testimonials.php */