<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading; ?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Experience Title : ','experience_title', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $experience_details->row()->experience_title; ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Description : ','experience_description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $experience_details->row()->experience_description; ?>
									</div>
								</div>
							</li>


							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Status :','Status', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $experience_details->row()->status; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/experience/experienceTypeList" class="tipLeft"
										   title="Go to lists"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<span class="clear"></span>
		</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
