<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/attribute/change_attribute_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $List)) {
								?>
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
							if ($allPrev == '1' || in_array('3', $List)) 
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
									        'class'    => 'checkall',
									    ]);	
									?>
								</th>

								<th class="tip_top" title="Click to sort">Amenities Name</th>
								<th class="tip_top" title="Click to sort">Created Date</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
								<input type="hidden" name="total_value_count" id="total_value_count" value="<?php echo $attributeList->num_rows(); ?>">
							<?php

							if ($attributeList->num_rows() > 0) 
							{
								foreach ($attributeList->result() as $row) 
								{
									/*check attribute have child values*/
									$this->db->select('list_id');
									$this->db->from('fc_list_values');
									$this->db->where('list_id',$row->id);
									$attribute_result = $this->db->get();
									if (strtolower($row->attribute_name_en) != 'price') {
										?>
										<tr>
											<td class="center tr_select ">
												<?php
												if($attribute_result->num_rows() == 0 && $attributeList->num_rows() != 1)
												{
													echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check',
											        'id'       => 'check_box'
											        ]);	
												}else{

												}
												
												?>
											</td>
											<td class="center">
												<?php echo $row->attribute_name; ?>
											</td>
											<td class="center">
												<?php echo date("d-m-Y h:i A", strtotime($row->dateAdded)); ?>
											</td>

											<td class="center">
												<?php
												
												if (($allPrev == '1' || in_array('2', $List)) && $attribute_result->num_rows() == 0) 
												{
													$mode = ($row->status == 'Active') ? '0' : '1';
													if ($mode == '0') 
													{
														?>
														<a title="Click to inactive" class="tip_top"
														   href="javascript:confirm_status('admin/attribute/change_attribute_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->status; ?></span>
														</a>
														<?php
													} 
													else
													{
														?>
														<a title="Click to active" class="tip_top"
														   href="javascript:confirm_status('admin/attribute/change_attribute_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->status; ?></span>
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
												<?php if ($allPrev == '1' || in_array('2', $List)) { ?>
													<span><a class="action-icons c-edit"
															 href="admin/attribute/edit_attribute_form/<?php echo $row->id; ?>"
															 title="Edit">Edit
															</a>
													</span>
												<?php } ?>
												
												<?php if ($allPrev == '1' || in_array('3', $List)) {?> 
													<?php if($attributeList->num_rows() == 1){ ?>
													<span>
														<a class="action-icons c-delete"
															 href="javascript:void(0)"
															 title="Atleast one attribute list Present">Delete
														</a>
													</span>
												<?php }elseif($attribute_result->num_rows() > 0){ ?><span>
														<a class="action-icons c-delete"
															 href="javascript:void(0)"
															 title="Amenities Have Child. Can't be delete">Delete
														</a>
													</span>

												<?php }else{?>

													<span>

														<a class="action-icons c-delete"

															 href="javascript:confirm_delete('admin/attribute/delete_attribute/<?php echo $row->id; ?>')"

															 title="Delete">Delete

														</a>

													</span>

												<?php } } ?>
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

								<th>Amenities Name</th>
								<th>Created Date</th>
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
					'id'       => 'total_value_count',
					'name' 	   => 'total_value_count',
					'value'    =>  $attributeList->num_rows()
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
