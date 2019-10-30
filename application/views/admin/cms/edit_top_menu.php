<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_wrap tabby">
					<div class="widget_top"><span class="h_icon list"></span>
						<h6>Edit Page</h6>
						<div id="widget_tab">
							<ul>
								<li><a href="#tab1" class="active_tab">Content</a></li>

							</ul>
						</div>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'adduser_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/cms/updateCmsTopMenu', $attributes)
						?>
						<div id="tab1">
							<ul>


								<li>
									<div class="form_grid_12">
										<?php

											echo form_label('Footer top menu Name<span class="req">*</span>','page_name', $commonclass);
										?>
										<div class="form_input">
											<?php
												echo form_input([
													'type'        => 'text',      
										            'name' 	      => 'top_menu_name',
										            'id'          => 'top_menu_name',
													'value'	      => $menu_details->row()->top_menu_name,
													'tabindex'	  => '2',
													'class'		  => 'required tipTop large',
													'title'		  => 'Please enter the menu name',
                                                    'maxLength'=>'15'
										        ]);
									        ?>
												<span id="page_name_valid" style="color:#f00;display:none;">Only Characters allowed!
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
												echo form_input([
													'type'      => 'submit',      
													'class' 	=> 'btn_small btn_blue',
													'value'	    => 'Submit',
													'tabindex'  => '5'
												]);
											?>
										</div>
									</div>
								</li>
							</ul>
						</div>


						<?php
							echo form_input([
								'type'      => 'hidden',      
								'name' 		=> 'top_menu_id',
								'value'	    => $menu_details->row()->top_menu_id
							]);

							echo form_close();
						 ?>
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

<script>
	function validate() 
	{

	}
</script>
