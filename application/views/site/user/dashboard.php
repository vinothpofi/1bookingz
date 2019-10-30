<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
	<div class="container">
		<div class="dashboard loggedIn clear">
			<div class="row">
				<div class="col-sm-3 width20">
					<div class="left">
						<div class="profile_I">
							<?php
							if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
								$imgSource = "images/users/" . $userDetails->row()->image;
							} else {
								$imgSource = "images/users/profile.png";
							}
							echo img($imgSource, TRUE, array('class' => 'opacity'));
							echo img($imgSource, TRUE, array('class' => 'dp'));
							?>
						</div>
						<div
							class="name"><?php echo ucfirst($userDetails->row()->firstname . ' ' . $userDetails->row()->lastname); ?></div>
						<a href="<?php echo base_url(); ?>settings" class="editPro"><i class="fa fa-pencil"
																					   aria-hidden="true"></i>
							<?php if ($this->lang->line('buildyourprofile') != '') {
								echo stripslashes($this->lang->line('buildyourprofile'));
							} else echo "build your profile"; ?></a>
						<a href="users/show/<?php echo $userDetails->row()->id; ?>"
						   class="viewPro"><?php if ($this->lang->line('ViewProfile') != '') {
								echo stripslashes($this->lang->line('ViewProfile'));
							} else echo "View Profile"; ?> <i class="fa fa-sign-in"
															  aria-hidden="true"></i></a>
					</div>
				</div>
				<div class="col-sm-9 width80">
					<div class="right">
						<p class="text-danger text-center"><?php echo $this->session->flashdata('errorMsg'); ?></p>
                        <?php if ($this->session->flashdata('sErrMSG')) { ?>
                            <div class="alert alert-success alert-dismissable">
                                <?php echo $this->session->flashdata('sErrMSG') ?>
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            </div>
                        <?php }
						if ($userDetails->row()->id_verified == 'No' || $userDetails->row()->accno == '') {
							?>
							<div class="panel panel-default">
								<div class="panel-heading"><?php if ($this->lang->line('Alerts') != '') {
										echo stripslashes($this->lang->line('Alerts'));
									} else echo "Alerts"; ?></div>
								<div class="panel-body">
									<?php if ($userDetails->row()->accno == '' AND $userDetails->row()->accname == '' AND $userDetails->row()->bankname == '') {
										if ($this->lang->line('Pleasetellus') != '') {
											$anchorText = stripslashes($this->lang->line('Pleasetellus'));
										} else $anchorText = "Please tell us how to pay you.";
										echo anchor('account-payout', $anchorText, array());
									}
									if ($userDetails->row()->id_verified == 'No') { ?>
										<div class="divider"></div>
										<?php if ($this->lang->line('Pleaseconfirm') != '') {
											echo stripslashes($this->lang->line('Pleaseconfirm'));
										} else echo "Please confirm your email address by clicking on the link we just emailed you. If you cannot find the email, you can";
										if ($this->lang->line('requestanew') != '') {
											$anchorText = stripslashes($this->lang->line('requestanew'));
										} else $anchorText = "request a new confirmation email";
										echo anchor('site/user/verification/verfiy-mail', ' ' . $anchorText, array());
									} ?>
								</div>
							</div>
							<?php
						}
						$result = 0;
						if ($userDetails->row()->id != '') {
							$this->db->select('*');
							$this->db->from(MED_MESSAGE);
							$this->db->where('receiverId', $userDetails->row()->id);
							$this->db->where('msg_read', 'No');
							$this->db->group_by('bookingNo');
							$result = $this->db->get()->num_rows();
						}
						?>
						<div class="panel panel-default">
							<div class="panel-heading"><?php if ($this->lang->line('Messages') != '') {
									echo stripslashes($this->lang->line('Messages'));
								} else echo " New Messages"; ?> <span class="number_s120">( <?php echo $result; ?>
									)</span></div>
							<div class="panel-body">
								<?php
								if ($result > 0) {
									if ($this->lang->line('Youhavereceived') != '') {
										echo stripslashes($this->lang->line('Youhavereceived'));
									} else echo "You have Received"; ?> <span
										class="number_s120"> <?php echo $result; ?> </span> <?php if ($this->lang->line('newmessages') != '') {
										echo stripslashes($this->lang->line('newmessages'));
									} else echo "New Message(s)";
									if ($this->lang->line('viewmessage') != '') {
										$anchorText = stripslashes($this->lang->line('viewmessage'));
									} else $anchorText = "view message";
									echo anchor('inbox', $anchorText, array('class' => 'asideR'));
								} else {
									if ($this->lang->line('Nomessagesto') != '') {
										echo stripslashes($this->lang->line('Nomessagesto'));
									} else echo "No New Messages to show";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><?php if ($this->lang->line('Verifications') != '') {
									echo stripslashes($this->lang->line('Verifications'));
								} else echo "Verifications"; ?></div>
							<div class="panel-body">
								<p><?php if ($this->lang->line('EmailAddressVerification') != '') {
										echo stripslashes($this->lang->line('EmailAddressVerification'));
									} else echo "Email Address Verification"; ?> </p>
								<p>
									<?php if ($userDetails->row()->id_verified == 'No') {
										if ($this->lang->line('Pleaseverifyyour') != '') {
											echo stripslashes($this->lang->line('Pleaseverifyyour'));
										} else echo "Please verify your email address by clicking the link in the message we just sent to:";
										echo $userDetails->row()->email;
										if ($this->lang->line('Cantfind') != '') {
											echo stripslashes($this->lang->line('Cantfind'));
										} else echo "Can’t find our message? Check your spam folder or resend the confirmation email.";
									} ?></p>
								<div class="verify">
									<?php
									if ($this->lang->line('Verified') != '') {
										$Verified = stripslashes($this->lang->line('Verified'));
									} else {
										$Verified = "Verified";
									}
									if ($this->lang->line('No verifications yet,To get verify') != '') {
										$NoVerified = stripslashes($this->lang->line('No verifications yet,To get verify'));
									} else {
										$NoVerified = "No verifications yet,To get verify";
									}
									if ($userDetails->row()->id_verified == 'No') {
										?>
										<img src="<?php echo base_url(); ?>images/unverified150x50.png"
											 width="30">
										<?php echo $NoVerified; ?>
										<a href="<?php echo base_url('verification'); ?>"
										   class="asideR"><?php if ($this->lang->line('Click here') != '') {
												echo stripslashes($this->lang->line('Click here'));
											} else echo "Click here"; ?></a>
									<?php } else {
										?>
										<img src="<?php echo base_url(); ?>images/verifiedIcon.png" width="30">
										<?php echo $Verified; ?>
										<a href="<?php echo base_url('verification'); ?>"
										   class="asideR"><?php if ($this->lang->line('AddMore') != '') {
												echo stripslashes($this->lang->line('AddMore'));
											} else echo "AddMore"; ?></a>
										<?php
									} ?>
								</div>
								<?php
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading"><?php if ($this->lang->line('available_coupons') != '') {
									echo stripslashes($this->lang->line('available_coupons'));
								} else echo "Available Coupons"; ?>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
								<table class="table  table-striped">
									<tr>
										<th><?php if ($this->lang->line('S.no') != '') {
												echo stripslashes($this->lang->line('S.no'));
											} else echo "S.no"; ?></th>
										<th><?php if ($this->lang->line('coupon_name') != '') {
												echo stripslashes($this->lang->line('coupon_name'));
											} else echo "Coupon Name"; ?></th>
										<th><?php if ($this->lang->line('coupon_code') != '') {
												echo stripslashes($this->lang->line('coupon_code'));
											} else echo "Coupon Code"; ?></th>
										<th><?php if ($this->lang->line('prodcut_list') != '') {
												echo stripslashes($this->lang->line('prodcut_list'));
											} else echo "Prodcut List"; ?></th>
										<th><?php if ($this->lang->line('from') != '') {
												echo stripslashes($this->lang->line('from'));
											} else echo "From"; ?></th>
										<th><?php if ($this->lang->line('to') != '') {
												echo stripslashes($this->lang->line('to'));
											} else echo "to"; ?></th>
										<th><?php if ($this->lang->line('limit_count') != '') {
												echo stripslashes($this->lang->line('limit_count'));
											} else echo "Limit Count"; ?></th>
										<th><?php if ($this->lang->line('Status') != '') {
												echo stripslashes($this->lang->line('Status'));
											} else echo "Status"; ?></th>
									</tr>
									<?php
									if ($couponData->num_rows() > 0) {
										$i = 1;
										foreach ($couponData->result() as $coupon) {
											if (($coupon->quantity - $coupon->purchase_count) > 0) {
												$type = $coupon->price_type == 1 ? 'flat' : '%';
												?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $coupon->coupon_name; ?></td>
													<td><?php echo $coupon->code . ' (' . $coupon->price_value . ' ' . $type . ')'; ?></td>
													<td style="text-align: center;" class="table-prd-img">
														<?php
														if ($coupon->product_id != '') {
															$sel_product = "select p.id,p.seourl,p.product_title from " . PRODUCT . " p where p.status= 'Publish' and p.id IN (" . $coupon->product_id . ")";
															$productData = $this->user_model->ExecuteQuery($sel_product);
															foreach ($productData->result() as $product) {
																?>
																<div>
																	<a href="<?php echo base_url() . 'rental/' . $product->seourl; ?>">
																		<label
																			class="tab-prod-title"><?php echo $product->product_title; ?></label></a>
																</div>
																<?php
															}
														} else {
															echo 'All';
														}
														?>
													</td>
													<td><?php echo $coupon->datefrom; ?></td>
													<td><?php echo $coupon->dateto; ?></td>
													<td><?php echo $coupon->quantity - $coupon->purchase_count; ?></td>
													<td><?php echo $coupon->status; ?></td>
												</tr>
												<?php $i++;
											}
										}
									} else {
										?>
										<tr>
											<td colspan="8"><p class="text-danger text-center">No Coupons
													Found!</p></td>
										</tr>
										<?php
									}
									?>
								</table>
							</div>
								<div class="myPagination">
									<?php echo $paginationLink; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
$this->load->view('site/includes/footer');
?>
