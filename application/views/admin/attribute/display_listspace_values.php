<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/listattribute/change_list_value_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('3', $ListSpace)) 
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
							
							if ($allPrev == '1' || in_array('3', $ListSpace)) 
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to delete records"><span
											class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php 
							} ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display" id="action_tbl_view">
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
								<th class="tip_top" title="Click to sort">Rental Type Name</th>
								<th class="tip_top" title="Click to sort">Rental Type Value</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($listValues->num_rows() > 0) 
							{
								foreach ($listValues->result() as $row) 
								{
									if (strtolower($row->attribute_name) != '') 
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
											<td class="center"><?php echo $row->attribute_name;?></td>
											<td class="center"><?php echo $row->list_value; ?></td>
											<center>
												<td>
													<?php
													if($row->listspace_id==9 && trim($row->list_value)=='House')
													{
														echo 'Active';
													}
													else
													{
														$modeid = ($row->status == 'Active') ? '0' : '1';
														if ($modeid == '0') 
														{
															?>
															<a title="Click to inactive" class="tip_top"
															   href="javascript:confirm_status('admin/seller/verify_user_liststatus/<?php echo $modeid; ?>/<?php echo $row->id; ?>');">
																<span
																	class="badge_style b_done"><?php echo 'Active';?>		
																</span>
															</a>
															<?php
														} 
														else
														{
															?>
															<a title="Click to active" class="tip_top"
															   href="javascript:confirm_status('admin/seller/verify_user_liststatus/<?php echo $modeid; ?>/<?php echo $row->id; ?>')">
																<span
																	class="badge_style"><?php echo "Inactive"; ?>		
																</span>
															</a>
															<?php
														}
													}
													?>
												</td>
											</center>

											<td class="center">
												<?php if ($allPrev == '1' || in_array('2', $ListSpace)) 
													{ ?>
													<span>
														<a class="action-icons c-edit"
															 href="admin/listattribute/edit_listSpace_value_form/<?php echo $row->id; ?>"
															 title="Edit">Edit
														</a>
													</span>
												<?php 
													} 
													if($row->listspace_id==9 && trim($row->list_value)=='House')
													{
													}
													else
													{
													if ($allPrev == '1' || in_array('3', $ListSpace)) 
													{ ?>
														<span>
															<a class="action-icons c-delete"
															 href="javascript:confirm_delete('admin/listattribute/delete_listspace_value/<?php echo $row->id; ?>')"
															 title="Delete">Delete
															</a>
														</span>
												<?php 
													} } ?>
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
								<th>Rental Type Name</th>
								<th>Rental Type Value</th>
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
