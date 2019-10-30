<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
/*print_r($currency_result);
exit;
stdClass Object ( [AUD] => 1.3235 [BGN] => 1.6204 [BRL] => 3.479 [CAD] => 1.2882 [CHF] => 0.99089 [CNY] => 6.3394 [CZK] => 21.103 [DKK] => 6.1724 [EUR] => 0.8285 [GBP] => 0.72659 [HKD] => 7.8485 [HRK] => 6.1471 [HUF] => 259.19 [IDR] => 13855 [ILS] => 3.5937 [INR] => 66.664 [ISK] => 101.57 [JPY] => 109.32 [KRW] => 1070.3 [MXN] => 18.801 [MYR] => 3.9131 [NOK] => 8.0025 [NZD] => 1.4181 [PHP] => 51.692 [PLN] => 3.493 [RON] => 3.8621 [RUB] => 62.484 [SEK] => 8.7142 [SGD] => 1.326 [THB] => 31.58 [TRY] => 4.0499 [ZAR] => 12.398 )*/
$product = $productList->row();
$BookingUser = $datavalues->row();
$dateaddes = date('Y-m-d',strtotime($BookingUser->dateAdded));
$curren_id = $this->db->select('curren_id')->where('created_date',$dateaddes)->get('fc_currency_cron')->row()->curren_id;

// echo $curren_id ;exit();

/* START dateAdded */
	$id = $BookingUser->prd_id;
	$Price = $this->db->where('id', $id)->get(PRODUCT)->row()->price;
	$currencyCode = $this->db->where('id', $id)->get(PRODUCT)->row()->currency;
	$checkIn = $BookingUser->checkin;
	$checkOut = $BookingUser->checkout;
	$begin = new DateTime($checkIn);
	$end = new DateTime($checkOut);
	$interval = new DateInterval('P1D'); // 1 Day
	$dateRange = new DatePeriod($begin, $interval, $end);
	$result = array();
	foreach ($dateRange as $date) {
		$result[] = $date->format('Y-m-d');
	}
	
	//echo count($result);
	$DateCalCul = 0;
	$sb_ScheduleDatePrice = $this->product_model->get_all_details(SCHEDULE, array('id' => $id));
	if ($sb_ScheduleDatePrice->row()->data != '') {
		$dateArr = json_decode($sb_ScheduleDatePrice->row()->data);
		$finaldateArr = (array)$dateArr;
		foreach ($result as $Rows) {
			if (array_key_exists($Rows, $finaldateArr)) {
				$DateCalCul = $DateCalCul + $finaldateArr[$Rows]->price;
			} else {
				$DateCalCul = $DateCalCul + $Price;
			}
		}
	} else {
		$DateCalCul = (count($result) * $Price);
	}
	//echo '<br>DateCalCul'.$DateCalCul.'<br>';
	$service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE seo_tag="guest-booking" AND status="Active"';
	$service_tax = $this->product_model->ExecuteQuery($service_tax_query);
	if ($service_tax->num_rows() == 0) {
		$sb_taxValue = '0.00';
		$sb_taxString = '0.00';
	} else {
		$sb_commissionType = $service_tax->row()->promotion_type;
		$sb_commissionValue = $service_tax->row()->commission_percentage;
		$finalTax = ($service_tax->row()->commission_percentage * $DateCalCul) / 100;
		$sb_taxValue = $finalTax;
		$sb_taxString = $finalTax;
		$currencyCode = $this->db->where('id', $id)->get(PRODUCT)->row()->currency;
		if ($currencyCode != $this->session->userdata('currency_type')) {
			if ($currency_result->$currencyCode) {
				//$sb_taxString = $sb_taxString / $currency_result->$currencyCode;
				$sb_taxString = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$sb_taxString,$curren_id);
			} else {
				$sb_taxString = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$sb_taxString,$curren_id);
			}
		} elseif ($currencyCode == $this->session->userdata('currency_type')) {
			$sb_taxString = $finalTax;
		}
	}
	//echo $sb_taxString; exit;
	$sb_total_nights = count($result);
	$sb_product_id = $id;
	$sb_subTotal = $DateCalCul;
	$currencyCode = $this->db->where('id', $id)->get(PRODUCT)->row()->currency;
	$sb_currencycd = $this->db->where('id', $id)->get(PRODUCT)->row()->currency;
	$securityDepositestart = $this->db->where('id', $id)->get(PRODUCT)->row()->security_deposit;
	$sb_securityDeposite = $securityDepositestart;
    // echo $currencyCode.$this->session->userdata('currency_type');exit();
	if ($currencyCode != $this->session->userdata('currency_type')) {
// echo $curren_id;exit();
        // $BookingUser->currency_cron_id
		if ($currency_result->$currencyCode) {
            
			$sb_securityDeposite_string = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$securityDepositestart,$curren_id);
			$sb_total_value = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$DateCalCul,$curren_id);
		} else {
			$sb_securityDeposite_string = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$securityDepositestart,$curren_id);

            // $sb_securityDeposite_stringqqq = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$securityDepositestart,165);
            //  $sb_securityDeposite_stringqqqs = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$securityDepositestart,164);
             // echo $sb_securityDeposite_stringqqq.'<br>';
             //  echo $sb_securityDeposite_stringqqqs.'<br>';exit();   




			$sb_total_value = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$DateCalCul,$curren_id);

		}
	} elseif ($currencyCode == $this->session->userdata('currency_type')) {
		$sb_securityDeposite_string = $securityDepositestart;
		$sb_total_value = $DateCalCul;
	}


	$basecurrencyCode = $this->db->where('default_currency', 'Yes')->get(CURRENCY)->row();
	$currency_code = $basecurrencyCode->currency_type;

	if ($service_tax->row()->promotion_type == 'flat') {
		if ($currency_code!=$currencyCode){  //DeafultCurrency!=Prd_Currency
			$serviceFeeInPrdCurrency=changeCurrency($currency_code,$currencyCode,$service_tax->row()->commission_percentage,$curren_id);
		}else{
			$serviceFeeInPrdCurrency=changeCurrency($currency_code,$currencyCode,$service_tax->row()->commission_percentage,$curren_id);
		}
	}else{
		$serviceFeeInPrdCurrency=$service_tax->row()->commission_percentage * $DateCalCul / 100;
	}
	//End - Convert Service Fee into Product Currency

	$sb_net_total_value = ($sb_total_value) + ($sb_taxString) + ($sb_securityDeposite_string);

	if ($currencyCode != $this->session->userdata('currency_type')) {
		$sb_net_total_string = $sb_net_total_value;

	} elseif ($currencyCode == $this->session->userdata('currency_type')) {
		$sb_net_total_string = $sb_net_total_value;
	}
	
	
