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

										foreach ($listspace_details->result() as $row)
										{
											if ($row->attribute_name != '') 
											{
												$listtype[$row->id] = $row->attribute_name;
											}
										}

										echo form_dropdown('list_name',$listtype, '', $listattr);
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
									            'id'          => 'list_value',
												'tabindex'	  => '1',
												'maxlength'	 => '40',
												'class'		  => 'required tipTop large',
												'title'		  => 'Please enter the rental type value'
									        ]);	
									?>
									<span id="list_value_valid"	style="color:#f00;display:none;"> Only Characters are allowed!
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
									            'id'          => 'list_description',
												'tabindex'	  => '1',
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
									echo form_label('List Value ('.$data->name.') <span class="req">*</span>','list_value', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'list_value_'.$data->lang_code,
									            'id'          => 'list_value_'.$data->lang_code,
												'tabindex'	  => '1',
												'maxlength'	 => '40',
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
												'title'		  => 'Please select image',
												'onchange'	  => 'Upload(this.id);'
									        ]);	

									        $imglbl = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;','class' => 'error','generated' => 'true');

											echo form_label('Height and Width must be below 35PX X 40PX.','',$imglbl);

											$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;','class' => 'error','generated' => 'true');

											echo form_label('Please select a valid Image file','',$imglbl2);

									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'submit',      
									            'value' 	  => 'Submit',
												'tabindex'	  => '2',
												'class'		  => 'btn_small btn_blue'
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
	<span class="clear"></span>
</div>
</div>
<!-- function to validate form inputs -->
<script>
	$('#addlistvalue_form').validate();
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>

<!-- function to validate image and upload -->
<script type="text/javascript">
	function Upload(files) 
	{
		var fileUpload = document.getElementById("image");

		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
		if (regex.test(fileUpload.value.toLowerCase())) 
		{
			if (typeof (fileUpload.files) != "undefined") 
			{
				var reader = new FileReader();
				reader.readAsDataURL(fileUpload.files[0]);
				reader.onload = function (e) 
				{
					var image = new Image();
					image.src = e.target.result;

					image.onload = function ()
					{
						var height = this.height;
						var width = this.width;
						if (height > 35 || width > 40)
						{
							document.getElementById("image_valid_error").style.display = "inline";
							$("#image_valid_error").fadeOut(9000);
							$("#image").val('');
							$("#image").focus();
							$(".filename").text('No file selected');
							return false;
						}
						return true;
					};
				}
			} 
			else
			{
				alert("This browser does not support HTML5.");
				$("#image").val('');
				return false;
			}
		} 
		else
		{			
			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(9000);
			$("#image").val('');
			$("#image").focus();
			return false;
		}
	}
</script>
