<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/location/change_tax_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>						
					</div>
					<div class="widget_content">
						<table class="display" id="newsletter_tbl">
						<thead>
						<tr>							
							<th class="tip_top" title="Click to sort">Country Name</th>
							<th class="center" title="Click to sort">State Name</th>
                            <th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($taxList->num_rows() > 0)
						{
							foreach ($taxList->result() as $row)
							{
						?>
						<tr>
							 <td class="center tr_select ">
                                <?php echo $CountryList->row()->name;?>
							</td>
							<td class="center  tr_select">
								<?php echo $row->name;?>
							</td>
							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $tax))
							{
								$mode = ($row->status == 'Active')?'0':'1';
								if ($mode == '0')
								{
							?>
								<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('admin/location/change_tax_status/<?php echo $mode;?>/<?php echo $row->id;?>');"><span class="badge_style b_done"><?php echo $row->status;?></span>
								</a>
							<?php
								}
								else
								{	
							?>
								<a title="Click to active" class="tip_top" href="javascript:confirm_status('admin/location/change_tax_status/<?php echo $mode;?>/<?php echo $row->id;?>')"><span class="badge_style"><?php echo $row->status;?></span>
								</a>
							<?php 
								}
							}
							else
							{
							?>
							<span class="badge_style b_done"><?php echo $row->status;?></span>
							<?php 
							}?>
							</td>
							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $tax))
							{?>
								<span><a class="action-icons c-edit" href="admin/location/edit_tax_form/<?php echo $row->id;?>" title="Edit">Edit</a>
								</span>
							<?php 
							}?>
								<span><a class="action-icons c-suspend" href="admin/location/view_tax/<?php echo $row->id;?>" title="View">View</a>
								</span>
							<?php 
							if ($allPrev == '1' || in_array('3', $tax))
							{
							?>                            	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/location/delete_tax/<?php echo $row->id;?>')" title="Delete">Delete</a>
								</span>
							<?php  
							}?>
							</td>
						</tr>
						<?php 
							}
						}
						?>
						</tbody>
						<tfoot>
							<tr>
							<th class="tip_top" title="Click to sort">Country Name</th>
							<th class="center" title="Click to sort">State Name</th>
                            <th>Status</th>
							<th>Action</th>
						</tr></tfoot>
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

				echo form_close();	
			?>
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>