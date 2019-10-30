<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Product management
 * @author Teamtweaks
 *
 */
class Product extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form', 'email', 'file'));
        $this->load->library(array('encrypt', 'form_validation', 'image_lib', 'resizeimage', 'email'));
        $this->load->model('product_model');

        if ($this->checkPrivileges('Properties', $this->privStatus) == FALSE) {
            redirect('admin');
        }
    }
 
    /**
     *
     * This function loads the product list page
     */
    public function index()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            redirect('admin/product/display_product_list');
        }
    }

    /**
     *
     * This function loads the property list page
     */
    public function cancel_booking_payment()
    {
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }
        else
        {
           
            $this->data['heading'] = 'Rental Host Cancellation Payments';
            $condition = array('cancelled','Yes');
            $CustomerDetails = $this->product_model->get_all_cancelled_users(); 
         //   echo "<pre>"   ;
       // print_r($CustomerDetails->result()); exit;
            //echo $this->db->last_query; exit;
            foreach($CustomerDetails->result() as $customer)
            {
                $customer_id = $customer->Bookingno;
                $cancel[] = $this->product_model->get_all_commission_tracking($customer_id);    
                //$this->data['paypalData'][$HostEmail] = $customer->paypal_email;                            
            }
         //  print_r($cancel);exit();
            $this->data['trackingDetails'] = $cancel;
            //$this->data['vehicle_type'] = $type;
//echo "string";exit();
            $this->load->view('admin/product/display_cancel_payment_lists',$this->data);
        }
    }

    public function add_pay_form()
    {
        if ($this->checkLogin('A') == '')
        {
            redirect('admin');
        }
        else {
            $this->data['heading'] = 'Add admin payment';
            
            $sid = $this->uri->segment(4,0);
            $guestid = $this->uri->segment(5,0);
            
            $getGuestEmail=$this->product_model->get_all_details(USERS,array('id'=>$guestid));
            $theEmail_is=$getGuestEmail->row()->email;      
            //echo $theEmail_is; exit;          
            $hostEmailQry = $this->product_model->get_commission_track_id($sid); 
            $product_id = $hostEmailQry->row()->vehicle_id;         
            $hostEmail = $hostEmailQry->row()->host_email;

            $this->data['hostEmail'] = $theEmail_is;          
            $this->data['bookid'] = $sid;
            $this->data['vehicle_type'] = $hostEmailQry->row()->vehicle_type; 

            $rental_booking_details= $this->product_model->get_unpaid_reviewcommission_tracking_details($hostEmail,$sid);       
            $payableAmount = 0;         
            $admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
            
            if(count($rental_booking_details) != 0)
            { 
                foreach($rental_booking_details as $rentals)
                {                   
                    //echo $rentals['user_currencycode'].'|'.$rentals['currency_cron_id'].'<br>';
                    $currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
                    //echo $currencyPerUnitSeller;
                    if($rentals['currency_cron_id']=='' || $rentals['currency_cron_id']==0) { $currencyCronId='';} else { $currencyCronId=$rentals['currency_cron_id']; }
                    if($rentals['dispute_by']=='Host')
                    {
                        if($rentals['user_currencycode']!=$admin_currencyCode)
                        {
                            $re_payable=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['paid_cancel_amount'],$currencyCronId);
                        }
                        else
                        {
                            $re_payable=$rentals['paid_cancel_amount'];
                        }
                    }
                    else
                    {
                        //echo $rentals['cancel_percentage']; exit;
                        if ($rentals['cancel_percentage']!='100')
                        {    
                            //echo $rentals['user_currencycode'].'|'.$admin_currencyCode;       //For moderate and Flexible
                            if($rentals['user_currencycode']!=$admin_currencyCode)
                                {
                                    if(!empty($currencyPerUnitSeller))
                                    {
                                        $rentals['subtot']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['subtotal'],$currencyCronId);
                                        //customised_currency_conversion($currencyPerUnitSeller,$rentals['subtotal']);
                                        $rentals['secdep']=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['secDeposit'],$currencyCronId);
                                        //customised_currency_conversion($currencyPerUnitSeller,$rentals['secDeposit']);
                                        $cancel_amount_toHost = $rentals['subtot']/100 * $rentals['cancel_percentage'];
                                        $cancel_amount=$rentals['subtot']-$cancel_amount_toHost; //to guest
                                        $cancel_amountWithSecDeposit=$cancel_amount+$rentals['secdep']; //to guest
                                        $re_payable= $cancel_amountWithSecDeposit;
                                    }
                                    else
                                    {
                                    $re_payable=0;
                                    }
                                }
                                else
                                {
                                    $cancel_amount_toHost = $rentals['subTotal']/100 * $rentals['cancel_percentage'];
                                    $cancel_amount=$rentals['subTotal']-$cancel_amount_toHost; //to guest
                                    $cancel_amountWithSecDeposit=$cancel_amount+$rentals['secDeposit'];
                                    $re_payable= $cancel_amountWithSecDeposit;
                                }
                        
                        }
                        else
                        { 
                    
                    //If Strict Means only Sec Deposit to Guest
                                if($rentals['user_currencycode']!=$admin_currencyCode)
                                {
                                    if(!empty($currencyPerUnitSeller))
                                    {
                                         $strict_amount=changeCurrency($rentals['user_currencycode'],$admin_currencyCode,$rentals['secDeposit']);//customised_currency_conversion($currencyPerUnitSeller,$rentals['secDeposit']);
                                        $re_payable= $strict_amount;    
                                    }
                                    else
                                    {
                                        $re_payable=0;
                                    }
                                }
                                else
                                {
                                    $strict_amount = $rentals['secDeposit'];
                                    $re_payable = $strict_amount; 
                                    
                                    
                                }
                            
                        }
                    }
                        $payableAmount =  $re_payable; 
                    }
                }           
            //payableAmount
            $this->data['payableAmount'] = $payableAmount;
            $this->data['GuestEmail'] = $theEmail_is;
            $this->load->view('admin/product/add_admin_payment',$this->data);
        }
    }
    public function paypal_Cancelpayment_property()
    {
        /*print_r($this->input->post()); exit;Array ( [amount_from_db] => 680 [vehicle_type] => 4 [amount_to_pay] => 680 [GuestEmail] => testrmisys@gmail.com [booking_number] => VE1500023 [hostEmail] => nagoor@pofitec.com [guestPayPalEmail] => nagoorbuyers@gmail.com ) */
        if ($this->checkLogin('A') == '')
        {
            redirect('admin');
        }
        else
        {       
            $this->load->library('paypal_class');
           // $vehicle_type = $this->input->post('vehicle_type'); 
            $return_url = base_url().'admin/product/paypal_cancelAmount_success_property';
            $cancel_url = base_url().'admin/product/paypal_cancelAmount_cancel_property'; 
            $notify_url = base_url().'admin/product/paypal_cancelAmount_notify_property';
            $item_name = $this->config->item('email_title').' Cancel Booking Payment';
            $totalAmount = $this->input->post('amount_to_pay');
            $guestEmail = $this->input->post('GuestEmail');         
            $BookingNumber = $this->input->post('booking_number');
            $guestPayPalEmail = $this->input->post('guestPayPalEmail');
            $loginUserId = $this->checkLogin('A');
            $quantity = 1;
            $paypal_settings=unserialize($this->config->item('payment_0'));
            $paypal_settings=unserialize($paypal_settings['settings']);

            if($paypal_settings['mode'] == 'sandbox')
            {
                $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            }
            else
            {
                $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
            }

            $ctype = ($paypal_settings['mode'] == 'sandbox')?"USD":"USD";
            $logo = base_url().'images/logo/'.$this->data['logo_img'];

            $this->paypal_class->add_field('currency_code', 'USD'); 
            $this->paypal_class->add_field('image_url',$logo);
            $this->paypal_class->add_field('business',trim($guestPayPalEmail)); /* Business Email -for pay to guest*/
            $this->paypal_class->add_field('return',$return_url); /*Return URL*/
            $this->paypal_class->add_field('cancel_return', $cancel_url); /*Cancel URL*/
            $this->paypal_class->add_field('notify_url', $notify_url); /*Notify url*/
            $this->paypal_class->add_field('custom', $guestEmail.'|'.$totalAmount.'|'.$BookingNumber.'|'.$vehicle_type); /*Custom Values*/
            $this->paypal_class->add_field('item_name', $item_name); /*Product Name*/
            $this->paypal_class->add_field('user_id', $loginUserId);
            $this->paypal_class->add_field('quantity', $quantity);  /*Quantity*/
            $this->paypal_class->add_field('amount', $totalAmount); /*Price*/
            $this->paypal_class->submit_paypal_post(); 
        }
    }
    public function paypal_cancelAmount_success_property(){
        $this->data['txn_id'] = $_REQUEST['txn_id'];
        $custom_values = explode('|',$_REQUEST['custom']);
        $this->data['guestEmail'] = $custom_values[0];
        $paypal_amount = $custom_values[1];
        $booking_number = $custom_values[2];
        $vehicle_type = $custom_values[3];
        $this->data['mc_gross'] = $_REQUEST['mc_gross']; 
        $this->data['currency_code'] = $_REQUEST['mc_currency'];
        $dataArr = array(
                        'customer_email'    =>$this->data['guestEmail'],
                        'transaction_id'    =>$this->data['txn_id'],
                        'amount'            =>$paypal_amount,
                        'status'            =>1,
                        'pay_status'        =>'paid'
                        );

        $this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
        $this->product_model->update_details(COMMISSION_TRACKING, array('paid_canel_status'=>'1'),array('booking_no'=>$booking_number));
        
        $this->setErrorMessage('success','Host Cancel Booking Payment is completed');
        redirect('admin/product/cancel_booking_payment');

        
    }
   public function paypal_cancelAmount_cancel_property()
    {
        $this->setErrorMessage('error','Cancel Property Booking Payment is Failed');
        
        redirect('admin/product/cancel_booking_payment/');
    }
    public function paypal_cancelAmount_notify_property(){
        $this->setErrorMessage('error','From Paypal ipn');
        //$type = end($this->uri->segments);
        redirect('admin/product/cancel_booking_payment/');
    }
    public function add_admin_payment_manual(){
        /*Array ( [hostEmail] => testhost@mailinator.com [bookid] => VE1500024 [transaction_id] => 123456 [amount] => 410.00 [balance_due] => testguest@mailinator.com [vehicle_type] => 4 )  */
        
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
        
        $rental_booking_details= $this->product_model->get_unpaid_reviewcommission_tracking($this->input->post('hostEmail'),$this->input->post('bookid'));
        /*print_r($rental_booking_details); exit;
        Array ( [0] => Array ( [id] => 51 [host_email] => testhost@mailinator.com [rental_type] => 4 [booking_no] => VE1500024 [total_amount] => 410.00 [subtotal] => 200 [guest_fee] => 10.00 [host_fee] => 0.00 [cancel_percentage] => 10 [paid_cancel_amount] => 410 [paid_canel_status] => 0 [booking_walletUse] => 0.00 [listing_walletUse] => 0.00 [payable_amount] => 400.00 [commission_paid_id] => 0 [paid_status] => no [dateAdded] => 2018-08-13 12:10:35 [dispute_by] => Host [disputer_id] => 71 [vehicle_id] => 14 [currencycode] => USD [currencyPerUnitSeller] => 1.00 [secDeposit] => 100.00 [user_currencycode] => USD [currency_cron_id] => 113 [subTotal] => 200 ) ) */
        //$vehicle_type = $this->input->post('vehicle_type'); 
        $payableAmount = 0;
        $admin_currencyCode=$this->session->userdata('fc_session_admin_currencyCode');
        if(count($rental_booking_details) != 0){ 
            foreach($rental_booking_details as $rentals){
                $currencyPerUnitSeller=$rentals['currencyPerUnitSeller'];
                
                if($rentals['dispute_by']=='Host')
                {
                    if($rentals['currencycode']!=$admin_currencyCode){
                        $re_payable = currency_conversion($pro->user_currencycode, $admin_currency_code, $rentals['paid_cancel_amount'],$rentals['currency_cron_id']);
                    }
                    else
                    {
                        $re_payable = $rentals['paid_cancel_amount'];
                    }
                }
                else
                {
                    if($rentals['currencycode']!=$admin_currencyCode){
                        if(!empty($currencyPerUnitSeller))
                        {
                            $rentals['subtot']=customised_currency_conversion($currencyPerUnitSeller,$rentals['subtotal']);
                            
                            $cancel_amount_toGuest = $rentals['subtot']/100 * $rentals['cancel_percentage'];
                            $cancel_amount = $rentals['subtot']-$cancel_amount_toGuest;
                            $re_payable=$cancel_amount;
                        }
                        else
                        {
                        $re_payable=0;
                        }
                    }else{
                        $cancel_amount_toGuest = $rentals['subtotal']/100 * $rentals['cancel_percentage'];
                        $cancel_amount = $rentals['subtotal']-$cancel_amount_toGuest;
                        $re_payable=$cancel_amount;
            
                    }
                }
                                    
                $payableAmount = $re_payable;
                $payableAmountCommi =  $rentals['subtotal']/100 * $rentals['cancel_percentage'];
                
            }
        }

        
            $dataArr = array(
                'customer_email'    =>  $this->input->post('hostEmail'),
                'transaction_id'    =>  $this->input->post('transaction_id'),
                'amount'            => $payableAmount, //in usd
                'status'            => 1,
                'pay_status'        =>"paid" 
            );
            $this->db->insert(CANCEL_PAYMENT_PAID,$dataArr);
            
            $this->db->update(COMMISSION_TRACKING, array('paid_canel_status'=>'1'), array('booking_no'=>$this->input->post('bookid')));

            redirect('admin/product/cancel_booking_payment');
        }
    }
    public function display_product_list()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $name_filter = $_GET['experience_name_filter_val'];
            
            $this->data['heading'] = 'Rentals List';
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
            if ($rep_code != '') {
                $condition = 'where u.rep_code="' . $rep_code . '" group by cit.name order by p.created desc';
            } else {
                $condition = 'group by cit.name order by p.created desc';
            }
            /*-----------------------*/
            $this->load->library('pagination');
            $limit_per_page = 10;
        if($name_filter == ''){
            $Total_properties = $this->db->select('id')->where('product_title LIKE "%'.$name_filter.'%"')->get(PRODUCT)->num_rows();
        }
        else{
             $Total_properties = $this->db->select('id')->get(PRODUCT)->num_rows();
        }
            $start_index = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $config['base_url'] = base_url() . 'admin/product/display_product_list';
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
        if($name_filter == ''){
            $this->data['productList'] = $this->product_model->get_allthe_details($_GET['status'], $_GET['city'], $_GET['checkin'], $_GET['checkout'], $_GET['id'], $rep_code, $limit_per_page, $start_index);
        }
        else{
             $this->data['productList'] = $this->product_model->get_allthe_details_filt($_GET['status'], $_GET['city'], $_GET['checkin'], $_GET['checkout'], $_GET['id'], $rep_code, $limit_per_page, $start_index, $name_filter);
        }
            // echo "<pre>";
            // print_r($this->data['productList']->result());exit();
            $this->data['userdetails'] = $this->product_model->get_particular_details('id,firstname,lastname', USERS, array(), array(array('field' => 'user_name', 'type' => 'asc')));
            $this->data['options'] = $this->product_model->get_search_options($condition);
            $this->load->view('admin/product/display_product_list', $this->data);
        }
    }

    /**
     *
     * This function change the property status, delete the property record
     */
    public function change_product_status_global()
    {
        if ($_POST['exportex'] == 'export') {
            $productList = $this->product_model->get_allthe_details($_POST['search_status'], $_POST['search_city'], $_POST['search_checkin'], $_POST['search_checkout'], $_POST['search_renters']);
            $data['checkin'] = $_POST['search_checkin'];
            $data['checkout'] = $_POST['search_checkout'];
            $data['getCustomerDetails'] = $a = $productList->result_array();
            $this->load->view('admin/product/customerExportExcel', $data);
        } else {
            if ($_POST['checkboxID'] != '') {
                if ($_POST['checkboxID'] == '0') {
                    redirect('admin/product/add_product_form/0');
                } else {
                    redirect('admin/product/add_product_form/' . $_POST['checkboxID']);
                }
            } else {
                if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') {
                    $data = $_POST['checkbox_id'];
                    if (strtolower($_POST['statusMode']) == 'delete') {
                        for ($i = 0; $i < count($data); $i++) {
                            if ($data[$i] == 'on') {
                                unset($data[$i]);
                            }
                        }
                        foreach ($data as $product_id) {
                            if ($product_id != '') {
                                $old_product_details = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
                                $this->product_model->commonDelete(PRODUCT_PHOTOS, array('product_id' => $product_id));
                                $this->product_model->commonDelete(PRODUCT_ADDRESS, array('product_id' => $product_id));
                                $this->product_model->commonDelete(PRODUCT_BOOKING, array('product_id' => $product_id));
                                $this->product_model->commonDelete(SCHEDULE, array('id' => $product_id));
                                $this->update_old_list_values($product_id, array(), $old_product_details);
                                $this->update_user_product_count($old_product_details);
                            }
                        }
                    }
                    $this->product_model->activeInactiveCommon(PRODUCT, 'id');
                    if (strtolower($_POST['statusMode']) == 'delete') {
                        $this->setErrorMessage('success', 'Rental records deleted successfully');
                    } else {
                        $this->setErrorMessage('success', 'Rental records status changed successfully');
                    }
                    redirect('admin/product/display_product_list');
                }
            }
        }
    }

    /**
     *
     * Update the products_count and products in list_values table, when edit or delete products
     * @param Integer $product_id
     * @param Array $list_val_arr
     * @param Array $old_product_details
     */
    public function update_old_list_values($product_id, $list_val_arr, $old_product_details = '')
    {
        if ($old_product_details == '' || count($old_product_details) == 0) {
            $old_product_details = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
        }
        $old_product_list_values = array_filter(explode(',', $old_product_details->row()->list_value));
        if (count($old_product_list_values) > 0) {
            if (!is_array($list_val_arr)) {
                $list_val_arr = array();
            }
            foreach ($old_product_list_values as $old_product_list_values_row) {
                if (!in_array($old_product_list_values_row, $list_val_arr)) {
                    $list_val_details = $this->product_model->get_all_details(LIST_VALUES, array('id' => $old_product_list_values_row));
                    if ($list_val_details->num_rows() == 1) {
                        $product_count = $list_val_details->row()->product_count;
                        $products_in_this_list = $list_val_details->row()->products;
                        $products_in_this_list_arr = array_filter(explode(',', $products_in_this_list));
                        if (in_array($product_id, $products_in_this_list_arr)) {
                            if (($key = array_search($product_id, $products_in_this_list_arr)) !== false) {
                                unset($products_in_this_list_arr[$key]);
                            }
                            $product_count--;
                            $list_update_values = array(
                                'products' => implode(',', $products_in_this_list_arr),
                                'product_count' => $product_count
                            );
                            $list_update_condition = array('id' => $old_product_list_values_row);
                            $this->product_model->update_details(LIST_VALUES, $list_update_values, $list_update_condition);
                        }
                    }
                }
            }
        }
        if ($old_product_details != '' && count($old_product_details) > 0 && $old_product_details->num_rows() == 1) {
            /*** Delete product id from lists which was created by users ***/
            $user_created_lists = $this->product_model->get_user_created_lists($old_product_details->row()->seller_product_id);
            if ($user_created_lists->num_rows() > 0) {
                foreach ($user_created_lists->result() as $user_created_lists_row) {
                    $list_product_ids = array_filter(explode(',', $user_created_lists_row->product_id));
                    if (($key = array_search($old_product_details->row()->seller_product_id, $list_product_ids)) !== false) {
                        unset($list_product_ids[$key]);
                        $update_ids = array('product_id' => implode(',', $list_product_ids));
                        $this->product_model->update_details(LISTS_DETAILS, $update_ids, array('id' => $user_created_lists_row->id));
                    }
                }
            }
            /*** Delete product id from product likes table and decrease the user likes count ***/
            $like_list = $this->product_model->get_like_user_full_details($old_product_details->row()->seller_product_id);
            if ($like_list->num_rows() > 0) {
                foreach ($like_list->result() as $like_list_row) {
                    $likes_count = $like_list_row->likes;
                    $likes_count--;
                    if ($likes_count < 0) $likes_count = 0;
                    $this->product_model->update_details(USERS, array('likes' => $likes_count), array('id' => $like_list_row->id));
                }
                $this->product_model->commonDelete(PRODUCT_LIKES, array('product_id' => $old_product_details->row()->seller_product_id));
            }
            /*** Delete product id from activity, notification and product comment tables ***/
            $this->product_model->commonDelete(USER_ACTIVITY, array('activity_id' => $old_product_details->row()->seller_product_id));
            $this->product_model->commonDelete(NOTIFICATIONS, array('activity_id' => $old_product_details->row()->seller_product_id));
            $this->product_model->commonDelete(PRODUCT_COMMENTS, array('product_id' => $old_product_details->row()->seller_product_id));
        }
    }

    public function update_user_product_count($old_product_details)
    {
        if ($old_product_details != '' && count($old_product_details) > 0 && $old_product_details->num_rows() == 1) {
            if ($old_product_details->row()->user_id > 0) {
                $user_details = $this->product_model->get_all_details(USERS, array('id' => $old_product_details->row()->user_id));
                if ($user_details->num_rows() == 1) {
                    $prod_count = $user_details->row()->products;
                    $prod_count--;
                    if ($prod_count < 0) {
                        $prod_count = 0;
                    }
                    $this->product_model->update_details(USERS, array('products' => $prod_count), array('id' => $old_product_details->row()->user_id));
                }
            }
        }
    }

    /**
     *
     * This function loads the affiliate product list page
     */
    public function display_user_product_list()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Affiliate Product List';
            $this->data['productList'] = $this->product_model->view_notsell_product_details();
            $this->load->view('admin/product/display_user_product_list', $this->data);
        }
    }

    /**
     * this function load add multiple image
     */
    public function dragimageuploadinsert()
    {
        $val = $this->uri->segment(4, 0);
        $this->data['prod_id'] = $val;
        $this->load->view('admin/product/dragndrop', $this->data);
    }

    /**
     *
     *  Inserr the Product using Ajax added 26/05/2014 */
    public function saveAdminDetailPage()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $condition = '';
            $catID = $this->input->post('catID');
            if ($catID == 0) {
                $title = $this->input->post('title');
                $dataArr = array('product_title' => $title, 'instant_pay' => 'No', 'request_to_book' => 'Yes');
                $excludeArr = array('title', 'catID', 'chk');
                $this->product_model->commonInsertUpdate(PRODUCT, 'insert', $excludeArr, $dataArr, $condition);
                $returnArr['resultval'] = $insert_id = $this->db->insert_id();
                $inputArr = array('product_id' => $insert_id);
                $inputArr1 = array('productId' => $insert_id);
                $this->product_model->commonInsertUpdate(PRODUCT_ADDRESS, 'insert', $excludeArr, $inputArr, $condition);
                $this->product_model->commonInsertUpdate(PRODUCT_ADDRESS_NEW, 'insert', $excludeArr, $inputArr1, $condition);
                $this->product_model->commonInsertUpdate(PRODUCT_BOOKING, 'insert', $excludeArr, $inputArr, $condition);
                $this->product_model->commonInsertUpdate(SCHEDULE, 'insert', $excludeArr, array('id' => $insert_id), $condition);
                echo json_encode($returnArr);
            } else {
                $returnArr['resultval'] = $catID;
                echo json_encode($returnArr);
            }
        }
    }

    /** Insert Images **/
    public function OtherDetailInsert()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $title = $this->input->post('val');
            $catID = $this->input->post('catID');
            $chk = $this->input->post('chk');
            $condition = array('id' => $catID);
            /*no currency conversion needed ; admin will process with same experience currency rather than admin currency for this add/edit experience only */
            /*
            if($chk=='price')
            {
                $productData = $this->product_model->get_all_details(PRODUCT,$condition)->row();
                if($productData->currency != $this->data['admin_currency_code'])
                {
                    $title = convertCurrency($this->data['admin_currency_code'],$productData->currency,$title);
                }
            }

            */
            $dataArr = array($chk => $title);
            $excludeArr = array('title', 'catID', 'chk');
            if ($chk == 'price') {
                $this->product_model->update_details(PRODUCT, array($chk => $title), array('id' => $catID));
            } else {
                $this->product_model->update_details(PRODUCT, array($chk => $title), array('id' => $catID));
            }
            $returnArr['resultval'] = $catID . "title" . $chk;
            echo json_encode($returnArr);
        }
    }

    public function DealPriceInsert()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $title = $this->input->post('title');
            $catID = $this->input->post('product_id');
            $chk = $this->input->post('val');
            $condition = array('product_id' => $catID);
            $dataArr = array($chk => $title);
            $dataArr1 = array($title => $this->input->post('val'), 'product_id' => $catID);
            $excludeArr = array('title', 'product_id', 'chk', 'val');
            $productDealPrice = $this->product_model->get_all_details(PRODUCT_DEALPRICE, $condition);
            if ($productDealPrice->num_rows() == 0) {
                $this->product_model->commonInsertUpdate(PRODUCT_DEALPRICE, 'insert', $excludeArr, $dataArr1, array());
            } else {
                $this->product_model->update_details(PRODUCT_DEALPRICE, array($title => $chk), array('product_id' => $catID));
            }
            echo $this->db->last_query();
            die;
            $returnArr['resultval'] = $catID . "title" . $chk;
            echo json_encode($returnArr);
        }
    }

    public function deleteProductImage()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            //echo 'gangatharan';die;
            redirect('admin');
        } else {
            $prdID = $this->input->post('prdID');
            $condition = array('id' => $prdID);
            /*Image Unlink*/
            $photo_details = $this->db->select('*')->from(PRODUCT_PHOTOS)->where('id', $prdID)->get();
            foreach ($photo_details->result() as $image_name) {
                $gambar = $image_name->product_image;
                unlink("server/php/rental/" . $gambar);
                unlink("server/php/rental/mobile/" . $gambar);
            }
            /*Image Unlink*/
            //$this->product_model->commonDelete(PRODUCT_PHOTOS,$condition);
            $this->product_model->commonDelete(PRODUCT_PHOTOS, array('id' => $prdID));
            $returnArr['resultval'] = $prdID;
            echo json_encode($returnArr);
        }
    }

    /**
     * product image insert
     */
    public function InsertProductImage()
    {
        $imageName = @implode(',', $this->input->post('imgUpload'));
        $imageNameNew = @explode(',', $imageName);
        $s = 0;
        foreach ($this->input->post('imgUploadUrl') as $imgUrl) {
            //echo '<br>'.$imgUrl.$imageNameNew[$s]; die;
            copy($imgUrl, './images/product/rentals/' . $imageNameNew[$s]);
            unlink('server/php/files/' . $imageNameNew[$s]);
            unlink('server/php/files/thumbnail/' . $imageNameNew[$s]);
            $s++;
        }
        $prd_id = $this->input->post('prod_id');
        $img_nameurl = $this->input->post('imgUploadUrl');
        $img_name = $this->input->post('imgUpload');
        for ($i = 0; $i < count($img_name); $i++) {
            if (!empty($img_name[$i])) {
                // print_r($img_name[$i]);
                $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $img_name[$i]);
                $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
            } else {
                print_r("File is empty");
                $this->setErrorMessage('error', 'You cannot choose image');
                redirect('admin/product/add_product_form/' . $prd_id);
            }
        }
        redirect('admin/product/add_product_form/' . $prd_id);
    }

    /**
     *
     * This function loads the add new product form
     */
    public function add_product_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Add New Rental';
            $product_id = $this->data['Product_id'] = $this->uri->segment(4, 0);
            $this->data['productAddressData'] = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId' => $product_id));
            $this->data['listDetail'] = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
            $this->data['instant_pay'] = $this->product_model->get_all_details(MODULES_MASTER, array('module_name' => 'payment_option'));
            $this->data['currencyList'] = $this->product_model->get_all_details(CURRENCY, array());
            $this->data['SublistDetail'] = $this->product_model->get_all_details(LIST_SUB_VALUES, array());
            $this->data['listValues'] = $this->product_model->get_all_details(LISTINGS, array('id' => 1));
            $this->data['listchildValues'] = $this->db->select('*')->from('fc_listing_child')->get();
            $this->data['ProductDealPrice'] = $this->product_model->get_all_details(PRODUCT_DEALPRICE, array('product_id' => $product_id));
            $this->data['listSpace'] = $this->product_model->get_all_details(LISTSPACE, array('status' => 'Active'));
            $this->data['listTypeValues'] = $this->product_model->get_all_details(LISTING_TYPES, array('status' => 'Active'));
            $this->data['productOldAddress'] = $this->product_model->get_old_address($product_id);
            $this->data['categoryView'] = $this->product_model->view_category_details();
            $this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST, array('status' => 'Active'), array(array('field' => 'name', 'type' => 'asc')));
            $this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
            $this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
            $this->data['NeiborCity'] = $this->product_model->get_all_details(NEIGHBORHOOD, array('status' => 'Active'));
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
            if ($rep_code != '') {
                $condition = 'where `group`="Seller" and `rep_code`="' . $rep_code . '" and host_status != 1 and status="Active" order by `created` desc';
            } else {
                $condition = 'where status="Active" and host_status != 1 order by `created` desc';
            }
            $this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname,email', USERS, $condition);
            $this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
            $this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES, array('status' => 'Active'));
            $this->data['getCommonFacilityDetails'] = $this->product_model->getCommonFacilityDetails();
            $this->data['getPropertyType'] = $this->product_model->getPropertyType();
            $this->data['getExtraFacilityDetails'] = $this->product_model->getExtraFacilityDetails();
            $this->data['getSpecialFeatureFacilityDetails'] = $this->product_model->getSpecialFeatureFacilityDetails();
            $this->data['getHomeSafetyFacilityDetails'] = $this->product_model->getHomeSafetyFacilityDetails();
            $this->data['imgDetail'] = $this->product_model->get_images($product_id);
            $this->data['membershipplan'] = $this->product_model->getMembershipPackage();
            $listIdArr = array();
            foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                $listIdArr[] = $listCountryValue['list_id'];
            }
            if ($this->data['listNameCnt']->num_rows() > 0) {
                foreach ($this->data['listNameCnt']->result_array() as $listCountryName) {
                    $this->data['listCountryValue'] .= '
					<script language="javascript">
			}
$(function(){
 
    $("#selectall' . $listCountryName['id'] . '").click(function () {
          $(".cb' . $listCountryName['id'] . '").attr("checked", this.checked);
    });
 
    $(".cb' . $listCountryName['id'] . '").click(function(){
 
        if($(".cb' . $listCountryName['id'] . '").length == $(".cb:checked").length) {
            $("#selectall' . $listCountryName['id'] . '").attr("checked", "checked");
        } else {
            $("#selectall' . $listCountryName['id'] . '").removeAttr("checked");
        }
 
    });
});
</script>
				
					
					<div class="dashboard_price_main">
            
            	<div class="dashboard_price">
            
                    <div class="dashboard_price_left"><h3>' . ucfirst($listCountryName['attribute_name']) . '</h3>' . $listCountryName['description'] . '<br /><br /><br />Select All<input type="checkbox" id="selectall' . $listCountryName['id'] . '"/></div><div class="dashboard_price_right"><ul class="facility_listed">';
                    foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                        if ($listCountryValue['list_id'] == $listCountryName['id']) {
                            if (in_array($listCountryValue['id'], $list_valueArr)) {
                                $checkStr = 'checked="checked"';
                            } else {
                                $checkStr = '';
                            }
                            $this->data['listCountryValue'] .= '<li><input type="checkbox" name="list_value[]" class="checkbox_check cb' . $listCountryName['id'] . '" ' . $checkStr . 'value="' . $listCountryValue['id'] . '"/><span>' . ucfirst($listCountryValue['list_value']) . '</span></li>';
                        }
                    }
                    $this->data['listCountryValue'] .= '</ul>
                    </div>                
                </div>             
            </div>';
                }
            }
        }
        $id = $this->uri->segment(4, 0);
        $hotel_id = $this->uri->segment(4);
        if ($hotel_id != '') {
            $condition = array('id' => $hotel_id);
            $condition = array(TOUR . '.id' => $hotel_id);
            $this->data['product_details'] = $this->product_model->view_product1($hotel_id);
        }
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
        $this->load->view('admin/product/add_product', $this->data);
    }

    //add property general information
    public function UpdateProduct()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $product_data = array();
            $facility_list = array();
            $product_name = $this->input->post('product_title');
            $product_name_ar = $this->input->post('product_title_ar');
            $product_id = $this->input->post('prdiii');
            $currency = $this->input->post('currency');
            $instant_pay_post = $this->input->post('instant_pay');
            $request_to_book = $this->input->post('request_to_book');
            if ($instant_pay_post == '') {
                $instant_pay = "No";
            } else {
                $instant_pay = $instant_pay_post;
            }
            if ($request_to_book == 'No' && $instant_pay == 'No') {
                $this->setErrorMessage('failure', 'Please Choose Yes Option');
                redirect('admin/product/add_product_form/' . $product_id);
            }
            $datefrom = date('Y/m/d', strtotime(str_replace('/', '/', $this->input->post('datefrom'))));
            $dateto = date('Y/m/d', strtotime(str_replace('/', '/', $this->input->post('dateto'))));
            $dataArr = array('datefrom' => $datefrom, 'dateto' => $dateto);
            if ($product_name == '') {
                $this->setErrorMessage('error', 'Product name required');
                echo "<script>window.history.go(-1)</script>";
                exit();
            }
            $price = $this->input->post('price');
            if ($price == '') {
                $this->setErrorMessage('error', 'Price required');
                echo "<script>window.history.go(-1)</script>";
                exit();
            } else if ($price <= 0) {
                $this->setErrorMessage('error', 'Price must be greater than zero');
                echo "<script>window.history.go(-1)</script>";
                exit();
            }
            if ($product_id == '') {
                $old_product_details = array();
                $condition = array('product_name' => $product_name,'product_title_ar' => $product_name_ar);
            } else {
                $old_product_details = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
                $condition = array('product_name' => $product_name,'product_title_ar' => $product_name_ar, 'id !=' => $product_id);
            }
            $address_detail = array(
                'address' => $this->input->post('address'),
                'country' => $this->input->post('country'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'street' => $this->input->post('apt'),
                'zip' => $this->input->post('post_code'),
                'lat' => $this->input->post('latitude'),
                'lang' => $this->input->post('longitude'),
                'productId' => $this->input->post('prdiii')
            );
            $address_check = $this->product_model->get_all_details(PRODUCT_ADDRESS_NEW, array('productId' => $product_id));
            if ($address_check->num_rows() != 0) {
                $this->product_model->update_details(PRODUCT_ADDRESS_NEW, $address_detail, array('productId' => $product_id));
            } else {
                $this->product_model->simple_insert(PRODUCT_ADDRESS_NEW, $address_detail);
            }
            $upadte_text = array(
                "description" => $this->input->post("description"),
                "description_ar" => $this->input->post("description_ar"),
                "space" => $this->input->post("space")
            );
            $this->product_model->update_details(PRODUCT, $upadte_text, array("id" => $product_id));
            $listname = $this->input->post('list_name');
            $id = $this->input->post('prdiii');
            $facility = @implode(',', $this->input->post('list_name'));
            $sublist = @implode(',', $this->input->post('sub_list'));
            $facility_list = array('list_name' => $facility, 'sub_list' => $sublist);
            $price_range = '';
            if ($price > 0 && $price < 21) {
                $price_range = '1-20';
            } else if ($price > 20 && $price < 101) {
                $price_range = '21-100';
            } else if ($price > 100 && $price < 201) {
                $price_range = '101-200';
            } else if ($price > 200 && $price < 501) {
                $price_range = '201-500';
            } else if ($price > 500) {
                $price_range = '501+';
            }
            $excludeArr = array("deal_amount", "deal_start_date", "deal_end_date", "gateway_tbl_length", "image", "productID", "changeorder", "status", "attribute_name", "attribute_val", "product_image", "userID", "description", "description_ar", "space", "guest_capacity", "WIFI"
            , "country", "state", "city", "post_code", "property_name", "apt", "address", "feature", "datefrom", "dateto", "expiredate", "listing_option", "google_map", "add_feature", "rentals_policy", "trams_condition", "invoice_template", "confirm_email", "order_email", "imaged", "longitude", "latitude", "imgPriority", "imgtitle", "prd_id", "prdiii", "user_id", "neighborhood", "can_policy,home_type");
            if ($product_id != '') {
                $getProductDetails = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
                $prdStatus = $getProductDetails->row()->status;
                if ($prdStatus == '' || $prdStatus == 'UnPublish') {
                    $product_status = 'UnPublish';
                } else {
                    $product_status = 'Publish';
                }
            }
            $seourl = url_title($product_name, '-', TRUE);
            $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $product_id));
            $seo_count = 1;
            while ($checkSeo->num_rows() > 0) {
                $seourl = $seourl . $seo_count;
                $seo_count++;
                $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $product_id));
            }
            $ImageName = '';
            $list_val_str = '';
            $list_val_arr = $this->input->post('list_value');
            $NeighborhoodStr = @implode(',', $this->input->post('neighborhood'));
            if (is_array($list_val_arr) && count($list_val_arr) > 0) {
                $list_val_str = implode(',', $list_val_arr);
            }
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $security_deposit = $this->input->post('security_deposit');
            if ($product_id == '') {
                $inputArr = array(
                    'created' => mdate($datestring, $time),
                    'seourl' => $seourl,
                    'list_value' => $list_val_str,
                    'price_range' => $price_range,
                    'neighborhood' => $NeighborhoodStr,
                    'user_id' => $this->input->post('user_id'),
                    'cancellation_policy' => $this->input->post('cancellation_policy'),
                    'security_deposit' => $security_deposit,
                    'instant_pay' => $instant_pay,
                    'request_to_book' => $request_to_book,
                    'calendar_checked' => 'sometimes',
                    'seller_product_id' => mktime()
                );
            } else {
                $inputArr = array(
                    'modified' => mdate($datestring, $time),
                    'seourl' => $seourl,
                    'neighborhood' => $NeighborhoodStr,
                    'category_id' => $category_id,
                    'status' => $product_status,
                    'price_range' => $price_range,
                    'list_name' => $list_name_str,
                    'user_id' => $this->input->post('user_id'),
                    'cancellation_policy' => $this->input->post('cancellation_policy'),
                    'security_deposit' => $security_deposit,
                    'instant_pay' => $instant_pay,
                    'request_to_book' => $request_to_book,
                    'calendar_checked' => 'sometimes',
                    'list_value' => $list_val_str
                );
            }
            if ($product_id != '') {
                $this->update_old_list_values($product_id, $list_val_arr, $old_product_details);
            }
            $dataArr = array_merge($inputArr, $product_data, $facility_list, $dataArr);
            $condition = array('id' => $product_id);
            $this->product_model->commonInsertUpdate(PRODUCT, 'update', $excludeArr, $dataArr, $condition);
            $Attr_val_str = '';
            $this->setErrorMessage('success', 'Property added successfully');
            $this->update_price_range_in_table('add', $price_range, $product_id, $old_product_details);
            $condition1 = array('product_id' => $product_id);
            $inputArr1 = array(
                'product_id' => $product_id,
                'country' => $this->input->post('country'),
                'state' => $this->input->post('state'),
                'city' => $this->input->post('city'),
                'post_code' => $this->input->post('post_code'),
                'apt' => $this->input->post('apt'),
                'address' => $this->input->post('address'),
                'latitude' => $this->input->post('latitude'),
                'longitude' => $this->input->post('longitude')
            );
            $this->product_model->update_details(PRODUCT_ADDRESS, $inputArr1, $condition1);
            /*Update the list table*/
            if (is_array($list_val_arr)) {
                foreach ($list_val_arr as $list_val_row) {
                    $list_val_details = $this->product_model->get_all_details(LIST_VALUES, array('id' => $list_val_row));
                    if ($list_val_details->num_rows() == 1) {
                        $product_count = $list_val_details->row()->product_count;
                        $products_in_this_list = $list_val_details->row()->products;
                        $products_in_this_list_arr = explode(',', $products_in_this_list);
                        if (!in_array($product_id, $products_in_this_list_arr)) {
                            array_push($products_in_this_list_arr, $product_id);
                            $product_count++;
                            $list_update_values = array(
                                'products' => implode(',', $products_in_this_list_arr),
                                'product_count' => $product_count
                            );
                            $list_update_condition = array('id' => $list_val_row);
                            $this->product_model->update_details(LIST_VALUES, $list_update_values, $list_update_condition);
                        }
                    }
                }
            }
            /*Update user table count*/
            if ($this->checkLogin('U') != '') {
                $user_details = $this->product_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
                if ($user_details->num_rows() == 1) {
                    $prod_count = $user_details->row()->products;
                    $prod_count++;
                    $this->product_model->update_details(USERS, array('products' => $prod_count), array('id' => $this->checkLogin('U')));
                }
            }
            redirect('admin/product/display_product_list');
        }
    }

    public function update_price_range_in_table($mode = '', $price_range = '', $product_id = '0', $old_product_details = '')
    {
        $list_values = $this->product_model->get_all_details(LIST_VALUES, array('list_value' => $price_range));
        if ($list_values->num_rows() == 1) {
            $products = explode(',', $list_values->row()->products);
            $product_count = $list_values->row()->product_count;
            if ($mode == 'add') {
                if (!in_array($product_id, $products)) {
                    array_push($products, $product_id);
                    $product_count++;
                }
            } else if ($mode == 'edit') {
                $old_price_range = '';
                if ($old_product_details != '' && count($old_product_details) > 0 && $old_product_details->num_rows() == 1) {
                    $old_price_range = $old_product_details->row()->price_range;
                }
                if ($old_price_range != '' && $old_price_range != $price_range) {
                    $old_list_values = $this->product_model->get_all_details(LIST_VALUES, array('list_value' => $old_price_range));
                    if ($old_list_values->num_rows() == 1) {
                        $old_products = explode(',', $old_list_values->row()->products);
                        $old_product_count = $old_list_values->row()->product_count;
                        if (in_array($product_id, $old_products)) {
                            if (($key = array_search($product_id, $old_products)) !== false) {
                                unset($old_products[$key]);
                                $old_product_count--;
                                $updateArr = array('products' => implode(',', $old_products), 'product_count' => $old_product_count);
                                $updateCondition = array('list_value' => $old_price_range);
                                $this->product_model->update_details(LIST_VALUES, $updateArr, $updateCondition);
                            }
                        }
                    }
                    if (!in_array($product_id, $products)) {
                        array_push($products, $product_id);
                        $product_count++;
                    }
                } else if ($old_price_range != '' && $old_price_range == $price_range) {
                    if (!in_array($product_id, $products)) {
                        array_push($products, $product_id);
                        $product_count++;
                    }
                }
            }
            $updateArr = array('products' => implode(',', $products), 'product_count' => $product_count);
            $updateCondition = array('list_value' => $price_range);
            $this->product_model->update_details(LIST_VALUES, $updateArr, $updateCondition);
        }
    }

    public function UpdateProductNew()
    {
        echo "update here all";
    }

    public function savetab1()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            //print_r($_POST);exit;
            $user_id = $this->input->post('user_id');
            $pro_id = $this->input->post('pro_id');
            $price = $this->input->post('price');
            $security_deposit = $this->input->post('security_deposit');
            $product_summary = $this->input->post('product_summary');
            $req = $this->input->post('req');
            $instant = $this->input->post('instant');
            $video_url = $this->input->post('video_url');
            $currency = $this->input->post('currency');
            //currency conversion
            /*
            if($this->data['admin_currency_code']!=$currency){
                $price = convertCurrency($this->data['admin_currency_code'],$currency,$this->input->post('price'));
            }else{
                $price = $this->input->post('price') ;
            }

            if($this->data['admin_currency_code']!=$currency){
                $security_deposit = convertCurrency($this->data['admin_currency_code'],$currency,$this->input->post('security_deposit'));
            }else{
                $security_deposit = $this->input->post('security_deposit') ;
            }
            */
            $cancellation_policy = $this->input->post('cancellation_policy');
            if ($cancellation_policy == 'Strict') {
                $return_amount = 0;
            }
            $cancel_percentage = $this->input->post('cancel_percentage');
            $cancel_description = $this->input->post('cancel_description');
            $cancel_description_ar = $this->input->post('cancel_description_ar');
            if ($pro_id != '') {
                $getProductDetails = $this->product_model->get_all_details(PRODUCT, array('id' => $pro_id));
                $getStatus = $getProductDetails->row()->status;
                if ($getStatus == '' || $getStatus == 'UnPublish') {
                    $status = "UnPublish";
                } else {
                    $status = "Publish";
                }
            }
            $dataArr = array('user_id' => $user_id, 'price' => $price, 'security_deposit' => $security_deposit, 'cancellation_policy' => $cancellation_policy, 'cancel_description' => $cancel_description,'cancel_description_ar' => $cancel_description_ar, 'cancel_percentage' => $cancel_percentage, 'status' => $status, 'description' => $product_summary, 'video_url' => $video_url, 'request_to_book' => $req, 'instant_pay' => $instant, 'currency' => $currency);
            $this->db->where('id', $pro_id)->update('fc_product', $dataArr);
            /**To Update the user as Seller**/
            $userArr = array('group' => 'Seller');
            $this->db->where('id', $user_id)->update('fc_users', $userArr);
            $returnArr['resultval'] = $pro_id;
            echo json_encode($returnArr);
        }
    }

    public function savetab3()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->input->post('pro_id') != '') {
                $pro_id = $this->input->post('pro_id');
            } else {
                $pro_id = $this->input->post('edit_pro_id');
            }
            $list_values = $this->input->post('list_values');
            if ($list_values != '') {
                $combine_list_val = implode(',', $list_values);
                $dataArr = array('list_name' => $combine_list_val);
                $this->db->where('id', $pro_id)->update('fc_product', $dataArr);
                $returnArr['resultval'] = 'Updated';
            } else {
                $returnArr['resultval'] = 'NoVal';
            }
            echo json_encode($returnArr);
        }
    }


    /**Start - Update in listings field as name=>id in fc_product**/
    /* public function Save_Listing_DetailsAdmin()
        {

        //echo "admin ";exit;

        //if ($this->checkLogin('U') != '')
            if ($this->checkLogin('A') != '')

            {
                $catID = $this->input->post('catID');
                $title = $this->input->post('title');
                $chk = $this->input->post('chk');
                //echo "post";print_r($_POST); exit;
                $checkListing = $this->product_model->get_all_details(PRODUCT,array('id'=>$catID));
                $listings_DetailsEncode = $this->product_model->get_all_details(LISTINGS,array('id'=>1))->row();

                $listings_DetailsDecode = json_decode($listings_DetailsEncode->listing_values);
                $listinsJson = json_decode($checkListing->row()->listings);
                if(count($listinsJson) != 0)
                {
                    $resultArr = array();
                    foreach ($listinsJson as $key => $value) {
                    $productListingName[$key] = $key ;
                    $productListingvalue[$key] = $value;
                }
                foreach($listings_DetailsDecode as $lisingTableName => $lisingTablevalue )
                {
                    if( $lisingTableName == $chk )
                    {
                        if($chk == 'minimum_stay'){
                            $this->product_model->update_details(PRODUCT,array('minimum_stay'=>$title),array('id' => $catID));
                            $resultArr[$lisingTableName] = $title;
                        }else if($chk == 'accommodates'){
                            $this->product_model->update_details(PRODUCT,array('accommodates'=>$title),array('id' => $catID));
                            $resultArr[$lisingTableName] = $title;
                        }
                        else{
                            $resultArr[$lisingTableName] = $title;
                    }
                    }
                    else if($lisingTableName == $productListingName[$lisingTableName])
                    {
                        $resultArr[$lisingTableName] = $productListingvalue[$lisingTableName];
                    }
                    else if($lisingTableName != 'minimum_stay' ){
                        $resultArr[$lisingTableName] = '';
                    }
                }


                    $json_result = json_encode($resultArr);
                    $FinalsValues = array('listings'=>$json_result);
                    //print_r($json_result);
                    $this->product_model->update_details(PRODUCT,$FinalsValues,array('id' => $catID));
                echo "firr";echo $this->db->last_query();
                }
                else
                {
                    $listingsRslt = $this->product_model->get_all_details(LISTING_TYPES,array());
                    foreach($listingsRslt->result() as $listing)
                    {
                        //if($listing->name != 'accommodates' && $listing->name != 'can_policy')
                        if($listing->name != 'can_policy')
                        {

                         if( $listing->id == $chk ){
                            if($chk == 'minimum_stay'){
                                $this->product_model->update_details(PRODUCT,array('minimum_stay'=>$title),array('id' => $catID));
                            }else if($chk == 'accommodates'){
                                $this->product_model->update_details(PRODUCT,array('accommodates'=>$title),array('id' => $catID));
                                $resultArr[$lisingTableName] = $title;
                            }
                            else{
                                $resultArr[$listing->id] = $title;
                                }
                        }
                        else if($listing->name != 'minimum_stay' )
                            {
                                $resultArr[$listing->name] = '';
                            }
                        }
                    }
                    //echo "<pre>"; print_r($resultArr); die;
                    $json_result=json_encode($resultArr);
                    $FinalsValues= array('listings'=>$json_result);

                    $this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
                    echo "Secc";echo $this->db->last_query();
                }
            }

    }
     */
    /**End - Update in listings field as name=>id in fc_product**/
    public function savetab4()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->input->post('pro_id') != '') {
                $pro_id = $this->input->post('pro_id');
            } else {
                $pro_id = $this->input->post('edit_pro_id');
            }
            $location = $this->input->post('location');
            $country = $this->input->post('country');
            $state = $this->input->post('state');
            $city = $this->input->post('city');
            $apt = $this->input->post('apt');
            $post_code = $this->input->post('post_code');
            $latitude = $this->input->post('latitude');
            $longitude = $this->input->post('longitude');
            $dataArr = array('address' => $location, 'street' => $apt, 'city' => $city, 'state' => $state, 'country' => $country, 'lat' => $latitude, 'lang' => $longitude, 'zip' => $post_code);
            $dataArr1 = array('country' => $country, 'state' => $state, 'city' => $city, 'post_code' => $post_code, 'address' => $location, 'latitude' => $latitude, 'longitude' => $longitude);
