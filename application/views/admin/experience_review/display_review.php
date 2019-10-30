<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/experience_review/change_review_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $Review))
							{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to active records"><span class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');" class="tipTop"
									   title="Select any checkbox and click here to inactive records"><span class="icon delete_co"></span><span class="btn_link">Inactive</span>
									</a>
								</div>
								<?php
							}
							if ($allPrev == '1' || in_array('3', $Review))
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"  class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display display_tbl" id="review_tbl">
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
								<th class="tip_top" title="Click to sort">S.No</th>
								<th class="center" title="Click to sort">Experience Name</th>
								<th class="center" title="Click to sort">Review For</th>
								<th class="center" title="Click to sort">Booking No</th>
								<th class="center" title="Click to sort">Rating</th>
								<th class="center" title="Click to sort">Email-ID</th>
								<th class="center" title="Click to sort">Date added</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i = 1;
							if (count($reviewList->result_array()) > 0)
							{
								foreach ($reviewList->result_array() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row['id'],
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'checkall'
											        ]);	
												?>
										</td>
										<td class="center  tr_select">
											<?php echo $i; ?>
										</td>
										<td class="center tr_select ">
											<a href="<?php echo base_url(); ?>view_experience/<?php echo $row['product_id']; ?>"
											   target="_blank"><?php echo ucfirst($row['product_title']); ?>  	
											</a>
										</td>
										
										<td class="center  tr_select">
											<?php if($row['review_type'] == '0'){echo "Experience";}else{echo "Host";} ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row['bookingno']; ?>
										</td>
										<td class="center tr_select ">
											<?php echo ucfirst($row['total_review']); ?>
										</td>
										<td class="center tr_select ">
											<?php echo $row['email']; ?>
										</td>
										<td class="center tr_select ">
											<?php echo date('m-d-Y', strtotime($row['dateAdded'])); ?>
										</td>
										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $Review))
											{
												$mode = ($row['status'] == 'Active') ? '0' : '1';
												if ($mode == '0')
												{
													?>
													<a title="Click to inactive" class="tip_top"
													   href="javascript:confirm_status('admin/experience_review/change_review_status/<?php echo $mode; ?>/<?php echo $row['id']; ?>');"><span class="badge_style b_done"><?php echo $row['status']; ?></span>
													</a>
													<?php
												} 
												else
												{
													?>
													<a title="Click to active" class="tip_top"
													   href="javascript:confirm_status('admin/experience_review/change_review_status/<?php echo $mode; ?>/<?php echo $row['id']; ?>')"><span class="badge_style"><?php echo $row['status']; ?></span>
													</a>
													<?php
												}
											} 
											else
											{
												?>
												<span class="badge_style b_done"><?php echo $row['status']; ?>	
												</span>
											<?php 
											} ?>
										</td>
										<td class="center">										
											<span>
												<a class="action-icons c-suspend"
													 href="admin/experience_review/view_review/<?php echo $row['id']; ?>"
													 title="View">View
												</a>
											</span>
											<?php 
											if ($allPrev == '1' || in_array('3', $Review))
											{ ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:confirm_delete('admin/experience_review/delete_review/<?php echo $row['id']; ?>')"
														 title="Delete">Delete
													</a>
												</span><?php 
											} ?>
										</td>
									</tr>
									<?php
									$i = $i + 1;
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
								<th><span class="tip_top">S.No</span></th>
								<th><span class="center">Experience Name</span></th>
								<th class="center" title="Click to sort">Review For</th>
								<th><span class="center">Booking No</span></th>
								<th><span class="center">Rating</span></th>
								<th><span class="center">Email-ID</span></th>
								<th>Date added</th>
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
				echo form_close();	
			?>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
