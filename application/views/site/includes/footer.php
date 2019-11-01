<script src="//connect.facebook.net/en_US/sdk.js" type="text/javascript"></script>
<script type="text/javascript">
    window.fbAsyncInit = function () {
        FB.init({
            appId: '<?php echo APPKEY; ?>',
            oauth: true,
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true, // parse XFBML
            version: 'v2.8' // use graph api version 2.8
        });

    };

    function fb_login() {
        console.log('fb_login function initiated');
        FB.login(function (response) {

            console.log('login response');
            console.log(response);
            console.log('Response Status' + response.status);
            //top.location.href=http://demo.Sundaroecommerce.com/;
            if (response.authResponse) {

                console.log('Auth success');

                FB.api("/me", 'GET', {'fields': 'id,email,verified,name'}, function (me) {

                    if (me.id) {


                        //console.log( 'Retrived user details from FB.api', me );

                        var id = me.id;
                        var email = me.email;
                        var name = me.name;
                        var live = '';
                        if (me.hometown != null) {
                            var live = me.hometown.name;
                        }

                        var passData = 'fid=' + id + '&email=' + email + '&name=' + name + '&live=' + live;
                        //alert(passData);
                        //console.log('data', passData);

                        $.ajax({
                            type: 'GET',
                            data: passData,
                            //data: $.param(passData),
                            global: false,
                            url: '<?php echo base_url() . 'facebooklogin'; ?>',
                            success: function (responseText) {
                                console.log(responseText);

                                location.reload();
                            },
                            error: function (xhr, status, error) {
                                console.log(status, status.responseText);
                            }
                        });

                    } else {

                        console.log('There was a problem with FB.api', me);

                    }
                });

            } else {
                console.log('Auth Failed');
            }

        }, {scope: 'email'});
    }
