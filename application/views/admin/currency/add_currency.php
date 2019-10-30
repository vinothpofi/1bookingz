<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New Currency</h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'utf-8');
					echo form_open(ADMIN_PATH . '/currency/insertEditCurrency', $attributes);
					?>
					<div id="tab1">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Country Name <span class="req">*</span>','country_name', $commonclass);	
									?>
									<div class="form_input">
										<?php

										$ctrname=array();
										$ctrname[''] = 'Select Country';

										if ($countryList->num_rows() > 0)
										{
											foreach ($countryList->result() as $get_list)
											{
												$ctrname[$get_list->name]=$get_list->name;
											}
										}	 

										$repattr = array(
											    'id'       => 'name',
											    'title'    => 'Please select the country name',
											    'style'    => 'width:295px; height:25px;',
											    'class'    => 'required tipTop',
											    'onchange' => 'get_suggestion(this.value);'
										);

										echo form_dropdown('country_name', $ctrname, '', $repattr);

										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Currency Symbol <span class="req">*</span>','currency_symbols', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'currency_symbols',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '5',
									            'id'          => 'currency_symbols',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the currency name'
									        ]);
										?>
										<span id="currency_symbol_valid" style="color:#f00;display:none;">Numbers Not Allowed!</span>
										<?php
											$currsyml=array('id' => 'currency_symbol_len','style' => 'font-size:12px;display:none;','class' => 'error');
											echo form_label('Max 5 Characters Allowed','currency_symbols', $currsyml);	
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Currency Type <span class="req">*</span>','currency_type', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'currency_type',
									            'style'   	  => 'width:295px',
									            'maxlength'   => '50',
									            'id'          => 'currency_type',
												'tabindex'	  => '1',
												'class'		  => 'required tipTop',
												'title'		  => 'Please enter the currency code'
									        ]);
										?>
										<span
											id="currency_type_valid" style="color:#f00;display:none;">Only Characters Allowed!</span>
										<?php
											$currtyp=array('id' => 'currency_type_len','style' => 'font-size:12px;display:none;','class' => 'error');
											//echo form_label('Max 50 Characters Allowed','currency_symbols', $currtyp);
										?>
										<br/><br/>

										<span style="font-size:14px; color:#CC3300;">*Note: Add the currency code accept by Paypal, to view the currency codes click the Below link,<br/><br/>
										<a	href="javascript: void(0)" onclick="window.open('https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ ', 'Paypal Currency Code', 'width=1200, height=1200');
                                             return false;">https://developer.paypal.com/webapps/developer/docs/classic/api/currency_codes/ 
                                         </a>
                                     	</span>
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
										<?php
											echo form_input([
												'type'     => 'submit',
												'value'    => 'Submit',
												'class'    => 'btn_small btn_blue'
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

<script>
	$("#currency_symbol").on('keyup', function (e)
	{
		var val = $(this).val();
		if (val.match(/[^0-9\s]/g)) 
		{

		}
		else
		{
			document.getElementById("currency_symbol_valid").style.display = "inline";
			$("#currency_symbol_valid").fadeOut(5000);
			$("#currency_symbol").focus();
			$("#currency_symbol").val('');
		}
	});


	$("#currency_symbol").on('keypress', function (e)
	{
		var val = $(this).val();
		if (val.length == 5)
		{
			document.getElementById("currency_symbol_len").style.display = "inline";
			$("#currency_symbol_len").fadeOut(5000);
		}
	});

	$("#currency_type").on('keypress', function (e)
	{
		var val = $(this).val();
		if (val.length == 5)
		{
			document.getElementById("currency_type_len").style.display = "inline";
			$("#currency_type_len").fadeOut(5000);
		}
	});

	function get_suggestion(country_name)
	{
		$.post("admin/currency/get_currency_code_and_symbol",
			{
				country_name: country_name
			},
			function (data, status)
			{
				var data = data.trim();
				var obj = JSON.parse(data);
				var code = obj.code;
				var symbol = obj.symbol;
				$("#currency_symbols").val(symbol);
				$("#currency_type").val(code);
			});
	}
</script>
