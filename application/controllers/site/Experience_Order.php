<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Experience order management full control.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class Experience_Order extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper(array('cookie', 'date', 'form', 'email'));
            $this->load->library(array('encrypt', 'form_validation'));
            $this->load->model('experience_order_model');
            $this->load->model('experience_model');
            $this->load->model('user_model');
            $this->load->model('product_model');
            $this->load->model('contact_model');
            $this->data['loginCheck'] = $this->checkLogin('U');
        }

        /**
         *
         * Loading Order Page
         */
        public function index()
        {
		
			
            $this->data['heading'] = 'Order Confirmation';
            $paidAmount = $couponUsedAmount = $walletUsedAmount = '0.00';
            if ($this->uri->segment(2) == 'success') {
                if ($this->uri->segment(5) == '') {
                    $transId = $_REQUEST['txn_id'];
                    $Pray_Email = $_REQUEST['payer_email'];
                    $update_pay_type = $this->uri->segment(5);
                } else {
                    $update_pay_type = $this->uri->segment(5);
                    $transId = $this->uri->segment(5);
                    $Pray_Email = '';
                }
				//paid_amount
                $UserNo = $this->uri->segment(3);
                $DealCodeNo = $this->uri->segment(4);
                $EnquiryUpdate = $this->experience_order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('dealCodeNumber' => $DealCodeNo));
                $eprd_id = $EnquiryUpdate->row()->product_id;
                $eInq_id = $EnquiryUpdate->row()->EnquiryId;
                $totalAmt = $EnquiryUpdate->row()->total;
                $booking_cur = $EnquiryUpdate->row()->currency_code;
				
                $this->data['paid_amount'] = $totalAmt;
                $this->data['currency_check'] = $booking_cur;
                $this->data['invoicedata'] = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $eInq_id));
				//echo $this->data['invoicedata']->row()->user_currencycode.'|'.$this->session->userdata('currency_type').'|'.$totalAmt; exit;
				//print_r($this->data['invoicedata']->row()->user_currencycode); exit;
                $condition1 = array('user_id' => $UserNo, 'prd_id' => $eprd_id, 'id' => $eInq_id);
                $dataArr1 = array('booking_status' => 'Booked');
                $this->experience_order_model->update_details(EXPERIENCE_ENQUIRY, $dataArr1, $condition1);
                $this->data['Confirmation'] = $this->experience_order_model->PaymentSuccess($this->uri->segment(3), $this->uri->segment(4), $transId, $update_pay_type);
                $SelBookingQty = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $eInq_id));
                $productId = $SelBookingQty->row()->prd_id;
                $arrival = $SelBookingQty->row()->checkin;
                $depature = $SelBookingQty->row()->checkout;
                $dates = $this->getDatesFromRange($arrival, $depature);
                $condition = array('status' => 'Active', 'seo_tag' => 'experience_listing');
                $service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition);
                $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
                $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
                $condition = array('status' => 'Active', 'seo_tag' => 'experience_booking');
                $service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
                $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
                $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
                $orderDetails = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $eInq_id));
                $userDetails = $this->experience_order_model->get_all_details(USERS, array('id' => $orderDetails->row()->renter_id));
                $guest_fee = $orderDetails->row()->serviceFee;
                $netAmount = $orderDetails->row()->totalAmt - $orderDetails->row()->serviceFee;
                if ($this->data['host_tax_type'] == 'flat') {
                    $host_fee = 0;
                } else {
                    $host_fee = 0;
                }
                $payable_amount = $netAmount - $host_fee;
                $data1 = array('host_email' => $userDetails->row()->email, 'booking_no' => $orderDetails->row()->Bookingno, 'total_amount' => $orderDetails->row()->totalAmt, 'guest_fee' => $guest_fee, 'host_fee' => $host_fee, 'payable_amount' => $payable_amount, 'exp_cancel_percentage' => $orderDetails->row()->exp_cancel_percentage, 'subtotal' => $orderDetails->row()->subTotal, 'booking_walletUse' => $walletUsedAmount //malar - wallet amount used on payment
                );
                $chkQry = $this->experience_order_model->get_all_details(EXP_COMMISSION_TRACKING, array('booking_no' => $orderDetails->row()->Bookingno));
                if ($chkQry->num_rows() == 0) {
                    $this->product_model->simple_insert(EXP_COMMISSION_TRACKING, $data1);
                } else {
                    $this->product_model->update_details(EXP_COMMISSION_TRACKING, $data1, array('booking_no' => $orderDetails->row()->Bookingno));
                }
                $this->booking_conform_mail($DealCodeNo);
                $this->data['Confirmation'] = 'Success';
                $this->data['productId'] = $productId;
                $this->load->view('site/experience/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'failure') {
                $this->data['invoicedata'] = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $eInq_id));
                $this->data['Confirmation'] = 'Failure';
                $this->data['errors'] = $this->session->userdata('payment_error');
                $this->session->unset_userdata('payment_error');
                $this->load->view('site/experience/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'notify') {
                $this->data['Confirmation'] = 'Failure';
                $this->load->view('site/experience/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'confirmation') {
                $this->data['Confirmation'] = 'Success';
                $this->load->view('site/experience/order.php', $this->data);
            } elseif ($this->uri->segment(2) == 'pakagesuccess') {
                $this->memberPackageUpdate($this->uri->segment(3));
            }
        }

        public function memberPackageUpdate($user_ID)
        {
            $condition = array('user_id' => $user_ID);
            $dataArr = array('package_status' => "Paid");
            $this->product_model->commonInsertUpdate(USERS, 'update', array('user_id'), array('package_status' => "Paid"), array('id' => $user_ID));
            $this->product_model->commonInsertUpdate(EXPERIENCE, 'update', $excludeArr, $dataArr, $condition);
            $this->memberPackagePurchaseEmail($user_ID);
            redirect(base_url('plan'));
        }

        public function booking_conform_mail($paymentid)
        {
            $PaymentSuccess = $this->experience_order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('dealCodeNumber' => $paymentid));
            $Renter_details = $this->experience_order_model->get_all_details(USERS, array('id' => $PaymentSuccess->row()->sell_id));
            $user_details = $this->experience_order_model->get_all_details(USERS, array('id' => $PaymentSuccess->row()->user_id));
            $Rental_details = $this->experience_order_model->get_all_details(EXPERIENCE, array('experience_id' => $PaymentSuccess->row()->product_id));
            $Contact_details = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->experience_order_model->get_all_details(EXPERIENCE_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
            $where1 = array('p.status' => '1', 'p.experience_id' => $PaymentSuccess->row()->product_id);
            $where_or = array('p.status' => '1');
            $where2 = array('p.status' => '1', 'p.experience_id' => $PaymentSuccess->row()->product_id);
            $productDetails = $this->experience_model->view_experience_details_site_one($where1, $where_or, $where2);
            $schduleDetail = $this->experience_model->getDateSchedule($productDetails->date_id);
			$cancel_policy = $Rental_details->row()->cancel_policy;
            //---------------email to user---------------------------
            $newsid = '50';
            $template_values = $this->experience_order_model->get_newsletter_template_details($newsid);
            $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values['news_subject'];
            $proImages = base_url() . 'images/experience/' . $RentalPhoto->row()->product_image;
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
			if($productCurrency!=$guest_currency_type)
			{
				$guestSingleNight = currency_conversion($productCurrency,$guest_currency_type, $singleNight);
				$guestSubTot = currency_conversion($productCurrency,$guest_currency_type, $subTot);
				$guestSecDep = currency_conversion($productCurrency,$guest_currency_type,$secDeposit);
			}
			else
			{
				$guestSingleNight = $singleNight;
				$guestSubTot = $subTot;
				$guestSecDep = $secDeposit;
			}
			if($guest_currency_type!=$Contact_details->row()->user_currencycode)
			{
				$guestServiceFee = currency_conversion($Contact_details->row()->user_currencycode,$guest_currency_type, $servicefee);
			}
			else
			{
				$guestServiceFee = $servicefee;
			}
			$guestNetTot = $guestSubTot+$guestServiceFee+$guestSecDep;
			/*ADMIN */ 
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
			
			$adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo'], 'first_name' => $user_details->row()->firstname, 'last_name' => $user_details->row()->lastname, 'NoofGuest' => $Contact_details->row()->NoofGuest, 'numofdates' => $Contact_details->row()->numofdates, 'booking_status' => $Contact_details->row()->booking_status, 'user_email' => $user_details->row()->email, 'ph_no' => $Renter_details->row()->phone_no, 'Enquiry' => $Contact_details->row()->Enquiry, 'checkin' => $chkIn, 'checkout' => $chkOut, 'currency_price' => $currency_price, 'currency' => $Rental_details->row()->currency, 'securityDeposite' => $securityDeposite, 'amount' => $total, 'netamount' => $Contact_details->row()->totalAmt, 'days' => $Contact_details->row()->numofdates, 'currency_serviceFee' => $currency_serviceFee, 'renter_id' => $PaymentSuccess->row()->sell_id, 'prd_id' => $PaymentSuccess->row()->product_id, 'renter_fname' => $Renter_details->row()->firstname, 'renter_lname' => $Renter_details->row()->lastname, 'owner_email' => $Renter_details->row()->email, 'owner_phone' => $Renter_details->row()->phone_no, 'rental_name' => $Rental_details->row()->experience_title, 'meta_title' => $this->config->item('email_title'), 'rental_image' => $proImages, 'renter_image' => $renter_image, 'user_image' => $user_image,'guestSingleNight'=>$guestSingleNight,'guestSubTot'=>$guestSubTot,'guestServiceFee'=>$guestServiceFee,'guestSecDep'=>$guestSecDep,'guestNetTot'=>$guestNetTot,'guest_currency_type'=>$guest_currency_type,'guestCurrencySymbol'=>$guestCurrencySymbol,'adminSingleNight'=>$adminSingleNight,'adminSubTot'=>$adminSubTot,'adminServiceFee'=>$adminServiceFee,'adminSecDep'=>$adminSecDep,'adminNetTot'=>$adminNetTot,'admin_currencyCode'=>$admin_currencyCode,'adminCurrencySymbol'=>$adminCurrencySymbol,'hostSingleNight'=>$hostSingleNight,'hostSubTot'=>$hostSubTot,'hostSecDep'=>$hostSecDep,'hostServiceFee'=>$hostServiceFee,'hostNetTot'=>$hostNetTot,'hostCurrencyType'=>$hostCurrencyType,'hostCurrencySymbol'=>$hostCurrencySymbol,'cancel_policy' => $cancel_policy,);
			/*$reg = $adminnewstemplateArr;
			$message = $this->load->view('newsletter/UsermailExperiencebooking' . $newsid . '.php', $reg, TRUE);
			echo '<br>User Mail<br>'.$message;
			$newsid = '22';
			$message1 = $this->load->view('newsletter/Adminmailbooking' . $newsid . '.php', $reg, TRUE);
			echo '<br>Admin Mail<br>'.$message1;
			$newsid = '34';
            $message2 = $this->load->view('newsletter/Host Mail Booking' . $newsid . '.php', $reg, TRUE);
			echo '<br>Host Mail<br>'.$message2;
			exit;*/
            /*$currency_symbol = $this->session->userdata('currency_s');
            $currency = $Rental_details->row()->currency;
            $currency_type = $this->session->userdata('currency_type');
            $currency_price = $Rental_details->row()->price;
            $currency_amount = $currency_price;
            $securityDeposite = $Contact_details->row()->secDeposit;
            $currency_serviceFee = $Contact_details->row()->serviceFee;
            $cancel_policy = $Rental_details->row()->cancel_policy;
            if ($currency != $this->session->userdata('currency_type')) {
                $currency_price = convertCurrency($currency, $this->session->userdata('currency_type'), $currency_price);
            } else {
                $currency_price = $currency_price;
            }
            if ($currency != $this->session->userdata('currency_type')) {
                $currency_amount = str_replace(',', '', convertCurrency($currency, $this->session->userdata('currency_type'), $currency_amount));
            } else {
                $currency_amount = $currency_amount;
            }
            if ($securityDeposite != 0) {
                if ($currency != $this->session->userdata('currency_type')) {
                    $securityDeposite = convertCurrency($currency, $this->session->userdata('currency_type'), $securityDeposite);
                } else {
                    $securityDeposite = $securityDeposite;
                }
            }
            if ($currency != $this->session->userdata('currency_type')) {
                $currency_serviceFee = convertCurrency($currency, $this->session->userdata('currency_type'), $currency_serviceFee);
            } else {
                $currency_serviceFee = $currency_serviceFee;
            }
            $currency_netamount = $currency_amount + $securityDeposite + $currency_serviceFee;
            $host_currency_netamount = $currency_amount + $securityDeposite;*/
            /***************************************currency****************************/
			//rental_image rental_name cancel_policy
            /*$adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo'], 'first_name' => $user_details->row()->firstname, 'last_name' => $user_details->row()->lastname, 'NoofGuest' => $Contact_details->row()->NoofGuest, 'numofdates' => $Contact_details->row()->numofdates, 'booking_status' => $Contact_details->row()->booking_status, 'user_email' => $user_details->row()->email, 'ph_no' => $Renter_details->row()->phone_no, 'Enquiry' => $Contact_details->row()->Enquiry, 'checkin' => $chkIn, 'checkout' => $chkOut, 'currency_price' => $currency_price, 'currency' => $Rental_details->row()->currency, 'securityDeposite' => $securityDeposite, 'amount' => $total, 'netamount' => $Contact_details->row()->totalAmt, 'days' => $Contact_details->row()->numofdates, 'currency_serviceFee' => $currency_serviceFee, 'renter_id' => $PaymentSuccess->row()->sell_id, 'prd_id' => $PaymentSuccess->row()->product_id, 'renter_fname' => $Renter_details->row()->firstname, 'renter_lname' => $Renter_details->row()->lastname, 'owner_email' => $Renter_details->row()->email, 'owner_phone' => $Renter_details->row()->phone_no, 'rental_name' => $Rental_details->row()->experience_title, 'rental_image' => $proImages, 'renter_image' => $renter_image, 'user_image' => $user_image, 'currency_symbol' => $currency_symbol, 'user_type' => $user_details->row()->loginUserType, 'currency_amount' => $currency_amount, 'currency_netamount' => $currency_netamount, 'currency_type' => $currency_type, 'cancel_policy' => $cancel_policy, 'host_currency_netamount' => $host_currency_netamount);*/
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
                //             $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Experience is booked (".$Rental_details->row()->experience_title.") successfully"));
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
                //             $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . ". Your Experience is booked (".$Rental_details->row()->experience_title.") successfully by User"));
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
            /*$this->experience_order_model->simple_insert(INBOX, array('sender_id' => $sender_email, 'user_id' => $PaymentSuccess->row()->user_id, 'mailsubject' => $template_values['news_subject'], 'description' => stripslashes($message)));*/
            $this->session->set_userdata('ContacterEmail', $user_details->row()->email);
            /* Mail function starts  */
            $reg = $adminnewstemplateArr;
			//print_r($reg);
			//echo '<br>'.$sender_email;
			//exit;
            $this->load->library('email');
            for ($i = 1; $i <= 3; $i++) {
                if ($i == 1) {
                    $message = $this->load->view('newsletter/UsermailExperiencebooking' . $newsid . '.php', $reg, TRUE); // users
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
					//sales@laravelecommerce.com
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
                        //echo $e->getMessage();
                    }
                }
            }
        }

        public function booking_conform_mail_admin($paymentid)
        {
            $PaymentSuccess = $this->experience_order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('dealCodeNumber' => $paymentid));
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_details = $this->experience_order_model->get_all_details(USERS, $condition);
            $condition3 = array('id' => $PaymentSuccess->row()->user_id);
            $user_details = $this->experience_order_model->get_all_details(USERS, $condition3);
            $condition1 = array('experience_id' => $PaymentSuccess->row()->product_id);
            $Rental_details = $this->experience_order_model->get_all_details(EXPERIENCE, $condition1);
            $Contact_details = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->experience_order_model->get_all_details(PRODUCT_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            /* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
        }

        public function booking_conform_mail_host($paymentid)
        {
            $PaymentSuccess = $this->experience_order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT, array('dealCodeNumber' => $paymentid));
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_details = $this->experience_order_model->get_all_details(USERS, $condition);
            $condition = array('id' => $PaymentSuccess->row()->sell_id);
            $Renter_email = $this->experience_order_model->get_all_details(USERS, $condition);
            $condition3 = array('id' => $PaymentSuccess->row()->user_id);
            $user_details = $this->experience_order_model->get_all_details(USERS, $condition3);
            $condition1 = array('experience_id' => $PaymentSuccess->row()->product_id);
            $Rental_details = $this->experience_order_model->get_all_details(EXPERIENCE, $condition1);
            $Contact_details = $this->experience_order_model->get_all_details(EXPERIENCE_ENQUIRY, array('id' => $PaymentSuccess->row()->EnquiryId));
            $RentalPhoto = $this->experience_order_model->get_all_details(EXPERIENCE_PHOTOS, array('product_id' => $PaymentSuccess->row()->product_id));
            /* $total = $Renter_details->row()->price * $Contact_details->row()->numofdates; */
            $total = $Contact_details->row()->totalAmt - $Contact_details->row()->serviceFee;
        }

        public function mail_owner_admin_booking($got_values)
        {
            $header = '';
            $adminnewstemplateArr = array();
            $subject = '';
            $cfmurl = '';
            $sender_email = '';
            $sender_name = '';
            if ($got_values['renter_id'] > 0) {
                $UserDetails = $this->user_model->get_all_details(USERS, array('id' => $got_values['renter_id']));
                $emailid = $UserDetails->row()->email;
                $this->experience_order_model->simple_insert(INBOX, array('sender_id' => $this->session->userdata('ContacterEmail'), 'user_id' => $emailid, 'mailsubject' => $template_values['news_subject'], 'description' => stripslashes($message)));
                $email_values = array('mail_type' => 'html', 'from_mail_id' => $sender_email, 'mail_name' => $sender_name, 'to_mail_id' => $emailid, 'subject_message' => $template_values['news_subject'], 'body_messages' => $message);
                $this->session->unset_userdata('ContacterEmail');
                $email_send_to_common = $this->experience_order_model->common_email_send($email_values);
            }
        }

        public function ipnpayment()
        {
            mysql_query('CREATE TABLE IF NOT EXISTS ' . EXPERIENCE_TRANSACTION . ' ( `id` int(255) NOT NULL AUTO_INCREMENT,`payment_cycle` varchar(500) NOT NULL,`txn_type` varchar(500) NOT NULL, `last_name` varchar(500) NOT NULL,`next_payment_date` varchar(500) NOT NULL, `residence_country` varchar(500) NOT NULL, `initial_payment_amount` varchar(500) NOT NULL, `currency_code` varchar(500) NOT NULL, `time_created` varchar(500) NOT NULL, `verify_sign` varchar(750) NOT NULL, `period_type` varchar(500) NOT NULL, `payer_status` varchar(500) NOT NULL, `test_ipn` varchar(500) NOT NULL, `tax` varchar(500) NOT NULL, `payer_email` varchar(500) NOT NULL, `first_name` varchar(500) NOT NULL, `receiver_email` varchar(500) NOT NULL, `payer_id` varchar(500) NOT NULL, `product_type` varchar(500) NOT NULL, `shipping` varchar(500) NOT NULL, `amount_per_cycle` varchar(500) NOT NULL, `profile_status` varchar(500) NOT NULL, `charset` varchar(500) NOT NULL, `notify_version` varchar(500) NOT NULL, `amount` varchar(500) NOT NULL, `outstanding_balance` varchar(500) NOT NULL, `recurring_payment_id` varchar(500) NOT NULL, `product_name` varchar(500) NOT NULL,`custom_values` varchar(500) NOT NULL, `ipn_track_id` varchar(500) NOT NULL, `tran_date` datetime NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3;');
            mysql_query("insert into " . EXPERIENCE_TRANSACTION . " set  payment_cycle='" . $_REQUEST['payment_cycle'] . "', txn_type='" . $_REQUEST['txn_type'] . "', last_name='" . $_REQUEST['last_name'] . "',
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
                    $this->data['Confirmation'] = $this->experience_order_model->PaymentSuccess($newcustom[1], $newcustom[2], $transId, $Pray_Email);
                    //$userdata = array('fc_session_user_id' => $newcustom[1],'randomNo' => $newcustom[2]);
                    $this->session->unset_userdata($userdata);
                } elseif ($newcustom[0] == 'Gift') {
                    $userdata = array('fc_session_user_id' => $newcustom[1]);
                    $this->session->set_userdata($userdata);
                    $transId = $_REQUEST['txn_id'];
                    $Pray_Email = $_REQUEST['payer_email'];
                    $this->data['Confirmation'] = $this->experience_order_model->PaymentGiftSuccess($newcustom[1], $transId, $Pray_Email);
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
            $this->experience_order_model->simple_insert(PRODUCT_COMMENTS, $conditionArr);
            $cmtID = $this->experience_order_model->get_last_insert_id();
            $datestring = "%Y-%m-%d %h:%i:%s";
            $time = time();
            $createdTime = mdate($datestring, $time);
            $actArr = array('activity' => 'own-product-comment', 'activity_id' => $product_id, 'user_id' => $this->checkLogin('U'), 'activity_ip' => $this->input->ip_address(), 'created' => $createdTime, 'comment_id' => $cmtID);
            $this->experience_order_model->simple_insert(NOTIFICATIONS, $actArr);
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

