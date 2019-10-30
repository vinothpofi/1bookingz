<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open(ADMIN_PATH.'/help/change_help_status_sub_menu',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6 style="text-align: center;"><?php echo $heading?></h6>
						
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<div class="btn_30_light" style="height: 29px; text-align:left;">
								<a href="admin/banner/addnew_banner" class="tipTop" title="Click here to add Main help page"><span class="icon add_co"></span><span class="btn_link">Add New</span></a>
							</div>
						
						</div>
					</div>
					<div class="widget_content">
						<table class="display" id="currency_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
								Banner
							</th>
							
							<th class="tip_top" title="Click to sort">
								Title
							</th> 
							<th class="tip_top" title="Click to sort">
								Subtitle
							</th>
							<th class="tip_top" title="Click to sort">
								Status
							</th> 							
                            <th class="tip_top" title="Click to sort">
								Action
							</th> 
                            
						</tr>
						</thead>
						<tbody>
						<?php 
						if ($mainmenu->num_rows() > 0){
							foreach ($mainmenu->result() as $row){
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row->id;?>">
							</td>
							<td class="center  tr_select">
								<?php echo $row->banner;?>
							</td>
							
							<td class="center  tr_select">
								<?php echo $row->title;?>
							</td>
							<td class="center  tr_select">
								<?php echo $row->subtitle;?>
							</td>
                             
                            <td class="center tr_select ">
                                <?php 
							if ($allPrev == '1' || in_array('2', $Listspace)){
								$mode = ($row->status == 'Active')?'0':'1';
								if ($mode == '0'){
							?>
								<a title="Click to inactive" class="tip_top" href="javascript:confirm_status('admin/banner/change_main_menu_status/<?php echo $mode;?>/<?php echo $row->id;?>');"><span class="badge_style b_done"><?php echo 'Active';?></span></a>
							<?php
								}else {	
							?>
								<a title="Click to active" class="tip_top" href="javascript:confirm_status('admin/banner/change_main_menu_status/<?php echo $mode;?>/<?php echo $row->id;?>')"><span class="badge_style"><?php echo 'Inactive';?></span></a>
							<?php 
								}
							}else {
							?>
							<span class="badge_style b_done"><?php echo $row->status;?></span>
							<?php }?>
							</td>
							<td align="center">
								
								<?php if ($allPrev == '1' || in_array('2', $Listspace)){?>
								<span><a class="action-icons c-edit" href="admin/banner/edit_helplist_form/<?php echo $row->id;?>" title="Edit">Edit</a></span>
							<?php }?>
								

							<?php if ($allPrev == '1' || in_array('3', $Listspace)){?>	
								<span><a class="action-icons c-delete" href="javascript:confirm_delete('admin/banner/delete_help_list/<?php echo $row->id;?>')" title="Delete">Delete</a></span>
							<?php }?>

							</td>
                           
							
						</tr>
						<?php 
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
								Banner
							</th>
							<th class="tip_top" title="Click to sort">
								 Title
							</th>
                            
							<th class="tip_top" title="Click to sort">
								Subtitle
							</th> 
							
							<th class="tip_top" title="Click to sort">
								Status
							</th> 
                            <th class="tip_top" title="Click to sort">
								Action
							</th> 
                            
						</tr>
					   </tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
		</form>	
			
		</div>
		<span class="clear"></span>
	</div></div>
	<script type="text/javascript">
$('#currency_tbl').dataTable({   
	"aoColumnDefs": [
	                 { "bSortable": false, "aTargets": [4] }
	                 ],
	                 "aaSorting": [[3, 'desc']],
	                 "sPaginationType": "full_numbers",
	                 "iDisplayLength": 100,
	                 "oLanguage": {
	                	 "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>",	
	                 },
	                 "sDom": '<"table_top"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>'
	                	 
});
</script>
<style>
#currency_tbl tr td,#currency_tbl tr th{
	border-right:#ccc 1px solid;
}
</style>

<?php 
$this->load->view('admin/templates/footer.php');
?>