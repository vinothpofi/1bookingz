<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6><?php echo $heading; ?> </h6>
				</div>
				<div class="widget_content">
					<?php
					$experience = array('class' => 'form_container left_label', 'id' => 'editexperience_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/experience/EditExperienceType', $experience)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Experience Title<span class="req">*</span>','experience_title', $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => 'experience_title',
									            'id'	   => 'experience_title',
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the Experience Title',
												'required' => 'required',
												
												'value'	   => $experience_details->row()->experience_title
									    ]);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("experience_title","") as $dynlang) {

									$commonclass = array('class' => 'field_title');

									echo form_label('Experience Title ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the Experience Title in '.$dynlang[0],
												'required' => 'required',
												
												'value'	   => $experience_details->row()->{$dynlang[1]}
									    ]);
									?>
								</div>
							<?php } ?>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Description<span class="req">*</span>','experience_description', $commonclass);	
								?>
								<div class="form_input">
									<?php

										$descattr = array(
												'type'     => 'textarea',      
									            'name' 	   => 'experience_description',
									            'id'	   => 'experience_description',
									            'class'    => 'required large tipTop',
									            'rows' 	   =>  10,
									            'title'    => 'Please enter the Experience 	
									            			   Description',
												'required' => 'required',
												'value'	   => $experience_details->row()->experience_description
									    );

									    echo form_textarea($descattr);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("experience_description","") as $dynlang) {

									echo form_label('Description ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										$descattr_ar = array(
												'type'     => 'textarea',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'rows' 	   =>  10,
									            'title'    => 'Please enter the Experience 	
									            			   Description',
												'required' => 'required',
												'value'	   => $experience_details->row()->{$dynlang[1]}
									    );

									    echo form_textarea($descattr_ar);
									?>
								</div>
							<?php } ?>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
												'type'     => 'hidden',      
									            'value'    => $experience_details->row()->id,
									            'name'     => 'experience_id'
									    ]);

									    echo form_input([
												'type'     => 'submit',      
									            'class'    => 'btn_small btn_blue',
									            'tabindex' => '4',
									            'value'    => 'Update'
									    ]);
									?>
									<a href="<?php echo 'admin/experience/experienceTypeList'; ?>" class="btn_small btn_blue"><span>Cancel</span></a>
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
<!-- script to validate form inputs -->
<script>
	$('#editexperience_form').validate();
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>

