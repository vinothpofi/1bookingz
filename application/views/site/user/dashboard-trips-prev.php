<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
$today =  date('Y-m-d h:i:s',strtotime(date('Y-m-d h:i:s', strtotime("-2 days"))));
//$today =  date('Y-m-d h:i:s');
?>
<section>
	<div class="container">
		<div class="loggedIn clear">
			<div class="width20">
				<ul class="sideBarMenu">
					<li>
						<a href="<?php echo base_url(); ?>trips/upcoming" <?php if ($this->uri->segment(2) == 'upcoming') { ?> class="active" <?php } ?>><?php if ($this->lang->line('YourTrips') != '') {
								echo stripslashes($this->lang->line('YourTrips'));
							} else echo "Your Trips"; ?></a></li>
					<li><a href="<?php echo base_url(); ?>trips/previous"
							<?php if ($this->uri->segment(2) == 'previous') { ?> class="active" <?php } ?>><?php if ($this->lang->line('PreviousTrips') != '') {
								echo stripslashes($this->lang->line('PreviousTrips'));
							} else echo "Previous Trips"; ?></a></li>
				</ul>
			</div>
			<div class="width80">
				<div class="row">
					<div class="col-sm-12">
						<div class="searchTable clear">
							<?php
							echo form_open('');
							if ($this->lang->line('Search Your Trips') != '') {
								$placeholder = stripslashes($this->lang->line('Search Your Trips'));
							} else $placeholder = "Search Your Trips";
							if ($this->lang->line('Search') != '') {
								$btnValue = stripslashes($this->lang->line('Search'));
							} else $btnValue = "Search";
							echo form_input('product_title', '', array('placeholder' => $placeholder));
							echo form_submit('submit', $btnValue, array('class' => 'submit'));
							echo form_close();
							?>
						</div>
						<div class="table-responsive">
						<table class="table  table-striped">
							<tr>
								<th width="10%"><?php if ($this->lang->line('BookedOn') != '') {
										echo stripslashes($this->lang->line('BookedOn'));
									} else echo "Booked On"; ?></th>
								<th width="10%"><?php if ($this->lang->line('PropertyName') != '') {
										echo stripslashes($this->lang->line('PropertyName'));
									} else echo "Property Name"; ?></th>
								<th width="5%"><?php if ($this->lang->line('Host') != '') {
										echo stripslashes($this->lang->line('Host'));
									} else echo "Host"; ?></th>
								<th width="30%"><?php if ($this->lang->line('DatesandLocation') != '') {
										echo stripslashes($this->lang->line('DatesandLocation'));
									} else echo "Dates and Location"; ?></th>
								<th width="5%"><?php if ($this->lang->line('Amount') != '') {
										echo stripslashes($this->lang->line('Amount'));
									} else echo "Amount"; ?></th>
								<th width="10%"><?php if ($this->lang->line('Status') != '') {
										echo stripslashes($this->lang->line('Status'));
										} else echo "Status"; ?></th>
							</tr>
							<?php
							if ($bookedRental->num_rows() > 0) {
								foreach ($bookedRental->result() as $row) {
									$pr_details = $this->cms_model->get_all_details(USERS, array('id' => $row->user_id));
									?>
									<tr>
										<td><?php echo date('M d, Y', strtotime($row->dateAdded)); ?></td>
										<td>
											<?php
											$imgSrc = 'dummyProductImage.jpg';
											if ($row->product_image != "" && file_exists('./images/rental/' . $row->product_image)) {
												$imgSrc = $row->product_image;
											}
											echo img(base_url() . 'images/rental/' . $imgSrc);?>
											<a href="<?php echo base_url() . "rental/" . $row->seourl; ?>">
											<?php 
												$prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$row);

												echo ucfirst($prod_tiltle); 
												//echo ucfirst($row->product_title); 
											?>
											</a>
											
											
										</td>
										<td><?php echo $row->firstname; ?></td>
										<td>
											<?php if ($row->checkin != '0000-00-00 00:00:00' && $row->checkout != '0000-00-00 00:00:00') {
												echo date('M d, Y', strtotime($row->checkin)) . " - " . date('M d, Y', strtotime($row->checkout));
											} ?>
											<div class="reduceFont"><?php
												if ($row->city_name != '') echo $row->city_name;
												if ($row->city_name != '' && $row->state_name != '') echo ', ';
												if ($row->state_name != '') echo $row->state_name;
												if ($row->country_name != '' && $row->state_name != '') echo ', ';
												if ($row->country_name != '') echo $row->country_name . '.'; ?></div>
											<div><?php
												if ($this->lang->line('booking_no') != '') {
													echo stripslashes($this->lang->line('booking_no'));
												} else echo "Booking No";
												?> : <?php echo $row->bookingno; ?>
											</div>
										</td>
										<td><span class="number_s120">
                                                <?php echo $currencySymbol;
												if ($row->offer > 0) {
													echo strtoupper($currencySymbol) . " " . number_format(CurrencyValue($row->product_id, $row->totalAmt), 2);
													echo '<li style="text-decoration: line-through;">' . strtoupper($currencySymbol) . " " . number_format($row->offer * $this->session->userdata('currency_r'), 2) . '</li>';
												} else {
													if ($row->secDeposit != 0) {
														$securityDeposite = $row->secDeposit;
													}
													$totalAmount = $row->subTotal + $row->serviceFee + $securityDeposite;
													$currency = $row->currency;
													if ($row->user_currencycode != $this->session->userdata('currency_type')) {
														if ($currency_result->$currency) {
															$price = $totalAmount / $currency_result->$currency;
														} else {
															$price = currency_conversion($row->user_currencycode, $this->session->userdata('currency_type'), $totalAmount,$row->currency_cron_id);
														}
														echo ' ' . number_format($price, 2);
													} else {
														echo $totalAmount;
													}
												} ?>
                                    </span>
											<?php
											//echo $row->currency;
											$currency = $row->currency;
											if ($row->walletAmount != '0.00') {
												if ($this->lang->line('Wallet') != '') {
													$wallet = stripslashes($this->lang->line('Wallet'));
												} else $wallet = "Wallet";
												echo "$wallet: " . $currencySymbol;
												if ($row->currency != $this->session->userdata('currency_type')) {
													if ($currency_result->$currency) {
														$price = $totalAmount / $currency_result->$currency;
													} else {
														$price = currency_conversion($currency, $this->session->userdata('currency_type'), $totalAmount);
													}
													echo ' ' . number_format($price, 2);
												} else {
													echo $row->walletAmount;
												}
												echo " " . $this->session->userdata('currency_type');
											}
											if ($row->is_coupon_used == 'Yes') {
												echo "Coupon : " . $currencySymbol;
												$couponPrice = ($row->total_amt - $row->discount);
												if ($row->currency != $this->session->userdata('currency_type')) {
													if ($currency_result->$currency) {
														$price = $totalAmount / $currency_result->$currency;
													} else {
														$price = currency_conversion($currency, $this->session->userdata('currency_type'), $totalAmount);
													}
													echo ' ' . number_format($price, 2);
												} else {
													echo $couponPrice;
												}
												echo " " . $this->session->userdata('currency_type');
											}
											?>
										</td>
										<td>
											<?php if ($row->booking_status == "Booked") {
												echo '<p>';
												echo date('M d, Y',strtotime($row->dateAdded));
												echo '</p>';
												if ($row->booking_status == "Booked") {
													if ($this->lang->line(Booked) != '') {
														echo stripslashes($this->lang->line('Booked'));
													} else echo "Booked";
												}
												if ($this->lang->line('Expired') != '') {
													echo ' ('.stripslashes($this->lang->line('Expired')).')';
												} else echo " (Expired)";
											} else {
												if ($row->booking_status == "Booked") {
													if ($this->lang->line('Booked') != '') {
														echo stripslashes($this->lang->line('Booked'));
													} else echo "Booked";
												} else {
													$paymentstatus = $this->product_model->get_all_details(PAYMENT, array('Enquiryid' => $row->cid));
													$chkval = $paymentstatus->num_rows();
													$chkval1 = $paymentstatus->row()->status;
													if ($row->approval == 'Accept' && ($chkval == 0 || $chkval1 == 'Pending')) { ?>
														Expired<br>(Not Paid)</br><?php } else {
														if ($this->lang->line('Pending') != '') {
															echo stripslashes($this->lang->line('Pending'));
														} else echo "Pending";
													}
												}
											} ?>
											<?php if ($row->booking_status == "Booked") { ?>
												<a href="<?php echo base_url(); ?>site/user/invoice/<?php echo $row->bookingno; ?>"
												   target="_blank"><?php if ($this->lang->line('Receipts/Invoice') != '') {
														echo stripslashes($this->lang->line('Receipts/Invoice'));
													} else echo "Receipts/Invoice"; ?></a>
												<?php
												if($row->cancelled != "Yes"){
												$this->data['reviewData_all'] = $this->product_model->get_trip_review_all($userDetails->row()->id);
												$this->data['reviewData'] = $this->product_model->get_trip_review($row->bookingno, $userDetails->row()->id);
												$this->data['hostreviewData'] = $this->product_model->get_trip_review_host($row->bookingno, $userDetails->row()->id);
												if ($this->data['reviewData']->num_rows() == 0) { ?>
													<a data-toggle="modal" href="#add_review"
													   onclick="return add_data(this,'0')"
													   user_id="<?php echo $row->renter_id; ?>"
													   product_id="<?php echo $row->product_id; ?>"
													   reviewer_id="<?php if ($userDetails != 'no') {
														   echo $userDetails->row()->id;
													   } ?>" booking_no="<?php if ($userDetails != 'no') {
														echo $row->bookingno;
													} ?>" pro_title="<?php echo $row->product_title; ?>"
													   img_src="<?php echo ($row->product_image != "" && file_exists("images/rental/" . $row->product_image)) ? base_url() . 'images/rental/' . $row->product_image : base_url() . 'images/rental/dummyProductImage.jpg'; ?>"><?php if ($this->lang->line('Review') != '') {
															echo stripslashes($this->lang->line('Review'));
														} else echo "Review"; ?></a>
												<?php } else { ?>
													<a data-toggle="modal" href="#display_review"
													   onclick="return booking_review(this)"
													   user_id="<?php echo $row->renter_id; ?>"
													   product_id="<?php echo $row->product_id; ?>"
													   booking_no="<?php echo $row->bookingno; ?>"
													   reviewer_id="<?php if ($userDetails != 'no') {
														   echo $userDetails->row()->id;
													   } ?>"><?php if ($this->lang->line('YourReview') != '') {
															echo stripslashes($this->lang->line('YourReview'));
														} else echo "Your Review"; ?></a>
												<?php } ?>
