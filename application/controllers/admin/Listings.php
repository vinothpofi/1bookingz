<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This controller contains the functions related to listings management 
 * @author Teamtweaks
 *
 */

class Listings extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('listings_model');
		if ($this->checkPrivileges('Listing',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
	
	/**
	 *Load contens for rooms and beds for listings
	 *
	 */
	public function rooms_and_beds() {
		//$condition=array('id'=>1);
		$this->data['listDetail'] = $this->listings_model->get_all_data(LISTING_TYPES);	
		$this->data['listvalues'] = $this->listings_model->get_all_values(LISTING);
				foreach($this->data['listvalues'] as $result)
					{
						$data = $result->listing_values;	
					}
					$this->data['finalVal'] = json_decode($data);
					//var_dump($this->data);die;
								
		$this->load->view('admin/listings/rooms_and_beds',$this->data);
	}
	
	/*
	*Load contens for listings informations for listings
	*
	*/
	public function listings_info() {
		$condition=array('id'=>1);
		$this->data['listDetail'] = $this->listings_model->get_all_details(LISTINGS,$condition);	
		$this->load->view('admin/listings/listings_info',$this->data);
	}
	
	/**
	 *
	 *This function load add new listing type form
	 */
	public function add_new_attribute()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			
			
			$id=$this->uri->segment(4,0);
			
			if($id != '')
			{
				$this->data['heading'] = 'Edit Features Type';
				$this->data['details'] = $this->listings_model->get_all_details(LISTING_TYPES, array('id'=>$id));
			}
			else
			$this->data['heading'] = 'Add New Features Type';
			
			$this->load->view('admin/listings/add_new_attribute',$this->data);
		}	
	}

	/*
	*Save rooms and beds for listings
	*
	*/
	 public function insertlistings_roomsandbed() {		

		$condition=array('id'=>1);
		if($this->input->post())
		{
		 
		$postValues = $this->input->post();
		// print_r($postValues);
		// exit();

		foreach($postValues as $seperate_key => $seperate_value){
				// $key_id = substr($seperate_key, 0,2);
				// echo $key_id;
				$newArr[$seperate_key] = $seperate_value;
				
		}
		print_r($newArr);
		exit();
		foreach($newArr as $newkey => $newval){
			$secondArr[$newval] = $newkey;
		}

		foreach ($secondArr as $key => $value) {

			$key_ex = explode(',',$key);
			// echo '<pre>';
			// print_r($key_ex);
			// echo '</pre>';
			foreach($key_ex as $now_key => $key_val){
				//$get_parent_id = $this->db->where()
				$insertdata = array('parent_id' => $value,'child_name' => $key_val);

				$this->db->insert('fc_listing_child',$insertdata);
			}
			
		}
		
		exit();
		
		
		foreach($postValues as $listName => $lsitValues ){
		
			$dataArr[$listName]= $lsitValues;
		}
			$finalVal=json_encode($dataArr);
			
			
		}
	  
		$listvalues = $this->listings_model->get_all_details(LISTINGS,$condition);	
		$listArr=array('listing_values'=>$finalVal);
               
		//$this->listings_model->update_details(LISTINGS,$listArr,$condition);
		if($listvalues->num_rows()==1){
			$this->listings_model->update_details(LISTINGS,$listArr,$condition);
		}else{
			$this->listings_model->simple_insert(LISTINGS,$listArr);
		} 
		
		redirect('admin/listings/rooms_and_beds');
	} 
	
	/**
	 *
	 *Function to save new listing type
	 */
	public function insert_attribute()
	{ 
		$id=$this->input->post('id');
		
		$attribute_name = str_replace(' ','_',$this->input->post('attribute_name'));
		$type = $this->input->post('type');
		$label_name = ucfirst($this->input->post('label_name'));
		//$label_name_ar = ucfirst($this->input->post('label_name_ar'));
		$status = $this->input->post('status');
		//echo $status;exit;
		$status_value ="InActive";

		if($status == 'on' || (($attribute_name == 'accommodates') || ($attribute_name == 'minimum_stay')))
		{
			$status_value ="Active"; 
		}

		if($id !== '')
		{
			$condition = array();
			$condition['id']=$id;
			if($attribute_name!='')$condition['name']=$attribute_name;
			if($type!='')$condition['type']=$type;
			$condition['labelname']=$label_name;

			$dataArr = array(
				'labelname'	=>	$label_name,
				'name' => $attribute_name,
				'type' => $type,
				'status' => $status_value

			);		
			//$condition['labelname_ar']=$label_name_ar;
			$condition1 = array('name'=>$attribute_name,'status'=>$status_value,'type'=>$type,'labelname'=>$label_name);

			foreach(language_dynamic_enable("labelname","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }	
			$listing_values = $this->listings_model->get_all_details(LISTING_TYPES,$condition1);
			if($listing_values->num_rows() > 0){
				$this->setErrorMessage('error','List type name already exist');
			}
			else{
				$this->listings_model->simple_updates($dataArr,$id);
				
				$this->setErrorMessage('success','Feature Updated successfully');
			}
			

			redirect('admin/listings/attribute_values');		
		}
		else
		{ 
			$exist_attribute = 0;
			$condition = array('name'=>$attribute_name,'status'=>$status_value,'type'=>$type,'labelname'=>$label_name);
			//$condition = array('name'=>$attribute_name,'status'=>$status_value,'type'=>$type,'labelname'=>$label_name,'labelname_ar'=>$label_name_ar);
			$listing_values = $this->listings_model->get_all_details(LISTINGS,array('id'=>'1'));
			
			$listingEncodeValue = $listing_values->row()->listing_values;
			$listingDecodeValue = json_decode($listingEncodeValue);
			foreach($listingDecodeValue as $listName => $lsitValues )
			{			
				$dataArr[$listName]= $lsitValues;
				if($listName == $attribute_name)
				{
					$exist_attribute += 1;
				}
			}

			if($exist_attribute==0)
			{
				$dataArr[$attribute_name] = '';
					$finalVal=json_encode($dataArr);
					foreach(language_dynamic_enable("labelname","") as $dynlang) {
               $condition=array_merge($condition,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

				$this->listings_model->update_details(LISTINGS,array('listing_values'=>$finalVal),array('id'=>'1'));
				$this->listings_model->simple_insert(LISTING_TYPES,$condition);
				
				$this->setErrorMessage('success','Feature Added successfully');
			}
			else
			{
				$this->setErrorMessage('error','List type name already exist');
			}
			redirect('admin/listings/attribute_values');
		}
	}

	public function attribute_values()
	{
			$this->data['heading'] = 'Features Types';
			$this->data['listingvalues'] = $this->listings_model->get_all_data();	
			$this->load->view('admin/listings/listing_types',$this->data);

	}
	public function delete_list($id='')
	{ 
		$id = $this->uri->segment(4,0);
		$listingValues = $this->listings_model->get_all_datas($id);
		foreach($listingValues as $result)	  
		{
		 $data = $result->name;
		}
		$listing_values = $this->listings_model->get_all_details(LISTINGS,array('id'=>'1'));
	foreach($listing_values->result() as $list)	  
		
		{
		 //echo $list->listing_values;
		 $restult_listing = $list->listing_values;
		 //echo $data;
		}
		$result_decode = json_decode($restult_listing);
		foreach($result_decode as $listName => $keyValues){
		
		if($data != $listName){
		//echo $listName;
		$finla_listing[$listName] = $keyValues;
		}
		
		}
		
		$this->listings_model->update_details(LISTINGS,array('listing_values'=>json_encode($finla_listing)),array('id'=>'1'));
		$this->listings_model->delete_listing($id);
		$this->setErrorMessage('success','Feature Deleted successfully');
		redirect('admin/listings/attribute_values');

	}
	
	public function change_list_types_status_global(){
	
		if(count($this->input->post('checkbox_id')) > 0 &&  $this->input->post('statusMode') != ''){
			$this->listings_model->activeInactiveCommon(LISTING_TYPES,'id');
			//echo $this->db->last_query();exit;
			if (strtolower($this->input->post('statusMode')) == 'delete'){
				$this->setErrorMessage('success','Features types deleted successfully');
			}else{
				$this->setErrorMessage('success','Features types status changed successfully');
			}
			redirect('admin/listings/attribute_values');
		}
	}

	/**
	 *
	 *Function to change listing type status
	 */
	public function change_listings_status()
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
			$this->listings_model->update_details(LISTING_TYPES,$newdata,$condition);
			$this->setErrorMessage('success','Listings Status Changed Successfully');
			redirect('admin/listings/attribute_values');
		}
	}

	/**
	 *
	 *This function loads listing child value list
	 */
	public function listing_child_values()
	{
		$this->data['heading'] = 'Listing Child Values';
		$this->data['listingvalues'] = $this->listings_model->get_all_data();	
		$this->load->view('admin/listings/listing_child_values',$this->data);
	}
	

	/**
	 *
	 *This function loads child value lists
	 */
	public function view_listing_child_values()
	{
		$this->data['heading'] = 'View Listing Child Values';
		$parent_id = $this->uri->segment(4);
		$this->data['listchildvalues'] = $this->listings_model->get_listing_childValues_view($parent_id);
		$this->load->view('admin/listings/view_listing_child_values',$this->data);
	}
	
	/**
	 *
	 *This function loads add new child value form
	 */
	public function add_new_child_fields()
	{
		$this->data['heading'] = 'Add Child Values';
		$parent_id = $this->uri->segment(4);
		$this->data['list_attr_name'] = $this->listings_model->get_all_details(fc_listing_types,array('id' => $parent_id))->row();
		$this->data['listchildvalues'] =$this->listings_model->get_listing_childValues($parent_id);
		$this->load->view('admin/listings/add_new_child_fields',$this->data);
	}

	public function add_submit_new_child_fields(){
		$parent_id = $this->input->post('parent_id');
		$child_value = ucfirst($this->input->post('child_value'));

		$insert_data= array(
			'parent_id' =>$parent_id,
			'child_name' =>$child_value
			);

		$this->db->insert('fc_listing_child',$insert_data);
		redirect('admin/listings/add_new_child_fields/'.$parent_id);
	}

	/**
	 *
	 *Function to delete list child value
	 */
	public function delete_child_list_value()
	{
		$id = $this->uri->segment(4);
		$parent_id = $this->uri->segment(5);
		$this->db->where('id',$id)->delete('fc_listing_child');
		redirect('admin/listings/add_new_child_fields/'.$parent_id);
	}

	/**
	 *
	 *Function to update list child value
	 */
	public function update_child_data(){
		$child_id = $this->input->post('child_id');
		$child_name = $this->input->post('child_name');
//		$child_name_arabic = $this->input->post('child_name_arabic');

		//	'child_name_arabic' =>$child_name_arabic

		$update_data= array(
			'child_name' =>$child_name
			);
		$this->db->where('id',$child_id)->update('fc_listing_child',$update_data);
	}
   
}



/* End of file listings.php */
/* Location: ./application/controllers/admin/listings.php */