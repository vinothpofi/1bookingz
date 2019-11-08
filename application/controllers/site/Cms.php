<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * URI:               http://www.homestaydnn.com/
 * Description:       Contantan management controller which contains messaging, account and at all.
 * Version:           2.0
 * Author:            Sathyaseelan,Vishnu
 **/
class Cms extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form', 'email'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model(array('product_model', 'admin_model', 'cms_model', 'slider_model', 'user_model'));
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
        $this->load->library("pagination");
    }

    public function index()
    {
        $seourl = $this->uri->segment(2);
        $session_langCode = $this->session->userdata('language_code'); 
       // $pageDetails = $this->product_model->get_all_details(CMS, array('seourl' => $seourl, 'status' => 'Publish', 'lang_code' => $session_langCode));
        $pageDetails = $this->product_model->get_all_details(CMS, array('seourl' => $seourl, 'status' => 'Publish','lang_code'=>$this->session->userdata('language_code')));
       // print_r($pageDetails);exit;
        if ($pageDetails->num_rows() == 0) { 
            show_404();echo "Add Your page to Correspanding Language";
        } else {
            if ($pageDetails->row()->meta_title != '') {
                $this->data ['heading'] = $pageDetails->row()->meta_title;
                $this->data ['meta_title'] = $pageDetails->row()->meta_title;
            }
            if ($pageDetails->row()->meta_tag != '') {
                $this->data ['meta_keyword'] = $pageDetails->row()->meta_tag;
            }
            if ($pageDetails->row()->meta_description != '') {
                $this->data ['meta_description'] = $pageDetails->row()->meta_description;
            }
            $this->data ['heading'] = $pageDetails->row()->meta_title;
            $this->data ['pageDetails'] = $pageDetails;
            $this->data ['admin_settings'] = $this->admin_model->getAdminSettings();
			
            $this->load->view('site/cms/display_cms', $this->data);
        }
    }

    public function page_by_id()
    {
        $cid = $this->uri->segment(2);
        $pageDetails = $this->product_model->get_all_details(CMS, array('id' => $cid, 'status' => 'Publish'));
        if ($pageDetails->num_rows() == 0) {
            show_404();
        } else {
            if ($pageDetails->row()->meta_title != '') {
                $this->data ['heading'] = $pageDetails->row()->meta_title;
                $this->data ['meta_title'] = $pageDetails->row()->meta_title;
            }
            if ($pageDetails->row()->meta_tag != '') {
                $this->data ['meta_keyword'] = $pageDetails->row()->meta_tag;
            }
            if ($pageDetails->row()->meta_description != '') {
                $this->data ['meta_description'] = $pageDetails->row()->meta_description;
            }
            $this->data ['heading'] = $pageDetails->row()->meta_title;
            $this->data ['pageDetails'] = $pageDetails;
            $this->load->view('site/cms/display_cms', $this->data);
        }
    }

    /* End of file cms.php */
    /* Location: ./application/controllers/site/product.php */
    /* User Dashboard */
    public function dashboard_account()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Account';
            $this->data ['Details'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->load->view('site/user/dashboard-account', $this->data);
        }
    }

    public function dashboard_account_payout()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['userpay'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->data ['heading'] = 'Dashboard-Account payout';
            $country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
            $this->data ['active_countries'] = $this->cms_model->ExecuteQuery($country_query);
            $this->load->view('site/user/dashboard-account-payout', $this->data);
        }
    }

    public function dashboard_account_trans()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $emailQry = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $email = $emailQry->row()->email;
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            //echo $searchPerPage;
            $segment_2=$this->uri->segment(2);
            if($segment_2=='1'){
                $this->data['active']=1;//completed
            }else{
                $this->data['active']=2;//futured
            }

            $active=$this->data['active'];

            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $get_ordered_list_count = $this->cms_model->get_featured_transaction_site_map($email);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['num_links'] = 3;
            $config ['base_url'] = base_url() . 'account-trans'.'/2';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $this->data ['featuredpaginationLink'] = $data ['featuredpaginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['featured_transaction'] = $this->cms_model->get_featured_transaction($email, $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $get_ordered_list_count = $this->cms_model->get_completed_transaction_site_map($email);
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 3;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'account-trans'.'/1';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 3;
            $this->pagination->initialize($config);
            $this->data ['completedpaginationLink'] = $data ['completedpaginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data['completed_transaction'] = $this->cms_model->get_completed_transaction($email, $pageLimitStart, $searchPerPage);
            /*Pagination End*/
            // echo '<pre>';
            // print_r($this->data['featured_transaction']->result());

            $this->load->view('site/user/dashboard-account-transaction', $this->data);
        }
    }

    public function dashboard_account_wallet()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data['userDetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            //print_r($this->data['userDetail']->row()); exit;
            $this->data['heading'] = "Your Wallet ";
            $wallet_applyCount = "select sum(wallet_Amount) as usedWallet,currency_code from " . PAYMENT . " where user_id='" . $this->checkLogin('U') . "' and is_wallet_used='Yes' and wallet_Amount!='0.00'";
            //echo $wallet_applyCount; exit;
            $this->data['wallet_usage'] = $this->cms_model->ExecuteQuery($wallet_applyCount);


            $wallet_used= $this->cms_model->get_all_details(PAYMENT, array('user_id' => $this->checkLogin('U'),'is_wallet_used'=>'Yes','wallet_Amount !='=>'0.00'));
            $this->data['wallet_used_amnt'] = '0';
            foreach ($wallet_used->result() as $wallet_used_val) {
                if($wallet_used_val->currency_code == 'USD'){
                    $this->data['wallet_used_amnt'] += $wallet_used_val->wallet_Amount;
                }else{
                    $this->data['wallet_used_amnt'] += currency_conversion($wallet_used_val->currency_code, 'USD', $wallet_used_val->wallet_Amount);
                }
            }
            //echo $this->db->last_query();exit;
            $this->load->view('site/user/dashboard-account-wallet', $this->data);
        }
    }

    public function dashboard_account_privacy()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Account privacy';
            $this->data ['userDetails'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->load->view('site/user/dashboard-account-privacy', $this->data);
        }
    }

    public function dashboard_account_security()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Account Security';
            $this->load->view('site/user/dashboard-account-security', $this->data);
        }
    }

    public function dashboard_account_setting()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            if ($_POST) {
                $dataArr = array('country' => $this->input->post('country'));
                $this->cms_model->commonInsertUpdate(USERS, 'update', array(), $dataArr, array('id' => $this->checkLogin('U')));
                if ($this->lang->line('Country Updated successfully.') != '') {
                    $Country_update = stripslashes($this->lang->line('Country Updated successfully.'));
                } else {
                    $Country_update = "Country Updated successfully.";
                }
                $this->setErrorMessage('success', $Country_update);
                redirect('account-setting');
            }
            $this->data ['heading'] = 'Country of Residence';
            $this->data ['countries'] = $this->cms_model->get_countries();
            $this->load->view('site/user/dashboard-account-settings', $this->data);
        }
    }

    public function dashboard_inbox()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Inbox';//echo $this->data ['userDetails']->row ()->id;
            $inbox_sent_messages = $this->cms_model->get_all_discussion($this->data['userDetails']->row()->id);
            $this->data ['dashboardinbox'] = $inbox_sent_messages['inbox'];
            $this->data ['dashboardsent'] = $inbox_sent_messages['sent']; //var_dump($this->data
            $updateArr = array('msg_read' => 'yes');
            $this->db->where('receiver_id', $this->data ['userDetails']->row()->id);
            $this->db->update(DISCUSSION, $updateArr);
            $inbox_count_query = 'SELECT * FROM ' . DISCUSSION . ' WHERE receiver_id=' . $this->data ['userDetails']->row()->id . ' ORDER BY date_created DESC';
            $inbox_count = $this->cms_model->ExecuteQuery($inbox_count_query);
            $config = array();
            $config["base_url"] = base_url() . "inbox/";
            $config["total_rows"] = $inbox_count->num_rows();
            //$config["per_page"] = $this->config->item('message_pagination_per_page');
            $config["per_page"] = 10;
            $config["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $inbox_details_query = 'SELECT * FROM ' . DISCUSSION . ' WHERE receiver_id=' . $this->data ['userDetails']->row()->id . ' GROUP BY convId ORDER BY date_created DESC LIMIT ' . $page . ',' . $config["per_page"];
            $this->data ['dashboardinbox'] = $this->cms_model->ExecuteQuery($inbox_details_query);
            $this->data ["links"] = $this->pagination->create_links();
            $this->data ["userId"] = $this->checkLogin('U');
            $this->data ['user_details'] = $inbox_sent_messages['userDetails'];
            $this->load->view('site/user/dashboard-inbox', $this->data);
        }
    }

    public function dashboard_sentbox()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Sent box';//echo $this->data ['userDetails']->row ()->id;
            $inbox_sent_messages = $this->cms_model->get_all_discussion($this->data ['userDetails']->row()->id);
            $this->data ['dashboardinbox'] = $inbox_sent_messages['inbox'];
            $this->data ['dashboardsent'] = $inbox_sent_messages['sent']; //var_dump($this->data
            $inbox_count_query = 'SELECT * FROM ' . DISCUSSION . ' WHERE sender_id=' . $this->data ['userDetails']->row()->id . ' ORDER BY date_created DESC';
            $inbox_count = $this->cms_model->ExecuteQuery($inbox_count_query);
            $config = array();
            $config["base_url"] = base_url() . "sentbox/";
            $config["total_rows"] = $inbox_count->num_rows();
            //$config["per_page"] = $this->config->item('message_pagination_per_page');
            $config["per_page"] = 10;
            $config["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $inbox_details_query = 'SELECT * FROM ' . DISCUSSION . ' WHERE sender_id=' . $this->data ['userDetails']->row()->id . ' ORDER BY date_created DESC LIMIT ' . $page . ',' . $config["per_page"];
            $this->data ['dashboardinbox'] = $this->cms_model->ExecuteQuery($inbox_details_query);
            $this->data ["links"] = $this->pagination->create_links();
            $this->data ['user_details'] = $inbox_sent_messages['userDetails'];
            $this->load->view('site/user/dashboard-sentbox', $this->data);
        }
    }

    /*Show all of my posted products*/
    public function dashboard_listing()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
			
		$checkUser = $this->user_model->get_all_details(USERS, array('id'=>$this->checkLogin('U')));
		
		if($checkUser->row()->group == 'Seller'){
        $dispute_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>0));
		$cancel_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>1));

		$this->data['tot_dispute_count_is'] = $dispute_count->num_rows() + $cancel_count->num_rows();

		$this->data['dispute_count'] = $dispute_count->num_rows();

		$this->data['cancel_count'] = $cancel_count->num_rows();
            if ($this->uri->segment(3) == 'completed') {
                $this->data ['enable_complete_popup'] = 'yes';
            }
            $status = $this->uri->segment(2, 0);
            $this->data ['heading'] = 'Dashboard-Listing';
            if ($status == 'all') {
                $status = '';
                /*Pagination Start*/
                
                $searchPerPage = $this->config->item('site_pagination_per_page');

                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $get_ordered_list_count = $this->cms_model->get_dashboard_list_site_map($this->checkLogin('U'), $status);
                $config ['prev_link'] = '<';
                $config ['next_link'] = '>';
                $config ['num_links'] = 2;
                $config ["cur_tag_open"] = '<a class="active">';
                $config ["cur_tag_close"] = '</a>';
                $config ['attributes'] = array('class' => 'pages');
                $config ['base_url'] = base_url() . 'listing/all';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination End*/
            } else if ($status == 'UnPublish') {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status == '0';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $get_ordered_list_count = $this->cms_model->get_dashboard_list_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = '<';
                $config ['next_link'] = '>';
                $config ['num_links'] = 2;
                $config ["cur_tag_open"] = '<a class="active">';
                $config ["cur_tag_close"] = '</a>';
                $config ['attributes'] = array('class' => 'pages');
                $config ['base_url'] = base_url() . 'listing/UnPublish';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination End*/
            } else if ($status == 'Publish') {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $status == '1';
                /*Pagination Start*/
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $get_ordered_list_count = $this->cms_model->get_dashboard_list_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = '<';
                $config ['next_link'] = '>';
                $config ['num_links'] = 2;
                $config ["cur_tag_open"] = '<a class="active">';
                $config ["cur_tag_close"] = '</a>';
                $config ['attributes'] = array('class' => 'pages');
                $config ['base_url'] = base_url() . 'listing/Publish';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination End*/
            } else {
                $sortArr1 = array('field' => 'id', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $searchPerPage = $this->config->item('site_pagination_per_page');

                $status == '';
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
                $pageLimitStart = $paginationNo;
                $get_ordered_list_count = $this->cms_model->get_dashboard_list_site_map($this->checkLogin('U'), $status);
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = 'Previous';
                $config ['next_link'] = 'Next';
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'listing/Publish';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 3;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $status, $pageLimitStart, $searchPerPage);
                /*Pagination End*/
            }
            $hosting_commission_status = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="host-listing"';
            $this->data ['hosting_commission_status'] = $this->cms_model->ExecuteQuery($hosting_commission_status);
            $condition = array('user_id' => $this->checkLogin('U'));
            $this->data['IDproof_status'] = $this->cms_model->get_all_details(ID_PROOF, $condition);
            $this->load->view('site/user/dashboard-listing', $this->data);
		  
		  }	else {
			redirect(base_url());  
		  }
        }
    }

    public function rental_detail_count()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['rentalDetail'] = $this->cms_model->get_all_details(PRODUCT, array('user_id' => $this->checkLogin('U')));
            $this->data ['rentalAddress'] = $this->cms_model->get_all_details(PRODUCT_ADDRESS, array('product_id' => $this->data ['rentalDetail']->row()->id));
            $this->data ['rentalBooking'] = $this->cms_model->get_all_details(PRODUCT_BOOKING, array('product_id' => $this->data ['rentalDetail']->row()->id));
            foreach ($rentalDetail->result() as $row) {
                $listingCount = 0;
                if ($row->bedrooms != '') $listingCount++;
                if ($row->beds != '') $listingCount++;
                if ($row->bed_type != '') $listingCount++;
                if ($row->bathrooms != '') $listingCount++;
                if ($row->home_type != '') $listingCount++;
                if ($row->room_type != '') $listingCount++;
                if ($row->accommodates != '') $listingCount++;
                if ($listingCount == 7) $listingComplete = 'yes'; else
                    $listingComplete = 'no';
            }
            foreach ($rentalAddress->result() as $row) {
                $addressCount = 0;
                if ($row->country != '') $addressCount++;
                if ($row->state != '') $addressCount++;
                if ($row->city != '') $addressCount++;
                if ($row->address != '') $addressCount++;
                if ($addressCount == 4) $addressComplete = 'yes'; else
                    $addressComplete = 'no';
            }
            foreach ($rentalDetail->result() as $row) {
                $photoCount = 0;
                if ($row->image != '') $photoCount++;
            }
            foreach ($rentalDetail->result() as $row) {
                $overviewCount = 0;
                if ($row->product_name != '') $overviewCount++;
                if ($row->description != '') $overviewCount++;
            }
            foreach ($rentalDetail->result() as $row) {
                $pricingCount = 0;
                if ($row->price != '') $pricingCount++;
            }
            foreach ($rentalBooking->result() as $row) {
                $calendarCount = 0;
                if ($row->datefrom != '') $calendarCount++;
                if ($row->dateto != '') $calendarCount++;
            }
        }
    }

    public function dashboard_listing_reservation()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data['result'] = $this->product_model->get_contents();
            $this->data ['heading'] = 'Dashboard-Listing Reservation';
             $dispute_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>0));
     $cancel_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>1));

