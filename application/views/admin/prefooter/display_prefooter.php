<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/prefooter/change_prefooter_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $user))
							{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to active records"><span
											class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to inactive records"><span	class="icon delete_co"></span><span class="btn_link">Inactive</span></a>
								</div>
								<?php
							}

							if ($allPrev == '1' || in_array('3', $Prefooter))
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span	class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display" id="newsletter_tbl">
							<thead>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
								<th class="tip_top" title="Click to sort">Prefooter Tilte</th>
								<th class="tip_top" title="Click to sort">Footer Link</th>
								<th>Prefooter Image</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($prefooterList->num_rows() > 0)
							{
								foreach ($prefooterList->result() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check'
											        ]);	
												?>
										</td>
										<td class="center">
											<?php echo ucfirst($row->footer_title); ?>
										</td>
										<td class="center">
											<?php echo $row->footer_link; ?>
										</td>
										<td class="center">
											<div class="widget_thumb">
												<?php if ($row->image != '') { ?>
													<img class="rollovereff" width="40px" height="40px"
														 src="<?php echo base_url(); ?>images/prefooter/<?php echo $row->image; ?>"/>
												<?php } else { ?>
													<img class="rollovereff" width="40px" align="middle" height="40px"
														 src="<?php echo base_url(); ?>images/users/user-thumb1.png"/>
												<?php } ?>
											</div>
										</td>

										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $Prefooter))
											 {
												$mode = ($row->status == 'Active') ? '0' : '1';
												if ($mode == '0')
												 {
													?>
													<a title="Click to inactive" class="tip_top"
													   href="javascript:confirm_status('admin/prefooter/change_prefooter_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->status; ?></span>
													</a>
													<?php
												}
												else
												{
													?>
													<a title="Click to active" class="tip_top"
													   href="javascript:confirm_status('admin/prefooter/change_prefooter_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->status; ?></span>
													</a>
													<?php
												}
											} 
											else 
											{
												?>
												<span class="badge_style b_done"><?php echo $row->status; ?>		
												</span>
											<?php 
											} ?>
										</td>
										<td class="center">
											<span>
												<a class="action-icons c-edit"
													 href="admin/prefooter/edit_prefooter_form/<?php echo $row->id; ?>"
													 title="Edit">Edit
												</a>
											</span>
											
										</td>
									</tr>
									<?php
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
								<th>Prefooter Title</th>
								<th>Footer Link</th>
								<th>Prefooter Image</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<?php
				echo form_input([
					'type'     => 'hidden',
					'id'       => 'statusMode',
					'name' 	   => 'statusMode'
					 ]);

				echo form_input([
					'type'     => 'hidden',
					'id'       => 'SubAdminEmail',
					'name' 	   => 'SubAdminEmail'
					 ]);

				echo form_close();	
			?>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
