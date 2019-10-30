<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<script type="text/javascript">
	function checkHostPaypalEmail(id)
	{
		paypalEmail = $("#hostPayPalEmail" + id).val();
		
		if (paypalEmail != 'no')
		{
			return true;
		}
		else
		{
			alert('No Host Paypal Email.');
			return false;
		}
	}
</script>

<div id="content">
	<div class="grid_container">
		<?php
		?>
		<div class="grid_12">
			<div class="right" style="color: #fff;">
				<h5>Admin Total Profit: <?php echo $admin_currency_symbol . ' ' . $adminProfit; ?></h5>
				<br>
				<h5>Total Used Wallet Amount: <?php echo $admin_currency_symbol . ' ' . $tot_usedWallet; ?></h5>
				<br>
				<h5>Balance: <?php echo $admin_currency_symbol . ' ' . ($adminProfit - $tot_usedWallet); ?></h5>
			</div>
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
					</div>
				</div>
				<div class="widget_content">
					<table class="display display_tbl" id="wallet_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">SNo.</th>
							<th class="tip_top" title="Click to sort">Name</th>
							<th class="tip_top" title="Click to sort">Email</th>
							<th class="tip_top" title="Total Amount on Wallet">Total Wallet Amnt
							</th>
							<th class="tip_top" title="Total Amount used from wallet">Used Wallet
							</th>
							<th class="tip_top" title="Available Balance  on Wallet">Balance</th>
						</tr>
						</thead>
						<tbody>
						
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">SNo.</th>
							<th class="tip_top" title="Click to sort">Name</th>
							<th class="tip_top" title="Click to sort">Email</th>
							<th class="tip_top" title="Click to sort">Total Wallet Amnt</th>
							<th class="tip_top" title="Click to sort">Used Wallet</th>
							<th class="tip_top" title="Click to sort">Balance</th>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<?php
			echo form_input([
				'type'     => 'hidden',
				'id'       => 'statusMode',
				'name' 	   => 'statusMode'
			]);
		?>

	</div>
	<span class="clear"></span>
</div>
</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#wallet_tbl').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						
						url :"<?php echo base_url(); ?>admin/commission/display_wallet_payments_list_datatables", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							// $(".employee-grid-error").html("");
							// $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							// $("#employee-grid_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>