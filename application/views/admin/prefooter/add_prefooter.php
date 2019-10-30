<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Add New Prefooter</h6>
					</div>
					<div class="widget_content">
					<?php 
						$attributes = array('class' => 'form_container left_label', 'id' => 'addslider_form', 'enctype' => 'multipart/form-data');
						echo form_open_multipart('admin/prefooter/insertEditprefooter',$attributes) 
					?>
	 						<ul>
	 							<li>
								<div class="form_grid_12">
									<label class="field_title" for="footer_title">prefooter Title <span class="req">*</span></label>
									<div class="form_input">
										<input name="footer_title" id="footer_title" type="text" required tabindex="1" class="required large tipTop" title="Please enter the prefooter name"/>
										<span id="footer_title_error" style="color:#f00;display:none;">Special Characters Not Allowed</span>
								</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="short_desc_count">Prefooter Excerpt Count </label>
									<div class="form_input">
										<input name="short_desc_count" id="short_desc_count" type="text" required tabindex="2" class="large tipTop" title="Please excerpt count" onblur="short_description(this)">
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="prefooter_link">prefooter Link <span class="req">*</span></label>
									<div class="form_input">
										<input name="footer_link" id="footer_link" type="url" tabindex="2" class="required large tipTop" title="Please enter the prefooter link"/>
									</div>
								</div>
								</li>
                               
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="image">prefooter Image<span class="req">*</span></label>
									<div class="form_input">
										<input name="image" id="image" type="file" tabindex="7" required class="required large tipTop" title="Please select prefooter image"/>
									</div>
								</div>
								</li>
								<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status <span class="req">*</span></label>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="8" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
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
<script>
$('#addprefooter_form').validate();

function short_description(elm)
{
var count=$(elm).val();
//alert(cou);
if(isNaN(count))
{
alert('Prefooter Except Count Should be Number');
$(elm).val("");
}
else
{
next_id=$(elm).closest('li').next().find('input').attr('id');
var short_description='<li><div class="form_grid_12"><label class="field_title" for="short_desc_count">Prefooter Short Description</label>';
for(var i=1;i<=count;i++)
{
short_desc_count='short_desc_count'+i;
count1=count;
short_description=short_description+'<div class="form_input"><input type="text"  class="required  large tipTop" tabindex="'+count1+'" name="'+short_desc_count+'" original-title="Please excerpt count"></div>';
}
short_description=short_description+'</div></li>';
if(next_id=='footer_link')
{
$(elm).closest('li').after(short_description);
}
else{
$(elm).closest('li').next('li').remove();
$(elm).closest('li').after(short_description);
}
//$(short_description).insertAfter('.left_label ul:li:eq(1)');
//alert(short_description);
}
}
</script>
<?php 
$this->load->view('admin/templates/footer.php');
?>
<script>
/* $("#footer_title").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z0-9-\s&()]/g)) {
	   document.getElementById("footer_title_error").style.display = "inline";
	   $("#footer_title_error").fadeOut(5000);
	   $("#footer_title").focus();
       $(this).val(val.replace(/[^a-zA-Z0-9-\s&()]/g, ''));
   }
}); */
</script>