<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Category page</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open(ADMIN_PATH . '/help/inserthelppage', $attributes);
						?>
						<div id="tab1">
							<p style="color: red;display: none;font-size: 15px;" id="er_display"></p>
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

													'0'         => 'Select',
											        'Both'         => 'Both',
											        'User'        => 'Guest',
											        'Host'  	   => ' Host'	   
											);											

											$typattr = array(
											        'style'  => ' width:295px; height:30px;',
											        'title'  => 'Please Choose Type',
											        'id'	=> 'id_type'

											);

											echo form_dropdown('type', $typ, '', $typattr);
											?>
											
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Category Name <span class="req">*</span>','country_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'help_name',
									            'style'   	  => 'width:295px',
									            'id'          => 'currency_symbol',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the Category name'
												]);
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php										
										echo form_label('Status <span class="req">*</span>','admin_name', $commonclass);	
								    	?>
										<div class="form_input">
											<div class="active_inactive">
												<input type="checkbox" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<button type="button" value="Submit" onclick="commentForm_sub()" class="btn_small btn_blue">Submit</button>
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
	<script type="text/javascript">
		function commentForm_sub(){
			
			var id_type = $('#id_type').val();
			//alert(id_type);
			if(id_type != '0'){
				$('#commentForm').submit();
			}
			else{
				 $('#er_display').fadeIn('fast', function () {
				 	$('#er_display').html('Please select type');
                $(this).delay(5000).fadeOut('slow');
            });
				
			}
		}
	</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
