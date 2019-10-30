<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to cms management 
 * @author Teamtweaks
 *
 */

class Contact_us extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('contact_model');
		if ($this->checkPrivileges('ContactUs',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
	 *
	 * This function loads contact list page
	 */
    public function display_contactus()
    {		
		if ($this->checkLogin ( 'A' ) == '')
		{
			redirect ( 'admin' );
		}
		else
		{
			$this->data ['heading'] = 'Contact List';
			$this->data ['admin_contactus'] = $this->contact_model->get_all_details ( CONTACTUS, array () );
			$this->load->view ( 'admin/contact/display_contactus', $this->data );
		}
	}

	/**
	 *
	 * This function delete contact details
	 */
	public function change_contact_status()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$list_value_id = $this->uri->segment(4);
			$condition = array('id' => $list_value_id);
			$this->contact_model->commonDelete(CONTACTUS,$condition);
			$this->setErrorMessage('success','Deleted successfully');
			redirect('admin/contact_us/display_contactus');
		}
	}

	/**
	 *
	 * This function loads edit replay details page
	 */
	public function replaymail()
	{
		if ($this->checkLogin ( 'A' ) == '')
		{
			redirect ( 'admin' );
		} 
		else
		{
			$id = $this->uri->segment ( 4 );
			$this->data ['heading'] = 'Contact List';
			$this->data ['admin_replay'] = $this->contact_model->get_all_details(CONTACTUS, array('id' => $id) );
			$this->load->view ( 'admin/contact/display_replaymail', $this->data );
		}
	}
		public function replaymail1()
		{
		
			$replayemail = $this->input->post('replayemail');
			$body_message = $this->input->post('your-message');
			
			
		$newsid = '28';
		$template_values = $this->contact_model->get_newsletter_template_details ( $newsid );
		$adminnewstemplateArr = array ('email_title' => $this->config->item ('email_title'),'logo' => $this->data ['logo']
		);
		extract ( $adminnewstemplateArr );
		$subject = 'From: ' . $this->config->item ('email_title') . ' - ' . $template_values ['news_subject'];
		$header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
		include ('./newsletter/registeration' . $newsid . '.php');
		
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item ( 'site_contact_mail' );
			$sender_name = $this->config->item ( 'email_title' );
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		
		
		/*
		$email_values = array (
				'mail_type' => 'html',
				'from_mail_id' => $sender_email,
				'mail_name' => $sender_name,
				'to_mail_id' => $replayemail, 
				'username' => $replayemail,
				'subject_message' => 'Contact us Reply',
				'body_messages' => $body_message
		);
			 //echo stripslashes($email_values['body_messages']);die;
	     $this->contact_model->common_email_send($email_values);
			*/
			/* START */
			$email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'to_mail_id' => $replayemail, 'subject_message' => 'Contact us Reply');
			$reg = array('logo' => $this->data ['logo'], 'body_message' => $body_message);
			//print_r($reg);
			$message = $this->load->view('../../newsletter/contact_us_reply.php', $reg, TRUE);
			//echo $message; exit;
			$this->load->library('email');
			$this->email->set_mailtype($email_values['mail_type']);
			$this->email->from($email_values['from_mail_id'], $sender_name);
			$this->email->to($email_values['to_mail_id']);
			$this->email->subject($email_values['subject_message']);
			$this->email->message($message);
			try {
				$this->email->send();
				if ($this->lang->line('Your message sent successfully.') != '') {
					$message = stripslashes($this->lang->line('Your message sent successfully.'));
				} else {
					$message = "Your message sent successfully.";
				}
				$this->setErrorMessage('success', $message);
			} catch (Exception $e) {
				echo $e->getMessage();
			}
			/* END */
			$this->setErrorMessage ( 'success', 'Your message sent successfully.' );
			redirect('admin/contact_us/display_contactus');
			
		}
		
		/**
		 *
		 * This function change ststus and delete contact details
		 */
		public function change_contact_status_global() 
		{		
			if (count ( $_POST ['checkbox_id'] ) > 0 && $_POST ['statusMode'] != '')
			{
				$this->contact_model->activeInactiveCommon ( CONTACTUS, 'id' );
				if (strtolower ( $_POST ['statusMode'] ) == 'delete')
				{
					$this->setErrorMessage ( 'success', 'Contact records deleted successfully' );
				}
				else
				{
					$this->setErrorMessage ( 'success', 'Contact records status changed successfully' );
				}
				redirect('admin/contact_us/display_contactus');
			}
		}
}

/* End of file contact_us.php */
/* Location: ./application/controllers/admin/contact_us.php */