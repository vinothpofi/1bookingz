<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Host</h6>
						<div id="widget_tab">
							<ul>
								<li><a href="#tab1" class="active_tab">Host Details</a></li>
								<li><a href="#tab2">Bank Details</a></li>
							</ul>
						</div>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin', $attributes)
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');
											echo form_label('User Image','User Image', 
												$commonclass);	
								    	?>
										<div class="form_input">
											<?php if ($seller_details->row()->image == '') 
											{ ?>
												<img src="<?php echo base_url(); ?>images/users/user-thumb1.png"
													 width="100px"/>
											<?php 
											} 
											else 
											{ ?>
												<img
													src="<?php echo base_url(); ?>images/users/<?php echo $seller_details->row()->image; ?>"
													width="100px"/>
											<?php 
											} ?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php

											echo form_label('First Name','full_name', 
												$commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->firstname != '') 
											{
												echo $seller_details->row()->firstname;
											} 
											else 
											{
												echo "----";
											} 
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Last Name ', 'full_name', $commonclass);
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->lastname != '') 
											{
												echo $seller_details->row()->lastname;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
											echo form_label('I Am ','gender', $commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->gender != '') 
											{
												echo $seller_details->row()->gender;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Date of birth ','dob_month',$commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->dob_month != '0' && $seller_details->row()->dob_date != '0' && $seller_details->row()->dob_year != '0') {
												echo $seller_details->row()->dob_month . '/' . $seller_details->row()->dob_date . '/' . $seller_details->row()->dob_year;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Phone no','phone_no', $commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->phone_no != '') 
											{
												echo $seller_details->row()->phone_no;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Where You Live','s_city',$commonclass);
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->s_city != '') 
											{
												echo $seller_details->row()->s_city;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Describe Yourself','description', 
												$commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->description != '') 
											{
												echo $seller_details->row()->description;
											}
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('School','school', $commonclass);	
								   		?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->school != '') 
											{
												echo $seller_details->row()->school;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Work','work', $commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->work != '') 
											{
												echo $seller_details->row()->work;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>
								
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Status','admin_name', $commonclass);	
								    	?>
										<div class="form_input">
											<?php echo $seller_details->row()->status; ?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Email','admin_name', $commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->email != '') 
											{
												echo $seller_details->row()->email;
											} 
											else 
											{
												echo "----";
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php if ($seller_details->row()->host_status == 1) 
											{ ?>
												<a href="admin/seller/display_archieve_seller" class="tipLeft"
												   title="Go to archieve seller <?php if ($seller_details->row()->request_status == 'Pending') {
													   echo 'requests';
												   } else {
													   echo 'list';
												   } ?>"><span class="badge_style b_done">Back</span>
												</a>
											<?php 
											} 
											else 
											{ ?>
												<a href="admin/seller/display_seller_<?php if ($seller_details->row()->request_status == 'Pending') {
													echo 'requests';
												} else {
													echo 'list';
												} ?>" class="tipLeft"
												   title="Go to seller <?php if ($seller_details->row()->request_status == 'Pending') {
													   echo 'requests';
												   } else {
													   echo 'list';
												   } ?>"><span class="badge_style b_done">Back</span>
												</a>
											<?php } ?>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="tab2">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Account Name','acc_name', $commonclass);
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->accname == '') 
											{
												echo 'Not available';
											} 
											else 
											{
												echo $seller_details->row()->accname;
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Account Number','accno', $commonclass);	
								    	?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->accno == '') 
											{
												echo 'Not available';
											} 
											else 
											{
												echo $seller_details->row()->accno;
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Bank Name','bankname', $commonclass);	
								   		?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->bankname == '') 
											{
												echo 'Not available';
											} 
											else 
											{
												echo $seller_details->row()->bankname;
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Rep Code','repcode', $commonclass);	
								   		?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->rep_code == '') 
											{
												echo 'Not available';
											} 
											else 
											{
												echo $seller_details->row()->rep_code;
											}
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Paypal Email','paypal', $commonclass);	
								   		?>
										<div class="form_input">
											<?php
											if ($seller_details->row()->paypal_email == '') 
											{
												echo 'Not available';
											} 
											else 
											{
												echo $seller_details->row()->paypal_email;
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php if ($seller_details->row()->host_status == 1) 
											{ ?>
												<a href="admin/seller/display_archieve_seller" class="tipLeft"
												   title="Go to archieve seller <?php if ($seller_details->row()->request_status == 'Pending') {
													   echo 'requests';
												   } else {
													   echo 'list';
												   } ?>"><span class="badge_style b_done">Back</span>
												</a>
											<?php 
											} 
											else 
											{ ?>
												<a href="admin/seller/display_seller_<?php if ($seller_details->row()->request_status == 'Pending') {
													echo 'requests';
												} else {
													echo 'list';
												} ?>" class="tipLeft"
												   title="Go to seller <?php if ($seller_details->row()->request_status == 'Pending') {
													   echo 'requests';
												   } else {
													   echo 'list';
												   } ?>"><span class="badge_style b_done">Back</span>
												</a>
											<?php } ?>
										</div>
									</div>
								</li>
							</ul>
						</div>
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
