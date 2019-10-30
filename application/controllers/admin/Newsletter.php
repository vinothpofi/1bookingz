<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to newsletter management 
 * @author Teamtweaks
 *
 */

class Newsletter extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('newsletter_model');
		if ($this->checkPrivileges('Newsletter',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the subscribers list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->load->view('admin/newsletter/display_subscribers_list',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the subscribers list page
	 */
	public function display_subscribers_list()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Subscribers List';
			$condition = array('news_subscriber'=>'Yes');			
			$this->data['subscribersList'] = $this->newsletter_model->get_users_subscriber_email();
			$this->data['NewsList'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			
			$this->load->view('admin/newsletter/display_subscribers',$this->data);
		}
	}
	
	/**
	 * 
	 * This function change the subscribers status
	 */
	public function change_subscribers_status()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		 {
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'No':'Yes';
			$newdata = array('subscriber' => $status);
			$condition = array('id' => $user_id);
			$this->newsletter_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Subscribers Status Changed Successfully');
			redirect('admin/newsletter/display_subscribers_list');
		}
	}
	

	
	/**
	 * 
	 * This function deletes the subscribers 
	 */	
	public function delete_subscribers()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$user_id = $this->uri->segment(4,0);			
			$newdata = array('subscriber' => 'delete');
			$condition = array('id' => $user_id);
			$this->newsletter_model->update_details(USERS,$newdata,$condition);
			$this->setErrorMessage('success','Subscribers Status Changed Successfully');
			redirect('admin/newsletter/display_subscribers_list');
		}
	}
	
	
	
	
	
	/**
	 * 
	 * This function change the subscribers status, delete the user record
	 */
	public function change_newsletter_status_global(){
	
		if($this->input->post('statusMode')=='SendMail' &&  $this->input->post('mail_contents')!=''){
			if(count($_POST['checkbox_id']) > 0){
					$data =  $_POST['checkbox_id'];
					for ($i=0;$i<count($data);$i++){
						if($data[$i] == 'on'){
							unset($data[$i]);
						}
					}
					//print_r($_POST);exit();
					$SubscribEmail=$this->newsletter_model->send_mail_subcribers($data);
					//echo '<pre>';print_r($SubscribEmail);die;
					
					$condition1 = array('id' => $this->input->post('mail_contents'));
					$NewsTemplate= $this->newsletter_model->get_all_details(NEWSLETTER,$condition1);
					//print_r($NewsTemplate->result());exit;
					$this->newsletter_model->send_mail_subcribers_list($SubscribEmail, $NewsTemplate);
					//echo $this->db->last_query();die;
					$this->setErrorMessage('success'," Send Mail's successfully");
					redirect('admin/newsletter/display_subscribers_list');
			}else{
					$this->setErrorMessage('error'," Email Not Send");
					redirect('admin/newsletter/display_subscribers_list');
			}
		}else if($this->input->post('statusMode')=='SendMailAll'){
					$conditionval = array('subscriber'=>'Yes');
					$SubscribEmail=$this->newsletter_model->get_newsletter_details(USERS,$conditionval);
					//echo '<pre>';print_r($SubscribEmail);die;
					$condition1 = array('id' => $this->input->post('mail_contents'));
					$NewsTemplate= $this->newsletter_model->get_all_details(NEWSLETTER,$condition1);
					$this->newsletter_model->send_mail_subcribers_list($SubscribEmail, $NewsTemplate);
					//echo $this->db->last_query();die;
					$this->setErrorMessage('success'," Send Mail's successfully");
					//echo $this->db->last_query();die;
					redirect('admin/newsletter/display_subscribers_list');
		}else{
			if(count($this->input->post('checkbox_id')) > 0 &&  $this->input->post('statusMode') != ''){

				$this->newsletter_model->newsletter(USERS,'id');
				if (strtolower($this->input->post('statusMode')) == 'delete'){
					$this->setErrorMessage('success','Subscribers records deleted successfully');
				}else {
					$this->setErrorMessage('success','Subscribers records status changed successfully');
				}
				redirect('admin/newsletter/display_subscribers_list');
			}
		}
	}
	/* End of file subscribers*/
	
	
	/**
	 * 
	 * This function loads the newsletter list page
	 */
	public function display_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Email Template List';
			$condition = array('news_subscriber'=>'');
			$this->data['subscribersList'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			$this->load->view('admin/newsletter/display_newsletter',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the email template list page
	 */
	public function display_subscriber_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Subscriber Email Template List';
			$condition = array('news_subscriber'=>'Yes');
			$this->data['subscribersList_template'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			$this->load->view('admin/newsletter/display_subscribers_newsletter',$this->data);
		}
	}

	/**
	 * 
	 * This function loads the add newsletter form
	 */
	public function add_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Add Email Template';
			$this->load->view('admin/newsletter/add_newsletter',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the edit template form
	 */
	public function edit_newsletter_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Edit Email Template';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			if ($this->data['user_details']->num_rows() == 1)
			{
				$this->load->view('admin/newsletter/edit_newsletter',$this->data);
			}
			else
			{
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function insert and edit a template details
	 */
	public function insertEditNewsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else 
		{
			if (!$this->data['demoserverChk'] || $this->checkLogin('A')==1)
			{
				$newsletter_id = $this->input->post('newsletter_id');
				$news_title = $this->input->post('news_title');
				$news_subscriber = $this->input->post('news_subscriber');
				$excludeArr = array("newsletter_id","status","news_descrip");
				$newsletter_status = 'Active';
				$dataArr = array();
				$datestring = "%Y-%m-%d";
				$time = time();

				if ($newsletter_id == '')
				{
					$code = $this->get_rand_str('10');
					$dataArr = array(
						'status' => $newsletter_status,
						'dateAdded'=>mdate($datestring,$time),
						'news_subscriber'=>$news_subscriber
						
						
					);
				}
				
				$news_descripe = str_replace("'.base_url().'", base_url(), $_POST['news_descrip']);
								
				if ($newsletter_id == '')
				{
					$condition = array();					
					$this->newsletter_model->commonInsertUpdate(NEWSLETTER,'insert',$excludeArr,$dataArr,$condition);
					$news_id=$this->newsletter_model->get_last_insert_id();
					$news_content=$this->newsletter_model->get_all_details(NEWSLETTER,array('id'=>$news_id));
					$news_content_new = str_replace("{","'.",addslashes($news_content->row()->news_descrip));
					$news_descripe = str_replace("}",".'",$news_content_new);
					$config = "<?php \$message .= '";
					$config .= "$news_descripe";
					$config .= "';  ?>";
					$file = 'application/views/newsletter/'.$news_title.''.$news_id.'.php';
					
					file_put_contents($file, $config);					
					$this->setErrorMessage('success','Newsletter added successfully');
				}
				else
				{					
					$news_content_new = str_replace("'.","{",$_POST['news_descrip']);
					$news_descripe = str_replace(".'","}",$news_content_new);
					$news_descripe = str_replace("adminnewstemplateArr['","",$news_descripe);
					$news_descripe = str_replace("']","",$news_descripe);

					$dataArr = array(
						'news_descrip' => $news_descripe,
						'news_subscriber'=>$news_subscriber
					);
					
					$condition = array('id' => $newsletter_id);
					$this->newsletter_model->commonInsertUpdate(NEWSLETTER,'update',$excludeArr,$dataArr,$condition);
					$news_content=$this->newsletter_model->get_all_details(NEWSLETTER,array('id'=>$newsletter_id));
					$news_content_new = str_replace("{","<?php echo ",$news_content->row()->news_descrip);
					$news_descripe = str_replace("}","; ?>",$news_content_new);
					
					$config = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>Welcome Message</title>
</head><body>';
					
					$config .= $news_descripe;					
					$config .= '</body></html>';

					$file = 'application/views/newsletter/'.$news_title.''.$newsletter_id.'.php';
					file_put_contents($file, $config);
					$this->setErrorMessage('success','Newsletter updated successfully');
				}
				if($news_subscriber == 'yes'){
					redirect('admin/newsletter/display_subscriber_newsletter');
				}
				else{
					redirect('admin/newsletter/display_newsletter');
				}
			}
			else
			{
				$this->setErrorMessage('error','You are in demo mode. Settings cannot be changed');
				redirect('admin/newsletter/display_newsletter');
			}
		}
	}
	
	/**
	 * 
	 * This function loads the template details view page
	 */
	public function view_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'View Email Template';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			if ($this->data['user_details']->num_rows() == 1)
			{
				$this->load->view('admin/newsletter/view_newsletter',$this->data);
			}
			else 
			{
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function loads the template details view page
	 */
	public function view_subscribers_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else 
		{
			$this->data['heading'] = 'View Email Template';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->newsletter_model->get_all_details(NEWSLETTER,$condition);
			if ($this->data['user_details']->num_rows() == 1)
			{
				$this->load->view('admin/newsletter/view_subscribers_newsletter',$this->data);
			}
			else 
			{
				redirect('admin');
			}
		}
	}
	/**
	 * 
	 * This function delete the subscribers record from db
	 */
	public function delete_newsletter()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			if (!$this->data['demoserverChk'] || $this->checkLogin('A')==1)
			{
				$user_id = $this->uri->segment(4,0);
				$check_email_type = $this->newsletter_model->get_all_details(NEWSLETTER,array('id' => $user_id));
				$condition = array('id' => $user_id,'typeVal' => '1');
				$this->newsletter_model->commonDelete(NEWSLETTER,$condition);
				$this->setErrorMessage('success','Email template deleted successfully');
				if($check_email_type->row()->news_subscriber == 'Yes'){
					unlink("application/views/newsletter/" . $check_email_type->row()->news_title . $user_id .'.php');
					
					redirect('admin/newsletter/display_subscriber_newsletter');
				}
				else{
					redirect('admin/newsletter/display_newsletter');
				}
			}
			else
			{
				$this->setErrorMessage('error','You are in demo mode. Settings cannot be changed');
				redirect('admin/newsletter/display_newsletter');
			}
		}
	}
	
	
	/**
	 *
	 *email by admin to all users or particular user
	 */ 
	public function mass_email()
	{
		if($_POST)
		{
	
			if($this->input->post('mail_to')=='particular')
			{
			$email_list=$this->input->post('email_list');		
			}
			$this->newsletter_model->send_mass_email($email_list);
			$this->setErrorMessage('success','Email has sent successfully');
			redirect('admin/newsletter/mass_email');
		}
		$this->data['heading'] = 'Mass E-Mail Campaigns';
		$this->data['user_emails']=$this->newsletter_model->get_users_email_for_mass_email();
		$this->load->view('admin/newsletter/mass_email',$this->data);
	}

}