//
            $this->db->where('productId', $pro_id)->update('fc_product_address_new', $dataArr);
            $this->db->where('product_id', $pro_id)->update('fc_product_address', $dataArr1);
            $returnArr['resultval'] = 'Updated';
            echo json_encode($returnArr);
        }
    }


    /**End - Update in listings field as id=>id in fc_product**/
    public function savetab6()
    {
        $returnArr['resultval'] = '';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->input->post('pro_id') != '') {
                $pro_id = $this->input->post('pro_id');
            } else {
                $pro_id = $this->input->post('edit_pro_id');
            }
            $space = $this->input->post('space');
            $other_thingnote = $this->input->post('other_thingnote');
            $house_rules = $this->input->post('house_rules');
            $neighbor_overview = $this->input->post('neighbor_overview');
            $interact_guest = $this->input->post('interact_guest');
            $guest_access = $this->input->post('guest_access');
           // $dataArr = array('space' => $space, 'other_thingnote' => $other_thingnote, 'guest_access' => $guest_access, 'interact_guest' => $interact_guest, 'neighbor_overview' => $neighbor_overview, 'house_rules' => $house_rules);
           // $this->db->where('id', $pro_id)->update('fc_product', $dataArr); already updated in ajax
            $returnArr['resultval'] = 'Updated';
            echo json_encode($returnArr);
        }
    }

    /**
     *
     * This function insert and edit product
     */
    public function insertEditProduct()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $product_data = array();
            $product_name = $this->input->post('product_name');
            $product_id = $this->input->post('productID');
            if ($product_name == '') {
                $this->setErrorMessage('error', 'Product name required');
                echo "<script>window.history.go(-1)</script>";
                exit();
            }
            $price = $this->input->post('price');
            if ($price == '') {
                $this->setErrorMessage('error', 'Price required');
                echo "<script>window.history.go(-1)</script>";
                exit();
            } else if ($price <= 0) {
                $this->setErrorMessage('error', 'Price must be greater than zero');
                echo "<script>window.history.go(-1)</script>";
                exit();
            }
            if ($product_id == '') {
                $old_product_details = array();
                $condition = array('product_name' => $product_name);
            } else {
                $old_product_details = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
                $condition = array('product_name' => $product_name, 'id !=' => $product_id);
            }
            $price_range = '';
            if ($price > 0 && $price < 21) {
                $price_range = '1-20';
            } else if ($price > 20 && $price < 101) {
                $price_range = '21-100';
            } else if ($price > 100 && $price < 201) {
                $price_range = '101-200';
            } else if ($price > 200 && $price < 501) {
                $price_range = '201-500';
            } else if ($price > 500) {
                $price_range = '501+';
            }
            $excludeArr = array("gateway_tbl_length", "image", "productID", "changeorder", "status", "attribute_name", "attribute_val", "product_image", "userID"
            , "country", "state", "city", "post_code", "property_name", "apt", "address", "feature", "datefrom", "dateto", "expiredate", "google_map", "add_feature", "rentals_policy", "trams_condition", "invoice_template", "confirm_email", "order_email", "imaged", "longitude", "latitude", "imgPriority", "imgtitle");
            if ($this->input->post('status') != '') {
                $product_status = 'Publish';
            } else {
                $product_status = 'UnPublish';
            }
            $seourl = url_title($product_name, '-', TRUE);
            $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $product_id));
            $seo_count = 1;
            while ($checkSeo->num_rows() > 0) {
                $seourl = $seourl . $seo_count;
                $seo_count++;
                $checkSeo = $this->product_model->get_all_details(PRODUCT, array('seourl' => $seourl, 'id !=' => $product_id));
            }
            $ImageName = '';
            $list_val_str = '';
            $list_val_arr = $this->input->post('list_value');
            //echo '<pre>';print_r($list_val_arr);die;
            if (is_array($list_val_arr) && count($list_val_arr) > 0) {
                $list_val_str = implode(',', $list_val_arr);
            }
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            if ($product_id == '') {
                $inputArr = array(
                    'created' => mdate($datestring, $time),
                    'seourl' => $seourl,
                    'product_title' => $product_name,
                    'list_value' => $list_val_str,
                    'list_name' => $list_val_str,
                    'price_range' => $price_range,
                    'user_id' => 0,
                    'seller_product_id' => mktime()
                );
            } else {
                $inputArr = array(
                    'modified' => mdate($datestring, $time),
                    'seourl' => $seourl,
                    'product_title' => $product_name,
                    'category_id' => $category_id,
                    'status' => $product_status,
                    'price_range' => $price_range,
                    'list_name' => $list_name_str,
                    'list_value' => $list_val_str
                );
            }
            $logoDirectory = './images/product';
            if (!is_dir($logoDirectory)) {
                mkdir($logoDirectory, 0777);
            }
            //$config['overwrite'] = FALSE;
            $config['remove_spaces'] = FALSE;
            $config['upload_path'] = $logoDirectory;
            $config['allowed_types'] = 'jpg|jpeg|gif|png';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $file_element_name = 'product_image';
            $ImageName_orig_name = '';
            $ImageName_encrypt_name = '';
            $file_element_name = 'product_image';
            $filePRoductUploadData = array();
            $setPriority = 0;
            $imgtitle = $this->input->post('imgtitle');
            if ($this->upload->do_multi_upload('product_image')) {
            }
            // echo "<pre>";print_r($_FILES['product_image']);die;
            $logoDetails = $this->upload->get_multi_upload_data();
            if ($product_id != '') {
                $this->update_old_list_values($product_id, $list_val_arr, $old_product_details);
            }
            $dataArr = array_merge($inputArr, $product_data);
            if ($product_id == '') {
                $condition = array();
                $this->product_model->commonInsertUpdate(PRODUCT, 'insert', $excludeArr, $dataArr, $condition);
                $product_id = $this->product_model->get_last_insert_id();
                $Attr_val_str = '';
                /*$Attr_val_arr = $this->input->post('list_value');
                 if (is_array($Attr_val_arr) && count($Attr_val_arr)>0){
                    for($k=0;$k<sizeof($Attr_val_arr);$k++){
                    $dataSubArr = '';
                    $dataSubArr = array('product_id'=> $product_id,'attr_price'=>$Attr_val_arr[$k]);
                    //echo '<pre>'; print_r($dataSubArr);
                    $this->product_model->add_subproduct_insert($dataSubArr);
                    }
                    }*/
                $this->setErrorMessage('success', 'Host added successfully');
                $product_id = $this->product_model->get_last_insert_id();
                $this->update_price_range_in_table('add', $price_range, $product_id, $old_product_details);
                //echo '<pre>';
                //print_r($excludeArr);print_r($dataArr);print_r($condition);die;
                //echo $this->input->post('status');die;
                if ($product_id == '') {
                    $product_data = array('image' => $ImageName);
                } else {
                    $existingImage = $this->input->post('imaged');
                    $newPOsitionArr = $this->input->post('changeorder');
                    $imagePOsit = array();
                    for ($p = 0; $p < sizeof($existingImage); $p++) {
                        $imagePOsit[$newPOsitionArr[$p]] = $existingImage[$p];
                    }
                    ksort($imagePOsit);
                    foreach ($imagePOsit as $keysss => $vald) {
                        $imgArraypos[] = $vald;
                    }
                    $imagArraypo0 = @implode(",", $imgArraypos);
                    $allImages = $imagArraypo0 . ',' . $ImageName;
                    $product_data = array('image' => $allImages);
                }
                $this->load->library('googlemaps');
                $GeoAddress = str_replace(" ", "+", $this->input->post('address'));
                $CityDateArr = $this->product_model->get_all_details(CITY, array('id' => $this->input->post('city')));
                $protocol=$this->data['protocol'];
                $geocode = file_get_contents($protocol.'maps.google.com/maps/api/geocode/json?address=' . $GeoAddress . ',+' . $CityDateArr->row()->name . ',+' . $this->input->post('post_code') . ',+moroco&sensor=false');
                $output = json_decode($geocode);
                $lat = $output->results[0]->geometry->location->lat;
                $long = $output->results[0]->geometry->location->lng;
                if ($lat == '' || $long == '') {
                    $lat = '32.2133861';
                    $long = '-5.4588187';
                }
                $inputArr1 = array(
                    'product_id' => $product_id,
                    'country' => $this->input->post('country'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'post_code' => $this->input->post('post_code'),
                    'apt' => $this->input->post('apt'),
                    'address' => $this->input->post('address'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude')
                );
                $this->product_model->simple_insert(PRODUCT_ADDRESS, $inputArr1);
                $inputArr2 = array();
                $inputArr2 = array(
                    'product_id' => $product_id,
                    'feature' => $this->input->post('feature'),
                    'google_map' => $this->input->post('google_map'),
                    'add_feature' => $this->input->post('add_feature'),
                    'rentals_policy' => $this->input->post('rentals_policy'),
                    'trams_condition' => $this->input->post('trams_condition'),
                    'confirm_email' => $this->input->post('confirm_email'),
                    'order_email' => $this->input->post('order_email'),
                    'invoice_template' => $this->input->post('invoice_template')
                );
                $this->product_model->simple_insert(PRODUCT_FEATURES, $inputArr2);
                $inputArr3 = array();
                $inputArr3 = array(
                    'product_id' => $product_id,
                    'dateto' => $this->input->post('dateto'),
                    'datefrom' => $this->input->post('datefrom'),
                    'price' => $this->input->post('price'),
                );
                $this->product_model->simple_insert(PRODUCT_BOOKING, $inputArr3);
                $DateArr = $this->GetDays($this->input->post('datefrom'), $this->input->post('dateto'));
                $dateDispalyRowCount = 0;
                if (!empty($DateArr)) {
                    $dateArrVAl .= '{';
                    foreach ($DateArr as $dateDispalyRow) {
                        if ($dateDispalyRowCount == 0) {
                            $dateArrVAl .= '"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"available"}';
                        } else {
                            $dateArrVAl .= ',"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"available"}';
                        }
                        $dateDispalyRowCount = $dateDispalyRowCount + 1;
                    }
                    $dateArrVAl .= '}';
                }
                $inputArr4 = array();
                $inputArr4 = array(
                    'id' => $product_id,
                    'data' => trim($dateArrVAl)
                );
                $this->product_model->simple_insert(SCHEDULE, $inputArr4);
            } else {
                $condition = array('id' => $product_id);
                /*if($this->input->post('prd_id')!=0) {
                 $condition =array('id'=>'182');*/
                $this->product_model->commonInsertUpdate(PRODUCT, 'update', $excludeArr, $dataArr, $condition);
                /*}*/
                /*$Attr_name_str = $Attr_val_str = '';
                 $Attr_name_arr = $this->input->post('product_attribute_name');
                 $Attr_val_arr = $this->input->post('product_attribute_val');
                 if (is_array($Attr_name_arr) && count($Attr_name_arr)>0){
                    for($k=0;$k<sizeof($Attr_name_arr);$k++){
                    $dataSubArr = '';
                    $dataSubArr = array('product_id'=> $product_id,'attr_id'=>$Attr_name_arr[$k],'attr_price'=>$Attr_val_arr[$k]);
                    //echo '<pre>'; print_r($dataSubArr);
                    $this->product_model->add_subproduct_insert($dataSubArr);
                    }
                    }*/
                $condition1 = array('product_id' => $product_id);
                $inputArr1 = array(
                    'product_id' => $product_id,
                    'country' => $this->input->post('country'),
                    'state' => $this->input->post('state'),
                    'city' => $this->input->post('city'),
                    'post_code' => $this->input->post('post_code'),
                    'apt' => $this->input->post('apt'),
                    'address' => $this->input->post('address'),
                    'latitude' => $this->input->post('latitude'),
                    'longitude' => $this->input->post('longitude')
                );
                $this->product_model->update_details(PRODUCT_ADDRESS, $inputArr1, $condition1);
                $inputArr2 = array();
                $inputArr2 = array(
                    'product_id' => $product_id,
                    'feature' => $this->input->post('feature'),
                    'google_map' => $this->input->post('google_map'),
                    'add_feature' => $this->input->post('add_feature'),
                    'rentals_policy' => $this->input->post('rentals_policy'),
                    'trams_condition' => $this->input->post('trams_condition'),
                    'confirm_email' => $this->input->post('confirm_email'),
                    'order_email' => $this->input->post('order_email'),
                    'invoice_template' => $this->input->post('invoice_template')
                );
                $this->product_model->update_details(PRODUCT_FEATURES, $inputArr2, $condition1);
                $DateUpdateCheck = $this->product_model->get_all_details(PRODUCT_BOOKING, array('product_id' => $product_id, 'dateto' => $this->input->post('dateto'), 'datefrom' => $this->input->post('datefrom')));
                if ($DateUpdateCheck->num_rows() == '1') {
                } else {
                    $DateArr = $this->GetDays($this->input->post('datefrom'), $this->input->post('dateto'));
                    $dateDispalyRowCount = 0;
                    if (!empty($DateArr)) {
                        $dateArrVAl .= '{';
                        foreach ($DateArr as $dateDispalyRow) {
                            if ($dateDispalyRowCount == 0) {
                                $dateArrVAl .= '"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"available"}';
                            } else {
                                $dateArrVAl .= ',"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"available"}';
                            }
                            $dateDispalyRowCount = $dateDispalyRowCount + 1;
                        }
                        $dateArrVAl .= '}';
                    }
                    $inputArr4 = array();
                    $inputArr4 = array(
                        'id' => $product_id,
                        'data' => trim($dateArrVAl)
                    );
                    $this->product_model->update_details(SCHEDULE, $inputArr4, array('id' => $product_id));
                }
                $inputArr3 = array();
                $inputArr3 = array(
                    'dateto' => $this->input->post('dateto'),
                    'datefrom' => $this->input->post('datefrom'),
                    'price' => $this->input->post('price'),
                );
                $this->product_model->update_details(PRODUCT_BOOKING, $inputArr3, $condition1);
                $this->setErrorMessage('success', 'Rental updated successfully');
                $this->update_price_range_in_table('edit', $price_range, $product_id, $old_product_details);
            }
            //Update the list table
            if (is_array($list_val_arr)) {
                foreach ($list_val_arr as $list_val_row) {
                    $list_val_details = $this->product_model->get_all_details(LIST_VALUES, array('id' => $list_val_row));
                    if ($list_val_details->num_rows() == 1) {
                        $product_count = $list_val_details->row()->product_count;
                        $products_in_this_list = $list_val_details->row()->products;
                        $products_in_this_list_arr = explode(',', $products_in_this_list);
                        if (!in_array($product_id, $products_in_this_list_arr)) {
                            array_push($products_in_this_list_arr, $product_id);
                            $product_count++;
                            $list_update_values = array(
                                'products' => implode(',', $products_in_this_list_arr),
                                'product_count' => $product_count
                            );
                            $list_update_condition = array('id' => $list_val_row);
                            $this->product_model->update_details(LIST_VALUES, $list_update_values, $list_update_condition);
                        }
                    }
                }
            }
            //upload image the table
            foreach ($logoDetails as $fileVal) {
                @copy('./images/product/' . $fileVal['file_name'], './images/product/thumb/' . $fileVal['file_name']);
                if (!$this->imageResizeWithSpace(300, 200, $fileVal['file_name'], './images/product/thumb/')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $sliderUploadedData = array($this->upload->data());
                }
                $imagePriority = $this->input->post('imgPriority');
                $filePRoductUploadData = array('product_id' => $product_id, 'imgtitle' => $imgtitle[$setPriority], 'product_image' => $fileVal['file_name'], 'imgPriority' => $imagePriority[$setPriority]);
                $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
                $setPriority = $setPriority + 1;
            }
            //Update user table count
            if ($this->checkLogin('U') != '') {
                $user_details = $this->product_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
                if ($user_details->num_rows() == 1) {
                    $prod_count = $user_details->row()->products;
                    $prod_count++;
                    $this->product_model->update_details(USERS, array('products' => $prod_count), array('id' => $this->checkLogin('U')));
                }
            }
            redirect('admin/product/display_product_list');
        }
    }

    public function GetDays($sStartDate, $sEndDate)
    {
        // Firstly, format the provided dates.
        // This function works best with YYYY-MM-DD
        // but other date formats will work thanks
        // to strtotime().
        $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));
        $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));
        // Start the variable off with the start date
        $aDays[] = $sStartDate;
        // Set a 'temp' variable, sCurrentDate, with
        // the start date - before beginning the loop
        $sCurrentDate = $sStartDate;
        // While the current date is less than the end date
        while ($sCurrentDate < $sEndDate) {
            // Add a day to the current date
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));
            // Add this new day to the aDays array
            $aDays[] = $sCurrentDate;
        }
        // Once the loop has finished, return the
        // array of days.
        return $aDays;
    }

    /**Start - Update in listings field as id=>id in fc_product**/
    public function Save_Listing_DetailsAdmin()
    {
        //echo "admin ";exit;
        //if ($this->checkLogin('U') != '')
        if ($this->checkLogin('A') != '') {

            $catID = $this->input->post('catID');
            $title = $this->input->post('title');
            $chk = $this->input->post('chk');
           // echo "post";print_r($_POST); exit;
            $checkListing = $this->product_model->get_all_details(PRODUCT, array('id' => $catID));
            /* $listings_DetailsEncode = $this->product_model->get_all_details(LISTINGS,array('id'=>1))->row();
                $listings_DetailsDecode = json_decode($listings_DetailsEncode->listing_values); */
            $listingsRsltEd = $this->product_model->get_all_details(LISTING_TYPES, array());
            $listinsJson = json_decode($checkListing->row()->listings);
            if (count($listinsJson) != 0) {
                $resultArr = array();
                foreach ($listinsJson as $key => $value) {
                    $productListingName[$key] = $key;
                    $productListingvalue[$key] = $value;
                }
                //foreach($listings_DetailsDecode as $lisingTableName => $lisingTablevalue )
                foreach ($listingsRsltEd->result() as $lisingTableName) {
                    if ($lisingTableName->id == $chk) {
                        if ($chk == '30') { //minimum_stay
                            $this->product_model->update_details(PRODUCT, array('minimum_stay' => $title), array('id' => $catID));
                            $resultArr[$lisingTableName->id] = $title;
                        } else if ($chk == '31') { //accommodates
                            $this->product_model->update_details(PRODUCT, array('accommodates' => $title), array('id' => $catID));
                            $resultArr[$lisingTableName->id] = $title;
                        } else {
                            $resultArr[$lisingTableName->id] = $title;
                        }
                    } else if ($lisingTableName->id == $productListingName[$lisingTableName->id]) {
                        $resultArr[$lisingTableName->id] = $productListingvalue[$lisingTableName->id];
                    } else if ($lisingTableName->id != '30') {
                        $resultArr[$lisingTableName->id] = '';
                    }
                }
                $json_result = json_encode($resultArr);
                $FinalsValues = array('listings' => $json_result);
                //print_r($json_result);
                $this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
                //echo "firr";echo $this->db->last_query();
            } else {
                $listingsRslt = $this->product_model->get_all_details(LISTING_TYPES, array());
                foreach ($listingsRslt->result() as $listing) {
                    //if($listing->name != 'accommodates' && $listing->name != 'can_policy')
                    //if($listing->name != 'can_policy') can_policy not in listing_types
                    //{
                    if ($listing->id == $chk) {
                        if ($chk == '30') { //minimum_stay
                            $this->product_model->update_details(PRODUCT, array('minimum_stay' => $title), array('id' => $catID));
                        } else if ($chk == '31') { //accommodates
                            $this->product_model->update_details(PRODUCT, array('accommodates' => $title), array('id' => $catID));
                            $resultArr[$lisingTableName] = $title;
                        } else {
                            $resultArr[$listing->id] = $title;
                        }
                    } else if ($listing->id != '30') //minimum_stay
                    {
                        $resultArr[$listing->id] = '';
                    }
                    //}
                }
                //echo "<pre>"; print_r($resultArr); die;
                $json_result = json_encode($resultArr);
                $FinalsValues = array('listings' => $json_result);
                $this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
                //echo "Secc";echo $this->db->last_query();
            }
        }
    }

    public function ChangeFeaturedProducts()
    {
        $ingIDD = $this->input->post('imgId');
        $FtrId = $this->input->post('FtrId');
        $currentPage = $this->input->post('cpage');
        $dataArr = array('featured' => $FtrId);
        $condition = array('id' => $ingIDD);
        $this->product_model->update_details(PRODUCT, $dataArr, $condition);
        echo $result = $FtrId;
    }

    /* Ajax update for edit product */
    /**
     *
     * Ajax function for delete the product pictures
     */
    public function editPictureProducts()
    {
        $ingIDD = $this->input->post('imgId');
        $currentPage = $this->input->post('cpage');
        $id = $this->input->post('val');
        $productImage = explode(',', $this->session->userdata('product_image_' . $ingIDD));
        if (count($productImage) < 2) {
            echo json_encode("No");
            exit();
        } else {
            $empImg = 0;
            foreach ($productImage as $product) {
                if ($product != '') {
                    $empImg++;
                }
            }
            if ($empImg < 2) {
                echo json_encode("No");
                exit();
            }
            $this->session->unset_userdata('product_image_' . $ingIDD);
            $resultVar = $this->setPictureProducts($productImage, $this->input->post('position'));
            $insertArrayItems = trim(implode(',', $resultVar)); //need validation here...because the array key changed here
            $this->session->set_userdata(array('product_image_' . $ingIDD => $insertArrayItems));
            $dataArr = array('image' => $insertArrayItems);
            $condition = array('id' => $ingIDD);
            $this->product_model->update_details(PRODUCT, $dataArr, $condition);
            echo json_encode($insertArrayItems);
        }
    }

    /**
     *
     * This function loads the edit product form
     */
    public function edit_product_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Edit Rental';
            $product_id = $this->uri->segment(4, 0);
            $condition = array('id' => $product_id);
            $this->data['product_details'] = $this->product_model->view_product1($product_id);
            $this->data['product_accomodate'] = $this->product_model->view_product1($product_id);
            $this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname', USERS, 'where status="Active" ');
            //print_r($this->data['product_details']->row());
            //die;
            $MembershipDetails = $this->user_model->get_all_details(FANCYYBOX, array('id' => $product_id));
            if ($this->data['product_details']->num_rows() == 1) {
                $this->data['imgDetail'] = $this->product_model->get_images($product_id);
                $this->data['categoryView'] = $this->product_model->get_category_details($this->data['product_details']->row()->category_id);
                $this->data['atrributeValue'] = $this->product_model->view_atrribute_details();
                $this->data['SubPrdVal'] = $this->product_model->view_subproduct_details($product_id);
                $this->data['PrdattrVal'] = $this->product_model->view_product_atrribute_details();
                $this->data['RentalCountry'] = $this->product_model->get_all_details(COUNTRY_LIST, array('status' => 'Active'), array('field' => 'name', 'type' => 'asc'));
                $this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
                $this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
                $this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
                $this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES, array('status' => 'Active'));
                $list_valueArr = explode(',', $this->data['product_details']->row()->list_value);
                $listIdArr = array();
                /*foreach($this->data['listValueCnt']->result_array() as $listCountryValue){
                 $listIdArr[]=$listCountryValue['list_id'];
                 }

                 if($this->data['listNameCnt']->num_rows() > 0){

                 foreach($this->data['listNameCnt']->result_array() as $listCountryName){

                    $this->data['listCountryValue'] .='
                    <script language="javascript">
                    $(function(){

                    $("#selectall'.$listCountryName['id'].'").click(function () {
                    $(".cb'.$listCountryName['id'].'").attr("checked", this.checked);
                    });

                    $(".cb'.$listCountryName['id'].'").click(function(){

                    if($(".cb'.$listCountryName['id'].'").length == $(".cb:checked").length) {
                    $("#selectall'.$listCountryName['id'].'").attr("checked", "checked");
                    } else {
                    $("#selectall'.$listCountryName['id'].'").removeAttr("checked");
                    }

                    });
                    });
                    </script>


                    <br /><span class="cat1"><!-- <input name="list_name[]" class="checkbox" type="checkbox" value="'.$listCountryName['id'].'" tabindex="7"> --><strong>'.ucfirst($listCountryName['attribute_name']).' &nbsp;</strong><input type="checkbox" id="selectall'.$listCountryName['id'].'"/></span><br />';

                    foreach($this->data['listValueCnt']->result_array() as $listCountryValue){

                    //if(in_array($listCountryName['id'],$listIdArr)){
                    if($listCountryValue['list_id']==$listCountryName['id']){

                    if (in_array($listCountryValue['id'],$list_valueArr)){
                    $checkStr = 'checked="checked"';
                    }else {
                    $checkStr = '';
                    }




                    $this->data['listCountryValue'] .='
                    <div style="float:left; margin-left:10px;">
                    <span>
                    <input name="list_value[]" class="checkbox cb'.$listCountryName['id'].'" '.$checkStr.' type="checkbox" value="'.$listCountryValue['id'].'" tabindex="7">
                    <label class="choice">'.ucfirst($listCountryValue['list_value']).'</label></span></div>';

                    }

                    }

                    }$this->data['listCountryValue'] .='';
                    }*/
                foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                    $listIdArr[] = $listCountryValue['list_id'];
                }
                if ($this->data['listNameCnt']->num_rows() > 0) {
                    foreach ($this->data['listNameCnt']->result_array() as $listCountryName) {
                        $this->data['listCountryValue'] .= '
					<script language="javascript">
$(function(){
 
    $("#selectall' . $listCountryName['id'] . '").click(function () {
          $(".cb' . $listCountryName['id'] . '").attr("checked", this.checked);
    });
 
    $(".cb' . $listCountryName['id'] . '").click(function(){
 
        if($(".cb' . $listCountryName['id'] . '").length == $(".cb:checked").length) {
            $("#selectall' . $listCountryName['id'] . '").attr("checked", "checked");
        } else {
            $("#selectall' . $listCountryName['id'] . '").removeAttr("checked");
        }
 
    });
});
</script>
				
					
					<div class="dashboard_price_main">
            
            	<div class="dashboard_price">
            
                    <div class="dashboard_price_left"><h3>' . ucfirst($listCountryName['attribute_name']) . '</h3>' . $listCountryName['description'] . '<br /><br /><br />Select All<input type="checkbox" id="selectall' . $listCountryName['id'] . '"/></div><div class="dashboard_price_right"><ul class="facility_listed">';
                        foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                            //if(in_array($listCountryName['id'],$listIdArr)){
                            if ($listCountryValue['list_id'] == $listCountryName['id']) {
                                if (in_array($listCountryValue['id'], $list_valueArr)) {
                                    $checkStr = 'checked="checked"';
                                } else {
                                    $checkStr = '';
                                }
                                $this->data['listCountryValue'] .= '<li><input type="checkbox" name="list_value[]" class="checkbox_check cb' . $listCountryName['id'] . '" ' . $checkStr . 'value="' . $listCountryValue['id'] . '"/><span>' . ucfirst($listCountryValue['list_value']) . '</span></li>';
                            }
                        }
                        $this->data['listCountryValue'] .= '</ul>
                    
                    
                    </div>
                
                </div> 
                
                
                
            
            </div>';
                    }
                }
                $this->load->library('googlemaps');
                $config['center'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
                $config['zoom'] = 'auto';
                $this->googlemaps->initialize($config);
                $marker = array();
                $marker['position'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
                $marker['draggable'] = true;
                $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
                $this->googlemaps->add_marker($marker);
                $this->data['map'] = $this->googlemaps->create_map();
                //echo '<pre>'; print_r($this->data['SubPrdVal']->result()); die;
                $this->load->view('admin/product/edit_product', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /******/
    public function ajaxProductAttributeUpdate()
    {
        $conditons = array('pid' => $this->input->post('attId'));
        $dataArr = array('attr_id' => $this->input->post('attname'), 'attr_price' => $this->input->post('attval'));
        $subproductDetails = $this->product_model->edit_subproduct_update($dataArr, $conditons);
    }

    /**
     *
     * This function change the property status
     */
    public function change_product_status()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $mode = $this->uri->segment(4, 0);
            $product_id = $this->uri->segment(5, 0);
            $status = ($mode == '0') ? 'UnPublish' : 'Publish';
            $newdata = array('status' => $status);
            $condition = array('id' => $product_id);
            $this->product_model->update_details(PRODUCT, $newdata, $condition);
            $this->setErrorMessage('success', 'Rental Status Changed Successfully');
            redirect('admin/product/display_product_list');
        }
    }


    /*****/
    public function publish_mail()
    {
        /* Admin Mail function */
        //$username = username
        $email = $_POST['email'];
        $firstname = $_POST['firstname'];
        $product_title = $_POST['product_title'];
        $newsid = '40';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
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
        $reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail, 'product_title' => $product_title);
        $message = $this->load->view('newsletter/AdminPropertyApprove' . $newsid . '.php', $reg, TRUE);
        $mail_subject = $email_values['subject_message'];
        if ($mail_subject == "") {
            $mail_subject="Your Property published";
        }
        //send mail
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($mail_subject);
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
        $product_title = $_POST['product_title'];
        $newsid = '41';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
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
        $reg = array('firstname' => $firstname, 'email_title' => $sender_name, 'logo' => $logo_mail, 'product_title' => $product_title);
        //print_r($this->data['logo']);
        $message = $this->load->view('newsletter/AdminPropertyUnapproved' . $newsid . '.php', $reg, TRUE);
        $mail_subject = $email_values['subject_message'];
        if ($mail_subject == "") {
            $mail_subject="Your Property Un-Published";
        }
        //send mail
        $this->load->library('email');
        $this->email->from($email_values['from_mail_id'], $sender_name);
        $this->email->to($email_values['to_mail_id']);
        $this->email->subject($mail_subject);
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
     * This function change the affiliate product status
     */
    public function change_user_product_status()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $mode = $this->uri->segment(4, 0);
            $product_id = $this->uri->segment(5, 0);
            $status = ($mode == '0') ? 'UnPublish' : 'Publish';
            $newdata = array('status' => $status);
            $condition = array('seller_product_id' => $product_id);
            $this->product_model->update_details(USER_PRODUCTS, $newdata, $condition);
            $this->setErrorMessage('success', 'Rental Status Changed Successfully');
            redirect('admin/product/display_user_product_list');
        }
    }

    /**
     *
     * This function loads the product view page
     */
    public function view_product()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'View Rental';
            $product_id = $this->uri->segment(4, 0);
            $condition = array('id' => $product_id);
            //$this->data['product_details'] = $this->product_model->get_all_details(PRODUCT,$condition);
            $this->data['product_details'] = $this->product_model->view_product1($product_id);
            if ($this->data['product_details']->num_rows() == 1) {
                 $this->data['p_listSpace'] = $this->product_model->get_all_details(LISTSPACE, array('status' => 'Active','id' => '9'));
                  $this->data['r_listSpace'] = $this->product_model->get_all_details(LISTSPACE, array('status' => 'Active','id' => '10'));
                $this->data['catList'] = $this->product_model->get_cat_list($this->data['product_details']->row()->category_id);
                $this->data['prd_adrs'] = $this->product_model->get_all_details(PRODUCT_ADDRESS, array('product_id' => $product_id));
                $this->data['RentalCountry'] = $this->product_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->country), array('field' => 'name', 'type' => 'asc'));
                $this->data['RentalState'] = $this->product_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->state));
                $this->data['RentalCity'] = $this->product_model->get_all_details(LOCATIONS, array('id' => $this->data['prd_adrs']->row()->city));
                $this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
                $this->data['RentalState'] = $this->product_model->get_all_details(STATE_TAX, array('status' => 'Active'));
                $this->data['RentalCity'] = $this->product_model->get_all_details(CITY, array('status' => 'Active'));
                $this->data['userdetails'] = $this->product_model->get_selected_fields_records('id,firstname,lastname', USERS, 'where status="Active" ');
                $this->data['listNameCnt'] = $this->product_model->get_all_details(ATTRIBUTE, array('status' => 'Active'));
                $this->data['listValueCnt'] = $this->product_model->get_all_details(LIST_VALUES, array('status' => 'Active'));
                $this->data['listings'] = $this->product_model->get_all_details(LISTINGS, array());
                $this->data['listTypeValues'] = $this->product_model->get_all_details(LISTING_TYPES, array('status' => 'Active'));
                $this->data['listings_hometype'] = $this->product_model->get_all_details('fc_listspace_values', array('id' => $this->data['product_details']->row()->home_type));
                $this->data['listings_roomtype'] = $this->product_model->get_all_details('fc_listspace_values', array('id' => $this->data['product_details']->row()->room_type));
                //To Display Instant Pay Option If Enable//
                $this->data['instant_pay'] = $this->product_model->get_all_details(MODULES_MASTER, array('module_name' => 'payment_option'));
                $list_valueArr = explode(',', $this->data['product_details']->row()->list_value);
                $listIdArr = array();
                foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                    $listIdArr[] = $listCountryValue['list_id'];
                }
                if ($this->data['listNameCnt']->num_rows() > 0) {
                    foreach ($this->data['listNameCnt']->result_array() as $listCountryName) {
                        $this->data['listCountryValue'] .= '<br /><span class="cat1"><!-- <input name="list_name[]" class="checkbox" type="checkbox" value="' . $listCountryName['id'] . '" tabindex="7"> --><strong>' . ucfirst($listCountryName['attribute_name']) . ' &nbsp;</strong></span><br />';
                        foreach ($this->data['listValueCnt']->result_array() as $listCountryValue) {
                            if ($listCountryValue['list_id'] == $listCountryName['id']) {
                                if (in_array($listCountryValue['id'], $list_valueArr)) {
                                    $checkStr = 'checked="checked"';
                                } else {
                                    $checkStr = '';
                                }
                                $this->data['listCountryValue'] .= '
								<div style="float:left; margin-left:10px;">
								<span>
								<input name="list_value[]" disabled="disabled"  class="checkbox" ' . $checkStr . ' type="checkbox" value="' . $listCountryValue['id'] . '" tabindex="7">
								<label class="choice">' . ucfirst($listCountryValue['list_value']) . '</label></span></div>';
                            }
                        }
                    }
                }
                $this->data['imgDetail'] = $this->product_model->get_images($product_id);
                //print_r($this->data['imgDetail']->result());die;
                $this->load->library('googlemaps');
                $config['center'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
                $config['zoom'] = 'auto';
                $this->googlemaps->initialize($config);
                $marker = array();
                $marker['position'] = $this->data['product_details']->row()->latitude . ',' . $this->data['product_details']->row()->longitude;
                $marker['draggable'] = true;
                $marker['ondragend'] = 'updateDatabase(event.latLng.lat(), event.latLng.lng());';
                $this->googlemaps->add_marker($marker);
                $this->data['map'] = $this->googlemaps->create_map();
                $this->data['getCommonFacilityDetails'] = $this->product_model->getCommonFacilityDetails();
                $this->data['getExtraFacilityDetails'] = $this->product_model->getExtraFacilityDetails();
                $this->data['getSpecialFeatureFacilityDetails'] = $this->product_model->getSpecialFeatureFacilityDetails();
                $this->data['getHomeSafetyFacilityDetails'] = $this->product_model->getHomeSafetyFacilityDetails();
                $this->load->view('admin/product/view_product', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *
     * This function delete the selling product record from db
     */
    public function delete_product()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $product_id = $this->uri->segment(4, 0);
            $condition = array('id' => $product_id);
            $old_product_details = $this->product_model->get_all_details(PRODUCT, array('id' => $product_id));
            $this->update_old_list_values($product_id, array(), $old_product_details);
            $this->update_user_product_count($old_product_details);
            $this->product_model->commonDelete(PRODUCT, $condition);
            /*Image Unlink*/
            $photo_details = $this->db->select('*')->from(PRODUCT_PHOTOS)->where('product_id', $product_id)->get();
            foreach ($photo_details->result() as $image_name) {
                $gambar = $image_name->product_image;
                unlink("server/php/rental/" . $gambar);
                unlink("server/php/rental/mobile/" . $gambar);
                unlink("server/php/rental/resize/" . $gambar);
            }
            /*Image Unlink*/
            $this->product_model->commonDelete(PRODUCT_PHOTOS, array('product_id' => $product_id));
            $this->product_model->commonDelete(PRODUCT_ADDRESS, array('product_id' => $product_id));
            $this->product_model->commonDelete(PRODUCT_BOOKING, array('product_id' => $product_id));
            $this->product_model->commonDelete(SCHEDULE, array('id' => $product_id));
            $this->product_model->commonDelete(SUBPRODUCT, array('product_id' => $product_id));
            $this->setErrorMessage('success', 'Rental deleted successfully');
            redirect('admin/product/display_product_list');
        }
    }

    /**
     *
     * This function delete the affiliate product record from db
     */
    public function delete_user_product()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $product_id = $this->uri->segment(4, 0);
            $condition = array('seller_product_id' => $product_id);
            $old_product_details = $this->product_model->get_all_details(USER_PRODUCTS, array('seller_product_id' => $product_id));
            $this->update_user_created_lists($product_id);
            $this->update_user_likes($product_id);
            $this->update_user_product_count($old_product_details);
            $this->product_model->commonDelete(USER_PRODUCTS, $condition);
            $this->product_model->commonDelete(USER_ACTIVITY, array('activity_id' => $product_id));
            $this->product_model->commonDelete(NOTIFICATIONS, array('activity_id' => $product_id));
            $this->product_model->commonDelete(PRODUCT_COMMENTS, array('product_id' => $product_id));
            $this->product_model->commonDelete(SUBPRODUCT, array('product_id' => $product_id));
            $this->setErrorMessage('success', 'Rental deleted successfully');
            redirect('admin/product/display_user_product_list');
        }
    }

    public function update_user_created_lists($pid = '0')
    {
        $user_created_lists = $this->product_model->get_user_created_lists($pid);
        if ($user_created_lists->num_rows() > 0) {
            foreach ($user_created_lists->result() as $user_created_lists_row) {
                $list_product_ids = array_filter(explode(',', $user_created_lists_row->product_id));
                if (($key = array_search($pid, $list_product_ids)) !== false) {
                    unset($list_product_ids[$key]);
                    $update_ids = array('product_id' => implode(',', $list_product_ids));
                    $this->product_model->update_details(LISTS_DETAILS, $update_ids, array('id' => $user_created_lists_row->id));
                }
            }
        }
    }

    public function update_user_likes($product_id = '0')
    {
        $like_list = $this->product_model->get_like_user_full_details($product_id);
        if ($like_list->num_rows() > 0) {
            foreach ($like_list->result() as $like_list_row) {
                $likes_count = $like_list_row->likes;
                $likes_count--;
                if ($likes_count < 0) $likes_count = 0;
                $this->product_model->update_details(USERS, array('likes' => $likes_count), array('id' => $like_list_row->id));
            }
            $this->product_model->commonDelete(PRODUCT_LIKES, array('product_id' => $product_id));
        }
    }

    /**
     *
     * This function change the affiliate product status, delete the affiliate product record
     */
    public function change_user_product_status_global()
    {
        if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') {
            $data = $_POST['checkbox_id'];
            if (strtolower($_POST['statusMode']) == 'delete') {
                for ($i = 0; $i < count($data); $i++) {
                    if ($data[$i] == 'on') {
                        unset($data[$i]);
                    }
                }
                foreach ($data as $product_id) {
                    if ($product_id != '') {
                        $old_product_details = $this->product_model->get_all_details(USER_PRODUCTS, array('seller_product_id' => $product_id));
                        $this->update_user_created_lists($product_id);
                        $this->update_user_likes($product_id);
                        $this->update_user_product_count($old_product_details);
                        $this->product_model->commonDelete(USER_ACTIVITY, array('activity_id' => $product_id));
                        $this->product_model->commonDelete(NOTIFICATIONS, array('activity_id' => $product_id));
                        $this->product_model->commonDelete(PRODUCT_COMMENTS, array('product_id' => $product_id));
                        $this->product_model->commonDelete(SUBPRODUCT, array('product_id' => $product_id));
                    }
                }
            }
            $this->product_model->activeInactiveCommon(USER_PRODUCTS, 'seller_product_id');
            if (strtolower($_POST['statusMode']) == 'delete') {
                $this->setErrorMessage('success', 'Rental records deleted successfully');
            } else {
                $this->setErrorMessage('success', 'Rental records status changed successfully');
            }
            redirect('admin/product/display_user_product_list');
        }
    }

    public function loadListValues()
    {
        $returnStr['listCnt'] = '<option value="">--Select--</option>';
        $lid = $this->input->post('lid');
        $lvID = $this->input->post('lvID');
        if ($lid != '') {
            $listValues = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => $lid));
            if ($listValues->num_rows() > 0) {
                foreach ($listValues->result() as $listRow) {
                    $selStr = '';
                    if ($listRow->id == $lvID) {
                        $selStr = 'selected="selected"';
                    }
                    $returnStr['listCnt'] .= '<option ' . $selStr . ' value="' . $listRow->id . '">' . $listRow->list_value . '</option>';
                }
            } else {
                $returnStr['listCountryCnt'] .= '<option value="">---Select---</option>';
            }
        }
        echo json_encode($returnStr);
    }

    public function loadCountryListValues()
    {
        $returnStr['listCountryCnt'] = '<select class="chzn-select required state_sel" name="state" tabindex="-1" style="width: 375px;" onchange="javascript:loadStateListValues(this);update_State();" id="state" data-placeholder="Please select the state name"><option value="">---Select---</option>';
        $lid = $this->input->post('lid');
        $lvID = $this->input->post('lvID');
        if ($lid != '') {
            $listValues = $this->product_model->get_all_details(STATE_TAX, array('countryid' => $lid));
            if ($listValues->num_rows() > 0) {
                foreach ($listValues->result() as $listRow) {
                    $selStr = '';
                    if ($listRow->id == $lvID) {
                        $selStr = 'selected="selected"';
                    }
                    $returnStr['listCountryCnt'] .= '<option ' . $selStr . ' value="' . $listRow->id . '">' . $listRow->name . '</option>';
                }
            } else {
                ///*$returnStr['listCountryCnt'] .= '<option value="">---Select---</option>';*/
            }
        }
        $returnStr['listCountryCnt'] .= '</select>';
        echo json_encode($returnStr);
    }

    public function loadStateListValues()
    {
        $returnStr['listCountryCnt'] = '<select class="chzn-select required city_sel" name="city" id="city" tabindex="-1" style="width: 375px;" data-placeholder="Please select the city name"><option value="">---Select---</option>';
        $lid = $this->input->post('lid');
        $lvID = $this->input->post('lvID');
        if ($lid != '') {
            $listValues = $this->product_model->get_all_details(CITY, array('stateid' => $lid));
            if ($listValues->num_rows() > 0) {
                foreach ($listValues->result() as $listRow) {
                    $selStr = '';
                    if ($listRow->id == $lvID) {
                        $selStr = 'selected="selected"';
                    }
                    $returnStr['listCountryCnt'] .= '<option ' . $selStr . ' value="' . $listRow->id . '">' . $listRow->name . '</option>';
                }
            } else {
                //$returnStr['listCountryCnt'] .= '<option value="">---Select---</option>';
            }
        }
        $returnStr['listCountryCnt'] .= '</select>';
        echo json_encode($returnStr);
    }

    public function changePosition()
    {
        if ($this->checkLogin('A') != '') {
            $catID = $this->input->post('catID');
            $pos = $this->input->post('pos');
            $this->product_model->update_details(PRODUCT, array('order' => $pos), array('id' => $catID));
        }
    }

    /**
     *
     * This function loads the properties dashboard
     */
    public function display_rental_dashboard()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
            $this->data['heading'] = 'Rentals Dashboard';
            $this->data['ProductList'] = $this->product_model->get_contactAll_details($rep_code);
            $this->data['TopRenterList'] = $this->product_model->get_contactAllSeller_details($rep_code);
            /** To Get Active & Inactive host**/
            $this->data['TopRenterListBoth'] = $this->product_model->get_contactAllSeller_detailsBoth($rep_code);
            /** To Get Booked Properties Count**/
            $this->data['TopBookedProperties'] = $this->product_model->get_BookedProperties($rep_code);
            /** To Get Published Properties**/
            $this->data['PublishedProperties'] = $this->product_model->getPublishedProeprties($rep_code);

           /*$test= $this->product_model->get_property_booking_graph($rep_code);
           //count_string
            print_r($test->result());
            exit;*/

            $active_users=$this->user_model->get_all_details(USERS,array('status'=>'Active','group'=>"Seller",'host_status'=>0));
            $inactive_users=$this->user_model->get_all_details(USERS,array('status'=>'Inactive','group'=>"Seller",'host_status'=>0));
            $archived_users=$this->user_model->get_all_details(USERS,array('status'=>'Inactive','group'=>"Seller",'host_status'=>1));
            $this->data['active_hosts']=$active_users->num_rows();
            $this->data['inactive_hosts']=$inactive_users->num_rows();
            $this->data['archived_hosts']=$archived_users->num_rows();

            $this->load->view('admin/product/display_rental_dashboard', $this->data);
        }
    }

    /**
     *
     * This function loads the Calendar view page
     */
    public function view_calendar()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'View Calendar';
            $user_id = $this->uri->segment(4, 0);
            $deal_id = $this->uri->segment(5, 0);
            $currency = $this->uri->segment(6, 0);
            $this->data['ViewList'] = array('rental_id' => $user_id, 'price' => $deal_id, 'currency' => $currency);
            $this->load->view('admin/product/view_calendar', $this->data);
        }
    }

    /* Export Excel function */
    public function customerExcelExport()
    {
        $sortArr = array('field' => 'id', 'type' => 'desc');
        $condition = array();
        $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
        if ($rep_code != '') {
            $condition = 'where u.status="Active" and u.rep_code="' . $rep_code . '" group by p.id order by p.created desc';
        } else {
            $condition = 'where u.status="Active" or p.user_id=0 group by p.id order by p.created desc';
        }
        $UserDetails = $this->product_model->view_product_details($condition);
		//print_r($UserDetails->result()); exit;
        $data['getCustomerDetails'] = $UserDetails->result_array();
        //echo '<pre>';print_r($data['getCustomerDetails']);die;
        $data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
        $data['admin_currency_code'] = $this->data['admin_currency_code'];
        $this->load->view('admin/product/customerExportExcel', $data);
    }

    /**
     *
     * Function to upload image
     */
        public function InsertProductImage1($prd_id)
    {
        $prd_id = $this->input->post('prdiii');
        //$rental_type = $this->db->select('rental_type')->where('id',$prd_id)->get(PRODUCT)->row()->rental_type;
        $rental_type = 1;

        if ($this->config->item('s3_bucket_name') != '' && $this->config->item('s3_access_key') != '' && $this->config->item('s3_secret_key') != '') $aws = 'Yes'; else $aws = 'No';
        if ($aws == 'Yes') {
            $totalCount = count($_FILES['files']['name']);
            $nameArr = $_FILES['files']['name'];
            $sizeArr = $_FILES['files']['size'];
            $tmpArr = $_FILES['files']['tmp_name'];
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
                        /*Rename image name.*/
                        $actual_image_name = time() . "." . $ext;
                        if ($s3->putObjectFile($tmp, $bucket, $actual_image_name, S3::ACL_PUBLIC_READ)) {
                            $s3file = 'http://' . $bucket . '.s3.amazonaws.com/' . $actual_image_name;
                            mysql_query("INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$s3file','$prd_id')");
                            $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $s3file);
                            $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
                        }
                    }
                }
            }
           // redirect('admin/product/add_product_form/' . $prd_id . '/image');
           //redirect('admin/manage_rentals/add_new_rentals/' . $prd_id . '/#photos_tab');
           redirect('admin/manage_rentals/add_new_rentals/'.$rental_type.'/'.$prd_id . '/#photos_tab');
        } else {
            $uploaddir = "images/rental/";
            $uploaddir_resize = "images/rental/resize/";
            foreach ($_FILES['files']['name'] as $name => $value) {
                $filename = stripslashes($_FILES['files']['name'][$name]);
                $size = filesize($_FILES['files']['tmp_name'][$name]);
                $width_height = getimagesize($_FILES['files']['tmp_name'][$name]);
                $image_name = time() . $filename;
                $newname = $uploaddir . $image_name;
                if (move_uploaded_file($_FILES['files']['tmp_name'][$name], $newname)) {
                    /*compress and Resize*/
                    $source_photo = 'images/rental/' . $image_name . '';
                    $dest_photo = $newname;
                    $this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
                    $option1 = $this->getImageShape(700, 460, $source_photo);
                    $resizeObj1 = new Resizeimage($source_photo);
                    $resizeObj1->resizeImage(700, 460, $option1);
                    $resizeObj1->saveImage($uploaddir . $image_name, 100);
                    /*compress and Resize*/
                    $time = time();
                    $timeImg = time();
                    @copy($filename, './images/rental/mobile/' . $timeImg . $filename);
                    $target_file = $uploaddir . $image_name;
                    $imageName = $timeImg . $filename;
                    $option = $this->getImageShape(500, 350, $target_file);
                    $resizeObj = new Resizeimage($target_file);
                    $resizeObj->resizeImage(500, 350, $option);
                    $resizeObj->saveImage($uploaddir . 'mobile/' . $imageName, 100);
                    $this->ImageCompress($uploaddir . 'mobile/' . $imageName);
                    @copy($uploaddir . 'mobile/' . $imageName, $uploaddir . 'mobile/' . $imageName);
                    $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $image_name, 'mproduct_image' => $imageName);
                    print_r($filePRoductUploadData);
                    $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
                }
            }
            //redirect('admin/product/add_product_form/' . $prd_id . '/image');
            //redirect('admin/manage_rentals/add_new_rentals/' . $prd_id . '/#photos_tab');
            redirect('admin/manage_rentals/add_new_rentals/'.$rental_type.'/'.$prd_id . '/#photos_tab');
        }
    }
    public function InsertProductImage2($prd_id)
    {
        $prd_id = $this->input->post('prdiii');
        if ($this->config->item('s3_bucket_name') != '' && $this->config->item('s3_access_key') != '' && $this->config->item('s3_secret_key') != '') $aws = 'Yes'; else $aws = 'No';
        if ($aws == 'Yes') {
            $totalCount = count($_FILES['files']['name']);
            $nameArr = $_FILES['files']['name'];
            $sizeArr = $_FILES['files']['size'];
            $tmpArr = $_FILES['files']['tmp_name'];
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
                        /*Rename image name.*/
                        $actual_image_name = time() . "." . $ext;
                        if ($s3->putObjectFile($tmp, $bucket, $actual_image_name, S3::ACL_PUBLIC_READ)) {
                            $s3file = 'http://' . $bucket . '.s3.amazonaws.com/' . $actual_image_name;
                            mysql_query("INSERT INTO fc_rental_photos(product_image,product_id) VALUES('$s3file','$prd_id')");
                            $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $s3file);
                            $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
                        }
                    }
                }
            }
            redirect('admin/product/add_product_form/' . $prd_id . '/image');
        } else {
            $uploaddir = "images/rental/";
            $uploaddir_resize = "images/rental/resize/";
            foreach ($_FILES['files']['name'] as $name => $value) {
                $filename = stripslashes($_FILES['files']['name'][$name]);
                $size = filesize($_FILES['files']['tmp_name'][$name]);
                $width_height = getimagesize($_FILES['files']['tmp_name'][$name]);
                $image_name = time() . $filename;
                $newname = $uploaddir . $image_name;
                if (move_uploaded_file($_FILES['files']['tmp_name'][$name], $newname)) {
                    /*compress and Resize*/
                    $source_photo = 'images/rental/' . $image_name . '';
                    $dest_photo = $newname;
                    $this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
                    $option1 = $this->getImageShape(700, 460, $source_photo);
                    $resizeObj1 = new Resizeimage($source_photo);
                    $resizeObj1->resizeImage(700, 460, $option1);
                    $resizeObj1->saveImage($uploaddir . $image_name, 100);
                    /*compress and Resize*/
                    $time = time();
                    $timeImg = time();
                    @copy($filename, './images/rental/mobile/' . $timeImg . $filename);
                    $target_file = $uploaddir . $image_name;
                    $imageName = $timeImg . $filename;
                    $option = $this->getImageShape(500, 350, $target_file);
                    $resizeObj = new Resizeimage($target_file);
                    $resizeObj->resizeImage(500, 350, $option);
                    $resizeObj->saveImage($uploaddir . 'mobile/' . $imageName, 100);
                    $this->ImageCompress($uploaddir . 'mobile/' . $imageName);
                    @copy($uploaddir . 'mobile/' . $imageName, $uploaddir . 'mobile/' . $imageName);
                    $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $image_name, 'mproduct_image' => $imageName);
                    $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
                }
            }
            redirect('admin/product/add_product_form/' . $prd_id . '/image');
        }
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

    public function InsertProductImage1_old($prd_id)
    {
        $prd_id = $this->input->post('prdiii');
        $valid_formats = array("jpg", "png", "gif", "zip", "bmp");
        $max_file_size = 1024 * 10000; //100 kb
        $path = "server/php/rental/"; // Upload directory
        $count = 0;
        if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {
            foreach ($_FILES['files']['name'] as $f => $name) {
                if ($_FILES['files']['error'][$f] == 4) {
                    continue; // Skip file if any error found
                }
                if ($_FILES['files']['error'][$f] == 0) {
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $message[] = "$name is too large!.";
                        continue; // Skip large files
                    } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                        $message[] = "$name is not a valid format";
                        continue; // Skip invalid file formats
                    } else { // No error found! Move uploaded files
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $name)) {
                            $filename[] = $_FILES["files"]["name"][$f];
                            $count++; // Number of successfully uploaded files
                        }
                    }
                }
            }
        }
        //print_r(count($filename)); die;
        for ($i = 0; $i < count($filename); $i++) {
            if (!empty($filename[$i])) {
                // print_r($img_name[$i]);
                $filePRoductUploadData = array('product_id' => $prd_id, 'product_image' => $filename[$i]);
                $this->product_model->simple_insert(PRODUCT_PHOTOS, $filePRoductUploadData);
            } else {
                print_r("File is empty");
                $this->setErrorMessage('error', 'You cannot choose image');
            }
        }
        redirect('admin/product/add_product_form/' . $prd_id);
        return true;
    }

    public function get_sublist_values()
    {
        $list_value_id = $this->input->post('list_value_id');
        //echo $list_value_id;
        $this->data['result'] = $this->product_model->get_all_details(LIST_SUB_VALUES, array('list_value_id' => $list_value_id));
        //print_r($this->data['result']); die;
        $returnstr['amenities'] = $this->load->view('admin/product/display_li', $this->data, true);
        echo json_encode($returnstr);
    }

    public function copyrenters()
    {
        $copyid = $this->uri->segment(4);
        $product = $this->product_model->get_all_details(PRODUCT, array('id' => $copyid));
        $data = array('room_type' => $product->row()->room_type,
            'price' => $product->row()->price,
            'home_type' => $product->row()->home_type,
            'accommodates' => $product->row()->accommodates,
            'bedrooms' => $product->row()->bedrooms,
            'beds' => $product->row()->beds,
            'bathrooms' => $product->row()->bathrooms,
            'bed_type' => $product->row()->bed_type,
            'user_id' => $product->row()->user_id,
            'description' => $product->row()->description,
            'list_name' => $product->row()->list_name,
            'city' => $product->row()->city,
            'status' => 'UnPublish'
        );
        $this->product_model->simple_insert(PRODUCT, $data);
        //echo $this->db->last_query();die;
        $getInsertId = $this->product_model->get_last_insert_id();
        $pro_add = $this->product_model->get_all_details(PRODUCT_ADDRESS, array('product_id' => $copyid));
        $data = array('product_id' => $getInsertId,
            'country' => $pro_add->row()->country,
            'state' => $pro_add->row()->state,
            'city' => $pro_add->row()->city,
            'post_code' => $pro_add->row()->post_code,
            'address' => $pro_add->row()->address,
            'latitude' => $pro_add->row()->latitude,
            'longitude' => $pro_add->row()->longitude,
        );
        $this->product_model->simple_insert(PRODUCT_ADDRESS, $data);
        $pro_img = $this->product_model->get_all_details(PRODUCT_PHOTOS, array('product_id' => $copyid));
        //print_r($pro_img->result());
        //echo $pro_img->num_rows();
        if ($pro_img->num_rows() > 0) {
            foreach ($pro_img->result() as $pro_image) {
                $data = array('product_id' => $getInsertId,
                    'product_image' => $pro_image->product_image,
                    'mproduct_image' => $pro_image->mproduct_image
                );
                $this->product_model->simple_insert(PRODUCT_PHOTOS, $data);
                $this->db->last_query();
            }
        }
        redirect('admin/product/add_product_form/' . $getInsertId);
    }

    public function Save_DetailsValues()
    {
        $catID = $this->input->post('catID');
        $title = $this->input->post('title');
        $chk = $this->input->post('chk');
        //echo $catID . $title . $chk; die;
        $checkListing = $this->product_model->get_all_details(PRODUCT, array('id' => $catID));
        $listings_DetailsEncode = $this->product_model->get_all_details(LISTINGS, array('id' => 1))->row();
        $listings_DetailsDecode = json_decode($checkListing->row()->listings);
        $listinsJson = json_decode($checkListing->row()->listings);
        if (count($listinsJson) != 0) {
            //	echo "<pre>"; print_r($listinsJson);
            $resultArr = array();
            foreach ($listinsJson as $key => $value) {
                $productListingName[$key] = $key;
                $productListingvalue[$key] = $value;
            }
            foreach ($listings_DetailsDecode as $lisingTableName => $lisingTablevalue) {
                if ($lisingTableName == $chk) {
                    $this->product_model->update_details(PRODUCT, array('minimum_stay' => $title), array('id' => $catID));
                    //$this->db->last_query();die;
                } else if ($lisingTableName == $productListingName[$lisingTableName]) {
                    $resultArr[$lisingTableName] = $productListingvalue[$lisingTableName];
                } else if ($lisingTableName != 'minimum_stay') {
                    //$resultArr[$lisingTableName] = '';
                }
            }
            $json_result = json_encode($resultArr);
            $FinalsValues = array('listings' => $json_result);
            //print_r($json_result);
            $this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
            //echo $this->db->last_query();
        } else {
            $listingsRslt = $this->product_model->get_all_details(LISTING_TYPES, array());
            foreach ($listingsRslt->result() as $listing) {
                if ($listing->name != 'accommodates' && $listing->name != 'can_policy') {
                    if ($listing->id == $chk) {
                        $this->product_model->update_details(PRODUCT, array('minimum_stay' => $title), array('id' => $catID));
                        $resultArr[$listing->id] = $title;
                    } else if ($listing->name != 30) {
                        $resultArr[$listing->id] = '';
                        //echo "string2";
                    }
                }
            }
            //echo "<pre>"; print_r($resultArr); die;
            $json_result = json_encode($resultArr);
            $FinalsValues = array('listings' => $json_result);
            $this->product_model->update_details(PRODUCT, $FinalsValues, array('id' => $catID));
            exit();
        }
    }

    public function saveDetailPage()
    {
        $catID = $this->input->post('catID');
        $title = $this->input->post('title');
        $chk = $this->input->post('chk');
        $this->product_model->update_details(PRODUCT, array($chk => $title), array('id' => $catID));
        if ($chk == 'price') {
            $product_id = $this->input->post('catID');
            $DateUpdateCheck = $this->product_model->get_all_details(PRODUCT_BOOKING, array('product_id' => $product_id));
            if ($DateUpdateCheck->num_rows() == '1') {
                $DateArr = $this->GetDays($DateUpdateCheck->row()->datefrom, $DateUpdateCheck->row()->dateto);
                $dateDispalyRowCount = 0;
                if (!empty($DateArr)) {
                    $dateArrVAl .= '{';
                    foreach ($DateArr as $dateDispalyRow) {
                        if ($dateDispalyRowCount == 0) {
                            $dateArrVAl .= '"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $title . '","promo":"","status":"available"}';
                        } else {
                            $dateArrVAl .= ',"' . $dateDispalyRow . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $title . '","promo":"","status":"available"}';
                        }
                        $dateDispalyRowCount = $dateDispalyRowCount + 1;
                    }
                    $dateArrVAl .= '}';
                }
                $inputArr4 = array();
                $inputArr4 = array(
                    'id' => $product_id,
                    'data' => trim($dateArrVAl)
                );
                $this->product_model->update_details(SCHEDULE, $inputArr4, array('id' => $product_id));
            }
        }
        $this->setErrorMessage('success', 'Successfully saved!');
    }


    function saveDescriptionPage(){
        if ($this->checkLogin('A') != '') {
            $catID = $this->input->post('catID');
            $title = $this->input->post('title');
            $chk = $this->input->post('chk');
            $this->product_model->update_details(PRODUCT, array($chk => $title), array('id' => $catID));

        }else{
            redirect('admin/product/display_product_list');
        }

    }

    function checkproperty_finish()
    {
        $pro_id = $_POST['pro_id'];
        echo "dfd" . $pro_id;
        $user_detail = $this->product_model->get_all_details(USERS, array('id' => $pro_id));
        $email = $user_detail->row()->email;
        $firstname = $user_detail->row()->firstname;
        $checkproperty = $this->product_model->get_all_details(PRODUCT, array('id' => $pro_id));
        $checkproperty_image = $this->product_model->get_all_details('fc_rental_photos', array('product_id' => $pro_id));
        $checkproperty_location = $this->product_model->get_all_details('fc_product_address_new', array('productId' => $pro_id));
        $total_filled_fields = 13;
        $filled = 0;
        if ($checkproperty->row()->product_title != '') {
            $filled++;
        }
        if ($checkproperty->row()->description != '') {
            $filled++;
        }
        if ($checkproperty->row()->currency != '') {
            $filled++;
        }
        if ($checkproperty->row()->price != '') {
            $filled++;
        }
        if ($checkproperty->row()->cancellation_policy != '') {
            $filled++;
        }
        if ($checkproperty->row()->status != '') {
            $filled++;
        }
        if ($checkproperty->row()->request_to_book != '') {
            $filled++;
        }
        if ($checkproperty->row()->instant_pay != '') {
            $filled++;
        }
        if ($checkproperty_image->row()->product_image != '') {
            $filled++;
        }
        if ($checkproperty_location->row()->address != '') {
            $filled++;
        }
        if ($checkproperty_location->row()->country != '') {
            $filled++;
        }
        if ($checkproperty_location->row()->city != '') {
            $filled++;
        }
        if ($checkproperty_location->row()->state != '') {
            $filled++;
        }
        if ($filled == $total_filled_fields) {
            $this->admin_property_publish_mail($email, $firstname);
        }
    }

    public function admin_property_publish_mail($email, $firstname)
    {
        /* Admin Mail function */
        //$username = username
        $newsid = '40';
        $template_values = $this->product_model->get_newsletter_template_details($newsid);
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
        $message = $this->load->view('newsletter/AdminPropertyApprove' . $newsid . '.php', $reg, TRUE);
        echo $message;
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
        //   redirect('admin/product/display_product_list');
        /* Admin Mail function End */
    }

    public function check_product_exist()
    {
        $product_title = $this->input->post('prd');

        $check = $this->db->select('id,product_title')->where('product_title LIKE "%'.$product_title.'%"')->get(PRODUCT)->num_rows();

        if($check > 0)
        {
            echo '1';/*exist product*/
        }else{echo '0';}
    }

}




/* End of file product.php */
/* Location: ./application/controllers/admin/product.php */
