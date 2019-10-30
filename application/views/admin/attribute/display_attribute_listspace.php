<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
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
			echo form_open('admin/listattribute/change_attribute_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<table class="display" id="action_tbl_view">
							<thead>
							<tr>								
								<th class="tip_top" title="Click to sort">Rental Type Name</th>
								<th class="tip_top" title="Click to sort">Created Date</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($attributeList->num_rows() > 0)
							{
								foreach ($attributeList->result() as $row)
								{
									if (strtolower($row->attribute_name) != 'price')
									{
										?>
										<tr>											
											<td class="center">
												<?php echo $row->attribute_name; ?>
											</td>
											<td class="center">
												<?php echo $row->dateAdded; ?>
											</td>
											<td class="center">
												<?php
												if ($allPrev == '1' || in_array('2', $ListSpace))
												{
													$mode = ($row->status == 'Active') ? '0' : '1';
													if ($mode == '0') 
													{
														?>
														<?php if ($row->id == '9') 
														{  
															echo $row->status; 
														}				 
														else 
														{ ?>
															<a title="Click to inactive" class="tip_top"
															   href="javascript:confirm_status('admin/listattribute/change_listattribute_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span
																	class="badge_style b_done"><?php echo $row->status; ?></span>
															</a>
															<?php
														}
													} 
													else
													{
													?>
														<a title="Click to active" class="tip_top" href="javascript:confirm_status('admin/listattribute/change_listattribute_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')">
															<span class="badge_style"><?php echo $row->status; ?>	
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
												<?php 
												} ?>
											</td>
											<td class="center">
												<?php if ($allPrev == '1' || in_array('2', $ListSpace)) 
												{ ?>
													<span>
														<a class="action-icons c-edit"
															 href="admin/listattribute/edit_listattribute_form/<?php echo $row->id; ?>"
															 title="Edit">Edit
														</a>
													</span>
												<?php 
												} ?>
											</td>
										</tr>
										<?php
									}
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>								
								<th>Rental Type Name</th>
								<th class="tip_top" title="Click to sort">Created Date</th>
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
