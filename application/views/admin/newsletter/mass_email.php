<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading; ?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'mass_email', 'accept-charset' => 'UTF-8', 'onsubmit' => 'return validateform();');
						echo form_open('admin/newsletter/mass_email', $attributes)
						?>
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Email To <span class="req">*</span>','news_title', $commonclass);	
									?>
									<div class="form_input">
										<?php
										
										echo form_input([
												'type'      => 'radio',      
									            'name' 	    => 'mail_to',
									            'id'	    => 'all_user',
									            'value'   	=> 'all'
									    ]);

										echo "All User";

										echo form_input([
												'type'      => 'radio',      
									            'name' 	    => 'mail_to',
									            'id'	    => 'particular_user',
									            'value'   	=> 'particular'
									    ]);

										echo "Particular";
										?>
									</div>
								</div>
							</li>
							
							<li id="particular_user_detail" style="display:none;">
								<div class="form_grid_12">									
									<div class="form_input">									
                                    <select name="email_list[]" multiple="multiple">
									<?php foreach($user_emails as $user_email) :?>
									<option value="<?php echo $user_email->email;?>"><?php echo $user_email->firstname.' '.$user_email->lastname;?> --<?php echo $user_email->email;?></option>
									<?php endforeach;?>
									</select>
									</div>
								</div>
								</li>

							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Subject <span class="req">*</span>','subject', $commonclass);	
									?>
									<div class="form_input">
										<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'subject',
									            'id'	    => 'subject',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the subject',
												'value'	    => ''
									    ]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Message <span class="req">*</span>','message', $commonclass);	
									?>
									<div class="form_input margin_cls">
										<?php

										$descattr=array(
											'required' => 'required',
											'class'    => 'tipTop mceEditor required',
											'id'       => 'message_content',
											'name'     => 'message',
										);

										echo form_textarea('message', '', $descattr);
										?>
									</div>
									<span id="message_content_empty" style="display:none;">Please Enter Message
									</span>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'submit',      
												'class' 	=> 'btn_small btn_blue',
												'tabindex'	=> '4',
												'value'		=> 'submit'
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

	<script type="text/javascript">
		$('#all_user').click(function ()
		{
			$('#particular_user_detail').hide();
		});

		$('#particular_user').click(function ()
		{
			$('#particular_user_detail').show();
		});

		$(document).ready(function ()
		{
			if ($('#particular_user').is(':checked') == true)
			{
				$('#particular_user_detail').show();
			}
		});
	</script>
	<!-- script to validate message content -->
	<script>
		function validateform()
		{
			var message_content = document.getElementById("message_content").value;
			if ($.trim(message_content) == "")
			{
				$("#message_content").focus();
				document.getElementById("message_content_empty").style.display = "inline";
				$("#message_content_empty").fadeOut(5000);
				return false;
			}
		}
	</script>
	
<?php
$this->load->view('admin/templates/footer.php');
?>
