<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**  
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class Slider extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('slider_model');
		if ($this->checkPrivileges('Slider',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the users list page
     */
   	public function index(){	
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			redirect('admin/slider/display_slider_list');
		}
	}
	
	/**
	 * 
	 * This function loads the users list page
	 */
	public function display_slider_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Banner List';
			$condition = array();
			$this->data['sliderList'] = $this->slider_model->get_all_details(SLIDER,$condition);
			$condition = array('id'=>'1');
			$enableRslt = $this->slider_model->get_all_details(ADMIN_SETTINGS,$condition);
			$this->data['enable'] = $enableRslt->row()->slider;
			$this->load->view('admin/slider/display_sliderlist',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the users dashboard
	 */
	public function display_user_dashboard(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Banner Dashboard';
			$condition = 'order by `created` desc';
			$this->data['usersList'] = $this->slider_model->get_slider_details($condition);
			$this->load->view('admin/slider/display_slider_dashboard',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new user form
	 */
	public function add_slider_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Banner';
			$this->load->view('admin/slider/add_slider',$this->data);
		}
	}
	
	/**
	 * 
	 * This function insert and edit a user
	 */
	public function insertEditSlider(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$slider_id = $this->input->post('slider_id');
			$slider_name = $this->input->post('slider_name');
			//$slider_name_ar = $this->input->post('slider_name_ar');
			$slider_title = $this->input->post('slider_title');
			if ($slider_id == ''){
				$condition = array('slider_name' => $slider_name);
			//	$condition_ar = array('slider_name_ar' => $slider_name_ar);
				foreach(language_dynamic_enable("slider_name","") as $dynlang) {
               	$condition=array_merge($condition,array($dynlang[1] => $this->input->post($dynlang[1])));
           		 }
				$duplicate_name = $this->slider_model->get_all_details(SLIDER,$condition);
			//	$duplicate_name_ar = $this->slider_model->get_all_details(SLIDER, $condition_ar);
				if ($duplicate_name->num_rows() > 0){
					$this->setErrorMessage('error','Banner name already exists');
					redirect('admin/slider/add_slider_form');
				}
				
			}
			$excludeArr = array("slider_id","image","status");
			//$excludeArr = array("slider_id","status");
			//echo $this->input->post('status');exi
			if ($this->input->post('status') != ''){
				$slider_status = 'Active';
			}else {
				$slider_status = 'Inactive';
			}
			$slider_status = 'Active';
			$inputArr = array('status' => $slider_status);
			$datestring = "%Y-%m-%d";
			$time = time();
			 if(!is_dir($logoDirectory))
                       {
                               mkdir($logoDirectory,0777);
                       }
					   
					   
				$Image_name = $_FILES['image']['name'];
				
				if ($Image_name!=''){
				$config['overwrite'] = FALSE;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size'] = 2000;
				$config['upload_path'] = './images/slider';
				$this->load->library('upload', $config);
				$this->upload->do_upload('image');
				$imgDetails = $this->upload->data();
				$inputArr['image'] = $imgDetails['file_name'];
							
				if($imgDetails['file_name']!=''){
					$path='/images/slider/thumb/';
					@copy('./images/slider/'.$imgDetails['file_name'],'./images/slider/thumb/'.$imgDetails['file_name']);
					  
			  if($imgDetails['image_width'] <1349 && $imgDetails['image_height'] < 484)
					{				  
						   if (!$this->imageResizeWithSpace(1349, 484, $imgDetails['file_name'], './images/slider/thumb/'))
						   {
						   
								   $error = array('error' => $this->upload->display_errors());
						   }
						   else
						   {
								   $sliderUploadedData = array($this->upload->data());   
						   } 
					 }
					$inputArr['image'] = $imgDetails['file_name'];
				}
			}else{
				$condition=array('id'=>$slider_id);
				$duplicate_name = $this->slider_model->get_all_details(SLIDER,$condition);
				//$duplicate_name_ar = $this->slider_model->get_all_details(SLIDER, $condition);
				$inputArr['image'] = $duplicate_name->row()->image;
				//$inputArr_ar['image'] = $duplicate_name_ar->row()->image;
			}

			$condition = array('id' => $slider_id);
			if ($slider_id == ''){
				//$inputArr = array('status' => 'Active');
				$this->slider_model->commonInsertUpdate(SLIDER,'insert',$excludeArr,$inputArr,$condition);
				$this->setErrorMessage('success','Banner added successfully');
			}else {
				$this->slider_model->commonInsertUpdate(SLIDER,'update',$excludeArr,$inputArr,$condition);
				$this->setErrorMessage('success','Banner updated successfully');
			}
			

			redirect('admin/slider/display_slider_list');
		}
	}
	
	/**
	 * 
	 * This function loads the edit user form
	 */
	public function edit_slider_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Banner';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['slider_details'] = $this->slider_model->get_all_details(SLIDER,$condition);
			if ($this->data['slider_details']->num_rows() == 1){
				$this->load->view('admin/slider/edit_slider',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function change the user status
	 */
	public function change_slider_status(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			
			$mode = $this->uri->segment(4,0);
			$user_id = $this->uri->segment(5,0);

			$status = ($mode == '0')?'Inactive':'Active';
			$newdata = array('status' => $status);
			$condition = array('id' => $user_id);
			$this->slider_model->update_details(SLIDER,$newdata,$condition);
			$condition = array('status' => 'Active');
			$slider_count = $this->slider_model->get_all_details(SLIDER,$condition);
			$slider_count = $slider_count->num_rows();
			// if($slider_count == 0){

			// $condition = array('id' => $user_id);
			// $this->slider_model->update_details(SLIDER,array('status' => 'Active'),$condition);
			// 	$this->setErrorMessage('error','At Least One Banner Should Be Active');
			// redirect('admin/slider/display_slider_list');
			// }
			$this->setErrorMessage('success','Banner Status Changed Successfully');
			redirect('admin/slider/display_slider_list');
		}
	}
	
	/**
	 * 
	 * This function loads the user view page
	 */
	public function view_slider(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'View Banner';
			$user_id = $this->uri->segment(4,0);
			$condition = array('id' => $user_id);
			$this->data['slider_details'] = $this->slider_model->get_all_details(SLIDER,$condition);
			if ($this->data['slider_details']->num_rows() == 1){
				$this->load->view('admin/slider/view_slider',$this->data);
			}else {
				redirect('admin');
			}
		}
	}
	
	/**
	 * 
	 * This function delete the user record from db
	 */
	public function delete_slider(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$user_id = $this->uri->segment(4,0);
			
			

			//
			$condition = array('status' => 'Active');
			$slider_count = $this->slider_model->get_all_details(SLIDER,$condition);
			$slider_count_is = $slider_count->num_rows();

			if($slider_count_is == 1 && $slider_count->row()->id == $user_id){
			$this->setErrorMessage('error','At Least One Banner Should Be Active');
			redirect('admin/slider/display_slider_list');
			}

			//
			$condition = array('id' => $user_id);
			$this->slider_model->commonDelete(SLIDER,$condition);
			$this->setErrorMessage('success','Banner deleted successfully');
			redirect('admin/slider/display_slider_list');
		}
	}
	
	/**
	 * 
	 * This function change the user status, delete the user record
	 */
	public function change_slider_status_global(){
		
		if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			$this->slider_model->activeInactiveCommon(SLIDER,'id');
			if (strtolower($_POST['statusMode']) == 'delete'){
				$this->setErrorMessage('success','Banner deleted successfully');
			}else {
				$this->setErrorMessage('success','Banner status changed successfully');
			}
			redirect('admin/slider/display_slider_list');
		}
	}
	// public function change_slider_status_global(){
		
	// 	$count_status = count($_POST['checkbox_id']);
	// 	if(count($_POST['checkbox_id']) > 0 &&  $_POST['statusMode'] != ''){
			


	// 		if (strtolower($_POST['statusMode']) == 'delete'){
				
	// 			 $data = $_POST['checkbox_id'];


 //        for ($i = 0; $i < count($data); $i++) {

 //            if ($data[$i] == 'on') {

               

 //            }

 //            else
 //            	{
 //            		$condition = array('status' => 'Active');
 //            			$slider_count = $this->slider_model->get_all_details(SLIDER,$condition);
 //            			$slider_count_is = $slider_count->num_rows();
            
 //            			if($slider_count_is == 1 && $slider_count->row()->id == $data[$i]){
 //            			$this->setErrorMessage('error','At Least One Banner Should Be Active');
 //            			redirect('admin/slider/display_slider_list');
 //            			}
            
 //            			$this->slider_model->commonDelete(SLIDER,array('id' => $data[$i]));
 //            	}
            	 
 //        }

	// 			$this->setErrorMessage('success','Banner deleted successfully');
	// 		}else {
	// 			$this->slider_model->activeInactiveCommon(SLIDER,'id');
	// 		$condition = array('status' => 'Active');
	// 		$slider_count = $this->slider_model->get_all_details(SLIDER,$condition);
	// 		$slider_count = $slider_count->num_rows();
	// 		if($slider_count == 0){

	// 			$count_status_is = $count_status-1;
	// 			$user_id = $_POST['checkbox_id'][$count_status_is];
	// 		$condition = array('id' => $user_id);
	// 		$this->slider_model->update_details(SLIDER,array('status' => 'Active'),$condition);
	// 			$this->setErrorMessage('error','At Least One Banner Should Be Active');
	// 		redirect('admin/slider/display_slider_list');
	// 		}

	// 			$this->setErrorMessage('success','Banner status changed successfully');
	// 		}
	// 		redirect('admin/slider/display_slider_list');
	// 	}
	// }
	
	public function getExtension($str)
  {
$i = strrpos($str,".");
if (!$i)
{
return "";
}
$l = strlen($str) - $i;
$ext = substr($str,$i+1,$l);
return $ext;
 }
 public function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
{

if($ext=="jpg" || $ext=="jpeg" )
{
$src = imagecreatefromjpeg($uploadedfile);
}
else if($ext=="png")
{
$src = imagecreatefrompng($uploadedfile);
}
else if($ext=="gif")
{
$src = imagecreatefromgif($uploadedfile);
}
else
{
$src = imagecreatefrombmp($uploadedfile);
}

list($width,$height)=getimagesize($uploadedfile);
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
$filename = $path.$newwidth.'_'.$actual_image_name; //PixelSize_TimeStamp.jpg
imagejpeg($tmp,$filename,100);
imagedestroy($tmp);
return $filename;
}
 
}

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */