<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/multilanguage/change_multi_language_details', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading; ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php 
								if ($allPrev == '1' || in_array('1', $Language))
								{ ?>
								<div class="btn_30_light" style="height: 29px; text-align:left;">
									<a href="admin/multilanguage/add_new_lg" class="tipTop"
									   title="Click here to add new language"><span class="icon add_co"></span><span class="btn_link">Add New</span>
									</a>
								</div>
							<?php 
								} 

								if ($allPrev == '1' || in_array('2', $Language))
								{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to active records"><span class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to inactive records"><span
											class="icon delete_co"></span><span class="btn_link">Inactive</span>
									</a>
								</div>
								<?php
							}

							if ($allPrev == '1' || in_array('3', $Language))
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
								<th class="tip_top" title="Click to sort">Language Name</th>
								<th class="tip_top" title="Click to sort">language Code</th>
								<th class="tip_top" title="Click to sort">language Order</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($language_list->num_rows() > 0)
							{
								foreach ($language_list->result() as $row)
								{
									?>
									<tr>
										<td class="center tr_select ">
											<?php if ($row->lang_code != 'en') 
											{ 
												echo form_input([
													'type'     => 'checkbox',
											        'value'    => $row->id,
											        'name' 	   => 'checkbox_id[]',
											        'class'    => 'check'
											        ]);	
											} ?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->name;

											if ($row->default_lang == 'Default')
											{
												?>
												<img src="images/checked.png" class="tip_top"
													 original-title="Default Site Language">
												<?php
											}
											?>
										</td>
										<td class="center  tr_select">
											<?php echo $row->lang_code; ?>
										</td>
										<td class="center">
											<?php
												echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'language_order',
									            'onchange'	=> "UpdateLangOrder(this,".$row->id.",'language_order')",
									            'maxlength' => '2',
									            'onkeypress'=> 'return check_for_num(event)',
												'value'	    => $row->language_order
									        	]);
											?>
											<br>
											<span id="imgmsg_<?php echo $row->id; ?>" style="color:green"></span>
										</td>

										<td class="center tr_select">
											<?php
											if ($allPrev == '1' || in_array('2', $Language))
											{
												if ($row->default_lang == 'Default')
											{ ?>
												<a title="Default" class="tip_top"><span class="badge_style b_done">Default</span>
													</a>
												<?php
											}
											else{
												$mode = ($row->status == 'Active') ? '0' : '1';
												if ($mode == '0')
												{
													?>
													<a title="Click to unpublish" class="tip_top"
													   href="javascript:confirm_status('admin/multilanguage/change_language_status/<?php echo $row->status; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->status; ?></span>
													</a>
													<?php
												} 
												else
												{
													?>
													<a title="Click to publish" class="tip_top"
													   href="javascript:confirm_status('admin/multilanguage/change_language_status/<?php echo $row->status; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->status; ?></span>
													</a>
													<?php
												}
											}
											} 
											else
											{
												?>
												<span class="badge_style b_done"><?php echo $row->status; ?>	
												</span>
											<?php 
											} ?>
										</td>

										<td class="center">
											<?php 
											if ($allPrev == '1' || in_array('2', $Language)) 
											{ ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/multilanguage/edit_language/<?php echo $row->lang_code; ?>/1"
														 title="Edit">Edit
													</a>
												</span>
											<?php 
											} 

											if ($allPrev == '1' || in_array('3', $Language))
											{
												$EmailtempId = array('1', '2', '3', '4', '5');

												if ($row->lang_code != 'en')
												{ ?>
													<span>
														<a class="action-icons c-delete"
															 href="javascript:confirm_delete('admin/multilanguage/delete_language/<?php echo $row->id; ?>')"
															 title="Delete">Delete
														</a>
													</span>
												<?php 
												}
											} 

											if ($row->status == 'Active' && $row->default_lang != 'Default') 
											{ ?>
												<span>
													<a class="action-icons c-approve"
														 href="admin/multilanguage/default_language/<?php echo $row->id; ?>" title="Make as Default">Default
													</a>
												</span>
											<?php } ?>
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
								<th>Language Name</th>
								<th>language Code</th>
								<th>language Order</th>
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
	
	<script>
		function check_for_num(evt) 
		{
			evt = (evt) ? evt : window.event;
			var charCode = (evt.which) ? evt.which : evt.keyCode;
			if (charCode > 31 && (charCode < 48 || charCode > 57))
			{
				return false;
			}
			return true;
		}
	</script>
	<!-- script to update language order -->
	<script>
		function UpdateLangOrder(evt, catID, chk)
		{
			var title = evt.value;
			$.ajax({
				type: 'POST',
				url: baseURL + 'admin/multilanguage/UpdateLangOrder',
				data: {'catID': catID, 'title': title, 'chk': chk},
				success: function (data)
				{
					data = data.trim();
					if (data == 'succ')
					{
						$('#imgmsg_' + catID).html('Done..!');
						$('#imgmsg_' + catID).fadeIn('slow', function ()
						{
							$(this).delay(1000).fadeOut('slow', function ()
							{
								$('#imgmsg_' + catID).html('');
							});
						});
					} 
					else
					{
						$('#imgmsg_' + catID).html('Try Again..!');
						$('#imgmsg_' + catID).fadeIn('slow', function ()
						{
							$(this).delay(1000).fadeOut('slow', function ()
							{
								$('#imgmsg_' + catID).html('');
							});
						});
					}
				}
			});
		}
	</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
