<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading ?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'addsubadmin_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/rep/insertEditRep', $attributes)
						?>
						<ul>
							<li id='repcode'>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Rep. Code <span
												class="req">*</span>','Code', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->admin_rep_code; ?>
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
									            'name' 	   => 'email',
									            'onChange' => 'check_rep_email(this.value);',
									            'class'    => 'required large tipTop',
									            'placeholder' => 'Please enter the email address',
												'value'	   => $admin_details->row()->email
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
										echo form_label('Name','admin_name',
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'     => 'text',      
									            'name' 	   => 'name',
									            'id' 	   => 'name',
									            'class'    => 'required large tipTop',
									            'placeholder' => 'Please enter the user name',
												'value'	   => $admin_details->row()->name
									        ]);								

									        $errorlbl = array('id' => 'name_error', 'style' => 'display:none;','class' => 'error');

											echo form_label('Numbers
											are not allowed','', 
												$errorlbl);	        
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Login Name','admin_name',
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->admin_name; 

											echo form_input([
												'type'     => 'hidden',      
									            'name' 	   => 'admin_name',
									            'id' 	   => 'admin_name',
												'value'	   => $admin_details->row()->admin_name
									        ]);								
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Registeration Date','admin_name',
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->created; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Password Reset Count','admin_name',
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->password_reset_count; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div style="color:red" id="chechmsg">
									</div>
									<?php
										echo form_label('','site_contact_mail', $commonclass);	
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
									echo form_input([
										'type'        => 'hidden',
									    'value'       => $admin_details->row()->id,
									    'name'        => 'subadminid'
									    ]);
								
								for ($i = 0; $i < sizeof($adminPrevArr); $i++)
								{
									$subAdmin = $adminPrevArr[$i];
									$priv = array();
									if (isset($privArr[$subAdmin])) 
									{
										$priv = $privArr[$subAdmin];
									}
									?>
									<div class="form_grid_12">
										<?php								
										echo form_label(ucfirst($subAdmin),'',
												$commonclass);	
								    	?>
										<table border="0" cellspacing="0" cellpadding="0" width="400">
											<tr>
												<?php 
												for ($j = 0; $j < 4; $j++) { ?>
												<td align="center" width="15%">


                                                    <?php
                                                    if ((($subAdmin == 'RentalTransaction' && $j == 0) || ($subAdmin == 'RentalBookingStatus' && $j == 0)||($subAdmin == 'ExperienceTransaction' && $j == 0) || ($subAdmin == 'ExperienceBookingStatus' && $j == 0) || ($subAdmin == 'Commission' && $j == 0) || ($subAdmin == 'Review' && $j == 0) || ($subAdmin == 'Review' && $j == 3)||($subAdmin == 'Dispute' && $j == 0)||($subAdmin == 'PaymentGateway' && $j == 0) ||($subAdmin == 'PaymentGateway' && $j == 2)||($subAdmin == 'Backup' && $j == 0)|| (($subAdmin == 'Enquiries' && $j != 2) && ($subAdmin == 'Enquiries' && $j != 1))) || (($subAdmin != 'RentalTransaction') && ($subAdmin != 'ExperienceTransaction') && ($subAdmin !='RentalBookingStatus') && ($subAdmin !='ExperienceBookingStatus') && ($subAdmin !='Commission') && ($subAdmin !='Review') && ($subAdmin !='Dispute') && ($subAdmin !='PaymentGateway')&&($subAdmin !='Backup')&&($subAdmin !='Enquiries'))) {
                                                    ?>
								        		<span class="checkboxCon">
												<input class="caseSeeker" <?php if (in_array($j, $priv))
												{
													echo 'checked="checked"';
												} ?>
											    type="checkbox" id="checkbox" name="<?php echo $subAdmin . '[]'; ?>"
											    id="<?php echo $subAdmin . '[]'; ?>" value="<?php echo $j; ?>"/>
								        		</span>

                                                    <?php
                                                    }

                                                    ?>
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
						<?php echo form_close(); ?>

						<!--script to validate name-->
						<script>
							 $("#name").on('keyup', function(e) 
							 {
                                var numers = /[0-9]+$/;
                                var val = $(this).val();
                                if(numers.test(val))
                                {
                                  document.getElementById("name_error").style.display = "inline";
                                  $("#name_error").fadeOut(5000);
                                  $(this).val(val.replace(/[0-9]+$/, ''));
                              	}
                           }); 

						</script>

						<!--start subadmin email id check-->
						<script type="text/javascript">
							function check_rep_email(emailid) 
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
						</script>
						<!--end subadmin email id check-->

					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
	</div>
	<script type="text/javascript">
		checkboxInit();
	</script>

	<!--script to validate  checkbox is selected-->
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
				return false; 
			}
		};
	</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
