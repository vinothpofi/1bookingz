<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_wrap tabby">
					<div class="widget_top"><span class="h_icon list"></span>
						<h6><?php echo $heading; ?></h6>
						<div id="widget_tab">
							<ul>
								<li><a href="#tab1" class="active_tab">Content</a></li>
								<li><a href="#tab2">SEO Details</a></li>
							</ul>
						</div>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label','onsubmit'=>'return test();', 'id' => 'adduser_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/cms/insertEditCms', $attributes);
						
							echo form_input([
								'type'      => 'hidden',      
								'name' 	    => 'lang_code',
								'value'	    => 'en'
							]);
						?>
						<div id="tab1">
							<ul>

                                <?php
                                $ownrnme = array();
                                $ownrnme[''] = '--Select Top menu--';
                                if (!empty($top_menu_details)) {
                                    foreach ($top_menu_details->result() as $top_menu) {
                                        $ownrnme[$top_menu->top_menu_id] = $top_menu->top_menu_name;
                                    }
                                }
                                $ownrnme_sel='';
                                $ownrattr = array(
                                    'id' => 'top_menu_id',
                                    'required'=>'required',
                                    'style' => 'width: 375px;',
                                    'class'=>'required large'
                                );

                                ?>
                                <li>
                                    <div class="form_grid_12">
                                        <?php
                                        $commonclass = array('class' => 'field_title');

                                        echo form_label('Footer Top menu <span class="req">*</span>','footer_top_menu_label', $commonclass);
                                        ?>
                                        <div class="form_input">
                                            <?php
                                            echo form_dropdown('top_menu_id', $ownrnme,$ownrnme_sel, $ownrattr);
                                            ?>
                                            <span id="footer_top_menu_error"	style="color:#f00;display:none;">Only Characters allowed!
											</span>
                                        </div>
                                    </div>
                                </li>



                                <li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Page Name <span class="req">*</span>','page_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
														'type'      => 'text',      
											            'name' 	    => 'page_name',
											            'id'	    => 'page_name',
											            'class'     => 'tipTop required large',
											            'tabindex'	=> '1',
											            'title'  	=> 'Please enter the page name'
											    ]);
											?>
											<span id="page_name_valid"	style="color:#f00;display:none;">Only Characters allowed!
											</span>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Page Title <span class="req">*</span>','page_title', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
														'type'      => 'text',      
											            'name' 	    => 'page_title',
											            'id'	    => 'page_title',
											            'class'     => 'tipTop required large',
											            'tabindex'	=> '2',
											            'title'  	=> 'Please enter the page title'
											    ]);
											?>
											<span
												id="page_title_valid" style="color:#f00;display:none;">Special Characters are not allowed!
											</span>
										</div>
									</div>
								</li>
								
								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Description <span class="req">*</span>','description', $commonclass);	
										?>
										<div class="form_input margin_cls">
											<?php

												$descattr=array(
													'tabindex' => '3',
													'id'	   => 'description',
													'class'    => 'large required tipTop mceEditor',
													'title'    => 'Please enter the page content'
												);

												echo form_textarea('description', '', $descattr);
											?>
										</div>
									</div>
									<br><span style="color:#DE5130;padding-left:378px;" id="description_error"></span>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Hidden Page <span class="req">*</span>','display_mode', $commonclass);	
										?>
										<div class="form_input">
											<div class="yes_no">
												<input type="checkbox" tabindex="4" name="hidden_page" id="yes_no_yes" class="yes_no"/>
											</div>
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

						<div id="tab2">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Meta Title','meta_title', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
														'type'      => 'text',      
											            'name' 	    => 'meta_title',
											            'id'	    => 'meta_title',
											            'class'     => 'tipTop large',
											            'tabindex'	=> '1',
											            'title'  	=> 'Please enter the page meta title'
											    ]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Meta Tag','meta_tag', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
														'type'      => 'text',      
											            'name' 	    => 'meta_tag',
											            'id'	    => 'meta_tag',
											            'class'     => 'tipTop large',
											            'tabindex'	=> '2',
											            'title'  	=> 'Please enter the page meta tag'
											    ]);
											?>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Meta Description','meta_description', $commonclass);	
										?>
										<div class="form_input">
											<?php

												$descattr2=array(
													'id'	   => 'meta_description',
													'tabindex' => '3',
													'class'    => 'large tipTop',
													'title'    => 'Please enter the meta description'
												);

												echo form_textarea('meta_description', '', $descattr2);
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
												echo form_input([
													'type'      => 'submit',      
													'class' 	=> 'btn_small btn_blue',
													'value'	    => 'Submit',
													'tabindex'  => '4'
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
	</div>
	<span class="clear"></span></div>
</div>

<?php
$this->load->view('admin/templates/footer.php');
?>

<script>
function test(){
    tinyMCE.triggerSave();
    var location_data = $('#description').val();
//alert(location_data);
 if(location_data == '')
   { 
   $("#description_error").text("This field was required.");
   $("#description").focus();
   return false;
   }else{
   $("#description_error").text("");
   }
   
}

</script>
