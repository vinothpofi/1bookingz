<?php
$this->load->view('admin/templates/header.php');
?>
	<style>
		.table_top, .table_bottom 
		{
			display: none;
		}
	</style>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/subadmin/change_subadmin_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $subadmin)) 
							{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to active records"><span
											class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');"
									   class="tipTop"
									   title="Select any checkbox and click here to inactive records"><span
											class="icon delete_co"></span><span class="btn_link">Inactive</span>
									</a>
								</div>
								<?php
							}
							?>							
						</div>
					</div>
					<div class="widget_content">
						<table class="display" id="subadmin_tbl">
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
								<th class="tip_top" title="Click to sort">Login Name</th>
								<th class="tip_top" title="Click to sort">Email-ID</th>
								<th class="tip_top" title="Click to sort">Admin Type</th>
								<th class="tip_top" title="Click to sort">Last Login Date</th>
								<th class="tip_top" title="Click to sort">Last Logout Date</th>
								<th class="tip_top" title="Click to sort">Last Login IP</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($admin_users->num_rows() > 0) 
							{
								foreach ($admin_users->result() as $row) 
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php
											echo form_input([
												'type'     => 'checkbox',
										        'value'    => $row->id,
										        'name' 	   => 'checkbox_id[]'
										        ]);	
											?>
										</td>
										<td class="center">
											<?php echo $row->admin_name; ?>
										</td>
										<td class="center">
											<?php echo $row->email; ?>
										</td>
										<td class="center">
											<?php echo ucfirst($row->admin_type) . ' Admin'; ?>
										</td>
										<td class="center">
											<?php echo $row->last_login_date; ?>
										</td>
										<td class="center">
											<?php echo $row->last_logout_date; ?>
										</td>
										<td class="center">
											<?php echo $row->last_login_ip; ?>
										</td>
										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $subadmin)) 
											{
												$mode = ($row->status == 'Active') ? '0' : '1';
												if ($mode == '0') 
												{
													?>
													<a title="Click to inactive" class="tip_top"
													   href="javascript:confirm_status('admin/subadmin/change_subadmin_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');">
													    <span
															class="badge_style b_done"><?php echo $row->status; ?>
														</span>
													</a>
													<?php
												} 
												else 
												{
												?>
													<a title="Click to active" class="tip_top"
													   href="javascript:confirm_status('admin/subadmin/change_subadmin_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')">
													    <span
															class="badge_style"><?php echo $row->status; ?>	
														</span>
													</a>
												<?php
												}
											}
											else 
											{
												?>
												<span class="badge_style b_done"><?php echo $row->status; ?>
												</span>
										<?php } ?>
										</td>
										<td class="center">
											<?php if ($allPrev == '1' || in_array('2', $subadmin)) 
											{ ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/subadmin/edit_subadmin_form/<?php echo $row->id; ?>"
														 title="Edit">Edit
													</a>
												</span>
											<?php } ?>
												<span>
													<a class="action-icons c-suspend"
													 href="admin/subadmin/view_subadmin/<?php echo $row->id; ?>"
													 title="View">View
													</a>
												</span>
											<?php if ($allPrev == '1' || in_array('3', $subadmin)) { ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:confirm_delete('admin/subadmin/delete_subadmin/<?php echo $row->id; ?>')"
														 title="Delete">Delete
													</a>
												</span>
											<?php } ?>
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
								<th>Login Name</th>
								<th>Email_ID</th>
								<th>Admin Type</th>
								<th>Last Login Date</th>
								<th>Last Logout Date</th>
								<th>Last Login IP</th>
								<th>Status</th>
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
