<?php
$this->load->view('admin/templates/header.php');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css">
<script>
	function checkMandatory() 
	{
		noMandatory = 0;
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		var email = $("#email").val();
		var pwd = $("#new_password").val();
		var confirmPwd = $("#confirm_password").val();
		var business_name = $("#business_name").val();
		var business_description = $("#description").val();
		var license_number = $("#license_number").val();
		var business_address = $("#business_address").val();
		
		var re = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

		if ((firstname == '') || (lastname == '') || (email == '') || (pwd == '') || (confirmPwd == '')  || (business_name == '')  || (business_description == '')  || (license_number == '') || (business_address == '')) 
		{
			$("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;

			alert('Some mandatory field remainds empty.Please fill mandatories.');
			return false;
		} 
		else if (!email.match(re)) 
		{
			$("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;
			alert('Invalid Email Address');			
			return false;
		}
		else if (pwd != confirmPwd) 
		{
			$("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;
			alert('New password and confirm password miss match');
			return false;
		}
		else if (!pwd.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/)) {
            $("#nextBtn").removeClass('nxtTab');
			noMandatory = 1;
			alert('Password must have min 8 characters includes 1 digit and 1 upper case');
			return false;
        }
		else 
		{
			noMandatory = 0;
			$("#nextBtn").addClass('nxtTab');
			return true;
		}
	}


	$(document).ready(function () 
	{
		$('.nxtTab').click(function () 
		{
			checkMandatory();
			if (noMandatory == 0) 
			{
				var cur = $(this).parent().parent().parent().parent().parent();
				cur.hide();
				cur.next().show();
				var tab = cur.parent().parent().prev();

				tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
			}
		});

		$('.prvTab').click(function () 
		{
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.prev().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
		});

		$('#tab2 input[type="checkbox"]').click(function () 
		{
			var cat = $(this).parent().attr('class');
			var curCat = cat;
			var catPos = '';
			var added = '';
			var curPos = curCat.substring(3);
			var newspan = $(this).parent().prev();
			if ($(this).is(':checked')) 
			{
				while (cat != 'cat1') 
				{
					cat = newspan.attr('class');
					catPos = cat.substring(3);
					if (cat != curCat && catPos < curPos) 
					{
						if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) 
						{
							/*Found it!*/
						}
						else 
						{
							newspan.find('input[type="checkbox"]').attr('checked', 'checked');
							added += catPos + ',';
						}
					}
					newspan = newspan.prev();
				}
			} 
			else 
			{
				var newspan = $(this).parent().next();
				if (newspan.get(0)) 
				{
					var cat = newspan.attr('class');
					var catPos = cat.substring(3);
				}

				while (newspan.get(0) && cat != curCat && catPos > curPos) 
				{
					newspan.find('input[type="checkbox"]').attr('checked', this.checked);
					newspan = newspan.next();
					cat = newspan.attr('class');
					catPos = cat.substring(3);
				}
			}
		});
	});
</script>
<div id="content" class="addSeller"> 
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New Host</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Host Details</a></li>
							<li><a href="#tab2">Bank Details</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addseller_form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return checkMandatory();', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/seller/insertEditRenter', $attributes)
					?>
					<div id="tab1">
						<ul>							
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Representative Name','bankname', 
												$commonclass);	
									?>
									<div class="form_input">
									<div class="selectdiv">
										<?php if ($_SESSION['fc_session_admin_rep_code'] != '') 
										{
											
											echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'rep_code',
									            'id'	    => 'rep_code',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'readonly'	=> 'readonly',
									            'title'  	=> 'Enter the Representative Code',
												'value'	    => $_SESSION['fc_session_admin_rep_code']
									        ]);
									         
										} 
										else 
										{ 
										/*drop down for rep code*/
										$repcode=array();
										$repcode[''] = 'Select Rep Code';

										foreach ($this->data['query'] as $row_rep)
										{
											$repcode[$row_rep->admin_rep_code]=$row_rep->admin_rep_code;
										}	 

										$repattr = array(
											    'id'     => 'rep_code' 
										);

										echo form_dropdown('rep_code', $repcode, '', $repattr);
										
										} ?>
										</div>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('First Name <span class="req">*</span>',
											'firstname', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'firstname',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '15',
									            'id'          => 'firstname',
												'required'	  => 'required',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the First Name'
									        ]);	

									        $fnamelbl = array('id' => 'full_name_error', 'style' => 'font-size:12px;display:none;','class' => 'error','generated' => 'true');

											echo form_label('Numbers are not allowed','', 
												$fnamelbl);
									    ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Last Name <span class="req">*</span>',
											'lastname', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'lastname',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '15',
									            'id'          => 'lastname',
												'required'	  => 'required',
												'tabindex'	  => '2',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the lastname'
									        ]);	

									        $fnamelbl = array('id' => 'last_name_error', 'style' => 'font-size:12px;display:none;','class' => 'error','generated' => 'true');

											echo form_label('Numbers are not allowed','', 
												$fnamelbl);
									    ?>
									</div>
								</div>
							</li>

							<?php  /* <li>
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

											echo form_dropdown('gender', $gender, '', $genderattr);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Date of birth ','dob_month', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
										//drop down for months
										$mnth=array();
										$mnth[''] = '--Select--';
										for ($i=1;$i<=12;$i++)
										{
											$mnth[$i]=date('F', mktime(0, 0, 0, $i, 1));
										}	 

										$mnthattr = array(
											    'id'     => 'user_birthdate_2i',
											    'class'  => 'valid tipTop',
											    'title'	 => 'Please select date of birth'	   
										);

										echo form_dropdown('dob_month', $mnth, '', $mnthattr);

										//drop down for days
										$days=array();
										$days[''] = '--Select--';
										for ($i=1;$i<=31;$i++)
										{
											$days[$i]=$i;
										}	 

										$daysattr = array(
											    'id'     => 'user_birthdate_3i'
										);

										echo form_dropdown('dob_date', $days, '', $daysattr);

										//drop down for year
										$year=array();
										$year[''] = '--Select--';
										for ($i = 2005; $i > 1920; $i--)
										{
											$year[$i]=$i;
										}	 

										$yearattr = array(
											    'id'     => 'user_birthdate_1i'
										);

										echo form_dropdown('dob_year', $year, '', $yearattr);
										?>
									</div>
								</div>
							</li> 
							 */ ?>
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Phone no','phone_no', 
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
												'class'		  => 'tipTop',
												'title'		  => 'Please enter your phone number',
												'maxlength'	  => 15
									        ]);

									        $numlbl = array('id' => 'phone_no_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Number are allowed','', 
												$numlbl);
									    ?>
									</div>
								</div>
							</li>
							
							<li>
							    <div class="form_grid_12">
							    	<?php echo form_label('Business Name <span
											class="req">*</span>','business_name', $commonclass);?>
							    	<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'business_name',
									            'style'   	  => 'width:295px',
									            'id'          => 'business_name',
												'required'	  => 'required',
												'tabindex'	  => '3',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter business name',
												'maxlength'	  => 100
									        ]);
											
											$busnamelbl = array('id' => 'business_name_error', 'style' => 'font-size:12px;display:none;','class' => 'error','generated' => 'true');

											echo form_label('Numbers are not allowed','', 
												$busnamelbl);
									    ?>
										
							    	</div>
							    </div>
							</li>
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('short Business Description <span
											class="req">*</span>','description', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											
									        $descattr = array(
											    'name' 	      => 'description',
									            'style'   	  => 'width:295px',
									            'tabindex'    => '5',
												'required'	  => 'required',
												'rows'	      => 3,
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter your Business
												                  details'
											);
											echo form_textarea($descattr);
									    ?>
									</div>
								</div>
							</li>
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Real Estate License number <span
											class="req">*</span>','license_number', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'license_number',
									            'style'   	  => 'width:295px',
									            'id'          => 'license_number',
												'required'	  => 'required',
												'tabindex'	  => '3',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter license number',
												'maxlength'	  => 30
									        ]);
									    ?>
									</div>
								</div>
							</li>
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Business Address <span
											class="req">*</span>','business_address', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
									        $descattr = array(
											    'name' 	      => 'business_address',
									            'style'   	  => 'width:295px',
									            'tabindex'    => '5',
												'required'	  => 'required',
												'rows'	      => 3,
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter business address'
											);
											echo form_textarea($descattr);
											
											$citylbl = array('id' => 's_city_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Alphabets are allowed','', 
												$citylbl);
										?>
									</div>
								</div>
							</li>
							
							<!--<li>
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
												'class'		  => 'tipTop',
												'title'		  => 'Please enter your current location'
									        ]);

									        $citylbl = array('id' => 's_city_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Alphabets are allowed','', 
												$citylbl);
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
									            'tabindex'    => '5',
												'rows'	      => 3,
												'class'		  => 'tipTop',
												'title'		  => 'Please enter your details'
											);
											echo form_textarea($descattr);
									    ?>
									</div>
								</div>
							</li> 

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('School','school', 
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
												'class'		  => 'tipTop',
												'title'		  => 'Please enter school name'
									        ]);

									        $schoollbl = array('id' => 'school_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Alphabets are allowed','', 
												$schoollbl);
									    ?>
									</div>
								</div>
							</li> 

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Work','work', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'work',
									            'style'   	  => 'width:295px',
									            'id'          => 'work',
												'tabindex'	  => '7',
												'class'		  => 'tipTop',
												'title'		  => 'Please enter work position'
									        ]);

									        $worklbl = array('id' => 'work_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Alphabets are allowed','', 
												$worklbl);
									    ?>
									</div>
								</div>
							</li> -->
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Email Address <span
											class="req">*</span>','email', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'email',
									            'style'   	  => 'width:295px',
									            'id'          => 'email',
												'tabindex'	  => '7',
												'class'		  => 'tipTop',
												'required'	  => 'required',
												'title'		  => 'Please enter email address',
												'onChange'	  => 'check_seller_email(this.value);'
									        ]);

									        $emaillbl = array('id' => 'email_exist_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('This Email Id
											Already Exist','', 
												$emaillbl);
									    ?>
									</div>
								</div>
							</li>
							
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('New Password <span	class="req">*</span>','new_password', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'password',      
											    'id' 	      => 'new_password',
											    'name'		  => 'new_password',
											    'class'   	  => 'tipTop large',
											    'tabindex'	  => '10',
											    'class'		  => 'required large tipTop',
											    'title'		  => 'Please enter the new password'
											]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Confirm Password <span	class="req">*</span>','confirm_password', $commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'password',      
											    'id' 	      => 'confirm_password',
											    'name'		  => 'confirm_password',
											    'class'   	  => 'tipTop large',
											    'tabindex'	  => '11',
											    'class'		  => 'required large tipTop',
											    'title'		  => 'Please re-type the above password'
											]);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Logo <span class="req">(Upload 272px X 272px Image)</span>','image', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'file',      
									            'name' 	      => 'image',
									            'title'   	  => 'Please select user image',
									            'id'          => 'image',
												'tabindex'	  => '12',
												'class'		  => 'large tipTop',
												'onchange'	  => 'Upload();'
									        ]);

									        $imglbl1 = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Height and Width must be 272PX x 272PX.','', 
												$imglbl1);

											$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Please select a valid Image file','', 
												$imglbl2);
									    ?>
									</div>
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
										<input type="checkbox" tabindex="13" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'button',      
									            'value' 	  => 'Next',
									            'id'          => 'nextBtn',
												'class'		  => 'btn_small btn_blue nxtTab'
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
										echo form_label('Account Name','accname', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'accname',
									            'id'          => 'accname',
												'tabindex'	  => '1',
												'class'		  => 'tipTop large',
												'title'	  	  => 'Enter the bank account Name'
									        ]);

									        $accnamelbl = array('id' => 'accname_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Numbers are not allowed','', 
												$accnamelbl);
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Account Number','accno', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'accno',
									            'id'          => 'accno',
												'tabindex'	  => '2',
												'class'		  => 'tipTop large',
												'title'	  	  => 'Enter the bank account number'
									        ]);

									        $accnolbl = array('id' => 'accno_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Only Numbers are allowed','', 
												$accnolbl);
									    ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php										
										echo form_label('Bank Name','bankname', 
												$commonclass);	
								    ?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'bankname',
									            'id'          => 'bankname',
												'tabindex'	  => '3',
												'class'		  => 'tipTop large',
												'title'	  	  => 'Enter the bank name'
									        ]);

									        $accnolbl = array('id' => 'bankname_error', 'style' => 'font-size:12px;display:none;','class' => 'error');

											echo form_label('Numbers are not allowed','', 
												$accnolbl);
									    ?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'button',      
									            'value' 	  => 'Previous',
									            'tabindex'    => '4',
												'class'		  => 'btn_small btn_blue prvTab'
									        ]);

											echo form_input([
												'type'        => 'submit',      
									            'value' 	  => 'Submit',
									            'tabindex'    => '9',
												'class'		  => 'btn_small btn_blue'
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
<!--calling fuction to validate form on submiting -->
<script>
	$('#addseller_form').validate();
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
<!-- Script to validate form inputs -->
<script>
	$("#firstname").on('keyup', function (e) 
	{
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) 
		{
			document.getElementById("full_name_error").style.display = "inline";
			$("#full_name").focus();
			$("#full_name_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#lastname").on('keyup', function (e) 
	{
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) 
		{
			document.getElementById("last_name_error").style.display = "inline";
			$("#last_name").focus();
			$("#last_name_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#phone_no").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^+0-9\s]/g)) 
		{
			document.getElementById("phone_no_error").style.display = "inline";
			$("#phone_no").focus();
			$("#phone_no_error").fadeOut(5000);
			$(this).val(val.replace(/[^+0-9\s]/g, ''));
		}
	});


	$("#accno").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^0-9-\s()]/g)) 
		{
			document.getElementById("accno_error").style.display = "inline";
			$("#accno").focus();
			$("#accno_error").fadeOut(5000);
			$(this).val(val.replace(/[^0-9-\s()]/g, ''));
		}
	});

	$("#accname").on('keyup', function (e) 
	{
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) {
			document.getElementById("accname_error").style.display = "inline";
			$("#accname").focus();
			$("#accname_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#bankname").on('keyup', function (e) 
	{
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) 
		{
			document.getElementById("bankname_error").style.display = "inline";
			$("#bankname").focus();
			$("#bankname_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});
	
	$("#business_name").on('keyup', function (e) 
	{
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) 
		{
			document.getElementById("business_name_error").style.display = "inline";
			$("#business_name").focus();
			$("#business_name_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});
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
					{
						var height = this.height;
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

<script type="text/javascript">
	/*this function is to check Email Id already exist or not*/
	function check_seller_email(emailid)
	{
		$.ajax({
			type: 'POST',
			data: 'email_id=' + emailid,
			url: 'admin/seller/check_seller_email_exist',
			success: function (responseText) 
			{
				if (responseText == 1) 
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