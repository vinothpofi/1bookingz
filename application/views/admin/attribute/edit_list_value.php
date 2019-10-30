<?php
$this->load->view('admin/templates/header.php');
?>
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
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Amenities Value</h6>
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

										$listattr = array('class' => 'chzn-select required', 'tabindex' => '1', 'style' => 'width: 375px; display: none;', 'data-placeholder' => 'Select List');

										$listtype = array();
										$selected =$list_value_details->row()->list_id;


										foreach ($list_details->result() as $row)
										{
											if ($row->attribute_name != 'price') 
											{
												$listtype[$row->id] = $row->attribute_name;
											}
										}

										echo form_dropdown('list_name',$listtype, $selected, $listattr);



									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Amenities Value <span class="req">*</span>',
											'list_value', $commonclass);	
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
												'title'		  => 'Please enter the amenities value'
									        ]);	
									?>
									<span id="list_value_valid"  style="color:#f00;display:none;"> Only Characters are allowed!
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
												'required' => 'required',
												 'value'   	  =>  $list_value_details->row()->{$dynlang[1]},
									    ]);
									?>
								</div>
							<?php } ?>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Amenities Icon<span class="req"></span>','image', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'           => 'text',      
									            'class' 	     => 'form-control icp icp-auto demo tipTop required large',
									            'placeholder'    => 'Select icons',
												'data-placement' => 'bottomRight',
												'name'			 => 'icons',
												'value'			 => $list_value_details->row()->image
									    ]);
									?>
                                    <span class="input-group-addon"></span>
                                </div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
												'type'        => 'submit',      
									            'class' 	  => 'btn_small btn_blue',
									            'tabindex'    => '2',
												'value'	 	  => 'Submit'
									    ]);
									?>
									<a href='<?php echo base_url() . 'admin/attribute/display_list_values'; ?>'>
										<button type="button" class="btn_small btn_blue " tabindex="9"><span>Back</span>
										</button>
									</a>
								</div>
							</div>
						</li>
					</ul>
					<?php
						echo form_input([
							'type'        => 'hidden',      
							'name' 	  	  => 'lvID',
							'value'	 	  => $list_value_details->row()->id
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

<!-- function for validating form inputs -->
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

