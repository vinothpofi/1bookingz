<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Amenities</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'editattribute_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/attribute/EditAttribute', $attributes)
					?>
					<ul>
						<?php 
						$langCount = $number_of_lang->num_rows();
						$langResult = $number_of_lang->result();

						foreach ($valAre as $key => $val) 
						{
							$attrName[] = $key;
						}
						?>
						
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Amenities Name <span class="req">*</span>','attribute_name', $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'attribute_name',
									            'id'	    => 'attribute_name',
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the Amenities name',
												'value'	    => $attribute_details->row()->attribute_name
									    ]);
									?>
									<span id="attribute_name_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!
									</span>
								</div>
							</div>
						</li>
                         <li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("attribute_name","") as $dynlang) {

									$commonclass = array('class' => 'attribute_name');

									echo form_label('Amenities Name in ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the Amenities Name in '.$dynlang[0],
												'required' => 'required',
												'value'	    => $attribute_details->row()->{$dynlang[1]}
									    ]);
									?>
									<span id="<?php echo $dynlang[1]; ?>_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!
									</span>
								</div>
							<?php } ?>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Amenities Description <span class="req">*</span>','attribute_title', $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'attribute_title',
									            'id'	    => 'attribute_title',
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the Amenities Title',
												'value'	    => $attribute_details->row()->attribute_title
									    ]);
									?>
									<span id="attribute_title_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!
									</span>
								</div>
							</div>
						</li>
                        <li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("attribute_title","") as $dynlang) {

									$commonclass = array('class' => 'attribute_title');

									echo form_label('Amenities Description in ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the Amenities Title in '.$dynlang[0],
												'required' => 'required',
												'value'	    => $attribute_details->row()->{$dynlang[1]}
									    ]);
									?>
									<span id="<?php echo $dynlang[1]; ?>_valid_error" style="color:#f00;display:none;">Only Alphabets are allowed!
									</span>
								</div>
							<?php } ?>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'hidden',      
									            'name' 	    => 'attribute_id',
												'value'	    => $attribute_details->row()->id
									    ]);

									    echo form_input([
												'type'      => 'submit',      
									            'tabindex' 	=> '4',
												'class'	    => 'btn_small btn_blue',
												'value'		=> 'Update'
									    ]);
									?>
									<a href='<?php echo base_url() . 'admin/attribute/display_attribute_list'; ?>'>
										<button type="button" class="btn_small btn_blue " tabindex="9"><span>Back</span>
										</button>
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

<!-- Calling function for form validating -->
<script>
	$('#editattribute_form').validate();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>

