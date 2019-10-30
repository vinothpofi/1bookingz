<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
$product = $productList->row();
$BookingUser = $BookingUserDetails->row();
$unitprice = $productList->row()->unitPerCurrencyUser;
$user_currencycode = $productList->row()->currencycode;
$currencyCode = $this->db->where('id', $Rental_id)->get(PRODUCT)->row()->currency;
$servicetax = $service_tax->row();
$country = $countryList;
$booking_user_currency = $product->user_currencycode;
?>
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
									<?php $avg_val = round($product->rate); ?>
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
					<!--<div class="divider"></div>-->
					<div class="tableRow total">
						<div class="left">
							<p><span class="number_s120"><?php 
								$base_val_json = json_decode($product->base_billing_val);
                             $this->data['base_subtotal'] = $base_val_json->base_subtotal;
                            $this->data['base_taxValue'] = $base_val_json->base_taxValue;
                            $this->data['base_securityDeposite'] = $base_val_json->base_securityDeposite;
                            $global_price = $product->subTotal;



								echo $currencySymbol;
									$commission = $product->serviceFee + $product->secDeposit;
									$pricePerNight = number_format(($product->totalAmt - $commission) / $product->numofdates, 2);

									if($booking_user_currency != $this->session->userdata('currency_type'))
			                        {
			                            if($this->session->userdata('currency_type') != $currencyCode){
			                            $global_price = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$this->data['base_subtotal'],$BookingUser->currency_cron_id);
			                            }else{
			                                $global_price = $this->data['base_subtotal'];
			                            }
			                        
			                        }else{
			                             $global_price = $product->subTotal;
			                        }

									$singleNight = $global_price/$product->numofdates;
									echo number_format($singleNight, 2);
									//echo number_format($global_price, 2);
									?>
									for <?php echo $product->numofdates; ?> </span> <?php if ($product->numofdates > 1) {
									if ($this->lang->line('Nights') != '') {
										echo stripslashes($this->lang->line('Nights'));
									} else echo "Nights";
								} else {
									if ($this->lang->line('night') != '') {
										echo stripslashes($this->lang->line('night'));
									} else echo "Night";
								} ?> </p>
						</div>
						<div class="right">
							<p class="number_s120"> <?php echo $currencySymbol;
								//$OnlyForDays = $global_price * $product->numofdates;
								$OnlyForDays = $global_price;
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
						$productCurrency = $product->currency;
						/*echo $product->currency.'|'.$this->session->userdata('currency_type').'nag'.$currency_result->$productCurrency.'/'; 
						if ($product->currency != $this->session->userdata('currency_type')) {
							if ($currency_result->$productCurrency) {

								$serviceFee = $product->serviceFee / $currency_result->$productCurrency;
							} else {

								$serviceFee = currency_conversion($productCurrency, $this->session->userdata('currency_type'), $product->serviceFee);
							}
						} else {
							
							//$serviceFee = currency_conversion($productCurrency, $this->session->userdata('currency_type'), $product->serviceFee);
							$serviceFee = $product->serviceFee;
						}
						*/
						$serviceFee = $product->serviceFee;
						

		                if($booking_user_currency != $this->session->userdata('currency_type'))
                        {
                            if($this->session->userdata('currency_type') != $currencyCode){
                                $serviceFee = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$this->data['base_taxValue'],$BookingUser->currency_cron_id);
                            }else{
                                $serviceFee = $this->data['base_taxValue'];
                            }
                        
                        }else{
                             $serviceFee = $product->serviceFee;
                        }

						
						?>
						
						<div class="right">
							<p class="number_s120"> <?php echo $currencySymbol . number_format($serviceFee, 2); ?> </p>
						</div>
					</div>
					<div class="tableRow">
						<div class="left">
							<p> <?php if ($this->lang->line('SecurityDeposit') != '') {
									echo stripslashes($this->lang->line('SecurityDeposit'));
								} else echo "Security Deposit"; ?> </p>
						</div>
						<?php
						/*if ($productCurrency != $this->session->userdata('currency_type')) {
							if ($currency_result->$productCurrency) {
								$secDeposit = $product->secDeposit / $currency_result->$productCurrency;
							} else {
								$secDeposit = currency_conversion($productCurrency, $this->session->userdata('currency_type'), $product->secDeposit);
							}
						} else {
							// $secDeposit = currency_conversion($productCurrency, $this->session->userdata('currency_type'), $product->secDeposit);

							$secDeposit = $product->secDeposit;
						}*/
						$secDeposit = $product->secDeposit;
						if($booking_user_currency != $this->session->userdata('currency_type'))
                        {
                            if($this->session->userdata('currency_type') != $currencyCode){
                                $secDeposit = changeCurrency($currencyCode,$this->session->userdata('currency_type'),$this->data['base_securityDeposite'],$BookingUser->currency_cron_id);
                            }else{
                                $secDeposit = $this->data['base_securityDeposite'];
                            }
                        
                        }else{
                             $secDeposit = $product->secDeposit;
                        }
						?>
						<div class="right">
							<p class="number_s120"> <?php echo $currencySymbol . number_format($secDeposit, 2); ?> </p>
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
							<h5> <?php echo $currencySymbol .  $GrandtotalAmt = number_format($secDeposit + $serviceFee + $OnlyForDays, 2); ?></h5>
						</div>
					</div>
					<p class="bottom"> <?php if ($this->lang->line('cancel_trip_msgOne') != '') {
							echo stripslashes($this->lang->line('cancel_trip_msgOne'));
						} else echo "You can Cancel Your trip untill before"; ?><b><?php echo " ".$cancelBeforeDay . " "; ?></b></p>
				</div>
			</div>
			<div class="col-md-7">
				<div class="paymentLeft">
					<h2 class="marginBottom3"> <?php if ($this->lang->line('Who_coming') != '') {
							echo stripslashes($this->lang->line('Who_coming'));
						} else echo "Who’s coming"; ?>?</h2>
					<div class="tableRow contactTitle marginBottom2">
						<div class="left">
							<h5> <?php if ($this->lang->line('Say_hello_to_your_host') != '') {
									echo stripslashes($this->lang->line('Say_hello_to_your_host'));
								} else echo "Say hello to your host"; ?> </h5>
							<p> <?php if ($this->lang->line('Let') != '') {
									echo stripslashes($this->lang->line('Let'));
								} else echo "Let"; ?>

                                <span style="color: #151515;font-weight: 600;">
                                    <?php echo ucfirst($product->firstname); ?>
                                </span>

								<?php if ($this->lang->line('known_about_ur_comming') != '') {
									echo stripslashes($this->lang->line('known_about_ur_comming'));
								} else echo "know a little about yourself and why you’re coming"; ?>.</p>
						</div>
						<div class="right">
							<?php
							$userphoto = 'profile.png';
							if ($product->userphoto != "" && file_exists('./images/rental/' . $product->userphoto)) {
								$userphoto = $product->userphoto;
							}
							echo img(base_url() . 'images/users/' . $userphoto);
							?>
						</div>
					</div>
					<?php
					if ($product->choosed_option == 'book_now') {
						$submit_url = 'site/user/booking_confirm/' . $this->uri->segment(2);
					} elseif ($product->choosed_option == 'instant_pay') {
						$submit_url = 'site/user/booking_confirm_instant/' . $this->uri->segment(2);
					} else {
						$submit_url = 'site/user/booking_confirm/' . $this->uri->segment(2);
					}
					echo form_open($submit_url, array('method' => 'post','onsubmit' => 'inloader();'));
					if ($this->lang->line('Message your host') != '') {
						$msg_placeholder = stripslashes($this->lang->line('Message your host'));
					} else $msg_placeholder = "Message your host";
					echo form_textarea('message', '', array('required' => 'required', 'placeholder' => $msg_placeholder, 'class' => 'marginBottom2'));
					echo form_hidden('Bookingno', $product->Bookingno);
					if ($instant == 'Yes') {
						if ($this->lang->line('PAY and BOOK') != '') {
							$btn_val = stripslashes($this->lang->line('PAY and BOOK'));
						} else $btn_val = "PAY and BOOK";
					} else {
						if ($this->lang->line('Book Now') != '') {
							$btn_val = stripslashes($this->lang->line('Book Now'));
						} else $btn_val = "Book Now";
					}?> <button type="button" class="submitBtn1 submitLeft" onclick="goBack()"><?php if ($this->lang->line('prev_page') != '') {
							echo stripslashes($this->lang->line('prev_page'));
						} else echo "Previous Page"; ?></button> <?php
					echo form_submit('', $btn_val, array('class' => 'submitBtn1'));
					echo form_close();
					?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
function goBack() {
	$('.loading').show();
  window.history.back();
}
</script>
<script type="text/javascript">
	function inloader()
		{
			 $('.loading').show();
			// 'cancel_policy/' . $this->uri->segment(2)
		

		}
</script>
<?php
$this->load->view('site/includes/footer');
?>
