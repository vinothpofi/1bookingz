<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* This controller contains the functions related to sub-admin management 
* @author Teamtweaks
*
*/

class Responsitary extends MY_Controller {
  function __construct(){
	parent::__construct();
	  $this->load->helper(array('cookie','date','form'));
	  $this->load->library(array('encrypt','form_validation'));		
	  $this->load->model('subadmin_model');
	  if ($this->checkPrivileges('RESPONSITARY',$this->privStatus) == FALSE){
	  redirect('admin');
	}
  }

  /**
  * 
  * This function loads the Sub Admin users list
  */
  public function display_responsitary(){
	  if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $this->data['heading'] = 'Responsitary List';
	  $condition = array();
	  $this->data['admin_users'] = $this->subadmin_model->get_all_details(RESPONSITARY,$condition);
	  $this->load->view('admin/responsitary/display_responsitary',$this->data);
	}
  }

  /**
  * 
  * This function change the Sub Admin user status
  */
  public function change_responsitary_status(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $mode = $this->uri->segment(4,0);
	  $adminid = $this->uri->segment(5,0);
	  $status = ($mode == '0')?'Inactive':'Active';
	  $newdata = array('status' => $status);
	  $condition = array('id' => $adminid);
	  $this->subadmin_model->update_details(RESPONSITARY,$newdata,$condition);
	  $this->setErrorMessage('success','Responsitary Status Changed Successfully');
	  redirect('admin/responsitary/display_responsitary');
	}
  }

  /**
  * 
  * This function loads the add subadmin form 
  */
  public function add_responsitary_form(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $this->data['heading'] = 'Add Responsitary';
	  $condition = array();
	  $this->load->view('admin/responsitary/add_responsitary',$this->data);
	}
  }

  /**
  * 
  * This function insert and edit a Sub Admin and his privileges
  */
  public function insertEditResponsitary(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $subadminid = $this->input->post('subadminid');
	  $sub_admin_name=$this->input->post('name');
	  $admin_name = $this->input->post('admin_name');
	  $admin_password = md5($this->input->post('admin_password'));
	  $email = $this->input->post('email');
	  if ($subadminid == ''){
	  $condition = array('email' => $email);
	  $duplicate_admin= $this->subadmin_model->get_all_details(ADMIN,$condition);
		if ($duplicate_admin->num_rows() > 0){
		  $this->setErrorMessage('error','Admin email already exists');
		  redirect('admin/responsitary/add_sub_admin_form');
		}else {
		  $duplicate_email = $this->subadmin_model->get_all_details(RESPONSITARY,$condition);
		  if ($duplicate_email->num_rows() > 0){
			$this->setErrorMessage('error','Responsitary email already exists');
			redirect('admin/responsitary/add_responsitary_form');
		  }else {
			$condition = array('admin_name' => $admin_name);
			$duplicate_adminname = $this->subadmin_model->get_all_details(ADMIN,$condition);
			if ($duplicate_adminname->num_rows() > 0){
			  $this->setErrorMessage('error','Admin name already exists');
			  redirect('admin/responsitary/add_responsitary_form');
			}else {
			  $duplicate_name = $this->subadmin_model->get_all_details(RESPONSITARY,$condition);
			  if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','Responsitary name already exists');
				redirect('admin/responsitary/add_responsitary_form');
			  }
			}
		  }
		}
	  }
	  $excludeArr = array("email","subadminid","name","admin_name","admin_password");
	  $privArr = array();
	  foreach ($this->input->post() as $key => $val){
	    if (!in_array($key, $excludeArr)){
		  $privArr[$key] = $val;
		}
	  }
	  $inputArr = array('privileges' => serialize($privArr));
	  $datestring = "%Y-%m-%d";
	  $time = time();
	  if ($subadminid == ''){
	  $admindata = array(
		'name'         =>$sub_admin_name,
		'admin_name'	=>	$admin_name,
		'admin_password'	=>	$admin_password,
		'email'	=>	$email,
		'created'	=>	mdate($datestring,$time),
		'modified'	=>	mdate($datestring,$time),
		'admin_type'	=>	'sub',
		'is_verified'	=>	'Yes',
		'status'	=>	'Active');
	  }else {
		$admindata = array('modified' =>	mdate($datestring,$time),'name' =>$sub_admin_name);
	  }
	  $dataArr = array_merge($admindata,$inputArr);
	  $condition = array('id' => $subadminid);
	  $this->subadmin_model->add_edit_subadmin($dataArr,$condition);
	  if ($subadminid == ''){
		$this->setErrorMessage('success','Responsitary added successfully');
	  }else {
		$this->setErrorMessage('success','Responsitary updated successfully');
	  }
	  redirect('admin/responsitary/display_responsitary');
	}
  }

  /**
  * 
  * This function loads the edit subadmin form
  */
  public function edit_responsitary_form(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $this->data['heading'] = 'Edit Responsitary';
	  $adminid = $this->uri->segment(4,0);
	  $condition = array('id' => $adminid);
	  $this->data['admin_details'] = $this->subadmin_model->get_all_details(RESPONSITARY,$condition);
	  if ($this->data['admin_details']->num_rows() == 1){
		$this->data['privArr'] = unserialize($this->data['admin_details']->row()->privileges);
		if (!is_array($this->data['privArr'])){
		  $this->data['privArr'] = array();
		}
	    $this->load->view('admin/responsitary/edit_responsitary',$this->data);
	  }else {
		redirect('admin');
	  }
	}
  }

  /**
  * 
  * This function loads the subadmin view page
  */
  public function view_responsitary(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $this->data['heading'] = 'View Sub-Admin';
	  $adminid = $this->uri->segment(4,0);
	  $condition = array('id' => $adminid);
	  $this->data['admin_details'] = $this->subadmin_model->get_all_details(RESPONSITARY,$condition);
	  if ($this->data['admin_details']->num_rows() == 1){
		$this->data['privArr'] = unserialize($this->data['admin_details']->row()->privileges);
		if (!is_array($this->data['privArr'])){
		  $this->data['privArr'] = array();
		}
		$this->load->view('admin/responsitary/view_responsitary',$this->data);
	  }else {
		redirect('admin');
	  }
	}
  }

  /**
  * 
  * This function delete the subadmin record from db
  */
  public function delete_responsitary(){
	if ($this->checkLogin('A') == ''){
	  redirect('admin');
	}else {
	  $subadmin_id = $this->uri->segment(4,0);
	  $condition = array('id' => $subadmin_id);
	  $this->subadmin_model->commonDelete(RESPONSITARY,$condition);
	  $this->setErrorMessage('success','Responsitary deleted successfully');
	  redirect('admin/responsitary/display_responsitary');
	}
  }

  /**
  * 
  * This function change the subadmin status, delete the subadmin record
  */
  public function change_responsitary_status_global(){
	if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
	  $this->subadmin_model->activeInactiveCommon(RESPONSITARY,'id');
	  if (strtolower($_POST['statusMode']) == 'delete'){
		$this->setErrorMessage('success','Responsitary records deleted successfully');
	  }else {
		$this->setErrorMessage('success','Responsitary records status changed successfully');
	  }
	  redirect('admin/responsitary/display_responsitary');
	}
  }
}

/* End of file subadmin.php */
/* Location: ./application/controllers/admin/subadmin.php */