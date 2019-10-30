<?php
$this->load->view('admin/templates/header.php');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css">
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Guest</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">User Details</a></li>
							<li><a href="#tab2">Change Password</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/users/insertEditUser', $attributes)
					?>
					<div id="tab1">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('First Name <span
												class="req">*</span>','full_name', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'firstname',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '50',
									            'id'          => 'full_name',
												'required'	  => 'required',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the user First Name',
												'value'		  => $user_details->row()->firstname
									        ]);	

									        $errorcharlbl = array('id' => 'full_name_error_len', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Max 50 Characters Allowed','', 
												$errorcharlbl);	

											$errornumlbl = array('id' => 'first_name_error_num', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Numbers are not allowed','', 
												$errornumlbl);							
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Last Name <span
												class="req">*</span>','full_name', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'lastname',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '50',
									            'id'          => 'last_name',
												'required'	  => 'required',
												'tabindex'	  => '2',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the user Last Name',
												'value'		  => $user_details->row()->lastname
									        ]);	

									        $lstnamelbl1 = array('id' => 'last_name_error_len', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Max 50 Characters Allowed','', 
												$lstnamelbl1);	

											$lstnamelbl2 = array('id' => 'last_name_error_num', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Numbers are not allowed','', 
												$lstnamelbl2);							
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('I Am ','gender', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php 
											$gender = array(); 
											$gender = array(
													''			   => '--Select--',
											        'Male'         => 'Male',
											        'Female'       => 'Female',
											        'Unspecified'  => 'Unspecified'	   
											);											

											$genderattr = array(
											        'id'     => 'gender',
											        'class'  => 'large tipTop',
											        'title'  => 'Please select the gender'	   
											);

											if ($user_details->row()->gender == 'Male')
											{
												$selectedgender = Male;
											}
											elseif ($user_details->row()->gender == 'Female') 
											{
												$selectedgender = Female;
											}
											elseif ($user_details->row()->gender == 'Unspecified') 
											{
												$selectedgender = Unspecified;
											}

											echo form_dropdown('gender', $gender, $selectedgender, $genderattr);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Date of birth ','gender', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										/*drop down for months*/
										$mnth=array();
										$mnth[''] = '--Select--';
										for ($i=1;$i<=12;$i++)
										{
											$mnth[$i]=date('F', mktime(0, 0, 0, $i, 1));
										}	 

										$mnthattr = array(
											    'id'     => 'user_birthdate_2i',
											    'class'  => 'valid'	   
										);

										echo form_dropdown('dob_month', $mnth, $user_details->row()->dob_month, $mnthattr);

										/*drop down for days*/
										$days=array();
										$days[''] = '--Select--';
										for ($i=1;$i<=31;$i++)
										{
											$days[$i]=$i;
										}	 

										$daysattr = array(
											    'id'     => 'user_birthdate_3i'
										);

										echo form_dropdown('dob_date', $days, $user_details->row()->dob_date, $daysattr);

										/*drop down for year*/
										$year=array();
										$year[''] = '--Select--';
										for ($i = 2005; $i > 1920; $i--)
										{
											$year[$i]=$i;
										}	 

										$yearattr = array(
											    'id'     => 'user_birthdate_1i'
										);

										echo form_dropdown('dob_year', $year, $user_details->row()->dob_year, $yearattr);

										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Phone no ','phone_no', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'phone_no',
									            'style'   	  => 'width:295px',
									            'id'          => 'phone_no',
												'tabindex'	  => '3',
												'value'		  => $user_details->row()->phone_no
									        ]);	

									    	$numlbl = array('id' => 'phone_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Number are allowed','', 
												$numlbl);
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Where You Live','s_city', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 's_city',
									            'style'   	  => 'width:295px',
									            'id'          => 's_city',
												'tabindex'	  => '4',
												'value'		  => $user_details->row()->s_city
									        ]);
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Describe Yourself','description', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											
									        $descattr = array(
											    'name' 	      => 'description',
									            'style'   	  => 'width:295px',
									            'id'          => 'description',
												'rows'	      => 3,
												'value'		  => $user_details->row()->description
											);
											echo form_textarea($descattr);
									    ?>
										</br>
										<br><span class="words-left"> </span>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('School','s_city', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'school',
									            'style'   	  => 'width:295px',
									            'id'          => 'school',
												'tabindex'	  => '6',
												'value'		  => $user_details->row()->school
									        ]);
									    ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Work','work', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'work',
									            'style'   	  => 'width:295px',
									            'id'          => 'work',
												'tabindex'	  => '7',
												'value'		  => $user_details->row()->work
									        ]);
									    ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Email Address','email', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php echo $user_details->row()->email; ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('User Image <span class="req">(Below 272px X 272px Image)</span>','image', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'file',      
									            'name' 	      => 'image',
									            'title'   	  => 'Please select user image',
									            'id'          => 'image',
												'tabindex'	  => '8',
												'class'		  => 'large tipTop',
												'accept'	  => 'image/*'
									        ]);

									        $imglbl1 = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Height and Width must be 272PX x 272PX.','', 
												$imglbl1);

											$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Please select a valid Image file','', 
												$imglbl2);
									    ?>
									</div>
									<?php if ($user_details->row()->loginUserType == "google") 
									{ ?>
										<div class="form_input">
											<img
												src="<?php if ($user_details->row()->image == '') {
													echo base_url() . 'images/users/user-thumb1.png';
												} else {
													echo $user_details->row()->image;
												} ?>" width="100px"/>
											</div>
									<?php 
									} 
									else 
									{ ?>
										<div class="form_input">
											<img
												src="<?php if ($user_details->row()->image == '') {
													echo base_url() . 'images/users/user-thumb1.png';
												} 
												else 
												{
													echo base_url(); ?>images/users/<?php echo $user_details->row()->image;
												} ?>" width="100px"/>
										</div>
									<?php } ?>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Status <span
											class="req">*</span>','admin_name', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox"
												   name="status" <?php if ($user_details->row()->status == 'Active') {
												echo 'checked="checked"';
											} ?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								<?php
									echo form_input([
										'type'        => 'hidden',      
									    'name' 	      => 'user_id',
									    'value'   	  => $user_details->row()->id
									]);
								?>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'button',      
											    'id' 	      => 'validate_edituser_form',
											    'class'   	  => 'btn_small btn_blue',
											    'value'		  => 'Update'
											]);
										?>	
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab2">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Password','password', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'password',      
											    'id' 	      => 'admin-pass',
											    'name'		  => 'password',
											    'class'   	  => 'tipTop large',
											    'value'		  => '',
											    'title'		  => 'Enter the Password'
											]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Confirm Password','confirm-password', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'password',      
											    'id' 	      => 'admin-cnfm-pass',
											    'name'		  => 'confirm-password',
											    'class'   	  => 'tipTop large',
											    'value'		  => '',
											    'title'		  => 'Enter the Confirm Password'
											]);
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
											    'onclick' 	  => 'return checkPassword();',
											    'class'   	  => 'btn_small btn_blue',
											    'value'		  => 'Update'
											]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>

