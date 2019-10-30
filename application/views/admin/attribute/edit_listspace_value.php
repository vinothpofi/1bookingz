<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add Rental Type Value</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addlistvalue_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/listattribute/insertEditListSpaceValue', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Select List <span class="req">*</span>','list_name', $commonclass);	
								?>
								<div class="form_input">
									<?php

										$listattr = array('id' => 'list_name', 'class' => 'chzn-select required', 'tabindex' => '1', 'style' => 'width: 375px; display: none;', 'data-placeholder' => 'Select List');

										$listtype = array();
										$listtype[''] = '---select---';

										foreach ($list_details->result() as $row)
										{
											if ($row->attribute_name!='') 
											{
												$listtype[$row->id] = $row->attribute_name;
											}
										}

										echo form_dropdown('list_name',$listtype, $list_value_details->row()->listspace_id, $listattr);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('List Value <span class="req">*</span>','list_value', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'list_value',
									            'value'   	  =>  $list_value_details->row()->list_value,
									            'id'          => 'list_value',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop large',
												'title'		  => 'Please enter the list space value'
									        ]);	
									?>
									<span id="list_value_valid" style="color:#f00;display:none;"> 	Only Characters are allowed!
									</span>
								</div>
							</div>
						</li>
						
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('List Description <span class="req">*</span>','list_description', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'list_description',
									            'value'   	  =>  $list_value_details->row()->list_description,
									            'id'          => 'list_description',
												'tabindex'	  => '2',
												'class'		  => 'required tipTop large',
												'title'		  => 'Please enter the rental type value description'
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
									echo form_label('List Value ('.$data->name.') <span class="req">*</span>','list_value_ar', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'list_value_'.$data->lang_code,
									            'id'          => 'list_value_'.$data->lang_code,
												'tabindex'	  => '1',
												 'value'   	  =>  $list_value_details->row()->{'list_value_'.$data->lang_code},
												'class'		  => 'required tipTop large',
												'title'		  => 'Please enter the rental type value'
									        ]);	
									?>
									<span id="list_value_ar_valid"	style="color:#f00;display:none;"> Only Characters are allowed!
									</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('List Description ('.$data->name.') <span class="req">*</span>','list_value_ar', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'list_description_'.$data->lang_code,
									            'id'          => 'list_description_'.$data->lang_code,
									             'value'   	  =>  $list_value_details->row()->{'list_description_'.$data->lang_code},
												'tabindex'	  => '1',
												'class'		  => 'required tipTop large',
												'title'		  => 'Please enter the rental type value description'
									        ]);	
									?>
									<span id="list_value_ar_valid"	style="color:#f00;display:none;"> Only Characters are allowed!
									</span>
								</div>
							</div>
						</li>
						

                                    <?php }} ?>
						<?php if ($list_value_details->row()->image != '') 
						{ ?>
							<li>
								<div class="form_grid_12 ">
									<?php
									echo form_label('List Icon <span class="req">*</span><span
											class="req"> Below 35*40 (H*W) </span>','image', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'file',      
									            'name' 	      => 'image',
									            'id'          => 'image',
												'tabindex'	  => '7',
												'class'		  => 'tipTop large',
												'title'		  => 'Please select image'
									        ]);	
										?>
									</div>
									<div class="form_input">
										<img src="<?php if ($list_value_details->row()->image == '') {
											echo base_url() . 'images/attribute/default-list-img.png';
										} else {
											echo base_url(); ?>images/attribute/<?php echo $list_value_details->row()->image;
										} ?>" width="100px"/>
									</div>
								</div>
							</li>
						<?php 
						} 
						else 
						{ ?>
							<li>
								<div class="form_grid_12 form_chsfile">
									<?php
									echo form_label('List Icon <span class="req">*</span><span
										class="req"> Below 35*40 (H*W) </span>','image', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'file',      
									            'name' 	      => 'image',
									            'id'          => 'image',
												'tabindex'	  => '7',
												'class'		  => 'tipTop large required',
												'title'		  => 'Please select image'
									        ]);	
										?>
									</div>
									<div class="form_input">
										<img src="<?php if ($list_value_details->row()->image == '') {
											echo base_url() . 'images/attribute/default-list-img.png';
										} else {
											echo base_url(); ?>images/attribute/<?php echo $list_value_details->row()->image;
										} ?>" width="100px"/>
									</div>
								</div>
							</li>
						<?php 
						} ?>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'submit', 
												'tabindex'	  => '2',
												'class'		  => 'btn_small btn_blue',
												'value'		  => 'Update'
									        ]);	
									?>
									<a href='<?php echo base_url() . 'admin//listattribute/display_listspace_values'; ?>'>
										<button type="button" class="btn_small btn_blue " tabindex="9">
										<span>Back</span>
										</button>
									</a>
								</div>
							</div>
						</li>
					</ul>
					<?php
						echo form_input([
							'type'        => 'hidden', 
							'name'	  	  => 'lvID',
							'value'		  => $list_value_details->row()->id
						]);	

						echo form_close(); 
					?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>

<script>
	$('#addlistvalue_form').validate();
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
