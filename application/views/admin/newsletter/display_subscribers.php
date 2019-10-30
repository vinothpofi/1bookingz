<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
	<div class="grid_container">
		<?php
		$attributes = array('id' => 'display_form');
		echo form_open('admin/newsletter/change_newsletter_status_global', $attributes)
		?>
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top"><span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php if ($allPrev == '1' || in_array('2', $Newsletter)) { ?>
							<div class="lenghtMenu" style="float:left; margin-top:7px;">
								<?php
										
										$emailtmplt=array();
										$emailtmplt[''] = 'Select Email Template';
										if ($NewsList->num_rows() > 0)
										{
										foreach ($NewsList->result() as $SendNews)
										{
											if ($SendNews->id > 11)
											{
												$emailtmplt[$SendNews->id] = $SendNews->news_title;
											}	
										}
										} 

										$emailtmpltattr = array(
											    'id'     => 'mail_contents',
											    'style'  => 'width:300px',
											    'class'	 => 'chzn-select',
											    'data-placeholder' => 'Select Email Template'   
										);

										echo form_dropdown('mail_contents', $emailtmplt, '', $emailtmpltattr);
								?>
							</div>

							<div class="btn_30_light" style="height: 29px;"><a href="javascript:void(0)"  onclick="return SelectValidationAdmin('SendMailAll','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any template and click here to send email button">
							<span class="icon email_co"></span><span class="btn_link">Send Mail To All User</span></a>
							</div>

							<div class="btn_30_light" style="height: 29px;"><a href="javascript:void(0)"  onclick="return checkBoxWithSelectValidationAdmin('SendMail','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and select template click here to send email button"><span class="icon email_co"></span><span class="btn_link">Send</span></a>
							</div>

							<div class="btn_30_light" style="height: 29px;"><a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to active records"><span class="icon accept_co"></span><span class="btn_link">Active</span></a>
							</div>

							<div class="btn_30_light" style="height: 29px;"><a href="javascript:void(0)"  onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');" class="tipTop"   title="Select any checkbox and click here to inactive records">
								<span class="icon delete_co"></span><span class="btn_link">Inactive</span></a>
							</div>

							<?php
							}
							if ($allPrev == '1' || in_array('3', $Newsletter))
							{
							?>
							<div class="btn_30_light" style="height: 29px;"><a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="widget_content">
					<table class="display" id="subscriber_tbl">
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
							<th class="tip_top" title="Click to sort"> Email Address</th>
							<th class="tip_top" title="Click to sort"> Status</th>
							<th> Action</th>
						</tr>
						</thead>
						<tbody>
						<?php

						if ($subscribersList->num_rows() > 0)
						{
							foreach ($subscribersList->result() as $row)
							{
								if (filter_var($row->email, FILTER_VALIDATE_EMAIL))
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
										<td class="center"><?php echo $row->email; ?></td>
										<td class="center"><?php
											if ($allPrev == '1' || in_array('2', $Newsletter)) 
											{
												$mode = ($row->subscriber == 'Yes') ? '0' : '1';
												if ($mode == '0') 
												{
													?>
													<a title="Click to inactive" class="tip_top"
													   href="javascript:confirm_status('admin/newsletter/change_subscribers_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo "Active"; ?></span>
													</a>
													<?php
												} 
												else
												{
													?>
													<a title="Click to active" class="tip_top"
													   href="javascript:confirm_status('admin/newsletter/change_subscribers_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo 'Inactive'; ?></span>
													</a>
													<?php
												}
											} 
											else
											{
												?>
												<span class="badge_style b_done"><?php echo $row->subscriber; ?>	
												</span>
											<?php 
											} ?>
										</td>
										<td class="center">
											
											<?php 
											if ($allPrev == '1' || in_array('3', $Newsletter)) 
											{ ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:confirm_delete('admin/newsletter/delete_subscribers/<?php echo $row->id; ?>')"
														 title="Delete">Delete
													</a>
												</span>
											<?php 
											} ?>
										</td>
									</tr>
									<?php
								}
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
							<th> Email Address</th>
							<th> Status</th>
							<th> Action</th>
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
	<span class="clear"></span></div>
</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
