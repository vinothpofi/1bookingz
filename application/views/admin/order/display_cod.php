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
									<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
								</th>
								<th class="tip_top" title="Click to sort">Order Id</th>
								<th class="tip_top" title="Click to sort">User Email</th>
								<th class="tip_top" title="Click to sort">Payment Date</th>
								<th class="tip_top" title="Click to sort">Transaction ID</th>
								<th>Total</th>
								<th>Payment Type</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($orderList->num_rows() > 0) 
							{
								foreach ($orderList->result() as $row) 
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
											<?php echo $row->id; ?>
										</td>
										<td class="center">
											<?php echo $row->email; ?>
										</td>
										<td class="center">
											<?php echo $row->created; ?>
										</td>

										<td class="center">
											<?php echo $row->dealCodeNumber; ?>
										</td>
										<td class="center">
											<?php echo $row->price; ?>
										</td>
										<td class="center">
											<?php echo $row->payment_type; ?>
										</td>
										<td class="center">
											<span class="badge_style b_pending"><?php echo $row->status; ?></span>
										</td>
										<td class="center">
											<span><a class="action-icons c-approve"
													 href="admin/order/displayconfirm_booking/<?php echo $row->id; ?>"
													 title="confirm">Confirm
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
								<th>Order Id</th>
								<th>User Email</th>
								<th>Payment Date</th>
								<th>Transaction ID</th>
								<th>Total</th>
								<th>Payment Date</th>
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
