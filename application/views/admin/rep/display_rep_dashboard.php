<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<?php
$active_users = $inactive_users = 0;
if ($repList->num_rows() > 0) 
{
	foreach ($repList->result() as $row) 
	{
		$status = strtolower($row->status);
		if ($status == 'active') 
		{
			$active_users++;
		} 
		else 
		{
			$inactive_users++;
		}
	}
}
?>
	<script type="text/javascript">
		/*=================
        CHART 5
        ===================*/
		$(function () 
		{
			plot2 = jQuery.jqplot('chart5',
				[[['Active',<?php echo $active_users; ?>], ['Inactive', <?php echo $inactive_users; ?>]]],
				{
					title: ' ',
					seriesDefaults: {
						shadow: false,
						renderer: jQuery.jqplot.PieRenderer,
						rendererOptions: {
							startAngle: 180,
							sliceMargin: 4,
							showDataLabels: true
						}
					},
					grid: {
						borderColor: '#ccc', /*CSS color spec for border around grid.*/
						borderWidth: 2.0,    /*pixel width of border around grid.*/
						shadow: false        /*draw a shadow for grid.*/
					},
					legend: {show: true, location: 'w'}
				}
			);
		});

	</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/charts/loader.js"></script>
	<script type="text/javascript">
	  google.charts.load('current', {'packages':['corechart']});
	  google.charts.setOnLoadCallback(drawChart);

	  function drawChart() {

	    var data = google.visualization.arrayToDataTable([
	        ['Total Representatives', 'Total'],
	        ['Active Representatives', <?php echo intval($active_users); ?>],
	        ['Inactive Representatives',<?php echo intval($inactive_users); ?>]
	    ]);
	      var options = {
	          height: 350,width: 525,pieSliceText: 'value-and-percentage',
	      };
	    var chart = new google.visualization.PieChart(document.getElementById('chart_rep'));
	    chart.draw(data, options);
	  }
	</script>
	<div id="content">
		<div class="grid_container">
			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading; ?></h6>
					</div>
					<div class="widget_content">
							
						<div id="chart_rep"></div>
						<!-- <?php if ($repList->num_rows() > 0) { ?>
							<h4>Total Representatives : <?php echo $repList->num_rows(); ?></h4>
						<?php } else { ?>
							<h4>No Representatives Available</h4>
						<?php } ?>
						<div id="chart5" class="chart_block">
						</div> -->
					</div>
				</div>
			</div>

			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon h_icon users"></span>
						<h6>Representatives List</h6>
					</div>
					<div class="widget_content table-responsive1">
						<table class="wtbl_list">
							<thead>
							<tr>
								<th>Name</th>
								<th>Status</th>
								<th>Email-ID</th>
								<th>Rep. Code</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($repList->num_rows() > 0) 
							{
								$result = $repList->result_array();
								for ($i = 0; $i < 5; $i++) 
								{
									if (isset($result[$i]) && is_array($result[$i])) 
									{
										?>
										<tr class="tr_even">
											<td>
												<?php echo ucfirst($result[$i]['admin_name']); ?>
											</td>
											<td>
												<?php echo $result[$i]['status']; ?>
											</td>
											<td>
												<?php echo $result[$i]['email']; ?>
											</td>
											<td>
												<?php echo $result[$i]['admin_rep_code']; ?>
											</td>
										</tr>
										<?php
									}
								}
							} 
							else 
							{
								?>
								<tr>
									<td colspan="5" align="center">No Rep. Available</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
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
