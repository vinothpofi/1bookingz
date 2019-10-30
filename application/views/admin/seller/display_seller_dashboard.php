<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<?php
/*$active_users = $inactive_users = 0;
if ($usersList->num_rows() > 0) 
{
	foreach ($usersList->result() as $row) 
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
}*/
?>

<?php
/*$active_users1 = $archivedUser1 = $inactive_users1 = 0;
if ($usersList->num_rows() > 0) 
{
	foreach ($usersList->result() as $row) 
	{
		$status = strtolower($row->status);
		if ($status == 'active' && $row->host_status == '0') 
		{
			$active_users1++;
		} 
		else if ($row->host_status == '1') 
		{
			$archivedUser1++;
		} 
		else if ($status == 'inactive' && $row->host_status == '0') 
		{
			$inactive_users1++;
		}
	}
}*/

?>

<script type="text/javascript" src="<?php echo base_url(); ?>js/admin/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Hosts','Total'],
            ['Active Hosts', <?php echo intval($active_users); ?>],
            ['Inactive Hosts',<?php echo intval($inactive_users); ?>],
            ['Archived Hosts',<?php echo intval($archived_users); ?>]
        ]);
        var options = {
            height: 350,width: 525,pieSliceText: 'value-and-percentage',
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_user'));
        chart.draw(data, options);
    }
</script>
	<div id="content">
		<div class="grid_container">
			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Host Dashboard</h6>
					</div>
					<div class="widget_content ">
						<?php if ($usersList->num_rows() > 0) { ?>
							<h4><?php echo $usersList->num_rows(); ?> Host registered in this site</h4>    <br>

							<div style="margin-left:20px">
								<table class="table" width="30%">
								<tr><td width="25%" align="right"><small>Active Host :&nbsp; </td><td width="5%" align="left"><?php echo $active_users; ?></small></td></tr>
								<tr><td  width="25%" align="right">
								<small>In Active Host :&nbsp; </td><td width="5%" align="left"><?php echo $inactive_users; ?></small></td></tr>
								<tr><td  width="25%" align="right">
								<small>Archived Host :&nbsp; </td><td width="5%" align="left"><?php echo $archived_users; ?></small></td></tr>
								</table>
							</div>
						<?php } else { ?>
							<h4>No host registered in this site</h4>
						<?php } ?>						
						<div id="chart_user" class="chart_block">
						</div>
					</div>
				</div>
			</div>

			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon image_1"></span>
						<h6>Recent Host</h6>
					</div>
					<div class="widget_content table-responsive1">
						<table class="wtbl_list">
							<thead>
							<tr>
								<th>Full Name</th>
								<th>Status</th>
								<th>Email-ID</th>
								<th>Image</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ($usersList->num_rows() > 0) 
							{
								$result = $usersList->result_array();
								for ($i = 0; $i < 5; $i++) 
								{
									if (isset($result[$i]) && is_array($result[$i])) 
									{
										?>
										<tr class="tr_even">
											<td>
												<?php echo ucfirst($result[$i]['firstname']) . ' ' . ucfirst($result[$i]['lastname']); ?>
											</td>
											<td>
												<?php echo $result[$i]['status']; ?>
											</td>
											<td>
												<?php echo $result[$i]['email']; ?>
											</td>
											<td>
												<div class="widget_thumb">
													<?php if ($result[$i]['image'] != '') { ?>
														<img width="40px" height="40px"
															 src="<?php echo base_url(); ?>images/users/<?php echo $result[$i]['image']; ?>"/>
													<?php } else { ?>
														<img width="40px" height="40px"
															 src="<?php echo base_url(); ?>images/users/user-thumb1.png"/>
													<?php } ?>
												</div>
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
									<td colspan="5" align="center">No Host Available</td>
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
