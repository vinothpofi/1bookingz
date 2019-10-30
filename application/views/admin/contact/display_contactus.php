<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/contact_us/change_contact_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6>CONTACT DETAILS</h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php
							if ($allPrev == '1' || in_array('3', $Contact_Us))
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>

					<div class="widget_content">
						<table class="display" id="language_tbl">
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
								<th class="tip_top" title="Click to sort">Name</th>
								<th class="tip_top" title="Click to sort">Email</th>
								<th class="tip_top" title="Click to sort">Subject</th>
								<th class="tip_top" title="Click to sort">Date</th>
								<th class="tip_top" title="Click to sort">Message
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($admin_contactus->num_rows() > 0) 
							{
								foreach ($admin_contactus->result() as $row) 
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php 
											if ($row->lang_code != 'en') 
											{ 
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check'
											        ]);	
											} 
											?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->name; ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->email; ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->subject; ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->date; ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->message; ?>
										</td>
										<td class="center">
											<?php 
											if ($allPrev == '1' || in_array('2', $ContactUs))
											{ ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/contact_us/replaymail/<?php echo $row->id; ?>"
														 title="Reply">Reply
													</a>
												</span>
											<?php 
											} 

											if ($allPrev == '1' || in_array('3', $ContactUs))
											{ ?>
												<span>
													<a class="action-icons c-delete"
														 href="admin/contact_us/change_contact_status/<?php echo $row->id; ?>" title="Delete">Delete
													</a>
												</span>
											<?php 
											} ?>
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
								<th>Name</th>
								<th>Email</th>
								<th>Subject</th>
								<th>Date</th>
								<th>Message</th>
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
