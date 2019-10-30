<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
error_reporting(-1);
/** * URI:               http://www.homestaydnn.com/ * Description:       Landing page full control. * Version:           2.0 * Author:            Sathyaseelan,Vishnu **/

date_default_timezone_set('Asia/Kolkata');
class MY_Controller extends CI_Controller
{
    public $privStatus;
    public $data = array();
    function __construct()
    {
        parent::__construct();
        ob_start();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        $this->load->helper('url');
        $this->load->helper('text');
        $this->load->helper('currency_helper');
        $this->load->helper('common_helper');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->load->library(array(
            'session'
        ));
        /* Start- Currency Conversion at single request*/
        if (!isset($_SESSION['currency_result'])) {
            $_SESSION['currency_result'] = get_multiple_currency_rate($this->session->userdata('currency_type'));
        }
        /* Close- Currency Conversion at single request*/
        $this->load->model(array(
            'product_model',
            'user_model',
            'landing_model',
            'admin_model',
            'city_model'
        ));
        /* Connecting Database */
        if ($_SESSION['pageURL'] != '' && $this->uri->segment(3) != 'login_user') {
            $_SESSION['redirectCount'] += 1;
            if ($_SESSION['redirectCount'] > 2 || strpos($_SESSION['pageURL'], 'logout') > 1) {
                $_SESSION['pageURL'] = '';
                $_SESSION['redirectCount'] = '';
            }
        }
        $this->load->database();
        $this->db->reconnect();
        $this->data['demoserverChk'] = $demoserverChk = strpos($this->input->server('DOCUMENT_ROOT'), 'casperon/');
        /*Open - Get Social media login details*/
        $social_media_details = $this->db->select('google_client_secret,google_client_id,linkedin_app_id,linkedin_app_key,facebook_app_id,facebook_app_secret,site_status')->get('fc_admin_settings')->result();
        $this->data['facebook_id'] = $social_media_details[0]->facebook_app_id;
        $this->data['facebook_secert'] = $social_media_details[0]->facebook_app_secret;
        $this->data['linkedin_id'] = $social_media_details[0]->linkedin_app_id;
        $this->data['linkedin_secert'] = $social_media_details[0]->linkedin_app_key;
        $this->data['google_id'] = $social_media_details[0]->google_client_id;
        $this->data['google_secert'] = $social_media_details[0]->google_client_secret;
        $this->data['site_status_val'] = $social_media_details[0]->site_status;
        /*Close - Get Social media login details*/
        /*Signup form datas*/
        $birth_month = array();
        $birth_month[''] = 'Month';
        for ($i = 1; $i <= 12; $i++) {
            $birth_month[$i] = date('F', strtotime(date('Y-' . $i . '-d')));
        }
        $birth_day = array();
        $birth_day[''] = 'Date';
        for ($i = 1; $i <= 31; $i++) {
            $birth_day[$i] = $i;
        }
        $birth_year = array();
        $birth_year[''] = 'Year';
        $birth_year_end = date('Y') - 18;
        $birth_year_start = $birth_year_end - 80;
        for ($i = $birth_year_end; $i >= $birth_year_start; $i--) {
            $birth_year[$i] = $i;
        }
        $this->data['birth_month'] = $birth_month;
        $this->data['birth_year'] = $birth_year;
        $this->data['birth_day'] = $birth_day;
        /*Signup Form End*/
        /* Social media*/
        $this->load->library('google');
        $this->data['googleLoginURL'] = $this->google->loginURL();
        $this->load->library('facebook');
        $this->data['fblogoutUrl'] = $this->facebook->logout_url();
        $this->data['fbLoginUrl'] = $this->facebook->login_url();
        /* Close - Social media*/
        /*Loading CMS Pages*/
        if ($_SESSION['cmsPages'] == '') {
            $cmsPages = $this->db->query('select * from ' . CMS . ' where `status`="Publish"');
            $_SESSION['cmsPages'] = $cmsPages->result_array();
        }
        $this->data['cmsPages'] = $_SESSION['cmsPages'];
        /* Loading Footer Cms*/

        //echo $langCode_ar;
        // print_r($cmsList);exit;
        // echo $_SESSION['language_code'] .'ggg';//exit;
        /*Loading active languages*/
        $activeLgsList = $this->db->query('select * from ' . LANGUAGES . ' where `status`="Active" ORDER BY language_order ASC');
        $_SESSION['activeLgs'] = $activeLgsList->result_array();
        $this->data['activeLgs'] = $_SESSION['activeLgs'];
        $prefooter_query = "SELECT * FROM " . PREFOOTER . " WHERE status='Active'  ORDER BY id ASC LIMIT 3";
        $this->data['prefooter_results'] = $this->db->query($prefooter_query);
        $this->data['google_map_api'] = $this->config->item('google_developer_key');
        $this->appkey_col = $this->landing_model->get_social_media();
        define('APPKEY', $this->appkey_col->row()->facebook_app_id);
        $this->linkkey_col = $this->landing_model->get_social_media();
        define('APPLinkKEY', $this->linkkey_col->row()->linkedin_app_key);
        $this->googlekey_col = $this->landing_model->get_social_media();
        define('GOOGLEKEY', $this->googlekey_col->row()->google_client_id);
        $this->googlesecretkey_col = $this->landing_model->get_social_media();
        define('GOOGLESECRETKEY', $this->googlesecretkey_col->row()->google_client_secret);
        $this->watermark_col = $this->landing_model->get_social_media();
        define('WATERMARKCOL', $this->watermark_col->row()->watermark);

        // Currency part

        /*$manualUpdateStatus = $this->db->select('manual_currency_status')->where('id', '1')->get('fc_admin')->row()->manual_currency_status;
        $manualUpdateStatus=1; // added newly
        if ($manualUpdateStatus == 1) {
            $checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date', date('Y-m-d'))->get()->row();
            if (count($checkTodayUpdated) > 0) {

            } else {
                $result = $this->db->select('*')->from('fc_currency_cron')->order_by('curren_id', 'desc')->limit(1)->get()->row();
                $data = array('cron_update' => '1', 'currency_values' => $result->currency_values, 'created_date' => date('Y-m-d'));
                $this->db->insert('fc_currency_cron', $data);
                //$this->setErrorMessage('success', 'Values are saved successfully');
                //redirect('admin/currencyManual');
            }
        } else {
            $checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date', date('Y-m-d'))->get()->row();
            $previous_json_status = 0;
            if (count($checkTodayUpdated) > 0) {

            } else {
                $exchangeRateApi = $this->db->where('id', '1')->get(ADMIN)->row()->exchange_rate_api;
                $currencyArr = array();
                $get_currency_symbol = $this->db->select('*')->from('fc_currency')->get();
                foreach ($get_currency_symbol->result() as $sym) {
                    // Continuing if we got a result
                    $req_url = 'https://v3.exchangerate-api.com/bulk/' . $exchangeRateApi . '/' . $sym->currency_type . '';
                    $response_json = file_get_contents($req_url);
                    if (false !== $response_json) {
                        // Try/catch for json_decode operation
                        try {
                            // Decoding
                            $response_object = json_decode($response_json);
                            // Checking for errors
                            if ('success' === $response_object->result) {
                                if (is_array($currencyArr)) {
                                    $currencyArr[] = $response_json;
                                } else {
                                    $currencyArr = $response_json;
                                }
                            } else {
                                $previous_json_status = 1;
                                $result = $this->db->select('*')->from('fc_currency_cron')->order_by('curren_id', 'desc')->limit(1)->get()->row();
                                $currencyArr = $result->currency_values;

                            }
                        } catch (Exception $e) {
                            // Handle JSON parse error...
                        }
                    } else {
                        $previous_json_status = 1;
                        $result = $this->db->select('*')->from('fc_currency_cron')->order_by('curren_id', 'desc')->limit(1)->get()->row();
                        $currencyArr = $result->currency_values;
                    }
                }
            }
            if ($previous_json_status == 0) {
                //$json_encode = json_encode(array("currency_data" => $currencyArr));
            } else {
                $json_encode = $currencyArr;
                $dataArr = array('currency_values' => $json_encode, 'created_date' => date('Y-m-d'), 'cron_update' => '1');
                $this->db->insert('fc_currency_cron', $dataArr);
            }
        }*/
        // End Currency Part
        /*-Unread messages start-*/
        if ($this->checkLogin('U') != '') {
            $this->data['unread_messages_count'] = $this->user_model->get_unread_messages_count($this->checkLogin('U'));
            $this->data['unread_messages_count_admin'] = $this->user_model->get_unread_messages_count_admin();
            $userId = $this->checkLogin('U');
        }
        /*-Unread messages end-*/
        $this->data['admin_currency_code'] = $this->db->where('id', '1')->get(ADMIN)->row()->admin_currencyCode;
        $this->data['admin_currency_symbol'] = $this->db->where(array(
            'currency_type' => $this->data['admin_currency_code']
        ))->get(CURRENCY)->row()->currency_symbols;
        /* Checking user language and loading user details */
        if ($this->checkLogin('U') != '') {
            $this->data['userDetails'] = $this->db->query('SELECT * FROM ' . USERS . ' WHERE `id` = ' . $this->session->userdata('fc_session_user_id') . '');
            if ($this->uri->segment('1') != 'admin') {
            if($this->data['userDetails']->num_rows() == 0 || $this->data['userDetails']->row()->status == 'Inactive' || $this->data['userDetails']->row()->host_status == '1'){
                $this->session->unset_userdata('fc_session_user_id');
                $this->session->unset_userdata('session_user_email');
                $this->session->unset_userdata('fc_session_user_login_type');
                /*$this->session->sess_destroy();*/
                 $this->setErrorMessage('success', 'Your Account Was InActive. Please Contact Admin.');
                redirect(base_url());
            }
        }
            $this->data['MyWishLists'] = $this->db->select('id,name,product_id')->where('user_id', $this->data[userDetails]->row()->id)->get(LISTS_DETAILS);
            $this->data['latestBookedTrips'] = $this->landing_model->get_latest_booked_rentals($this->data[userDetails]->row()->id);
        }
        $config['SITENAME'] = $this->config->item('meta_title');
        if (substr($uriMethod, 0, 7) == 'display' || substr($uriMethod, 0, 4) == 'view' || $uriMethod == '0') {
            $this->privStatus = '0';
        } else if (substr($uriMethod, 0, 3) == 'add') {
            $this->privStatus = '1';
        } else if (substr($uriMethod, 0, 4) == 'edit' || substr($uriMethod, 0, 6) == 'insert' || substr($uriMethod, 0, 6) == 'change') {
            $this->privStatus = '2';
        } else if (substr($uriMethod, 0, 6) == 'delete') {
            $this->privStatus = '3';
        } else {
            $this->privStatus = '0';
        }
        $this->data['title'] = $this->config->item('meta_title');
        $this->data['heading'] = '';
        $this->data['flash_data'] = $this->session->flashdata('sErrMSG');
        $this->data['flash_data_type'] = $this->session->flashdata('sErrMSGType');
        $this->data['adminPrevArr'] = $this->config->item('adminPrev');
        $this->data['adminEmail'] = $this->config->item('email');
        $this->data['privileges'] = $this->session->userdata('fc_session_admin_privileges');
        $this->data['subAdminMail'] = $this->session->userdata('fc_session_admin_email');
        $this->data['admin_rep_code'] = $this->session->userdata('fc_session_admin_rep_code');
        $this->data['loginID'] = $this->session->userdata('fc_session_user_id');
        $this->data['allPrev'] = '0';
        $this->data['logo'] = $this->config->item('logo_image');
        $this->data['logo_img'] = $this->config->item('home_logo_image');
        $this->data['fevicon'] = $this->config->item('fevicon_image');
        $this->data['watermark'] = $this->config->item('watermark');

        $this->data['footer_cont'] = $this->product_model->get_all_details(ADMIN_SETTINGS, array('id' => '1'));

        $this->data['footer'] = $this->config->item('footer_content');
        $this->data['footer_ar'] = $this->config->item('footer_content_ar');
        $this->data['siteContactMail'] = $this->config->item('site_contact_mail');
        $this->data['WebsiteTitle'] = $this->config->item('email_title');
        $this->data['siteTitle'] = $this->config->item('email_title');
        $this->data['meta_title'] = $this->config->item('meta_title');
        $this->data['meta_keyword'] = $this->config->item('meta_keyword');
        $this->data['meta_description'] = $this->config->item('meta_description');
        $this->data['giftcard_status'] = $this->config->item('giftcard_status');
        $this->data['sidebar_id'] = $this->session->userdata('session_sidebar_id');
        if ($this->session->userdata('fc_session_admin_name') == $this->config->item('admin_name')) {
            $this->data['allPrev'] = '1';
        }
        $this->data['paypal_ipn_settings'] = unserialize($this->config->item('payment_0'));
        $this->data['paypal_credit_card_settings'] = unserialize($this->config->item('payment_1'));
        $this->data['authorize_net_settings'] = unserialize($this->config->item('payment_2'));
        /**********Curreny Settings end*********/
        /***************USD Default Curreny********/
        if ($this->session->userdata('currency_type') == '') {
            $currency_values = $this->product_model->get_all_details(CURRENCY, array(
                'status' => 'Active',
                'default_currency' => 'Yes'
            ));
            if ($currency_values->num_rows() == 1) {
                foreach ($currency_values->result() as $currency_v) {
                    $this->session->set_userdata('currency_type', $currency_v->currency_type);
                    $this->session->set_userdata('currency_s', $currency_v->currency_symbols);
                    $this->session->set_userdata('currency_r', $currency_v->currency_rate);
                }
            } else {
                $currency_values = $this->product_model->get_all_details(CURRENCY, array(
                    'currency_type' => 'USD'
                ));
                foreach ($currency_values->result() as $currency_v) {
                    $this->session->set_userdata('currency_type', $currency_v->currency_type);
                    $this->session->set_userdata('currency_s', $currency_v->currency_symbols);
                    $this->session->set_userdata('currency_r', $currency_v->currency_rate);
                }
            }
            $this->data['currencySymbol'] = $this->session->userdata('currency_s');
            $this->data['currencyType'] = $this->session->userdata('currency_type');
        } else {
            $this->data['currencySymbol'] = $this->session->userdata('currency_s');
            $this->data['currencyType'] = $this->session->userdata('currency_type');
        }
        //  $this->data['currency_setup'] = $this->product_model->get_all_details(CURRENCY, array(
        //   'status' => 'Active'), '');

        $this->db->select('*');
        $this->db->group_by('currency_type');
        $this->db->where(array('status' => 'Active'));
        $this->data['currency_setup'] = $this->db->get(CURRENCY);
        /***************USD Default Curreny********/
        $this->data['datestring'] = "%Y-%m-%d %h:%i:%s";
        if ($this->checkLogin('U') != '') {
            $this->data['common_user_id'] = $this->checkLogin('U');
        } elseif ($this->checkLogin('T') != '') {
            $this->data['common_user_id'] = $this->checkLogin('T');
        } else {
            $temp_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
            $this->session->set_userdata('fc_session_temp_id', $temp_id);
            $this->data['common_user_id'] = $temp_id;
        }
        $this->data['emailArr'] = $this->config->item('emailArr');
        $this->data['notyArr'] = $this->config->item('notyArr');
        $this->load->model('product_model');
        /*         * Like button texts         */
        define(LIKE_BUTTON, $this->config->item('like_text'));
        define(LIKED_BUTTON, $this->config->item('liked_text'));
        define(UNLIKE_BUTTON, $this->config->item('unlike_text'));
        /*Refereral Start */
        if ($this->input->get('ref') != '') {
            $referenceName = $this->input->get('ref');
            $this->session->set_userdata('referenceName', $referenceName);
        }
        /*Refereral End */
        /* Multilanguage start*/
        $defaultLanguage = 'en';
        if ($this->uri->segment('1') != 'admin') {
            if ($this->session->userdata('language_code') == '') {
                $CountryArr = $this->product_model->get_all_details(LANGUAGES, array(
                    'status' => 'Active',
                    'default_lang' => 'Default'
                ));
                if ($CountryArr->row()->status == 'Active') {
                    $this->session->set_userdata('language_code', $CountryArr->row()->lang_code);
                    $defaultLanguage = $CountryArr->row()->lang_code;
                } else {
                    $this->session->set_userdata('language_code', 'en');
                    $defaultLanguage = 'en';
                }
            }
            $selectedLanguage = $this->session->userdata('language_code');
            ($selectedLanguage != '') ? $selectedLanguage = $selectedLanguage : $selectedLanguage = 'en';
            $filePath = APPPATH . "language/" . $selectedLanguage . "/" . $selectedLanguage . "_lang.php";
            if ($selectedLanguage != '') {
                if (!(is_file($filePath))) {
                    $this->lang->load($defaultLanguage, $defaultLanguage);
                } else {
                    $this->lang->load($selectedLanguage, $selectedLanguage);
                }
            } else {
                $this->lang->load($defaultLanguage, $defaultLanguage);
            }
        }


        /*if ($_SESSION['language_code'] == 'en') {
            $get_languages = $this->landing_model->get_all_details(LANGUAGES, array(
                'status' => 'Active'
            ));
            //print_r($get_languages);
            $langCode = $get_languages->row()->lang_code;
            $langCode_ar = $get_languages->row()->lang_code_ar;

            $this->data['cmsList'] = $this->db->query('select * from ' . CMS . ' where `lang_code`="' . $langCode . '" and `status`="Publish" and hidden_page="No"');
        } else {
            $get_languages = $this->landing_model->get_all_details(LANGUAGES, array(
                'status' => 'Active'
            ));
            //print_r($get_languages);
            $langCode = $get_languages->row()->lang_code;
            $langCode_ar = $get_languages->row()->lang_code_ar;
            $lang_code_is = 'lang_code_' . $_SESSION['language_code'];
            $this->data['cmsList'] = $this->db->query('select * from ' . CMS . ' where `lang_code`="' . $_SESSION['language_code'] . '" and `status`="Publish" and hidden_page="No"');
        }*/

        /* New cms page added */

        /* Loading Footer Cms*/
        if ($this->session->userdata('language_code') == '') {
            $get_languages         = $this->landing_model->get_all_details(LANGUAGES, array(
                'default_lang' => 'Default',
                'status' => 'Active'
            ));
            $langCode              = $get_languages->row()->lang_code;
            $this->data['cmsList'] = $this->db->query('select * from ' . CMS . ' where `lang_code`="' . $langCode . '" and `status`="Publish" and hidden_page="No"');

            $footer_menus         = $this->landing_model->get_all_details(CMS_TOP_MENU, array());
            $cms_arr=array();
            if($footer_menus->num_rows()>0){
                foreach ($footer_menus->result() as $val){
                    $cmslist=$this->db->query('select * from ' . CMS . ' where `lang_code`="' . $langCode . '" and `status`="Publish" and hidden_page="No" and top_menu_id='.$val->top_menu_id.' order by view_order asc');
                    $cms_arr[$val->top_menu_name]=$cmslist->result_array();
                }
            }
            $this->data['cmsList']=$cms_arr;
            //print_r($cms_arr);
            //exit;

        } else {

            $footer_menus         = $this->landing_model->get_all_details(CMS_TOP_MENU, array());
            $cms_arr=array();
            if($footer_menus->num_rows()>0){
                foreach ($footer_menus->result() as $val){
                    $cmslist=$this->db->query('select * from ' . CMS . ' where `lang_code`="' . $this->session->userdata('language_code') . '" and `status`="Publish" and hidden_page="No" and top_menu_id='.$val->top_menu_id.' order by view_order asc');
                    $cms_arr[$val->top_menu_name]=$cmslist->result_array();
                }
            }
            $this->data['cmsList']=$cms_arr;

            //$this->data['cmsList'] = $this->db->query('select * from ' . CMS . ' where `lang_code`="' . $this->session->userdata('language_code') . '" and `status`="Publish" and hidden_page="No"');
        }

        $this->data['CityDetails'] = $this->city_model->Featured_city();

        /* New cms page added */



        /* Multilanguage end*/
        /* experience module data - check experience module enabled or not */
        $exprienceModuleExist = $this->landing_model->checkModuleStatus('experience');
        $this->data['experienceExistCount'] = $exprienceModuleExist->num_rows();
        /* experience module ends  */
        /* Curreny Check  */
        $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
        $session_admin_mode = $this->session->userdata('session_admin_mode');
        if (($this->checkLogin('A') != "") && ($session_admin_mode == ADMIN)) {
            if ($admin_currencyCode == '') {
                $this->setErrorMessage('error', 'Please choose currency and update');
            }
        }
        $controller = $this->router->fetch_class();
        $this->data['current_controller'] = $controller;
        $this->data['current_class'] =  $this->router->fetch_method();
        /* Curreny Check  */
        /*Privilages Check and Set*/
        $name = $this->session->userdata('fc_session_admin_name');
        $email = $this->session->userdata('fc_session_admin_email');
        if ($name != '' && $email != '') {
            $mode = SUBADMIN;
            if ($name == $this->config->item('admin_name')) {
                $mode = ADMIN;
            }
            $condition = array(
                'admin_name' => $name,
                'email' => $email,
                'is_verified' => 'Yes',
                'status' => 'Active'
            );
            $query = $this->admin_model->get_all_details($mode, $condition);
            if ($query->num_rows() == 1) {
                $priv = unserialize($query->row()->privileges);
                if ($mode == ADMIN) {
                    $admindata = array(
                        'fc_session_admin_privileges' => $priv
                    );
                } else {
                    $admindata = array(
                        'fc_session_admin_privileges' => $priv
                    );
                }
                $this->session->set_userdata($admindata);
            }
        }
        /*End Privilages Check and Set*/

        $user_id = $this->checkLogin('U');
        //for conversation page//
        $page = $this->uri->segment(1);
        //='new_conversation';
        if ($page == 'new_conversation') {
            $bookingNo = $this->uri->segment(2);
            if ($bookingNo != '') {
                $conversationDetails = $this->user_model->get_all_details(MED_MESSAGE, array('bookingNo' => $bookingNo), array(array('field' => 'id', 'type' => 'asc')));
                $productId = ($conversationDetails->row()->productId) ? $conversationDetails->row()->productId : '';
                if ($productId != '') {
                    $product_details = $this->user_model->get_all_details(PRODUCT, array('id' => $productId));
                    $this->db->where('bookingNo', $bookingNo);
                    $this->db->where('receiverId', $user_id);

                    if ($product_details->row()->user_id == $user_id) {
                        $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes', 'host_msgread_status' => 'Yes'));
                    } else {
                        $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes', 'user_msgread_status' => 'Yes'));
                    }
                }
            }
        }
        //for conversation page//

        /*Message counts*/

        $msg_unread_count = 0;
        if ($user_id != '') {
            $sql = " select m.*,p.user_id as host_id from " . MED_MESSAGE . " as m," . PRODUCT . " as p where m.productId=p.id and m.receiverId=" . $user_id . " and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";
            $result = $this->db->query($sql);
            $msg_unread_count = $result->num_rows();
        }
        $this->data['property_msg_count'] = $msg_unread_count;
        $experienceExistCount = $this->data['experienceExistCount'];
        $total_exp = 0;
        $msg_unread_count_exp = 0;
        if ($experienceExistCount > 0) {
            if ($user_id != '') {
                $sql = " select m.*,p.user_id as host_id from " . EXPERIENCE_MED_MSG . " as m," . EXPERIENCE . " as p where m.productId=p.experience_id and m.receiverId=" . $user_id . " and ( ( m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No')) and m.msg_status=0";
                $result = $this->db->query($sql);
                $msg_unread_count_exp = $result->num_rows();
            }
            $total_exp = $msg_unread_count_exp;
        }

        $this->data['experience_msg_count'] = $total_exp;

        /*To find Protocal*/
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        //print_r($_SERVER);
        $this->data['protocol']=$protocol;


    }
    /*     * This function return the session value based on param     */
    public function checkLogin($type = '')
    {
        if ($type == 'A') {
            return $this->session->userdata('fc_session_admin_id');
        } else if ($type == 'N') {
            return $this->session->userdata('fc_session_admin_name');
        } else if ($type == 'M') {
            return $this->session->userdata('fc_session_admin_email');
        } else if ($type == 'P') {
            return $this->session->userdata('fc_session_admin_privileges');
        } else if ($type == 'U') {
			//CHECKING USER IS ACTIVE OR NOT
			//echo 'User ID'.$this->session->userdata('fc_session_user_id');
            return $this->session->userdata('fc_session_user_id');
        } else if ($type == 'T') {
            return $this->session->userdata('fc_session_temp_id');
        }
    }
    /*     * This function set the error message and type in session     */
    public function setErrorMessage($type = '', $msg = '')
    {
        ($type == 'success') ? $msgVal = 'successMsg' : $msgVal = 'errorMsg';
        $this->session->set_flashdata($msgVal, $msg);
        ($type == 'success') ? $msgVal = 'message-green' : $msgVal = 'message-red';
        $this->session->set_flashdata('sErrMSGType', $msgVal);
        $this->session->set_flashdata('sErrMSG', $msg);
    }
    /*     * This function check the admin privileges     */
    public function checkPrivileges($name = '', $right = '')
    {
        $prev       = '0';
        $privileges = $this->session->userdata('fc_session_admin_privileges');
        extract($privileges);
        $userName  = $this->session->userdata('fc_session_admin_name');
        $adminName = $this->config->item('admin_name');
        if ($userName == $adminName) {
            $prev = '1';
        }
        if (isset(${$name}) && is_array(${$name}) && in_array($right, ${$name})) {
            $prev = '1';
        }
        if ($prev == '1') {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /* Generate random string*/
    public function get_rand_str($length = '6')
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
    /*Unsetting array element*/
    public function setPictureProducts($productImage, $position)
    {
        unset($productImage[$position]);
        return $productImage;
    }
    /*Resize the image*/
    public function imageResizeWithSpace($box_w, $box_h, $userImage, $savepath)
    {
        $thumb_file = $savepath . $userImage;
        list($w, $h, $type, $attr) = getimagesize($thumb_file);
        $size = getimagesize($thumb_file);
        switch ($size["mime"]) {
            case "image/jpeg":
                $img = imagecreatefromjpeg($thumb_file);
                break;
            case "image/gif":
                $img = imagecreatefromgif($thumb_file);
                break;
            case "image/png":
                $img = imagecreatefrompng($thumb_file);
                break;
            default:
                $im = false;
                break;
        }
        $new = imagecreatetruecolor($box_w, $box_h);
        if ($new === false) {
            return null;
        }
        $whiteColorIndex = imagecolorexact($new, 255, 255, 255);
        $whiteColor      = imagecolorsforindex($new, $whiteColorIndex);
        imagecolortransparent($new, $whiteColor);
        $fill = imagecolorallocate($new, 064, 064, 064);
        imagefill($new, 0, 0, $fill);
        $hratio = $box_h / imagesy($img);
        $wratio = $box_w / imagesx($img);
        $ratio  = min($hratio, $wratio);
        if ($ratio > 1.0)
            $ratio = 1.0;
        $sy  = floor(imagesy($img) * $ratio);
        $sx  = floor(imagesx($img) * $ratio);
        $m_y = floor(($box_h - $sy) / 2);
        $m_x = floor(($box_w - $sx) / 2);
        if (!imagecopyresampled($new, $img, $m_x, $m_y, 0, 0, $sx, $sy, imagesx($img), imagesy($img))) {
            imagedestroy($new);
            return null;
        }
        imagedestroy($i);
        imagejpeg($new, $thumb_file, 90);
    }
    /*Watermarking the image*/
    public function watermarkimages($uploaddir, $image_name)
    {
        $masterURL = $uploaddir . $image_name;
        header('content-type: image/jpeg');
        $watermark        = imagecreatefrompng('images/watermark3.png');
        $watermark_width  = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        $image            = imagecreatefromjpeg($masterURL);
        $size             = getimagesize($masterURL);
        $dest_x           = $size[0] - $watermark_width - 5;
        $dest_y           = $size[1] - $watermark_height - 500;
        imagecopymerge($image, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height, 20);
        imagejpeg($image, $masterURL);
    }
    /*Image compression*/
   public function compress($source, $destination, $quality)
{
$info = getimagesize($source);
$source=base_url().$source;

if ($info['mime'] == 'image/jpeg') {
$image = imagecreatefromjpeg($source);
imagejpeg($image, $destination, $quality);
}elseif ($info['mime'] == 'image/jpg') {
$image = imagecreatefromjpeg($source);
imagejpeg($image, $destination, $quality);
}elseif ($info['mime'] == 'image/gif') {
$image = imagecreatefromgif($source);
imagegif($image, $destination, $quality);
}elseif ($info['mime'] == 'image/png'){
//echo 'dfdfdf';exit;
// Load a png image with alpha channels
$image = imagecreatefrompng($source);
imagepng($image, $destination);
}else{
$image = imagecreatefromjpeg($source);
imagejpeg($image, $destination, $quality);
}
//echo print_r($image);
return $destination;
}
    public function ImageCompress($source_url, $destination_url, $quality = 50)
    {
        $info     = getimagesize($source_url);
        $savePath = $source_url;
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($savePath);
        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($savePath);
        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($savePath);
        imagejpeg($image, $savePath, $quality);
    }
    public function getImageShape($width, $height, $target_file)
    {
        list($w, $h) = getimagesize($target_file);
        if ($w == $width && $h == $height) {
            $option = "exact";
        } else if ($w > $h) {
            $option = "exact";
        } else if ($w < $h) {
            $option = "exact";
        } else {
            $option = "exact";
        }
        return $option;
    }
    /*--Push Notification for IOS--*/
    public function push_notification($deviceId, $message)
    {
        $deviceId = "d71c5c42cf8bee5e4b56d401b342094c15d77303afd375190077ecbf091ea64a";
        $message  = array(
            'message' => "Test message for Renters succeeded"
        );
        $this->load->library('apns');
        $this->apns->send_push_message($deviceId, $message);
    }
    /*--Push Notification for IOS--*/
    /* override number_format function  starts */
    /*-- this for avoiding the round off calculation of currency based amount calculations --*/
    public function number_format($number, $precision = 2, $separator = '.')
    {
        $numberParts = explode($separator, $number);
        $response    = $numberParts[0];
        if (count($numberParts) > 1) {
            $response .= $separator;
            $response .= substr($numberParts[1], 0, $precision);
        }
        return $response;
    }
    /* override number_format function ends */
    /*nan--added*/
    public function get_review_exp($id)
    {
        $data = $this->product_model->get_avg_review_experience($id);
        return $data;
    }
    /*Get min and max lats*/
    public function get_address_bound($googleAddress = "", $google_map_api = "", $bing_map_api = '')
    {
        /*Sathyaseelan*/
        $address_arr     = array();
        $address_details = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$googleAddress&key=$google_map_api");
        $json            = json_decode($address_details);
        $cou             = count($json->{'results'});
        /*Check if google returns address boundaries*/
        if ($cou > 0) {
            $address_arr['lat']     = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $address_arr['long']    = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            $address_arr['minLat']  = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lat'};
            $address_arr['minLong'] = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'southwest'}->{'lng'};
            $address_arr['maxLat']  = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lat'};
            $address_arr['maxLong'] = $json->{'results'}[0]->{'geometry'}->{'bounds'}->{'northeast'}->{'lng'};
        } else {
            /*if google does not returns any address boundaries then proceed with bing - Better performance*/
            $address_details        = file_get_contents("http://dev.virtualearth.net/REST/v1/Locations?query=$googleAddress&key=$bing_map_api");
            $json                   = json_decode($address_details);
            $boundaryExtracted      = $json->resourceSets[0]->resources[0]->bbox;
            $LatLangExtracted       = $json->resourceSets[0]->resources[0]->point->coordinates;
            $address_arr['lat']     = $LatLangExtracted[0];
            $address_arr['long']    = $LatLangExtracted[1];
            $address_arr['minLat']  = $boundaryExtracted[0];
            $address_arr['minLong'] = $boundaryExtracted[1];
            $address_arr['maxLat']  = $boundaryExtracted[2];
            $address_arr['maxLong'] = $boundaryExtracted[3];
        }
        return $address_arr;
    }
}