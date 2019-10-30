<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 

/**
 * 
 * This controller contains the functions related to Product management 
 * @author Teamtweaks
 *
 */ 

class Reports extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form', 'email', 'file'));
        $this->load->library(array('encrypt', 'form_validation', 'image_lib', 'resizeimage', 'email'));
		$this->load->model('report_model');
		$this->load->model('product_model');
		if ($this->checkPrivileges('Reports',$this->privStatus) == FALSE){
			redirect('admin');
		}
    }
    
    /**
     * 
     * This function loads the product list page
     */

	public function display_report_list()
	{
		
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else 
		{
			$this->data['heading'] = 'Reports';
			$search_type = '';
		    
			$name_filter = $_GET['experience_name_filter_val'];
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
            if ($rep_code != '') {
                $condition = 'where u.rep_code="' . $rep_code . '" group by cit.name order by p.created desc';
            } else {
                $condition = 'group by cit.name order by p.created desc';
            }
            /*-----------------------*/
            $this->load->library('pagination');
            $limit_per_page = 10;
         	//    if($name_filter == ''){
         	//    $Total_properties = $this->db->select('id')->where('product_title LIKE "%'.$name_filter.'%"')->get(PRODUCT)->num_rows();

	        // }
	        //else{
            	 $Total_properties = 0;
	        	 //$Total_properties = $this->db->select('id')->get(PRODUCT)->num_rows();   
	       // }
	            $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	            $config['base_url'] = base_url() . 'admin/reports/display_reports_list';
	            $config['total_rows'] = $Total_properties;
	            $config['per_page'] = $limit_per_page;
	            $config['uri_segment'] = 4;
	            $config['num_tag_open'] = '<li>';
	            $config['num_tag_close'] = '</li>';
	            $config['cur_tag_open'] = '<li class="active"><a>';
	            $config['cur_tag_close'] = '</a></li>';
	            $config['first_link'] = '<< ';
	            $config['first_tag_open'] = '<li>';
	            $config['first_tag_close'] = '</li>';
	            $config['last_link'] = ' >>';
	            $config['last_tag_open'] = '<li>';
	            $config['last_tag_close'] = '</li>';
	            $config['next_tag_open'] = '<li>';
	            $config['next_tag_close'] = '</li>';
	            $config['prev_tag_open'] = '<li>';
	            $config['prev_tag_close'] = '</li>';
	            $this->pagination->initialize($config);
	            $this->data["links"] = $this->pagination->create_links();
	            /*-----------------------*/
	            $this->data['checkin'] = $_GET['checkin'];
	            $this->data['checkout'] = $_GET['checkout'];
	        if($search_type != ''){
	            $this->data['productList'] = $this->report_model->get_allthe_details($_GET['status'], $_GET['city'], $_GET['checkin'], $_GET['checkout'], $_GET['id'], $rep_code, $limit_per_page, $start_index);

	        }
	        else{
	        	$this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
 
	        	$this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
	        	$this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
	        	$this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

	        }
	            // echo "<pre>";
	            // print_r($this->data['productList']->result());exit();
	            $this->data['userdetails'] = $this->report_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
	            $this->data['options'] = $this->product_model->get_search_options($condition);
				$this->load->view('admin/reports/display_reports_list', $this->data);
		}
	}

	public function ajax_fetch_type_based_rental_data()
	{
			$search_type = $this->input->get('search_type');

			$this->data['search_type_fetch'] = 1;
		//	echo $this->data['search_type_fetch'];exit();
		   $data['datefrom'] = $datefrom = $this->input->get('datefrom');
		  $data['dateto'] =  $dateto = $this->input->get('dateto');
		    $data['search_name'] = $search_name = $this->input->get('search_name');
		    
		    $homename = $this->input->get('homename');
		    $data['status_order'] = $status_order = $this->input->get('status_order');
            $this->data['heading'] = 'Rentals Report';
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
            if ($rep_code != '') {
                $condition = 'where u.rep_code="' . $rep_code . '" group by cit.name order by p.created desc';
            } else {
                $condition = 'group by cit.name order by p.created desc';
            }
            /*-----------------------*/
            $this->load->library('pagination');
            if($dateto == ''){$datefrom = '';}
             $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             if($datefrom != '' || $dateto != '' || $search_name != '' || $status_order != ''){
		    	 $limit_per_page = $this->db->select('id')->get(PRODUCT)->num_rows();
		    	$count_data = $this->report_model->get_allthe_details($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
	            $Total_properties = $count_data->num_rows();
	            $limit_per_page = 10;
	         
		    }
		    else{
		    	
		    	 $Total_properties = $this->db->select('id')->get(PRODUCT)->num_rows();
	            $limit_per_page = 10;
		    }
        	//echo $Total_properties ;exit();
           
	            //echo  $Total_properties;exit();
	            $config['base_url'] = base_url() . 'admin/reports/ajax_fetch_type_based_rental_data';
	            $config['total_rows'] = $Total_properties;
	            $config['per_page'] = $limit_per_page;
	            $config['uri_segment'] = 4;
	            $config['num_tag_open'] = '<li>';
	            $config['num_tag_close'] = '</li>';
	            $config['cur_tag_open'] = '<li class="active"><a>';
	            $config['cur_tag_close'] = '</a></li>';
	            $config['first_link'] = '<< ';
	            $config['first_tag_open'] = '<li>';
	            $config['first_tag_close'] = '</li>';
	            $config['last_link'] = ' >>';
	            $config['last_tag_open'] = '<li>';
	            $config['last_tag_close'] = '</li>';
	            $config['next_tag_open'] = '<li>';
	            $config['next_tag_close'] = '</li>';
	            $config['prev_tag_open'] = '<li>';
	            $config['prev_tag_close'] = '</li>';
	            $this->pagination->initialize($config);
	            $this->data["links"] = $this->pagination->create_links();
	            /*-----------------------*/
	            $this->data['checkin'] = $_GET['checkin'];
	            $this->data['checkout'] = $_GET['checkout'];
	            //echo $status_order;exit();
		        if($search_type != ''){
		            $this->data['productList'] = $productList = $this->report_model->get_allthe_details($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);

		            $this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		        }
		        else{
		        	$this->data['productList'] = $this->report_model->get_allthe_details($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);

		        	$this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		        	 $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		        }
	        
	            $this->data['userdetails'] = $this->product_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
	            $this->data['options'] = $this->product_model->get_search_options($condition);
	            $this->load->view('admin/reports/display_reports_list', $this->data);
	         

	}

	public function ajax_fetch_type_based_experience_data()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$search_type = $this->input->get('search_type');
			$data['datefrom'] = $datefrom = $this->input->get('datefrom');
		  	$data['dateto'] =  $dateto = $this->input->get('dateto');
		    $data['search_name'] = $search_name = $this->input->get('search_name');
		    $data['status_order'] = $status_order = $this->input->get('status_order');
			$this->data['search_type_fetch'] = 2;
			//$name_filter = $_GET['experience_name_filter_val'];
			//echo "string";exit();
			$this->data['heading'] = 'Experience Report';

			/*-----------------------*/
			$this->load->library('pagination');
			$limit_per_page = 20;
			//if($name_filter == ''){
			$Total_properties = $this->db->select('experience_id')->get(EXPERIENCE)->num_rows();

			 if($dateto == ''){$datefrom = '';}
             $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             if($datefrom != '' || $dateto != '' || $search_name != '' || $status_order != ''){
		    	 $limit_per_page = $this->db->select('experience_id')->get(EXPERIENCE)->num_rows();
		    	
		    	$count_data = $this->report_model->get_allthe_details_experience($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
	            $Total_properties = $count_data->num_rows();
	            $limit_per_page = 10;
	         
		    }
		    else{
		    	
		    	 $Total_properties = $this->db->select('experience_id')->get(EXPERIENCE)->num_rows();
	            $limit_per_page = 10;
		    }

		   
					//}
					//else {
						//$Total_properties = $this->db->select('experience_id')->where('experience_title LIKE "%'.$name_filter.'%"')->get(EXPERIENCE)->num_rows();
					
					//}
//echo $Total_properties;exit();
			$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$config['base_url'] = base_url() . 'admin/reports/ajax_fetch_type_based_experience_data';
			$config['total_rows'] = $Total_properties;
			$config['per_page'] = $limit_per_page;
			$config['uri_segment'] = 4;
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="active"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['first_link'] = '<< ';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = ' >>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$this->pagination->initialize($config);
			$this->data["links"] = $this->pagination->create_links();
			/*-----------------------*/
			$condition = 'where u.status="Active" or p.user_id=0 group by cit.name order by p.added_date desc';
			if($search_type != '')
			{
				$this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
				$this->data['experienceList'] = $this->report_model->get_allthe_details_experience($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
				//echo $this->data['productList']->num_rows();exit();
				 $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
			}
			else {
				$this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
				$this->data['experienceList'] = $this->report_model->get_allthe_details_experience($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
				 $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));


			}
			
			foreach ($this->data['experienceList']->result() as $row) {
				$expId = $row->experience_id;
			}
			$this->data['userdetails'] = $this->report_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
			$this->data['options'] = $this->report_model->get_search_options_experience($condition);
			$this->load->view('admin/reports/display_reports_list', $this->data);
		}
	}

	public function ajax_fetch_type_based_guest_data()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$search_type = $this->input->get('search_type');
			$this->data['search_type_fetch'] = 3;
			$data['datefrom'] = $datefrom = $this->input->get('datefrom');
		  	$data['dateto'] =  $dateto = $this->input->get('dateto');
		    $data['search_name'] = $search_name = $this->input->get('search_name');
		    $data['status_order'] = $status_order = $this->input->get('status_order');
			$this->data['heading'] = 'Guest Report';
			$this->load->library('pagination');
			
            if($dateto == ''){$datefrom = '';}
             $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             if($datefrom != '' || $dateto != '' || $search_name != '' || $status_order != ''){
             	$this->db->select('u.*,pr.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.user_id=u.id",'left');
            $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.user_id=u.id",'left');
            $this->db->where(array('u.group' => 'User'));
           	$this->db->group_by('u.id');
            $limit_per_page = $this->db->get()->num_rows();
		    	
		    	$count_data = $this->report_model->get_allthe_details_users($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
	            $Total_properties = $count_data->num_rows();
	             $limit_per_page = 10;
	         
		    }
		    else{
		    	
		    	 	 $this->db->select('u.*,pr.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.user_id=u.id",'left');
            $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.user_id=u.id",'left');
           	$this->db->group_by('u.id');
           	$this->db->where(array('u.group' => 'User'));
            $Total_properties = $this->db->get()->num_rows();
	            $limit_per_page = 10;
		    }

				$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	            $config['base_url'] = base_url() . 'admin/reports/ajax_fetch_type_based_guest_data';
	            $config['total_rows'] = $Total_properties;
	            $config['per_page'] = $limit_per_page;
	            $config['uri_segment'] = 4;
	            $config['num_tag_open'] = '<li>';
	            $config['num_tag_close'] = '</li>';
	            $config['cur_tag_open'] = '<li class="active"><a>';
	            $config['cur_tag_close'] = '</a></li>';
	            $config['first_link'] = '<< ';
	            $config['first_tag_open'] = '<li>';
	            $config['first_tag_close'] = '</li>';
	            $config['last_link'] = ' >>';
	            $config['last_tag_open'] = '<li>';
	            $config['last_tag_close'] = '</li>';
	            $config['next_tag_open'] = '<li>';
	            $config['next_tag_close'] = '</li>';
	            $config['prev_tag_open'] = '<li>';
	            $config['prev_tag_close'] = '</li>';
	            $this->pagination->initialize($config);
	            $this->data["links"] = $this->pagination->create_links();
	            /*-----------------------*/
	         	$this->data['checkin'] = $_GET['checkin'];
	            $this->data['checkout'] = $_GET['checkout'];
		        if($search_type != ''){
		        	 $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		            $this->data['usersList'] = $this->report_model->get_allthe_details_users($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
		          	$this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		        }
		        else{
		        	 $this->data['hostList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		        	 $this->data['usersList'] = $this->report_model->get_allthe_details_users($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
		        	 $this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		        	$this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		        }
	        

			$this->data['userdetails'] = $this->report_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
	    	$this->data['options'] = $this->report_model->get_search_options($condition);
			$this->load->view('admin/reports/display_reports_list', $this->data);
		}
	}


	public function ajax_fetch_type_based_host_data()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['search_type_fetch'] = 4;
			$search_type = $this->input->get('search_type');
			$this->data['heading'] = 'Host Report';
			$this->load->library('pagination');
			$data['datefrom'] = $datefrom = $this->input->get('datefrom');
		  	$data['dateto'] =  $dateto = $this->input->get('dateto');
		    $data['search_name'] = $search_name = $this->input->get('search_name');
		    $data['status_order'] = $status_order = $this->input->get('status_order');


             if($dateto == ''){$datefrom = '';}
             $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
             if($datefrom != '' || $dateto != '' || $search_name != '' || $status_order != ''){
		    	

		    	 $this->db->select('u.*,pr.*,er.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.renter_id=u.id",'left');
             $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.renter_id=u.id",'left');
            $this->db->where(array('u.status'=> 'Active','u.group'=>'Seller'));
           $this->db->group_by('u.id');
            $limit_per_page = $this->db->get_where()->num_rows();
		    	
		    	$count_data = $this->report_model->get_allthe_details_hosts($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
	            $Total_properties = $count_data->num_rows();
	          $limit_per_page = 10;
		    }
		    else{
		    	
		    	 	
			  $this->db->select('u.*,pr.*,er.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.renter_id=u.id",'left');
             $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.renter_id=u.id",'left');
            $this->db->where(array('u.status'=> 'Active','u.group'=>'Seller'));
           $this->db->group_by('u.id');
            $Total_properties = $this->db->get_where()->num_rows();
	            $limit_per_page = 10;
		    }
           //echo $Total_properties;exit();

				$start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
	            $config['base_url'] = base_url() . 'admin/reports/ajax_fetch_type_based_host_data';
	            $config['total_rows'] = $Total_properties;
	            $config['per_page'] = $limit_per_page;
	            $config['uri_segment'] = 4;
	            $config['num_tag_open'] = '<li>';
	            $config['num_tag_close'] = '</li>';
	            $config['cur_tag_open'] = '<li class="active"><a>';
	            $config['cur_tag_close'] = '</a></li>';
	            $config['first_link'] = '<< ';
	            $config['first_tag_open'] = '<li>';
	            $config['first_tag_close'] = '</li>';
	            $config['last_link'] = ' >>';
	            $config['last_tag_open'] = '<li>';
	            $config['last_tag_close'] = '</li>';
	            $config['next_tag_open'] = '<li>';
	            $config['next_tag_close'] = '</li>';
	            $config['prev_tag_open'] = '<li>';
	            $config['prev_tag_close'] = '</li>';
	            $this->pagination->initialize($config);
	            $this->data["links"] = $this->pagination->create_links();
	            /*-----------------------*/
	         	$this->data['checkin'] = $_GET['checkin'];
	            $this->data['checkout'] = $_GET['checkout'];
		        if($search_type != ''){
		        	
		            $this->data['hostList'] = $this->report_model->get_allthe_details_hosts($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
		           //  echo "<pre>";
		           // print_r($this->data['hostList']->result());exit();
		         //   echo $this->db->last_query();exit();

		          	$this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		            $this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
		           
		            $this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));
// 		            echo "<pre>";
// print_r($this->data['hostList']->result());exit();
		        }
		        else{
		        	   $this->data['hostList'] = $this->report_model->get_allthe_details_hosts($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, $start_index);
  //echo $this->db->last_query();exit();
		        	 $this->data['experienceList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		        	 $this->data['productList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

		        	$this->data['usersList'] = $this->report_model->get_all_details(USERS,array('firstname' => 'fffffff'));

// 		        	echo "<pre>";
 //print_r($this->data['hostList']->num_rows());exit();
		        }
	        

			$this->data['userdetails'] = $this->report_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
	    	$this->data['options'] = $this->report_model->get_search_options($condition);
			$this->load->view('admin/reports/display_reports_list', $this->data);

		}
	}
	public function ExcelExport()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			if($this->uri->segment(4) == 'display_report_list'){
				$this->setErrorMessage('error','Please Select Any Option');
        redirect('admin/reports/display_report_list');
				
			}
			$this->data['search_type'] = $search_type = $this->uri->segment(4);
			$datefrom = $this->uri->segment(5);
		  	$dateto =  $this->uri->segment(6);
		    $search_name = $this->uri->segment(8);
		    $status_order = $this->uri->segment(7);
		    if($dateto == 'no'){
		    	$datefrom = '';
		    	$dateto = '';
		    }
		    if($search_name == 'no'){
		    	$search_name = '';
		    }
		    if($status_order == 'no'){
		    	$status_order = '';
		    }
		  
		    if($search_type == 'ajax_fetch_type_based_rental_data'){
		    	 $limit_per_page = $this->db->select('id')->get(PRODUCT)->num_rows();
		    	 
		    	$UserDetails =  $this->report_model->get_allthe_details($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, 0);


		    }
		   else if($search_type == 'ajax_fetch_type_based_experience_data'){

		   	$limit_per_page = $this->db->select('experience_id')->get(EXPERIENCE)->num_rows();
		    	
		    	$UserDetails = $this->report_model->get_allthe_details_experience($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, 0);
		    	
		    	
		    }
		    else if($search_type == 'ajax_fetch_type_based_guest_data'){

		    	$this->db->select('u.*,pr.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.user_id=u.id",'left');
            $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.user_id=u.id",'left');
             $this->db->where(array('u.group'=>'User'));
           	$this->db->group_by('u.id');
            $limit_per_page = $this->db->get_where()->num_rows();
		    	
		    	$UserDetails = $this->report_model->get_allthe_details_users($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, 0);

		    	
		    }
		    else if($search_type == 'ajax_fetch_type_based_host_data'){

		    	 $this->db->select('u.*,pr.*,er.*');
            $this->db->from(USERS . ' as u');
            $this->db->join(RENTALENQUIRY . ' as pr', "pr.renter_id=u.id",'left');
             $this->db->join(EXPERIENCE_ENQUIRY . ' as er', "er.renter_id=u.id",'left');
            $this->db->where(array('u.group'=>'Seller'));
           $this->db->group_by('u.id');
            $limit_per_page = $this->db->get_where()->num_rows();
		    	
		    	$UserDetails = $this->report_model->get_allthe_details_hosts($status_order, $search_name, $datefrom, $dateto, $_GET['id'], $rep_code, $limit_per_page, 0);
		    	// echo $this->db->last_query();
		    	// echo '<pre>';
		    	// print_r($UserDetails->result());exit;
		    }

		// echo "<pre>";
		//     	print_r($UserDetails->result());exit();
		
		$data['getCustomerDetails'] = $UserDetails->result_array();
		// echo "<pre>";
		// print_r($data['getCustomerDetails']);exit();
		if($search_type == 'ajax_fetch_type_based_rental_data'){
$this->load->view('admin/reports/reports_excel', $data);
		}
		else if($search_type == 'ajax_fetch_type_based_experience_data'){
			$this->load->view('admin/reports/exp_reports', $data);
		}
		else if($search_type == 'ajax_fetch_type_based_guest_data'){
			$this->load->view('admin/reports/guest_reports', $data);
		}
			else if($search_type == 'ajax_fetch_type_based_host_data'){
				$this->load->view('admin/reports/host_reports', $data);
			}

		}
		
	}
	/**
	 * 
	 * This function loads the selling product list page
	 */
	public function display_product_list(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Rentals List';
			$this->data['productList'] = $this->product_model->view_product_details('  where u.status="Active" or p.user_id=0 group by p.id order by p.created desc');
			$this->load->view('admin/rentals/display_product_list',$this->data);
		}
	}
	
	/**
	 * 
	 * This function loads the add new product form
	 */
	public function add_product_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Rental';
			$product_id=$this->data['Product_id'] = $this->uri->segment(4,0);
			
		
		
			
		
			
			
			
			
		
			
		
		/*edit form code added 29/05/2014 */
		
		 $id=$this->uri->segment(4,0);
		 $hotel_id = $this->uri->segment(4);
		
			
			if($hotel_id!='') {
				$condition=array('id'=>$hotel_id);
				$condition = array(TOUR.'.id' => $hotel_id);
				//$this->data['product_details']=$this->tour_model->display_tour_list($condition);
				$this->data['product_details'] = $this->product_model->view_product1($hotel_id);
				
			}
		} 	
			$this->load->view('admin/rentals/add_product',$this->data);
		
	}
	
	public function UpdateProduct(){}
	
	/** 
	* 
	*  Inserr the Product using Ajax added 26/05/2014 */
	
	 public function insert_general_info()
		{ 
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		} else {
					$condition='';
					$catID = $this->input->post('rental_id');	
					$title = $this->input->post('product_title');
					$seourl = url_title($title, '-', TRUE);
					$checkSeo = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl));
					$seo_count = 1;
					while ($checkSeo->num_rows()>0){
						$seourl = $seourl.$seo_count;
						$seo_count++;
						$checkSeo = $this->product_model->get_all_details(PRODUCT,array('seourl'=>$seourl));
					}
					
					$dataArr = array( 'user_id' => $this->input->post('user_id'),'product_name' => $title,'product_title' => $title,'seourl' => $seourl);
					$excludeArr =array( 'product_title','catID','chk','rental_id','user_id');
					if($catID==0) {			
						$this->product_model->commonInsertUpdate(PRODUCT,'insert',$excludeArr,$dataArr,$condition);	
						$returnArr['resultval']=$insert_id = $this->db->insert_id();	
						$inputArr = array('product_id' =>$insert_id);
						$this->product_model->simple_insert(PRODUCT_ADDRESS,$inputArr);
						$this->product_model->simple_insert(PRODUCT_BOOKING,$inputArr);
						$this->product_model->simple_insert(SCHEDULE,array('id'=>$insert_id));
						redirect('admin/rentals/add_rental_photo/'.$insert_id);
					}else { 
						$condition=array('id'=>$this->input->post('rental_id'));
						$this->product_model->commonInsertUpdate(PRODUCT,'update',$excludeArr,$dataArr,$condition);	
						redirect('admin/rentals/add_rental_photo/'.$catID);
					}
						
					
				}
		}
		
	public function dragimageuploadinsert()
		{
			$val = $this->uri->segment(4,0);
			$this->data['prod_id']=$val;
			
			$this->load->view('admin/rentals/dragndrop',$this->data);
			//$this->load->view('site/product/photos_listing');
		}
		
	/** image upload */
	 public function InsertProductImage1($prd_id) {
	    $prd_id = $this->input->post('prdiii');
		$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
		$max_file_size = 1024*10000; //100 kb
		$path = "server/php/rental/"; // Upload directory
		$count = 0;
		
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
			// Loop $_FILES to execute all files
			foreach ($_FILES['files']['name'] as $f => $name) {     
				if ($_FILES['files']['error'][$f] == 4) {
					continue; // Skip file if any error found
				}	       
				if ($_FILES['files']['error'][$f] == 0) {	           
					if ($_FILES['files']['size'][$f] > $max_file_size) {
						$message[] = "$name is too large!.";
						//redirect('admin/product/add_product_form/'.$prd_id);
						
						continue; // Skip large files
						
					}
					elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
						$message[] = "$name is not a valid format";
						continue; // Skip invalid file formats
					}
					else{ // No error found! Move uploaded files 
						if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name)) {
							$filename[] =$_FILES["files"]["name"][$f];
							$count++; // Number of successfully uploaded files
						}
					}
				}
			}
		}
		for($i=0;$i<count($filename);$i++) {	
			   if(!empty($filename[$i])) {
			   // print_r($img_name[$i]);
				$filePRoductUploadData = array('product_id'=>$prd_id,'product_image'=>$filename[$i]);
			    $this->product_model->simple_insert(PRODUCT_PHOTOS,$filePRoductUploadData);
				
				
			   } 
			   else {
			    print_r("File is empty");
				$this->setErrorMessage('error','You cannot choose image');
				
				
			   }
			   
		}
		redirect('admin/rentals/add_rental_photo/'.$prd_id);
		return true;
	 
		}
		
		public function AddAmenities_form(){
			///////////////////
		if ($this->checkLogin('A') == ''){
			redirect('admin');	redirect('admin');
		}else {
			$this->data['heading'] = 'Edit Rental';
			$product_id = $this->uri->segment(4,0);
			
			$condition = array('id' => $product_id);
			$this->data['product_details'] = $this->product_model->view_product1($product_id);
			$this->data['getCommonFacilityDetails'] = $this->product_model->getCommonFacilityDetails();
			$this->data['getCommonFacilityDetails'] = $this->product_model->getCommonFacilityDetails();
			$this->data['getExtraFacilityDetails'] = $this->product_model->getExtraFacilityDetails();
			$this->data['getSpecialFeatureFacilityDetails'] = $this->product_model->getSpecialFeatureFacilityDetails();
			$this->data['getHomeSafetyFacilityDetails'] = $this->product_model->getHomeSafetyFacilityDetails();
		}
			/////////////////////
			$this->load->view('admin/rentals/add_amenities',$this->data);
		}
	public function addAmenities()
		{
			
			$listname = $this->input->post('list_name');
			$id = $this->input->post('prdiii');	
			$condition=array('id'=>$id);
			$facility = @implode(',',$this->input->post('list_name'));		
			$facility_list = array('list_name' => $facility);
			$this->product_model->edit_product($facility_list,$condition);	
			redirect('admin/rentals/AddaddressForm/'.$id);
			//$this->load->view('site/product/photos_listing');
		}
			
		public function AddaddressForm()
		{
			$this->data['heading'] = 'Edit Rental';
			$product_id = $this->uri->segment(4,0);
			$this->data['product_details'] = $this->product_model->view_product1($product_id);
			
			$this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST,array('status'=>'Active'));
				$this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX,array('status'=>'Active'));
				$this->data['RentalCity'] =  $this->product_model->get_all_details(CITY,array('status'=>'Active'));
				
				$this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE,array('status'=>'Active'));
				$this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES,array('status'=>'Active'));
				$list_valueArr=explode(',',$this->data['product_details']->row()->list_value);
				$listIdArr=array();
			redirect('admin/rentals/AddaddressForm/'.$id);
			//$this->load->view('site/product/photos_listing');
		}	
		/**
	 * 
	 * This function loads the add new product form
	 */
	public function add_rental_general_info_form(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Rental';
			$product_id=$this->data['Product_id'] = $this->uri->segment(4,0);
			$this->data['userdetails'] =  $this->product_model->get_selected_fields_records('id,firstname,lastname',USERS,'where status="Active"');
		 	$id=$this->uri->segment(4,0);
			if($id!='') {
				$this->data['product_details'] = $this->product_model->view_product1($id);
				
			}
			$this->load->view('admin/rentals/add_product',$this->data);
		
		}
	}
	
	public function add_rental_photo(){
		if ($this->checkLogin('A') == ''){
			redirect('admin');
		}else {
			$this->data['heading'] = 'Add New Rental';
		 	$id=$this->uri->segment(4,0);
			if($id!='') {
				$this->data['product_details'] = $this->product_model->view_product1($id);
				if ($this->data['product_details']->num_rows() == 1){
					$this->data['imgDetail'] = $this->product_model->get_images($id);
				}
			}
			$this->load->view('admin/rentals/add_rentals_photo',$this->data);
		}
	}

	public function autocomplete_name(){
$term=$_POST["term"];
$search_type = $this->uri->segment(4);

 $query="SELECT DISTINCT product_title FROM fc_product where product_title like '%".$term."%'";

 $query_fetch = $this->report_model->ExecuteQuery($query);
// print_r($query->result());exit();
// $this->product_model->ExecuteQuery($service_tax_query);
 $name = '<div id="name-list">';

foreach($query_fetch->result() as $query_result)
{
    $prp = trim($query_result->product_title);
   $name .='<input onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;" type="text" value="'.$prp.'" readonly/>';
  //  $name .='<a onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;">'. $query_result->product_title.'</a><br>';

}
$name .= '</div>';

echo $name;
}

