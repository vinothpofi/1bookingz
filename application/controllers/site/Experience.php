<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * URI:               http://www.homestaydnn.com/
 * Description:       Experience module(includes Add,Manage experiences).
 * Version:           2.0
 * Author:            Sathyaseelan,Vishnu
 **/
class Experience extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form', 'email'));
        $this->load->library(array('form_validation', 'resizeimage', 'image_lib'));
        $this->load->model(array('experience_model', 'admin_model', 'cms_model', 'slider_model', 'user_model',));
        $this->load->helper("url");
        $this->load->library("pagination");
        $ListingStepsArr = array('manage_experience', 'schedule_experience', 'experience_image', 'experience_details', 'additional_details', 'location_details', 'group_details', 'guest_requirement', 'experience_cancel_policy');
        $this->data['Steps_count1'] = $this->data['Steps_count2'] = $this->data['Steps_count3'] = $this->data['Steps_count4'] = 0;
        $this->data['Steps_count5'] = $this->data['Steps_count6'] = $this->data['Steps_count7'] = $this->data['Steps_count8'] = 0;
        $this->data ['loginCheck'] = $this->checkLogin('U');
        $this->data['exp_page'] = '1';
        if ($this->data ['loginCheck'] != '') {
            if ($this->uri->segment(2, 0) != '') {
                if (in_array($this->uri->segment(1, 0), $ListingStepsArr)) {
                    $id = $this->uri->segment(2, 0);
                    $this->data['Steps_title'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and date_count ="" and experience_title="" and type_id="0" ');
                    $this->data['Steps_price'] = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_DATES, ' where experience_id=' . $id . ' and status ="1"');
                    $this->data['Steps_exp_details'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and (kit_content ="" or experience_description="" or     language_list="" ) ');
                    $this->data['Steps_image'] = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_PHOTOS, ' where product_id=' . $id . ' and product_image !=""');
                    $this->data['Steps_additional'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and (note_to_guest ="" or location_description="") ');
                    $this->data['Steps_location'] = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_ADDR, ' where experience_id=' . $id . ' and (lang ="" or lat="") ');
                    $this->data['Steps_group'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and    group_size ="" ');
                    $this->data['Steps_guest'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and guest_requirement =""  ');
                    $this->data['Steps_cancelPolicy'] = $this->experience_model->get_selected_fields_records('experience_id', EXPERIENCE, ' where experience_id=' . $id . ' and cancel_policy =""  ');
                    if ($this->data['Steps_title']->num_rows() > 0) {
                        $this->data['Steps_count1'] = 1;
                    }
                    if ($this->data['Steps_price']->num_rows() == 0) {
                        $this->data['Steps_count2'] = 1;
                    }
                    if ($this->data['Steps_image']->num_rows() == 0) {
                        $this->data['Steps_count3'] = 1;
                    }
                    if ($this->data['Steps_exp_details']->num_rows() > 0) {
                        $this->data['Steps_count4'] = 1;
                    }
                    if ($this->data['Steps_additional']->num_rows() > 0) {
                        $this->data['Steps_count5'] = 1;
                    }
                    if ($this->data['Steps_location']->num_rows() > 0) {
                        $this->data['Steps_count6'] = 1;
                    }
                    if ($this->data['Steps_group']->num_rows() > 0) {
                        $this->data['Steps_count7'] = 1;
                    }
                    if ($this->data['Steps_guest']->num_rows() > 0) {
                        $this->data['Steps_count8'] = 1;
                    }
                    if ($this->data['Steps_cancelPolicy']->num_rows() > 0) {
                        $this->data['Steps_count9'] = 1;
                    }
                    $this->data['Steps_tot'] = $this->data['Steps_count1'] + $this->data['Steps_count2'] + $this->data['Steps_count3'] + $this->data['Steps_count4'] + $this->data['Steps_count5'] + $this->data['Steps_count6'] + $this->data['Steps_count7'] + $this->data['Steps_count8'] + $this->data['Steps_count9'];
                }
            } else {
                $this->data['Steps_count1'] = 1;
                $this->data['Steps_count2'] = 1;
                $this->data['Steps_count3'] = 1;
                $this->data['Steps_count4'] = 1;
                $this->data['Steps_count5'] = 1;
                $this->data['Steps_count6'] = 1;
                $this->data['Steps_count7'] = 1;
                $this->data['Steps_count8'] = 1;
                $this->data['Steps_count9'] = 1;
                $this->data['steps_disable'] = 1;
            }
            /* newly added  for active */
            $id = $this->uri->segment(2, 0);
            if ($id != '') {
                $completed_arr = array();
                $this->data['basics'] = 0;
                $this->data['language'] = 0;
                $this->data['organization'] = 0;
                $this->data['exp_title'] = 0;
                $this->data['timing'] = 0;
                $this->data['tagline'] = 0;
                $this->data['photos'] = 0;
                $this->data['what_we_do'] = 0;
                $this->data['where_will_be'] = 0;
                $this->data['where_will_meet'] = 0;
                $this->data['what_will_provide'] = 0;
                $this->data['notes'] = 0;
                $this->data['about_you'] = 0;
                $this->data['guest_req'] = 0;
                $this->data['group_size'] = 0;
                $this->data['price'] = 0;
                $this->data['cancel_policy'] = 0;
                $condition = array('experience_id' => $id);
                $all_details = $this->experience_model->get_all_details(EXPERIENCE, $condition);
                $data = $all_details->row();
                if (!empty($data)) {
                    if ($data->exp_type != '' && ($data->total_hours != '' || $data->date_count != '') && $data->type_id != '') {
                        $this->data['basics'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->language_list != '') {
                        $this->data['language'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->organization != '' && $data->organization_des != '') {
                        $this->data['organization'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->experience_title != '') {
                        $this->data['organization'] = 1;
                        $this->data['exp_title'] = 1;
                        $completed_arr[] = 1;
                    }
                    $dat_date = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_DATES, ' where experience_id=' . $id);
                    $shedule_timing = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_TIMING, ' where experience_id=' . $id);
                    if ($dat_date->num_rows() > 0 && $shedule_timing->num_rows() > 0) {
                        $this->data['timing'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->exp_tagline != '') {
                        $this->data['tagline'] = 1;
                        $completed_arr[] = 1;
                    }
                    $dat_img = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_PHOTOS, ' where product_id=' . $id . ' and product_image !=""');
                    if ($dat_img->num_rows() > 0) {
                        $this->data['photos'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->what_we_do != '') {
                        $this->data['photos'] = 1;
                        $this->data['what_we_do'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->location_description != '') {
                        $this->data['where_will_be'] = 1;
                        $completed_arr[] = 1;
                    }
                    $loc_data = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_ADDR, ' where experience_id=' . $id);
                    if ($loc_data->num_rows() > 0) {
                        $this->data['where_will_meet'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->kit_content != '') {
                        $this->data['what_will_provide'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->note_to_guest != '') {
                        $this->data['notes'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->about_host != '') {
                        $this->data['about_you'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->guest_requirement != '') {
                        $this->data['guest_req'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->group_size != '') {
                        $this->data['group_size'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->price > 0) {
                        $this->data['price'] = 1;
                        $completed_arr[] = 1;
                    }
                    if ($data->cancel_policy != '') {
                        $this->data['cancel_policy'] = 1;
                        $completed_arr[] = 1;
                    }
                    $this->data['completed_steps'] = count($completed_arr);
                    $this->data['remaining'] = (17 - count($completed_arr));
                }
            }
            /* newly added  for active */
            $hosting_commission_status = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_listing" and status = "Active"';
            $this->data ['hosting_commission_status'] = $this->experience_model->ExecuteQuery($hosting_commission_status);
        }
        $this->data['controller'] = $this;
        $this->load->library("pagination");
    }

    /* experience listing for booking -  */
    public function explore_experience( $user_id_is = '')
    {
        /*Variable decleration*/
        
        $perPage = $this->config->item('site_pagination_per_page');
        $start = 0;
        $date_search = '';
        $category_search = '';
        $user_id_query = '';
        $type_search = '';
        $search = '';
        $whereLat = '';
        $address_details = array("minLat" => "", "maxLat" => "", "minLong" => "", "maxLong" => "");
        $category = $this->input->post('category');
        $type_id = $this->input->post('type_id');
        $datefrom = $this->input->get('checkin');
        $dateto = $this->input->get('checkout');
        $minLat = $this->input->post('minLat');
        $maxLat = $this->input->post('maxLat');
        $minLong = $this->input->post('minLong');
        $maxLong = $this->input->post('maxLong');
        $page = $this->input->get('page');
        $this->data ['gogole_address'] = $get_address = $this->input->get('city');
        /*Google and Bing api Key*/
        $google_map_api = $this->config->item('google_developer_key');
        $bing_map_api = $this->config->item('bing_developer_key');
        /*close Google, Bing api key*/
        if ($minLat != "" && $maxLat != "" && $minLong != "" && $maxLong != "") {
            /*Check to reduce the wastage of map api requests*/
            $whereLat = '(expAdd.lat BETWEEN "' . $minLat . '" AND "' . $maxLat . '" ) AND (expAdd.lang BETWEEN "' . $minLong . '" AND "' . $maxLong . '" ) and ';
            $address_details = array("minLat" => $minLat, "maxLat" => $maxLat, "minLong" => $minLong, "maxLong" => $maxLong);
        } else if ($get_address != '') {
            $address = str_replace(" ", "+", $get_address);
            $address_details = $this->get_address_bound($address, $google_map_api, $bing_map_api);
            $whereLat = '(expAdd.lat BETWEEN "' . $address_details["minLat"] . '" AND "' . $address_details["maxLat"] . '" ) AND (expAdd.lang BETWEEN "' . $address_details["minLong"] . '" AND "' . $address_details["maxLong"] . '" ) and ';
        }
        $this->data["minLat"] = $address_details["minLat"];
        $this->data["maxLat"] = $address_details["maxLat"];
        $this->data["minLong"] = $address_details["minLong"];
        $this->data["maxLong"] = $address_details["maxLong"];
        /*Wishlist*/
        $wishlists = $this->experience_model->get_all_details(LISTS_DETAILS, array('user_id' => $this->checkLogin('U')));
        $newArr = array();
        foreach ($wishlists->result() as $wish) {
            $newArr = array_merge($newArr, explode(',', $wish->experience_id));
        }
        $this->data ['newArr'] = $newArr;
        /*Query building start*/
        
      //  echo $datefrom;exit;
        if (($datefrom != '') && ($dateto != '')) {
            $datefrom = date('Y-m-d',strtotime($datefrom));
        $dateto = date('Y-m-d',strtotime($dateto));
            if ($datefrom != '' && $dateto != '') {
                $date_search = ' d.from_date >= "' . $datefrom . '" and d.to_date <= "' . $dateto . '" and ';

               //$date_search = ' (d.from_date BETWEEN "' . $datefrom . '" and "' . $dateto . '") and ';
            } 
        }
        if ($_POST['category'] != '') {
            $single_Day = $multi_day = 0;
            foreach ($category as $cat) {
                if ($cat == '1') {
                    $multi_day = '1';
                } else if ($cat == '2') {
                    $single_Day = '1';
                }
            }
            if (($single_Day == 1 && $multi_day == 1) || ($single_Day == 0 && $multi_day == 0)) {
                $category_search = 'p.date_count>=1 and ';
            } else if (($single_Day == 0 && $multi_day == 1)) {
                $category_search = 'p.date_count>1 and ';
            } else {
                $category_search = 'p.date_count=1 and ';
            }
        }
        if ($_POST['type_id']) {
            $selected_types = implode(',', $type_id);
            if ($search == '') $type_search .= 'p.type_id in (' . $selected_types . ') and '; else
                $type_search .= '  ' . 'p.type_id in (' . $selected_types . ') and';
        }
        if($user_id_is != ''){
             $user_id_query .= 'p.user_id =' . $user_id_is . ' and ';
        }
        $search_query = $whereLat . '' . $date_search . ' ' . $category_search . ' ' . $type_search . ' ' .  $user_id_query;
        /*Query building Close*/
        $this->data['experienceType'] = $this->experience_model->get_all_details(EXPERIENCE_TYPE, array('status' => 'Active'));
        if (!empty($page)) {
            //echo 'here';
            $start = ceil($this->input->get("page") * $perPage);
            $this->data ['product'] = $product = $this->experience_model->get_exprience_view_details_withFilter('  where ' . $search_query . '  d.from_date > "' . date('Y-m-d') . '"' . " and extyp.status='Active' and p.status='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id) group by p.experience_id order by p.added_date desc limit " . $start . ',' . $perPage);
            $this->load->view('site/experience/ajax_explore_experience', $this->data);
            die;
        } else {
            //echo 'there';
            $this->data ['product'] = $product = $this->experience_model->get_exprience_view_details_withFilter('  where ' . $search_query . '  d.from_date > "' . date('Y-m-d') . '"' . " and extyp.status='Active' and p.status='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id) group by p.experience_id order by p.added_date desc limit " . $start . ',' . $perPage);

            //echo $this->data ['product']; exit;
            $count = $product = $this->experience_model->get_exprience_view_details_withFilter('  where ' . $search_query . '  d.from_date > "' . date('Y-m-d') . '"' . " and extyp.status='Active' and p.status='1' AND EXISTS
      ( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
      )  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id) group by p.experience_id order by p.added_date desc ")->num_rows();

        }
      //  echo $this->db->last_query();exit();
        $pages = ceil($count / $perPage);
        $this->data ['total_pages'] = $pages;
        $this->data ['total_listings'] = $count;
        $this->load->view('site/experience/explore_experience', $this->data);
    }

    /* manage Experience */
    public function manage_experience($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            if ($expid != '') {
                $userId = $this->checkLogin('U');
                $this->data['id'] = $expid;
                $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
                $this->data['experienceTypeList'] = $this->experience_model->view_experienceType_details();
                $this->data['currencyDetail'] = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
                $condition = array('experience_id' => $expid);
                $this->data['date_details'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
                $this->data['page_exp'] = 'further';
                if ($this->data['listDetail']->num_rows() > 0) {
                    $this->load->view('site/experience/manage_experience', $this->data);
                } else
                    redirect();
            } else {
                $expid = 0;
                $userId = $this->checkLogin('U');
                $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
                $this->data['id'] = $expid;
                $this->data['experienceTypeList'] = $this->experience_model->view_experienceType_details();
                $this->data['currencyDetail'] = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
                $condition = array('experience_id' => $expid);
                $this->data['date_details'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
                $this->data['page_exp'] = 'initial';
                $this->load->view('site/experience/manage_experience', $this->data);
            }
        } else {
            redirect();
        }
    }

    /*To Update Experience Category*/
    public function UpdateExp_Category()
    {
        $typeId = $this->input->post('category_id');
        $expId = $this->input->post('exp_id');
        $booked = array('booking_status' => 'Booked');
        $data = $this->experience_model->get_booked_exp_details($booked, $expId);
        if ($data->num_rows() == 0) {
            $this->experience_model->update_details(EXPERIENCE, array('type_id' => $typeId), array('experience_id' => $expId));
            echo "success";
        } else {
            echo "fail";
        }
    }

    /*Create new expirience*/
    public function add_experience_new()
    {
        $dat_count = $this->input->post('total_count_date');
        $time_count = $this->input->post('total_count_time');
        $experience_type = $this->input->post('experience_type');
        $currency = $this->session->userdata('currency_type');
        $type_id = $this->input->post('type_id');
        if ($experience_type == '2') {
            $date_count = 1;
            $total_hours = $time_count;
        } else {
            $date_count = $dat_count;
            $total_hours = '';
        }
        $id = $this->checkLogin('U');
        $condition = array('id' => $id, 'status' => 'Active');
        $this->data['checkUser'] = $this->experience_model->get_all_details(USERS, $condition);
        if ($this->data['checkUser']->num_rows() == 1) {
            $data = array('type_id' => $type_id, 'exp_type' => $experience_type, 'date_count' => $date_count, 'total_hours' => $total_hours, 'user_id' => $id, 'currency' => '', 'status' => '0');
            $this->experience_model->simple_insert(EXPERIENCE, $data);
            $getInsertId = $this->experience_model->get_last_insert_id();
            $this->experience_model->update_details(USERS, array('is_experienced' => '1', 'group' => 'Seller'), array('id' => $id));
            redirect('experience_language_details/' . $getInsertId);
        } else {
            redirect(base_url());
        }
    }

    /*Step:2 Language management*/
    public function experience_language_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
            $this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
            $this->data['id'] = $expid;
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/exp_language', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Adding languages*/
    public function update_languages()
    {
        $experience_id = $this->input->post('experience_id');
        $excludeArr = array('languages', 'languages_known');
        $inputArr['language_list'] = implode(',', $this->input->post('languages_known'));
        $condition = array('experience_id' => $experience_id);
        $this->experience_model->update_details(EXPERIENCE, array('language_list' => $inputArr['language_list']), $condition);
        $this->db->select('*');
        $this->db->from(LANGUAGES_KNOWN);
        $this->db->where_in('language_code', $this->input->post('languages_known'));
        $languages = $this->db->get();
        $returnStr = '';
        foreach ($languages->result() as $language) {
            $returnStr .= '<li id="' . $language->language_code . '">' . $language->language_name . '<span onclick="delete_languages(this,' . $language->language_code . ')">X</span></li>';
        }
        echo $returnStr;
    }

    /*Delete languages*/
    public function delete_languages()
    {
        $experience_id = $this->input->post('experience_id');
        $languages_known_query = 'SELECT language_list FROM ' . EXPERIENCE . ' WHERE experience_id=' . $experience_id;
        $languages_known = $this->experience_model->ExecuteQuery($languages_known_query);
        $languages = explode(',', $languages_known->row()->language_list);
        $position = array_search($this->input->post('language_code'), $languages);
        unset($languages[$position]);
        $inputArr['language_list'] = implode(',', $languages);
        $condition = array('experience_id' => $experience_id);
        $this->experience_model->update_details(EXPERIENCE, array('language_list' => $inputArr['language_list']), $condition);
        echo json_encode(array('status_code' => 1));
    }

    /*Organization details load view*/
    public function experience_organization_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/experience_organization_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Add Experience organization detail to DB*/
    public function add_org_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $organization = $this->input->post('organization');
           // $organization_ar = $this->input->post('organization_ar');
            $organization_des = $this->input->post('organization_des');
           // $organization_des_ar = $this->input->post('organization_des_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
           
            $data = array('organization' => $organization, 'organization_des' => $organization_des);
           
            $fieldname = array("organization", "organization_des");
                foreach($fieldname as $fieldnm){
                    foreach (language_dynamic_enable($fieldnm, "") as $dynlang) {
                    $data = array_merge($data, array($dynlang[1] => $this->input->post($dynlang[1])));
                }

            }

            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('experience_details/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Showing Exprience details view*/
    public function experience_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/experience_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Add Experience title*/
    public function add_exp_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $experience_title = $this->input->post('experience_title');
           // $experience_title_ar = $this->input->post('experience_title_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $data = array('experience_title' => $experience_title);
           
            $fieldname = array("experience_title");
                foreach($fieldname as $fieldnm){
                    foreach (language_dynamic_enable($fieldnm, "") as $dynlang) {
                    $data = array_merge($data, array($dynlang[1] => $this->input->post($dynlang[1])));
                }

            }     

            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('schedule_experience/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Show scheduling the Date view*/
    public function schedule_experience($expid = '')
    {
        if ($this->checkLogin('U') != '') 
        {
            $this->data['id'] = $expid;
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $this->data['currencyDetail'] = $this->experience_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
            $date_time_details = $this->experience_model->get_date_time_details($expid);
            
            $this->data['date_details'] = $date_time_details;
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/schedule_experience', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /* to date calculation  */
    public function todateCalculate()
    {
        $from_date = $this->input->post('from_date');
        $date_count = $this->input->post('date_count');
        $date_count1 = $date_count - 1;
        if ($date_count > 1) $to_date = date("Y-m-d", strtotime('+' . $date_count1 . ' days', strtotime($from_date))); else
            $to_date = date("Y-m-d", strtotime($from_date));
        echo $to_date;
    }

    /*Saving the dates of exprience to The database*/
    public function saveDates()
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $experience_id = $this->input->post('experience_id');
        $price = $this->input->post('price');
        $currency = $this->input->post('currency');
        $experience_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $experience_id));
        if ($experience_details->num_rows() > 0) {
            $price = $experience_details->row()->price;
            $currency = $experience_details->row()->currency;
        }
        $checkDatesExist = $this->experience_model->ExecuteQuery("select id from " . EXPERIENCE_DATES . " where  ((from_date BETWEEN '" . $from_date . "' and '" . $to_date . "') or (to_date BETWEEN '" . $from_date . "' and '" . $to_date . "')) and experience_id='" . $experience_id . "'");
        if ($checkDatesExist->num_rows() > 0) {
            $message = array('case' => '3');
        } else {
            $dataArr = array('experience_id' => $experience_id, 'from_date' => $from_date, 'to_date' => $to_date, 'price' => $price, 'currency' => $currency, 'created_at' => date('Y-m-d H:i:s'), 'status' => '0');
            $this->db->insert(EXPERIENCE_DATES, $dataArr);
            $insert_id = $this->db->insert_id();
            $message = array('case' => '1', 'date_id' => $insert_id);
        }
        echo json_encode($message);
    }

    /*Change status of date*/
    public function change_date_status()
    {
        if ($this->checkLogin('U') != '') {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $condition = array('id' => $id);
            $data = array('status' => $status);
            $res = $this->experience_model->update_details(EXPERIENCE_DATES, $data, $condition);
            echo $res;
        } else {
            redirect();
        }
    }

    /*Get time sheet for particular date*/
    public function get_new_timesheet()
    {
        if ($this->checkLogin('U') != '') {
            $exp_dates_id = $this->input->post('date_id');
            $condition = array('id' => $exp_dates_id);
            $res_data = $this->experience_model->get_all_details(EXPERIENCE_DATES, $condition);
            $date = $res_data->row();
            $condition1 = array('exp_dates_id' => $exp_dates_id);
            $res_data1 = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition1);
            $date_time = $res_data1->result();
            $disable_date = array();
            if (!empty($date_time)) {
                foreach ($date_time as $dat_time) {
                    $disable_date []= date('m/d/Y', strtotime($dat_time->schedule_date));
                }
            }
            $str = '<tr id="child_create_' . $exp_dates_id . '" class="child_create_' . $exp_dates_id . '">';
            $str .= '<td colspan="3">';
            $str .= '<form id="new_time_sheet_' . $exp_dates_id . '" name="new_time_sheet_' . $exp_dates_id . '">';
            /*$str .= '<input type="hidden" id="disabled_date_' . $exp_dates_id . '" name="disabled_date_' . $exp_dates_id . '" value="' . $disable_date . '" />';*/
            $str .= "<input type='hidden' id='disabled_date_" . $exp_dates_id . "' name='disabled_date_" . $exp_dates_id . "' value='" . implode(',',$disable_date) . "' />";
            $str .= '<input type="hidden" id="experience_id_' . $exp_dates_id . '" name="experience_id" value="' . $date->experience_id . '">';
            $str .= '<input type="hidden" id="from_date_' . $exp_dates_id . '" name="from_date" value="' . $date->from_date . '">';
            $str .= '<input type="hidden" id="to_date_' . $exp_dates_id . '" name="to_date" value="' . $date->to_date . '">';
            $str .= '<input type="hidden" name="exp_dates_id" value="' . $exp_dates_id . '">';
            $str .= '<div class="square_box " id="new_timesheet_' . $exp_dates_id . '">';
            $str .= '<p class="text-danger" id="new_form_error_msg_' . $exp_dates_id . '"></p>';
            $same_day = '';
            if ($date->from_date == $date->to_date) {
                $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';
                if ($this->lang->line('Date') != '') 
                {
                    $str .= '' . stripslashes($this->lang->line('Date')) .'';
                } 
                else 
                {
                   $str .= 'Date';  
                } 
                $str .= '<span class="impt">*</span></p>  <input type="text" name="schedule_date" id="schedule_date_' . $exp_dates_id . '" class="dev_multi_schedule_date input_class" value="" readonly></div></div>';/*' . $date->to_date . '*/
                $same_day = 1;
            } else {
                $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';
                if ($this->lang->line('Date') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('Date')) .'';
                } 
                else 
                {
                   $str .= 'Date;';  
                } 
                 $str .= '<span class="impt">*</span></p>  <input type="text" name="schedule_date" id="schedule_date_' . $exp_dates_id . '" class="dev_multi_schedule_date input_class" value=""></div></div>';
            }
            /*Start-Time drop down array generation*/
            $timeArr = array();
            $startTime = strtotime("00:00");
            $endTime = strtotime("24:00");
            $returnTimeFormat = 'G:i';
            $current = time();
            $addTime = strtotime('+60 mins', $current);
            $diff = $addTime - $current;
            while ($startTime < $endTime) {
                $timeArr[date($returnTimeFormat, $startTime)] = date($returnTimeFormat, $startTime);
                $startTime += $diff;
            }
            /*Close-Time drop down array generation*/
            $dropDownOption = array("id" => "end_time_" . $exp_dates_id);
            ($same_day == 1) ? $dropDownOption["readOnly"] = "true" : "";
            $str .= '<div class="form-group text-left"><div class="col-md-6"><p>';
            if ($this->lang->line('From_Time') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('From_Time')) .'';
                } 
                else 
                {
                   $str .= 'From Time;';  
                } 
            $str .= '<span class="impt">*</span></p>' . form_dropdown("start_time", $timeArr, "", array("id" => "star_time_" . $exp_dates_id, "onchange" => "assign_to_time_hour($exp_dates_id)")) . ' </div>';
            $str .= '<div class="col-md-6"><p>';
            if ($this->lang->line('To_TimeFor') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('To_TimeFor')) .'';
                } 
                else 
                {
                   $str .= 'To TimeFor;';  
                }
             $str .= '<span class="impt">*</span></p>' . form_dropdown("end_time", $timeArr, "", $dropDownOption) . '</div>';
            $str .= '</div>';
            $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';
            
            
            if ($this->lang->line('Title') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('Title')) .'';
                } 
                else 
                {
                   $str .=  'Title';
                }
            $str .= '<span class="impt">*</span></p> <input name="title" type="text" value=""  id="title_' . $exp_dates_id . '" class="input_class"  onkeydown="word_count(this)"><p><span id="title_' . $exp_dates_id . '_char_count"></span></p></div></div>';
            

         

            $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';
            if ($this->lang->line('list_Description') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('list_Description')) .'';
                } 
                else 
                {
                   $str .= 'Description;';  
                }
            $str .= '<span class="impt">*</span></p><textarea maxlength="150" name="description" id="description_' . $exp_dates_id . '" onkeydown="description_count(this)"></textarea><p><span id="description_' . $exp_dates_id . '_char_count"></span> </p></div></div>';
            
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                     

               $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';
            
         //  foreach(language_dynamic_enable("title","") as $dynlang) {
            
            if ($this->lang->line('Title') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('Title')) .'('.$data->name.')';
                } 
                else 
                {
                   $str .= 'Title'.'('.$data->name.')';
                }
            $str .= '<span class="impt">*</span></p> <input name="title_'.$data->lang_code.'" type="text" value=""  id="title_'.$data->lang_code.'_' . $exp_dates_id . '" class="input_class"  onkeydown="word_count(this)"><p><span id="title_'.$data->lang_code.'_' . $exp_dates_id . '_char_count"></span></p></div></div>';
         //  }
           
            $str .= '<div class="col-md-12"><div class="form-group text-left"><p>';

          //  foreach(language_dynamic_enable("description","") as $dynlang){

            if ($this->lang->line('list_Description') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('list_Description')) .'('.$data->name. ")";
                } 
                else 
                {
                   $str .= 'Description' ."(". $data->name.")";  
                }

            $str .= '<span class="impt">*</span></p><textarea maxlength="150" name="description_'.$data->lang_code.'" id="description_'.$data->lang_code.'_' . $exp_dates_id . '" onkeydown="description_count(this)"></textarea><p><span id="description_'.$data->lang_code.'_' . $exp_dates_id . '_char_count"></span> </p></div></div>';
         //   }


        }}

            $str .= '<div class="clear text-right"><button class="submitBtn1" id="add_time_sheet_' . $exp_dates_id . '" type="button" onclick="add_time_sheet(' . $exp_dates_id . ')">';
            if ($this->lang->line('Submit') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('Submit')) .'';
                } 
                else 
                {
                   $str .= 'Submit;';  
                }
            $str .= '</button>&nbsp;<button class="submitBtn1" id="add_time_sheet_' . $exp_dates_id . '" type="button" onclick="cancel_time_sheet(' . $exp_dates_id . ')">';
            if ($this->lang->line('Cancel') != '') 
                {
                    $str .= ''. stripslashes($this->lang->line('Cancel')) .'';
                } 
                else 
                {
                   $str .= 'Cancel;';  
                }
            $str .= '</button></div>';
            $str .= '</div>';
            $str .= '</form>';
            $str .= '</td>';
            $str .= '</tr>';
            echo $str;
        } else {
            redirect();
        }
    }

    /*Time sheets*/
    public function get_timesheets()
    {
        if ($this->checkLogin('U') != '') {
            $exp_dates_id = $this->input->post('date_id');
            $condition = array('exp_dates_id' => $exp_dates_id);
            $res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
            $data = $res_data->result();
            
                if ($this->lang->line('schedule_date') != '') {
                    $schedule_dt= stripslashes($this->lang->line('schedule_date'));
                } else {
                    $schedule_dt= "Scheduled Date";
                } 
                if ($this->lang->line('time') != '') {
                    $tme= stripslashes($this->lang->line('time'));
                } else {
                    $tme= "Time";
                } 
            
                if ($this->lang->line('no_schedule_found') != '') {
                    $no_schedule= stripslashes($this->lang->line('no_schedule_found'));
                } else {
                    $no_schedule= "No schedule found";
                } 
            
                if ($this->lang->line('exp_Active') != '') {
                    $active= stripslashes($this->lang->line('exp_Active'));
                } else {
                    $active= "Active";
                } 
                if ($this->lang->line('Action') != '') {
                    $action= stripslashes($this->lang->line('Action'));
                } else {
                    $action= "Action";
                }   
                if ($this->lang->line('Title') != '') {
                    $tittle= stripslashes($this->lang->line('Title'));
                } else {
                    $tittle= "Title";
                } 

                if ($this->lang->line('exp_inactive') != '') {
                    $inActive= stripslashes($this->lang->line('exp_inactive'));
                } else {
                    $inActive= "Inactive";
                } 
            
            $str = '<tr id="child_view_' . $exp_dates_id . '" class="child_' . $exp_dates_id . '">';
            if (count($data) > 0) {
                $str .= '<td colspan="3">';
                $str .= '<table class="table table-striped">';
                $str .= '<thead><th> '.$schedule_dt. '</th><th>'.$tme.'</th><th>'.$tittle.'</th><th>'.$action.'</th></thead>';
                foreach ($data as $time) {
                    $str .= '<tr id="first_child_' . $time->id . '"><td><input type="hidden" value="' . $time->schedule_date . '" class="dev_multi_schedule_date_new">' . $time->schedule_date . '</td><td>' . date('h:i A', strtotime($time->start_time)) . '-' . date('h:i A', strtotime($time->end_time)) . '</td><td>' . $time->title . '</td><td class="date_actions"><i class="fa fa-pencil-square-o cursor_pointer" aria-hidden="true" title="edit" onclick="edit_time_sheet(' . $time->id . ',' . $exp_dates_id . ')"></i>&nbsp;<i class="fa fa-times cursor_pointer" aria-hidden="true" onclick="remove_time_sheet(' . $time->id . ')" title="delete time schedule"></i>&nbsp;&nbsp;';
                    
                    if ($time->status == 1) {
                        $active_str = $active;
                    } else {
                        $active_str = $inActive;
                    }
                    $str .= '<span class="" title="change status"><a class="btn-sm status" href="javascript:void(0);" onclick="change_timing_status(' . $time->id . ',this,' . $exp_dates_id . ');">' . $active_str . '</a></span>&nbsp;</td></tr>';
                }
                $str .= '</table>';
                $str .= '</td>';
            } else {
                $str .= '<td colspan="3">';
                $str .= $no_schedule;
                $str .= '</td>';
            }
            $str .= '</tr>';
            echo $str;
        } else {
            redirect();
        }
    }

    /*Adding the time sheet to DB*/
    public function add_timesheet()
    {
        if ($this->checkLogin('U') != '') {
            $start_time = $this->input->post('start_time');
            $schedule_date = $this->input->post('schedule_date');
            $end_time = $this->input->post('end_time');
            $title = $this->input->post('title');
           //  $title_ar = $this->input->post('title_ar');
            $description = $this->input->post('description');
           // $description_ar = $this->input->post('description_ar');
            $experience_id = $this->input->post('experience_id');
            $exp_dates_id = $this->input->post('exp_dates_id');
            $datArr = array('experience_id' => $experience_id, 'start_time' => $start_time, 'end_time' => $end_time, 'schedule_date' => $schedule_date, 'title' => $title, 'description' => $description, 'exp_dates_id' => $exp_dates_id);
            foreach(language_dynamic_enable("title","") as $dynlang) {
               $datArr=array_merge($datArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("description","") as $dynlang) {
               $datArr=array_merge($datArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            $res = $this->db->insert(EXPERIENCE_TIMING, $datArr);
            echo $res;
        } else {
            redirect();
        }
    }

    /*Change timing status*/
    public function change_timing_status()
    {
        if ($this->checkLogin('U') != '') {
            $id = $this->input->post('id');
            $status = $this->input->post('status');
            $exp_date_id = $this->input->post('exp_date_id');
            $condition = array('id' => $id);
            $data = array('status' => $status);
            $res = $this->experience_model->update_details(EXPERIENCE_TIMING, $data, $condition);
            if ($status == '0') {
                $shedule_timing = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_TIMING, ' where experience_id=' . $exp_date_id . ' and status="1"');//active
                if ($shedule_timing->num_rows() == 0) {
                    echo '2';
                } else {
                    echo $res;
                }
            }
        } else {
            redirect();
        }
    }

    /*Edit Time sheets*/
    public function get_timesheets_for_edit()
    {
        if ($this->checkLogin('U') != '') {
            /*Start-Time drop down array generation*/
            $timeArr = array();
            $startTime = strtotime("00:00");
            $endTime = strtotime("24:00");
            $returnTimeFormat = 'G:i';
            $current = time();
            $addTime = strtotime('+60 mins', $current);
            $diff = $addTime - $current;
            while ($startTime < $endTime) {
                $timeArr[date($returnTimeFormat, $startTime)] = date($returnTimeFormat, $startTime);
                $startTime += $diff;
            }
            /*Close-Time drop down array generation*/
            $id = $this->input->post('id');
            $condition = array('id' => $id);
            $res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
            $data = $res_data->result();
                if ($this->lang->line('From_Time') != '') {
                    $from_time= stripslashes($this->lang->line('From_Time'));
                } else {
                    $from_time= "From Time";
                } 
                
                if ($this->lang->line('to_time') != '') {
                    $to_time= stripslashes($this->lang->line('to_time'));
                } else {
                    $to_time= "To Time";
                } 
                
                if ($this->lang->line('Date') != '') {
                    $date= stripslashes($this->lang->line('Date'));
                } else {
                    $date= "Date";
                } 
                     
               // foreach(language_dynamic_enable("title", "") as $dynlang){                  
                    if ($this->lang->line('Title') != '') {
                        $tittle= stripslashes($this->lang->line('Title'));
                    } else {
                        $tittle= "Title". "(". $dynlang[0]. ")";
                    } 
               // }

                //foreach(language_dynamic_enable("description", "") as $dynlang){

                    if ($this->lang->line('list_Description') != '') {
                        $desc= stripslashes($this->lang->line('list_Description'));
                    } else {
                        $desc= "Description". "(". $dynlang[0]. ")";
                    } 
                //}

                if ($this->lang->line('exp_update') != '') {
                    $update= stripslashes($this->lang->line('exp_update'));
                } else {
                    $update= "Update";
                } 
                if ($this->lang->line('Reset') != '') {
                    $reset= stripslashes($this->lang->line('Reset'));
                } else {
                    $reset= "Reset";
                } 
                if ($this->lang->line('Cancel') != '') {
                    $cancel= stripslashes($this->lang->line('Cancel'));
                } else {
                    $cancel= "Cancel";
                } 
                if ($this->lang->line('Action') != '') {
                    $action= stripslashes($this->lang->line('Action'));
                } else {
                    $action= "Action";
                } 
            $str = '<tr id="grand_child_edit_' . $id . '" class="grand_hild_edit_' . $id . '">';
            foreach ($data as $time) {                
                $str .= '<td colspan="4">';
                $str .= '<form id="time_sheet_' . $time->id . '" name="time_sheet_' . $time->id . '">';
                $str .= '<input type="hidden" name="id" value="' . $time->id . '">';
                $str .= '<input type="hidden" id="experience_id_' . $time->id . '" name="experience_id" value="' . $time->experience_id . '">';
                $str .= '<div class="square_box mich" id="timesheet_' . $time->id . '">';
                $str .= '<div class="text-danger" id="edit_form_error_msg_' . $time->id . '"></div>';
                $str .= '<div class="col-md-12"><div class="form-group text-left"><p>'.$date.' <span class="impt">*</span></p>  <input type="text" name="schedule_date" id="schedule_date_' . $time->id . '" class="dev_multi_schedule_date input_class" data-date="' . $time->schedule_date . '" value="' . $time->schedule_date . '"></div></div>';
                $str .= '<div class="form-group text-left">';
                $str .= '<div class="col-md-6"><p>'.$from_time.' <span class="impt">*</span></p>' . form_dropdown("start_time", $timeArr, date('G:i', strtotime($time->start_time)), array("onchange" => "assign_to_time_hour($time->id,$time->exp_dates_id)", "id" => "start_time_" . $time->id)) . ' </div>';
                $str .= '<div class="col-md-6"><p>'.$to_time.' <span class="impt">*</span></p>' . form_dropdown("end_time", $timeArr, date('G:i', strtotime($time->end_time)), array("id" => "end_time_" . $time->id)) . '</div>';
                $str .= '</div>';
                $str .= '<div class="col-md-12"><div class="form-group text-left"><p>'.$tittle.' <span class="impt">*</span></p> <input name="title" type="text" value="' . $time->title . '"  id="title_' . $time->id . '" class="input_class"  onkeydown="word_count(this)">';
                $str .= '<p><span id="title_' . $time->id . '_char_count"> </span>  </p></div></div>';
    
          
                $str .= '<div class="col-md-12" ><div class="form-group text-left" ><p> '.$desc.' <span class="impt" >*</span ></p ><textarea  name = "description" id = "description_' . $time->id . '" onkeydown = "description_count(this)" > ' . $time->description . '</textarea >';
                $str .= '<p><span id="description_' . $time->id . '_char_count"></span> </p></div></div>';

                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                      
                //  foreach(language_dynamic_enable("description", "") as $dynlang){ 
                $str .= '<div class="col-md-12"><div class="form-group text-left"><p>'.$tittle.' '.$data->name.' <span class="impt">*</span></p> <input name="title_'.$data->lang_code.'" type="text" value="' . $time->{'title_'.$data->lang_code} . '"  id="title_' . $time->id . '" class="input_class"  onkeydown="word_count(this)">';
                $str .= '<p><span id="title_' . $time->id . '_char_count"> </span>  </p></div></div>';

           // }

               // foreach(language_dynamic_enable("description", "") as $dynlang){ 
                $str .= '<div class="col-md-12" ><div class="form-group text-left" ><p>Description in  '.$data->name.' <span class="impt" >*</span ></p ><textarea  name = "description_'.$data->lang_code.'" id = "description_' . $time->id . '" onkeydown = "description_count(this)" > ' . $time->{'description_'.$data->lang_code} . '</textarea >';
                $str .= '<p><span id="description_' . $time->id . '_char_count"></span> </p></div></div>';
}}

                $str .= '<div class="clear text-right" ><button class="submitBtn1" id = "update_time_sheet_' . $time->id . '" type = "button" onclick = "update_time_sheet(' . $time->id . ',' . $time->exp_dates_id . ')" > '.$update.'</button >&nbsp;&nbsp;<button class="submitBtn1" id = "reset_time_sheet_' . $time->id . '" type = "button" > '.$reset.'</button >&nbsp;&nbsp;<button class="submitBtn1"  id = "reset_time_sheet_' . $time->id . '" type = "reset" onclick = "cancel_time_sheet_grand_child(' . $time->id . ')" > '.$cancel.'</button ></div > ';
                $str .= '</div > ';
                $str .= '</form > ';
                $str .= '</td > ';
            }
            echo $str;
        } else {
            redirect();
        }
    }

    /*Delete time sheet*/
    public function delete_timesheet()
    {
        if ($this->checkLogin('U') != '') {
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->delete(EXPERIENCE_TIMING);
        } else {
            redirect();
        }
    }

    /*Update the edited timesheet*/
    public function update_timesheet()
    {
        if ($this->checkLogin('U') != '') {
            $start_time = $this->input->post('start_time');
            $end_time = $this->input->post('end_time');
            $title = $this->input->post('title');
            $description = $this->input->post('description');
            $id = $this->input->post('id');
            $schedule_date = $this->input->post('schedule_date');
            $condn = array('id' => $id);  

            $dataArr = array('status' => '1', 'start_time' => $start_time, 'end_time' => $end_time, 'title' => $title, 'description' => $description, 'schedule_date' => $schedule_date);

            foreach(language_dynamic_enable("title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("description","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            $res = $this->experience_model->update_details(EXPERIENCE_TIMING, $dataArr, $condn);
            echo $res;
        } else {
            redirect();
        }
    }

    public function dashboard_experience_listing()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            if ($this->uri->segment(3) == 'completed') {
                $this->data ['enable_complete_popup'] = 'yes';
            }
            $status = $this->uri->segment(2, 0);
            $this->data ['heading'] = 'Dashboard-Experience';
            if ($status == 'all') {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status = '';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                //echo $paginationNo; exit;
                $pageLimitStart = $paginationNo;
                $pageLimitEnd = $pageLimitStart + $searchPerPage;
                $get_ordered_list_count = $this->experience_model->get_dashboard_experience_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = ' < ';
                $config ['next_link'] = ' > ';
                $config ["cur_tag_open"] = '<a class="active">';
                $config ["cur_tag_close"] = '</a>';
                $config ['attributes'] = array('class' => 'pages');
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'experience/all';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['ExperienceDetail'] = $this->experience_model->get_dashboard_experience($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination Start*/
            } else if ($status == 'UnPublish') {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status = '0';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $pageLimitEnd = $pageLimitStart + $searchPerPage;
                $get_ordered_list_count = $this->experience_model->get_dashboard_experience_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = 'Previous';
                $config ['next_link'] = 'Next';
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'experience/UnPublish';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['ExperienceDetail'] = $this->experience_model->get_dashboard_experience($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination Start*/
            } else if ($status == 'Publish') {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status = '1';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $pageLimitEnd = $pageLimitStart + $searchPerPage;
                $get_ordered_list_count = $this->experience_model->get_dashboard_experience_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = 'Previous';
                $config ['next_link'] = 'Next';
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'experience/Publish';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['ExperienceDetail'] = $this->experience_model->get_dashboard_experience($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination Start*/
            } else {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status = '';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $pageLimitEnd = $pageLimitStart + $searchPerPage;
                $get_ordered_list_count = $this->experience_model->get_dashboard_experience_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = 'Previous';
                $config ['next_link'] = 'Next';
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'experience/all';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['ExperienceDetail'] = $this->experience_model->get_dashboard_experience($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination Start*/
            }
            //echo $this->db->last_query();
            $hosting_commission_status = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_listing" and status = "Active"';
            $this->data ['hosting_commission_status'] = $this->experience_model->ExecuteQuery($hosting_commission_status);
            $this->data ['controller'] = $this;
            $this->load->view('site/experience/dashboard-experience', $this->data);
        }
    }

    /* Experience Listing ends  */
    /* Add New Experience */
    public function new_experience()
    {
        if ($this->checkLogin('U') != '') {
            if ($this->session->userdata('language_code') == '') $condition = array('status' => 'Active', 'lang' => 'en'); else
                $condition = array('status' => 'Active', 'lang' => $this->session->userdata('language_code'));
            //$this->data['listspace'] = $this->experience_model->get_all_details(LISTSPACE,$condition);
            //$this->data['listValues'] = $this->experience_model->get_all_details(LISTINGS,array('id'=>1));
            $condition = array('status' => 'Active');
            $this->data['experience_typeList'] = $this->experience_model->get_all_details(EXPERIENCE_TYPE, $condition);
            //print_r($this->data['experience_typeList']);
            $this->load->view('site/experience/new_experience', $this->data);
        } else {
            redirect();
        }
    }

    public function add_experience()
    {
        //echo '<pre>'; print_r($_POST); die;
        //$this->input->post('room_type');
        $address = $this->input->post('city');
        $date_count = $this->input->post('date_count');
        $experience_title = $this->input->post('experience_title');
        $experience_type = $this->input->post('experience_type');
        $experience_category = $this->input->post('experience_category');
        $currency = $this->input->post('currency');
        if ($experience_category != '1') $date_count = 1;
        if ($this->checkLogin('U') == '') {
            if ($this->lang->line('Please sign in before listing your experience') != '') {
                $message = stripslashes($this->lang->line('Please sign in before listing your experience'));
            } else {
                $message = "Please sign in before listing your experience";
            }
            $this->setErrorMessage('error', $message);
            redirect(base_url());
        } else {
            $id = $this->checkLogin('U');
            $condition = array('id' => $id, 'status' => 'Active');
            $this->data['checkUser'] = $this->experience_model->get_all_details(USERS, $condition);
            $cityArr = explode(',', $this->input->post('city'));
            if ($this->data['checkUser']->num_rows() == 1) {
                $data = array('type_id' => $experience_type, 'date_count' => $date_count, 'experience_title' => $experience_title, 'user_id' => $id, 'currency' => $currency, 'status' => '0');
                //echo '<pre>'; print_r($data); die;
                $this->experience_model->simple_insert(EXPERIENCE, $data);
                //echo $this->db->last_query();die;
                $getInsertId = $this->experience_model->get_last_insert_id();
                //$dataArr = array('productId' => $getInsertId,'street' => $street,'area' => $area,'location' => $location,'city' => $city,'state' => $state,'country' => $country,'lang' => $lang,'lat' => $lat,'zip' => $zip);
                $dataArr = array('experience_id' => $getInsertId, 'address' => $address);
                $this->experience_model->simple_insert(EXPERIENCE_ADDR, $dataArr);
                $inputArr3 = array();
                $inputArr3 = array('product_id' => $getInsertId);
                //$this->experience_model->simple_insert(PRODUCT_BOOKING,$inputArr3);
                $inputArr4 = array();
                $inputArr4 = array('id' => $getInsertId);
                //$this->experience_model->simple_insert(SCHEDULE,$inputArr4);
                $this->experience_model->update_details(USERS, array('is_experienced' => '1'), array('id' => $id));
                redirect('manage_experience/' . $getInsertId);
            } else {
                if ($this->lang->line('Please_register_before_you_start_listing_your_experience') != '') {
                    $message = stripslashes($this->lang->line('Please_register_before_you_start_listing_your_experience'));
                } else {
                    $message = "Please register before you start listing your experience";
                }
                $this->setErrorMessage('error', $message);
                redirect(base_url());
            }
        }
    }

    /* Add New Experience Ends */
    /* get timing of perticulae date */
    public function get_timing()
    {
        $experience_id = $this->input->post('experience_id');
        $date_id = $this->input->post('date_id');
        $i = 0;
        //echo $experience_id;
        $sel_timing = "select * from " . EXPERIENCE_TIMING . " where exp_dates_id='" . $date_id . "' and experience_id='" . $experience_id . "'";
        $sel_res = $this->experience_model->ExecuteQuery($sel_timing);
        $date_count = $this->input->post('date_count');
        $schedule_date = '';
        if ($date_count > 1) {
            $schedule_date .= '<input type="text" class="dev_multi_schedule_date col-sm-2"  id="schedule_date" name="schedule_date[]" />';
        } else {
            $schedule_date = ' <input type="text" class="dev_multi_schedule_date dev_schedule_date col-sm-2"  id="schedule_date1" name="schedule_date[]"  />';
        }
        //echo $sel_res->num_rows();
        if ($sel_res->num_rows() > 0) {
            echo '
            ';
            foreach ($sel_res->result() as $timing) {
                echo '

                <div class="exp-addpanel">
                <div style="display: block;overflow: hidden;">
                <div class="col-md-6">
                <label>Date</label>
                    <input type="text" class="dev_multi_schedule_date col-sm-2" onclick="setDatepickerHere()"   id="schedule_date' . $i . '" name="schedule_date[]" onkeypress="return isNumber(event)" value="' . $timing->schedule_date . '"  />
                    </div>
                    </div>
                    <div class="col-md-6">
                    <label>Start Time</label>
                    <input type="text" class="dev_time" name="start_time[]"  value="' . $timing->start_time . '" onkeypress="return isNumber(event)" required/>
                    </div>  

                        <div class="col-md-6">
                    <label>End Time</label>
                    <input type="text" class="dev_time"  name="end_time[]" value="' . $timing->end_time . '" onkeypress="return isNumber(event)" required />
                        </div>

                        <div class="col-md-12 exp-full">

                    <label>Title</label>
                    <input type="text" class="" name="schedule_title[]"  value="' . $timing->title . '" required />
                        </div>
                        <div class="col-md-12">
                    <label>Description</label>
                    <textarea class="" name="schedule_description[]" required >' . $timing->description . '</textarea>
                    </div>
                
                </div>';
                echo '<input type="button" class="filter-btn" id="update_btn" style="float: left;" name="" value="Update" onclick="update_timing(' . $timing->id . ')">
                                <input type="reset" class="filter-btn" id="reset_btn" style="float: left;"  name="" value="Cancel" onclick="cancel_timing(' . $timing->id . ')"><br>';
                echo '<div class="minus-button"><button type="button" class="" id="add_timing_btn" onclick="delete_timing_row(' . $timing->id . ')" ><i class="fa fa-minus-circle" aria-hidden="true"></i></button></div> ';
                $i++;
            }
        }
        if ($sel_res->num_rows() == 0) $i = 1;
        echo '<div class="exp-addicon" style="text-align:right; font-size: 14px;"><div class="add-new"> <button type="button" class="" id="add_timing_btn_' . $i . '" onclick="add_timing_row(' . $i . ')" >
<span class="add-timeing">Add new Timeing</span><i class="fa fa-plus-circle" aria-hidden="true"></i></button></div></div>';
    }

    /* Experience  schedule  */
    /* newly added */
    public function get_timesheets_forStatus()
    {
        if ($this->lang->line('Time') != '') {
                    $Time= stripslashes($this->lang->line('Time'));
                } else {
                    $Time= "Time";
                } 
                if ($this->lang->line('Title') != '') {
                    $tittle= stripslashes($this->lang->line('Title'));
                } else {
                    $tittle= "Title";
                } 
                if ($this->lang->line('schedule_date') != '') {
                    $schedule_dt= stripslashes($this->lang->line('schedule_date'));
                } else {
                    $schedule_dt= "Scheduled Date";
                }
                if ($this->lang->line('Status') != '') {
                    $st= stripslashes($this->lang->line('Status'));
                } else {
                    $st= "Status";
                } 
        if ($this->checkLogin('U') != '') {
            $exp_dates_id = $this->input->post('date_id');
            $status_is = $this->input->post('status_is');
            $condition = array('exp_dates_id' => $exp_dates_id);
            $res_data = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
            $data = $res_data->result();
            $str = '<tr id="child_view_' . $exp_dates_id . '" class="child_' . $exp_dates_id . '">';
            if (count($data) > 0) {
                $str .= '<td colspan="3">';
                $str .= '<table class="table table-striped">';
                $str .= '<thead><th>'.$schedule_dt.'</th><th>'.$Time.'</th><th>'.$tittle.'</th><th>'.$st.'</th></thead>';
                foreach ($data as $time) {
                    $str .= '<tr id="first_child_' . $time->id . '"><td><input type="hidden" value="' . $time->schedule_date . '" class="dev_multi_schedule_date_new">' . $time->schedule_date . '</td><td>' . date('h:i A', strtotime($time->start_time)) . '-' . date('h:i A', strtotime($time->end_time)) . '</td>
                <td>' . $time->title . '</td>
                <td class="date_actions">' . $status_is . '</td>
                </tr>';
                }
                $str .= '</table>';
                $str .= '</td>';
            } else {
                $str .= '<td colspan="3">';
                $str .= 'No schedule found..';
                $str .= '</td>';
            }
            $str .= '</tr>';
            echo $str;
        } else {
            redirect();
        }
    }

    public function add_tagline_experience($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $exp_tagline = $this->input->post('exp_tagline');
          //  $exp_tagline_ar = $this->input->post('exp_tagline_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('exp_tagline' => $exp_tagline);

            //echo '<pre>'; print_r($data); die;
            $fieldname = array("exp_tagline");
                foreach($fieldname as $fieldnm){
                    foreach (language_dynamic_enable($fieldnm, "") as $dynlang) {
                    $data = array_merge($data, array($dynlang[1] => $this->input->post($dynlang[1])));
                }

            } 
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('experience_image/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_what_we_do($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $what_we_do = $this->input->post('what_we_do');
           // $what_we_do_ar = $this->input->post('what_we_do_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('what_we_do' => $what_we_do);
          //echo '<pre>'; print_r($data); die;
             $fieldname = array("what_we_do");
                foreach($fieldname as $fieldnm){
                    foreach (language_dynamic_enable($fieldnm, "") as $dynlang) {
                    $data = array_merge($data, array($dynlang[1] => $this->input->post($dynlang[1])));
                }
            } 

//echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('where_we_will_be/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_guest_requirements($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $guest_requirement = $this->input->post('guest_requirement');
           // $guest_requirement_ar = $this->input->post('guest_requirement_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array(
                'guest_requirement' => $guest_requirement
                );
            foreach(language_dynamic_enable("guest_requirement","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('group_size/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_note_to_guest($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $note_to_guest = $this->input->post('note_to_guest');
           // $note_to_guest_ar = $this->input->post('note_to_guest_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array(
                'note_to_guest' => $note_to_guest
                );
             foreach(language_dynamic_enable("note_to_guest","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('about_exp_host/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_about_exp_host($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $about_host = $this->input->post('about_host');
            //$about_host_ar= $this->input->post('about_host_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array(
                'about_host' => $about_host
                
                );
            foreach(language_dynamic_enable("about_host","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('guest_requirement/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_group_size($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $group_size = $this->input->post('group_size');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('group_size' => $group_size);
            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('price/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_price($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $price = $this->input->post('price');
            $currency = $this->input->post('currency');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $condition2 = array('experience_id' => $expid);
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('price' => $price, 'currency' => $currency);
            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->experience_model->update_details(EXPERIENCE_DATES, $data, $condition2);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('experience_cancel_policy/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_location_description($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $location_description = $this->input->post('location_description');
           // $location_description_ar = $this->input->post('location_description_ar');
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('location_description' => $location_description);
            $fieldname = array("location_description");
                foreach($fieldname as $fieldnm){
                    foreach (language_dynamic_enable($fieldnm, "") as $dynlang) {
                    $data = array_merge($data, array($dynlang[1] => $this->input->post($dynlang[1])));
                }
            } 

            //echo '<pre>'; print_r($data); die;
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                redirect('location_details/' . $expid);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function add_cancel_policy($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $cancel_policy = $this->input->post('cancellation_policy');
            $cancel_policy_des = $this->input->post('cancel_policy_des');
           // $cancel_policy_des_ar = $this->input->post('cancel_policy_des_ar');
            $security_deposit = $this->input->post('sec_deposit');
            if ($cancel_policy == 'No Return') {
                $cancel_percentage = 0;
            } else {
                $cancel_percentage = $this->input->post('cancel_percentage');
            }
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $id = $this->checkLogin('U');
            $data = array('cancel_policy' => $cancel_policy,'meta_title'=> $this->input->post('meta_title'), 'cancel_policy_des' => $cancel_policy_des,'cancel_percentage' => $cancel_percentage, 'security_deposit' => $security_deposit);
             foreach(language_dynamic_enable("cancel_policy_des","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("meta_description","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
            foreach(language_dynamic_enable("meta_keyword","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("meta_title","") as $dynlang) {
               $data=array_merge($data,array($dynlang[1] => $this->input->post($dynlang[1])));
            }
           // print_r($data);exit();
            $this->experience_model->update_details(EXPERIENCE, $data, $condition);
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
           
            $message = "Your Experience is successfully added";
            $this->setErrorMessage('success', $message);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/exp_listing_confirm', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Add tagline view load*/
    public function tagline_experience($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/tagline_experience', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function what_we_do($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);     
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/what_we_do', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function where_we_will_be($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/where_we_will_be', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function what_you_will_provide($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            $this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
            $this->data['lang_count'] = $this->experience_model->get_all_details(LANGUAGES, array('status'=>'Active','dynamic_lang'=>'1'))->num_rows();

            /*print_r($this->data['guide_provides']);
            echo '<hr>';
            print_r($condition);
            echo '<br>'.$condition.'/'.EXPERIENCE_GUIDE_PROVIDES;
            exit;*/
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/what_you_will_provide', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function notes_to_guest($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/notes_to_guests', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function about_exp_host($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/about_exp_host', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function group_size($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            $minimum_stay = $this->experience_model->get_data_minimum_stay();
            /*echo '<pre>';
            print_r($minimum_stay);
            echo '</pre>';
            */
            $this->data['minimum_stay'] = $minimum_stay->result();
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/group_size', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function price($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            //$this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES,$condition);
            $currentCurrency = $this->experience_model->get_all_details(CURRENCY, array('status'=>'Active'));
            $currentCurrency = $currentCurrency->result();
            $user_array = array('0' => array('currency_type' => 'Select Currency') );
           $user_array = json_decode(json_encode($user_array));
            $currentCurrency  = array_merge($currentCurrency,$user_array);

            $last_array = count($currentCurrency)-1;
                            $tmp = $currentCurrency[0];
                            $currentCurrency[0] = $currentCurrency[$last_array];
                            $currentCurrency[$last_array] = $tmp;
         //  echo "<pre>"; print_r($currentCurrency);exit();
            $this->data['currentCurrency_all'] = $currentCurrency;
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/price', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }


    /*newly added*/
    /* Experience  schedule ends  */
    /* Experience  details starts  */
    public function experience_details_old($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
            $this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
            $condition = array('experience_id' => $expid);
            $this->data['guide_provides'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/experience_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function saveKit()
    {   $kit_title = $this->input->post('kit_title');
       // $kit_title_ar = $this->input->post('main_title_ar');
        $kit_detailed_title = $this->input->post('kit_detailed_title');
       // $kit_detailed_title_ar = $this->input->post('detailed_title_ar');
        $kit_count = $this->input->post('kit_count');
        $kit_description = str_replace("'", "`", $this->input->post('kit_description'));
        //$kit_description_ar = str_replace("'", "`", $this->input->post('kit_description_ar'));
        $experience_id = $this->input->post('experience_id');
        $checkDatesExist = $this->experience_model->ExecuteQuery("select id from " . EXPERIENCE_GUIDE_PROVIDES . " where kit_title= '" . $kit_title . "' and experience_id='" . $experience_id . "' and status='1' ");
   // print_r($checkDatesExist->result());exit();
        if ($checkDatesExist->num_rows() > 0) {
            $message = array('case' => '3');
        } else {
            $dataArr = array('experience_id' => $experience_id, 'kit_title' => $kit_title, 'kit_detailed_title' => $kit_detailed_title,  'kit_description' => $kit_description,  'kit_count' => $kit_count, 'created_at' => date('Y-m-d H:i:s'), 'status' => '1');

        foreach(language_dynamic_enable("kit_title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("kit_detailed_title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("kit_description","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            $this->db->insert(EXPERIENCE_GUIDE_PROVIDES, $dataArr);
            //update in experience table kit_content
            $condition = array('experience_id' => $experience_id);
            $guide_provides = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
            foreach ($guide_provides->result() as $row) {
                $kit[] = $row->id;
            }
            $kit = implode(',', $kit);
            $dataArr = array('kit_content' => $kit);
            $this->experience_model->update_details(EXPERIENCE, $dataArr, $condition);
            $message = array('case' => '1');
        }
        echo json_encode($message);
    }

    public function update_kit()
    {
        $kit_id = $this->input->post('kit_id');
        $kit_title = $this->input->post('kit_title');
       // $kit_title_ar = $this->input->post('main_title_ar');
        $kit_detailed_title = $this->input->post('kit_detailed_title');
       // $kit_detailed_title_ar = $this->input->post('detailed_title_ar');
        $kit_count = $this->input->post('kit_count');
        $kit_description = str_replace("'", "`", $this->input->post('kit_description'));
        //$kit_description_ar = str_replace("'", "`", $this->input->post('kit_description_ar'));
        $experience_id = $this->input->post('experience_id');
        $condition = array('id' => $kit_id);

        $dataArr = array('experience_id' => $experience_id, 'kit_title' => $kit_title, 'kit_detailed_title' => $kit_detailed_title, 'kit_description' => $kit_description, 'kit_count' => $kit_count, 'created_at' => date('Y-m-d H:i:s'), 'status' => '1');
       
            foreach(language_dynamic_enable("kit_title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("kit_detailed_title","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }

            foreach(language_dynamic_enable("kit_description","") as $dynlang) {
               $dataArr=array_merge($dataArr,array($dynlang[1] => $this->input->post($dynlang[1])));
            }



        $this->experience_model->update_details(EXPERIENCE_GUIDE_PROVIDES, $dataArr, $condition);
        $condition = array('experience_id' => $experience_id);
        $guide_provides = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
        foreach ($guide_provides->result() as $row) {
            $kit[] = $row->id;
        }
        $kit = implode(',', $kit);
        $dataArr = array('kit_content' => $kit);
        $this->experience_model->update_details(EXPERIENCE, $dataArr, $condition);
        $message = array('case' => '1');
        echo json_encode($message);
    }

    /* delete kit */
    public function delete_kit_package()
    {
        //exit();
        //echo "prd_id" . $product_id ; exit;
        $id = $this->uri->segment(4);
        $product_id = $this->uri->segment(5);
        $this->db->where('id', $id)->delete(EXPERIENCE_GUIDE_PROVIDES);
        $this->experience_model->update_details(EXPERIENCE, array('kit_content' => ''), array('experience_id' => $product_id));
        redirect('what_you_will_provide/' . $product_id);
    }



    /* Experience  details ends  */
    /* Additional Details starts */
    public function additional_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/additional_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }
    /* Additional Details ends */
    /*  location details starts */
    public function location_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('experience_id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            //echo "result is";print_r($this->data['listDetail']->result());
            //$this->db->last_query();
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->data['Experience_address'] = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $expid));
                //echo "expp"; print_r($this->data['Experience_address']->result());
                $this->load->view('site/experience/location_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    /*Saving the address to DB*/
    public function insert_address()
    {
        $actual_link = $this->input->post('actual_link');
        if ($this->checkLogin('U') != '') {
            $prd_id = $this->input->post('product_id');
            $product_id = array('experience_id' => $prd_id);
            $lat = $this->input->post('latitude');
            $lang = $this->input->post('longitude');
            if ($lat == "" || $lang == "") {
                $newAddress = '';
                if ($this->input->post('address') != '') $newAddress .= ',' . $this->input->post('address');
                if ($this->input->post('city') != '') $newAddress .= ',' . $this->input->post('city');
                if ($this->input->post('state') != '') $newAddress .= ',' . $this->input->post('state');
                if ($this->input->post('country') != '') $newAddress .= ',' . $this->input->post('country');
                if ($this->input->post('post_code') != '') $newAddress .= ',' . $this->input->post('post_code');
                $address = str_replace(" ", "+", $newAddress);
                $google_map_api=$this->config->item('google_developer_key');
                $protocol=$this->data['protocol'];
                $json = file_get_contents($protocol."maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
                $json = json_decode($json);
                $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                if ($lat == null || $lat == '') {
                    $lat = '0';
                }
                if ($lang == null || $lang == '') {
                    $lang = '0';
                }
            }
            $dataArr = array('address' => $this->input->post('address_location'), 'country' => $this->input->post('country'), 'state' => $this->input->post('state'), 'city' => $this->input->post('city'), 'street' => $this->input->post('address'), 'zip' => $this->input->post('post_code'), 'lat' => $lat, 'lang' => $lang);
            $data = array_merge($dataArr, $product_id);
            $this->data['productDetail'] = $this->experience_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $prd_id));
            if ($this->data['productDetail']->num_rows() > 0) {
                $this->experience_model->update_details(EXPERIENCE_ADDR, $dataArr, array('experience_id' => $prd_id));
            } else {
                $this->experience_model->simple_insert(EXPERIENCE_ADDR, $data);
            }
        }
        redirect($actual_link);
        //echo "<script>window.history.go(-1)</script>";exit();
        //echo base_url()."amenities_listing/".$listDetail->row()->id;
    }

    /*  location details ends */
    /* Group Details starts */
    public function group_details($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/group_details', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }
    /* Group Details ends */
    /* Guest Requirement starts */
    public function guest_requirement($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $this->data['id'] = $expid;
            $condition = array('experience_id' => $expid);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/guest_requirement', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }
    /* Guest requirement ends */
    /* Cancel Policy starts */
    public function experience_cancel_policy($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $this->data['id'] = $expid;
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            if ($this->data['listDetail']->row()->currency != '') {
                $currentCurrency = $this->product_model->get_all_details(CURRENCY, array('currency_type' => $this->data['listDetail']->row()->currency));
                $this->data['currentCurrency'] = $currentCurrency->row()->currency_symbols;
                $this->data['currentCurrency_type'] = $currentCurrency->row()->currency_type;
            }
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->load->view('site/experience/experience_cancel_policy', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    //add timing row
    public function add_timing_row()
    {
        $rowId = $this->input->post('rowID') + 1;
        $date_count = $this->input->post('date_count');
        $from_date = $this->input->post('from_date');
        $schedule_date = '';
        if ($date_count > 1) {
            $schedule_date .= '<input type="text" class="dev_multi_schedule_date col-sm-2"  id="schedule_date' . $rowId . '" name="schedule_date[]" onclick="setDatepickerHere()" onkeypress="return isNumber(event)" />';
        } else {
            $schedule_date .= ' <input type="text" class="dev_multi_schedule_date dev_schedule_date col-sm-2"  id="schedule_date' . $rowId . '" name="schedule_date[]" value="' . $from_date . '" onkeypress="return isNumber(event)" readonly />';
        }
        echo '<div class="removeBlock"><div class="exp-addpanel">
                <div style="display:block; overflow:hidden;">
                 <div class="col-md-6">
                 <label>Date</label>
                ' . $schedule_date . '
                  </div>
                  </div>
                   <div class="col-md-6">
                    <label>Start Time</label>
                    <input type="text" class="dev_time" name="start_time[]" onkeypress="return isNumber(event)"   value="" required />
                     </div>

                    <div class="col-md-6">
                    <label>End Time</label>
                    <input type="text" class="dev_time"  name="end_time[]" onkeypress="return isNumber(event)" value="" required />
                         </div>

                         <div class="col-md-12 exp-full">
                    <label>Title</label>
                    <input type="text" class="" name="schedule_title[]"  value="" required />

                         </div>

                         <div class="col-md-12">
                    <label>Description</label>
                    <textarea class="" name="schedule_description[]" required ></textarea>
                 </div>
                </div>
                <div class="exp-addicon minus-button"><button type="button" class="btn1"><i class="fa fa fa-minus-circle" aria-hidden="true"></i></button></div></div>

                <div class="exp-addicon"><button type="button" class="" id="add_timing_btn_' . $rowId . '" onclick="add_timing_row(' . $rowId . ')" ><span class="add-timeing">Add new Timeing</span><i class="fa fa-plus-circle" aria-hidden="true"></i></button></div>';
    }

    public function save_date_schedule_timing()
    {
        //echo "savehere";die;
        //print_r($_POST);exit;
        $experience_id = $this->input->post('experience_id');
        $dates_id = $this->input->post('dates_id');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $schedule_title = $this->input->post('schedule_title');
        $schedule_description = $this->input->post('schedule_description');
        $schedule_date = $this->input->post('schedule_date');
        //print_r($schedule_description);exit;
        //echo $schedule_description;exit;
        $length = count($start_time);
        $this->db->where('exp_dates_id', $dates_id);
        $this->db->delete(EXPERIENCE_TIMING);
        $inserted_dates = array();
        for ($i = 0; $i < $length; $i++) {
            if (($start_time[$i] != '' && $end_time[$i] != '') && ($start_time[$i] != '00:00' && $end_time[$i] != '00:00')) {
                if (!(in_array($schedule_date[$i], $inserted_dates))) {
                    $dataArr = array('exp_dates_id' => $dates_id, 'experience_id' => $experience_id, 'schedule_date' => $schedule_date[$i], 'start_time' => $start_time[$i], 'end_time' => $end_time[$i], 'title' => $schedule_title[$i], 'description' => $schedule_description[$i] != '' ? $schedule_description[$i] : '', 'status' => '1');
                    $condition = array('exp_dates_id' => $dates_id, 'experience_id' => $experience_id, 'schedule_date' => $schedule_date[$i], 'start_time' => $start_time[$i]);
                    $time_details = $this->experience_model->get_all_details(EXPERIENCE_TIMING, $condition);
                    if ($time_details->num_rows() > 0) {
                        $condn = array('id' => $time_details->row()->id);
                        $this->experience_model->update_details(EXPERIENCE_TIMING, $dataArr, $condn);
                    } else {
                        $sel_q = "select * from " . EXPERIENCE_TIMING . " where experience_id='" . $experience_id . "' and schedule_date='" . $schedule_date[$i] . "' and (((start_time BETWEEN '" . $start_time[$i] . "' and '" . $end_time[$i] . "') or (end_time BETWEEN '" . $start_time[$i] . "' and '" . $end_time[$i] . "')))";
                        //exit;
                        $checkValid = $this->experience_model->ExecuteQuery($sel_q);
                        if ($checkValid->num_rows() == 0) $this->experience_model->simple_insert(EXPERIENCE_TIMING, $dataArr);
                    }
                }
            }
            $inserted_dates[] = $schedule_date[$i];
        }
        $message = array('case' => '2');
        echo json_encode($message);
    }

    public function delete_timing_row()
    {
        $row_id = $this->input->post('row_id');
        $this->db->where('id', $row_id);
        $this->db->delete(EXPERIENCE_TIMING);
        echo 'success';
    }

    //update date
    public function updateDates()
    {
        $date_id = $this->input->post('date_id');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $date_count = $this->input->post('date_count');
        $experience_id = $this->input->post('experience_id');
        $price = $this->input->post('price');
        $currency = $this->input->post('currency');
        $experience_details = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $experience_id));
        if ($experience_details->num_rows() > 0) {
            $price = $experience_details->row()->price;
            $currency = $experience_details->row()->currency;
        }
        $checkDatesExist = $this->experience_model->ExecuteQuery("select id from " . EXPERIENCE_DATES . " where  ((from_date BETWEEN '" . $from_date . "' and '" . $to_date . "') or (to_date BETWEEN '" . $from_date . "' and '" . $to_date . "')) and experience_id='" . $experience_id . "' and status='1' and id!='$date_id' ");
        if ($checkDatesExist->num_rows() > 0) {
            $message = array('case' => '3');
        } else {
            $dataArr = array('experience_id' => $experience_id, 'from_date' => $from_date, 'to_date' => $to_date, 'price' => $price, 'currency' => $currency, 'created_at' => date('Y-m-d H:i:s'), 'status' => '1');
            $this->db->where('id', $date_id);
            $this->db->update(EXPERIENCE_DATES, $dataArr);
            $message = array('case' => '1', 'date_id' => $date_id);
        }
        echo json_encode($message);
    }

    //delete signle date
    public function delete_date($date_id, $expId)
    {
        
        //delete experience date
        $this->db->where('id', $date_id);
        $this->db->delete(EXPERIENCE_DATES);
        // delete time schedule
        $this->db->where('exp_dates_id', $date_id);
        $this->db->delete(EXPERIENCE_TIMING);
        redirect('schedule_experience/' . $expId);
    }

    /*save details ajax call start*/
    public function saveDetailPage()
    {
        if ($this->checkLogin('U') != '') {
            $catID = $this->input->post('catID');
            $title = $this->input->post('title');
            $chk = $this->input->post('chk');
            $this->experience_model->update_details(EXPERIENCE, array($chk => $title), array('experience_id' => $catID));
            if ($this->lang->line('Successfully_saved') != '') {
                $message = stripslashes($this->lang->line('Successfully_saved!'));
            } else {
                $message = "Successfully saved!";
            }
            $this->setErrorMessage('success', $message);
        }
    }

    //save details ajax call ends
    /* Experience Image starts */
    public function experience_image($expid = '')
    {
        if ($this->checkLogin('U') != '') {
            $condition = array('id' => $expid, 'user_id' => $this->checkLogin('U'));
            $this->data['id'] = $expid;
            $userId = $this->checkLogin('U');
            $this->data['listDetail'] = $this->experience_model->view_experience_details("where p.experience_id=$expid and p.user_id=$userId");
            $condition = array('experience_id' => $expid);
            if ($this->data['listDetail']->num_rows() > 0) {
                $this->data['imgDetail'] = $this->experience_model->get_images($expid);
                $this->load->view('site/experience/experience_image', $this->data);
            } else
                redirect();
        } else {
            redirect();
        }
    }

    public function ajaxImageUpload_aws()
    {
        $prd_id = $this->input->post('experience_id');
        $totalCount = count($_FILES['photos']['name']);
        $nameArr = $_FILES['photos']['name'];
        $sizeArr = $_FILES['photos']['size'];
        $tmpArr = $_FILES['photos']['tmp_name'];
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
        for ($i = 0; $i < $totalCount; $i++) {
            $name = $nameArr[$i];
            $size = $sizeArr[$i];
            $tmp = $tmpArr[$i];
            $ext = $this->getExtension($name);
            if (strlen($name) > 0) {
                if (in_array($ext, $valid_formats)) {
                    $s3_bucket_name = $this->config->item('s3_bucket_name');
                    $s3_access_key = $this->config->item('s3_access_key');
                    $s3_secret_key = $this->config->item('s3_secret_key');
                    include('amazon/s3_config.php');
                    //Rename image name.
                    $actual_image_name = time() . "." . $ext;
                    if ($s3->putObjectFile($tmp, $bucket, $actual_image_name, S3::ACL_PUBLIC_READ)) {
                        $s3file = 'http://' . $bucket . '.s3.amazonaws.com/' . $actual_image_name;
                        mysql_query("INSERT INTO " . EXPERIENCE_PHOTOS . "(product_image,product_id) VALUES('$s3file','$prd_id')");
                    }
                }
            }
        }
        redirect('experience_image/' . $prd_id);
    }

    /*Photos Uploading*/
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

    public function ajaxImageUpload()
    {
        $prd_id = $this->input->post('id');
        $data = $this->input->post('image-data');
        /*Start-Uploading cropped image*/
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $img_name = date("Ymdhis");
        $file = 'images/experience/' . $img_name . '.png';
        $saved_file = file_put_contents($file, $data);
        if ($saved_file === false || ($saved_file == -1)) {
            echo '<p class="text-center text-danger" id="danger">Error in uploading</p>';
        } else {
            $success = $this->db->insert(EXPERIENCE_PHOTOS, array('product_image' => $img_name . '.png', 'product_id' => $prd_id));
            if ($success) {
                $home = base_url() . 'experience_image/' . $prd_id;
                echo '<script>window.location.href="' . $home . '"</script>';
            }
        }
    }

    /*Delete Exprience image*/
    public function deleteProductImage()
    {
        $returnArr['resultval'] = '';
        $prdID = $this->input->post('prdID');
        $photo_details = $this->db->select('*')->from(EXPERIENCE_PHOTOS)->where('id', $prdID)->get();
        foreach ($photo_details->result() as $image_name) {
            $gambar = $image_name->product_image;
            unlink("images/experience/" . $gambar);
        }
        $this->experience_model->commonDelete(EXPERIENCE_PHOTOS, array('id' => $prdID));
        $returnArr['resultval'] = $prdID;
        echo json_encode($returnArr);
    }

    /* manage Experience ends */
    /*  location change ajax */
    public function get_location()
    {
        $google_map_api = $this->config->item('google_developer_key');
        $address = $this->input->post('address');
        $retrnstr['street'] = '';
        $retrnstr['street1'] = '';
        $retrnstr['area'] = '';
        $retrnstr['location'] = '';
        $retrnstr['city'] = '';
        $retrnstr['state'] = '';
        $retrnstr['country'] = '';
        $retrnstr['lat'] = '';
        $retrnstr['long'] = '';
        $retrnstr['zip'] = '';
        $address = str_replace(" ", "+", $address);
        $json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
        $json = json_decode($json);
        $newAddress = $json->{'results'}[0]->{'address_components'};
        foreach ($newAddress as $nA) {
            if ($nA->{'types'}[0] == 'route') $retrnstr['street'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'sublocality_level_2') $retrnstr['street1'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'sublocality_level_1') $retrnstr['area'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'locality') $retrnstr['location'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'administrative_area_level_2') $retrnstr['city'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'administrative_area_level_1') $retrnstr['state'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'country') $retrnstr['country'] = $nA->{'long_name'};
            if ($nA->{'types'}[0] == 'postal_code') $retrnstr['zip'] = $nA->{'long_name'};
        }
        if ($retrnstr['city'] == '') $retrnstr['city'] = $retrnstr['location'];
        $retrnstr['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        $retrnstr['lang'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        echo json_encode($retrnstr);
    }

    //save new map details to experience address
    public function save_lat_lng()
    {
        $dataArr = array('lat' => $this->input->post('latitude'), 'lang' => $this->input->post('longitude'), 'city' => $this->input->post('city'), 'state' => $this->input->post('state'), 'country' => $this->input->post('country'), 'address' => $this->input->post('address'), 'area' => $this->input->post('area'), 'street' => $this->input->post('street'), 'location' => $this->input->post('location'));
        //print_r $dataArr;die;
        $this->product_model->update_details(EXPERIENCE_ADDR, $dataArr, array('experience_id' => $this->input->post('product_id')));
        //echo $this->db->last_query();die;
    }

    /* Experiernce Listing  Payment  starts */
    public function redirect_base()
    {
        if ($this->checkLogin('U') == '') {
            redirect('default_controller');
        } else {
            $hosting_commission_status = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_listing"  and status = "Active"';
            $this->data ['hosting_commission_status'] = $this->experience_model->ExecuteQuery($hosting_commission_status);
            if ($this->uri->segment(4) == 'completed') {
                $this->session->set_userdata('enable_complete_popup', 'yes');
                $this->data['productdetail'] = $this->experience_model->get_all_details(EXPERIENCE, array("id" => $this->uri->segment(5)));
                $this->load->database();
                $this->db->reconnect();
                redirect(base_url('experience/all'));
            } else if ($this->uri->segment(4) == 'payment') {
                $sel_q = "select id from " . EXPERIENCE_LISTING_PAYMENT . " where product_id='" . $this->uri->segment(5) . "' and payment_status='paid' ";
                $payment_done = $this->experience_model->ExecuteQuery($sel_q);
                if ($payment_done->num_rows > 0) {
                    redirect(base_url('experience/all'));
                } else {
                    $this->data['hosting_payment_details'] = $this->experience_model->get_all_details(COMMISSION, array("seo_tag" => 'experience_listing', 'status' => 'Active'));//1
                    $this->db->reconnect();
                    $this->data['ProductDetail'] = $this->experience_model->get_all_details(EXPERIENCE, array("experience_id" => $this->uri->segment(5)));//1
                    $this->data['productImage'] = $this->db->where(array("product_id" => $this->uri->segment(5)))->limit('1')->get(EXPERIENCE_PHOTOS);
                    $this->data['productAddress'] = $this->db->select('address')->where(array("experience_id" => $this->uri->segment(5)))->limit('1')->get(EXPERIENCE_ADDR);
                    $uniid = "A" . time();
                    $this->data['RefNo'] = $uniid;
                    $source = "DbQhpCuQpPM07244" . $uniid . "100MYR";
                    $val = sha1($source);
                    $rval = $this->hex2bin($val);
                    $this->data['signature'] = base64_encode($rval);
                    $this->load->view('site/experience/payment', $this->data);
                }
            } else {
                $condition = array('id' => $this->uri->segment(4));
                $this->data['listDetail'] = $this->experience_model->get_all_details(EXPERIENCE, $condition);
                $this->load->view('site/experience/phone_verification', $this->data);
            }
        }
    }

    function hex2bin($str)
    {
        $sbin = "";
        $len = strlen($str);
        for ($i = 0; $i < $len; $i += 2) {
            $sbin .= pack("H*", substr($str, $i, 2));
        }
        return $sbin;
    }

    /* redirect url ends */
    /* stripe payment starts */
    public function GuidePaymentCredit()
    {
        //echo 'test'; exit;
        $product_id = $this->input->post('booking_rental_id');
        $host_payment = $this->experience_model->get_all_details(EXPERIENCE_LISTING_PAYMENT, array('product_id' => $product_id, 'host_id' => $this->checkLogin('U')));
        if ($host_payment->num_rows() > 0) {
            $delete_failed_payment = 'DELETE FROM ' . EXPERIENCE_LISTING_PAYMENT . ' WHERE product_id=' . $product_id . ' AND host_id=' . $this->checkLogin('U');
            $this->experience_model->ExecuteQuery($delete_failed_payment);
        }
        $loginUserId = $this->checkLogin('U');
        $admin = $this->user_model->get_all_details(ADMIN, array('admin_type' => 'super'));
        $data = $admin->row();
        //print_r($data=$admin->row());
        $admin_currencyCode = trim($data->admin_currencyCode);
        /*  if($this->session->userdata('currency_type') != $admin_currencyCode){
            $unit_price=convertCurrency($admin_currencyCode,$this->session->userdata('currency_type'),1);
        }else{
            $unit_price=1;
        } */
        /** Preetha - Start - Get Experience currency code, compare with admin currency**/
        $getExpDetails = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
        $theCurrency = $getExpDetails->row()->currency;
        if ($theCurrency != $admin_currencyCode) {
            $unit_price = convertCurrency($admin_currencyCode, $theCurrency, 1);
        } else {
            $unit_price = 1;
        }
        /** Preetha - End - Get Experience currency code, compare with admin currency - to avoid validating the user to pay in same currency **/
        $paymentArr = array('product_id' => $product_id, 'amount' => $this->input->post('amount'), 'host_id' => $loginUserId, 'payment_status' => 'Pending', 'payment_type' => $this->input->post('payment_method'), //'currency_code' => 'USD',
            'currency_code' => $admin_currencyCode, 'currency_code_host' => $theCurrency, 'unitPerCurrencyHost' => $unit_price, 'commission' => $this->input->post('commission'), 'commission_type' => $this->input->post('commission_type'), 'hosting_price' => $this->input->post('hosting_price'));
        //$this->data['currencyType'] = 'USD';
        $this->data['currencyType'] = $admin_currencyCode;
        $this->experience_model->simple_insert(EXPERIENCE_LISTING_PAYMENT, $paymentArr);
        $totalAmount = number_format($this->input->post('total_price'),2);
        //echo $totalAmount; exit;
        define("StripeDetails", $this->config->item('payment_1'));
        $StripDetVal = unserialize(StripeDetails);
        $StripeVals = unserialize($StripDetVal['settings']);
        require_once('./stripe/lib/Stripe.php');
        $secret_key = $StripeVals['secret_key'];
        $publishable_key = $StripeVals['publishable_key'];
        $stripe = array("secret_key" => $secret_key, "publishable_key" => $publishable_key);
        //Stripe::setApiKey($stripe['secret_key']);
        //stripe_new
        \Stripe\Stripe::setApiKey($stripe['secret_key']);
        $token = $this->input->post('stripeToken');
        $amounts = $totalAmount * 100;
        $this->data['payment_gross'] = $totalAmount;
        try {
          // $customer = Stripe_Customer::create(array("card" => $token, "description" => "Experience Listing Purhcase for " . $this->config->item('email_title'), "email" => $this->input->post('email')));

            $customer = \Stripe\Customer::create(array("card" => $token, "description" => "Experience Listing for " . $this->config->item('email_title'), "email" => $this->input->post('email')));

            // Stripe_Charge::create(array("amount" => $amounts, # amount in cents, again
            //     "currency" => $this->data['currencyType'], "customer" => $customer->id));

            \Stripe\Charge::create(array("amount"   => ($amounts), # amount in cents, again
                    "currency" => $this->data['currencyType'], "customer" => $customer->id));

            $bookingId = 'XP' . time();
            $this->data['bookingId'] = $bookingId;
            //$dataArr = array('payment_status'=>'paid', 'bookingId'=>$bookingId);
            $dataArr = array('payment_status' => 'paid');
            $condition = array('product_id' => $product_id);
            $this->experience_model->update_details(EXPERIENCE_LISTING_PAYMENT, $dataArr, $condition);
            $message = "Successfully Paid for yor Experience";
            $this->setErrorMessage('success', $message);
            //redirect('experience/all');
            $this->load->view('site/experience/guide_success', $this->data);
        } catch (Exception $e) {
            $this->session->set_userdata('payment_error', $e->getMessage());
            //redirect('experience_order/failure/'.$e->getMessage());
            redirect('experience_order/failure/');
        }
    }

    /* stripe payment ends */
    public function paid_redirect()
    {
        # code...
    }

    /* paypal Payment starts */
    public function GuidePayment()
    {
        //print_r($this->input->post());
        //exit;
        $product_id = $this->uri->segment(4);
        $price = $this->uri->segment(5);
        //echo $price; exit;
        //delete failed payment for particular user
        $host_payment = $this->experience_model->get_all_details(EXPERIENCE_LISTING_PAYMENT, array('product_id' => $product_id, 'host_id' => $this->checkLogin('U')));
        if ($host_payment->num_rows() > 0) {
            $delete_failed_payment = 'DELETE FROM ' . EXPERIENCE_LISTING_PAYMENT . ' WHERE product_id=' . $product_id . ' AND host_id=' . $this->checkLogin('U');
            $this->experience_model->ExecuteQuery($delete_failed_payment);
        }
        $product = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
        $seller = $this->experience_model->get_all_details(USERS, array('id' => $product->row()->user_id));
        /*Paypal integration start */
        $this->load->library('paypal_class');
        $item_name = $this->config->item('email_title') . ' Experiences';
        $totalAmount = $this->uri->segment(5);
        //echo  $totalAmount; exit;
        //$usdvalue = $this->experience_model->get_all_details(CURRENCY,array('currency_type'=>'MYR'));
        //  $totalAmount = $totalAmount * $usdvalue->row()->currency_rate;
        $loginUserId = $this->checkLogin('U');
        //$lastFeatureInsertId = $this->session->userdata('randomNo');
        $admin = $this->experience_model->get_all_details(ADMIN, array('admin_type' => 'super'));
        $data = $admin->row();
        $admin_currencyCode = trim($data->admin_currencyCode);
        /** Preetha - Start - Get Experience currency code, compare with admin currency**/
        $getExpDetails = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
        $theCurrency = $getExpDetails->row()->currency;
        if ($theCurrency != $admin_currencyCode) {
            $unit_price = convertCurrency($admin_currencyCode, $theCurrency, 1);
        } else {
            $unit_price = 1;
        }
        /** Preetha - End - Get Experience currency code, compare with admin currency - to avoid validating the user to pay in same currency **/
        /*NAGOOR -START */
        $currency_result = $this->session->userdata('currency_result');
        $hosting_payment_details = $this->experience_model->get_all_details(COMMISSION, array("seo_tag" => 'experience_listing', 'status' => 'Active'));
        $this->db->reconnect();
        $ProductDetail = $this->experience_model->get_all_details(EXPERIENCE, array("experience_id" => $product_id));
        $product = $ProductDetail->row();
        $hostCurrency = $product->currency;
        $commission = $hosting_payment_details->row()->commission_percentage;
        $promotion_type = $hosting_payment_details->row()->promotion_type;
        if ($promotion_type == 'percentage') {
            $hosting_price = ($product->price / 100) * $commission;
            if ($hostCurrency != "USD") {
                if ($currency_result->$hostCurrency) {
                    $hosting_price = $hosting_price / $currency_result->$hostCurrency;
                } else {
                    $hosting_price = currency_conversion($hostCurrency, $this->session->userdata('currency_type'), $hosting_price);
                }
            }
        } else {
            $hosting_price = $commission;
        }
        /* NAGOOR -- END */
        $quantity = 1;
        $insertIds = array();
        $now = date("Y-m-d H:i:s");
        $paymentArr = array('product_id' => $product_id, 'amount' => $totalAmount, 'host_id' => $loginUserId, 'payment_status' => 'Pending', 'currency_code_host' => $theCurrency, 'unitPerCurrencyHost' => $unit_price, 'payment_type' => 'paypal', 'currency_code' => $admin_currencyCode, 'commission' => $commission,'commission_type' => $promotion_type, 'hosting_price' => $hosting_price );
        $this->experience_model->simple_insert(EXPERIENCE_LISTING_PAYMENT, $paymentArr);
        $insertIds[] = $this->db->insert_id();
        $paymtdata = array('randomNo' => $dealCodeNumber, 'randomIds' => $insertIds);
        $this->session->set_userdata($paymtdata);
        $paypal_settings = unserialize($this->config->item('payment_0'));
        $paypal_settings = unserialize($paypal_settings['settings']);
        if ($paypal_settings['mode'] == 'sandbox') {
            $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
        } else {
            $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
        }
        $ctype = ($paypal_settings['mode'] == 'sandbox') ? "USD" : "USD";
        // To change the currency type for below line >> Sandbox: USD, Live: MYR
        $CurrencyType = $this->experience_model->get_all_details(CURRENCY, array('currency_type' => $ctype));
        $this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type); //   USD
        $totAmt = $totalAmount * $CurrencyType->row()->currency_rate;
        $this->paypal_class->add_field('business', $paypal_settings['merchant_email']); // Business Email
        $this->paypal_class->add_field('return', base_url() . 'guide-payment-success/' . $product_id . '/' . $price); // Return URL
        $this->paypal_class->add_field('cancel_return', base_url() . 'order/failure'); // Cancel URL
        $this->paypal_class->add_field('notify_url', base_url() . 'order/ipnpayment'); // Notify url
        $this->paypal_class->add_field('custom', 'Experience|' . $loginUserId . '|' . $lastFeatureInsertId); // Custom Values
        $this->paypal_class->add_field('item_name', $item_name); // Product Name
        $this->paypal_class->add_field('user_id', $loginUserId);
        $this->paypal_class->add_field('quantity', $quantity); // Quantity
        //echo $totalAmount;die;
        // $this->paypal_class->add_field('amount', $totalAmount); // Price
        $this->paypal_class->add_field('amount', $totAmt);
        $this->paypal_class->add_field('payment_gross', $totAmt);
        //$this->paypal_class->add_field('amount', number_format($totAmt,2,'.',''));
        //$this->paypal_class->add_field('amount', 1); // Price
        //echo base_url().'order/success/'.$loginUserId.'/'.$lastFeatureInsertId; die;
        $this->paypal_class->submit_paypal_post();
    }

    /* paypal Payment ends */
    /*  paypal success payment anf email starts */
    public function guidepayment_success()
    {
        $transId = $_REQUEST['txn_id'];
        $Pray_Email = $_REQUEST['payer_email'];
        $payment_gross = $_REQUEST['payment_gross'];
        $price = $this->uri->segment(3);
        $this->data['price'] = $price;
        $currencySymbol = $this->session->userdata('currency_s');
        $bookingId = 'XP' . time();
        $this->data['payment_gross'] = $payment_gross;
        $this->data['bookingId'] = $bookingId;
        $product_id = $this->uri->segment(2);
        $prodcutDetails = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
        $user_id = $prodcutDetails->row()->user_id;
        $dataArr = array('paypal_txn_id' => $transId, 'paypal_email' => $Pray_Email, 'payment_status' => 'paid', 'bookingId' => $bookingId);
        $condition = array('product_id' => $this->uri->segment(2));
        $this->experience_model->update_details(EXPERIENCE_LISTING_PAYMENT, $dataArr, $condition);
        $this->guide_payment_mail($transId);
        //$this->data['exper_list'] = $this->db->where('product_id',$this->uri->segment(2))->get(EXPERIENCE_LISTING_PAYMENT)->row();
        //print_r($this->data['exper_list']);exit;
        //$this->host_payment_mailbyadmin($transId);
        //$this->data['printr']=$_REQUEST;
        //die;
        if ($this->lang->line('Payment Made Successfull, please wait for Approval to list your Product') != '') {
            $message = stripslashes($this->lang->line('Payment Made Successfull, please wait for Approval to list your Experience'));
        } else {
            $message = "Payment Made Successfull, please wait for Approval to list your Experience";
        }
        $this->setErrorMessage('success', $message);
        $this->load->view('site/experience/guide_success', $this->data);
        //redirect('listing/all');
    }

    public function guide_payment_mail($transId)
    {
        /* Mail Function starts */
        $this->data['paymentdetail'] = $this->experience_model->view_payment_details($transId);
        $hostemail = $this->data['paymentdetail']->row()->email;
        $hostname = $this->data['paymentdetail']->row()->firstname;
        $prdname = $this->data['paymentdetail']->row()->prd_name;
        $amount = $this->data['paymentdetail']->row()->hosting_price;
        $created = $this->data['paymentdetail']->row()->created;
        $dateAndTime = $created;
        $cdata = '';
        $ctime = '';
        $newsid = '26';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo'], 'hostname' => $hostname, 'prdname' => $prdname, 'amount' => $amount, 'currency_s' => $this->session->userdata('currency_s'), 'currency_type' => $this->session->userdata('currency_type'));
        extract($adminnewstemplateArr);
        //echo "<pre>"; print_r($adminnewstemplateArr);
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $this->load->library('email');
        for ($i = 1; $i <= 3; $i++) {
            if ($i == 1) {
                $to_host['to_host'] = 1;
                $to_admin['to_admin'] = 0;
                $reg = array_merge($adminnewstemplateArr, $to_host, $to_admin);
                $message = $this->load->view('newsletter/Property Host Payment Success Host' . $newsid . '.php', $reg, TRUE); //Listing pay from host and mail to host
                //echo $message; exit;
                $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $hostemail, 'cc_mail_id' => $template_values ['sender_email'], 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
                $this->email->from($email_values['from_mail_id'], $sender_name);
                $this->email->to($email_values['to_mail_id']);
                $this->email->subject($email_values['subject_message']);
                $this->email->set_mailtype("html");
                $this->email->message($message);
                try {
                    $this->email->send();
                    //echo "success1";
                    $returnStr ['msg'] = 'Success';
                    $returnStr ['success'] = '1';
                } catch (Exception $e) {
                    //echo $e->getMessage();
                }
            } elseif ($i == 2) {
                $newsid = '27';
                $to_host['to_host'] = 0;
                $to_admin['to_admin'] = 1;
                $reg = array_merge($adminnewstemplateArr, $to_host, $to_admin);
                $message1 = $this->load->view('newsletter/Property Host Payment Success Admin' . $newsid . '.php', $reg, TRUE); //Listing pay from host to mail admin
                $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $sender_email, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message1);
                $this->email->from($email_values['from_mail_id'], $sender_name);
                $this->email->to($email_values['to_mail_id']);
                $this->email->subject($email_values['subject_message']);
                $this->email->set_mailtype("html");
                $this->email->message($message1);
                try {
                    $this->email->send();
                    //echo "success2";
                    $returnStr ['msg'] = 'Success';
                    $returnStr ['success'] = '1';
                } catch (Exception $e) {
                    //echo $e->getMessage();
                }
            }
        }
        /* Mail Function ends */
    }


    /*  paypal success payment anf email ends */
    /* Experiernce Listing  Payment  ends */
    /* phone verification starts */
    public function check_phone_verification()
    {
        $mobile_verification_code = $this->input->post('mobile_verification_code');
        $phone_verify_query = 'SELECT * FROM ' . USERS . ' WHERE id=' . $this->checkLogin('U') . ' AND mobile_verification_code="' . $mobile_verification_code . '"';
        $match_row = $this->db->query($phone_verify_query);
        if ($match_row->num_rows() == 1) {
            $this->db->select('*');
            $this->db->from(USERS);
            $this->db->where('id', $this->checkLogin('U'));
            $row = $this->db->get();
            if ($row->num_rows() == 1) {
                $excludeArr = array('mobile_verification_code');
                $dataArr = array('ph_verified' => 'Yes');
                $condition = array('id' => $this->checkLogin('U'));
                $this->experience_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
            } else {
                $excludeArr = array('mobile_verification_code');
                $dataArr = array('id' => $this->checkLogin('U'), 'ph_verified' => 'Yes');
                $condition = array();
                $this->experience_model->commonInsertUpdate(USERS, 'insert', $excludeArr, $dataArr, $condition);
            }
            echo 'success';
            if ($this->lang->line('Phone Number Verified Successfully') != '') {
                $message = stripslashes($this->lang->line('Phone Number Verified Successfully'));
            } else {
                $message = "Phone Number Verified Successfully";
            }
            $this->setErrorMessage('success', $message);
        } else {
            echo 'fail';
        }
    }

    /* phone verification starts */
    /* Experience Delete starts */
    public function delete_property_details()
    {
        //$this->setErrorMessage('success','Review received, will be added after approval');
        if ($this->data['loginCheck'] != '') {
            $product_id = $this->uri->segment(4, 0);
            $this->experience_model->commonDelete(EXPERIENCE, array('experience_id' => $product_id));
            $this->experience_model->commonDelete(EXPERIENCE_PHOTOS, array('product_id' => $product_id));
            $this->experience_model->commonDelete(EXPERIENCE_ADDR, array('experience_id' => $product_id));
            //$this->experience_model->commonDelete(PRODUCT_BOOKING,array('product_id' => $product_id)); //malar commanded
            //$this->experience_model->commonDelete(SCHEDULE,array('id' => $product_id));//malar commanded
            //$this->experience_model->commonDelete(CONTACT,array('Experience_id' => $product_id));
            if ($this->lang->line('Experience Deleted Successfully') != '') {
                $message = stripslashes($this->lang->line('Experience Deleted Successfully'));
            } else {
                $message = "Experience Deleted Successfully";
            }
            $this->setErrorMessage('success', $message);
            redirect(base_url() . 'listing/all');
        } else {
            if ($this->lang->line('User Profile Information Updated successfully') != '') {
                $message = stripslashes($this->lang->line('User Profile Information Updated successfully'));
            } else {
                $message = "User Profile Information Updated successfully";
            }
            $this->setErrorMessage('error', $message);
            redirect(base_url());
        }
    }

    /*  view experience  details starts */
    public function view_experience($seourl)
    {
        if ($this->data['experienceExistCount'] <= 0) {
            $this->setErrorMessage('error', 'Experience Module is Disabled');
            redirect(base_url());
        }
        $this->data['controller'] = $this;
        $this->data['currentUser'] = $this->checkLogin('U') != '' ? $this->checkLogin('U') : '';
        $where1 = array('p.status' => '1', 'p.experience_id' => $seourl);
        $where_or = array('p.status' => '1');
        $where2 = array('p.status' => '1', 'p.experience_id' => $seourl);
        $this->load->model('admin_model');
        $this->data['admin_settings'] = $result = $this->admin_model->getAdminSettings();
        $this->data['productDetails'] = $this->experience_model->view_experience_details_site_one($where1, $where_or, $where2);
       // echo $this->data['productDetails']->row()->type_id;
        $this->data['expe_type'] = $this->experience_model->get_all_details(EXPERIENCE_TYPE, array('id' => $this->data['productDetails']->row()->type_id));
        
        $booked = array('booking_status' => 'Booked');
        $exp_id = $this->data['productDetails']->row()->experience_id;
        $this->data['booked_experience'] = $this->experience_model->get_booked_exp_details($booked, $exp_id);
        if ($this->data['productDetails']->row()->experience_id == '') {
            if ($this->lang->line('Experience details not available') != '') {
                $message = stripslashes($this->lang->line('Experience details not available'));
            } else {
                $message = "Experience details not available";
            }
            $this->setErrorMessage('error', $message);
            redirect(base_url());
        }
        if ($this->data['productDetails']->row()->experience_id != '') {
            $view_count = $this->data['productDetails']->row()->page_view_count + 1;
            $newdata = array('page_view_count' => $view_count);
            $condition = array('experience_id' => $this->data['productDetails']->row()->experience_id);
            $this->experience_model->update_details(EXPERIENCE, $newdata, $condition);
        }
        $this->data['productImages'] = $this->experience_model->get_images($this->data['productDetails']->row()->experience_id);
        $this->data['reviewData'] = $this->experience_model->get_review($this->data['productDetails']->row()->experience_id);
        $this->data['user_reviewData'] = $this->experience_model->get_review($this->data['productDetails']->row()->experience_id, '');
        $id = $this->data['productDetails']->row()->experience_id;
        $this->data['review_avg_res'] = $this->product_model->get_avg_review_experience($id);
        $this->data['reviewData'] = $this->experience_model->get_review_other($this->data['productDetails']->row()->experience_id, '');
        $this->data['reviewTotal'] = $this->experience_model->get_review_tot($this->data['productDetails']->row()->experience_id);
        $product_id = $this->data['productDetails']->row()->experience_id;
        $this->data['product_details'] = $this->experience_model->view_product1($product_id);
        $this->data['RatePackage'] = '';
        $this->data['heading'] = $this->data['productDetails']->row()->meta_title;
        if ($this->data['productDetails']->row()->meta_title != '') {
            $this->data['meta_title'] = $this->data['productDetails']->row()->meta_title;
        }
        if ($this->data['productDetails']->row()->meta_keyword != '') {
            $this->data['meta_keyword'] = $this->data['productDetails']->row()->meta_keyword;
        }
        if ($this->data['productDetails']->row()->meta_description != '') {
            $this->data['meta_description'] = $this->data['productDetails']->row()->meta_description;
        }
        
        $wishlists = $this->experience_model->get_all_details(LISTS_DETAILS, array('user_id' => $this->checkLogin('U')));
        $newArr = array();
        foreach ($wishlists->result() as $wish) {
            $newArr = array_merge($newArr, explode(',', $wish->experience_id));
        }
        
        $this->data ['newArr'] = $newArr;
        $this->data['ChkWishlist'] = '0';
        if ($this->checkLogin('U') > 0) {
            $this->data['getWishList'] = $this->experience_model->ChkWishlistProduct($this->data['productDetails']->row()->experience_id, $this->checkLogin('U'));
            $this->data['ChkWishlist'] = $this->data['getWishList']->num_rows();
        }
        $curDate = date('Y-m-d');
        $this->data['DistanceQryArr'] = $this->experience_model->view_product_details_distance_list($this->data['productDetails']->row()->latitude, $this->data['productDetails']->row()->longitude, ' p.experience_id <> ' . $this->data['productDetails']->row()->experience_id . ' AND d.from_date > "'.$curDate.'" and  p.status="1" AND EXISTS ( select c.id FROM fc_experience_dates c where c.status="0" and c.experience_id=p.experience_id ) group by p.experience_id order by p.experience_id  DESC limit 0,8');
        $condition = array('status' => '1', 'experience_id' => $this->data['productDetails']->row()->experience_id);
        $this->data['kit_content'] = $this->experience_model->get_all_details(EXPERIENCE_GUIDE_PROVIDES, $condition);
        if ($this->data['productDetails']->row()->language_list != '') {
            $this->data['language_list'] = $this->experience_model->ExecuteQuery("select language_name from " . LANGUAGES_KNOWN . " where language_code in (" . $this->data['productDetails']->row()->language_list . ") ");
        }
        $this->data['datesList'] = $this->experience_model->getAvailableDates($product_id, date('Y-m-d'));
        if ($this->data['datesList']->num_rows() > 0) {
            foreach ($this->data['datesList']->result() as $dates) {
                $dateId = $dates->id;
                $this->data['datesSchedule'][$dateId] = $this->experience_model->getDateSchedule($dateId);
            }
        }
        $newArr = array();
        $wishlists = $this->experience_model->get_all_details(EXPERIENCE_WISHLIST, array('user_id' => $this->checkLogin('U')));
        if ($wishlists->num_rows() > 0) {
            foreach ($wishlists->result() as $wish) {
                $newArr = array_merge($newArr, explode(',', $wish->product_id));
            }
            $this->data ['newArr'] = $newArr;
        }
        
        $exp_details = $this->data['productDetails']->row();
        $exp_cat_id = $exp_details->type_id;
        if ($exp_cat_id != '') {
            $query_run = "p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city,ed.from_date, (select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.product_id= p.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . EXPERIENCE_REVIEW . " as Rw where Rw.product_id= p.experience_id and Rw.status='Active') as avg_val ";
            $query_run = $this->db->select($query_run, false);//false prevents the ``
            $this->db->from(EXPERIENCE . ' as p');
            //$this->db->from(EXPERIENCE_REVIEW.' as R');
            $this->db->join(EXPERIENCE_TYPE . ' as extyp', 'extyp.id=p.type_id');
            $this->db->join(EXPERIENCE_ADDR . ' as expAdd', 'expAdd.experience_id=p.experience_id', "LEFT");
            $this->db->join(USERS . ' as u', "u.id=p.user_id");
            $this->db->join(EXPERIENCE_PHOTOS . ' as rp', "rp.product_id=p.experience_id", "LEFT");
            $this->db->join(EXPERIENCE_DATES . ' as ed', "ed.experience_id=p.experience_id", "LEFT");
            $this->db->order_by('p.experience_id', 'desc');
            $this->db->group_by('p.experience_id');
            $this->db->where('p.status', '1');
            $this->db->where('extyp.status', 'Active');
            $this->db->where('ed.from_date >', date('Y-m-d'));
            $this->db->where("p.experience_id != ", $this->data['productDetails']->row()->experience_id);
            $this->db->where(array('p.type_id' => $exp_cat_id));
            //$this->db->where(array('R.product_id'=>$this->data['productDetails']->row()->experience_id));
            $this->data['ExperienceCatBasedList'] = $this->db->get();
            //echo $this->db->last_query();
        }
        /**For Similar Listing Review**/
        foreach ($this->data['ExperienceCatBasedList']->result() as $forSimilarExp) {
            $exp_id = $forSimilarExp->experience_id;
            $this->data['user_reviewData_similar'][$exp_id] = $this->experience_model->get_review_similar($exp_id, '');
        }
        /*
        echo '<pre>';
        print_r($this->data['productDetails']->row());
        echo '</pre>';
        */
        $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="guest-booking" AND status="Active"';
        $this->data['service_tax'] = $this->product_model->ExecuteQuery($service_tax_query);
        $this->data['controller_exp'] = $this;
        $this->load->view('site/experience/view_experience', $this->data);
    }



    /*  view experience  details ends */
    /* contact host in experience detailed view page */
    public function add_conctact_msg()
    {
        $redirect = $this->input->post('redirect');
        $excludeArr = array('redirect', 'discussion', 'experience_title');
        $now = time();
        $dataArr = array('productId' => $this->input->post('rental_id'), 'senderId' => $this->checkLogin('U'), 'receiverId' => $this->input->post('receiver_id'), 'subject' => 'Contact Message on :' . $this->input->post('experience_title'), 'message' => $this->input->post('message'));
        $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $dataArr);
        $dataArr = array('convId' => $now);
        $condition = array();
        $this->product_model->commonInsertUpdate(EXPERIENCE_DISCUSSION, 'insert', $excludeArr, $dataArr, $condition);
        if ($this->lang->line('Your message was successfully sent') != '') {
            $message = stripslashes($this->lang->line('Your message was successfully sent'));
        } else {
            $message = "Your message was successfully sent";
        }
        $this->setErrorMessage('success', $message);
        redirect($redirect);
    }

    /* Experience booking Enquiry starts */
    public function experience_booking_enquiry($date_id)
    {
        //echo 'here'.$date_id; exit;
        $this->db->select('d.id,d.experience_id ,d.from_date,d.to_date,exp.user_id,exp.date_count,exp.cancel_percentage,exp.security_deposit,exp.currency,exp.price');
        $this->db->from(EXPERIENCE_DATES . ' as d');
        $this->db->join(EXPERIENCE . ' as exp', "exp.experience_id=d.experience_id", "LEFT");
        $this->db->where('d.id', $date_id);
        $this->db->where('d.status ', '0');
        $this->db->where('exp.status ', '1');
        $this->db->order_by('d.id');
        $date_details = $this->db->get();
        $NoofGuest = '1';
        if ($date_details->num_rows() > 0) {
            $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_booking" AND status="Active"';
            $service_tax = $this->product_model->ExecuteQuery($service_tax_query);
            if ($service_tax->num_rows() == 0) {
                $this->data['taxValue'] = '0.00';
            } else {
                $this->data['commissionType'] = $service_tax->row()->promotion_type;
                $this->data['commissionValue'] = $service_tax->row()->commission_percentage;
                
                /**Start - Convert Service Fee Into Experience Currency **/
                
                    $currencyCodeExp = $date_details->row()->currency; //Exp Currency
                    $DefaultCurrency = $this->db->where('default_currency', 'Yes')->get(CURRENCY)->row();
                    $DefaultCur=$DefaultCurrency->currency_type; //AdminCurrency
                if ($service_tax->row()->promotion_type == 'flat') {
                    
                    if ($DefaultCur!=$currencyCodeExp){
                        $serviceFee = convertCurrency($DefaultCur,$currencyCodeExp,$service_tax->row()->commission_percentage);
                    }else{
                        $serviceFee =$service_tax->row()->commission_percentage;
                    }
                } else { //calculate percentage
                    $serviceFee = ($service_tax->row()->commission_percentage) / 100 * $date_details->row()->price;   
                }
                /**Start - Convert Service Fee Into Experience Currency **/
            }
          
            
            $totalAmt = $date_details->row()->price + $serviceFee + $date_details->row()->security_deposit;
            $admin = $this->user_model->get_all_details(ADMIN, array('admin_type' => 'super'));
            $data = $admin->row();
            $admin_currencyCode = trim($data->admin_currencyCode);
            $seller_currencyCode = $date_details->row()->currency;
            $user_currencyCode = trim($this->session->userdata('currency_type'));
            $amount = 1;
            $currencyPerUnitSeller = 1;
            $unitPerCurrencyUser = 1;
            $unitPerCurrencySeller = 1;
            if ($admin_currencyCode != $seller_currencyCode) {
                $currencyPerUnitSeller = convertCurrency($admin_currencyCode, $seller_currencyCode, $amount);
            }
            if ($seller_currencyCode != $admin_currencyCode) {
                $unitPerCurrencySeller = convertCurrency($seller_currencyCode, $admin_currencyCode, $amount);
            }
            if ($user_currencyCode != $seller_currencyCode) {
                $unitPerCurrencyUser = convertCurrency($user_currencyCode, $seller_currencyCode, $amount);
            }
            $last_cron_id = $this->db->select('*')->from('fc_currency_cron')->order_by('curren_id','desc')->limit(1)->get();
            //echo $seller_currencyCode.'|'.$this->session->userdata('currency_type'); exit;
            
            if ($seller_currencyCode != $this->session->userdata('currency_type')) {
                $insSubTotal = currency_conversion($seller_currencyCode,$this->session->userdata('currency_type'),$date_details->row()->price);
                $serviceFee = currency_conversion($seller_currencyCode,$this->session->userdata('currency_type'),$serviceFee);
                $insSecDeposit = currency_conversion($seller_currencyCode,$this->session->userdata('currency_type'),$date_details->row()->security_deposit);
                $totalAmt = $insSubTotal+$serviceFee+$insSecDeposit;//currency_conversion($seller_currencyCode,$this->session->userdata('currency_type'),$totalAmt);
                
            }
            else
            {
                $insSubTotal = $date_details->row()->price;
                $insSecDeposit = $date_details->row()->security_deposit;
            }
            
            //$convSubTotal = 
            $dataArr = array('checkin' => date('Y-m-d H:i:s', strtotime($date_details->row()->from_date)), 
                             'checkout' => date('Y-m-d H:i:s', strtotime($date_details->row()->to_date)), 
                             'numofdates' => $date_details->row()->date_count, 
                             'user_id' => $this->checkLogin('U'), 
                             'renter_id' => $date_details->row()->user_id,
                             'exp_price'=>$date_details->row()->price,
                             'subTotal' => $insSubTotal, 
                             'serviceFee' => $serviceFee, 
                             'totalAmt' => $totalAmt, 
                             'NoofGuest' => $NoofGuest, 
                             'prd_id' => $date_details->row()->experience_id, 
                             'date_id' => $date_details->row()->id, 
                             'currencycode' => $date_details->row()->currency, 
                             'secDeposit' => $insSecDeposit, 
                             'booking_status' => 'Enquiry', 
                             'user_currencyCode' => $user_currencyCode, 
                             'currencyPerUnitSeller' => $currencyPerUnitSeller, 
                             'unitPerCurrencyUser' => $unitPerCurrencyUser, 
                             'exp_cancel_percentage' => $date_details->row()->cancel_percentage,
                             'currency_cron_id'=>$last_cron_id->row()->curren_id);
            //print_r($dataArr);exit;
            $this->experience_model->simple_insert(EXPERIENCE_ENQUIRY, $dataArr);
            $insertid = $this->db->insert_id();
            $val = 10 * $insertid + 8;
            $val = 1500000 + $val;
            $bookingno = "XP" . $val;
            $newdata = array('Bookingno' => $bookingno);
            $condition = array('id' => $insertid);
            $this->experience_model->update_details(EXPERIENCE_ENQUIRY, $newdata, $condition);
            $this->session->set_userdata('experienceEnquiryId', $insertid);
            redirect(base_url() . 'experience_booking/' . $date_details->row()->experience_id);
        } else {
            $this->setErrorMessage('error', 'Experience Not Listed.');
            redirect(base_url());
        }
    }

    /* Booking Enquiry View detials and confirmation page  */
    public function experience_guest_booking()
    {
        $Rental_id = $this->uri->segment(2, 0);
        $dataArr = array('booking_status' => 'Pending');
        $this->data ['productList'] = $this->experience_model->view_product_details_booking(' where p.experience_id="' . $Rental_id . '" and rq.id="' . $this->session->userdata('experienceEnquiryId') . '" group by p.experience_id order by p.added_date desc limit 0,1');
        $this->data['experience_DateDetails'] = $this->experience_model->get_all_details(EXPERIENCE_DATES, array('id' => $this->data ['productList']->row()->date_id));
        $this->data ['countryList'] = $this->product_model->get_country_list();
        $this->data ['BookingUserDetails'] = $this->experience_model->view_user_details_booking(' where p.experience_id ="' . $Rental_id . '" and rq.id="' . $this->session->userdata('EnquiryId') . '" group by p.experience_id order by p.added_date desc limit 0,1');
        $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE commission_type="experience_booking" AND status="Active"';
        $this->data['service_tax'] = $this->experience_model->ExecuteQuery($service_tax_query);
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
        $this->load->view('site/experience/enquiry_confirmation', $this->data);
    }

    public function experience_bookingConfirm($value = '')
    {
        //print_r($this->input->post()); exit;Array ( [Bookingno] => XP1500448 [email_id] => [user_id] => [message] => [bookbtn] => Book Now )
        $bookingDetails = $this->user_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $this->input->post('Bookingno')));
        $message = ($this->input->post('message') != '') ? $this->input->post('message') : 'New Booking available on your experience.';
        $dataArr = array('productId' => $bookingDetails->row()->prd_id, 'bookingNo' => $bookingDetails->row()->Bookingno, 'senderId' => $bookingDetails->row()->user_id, 'receiverId' => $bookingDetails->row()->renter_id, 'subject' => 'Booking Request : ' . $bookingDetails->row()->Bookingno, 'message' => $message);
        $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $dataArr);
        $this->user_model->update_details(EXPERIENCE_ENQUIRY, array('booking_status' => 'Pending', 'caltophone' => $this->input->post('phone_no')), array('user_id' => $this->checkLogin('U'), 'id' => $this->session->userdata('experienceEnquiryId')));
        /* Mail function start */
        $this->data['bookingmail'] = $this->experience_model->getbookeduser_detail($bookingDetails->row()->id);
        /*print_r($this->data['bookingmail']->row()); exit;stdClass Object ( [noofdates] => 2 [checkin] => 2018-05-03 00:00:00 [checkout] => 2018-05-04 00:00:00 [renter_id] => 16 [unitPerCurrencyUser] => 3.51 [user_currencycode] => USD [price] => 100.00 [email] => nagoor@pofitec.com [name] => Nagoor [productname] => Experience BRL [prd_id] => 26 )*/
        $pdt_price = $this->data['bookingmail']->row()->subTotal;
        $pdt_price = $this->data['bookingmail']->row()->price;
        $security_deposit = $this->data['bookingmail']->row()->security_deposit;
        /*COMMISSION*/
        $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_booking" AND status="Active"';
        $service_tax = $this->product_model->ExecuteQuery($service_tax_query);
        $serviceFee = ($service_tax->row()->commission_percentage) / 100 * $pdt_price;  
        /*EOF COMMISSION */
        $price = $pdt_price+$security_deposit+$serviceFee;
        $checkindate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkin));
        $checkoutdate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkout));
        $newsid = '49';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $hostuserId = $this->data['bookingmail']->row()->user_id;
        $hostemail = $this->db->select('email')->from('fc_users')->where('id = ', $hostuserId)->get()->row()->email;
        $hostphone = $this->db->select('phone_no')->from('fc_users')->where('id = ', $hostuserId)->get()->row()->phone_no;
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $hostemail, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
        
        $CurrencySymbol = $this->db->select('*')->from('fc_currency')->where('currency_type = ', $this->data['bookingmail']->row()->currency)->get()->row()->currency_symbols;
        $Booking_info = array('logo'=>$this->data['logo'],'travellername' => $this->data['bookingmail']->row()->name, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name, 'currencySymbol' => $CurrencySymbol,'productname'=>$this->data['bookingmail']->row()->productname);
        //print_r($Booking_info);
        //exit;
        $message =   $this->load->view('newsletter/ExperienceBookInfo' . $newsid . '.php', $Booking_info, TRUE);
        
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->set_mailtype("html");
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        /* Mail function end */
        /*==========Experience booking SMS to Host=============*/ 
                if ($this->config->item('twilio_status') == '1') {

                        require_once('twilio/Services/Twilio.php');
                        $account_sid = $this->config->item('twilio_account_sid');
                        $auth_token = $this->config->item('twilio_account_token');
                        $from = $this->config->item('twilio_phone_number');
                        try {
                            $to = $hostphone;
                            $client = new Services_Twilio($account_sid, $auth_token);
                            $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Experience (".$this->data['bookingmail']->row()->productname.") is Booked by User."));
                            //echo 'success';
                        } catch (Services_Twilio_RestException $e) {
                            //echo "Authentication Failed..!";
                        }
                }
        /*===========Experience booking SMS to Host=============*/ 
        /* Traveller(Guest) Mail Function Start */
        $id = $bookingDetails->row()->id;
        $this->data['bookingmail'] = $this->experience_model->getbookeduser_detail($id);
        $price = $this->data['bookingmail']->row()->price;
        $checkindate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkin));
        $checkoutdate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkout));
        $this->data['hostdetail'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['bookingmail']->row()->renter_id));
        $hostname = $this->data['hostdetail']->row()->user_name;
        $hostemail = $this->data['hostdetail']->row()->email;
        $to = $this->data['bookingmail']->row()->email;
        $price = $this->data['bookingmail']->row()->price;
        $prd_id = $this->data['bookingmail']->row()->prd_id;
        $this->data['productimage'] = $this->experience_model->getproductimage($prd_id);
        $newsid = '20';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['bookingmail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $totalAmt = $this->data['bookingmail']->row()->totalAmt;
        $CurrencySymbol = $this->db->select('*')->from('fc_currency')->where('currency_type = ', $this->data['bookingmail']->row()->user_currencycode)->get()->row()->currency_symbols;
       $traveller_info = array('logo'=>$this->data['logo'],'prd_id' => $this->data['bookingmail']->row()->prd_id, 'travellername' => $this->data['bookingmail']->row()->name, 'productname' => $this->data['bookingmail']->row()->productname, 'prd_image' => $this->data['productimage']->row()->product_image, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $totalAmt, 'email_title' => $sender_name, 'currencySymbol' => $CurrencySymbol,'hostname'=>$hostname);
        
        $message = $this->load->view('newsletter/TravellerInfo' . $newsid . '.php', $traveller_info, TRUE);
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->set_mailtype("html");
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        $dataArr = array('productId' => $bookingDetails->row()->prd_id, 'senderId' => $bookingDetails->row()->renter_id, 'receiverId' => $bookingDetails->row()->user_id, 'bookingNo' => $bookingDetails->row()->Bookingno, 'subject' => 'Booking Request : ' . $bookingDetails->row()->Bookingno, 'message' => 'Accepted', 'point' => '1', 'status' => 'Accept');
        $this->db->insert(EXPERIENCE_MED_MSG, $dataArr);
        $this->db->where('bookingNo', $bookingDetails->row()->Bookingno);
        $this->db->update(EXPERIENCE_MED_MSG, array('status' => 'Accept'));
        $newdata = array('approval' => 'Accept');
        $condition = array('Bookingno' => $bookingDetails->row()->Bookingno);
        $this->user_model->update_details(EXPERIENCE_ENQUIRY, $newdata, $condition);
        $bookingDetails = $this->user_model->get_all_details(EXPERIENCE_ENQUIRY, $condition);
        $enqId = $bookingDetails->row()->id;
        redirect("site/experience/confirmbooking/" . $enqId);
    }

    /*  experience instant booking starts */
    public function experience_booking_instant($date_id)
    {
        $this->db->select('d.id,d.experience_id ,d.from_date,d.to_date,exp.user_id,exp.date_count,exp.security_deposit,exp.currency,exp.price');
        $this->db->from(EXPERIENCE_DATES . ' as d');
        $this->db->join(EXPERIENCE . ' as exp', "exp.experience_id=d.experience_id", "LEFT");
        $this->db->where('d.id', $date_id);
        $this->db->where('d.status ', '1');
        $this->db->where('exp.status ', '1');
        $this->db->order_by('d.id');
        $date_details = $this->db->get();
        $NoofGuest = '1';
        if ($date_details->num_rows() > 0) {
            $val = 10 * $insertid + 8;
            $val = 1500000 + $val;
            $bookingno = "XP" . $val;
            $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_booking" AND status="Active"';
            $service_tax = $this->product_model->ExecuteQuery($service_tax_query);
            if ($service_tax->num_rows() == 0) {
                $this->data['taxValue'] = '0.00';
            } else {
                $this->data['commissionType'] = $service_tax->row()->promotion_type;
                $this->data['commissionValue'] = $service_tax->row()->commission_percentage;
                if ($service_tax->row()->promotion_type == 'flat') {
                    $currencyCode = $date_details->row()->currency;
                    $currInto_result = $this->db->where('currency_type', $currencyCode)->get(CURRENCY)->row();
                    $rate = $service_tax->row()->commission_percentage * $currInto_result->currency_rate;
                    $this->data['taxValue'] = $rate;
                } else {
                    $finalTax = ($service_tax->row()->commission_percentage) / 100;
                    $this->data['taxValue'] = $finalTax;
                }
            }
            $serviceFee = $date_details->row()->price * $this->data['taxValue'];
            $totalAmt = $date_details->row()->price + $serviceFee;
            $dataArr = array('checkin' => date('Y-m-d H:i:s', strtotime($date_details->row()->from_date)), 'checkout' => date('Y-m-d H:i:s', strtotime($date_details->row()->to_date)), //'Enquiry'         =>  '0',
                'numofdates' => $date_details->row()->date_count, //'caltophone'        =>  '0',
                'user_id' => $this->checkLogin('U'), 'renter_id' => $date_details->row()->user_id, 'subTotal' => $date_details->row()->price, 'serviceFee' => $serviceFee, 'totalAmt' => $totalAmt, 'NoofGuest' => $NoofGuest, 'prd_id' => $date_details->row()->experience_id, 'date_id' => $date_details->row()->id, 'currencycode' => $date_details->row()->currency, 'secDeposit' => $date_details->row()->security_deposit, //'walletAmount'   =>  '0',
                'booking_status' => 'Pending', 'Bookingno' => $bookingno);
            $this->experience_model->simple_insert(EXPERIENCE_ENQUIRY, $dataArr);
            $insertid = $this->db->insert_id();
            $this->session->set_userdata('experienceEnquiryId', $insertid);
            $this->experience_instantBookingconfirm();
        } else {
            $this->setErrorMessage('error', 'Experience Not Listed.');
            redirect(base_url());
        }
    }

    public function experience_instantBookingconfirm()
    {
        $bookingDetails = $this->user_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $this->input->post('Bookingno')));
        $message = ($this->input->post('message') != '') ? $this->input->post('message') : 'New Booking available on your experience.';
        $dataArr = array('productId' => $bookingDetails->row()->prd_id, 'bookingNo' => $bookingDetails->row()->Bookingno, 'senderId' => $bookingDetails->row()->user_id, 'receiverId' => $bookingDetails->row()->renter_id, 'subject' => 'Booking Request : ' . $bookingDetails->row()->Bookingno, 'message' => $message);
        $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $dataArr);
        /* Mail function start */
        $this->data['bookingmail'] = $this->experience_model->getbookeduser_detail($bookingDetails->row()->id);
        $price = $this->data['bookingmail']->row()->price;
        $checkindate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkin));
        $checkoutdate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkout));
        $newsid = '16';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $hostemail, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
        $Booking_info = array('travellername' => $this->data['bookingmail']->row()->name, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name, 'currencySymbol' => $this->session->userdata('currency_s'));
        $message = $this->load->view('newsletter/BookInfo' . $newsid . '.php', $Booking_info, $dataArr, TRUE);
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->set_mailtype("html");
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        /* Mail function end */
        /* Traveller Mail Function Start */
        $id = $this->session->userdata('EnquiryId');
        $this->data['bookingmail'] = $this->user_model->getbookeduser_detail($id);
        $price = $this->data['bookingmail']->row()->price;
        $checkindate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkin));
        $checkoutdate = date('d-M-Y', strtotime($this->data['bookingmail']->row()->checkout));
        $this->data['hostdetail'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['bookingmail']->row()->renter_id));
        $hostname = $this->data['hostdetail']->row->email;
        $hostemail = $this->data['hostdetail']->row->user_name;
        $to = $this->data['bookingmail']->row()->email;
        $price = $this->data['bookingmail']->row()->price;
        $prd_id = $this->data['bookingmail']->row()->prd_id;
        $this->data['productimage'] = $this->experience_model->getproductimage($prd_id);
        $newsid = '20';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['bookingmail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $traveller_info = array('logo'=>$this->data['logo'],'prd_id' => $this->data['bookingmail']->row()->prd_id, 'travellername' => $this->data['bookingmail']->row()->name, 'productname' => $this->data['bookingmail']->row()->productname, 'prd_image' => $this->data['productimage']->row()->product_image, 'checkindate' => $checkindate, 'checkoutdate' => $checkoutdate, 'price' => $this->data['bookingmail']->row()->price, 'totalprice' => $price, 'email_title' => $sender_name, 'currencySymbol' => $this->session->userdata('currency_s'));
        $message = $this->load->view('newsletter/TravellerInfo' . $newsid . '.php', $traveller_info, $dataArr, TRUE);
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->set_mailtype("html");
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        /* Traveller Mail Function End */
        $dataArr = array('productId' => $bookingDetails->row()->prd_id, 'senderId' => $bookingDetails->row()->renter_id, 'receiverId' => $bookingDetails->row()->user_id, 'bookingNo' => $bookingDetails->row()->Bookingno, 'subject' => 'Booking Request : ' . $bookingDetails->row()->Bookingno, 'message' => 'Accepted', 'point' => '1', 'status' => 'Accept');
        $this->db->insert(EXPERIENCE_MED_MSG, $dataArr);
        $this->db->where('bookingNo', $bookingDetails->row()->Bookingno);
        $this->db->update(EXPERIENCE_MED_MSG, array('status' => 'Accept'));
        $newdata = array('approval' => 'Accept');
        $condition = array('Bookingno' => $bookingDetails->row()->Bookingno);
        $this->user_model->update_details(EXPERIENCE_ENQUIRY, $newdata, $condition);
        $bookingDetails = $this->user_model->get_all_details(EXPERIENCE_ENQUIRY, $condition);
        $enqId = $bookingDetails->row()->id;
        redirect("site/experience/confirmbooking/" . $enqId);
    }

    public function confirmbooking()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $id = $this->uri->segment(4);
            $this->data['datavalues'] = $this->user_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $id));
            if ($this->data['datavalues']->row()->booking_status == 'Booked' || $this->data['datavalues']->row()->booking_status == 'Enquiry' || $this->data['datavalues']->row()->approval != 'Accept') {
                redirect(base_url() . 'my_experience/upcoming');
            }
            $user = $this->data['datavalues']->row_array();
            $refno = $this->data['datavalues']->row()->Bookingno;
            $Rental_id = $this->data['datavalues']->row()->prd_id;
            $date_id = $this->data['datavalues']->row()->date_id;
            $this->data['experience_DateDetails'] = $this->user_model->get_all_details(EXPERIENCE_DATES, array('id' => $date_id));
            $this->data['pay'] = $this->experience_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('user_id' => $user['user_id']));
            $this->data['userDetails'] = $this->experience_model->get_all_details(USERS, array('id' => $user['user_id']));
            $this->data ['productList'] = $this->experience_model->view_product_details_booking(' where rq.Bookingno="' . $refno . '"  group by p.experience_id order by p.added_date desc limit 0,1');
            
            //echo $this->db->last_query();die;
            
            $this->data ['countryList'] = $this->product_model->get_country_list();
            $this->data ['BookingUserDetails'] = $this->experience_model->view_user_details_booking(' where p.experience_id="' . $Rental_id . '" and rq.id="' . $this->session->userdata('EnquiryId') . '" group by p.experience_id order by p.added_date desc limit 0,1');
            
            $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE commission_type="Guest Booking" AND status="Active"';
            $this->data['service_tax'] = $this->experience_model->ExecuteQuery($service_tax_query);
            if ($this->data ['productList']->row()->meta_title != '') {
                $this->data ['meta_title'] = $this->data ['productList']->row()->meta_title;
            }
            if ($this->data ['productList']->row()->meta_keyword != '') {
                $this->data ['meta_keyword'] = $this->data ['productList']->row()->meta_keyword;
            }
            if ($this->data ['productList']->row()->meta_description != '') {
                $this->data ['meta_description'] = $this->data ['productList']->row()->meta_description;
            }
            $this->data['paypal_status'] = $this->experience_model->get_all_details(PAYMENT_GATEWAY, array('gateway_name' => 'Paypal IPN'));
            $this->data['creditCard_status'] = $this->experience_model->get_all_details(PAYMENT_GATEWAY, array('gateway_name' => 'Credit Card'));
            $tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE id=4';
            $this->data ['tax'] = $this->experience_model->ExecuteQuery($tax_query);
            $uniid = time() . "-" . $refno;
            $this->data['RefNo'] = $uniid;
            $source = "DbQhpCuQpPM07244" . $uniid . "100MYR";
            $val = sha1($source);
            $rval = $this->hex2bin($val);
            $this->data['signature'] = base64_encode($rval);
            /* user wallet  */
            $userId = $this->checkLogin('U');
            $selRefferalAmount_q = "select referalAmount,referalAmount_currency from " . USERS . " where id ='" . $userId . "' ";
            $this->data['userWallet'] = $this->experience_model->ExecuteQuery($selRefferalAmount_q);
            /* user wallet ends */
            $this->load->view('site/experience/confirmpayment', $this->data);
        }
    }


    /*  experience instant booking ends */
    /*  experience invoice starts */
    public function invoice()
    {
        header('Content-Type: text/html; charset="utf-8"', true);
        $id = $this->uri->segment(4);
        $this->data['Invoicetmp'] = $Invoicetmp = $this->product_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $id));
        $eId = $Invoicetmp->row()->id;
        $unitprice = $Invoicetmp->row()->unitPerCurrencyUser;
        $user_buked_currency = $Invoicetmp->row()->user_currencycode;
        $this->data['transactionid'] = $transactionid = $this->product_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('EnquiryId' => $eId));
        $admin_email = $this->product_model->get_all_details(ADMIN, array())->row()->email;
        $this->data['transid'] = $Invoicetmp->row()->Bookingno;
        $this->data['productvalue'] = $productvalue = $this->product_model->get_all_details(EXPERIENCE, array('experience_id' => $Invoicetmp->row()->prd_id));
        if ($Invoicetmp->row()->secDeposit != 0) {
            $securityDepositeTemp = $Invoicetmp->row()->secDeposit;
        } else
            $securityDepositeTemp = '0.00';
        $this->data['productaddress'] = $productaddress = $this->product_model->get_all_details(EXPERIENCE_ADDR, array('experience_id' => $Invoicetmp->row()->prd_id));
        $product_id = $Invoicetmp->row()->prd_id;
        $this->data['checkindate'] = date('d-M-Y', strtotime($Invoicetmp->row()->checkin));
        $this->data['checkoutdate'] = date('d-M-Y', strtotime($Invoicetmp->row()->checkout));
        $this->data['TotalAmt_temp'] = $TotalAmt_temp = ($Invoicetmp->row()->totalAmt) - ($Invoicetmp->row()->serviceFee);
        $currencycode = $Invoicetmp->row()->currencycode;
        $choosedCurrency = $Invoicetmp->row()->user_currencycode;

        $getCurrencySymbol=$this->product_model->get_selected_fields_records('currency_symbols',CURRENCY," where currency_type='" . $choosedCurrency."'");
        $this->data['choosedCurrency']=$getCurrencySymbol->row()->currency_symbols;
        //SECURITY DEPOSIT
        if ($user_buked_currency != $this->session->userdata('currency_type')) {
            /*if (!empty($unitprice)) {
                $this->data['securityDeposite'] = $securityDeposite = customised_currency_conversion($unitprice, $securityDepositeTemp);
            } else {
                $this->data['securityDeposite'] = $securityDeposite = convertCurrency($productvalue->row()->currency, $this->session->userdata('currency_type'), $securityDepositeTemp);
            }*/
            $securityDeposite = number_format(currency_conversion($user_buked_currency, $this->session->userdata('currency_type'), $securityDepositeTemp,$Invoicetmp->row()->currency_cron_id),2);
        } else {
            $securityDeposite = number_format($securityDepositeTemp,2);
        }
        $this->data['securityDeposite'] = $securityDeposite;
        
        //SUB TOTAL
        if ($user_buked_currency != $this->session->userdata('currency_type')) {
            /*if (!empty($unitprice)) {
                $this->data['TotalwithoutService'] = $TotalwithoutService = customised_currency_conversion($unitprice, $Invoicetmp->row()->subTotal);
            } else {
                $this->data['TotalwithoutService'] = $TotalwithoutService = convertCurrency($currencycode, $this->session->userdata('currency_type'), $Invoicetmp->row()->subTotal);
            }*/
            $TotalwithoutService = currency_conversion($user_buked_currency, $this->session->userdata('currency_type'), $Invoicetmp->row()->subTotal,$Invoicetmp->row()->currency_cron_id);
        } else {
            $TotalwithoutService = $Invoicetmp->row()->subTotal;
        }
        $this->data['TotalwithoutService'] = number_format($TotalwithoutService,2);
        
        $to = '';
        $service = $this->user_model->get_all_details(COMMISSION, array('id' => 2, 'status' => 'Active'));
        
        //SERVICE FEE
        if ($user_buked_currency != $this->session->userdata('currency_type')) {
            /*if (!empty($unitprice)) {
                $this->data['servicefee'] = $servicefee = customised_currency_conversion($unitprice, $Invoicetmp->row()->serviceFee);
            } else {
                $this->data['servicefee'] = $servicefee = convertCurrency($currencycode, $this->session->userdata('currency_type'), $Invoicetmp->row()->serviceFee);
            }*/
            $servicefee = currency_conversion($user_buked_currency, $this->session->userdata('currency_type'), $Invoicetmp->row()->serviceFee,$Invoicetmp->row()->currency_cron_id);
        } else {
            $servicefee = $Invoicetmp->row()->serviceFee;
        }
        $this->data['servicefee']=number_format($servicefee,2);
        
        
        //$this->data['TotalAmt'] = $TotalwithoutService + $servicefee + $securityDeposite;
        if ($user_buked_currency == $this->session->userdata('currency_type')) {
            $this->data['TotalAmt'] = number_format($Invoicetmp->row()->totalAmt,2);
        } else {
            $price = currency_conversion($user_buked_currency, $this->session->userdata('currency_type'), $Invoicetmp->row()->totalAmt,$Invoicetmp->row()->currency_cron_id);
            $this->data['TotalAmt'] = number_format($price, 2);
        }
        
        
        $this->data['gtotalAmt'] = number_format($this->pastDateCurrency($product_id, $Invoicetmp->row()->dateAdded, $productvalue->row()->price), 2);
        if ($this->lang->line('night') != '') {
            $this->data['night'] = stripslashes($this->lang->line('night'));
        } else {
            $this->data['night'] = "Night";
        }
        if ($this->lang->line('Nights') != '') {
            $this->data['Nights'] = stripslashes($this->lang->line('Nights'));
        } else {
            $this->data['Nights'] = "Nights";
        }
        if ($this->lang->line('Guest') != '') {
            $this->data['guest'] = stripslashes($this->lang->line('Guest'));
        } else {
            $this->data['guest'] = "Guest";
        }
        if ($this->lang->line('guest') != '') {
            $this->data['Guests'] = stripslashes($this->lang->line('guest'));
        } else {
            $this->data['Guests'] = "Guests";
        }
        $this->data['Night'] = ($Invoicetmp->row()->numofdates == 1) ? $this->data['night'] : $this->data['Nights'];
        $this->data['Guest'] = ($Invoicetmp->row()->NoofGuest == 1) ? $this->data['guest'] : $this->data['Guests'];
        $this->data['houserule'] = ($productvalue->row()->house_rules != '') ? $productvalue->row()->house_rules : 'None';
        if ($this->lang->line('Receipt') != '') {
            $this->data['Receipt'] = stripslashes($this->lang->line('Receipt'));
        } else {
            $this->data['Receipt'] = "Receipt";
        }
        if ($this->lang->line('Booking No') != '') {
            $this->data['Booking_No'] = stripslashes($this->lang->line('Booking No'));
        } else {
            $this->data['Booking_No'] = "Booking No";
        }
        if ($this->lang->line('ExperienceName') != '') {
            $this->data['Property_Name'] = stripslashes($this->lang->line('ExperienceName'));
        } else {
            $this->data['Property_Name'] = "Experience Name";
        }
        if ($this->lang->line('Address') != '') {
            $this->data['Address'] = stripslashes($this->lang->line('Address'));
        } else {
            $this->data['Address'] = "Address";
        }
        if ($this->lang->line('check_in') != '') {
            $this->data['check_in'] = stripslashes($this->lang->line('check_in'));
        } else {
            $this->data['check_in'] = "check_in";
        }
        if ($this->lang->line('check_out') != '') {
            $this->data['check_out'] = stripslashes($this->lang->line('check_out'));
        } else {
            $this->data['check_out'] = "check_out";
        }
        if ($this->lang->line('Print Page') != '') {
            $this->data['Print_Page'] = stripslashes($this->lang->line('Print Page'));
        } else {
            $this->data['Print_Page'] = "Print Page";
        }
        if ($this->lang->line('Cancellation Policy') != '') {
            $this->data['Cancellation_Policy'] = stripslashes($this->lang->line('Cancellation Policy'));
        } else {
            $this->data['Cancellation_Policy'] = "Cancellation Policy";
        }
        if ($this->lang->line('For More details of the cancellation policy, please refer') != '') {
            $this->data['Details_Cancellation_Policy'] = stripslashes($this->lang->line('For More details of the cancellation policy, please refer'));
        } else {
            $this->data['Details_Cancellation_Policy'] = "For More details of the cancellation policy, please refer";
        }
        if ($this->lang->line('house_rules') != '') {
            $this->data['house_rules'] = stripslashes($this->lang->line('house_rules'));
        } else {
            $this->data['house_rules'] = "house_rules";
        }
        if ($this->lang->line('Booked for') != '') {
            $this->data['Bookedfor'] = stripslashes($this->lang->line('Booked for'));
        } else {
            $this->data['Bookedfor'] = "Booked for";
        }
        if ($this->lang->line('SecurityDeposit') != '') {
            $this->data['SecurityDeposit'] = stripslashes($this->lang->line('SecurityDeposit'));
        } else {
            $this->data['SecurityDeposit'] = "SecurityDeposit";
        }
        if ($this->lang->line('ServiceFee') != '') {
            $this->data['ServiceFee'] = stripslashes($this->lang->line('ServiceFee'));
        } else {
            $this->data['ServiceFee'] = "ServiceFee";
        }
        if ($this->lang->line('Total') != '') {
            $this->data['Total'] = stripslashes($this->lang->line('Total'));
        } else {
            $this->data['Total'] = "Total";
        }
        if ($this->lang->line('Wallet') != '') {
            $this->data['Wallet'] = stripslashes($this->lang->line('Wallet'));
        } else {
            $this->data['Wallet'] = "Wallet";
        }
        if ($this->lang->line('Coupon') != '') {
            $this->data['Coupon'] = stripslashes($this->lang->line('Coupon'));
        } else {
            $this->data['Coupon'] = "Coupon";
        }
        if ($this->lang->line('paid') != '') {
            $this->data['Paid'] = stripslashes($this->lang->line('paid'));
        } else {
            $this->data['Paid'] = "Paid";
        }
        if ($this->lang->line('(Recuerde: no responder a esta reserva dará lugar a que su anuncio sea menor).') != '') {
            $this->data['Recuerde'] = stripslashes($this->lang->line('(Recuerde: no responder a esta reserva dará lugar a que su anuncio sea menor).'));
        } else {
            $this->data['Recuerde'] = "(Recuerde: no responder a esta reserva dará lugar a que su anuncio sea menor).";
        }
        if ($this->lang->line('If you need help or have any questions, please visit') != '') {
            $this->data['need_help'] = stripslashes($this->lang->line('If you need help or have any questions, please visit'));
        } else {
            $this->data['need_help'] = "If you need help or have any questions, please visit";
        }
        $this->load->view('site/experience/invoice', $this->data);
    }
    /*  experience invoice ends */
    /*  add review starts */
    function pastDateCurrency($id, $date, $Productamount)
    {
        $ci =& get_instance();
        $currency_date = date('Y-m-d', strtotime($date));
        $today = date("Y-m-d");
        if ($today <= $currency_date) {
            return $this->CurrencyValue($id, $Productamount);
        }
        $productCurrencyCode = $ci->db->where('experience_id', $id)->get(EXPERIENCE)->row()->currency;
        $currentCurrencyCode = $ci->session->userdata('currency_type');
        $amount = "http://currencies.apps.grandtrunk.net/getrate/$currency_date/$productCurrencyCode/$currentCurrencyCode";
        if (ini_get('allow_url_fopen')) {
            $response = file_get_contents($amount, 'r');
        }
        $current_amount = $Productamount * $response;
        return number_format($current_amount, 2);
    }
    /*  add review ends */
    /* Dispute function  */
    function CurrencyValue($id, $amount)
    {
        $rate = 0;
        $ci =& get_instance();
        $currencyCode = $ci->session->userdata('currency_type');
        $productCurrencyCode = $ci->db->where('experience_id', $id)->get(EXPERIENCE)->row()->currency;
        if ($currencyCode == '') {
            $newCurrencyCode = $ci->db->where(array('status' => 'Active', 'default_currency' => 'Yes'))->get(CURRENCY)->row()->currency_type;
            $params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $newCurrencyCode);
            $rate = round(currency_convert($params));
            echo $rate;
            if ($rate != 0) return $rate; else
                return $amount;
        }
        $params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);
        $rate = number_format(currency_convert($params), 2);
        if ($rate != 0) return $rate; else
            return $amount;
    }

    /* Dispute function */
    /*Dispute cancel booking*/
    public function add_review()
    {
        if ($_POST['proid'] != '') {
            $total_review = $_POST['total_review'] > 1 ? $_POST['total_review'] : 1;
            $dataArr = array('review' => $_POST['review'], 'status' => 'Inactive', 'product_id' => $_POST['proid'], 'user_id' => $_POST['user_id'], 'reviewer_id' => $_POST['reviewer_id'], 'email' => $_POST['reviewer_email'], 'bookingno' => $_POST['bookingno'], 'total_review' => $total_review,'review_type'=>$_POST['type']);
            $insertquery = $this->experience_model->add_review($dataArr);
            if ($this->lang->line('Your Review is received,it will be added after approval') != '') {
                $message = stripslashes($this->lang->line('Your Review is received,it will be added after approval'));
            } else {
                $message = "Your Review is received,it will be added after approval";
            }
            $this->setErrorMessage('success', $message);
        }
        redirect('my_experience/upcoming');
    }
    /*End Cancel booking*/
    /*  add discussion starts */
    public function add_dispute()
    {
        $prd_id = $this->input->post('prd_id');
        $bookingNo = $this->input->post('bookingNo');
        $trip_url = $this->input->post('trip_url');
        $email = $this->input->post('email');
        $disputer_id = $this->input->post('disputer_id');
        $excludeArr = array('trip_url', 'dispute_message', 'bookingNo');
        $dataArr = array('prd_id' => $prd_id, 'message' => $this->input->post('message'), 'user_id' => $this->checkLogin('U'), 'booking_no' => $bookingNo, 'email' => $email, 'disputer_id' => $disputer_id);
        $this->product_model->commonInsertUpdate(EXPERIENCE_DISPUTE, 'insert', $excludeArr, $dataArr, $condition);
        if ($this->lang->line('Successfully Dispute Added !!..') != '') {
            $message = stripslashes($this->lang->line('Successfully Dispute Added !!..'));
        } else {
            $message = "Successfully Dispute Added !!..";
        }
        $this->setErrorMessage('success', $message);
        redirect('my_experience/' . $trip_url);
    }
    /*  add discussion ends */
    /*  experience review display starts  */
    public function cancel_booking()
    {
        $prd_id = $this->input->post('prd_id');
        $bookingNo = $this->input->post('bookingNo');
        $trip_url = $this->input->post('trip_url');
        $email = $this->input->post('email');
        $disputer_id = $this->input->post('disputer_id');
        $excludeArr = array('trip_url', 'dispute_message', 'bookingNo','cancellation_percentage');
        $dataArr = array('prd_id' => $prd_id, 'message' => $this->input->post('message'), 'user_id' => $this->checkLogin('U'), 'booking_no' => $bookingNo, 'email' => $email, 'disputer_id' => $disputer_id,'cancellation_percentage'=>$this->input->post('cancellation_percentage'), 'cancel_status' => 1);
        $this->product_model->commonInsertUpdate(EXPERIENCE_DISPUTE, 'insert', $excludeArr, $dataArr, $condition);
        $UpdateArr = array('cancelled' => 'Yes');
        $Condition = array('prd_id' => $prd_id, 'user_id' => $this->checkLogin('U'), 'Bookingno' => $bookingNo);
       $this->product_model->update_details(EXPERIENCE_ENQUIRY, $UpdateArr, $Condition);
        
        /*MAIL TO HOST */
        $newsid = '56';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        
        $condition = array('id' => $disputer_id);
        $hostDetails = $this->product_model->get_all_details(USERS, $condition);
        $uid = $hostDetails->row()->id;
        $hostname = $hostDetails->row()->user_name;
        $host_email = $hostDetails->row()->email;
        
        $condition = array('id' => $this->checkLogin('U'));
        $custDetails = $this->product_model->get_all_details(USERS, $condition);
        $cust_name = $custDetails->row()->user_name;
        
        $condition = array('experience_id' => $prd_id);
        $prdDetails = $this->product_model->get_all_details(EXPERIENCE, $condition);
        $prd_title = $prdDetails->row()->experience_title;
        $reason = $this->input->post('message');
        
        $email_values = array('from_mail_id' => $sender_email, 'to_mail_id' => $host_email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $reg = array('logo' => $this->data['logo'],'host_name' => $hostname, 'cust_name' => $cust_name, 'prd_title' => $prd_title, 'reason' => $reason, 'booking_no' => $bookingNo);
        $message = $this->load->view('newsletter/ToHostCancelExpBooking' . $newsid . '.php', $reg, TRUE);
        //echo $email_values['from_mail_id'].'|'.$sender_name.'|'.$email_values['to_mail_id'].'|'.$email_values['subject_message'].'|'.$message; exit;
        $this->load->library('email', $config);
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
        //exit;
        /* EOF MAIL TO HOST */
        /*==========Cancellation SMS to Host=============*/ 
                if ($this->config->item('twilio_status') == '1') {

                        require_once('twilio/Services/Twilio.php');
                        $account_sid = $this->config->item('twilio_account_sid');
                        $auth_token = $this->config->item('twilio_account_token');
                        $from = $this->config->item('twilio_phone_number');
                        try {
                            $to = $hostDetails->row()->phone_no;
                            
                            $client = new Services_Twilio($account_sid, $auth_token);
                            $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Experience (".$prd_title.") - Bookingno:".$bookingNo." booking is Cancelled by User."));
                            //echo 'success';
                        } catch (Services_Twilio_RestException $e) {
                            //echo "Authentication Failed..!";
                        }
                }
        /*===========Cancellation SMS to Host=============*/ 
        $getEnquiryDet = $this->product_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $bookingNo));
        $TheSubTot = $getEnquiryDet->row()->subTotal;  //28.58
        $SecDeposit = $getEnquiryDet->row()->secDeposit; //28.58
        $CancelPercentage = $getEnquiryDet->row()->exp_cancel_percentage; // 50
        $CancelAmount = $TheSubTot / 100 * $CancelPercentage; //14.29
        $cancel_amount_guest=$TheSubTot-$CancelAmount; // 14.29
        
        if ($CancelPercentage!="100"){
            $CancelAmountWithSecDeposit=$cancel_amount_guest+$SecDeposit; //42.87
        }else{
            $CancelAmountWithSecDeposit=$SecDeposit;
        }
        
        $UpdateCommissionArr = array('paid_cancel_amount' => $CancelAmountWithSecDeposit);
        $ConditionCommission = array('booking_no' => $bookingNo);
        $this->product_model->update_details(EXP_COMMISSION_TRACKING, $UpdateCommissionArr, $ConditionCommission);

        if ($this->lang->line('Successfully booking canceled !!..') != '') {
            $message = stripslashes($this->lang->line('Successfully booking canceled !!..'));
        } else {
            $message = "Successfully booking canceled !!..";
        }
        $this->setErrorMessage('success', $message);
        redirect('my_experience/' . $trip_url);
    }

    public function add_discussion()
    {
        $redirect = $this->input->post('redirect');
        $excludeArr = array('redirect', 'discussion');
        $now = time();
         $bookingno=$this->input->post('bookingno');
         if($bookingno!='') {
       
        $dataArr = array('productId' => $this->input->post('rental_id'), 'bookingNo' => $this->input->post('bookingno'), 'senderId' => $this->checkLogin('U'), 'receiverId' => $this->input->post('receiver_id'), 'subject' => 'Booking Request : ' . $this->input->post('bookingno'), 'message' => $this->input->post('message'));
        $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $dataArr);
        $dataArr = array('convId' => $now);
        $condition = array();
        $this->product_model->commonInsertUpdate(EXPERIENCE_DISCUSSION, 'insert', $excludeArr, $dataArr, $condition);
        if ($this->lang->line('Your message was successfully sent') != '') {
            $message = stripslashes($this->lang->line('Your message was successfully sent'));
        } else {
            $message = "Your message was successfully sent";
        }
        $this->setErrorMessage('success', $message);
        redirect($redirect);
    }
    else{
        $rn=rand(100,999);
            $bookingno="ENQ".date('Y').date('m').date('d').$rn;
            $dataArr = array('productId' => $this->input->post('rental_id'), 'bookingNo' => $bookingno, 'senderId' => $this->checkLogin('U'), 'receiverId' => $this->input->post('receiver_id'), 'subject' => 'Booking Request : '.$bookingno, 'message' => $this->input->post('message'));
        $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $dataArr);

         $userArr = array('productId' => $this->input->post('rental_id'), 'bookingNo' => $bookingno, 'senderId' => $this->input->post('receiver_id'), 'receiverId' => $this->checkLogin('U'), 'subject' => 'Booking Request : '.$bookingno, 'message' => $this->input->post('message'));

         $this->user_model->simple_insert(EXPERIENCE_MED_MSG, $userArr);

        $dataArr = array('convId' => $now);
        $condition = array();
        $this->product_model->commonInsertUpdate(EXPERIENCE_DISCUSSION, 'insert', $excludeArr, $dataArr, $condition);
        if ($this->lang->line('Your message was successfully sent') != '') {
            $message = stripslashes($this->lang->line('Your message was successfully sent'));
        } else {
            $message = "Your message was successfully sent";
        }
        $this->setErrorMessage('success', $message);
        redirect($redirect);

    }
    }
    /*  experience review display ends  */
    /* experience dispute display starts */
    public function display_review()
    {
        if ($this->data['loginCheck'] != '') {
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_productreview_aboutyou_site_map($this->data['loginCheck']);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-review';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['ReviewDetails'] = $this->experience_model->get_productreview_aboutyou($this->data['loginCheck'], $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['uId'] = $this->data['loginCheck'];
            $this->load->view('site/experience/review', $this->data);
        } else {
            redirect(base_url());
        }
    }

    public function display_review1()
    {
        if ($this->data['loginCheck'] != '') {
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_productreview_byyou_site_map($this->data['loginCheck']);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-review1';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['ReviewDetails'] = $this->experience_model->get_productreview_byyou($this->data['loginCheck'], $pageLimitStart, $searchPerPage);
            //echo EXPERIENCE_REVIEW; exit;
            /*Pagination End*/
            $this->data['uId'] = $this->data['loginCheck'];
            $this->load->view('site/experience/reviewbyyou', $this->data);
        } else {
            redirect(base_url());
        }
    }



    /* experience dispute display ends */
    /*cancel booking dispute details*/
    public function display_dispute1()
    {
        if ($this->data['loginCheck'] != '') {
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_productdispute_byyou_site_map($this->data['loginCheck']);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-dispute1';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['DisputeDetails'] = $this->experience_model->get_productdispute_byyou($this->data['loginCheck'], $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['uId'] = $this->data['loginCheck'];
            $this->load->view('site/experience/disputebyyou', $this->data);
        } else {
            redirect(base_url());
        }
    }

    public function accept_dispute()
    {
        $disputeId = $this->uri->segment(4);
        $booking_no = $this->uri->segment(5);

        $condition = array('id' => $disputeId);

        $disputeData  = $this->experience_model->get_all_details('fc_experience_dispute',$condition);
        //print_r($disputeData->row());
        $data  = array('status' =>'Accept');
        
        $this->experience_model->update_details('fc_experience_dispute',$data,$condition);

        $this->setErrorMessage('success','Dispute accepted successfully');
        redirect('experience-cancel_booking_dispute');
    }
    function reject_dispute()
    {
        $disputeId = $this->uri->segment(4);

        $condition = array('id' => $disputeId);

        $data  = array('status' =>'Reject');
        
        $this->experience_model->update_details('fc_experience_dispute',$data,$condition);


        $this->setErrorMessage('success','Dispute rejected successfully');
        redirect('experience-cancel_booking_dispute');

    }

    /*  transaction display */
    /*Accept cancel booking dispute*/
    public function display_dispute()
    {
        if ($this->data['loginCheck'] != '') {
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_productdispute_aboutyou_site_map($this->data['loginCheck']);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-dispute';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['DisputeDetails'] = $this->experience_model->get_productdispute_aboutyou($this->data['loginCheck'], $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['uId'] = $this->data['loginCheck'];
            $this->load->view('site/experience/dispute', $this->data);
        } else {
            redirect(base_url());
        }
    }

    public function cancel_booking_dispute()
    {
        if ($this->data['loginCheck'] != '') {
            /*Pagination Start*/
            $searchPerPage = '1';
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_cancel_dispute_site_map($this->data['loginCheck']);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-cancel_booking_dispute';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['Canceldisputebooking'] = $this->experience_model->get_cancel_dispute($this->data['loginCheck'], $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['uId'] = $this->data['loginCheck'];
            $this->load->view('site/experience/cancel_booking_dispute', $this->data);
        } else {
            redirect(base_url());
        }
    }

    public function Cancel_Book_experience()
    {
        $disputeId = $this->input->post('disputeId');
        $booking_no = $this->input->post('booking_no');
        $cancel_booking_id = $this->input->post('cancel_id');
        $condition = array('id' => $disputeId, 'cancel_status' => $cancel_booking_id);
        $disputeData = $this->experience_model->get_all_details(EXPERIENCE_DISPUTE, $condition);
        $data = array('status' => 'Accept');
        $this->experience_model->update_details(EXPERIENCE_DISPUTE, $data, $condition);
        echo 'success';
        $getBookedDate = $this->experience_model->ExecuteQuery("select DATE(checkin) as checkinDate ,DATE(checkout) as checkoutDate from " . EXPERIENCE_ENQUIRY . " where Bookingno='" . $booking_no . "'")->row();
        $UpdateArr = array('cancelled' => 'Yes');
        $Condition = array('prd_id' => $disputeData->row()->prd_id, 'user_id' => $disputeData->row()->user_id, 'Bookingno' => $disputeData->row()->booking_no);
        $this->product_model->update_details(EXPERIENCE_ENQUIRY, $UpdateArr, $Condition);
        $getEnquiryDet = $this->product_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $disputeData->row()->booking_no));
        $TheSubTot = $getEnquiryDet->row()->subTotal;
        $CancelPercentage = $getEnquiryDet->row()->cancel_percentage;
        $CancelAmount = $TheSubTot / 100 * $CancelPercentage;
        $UpdateCommissionArr = array('paid_cancel_amount' => $CancelAmount);
        $ConditionCommission = array('booking_no' => $disputeData->row()->booking_no);
        $this->product_model->update_details(EXP_COMMISSION_TRACKING, $UpdateCommissionArr, $ConditionCommission);
        /* End - Update RentalEnquiry and Commission Tracking*/
        /*Mail To Guest Start*/
        $condition = array('id' => $this->checkLogin('U'));
        $hostDetails = $this->product_model->get_all_details(USERS, $condition);
        $uid = $hostDetails->row()->id;
        $hostname = $hostDetails->row()->user_name;
        $host_email = $hostDetails->row()->email;
        $condition = array('id' => $disputeData->row()->user_id);
        $custDetails = $this->product_model->get_all_details(USERS, $condition);
        $cust_name = $custDetails->row()->user_name;
        $cust_email = $custDetails->row()->email;
        $newsid = '57';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, //'from_mail_id'=>'kathirvel@pofitec.com',
            'to_mail_id' => $cust_email, 'subject_message' => $template_values ['news_subject'],);
        $reg = array('name' => 'Accepted', 'host_name' => $hostname, 'cus_name' => $cust_name,'logo' => $this->data['logo']);
        $message = $this->load->view('newsletter/ToGuestAcceptRejection' . $newsid . '.php', $reg, TRUE);
        $this->load->library('email');
        $this->email->set_mailtype($email_values['mail_type']);
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->message($message);
        try {
            $this->email->send();
            if ($this->lang->line('mail_send_success') != '') {
                $message = stripslashes($this->lang->line('mail_send_success'));
            } else {
                $message = "mail send success";
            }
            $this->setErrorMessage('success', $message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        /*Mail To Guest End*/
    }

    /*  transaction display  ends */
    /* my experience listing- booked by you  */
    function rejectBooking_experience()
    {
        $disputeId = $this->input->post('disputeId');
        $booking_no = $this->input->post('booking_no');
        $cancel_booking_id = $this->input->post('cancel_id');
        $condition = array('id' => $disputeId, 'cancel_status' => $cancel_booking_id);
        $data = array('status' => 'Reject');
        $ok = $this->experience_model->update_details(EXPERIENCE_DISPUTE, $data, $condition);
        echo 'success';
        /* Mail to Guest Start*/
        $newsid = '58';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        $getdisputeDetails = $this->experience_model->get_all_details(EXPERIENCE_DISPUTE, $condition);
        $condition = array('id' => $this->checkLogin('U'));
        $hostDetails = $this->product_model->get_all_details(USERS, $condition);
        $uid = $hostDetails->row()->id;
        $hostname = $hostDetails->row()->user_name;
        $host_email = $hostDetails->row()->email;
        $condition = array('id' => $getdisputeDetails->row()->user_id);
        $custDetails = $this->product_model->get_all_details(USERS, $condition);
        $cust_name = $custDetails->row()->user_name;
        $email = $custDetails->row()->email;
        $condition = array('id' => $getdisputeDetails->row()->prd_id);
        $prdDetails = $this->product_model->get_all_details(EXPERIENCE, $condition);
        $prd_title = $prdDetails->row()->product_title;
        $email_values = array('from_mail_id' => $sender_email, //'from_mail_id'=>'kailashkumar.r@pofitec.com',
            'to_mail_id' => $email, //'to_mail_id'=> 'preetha@pofitec.com',
            'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $reg = array('host_name' => $hostname, 'cust_name' => $cust_name, 'prd_title' => $prd_title,'logo' => $this->data['logo']);
        $message = $this->load->view('newsletter/ToGuestRejectCancelBooking' . $newsid . '.php', $reg, TRUE);
        $this->load->library('email', $config);
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
        /* Mail to Guest End*/
    }

    public function dashboard_account_trans()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else { 
            $emailQry = $this->experience_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $email = $emailQry->row()->email;
            /*Pagination Start*/
            $segment_2=$this->uri->segment(2);
            if($segment_2=='1'){
                $this->data['active']=1;//completed
            }else{
                $this->data['active']=2;//futured
            }
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_featured_transaction_site_map($email);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'experience-transactions'.'/2';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['featuredpaginationLink'] = $data ['featuredpaginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['featured_transaction'] = $this->experience_model->get_featured_transaction($email, $pageLimitStart, $searchPerPage);
            /*print_r($this->data['featured_transaction']->result()); exit();*/
            //exit;
            /*Pagination End*/
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->get_completed_transaction_site_map($email);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'experience-transactions'.'/1';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['completedpaginationLink'] = $data ['completedpaginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['completed_transaction'] = $this->experience_model->get_completed_transaction($email, $pageLimitStart, $searchPerPage);
            /*print_r($this->data['completed_transaction']->result()); exit();*/
            /*Pagination End*/
            $this->load->view('site/experience/dashboard-account-transaction', $this->data);
        }
    }

    /* my experience listing- booked by you  */
    /*  experience reservation starts */
    public function my_experience()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $keyword = "";
            if ($_POST) {
                $keyword = $this->input->post('product_title');
            }
            $this->data['result'] = $this->product_model->get_contents();
            $this->load->model('admin_model');
            $this->data ['heading'] = 'Dashboard-My Experience';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->booked_rental_trip_site_map($this->checkLogin('U'), $keyword);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'my_experience/upcoming';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->experience_model->booked_rental_trip($this->checkLogin('U'), $keyword, $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['user_id'] = $this->checkLogin('U');
            $this->load->view('site/experience/dashboard-my_experience', $this->data);
        }
    }

    public function my_experience_prev()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            if ($_POST) {
                $product_title = $this->input->post('product_title');
            }
            $this->data ['heading'] = 'Dashboard-My Experience previous';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->booked_rental_trip_prev_site_map($this->checkLogin('U'), $product_title);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<<';
            $config ['next_link'] = '>>';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'my_experience/previous';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->experience_model->booked_rental_trip_prev($this->checkLogin('U'), $product_title, $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->data['user_id'] = $this->checkLogin('U');
            $this->load->view('site/experience/dashboard-my_experience-prev', $this->data);
        }
    }

    /*  experience reservation ends */
    /* Experience module ends */
    /*  currency helper function overrride starts */
    public function dashboard_listing_reservation()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data['result'] = $this->experience_model->get_contents();
            $this->data ['heading'] = 'Dashboard-Experience Reservation';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->booked_rental_future_site_map($this->checkLogin('U'));
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'experience-reservation';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->experience_model->booked_rental_future($this->checkLogin('U'), $pageLimitStart, $searchPerPage);
           
            /*Pagination End*/
            $this->load->view('site/experience/dashboard-listing-reservation', $this->data);
        }
    }

     public function cancel_by_host()
    {
        
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $keyword = "";
            if ($_POST) {
                $keyword = $this->input->post('product_title');
            }
            $this->data ['heading'] = 'Dashboard-Trips';
            /*Pagination Start*/
            
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->hostcancelled_trip_site_map($this->checkLogin('U'), $keyword);//booked_rental_trip_site_map
            $this->config->item('site_pagination_per_page');
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'host_cancelled_bookings_experience';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config['attributes'] = array('class' => 'pages');
            $config["next_link"] = '>';
            $config["prev_link"] = '<';
            $config ["uri_segment"] = 2;
            $config['first_link'] = false;
            $config['last_link'] = false;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['cancelledRental'] = $this->experience_model->hostcancelled_trip($this->checkLogin('U'), $keyword, $pageLimitStart, $searchPerPage);
            //echo $this->db->last_query(); exit;
            /*Pagination End*/
            $this->data['user_id'] = $this->checkLogin('U');
            $this->load->view('site/experience/host_cancelled_booking', $this->data);
        }
    }
    function host_cancel_booking()
    {
      //  echo 'hi';exit();
        
        $vehicle_id = $this->input->post('prd_id');
         $user_id = $this->input->post('user_id');
       // $vehicle_type = $this->input->post('vehicle_type');
        $cancel_percentage = $this->input->post('cancellation_percentage');
        $bookingNo = $this->input->post('Bookingno');
        $trip_url = $this->input->post('trip_url');
      
        $disputer_id = $this->input->post('disputer_id');
        $condition = array('id' => $disputer_id);
        $hostDetails = $this->experience_model->get_all_details(USERS, $condition);
        $email = $hostDetails->row()->email;
        $excludeArr = array('trip_url', 'dispute_message', 'Bookingno');
        $dataArr = array('prd_id' => $vehicle_id, 'cancellation_percentage' => $cancel_percentage, 'message' => $this->input->post('message'), 'user_id' => $user_id, 'booking_no' => $bookingNo, 'email' => $email, 'disputer_id' => $disputer_id, 'cancel_status' => 1,'dispute_by'=>'Host','status'=>'Accept');
        /* Mail to Host Start*/
       // print_r($dataArr);exit();
        $newsid = '72';
        $template_values = $this->experience_model->get_newsletter_template_details($newsid);
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        //HOST DETAILS
        
        $uid = $hostDetails->row()->id;
        $hostname = $hostDetails->row()->user_name;
        $host_email = $hostDetails->row()->email;
        
        //GUEST DETAILS
        $getEnquiryDet = $this->experience_model->get_all_details(EXPERIENCE_ENQUIRY, array('Bookingno' => $bookingNo))->row();
        $guest_id = $getEnquiryDet->user_id;
        $EnquiryId=$getEnquiryDet->id;
        $checkInDate = $getEnquiryDet->checkin;
        $checkOutDate = $getEnquiryDet->checkout;
        $Enquser_id=$getEnquiryDet->user_id;
        $Enqsell_id=$getEnquiryDet->renter_id;
        $Enqvehicle_id=$getEnquiryDet->prd_id;
        
        $condition = array('id' => $guest_id);
        $custDetails = $this->experience_model->get_all_details(USERS, $condition);
        $cust_name = $custDetails->row()->user_name;
        $cust_email = $custDetails->row()->email;
        
         $condition = array('experience_id' => $vehicle_id);
        $prdDetails = $this->experience_model->get_all_details(EXPERIENCE, $condition);
        $prd_title = $prdDetails->row()->experience_title;
        $reason = $this->input->post('message');
        $booking_no = $bookingNo;
        $email_values = array('from_mail_id' => $sender_email, 'to_mail_id' => $cust_email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $reg = array('logo' => $this->data['logo'],'host_name' => $hostname, 'cust_name' => $cust_name, 'prd_title' => $prd_title, 'reason' => $reason, 'booking_no' => $booking_no);
        $message = $this->load->view('newsletter/ToGuestCancelExpBooking' . $newsid . '.php', $reg, TRUE);
        echo $message;
        $this->load->library('email', $config);
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
        /*MAIL TO HOST */
        $newsid = '56';
        $template_values = $this->experience_model->get_newsletter_template_details($newsid);
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        
        $condition = array('id' => $disputer_id);
        $hostDetails = $this->experience_model->get_all_details(USERS, $condition);
        $uid = $hostDetails->row()->id;
        $hostname = $hostDetails->row()->user_name;
        $host_email = $hostDetails->row()->email;
        
        $condition = array('id' => $this->checkLogin('U'));
        $custDetails = $this->experience_model->get_all_details(USERS, $condition);
        $cust_name = $custDetails->row()->user_name;
        
        $condition = array('experience_id' => $prd_id);
        $prdDetails = $this->experience_model->get_all_details(EXPERIENCE, $condition);
        $prd_title = $prdDetails->row()->experience_title;
        $reason = $this->input->post('message');
        
        $email_values = array('from_mail_id' => $sender_email, 'to_mail_id' => $host_email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $reg = array('logo' => $this->data['logo'],'host_name' => $hostname, 'cust_name' => $cust_name, 'prd_title' => $prd_title, 'reason' => $reason, 'booking_no' => $bookingNo);
        $message = $this->load->view('newsletter/ToHostCancelExpBooking' . $newsid . '.php', $reg, TRUE);
        //echo $email_values['from_mail_id'].'|'.$sender_name.'|'.$email_values['to_mail_id'].'|'.$email_values['subject_message'].'|'.$message; exit;
        $this->load->library('email', $config);
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
        //exit;
        /* EOF MAIL TO HOST */
        
        
        $this->experience_model->commonInsertUpdate(EXPERIENCE_DISPUTE, 'insert', $excludeArr, $dataArr, $condition);
        
        //Start - Update Rental enquiry and commission tracking.
        //$UpdateArr=array('cancelled'=>'Yes');
        $UpdateArr=array('cancelled'=>'Yes','dispute_by'=>'Host');
        $Condition=array('prd_id'=>$vehicle_id,
                         'Bookingno'=>$bookingNo);
        $this->experience_model->update_details(EXPERIENCE_ENQUIRY,$UpdateArr,$Condition);
        
      

        $get_paid_amount = $this->experience_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('EnquiryId'=>$EnquiryId,'user_id'=>$user_id,'sell_id'=>$disputer_id,'product_id'=>$vehicle_id));
        $paidAmount = $getEnquiryDet->totalAmt;
       
        $UpdateCommissionArr=array('paid_cancel_amount'=>$paidAmount,'dispute_by'=>'Host','disputer_id'=>$disputer_id);
        $ConditionCommission=array('booking_no'=>$bookingNo);
        $this->experience_model->update_details(EXP_COMMISSION_TRACKING,$UpdateCommissionArr,$ConditionCommission);
        //End - Update Rental enquiry and commission tracking.
        

        //  exit;
        if ($this->lang->line('Successfully booking canceled !!..') != '') {
            $message = stripslashes($this->lang->line('Successfully booking canceled !!..'));
        } else {
            $message = "Successfully booking canceled !!..";
        }
        $this->setErrorMessage('success', $message);
        redirect($trip_url);
    }

    public function dashboard_listing_pass_reservation()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data['result'] = $this->experience_model->get_contents();
            $this->data ['heading'] = 'Dashboard-Experience Reservation';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->experience_model->booked_rental_passed_site_map($this->checkLogin('U'));
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = 'Previous';
            $config ['next_link'] = 'Next';
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'experience-passed-reservation';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->experience_model->booked_rental_passed($this->checkLogin('U'), $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            $this->load->view('site/experience/dashboard-listing-passed-reservation', $this->data);
        }
    }

    function convertCurrency($from, $to, $amount)
    {
        $url = "http://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $request = curl_init();
        $timeOut = 0;
        curl_setopt($request, CURLOPT_URL, $url);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);
        preg_match("/<span class=bld>(.*)<\/span>/", $response, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return number_format((float)$converted, 2, '.', '');
    }

    public function med_message()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;

         $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
          $this->data['page_name']='experience_inbox';//all

         $this->data['bookingNo_all']= $get_ordered_list_count = $this->experience_model->get_med_messages_site_map($this->data['loginCheck']);
         $get_ordered_list_count=$this->experience_model->get_med_messages($this->checkLogin('U'), '','',$booking_nos);// for pagination count

        $this->config->item('site_pagination_per_page');
        $config ['prev_link'] = '<';
        $config ['next_link'] = '>';
        $config ["cur_tag_open"] = '<a class="active">';
        $config ["cur_tag_close"] = '</a>';
        $config ['attributes'] = array('class' => 'pages');
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience_inbox';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->load->view('site/experience/dashboard-med-message', $this->data);
    }
    /* Starred Message*/ 
    public function msg_starred()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;


         $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='experience-msg-starred';//all
         $this->data['bookingNo_all']= $get_ordered_list_count = $this->experience_model->get_med_messages_starred($this->data['loginCheck']);
         $get_ordered_list_count = $this->experience_model->get_med_messages_starred($this->data['loginCheck'], '','',$booking_nos);

        $this->config->item('site_pagination_per_page');
       $config ['prev_link'] = '<';
        $config ['next_link'] = '>';
        $config ["cur_tag_open"] = '<a class="active">';
        $config ["cur_tag_close"] = '</a>';
        $config ['attributes'] = array('class' => 'pages');
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience-msg-starred';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages_starred($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
        $this->load->view('site/experience/dashboard-med-message', $this->data);  
    }

    /* Unread Message*/
    public function msg_unread()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;


         $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
         $this->data['page_name']='experience-msg-unread';//all

        $this->data['bookingNo_all'] = $get_ordered_list_count = $this->experience_model->get_med_messages_unread($this->data['loginCheck']);
        $get_ordered_list_count = $this->experience_model->get_med_messages_unread($this->data['loginCheck'], '','',$booking_nos);
        $this->config->item('site_pagination_per_page');
        $config ['prev_link'] = '<';
        $config ['next_link'] = '>';
        $config ["cur_tag_open"] = '<a class="active">';
        $config ["cur_tag_close"] = '</a>';
        $config ['attributes'] = array('class' => 'pages');
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience-msg-unread';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages_unread($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
        $this->load->view('site/experience/dashboard-med-message', $this->data); 
    } 

    /* Archived Message*/
    public function msg_archived()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;

         $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
         $this->data['page_name']='experience-msg-archived';//all

        $this->data['bookingNo_all'] =  $get_ordered_list_count = $this->experience_model->get_med_messages_archived($this->data['loginCheck']);
        $get_ordered_list_count = $this->experience_model->get_med_messages_archived($this->data['loginCheck'], '','',$booking_nos);
        
        $this->config->item('site_pagination_per_page');
        $config ['prev_link'] = '<';
        $config ['next_link'] = '>';
        $config ["cur_tag_open"] = '<a class="active">';
        $config ["cur_tag_close"] = '</a>';
        $config ['attributes'] = array('class' => 'pages');
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience-msg-archived';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages_archived($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
        $this->load->view('site/experience/dashboard-med-message', $this->data); 
    }

    /*Pending Request*/ 
    public function msg_pending_request()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;


         $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
         $this->data['page_name']='experience-msg-pending-request';//all

        $this->data['bookingNo_all'] =  $get_ordered_list_count = $this->experience_model->get_med_messages_pending_request($this->data['loginCheck']);
        $get_ordered_list_count = $this->experience_model->get_med_messages_pending_request($this->data['loginCheck'], '','',$booking_nos);

        $this->config->item('site_pagination_per_page');
        $config ['prev_link'] = 'Previous';
        $config ['next_link'] = 'Next';
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience_inbox';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages_pending_request($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
        $this->load->view('site/experience/dashboard-med-message', $this->data); 
    }

    /*Reservation Messages*/
    public function msg_reservation()
    {
        /*Pagination Start*/
        $searchPerPage = $this->config->item('site_pagination_per_page');
        $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $pageLimitStart = $paginationNo;
        $pageLimitEnd = $pageLimitStart + $searchPerPage;


          $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
         $this->data['selected_booking_nos']=$booking_nos;
         $this->data['page_name']='experience-msg-reservation';//all


         $this->data['bookingNo_all'] = $get_ordered_list_count = $this->experience_model->get_med_messages_reservations($this->data['loginCheck']);
         $get_ordered_list_count = $this->experience_model->get_med_messages_reservations($this->data['loginCheck'], '','',$booking_nos);

        $this->config->item('site_pagination_per_page');
        $config ['prev_link'] = '<';
        $config ['next_link'] = '>';
        $config ["cur_tag_open"] = '<a class="active">';
        $config ["cur_tag_close"] = '</a>';
        $config ['attributes'] = array('class' => 'pages');
        $config ['num_links'] = 2;
        $config ['base_url'] = base_url() . 'experience-msg-reservation';
        $config ['total_rows'] = count($get_ordered_list_count);
        $config ["per_page"] = $searchPerPage;
        $config ["uri_segment"] = 2;
        $this->pagination->initialize($config);
        $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
        
        $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
        $this->data['med_messages'] = $this->experience_model->get_med_messages_reservations($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
        /*Pagination End*/
        $this->data['userId'] = $this->checkLogin('U');
        $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
        $this->load->view('site/experience/dashboard-med-message', $this->data); 
    }

    public function change_star_status()
    {
        $bookingNo = $this->uri->segment(2);
        $message_id = $this->uri->segment(3);
        if($this->uri->segment(4) == 1)
        {
            $status = 'No';
        }
        elseif($this->uri->segment(4) == 0)
        {
            $status = 'Yes';
        }
        $this->db->where('bookingNo', $bookingNo);
        $this->db->where('id', $message_id);
        $this->db->update(EXPERIENCE_MED_MSG, array('msg_star_status' => $status));
        redirect('experience_inbox');
    }
    public function change_archive_status()
    {
        $bookingNo = $this->uri->segment(2);
        $message_id = $this->uri->segment(3);

        if($this->uri->segment(4) == 1)
        {
            $status = 'No';
        }
        elseif($this->uri->segment(4) == 0)
        {
            $status = 'Yes';
        }
        $this->db->where('bookingNo', $bookingNo);
        $this->db->where('id', $message_id);
        $this->db->update(EXPERIENCE_MED_MSG, array('user_archive_status' => $status,'host_archive_status' => $status));
        redirect('experience_inbox');
    }
    
    public function host_conversation()
    {
        $bookingNo = $this->uri->segment(2, 0);
        $messageID = $this->uri->segment(3, 0);
        $this->data['bookingNo'] = $bookingNo;
        $this->data['userId'] = $this->checkLogin('U');
        if ($this->checkLogin('U') != '' && $bookingNo != '') {
            $this->data['conversationDetails'] = $this->experience_model->get_all_details(EXPERIENCE_MED_MSG, array('BookingNo' => $bookingNo), array(array('field' => 'id')));
            $this->data['product_details'] = $this->experience_model->get_all_details(EXPERIENCE, array('experience_id' => $this->data['conversationDetails']->row()->productId));
            if ($this->data['conversationDetails']->num_rows() > 0) {
                $this->db->where('bookingNo', $bookingNo);
                $this->db->where('receiverId', $this->checkLogin('U'));
                if ($this->data['product_details']->row()->user_id == $this->checkLogin('U')) { //logged person is a host
                    $this->db->update(EXPERIENCE_MED_MSG, array('msg_read' => 'Yes', 'host_msgread_status' => 'Yes'));
                } else {
                    $this->db->update(EXPERIENCE_MED_MSG, array('msg_read' => 'Yes', 'user_msgread_status' => 'Yes'));
                }
            }
            $this->data['bookingDetails'] = $this->experience_model->get_booking_details($bookingNo);
            $temp[] = $this->data['conversationDetails']->row()->senderId;
            $temp[] = $this->data['conversationDetails']->row()->receiverId;
            $productId = $this->data['productId'] = $this->data['conversationDetails']->row()->productId;
            if ($this->checkLogin('U') == $temp[0]) {
                $this->data['sender_id'] = $temp[0];
                $this->data['receiver_id'] = $temp[1];
            } else {
                $this->data['sender_id'] = $temp[1];
                $this->data['receiver_id'] = $temp[0];
            }
            $this->data['senderDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['sender_id']));
            $this->data['receiverDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['receiver_id']));
            //echo REVIEW.'|'.$this->data['receiver_id']; exit;fc_review|43
            //print_r($this->data['receiverDetails']->row());
            //exit;
            $this->data['verifiedDetails'] = $this->user_model->get_all_details(REQUIREMENTS, array('user_id' => $this->data['receiver_id']));
            
            //$reviewCount = $this->user_model->get_all_details(REVIEW, array('user_id' => $this->data['receiver_id']));
            $reviewCount = $this->user_model->get_all_details(EXPERIENCE_REVIEW, array('reviewer_id' => $this->data['receiver_id'],'bookingno'=>$bookingNo));//by nagoor
            $this->data['reviewCount'] = $reviewCount->num_rows();
            $this->data['productDetails'] = $this->user_model->get_all_details(EXPERIENCE, array('experience_id' => $productId));
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $ip = $_SERVER['HTTP_CLIENT_IP'];
            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            } else {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $sender_id = $this->data['sender_id'];
            $receiver_id = $this->data['receiver_id'];
            $sender = $this->user_model->get_users_details("where id=$sender_id");
            $receiver = $this->user_model->get_users_details("where id=$receiver_id");
            $this->load->view('site/experience/host_conversation', $this->data);
        } else {
            redirect();
        }
    }
    
        public function delete_conversation_details_msg($id){

            $update1 = array('msg_status' => 1);
            $this->db->set($update1);
            $this->db->where('id', $id);
            $this->db->update(EXPERIENCE_MED_MSG);
            
            if ($this->lang->line('Message deleted successfully!') != '') {
                $message = stripslashes($this->lang->line('Message deleted successfully!'));
            } else {
                $message = "Message deleted successfully!";
            }
            $this->setErrorMessage('success', $message);
            redirect('experience_inbox');
    }

    public function send_message()
    {
        $sender_id = $this->input->post('sender_id');
        $receiver_id = $this->input->post('receiver_id');
        $booking_id = $this->input->post('booking_id');
        $product_id = $this->input->post('product_id');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $host_msgread_status = $user_msgread_status = 'Yes';
        $msg_read = 'No';
        $statusQry = $this->user_model->get_all_details(EXPERIENCE_MED_MSG, array('bookingNo' => $booking_id));
        $status = $statusQry->row()->status;
        $productData = $this->user_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
        if ($productData->row()->user_id == $this->checkLogin('U')) {
            $user_msgread_status = 'No';
            $host_msgread_status = 'Yes';
        } else {
            $host_msgread_status = 'No';
            $user_msgread_status = 'Yes';
        }
        $dataArr = array('productId' => $product_id, 'senderId' => $sender_id, 'receiverId' => $receiver_id, 'bookingNo' => $booking_id, 'subject' => $subject, 'message' => $message, 'point' => '0', 'status' => $status, 'msg_read' => $msg_read, 'host_msgread_status' => $host_msgread_status, 'user_msgread_status' => $user_msgread_status);
        $this->db->insert(EXPERIENCE_MED_MSG, $dataArr);
    }

    /* Med msg ends */
    /* wishlist  */
    public function AddWishListForm()
    {
        $Rental_id = $this->uri->segment(4, 0);
        $this->data ['productList'] = $this->experience_model->get_product_details_wishlist($Rental_id);
        $this->data ['WishListCat'] = $this->experience_model->get_list_details_wishlist($this->data ['loginCheck']);
        $this->data ['notesAdded'] = $this->experience_model->get_notes_added($Rental_id, $this->data ['loginCheck']);
        $this->load->view('site/experience/ExperienceWishlist', $this->data);
    }

    public function AddToWishList()
    {
        /*print_r($this->input->post()); exit;
        Array ( [rental_id] => 40 [wishlist_cat] => Array ( [0] => 1 ) [nid] => [add-notes] => test [submit] => Add )*/
        $Rental_id = $this->input->post('rental_id');
        $notes = $this->input->post('add-notes');
        $user_id = $this->data['loginCheck'];
        $note_id = $this->input->post('nid');
        $wishlist_cat = $this->input->post('wishlist_cat');
        if ($Rental_id != '') {
            $this->experience_model->update_wishlist($Rental_id, $wishlist_cat);
            if ($note_id != '') {
                $this->experience_model->update_notes(array('notes' => $notes), array('id' => $note_id));
            } else {
                $this->experience_model->update_notes(array('experience_id' => $Rental_id, 'user_id' => $user_id, 'notes' => $notes));
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

    public function DeleteWishList()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $product_id = $this->input->post('pid');
            $id = $this->input->post('wid');
            $condition = array('id' => $id);
            $this->data['WishListCat'] = $this->product_model->get_all_details(LISTS_DETAILS, $condition);
            if ($this->data['WishListCat']->row()->experience_id != '') {
                $WishListCatArr = @explode(',', $this->data['WishListCat']->row()->experience_id);
                $my_array = array_filter($WishListCatArr);
                $to_remove = (array)$product_id;
                $result = array_diff($my_array, $to_remove);
                $resultStr = implode(',', $result);
                if ($resultStr != '') {
                    $this->product_model->updateWishlistRentals(array('experience_id' => $resultStr, 'last_added' => '2'), $condition);
                    $res['result'] = '0';
                } else {
                    $this->product_model->updateWishlistRentals(array('experience_id' => $resultStr, 'last_added' => '1'), $condition);
                    $res['result'] = '1';
                }
            } else if ($this->data['WishListCat']->row()->product_id != '') {
                $WishListCatArr = @explode(',', $this->data['WishListCat']->row()->product_id);
                $my_array = array_filter($WishListCatArr);
                $to_remove = (array)$product_id;
                $result = array_diff($my_array, $to_remove);
                $resultStr = implode(',', $result);
                if ($resultStr != '') {
                    $this->product_model->updateWishlistRentals(array('product_id' => $resultStr, 'last_added' => '2'), $condition);
                    $res['result'] = '0';
                } else {
                    $this->product_model->updateWishlistRentals(array('product_id' => $resultStr, 'last_added' => '1'), $condition);
                    $res['result'] = '1';
                }
            }
        }
        echo json_encode($res);
    }

    /* wishlist */
    public function SavePhotoCaption()
    {
        $excludeArr = array('id');
        $dataArr = array();
        $condition = array('id' => $this->input->post('id'));
        $this->product_model->commonInsertUpdate(EXPERIENCE_PHOTOS, 'update', $excludeArr, $dataArr, $condition);
        echo json_encode(array('status_code' => 1));
    }

    public function get_remaining_count($id)
    {
        $remaining = '';
        if ($id != '') {
            $completed_arr = array();
            $this->data['basics'] = 0;
            $this->data['language'] = 0;
            $this->data['organization'] = 0;
            $this->data['exp_title'] = 0;
            $this->data['timing'] = 0;
            $this->data['tagline'] = 0;
            $this->data['photos'] = 0;
            $this->data['what_we_do'] = 0;
            $this->data['where_will_be'] = 0;
            $this->data['where_will_meet'] = 0;
            $this->data['what_will_provide'] = 0;
            $this->data['notes'] = 0;
            $this->data['about_you'] = 0;
            $this->data['guest_req'] = 0;
            $this->data['group_size'] = 0;
            $this->data['price'] = 0;
            $this->data['cancel_policy'] = 0;
            $condition = array('experience_id' => $id);
            $all_details = $this->experience_model->get_all_details(EXPERIENCE, $condition);
            $data = $all_details->row();
            if (!empty($data)) {
                if ($data->exp_type != '' && ($data->total_hours != '' || $data->date_count != '') && $data->type_id != '') {
                    $this->data['basics'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->language_list != '') {
                    $this->data['language'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->organization != '' && $data->organization_des != '') {
                    $this->data['organization'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->experience_title != '') {
                    $this->data['organization'] = 1;
                    $this->data['exp_title'] = 1;
                    $completed_arr[] = 1;
                }
                $dat_date = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_DATES, ' where experience_id=' . $id);
                $shedule_timing = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_TIMING, ' where experience_id=' . $id);
                if ($dat_date->num_rows() > 0 && $shedule_timing->num_rows() > 0) {
                    $this->data['timing'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->exp_tagline != '') {
                    $this->data['tagline'] = 1;
                    $completed_arr[] = 1;
                }
                $dat_img = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_PHOTOS, ' where product_id=' . $id . ' and product_image !=""');
                if ($dat_img->num_rows() > 0) {
                    $this->data['photos'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->what_we_do != '') {
                    $this->data['photos'] = 1;
                    $this->data['what_we_do'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->location_description != '') {
                    $this->data['where_will_be'] = 1;
                    $completed_arr[] = 1;
                }
                $loc_data = $this->experience_model->get_selected_fields_records('id', EXPERIENCE_ADDR, ' where experience_id=' . $id);
                if ($loc_data->num_rows() > 0) {
                    $this->data['where_will_meet'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->kit_content != '') {
                    $this->data['what_will_provide'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->note_to_guest != '') {
                    $this->data['notes'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->about_host != '') {
                    $this->data['about_you'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->guest_requirement != '') {
                    $this->data['guest_req'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->group_size != '') {
                    $this->data['group_size'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->price > 0) {
                    $this->data['price'] = 1;
                    $completed_arr[] = 1;
                }
                if ($data->cancel_policy != '') {
                    $this->data['cancel_policy'] = 1;
                    $completed_arr[] = 1;
                }
                $completed = count($completed_arr);
                $remaining = (17 - count($completed_arr));
                if (($data->experience_description != '') && ($dat_img->num_rows() == 0)) {
                    $remaining--;
                }
                if ($data->experience_title != '' && ($data->organization == '' || $data->organization_des == '')) {
                    $remaining--;
                }
            }
        }
        return $remaining;
    }

    /**To Update SEO**/
    public function UpdateSEO()
    {
        $catID = $this->input->post('catID');
        $title = $this->input->post('title');
        $chk = $this->input->post('chk');
        $this->experience_model->update_details(EXPERIENCE, array($chk => $title), array('experience_id' => $catID));
    }

}