<?php
												 /* Review to host */

                               if ($this->data['hostreviewData']->num_rows() == 0) { ?>
                                   <br>
                                   <a data-toggle="modal" href="#add_review"
                                      onclick="return add_data(this,'1')"
                                      user_id="<?php echo $row->renter_id; ?>"
                                      product_id="<?php echo $row->product_id; ?>"
                                      reviewer_id="<?php if ($userDetails != 'no') {
                                          echo $userDetails->row()->id;
                                      } ?>" booking_no="<?php if ($userDetails != 'no') {
                                       echo $row->bookingno;
                                   } ?>" pro_title="<?php echo $row->product_title; ?>"
                                      img_src="<?php echo ($row->product_image != "" && file_exists("images/rental/" . $row->product_image)) ? base_url() . 'images/rental/' . $row->product_image : base_url() . 'images/rental/dummyProductImage.jpg'; ?>"><?php if ($this->lang->line('ReviewOwner') != '') {
                              echo stripslashes($this->lang->line('ReviewOwner'));
                              } else echo "Review Owner"; ?></a>
                               <?php } else { ?>
                                   <br>
                                   <a data-toggle="modal" href="#display_review"
                                      onclick="return booking_review(this,'1')"
                                      user_id="<?php echo $row->renter_id; ?>"
                                      product_id="<?php echo $row->product_id; ?>"
                                      booking_no="<?php echo $row->bookingno; ?>"
                                      reviewer_id="<?php if ($userDetails != 'no') {
                                          echo $userDetails->row()->id;
                                      } ?>"><?php if ($this->lang->line('ReviewOwner') != '') {
                              echo stripslashes($this->lang->line('OwnerReview'));
                              } else echo "Owner Review"; ?></a>
                               <?php } 
											}
                           /* Review to host */

                           ?>

												<?php
												$Check_date = $this->product_model->get_all_details(RENTALENQUIRY, array('user_id' => $user_id, 'prd_id' => $row->product_id));
												//print_r($Check_date->result_array());
												$time_val = date('Y-m-d');
												$check_in = date("Y-m-d", strtotime($row->checkin));
												$check_out = date("Y-m-d", strtotime($row->checkout));
												$dis_details = $this->product_model->get_all_details(DISPUTE, array('user_id' => $user_id, 'prd_id' => $row->product_id, 'booking_no' => $row->bookingno));
												$admin = $this->product_model->getAdminSettings(ADMIN_SETTINGS);
												$dipute_day = $admin->row()->dispute_days;
												$after_day = strtotime("+" . $dipute_day . "days", strtotime($check_in));
												$out_date = date('Y-m-d', $after_day);
												$hideCancelDay = $this->config->item('cancel_hide_days_property');
												$totlessDays = $hideCancelDay + 1; //from checkin date before (n) days
												$minus_checkin = strtotime("-" . $totlessDays . "days", strtotime($check_in));
												$checkinBeforeDay = date('Y-m-d', $minus_checkin);
												if ($dis_details->num_rows() != 0){
													if ($dis_details->row()->cancel_status == 1) { ?>
														<br><a data-toggle="modal"
															   href="#disputed_<?php echo $row->bookingno; ?>"
															   onclick="return add_data(this)"
															   user_id="<?php echo $row->renter_id; ?>"
															   product_id="<?php echo $row->product_id; ?>"
															   reviewer_id="<?php if ($userDetails != 'no') {
																   echo $userDetails->row()->id;
															   } ?>"
															   booking_no="<?php if ($userDetails != 'no') {
																   echo $row->bookingno;
															   } ?>"><?php if ($this->lang->line('Canceled') != '') {
																echo stripslashes($this->lang->line('Canceled'));
															} else echo "Canceled"; ?></a>
													<?php } elseif ($dis_details->row()->cancel_status == 0) { ?>
														<br><a data-toggle="modal"
															   href="#disputed_<?php echo $row->bookingno; ?>"
															   onclick="return add_data(this)"
															   user_id="<?php echo $row->renter_id; ?>"
															   product_id="<?php echo $row->product_id; ?>"
															   reviewer_id="<?php if ($userDetails != 'no') {
																   echo $userDetails->row()->id;
															   } ?>"
															   booking_no="<?php if ($userDetails != 'no') {
																   echo $row->bookingno;
															   } ?>"><?php if ($this->lang->line('Disputed') != '') {
																echo stripslashes($this->lang->line('Disputed'));
															} else echo "Disputed"; ?></a>
													<?php }
												} ?>
												<br>
												<a data-toggle="modal" href="#message"
												   onclick="return post_discussion(this)"
												   renter_id="<?php echo $row->renter_id; ?>"
												   product_id="<?php echo $row->product_id; ?>"
												   booking_no="<?php echo $row->bookingno; ?>"
												   reviewer_id="<?php if ($userDetails != 'no') {
													   echo $userDetails->row()->id;
												   } ?>"><?php if ($this->lang->line('Message') != '') {
														echo stripslashes($this->lang->line('Message'));
													} else echo "Message"; ?></a>
											<?php } ?>
										</td>
									</tr>
								<?php }
							} else {
								?>
								<tr>
									<td colspan="8"><p
											class="text-center text-danger"> <?php if ($this->lang->line('Youhaveno') != '') {
												echo stripslashes($this->lang->line('Youhaveno'));
											} else echo "You have no current trips."; ?> </p></td>
								</tr>
								<?php
							} ?>
						</table>
					</div>
					</div>
					<div class="col-lg-12 myPage">
						<div class="myPagination">
							<?php echo $paginationLink; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- My Review Modal -->
