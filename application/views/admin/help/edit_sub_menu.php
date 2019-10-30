<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Categories & Sub topic</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open(ADMIN_PATH . '/help/insertsubmenu', $attributes)
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Type <span class="req">*</span>','location_name', $commonclass);	
										?>
										<div class="form_input">
											<?php 
											$typ = array(); 
											$typ = array(
											        'Both'         => 'Both',
											        'User'         => 'Guest',
											        'Host'  	   => 'Host'	   
											);											

											$typattr = array(
											        'class'  => 'select_width',
											        'title'  => 'Please Choose Type'	   
											);

											echo form_dropdown('type', $typ, $helpList->row()->type, $typattr);
											?>											
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Select Category<span class="req">*</span>','mian', $commonclass);	
										?>
										<div class="form_input">
											<?php 
											$minmenu = array();
											foreach ($main->result() as $row)
											{
												$minmenu[$row->id] = $row->name;
											}								

											$minmenuattr = array(
											        'style'  => 'width: 375px; display: none;',
											        'class'       => 'chzn-select required',
											        'data-placeholder' => 'Select Main Page'	   
											);

											echo form_dropdown('main', $minmenu, $helpList->row()->main, $minmenuattr);
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Page Name <span class="req">*</span>','country_name', $commonclass);	
										
										echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'help_name',
									            'style'   	  => 'width:295px',
									            'id'          => 'currency_symbols',
												'value'	  	  => $helpList->row()->name,
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the Page Name'
										]);
										?>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
											echo form_label('Status <span class="req">*</span>','admin_name', $commonclass);	
								    	?>
										<div class="form_input">
											<div class="active_inactive">
												<input type="checkbox" name="status" <?php if ($helpList->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
											</div>
										</div>
									</div>
								</li>
								<?php
									echo form_input([
										'type'        => 'hidden',      
									    'value' 	  => $helpList->row()->id,
									    'name'        => 'help_id'
									]);
								?>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php
												echo form_input([
													'type'        => 'submit',      
										            'value' 	  => 'Update',
													'class'		  => 'btn_small btn_blue'
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
