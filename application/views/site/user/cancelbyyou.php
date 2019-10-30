<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
	<div class="container">
		<div class="loggedIn clear">
			<div class="width20">
				<ul class="sideBarMenu">
					<li>
						<a href="<?php echo base_url(); ?>settings" <?php if ($this->uri->segment(1) == 'settings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('EditProfile') != '') {
								echo stripslashes($this->lang->line('EditProfile'));
							} else echo "Edit Profile"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>photo-video" <?php if ($this->uri->segment(1) == 'photo-video') { ?> class="active" <?php } ?>><?php if ($this->lang->line('photos') != '') {
								echo stripslashes($this->lang->line('photos'));
							} else echo "Photos"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>verification" <?php if ($this->uri->segment(1) == 'verification') { ?> class="active" <?php } ?>><?php if ($this->lang->line('TrustandVerification') != '') {
								echo stripslashes($this->lang->line('TrustandVerification'));
							} else echo "Trust and Verification"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>display-review" <?php if ($this->uri->segment(1) == 'display-review') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {
								echo stripslashes($this->lang->line('Reviews'));
							} else echo "Reviews"; ?></a></li>
					<?php $disputeLinks = array('display-dispute', 'display-dispute1', 'cancel-booking-dispute', 'display-dispute2'); ?>
					<li>
						<a href="<?php echo base_url(); ?>display-dispute" <?php if (in_array($this->uri->segment(1), $disputeLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute/Cancel') != '') {
								echo stripslashes($this->lang->line('Dispute/Cancel'));
							} else echo "Dispute/Cancel"; ?> <span class="badge"><?php if($tot_dispute_count_is != 0) {echo ' '.$tot_dispute_count_is;} ?></span></a></li>
					<li>
						<a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {
								echo stripslashes($this->lang->line('ViewProfile'));
							} else echo "View Profile"; ?></a></li>
				</ul>
			</div>
			<div class="width80">
				<div class="row">
					<div class="col-sm-12">
						<ul class="nav nav-tabs responsiveNav">
							<li><a data-toggle="tab"
								   onclick="window.location.href='<?php echo base_url(); ?>display-dispute'"
								   href="<?php echo base_url(); ?>display-dispute"><?php if ($this->lang->line('Dispute_About_You') != '') {
										echo stripslashes($this->lang->line('Dispute_About_You'));
									} else echo "Dispute About You"; ?><span class="badge"><?php if($dispute_count != 0){echo ' '.$dispute_count;} ?></span></a></li>
							<li><a data-toggle="tab"
								   onclick="window.location.href='<?php echo base_url(); ?>display-dispute1'"
								   href="<?php echo base_url(); ?>display-dispute1"><?php if ($this->lang->line('Dispute_By_You') != '') {
										echo stripslashes($this->lang->line('Dispute_By_You'));
									} else echo "Dispute By You"; ?></a></li>
							<li><a data-toggle="tab"
								   onclick="window.location.href='<?php echo base_url(); ?>cancel-booking-dispute'"
								   href="<?php echo base_url(); ?>cancel-booking-dispute"><?php if ($this->lang->line('cancel_booking_by_you') != '') {
										echo stripslashes($this->lang->line('cancel_booking_by_you'));
									} else echo "Cancel booking by you"; ?></a></li>
							<li class="active"><a data-toggle="tab"
												  href="#menu1"><?php if ($this->lang->line('cancel_booking') != '') {
										echo stripslashes($this->lang->line('cancel_booking'));
									} else echo "Cancel booking"; ?><span class="badge"><?php if($cancel_count != 0){echo ' '.$cancel_count;} ?></span></a></li>
						</ul>
						<div class="tab-content marginBottom2">
							<div id="menu1" class="tab-pane fade in active">
								<?php
								$count = $Canceldisputebooking->num_rows();
								if ($count > 0) {
									foreach ($Canceldisputebooking->result() as $review) {
										?>
										<div class="tableRow reviewList_1">
											<div class="left">
												<?php
												if ($review->image != '' && file_exists('./images/users/' . $review->image)) {
													$imgSource = "images/users/" . $review->image;
												} else {
													$imgSource = "images/users/profile.png";
												}
												echo img($imgSource, TRUE, array('class' => 'userIcon'));
												?>
											</div>
											<div class="right">
												<div class="clear">
													<div class="colLeft">
													</div>
													<div class="colRight">
														Cancel
														at <?php echo anchor('rental/' . $review->seourl, $review->product_title); ?>
														for Booking No: <?php echo $review->booking_no; ?>
													</div>
												</div>
												<div class="content">
													<?php echo $review->message; ?>
												</div>
												<div class="colRight">
													<div class="email"><?php //echo $review->email; ?>

                                                        <?php if ($this->lang->line('to') != '') {
                                                            echo stripslashes($this->lang->line('by'));
                                                        } else echo "by"; ?>

                                                        <?php echo ucfirst($review->firstname." ".$reveiw->lastname); ?>

														- <?php echo date('d-m-Y', strtotime($review->created_date)); ?></div>
												</div>
												<div class="">
													<div class="btn-group">

                                                        <?php
                                                        //echo $review->status;

                                                        if ($review->status == 'Pending') {

                                                            $checkin = $review->checkin;
                                                            $checkout = $review->checkout;

                                                            if (strtotime(date('Y-m-d')) < strtotime($checkin)) {
                                                                ?>
                                                                <button type="button" class="submitBtn1"
                                                                        onclick="cancelbookingdispute(<?php echo $review->id; ?>,'<?php echo $review->booking_no; ?>','<?php echo $review->cancel_status; ?>' );"><?php if ($this->lang->line('Accept') != '') {
                                                                        echo stripslashes($this->lang->line('Accept'));
                                                                    } else echo "Accept"; ?></button>
                                                                <button type="button" class="submitBtn"
                                                                        onclick="rejectBooking(<?php echo $review->id; ?>,'<?php echo $review->booking_no; ?>','<?php echo $review->cancel_status; ?>');"><?php if ($this->lang->line('reject') != '') {
                                                                        echo stripslashes($this->lang->line('reject'));
                                                                    } else echo "Reject"; ?></button>
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <br>
                                                                <span class="badge"><?php if ($this->lang->line('expired') != '') {
                                                                        echo stripslashes($this->lang->line('expired'));
                                                                    } else echo "Pending Request Expired"; ?>
                                                                </span>

                                                                <?php
                                                            }

                                                        } elseif ($review->status == 'Accept') { ?>
															<button style="cursor: none;" type="button" class="submitBtn1"><?php if ($this->lang->line('Canceled') != '') {
																	echo stripslashes($this->lang->line('Canceled'));
																} else echo "Canceled"; ?></button>
															<?php
														} else {
															?>
															<button style="cursor: none;" class="submitBtn1"
																type="button"><?php if ($this->lang->line('rejected') != '') {
																	echo stripslashes($this->lang->line('rejected'));
																} else echo "Rejected"; ?></button>
														<?php }
														?>
													</div>
												</div>
											</div>
										</div>
										<?php
									} ?>
									<div class="myPagination left">
										<?php echo $paginationLink; ?>
									</div>
									<?php
								} else {
									?>
									<div class="tableRow reviewList_1">
										<p class="text-danger text-center"><?php
											if ($this->lang->line('no_cancel_byyou') != '') {
												echo stripslashes($this->lang->line('no_cancel_byyou'));
											} else {
												echo "No Cancel of booking about you!";
											}
											?></p>
									</div>
									<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	function cancelbookingdispute(id, booking_no, cancel_id) {
		$('.loading').show();
		$.ajax({
			type: 'POST',
			url: baseURL + 'site/product/Cancel_Book',
			data: {'disputeId': id, 'booking_no': booking_no, 'cancel_id': cancel_id},
			success: function (response) {
				if (response.trim() == 'success') {
					boot_alert("<?php if ($this->lang->line('cancel_booking_accepted') != '') {
						echo stripslashes($this->lang->line('cancel_booking_accepted'));
					} else echo "Cancel booking accepted";?>");
				} else {
					boot_alert("<?php if ($this->lang->line('cancel_booking_failed') != '') {
						echo stripslashes($this->lang->line('cancel_booking_failed'));
					} else echo "Accept on cancel booking failed";?>");
				}
				window.location.href = baseURL + 'display-dispute2';
			}
		});
	}

	function rejectBooking(id, booking_no, cancel_id) {
		$('.loading').show();
		$.ajax({
			type: 'POST',
			url: baseURL + 'site/product/rejectBooking',
			data: {'disputeId': id, 'booking_no': booking_no, 'cancel_id': cancel_id},
			success: function (response) {
				if (response.trim() == 'success') {
					boot_alert("<?php if ($this->lang->line('cancelation_is_rejected') != '') {
						echo stripslashes($this->lang->line('cancelation_is_rejected'));
					} else echo "Cancellation is rejected";?>");
				} else {
					boot_alert("<?php if ($this->lang->line('cancelation_is_rejected_failed') != '') {
						echo stripslashes($this->lang->line('cancelation_is_rejected_failed'));
					} else echo "Reject on Cancellation failed";?>");
				}
				window.location.href = baseURL + 'display-dispute2';
			}
		});
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
