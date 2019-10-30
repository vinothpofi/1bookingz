<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>View Listing Child Values</h6>
				</div> 
				<div id="season_table">
					<table class="display display_tbl" id="subadmin_tbl">
						<thead>
						<tr>
							<th class="tip_top" title="Click to sort">List Name</th>
							<th class="tip_top" title="Click to sort">Child Values</th>
						</tr>
						</thead>
						<tbody>
						<?php
						
						if ($listchildvalues->num_rows() > 0)
						{
							$i = 1;
							foreach ($listchildvalues->result() as $row) 
							{
								?>
								<tr>
									<td class="center">
										<?php echo ucfirst($row->labelname); ?>
									</td>
									<td class="center">
										<?php echo $row->child_name; ?>
									</td>
								</tr>
								<?php
								$i++;
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="tip_top" title="Click to sort">List Name</th>
							<th class="tip_top" title="Click to sort">Child Values</th>
						</tr>
						</tfoot>
					</table>
					<div class="form_input" style="margin-left: 514px">
						<a href="admin/listings/listing_child_values" class="tipLeft"
						   title="Go to listing child values"><span class="badge_style b_done">Back</span>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<span class="clear"></span>
</div>

