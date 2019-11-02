<?php if (!defined('BASEPATH')) exit ('No direct script access allowed');

/**
 * URI:               http://www.homestaydnn.com/
 * Description:       Sign in and sign out for normal and social media users
 * Version:           2.0
 * Author:            Sathyaseelan,Vishnu
 **/
class Signupsignin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array(
            'cookie',
            'date',
            'form',
            'email',
            'url',
            'string'
        ));
        $this->load->library(array(
            'form_validation',
            'session',
            'email',
            'google',
			'facebook'
        ));
        $this->load->model(array(
            'user_model',
            'product_model',
            'contact_model',
            'checkout_model',
            'order_model'
        ));
        $this->load->config('linkedin');
        if ($_SESSION ['sMainCategories'] == '') {
            $sortArr1 = array(
                'field' => 'cat_position',
                'type' => 'asc'
            );
            $sortArr = array(
                $sortArr1
            );
            $_SESSION ['sMainCategories'] = $this->product_model->get_all_details(CATEGORY, array(
                'rootID' => '0',
                'status' => 'Active'
            ), $sortArr);
        }
        $this->data ['mainCategories'] = $_SESSION ['sMainCategories'];
        if ($_SESSION ['sColorLists'] == '') {
            $_SESSION ['sColorLists'] = $this->user_model->get_all_details(LIST_VALUES, array(
                'list_id' => '1'
            ));
        }
        $this->data ['mainColorLists'] = $_SESSION ['sColorLists'];
        $this->data ['loginCheck'] = $this->checkLogin('U');
        $this->data ['likedProducts'] = array();
        if ($this->data ['loginCheck'] != '') {
            $this->data ['WishlistUserDetails'] = $this->user_model->get_all_details(USERS, array(
                'id' => $this->checkLogin('U')
            ));
            $this->data ['likedProducts'] = $this->user_model->get_all_details(PRODUCT_LIKES, array(
                'user_id' => $this->checkLogin('U')
            ));
        }
    }

    /**
     * Function for signup
     */
     function create_normal_user($message)
    {
		
        $firstname = $this->input->post('first_name');
        $lastname = $this->input->post('last_name');
        $email = $this->input->post('email_address');
        $phone_number = $this->input->post('phone');
        $confirm_password = $this->input->post('user_password');
        $pwd = md5($this->input->post('user_password'));
        $birth_month = md5($this->input->post('birth_month'));
        $birth_day = md5($this->input->post('birth_day'));
        $birth_year = md5($this->input->post('birth_year'));
        $invite_reference = $this->input->post('invite_reference');
		
        $acc_group_type = $this->input->post('group_type'); 
        $business_name = $this->input->post('business_name');
        $business_desc = $this->input->post('business_desc'); 
        $license_no = $this->input->post('license_no');
        $business_addr = $this->input->post('business_addr');
		//print_r($_POST); exit;
		//echo $invite_reference; exit;
        $expireddate = date('Y-m-d', strtotime('+15 days'));
        if (valid_email($email)) {
            $condition = array(
                'email' => $email
            );
            $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' ORDER BY `id` DESC");
            if ($duplicateMail->num_rows() > 0) {
                echo 'Error::Email id already exists';
                exit;
            } else {
				$login_type='normal';
				$rep_code='';
				$this->user_model->insertUserQuick_user($firstname, $lastname, $phone_number, $email, $pwd, $confirm_password, $expireddate, $login_type, $this->input->post('birth_day'), $this->input->post('birth_month'), $this->input->post('birth_year'), $invite_reference, $rep_code,$acc_group_type,$business_name,$business_desc,$license_no,$business_addr);

                /*==================SMS SEND==========================*/ 
                 if ($this->config->item('twilio_status') == '1') {

                    require_once('twilio/Services/Twilio.php');
                    $account_sid = $this->config->item('twilio_account_sid');
                    $auth_token = $this->config->item('twilio_account_token');
                    $from = $this->config->item('twilio_phone_number');
                    try {
                        $to = $phone_number;
                        
                        $client = new Services_Twilio($account_sid, $auth_token);
                        $client->account->messages->create(array('To' => $to, 'From' => $from, 'Body' => "Hi This is from " . $this->config->item('meta_title') . " and Your are Registered Successfully. "));
                        //echo 'success';
                    } catch (Services_Twilio_RestException $e) {
                        //echo "Authentication Failed..!";
                    }
                }
                /*==================SMS SEND==========================*/

                /*$this->user_model->insertUserQuick($firstname, $lastname, $email, $pwd, $confirm_password, $expireddate, $birth_day, $birth_month, $birth_year,$invite_reference);*/
                /* Get user details*/
                /*Set Session Variable*/
                $usrDetails = $this->user_model->get_all_details(USERS, $condition);
                if ($usrDetails->num_rows() == '1') {
                    $userdata = array(
                        'fc_session_user_id' => $usrDetails->row()->id,
                        'fc_session_user_login_type' => 'normal',
                        'session_user_email' => $usrDetails->row()->email,
                        'normal_login' => normal
                    );
                    $this->session->set_userdata($userdata);
                    $datestring = "%Y-%m-%d %h:%i:%s";
                    $time = time();
                    $newdata = array(
                        'last_login_date' => mdate($datestring, $time),
                        'last_login_ip' => $this->input->ip_address()
                    );
                    $condition = array(
                        'id' => $usrDetails->row()->id
                    );
                    $this->user_model->update_details(USERS, $newdata, $condition);


					
					if ($this->lang->line('succ_created') != '') {
                        $succ_created= stripslashes($this->lang->line('succ_created'));
                     } else $succ_created= "Successfully Account Created"; 
					
                    echo "Success::$succ_created";
                }

                /* Send Mail to users and admin */
                /*============ Start For User =================*/
                $newsid = '35';
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
                $randStr = $this->get_rand_str('10');
                $cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
                $logo_mail = $this->data['logo'];
                $reg = array('username' => $username, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
                $email_values = array(
                    'from_mail_id' => $sender_email,
                    'to_mail_id' => $usrDetails->row()->email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
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
                /*============ End For User =================*/
                /*============ Start For Admin =================*/
                $newsid = '42';
                $template_values = $this->product_model->get_newsletter_template_details($newsid);
                if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                    $sender_email = $this->data['siteContactMail'];
                    $sender_name = $this->data['siteTitle'];
                } else {
                    $sender_name = $template_values['sender_name'];
                    $sender_email = $template_values['sender_email'];
                }
                $username = $usrDetails->row()->user_name;
                $email = $usrDetails->row()->email;
                $cfmurl = 'There is one new registration done on website. User details below.';
                $logo_mail = $this->data['logo'];
                $reg = array('username' => $username, 'email' => $email, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationAdminConfirmation' . $newsid . '.php', $reg, TRUE);
                $email_values = array(
                    'from_mail_id' => $sender_email,
                    'to_mail_id' => $sender_email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
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
                /*============ End For Admin =================*/
            }
        }
    }

    /* Normal User Login */
    function login_normal_user()
    {
		
        $email = $this->input->post('email_address');
        $pwd = md5($this->input->post('user_password'));
        $expireddate = date('Y-m-d', strtotime('+15 days'));
        if (valid_email($email)) {
            $isUserFound = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' AND `password` ='" . $pwd . "' AND status='Active' ORDER BY `id` DESC");
            $isUserstatus = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' AND `password` ='" . $pwd . "' AND status='Inactive' ORDER BY `id` DESC");
            $isUserstatus_deleted = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' AND `password` ='" . $pwd . "' AND host_status='1' ORDER BY `id` DESC");
            if($isUserstatus->num_rows() == 1 || $isUserstatus_deleted->num_rows() == 1){
                $is_deleted = '1' ;
            }else{
                $is_deleted = '0' ;
            }
            if ($isUserFound->num_rows() == 0) {
                  if($is_deleted == 0)
               { 
                echo 'Error::Invalid Login Details';
            }
            else{
                echo 'Error::Your Account Was Canceled. Please Contact Admin.';
            }
                exit;
            } else {
                if ($isUserFound->num_rows() == '1') {
                    $userdata = array(
                        'fc_session_user_id' => $isUserFound->row()->id,
                        'fc_session_user_login_type' => 'normal',
                        'session_user_email' => $isUserFound->row()->email,
                        'normal_login' => 'normal'
                    );
                    $this->session->set_userdata($userdata);
                    $datestring = "%Y-%m-%d %h:%i:%s";
                    $time = time();
                    $newdata = array(
                        'last_login_date' => mdate($datestring, $time),
                        'expired_date' => $expireddate,
                        'last_login_ip' => $this->input->ip_address()
                    );
                    $condition = array(
                        'id' => $isUserFound->row()->id
                    );
                    $this->user_model->update_details(USERS, $newdata, $condition);
					if($this->input->post('remember_me')=='true')
					{
						if (!isset($_COOKIE['autologin'])) {   
							$expiretime=time()+60*60*24; 
							$rememberArray =array('email'=>$email,'password'=>$this->input->post('user_password'));
							$json = json_encode($rememberArray);
							setcookie('autologin', $json, $expiretime, "/"); 
						}
					}
					else
					{
						$expiretime=time()-60*60*24; 
						setcookie('autologin', '', $expiretime, "/"); 
					}						
					if ($this->lang->line('login_msg') != '') {
						$succ= stripslashes($this->lang->line('login_msg'));
					} else $succ= "Successfully Logged In"; 
                   // $this->setErrorMessage('success',$succ);

                //redirect(base_url());
                    echo "Success::$succ"; 
                }
            }
        }
    }

    /* Forgot Password Reset */
    function send_password_to_mail()
    {
        $email = $this->input->post('email_address');
        if (valid_email($email)) {
            $isUserFound = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' ORDER BY `id` DESC");
            if ($isUserFound->num_rows() == 0) {
                echo 'Error::Invalid Email Address';
                exit;
            } else {
                $alphabet = "abcdefghijuwxyzABCDE01234FGHIJKLMNOPQklmnopqrstRSTUWXYZ0123456789";
                $pwd = substr( str_shuffle( $alphabet ), 0, 10 );
                $newdata = array(
                    'password' => md5($pwd)
                );
                $condition = array(
                    'email' => $email
                );
                $this->user_model->update_details(USERS, $newdata, $condition);
                $newsid = '5';
                $template_values = $this->user_model->get_newsletter_template_details($newsid);
                $adminnewstemplateArr = array(
                    'email_title' => $this->config->item('email_title'),
                    'logo' => $this->config->item('logo_image')
                );
                extract($adminnewstemplateArr);
                $newsid = '5';
                if ($template_values ['sender_name'] == '' && $template_values ['sender_email'] == '') {
                    $sender_email = $this->config->item('site_contact_mail');
                    $sender_name = $this->config->item('email_title');
                } else {
                    $sender_name = $template_values ['sender_name'];
                    $sender_email = $template_values ['sender_email'];
                }
                $reg = array (
                    'email_title' => $this->config->item ( 'email_title' ),'pwd' => $pwd,'logo' => $this->config->item('logo_image'));
                $message = $this->load->view('newsletter/Forgot Password' . $newsid . '.php', $reg, TRUE);

                $email_values = array(
                    'mail_type' => 'html',
                    'from_mail_id' => $sender_email,
                    'mail_name' => $sender_name,
                    'to_mail_id' => $isUserFound->row()->email,
                    'subject_message' => 'Password Reset',
                    'body_messages' => $message
                );
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
                if ($this->lang->line('new_password_send_email') != '') {
                            $send = stripslashes($this->lang->line('new_password_send_email'));
                        } else $send = "New Password Send To your Email Account"; 
                echo 'Success::'.$send;
            }
        }
    }

    /*Google Login*/
    public function googleLogin($message)
    {
        if (isset($_GET['code'])) {
            $this->google->getAuthenticate();
            $gpInfo = $this->google->getUserInfo();
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $gpInfo['id'];
            $userData['first_name'] = $gpInfo['given_name'];
            $userData['last_name'] = $gpInfo['family_name'];
            $userData['email'] = $gpInfo['email'];
            $userData['gender'] = !empty($gpInfo['gender']) ? $gpInfo['gender'] : '';
            $userData['locale'] = !empty($gpInfo['locale']) ? $gpInfo['locale'] : '';
            $userData['profile_url'] = !empty($gpInfo['link']) ? $gpInfo['link'] : '';
            $userData['picture_url'] = !empty($gpInfo['picture']) ? $gpInfo['picture'] : '';
            /*insert or update user data to the database*/
            $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
             $deactivateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' AND status='Inactive' ORDER BY `id` DESC");
            if ($duplicateMail->num_rows() > 0) {
                $userdata = array(
                    'fc_session_user_id' => $duplicateMail->row()->id,
                    'session_user_email' => $duplicateMail->row()->email,
                    'fc_session_user_login_type' => 'google'
                );
                $this->session->set_userdata($userdata);
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $newdata = array(
                    'last_login_date' => mdate($datestring, $time),
                    'last_login_ip' => $this->input->ip_address()
                );
                $condition = array(
                    'id' => $duplicateMail->row()->id
                );
                $this->user_model->update_details(USERS, $newdata, $condition);
                if($this->session->has_userdata('session_redirect_url')){
                    $redirect_url=$this->session->session_redirect_url;
                    $this->session->unset_userdata('session_redirect_url');
                    redirect(base_url($redirect_url));
                }
                redirect(base_url($this->session->current_page_url));
            } else {
                if ($deactivateMail->num_rows() > 0) {

                     $message = "Your Account Was Canceled. Please Contact Admin.";
                $this->setErrorMessage('success', $message);

            redirect(base_url());
                 }
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $confirm_password = substr( str_shuffle( $alphabet ), 0, 10 );
                $pwd = md5($confirm_password);
                $expireddate = date('Y-m-d', strtotime('+15 days'));
                $login_type = 'google';
                $this->user_model->insertUserQuick($userData['first_name'], $userData['last_name'], $userData['email'], $pwd, $confirm_password, $expireddate,$login_type);
                /* Get user details*/
                /*Set Session Variable*/
                $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
                $condition = array(
                    'id' => $duplicateMail->row()->id
                );
                $usrDetails = $this->user_model->get_all_details(USERS, $condition);
                if ($usrDetails->num_rows() == '1') {
                    $userdata = array(
                        'fc_session_user_id' => $usrDetails->row()->id,
                        'session_user_email' => $usrDetails->row()->email,
                        'fc_session_user_login_type' => 'google'
                    );
                    $this->session->set_userdata($userdata);
                    $datestring = "%Y-%m-%d %h:%i:%s";
                    $time = time();
                    $newdata = array(
                        'last_login_date' => mdate($datestring, $time),
                        'last_login_ip' => $this->input->ip_address()
                    );
                    $condition = array(
                        'id' => $usrDetails->row()->id
                    );
                    $this->user_model->update_details(USERS, $newdata, $condition);
					
					
                    if ($this->lang->line('succ_created') != '') {
							$succ_created= stripslashes($this->lang->line('succ_created'));
                     } else $succ_created= "Successfully Account Created"; 
                    echo "Success::$succ_created";
                }
                /* Send Mail to users and admin */
                /*============ Start For User =================*/
                $newsid = '35';
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
                $randStr = $this->get_rand_str('10');
                $cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
                $logo_mail = $this->data['logo'];
                $email_values = array(
                    'from_mail_id' => $sender_email,
                    'to_mail_id' =>$usrDetails->row()->email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
                $reg = array('username' => $username, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
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
                /*============ End For User =================*/
                /*============ Start For Admin =================*/
                $newsid = '42';
                $template_values = $this->product_model->get_newsletter_template_details($newsid);
                if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                    $sender_email = $this->data['siteContactMail'];
                    $sender_name = $this->data['siteTitle'];
                } else {
                    $sender_name = $template_values['sender_name'];
                    $sender_email = $template_values['sender_email'];
                }
                $username = $usrDetails->row()->user_name;
                $email = $usrDetails->row()->email;
                $cfmurl = 'There is one new registration done on website. User details below.';
                $logo_mail = $this->data['logo'];
                $email_values = array(
                    'from_mail_id' => $usrDetails->row()->email,
                    'to_mail_id' => $sender_email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
                $reg = array('username' => $username, 'email' => $email, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationAdminConfirmation' . $newsid . '.php', $reg, TRUE);
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
                $this->session->set_userdata('loggedIn', true);
                $this->session->set_userdata('userData', $userData);
                if($this->session->has_userdata('session_redirect_url')){
                    $redirect_url=$this->session->session_redirect_url;
                    $this->session->unset_userdata('session_redirect_url');
                    redirect(base_url($redirect_url));
                }
                redirect(base_url($this->session->current_page_url));
            }
        }
    }

    /*Facebook Login*/
   public function FbLogin($message)
    {
		//echo 'Authenticated'.$this->facebook->is_authenticated();
        if ($this->facebook->is_authenticated()) {
           // print_r("ok1");exit;
            //authenticate user
            $this->facebook->getAuthenticate();
            //get user info from google
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
            //preparing data for database insertion
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['first_name'];
            $userData['last_name'] = $userProfile['last_name'];
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = 'https://www.facebook.com/' . $userProfile['id'];
            $userData['picture_url'] = $userProfile['picture']['data']['url'];//insert or update user data to the database
            $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
            if ($duplicateMail->num_rows() > 0) {
                $userdata = array(
                    'fc_session_user_id' => $duplicateMail->row()->id,
                    'session_user_email' => $duplicateMail->row()->email,
                    'fc_session_user_login_type' => 'facebook'
                );
                $this->session->set_userdata($userdata);
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $newdata = array(
                    'last_login_date' => mdate($datestring, $time),
                    'last_login_ip' => $this->input->ip_address()
                );
                $condition = array(
                    'id' => $duplicateMail->row()->id
                );
                $this->user_model->update_details(USERS, $newdata, $condition);
                if($this->session->has_userdata('session_redirect_url')){
                    $redirect_url=$this->session->session_redirect_url;
                    $this->session->unset_userdata('session_redirect_url');
                    redirect(base_url($redirect_url));
                }
                redirect(base_url($this->session->current_page_url));
            } else {
                $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                $confirm_password = substr( str_shuffle( $alphabet ), 0, 10 );
                $pwd = md5($confirm_password);
                $expireddate = date('Y-m-d', strtotime('+15 days'));
                $login_type = 'facebook';
                $this->user_model->insertUserQuick($userData['first_name'], $userData['last_name'], $userData['email'], $pwd, $confirm_password, $expireddate,$login_type);
                $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
                $condition = array(
                    'id' => $duplicateMail->row()->id
                );
                $usrDetails = $this->user_model->get_all_details(USERS, $condition);
                if ($usrDetails->num_rows() == '1') {
                    $userdata = array(
                        'fc_session_user_id' => $usrDetails->row()->id,
                        'session_user_email' => $usrDetails->row()->email,
                        'fc_session_user_login_type' => 'facebook',
                    );
                    $this->session->set_userdata($userdata);
                    $datestring = "%Y-%m-%d %h:%i:%s";
                    $time = time();
                    $newdata = array(
                        'last_login_date' => mdate($datestring, $time),
                        'last_login_ip' => $this->input->ip_address()
                    );
                    $condition = array(
                        'id' => $usrDetails->row()->id
                    );
                    $this->user_model->update_details(USERS, $newdata, $condition);
					
					
                    if ($this->lang->line('succ_created') != '') {
							$succ_created= stripslashes($this->lang->line('succ_created'));
                     } else $succ_created= "Successfully Account Created"; 
                    echo "Success::$succ_created";
                }
                $newsid = '35';
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
                $randStr = $this->get_rand_str('10');
                $cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
                $logo_mail = $this->data['logo'];
                $email_values = array(
                    'from_mail_id' => $sender_email,
                    'to_mail_id' => $usrDetails->row()->email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
                $reg = array('username' => $username, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
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
                $newsid = '42';
                $template_values = $this->product_model->get_newsletter_template_details($newsid);
                if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                    $sender_email = $this->data['siteContactMail'];
                    $sender_name = $this->data['siteTitle'];
                } else {
                    $sender_name = $template_values['sender_name'];
                    $sender_email = $template_values['sender_email'];
                }
                $username = $usrDetails->row()->user_name;
                $email = $usrDetails->row()->email;
                $cfmurl = 'There is one new registration done on website. User details below.';
                $logo_mail = $this->data['logo'];
                $email_values = array(
                    'from_mail_id' => $usrDetails->row()->email,
                    'to_mail_id' => $sender_email,
                    'subject_message' => $template_values ['news_subject'],
                    'body_messages' => $message
                );
                $reg = array('username' => $username, 'email' => $email, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                $message = $this->load->view('newsletter/RegistrationAdminConfirmation' . $newsid . '.php', $reg, TRUE);
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
                if($this->session->has_userdata('session_redirect_url')){
                    $redirect_url=$this->session->session_redirect_url;
                    $this->session->unset_userdata('session_redirect_url');
                    redirect(base_url($redirect_url));
                }
                redirect(base_url($this->session->current_page_url));
            }
        }
    }

    /*LinkedIn Login*/
    public function linkedInLogin($message)
    {
        //Include the linkedin api php libraries
        include_once APPPATH . "libraries/linkedin-oauth-client/http.php";
        include_once APPPATH . "libraries/linkedin-oauth-client/oauth_client.php";
        //Get status and user info from session
        $oauthStatus = $this->session->userdata('oauth_status');
        $sessUserData = $this->session->userdata('userData');
        if (isset($oauthStatus) && $oauthStatus == 'verified') {
            //User info from session
            $userData = $sessUserData;
        } elseif ((isset($_GET["oauth_init"]) && $_GET["oauth_init"] == 1) || (isset($_GET['oauth_token']) && isset($_GET['oauth_verifier']))) {
            $client = new oauth_client_class;
            $client->client_id = $this->config->item('linkedin_api_key');
            $client->client_secret = $this->config->item('linkedin_api_secret');
            $client->redirect_uri = base_url() . $this->config->item('linkedin_redirect_url');
            $client->scope = $this->config->item('linkedin_scope');
            $client->debug = false;
            $client->debug_http = true;
            $application_line = __LINE__;
            //If authentication returns success
            if ($success = $client->Initialize()) {
                if (($success = $client->Process())) {
                    if (strlen($client->authorization_error)) {
                        $client->error = $client->authorization_error;
                        $success = false;
                    } elseif (strlen($client->access_token)) {
                        $success = $client->CallAPI('http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)',
                            'GET',
                            array('format' => 'json'),
                            array('FailOnAccessError' => true), $userInfo);
                    }
                }
                $success = $client->Finalize($success);
            }
            if ($client->exit) exit;
            if ($success) {
                //Preparing data for database insertion
                $first_name = !empty($userInfo->firstName) ? $userInfo->firstName : '';
                $last_name = !empty($userInfo->lastName) ? $userInfo->lastName : '';
                $userData = array(
                    'oauth_provider' => 'linkedin',
                    'oauth_uid' => $userInfo->id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $userInfo->emailAddress,
                    'locale' => $userInfo->location->name,
                    'profile_url' => $userInfo->publicProfileUrl,
                    'picture_url' => $userInfo->pictureUrl
                );
                $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
                if ($duplicateMail->num_rows() > 0) {
                    $userdata = array(
                        'fc_session_user_id' => $duplicateMail->row()->id,
                        'session_user_email' => $duplicateMail->row()->email,
                        'fc_session_user_login_type' => 'linkedin'
                    );
                    $this->session->set_userdata($userdata);
                    $datestring = "%Y-%m-%d %h:%i:%s";
                    $time = time();
                    $newdata = array(
                        'last_login_date' => mdate($datestring, $time),
                        'last_login_ip' => $this->input->ip_address()
                    );
                    $condition = array(
                        'id' => $duplicateMail->row()->id
                    );
                    $this->user_model->update_details(USERS, $newdata, $condition);
                    if($this->session->has_userdata('session_redirect_url')){
                        $redirect_url=$this->session->session_redirect_url;
                        $this->session->unset_userdata('session_redirect_url');
                        redirect(base_url($redirect_url));
                    }
                    redirect(base_url($this->session->current_page_url));
                } else {
                    $deactivateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' AND status='Inactive' ORDER BY `id` DESC");

                    if ($deactivateMail->num_rows() > 0) {

                     $message = "Your Account Was Canceled. Please Contact Admin.";
                $this->setErrorMessage('success', $message);

            redirect(base_url());
                 }
                    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
                    $confirm_password = substr( str_shuffle( $alphabet ), 0, 10 );
                    $pwd = md5($confirm_password);
                    $expireddate = date('Y-m-d', strtotime('+15 days'));
                    $login_type = 'linkedin';
                    $this->user_model->insertUserQuick($userData['first_name'], $userData['last_name'], $userData['email'], $pwd, $confirm_password, $expireddate,$login_type);
                    /* Get user details*/
                    /*Set Session Variable*/
                    $duplicateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $userData['email'] . "' ORDER BY `id` DESC");
                    $condition = array(
                        'id' => $duplicateMail->row()->id
                    );
                    $usrDetails = $this->user_model->get_all_details(USERS, $condition);
                    if ($usrDetails->num_rows() == '1') {
                        $userdata = array(
                            'fc_session_user_id' => $usrDetails->row()->id,
                            'session_user_email' => $usrDetails->row()->email,
                            'fc_session_user_login_type' => 'linkedin'
                        );
                        $this->session->set_userdata($userdata);
                        $datestring = "%Y-%m-%d %h:%i:%s";
                        $time = time();
                        $newdata = array(
                            'last_login_date' => mdate($datestring, $time),
                            'last_login_ip' => $this->input->ip_address()
                        );
                        $condition = array(
                            'id' => $usrDetails->row()->id
                        );
                        $this->user_model->update_details(USERS, $newdata, $condition);
						
						
                       if ($this->lang->line('succ_created') != '') {
							$succ_created= stripslashes($this->lang->line('succ_created'));
                     } else $succ_created= "Successfully Account Created"; 
						echo "Success::$succ_created";
                    }
                    /* Send Mail to users and admin */
                    /*============ Start For User =================*/
                    $newsid = '35';
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
                    $randStr = $this->get_rand_str('10');
                    $cfmurl = base_url() . 'site/user/confirm_verify/' . $uid . "/" . $randStr . "/confirmation";
                    $logo_mail = $this->data['logo'];
                    $email_values = array(
                        'from_mail_id' => $sender_email,
                        'to_mail_id' => $usrDetails->row()->email,
                        'subject_message' => $template_values ['news_subject'],
                        'body_messages' => $message
                    );
                    $reg = array('username' => $username, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                    $message = $this->load->view('newsletter/RegistrationConfirmation' . $newsid . '.php', $reg, TRUE);
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
                    /*============ End For User =================*/
                    /*============ Start For Admin =================*/
                    $newsid = '42';
                    $template_values = $this->product_model->get_newsletter_template_details($newsid);
                    if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
                        $sender_email = $this->data['siteContactMail'];
                        $sender_name = $this->data['siteTitle'];
                    } else {
                        $sender_name = $template_values['sender_name'];
                        $sender_email = $template_values['sender_email'];
                    }
                    $username = $usrDetails->row()->user_name;
                    $email = $usrDetails->row()->email;
                    $cfmurl = 'There is one new registration done on website. User details below.';
                    $logo_mail = $this->data['logo'];
                    $email_values = array(
                        'from_mail_id' => $usrDetails->row()->email,
                        'to_mail_id' => $sender_email,
                        'subject_message' => $template_values ['news_subject'],
                        'body_messages' => $message
                    );
                    $reg = array('username' => $username, 'email' => $email, 'cfmurl' => $cfmurl, 'email_title' => $sender_name, 'logo' => $logo_mail);
                    $message = $this->load->view('newsletter/RegistrationAdminConfirmation' . $newsid . '.php', $reg, TRUE);
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
                    if($this->session->has_userdata('session_redirect_url')){
                        $redirect_url=$this->session->session_redirect_url;
                        $this->session->unset_userdata('session_redirect_url');
                        redirect(base_url($redirect_url));
                    }
                    redirect(base_url($this->session->current_page_url));
                }
            } else {
                $data['error_msg'] = 'Some problem occurred, please try again later!';
            }
        } elseif (isset($_REQUEST["oauth_problem"]) && $_REQUEST["oauth_problem"] <> "") {
            $data['error_msg'] = $_GET["oauth_problem"];
        } else {
            $data['oauthURL'] = base_url() . $this->config->item('linkedin_redirect_url') . '?oauth_init=1';
        }
    }

    /*Logout All type except FB*/
    public function user_logout()
    {
        $this->session->unset_userdata('fc_session_user_id');
        $this->session->unset_userdata('session_user_email');
        $this->session->unset_userdata('fc_session_user_login_type');
        /*$this->session->sess_destroy();*/
        redirect(base_url());
    }

    /* FB Logout*/
    public function Fblogout()
    {
        $this->facebook->destroy_session();
        $this->session->unset_userdata('fc_session_user_id');
        $this->session->unset_userdata('session_user_email');
        $this->session->unset_userdata('fc_session_user_login_type');
        redirect(base_url());
    }
}
