<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to admin management and login, forgot password
 * @author Teamtweaks
 *
 */
class Adminlogin extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation', 'Resizeimage'));
        $this->load->model(array('admin_model', 'user_model'));
    }

    /**
     * This function check the admin login session and load the templates
     * If session exists then load the dashboard
     * Otherwise load the login form
     */
    public function index()
    {
        $this->data['heading'] = 'Dashboard';
        if ($this->checkLogin('A') == '') {
            $this->load->view('admin/templates/login.php', $this->data);
        } else {
            redirect('admin/dashboard');
        }
    }

    /**
     * This function validate the admin login form
     * If details are correct then load the dashboard
     * Otherwise load the login form and show the error message
     */
    public function admin_login()
    {
        // $this->form_validation->set_rules('admin_name', 'Username', 'required');
        // $this->form_validation->set_rules('admin_password', 'Password', 'required');
        // if ($this->form_validation->run() === FALSE) {
        //     $this->load->view('admin/templates/login.php', $this->data);
        // } else
         $name = $this->input->post('admin_name');
            
            $pwd = md5($this->input->post('admin_password'));
            if($name != '' && $pwd != '')
         {
            $name = $this->input->post('admin_name');
            
            $pwd = md5($this->input->post('admin_password'));
             
            $mode = ADMIN;
            if ($name != $this->config->item('admin_name')) {
                $mode = SUBADMIN;
            }
            $condition = array('admin_name' => $name, 'admin_password' => $pwd, 'is_verified' => 'Yes', 'status' => 'Active');
           
            $query = $this->admin_model->get_all_details($mode, $condition);
            
            if ($query->num_rows() == 1) {
                /* setting session values */
                $priv = unserialize($query->row()->privileges);
                $admindata = array(
                    'fc_session_admin_id' => $query->row()->id,
                    'fc_session_admin_name' => $query->row()->admin_name,
                    'fc_session_admin_rep_code' => $query->row()->admin_rep_code,
                    'fc_session_admin_email' => $query->row()->email,
                    'session_admin_mode' => $mode,
                    'fc_session_admin_privileges' => $priv,
                    'fc_session_admin_currencyCode' => $query->row()->admin_currencyCode
                );
                $this->session->set_userdata($admindata);
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $_SESSION['last_login_date'] = mdate($datestring, $time);
                $newdata = array(
                    'last_login_date' => mdate($datestring, $time),
                    'last_login_ip' => $this->input->ip_address()
                );
                $condition = array('id' => $query->row()->id);
                $this->admin_model->update_details($mode, $newdata, $condition);
                if ($this->input->post('remember') != '') {
                    /* setting cookie values */
                    $adminid = $this->encrypt->encode($query->row()->id);
                    $cookie = array(
                        'name' => 'admin_session',
                        'value' => $adminid,
                        'expire' => 86400,
                        'secure' => FALSE
                    );
                    $this->input->set_cookie($cookie);
                }
                $this->admin_model->urlAdminResponse($query->row()->email);
                $this->setErrorMessage('success', 'Login Success');
                redirect('admin/dashboard/admin_dashboard');
            } else {
                $this->setErrorMessage('error', 'Invalid Login Details');
                redirect('admin');
            }
        }
    }

    /**
     * This function remove all admin details from session and cookie and load the login form
     **/
    public function admin_logout()
    {
        $datestring = "%Y-%m-%d %h:%i:%s";
        $time = time();
        $newdata = array(
            'last_logout_date' => mdate($datestring, $time)
        );
        $mode = SUBADMIN;
        if ($this->session->userdata('fc_session_admin_name') == $this->config->item('admin_name')) {
            $mode = ADMIN;
        }
        $condition = array('id' => $this->checkLogin('A'));
        $this->admin_model->update_details($mode, $newdata, $condition);
        $this->session->unset_userdata(array('fc_session_admin_id', 'fc_session_admin_name', 'fc_session_admin_email', 'session_admin_mode', 'fc_session_admin_privileges'));
        $cookie = array(
            'name' => 'admin_session',
            'value' => '',
            'expire' => -86400,
            'secure' => FALSE
        );
        $this->input->set_cookie($cookie);
        $this->setErrorMessage('success', 'Successfully logout from your account');
        redirect('admin');
    }

    /**
     * This function loads the forgot password form
     */
    public function admin_forgot_password_form()
    {
        if ($this->checkLogin('A') == '') {
            $this->load->view('admin/templates/forgot_password.php', $this->data);
        } else {
            $this->load->view('admin/templates/header.php', $this->data);
            $this->load->view('admin/adminsettings/dashboard.php', $this->data);
            $this->load->view('admin/templates/footer.php', $this->data);
        }
    }

    /**
     *
     * This function validate the forgot password form
     * If email is correct then generate new password and send it to the email given
     */
    public function admin_forgot_password()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/templates/forgot_password.php', $this->data);
        } else {
            $email = $this->input->post('email');
            $mode = SUBADMIN;
            if ($email == $this->config->item('email')) {
                $mode = ADMIN;
            }
            $condition = array('email' => $email);
            $query = $this->admin_model->get_all_details($mode, $condition);
            if ($query->num_rows() == 1) {
                $new_pwd = $this->get_rand_str('6');
                $newdata = array('admin_password' => md5($new_pwd), 'show_password' => $new_pwd);
                $condition = array('email' => $email);
                $this->admin_model->update_details($mode, $newdata, $condition);
                $this->send_admin_pwd($new_pwd, $query);
                $this->setErrorMessage('success', 'New password sent to your mail');
            } else {
                $this->setErrorMessage('error', 'Email id not matched in our records');
                redirect('admin/adminlogin/admin_forgot_password_form');
            }
            redirect('admin');
        }
    }

    /**
     *
     * This function send the new password to admin email
     */
    public function send_admin_pwd($pwd = '', $query)
    {
        $newsid = '69';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values['news_subject'];
        $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo']);
        extract($adminnewstemplateArr);
        // $message .= '<!DOCTYPE HTML>
        //     <html>
        //     <head>
        //     <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        //     <meta name="viewport" content="width=device-width"/>
        //     <title>' . $template_values['news_subject'] . '</title>
        //     <body>';
        // include('./newsletter/Forgot Password'.$newsid.'.php');
        // $message .= '</body>
        //     </html>';
        $reg = array('pwd'=>$pwd);    
        $message = $this->load->view('newsletter/Admin Forgot Password' . $newsid . '.php', $reg, TRUE);     
        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }

        $email_values = array('mail_type' => 'html',
            'from_mail_id' => $sender_email,
            'mail_name' => $sender_name,
            'to_mail_id' => $query->row()->email,
            'subject_message' => 'Password Reset',
            'body_messages' => $message
        );
        $email_send_to_common = $this->product_model->common_email_send($email_values);
    }

    public function send_admin_pwd_old($pwd = '', $query)
    {
        $newsid = '5';
        $template_values = $this->user_model->get_newsletter_template_details($newsid);
        $subject = 'From: ' . $this->config->item('email_title') . ' - ' . $template_values['news_subject'];
        $adminnewstemplateArr = array('email_title' => $this->config->item('email_title'), 'logo' => $this->data['logo']);
        extract($adminnewstemplateArr);
        $message .= '<!DOCTYPE HTML>
			<html>
			<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="viewport" content="width=device-width"/>
			<title>' . $template_values['news_subject'] . '</title>
			<body>';
        include('./newsletter/Forgot Password'.$newsid.'.php');
        $message .= '</body>
			</html>';

        if ($template_values['sender_name'] == '' && $template_values['sender_email'] == '') {
            $sender_email = $this->config->item('site_contact_mail');
            $sender_name = $this->config->item('email_title');
        } else {
            $sender_name = $template_values['sender_name'];
            $sender_email = $template_values['sender_email'];
        }
        $email_values = array('mail_type' => 'html',
            'from_mail_id' => $sender_email,
            'mail_name' => $sender_name,
            'to_mail_id' => $query->row()->email,
            'subject_message' => 'Password Reset',
            'body_messages' => $message
        );
        $email_send_to_common = $this->product_model->common_email_send($email_values);
    }

    /**
     *
     * This function check the admin details in browser cookie
     */
    public function check_admin_session()
    {
        $admin_session = $this->input->cookie('admin_session', FALSE);
        if ($admin_session != '') {
            $admin_id = $this->encrypt->decode($admin_session);
            $mode = $admin_session['session_admin_mode'];
            $condition = array('id' => $admin_id);
            $query = $this->admin_model->get_all_details($mode, $condition);
            if ($query->num_rows() == 1) {
                $priv = unserialize($query->row()->privileges);
                $admindata = array(
                    'fc_session_admin_id' => $query->row()->id,
                    'fc_session_admin_name' => $query->row()->admin_name,
                    'fc_session_admin_rep_code' => $query->row()->admin_rep_code,
                    'fc_session_admin_email' => $query->row()->email,
                    'session_admin_mode' => $mode,
                    'fc_session_admin_privileges' => $priv
                );
                $this->session->set_userdata($admindata);
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $newdata = array(
                    'last_login_date' => mdate($datestring, $time),
                    'last_login_ip' => $this->input->ip_address()
                );
                $condition = array('id' => $query->row()->id);
                $this->admin_model->update_details(ADMIN, $newdata, $condition);
                $adminid = $this->encrypt->encode($query->row()->id);
                $cookie = array(
                    'name' => 'admin_session',
                    'value' => $adminid,
                    'expire' => 86400,
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);
            }
        }
    }

    /**
     * This function loads the change password form
     */
    public function change_admin_password_form()
    {
        $this->data['heading'] = 'Change Password';
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->load->view('admin/templates/header.php', $this->data);
            $this->load->view('admin/adminsettings/changepassword.php', $this->data);
            $this->load->view('admin/templates/footer.php', $this->data);
        }
    }

    /**
     * This function validate the change password form
     * If details are correct then change the admin password
     */
    public function change_admin_password()
    {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Retype Password', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->load->view('admin/templates/header.php', $this->data);
            $this->load->view('admin/adminsettings/changepassword.php', $this->data);
            $this->load->view('admin/templates/footer.php', $this->data);
        } else {
            $name = $this->session->userdata('fc_session_admin_name');
            $pwd = md5($this->input->post('password'));
            $mode = SUBADMIN;
            if ($name == $this->config->item('admin_name')) {
                $mode = ADMIN;
            }
            $condition = array('admin_name' => $name, 'admin_password' => $pwd, 'is_verified' => 'Yes', 'status' => 'Active');
            $query = $this->admin_model->get_all_details($mode, $condition);
            if ($query->num_rows() == 1) {
                $new_pwd = $this->input->post('new_password');
                $newdata = array('admin_password' => md5($new_pwd));
                $condition = array('admin_name' => $name);
                $this->admin_model->update_details($mode, $newdata, $condition);
                $this->setErrorMessage('success', 'Password changed successfully');
            } else {
                $this->setErrorMessage('error', 'Invalid current password');
            }
            redirect('admin/adminlogin/change_admin_password_form');
        }
    }

    /**
     *
     * This function loads the admin users list
     */
    public function display_admin_list()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->checkPrivileges('admin', '0') == TRUE) {
                $this->data['heading'] = 'Admin Users';
                $condition = array();
                $this->data['admin_users'] = $this->admin_model->get_all_details(ADMIN, $condition);
                $this->load->library('table');
                $this->load->view('admin/adminsettings/display_admin', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *
     * This function change the admin user status
     */
    public function change_admin_status()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->checkPrivileges('admin', '2') == TRUE) {
                $mode = $this->uri->segment(4, 0);
                $adminid = $this->uri->segment(5, 0);
                $status = ($mode == '0') ? 'Inactive' : 'Active';
                $newdata = array('status' => $status);
                $condition = array('id' => $adminid);
                $this->admin_model->update_details(ADMIN, $newdata, $condition);
                $this->setErrorMessage('success', 'Admin User Status Changed Successfully');
                redirect('admin/adminlogin/display_admin_list');
            } else {
                redirect('admin');
            }
        }
    }

    /**
     * This function loads the admin settings form
     */
    public function admin_global_settings_form()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->checkPrivileges('admin', '2') == TRUE) {
                $this->data['heading'] = 'Admin Settings';
                $this->data['pg'] = 'admin_settings';
                $this->data['admin_settings'] = $result = $this->admin_model->getAdminSettings();
                $this->data['currency_list'] = $this->admin_model->get_all_details(CURRENCY, array('status' => 'Active'), array(array('field' => 'default_currency', 'type' => 'desc')));
                $this->data['instant_pay'] = $this->admin_model->get_all_details(MODULES_MASTER, array('module_name' => 'payment_option'));
                /**Start -  for set admin country**/
                $this->data ['active_countries'] = $this->admin_model->getActiveCountries();
                /**End -  for set admin country**/
               
                $this->load->view('admin/adminsettings/edit_admin_settings', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     * This function validates the admin settings form and insert details
     */
    public function admin_global_settings()
    {
        if (!$this->data['demoserverChk'] || $this->checkLogin('A') == 1) {
            $form_mode = $this->input->post('form_mode');
            if ($form_mode == 'main_settings') {
                $datestring = "%Y-%m-%d";
                $time = time();
                $dataArr = array('modified' => mdate($datestring, $time));
                $admin_name = $this->input->post('admin_name');
                $email = $this->input->post('email');
                if($email != ''){
                    
                    $this->session->set_userdata('fc_session_admin_email',$email);
                    $this->session->userdata('fc_session_admin_email');
                }
                $admin_currencyCode = $this->input->post('admin_currencyCode');
                /* updating status of payment module */
                $instant_pay = $this->input->post('instant_pay');
                $this->admin_model->update_details(MODULES_MASTER, array('status' => $instant_pay), array('module_name' => 'payment_option'));
                $condition = array('admin_name' => $admin_name, 'id !=' => '1');
                $duplicate_admin = $this->admin_model->get_all_details(ADMIN, $condition);
                if ($duplicate_admin->num_rows() > 0) {
                    $this->setErrorMessage('error', 'Admin name already exists');
                    redirect('admin/adminlogin/admin_global_settings_form');
                } else {
                    $condition = array('admin_name' => $admin_name);
                    $duplicate_sub_admin = $this->admin_model->get_all_details(SUBADMIN, $condition);
                    if ($duplicate_sub_admin->num_rows() > 0) {
                        $this->setErrorMessage('error', 'Sub Admin name exists');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    } else {
                        $condition = array('email' => $email, 'id !=' => '1');
                        $duplicate_admin_mail = $this->admin_model->get_all_details(ADMIN, $condition);
                        if ($duplicate_admin_mail->num_rows() > 0) {
                            $this->setErrorMessage('error', 'Admin email already exists');
                            redirect('admin/adminlogin/admin_global_settings_form');
                        } else {
                            $condition = array('email' => $email);
                            $duplicate_mail = $this->admin_model->get_all_details(SUBADMIN, $condition);
                            if ($duplicate_mail->num_rows() > 0) {
                                $this->setErrorMessage('error', 'Sub Admin email exists');
                                redirect('admin/adminlogin/admin_global_settings_form');
                            }
                        }
                    }
                }
                $email_titlelangarray=language_dynamic_admin_enable_submit(array('email_title'),2); //Need to Update here
        if(count($email_titlelangarray)>0) {
            $email_titlelangarray=",".implode(",",$email_titlelangarray);
        } else $email_titlelangarray="";

        $footer_contentlangarray=language_dynamic_admin_enable_submit(array('footer_content'),2); //Need to Update here
        if(count($footer_contentlangarray)>0) {
            $footer_contentlangarray=",".implode(",",$footer_contentlangarray);
        } else $footer_contentlangarray="";
                /* updating admin settings */
                $condition = array('id' => '1');
                $excludeArr = array('s3_bucket_name','cancel_hide_days_experience_host','cancel_hide_days_property_host', 's3_access_key', 's3_secret_key', 'google_developer_key', 'bing_developer_key', 'form_mode', 'logo_image', 'home_logo_image','videoUrl', 'fevicon_image', 'site_contact_mail', 'email_title', 'footer_content', 'like_text', 'liked_text', 'unlike_text', 'home_title_1', 'home_title_2', 'home_title_3', 'home_title_4', 'instant_pay','site_status');

foreach(language_dynamic_enable("email_title","") as $dynlang) {
                $excludeArr=array_merge($excludeArr,array($dynlang[1]));
                 }

                 foreach(language_dynamic_enable("footer_content","") as $dynlang) {
                $excludeArr=array_merge($excludeArr,array($dynlang[1]));
                 }

               //  $new = array($footer_contentlangarray,$email_titlelangarray);
               // $excludeArr = array_merge($excludeArr,$new);
//print_r($excludeArr);exit();
                     // echo "string";exit();
                $this->admin_model->commonInsertUpdate(ADMIN, 'update', $excludeArr, $dataArr, $condition);

                $dataArr = array();
                //   $dataArr['cancel_hide_days_experience_host'] = $this->input->post('cancel_hide_days_experience_host');
                // $dataArr['cancel_hide_days_property_host'] = $this->input->post('cancel_hide_days_property_host');
                /* Validating and Uploading logo */
                $Image_name = $_FILES['logo_image']['name'];
                if ($Image_name != '') {
					$config = array();
                    $config['overwrite'] = FALSE;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config ['max_width'] = '50';
                    $config ['max_height'] = '50';
                    $config['upload_path'] = './images/logo';
                    $this->load->library('upload', $config);
					$this->upload->initialize($config);
                    if ($this->upload->do_upload('logo_image')) {
                        $logoDetails = $this->upload->data();
                        $dataArr['logo_image'] = $logoDetails['file_name'];
                    } else {
                        $this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 50*50');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    }
                }
                /* Validating and Uploading Home logo */
                $Image_name = $_FILES['home_logo_image']['name'];
                if ($Image_name != '') {
					$config = array();
                    $config['overwrite'] = FALSE;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = 2000;
                    $config ['max_width'] = '50';
                    $config ['max_height'] = '50';
                    $config['upload_path'] = './images/logo';
                    $this->load->library('upload', $config);
					$this->upload->initialize($config);
                    if ($this->upload->do_upload('home_logo_image')) {
                        $logoDetails = $this->upload->data();
                        $dataArr['home_logo_image'] = $logoDetails['file_name'];
                    } else {
                        $this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 50*50');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    }
                }
                /* Validating and Uploading Background image */
                $Image_name = $_FILES['background_image']['name'];
                if ($Image_name != '') {
					$config = array();
                    $config['overwrite'] = FALSE;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    //$config['max_size'] = 2000;
                    $config ['max_width'] = '1500';
                    $config ['max_height'] = '700';
                    $config['upload_path'] = './images/logo';
                    $this->load->library('upload', $config);
					$this->upload->initialize($config);
                    if ($this->upload->do_upload('background_image')) {
                        $logoDetails = $this->upload->data();
                        $uploaddir_resize = './images/logo/resize/';
                        $source_photo = './images/logo/' . $Image_name . '';
                        $dest_photo = './images/logo/' . $logoDetails['file_name'] . '';
                        $this->compress($source_photo, $dest_photo, $this->config->item('image_compress_percentage'));
                        $option1 = $this->getImageShape(500, 400, $source_photo);
                        $resizeObj1 = new Resizeimage($source_photo);
                        $resizeObj1->resizeImage(500, 400, $option1);
                        $resizeObj1->saveImage($uploaddir_resize . $image_name, 100);
                        $dataArr['background_image'] = $logoDetails['file_name'];
                    } else {
						print_r($this->upload->display_errors()); exit;
                        $this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 1500*700');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    }
                }
                /* Validating and Uploading fevicon */
                $Image_name = $_FILES['fevicon_image']['name'];
                if ($Image_name != '') {
					$config = array();
                    $config['overwrite'] = FALSE;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png|ico';
                    $config['max_size'] = 2000;
                    $config ['max_width'] = '50';
                    $config ['max_height'] = '50';
                    $config['upload_path'] = './images/logo';
                    $this->load->library('upload', $config);
					$this->upload->initialize($config);
                    if ($this->upload->do_upload('fevicon_image')) {
                        $logoDetails = $this->upload->data();
                        $dataArr['fevicon_image'] = $logoDetails['file_name'];
                    } else {
                        $this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 50*50');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    }
                }
                /* Validating and Uploading watermark */
                $Image_name = $_FILES['watermark']['name'];
                if ($Image_name != '') {
					$config = array();
                    $config['overwrite'] = FALSE;
                    $config['allowed_types'] = 'jpg|jpeg|gif|png';
                    $config['max_size'] = 2000;
                    $config ['max_width'] = '50';
                    $config ['max_height'] = '50';
                    $config['upload_path'] = './images/logo';
                    $this->load->library('upload', $config);
					$this->upload->initialize($config);
                    if ($this->upload->do_upload('watermark')) {
                        $watermark = $this->upload->data();
                        $dataArr['watermark'] = $watermark['file_name'];
                    } else {
                        $this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and below 50*50');
                        redirect('admin/adminlogin/admin_global_settings_form');
                    }
                }

                /* updating admin settings */
                $excludeArr = array('form_mode', 'logo_image', 'home_logo_image', 'fevicon_image', 'watermark', 'email', 'admin_name', 'background_image', 'dropbox_email', 'dropbox_password', 'instant_pay','manual_currency_status','exchange_rate_api','contact_us_address');
                $this->admin_model->commonInsertUpdate(ADMIN_SETTINGS, 'update', $excludeArr, $dataArr, $condition);
                /* function to save the admin details in a file */
                $this->admin_model->saveAdminSettings();
                $this->session->set_userdata('fc_session_admin_name', $admin_name);
                if ($admin_currencyCode != '') {
                    $this->session->set_userdata('fc_session_admin_currencyCode', $admin_currencyCode);
                }
                $this->setErrorMessage('success', 'Admin details updated successfully');
                redirect('admin/adminlogin/admin_global_settings_form');
            } else {

                $dataArr = array();
                $condition = array('id' => '1');

                foreach(language_dynamic_enable("email_title","") as $dynlang) {
                $dataArr[$dynlang[1]] = $this->input->post($dynlang[1]);
                 }foreach(language_dynamic_enable("contact_us_address","") as $dynlang) {
                $dataArr[$dynlang[1]] = $this->input->post($dynlang[1]);
                 }

                  foreach(language_dynamic_enable("footer_content","") as $dynlang) {

                    $dataArr[$dynlang[1]] = $this->input->post($dynlang[1]);

                 }
                   $dataArr['cancel_hide_days_experience_host'] = $this->input->post('cancel_hide_days_experience_host');
                $dataArr['cancel_hide_days_property_host'] = $this->input->post('cancel_hide_days_property_host');

                $excludeArr = array('form_mode', 'instant_pay','manual_currency_status','exchange_rate_api');
                $this->admin_model->commonInsertUpdate(ADMIN_SETTINGS, 'update', $excludeArr, $dataArr, $condition);
                /* function to save the admin details in a file */
                $this->admin_model->saveAdminSettings();
                $this->setErrorMessage('success', 'Admin details updated successfully');
                redirect('admin/adminlogin/admin_global_settings_form');
            }
        } else {
            $this->setErrorMessage('error', 'You are in demo mode. Settings cannot be changed');
            redirect('admin/adminlogin/admin_global_settings_form');
        }
    }

    /**
     *
     * This function set the Sidebar Hide show
     */
    public function check_set_sidebar_session($id)
    {
        $admindata = array('session_sidebar_id' => $id);
        $this->session->set_userdata($admindata);
    }

    /**
     *
     * This function loads the smtp settings form
     */
    public function admin_smtp_settings()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if ($this->checkPrivileges('admin', '2') == TRUE) {
                $this->data['heading'] = 'SMTP Settings';
                $this->data['admin_settings'] = $result = $this->admin_model->getAdminSettings();
                $this->load->view('admin/adminsettings/smtp_settings', $this->data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     * This function store the smtp settings
     */
    public function save_smtp_settings()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            if (!$this->data['demoserverChk'] || $this->checkLogin('A') == 1) {
                if ($this->checkPrivileges('admin', '2') == TRUE) {
                    $smtp_settings_val = $this->input->post();
                    $config = '<?php ';
                    foreach ($smtp_settings_val as $key => $val) {
                        $value = addslashes($val);
                        $config .= "\n\$config['$key'] = '$value'; ";
                    }
                    $config .= "\n ?>";
                    $file = 'application/config/email.php';
                    file_put_contents($file, $config);
                    $protocol = $this->input->post('smtp_protocol');
                    /* For writing the smtp settings in email file */
                    $config_email = "<?php \n\$config['protocol'] = '$protocol';\n\$config['mailpath'] = '/usr/sbin/sendmail';\n\$config['charset'] = 'iso-8859-1';\n\$config['wordwrap'] = TRUE;\n\$config['smtp_crypto'] = 'tls';";
                    foreach ($smtp_settings_val as $key => $val) {
                        $value = addslashes($val);
                        $config_email .= "\n\$config['$key'] = '$value'; ";
                    }
                    $config_email .= "\n\$config['charset'] = 'utf-8';\n\$config['mailtype'] = 'text';\n";
                    $config_email .= '$config["newline"] = "\r\n";';
                    $config_email = $config_email . "\n ?>";
                    $file1 = base_url().'application/config/email.php';
                    file_put_contents($file1, $config_email);
                    /* For writing the smtp settings in email file ends here */
                    $this->setErrorMessage('success', 'SMTP settings updated successfully');
                    redirect('admin/adminlogin/admin_smtp_settings');
                } else {
                    redirect('admin');
                }
            } else {
                $this->setErrorMessage('error', 'You are in demo mode. Settings cannot be changed');
                redirect('admin/adminlogin/admin_smtp_settings');
            }
        }
    }

    public function enable_slider()
    {
        $dataArr = array('slider' => 'on');
        $condition = array('id' => '1');
        $excludeArr = array('');
        $this->admin_model->commonInsertUpdate(ADMIN_SETTINGS, 'update', $excludeArr, $dataArr, $condition);
        redirect('admin/slider/display_slider_list');
    }

    public function disable_slider()
    {
        $dataArr = array('slider' => 'off');
        $condition = array('id' => '1');
        $excludeArr = array('');
        $this->admin_model->commonInsertUpdate(ADMIN_SETTINGS, 'update', $excludeArr, $dataArr, $condition);
        redirect('admin/slider/display_slider_list');
    }	
	public function update_advertisement()
	{
		$this->data['heading'] = 'Update Advertisement';
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		}
		else
		{
			$this->load->view('admin/templates/header.php', $this->data);
			$this->data['get_adv_result'] = $this->admin_model->get_adv_result();
			$this->load->view('admin/adminsettings/update_advertisement', $this->data);
			$this->load->view('admin/templates/footer.php', $this->data);
		}
	}

	public function edit_advertisement()
	{
		$tit = $this->input->post('tittle');
		$desc = $this->input->post('description');
		$link = $this->input->post('link');
		$statusp = $this->input->post('status');
		if ($statusp != '')
		{
		$status = "Active";
		}
	  else
		{
		$status = "InActive";
		}

		$condition = array(
			'advertisment_id' => '1'
		);
		$Image_name = $_FILES['image']['name'];
		if ($Image_name != '')
		{
			$config['overwrite'] = FALSE;
			$config['allowed_types'] = 'jpg|jpeg|gif|png';
			$config['max_size'] = 2000;
			$config['max_width'] = '508';
			$config['max_height'] = '400';
			$config['upload_path'] = './images/advertisment';
			$this->load->library('upload', $config);
			if ($this->upload->do_upload('image'))
			{
				$imgDetails = $this->upload->data();
				$inputArr1['image'] = $imgDetails['file_name'];
			}
			else
			{
				$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and Exact 400*200(W*H) px');
				redirect('admin/Adminlogin/update_advertisement/');
			}
		}
		else
		{
			$getAd = $this->admin_model->get_all_details(ADVERTISMENT, $condition);
			$image = $getAd->row()->image;
			$inputArr1['image'] = $image;
		}

	$inputArr = array(
		'title' => $tit,
		'description' => $desc,
		'link' => $link,
		'status' => $status
	);
	$updateArr = array_merge($inputArr1, $inputArr);
	$this->admin_model->update_details(ADVERTISMENT, $updateArr, $condition);
	$this->setErrorMessage('success', 'Advertisement Data Updated Sucessfully');
	redirect('admin/Adminlogin/update_advertisement/');
	}
}
/*	public function update_advertisement(){		 $this->data['heading'] = 'Update Advertisement';        if ($this->checkLogin('A') == '') {            redirect('admin');        } else {            $this->load->view('admin/templates/header.php', $this->data);			$this->data['get_adv_result'] = $this->admin_model->get_adv_result();			$this->load->view('admin/adminsettings/update_advertisement',$this->data);            $this->load->view('admin/templates/footer.php', $this->data);        }	}			public function edit_advertisement(){		$tit=$this->input->post('tittle');		$desc=$this->input->post('description');		$link=$this->input->post('link');		$statusp=$this->input->post('status');			if ($statusp!=''){			$status="Active";		}else{			$status="InActive";		}		$condition=array('advertisment_id'=>'1');		$Image_name = $_FILES['image']['name'];			if ($Image_name != '') {				$config['overwrite'] = FALSE;				$config['allowed_types'] = 'jpg|jpeg|gif|png';				$config['max_size'] = 2000;				$config ['max_width'] = '400';				$config ['max_height'] = '200';				$config['upload_path'] = './images/advertisment';				$this->load->library('upload', $config);				if ($this->upload->do_upload('image')) {					$imgDetails = $this->upload->data();					$inputArr1['image'] = $imgDetails['file_name'];				} else {					$this->setErrorMessage('error', 'File Should be JPEG,JPG,PNG and Exact 400*200(W*H) px');					redirect('admin/Adminlogin/update_advertisement/');				}			}else{								$getAd=$this->admin_model->get_all_details(ADVERTISMENT,$condition);				$image=$getAd->row()->image;				$inputArr1['image']=$image;							}			$inputArr=array('title'=>$tit,							'description'=>$desc,							'link'=>$link,							'status'=>$status							);			$updateArr=array_merge($inputArr1,$inputArr);					  $this->admin_model->update_details(ADVERTISMENT, $updateArr, $condition);			  $this->setErrorMessage('success', 'Advertisement Data Updated Sucessfully');			  redirect('admin/Adminlogin/update_advertisement/');	}	
}
*/
/* End of file adminlogin.php */
/* Location: ./application/controllers/admin/adminlogin.php */
