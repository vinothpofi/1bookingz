<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/order/change_order_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tbl">
							<thead>
							<tr>
								<th class="center">
									<?php
									echo form_input([
										'type' => 'checkbox',
										'value' => 'on',
										'name' => 'checkbox_id[]',
										'class' => 'checkall'
									]);
									?>
								</th>
								<th class="tip_top" title="Click to sort">
									<span style="padding:10px">S.No</span>
								</th>
								<th class="tip_top" title="Click to sort">
									<span style="padding:5px 10px 5px 5px">Booking No</span>
								</th>
								<th class="tip_top" title="Click to sort">Guest Email ID</th>
								<th class="tip_top" title="Click to sort">Product Title</th>
								<th class="tip_top" title="Click to sort">Date Added</th>
								<th class="tip_top" title="Total Booking Amount">Total Amount <i class="fa fa-info-circle"></i></th>
								<th class="tip_top" title="Coupon amount used in orders">Total Discount <i class="fa fa-info-circle"></i></th>
								<th  class="tip_top" title="Service fee">Guest Service Amount</th>
								<th class="tip_top" title="(Sub Total - ((Sub Total * Cancel Percentage)/100)+security deposit)">Cancellation Amount <i class="fa fa-info-circle"></i></th>
								<!--<th>Actual Profit</th>-->
								<th class="tip_top" title="Wallet amount used in orders">Used Wallet Amount <i class="fa fa-info-circle"></i></th>
								<th>paid</th>
								<th class="tip_top" title="Payable amount  - Paid amount">Balance</th>
								<!-- <th><span style="padding:10px">Product Title</span></th> -->
								<th>Booking Status</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if (count($product) > 0) {
								$i = 1;
								foreach ($product as $value)
								{
									foreach ($value as $pro)
									{
										$currencyPerUnitSeller = $pro->currencyPerUnitSeller;
										$minus_checkin = strtotime($pro->checkin);
										$checkinBeforeDay = date('Y-m-d', $minus_checkin);
										$current_date = date('Y-m-d');
										if ($checkinBeforeDay <= $current_date) {
											?>
											<tr>
												<td class="center tr_select ">
													<?php
													echo form_input([
														'type' => 'checkbox',
														'value' => $row->id,
														'name' => 'checkbox_id[]',
														'class' => 'checkall'
													]);
													?>
												</td>
												<td class="center">
													<?php echo $i; ?>
												</td>
												<td class="center">
													<?php echo $pro->Bookingno; ?>
												</td>
												<td class="center">
													<?php echo $pro->email; ?>
												</td>
												<td class="center">
													<?php echo $pro->product_title; ?>
												</td>
												<td class="center">
													<?php echo date('d-m-Y', strtotime($pro->dateAdded)); ?>
												</td>
												<td class="center">
													<!-- TotalAmount-->
													<?php
													$tot_amount = $pro->total_amount;
													$createdDate = date('Y-m-d',strtotime($pro->dateAdded));
													$getCurrencyId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
													if($getCurrencyId=='') { $getCurrencyId=''; }
													if ($admin_currency_code != $pro->user_currencycode)
													{
														//$theTot_amount = customised_currency_conversion($currencyPerUnitSeller, $tot_amount);
														$theTot_amount = currency_conversion($pro->user_currencycode, $admin_currency_code, $tot_amount,$getCurrencyId);
													} 
													else 
													{
														$theTot_amount = $tot_amount;
													}
													echo $admin_currency_symbol . ' ' . $theTot_amount;
													?>
												</td>
												<td class="center">
													<!-- TotalDiscount-->
													
													<?php
													$couponAmount=$pro->total_amt-$pro->discount;
													if($pro->is_coupon_used=="Yes"){	
														if ($admin_currency_code != $pro->user_currencycode)
														{
															$couponAmountFN = currency_conversion($pro->user_currencycode, $admin_currency_code, $couponAmount,$getCurrencyId);
															
															//$couponAmountFN = customised_currency_conversion($currencyPerUnitSeller, $couponAmount);
														}
														else
														{
															$couponAmountFN = $couponAmount;
														}
														
													}else{
														
														$couponAmountFN="0.00";
														
													}												
													echo $admin_currency_symbol . ' ' . $couponAmountFN;
													
												/* 	if ($pro->coupon_discount != '')
													{
														echo $admin_currency_symbol . ' ' . $pro->coupon_discount;
													}
													else 
													{
														echo $admin_currency_symbol . '' . "0.00";
													} */
													?>
												</td>
												<td class="center">
													<!-- Guest Fee-->
													<?php
													$GuestFee = $pro->guest_fee;

													if ($admin_currency_code != $pro->user_currencycode)
													{
														$theGuestFee = currency_conversion($pro->user_currencycode, $admin_currency_code, $GuestFee,$getCurrencyId);
														//$theGuestFee = customised_currency_conversion($currencyPerUnitSeller, $GuestFee);
													}
													else
													{
														$theGuestFee = $GuestFee;
													}
													echo $admin_currency_symbol . ' ' . $theGuestFee;
													?>
												</td>
												<td class="center">
													<!-- cancellation Amount-->
													<?php
													/** Start - Convert Cancel Amount **/
													
													//$cancel_amountBf=$pro->payable_amount-$pro->paid_cancel_amount;
													$cancel_amount_percen = $pro->subTotal / 100 * $pro->enq_cancel_per;//35.3
													$cancel_amount=$pro->subTotal-$cancel_amount_percen;//317.7
													$cancel_amountWithSecDeposit=$cancel_amount+$pro->secDeposit;//417.7
													if ($pro->cancelled == 'Yes')
													{
														if($pro->cancelled_by=='Host'){
															if ($admin_currency_code != $pro->user_currencycode)
														{
																$cancel_amount = currency_conversion($pro->user_currencycode, $admin_currency_code, $tot_amount, $getCurrencyId);
																//$cancel_amount = customised_currency_conversion($currencyPerUnitSeller, $cancel_amountBf);
														}
														else
														{
																$cancel_amount = $tot_amount;	
														}
														
														echo $admin_currency_symbol . ' ' . $tot_amount;
														}else{
														if ($admin_currency_code != $pro->user_currencycode)
														{
																$cancel_amount = currency_conversion($pro->user_currencycode, $admin_currency_code, $cancel_amountWithSecDeposit,$getCurrencyId);
																//$cancel_amount = customised_currency_conversion($currencyPerUnitSeller, $cancel_amountBf);
														}
														else
														{
																$cancel_amount = $cancel_amountWithSecDeposit;	
														}
														
														echo $admin_currency_symbol . ' ' . $cancel_amount;

													}
													}else{
														
														echo $admin_currency_symbol . ' ' . '0.00';
													}

													
													
													?>
												</td>
												<!--<td class="center">
													 Actual Profit
													<?php //$act_pro = ($pro->guest_fee + $pro->host_fee) - $pro->coupon_discount; ?>
													<?php
													/* if ($admin_currency_code != $pro->currencycode)
													{
														$theActualProfit = customised_currency_conversion($currencyPerUnitSeller, $act_pro);
													}
													else 
													{
														$theActualProfit = $act_pro;
													}

													echo $admin_currency_symbol . ' ' . $theActualProfit; */
													?>
												</td>-->
												<td class="center">
													<?php
													if ($pro->booking_walletUse != '')
													{
														//echo $admin_currency_symbol . ' ' . number_format($pro->booking_walletUse);
														
														if ($admin_currency_code != $pro->user_currencycode)
														{
															$WalletAmount = currency_conversion($pro->user_currencycode, $admin_currency_code, $pro->booking_walletUse,$getCurrencyId);
															//$WalletAmount = customised_currency_conversion($currencyPerUnitSeller, $pro->booking_walletUse);
														}
														else
														{
															$WalletAmount = $pro->booking_walletUse;
														}
														
														echo $admin_currency_symbol . '' . $WalletAmount;
													}
													else
													{
														echo $admin_currency_symbol . '' . "0.00";
													}
													?>
												</td>
												<td class="center">
												
													<?php if ($pro->paid_status == 'yes')
													{
														/** Start - Convert Cancel Amount **/
														$cancel_amountBf = $pro->payable_amount-$pro->paid_cancel_amount;
														
														if ($admin_currency_code != $pro->user_currencycode)
														{
																$cancel_amount = currency_conversion($pro->user_currencycode, $admin_currency_code, $cancel_amountBf,$getCurrencyId);
																//$cancel_amount = customised_currency_conversion($currencyPerUnitSeller, $cancel_amountBf);
														}
														else
														{
																$cancel_amount = $cancel_amountBf;
														}
														/** End - Convert Cancel Amount **/

														/** Start - Convert Payable Amount **/
														$payable = $pro->payable_amount;
														if ($admin_currency_code != $pro->user_currencycode)
														{
															$thePayable = currency_conversion($pro->user_currencycode, $admin_currency_code, $payable,$getCurrencyId);
															//$thePayable = customised_currency_conversion($currencyPerUnitSeller, $payable);
														}
														else
														{
															$thePayable = $payable;
														}
														/** End - Convert Payable Amount **/

														/** Paid AMount*/
														if ($pro->cancelled == 'Yes')
														{
															$thepaidAmount = $cancel_amount;
														}
														else
														{
															$thepaidAmount = $thePayable;
														}
														/** Paid AMount*/

														echo $admin_currency_symbol . '' . $thepaidAmount;
													} 
													else 
													{
														echo $admin_currency_symbol . '' . "0.00";
													} ?>
													
													
												</td>
												<td class="center">
											
												<?php if ($pro->paid_status == 'no')
												{
													/** Start - Convert Cancel Amount **/
													$cancel_amountBf = $pro->payable_amount-$pro->paid_cancel_amount;
													
		
													if ($admin_currency_code != $pro->user_currencycode)
													{	
														$cancel_amount = currency_conversion($pro->user_currencycode, $admin_currency_code, $cancel_amountBf,$getCurrencyId);
													}
													else
													{
														$cancel_amount = $cancel_amountBf;
														
													}
													
													
													/** End - Convert Cancel Amount **/

													/** Start - Convert Payable Amount **/
													$payable = $pro->payable_amount;
													if ($admin_currency_code != $pro->user_currencycode)
													{
														$thePayable = currency_conversion($pro->user_currencycode, $admin_currency_code, $payable,$getCurrencyId);
														//customised_currency_conversion($currencyPerUnitSeller, $payable);
													}
													else
													{
														$thePayable = $payable;
													}
													/** End - Convert Payable Amount **/

													/** Balence AMount*/
													if ($pro->cancelled == 'Yes')
													{
														/*check policy here*/
														    
															
														 $thebalenceAmount = $cancel_amount;
		
						}
													else
													{
														$thebalenceAmount = $thePayable;
													}
													/** Balence AMount*/

													echo $admin_currency_symbol . '' . $thebalenceAmount;
													
												}
												else
												{
													echo $admin_currency_symbol . '' . "0.00";
												}
												?>
											</td>
												<td class="center">
													<?php echo $pro->booking_status; ?>
												</td>
											</tr>
											<?php
										}
									}
									$i++;
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th class="tip_top" title="Click to sort">Guest Email ID</th>
								<th>Product Title</th>
								<th class="tip_top" title="Click to sort">Date Added</th>
								<th>Total Amount</th>
								<th>Total Discount</th>
								<th>Guest Service Amount</th>
								<th>Cancellation Amount</th>
							<!--	<th>Actual Profit</th>-->
								<th>Used Wallet Amount</th>
								<th>paid</th>
								<th>Balance</th>
								<!-- <th>Product Title</th> -->
								<th class="tip_top" title="Click to sort">Booking Status</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<?php
				echo form_input([
					'type'     => 'hidden',
					'id'       => 'statusMode',
					'name' 	   => 'statusMode'
					 ]);

				echo form_input([
					'type'     => 'hidden',
					'id'       => 'SubAdminEmail',
					'name' 	   => 'SubAdminEmail'
					 ]);

				echo form_close();	
			?>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