<!-- Script to validate form inputs -->
<script type="text/javascript">
	$('#validate_edituser_form').click(function () 
	{
		var image_name = $('#image').val();
		var full_name = $('#full_name').val();
		var last_name = $('#last_name').val();

		var ext = $('#image').val().split('.').pop().toLowerCase();
		if (full_name == '') 
		{
			document.getElementById("full_name_error").style.display = "inline";
			$("#full_name_error").fadeOut(8000);
		} 
		else if (last_name == '') 
		{
			document.getElementById("last_name_error").style.display = "inline";
			$("#last_name_error").fadeOut(8000);
		} 
		else if (image_name != '') 
		{
			if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) 
			{
				alert('Only Images can be Uploaded');
			}
			else 
			{
				$('#edituser_form').submit();
			}
		}
		else 
		{
			$('#edituser_form').submit();
		}
	});
</script>
<!-- Script to validate form inputs -->
<script>
	$("#full_name").on('keypress', function (e) 
	{
		var val = $(this).val();
		if (val.length == 50) 
		{
			document.getElementById("full_name_error_len").style.display = "inline";
			$("#full_name_error_len").fadeOut(5000);
		}
	});

	$("#last_name").on('keypress', function (e) 
	{
		var val = $(this).val();
		if (val.length == 50) 
		{
			document.getElementById("last_name_error_len").style.display = "inline";
			$("#last_name_error_len").fadeOut(5000);
		}
	});

	$("#phone_no").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^+0-9\s]/g)) 
		{
			document.getElementById("phone_error").style.display = "inline";
			$("#phone_no").focus();
			$("#phone_error").fadeOut(5000);
			$(this).val(val.replace(/[^+0-9\s]/g, ''));
		}
	});


</script>

<!-- Script to validate password -->
<script type="text/javascript">
	function checkPassword() 
	{
		if ($('#admin-pass').val().length < 8) 
		{
			alert('Password must be 8 characters (must contain 1 digit and 1 uppercase)');
			return false;
		}
		if ($('#admin-pass').val() != $('#admin-cnfm-pass').val()) 
		{
			alert('Password should be same as above given password!');
			return false;
		}
		else return true;
	}
</script>

<!-- Script to validate image and upload -->
<script type="text/javascript">
	function Upload() 
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
					{						var height = this.height;
						var width = this.width;						
						if (height > 272 || width > 272) 
						{							
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
			$("#image_type_error").fadeOut(7000);
			$("#image").val('');
			$("#image").focus();
			return false;
		}
	}
</script>

<script>
	$(document).ready(function () 
	{
		$('.yes_no').click(function () 
		{
			if ($('#yesNoCheck').is(":checked")) 
			{
				$(".verifyUnverifyOption").css("display", "none");
				$("#showErr").html("UnVerified");
			} 
			else 
			{
				$(".verifyUnverifyOption").css("display", "block");
				$("#showErr").html("");
			}

		});
	});
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
<script type="text/javascript">
    $(function () {
        var element = document.getElementById('phone_no');
        if(element.value=='')
        {
            $('#phone_no').val('+91');
        }

		$("body").tooltip({ selector: '[data-toggle=tooltip]' });
		//alert('<?php echo current_url();?>');
    });
</script>
<script src="<?php echo base_url(); ?>assets/js/intlTelInput.js"></script>
<script type="text/javascript">
    $("#phone_no").intlTelInput({
      // allowDropdown: false,
      // autoHideDialCode: false,
      // autoPlaceholder: "off",
      // dropdownContainer: document.body,
      // excludeCountries: ["us"],
      // formatOnDisplay: false,
      // geoIpLookup: function(callback) {
      //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
      //     var countryCode = (resp && resp.country) ? resp.country : "";
      //     callback(countryCode);
      //   });
      // },
      // hiddenInput: "full_number",
      // initialCountry: "auto",
      // localizedCountries: { 'de': 'Deutschland' },
      // nationalMode: false,
      // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
      // placeholderNumberType: "MOBILE",
      preferredCountries: ['in'],
      // separateDialCode: true,
      utilsScript: "build/js/utils.js",
    });
    
</script>