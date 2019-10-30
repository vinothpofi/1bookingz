<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Rental Dispute</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Booking Number','booking_no', $commonclass);
									?>
									<div class="form_input">
										<?php echo ucfirst($review_details->row()->booking_no); ?>
									</div>
								</div>
							</li>
                            <li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Rental Name ','title', $commonclass);
									?>
									<div class="form_input">
										<?php echo ucfirst($review_details->row()->product_title); ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Rental Name ','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->message; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Dispute Email Address','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->email; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Host Name','description', $commonclass);	
									?>
									<div class="form_input">
										<?php 
										if ($review_details->row()->med_senderid == $review_details->row()->host_id)
										{
											$host_id = $review_details->row()->med_senderid;
										}
										else
										{
											$host_id = $review_details->row()->med_receiverid;
										} 

										$host_details = $this->review_model->get_all_details(USERS, array('id' => $host_id)); 
										
										echo $host_details->row()->user_name; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('User Name','description', $commonclass);
									?>
									<div class="form_input">
										<?php
										if ($review_details->row()->med_senderid != $review_details->row()->host_id) 
										{
											$user_id = $review_details->row()->med_senderid;
										} 
										else
										{
											$user_id = $review_details->row()->med_receiverid;
										} 

										 $user_details = $this->review_model->get_all_details(USERS, array('id' => $user_id));

										  echo $user_details->row()->user_name; ?>
									</div>
								</div>
							</li>
                            <li class="btn_cls">
                                <div class="form_grid_12">

                                    <?php
                                    echo form_label('Status','status', $commonclass);
                                    ?>
                                <div style="">
							<?php 
							if ($review_details->row()->status == 'Pending')
							{
                                $checkin=$review_details->row()->checkin;
                                $checkout=$review_details->row()->checkout;
                             if (strtotime(date('Y-m-d')) < strtotime(date(/*'Y-m-d',*/ $checkout))) {
                                ?>

                                        <a href='<?php echo base_url() . "admin/dispute/accept_dispute/" . $review_details->row()->id . '/' . $review_details->row()->booking_no; ?>'>
                                            <button type="button" class="btn_small btn_blue" tabindex="4">
                                                <span>Accept</span></button>
                                        </a>

                                        <a href='<?php echo base_url() . "admin/dispute/reject_dispute/" . $review_details->row()->id . '/' . $review_details->row()->booking_no; ?>'>
                                            <button type="button" class="btn_small btn_blue"
                                                    style='background-color: rgb(206, 10, 10);border-color:#771515'
                                                    tabindex="4"><span>Reject</span>
                                            </button>
                                        </a>

                                <?php
                            }else{
                                ?>
                                <span class="badge_style" style="background-color: rgb(126, 123, 123);border-color:#771515">Expired</span>

                                <?php
                            }
                            }else{
                                ?>
                                <span class="badge_style" style="background-color: rgb(126, 123, 123);border-color:#771515"><?php echo $review_details->row()->status ?></span>

                                <?php
                            } ?>
                                    </div>
                                    </div>
                                </li>
							<li class="btn_cls">
								<div class="form_grid_12" style="margin-left:340px;">
									<?php
										echo form_label('Message Conversation','description', $commonclass);
									?>
								</div>
							</li>

							<li>
								<?php
								$booking_no = $this->uri->segment(4);
								$message = $this->review_model->get_all_details(MED_MESSAGE, array('bookingNo' => $booking_no));
								foreach ($message->result() as $list)
								{
								if ($review_details->row()->host_id == $list->senderId)
								{
								?>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label($host_details->row()->user_name.'(HOST)','description', $commonclass);
									?>
									<div class="form_input">
										<?php echo $list->message; ?>
									</div>
								</div>
							</li>
						<?php 
							}
							else
							{ ?>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label($user_details->row()->user_name.'(USER)','description', $commonclass);
									?>
									<div class="form_input">
										<?php echo $list->message; ?>
									</div>
								</div>
							</li>

						<?php 
							}
						} ?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/dispute/display_dispute_list" class="tipLeft"
										   title="Go to Dispute list"><span class="badge_style b_done">Back</span>
										</a>
									</div>
								</div>
							</li>
						</ul>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
	</div>
	
<?php
$this->load->view('admin/templates/footer.php');
?>
