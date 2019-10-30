<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit Commission</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'editcommission_form', 'enctype' => 'multipart/form-data', 'onsubmit' => 'return validate();');
					echo form_open_multipart('admin/commission/insertEditCommission', $attributes)
					?>
					<ul>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Promotion Type <span class="req">*</span>','promotion_type', $commonclass);	
									
									if ($commission_details->row()->seo_tag == 'host-listing') 
									{ ?>
									<p>Flat</p>
								<?php 
									} 
									else if ($commission_details->row()->seo_tag == 'experience_listing') 
									{ ?>
									<p>Flat</p>
								<?php 
									} else if ($commission_details->row()->seo_tag == 'guest_invite_accept') { ?>
									<p>Percentage</p>
							  <?php } else if($commission_details->row()->seo_tag == 'experience_booking' || $commission_details->row()->seo_tag == 'guest-booking'){
										echo '<p>Percentage</p>';
									} else
									{ ?>
									<div class="form_input">
										<?php 
											$promo = array(); 
											$promo = array(
													''			   => 'Select',
											        'flat'         => 'Flat',
											        'percentage'   => 'Percentage'
											);											

											$promoattr = array(
											        'id'     => 'gender',
											        'class'  => 'large tipTop',
											        'title'  => 'Please select the gender'	   
											);

											echo form_dropdown('promotion_type', $promo, $commission_details->row()->promotion_type, $promoattr);
										?>										
										<span id="promotion_type_warn" class="error"></span>
										<span id="promotion_type_valid" style="color:#f00;display:none;">Please select the country name</span>
									</div>
								<?php } ?>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Commission Type <span class="req">*</span>','commission_type', $commonclass);
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'commission_type',
									            'style'   	  => 'width:295px',
									            'value'   	  => $commission_details->row()->commission_type,
									            'id'          => 'commission_type',
												'readonly'	  => 'readonly',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the user Commission Type'
									        ]);
									?>
									<span id="commission_type_warn" class="error"></span>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Commission Amount <span class="req">*</span>','commission_percentage', $commonclass);
								?>
								<div class="form_input">
									<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'commission_percentage',
									            'style'   	  => 'width:295px',
									            'value'   	  => $commission_details->row()->commission_percentage,
									            'id'          => 'commission_percentage',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the Commission Amount'
									        ]);
									?>
									 <span
										id="commission_percentage_valid" style="color:#f00;display:none;">Only Numbers Allowed
									</span>
									<span id="commission_percentage_warn" class="error"></span>
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
										<input type="checkbox" name="status" <?php if ($commission_details->row()->status == 'Active'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive"/>
									</div>
								</div>
							</div>
							<?php
								echo form_input([
									'type'     => 'hidden',
									'name' 	   => 'commission_id',
									'value'    => $commission_details->row()->id
								]);
							?>
						</li>

						<li>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
											'type'     => 'button',
											'id' 	   => 'editcommission_form_button',
											'class'    => 'btn_small btn_blue',
											'value'	   => 'Update',
											'tabindex' => '4'
										]);
									?>
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
<script type="text/javascript">
	$('#editcommission_form_button').click(function ()
	{
		$('#commission_type_warn').html('');
		$('#commission_percentage_warn').html('');

		var commission_type = $('#commission_type').val();
		var commission_percentage = $('#commission_percentage').val();

		if (commission_type == '')
		{
			$('#commission_type_warn').html('Please Enter Commission Type');
			$('#commission_type').focus();
		}
		else if (commission_percentage == '')
		{
			$('#commission_percentage_warn').html('Please Enter Commission Amount');
			$('#commission_percentage').focus();
		}
		else if (isNaN(commission_percentage))
		{
			$('#commission_percentage_warn').html('Please Percentage Should be Number');
			$('#commission_percentage').focus();
		}
		else
		{
			$('#editcommission_form').submit();
		}
	});
</script>

<style>
	.error 
	{
		color: red;
	}
</style>

<?php
$this->load->view('admin/templates/footer.php');
?>

<script>
	function validate()
	{
		if ($('#promotion_type option:selected').val() == '')
		{
			document.getElementById("promotion_type_valid").style.display = "inline";
			$("#promotion_type").focus();
			$("#promotion_type_valid").fadeOut(5000);
			//alert("Please Select Country Name");
			return false;
		}

	}
</script>

<script>
	$("#commission_percentage").on('keyup', function (e)
	{
		var val = $(this).val();
		if (val.match(/[^0-9.%\s]/g))
		{
			document.getElementById("commission_percentage_valid").style.display = "inline";
			$("#commission_percentage_valid").fadeOut(5000);
			$("#commission_percentage").focus();
			$(this).val(val.replace(/[^0-9.%\s]/g, ''));
		}
	});
</script>
