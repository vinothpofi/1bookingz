<?php
//echo '<pre>'.print_r($testimonialsList->result_array());die;
$this->load->view('admin/templates/header.php');
extract($privileges);
//error_reporting(-1);

//print_r($reviewList->result_array());
 //print_r($testimonialsList);die;
?>
<div id="content">
		<div class="grid_container">
			<?php 
				$attributes = array('id' => 'display_form');
				echo form_open('admin/experience_dispute/change_expdispute_status_global',$attributes) 
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					
                    <div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php if ($allPrev == '1' || in_array('2', $Review)){?>
							
						<?php 
						}
						if ($allPrev == '1' || in_array('3', $Review)){
						?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)" onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');" class="tipTop" title="Select any checkbox and click here to delete records"><span class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>
						<?php }?>
						</div>
					</div>
					<div class="widget_content">
						<table class="display display_tbl" id="dispute_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
							S.No
							</th>
							<th class="center" title="Click to sort">
                            Rental Name
							</th>
                            <th class="center" title="Click to sort">
                            Dispute Message
							</th>
                             <th class="center" title="Click to sort">
                           Dispute Email
							</th>
							<th class="center" title="Click to sort">
                            Date added
							</th>
                            <th class="center" title="Dispute Status">
                            Status
                            </th>
							<th>
								Action
							</th>
						</tr>
						</thead>
						<tbody>

						<?php
						
						$i=1;
						if (count($expdisputecancelbooking->result_array()) > 0){
							foreach($expdisputecancelbooking->result_array() as $row){
						?>
						<tr>
							<td class="center tr_select ">
								<input name="checkbox_id[]" type="checkbox" value="<?php echo $row['id'];?>">
							</td>
							<td class="center  tr_select">
								<?php echo $i;?>
							</td>
							<td class="center tr_select ">
                                <a href = "<?php echo base_url();?>rental/<?php echo $row['experience_id'];?>" target="_blank"><?php echo ucfirst($row['experience_title']);?></a>
							</td>
                             <td class="center tr_select ">
                                <?php echo ucfirst($row['message']);?>
							</td>
                            <td class="center tr_select ">
                                <?php echo $row['email'];?>
							</td>
                            <td class="center tr_select ">
                                <?php echo date('m-d-Y', strtotime($row['created_date']));?>
							</td>
                            <td class="center tr_select ">
                                <?php  //malar - 10/07/2017
							if($row['status']=='Accept'){
							?>
								<span class="badge_style b_done"><?php echo "Cancel Booking";?></span>
							<?php
							}elseif($row['status']=='Reject'){
								?>

								<span class="badge_style" style="background-color: rgb(206, 10, 10);border-color:#771515"><?php echo $row['status'];?></span>
							
								<?php
							} else{
							?>
								<span class="badge_style"><?php echo $row['status'];?></span>
							<?php } ?>
							</td>
                            
							<td class="center">
								<span><a class="action-icons c-suspend" href="admin/experience_dispute/view_exp_cancel_booking/<?php echo $row['booking_no'];?>" title="View">View</a></span>   
								
							</td>
						</tr>
						<?php 
							$i=$i+1;}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th><span class="tip_top">S.No.</span></th>
						    <th><span class="center">Rental Name</span></th>
		                    <th><span class="center">Dispute Message</span></th>
		                    <th><span class="center">Dispute Email</span></th>
		                 	<th>Date added</th>
		                   	<th class="center"> Status  </th>
							<th>Action</th>
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