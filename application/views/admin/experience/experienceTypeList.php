<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/experience/change_experience_type_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading; ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php if ($allPrev == '1' || in_array('2', $Experience)) 
							{ ?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to active records"><span class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');"
									   class="tipTop"
									   title="Select any checkbox and click here to inactive records"><span	class="icon delete_co"></span><span class="btn_link">Inactive</span>
									</a>
								</div>
								<?php
							}
							if ($allPrev == '1' || in_array('3', $Experience)) {
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="confirm('Are you sure to delete? * All Experiences under selected Experience Types will be deleted');return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="widget_content responsive">
						<table class="display" id="action_tbl_view">
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
								<th class="tip_top" title="Click to sort">Experience Type</th>
								<th class="tip_top" title="Click to sort">Created Date</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($experienceList->num_rows() > 0) 
							{
								foreach ($experienceList->result() as $row) 
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
										<td class="center"><?php echo $row->experience_title; ?>
										</td>
										<td class="center"><?php echo $row->dateAdded; ?></td>
										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $Experience)) 
											{
												$mode = ($row->status == 'Active') ? '0' : '1';
												if ($mode == '0') 
												{
													?>
													<a title="Click to inactive" class="tip_top"
													   href="javascript:confirm_status('admin/experience/change_experienceType_status/<?php echo $mode; ?>/<?php echo $row->id; ?>');"><span class="badge_style b_done"><?php echo $row->status; ?></span>
													</a>
													<?php
												} 
												else
												{
													?>
													<a title="Click to active" class="tip_top"
													   href="javascript:confirm_status('admin/experience/change_experienceType_status/<?php echo $mode; ?>/<?php echo $row->id; ?>')"><span class="badge_style"><?php echo $row->status; ?></span>
													</a>
													<?php
												}
											} 
											else
											{
												?>
												<span class="badge_style b_done"><?php echo $row->status; ?></span>
											<?php 
											} ?>
										</td>
										<td class="center">
											<?php if ($allPrev == '1' || in_array('2', $Experience)) 
											{ ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/experience/edit_experienceType_form/<?php echo $row->id; ?>"
														 title="Edit">Edit
													</a>
												</span>
											<?php 
											} ?>
											<span>
												<a class="action-icons c-suspend"
													 href="admin/experience/view_experienceType/<?php echo $row->id; ?>"
													 title="View">View
												</a>
											</span>
											<?php if ($allPrev == '1' || in_array('3', $Experience)) 
											{ ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:confirm('Are you sure to delete? * All Experiences under this Experiece Type will be deleted');confirm_delete('admin/experience/delete_experienceType/<?php echo $row->id; ?>')"
														 title="Delete">Delete
													</a>
												</span>
											<?php 
											} 

											if ($allPrev == '1' || in_array('2', $Experience)) 
											{ 

											 	if ($row->featured == '0') 
											 	{ ?>
													<span id="feature_<?php echo $row->id; ?>"><a class="c-unfeatured" href="javascript:ChangeFeaturedExperienceType('1','<?php echo $row->id; ?>')" title="Click To Featured">Un-Featured</a>
													</span>
												<?php 
												} 
												else 
												{ ?>
													<span id="feature_<?php echo $row->id; ?>"><a class="c-featured" href="javascript:ChangeFeaturedExperienceType('0','<?php echo $row->id; ?>')" title="Click To Un-Featured">Featured</a>
													</span>
												<?php 
												} 
												} 
												?>
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
								<th>Experience Type</th>
								<th>Created Date</th>
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

	<script type="text/javascript">
		/*  featured status change of experience */
		function ChangeFeaturedExperienceType(e, t) 
		{
			$("#feature_" + t).html('<a class="c-loader" href="javascript:void(0);" title="Loading" >Loading</a>');
			var a = (e == '1') ? 'Featured' : 'Unfeatured',
				i = "feature_" + t,
				s = window.location.pathname,
				o = s.substring(s.lastIndexOf("/") + 1);
			$.ajax({
				type: "POST",
				url: BaseURL + "admin/experience/ChangeFeaturedExperienceType",
				data: {
					id: i,
					cpage: o,
					imgId: t,
					FtrId: e
				},
				dataType: "json",
				success: function (e) 
				{

					$("#feature_" + t).remove()
				}
			}), "Featured" == a ? $("#feature_" + t).html('<a class="c-featured" href="javascript:ChangeFeaturedExperienceType(0,' + t + ')" title="Click To Un-Featured" >Featured</a>').show() : $("#feature_" + t).html('<a class="c-unfeatured" href="javascript:ChangeFeaturedExperienceType(1,' + t + ')" title="Click To Featured" >Un-Featured</a>').show()
		}
	</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
