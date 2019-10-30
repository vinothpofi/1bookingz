<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Banner Details</h6>						
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin', $attributes)
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Banner Image','',$commonclass);	
										?>
										<div class="form_input">
											<?php if ($slider_details->row()->image == '')
											{ ?>
												<img src="<?php echo base_url(); ?>images/users/user-thumb1.png" width="100px"/>
											<?php 
											} 
											else
											{ ?>
												<img
													src="<?php echo base_url(); ?>images/slider/<?php echo $slider_details->row()->image; ?>"
													width="100px"/>
											<?php } ?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Banner Name','',$commonclass);	
										?>
										<div class="form_input">
											<?php echo $slider_details->row()->slider_name; ?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Banner Title','',$commonclass);	
										?>
										<div class="form_input">
											<?php echo $slider_details->row()->slider_title; ?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Banner Description','slider_desc',$commonclass);	
										?>
										<div class="form_input">
											<?php echo $slider_details->row()->slider_desc; ?>
										</div>
									</div>
								</li>

								<!-- <li>
									<div class="form_grid_12">
										<?php
											echo form_label('Banner Link','slider_desc',$commonclass);	
										?>
										<div class="form_input">
											<?php echo '<a href="'.$slider_details->row()->slider_link.'" target="_blank">'.$slider_details->row()->slider_link.'</a>'; ?>
										</div>
									</div>
								</li> -->

								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<a href="admin/slider/display_slider_list" class="tipLeft" title="Go to slider list"><span class="badge_style b_done">Back</span>
											</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<span class="clear"></span>
		</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
