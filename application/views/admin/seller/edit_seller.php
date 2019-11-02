<?php
$this->load->view('admin/templates/header.php');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/intlTelInput.css">
<script type="text/javascript">
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Host</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Host Details</a></li>
							<li><a href="#tab2">Bank Details</a></li>
							<li><a href="#tab3">Change Password</a></li>
							<li><a href="#tab4" class="id_verify active_tab" id="id_verify">ID Verification</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open('admin/seller/insertEditSeller', $attributes);
					?>
					<div id="tab1">
						<ul>
							<?php
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'rep_code',
								'title' => 'Enter the bank name',
								'class' => 'required tipTop',
								'readonly' => 'readonly',
								'value' => $seller_details->row()->rep_code
                            ));
							?>
							<li>
								<div class="form_grid_12">
									<?php
									$commonclass = array('class' => 'field_title');
									echo form_label('Rep Code <span
													class="req">*</span>', 'bankname',
										$commonclass);
									?>
									<div class="form_input">
										<?php
										if ($_SESSION['fc_session_admin_rep_code'] != '') {
											echo form_input(array(
												'type' => 'text',
												'name' => 'rep_code',
												'id' => 'rep_code',
												'style' => 'width:295px',
												'class' => 'tipTop required',
												'readonly' => 'readonly',
												'title' => 'Enter the Representative Code',
												'value' => $_SESSION['fc_session_admin_rep_code']
                                            ));
										} else {
											/*drop down for rep code*/
											$repcode = array();
											$repcode[''] = 'Select Rep Code';
											foreach ($this->data['query'] as $row_rep) {
												$repcode[$row_rep->admin_rep_code] = $row_rep->admin_rep_code;
											}
											echo form_dropdown('rep_code', $repcode,
												$seller_details->row()->rep_code);
										} ?>
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
										echo form_input(array(
											'type' => 'text',
											'name' => 'firstname',
											'style' => 'width:295px',
											'value' => $seller_details->row()->firstname,
											'id' => 'full_name',
											'required' => 'required',
											'tabindex' => '1',
											'class' => 'required tipTop',
											'title' => 'Please enter the First Name'
                                        ));
										$fnamelbl = array('id' => 'full_name_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error', 'generated' => 'true');
										echo form_label('Numbers are not allowed', '',
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
										echo form_input(array(
											'type' => 'text',
											'name' => 'lastname',
											'style' => 'width:295px',
											'value' => $seller_details->row()->lastname,
											'id' => 'last_name',
											'required' => 'required',
											'tabindex' => '2',
											'class' => 'required tipTop',
											'title' => 'Please enter the lastname'
                                        ));
										$fnamelbl = array('id' => 'last_name_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error', 'generated' => 'true');
										echo form_label('Numbers are not allowed', '',
											$fnamelbl);
										?>
									</div>
								</div>
							</li>
							<?php /* <li>
								<div class="form_grid_12">
									<?php
									echo form_label('I Am ', 'gender', $commonclass);
									?>
									<div class="form_input">
										<?php
										$gender = array();
										$gender = array(
											'' => '--Select--',
											'Male' => 'Male',
											'Female' => 'Female',
											'Unspecified' => 'Unspecified'
										);
										$genderattr = array(
											'id' => 'gender',
											'tabindex' => '3',
											'class' => 'large tipTop',
											'title' => 'Please select the gender'
										);
										echo form_dropdown('gender', $gender, $seller_details->row()->gender, $genderattr);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Date of birth ', 'dob_month', $commonclass);
									?>
									<div class="form_input">
										<?php
										
										$mnth = array();
										$mnth[''] = '--Select--';
										for ($i = 1; $i <= 12; $i++) {
											$mnth[$i] = date('F', mktime(0, 0, 0, $i, 1));
										}
										$mnthattr = array(
											'id' => 'user_birthdate_2i',
											'class' => 'valid',
											'tabindex' => '4'
										);
										echo form_dropdown('dob_month', $mnth,
											$mnth[$seller_details->row()->dob_month], $mnthattr);
										
										$days = array();
										$days[''] = '--Select--';
										for ($i = 1; $i <= 31; $i++) {
											$days[$i] = $i;
										}
										$daysattr = array(
											'id' => 'user_birthdate_3i'
										);
										echo form_dropdown('dob_date', $days,
											$days[$seller_details->row()->dob_date], $daysattr);
										
										$year = array();
										$year[''] = '--Select--';
										for ($i = 2005; $i > 1920; $i--) {
											$year[$i] = $i;
										}
										$yearattr = array(
											'id' => 'user_birthdate_1i'
										);
										echo form_dropdown('dob_year', $year,
											$year[$seller_details->row()->dob_year], $yearattr);
										?>
									</div>
								</div>
							</li> */ ?>
							
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Phone no', 'phone_no',
										$commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'phone_no',
											'style' => 'width:295px',
											'id' => 'phone_no',
											'tabindex' => '5',
											'class' => 'tipTop',
											'value' => $seller_details->row()->phone_no,
											'onkeypress' => ''
                                        ));
										$numlbl = array('id' => 'phone_no_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Only Number are allowed', '',
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
												'value' => $seller_details->row()->business_name,
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
												'value' => $seller_details->row()->description,
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
												'value' => $seller_details->row()->license_number,
												'title'		  => 'Please enter license number',
												'maxlength'	  => 15
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
												'value' => $seller_details->row()->business_address,
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
							
							
							<?php /* <li>
								<div class="form_grid_12">
									<?php
									echo form_label('Where You Live', 's_city',
										$commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 's_city',
											'style' => 'width:295px',
											'id' => 's_city',
											'tabindex' => '6',
											'value' => $seller_details->row()->s_city
                                        ));
										?>
									</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Describe Yourself', 'description',
										$commonclass);
									?>
									<div class="form_input">
										<?php
										$descattr = array(
											'name' => 'description',
											'style' => 'width:295px',
											'tabindex' => '7',
											'rows' => 3,
											'value' => $seller_details->row()->description
										);
										echo form_textarea($descattr);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('School', 'school', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'school',
											'style' => 'width:295px',
											'id' => 'school',
											'tabindex' => '8',
											'value' => $seller_details->row()->school
                                        ));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Work', 'work', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'work',
											'style' => 'width:295px',
											'id' => 'work',
											'tabindex' => '9',
											'value' => $seller_details->row()->work
                                        ));
										?>
									</div>
								</div>
							</li> */ ?>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Email Address <span
											class="req">*</span>', 'email', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'email',
											'style' => 'width:295px',
											'readonly' => 'readonly',
											'tabindex' => '10',
											'class' => 'tipTop required',
											'required' => 'required',
											'title' => 'Please enter email address',
											'value' => $seller_details->row()->email
                                        ));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('User Image <span class="req">(Upload 272px X 272px Image)</span>', 'image',
										$commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'file',
											'name' => 'image',
											'title' => 'Please select user image',
											'id' => 'image',
											'tabindex' => '11',
											'class' => 'large tipTop',
											'onchange' => 'Upload();'
                                        ));
										$imglbl1 = array('id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Height and Width must be 272PX x 272PX.', '',
											$imglbl1);
										$imglbl2 = array('id' => 'image_type_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Please select a valid Image file', '',
											$imglbl2);
										?>
									</div>
									<?php
									if ($seller_details->row()->loginUserType == "google" && strpos($seller_details->row()->image, 'http') !== false) { ?>
										<div class="form_input">
											<img src="<?php if ($seller_details->row()->image == '') {
												echo base_url() . 'images/site/profile.png';
											} else {
												echo $seller_details->row()->image;
											} ?>" width="100px"/></div>
										<?php
									} elseif ($seller_details->row()->image != '' && file_exists('images/users/' . $seller_details->row()->image)) { ?>
										<div class="form_input"><img
												src="<?php if ($seller_details->row()->image == '') {
													echo base_url() . 'images/site/profile.png';
												} else {
													echo base_url(); ?>images/users/<?php echo $seller_details->row()->image;
												} ?>" width="100px"/></div>
										<?php
									} else { ?>
										<img width="40px" height="40px"
											 src="<?php echo base_url(); ?>images/users/user-thumb1.png"/>
										<?php
									}
									?>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Status <span class="req">*</span>', 'admin_name', $commonclass);
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="13"
												   name="status" <?php if ($user_details->row()->status == 'Active') {
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
										echo form_input(array(
											'type' => 'submit',
											'value' => 'Update',
											'class' => 'btn_small btn_blue'
                                        ));
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
									echo form_label('Stripe Account Name <span class="req">*</span>', 'acc_name', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'accname',
											'id' => 'accname',
											'value' => $seller_details->row()->accname,
											'class' => 'tipTop large',
											'title' => 'Enter the bank account Name',
											'required' => 'required'
                                        ));
										$accnamelbl = array('id' => 'accname_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Numbers are not allowed', '',
											$accnamelbl);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Account Number <span class="req">*</span>', 'accno', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'accno',
											'id' => 'accno',
											'required' => 'required',
											'class' => 'tipTop large',
											'title' => 'Enter the bank account number',
											'value' => $seller_details->row()->accno
                                        ));
										$accnolbl = array('id' => 'accno_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Only Numbers are allowed', '',
											$accnolbl);
										?>
									</div>
								</div>
							</li>
							<li style="display:none;">
								<div class="form_grid_12">
									<?php
									echo form_label('Stripe Account User Name <span class="req">*</span>', 'bankname', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'bankname',
											'id' => 'bankname',
											'required' => 'required',
											'class' => 'tipTop large',
											'title' => 'Enter the Stripe Account name',
											'value' => $seller_details->row()->bankname,
                                        ));
										$accnolbl = array('id' => 'bankname_error', 'style' => 'font-size:12px;display:none;', 'class' => 'error');
										echo form_label('Numbers are not allowed', '',
											$accnolbl);
										?>
									</div>
								</div>
							</li>
							<li style="display:none;">
								<div class="form_grid_12">
									<?php
									echo form_label('Paypal Email <span class="req">*</span>', 'paypal_email', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'email',
											'name' => 'paypal_email',
											'id' => 'paypal_email',
											'required' => 'required',
											'class' => 'tipTop large',
											'title' => 'Enter the bank name',
											'value' => $seller_details->row()->paypal_email
                                        ));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										if($site_status_val == 1){
										echo form_input(array(
											'type' => 'submit',
											'value' => 'Update',
											'tabindex' => '4',
											'class' => 'btn_small btn_blue'
											 ));
										}
										elseif($site_status_val == 2)
												{
											?>
											<button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Save</button>
										<?php } ?>
                                       
									
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab3">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Password', 'password', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'password',
											'id' => 'admin-pass',
											'name' => 'password',
											'class' => 'tipTop large',
											'title' => 'Enter the password'
                                        ));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Confirm Password ', 'confirm_password', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'password',
											'id' => 'admin-cnfm-pass',
											'name' => 'confirm-password',
											'class' => 'tipTop large',
											'title' => 'Enter the Confirm password'
                                        ));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'submit',
											'value' => 'Update',
											'onclick' => 'return checkPassword();',
											'class' => 'btn_small btn_blue'
                                        ));
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<?php
					echo form_input(array(
						'type' => 'hidden',
						'name' => 'seller_id',
						'value' => $seller_details->row()->id
					));
					echo form_close();
					?>
					<!-- id verify-->
					<div id="tab4">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
						echo form_open('admin/seller/update_host_id_proof/' . $user_idProof->row()->id, $attributes);
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<table border="1px" width="100%">
										<tr>
											<th width="25%">S.No</th>
											<th width="25%"> Proof Type</th>
											<th width="25%">ID Proof</th>
											<th width="25%">Status</th>
										</tr>
										<?php
										$db_proof = $user_idProof->result();
										if ($db_proof == '') {
											?>
											<img src="<?php echo base_url(); ?>images/users/proof.png"
												 style="width: 242px;">
											<?php
										} else {
											?>
											<tr>
											<?php
											$i = 1;
											foreach ($user_idProof->result() as $post) {
												$img_formats = array("jpg", "png", "gif", "jpeg");
												$txt_formats = array("txt");
												$pdf_formats = array("pdf");
												$word_formats = array("doc", "docx");
												$file_ext = explode('.', $post->proof_file);
												if (in_array($file_ext[1], $img_formats))    /*check the file is image or not*/ {
													?>
													<td><?php echo $i; ?></td>
													<td>
														<?php
														$proof_title = '';
														if ($post->proof_type == '1')
															$proof_title = "Passport";
														elseif ($post->proof_type == '2')
															$proof_title = "Voter ID";
														elseif ($post->proof_type == '3')
															$proof_title = "Driving Licence";
														echo $proof_title;
														?>
													</td>
													<td>
														<img src="<?php if ($post->proof_file == '') {
															echo base_url() . 'images/proofs/proof.png';
														} else {
															echo base_url(); ?>images/proofs/<?php echo $post->proof_file;
														} ?>" width="150px" alt="Proof"/>
													</td>
													<td>
														<div class="verified_unverified">
															<?php
															$idstschk = "";
															if ($post->id_proof_status == 'Verified') {
																$idstschk = checked;
															}
															echo form_input(array(
																'type' => 'checkbox',
																'id' => 'active_inactive_active',
																'name' => 'status[' . $post->id.']',
																'class' => 'verified_unverified',
																'onchange' => 'SaveProofStatus();',
																$idstschk => $idstschk
															));
															echo form_input(array(
																'type' => 'hidden',
																'value' => $post->id,
																'name' => 'id[]'
															));
															?>
															<span id="showErr"></span><br>
														<small  class="err" style="color: red;">Note: Please choose <b>Allow Another Proof To Submit</b> when you change status as Unverfied</small>
														</div>
														<span id="showErr"></span>
													</td>
													<?php
												} else if (in_array($file_ext[1], $txt_formats)) {
													?>
													<td><?php echo $i; ?> </td>
													<td>
														<?php
														$proof_title = '';
														if ($post->proof_type == '1')
															$proof_title = "Passport";
														elseif ($post->proof_type == '2')
															$proof_title = "Voter ID";
														elseif ($post->proof_type == '3')
															$proof_title = "Driving Licence";
														echo $proof_title; ?>
													</td>
													<td>
														<a href="<?php if ($post->proof_file == '') {
															echo base_url() . 'image/proofs/txt_thumb.png';
														} else {
															echo base_url() . ID_PROOF_PATH . $post->proof_file;
														} ?>" target="_blank"><?php echo $post->proof_file; ?></a>
													</td>
													<td>
														<div class="verified_unverified">
															<?php
															$idstschk1 = "";
															if ($post->id_proof_status == 'Verified') {
																$idstschk1 = checked;
															}
															echo form_input(array(
																'type' => 'checkbox',
																'id' => 'active_inactive_active',
																'name' => 'status[' . $post->id.']',
																'class' => 'verified_unverified',
																'onchange' => 'SaveProofStatus();',
																$idstschk1 => $idstschk1
															));
															echo form_input(array(
																'type' => 'hidden',
																'value' => $post->id,
																'name' => 'id[]'
															));
															?>
														</div>
														<span id="showErr"></span>
													</td>
													<?php
												} else if (in_array($file_ext[1], $pdf_formats)) {
													?>
													<td><?php echo $i; ?></td>
													<td>
														<?php
														$proof_title = '';
														if ($post->proof_type == '1')
															$proof_title = "Passport";
														elseif ($post->proof_type == '2')
															$proof_title = "Voter ID";
														elseif ($post->proof_type == '3')
															$proof_title = "Driving Licence";
														echo $proof_title; ?> </td>
													<td>
														<a href="<?php if ($post->proof_file == '') {
															echo base_url() . 'images/proofs/pdf_thumb.png';
														} else {
															echo base_url() . ID_PROOF_PATH . $post->proof_file;
														} ?>" target="_blank"><?php echo $post->proof_file; ?></a>
													</td>
													<td>
														<div class="verified_unverified">
															<?php
															$idstschk2 = "";
															if ($post->id_proof_status == 'Verified') {
																$idstschk2 = checked;
															}
															echo form_input(array(
																'type' => 'checkbox',
																'id' => 'active_inactive_active',
																'name' => 'status[' . $post->id.']',
																'class' => 'verified_unverified',
																'onchange' => 'SaveProofStatus();',
																$idstschk2 => $idstschk2
															));
															echo form_input(array(
																'type' => 'hidden',
																'value' => $post->id,
																'name' => 'id[]'
															));
															?>
														</div>
														<span id="showErr"></span>
													</td>
												<?php } else if (in_array($file_ext[1], $word_formats)) {
													?>
													<td><?php echo $i; ?> </td>
													<td>
														<?php
														$proof_title = '';
														if ($post->proof_type == '1')
															$proof_title = "Passport";
														elseif ($post->proof_type == '2')
															$proof_title = "Voter ID";
														elseif ($post->proof_type == '3')
															$proof_title = "Driving Licence";
														echo $proof_title; ?> </td>
													<td>
														<a href="<?php if ($post->proof_file == '') {
															echo base_url() . 'images/verify-images/word_thumb/word_thumb.jpg';
														} else {
															echo base_url() . ID_PROOF_PATH . $post->proof_file;
														} ?>" target="_blank"><?php echo $post->proof_file; ?></a>
													</td>
													<td>
														<div class="verified_unverified">
															<?php
															$idstschk2 = "";
															if ($post->id_proof_status == 'Verified') {
																$idstschk2 = checked;
															}
															echo form_input(array(
																'type' => 'checkbox',
																'id' => 'active_inactive_active',
																'name' => 'status[' . $post->id.']',
																'class' => 'verified_unverified',
																'onchange' => 'SaveProofStatus();',
																$idstschk2 => $idstschk2
															));
															echo form_input(array(
																'type' => 'hidden',
																'value' => $post->id,
																'name' => 'id[]'
															));
															?>
														</div>
														<span id="showErr"></span>
													</td>
												<?php }
												?>  </tr><?php
												$i++;
											}
										}
										?>
										<div class="form_grid_12" id="allowSubmit">
											<?php
											echo form_label('Allow Another Proof to Submit', 'declineStatus',
												$commonclass);
											?>

											<div class="form_input">
												<div class="yes_no">

                                                    <input type="checkbox"  name="decline_status" id="yesNoCheck" <?php if ($post->decline_status=='Yes') { ?> checked="checked" <?php } ?> class="yes_no"/>

                                                    <?php
													echo form_input(array(
														'type' => 'hidden',
														'value' => $user_idProof->row()->user_id,
														'name' => 'user_id'
													));
													?>
												</div>
											</div>
											<hr>
										</div>
										<br><br><br>
									</table>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input" style="text-align: right; display:none" id="submit_btn">
										<?php
										echo form_input(array(
											'type' => 'submit',
											'name' => 'submit',
											'value' => 'Submit',
											'id' => 'formSub',
											'class' => 'btn_small btn_blue nxtTab'
										));
										?>
									</div>
								</div>
							</li>
						</ul>
						</form>
					</div>
					<!--//id verify-->
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>
<!-- Script to validate password -->
<script type="text/javascript">
	function checkPassword() {
		if ($('#admin-pass').val().length < 8) {
			alert('Password should be 8 charecter and both same!');
			return false;
		}

		if ($('#admin-pass').val() != $('#admin-cnfm-pass').val()) {
			alert('Password should be same as above given password!');
			return false;
		}
		else return true;
	}