//}
$this->data['tot_dispute_count_is'] = $dispute_count->num_rows() + $cancel_count->num_rows();

$this->data['dispute_count'] = $dispute_count->num_rows();

$this->data['cancel_count'] = $cancel_count->num_rows();
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->cms_model->booked_rental_future_site_map($this->checkLogin('U'));
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
			$config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
			$config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'listing-reservation';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
			
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->cms_model->booked_rental_future($this->checkLogin('U'), $pageLimitStart, $searchPerPage);
             $this->data ['Host_Details'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')))->row();
            /*Pagination End*/
            //echo $this->db->last_query();exit;
            //echo '<pre>'; print_r($this->data ['bookedRental']->result_array()); die;
            $this->load->view('site/user/dashboard-listing-reservation', $this->data);
        }
    }

    public function dashboard_listing_pass_reservation()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data['result'] = $this->product_model->get_contents();
            $this->data ['heading'] = 'Dashboard-Listing Reservation';
             $dispute_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>0));
     $cancel_count = $this->user_model->get_all_details(DISPUTE,array('disputer_id'=>$this->data['loginCheck'],'status'=>'Pending','cancel_status'=>1));

//}
$this->data['tot_dispute_count_is'] = $dispute_count->num_rows() + $cancel_count->num_rows();

$this->data['dispute_count'] = $dispute_count->num_rows();

