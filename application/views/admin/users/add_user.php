<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New Guest</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'adduser_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/users/insertEditUser', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('First Name <span class="req">*</span>','firstname', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'firstname',
									            'id'	    => 'firstname',
									            'maxlength' => '50',
									            'class'     => 'required large tipTop',
									            'tabindex'  => '1',
												'title'	    => 'Please enter the user First Name'
									        ]);

									        $fnamelbl = array('id' => 'firstname_error_len', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Max 50 Characters Allowed','', 
												$fnamelbl);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Last Name <span class="req">*</span>','lastname', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'lastname',
									            'id'	    => 'lastname',
									            'maxlength' => '50',
									            'class'     => 'required large tipTop',
									            'tabindex'  => '2',
												'title'	    => 'Please enter the user Last Name'
									        ]);

									        $lnamelbl = array('id' => 'lastname_error_len', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Max 50 Characters Allowed','', 
												$lnamelbl);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Email Address <span class="req">*</span>','email', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'email',
									            'id'	    => 'email',
									            'onChange'  => 'check_email_exist(this.value);',
									            'class'     => 'required email large tipTop',
									            'tabindex'  => '3',
												'title'	    => 'Please enter the user email address'
									        ]);

									        $maillbl = array('id' => 'email_exist_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('This Email Id Already Exist','', 
												$maillbl);
									?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('New Password <span class="req">*</span>','new_password', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'password',      
									            'name' 	    => 'new_password',
									            'id'	    => 'new_password',
									            'onChange'  => 'check_email_exist(this.value),check_password();',
									            'class'     => 'required large tipTop',
									            'tabindex'  => '4',
												'title'	    => 'Please enter the new password'
									        ]);
									?>
								</div>
								 <p class="text-danger" style="color:red;padding-left: 366px;" id="new_password_error_message"></p>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Re-type Password <span class="req">*</span>','confirm_password', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'password',      
									            'name' 	    => 'confirm_password',
									            'id'	    => 'confirm_password',
									            'onChange'  => 'check_email_exist(this.value);',
									            'class'     => 'required large tipTop',
									            'tabindex'  => '5',
												'title'	    => 'Please re-type the above password'
									        ]);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12 ">
								<?php
										echo form_label('User Image <span class="req">(Below 272px X 272px Image)</span>','image', 
												$commonclass);	
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'      => 'file',      
									            'name' 	    => 'image',
									            'id'	    => 'image',
									            'onChange'  => 'Upload(this.id);',
									            'class'     => 'large tipTop',
									            'tabindex'  => '6',
												'title'	    => 'Please select user image'
									        ]);

									        $imglbl = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Height and Width must be 272PX x 272PX.','', 
												$imglbl);

											$imgtypelbl = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Please select a valid Image file','', 
												$imgtypelbl);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php
										echo form_label('Status <span class="req">*</span>','admin_name', 
												$commonclass);	
								?>
								<div class="form_input">
									<div class="active_inactive">
										<input type="checkbox" tabindex="7" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
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
									            'class'     => 'btn_small btn_blue',
									            'tabindex'  => '8',
									            'value'     => 'Submit'
									        ]);
									?>
								</div>
							</div>
						</li>
					</ul>
					<?php	echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>

<?php
$this->load->view('admin/templates/footer.php');
?>
<!-- Script to validating firstname and lastname -->
<script>
	$("#firstname").on('keypress', function (e) 
	{
		var val = $(this).val();
		if (val.length == 50) 
		{
			document.getElementById("firstname_error_len").style.display = "inline";
			$("#firstname_error_len").fadeOut(5000);
		}
	});

	$("#lastname").on('keypress', function (e) 
	{
		var val = $(this).val();
		if (val.length == 50) 
		{
			document.getElementById("lastname_error_len").style.display = "inline";
			$("#lastname_error_len").fadeOut(5000);
		}
	});
</script>

<!--Script to validate image and upload-->
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
						if (height > 272 || width > 272) 
						{							
							document.getElementById("image_valid_error").style.display = "inline";
							$("#image").val('');
							$(".filename").html('No file selected');
							$("#image_valid_error").fadeOut(7000);
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
				$(".filename").html('');
				return false;
			}
		} 
		else 
		{			
			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(7000);
			$("#image").val('');
			$(".filename").html('');
			$("#image").focus();
			return false;
		}
	}
</script>

<!--start subadmin email id check-->
<script type="text/javascript">
	function check_email_exist(emailid) 
	{
		$.ajax({
			type: 'POST',
			data: 'email_id=' + emailid + '&group=User',
			url: 'admin/users/check_user_email_exist',
			success: function (responseText) 
			{
				if (responseText > 0) 
				{
					document.getElementById("email_exist_error").style.display = "inline";
				} 
				else 
				{
					document.getElementById("email_exist_error").style.display = "none";
				}
			}
		});
	}

</script>

<script>
function check_password(){
	var user_password = $('#new_password').val(); 
	if (!user_password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{6,}$/)) { 
            $("#new_password").focus();
            $("#new_password").val('');
            $("#new_password_error_message").html('Password must be 8 characters (must contain 1 digit and 1 uppercase)')
            return false;
        }
}

</script>
<!--end subadmin email id check-->	
