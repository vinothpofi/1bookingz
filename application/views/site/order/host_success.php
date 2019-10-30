<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');$user_currencycode=$this->session->userdata('currency_type');
?>
<section>
	<div class="container-fluid inviteBg"
		 style="background-image: url('<?php echo base_url(); ?>images/payment_success.jpg');"></div>
	<div class="container inviteFrnds">
	
		<p class="text-center text-success" style="margin-top: 10px;"> <?php if ($this->lang->line('page_will_redirect') != '') { echo stripslashes($this->lang->line('page_will_redirect')); } else echo "Page will redirect in"; ?> <span
				id="countdowntimer">10 </span> <?php if ($this->lang->line('single_sec') != '') { echo stripslashes($this->lang->line('single_sec')); } else echo "Seconds"; ?> </p>
				
				
		
		<div class="row">
			<div class="col-md-12">
				<div class="searchTable clear text-center"><br><br>
					<table class="table table-bordered table-stripped">
						<tr>
							<td width="50%"><?php if ($this->lang->line('Your Listing Reference Number is') != '') {
									echo stripslashes($this->lang->line('Your Listing Reference Number is'));
								} else echo "Your Listing Reference Number is"; ?></td>
							<td width="50%"><?php echo $bookingId; ?></td>
						</tr>
						<tr>
							<td><?php if ($this->lang->line('Amount paid') != '') {
									echo stripslashes($this->lang->line('Amount paid'));
								} else echo "Amount paid"; ?></td>
							<td>														
							<?php echo $currencySymbol;
							if ('USD' != $this->session->userdata('currency_type')) {	
								echo currency_conversion('USD', $user_currencycode, $payment_gross);
								} else {	
								echo $payment_gross;	
								}															//echo number_format($price, 2) . ' ' . $this->session->userdata('currency_type'); 								echo $this->session->userdata('currency_type'); 																?>															</td>
						</tr>
					</table>
					<br><br>
				</div>
			</div>
		</div>
		<?php
		$this->output->set_header('refresh:10;url=' . base_url() . 'listing/all');
		?>
	</div>
</section>
<script type="text/javascript">
	var timeleft = 10;
	var downloadTimer = setInterval(function () {
		timeleft--;
		document.getElementById("countdowntimer").textContent = timeleft;
		if (timeleft <= 0)
			clearInterval(downloadTimer);
	}, 1000);
</script>
<?php
$this->load->view('site/includes/footer');
?>