<div id="display_review" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2><?php if ($this->lang->line('Your Review') != '') {
               echo stripslashes($this->lang->line('Your Review'));
               } else echo "Your Review"; ?></h2>
         </div>
         <div class="modal-body">
            <div class="tableRow reviewList_1 noBorder">
               <div class="left">
                  <?php
                     if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
                         $imgSource = "images/users/" . $userDetails->row()->image;
                     } else {
                         $imgSource = "images/users/profile.png";
                     }
                     echo img($imgSource, TRUE, array('class' => 'userIcon'));
                     ?>
               </div>
               <div class="right">
                  <?php
                     $reviewData = $this->data['reviewData_all'];
                     if ($reviewData != '') {
                         foreach ($reviewData->result_array() as $review):
                          $id_str="listing_";
                                if($review['review_type']==1){
                                    $id_str="owner_";
                                }
                          ?>
                  <div style="display: none;"
                                     id="<?php echo $id_str.$review['bookingno']; ?>" class="PropReview PropReview_<?php echo $review['bookingno']; ?>">
                                    <div class="clear">
                                        <div class="colLeft">
                                            <div class="starRatingOuter1">
                                                <div class="starRatingInner1"
                                                     style="width: <?php echo $review['total_review'] * 20 ?>%;"></div>
                                            </div>
                                        </div>
                                        <div class="colRight">
                                            Booking No: <?= $review['bookingno']; ?>
                                        </div>
                                    </div>
                                    <div class="content"><?php echo $review['review']; ?>
                                    </div>
                                    <div class="colRight">
                                        <div class="email"><?php echo $review['email']; ?>
                                            - <?php echo date('d-m-Y', strtotime($review['dateAdded'])); ?>
                                        </div>
                                    </div>
                                </div>
                  <?php endforeach;
                     } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!--Add new review for the property-->
