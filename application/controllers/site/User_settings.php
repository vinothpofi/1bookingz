<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Landing page full control.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class User_settings extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper(array('cookie', 'date', 'form', 'email'));
            $this->load->library(array('encrypt', 'form_validation', 'pagination'));
            $this->load->model('user_model');
            $this->load->model('review_model');
            $this->load->model('cms_model');
            $this->load->model('experience_model');
            if ($_SESSION['sMainCategories'] == '') {
                $sortArr1 = array('field' => 'cat_position', 'type' => 'asc');
                $sortArr = array($sortArr1);
                $_SESSION['sMainCategories'] = $this->user_model->get_all_details(CATEGORY, array('rootID' => '0', 'status' => 'Active'), $sortArr);
            }
            $this->data['mainCategories'] = $_SESSION['sMainCategories'];
            if ($_SESSION['sColorLists'] == '') {
                $_SESSION['sColorLists'] = $this->user_model->get_all_details(LIST_VALUES, array('list_id' => '1'));
            }
            $this->data['mainColorLists'] = $_SESSION['sColorLists'];
            $this->data['loginCheck'] = $this->checkLogin('U');
        }

        public function index()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url());
            } else {
                $this->data['heading'] = 'Dashboard';
                $user_id_verified_query = 'SELECT * FROM ' . REQUIREMENTS . ' WHERE user_id=' . $this->checkLogin('U');
                $condition = array('receiver_id' => $this->checkLogin('U'), 'msg_read' => 'no');
                $this->data['dashboardinbox'] = $this->user_model->get_all_details(DISCUSSION, $condition);
                $this->data['user_verified_status'] = $this->user_model->ExecuteQuery($user_id_verified_query);
                $searchPerPage = $this->config->item('site_pagination_per_page');
                $paginationNo = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
                $pageLimitStart = $paginationNo;
                $get_ordered_list_count = $this->user_model->coupon_data_site_map();
                $this->config->item('site_pagination_per_page');
                $config ['prev_link'] = '<';
                $config ['next_link'] = '>';
				$config ["cur_tag_open"] = '<a class="active">';
				$config ["cur_tag_close"] = '</a>';
                $config ['attributes'] = array('class' => 'pages');
                $config ['num_links'] = 2;
                $config ['base_url'] = base_url() . 'dashboard/';
                $config ['total_rows'] = ($get_ordered_list_count->num_rows());
                $config ["per_page"] = $searchPerPage;
                $config ["uri_segment"] = 2;
                $this->pagination->initialize($config);
                $this->data ['paginationLink'] = $data ['paginationLink'] = $this->pagination->create_links();
                $this->data ['get_ordered_list_count'] = $get_ordered_list_count->num_rows();
                $this->data['couponData'] = $this->user_model->coupon_data($pageLimitStart, $searchPerPage);
                $this->load->view('site/user/dashboard', $this->data);
            }
        }

        /*Show Edit profile Form to user to edit their information*/
        public function display_user_settings()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url());
            } else {
               
                $this->data['heading'] = 'Settings';
                $country_query = 'SELECT id,name FROM ' . LOCATIONS . ' WHERE status="Active" order by name';
                $this->data['active_countries'] = $this->user_model->ExecuteQuery($country_query);
                $user_verified_query = 'SELECT * FROM ' . REQUIREMENTS . ' WHERE user_id=' . $this->checkLogin('U');
                $this->data['user_verified_status'] = $this->user_model->ExecuteQuery($user_verified_query);
                $languages_known_query = 'SELECT * FROM ' . LANGUAGES_KNOWN;
                $this->data['languages_known'] = $this->user_model->ExecuteQuery($languages_known_query);
                $this->load->view('site/user/settings', $this->data);
            }
        }

        public function user_edit($id)
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url());
            } else {
                $condition = array('id' => $id);
                $this->data['UserDetail'] = $this->user_model->get_all_details(USERS, $condition);
                $this->data['heading'] = 'Profile';
                $this->load->view('site/user/profile', $this->data);
            }
        }

        public function delete_inquiry_details()
        {
            $id = $this->uri->segment(4);
            if ($this->lang->line('Message deleted successfully!') != '') {
                $delete_mesage = stripslashes($this->lang->line('Message deleted successfully!'));
            } else {
                $delete_mesage = "Message deleted successfully!";
            }
            $this->setErrorMessage('success', $delete_mesage);
            $this->db->where('id', $id)->delete(DISCUSSION);
            redirect('inbox');
        }

        public function delete_conversation_details()
        {
            $id = $this->uri->segment(4);
            $this->db->where('convId', $id)->delete(DISCUSSION);
            if ($this->lang->line('Message deleted successfully!') != '') {
                $delete_mesage = stripslashes($this->lang->line('Message deleted successfully!'));
            } else {
                $delete_mesage = "Message deleted successfully!";
            }
            $this->setErrorMessage('success', $delete_mesage);
            redirect('inbox');
        }

        public function view_inquiry_details()
        {
            //view_product_details1
            $id = $this->uri->segment(4);
            $pageDetails = $this->product_model->get_all_details(DISCUSSION, array('id' => $id));
            //echo $pageDetails->row()->rental_id;die;
            $productDetails = $this->product_model->view_product_details1("where p.id=" . $pageDetails->row()->rental_id);
            //$productDetails=$this->product_model->get_all_details(PRODUCT,array('id'=>$pageDetails->row()->rental_id));
            $hostDetails = $this->product_model->get_all_details(USERS, array('id' => $productDetails->row()->user_id));
            $senderDetails = $this->product_model->get_all_details(USERS, array('id' => $pageDetails->row()->sender_id));
            $receiverDetails = $this->product_model->get_all_details(USERS, array('id' => $pageDetails->row()->receiver_id));
            if ($pageDetails->num_rows() == 0) {
                show_404();
            } else {
                $this->data['heading'] = 'View Inquiry Details';
                $this->data['pageDetails'] = $pageDetails;
                $this->data['productDetails'] = $productDetails;
                $this->data['hostDetails'] = $hostDetails;
                $this->data['senderDetails'] = $senderDetails;
                $this->data['receiverDetails'] = $receiverDetails;
                $this->data['UserId'] = $this->checkLogin('U');
                $this->load->view('site/cms/display_inquiry', $this->data);
            }
        }

        public function view_conversation_details()
        {
            //view_product_details1
            //echo $this->checkLogin('U');die;
            $id = $this->uri->segment(4);
            $pageDetails = $this->product_model->get_all_details(DISCUSSION, array('convId' => $id));
            //echo $pageDetails->row()->rental_id;die;
            $productDetails = $this->product_model->view_product_details1("where p.id=" . $pageDetails->row()->rental_id);
            //$productDetails=$this->product_model->get_all_details(PRODUCT,array('id'=>$pageDetails->row()->rental_id));
            $hostDetails = $this->product_model->get_all_details(USERS, array('id' => $productDetails->row()->user_id));
            $senderDetails = $this->product_model->get_all_details(USERS, array('id' => $pageDetails->row()->sender_id));
            $receiverDetails = $this->product_model->get_all_details(USERS, array('id' => $pageDetails->row()->receiver_id));
            if ($pageDetails->num_rows() == 0) {
                show_404();
            } else {
                $this->data['heading'] = 'View Conversation Details';
                $this->data['pageDetails'] = $pageDetails;
                $this->data['productDetails'] = $productDetails;
                $this->data['hostDetails'] = $hostDetails;
                $this->data['senderDetails'] = $senderDetails;
                $this->data['receiverDetails'] = $receiverDetails;
                $this->data['UserId'] = $this->checkLogin('U');
                $this->load->view('site/cms/display_conversation', $this->data);
            }
        }

        /*Update user's Profile information to the atabase*/
        public function update_profile()
        {
            $inputArr = array();
            $response['success'] = '0';
            if ($this->checkLogin('U') == '') {
                $response['msg'] = 'You must login';
            } else {
                $update = '0';
                $email = $this->input->post('email');
                if ($email != '') {
                    if (valid_email($email)) {
                        $condition = array('email' => $email, 'id !=' => $this->checkLogin('U'));
                        $duplicateMail = $this->user_model->get_all_details(USERS, $condition);
                        if ($duplicateMail->num_rows() > 0) {
                            $response['msg'] = 'Email already exists';
                        } else {
                            $inputArr['email'] = $email;
                            $update = '1';
                        }
                    } else {
                        $response['msg'] = 'Invalid email';
                    }
                } else {
                    $update = '1';
                }
                if ($update == '1') {
                    $birthday = $this->input->post('dob_year') . '-' . $this->input->post('dob_month') . '-' . $this->input->post('dob_date');
                    $updateArr = array(
                        'email' => $email,
                        'firstname' => $this->input->post('firstname'),
                        'lastname' => $this->input->post('lastname'),
                        'gender' => $this->input->post('gender'),
                        'dob_month' => $this->input->post('dob_month'),
                        'dob_date' => $this->input->post('dob_date'),
                        'dob_year' => $this->input->post('dob_year'),
                        'paypal_email' => $this->input->post('paypal_email'),
                        's_city' => $this->input->post('s_city'),
                        'description' => $this->input->post('description'),
                        'school' => $this->input->post('school'),
                        'work' => $this->input->post('work'),
                        'birthday' => $birthday,
                        'timezone' => $this->input->post('timezone')
                        );
//                    print_r($updateArr);
                    $condition = array('id' => $this->checkLogin('U'));
                    $this->db->set($updateArr)->where($condition)->update(USERS);
                }
            }
            if ($this->lang->line('User_Updated_successfully') != '') {
                    $message = stripslashes($this->lang->line('User_Updated_successfully'));
                } else {
                    $message = "User Profile Information Updated successfully";
                }
                $this->setErrorMessage('success', $message);
            redirect(base_url('settings'));
        }

        /*Update Profile Information to database*/
        public function changePhoto()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $config['overwrite'] = FALSE;
                $config['remove_spaces'] = TRUE;
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size'] = 2000;
                $config['max_width'] = '1600';
                $config['max_height'] = '1600';
                $config['upload_path'] = './images/users';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('upload-file')) {
                    $imgDetailsd = $this->upload->data();
                    //$dataArr['image'] = $imgDetails['file_name'];
                    $imgDetails = array('image' => $imgDetailsd['file_name']);
                } else {
                    $imgDetails = array();
                }    //$dataArr['image'] = $imgDetails['file_name'];
                $dataArr = array('firstname'              => $this->input->post('firstname'), 'gender' => $this->input->post('gender'), 'lastname' => $this->input->post('lastname'), 'email' => $this->input->post('email'), 'paypal_email' => $this->input->post('paypal_email'), //'phone_no'=>$this->input->post('phone_no'),
                    //'ph_country'=>$this->input->post('phone_country'),
                                 'description'            => $this->input->post('description'), 'dob_month' => $this->input->post('dob_month'), 'dob_date' => $this->input->post('dob_date'), 'dob_year' => $this->input->post('dob_year'), 'school' => $this->input->post('school'), 'work' => $this->input->post('work'), 'timezone' => $this->input->post('timezone'), 'emergency_name' => $this->input->post('emergency_name'), 'emergency_phone' => $this->input->post('emergency_phone'), 'emergency_email' => $this->input->post('emergency_email'), 's_city' => $this->input->post('s_city'), //'rep_code'=>$this->input->post('rep_code'),
                                 'emergency_relationship' => $this->input->post('emergency_relationship'));
                //print_r($dataArr);die;
                $condition = array('id' => $this->checkLogin('U'));
                $dataArrMrg = array_merge($dataArr, $imgDetails);
                $this->user_model->update_details(USERS, $dataArrMrg, $condition);
                //echo $this->db->last_query();die;
                //die;
                //print_r($_SESSION);exit;
                //print_r($this->session->userdata('lang_code'));exit;
                if ($this->lang->line('User Profile Information Updated successfully') != '') {
                    $message = stripslashes($this->lang->line('User Profile Information Updated successfully'));
                } else {
                    $message = "User Profile Information Updated successfully";
                }
                $this->setErrorMessage('success', $message);
                redirect(base_url() . 'settings');
            }
        }

        /* malar - clear old phone number details to enter new one by user confirmation  */
        public function allow_changePhone()
        {
            $condition = array('id' => $this->checkLogin('U'));
            $dataArr = array('ph_verified' => 'No', 'phone_no' => '');
            $this->user_model->update_details(USERS, $dataArr, $condition);
            echo 'success';
        }

        /* malar - clear old phone number details to enter new one by user confirmation ends  */
        public function delete_user_photo()
        {
            $response['success'] = '0';
            if ($this->checkLogin('U') == '') {
                $response['msg'] = 'You must login';
            } else {
                $condition = array('id' => $this->checkLogin('U'));
                $dataArr = array('image' => '');
                $this->user_model->update_details(USERS, $dataArr, $condition);
                if ($this->lang->line('Profile photo deleted successfully') != '') {
                    $message = stripslashes($this->lang->line('Profile photo deleted successfully'));
                } else {
                    $message = "Profile photo deleted successfully";
                }
                $this->setErrorMessage('success', $message);
                $response['success'] = '1';
            }
            echo json_encode($response);
        }

        public function delete_user_account()
        {
            if ($this->checkLogin('U') != '') {
                $datestring = "%Y-%m-%d %h:%i:%s";
                $time = time();
                $newdata = array('last_logout_date' => mdate($datestring, $time), 'status' => 'Inactive');
                $condition = array('id' => $this->checkLogin('U'));
                $this->user_model->update_details(USERS, $newdata, $condition);
                $userdata = array('fc_session_user_id' => '', 'session_user_name' => '', 'session_user_email' => '', 'fc_session_temp_id' => '');
                $this->session->set_userdata($userdata);
                if ($this->lang->line('Your account inactivated successfully') != '') {
                    $message = stripslashes($this->lang->line('Your account inactivated successfully'));
                } else {
                    $message = "Your account inactivated successfully";
                }
                $this->setErrorMessage('success', $message);
            }
        }

        public function password_settings()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Password Settings';
                $this->load->view('site/user/changepassword', $this->data);
            }
        }

        public function change_user_password()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $pwd = $this->input->post('pass');
                $cfmpwd = $this->input->post('confirmpass');
                if ($pwd != '' && $cfmpwd != '' && strlen($pwd) > 5) {
                    if ($pwd == $cfmpwd) {
                        $dataArr = array('password' => md5($pwd));
                        $condition = array('id' => $this->checkLogin('U'));
                        $this->user_model->update_details(USERS, $dataArr, $condition);
                        if ($this->lang->line('Password changed successfully') != '') {
                            $message = stripslashes($this->lang->line('Password changed successfully'));
                        } else {
                            $message = "Password changed successfully";
                        }
                        $this->setErrorMessage('success', $message);
                    } else {
                        if ($this->lang->line('Passwords does not match') != '') {
                            $message = stripslashes($this->lang->line('Passwords does not match'));
                        } else {
                            $message = "Passwords does not match";
                        }
                        $this->setErrorMessage('error', $message);
                    }
                } else {
                    if ($this->lang->line('Password and Confirm password fields required') != '') {
                        $message = stripslashes($this->lang->line('Password and Confirm password fields required'));
                    } else {
                        $message = "Password and Confirm password fields required";
                    }
                    $this->setErrorMessage('error', $message);
                }
                redirect(base_url() . 'settings/password');
            }
        }

        public function preferences_settings()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Preference Settings';
                $this->data['languages'] = $this->user_model->get_all_details(LANGUAGES, array());
                $this->load->view('site/user/change_preferences', $this->data);
            }
        }

        public function update_preferences()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->user_model->commonInsertUpdate(USERS, 'update', array(), array(), array('id' => $this->checkLogin('U')));
                if ($this->lang->line('Preferences saved successfully') != '') {
                    $message = stripslashes($this->lang->line('Preferences saved successfully'));
                } else {
                    $message = "Preferences saved successfully";
                }
                $this->setErrorMessage('success', '$message');
                redirect(base_url() . 'settings/preferences');
            }
        }

        public function notifications_settings()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Notifications Settings';
                $this->data['languages'] = $this->user_model->get_all_details(LANGUAGES, array());
                $this->load->view('site/user/change_notifications', $this->data);
            }
        }

        public function update_notifications()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $emailArr = $this->data['emailArr'];
                $notyArr = $this->data['notyArr'];
                $emailStr = '';
                $notyStr = '';
                foreach ($this->input->post() as $key => $val) {
                    if (in_array($key, $emailArr)) {
                        $emailStr .= $key . ',';
                    } else if (in_array($key, $notyArr)) {
                        $notyStr .= $key . ',';
                    }
                }
                $updates = $this->input->post('updates');
                $updates = ($updates == '') ? '0' : '1';
                $emailStr = substr($emailStr, 0, strlen($emailStr) - 1);
                $notyStr = substr($notyStr, 0, strlen($notyStr) - 1);
                $dataArr = array('email_notifications' => $emailStr, 'notifications' => $notyStr, 'updates' => $updates);
                $condition = array('id' => $this->checkLogin('U'));
                $this->user_model->update_details(USERS, $dataArr, $condition);
                if ($this->lang->line('Notifications settings saved successfully') != '') {
                    $message = stripslashes($this->lang->line('Notifications settings saved successfully'));
                } else {
                    $message = "Notifications settings saved successfully";
                }
                $this->setErrorMessage('success', $message);
                redirect(base_url() . 'settings/notifications');
            }
        }

        public function user_purchases()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Purchases';
                $this->data['purchasesList'] = $this->user_model->get_purchase_details($this->checkLogin('U'));
                $this->load->view('site/user/user_purchases', $this->data);
            }
        }

        public function user_orders()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Orders';
                $this->data['ordersList'] = $this->user_model->get_user_orders_list($this->checkLogin('U'));
                $this->load->view('site/user/user_orders_list', $this->data);
            }
        }

        public function manage_fancyybox()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Subscriptions';
                $this->data['subscribeList'] = $this->user_model->get_subscriptions_list($this->checkLogin('U'));
                $this->load->view('site/user/manage_fancyybox', $this->data);
            }
        }

        public function shipping_settings()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Shipping Address';
                $this->data['countryList'] = $this->user_model->get_all_details(COUNTRY_LIST, array());
                $this->data['shippingList'] = $this->user_model->get_all_details(SHIPPING_ADDRESS, array('user_id' => $this->checkLogin('U')));
                $this->load->view('site/user/shipping_settings', $this->data);
            }
        }

        public function insertEdit_shipping_address()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $shipID = $this->input->post('ship_id');
                $is_default = $this->input->post('set_default');
                if ($is_default == '') {
                    $primary = 'No';
                } else {
                    $primary = 'Yes';
                }
                $checkAddrCount = $this->user_model->get_all_details(SHIPPING_ADDRESS, array('user_id' => $this->checkLogin('U')));
                if ($checkAddrCount->num_rows == 0) {
                    $primary = 'Yes';
                }
                $excludeArr = array('ship_id', 'set_default');
                $dataArr = array('primary' => $primary);
                $condition = array('id' => $shipID);
                if ($shipID == '') {
                    $this->user_model->commonInsertUpdate(SHIPPING_ADDRESS, 'insert', $excludeArr, $dataArr, $condition);
                    $shipID = $this->user_model->get_last_insert_id();
                    if ($this->lang->line('Your Shipping address is added successfully !') != '') {
                        $message = stripslashes($this->lang->line('Your Shipping address is added successfully !'));
                    } else {
                        $message = "Your Shipping address is added successfully !";
                    }
                    $this->setErrorMessage('success', $message);
                } else {
                    $this->user_model->commonInsertUpdate(SHIPPING_ADDRESS, 'update', $excludeArr, $dataArr, $condition);
                    if ($this->lang->line('Shipping address updated successfully') != '') {
                        $message = stripslashes($this->lang->line('Shipping address updated successfully'));
                    } else {
                        $message = "Shipping address updated successfully";
                    }
                    $this->setErrorMessage('success', $message);
                }
                if ($primary == 'Yes') {
                    $condition = array('id !=' => $shipID, 'user_id' => $this->checkLogin('U'));
                    $dataArr = array('primary' => 'No');
                    $this->user_model->update_details(SHIPPING_ADDRESS, $dataArr, $condition);
                } else {
                    $condition = array('primary' => 'Yes', 'user_id' => $this->checkLogin('U'));
                    $checkPrimary = $this->user_model->get_all_details(SHIPPING_ADDRESS, $condition);
                    if ($checkPrimary->num_rows() == 0) {
                        $condition = array('id' => $shipID, 'user_id' => $this->checkLogin('U'));
                        $dataArr = array('primary' => 'Yes');
                        $this->user_model->update_details(SHIPPING_ADDRESS, $dataArr, $condition);
                    }
                }
                redirect(base_url() . 'settings/shipping');
            }
        }

        public function get_shipping()
        {
            $shipID = $this->input->post('shipID');
            $shipDetails = $this->user_model->get_all_details(SHIPPING_ADDRESS, array('id' => $shipID));
            $returnStr['full_name'] = $shipDetails->row()->full_name;
            $returnStr['nick_name'] = $shipDetails->row()->nick_name;
            $returnStr['address1'] = $shipDetails->row()->address1;
            $returnStr['address2'] = $shipDetails->row()->address2;
            $returnStr['city'] = $shipDetails->row()->city;
            $returnStr['state'] = $shipDetails->row()->state;
            $returnStr['country'] = $shipDetails->row()->country;
            $returnStr['postal_code'] = $shipDetails->row()->postal_code;
            $returnStr['phone'] = $shipDetails->row()->phone;
            $returnStr['primary'] = $shipDetails->row()->primary;
            echo json_encode($returnStr);
        }

        public function remove_shipping_addr()
        {
            $returnStr['status_code'] = 0;
            if ($this->checkLogin('U') == '') {
                $returnStr['message'] = 'You must login';
            } else {
                $shipID = $this->input->post('id');
                $this->user_model->commonDelete(SHIPPING_ADDRESS, array('id' => $shipID));
                $returnStr['status_code'] = 1;
            }
            echo json_encode($returnStr);
        }

        public function user_credits()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'My Earnings';
                $orderDetails = $this->data['orderDetails'] = $this->commission->get_total_order_amount($this->checkLogin('U'));
                $commission_to_admin = 0;
                $amount_to_vendor = 0;
                $total_amount = 0;
                $this->data['total_amount'] = $total_amount;
                $total_orders = 0;
                $this->data['except_refunded'] = 0;
                if ($orderDetails->num_rows() == 1) {
                    $commission_percentage = $this->data['userDetails']->row()->commision;
                    $total_amount = $orderDetails->row()->TotalAmt;
                    $this->data['total_amount'] = $total_amount;
                    $total_amount = $total_amount - $this->data['userDetails']->row()->refund_amount;
                    $this->data['except_refunded'] = $total_amount;
                    $commission_to_admin = $total_amount * ($commission_percentage * 0.01);
                    if ($commission_to_admin < 0) $commission_to_admin = 0;
                    $amount_to_vendor = $total_amount - $commission_to_admin;
                    if ($amount_to_vendor < 0) $amount_to_vendor = 0;
                    $total_orders = $orderDetails->row()->orders;
                }
                $paidDetails = $this->commission->get_total_paid_details($this->checkLogin('U'));
                $paid_to = 0;
                if ($paidDetails->num_rows() == 1) {
                    $paid_to = $paidDetails->row()->totalPaid;
                    if ($paid_to < 0) $paid_to = 0;
                }
                $paid_to_balance = $amount_to_vendor - $paid_to;
                if ($paid_to_balance < 0) $paid_to_balance = 0;
                $this->data['commission_to_admin'] = $commission_to_admin;
                $this->data['amount_to_vendor'] = $amount_to_vendor;
                $this->data['total_orders'] = $total_orders;
                $this->data['paid_to'] = $paid_to;
                $this->data['paid_to_balance'] = $paid_to_balance;
                $sortArr1 = array('field' => 'date', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $this->data['paidDetailsList'] = $this->commission->get_all_details(VENDOR_PAYMENT, array('vendor_id' => $this->checkLogin('U'), 'status' => 'success'), $sortArr);
                $this->load->view('site/user/user_credits', $this->data);
            }
        }

        public function user_referrals()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                //echo "hi";die;
                $paginationNo = $this->uri->segment('2');
                if ($paginationNo == '') {
                    $paginationNo = 0;
                } else {
                    $paginationNo = $paginationNo;
                }
                $searchPerPage = $this->config->item('pagination_per_page');
                //echo "DSf".$this->uri->segment('2');die;
                $referalBaseUrl = base_url() . 'referrals';
                $getReferalListCount = $this->user_model->getReferalList();
                $getReferalList = $this->user_model->getReferalList($searchPerPage, $paginationNo);
                $config['base_url'] = $referalBaseUrl;
                $config['total_rows'] = count($getReferalListCount);
                $config["per_page"] = $searchPerPage;
                $config["uri_segment"] = 2;
                $this->pagination->initialize($config);
                $paginationLink = $this->pagination->create_links();//die;
                $this->data['heading'] = 'Referrals';
                $this->data['getReferalList'] = $getReferalList;
                $this->data['paginationLink'] = $paginationLink;
                //	echo "<pre>";print_r($getReferalList);die;
                //	    	$this->data['purchasesList'] = $this->user_model->get_group_gifts_list($this->checkLogin('U'));
                $this->load->view('site/user/user_referrals', $this->data);
            }
        }

        public function user_giftcards()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $this->data['heading'] = 'Gift Cards';
                $this->data['giftcardsList'] = $this->user_model->get_gift_cards_list($this->data['userDetails']->row()->email);
                $this->load->view('site/user/user_giftcards', $this->data);
            }
        }

        public function user_profile()
        {
            $userid = $this->uri->segment(3);
           $this->data['guest'] = $this->checkLogin('U');
            $condition = array('id' => $userid);
            $this->data['user_Details'] = $this->user_model->get_all_details(USERS, $condition);
            $this->data['phone_number_verified'] = $this->review_model->get_phone_number_verified($userid);
            $this->data['ReviewDetails'] = $this->review_model->get_productreview_aboutyou1($userid);
            $this->data['rental_counts'] = $this->user_model->get_all_details(PRODUCT, array('user_id' => $userid));
           // echo $this->data['rental_counts']->num_rows();exit;
            $this->data ['rentalDetail'] = $this->cms_model->get_dashboard_list($userid, Publish);

            if ($this->data['experienceExistCount'] > 0) {
                $this->data['exp_counts'] = $this->user_model->get_all_details(EXPERIENCE, array('user_id' => $userid));
                $this->data ['expDetail'] = $this->experience_model->get_experiences_list($userid);
                $this->data ['Exp_ReviewDetails'] = $this->experience_model->get_experiences_review_aboutyou1($userid);
            }
            $this->data['languages'] = $this->cms_model->get_all_details(LANGUAGES_KNOWN, array());
            $this->data['verifyid'] = $this->cms_model->get_all_details(USERS, array('id' => $userid));
            $this->data['WishListCat'] = $this->product_model->get_list_details_wishlist($userid);
            $this->data ['properties_list_details'] = $properties_list_details = $this->product_model->get_list_details_wishlist($userid);
            foreach ($properties_list_details->result() as $list) {
                $prd_id[] = $list->product_id;
            }
            $prd_String = implode(",", $prd_id);
            $searchArr1 = array_filter(explode(',', $prd_String));
            $searchArr = array_unique($searchArr1);
            if (count($searchArr) > 0) {
                foreach ($searchArr as $searchphotoid) {
                    $wishlist_image[$searchphotoid] = $this->product_model->get_product_wishlistImage($searchphotoid);
                }
                $this->data['properties_wishlist_image'] = $wishlist_image;
                $this->data ['Properties_WishList'] = $this->product_model->get_products_wishlist($searchArr);
            } else {
                $this->data ['Properties_WishList'] = $this->product_model->get_products_wishlist('0');
            }
            $this->data ['experiences_list_details'] = $experiences_list_details = $this->product_model->get_list_details_wishlist($userid);
            foreach ($experiences_list_details->result() as $list) {
                $exp_id[] = $list->experience_id;
            }
            $exp_String = implode(",", $exp_id);
            $searchArr1 = array_filter(explode(',', $exp_String));
            $searchArr = array_unique($searchArr1);
            $this->data ['Experiences_WishList'] =0;
             $this->data['experiences_wishlist_image'] = 0;
            if ($this->data['experienceExistCount'] > 0) {
            if (count($searchArr) > 0) {
                foreach ($searchArr as $searchphotoid) {
                    $wishlist_image[$searchphotoid] = $this->product_model->get_experiences_wishlistImage($searchphotoid);
                }
                $this->data['experiences_wishlist_image'] = $wishlist_image;
                $this->data ['Experiences_WishList'] = $this->product_model->get_experiences_wishlist($searchArr);
            } else {
                $this->data ['Experiences_WishList'] = $this->product_model->get_experiences_wishlist('0');
            }
            }
            $this->load->view('site/user/display_user_profile', $this->data);
        }

        public function change_photo()
        {
            if ($this->checkLogin('U') == '') {
                redirect(base_url() . 'login');
            } else {
                $config['overwrite'] = FALSE;
                $config['remove_spaces'] = TRUE;
                $config['allowed_types'] = 'jpg|jpeg|gif|png';
                $config['max_size'] = 2000;
                $config['max_width'] = '600';
                $config['max_height'] = '600';
                $config['upload_path'] = './images/users';
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('upload-file')) {
                    $imgDetails = $this->upload->data();
                    $dataArr['image'] = $imgDetails['file_name'];
                    $condition = array('id' => $this->checkLogin('U'));
                    $this->user_model->update_details(USERS, $dataArr, $condition);
                    redirect('image-crop/' . $this->checkLogin('U'));
                } else {
                    $this->setErrorMessage('error', strip_tags($this->upload->display_errors()));
                }
                echo "<script>window.history.go(-1);</script>";
            }
        }

        /*Update known languages to Database*/
        public function update_languages()
        {
            $inputArr['languages_known'] = implode(',', $this->input->post('languages_known'));
            $condition = array('id' => $this->checkLogin('U'));
            $this->db->set($inputArr)->where($condition)->update(USERS);
            $this->db->select('*');
            $this->db->from(LANGUAGES_KNOWN);
            $this->db->where_in('language_code', $this->input->post('languages_known'));
            $languages = $this->db->get();
            $returnStr = '';
            foreach ($languages->result() as $lang) {
                $returnStr .= '<li id="' . $lang->language_code . '">' . $lang->language_name . '
                                <span onclick="delete_languages(this,' . $lang->language_code . ')">X</span>
                                </li>';
            }
            echo $returnStr;
        }

        /*Delete known language from the Database*/
        public function delete_languages()
        {
            $languages_known_query = 'SELECT languages_known FROM ' . USERS . ' WHERE id=' . $this->checkLogin('U');
            $languages_known = $this->user_model->ExecuteQuery($languages_known_query);
            $languages = explode(',', $languages_known->row()->languages_known);
            $position = array_search($this->input->post('language_code'), $languages);
            unset($languages[$position]);
            $excludeArr = array('languages', 'language_code');
            $inputArr['languages_known'] = implode(',', $languages);
            $condition = array('id' => $this->checkLogin('U'));
            $this->user_model->commonInsertUpdate(USERS, 'update', $excludeArr, $inputArr, $condition);
            echo json_encode(array('status_code' => 1));
            //print_r($languages);die;
        }

        public function delete_conversation_details_msg($id)
        {
            //echo $id;
            $update1 = array('msg_status' => 1);
            $this->db->set($update1);
            $this->db->where('id', $id);
            $this->db->update(MED_MESSAGE);
            //$this->db->where('id', $id)->update(MED_MESSAGE);
            //$this->db->where('msg_status', 1)->update(MED_MESSAGE);
            if ($this->lang->line('Message deleted successfully!') != '') {
                $message = stripslashes($this->lang->line('Message deleted successfully!'));
            } else {
                $message = "Message deleted successfully!";
            }
            $this->setErrorMessage('success', $message);
            redirect('inbox');
        }

    }

    /* End of file user_settings.php */
    /* Location: ./application/controllers/site/user_settings.php */