public function ajax_autocomplete_name_exp(){
$term=$_POST["term"];
$search_type = $this->uri->segment(4);

 $query="SELECT DISTINCT experience_title FROM fc_experiences where experience_title like '%".$term."%'";

 $query_fetch = $this->report_model->ExecuteQuery($query);
// print_r($query->result());exit();
// $this->product_model->ExecuteQuery($service_tax_query);
 $name = '<div id="name-list">';

foreach($query_fetch->result() as $query_result)
{
    $prp = trim($query_result->experience_title);
   $name .='<input onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;" type="text" value="'.$prp.'" readonly/>';
  //  $name .='<a onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;">'. $query_result->product_title.'</a><br>';

}
$name .= '</div>';

echo $name;
}

public function ajax_autocomplete_name_guest(){
$term=$_POST["term"];
$search_type = $this->uri->segment(4);

 $query="SELECT DISTINCT firstname FROM fc_users where firstname like '%".$term."%'";

 $query_fetch = $this->report_model->ExecuteQuery($query);
// print_r($query->result());exit();
// $this->product_model->ExecuteQuery($service_tax_query);
 $name = '<div id="name-list">';

foreach($query_fetch->result() as $query_result)
{
    $prp = trim($query_result->firstname.' '.$query_result->lastname);
   $name .='<input onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;" type="text" value="'.$prp.'" readonly/>';
  //  $name .='<a onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;">'. $query_result->product_title.'</a><br>';

}
$name .= '</div>';

echo $name;
}

public function ajax_autocomplete_name_host(){
$term=$_POST["term"];
$search_type = $this->uri->segment(4);

 $query="SELECT DISTINCT firstname FROM fc_users where firstname like '%".$term."%'";

 $query_fetch = $this->report_model->ExecuteQuery($query);
// print_r($query->result());exit();
// $this->product_model->ExecuteQuery($service_tax_query);
 $name = '<div id="name-list">';

foreach($query_fetch->result() as $query_result)
{
    $prp = trim($query_result->firstname.' '.$query_result->lastname);
   $name .='<input onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;" type="text" value="'.$prp.'" readonly/>';
  //  $name .='<a onclick="selectCountry(this.value);" style="cursor: pointer;color: #000;">'. $query_result->product_title.'</a><br>';

}
$name .= '</div>';

echo $name;
}
}

/* End of file product.php */
/* Location: ./application/controllers/admin/product.php */