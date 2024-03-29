<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/location/change_location_status_global',$attributes) 
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
							
							<th class="tip_top" title="Click to sort">
								 Location Name
							</th>
							<th class="center" title="Click to sort">
                            Symbol
							</th>
                            <th class="center" title="Click to sort">
                            Currency
							</th>
                            <th>
								Default
							</th>
							<th>
								Action
							</th>
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($countryList->num_rows() > 0){
							foreach ($countryList->result() as $row){
						?>
						<tr>
							
							<td class="center  tr_select">
								<?php echo $row->name;?>
							</td>
							<td class="center tr_select ">
                                <?php echo $row->currency_symbol;?>
							</td>
                            <td class="center tr_select ">
                                <?php echo $row->currency_type;?>
							</td>
							<td class="center">
                            <span><a class="action-icons c-edit" href="admin/tax/display_tax_statelist/<?php echo $row->id;?>" title="Zones">Zones</a></span>
							</td>
							<td class="center">
							<?php if ($allPrev == '1' || in_array('2', $Location)){?>
								<span><a class="action-icons c-edit" href="admin/location/edit_location_form/<?php echo $row->id;?>" title="Edit">Edit</a></span>
							<?php }?>
								<span><a class="action-icons c-suspend" href="admin/location/view_location/<?php echo $row->id;?>" title="View">View</a></span>
							<?php if ($allPrev == '1' || in_array('3', $Location)){
							
							if($row->status!='Active'){
							
							?>
                            	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/location/delete_location/<?php echo $row->id;?>')" title="Delete">Delete</a></span>
							<?php } }?>
							</td>
						</tr>
						<?php 
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							
							<th>
								 Location Name
							</th>
							<th class="center">
								Symbol
							</th>
							<th>
								 Currency
							</th>
                            <th>
								 Default
							</th>
							<th>
								 Action
							</th>
						</tr></tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div>
</div>
<?php 
$this->load->view('admin/templates/footer.php');
?>