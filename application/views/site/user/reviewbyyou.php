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
							
					<?php $review_link = ''; if(!empty($userDetails)) { if($userDetails->row()->group == 'Seller') { $review_link = 'display-review'; }else if($userDetails->row()->group == 'User'){  $review_link = 'display-review1'; } } ?>
					<li>
						<a href="<?php echo base_url().$review_link; ?>" <?php if ($this->uri->segment(1) == 'display-review' || $this->uri->segment(1) == 'display-review1') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {
								echo stripslashes($this->lang->line('Reviews'));
							} else echo "Reviews"; ?></a></li>
							
					<?php $dispute_link = ''; if(!empty($userDetails)) { if($userDetails->row()->group == 'Seller') { $dispute_link = 'display-dispute'; }else if($userDetails->row()->group == 'User'){  $dispute_link = 'display-dispute1'; } } ?>
					<li>
						<a href="<?php echo base_url().$dispute_link; ?>" <?php if ($this->uri->segment(1) == 'display-dispute') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute') != '') {
								echo stripslashes($this->lang->line('Dispute'));
							} else echo "Dispute"; ?></a></li>
					<li>
						<a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {
								echo stripslashes($this->lang->line('ViewProfile'));
							} else echo "View Profile"; ?></a></li>
				</ul>
			</div>
			<div class="width80">
				<div class="row">
					<div class="col-sm-12">
						<ul class="nav nav-tabs">
							 <?php if(!empty($userDetails)) { ?>
								<?php if($userDetails->row()->group == 'Seller') { ?>
										<li><a data-toggle="tab"
									onclick="window.location.href='<?php echo base_url(); ?>display-review'"
									href="<?php echo base_url(); ?>display-review"><?php if ($this->lang->line('ReviewsAboutYou') != '') {
										echo stripslashes($this->lang->line('ReviewsAboutYou'));
										} else echo "Reviews About You"; ?></a></li>
								<?php } ?>
								
							<?php if($userDetails->row()->group == 'User') { ?>
							<li class="active"><a data-toggle="tab"
												  href="#menu1"><?php if ($this->lang->line('ReviewsbyYou') != '') {
										echo stripslashes($this->lang->line('ReviewsbyYou'));
									} else echo "Reviews by You"; ?></a></li>
							<?php } } ?>
						</ul>
						<div class="tab-content marginBottom2">
							<div id="menu1" class="tab-pane fade in active">
								<?php
								$count = $ReviewDetails->num_rows();
								if ($count > 0) {
									foreach ($ReviewDetails->result() as $review) {
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
														<div class="starRatingOuter1">
															<div class="starRatingInner1"
																 style="width: <?php echo $review->total_review * 20 ?>%;"></div>
														</div>
													</div>
													<div class="colRight">
														at <?php echo anchor('rental/' . $review->seourl, $review->product_title); ?>
														for Booking No: <?php echo $review->bookingno; ?>
													</div>
												</div>
												<div class="content">
													<?php echo $review->review; ?>
												</div>
												<div class="content">
													<?php if($review->review_type == '0'){$for_rev = 'Rental';}else{$for_rev = 'Host';} ?>
													<span class="badge"><?php echo $for_rev; ?></span>
												</div>
												<div class="colRight">
													<div class="email">

                                                        <?php //echo $review->email; ?>

                                                        <?php if ($this->lang->line('to') != '') {
                                                            echo stripslashes($this->lang->line('to'));
                                                        } else echo "to"; ?>

                                                        <?php echo ucfirst($review->firstname." ".$reveiw->lastname); ?>

														- <?php echo date('d-m-Y', strtotime($review->dateAdded)); ?></div>
												</div>
											</div>
										</div>
										<?php
									}
									?>
									<div class="myPagination left">
										<?php echo $paginationLink; ?>
									</div>
									<?php
								} else {
									?>
									<div class="tableRow reviewList_1">
										<p class="text-danger text-center"><?php
											if ($this->lang->line('no_past_reviews') != '') {
												echo stripslashes($this->lang->line('no_past_reviews'));
											} else {
												echo "No past reviews found!";
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
<?php
$this->load->view('site/includes/footer');
?>