<div id="add_review" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2><?php if ($this->lang->line('Add Review') != '') {
               echo stripslashes($this->lang->line('Add Review'));
               } else echo "Add Review"; ?></h2>
         </div>
         <div class="modal-body">
            <div class="tableRow reviewList_1 noBorder">
               <div class="left">
                  <img src="" id="pro_img" class="userIcon">
               </div>
               <div class="right">
                  <div class="clear">
                     <div class="colLeft">
                        <h5 id="pro_title" class="text-capitalize"></h5>
                        <?php if ($this->lang->line('booking_no') != '') { echo stripslashes($this->lang->line('booking_no'));
               } else echo "Booking No"; ?> : <span id="booking_no_show"></span>
                     </div>
                  </div>
				  
				  
			   
				  
				  
                  <div class="content">
                     <label><?php if ($this->lang->line('My review') != '') {
                        echo stripslashes($this->lang->line('My review'));
                        } else echo "My review"; ?><span>*</span>
                     <small style="color:#666;">
                     (<?php if ($this->lang->line('Exclude personally identifiable information such as name, email address, etc') != '') {
                        echo stripslashes($this->lang->line('Exclude personally identifiable information such as name, email address, etc'));
                        } else echo "Exclude personally identifiable information such as name, email address, etc"; ?>
                     )
                     </small>
                     </label>
                     <?php if ($loginCheck != '') {
						echo form_open('site/product/add_review', array('id' => 'reviewFormSubmit'));
						echo form_input(array('name' => 'redirect', 'value' => $this->uri->segment(1) . '/' . $this->uri->segment(2), 'type' => 'hidden'));
                        echo form_input(array('name' => 'proid', 'id' => 'proid', 'type' => 'hidden'));
                        echo form_input(array('name' => 'user_id', 'id' => 'user_id', 'type' => 'hidden'));
                        echo form_input(array('name' => 'type', 'id' => 'type', 'type' => 'hidden','value'=>'0'));
                        echo form_input(array('name' => 'bookingno', 'id' => 'booking_no', 'type' => 'hidden'));
                        echo form_input(array('name' => 'reviewer_id', 'value' => $userDetails->row()->id, 'type' => 'hidden'));
                        echo form_input(array('name' => 'reviewer_email', 'value' => $userDetails->row()->email, 'type' => 'hidden'));
                        echo form_textarea(array('required' => 'required','name' => 'review', 'id' => 'review-text-value', 'rows' => '5', 'maxlength' => '300'));
                        ?>
                     <div class="rating">
                        <?php if ($this->lang->line('Rating') != '') {
                           echo stripslashes($this->lang->line('Rating'));
                           } else echo "Rating"; ?> :
                        <?php
                           echo form_radio('total_review', '5', FALSE,  array("id" => "star5"), '') . '<label for="star5" title="5 star" >5 star</label> ';
                           echo form_radio('total_review', '4', FALSE, array("id" => "star4"), '') . '<label for="star4" title="4 star" >4 star</label> ';
                           
                           echo form_radio('total_review', '3', FALSE, array("id" => "star3"), '') . '<label for="star3" title="3 star" >3 star</label> ';
                           
                           echo form_radio('total_review', '2', FALSE, array("id" => "star2"), '') . '<label for="star2" title="2 star" >2 star</label> ';
                           
                           echo form_radio('total_review', '1', FALSE, array("id" => "star1"), '') . '<label for="star1" title="1 star" >1 star</label> ';
                           
                           } ?>
                     </div>
                  </div>
				   <?php if ($this->lang->line('Submit my review') != '') {
                        $myrev= stripslashes($this->lang->line('Submit my review'));
                        } else $myrev= "Submit my review"; 
                        if ($this->lang->line('reviewing') != '') {
                        $reviewing= stripslashes($this->lang->line('reviewing'));
                        } else $reviewing= "Reviewing..";

                        ?>
                  <div class="colRight">
