<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Experience management
 * Experience mentioned as 'Experience'
 * @author Teamtweaks
 *
 */
class Manage_rentals extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation', 'image_lib', 'resizeimage', 'email'));
		$this->load->model('experience_model');
		$this->load->model('product_model');
		if ($this->checkPrivileges('Properties', $this->privStatus) == FALSE) {
			redirect('admin');
		}
		$id = $this->uri->segment(5, 0);
		$this->data['basics'] = 0;
		$this->data['location_tab'] = 0;
		$this->data['price'] = 0;
		$this->data['overview'] = 0;
		$this->data['addtional_details'] = 0;
		$this->data['photos'] = 0;
		$this->data['amenities'] = 0;
		$this->data['listings'] = 0;
		$this->data['cancel_policy'] = 0;
		$this->data['procedure'] = 0;
		$this->data['addtional_price'] = 0;
		$this->data['doctor'] = 0;
		
		$this->data['procedures'] = 0;

		if ($id != '') {

			$condition = array('id' => $id);
			$all_details = $this->product_model->get_all_details(PRODUCT, $condition);
			$data = $all_details->row();
			
			
			
			if (!empty($data)) {
				//if ($data->home_type != '' && $data->room_type != '' && $data->user_id != '') {
				if ($data->user_id != '') {
					$this->data['basics'] = 1;
				}
				$loc_data = $this->product_model->get_selected_fields_records('id', 'fc_product_address_new', ' where productId=' . $id);
				
				if ($loc_data->num_rows() > 0) {
					$this->data['location_tab'] = 1;
				}
				if ($data->price > 0) {
					$this->data['price'] = 1;
				}
				if ($data->product_title != '' && $data->description != '') {
					$this->data['overview'] = 1;
				}
				if ($data->other_thingnote != '' || $data->house_rules != '' || $data->guest_access != '' || $data->guest_access_ph != '' || $data->interact_guest != '' || $data->neighbor_overview != '') {
					$this->data['addtional_details'] = 1;
				}
				$dat_img = $this->product_model->get_selected_fields_records('id', PRODUCT_PHOTOS, ' where product_id=' . $id . ' and product_image !=""');
				if ($dat_img->num_rows() > 0) {
					$this->data['photos'] = 1;
				}
				if ($data->list_name != '') {
					$this->data['amenities'] = 1;
				}
				if ($data->listings != '') {
					$this->data['listings'] = 1;
				}
				if ($data->cancellation_policy != '') {
					$this->data['cancel_policy'] = 1;
				}
			
			}
		}
	}


	



	/*** mail publish/Unpublish ***/
	public function publish_mail()
	{
		/* Admin Mail function */
		//$username = username
		$email = $_POST['email'];
		$firstname = $_POST['firstname'];
		$newsid = '51';
		$template_values = $this->experience_model->get_newsletter_template_details($newsid);
		if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
			$sender_email = $this->data['siteContactMail'];
			$sender_name = $this->data['siteTitle'];
		} else {
			$sender_name = $template_values['sender_name'];
			$sender_email = $template_values['sender_email'];
		}
		//$cfmurl = 'Host has approved your property and it is showing in listing page.';
		$logo_mail = $this->data['logo'];
		$email_values = array(
			'from_mail_id' => $sender_email,
			'to_mail_id' => $email,
			'subject_message' => $template_values ['news_subject'],
			'body_messages' => $message
		);
		$reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail);
		//print_r($this->data['logo']);
		$message = $this->load->view('newsletter/AdminExperienceApprove' . $newsid . '.php', $reg, TRUE);
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
		redirect('admin/product/display_product_list');
		/* Admin Mail function End */
	}

	public function unpublish_mail()
	{
		/* Admin Mail function */
		$email = $_POST['email'];
		$firstname = $_POST['firstname'];
		$newsid = '52';
		$template_values = $this->experience_model->get_newsletter_template_details($newsid);
		if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
			$sender_email = $this->data['siteContactMail'];
			$sender_name = $this->data['siteTitle'];
		} else {
			$sender_name = $template_values['sender_name'];
			$sender_email = $template_values['sender_email'];
		}
		//$cfmurl = 'Host has approved your property and it is showing in listing page.';
		$logo_mail = $this->data['logo'];
		$email_values = array(
			'from_mail_id' => $sender_email,
			'to_mail_id' => $email,
			'subject_message' => $template_values ['news_subject'],
			'body_messages' => $message
		);
		$reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail);
		//print_r($this->data['logo']);
		$message = $this->load->view('newsletter/AdminExperienceUnapproved' . $newsid . '.php', $reg, TRUE);
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
		redirect('admin/product/display_product_list');
		/* Admin Mail function End */
	}


	/**
	 *
	 *Function to add and edit experience 
	 */
	public function add_new_rentals($rental_type='',$id = '')
	{
		//echo $id;exit();
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			//echo $rental_type.'/'.$id; exit;
			if ($this->uri->segment(4, 0) == '') {
				$this->data['heading'] = 'Hotel Rentals';
			} else {
				$this->data['heading'] = 'Rentals';
			}
			//doctor_listing
			 $this->data['doctor_list_Residency_doc'] = 0;
			  $condition =array('status' => 'Active');
            $this->data['cities'] = $this->product_model->get_all_details(CITY, $condition);
            $this->data['countries'] = $this->product_model->get_all_details(COUNTRY_LIST, $condition);
            $this->data['states'] = $this->product_model->get_all_details(STATE_TAX, $condition);
             $condition = array('id' => $id);
            $this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, $condition);
           