/* END */

$servicetax = $service_tax->row();
$rentalDetail = $datavalues->row();
$subTotal = $rentalDetail->subTotal;
$secDeposit = $rentalDetail->secDeposit;
$totalAmt = $rentalDetail->totalAmt;
$serviceFee = $rentalDetail->serviceFee;

$unitprice = $rentalDetail->unitPerCurrencyUser;
$user_currencycode = $rentalDetail->currencycode;
$enquiry_userCurrencyCode = $rentalDetail->user_currencycode;
$rental_currencycode = $rentalDetail->currencycode;
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
                            <h5><?php echo ucfirst($product->product_title); ?></h5>
                            <div class="sub"><?php echo ucfirst($product->address); ?></div>
                            <div class="clear">
                                <div class="starRatingOuter1">
                                    <?php $avg_val = round($similar_Rentals->rate); ?>
                                    <div class="starRatingInner1"
                                         style="width: <?php echo ($product->num_reviewers > 0) ? $avg_val * 20 : 0; ?>%;"></div>
                                </div>
                                <span
                                        class="ratingCount"><?php echo $product->num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
                                        echo stripslashes($this->lang->line('Reviews'));
                                    } else echo "Reviews"; ?></span>
                            </div>
                        </div>
                        <div class="right">
                            <?php
                            $img_src = 'dummyProductImage.jpg';
                            if ($product->product_image != "" && file_exists('./images/rental/' . $product->product_image)) {
                                $img_src = $product->product_image;
                            }
                            echo img(base_url() . 'images/rental/' . $img_src, '', array("class" => "propImg"));
                            ?>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <p><i class="fa fa-user-o" aria-hidden="true"></i> <span
                                class="number_s120"><?php echo $BookingUser->NoofGuest; ?></span> <?php if ($BookingUser->NoofGuest > 1) {
                            if ($this->lang->line('guest') != '') {
                                echo stripslashes($this->lang->line('guest'));
                            } else
                                echo "Guests";
                        }
                        if ($BookingUser->NoofGuest == 1) {
                            if ($this->lang->line('guest_s') != '') {
                                echo stripslashes($this->lang->line('guest_s'));
                            } else
                                echo "Guest";
                        } ?></p>
                    <p><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <span
                                class="number_s120"><?php echo date('d', strtotime($BookingUser->checkin)); ?></span> <?php echo date('M', strtotime($BookingUser->checkin)); ?>
                        <span class="number_s120"><?php echo date('Y', strtotime($BookingUser->checkin)); ?>
                            - <?php echo date('d', strtotime($BookingUser->checkout)); ?></span> <?php echo date('M', strtotime($BookingUser->checkout)); ?>
                        <span class="number_s120"><?php echo date('Y', strtotime($BookingUser->checkout)); ?></span></p>
                    <div class="divider"></div>
                    <div class="tableRow">
                        <div class="left">
                            <p>	<?php 
							if ($this->lang->line('Sub_Total') != '') {
                                echo stripslashes($this->lang->line('Sub_Total'));
                            } else
                                echo "Sub total";
							?>
                                <?php
								//user_currencycode ==>brl
								//echo $this->session->userdata('currency_type'); exit; //USD
								//echo $currency_result->$user_currencycode; exit; // 3.479
                                //$commission = $BookingUser->serviceFee + $BookingUser->secDeposit;
                                //$pricePerNight = number_format(($BookingUser->totalAmt - $commission) / $BookingUser->numofdates, 2);
								//echo $user_currencycode.' != '.$this->session->userdata('currency_type');
                               // if ($enquiry_userCurrencyCode != $this->session->userdata('currency_type')) {
								//	$global_price = currency_conversion($enquiry_userCurrencyCode, $this->session->userdata('currency_type'), $BookingUser->subTotal,$BookingUser->currency_cron_id);
                                    /*if ($currency_result->$user_currencycode) {
                                        $global_price = $subTotal / $currency_result->$user_currencycode;
                                    } else {
                                        $global_price = currency_conversion($user_currencycode, $this->session->userdata('currency_type'), $subTotal);
                                    }*/
                                //} else {
                                //    $global_price = $BookingUser->subTotal;
                                //}
								
                                ?></p>
                        </div>
                        <div class="right">
                            <p class="number_s120"> <?php echo $currencySymbol;
                                $OnlyForDays = $sb_total_value;
                                echo number_format($OnlyForDays, 2);
                                ?></p>
                        </div>
                    </div>
                    <div class="tableRow">
                        <div class="left">
                            <p> <?php if ($this->lang->line('service_fee') != '') {
                                    echo stripslashes($this->lang->line('service_fee'));
                                } else echo "Service Fee"; ?> </p>
                        </div>
                        <?php
						/*if ($enquiry_userCurrencyCode != $this->session->userdata('currency_type')) {
							$serviceFee = currency_conversion($enquiry_userCurrencyCode, $this->session->userdata('currency_type'), $BookingUser->serviceFee,$BookingUser->currency_cron_id);
						} else {
							$serviceFee = $BookingUser->serviceFee;
						}
						*/		
                        /*if ($user_currencycode != $this->session->userdata('currency_type')) {
                            if ($currency_result->$user_currencycode) {

                                $serviceFee = $serviceFee / $currency_result->$user_currencycode;
                            } else {

                                $serviceFee = convertCurrency($user_currencycode, $this->session->userdata('currency_type'), $serviceFee);
                            }
                        } else {
                            
                            $serviceFee = $serviceFee;
                        } */
                        ?>
                        <div class="right">
                            <p class="number_s120"> <?php echo $currencySymbol .  number_format($sb_taxString, 2); ?> </p>
                        </div>
                    </div>
                    <div class="tableRow">
                        <div class="left">
                            <p> <?php if ($this->lang->line('SecurityDeposit') != '') {
                                    echo stripslashes($this->lang->line('SecurityDeposit'));
                                } else echo "Security Deposit"; ?> </p>
                        </div>
                        <?php
                        /*if ($user_currencycode != $this->session->userdata('currency_type')) {
                            if ($currency_result->$user_currencycode) {
                                
                                $secDeposit = $secDeposit / $currency_result->$user_currencycode;
                            } else {

                                $secDeposit = currency_conversion($user_currencycode, $this->session->userdata('currency_type'), $secDeposit);
                            }
                        } else {
                            //$secDeposit = currency_conversion($user_currencycode, $this->session->userdata('currency_type'), $secDeposit);
                            $secDeposit = $secDeposit;
                        }*/
						/*if ($enquiry_userCurrencyCode != $this->session->userdata('currency_type')) {
							$secDeposit = currency_conversion($enquiry_userCurrencyCode, $this->session->userdata('currency_type'), $BookingUser->secDeposit,$BookingUser->currency_cron_id);
						} else {
							$secDeposit = $BookingUser->secDeposit;
						}*/
						
						
                        ?>
                        <div class="right">
                            <p class="number_s120"> <?php echo $currencySymbol .  number_format($sb_securityDeposite_string, 2); ?> </p>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="tableRow">
                        <div class="left">
                            <p> <?php if ($this->lang->line('Total') != '') {
                                    echo stripslashes($this->lang->line('Total'));
                                } else echo "Total"; ?>(<?php echo $this->session->userdata('currency_type'); ?>)</p>
                        </div>
                        <div class="right">
                            <h5> <?php echo $currencySymbol . $GrandtotalAmt = number_format($sb_securityDeposite_string + $sb_taxString + $OnlyForDays, 2); ?></h5>
                        </div>
                    </div>
                    <p class="bottom"> <?php if ($this->lang->line('cancel_trip_msgOne') != '') {
                            echo stripslashes($this->lang->line('cancel_trip_msgOne'));
                        } else echo "You can Cancel Your trip untill before"; ?><?php echo " ".$this->config->item('cancel_hide_days_property') . " "; ?><?php if ($this->lang->line('cancel_trip_msgTwo') != '') {
                            echo stripslashes($this->lang->line('cancel_trip_msgTwo'));
                        } else echo "days from Check in Date..!"; ?></p>
                </div>
            </div>
            <div class="col-md-7">
                <div class="paymentOption">
                    <div class="panel-group" id="accordion">
                        <?php
                        echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id' => 'ttotal', 'value' => $sb_net_total_string));
						echo form_input(array('type' => 'hidden', 'name' => 'prd_cur', 'id' => 'prd_currency', 'value' => $datavalues->row()->currencycode));
                        //echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id' => 'tuser_id', 'value' => $datavalues->row()->user_id));
                        echo form_input(array('type' => 'hidden', 'name' => 'unitprice', 'id' => 'unitprice', 'value' => $BookingUser->unitPerCurrencyUser));
                        echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                        echo form_input(array('type' => 'hidden', 'name' => 'rental_id', 'id' => 'rental_id', 'value' => $product->id));
                        if ($creditCard_payment != 'Disable' || $StripeVal != 'Disable' || $paypalVal != 'Disable') { ?>
                            <div class="panel panel-default" id="coupon_id">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                            <h5><?php if ($this->lang->line('Doyouhave') != '') {
                                                    echo stripslashes($this->lang->line('Doyouhave'));
                                                } else echo "Do you have Coupon code?"; ?></h5></a>
                                    </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <?= form_open('#', array('onsubmit' => 'return mycoupon();')); ?>
                                        <div class="col-lg-6">
                                            <?= form_input('couponcode', '', array('id' => 'couponcode', 'placeholder' => ($this->lang->line('Coupon Code') != '') ? stripslashes($this->lang->line('Coupon Code')) : 'Coupon Code', 'required' => 'required')) ?>
                                        </div>
                                        <div class="col-lg-6">
                                            <?= form_input(array('type' => 'hidden', 'name' => 'huser_id', 'id' => 'huser_id', 'value' => $product->user_id)); ?>
                                            <?= form_input(array('type' => 'hidden', 'name' => 'total', 'id' => 'total', 'value' => $subtotal + $tax_price)); ?>
                                            <button type="submit"
                                                    class="submitBtn" id="coupon_Btn"><?php if ($this->lang->line('Apply') != '') {
                                                    echo stripslashes($this->lang->line('Apply'));
                                                } else echo "Apply"; ?></button>
                                        </div>
                                        <div class="col-lg-12">
                                            <p id="totals"></p>
                                            <p id="disper"></p>
                                            <p id="disamount"></p>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>
                                </div>
                            </div>
							
							
							<div class="panel panel-default" id="wallet_id">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" class="collapsed" aria-expanded="false">
                                            <h5>Cash in Wallet?</h5></a>
                                    </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
									
									<!-- wallet  payment-->
							
							 <?php if($userWallet->row()->referalAmount>0) { ?> 
								
								<?php $data = array(        'name'          => 'wallet_pay',        'id'            => 'wallet_pay',		'onClick'		=> "myWallet()");echo form_checkbox($data); ?>
								<label for='wallet_pay'>								<span class="credit-card" style="text-transform: capitalize;"><?php if($this->lang->line('Use_Wallet') != '') { echo stripslashes($this->lang->line('Use_Wallet')); } else echo "Use Wallet";?> ( <?php echo $currencySymbol;  echo convertCurrency($userWallet->row()->referalAmount_currency,$this->session->userdata('currency_type'),$userWallet->row()->referalAmount);?> )</span>								</label>
								<?php echo form_open('site/checkout/PaymentWallet', array('id' => 'wallet_form', 'name' => 'myForm','method'=>'POST','accept-charset'=>'UTF-8')); 								?>									<!--<input type="hidden" name="wallet" id="w_wallet" value="<?php  //echo convertCurrency($userWallet->row()->referalAmount_currency,$datavalues->row()->currencycode,$userWallet->row()->referalAmount);?>" />-->																	
								<?php																			echo form_input(array('type' => 'hidden', 'name' => 'wallet', 'id'=>'w_wallet',		'value' => $userWallet->row()->referalAmount)); 																		echo form_input(array('type' => 'hidden', 'name' => 'wallet_cur', 'id'=>'w_wallet_cur',	'value' => $userWallet->row()->referalAmount_currency)); 																												echo form_input(array('type' => 'hidden', 'name' => 'total_price', 'id'=>'w_price',			'value' => $datavalues->row()->totalAmt)); 																		echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id'=>'w_sum','value' =>  $datavalues->row()->totalAmt));																				echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'id'=>'w_ind','value' =>  $datavalues->row()->totalAmt));																				echo form_input(array('type' => 'hidden', 'name' => 'currencycode', 'id'=>'_price_val_authorize','value' => $datavalues->row()->currencycode ));																				echo form_input(array('type' => 'hidden', 'name' => 'booking_rental_id' ,'value' => $product->id ));																				echo form_input(array('type' => 'hidden', 'name' => 'enquiryid','value' => $this->uri->segment(4)));																?>				
									<?php echo form_close(); ?>
								<p id="w_totals"></p>
								<p id="w_disper"></p>
								<p id="w_disamount"></p>

							  <?php } else { ?>
							  
							  <?php echo "Invite a friend to get Cash in Wallet..!"; } ?>
							
							<!-- wallet payment ends -->
									
									
                                      

										</div>
                                </div>
                            </div>
							
								
							
                            <?php if ($creditCard_payment != 'Disable') { ?>
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
                                            echo form_open('site/checkout/PaymentCredit', array('id' => 'credit_card_forms', 'onsubmit' => 'return form_validation_creditcard();'));
                                            echo form_input(array('type' => 'hidden', 'name' => 'total_price', 'id' => 'price_val_authorize', 'value' => $sb_net_total_string));
                                            echo form_input(array('type' => 'hidden', 'name' => 'currencycode', 'value' => $datavalues->row()->currencycode));
                                            echo form_input(array('type' => 'hidden', 'name' => 'booking_rental_id', 'value' => $product->id));
                                            echo form_input(array('type' => 'hidden', 'name' => 'enquiryid', 'value' => $this->uri->segment(4)));
                                            echo form_input(array('type' => 'hidden', 'name' => 'creditvalue', 'value' => 'authorize'));
											echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
											 echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $curren_id));
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
                                                    $crdNum= stripslashes($this->lang->line('enter_credit_card_num'));
                                                } else $crdNum= "Enter Credit Card Number"; ?>
												
                                            <?php
                                            echo form_input('cardNumber', '', array('placeholder' => "$crdNum", 'autocomplete' => 'off', 'id' => 'CCcardNumber', 'maxlength' => '16'));
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <label
                                                                class="col-sm-12"><?php if ($this->lang->line('Expiration Date') != '') {
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
                                                    $securityCode= stripslashes($this->lang->line('enter_security_code'));
													} else $securityCode= "Enter Security Code"; ?>
													
                                                    <?php
                                                    echo form_password('creditCardIdentifier', '', array('placeholder' => "$securityCode", 'autocomplete' => 'off', 'id' => 'creditCardIdentifier'));
                                                    ?>
                                                </div>
                                            </div>
                                            <button class="submitBtn"
                                                    id="CCPaymentButton"><?php if ($this->lang->line('Proceed with Payment Credit card') != '') {
                                                    echo stripslashes($this->lang->line('Proceed with Payment Credit card'));
                                                } else echo "Pay with Credit card"; ?></button>
                                            <?php echo form_close(); ?>
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
                                            echo form_open('site/checkout/UserPaymentCreditStripe', array('id' => 'credit_card_forms_stripe'));
                                            echo form_input(array('type' => 'hidden', 'name' => 'stripe_mode', 'id' => 'stripe_mode', 'value' => $StripeValDet1['mode']));
                                            echo form_input(array('type' => 'hidden', 'name' => 'stripe_key', 'id' => 'stripe_key', 'value' => $StripeValDet1['secret_key']));
                                            echo form_input(array('type' => 'hidden', 'name' => 'stripe_publish_key', 'id' => 'stripe_publish_key', 'value' => $StripeValDet1['publishable_key']));
                                           echo form_input(array('type' => 'hidden', 'name' => 'total_price', 'id' => 'price_val_stripe', 'value' => $sb_net_total_string));										   										                                              //echo form_input(array('type' => 'text', 'name' => 'total_price', 'id' => 'price_val_stripe', 'value' =>  '388.59' ));
                                            echo form_input(array('type' => 'hidden', 'name' => 'currencycode', 'id' => 'currencycode', 'value' => $datavalues->row()->currencycode));
                                            echo form_input(array('type' => 'hidden', 'name' => 'booking_rental_id', 'id' => 'booking_rental_id', 'value' => $product->id));
                                            echo form_input(array('type' => 'hidden', 'name' => 'enquiryid', 'id' => 'enquiryid', 'value' => $this->uri->segment(4)));
                                            echo form_input(array('type' => 'hidden', 'name' => 'creditvalue', 'id' => 'creditvalue', 'value' => 'stripe'));
											echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
											 echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $curren_id));
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
												
												<?php if ($this->lang->line('enter_credit_card_num') != '') {
                                                    $crdNum= stripslashes($this->lang->line('enter_credit_card_num'));
                                                } else $crdNum= "Enter Credit Card Number"; ?>
												
                                            <?php
                                            echo form_input('cardNumber', '', array('placeholder' => "$crdNum", 'autocomplete' => 'off', 'id' => 'cardNumber', 'maxlength' => '16', 'data-stripe' => 'number'));
                                            ?>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row">
                                                        <label
                                                                class="col-sm-12"><?php if ($this->lang->line('Expiration Date') != '') {
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
													<?php if ($this->lang->line('enter_security_code') != '') {
                                                    $securityCode= stripslashes($this->lang->line('enter_security_code'));
													} else $securityCode= "Enter Security Code"; ?>
													
                                                    <?php
                                                    echo form_password('creditCardIdentifier', '', array('placeholder' => "$securityCode", 'autocomplete' => 'off', 'id' => 'StripeCVCIdentifier', 'data-stripe' => 'cvc'));
                                                    ?>
                                                </div>
                                            </div>
                                            <button class="submitBtn" onclick="return stripePayment();"
                                                    id="StripePaymentButton"><?php if ($this->lang->line('Pay with Stripe') != '') {
                                                    echo stripslashes($this->lang->line('Pay with Stripe'));
                                                } else echo "Pay with Stripe"; ?></button>
                                            <?php echo form_close(); ?>
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
                                            echo form_open('site/checkout/PaymentProcess', array('name' => 'paypal'));
                                            echo form_hidden('product_id', $data->prd_id);
                                            echo form_hidden('product_name', $productprice->row()->product_title);
                                            echo form_hidden('currencycode', $datavalues->row()->currencycode);
                                            echo form_hidden('unitPriceUser', $datavalues->row()->unitPerCurrencyUser);
                                            echo form_hidden('tax', $sb_taxString);
                                            echo form_hidden('user_id', $data->user_id);
                                            echo form_hidden('sell_id', $data->renter_id);
                                            echo form_hidden('enquiryid', $this->uri->segment(4));
                                            echo form_hidden('dealCodeNumber', '');
											echo form_input(array('type' => 'hidden', 'name' => 'user_currencycode', 'id' => 'user_currencycode', 'value' => $this->session->userdata('currency_type')));
                                            echo form_input(array('type' => 'hidden', 'name' => 'price', 'id' => 'final_value_price', 'value' => $sb_net_total_string));
                                            echo form_input(array('type' => 'hidden', 'name' => 'sumtotal', 'id' => 'final_value_sum', 'value' => $sb_net_total_string));
                                            echo form_input(array('type' => 'hidden', 'name' => 'indtotal', 'id' => 'final_value_ind', 'value' => $sb_net_total_string));
                                            echo form_input(array('type' => 'hidden', 'name' => 'currency_cron_id', 'id' => 'currency_cron_id', 'value' => $curren_id));
                                            echo form_submit('paypal', ($this->lang->line('Book Now') != '') ? stripslashes($this->lang->line('Book Now')) . '(PayPal)' : "Book Now (PayPal)", array('class' => 'submitBtn'));
                                            echo form_close(); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        } else { ?>
                            <p class="text-center text-danger"><?php if ($this->lang->line('no_payment_method') != '') {
                            echo stripslashes($this->lang->line('no_payment_method'));
                        } else echo "No Payment Method is Available"; ?></p>
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

    function mycoupon() {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url();?>site/product/coupons',
            data: {
                'total': $('#ttotal').val(),
                'user_id': $('#tuser_id').val(),
                'product_id': $("#rental_id").val(),
                'unitprice': $("#unitprice").val(),
                'user_curcode': $("#user_currencycode").val(),
                'rental_currencycode': "<?= $rental_currencycode; ?>",
                'couponcode': $('#couponcode').val()
            },
            dataType: 'json',
            success: function (json) {
                if (json == '0endcount') {
                    $('#totals').html('<p class="text-danger">Coupon is Not Available..!</p>');
                    emptyValues();
                    return false;
                }
                if (json == '0couexpi') {
                    $('#totals').html('<p class="text-danger">Coupon Code Expired..!</p>');
                    emptyValues();
                    return false;
                }
                if (json == '0invalid') {
                    $('#totals').html('<p class="text-danger">Invalid Coupon Please Try again Later..!</p>');
                    emptyValues();
                    return false;
                }
                if (json == '0moreamt') {
                    $('#totals').html('<p class="text-danger">Your Property Amount is more then Coupon Amount..!</p>');
                    emptyValues();
                    return false;
                }
                var test = json.split("-");
                console.log(test);
                if (test[0] == '' || test[0] == '0') {
                    $('#totals').html('<p class="text-danger">Invalid Coupon Code or Coupon Code may be Expired</p>');
                    document.getElementById("couponcode").value = '';
                    $('#disper').hide();
                    $('#disamount').hide();
                    $("#price_val_stripe").val('');
                    $("#price_val_authorize").val('');
                    $("#dcouponcode").val('');
                    $("#disamounts").val('');
                    $("#final_value_price").val('');
                    $("#final_value_sum").val('');
                    $("#final_value_ind").val('');
                    $("distype").val('');
                    $("#dval").val('');
                    $("#wallet_exist").val('');
                    $("#w_price").val('');
                    $("#w_sum").val('');
                    $("#w_ind").val('');
                    $("#w_dval").val('');
                    return false;
                }
                $('#totals').html('<p class="text-info">' + 'Total Amount : ' + test[8] + '</p> ');
                $('#totals').show();
                $('#disper').html('<p class="text-info">' + 'Amount Discount : ' + test[6] + '</p> ');
                $('#disper').show();
                $('#disamount').html('<p class="text-info">' + 'Amount to be paid: ' + test[7] + '</p> ');
                $('#disamount').show();
                $("#price_val_stripe").val(test[2]);
                $("#price_val_authorize").val(test[2]);
                $("#dcouponcode").val(test[0]);
                $("#disamounts").val(test[3] - test[2]);
                $("#final_value_price").val(test[2]);
                $("#final_value_sum").val(test[2]);
                $("#final_value_ind").val(test[2]);
                $("distype").val(test[4]);
                $("#dval").val(test[1]);
                $("#w_price").val(test[2]);
                $("#w_sum").val(test[2]);
                $("#w_ind").val(test[2]);
                $("#w_dval").val(test[1]);
                return false;
            }
        });
        return false;
		
		
		
    }

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
            $("#cc_error_msg").html("");
        }
        return true;
    }
    function emptyValues() {
        document.getElementById("couponcode").value = '';
        $('#disper').hide();
        $('#disamount').hide();
        $("#price_val_stripe").val('');
        $("#price_val_authorize").val('');
        $("#dcouponcode").val('');
        $("#disamounts").val('');
        $("#final_value_price").val('');
        $("#final_value_sum").val('');
        $("#final_value_ind").val('');
        $("distype").val('');
        $("#dval").val('');
        $("#wallet_exist").val('');
        $("#w_price").val('');
        $("#w_sum").val('');
        $("#w_ind").val('');
        $("#w_dval").val('');
        return false;
    }