<a class="email" style="display:none;" id="rev_btn_loading"><i class="fa fa-spinner fa-spin"></i> <?php echo $reviewing; ?></a>
                     <?php
                        echo form_button('makeReview', "$myrev", array('onClick' => 'add_review();', 'class' => 'submitBtn1', 'id' => 'rev_sub'));
                        echo form_close();
                        ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Message Modal -->
<div id="message" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h2 class="mHead"><?php if ($this->lang->line('Message to Host') != '') {
               echo stripslashes($this->lang->line('Message to Host'));
               } else echo "Message to Host"; ?></h2>
         </div>
         <div class="modal-body">
		 <?php if ($this->lang->line('send_message_to_host') != '') {
               $sendMsg= stripslashes($this->lang->line('send_message_to_host'));
               } else $sendMsg= "Send Message to Host"; ?>
		 
		 
            <div>
               <?php
                  echo form_open('site/product/add_discussion', array('id' => 'add_discussion'));
                  echo form_input(array('name' => 'rental_id', 'id' => 'rental_id', 'type' => 'hidden'));
                  echo form_input(array('name' => 'sender_id', 'id' => 'sender_id', 'type' => 'hidden'));
                  echo form_input(array('name' => 'receiver_id', 'id' => 'receiver_id', 'type' => 'hidden'));
                  echo form_input(array('name' => 'bookingno', 'id' => 'booking_id', 'type' => 'hidden'));
                  echo form_input(array('name' => 'posted_by', 'value' => 'posted_by', 'type' => 'hidden'));
                  echo form_input(array('name' => 'redirect', 'value' => $this->uri->segment(1) . '/' . $this->uri->segment(2), 'type' => 'hidden'));
                  echo form_textarea(array('name' => 'message', 'placeholder' => "$sendMsg", 'id' => 'message-text', 'rows' => '7','required'=>'required'));
                  echo form_submit('', ($this->lang->line('Send') != '') ? stripslashes($this->lang->line('Send')) : 'Send', array('class' => 'submitBtn1'));
                  echo form_close();
                  ?>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
