<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
if ($this->lang->line('Guest') != '') {
	$Guest = stripslashes($this->lang->line('Guest'));
} else {
	$Guest = "Guest";
}
if ($this->lang->line('guest') != '') {
	$guests = stripslashes($this->lang->line('guest'));
} else {
	$guests = "Guests";
}
$count = 2;
$SenderImage = base_url() . 'images/users/profile.png';
if ($senderDetails->row()->image != "" && file_exists('./images/users/' . $senderDetails->row()->image)) {
	$SenderImage = base_url() . 'images/users/' . $senderDetails->row()->image;
}
$ReceiverImage = base_url() . 'images/users/profile.png';
if ($receiverDetails->row()->image != "" && file_exists('./images/users/' . $receiverDetails->row()->image)) {
	$ReceiverImage = base_url() . 'images/users/' . $receiverDetails->row()->image;
}
?>

<section>
	<div class="container">
		<div class="loggedIn clear padding_L2">
			<div class="row">
				<div class="col-sm-3">
					<div class="profile_I">
						<?php
						$ImageSrc = 'profile.png';
						if ($receiverDetails->row()->image != "" && file_exists('./images/users/' . $receiverDetails->row()->image)) {
							$ImageSrc = $receiverDetails->row()->image;
						}
						echo img(base_url() . 'images/users/' . $ImageSrc, TRUE, array('class' => 'opacity'));
						echo img(base_url() . 'images/users/' . $ImageSrc, TRUE, array('class' => 'dp'));
						?>
					</div>
					<div class="verifications">
						<div class="text-center">
							<h5><?php if ($this->lang->line('Member since') != '') {
									echo stripslashes($this->lang->line('Member since'));
								} else echo "Member since"; ?><?php echo ' ' . date('Y', strtotime($receiverDetails->row()->created)); ?></h5>
							<p><?php if ($receiverDetails->row()->s_city != '') {
									echo ucfirst($receiverDetails->row()->s_city);
								} else {
									if ($this->lang->line('No Address') != '') {
										echo stripslashes($this->lang->line('No Address'));
									} else echo "No Address";
								} ?></p>
						</div>
						<div class="divider"></div>
						<h5><?php if ($this->lang->line('Verifications') != '') {
								echo stripslashes($this->lang->line('Verifications'));
							} else echo "Verifications"; ?></h5>
						<div class="tableRow">
							<div class="left">
								<div><?php if ($this->lang->line('Email Address') != '') {
										echo stripslashes($this->lang->line('Email Address'));
									} else echo "Email Address"; ?></div>
							</div>
							<div class="right">
								<img
									src="<?php echo base_url(); ?>images/<?php echo ($receiverDetails->row()->id_verified == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png'; ?>"
									width="25">
							</div>
						</div>
						<div class="tableRow">
							<div class="left">
								<div><?php if ($this->lang->line('Phone number') != '') {
										echo stripslashes($this->lang->line('Phone number'));
									} else echo "Phone number"; ?></div>
							</div>
							<div class="right">
								<img
									src="<?php echo base_url(); ?>images/<?php echo ($receiverDetails->row()->ph_verified == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png'; ?>"
									width="25">
							</div>
						</div>
						<div class="tableRow">
							<div class="left">
								<div><?php if ($this->lang->line('review') != '') {
										echo stripslashes($this->lang->line('review'));
									} else echo "review"; ?></div>
							</div>
							<div class="right">
								<div
									class="number_s120"><?php echo $reviewCount . ' '; ?><?php if ($this->lang->line('reviews') != '') {
										echo stripslashes($this->lang->line('reviews'));
									} else echo "Reviews"; ?></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-9">
					<?php if ($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Decline') { ?>
						<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							<h3><?php if ($this->lang->line('Declined') != '') {
									echo stripslashes($this->lang->line('Declined'));
								} else echo "Declined"; ?></h3>
							<p><?php if ($this->lang->line('Don t give up — keep contacting other listings.') != '') {
									echo stripslashes($this->lang->line('Don t give up — keep contacting other listings.'));
								} else echo "Don t give up — keep contacting other listings."; ?></p>
							<p><?php if ($this->lang->line('Contacting several places considerably improves your odds of a booking.') != '') {
									echo stripslashes($this->lang->line('Contacting several places considerably improves your odds of a booking.'));
								} else echo "Contacting several places considerably improves your odds of a booking."; ?></p>
						</div>
						<?php
					} else if ($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Decline') {
						?>
						<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							<h3><?php if ($this->lang->line('Declined') != '') {
									echo stripslashes($this->lang->line('Declined'));
								} else echo "Declined"; ?></h3>
							<p><?php if ($this->lang->line('You was declined the guest for this booking.') != '') {
									echo stripslashes($this->lang->line('You was declined the guest for this booking.'));
								} else echo "You was declined the guest for this booking."; ?></p>
							<p><?php if ($this->lang->line('Kindly reply to guest to get more number of guests.') != '') {
									echo stripslashes($this->lang->line('Kindly reply to guest to get more number of guests.'));
								} else echo "Kindly reply to guest to get more number of guests."; ?></p>
						</div>
						<?php
					} else if ($bookingDetails->row()->renter_id != $userId && $conversationDetails->row()->status == 'Accept') {
						?>
						
						<?php
					} else if ($bookingDetails->row()->renter_id == $userId && $conversationDetails->row()->status == 'Accept') {
						?>
						<div class="alert alert-success alert-dismissable">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
							<h3><?php if ($this->lang->line('Accepted') != '') {
									echo stripslashes($this->lang->line('Accepted'));
								} else echo "Accepted"; ?></h3>
							<p><?php if ($this->lang->line('You Accepted the guest for this booking.') != '') {
									echo stripslashes($this->lang->line('You Accepted the guest for this booking.'));
								} else echo "You Accepted the guest for this booking."; ?></p>
							<p><?php if ($this->lang->line('Kindly respond to guest to give a guidance through this conversation.') != '') {
									echo stripslashes($this->lang->line('Kindly respond to guest to give a guidance through this conversation.'));
								} else echo "Kindly respond to guest to give a guidance through this conversation."; ?></p>
						</div>
						<?php
					} ?>
					<div class="msgConversation">
						<?php
						$total = $conversationDetails->num_rows();
						foreach ($conversationDetails->result() as $coversation) {
							if ($coversation->point == '1') {
								?>
								<div class="chat">
									<div
										class="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? 'left' : 'right'; ?>">
										<img
											src="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? $ReceiverImage : $SenderImage; ?>">
											
											
											
											<?php if ($this->lang->line('experiences') != '') {
												$expz= stripslashes($this->lang->line('experiences'));
											} else $expz= "Experiences"; ?>
											
										<p class="statement"><?php  echo $expz;   ?> <b> <?php echo $bookingDetails->row()->product_title; ?></b>

											<?php if ($this->lang->line('by_you_on') != '') {
												$by_you= stripslashes($this->lang->line('by_you_on'));
											} else $by_you= "by You on"; ?>
											
											<?php if ($this->lang->line('by Host on') != '') {
												$by_host= stripslashes($this->lang->line('by Host on'));
											} else $by_host= "by Host on"; ?>

										<?php if ($this->lang->line('was') != '') {
												echo stripslashes($this->lang->line('was'));
											} else echo "was"; ?> <?php echo ($coversation->status == 'Accept') ? 'Accepted' : 'Declined'; ?> <?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? "$by_host" : " $by_you "; ?>
											<b><?php echo date('d-m-Y h:i a', strtotime($coversation->dateAdded)); ?></b>.
											( <?php if (date('Y', strtotime($bookingDetails->row()->checkout)) == date('Y', strtotime($bookingDetails->row()->checkin))) {
												echo date('M d', strtotime($bookingDetails->row()->checkin));
											} else {
												echo date('M d, Y', strtotime($bookingDetails->row()->checkin));
											} ?>
											- <?php if (date('M', strtotime($bookingDetails->row()->checkout)) != date('M', strtotime($bookingDetails->row()->checkin))) {
												echo date('M d, Y', strtotime($bookingDetails->row()->checkout));
											} else {
												echo date('M d, Y', strtotime($bookingDetails->row()->checkout));
											} ?>.<?php echo " ".$bookingDetails->row()->NoofGuest . " ";
											echo ($bookingDetails->row()->NoofGuest > 1) ? $guests : $Guest; ?>
											).
										</p>
										<small><?php echo ucfirst($senderDetails->row()->firstname); ?></small>
									</div>
								</div>
								<?php
							} else if ($sender_id == $coversation->senderId) {
								?>
								<div class="chat">
									<div
										class="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? 'left' : 'right'; ?>">
										<img
											src="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? $ReceiverImage : $SenderImage; ?>">
										<p><?php echo ucfirst($coversation->message); ?></p>
										<small><?php echo ucfirst($senderDetails->row()->firstname); ?>
											- <?php echo date('d-m-Y h:i a', strtotime($coversation->dateAdded)); ?></small>
									</div>
								</div>
							<?php } else {
								if ($total == $count) {
									?>
									<div class="chat">
										<div
											class="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? 'left' : 'right'; ?>">
											<img
												src="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? $ReceiverImage : $SenderImage; ?>">
											<p class="statement"><?php if ($this->lang->line('Inquiry about') != '') {
													echo stripslashes($this->lang->line('Inquiry about'));
												} else echo "Inquiry about"; ?> <b> <?php echo $bookingDetails->row()->product_title; ?></b>
												on
												<b><?php if (date('Y', strtotime($bookingDetails->row()->checkout)) == date('Y', strtotime($bookingDetails->row()->checkin))) {
														echo date('M d', strtotime($bookingDetails->row()->checkin));
													} else {
														echo date('M d, Y', strtotime($bookingDetails->row()->checkin));
													} ?>
													- <?php if (date('M', strtotime($bookingDetails->row()->checkout)) != date('M', strtotime($bookingDetails->row()->checkin))) {
														echo date('M d, Y', strtotime($bookingDetails->row()->checkout));
													} else {
														echo date('M d, Y', strtotime($bookingDetails->row()->checkout));
													} ?>. <?php echo " ".$bookingDetails->row()->NoofGuest." ";
													echo ($bookingDetails->row()->NoofGuest > 1) ? $guests : $Guest; ?></b>
												.</p>
										</div>
									</div>
									<?php $first = 1;
								} ?>
								<div class="chat">
									<div
										class="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? 'left' : 'right'; ?>">
										<img
											src="<?php echo ($this->session->userdata('fc_session_user_id') == $coversation->receiverId) ? $ReceiverImage : $SenderImage; ?>">
										<p><?php echo ucfirst($coversation->message); ?></p>
										<small><?php echo ucfirst($receiverDetails->row()->firstname); ?>
											- <?php echo date('d-m-Y - h:i a', strtotime($coversation->dateAdded)); ?></small>
									</div>
								</div>
								<?php
							}
							$count++;
						}
						echo form_open('', array('onsubmit' => 'return sendMessage();', 'class' => 'clear'));
						echo form_input(array('type' => 'hidden', 'value' => $sender_id, 'id' => 'sender_id'));
						echo form_input(array('type' => 'hidden', 'value' => $receiver_id, 'id' => 'receiver_id'));
						echo form_input(array('type' => 'hidden', 'value' => $bookingNo, 'id' => 'bookingno'));
						echo form_input(array('type' => 'hidden', 'value' => $productId, 'id' => 'product_id'));
						echo form_input(array('type' => 'hidden', 'value' => $conversationDetails->row()->subject, 'id' => 'subject'));
						echo form_input(array('type' => 'hidden', 'value' => $pageURL, 'id' => 'pageURL'));
						echo form_input(array('type' => 'hidden', 'value' => base_url(), 'id' => 'baseURL'));
						if ($this->lang->line('Add a Personal message here...') != '') {
							$textareaPlaceholder = stripslashes($this->lang->line('Add a Personal message here...'));
						} else $textareaPlaceholder = "Add a Personal message here...";
						echo form_textarea('message', '', array('placeholder' => $textareaPlaceholder, 'id' => 'message_content'));
						if ($this->lang->line('Send Message') != '') {
							$BtnValue = stripslashes($this->lang->line('Send Message'));
						} else $BtnValue = "Send Message";
						echo form_submit('submit', $BtnValue, array('class' => 'submitBtn1'));
						echo form_close();
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function sendMessage() {
		 $('.loading').show();
		var message = $('#message_content');
		if (message.val() == '') {
			 $('.loading').hide();

			boot_alert('<?php if ($this->lang->line("Message_is_required!") != '') {
				echo stripslashes($this->lang->line("Message_is_required!"));
			} else echo "Message is required!";?>');
			message.focus();
			return false;
		} else {
			var sender_id = $('#sender_id').val();
			var receiver_id = $('#receiver_id').val();
			var booking_id = $('#bookingno').val();
			var pageURL = $('#pageURL').val();
			var product_id = $('#product_id').val();
			var message_content = message.val();
			var subject = $('#subject').val();
			$.ajax(
				{
					type: 'POST',
					url: "<?php echo base_url();?>site/experience/send_message",
					data: {
						'sender_id': sender_id,
						'receiver_id': receiver_id,
						'booking_id': booking_id,
						'product_id': product_id,
						'message': message_content,
						'subject': subject
					},
					success: function (data) {
						 $('.loading').show();
						window.location.reload();
					}
				});
		}
		return false;
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