</script>
<script type="text/javascript">
function myWallet()
{
	var walletAmount = $("#w_wallet").val();
	var bookingtot = $("#w_price").val();
	if($("#wallet_pay").is(':checked')){			
		if(walletAmount!=bookingtot){
			if(walletAmount<bookingtot)
			{	
				useWallet();
			}else{
				useWallet();

				$('#paypal').hide();

				$('#credit_card_forms_stripe').hide();

			    $('#credit_card_forms').hide();

			    $('#stripe-pay-button').hide();

			    $("#card").hide();

			    $('#wallet-pay-button').show();

			    $("input[name='pay']").hide();
			}
		}else{
			$('#paypal').hide();

			$('#credit_card_forms_stripe').hide();

		    $('#credit_card_forms').hide();

		    $('#stripe-pay-button').hide();

		    $("#card").hide();

		    $('#wallet-pay-button').show();

		    $("input[name='pay']").hide();

			//alert("Sorry you can't pay full payment from wallet. ");
		}

	}else {
		alert('no wallet');
		$('#w_totals').hide();

		$('#w_disper').hide();

		$('#w_disamount').hide();

		$("#price_val_stripe").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#price_val_authorize").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_price").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_sum").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#final_value_ind").val('<?php echo $datavalues->row()->totalAmt; ?>');

		//$("distype").val('');

		$("#w_price").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_sum").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_ind").val('<?php echo $datavalues->row()->totalAmt; ?>');

		$("#w_dval").val('');
	}
	
	$("#coupon_id").css('display','none');
}


