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
						<h6><?php echo $heading; ?></h6>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="subadmin_tblPaid">
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
								<th class="tip_top" title="Click to sort">Guest Email-ID</th>
								<th class="tip_top" title="Click to sort">Payment Date & Time</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th>Total&nbsp;<a class="fa fa-info-circle fa-lg tipTop" original-title="Total Booking amount with service fee and security fee in admin's currency"></a></th>
								<th>Payment Type</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($orderList->num_rows() > 0) 
							{
								$i = 1;
								foreach ($orderList->result() as $row) 
								{
									?>
									<tr>
										<td class="center tr_select ">
											<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id; ?>">
										</td>
										<td class="center">
											<?php 	echo $i; ?>
										</td>
										<td class="center">
											<?php echo $row->email; ?>
										</td>
										<td class="center">
											<?php echo $row->created; ?>
										</td>
										<td class="center">
											<?php echo $row->bookingno; ?>
										</td>
										<td -class="center <?php echo $row->currency_cron_id;?>" style="text-align:right">
											<?php 
											if($row->currency_cron_id==0) { $currencyCronId='';} else {$currencyCronId=$row->currency_cron_id; }
											$currencyPerUnitSeller = $row->currencyPerUnitSeller;
											if ($admin_currency_code != $row->currency_code) 
											{
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->total); 
												echo currency_conversion($row->currency_code, $admin_currency_code, $row->total,$currencyCronId);
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . number_format($row->total,2);
											}
											?>
										</td>
										<td class="center">
											<!-- <?php echo ($row->payment_type == "Credit Cart") ? "Credit Card" : $row->payment_type; ?> -->
											 <?php echo ($row->payment_type !="Paypal" && $row->paypal_transaction_id !="0")?"Stripe":$row->payment_type;?>
										</td>
										<td class="center">
											<span class="badge_style b_done"><?php echo $row->status; ?></span>
										</td>
										<td class="center">
											<a href="admin/order/order_review/<?php echo $row->dealCodeNumber; ?>"
											   class="tipTop" title="View details"><span class="action-icons c-suspend" style="cursor:pointer;"></span>
											</a>
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
								<th>S No</th>
								<th>Guest Email-ID</th>
								<th>Payment Date & Time</th>								
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th>Total</th>
								<th>Payment Type</th>
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
