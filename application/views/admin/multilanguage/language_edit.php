<?php
// echo $site_status_val;exit;
$this->load->view('admin/templates/header.php');
if (is_file('./fc_smtp_settings.php'))
{
	include('fc_smtp_settings.php');
}
?>
<script type="text/javascript">
	function change_the_another_file(fileName) 
	{
		filenameId = $('#language_select').val();
		if (fileName != '' && filenameId != '')
		{
			window.open("admin/multilanguage/edit_language/" + fileName + "/" + filenameId, "_self");
		}
	}
</script>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Language - <?php echo $selectedLanguage; ?>
						- <?php echo 'Page' . ' ' . $current_file_no; ?>
					</h6>
					<?php $NewOpArr = '';
					for ($i = 1; $i < $get_total_files; $i++) 
					{						
						$NewOpArr[$i]='Page ' . $i;
					} ?>
					<div style="float:right">
						<?php						
							$pageattr = array(
								'id'     => 'language_select',
								'style'  => 'float:left;margin: 9px 10px 0px; width:80px'	   
											);

							echo form_dropdown('language_select', $NewOpArr, '', $pageattr);
						
							echo form_input([
								'type'     => 'button',
								'value'    => 'Submit',
								'style'    => 'float:right !important; margin:4px 20px 0 0',
								'class'    => 'btn_small btn_blue',
								'onclick'  => "javascript:change_the_another_file('".$selectedLanguage."')"
									        ]);	
						?>
					</div>
				</div>

				<div class="widget_content">
					<?php
						$lngclass = array('class' => 'error','style' => 'font-size:18px;');

						echo form_label('Note: Dont Edit The Values Inside Of Curly Braces Eg:
						{SITENAME}','', $lngclass);	
					?>
					<p style="font-size:12px;">Eg: Join {SITENAME} today --- Rejoignez {SITENAME} aujourd'hui</p>
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'languageEdit', 'accept-charset' => 'UTF-8');
					echo form_open('admin/multilanguage/languageAddEditValues', $attributes);
					
						echo form_input([
							'type'     => 'hidden',
							'value'    => $selectedLanguage,
							'name' 	   => 'selectedLanguage'
						]);

						echo form_input([
							'type'     => 'hidden',
							'value'    => $file_name_prefix,
							'name' 	   => 'file_name_prefix'
						]);	

						echo form_input([
							'type'     => 'hidden',
							'value'    => $current_file_no,
							'name' 	   => 'current_file_no'
						]);
					?>
					<ul>
						<?php
						$loopNumber = 0;
						foreach ($file_key_values as $language_keys_item) 
						{
							if ($loopNumber != '0')
							{
								?>
								<li>
									<div class="form_grid_12">
										<?php
											$commonclass = array('class' => 'field_title');

											echo form_label(stripslashes($file_lang_values[$loopNumber]).'<span class="req">*</span>','language_vals'.$loopNumber, 
													$commonclass);	
										?>										
										<div class="form_input">
											<?php
												echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'language_vals[]',
									            'id'	    => 'language_vals'.$loopNumber,
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'required'  => 'required',
									            'title'  	=> 'Please enter the language',
												'value'	    => stripslashes($this->lang->line($language_keys_item))
									        	]);

									        	echo form_input([
												'type'      => 'hidden',      
									            'name' 	    => 'languageKeys[]',
									            'id'	    => 'smtp_host',
									            'class'     => 'tipTop required large',
									            'tabindex'	=> '1',
									            'required'  => 'required',
									            'title'  	=> 'Please enter the language',
												'value'	    => stripslashes($language_keys_item)
									        	]);
									         
											?>
										</div>
									</div>
								</li>
								<?php
							}
							$loopNumber = $loopNumber + 1;
						}
						?>
						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										
									?>
									<?php
												if($site_status_val == 1){
												echo form_input([
											'type'     => 'submit',
									        'value'    => 'Save',
									        'class'    => 'btn_small btn_blue'
									        ]);	
												}
												elseif($site_status_val == 2)
												{
											?>
											<button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Save</button>
										<?php } ?>
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
