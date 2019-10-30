<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<script type="text/javascript">
		function checkHostPaypalEmail(id) 
		{
			paypalEmail = $("#hostPayPalEmail" + id).val();
			
			if (paypalEmail != 'no')
			{
				return true;
			}
			else 
			{
				alert('No Host Paypal Email.');
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
						<table class="display display_tbl" id="propertyCancel_tbl">
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
								//print_r($trackingDetails);
								//exit;
								foreach ($trackingDetails as $value)
								{
									foreach ($value as $cancel)
									{
										
										$currencyPerUnitSeller = $cancel->currencyPerUnitSeller;
										if($cancel->currency_cron_id==0) { $currencyCronId=''; } else { $currencyCronId=$cancel->currency_cron_id; }
										//echo $currencyCronId.'<br>';
										?>
										<tr>
											<td><?php echo $i;?></td>
											<td><?php echo $cancel->email; ?></td>
											<td><?php echo count($cancel->host_email);?></td>
											<td>
												<!---guest service amount---->
												<?php 
												$cancel_amount_percen = $cancel->subTotal / 100 * $cancel->cancel_percentage;//35.3
												
												$cancel_amount=$cancel->subTotal-$cancel_amount_percen;//317.7
												$cancel_amountWithSecDeposit=$cancel_amount+$cancel->secDeposit;//417.7

												//to Guest
												
												if ($cancel->cancel_percentage != '100')
											    {
													/* for moderate,flexible*/
													if ($admin_currency_code != $cancel->user_currencycode) 
													{
														$TheCancelAMount = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel_amountWithSecDeposit,$currencyCronId);
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
														$TheCancelAMountStrict = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->secDeposit,$currencyCronId);
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
												<!---paid---->
												<?php
												if ($cancel->paid_canel_status == 1)
												{
													if ($cancel->cancel_percentage != '100') 
													{  /*for moderate,flexible*/
														if ($admin_currency_code != $cancel->user_currencycode) 
														{
															$Paid = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->paid_cancel_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
														} 
														else
														{
															$Paid = $cancel->paid_cancel_amount;
														}

														echo $admin_currency_symbol . '' . $Paid;

													} 
													else
													{ /*for strict 100% (SubTot)of amount will take to host,For guest Only sec Deposit will return
*/
														 if ($admin_currency_code != $cancel->user_currencycode)
														{
															$paidStrictAMount = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->paid_cancel_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
														}
														else
														{
															$paidStrictAMount = $cancel->paid_cancel_amount;
														} 

														echo $admin_currency_symbol . ' ' . $paidStrictAMount;
													}

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
													if ($cancel->cancel_percentage != '100')
													{ /* for moderate,flexible*/

														if ($admin_currency_code != $cancel->user_currencycode) 
														{
															$Balence = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->paid_cancel_amount,$currencyCronId);
															//customised_currency_conversion($currencyPerUnitSeller, $cancel->paid_cancel_amount);
														} 
														else
														{
															$Balence = $cancel->paid_cancel_amount;
														}

														echo $admin_currency_symbol . '' . $Balence;
													} 
													else
													{ /*for strict Only Security deposit to guest*/ 
												
												
														 if ($admin_currency_code != $cancel->user_currencycode)
														{
															$balenceStrictAMount = convertCurrency($cancel->user_currencycode, $admin_currency_code, $cancel->secDeposit,$currencyCronId);
															//customised_currency_conversion($currencyPerUnitSeller, $cancel->secDeposit);
														}
														else
														{
															$balenceStrictAMount = $cancel->secDeposit;
														} 
														
														echo $admin_currency_symbol . ' ' . $balenceStrictAMount;
													}
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
													if ($cancel->cancel_percentage != '100')
													{ /*for moderate,flexible*/

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
												}
												else
												{
													$cancel_amount_pay = 0;
												}

												if ($cancel_amount_pay != 0.00)
												{ 
											
												
											//For Strict its enough to sec deposit to guest
											
											?>
													<span class="action_link">
														<a class="p_approve tipLeft" href="admin/dispute/add_pay_form/<?php echo $cancel->booking_no; ?>/<?php echo $cancel->id; ?>" title="Offline Payment Mode" style="margin-bottom:2px;">Offline</a>
													</span>

													<span class="action_link">
									<?php
										$attributes = array('onsubmit' => 'return checkHostPaypalEmail('.$i.')');

										echo form_open('admin/dispute/paypal_Cancelpayment_property', $attributes);
									
										$paypal_amount = $cancel_amount_pay;//original
										//$paypal_amount = $TheCancelAMountStrict;
										
											echo form_input([
												'type'     => 'hidden',
										        'value'    => $paypal_amount,
										        'name' 	   => 'amount_from_db'
										    ]);	
										
										if ($admin_currency_code != 'USD')
										{
											$paypal_amount = convertCurrency($admin_currency_code, 'USD', $paypal_amount);
										}

										$paypal_amount = str_replace(',', '', $paypal_amount);

											echo form_input([
												'type'     => 'hidden',
										        'value'    => $paypal_amount,
										        'name' 	   => 'amount_to_pay'
										        ]);

										    echo form_input([
												'type'     => 'hidden',
										        'value'    => $cancel->email,
										        'name' 	   => 'GuestEmail'
										        ]);

										    echo form_input([
												'type'     => 'hidden',
										        'value'    => $cancel->booking_no,
										        'name' 	   => 'booking_number'
										        ]);	

										    echo form_input([
												'type'     => 'hidden',
										        'value'    => $cancel->host_email,
										        'name' 	   => 'hostEmail'
										        ]);
										    $pplval="";
										    if ($paypalData[$key] != '')
										    {
										    	$pplval = $paypalData[$key];
										    }
										    else
										    {
										    	$pplval = no;
										    }

										    echo form_input([
												'type'     => 'hidden',
										        'value'    => $pplval,
										        'name' 	   => 'guestPayPalEmail',
										        'id'	   => 'guestPayPalEmail'.$i
										        ]);	

										    echo form_input([
												'type'     => 'submit',
										        'value'    => 'Online',
										        'title'    => 'Paypal Online Payment Mode',
										        'class'	   => 'p_approve tipLeft btn_small btn_blue',
												'style'	   => 'height: 20px !important;border: #cb9b0c 1px solid;padding: 4px 8px;font-size: 10px;'
										        ]);

										     echo form_close();
										?>
								</span>
												
								
												<?php } ?>


											</td>
										</tr>

										<?php 
										?>
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