function add_data(evt,type) {
       var product_id = $(evt).attr('product_id');
       var reviewer_id = $(evt).attr('reviewer_id');
       var booking_no = $(evt).attr('booking_no');
       var user_id = $(evt).attr('user_id');
       var pro_title = $(evt).attr('pro_title');
       var img_src = $(evt).attr('img_src');
       $('#add_review #user_id').val(user_id);
       $('#add_review #proid').val(product_id);
       $('#add_review #booking_no').val(booking_no);
       $('#add_review #booking_no_show').html(booking_no);
       $('#add_review #pro_title').html(pro_title);
       $('#add_review #pro_img').attr("src", img_src);
       $('#add_review #type').val(type);
   }
   /*Create add review form values*/
   function add_review() {

    $('#rev_btn_loading').show();
    $('#rev_sub').hide();
    
		var ratings=document.getElementsByName("total_review");
		var check1=0;
		for (i=0;i<ratings.length;i++){
			if(ratings[i].checked){
				check1++;
				break;
			}
		}
		if ($('textarea#review-text-value').val() == '') {
            $('#rev_btn_loading').hide();
             $('#rev_sub').show();
           $('#review-text-value').focus();
           return false;
		}
		else if(check1){
		}else{
     
			alert("<?php if ($this->lang->line('give_a_rating') != '') {
					echo stripslashes($this->lang->line('give_a_rating'));
               } else echo "Give a Rating"; ?>");
               $('#rev_btn_loading').hide();
             $('#rev_sub').show();
			return false;
		}

       $('#reviewFormSubmit').submit();
   }
   /*Showing review*/
   function booking_review(evt,type) {
       var booking_no = $(evt).attr('booking_no');
       var user_id = $(evt).attr('user_id');
       $('.PropReview').hide();
        if(type==1){
            $('#owner_' + booking_no).show();
        }else {
            $('#listing_' + booking_no).show();
        }
   }
   /*Show send message form*/
   function post_discussion(evt) {
       $('#rental_id').val($(evt).attr('product_id'));
       $('#sender_id').val($(evt).attr('reviewer_id'));
       $('#receiver_id').val($(evt).attr('renter_id'));
       $('#booking_id').val($(evt).attr('booking_no'));
   }
</script>

<?php
$this->load->view('site/includes/footer');
?>
