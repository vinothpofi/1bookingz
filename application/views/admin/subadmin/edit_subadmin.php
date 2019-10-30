<?php

$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Subadmin</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'addsubadmin_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/subadmin/insertEditSubadmin', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$titleclass = array('class' => 'field_title');

										echo form_label('Email Address','email', 
												$titleclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->email; 

											echo form_input([
												'type'     => 'hidden',
									            'name' 	   => 'email',
												'value'	   => $admin_details->row()->email
									        ]);
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Name','admin_name', 
												$titleclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',
									            'id'          => 'name',
									            'name' 	      => 'name',
									            'class'       => 'required large tipTop',
									            'placeholder' => 'Enter your name',
												'value'	      => $admin_details->row()->name
									        ]);

									        $errorlbl = array('id' => 'name_error_len', 'style' => 'display:none;','class' => 'error');

											echo form_label('Only 50 Characters
											are allowed','', 
												$errorlbl);	
									        ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Login Name','admin_name', 
												$titleclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->admin_name; 

											echo form_input([
												'type'     => 'hidden',
									            'name' 	   => 'admin_name',
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
												$titleclass);	
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
												$titleclass);	
								    ?>
									<div class="form_input">
										<?php echo $admin_details->row()->password_reset_count; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div style="color:red" id="chechmsg"></div>
									<?php										
										echo form_label('','site_contact_mail', 
												$titleclass);	
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
										echo form_label('Mangem	ent Name','', 
												$titleclass);	
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
							//	 echo "<pre>";	print_r($adminPrevArr);
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
												$titleclass);	
								    	?>
										<table border="0" cellspacing="0" cellpadding="0" width="400">
											<tr>
												<?php for ($j = 0; $j < 4; $j++) 
												{ ?>
													<td align="center" width="15%">
                                                        <?php  if ((($subAdmin == 'RentalTransaction' && $j == 0) || ($subAdmin == 'RentalBookingStatus' && $j == 0)||($subAdmin == 'ExperienceTransaction' && $j == 0) || ($subAdmin == 'ExperienceBookingStatus' && $j == 0) || ($subAdmin == 'Commission' && $j == 0) || ($subAdmin == 'Review' && $j == 0) || ($subAdmin == 'Review' && $j == 3)||($subAdmin == 'Dispute' && $j == 0)||($subAdmin == 'PaymentGateway' && $j == 0) ||($subAdmin == 'PaymentGateway' && $j == 2)||($subAdmin == 'Backup' && $j == 0)|| (($subAdmin == 'Enquiries' && $j != 2) && ($subAdmin == 'Enquiries' && $j != 1))) || (($subAdmin != 'RentalTransaction') && ($subAdmin != 'ExperienceTransaction') && ($subAdmin !='RentalBookingStatus') && ($subAdmin !='ExperienceBookingStatus') && ($subAdmin !='Commission') && ($subAdmin !='Review') && ($subAdmin !='Dispute') && ($subAdmin !='PaymentGateway')&&($subAdmin !='Backup')&&($subAdmin !='Enquiries'))) { ?>
								        			<span class="checkboxCon">
								        			<?php
								        			$chk = "";
								        			if (in_array($j, $priv))
								        			{
								        				$chk = checked;
								        			}
														echo form_input([
															'type'     => 'checkbox',
															'id'	   => 'checkbox',
													        'value'    => $j,
													        'name' 	   => $subAdmin . '[]',
													        'class'    => 'caseSeeker',
													        $chk 	   => $chk
													        ]);	
								        			
													?>		
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
										   // 'onclick'     => 'return Checkbox();',
										    'tabindex'    => '15'
										    ]);
									    ?>
									</div>
								</div>
							</li>
						</ul>
						<?php echo  form_close(); ?>
						
						
						<!--script to check name length-->
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
<?php
$this->load->view('admin/templates/footer.php');
?>
