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
						<table class="display display_tbl display_tbl_fnt " id="subadmin_tblListing">
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
								<th class="tip_top" title="Click to sort">Host Email</th>
								<th class="tip_top" title="Click to sort">Property title</th>
								<th class="tip_top" title="Click to sort">Payment Date</th>
								<th>Total(Host)<a class="tip_top" title="Total in Host's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th>Total(Admin)<a class="tip_top" title="Total in Admin's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th class="tip_top" title="Click to sort">Commission</th>
								<th class="tip_top" title="Click to sort">Payable amount(Host)<a class="tip_top" title="Payable Amount in Host's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th class="tip_top" title="Click to sort">Payable amount(Admin)<a class="tip_top" title="Payable Amount in Admin's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th class="tip_top" title="Click to sort">Transaction ID</th>
								<th>Payment Type</th>
								<th class="tip_top" title="Click to sort">Status</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($listingorderList->num_rows() > 0) 
							{
								foreach ($listingorderList->result() as $row) 
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
											<?php echo $row->email; ?>
										</td>
										<td class="center">
											<?php echo $row->prd_name; ?>
										</td>
										<td class="center">
											<?php echo date('d-m-Y', strtotime($row->created)); ?>
										</td>
										<td class="center" style="text-align:right">
											<?php echo $this->db->select('currency_symbols')->where('currency_type',$row->currency_code_host)->get('fc_currency')->row()->currency_symbols.$row->amount/* . " " . $row->currency_code_host*/; ?>
										</td>
										<td class="center" style="text-align:right">
											<?php
											$unitPerCurrencyHost = $row->unitPerCurrencyHost;
											
											if ($admin_currency_code != $row->currency_code_host)
											{
												
												$createdDate = date('Y-m-d',strtotime($row->created));
												$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
												if($gotCronId!='' || $gotCronId!=0)
												{
													$price = currency_conversion($row->currency_code_host, $admin_currency_code, $row->amount,$gotCronId);
													//convertCurrency($row->currency, $admin_currency_code, $row->price);
												}
												else
												{
													$price = currency_conversion($row->currency_code_host, $admin_currency_code, $row->amount);
													//convertCurrency($row->currency, $admin_currency_code, $row->price);
												}
												echo $admin_currency_symbol . ' ' .$price;
												//echo $row->created.'|'.$row->bookingId.'|'.$admin_currency_symbol . ' '  ;
												//customised_currency_conversion($unitPerCurrencyHost, $row->amount);
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . $row->amount;
											}
											?>
										</td>
										<td class="center">
											<?php echo $row->commission . " (" . $row->commission_type . ")"; ?>
										</td>
										<td class="center" style="text-align:right">
											<?php
											//echo $admin_currency_code.'|'.$row->currency_code_host;
											if ($admin_currency_code != $row->currency_code_host)
											{
												//$theHostingPrice = $row->hosting_price * $unitPerCurrencyHost;
												//echo $theHostingPrice . " " . $row->currency_code_host;
												$createdDate = date('Y-m-d',strtotime($row->created));
												$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
												if($gotCronId!=''|| $gotCronId!=0)
												{
													$price = currency_conversion($admin_currency_code,$row->currency_code_host, $row->hosting_price,$gotCronId);
												}
												else
												{
													$price = currency_conversion($admin_currency_code,$row->currency_code_host, $row->hosting_price);
												}
												echo $this->db->select('currency_symbols')->where('currency_type',$row->currency_code_host)->get('fc_currency')->row()->currency_symbols . ' ' .number_format($price,2);
											} 
											else
											{
												echo $this->db->select('currency_symbols')->where('currency_type',$row->currency_code_host)->get('fc_currency')->row()->currency_symbols . ' ' . number_format($row->hosting_price,2);
											}
											?>
										</td>
										<td class="center" style="text-align:right">
											<?php

											echo $admin_currency_symbol . " " . number_format($row->hosting_price,2);

											?>
										</td>

										<td class="center">
											<?php 
											if ($row->paypal_txn_id != '') 
											{
												echo $row->paypal_txn_id;
											} 
											else 
											{
												echo "---";
											}
											?>
										</td>

										<td class="center">
											<?php echo $row->payment_type; ?>
										</td>
										<td class="center">
											<span class="badge_style b_done"><?php echo $row->payment_status; ?></span>
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
											'value'    => $row->id,
											'name' 	   => 'checkbox_id[]',
											'class'    => 'checkall'
											]);	
										?>
								</th>
								<th class="tip_top" title="Click to sort">Host Email</th>
								<th class="tip_top" title="Click to sort">Property title</th>
								<th class="tip_top" title="Click to sort">Payment Date</th>
								<th>Total(Host)</th>
								<th>Total(Admin)</th>
								<th class="tip_top" title="Click to sort">Commission</th>
								<th class="tip_top" title="Click to sort">Payable amount(Host)</th>
								<th class="tip_top" title="Click to sort">Payable amount(Admin)</th>
								<th class="tip_top" title="Click to sort">Transaction ID</th>
								<th>Payment Type</th>
								<th class="tip_top" title="Click to sort">Status</th>
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