</script>
<script>
	$('#edituser_form').validate();
</script>
<script>
	$(document).ready(function () {
		$('.yes_no').click(function () {
			if ($('#yesNoCheck').is(":checked")) {
				$(".verified_unverified").css("display", "none");
				$("#showErr").html("UnVerified");

			}
			else {
				$(".verified_unverified").css("display", "block");
				$("#showErr").html("");

			}
			$("#submit_btn").show();
		});
	});

	$('.verified_unverified').click(function () {
		$("#submit_btn").show();
	});
</script>
<!-- Script to validate form inputs -->
<script>
	$("#full_name").on('keyup', function (e) {
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) {
			document.getElementById("full_name_error").style.display = "inline";
			$("#full_name").focus();
			$("#full_name_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#last_name").on('keyup', function (e) {
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) {
			document.getElementById("last_name_error").style.display = "inline";
			$("#last_name").focus();
			$("#last_name_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#phone_no").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^+0-9\s]/g)) {
			document.getElementById("phone_no_error").style.display = "inline";
			$("#phone_no").focus();
			$("#phone_no_error").fadeOut(5000);
			$(this).val(val.replace(/[^+0-9\s]/g, ''));
		}
	});


	$("#accno").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9-\s()]/g)) {
			document.getElementById("accno_error").style.display = "inline";
			$("#accno").focus();
			$("#accno_error").fadeOut(5000);
			$(this).val(val.replace(/[^0-9-\s()]/g, ''));
		}
	});

	$("#accname").on('keyup', function (e) {
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) {
			document.getElementById("accname_error").style.display = "inline";
			$("#accname").focus();
			$("#accname_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});

	$("#bankname").on('keyup', function (e) {
		var numers = /[0-9]+$/;
		var val = $(this).val();
		if (numers.test(val)) {
			document.getElementById("bankname_error").style.display = "inline";
			$("#bankname").focus();
			$("#bankname_error").fadeOut(5000);
			$(this).val(val.replace(/[0-9]+$/, ''));
		}
	});
</script>
<!-- Script to validate and upload image -->
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
						if (height > 272 || width > 272) {
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

	function SaveProofStatus() {
		alert();
	}
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