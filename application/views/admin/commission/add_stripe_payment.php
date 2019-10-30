<?php
$this->load->view('admin/templates/header.php');
define("StripeDetails", $this->config->item('payment_1'));
$StripeValDet = unserialize(StripeDetails);
$StripeVal = $StripeValDet['status'];
$StripeValDet1 = unserialize($StripeValDet['settings']);
?>
    <div id="content">
        <div class="grid_container">
            <div class="grid_12">
                <div class="widget_wrap">
                    <div class="widget_top">
                        <span class="h_icon list"></span>
                        <h6><?php echo $heading; ?></h6>
                    </div>
                    <div class="widget_content">
                            <?php
                                $attributes = array('class' => 'form_container left_label', 'id' => 'credit_card_forms_stripe');
                                echo form_open_multipart('admin/commission/HostPaymentCreditStripe', $attributes)
                                ?>
                           <ul>     
                            <?php 
                                echo form_input(array('type' => 'text', 'name' => 'stripe_mode', 'id' => 'stripe_mode', 'value' => $StripeValDet1['mode']));
                                echo form_input(array('type' => 'text', 'name' => 'stripe_key', 'id' => 'stripe_key', 'value' => 'sk_test_ZeA08MNhppIpOIpfITFJb2FK'));
                                echo form_input(array('type' => 'text', 'name' => 'stripe_publish_key', 'id' => 'stripe_publish_key', 'value' => 'pk_test_VpXhyRzbBkw5BsytSDaf7Hto'));
                                echo form_input(array('type' => 'text', 'name' => 'total_price', 'id' => 'price_val_stripe', 'value' => '105.00'));                                                                                                                              //echo form_input(array('type' => 'text', 'name' => 'total_price', 'id' => 'price_val_stripe', 'value' =>  '388.59' ));
                                echo form_input(array('type' => 'text', 'name' => 'currencycode', 'id' => 'currencycode', 'value' => ''));
                                echo form_input(array('type' => 'text', 'name' => 'booking_rental_id', 'id' => 'booking_rental_id', 'value' => ''));
                                echo form_input(array('type' => 'hidden', 'name' => 'enquiryid', 'id' => 'enquiryid', 'value' => ''));
                                echo form_input(array('type' => 'text', 'name' => 'creditvalue', 'id' => 'creditvalue', 'value' => 'stripe'));
                                echo form_input(array('type' => 'text', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                               echo form_input(array('type' => 'text', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => ''));
                               ?>
                                            <p class="text-center text-success" id="loadingContainer"
                                               style="display: none;"><i
                                                        class="fa fa-spinner fa-spin fa-1x fa-fw"></i> <?php if ($this->lang->line('Please wait your transaction on process') != '') {
                                                    echo stripslashes($this->lang->line('Please wait your transaction on process'));
                                                } else echo "Please wait your transaction on process"; ?></p>
                                            <p class="text-center text-danger" id="StripePaymentErrors"
                                               style="display: none;"></p>
                                    <li>
                                        <div class="form_grid_12">
                                            <label><?php if ($this->lang->line('Card Type') != '') {
                                                    echo stripslashes($this->lang->line('Card Type'));
                                                } else echo "Card Type"; ?></label>
                                        <div class="form_input">
                                            <?php
                                            if ($this->lang->line('Visa') != '') {
                                                $visaLabel = stripslashes($this->lang->line('Visa'));
                                            } else $visaLabel = 'Visa';
                                            if ($this->lang->line('American Express') != '') {
                                                $AmexLabel = stripslashes($this->lang->line('American Express'));
                                            } else $AmexLabel = 'American Express';
                                            if ($this->lang->line('MasterCard') != '') {
                                                $MasterCardLabel = stripslashes($this->lang->line('MasterCard'));
                                            } else $MasterCardLabel = 'MasterCard';
                                            if ($this->lang->line('Discover') != '') {
                                                $DiscoverLabel = stripslashes($this->lang->line('Discover'));
                                            } else $DiscoverLabel = 'Discover';
                                            $CardOptions = array('Visa' => $visaLabel, 'Amex' => $AmexLabel, 'MasterCard' => $MasterCardLabel, 'Discover' => $DiscoverLabel);
                                            echo form_dropdown('cardType', $CardOptions, '', array('id' => 'cardType'));
                                            ?>
                                        </div>
                                        </div>
                                    </li>
                                    <li>   
                                      <div class="form_grid_12">     
                                        <label><?php if ($this->lang->line('Credit Card Number') != '') {
                                                    echo stripslashes($this->lang->line('Credit Card Number'));
                                                } else echo "Credit Card Number"; ?></label>
                                                
                                                <?php if ($this->lang->line('enter_credit_card_num') != '') {
                                                    $crdNum= stripslashes($this->lang->line('enter_credit_card_num'));
                                                } else $crdNum= "Enter Credit Card Number"; ?>
                                        <div class="form_input">    
                                            <?php
                                            echo form_input('cardNumber', '', array('placeholder' => "$crdNum", 'autocomplete' => 'off', 'id' => 'cardNumber', 'maxlength' => '16', 'data-stripe' => 'number'));
                                            ?>
                                        </div>
                                        </div>
                                    </li>
                                    <li>    
                                     <div class="form_grid_12">        
                                    <label class="col-sm-12">
                                        <?php if ($this->lang->line('Expiration Date') != '') {
                                                                echo stripslashes($this->lang->line('Expiration Date'));
                                                            } else echo "Expiration Date"; ?>
                                                                
                                    </label>
                                    <div class="form_input">
                                                    
                                                            <?php
                                                            $expriedMonth = array();
                                                            for ($i = 1; $i <= 12; $i++) {
                                                                $expriedMonth[$i] = $i;
                                                            }
                                                            echo form_dropdown('CCExpMonth', $expriedMonth, date('m'), array('id' => 'ExpMonth', 'data-stripe' => 'exp-month'));
                                                            ?>
                                                       
                                                            <?php
                                                            $expriedYear = array();
                                                            for ($i = date('Y'); $i < (date('Y') + 30); $i++) {
                                                                $expriedYear[$i] = $i;
                                                            }
                                                            echo form_dropdown('CCExpYear', $expriedYear, date('m'), array('id' => 'ExpYear', 'data-stripe' => 'exp-year'));
                                                            ?>
                                                       
                                            </div>
                                            </div>          
                                        </li>
                                        <li>
                                            <div class="form_grid_12">
                                                <div class="col-sm-6">
                                                    <label><?php if ($this->lang->line('Security Code') != '') {
                                                            echo stripslashes($this->lang->line('Security Code'));
                                                        } else echo "Security Code"; ?>
                                                    </label>
                                                    <div class="form_input">
                                                    <?php if ($this->lang->line('enter_security_code') != '') {
                                                    $securityCode= stripslashes($this->lang->line('enter_security_code'));
                                                    } else $securityCode= "Enter Security Code"; ?>
                                                    
                                                    <?php
                                                    echo form_password('creditCardIdentifier', '', array('placeholder' => "$securityCode", 'autocomplete' => 'off', 'id' => 'StripeCVCIdentifier', 'data-stripe' => 'cvc'));
                                                    ?>
                                                </div>
                                                </div>
                                                </div>
                                         </li>  
                                         <li> 
                                            <div class="form_grid_12">
                                             <div class="form_input">
                                            <button class="submitBtn" onclick="return stripePayment();"
                                                    id="StripePaymentButton"><?php if ($this->lang->line('Pay with Stripe') != '') {
                                                    echo stripslashes($this->lang->line('Pay with Stripe'));
                                                } else echo "Pay with Stripe"; ?></button>
                                            </div>
                                            </div>
                                        </li>
                                </ul>
                                <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <span class="clear"></span>
    </div>
    </div>
    <!-- script for form validation -->
    <script type="text/javascript">
        $('#add_vendor_payment_form').validate();
    </script>
    <script type="text/javascript">
    function stripePayment() {        
        var $form = $('#credit_card_forms_stripe');
        $('#StripePaymentErrors').hide();
        $('#loadingContainer').show();
        $('#StripePaymentButton').prop('disabled', true);
        Stripe.createToken($form, stripeResponseHandler);
        return false;
    }

    var stripeResponseHandler = function (status, response) {
        alert("stripe handler");
        $('#loadingContainer').hide();
        var $form = $('#credit_card_forms_stripe');
        if (response.error) {
            $('#StripePaymentErrors').text(response.error.message);
            $('#StripePaymentErrors').fadeIn();
            $('#StripePaymentButton').prop('disabled', false);
        } else {
            $('#StripePaymentErrors').hide();
            var token = response.id;
            $form.append($('<input type="hidden" name="stripeToken" />').val(token));
            $form.get(0).submit();
        }
    };
    </script>
<?php
$this->load->view('admin/templates/footer.php');
?>