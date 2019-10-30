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
						<table class="display display_tbl" id="dispute_tbl">
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
								<th class="center" title="Click to sort">Dispute Message</th>
								<th class="center" title="Click to sort">Dispute Email</th>
								<th class="center" title="Click to sort">Date added</th>
								<th class="center" title="Dispute Status">Status</th>
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
											        'class'    => 'check'
											        ]);	
												?>											
										</td>
										<td class="center  tr_select"><?php echo $i; ?></td>
										<td class="center tr_select ">
											<a href="<?php echo base_url(); ?>rental/<?php echo $row['product_id']; ?>" target="_blank"><?php echo ucfirst($row['product_title']); ?>
											</a>
										</td>
                                        <td class="center tr_select ">
                                            <?php echo $row['booking_no']; ?>
                                        </td>
										<td class="center tr_select ">
											<?php echo ucfirst($row['message']); ?>
										</td>
										<td class="center tr_select ">
											<?php echo $row['email']; ?>
										</td>
										<td class="center tr_select ">
											<?php echo date('m-d-Y', strtotime($row['created_date'])); ?>
										</td>
										<td class="center tr_select ">

                                            <?php if($row['status'] == 'Pending')
                                            {
                                                $checkin=$row['checkin'];
                                                $checkout=$row['checkout'];
                                                if (strtotime(date('Y-m-d')) < strtotime(date(/*'Y-m-d',*/ $checkout)))
                                                { ?> <span class="badge_style b_done"><?php echo $row['status']; ?> </span>
                                          <?php }else{ ?>
                                                    <span class="badge_style">Expired</span>
                                         <?php  }
                                            }else{ ?>
                                                <span class="badge_style"><?php echo $row['status']; ?></span>
                                         <?php } ?>

											
										</td>
										<td class="center">
											<span>
												<a class="action-icons c-suspend"
													 href="admin/dispute/view_dispute/<?php echo $row['booking_no']; ?>"
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
								<th><span class="center">Dispute Message</span></th>
								<th><span class="center">Dispute Email</span></th>
								<th>Date added</th>
								<th class="center"> Status</th>
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
