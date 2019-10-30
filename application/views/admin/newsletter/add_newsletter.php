<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add Email Template</h6>
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
												'value'	    => ''
									    ]);
										?>
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
										
										echo form_input([
												'type'      => 'radio',      
									            'name' 	    => 'news_subscriber',
									            'id'	    => 'news_sub',
									            'checked'   => 'checked'
									    ]);

										echo "Normal";

									    echo form_input([
												'type'      	=> 'radio',      
									            'name' 	    	=> 'news_subscriber',
									            'id'	    	=> 'news_subr',
									            'value'			=> 'yes'
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
									            'title'  	=> 'Please enter the email template subject'
									    ]);
										?>
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
												'value'	    => $this->data['title']
									    ]);
										?>
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
												'value'	    => $this->config->item('email')
									    ]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php

										echo form_label('Email Description','news_descrip', $commonclass);	
									?>
									<div class="form_input">
										<?php

										$descattr=array(
											'style' => 'width:295px;',
											'class' => 'tipTop mceEditor',
											'title' => 'Please enter the email templete description'
										);

										echo form_textarea('news_descrip', '', $descattr);
										?>
									</div>
								</div>
							</li>
							<?php
								echo form_input([
									'type'      => 'hidden',      
									'name' 	    => 'status',
									'id'	    => 'status'
								]);

								echo form_input([
									'type'      => 'hidden',      
									'name' 	    => 'newsletter_id'
								]);
							?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'      => 'submit',      
												'class' 	=> 'btn_small btn_blue',
												'tabindex'	=> '4',
												'value'		=> 'Submit'
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
