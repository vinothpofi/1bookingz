<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to user management
 * @author Teamtweaks
 *
 */
class Commission extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model('commission_model');
        if ($this->checkPrivileges('Commission', $this->privStatus) == FALSE) {
            redirect('admin');
        }
    }

    /**
     *
     * This function loads the commisions list page
     */
    public function index()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            redirect('admin/commission/display_commission_list');
        }
    }


    /**
     *
     * This function loads the commission list page
     */
    public function display_commission_list()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Commission List';
            $condition = array();
            $this->data['commissionList'] = $this->commission_model->get_all_details(COMMISSION, $condition);
            $this->load->view('admin/commission/display_commissionlist', $this->data);
        }
    }

    public function display_commission_representative_lists()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Commission Representative Tracking Lists';
            $sellerDetails = $this->commission_model->get_all_details(USERS, array('group' => 'Seller', 'status' => 'Active', 'repcode_id' => 1));
            //echo "<pre>";	print_r($sellerDetails->result()); die; $this->data['trackingDetails']
            foreach ($sellerDetails->result() as $seller) {
                $sellerEmail = $seller->email;
                //echo $sellerEmail;
                //$this->data['query'] = $this->commission_model->get_repcode_details($sellerEmail);
                $rental_booking_details[$sellerEmail] = $this->commission_model->get_all_commission_trackings($sellerEmail);
                $this->data['trackingDetails'][$sellerEmail]['rowsCount'] = count($rental_booking_details[$sellerEmail]);
                $this->data['trackingDetails'][$sellerEmail]['guest_fee'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['total_amount'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['host_fee'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['rep_fee'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['code'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['payable_amount'] = 0;
                //echo "<pre>";print_r($rental_booking_details[$sellerEmail]); die;
                if (count($rental_booking_details[$sellerEmail]) != 0) {
                    foreach ($rental_booking_details[$sellerEmail] as $rentals) {
                        $this->data['trackingDetails'][$sellerEmail]['id'] = $rentals['id'];
                        $this->data['trackingDetails'][$sellerEmail]['total_amount'] = $this->data['trackingDetails'][$sellerEmail]['total_amount'] + $rentals['total_amount'];
                        $this->data['trackingDetails'][$sellerEmail]['guest_fee'] = $this->data['trackingDetails'][$sellerEmail]['guest_fee'] + $rentals['guest_fee'];
                        $this->data['trackingDetails'][$sellerEmail]['host_fee'] = $this->data['trackingDetails'][$sellerEmail]['host_fee'] + $rentals['host_fee'];
                        $this->data['trackingDetails'][$sellerEmail]['rep_fee'] = $this->data['trackingDetails'][$sellerEmail]['rep_fee'] + $rentals['rep_fee'];
                        $this->data['trackingDetails'][$sellerEmail]['code'] = $rentals['code'];
                        $this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'];
                    }
                }
                $paidAmountQry = $this->commission_model->get_paid_detailss($sellerEmail);
                $this->data['trackingDetails'][$sellerEmail]['paid'] = 0;
                /*if(count($paidAmountQry) != 0){

                    foreach($paidAmountQry as $rental_paid)
                    {
                    $this->data['trackingDetails'][$sellerEmail]['paid'] = $this->data['trackingDetails'][$sellerEmail]['paid'] + AdminCurrencyValue($rental_paid['prd_id'],$rental_paid['payable_amount']);
                    }
                }*/
                $paidAmount = 0;
                $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
                if (count($paidAmountQry) != 0) {
                    foreach ($paidAmountQry as $rental_paid) {
                        $currencyPerUnitSeller = $rental_paid['currencyPerUnitSeller'];
                        if ($rental_paid['currencycode'] != $admin_currencyCode) {
                            $re_paid = customised_currency_conversion($currencyPerUnitSeller, $rental_paid['payable_amount']);
                        } else {
                            $re_paid = $rental_paid['payable_amount'];
                        }
                        $paidAmount = $paidAmount + $re_paid;
                    }
                    $this->data['trackingDetails'][$sellerEmail]['paid'] = $paidAmount;
                }
                //echo $sellerEmail;
                $this->data['rep_details'] = $this->commission_model->get_rep_details($sellerEmail);
                //$rep_code = $this->data['rep_details']->row()->rep_code;
                //echo $rep_code;
                //$this->data['rep_details_com'] = $this->commission_model->get_rep_details_commison($this->data['rep_details']->row()->email);
            }
            //echo $this->data['rep_details']->row()->email;
            //$this->load->view('admin/commission/display_tracking_lists',$this->data);
            $this->load->view('admin/commission/display_commission_representative_lists', $this->data);
        }
    }

    /**
     *
     * This function loads the commission dashboard
     */
    public function display_commission_dashboard()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Members Dashboard';
            $condition = 'where `group`="commission" order by `created` desc';
            $this->data['commissionList'] = $this->commission_model->get_commission_details($condition);
            $this->load->view('admin/commission/display_commission_dashboard', $this->data);
        }
    }

    /**
     *
     * This function loads the add new commission form
     */
    public function add_commission_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Add New Commission';
            $this->load->view('admin/commission/add_commission', $this->data);
        }
    }

    /**
     *
     * This function insert and edit a commission
     */
    public function insertEditcommission()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $commission_id = $this->input->post('commission_id');
            $commission_type = $this->input->post('commission_type');
            if ($commission_id == '') {
                $condition = array('commission_type' => $commission_type);
                $duplicate_name = $this->commission_model->get_all_details(COMMISSION, $condition);
                if ($duplicate_name->num_rows() > 0) {
                    $this->setErrorMessage('error', 'Commission already exists');
                    redirect('admin/commission/add_commission_form');
                }
            }
            $excludeArr = array("commission_id", "image", "new_password", "confirm_password", "group", "status");
            if ($this->input->post('status') != '') {
                $commission_status = 'Active';
            } else {
                $commission_status = 'Inactive';
            }
            $dataArr = array('status' => $commission_status);
            $condition = array('id' => $commission_id);
            if ($commission_id == '') {
                $this->commission_model->commonInsertUpdate(COMMISSION, 'insert', $excludeArr, $dataArr, $condition);
                $this->setErrorMessage('success', 'commission added successfully');
            } else {
                $this->commission_model->commonInsertUpdate(COMMISSION, 'update', $excludeArr, $dataArr, $condition);
                $this->setErrorMessage('success', 'commission updated successfully');
            }
            redirect('admin/commission/display_commission_list');
        }
    }

    /**
     *
     * This function loads the edit commission form
     */
    public function edit_commission_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Edit commission';
            $commission_id = $this->uri->segment(4, 0);
            $condition = array('id' => $commission_id);
            $this->data['commission_details'] = $this->commission_model->get_all_details(COMMISSION, $condition);
            if ($this->data['commission_details']->num_rows() == 1) {
                $this->load->view('admin/commission/edit_commission', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *
     * This function change the commission status
     */
    public function change_commission_status()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $mode = $this->uri->segment(4, 0);
            $commission_id = $this->uri->segment(5, 0);
            $status = ($mode == '0') ? 'Inactive' : 'Active';
            $newdata = array('status' => $status);
            $condition = array('id' => $commission_id);
            $this->commission_model->update_details(COMMISSION, $newdata, $condition);
            $this->setErrorMessage('success', 'commission Status Changed Successfully');
            redirect('admin/commission/display_commission_list');
        }
    }

    /**
     *
     * This function loads the commission view page
     */
    public function view_commission()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'View commission';
            $commission_id = $this->uri->segment(4, 0);
            $condition = array('id' => $commission_id);
            $this->data['commission_details'] = $this->commission_model->get_all_details(commission, $condition);
            if ($this->data['commission_details']->num_rows() == 1) {
                $this->load->view('admin/commission/view_commission', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *
     * This function delete the commission record from db
     */
    public function delete_commission()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $commission_id = $this->uri->segment(4, 0);
            $condition = array('id' => $commission_id);
            $this->commission_model->commonDelete(commission, $condition);
            $this->setErrorMessage('success', 'commission deleted successfully');
            redirect('admin/commission/display_commission_list');
        }
    }

    /**
     *
     * This function change the commission status, delete the commission record
     */
    public function change_commission_status_global()
    {
        if (count($_POST['checkbox_id']) > 0 && $_POST['statusMode'] != '') {
            $this->commission_model->activeInactiveCommon(COMMISSION, 'id');
            if (strtolower($_POST['statusMode']) == 'delete') {
                $this->setErrorMessage('success', 'commission records deleted successfully');
            } else {
                $this->setErrorMessage('success', 'commission records status changed successfully');
            }
            redirect('admin/commission/display_commission_list');
        }
    }

    public function export_commission_details()
    {
        $fields_wanted = array('firstname', 'lastname', 'email', 'created', 'last_login_date', 'last_login_ip');
        $table = commission;
        $commission = $this->commission_model->export_commission_details($table, $fields_wanted);
        $this->data['commission_detail'] = $commission['commission_detail']->result();
        $this->load->view('admin/commission/export_commission', $this->data);
    }

    /**
     *
     * This function loads commission track list page
     */
    public function display_commission_tracking_lists()
    {
		//coupon_discount
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Rental Commission Tracking Lists';
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');

            if($rep_code!=''){
                $sellerDetails = $this->commission_model->get_all_details(USERS,array('group'=>'Seller','status'=>'Active','rep_code'=>$rep_code),array(array('field'=>'id','type'=>"DESC")));
            }else{
                $sellerDetails = $this->commission_model->get_all_details(USERS,array('group'=>'Seller','status'=>'Active'),array(array('field'=>'id','type'=>"DESC")));
            }

            foreach ($sellerDetails->result() as $seller) {
                $sellerEmail = $seller->email;
                $sellerId = $seller->id;
                /* paypal email */
                $this->data['paypalData'][$sellerEmail] = $seller->paypal_email;
                $rental_booking_details[$sellerEmail] = $this->commission_model->get_all_commission_tracking($sellerEmail);
                $this->data['trackingDetails'][$sellerEmail]['guest_fee'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['total_amount'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['host_fee'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['payable_amount'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['coupon_discount'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['cancel_percentage'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['rowsCount'] = 0;
                $this->data['trackingDetails'][$sellerEmail]['secDeposit'] = 0;
                if (count($rental_booking_details[$sellerEmail]) != 0) {
                    foreach ($rental_booking_details[$sellerEmail] as $rentals) {
						if ($rentals['currency_cron_id']==0) { $currencyCronId=''; } else { $currencyCronId = $rentals['currency_cron_id'];}
                        /** Start - display Tracking details if the dates reached **/
                        //$totlessDays = $this->config->item('cancel_hide_days_property');
						//$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
						/* HERE CONFUSION OCCURED. WHY WE NEED TO ADD CANCELLATION DAYS HERE. SO I TRIED WITHOUT CANCELLATION DAYS BELOW*/
						$minus_checkin = strtotime($rentals['checkin']);//Added by nagoor
                        $checkinBeforeDay = date('Y-m-d', $minus_checkin);
						//checkin days 2018-05-11 00:00:00 $checkinBeforeDay 2018-04-21.'<br>';
                        $current_date = date('Y-m-d');
						//echo $checkinBeforeDay.'<='.$current_date.'<bR>';
						//echo $rentals['Bookingno'].'|'.$checkinBeforeDay.'|'.$current_date.'<br>'; cancel_percentage
                        /** End - display Tracking details if the dates reached **/ 
                        if ($checkinBeforeDay <= $current_date) {
                            $this->data['trackingDetails'][$sellerEmail]['rowsCount'] += 1;
                            $this->data['trackingDetails'][$sellerEmail]['checkin'] .= $rentals['checkin'] . ',';
                            $this->data['trackingDetails'][$sellerEmail]['booking_noPay'] .= $rentals['booking_no'] . ',';
                            $EnquiryId = $rentals['EnquiryId'];
                            $this->data['trackingDetails'][$sellerEmail]['renter_id'] = $rentals['renter_id'];
                            $payment_details = $this->commission_model->get_all_details(PAYMENT, array('EnquiryId' => $EnquiryId));
                            $payment = $payment_details->row();
							
							$currencyPerUnitSeller_one = $rentals['currencyPerUnitSeller'];
							
                            if (!empty($payment)) {
								 
                                if ($payment->is_coupon_used == 'Yes') {
                                    $coupon_discount += round(($payment->total_amt - $payment->discount), 2);
									
									//Start - Convert Coupon Amount
									 if ($rentals['user_currencycode'] != $this->data['admin_currency_code']) {
										 $couponDS= currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $coupon_discount,$currencyCronId);
										 //customised_currency_conversion($currencyPerUnitSeller_one, $coupon_discount);
									 }else{
										 $couponDS=$coupon_discount;
									 }
									 //End - Convert Coupon Amount
									 
                                    $this->data['trackingDetails'][$sellerEmail]['coupon_discount'] +=   $couponDS;
									
									
                                }
                            }
                            $this->data['trackingDetails'][$sellerEmail]['id'] = $rentals['id'];
                            if ($rentals['user_currencycode'] != $this->data['admin_currency_code']) {
                                $currencyPerUnitSeller = $rentals['currencyPerUnitSeller'];
                                $rentals['total_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['total_amount'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['total_amount']);
                                $rentals['booking_walletUse'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['booking_walletUse'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['booking_walletUse']);
                                $rentals['guest_fee'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['guest_fee'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['guest_fee']);
                                $rentals['host_fee'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['host_fee'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['host_fee']);
                                $rentals['payable_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['payable_amount'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['payable_amount']);
                                $rentals['paid_cancel_amount'] = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['paid_cancel_amount'],$currencyCronId);
								//customised_currency_conversion($currencyPerUnitSeller, $rentals['paid_cancel_amount']);
                            } else {
                                $rentals['total_amount'] = $rentals['total_amount'];
                                $rentals['guest_fee'] = $rentals['guest_fee'];
                                $rentals['host_fee'] = $rentals['host_fee'];
                                $rentals['payable_amount'] = $rentals['payable_amount'];
                                $rentals['booking_walletUse'] = $rentals['booking_walletUse'];
                                $rentals['paid_cancel_amount'] = $rentals['paid_cancel_amount'];
                            }
                            $this->data['trackingDetails'][$sellerEmail]['total_amount'] = $this->data['trackingDetails'][$sellerEmail]['total_amount'] + $rentals['total_amount'];
                            $this->data['trackingDetails'][$sellerEmail]['guest_fee'] = $this->data['trackingDetails'][$sellerEmail]['guest_fee'] + $rentals['guest_fee'];
                            $this->data['trackingDetails'][$sellerEmail]['booking_no'] = $rentals['booking_no'];
                            $this->data['trackingDetails'][$sellerEmail]['host_fee'] = $this->data['trackingDetails'][$sellerEmail]['host_fee'] + $rentals['host_fee'];
							
							
                           //$cancel_amountBf = $rentals['payable_amount'] - $rentals['paid_cancel_amount'];
							$cancel_amount_percen = $rentals['subtotal'] / 100 * $rentals['cancel_percentage'];
							$cancel_amount=$rentals['subtotal']-$cancel_amount_percen;//317.7
							$cancel_amountBf=$cancel_amount+$rentals['secDeposit'];//417.7
                            if ($rentals['cancelled'] == 'Yes') {
                                $this->data['trackingDetails'][$sellerEmail]['cancel_percentage'] += $cancel_amountBf;
                            } else {
                                $this->data['trackingDetails'][$sellerEmail]['cancel_percentage'] += '0.00';
                            }
							
							
							
							   /** Start - Convert Wallet Used Amount **/
									 if ($rentals['user_currencycode'] != $this->data['admin_currency_code']) {
										 $WalletUsed = currency_conversion($rentals['user_currencycode'], $this->data['admin_currency_code'], $rentals['booking_walletUse'],$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller_one, $rentals['booking_walletUse']);
									 }else{
										 $WalletUsed =$rentals['booking_walletUse'];
									 }
								/** End - Start - Convert Wallet Used Amount **/	
								
								
                            $this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] += $WalletUsed;
						   
						   
                           // $this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] = $this->data['trackingDetails'][$sellerEmail]['booking_walletUse'] + $rentals['booking_walletUse'];
							
							
                            /**to show AmountTohost if the property is canceled **/
							
							//$rentals['paid_cancel_amount'] is amount to guest
							
                            if ($rentals['cancelled'] == 'Yes') {
								$this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'] - $rentals['paid_cancel_amount'];																
                            } else {
                                $this->data['trackingDetails'][$sellerEmail]['payable_amount'] = $this->data['trackingDetails'][$sellerEmail]['payable_amount'] + $rentals['payable_amount'];
                            }
                            /**to show cancelAmount if the property is canceled **/



                        }
                    }
                }

                $paidAmountQry = $this->commission_model->get_paid_details($sellerEmail);
                $this->data['trackingDetails'][$sellerEmail]['paid'] = 0;
                $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
                $paidAmount = 0;
                if (count($paidAmountQry) != 0) {
                    foreach ($paidAmountQry as $rental_paid) {
						if ($rental_paid['currency_cron_id']==0) { $currencyCronId=''; } else { $currencyCronId = $rental_paid['currency_cron_id'];}
						/* NAGOOR START */ 
						$totlessDays = $this->config->item('cancel_hide_days_property');
                        $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
                        $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                        $current_date = date('Y-m-d');
						//echo $rentals['Bookingno'].'|'.$checkinBeforeDay.'|'.$current_date.'<br>';
                        //if ($checkinBeforeDay <= $current_date) {
						/* NAGOOR END */	
                        $currencyPerUnitSeller = $rental_paid['currencyPerUnitSeller'];
                        /** Start - Convert Cancel Amount **/
						
                        $cancel_amountBf = $rental_paid['payable_amount']-$rental_paid['paid_cancel_amount'];
                       
                        if ($rental_paid['user_currencycode'] != $admin_currencyCode) {
							
                                $cancel_amount = currency_conversion($rental_paid['user_currencycode'], $admin_currencyCode, $cancel_amountBf,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $cancel_amountBf);
                           
                        } else {

                                $cancel_amount = $cancel_amountBf;
                        }
                        /** End - Convert Cancel Amount **/
						
						
                        /** Start - Convert payable Amount **/
                        $payableDb = $rental_paid['payable_amount'];
						
                        if ($rental_paid['user_currencycode'] != $admin_currencyCode) {
							$payable = currency_conversion($rental_paid['user_currencycode'], $admin_currencyCode, $payableDb,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $payableDb);
							//echo $rental_paid['user_currencycode'].'|'.$admin_currencyCode.'|'.$payableDb.'|'.$currencyCronId.'|'.$payable.'<br>';
                        } else {
							
                            $payable = $payableDb;
                        }
						
                        /** End - Convert payable Amount **/
						
						
                        if ($rental_paid['cancelled'] == 'Yes') {
							
                            $re_paid = $cancel_amount;
                        } else {
                            $re_paid = $payable;
                        }
                        $paidAmount = $paidAmount + $re_paid;
                    }
					//$this->data['trackingDetails'][$sellerEmail]['newpaid'] = 
                    $this->data['trackingDetails'][$sellerEmail]['paid'] = $paidAmount;
                }
            }
            $this->load->view('admin/commission/display_tracking_lists', $this->data);
        }
    }

    public function display_product_list($email)
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Property wise payment details';
            $detail_get = $this->commission_model->get_rep_details_commison($email);
            $pro_detail = array();
            foreach ($detail_get->result() as $details) {
                /** Start - display Tracking details if the dates reached **/
                $totlessDays = $this->config->item('cancel_hide_days_property');
                $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($details->checkin));
                $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                $current_date = date('Y-m-d');
                /** End - display Tracking details if the dates reached **/
                if ($checkinBeforeDay <= $current_date) {
                    $condition = array('Bookingno' => $details->booking_no, 'booking_status' => 'Booked');
                    $details = $this->commission_model->get_all_product_details($condition);
                    $pro_detail[] = $details->result();
                }
            }
            $this->data['product'] = $pro_detail;
            $this->load->view('admin/commission/display_product_list', $this->data);
        }
    }

    /**
     *
     * This function loads user wallet list page
     */
    public function display_wallet_payments_list()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'User Wallet Lists';
            $rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
             if ($rep_code != '') {				 $sellerDetails = $this->commission_model->get_user_det_rep($rep_code);            } else {              				  $sellerDetails = $this->commission_model->get_user_det();            } 
           
            $tot_usedWallet = $this->data['adminProfit'] = 0;
            foreach ($sellerDetails->result() as $seller) {
                $userId = $seller->id;
                $wallet_applyCount = "select sum(py.wallet_Amount) as usedWallet,py.currency_code,re.currencyPerUnitSeller from " . PAYMENT . " as py ," . RENTALENQUIRY . " as re where py.user_id='" . $userId . "' and py.is_wallet_used='Yes' and py.wallet_Amount!='0.00' and py.EnquiryId=re.id";
                $wallet_usage = $this->commission_model->ExecuteQuery($wallet_applyCount)->row();
                $currencyPerUnitSeller = $wallet_usage->currencyPerUnitSeller;
                if ($wallet_usage->usedWallet != null) {
                    $usedWallet = $wallet_usage->usedWallet;
                    $currency_code = $wallet_usage->currency_code;
                    if ($currency_code != $this->data['admin_currency_code']) {
                        $usedWallet = customised_currency_conversion($currencyPerUnitSeller, $usedWallet);
                        $tot_usedWallet += $usedWallet;
                    } else {
                        $usedWallet = $usedWallet;
                        $tot_usedWallet += $usedWallet;
                    }
                } else {
                    $usedWallet = '0.00';
                    $currency_code = $this->data['admin_currency_code'];
                    $tot_usedWallet += $usedWallet;
                }
                $this->data['walletData'][$userId] = array('name' => $seller->firstname . ' ' . $seller->lastname, 'email' => $seller->email, 'totalReferalAmount' => $seller->totalReferalAmount, 'referalAmount_currency' => $seller->referalAmount_currency, 'usedWallet' => $usedWallet, 'paidCurrency' => $currency_code);
                $userEmail = $seller->email;
                $rental_booking_details[$userEmail] = $this->commission_model->get_all_commission_tracking($userEmail);
                if (count($rental_booking_details[$userEmail]) != 0) {
                    foreach ($rental_booking_details[$userEmail] as $rentals) {
                        if ($rentals['currencycode'] != $this->data['admin_currency_code']) {
                            $rentals['guest_fee'] = customised_currency_conversion($currencyPerUnitSeller, $rentals['guest_fee']);
                        } else {
                            $rentals['guest_fee'] = $rentals['guest_fee'];
                        }
                        $this->data['adminProfit'] += $rentals['guest_fee'];
                    }
                }
            }
            $this->data['tot_usedWallet'] = $tot_usedWallet;
            $this->load->view('admin/commission/display_wallet_lists', $this->data);
        }
    }


    public function display_commission_tracking_lists_old()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Commission Lists';
            $sellerDetails = $this->commission_model->get_all_details(USERS, array('group' => 'Seller', 'status' => 'Active'));
            $CommDetails = $this->commission_model->get_all_details(COMMISSION, array('id' => '3'));
            //echo '<pre>'; print_r($CommDetails->result()); die;
            if ($sellerDetails->num_rows() > 0) {
                foreach ($sellerDetails->result() as $sellerDetailsRow) {
                    $orderDetails[$sellerDetailsRow->id] = $this->commission_model->get_total_order_amount($sellerDetailsRow->id);
                    $refund_amt = $sellerDetailsRow->refund_amount;
                    $commission_to_admin[$sellerDetailsRow->id] = 0;
                    $amount_to_vendor[$sellerDetailsRow->id] = 0;
                    $total_amount = $tax_amount = $RemainAmt = $adminTotAmt = 0;
                    $this->data['total_amount'][$sellerDetailsRow->id] = $total_amount;
                    $this->data['tax_amount'][$sellerDetailsRow->id] = $tax_amount;
                    $this->data['remain_amount'][$sellerDetailsRow->id] = $RemainAmt;
                    $this->data['TotalAdminAmt'][$sellerDetailsRow->id] = $adminTotAmt;
                    //echo '<pre>'; print_r($orderDetails[$sellerDetailsRow->id]->result_array());
                    $total_orders = 0;
                    if ($orderDetails[$sellerDetailsRow->id]->num_rows() == 1) {
                        $commission_percentage = $CommDetails->row()->commission_percentage;
                        $total_amount = $orderDetails[$sellerDetailsRow->id]->row()->TotalAmt;
                        $tax_amount = $orderDetails[$sellerDetailsRow->id]->row()->TaxAmt;
                        $RemainAmt = $total_amount - $tax_amount;
                        $this->data['total_amount'][$sellerDetailsRow->id] = $total_amount;
                        $total_amount = $RemainAmt - $refund_amt;
                        $total_orders = $orderDetails[$sellerDetailsRow->id]->row()->orders;
                        if ($CommDetails->row()->promotion_type == 'percentage') {
                            $commission_to_admin[$sellerDetailsRow->id] = $total_amount * ($commission_percentage * 0.01);
                        } else {
                            $commission_to_admin[$sellerDetailsRow->id] = $total_orders * $commission_percentage;
                        }
                        if ($commission_to_admin[$sellerDetailsRow->id] < 0) $commission_to_admin[$sellerDetailsRow->id] = 0;
                        $amount_to_vendor[$sellerDetailsRow->id] = $total_amount - $commission_to_admin[$sellerDetailsRow->id];
                        if ($amount_to_vendor[$sellerDetailsRow->id] < 0) $amount_to_vendor[$sellerDetailsRow->id] = 0;
                    }
                    $paidDetails = $this->commission_model->get_total_paid_details($sellerDetailsRow->id);
                    $paid_to[$sellerDetailsRow->id] = 0;
                    if ($paidDetails->num_rows() == 1) {
                        $paid_to[$sellerDetailsRow->id] = $paidDetails->row()->totalPaid;
                        if ($paid_to[$sellerDetailsRow->id] < 0) $paid_to[$sellerDetailsRow->id] = 0;
                    }
                    $paid_to_balance[$sellerDetailsRow->id] = $amount_to_vendor[$sellerDetailsRow->id] - $paid_to[$sellerDetailsRow->id];
                    if ($paid_to_balance[$sellerDetailsRow->id] < 0) $paid_to_balance[$sellerDetailsRow->id] = 0;
                    $this->data['total_orders'][$sellerDetailsRow->id] = $total_orders;
                    $this->data['tax_amount'][$sellerDetailsRow->id] = $tax_amount;
                    $this->data['remain_amount'][$sellerDetailsRow->id] = $RemainAmt;
                    $this->data['commission_to_admin'][$sellerDetailsRow->id] = $commission_to_admin[$sellerDetailsRow->id];
                    $this->data['amount_to_vendor'][$sellerDetailsRow->id] = $amount_to_vendor[$sellerDetailsRow->id];
                    $this->data['TotalAdminAmt'][$sellerDetailsRow->id] = $tax_amount + $commission_to_admin[$sellerDetailsRow->id];
                    $this->data['paid_to'][$sellerDetailsRow->id] = $paid_to[$sellerDetailsRow->id];
                    $this->data['paid_to_balance'][$sellerDetailsRow->id] = $paid_to_balance[$sellerDetailsRow->id];
                }
            }
            //echo "<pre>"; print_r($this->data['tax_amount']); die;
            $this->data['sellerDetails'] = $sellerDetails;
            $this->load->view('admin/commission/display_tracking_lists', $this->data);
        }
    }

    public function view_paid_details()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Vendor payment details';
            $sid = $this->uri->segment(4, 0);
            $this->data['paidDetails'] = $this->commission_model->get_all_details(VENDOR_PAYMENT, array('vendor_id' => $sid));
            $this->load->view('admin/commission/view_paid_details', $this->data);
        }
    }

    /**
     *
     * This function loads payment form
     */
    public function add_pay_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
			
            $this->data['heading'] = 'Add vendor payment';
            $sid = $this->uri->segment(4, 0);
            $hostEmailQry = $this->commission_model->get_commission_track_id($sid);
            $product_id = $hostEmailQry->row()->prd_id;
            $hostEmail = $hostEmailQry->row()->host_email;
            $this->data['hostEmail'] = $hostEmail;
            $rental_booking_details = $this->commission_model->get_unpaid_commission_tracking($hostEmail);
            $payableAmount = 0;
            $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
            if (count($rental_booking_details) != 0) {
                foreach ($rental_booking_details as $rentals) {
                    /** Start - check if the dates reached **/
                    $totlessDays = $this->config->item('cancel_hide_days_property');
                    $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
                    $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                    $current_date = date('Y-m-d');
                    /** End - check if the dates reached **/
                    if ($checkinBeforeDay <= $current_date) {
                        $currencyPerUnitSeller = $rentals['currencyPerUnitSeller'];
						
						/** Start - minus the cancel amount if the guest cancel his property**/
						$canelAMount = $rentals['payable_amount'] - $rentals['paid_cancel_amount'];
						 /** End - minus the cancel amount if the guest cancel his property**/
                        if ($rentals['user_currencycode'] != $admin_currencyCode) {
                            if (!empty($currencyPerUnitSeller)) {
									

                                if ($rentals['cancelled'] == 'Yes') {
                                    $re_payable = currency_conversion($rentals['user_currencycode'], $admin_currencyCode, $canelAMount,$rentals['currency_cron_id']);
                                    //$re_payable = customised_currency_conversion($currencyPerUnitSeller, $canelAMount);
                                } else {
									$re_payable = currency_conversion($rentals['user_currencycode'], $admin_currencyCode, $rentals['payable_amount'],$rentals['currency_cron_id']);
                                    //$re_payable = customised_currency_conversion($currencyPerUnitSeller, $rentals['payable_amount']);
                                }
                               
                            } else {
                                $re_payable = 0;
                            }
                        } else {
                           
                            
                            if ($rentals['cancelled'] == 'Yes') {
                                $re_payable =  $canelAMount;
                            } else {
                                $re_payable = $rentals['payable_amount'];
                            }
                           
                        }
                        $payableAmount = ($payableAmount + $re_payable);


                    }
                }
            }


            $paidAmountQry = $this->commission_model->get_paid_details($hostEmail);
            $paidAmount = 0;
            $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
            if (count($paidAmountQry) != 0) {
                foreach ($paidAmountQry as $rental_paid) {
                    $currencyPerUnitSeller = $rental_paid['currencyPerUnitSeller'];
                    if ($rental_paid['currencycode'] != $admin_currencyCode) {
                        $cancel_amount = $rental_paid['subtotal'] / 100 * $rental_paid['cancel_percentage'];
                        /** Start - minus the cancel amount if the guest cancel his property**/
                        if ($rental_paid['cancelled'] == 'Yes') {
                            $lessAmount = $rental_paid['payable_amount'] - $cancel_amount;
                            $re_paid = customised_currency_conversion($currencyPerUnitSeller, $lessAmount);
                        } else {
                            $re_paid = customised_currency_conversion($currencyPerUnitSeller, $rental_paid['payable_amount']);
                        }
                        /** End - minus the cancel amount if the guest cancel his property**/
                    } else {
                        $cancel_amount = $rental_paid['subtotal'] / 100 * $rental_paid['cancel_percentage'];
                        /** Start - minus the cancel amount if the guest cancel his property**/
                        if ($rental_paid['cancelled'] == 'Yes') {
                            $re_paid = $rental_paid['payable_amount'] - $cancel_amount;
                        } else {
                            $re_paid = $rental_paid['payable_amount'];
                        }
                        /** End - minus the cancel amount if the guest cancel his property**/
                    }
                    $paidAmount = $paidAmount + $re_paid;
                }
            }
            $this->data['hostEmail'] = $hostEmail;
            $final_payable = $payableAmount;
            $this->data['payableAmount'] = $final_payable;
            $this->load->view('admin/commission/add_vendor_payment', $this->data);
        }
    }

    /**
     *
     * This function starts Paypal integration
     */
    public function paypal_payment()
    {
		
        $this->load->library('paypal_class');
        $return_url = base_url() . 'admin/commission/paypal_commission_success';
        $cancel_url = base_url() . 'admin/commission/paypal_commission_cancel';
        $notify_url = base_url() . 'admin/commission/paypal_commission_ipn';
        $item_name = $this->config->item('email_title') . ' Commission Payment';
        $checkInDate = $this->input->post('checkinDate');
        $bookingNo = $this->input->post('bookingNo');
        $totalAmount = $this->input->post('amount_to_pay');
        $amount_from_db = $this->input->post('amount_from_db');
        $hostEmail = $this->input->post('hostEmail');


        /**Start - Get unpaid booking numbers Compare with check in dates*/
        $Get_bk_numbers = $this->commission_model->get_unpaid_commission_tracking($hostEmail);
        foreach ($Get_bk_numbers as $rentals_up) {
            $totlessDays = $this->config->item('cancel_hide_days_experience');
            $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals_up['checkin']));
            $checkinBeforeDay = date('Y-m-d', $minus_checkin);
            $current_date_up = date('Y-m-d');
            if($checkinBeforeDay<=$current_date_up){
                $bk_numbers[]=$rentals_up['booking_no'];
            }
        }

        /**End - Get unpaid booking numbers Compare with check in dates*/
		
        $unpaid_bk_numbers_prop=array_unique($bk_numbers);
        $unpaid_bk_numbers=implode(",", $unpaid_bk_numbers_prop);
		
        $hostPayPalEmail = $this->input->post('hostPayPalEmail');
        $loginUserId = $this->checkLogin('A');
        $quantity = 1;
        $paypal_settings = unserialize($this->config->item('payment_0'));
        $paypal_settings = unserialize($paypal_settings['settings']);
        if ($paypal_settings['mode'] == 'sandbox') {
            $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   /* testing paypal url*/
        } else {
            $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
        }
        $ctype = ($paypal_settings['mode'] == 'sandbox') ? "USD" : "USD";
        $logo = base_url() . 'images/logo/' . $this->data['logo_img'];
        $this->paypal_class->add_field('currency_code', 'USD');
        $this->paypal_class->add_field('image_url', $logo);
        $this->paypal_class->add_field('business', trim($hostPayPalEmail)); /*Business Email -for pay to host*/
        $this->paypal_class->add_field('return', $return_url); /*Return URL*/
        $this->paypal_class->add_field('cancel_return', $cancel_url); /*Cancel URL*/
        $this->paypal_class->add_field('notify_url', $notify_url); /* Notify url*/
        $this->paypal_class->add_field('custom', $hostEmail . '|' . $amount_from_db . '|' . $checkInDate . '|' . $bookingNo . '|' .  $unpaid_bk_numbers); /* Custom Values*/
        $this->paypal_class->add_field('item_name', $item_name); /* Product Name*/
        $this->paypal_class->add_field('user_id', $loginUserId);
        $this->paypal_class->add_field('quantity', $quantity); /*Quantity*/
        $this->paypal_class->add_field('amount', $totalAmount); /* Price*/
        $this->paypal_class->submit_paypal_post();
    }


    /* paypal commission payment starts */
    function paypal_commission_success()
    {
        //get the transaction data
        /*$paypalInfo = $this->input->post();

          

        $data['item_number'] = $paypalInfo['item_name']; 

        $data['payment_amt'] = $paypalInfo["amount"];

        $data['currency_code'] = $paypalInfo['currency_code'];

        */
        $this->data['receiver_email'] = $_REQUEST['receiver_email'];
        $this->data['txn_id'] = $_REQUEST['txn_id'];
        $this->data['payer_email'] = $_REQUEST['payer_email'];
        // $this->data['hostEmail'] = $_REQUEST['custom'];
        $custom_values = explode('|', $_REQUEST['custom']);
        $this->data['hostEmail'] = $custom_values[0];
        $paypal_amount = $custom_values[1];
        $checkin = $custom_values[2];
        $bookingno = $custom_values[3];
        $unpaid_bk_num = $custom_values[4];
        $theCheckIn = explode(",", $checkin);
        $thebookingNo = explode(",", $bookingno);
        $unpaidThebookingNo = explode(",", $unpaid_bk_num);

        //print_r($this->data['txn_id']);
        /*

         $this->data['receiver_email'] = 'kailashkumar075@gmail.com';

         $this->data['txn_id '] = '3434ggfdhg5';

         $this->data['payer_email'] = 'admin@gmail.com';

         $this->data['hostEmail'] = 'vinodbabu@pofitec.com';

         */
        $this->data['mc_gross'] = $_REQUEST['mc_gross'];
        $this->data['currency_code'] = $_REQUEST['mc_currency'];
        /*

         $paypal_amount = $this->data['mc_gross'];



           if($this->data['currency_code']!=$this->data['admin_currency_code'])

                $paypal_amount = convertCurrency($this->data['currency_code'],$this->data['admin_currency_code'],$this->data['mc_gross']);



         //$paypal_amount;exit;

         */
        $dataArr = array(
            'host_email' => $this->data['hostEmail'],
            'transaction_id' => $this->data['txn_id'],
            'booking_no' => $unpaid_bk_num,
            'amount' => $paypal_amount,
            'status' => 'Paid'
        );
        //Commission update
        $this->commission_model->simple_insert(COMMISSION_PAID, $dataArr);
        $commission_paid_id=$this->commission_model->get_last_insert_id();

        /** Start - Update payment details if the dates reached and certain booking no **/
        foreach ($theCheckIn as $date) {
            $totlessDays = $this->config->item('cancel_hide_days_property');
            $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($date));
            $checkinBeforeDay = date('Y-m-d', $minus_checkin);
            $current_date = date('Y-m-d');
            if ($checkinBeforeDay <= $current_date) {
                foreach ($unpaidThebookingNo as $b_no) {
                    $this->commission_model->update_details(COMMISSION_TRACKING, array('paid_status' => 'yes','commission_paid_id'=>$commission_paid_id), array('booking_no' => $b_no));

                }
            }
            //$this->commission_model->update_details(COMMISSION_TRACKING, array('paid_status'=>'yes'), array('host_email'=>$this->data['hostEmail']));
        }

        /** End - Update payment details if the dates reachedv and certain booking no **/
        /*  Mail notification to host starts */
        //$host_details = $this->commission_model->ExecuteQuery('select user_name from '.USERS." where email='".$this->data['hostEmail'] ."' and account_type='1'");
        //$host_detail = $host_details->get();
        $adminnewstemplateArr = array(
            'news_subject' => 'HomeStay DNN - Commission Payment',
            'logo_image' => $this->config->item('logo_image'),
            'logo' => $this->config->item('logo_image'),
            'news_descrip' => $description,
            'email' => $this->config->item('email'),
            'title' => 'Commission Payment',
            'hostname' => 'Host'
        );
        extract($adminnewstemplateArr);
        $description = '<table class="ui-sortable-handle currentTable" border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#4f595b">

				<tbody>

				<tr>

				<td>

				<table class="devicewidth" style="background-color: #f8f8f8;" border="0" cellspacing="0" cellpadding="0" width="600" align="center">

				<tbody>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="left" bgcolor="#4f595b"><img src="' . base_url() . 'images/logo/' . $logo . '" alt="logo" /></td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td class="editable" style="color: #ffffff; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; text-transform: uppercase; padding: 8px 20px; background-color: #752b7e;" align="center" valign="middle">Hi ' . $hostname . ',</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<th style="color: #000; padding: 0px 20px; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="center"> Your commission amount(' . $paypal_amount . ' ' . $this->data['currency_code'] . ') is paid by  admin on ' . date('d/m/Y') . '.  </th>

				</tr>

				<tr>

				<td>&nbsp;</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td style="padding: 0px 20px; color: #444444; font-family: Open Sans, Arial, Helvetica, sans-serif; font-size: 13px;" align="left" valign="middle">

				<p>Thanks!</p>

				<p>The Home<span>StayDnn</span> Team</p>

				</td>

				</tr>

				<tr>

				<td height="30">&nbsp;</td>

				</tr>

				<tr>

				<td height="30" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td align="center" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				<tr>

				<td height="50" bgcolor="#4f595b">&nbsp;</td>

				</tr>

				</tbody>

				</table>

				</td>

				</tr>

				</tbody>

				</table>';
        $subject = 'From: ' . $this->config->item('email_title') . ' - ';
        $message .= '<!DOCTYPE HTML>

			<html>

			<head>

			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

			<meta name="viewport" content="width=device-width"/>

			<title>' . $news_subject . '</title><body>';
        $message .= $description;
        $message .= '</body>

			</html>';
        $email_values = array('mail_type' => 'html',
            'from_mail_id' => 'sales@laravelecommerce.com',
            'mail_name' => 'HomeStay DNN',
            'to_mail_id' => $this->data['hostEmail'],
            'subject_message' => 'HomeStay DNN - Commission Payment',
            'body_messages' => $message
        );
        $email_send_to_common = $this->commission_model->common_email_send($email_values);
        //print_r($email_send_to_common);die;
        /*  Mail notification to host ends */
        $this->setErrorMessage('error', 'Commission Payment is competed');
        redirect('admin/commission/display_commission_tracking_lists');
        //pass the transaction data to view
        //$this->data['heading'] = "Payment Cancelled";
        //$this->load->view('admin/commission/paypal_success', $this->data);
    }


    function paypal_commission_cancel()
    {
        $this->data['heading'] = "Payment Cancelled";
        $this->load->view('admin/commission/paypal_cancel', $this->data);
    }


    function paypal_commission_ipn()
    {
        /*

       $paypalInfo = $this->input->post();





           $dataArr = array(

               'host_email'	=>	'vinodbabu@pofitec.com',

               'amount'		=>'210.28'

           );

       //	print_r($dataArr); die;

           $this->commission_model->simple_insert(COMMISSION_PAID,$dataArr);

           $this->commission_model->update_details(COMMISSION_TRACKING, array('paid_status'=>'yes'), array('host_email'=>$paypalInfo['hostEmail']));

           redirect('admin/commission/display_commission_tracking_lists');

       */
    }


    public function add_pay_form_old()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Add vendor payment';
            $sid = $this->uri->segment(4, 0);
            $this->data['sellerDetails'] = $this->commission_model->get_all_details(USERS, array('group' => 'Seller', 'id' => $sid));
            $CommDetails = $this->commission_model->get_all_details(COMMISSION, array('id' => '3'));
            if ($this->data['sellerDetails']->num_rows() == 1) {
                $this->data['orderDetails'] = $this->commission_model->get_total_order_amount($sid);
                $commission_percentage = $CommDetails->row()->commission_percentage;
                $total_amount = $tax_amount = $RemainAmt = $adminTotAmt = 0;
                if ($this->data['orderDetails']->num_rows() == 1) {
                    $total_amount = $this->data['orderDetails']->row()->TotalAmt;
                    $tax_amount = $this->data['orderDetails']->row()->TaxAmt;
                    $RemainAmt = $total_amount - $tax_amount;
                    $this->data['total_amount'] = $total_amount;
                    $total_amount = $RemainAmt - $refund_amt;
                    $total_orders = $this->data['orderDetails']->row()->orders;
                    if ($CommDetails->row()->promotion_type == 'percentage') {
                        $commission_to_admin = $total_amount * ($commission_percentage * 0.01);
                    } else {
                        $commission_to_admin = $total_orders * $commission_percentage;
                    }
                }
                $total_amount = $total_amount - $this->data['sellerDetails']->row()->refund_amount;
                if ($commission_to_admin < 0) $commission_to_admin = 0;
                $amount_to_vendor = $total_amount - $commission_to_admin;
                if ($amount_to_vendor < 0) $amount_to_vendor = 0;
                $this->data['paidDetails'] = $this->commission_model->get_total_paid_details($sid);
                $paid_to = 0;
                if ($this->data['paidDetails']->num_rows() == 1) {
                    $paid_to = $this->data['paidDetails']->row()->totalPaid;
                    if ($paid_to < 0) $paid_to = 0;
                }
                $paid_to_balance = $amount_to_vendor - $paid_to;
                if ($paid_to_balance < 0) $paid_to_balance = 0;
                $this->data['commission_to_admin'] = $commission_to_admin;
                $this->data['amount_to_vendor'] = $amount_to_vendor;
                $this->data['paid_to'] = $paid_to;
                $this->data['paid_to_balance'] = $paid_to_balance;
                $this->load->view('admin/commission/add_vendor_payment', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    public function add_vendor_payment()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            /*			$balance = $this->input->post('balance_due');
                        $amount = $this->input->post('amount');
                        if ($amount>$balance){
                            $this->setErrorMessage('error','Amount exceeds the balance due');
                            echo "<script>window.history.go(-1);</script>";exit();
                        }else {
                            $trans_id = $this->input->post('transaction_id');
                            $duplicateCheck = $this->commission->get_all_details(VENDOR_PAYMENT,array('transaction_id'=>$trans_id));
                            if ($duplicateCheck->num_rows()>0){
                                $this->setErrorMessage('error','Transaction id already exists');
                                echo "<script>window.history.go(-1);</script>";exit();
                            }else {
                                $excludeArr = array('balance_due');
                                $this->commission->commonInsertUpdate(VENDOR_PAYMENT,'insert',$excludeArr,array());
                                $this->setErrorMessage('success','Payment added successfully');
                                redirect('admin/commission/view_paid_details/'.$this->input->post('vendor_id'));
                            }
                        }
            */
            $balance = $this->input->post('balance_due');
            $amount = $this->input->post('amount');
            $seller_id = $this->input->post('vendor_id');
            if ($amount > $balance) {
                $this->setErrorMessage('error', 'Amount exceeds the balance due');
                echo "<script>window.history.go(-1);</script>";
                exit();
            } else {
                $randNumber = mt_rand();
                $key = 'team-fancyy-clone-tweaks';
                $encrypted_string = $this->encrypt->encode($randNumber, $key);
                $dataArr = array(
                    'transaction_id' => $randNumber,
                    'payment_type' => 'paypal',
                    'amount' => $amount,
                    'status' => 'pending',
                    'vendor_id' => $seller_id
                );
                $this->commission_model->simple_insert(VENDOR_PAYMENT, $dataArr);
                $this->data['randNumber'] = $randNumber;
                $this->data['code'] = $encrypted_string;
                $this->data['amount'] = $amount;
                $this->data['admin_id'] = $this->encrypt->encode($this->checkLogin('A'), $key);
                $this->data['seller_id'] = $this->encrypt->encode($seller_id, $key);
                $this->data['paypal_email'] = $this->input->post('paypal_email');
                $this->load->view('admin/commission/paypal_form', $this->data);
            }
        }
    }

    /**
     *
     * This function load the vendor payment
     */
    public function add_vendor_payment_manual()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $rental_booking_details = $this->commission_model->get_unpaid_commission_tracking($this->input->post('hostEmail'));
            $payableAmount = 0;
            $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
            if (count($rental_booking_details) != 0) {
                foreach ($rental_booking_details as $rentals) {
                    /** Start - Update payment details if the dates reached **/
                    $totlessDays = $this->config->item('cancel_hide_days_property');
                    $minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($rentals['checkin']));
                    $checkinBeforeDay = date('Y-m-d', $minus_checkin);
                    $current_date = date('Y-m-d');
                    if ($checkinBeforeDay <= $current_date) {
                        $currencyPerUnitSeller = $rentals['currencyPerUnitSeller'];
                        if ($rentals['currencycode'] != $admin_currencyCode) {
                            if (!empty($currencyPerUnitSeller)) {
                                $cancel_amount = $rentals['subtotal'] / 100 * $rentals['cancel_percentage'];
                                /** Start - minus the cancel amount if the guest cancel his property**/
                                if ($rentals['cancelled'] == 'Yes') {
                                    $lessAmount = $rentals['payable_amount'] - $cancel_amount;
                                    $re_payable = customised_currency_conversion($currencyPerUnitSeller, $lessAmount);
                                } else {
                                    $re_payable = customised_currency_conversion($currencyPerUnitSeller, $rentals['payable_amount']);
                                }
                                /** End - minus the cancel amount if the guest cancel his property**/
                            } else {
                                $re_payable = 0;
                            }
                        } else {
                            $cancel_amount = $rentals['subtotal'] / 100 * $rentals['cancel_percentage'];
                            /** Start - minus the cancel amount if the guest cancel his property**/
                            if ($rentals['cancelled'] == 'Yes') {
                                $re_payable = $rentals['payable_amount'] - $cancel_amount;
                            } else {
                                $re_payable = $rentals['payable_amount'];
                            }
                            /** End - minus the cancel amount if the guest cancel his property**/
                        }
                        $payableAmount = ($payableAmount + $re_payable);
                       // $this->commission_model->update_details(COMMISSION_TRACKING, array('paid_status' => 'yes'), array('booking_no' => $rentals['booking_no']));
                        $booking_numbers[]=$rentals['booking_no']; //Booking Numbers for this transaction
                    }
                    /** End - Update payment details if the dates reached **/
                }
            }

            $makeComma=implode(',',$booking_numbers);

            $dataArr = array(
                'host_email' => $this->input->post('balance_due'),
                'transaction_id' => $this->input->post('transaction_id'),
                'booking_no' =>  $makeComma,
                'amount' => $payableAmount,
                'status' => 'paid'
            );
            $this->commission_model->simple_insert(COMMISSION_PAID, $dataArr);
            $getInsertId = $this->commission_model->get_last_insert_id();
            foreach($booking_numbers as $com_up){
                $this->commission_model->update_details(COMMISSION_TRACKING, array('commission_paid_id' => $getInsertId,'paid_status' => 'yes'), array('booking_no' => $com_up));
            }
            redirect('admin/commission/display_commission_tracking_lists');
        }
    }

    public function add_vendor_payment_manual_old()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $balance = $this->input->post('balance_due');
            $amount = $this->input->post('amount');
            if ($amount > $balance) {
                $this->setErrorMessage('error', 'Amount exceeds the balance due');
                echo "<script>window.history.go(-1);</script>";
                exit();
            } else {
                $trans_id = $this->input->post('transaction_id');
                $duplicateCheck = $this->commission_model->get_all_details(VENDOR_PAYMENT, array('transaction_id' => $trans_id));
                if ($duplicateCheck->num_rows() > 0) {
                    $this->setErrorMessage('error', 'Transaction id already exists');
                    echo "<script>window.history.go(-1);</script>";
                    exit();
                } else {
                    $excludeArr = array('balance_due');
                    $this->commission_model->commonInsertUpdate(VENDOR_PAYMENT, 'insert', $excludeArr, array());
                    $this->setErrorMessage('success', 'Payment added successfully');
                    redirect('admin/commission/view_paid_details/' . $this->input->post('vendor_id'));
                }
            }
        }
    }

    public function display_payment_success()
    {
        if ($this->checkLogin('A') != '') {
            $msg = $this->input->get('msg');
            if ($msg == 'success') {
                $key = 'team-fancyy-clone-tweaks';
                $randNumber = $this->encrypt->decode($this->input->get('trans'), $key);
                $seller_id = $this->encrypt->decode($this->input->get('sellId'), $key);
                $admin_id = $this->encrypt->decode($this->input->get('modeVal'), $key);
                if ($admin_id == $this->checkLogin('A')) {
                    $dataArr = array(
                        'status' => 'success',
                    );
                    $this->commission_model->update_details(VENDOR_PAYMENT, $dataArr, array('transaction_id' => $randNumber, 'vendor_id' => $seller_id));
                    $this->data['heading'] = 'Payment Success';
                    $this->load->view('admin/commission/payment_success', $this->data);
                } else {
                    redirect('admin');
                }
            }
        } else {
            redirect('admin');
        }
    }

    public function display_payment_failed()
    {
        if ($this->checkLogin('A') != '') {
            $this->data['heading'] = 'Payment Failure';
            $this->load->view('admin/commission/payment_failed', $this->data);
        } else {
            redirect('admin');
        }
    }

    public function commission_pay()
    {
    }

    public function add_pay_form_rep()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Add vendor payment';
            $sid = $this->uri->segment(4, 0);
            $hostEmailQry = $this->commission_model->get_commission_track_ids($sid);
            $product_id = $hostEmailQry->row()->prd_id;
            $hostEmail = $hostEmailQry->row()->host_email;
            $this->data['hostEmail'] = $hostEmail;
            $rental_booking_details = $this->commission_model->get_unpaid_commission_trackings($hostEmail);
            $payableAmount = 0;
            /*if(count($rental_booking_details) != 0){
                foreach($rental_booking_details as $rentals)
                {

                    $payableAmount = $payableAmount + AdminCurrencyValue($rentals['prd_id'],$rentals['payable_amount']);


                    }
                }*/
            $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
            //print_r($rental_booking_details);
            if (count($rental_booking_details) != 0) {
                foreach ($rental_booking_details as $rentals) {
                    $currencyPerUnitSeller = $rentals['currencyPerUnitSeller'];
                    if ($rentals['currencycode'] != $admin_currencyCode) {
                        if (!empty($currencyPerUnitSeller))
                            $re_payable = customised_currency_conversion($currencyPerUnitSeller, $rentals['payable_amount']);
                        else
                            $re_payable = 0;
                    } else {
                        $re_payable = $rentals['payable_amount'];
                    }
                    $payableAmount = ($payableAmount + $re_payable);
                    //print_r(AdminCurrencyValue);
                }
            }
            $paidAmountQry = $this->commission_model->get_paid_detailss($hostEmail);
            $paidAmount = 0;
            /*if(count($paidAmountQry) != 0){
                foreach($paidAmountQry as $rental_paid)
                {
                $paidAmount =$paidAmount + AdminCurrencyValue($rental_paid['prd_id'],$rental_paid['payable_amount']);
                }
            }*/
            $admin_currencyCode = $this->session->userdata('fc_session_admin_currencyCode');
            if (count($paidAmountQry) != 0) {
                foreach ($paidAmountQry as $rental_paid) {
                    $currencyPerUnitSeller = $rental_paid['currencyPerUnitSeller'];
                    if ($rental_paid['currencycode'] != $admin_currencyCode) {
                        $re_paid = customised_currency_conversion($currencyPerUnitSeller, $rental_paid['payable_amount']);
                    } else {
                        $re_paid = $rental_paid['payable_amount'];
                    }
                    $paidAmount = $paidAmount + $re_paid;
                }
            }
            $this->data['hostEmail'] = $hostEmail;
            if ($payableAmount > $paidAmount) {
                $final_payable = number_format($payableAmount - $paidAmount, 2, '.', '');
            } else {
                $final_payable = 0;
            }
            $this->data['payableAmount'] = $final_payable;
            //$this->data['payableAmount'] = number_format($payableAmount-$paidAmount, 2, '.', '');
            $this->load->view('admin/commission/add_vendor_payment _rep', $this->data);
        }
    }

    public function add_vendor_payment_manual_rep()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            //echo "<pre>";	print_r($this->input->post());
            $rental_booking_details = $this->commission_model->get_unpaid_commission_trackings($this->input->post('hostEmail'));
            $payableAmount = 0;
            if (count($rental_booking_details) != 0) {
                foreach ($rental_booking_details as $rentals) {
                    $payableAmount = $payableAmount + $rentals['payable_amount'];
                }
            }
            $dataArr = array(
                'host_email' => $this->input->post('balance_due'),
                'transaction_id' => $this->input->post('transaction_id'),
                'amount' => $payableAmount
            );
            //	print_r($dataArr); die;
            $this->commission_model->simple_insert(COMMISSION_PAID, $dataArr);
            $this->commission_model->update_details(COMMISSION_REP_TRACKING, array('paid_status' => 'yes'), array('host_email' => $this->input->post('hostEmail')));
            redirect('admin/commission/display_commission_representative_lists');
        }
    }


}

/* End of file commission.php */
/* Location: ./application/controllers/admin/commission.php */
