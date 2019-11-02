<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * URI:               http://www.homestaydnn.com/property?ooty
 * Description:       Map search control.
 * Version:           2.0
 * Author:            Sathyaseelan,Vishnu
 **/
class Rentals extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form', 'email', 'text', 'html'));
		$this->load->library(array('form_validation'));
		$this->load->model(array('product_model', 'user_model'));
		$this->load->library('pagination');
		if ($_SESSION ['sMainCategories'] == '') {
			$sortArr1 = array('field' => 'cat_position', 'type' => 'asc');
			$sortArr = array($sortArr1);
			$_SESSION ['sMainCategories'] = $this->product_model->get_all_details(CATEGORY, array('rootID' => '0', 'status' => 'Active'), $sortArr);
		}
		$this->data ['mainCategories'] = $_SESSION ['sMainCategories'];
		if ($_SESSION ['sColorLists'] == '') {
			$_SESSION ['sColorLists'] = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => '1'));
		}
		$this->data ['mainColorLists'] = $_SESSION ['sColorLists'];
		$this->data ['loginCheck'] = $this->checkLogin('U');
		$this->data ['likedProducts'] = array();
		if ($this->data ['loginCheck'] != '') {
			$this->data ['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES, array('user_id' => $this->checkLogin('U')));
		}
	}

	/*Creating wishlist category*/
	public function rentalwishlistcategoryAdd()
	{
		$wishuser_id = $this->session->userdata('fc_session_user_id');
		$wishcatname = $this->input->post('list_name');
		$val = $this->input->post('whocansee');
		$list_id = $this->input->post('list_id');
		if ($val == '0' or $val = "") {
			$whocansee = 'Everyone';
		} else {
			$whocansee = 'Only me';
		}
		if ($list_id != '') {
			$this->data ['WishListCat'] = $this->product_model->get_all_details(LISTS_DETAILS, array('user_id' => $wishuser_id, 'name' => $wishcatname, 'id !=' => $list_id));
			if ($this->data ['WishListCat']->num_rows() > 0) {
				$res ['result'] = '1';
			} else {
				$this->product_model->update_details(LISTS_DETAILS, array('user_id' => $wishuser_id, 'name' => ucfirst($wishcatname), 'whocansee' => $whocansee), array('id' => $list_id));
				$res ['result'] = '5';
			}
		} else {
			$this->data ['WishListCat'] = $this->product_model->check_users_lists($wishuser_id, $wishcatname);
			if ($this->data ['WishListCat']->num_rows() > 0) {
				$res ['result'] = '1';
			} else {
				$res ['result'] = '0';
				$data = $this->product_model->add_wishlist_category(array('user_id' => $wishuser_id, 'name' => ucfirst($wishcatname), 'whocansee' => $whocansee));
				$res ['wlist'] = '<li><label><span class="checkboxStyle"><label><input type="checkbox" class="messageCheckbox hideTemp" checked="checked" value="' . $data . '" name="wishlist_cat[]" id="wish_' . $data . '" /> <i class="fa fa-check"></i> </span>' . $wishcatname . '</label><label></li>';
			}
		}
		echo json_encode($res);
	}

	/*Saving wishlist to my account*/
	public function AddToWishList()
	{
		$Rental_id = $this->input->post('rental_id');
		$notes = $this->input->post('add-notes');
		$user_id = $this->data ['loginCheck'];
		$note_id = $this->input->post('nid');
		$wishlist_cat = $this->input->post('wishlist_cat');
		if ($Rental_id != '') {
			$this->product_model->update_wishlist($Rental_id, $wishlist_cat);
			if ($note_id != '') {
				$this->product_model->update_notes(array('notes' => $notes), array('id' => $note_id));
			} else {
				$this->product_model->update_notes(array('product_id' => $Rental_id, 'user_id' => $user_id, 'notes' => $notes));
			}
			if ($this->lang->line('Wish list added successfully.') != '') {
				$message = stripslashes($this->lang->line('Wish list added successfully.'));
			} else {
				$message = "Wish list added successfully.";
			}
			$this->setErrorMessage('success', $message);
		}
		echo '<script>window.history.go(-1);</script>';
	}

	/*Showing wishlist form*/
	public function AddWishListForm()
	{
		$Rental_id = $this->uri->segment(4, 0);
		$this->data ['productList'] = $this->product_model->get_product_details_wishlist($Rental_id);
		$this->data ['WishListCat'] = $this->product_model->get_list_details_wishlist($this->session->userdata('fc_session_user_id'));
		$this->data ['notesAdded'] = $this->product_model->get_notes_added($Rental_id, $this->session->userdata('fc_session_user_id'));
		$this->load->view('site/includes/wishlist', $this->data);
	}

	/*Booking the rental property*/
	public function rental_guest_booking()
	{
		$this->data['heading'] = "Confirm your Booking";
		$Rental_id = $this->uri->segment(2, 0);
		$this->data ['Rental_id'] = $Rental_id;
		$this->data ['productList'] = $this->product_model->view_product_details_booking(' where p.id="' . $Rental_id . '" and rq.id="' . $this->session->userdata('EnquiryId') . '" group by p.id order by p.created desc limit 0,1');
		$Price = $this->data ['productList']->row()->price;
		$begin = new DateTime($this->data ['productList']->row()->checkin);
		$end = new DateTime($this->data ['productList']->row()->checkout);
		$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
		foreach ($daterange as $date) {
			$result[] = $date->format("Y-m-d");
		}
		$hideCancelDay = $this->config->item('cancel_hide_days_property');
        $totlessDays = $hideCancelDay + 1;
        $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($this->data ['productList']->row()->checkin));
        $this->data['cancelBeforeDay'] = date('d M Y', $minus_checkin);
		$DateCalCul = 0;
		$this->data['ScheduleDatePrice'] = $this->product_model->get_all_details(SCHEDULE, array('id' => $Rental_id));
		if ($this->data['ScheduleDatePrice']->row()->data != '') {
			
			$dateArr = json_decode($this->data['ScheduleDatePrice']->row()->data);
			$finaldateArr = (array)$dateArr;
			foreach ($result as $Rows) {
				if (array_key_exists($Rows, $finaldateArr)) {
					
					$this->data ['productPrice'] = $DateCalCul = $DateCalCul + $finaldateArr[$Rows]->price;

				} else {

					$this->data ['productPrice'] = $DateCalCul = $DateCalCul + $Price;
					
				}
			}
		} else {
			
			$this->data ['productPrice'] = $DateCalCul = (count($result) * $Price);
		}
		
		$this->data ['countryList'] = $this->product_model->get_country_list();
		$this->data ['BookingUserDetails'] = $this->product_model->view_user_details_booking(' where p.id="' . $Rental_id . '" and rq.id="' . $this->session->userdata('EnquiryId') . '" group by p.id order by p.created desc limit 0,1');
		$service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE commission_type="Guest Booking" AND status="Active"';
		$this->data['service_tax'] = $this->product_model->ExecuteQuery($service_tax_query);
		if ($this->data ['productList']->row()->meta_title != '') {
			$this->data ['meta_title'] = $this->data ['productList']->row()->meta_title;
		}
		if ($this->data ['productList']->row()->meta_keyword != '') {
			$this->data ['meta_keyword'] = $this->data ['productList']->row()->meta_keyword;
		}
		if ($this->data ['productList']->row()->meta_description != '') {
			$this->data ['meta_description'] = $this->data ['productList']->row()->meta_description;
		}
		$tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE id=4';
		$this->data['securityDeposite'] = $this->data ['productList']->row()->secDeposit;
		$this->data ['tax'] = $this->product_model->ExecuteQuery($tax_query);
		$this->load->view('site/rentals/booking_confirm', $this->data);
	}

	/*Map search function */
	public function mapview()
	{
		/* Start- Variable declaration checkin*/
		$Start = 0;
		$this->data['searchPerPage'] = $searchPerPage = $this->config->item('site_pagination_per_page');
		$room_type_query = "";
		$property_query = "";
		$find_in_set_categories = "";
		$category_query = "";
		$restrict_product_id_query = "";
		$pay_option_query = "";
		$price_array = array();
		$session_currency = $this->session->userdata('currency_type');
		$google_map_api = $this->config->item('google_developer_key');
		$bing_map_api = $this->config->item('bing_developer_key');
		$getted_city = $this->input->get('city');
		$prop_type_is = $this->product_model->get_all_details(LISTSPACE, array('id' => '9'));
		$this->data['prop_type_is'] = $prop_type_is->row();
		$room_type_is = $this->product_model->get_all_details(LISTSPACE, array('id' => '10'));
		$this->data['room_type_is'] = $room_type_is->row();
		//echo $getted_city;exit;
		if($this->input->post('checkin') == '' || $this->input->post('checkout') == '')
		{
			$datefrom = $this->input->get('checkin');
			$dateto = $this->input->get('checkout');
		}
		else
		{
			$datefrom = $this->input->post('checkin');
			$dateto = $this->input->post('checkout');
			$datefrom = date("m/d/Y", strtotime($datefrom));
			$dateto = date("m/d/Y", strtotime($dateto));
		}
		$page = $this->input->post('page_number');
		if (!$page) {
			$page = 0;
		}
		$guests = $this->input->post('guests');
		$pay_option = $this->input->post('instant_pay');
		if($pay_option == 'Yes'){
			$instant_pay_val = 'Yes';
			$pay_option_query = ' and p.instant_pay ="' . $instant_pay_val.'"';
		}else{
			$pay_option_query = "";
		}
	//	echo $pay_option_query;exit;;
		$room_type = $this->input->post('room_type');
		$property_type = $this->input->post('property_type');
		$min_max_amount = explode('-', $this->input->post('min_max_amount'));
		$pricemin = $min_max_amount[0];
		if($min_max_amount[1] != ''){
				$pricemax = ceil($min_max_amount[1]);}
				else{
					$pricemax = $min_max_amount[1];
				}
		$listvalue = $this->input->post('listvalue');
		$minLat = $this->input->post('minLat');
		$minLong = $this->input->post('minLong');
		$maxLat = $this->input->post('maxLat');
		$maxLong = $this->input->post('maxLong');
		//echo $minLat.' '.$minLong.' '.$maxLat.' '.$maxLong;exit();
		$lat = $this->input->post('lat');
		$long = $this->input->post('long');
		/* Close- Variable declaration*/
		if ($this->input->post('request_type') != "ajax_call") {
			/* Start- Getting address data*/
			// 	$ip = $_SERVER['REMOTE_ADDR'];
		// 	$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
		// 	$names = json_decode(file_get_contents("http://country.io/names.json"), true);
		// 	$countryis = $names[$details->country];
		// // $_SERVER['REMOTE_ADDR'];
		// 	$address = str_replace(' ', '+',$details->city.', '.$details->region.', '.$countryis);
			$address = str_replace(' ', '+', $getted_city);
			$address_details = $this->get_address_bound($address, $google_map_api, $bing_map_api);
			//print_r($address_details);die;
			$this->data ['minLat'] = $minLat = ($address_details['minLat']!="")?$address_details['minLat']:"0.00000";
			$this->data ['lat'] = $lat = ($address_details['lat']!="")?$address_details['lat']:"0.00000";
			$this->data ['long'] = $long = ($address_details['long']!="")?$address_details['long']:"0.00000";
			$this->data ['minLong'] = $minLong = ($address_details['minLong']!="")?$address_details['minLong']:"0.00000";
			$this->data ['maxLat'] = $maxLat = ($address_details['maxLat']!="")?$address_details['maxLat']:"0.00000";
			$this->data ['maxLong'] = $maxLong = ($address_details['maxLong']!="")?$address_details['maxLong']:"0.00000";
		}
		/* close- Getting address data*/
		/*Loading wish-list*/
		//echo LISTS_DETAILS; exit;fc_lists
		$wishlists = $this->product_model->get_all_details(LISTS_DETAILS, array('user_id' => $this->checkLogin('U')));
		$wish_list_array = array();
		foreach ($wishlists->result() as $wish) {
			$wish_list_array = array_merge($wish_list_array, explode(',', $wish->product_id));
		}
		/*Close loading wish-list*/
		if ($this->input->post('zoom') == "") {
			$this->data ['zoom'] = $this->input->post('zoom');
		} else {
			$this->data ['zoom'] = 13;
		}
		$this->data ['cLat'] = $this->input->post('cLat');
		$this->data ['cLong'] = $this->input->post('cLong');
		$whereLat = 'AND (pa.lat BETWEEN "' . $minLat . '" AND "' . $maxLat . '" ) AND (pa.lang BETWEEN "' . $minLong . '" AND "' . $maxLong . '" )';
		if ($datefrom != '' && $dateto != '') {
			$DateStart = date("Y-m-d", strtotime($datefrom));
			$DateEnd = date("Y-m-d", strtotime($dateto));
			//new_query
			$restrict_dates=$this->product_model->booked_listings($DateStart,$DateEnd);
					
			if(!empty($restrict_dates))
			{
				$restrict_product_id = implode(',', $restrict_dates);
				$restrict_product_id_query = " and p.id NOT IN(" . $restrict_product_id . ")";
			}
			else
			{
				$restrict_product_id_query = "";
			}

		}
		//echo $guests;exit;
		if ($guests != '') {
			
				$guest_query = " and p.accommodates >=" . $guests;
			
		} else {
			$guest_query = " and p.accommodates >= 1";
		}
		
		if ($pricemax != '' && $pricemin != '') {
			$this->data ['pricemin'] = $pricemin;
			$this->data ['pricemax'] = $pricemax + 5;
		} else {
			$this->data ['pricemin'] = 0;
			$this->data ['pricemax'] = 50000000;
		}
		if (count($room_type) != 0) {
			$room_values_count = 0;
			$room_checked_id = "";
			foreach ($room_type as $room_checked_values) {
				if ($room_checked_values != '') {
					$room_values_count = 1;
					$room_checked_id .= "'" . trim($room_checked_values) . "',";
				}
			}
			$room_checked_id .= "}";
			$room_check_id = str_replace(",}", "", $room_checked_id);
			if ($room_values_count == 1) $room_type_query = " and p.room_type IN (" . $room_check_id . ")";
		}
		if (count($property_type) != 0) {
			$propertyCount = 0;
			$property_checked_id = "";
			foreach ($property_type as $property_checked_values) {
				if ($property_checked_values != '') {
					$propertyCount = 1;
					$property_checked_id .= "'" . trim($property_checked_values) . "',";
				}
			}
			$property_checked_id .= "}";
			$property_check_id = str_replace(",}", "", $property_checked_id);
			if ($propertyCount == 1) $property_query = " and p.home_type IN (" . $property_check_id . ")";
		}
		if (count($listvalue) != 0) {
			$find_in_set_categories .= '(';
			foreach ($listvalue as $list) {
				if ($list != '') $find_in_set_categories .= ' FIND_IN_SET("' . $list . '", p.list_name) OR';
			}
		}
		if ($find_in_set_categories != '') {
			$find_in_set_categories = substr($find_in_set_categories, 0, -2);
			$category_query = ' ' . $find_in_set_categories . ') and';
		}
		$search = '(1=1 ' . $whereLat . $guest_query . $room_type_query . $pay_option_query . $property_query . $restrict_product_id_query . ') and ' . $category_query;
		$total_pages = $this->product_model->get_total_pages_for_search($search);
		$pages = $this->generate_page_numbers($page, $total_pages, $searchPerPage);
		if ($this->input->post('request_type') == "ajax_call") {
			$page--;
			$Start = ceil($page * $searchPerPage);
			$productList = $this->product_model->view_product_details_sitemapview($search, $Start, $searchPerPage);
			$res_data = array();
			$result = array();
			if ($productList->num_rows() > 0) {
				$currency_result = $this->session->userdata('currency_result');
				$i = 0;
				foreach ($productList->result() as $rentals) {
					$prdId = $rentals->id;
					$prodcutImages = $this->db->select('product_image')->where('product_id', $prdId)->get(PRODUCT_PHOTOS);
					if ($rentals->currency != $session_currency) {
						$list_currency = $rentals->currency;
						if ($currency_result->$list_currency) {
							//$price = $rentals->price / $currency_result->$list_currency;
							$price = currency_conversion($rentals->currency, $this->session->currency_type, $rentals->price);
						} else {
							$price = currency_conversion($rentals->currency, $this->session->currency_type, $rentals->price);
						}
					} else {
						$price = $rentals->price;
					}
					$price = $this->number_format($price, 2);
					if ($pricemin != "" && $pricemax != "") {
						if ($price >= $pricemin && $price <= $pricemax) {
							array_push($price_array, $price);
							$rent_image = 'dummyProductImage.jpg';
							$images = array();
							if ($prodcutImages->num_rows() > 0) {
								foreach ($prodcutImages->result() as $rental_images) {
									if (file_exists('./images/rental/' . $rental_images->product_image)) {
										array_push($images, $rental_images->product_image);
									}
								}
								if (!empty($images)) {
									$rent_image = @implode(',', $images);
								}
							}
							$res_data[$i][0] = ucfirst($rentals->product_title);
							$res_data[$i][1] = $rentals->latitude;
							$res_data[$i][2] = $rentals->longitude;
							$res_data[$i][3] = $i;
							$res_data[$i][4] = $rentals->city_name;
							$res_data[$i][5] = $rentals->num_reviewers . ' Reviews';
							$res_data[$i][6] = $rentals->avg_val * 20;
							$res_data[$i][7] = number_format($price, 2);
							$res_data[$i][8] = $rent_image;
							$res_data[$i][9] = $rentals->seourl;
							if ($this->session->fc_session_user_id) {
								if (!in_array($rentals->id, $wish_list_array)) {
									$res_data[$i][10] = 'onclick="loadWishlistPopup(' . $rentals->id . ');"';
								} else {
									$res_data[$i][10] = '';
								}
							} else {
								$res_data[$i][10] = 'data-toggle="modal" data-target="#signIn" style="display: inline;"';
							}
							
							if ($rentals->list_value!=''){
								$res_data[$i][11] = $rentals->list_value . " . ";
							}else{
								$res_data[$i][11] = 'dnn';
							}
							
							
							$i++;
						}
					} else {
						array_push($price_array, $price);
						$rent_image = 'dummyProductImage.jpg';
						$images = array();
						if ($prodcutImages->num_rows() > 0) {
							foreach ($prodcutImages->result() as $rental_images) {
								if (file_exists('./images/rental/' . $rental_images->product_image)) {
									array_push($images, $rental_images->product_image);
								}
							}
							if (!empty($images)) {
								$rent_image = @implode(',', $images);
							}
						}
						$res_data[$i][0] = ucfirst($rentals->product_title);
						$res_data[$i][1] = $rentals->latitude;
						$res_data[$i][2] = $rentals->longitude;
						$res_data[$i][3] = $i;
						$res_data[$i][4] = $rentals->city_name;
						$res_data[$i][5] = $rentals->num_reviewers . ' Reviews';
						$res_data[$i][6] = $rentals->avg_val * 20;
						$res_data[$i][7] = number_format($price, 2);
						$res_data[$i][8] = $rent_image;
						$res_data[$i][9] = $rentals->seourl;
						if ($this->session->fc_session_user_id) {
							if (!in_array($rentals->id, $wish_list_array)) {
								$res_data[$i][10] = "onclick='loadWishlistPopup(" . $rentals->id . ");'";
							} else {
								$res_data[$i][10] = '';
							}
						} else {
							$res_data[$i][10] =  "data-toggle='modal' data-target='#signIn' style='display: inline;'";
						}
							if ($rentals->list_value!=''){
								$res_data[$i][11] = $rentals->list_value . " . ";
							}else{
								$res_data[$i][11] = 'dnn';
							}
						$res_data[$i][12] = $rentals->instant_pay;
						$i++;
					}
				}
			}
			$result['property'] = $res_data;
			$result['lat'] = $lat;
			$result['lang'] = $long;
			$result['minLat'] = $minLat;
			$result['minLong'] = $minLong;
			$result['maxLat'] = $maxLat;
			$result['maxLong'] = $maxLong;
			$result['pages'] = $pages;
			$result['total_pages'] = $total_pages;
			$TotalResultsFrom = $Start + 1;
			$result['Start'] = '' . ($TotalResultsFrom) . ' - ' . ($Start + count($res_data));
			$result['searchPerPage'] = $total_pages;
			$result['minimum_price'] = min($price_array);
			$result['maximum_price'] = max($price_array);
			echo json_encode($result);
			exit();
		}
		$productList = $this->product_model->view_product_details_sitemapview($search, $Start, $searchPerPage);
		$result = "";
		if ($productList->num_rows() > 0) {
			$currency_result = $this->session->userdata('currency_result');
			$i = 0;
			foreach ($productList->result() as $rentals) {
				$prdId = $rentals->id;
				$prodcutImages = $this->db->select('product_image')->where('product_id', $prdId)->get(PRODUCT_PHOTOS);
				if ($rentals->currency != $session_currency) {
					$list_currency = $rentals->currency;
					if ($currency_result->$list_currency) {
						//$price = $rentals->price / $currency_result->$list_currency;
						$price = currency_conversion($rentals->currency, $session_currency, $rentals->price);
					} else {
						$price = currency_conversion($rentals->currency, $session_currency, $rentals->price);
					}
				} else {
					$price = $rentals->price;
				}
				array_push($price_array, $price);
				$rent_image = 'dummyProductImage.jpg';
				$images = array();
				if ($prodcutImages->num_rows() > 0) {
					foreach ($prodcutImages->result() as $rental_images) {
						if (file_exists('./images/rental/' . $rental_images->product_image)) {
							array_push($images, $rental_images->product_image);
						}
					}
					if (!empty($images)) {
						$rent_image = @implode(',', $images);
					}
				}
				if ($this->session->fc_session_user_id) {
					if (!in_array($rentals->id, $wish_list_array)) {
						$wishlist = "onclick='loadWishlistPopup(" . $rentals->id . ");'";
					} else {
						$wishlist = '';
					}
				} else {
					$wishlist = "data-toggle='modal' data-target='#signIn' style='display: inline;'";
				}
				
				/*Description*/
				$desc_length = strlen($rentals->description);
				if($desc_length > 100){
					$pro_description = character_limiter($rentals->description,100);
				}else{
					$pro_description =  strip_tags($rentals->description);
				}
				
				/*Listing Details*/
				
				$userDetails_r = $this->user_model->get_all_details(USERS, ['id'=>$this->checkLogin('U')]);
				$userDetails_group = $userDetails_r->row()->group;
				
				$location_card = '';	
				$list_type_value = $this->product_model->get_listing_child(); 
				$finalsListing = json_decode($rentals->listings);
				foreach ($finalsListing as $listingResult => $FinalValues) {
					$resultArr[$listingResult] = $FinalValues;		 
				} 
						
				if($list_type_value->num_rows() > 0){
				foreach($list_type_value->result() as $list_val){
					if($resultArr[$list_val->list_id] != ''){ 
					$list_child_value = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $resultArr[$list_val->list_id]));
									
					if($list_val->type == 'option'){ 
						 $location_card .= '<span class='.$list_val->name.'>'.stripslashes(ucfirst($list_child_value->row()->child_name)).'</span>';
					} elseif($list_val->type == 'text') { 
						 $location_card .= '<span class='.$list_val->name.'>'.stripslashes(ucfirst($resultArr[$list_val->list_id])).'</span>';
					} }else{ 
						 $location_card .= '<span class='.$list_val->name.'>0</span>';
					 }
				  }
				}
						
				
				
				
				$result .= '["' . ucfirst($rentals->product_title) . '",' . $rentals->latitude . ',' . $rentals->longitude . ',' . $i . ',"' . $rentals->city_name . '","' . $rentals->num_reviewers . ' Reviews","' . $rentals->avg_val * 20 . '","' . number_format($price, 2) . '","' . $rent_image . '","' . $rentals->seourl . '","'. $wishlist . '","'. $rentals->list_value . " . " .'","'. $rentals->instant_pay .'","'. $pro_description .'","'. $userDetails_group .'","'. $location_card .'"]';
				if ($i != $productList->num_rows()) {
					$result .= ',';
				};
				$i++;
				//print_r($result);	exit;
			}
		}
		

		
			$listChildValues = $this->product_model->get_guest_capacity();
			$this->data['accommodates']=$listChildValues->row()->child_name;
			
			
		$listRoomSpaceCondition = array('attribute_seourl' => 'roomtype', 'status' => 'Active');
		$roomListSpace = $this->product_model->get_all_details(LISTSPACE, $listRoomSpaceCondition);
		if ($roomListSpace->num_rows() != 0) {
			$roomTypeListSpace = $roomListSpace->row()->id;
			$this->data['roomType'] = $this->product_model->get_all_details(LISTSPACE_VALUES, array('status' => 'Active','listspace_id' => $roomTypeListSpace), array(array('field' => 'other', 'type' => 'asc')));
		}
		$listSpaceCondition = array('attribute_seourl' => 'propertytype', 'status' => 'Active');
		$this->data['carListSpace'] = $carListSpace = $this->product_model->get_all_details(LISTSPACE, $listSpaceCondition);
		if ($carListSpace->num_rows() != 0) {
			$carTypeListSpace = $carListSpace->row()->id;
			$this->data['propertyTypes'] = $this->product_model->get_all_details(LISTSPACE_VALUES, array('listspace_id' => $carTypeListSpace,'other'=>'Yes'), array(array('field' => 'other', 'type' => 'asc')));
		}
		$cat_subcat = $this->product_model->get_cat_subcat();
		$this->data['main_cat'] = $cat_subcat ['main_cat'];
		$this->data['sec_category'] = $cat_subcat ['sec_category'];
		$this->data['heading'] = 'Properties in ' . $getted_city;
		$this->data['minimum_price'] = min($price_array);
		$this->data['maximum_price'] = max($price_array);
		
		if(count($price_array) != 0){
				$this->data['average'] = array_sum($price_array) / count($price_array);}
				else{
					$this->data['average'] = '0.00';
				}
				
		$this->data['productList'] = $result;
		$this->data['pages'] = $pages;
		$this->data['total_pages'] = $total_pages;
		$this->data['totalShowed'] = $productList->num_rows();
		$this->data['Start'] = $Start;
		$this->load->view('site/rentals/rental_list', $this->data);
	}

	public function generate_page_numbers($page, $total_pages, $limit)
	{
		$stages = 3;
		if ($page == 0) {
			$page = 1;
		}
		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($total_pages / $limit);
		$LastPagem1 = $lastpage - 1;
		$paginate = '';
		if ($lastpage > 1) {
			if ($page > 1) {
				$paginate .= '<a onclick="create_page(' . $prev . ');" href="#" class="prev"> < </a>';
			}
			if ($lastpage < 7 + ($stages * 2)) {
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if ($counter == $page) {
						$paginate .= '<a onclick="javascript:void(0);" href="#" class="active">' . $counter . '</a>';
					} else {
						$paginate .= '<a onclick="create_page(' . $counter . ');" href="#" class="pages">' . $counter . '</a>';
					}
				}
			} elseif ($lastpage > 5 + ($stages * 2)) {
				if ($page < 1 + ($stages * 2)) {
					for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
						if ($counter == $page) {
							$paginate .= '<a onclick="javascript:void(0);" href="#" class="active">' . $counter . '</a>';
						} else {
							$paginate .= '<a onclick="create_page(' . $counter . ');" href="#" class="pages">' . $counter . '</a>';
						}
					}
					$paginate .= "...";
					$paginate .= '<a onclick="create_page(' . $LastPagem1 . ');" href="#" class="pages">' . $LastPagem1 . '</a>';
					$paginate .= '<a onclick="create_page(' . $lastpage . ');" href="#" class="pages">' . $lastpage . '</a>';
				} elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
					$paginate .= '<a onclick="create_page(1);" href="#" class="pages">1</a>';
					$paginate .= '<a onclick="create_page(2);" href="#" class="pages">2</a>';
					$paginate .= "...";
					for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
						if ($counter == $page) {
							$paginate .= '<a onclick="javascript:void(0);" href="#" class="active">' . $counter . '</a>';
						} else {
							$paginate .= '<a onclick="create_page(' . $counter . ');" href="#" class="pages">' . $counter . '</a>';
						}
					}
					$paginate .= "...";
					$paginate .= '<a onclick="create_page(' . $LastPagem1 . ');" href="#" class="pages">' . $LastPagem1 . '</a>';
					$paginate .= '<a onclick="create_page(' . $lastpage . ');" href="#" class="pages">' . $lastpage . '</a>';
				} else {
					$paginate .= '<a onclick="create_page(1);" href="#" class="pages">1</a>';
					$paginate .= '<a onclick="create_page(2);" href="#" class="pages">2</a>';
					$paginate .= "...";
					for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
						if ($counter == $page) {
							$paginate .= '<a onclick="javascript:void(0);" href="#" class="active">' . $counter . '</a>';
						} else {
							$paginate .= '<a onclick="create_page(' . $counter . ');" href="#" class="pages">' . $counter . '</a>';
						}
					}
				}
			}
			if ($page < $counter - 1) {
				$paginate .= '<a onclick="create_page(' . $next . ');" href="#" class="next"> > </a>';
			}
		}
		return $paginate;
	}

	/*Show popular lists*/
	public function popular_list()
	{
		$perPage = $this->config->item('popular_pagination_per_page');
		$start = 0;
		$count = $this->product_model->get_total_popular_list();				
		$wishlists = $this->product_model->get_all_details(LISTS_DETAILS, array('user_id' => $this->checkLogin('U')));
		$newArr = array();
		foreach ($wishlists->result() as $wish) {
			$newArr = array_merge($newArr, explode(',', $wish->product_id));
		}
		$page = $this->input->get("page");
		$this->data ['newArr'] = $newArr;		
		if (!empty($page)) {
			$start = ceil($this->input->get("page") * $perPage);			
			$this->data ['product'] = $this->product_model->get_review_rating(" WHERE p.status = " . "'Publish'" . " AND p.featured =" . "'Featured'" . " GROUP BY p.id ORDER BY rate desc limit" . " " . $start . ',' . $perPage);
			$this->load->view('site/rentals/AjaxPopularList', $this->data);
		} else {
			$pages = ceil($count / $perPage);
			$this->data ['total_pages'] = $pages;
			$this->data ['product'] = $this->product_model->get_review_rating(" WHERE p.status = " . "'Publish'" . " AND p.featured =" . "'Featured'" . " GROUP BY p.id ORDER BY rate desc limit" . " " . $start . ',' . $perPage);
			$this->load->view('site/rentals/popular_list', $this->data);
		}
	}

	/*Edit wishlist notes*/
	public function edit_notes()
	{
		$id = $this->input->post('nid');
		$notes = $this->input->post('notes');
		$this->product_model->update_details(NOTES, array(
			'notes' => $notes
		), array('id' => $id));
		$res ['result'] = '1';
		echo json_encode($res);
	}
}