</script>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="selectBoxRow clear">
                    <div class="selectBox">
                        <select onChange="changeLanguage(this);">
                            <?php
                            $selectedLangCode = $this->session->userdata('language_code');
                            if ($selectedLangCode == '') {
                                $selectedLangCode = $defaultLg[0]['lang_code'];
                            }
                            if (count($activeLgs) > 0) {
                                foreach ($activeLgs as $activeLgsRow) {
                                    ?>
                                    <option
                                            value="<?php echo base_url(); ?>lang/<?php echo $activeLgsRow['lang_code']; ?>" <?php if ($selectedLangCode == $activeLgsRow['lang_code']) {
                                        echo 'selected="selected"';
                                    } ?>><?php echo ucfirst($activeLgsRow['name']); ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="selectBox">
                        <select onChange="changeCurrency(this);">
                            <?php
                            if ($currency_setup->num_rows() > 0) {
                                foreach ($currency_setup->result() as $currency_s) {
                                    if ($currency_s->currency_type == $this->session->userdata('currency_type')) {
                                        $SelecTed = 'selected="selected"';
                                    } else {
                                        $SelecTed = '';
                                    }
                                    ?>
                                    <option
                                            value="<?php echo base_url(); ?>change-currency/<?php echo $currency_s->id; ?>" <?php echo $SelecTed; ?>><?php echo $currency_s->currency_type; ?></option>
                                <?php }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>


            <?php /*

            <div class="col-sm-3">
                <div class="listMenus">
                    <h5><?php if ($this->lang->line('Service') != '') {
                            echo stripslashes($this->lang->line('Service'));
                        } else echo "Service"; ?></h5>
                    <ul>
                        <li><a href="<?= base_url(); ?>contact-us"> <?php if ($this->lang->line('Contact Us') != '') {
                                    echo stripslashes($this->lang->line('Contact Us'));
                                } else echo "Contact Us"; ?> </a></li>
                        <li><a href="<?= base_url(); ?>help"> <?php if ($this->lang->line('FAQ') != '') {
                                    echo stripslashes($this->lang->line('FAQ'));
                                } else echo "FAQ"; ?> </a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="listMenus">
                    <h5><?php if ($this->lang->line('Company') != '') {
                            echo stripslashes($this->lang->line('Company'));
                        } else echo "Company"; ?></h5>
                    <ul>

                        <?php //print_r($cmsList);
                        // echo $cmsList->num_rows();
                        //  print_r( $cmsList->result());exit;
                        //  $cmsList= $this->db->query('select * from ' . CMS . ' where `lang_code`="' . $_SESSION['language_code'] . '" and `status`="Publish" and hidden_page="No"');
                        if ($_SESSION['language_code'] == 'en') {
                            //echo $_SESSION['language_code'];
                            if ($cmsList->num_rows() > 0) {
                                $i = 1;
                                //  echo $cmsList->num_rows();
                                foreach ($cmsList->result() as $key => $row) {
                                    if ($i % 2 != 0) {
                                        if ($row->seourl != 'help') { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                                <!--  <a href="pages/<?php $row->seourl; ?>"><?php ucfirst($row->page_name) ?></a> -->
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                            </li>
                                        <?php }
                                    }
                                    $i++;
                                }
                            } else {
                                echo "";
                            }
                        } else {

                            $lang_is = 'page_name_' . $_SESSION['language_code'];
                            if ($cmsList->num_rows() > 0) {
                                $i = 1;
                                foreach ($cmsList->result() as $key => $row) {
                                    if ($i % 2 != 0) {
                                        if ($row->$lang_is != '') {

                                            $value = $row->$lang_is;
                                        } else {
                                            $value = 'No Title';
                                        }
                                        if ($row->seourl != 'help') { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($value)); ?>
                                                <!--  <a href="pages/<?php $row->seourl; ?>"><?php ucfirst($row->page_name) ?></a> -->
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($value)); ?>
                                            </li>
                                        <?php }
                                    }
                                    $i++;
                                }
                            } else {
                                echo "";
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="listMenus">
                    <h5>&nbsp;</h5>
                    <ul>
                        <?php if ($_SESSION['language_code'] == 'en') {
                            if ($cmsList->num_rows() > 0) {
                                $i = 1;
                                foreach ($cmsList->result() as $key => $row) {
                                    if ($i % 2 == 0) {
                                        if ($row->seourl != 'help') { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($row->page_name)); ?>
                                            </li>
                                        <?php }
                                    }
                                    $i++;
                                }
                            } else {
                                echo "";
                            }
                        } else {
                            $lang_is = 'page_name_' . $_SESSION['language_code'];
                            if ($cmsList->num_rows() > 0) {
                                $i = 1;
                                foreach ($cmsList->result() as $key => $row) {
                                    //  echo $row->page_name_fr;
                                    if ($i % 2 == 0) {
                                        if ($row->$lang_is != '') {

                                            $value = $row->$lang_is;
                                        } else {
                                            $value = 'No Title';
                                        }

                                        if ($row->seourl != 'help') { ?>
                                            <li>

                                                <?php

                                                echo anchor('pages/' . $row->seourl, ucfirst($value)); ?>
                                            </li>
                                        <?php } else { ?>
                                            <li>
                                                <?php echo anchor('pages/' . $row->seourl, ucfirst($value)); ?>
                                            </li>
                                        <?php }
                                    }
                                    $i++;
                                }
                            } else {
                                echo "";
                            }
                        } ?>


                    </ul>
                </div>
            </div>

 <?php */ ?>

            <!--- footer menu new --->

            <?php

            if(!empty($cmsList)){

                $i=0;
                foreach($cmsList as $top_menu=>$cms_page){

                    if(is_array($cms_page)){
                        ?>
            <div class="col-sm-3">
                        <div class="listMenus">
                            <h5><?php  //echo $top_menu; ?>

                                <?php if ($this->lang->line($top_menu) != '') {
                                    echo stripslashes($this->lang->line($top_menu));
                                } else echo $top_menu; ?>


                            </h5>

                            <ul>
                                <?php foreach ($cms_page as $key=>$page){ ?>
                                    <li><a href="<?= base_url().'pages/'.$page['seourl']; ?>"> <?php echo ucfirst($page['page_title']); ?>  </a>
                                    </li>
                                <?php } ?>

                                <?php if($i==0){

                                    //first session//
                                    ?>
                                    <li><a href="<?= base_url(); ?>help"> <?php if ($this->lang->line('Help') != '') {
                                                echo stripslashes($this->lang->line('Help'));
                                            } else echo "Help"; ?> </a></li>
                                    <li><a href="<?= base_url(); ?>contact-us"> <?php if ($this->lang->line('Contact Us') != '') {
                                                echo stripslashes($this->lang->line('Contact Us'));
                                            } else echo "Contact Us"; ?> </a></li>
                                <?php } ?>
                            </ul>

                        </div>
            </div>
                        <?php
                    }
                    $i++;

                }

            }
            ?>

            <!--- footer menu new --->


        </div>
        <div class="copyRights">
            <div class="clear">
                <?php //if($_SESSION['language_code'] == 'ar') {
                if ($_SESSION['language_code'] == 'en') {
                    $foot_col = 'footer_content';
                } else {
                    $foot_col = 'footer_content_' . $_SESSION['language_code'];
                }

                //                     $condition_DEV = array('id'=>'1');
                // $footer_cont = $this->product_model->get_all_details(ADMIN_SETTINGS, $condition_DEV);
                //print_r($footer_cont->result());
                ?>
                <div class="left copyRights__text">
                    <?= html_entity_decode($footer_cont->row()->$foot_col); ?>
                </div>

                <div class="right copyRights__text">
                    <a href="<?php echo base_url(); ?>pages/terms-of-service"><?php if ($this->lang->line('header_terms_service') != '') {
                            echo stripslashes($this->lang->line('header_terms_service'));
                        } else echo "Terms of Service"; ?></a>
                    <a href="<?php echo base_url(); ?>pages/privacy-policy"><?php if ($this->lang->line('header_privacy_policy') != '') {
                            echo stripslashes($this->lang->line('header_privacy_policy'));
                        } else echo "Privacy Policy"; ?></a>
                    <!--<a href="#">Site Map</a>-->

                    <div class="f-social-icons">
                        <?php if ($this->config->item('facebook_link') != '') { ?>
                            <a href="<?php echo $this->config->item('facebook_link'); ?>"><img
                                        src="<?php echo base_url(); ?>images/facebookIcon_f.png"></a>
                        <?php }
                        if ($this->config->item('twitter_link') != '') { ?>
                            <a href="<?php echo $this->config->item('twitter_link'); ?>"><img
                                        src="<?php echo base_url(); ?>images/twitterIcon.png"></a>
                        <?php }
                        if ($this->config->item('googleplus_link') != '') { ?>
                            <a href="<?php echo $this->config->item('googleplus_link'); ?>"><img
                                        src="<?php echo base_url(); ?>images/instagramIcon.png"></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Sign Up Modal -->
<div id="signUp" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="signUpIn">
                    <?php $invite_word = $this->uri->segment(2, 0);
                    if (!$invite_word == 'invite') {
                        ?>

                        <?php if ($facebook_id != '' && $facebook_secert != '') { ?>
                            <?php /* <a href="<?php echo $fbLoginUrl; ?>" class="faceBook hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') {
                                echo stripslashes($this->lang->line('facebook_signup'));
                            } else echo "Continue with Facebook"; ?></a> */ ?>
                            <a href="javascript:;" onclick="fb_login()" class="faceBook hide_signUp"> <img src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') { echo stripslashes($this->lang->line('facebook_signup')); } else { echo "Continue with Facebook"; } ?></a>
                        <?php }
                        if ($google_id != '' && $google_secert != '') { ?>
                             <a href="<?php echo $googleLoginURL; ?>" class="googlePlus hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/gplus.png"> <?php if ($this->lang->line('signup_google') != '') {
                                echo stripslashes($this->lang->line('signup_google'));
                            } else echo "Continue with Google"; ?></a>
                        <?php }
                        if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                             <a href="<?php echo base_url(); ?>linkedin-login?oauth_init=1" 
                           class="googlePlus hide_signUp" style="color: #ffffff;background:#0288d1 !important;border: none;">
                            <img
                                    src="<?php echo base_url(); ?>images/linkedinIcon.png"> <?php if ($this->lang->line('signup_linkedin') != '') {
                                echo stripslashes($this->lang->line('signup_linkedin'));
                            } else echo "Continue with Linkedin"; ?></a>
                        <?php } ?>


                        <p class="SignupBlock dd"><?php if ($this->lang->line('sign_up_with') != '') {
                                echo stripslashes($this->lang->line('sign_up_with'));
                            } else echo "Sign Up With"; ?> <a
                                    href="<?php echo $fbLoginUrl; ?>"><?php if ($this->lang->line('Facebook') != '') {
                                    echo stripslashes($this->lang->line('Facebook'));
                                } else echo "Facebook"; ?></a><?php if ($google_id != '' && $google_secert != '') { ?>
                                <a id="sgup_tx" class=""
                                   href="<?php echo $googleLoginURL; ?>"><?php if ($this->lang->line('Google') != '') {
                                        echo stripslashes($this->lang->line('Google'));
                                    } else echo "Google"; ?></a> Or
                            <?php } ?> <?php if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                                <a id="sgup_tx" href="<?php echo base_url(); ?>linkedin-login?oauth_init=1"
                                   class=""><?php if ($this->lang->line('Linkedin') != '') {
                                        echo stripslashes($this->lang->line('Linkedin'));
                                    } else echo "Linkedin"; ?></a>
                            <?php } ?></p>
                        <div class="or"><span>or</span></div>

                    <?php } ?>
                    <a href="#" class="email signupOpen hide_signUp"> <img
                                src="<?php echo base_url(); ?>images/emailIcon.png"><?php if ($this->lang->line('Sign_up_with_Email') != '') {
                            echo stripslashes($this->lang->line('Sign_up_with_Email'));
                        } else echo "Sign up with Email"; ?> </a>
                    <?php
                    echo form_open('site/signupsignin/create_normal_user')
                    ?>
                    <div class="SignupBlock newSignupBlock" id="sd">
                        <!-- <p class="text-danger" id="signup_error_message"></p> -->
                        <!-- <p class="text-success" id="signup_success_message"></p> -->
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('signup_emailaddrs') != '') {
                                $em_addr = stripslashes($this->lang->line('signup_emailaddrs'));
                            } else $em_addr = "Email Address";
                            echo form_input('email_address', '', array("id" => "email_address", "placeholder" => $em_addr)); ?>
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('signup_full_name') != '') {
                                $fn_addr = stripslashes($this->lang->line('signup_full_name'));
                            } else $fn_addr = "First Name";
                            echo form_input('first_name', '', array("id" => "first_name", "placeholder" => $fn_addr)); ?>
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </div>
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('signup_user_name') != '') {
                                $ln_addr = stripslashes($this->lang->line('signup_user_name'));
                            } else $ln_addr = "Last Name";
                            echo form_input('last_name', '', array("id" => "last_name", "placeholder" => $ln_addr)); ?>
                            <i class="fa fa-user-o" aria-hidden="true"></i>
                        </div>

                        <div class="image_box">
                            <?php
                            if ($this->lang->line('front_phone') != '') {
                                $ln_addr = stripslashes($this->lang->line('front_phone'));
                            } else $ln_addr = "Phone";
                            $data = array(
                                'name' => 'phone',
                                'id' => 'phone',
                                'type' => 'text',
                                'maxlength' => '15',
                                'placeholder' => '+1 999-999-9999'
                            );
                            echo form_input($data); ?>
                            <i class="fa fa-phone" aria-hidden="true"></i>
                        </div>
                        <label>Example: +1 999-999-9999</label>
						
						<div class="image_box">
                            <?php
                            if ($this->lang->line('signup_login_type') != '') {
                                $login_type = stripslashes($this->lang->line('signup_login_type'));
                            } else $login_type = "Login Type";
							
							if ($this->lang->line('Host') != '') {
                                $host_labe = stripslashes($this->lang->line('Host'));
                            } else $host_labe = "Host";
							
							if ($this->lang->line('guest_s') != '') {
                                $guest_labe = stripslashes($this->lang->line('guest_s'));
                            } else $guest_labe = "Guest";
							
								$options = array('' => $login_type, 'Host' => $host_labe, 'Guest' => $guest_labe);
							    echo form_dropdown('login_type', $options, '', array("id" => "login_type"));
							?>
                        </div>
						
						<div id="host_details" style="display:none;">
							<div class="image_box">
								<?php
								if ($this->lang->line('signup_business_name') != '') {
									$bus_name = stripslashes($this->lang->line('signup_business_name'));
								} else $bus_name = "Business Name";
								echo form_input('business_name', '', array("id" => "business_name", "placeholder" => $bus_name)); ?>                            <i class="fa fa-lock" aria-hidden="true"></i>
							</div>
							
							<div class="image_box">
								<?php
								if ($this->lang->line('signup_business_description') != '') {
									$bus_desc = stripslashes($this->lang->line('signup_business_description'));
								} else $bus_desc = "Business Description";
								echo form_input('business_desc', '', array("id" => "business_desc", "placeholder" => $bus_desc)); ?>                            <i class="fa fa-lock" aria-hidden="true"></i>
							</div>
							
							<div class="image_box">
								<?php
								if ($this->lang->line('signup_license_number') != '') {
									$lic_num = stripslashes($this->lang->line('signup_license_number'));
								} else $lic_num = "License Number";
								echo form_input('license_no', '', array("id" => "license_no", "placeholder" => $lic_num)); ?>                            <i class="fa fa-lock" aria-hidden="true"></i>
							</div>
							
							<div class="image_box">
								<?php
								if ($this->lang->line('signup_business_address') != '') {
									$bus_addr = stripslashes($this->lang->line('signup_business_address'));
								} else $bus_addr = "Business Address";
								echo form_input('business_addr', '', array("id" => "business_addr", "placeholder" => $bus_addr)); ?>                            <i class="fa fa-lock" aria-hidden="true"></i>
							</div>
						</div>
						
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('create_pwd') != '') {
                                $cr_pswd = stripslashes($this->lang->line('create_pwd'));
                            } else $cr_pswd = "Create Password";
                            echo form_password('user_password', '', array("onkeyup"=>"pwd_validation(this.value);","id" => "user_password", "placeholder" => $cr_pswd)); ?>
                            <i id="showPass_reg" class="fa fa-eye" aria-hidden="true"></i>
                        </div>
						
                        <div class="image_box">
                            <?php
                            if ($this->lang->line('change_conf_pwd') != '') {
                                $cnfr_pswd = stripslashes($this->lang->line('change_conf_pwd'));
                            } else $cnfr_pswd = "Confirm Password";
                            echo form_password('user_confirm_password', '', array("onkeyup"=>"cnf_pwd_validation(this.value);","id" => "user_confirm_password", "placeholder" => $cnfr_pswd)); ?>
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </div>
                        <div id="pwd_validation_points">
                            <i id="pwd_caps_tik"  class="fa fa-check green" aria-hidden="true"></i><small id="pwd_caps" class="pwdSmall">One Letter Must Be Capital</small><br>
                            <i id="pwd_digit_tik"  class="fa fa-check green" aria-hidden="true"></i><small id="pwd_digit" class="pwdSmall">One Number Must Be there</small><br>
                            <i id="pwd_total_tik"  class="fa fa-check green" aria-hidden="true"></i><small id="pwd_total" class="pwdSmall">should not less than 8 chars</small><br>
                            <i id="pwd_cnf_tik"  class="fa fa-check green" aria-hidden="true"></i><small id="pwd_cnf" class="pwdSmall">Conform password should be same</small>
                        </div>
                       <!--  <h5><?php if ($this->lang->line('BirthDate') != '') {
                                echo stripslashes($this->lang->line('BirthDate'));
                            } else echo "Birth Day"; ?></h5>
                        <div class="reduceFont"><?php if ($this->lang->line('signup_18older') != '') {
                                echo stripslashes($this->lang->line('signup_18older'));
                            } else echo "To sign up, you must be 18 or older. Other people won’t see your
                            birthday."; ?>
                        </div>
                        <div class="row birthdayCol">
                            <div class="col-sm-5">
                                <?php
                                echo form_dropdown('birth_month', $birth_month, '', array("id" => "birth_month"));
                                ?>
                            </div>
                            <div class="col-sm-2">
                                <?php
                                echo form_dropdown('birth_day', $birth_day, '', array("id" => "birth_day"));
                                ?>
                            </div>
                            <div class="col-sm-5">
                                <?php
                                echo form_dropdown('birth_year', $birth_year, '', array("id" => "birth_year"));
                                ?>
                            </div>
                        </div> -->
                        <label>
        			<span class="checkboxStyle">
                        <?php echo form_checkbox('acccept_terms', 'accepted', '', array("id" => "acccept_terms", "class" => "hideTemp")); ?>
                        <i class="fa fa-check" aria-hidden="true"></i>
	        		</span>
                            <input type="hidden" name="invite_reference" id="invite_reference"
                                   value="<?= ($this->uri->segment(1) == "c" && $this->uri->segment(2) == "invite") ? $this->uri->segment(3) : "0"; ?>">
                            <div class="reduceFont marginTop3"><?php if ($this->lang->line('signup_cont1') != '') {
                                    echo stripslashes($this->lang->line('signup_cont1'));
                                } else echo 'By Signing up, you confirm that you accept the'; ?>
                                <a target="_blank" data-popup="true"
                                   href="pages/terms-of-service"><?php if ($this->lang->line('header_terms_service') != '') {
                                        echo stripslashes($this->lang->line('header_terms_service'));
                                    } else echo "Terms of Service"; ?></a> <?php if ($this->lang->line('header_and') != '') {
                                    echo stripslashes($this->lang->line('header_and'));
                                } else echo "and"; ?>
                                <a target="_blank" data-popup="true"
                                   href="pages/privacy-policy"><?php if ($this->lang->line('header_privacy_policy') != '') {
                                        echo stripslashes($this->lang->line('header_privacy_policy'));
                                    } else echo "Privacy Policy"; ?></a>
                            </div>
                        </label>
                        <p class="text-danger" id="signup_error_message"></p>
                        <p class="text-success" id="signup_success_message"></p>
                        <a class="email" style="display:none;" id="create_account_btn_loading"
                           href="javascript:void(0);"><i class="fa fa-spinner fa-spin"></i> Creating Account..</a>
                        <a href="javascript:void(0);" id="create_account_button" onclick="validate_and_create_user();"
                           class="email"> <?php if ($this->lang->line('login_signup') != '') {
                                echo stripslashes($this->lang->line('login_signup'));
                            } else echo "Create Account"; ?></a>
                    </div>
                    <?php echo form_close(); ?>
                    <div class="bottom"></div>
                    <p><?php if ($this->lang->line('already_member') != '') {
                            echo stripslashes($this->lang->line('already_member'));
                        } else echo "Already a member?"; ?> <a href="#signIn" data-dismiss="modal"
                                                               data-toggle="modal"><?php if ($this->lang->line('header_login') != '') {
                                echo stripslashes($this->lang->line('header_login'));
                            } else echo "Log in"; ?></a></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sign In Modal -->
