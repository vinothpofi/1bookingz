<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to seller management
 * @author Teamtweaks
 *
 */
class Seller extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('seller_model');
		$this->load->model('user_model');
		$this->load->model('cms_model');
		if ($this->checkPrivileges('Host', $this->privStatus) == FALSE) {
			redirect('admin');
		}
	}

	/**
	 *
	 * This function loads the seller requests page
	 */
	public function index()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			redirect('admin/seller/display_seller_dashboard');
		}
	}

	/**
	 *
	 * This function loads the sellers dashboard
	 */
	public function display_seller_dashboard()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Host Dashboard';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if ($rep->row()->admin_rep_code == '') {
				$condition = 'where `group`="Seller" order by `created` desc';
			} else {
				$rep_code = $rep->row()->admin_rep_code;
				$condition = 'where `group`="Seller" and `rep_code`="' . $rep_code . '" order by `created` desc';
			}
			$this->data['usersList'] = $this->user_model->get_users_details($condition);

            $active_users=$this->user_model->get_all_details(USERS,array('status'=>'Active','group'=>"Seller",'host_status'=>0));
            $inactive_users=$this->user_model->get_all_details(USERS,array('status'=>'Inactive','group'=>"Seller",'host_status'=>0));
            $archived_users=$this->user_model->get_all_details(USERS,array('status'=>'Inactive','group'=>"Seller",'host_status'=>1));
            $this->data['active_users']=$active_users->num_rows();
            $this->data['inactive_users']=$inactive_users->num_rows();
            $this->data['archived_users']=$archived_users->num_rows();


            $this->load->view('admin/seller/display_seller_dashboard', $this->data);
		}
	}

	/* Seller Proof Verification Starts  - malar 12/07/2017 */
	public function verify_seller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Verify User Proof';
			$user_id = $this->uri->segment(4, 0);
			$select_query = "SELECT * FROM " . ID_PROOF . " WHERE user_id='" . $user_id . "'";
			$this->data['user_id'] = $user_id;
			$this->data['user_type'] = 'Seller';
			$this->data['userDetails'] = $this->user_model->ExecuteQuery($select_query);
			$this->load->view('admin/users/verify_user', $this->data);
		}
	}

	/**
	 *
	 * This function loads the seller requests page
	 */
	public function display_seller_requests()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Hosts Requests';
			$condition = array('request_status' => 'Pending', 'group' => 'User');
			$this->data['sellerRequests'] = $this->seller_model->get_all_details(USERS, $condition);
			$this->load->view('admin/seller/display_seller_requests', $this->data);
		}
	}

	/**
	 *
	 * This function loads the Host list page
	 */
	public function display_seller_list()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Host List';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if ($rep->row()->admin_rep_code == '') {

				$condition = array('group' => 'Seller', 'host_status' => 0, 'email !=' => '');
			} else {

				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller', 'rep_code' => $rep_code, 'host_status' => 0, 'email !=' => '');
			}
			if ($reptv_code != '') {
				$condition['rep_code'] = $reptv_code;
			}
			$rep_set = $this->uri->segment(4, 0); 
			if ($rep_set != '0') {
				$condition = array('group' => 'Seller', 'rep_code' => $rep_set, 'host_status' => 0, 'email !=' => '');
				$this->data['sellersList'] = $this->seller_model->get_all_seller_details_Proof($condition);
			} else {
				$this->data['sellersList'] = $this->seller_model->get_all_seller_details_Proof($condition);

			} 
			$this->load->view('admin/seller/display_sellerlist', $this->data);
		}
	}
	public function display_seller_list_datatables()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$requestData= $_REQUEST;
			$this->data['heading'] = 'Host List';
			$columns = array(
			// datatable column index  => database column name
				0 =>'firstname', 
				1 => 'lastname',
				2=> 'email',
				3 =>'image', 
				4 => 'is_verified',
				5 =>'loginUserType', 
				6 => 'last_login_date',
				7 => 'status'
			);
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if ($rep->row()->admin_rep_code == '') {

				$condition = array('group' => 'Seller', 'host_status' => 0, 'email !=' => '');
			} else {

				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller', 'rep_code' => $rep_code, 'host_status' => 0, 'email !=' => '');
			}
			if ($reptv_code != '') {
				$condition['rep_code'] = $reptv_code;
			}
			$rep_set = $this->uri->segment(4, 0); 
			if ($rep_set != '0') {
				$condition = array('group' => 'Seller', 'rep_code' => $rep_set, 'host_status' => 0, 'email !=' => '');
				$sellersList = $this->seller_model->get_all_seller_details_Proof($condition);
			} else {
				$sellersList = $this->seller_model->get_all_seller_details_Proof($condition);

			}
			$totalData = $sellersList->num_rows();
			$totalFiltered = $totalData;

				if ($rep->row()->admin_rep_code == '') {

				$condition  = "`group` = 'Seller' AND `host_status` = 0 AND `email` IS NOT NULL";
			} else {

				$rep_code = $rep->row()->admin_rep_code;
				$condition = "`group` = 'Seller' AND `rep_code` = $rep_set AND `host_status` = 0 AND `email` IS NOT NULL";

			}
			if ($reptv_code != '') {
				$condition['rep_code'] = $reptv_code;
			}
			$rep_set = $this->uri->segment(4, 0); 
			if ($rep_set != '0') {
				$condition = "`group` = 'Seller' AND `rep_code` = $rep_set AND `host_status` = 0 AND `email` IS NOT NULL";
			}
			
			if( !empty($requestData['search']['value']) ) {   
				$condition.=" AND ( firstname LIKE '".$requestData['search']['value']."%' ";    
				$condition.=" OR lastname LIKE '".$requestData['search']['value']."%' ";

				$condition.=" OR email LIKE '".$requestData['search']['value']."%' ";

				$condition.=" OR loginUserType LIKE '".$requestData['search']['value']."%' ";

				$condition.=" OR status LIKE '".$requestData['search']['value']."%' )";
			}
			//
			$this->db->select('u.*,uid.id_proof_status');
			$this->db->from(USERS.' as u');
			$this->db->join(ID_PROOF.' as uid',"uid.user_id=u.id","left");
			$this->db->where($condition);
			$sellersList = $this->db->get();
			// print_r($sellersList->result());exit;
			$totalFiltered = $sellersList->num_rows();
			$order_is =" ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  ";
			$limit_is = "".$requestData['start']." ,".$requestData['length']."   ";
			

			$this->db->select('u.*,uid.id_proof_status');
			$this->db->from(USERS.' as u');
			$this->db->join(ID_PROOF.' as uid',"uid.user_id=u.id","left");
			$this->db->where($condition);
			$this->db->order_by($columns[$requestData['order'][0]['column']],$requestData['order'][0]['dir']);
            $this->db->limit($requestData['length'],$requestData['start']);
			$sellersList = $this->db->get();	
		
			// echo "<pre>";
			// print_r($usersList->result());exit;
			$allPrev = $this->data['allPrev'];
			$Members = $this->data['Host'];
			$allPrev = $this->data['allPrev'];
			$data=array(); 
			foreach ($sellersList->result() as $row) {
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
				if ($row->id_proof_status == '') {
					$id_proof_status = "Proof Not Sent"; 
				} else {
					$id_proof_status = '<b>' . $row->id_proof_status . '</b>';
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
												
					$stat = '<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('."'".'admin/seller/change_user_status/'.$mode.'/'.$row->id."'".');"><span class="badge_style b_done">'.$row->status.'</span></a>';
												
					} else {
					$stat = '<a title="Click to active" class="tip_top"  href="javascript:confirm_status('."'".'admin/seller/change_user_status/'.$mode.'/'.$row->id."'".')"><span class="badge_style">'.$row->status.'</span></a>';							
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
				$action = '<span><a class="action-icons c-edit" href="admin/seller/edit_seller_form/'.$row->id.'" title="Edit">Edit</a></span>';
				}
				$action_1='<span><a class="action-icons c-suspend" href="admin/seller/view_seller/'.$row->id.'" title="View">View</a></span>';
				if ($allPrev == '1' || in_array('3', $Members)) {
				 $action_2='<span><a class="action-icons c-delete" href="javascript:confirm_delete('."'".'admin/seller/delete_seller/'.$row->id."'".')" title="Delete">Delete</a></span>';

			//	$action_2="<span><a class='action-icons c-delete' href='javascript:confirm_delete(".'"'."admin/users/delete_user/".$row->id.'"'.")' title='Delete'>Delete</a></span>";
				} 
				
				if ($allPrev == '1' || in_array('2', $Members)){
					$mode = ($row->is_verified == 'Yes') ? '0' : '1';
					if ($mode == '0'){
												
					$isverified = '<a title="Verified" class="tip_top"><span class="badge_style b_done">Verified</span></a>';
												
					} else {
					$isverified = '<a title="Click to verify" class="tip_top"  href="javascript:confirm_status('."'".'admin/seller/change_user_verification/'.$mode.'/'.$row->id."'".')"><span class="badge_style">'.$row->is_verified.'</span></a>';							
				    }
				} 
				else 
				{
					
					$isverified ='<span class="badge_style b_done">'.$row->is_verified.'
																</span>';
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
				$nestedData[] = $isverified;
				$nestedData[] = $loginUserType;
				$nestedData[] = $row->created;
				$nestedData[] = $last_login_date;
				$nestedData[] = $last_login_ip;
				$nestedData[] = $id_proof_status;
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
	 * This function loads the Archieve Seller list page
	 */
	public function display_archieve_seller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Host &nbsp;Archive &nbsp;List';
			$rep = $this->seller_model->get_sub($_SESSION['fc_session_admin_id']);
			$rep->row()->admin_rep_code;
			if ($rep->row()->admin_rep_code == '') {
				$condition = array('group' => 'Seller', 'host_status' => 1, 'email !=' => '');
			} else {
				$rep_code = $rep->row()->admin_rep_code;
				$condition = array('group' => 'Seller', 'rep_code' => $rep_code, 'host_status' => 1, 'email !=' => '');
			}
			$this->data['sellersList'] = $this->seller_model->get_all_details(USERS, $condition);
			$this->load->view('admin/seller/display_archieve_seller', $this->data, $result_u);
		}
	}

	/**
	 *
	 * This function insert and edit a user
	 */
	public function insertEditRenter()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$seller_id = $this->input->post('seller_id');
			$firstname = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$confirm_password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			$rep_code = $this->input->post('rep_code');
			$user_name = $this->input->post('firstname');
			$condition = array('email' => $email);
			$duplicate_mail = $this->seller_model->get_all_details(USERS, $condition);
			if ($duplicate_mail->num_rows() > 0) {
				$this->setErrorMessage('error', 'This email already exists');
				redirect('admin/seller/add_seller_form');
			}
			$excludeArr = array("email", "seller_id", "image", "new_password", "group", "status");
			$user_group = 'Seller';
			$repcode_id = 1;
			if ($this->input->post('status') != '') {
				$user_status = 'Active';
			} else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group, 'email' => $email, 'status' => $user_status, 'repcode_id' => $repcode_id);
			$inputArr['request_status'] = 'Approved';
			$datestring = "%Y-%m-%d";
			$time = time();
			$Image_name = $_FILES['image']['name'];
			if ($Image_name != '') {
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config ['max_width'] = '272';
				$config ['max_height'] = '272';
				$config['upload_path'] = './images/users';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$imgDetails = $this->upload->data();
					$inputArr['image'] = $imgDetails['file_name'];
				} else {
					$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 272*272 px');
					redirect('admin/seller/add_seller_form/');
				}
			}
			$currDAte = date("Y-m-d");
			if ($seller_id == '') {
				$user_data = array(
					'password' => $password,
					'is_verified' => 'No',
					'member_purchase_date' => $currDAte,
					'package_status' => 'Paid',
					'created' => mdate($datestring, $time),
					'modified' => mdate($datestring, $time),
				);
			} else {
				$user_data = array('modified' => mdate($datestring, $time));
			}
			$dataArr = array_merge($inputArr, $user_data);
			$condition = array('id' => $seller_id);
			if ($seller_id == '') {
				$regex_lowercase = '/[a-z]/';
		        $regex_uppercase = '/[A-Z]/';
		        $regex_number = '/[0-9]/';
		         if (preg_match_all($regex_lowercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_uppercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_number, $this->input->post('new_password')) < 1 || strlen($this->input->post('new_password')) < 8)
			        {
			        	$this->setErrorMessage('valid_password', 'Password must be 8 characters (must contain 1 digit and 1 uppercase)');
			            redirect('admin/users/add_user_form/');
			        }
			        else{
			        	$this->seller_model->commonInsertUpdate(USERS, 'insert', $excludeArr, $dataArr, $condition);
						$this->setErrorMessage('success', 'Added successfully');
			        }
				
				/******Mail Function**********/
				$newsid = '45';
				$template_values = $this->product_model->get_newsletter_template_details($newsid);
				if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
					$sender_email = $this->data['siteContactMail'];
					$sender_name = $this->data['siteTitle'];
				} else {
					$sender_name = $template_values['sender_name'];
					$sender_email = $template_values['sender_email'];
				}
				$username = $firstname . $lastname;
				$uid = $insertid;
				$repcode = $rep_code;
				$email = $email;
				$password = $this->input->post('new_password');
				$randStr = $this->get_rand_str('10');
				$logo_mail = $this->data['logo'];
				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);
				$reg = array('username' => $username, 'email' => $email, 'password' => $password, 'email_title' => $sender_name, 'logo' => $logo_mail, 'repcode' => $repcode);
				$message = $this->load->view('newsletter/HostRegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
				/*send mail*/
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
			} else {
				$this->seller_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				$this->setErrorMessage('success', 'Updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}

	public function insertEditRenter1()
	{
		echo "insertEditRenter1";
		die();
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$user_id = $this->input->post('user_id');
			$firstname = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			if ($user_id == '') {
				//$unameArr = $this->config->item('unameArr');
				/*if (!preg_match('/^\w{1,}$/', trim($firstname))){
					$this->setErrorMessage('error','User name not valid. Only alphanumeric allowed');
					echo "<script>window.history.go(-1);</script>";exit;
				}*/
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->seller_model->get_all_details(USERS, $condition);
				if ($duplicate_name->num_rows() > 0) {
					$this->setErrorMessage('error', 'First name already exists');
					redirect('admin/seller/add_seller_form');
				} else {
					$condition = array('email' => $email);
					$duplicate_mail = $this->seller_model->get_all_details(USERS, $condition);
					if ($duplicate_mail->num_rows() > 0) {
						$this->setErrorMessage('error', 'This email already exists');
						redirect('admin/seller/add_seller_form');
					}
				}
			}
			$condition = array('id' => $seller_id);
			$excludeArr = array("user_id", "image", "new_password", "confirm_password", "group", "status");
			$user_group = 'Seller';
			if ($this->input->post('status') != '') {
				$user_status = 'Active';
			} else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group, 'status' => $user_status);
			$inputArr['request_status'] = 'Approved';
			$datestring = "%Y-%m-%d";
			$time = time();
			//$config['encrypt_name'] = TRUE;
			$config['overwrite'] = FALSE;
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			$config['max_size'] = 2000;
			$config['upload_path'] = './images/users';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image')) {
				$imgDetails = $this->upload->data();
				$inputArr['image'] = $imgDetails['file_name'];
			}
			//$MemberList = $this->seller_model->get_all_details(FANCYYBOX,array('id'=>$this->input->post('member_pakage')));
			$currDAte = date("Y-m-d");
			if ($user_id == '') {
				$user_data = array(
					'password' => $password,
					'is_verified' => 'No',
					'member_purchase_date' => $currDAte,
					'package_status' => 'Paid',
					'created' => mdate($datestring, $time),
					'modified' => mdate($datestring, $time),
				);
			} else {
				$user_data = array('modified' => mdate($datestring, $time));
			}
			$dataArr = array_merge($inputArr, $user_data);
			$condition = array('id' => $user_id);
			if ($user_id == '') {
				$this->seller_model->commonInsertUpdate(USERS, 'insert', $excludeArr, $dataArr, $condition);
				$this->setErrorMessage('success', 'Added successfully');
				$insertid = $this->db->insert_id();
				/* Mail function */
				$newsid = '39';
				$template_values = $this->product_model->get_newsletter_template_details($newsid);
				if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
					$sender_email = $this->data['siteContactMail'];
					$sender_name = $this->data['siteTitle'];
				} else {
					$sender_name = $template_values['sender_name'];
					$sender_email = $template_values['sender_email'];
				}
				$username = $firstname . $lastname;
				$uid = $insertid;
				//$username = $usrDetails->row ()->user_name;
				//$email = $usrDetails->row ()->email;
				$randStr = $this->get_rand_str('10');
				$cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
				$logo_mail = $this->data['logo'];
				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);
				$reg = array('username' => $username, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
				//print_r($this->data['logo']);
				$message = $this->load->view('newsletter/UserRegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
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
				/* Mail function End */
			} else {
				//print_r($dataArr);die;
				$this->seller_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				$this->setErrorMessage('success', 'Updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function insert and edit a seller
	 */
	public function insertEditSeller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$user_id = $this->input->post('seller_id');
			$firstname = $this->input->post('firstname');
			$user_name = $this->input->post('firstname');
			$password = md5($this->input->post('new_password'));
			$email = $this->input->post('email');
			$accname = $this->input->post('accname');
			$accno = $this->input->post('accno');
			$bankname = $this->input->post('bankname');
			$paypal_email = $this->input->post('paypal_email');
			if ($user_id == '') {
				$condition = array('firstname' => $firstname);
				$duplicate_name = $this->user_model->get_all_details(USERS, $condition);
				if ($duplicate_name->num_rows() > 0) {
					$this->setErrorMessage('error', 'First name already exists');
					redirect('admin/seller/add_seller_form');
				}
			}
			$excludeArr = array("user_id", "image", "new_password", "confirm_password", "group", "status", "accname", "accno", "bankname", "paypal_email");
			$user_group = 'Seller';
			if ($this->input->post('status') != '') {
				$user_status = 'Active';
			} else {
				$user_status = 'Inactive';
			}
			$inputArr = array('group' => $user_group, 'email' => $email, 'status' => $user_status, 'user_name' => $user_name, "accname" => $accname, "accno" => $accno, "bankname" => $bankname, "paypal_email" => $paypal_email);
			$inputArr['request_status'] = 'Approved';
			$datestring = "%Y-%m-%d";
			$time = time();
			$Image_name = $_FILES['image']['name'];
			if ($Image_name != '') {
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000000;
				$config ['max_width'] = '272';
				$config ['max_height'] = '272';
				$config['upload_path'] = './images/users';
				$this->load->library('upload', $config);
				if ($this->upload->do_upload('image')) {
					$imgDetails = $this->upload->data();
					$inputArr['image'] = $imgDetails['file_name'];
					/* Compress */
					$source_photo = './images/users/' . $imgDetails['file_name'] . '';
					$dest_photo = './images/users/' . $imgDetails['file_name'];
					$this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
					/* End Compress */
				} else {
					$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 272*272 px');
					redirect('admin/seller/edit_seller_form/' . $user_id);
				}
			}
			if ($user_id == '') {
				$user_data = array(
					'password' => $password,
					'is_verified' => 'No',
					'created' => mdate($datestring, $time),
					'modified' => mdate($datestring, $time),
				);
			} else {
				$user_data = array('modified' => mdate($datestring, $time));
			}
			$dataArr = array_merge($inputArr, $user_data);
			$excludeArr = array("user_id", "confirm-password", "password", "new_password", "confirm_password", "accname", "accno", "bankname", "paypal_email");
			$condition = array('id' => $user_id);
			if ($user_id == '') {
				
				$regex_lowercase = '/[a-z]/';
		        $regex_uppercase = '/[A-Z]/';
		        $regex_number = '/[0-9]/';
		      	if (preg_match_all($regex_lowercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_uppercase, $this->input->post('new_password')) < 1 || preg_match_all($regex_number, $this->input->post('new_password')) < 1 || strlen($this->input->post('new_password')) < 6)
			        {

			            $this->setErrorMessage('valid_password', 'The field must be at least 1 lowercase, 1 uppercase, 1 number.');
			            redirect('admin/seller/add_seller_form');
			        }
			        else{
			        	$this->user_model->commonInsertUpdate(USERS, 'insert', $excludeArr, $dataArr, $condition);
						$this->setErrorMessage('success', 'User added successfully');
			        }
				
			} else {
				$this->user_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				$regex_lowercase = '/[a-z]/';
		        $regex_uppercase = '/[A-Z]/';
		        $regex_number = '/[0-9]/';
				if ($this->input->post('password') != '') {
					if (preg_match_all($regex_lowercase, $this->input->post('password')) < 1 || preg_match_all($regex_uppercase, $this->input->post('password')) < 1 || preg_match_all($regex_number, $this->input->post('password')) < 1 || strlen($this->input->post('password')) < 6)
			        {
			        	$this->setErrorMessage('valid_password', 'Password must be 8 characters (must contain 1 digit and 1 uppercase)');
			            redirect('admin/seller/edit_seller_form/' . $user_id);
			        }
			        else{
			        	$pwd = $this->input->post('password');
						$newdata = array('password' => md5($pwd));
						$this->user_model->update_details(USERS, $newdata, $condition);
			        }
					
				}
				$this->setErrorMessage('success', 'Host updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}

	public function insertEditSeller1()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$seller_id = $this->input->post('seller_id');
			$email = $this->input->post('email');
			$excludeArr = array("seller_id", "confirm_password", "password", "email");
			$dataArr = array();
			$condition = array('id' => $seller_id);
			if ($this->input->post('password') != '') {
				$pwd = $this->input->post('password');
				$newdata = array('password' => md5($pwd));
				$this->seller_model->update_details(USERS, $newdata, $condition);
				$this->send_user_password($pwd, $email);
			}
			if ($seller_id == '') {
				$this->seller_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				$this->setErrorMessage('success', 'User added successfully');
			} else {
				$this->seller_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
				$this->setErrorMessage('success', 'User updated successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}

	public function send_user_password($pwd = '', $email)
	{
		$newsid = '5';
		$template_values = $this->seller_model->get_newsletter_template_details($newsid);
		$adminnewstemplateArr = array(
			'email_title' => $this->config->item('email_title'),
			'logo' => $this->data ['logo']
		);
		extract($adminnewstemplateArr);
		$subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values ['news_subject'];
		$message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values ['news_subject'] . '</title>
			<body>';
		include('./newsletter/registeration' . $newsid . '.php');
		$message .= '</body>
			</html>';
		if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
			$sender_email = $this->config->item('site_contact_mail');
			$sender_name = $this->config->item('email_title');
		} else {
			$sender_name = $template_values ['sender_name'];
			$sender_email = $template_values ['sender_email'];
		}
		$email_values = array(
			'mail_type' => 'html',
			'from_mail_id' => $sender_email,
			'mail_name' => $sender_name,
			'to_mail_id' => $email,
			'subject_message' => 'Password Reset',
			'body_messages' => $message
		);
		$email_send_to_common = $this->seller_model->common_email_send($email_values);
	}

	/**
	 *
	 * This function change the seller request status
	 */
	public function change_seller_request()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Rejected' : 'Approved';
			$newdata = array('request_status' => $status);
			if ($status == 'Rejected') {
				$newdata['group'] = 'User';
			} else if ($status == 'Approved') {
				$newdata['group'] = 'Seller';
			}
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'Host Request ' . $status . ' Successfully');
			redirect('admin/seller/display_seller_requests');
		}
	}

	/**
	 *
	 * This function change the seller status
	 */
	public function change_seller_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Rejected' : 'Approved';
			$newdata = array('request_status' => $status);
			if ($status == 'Rejected') {
				$newdata['group'] = 'User';
			} else if ($status == 'Approved') {
				$newdata['group'] = 'Seller';
			}
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function loads the add new seller form
	 */
	public function add_seller_form()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Add New Host';
			$sortArr1 = array('field' => 'name', 'type' => 'asc');
			$sortArr = array($sortArr1);
			$this->data['member_details'] = $this->seller_model->get_all_details(FANCYYBOX, array('status' => 'Publish'), $sortArr);
			$this->data['query'] = $this->seller_model->get_rep_all_details();
			$this->load->view('admin/seller/add_seller', $this->data);
		}
	}

	/**
	 *
	 * This function loads the edit seller form
	 */
	public function edit_seller_form()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Edit Host';
			$user_id = $this->uri->segment(4, 0);
			$condition = array('id' => $user_id);
			$this->data['seller_details'] = $this->seller_model->get_all_details(USERS, $condition);
			$this->data['user_details'] = $this->user_model->get_all_details(USERS, $condition);
			$this->data['user_idProof'] = $this->user_model->get_all_details(ID_PROOF, array('user_id' => $user_id));
			$this->data['member_details'] = $this->seller_model->get_all_details(FANCYYBOX, array('status' => 'Publish'), $sortArr);
			$this->data['query'] = $this->seller_model->get_rep_all_details();
			$country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
			$this->data ['active_countries'] = $this->cms_model->ExecuteQuery($country_query);
			if ($this->data['seller_details']->num_rows() == 1 && $this->data['seller_details']->row()->group == 'Seller') {
				$this->load->view('admin/seller/edit_seller', $this->data);
			} else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function to update seller id proof
	 */
	public function update_host_id_proof()
	{
		if (isset($_POST['submit'])) {
			$ids = $this->input->post('id');
			$status = $this->input->post('status');
			$user_id = $this->input->post('user_id');
			$declineStatus = $this->input->post('decline_status');


			foreach ($ids as $id) {
				if (isset($status[$id]) && $declineStatus == 'on') {
					echo "NoProcess";
				} else if (isset($status[$id])) {
					$this->db->set('id_proof_status', 'Verified');
					$this->db->where('id', $id);
					$this->db->update(ID_PROOF);
					$this->setErrorMessage('success', 'Seller Proof Verified successfully');
					/* Mail to Host*/
					/* Mail function */
					$newsid = '54';
					$template_values = $this->product_model->get_newsletter_template_details($newsid);
					if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
						$sender_email = $this->data['siteContactMail'];
						$sender_name = $this->data['siteTitle'];
					} else {
						$sender_name = $template_values['sender_name'];
						$sender_email = $template_values['sender_email'];
					}
					$condition = array(
						'id' => $user_id
					);
					$usrDetails = $this->user_model->get_all_details(USERS, $condition);
					$uid = $usrDetails->row()->id;
					$username = $usrDetails->row()->user_name;
					$email = $usrDetails->row()->email;
					$randStr = $this->get_rand_str('10');
					$email_values = array(
						'from_mail_id' => $sender_email,
						'to_mail_id' => $email,
						'subject_message' => $template_values ['news_subject'],
						'body_messages' => $message
					);
					$reg = array('hostname' => $username,'logo' => $this->data['logo']);
					$message = $this->load->view('newsletter/Admin - ID Proof verified' . $newsid . '.php', $reg, TRUE);
					$this->load->library('email');
					$this->email->from($email_values['from_mail_id'], $sender_name);
					$this->email->to($email_values['to_mail_id']);
					$this->email->subject($email_values['subject_message']);
					$this->email->set_mailtype("html");
					$this->email->message($message);
					if ($this->email->send()) {
						echo "Success";
					} else {
						echo $this->email->print_debugger();
					}
				} else {
					$this->db->set('id_proof_status', 'UnVerified'); /*value that used to update column*/
					$this->db->where('id', $id); /*which row want to upgrade*/
					$this->db->update(ID_PROOF);
					$this->setErrorMessage('success', 'Seller Proof Verified successfully');
				}
			}
			if ($declineStatus == 'on') {
				$this->db->set('decline_status', 'Yes');
				$this->db->set('id_proof_status', 'UnVerified');
				$this->db->where('user_id', $user_id);
				$this->db->update(ID_PROOF);
				$this->setErrorMessage('success', 'Status Updated successfully');
				/* Mail To Host*/
				/* Mail function */
				$newsid = '55';
				$template_values = $this->product_model->get_newsletter_template_details($newsid);
				if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
					$sender_email = $this->data['siteContactMail'];
					$sender_name = $this->data['siteTitle'];
				} else {
					$sender_name = $template_values['sender_name'];
					$sender_email = $template_values['sender_email'];
				}
				$condition = array(
					'id' => $user_id
				);
				$usrDetails = $this->user_model->get_all_details(USERS, $condition);
				$uid = $usrDetails->row()->id;
				$username = $usrDetails->row()->user_name;
				$email = $usrDetails->row()->email;
				$randStr = $this->get_rand_str('10');
				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);
				$reg = array('hostname' => $username,'logo' => $this->data['logo']);
				$message = $this->load->view('newsletter/Admin - Request to Host to Send another ID Proof' . $newsid . '.php', $reg, TRUE);
				/*send mail*/
				$this->load->library('email', $config);
				$this->email->from($email_values['from_mail_id'], $sender_name);
				$this->email->to($email_values['to_mail_id']);
				$this->email->subject($email_values['subject_message']);
				$this->email->set_mailtype("html");
				$this->email->message($message);
				if ($this->email->send()) {
					echo "Success";
				} else {
					echo $this->email->print_debugger();
				}
				/* Mail function End */
				/* Mail To Host End*/
			} else {
				$this->db->set('decline_status', 'No');
				$this->db->where('user_id', $user_id);
				$this->db->update(ID_PROOF);
				$this->setErrorMessage('success', 'Status Updated successfully');
			}
		}
		redirect('admin/seller/display_seller_list');
	}

	/**
	 *
	 * This function loads the seller view page
	 */
	public function view_seller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'View Host';
			$seller_id = $this->uri->segment(4, 0);
			$condition = array('id' => $seller_id);
			$this->data['seller_details'] = $this->seller_model->get_all_details(USERS, $condition);
			if ($this->data['seller_details']->num_rows() == 1) {
				$this->load->view('admin/seller/view_seller', $this->data);
			} else {
				redirect('admin');
			}
		}
	}

	/**
	 *
	 * This function delete the seller record from db
	 */
	public function delete_seller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$seller_id = $this->uri->segment(4, 0);
			$act = 1;
			$this->db->reconnect();
			$this->db->where('id', $seller_id);
			$this->db->set(array('host_status'=>$act,'status'=>'Inactive'));
			$this->db->update(USERS);
			$this->db->reconnect();
			$this->db->where('user_id', $seller_id);
			$this->db->set('host_status', $act);
			$this->db->update(PRODUCT);
			$this->setErrorMessage('success', 'Host deleted successfully');
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function delete the update seller record from db
	 */
	public function update_seller()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$seller_id = $this->uri->segment(4, 0);
			$act = 0;
			$this->db->reconnect();
			$this->db->where('id', $seller_id);
			$this->db->set('host_status', $act);
			$this->db->update(USERS);
			$this->db->reconnect();
			$this->db->where('user_id', $seller_id);
			$this->db->set('host_status', $act);
			$this->db->update(PRODUCT);
			$this->setErrorMessage('success', 'Host Updated successfully');
			redirect('admin/seller/display_archieve_seller');
		}
	}

	/**
	 *
	 * This function delete the seller request records
	 */
	public function change_seller_status_global()
	{
		if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') {
			$this->seller_model->activeInactiveCommon(USERS, 'id');
			if (strtolower($_POST['statusMode']) == 'delete') {
				$this->setErrorMessage('success', 'Host records deleted successfully');
			} else {
				$this->setErrorMessage('success', 'Host records status changed successfully');
			}
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function change host status
	 */
	public function change_user_status()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}
	
	
	public function change_user_verification()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'No' : 'Yes';
			$newdata = array('is_verified' => $status,'id_verified'=>'Yes');
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS, $newdata, $condition);
			
			/* Mail function */
			if($status == 'Yes'){
				$newsid = '73';
				$template_values = $this->product_model->get_newsletter_template_details($newsid);
				if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
					$sender_email = $this->data['siteContactMail'];
					$sender_name = $this->data['siteTitle'];
				} else {
					$sender_name = $template_values['sender_name'];
					$sender_email = $template_values['sender_email'];
				}
				$condition = array(
					'id' => $user_id
				);
				$usrDetails = $this->user_model->get_all_details(USERS, $condition);
				$uid = $usrDetails->row()->id;
				$username = $usrDetails->row()->user_name;
				$email = $usrDetails->row()->email;
				$email_values = array(
					'from_mail_id' => $sender_email,
					'to_mail_id' => $email,
					'subject_message' => $template_values ['news_subject'],
					'body_messages' => $message
				);
				$reg = array('hostname' => $username,'logo' => $this->data['logo']);
				$message = $this->load->view('newsletter/Admin - Account verified' . $newsid . '.php', $reg, TRUE);
				$this->load->library('email');
				$this->email->from($email_values['from_mail_id'], $sender_name);
				$this->email->to($email_values['to_mail_id']);
				$this->email->subject($email_values['subject_message']);
				$this->email->set_mailtype("html");
				$this->email->message($message);
				if ($this->email->send()) {
					echo "Success";
				} else {
					echo $this->email->print_debugger();
				}
			}
					
			$this->setErrorMessage('success', 'Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function verify host status
	 */
	public function verify_user_status()
	{
		echo("inside function");
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'No' : 'Yes';
			$newdata = array('is_verified' => $status);
			$condition = array('id' => $user_id);
			$this->seller_model->update_details(USERS, $newdata, $condition);
			$this->setErrorMessage('success', 'Host Status Changed Successfully');
			redirect('admin/seller/display_seller_list');
		}
	}

	/**
	 *
	 * This function verify host status
	 */
	public function verify_user_liststatus()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$mode = $this->uri->segment(4, 0);
			$user_id = $this->uri->segment(5, 0);
			$status = ($mode == '0') ? 'Inactive' : 'Active';
			$other = ($mode == '0') ? 'No' : 'Yes';
			$newdata = array('status' => $status,'other' => $other);
			$condition = array('id' => $user_id);
			$ListSpac_type = $this->user_model->get_all_details(LISTSPACE_VALUES, array('id' => $user_id,'status'=> 'Active'));
			//echo $ListSpac_type->row()->listspace_id;exit();
			if($ListSpac_type->row()->listspace_id == '9')
			{
				$ListSpac_Details = $this->user_model->get_all_details(LISTSPACE_VALUES, array('status'=> 'Active','listspace_id' => '9'));
			}
		else
			{
				$ListSpac_Details = $this->user_model->get_all_details(LISTSPACE_VALUES, array('status'=> 'Active','listspace_id' => '10'));
			}

			// print_r($ListSpac_Details->num_rows());exit();
		if($ListSpac_Details->num_rows() != 1 || $status == 'Active')
			{
				$this->seller_model->update_details(LISTSPACE_VALUES, $newdata, $condition);
					if ($mode == '1')
					{
						$this->setErrorMessage('success', 'Listspace Value Activated Successfully');
					} 
					else
					{
					$this->setErrorMessage('success', 'Listspace Value Inactivated Successfully');
					}
			}
			else
			{
			$this->setErrorMessage('error', 'Atleast One Should Active');
			}
			redirect('admin/listattribute/display_listspace_values');
		}
	}

	/**
	 *
	 * This function updates refund
	 */
	public function update_refund()
	{
		if ($this->checkLogin('A') != '') {
			$uid = $this->input->post('uid');
			$refund_amount = $this->input->post('amt');
			if ($uid != '') {
				$this->seller_model->update_details(USERS, array('refund_amount' => $refund_amount), array('id' => $uid));
			}
		}
	}

	/* Export Excel function */
	public function customerExcelExport()
	{
		$sortArr = array('field' => 'id', 'type' => 'desc');
		$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
		if ($rep_code != '') {
			$condition = array('group' => 'Seller', 'rep_code' => $rep_code);
		} else {
			$condition = array('group' => 'Seller');
		}
		$UserDetails = $this->user_model->get_all_details(USERS, $condition);
		$data['getCustomerDetails'] = $UserDetails->result_array();
		//exit();
		$this->load->view('admin/seller/customerExportExcel', $data);
	}

	/**
	 *
	 * This function verifys seller email
	 */
	public function check_seller_email_exist()
	{
		$email_id = $_POST['email_id'];
		$this->data['exist'] = $this->seller_model->check_seller_email_exist($email_id);
		if ($this->data['exist']->num_rows() > 0) {
			echo "1";
		}
	}
}

/* End of file seller.php */
/* Location: ./application/controllers/admin/seller.php */
