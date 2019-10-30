<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Prefooter</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'editslider_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/prefooter/insertEditprefooter', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('prefooter Title <span class="req">*</span>','footer_title', $commonclass);	
								?>
								<div class="form_input">
									<?php 
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'footer_title',
									            'id'	    => 'footer_title',
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the prefooter name',
												'value'	    => $prefooter_details->row()->footer_title
									    ]);
									?>
									<span id="footer_title_error" style="color:#f00;display:none;">Special Characters Not Allowed</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("footer_title","") as $dynlang) {										
										$commonclass = array('class' => 'field_title');

										echo form_label('prefooter Title ('.$dynlang[0].')<span class="req">*</span>',$dynlang[1], $commonclass);	
								?>
								<div class="form_input">
									<?php 
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => $dynlang[1],
									            'id'	    => $dynlang[1],
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the prefooter name',
												'value'	    => $prefooter_details->row()->{$dynlang[1]}
									    ]);
									?>
									<span id="footer_title_error" style="color:#f00;display:none;">Special Characters Not Allowed</span>
								</div>
							<?php } ?>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('prefooter Link','prefooter_link', $commonclass);	
								?>
								<div class="form_input">
									<?php 
										echo form_input([
												'type'      => 'url',      
									            'name' 	    => 'footer_link',
									            'id'	    => 'footer_link',
									            'required' 	=> 'required',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '2',
									            'title'  	=> 'Please enter the prefooter link',
												'value'	    => $prefooter_details->row()->footer_link
									    ]);
										
										$dmnlbl = array('class' => 'error');
										echo form_label('Example: http://www.domain.com','', $dmnlbl);
									?>
								</div>
							</div>
						</li>

						<li>							
							<div class="form_grid_12">
								<?php
										echo form_label('prefooter Description <span class="req">*</span>','prefooter_link', $commonclass);	
								?>
								<div class="form_input">
									<?php
											
									        $descattr = array(
											    'name' 	      => 'description',
											    'id'		  => 'prefooter_description',
									            'onkeyup'     => 'char_countPreFooter(this);',
									            'required'    => 'required',
									            'maxlength'	  => '250',
									            'rows'		  => 2,
												'class'		  => 'tipTop',
												'value'		  => $prefooter_details->row()->description
											);

											echo form_textarea($descattr);
									?>									
								</div>
								<?php
								$string = str_replace(' ', '', $prefooter_details->row()->description);
								$len = mb_strlen($string, 'utf8');
								$remaining = (250 - $len);
								?>
								<br>
								<span class="small_label we_do_sl" style="margin-left: 345px">
								<span
									id="prefooter_description_char_count"><?php echo $remaining; ?></span>characters remaining
								</span>
							</div>
						</li>
						<li>							
							<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("description","") as $dynlang) {	
										echo form_label('prefooter Description (Arabic) <span class="req">*</span>','prefooter_link', $commonclass);	
								?>
								<div class="form_input">
									<?php
											
									        $descattr = array(
											    'name' 	      => $dynlang[1],
											    'id'		  => $dynlang[1],
									            'onkeyup'     => 'char_countPreFooter(this);',
									            'required'    => 'required',
									            'maxlength'	  => '250',
									            'rows'		  => 2,
												'class'		  => 'tipTop',
												'value'		  => $prefooter_details->row()->{$dynlang[1]}
											);

											echo form_textarea($descattr);
									?>									
								</div>
								<?php
								$string = str_replace(' ', '', $prefooter_details->row()->description);
								$len = mb_strlen($string, 'utf8');
								$remaining = (250 - $len);
								?>
								<br>
								<span class="small_label we_do_sl" style="margin-left: 345px">
								<span
									id="prefooter_description_char_count"><?php echo $remaining; ?></span>characters remaining
								</span>
							<?php } ?>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('prefooter Icon  <br><br> <span class="req"> * Below 130*130 and JPG,PNG,JPEG  </span><br>','image', $commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'file',      
									            'name' 	      => 'image',
									            'onchange'    => 'Upload(this.id);',
									            'id'          => 'image',
												'tabindex'	  => '7',
												'class'		  => 'tipTop large',
												'title'		  => 'Please select prefooter image'
									        ]);
									?>
								</div>
								<div class="form_input">
									<img
										src="<?php echo base_url(); ?>images/prefooter/<?php echo $prefooter_details->row()->image; ?>"
										width="100px"/>
								</div>
								<?php
									$imglbl1 = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

									echo form_label('Height and Width must be below 130PX X 130PX.','', $imglbl1);

									$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

									echo form_label('Please select a valid Image file','', 
												$imglbl2);
								?>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Status <span class="req">*</span>','admin_name', $commonclass);	
								?>
								<div class="form_input">
									<div class="active_inactive">
										<input type="checkbox" name="status" <?php if ($prefooter_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
									</div>
								</div>
							</div>
							<?php
								echo form_input([
									'type'     => 'hidden',
									'name' 	   => 'prefooter_id',
									'value'    => $prefooter_details->row()->id
								]);
							?>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
									if($site_status_val == 1){
										echo form_input([
											'type'     => 'submit',
											'onclick'  => 'return checkUrl();',
											'class'    => 'btn_small btn_blue',
											'tabindex' => '4',
											'value'	   => 'Update'
										]);
									}elseif($site_status_val == 2){
									?>
									<button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Update</button>
									<?php } ?>
									<a href="<?php echo base_url() . "admin/prefooter/display_prefooter_list"; ?>">
										<button type="button" class="btn_small btn_blue" tabindex="4"><span>Back</span>
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

<script>
	function checkUrl() 
	{
		var str = $("#footer_link").val();
		if (str.indexOf('"') == -1)
		{
			return true;
		}
		else
		 {
			alert('Kindly check the URL!');
			return false;
		}
	}
</script>
<!-- script to upload image -->
<script type="text/javascript">
	function Upload(files)
	{
		var fileUpload = document.getElementById("image");
		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg)$");
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
						if (height > 130 || width > 130)
						{
							document.getElementById("image_valid_error").style.display = "inline";
							$("#image_valid_error").fadeOut(9000);
							$("#image").val('');
							$(".filename").text('No file selected');
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
			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(9000);
			$("#image").val('');
			$("#image").focus();
			return false;
		}
	}
</script>
<!-- script to calculate description length -->
<script>
	function char_countPreFooter(obj)
	{ 
		value_str = obj.value.trim();
		var length = value_str.length; 
		var maxlength = $(obj).attr('maxlength'); 
		var id = obj.id;
		var length = maxlength - length; 
		$('#prefooter_description_char_count').text(length);
	}
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>