<div id="signIn" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="signUpIn">
                    <?php if ($facebook_id != '' && $facebook_secert != '') { ?>
                        <?php /* <a href="<?php echo $fbLoginUrl; ?>" class="faceBook hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') {
                                echo stripslashes($this->lang->line('facebook_signup'));
                            } else echo "Continue with Facebook"; ?></a> */ ?>
                        <a href="javascript:;" onclick="fb_login()" class="faceBook hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/facebookIcon.png"> <?php if ($this->lang->line('facebook_signup') != '') {
                                echo stripslashes($this->lang->line('facebook_signup'));
                            } else {
                                echo "Continue with Facebook";
                            } ?></a>
                    <?php }
                    if ($google_id != '' && $google_secert != '') { ?>
                        <a href="<?php echo $googleLoginURL; ?>" class="googlePlus hide_signUp"> <img
                                    src="<?php echo base_url(); ?>images/gplus.png"> <?php if ($this->lang->line('signup_google') != '') {
                                echo stripslashes($this->lang->line('signup_google'));
                            } else echo "Continue with Google"; ?></a>
                    <?php }
                    if ($linkedin_id != '' && $linkedin_secert != '') { ?>
                        <a href="<?php echo base_url(); ?>linkedin-login?oauth_init=1"
                           class="googlePlus hide_signUp" style="color: #ffffff;background:#0288d1 !important;border: none;">
                            <img
                                    src="<?php echo base_url(); ?>images/linkedinIcon.png"> <?php if ($this->lang->line('signup_linkedin') != '') {
                                echo stripslashes($this->lang->line('signup_linkedin'));
                            } else echo "Continue with Linkedin"; ?></a>
                    <?php } ?>


                    <div class="or"><span><?php if ($this->lang->line('OR') != '') {
                                echo stripslashes($this->lang->line('OR'));
                            } else echo "OR"; ?></span></div>
                    <?php echo form_open();
                    if (isset($_COOKIE['autologin'])) {
                        $remembered_det = $_COOKIE['autologin'];
                        $checked_status = 'checked="checked"';
                        $decodeJson = json_decode($remembered_det, true);
                        $cookie_email = $decodeJson['email'];
                        $cookie_paswd = $decodeJson['password'];
                    } else {
                        $remembered_det = '';
                        $checked_status = '';
                        $cookie_email = '';
                        $cookie_paswd = '';
                    }
                    //$decodeJson =  json_decode($json, true);
                    //echo ;
                    //$json = json_encode($rememberArray);
                    ?>
                    <p class="text-danger" id="signin_error_message"></p>
                    <p class="text-success" id="signin_success_message"></p>
                    <div class="image_box">
                        <?php


                        if ($this->lang->line('Enter_Email') != '') {
                            $ent_eml = stripslashes($this->lang->line('Enter_Email'));
                        } else {
                            $ent_eml = 'Enter Email';
                        }
                        echo form_input('user_email', $cookie_email, array('autocomplete' => 'off', 'id' => 'login_email_address', 'placeholder' => $ent_eml)); ?>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="image_box">
                        <?php
                        if ($this->lang->line('Enter_Password') != '') {
                            $ent_psd = stripslashes($this->lang->line('Enter_Password'));
                        } else {
                            $ent_psd = 'Enter Password';
                        }
                        echo form_password('user_password', $cookie_paswd, array('autocomplete' => 'off', 'id' => 'login_password', "class" => "password_l", 'placeholder' => $ent_psd)); ?>
                        <i class="fa fa-lock" aria-hidden="true"></i>
                    </div>
                    <div class="remember clear">
                        <div class="left">
                            <label>
	        			<span class="checkboxStyle">
	        				<input type="checkbox" name="remember_me" id="remember_meChkBox"
                                   class="hideTemp" <?php echo $checked_status; ?>>
		        			<i class="fa fa-check" aria-hidden="true"></i>
		        		</span>
                                <?php if ($this->lang->line('remember_me') != '') {
                                    echo stripslashes($this->lang->line('remember_me'));
                                } else echo "Remember Me"; ?>
                            </label>
                        </div>
                        <div class="right">
                            <?php if ($_SESSION['language_code'] == 'en') { ?>
                                <a href="#" class="showPass"><?php if ($this->lang->line('Show_Password') != '') {
                                    echo stripslashes($this->lang->line('Show_Password'));
                                } else echo "Show Password"; ?></a><?php } elseif ($_SESSION['language_code'] == 'ar') { ?>
                                <a href="#" class="showPass_ar"><?php if ($this->lang->line('Show_Password') != '') {
                                    echo stripslashes($this->lang->line('Show_Password'));
                                } else echo "Show Password"; ?></a><?php } else { ?>
                                <a href="#" class="showPass"><?php if ($this->lang->line('Show_Password') != '') {
                                        echo stripslashes($this->lang->line('Show_Password'));
                                    } else echo "Show Password"; ?></a>
                            <?php } ?>
                        </div>
                    </div>

                    <a href="javascript:void(0);" class="email" onclick="javascript:user_login();"><i id="spin"
                                                                                                      style="display: none;"
                                                                                                      class="fa fa-spinner fa-spin"></i> <?php if ($this->lang->line('Log_in') != '') {
                            echo stripslashes($this->lang->line('Log_in'));
                        } else echo "Log in"; ?></a>
                    <a href="#forgotPassword" class="forgotPass" data-dismiss="modal"
                       data-toggle="modal"><?php if ($this->lang->line('forgot_passsword') != '') {
                            echo stripslashes($this->lang->line('forgot_passsword'));
                        } else echo "Forgot Passsword ?"; ?></a>
                    <div class="bottom"></div>
                    <p><?php if ($this->lang->line('dont_have_account') != '') {
                            echo stripslashes($this->lang->line('dont_have_account'));
                        } else echo "Don’t have an account?"; ?> <a href="#signUp" data-dismiss="modal"
                                                                    data-toggle="modal"><?php if ($this->lang->line('signup') != '') {
                                echo stripslashes($this->lang->line('signup'));
                            } else echo "Sign Up"; ?></a></p>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<?php
