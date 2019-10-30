<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Twillio Messaging controller.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class Twilio extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->model('product_model');
            $this->load->library('session');
        }

        public function index()
        {
            redirect('site/twilio/send_sms');
        }

        public function send_sms()
        {
            require_once('twilio/Services/Twilio.php');
            $account_sid = 'AC86dee6bbb798dfa194415808420c6518';
            $auth_token = '0a4495ba71d620a5981f0527743e5de4';
            $client = new Services_Twilio($account_sid, $auth_token);
            $client->account->messages->create(array('To' => "+917845727657", 'From' => "+14703308893", 'Body' => "Hi This is Ganga",));
        }

        public function product_verification()
        {
            require_once('twilio/Services/Twilio.php');
            $account_sid = $this->config->item('twilio_account_sid');
            $auth_token = $this->config->item('twilio_account_token');
            $random_confirmation_number = mt_rand(100000, 999999);
            $excludeArr = array('product_id', 'mobile_code');
            $dataArr = array('mobile_verification_code' => $random_confirmation_number, 'phone_no' => $this->input->post('phone_no'), 'ph_country' => $this->input->post('ph_country'));
            $condition = array('id' => $this->checkLogin('U'));
            $this->product_model->commonInsertUpdate(USERS, 'update', $excludeArr, $dataArr, $condition);
            $from = $this->config->item('twilio_phone_number');
            if ($this->input->post('mobile_code') && $this->input->post('phone_no')) {
                $mobile_code = $this->input->post('mobile_code');
                $phone_number = $this->input->post('phone_no');
            } else {
                $user_details_query = $this->product_model->get_all_details(USERS, array('id' => $this->checkLogin('U')));
                $mobile_code_query = 'SELECT country_mobile_code FROM ' . LOCATIONS . ' WHERE id=' . $user_details_query->row()->country;
                $mobile_code = $this->product_model->ExecuteQuery($mobile_code_query);
                $phone_number = $this->data['userDetails']->row()->phone_no;
                $mobile_code = $mobile_code->row()->country_mobile_code;
            }
            /**start - to show the message in network that credential is not valid**/
            if ($this->config->item('twilio_status') == '1') {
                try {
                    $to = $mobile_code . $phone_number;
                    $client = new Services_Twilio($account_sid, $auth_token);
                    $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . " and Your Verification Code is " . $random_confirmation_number,));
                    echo 'success';
                } catch (Services_Twilio_RestException $e) {
                    echo "Authentication Failed..!";
                }
            }
        }

        public function get_mobile_code()
        {
            $country_id = $this->input->post('country_id');
            $country_mobile_code_query = 'SELECT country_mobile_code FROM ' . LOCATIONS . ' WHERE id=' . $country_id;
            $country_mobile_code = $this->product_model->ExecuteQuery($country_mobile_code_query)->row_array();
            echo json_encode($country_mobile_code);
        }

        public function get_mobile_code_default()
        {
            $country_id = $this->input->post('country_id');
            $country_mobile_code_query = 'SELECT country_mobile_code FROM ' . LOCATIONS . ' WHERE id=' . $country_id;
            $country_mobile_code = $this->product_model->ExecuteQuery($country_mobile_code_query)->row_array();
            echo json_encode($country_mobile_code);
        }

    }