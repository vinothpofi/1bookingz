<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Edit Slider</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'editslider_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/prefooter/insertEditadvertisment',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="footer_title">Title <span class="req">*</span></label>
									<div class="form_input">
										<input name="title" id="footer_title" type="text" tabindex="1" class="required large tipTop" title="Please enter the prefooter name" value="<?php echo $advertisment_details->row()->title;?>"/>
									</div>
								</div>
								</li>
								


								<li>
								<div class="form_grid_12">
									<label class="field_title" for="prefooter_link">Button Link <span class="req">*</span></label>
									<div class="form_input">
										<input name="link" id="footer_link" type="text" tabindex="2" class="required large tipTop" title="Please enter the prefooter link" value="<?php echo $advertisment_details->row()->link;?>">
										<label class="error">Example: http://www.domain.com </label>
									</div>
								</div>
								</li>

								<li>
								<div class="form_grid_12">
									<label class="field_title" for="prefooter_link">Description <span class="req">*</span></label>
									<div class="form_input">
										<textarea name="description"><?php echo $advertisment_details->row()->description;?></textarea>
										
										
									</div>
								</div>
								</li>
							
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="image">Image<span class="req">*</span></label>
									<div class="form_input">
										<input name="image" id="image" type="file" tabindex="7" class="large tipTop" title="Please select prefooter image"/>
									</div>
									<div class="form_input"><img src="<?php echo base_url();?>images/advertisment/<?php echo $advertisment_details->row()->image;?>" width="100px"/></div>
								</div>
								</li>
					            <li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" name="status" <?php if ($advertisment_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
								<input type="hidden" name="advertisment_id" value="<?php echo $advertisment_details->row()->advertisment_id;?>"/>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" onclick="return checkUrl();" tabindex="4"><span>Update</span></button>
									</div>
								</div>
								</li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
</div>
<script>
function checkUrl()
{
	var str = $("#footer_link").val();
	if(str.indexOf('"') == -1)
	{
		return true;
	}
	else
	{
		alert('Kindly check the URL!');
		return false;
	}
}
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>