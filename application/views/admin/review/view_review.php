<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Review</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="title">Rental Name</label>
									<div class="form_input">
										<?php echo ucfirst($review_details->row()->product_title); ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<label class="field_title" for="title">Review For</label>
									<div class="form_input">
										<?php if($review_details->row()->review_type == '0'){echo "Rental";}else{echo "Host";} ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Review Comments','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->review; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Review Rating','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->total_review; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Full Name','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->user_name; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Email Address','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->email; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Status','description', $commonclass);	
									?>
									<div class="form_input">
										<?php echo $review_details->row()->status; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/review/display_review_list" class="tipLeft" title="Go to review list"><span class="badge_style b_done">Back</span>
										</a>
									</div>
								</div>
							</li>
						</ul>
						<?php echo form_close(); ?>
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