if ($this->lang->line('Show_Password') != '') {
    $show = stripslashes($this->lang->line('Show_Password'));
} else $show = "Show Password";
if ($this->lang->line('hide_Password') != '') {
    $hide = stripslashes($this->lang->line('hide_Password'));
} else $hide = "Hide Password";
?>
<script>

    $(".showPass_ar").click(function () {
        if ($(".password_l").attr("type") == "password") {
            $(".password_l").prop("type", "text");
            $(this).text("اخفاء كلمة المرور");
        }
        else {
            $(".password_l").prop("type", "password");
            $(this).text("عرض كلمة المرور");
        }
    });
</script>
<script>

    $('#login_password').keypress(function (e) {
        if (e.which == '13') {
            user_login();
        }
    });
</script>
<!-- Sign In Modal -->
<div id="forgotPassword" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <?php echo form_open(''); ?>
                <div class="signUpIn">
                    <h3><?php if ($this->lang->line('forgot_reset_pwd') != '') {
                            echo stripslashes($this->lang->line('forgot_reset_pwd'));
                        } else echo "Reset Password"; ?></h3>
                    <p class="resetPassDesc"><?php if ($this->lang->line('contant_reset_pwd') != '') {
                            echo stripslashes($this->lang->line('contant_reset_pwd'));
                        } else echo "Enter the email address associated with your account, and we'll email you a link to reset your password."; ?></p>
                    <p class="text-danger" id="forgot_pass_error"></p>
                    <p class="text-success" id="forgot_pass_success"></p>
                    <div class="image_box">
                        <?php echo form_input('forgot_email', '', array('id' => 'forgot_pass_email', 'placeholder' => $ent_eml)); ?>
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    </div>
                    <div class="remember clear">
                        <div class="left">
                            <a href="#signIn" class="bckToLogin" data-dismiss="modal" data-toggle="modal"> <span
                                        class="number_s">  </span> <?php if ($this->lang->line('back_to_login') != '') {
                                    echo stripslashes($this->lang->line('back_to_login'));
                                } else echo "Back to Login"; ?> </a>


                        </div>
                        <div id='loadingmessage'>
                            <img width='50px' src='<?php echo base_url(); ?>images/spinner.gif'/>
                        </div>
                        <div class="right">
                            <a href="javascript:void(0);" onclick="javascript:forgot_pass_mail();"
                               class="email"> <?php if ($this->lang->line('send_reset_pwd') != '') {
                                    echo stripslashes($this->lang->line('send_reset_pwd'));
                                } else echo "Send Reset Link"; ?> </a>
                        </div>
                    </div>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
