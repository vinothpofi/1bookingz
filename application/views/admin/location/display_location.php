<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/location/change_location_status',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<?php if ($allPrev == '1' || in_array('1', $ManageCountry))
						{?>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<div class="btn_30_light" style="height: 29px; text-align:left;">
								<a href="admin/location/add_location_form" class="tipTop" title="Click here to add Country"><span class="icon add_co"></span><span class="btn_link">Add New</span>
								</a>
							</div>
						</div>
						<?php 
						} ?>
					</div>

					<div class="widget_content">
						<table class="display" id="location_tbl">
						<thead>
						<tr>							
							<th class="tip_top" title="Click to sort">Country Name</th>
                            <th>Zones</th>
                            <th>Status</th>
							<th>Action</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($locationList->num_rows() > 0)
						{
							foreach ($locationList->result() as $row)
							{
						?>
						<tr>							
							<td class="center  tr_select"><?php echo $row->name;?></td>
                            <td class="center"> 
                            <div class="btn_30_light">
                                <a href="admin/location/display_tax_statelist/<?php echo $row->id;?>" class="tipTop" title="View Zones">
                                <span class="icon zones_co"></span>
                                <span class="btn_link">Zones</span>
                                </a>
                            </div>                           
							</td>
							<td class="center">
							<?php 
							if ($allPrev == '1' || in_array('2', $ManageCountry))
							{
								if($row->status == 'Active')
								{								
							?>
								<span class="badge_style b_done"><a href="<?php base_url();?>admin/location/change_location_status/InActive/<?php echo $row->id;?>">Active</a>
								</span>
							<?php
								}
								else
								{	
							?>
								<span class="badge_style"><a href="<?php base_url();?>admin/location/change_location_status/Active/<?php echo $row->id;?>">InActive</a>
								</span>
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
							<?php if ($allPrev == '1' || in_array('2', $ManageCountry)){?>
								<span><a class="action-icons c-edit" href="admin/location/edit_location_form/<?php echo $row->id;?>" title="Edit">Edit</a></span>
							<?php }?>
								<span><a class="action-icons c-suspend" href="admin/location/view_location/<?php echo $row->id;?>" title="View">View</a>
								</span>
							<?php if ($allPrev == '1' || in_array('3', $ManageCountry))
							{							
								if($row->status!='Active')
								{							
							?>                            	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/location/delete_location/<?php echo $row->id;?>')" title="Delete">Delete</a>
								</span>
							<?php }
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
							<th>Country Name</th>
                            <th>Zones</th>
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