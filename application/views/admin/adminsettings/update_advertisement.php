<div id="content">
<?php 


?>

		<div class="grid_container">

			<div class="grid_12">

				<div class="widget_wrap">

					<div class="widget_top">

						<span class="h_icon list"></span>

						<h6>Update Advertisement</h6>

					</div>
					
					<?php if($get_adv_result->num_rows() > 0 ) { ?>

					<div class="widget_content">
					
					
					<form action="admin/adminlogin/edit_advertisement" method="post" id="update_advertisement" class="form_container left_label" enctype="multipart/form-data">
				

	 						<ul>

								<li>

								<div class="form_grid_12">

									<?php

									$tittlelbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Tittle<span class="req">*</span>','Tittle',$tittlelbl);

									?>

									<div class="form_input">

										<?php

											$tittle = array(

											'name' 	       => 'tittle',

											'id'   	   	   => 'tittle',

											'tabindex' 	   => '1',

											'class'    	   => 'required large tipTop',

											'autocomplete' => FALSE,

											'maxlenght' => '30',

											'title'        => 'Please enter the tittle of advertisement',
											
											'value'        => $get_adv_result->row()->title

										);

										echo form_input($tittle);

										?>										
<br>
<small style="color: red;">Maximum 30 characters</small>
									</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<?php

									$desclbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Description<span class="req">*</span>','Description',$desclbl);

									?>

									<div class="form_input">

										<?php

											$description = array(
											'name' => 'description',
											'id' => 'description',
											'tabindex' => '2',
											'class' => 'large tipTop dscptn_wdth',
											'rows' => 2,
											'title' => 'Please enter the Advertisement description',
											'value' => $get_adv_result->row()->description
										);
										echo form_textarea($description);

										?>										
<br>
<small style="color: red;">Maximum 150 Words</small>
									</div>
									<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
					<p style="color: red;" class="text center text-danger" id="danger"></p>
					<p class="text center text-success" id="success"></p>
				</div>

								</div>

								</li>

								<li>

								<div class="form_grid_12">

									<?php

									$linklbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Link<span class="req">*</span>','Link',$linklbl);

									?>

									<div class="form_input">

										<?php

										$repswd = array(
												'type'=>'url',

											'name' 	       => 'link',

											'id'   	       => 'link',

											'tabindex'     => '3',

											'class'        => 'required large tipTop',

											'autocomplete' => FALSE,

											'title'        => 'Please Enter Link',
											
											'value'        => $get_adv_result->row()->link

										);

										echo form_input($repswd);

										?>

									</div>

								</div>

								</li>
								
								
										
										
								<li>
										
								<div class="form_grid_12">

									<?php

									$Imagelbl = array(

									        'class' => 'field_title'  

									);

									echo form_label('Image<span class="req">*</span>','Image',$Imagelbl);

									?>

									<div class="form_input">

										<?php
										echo form_label('Height and Width must be Exact 508PX x 400PX','Image',$Imagelbl);
										echo form_input(array(
											'type' => 'file',
											'name' => 'image',
											'title' => 'Please select Advertisement image',
											'id' => 'image',
											'tabindex' => '11',
											'class' => 'large tipTop',
											'onchange' => 'Upload();'
                                        ));

										
										$imglbl1 = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Height and Width must be Exact 508PX x 400PX.', '',
											$imglbl1);
											
											$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Please select a valid Image file', '',
											$imglbl2);
											
											
											$img_ex=array(
												'type'=>'hidden',
												 'name'=>'img_ex',
												 'id'=>'img_ex',
												 'value'=>$get_adv_result->row()->image
											);
											echo form_input($img_ex);
										?>

										
									</div>
									
									<img src="<?php echo base_url()?>images/advertisment/<?php echo $get_adv_result->row()->image; ?>"  height="100" width="100" style="margin-left: 324px;">

								</div>
										
										
								</li>
								
								<li>
								<div class="form_grid_12">
									<?php
									
									$Statuslbl = array(
									        'class' => 'field_title'  
									);
									echo form_label('Status', 'Status', $Statuslbl);
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" 
												   name="status" <?php if ($get_adv_result->row()->status == 'Active') {
												echo 'checked="checked"';
											} ?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>
								
								
								
								

								<li>

								<div class="form_grid_12">

									<div class="form_input">

										<?php

										$update_ad = array(
										    'name'=>'update',
											
											'type'=>'button',
											
											'content'=> 'Update',

											'class'  => 'btn_small btn_blue',
											
											'onClick'   => 'Update_add()'

										);

										echo form_button($update_ad);

										?>

									</div>

								</div>

								</li>

							</ul>

						</form>

					</div>
					<?php }  else { ?>
					
					<p>No Advertisement Added..!</p>
					
					<?php  }?>

				</div>

			</div>

		</div>

		<span class="clear"></span>

	</div>

</div>

<script type="text/javascript">
function Upload() {
		var fileUpload = document.getElementById("image");
		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif)$");
		if (regex.test(fileUpload.value.toLowerCase())) {
			if (typeof (fileUpload.files) != "undefined") {
				var reader = new FileReader();
				reader.readAsDataURL(fileUpload.files[0]);

				reader.onload = function (e) {
					var image = new Image();
					image.src = e.target.result;
					image.onload = function () {
						var height = this.height;
						var width = this.width;
						//alert(height+'\n'+width);
						if (height !=400 || width !=508) {
							document.getElementById("image_valid_error").style.display = "inline";
							$("#image_valid_error").fadeOut(7000);
							$("#image").val('');
							$(".filename").text('No file selected');
							$("#image").focus();
							return false;
						}
						return true;
					};
				}
			}
			else {
				alert("This browser does not support HTML5.");
				$("#image").val('');
				return false;
			}
		}
		else {
			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(7000);
			$("#image").val('');
			$("#image").focus();
			return false;
		}
	}
	
	function Update_add(){
		var tit=$("#tittle").val();
		var desc=$("#description").val();

		var link=$("#link").val();
		var img=$("#img_eximg_ex").val();
		var words = desc.split(/\b\S+\b/g).length - 1;


		if (words > 150) {
				document.getElementById("errordisplay").style.display = "block";
				document.getElementById("danger").innerHTML = "Total of " + words + " words found! Summary should not exceed 150 words!";
				return false;
			}
			else {
				document.getElementById("errordisplay").style.display = "none";
				document.getElementById("danger").innerHTML = "";
			}
		
		if (tit=="" || desc=="" || link=="" || img==""){
			alert("Please Fill All Fields");
		}else{
			document.getElementById("update_advertisement").submit();
			
		}
	}
</script>