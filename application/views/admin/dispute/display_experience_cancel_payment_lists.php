<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<script type="text/javascript">
	function checkHostPaypalEmail(id)
	{
		paypalEmail = $("#hostPayPalEmail" + id).val();
		if (paypalEmail != 'no') {
			return true;
		}
		else {
			alert('No Guest Paypal Email.');
			return false;
		}
	}
</script>

<div id="content">
	<div class="grid_container">
		<?php
		?>
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
					</div>
				</div>
				<div class="widget_content">
					<table class="display display_tbl" id="commission_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">SNo.</th>
							<th class="tip_top" title="Click to sort">Guest Email Id</th>
							<th class="tip_top" title="Click to sort">Total orders</th>
							<th class="tip_top" title="(Subtotal - ((Subtotal*Cancel Percentage)/100)+Security Deposit)">Cancellation Amount <a class="fa fa-info-circle"></a></th>
							<th class="tip_top" title="Click to sort">Paid</th>
							<th class="tip_top" title="Click to sort">Balance</th>
							<th>Options</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if (count($trackingDetails) > 0)
						{
							$i = 1;
							foreach ($trackingDetails as $value)
							{
								foreach ($value as $cancel)
								{
									if($cancel->currency_cron_id==0) { $currencyCronId=''; } else { $currencyCronId=$cancel->currency_cron_id; }
									$currencyPerUnitSeller = $cancel->currencyPerUnitSeller;
									?>
									<tr>
										<td><?php echo $i; ?></td>
										<td><?php echo $cancel->email; ?></td>
										<td><?php echo count($cancel->host_email); ?></td>
										<?php /*<td>
										
											<!--guest service amount-->
											<?php
											
												if ($admin_currency_code != $cancel->currencycode)
												{
													$CancelAmount = currency_conversion($cancel->currencycode,$admin_currency_code,$cancel->paid_cancel_amount,$cancel->currency_cron_id);
													//$CancelAmount = customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);

												}
												else
												{
													$CancelAmount = $cancel->paid_cancel_amount;
												}
											
											echo $admin_currency_symbol . '' . $CancelAmount;
											
											echo "--" . $cancel->Bookingno;
											?>
											

										</td> */ ?>
										<td>
											<!---guest service amount---->
											<?php 
											$cancel_amount_percen = $cancel->subTotal / 100 * $cancel->exp_cancel_percentage;//13.587
											$cancel_amount=$cancel->subTotal-$cancel_amount_percen;//679.35-13.587 = 665.763
											$cancel_amountWithSecDeposit=$cancel_amount+$cancel->secDeposit;//665.763+679.35 ==> 1345.113
											//echo $cancel_amountWithSecDeposit;
											//to Guest
											
											if ($cancel->exp_cancel_percentage != '100')
											{
												/* for moderate,flexible*/
												if ($admin_currency_code != $cancel->user_currencycode) 
												{
													$TheCancelAMount = currency_conversion($cancel->user_currencycode,$admin_currency_code,$cancel_amountWithSecDeposit,$currencyCronId);//convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel_amountWithSecDeposit,$currencyCronId);
													//customised_currency_conversion($currencyPerUnitSeller, $cancel_amountWithSecDeposit);
												} 
												else
												{
													$TheCancelAMount = $cancel_amountWithSecDeposit;
												}

												echo $admin_currency_symbol . ' ' . $TheCancelAMount;

											} 
											else
											{
												//if stricts Only Security deposit amount to guest
												
												 if ($admin_currency_code != $cancel->user_currencycode)
												{
													$TheCancelAMountStrict = currency_conversion($cancel->user_currencycode,$admin_currency_code,$cancel->secDeposit,$currencyCronId);//convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->secDeposit,$currencyCronId);
												}
												else 
												{
													$TheCancelAMountStrict = $cancel->secDeposit;
												}
												 
												
												

												echo $admin_currency_symbol . ' ' . $TheCancelAMountStrict;
											} 

											echo "--" . $cancel->booking_no;
											?>
											
											
											
										</td>
										<td>
											<!---paid-->
											<?php
											if ($cancel->paid_canel_status == 1)
											{
												if ($admin_currency_code != $cancel->user_currencycode)
												{
													//$PaidCancel = customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
													$PaidCancel = currency_conversion($cancel->user_currencycode,$admin_currency_code,$cancel->paid_cancel_amount,$currencyCronId);
												}
												else
												{
													$PaidCancel = $cancel->paid_cancel_amount;
												}
												echo $admin_currency_symbol . '' . $PaidCancel;												
											}
											else
											{
												echo $admin_currency_symbol . '' . "0.00";
											}
											?>
										</td>
										<td>
											<!---option---->
											<?php
											if ($cancel->paid_canel_status == 0)
											{
												
												if ($admin_currency_code != $cancel->user_currencycode)
												{
													//$Balance = customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
													$Balance = currency_conversion($cancel->user_currencycode,$admin_currency_code,$cancel->paid_cancel_amount,$currencyCronId);
												}
												else
												{
													$Balance = $cancel->paid_cancel_amount;
												}
												
																						
												echo $admin_currency_symbol . '' . $Balance;
												
											}
											else
											{
												echo $admin_currency_symbol . '' . "0.00";
											}
											?>
											
										</td>
										<td>
											<?php
											if ($cancel->paid_canel_status == 0)
											{
												//echo 'inside'.$admin_currency_code.'|'.$cancel->user_currencycode;
												//$cancel_amount_pay = $cancel->paid_cancel_amount;
												if ($admin_currency_code != $cancel->user_currencycode)
													{
														$cancel_amount_pay = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->paid_cancel_amount,$currencyCronId);
														//customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
													}
													else
													{
														$cancel_amount_pay = $cancel->paid_cancel_amount;
													}
											}
											else
											{
												$cancel_amount_pay = 0;
											}

											if ($cancel_amount_pay != 0.00)
											{
											
												
												?>
												<span class="action_link">
													<a class="p_approve tipLeft" href="admin/dispute/add_experience_pay_form/<?php echo $cancel->booking_no; ?>" title="Offline Payment Mode" style="margin-bottom:2px">Offline
													</a>
												</span>
												<span class="action_link">
									<?php
									$attributes = array('onsubmit' => 'return checkHostPaypalEmail('.$i.');');
									echo form_open('admin/dispute/paypal_payment_CancelAmount', $attributes);
									
										$paypal_amount = $cancel_amount_pay;
										
											echo form_input([
												'type'     => 'hidden',
										        'value'    => $paypal_amount,
										        'name' 	   => 'amount_from_db'
										        ]);	

										if ($admin_currency_code != 'USD')
										{
											echo 'inside';
											//$PayPalAmount = customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
											$PayPalAmount = currency_conversion('USD',$admin_currency_code,$cancel_amount_pay,$currencyCronId);
										}
										else
										{
											$PayPalAmount = $cancel_amount_pay;
										}

										
											echo form_input([
											'type'     => 'hidden',
									        'value'    => $PayPalAmount,
									        'name' 	   => 'amount_to_pay'
									        ]);	

											echo form_input([
											'type'     => 'hidden',
									        'value'    => $cancel->booking_no,
									        'name' 	   => 'booking_number'
									        ]);

									        echo form_input([
											'type'     => 'hidden',
									        'value'    => $cancel->email,
									        'name' 	   => 'GuestEmail'
									        ]);

									        $cncleml = "";
									        if ($paypalData[$key] != '')
									        {
									        	 $cncleml = $paypalData[$key];
									        }
									        else
									        {
									        	$cncleml = no;
									        }

									        echo form_input([
											'type'     => 'hidden',
									        'value'    => $cncleml,
									        'name' 	   => 'guestPayPalEmail',
									        'id'	   => 'hostPayPalEmail'.$i
									        ]);
									        	
										?>
										<button type='submit' class="p_approve tipLeft btn_small btn_blue" style="height: 20px !important;border: #cb9b0c 1px solid;padding: 4px 8px;font-size: 10px;"  title="Paypal Online Payment Mode">Online</button>
									<?php echo form_close(); ?>
								</span>
								
											
								
											<?php } else{ ?>

											<span class="action_link">Paid</span>	

											<?php } ?>
										</td>
									</tr>
									<?php
									$i++;
								}
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">SNo.</th>
							<th class="tip_top" title="Click to sort">Guest Email Id</th>
							<th class="tip_top" title="Click to sort">Total orders</th>
							<th class="tip_top" title="(Subtotal - ((Subtotal*Cancel Percentage)/100)+Security Deposit)">Cancellation Amount <a class="fa fa-info-circle"></a></th>
							<th class="tip_top" title="Click to sort">Paid</th>
							<th class="tip_top" title="Click to sort">Balance</th>
							<th>Options</th>
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
		?>
	</div>
	<span class="clear"></span>
</div>
</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