<!--Wish List Adding and creating-->
<div id="contactHost" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row" id="WishlistFormContainer">
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if ($this->lang->line('pls_enter_email') != '') {
    $entr_email = stripslashes($this->lang->line('pls_enter_email'));
} else {
    $entr_email = "Please Enter Email Address";
}
?>
<input type="hidden" name="" id="entr_email" value="<?php echo $entr_email; ?>">


<?php
if ($this->lang->line('pls_enter_email_valid') != '') {
    $valid_email = stripslashes($this->lang->line('pls_enter_email_valid'));
} else {
    $valid_email = "Please Enter Valid Email Address";
}
?>
<input type="hidden" name="" id="valid_email" value="<?php echo $valid_email; ?>">

<?php
if ($this->lang->line('pls_enter_passwrd') != '') {
    $enter_paswrd = stripslashes($this->lang->line('pls_enter_passwrd'));
} else {
    $enter_paswrd = "Please Enter Password";
}
?>
<input type="hidden" name="" id="enter_paswrd" value="<?php echo $enter_paswrd; ?>">

<?php
if ($this->lang->line('pls_enter_phone') != '') {
    $enter_phone = stripslashes($this->lang->line('pls_enter_phone'));
} else {
    $enter_phone = "Please Enter Phone Number";
}
?>
<input type="hidden" name="" id="enter_phone" value="<?php echo $enter_phone; ?>">

