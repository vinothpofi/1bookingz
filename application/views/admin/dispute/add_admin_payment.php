<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6><?php echo $heading; ?></h6>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'add_vendor_payment_form');
					echo form_open_multipart('admin/dispute/add_admin_payment_manual', $attributes)
					?>
					<ul>
						<?php
							echo form_input([
							'type'     => 'hidden',
							'value'    =>  $hostEmail,
							'name' 	   => 'hostEmail'
							 ]);

							echo form_input([
							'type'     => 'hidden',
							'value'    =>  $bookid,
							'name' 	   => 'bookid'
							 ]);
						?>
						<li>
							<div class="form_grid_12">
								<?php
									$commonclass = array('class' => 'field_title');

									echo form_label('Transaction Id <span class="req">*</span>','transaction_id', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'       => 'text',      
									            'name' 	     => 'transaction_id',
									            'id'	     => 'transaction_id',
									            'class'      => 'required large tipTop',
									            'tabindex'	 => '1',
									            'title'  	 => 'Please enter the transaction id',
									            'onkeypress' => 'return check_for_num(event)'
									    ]);
									?>
								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<?php

									echo form_label('Amount <span class="req">*</span>','amount', $commonclass);	
								?>
								<div class="form_input">
									<?php
										echo form_input([
												'type'      => 'text',      
									            'name' 	    => 'amount',
									            'class'     => 'required number large tipTop',
									            'tabindex'	=> '3',
									            'title'  	=> 'Please enter the amount',
									            'readonly'	=> 'readonly',
									            'value'		=> number_format($payableAmount, 2, '.', '')
									    ]);
									?>
									<span
										class="input_instruction green">Balance amount is <?php echo $admin_currency_symbol . number_format($payableAmount, 2, '.', ''); ?>		
									</span>
								</div>
							</div>
						</li>

						<li>
							<?php
								echo form_input([
								'type'     => 'hidden',
								'value'    => $guestEmail,
								'name' 	   => 'balance_due'
								 ]);
							?>
							<div class="form_grid_12">
								<div class="form_input">
									<?php
										echo form_input([
										'type'     => 'submit',
										'value'    => 'ADD PAYMENT',
										'class'    => 'btn_small btn_blue'
										 ]);
									?>
									<a href="<?php echo base_url() . "admin/dispute/cancel_booking_payment"; ?>">
										<button type="button" class="btn_small btn_blue" tabindex="4"><span>Cancel</span></button>
									</a>
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
	$('#add_vendor_payment_form').validate();
</script>

<script>
	function check_for_num(evt)
	{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57))
		{
			return false;
		}
		return true;
	}
</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
