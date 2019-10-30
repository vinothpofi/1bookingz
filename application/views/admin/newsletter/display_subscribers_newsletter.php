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
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading; ?></h6>						
					</div>
					<div class="widget_content">
						<table class="display" id="subscribers_newsletter_tbl">
							<thead>
							<tr>
								<th class="tip_top" title="Click to sort">Template Name</th>
								<th class="center" title="Click to sort">Email Subject</th>
								<th>Action</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($subscribersList_template->num_rows() > 0)
							{
								foreach ($subscribersList_template->result() as $row)
								{
									?>
									<tr>
										<td class="center  tr_select">
											<?php echo $row->news_title; ?>
										</td>
										<td class="center tr_select ">
											<?php echo $row->news_subject; ?>
										</td>
										<td class="center">
											<?php if ($allPrev == '1' || in_array('2', $Newsletter)) { ?>
												<span>
													<a class="action-icons c-edit"
														 href="admin/newsletter/edit_newsletter_form/<?php echo $row->id; ?>"
														 title="Edit">Edit
													</a>
												</span>
											<?php } ?>
											<span>
												<a class="action-icons c-suspend"
													 href="admin/newsletter/view_subscribers_newsletter/<?php echo $row->id; ?>"
													 title="View">View
												</a>
											</span>
											<?php 
											if ($allPrev == '1' || in_array('3', $Newsletter)) 
											{
												$EmailtempId = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11');
												if (!in_array($row->id, $EmailtempId)) 
												{
													?>
													<span>
														<a class="action-icons c-delete"
															 href="javascript:confirm_delete('admin/newsletter/delete_newsletter/<?php echo $row->id; ?>')"
															 title="Delete">Delete
														</a>
													</span>
												<?php 
												}
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
								<th>Template Name</th>
								<th class="center">Email Subject</th>
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