//print_r($this->data['listDetail']->result());exit();
            //end_of_doctor_listing

             //procedure_listing

   			$condition =array('status' => 'Active');
            $this->data['cities'] = $this->product_model->get_all_details(CITY, $condition);
            $this->data['countries'] = $this->product_model->get_all_details(COUNTRY_LIST, $condition);
            $this->data['states'] = $this->product_model->get_all_details(STATE_TAX, $condition);
            $condition = array('id' => $id, 'user_id' => $this->checkLogin('U'));
            $this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, $condition);
            $condition =array('id' => $id);
            $this->data['procedure_types'] = $this->product_model->get_all_details(PRODUCT, $condition);
            $condition =array('hosp_id' => $id);
            $this->data['procedure_list'] = 0;
            $this->data['currency_code_is'] = $this->data['procedure_types']->row()->currency;
   
$proced_type = explode(',', $this->data['procedure_types']->row()->procedure_type_id);
       //  exit();
          
                $this->data['currencyDetail'] = $currencies = $this->product_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
                $currencytypes = array('0' => 'Select Currency');
                foreach ($currencies->result() as $value) {
                    $currencyid = $value->id;
                    if ($currencyid != "") {
                        $currencytypes[$value->currency_type] = $value->currency_type;
                    }
                }
                $this->data['currencytypes'] = $currencytypes;
                $this->data['getDefaultCurrency'] = $this->product_model->get_all_details(CURRENCY, array('status' => 'Active', 'default_currency' => 'Yes'));
                if ($this->data['listDetail']->row()->currency != '') {
                    $currentCurrency = $this->product_model->get_all_details(CURRENCY, array('currency_type' => $this->data['listDetail']->row()->currency));
                    $this->data['currentCurrency'] = $currentCurrency->row()->currency_symbols;
                }
               
                
               $this->db->select('*');
                $this->db->from(LISTSPACE_VALUES);
                $this->db->where_in('id', $proced_type);
                 $this->data['procedure_type_list'] =  $this->db->get();

                
                
                $this->data['doctor_list_Residency'] =  0;

                //additional_price
               
                $this->data['addons_list'] =  0;
                 $this->data['rooms_types'] = $this->db->select('*')->from('fc_listspace_values')->where('listspace_id','11')->get();
                  $this->data['proced_list'] = 0;
                  $this->data['currencyDetail'] = $currencies = $this->product_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
                $currencytypes = array('0' => 'Select Currency');
                foreach ($currencies->result() as $value) {
                    $currencyid = $value->id;
                    if ($currencyid != "") {
                        $currencytypes[$value->currency_type] = $value->currency_type;
                    }
                }
                $this->data['currencytypes'] = $currencytypes;
                $this->data['getDefaultCurrency'] = $this->product_model->get_all_details(CURRENCY, array('status' => 'Active', 'default_currency' => 'Yes'));
                //end of additional_price



			/* starts here */
			//$rental_type=1;
			$condition = array('status' => 'Active'); 
			$listspace = $this->product_model->get_all_details(LISTSPACE, $condition);
			$property_type = array();
			$property_label = array();
			foreach ($listspace->result() as $value) {
				//$listspaceid = $value->toId;//old
				$listspaceid = $value->id;//nagoor
				if ($listspaceid != "") {
					//$propertycondition = array('listspace_id' => $listspaceid, 'other' => 'yes');
					$propertycondition = array('listspace_id' => $listspaceid,'status' => 'Active');
					$propertytypes = $this->product_model->get_all_details(fc_listspace_values, $propertycondition);
					//print_r($propertytypes->result()); exit;
					if ($propertytypes->num_rows() > 0) {
						foreach ($propertytypes->result() as $lists) {
							$property = "";
						 //if($this->session->userdata('language_code') =='en') { $field = 'list_value'; } else { $field='list_value_ph'; } 
						  $field = 'list_value';
						   $property_type[$listspaceid][$lists->id] = $lists->$field;
							if ($value->attribute_seourl == strtolower("PropertyType")) {
								$property = ucfirst($value->attribute_name);
							} else {
								$property = ucfirst($value->attribute_name);
							}
							$property_label[$listspaceid] = $property;
						}
					}
				}
			}
			$this->data['rental_type'] = $rental_type;
			$this->data['property_type'] = $property_type;
			$this->data['property_label'] = $property_label;
			/* ends here */
			$product_id = $this->data['Product_id'] = $id;
			$this->data['productAddressData'] = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId' => $product_id));

			$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
			
			$this->data['productOldAddress'] = $this->product_model->get_old_address($product_id);
			/*Rental Address*/
			$this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST, array('status' => 'Active'), array(array('field' => 'name', 'type' => 'asc')));
			$this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
			$this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
			$this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname,email', USERS, 'where status="Active" and host_status=0');
			/*currency list*/
			$this->data['currencyList'] = $this->product_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
			$this->data['imgDetail'] = $this->product_model->get_images($product_id);
		}
		
		//$this->data['listchildValues'] = $this->db->select('*')->from('fc_listing_child')->where('rental_type',$rental_type)->get();
		$this->data['listSpace'] = $this->product_model->get_all_details(LISTSPACE, array('status' => 'Active'));  // rental sub type
		$this->data['listTypeValues'] = $this->product_model->get_all_details(LISTING_TYPES, array('status' => 'Active')); // features
		$this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));  // Amenities
		$this->data['listchildValues'] = $this->product_model->get_selected_fields_records('id,parent_id,child_name,status',LISTING_CHILD,' ORDER BY child_name ASC');
		$languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
		$this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
		//$this->data['experienceTypeList'] = $this->product_model->view_experienceType_details();
		/*edit form code*/
		//$id = $this->uri->segment(4, 0);
		$hotel_id = $id;
		if ($hotel_id != '') {
			$this->data['product_details'] = $this->product_model->view_product1($hotel_id);
			if ($this->data['product_details']->num_rows() > 0) {
				if ($this->data['product_details']->row()->language_list != '') {
					$this->data['language_list'] = $this->product_model->ExecuteQuery("select language_name from " . LANGUAGES_KNOWN . " where language_code in (" . $this->data['product_details']->row()->language_list . ") ");
				}
			}
			$condition = array('id' => $hotel_id);
			//$this->data['date_details'] = $this->product_model->get_all_details(EXPERIENCE_DATES, $condition);
			//$this->data['guide_provides'] = $this->product_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
			//$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, $condition);
			$this->data['listDetail'] = $this->product_model->view_product_details_site("where p.id=$hotel_id");			
			if ($this->data['listDetail']->row()->currency != '') {
				$currentCurrency = $this->product_model->get_all_details(CURRENCY, array('currency_type' => $this->data['listDetail']->row()->currency));
				$this->data['currentCurrency'] = $currentCurrency->row()->currency_symbols;
				$this->data['currentCurrency_type'] = $currentCurrency->row()->currency_type;
			}
			//$date_time_details = $this->product_model->get_date_time_details($product_id);
			//$this->data['date_details'] = $date_time_details;
		}
		//print_r($this->data['product_details']->row()); exit;
		$this->load->library('googlemaps');
		$config['center'] = '37.4419, -122.1419';
		$config['zoom'] = 'auto';
		$this->googlemaps->initialize($config);
		$marker = array();
		$marker['position'] = '37.429, -122.1419';
		$marker['draggable'] = true;
		$marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
		$this->googlemaps->add_marker($marker);
		$this->data['map'] = $this->googlemaps->create_map();
		$this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
		$this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
		$this->data['id'] = $id;
		$minimum_stay = $this->experience_model->get_data_minimum_stay();
		$this->data['minimum_stay'] = $minimum_stay->result();
		$currentCurrency = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'));
		$this->data['currentCurrency_all'] = $currentCurrency->result();
		$this->load->view('admin/product/add_product', $this->data);
	}
	public function update_rentals_general($id)
	{	/*print_r($this->input->post()); exit;Array ( [rental_type] => 3 [org_current_user_id] => 73 [user_id] => 73 [Property_type] => 58 [Room_Type] => 60 )  */
		
		
		$user_id = $this->input->post('user_id');
		$hometype = $this->input->post('property_type');
		$roomtype = $this->input->post('room_Type');
		$other = $this->input->post('other');
	//	$procedure_type_id_Arr = $this->input->post('procedure_type_id');
		
	//	$procedure_type_id = implode(',',$procedure_type_id_Arr);
		


		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			
			$data = array( 'user_id' => $user_id, 'home_type' => $hometype,'room_type'=>$roomtype);
			//print_r($data);exit();
			$this->product_model->update_details(PRODUCT,array('id' => $id));
			$this->setErrorMessage('success', 'Rentals details updated successfully');
			echo json_encode(array("id" => $id, "status" => 1));
		}
	}

	/**
	 *
	 * This function add new experience
	 */
	public function add_rentals_new()
	{
		$rental_type = $this->input->post('rental_type');
		$hometype = $this->input->post('propertytype');
        $roomtype = $this->input->post('roomtype');
		$user_id = $this->input->post('user_id');
		//$other = $this->input->post('other');
	//	$procedure_type_id_Arr = $this->input->post('procedure_type_id');
		// $procedure_type_id = implode(',',$procedure_type_id_Arr);
		
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$data = array('home_type' => $hometype,'room_type' => $roomtype,'user_id' => $user_id, 'status' => 'UnPublish', 'instant_pay' => 'No', 'request_to_book' => 'Yes','calendar_checked'=>'always','currency' => '');
            $this->product_model->simple_insert(PRODUCT, $data);
			$getInsertId = $this->product_model->get_last_insert_id();
			
			$inputArr3 = array('product_id' => $getInsertId);
            $this->product_model->simple_insert(PRODUCT_BOOKING, $inputArr3);
			
			$inputArr4 = array('id' => $getInsertId);
            $this->product_model->simple_insert(SCHEDULE, $inputArr4);
			$this->product_model->update_details(USERS, array('group' => 'Seller'), array('id' => $user_id));
			
			$this->setErrorMessage('success', 'Rentals Basic details saved successfully');
			echo json_encode(array("id" => $getInsertId, "status" => 1));
		}
	}


	public function add_exp_video_url($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$video_url = $this->input->post('video_url');
			$condition = array('id' => $expid);
			$data = array( 'video_url' => $video_url );
			$this->experience_model->update_details(PRODUCT, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}
	public function add_amenities()
	{
		if ($this->checkLogin('A') != '') {
			$pro_id = $this->input->post('pro_id');
			$list_values = $this->input->post('list_values');
			$combine_list_val = implode(',', $list_values);
            $dataArr = array('list_name' => $combine_list_val);
            $this->db->where('id', $pro_id)->update('fc_product', $dataArr);
            echo 1;

		} else {
			redirect('admin');
		}
	}
	
	public function add_listings()
	{
		if ($this->checkLogin('A') != '') {
			/*$pro_id = $this->input->post('pro_id');
			$list_values = $this->input->post('list_values');
			$combine_list_val = implode(',', $list_values);
            $dataArr = array('list_name' => $combine_list_val);
            $this->db->where('id', $pro_id)->update('fc_product', $dataArr);
            echo 1;*/
			print_r($_POST);
		} else {
			redirect('admin');
		}
	}
	

	public function add_addtionalDetail($expid = '')
	{
		if ($this->checkLogin('A') != '') {
		
			$other_thingnote = $this->input->post('other_thingnote');
			//$other_thingnote_ph = $this->input->post('other_thingnote_ph');
			$house_rules = $this->input->post('house_rules');
			//$house_rules_ph = $this->input->post('house_rules_ph');
			$guest_access = $this->input->post('guest_access');
			//$guest_access_ph = $this->input->post('guest_access_ph');
			$interact_guest = $this->input->post('interact_guest');
			//$interact_guest_ph = $this->input->post('interact_guest_ph');
			$neighbor_overview = $this->input->post('neighbor_overview');
			//$neighbor_overview_ph = $this->input->post('neighbor_overview_ph');
			$space = $this->input->post('space');
		//	$space_ph = $this->input->post('space_ph');
			$condition = array('id' => $expid);


			$data=array('space' 				=> $space,
						'other_thingnote' 		=> $other_thingnote,
						'house_rules' 			=> $house_rules,
						'guest_access' 			=> $guest_access,
						'interact_guest' 		=> $interact_guest,
						'neighbor_overview' 	=> $neighbor_overview,
						);
			foreach(language_dynamic_enable("space","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("other_thingnote","") as $dynlang) {
                $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("house_rules","") as $dynlang) {
                $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("guest_access","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("interact_guest","") as $dynlang) {
                $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
			foreach(language_dynamic_enable("neighbor_overview","") as $dynlang) {
                $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));              
            }    
            
			$this->product_model->update_details(PRODUCT, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}

	public function add_overview($expid = '')
	{

		if ($this->checkLogin('A') != '') {
			$product_title = $this->input->post('product_title');
			$seourl = url_title($product_title, '-', TRUE);
            $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $expid));
			$seo_count = 1;
            while ($checkSeo->num_rows() > 0) {
                $seourl = $seourl . $seo_count;
                $seo_count++;
                $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $expid));
            }
            
			//$product_title_ar = $this->input->post('product_title_ar');
			$description = $this->input->post('description');
		//	$description_ar = $this->input->post('description_ar');
			$request_to_book = $this->input->post('request_to_book');
			$instant_pay = $this->input->post('instant_pay');
			$condition = array('id' => $expid);
			$data=array('seourl'			=> $seourl,
						'product_title' 	=> $product_title,
						// 'product_title_ar'  => $product_title_ar,
						'description' 		=> $description,
						// 'description_ar'	=> $description_ar,
						'request_to_book' 	=> $request_to_book,
						'instant_pay' 		=> $instant_pay
						);
			   foreach(language_dynamic_enable("product_title","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("description","") as $dynlang) {
                $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

			$this->product_model->update_details(PRODUCT, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo '1';
		} else {
			redirect('admin');
		}
	}

	

	public function add_price($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			$price = $this->input->post('price');			
			$currency = $this->input->post('currency');
			$condition = array('id`' => $expid);
			$data = array(
				'currency' => $currency,
				'price' => $price
			);
			$this->product_model->update_details(PRODUCT, $data, $condition);
			//$this->product_model->update_details(EXPERIENCE_DATES, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
			//redirect('admin/experience/add_experience_form_new/'.$expid.'#cancel_policy_tab');
		} else {
			redirect('admin');
		}
	}

	public function add_cancel_policy($expid = '')
	{
		if ($this->checkLogin('A') != '') {
			// print_r($_POST);exit();
			$cancel_policy = $this->input->post('cancel_policy');
			$cancel_policy_des = $this->input->post('cancel_policy_des'); 
		//	$cancel_policy_ar = $this->input->post('cancel_policy_ar'); 
			$security_deposit = $this->input->post('sec_deposit');
			if ($cancel_policy == 'Strict') {
				$cancel_percentage = 100; //100% Amount to host
			} else {
				$cancel_percentage = $this->input->post('cancel_percentage');
			}
			$condition = array('id' => $expid);
			$data = array(
				'cancellation_policy' => $cancel_policy,
				'cancel_description' => $cancel_policy_des,
				// 'cancel_description_ar' => $cancel_policy_ar,
				'cancel_percentage' => $cancel_percentage,
				'security_deposit' => $security_deposit,
				'meta_title' 		=> $this->input->post('meta_title'),
				//'meta_title_ar'		=> $this->input->post('meta_title_ar'),
				'meta_keyword' 		=> $this->input->post('meta_keyword'),
				//'meta_keyword_ar'	=> $this->input->post('meta_keyword_ar'),
				'meta_description' 	=> $this->input->post('meta_description'),
				//'meta_description_ar' => $this->input->post('meta_description_ar')
			);

			$fieldname=array("cancel_description","meta_title", "meta_keyword","meta_description");
foreach($fieldname as $fieldnm) {
			  foreach(language_dynamic_enable($fieldnm, "") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));




            }}
           // print_r($data);exit();
			$this->experience_model->update_details(PRODUCT, $data, $condition);
			$this->setErrorMessage('success', 'Saved successfully');
			echo 1;
		} else {
			redirect('admin');
		}
	}


	public function todateCalculate()
	{
		$from_date = $this->input->post('from_date');
		$date_count = $this->input->post('date_count');
		$tot_date = $date_count - 1;
		if ($date_count > 1)
			$to_date = date("Y-m-d", strtotime('+' . $tot_date . ' days', strtotime($from_date)));
		else
			$to_date = date("Y-m-d", strtotime($from_date));
		echo $to_date;
	}

	
	//General info update ends
	//location
	public function save_address()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			/*if ($this->input->post('pro_id') != '') {
				$pro_id = $this->input->post('pro_id');
			} else {
				$pro_id = $this->input->post('edit_pro_id');
			}*/
			$pro_id = $this->input->post('edit_pro_id');

			$location = $this->input->post('location');
			$country = $this->input->post('country');
			$state = $this->input->post('state');
			$city = $this->input->post('city');
			$apt = $this->input->post('apt');
			$post_code = $this->input->post('post_code');
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			$rental_type = $this->input->post('rental_type');
			if ($latitude == null || $latitude == '') {
				$latitude = '0';
			}
			if ($longitude == null || $longitude == '') {
				$longitude = '0';
			}
			$dataArr = array('address' => $location, 'street' => $apt, 'city' => $city, 'state' => $state, 'country' => $country, 'lang' => $longitude, 'lat' => $latitude, 'zip' => $post_code);
			$product_id = array('productId' => $pro_id);
			$data = array_merge($dataArr, $product_id);
			$check = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId' => $pro_id));
			if ($check->num_rows() > 0) {
				$this->product_model->update_details(PRODUCT_ADDRESS_NEW, $dataArr, array('productId' => $pro_id));
			} else {
				$this->product_model->simple_insert(PRODUCT_ADDRESS_NEW, $data);
			}
			//$this->db->where('experience_id',$pro_id)->update(EXPERIENCE_ADDR,$dataArr);
			//echo $this->db->last_query();
			//$this->db->where('experience_id', $pro_id)->update(EXPERIENCE, array('location' => $location));
			$returnArr['resultval'] = 'Updated';
			echo json_encode($returnArr);
		}
	}


	/* delete kit ends */
	/*  Delete experience image starts */
	public function deleteProductImage()
	{
		$returnArr['resultval'] = '';
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$prdID = $this->input->post('prdID');
			$photo_details = $this->db->select('*')->from(PRODUCT_PHOTOS)->where('id', $prdID)->get();
			foreach ($photo_details->result() as $image_name) {
				$gambar = $image_name->product_image;
				unlink("images/rentals/" . $gambar);
			}
			/*Image Unlink*/
			$this->product_model->commonDelete(PRODUCT_PHOTOS, array('id' => $prdID));
			$returnArr['resultval'] = $prdID;
			echo json_encode($returnArr);
		}
	}
	/* Delete experience image ends */
	/* Image adding popup starts */
	public function dragimageuploadinsert()
	{
		$val = $this->uri->segment(4, 0);
		$this->data['prod_id'] = $val;
		$this->load->view('admin/product/dragndrop', $this->data);
		//$this->load->view('site/product/photos_listing');
	}

	

	public function getExtension($str)
	{
		$i = strrpos($str, ".");
		if (!$i) {
			return "";
		}
		$l = strlen($str) - $i;
		$ext = substr($str, $i + 1, $l);
		return $ext;
	}

/* experience add & edit  ajax function ends  */
	/* Experience Ends */
}

/* End of file experience.php */
/* Location: ./application/controllers/admin/experience.php */
