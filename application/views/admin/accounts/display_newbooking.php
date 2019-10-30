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
                            <th class="tip_top" title="Click to sort">
								<span style="padding:10px"> S No</span>
							</th>
							<th class="tip_top" title="Click to sort">
								<span style="padding:5px 10px 5px 5px">Booking No</span>
							</th>
                            <th class="tip_top" title="Click to sort">
								 Date Added		
							</th>							
							<th>
								<span style="padding:10px">Guest Email ID</span>
							</th>
							<th>
                            	Host Email ID
                            </th>
   							<th class="tip_top" title="Click to sort">
								Booking Status
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						$payment = $this->account_model->get_all_details(PAYMENT,array('status'=>'Paid'));
						foreach($payment->result() as $enqId)$enqIds[]=$enqId->EnquiryId;
						if ($newbookingList->num_rows() > 0)
						{
						$i=1;
							foreach ($newbookingList->result() as $row)
							{	
							  if(!in_array($row->id, $enqIds))
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
								<?php echo $i;?>
							</td>
							<td class="center">
								<?php echo $row->Bookingno;?>
							</td>
   							<td class="center">
								<?php echo date('d-m-Y',strtotime($row->dateAdded));?>
							</td>
							<td class="center">
								 <?php echo $row->email;?>
							</td>							
							<td class="center">
								 <?php
								 $hostemail = $this->account_model->get_all_details(USERS,array('id'=>$row->renter_id));
								  echo $hostemail->row()->email;
								 ?>
							</td>
							<td class="center">
							<?php 
							if($row->approval=="Pending") 
							{
							$status ="Pending Confirmation";
							} 
							else if($row->approval=="Accept") 
							{
							$status ="Pending Payment";
							} 
							elseif($row->approval=="Decline") 
							{
							$status ="Decline";
							}
							?>
							<span class="badge_style b_done"><?php echo $status;?></span>
							</td>							
						</tr>                        
						<?php 
						}
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
							<th>Guest Email ID</th>    
							<th>Host Email ID</th>
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