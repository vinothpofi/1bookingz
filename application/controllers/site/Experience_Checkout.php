<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Experience payment and management full control.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class Experience_Checkout extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper(array('cookie', 'date', 'form', 'email'));
            $this->load->library(array('encrypt', 'form_validation'));
            $this->load->model('experience_checkout_model');
            $this->data['loginCheck'] = $this->checkLogin('U');
            $this->data['countryList'] = $this->experience_checkout_model->get_all_details(COUNTRY_LIST, array());
            define("API_LOGINID", $this->config->item('payment_2'));
            define("StripeDetails", $this->config->item('payment_1'));
        }

        /****************** Insert the checkout to user********************/
        public function PaymentProcess()
        { /*echo '<pre>'; print_r($_POST); die;*/
            $product_id = $this->input->post('product_id');
            $tax = $this->input->post('tax');
            $enquiryid = $this->input->post('enquiryid');
            $product = $this->experience_checkout_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
            $this->load->library('paypal_class');
            $item_name = $this->input->post('product_name');
            $totalAmount = $this->input->post('price');
            $indtotal = $this->input->post('indtotal');
            $currencyCode = $this->input->post('currencycode');
            $user_currencycode = $this->input->post('user_currencycode');
            $loginUserId = $this->checkLogin('U');
			$currency_cron_id = $this->input->post('currency_cron_id');
            $quantity = 1;
            if ($this->session->userdata('randomNo') != '') {
                $delete = 'delete from ' . EXPERIENCE_BOOKING_PAYMENT . ' where dealCodeNumber = "' . $this->session->userdata('randomNo') . '" and user_id = "' . $loginUserId . '" and status != "Paid"  ';
                $this->experience_checkout_model->ExecuteQuery($delete, 'delete');
                $dealCodeNumber = $this->session->userdata('randomNo');
            } else {
                $dealCodeNumber = mt_rand();
            }
            $insertIds = array();
            $now = date("Y-m-d H:i:s");
            $paymentArr = array('product_id' => $product_id, 'price' => $totalAmount, //'price'=> convertCurrency($currencyCode,'USD',$totalAmount),
                                'indtotal'   => $indtotal, //'indtotal'=> convertCurrency($currencyCode,'USD',$indtotal),
                                'tax'        => $tax, 'sumtotal' => $totalAmount, //'sumtotal'=> convertCurrency($currencyCode,'USD',$totalAmount),
                                'user_id'    => $loginUserId, 'sell_id' => $product->row()->user_id, 'created' => $now, 'dealCodeNumber' => $dealCodeNumber, 'status' => 'Pending', 'shipping_status' => 'Pending', //'total'  => convertCurrency($currencyCode,'USD',$totalAmount),
                                'total'      => $totalAmount, 'EnquiryId' => $enquiryid, 'inserttime' => NOW(), 'payment_type' => 'Paypal', 'currency_code' => $user_currencycode);
            $this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT, $paymentArr);
            $insertIds[] = $this->db->insert_id();
            $paymtdata = array('randomNo' => $dealCodeNumber, 'randomIds' => $insertIds);
            $lastFeatureInsertId = $dealCodeNumber;
            $this->session->set_userdata($paymtdata);
            $paypal_settings = unserialize($this->config->item('payment_0'));
            $paypal_settings = unserialize($paypal_settings['settings']);
            if ($paypal_settings['mode'] == 'sandbox') {
                $this->paypal_class->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            } else {
                $this->paypal_class->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            }
            if ($paypal_settings['mode'] == 'sandbox') {
                $ctype = 'USD';
            } else {
                $ctype = 'USD';
            }
            $logo = base_url() . 'images/logo/' . $this->data['logo_img'];
            $CurrencyType = $this->experience_checkout_model->get_all_details(CURRENCY, array('currency_type' => $ctype));
            $this->paypal_class->add_field('currency_code', $CurrencyType->row()->currency_type);
            $this->paypal_class->add_field('image_url', $logo);
            $this->paypal_class->add_field('business', $paypal_settings['merchant_email']); // Business Email
            $this->paypal_class->add_field('return', base_url() . 'Experience_Order/success/' . $loginUserId . '/' . $lastFeatureInsertId); // Return URL
            $this->paypal_class->add_field('cancel_return', base_url() . 'Experience_Order/failure'); // Cancel URL
            $this->paypal_class->add_field('notify_url', base_url() . 'Experience_Order/ipnpayment'); // Notify url
            $this->paypal_class->add_field('custom', 'Product|' . $loginUserId . '|' . $lastFeatureInsertId); // Custom Values
            $this->paypal_class->add_field('item_name', $item_name); // Product Name
            $this->paypal_class->add_field('user_id', $loginUserId);
            $this->paypal_class->add_field('quantity', $quantity); // Quantity
            //$currencyCode;
            if ($user_currencycode != 'USD') {
                //$totalAmount = convertCurrency($currencyCode, 'USD', $totalAmount);
				$totalAmount = currency_conversion($user_currencycode, 'USD', $totalAmount,$currency_cron_id);
            }
            $this->paypal_class->add_field('amount', $totalAmount); // Price
            $this->paypal_class->submit_paypal_post();
        }

        public function UserPaymentCreditStripe()
        {
            //echo '<pre>'; print_r($_POST); die;
            $userDetails = $this->experience_checkout_model->get_all_details(USERS, $condition);
            $loginUserId = $this->checkLogin('U');
            $product_id = $this->input->post('product_id');
            $tax = $this->input->post('tax');
            $currencyCode = $this->input->post('currencycode');
			$user_currencycode = $this->input->post('user_currencycode');
            $currency_cron_id = $this->input->post('currency_cron_id');
            $enquiryid = $this->input->post('enquiryid');
            $indtotal = $this->input->post('indtotal');  // experience unit price
            $product = $this->experience_checkout_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
            $seller = $this->experience_checkout_model->get_all_details(USERS, array('id' => $product->row()->user_id));
            $dealcode = $this->db->insert_id(); 
            $lastFeatureInsertId = $this->session->userdata('randomNo'); 
            $userDetails = $this->experience_checkout_model->get_all_details(USERS, $condition);
			
            $values = array('amount' => $this->input->post('total_price'), 'card_num' => $this->input->post('cardNumber'), 'exp_date' => $this->input->post('CCExpDay') . '/' . $this->input->post('CCExpMnth'), 'first_name' => $userDetails->row()->firstname, 'last_name' => $userDetails->row()->lastname, 'address' => $this->input->post('address'), 'city' => $this->input->post('city'), 'state' => $this->input->post('state'), 'country' => $userDetails->row()->country, 'phone' => $userDetails->row()->phone_no, 'email' => $userDetails->row()->email, 'card_code' => $this->input->post('creditCardIdentifier'));
            $excludeArr = array('authorize_mode', 'authorize_id', 'authorize_key', 'creditvalue', 'shipping_id', 'cardType', 'email', 'cardNumber', 'CCExpDay', 'CCExpMnth', 'creditCardIdentifier', 'total_price', 'CreditSubmit');
            $condition = array('id' => $loginUserId);
            $dataArr = array('user_id' => $loginUserId, 'full_name' => $userDetails->row()->firstname . ' ' . $userDetails->row()->lastname, 'address1' => $this->input->post('address'), 'address2' => $this->input->post('address2'), 'city' => $this->input->post('city'), 'state' => $this->input->post('state'), 'country' => $this->input->post('country'), 'postal_code' => $this->input->post('postal_code'), 'phone' => $this->input->post('phone_no'));

            $StripDetVal = unserialize(StripeDetails);
            $StripeVals = unserialize($StripDetVal['settings']);
            require_once('./stripe/lib/Stripe.php');
            $secret_key = $StripeVals['secret_key'];
            $publishable_key = $StripeVals['publishable_key'];
            $stripe = array("secret_key" => $secret_key, "publishable_key" => $publishable_key);
           // Stripe::setApiKey($stripe['secret_key']);
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            $token = $this->input->post('stripeToken');
            //$amounts = currencyConvertToUSD($product_id, $values['amount']) * 100;
			$amounts = currency_conversion($user_currencycode, 'USD', $this->input->post('total_price'),$currency_cron_id);
		//	echo $amounts; exit;
            try {
               // $customer = Stripe_Customer::create(array("card" => $token, "description" => "Product Purhcase for " . $this->config->item('email_title'), "email" => $this->input->post('email')));
                //stripe_new
                 $customer = \Stripe\Customer::create(array("card" => $token, "description" => "Product Purhcase for " . $this->config->item('email_title'), "email" => $this->input->post('email')));

                // Stripe_Charge::create(array("amount"   => ($amounts*100), # amount in cents, again
                //                             "currency" => 'USD', "customer" => $customer->id));
                
                 \Stripe\Charge::create(array("amount"   => ($amounts*100), # amount in cents, again
                    "currency" => 'USD', "customer" => $customer->id));

                $product_id = $this->input->post('booking_rental_id');
                $product = $this->experience_checkout_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
                $seller = $this->experience_checkout_model->get_all_details(USERS, array('id' => $product->row()->user_id));
                $totalAmount = $this->input->post('total_price');
                //$totalAmount = currency_conversion($user_currencycode, 'USD', $this->input->post('total_price'),$currency_cron_id);
                if ($this->session->userdata('randomNo') != '') {
                    $delete = 'delete from ' . EXPERIENCE_BOOKING_PAYMENT . ' where dealCodeNumber = "' . $this->session->userdata('randomNo') . '" and user_id = "' . $loginUserId . '" ';
                    $this->experience_checkout_model->ExecuteQuery($delete, 'delete');
                    $dealCodeNumber = $this->session->userdata('randomNo');
                } else {
                    $dealCodeNumber = mt_rand();
                }
                $insertIds = array();
                $now = date("Y-m-d H:i:s");
                $paymentArr = array('product_id' => $product_id, 'sell_id' => $product->row()->user_id, 'price' => $totalAmount,   //totAmt in rentalEnquiry
                                    'indtotal'   => $indtotal, 'sumtotal' => $totalAmount,  //totAmt in rentalEnquiry
                                    'user_id'    => $loginUserId, //price in product Tbl
                                    'created'    => $now, 'dealCodeNumber' => $dealCodeNumber, 'status' => 'Pending', 'shipping_status' => 'Pending', 'total' => $totalAmount,  //totAmt in rentalEnquiry
                                    'EnquiryId'  => $enquiryid, 'inserttime' => NOW(), 'currency_code' => $user_currencycode);
                $this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT, $paymentArr);
                $insertIds[] = $this->db->insert_id();
                $paymtdata = array('randomNo' => $dealCodeNumber, 'randomIds' => $insertIds, 'EnquiryId' => $enquiryid);
                $this->session->set_userdata($paymtdata);
                $this->experience_checkout_model->edit_rentalbooking(array('booking_status' => 'Booked'), array('id' => $this->session->userdata('EnquiryId')));
                $lastFeatureInsertId = $this->session->userdata('randomNo');
                redirect('Experience_Order/success/' . $loginUserId . '/' . $lastFeatureInsertId . '/' . $token);
            } catch (Exception $e) {
                $error = $e->getMessage();
                $this->session->set_userdata('payment_error', $error);
                redirect('Experience_Order/failure');
            }
        }

        public function PaymentCredit()
        {
            //echo '<pre>';print_r($_POST);die;
            $cvv = md5($this->input->post('creditCardIdentifier'));
            $dataArr = array('cvv' => $cvv);
            $condition = array('id' => $this->checkLogin('U'));
            $userDetails = $this->experience_checkout_model->get_all_details(USERS, $condition);
            $loginUserId = $this->checkLogin('U');
            $lastFeatureInsertId = $this->session->userdata('randomNo');
            $currency_code = $this->input->post('currencycode');
			$user_currencycode = $this->input->post('user_currencycode');
            if ($this->input->post('creditvalue') == 'authorize') {
                $Auth_Details = unserialize(API_LOGINID);
                $Auth_Setting_Details = unserialize($Auth_Details['settings']);
                ///echo '<pre>';print_r($Auth_Setting_Details);die;
                error_reporting(-1);
                define("AUTHORIZENET_API_LOGIN_ID", $Auth_Setting_Details['merchantcode']);    // Add your API LOGIN ID
                define("AUTHORIZENET_TRANSACTION_KEY", $Auth_Setting_Details['merchantkey']); // Add your API transaction key
                define("API_MODE", $Auth_Setting_Details['mode']);
                if (API_MODE == 'sandbox') {
                    define("AUTHORIZENET_SANDBOX", true);// Set to false to test against production
                } else {
                    define("AUTHORIZENET_SANDBOX", false);
                }
                define("TEST_REQUEST", "FALSE");
                require_once './authorize/autoload.php';
                $transaction = new AuthorizeNetAIM;
                $transaction->setSandbox(AUTHORIZENET_SANDBOX);
				$payable_amount = currency_conversion($this->input->post('user_currencycode'), 'USD', $this->input->post('total_price'),$this->input->post('currency_cron_id'));
                $transaction->setFields(array('amount' => $payable_amount, 'card_num' => $this->input->post('cardNumber'), 'exp_date' => $this->input->post('CCExpMonth') . '/' . $this->input->post('CCExpYear'), 'first_name' => $userDetails->row()->firstname, 'last_name' => $userDetails->row()->lastname, 'address' => $this->input->post('address'), 'city' => $this->input->post('city'), 'state' => $this->input->post('state'), 'country' => $userDetails->row()->country, 'phone' => $userDetails->row()->phone_no, 'email' => $userDetails->row()->email, 'card_code' => $this->input->post('creditCardIdentifier'),));
                $response = $transaction->authorizeAndCapture();
                //echo '<pre>';print_r($response);die;
                if ($response->approved != '') {
                    $product_id = $this->input->post('booking_rental_id');
                    $product = $this->experience_checkout_model->get_all_details(EXPERIENCE, array('experience_id' => $product_id));
                    $seller = $this->experience_checkout_model->get_all_details(USERS, array('id' => $product->row()->user_id));
                    $totalAmnt = $this->input->post('total_price');
                    $enquiryid = $this->input->post('enquiryid');
                    $indtotal = $this->input->post('indtotal');  // experience unit price
                    $loginUserId = $this->checkLogin('U');
                    if ($this->session->userdata('randomNo') != '') {
                        $delete = 'delete from ' . EXPERIENCE_BOOKING_PAYMENT . ' where dealCodeNumber = "' . $this->session->userdata('randomNo') . '" and user_id = "' . $loginUserId . '" ';
                        $this->experience_checkout_model->ExecuteQuery($delete, 'delete');
                        $dealCodeNumber = $this->session->userdata('randomNo');
                    } else {
                        $dealCodeNumber = mt_rand();
                    }
           
                    $insertIds = array();
                    $now = date("Y-m-d H:i:s");
                    $paymentArr = array('product_id' => $product_id, 'sell_id' => $product->row()->user_id, 'price' => $totalAmnt, 'indtotal' => $indtotal, 'sumtotal' => $totalAmnt, 'user_id' => $loginUserId, 'created' => $now, 'dealCodeNumber' => $dealCodeNumber, 'status' => 'Paid', 'shipping_status' => 'Pending', 'total' => $totalAmnt, 'EnquiryId' => $enquiryid, 'inserttime' => NOW(), 'currency_code' => $user_currencycode);
                    $this->experience_checkout_model->simple_insert(EXPERIENCE_BOOKING_PAYMENT, $paymentArr);
                    $insertIds[] = $this->db->insert_id();
                    $paymtdata = array('randomNo' => $dealCodeNumber, 'randomIds' => $insertIds);
                    $this->session->set_userdata($paymtdata, $currency_code);
                    $this->experience_checkout_model->edit_rentalbooking(array('booking_status' => 'Booked'), array('id' => $enquiryid));
                    $lastFeatureInsertId = $this->session->userdata('randomNo');
                    redirect('Experience_Order/success/' . $loginUserId . '/' . $lastFeatureInsertId . '/' . $response->transaction_id);
                } else {
                    $this->session->set_userdata('payment_error', $response->response_reason_text);
                    //redirect('experience_order/failure/'.$response->response_reason_text);
                    redirect('Experience_Order/failure/');
                }
            }
        }

    }
    /* End of file experience_checkout.php */
    /* Location: ./application/controllers/site/experience_checkout.php */