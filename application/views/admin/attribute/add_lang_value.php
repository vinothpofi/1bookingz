<?php
$this->load->view('admin/templates/header.php');
?>
<script>
function main_page(val1){
$.ajax(
     {
			type: 'POST',
			url:'<?php echo base_url(); ?>admin/listattribute/main_listspace',
			data:{'id':val1},
			success: function(data) 
			{
			$('#lang').html(data);
			}
	 });
}
</script>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New List</h6>
                        
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/listattribute/insertAttribute_other',$attributes) 
					?>
                    
						<ul>
	 							
							<li>
							<div class="form_grid_12">
								<label class="field_title" for="template">Choose List <span class="req">*</span></label>
								<div class="form_input">
								<select name="toId" onchange="main_page(this.value)" >
									<option>Please Choose List</option>
									<?php  foreach($cms_details->result() as $page) { ?>
									<option value="<?php echo $page->id; ?>"><?php echo $page->attribute_name; ?></option>
									<?php } ?>
								</select>
								</div>
							</div>
							</li>
							<li>
							<div class="form_grid_12">
								<label class="field_title" for="template">Choose Language <span class="req">*</span></label>
								<div class="form_input">
								<select name="lang" id="lang">
									<option>Please Choose Language</option>
								</select>
								</div>
							</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="attribute_name">List Name <span class="req">*</span></label>
									<div class="form_input">
										<input name="attribute_name" id="attribute_name" type="text" tabindex="1" class="required large tipTop" title="Please enter the list name" value=""/>
									</div>
								</div>
							</li>
								</li>
								<li>
								<div class="form_grid_12">
									<div class="form_input">
										<button type="submit" class="btn_small btn_blue" tabindex="9"><span>Submit</span></button>
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
<?php 
$this->load->view('admin/templates/footer.php');
?>