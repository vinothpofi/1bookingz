<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Review extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('review_model');
		if ($this->checkPrivileges('Review',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the review list page
     */
   	public function index()
   	{	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/review/display_review_list');
		}
	}
	
	/**
	 * 
	 * This function loads the review list page
	 */
	public function display_review_list()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Review List';
			$condition = array();
			$this->data['reviewList'] = $this->review_model->get_all_review_details();		
			$this->load->view('admin/review/display_review',$this->data);
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
	public function edit_testimonials_form()
	{
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
	 *This function changes the review status
	 */
	public function change_review_status()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			
		if($status=='Active'){
				$GetReviewDetails=$this->review_model->get_all_details(REVIEW,$condition);
				if($GetReviewDetails->row()->user_id > 0 && $GetReviewDetails->row()->user_id != '')
				{
					$GetUserDetails=$this->review_model->get_all_details(USERS,array('id' => $GetReviewDetails->row()->user_id)); 
					$GetRentalDetails=$this->review_model->get_all_details(PRODUCT,array('id' => $GetReviewDetails->row()->product_id));	
					$hostEmail=$GetUserDetails->row()->email;
					$hostname=$GetUserDetails->row()->firstname;
					$prdName=$GetRentalDetails->row()->product_title;
					$prdId=$GetRentalDetails->row()->id;
			
					/*Mail To Host Start*/
					$newsid='65'; 
					$template_values=$this->review_model->get_newsletter_template_details($newsid);

					if($template_values['sender_name']=='' && $template_values['sender_email']==''){
						$sender_email=$this->data['siteContactMail'];
						$sender_name=$this->data['siteTitle'];
					}else{
						$sender_name=$template_values['sender_name'];
						$sender_email=$template_values['sender_email'];
					} 
                         
		             $email_values = array('mail_type'=>'html',
					       'from_mail_id'=>$sender_email,
							'to_mail_id'=> $hostEmail,
							'subject_message'=>$template_values ['news_subject'],
					
					);  

					$reg = array (
						'propertyname' => $prdName,
						'hostname'	=>$hostname,
						'prd_id'	=>$prdId,
						'base_url'	=> base_url(),
						'logo' => $this->data['logo']
					);

			 		$message = $this->load->view('newsletter/ReviewAcceptedbyAdmin'.$newsid.'.php',$reg,TRUE);
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
					/*Mail To Host End*/
			}
		}
			
			$this->db->reconnect();
			$this->review_model->update_details(REVIEW,$newdata,$condition);
			$this->setErrorMessage('success','Review Status Changed Successfully');
			redirect('admin/review/display_review_list');
		
	}
	}
	
	/**
	 * 
	 * This function loads the review view page
	 */
	public function view_review()
	{
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Review';
			$review_id = $this->uri->segment(4,0);
			$this->data['review_details'] = $this->review_model->get_review_details($review_id);

			if ($this->data['review_details']->num_rows() == 1){
				$this->load->view('admin/review/view_review',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the review record from db
	 */
	public function delete_review()
	{
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
	public function change_review_status_global()
	{
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