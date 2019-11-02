<?php
$this->load->view('admin/templates/header.php');

if (isset($details))
{ ?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Features Type</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
						echo form_open_multipart('admin/listings/insert_attribute', $attributes);
						if ($details->row()->name == 'accommodates' || $details->row()->name == 'can_policy' || $details->row()->name == 'minimum_stay' || $details->row()->name == 'SPACE_SIZE' || $details->row()->name == 'No_of_beds' || $details->row()->name == 'car_parking' || $details->row()->name == 'No_of_bathrooms') 
						{
							$disabled = 'Yes';
						}
						else
						{
							$disabled = 'No';
						}
						
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Label Name <span class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											$namedisbl = "";
											if ($disabled == 'Yes')
											{
												$namedisbl = readonly;
											}
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'attribute_name',
									            'id'	    => 'attribute_name',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the Lable name',
												'value'	    => $details->row()->name,
												$namedisbl	=> $namedisbl
									        ]);
										?>
									</div>
								</div>
							</li>
							
							<?php

								echo form_input([
									'type'      => 'hidden',      
									'name' 	    => 'id',
									'value'	    => $this->uri->segment(4, 0)
								]);

							?>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Type <span class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php

											$typdsbl = ""; 
											$typoptn = "";
											$typtxt = "";

											if ($disabled == 'Yes')
											{
												$typdsbl = readonly;
											}

											if($details->row()->type == 'option')
											{
												$typoptn = checked;
											}
											else if($details->row()->type == 'text')
											{
												$typtxt = checked;
											}

											echo form_input([
												'type'      => 'radio',      
												'name' 	    => 'type',
												'value'	    => 'option',
												$typdsbl	=> $typdsbl,
												$typoptn	=> $typoptn
											]);
											echo "Option";
												if($details->row()->name != 'accommodates' && $details->row()->name != 'minimum_stay'){
											echo form_input([
												'type'      => 'radio',      
												'name' 	    => 'type',
												'value'	    => 'text',
												$typdsbl	=> $typdsbl,
												$typtxt		=> $typtxt
											]);
											echo "Text";
												}
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('label <span class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'text',      
												'name' 	    => 'label_name',
												'id' 	    => 'label_name',
												'value'	    => $details->row()->labelname,
												'tabindex'	=> '1',
												'class'		=> 'required large tipTop',
												'title'		=> 'Please enter the label'
											]);
										?>
									</div>
								</div>
							</li>
<?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('label ('.$data->name.') <span class="req">*</span>','attribute_name_ar', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input(array(
												'type'      => 'text',      
												'name' 	    => 'labelname_'.$data->lang_code,
												'id' 	    => 'labelname_'.$data->lang_code,
												'value'	    => $details->row()->{'labelname_'.$data->lang_code},
												'tabindex'	=> '1',
												'class'		=> 'required large tipTop',
												'title'		=> 'Please enter the label'
											));
										?>
									</div>
								</div>
							</li>
						<?php }} ?>
						<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Status <span	class="req">*</span>','admin_name', $commonclass);	
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="11" name="status" checked="checked"
												   id="active_inactive_active" class="active_inactive" <?php if($disabled =='Yes'){echo 'disabled'; }else{ }?> />
										</div>
									</div>
								</div>
							</li>
							<li>

								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue " tabindex="9">
											<span>Update</span></button>
										<a href='<?php echo base_url() . 'admin/listings/attribute_values'; ?>'>
											<button type="button" class="btn_small btn_blue " tabindex="9">
												<span>Back</span></button>
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
	</div>
<?php 
    } 
	else 
	{ ?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Features Type</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
						echo form_open_multipart('admin/listings/insert_attribute', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Label Name <span class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											$namedisbl = "";
											if ($disabled == 'Yes')
											{
												$namedisbl = Disabled;
											}
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'attribute_name',
									            'id'	    => 'attribute_name',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the features name',
												'value'	    => '',
												$namedisbl	=> $namedisbl
									        ]);
										?>
										<span id="attribute_name_valid"   style="color:#f00;display:none;">Only Characters are allowed!</span>
									</div>
								</div>
							</li>
							<?php

								echo form_input([
									'type'      => 'hidden',      
									'name' 	    => 'id',
									'value'	    => ''
								]);

							?>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Type <span	class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'radio',      
												'name' 	    => 'type',
												'value'	    => 'option',
												'checked'	=> 'checked'
											]);
											echo "Option";

											echo form_input([
												'type'      => 'radio',      
												'name' 	    => 'type',
												'value'	    => 'text'
											]);
											echo "Text";
										?>										
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('label <span	class="req">*</span>','attribute_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'text',      
												'name' 	    => 'label_name',
												'id' 	    => 'label_name',
												'tabindex'	=> '1',
												'class'		=> 'required large tipTop',
												'title'		=> 'Please enter the feature label'
											]);
										?>
										<span id="label_name_valid" style="color:#f00;display:none;">Only Characters are allowed!
										</span>
									</div>
								</div>
							</li>

							<?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('label ('.$data->name.') <span class="req">*</span>','attribute_name_ar', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input(array(
												'type'      => 'text',      
												'name' 	    => 'labelname_'.$data->lang_code,
												'id' 	    => 'labelname_'.$data->lang_code,
												
												'tabindex'	=> '1',
												'class'		=> 'required large tipTop',
												'title'		=> 'Please enter the label'
											));
										?>
									</div>
								</div>
							</li>
						<?php }} ?>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Status <span	class="req">*</span>','admin_name', $commonclass);	
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="11" name="status" checked="checked"
												   id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
												echo form_input([
													'type'      => 'submit',      
													'value' 	=> 'Submit',
													'tabindex'	=> '9',
													'class'		=> 'btn_small btn_blue'
												]);
										?>
									</div>
								</div>
							</li>
						</ul>
						<?php echo form_close(); ?>
					</div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>
<span class="clear"></span>

</div>
<script>
	$(".active_inactive").on("click", function (e) {
		var checkbox = $(this);
		if (checkbox.is(":checked") {
			e.preventDefault();
			return false;
		}
	});
</script>
<!-- script to validate form inputs -->
<script type="text/javascript">
	$('#addattribute_form').validate();
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
