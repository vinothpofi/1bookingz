<?php
$this->load->view('admin/templates/header.php');
?>
	<!-- script to generate sub menu -->
	<script>
		$(document).ready(function ()
		{
			$('#mainmenu').change(function ()
			{
				id = $('#mainmenu').val();
				$.ajax({
					url: '<?php echo base_url();?>admin/help/ajaxsubmenu',
					data: {
						id: id
					},
					dataType: 'json',
					success: function (json)
					{
						$('#submenudiv').html(json.states_list);
						$(".chzn-select").chosen();

					},
					type: 'POST'
				});
			});
		});

		function choosenval()
		{
			var config = {
				'.chosen-select': {},
				'.chosen-select-deselect': {allow_single_deselect: true},
				'.chosen-select-no-single': {disable_search_threshold: 10},
				'.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
				'.chosen-select-width': {width: "95%"}
			}
			for (var selector in config)
			{
				$(selector).chosen(config[selector]);
			}
		}
	</script>

	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New FAQ</h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm');
						echo form_open(ADMIN_PATH . '/help/insertquestion', $attributes)
						?>
						<div id="tab1">
							<ul>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label('Select Category <span class="req">*</span>','mian', $commonclass);	
										?>	
										<div class="form_input">
											<?php 
											$mian=array();
											foreach ($helpList->result() as $row)
											{
												$mian[$row->id]=$row->name;
											}								

											$mienattr = array(
											        'style'  => 'width: 375px; display: none;',
											        'class'       => 'chzn-select required',
											        'data-placeholder' => 'Select Main Page',
											        'id'	=> 	'mainmenu'   
											);

											echo form_dropdown('main', $mian, '', $mienattr);
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Select Topic Name <span class="req">*</span>','mian', $commonclass);	
										?>
										<div class="form_input" id='submenudiv'>
											<?php 
											$submenu = array();		
											foreach ($subhelp->result() as $row)
											{
												$submenu[$row->id] = $row->name;
											}	

											$submenuattr = array(
											        'style'  => 'width: 375px; display: none;',
											        'class'       => 'chzn-select required',
											        'data-placeholder' => 'Select Main Page',
											        'id' => 'sub_menu'	   
											);

											echo form_dropdown('submenu', $submenu, '', $submenuattr);
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Question<span class="req">*</span>','location_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
												echo form_input([
												'type'           => 'text',      
									            'name' 	         => 'question',
									            'id'             => 'question',
												'tabindex'	     => '1',
												'class'		     => 'required tipTop large',	
									            'original-title' => 'Please enter the user Question'
											]);
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Answer<span class="req">*</span>','location_name', $commonclass);	
										?>
										<div class="form_input">
											<?php
											
									        $descattr = array(
											    'name' 	      => 'answer',
									            'style'   	  => 'width:295px',
									            'tabindex'    => '4',
												'rows'	      => 5,
												'class'		  => 'required small tipTop mceEditor',
												'id'		  => 'Answer',
												'original-title' => 'Please enter the Answer'
											);
											echo form_textarea($descattr);
									   		?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<?php
											echo form_label('Status<span class="req">*</span>','admin_name', $commonclass);	
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
										<?php
											echo form_label('Featured<span class="req">*</span>','admin_name', $commonclass);	
										?>
										<div class="form_input">
											<div class="active_inactive">
												<?php
												
												echo form_input([
														'type'      => 'radio',      
											            'name' 	    => 'feature',
											            'class'	    => 'active_inactive',
											            'value'	    => 'yes'

											    ]);

												echo "Yes";

											    echo form_input([
														'type'      	=> 'radio',      
											            'name' 	    	=> 'feature',
											            'class'	    	=> 'active_inactive',
											            'value'			=> 'no',
                                                        'checked'       =>TRUE
											    ]);
											    echo "No";

											    ?>
											</div>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<?php
												echo form_input([
													'type'      => 'button',      
													'class' 	=> 'btn_small btn_blue',
													'tabindex'	=> '4',
													'value'		=> 'Submit',
													'onclick'   => 'validate_form()'
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
	<script type="text/javascript">
		function validate_form(){
			var sub_menu = $('#sub_menu').val();
			tinyMCE.triggerSave();
			var Answer_ifr = $('#Answer').val();
			var question = $('#question').val();
			if(Answer_ifr == ''){
				alert('Please Fill The Answer');
			}
			// else if(sub_menu == '' || sub_menu == null)
			// {
			// 	alert('Please select Topic Name');
			// }
			else{
				$('#commentForm').submit();
			}

		}
	</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
