<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Managing orders payment-success or failure and any at all.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class Order extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper(array('cookie', 'date', 'form', 'email'));
            $this->load->library(array('encrypt', 'form_validation'));
            $this->load->model('order_model');
            $this->load->model('user_model');
			$this->load->helper('currency_helper');
            $this->load->model('product_model');
            $this->load->model('contact_model');
            if ($_SESSION['sMainCategories'] == '') {
                $sortArr1 = array('field' => 'cat_position', 'type' => 'asc');
                $sortArr = array($sortArr1);
                $_SESSION['sMainCategories'] = $this->order_model->get_all_details(CATEGORY, array('rootID' => '0', 'status' => 'Active'), $sortArr);
            }
            $this->data['mainCategories'] = $_SESSION['sMainCategories'];
            if ($_SESSION['sColorLists'] == '') {
                $_SESSION['sColorLists'] = $this->order_model->get_all_details(LIST_VALUES, array('list_id' => '1'));
            }
            $this->data['mainColorLists'] = $_SESSION['sColorLists'];
            $this->data['loginCheck'] = $this->checkLogin('U');
        }

        /*Order landing- manages order payment success and failure*/
        public function index()
        {
			
            $this->data['heading'] = 'Order Confirmation';
            $paidAmount = $couponUsedAmount = $walletUsedAmount = '0.00';
            if ($this->uri->segment(2) == 'success') {
				//invoicedata
                if ($this->uri->segment(5) == '') {
                    $transId = $_REQUEST['txn_id'];
                    $Pray_Email = $_REQUEST['payer_email'];
                } else {
                    $transId = $this->uri->segment(5);
                    $Pray_Email = '';
                }
                $UserNo = $this->uri->segment(3);
                $DealCodeNo = $this->uri->segment(4);
				
                $EnquiryUpdate = $this->order_model->get_all_details(PAYMENT, array('dealCodeNumber' => $DealCodeNo));
                $eprd_id = $EnquiryUpdate->row()->product_id;
                $eInq_id = $EnquiryUpdate->row()->EnquiryId;
                $totalAmt = $EnquiryUpdate->row()->total;
                $this->data['paid_amount'] = $totalAmt;
                $this->data['paid_curr_code'] = $EnquiryUpdate->row()->currency_code;
                $couponses = $this->session->userdata('coupon_strip');
                $coupon = explode('-', $couponses);
				
                if ($coupon['0'] != '') {
                    $data = array('is_coupon_used' => 'Yes', 'discount_type' => $coupon['4'], 'coupon_code' => $coupon['0'], 'discount' => $coupon['2'], 'dval' => $coupon['1'], 'total_amt' => $coupon['9']  //from prdcurrency amount
                    );
                    //$this->session->unset_userdata('coupon_strip');
                    $this->session->unset_userdata(array('coupon_strip'));
                    $this->order_model->update_details(PAYMENT, $data, array('dealCodeNumber' => $DealCodeNo));
                    $data = array('code' => trim($coupon['0']));
                    $couponi = $this->order_model->get_all_details(COUPONCARDS, $data);
                    $data = array('purchase_count' => $couponi->row()->purchase_count + 1, 'card_status' => 'redeemed');
                    $this->order_model->update_details(COUPONCARDS, $data, array('id' => $couponi->row()->id));
                }
                $booked_data_Q = $this->order_model->get_all_details(PAYMENT, array('user_id' => $UserNo, 'dealCodeNumber' => $DealCodeNo));
                $currencyCode = $booked_data_Q->row()->currency_code;
                $wallet = $this->session->userdata('wallet_strip');
                $wallet = explode('`', $wallet);
                //wallet
                $referred_userData = $this->order_model->get_all_details(USERS, array('id' => $UserNo));
                $existAmount = $referred_userData->row()->referalAmount;
                $exit_totalReferalAmount = $referred_userData->row()->totalReferalAmount;
                $existAmountCurrenctCode = $referred_userData->row()->referalAmount_currency;
                if ($existAmountCurrenctCode != 'USD') {
                    $existAmount = convertCurrency($existAmountCurrenctCode, 'USD', $existAmount);
                    $exit_totalReferalAmount = convertCurrency($existAmountCurrenctCode, 'USD', $exit_totalReferalAmount);
                }
                // echo "<pre>";
                //  print_r($wallet);
                // echo $existAmountCurrenctCode;
                //exit();
                if ($this->session->userdata('currency_type') != 'USD') {

                    $remindWallet = convertCurrency($existAmountCurrenctCode, $this->session->userdata('currency_type'), $wallet['11']);
                    // echo $existAmount.'<br>';
                    // $remindWallet = $wallet['11'];
                    //  echo $remindWallet;

                }
                else{
                    $remindWallet = $wallet['11'];
                    //$remindWallet = $wallet['11'];
                }


                //$remindWallet = $existAmount - $wallet['1'];
                /* echo $remindWallet;
             print_r($wallet);
                 exit();*/

                if (isset($_SESSION['wallet_strip'])) {

                    if ($wallet['0'] != '') {
                        if ($this->session->userdata('currency_type') != $currencyCode) {
                            $wal_amnt = convertCurrency($this->session->userdata('currency_type'), $currencyCode, $wallet['12']);
                        }
                        else{
                            $wal_amnt = $wallet['12'];/*subtotal*/
                        }

                        //  $data = array('is_wallet_used' => $wallet['0'], 'wallet_Amount' => $wal_amnt);

                        $data = array('is_wallet_used' => 'Yes',
                            'discount_type' => 0,
                            'discount' => $wallet['1'],/*Wallet total amount*/
                            'total_amt' => $wallet['12'], /*subtotal*/
                            'wallet_Amount' => $wal_amnt //from prdcurrency amount
                        );
                        //print_r($data);exit();

                        $walletUsedAmount = $wallet['12'];/*subtotal*/
                        //$this->session->unset_userdata('wallet_strip');
                        $this->session->unset_userdata(array('wallet_strip'));
                        $this->order_model->update_details(PAYMENT, $data, array('dealCodeNumber' => $DealCodeNo));
                        $data = array('walletAmount' => $walletUsedAmount);
                        $this->order_model->update_details(RENTALENQUIRY, $data, array('id' => $eInq_id));
                        $userQ = $this->order_model->get_all_details(USERS, array('id' => $UserNo));
                        /*Added the remaining amount to total wallet amount*/
                        $get_wallet_exist_amt = $userQ->row()->totalReferalAmount;
                        $wallet_bal_added = $get_wallet_exist_amt + $wallet_balance;
                        if ($userQ->row()->referalAmount_currency != $currencyCode) {
                            $remindWallet = currency_conversion($currencyCode, $userQ->row()->referalAmount_currency, $remindWallet);

                        } else {
                            $remindWallet = $remindWallet;

                        }
                        $newdata = array('referalAmount' => $remindWallet);
                        $condition = array('id' => $this->checkLogin('U'));
                        $this->order_model->update_details(USERS, $newdata, $condition);
                    }
                }
                $this->data['invoicedata'] = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $eInq_id));
                $condition1 = array('user_id' => $UserNo, 'prd_id' => $eprd_id, 'id' => $eInq_id);
                $dataArr1 = array('booking_status' => 'Booked');
                $this->order_model->update_details(RENTALENQUIRY, $dataArr1, $condition1); // need to uncomment
                $this->data['Confirmation'] = $this->order_model->PaymentSuccess($this->uri->segment(3), $this->uri->segment(4), $transId, $Pray_Email);
                $SelBookingQty = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $eInq_id));
                $productId = $SelBookingQty->row()->prd_id;
                $arrival = $SelBookingQty->row()->checkin;
                $depature = $SelBookingQty->row()->checkout;
                $dates = $this->getDatesFromRange($arrival, $depature);
                $i = 1;
                $dateMinus1 = count($dates) - 1;
                foreach ($dates as $date) {
                    if ($i <= $dateMinus1) {
                        $BookingArrorder_review = $this->contact_model->get_all_details(CALENDARBOOKING, array('PropId' => $productId, 'id_state' => 1, 'id_item' => 1, 'the_date' => $date));
                        if ($BookingArr->num_rows > 0) {
                        } else {
                            $dataArr = array('PropId' => $productId, 'id_state' => 1, 'id_item' => 1, 'the_date' => $date);
                            $this->contact_model->simple_insert(CALENDARBOOKING, $dataArr);
                        }
                    }
                    $i++;
                }
                $DateArr = $this->product_model->get_all_details(CALENDARBOOKING, array('PropId' => $productId));
                $dateDispalyRowCount = 0;
                $dateArrVAl = '';
                //schedule_change
                $schedule_q = $this->product_model->get_all_details(SCHEDULE, array('id' => $productId));
                $sched = $schedule_q->row()->data;
                $data_old = json_decode($sched, true);
                // echo 'before booked<br>';
                // echo "<per>";
                // print_r($data_old); echo "<br>";
                $price = 0;
                if ($DateArr->num_rows() > 0) {
                    $dateArrVAl .= '{';
                    foreach ($DateArr->result() as $dateDispalyRow) {
                        if ($dateDispalyRowCount == 0) {
                            $dateArrVAl .= '"' . $dateDispalyRow->the_date . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"booked"}';
                        } else {
                            $dateArrVAl .= ',"' . $dateDispalyRow->the_date . '":{"available":"1","bind":0,"info":"","notes":"","price":"' . $price . '","promo":"","status":"booked"}';
                        }
                        $dateDispalyRowCount = $dateDispalyRowCount + 1;
                    }
                    $dateArrVAl .= '}';
                }
                // echo count($data_old);exit();
                // echo 'new booked';
                // echo "<per>";
                // print_r($dateArrVAl);echo "----------------------<br>";
                if(count($data_old) > 0)
                {
                    $decoded = json_decode($dateArrVAl, true);
                    $dateArrVAl = array_merge($decoded, $data_old);
                    $dateArrVAl = json_encode($dateArrVAl);
                }

                // echo 'after booked';
                // echo "<per>";
                // print_r($dateArrVAl);exit;
                $inputArr4 = array('id' => $productId, 'data' => trim($dateArrVAl));
                $this->product_model->update_details(SCHEDULE, $inputArr4, array('id' => $productId));

                $condition = array('status' => 'Active', 'seo_tag' => 'host-listing');
                $service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition);
                $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
                $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
                $condition = array('status' => 'Active', 'seo_tag' => 'guest-booking');
                $service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
                $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
                $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
                $orderDetails = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $eInq_id));
                $userDetails = $this->order_model->get_all_details(USERS, array('id' => $orderDetails->row()->renter_id));
                $guest_fee = $orderDetails->row()->serviceFee;
                $netAmount = $orderDetails->row()->totalAmt - $guest_fee;
                if ($this->data['host_tax_type'] == 'flat') {
                    $host_fee = 0;
                } else {
                    $host_fee = 0;
                }
                $payable_amount = $netAmount - $host_fee;
				//echo $userDetails->row()->rep_code; exit;
                if ($userDetails->row()->rep_code != '') {
                    $condition = array('status' => 'Active', 'seo_tag' => 'host-accept-rep');
                    $service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
                    $this->data['rep_host'] = $service_tax_guest->row()->promotion_type;
                    $this->data['rep_guest'] = $service_tax_guest->row()->commission_percentage;
                    $condition = array('status' => 'Active', 'seo_tag' => 'guest-accept-rep');
                    $service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
                    $this->data['rep_host_rep'] = $service_tax_guest->row()->promotion_type;
                    $this->data['rep_guest_rep'] = $service_tax_guest->row()->commission_percentage;
                    if ($this->data['rep_host'] == 'flat') {
                        $rep_fees = $this->data['rep_host'];
                    } else {
                        $rep_all = $this->data['rep_guest'] / 100;
                        $rep_fees = ($netAmount * $this->data['host_tax_value']) / 100;
                    }
                    $rep_fee = $netAmount * $rep_all;
                    $data2 = array('host_email' => $userDetails->row()->email, 'booking_no' => $orderDetails->row()->Bookingno, 'total_amount' => $orderDetails->row()->totalAmt, 'guest_fee' => $guest_fee, 'host_fee' => $rep_fees, 'rep_fee' => $rep_fee, 'code' => $userDetails->row()->rep_code, 'payable_amount' => $rep_fee);
                    $chkQry = $this->order_model->get_all_details(COMMISSION_REP_TRACKING, array('booking_no' => $orderDetails->row()->Bookingno));
                    if ($chkQry->num_rows() == 0) $this->product_model->simple_insert(COMMISSION_REP_TRACKING, $data2); else
                        $this->product_model->update_details(COMMISSION_REP_TRACKING, $data2, array('booking_no' => $orderDetails->row()->Bookingno));
                    $data1 = array('host_email' => $userDetails->row()->email, 'booking_no' => $orderDetails->row()->Bookingno, 'total_amount' => $EnquiryUpdate->row()->total, 'guest_fee' => $guest_fee, 'host_fee' => $host_fee, 'cancel_percentage' => $orderDetails->row()->cancel_percentage, 'subtotal' => $orderDetails->row()->subTotal, 'payable_amount' => $payable_amount, 'booking_walletUse' => $walletUsedAmount //malar - wallet amount used on payment
                    );
                    $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING, array('booking_no' => $orderDetails->row()->Bookingno));
                    if ($chkQry->num_rows() == 0) $this->product_model->simple_insert(COMMISSION_TRACKING, $data1); else
                        $this->product_model->update_details(COMMISSION_TRACKING, $data1, array('booking_no' => $orderDetails->row()->Bookingno));
						
						
                } else {
					
					//$payable_amount = $orderDetails->row()->totalAmt - $guest_fee;
                    $data1 = array('host_email' => $userDetails->row()->email, 'booking_no' => $orderDetails->row()->Bookingno, 'total_amount' => $orderDetails->row()->totalAmt, 'guest_fee' => $guest_fee, 'host_fee' => $host_fee, 'cancel_percentage' => $orderDetails->row()->cancel_percentage, 'subtotal' => $orderDetails->row()->subTotal, 'payable_amount' => $payable_amount, 'booking_walletUse' => $walletUsedAmount //malar - wallet amount used on payment
                    );
                    $chkQry = $this->order_model->get_all_details(COMMISSION_TRACKING, array('booking_no' => $orderDetails->row()->Bookingno));
					//echo $chkQry->num_rows().'<br>';print_r($data1); exit;
                    if ($chkQry->num_rows() == 0) $this->product_model->simple_insert(COMMISSION_TRACKING, $data1); else
                        $this->product_model->update_details(COMMISSION_TRACKING, $data1, array('booking_no' => $orderDetails->row()->Bookingno));
						
                }
				
			
                $this->booking_conform_mail($DealCodeNo);
                $this->data['Confirmation'] = 'Success';
                $this->data['productId'] = $productId;
                $this->load->view('site/order/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'failure') {
                $this->data['Confirmation'] = 'Failure';
                $this->data['errors'] = $this->session->userdata('payment_error');
                $this->session->unset_userdata('payment_error');
                $this->load->view('site/order/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'failureList') {
                $this->data['Confirmation'] = 'failureList';
                $this->data['errors'] = $this->session->userdata('payment_error');
                $this->session->unset_userdata('payment_error');
                $this->load->view('site/order/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'notify') {
                $this->data['Confirmation'] = 'Failure';
                $this->load->view('site/order/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'confirmation') {
                $this->data['Confirmation'] = 'Success';
                $this->load->view('site/order/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'pakagesuccess') {
                $this->memberPackageUpdate($this->uri->segment(3));
            }
        }

        public function memberPackageUpdate($user_ID)
        {
            $condition = array('user_id' => $user_ID);
            $dataArr = array('package_status' => "Paid");
            $this->product_model->commonInsertUpdate(USERS, 'update', array('user_id'), array('package_status' => "Paid"), array('id' => $user_ID));
            $this->product_model->commonInsertUpdate(PRODUCT, 'update', $excludeArr, $dataArr, $condition);
            $this->memberPackagePurchaseEmail($user_ID);
            redirect(base_url('plan'));
        }
        /*Mail for success booking*/
        public function booking_conform_mail($paymentid)
        {
			
			//echo $paymentid;
            $PaymentSuccess = $this->order_model->get_all_details(PAYMENT, array('dealCodeNumber' => $paymentid));
			
            $Renter_details = $this->order_model->get_all_details(USERS, array('id' => $PaymentSuccess->row()->sell_id));
            $user_details = $this->order_model->get_all_details(USERS, array('id' => $PaymentSuccess->row()->user_id));
            $Rental_details = $this->order_model->get_all_details(PRODUCT, array('id' => $PaymentSuccess->row()->product_id));
            $Contact_details = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
			
            /*---------------email to user---------------------------*/
            $newsid = '29';
            $template_values = $this->order_model->get_newsletter_template_details($newsid);
            $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values['news_subject'];
            $proImages = base_url() . 'images/rental/' . $RentalPhoto->row()->product_image;
            $chkIn = date('d-m-y', strtotime($Contact_details->row()->checkin));
            $chkOut = date('d-m-y', strtotime($Contact_details->row()->checkout));
            $user_image = $user_details->row()->image;
            $user_type = $user_details->row()->loginUserType;
            $user_types = $user_type;
            if ($user_image != '') {
                if ($user_types == 'google') {
                    $user_image = $user_image;
                } elseif ($user_types != '') {
                    $user_image = base_url() . 'images/users/' . $user_image;
                }
            } else {
                $user_image = base_url() . 'images/users/profile.png';
            }
            $renter_image = $Renter_details->row()->image;
            $renter_type = $Renter_details->row()->loginUserType;
            if ($renter_image != '') {
                if ($renter_type == 'google') {
                    $renter_image = $renter_image;
                } elseif ($renter_type != '') {
                    $renter_image = base_url() . 'images/users/' . $renter_image;
                }
            } else {
                $renter_image = base_url() . 'images/users/profile.png';
            }
            /***************************************currency****************************/
			$productCurrency = $Rental_details->row()->currency;
			$currency = $Rental_details->row()->currency;
			
			$guest_currency_type = $this->session->userdata('currency_type');
			$guestCurrencySymbol = $currency_symbol = $this->session->userdata('currency_s');
			$singleNight = $Rental_details->row()->price;
			$noofnights = $Contact_details->row()->numofdates;
			$subTot = $singleNight*$noofnights;
			$servicefee = $Contact_details->row()->serviceFee;
			$secDeposit = $Rental_details->row()->security_deposit;
			$secDeposit = $Rental_details->row()->security_deposit;
			
			
			/**Coupon Amount**/
			if ($PaymentSuccess->row()->is_coupon_used == 'Yes') {
            $couponDiscount = $PaymentSuccess->row()->total_amt - $PaymentSuccess->row()->discount;
			//$couponDiscount = number_format($couponDiscount,2); 
            if($guest_currency_type != $Contact_details->row()->user_currencycode)
			{

               //  echo $guest_currency_type;
				$coupondiscount = currency_conversion($guest_currency_type,$guest_currency_type,$couponDiscount);
			}
			else
			{

				$coupondiscount  = $couponDiscount;
			}
			}  
		//	echo $coupondiscount;exit();
		
			/**Wallet Amount**/
            // echo $PaymentSuccess->row()->wallet_Amount;
            // echo $PaymentSuccess->row()->total_amt;exit();

			if ($PaymentSuccess->row()->is_wallet_used == 'Yes') {
            $wallet_Amount = $PaymentSuccess->row()->wallet_Amount;

           // echo $PaymentSuccess->row()->currency_code;

            if($guest_currency_type!=$Contact_details->row()->user_currencycode)
			{
                if($PaymentSuccess->row()->currency_code != $guest_currency_type)
                {
				$wallet_Amount = currency_conversion($Contact_details->row()->user_currencycode,$guest_currency_type, $wallet_Amount);
            }
            else{
                $wallet_Amount  = $wallet_Amount;
            }
			}
			else
			{
				$wallet_Amount  = $wallet_Amount;
			}
			} else {

				$wallet_Amount = '0.00';
			} 
			
			//echo $wallet_Amount;exit();
			
			//BRL!=USD // all need to go as USD
			if($productCurrency!=$guest_currency_type)
			{
				$guestSingleNight = currency_conversion($productCurrency,$guest_currency_type, $singleNight);
				$guestSubTot = currency_conversion($productCurrency,$guest_currency_type, $subTot);
				$guestSecDep = currency_conversion($productCurrency,$guest_currency_type,$secDeposit);
                $guestServ_fee_is = currency_conversion($productCurrency,$guest_currency_type,$servicefee);
				
				
			}
			else
			{
				$guestSingleNight = $singleNight;
				$guestSubTot = $subTot;
				$guestSecDep = $secDeposit;
                $guestServ_fee_is = $servicefee;
			
				
			}
			if($guest_currency_type!=$Contact_details->row()->user_currencycode)
			{
				$guestServiceFee = currency_conversion($Contact_details->row()->user_currencycode,$guest_currency_type, $servicefee);
			}
			else
			{
				$guestServiceFee = $servicefee;
			}

            if($guest_currency_type!=$Contact_details->row()->user_currencycode)
            {
                if($Rental_details->row()->currency != $guest_currency_type){
                $base_total_val = currency_conversion($Rental_details->row()->currency,$guest_currency_type, $base_total_val);
            }else{
               $base_total_val = $base_total_val;
            }
            }
            else
            {
                $base_total_val = $Contact_details->row()->totalAmt;
            }
            $dis_amnt = $wallet_Amount+$coupondiscount;
            $base_total_val_is = $base_total_val - $dis_amnt;
			
			
			
			
			$guestNetTot = $guestSubTot+$guestServiceFee+$guestSecDep;
			
			
			$admin = $this->user_model->get_all_details(ADMIN, array('admin_type' => 'super'));
			$data = $admin->row();
			$admin_currencyCode = trim($data->admin_currencyCode);
			$adminCurrencySymbol = $this->db->select('currency_symbols')->from('fc_currency')->where('currency_type = ', $admin_currencyCode)->get()->row()->currency_symbols;
			//echo $admin_currencyCode.'|'.$productCurrency;
			if($admin_currencyCode!=$productCurrency)
			{
				$adminSingleNight = currency_conversion($productCurrency,$admin_currencyCode, $singleNight);
				$adminSubTot = currency_conversion($productCurrency,$admin_currencyCode, $subTot);
				$adminSecDep = currency_conversion($productCurrency,$admin_currencyCode,$secDeposit);
				
			}
			else
			{
				$adminSingleNight = $singleNight;
				$adminSubTot = $subTot;
				$adminSecDep = $secDeposit;
				
			}
			if($admin_currencyCode!=$Contact_details->row()->user_currencycode)
			{
				$adminServiceFee = currency_conversion($Contact_details->row()->user_currencycode, $admin_currencyCode, $servicefee);
			}
			else
			{
				$adminServiceFee = $servicefee;
			}
			$adminNetTot = $adminSubTot+$adminServiceFee+$adminSecDep;
			
			/*HOST*/
			$hostCurrencyType = $currency;
			$hostCurrencySymbol = $this->db->select('currency_symbols')->from('fc_currency')->where('currency_type = ', $currency)->get()->row()->currency_symbols;
			$hostSingleNight = $singleNight;
			$hostSubTot = $subTot;
			$hostSecDep = $secDeposit;
			if($hostCurrencyType!=$Contact_details->row()->user_currencycode)
			{
				$hostServiceFee = ceil(currency_conversion($Contact_details->row()->user_currencycode, $hostCurrencyType, $servicefee));
			}
			else
			{
				$hostServiceFee = $servicefee;
			}
			$hostNetTot = $hostSubTot+$hostServiceFee+$hostSecDep;

            if($PaymentSuccess->row()->is_coupon_used == 'Yes'){
                $coupon_used_amt =  '<tr>
                <td style="border-bottom: 1px solid #bbb;">Coupon amount: </td>
                <td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
                <td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><p>'.$currency_symbol.$coupondiscount.$currency_type.'</p></td>
                </tr>';
               
            }else{
                $coupon_used_amt = '';
            }

            if($PaymentSuccess->row()->is_wallet_used == 'Yes'){
                $wallet_used_amt =  '<tr>
                <td style="border-bottom: 1px solid #bbb;">Wallet amount: </td>
                <td style="border-bottom: 1px solid #bbb;">&nbsp;</td>
                <td style="border-bottom: 1px solid #bbb; padding: 10px 0px;"><p>'.$currency_symbol.$wallet_Amount.$currency_type.'</p></td>
                </tr>';
               
            }else{
                $wallet_used_amt = '';
            }
			
            /***************************************currency****************************/
            $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo'], 'first_name' => $user_details->row()->firstname, 'last_name' => $user_details->row()->lastname, 'NoofGuest' => $Contact_details->row()->NoofGuest, 'numofdates' => $Contact_details->row()->numofdates, 'booking_status' => $Contact_details->row()->booking_status, 'user_email' => $user_details->row()->email, 'ph_no' => $Renter_details->row()->phone_no, 'Enquiry' => $Contact_details->row()->Enquiry, 'checkin' => $chkIn, 'checkout' => $chkOut, 'currency_price' => $currency_price, 'currency' => $Rental_details->row()->currency, 'securityDeposite' => $securityDeposite, 'amount' => $total, 'netamount' => $base_total_val_is, 'days' => $Contact_details->row()->numofdates, 'currency_serviceFee' => $currency_serviceFee, 'renter_id' => $PaymentSuccess->row()->sell_id, 'prd_id' => $PaymentSuccess->row()->product_id, 'renter_fname' => $Renter_details->row()->firstname, 'renter_lname' => $Renter_details->row()->lastname, 'owner_email' => $Renter_details->row()->email, 'owner_phone' => $Renter_details->row()->phone_no, 'rental_name' => $Rental_details->row()->product_title, 'meta_title' => $this->config->item('email_title'), 'rental_image' => $proImages, 'renter_image' => $renter_image, 'user_image' => $user_image,'guestSingleNight'=>$guestSingleNight,'guestSubTot'=>$guestSubTot,'guestServiceFee'=>$guestServiceFee,'guestSecDep'=>$guestSecDep,'guestNetTot'=>$guestNetTot,'guest_currency_type'=>$guest_currency_type,'guestCurrencySymbol'=>$guestCurrencySymbol,'adminSingleNight'=>$adminSingleNight,'adminSubTot'=>$adminSubTot,'adminServiceFee'=>$adminServiceFee,'adminSecDep'=>$adminSecDep,'adminNetTot'=>$adminNetTot,'admin_currencyCode'=>$admin_currencyCode,'adminCurrencySymbol'=>$adminCurrencySymbol,'hostSingleNight'=>$hostSingleNight,'hostSubTot'=>$hostSubTot,'hostSecDep'=>$hostSecDep,'hostServiceFee'=>$hostServiceFee,'hostNetTot'=>$hostNetTot,'hostCurrencyType'=>$hostCurrencyType,'hostCurrencySymbol'=>$hostCurrencySymbol,'coupon_used'=>$PaymentSuccess->row()->is_coupon_used,'couponDiscount'=>$coupondiscount,'wallet_used'=>$PaymentSuccess->row()->is_wallet_used,'wallet_Amount'=>$wallet_Amount,'coupon_used_amt'=>$coupon_used_amt,'wallet_used_amt'=>$wallet_used_amt,'booking_no'=>$Contact_details->row()->Bookingno, 'cancel_policy' => $Rental_details->row()->cancel_description, 'cancel_policy_type' => $Rental_details->row()->cancellation_policy,'guestServ_fee_is'=>$guestServiceFee);
			
            extract($adminnewstemplateArr);

            /*==========confirm SMS to user=============*/ 
                // if ($this->config->item('twilio_status') == '1') {

                //         require_once('twilio/Services/Twilio.php');
                //         $account_sid = $this->config->item('twilio_account_sid');
                //         $auth_token = $this->config->item('twilio_account_token');
                //         $from = $this->config->item('twilio_phone_number');
                //         try {
                //             $to = $user_details->row()->phone_no;
                            
                //             $client = new Services_Twilio($account_sid, $auth_token);
                //             $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Property is booked (".$Rental_details->row()->product_title.") successfully"));
                //             //echo 'success';
                //         } catch (Services_Twilio_RestException $e) {
                //             //echo "Authentication Failed..!";
                //         }
                // }
            /*===========confirm SMS to user=============*/ 
            /*==========confirm SMS to Host=============*/ 
                // if ($this->config->item('twilio_status') == '1') {

                //         require_once('twilio/Services/Twilio.php');
                //         $account_sid = $this->config->item('twilio_account_sid');
                //         $auth_token = $this->config->item('twilio_account_token');
                //         $from = $this->config->item('twilio_phone_number');
                //         try {
                //             $to = $Renter_details->row()->phone_no;
                            
                //             $client = new Services_Twilio($account_sid, $auth_token);
                //             $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Property is booked (".$Rental_details->row()->product_title.") successfully by User"));
                //             //echo 'success';
                //         } catch (Services_Twilio_RestException $e) {
                //             //echo "Authentication Failed..!";
                //         }
                // }
            /*===========confirm SMS to Host=============*/ 
            if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                $sender_email = $this->data['siteContactMail'];
                $sender_name = $this->data['siteTitle'];
            } else {
                $sender_name = $template_values['sender_name'];
                $sender_email = $template_values['sender_email'];
            }
            $this->session->set_userdata('ContacterEmail', $user_details->row()->email);
            /* Mail function starts  */
            $reg = $adminnewstemplateArr;
            $this->load->library('email');
            for ($i = 1; $i <= 3; $i++) {
                if ($i == 1) {
                    $message = $this->load->view('newsletter/Usermailbooking' . $newsid . '.php', $reg, TRUE); // users
                    $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $user_details->row()->email, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
                    $this->email->from($email_values['from_mail_id'], $sender_name);
                    $this->email->to($email_values['to_mail_id']);
                    $this->email->subject($email_values['subject_message']);
                    $this->email->set_mailtype("html");
                    $this->email->message($message);
                    try {
                        $this->email->send();
                        $returnStr ['msg'] = 'Success';
                        $returnStr ['success'] = '1';
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } elseif ($i == 2) {
                    $newsid = '22';
                    $message1 = $this->load->view('newsletter/Adminmailbooking' . $newsid . '.php', $reg, TRUE); //admin
                    $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $sender_email, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message1);
                    $this->email->from($email_values['from_mail_id'], $sender_name);
                    $this->email->to($email_values['to_mail_id']);
                    $this->email->subject($email_values['subject_message']);
                    $this->email->set_mailtype("html");
                    $this->email->message($message1);
                    try {
                        $this->email->send();
                        $returnStr ['msg'] = 'Success';
                        $returnStr ['success'] = '1';
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                } elseif ($i == 3) {
                    $newsid = '34';
                    $message2 = $this->load->view('newsletter/Host Mail Booking' . $newsid . '.php', $reg, TRUE); //Host
                    $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $Renter_details->row()->email, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message2);
                    $this->email->from($email_values['from_mail_id'], $sender_name);
                    $this->email->to($email_values['to_mail_id']);
                    $this->email->subject($email_values['subject_message']);
                    $this->email->set_mailtype("html");
                    $this->email->message($message2);
                    try {
                        $this->email->send();
                        $returnStr ['msg'] = 'Success';
                        $returnStr ['success'] = '1';
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }
        }

        public function booking_conform_mail_admin($paymentid)
        {
            $PaymentSuccess = $this->order_model->get_all_details(PAYMENT, array('dealCodeNumber' => $paymentid));
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_details = $this->order_model->get_all_details(USERS, $condition);
            $condition3 = array('id' => $PaymentSuccess->row()->user_id);
            $user_details = $this->order_model->get_all_details(USERS, $condition3);
            $condition1 = array('id' => $PaymentSuccess->row()->product_id);
            $Rental_details = $this->order_model->get_all_details(PRODUCT, $condition1);
            $Contact_details = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            /* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
            //---------------email to user---------------------------
            /*$newsid='33';
            $template_values=$this->order_model->get_newsletter_template_details($newsid);


            $subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
            $proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
            $chkIn = date('d-m-y',strtotime($Contact_details->row()->checkin));
            $chkOut = date('d-m-y',strtotime($Contact_details->row()->checkout));
            $adminnewstemplateArr=array(
                    'email_title'=>$this->config->item('email_title'),
                    'logo'=>$this->data['logo'],
                    'first_name'=>$user_details->row()->firstname,
                    'last_name'=>$user_details->row()->lastname,
                    'NoofGuest'=>$Contact_details->row()->NoofGuest,
                    'numofdates'=>$Contact_details->row()->numofdates,
                    'booking_status'=>$Contact_details->row()->booking_status,
                    'user_email'=>$user_details->row()->email,
                    'ph_no'=>$user_details->row()->phone_no,
                    'Enquiry'=>$Contact_details->row()->Enquiry,
                    'checkin'=>$chkIn,
                    'checkout'=>$chkOut,
                    'price'=>$Renter_details->row()->price,
                    'amount'=>$total,
                    'netamount'=>$Contact_details->row()->totalAmt,
                    'noofnights'=>$Contact_details->row()->numofdates,
                    'serviceFee'=>$Contact_details->row()->serviceFee,
                    'renter_id'=>$PaymentSuccess->row()->sell_id,
                    'prd_id'=>$PaymentSuccess->row()->product_id,
                    'renter_fname'=>$Renter_details->row()->firstname,
                    'renter_lname'=>$Renter_details->row()->lastname,
                    'owner_email'=>$Renter_details->row()->email,
                    'owner_phone'=>$Renter_details->row()->phone_no,
                    'rental_name'=>$Rental_details->row()->product_title,
                    'rental_image'=>$proImages);


            extract($adminnewstemplateArr);

            $header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";

            $message .= '<body>';


            include('./newsletter/registeration'.$newsid.'.php');

            $message .= '</body>
                </html>';

            if($template_values['sender_name']=='' && $template_values['sender_email']==''){
                $sender_email=$this->data['siteContactMail'];
                $sender_name=$this->data['siteTitle'];
            }else{
                $sender_name=$template_values['sender_name'];
                $sender_email=$template_values['sender_email'];
            }

            /* $sender_name=ucfirst($Renter_details->row()->first_name).' '.ucfirst($Renter_details->row()->last_name);
            $sender_email=$Renter_details->row()->email;

            //add inbox from mail
            $this->order_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$PaymentSuccess->row()->user_id,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
            $this->session->set_userdata('ContacterEmail',$user_details->row()->email);

            $email_values = array('mail_type'=>'html',
                                'from_mail_id'=>$sender_email,
                                'mail_name'=>$sender_name,
                                'to_mail_id'=>$sender_email,
                                'subject_message'=>$template_values['news_subject'],
                                'body_messages'=>$message
                                );
            //echo '<pre>'; print_r($email_values);
            $email_send_to_common = $this->order_model->common_email_send($email_values);*/
            //$this->mail_owner_admin_booking($adminnewstemplateArr);
        }

        public function booking_conform_mail_host($paymentid)
        {
            $PaymentSuccess = $this->order_model->get_all_details(PAYMENT, array('dealCodeNumber' => $paymentid));
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_details = $this->order_model->get_all_details(USERS, $condition);
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_email = $this->order_model->get_all_details(USERS, $condition);
            $condition3 = array('id' => $PaymentSuccess->row()->user_id);
            $user_details = $this->order_model->get_all_details(USERS, $condition3);
            $condition1 = array('id' => $PaymentSuccess->row()->product_id);
            $Rental_details = $this->order_model->get_all_details(PRODUCT, $condition1);
            $Contact_details = $this->order_model->get_all_details(RENTALENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->order_model->get_all_details(PRODUCT_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            /* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
            //---------------email to user---------------------------
            /*$newsid='34';
            $template_values=$this->order_model->get_newsletter_template_details($newsid);


            $subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
            $proImages=base_url().PRODUCTPATH.$RentalPhoto->row()->product_image;
            $chkIn = date('d-m-y',strtotime($Contact_details->row()->checkin));
            $chkOut = date('d-m-y',strtotime($Contact_details->row()->checkout));
            $adminnewstemplateArr=array(
                    'email_title'=>$this->config->item('email_title'),
                    'logo'=>$this->data['logo'],
                    'first_name'=>$user_details->row()->firstname,
                    'last_name'=>$user_details->row()->lastname,
                    'NoofGuest'=>$Contact_details->row()->NoofGuest,
                    'numofdates'=>$Contact_details->row()->numofdates,
                    'booking_status'=>$Contact_details->row()->booking_status,
                    'user_email'=>$user_details->row()->email,
                    'ph_no'=>$user_details->row()->phone_no,
                    'Enquiry'=>$Contact_details->row()->Enquiry,
                    'checkin'=>$chkIn,
                    'checkout'=>$chkOut,
                    'price'=>$Renter_details->row()->price,
                    'amount'=>$total,
                    'netamount'=>$Contact_details->row()->totalAmt,
                    'noofnights'=>$Contact_details->row()->numofdates,
                    'serviceFee'=>$Contact_details->row()->serviceFee,
                    'renter_id'=>$PaymentSuccess->row()->sell_id,
                    'prd_id'=>$PaymentSuccess->row()->product_id,
                    'renter_fname'=>$Renter_details->row()->firstname,
                    'renter_lname'=>$Renter_details->row()->lastname,
                    'owner_email'=>$Renter_details->row()->email,
                    'owner_phone'=>$Renter_details->row()->phone_no,
                    'rental_name'=>$Rental_details->row()->product_title,
                    'rental_image'=>$proImages);


            extract($adminnewstemplateArr);

            $header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";

            $message .= '<!DOCTYPE HTML>
                <html>
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width"/><body>';


            include('./newsletter/registeration'.$newsid.'.php');

            $message .= '</body>
                </html>';

            if($template_values['sender_name']=='' && $template_values['sender_email']==''){
                $sender_email=$this->data['siteContactMail'];
                $sender_name=$this->data['siteTitle'];
            }else{
                $sender_name=$template_values['sender_name'];
                $sender_email=$template_values['sender_email'];
            }

            /* $sender_name=ucfirst($Renter_details->row()->first_name).' '.ucfirst($Renter_details->row()->last_name);
            $sender_email=$Renter_details->row()->email;

            //add inbox from mail
            $this->order_model->simple_insert(INBOX,array('sender_id'=>$sender_email,'user_id'=>$PaymentSuccess->row()->user_id,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
            $this->session->set_userdata('ContacterEmail',$user_details->row()->email);

            $email_values = array('mail_type'=>'html',
                                'from_mail_id'=>$sender_email,
                                'mail_name'=>$sender_name,
                                'to_mail_id'=>$Renter_email->row()->email,
                                'subject_message'=>$template_values['news_subject'],
                                'body_messages'=>$message
                                );
            //echo '<pre>'; print_r($email_values);
            $email_send_to_common = $this->order_model->common_email_send($email_values);*/
            //$this->mail_owner_admin_booking($adminnewstemplateArr);
        }

        public function mail_owner_admin_booking($got_values)
        {//print_r($got_values);die;
            //email to admin
            $header = '';
            $adminnewstemplateArr = array();
            $subject = '';
            $cfmurl = '';
            $sender_email = '';
            $sender_name = '';
            /*$newsid='9';
            $template_values=$this->order_model->get_newsletter_template_details($newsid);

            $adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),
                                        'logo'=> $this->data['logo']
                                        );

            extract($adminnewstemplateArr);
            extract($got_values);

            $subject = 'From: '.$this->config->item('email_title').' - '.$template_values['news_subject'];
            $header .="Content-Type: text/plain; charset=ISO-8859-1\r\n";

            $message .= '<!DOCTYPE HTML>
                <html>
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <meta name="viewport" content="width=device-width"/><body>';
            include('./newsletter/registeration'.$newsid.'.php');

            $message .= '</body>
                </html>';

            if($template_values['sender_name']=='' && $template_values['sender_email']=='')
                {
                    $sender_email=$this->data['siteContactMail'];
                    $sender_name=$this->data['siteTitle'];
                }
            else
                {
                    $sender_name=$template_values['sender_name'];
                    $sender_email=$template_values['sender_email'];
                }

            //add inbox from mail
            $this->order_model->simple_insert(INBOX,array('sender_id'=>$this->session->userdata('ContacterEmail'),'user_id'=>$sender_email,'mailsubject'=>$template_values['news_subject'],'description'=>stripslashes($message)));
            $email_values2 = array('mail_type'=>'html',
                                'from_mail_id'=>$sender_email,
                                'mail_name'=>$sender_email,
                                'to_mail_id'=>$sender_email,
                                'subject_message'=>$template_values['news_subject'],
                                'body_messages'=>$message
                                );
            $email_send_to_common1 = $this->order_model->common_email_send($email_values2);*/
            //Email to owner
            if ($got_values['renter_id'] > 0) {
                $UserDetails = $this->user_model->get_all_details(USERS, array('id' => $got_values['renter_id']));
                $emailid = $UserDetails->row()->email;
                $this->order_model->simple_insert(INBOX, array('sender_id' => $this->session->userdata('ContacterEmail'), 'user_id' => $emailid, 'mailsubject' => $template_values['news_subject'], 'description' => stripslashes($message)));
                $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $emailid, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
                //echo"admin<pre>"; print_r($email_values2);echo "<br>";
                //echo"owner"; print_r($email_values); die;
                $this->session->unset_userdata('ContacterEmail');
                $email_send_to_common = $this->order_model->common_email_send($email_values);
            }
            //echo '<pre>';print_r($email_values);die;
        }

        public function ipnpayment()
        {
            mysql_query('CREATE TABLE IF NOT EXISTS ' . TRANSACTIONS . ' ( `id` int(255) NOT NULL AUTO_INCREMENT,`payment_cycle` varchar(500) NOT NULL,`txn_type` varchar(500) NOT NULL, `last_name` varchar(500) NOT NULL,`next_payment_date` varchar(500) NOT NULL, `residence_country` varchar(500) NOT NULL, `initial_payment_amount` varchar(500) NOT NULL, `currency_code` varchar(500) NOT NULL, `time_created` varchar(500) NOT NULL, `verify_sign` varchar(750) NOT NULL, `period_type` varchar(500) NOT NULL, `payer_status` varchar(500) NOT NULL, `test_ipn` varchar(500) NOT NULL, `tax` varchar(500) NOT NULL, `payer_email` varchar(500) NOT NULL, `first_name` varchar(500) NOT NULL, `receiver_email` varchar(500) NOT NULL, `payer_id` varchar(500) NOT NULL, `product_type` varchar(500) NOT NULL, `shipping` varchar(500) NOT NULL, `amount_per_cycle` varchar(500) NOT NULL, `profile_status` varchar(500) NOT NULL, `charset` varchar(500) NOT NULL, `notify_version` varchar(500) NOT NULL, `amount` varchar(500) NOT NULL, `outstanding_balance` varchar(500) NOT NULL, `recurring_payment_id` varchar(500) NOT NULL, `product_name` varchar(500) NOT NULL,`custom_values` varchar(500) NOT NULL, `ipn_track_id` varchar(500) NOT NULL, `tran_date` datetime NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;');
            mysql_query("insert into " . TRANSACTIONS . " set  payment_cycle='" . $_REQUEST['payment_cycle'] . "', txn_type='" . $_REQUEST['txn_type'] . "', last_name='" . $_REQUEST['last_name'] . "',
next_payment_date='" . $_REQUEST['next_payment_date'] . "', residence_country='" . $_REQUEST['residence_country'] . "', initial_payment_amount='" . $_REQUEST['initial_payment_amount'] . "',
currency_code='" . $_REQUEST['currency_code'] . "', time_created='" . $_REQUEST['time_created'] . "', verify_sign='" . $_REQUEST['verify_sign'] . "', period_type= '" . $_REQUEST['period_type'] . "', payer_status='" . $_REQUEST['payer_status'] . "', test_ipn='" . $_REQUEST['test_ipn'] . "', tax='" . $_REQUEST['tax'] . "', payer_email='" . $_REQUEST['payer_email'] . "', first_name='" . $_REQUEST['first_name'] . "', receiver_email='" . $_REQUEST['receiver_email'] . "', payer_id='" . $_REQUEST['payer_id'] . "', product_type='" . $_REQUEST['product_type'] . "', shipping='" . $_REQUEST['shipping'] . "', amount_per_cycle='" . $_REQUEST['amount_per_cycle'] . "', profile_status='" . $_REQUEST['profile_status'] . "', charset='" . $_REQUEST['charset'] . "',
notify_version='" . $_REQUEST['notify_version'] . "', amount='" . $_REQUEST['amount'] . "', outstanding_balance='" . $_REQUEST['payment_status'] . "', recurring_payment_id='" . $_REQUEST['txn_id'] . "', product_name='" . $_REQUEST['product_name'] . "', custom_values ='" . $_REQUEST['custom'] . "', ipn_track_id='" . $_REQUEST['ipn_track_id'] . "', tran_date=NOW()");
            $this->data['heading'] = 'Order Confirmation';
            if ($_REQUEST['payment_status'] == 'Completed') {
                $newcustom = explode('|', $_REQUEST['custom']);
                if ($newcustom[0] == 'Product') {
                    $userdata = array('fc_session_user_id' => $newcustom[1], 'randomNo' => $newcustom[2]);
                    $this->session->set_userdata($userdata);
                    $transId = $_REQUEST['txn_id'];
                    $Pray_Email = $_REQUEST['payer_email'];
                    $this->data['Confirmation'] = $this->order_model->PaymentSuccess($newcustom[1], $newcustom[2], $transId, $Pray_Email);
                    //$userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
                    $this->session->unset_userdata($userdata);
                } elseif ($newcustom[0] == 'Gift') {
                    $userdata = array('fc_session_user_id' => $newcustom[1]);
                    $this->session->set_userdata($userdata);
                    $transId = $_REQUEST['txn_id'];
                    $Pray_Email = $_REQUEST['payer_email'];
                    $this->data['Confirmation'] = $this->order_model->PaymentGiftSuccess($newcustom[1], $transId, $Pray_Email);
                    //$userdata = array('fc_session_user_id' => $newcustom[1]);
                    $this->session->unset_userdata($userdata);
                }
            }
        }

        public function insert_product_comment()
        {
            $uid = $this->checkLogin('U');
            $returnStr['status_code'] = 0;
            $comments = $this->input->post('comments');
            $product_id = $this->input->post('cproduct_id');
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $conditionArr = array('comments' => $comments, 'user_id' => $uid, 'product_id' => $product_id, 'status' => 'InActive', 'dateAdded' => mdate($datestring, $time));
            $this->order_model->simple_insert(PRODUCT_COMMENTS, $conditionArr);
            $cmtID = $this->order_model->get_last_insert_id();
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $createdTime = mdate($datestring, $time);
            $actArr = array('activity' => 'own-product-comment', 'activity_id' => $product_id, 'user_id' => $this->checkLogin('U'), 'activity_ip' => $this->input->ip_address(), 'created' => $createdTime, 'comment_id' => $cmtID);
            $this->order_model->simple_insert(NOTIFICATIONS, $actArr);
            $this->send_comment_noty_mail($cmtID, $product_id);
            $returnStr['status_code'] = 1;
            echo json_encode($returnStr);
        }

        public function send_comment_noty_mail($cmtID = '0', $pid = '0')
        {
            if ($this->checkLogin('U') != '') {
                if ($cmtID != '0' && $pid != '0') {
                    $productUserDetails = $this->product_model->get_product_full_details($pid);
                    if ($productUserDetails->num_rows() == 1) {
                        $emailNoty = explode(',', $productUserDetails->row()->email_notifications);
                        if (in_array('comments', $emailNoty)) {
                            $commentDetails = $this->product_model->view_product_comments_details('where c.id=' . $cmtID);
                            if ($commentDetails->num_rows() == 1) {
                                if ($productUserDetails->prodmode == 'seller') {
                                    $prodLink = base_url() . 'things/' . $productUserDetails->row()->id . '/' . url_title($productUserDetails->row()->product_name, '-');
                                } else {
                                    $prodLink = base_url() . 'user/' . $productUserDetails->row()->user_name . '/things/' . $productUserDetails->row()->seller_product_id . '/' . url_title($productUserDetails->row()->product_name, '-');
                                }
                                /*$newsid='1';
                                $template_values=$this->order_model->get_newsletter_template_details($newsid);
                                $adminnewstemplateArr=array('email_title'=> $this->config->item('email_title'),'logo'=> $this->data['logo'],'full_name'=>$commentDetails->row()->full_name,'product_name'=>$productUserDetails->row()->product_name,'user_name'=>$commentDetails->row()->user_name);
                                extract($adminnewstemplateArr);
                                $subject = $this->config->item('email_title').' - '.$template_values['news_subject'];

                                $message .= '<!DOCTYPE HTML>
                                    <html>
                                    <head>
                                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                    <meta name="viewport" content="width=device-width"/>
                                    <title>'.$template_values['news_subject'].'</title>
                                    <body>';
                                include('./newsletter/registeration'.$newsid.'.php');

                                $message .= '</body>
                                    </html>';

                                if($template_values['sender_name']=='' && $template_values['sender_email']==''){
                                    $sender_email=$this->data['siteContactMail'];
                                    $sender_name=$this->data['siteTitle'];
                                }else{
                                    $sender_name=$template_values['sender_name'];
                                    $sender_email=$template_values['sender_email'];
                                }

                                //add inbox from mail
                                $this->order_model->simple_insert(INBOX,array('user_id'=>$productUserDetails->row()->email,'sender_id'=>$sender_email,'mailsubject'=>$subject,'description'=>stripslashes($message)));

                                $email_values = array('mail_type'=>'html',
                                                    'from_mail_id'=>$sender_email,
                                                    'mail_name'=>$sender_name,
                                                    'to_mail_id'=>$productUserDetails->row()->email,
                                                    'subject_message'=>$subject,
                                                    'body_messages'=>$message
                                                    );
                                $email_send_to_common = $this->product_model->common_email_send($email_values);*/
                            }
                        }
                    }
                }
            }
        }

        public function getDatesFromRange($start, $end)
        {
            $dates = array($start);
            while (end($dates) < $end) {
                $dates[] = date('Y-m-d', strtotime(end($dates) . ' +1 day'));
            }
            return $dates;
        }

    }  /* Main controller end */

