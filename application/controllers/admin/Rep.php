<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to sub-admin management
 * @author Teamtweaks
 *
 */
class Rep extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model(array('subadmin_model', 'product_model'));
	}

	/**
	 *
	 * This function loads the Sub Admin users list
	 */
	public function display_rep_list()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Representatives List';
			$condition = array('admin_rep_type' => 'Representative');
			$sortArr1 = array('field' => 'created', 'type' => 'desc');
			$sortArr = array($sortArr1);

			$this->data['admin_users'] = $this->subadmin_model->get_rep_details_with_host();
			
			$this->load->view('admin/rep/display_replist', $this->data);
		}
	}

	/**
	 *
	 * This function change the Sub Admin user status
	 */
	public function change_rep_status()
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

			$this->setErrorMessage('success', 'Representative Status Changed Successfully');
			redirect('admin/rep/display_rep_list');
		}
	}

	/**
	 *
	 * This function loads the add subadmin form
	 */
	public function add_rep_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Add Representative';
			$condition = array();
			$this->load->view('admin/rep/add_rep', $this->data);
		}
	}

	/**
	 *
	 * This function insert and edit a Sub Admin and his privileges
	 */
	public function insertEditRep()
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
			$repcode = $this->input->post('rep_Code');

			$ignore = array($subadminid);
			$sortArr = '';
			if ($subadminid == '') 
			{
				$condition = array('email' => $email);
				$duplicate_admin = $this->subadmin_model->get_all_details(ADMIN, $condition);
				if ($duplicate_admin->num_rows() > 0) 
				{
					$this->setErrorMessage('error', 'Admin email already exists');
					if ($subadminid == '') 
					{
						redirect('admin/rep/add_rep_form');
					} 
					else 
					{
						redirect('admin/rep/edit_rep_form/' . $subadminid);
					}
				} 
				else 
				{
					$duplicate_email = $this->subadmin_model->get_all_details(SUBADMIN, $condition);
					if ($duplicate_email->num_rows() > 0) 
					{
						$this->setErrorMessage('error', 'Sub Admin/Representative Email-ID already exists');

						if ($subadminid == '') 
						{
							redirect('admin/rep/add_rep_form');
						} 
						else 
						{
							redirect('admin/rep/edit_rep_form/' . $subadminid);
						}

					} 
					else 
					{
						$condition = array('admin_name' => $admin_name);
						$duplicate_adminname = $this->subadmin_model->get_all_details(ADMIN, $condition);

						if ($duplicate_adminname->num_rows() > 0) 
						{
							$this->setErrorMessage('error', 'Admin name already exists');
							if ($subadminid == '') 
							{
								redirect('admin/rep/add_rep_form');
							} 
							else 
							{
								redirect('admin/rep/edit_rep_form/' . $subadminid);
							}
						} 
						else 
						{
							$duplicate_name = $this->subadmin_model->get_all_details(SUBADMIN, $condition);
							if ($duplicate_name->num_rows() > 0) 
							{
								$this->setErrorMessage('error', 'Sub Admin/Representative login name already exists');
								if ($subadminid == '') 
								{
									redirect('admin/rep/add_rep_form');
								}
								else 
								{
									redirect('admin/rep/edit_rep_form/' . $subadminid);
								}
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
					redirect('admin/rep/edit_rep_form/' . $subadminid);

				} 
				else 
				{
					$duplicate_email = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr, $subadminid);

					if ($duplicate_email->num_rows() > 0) 
					{
						$this->setErrorMessage('error', 'Sub Admin email already exists');

						redirect('admin/rep/edit_rep_form/' . $subadminid);


					} 
					else 
					{
						$condition = array('admin_name' => $admin_name);
						$duplicate_adminname = $this->subadmin_model->get_all_details(ADMIN, $condition);
						
						if ($duplicate_adminname->num_rows() > 0) 
						{
							$this->setErrorMessage('error', 'Admin name already exists');

							redirect('admin/rep/edit_rep_form/' . $subadminid);

						} 
						else 
						{
							$duplicate_name = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr, $subadminid);

							if ($duplicate_name->num_rows() > 0) 
							{
								$this->setErrorMessage('error', 'Sub Admin/Representative name already exists');

								redirect('admin/rep/edit_rep_form/' . $subadminid);
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
				$admindata = array('modified' => mdate($datestring, $time), 'name' => $sub_admin_name, 'email' => $email);
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

				try {
					$this->email->send();
					$returnStr ['msg'] = 'Successfully registered';
					$returnStr ['success'] = '1';
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				/* Mail function End */

				$this->setErrorMessage('success', 'Representative added successfully');
			} 
			else 
			{
				$this->setErrorMessage('success', 'Representative updated successfully');
			}

			redirect('admin/rep/display_rep_list');
		}
	}

	/**
	 *
	 * This function loads the edit subadmin form
	 */
	public function edit_rep_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Edit Representative';
			$adminid = $this->uri->segment(4, 0);
			$condition = array('id' => $adminid);
			$this->data['admin_details'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition);

			if ($this->data['admin_details']->num_rows() == 1) 
			{
				$this->data['privArr'] = unserialize($this->data['admin_details']->row()->privileges);
				if (!is_array($this->data['privArr'])) 
				{
					$this->data['privArr'] = array();
				}

				$this->load->view('admin/rep/edit_rep', $this->data);
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
	public function view_rep()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'View Representative';
			$adminid = $this->uri->segment(4, 0);
			$condition = array('id' => $adminid);
			$sortArr1 = array('field' => 'created', 'type' => 'desc');
			$sortArr = array($sortArr1);
			$this->data['rep_details'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition, $sortArr);

			if ($this->data['rep_details']->num_rows() == 1) 
			{
				$this->data['privArr'] = unserialize($this->data['rep_details']->row()->privileges);
				if (!is_array($this->data['privArr'])) 
				{
					$this->data['privArr'] = array();
				}

				$this->load->view('admin/rep/view_rep', $this->data);
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
	public function delete_rep()
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

			$this->setErrorMessage('success', 'Representative deleted successfully');
			redirect('admin/rep/display_rep_list');
		}
	}

	public function reassign_hosts_to_other_rep()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$rep_id = $this->uri->segment(4, 0);
			$this->data['heading'] = "Re-assign Hosts";
			$condition = array('admin_rep_type' => 'Representative');

			$this->data['rep_details'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition);


			foreach ($this->data['rep_details']->result() as $row) 
			{
				if ($row->id == $rep_id) 
				{
					$rep_code = $row->admin_rep_code;
					$this->data['rep_code'] = $rep_code;
					$this->data['rep_id'] = $rep_id;
				}
			}

			if ($rep_code != '') 
			{
				$condition = array('group' => 'Seller', 'rep_code' => $rep_code);
				$this->data['sellersList'] = $this->subadmin_model->get_all_details(USERS, $condition);
				$this->load->view('admin/rep/reassign_hosts', $this->data);
			} 
			else
			{
				redirect('admin/rep/display_rep_list');
			}
		}
	}

	public function reassign_hosts_to_other_rep_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$current_rep_code = $this->input->post('current_rep_code');
			$rep_id = $this->input->post('rep_id');
			$rep_code = $this->input->post('rep_code');
			$hostArr = $this->input->post('host');
			$user_ids = implode(',', $hostArr);
			$datestring = "%Y-%m-%d";
			$time = time();
			
			if (!empty($hostArr)) 
			{
				$hostdata = array(
					'rep_code' => $rep_code,
					'modified' => mdate($datestring, $time));
				$condition = array('rep_code' => $current_rep_code);

				$this->subadmin_model->update_details(USERS, $hostdata, $condition, $hostArr);
				$this->setErrorMessage('success', 'Hosts Reassigned successfully');
				redirect('admin/rep/display_rep_list');
				
			} 
			else 
			{
				$this->setErrorMessage('error', 'Assign Hosts');
				redirect('admin/rep/reassign_hosts_to_other_rep/' . $rep_id);
			}
		}
	}

	/**
	 *
	 * This function change the subadmin status, delete the subadmin record
	 */
	public function change_rep_status_global()
	{
		if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') 
		{
			$this->subadmin_model->activeInactiveCommon(SUBADMIN, 'id');
			if (strtolower($_POST['statusMode']) == 'delete') 
			{
				$this->setErrorMessage('success', 'Representative records deleted successfully');
			} 
			else 
			{
				$this->setErrorMessage('success', 'Representative records status changed successfully');
			}
			redirect('admin/rep/display_rep_list');
		}
	}

	/**
	 *
	 * This function downloads the representatives list
	 */
	public function export_rep_details()
	{
		$fields_wanted = array('name', 'admin_name', 'last_logout_date', 'email', 'admin_rep_code', 'status', 'created', 'last_login_date', 'last_login_ip', '(select IFNULL(count(ur.id),0) from fc_users as ur where ur.rep_code= admin_rep_code) as host_count');

		$rep = $this->subadmin_model->export_rep_details(SUBADMIN, $fields_wanted);
		$this->data['rep_detail'] = $rep['rep_detail']->result_array();
		$this->load->view('admin/rep/export_rep', $this->data);
	}

	/**
	 *
	 * This function loads the representative dashboard 
	 */
	public function display_rep_dashboard()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Representatives Dashboard';
			$condition = array('admin_rep_type' => 'Representative');
			
			$this->data['repList'] = $this->subadmin_model->get_all_details(SUBADMIN, $condition);
			$this->load->view('admin/rep/display_rep_dashboard', $this->data);
		}
	}
}

/* End of file subadmin.php */
/* Location: ./application/controllers/admin/subadmin.php */
