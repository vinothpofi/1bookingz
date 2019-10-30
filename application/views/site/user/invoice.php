<!DOCTYPE html >
<head>
	<title> Renters booking </title>
	<link rel="shortcut icon" type="image/x-icon"
		  href="<?= base_url(); ?>images/logo/<?php echo $this->config->item('fevicon_image'); ?>">
</head>
<body style="margin:0px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ccc" data -
	   bgcolor="body-bg-dark" data - module="1" class="ui-sortable-handle currentTable">
	<tbody>
	<tr>
		<td>
			<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="devicewidth"
				   style="background-color:#ffffff;" data - bgcolor="light-gray-bg">
				<tbody>
				<tr>
					<td height="30" bgcolor="#ccc">&nbsp;</td>
				</tr>
				<tr>
					<td align="center">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
							<tbody>
							<tr style="padding: 10px 10px 0px 10px; float: left">
								<td align="center" valign="top">
									<table width="650" border="0" cellpadding="5" cellspacing="1">
										<tbody
											style="font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px;">
										<tr>
											<th width="70" bgcolor="#ff5b61"
												style="color:#fff; font-size:15px;"> <?= $Receipt; ?>
											</th>
											<th width="75"></th>
											<th width="75"></th>
											<th width="75"></th>
											<th align="right" width="75" style="color:#f3402e; text-align:right"><a
													onClick="window.print()" TARGET="_blank"
													style="cursor: pointer; cursor: hand;text-decoration:underline;">
													<?= $Print_Page; ?></a></th>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							</tr >
							<tr>
								<td align="left"
									style="color:#4c4c4c;font-size:13px;font-family:Open Sans, Arial, Helvetica, sans-serif;margin:10px; padding: 10px">
									<?= $Booking_No; ?>: <?= $transid; ?>
								</td>
							</tr>
							<tr>
								<td align="left"
									style="color:#4c4c4c;font-size:13px;font-family:Open Sans, Arial, Helvetica, sans-serif;margin:10px; padding: 10px">
									<?= $Property_Name . ' : ' . $productvalue->row()->product_title; ?>
								</td>
							</tr>
							<tr>
								<td align="left"
									style="color:#4c4c4c;font-size:13px;font-family:Open Sans, Arial, Helvetica, sans-serif;margin:10px; padding: 10px">
									<?php echo $Address . " : ";

									if ($productaddress->row()->street!='') {
									    echo $productaddress->row()->street . ',';
                                    }

                                    if ($productaddress->row()->city!='') {
                                        echo $productaddress->row()->city . ',';
                                    }

                                    if ($productaddress->row()->state!='') {
                                        echo $productaddress->row()->state . ',';
                                    }

                                    if ($productaddress->row()->country!='') {
                                        echo $productaddress->row()->country . ',';
                                    }

                                    if ($productaddress->row()->zip!='') {
                                        echo $productaddress->row()->zip . '.';
                                    }

                                    ?>
								</td>
							</tr>
							<tr>
								<td style="border-top:1px solid #808080" bgcolor="#fff">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
										<tbody>
										<tr style="padding: 10px; float: left">
											<td align="center" valign="top">
												<table width="650" border="0" cellpadding="5" cellspacing="1">
													<tbody
														style="font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px;">
													<tr>
														<th width="75" bgcolor="#EFEFEF"> <?= $check_in; ?></th>
														<th width="5"></th>
														<th width="75" bgcolor="#EFEFEF"> <?= $check_out; ?></th>
														<th width="75"></th>
														<th width="75" bgcolor="#EFEFEF"> <?= $Night; ?></th>
														<th width="75" bgcolor="#EFEFEF"> <?= $Guest; ?></th>
													</tr>
													<tr align="center">
														<td> <?= $checkindate; ?></td>
														<td></td>
														<td> <?= $checkoutdate; ?></td>
														<td></td>
														<td> <?= $Invoicetmp->row()->numofdates; ?></td>
														<td> <?= $Invoicetmp->row()->NoofGuest; ?></td>
													</tr>
													</tbody>
												</table>
											</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr style="pointer-events:none;display: none;">
								<td align="center" valign="top"
									style="color:#000; font-weight: 700; font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px;"
									data - size="body-text" data - min="10" data - max="25" data - color="footer-text">
									<img id="map-image" border="0" alt="<?= $productaddress->row()->address; ?>"
										 src="https://maps.googleapis.com/maps/api/staticmap?center=' .<?= $productaddress->row()->address; ?> '&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?= $productaddress->row()->address ?>&key=<?php echo $this->config->item("google_developer_key"); ?>">
								</td>
							</tr>
							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
							<tr>
								<td align="center">
									<table width="100%" border="0" cellspacing="1" cellpadding="0" align="center"
										   style="padding:0px 10px;">
										<tbody>
										<tr>
											<td align="left" width="300px" valign="top"
												style="color:#4f595b; font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;"
												data - size="body-text" data - min="10" data - max="25" data -
												color="footer-text">
												<h4 style="float: left; width:100%;"> <?= $Cancellation_Policy; ?> -
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= ucfirst($productvalue->row()->cancellation_policy); ?> </h4><?= $Details_Cancellation_Policy; ?>
												<a href="<?= base_url(); ?>pages/cancellation-policy"
												   target="_blank"> <?= $Cancellation_Policy; ?></a>.
											<td>
										</tr>
										<tr>
											<td align="left" width="300px" valign="top"
												style="color:#4f595b; font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;"
												data - size="body-text" data - min="10" data - max="25" data -
												color="footer-text">
												<h4 style="float: left; width:100%; margin: 10px 0px;"> <?php if ($this->lang->line('billing') != '') {
                                    $thereis= stripslashes($this->lang->line('billing'));
                                } else $thereis= "Billing"; ?></h4>
												
												
												
												<table style="width:100%; font-size:13px;">
													<?php if($couponDiscount > 0) { ?>
													<tr>
														<td style="border-bottom: 1px solid #bbb;  padding: 10px 0px;">
															<?= $Coupon; ?>
														</td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"></td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"> <?= $this->session->userdata('currency_s') . ' ' . $couponDiscount; ?>
														</td>
													</tr>
												<?php } ?>
												<?php if($wallet_Amount > 0) { ?>
													<tr>
														<td style="border-bottom: 1px solid #bbb;  padding: 10px 0px;">
															<?= $Wallet; ?>
														</td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"></td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"> <?= $this->session->userdata('currency_s') . ' ' . $wallet_Amount; ?>
														</td>
													</tr>
													<?php } ?>
													<tr>
														<td style="border-bottom: 1px solid #bbb;"> <?= $Bookedfor; ?> <?= $Invoicetmp->row()->numofdates; ?>
															&nbsp;<?= $Night; ?></td>
														<td style="border-bottom: 1px solid #bbb;"></td>
														<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;">
															<?= $this->session->userdata('currency_s'); ?> <?= number_format(($TotalwithoutService - ($wallet_Amount + $couponDiscount)),2); ?>
														</td>
													</tr>
													<tr>
														<td style="border-bottom: 1px solid #bbb;"> <?= $SecurityDeposit; ?></td>
														<td style="border-bottom: 1px solid #bbb;"></td>
														<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;"><?= $this->session->userdata('currency_s') . ' ' . $securityDeposite; ?>
														</td>
													</tr>
													<tr>
														<td style="border-bottom: 1px solid #bbb;"> <?= $ServiceFee; ?></td>
														<td style="border-bottom: 1px solid #bbb;"></td>
														<td style="border-bottom: 1px solid #bbb; padding: 5px 0px;"> <?= $this->session->userdata('currency_s') . ' ' . $servicefee; ?></td>
													</tr>
													<tr>
														<td style="border-bottom: 1px solid #bbb;  padding: 10px 0px;">
															<?= $Total; ?>
														</td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"></td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;">
															<?= $this->session->userdata('currency_s') . ' ' . $paidTotal ; ?>
														</td>
													</tr>
													
													<tr style="display: none;">
														<td style="border-bottom: 1px solid #bbb;  padding: 10px 0px;">
															<?= $Paid; ?>
														</td>
														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"></td>
                                                        <!---- ($wallet_Amount + $couponDiscount) -->

														<td style="border-bottom: 1px solid #bbb;padding: 10px 0px;"><?= $this->session->userdata('currency_s') . ' ' . ($TotalAmt ); ?>
														</td>
													</tr>
												</table>
											<td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							</tr >
							<tr>
								<td>&nbsp;</td>
							</tr>

							<tr>
								<td>&nbsp;</td>
							</tr>
							<tr>
								<td align="center" valign="middle"
									style="color:#444444; font-family:Open Sans, Arial, Helvetica, sans-serif; font-size:13px; padding:0 20px;"
									data - size="body-text" data - min="10" data - max="25" data -
									color="body-text"><?= $need_help; ?> <a href="mailto:<?= $admin_email; ?>"
																			style="color:#0094aa;" data -
																			link -
																			color="plain-url-color"> <?= $admin_email; ?></a>
								</td>
							</tr>
							<tr>
								<td height="50">&nbsp;</td>
							</tr>
							<tr>
								<td height="30" bgcolor="#ccc">&nbsp;</td>
							</tr>
							<tr>
								<td align="center" bgcolor="#fff">
									<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center"
										   style="padding:0px 10px;">
										<tbody>
										</tbody>
									</table>
								</td>
							</tr>
							</tbody>
						</table>
					</td>
				</tr>
				</tbody>
			</table>
</body>
</html >
