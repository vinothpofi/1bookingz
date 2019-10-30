<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Currency Conversion</h6>
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
									<label for="country_name" class="field_title">Date<span class="req">*</span></label>
									<div class="form_input">
										<input type="text" class="col-sm-2" placeholder="mm/dd/yyyy" id="datetimepicker1" style="cursor:pointer;width:295px;" name="from_date" value="<?php echo date('m/d/Y',strtotime($curren_date));?>">
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label for="country_name" class="field_title">From Currency<span class="req">*</span></label>
									<div class="form_input">
										
										<select name="fromCurrency" id="fromCurrency" class="select2 col-sm-2" style="padding:5px 2px;" onchange="get_result1();">
											<?php 
											if(count($currencies) > 0 )
											{
												foreach($currencies as $currencee)
												{
													echo '<option value="'.$currencee->currency_type.'">'.$currencee->currency_type.'</option>';
												}
											}
											?>
										</select>
										<input type="text" class="col-sm-2" placeholder="Amount" id="amountIs1" name="amount" value="" style="width:295px;" >
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label for="country_name" class="field_title">To Currency<span class="req">*</span></label>
									<div class="form_input">
										
										<select name="toCurrency" id="toCurrency" class="select2 col-sm-2" style="padding:5px 2px;" >
											<?php 
											if(count($currencies) > 0 )
											{
												foreach($currencies as $currencee)
												{
													echo '<option value="'.$currencee->currency_type.'">'.$currencee->currency_type.'</option>';
												}
											}
											?>
										</select>
										<input type="text" class="col-sm-2" placeholder="Amount" id="amountIs2" name="amount" value="" style="width:295px;"  readonly="readonly">
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
								<div class="form_input">
									<input type="button" class="btn_blue btn_small" value="submit" onclick="get_result1();">
								</div>
								</div>
							</li>					

							<li>
								<div class="form_grid_12">
									<label for="country_name" class="Result_label"></label>
									<div class="form_input">
										<label for="country_name" class="Result_label2"><img src="<?php echo base_url().'assets/img/loader.gif';?>" style="width: 100px;display:none" id="my_loader"  /></label>
									</div>
								</div>
							</li>

							<!--<li>
								<div class="form_grid_12">
									<div class="form_input">
										<input type="button" value="Convert" class="btn_small btn_blue" onclick="getResult();">
									</div>
								</div>
							</li>-->
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
$(document).ready(function(){
	//$('#datetimepicker1').datepicker();
	$("#datetimepicker1").datepicker({
		onSelect: function(dateText, inst) { get_result1(); }
	});
});
	function get_result1() {
		var date = $('#datetimepicker1').val();
		var amount = $('#amountIs1').val();
		var fromCurrency = $('#fromCurrency').val();
		var toCurrency = $('#toCurrency').val();
		$.ajax({
					type: 'POST',
					url: '<?php echo base_url();?>/admin/Currency/getValue',
					data: {date: date, amount: amount,fromCurrency: fromCurrency, toCurrency: toCurrency},
					beforeSend:function(){
						$('#my_loader').show();
					},
					success: function (response) {
						$('#my_loader').hide();
						$('#amountIs2').val(response);

					}
				});
	}
	function get_result2() {
		var date = $('#datetimepicker1').val();
		var amount = $('#amountIs1').val();
		var fromCurrency = $('#fromCurrency').val();
		var toCurrency = $('#toCurrency').val();
		$.ajax({
					type: 'POST',
					url: '<?php echo base_url();?>/admin/Currency/getValue',
					data: {date: date, amount: amount,fromCurrency: fromCurrency, toCurrency: toCurrency},
					beforeSend:function(){
						$('#my_loader').show();
					},
					success: function (response) {
						$('#my_loader').hide();
						$('#amountIs2').val(response);

					}
				});
	}

</script>
