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
								<th class="tip_top" title="Click to sort">Host Email-id</th>
								<th class="tip_top" title="Click to sort">Property title</th>
								<th class="tip_top" title="Click to sort">Payment Date</th>
								<th>Total(Host)<a class="tip_top" title="Total in Host's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th>Total(Admin)<a class="tip_top" title="Total in Admin's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th class="tip_top" title="Click to sort">Commission</th>
								<th class="tip_top" title="Click to sort">Payable amount(Host)<a class="tip_top" title="Payable amount in Host's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
								<th class="tip_top" title="Click to sort">Payable amount(Admin)<a class="tip_top" title="Payable amount in Admin's Currency code"><i class="fa fa-info-circle fa-lg"></i></a></th>
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
										<td -class="center" style="text-align:right">
											<?php echo $this->db->select('currency_symbols')->where('currency_type',$row->hosted_currency)->get('fc_currency')->row()->currency_symbols.$row->price; ?>
										</td>
										<td -class="center" style="text-align:right">
											<?php

											$unitPerCurrencyHost = $row->unitPerCurrencyHost;

											if ($admin_currency_code != $row->currency_code_host)
											{
												$createdDate = date('Y-m-d',strtotime($row->created));
												$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
												if($gotCronId==0) { $gotCronId='';}
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($unitPerCurrencyHost, $row->price);
												echo currency_conversion($row->currency_code_host, $admin_currency_code, $row->price,$gotCronId);
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . number_format($row->price,2);
											}
											?>
										</td>
										<td class="center">
											<?php echo $row->commission . " (" . $row->commission_type . ")"; ?>
										</td>
										<td -class="center" style="text-align:right">
											<?php

											if ($admin_currency_code != $row->currency_code_host)
											{
												$createdDate = date('Y-m-d',strtotime($row->created));
												$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
												if($gotCronId==0) { $gotCronId='';}
												$price = currency_conversion($admin_currency_code,$row->currency_code_host, $row->hosting_price,$gotCronId);
												echo $this->db->select('currency_symbols')->where('currency_type',$row->currency_code_host)->get('fc_currency')->row()->currency_symbols.$price;
												
												//$theHostingPrice = $row->hosting_price * $unitPerCurrencyHost;
												///echo $theHostingPrice . " " . $row->currency_code_host;
												
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . $row->hosting_price;
											}
											?>
										</td>
										<td class="center">
											<?php

											echo $admin_currency_symbol . " " . $row->hosting_price;
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
											<span class="badge_style b_done"><?php echo $row->payment_status; ?>	
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
								<th class="tip_top" title="Click to sort">Host Email-id</th>
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
