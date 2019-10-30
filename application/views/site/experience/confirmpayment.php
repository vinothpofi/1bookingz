<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
$product = $productList->row();
//$BookingUser = $BookingUserDetails->row();
$BookingUser = $datavalues->row();
$servicetax = $service_tax->row();
$rentalDetail = $datavalues->row();
$data = $datavalues->row();
$coupon = $pay->row();
$unitprice = $rentalDetail->unitPerCurrencyUser;
//$user_currencycode = $rentalDetail->user_currencycode;
$user_currencycode = $productList->row()->currency;
$Experience_cur = $product->currency;

$commission = $product->serviceFee + $product->secDeposit;
if ($user_currencycode != $this->session->userdata('currency_type')) {
	$globalpdt_price = currency_conversion($user_currencycode, $this->session->userdata('currency_type'), $product->price,$BookingUser->currency_cron_id);
}
else
{
	$globalpdt_price = $product->price;
}
$service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="experience_booking" AND status="Active"';
$service_tax = $this->product_model->ExecuteQuery($service_tax_query);
$serviceFee = ($service_tax->row()->commission_percentage) / 100 * $globalpdt_price;  

/**Start - Get Payments Gateway is Enabled**/
define("paypal", $this->config->item('payment_0'));
$paypal = unserialize(paypal);
$paypalVal = $paypal['status'];
define("StripeDetails", $this->config->item('payment_1'));
$StripeValDet = unserialize(StripeDetails);
$StripeVal = $StripeValDet['status'];
$StripeValDet1 = unserialize($StripeValDet['settings']);
define("creditcard", $this->config->item('payment_2'));
$creditcard = unserialize(creditcard);
$creditCard_payment = $creditcard['status'];
/**End - Get Payments Gateway is Enabled **/
$userCurrencyCode = $datavalues->row()->user_currencycode;
?>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript">
        Stripe.setPublishableKey('<?php echo $StripeValDet1['publishable_key']; ?>');
    </script>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-5 swapRight">
                    <div class="paymentRight">
                        <div class="tableRow head">
                            <div class="left">
                                <h5><?php echo ucfirst($product->experience_title); ?></h5>
                                <div class="sub"><?php echo ucfirst($product->address); ?></div>
                            </div>
                            <div class="right">
                                <?php
                                $img_src = 'dummyProductImage.jpg';
                                if ($product->product_image != "" && file_exists('./images/experience/' . $product->product_image)) {
                                    $img_src = $product->product_image;
                                }
                                echo img(base_url() . 'images/experience/' . $img_src, '', array("class" => "propImg"));
                                ?>
                            </div>
                        </div>
                        <div class="divider"></div>
                        <p><i class="fa fa-user-o" aria-hidden="true"></i> <span
                                    class="number_s120"><?php echo $product->NoofGuest; ?></span> <?php if ($product->NoofGuest > 1) {
                                if ($this->lang->line('guest') != '') {
                                    echo stripslashes($this->lang->line('guest'));
                                } else

                                    echo "Guests";
                            }
                            if ($product->NoofGuest == 1) {
                                if ($this->lang->line('guest_s') != '') {
                                    echo stripslashes($this->lang->line('guest_s'));
                                } else

                                    echo "Guest";
                            } ?></p>
                        <p><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <span
                                    class="number_s120"><?php echo date('d', strtotime($product->checkin)); ?></span> <?php echo date('M', strtotime($product->checkin)); ?>
                            <span class="number_s120"><?php echo date('Y', strtotime($product->checkin)); ?>
                                - <?php echo date('d', strtotime($product->checkout)); ?></span> <?php echo date('M', strtotime($product->checkout)); ?>
                            <span class="number_s120"><?php echo date('Y', strtotime($product->checkout)); ?></span></p>
                        <div class="divider"></div>
                        <div class="tableRow">
                            <div class="left">
                                <p><?php if ($this->lang->line('Unit_Price') != '') {
                                        echo stripslashes($this->lang->line('Unit_Price'));
                                    } else echo "Unit Price";  ?></p>
                            </div>
                            <div class="right">
                                <p class="number_s120"> <?php echo $currencySymbol.' '.number_format($globalpdt_price, 2);
                                    /*if ($Experience_cur != $this->session->userdata('currency_type')) {
                                            $global_price = currency_conversion($Experience_cur, $this->session->userdata('currency_type'), $product->price);
                                            echo $global_price; //already number formatted in currency_conversion
											
                                    } else {
                                       echo number_format($product->price, 2);
                                    }
									*/
                                    ?></p>
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="left">
                                <p> <?php if ($this->lang->line('service_fee') != '') {
                                        echo stripslashes($this->lang->line('service_fee'));
                                    } else echo "Service Fee"; ?> </p>
                            </div>
                            <div class="right">
                                <p class="number_s120"> <?php $printedServiceFee =  substr($serviceFee,0,strpos($serviceFee,".") + 3);
								echo $currencySymbol.' '.$printedServiceFee;
								/**Note : Service fee already in experience currency only. so lets compare ExpCurrency and SessionCurrency**/
                                    /*if ($Experience_cur != $this->session->userdata('currency_type')) {
                                        $ServicePrice = currency_conversion($Experience_cur, $this->session->userdata('currency_type'), $product->serviceFee);
										echo $ServicePrice;
                                    } else {
                                        $ServicePrice = $product->serviceFee;
										 echo number_format($ServicePrice, 2);
                                    }
									*/
                                    ?> </p>
                            </div>
                        </div>
                        <div class="tableRow">
                            <div class="left">
                                <p> <?php if ($this->lang->line('SecurityDeposit') != '') {
                                        echo stripslashes($this->lang->line('SecurityDeposit'));
                                    } else echo "Security Deposit"; ?> </p>
                            </div>
                            <div class="right">
                                <p class="number_s120">
								
                                    <?php
									echo $currencySymbol;
                                    if ($user_currencycode != $this->session->userdata('currency_type')) {
                                       // $security_deposit = currency_conversion($Experience_cur, $this->session->userdata('currency_type'), $product->security_deposit);
                                        //echo $security_deposit; //already number formatted in currency_conversion
										$securityPrice = currency_conversion($user_currencycode, $this->session->userdata('currency_type'), $product->security_deposit,$BookingUser->currency_cron_id);
                                    } else {
                                        $securityPrice = $product->security_deposit;
                                    }
									echo number_format($securityPrice, 2);
                                    ?>
                                </p>
                            </div>
                        </div>
                        <!--<div class="divider"></div>-->
                        <div class="tableRow total">
                            <div class="left">
                                <p> <?php if ($this->lang->line('Total') != '') {
                                        echo stripslashes($this->lang->line('Total'));
                                    } else echo "Total"; ?>(<?php echo $this->session->userdata('currency_type'); ?>
                                    )</p>
                            </div>
                            <div class="right">
                                <h5> <?php
									$netTotal = $securityPrice + $printedServiceFee + $globalpdt_price;
                                    echo $currencySymbol.' '.number_format($netTotal, 2);
                                    /*     $GrandtotalAmt = $product->price+$product->serviceFee+$product->secDeposit; //All in ExpCurrency
                                    if ($Experience_cur != $this->session->userdata('currency_type')) {
                                        $Grandtotal = currency_conversion($Experience_cur, $this->session->userdata('currency_type'), $GrandtotalAmt);
                                        echo $Grandtotal; //already number formatted in currency_conversion
                                    } else {
                                        echo number_format($GrandtotalAmt, 2);
                                    }*/
                                    ?></h5>
                            </div>
                        </div>
                        <p class="bottom"> <?php if ($this->lang->line('cancel_experience') != '') {
                                echo stripslashes($this->lang->line('cancel_experience'));
                            } else echo "You can Cancel Your Experience untill before"; ?>  <?php echo $this->config->item('cancel_hide_days_experience'); ?> <?php if ($this->lang->line('days_from_checkin_date') != '') {
                                echo stripslashes($this->lang->line('days_from_checkin_date'));
                            } else echo "days from Check in Date"; ?> ..!</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="paymentOption">
                        <div class="panel-group" id="accordion">
                            <?php
                            echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id' => 'ttotal', 'value' => $netTotal));
                            echo form_input(array('type' => 'hidden', 'name' => 'user_id', 'id' => 'tuser_id', 'value' => $datavalues->row()->user_id));
							echo form_input(array('type' => 'hidden', 'name' => 'prd_cur', 'id' => 'prd_currency', 'value' => $datavalues->row()->currencycode));
                            echo form_input(array('type' => 'hidden', 'name' => 'unitprice', 'id' => 'unitprice', 'value' => $BookingUser->unitPerCurrencyUser));
                            echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                            echo form_input(array('type' => 'hidden', 'name' => 'rental_id', 'id' => 'rental_id', 'value' => $product->id)); ?>

                            <?php if ($creditCard_payment != 'Disable' || $StripeVal != 'Disable' || $paypalVal != 'Disable') {
                                if ($creditCard_payment != 'Disable') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                    <h5><?php if ($this->lang->line('Credit card') != '') {
                                                            echo stripslashes($this->lang->line('Credit card'));
                                                        } else echo "Credit card"; ?></h5></a>
                                            </h4>
                                        </div>
                                        <div id="collapse1" class="panel-collapse collapse in">
                                            <div class="panel-body">
                                                <div class="icons">
                                                    <img src="<?php echo base_url(); ?>images/visa.png">
                                                    <img src="<?php echo base_url(); ?>images/masterCard.png">
                                                    <img src="<?php echo base_url(); ?>images/americanExpress.png">
                                                    <img src="<?php echo base_url(); ?>images/discover.png">
                                                </div>
                                                <?php
                                                echo form_open('site/Experience_Checkout/PaymentCredit', array('id' => 'credit_card_forms', 'onsubmit' => 'return form_validation_creditcard();'));
												echo form_input(array('type' => 'hidden', 'name' => 'total_price', 'id' => 'price_val_authorize', 'value' => $netTotal));
												echo form_input(array('type' => 'hidden', 'name' => 'currencycode', 'value' => $datavalues->row()->currencycode));
												echo form_input(array('type' => 'hidden', 'name' => 'booking_rental_id', 'value' => $product->id));
												echo form_input(array('type' => 'hidden', 'name' => 'enquiryid', 'value' => $this->uri->segment(4)));
												echo form_input(array('type' => 'hidden', 'name' => 'creditvalue', 'value' => 'authorize'));
												echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
												 echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $datavalues->row()->currency_cron_id));
												  echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'value' => $experience_DateDetails->row()->price));
												
                                                ?>
                                                <p class="text-center text-success" id="CCloadingContainer"
                                                   style="display: none;"><i
                                                            class="fa fa-spinner fa-spin fa-1x fa-fw"></i> <?php if ($this->lang->line('Please wait your transaction on process') != '') {
                                                        echo stripslashes($this->lang->line('Please wait your transaction on process'));
                                                    } else echo "Please wait your transaction on process"; ?></p>
                                                <p class="text-center text-danger" id="cc_error_msg"></p>
                                                <label><?php if ($this->lang->line('Card Type') != '') {
                                                        echo stripslashes($this->lang->line('Card Type'));
                                                    } else echo "Card Type"; ?></label>
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
                                                echo form_dropdown('cardType', $CardOptions, '', array('id' => 'CCcardType'));
                                                ?>
                                                <label><?php if ($this->lang->line('Credit Card Number') != '') {
                                                        echo stripslashes($this->lang->line('Credit Card Number'));
                                                    } else echo "Credit Card Number"; ?></label>
													
													<?php if ($this->lang->line('enter_credit_card_num') != '') {
                                                        $enter_credit= stripslashes($this->lang->line('enter_credit_card_num'));
                                                    } else $enter_credit= "Enter Credit Card Number"; ?>
													
                                                <?php
                                                echo form_input('cardNumber', '', array('placeholder' => $enter_credit, 'autocomplete' => 'off', 'id' => 'CCcardNumber', 'maxlength' => '16'));
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <label class="col-sm-12"><?php if ($this->lang->line('Expiration Date') != '') {
                                                                    echo stripslashes($this->lang->line('Expiration Date'));
                                                                } else echo "Expiration Date"; ?></label>
                                                            <div class="col-sm-5">
                                                                <?php
                                                                $expriedMonth = array();
                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $expriedMonth[$i] = $i;
                                                                }
                                                                echo form_dropdown('CCExpMonth', $expriedMonth, date('m'), array('id' => 'CCExpMonth'));
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <?php
                                                                $expriedYear = array();
                                                                for ($i = date('Y'); $i < (date('Y') + 30); $i++) {
                                                                    $expriedYear[$i] = $i;
                                                                }
                                                                echo form_dropdown('CCExpYear', $expriedYear, date('m'), array('id' => 'CCExpYear'));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label><?php if ($this->lang->line('Security Code') != '') {
                                                                echo stripslashes($this->lang->line('Security Code'));
                                                            } else echo "Security Code"; ?>
                                                        </label>
														<?php if ($this->lang->line('enter_security_code') != '') {
                                                                $enter_sec= stripslashes($this->lang->line('enter_security_code'));
                                                            } else $enter_sec= "Enter Security Codee"; ?>
														
														
                                                        <?php
                                                        echo form_password('creditCardIdentifier', '', array('placeholder' =>$enter_sec, 'autocomplete' => 'off', 'id' => 'creditCardIdentifier'));
                                                        ?>
                                                    </div>
                                                </div>

                                                    <button class="submitBtn"
                                                            id="CCPaymentButton"><?php if ($this->lang->line('Proceed with Payment Credit card') != '') {
                                                            echo stripslashes($this->lang->line('Proceed with Payment Credit card'));
                                                        } else echo "Pay with Credit card"; ?></button>

                                               <?php  echo form_close(); ?>

                                                <?php if($this->config->item('site_status')==2){ ?>
                                                    <h6>SandBox Account Details</h6>
                                                    <label>Test Card Number: 4111111111111111</label><br>
                                                    <label>Test card type: Visa</label><br>
                                                    <label>Test card cvv: 123</label>
                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                if ($StripeVal != 'Disable') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                                    <h5><?php if ($this->lang->line('Stripe') != '') {
                                                            echo stripslashes($this->lang->line('Stripe'));
                                                        } else echo "Stripe"; ?></h5></a>
                                            </h4>
                                        </div>
                                        <div id="collapse2"
                                             class="panel-collapse collapse <?php echo ($creditCard_payment == 'Disable') ? 'in' : ''; ?>">
                                            <div class="panel-body">
                                                <div class="icons">
                                                    <img src="<?php echo base_url(); ?>images/visa.png">
                                                    <img src="<?php echo base_url(); ?>images/masterCard.png">
                                                    <img src="<?php echo base_url(); ?>images/americanExpress.png">
                                                    <img src="<?php echo base_url(); ?>images/discover.png">
                                                </div>
                                                <?php
                                                echo form_open('site/Experience_Checkout/UserPaymentCreditStripe', array('id' => 'credit_card_forms_stripe'));
                                                echo form_input(array('type' => 'hidden', 'name' => 'stripe_mode', 'id' => 'stripe_mode', 'value' => $StripeValDet1['mode']));
                                                echo form_input(array('type' => 'hidden', 'name' => 'stripe_key', 'id' => 'stripe_key', 'value' => $StripeValDet1['secret_key']));
                                                echo form_input(array('type' => 'hidden', 'name' => 'stripe_publish_key', 'id' => 'stripe_publish_key', 'value' => $StripeValDet1['publishable_key']));
                                                echo form_input(array('type' => 'hidden', 'name' => 'total_price', 'id' => 'price_val_stripe', 'value' => $netTotal));
                                                echo form_input(array('type' => 'hidden', 'name' => 'currencycode', 'id' => 'currencycode', 'value' => $datavalues->row()->currencycode));
                                                echo form_input(array('type' => 'hidden', 'name' => 'booking_rental_id', 'id' => 'booking_rental_id', 'value' => $product->id));
                                                echo form_input(array('type' => 'hidden', 'name' => 'enquiryid', 'id' => 'enquiryid', 'value' => $this->uri->segment(4)));
                                                echo form_input(array('type' => 'hidden', 'name' => 'creditvalue', 'id' => 'creditvalue', 'value' => 'stripe'));
												echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                                                echo form_input(array('type' => 'hidden', 'name' => 'date_id', 'value' => $data->date_id));
                                                echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'value' => $experience_DateDetails->row()->price));
												 echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $datavalues->row()->currency_cron_id));
                                                ?>
                                                <p class="text-center text-success" id="loadingContainer"
                                                   style="display: none;"><i
                                                            class="fa fa-spinner fa-spin fa-1x fa-fw"></i> <?php if ($this->lang->line('Please wait your transaction on process') != '') {
                                                        echo stripslashes($this->lang->line('Please wait your transaction on process'));
                                                    } else echo "Please wait your transaction on process"; ?></p>
                                                <p class="text-center text-danger" id="StripePaymentErrors"
                                                   style="display: none;"></p>
                                                <label><?php if ($this->lang->line('Card Type') != '') {
                                                        echo stripslashes($this->lang->line('Card Type'));
                                                    } else echo "Card Type"; ?></label>
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
                                                <label><?php if ($this->lang->line('Credit Card Number') != '') {
                                                        echo stripslashes($this->lang->line('Credit Card Number'));
                                                    } else echo "Credit Card Number"; ?></label>
                                                <?php
                                                echo form_input('cardNumber', '', array('placeholder' => $enter_credit, 'autocomplete' => 'off', 'id' => 'cardNumber', 'maxlength' => '16', 'data-stripe' => 'number'));
                                                ?>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="row">
                                                            <label class="col-sm-12"><?php if ($this->lang->line('Expiration Date') != '') {
                                                                    echo stripslashes($this->lang->line('Expiration Date'));
                                                                } else echo "Expiration Date"; ?></label>
                                                            <div class="col-sm-5">
                                                                <?php
                                                                $expriedMonth = array();
                                                                for ($i = 1; $i <= 12; $i++) {
                                                                    $expriedMonth[$i] = $i;
                                                                }
                                                                echo form_dropdown('CCExpMonth', $expriedMonth, date('m'), array('id' => 'ExpMonth', 'data-stripe' => 'exp-month'));
                                                                ?>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <?php
                                                                $expriedYear = array();
                                                                for ($i = date('Y'); $i < (date('Y') + 30); $i++) {
                                                                    $expriedYear[$i] = $i;
                                                                }
                                                                echo form_dropdown('CCExpYear', $expriedYear, date('m'), array('id' => 'ExpYear', 'data-stripe' => 'exp-year'));
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label><?php if ($this->lang->line('Security Code') != '') {
                                                                echo stripslashes($this->lang->line('Security Code'));
                                                            } else echo "Security Code"; ?>
                                                        </label>
                                                        <?php
                                                        echo form_password('creditCardIdentifier', '', array('placeholder' => $enter_sec, 'autocomplete' => 'off', 'id' => 'StripeCVCIdentifier', 'data-stripe' => 'cvc'));
                                                        ?>
                                                    </div>
                                                </div>

                                                    <button class="submitBtn" onclick="return stripePayment();"
                                                            id="StripePaymentButton"><?php if ($this->lang->line('Pay with Stripe') != '') {
                                                            echo stripslashes($this->lang->line('Pay with Stripe'));
                                                        } else echo "Pay with Stripe"; ?></button>

                                                <?php
                                                echo form_close(); ?>

                                                <?php if($this->config->item('site_status')==2){ ?>
                                                    <h6>SandBox Account Details</h6>
                                                    <label>Test Card Number: 4242424242424242</label><br>
                                                    <label>Test card type: Visa</label><br>
                                                    <label>Test card cvv: 123</label>
                                                <?php } ?>

                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                if ($paypalVal != 'Disable') { ?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                                    <h5><?php if ($this->lang->line('Paypal') != '') {
                                                            echo stripslashes($this->lang->line('Paypal'));
                                                        } else echo "Paypal"; ?></h5></a>
                                            </h4>
                                        </div>
                                        <div id="collapse3"
                                             class="panel-collapse collapse <?php echo ($creditCard_payment == 'Disable' && $StripeVal == 'Disable') ? 'in' : ''; ?>">
                                            <div class="panel-body">
                                                <img src="<?php echo base_url(); ?>images/paypal.png" width="70">
                                                <br><br>
                                                <?php
                                                $data = $datavalues->row();
                                                $coupon = $pay->row();
                                                $service_tax = $service_tax->row();
                                                $productprice = $this->user_model->get_all_details(PRODUCT, array('id' => $data->prd_id));
                                                $pprice = $productprice->row()->price;
                                                $total = $pprice * $data->numofdates;
                                                $total1 = $stotal * $data->NoofGuest;
                                                if ($service_tax->promotion_type == 'flat') {
                                                    $total = $total + $service_tax->commission_percentage;
                                                } else {
                                                    $tax = $service_tax->commission_percentage;
                                                    $taxamt = ($total * $tax / 100);
                                                    $total = ($total + $taxamt);
                                                    $total1 = ($total1 + ($total1 * $tax / 100));
                                                }
                                                echo form_open('site/Experience_Checkout/PaymentProcess', array('name' => 'paypal'));
                                                echo form_hidden('product_id', $data->prd_id);
                                                echo form_hidden('date_id', $data->date_id);
                                                echo form_hidden('product_name', $productList->row()->experience_title);
                                                echo form_hidden('currencycode', $datavalues->row()->currencycode);
                                                $pricevalue = ($coupon->couponCode == '') ? $datavalues->row()->totalAmt : $pay->row()->total_amt;
                                                echo form_hidden('unitPriceUser', $datavalues->row()->unitPerCurrencyUser);
                                                echo form_hidden('tax', $datavalues->row()->serviceFee);
                                                echo form_hidden('user_id', $data->user_id);
                                                echo form_hidden('sell_id', $data->renter_id);
                                                echo form_hidden('enquiryid', $this->uri->segment(4));
                                                echo form_hidden('dealCodeNumber', '');
												echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                                                echo form_input(array('type' => 'hidden', 'name' => 'price', 'id' => 'final_value_price', 'value' => $netTotal));
                                                echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id' => 'final_value_sum', 'value' => $netTotal));
                                                //echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'id' => 'final_value_ind', 'value' => $netTotal));
												echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'value' => $experience_DateDetails->row()->price));
												echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $datavalues->row()->currency_cron_id));
                                                echo form_submit('paypal', ($this->lang->line('Book Now') != '') ? stripslashes($this->lang->line('Book Now')) . '(PayPal)' : "Book Now (PayPal)", array('class' => 'submitBtn'));
                                                echo form_close(); ?>

                                                <?php if($this->config->item('site_status')==2){ ?>
                                                    <h6>SandBox Account Details</h6>
                                                    <label>Test Account: kumarkailash075-buyer@gmail.com</label><br>
                                                    <label>Password: mahesh84</label><br>
                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <p class="text-center text-danger">No Payment Method is Available</p>
                                <?php
                            }
                            ?>
                        </div>
                        <p class="bottomTxt"><?php if ($this->lang->line('Bysubmittinga') != '') {
                                echo stripslashes($this->lang->line('Bysubmittinga'));
                            } else echo "By submitting a booking request, you accept the Renters"; ?> <a target="_blank"
                                                                                                         href="<?php echo base_url(); ?>pages/terms-of-service"><?php if ($this->lang->line('termsandconditions1') != '') {
                                    echo stripslashes($this->lang->line('termsandconditions1'));
                                } else echo "terms and conditions"; ?></a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        function stripePayment() {
             $('.loading').show();
            var $form = $('#credit_card_forms_stripe'); 
            $('#StripePaymentErrors').hide();
            $('#loadingContainer').show();
            $('#StripePaymentButton').prop('disabled', true);
            Stripe.createToken($form, stripeResponseHandler);
            return false;
        }

        var stripeResponseHandler = function (status, response) {
            $('#loadingContainer').hide();
            var $form = $('#credit_card_forms_stripe');
            if (response.error) {
                $('.loading').hide();
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

        /*Credit card validation*/
        function form_validation_creditcard() {

            var card_no = $("#CCcardNumber").val();
            var security_code = $("#creditCardIdentifier").val();
            if (card_no == "") {
                $("#cc_error_msg").html("Please provide credit card Number");
                return false;
            }
            else if (isNaN(card_no)) {
                $("#cc_error_msg").html("Please provide valid credit card Number");
                return false;
            }
            else {
                $("#cc_error_msg").html("");
            }
            if (security_code == "") {
                $("#cc_error_msg").html("Please provide security code");
                return false;
            }
            else if (isNaN(security_code)) {
                $("#cc_error_msg").html("Please provide valid security code");
                return false;
            }
            else {
                 $('.loading').show();
                $("#cc_error_msg").html("");
            }
            return true;
        }
    </script>
<?php
$this->load->view('site/includes/footer');
?>