<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add Sub-admin</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addsubadmin_form', 'accept-charset' => 'UTF-8');
					echo form_open('admin/subadmin/insertEditSubadmin', $attributes)
					?>
					<ul>
						<?php
							echo form_input([
								'type'     => 'hidden',
							    'id'       => 'rep_type_normal',
								'name' 	   => 'rep_type',
								'required' => 'required',
								'checked'  => 'checked',
							    'value'	   => 'Normal'
									        ]);
						?>
							<li id='repcode' style="display:none;">
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Code <span
												class="req">*</span>','Code', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php

											$gt = 'REP';
											$ns = date('s');
											$nn = rand(1000, 100000);
											$n = $nn + $ns;
											$gtcode = str_pad($n + 1, 5, "0", STR_PAD_LEFT);

											echo form_input([
												'type'     => 'text',
									            'id'       => 'rep_Code',
									            'name' 	   => 'rep_Code',
									            'tabindex' => '3',
									            'class'    => 'required large tipTop',
									            'readonly' => 'readonly',
												'value'	   => $gt . $gtcode
									        ]);
									    ?>
									</div>
								</div>
							</li>				

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Email Address <span
												class="req">*</span>','email', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'     => 'text',
									            'id'       => 'email',
									            'name' 	   => 'email',
									            'tabindex' => '1',
									            'class'    => 'required large tipTop',
									            'title' => 'Please enter the sub admin email address',
									            'placeholder' => 'Please enter the sub admin email address',
									            'onChange' => 'check_subadmin_email(this.value);'
									        ]);

										$errorlbl = array('id' => 'email_exist_error', 'style' => 'display:none;','class' => 'error');

										echo form_label('This Email Id
										Already Exist','', 
												$errorlbl);	
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Name<span
												class="req">*</span>','name', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'     => 'text',
									            'id'       => 'name',
									            'name' 	   => 'name',
									            'tabindex' => '2',
									            'class'    => 'required large tipTop',
									            'title' => 'Please enter the sub admin username',
									            'placeholder' => 'Please enter the sub admin username',
									            'maxlength' => '50'
									        ]);

										$errorlbl = array('id' => 'name_error_len', 'style' => 'display:none;','class' => 'error');

										echo form_label('Only 50 Characters
										allowed','', 
												$errorlbl);	
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Login Name<span
												class="req">*</span>','admin_name', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'     => 'text',
									            'id'       => 'admin_name',
									            'name' 	   => 'admin_name',
									            'tabindex' => '3',
									            'class'    => 'required large tipTop',
									            'title' => 'Please enter the sub admin username',
									            'placeholder' => 'Please enter the sub admin username',
									            'onChange' => 'check_subadmin_loginname(this.value);'
									        ]);

										$errorlbl = array('id' => 'admin_name_error_len', 'style' => 'display:none;','class' => 'error');

										echo form_label('Special
										Characters are not allowed','', 
												$errorlbl);

										$errorlbl2 = array('id' => 'loginname_exist_error', 'style' => 'display:none;','class' => 'error');

										echo form_label('This Login
										Name Already Exist','', 
												$errorlbl2);	
									?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Password<span
												class="req">*</span>','site_contact_mail', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
											'type'         => 'password',
									        'id'           => 'admin_password',
									        'name' 	       => 'admin_password',
									        'tabindex'     => '4',
									        'class'        => 'required large tipTop',
									        'title'        => 'Please enter the password',
									        'placeholder'  => 'Please enter the password',
									        'maxlength'    => '10',
									        'autocomplete' => FALSE
									        ]);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Confirm Password<span
												class="req">*</span>','confirm_password', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
											'type'         => 'password',
									        'id'           => 'confirm_password',
									        'name' 	       => 'confirm_password',
									        'tabindex'     => '5',
									        'class'        => 'required large tipTop',
									        'title'        => 'Please re-type the above password',
									        'placeholder'  => 'Please re-type the above password',
									        'maxlength'    => '10',
									        'autocomplete' => FALSE
									        ]);
									?>
								</div>
							</div>
						</li>

						<?php
						sizeof($adminPrevArr);
						$subAdmins = $adminPrevArr[1];			
						?>							
							<li id="privileges">
								<div style="color:red" id="chechmsg"></div>
								<div class="form_grid_12">
									<?php
									echo form_label('','site_contact_mail');
									?>
									<div id="uniform-undefined" class="form_input checker focus">
										<span class="" style="float:left;">
										<?php
											echo form_input([
												'type'        => 'checkbox',
									            'id'          => 'selectallseeker',
									            'class'       => 'checkbox'
									        ]);
										?>
										</span>
										<?php
											$slctall = array('style' => 'float:left;margin:5px;');								
											echo form_label('Select all','', 
												$slctall);	
								    	?>
									</div>
								</div>
								<div style="margin-top: 20px;"></div>
								<div class="form_grid_12">
									<?php									
										echo form_label('Mangement Name','', 
												$commonclass);	
								    ?>
									<table border="0" cellspacing="0" cellpadding="0" width="400">
										<tr>
											<td align="center" width="15%">View</td>
											<td align="center" width="15%">Add</td>
											<td align="center" width="15%">Edit</td>
											<td align="center" width="15%">Delete</td>
										</tr>
									</table>
								</div>

								<?php
								
								for ($i = 0; $i < sizeof($adminPrevArr); $i++)
								{
									$subAdmin = $adminPrevArr[$i]; 
								?>
									<div class="form_grid_12">
										<?php									
										echo form_label(ucfirst($subAdmin),'',
												$commonclass);	
								    	?>
										<table border="0" cellspacing="0" cellpadding="0" width="400">
											<tr>
												<?php 
												for ($j = 0; $j < 4; $j++) 
												{ ?>
												<td align="center" width="15%">

<?php  if ((($subAdmin == 'Rental Transaction' && $j == 0) || ($subAdmin == 'Rental Booking Status' && $j == 0)||($subAdmin == 'Experience Transaction' && $j == 0) || ($subAdmin == 'Experience Booking Status' && $j == 0) || ($subAdmin == 'Commission' && $j == 0) || ($subAdmin == 'Review' && $j == 0) || ($subAdmin == 'Review' && $j == 3)||($subAdmin == 'Dispute' && $j == 0)||($subAdmin == 'Payment Gateway' && $j == 0) ||($subAdmin == 'Payment Gateway' && $j == 2)||($subAdmin == 'Backup' && $j == 0)|| (($subAdmin == 'Enquiries' && $j != 2) && ($subAdmin == 'Enquiries' && $j != 1))) || (($subAdmin != 'RentalTransaction') && ($subAdmin != 'Experience Transaction') && ($subAdmin !='Rental Booking Status') && ($subAdmin !='Experience Booking Status') && ($subAdmin !='Commission') && ($subAdmin !='Review') && ($subAdmin !='Dispute') && ($subAdmin !='Payment Gateway')&&($subAdmin !='Backup')&&($subAdmin !='Enquiries'))) { ?>
								        		<span class="checkboxCon">
												<input class="caseSeeker" id="checkbox" type="checkbox" name="<?php echo $subAdmin . '[]'; ?>"
			   									id="<?php echo $subAdmin . '[]'; ?>"
			   									value="<?php echo $j; ?>"/>
								        		</span>
								        		  <?php } ?>
												</td>
												<?php } ?>
											</tr>
										</table>
									</div>
								<?php } ?>
							</li>						
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
											'type'        => 'submit',
										    'value'       => 'Update',
										    'class'       => 'btn_small btn_blue',
										    'onclick'     => 'return Checkbox();',
										    'tabindex'    => '15'
										    ]);
									    ?>
								</div>
							</div>
						</li>
					</ul>
					<?php echo  form_close(); ?> 

					<!--script to check name length-->
					<script type="text/javascript">
						function Checkbox() 
						{
							var isChecked = $("#checkbox").is(":checked");
							if (isChecked) 
							{
								$('#chechmsg').html("");					
							} 
							else 
							{
								$('#chechmsg').html("Check any one field");
							}
						};
					</script>

					<!--script to validate ay checkbox is selected-->
					<script>
						$("#name").on('keypress', function (e) 
						{
							var val = $(this).val();
							if (val.length == 50) 
							{
								document.getElementById("name_error_len").style.display = "inline";
								$("#name_error_len").fadeOut(5000);
							}
						});						
					</script>

					<!--subadmin email id check-->
					<script type="text/javascript">
						/*this function is to check Email Id already exist are not*/
						function check_subadmin_email(emailid) 
						{
							$.ajax({
								type: 'POST',
								data: 'email_id=' + emailid,
								url: 'admin/subadmin/check_subadmin_email_exist',
								success: function (responseText) 
								{
									if (responseText == 1) 
									{
										document.getElementById("email_exist_error").style.display = "inline";
									} 
									else 
									{
										document.getElementById("email_exist_error").style.display = "none";
									}
								}
							});
						}

						/*this function is to check login name already exist are not*/
						function check_subadmin_loginname(admin_name) 
						{
							$.ajax({
								type: 'POST',
								data: 'admin_name=' + admin_name,
								url: 'admin/subadmin/check_subadmin_loginname_exist',
								success: function (responseText) 
								{

									if (responseText == 1) 
									{
										document.getElementById("loginname_exist_error").style.display = "inline";
									} 
									else 
									{
										document.getElementById("loginname_exist_error").style.display = "none";
									}
								}
							});
						}
					</script>
					<!--end subadmin email id check-->
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
