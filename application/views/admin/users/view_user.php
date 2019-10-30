<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>View User</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Details</a></li>			
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

										echo form_label('User Image (Image Size 272px X 272px)','', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php if ($user_details->row()->image == '') 
										{ ?>
											<img src="<?php echo base_url(); ?>images/users/user-thumb1.png"
												 width="100px"/>
										<?php 
										} 
										else 
										{ ?>
											<img
												src="<?php echo base_url(); ?>images/users/<?php echo $user_details->row()->image; ?>"
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
										if ($user_details->row()->firstname != '') 
										{
											echo $user_details->row()->firstname;
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
										echo form_label('Last Name','full_name', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->lastname != '') 
										{
											echo $user_details->row()->lastname;
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
										echo form_label('I Am','gender', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->gender != '') 
										{
											echo $user_details->row()->gender;
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
										echo form_label('Date of birth','gender', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->dob_month != '0' && $user_details->row()->dob_date != '0' && $user_details->row()->dob_year != '0') 
										{
											echo $user_details->row()->dob_month . '/' . $user_details->row()->dob_date . '/' . $user_details->row()->dob_year;
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
										echo form_label('Phone no','phone_no', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->phone_no != '' && $user_details->row()->phone_no != '0') 
										{
											echo $user_details->row()->phone_no;
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
										echo form_label('Where You Live','s_city', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->s_city != '') 
										{
											echo $user_details->row()->s_city;
										}
										else 
										{
											echo "----";
										} ?>
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
										if ($user_details->row()->description != '') 
										{
											echo $user_details->row()->description;
										} 
										else 
										{
											echo "----";
										} ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('School','s_city', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->school != '') 
										{
											echo $user_details->row()->school;
										} 
										else 
										{
											echo "----";
										} ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Work','Work', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->work != '') {
											echo $user_details->row()->work;
										} else {
											echo "----";
										} ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('User Type','User Type', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $user_details->row()->group; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Login User Type','Login User Type', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->loginUserType == 'normal') {
											echo "E-mail";
										} else {
											echo ucfirst($row->loginUserType);
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Email Address','Email Address', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										if ($user_details->row()->email != '') 
										{
											echo $user_details->row()->email;
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
										echo form_label('Created On','Created On', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $user_details->row()->created; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Modified On','Modified On', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $user_details->row()->modified; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/users/display_user_list" class="tipLeft"
										   title="Go to Guest list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
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
