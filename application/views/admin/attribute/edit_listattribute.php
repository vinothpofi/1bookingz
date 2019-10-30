<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit List</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data');
					echo form_open_multipart('admin/listattribute/EditlistAttribute', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('List Name <span class="req">*</span>','attribute_name', $commonclass);	
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
									            'title'  	=> 'Please enter the list name',
												'value'	    => $attribute_details->row()->attribute_name
									    ]);

									?>
									<span id="attribute_name_valid" style="color:#f00;display:none;"> Only Characters allowed!
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
									$commonclass = array('class' => 'field_title');

									echo form_label('List Name ('.$data->name.') <span class="req">*</span>',$data->name, $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'attribute_name_'.$data->lang_code,
									            'id'	    => 'attribute_name_'.$data->lang_code,
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the list name',
												'value'	    => $attribute_details->row()->{'attribute_name_'.$data->lang_code}
									    ]);

									?>
									<span id="attribute_name<?php echo $data->lang_code; ?>_valid" style="color:#f00;display:none;"> Only Characters allowed!
									</span>
								</div>
							</div>
						</li>

                                    <?php }} ?>



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
									            'class' 	=> 'btn_small btn_blue',
												'value'	    => 'Update',
												'tabindex'	=> '4'
									    ]);

									?>
									<a href='<?php echo base_url() . 'admin/listattribute/display_attribute_listspace'; ?>'>
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
<!-- script to validate form inputs -->
<script type="text/javascript">
	$('#edituser_form').validate();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
