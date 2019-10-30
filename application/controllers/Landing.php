<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * URI:        http://www.homestaydnn.com/plugins/easy-facebook-likebox
 * Description:       Easy Facebook like box WordPress plugin allows you to easly display facebook like box fan page on your website using either widget or shortcode to increase facbook fan page likes. You can use the shortcode generated after saving the facebook like box widget. Its completely customizable with lots of optional settings. Its also responsive facebook like box at the same time.
 * Version:           4.2
 * Author:            Sajid Javed
 * Author URI:        http://jwebsol.com
 * Text Domain:       easy-facebook-likebox
 * Domain Path:       /languages
 **/
class Landing extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form', 'email', 'text'));
		$this->load->library(array('form_validation'));
		$this->load->library('jquery_stars');
		$this->load->model(array('product_model', 'city_model', 'admin_model', 'cms_model', 'landing_model', 'slider_model', 'user_model'));
		if ($_SESSION['sMainCategories'] == '') {
			$sortArr1 = array('field' => 'cat_position', 'type' => 'asc');
			$sortArr = array($sortArr1);
			$_SESSION['sMainCategories'] = $this->product_model->get_all_details(CATEGORY, array('rootID' => '0', 'status' => 'Active'), $sortArr);
		}
		$this->data['mainCategories'] = $_SESSION['sMainCategories'];
		$this->data['mainColorLists'] = $_SESSION['sColorLists'];
		$this->data['loginCheck'] = $this->checkLogin('U');
		$this->data['likedProducts'] = array();
		if ($this->data['loginCheck'] != '') {
			$this->data['likedProducts'] = $this->product_model->get_all_details(PRODUCT_LIKES, array('user_id' => $this->checkLogin('U')));
		}
	}

	/* Default Homepage */
	public function index()
	{
		$this->data['heading'] = 'Welcome';
		$this->data['totalProducts'] = $this->product_model->get_total_records(PRODUCT);
		$this->data['CityDetails'] = $this->city_model->Featured_city();
		$this->data['controller'] = $this;
		foreach ($this->data['CityDetails']->result() as $r) {
			$city_name = $r->name;
			$country = $r->country;
			$state_name = $r->state_name;
			$addressLatLong = array('minLat' => $r->minLat, 'maxLat' => $r->maxLat, 'minLong' => $r->minLong, 'maxLong' => $r->maxLong);
			$this->data['CityName'][$city_name] = $this->city_model->cityall($city_name, $country, $state_name, $addressLatLong)->result();
		}
		$this->data['CityCountDetails'] = $this->city_model->CityCountDisplay('neighborhoods,count(neighborhoods) as CityCountVal', 'neighborhoods', NEIGHBORHOOD);
		$this->data['SliderList'] = $this->slider_model->get_slider_details('WHERE status="Active"');
		$listValues = $this->product_model->get_all_details(LISTINGS, array('id' => 1));
		foreach ($listValues->result() as $result) {
			$values = $result->listing_values;
		}
		$roombedVal = json_decode($values);
		foreach ($roombedVal as $key => $values) {
			$listing_values[$key] = $values;
		}
		$listChildValues = $this->product_model->get_all_details(LISTING_CHILD, array('parent_id' => 31));
		if ($listChildValues->num_rows() > 0) {
			foreach ($listChildValues->result() as $accom) {
				$accommodates[] = $accom->child_name;
			}
		} else {
			$accommodates = '';
		}
		$this->data['accommodates'] = $accommodates;
		$condition = array('id' => '1');
		$enableRslt = $this->slider_model->get_all_details(ADMIN_SETTINGS, $condition);
		$this->data['featuredLists'] = $this->landing_model->get_featured_lists();
		$this->data['adminList'] = $enableRslt->row();
		$this->data['posts'] = $this->user_model->get_user_type();
		if ($this->data['experienceExistCount'] > 0) {
			$this->data ['featuredExperiences'] = $product = $this->landing_model->get_exprience_view_details_withFilter('  where ' . $search . '  d.from_date > "' . date('Y-m-d') . '"' . " and extyp.status='Active' and p.status='1' and p.featured='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id) group by p.experience_id order by p.added_date desc ");
		}
		$this->data['prefooter_result'] = $this->landing_model->get_prefooter();
		$this->data['adv_result'] = $this->landing_model->adv_result_result();
		$this->load->view('site/landing/landing', $this->data);
	}

	/*Displaying property details for booking that includes hist details booking option and ratings and reviews*/
	public function display_product_detail($seourl)
	{
		if (!is_numeric($seourl)) {
			$seourl = $this->product_model->get_product_id($seourl);
		}
		$where1 = array('p.status' => 'Publish', 'p.id' => $seourl);
		$where_or = array('p.status' => 'Publish');
		$where2 = array('p.status' => 'Publish', 'p.id' => $seourl);
		$this->load->model('admin_model');
		$this->data['admin_settings'] = $result = $this->admin_model->getAdminSettings();
		$this->data['productDetails'] = $this->product_model->view_product_details_site_one($where1, $where_or, $where2);
		if ($this->data['productDetails']->row()->id == '') {
			if ($this->lang->line('List details not available') != '') {
				$message = stripslashes($this->lang->line('List details not available'));
			} else {
				$message = "List details not available";
			}
			$this->setErrorMessage('error', $message);
			redirect(base_url());
		}
		$this->data['productImages'] = $this->product_model->get_images($this->data['productDetails']->row()->id);
		$this->data['reviewData'] = $this->product_model->get_review($this->data['productDetails']->row()->id);
		if ($this->checkLogin('U') != '') {
			$this->data['user_reviewData'] = $this->product_model->get_review($this->data['productDetails']->row()->id, $this->checkLogin('U'));
			$this->data['reviewData'] = $this->product_model->get_review_other($this->data['productDetails']->row()->id, $this->checkLogin('U'));
		}
		$this->data['reviewTotal'] = $this->product_model->get_review_tot($this->data['productDetails']->row()->id);
		//blocked dates
		$BookedArr = array();
		$booked_Dates = $this->db->select('checkin,checkout')->where(array('prd_id' => $seourl, 'booking_status' => 'Booked','cancelled' => 'No'))->get(RENTALENQUIRY);
		if ($booked_Dates->num_rows() > 0) {
			foreach ($booked_Dates->result() as $Dates) {
				$current = strtotime($Dates->checkin);
				$last = strtotime($Dates->checkout);
				while ($current <= $last) {
					$BookedArr[] = "'" . date('m/d/Y', $current) . "'";
					$current = strtotime('+1 day', $current);
				}
			}
		}
		$schedule_Dates1 = $this->db->select('data')->where(array('id' => $this->data['productDetails']->row()->id))->get(SCHEDULE);
		$schedules = $schedule_Dates1->row()->data;
		$parse_schedule = json_decode($schedules,true);
		foreach($parse_schedule as $key=>$val)
		{
			if($val['status']=='booked' || $val['status']=='unavailable')
			{
				$BookedArr[] = "'" . date('m/d/Y', strtotime($key)) . "'";
			}
		}
		
		
		$booked_Dates1 = $this->db->select('the_date')->where(array('PropId' => $seourl))->get(CALENDARBOOKING);
		if ($booked_Dates1->num_rows() > 0) {
			foreach ($booked_Dates1->result() as $Dates1) {
				$BookedArr[] = "'" . date('m/d/Y', strtotime($Dates1->the_date)) . "'";
			}
		}
		$this->data['booked_Dates'] = @implode(',', $BookedArr);
		$product_id = $this->data['productDetails']->row()->id;
		$this->data['product_details'] = $this->product_model->view_product1($product_id);
		$this->data['RatePackage'] = '';
		$this->data['google_map_api_key'] = $this->config->item('google_map_api_key');
		$this->data['heading'] = ($this->data['productDetails']->row()->meta_title != "") ? $this->data['productDetails']->row()->meta_title : $this->data['productDetails']->row()->product_title;
		$this->data['getlistImage'] = $this->product_model->get_all_details(LISTSPACE_VALUES, array('id' => $this->data['productDetails']->row()->home_type));
		$this->data['room_type'] = $this->product_model->get_all_details(LISTSPACE_VALUES, array('id' => $this->data['productDetails']->row()->room_type));
		$this->data['listingChild'] = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $this->data['productDetails']->row()->accommodates));
		if ($this->data['productDetails']->row()->meta_title != '') {
			$this->data['meta_title'] = $this->data['productDetails']->row()->meta_title;
		}
		if ($this->data['productDetails']->row()->meta_keyword != '') {
			$this->data['meta_keyword'] = $this->data['productDetails']->row()->meta_keyword;
		}
		if ($this->data['productDetails']->row()->meta_description != '') {
			$this->data['meta_description'] = $this->data['productDetails']->row()->meta_description;
		}
		$listings_hometype = $this->product_model->get_all_details(LISTSPACE_VALUES, array('id' => $this->data['product_details']->row()->home_type));
		if (!empty($listings_hometype)) {
			$listings_hometype = $listings_hometype->row()->list_value;
		} else {
			$listings_hometype = '';
		}
		$this->data['listings_hometype'] = $listings_hometype;
		$this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, array('status' => 'Active'));
		$this->data['host_review_rental'] = $this->product_model->get_host_review_rentals($this->data['productDetails']->row()->user_id);
		$this->data['host_review_exprience'] = $this->product_model->get_host_review_exprience($this->data['productDetails']->row()->user_id);
		$this->data['known_langs'] = $this->product_model->get_known_langs($this->data['productDetails']->row()->languages_known);
		$this->data['pay_option'] = $this->product_model->get_all_details(PRODUCT, array('id' => $seourl));
		$this->data['instant_pay'] = $this->product_model->get_all_details(MODULES_MASTER, array('module_name' => 'payment_option'));
		$this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
		$this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES, array('status' => 'Active'));
		$this->data['listItems'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
		$wishlists = $this->product_model->get_all_details(LISTS_DETAILS, array('user_id' => $this->checkLogin('U')));
		$newArr = array();
//            echo '<pre>';print_r($wishlists);
		foreach ($wishlists->result() as $wish) {
			$newArr = array_merge($newArr, explode(',', $wish->product_id));
		}
//            print_r($newArr);die;
		$this->data ['newArr'] = array_filter($newArr);
		$this->data['SublistDetail'] = $this->product_model->get_all_details(LIST_SUB_VALUES, $contition);
		$rental_category_subcategory = $this->product_model->amenities_main_sub_category($this->data['product_details']->row()->list_name);
		$this->data['subcategory'] = $rental_category_subcategory;
		$listIdArr = array();
		foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
			$listIdArr[] = $listCountryValue['list_id'];
		}
		$this->data['ChkWishlist'] = '0';
		if ($this->checkLogin('U') > 0) {
			$this->data['getWishList'] = $this->product_model->ChkWishlistProduct($this->data['productDetails']->row()->id, $this->checkLogin('U'));
			$this->data['ChkWishlist'] = $this->data['getWishList']->num_rows();
		}
		$this->data['DistanceQryArr'] = $this->product_model->view_product_details_distance_list($this->data['productDetails']->row()->latitude, $this->data['productDetails']->row()->longitude, ' p.id <> ' . $this->data['productDetails']->row()->id . ' and  p.status="Publish" group by p.id order by p.id  DESC');
		$this->data['ConfigBooking'] = $this->product_model->get_all_details(BOOKINGCONFIG, array('cal_url' => base_url()));
		if ($this->data['ConfigBooking']->num_rows() == '') {
			$this->product_model->update_details(BOOKINGCONFIG, array('cal_url' => base_url()), array());
		}
		$this->data['CalendarBooking'] = $this->product_model->get_all_details(CALENDARBOOKING, array('PropId' => $this->data['productDetails']->row()->id));
		if ($this->data['CalendarBooking']->num_rows() > 0) {
			foreach ($this->data['CalendarBooking']->result() as $CRow) {
				$DisableCalDate .= '"' . $CRow->the_date . '",';
			}
			$this->data['forbiddenCheckIn'] = '[' . $DisableCalDate . ']';
		} else {
			$this->data['forbiddenCheckIn'] = '[]';
			$this->data['forbiddenCheckOut'] = '[]';
		}
		$all_dates = array();
		$selected_dates = array();
		foreach ($this->data['CalendarBooking']->result() as $date) {
			$all_dates[] = trim($date->the_date);
			$date1 = new DateTime(trim($date->the_date));
			$date2 = new DateTime($prev);
			$diff = $date2->diff($date1)->format("%a"); //diff in days
			if ($diff == '1') {
				$selected_dates[] = trim($date->the_date);
			}
			$prev = trim($date->the_date);
			$DisableCalDate = '';
			foreach ($all_dates as $CRow) {
				$DisableCalDate .= '"' . $CRow . '",';
			}
			$this->data['forbiddenCheckIn'] = '[' . $DisableCalDate . ']';
			$DisableCalDate = '';
			foreach ($selected_dates as $CRow) {
				$DisableCalDate .= '"' . $CRow . '",';
			}
			$this->data['forbiddenCheckOut'] = '[' . $DisableCalDate . ']';
		}
		$service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="guest-booking" AND status="Active"';
		$this->data['service_tax'] = $this->product_model->ExecuteQuery($service_tax_query);
		if ($this->data['productDetails']->row()->user_id != '') {
			$existCheck = "SELECT * FROM " . ID_PROOF . " WHERE user_id=" . $this->data['productDetails']->row()->user_id;
			$this->data['proof_verify'] = $this->product_model->ExecuteQuery($existCheck);
		}
		$this->data['ProductDealPrice'] = $this->product_model->get_all_details(PRODUCT_DEALPRICE, array('product_id' => $seourl));
		$this->load->view('site/rentals/product_detail', $this->data);
	}
}
/* End of file landing.php */
/* Location: ./application/controllers/site/landing.php */
