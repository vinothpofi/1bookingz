<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit User Language</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'UTF-8');
						echo form_open(ADMIN_PATH . '/multilanguage/insertEditUserLang', $attributes)
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Language Name <span class="req">*</span>','language_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'language_name',
									            'id'	    => 'language_name',
									            'style' 	=> 'width:295px',
									            'class'     => 'tipTop required',
									            'tabindex'	=> '1',
									            'title'  	=> 'Please enter the language name',
												'value'	    => $language_list->row()->language_name
									        	]);
											?>
										</div>
									</div>
								</li>
								<?php
									echo form_input([
										'type'     => 'hidden',
									    'value'    => $language_list->row()->id,
									    'name' 	   => 'language_id'
									]);	
								?>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php
												echo form_input([
													'type'     => 'submit',
												    'class'    => 'btn_small btn_blue',
												    'value'    => 'Update',
												    'tabindex' => '4'
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
	
<?php
$this->load->view('admin/templates/footer.php');
?>
