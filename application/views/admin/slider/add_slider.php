<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New Banner</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addslider_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/slider/insertEditSlider', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Banner Name <span class="req">*</span>','user_name', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'slider_name',
									            'id'	    => 'slider_name',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the banner name'
									        ]);
									?>
									<span id="slider_name_valid" style="color:#f00;display:none;">Only Alphabets Allowed
									</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("slider_name","") as $dynlang) {

									echo form_label('Banner Name ('.$dynlang[0].') <span class="req">*</span>',$dynlang[1], $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => $dynlang[1],
									            'id'	    => $dynlang[1],
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the banner name in '.$dynlang[0]
									        ]);
									?>
									<span id="slider_name_valid" style="color:#f00;display:none;">Only Alphabets Allowed
									</span>
								</div>
							<?php } ?>
							</div>
						</li>
						

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Banner Title <span class="req">*</span>','full_name', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'slider_title',
									            'id'	    => 'slider_title',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '2',
									            'title'  	=> 'Please enter the banner title'
									        ]);
									?>
									<span id="slider_title_valid" style="color:#f00;display:none;">Special Characters Not Allowed
									</span>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("slider_title","") as $dynlang) {

									echo form_label('Banner Title ('.$dynlang[0].')<span class="req">*</span>',$dynlang[1], $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => $dynlang[1],
									            'id'	    => $dynlang[1],
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '2',
									            'title'  	=> 'Please enter the banner title in'.$dynlang[0]
									        ]);
									?>
									<span id="slider_title_valid" style="color:#f00;display:none;">Special Characters Not Allowed
									</span>
								</div>
							<?php } ?>
							</div>
						</li>

						
						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Banner Description ','slider_desc', $commonclass);	
								?>
								<div class="form_input">
									<?php											
									        $descattr = array(
											    'name' 	      => 'slider_desc',
									            'id'   	 	  => 'slider_desc',
									            'tabindex'    => '5',
												'rows'	      => 3,
												'class'		  => 'tipTop large',
												'title'		  => 'Please enter the banner link'
											);
											echo form_textarea($descattr);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("slider_desc","") as $dynlang) {
									echo form_label('Banner Description ('.$dynlang[0].') ',$dynlang[1], $commonclass);	
								?>
								<div class="form_input">
									<?php											
									        $descattr = array(
											    'name' 	      => $dynlang[1],
									            'id'   	 	  => $dynlang[1],
									            'tabindex'    => '5',
												'rows'	      => 3,
												'class'		  => 'tipTop large',
												'title'		  => 'Please enter the banner link in '.$dynlang[0]
											);
											echo form_textarea($descattr);
									?>
								</div>
							<?php } ?>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
									echo form_label('Banner Image <span class="req">*</span>','image', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'file',      
									            'name' 	    => 'image',
									            'id'	    => 'image',
									            'onchange' 	=> 'Upload(this.id);',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '7',
									            'title'  	=> 'Please select banner image'
									        ]);
									?>
									<br>
									<span style="color:red;">Upload the Image Size 1349 X 484 or Above</span>
								</div>
								<?php
									$imgerr = array('id' => 'image_valid_error','style' => 'font-size:12px;display:none', 'class' => 'error');

									echo form_label('This field is required','image', $imgerr);

										
								?>
							</div>
						</li>

						<!-- <li>
							<div class="form_grid_12">
								<?php
									echo form_label('Status<span class="req">*</span>','admin_name', $commonclass);	
								?>
								<div class="form_input">
									<div class="active_inactive">
										<?php
											echo form_input([
												'type'     => 'checkbox',
										        'id'       => 'active_inactive_active',
										        'name' 	   => 'status',
										        'class'    => 'active_inactive',
										        'checked'  => 'checked'
										        ]);
										?>
									</div>
								</div>
							</div>
						</li>
 -->
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
											'type'     => 'submit',
									        'value'    => 'Submit',
									        'tabindex' => '9',
									        'class'    => 'btn_small btn_blue'
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

<script>
	$('#addslider_form').validate();
</script>


<script type="text/javascript">
	function Upload(files)
	{
		var fileUpload = document.getElementById("image");

		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
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

						if (height < 484 || width < 1349)
						{
							$("#image_valid_error").html('Height and Width must be above 1349PX X 484PX.');
						//	document.getElementById("image_valid_error").style.display = "inline";
							//$("#image_valid_error").fadeOut(15000);
							$("#image").val('');
							$("#image").focus();
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
			$("#image_valid_error").html('Please select a valid Image file');		
			//document.getElementById("image_type_error").style.display = "inline";
			//$("#image_valid_error").fadeOut(15000);
			$("#image").val('');
			$("#image").focus();
			return false;
		}
	}
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>

