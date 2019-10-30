<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/order/change_order_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>						
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
							<th class="tip_top" title="Click to sort">Date Added</th>
                            <th class="tip_top" title="Click to sort">Currency Type (Host)</th>
							<th class="tip_top" title="Click to sort">Amount (Host) </th>
							<th class="tip_top" title="Click to sort">Amount (Admin)</th>
							<th>Guest Email</th>
							<th>Host Email</th>
   							<th class="tip_top" title="Click to sort">Booking Status</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($newbookingList->num_rows() > 0)
						{
							$i=1;
							foreach ($newbookingList->result() as $row)
							{								if($row->currency_cron_id==0){ $currencyCronId = '';} else { $currencyCronId=$row->currency_cron_id; }
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
                            <td class="center"><?php echo $i;?></td>
							<td class="center"><?php echo $row->Bookingno;?></td>
   							<td class="center">
								<?php echo date('d-m-Y',strtotime($row->dateAdded));?>
							</td>
							<td class="center"><?php echo $row->currencycode;?></td>
							<td class="center">								<?php /*echo $row->totalAmt; */ 																if($row->user_currencycode!=$row->currencycode)								{									echo currency_conversion($row->user_currencycode, $row->currencycode, $row->totalAmt,$currencyCronId) . "<br>";								}								else								{									echo $row->totalAmt . "<br>";								}								?>															</td>
							<td class="center">
								<?php 
										$unitPerCurrencyUser=$row->unitPerCurrencyUser;
										if($admin_currency_code!=$row->user_currencycode)
										{											
											echo $admin_currency_symbol.' '.currency_conversion($row->user_currencycode, $admin_currency_code, $row->totalAmt,$currencyCronId);//.'|'.customised_currency_conversion($unitPerCurrencyUser,$row->totalAmt);
										}
										else
										{
											echo $admin_currency_symbol.' '.$row->totalAmt;
										}
										?>
							</td>
							<td class="center"><?php echo $row->email;?></td>
							<td class="center">
								 <?php
								 $hostemail = $this->account_model->get_all_details(USERS,array('id'=>$row->renter_id));
								  echo $hostemail->row()->email;
								 ?>
							</td>
							<td class="center">
							<span class="badge_style b_done">
								<?php
								if($row->booking_status=='Pending')
								{
								 echo "Pending & Expired"; 
								}
								elseif($row->booking_status=='Booked')
								{
								 echo "Booked & Expired"; 
								}
								else
								{
								 echo "Expired"; 
								}
								?>									
							</span>
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
                            <th class="tip_top" title="Click to sort">Date Added</th>
							<th class="tip_top" title="Click to sort">Currency Type (Host)</th>
							<th class="tip_top" title="Click to sort">Amount (Host)</th>
							<th class="tip_top" title="Click to sort">Amount (Admin)</th>
							<th>Guest Email</th>
							<th>Host Email</th>
   							<th class="tip_top" title="Click to sort">Booking Status</th>
						</tr>
						</tfoot>
						</table>
					</div>
				</div>
			</div><?php
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