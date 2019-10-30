<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/order/change_order_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tbl">
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
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th class="tip_top" title="Click to sort">Date</th>
								<th class="tip_top" title="Click to sort">Property ID</th>
								<th>Guest Email</th>
								<th>Guest Contact</th>
								<th>Host Email</th>
								<th>Host Contact</th>
								<th class="tip_top" title="Click to sort">Booking Status</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($newbookingList->num_rows() > 0) 
							{
								$i = 1;
								foreach ($newbookingList->result() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'checkall'
											        ]);	
												?>
										</td>
										<td class="center">
											<?php echo $i; ?>
										</td>
										<td class="center">
											<?php echo $row->Bookingno; ?>
										</td>
										<td class="center">
											<?php echo date('d-m-Y', strtotime($row->dateAdded)); ?>
										</td>
										<td class="center">
											<?php echo $row->prd_id; ?>
										</td>
										<td class="center">
											<?php echo $row->email; ?>
										</td>
										<td class="center">
											<?php echo ($row->phone_no == 0) ? " " : $row->phone_no; ?>
										</td>
										<td class="center">
											<?php
											$hostemail = $this->account_model->get_all_details(USERS, array('id' => $row->renter_id));
											echo $hostemail->row()->email;
											?>
										</td>
										<td class="center">
											<?php
											$hostemail = $this->account_model->get_all_details(USERS, array('id' => $row->renter_id));
											echo ($hostemail->row()->phone_no == 0) ? " " : $hostemail->row()->phone_no;
											?>
										</td>
										<td class="center">
											<span
												class="badge_style b_done"><?php echo ($row->booking_status == "Pending") ? "Pending Confirmation" : $row->booking_status; ?></span>
										</td>
									</tr>
									<?php
									$i++;
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
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th class="tip_top" title="Click to sort">Date</th>
								<th class="tip_top" title="Click to sort">Property ID</th>
								<th>Guest Email</th>
								<th>Guest Contact</th>
								<th>Host Email</th>
								<th>Host Contact</th>
								<th class="tip_top" title="Click to sort">Booking Status</th>
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
