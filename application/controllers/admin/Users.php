<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to user management
 * @author Teamtweaks
 *
 */
class Users extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation', 'image_lib', 'resizeimage'));
		$this->load->model('user_model');
		$this->load->library('pagination');
		if ($this->checkPrivileges('Members', $this->privStatus) == FALSE)
		{
			redirect('admin');
		}
	}

	/**
	 *
	 * This function loads the users list page
	 */
	public function index()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else 
		{
			redirect('admin/users/display_user_list');
		}
	}


	/**
	 *  Function to verify User ID proof
	 **/
	public function verify_user()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Verify User Proof';
			$user_id = $this->uri->segment(4, 0);

			$select_query = "SELECT * FROM " . ID_PROOF . " WHERE user_id='" . $user_id . "'";

			$this->data['user_id'] = $user_id;
			$this->data['user_type'] = 'User';
			$this->data['userDetails'] = $this->user_model->ExecuteQuery($select_query);
			
			$this->load->view('admin/users/verify_user', $this->data);

		}
	}


	public function update_proof_file()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {

			if (isset($_POST['submit'])) {

				

				$ids = $this->input->post('proofID');
				$status = $this->input->post('proof_status');
				$comments = $this->input->post('comments');
				$user_type = $this->input->post('user_type');
				// print_r($id);
				//print_r($status); exit;
				foreach ($ids as $id) {

					//echo "Update Here";

					$this->db->set('proof_status', $status[$id]); //value that used to update column
					$this->db->set('proof_comments', $comments[$id]); //value that used to update column
					$this->db->where('id', $id); //which row want to upgrade
					$this->db->update(ID_PROOF);


					//$this->load->view('admin/seller/add_seller',$this->data);
					//redirect('admin/seller/display_seller_list');				
				}
				$this->setErrorMessage('success', ' Proof Verified successfully');
			}
			if ($user_type == 'User')
				redirect('admin/users/display_user_list');
			else
				redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function loads the users list view
	 */
	public function display_user_list()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Guest List';

			// $condition = array('group' => 'User', 'email !=' => '');
			// $condition1 = array(array('field' => 'id', 'type' => 'desc'));

			// $this->data['usersList'] = $this->user_model->get_all_details(USERS, $condition, $condition1);

			// foreach ($this->data['usersList']->result() as $usersList_value) {
			// 	$nestedData[] = $row["employee_name"];
			// 	$nestedData[] = $row["employee_salary"];
			// 	$nestedData[] = $row["employee_age"];
				
			// 	$data[] = $nestedData;
			// }

			$this->load->view('admin/users/display_userlist', $this->data);
		}
	}

	public function display_user_list_datatables()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$requestData= $_REQUEST;
			$this->data['heading'] = 'Guest List';
			$columns = array(
			// datatable column index  => database column name
				0 =>'firstname', 
				1 => 'lastname',
				2=> 'status',
				3 =>'image', 
				4 => 'is_verified',
				5 =>'loginUserType', 
				6 => 'last_login_date'
			);
			$condition = array('group' => 'User', 'email !=' => '');
			$condition1 = array(array('field' => 'id', 'type' => 'desc'));
			$data = array();
			$usersList = $this->user_model->get_all_details(USERS, $condition);
			$totalData = $usersList->num_rows();
			$totalFiltered = $totalData;

			$sql = "SELECT * ";
			$sql.=" FROM fc_users ";
			if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
				$sql.="WHERE";
				$sql.=" ( firstname LIKE '".$requestData['search']['value']."%' ";    
				$sql.=" OR lastname LIKE '".$requestData['search']['value']."%' ";

				$sql.=" OR email LIKE '".$requestData['search']['value']."%' ";

				$sql.=" OR loginUserType LIKE '".$requestData['search']['value']."%' ";

				$sql.=" OR status LIKE '".$requestData['search']['value']."%' )";
				$usersList = $this->db->query($sql);
			$totalFiltered = $usersList->num_rows();
			$sql.="and";
			}else{
				$usersList = $this->db->query($sql);
			$totalFiltered = $usersList->num_rows();
				$sql.="where";
			}

			
			$sql.= " `group` = 'User' and `email` IS NOT NULL";
			$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
			/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */	
			//echo $sql;exit;
			$usersList = $this->db->query($sql);
			$totalFiltered = $usersList->num_rows();
			// echo "<pre>";
			// print_r($usersList->result());exit;
			$allPrev = $this->data['allPrev'];
			$Members = $this->data['Members'];
			$allPrev = $this->data['allPrev'];
			foreach ($usersList->result() as $row) {
				$nestedData=array(); 
				$modeid = ($row->is_verified == 'Yes') ? '0' : '1';
										if ($modeid == '0') 
										{
											
											$status_is = "<a title='Click to inactive' class='tip_top'
																						   href='javascript:confirm_status('admin/users/verify_user_status/ $modeid/".$row->id."'><span
																								class='badge_style b_done'>".$row->is_verified."							
																							</span>
																						</a>";
											
										} 
										else 
										{
											
										$status_is = "<a title='Click to active' class='tip_top'
																						   href='javascript:confirm_status('admin/users/verify_user_status/".$modeid."/".$row->id."')'><span
																								class='badge_style'>No</span>
																						</a>";
											
										}

				if ($row->loginUserType == 'normal') {
					$loginUserType= "E-mail";
				} else {
					$loginUserType = ucfirst($row->loginUserType);
				}
				if ($row->last_login_date == '0000-00-00 00:00:00') 
				{
				 	$last_login_date = '-';
				}else {
				 	$last_login_date =  date("Y-m-d", strtotime($row->last_login_date));
				}
				
				if ($allPrev == '1' || in_array('2', $Members)){
					$mode = ($row->status == 'Active') ? '0' : '1';
					if ($mode == '0'){
												
					$stat = '<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('."'".'admin/users/change_user_status/'.$mode.'/'.$row->id."'".');"><span class="badge_style b_done">'.$row->status.'</span></a>';
												
					} else {
					$stat = '<a title="Click to active" class="tip_top"  href="javascript:confirm_status('."'".'admin/users/change_user_status/'.$mode.'/'.$row->id."'".')"><span class="badge_style">'.$row->status.'</span></a>';							
				    }
					} 
										else 
										{
											
											$stat ='<span class="badge_style b_done">'.$row->status.'
																						</span>';
										}
				 if ($row->loginUserType == 'google') {
					$image_is = '<img class="rollovereff" width="40px" height="40px" src="'.base_url().'images/users/'.$row->image.'"/>';
				} else if ($row->image != '') {
				$image_is = '<img class="rollovereff" width="40px" height="40px" src="'.base_url().'images/users/'.$row->image.'"/>';
				} else { 
				$image_is = '<img class="rollovereff" width="40px" height="40px" src="'.base_url().'images/users/user-thumb1.png"/>';
				}

				$nestedData[] = '<td class="center tr_select "><input name="checkbox_id[]" type="checkbox" value="'.$row->id.'"></td>';

				if ($allPrev == '1' || in_array('2', $Members)) { 
				$action = '<span><a class="action-icons c-edit" href="admin/users/edit_user_form/'.$row->id.'" title="Edit">Edit</a></span>';
				}
				$action_1='<span><a class="action-icons c-suspend" href="admin/users/view_user/'.$row->id.'" title="View">View</a></span>';
				if ($allPrev == '1' || in_array('3', $Members)) {
				 $action_2='<span><a class="action-icons c-delete" href="javascript:confirm_delete('."'".'admin/users/delete_user/'.$row->id."'".')" title="Delete">Delete</a></span>';

			//	$action_2="<span><a class='action-icons c-delete' href='javascript:confirm_delete(".'"'."admin/users/delete_user/".$row->id.'"'.")' title='Delete'>Delete</a></span>";
				} 
				if ($row->last_login_ip == '') 
										{
											$last_login_ip = '-';
										} 
										else 
										{
											$last_login_ip = $row->last_login_ip;
										}
				$nestedData[] = $row->firstname;
				$nestedData[] = $row->lastname;
				$nestedData[] = $row->email;
				$nestedData[] = $loginUserType;
				$nestedData[] = $row->created;
				$nestedData[] = $last_login_date;
				$nestedData[] = $last_login_ip;
				$nestedData[] = $stat;
				$nestedData[] = $action.$action_1.stripSlashes($action_2);
				
				$data[] = $nestedData;
			}
			// print_r( $data);exit;
			$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

			echo json_encode($json_data);  // send data as json format
		}
	}

	/**
	 *
	 * This function loads the users dashboard
	 */

	public function display_user_dashboard()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Guest Dashboard';
			$condition = 'where `email`!="" AND `group`="User" order by `id` desc';
			$this->data['usersList'] = $this->user_model->get_users_details($condition);

			$active_users=$this->user_model->get_all_details(USERS,array('status'=>'Active','group'=>"User"));
			$inactive_users=$this->user_model->get_all_details(USERS,array('status'=>'Inactive','group'=>"User"));
            $this->data['active_users']=$active_users->num_rows();
            $this->data['inactive_users']=$inactive_users->num_rows();

			$this->load->view('admin/users/display_user_dashboard', $this->data);
		}
	}

	/**
	 *
	 * This function loads the add new user form
	 */
	public function add_user_form()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} 
		else {
			$this->data['heading'] = 'Add New Guest';
			$this->load->view('admin/users/add_user', $this->data);
		}
	}

	/**
	 *
	 * This function insert and edit a user
	 */
	public function insertEditUser()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$user_id = $this->input->post('user_id');
			$first = $this->input->post('firstname');
			$firstname = $first . trim();
			$user = $this->input->post('firstname');
			$user_name = $user . trim();
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');

			if ($user_id == '') 
			{				
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->user_model->get_all_details(USERS, $condition);
				
				$condition = array('email' => $email);
				$duplicate_mail = $this->user_model->get_all_details(USERS, $condition);

				if ($duplicate_mail->num_rows() > 0) 
				{
					$this->setErrorMessage('error', 'User email already exists');
					redirect('admin/users/add_user_form');
				}				
			}

			$excludeArr = array("user_id", "image", "new_password", "confirm_password", "group", "status");
			$user_group = 'User';

			if ($this->input->post('status') != '') 
			{
				$user_status = 'Active';
			} 
			else 
			{
				$user_status = 'Inactive';
			}

			$inputArr = array('group' => $user_group, 'status' => $user_status, 'user_name' => $user_name);

			$inputArr['request_status'] = 'Approved';
			$datestring = "%Y-%m-%d %H:%s:%i";
			$time = time();
			
			$Image_name = $_FILES['image']['name'];
			if ($Image_name != '') 
			{
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config ['max_width'] = '272';
				$config ['max_height'] = '272';
				$config['upload_path'] = './images/users';

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) 
				{
					$imgDetails = $this->upload->data();
					$inputArr['image'] = $imgDetails['file_name'];
					/* Compress */
					$source_photo = './images/users/' . $imgDetails['file_name'] . '';
					$dest_photo = './images/users/' . $imgDetails['file_name'];
					$this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
					/* End Compress */
				} 
				else 
				{
					if ($user_id != '') 
					{
						$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 272*272 px');
						redirect('admin/users/edit_user_form/' . $user_id);

					} 
					else 
					{
						$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 272*272 px');
						redirect('admin/users/add_user_form/');
					}
				}
			}

			if ($user_id == '') 
			{
				$user_data = array(
					'password' => $password,
					'is_verified' => 'No',
					'created' => mdate($datestring, $time),
					'modified' => mdate($datestring, $time),
				);
			}
			else 
			{

				$user_data = array('modified' => mdate($datestring, $time));
			}

			$dataArr = array_merge($inputArr, $user_data);
			$excludeArr = array("user_id", "confirm-password", "password", "new_password", "confirm_password");
			$condition = array('id' => $user_id);

			if ($user_id == '') 
			{
				$regex_lowercase = '/[a-z]/';
		        $regex_uppercase = '/[A-Z]/';
		        $regex_number = '/[0-9]/';
		      if (preg_match_all($regex_lowercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_uppercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_number, $this->input->post('new_password')) < 1 || strlen($this->input->post('new_password')) < 8)
			        {

			            $this->setErrorMessage('valid_password', 'Password must be 8 characters (must contain 1 digit and 1 uppercase)');
			            redirect('admin/users/add_user_form/');
			        }
			        else{
			        	$this->user_model->commonInsertUpdate(USERS, 'insert', $excludeArr, $dataArr, $condition);
						$this->setErrorMessage('success', 'User added successfully');
						$insertid = $this->db->insert_id();
			        }
				

				/* Mail function */
				$newsid = '39';
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

				$username = $firstname . $lastname;
				$uid = $insertid;
				$randStr = $this->get_rand_str('10');
				$cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
				$logo_mail = $this->data['logo'];

				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);

				$reg = array('username' => $username, 'email' => $email, 'password' => $this->input->post('new_password'), 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
				$message = $this->load->view('newsletter/UserRegistrationConfirmation' . $newsid . '.php', $reg, TRUE);

				/*send mail*/
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
			} 
			else 
			{
				$this->user_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				

				$regex_lowercase = '/[a-z]/';
		        $regex_uppercase = '/[A-Z]/';
		        $regex_number = '/[0-9]/';
				if ($this->input->post('password') != '') 
				{
					
					if (preg_match_all($regex_lowercase, $this->input->post('password')) < 1 || preg_match_all($regex_uppercase, $this->input->post('password')) < 1 || preg_match_all($regex_number, $this->input->post('password')) < 1 || strlen($this->input->post('password')) < 6)
			        {

			            $this->setErrorMessage('valid_password', 'Password must be 8 characters (must contain 1 digit and 1 uppercase)');
			            redirect('admin/users/edit_user_form/' . $user_id);
			        }
			        else{
			        	$pwd = $this->input->post('password');
			        	$newdata = array('password' => md5($pwd));
			        	$this->user_model->update_details(USERS, $newdata, $condition);
			        }
					
				}

				$this->setErrorMessage('success', 'User updated successfully');
			}

			redirect('admin/users/display_user_list');
		}
	}

	/**
	 *
	 * This function loads the edit user form
	 */
	public function edit_user_form()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Edit Member';
			$user_id = $this->uri->segment(4, 0);
			$condition = array('id' => $user_id);

			$this->data['user_details'] = $this->user_model->get_all_details(USERS, $condition);
			$this->data['user_idProof'] = $this->user_model->get_all_details(ID_PROOF, array('user_id' => $user_id));
			if ($this->data['user_details']->num_rows() == 1) 
			{
				$this->load->view('admin/users/edit_user', $this->data);
			} 
			else 
			{
				redirect('admin');
			}
		}
	}


	/**
	 *
	 * This function change the user status
	 */
	public function change_user_status()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->user_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'User Status Changed Successfully');
			redirect('admin/users/display_user_list');
		}
	}

	/**
	 *
	 * This function loads the user view page
	 */
	public function view_user()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'View User';
			$user_id = $this->uri->segment(4, 0);
			$condition = array('id' => $user_id);
			$this->data['user_details'] = $this->user_model->get_all_details(USERS, $condition);
			if ($this->data['user_details']->num_rows() == 1) 
			{
				$this->load->view('admin/users/view_user', $this->data);
			} 
			else 
			{
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function delete the user record from db
	 */
	public function delete_user()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$user_id = $this->uri->segment(4, 0);
			$condition = array('id' => $user_id);
			$this->user_model->commonDelete(USERS, $condition);
			$this->setErrorMessage('success', 'User deleted successfully');
			redirect('admin/users/display_user_list');
		}
	}

	/**
	 *
	 * This function change the user verified status
	 */
	public function verify_user_status()
	{
		echo("inside function");
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'No' : 'Yes';
			$newdata = array('is_verified' => $status);
			$condition = array('id' => $user_id);
			$this->user_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'User Status Changed Successfully');
			redirect('admin/users/display_user_list');
		}
	}


	/**
	 *
	 * This function change the user status, delete the user record
	 */
	public function change_user_status_global()
	{
		if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') 
		{
			$this->user_model->activeInactiveCommon(USERS, 'id');

			if (strtolower($_POST['statusMode']) == 'delete') 
			{
				$this->setErrorMessage('success', 'User records deleted successfully');
			} 
			else 
			{
				$this->setErrorMessage('success', 'User records status changed successfully');
			}

			redirect('admin/users/display_user_list');
		}
	}

	/**
	 *
	 * This function exports whole user details
	 */
	public function export_user_details()
	{
		$fields_wanted = array('firstname', 'lastname','loginUserType', 'email', 'created', 'last_login_date', 'last_login_ip', 'status');
		$table = USERS;
		$users = $this->user_model->export_user_details($table, $fields_wanted);
		$this->data['users_detail'] = $users['users_detail']->result_array();
		
		$this->load->view('admin/users/export_user', $this->data);
	}

	/*This function used to check subadmin email id is already exist or not when add/edit subadmin */
	public function check_user_email_exist()
	{
		$email_id = $_POST['email_id'];
		$group = $_POST['group'];
		$exist = $this->user_model->check_user_email_exist($email_id, $group);
		echo $exist->num_rows();
	}
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */
