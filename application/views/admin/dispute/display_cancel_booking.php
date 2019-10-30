<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/review/change_review_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php 							
							if ($allPrev == '1' || in_array('3', $Review))
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php 
							} ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display display_tbl" id="dispute_tbl_property">
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
								<th class="center" title="Click to sort">Rental Name</th>
								<th class="center" title="Click to sort">Booking No</th>
								<th class="center" title="Click to sort">

								Cancelled By

							</th>
								<th class="center" title="Click to sort">Cancel Message</th>
								<th class="center" title="Click to sort">Cancel Email</th>
								<th class="center" title="Click to sort">Cancellation percentage</th>
								<th class="center" title="Click to sort">Date added</th>
								<th class="center" title="Dispute Status">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							$i = 1;
							if (count($disputecancelbooking->result_array()) > 0)
							{
								foreach ($disputecancelbooking->result_array() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row['id'],
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check'
											        ]);	
												?>
										</td>
										<td class="center  tr_select">
											<?php echo $i; ?>
										</td>
										<td class="center tr_select ">
											<a href="<?php echo base_url(); ?>rental/<?php echo $row['product_id']; ?>" target="_blank"><?php echo ucfirst($row['product_title']); ?>	
											</a>
										</td>
                                        <td class="center tr_select ">
                                        <?php echo $row['booking_no']; ?>
                                        </td>
                                        <td>
                                        <?php if($row['dispute_by'] == 'Host') { echo $row['dispute_by'] ;}else {echo 'Guest';}?>
                                    </td>
										<td class="center tr_select ">
											<?php echo ucfirst($row['message']); ?>
										</td>
										<td class="center tr_select ">
											<?php if($row['dispute_by'] == 'Host') { echo $row['d_email'] ;}else {echo $row['email'];}?>
										</td>
										<?php if ($row['cancellation_percentage'] != '')
										{
											?>
											<td class="center tr_select ">
												<?php echo $row['cancellation_percentage'] . '%'; ?>
											</td>
										<?php 
										} 
										else
										{ ?>
											<td class="center tr_select ">
												<?php echo "---"; ?>
											</td>
										<?php 
										} ?>
										<td class="center tr_select ">
											<?php echo date('m-d-Y', strtotime($row['created_date'])); ?>
										</td>
										<td class="center tr_select ">
											<?php 
											if ($row['status'] == 'Accept')
											{
												?>
												<span class="badge_style b_done"><?php echo "Cancelled"; ?></span>
												
									
									
												<?php
											} 
											elseif ($row['status'] == 'Reject')
											{
												?>
												<span class="badge_style" style="background-color: rgb(206, 10, 10);border-color:#771515"><?php echo "Rejected"; ?>
												</span>
											<?php
											} 
											else
											{
												?>


											<?php
											 $check_in = date("Y-m-d", strtotime($row['checkin']));
											 $time_val = date("Y-m-d");
											if (strtotime(date('Y-m-d')) < $check_in){ ?>
                                                <span class="badge_style"><?php echo $row['status']; ?>	</span>
												<div style="margin-top: 10px;">
													<a href='<?php echo base_url() . "admin/dispute/Cancel_Book/" . $row['id'] . '/' . $row['booking_no'] . '/' . $row['cancel_status']; ?>'>
											<button type="button" class="btn_small btn_blue" tabindex="4"> <span>Accept</span></button>
										</a>

										<a href='<?php echo base_url() . "admin/dispute/rejectBooking/" . $row['id'] . '/' . $row['booking_no'] . '/' . $row['cancel_status']; ?>'>
											<button type="button" class="btn_small btn_blue"	style='background-color: rgb(206, 10, 10);border-color:#771515  ' tabindex="4"><span>Reject</span></button>
										</a></div>
									<?php }else{
											    ?>
                                                <span class="badge_style" style="background-color: rgb(126, 123, 123);border-color:#771515">Expired</span>
                                                <?php

                                            } ?>
											<?php 
											} ?>
										</td>
										<td class="center">
											<span>
												<a class="action-icons c-suspend"
													 href="admin/dispute/view_cancel_booking/<?php echo $row['booking_no']; ?>"
													 title="View">View
												</a>
											</span>
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
								<th><span class="tip_top">S.No.</span></th>
								<th><span class="center">Rental Name</span></th>
								<th><span class="center">Booking No</span></th>
								<th><span class="center">Cancelled By</span></th>
								<th><span class="center">Cancel Message</span></th>
								<th><span class="center">Cancel Email</span></th>
								<th class="center">Cancellation percentage</th>
								<th>Date added</th>
								<th class="center">Status</th>
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
