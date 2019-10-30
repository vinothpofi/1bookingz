<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading;?></h6>
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

										echo form_label('Country Name<span class="req">*</span>','country_id', $commonclass);	
									?>
                                    <div class="form_input">
                                      <?php echo $CountryList->row()->name;?>
                                    </div>
                                  </div>
                                </li>

                                <li>
								<div class="form_grid_12">
									<?php
										echo form_label('State Name<span class="req">*</span>','state_name', $commonclass);	
									?>
									<div class="form_input">
                                    <?php echo $tax_details->row()->name;?>
									</div>
								</div>
								</li>

								<li>
								<div class="form_grid_12">
									<?php
										echo form_label('State Code<span class="req">*</span>','state_code', $commonclass);	
									?>
									<div class="form_input">
                                   <?php echo $tax_details->row()->state_code;?>
									</div>
								</div>
								</li>
                                 
	 							<li>
				                  <div class="form_grid_12">
				                    <?php
										echo form_label('Meta Title','meta_title', $commonclass);
									?>
				                    <div class="form_input">
				                      <?php echo $tax_details->row()->meta_title;?>
				                    </div>
				                  </div>
				                </li>

				                <li>
				                  <div class="form_grid_12">
				                    <?php
										echo form_label('Meta Keyword','meta_tag', $commonclass);
									?>
				                    <div class="form_input">
				                     <?php echo $tax_details->row()->meta_keyword;?>
				                    </div>
				                  </div>
				                </li>

				                <li>
				                  <div class="form_grid_12">
				                   <?php
										echo form_label('Meta Description','meta_description', $commonclass);
									?>
				                    <div class="form_input">
				                      <?php echo $tax_details->row()->meta_description;?>
				                    </div>
				                  </div>
				                </li>
	 							
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/location/display_tax_statelist/<?php echo $tax_details->row()->countryid;?>" class="tipLeft" title="Go to location list"><span class="badge_style b_done">Back</span></a>
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