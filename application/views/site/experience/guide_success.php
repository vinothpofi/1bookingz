<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
	<div class="container-fluid inviteBg"
		 style="background-image: url('<?php echo base_url(); ?>images/payment_success.jpg');"></div>
	<div class="container inviteFrnds">
		<p class="text-center text-success" style="margin-top: 10px;"> Page will redirect in <span
				id="countdowntimer">5 </span> Seconds</p>
		<div class="heading">
			<h2><?php if ($this->lang->line('Thanks for your Listing') != '') {
					echo stripslashes($this->lang->line('Thanks for your Listing'));
				} else echo "Thanks for your Listing"; ?></h2>
			<h5><?php if ($this->lang->line('We are glad that you choose our service, please review us after your journey') != '') {
					echo stripslashes($this->lang->line('We are glad that you choose our service, please review us after your journey'));
				} else echo "We are glad that you choose our service, please review us after your journey"; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="searchTable clear text-center"><br><br>
                  <div class="table-responsive">
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
							<td><?php 
								echo $currencySymbol;
								if ('USD' != $this->session->userdata('currency_type')) {	
									echo currency_conversion('USD', $this->session->userdata('currency_type'), $payment_gross);
									} else {	
									echo $payment_gross;	
									}	
								/*	echo $this->db->select('*')->from('fc_currency')->where('currency_type = ', $exper_list->currency_code_host)->get()->row()->currency_symbols.' ';
								if ("USD" == $this->session->userdata('currency_type')) {
									$price = currency_conversion("USD", $this->session->userdata('currency_type'), $price);
								}
								echo number_format($price, 2) . ' ' . $exper_list->currency_code_host;*/ ?></td>
						</tr>
					</table>
				</div>
					<br><br>
				</div>
			</div>
		</div>
		<?php
		/*print_r($_REQUEST);
		echo '<hr>';
		print_r($printr);
		Array ( [/guide-payment-success/32/7] => [payer_email] => nagoorbuyers@gmail.com [payer_id] => KNPGA48HMPF2A [payer_status] => VERIFIED [first_name] => Buyer [last_name] => Nagoor [address_name] => Buyer Nagoor [address_street] => 1 Main St [address_city] => San Jose [address_state] => CA [address_country_code] => US [address_zip] => 95131 [residence_country] => US [txn_id] => 2TG54610P5923874R [mc_currency] => USD [mc_gross] => 7.00 [protection_eligibility] => INELIGIBLE [payment_gross] => 7.00 [payment_status] => Pending [pending_reason] => unilateral [payment_type] => instant [item_name] => HomeStayDnn Experiences [quantity] => 1 [txn_type] => web_accept [payment_date] => 2018-05-07T10:01:03Z [business] => kumarkailash075@gmail.com [notify_version] => UNVERSIONED [custom] => Experience|39| [verify_sign] => AfQZ8JXN3447m31txmgI-snkBnbFAZk0NJvj4SckNzQwNoi4f6Dg.jXr )*/

		$this->output->set_header('refresh:5;url=' . base_url() . 'experience/all');
		?>
	</div>
</section>
<script type="text/javascript">
	var timeleft = 5;
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