function useWallet(){
		$.ajax({
			type:'POST',
			url:'<?php echo base_url();?>site/product/useWallet',
			data:{'walletAmount':$('#w_wallet').val(),'total':$('#ttotal').val(),'user_id':$('#tuser_id').val(),'product_id':$("#rental_id").val(),'walletCurrency':$("#w_wallet_cur").val(),'prdCurrency':$("#prd_currency").val()},
			dataType:'json',
			success: function(json){
			var test = json.split("-"); 
	
			var WalletAmt=parseInt(test[6]);	
			var TotalAmt=parseInt(test[8]);		
			if(test[0] == '' || test[0] == 'no')
			{
			$('#w_totals').html('wallet invalid');

			$('#w_disper').hide();

			$('#w_disamount').hide();

			$("#price_val_stripe").val('');

			$("#price_val_authorize").val('');



			$("#wallet_exist").val(test[0]);

			$("#disamounts").val('');

			$("#final_value_price").val('');

			$("#final_value_sum").val('');

			$("#final_value_ind").val('');



			$("#w_price").val('');

			$("#w_sum").val('');

			$("#w_ind").val('');

			$("#w_dval").val('');

				return false;

			} else if (WalletAmt > TotalAmt){
				alert("You Cannot Use Wallet. Your Wallet Amount is Higher then the Total Amount");		
				$('#credit_card_forms_stripe').show();		
				$('#credit_card_forms').show();			
				return false;	
				}

			$('#w_totals').html('<p style="color:#0193e6; margin-right:3px;">'+'Total Amount : '+ test[8] +'</p> ');

			$('#w_totals').show();
	        $('#w_disper').html('<p style="color:#0193e6; margin-right:3px;">'+'Wallet Amount : '+ test[6] +'</p> ');

			$('#w_disper').show();
			$('#w_disamount').html('<p style="color:#0193e6; margin-right:3px;">'+'Amount to be paid: '+ test[7] +'</p> ');

			$("#final_value_price").val(test[9]); 		
			$('#w_disamount').show();		
			$("#price_val_stripe").val(test[7]); 	
			$("#price_val_authorize").val(test[7]); 			
			$("#wallet_exist").val(test[0]);
			$("#disamounts").val(test[4]-test[3]);

			

			$("#final_value_sum").val(test[3]);

			$("#final_value_ind").val(test[3]);

			$("#w_price").val(test[3]);

			$("#w_sum").val(test[3]);

			$("#w_ind").val(test[3]);

			//$("distype").val(test[4]);

			$("#w_dval").val(test[1]);	
			$('#credit_card_forms_stripe').show();		
			$('#credit_card_forms').show();

			return;		

			}
		}); 
}

$("#coupon_Btn").click(function(){
	$("#wallet_id").css('display','none');
});

</script>
<?php
$this->load->view('site/includes/footer');
?>
