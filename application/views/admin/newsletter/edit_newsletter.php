<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Email Template</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'UTF-8');
					echo form_open('admin/newsletter/insertEditNewsletter', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Template Name <span class="req">*</span>','news_title', $commonclass);	
								?>
								<div class="form_input">
									<?php

										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'news_title',
									            'id'	    => 'news_title',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the email template name',
												'value'	    => $user_details->row()->news_title
									    ]);
									?>
									<span id="news_title_valid"	 style="color:#f00;display:none;">Special Characters are not allowed!
									</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('For <span class="req">*</span>','news_title', $commonclass);	
								?>
								<div class="form_input">
									<?php
										$normalchk = "";
										$Subscriberschk = "";
										if($user_details->row()->news_subscriber != 'Yes')
										{
											$normalchk = checked;
										}

										if($user_details->row()->news_subscriber == 'Yes')
										{
											$Subscriberschk = checked;
										}

										echo form_input([
												'type'      => 'radio',      
									            'name' 	    => 'news_subscriber',
									            'id'	    => 'news_sub',
									            $normalchk  => $normalchk
									    ]);

										echo "Normal";

									    echo form_input([
												'type'      	=> 'radio',      
									            'name' 	    	=> 'news_subscriber',
									            'id'	    	=> 'news_subr',
									            'value'			=> 'yes',
									            $Subscriberschk => $Subscriberschk
									    ]);

									    echo "Subscribers";
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Email Subject <span class="req">*</span>','news_subject', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'news_subject',
									            'id'	    => 'news_subject',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the email template subject',
												'value'	    => $user_details->row()->news_subject
									    ]);
									?>
									<span
										id="news_subject_valid" style="color:#f00;display:none;">Special Characters are not allowed!
									</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Sender Name <span class="req">*</span>','sender_name', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'sender_name',
									            'id'	    => 'sender_name',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the sender name',
												'value'	    => $user_details->row()->sender_name
									    ]);
									?>
									<span
										id="sender_name_valid" style="color:#f00;display:none;">Special Characters are not allowed!
									</span>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Sender Email <span class="req">*</span>','sender_email', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'email',      
									            'name' 	    => 'sender_email',
									            'id'	    => 'sender_email',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the sender email address',
												'value'	    => $user_details->row()->sender_email
									    ]);
									?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Email Description <span class="req">*</span>','news_descrip', $commonclass);	
								?>
								<div class="form_input margin_cls">
									<?php

										$descattr=array(
											'style' => 'width:295px;',
											'class' => 'tipTop mceEditor',
											'title' => 'Please enter the email templete description'
										);

										echo form_textarea('news_descrip', $user_details->row()->news_descrip, $descattr);
									?>
								</div>
							</div>
						</li>
						<?php
							echo form_input([
								'type'      => 'hidden',      
								'name' 	    => 'newsletter_id',
								'value'	    => $user_details->row()->id
							]);
						?>
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
											'type'      => 'submit',      
											'class' 	=> 'btn_small btn_blue',
											'value'	    => 'Update',
											'tabindex'  => '4'
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
<?php
$this->load->view('admin/templates/footer.php');
?>
<!-- script for validating inputs -->
<script>
	$("#news_title").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^a-zA-Z0-9.,|-\s()&/]/g)) 
		{
			document.getElementById("news_title_valid").style.display = "inline";
			$("#news_title_valid").fadeOut(5000);
			$("#news_title").focus();
			$(this).val(val.replace(/[^a-zA-Z.,|-\s()&/]/g, ''));
		}
	});

	$("#news_subject").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^a-zA-Z0-9.,|-\s()@&/]/g)) 
		{
			document.getElementById("news_subject_valid").style.display = "inline";
			$("#news_subject_valid").fadeOut(5000);
			$("#news_subject").focus();
			$(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()@&/]/g, ''));
		}
	});

	$("#sender_name").on('keyup', function (e)
	{
		var val = $(this).val();
		if (val.match(/[^a-zA-Z0-9.,|-\s()&/]/g))
		{
			document.getElementById("sender_name_valid").style.display = "inline";
			$("#sender_name_valid").fadeOut(5000);
			$("#sender_name").focus();
			$(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()&/]/g, ''));
		}
	});
</script>
