<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
if ($this->lang->line('Verified') != '') {
	$Verified = stripslashes($this->lang->line('Verified'));
} else {
	$Verified = "Verified";
}
if ($this->lang->line('NotVerified') != '') {
	$NotVerified = stripslashes($this->lang->line('NotVerified'));
} else {
	$NotVerified = "Not Verified";
}
?>
<section>
	<div class="container">
		<div class="loggedIn clear">
			<div class="width20">
				<ul class="sideBarMenu">
					<li>
						<a href="<?php echo base_url(); ?>settings" <?php if ($this->uri->segment(1) == 'settings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('EditProfile') != '') {
								echo stripslashes($this->lang->line('EditProfile'));
							} else echo "Edit Profile"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>photo-video" <?php if ($this->uri->segment(1) == 'photo-video') { ?> class="active" <?php } ?>><?php if ($this->lang->line('photos') != '') {
								echo stripslashes($this->lang->line('photos'));
							} else echo "Photos"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>verification" <?php if ($this->uri->segment(1) == 'verification') { ?> class="active" <?php } ?>><?php if ($this->lang->line('TrustandVerification') != '') {
								echo stripslashes($this->lang->line('TrustandVerification'));
							} else echo "Trust and Verification"; ?></a></li>
					<li>
						<a href="<?php echo base_url(); ?>display-review" <?php if ($this->uri->segment(1) == 'display-review') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {
								echo stripslashes($this->lang->line('Reviews'));
							} else echo "Reviews"; ?></a></li>
					<li>
						<a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {
								echo stripslashes($this->lang->line('ViewProfile'));
							} else echo "View Profile"; ?></a></li>
				</ul>
			</div>
			<div class="width80">
				<div class="panel panel-default">
					<div class="panel-heading"><?php if ($this->lang->line('VerifyyourID') != '') {
							echo stripslashes($this->lang->line('VerifyyourID'));
						} else echo "Verify Your ID"; ?></div>
					<div class="panel-body">
						<p><?php if ($this->lang->line('GettingyourVerified') != '') {
								echo stripslashes($this->lang->line('GettingyourVerified'));
							} else echo "Getting your Verified ID is the easiest way to help build trust in the community. We'll verify you by matching information from an online account to an official ID."; ?></p>
						<p><?php if ($this->lang->line('youwantbelow') != '') {
								echo stripslashes($this->lang->line('youwantbelow'));
							} else echo "Or, you can choose to only add the verifications you want below."; ?></p>
						<div class="marginBottom3">
							<?php
							if ($UserDetail->row()->id_verified == 'Yes') {
								?><a href="javascript:void(0);"><img
									src="<?php echo base_url(); ?>images/verifiedIcon.png"
									width="25"> <?php if ($this->lang->line('Verified') != '') {
									echo stripslashes($this->lang->line('Verified'));
								} else echo "Verified"; ?></a><?php
							} else {
								?>
								<a href="verification/verify-mail"><img
										src="<?php echo base_url(); ?>images/unverified150x50.png"
										width="25"> <?php if ($this->lang->line('Verifyme') != '') {
										echo stripslashes($this->lang->line('Verifyme'));
									} else echo "Verify me"; ?></a>
								<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="panel panel-default" >
					<div class="panel-heading"><?php if ($this->lang->line('Verifications') != '') {
							echo stripslashes($this->lang->line('Verifications'));
						} else echo "Verifications"; ?></div>
					<div class="panel-body">
						<?php
						$eVerify = $userDetails->row()->id_verified;
						$eV = ($eVerify == 'Yes') ? $Verified : $NotVerified;
						$eVImage = ($eVerify == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png';
						$pVerify = $userDetails->row()->ph_verified;
						$pV = ($pVerify == 'Yes') ? $Verified : $NotVerified;
						$pVImage = ($pVerify == 'Yes') ? 'verifiedIcon.png' : 'unverified150x50.png';
						?>
						<p><?php if ($this->lang->line('EmailAddressVerification') != '') {
								echo stripslashes($this->lang->line('EmailAddressVerification'));
							} else echo "Email Address Verification"; ?></p>
						<div class="marginBottom3">
							<img src="<?php echo base_url(); ?>images/<?php echo $eVImage; ?>"
								 width="25"> <?php echo $eV; ?>
						</div>
						<p><?php if ($this->lang->line('PhoneNumberVerification') != '') {
								echo stripslashes($this->lang->line('PhoneNumberVerification'));
							} else echo "Email Phone Number Verification"; ?></p>
						<div class="marginBottom3">
							<img src="<?php echo base_url(); ?>images/<?php echo $pVImage; ?>"
								 width="25"> <?php echo $pV; ?>
						</div>
					</div>
				</div>
				<div class="panel panel-default">




					<div class="panel-heading"><?php if ($this->lang->line('PhoneNumberVerification') != '') {
								echo stripslashes($this->lang->line('PhoneNumberVerification'));
							} else echo "Phone Number Verification"; ?></div>
					<div class="panel-body">
						<?php
						if ($pVerify != 'Yes') {
							?>

							<h5><?php if ($this->lang->line('PhoneNumber') != '') {
								echo stripslashes($this->lang->line('PhoneNumber'));
							} else echo "Phone Number"; ?></h5>
							<p><?php if ($this->lang->line('Makeit') != '') {
									echo stripslashes($this->lang->line('Makeit'));
								} else echo "Make it easier to communicate with a verified phone number. We’ll send you a code by SMS or read it to you over the phone. Enter the code below to confirm that you’re the person on the other end."; ?></p>
							<p><?php if ($this->lang->line('Restassured') != '') {
									echo stripslashes($this->lang->line('Restassured'));
								} else echo "Rest assured, your number is only shared with another member once you have a confirmed booking."; ?></p>
							<div class="row phoneVer">
								<div class="col-sm-4">
									<label><?php if ($this->lang->line('Chooseacountry') != '') {
											echo stripslashes($this->lang->line('Chooseacountry'));
										} else echo "Choose a country:"; ?></label>
									<?php
									$countryOptions = array();
									$countryOptions[''] = 'Select';
									$choosedOption = $this->config->item('admin_country_code');
									foreach ($active_countries->result() as $active_country) {
										$countryOptions[$active_country->id] = $active_country->name;
									}
									echo form_dropdown('phone_country', $countryOptions, $choosedOption, array('onchange' => 'get_mobile_code(this.value)'));
									?>
								</div>
								<div class="col-sm-5">
									<label><?php if ($this->lang->line('') != 'Addaphonenumber') {
											echo stripslashes($this->lang->line('Addaphonenumber'));
										} else echo "Add a phone number"; ?></label>
									<div class="phoneNumber">
										<span class="code">+91</span>
									<?php if($userDetails->row()->phone_no == '') {?>
										<span class="code">+ 1</span>
									<?php } ?>
										<?php if ($this->lang->line('') != 'enter_phone_number') {
											$entr= stripslashes($this->lang->line('enter_phone_number'));
											} else $entr= "Enter Phone Number"; ?>

										<?php
										echo form_input('phone_number', $userDetails->row()->phone_no, array('id' => 'phone_number', 'placeholder' => "$entr", 'class' => 'num'));
										echo form_input(array('type' => 'hidden', 'id' => 'admin_country', 'value' => $choosedOption));
										?>
									</div>
								</div>
								<div class="col-sm-3">
									<input type="button" class="submitBtn1" id="verify_sms"
										   value="<?php if ($this->lang->line('VerifyviaSMS') != '') {
											   echo stripslashes($this->lang->line('VerifyviaSMS'));
										   } else echo "Verify via SMS"; ?>" name="">
								</div>
							</div>
						<?php } else {
							echo form_input('used_number', $userDetails->row()->phone_no, array('class' => 'num', 'readonly' => 'readonly'));
							?>
							<input type="button" class="submitBtn1" onclick="changePhone();"
								   value="<?php if ($this->lang->line('PhoneNumberisVerified') != '') {
									   echo stripslashes($this->lang->line('PhoneNumberisVerified'));
								   } else echo "Phone Number is Verified"; ?>" name="">
							<?php
							echo form_input(array('type' => 'hidden', 'id' => 'admin_country', 'value' => $choosedOption));
						} ?>
					</div>
				</div>

				    	<div class="phone-number-verify-widget verification_div phoneVer col-sm-12" style="margin: 12px 12px;display: none;">
						    <p class="message message_sent"></p>

						    <label class="col-sm-12" for="phone_number_verification">Please enter the 6-digit code:</label>
						    <div class="col-sm-12">
						    <div class="col-sm-4">
						    <input type="text" id="mobile_verification_code" class="num">
						</div>
						 <div class="col-sm-4">
						     <a href="javascript:void(0);" style="margin: 0 ;" class="submitBtn1" onclick="check_phpone_verification()" rel="verify">
						        <?php if($this->lang->line('Verify') != '') { echo stripslashes($this->lang->line('Verify')); } else echo "Verify";?>
						      </a>
						  </div> <div class="col-sm-4">
						      <a style="margin: 0 ;" href="javascript:void(0);" class="submitBtn1" onclick="cancel_verification();">
						        <?php if($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel";?>
						      </a>
						    </div>
						    
						</div>
						<p class="arrive"><?php if($this->lang->line('arrival_text') != '') { echo stripslashes($this->lang->line('arrival_text')); } else echo "If it doesn't arrive, click cancel and try call verification instead.";?></p>
						</div>
					
				<div class="panel panel-default" id="verification_list">
					<div class="panel-heading"><?php if ($this->lang->line('License_Reg_verification') != '') {
									   echo stripslashes($this->lang->line('License_Reg_verification'));
								   } else echo "Real Estate License Registration Document Verification"; ?></div>
					<div class="panel-body">
						<!--Proof upload-->
						<div
							id="proofUpload" <?php if ($proofDetails->row()->decline_status == 'Yes' && $proofDetails->row()->id_proof_status == 'UnVerified') {
							echo 'style="display:none;"';
						} else if ($proofDetails->row()->id_proof_status == 'UnVerified' || $proofDetails->row()->id_proof_status == 'OnRequest' || $proofDetails->row()->id_proof_status == 'Verified') {
							echo 'style="display:none;"';
						} ?> >
							<!-- id="head"-->
							<div
								id="head" <?php if ($proofDetails->row()->decline_status == 'Yes' && $proofDetails->row()->id_proof_status == 'UnVerified') {
								echo 'style="display:block;"';
							} else if ($proofDetails->row()->id_proof_status == 'UnVerified' || $proofDetails->row()->id_proof_status == 'OnRequest' || $proofDetails->row()->id_proof_status == 'Verified') {
								echo 'style="display:none;"';
							} ?> >
								<h3 class="bold-verify"><?php if ($this->lang->line('upload_your_documents') != '') {
										echo stripslashes($this->lang->line('upload_your_documents'));
									} else echo "Upload your Documents"; ?>
									(<?php if ($this->lang->line('goverment_id') != '') {
										echo stripslashes($this->lang->line('goverment_id'));
									} else echo "Goverment Id"; ?>)</h3>
								<div class="passport-verification"><?php if ($this->lang->line('upload_proof') != '') {
										echo stripslashes($this->lang->line('upload_proof'));
									} else echo "Upload the picture of your official id such as Passport or Voter ID"; ?></div>
							</div>
							<p class="msgverif"><?php echo $msg; ?></p>
							<p id='checkedValue'></p>
							<form action="<?= base_url(); ?>site/user/upload_id_proof" method="POST" id='form_id'
                                  enctype="multipart/form-data" accept-charset="UTF-8">
								<ul id="listoption" <?php if ($proofDetails->row()->decline_status == 'Yes') {
									'style="display:block;"';
								} else if ($proofDetails->row()->id_proof_status == 'UnVerified' || $proofDetails->row()->id_proof_status == 'OnRequest' || $proofDetails->row()->id_proof_status == 'Verified') {
									echo 'style="display:none;"';
								} ?> >
									<li>
										<label for='option1' class="radioStyle default">
											<div class="radiolbl-verification">
												<input type="radio" value="1" id="option1" name="option" checked
													   required/>
												<span class="checkmark"></span>
												<span>
													<?php if ($this->lang->line('passport') != '') {
														echo stripslashes($this->lang->line('passport'));
													} else echo "Passport"; ?>
												</span>
											</div>
										</label>
									</li>
									<li>
										<label for='option2' class="radioStyle default">
											<div class="radiolbl-verification">
												<input type="radio" value="2" id="option2" name="option" required/>
												<span class="checkmark"></span>
												<span>
													<?php if ($this->lang->line('voter_id') != '') {
														echo stripslashes($this->lang->line('voter_id'));
													} else echo "Voter ID"; ?>
												</span>
											</div>
										</label>
									</li>
									<li>
										<label for='option3' class="radioStyle default">
											<div class="radiolbl-verification" >
												<input type="radio" value="3" id="option3" name="option" required/>
												<span class="checkmark"></span>
												<span>
													<?php if ($this->lang->line('driving_licence') != '') {
														echo stripslashes($this->lang->line('driving_licence'));
													} else echo "Driving Licence"; ?>
												</span>
											</div>
										</label>
									</li>
								</ul>
								<!--<input type="text" name="country" id="country" placeholder="Enter your country" required> -->
								<div id="SubmitBtn" <?php if ($proofDetails->row()->decline_status == 'Yes') {
									'style="display:block;"';
								} else if ($proofDetails->row()->id_proof_status == 'UnVerified' || $proofDetails->row()->id_proof_status == 'OnRequest' || $proofDetails->row()->id_proof_status == 'Verified') {
									echo 'style="display:none;"';
								} ?> >
									<div class="verification-uploadimg">
										<input type="file" name="proof_file" class="fileStyle marginBottom2" required id="proof_file"/>
										<b><?php if ($this->lang->line('note') != '') {
												echo stripslashes($this->lang->line('note'));
											} else echo "Note"; ?> : </b>
										<small><?php if ($this->lang->line('err_upload_proof') != '') {
												echo stripslashes($this->lang->line('err_upload_proof'));
											} else echo "Please upload jpg,gif,png or pdf,doc file to verification, File size limit it 2 mb"; ?></small>
										<br><br>
										<b><?php if ($this->lang->line('note') != '') {
												echo stripslashes($this->lang->line('note'));
											} else echo "Note"; ?> : </b>
										<small><?php if ($this->lang->line('once_you_uploaded') != '') {
												echo stripslashes($this->lang->line('once_you_uploaded'));
											} else echo "Once You Upload Proof you cannot able to edit Until Admin Gives Acceptance"; ?> </small>
									</div>
									<div class="marginTop_1">
										<button class="submitBtn1" type="button"
												onclick="checkProofAvailability();"><?php if ($this->lang->line('Submit') != '') {
												echo stripslashes($this->lang->line('Submit'));
											} else echo "Submit"; ?> </button>
									</div>
								</div>
							</form>
						</div>
						<!--Proof upload-->
						<?php
						if ($proofDetails->num_rows() > 0) {
							?>
							<div class="table-responsive">
							<table class="table table-bordered table-striped alignLeft">
								<tr>
									<th width="5%"><?php if ($this->lang->line('S.No') != '') {
											echo stripslashes($this->lang->line('S.No'));
										} else echo "S.No"; ?></th>
									<th width="50%"><?php if ($this->lang->line('proof_name') != '') {
											echo stripslashes($this->lang->line('proof_name'));
										} else echo "Proof Name"; ?></th>
									<th width="25%"><?php if ($this->lang->line('file') != '') {
											echo stripslashes($this->lang->line('file'));
										} else echo "File"; ?></th>
									<th width="20%"><?php if ($this->lang->line('Status') != '') {
											echo stripslashes($this->lang->line('Status'));
										} else echo "Status"; ?></th>
								</tr>
								<?php
								$img_type = array('gif', 'jpg', 'png', 'bmp', 'jpeg');
								$doc_type = array('doc', 'docx');
								$pdf_type = 'pdf';
								$i = 1;
								foreach ($proofDetails->result() as $proof) {
									$file_ar = explode('.', $proof->proof_file);
									$file_ext = end($file_ar);
									$proof_title = '';
									if ($proof->proof_type == '1')
										$proof_title = "Passport";
									elseif ($proof->proof_type == '2')
										$proof_title = "Voter ID";
									elseif ($proof->proof_type == '3')
										$proof_title = "Driving Licence";
									if ($proof->proof_status == 'P')
										$proof_status = 'Not Verified';
									elseif ($proof->proof_status == 'CL')
										$proof_status = 'Cancelled';
									elseif ($proof->proof_status == 'V')
										$proof_status = 'Verified';
									else
										$proof_status = 'Not Done';
									?>
									<tr>
										<td><?= $i; ?></td>
										<td><?= $proof_title; ?></td>
										<td>
											<?php
											if (in_array($file_ext, $img_type)) {
												?>
												<img src="<?php echo ID_PROOF_PATH . $proof->proof_file; ?>"
													 width="50"/>
												<?php
											} elseif (in_array($file_ext, $doc_type)) {
												?><a href='<?php echo ID_PROOF_PATH . $proof->proof_file; ?>'
													 target='_blank'>
												<img width="50" src="<?= base_url(); ?>images/document.png"
													 width='100'/> </a>
												<?php
											} elseif ($file_ext == $pdf_type) {
												?><a href='<?php echo ID_PROOF_PATH . $proof->proof_file; ?>'
													 target='_blank'>
												<img width="50" src="<?= base_url(); ?>images/document.png"
													 width='100'/> </a>
												<?php
											}
											?>
										</td>
										<td><?php
											if ($proof->id_proof_status == 'UnVerified' && $proof->decline_status == 'Yes') { ?>
												<button class="btn btn-warninge" type="button" onclick="showUpload();"
														id="newUpload"><?php if ($this->lang->line('upload_new_proof') != '') {
														echo stripslashes($this->lang->line('upload_new_proof'));
													} else echo "Upload New Proof"; ?> </button>
												<span id="uploadNewProof">	</span>
											<?php } else if ($proof->id_proof_status == 'OnRequest') { ?>
												<div
													id="request_id"><?php if ($this->lang->line('request_sent') != '') {
														echo stripslashes($this->lang->line('request_sent'));
													} else echo "Request Sent"; ?> </div>
											<?php } else if ($proof->id_proof_status == 'Verified') { ?>
												<div id="verified_id"><?php if ($this->lang->line('Verified') != '') {
														echo stripslashes($this->lang->line('Verified'));
													} else echo "Verified"; ?> </div>
												<br><br>
											<?php } else if ($proof->id_proof_status == 'UnVerified') { ?>
												<button class="btn btn-warninge" type="button"
														id="request_id"> <?php if ($this->lang->line('UnVerified') != '') {
														echo stripslashes($this->lang->line('UnVerified'));
													} else echo "UnVerified"; ?> </button>
											<?php } ?>
										</td>
									</tr>
									<?php
									$i++;
								}
								?>
							</table>
						</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
	function changePhone() {
		var confirm_change = confirm('<?php if ($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?') != '') {
			echo stripslashes($this->lang->line('Your_current_phone_number_is_verfied_actually_Are_you_sure_you_want_to_change_it?'));
		} else echo "Your current phone number is verfied actually, Are you sure,you want to change it?";?>');
		if (confirm_change) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>site/user_settings/allow_changePhone',
				data: {data: '1'},
				success: function (response) {
					if (response.trim() == 'success')
						window.location.reload();
					else
						boot_alert('<?php if ($this->lang->line('sorry_Enable_to_change') != '') {
							echo stripslashes($this->lang->line('sorry_Enable_to_change'));
						} else echo "sorry.Enable to change.";?>');
				}
			});
		} 
	}

	function get_mobile_code(country_id) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>site/twilio/get_mobile_code',
			data: {country_id: country_id},
			dataType: 'json',
			success: function (response) {
				$('.code').text(response['country_mobile_code']);
			}
		});
	}

	$('#verify_sms').click(function () {
//$('.verification_div').css('display', 'block');
		var mobile_code = $('.code').text();
		var phone_number = $('#phone_number').val();
		if (phone_number == '') {
			boot_alert('<?php if ($this->lang->line('Please_Enter_Phone_Number') != '') {
				echo stripslashes($this->lang->line('Please_Enter_Phone_Number'));
			} else echo "Please Enter Phone Number";?>');
		}
		else if (isNaN(phone_number) || phone_number.length < 8 || phone_number.length > 10) {
			boot_alert('<?php if ($this->lang->line('Phone_Number_Should_be_Valid') != '') {
			echo stripslashes($this->lang->line('Phone_Number_Should_be_Valid'));
		} else echo "Phone Number Should be Valid";?>');
		}
		else {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url();?>site/twilio/product_verification',
				data: {phone_no: phone_number, mobile_code: mobile_code},
				success: function (response) {
					response = response.trim();
					if (response == 'success') {
						boot_alert('<?php if ($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code') != '') {
							echo stripslashes($this->lang->line('We_Have_Sent_Verification_Code_to_Your_Mobile_Please_Enter_Verification_Code'));
						} else echo "We Have Sent Verification Code to Your Mobile Please Enter Verification Code";?>');

						$('.message_sent').text('<?php if ($this->lang->line('We_sent_a_verification_code_to') != '') {
							echo stripslashes($this->lang->line('We_sent_a_verification_code_to'));
						} else echo "We sent a verification code to"; echo " ";?>' + phone_number);

						$('.verification_div').css('display', 'block');
					}
				}
			});
		}
	});

	/*Proof verification*/
	function checkProofAvailability() {
		var choices = '';
		var els = document.getElementsByName('option');
		for (var i = 0; i < els.length; i++) {
			if (els[i].checked) {
				choices = els[i].value;
			}
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>site/user/checkUserProof',
			data: {proof_type: choices},
			success: function (response) {
				if (response.trim() == 'exist') {
					if (confirm("<?php if ($this->lang->line('rewrite_existing_one') != '') {
							echo stripslashes($this->lang->line('rewrite_existing_one'));
						} else echo "Proof for this type is already submitted. Do you want rewrite the existing one?";?> ")) {
						allowfn();
					} else {
						boot_alert("<?php if ($this->lang->line('choose_another_proof') != '') {
							echo stripslashes($this->lang->line('choose_another_proof'));
						} else echo "Please choose another proof type.";?>");
					}
				} else {
					//
					allowfn();
				}
			}
		});
	}

	function allowfn() {
		if (document.getElementById("proof_file").files.length == 0) {
			boot_alert("<?php if ($this->lang->line('choose_file') != '') {
				echo stripslashes($this->lang->line('choose_file'));
			} else echo "Please Choose File";?>");
			return false;
		} else {
			if (confirm("<?php if ($this->lang->line('request_to_admin') != '') {
					echo stripslashes($this->lang->line('request_to_admin'));
				} else echo "Are you sure want to send request to admin?";?>")) {
				 $('.loading').show();
				$("#form_id").submit();
			}
		}
	}

        function showUpload(){
            if (confirm("<?php if($this->lang->line('upload_new_proof') != '') { echo stripslashes($this->lang->line('upload_new_proof')); } else echo "Are You Want to upload a new proof?"; ?>")) {
                document.getElementById("proofUpload").style.display = "block";
                document.getElementById("newUpload").style.display = "none";
                $('#uploadNewProof').html('Upload New Proof');
            }else{

            }
        }
        function cancel_verification()
{
$('.verification_div').css('display','none');
}

function check_phpone_verification()
{
 mobile_verification_code=$('#mobile_verification_code').val();
$.ajax({
type:'POST',
url:'<?php echo base_url()?>site/product/check_phone_verification',
data:{mobile_verification_code:mobile_verification_code},
success:function(response)
{ 
response=response.trim();
if(response=='success')
{
window.location.reload(true);
}
else{
alert('<?php if($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code') != '') { echo stripslashes($this->lang->line('Verification_Code_Does_not_match_Please_enter_Correct_Code')); } else echo "Verification Code Does not match Please enter Correct Code";?>');
}

}
}); 

}

</script>
<?php
$this->load->view('site/includes/footer');
?>