<?php
if ($this->lang->line('paswrd_must') != '') {
    $paswrd_must = stripslashes($this->lang->line('paswrd_must'));
} else {
    $paswrd_must = "Password must be 8 characters (must contain 1 digit and 1 uppercase)";
}
?>
<input type="hidden" name="" id="paswrd_must" value="<?php echo $paswrd_must; ?>">

<?php
if ($this->lang->line('pls_entr_first_name') != '') {
    $entr_first = stripslashes($this->lang->line('pls_entr_first_name'));
} else {
    $entr_first = "Please Enter First Name";
}
?>
<input type="hidden" name="" id="entr_first" value="<?php echo $entr_first; ?>">

<?php
if ($this->lang->line('pls_entr_last_name') != '') {
    $entr_last = stripslashes($this->lang->line('pls_entr_last_name'));
} else {
    $entr_last = "Please Enter Last name";
}
?>
<input type="hidden" name="" id="entr_last" value="<?php echo $entr_last; ?>">

<?php
if ($this->lang->line('pls_entr_confirm_paswrd') != '') {
    $confirm_pas = stripslashes($this->lang->line('pls_entr_confirm_paswrd'));
} else {
    $confirm_pas = "Please Enter Confirm Password";
}
?>
<input type="hidden" name="" id="confirm_pas" value="<?php echo $confirm_pas; ?>">

<?php
if ($this->lang->line('confirm_paswrd_not_matched') != '') {
    $not_matched = stripslashes($this->lang->line('confirm_paswrd_not_matched'));
} else {
    $not_matched = "Password and Confirm Password not matched";
}
?>
<input type="hidden" name="" id="not_matched" value="<?php echo $not_matched; ?>">

<?php
if ($this->lang->line('must_accept_term') != '') {
    $must_accept = stripslashes($this->lang->line('must_accept_term'));
} else {
    $must_accept = "Must accept our terms and conditions";
}
?>
<input type="hidden" name="" id="must_accept" value="<?php echo $must_accept; ?>">

<?php
if ($this->lang->line('pls_entr_business_name') != '') {
    $entr_bus_name = stripslashes($this->lang->line('pls_entr_business_name'));
} else {
    $entr_bus_name = "Please Enter Business Name";
}
?>
<input type="hidden" name="" id="entr_bus_name" value="<?php echo $entr_bus_name; ?>">

<?php
if ($this->lang->line('pls_entr_business_desc') != '') {
    $entr_bus_desc = stripslashes($this->lang->line('pls_entr_business_desc'));
} else {
    $entr_bus_desc = "Please Enter Business Description";
}
?>
<input type="hidden" name="" id="entr_bus_desc" value="<?php echo $entr_bus_desc; ?>">

<?php
if ($this->lang->line('pls_entr_license_no') != '') {
    $entr_licen_no = stripslashes($this->lang->line('pls_entr_license_no'));
} else {
    $entr_licen_no = "Please Enter Real Estate License Number";
}
?>
<input type="hidden" name="" id="entr_licen_no" value="<?php echo $entr_licen_no; ?>">

