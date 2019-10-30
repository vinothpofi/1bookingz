<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form', 'accept-charset' => 'UTF-8');
			echo form_open('admin/listings/change_list_types_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading; ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<table class="display" id="action_tbl_view">
							<thead>
							<tr>
								<th class="center">S.No.</th>
								<th class="tip_top" title="Click to sort">Name</th>
								<th class="tip_top" title="Click to sort">Type</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th class="tip_top" title="Click to sort"> Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i = 1;							
							foreach ($listingvalues as $row) 
							{
								if (strtolower($row->name) != 'price' && $row->type != 'text')
								{
									?>
									<tr>
										<td class="center tr_select "><?php echo $i; ?></td>
										<td class="center"><?php echo $row->labelname; ?></td>
										<td class="center"><?php echo $row->type; ?></td>
										<td class="center">
											<span class="badge_style b_done"><?php echo $row->status; ?>	
											</span>
										</td>
										<?php 
										if ($row->type != 'text') 
										{ ?>
											<td class="center">
												<?php
												if ($allPrev == '1' || in_array('2', $Listing)) 
												{ ?>
													<span>
														<a class="action-icons c-add"
															 href="admin/listings/add_new_child_fields/<?php echo $row->id; ?>"
															 title="Add Child">Add Child
														</a>
													</span>
												<?php 
												} ?>
												<span>
													<a class="action-icons c-suspend"
														 href="admin/listings/view_listing_child_values/<?php echo $row->id; ?>"
														 title="View child values">View child values
													</a>
												</span>
											</td>
										<?php 
											} else { ?>
											<td></td>
										<?php } ?>
									</tr>
									<?php $i++;
								}
							}							
							?>
							</tbody>
							<tfoot>
							<tr>
								<th class="center">S.No.</th>
								<th>Name</th>
								<th>Type</th>
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
