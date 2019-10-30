<?php
    if (!defined('BASEPATH')) exit ('No direct script access allowed');

    /**
     * URI:               http://www.homestaydnn.com/
     * Description:       Help management controller.
     * Version:           2.0
     * Author:            Sathyaseelan,Vishnu
     **/
    class Help extends MY_Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->load->helper(array('cookie', 'date', 'form', 'email'));
            $this->load->library(array('encrypt', 'form_validation'));
            $this->load->model('help_model');
            $this->data ['loginCheck'] = $this->checkLogin('U');
        }

        public function index()
        {
			if($this->lang->line('How can we help?') != ''){ $help1 = stripslashes($this->lang->line('How can we help?'));} else $help1 = "How can we help?"; 
            $this->data['help1']=$help1;
			 if ($this->uri->segment(2) == 'guest' && $this->uri->segment(3) == '') {
				  
                  //echo 'hi 1';exit;
				 $type = 'User';
				 $mainMenu = $this->help_model->get_all_menu_type($type);
				// echo $this->db->last_query(); die;
				 $subMenu = '';
				
				 foreach($mainMenu->result() as $m) {	 
					$getid[] =  $m->id; 
				  } 
				 $this->data['questions'] = $this->help_model->get_all_question($getid, $subMenu);
				 //echo $this->db->last_query(); die;
			 }
			 
			 if ($this->uri->segment(2) == 'host' && $this->uri->segment(3) == '') {
               // echo 'hi 2';exit;
				 $type = 'Host';
				 $mainMenu = $this->help_model->get_all_menu_type($type);
				 $subMenu = '';
				 
				  foreach($mainMenu->result() as $m) {	 
					$getid[] =  $m->id; 
				  }
				  
				 $this->data['questions'] = $this->help_model->get_all_question($getid, $subMenu);
				 
			 }
			
            if ($this->uri->segment(2) == 'guest') {
                $this->data['type'] = "guest";
                $where = '';
				
				
               // $this->data['mainmenu'] = $this->help_model->get_all_menu_type($this->uri->segment(2));
                $this->data['mainmenu'] = $this->help_model->get_all_menu_type("User");
				
				
                if ($this->uri->segment(3) != '') {
                    $this->data['mainSeo'] = $this->uri->segment(3);
                    $mainMenu = $this->help_model->get_all_details(HELP_MAIN, array('seo' => $this->uri->segment(3)));
					
                    $this->data['submenu'] = $this->help_model->get_all_sub_menu($mainMenu->row()->id);
                }
                if ($this->uri->segment(4) != '') {
                    $this->data['mainSeo'] = $this->uri->segment(3);
                    $mainMenu = $this->help_model->get_all_details(HELP_MAIN, array('seo' => $this->uri->segment(3)));
                    $this->data['subSeo'] = $this->uri->segment(4);
                    $subMenu = $this->help_model->get_all_details(HELP_SUB, array('seo' => $this->uri->segment(4)));
                    $this->data['questions'] = $this->help_model->get_all_question($mainMenu->row()->id, $subMenu->row()->id);
                    //echo $this->db->last_query(); die;
                    $this->data['qusSeo'] = $this->uri->segment(5);
                }
				
                $this->load->view('site/cms/help-menu', $this->data);
            } else if ($this->uri->segment(2) == 'host') {

                $this->data['type'] = "host";
                $where = '';
                $this->data['mainmenu'] = $this->help_model->get_all_menu_type($this->uri->segment(2));
                if ($this->uri->segment(3) != '') {
                    $this->data['mainSeo'] = $this->uri->segment(3);
                    $mainMenu = $this->help_model->get_all_details(HELP_MAIN, array('seo' => $this->uri->segment(3)));
                    $this->data['submenu'] = $this->help_model->get_all_sub_menu($mainMenu->row()->id);
                }
                if ($this->uri->segment(4) != '') {
                    $this->data['mainSeo'] = $this->uri->segment(3);
                    $mainMenu = $this->help_model->get_all_details(HELP_MAIN, array('seo' => $this->uri->segment(3)));
                    $this->data['subSeo'] = $this->uri->segment(4);
                    $subMenu = $this->help_model->get_all_details(HELP_SUB, array('seo' => $this->uri->segment(4)));
                    $this->data['questions'] = $this->help_model->get_all_question($mainMenu->row()->id, $subMenu->row()->id);
                }
                if ($this->uri->segment(5) != '') {
                    $this->data['mainSeo'] = $this->uri->segment(3);
                    $mainMenu = $this->help_model->get_all_details(HELP_MAIN, array('seo' => $this->uri->segment(3)));
                    $this->data['subSeo'] = $this->uri->segment(4);
                    $subMenu = $this->help_model->get_all_details(HELP_SUB, array('seo' => $this->uri->segment(4)));
                    $this->data['questions'] = $this->help_model->get_all_question($mainMenu->row()->id, $subMenu->row()->id);
                    $this->data['qusSeo'] = $this->uri->segment(5);
                }
                $this->load->view('site/cms/help-menu', $this->data);
            } else if ($this->uri->segment(2) == '') {
                if ($this->session->userdata('language_code') == '') {
                    $condition = array('feature' => 'yes', 'lang' => 'dan');
                } else {
                    $condition = array('feature' => 'yes', 'lang' => $this->session->userdata('language_code'));
                }
                $this->data['help_list'] = $this->help_model->get_all_details(HELP_QUESTION, $condition);

                $this->load->view('site/cms/help', $this->data);
            }

        }

        function ajaxquestionanswer()
        {
            if ($this->input->post('search_keyword') != '') {
                $data['values'] = $this->help_model->getquestionanswersearch();
                $this->load->view('site/cms/helpquestion', $data);
            }
        }

        public function set_main_seo()
        {
            $check = $this->help_model->get_all_details(HELP_MAIN, array());
            foreach ($check->result() as $res) {
                $seo = strtolower($res->name);
                $seo = mysql_real_escape_string($seo);
                $seo = trim($seo);
                $seo = str_replace("'", "", $seo);
                $seo = str_replace("&", "", $seo);
                $seo = str_replace("'", "", $seo);
                $seo = @ereg_replace("[^A-Za-z0-9]", " ", $seo);
                $seo = preg_replace("/\s+/", " ", $seo);
                $seo = str_replace(" ", "-", $seo);
                $this->help_model->update_details(HELP_MAIN, array('seo' => $seo), array('id' => $res->id));
            }
        }

        public function set_sub_seo()
        {
            $check = $this->help_model->get_all_details(HELP_SUB, array());
            foreach ($check->result() as $res) {
                $seo = strtolower($res->name);
                $seo = mysql_real_escape_string($seo);
                $seo = trim($seo);
                $seo = str_replace("'", "", $seo);
                $seo = str_replace("&", "", $seo);
                $seo = str_replace("'", "", $seo);
                $seo = @ereg_replace("[^A-Za-z0-9]", " ", $seo);
                $seo = preg_replace("/\s+/", " ", $seo);
                $seo = str_replace(" ", "-", $seo);
                $this->help_model->update_details(HELP_SUB, array('seo' => $seo), array('id' => $res->id));
            }
        }

        public function set_qus_seo()
        {
            $check = $this->help_model->get_all_details(HELP_QUESTION, array());
            foreach ($check->result() as $res) {
                $seo = strtolower($res->question);
                $seo = mysql_real_escape_string($seo);
                $seo = trim($seo);
                $seo = str_replace("'", "", $seo);
                $seo = str_replace("&", "", $seo);
                $seo = str_replace("'", "", $seo);
                $seo = @ereg_replace("[^A-Za-z0-9]", " ", $seo);
                $seo = preg_replace("/\s+/", " ", $seo);
                $seo = str_replace(" ", "-", $seo);
                $this->help_model->update_details(HELP_QUESTION, array('seo' => $seo), array('id' => $res->id));
            }
        }

        /* Controller End */
    }
