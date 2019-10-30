<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to Attribute management 
 * Attribute mentioned as 'List'
 * @author Teamtweaks
 *
 */ 

class Rentaltype extends MY_Controller {
 
	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('attribute_model');
		if ($this->checkPrivileges('ListSpace',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the attribute list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			//redirect('admin/attribute/display_attribute_list');
			$this->data['heading'] = 'Rental Type Details';
			$this->data['attributeList'] = $this->attribute_model->get_all_details(RENTAL_TYPE_MASTER, array());//'lang'=>'en'
			$this->load->view('admin/attribute/rental_type_list',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the attribute list page
	 */
	public function display_attribute_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'List Details';
			$this->data['attributeList'] = $this->attribute_model->view_attribute_details();
			$this->load->view('admin/attribute/display_attribute_list',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the attribute list space page
	 */
	public function display_attribute_listspace()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Rental &nbsp;Type &nbsp;Details';
			$this->data['attributeList'] = $this->attribute_model->get_all_details(LISTSPACE, array('lang'=>'en'));
			$this->load->view('admin/attribute/display_attribute_listspace',$this->data);
		}
	}

	public function add_Rentaltype_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
		}
	}
	/**
	 * 
	 * This function loads the list values page
	 */
	public function display_list_values(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'List Values';
			$this->data['listValues'] = $this->attribute_model->get_list_values();
			//echo $this->db->last_query();die;
			$this->load->view('admin/attribute/display_list_values',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the list space values page
	 */
	public function display_listspace_values()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Rental Type Values';
			$this->data['listValues'] = $this->attribute_model->get_listspace_values();
			$this->load->view('admin/attribute/display_listspace_values',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new attribute form
	 */
	public function add_attribute_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New List';
			$this->data['Attribute_id'] = $this->uri->segment(4,0);
			$this->load->view('admin/attribute/add_attribute',$this->data);
		}
	}
	
	public function add_attribute_listform(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New List';
			$this->data['Attribute_id'] = $this->uri->segment(4,0);
			$this->load->view('admin/attribute/addlist_attribute',$this->data);
		}
	}
	
	
	
	/**
	 * 
	 * This function insert attribute
	 */
	public function insertAttribute(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			echo '<pre>';print_r($_POST);die;
			$attribute_name = $this->input->post('attribute_name');
			if($attribute_name ==''){
				$this->setErrorMessage('error','Please enter list name');
				redirect('admin/attribute/add_attribute_form/');
			}
			
			
			
			$condition = array('attribute_name' => $attribute_name);
			$duplicate_name = $this->attribute_model->get_all_details(ATTRIBUTE,$condition);
			if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','List name already exists');
				redirect('admin/attribute/add_attribute_form/');
			}
			$seourl = url_title($attribute_name,'',TRUE);
			$excludeArr = array("status");
			
			if ($this->input->post('status') != ''){
				$attribute_status = 'Active';
			}else {
				$attribute_status = 'Inactive';
			}
			
			$dataArr = array( 'attribute_name' => $attribute_name,'status' => $attribute_status,'attribute_seourl'=>$seourl );
			
