<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
    <section>
        <div class="container">
            <div class="dashboard loggedIn clear">
                <div class="col-sm-3 width20">
                    <ul class="sideBarMenu">
                        <?php if($userDetails->row()->group == 'Seller'){ ?> 
						<li>
                            <a href="<?php echo base_url(); ?>account-payout" <?php if ($this->uri->segment(1) == 'account-payout') echo 'class="active"'; ?>><?php if ($this->lang->line('PayoutPreferences') != '') { echo stripslashes($this->lang->line('PayoutPreferences')); } else echo "Payout Preferences"; ?></a></li>
						<?php } ?>
					    <li>
                            <a href="<?php echo base_url(); ?>account-trans" <?php if ($this->uri->segment(1) == 'account-trans') echo 'class="active"'; ?>><?php if ($this->lang->line('TransactionHistory') != '') { echo stripslashes($this->lang->line('TransactionHistory')); } else echo "Transaction History"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>account-security" <?php if ($this->uri->segment(1) == 'account-security') echo 'class="active"'; ?>><?php if ($this->lang->line('Security') != '') { echo stripslashes($this->lang->line('Security')); } else echo "Security"; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url(); ?>account-setting" <?php if ($this->uri->segment(1) == 'account-setting') echo 'class="active"'; ?>><?php if ($this->lang->line('settings_new') != '') { echo stripslashes($this->lang->line('settings_new')); } else echo "Settings"; ?></a>
                        </li>
                        <?php /* <li>
                            <a href="<?php echo base_url(); ?>your-wallet" <?php if ($this->uri->segment(1) == 'your-wallet') echo 'class="active"'; ?>><?php if ($this->lang->line('your_wallet') != '') { echo stripslashes($this->lang->line('your_wallet')); } else echo "Your Wallet"; ?></a></li>  */?>
                    </ul>
                </div>
                <div class="col-sm-9 width80">
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php if ($this->lang->line('PayoutMethods') != '') {
                                echo stripslashes($this->lang->line('PayoutMethods'));
                            } else echo "Payout Methods"; ?></div>
                        <div class="panel-body">
                            <?php if ($userpay->row()->accname == '') { ?>
                                <a href="#" data-toggle="modal" data-target="#editPayout_M">
                                    <?php if ($this->lang->line('add_payout_method') != '') {
                                        echo stripslashes($this->lang->line('add_payout_method'));
                                    } else echo "Add Payout Method"; ?></a>
                            <?php } else { ?>
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th><?php if ($this->lang->line('stripe_acc_name') != '') {
                                                echo stripslashes($this->lang->line('stripe_acc_name'));
                                            } else echo "Stripe Account User Name"; ?></th>
                                        <th><?php if ($this->lang->line('AccountNumber') != '') {
                                                echo stripslashes($this->lang->line('AccountNumber'));
                                            } else echo "Account Number"; ?></th>
                                        <?php /* <th><?php if ($this->lang->line('stripe_acc_name') != '') {
                                                echo stripslashes($this->lang->line('stripe_acc_name'));
                                            } else echo "Stripe Account User Name"; ?></th>
                                        <th><?php if ($this->lang->line('Paypal_Email') != '') {
                                                echo stripslashes($this->lang->line('Paypal_Email'));
                                            } else echo " Paypal Email"; ?></th> */?> 
                                        
                                        <th><?php if ($this->lang->line('settings_new') != '') {
                                                echo stripslashes($this->lang->line('settings_new'));
                                            } else echo "Settings"; ?></th>
                                    </tr>
                                    <tr>
                                        <td><?php echo $userpay->row()->accname; ?></td>
                                        <td><?php echo $userpay->row()->accno; ?></td>
                                       <!-- <td><?php echo $userpay->row()->bankname; ?></td>
                                        <td><?php echo $userpay->row()->paypal_email; ?></td>-->

                                        <td>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle" data-toggle="modal" data-target="#editPayout_M" type="button"><i
                                                            class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                <ul class="dropdown-menu sm">
                                                    <li><a href="#" data-toggle="modal"
                                                           data-target="#editPayout_M"><?php if ($this->lang->line('Edit') != '') { echo stripslashes($this->lang->line('Edit')); } else echo "Edit"; ?></a>  
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- EditPayout_M Modal -->
    <div id="editPayout_M" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h2 class="mHead"><?php if ($this->lang->line('AddPayoutDetails') != '') {
                            echo stripslashes($this->lang->line('AddPayoutDetails'));
                        } else echo "Add Payout Details"; ?></h2>
                </div>
                <div class="modal-body">
                    <?php echo form_open('site/user/account_update', array('class' => 'formFields', 'onsubmit' => 'return validate_form()')); ?>
                    <div class="form-group">
                        <label><?php if ($this->lang->line('stripe_acc_name') != '') {
                                echo stripslashes($this->lang->line('stripe_acc_name'));
                            } else echo "Stripe Account User Name"; ?></label>
                        <?php
                        if ($this->lang->line('account_name_here') != '') {
                            $accountNamePlaceHolder = stripslashes($this->lang->line('account_name_here'));
                        } else $accountNamePlaceHolder = "Account name here";
                        echo form_input('accname', $userpay->row()->accname, array('required' => 'required', 'id' => 'accname', 'placeholder' => $accountNamePlaceHolder));
                        echo form_hidden('hid', $userpay->row()->id, array('id' => 'hid'));
                        ?>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label><?php if ($this->lang->line(' Paypal_Email') != '') {
                                echo stripslashes($this->lang->line(' Paypal_Email'));
                            } else echo "  Paypal Email"; ?></label>
                        <?php
                        if ($this->lang->line('enter_paypal_email_here') != '') {
                            $accountNamePlaceHolder = stripslashes($this->lang->line('enter_paypal_email_here'));
                        } else $accountNamePlaceHolder = "Enter Paypal email here";
                        echo form_input('paypal_email', $userpay->row()->paypal_email, array('id' => 'paypal_email', 'required' => 'required', 'placeholder' => $accountNamePlaceHolder));
                        ?>
                        <small id="email_error" style="display: none;color: red;font-size: 12px;">Enter Valid Email</small>
                    </div>
                    <div class="form-group"style="display:none;">
                        <label><?php if ($this->lang->line('BankName') != '') {
                                echo stripslashes($this->lang->line('BankName'));
                            } else echo "Bank Name"; ?></label>
                        <?php
                        if ($this->lang->line('enter_bank_name_here') != '') {
                            $accountNamePlaceHolder = stripslashes($this->lang->line('enter_bank_name_here'));
                        } else $accountNamePlaceHolder = "Enter bank name here";
                        echo form_input('bankname', $userpay->row()->bankname, array('required' => 'required', 'id' => 'bankname', 'placeholder' => $accountNamePlaceHolder));
                        ?>
                    </div>
                    <div class="form-group">
                        <label><?php if ($this->lang->line('AccountNumber') != '') {
                                echo stripslashes($this->lang->line('AccountNumber'));
                            } else echo "Account Number"; ?></label>
                        <?php
                        if ($this->lang->line('account_number_here') != '') {
                            $accountNamePlaceHolder = stripslashes($this->lang->line('account_number_here'));
                        } else $accountNamePlaceHolder = "Account number here";
                        echo form_input('accno', $userpay->row()->accno, array('maxlength'=>'16','required' => 'required', 'id' => 'accno', 'placeholder' => $accountNamePlaceHolder));
                        ?>
                        <small id="account_number_error" style="display: none;color: red;font-size: 12px;">Enter Valid Account Number</small>
                    </div>

                   

                    <?php
                    if ($this->lang->line('Submit') != '') {
                        $btnValue = stripslashes($this->lang->line('Submit'));
                    } else $btnValue = "Submit";?>
                    <button type="submit" style="padding: 10px 60px;" id="update_button" name="submit" class="submitBtn1"><i id="spin" style="display: none;" class="fa fa-spinner fa-spin"></i><?php echo $btnValue; ?></button>
                    <?php
                   // echo form_submit('submit', $btnValue, array('class' => 'submitBtn1'));
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validate_form() {
            $('#spin').show();
                $('#update_button').prop('disabled', true);
            if ($("#accname").val() == "") {
                 $('#spin').hide();
                boot_alert("<?php if ($this->lang->line('enter_account_name') != '') {
                    echo stripslashes($this->lang->line('enter_account_name'));
                } else echo "Please enter the account name!";?>");
                $("#accname").focus();
                return false;
            }
            var accno = $("#accno").val();
            //alert(accno);
          
           if (isNaN(accno)) {
            $('#spin').hide();
             $('#update_button').prop('disabled', false);
$('#account_number_error').show();
return false;
           }

            else if ($("#accno").val() == "") {
                $('#spin').hide();
                 $('#update_button').prop('disabled', false);
                boot_alert("<?php if ($this->lang->line('enter_account_number') != '') {
                    echo stripslashes($this->lang->line('enter_account_number'));
                } else echo "Please enter the account number!";?>");
                $("#accno").focus();
                return false;
            }
            else if ($("#bankname").val() == "") {
                $('#spin').hide();
                 $('#update_button').prop('disabled', false);
                boot_alert("<?php if ($this->lang->line('enter_bank_name') != '') {
                    echo stripslashes($this->lang->line('enter_bank_name'));
                } else echo "Please enter the bank name!";?>");
                $("#bankname").focus();
                return false;
            }else if ($("#routing").val() == "") {
                $('#spin').hide();
                 $('#update_button').prop('disabled', false);
                boot_alert("Enter Routing");
                $("#routing").focus();
                return false;
            }
            var email = $('#paypal_email').val();
        
           if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email))
  {
     
   $('#account_update').submit();
  }
  else
  {
   $('#spin').hide();
   $('#update_button').prop('disabled', false);
   $('#email_error').show();
        
        return false;
  }
        }

        $("#accname").on('keyup', function (e) {
            var val = $(this).val();
            if (val.match(/[^a-zA-Z.\s]/g)) {
                document.getElementById("accname_error").style.display = "inline";
                $("#accname").focus();
                $("#accname_error").fadeOut(5000);
                $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
            }
        });
        $("#bankname").on('keyup', function (e) {
            var val = $(this).val();
            if (val.match(/[^a-zA-Z\s]/g)) {
                document.getElementById("bankname_error").style.display = "inline";
                $("#bankname").focus();
                $("#bankname_error").fadeOut(5000);
                $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
            }
        });
        $("#accno").on('keyup', function (e) {
            var val = $(this).val();
            if (val.match(/[^0-9-\s()]/g)) {
                document.getElementById("accno_error").style.display = "inline";
                $("#accno").focus();
                $("#accno_error").fadeOut(5000);
                $(this).val(val.replace(/[^0-9-\s()]/g, ''));
            }
        });
    </script>
<?php
$this->load->view('site/includes/footer');
?>