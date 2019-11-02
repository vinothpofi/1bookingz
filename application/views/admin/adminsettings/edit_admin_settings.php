<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_wrap tabby">
					<div class="widget_top"><span class="h_icon list"></span>
						<h6>Global Site Configuration</h6>
						<div id="widget_tab">
							<ul>
								<li><a href="#tab1" class="active_tab">Admin Settings</a></li>
								<li><a href="#tab2">Social Media Settings</a></li>
								<li><a href="#tab3">Google Webmaster & SEO</a></li>
							</ul>
						</div>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
						echo form_open_multipart('admin/adminlogin/admin_global_settings', $attributes);
						echo form_input([
							'type' => 'hidden',
							'name' => 'form_mode',
							'value' => 'main_settings'
						]);
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
										$commonclass = array('class' => 'field_title');
										echo form_label('Admin Name <span
												class="req">*</span>', 'Admin Name',
											$commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'text',
												'id' => 'admin_name',
												'name' => 'admin_name',
												'tabindex' => '1',
												'class' => 'required large tipTop',
												'title' => 'Please enter the admin username',
												'value' => $admin_settings->row()->admin_name
											]);
											$errorlbl = array('id' => 'name_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special
												Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Email Address <span
												class="req">*</span>', 'email',
											$commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'text',
												'id' => 'email',
												'name' => 'email',
												'tabindex' => '2',
												'class' => 'required large tipTop',
												'title' => 'Please enter the admin email address',
												'value' => $admin_settings->row()->email
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Admin Default Currency <span
												class="req">*</span>', 'admin_currencyCode',
											$commonclass);
										?>
										<div class="form_input">
											<?php
											if ($admin_settings->row()->admin_currencyCode == '') {
												?>
												<select name="admin_currencyCode" id="admin_currencyCode" required>
													<option value="">select</option>
													<?php foreach ($currency_list->result() as $currency) { ?>
														<option
															value="<?php echo $currency->currency_type; ?>" <?php if ($admin_settings->row()->admin_currencyCode == $currency->currency_type) echo 'selected="selected"'; ?>><?php echo $currency->currency_type; ?></option>
													<?php } ?>
												</select>
											<?php } else {
												echo $admin_settings->row()->admin_currencyCode;
											} ?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Instant Pay <span
												class="req">*</span>', 'admin_name',
											$commonclass);
										?>
										<div class="form_input">
											<?php
											if (!empty($instant_pay)) {
												if ($instant_pay->row()->status == '1') {
													$instpayattr = array('tabindex' => '11');
													echo form_radio('instant_pay', '1', TRUE, $instpayattr);
												} else {
													$instpayattr = array('tabindex' => '11');
													echo form_radio('instant_pay', '1', FALSE, $instpayattr);
												}
											}
											?>
											Enable
											<?php
											if (!empty($instant_pay)) {
												if ($instant_pay->row()->status == '0') {
													$instpayattr = array('tabindex' => '11');
													echo form_radio('instant_pay', '0', TRUE, $instpayattr);
												} else {
													$instpayattr = array('tabindex' => '11');
													echo form_radio('instant_pay', '0', FALSE, $instpayattr);
												}
											}
											?>
											Disable
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Site Contact Email', 'site_contact_mail', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'email',
												'id' => 'site_contact_mail',
												'name' => 'site_contact_mail',
												'tabindex' => '3',
												'class' => 'large tipTop',
												'title' => 'Please enter the site contact email',
												'value' => $admin_settings->row()->site_contact_mail
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Site Name', 'email_title', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'text',
												'id' => 'email_title',
												'name' => 'email_title',
												'tabindex' => '4',
												'class' => 'large tipTop',
												'title' => 'Please enter the site name',
												'value' => $admin_settings->row()->email_title
											]);
											$errorlbl = array('id' => 'site_name_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special
												Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>

								</li>
								<li>
									
									<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("email_title","") as $dynlang) {

									$commonclass = array('class' => 'field_title');

									echo form_label('Site Name ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the site name in '.$dynlang[0],
												'required' => 'required',
												
												'value'	   => $admin_settings->row()->{$dynlang[1]}
									    ]);
									?>
								</div>
							<?php } ?>
							</div>
								</li>
                                <li>
                                    <div class="form_grid_12">
                                        <?php

                                        echo form_label('Contact Us','contact_us_address', $commonclass);
                                        ?>
                                        <div class="form_input margin_cls">
                                            <?php

                                            $descattr=array(
                                                'style'    => 'width:295px;',
                                                'class'    => 'large tipTop mceEditor',
                                                'title'    => 'Please enter the contact_us_address',
                                                'tabindex' => '4'
                                            );

                                            echo form_textarea('contact_us_address', $admin_settings->row()->contact_us_address, $descattr);
                                            ?>
                                        </div>
                                    </div>
                                </li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Site Status', 'site_status', $commonclass);
										?>
										<div class="form_input">
											<select id="site_status" name="site_status" required>
												<option value="">--Select--</option>
												<option value="1" <?php if($admin_settings->row()->site_status == 1){ echo 'selected'; } ?>>Live</option>
												<option value="2" <?php if($admin_settings->row()->site_status == 2){ echo 'selected'; } ?>>Demo</option>
											</select>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Logo (Must Be 240*40)', 'logo_image', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'file',
												'id' => 'logo_image',
												'name' => 'logo_image',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please select the logo image'
											]);
											?>
										</div>
										<div class="form_input">
											<img
												src="<?php echo base_url(); ?>images/logo/<?php echo $admin_settings->row()->logo_image; ?>"
												width="100px"/>
										</div>
									</div>
								</li>
								<!-- <li>
									<div class="form_grid_12">
										<?php
										echo form_label('Home page Logo (Below
											50*50)', 'home_logo_image', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'file',
												'id' => 'home_logo_image',
												'name' => 'home_logo_image',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please select the Home Page logo image'
											]);
											?>
										</div>
										<div class="form_input">
											<img
												src="<?php echo base_url(); ?>images/logo/<?php echo $admin_settings->row()->home_logo_image; ?>"
												width="100px"/>
										</div>
									</div>
								</li> -->
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Background Image (Below
											1500*700)', 'background_image', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'file',
												'id' => 'background_image',
												'name' => 'background_image',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please select the Background image'
											]);
											?>
										</div>
										<div class="form_input">
											<img
												src="<?php echo base_url(); ?>images/logo/<?php echo $admin_settings->row()->background_image; ?>"
												width="100px"/>
										</div>
									</div>
								</li>
								<li style="display: none;">
									<div class="form_grid_12">
										<?php
										echo form_label('Banner Video Url', 'videoUrl', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'url',
												'id' => 'videoUrl',
												'name' => 'videoUrl',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please enter Banner Video Url',
												'value' => $admin_settings->row()->videoUrl
											]);
											?>
											<br>
											<?php
											$urlerrlbl = array('class' => 'error');
											echo form_label('Example: http://www.domain.com', '', $urlerrlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Favicon (Below 50*50)', 'fevicon_image', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'file',
												'id' => 'fevicon_image',
												'name' => 'fevicon_image',
												'tabindex' => '6',
												'class' => 'large tipTop',
												'title' => 'Please select the favicon image'
											]);
											?>
										</div>
										<div class="form_input">
											<img
												src="<?php echo base_url(); ?>images/logo/<?php echo $admin_settings->row()->fevicon_image; ?>"
												width="50px"/>
										</div>
									</div>
								</li>
								<li style="display: none;">
									<div class="form_grid_12">
										<?php
										echo form_label('Watermark (Below 50*50)', 'watermark', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'file',
												'id' => 'watermark',
												'name' => 'watermark',
												'tabindex' => '6',
												'class' => 'large tipTop',
												'title' => 'Please select the watermark image'
											]);
											?>
										</div>
										<div class="form_input">
											<img
												src="<?php echo base_url(); ?>images/logo/<?php echo $admin_settings->row()->watermark; ?>"
												width="50px"/>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Footer Content', 'footer_content', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'text',
												'id' => 'footer_content',
												'name' => 'footer_content',
												'tabindex' => '7',
												'class' => 'large tipTop',
												'title' => 'Please enter the footer copyright content',
												'value' => htmlentities($admin_settings->row()->footer_content)
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									
									<div class="form_grid_12">
								<?php  foreach(language_dynamic_enable("footer_content","") as $dynlang) {

									$commonclass = array('class' => 'footer_content');

									echo form_label('Footer Content in ('.$dynlang[0].')<span class="req">*</span>',$dynlang[0], $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'     => 'text',      
									            'name' 	   => $dynlang[1],
									            'id'	   => $dynlang[1],
									            'class'    => 'required large tipTop',
									            'tabindex' => '1',
									            'title'    => 'Please enter the footer content in '.$dynlang[0],
												'required' => 'required',
												
												'value'	   => $admin_settings->row()->{$dynlang[1]}
									    ]);
									?>
								</div>
							<?php } ?>
							</div>
								</li>
								
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Twilio Status', 'twilio_status', $commonclass);
										?>
										<div class="form_input">
											<?php
											$twilstsattr = array('tabindex' => '11', 'onchange' => 'getTwilioStatus(this);');
											if ($admin_settings->row()->twilio_status == '1') {
												echo form_radio('twilio_status', '1', TRUE, $twilstsattr);
											} else {
												echo form_radio('twilio_status', '1', FALSE, $twilstsattr);
											}
											?>
											Enable
											<?php
											if ($admin_settings->row()->twilio_status == '0') {
												echo form_radio('twilio_status', '0', TRUE, $twilstsattr);
											} else {
												echo form_radio('twilio_status', '0', FALSE, $twilstsattr);
											}
											?>
											Disable
										</div>
									</div>
									<?php
									echo form_input([
										'type' => 'hidden',
										'id' => 'twilioState_id',
										'value' => $admin_settings->row()->twilio_status
									]);
									?>
								</li>
								<div id="twilioGroup" style="display:none">
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Twilio Account SID <span
													class="req">*</span>', 'twilio_account_sid', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'type' => 'text',
													'id' => 'twilio_account_sid',
													'name' => 'twilio_account_sid',
													'tabindex' => '7',
													'required' => 'required',
													'class' => 'large tipTop',
													'title' => 'Please enter Twilio Account SID',
													'value' => htmlentities($admin_settings->row()->twilio_account_sid)
												]);
												$errorlbl = array('id' => 'twilio_account_sid_error', 'style' => 'display:none;', 'class' => 'error');
												echo form_label('Special Characters are not allowed!', '',
													$errorlbl);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Twilio Account Auth
												Token <span	class="req">*</span>', 'twilio_account_token', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'type' => 'text',
													'id' => 'twilio_account_token',
													'name' => 'twilio_account_token',
													'tabindex' => '7',
													'required' => 'required',
													'class' => 'large tipTop',
													'title' => 'Please enter Twilio Account Auth Token',
													'value' => htmlentities($admin_settings->row()->twilio_account_token)
												]);
												$errorlbl = array('id' => 'twilio_account_token_error', 'style' => 'display:none;', 'class' => 'error');
												echo form_label('Special Characters are not allowed!', '',
													$errorlbl);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Twilio Phone Number <span	class="req">*</span>', 'twilio_phone_number', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'type' => 'text',
													'id' => 'twilio_phone_number',
													'name' => 'twilio_phone_number',
													'tabindex' => '7',
													'required' => 'required',
													'class' => 'large tipTop',
													'title' => 'Please enter Twilio Phone Number',
													'value' => htmlentities($admin_settings->row()->twilio_phone_number)
												]);
												$errorlbl = array('id' => 'twilio_phone_number_error', 'style' => 'display:none;', 'class' => 'error');
												echo form_label('Special Characters are not allowed!', '',
													$errorlbl);
												?>
											</div>
										</div>
									</li>
								</div>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Pagination Limit for
											Property Filter', 'site_pagination_per_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'site_pagination_per_page',
												'name' => 'site_pagination_per_page',
												'tabindex' => '7',
												'min' => '1',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter pagination limit for Property Filter',
												'value' => htmlentities($admin_settings->row()->site_pagination_per_page)
											]);
											?>
										</div>
									</div>
								</li>
								
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Pagination Limit For The Popular Page <span	class="req">*</span>', 'pagination_for_popular_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'popular_pagination_per_page',
												'name' => 'popular_pagination_per_page',
												'tabindex' => '7',
												'min' => '3',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter pagination limit for popular page',
												'value' => htmlentities($admin_settings->row()->popular_pagination_per_page)
											]);
											$errorlbl = array('id' => 'twilio_phone_number_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Pagination Limit for Places
											Page <span	class="req">*</span>', 'pagination_for_places_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'places_pagination_per_page',
												'name' => 'places_pagination_per_page',
												'tabindex' => '7',
												'min' => '5',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter pagination limit for places page',
												'value' => htmlentities($admin_settings->row()->places_pagination_per_page)
											]);
											$errorlbl = array('id' => 'twilio_phone_number_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Pagination Limit for
											Experiences Page <span	class="req">*</span>', 'pagination_for_experience_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'experiences_pagination_per_page',
												'name' => 'experiences_pagination_per_page',
												'tabindex' => '7',
												'min' => '5',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter pagination limit for Experience page',
												'value' => htmlentities($admin_settings->row()->experiences_pagination_per_page)
											]);
											$errorlbl = array('id' => 'twilio_phone_number_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Pagination Limit for
											WishList Page <span	class="req">*</span>', 'pagination_for_experience_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'wishlist_pagination_per_page',
												'name' => 'wishlist_pagination_per_page',
												'tabindex' => '7',
												'min' => '3',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter pagination limit for wishlist page',
												'value' => htmlentities($admin_settings->row()->wishlist_pagination_per_page)
											]);
											$errorlbl = array('id' => 'twilio_phone_number_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special Characters are not allowed!', '',
												$errorlbl);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Image Compression
											Percentage', 'pagination_for_experience_page', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'image_compress_percentage',
												'name' => 'image_compress_percentage',
												'tabindex' => '8',
												'min' => '0',
												'max' => '100',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Image Compression Percentage',
												'value' => htmlentities($admin_settings->row()->image_compress_percentage)
											]);
											?>%
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Dispute Days', 'dispute_days', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'dispute_days',
												'name' => 'dispute_days',
												'tabindex' => '7',
												'min' => '1',
												'class' => 'large tipTop',
												'title' => 'Please enter Dispute Days',
												'value' => htmlentities($admin_settings->row()->dispute_days)
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Before Number of days to
											allow cancellation<br>(property)', 'property_cancellation', $commonclass);
										?>
										<small>*Cancellation button will be hide before (n) days from booking start
											date
										</small>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'cancel_hide_days_property',
												'name' => 'cancel_hide_days_property',
												'tabindex' => '8',
												'min' => '1',
												'max' => '100',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Number of Days',
												'value' => htmlentities($admin_settings->row()->cancel_hide_days_property)
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Before Number of days to
											allow Host cancellation<br>(property)', 'property_host_cancellation', $commonclass);
										?>
										<small>*Cancellation button will be hide before (n) days from booking start
											date
										</small>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'number',
												'id' => 'cancel_hide_days_property_host',
												'name' => 'cancel_hide_days_property_host',
												'tabindex' => '8',
												'min' => '1',
												'max' => '100',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Number of Days',
												'value' => htmlentities($admin_settings->row()->cancel_hide_days_property_host)
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Before Number of days
											to allow cancellation<br>(experience)', 'experience_cancellation', $commonclass);
										?>
										<small>*Cancellation button will be hide before (n) days from booking start
											date
										</small>
										<div class="form_input">
											<?php
											echo form_input(array(
												'type' => 'number',
												'id' => 'cancel_hide_days_experience',
												'name' => 'cancel_hide_days_experience',
												'tabindex' => '8',
												'min' => '1',
												'max' => '100',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Number of Days',
												'value' => htmlentities($admin_settings->row()->cancel_hide_days_experience)
											));
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Before Number of days
											to allow Host cancellation<br>(experience)', 'experience_cancellation', $commonclass);
										?>
										<small>*Cancellation button will be hide before (n) days from booking start
											date
										</small>
										<div class="form_input">
											<?php
											echo form_input(array(
												'type' => 'number',
												'id' => 'cancel_hide_days_experience_host',
												'name' => 'cancel_hide_days_experience_host',
												'tabindex' => '8',
												'min' => '1',
												'max' => '100',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Number of Days',
												'value' => htmlentities($admin_settings->row()->cancel_hide_days_experience_host)
											));
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Admin Country<span
												class="req">*</span>', 'country', $commonclass);
										?>
										<div class="form_input">
											<select id="admin_country_code" name="admin_country_code" required>
												<option value="">Select</option>
												<?php foreach ($active_countries->result() as $active_country) : ?>
													<option
														value="<?php echo $active_country->id; ?>" <?php if ($active_country->id == $admin_settings->row()->admin_country_code) {
														echo 'selected="selected"';
													} ?>>
														<?php echo $active_country->name; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Manually update currency values<span
												class="req">*</span>', 'country', $commonclass);
										?>
										<div class="form_input">
											<select id="manual_currency_status" name="manual_currency_status" required>
												<option value="">Select</option>
												<option value="1" <?php if ($admin_settings->row()->manual_currency_status=='1') { echo 'selected="selected"'; } ?>>Yes</option>
												<option value="0" <?php if ($admin_settings->row()->manual_currency_status=='0') { echo 'selected="selected"'; } ?>>No</option>
											</select>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Exchange Rate API Key<span class="req">*</span>', 'exchange_rate_api', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'text',
												'id' => 'exchange_rate_api',
												'name' => 'exchange_rate_api',
												'tabindex' => '7',
												'required' => 'required',
												'class' => 'large tipTop',
												'title' => 'Please enter Exchange Rate API',
												'value' => htmlentities($admin_settings->row()->exchange_rate_api)
											]);
											$errorlbl = array('id' => 'exchange_rate_api_error', 'style' => 'display:none;', 'class' => 'error');
											echo form_label('Special Characters are not allowed!', '',$errorlbl);
											?>
										</div>
									</div>
								</li>
							</ul>
							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											
											<?php
											if($site_status_val == 1){
												echo form_input(array(
												'type' => 'submit',
												'tabindex' => '15',
												'class' => 'btn_small btn_blue',
												'value' => 'Submit'
												));
											}elseif($site_status_val == 2){ ?>
												<button type="button" onclick="alert('Cannot Submit on Demo Mode')">Submit</button>
												
											<?php }
											?>
										</div>
									</div>
								</li>
								
							</ul>
						</div>
						<?php
						echo form_close();
						$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/adminlogin/admin_global_settings', $attributes);
						echo form_input(array(
							'type' => 'hidden',
							'name' => 'form_mode',
							'value' => 'social'
						));
						?>
						<div id="tab2">
							<ul>
								<div class="form_grid_12">
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Facebook Link', 'facebook_link', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'facebook_link',
													'id' => 'facebook_link',
													'type' => 'url',
													'tabindex' => '10',
													'class' => 'large tipTop',
													'title' => 'Please enter the site facebook url',
													'value' => $admin_settings->row()->facebook_link
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google plus', 'googleplus_link', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'googleplus_link',
													'id' => 'googleplus_link',
													'type' => 'url',
													'tabindex' => '10',
													'class' => 'large tipTop',
													'title' => 'Please enter the site google plus url',
													'value' => $admin_settings->row()->googleplus_link
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Youtube Link', 'youtube_link', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'youtube_link',
													'id' => 'youtube_link',
													'type' => 'url',
													'tabindex' => '10',
													'class' => 'large tipTop',
													'title' => 'Please enter the site youtube url',
													'value' => $admin_settings->row()->youtube_link
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Twitter Link', 'twitter_link', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'twitter_link',
													'id' => 'twitter_link',
													'type' => 'url',
													'tabindex' => '10',
													'class' => 'large tipTop',
													'title' => 'Please enter the site twitter url',
													'value' => $admin_settings->row()->twitter_link
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Pinterest Link', 'pinterest', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'pinterest',
													'id' => 'pinterest',
													'type' => 'url',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the site pintrest url',
													'value' => $admin_settings->row()->pinterest
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Client Id', 'google_client_id', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_client_id',
													'id' => 'google_client_id',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the site pintrest url',
													'value' => $admin_settings->row()->google_client_id
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Redirect
												Url', 'google_redirect_url', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_redirect_url',
													'id' => 'google_redirect_url',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the google redirect url',
													'value' => $admin_settings->row()->google_redirect_url
												));
												$googledrt = array('class' => 'error');
												echo form_label('Note: For Google Redirect Url Copy This Url and
													Paste It. - ' . base_url() . 'google-login', '', $googledrt);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Redirect Url For
												DB Backup', 'google_redirect_url', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_redirect_url_db',
													'id' => 'google_redirect_url_db',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the google redirect url',
													'value' => $admin_settings->row()->google_redirect_url_db
												));
												$googledrtdb = array('class' => 'error');
												echo form_label('Note: For Google Redirect Url Copy This Url and
													Paste It. - ' . base_url() . '
													dbbackup/fileUpload.php', '', $googledrtdb);
												echo form_label('Note: Kindly Enable Drive API in APIs', '', $googledrtdb);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Redirect Url For
												Connect', 'google_redirect_url', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_redirect_url_connect',
													'id' => 'google_redirect_url_connect',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the google redirect url',
													'value' => $admin_settings->row()->google_redirect_url_connect
												));
												$googledrtdb = array('class' => 'error');
												echo form_label('Note: For Google Redirect Url Copy This Url and
													Paste It. -' . base_url() . '
													site/invitefriend/google_connect', '', $googledrtdb);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Secret
												Key', 'google_client_secret', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_client_secret',
													'id' => 'google_client_secret',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the google secret key',
													'value' => $admin_settings->row()->google_client_secret
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Google Map API Key', 'google_developer_key', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'google_developer_key',
													'id' => 'google_developer_key',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the google developer key',
													'value' => $admin_settings->row()->google_developer_key
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Bing Map API Key', 'bing_developer_key', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input(array(
													'name' => 'bing_developer_key',
													'id' => 'bing_developer_key',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the bing developer key',
													'value' => $admin_settings->row()->bing_developer_key
												));
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Facebook App ID', 'facebook_app_id', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'name' => 'facebook_app_id',
													'id' => 'facebook_app_id',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the facebook app id',
													'value' => $admin_settings->row()->facebook_app_id
												]);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Facebook App
												Secret', 'facebook_app_secret', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'name' => 'facebook_app_secret',
													'id' => 'facebook_app_secret',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the facebook app secret',
													'value' => $admin_settings->row()->facebook_app_secret
												]);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('LinkedIn App ID', 'linkedin_app_id', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'name' => 'linkedin_app_id',
													'id' => 'linkedin_app_id',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the LinkedIn app id',
													'value' => $admin_settings->row()->linkedin_app_id
												]);
												?>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('LinkedIn Secret
												Key', 'linkedin_secret_key', $commonclass);
											?>
											<div class="form_input">
												<?php
												echo form_input([
													'name' => 'linkedin_app_key',
													'id' => 'linkedin_app_key',
													'type' => 'text',
													'tabindex' => '11',
													'class' => 'large tipTop',
													'title' => 'Please enter the LinkedIn Secret Key',
													'value' => $admin_settings->row()->linkedin_app_key
												]);
												?>
											</div>
										</div>
									</li>
							</ul>
							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											
											<?php
											if($site_status_val == 1){
												echo form_input([
												'type' => 'submit',
												'tabindex' => '15',
												'class' => 'btn_small btn_blue',
												'value' => 'Submit'
												]);
											}elseif($site_status_val == 2){ ?>
												<button type="button" onclick="alert('Cannot Submit on Demo Mode')">Submit</button>
												
											<?php }
											?>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<?php echo form_close();
						$attributes = array('class' => 'form_container left_label', 'id' => 'settings_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/adminlogin/admin_global_settings', $attributes);
						echo form_input([
							'type' => 'hidden',
							'name' => 'form_mode',
							'value' => 'seo'
						]);
						?>
						<div id="tab3">
							<ul>
								<li>
									<h3>Search Engine Information</h3>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Meta Title', 'meta_title', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'name' => 'meta_title',
												'id' => 'meta_title',
												'type' => 'text',
												'tabindex' => '1',
												'class' => 'large tipTop',
												'title' => 'Please enter the site meta title',
												'value' => $admin_settings->row()->meta_title
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Meta Keyword', 'meta_keyword', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'name' => 'meta_keyword',
												'id' => 'meta_keyword',
												'type' => 'text',
												'tabindex' => '2',
												'class' => 'large tipTop',
												'title' => 'Please enter the site meta keyword',
												'value' => $admin_settings->row()->meta_keyword
											]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Meta Description', 'meta_description', $commonclass);
										?>
										<div class="form_input">
											<?php
											$meta_descattr = array(
												'cols' => '70',
												'tabindex' => '3',
												'rows' => '5'
											);
											echo form_textarea('meta_description', $admin_settings->row()->meta_description, $meta_descattr
											);
											?>
										</div>
									</div>
								</li>
								<li>
									<h3>Google Webmaster Info</h3>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Google Analytics
											Code', 'google_verification_code', $commonclass);
										?>
										<div class="form_input">
											<?php
											$anlyt_codeattr = array(
												'cols' => '70',
												'tabindex' => '3',
												'rows' => '5',
												'title' => 'Copy google analytics code and paste here'
											);
											echo form_textarea('google_verification_code', $admin_settings->row()->google_verification_code, $anlyt_codeattr
											);
											?>
											<br/>
											<span>For Examples:
                      <pre><?php echo htmlspecialchars('<script type="text/javascript"

  var _gaq = _gaq || [];
  _gaq.push([_setAccount, UA-XXXXX-Y]);
  _gaq.push([_trackPageview]);

  (function() {
    var ga = document.createElement(script); ga.type = text/javascript; ga.async = true;
    ga.src = (https: == document.location.protocol ? https://ssl : http://www) + .google-analytics.com/ga.js;
    var s = document.getElementsByTagName(script)[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>'); ?></pre>
                      </span></div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Google HTML Meta Verifcation
											Code', 'meta_keyword', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'name' => 'google_verification',
												'id' => 'google_verification',
												'type' => 'text',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => "Google HTMl Verification Code. Eg: <meta name='google-site-verification' content='XXXXX'>",
												'value' => str_replace('"', "'", $admin_settings->row()->google_verification)
											]);
											?>
											<span>
												<br/>
                      								Google Webmaster Verification using Meta tag. <br/>For more reference: 
                      								<a
														href="https://support.google.com/webmasters/answer/35638#3"
														target="_blank">https://support.google.com/webmasters/answer/35638#3
													</a>
											</span>
										</div>
									</div>
								</li>
							</ul>

							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											
											<?php

											if($site_status_val == 1){
												echo form_input([
													'type' => 'submit',
													'tabindex' => '15',
													'class' => 'btn_small btn_blue',
													'value' => 'Submit'
												]);
											}elseif($site_status_val == 2){ ?>
												<button type="button" onclick="alert('Cannot Submit on Demo Mode')">Submit</button>
												
											<?php }
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
	</div>
	<span class="clear"></span></div>
</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script type="text/javascript">
	function getTwilioStatus(status) {
		var theValue = status.value;
		if (theValue == '1') {
			$("#twilioGroup").css('display', 'block');
		} else {
			$("#twilioGroup").css('display', 'none');
			$("#twilio_account_sid").val('');
			$("#twilio_account_token").val('');
			$("#twilio_phone_number").val('');
		}

	}
</script>
<script type="text/javascript">
	window.addEventListener('load',
		function () {
			var getStatus = $("#twilioState_id").val();
			if (getStatus == '1') {
				$("#twilioGroup").css('display', 'block');
			} else {
				$("#twilioGroup").css('display', 'none');
			}

		}, false);
</script>
<script>
	/* $("#admin_name").on('keyup', function(e) {
        var val = $(this).val();
       if (val.match(/[^a-zA-Z\s()&]/g)) {
           document.getElementById("name_error").style.display = "inline";
           $("#name_error").fadeOut(5000);
           $("#admin_name").focus();
           $(this).val(val.replace(/[^a-zA-Z\s()&]/g, ''));
       }
    });

    $("#email_title").on('keyup', function(e) {
        var val = $(this).val();
       if (val.match(/[^a-zA-Z0-9-\s&()]/g)) {
           document.getElementById("site_name_error").style.display = "inline";
           $("#site_name_error").fadeOut(5000);
           $("#email_title").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9-\s&()]/g, ''));
       }
    });

    $("#twilio_phone_number").on('keyup', function(e) {
        var val = $(this).val();
       if (val.match(/[^0-9\s]/g)) {
           document.getElementById("twilio_phone_number_error").style.display = "inline";
           $("#twilio_phone_number_error").fadeOut(5000);
           $("#twilio_phone_number").focus();
           $(this).val(val.replace(/[^0-9\s]/g, ''));
       }
    }); */

	/*$("#twilio_account_sid").on('keyup', function(e) {
        var val = $(this).val();
       if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("twilio_account_sid_error").style.display = "inline";
           $("#twilio_account_sid_error").fadeOut(5000);
           $("#twilio_account_sid").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
       }
    });


    $("#twilio_account_token").on('keyup', function(e) {
        var val = $(this).val();
      if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("twilio_account_token_error").style.display = "inline";
           $("#twilio_account_token_error").fadeOut(5000);
           $("#twilio_account_token").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()]/g, ''));
       }
    });

     $("#home_title_1").on('keyup', function(e) {
        var val = $(this).val();
      if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("home_title_1_error").style.display = "inline";
           $("#home_title_1_error").fadeOut(5000);
           $("#home_title_1").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
       }
    });

    $("#home_title_2").on('keyup', function(e) {
        var val = $(this).val();
      if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("home_title_2_error").style.display = "inline";
           $("#home_title_2_error").fadeOut(5000);
           $("#home_title_2").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
       }
    });

    $("#home_title_3").on('keyup', function(e) {
        var val = $(this).val();
      if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("home_title_3_error").style.display = "inline";
           $("#home_title_3_error").fadeOut(5000);
           $("#home_title_3").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
       }
    });

    $("#home_title_4").on('keyup', function(e) {
        var val = $(this).val();
      if (val.match(/[^a-zA-Z0-9.,|-\s()]/g)) {
           document.getElementById("home_title_4_error").style.display = "inline";
           $("#home_title_4_error").fadeOut(5000);
           $("#home_title_4").focus();
           $(this).val(val.replace(/[^a-zA-Z0-9.,&|-\s()]/g, ''));
       }
    }); */
</script>