			$this->attribute_model->add_attribute($dataArr);
			$this->setErrorMessage('success','List added successfully');
			redirect('admin/attribute/display_attribute_list');
		}
	}
	
	
	public function insertAttributelist(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$attribute_name = $this->input->post('attribute_name');
			if($attribute_name ==''){
				$this->setErrorMessage('error','Please enter listspace name');
				redirect('admin/Rentaltype/add_attribute_listform/');
			}
			
			
			
			$condition = array('attribute_name' => $attribute_name);
			$duplicate_name = $this->attribute_model->get_all_details(LISTSPACE,$condition);
			if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','List name already exists');
				redirect('admin/Rentaltype/add_attribute_listform/');
			}
			$seourl = url_title($attribute_name,'',TRUE);
			$excludeArr = array("status");
			
			if ($this->input->post('status') != ''){
				$attribute_status = 'Active';
			}else {
				$attribute_status = 'Inactive';
			}
			
			$dataArr = array( 'attribute_name' => $attribute_name,'attribute_description'=>$this->input->post('attribute_description'),'status' => $attribute_status,'attribute_seourl'=>$seourl );
			
			$this->attribute_model->addlist_attribute($dataArr);
			$this->setErrorMessage('success','List added successfully!!');
			redirect('admin/Rentaltype/display_attribute_listspace');
		}
	}
	
	/**
	 * 
	 * This function Edit attribute
	 */
	public function EditAttribute(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
		

			$attribute_id = $this->input->post('attribute_id');			
			$attribute_name = $this->input->post('attribute_name');
			
			$condition = array('id' => $attribute_id);

			$excludeArr = array("status");
			$seourl = url_title($attribute_name,'',TRUE);
			$dataArr = array( 'attribute_name' => $attribute_name,'status' => 'Active','attribute_seourl'=>$seourl );
			
			$this->attribute_model->edit_attribute($dataArr,$condition);
			$this->setErrorMessage('success','List updated successfully');
			redirect('admin/attribute/display_attribute_list');
		}
	}
	
	/**
	 * 
	 * This function Edit list attribute details
	 */
	public function EditRentaltype()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{	

			$attribute_id = $this->input->post('attribute_id');			
			$attribute_name = $this->input->post('attribute_name');			
			$condition = array('id' => $attribute_id);

			$excludeArr = array("status");
			$seourl = url_title($attribute_name,'',TRUE);
			$dataArr = array( 'attribute_name' => $attribute_name,'status' => 'Active');
			
			$this->attribute_model->edit_Rentaltype($dataArr,$condition);
			$this->setErrorMessage('success','List updated successfully');
			redirect('admin/Rentaltype/display_attribute_listspace');
		}
	}
		
	
	/**
	 * 
	 * This function loads the edit attribute form
	 */
	public function edit_attribute_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit List';
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->data['attribute_details'] = $this->attribute_model->view_attribute($condition);
			if ($this->data['attribute_details']->num_rows() == 1){
				$this->load->view('admin/attribute/edit_attribute',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function loads the edit list form
	 */
	public function edit_Rentaltype_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Edit List';
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->data['attribute_details'] = $this->attribute_model->view_Rentaltype($condition);

			if ($this->data['attribute_details']->num_rows() == 1)
			{
				$this->load->view('admin/attribute/edit_Rentaltype',$this->data);
			}
			else
			{
				redirect('admin');
			}
		}
	}

	/**
	 * 
	 * This function loads the edit list value form
	 */
	public function edit_list_value_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit List Value';
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->data['list_value_details'] = $this->attribute_model->get_all_details(LIST_VALUES,$condition);
			if ($this->data['list_value_details']->num_rows() == 1){
				$this->data['list_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
				$this->load->view('admin/attribute/edit_list_value',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function load edit list space form
	 */
	public function edit_listSpace_value_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else 
		{
			$this->data['heading'] = 'Edit Rental Type Value';
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->data['list_value_details'] = $this->attribute_model->get_all_details(LISTSPACE_VALUES,$condition);

			if ($this->data['list_value_details']->num_rows() == 1)
			{
				$this->data['list_details'] = $this->attribute_model->get_all_details(LISTSPACE,array('status'=>'Active', 'lang'=>'en'));
				$this->load->view('admin/attribute/edit_listspace_value',$this->data);
			}
			else
			{
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function change the attribute status
	 */
	public function change_attribute_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$mode = $this->uri->segment(4,0);
			$attribute_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $attribute_id);
			$this->attribute_model->update_details(ATTRIBUTE,$newdata,$condition);
			$this->setErrorMessage('success','List Status Changed Successfully');
			redirect('admin/attribute/display_attribute_list');
		}
	}
	
	/**
	 * 
	 * This function change the list attribute status
	 */
	public function change_Rentaltype_status()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$mode = $this->uri->segment(4,0);
			$attribute_id = $this->uri->segment(5,0);
			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $attribute_id);
			$this->attribute_model->update_details(LISTSPACE,$newdata,$condition);
			$this->setErrorMessage('success','List Status Changed Successfully');
			redirect('admin/Rentaltype/display_attribute_listspace');
		}
	}
	
	/**
	 * 
	 * This function loads the attribute view page
	 */
	public function view_attribute(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View List';
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->data['attribute_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,$condition);
			if ($this->data['attribute_details']->num_rows() == 1){
				$this->load->view('admin/attribute/view_attribute',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	
	public function view_Rentaltype(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View List';
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->data['attribute_details'] = $this->attribute_model->get_all_details(LISTSPACE,$condition);
			if ($this->data['attribute_details']->num_rows() == 1){
				$this->load->view('admin/attribute/view_Rentaltype',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the attribute record from db
	 */
	public function delete_attribute(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->attribute_model->commonDelete(ATTRIBUTE,$condition);
			$this->setErrorMessage('success','List deleted successfully');
			redirect('admin/attribute/display_attribute_list');
		}
	}
	
	public function delete_Rentaltype(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$attribute_id = $this->uri->segment(4,0);
			$condition = array('id' => $attribute_id);
			$this->attribute_model->commonDelete(LISTSPACE,$condition);
			$this->setErrorMessage('success','List deleted successfully');
			redirect('admin/Rentaltype/display_attribute_listspace');
		}
	}

	/**
	 * 
	 * This function delete the list value from db
	 */
	public function delete_list_value(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->attribute_model->commonDelete(LIST_VALUES,$condition);
			$this->setErrorMessage('success','List value deleted successfully');
			redirect('admin/attribute/display_list_values');
		}
	}
	
	
		public function delete_listspace_value(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->attribute_model->commonDelete(LISTSPACE_VALUES,$condition);
			$this->setErrorMessage('success','List value deleted successfully');
			redirect('admin/Rentaltype/display_listspace_values');
		}
	}
	
	/**
	 * 
	 * This function change the attribute status, delete the attribute record
	 */
	public function change_attribute_status_global(){
	
		if($this->input->post('checkboxID')!=''){
		
		
			if($this->input->post('checkboxID')=='0'){
				redirect('admin/attribute/add_attribute_form/0');
			}else{
				redirect('admin/attribute/add_attribute_form/'.$this->input->post('checkboxID'));			
			}
	
		}else{
		
			if(count($this->input->post('checkbox_id')) > 0 &&  $this->input->post('statusMode') != ''){
			
				$this->attribute_model->activeInactiveCommon(LISTSPACE,'id');
				//echo $this->db->last_query();exit;
				if (strtolower($this->input->post('statusMode')) == 'delete'){
					$this->setErrorMessage('success','Attribute records deleted successfully');
				}else {
					$this->setErrorMessage('success','Attribute records status changed successfully');
				}
				
				redirect('admin/Rentaltype/display_attribute_listspace');
			}
		}
	}

	/**
	 * 
	 * This function delete the list value record
	 */
	public function change_list_value_status_global(){
	
		if(count($this->input->post('checkbox_id')) > 0 &&  $this->input->post('statusMode') != ''){
			$this->attribute_model->activeInactiveCommon_new(LISTSPACE_VALUES,'id');
			if (strtolower($this->input->post('statusMode')) == 'delete'){
				$this->setErrorMessage('success','List values deleted successfully');
			}
			redirect('admin/Rentaltype/display_listspace_values');
		}
	}
	
	/**
	 * 
	 * This function loads the add new attribute form
	 */
	public function add_list_value_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add List Value';
			$this->data['list_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
			$this->load->view('admin/attribute/add_list_value',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new list space form
	 */
	public function add_listspace_value_form()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->data['heading'] = 'Add Rental Type Value';
			$this->data['listspace_details'] = $this->attribute_model->get_all_details(LISTSPACE,array('status'=>'Active'));			
			$this->load->view('admin/attribute/add_listspace_value',$this->data);
		}
	}
	
	
	public function insertEditListValue(){
	
	    $list_id = $this->input->post('list_name');
		
		
		if ($list_id == ''){
			$this->setErrorMessage('error','Select the list');
			echo "<script>window.history.go(-1)</script>";
		}else {
			$lvID = $this->input->post('lvID');
			$list_value = $this->input->post('list_value');
			$seourl = url_title($list_value,'',TRUE);
			if ($lvID == ''){
				$dataArr = array(
					'list_id'	=>	$list_id,
					'list_value'=>	$list_value
				);
			}else {
				$dataArr = array(
					'id !='		=>	$lvID,
					'list_id'	=>	$list_id,
					'list_value'=>	$list_value
				);
			}
			$duplicateCheck = $this->attribute_model->get_all_details(LIST_VALUES,$dataArr);
			$dataArr = array(
				'list_id'	=>	$list_id,
				'list_value'=>	$list_value,
				'list_value_seourl'=> $seourl
			);
			 $config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/attribute/';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
		    	$imgDetails = $this->upload->data();
		    	$dataArr['image'] = $imgDetails['file_name'];
			}
			if ($duplicateCheck->num_rows()==0){
				if ($lvID == ''){
					$this->attribute_model->simple_insert(LIST_VALUES,$dataArr);
					$this->setErrorMessage('success','List value inserted successfully');
				}else {
					$condition = array('id'=>$lvID);
					$this->attribute_model->update_details(LIST_VALUES,$dataArr,$condition);
					$this->setErrorMessage('success','List value updated successfully');
				}
				redirect('admin/attribute/display_list_values');
			}else {
				$this->setErrorMessage('error','List value already exists');
				echo "<script>window.history.go(-1)</script>";
			}
		}
	}
	
	
	/**
	 * 
	 * Function to insert and edit list space values
	 */	
	public function insertEditListSpaceValue(){
	
	    $list_id = $this->input->post('list_name');
		
		if ($list_id == '')
		{
			$this->setErrorMessage('error','Select the list');
			echo "<script>window.history.go(-1)</script>";
		}
		else
		{
			$lvID = $this->input->post('lvID');
			$list_value = ucfirst($this->input->post('list_value'));
			$list_description = $this->input->post('list_description');
			$seourl = url_title($list_value,'',TRUE);

			if ($lvID == '')
			{
				$dataArr = array(
					'listspace_id'	=>	$list_id,
					'list_value'=>	$list_value
				);
			}
			else
			{
				$dataArr = array(
					'id !='		=>	$lvID,
					'listspace_id'	=>	$list_id,
					'list_value'=>	$list_value
				);
			}

			$duplicateCheck = $this->attribute_model->get_all_details(LISTSPACE_VALUES,$dataArr);
			$dataArr = array(
				'listspace_id'	=>	$list_id,
				'list_value'=>	$list_value,
				'list_description'=>	$list_description,
				'list_value_seourl'=> $seourl
			);			
			
			$Image_name=$_FILES['image']['name']; 
			if ($Image_name!='')
			{
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
			$config ['max_width'] = '40';
			$config ['max_height'] = '35';
		    $config['upload_path'] = './images/attribute/';
		    $this->load->library('upload', $config);
			
				if ( $this->upload->do_upload('image'))
				{
					$imgDetails = $this->upload->data(); 
					$dataArr['image'] = $imgDetails['file_name'];
				}
				else
				{
					
				if($lvID!='')
				{
					$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 35*40 px (H*W)');
					redirect('admin/Rentaltype/edit_listSpace_value_form/'.$lvID);
				}
				else
				{
					$this->setErrorMessage('error','File Should be JPEG,JPG,PNG and below 100*100 px');
					redirect('admin/Rentaltype/add_listspace_value_form');
				}					
				}
			}
			
			if ($duplicateCheck->num_rows()==0)
			{
				if ($lvID == '')
				{
					$this->attribute_model->simple_insert(LISTSPACE_VALUES,$dataArr);
					$this->setErrorMessage('success','List value inserted successfully');
				}
				else
				{
					$condition = array('id'=>$lvID);
					$this->attribute_model->update_details(LISTSPACE_VALUES,$dataArr,$condition);
					$this->setErrorMessage('success','List value updated successfully');
				}
				redirect('admin/Rentaltype/display_listspace_values');
			}
			else
			{
				$this->setErrorMessage('error','List value already exists');
				echo "<script>window.history.go(-1)</script>";
			}
		}
	}
	
	
	
	public function display_sub_list_values(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
		//echo 'gangatha';die;
			$this->data['heading'] = 'Sub List Values';
			$this->data['SublistValues'] = $this->attribute_model->get_sub_list_values();
			//echo $this->db->last_query();die;
			$this->load->view('admin/attribute/display_sub_list_values',$this->data);
		}
	}
	
	public function add_sub_list_value_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add Sub List Value';
			$this->data['list_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
			$this->data['sub_list_details'] = $this->attribute_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
			
			//echo $this->db->last_query();
			
			//print_r($this->data['sub_list_details']->result());die;
			$this->load->view('admin/attribute/add_sub_list_value',$this->data);
		}
	}
	
	public function add_sub_list_value_form_frm(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$list_id = $this->input->post('list_id');
			//$this->data['heading'] = 'Add Sub List Value';
			//$this->data['list_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
			$this->data['sub_list_details'] = $this->attribute_model->get_all_details(LIST_VALUES,array('status'=>'Active','list_id'=>$list_id));

			$returnstr['amenities'] = $this->load->view('admin/attribute/display_li',$this->data,true);
			echo json_encode($returnstr);
			//echo $this->db->last_query();
				
			//print_r($this->data['sub_list_details']->result());die;
			//$this->load->view('admin/attribute/add_sub_list_value',$this->data);
		}
	}
	
	
	public function insertEditSubListValue(){
		$list_id = $this->input->post('list_id');
		$list_value_id = $this->input->post('list_value_id');
		if ($list_id == ''){
			$this->setErrorMessage('error','Select the list');
			echo "<script>window.history.go(-1)</script>";
		}
		else if($list_value_id=='')
		{
		    $this->setErrorMessage('error','Select list value');
			echo "<script>window.history.go(-1)</script>";
		}
		else {
		
			$lvID = $this->input->post('lvID');
			$list_value_id = $this->input->post('list_value_id');
			$sub_list_value = $this->input->post('sub_list_value');
			$seourl = url_title($list_value,'',TRUE);
			if ($lvID == ''){
			
				$dataArr = array(
					'list_id'	=>	$list_id,
					'list_value_id'=>	$list_value_id,
					'sub_list_value'=>	$sub_list_value,
				);
				//print_r($dataArr);die;
			}else {
				$dataArr = array(
					'id !='		=>	$lvID,
					'list_id'	=>	$list_id,
					'list_value_id'=>	$list_value_id,
					'sub_list_value'=>	$sub_list_value,
				);
			}
			$duplicateCheck = $this->attribute_model->get_all_details(LIST_SUB_VALUES,$dataArr);
			$dataArr = array(
				'list_id'	=>	$list_id,
				'list_value_id'=>	$list_value_id,
				'sub_list_value'=>	$sub_list_value,
				'sub_list_value_seourl'=> $seourl
			);
			
			$config['overwrite'] = FALSE;
	    	$config['allowed_types'] = 'jpg|jpeg|gif|png';
		    $config['max_size'] = 2000;
		    $config['upload_path'] = './images/attribute';
		    $this->load->library('upload', $config);
			if ( $this->upload->do_upload('image')){
		    	$imgDetails = $this->upload->data();
		    	$dataArr['image'] = $imgDetails['file_name'];
			}
			
			if ($duplicateCheck->num_rows()==0){
				if ($lvID == ''){
					$this->attribute_model->simple_insert(LIST_SUB_VALUES,$dataArr);
					$this->setErrorMessage('success','List value inserted successfully');
				}else {
					$condition = array('id'=>$lvID);
					$this->attribute_model->update_details(LIST_SUB_VALUES,$dataArr,$condition);
					$this->setErrorMessage('success','List value updated successfully');
				}
				redirect('admin/attribute/display_sub_list_values');
			}else {
				$this->setErrorMessage('error','List value already exists');
				echo "<script>window.history.go(-1)</script>";
			}
		}
	}
	
	public function delete_sub_list_value(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->attribute_model->commonDelete(LIST_SUB_VALUES,$condition);
			$this->setErrorMessage('success','List value deleted successfully');
			redirect('admin/attribute/display_sub_list_values');
		}
	}
	
	public function edit_sub_list_value_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit List Value';
			$list_value_id = $this->uri->segment(4,0);
			$condition = array('id' => $list_value_id);
			$this->data['sub_list_value_details'] = $this->attribute_model->get_all_details(LIST_SUB_VALUES,$condition);
			//print_r($this->data['sub_list_value_details']->row());die;
			if ($this->data['sub_list_value_details']->num_rows() == 1){
				$this->data['list_value_details'] = $this->attribute_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
				//echo $this->db->last_query();die;
				$this->data['list_details'] = $this->attribute_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
				//print_r($this->data['list_value_details']->result());die;
				$this->load->view('admin/attribute/edit_sub_list_value',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	public function add_lang_value(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New List';
			$this->data['cms_details'] = $this->attribute_model->get_all_details(LISTSPACE,array('lang'=>'en'));
			$this->data['lang_details'] = $this->attribute_model->get_all_details(LANGUAGES,array('status'=>'Active'));
			$this->load->view('admin/attribute/add_lang_value',$this->data);
		}
	}
	
	public function main_listspace(){
		$seourl = $this->input->post('id');
		$this->data['lang_detail'] = $this->attribute_model->get_all_details(LANGUAGES,array('status'=>'Active'));
		$select .= '<option >Please Choose Language</option>';
		foreach($this->data['lang_detail']->result() as $lang) {
			$checkNum = $this->attribute_model->get_all_details(LISTSPACE,array('toId'=>$seourl,'lang'=>$lang->lang_code));
			if($checkNum->num_rows() == 0){
				$select .='<option value="'.$lang->lang_code.'">'.$lang->name.'</option>'; 
			}
		}
		echo $select;
	}
	
	public function insertAttribute_other(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			//echo '<pre>';print_r($_POST);
			$attribute_name = $this->input->post('attribute_name');
			if($attribute_name ==''){
				$this->setErrorMessage('error','Please enter list name');
				redirect('admin/Rentaltype/add_lang_value');
			}
			
			
			
			$condition = array('attribute_name' => $attribute_name);
			$duplicate_name = $this->attribute_model->get_all_details(LISTSPACE,$condition);
			if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','List name already exists');
				redirect('admin/Rentaltype/add_lang_value');
			}
			
			$seourl_qry = $this->attribute_model->get_all_details(LISTSPACE,array('id'=>$this->input->post('toId')));
			//echo '<pre>';print_r($seourl_qry->result());
			$dataArr = array( 'attribute_name'=>$this->input->post('attribute_name'), 'status'=>'Active', 'attribute_seourl'=>$seourl_qry->row()->attribute_seourl, 'lang'=>$this->input->post('lang'), 'toId'=>$this->input->post('toId'));
			//echo '<pre>';print_r($dataArr);die;
			$this->attribute_model->simple_insert(LISTSPACE, $dataArr);
			$this->setErrorMessage('success','List added successfully');
			redirect('admin/Rentaltype/display_attribute_listspace');
		}
	}
	
	public function display_other_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Other List Details';
			$id = $this->uri->segment(4);
			$this->data['heading'] = 'List Space Details';
			$this->data['attributeList'] = $this->attribute_model->get_all_details(LISTSPACE, array('lang <>'=>'en', 'toId'=>$id));
			$this->load->view('admin/attribute/display_attribute_other_listspace',$this->data);
		}
	}
	
	public function add_lang_value_space(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New List';
			$this->data['cms_details'] = $this->attribute_model->get_all_details(LISTSPACE_VALUES,array('lang'=>'en'));
			$this->data['lang_details'] = $this->attribute_model->get_all_details(LANGUAGES,array('status'=>'Active'));
			$this->load->view('admin/attribute/add_other_listspace_value',$this->data);
		}
	}
	
	public function main_listspace_values(){
		$seourl = $this->input->post('id');
		$this->data['lang_detail'] = $this->attribute_model->get_all_details(LANGUAGES,array('status'=>'Active'));
		$select .= '<option >Please Choose Language</option>';
		foreach($this->data['lang_detail']->result() as $lang) {
			$checkNum = $this->attribute_model->get_all_details(LISTSPACE_VALUES,array('toId'=>$seourl,'lang'=>$lang->lang_code));
			if($checkNum->num_rows() == 0){
				$select .='<option value="'.$lang->lang_code.'">'.$lang->name.'</option>'; 
			}
		}
		echo $select;
	}
	
	public function insertEditListSpaceValue_other(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			//echo '<pre>';print_r($_POST);
			$attribute_name = $this->input->post('attribute_name');
			if($attribute_name ==''){
				$this->setErrorMessage('error','Please enter list name');
				redirect('admin/Rentaltype/add_lang_value_space');
			}
			
			
			
			$condition = array('list_value' => $attribute_name);
			$duplicate_name = $this->attribute_model->get_all_details(LISTSPACE_VALUES,$condition);
			if ($duplicate_name->num_rows() > 0){
				$this->setErrorMessage('error','List name already exists');
				redirect('admin/Rentaltype/add_lang_value_space');
			}
			
			$seourl_qry = $this->attribute_model->get_all_details(LISTSPACE_VALUES,array('id'=>$this->input->post('toId')));
			//echo '<pre>';print_r($seourl_qry->result());
			$dataArr = array( 'listspace_id'=>$seourl_qry->row()->listspace_id, 'list_value'=>$this->input->post('attribute_name'), 'list_description'=>$this->input->post('list_description'), 'other'=>$seourl_qry->row()->other, 'image'=>$seourl_qry->row()->image, 'list_value_seourl'=>$seourl_qry->row()->list_value_seourl, 'status'=>'Active', 'lang'=>$this->input->post('lang'), 'toId'=>$this->input->post('toId'));
			//echo '<pre>';print_r($dataArr);die;
			$this->attribute_model->simple_insert(LISTSPACE_VALUES, $dataArr);
			$this->setErrorMessage('success','List added successfully');
			redirect('admin/Rentaltype/display_listspace_values');
		}
	}
	
	public function display_other_list_values(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Other List Details';
			$id = $this->uri->segment(4);
			$this->data['heading'] = 'List Space Details';
			$this->data['attributeList'] = $this->attribute_model->get_all_details(LISTSPACE, array('lang <>'=>'en', 'toId'=>$id));
			$this->load->view('admin/attribute/display_attribute_other_listspace',$this->data);
		}
	}
}

/* End of file attribute.php */
/* Location: ./application/controllers/admin/attribute.php */