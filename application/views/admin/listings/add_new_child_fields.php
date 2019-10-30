<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add Child Values</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addattribute_form', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/listings/add_submit_new_child_fields', $attributes)
					?>
					<ul>
						<?php
						echo form_input([
							'type'  => 'hidden',
							'name'  => 'parent_id',
							'value' => $this->uri->segment(4)
						]);

						echo form_input([
							'type'  => 'hidden',
							'id'    => 'child_id',
							'value' => ''
						]);
						?>
						<li>
							<div class="form_grid_12">
								<?php
								$commonclass = array('class' => 'field_title');

								echo form_label('Child Value <span class="req">*</span>', 'attribute_name', $commonclass);
								?>
								<div class="form_input">
									<?php
									if($list_attr_name->name == 'minimum_stay' || $list_attr_name->name == 'accommodates'){
									$childname_class ='tipTop required large child_name_num';}else{
										$childname_class ='tipTop required large';
									}
									echo form_input([
										'type' 		=> 'text',
										'name' 		=> 'child_value',
										'id' 		=> 'child_name',
										'style' 	=> 'width:295px',
										'class' 	=> $childname_class,
										'tabindex'  => '1',
										'title' 	=> 'Please enter the child name',
										'required'  => 'required'
									]);
									?>
									<span id="child_name_valid"  style="color:#f00;display:none;"> Charecters and Numbers only!</span>
								</div>
							</div>
						</li>

						<li style="display: none;">
							<div class="form_grid_12">
								<?php
								echo form_label('Child Value(Arabic) <span class="req">*</span>', 'attribute_name', $commonclass);
								?>
								<div class="form_input">
									<?php
									echo form_input([
										'type' 		=> 'text',
										'name' 		=> 'child_value_arabic',
										'id' 		=> 'child_name_arabic',
										'style' 	=> 'width:295px',
										'class' 	=> 'tipTop required large',
										'tabindex'  => '1',
										'title' 	=> 'Please enter the child name',
										'required'  => 'required',
										'value'		=> 'none'
									]);
									?>
								</div>
							</div>
						</li>
						<?php
						echo form_input([
							'type'  => 'hidden',
							'name'  => 'id',
							'value' => ''
						]);
						?>
						<li>

							<div class="form_grid_12">
								<div class="form_input">
									<?php
									echo form_input([
										'type' 		=> 'submit',
										'id' 		=> 'add_btn',
										'class' 	=> 'btn_small btn_blue',
										'tabindex'  => '9',
										'value' 	=> 'Submit'
									]);
									?>
									<input type="button" class="btn_small btn_blue" id="update_btn"
										   style="display: none;" name="" value="Update"
										   onclick="javascript:child_data_Update();">
									<a href="admin/listings/listing_child_values">
										<button class="btn_small btn_blue" type="button">Back</button>
									</a>
								</div>

							</div>
						</li>
					</ul>
				<?php echo form_close(); ?>
				</div>
				<div id="season_table">
					<table class="display display_tbl" id="subadmin_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">Features Name</th>
							<th class="tip_top" title="Click to sort">Child Values</th>
							<th class="tip_top" title="Click to sort">Action</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if ($listchildvalues->num_rows() > 0)
						{
							$i = 1;
							foreach ($listchildvalues->result() as $row)
							{
								?>
								<tr>
									<td class="center">
										<?php echo ucfirst($row->labelname); ?>
									</td>
									<td class="center">
										<?php echo $row->child_name; ?>
									</td>
									<td class="center">
										<?php if ($allPrev == '1' || in_array('2', $Properties)) { ?>
											<span>								
											<span class="action-icons c-edit"
												  onclick="javascript:get_child_data('<?php echo $row->child_id; ?>','<?php echo $row->child_name; ?>', '<?php echo $row->child_name_arabic; ?>');"
												  title="Edit"><?php if ($this->lang->line('back_Edit') != '') {
													echo stripslashes($this->lang->line('back_Edit'));
												} else echo "Edit"; ?></span>
											</span>
										<?php 	
												 if($row->child_used > 0){ ?>
												 	<span>
													<a class="action-icons c-delete"
														 href="javascript:void(0);"
														 title="Can't be delete. Child are used">Delete
													</a>
												</span>
											<?php }elseif($listchildvalues->num_rows() == 1){ ?>
												<span>
													<a class="action-icons c-delete"
														 href="javascript:void(0);"
														 title="Atlease One child is Present">Delete
													</a>
												</span>
											<?php }else{?>
												 <span>
													<a class="action-icons c-delete"
														 href="admin/listings/delete_child_list_value/<?php echo $row->child_id; ?>/<?php echo $this->uri->segment(4); ?>"
														 title="Delete">Delete
													</a>
												</span>
											<?php } ?>
																						
										<?php } ?>
									</td>
								</tr>
								<?php
								$i++;
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">Features Name</th>
							<th class="tip_top" title="Click to sort">Child Values</th>
							<th class="tip_top" title="Click to sort">Action</th>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<span class="clear"></span>
</div>

<script>
	$(".active_inactive").on("click", function (e) {
		var checkbox = $(this);
		if (checkbox.is(":checked") {
			e.preventDefault();
			return false;
		}
	});
</script>
<!-- script to get child details -->
<script type="text/javascript">
	function get_child_data(child_id, child_name, child_name_arabic) {

		$('#child_id').val(child_id);
		$('#child_name').val(child_name);
		$('#child_name_arabic').val(child_name_arabic);
		$('#add_btn').hide();
		$('#update_btn').show();
	}
</script>
<!-- script to update child details -->
<script type="text/javascript">
	function child_data_Update() {
		var child_id = document.getElementById('child_id').value;
		var child_name = document.getElementById('child_name').value;
		var child_name_arabic = document.getElementById('child_name_arabic').value;
		$.ajax({

			type: 'post',
			url: baseURL + 'admin/listings/update_child_data',
			data: {'child_id': child_id, 'child_name': child_name, 'child_name_arabic': child_name_arabic},
			dataType: 'json',

			success: function (json) {
				
			}
		});
		window.location.reload();
	}
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>

<script>
$(function() {
  var regExp = /[a-z]/i;
  $('.child_name_num').on('keydown keyup', function(e) {
    var value = String.fromCharCode(e.which) || e.key;

    // No letters
    if (regExp.test(value)) {
		 $("#child_name_valid").show();
      e.preventDefault();
	  setTimeout(function() { $("#child_name_valid").hide(); }, 3000);
      return false;
    }
  });
});
	$("#child_name").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^a-zA-z0-9\s]/g)) {
			document.getElementById("child_name_valid").style.display = "inline";
			$("#child_name").focus();
			$("#child_name_valid").fadeOut(5000);
			$(this).val(val.replace(/[^0-9\s]/g, ''));
		}
	});
</script>
