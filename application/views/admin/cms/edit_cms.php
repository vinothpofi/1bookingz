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
								<li><a href="#tab2">SEO Details</a></li>
							</ul>
						</div>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'adduser_form', 'accept-charset' => 'UTF-8');
						echo form_open('admin/cms/insertEditCms', $attributes)
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
                                $ownrnme_sel=$cms_details->row()->top_menu_id;
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

								<?php if ($cms_details->row()->category == 'Sub')
								{ ?>
									<li>
										<div class="form_grid_12">
											<?php
												$commonclass = array('class' => 'field_title');

												echo form_label('Select Main <span class="req">*</span>','parent', $commonclass);	
											?>
											<div class="form_input">
											<?php
												$mainctgry=array();
												$mainctgry[''] = '--Select--';

												foreach ($cms_main_details->result() as $row)
												{
													$mainctgry[$row->id]=$row->page_name;
												}	 

												$mainctgryattr = array(
													'id'       => 'parent',
													'class'    => 'chzn-select required',
													'data-placeholder'	 => 'Select Main Page',
													'style'	   => 'width: 375px; display: none;',
													'tabindex' => '1'   
												);

												echo form_dropdown('parent', $mainctgry, $cms_details->row()->parent, $mainctgryattr);
												?>
												<span id="parent_valid" style="color:#f00;display:none;">Please select Main Page</span>
											</div>
										</div>
									</li>
								<?php } ?>
								<li>
									<div class="form_grid_12">
										<?php

											echo form_label('Page Name<span class="req">*</span>','page_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
													'type'        => 'text',      
										            'name' 	      => 'page_name',
										            'id'          => 'page_name',
													'value'	      => $cms_details->row()->page_name,
													'tabindex'	  => '2',
													'class'		  => 'required tipTop large',
													'title'		  => 'Please enter the page name'
										        ]);
									        ?>
												<span id="page_name_valid" style="color:#f00;display:none;">Only Characters allowed!
												</span>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php

											echo form_label('Page Title','page_title', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
													'type'        => 'text',      
										            'name' 	      => 'page_title',
										            'id'          => 'page_title',
													'value'	      => $cms_details->row()->page_title,
													'tabindex'	  => '3',
													'class'		  => 'tipTop large',
													'title'		  => 'Please enter the page title'
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

											echo form_label('Description','description', $commonclass);	
										?>
										<div class="form_input margin_cls">
											<?php

												$descattr=array(
													'style'    => 'width:295px;',
													'class'    => 'large tipTop mceEditor',
													'title'    => 'Please enter the page content',
													'tabindex' => '4'
												);

												echo form_textarea('description', $cms_details->row()->description, $descattr);
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
											            'class'     => 'large tipTop',
											            'tabindex'	=> '1',
											            'title'  	=> 'Please enter the page meta title',
														'value'	    => $cms_details->row()->meta_title
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
											            'class'     => 'large tipTop',
											            'tabindex'	=> '2',
											            'title'  	=> 'Please enter the page meta tag',
														'value'	    => $cms_details->row()->meta_tag
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
												'id' 	  => 'meta_description',
												'class'   => 'large tipTop',
												'title'   => 'Please enter the meta description',
												'tabindex' => '3'
												);

												echo form_textarea('meta_description', $cms_details->row()->meta_description, $descattr2);
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
						<?php
							echo form_input([
								'type'      => 'hidden',      
								'name' 		=> 'cms_id',
								'value'	    => $cms_details->row()->id
							]);
						
						if ($cms_details->row()->category == 'Sub') 
						{ 
							echo form_input([
								'type'      => 'hidden',      
								'name' 		=> 'subpage',
								'value'	    => 'subpage'
							]);

							echo form_close();
						} ?>						
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
		if ($('#parent option:selected').val() == '') 
		{
			document.getElementById("parent_valid").style.display = "inline";
			$("#parent").focus();
			$("#parent_valid").fadeOut(5000);
			return false;
		}
	}
</script>
