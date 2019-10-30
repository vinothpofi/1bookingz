<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to user management
 * @author Teamtweaks
 *
 */
class Experience_review extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('experience_review_model');
		if ($this->checkPrivileges('Review', $this->privStatus) == FALSE) {
			redirect('admin');
		}
	}

	/**
	 *
	 * This function loads the experience_review list page
	 */
	public function index()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			redirect('admin/review/display_experience_review_list');
		}
	}

	/**
	 *
	 * This function loads the experience_review list page
	 */
	public function display_experience_review_list()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		} else {
			$this->data['heading'] = 'Experience Review List';
			$condition = array();
			$this->data['reviewList'] = $this->experience_review_model->get_all_review_details();
			$this->load->view('admin/experience_review/display_review', $this->data);
		}
	}

	/**
	 *
	 * Function to change review status
	 */
	public function change_review_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);

			if ($status == 'Active')
			{
				$GetReviewDetails = $this->experience_review_model->get_all_details(EXPERIENCE_REVIEW, $condition);
				if ($GetReviewDetails->row()->user_id > 0 && $GetReviewDetails->row()->user_id != '') {

					$GetUserDetails = $this->experience_review_model->get_all_details(USERS, array('id' => $GetReviewDetails->row()->user_id)); 
					$GetExperienceDetails = $this->experience_review_model->get_all_details(EXPERIENCE, array('experience_id' => $GetReviewDetails->row()->product_id));
					$hostEmail = $GetUserDetails->row()->email;
					$hostname = $GetUserDetails->row()->firstname;
					$ExpTittle = $GetExperienceDetails->row()->experience_title;
					$ExpId = $GetExperienceDetails->row()->experience_id;

					/*Mail To Host Start*/
					$newsid = '66';
					$template_values = $this->experience_review_model->get_newsletter_template_details($newsid);
					if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
						$sender_email = $this->data['siteContactMail'];
						$sender_name = $this->data['siteTitle'];
					} else {
						$sender_name = $template_values['sender_name'];
						$sender_email = $template_values['sender_email'];
					}
					$email_values = array('mail_type' => 'html',
						'from_mail_id' => $sender_email,
						'to_mail_id' => $hostEmail,
						'subject_message' => $template_values ['news_subject'],
					);
					$reg = array(
						'expTittle' => $ExpTittle,
						'hostname' => $hostname,
						'exp_id' => $ExpId,
						'base_url' => base_url(),
						'logo' => $this->data['logo']
					);

					$message = $this->load->view('newsletter/ExperienceReviewAcceptedbyAdmin' . $newsid . '.php', $reg, TRUE);
					$this->load->library('email');
					$this->email->set_mailtype($email_values['mail_type']);
					$this->email->from($email_values['from_mail_id'], $sender_name);
					$this->email->to($email_values['to_mail_id']);
					$this->email->subject($email_values['subject_message']);
					//$this->email->set_mailtype("html");
					$this->email->message($message);
					try {
						$this->email->send();

						if ($this->lang->line('mail_send_success') != '') {
							$message = stripslashes($this->lang->line('mail_send_success'));
						} else {
							$message = "mail send success";
						}
						$this->setErrorMessage('success', $message);

					} catch (Exception $e) {
						echo $e->getMessage();

					}
					/*Mail To Host End*/

				}
			}

			$this->db->reconnect();
			$this->experience_review_model->update_details(EXPERIENCE_REVIEW, $newdata, $condition);
			$this->setErrorMessage('success', 'Review Status Changed Successfully');
			redirect('admin/experience_review/display_experience_review_list');
		}
	}

	/**
	 *
	 * This function loads the review view page
	 */
	public function view_review()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} else {
			$this->data['heading'] = 'View Review';
			$review_id = $this->uri->segment(4, 0);
			$this->data['review_details'] = $this->experience_review_model->get_review_details($review_id);

			if ($this->data['review_details']->num_rows() == 1) {
				$this->load->view('admin/experience_review/view_review', $this->data);
			} 
			else {
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
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		} 
		else {
			$id = $this->uri->segment(4, 0);
			$condition = array('id' => $id);
			$this->experience_review_model->commonDelete(EXPERIENCE_REVIEW, $condition);
			$this->setErrorMessage('success', 'Review deleted successfully');
			redirect('admin/experience_review/display_experience_review_list');
		}
	}

	/**
	 *
	 * This function change the user status, delete the user record
	 */
	public function change_review_status_global()
	{
		if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') {
			$this->experience_review_model->activeInactiveCommon(EXPERIENCE_REVIEW, 'id');
			if (strtolower($_POST['statusMode']) == 'delete') {
				$this->setErrorMessage('success', 'Review records deleted successfully');
			} else {
				$this->setErrorMessage('success', 'Review records status changed successfully');
			}
			redirect('admin/experience_review/display_experience_review_list');
		}
	}
}

/* End of file experience_review.php */
/* Contact: ./application/controllers/admin/experience_review.php */
