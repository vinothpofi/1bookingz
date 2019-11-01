<?php$this->load->view('site/includes/header');$this->load->view('site/includes/top_navigation_links');$currency_result = $this->session->userdata('currency_result');if ($this->lang->line('Please_enter_your_old_password') != '') {    $old_password = stripslashes($this->lang->line('Please_enter_your_old_password'));} else {    $old_password = "Please enter your old password";}if ($this->lang->line('Please_enter_your_new_passowrd') != '') {    $new_password = stripslashes($this->lang->line('Please_enter_your_new_passowrd'));} else {    $new_password = "Please enter your new passowrd";}if ($this->lang->line('Please_enter_confirm_password') != '') {    $confirm_password = stripslashes($this->lang->line('Please_enter_confirm_password'));} else {    $confirm_password = "Please enter confirm password";}if ($this->lang->line('Passwords_not_matching') != '') {    $pass_not_match = stripslashes($this->lang->line('Passwords_not_matching'));} else {    $pass_not_match = "Passwords not matching";}?>    <section>        <div class="container">            <div class="loggedIn clear">                <div class="width20">                    <ul class="sideBarMenu">						<?php if($userDetails->row()->group == 'Seller'){ ?>                         <li>                            <a href="<?php echo base_url(); ?>account-payout" <?php if ($this->uri->segment(1) == 'account-payout') echo 'class="active"'; ?>><?php if ($this->lang->line('PayoutPreferences') != '') { echo stripslashes($this->lang->line('PayoutPreferences')); } else echo "Payout Preferences"; ?></a></li>                        <?php } ?>						<li>                            <a href="<?php echo base_url(); ?>account-trans" <?php if ($this->uri->segment(1) == 'account-trans') echo 'class="active"'; ?>><?php if ($this->lang->line('TransactionHistory') != '') { echo stripslashes($this->lang->line('TransactionHistory')); } else echo "Transaction History"; ?></a></li>                        <li>                            <a href="<?php echo base_url(); ?>account-security" <?php if ($this->uri->segment(1) == 'account-security') echo 'class="active"'; ?>><?php if ($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security"; ?></a>                        </li>                        <li>                            <a href="<?php echo base_url(); ?>account-setting" <?php if ($this->uri->segment(1) == 'account-setting') echo 'class="active"'; ?>><?php if ($this->lang->line('Settings') != '') { echo stripslashes($this->lang->line('Settings')); } else echo "Settings"; ?></a>                        </li>                        <?php /* <li>                            <a href="<?php echo base_url(); ?>your-wallet" <?php if ($this->uri->segment(1) == 'your-wallet') echo 'class="active"'; ?>><?php if ($this->lang->line('your_wallet') != '') { echo stripslashes($this->lang->line('your_wallet')); } else echo "Your Wallet"; ?></a></li>  */?>                    </ul>                </div>                <div class="width80">                    <?php                    echo form_open('account-setting', array('onsubmit' => 'return validatePassword();'));                    ?>                    <div class="panel panel-default">                        <div class="panel-heading"><?php if ($this->lang->line('CountryofResidence') != '') {                                echo stripslashes($this->lang->line('CountryofResidence'));                            } else echo "Country of Residence"; ?></div>                        <div class="panel-body">                            <p class="text-danger text-center"                               id="ErrorMsg"><?php echo $this->session->flashdata('errorMsg'); ?></p>                            <p class="text-success text-center"><?php echo $this->session->flashdata('successMsg'); ?></p>                            <div class="formList">                                <label><?php if ($this->lang->line('CountryofResidence') != '') {                                        echo stripslashes($this->lang->line('CountryofResidence'));                                    } else echo "Country of Residence"; ?>:</label>                                <div class="right">                                    <?php                                    if ($this->lang->line('select') != '') {                                        $EmptyOption = stripslashes($this->lang->line('select'));                                    } else $EmptyOption = "Select";                                    $countryArray = array();                                    $countryArray[''] = $EmptyOption;                                    foreach ($countries->result() as $country) {                                        $countryArray[$country->id] = $country->name;                                    }                                    echo form_dropdown('country', $countryArray, $userDetails->row()->country, array('onchange' => 'changeButton()'));                                    ?>                                </div>                            </div>                        </div>                    </div>                    <?php                    if ($this->lang->line('ResidenceClicksave') != '') {                        $btnValue = stripslashes($this->lang->line('ResidenceClicksave'));                    } else $btnValue = "Save Country of Residence";                    if ($this->lang->line('CancelAccount') != '') {                        $cancelButton = stripslashes($this->lang->line('CancelAccount'));                    } else $cancelButton = "Cancel Account";                    echo form_submit('', $btnValue, array('class' => 'submitBtn1', 'disabled' => 'true', 'id' => 'change_button'));                    echo form_close();                    ?><br>                    <div class="panel panel-default">                        <div class="panel-heading"><?php if ($this->lang->line('CancelAccount') != '') {                                echo stripslashes($this->lang->line('CancelAccount'));                            } else echo "Cancel Account"; ?></div>                        <div class="panel-body">                            <?php                             $pr_details =  $this->db->query('SELECT * FROM ' . RENTALENQUIRY . ' WHERE renter_id="'.$userDetails->row()->id.'" AND approval="Pending"');                              $row_enq=$pr_details->num_rows();                            echo form_button('cancelAccount', $cancelButton, array('onclick' => 'checkConfirmation(this);','value'=>$row_enq, 'class' => 'submitBtn1'));                            ?>                        </div>                    </div>                </div>            </div>        </div>    </section>    <script>        function changeButton() {            $("#change_button").removeAttr('disabled');        }        function checkConfirmation(element) {if(element.value >= 1){    alert('You Have New Bookings In Your Property. Please Give Response..')}          else{                if (confirm("<?php if ($this->lang->line('want_to_cancel') != '') {                    echo stripslashes($this->lang->line('want_to_cancel'));                } else echo "Are You Sure Want to cancel your Account.?";?>"))             {                window.location.href = "site/cms/cancelmyaccount/<?php echo $userDetails->row()->id; ?>";            }        }        }    </script><?php$this->load->view('site/includes/footer');?>