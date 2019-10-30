<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading; ?></h6>
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

										echo form_label('Password','admin_name', $commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $rep_details->row()->show_password; ?>
									</div>
								</div>
							</li>


							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Email Address','email', $commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $rep_details->row()->email; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Sub Admin Name','admin_name', $commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $rep_details->row()->admin_name; ?>
									</div>
								</div>
							</li>
							<li>
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
									    'value'       => $rep_details->row()->id,
									    'name'        => 'subadminid'
									    ]);

								sizeof($adminPrevArr);
								$subAdmin = $adminPrevArr;
								
								for ($i = 0; $i < sizeof($adminPrevArr); $i++)
								{
									$subAdmin = $adminPrevArr[$i];
									$priv = array();
									if (isset($privArr[$subAdmin])) 
									{
										$priv = $privArr[$subAdmin];
									}
									if (!is_array($priv)) 
									{
										$priv = array();
									}
									?>
									<div class="form_grid_12">
										<?php
										echo form_label(ucfirst($subAdmin),'', 
											$commonclass);	
								    	?>
										<table border="0" cellspacing="0" cellpadding="0" width="400">
											<tr>
												<?php for ($j = 0; $j < 4; $j++) 
												{ ?>
													<td align="center" width="15%">

                                                        <?php

                                                        if((($subAdmin == 'RentalTransaction' && $j == 0) || ($subAdmin == 'RentalBookingStatus' && $j == 0)||($subAdmin == 'ExperienceTransaction' && $j == 0) || ($subAdmin == 'ExperienceBookingStatus' && $j == 0) || ($subAdmin == 'Commission' && $j == 0) || ($subAdmin == 'Review' && $j == 0) || ($subAdmin == 'Review' && $j == 3)||($subAdmin == 'Dispute' && $j == 0)||($subAdmin == 'PaymentGateway' && $j == 0) ||($subAdmin == 'PaymentGateway' && $j == 2)||($subAdmin == 'Backup' && $j == 0)|| (($subAdmin == 'Enquiries' && $j != 2) && ($subAdmin == 'Enquiries' && $j != 1))) || (($subAdmin != 'RentalTransaction') && ($subAdmin != 'ExperienceTransaction') && ($subAdmin !='RentalBookingStatus') && ($subAdmin !='ExperienceBookingStatus') && ($subAdmin !='Commission') && ($subAdmin !='Review') && ($subAdmin !='Dispute') && ($subAdmin !='PaymentGateway')&&($subAdmin !='Backup')&&($subAdmin !='Enquiries'))){

                                                            ?>
														<input disabled="disabled" <?php if (in_array($j, $priv)) {
															echo 'checked="checked"';
														} ?> type="checkbox" name="<?php echo $subAdmin . '[]'; ?>"
															   id="<?php echo $subAdmin . '[]'; ?>"
															   value="<?php echo $j; ?>"/>

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
										<a href="admin/rep/display_rep_list" class="tipLeft"
										   title="Back to representative list"><span
												class="badge_style b_done">Back</span>
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
