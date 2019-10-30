<?php
$this->load->view('admin/templates/header.php');
?>
<style>
	.iconpicker-popover{z-index: 9;}
	.iconpicker .iconpicker-item.iconpicker-selected{box-shadow: 0 0 0 1px #ddd !important; color: inherit !important; background-color: #eee;}
</style>


<!--files for icons upload-->
<link href="css/fontawesome-iconpicker.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="js/fontawesome-iconpicker.js"></script>
<link href="css/fontawesome-iconpicker.min.css" rel="stylesheet" type="text/css" media="screen">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen">
<script src="js/fontawesome-iconpicker.js"></script>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap" style="overflow: visible;">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add Amenities Value</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addlistvalue_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/attribute/insertEditListValue', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Select Amenities <span class="req">*</span>','list_name', $commonclass);	
								?>
								<div class="form_input">
									<?php

										$listattr = array('class' => 'chzn-select required', 'tabindex' => '1', 'style' => 'width: 375px; display: none;', 'data-placeholder' => 'Select Amenities');

										$listtype = array();

										foreach ($list_details->result() as $row)
										{
											if ($row->attribute_name != 'price') 
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
									echo form_label('Amenities Value <span class="req">*</span>','list_value', $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'list_value',
									            'id'	    => 'list_value',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the amenities value'
									    ]);
									?>
									<span id="list_value_valid" style="color:#f00;display:none;">	Only Characters are allowed!
									</span>
								</div>
							</div>
						</li>
                        <li>
							
<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("list_value","") as $dynlang) {

									$commonclass = array('class' => 'footer_content');

									echo form_label('Amenities Value in ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the Amenities Value in '.$dynlang[0],
												'required' => 'required'
									    ]);
									?>
								</div>
							<?php } ?>
							</div>

						</li>
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Amenities Icon ','image', $commonclass);	
								?>
							<div class="form_input">
								<?php
									echo form_input([
												'type'           => 'text',      
									            'class' 	     => 'form-control icp icp-auto demo tipTop required large',
									            'placeholder'    => 'Select icons',
												'data-placement' => 'bottomRight',
												'name'			 => 'icons'
									    ]);	
								?>	
								<span class="input-group-addon"></span>							
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'submit', 
									            'class'     => 'btn_small btn_blue',
									            'tabindex'	=> '2',
									            'value'  	=> 'Submit'
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

<!-- function for fontawesome-iconpicker -->
<script>
$('.demo').iconpicker();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>