<?php
if ($this->lang->line('pls_entr_business_addr') != '') {
    $entr_bus_addr = stripslashes($this->lang->line('pls_entr_business_addr'));
} else {
    $entr_bus_addr = "Please Enter Business Address";
}
?>
<input type="hidden" name="" id="entr_bus_addr" value="<?php echo $entr_bus_addr; ?>">

<input type="hidden" id="to_url_value" value="<?php echo current_url(); ?>"/>
<script>

    function validate_and_create_user() {
        var enter_emailS = $("#entr_email").val();
        var enter_email_valS = $("#valid_email").val();
        var entr_firstS = $("#entr_first").val();
        var entr_lastS = $("#entr_last").val();
        var entr_paswrdS = $("#enter_paswrd").val();
        var enter_phone = $("#enter_phone").val();
        var must_containS = $("#paswrd_must").val();
        var confirmS = $("#confirm_pas").val();
        var not_matchedS = $("#not_matched").val();
        var must_accept = $("#must_accept").val();
        var entr_bus_nameS = $("#entr_bus_name").val();
        var entr_bus_descS = $("#entr_bus_desc").val();
        var entr_licen_noS = $("#entr_licen_no").val();
        var entr_bus_addrS = $("#entr_bus_addr").val();
        

        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#email_address").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var phone = $("#phone").val();
		var business_name = $("#business_name").val();
        var business_desc = $("#business_desc").val();
        var license_no = $("#license_no").val();
        var business_addr = $("#business_addr").val();
        var user_password = $("#user_password").val();
        var birth_month = $("#birth_month").val();
        var birth_day = $("#birth_day").val();
        var birth_year = $("#birth_year").val();
        var invite_reference = $("#invite_reference").val();
        var user_confirm_password = $("#user_confirm_password").val();
        var acccept_terms = $("#acccept_terms");
        if (email_address == "") {
            $("#email_address").focus();
            $("#signup_error_message").html(enter_emailS)
            return false;
        } else if (!filter.test(email_address)) {
            $("#email_address").focus();
            $("#signup_error_message").html(enter_email_valS)
            return false;
        } else if (first_name == "") {
            $("#first_name").focus();
            $("#signup_error_message").html(entr_firstS)
            return false;
        } else if (last_name == "") {
            $("#last_name").focus();
            $("#signup_error_message").html(entr_lastS);
            return false;
        } else if (phone == "") {
            $("#phone").focus();
            $("#signup_error_message").html(enter_phone);
            return false;
        } else if (business_name == "") {
            $("#business_name").focus();
            $("#signup_error_message").html(entr_bus_nameS)
            return false;
        } else if (business_desc == "") {
            $("#business_desc").focus();
            $("#signup_error_message").html(entr_bus_descS)
            return false;
        } else if (license_no == "") {
            $("#license_no").focus();
            $("#signup_error_message").html(entr_licen_noS)
            return false;
        } else if (business_addr == "") {
            $("#business_addr").focus();
            $("#signup_error_message").html(entr_bus_addrS)
            return false;
        } 
        else if (user_password == "") {
            $("#user_password").focus();
            $("#signup_error_message").html(entr_paswrdS)
            return false;
        } else if (!user_password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/)) {
            $("#user_password").focus();
            $("#signup_error_message").html(must_containS)
            return false;
        } else if (user_confirm_password == "") {
            $("#user_confirm_password").focus();
            $("#signup_error_message").html(confirmS)
            return false;
        } else if (user_confirm_password != user_password) {
            $("#user_confirm_password").focus();
            $("#signup_error_message").html(not_matchedS)
            return false;
        } else if (acccept_terms.not(":checked").length) {
            $("#acccept_terms").focus();
            $("#signup_error_message").html(must_accept)
            return false;
        } else {
            $("#create_account_button").hide();
            $("#create_account_btn_loading").show();
            $("#signup_error_message").html("");
            $.post("<?= base_url(); ?>site/signupsignin/create_normal_user", {
                email_address: email_address,
                first_name: first_name,
                birth_month: birth_month,
                birth_day: birth_day,
                birth_year: birth_year,
                invite_reference: invite_reference,
                user_password: user_password,
                last_name: last_name,
                phone: phone
            }, function (result) {
                var data = result.split("::");
                var resp = "Success";
                if (data[0].trim() == resp) {
                    var redirect_to = $('#to_url_value').val();
                    window.location.href = '<?= base_url(); ?>' + redirect_to;
                    $("#signup_success_message").html(data[1])
                    $("#signup_error_message").html("");
                    window.location.reload();
                } else {
                    $("#create_account_btn_loading").hide();
                    $("#create_account_button").show();
                    $("#signup_error_message").html(data[1]);
                    $("#signup_success_message").html("");
                    // $('#sd')[0].scrollIntoView(true);

                    // document.getElementById('sd').scrollIntoView(true);

                    //document.getElementById('sd').scrollIntoView();


                }
            });
            return true;
        }
    }

    function user_login() {
        $('#spin').show();
        var enter_email = $("#entr_email").val();
        var valid_email = $("#valid_email").val();
        var enter_paswrd = $("#enter_paswrd").val();
        var paswrd_must = $("#paswrd_must").val();

        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#login_email_address").val();
        var user_password = $("#login_password").val();
        var remember_me = $('#remember_meChkBox').is(":checked");
        if (email_address == "") {
            $('#spin').hide();
            $("#login_email_address").focus();
            $("#signin_error_message").html(enter_email)
            return false;
        } else if (!filter.test(email_address)) {
            $('#spin').hide();
            $("#login_email_address").focus();
            $("#signin_error_message").html(valid_email)
            return false;
        } else if (user_password == "") {
            $('#spin').hide();
            $("#login_password").focus();
            $("#signin_error_message").html(enter_paswrd)
            return false;
        } else {
            $("#signin_error_message").html("");
            $.post("<?= base_url(); ?>site/signupsignin/login_normal_user", {
                email_address: email_address,
                user_password: user_password,
                remember_me: remember_me
            }, function (result) {
                var data = result.split("::");
                var resp = "Success";
                //alert(data[0]);
                //Success::Successfully Logged In
                if (data[0].trim() == resp) {

                    var redirect_to = $('#to_url_value').val();
                    window.location.href = '<?= base_url(); ?>' + redirect_to;
                    $("#signin_success_message").html(data[1]);
                    $("#signin_error_message").html("");
                    window.location.reload()

                }
                else {
                    $('#spin').hide();
                    $("#signin_error_message").html(data[1]);
                    $("#signin_success_message").html("");
                    $("#login_email_address").val('').focus();
                    $("#login_password").val('').focus();

                    // alert('err')
                    //window.location.reload();

                }
                //location.reload();
            });
            return true;
        }
    }

    function forgot_pass_mail() {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        var email_address = $("#forgot_pass_email").val();
        if (email_address == "") {
            $("#forgot_pass_email").focus();
            $("#forgot_pass_error").html("Please Enter Email Address")
            return false;
        } else if (!filter.test(email_address)) {
            $("#forgot_pass_email").focus();
            $("#forgot_pass_error").html("Please Enter Valid Email Address")
            return false;
        } else {
            $('#forgot_pass_email').hide();
            $('#loadingmessage').show();
            $("#forgot_pass_error").html("");
            $.post("site/signupsignin/send_password_to_mail", {
                email_address: email_address
            }, function (result) {
                var data = result.split("::");
                $('#loadingmessage').hide();
                if (data[0] == "Success") {

                    $("#forgot_pass_success").html(data[1])
                    $("#signin_error_message").html("");
                } else {
                    $('#forgot_pass_email').show();
                    $("#forgot_pass_error").html(data[1]);
                    $("#forgot_pass_success").html("");
                }
            });
            return true;
        }
    }

    /*Loading wishlist form*/
    function loadWishlistPopup(rentalId) {
        $('#contactHost').modal('show');
        $('#WishlistFormContainer').html('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</p>');
        $.get("<?php echo base_url(); ?>site/rentals/AddWishListForm/" + rentalId, function (data) {
            $('#WishlistFormContainer').html(data);
        });
    }

    /*Loading wishlist form for experience*/
    function loadExperienceWishlistPopup(rentalId) {
        $('#contactHost').modal('show');
        $('#WishlistFormContainer').html('<p class="text-center"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i> Loading...</p>');
        $.get("<?php echo base_url(); ?>site/experience/AddWishListForm/" + rentalId, function (data) {
            $('#WishlistFormContainer').html(data);
        });
    }

    /*Setting Language and currency*/
    function changeLanguage(e) {
        var strUser = e.options[e.selectedIndex].value;
        // alert(strUser);
        window.location.href = strUser;
    }

    function changeCurrency(e) {
        var strUser = e.options[e.selectedIndex].value;
        window.location.href = strUser;
    }

    function set_signup_and_login_link(link_to) {
        $("#to_url_value").val(link_to);
        $.post("<?= base_url(); ?>site/user/set_redirect_session", {'to_url': link_to});
    }
	
	function manage_register_form() {
       
    }

