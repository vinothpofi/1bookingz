<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>View Country</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label');
						echo form_open('admin',$attributes) 
					?>
	 						<ul>
                            	<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Country Name','location_name', $commonclass);	
									?>
									<div class="form_input">
                                    <?php echo $location_details->row()->name;?>
									</div>
								</div>
								</li>
                                <li>
								<div class="form_grid_12">
									<?php
										echo form_label('Country Code ','language_code', $commonclass);	
									?>
									<div class="form_input">                                    
                                    <?php
									if($LanguageList->num_rows() > 0)
									{
										foreach($LanguageList->result() as $Row)
										{												
											if($location_details->row()->language_code==$Row->lang_code)
											{
												 	echo $Row->name;
											}												
										}
									}
									?>                                    
								</div>
								</div>
								</li>								
                                
					 			<li>
				                  <div class="form_grid_12">
				                  	<?php
									echo form_label('Meta Title','meta_title', $commonclass);	
									?>
				                    <div class="form_input">
				                      <?php echo $location_details->row()->meta_title;?>
				                    </div>
				                  </div>
				                </li>

				                <li>
				                  <div class="form_grid_12">
				                  	<?php
									echo form_label('Meta Keyword','meta_tag', $commonclass);	
									?>
				                    <div class="form_input">
				                     <?php echo $location_details->row()->meta_keyword;?>
				                    </div>
				                  </div>
				                </li>

				                <li>
				                  <div class="form_grid_12">
				                    <?php
									echo form_label('Meta Description','meta_description', $commonclass);	
									?>
				                    <div class="form_input">
				                      <?php echo $location_details->row()->meta_description;?>
				                    </div>
				                  </div>
				                </li>
	 							
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/location/display_location_list" class="tipLeft" title="Go to location list"><span class="badge_style b_done">Back</span>
										</a>
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