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
				<?php $disputeLinks = array('display-dispute', 'display-dispute1', 'cancel-booking-dispute', 'display-dispute2'); ?>
					
							 <li>
                            <a href="<?php echo base_url(); ?>listing/all" <?php if ($this->uri->segment(1) == 'listing') { ?> class="active" <?php } ?>><?php if ($this->lang->line('ManageListings') != '') {
                                    echo stripslashes($this->lang->line('ManageListings'));
                                } else echo "Manage Listings"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>listing-reservation" <?php if ($this->uri->segment(1) == 'listing-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('YourReservations') != '') {
                                    echo stripslashes($this->lang->line('YourReservations'));
                                } else echo "Your Reservations"; ?></a></li>
                
                 <li>
                  <a href="<?php echo base_url(); ?>listing-passed-reservation" <?php if ($this->uri->segment(1) == 'listing-passed-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('ViewPastReserv') != '') {
                                    echo stripslashes($this->lang->line('ViewPastReserv'));
                  } else echo "View Past Reservation History"; ?></a>
                
                </li>
                <li>
                  <a href="<?php echo base_url(); ?>host_cancelled_bookings" <?php if ($this->uri->segment(1) == 'host_cancelled_bookings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('host_cancel') != '') {
                                    echo stripslashes($this->lang->line('host_cancel'));
                  } else echo "Host cancellation"; ?></a>
                
                </li>
                <li>
						<a href="<?php echo base_url(); ?>display-dispute" <?php if (in_array($this->uri->segment(1), $disputeLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute/Cancel') != '') {
								echo stripslashes($this->lang->line('Dispute/Cancel'));
							} else echo "Dispute/Cancel"; ?> <span class="badge"><?php if($tot_dispute_count_is != 0) {echo ' '.$tot_dispute_count_is;} ?></span></a></li>
					   
							
				</ul>
			</div>
			<div class="width80">
				<div class="row">
					<div class="col-sm-12">
						<ul class="nav nav-tabs responsiveNav">
							<li class="active"><a data-toggle="tab"
												  href="#menu1"><?php if ($this->lang->line('Dispute_About_You') != '') {
										echo stripslashes($this->lang->line('Dispute_About_You'));
									} else echo "Dispute About You"; ?><span class="badge"><?php if($dispute_count != 0){echo ' '.$dispute_count;} ?></span></a></a></li>
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
							<li><a data-toggle="tab"
								   onclick="window.location.href='<?php echo base_url(); ?>display-dispute2'"
								   href="<?php echo base_url(); ?>display-dispute2"><?php if ($this->lang->line('cancel_booking') != '') {
										echo stripslashes($this->lang->line('cancel_booking'));
									} else echo "Cancel booking"; ?><span class="badge"><?php if($cancel_count != 0){echo ' '.$cancel_count;} ?></span></a></li>
									<li>

						</li>
						</ul>
						<div class="tab-content marginBottom2">
							<div id="menu1" class="tab-pane fade in active">

								<select style="color: #a61d55;" id="dispute_status" onchange="dispute_status_filter(this.value)";>

                                        <option value=""><?php if ($this->lang->line('select_state') != '') {
                                                echo stripslashes($this->lang->line('select_state'));
                                            } else echo "Search The Status"; ?></option>

                                        <option value="Processing" <?php if($state == 'Processing'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('processing') != '') {
                                                echo stripslashes($this->lang->line('processing'));
                                            } else echo "Processing"; ?></option>

                                        <option value="Completed" <?php if($state == 'Completed'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('completed') != '') {
                                                echo stripslashes($this->lang->line('completed'));
                                            } else echo "Completed"; ?></option>

                                        <option value="Rejected" <?php if($state == 'Rejected'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('rejected') != '') {
                                                echo stripslashes($this->lang->line('rejected'));
                                            } else echo "Rejected"; ?></option>
                                        <option value="Pending" <?php if($state == 'Pending'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('Pending') != '') {
                                                echo stripslashes($this->lang->line('Pending'));
                                            } else echo "Pending"; ?></option>


                                    </select>

								<?php
								$count = $DisputeDetails->num_rows();
								if ($count > 0) {
								    ?>

                                    

								    <?php

									foreach ($DisputeDetails->result() as $review) {
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
														Dispute
														at <?php echo anchor('rental/' . $review->seourl, $review->product_title); ?>
														for Booking No: <?php echo $review->booking_no; ?>
													</div>
												</div>
												<div class="content">
													<?php echo $review->message; ?>
												</div>
												<div class="colRight">
													<div class="email"><?php //echo $review->email; ?>

                                                         <?php if ($this->lang->line('created_at') != '') {
                                                            echo stripslashes($this->lang->line('created_at'));
                                                        } else echo "Cancelled At"; ?> 

                                                        <?php //echo ucfirst($review->firstname." ".$reveiw->lastname); ?>

														- <?php echo date('d-m-Y', strtotime($review->created_date)); ?></div>
												</div>
												<div class="row">
													<div class="btn-group"><?php
                                                        if ($review->status == 'Pending') {

                                                            $checkin = $review->checkin;
                                                            $checkout = $review->checkout;
                                                            if (date('Y-m-d') <= $checkout) {
                                                                ?>
                                                                <button type="button" class="submitBtn1"
                                                                        onclick="acceptDispute(<?php echo $review->id; ?>,'<?php echo $review->booking_no; ?>' );"><?php if ($this->lang->line('Accept') != '') {
                                                                        echo stripslashes($this->lang->line('Accept'));
                                                                    } else echo "Accept";
                                                                     ?></button>
                                                                <button type="button" class="submitBtn"
                                                                        onclick="rejectDispute(<?php echo $review->id; ?>,'<?php echo $review->booking_no; ?>');"><?php if ($this->lang->line('reject') != '') {
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

														} else if($review->status == 'Processing') { ?>

												<button type="button" class="submitBtn1"
																	onclick="completedDispute(<?php echo $review->id; ?>,'<?php echo $review->booking_no; ?>' );"><?php if ($this->lang->line('Processing') != '') {
																	echo stripslashes($this->lang->line('Processing'));
																} else echo "Processing"; ?></button>
																<?php } else if($review->status == 'Completed') { ?>

																	<button type="button" class="submitBtn1">
																<?php echo $review->status; ?>
															</button>

															<?php } else { ?>
															<button type="button" class="submitBtn1">
																<?php echo $review->status; ?>
															</button>
															<?php
														}
														?></div>
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
											if ($this->lang->line('no_dispute_about_you') != '') {
												echo stripslashes($this->lang->line('no_dispute_about_you'));
											} else {
												echo "No dispute about you!";
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
	function acceptDispute(id, booking_no) {
		$('.loading').show();
		$.ajax({
			type: 'POST',
			url: baseURL + 'site/product/acceptDispute',
			data: {'disputeId': id, 'booking_no': booking_no},
			success: function (response) {
				if (response.trim() == 'success') {
					alert("<?php if ($this->lang->line('dispute_accepted') != '') {
						echo stripslashes($this->lang->line('dispute_accepted'));
					} else echo "Dispute Accepted";?>");

				} else {
					boot_alert("<?php if ($this->lang->line('dispute_failed') != '') {
						echo stripslashes($this->lang->line('dispute_failed'));
					} else echo "Accept on dispute failed";?>");
				}
				window.location.href = baseURL + 'display-dispute';
			}
		});
	}

	function completedDispute(id, booking_no){


		//alert(id);alert(booking_no);
		$('.loading').show();
		$.ajax({
			type: 'POST',
			url: baseURL + 'site/product/completedDispute',
			data: {'disputeId': id, 'booking_no': booking_no},
			success: function (response) {
				if (response.trim() == 'success') {
					boot_alert("<?php if ($this->lang->line('dispute_completed') != '') {
						echo stripslashes($this->lang->line('dispute_completed'));
					} else echo "Dispute Completed";?>");

				} else {
					boot_alert("<?php if ($this->lang->line('dispute_failed') != '') {
						echo stripslashes($this->lang->line('dispute_failed'));
					} else echo "Accept on dispute failed";?>");
				}
				window.location.href = baseURL + 'display-dispute';
			}
		});

	}

	function rejectDispute(id, booking_no) {
		$('.loading').show();
		$.ajax({

			type: 'POST',
			url: baseURL + 'site/product/rejectDispute',
			data: {'disputeId': id, 'booking_no': booking_no},
			success: function (response) {
				if (response.trim() == 'success') {
					boot_alert("<?php if ($this->lang->line('dispute_rejected') != '') {
						echo stripslashes($this->lang->line('dispute_rejected'));
					} else echo "Dispute Rejected";?>");

				} else {
					boot_alert("<?php if ($this->lang->line('dispute_reject_failed') != '') {
						echo stripslashes($this->lang->line('dispute_reject_failed'));
					} else echo "Reject on dispute failed";?>");

				}
				window.location.href = baseURL + 'display-dispute';
			}
		});
	}
	function  dispute_status_filter(state) {
		//alert(state);
		if(state == 'Processing'){
			enurl = '0';
		}
		if(state == 'Completed'){
			enurl = '1';
		}
		if(state == 'Rejected'){
			enurl = '2';
		}
		if(state == 'Pending'){
			enurl = '3';
		}
		if(state == ''){
			window.location.href = baseURL + 'display-dispute';
		}

		window.location.href = baseURL + 'display-dispute-filter/' + enurl;
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