</script>
<script type="text/javascript">
    $(function () {
        var element = document.getElementById('phone');
        if (element.value == '') {
            $('#phone').val('+1');
        }

        $("body").tooltip({selector: '[data-toggle=tooltip]'});
        //alert('<?php echo current_url();?>');
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
<script type="text/javascript">
    $("#phone").intlTelInput({
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: "off",
        // dropdownContainer: document.body,
        // excludeCountries: ["us"],
        // formatOnDisplay: false,
        // geoIpLookup: function(callback) {
        //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //     var countryCode = (resp && resp.country) ? resp.country : "";
        //     callback(countryCode);
        //   });
        // },
        // hiddenInput: "full_number",
        // initialCountry: "auto",
        // localizedCountries: { 'de': 'Deutschland' },
        // nationalMode: false,
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        // placeholderNumberType: "MOBILE",
        preferredCountries: ['us'],
        // separateDialCode: true,
        utilsScript: "<?php echo base_url(); ?>assets/js/utils.js",
    });
function pwd_validation(params) {
// alert(params);
  
    if ((/[A-Z]/.test(params)) && params != '') {
          
           $('#pwd_caps_tik').css('color', 'green');
           // $('#pwd_caps').css('margin-left', '10px');
           $('#pwd_caps_tik').show();
           

        } else{
             $('#pwd_caps_tik').css('color', 'rgba(0, 128, 0, 0.20)');
             // $('#pwd_caps_tik').hide();
  
        }
        ///^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/
        if ((/\d/.test(params)) && params != '') {
          
          $('#pwd_digit_tik').css('color', 'green');
          // $('#pwd_digit').css('margin-left', '10px');
          $('#pwd_digit_tik').show();

        } 
        else{
             
   $('#pwd_digit_tik').css('color', 'rgba(0, 128, 0, 0.20)');
   // $('#pwd_digit_tik').hide();
        }
        if (params.length >= 8) {
          
            $('#pwd_total_tik').css('color', 'green');
            // $('#pwd_total').css('margin-left', '10px');
            $('#pwd_total_tik').show();

        } else{
             
   $('#pwd_total_tik').css('color', 'rgba(0, 128, 0, 0.20)');
   // $('#pwd_total_tik').hide();
        }
}
function cnf_pwd_validation(params) {
    var user_password = $('#user_password').val();

    if(params == user_password){
         $('#pwd_cnf_tik').css('color', 'green');
         // $('#pwd_cnf').css('margin-left', '10px');
            $('#pwd_cnf_tik').show();
    } else{
             
   $('#pwd_cnf_tik').css('color', 'rgba(0, 128, 0, 0.20)');
   // $('#pwd_cnf_tik').hide();
        }

}
 $("#showPass_reg").click(function () {
        if ($("#user_password").attr("type") == "password") {
            $(".password_l").prop("type", "text");
        }
        else {
            $("#user_password").prop("type", "password");
           
        }
    });
</script>

<script>
 $("#login_type").change(function () { 
	 var login_type = $("#login_type").val(); 
	 if(login_type == 'Host'){ 
		 $("#host_details").show();
	 }else{
		 $("#host_details").hide();
	 }
 });
</script>