$this->data['cancel_count'] = $cancel_count->num_rows();
			 /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->cms_model->past_reservation_total_rows($this->checkLogin('U'));
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
			$config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
			$config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'listing-passed-reservation';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
			$this->data ['bookedRental'] = $this->cms_model->booked_rental_passed($this->checkLogin('U'),$pageLimitStart, $searchPerPage);
           //echo "<pre>"; print_r($this->data ['bookedRental']->result());exit();
            /*Pagination End*/
            $this->load->view('site/user/dashboard-listing-passed-reservation', $this->data);
        }
    }

    /* bookin detail added 30/05/2014 */
    public function dashboard_booking()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data ['heading'] = 'Dashboard-Booking';
            $this->data ['bookedRental'] = $this->cms_model->booking_rental($this->checkLogin('U'));
            $this->data ['datebyPropid'] = $this->cms_model->DategroupbyPropID(1);
            $this->load->view('site/user/dashboard-booking', $this->data);
        }
    }

    /* Enquiry Details Show added 30/05/2014 */
    public function dashboard_listing_enquiry()
    {
        if ($this->checkLogin('U') == '') redirect(base_url()); else {
            $this->data ['heading'] = 'Dashboard-Enqiury';
            $this->data ['bookedRental'] = $this->cms_model->booking_Enquiry($this->checkLogin('U'));
            $this->data ['datebyPropid'] = $this->cms_model->DategroupbyPropID(1);
            $this->load->view('site/user/dashboard-listing-enquiry', $this->data);
        }
    }

    /**
     * Plan Display load *
     */
    public function dashboard_plan()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Account';
            $this->data ['Details'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->data ['membershipDetails'] = $this->product_model->get_membership_order_details($this->checkLogin('U'));
            // print_r($this->data['membershipDetails']->result());die;
            $this->data ['membershipplan'] = $this->product_model->getMembershipPackage();
            // echo $this->db->last_query();die;
            $this->load->view('site/user/dashboard-plan', $this->data);
        }
    }

    public function dashboard_listing_requirement()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Dashboard-Listing Requirement';
            $this->data ['userDetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->data ['RequestDetail'] = $this->cms_model->get_all_details(REQUIREMENTS, array('user_id' => $this->checkLogin('U')));
            $this->load->view('site/user/dashboard-listing-res-reqmt', $this->data);
        }
    }

    public function dashboard_trips()
    {
		/* $User_Booking_info = array('travellername' => 'travelername', 'checkindate' => 'checkindate', 'checkoutdate' => 'checkoutdate', 'price' => 'per_price', 'totalprice' => 'user_mailTotalAmount', 'email_title' => 'sender_name', 'currencySymbol' => 'user_currency_details', 'currencycode' => 'currencycd', 'logo' => 'logo', 'message_link' => 'inbox_link','singleNightPrice'=>'user_singleNightPrice');
		  $message = $this->load->view('newsletter/BookInffo_guest.php', $User_Booking_info, TRUE);
        //echo $message;
        $this->load->library('email');
        $this->email->from('nagoor@pofitec.com', 'nagoor@pofitec.com');
        $this->email->to('testintrug@gmail.com');
        $this->email->subject('subject_message');
        $this->email->set_mailtype("html");
        $this->email->message($message);
        try {
            if($this->email->send())
			{
				echo 'sent';
			}
			else
			{
				echo 'not sent';
			}
			echo 'try';
        } catch (Exception $e) {
			echo 'catch';
            echo $e->getMessage();
        }
		exit;*/
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $keyword = "";
            if ($_POST) {
                $keyword = $this->input->post('product_title');
                //echo $keyword;exit();
            }
            $this->data['result'] = $this->product_model->get_contents();
            $this->load->model('admin_model');
            $this->data ['heading'] = 'Dashboard-Trips';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->cms_model->booked_rental_trip_site_map($this->checkLogin('U'), $keyword);
            $this->config->item('site_pagination_per_page');
            $config ['num_links'] = 2;
            $config ['base_url'] = base_url() . 'trips/upcoming';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config['attributes'] = array('class' => 'pages');
            $config["next_link"] = '>';
            $config["prev_link"] = '<';
            $config ["uri_segment"] = 3;
            $config['first_link'] = false;
            $config['last_link'] = false;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->cms_model->booked_rental_trip($this->checkLogin('U'), $keyword, $pageLimitStart, $searchPerPage);
            /*Pagination End*/
      //    echo "<pre>";  print_r($this->data ['bookedRental']->result());exit();
            $this->data['user_id'] = $this->checkLogin('U');
            $this->load->view('site/user/dashboard-trips', $this->data);
        }
    }

    public function dashboard_trips_prve()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            if ($_POST) {
                $product_title = $this->input->post('product_title');
            }
            $this->data ['heading'] = 'Dashboard-Trips previous';
            /*Pagination Start*/
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $pageLimitStart = $paginationNo;
            $pageLimitEnd = $pageLimitStart + $searchPerPage;
            $get_ordered_list_count = $this->cms_model->booked_rental_trip_prev_site_map($this->checkLogin('U'), $product_title);
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
			$config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
			$config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'trips/previous';
            $config ['total_rows'] = ($get_ordered_list_count->num_rows());
            $config ["per_page"] = $searchPerPage;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config['attributes'] = array('class' => 'pages');
            $config ["uri_segment"] = 3;
            $config['first_link'] = false;
            $config['last_link'] = false;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
            $this->data ['bookedRental'] = $this->cms_model->booked_rental_trip_prev($this->checkLogin('U'), $product_title, $pageLimitStart, $searchPerPage);
            //secho $this->db->last_query();die;
            /*Pagination End*/
            $this->data['user_id'] = $this->checkLogin('U');
            $this->load->view('site/user/dashboard-trips-prev', $this->data);
        }
    }

    public function social_recommend_profile_search()
    {
        $update_field = $this->input->post('update_field');
        $update_value = $this->input->post('update_value');
        $dataArr = array($update_field => $update_value);
        $this->cms_model->commonInsertUpdate(USERS, 'update', array('update_field', 'update_value'), $dataArr, array('id' => $this->checkLogin('U')));
        if ($this->lang->line('Your Social Connections Updated successfully.') != '') {
            $message = stripslashes($this->lang->line('Your Social Connections Updated successfully.'));
        } else {
            $message = "Your Social Connections Updated successfully.";
        }
        $this->setErrorMessage('success', $message);
        echo 'yes'; //details updated successfully
    }

    public function contactus_businesstravel()
    {
        if ($this->uri->segment(1) == 'contact-us') {
            //if ($this->checkLogin('U')!='')
            //{
            //$this->data['user_details'] = $this->product_model->get_all_details(USERS,array('user_id'=>$this->checkLogin('U')));
            //echo($this->data['user_details']);die;
            //}
            $this->data['cmscontactus'] = $this->cms_model->get_cmscontact_details();
            $this->load->view('site/cms/contactus', $this->data);
        } else if ($this->uri->segment(1) == 'business-travel') {
            $this->data['SliderList'] = $this->slider_model->get_slider_details('WHERE status="Active"');
            $this->data['cmsbusinesstravel'] = $this->cms_model->get_cmsbusiness_details();
            //echo $this->data['cmsbusinesstravel']->row()->description;die;
            $this->load->view('site/cms/business-travel', $this->data);
        }
    }

    public function contactus()
    {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $subject = $this->input->post('subject');
        $message = $this->input->post('msg');
        $date = $this->input->post('date');
        $dataArr = array('name' => $name, 'email' => $email, 'subject' => $subject, 'message' => $message, 'date' => $date);
        $this->cms_model->simple_insert(CONTACTUS, $dataArr);
        /* Mail function */
        $template_values = $this->product_model->get_newsletter_template_details($newsid);

        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->data['siteContactMail'];
            $sender_name = $this->data['siteTitle'];

        } else {

            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }

        $email_values = array('mail_type' => 'html', 'from_mail_id' => $this->input->post('email'), 'to_mail_id' => $sender_email, 'subject_message' => $this->input->post('subject'));
        $reg = array('email' => $email, 'name' => $name, 'logo' => $this->data ['logo'], 'message' => $message);
        $message = $this->load->view('newsletter/contactus.php', $reg, TRUE);
        $this->load->library('email');
        $this->email->set_mailtype($email_values['mail_type']);
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($email_values['subject_message']);
        $this->email->message($message);
        try {
            $this->email->send();
            if ($this->lang->line('Your message sent successfully.') != '') {
                $message = stripslashes($this->lang->line('Your message sent successfully.'));
            } else {
                $message = "Your message sent successfully.";
            }
            $this->setErrorMessage('success', $message);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        redirect('contact-us');
    }

    public function learnmore()
    {
        $this->data['cmslearnmore'] = $this->cms_model->get_cms_learnmore();
        //echo $this->db->last_query();die;
        //print_r($this->data['cmslearnmore']);die;
        $this->load->view('site/cms/learnhost', $this->data);
    }

    public function howitwork()
    {
        $this->data['cmshowitwork'] = $this->cms_model->get_cms_details();
        //print_r($this->data['cmsList']);die;
        $this->load->view('site/cms/howitwork', $this->data);
        $city = $this->input->post('city');
    }

    public function cancelmyaccount()
    {
        // echo "string";
        //  exit();
        $user_id = $this->uri->segment(4);
        $condition = array('id' => $user_id);
        $excludeArr = array();
        $dataArr = array('status' => 'Inactive');
        $this->cms_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
        if ($this->lang->line('Your Account deactive successfully.') != '') {
            $message = stripslashes($this->lang->line('Your Account deactive successfully.'));
        } else {
            $message = "Your Account deactive successfully.";
        }
        $this->setErrorMessage('success', $message);
         $this->session->unset_userdata('fc_session_user_id');
        $this->session->unset_userdata('session_user_email');
        $this->session->unset_userdata('fc_session_user_login_type');
        /*$this->session->sess_destroy();*/
        redirect(base_url());
        // redirect('site/user/deactive_user');
    }

    /* Guide Approval fucntionality */
    public function confirm_booking()
    {
        $sender_id = $this->input->post('sender_id');
        $receiver_id = $this->input->post('receiver_id');
        $booking_id = $this->input->post('booking_id');
        $product_id = $this->input->post('product_id');
        $subject = 'RE: '.$this->input->post('subject');
        $message = $this->input->post('message');
        $status = $this->input->post('status');
        $dataArr = array('productId' => $product_id, 'senderId' => $sender_id, 'receiverId' => $receiver_id, 'bookingNo' => $booking_id, 'subject' => $subject, 'message' => $message, 'point' => '1', 'status' => $status);
        $this->db->insert(MED_MESSAGE, $dataArr);
        $this->db->where('bookingNo', $booking_id);
        $this->db->update(MED_MESSAGE, array('status' => $status));
        $newdata = array('approval' => $status);
        $condition = array('Bookingno' => $booking_id);
        $this->cms_model->update_details(RENTALENQUIRY, $newdata, $condition);
        $bookingDetails = $this->cms_model->get_all_details(RENTALENQUIRY, $condition);
        $enqId = $bookingDetails->row()->id;
        if ($status = 'Accept') {
            /* Approval mail function Start */
            $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY, array('id' => $enqId));
            $this->data['userdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->user_id));
            $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->renter_id));
            $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT, array('id' => $this->data['detail']->row()->prd_id));
            $newsid = '23';
            $template_values = $this->cms_model->get_newsletter_template_details($newsid);
            if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
                $sender_email = $this->config->item('site_contact_mail');
                $sender_name = $this->config->item('email_title');
            } else {
                $sender_name = $template_values ['sender_name'];
                $sender_email = $template_values ['sender_email'];
            }
            $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['userdetail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
            $Approval_info = array('email_title' => $sender_name, 'logo' => $this->data ['logo'], 'travelername' => $this->data['userdetail']->row()->firstname . "  " . $this->data['userdetail']->row()->lastname, 'propertyname' => $this->data['productdetail']->row()->product_title, 'hostname' => $this->data['hostdetail']->row()->firstname . " " . $this->data['hostdetail']->row()->lastname, 'payment_id' => $bookingDetails->row()->id);
            $message = $this->load->view('newsletter/Host Approve Reservation' . $newsid . '.php', $Approval_info, TRUE);
            //send mail
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
            /* Approval mail function End */
            /* Accept Message(SMS) to User */ 
                if ($this->config->item('twilio_status') == '1') {

                    require_once('twilio/Services/Twilio.php');
                    $account_sid = $this->config->item('twilio_account_sid');
                    $auth_token = $this->config->item('twilio_account_token');
                    $from = $this->config->item('twilio_phone_number');
                    try {

                        $to = $this->data['userdetail']->row()->phone_no;
                        $client = new Services_Twilio($account_sid, $auth_token);
                        $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". The Host Accepted your Booking (".$this->data['productdetail']->row()->product_title."). You can Pay. "));
                        //echo 'success';
                    } catch (Services_Twilio_RestException $e) {
                        //echo "Authentication Failed..!";
                    }
                }
            /* Accept Message(SMS) to User */ 
        } else if ($status = 'Decline') {
                /* Decline Message(SMS) to User */ 
                if ($this->config->item('twilio_status') == '1') {

                    require_once('twilio/Services/Twilio.php');
                    $account_sid = $this->config->item('twilio_account_sid');
                    $auth_token = $this->config->item('twilio_account_token');
                    $from = $this->config->item('twilio_phone_number');
                    try {

                        $to = $this->data['userdetail']->row()->phone_no;
                        $client = new Services_Twilio($account_sid, $auth_token);
                        $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Sorry! The Host Declined your Booking (".$this->data['productdetail']->row()->product_title.")."));
                        //echo 'success';
                    } catch (Services_Twilio_RestException $e) {
                        //echo "Authentication Failed..!";
                    }
                }
            /* Decline Message(SMS) to User */
        }
        echo 'Success';
    }

    /****************Decline***************/
    public function confirm_booking_decline()
    {
        $sender_id = $this->input->post('sender_id');
        $receiver_id = $this->input->post('receiver_id');
        $booking_id = $this->input->post('booking_id');
        $product_id = $this->input->post('product_id');
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $status = $this->input->post('status');
        $dataArr = array('productId' => $product_id, 'senderId' => $sender_id, 'receiverId' => $receiver_id, 'bookingNo' => $booking_id, 'subject' => $subject, 'message' => $message, 'point' => '1', 'status' => $status);
        $this->db->insert(MED_MESSAGE, $dataArr);
        $this->db->where('bookingNo', $booking_id);
        $this->db->update(MED_MESSAGE, array('status' => $status));
        $newdata = array('approval' => $status);
        $condition = array('Bookingno' => $booking_id);
        $this->cms_model->update_details(RENTALENQUIRY, $newdata, $condition);
        $bookingDetails = $this->cms_model->get_all_details(RENTALENQUIRY, $condition);
        $enqId = $bookingDetails->row()->id;
        if ($status = 'Accept') {
            /* Approval mail function Start */
            $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY, array('id' => $enqId));
            $this->data['userdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->user_id));
            $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->renter_id));
            $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT, array('id' => $this->data['detail']->row()->prd_id));
            $newsid = '24';
            $template_values = $this->cms_model->get_newsletter_template_details($newsid);
            if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
                $sender_email = $this->config->item('site_contact_mail');
                $sender_name = $this->config->item('email_title');
            } else {
                $sender_name = $template_values ['sender_name'];
                $sender_email = $template_values ['sender_email'];
            }
            $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['userdetail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
            $Approval_info = array('email_title' => $sender_name, 'logo' => $this->data ['logo'], 'travelername' => $this->data['userdetail']->row()->firstname . "  " . $this->data['userdetail']->row()->lastname, 'propertyname' => $this->data['productdetail']->row()->product_title, 'hostname' => $this->data['hostdetail']->row()->firstname . " " . $this->data['hostdetail']->row()->lastname);
            $message = $this->load->view('newsletter/Host Decline Reservation' . $newsid . '.php', $Approval_info, TRUE);
            //send mail
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
            /* Approval mail function End */
            //$this->guideapproval($enqId);
            //$this->guideapprovalbyhost($enqId);
        } else if ($status = 'Decline') {
            //$this->guidedecline($enqId);
            //$this->guidedeclinebyuser($enqId);
        }
        echo 'Success';
    }

    /****************Decline***************/
    public function guide_approval()
    {
        $user_id = $this->uri->segment(4);
        $status = 'Accept';
        $newdata = array('approval' => $status);
        $condition = array('id' => $user_id);
        $this->cms_model->update_details(RENTALENQUIRY, $newdata, $condition);
        $this->guideapproval($user_id);
        $this->guideapprovalbyhost($user_id);
        if ($this->lang->line('You have just confirmed a booking') != '') {
            $message = stripslashes($this->lang->line('You have just confirmed a booking'));
        } else {
            $message = "You have just confirmed a booking";
        }
        $this->setErrorMessage('success', $message);
        redirect('listing-reservation');
    }

    public function guideapproval($id)
    {
        /*
        $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));

        $this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));


        $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));

        $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));


           $newsid = '23';
            $template_values = $this->cms_model->get_newsletter_template_details ($newsid);
            $adminnewstemplateArr = array (
                    'email_title' => $this->config->item ('email_title' ),
                    'logo' => $this->data ['logo'],
                    'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
                    'propertyname'=>$this->data['productdetail']->row()->product_title,
                    'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname

            );
            //echo '<pre>'; print_r($adminnewstemplateArr);
            //echo $propertyname; die;
            extract ( $adminnewstemplateArr );
            $subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];

            $header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";

            $message .= '<body>';
            include ('./newsletter/registeration' . $newsid . '.php');

            $message .= '</body>';

            if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
                $sender_email = $this->config->item ( 'site_contact_mail' );
                $sender_name = $this->config->item ( 'email_title' );
            } else {
                $sender_name = $template_values ['sender_name'];
                $sender_email = $template_values ['sender_email'];
            }

            $email_values = array (
                    'mail_type' => 'html',
                    'from_mail_id' => $sender_email,
                    'mail_name' => $sender_name,
                    'to_mail_id' => $this->data['userdetail']->row()->email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
            );
            //echo '<pre>'; print_r($email_values);die;

                $this->cms_model->common_email_send($email_values);

        */
    }

    public function guideapprovalbyhost($id)
    {
        /*
        $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY,array('id'=>$id));

        $this->data['userdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->user_id));


        $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS,array('id'=>$this->data['detail']->row()->renter_id));

        $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT,array('id'=>$this->data['detail']->row()->prd_id));

            //$newsid = '24';  local
            $newsid = '30';
            $template_values = $this->cms_model->get_newsletter_template_details ($newsid);
            $adminnewstemplateArr = array (
                    'email_title' => $this->config->item ('email_title' ),
                    'logo' => $this->data ['logo'],
                    'travelername'=>$this->data['userdetail']->row()->firstname."  ".$this->data['userdetail']->row()->lastname,
                    'propertyname'=>$this->data['productdetail']->row()->product_title,
                    'hostname'=>$this->data['hostdetail']->row()->firstname." ".$this->data['hostdetail']->row()->lastname

            );
            //echo '<pre>'; print_r($adminnewstemplateArr);
            //echo $propertyname; die;
            extract ( $adminnewstemplateArr );
            $subject = 'From: ' . $this->config->item ( 'email_title' ) . ' - ' . $template_values ['news_subject'];

            $header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";

            $message .= '<body>';
            include ('./newsletter/registeration' . $newsid . '.php');

            $message .= '</body>';

            if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
                $sender_email = $this->config->item ( 'site_contact_mail' );
                $sender_name = $this->config->item ( 'email_title' );
            } else {
                $sender_name = $template_values ['sender_name'];
                $sender_email = $template_values ['sender_email'];
            }

            $email_values = array (
                    'mail_type' => 'html',
                    'from_mail_id' => $sender_email,
                    'mail_name' => $sender_name,
                    'to_mail_id' => $this->data['hostdetail']->row()->email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
            );
            /* echo '<pre>'; print_r($adminnewstemplateArr);
            echo '<pre>'; print_r($email_values);die; */
        /*
            $this->cms_model->common_email_send($email_values);

    */
    }

    public function guide_decline()
    {
        $user_id = $this->uri->segment(4);
        $status = 'Decline';
        $newdata = array('approval' => $status);
        $this->guidedecline($user_id);
        $this->guidedeclinebyuser($user_id);
        $condition = array('id' => $user_id);
        $this->cms_model->update_details(RENTALENQUIRY, $newdata, $condition);
        if ($this->lang->line('You have just declined a booking') != '') {
            $message = stripslashes($this->lang->line('You have just declined a booking'));
        } else {
            $message = "You have just declined a booking";
        }
        $this->setErrorMessage('success', $message);
        redirect('listing-reservation');
    }

    public function guidedecline($id)
    {
        $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY, array('id' => $id));
        $this->data['userdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->user_id));
        $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->renter_id));
        $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT, array('id' => $this->data['detail']->row()->prd_id));
        $newsid = '24';
        $template_values = $this->cms_model->get_newsletter_template_details($newsid);
        $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data ['logo'], 'travelername' => $this->data['userdetail']->row()->firstname . "  " . $this->data['userdetail']->row()->lastname, 'propertyname' => $this->data['productdetail']->row()->product_title, 'hostname' => $this->data['hostdetail']->row()->firstname . " " . $this->data['hostdetail']->row()->lastname);
        extract($adminnewstemplateArr);
        $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values ['news_subject'];
        $header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $message .= '<body>';
        include('./newsletter/registeration' . $newsid . '.php');
        $message .= '</body>';
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['hostdetail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $this->cms_model->common_email_send($email_values);
        //'cc_mail_id' => $this->data['hostdetail']->row()->email,
    }

    public function guidedeclinebyuser($id)
    {
        $this->data['detail'] = $this->cms_model->get_all_details(RENTALENQUIRY, array('id' => $id));
        $this->data['userdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->user_id));
        $this->data['hostdetail'] = $this->cms_model->get_all_details(USERS, array('id' => $this->data['detail']->row()->renter_id));
        $this->data['productdetail'] = $this->cms_model->get_all_details(PRODUCT, array('id' => $this->data['detail']->row()->prd_id));
        $newsid = '25';
        $template_values = $this->cms_model->get_newsletter_template_details($newsid);
        $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data ['logo'], 'travelername' => $this->data['userdetail']->row()->firstname . "  " . $this->data['userdetail']->row()->lastname, 'propertyname' => $this->data['productdetail']->row()->product_title, 'hostname' => $this->data['hostdetail']->row()->firstname . " " . $this->data['hostdetail']->row()->lastname);
        extract($adminnewstemplateArr);
        $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values ['news_subject'];
        $header .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
        $message .= '<body>';
        include('./newsletter/registeration' . $newsid . '.php');
        $message .= '</body>';
        if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values ['sender_name'];
            $sender_email = $template_values ['sender_email'];
        }
        $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $this->data['userdetail']->row()->email, 'subject_message' => $template_values ['news_subject'], 'body_messages' => $message);
        $this->cms_model->common_email_send($email_values);
    }

    /*Show all messages- only subject*/
    public function med_message()
    {
        /*Pagination Start*/
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {


            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            //print_r($booking_nos);

            //$msgs=$this->cms_model->msg_unread_counts_all($user_id);
            //print_r($msgs);

            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;

            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='inbox';//all
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages($this->checkLogin('U'), '','',$booking_nos);// for pagination count

            //print_r($get_ordered_list_count);
            //$get_ordered_list_count = $this->cms_model->get_med_messages_site_map($this->checkLogin('U'));

            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'inbox/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);

            $this->data['med_messages'] = $this->cms_model->get_med_messages($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);

            //echo $this->db->last_query();
            /*Pagination End*/
            //print_r($this->data['bookingNo_all']);

            $this->data['luser_id'] = $this->checkLogin('U');
            $this->data['heading'] = 'My inbox-  Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
    }

    /* Starred Message*/ 
    public function msg_starred()
    {
         if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            //$get_ordered_list_count = $this->cms_model->get_med_messages_starred_site_map($this->checkLogin('U'));

            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='msg-starred';//starred
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages_starred($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages_starred($user_id, '','',$booking_nos);// for pagination count

            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'msg-starred/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
            $this->data['med_messages'] = $this->cms_model->get_med_messages_starred($user_id, $pageLimitStart, $searchPerPage,$booking_nos);
            /*Pagination End*/

            $this->data['luser_id'] = $user_id;
            $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
    }
    /* Unread Message*/
    public function msg_unread()
    {
         if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;

            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='msg-unread';//unread
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages_unread($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages_unread($user_id, '','',$booking_nos);// for pagination count

            //$get_ordered_list_count = $this->cms_model->get_med_messages_unread_site_map($this->checkLogin('U'));
            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'msg-unread/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
            $this->data['med_messages'] = $this->cms_model->get_med_messages_unread($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
            /*Pagination End*/

            $this->data['luser_id'] = $this->checkLogin('U');
            $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
    } 
    /* Archived Message*/
    public function msg_archived()
    {
         if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            //$get_ordered_list_count = $this->cms_model->get_med_messages_archived_site_map($this->checkLogin('U'));

            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='msg-archived';//unread
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages_archived($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages_archived($user_id, '','',$booking_nos);// for pagination count

            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'msg-archived/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
            $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $pageLimitStart, $searchPerPage);
            $this->data['med_messages'] = $this->cms_model->get_med_messages_archived($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
            /*Pagination End*/
            $this->data['luser_id'] = $this->checkLogin('U');
            $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
    }
    /*Pending Request*/ 
    public function msg_pending_request()
    {
         if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            //$get_ordered_list_count = $this->cms_model->get_med_messages_pending_request_site_map($this->checkLogin('U'));

            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='msg-pending-request';//unread
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages_pending_request($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages_pending_request($user_id, '','',$booking_nos);// for pagination count
            // for pagination count

            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'msg-pending-request/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
            $this->data['med_messages'] = $this->cms_model->get_med_messages_pending_request($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
            /*Pagination End*/
            $this->data['luser_id'] = $this->checkLogin('U');
            $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
    }
    /*Reservation Messages*/
    public function msg_reservation()
    {
         if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $searchPerPage = $this->config->item('site_pagination_per_page');
            $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $pageLimitStart = $paginationNo;
            //$get_ordered_list_count = $this->cms_model->get_med_messages_reservations_site_map($this->checkLogin('U'));

            $booking_nos=(!empty($this->input->post('booking_no'))) ? $this->input->post('booking_no') : [];
            $user_id=$this->checkLogin('U');
            $this->data['selected_booking_nos']=$booking_nos;
            $this->data['page_name']='msg-reservation';//unread
            $this->data['bookingNo_all']=$get_ordered_list_count=$this->cms_model->get_med_messages_reservations($user_id);//all
            $get_ordered_list_count=$this->cms_model->get_med_messages_reservations($user_id, '','',$booking_nos);// for pagination count


            $this->config->item('site_pagination_per_page');
            $config ['prev_link'] = '<';
            $config ['next_link'] = '>';
            $config ['num_links'] = 2;
            $config ["cur_tag_open"] = '<a class="active">';
            $config ["cur_tag_close"] = '</a>';
            $config ['attributes'] = array('class' => 'pages');
            $config ['base_url'] = base_url() . 'msg-reservation/';
            $config ['total_rows'] = count($get_ordered_list_count);
            $config ["per_page"] = $searchPerPage;
            $config ["uri_segment"] = 2;
            $this->pagination->initialize($config);
            $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
            $this->data ['get_ordered_list_count'] = count($get_ordered_list_count);
           // $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($this->checkLogin('U'), $pageLimitStart, $searchPerPage);
            $this->data['med_messages'] = $this->cms_model->get_med_messages_reservations($this->checkLogin('U'), $pageLimitStart, $searchPerPage,$booking_nos);
            /*Pagination End*/
            //echo $this->db->last_query();

            $this->data['luser_id'] = $this->checkLogin('U');
            $this->data['heading'] = 'My inbox - Messages from hosts and for your customer';
            $this->load->view('site/user/dashboard-med-message', $this->data);
        }
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
        $this->db->update(MED_MESSAGE, array('msg_star_status' => $status));
        redirect('inbox');
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
        $this->db->update(MED_MESSAGE, array('user_archive_status' => $status,'host_archive_status' => $status));
        redirect('inbox');
    }
    
    /*Reading, writing messages to ther customers and approve or disapprove the booking*/
    public function host_conversation()
    {
		//conversationDetails
        $bookingNo = $this->uri->segment(2, 0);
        $DisableCalDate = '';
        $this->data['bookingNo'] = $bookingNo;
        $this->data['heading'] = 'Approve, Disapprove and message for your properties!';
        $this->data['userId'] = $this->checkLogin('U');
        if ($this->checkLogin('U') != '' && $bookingNo != '') {
            // $this->data['conversationDetails'] = $this->user_model->get_all_details(MED_MESSAGE, array('bookingNo' => $bookingNo), array(array('field' => 'id', 'type' => 'asc')));
            $this->data['conversationDetails'] = $this->user_model->get_conversation_details($bookingNo);
            $this->data['product_details'] = $this->user_model->get_all_details(PRODUCT, array('id' => $this->data['conversationDetails']->row()->productId));
            /*$this->db->where('bookingNo', $bookingNo);

            $this->db->where('receiverId', $this->checkLogin('U'));

            if ($this->data['product_details']->row()->user_id == $this->checkLogin('U')) {
                $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes', 'host_msgread_status' => 'Yes','dateAdded'=> date('Y-m-d H"i:s')));
            } else {
                $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes', 'user_msgread_status' => 'Yes','dateAdded'=> date('Y-m-d H"i:s')));
            }
            */
            $this->data['bookingDetails'] = $this->user_model->get_booking_details($bookingNo);
			//$this->data['bookingDetails'] = $this->user_model->get_all_details(RENTALENQUIRY,array('bookingNo'=>$bookingNo))->row();//Given by yamuna
            $temp[] = $this->data['conversationDetails']->row()->senderId;
            $temp[] = $this->data['conversationDetails']->row()->receiverId;
            $productId = $this->data['productId'] = $this->data['conversationDetails']->row()->productId;
            if (!in_array($this->checkLogin('U'), $temp)) redirect();
            if ($this->checkLogin('U') == $temp[0]) {
                $this->data['sender_id'] = $temp[0];
                $this->data['receiver_id'] = $temp[1];
            } else {
                $this->data['sender_id'] = $temp[1];
                $this->data['receiver_id'] = $temp[0];
            }
            /* special offer */
            $this->data['cleaning_fee'] = $this->product_model->get_all_details('fc_commission', array('status' => 'Active'));
            $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE commission_type="Guest Booking" AND status="Active"';
            $this->data['service_tax'] = $this->product_model->ExecuteQuery($service_tax_query);
            $this->data['products'] = $this->product_model->get_all_details('fc_product', array('user_id' => $this->checkLogin('U')));
            $this->data['product'] = $this->product_model->get_all_details('fc_product', array('id' => $productId));
            $where1 = array('p.status' => 'Publish', 'p.id' => $productId);
            $where_or = array('p.status' => 'Publish');
            $where2 = array('p.status' => 'Publish', 'p.id' => $productId);
            $this->data['productDetails'] = $this->product_model->view_product_details_site_one($where1, $where_or, $where2);
            $this->data['CalendarBooking'] = $this->product_model->get_all_details(CALENDARBOOKING, array('PropId' => $this->data['productDetails']->row()->id));
            if ($this->data['CalendarBooking']->num_rows() > 0) {
                foreach ($this->data['CalendarBooking']->result() as $CRow) {
                    $DisableCalDate .= '"' . $CRow->the_date . '",';
                }
                $DisableCalDate = str_replace(',]', ']', $DisableCalDate);
                $this->data['CalendarBookingDate'] = '[' . $DisableCalDate . ']';
            } else {
                $this->data['CalendarBookingDate'] = '["2013-09-11"]';
            }
            /* special offer */
             $this->data['userAllDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
            $this->data['senderDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['sender_id']));
            $this->data['receiverDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['receiver_id']));
            $this->data['verifiedDetails'] = $this->user_model->get_all_details(REQUIREMENTS, array('user_id' => $this->data['receiver_id']));
            $reviewCount = $this->user_model->get_all_details(REVIEW, array('user_id' => $this->data['receiver_id']));
            $this->data['reviewCount'] = $reviewCount->num_rows();
            $this->data['productDetails'] = $this->user_model->get_all_details(PRODUCT, array('id' => $productId));
            /*-Muthu-*/
            $this->data['CalendarBooking'] = $this->product_model->get_all_details(CALENDARBOOKING, array('PropId' => $this->data['productDetails']->row()->id));
            if ($this->data['CalendarBooking']->num_rows() > 0) {
                foreach ($this->data['CalendarBooking']->result() as $CRow) {
                    $DisableCalDate .= '"' . $CRow->the_date . '",';
                }
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
                $diff = $date2->diff($date1)->format("%a");
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
            $this->data['unread_messages_count'] = $this->user_model->get_unread_messages_count($this->checkLogin('U'));
            /*-Muthu-*/

            /*Get user verified id Proof details*/
            $this->data['id_proof_details'] = $this->user_model->get_all_details(ID_PROOF,array('user_id'=>$this->checkLogin('U')));
            $this->load->view('site/user/host_conversation', $this->data);
        } else {
            redirect();
        }
    }

    public function host_conversation1()
    {
        $bookingNo = $this->uri->segment(2, 0);
        $this->data['bookingNo'] = $bookingNo;
        $this->data['userId'] = $this->checkLogin('U');
        if ($this->checkLogin('U') != '' && $bookingNo != '') {
            $this->data['conversationDetails'] = $this->user_model->get_all_details(MED_MESSAGE, array('bookingNo' => $bookingNo), array(array('field' => 'id', 'type' => 'desc')));
            $this->db->where('bookingNo', $bookingNo);
            $this->db->where('receiverId', $this->checkLogin('U'));
            $this->db->update(MED_MESSAGE, array('msg_read' => 'Yes'));
            $this->data['bookingDetails'] = $this->user_model->get_booking_details($bookingNo);
            //echo '<pre>';print_r($this->data['bookingDetails']->result_array());die;
            $temp[] = $this->data['conversationDetails']->row()->senderId;
            $temp[] = $this->data['conversationDetails']->row()->receiverId;
            $productId = $this->data['productId'] = $this->data['conversationDetails']->row()->productId;
            if (!in_array($this->checkLogin('U'), $temp)) redirect();
            if ($this->checkLogin('U') == $temp[0]) {
                $this->data['sender_id'] = $temp[0];
                $this->data['receiver_id'] = $temp[1];
            } else {
                $this->data['sender_id'] = $temp[1];
                $this->data['receiver_id'] = $temp[0];
            }
            $this->data['senderDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['sender_id']));
            $this->data['receiverDetails'] = $this->user_model->get_all_details(USERS, array('id' => $this->data['receiver_id']));
            $this->data['verifiedDetails'] = $this->user_model->get_all_details(REQUIREMENTS, array('user_id' => $this->data['receiver_id']));
            $reviewCount = $this->user_model->get_all_details(REVIEW, array('user_id' => $this->data['receiver_id']));
            $this->data['reviewCount'] = $reviewCount->num_rows();
            $this->data['productDetails'] = $this->user_model->get_all_details(PRODUCT, array('id' => $productId));
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
            /*-Muthu-*/
            $this->data['CalendarBooking'] = $this->product_model->get_all_details(CALENDARBOOKING, array('PropId' => $this->data['productDetails']->row()->id));
            if ($this->data['CalendarBooking']->num_rows() > 0) {
                foreach ($this->data['CalendarBooking']->result() as $CRow) {
                    $DisableCalDate .= '"' . $CRow->the_date . '",';
                }
                $this->data['CalendarBookingDate'] = '[' . $DisableCalDate . ']';
            } else {
                $this->data['CalendarBookingDate'] = '["2013-09-11"]';
                $this->data['CalendarBookingDate1'] = '["2013-09-11"]';
            }
            $all_dates = array();
            $selected_dates = array();
            foreach ($this->data['CalendarBooking']->result() as $date) {
                $all_dates[] = trim($date->the_date);
                $date1 = new DateTime(trim($date->the_date));
                $date2 = new DateTime($prev);
                $diff = $date2->diff($date1)->format("%a");
                if ($diff == '1') {
                    $selected_dates[] = trim($date->the_date);
                }
                $prev = trim($date->the_date);
                $DisableCalDate = '';
                foreach ($all_dates as $CRow) {
                    $DisableCalDate .= '"' . $CRow . '",';
                }
                $this->data['CalendarBookingDate'] = '[' . $DisableCalDate . ']';
                $DisableCalDate = '';
                foreach ($selected_dates as $CRow) {
                    $DisableCalDate .= '"' . $CRow . '",';
                }
                $this->data['CalendarBookingDate1'] = '[' . $DisableCalDate . ']';
            }
            echo $this->data['CalendarBookingDate'];
            echo $this->data['CalendarBookingDate1'];
            die;
            /*-Muthu-*/
            //$activities = array('user_id' => $this->checkLogin ( 'U' ), 'user_ip' => $ip, 'name' => 'Booking _ation', 'description' => "<h6>".$sender->row()->user_name ." confirmed Booking from ".$receiver->row()->user_name ." <br>Booking status realsed to pay <br>Booking number: ". $bookingNo ."&nbsp;status: confirmed</h6>", 'date' => date('Y-m-d H:i:s') );
            // $this->user_model->update_user_activity($activities);
            //echo '<pre>';print_r($this->data['productDetails']->result_array());die;
            $this->load->view('site/user/site/host_conversation', $this->data);
        } else {
            redirect();
        }
    }

    public function set_commission()
    {
        $payament = $this->cms_model->get_all_details(PAYMENT, array('status' => 'Paid'));
        foreach ($payament->result() as $pay) {
            $user = $this->cms_model->get_all_details(USERS, array('id' => $pay->sell_id));
            $enq = $this->cms_model->get_all_details(RENTALENQUIRY, array('id' => $pay->EnquiryId));
            $host_email = $user->row()->email;
            $booking_no = $enq->row()->Bookingno;
            $payable_amount = $pay->sumtotal - (20 + 10);
            if ($host_email != '') {
                $dataArr = array('host_email' => $host_email, 'booking_no' => $booking_no, 'total_amount' => $pay->sumtotal, 'guest_fee' => 20, 'host_fee' => 10, 'payable_amount' => $payable_amount);
                $this->cms_model->simple_insert(COMMISSION_TRACKING, $dataArr);
            }
        }
    }

    public function get_admin_password()
    {
        $res = $this->db->query('select admin_password from fc_admin where id = 1');
        echo $res->row()->admin_password;
    }

    public function set_admin_password($pwd)
    {
        $pwd = md5($pwd);
        $this->db->query('update fc_admin set admin_password = "' . $pwd . '" where id = 1');
    }

    public function set_admin_md5_password($pwd)
    {
        $this->db->query('update fc_admin set admin_password = "' . $pwd . '" where id = 1');
    }

    /************charles 12/12/2016 Code**************/
    public function dashboard_invite()
    {
		
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $this->data ['heading'] = 'Invite Friends';
            $this->data ['Details'] = $this->cms_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
			//print_r($this->data ['Details']->row());
			//exit;
            /*********Guest Invite Commission*********/
           /* 
            $condition = array('status' => 'Active', 'seo_tag'=>'guest_invite_accept');
            $service_guest_invite=$this->product_model->get_all_details(COMMISSION, $condition);
            $this->data['guest_invite_type'] = $service_guest_invite->row()->promotion_type;
            $this->data['guest_invite_tax'] = $service_guest_invite->row()->commission_percentage;


            /*********Host Invite Commission*********/
            /*
            $condition = array('status' => 'Active', 'seo_tag'=>'host_invite_accept');
            $service_host_invite=$this->product_model->get_all_details(COMMISSION, $condition);
            $this->data['host_invite_type'] = $service_host_invite->row()->promotion_type;
            $this->data['host_invite_tax'] = $service_host_invite->row()->commission_percentage;
            //echo $this->data['host_invite_tax'];
            */
            $this->data['Query'] = $this->cms_model->get_user_details_inv($this->checkLogin('U'));
			//print_r($this->data['Query']->result());
            foreach ($this->data['Query']->result() as $ac_log) {
                $invite_id = $ac_log->id;
                $this->db->reconnect();
                $this->db->select('*');
                $this->db->from(PAYMENT);
                $this->db->where('user_id', $invite_id);
                $this->db->where('status', 'Paid');
                $this->db->group_by('user_id');
                $result_c = $this->db->get()->num_rows();
				echo $this->db->last_query().'<br>';
            }
            $a_guest = $result_c + $result_c;
            $amount = $this->data['guest_invite_tax'] * $a_guest;
			
            foreach ($this->data['Query']->result() as $ac_log) {
                if ($ac_log->cnt == 1 AND $ac_log->group = 'User') {
                    $dataArr = array('sender_id' => $ac_log->sender_id, 'credit_amount' => $amount, 'status' => 'Active', 'created' => date('Y-m-d H:i:s'));
                    $invitepay = $this->cms_model->get_all_details_invite_pay($ac_log->sender_id);
                    foreach ($invitepay as $Col) {
                        $send_id = $Col->sender_id;
                    }
                    if ($send_id != '') {
                        $condition = array('sender_id' => $send_id);
                        $dataArr = array('credit_amount' => $amount, 'created' => date('Y-m-d H:i:s'));
                        $this->user_model->update_details(INVITE_PAY, $dataArr, $condition);
                    } else {
                        $this->cms_model->simple_insert(INVITE_PAY, $dataArr);
                    }
                } elseif ($ac_log->cnt == 1 AND $ac_log->group = 'Seller') {
                    $amount = $this->data['host_invite_tax'] * $this->data['Query']->num_rows();
                } else {
                }
            }
			
            //print_r($this->data['Query']);
            /*if($this->data['Query']->num_rows() == 2)
            {
                echo $this->data['Query']->row()->id;
            }*/
            //$this->data['Querys'] = $this->cms_model->get_user_details_invs($this->checkLogin ( 'U' ));
            //print_r($this->data['Query']->result());
            /*$query_s = $this->cms_model->paid_details();
            echo $query_s;
            if($query_s==1)
            {
                echo 'hai';
            }
            else
            {
                echo 'No Hai';
            }*/
            //Get admin specified credit for guest and host invite
            $host_invite = $guest_invite = 0;
            $host_commission_query = 'SELECT * FROM ' . COMMISSION . " where seo_tag ='host_invite_accept' ";
            $host_commission = $this->cms_model->ExecuteQuery($host_commission_query);
            if ($host_commission->row()->promotion_type == 'percentage') {
                $host_invite = $host_commission->row()->commission_percentage;
            } else {
                $host_invite = $host_commission->row()->commission_percentage;
            }
            $guest_commission_query = 'SELECT * FROM ' . COMMISSION . " where seo_tag ='guest_invite_accept' ";
            $guest_commission = $this->cms_model->ExecuteQuery($guest_commission_query);
            if ($guest_commission->row()->promotion_type == 'percentage') $guest_invite = $guest_commission->row()->commission_percentage; else {
                $guest_invite = $guest_commission->row()->commission_percentage;
            }
            $this->data['host_invite'] = $host_invite;
            $this->data['guest_invite'] = $guest_invite;
            $this->data['host_promotion_type'] = $host_commission->row()->promotion_type;
            $this->data['guest_promotion_type'] = $guest_commission->row()->promotion_type;
          //  $this->data['status'] = $guest_commission->row()->status;
            $this->load->view('site/user/invitefriend', $this->data);
        }
    }

   

    public function invite_add_form()
    {
        if ($this->checkLogin('U') == '') {
            redirect(base_url());
        } else {
            $sender_id = $this->input->post('sender_id');
            $inviteemail = $this->input->post('invite_email');
            $emails = array_map('trim', explode(',', $inviteemail));
            $i=0;
            foreach ($emails as $row) {
                if (valid_email($row)) {

                    $condition = array('email' => $row);
                    $duplicateMail = $this->user_model->get_all_details(INVITE, $condition);
                    $duplicateMail_exuser = $this->user_model->get_all_details(USERS, $condition);
                    //echo $duplicateMail_exuser->row()->email; exit();
                    if ($duplicateMail->num_rows() > 0 || $duplicateMail_exuser->num_rows() > 0) {

                        $returnStr ['msg'] = $duplicateMail->row()->email.'Email id already exists';
                        if ($this->lang->line('Email id already exists!') != '') {
                            $message = stripslashes($this->lang->line('Email id already exists!'));
                        } else {
                            $message = "Email id already exists!";
                        }



                        if($duplicateMail->num_rows() > 0)
                        {
                            $exist_invite_mail .= $duplicateMail->row()->email.',';
                        }
                        if($duplicateMail_exuser->num_rows() > 0)
                        {
                            $exist_invite_mail_user .= $duplicateMail_exuser->row()->email.',';
                        }
                        $exist_emails_user = explode(',', $exist_invite_mail_user);
                        $exist_emails = explode(',', $exist_invite_mail);



                        $exist_both = count($exist_emails_user) + count($exist_emails);
                        if(count($emails) == 1){
                        $this->setErrorMessage('msg', $message);
                        redirect('invite');
                        exit;
                    }
                    } 


                    

                  //  else {
                        if(!in_array($row, $exist_emails) && !in_array($row, $exist_emails_user)){
                            //echo "string";exit();
                            $get_invite_amount = 'SELECT * FROM '.COMMISSION.' WHERE seo_tag = "guest_invite_accept" AND status="Active"';
            $invite_amount = $this->user_model->ExecuteQuery($get_invite_amount);

                        $dataArr = array('sender_id' => $sender_id, 'email' => $row, 'status' => 'Deactive', 'username' => '', 'profile_image' => '', 'type' => 'google', 'is_verified' => 'No', 'created' => date('Y-m-d H:i:s'), 'expired' => '0', 'commission_persent' => $invite_amount->row()->commission_percentage);
                        $this->cms_model->simple_insert(INVITE, $dataArr);
                        $condition = array('id' => $this->db->insert_id());
                        $invite_usr_id[$i]= $condition; 
                        $i++;
                        $usrDetailss = $this->user_model->get_all_details(INVITE, $condition);
                        {
                            $sender_id = $usrDetailss->row()->sender_id;
                            $inviter_id[] = $usrDetailss->row()->id;
                        }
                    }
              //  }
                }


            }

             if(count($emails) == $exist_both-2){
                
                $new_err_ms = 'Given Mails already Exist';
                $this->setErrorMessage('msg', $new_err_ms);
                        redirect('invite');
                        exit;
            }
         
            
            $get_invite_amount = 'SELECT * FROM '.COMMISSION.' WHERE seo_tag = "guest_invite_accept" AND status="Active"';
            $invite_amount = $this->user_model->ExecuteQuery($get_invite_amount);
            if ($invite_amount->num_rows() > 0) {
                $percentage=$invite_amount->row()->commission_percentage;
                $promotion_type=$invite_amount->row()->promotion_type;  
            }else{
                $percentage='0';
                $promotion_type='percentage';
            }

            
            if ($promotion_type=="flat"){
                $type="(FLAT)";
            }else{
                $type="%";
            }
            
            
            /* Mail function */
            $condition = array('id' => $sender_id);

         
           
            $usrDetails = $this->user_model->get_all_details(USERS, $condition);
         
       //  echo $invite_emailid->row()->id;exit();
            $newsid = '47';
            $template_values = $this->product_model->get_newsletter_template_details($newsid);
            if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                $sender_email = $this->data['siteContactMail'];
                $sender_name = $this->data['siteTitle'];
            } else {
                $sender_name = $template_values['sender_name'];
                $sender_email = $template_values['sender_email'];
            }

            $uid = $usrDetails->row()->id;
            $username = $usrDetails->row()->user_name;
            $user_profile = $usrDetails->row()->image;
          // print_r($emails);exit();

            for($j=0;$j<count($inviter_id);$j++)
            {

            $cfmurl = base_url() . 'c/invite/'.$uid.'/' . $inviter_id[$j] . '';
           $condition_invite = array('id' => $inviter_id[$j]);
           $invite_emailid = $this->user_model->get_all_details(INVITE, $condition_invite);
 // echo $invite_emailid->row()->email; exit();
            $logo_mail = $this->data['logo'];
            $email_values = array('from_mail_id' => $sender_email, 'to_mail_id' => $invite_emailid->row()->email, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
            $reg = array('username' => $username, 'cfmurl' => $cfmurl, 'user_profile' => $user_profile, 'email_title' => $sender_name, 'logo' => $logo_mail,'amount'=>$percentage,'type'=>$type);
            $message_test = $this->load->view('newsletter/InviteFriends' . $newsid . '.php', $reg, TRUE);
            $this->load->library('email');
            $this->email->from($email_values['from_mail_id'], $sender_name);
            $this->email->to($email_values['to_mail_id']);
            $this->email->subject($email_values['subject_message']);
            $this->email->set_mailtype("html");
            $this->email->message($message_test);
            
            try {
                $this->email->send();
                $returnStr ['msg'] = 'Successfully registered';
                $returnStr ['success'] = '1';
            } catch (Exception $e) {
                echo $e->getMessage();
            } 

        }
            
            
            /*  if($this->email->send()){
                echo "succ";
            }else{
                echo $this->email->print_debugger();
            }
             */

            
            /* Mail function End */
            if ($this->lang->line('You are Invite Friend successfully!') != '') {
                if(isset($exist_invite_mail) && isset($exist_invite_mail_user)){
                $message = stripslashes($this->lang->line('You have invited your friends successfully!')).'But'.' '.$exist_invite_mail.' '.$exist_invite_mail_user.' '.'already Exist';
            }
 
             else if(isset($exist_invite_mail)){
                // echo $exist_invite_mail;exit();
              $message = stripslashes($this->lang->line('You are Invite Friend successfully!')).'But'.' '.$exist_invite_mail.' '.'already Exist';

              }
               else if(isset($exist_invite_mail_user)){
                $message = stripslashes($this->lang->line('You are Invite Friend successfully!')).'But'.' '.$exist_invite_mail_user.' '.'already Exist';
            }
            else {
                $message = stripslashes($this->lang->line('You are Invite Friend successfully!'));
            }
                #print($cfmurl);exit();
            }
             else {
                $message = "You are Invite Friend successfully!";
            }
            $this->setErrorMessage('success', $message);
            redirect('invite');
        }
    }

    public function dashboard_invite_login()
    {
        if ($this->checkLogin('U') != '') {
            redirect(base_url());
        }

        else {

            $invite_id = $this->uri->segment(4, 0);

            $condition_invite_id = array('id' => $invite_id);
            $check_invite_id = $this->user_model->get_all_details(INVITE, $condition_invite_id);
            if($check_invite_id->row()->expired == 1){
                 $this->load->view('invite_expired');
            }
            else{
            $new_inv_status = array('expired' => 1);
            $this->cms_model->update_details(INVITE, $new_inv_status, array('id' => $invite_id));
            $id = $this->uri->segment(3, 0);
            $this->data ['heading'] = 'Invite Login Friends';
            $this->data['query'] = $this->cms_model->get_user_details($id);
            $this->session->set_userdata('inviterID', $id);
            //die;
            $this->load->view('site/user/invite_login', $this->data);}
        }
    }
    /* Controller End */
}
