<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<div>
						    <h2>Dear Admin</h2>
						    <span>Your payment was successful.</span><br/>
						    <span>Transaction Number : 
						        <strong><?php echo $txn_id; ?></strong>
						    </span><br/>
						    
						    <span>Amount Paid : 
						        <strong>$<?php echo $payment_gross.' '.$currency_code; ?></strong>
						    </span><br/>
						    
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>	
