<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<style type="text/css">
  /*  .alertDiv {position: fixed;top: -30%;width: 100%;padding: 2%;text-align: center;z-index: 99;transition: 0.5s;padding: 2% 0 2% 0;background-color: #a61d55;color: #fff;font-weight: bold;}
.alertDiv.active {top:0px;}
.alertDiv span {display: inline;padding: 1%;border-radius: 4px;}*/
</style>
    <section>
        <div class="container">
            <div class="loggedIn clear">
                <div class="width20">
                    <ul class="sideBarMenu">
                        <li>
                            <a href="<?php echo base_url(); ?>settings" <?php if ($this->uri->segment(1) == 'settings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('EditProfile') != '') {
                                    echo stripslashes($this->lang->line('EditProfile'));
                                } else echo "Edit Profile"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>photo-video" <?php if ($this->uri->segment(1) == 'photo-video') { ?> class="active" <?php } ?>><?php if ($this->lang->line('photos') != '') {
                                    echo stripslashes($this->lang->line('photos'));
                                } else echo "Photos"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>verification" <?php if ($this->uri->segment(1) == 'verification') { ?> class="active" <?php } ?>><?php if ($this->lang->line('TrustandVerification') != '') {
                                    echo stripslashes($this->lang->line('TrustandVerification'));
                                } else echo "Trust and Verification"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>display-review" <?php if ($this->uri->segment(1) == 'display-review') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {
                                    echo stripslashes($this->lang->line('Reviews'));
                                } else echo "Reviews"; ?></a></li>
                        <!-- <li>
                        <a href="<?php echo base_url(); ?>display-dispute" <?php if (in_array($this->uri->segment(1), $disputeLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute/Cancel') != '') {
                                echo stripslashes($this->lang->line('Dispute/Cancel'));
                            } else echo "Dispute/Cancel"; ?> <span class="badge"><?php if($tot_dispute_count_is != 0) {echo ' '.$tot_dispute_count_is;} ?></span></a></li> -->
                        <li>
                            <a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {
                                    echo stripslashes($this->lang->line('ViewProfile'));
                                } else echo "View Profile"; ?></a></li>
                    </ul>
                </div>
                <div class="width80">
                    <?php echo form_open('site/user_settings/update_profile', array('class' => 'marginBottom2',"id"=>"update_profile")); ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php if ($this->lang->line('Profile') != '') {
                                echo stripslashes($this->lang->line('Profile'));
                            } else echo "Profile"; ?></div>
                        <div class="panel-body">
                            <div class="formList">
                                <label><?php if ($this->lang->line('signup_full_name') != '') {
                                        echo stripslashes($this->lang->line('signup_full_name'));
                                    } else echo "First Name"; ?> * </label>
                                <div class="right">
                                    <?php
                                    $firstName = "";
                                    if($this->lang->line('Enter your First Name') != ''){
                                        $enterfname= stripslashes($this->lang->line('Enter your First Name'));
                                    } else $enterfname ='Enter your First Name';
                                    if (!empty($userDetails)) {
                                        $firstName = $userDetails->row()->firstname;
                                    }
                                    echo form_input('firstname', $firstName, array('placeholder' => $enterfname,'id'=>'firstname'));
                                    ?>

                                    <small id="firstname_err" style="font-size: 12px;color: red;display: none;"></small>
                                </div>
                            </div>
                            <div class="formList">
                                <label><?php if ($this->lang->line('signup_user_name') != '') {
                                        echo stripslashes($this->lang->line('signup_user_name'));
                                    } else echo "Last Name:"; ?> </label>
                                <div class="right">
                                    <?php
                                    $lastname = "";
                                    if($this->lang->line('Enter your Last Name') != ''){
                                        $enterlname= stripslashes($this->lang->line('Enter your Last Name'));
                                    } else $enterlname ='Enter your Last Name';
                                    if (!empty($userDetails)) {
                                        $lastname = $userDetails->row()->lastname;
                                    }
                                    echo form_input('lastname', $lastname, array('placeholder' => $enterlname));
                                    ?>
                                    <p><?php if ($this->lang->line('Thisisonlyshared') != '') {
                                            echo stripslashes($this->lang->line('Thisisonlyshared'));
                                        } else echo "This is only shared once you have a confirmed booking with another user."; ?></p>
                                </div>
                            </div>
                            <div class="formList" style="display:none;">
                                <label><?php if ($this->lang->line('IAm') != '') {
                                        echo stripslashes($this->lang->line('IAm'));
                                    } else echo "I Am"; ?></label>
                                <div class="right">
                                    <?php
                                    if ($this->lang->line('Male') != '') {
                                        $male = stripslashes($this->lang->line('Male'));
                                    } else $male = "Male";
                                    if ($this->lang->line('Female') != '') {
                                        $female = stripslashes($this->lang->line('Female'));
                                    } else $female = 'Female';
                                    if ($this->lang->line('unspecified') != '') {
                                        $unspecified = stripslashes($this->lang->line('unspecified'));
                                    } else $unspecified = "Unspecified";
                                    $choosed = 'Unspecified';
                                    if (!empty($userDetails)) {
                                        $choosed = $userDetails->row()->gender;
                                    }
                                    $dropDownOptions = array('Male' => $male, 'Female' => $female, 'Unspecified' => $unspecified,);
                                    echo form_dropdown('gender', $dropDownOptions, $choosed, array('id'=>'gender'));
                                    ?>
                                    <p><?php if ($this->lang->line('Weusethisdata') != '') {
                                            echo stripslashes($this->lang->line('Weusethisdata'));
                                        } else echo "We use this data for analysis and never share it with other users."; ?></p>
                                </div>
                            </div>
                            <div class="formList" style="display:none;">
                                <label><?php if ($this->lang->line('BirthDate') != '') {
                                        echo stripslashes($this->lang->line('BirthDate'));
                                    } else echo "Birth Date"; ?></label>
                                <div class="right">
                                    <?php
                                    $choosedMonth = "";
                                    if (!empty($userDetails)) {
                                        $choosedMonth = $userDetails->row()->dob_month;
                                    }
                                    $monthArray = array();
                                    $monthArray[""] = "Month";
                                    for ($i = 1; $i <= 12; $i++) {
                                        $monthArray[$i] = date('F', mktime(0, 0, 0, $i, 10));
                                    }
                                    echo form_dropdown('dob_month', $monthArray, $choosedMonth);
                                    $dateArray = array();
                                    $choosedDay = "";
                                    if (!empty($userDetails)) {
                                        $choosedDay = $userDetails->row()->dob_date;
                                    }
                                    $dateArray[''] = 'Day';
                                    for ($i = 1; $i <= 31; $i++) {
                                        $dateArray[$i] = $i;
                                    }
                                    echo form_dropdown('dob_date', $dateArray, $choosedDay);
                                    $yearArray = array();
                                    $choosedYear = "";
                                    if (!empty($userDetails)) {
                                        $choosedYear = $userDetails->row()->dob_year;
                                    }
                                    $yearArray[''] = 'Year';
                                    $current_year = date('Y') - 5;
                                    $start_year = date('Y') - 100;
                                    for ($i = $current_year; $i > $start_year; $i--) {
                                        $yearArray[$i] = $i;
                                    }
                                    echo form_dropdown('dob_year', $yearArray, $choosedYear);
                                    ?>
                                    <p><?php if ($this->lang->line('Themagicaldayou') != '') {
                                            echo stripslashes($this->lang->line('Themagicaldayou'));
                                        } else echo "The magical day you were dropped from the sky by a stork. We use this data for analysis and never share it with other users."; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="formList">
                                <label><?php if ($this->lang->line('signup_emailaddrs') != '') {
                                        echo stripslashes($this->lang->line('signup_emailaddrs'));
                                    } else echo "Email Address"; ?> * </label>
                                <div class="right">
                                    <?php
                                    $loginUserType = $userDetails->row()->loginUserType;
                                    $userEmail = "";
                                    if (!empty($userDetails)) $userEmail = $userDetails->row()->email;
                                    if($userEmail != 'undefined' && $userDetails->row()->id_verified != 'No'){
                                    echo form_input(array('name' => 'email', 'type' => 'email', 'placeholder' => 'Enter your Email', 'value' => $userEmail, 'readonly' => 'readonly', 'id' => 'email_address'));
                                    }
                                    else{
                                         echo form_input(array('name' => 'email', 'type' => 'email', 'placeholder' => 'Enter your Email', 'value' => $userEmail, 'id' => 'email_address'));
                                    }
                                    ?>
                                    <p><?php if ($this->lang->line('Thisisonlyshared') != '') {
                                            echo stripslashes($this->lang->line('Thisisonlyshared'));
                                        } else echo "This is only shared once you have a confirmed booking with another user."; ?>
                                    </p>
                                </div>
                            </div>
							
							<?php if (!empty($userDetails)) if($userDetails->row()->group == 'Seller'){ ?>
							<div class="formList">
                                <label><?php if ($this->lang->line('signup_business_name') != '') {
                                        echo stripslashes($this->lang->line('signup_business_name'));
                                    } else echo "Business Name"; ?></label>
                                <div class="right">
                                    <?php
                                    $userbusinessname = "";
                                    if($this->lang->line('Enter_your_business_name') != ''){
                                        $enterBusinessName= stripslashes($this->lang->line('Enter_your_business_name'));
                                    } else $enterBusinessName ='Enter your Business Name';
                                    if (!empty($userDetails)) $userbusinessname = $userDetails->row()->business_name;
                                    echo form_input(array('name' => 'business_name', 'type' => 'text', 'placeholder' => $enterBusinessName, 'value' => $userbusinessname));
                                    ?>
                                </div>
                            </div>
							
							<div class="formList">
                                <label><?php if ($this->lang->line('signup_business_description') != '') {
                                        echo stripslashes($this->lang->line('signup_business_description'));
                                    } else echo "Business Description"; ?></label>
                                <div class="right">
                                    <?php
                                    $userbusinessdesc = "";
                                    if($this->lang->line('Enter_your_business_desc') != ''){
                                        $enterBusinessdesc= stripslashes($this->lang->line('Enter_your_business_desc'));
                                    } else $enterBusinessdesc ='Enter your Business Description';
                                    if (!empty($userDetails)) $userbusinessdesc = $userDetails->row()->description;
                                    echo form_textarea(array('name' => 'business_desc', 'type' => 'text', 'placeholder' => $enterBusinessdesc, 'value' => $userbusinessdesc,'rows'=>3));
                                    ?>
                                </div>
                            </div>
							
							<div class="formList">
                                <label><?php if ($this->lang->line('signup_license_number') != '') {
                                        echo stripslashes($this->lang->line('signup_license_number'));
                                    } else echo "License Number"; ?></label>
                                <div class="right">
                                    <?php
                                    $userlicno = "";
                                    if($this->lang->line('Enter_license_number') != ''){
                                        $enterlicno= stripslashes($this->lang->line('Enter_license_number'));
                                    } else $enterlicno ='Enter License Number';
                                    if (!empty($userDetails)) $userlicno = $userDetails->row()->license_number;
                                    echo form_input(array('name' => 'license_no', 'type' => 'text', 'placeholder' => $enterlicno, 'value' => $userlicno));
                                    ?>
                                </div>
                            </div>
							
							<div class="formList">
                                <label><?php if ($this->lang->line('signup_business_address') != '') {
                                        echo stripslashes($this->lang->line('signup_business_address'));
                                    } else echo "Business Address"; ?></label>
                                <div class="right">
                                    <?php
                                    $userbusinessaddr = "";
                                    if($this->lang->line('Enter_business_address') != ''){
                                        $enterbusinaddr= stripslashes($this->lang->line('Enter_business_address'));
                                    } else $enterbusinaddr ='Enter Business Address';
                                    if (!empty($userDetails)) $userbusinessaddr = $userDetails->row()->business_address;
                                    echo form_textarea(array('name' => 'license_no', 'type' => 'text', 'placeholder' => $enterbusinaddr, 'value' => $userbusinessaddr,'rows'=>3));
                                    ?>
                                </div>
                            </div>
							
							<?php } ?>
							
                            <div class="formList" style="display:none;">
                                <label><?php if ($this->lang->line('Paypal_Email') != '') {
                                        echo stripslashes($this->lang->line('Paypal_Email'));
                                    } else echo "Paypal Email-ID"; ?></label>
                                <div class="right">
                                    <?php
                                    $userPayPalEmail = "";
                                    if($this->lang->line('Enter your PayPal Email') != ''){
                                        $enterpaypal= stripslashes($this->lang->line('Enter your PayPal Email'));
                                    } else $enterpaypal ='Enter your PayPal Email';
                                    if (!empty($userDetails)) $userPayPalEmail = $userDetails->row()->paypal_email;
                                    echo form_input(array('name' => 'paypal_email', 'type' => 'email', 'placeholder' => $enterpaypal, 'value' => $userPayPalEmail));
                                    ?>
                                </div>
                            </div>
                            <div class="formList" style="display:none;">
                                <label><?php if ($this->lang->line('WhereYouLive') != '') {
                                        echo stripslashes($this->lang->line('WhereYouLive'));
                                    } else echo "Where You Live"; ?></label>
                                <div class="right">
                                    <?php
                                    $s_city = "";
                                    if ($this->lang->line('Enter your Place') != '') {
                                        $place= stripslashes($this->lang->line('Enter your Place'));
                                    } else $place="Enter your Place"; 
                                    if (!empty($userDetails)) $s_city = $userDetails->row()->s_city;
                                    echo form_input('s_city', $s_city, array('placeholder' => $place));
                                    ?>
                                </div>
                            </div>
                            <div class="formList noMargin" style="display:none;">
                                <label><?php if ($this->lang->line('DescribeYourself') != '') {
                                        echo stripslashes($this->lang->line('DescribeYourself'));
                                    } else echo "DescribeYourself"; ?></label>
                                <div class="right">
                                    <?php
                                    $description = "";
                                    if ($this->lang->line('Tell Something about Yourself!') != '') {
                                        $tell= stripslashes($this->lang->line('Tell Something about Yourself!'));
                                    } else $tell="Tell Something about Yourself!"; 
                                    if (!empty($userDetails)) $description = $userDetails->row()->description;
                                    echo form_textarea('description', $description, array('placeholder' => $tell));
                                    ?>
                                    <p><?php if ($this->lang->line('We built on relationships. Help other people get to know you.') != '') {
                                            echo stripslashes($this->lang->line('We built on relationships. Help other people get to know you.'));
                                        } else echo "We built the relationships. Help other people get to know you."; ?></p>
                                    <p><?php if ($this->lang->line('Tellthemabout') != '') {
                                            echo stripslashes($this->lang->line('Tellthemabout'));
                                        } else echo "Tell them about the things you like: What are 5 things you can’t live without? Share your favorite travel destinations, books, movies, shows, music, food."; ?></p>
                                    <p><?php if ($this->lang->line('Tellthemwhat') != '') {
                                            echo stripslashes($this->lang->line('Tellthemwhat'));
                                        } else echo "Tell them what it’s like to have you as a guest or host: What’s your style traveling? hosting?"; ?></p>
                                    <p><?php if ($this->lang->line('Dyouhave') != '') {
                                            echo stripslashes($this->lang->line('Dyouhave'));
                                        } else echo "Tell them about you: Do you have a life motto?"; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php if ($this->lang->line('Optional') != '') {
                                echo stripslashes($this->lang->line('Optional'));
                            } else echo "Optional"; ?></div>
                        <div class="panel-body">
                            <div class="formList">
                                <label><?php if ($this->lang->line('School') != '') {
                                        echo stripslashes($this->lang->line('School'));
                                    } else echo "School"; ?></label>
                                <div class="right">
                                    <?php
                                    $school = "";
                                    if ($this->lang->line('where_did_your_schooling') != '') {
                                        $schoolPlaceholder = stripslashes($this->lang->line('where_did_your_schooling'));
                                    } else $schoolPlaceholder = "Where did your schooling";
                                    if (!empty($userDetails)) $school = $userDetails->row()->school;
                                    echo form_input('school', $school, array('placeholder' => $schoolPlaceholder,'maxLength'=>'40'));
                                    ?>
                                </div>
                            </div>
                            <div class="formList">
                                <label><?php if ($this->lang->line('Work') != '') {
                                        echo stripslashes($this->lang->line('Work'));
                                    } else echo "Work"; ?></label>
                                <div class="right">
                                    <?php
                                    $work = "";
                                    if ($this->lang->line('your_working_place') != '') {
                                        $workPlaceholder = stripslashes($this->lang->line('your_working_place'));
                                    } else $workPlaceholder = "Your working place";
                                    if (!empty($userDetails)) $work = $userDetails->row()->work;
                                    echo form_input('work', $work, array('placeholder' => $workPlaceholder,'maxLength'=>'40'));
                                    ?>
                                </div>
                            </div>
                            <div class="formList">
                                <label><?php if ($this->lang->line('TimeZone') != '') {
                                        echo stripslashes($this->lang->line('TimeZone'));
                                    } else echo "Time Zone"; ?> </label>
                                <div class="right">
                                    <select name="timezone">
                                        <option value=""><?php if ($this->lang->line('select') != '') {
                                                echo stripslashes($this->lang->line('select'));
                                            } else echo "Select"; ?></option>
                                        <option value="International Date Line West"
                                                <?php if ($userDetails->row()->timezone == 'International Date Line West'){ ?>selected="selected"<?php } ?>>
                                            (GMT-11:00) International Date Line West
                                        </option>
                                        <option value="Midway Island"
                                                <?php if ($userDetails->row()->timezone == 'Midway Island'){ ?>selected="selected"<?php } ?>>
                                            (GMT-11:00) Midway Island
                                        </option>
                                        <option value="Samoa"
                                                <?php if ($userDetails->row()->timezone == 'Samoa'){ ?>selected="selected"<?php } ?>>
                                            (GMT-11:00) Samoa
                                        </option>
                                        <option value="Hawaii"
                                                <?php if ($userDetails->row()->timezone == 'Hawaii'){ ?>selected="selected"<?php } ?>>
                                            (GMT-10:00) Hawaii
                                        </option>
                                        <option value="Alaska"
                                                <?php if ($userDetails->row()->timezone == 'Alaska'){ ?>selected="selected"<?php } ?>>
                                            (GMT-09:00) Alaska
                                        </option>
                                        <option value="America/Los_Angeles"
                                                <?php if ($userDetails->row()->timezone == 'America/Los_Angeles'){ ?>selected="selected"<?php } ?>>
                                            (GMT-08:00) America/Los_Angeles
                                        </option>
                                        <option value="Pacific Time (US &amp; Canada)"
                                                <?php if ($userDetails->row()->timezone == 'Pacific Time (US &amp; Canada)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-08:00) Pacific Time (US &amp; Canada)
                                        </option>
                                        <option value="Tijuana"
                                                <?php if ($userDetails->row()->timezone == 'Tijuana'){ ?>selected="selected"<?php } ?>>
                                            (GMT-08:00) Tijuana
                                        </option>
                                        <option value="Arizona"
                                                <?php if ($userDetails->row()->timezone == 'Arizona'){ ?>selected="selected"<?php } ?>>
                                            (GMT-07:00) Arizona
                                        </option>
                                        <option value="Chihuahua"
                                                <?php if ($userDetails->row()->timezone == 'Chihuahua'){ ?>selected="selected"<?php } ?>>
                                            (GMT-07:00) Chihuahua
                                        </option>
                                        <option value="Mazatlan"
                                                <?php if ($userDetails->row()->timezone == 'Mazatlan'){ ?>selected="selected"<?php } ?>>
                                            (GMT-07:00) Mazatlan
                                        </option>
                                        <option value="Mountain Time (US and Canada)"
                                                <?php if ($userDetails->row()->timezone == 'Mountain Time (US and Canada)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-07:00) Mountain Time (US and Canada)
                                        </option>
                                        <option value="Central America"
                                                <?php if ($userDetails->row()->timezone == 'Central America'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Central America
                                        </option>
                                        <option value="Central Time (US and Canada)"
                                                <?php if ($userDetails->row()->timezone == 'Central Time (US and Canada)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Central Time (US and Canada)
                                        </option>
                                        <option value="Guadalajara"
                                                <?php if ($userDetails->row()->timezone == 'Guadalajara'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Guadalajara
                                        </option>
                                        <option value="Mexico City"
                                                <?php if ($userDetails->row()->timezone == 'Mexico City'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Mexico City
                                        </option>
                                        <option value="Monterrey"
                                                <?php if ($userDetails->row()->timezone == 'Monterrey'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Monterrey
                                        </option>
                                        <option value="Saskatchewan"
                                                <?php if ($userDetails->row()->timezone == 'Saskatchewan'){ ?>selected="selected"<?php } ?>>
                                            (GMT-06:00) Saskatchewan
                                        </option>
                                        <option value="America/Montreal"
                                                <?php if ($userDetails->row()->timezone == 'America/Montreal'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) America/Montreal
                                        </option>
                                        <option value="America/New_York"
                                                <?php if ($userDetails->row()->timezone == 'America/New_York'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) America/New_York
                                        </option>
                                        <option value="America/Toronto"
                                                <?php if ($userDetails->row()->timezone == 'America/Toronto'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) America/Toronto
                                        </option>
                                        <option value="Bogota"
                                                <?php if ($userDetails->row()->timezone == 'Bogota'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) Bogota
                                        </option>
                                        <option value="Eastern Time (US and Canada)"
                                                <?php if ($userDetails->row()->timezone == 'Eastern Time (US and Canada)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) Eastern Time (US and Canada)
                                        </option>
                                        <option value="Indiana (East)"
                                                <?php if ($userDetails->row()->timezone == 'Indiana (East)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) Indiana (East)
                                        </option>
                                        <option value="Lima"
                                                <?php if ($userDetails->row()->timezone == 'Lima'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) Lima
                                        </option>
                                        <option value="Quito"
                                                <?php if ($userDetails->row()->timezone == 'Quito'){ ?>selected="selected"<?php } ?>>
                                            (GMT-05:00) Quito
                                        </option>
                                        <option value="Caracas"
                                                <?php if ($userDetails->row()->timezone == 'Caracas'){ ?>selected="selected"<?php } ?>>
                                            (GMT-04:30) Caracas
                                        </option>
                                        <option value="Atlantic Time (Canada)"
                                                <?php if ($userDetails->row()->timezone == 'Atlantic Time (Canada)'){ ?>selected="selected"<?php } ?>>
                                            (GMT-04:00) Atlantic Time (Canada)
                                        </option>
                                        <option value="Georgetown"
                                                <?php if ($userDetails->row()->timezone == 'Georgetown'){ ?>selected="selected"<?php } ?>>
                                            (GMT-04:00) Georgetown
                                        </option>
                                        <option value="La Paz"
                                                <?php if ($userDetails->row()->timezone == 'La Paz'){ ?>selected="selected"<?php } ?>>
                                            (GMT-04:00) La Paz
                                        </option>
                                        <option value="Santiago"
                                                <?php if ($userDetails->row()->timezone == 'Santiago'){ ?>selected="selected"<?php } ?>>
                                            (GMT-04:00) Santiago
                                        </option>
                                        <option value="Newfoundland"
                                                <?php if ($userDetails->row()->timezone == 'Newfoundland'){ ?>selected="selected"<?php } ?>>
                                            (GMT-03:30) Newfoundland
                                        </option>
                                        <option value="Brasilia"
                                                <?php if ($userDetails->row()->timezone == 'Brasilia'){ ?>selected="selected"<?php } ?>>
                                            (GMT-03:00) Brasilia
                                        </option>
                                        <option value="Buenos Aires"
                                                <?php if ($userDetails->row()->timezone == 'Buenos Aires'){ ?>selected="selected"<?php } ?>>
                                            (GMT-03:00) Buenos Aires
                                        </option>
                                        <option value="Greenland"
                                                <?php if ($userDetails->row()->timezone == 'Greenland'){ ?>selected="selected"<?php } ?>>
                                            (GMT-03:00) Greenland
                                        </option>
                                        <option value="Mid-Atlantic"
                                                <?php if ($userDetails->row()->timezone == 'Mid-Atlantic'){ ?>selected="selected"<?php } ?>>
                                            (GMT-02:00) Mid-Atlantic
                                        </option>
                                        <option value="Azores"
                                                <?php if ($userDetails->row()->timezone == 'Azores'){ ?>selected="selected"<?php } ?>>
                                            (GMT-01:00) Azores
                                        </option>
                                        <option value="Cape Verde Is."
                                                <?php if ($userDetails->row()->timezone == 'Cape Verde Is.'){ ?>selected="selected"<?php } ?>>
                                            (GMT-01:00) Cape Verde Is.
                                        </option>
                                        <option value="Casablanca"
                                                <?php if ($userDetails->row()->timezone == 'Casablanca'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) Casablanca
                                        </option>
                                        <option value="Dublin"
                                                <?php if ($userDetails->row()->timezone == 'Dublin'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) Dublin
                                        </option>
                                        <option value="Edinburgh"
                                                <?php if ($userDetails->row()->timezone == 'Edinburgh'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) Edinburgh
                                        </option>
                                        <option value="Lisbon"
                                                <?php if ($userDetails->row()->timezone == 'Lisbon'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) Lisbon
                                        </option>
                                        <option value="London"
                                                <?php if ($userDetails->row()->timezone == 'London'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) London
                                        </option>
                                        <option value="Monrovia"
                                                <?php if ($userDetails->row()->timezone == 'Monrovia'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) Monrovia
                                        </option>
                                        <option value="UTC"
                                                <?php if ($userDetails->row()->timezone == 'UTC'){ ?>selected="selected"<?php } ?>>
                                            (GMT+00:00) UTC
                                        </option>
                                        <option value="Amsterdam"
                                                <?php if ($userDetails->row()->timezone == 'Amsterdam'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Amsterdam
                                        </option>
                                        <option value="Belgrade"
                                                <?php if ($userDetails->row()->timezone == 'Belgrade'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Belgrade
                                        </option>
                                        <option value="Berlin"
                                                <?php if ($userDetails->row()->timezone == 'Berlin'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Berlin
                                        </option>
                                        <option value="Bern"
                                                <?php if ($userDetails->row()->timezone == 'Bern'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Bern
                                        </option>
                                        <option value="Bratislava"
                                                <?php if ($userDetails->row()->timezone == 'Bratislava'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Bratislava
                                        </option>
                                        <option value="Brussels"
                                                <?php if ($userDetails->row()->timezone == 'Brussels'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Brussels
                                        </option>
                                        <option value="Budapest"
                                                <?php if ($userDetails->row()->timezone == 'Budapest'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Budapest
                                        </option>
                                        <option value="Copenhagen"
                                                <?php if ($userDetails->row()->timezone == 'Copenhagen'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Copenhagen
                                        </option>
                                        <option value="Europe/Amsterdam"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Amsterdam'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Amsterdam
                                        </option>
                                        <option value="Europe/Berlin"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Berlin'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Berlin
                                        </option>
                                        <option value="Europe/Copenhagen"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Copenhagen'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Copenhagen
                                        </option>
                                        <option value="Europe/Madrid"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Madrid'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Madrid
                                        </option>
                                        <option value="Europe/Paris"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Paris'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Paris
                                        </option>
                                        <option value="Europe/Rome"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Rome'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Rome
                                        </option>
                                        <option value="Europe/Zagreb"
                                                <?php if ($userDetails->row()->timezone == 'Europe/Zagreb'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Europe/Zagreb
                                        </option>
                                        <option value="Ljubljana"
                                                <?php if ($userDetails->row()->timezone == 'Ljubljana'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Ljubljana
                                        </option>
                                        <option value="Madrid"
                                                <?php if ($userDetails->row()->timezone == 'Madrid'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Madrid
                                        </option>
                                        <option value="Paris"
                                                <?php if ($userDetails->row()->timezone == 'Paris'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Paris
                                        </option>
                                        <option value="Prague"
                                                <?php if ($userDetails->row()->timezone == 'Prague'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Prague
                                        </option>
                                        <option value="Rome"
                                                <?php if ($userDetails->row()->timezone == 'Rome'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Rome
                                        </option>
                                        <option value="Sarajevo"
                                                <?php if ($userDetails->row()->timezone == 'Sarajevo'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Sarajevo
                                        </option>
                                        <option value="Skopje"
                                                <?php if ($userDetails->row()->timezone == 'Skopje'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Skopje
                                        </option>
                                        <option value="Stockholm"
                                                <?php if ($userDetails->row()->timezone == 'Stockholm'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Stockholm
                                        </option>
                                        <option value="Vienna"
                                                <?php if ($userDetails->row()->timezone == 'Vienna'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Vienna
                                        </option>
                                        <option value="Warsaw"
                                                <?php if ($userDetails->row()->timezone == 'Warsaw'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Warsaw
                                        </option>
                                        <option value="West Central Africa"
                                                <?php if ($userDetails->row()->timezone == 'West Central Africa'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) West Central Africa
                                        </option>
                                        <option value="Zagreb"
                                                <?php if ($userDetails->row()->timezone == 'Zagreb'){ ?>selected="selected"<?php } ?>>
                                            (GMT+01:00) Zagreb
                                        </option>
                                        <option value="Asia/Jerusalem"
                                                <?php if ($userDetails->row()->timezone == 'Asia/Jerusalem'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Asia/Jerusalem
                                        </option>
                                        <option value="Athens"
                                                <?php if ($userDetails->row()->timezone == 'Athens'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Athens
                                        </option>
                                        <option value="Bucharest"
                                                <?php if ($userDetails->row()->timezone == 'Bucharest'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Bucharest
                                        </option>
                                        <option value="Cairo"
                                                <?php if ($userDetails->row()->timezone == 'Cairo'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Cairo
                                        </option>
                                        <option value="Harare"
                                                <?php if ($userDetails->row()->timezone == 'Harare'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Harare
                                        </option>
                                        <option value="Helsinki"
                                                <?php if ($userDetails->row()->timezone == 'Helsinki'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Helsinki
                                        </option>
                                        <option value="Istanbul"
                                                <?php if ($userDetails->row()->timezone == 'Istanbul'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Istanbul
                                        </option>
                                        <option value="Jerusalem"
                                                <?php if ($userDetails->row()->timezone == 'Jerusalem'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Jerusalem
                                        </option>
                                        <option value="Kyiv"
                                                <?php if ($userDetails->row()->timezone == 'Kyiv'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Kyiv
                                        </option>
                                        <option value="Pretoria"
                                                <?php if ($userDetails->row()->timezone == 'Pretoria'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Pretoria
                                        </option>
                                        <option value="Riga"
                                                <?php if ($userDetails->row()->timezone == 'Riga'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Riga
                                        </option>
                                        <option value="Sofia"
                                                <?php if ($userDetails->row()->timezone == 'Sofia'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Sofia
                                        </option>
                                        <option value="Tallinn"
                                                <?php if ($userDetails->row()->timezone == 'Tallinn'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Tallinn
                                        </option>
                                        <option value="Vilnius"
                                                <?php if ($userDetails->row()->timezone == 'Vilnius'){ ?>selected="selected"<?php } ?>>
                                            (GMT+02:00) Vilnius
                                        </option>
                                        <option value="Baghdad"
                                                <?php if ($userDetails->row()->timezone == 'Baghdad'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:00) Baghdad
                                        </option>
                                        <option value="Kuwait"
                                                <?php if ($userDetails->row()->timezone == 'Kuwait'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:00) Kuwait
                                        </option>
                                        <option value="Minsk"
                                                <?php if ($userDetails->row()->timezone == 'Minsk'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:00) Minsk
                                        </option>
                                        <option value="Nairobi"
                                                <?php if ($userDetails->row()->timezone == 'Nairobi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:00) Nairobi
                                        </option>
                                        <option value="Riyadh"
                                                <?php if ($userDetails->row()->timezone == 'Riyadh'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:00) Riyadh
                                        </option>
                                        <option value="Tehran"
                                                <?php if ($userDetails->row()->timezone == 'Tehran'){ ?>selected="selected"<?php } ?>>
                                            (GMT+03:30) Tehran
                                        </option>
                                        <option value="Abu Dhabi"
                                                <?php if ($userDetails->row()->timezone == 'Abu Dhabi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Abu Dhabi
                                        </option>
                                        <option value="Baku"
                                                <?php if ($userDetails->row()->timezone == 'Baku'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Baku
                                        </option>
                                        <option value="Moscow"
                                                <?php if ($userDetails->row()->timezone == 'Moscow'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Moscow
                                        </option>
                                        <option value="Muscat"
                                                <?php if ($userDetails->row()->timezone == 'Muscat'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Muscat
                                        </option>
                                        <option value="St. Petersburg"
                                                <?php if ($userDetails->row()->timezone == 'St. Petersburg'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) St. Petersburg
                                        </option>
                                        <option value="Tbilisi"
                                                <?php if ($userDetails->row()->timezone == 'Tbilisi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Tbilisi
                                        </option>
                                        <option value="Volgograd"
                                                <?php if ($userDetails->row()->timezone == 'Volgograd'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Volgograd
                                        </option>
                                        <option value="Yerevan"
                                                <?php if ($userDetails->row()->timezone == 'Yerevan'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:00) Yerevan
                                        </option>
                                        <option value="Kabul"
                                                <?php if ($userDetails->row()->timezone == 'Kabul'){ ?>selected="selected"<?php } ?>>
                                            (GMT+04:30) Kabul
                                        </option>
                                        <option value="Islamabad"
                                                <?php if ($userDetails->row()->timezone == 'Islamabad'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:00) Islamabad
                                        </option>
                                        <option value="Karachi"
                                                <?php if ($userDetails->row()->timezone == 'Karachi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:00) Karachi
                                        </option>
                                        <option value="Tashkent"
                                                <?php if ($userDetails->row()->timezone == 'Tashkent'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:00) Tashkent
                                        </option>
                                        <option value="Chennai"
                                                <?php if ($userDetails->row()->timezone == 'Chennai'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:30) Chennai
                                        </option>
                                        <option value="Kolkata"
                                                <?php if ($userDetails->row()->timezone == 'Kolkata'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:30) Kolkata
                                        </option>
                                        <option value="Mumbai"
                                                <?php if ($userDetails->row()->timezone == 'Mumbai'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:30) Mumbai
                                        </option>
                                        <option value="New Delhi"
                                                <?php if ($userDetails->row()->timezone == 'New Delhi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:30) New Delhi
                                        </option>
                                        <option value="Sri Jayawardenepura"
                                                <?php if ($userDetails->row()->timezone == 'Sri Jayawardenepura'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:30) Sri Jayawardenepura
                                        </option>
                                        <option value="Kathmandu"
                                                <?php if ($userDetails->row()->timezone == 'Kathmandu'){ ?>selected="selected"<?php } ?>>
                                            (GMT+05:45) Kathmandu
                                        </option>
                                        <option value="Almaty"
                                                <?php if ($userDetails->row()->timezone == 'Almaty'){ ?>selected="selected"<?php } ?>>
                                            (GMT+06:00) Almaty
                                        </option>
                                        <option value="Astana"
                                                <?php if ($userDetails->row()->timezone == 'Astana'){ ?>selected="selected"<?php } ?>>
                                            (GMT+06:00) Astana
                                        </option>
                                        <option value="Dhaka"
                                                <?php if ($userDetails->row()->timezone == 'Dhaka'){ ?>selected="selected"<?php } ?>>
                                            (GMT+06:00) Dhaka
                                        </option>
                                        <option value="Ekaterinburg"
                                                <?php if ($userDetails->row()->timezone == 'Ekaterinburg'){ ?>selected="selected"<?php } ?>>
                                            (GMT+06:00) Ekaterinburg
                                        </option>
                                        <option value="Rangoon"
                                                <?php if ($userDetails->row()->timezone == 'Rangoon'){ ?>selected="selected"<?php } ?>>
                                            (GMT+06:30) Rangoon
                                        </option>
                                        <option value="Bangkok"
                                                <?php if ($userDetails->row()->timezone == 'Bangkok'){ ?>selected="selected"<?php } ?>>
                                            (GMT+07:00) Bangkok
                                        </option>
                                        <option value="Hanoi"
                                                <?php if ($userDetails->row()->timezone == 'Hanoi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+07:00) Hanoi
                                        </option>
                                        <option value="Jakarta"
                                                <?php if ($userDetails->row()->timezone == 'Jakarta'){ ?>selected="selected"<?php } ?>>
                                            (GMT+07:00) Jakarta
                                        </option>
                                        <option value="Novosibirsk"
                                                <?php if ($userDetails->row()->timezone == 'Novosibirsk'){ ?>selected="selected"<?php } ?>>
                                            (GMT+07:00) Novosibirsk
                                        </option>
                                        <option value="Asia/Makassar"
                                                <?php if ($userDetails->row()->timezone == 'Asia/Makassar'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Asia/Makassar
                                        </option>
                                        <option value="Beijing"
                                                <?php if ($userDetails->row()->timezone == 'Beijing'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Beijing
                                        </option>
                                        <option value="Chongqing"
                                                <?php if ($userDetails->row()->timezone == 'Chongqing'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Chongqing
                                        </option>
                                        <option value="Hong Kong"
                                                <?php if ($userDetails->row()->timezone == 'Hong Kong'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Hong Kong
                                        </option>
                                        <option value="Krasnoyarsk"
                                                <?php if ($userDetails->row()->timezone == 'Krasnoyarsk'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Krasnoyarsk
                                        </option>
                                        <option value="Kuala Lumpur"
                                                <?php if ($userDetails->row()->timezone == 'Kuala Lumpur'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Kuala Lumpur
                                        </option>
                                        <option value="Perth"
                                                <?php if ($userDetails->row()->timezone == 'Perth'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Perth
                                        </option>
                                        <option value="Singapore"
                                                <?php if ($userDetails->row()->timezone == 'Singapore'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Singapore
                                        </option>
                                        <option value="Taipei"
                                                <?php if ($userDetails->row()->timezone == 'Taipei'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Taipei
                                        </option>
                                        <option value="Ulaan Bataar"
                                                <?php if ($userDetails->row()->timezone == 'Ulaan Bataar'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Ulaan Bataar
                                        </option>
                                        <option value="Urumqi"
                                                <?php if ($userDetails->row()->timezone == 'Urumqi'){ ?>selected="selected"<?php } ?>>
                                            (GMT+08:00) Urumqi
                                        </option>
                                        <option value="Irkutsk"
                                                <?php if ($userDetails->row()->timezone == 'Irkutsk'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:00) Irkutsk
                                        </option>
                                        <option value="Osaka"
                                                <?php if ($userDetails->row()->timezone == 'Osaka'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:00) Osaka
                                        </option>
                                        <option value="Sapporo"
                                                <?php if ($userDetails->row()->timezone == 'Sapporo'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:00) Sapporo
                                        </option>
                                        <option value="Seoul"
                                                <?php if ($userDetails->row()->timezone == 'Seoul'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:00) Seoul
                                        </option>
                                        <option value="Tokyo"
                                                <?php if ($userDetails->row()->timezone == 'Tokyo'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:00) Tokyo
                                        </option>
                                        <option value="Adelaide"
                                                <?php if ($userDetails->row()->timezone == 'Adelaide'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:30) Adelaide
                                        </option>
                                        <option value="Darwin"
                                                <?php if ($userDetails->row()->timezone == 'Darwin'){ ?>selected="selected"<?php } ?>>
                                            (GMT+09:30) Darwin
                                        </option>
                                        <option value="Brisbane"
                                                <?php if ($userDetails->row()->timezone == 'Brisbane'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Brisbane
                                        </option>
                                        <option value="Canberra"
                                                <?php if ($userDetails->row()->timezone == 'Canberra'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Canberra
                                        </option>
                                        <option value="Guam"
                                                <?php if ($userDetails->row()->timezone == 'Guam'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Guam
                                        </option>
                                        <option value="Hobart"
                                                <?php if ($userDetails->row()->timezone == 'Hobart'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Hobart
                                        </option>
                                        <option value="Melbourne"
                                                <?php if ($userDetails->row()->timezone == 'Melbourne'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Melbourne
                                        </option>
                                        <option value="Port Moresby"
                                                <?php if ($userDetails->row()->timezone == 'Port Moresby'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Port Moresby
                                        </option>
                                        <option value="Sydney"
                                                <?php if ($userDetails->row()->timezone == 'Sydney'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Sydney
                                        </option>
                                        <option value="Yakutsk"
                                                <?php if ($userDetails->row()->timezone == 'Yakutsk'){ ?>selected="selected"<?php } ?>>
                                            (GMT+10:00) Yakutsk
                                        </option>
                                        <option value="New Caledonia"
                                                <?php if ($userDetails->row()->timezone == 'New Caledonia'){ ?>selected="selected"<?php } ?>>
                                            (GMT+11:00) New Caledonia
                                        </option>
                                        <option value="Vladivostok"
                                                <?php if ($userDetails->row()->timezone == 'Vladivostok'){ ?>selected="selected"<?php } ?>>
                                            (GMT+11:00) Vladivostok
                                        </option>
                                        <option value="Auckland"
                                                <?php if ($userDetails->row()->timezone == 'Auckland'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Auckland
                                        </option>
                                        <option value="Fiji"
                                                <?php if ($userDetails->row()->timezone == 'Fiji'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Fiji
                                        </option>
                                        <option value="Kamchatka"
                                                <?php if ($userDetails->row()->timezone == 'Kamchatka'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Kamchatka
                                        </option>
                                        <option value="Magadan"
                                                <?php if ($userDetails->row()->timezone == 'Magadan'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Magadan
                                        </option>
                                        <option value="Marshall Is."
                                                <?php if ($userDetails->row()->timezone == 'Marshall Is.'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Marshall Is.
                                        </option>
                                        <option value="Solomon Is."
                                                <?php if ($userDetails->row()->timezone == 'Solomon Is.'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Solomon Is.
                                        </option>
                                        <option value="Wellington"
                                                <?php if ($userDetails->row()->timezone == 'Wellington'){ ?>selected="selected"<?php } ?>>
                                            (GMT+12:00) Wellington
                                        </option>
                                        <option value="Nuku'alofa"
                                                <?php if ($userDetails->row()->timezone == "Nuku'alofa"){ ?>selected="selected"<?php } ?>>
                                            (GMT+13:00) Nuku'alofa
                                        </option>
                                    </select>
                                    <p><?php if ($this->lang->line('Yourhometime') != '') {
                                            echo stripslashes($this->lang->line('Yourhometime'));
                                        } else echo "Your home time zone."; ?></p>
                                </div>
                            </div>
                            <div class="formList">
							
                                <label><?php if ($this->lang->line('Language') != '') {
                                            echo stripslashes($this->lang->line('Language'));
                                        } else echo "Language"; ?></label>
                                <div class="right">
                                    <?php
                                    $languages_known_user = explode(',', $userDetails->row()->languages_known);
                                    if (count($languages_known_user) > 0) { ?>
                                        <ul class="languageList" id="knownLanguages">
                                            <?php
                                            foreach ($languages_known->result() as $language) {
                                                if (in_array($language->language_code, $languages_known_user)) {
                                                    ?>
                                                    <li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name; ?>
                                                        <span onclick="delete_languages(this,'<?php echo $language->language_code; ?>')">X</span>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </ul>
                                    <?php } ?>
                                    <div class="addLang" data-toggle="modal" data-target="#addLanguage"><span
                                                class="number_s120">+</span><a
                                                href="javascript:void(0)"> <?php if ($this->lang->line('AddMore') != '') {
                                                echo stripslashes($this->lang->line('AddMore'));
                                            } else echo "Add More"; ?></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($this->lang->line('Save') != '') {
                        $btnValue = stripslashes($this->lang->line('Save'));
                    } else $btnValue = "Save";
                    echo form_button('save', $btnValue, array('onclick' => 'update_profile();','class' => 'submitBtn1'));
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Add Language Modal -->
    <div id="addLanguage" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="mHead"><?php if ($this->lang->line('SpokenLanguages') != '') {
                            echo stripslashes($this->lang->line('SpokenLanguages'));
                        } else echo "Spoken Languages"; ?></h2>
                </div>
                <div class="modal-body">
                    <p><?php if ($this->lang->line('Whatlanguages') != '') {
                            echo stripslashes($this->lang->line('Whatlanguages'));
                        } else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language."; ?></p>
                    <div class="clear allLang">
                        <?php
                        $languages_knowns = explode(',', $userDetails->row()->languages_known);
                        foreach ($languages_known->result() as $language) {
                            ?>
                            <label>

					<span class="checkboxStyle">

						<input type="checkbox" <?php if (in_array($language->language_code, $languages_knowns)) { ?> checked="checked" <?php } ?>
                               name="languages[]" value="<?php echo $language->language_code ?>" class="hideTemp"
                               alt="<?php echo $language->language_name; ?>">

		    			<i class="fa fa-check" aria-hidden="true"></i>

		    		</span>
                                <div class=""><?php echo $language->language_name; ?></div>
                            </label>
                            <?php
                        }
                        ?>
                    </div>
                    <input type="button" class="submitBtn1" id="language_ajax" data-dismiss="modal"
                           value="<?php if ($this->lang->line('Save') != '') {
                               echo stripslashes($this->lang->line('Save'));
                           } else echo "Save"; ?>" name="">
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#language_ajax').click(function () {
                var languages = document.getElementsByName('languages[]');
                var languages_known = new Array();
                for (var i = 0; i < languages.length; i++) {
                    if ($(languages[i]).is(':checked')) {
                        languages_known.push(languages[i].value);
                    }
                }
                if (languages_known.length > 0) {
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url()?>site/user_settings/update_languages',
                        data: {languages_known: languages_known},
                        success: function (response) {
                            $('#knownLanguages').html(response.trim());
                        }
                    });
                }
            })
        });

        function delete_languages(elem, language_code) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>site/user_settings/delete_languages',
                data: {language_code: language_code},
                dataType: 'json',
                success: function (response) {
                    if (response['status_code'] == 1) {
                        $(elem).closest('li').remove();
                    }
                }
            });
        }

        function update_profile(){
            var first_name = $("#firstname").val();
            if(first_name == ''){
                    $('#firstname_err').show();
                    $('#firstname_err').html('Please enter the valid First name');
                    $('html, body').animate({
                        'scrollTop' : $("#firstname_err").position().top
                    });
                    return false;
            } else{
                //   alert('Please Enter Your Riding Year');
                 $('.loading').show();
                $('#firstname_err').show();
                $('#riding_year_err').hide();
                $('#firstname_err').html('');
                $('#update_profile').submit();
            }
        }
    </script>
<?php
$this->load->view('site/includes/footer');
?>