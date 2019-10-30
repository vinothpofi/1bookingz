<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to sub-admin management
 * @author Teamtweaks
 *
 */
class Subadmin extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model(array('subadmin_model', 'product_model'));
		if ($this->checkPrivileges('subadmin', $this->privStatus) == FALSE) 
		{
			redirect('admin');
		}
	}

	/**
	 *
	 * This function loads the Sub Admin users list
	 */
	public function display_sub_admin()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Sub-Admin Users';
			$condition = array('admin_rep_code' => '', 'admin_rep_type' => 'Normal');
			$sortArr1 = array('field' => 'id', 'type' => 'desc');
			$sortArr = array($sortArr1);
			$this->data['admin_users'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr);
			
			$this->load->view('admin/subadmin/display_subadmin', $this->data);
		}
	}

	/**
	 *
	 * This function change the Sub Admin user status
	 */
	public function change_subadmin_status()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$mode = $this->uri->segment(4, 0); 
			$adminid = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$newdata = array('status' => $status); 
			$condition = array('id' => $adminid);

			$this->subadmin_model->update_details(SUBADMIN, $newdata, $condition);
			$this->setErrorMessage('success', 'Sub Admin Status Changed Successfully');
			redirect('admin/subadmin/display_sub_admin');
		}
	}

	/**
	 *
	 * This function loads the add subadmin form
	 */
	public function add_sub_admin_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Add Sub-Admin';
			$condition = array();
			$this->load->view('admin/subadmin/add_subadmin', $this->data);
		}
	}

	/**
	 *
	 * This function insert and edit a Sub Admin and his privileges
	 */
	public function insertEditSubadmin()
	{ 
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$subadminid = $this->input->post('subadminid'); 
			$sub_admin_name = $this->input->post('name');
			$admin_name = $this->input->post('admin_name');			
			$admin_password = md5($this->input->post('admin_password'));
			$show_password = $this->input->post('admin_password');
			$email = $this->input->post('email');
			$reptype = $this->input->post('rep_type'); 

			if ($reptype == 'Normal') 
			{
				$repcode = '';
			} 
			else 
			{
				$repcode = $this->input->post('rep_Code');
			}

			if ($subadminid == '') 
			{
				$condition = array('email' => $email);
				$duplicate_admin = $this->subadmin_model->get_all_details(ADMIN, $condition);

				if ($duplicate_admin->num_rows() > 0) 
				{
					$this->setErrorMessage('error', 'Admin email already exists');
					redirect('admin/subadmin/add_sub_admin_form');
				} 
				else 
				{
					$duplicate_email = $this->subadmin_model->get_all_details(SUBADMIN, $condition);
					if ($duplicate_email->num_rows() > 0) 
					{
						$this->setErrorMessage('error', 'Sub Admin email already exists');
						redirect('admin/subadmin/add_sub_admin_form');
					} 
					else 
					{
						$condition = array('admin_name' => $admin_name);
						$duplicate_adminname = $this->subadmin_model->get_all_details(ADMIN, $condition);
						if ($duplicate_adminname->num_rows() > 0) 
						{
							$this->setErrorMessage('error', 'Admin name already exists');
							redirect('admin/subadmin/add_sub_admin_form');
						} 
						else 
						{
							$duplicate_name = $this->subadmin_model->get_all_details(SUBADMIN, $condition);
							if ($duplicate_name->num_rows() > 0) 
							{
								$this->setErrorMessage('error', 'Sub Admin name already exists');
								redirect('admin/subadmin/add_sub_admin_form');
							}
						}
					}
				}
			} 
			else 
			{
				$condition = array('email' => $email);
				$duplicate_admin = $this->subadmin_model->get_all_details(ADMIN, $condition);

				if ($duplicate_admin->num_rows() > 0) 
				{
					$this->setErrorMessage('error', 'Admin email already exists');
					redirect('admin/subadmin/edit_subadmin_form/' . $subadminid);

				} 
				else 
				{
					$duplicate_email = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr, $subadminid);

					if ($duplicate_email->num_rows() > 0) 
					{
						$this->setErrorMessage('error', 'Sub Admin email already exists');

						rredirect('admin/subadmin/edit_subadmin_form/' . $subadminid);
					} 
					else 
					{
						$condition = array('admin_name' => $admin_name);
						$duplicate_adminname = $this->subadmin_model->get_all_details(ADMIN, $condition);
						
						if ($duplicate_adminname->num_rows() > 0) 
						{
							$this->setErrorMessage('error', 'Admin name already exists');

							redirect('admin/subadmin/edit_subadmin_form/' . $subadminid);

						} 
						else 
						{
							$duplicate_name = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr, $subadminid);
							if ($duplicate_name->num_rows() > 0) 
							{
								$this->setErrorMessage('error', 'Sub Admin/Representative name already exists');

								redirect('admin/subadmin/edit_subadmin_form/' . $subadminid);
							}
						}
					}
				}
			}

			$excludeArr = array("email", "subadminid", "name", "admin_name", "admin_password", "show_password", "admin_rep_code", "admin_rep_type");
			$privArr = array();
			
			foreach ($this->input->post() as $key => $val) 
			{
				if (!in_array($key, $excludeArr)) 
				{
					$privArr[$key] = $val;
				}
			}

			$inputArr = array('privileges' => serialize($privArr));
			$datestring = "%Y-%m-%d";
			$time = time();
			
			if ($subadminid == '')
			 {
				$admindata = array(
					'name' => $sub_admin_name,
					'admin_name' => $admin_name,
					'admin_password' => $admin_password,
					'show_password' => $show_password,
					'email' => $email,
					'created' => mdate($datestring, $time),
					'modified' => mdate($datestring, $time),
					'admin_type' => 'sub',
					'admin_rep_code' => $repcode,
					'admin_rep_type' => $reptype,
					'is_verified' => 'Yes',
					'status' => 'Active');
			} 
			else 
			{
				$admindata = array('modified' => mdate($datestring, $time), 'name' => $sub_admin_name);
			}

			$dataArr = array_merge($admindata, $inputArr);
			$condition = array('id' => $subadminid);
			$this->subadmin_model->add_edit_subadmin($dataArr, $condition);

			if ($subadminid == '') 
			{
				/******Mail Function**********/
				$newsid = '46';
				$template_values = $this->product_model->get_newsletter_template_details($newsid);
				if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') 
				{
					$sender_email = $this->data['siteContactMail'];
					$sender_name = $this->data['siteTitle'];
				} 
				else 
				{
					$sender_name = $template_values['sender_name'];
					$sender_email = $template_values['sender_email'];
				}

				$username = $admin_name;
				$email = $email;
				$password = $this->input->post('admin_password');
				$logo_mail = $this->data['logo'];
				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);

				$reg = array('username' => $username, 'email' => $email, 'repcode' => $repcode, 'password' => $password, 'email_title' => $sender_name, 'logo' => $logo_mail);		   
            
				$message = $this->load->view('newsletter/SubRepRegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
				/*send mail */    

				$this->load->library('email');
				$this->email->from($email_values['from_mail_id'], $sender_name);
				$this->email->to($email_values['to_mail_id']);
				$this->email->subject($email_values['subject_message']);
				$this->email->set_mailtype("html");
				$this->email->message($message);
				try 
				{
					$this->email->send();
					$returnStr ['msg'] = 'Successfully registered';
					$returnStr ['success'] = '1';
				} 
				catch (Exception $e) 
				{
					echo $e->getMessage();
				}
				/* Mail function End */
				
				$this->setErrorMessage('success', 'Subadmin added successfully');
			} 
			else 
			{
				$this->setErrorMessage('success', 'Subadmin updated successfully');
			}
			redirect('admin/subadmin/display_sub_admin');
		}
	}

	/**
	 *
	 * This function loads the edit subadmin form
	 */
	public function edit_subadmin_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Edit Sub-Admin';
	 	    $adminid = $this->uri->segment(4,0);
	  		$condition = array('id' => $adminid);
	  		$this->data['admin_details'] = $this->subadmin_model->get_all_details(SUBADMIN,$condition);
			 
			if ($this->data['admin_details']->num_rows() == 1) 
			{
				$this->data['privArr'] = unserialize($this->data['admin_details']->row()->privileges);	
					
				if (!is_array($this->data['privArr'])) 
				{
					$this->data['privArr'] = array();
				}

				$this->load->view('admin/subadmin/edit_subadmin', $this->data);
			} 
			else 
			{
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function loads the subadmin view page
	 */
	public function view_subadmin()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'View Sub-Admin';
			$adminid = $this->uri->segment(4, 0);
			$condition = array('id' => $adminid);
			$sortArr1 = array('field' => 'created', 'type' => 'desc');
			$sortArr = array($sortArr1);
			$this->data['admin_details'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr);
			if ($this->data['admin_details']->num_rows() == 1) 
			{
				$this->data['privArr'] = unserialize($this->data['admin_details']->row()->privileges);
				if (!is_array($this->data['privArr']))
				{
					$this->data['privArr'] = array();
				}

				$this->load->view('admin/subadmin/view_subadmin', $this->data);
			} 
			else 
			{
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function delete the subadmin record from db
	 */
	public function delete_subadmin()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$subadmin_id = $this->uri->segment(4, 0);
			$condition = array('id' => $subadmin_id);
			$this->subadmin_model->commonDelete(SUBADMIN, $condition);
			$this->setErrorMessage('success', 'Subadmin deleted successfully');
			redirect('admin/subadmin/display_sub_admin');
		}
	}

	/**
	 *
	 * This function change the subadmin status, delete the subadmin record
	 */
	public function change_subadmin_status_global()
	{
		if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') 
		{
			$this->subadmin_model->activeInactiveCommon(SUBADMIN, 'id');
			if (strtolower($_POST['statusMode']) == 'delete') 
			{
				$this->setErrorMessage('success', 'Subadmin records deleted successfully');
			} 
			else 
			{
				$this->setErrorMessage('success', 'Subadmin records status changed successfully');
			}
			redirect('admin/subadmin/display_sub_admin');
		}
	}

	/*This function used to check subadmin email id is already exist or not when add/edit subadmin */
	public function check_subadmin_email_exist()
	{
		$email_id = $_POST['email_id'];

		$this->data['exist'] = $this->subadmin_model->check_subadmin_email_exist($email_id);
		if ($this->data['exist']->num_rows() > 0) 
		{
			echo "1";
		}
	}

	/*This function used to check subadmin login name is already exist or not when add/edit subadmin */
	public function check_subadmin_loginname_exist()
	{
		$admin_name = $_POST['admin_name'];
		$this->data['exist'] = $this->subadmin_model->check_subadmin_loginname_exist($admin_name);
		if ($this->data['exist']->num_rows() > 0) {
			echo "1";
		}
	}

	/**
	 *
	 * This function loads the subadmin dashboard page
	 */
	public function display_subadmin_dashboard()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Sub-Admin Dashboard';
			$condition = array('admin_rep_type' => 'Normal');
			$this->data['subadmin_list'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition);

			$this->load->view('admin/subadmin/display_subadmin_dashboard', $this->data);
		}
	}
}

/* End of file subadmin.php */
/* Location: ./application/controllers/admin/subadmin.php */
