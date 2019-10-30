<style>
    #subadmin_tbl_paginate{
        display: none;
    }
    .dataTables_filter {
  
    margin: 6px 0;
}
.name_filter input{
	background: none !important;
	padding: 5px 21px 5px 21px !important;
}
</style>
<?php

$this->load->view('admin/templates/header.php');
extract($privileges);

?>
<div id="content">
	<div class="grid_container">
		<?php
		$attributes = array('id' => 'display_form');
		echo form_open('admin/experience/change_experience_status_global', $attributes);
		//echo $experienceList->num_rows();exit();
		?>
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php if ($allPrev == '1' || in_array('2', $Experience)) { ?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)"
								   onclick="return checkBoxValidationAdmin('1','<?php echo $subAdminMail; ?>');"
								   class="tipTop" title="Select any checkbox and click here to publish records"><span
										class="icon accept_co"></span><span class="btn_link">Publish</span></a>
							</div>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)"
								   onclick="return checkBoxValidationAdmin('0','<?php echo $subAdminMail; ?>');"
								   class="tipTop" title="Select any checkbox and click here to unpublish records"><span
										class="icon delete_co"></span><span class="btn_link">UnPublish</span></a>
							</div>
							<?php
						}
						if ($allPrev == '1' || in_array('3', $Experience)) {
							?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)"
								   onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
								   class="tipTop" title="Select any checkbox and click here to delete records"><span
										class="icon cross_co"></span><span class="btn_link">Delete</span></a>
							</div>
						<?php } ?>
						<div class="btn_30_light" style="height: 29px;">
							<a href="admin/experience/customerExcelExport" class="tipTop"
							   title="Click export all property list"><span class="icon cross_co"></span><span
									class="btn_link">Export All Experience</span></a>
						</div>
					</div>
				</div>
				
				<div class="name_filter">
					<div class="dataTables_filter" id="experience_name_filter"><label><strong>Search: </strong> 
					
						<input placeholder="Enter Name" type="text" value="" name="experience_name_filter_val">
						<input type="button" onclick="experience_name_filter();" class="btn btn-block btn-success" value="Search" name="experience_name_filter_val">	
						<input type="button" onclick="experience_name_filter_reset();" class="btn btn-block btn-success" value="Reset" name="experience_name_filter_val">	
					
        </label></div>
				</div>

				<div class="widget_content table-res">
					<table class="display display_tbl">
						<thead>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th class="tip_top" title="Click to sort">
								Experience Name
							</th>
							<th class="tip_top" title="Click to sort">
								Experience Id
							</th>
							<th class="tip_top" title="Click to sort">
								Currency Type (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Host) <a class="tip_top" title="Price in Host's Currency code"><i class="fa fa-info-circle fa-lg"></i></a>
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Admin) <a class="tip_top" title="Price in Admin's Currency code"><i class="fa fa-info-circle fa-lg"></i></a>
							</th>
							<th class="tip_top" title="Click to sort">
								Experience Type
							</th>
							<th class="tip_top" title="Click to sort">
								Category Name
							</th>
							<th class="tip_top" title="Click to sort">
								Added By
							</th>
							<th class="tip_top" title="Click to sort">
								Status
							</th>
							<th class="tip_top" title="Click to sort">
								Experience Created On
							</th>
							<th width="15%">
								Action
							</th>
						</tr>
						</thead>
						<tbody>
						<?php

						if ($experienceList->num_rows() > 0) {
							//print_r($experienceList->result());exit;
							foreach ($experienceList->result() as $row) {
								$img = 'dummyProductImage.jpg';
								$imgArr = explode(',', $row->PImg);
								if (count($imgArr) > 0) {
									foreach ($imgArr as $imgRow) {
										if ($imgRow != '') {
											$img = $imgRow;
											break;
										}
									}
								}
								if ($row->status != '2') {
									?>
									<tr>
										<td class="center tr_select ">
											<input name="checkbox_id[]" type="checkbox"
												   value="<?php echo $row->experience_id; ?>">
										</td>
										<td class="center">
											<?php echo ucfirst($row->experience_title);
											?>
										</td>
										<td class="center">
											<?php echo $row->experience_id; ?>
										</td>
										<td class="center">
											<?php echo $row->currency; ?>
										</td>
										<td -class="center" style="text-align:right">
											<?php echo $this->db->select('currency_symbols')->where('currency_type',$row->currency)->get('fc_currency')->row()->currency_symbols.$row->price; ?>
										</td>
										<td /class="center <?php echo $row->added_date;?>" style="text-align:right">
											<?php //echo $row->price;
											$expID = $row->experience_id;
											$experience_price = $row->price;
											$createdDate = date('Y-m-d',strtotime($row->added_date));
											$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
											if($gotCronId==0){ $gotCronId='';}
											echo $admin_currency_symbol;
											if ($admin_currency_code != $row->currency && ($row->currency != '' || $row->currency != '0')) {
												//echo convertCurrency($row->currency, $admin_currency_code, $experience_price);
												echo currency_conversion($row->currency, $admin_currency_code, $experience_price,$gotCronId);
											} else {
												echo $experience_price;
											}
											/*
                                            $currencyPerUnitSeller=$row->currencyPerUnitSeller;

                                            if($admin_currency_code!=$row->currency_code){
                                                //echo convertCurrency($row->currency_code,$admin_currency_code,$row->total);
                                                echo $admin_currency_symbol.' '.customised_currency_conversion($currencyPerUnitSeller,$row->total);
                                            }else
                                                echo $admin_currency_symbol.' '.$row->total;
                                    */
											//echo $admin_currency_code;
											?>
										</td>
										<td class="center">
											<?php
											if ($row->date_count == 1) {
												echo "Experience";
											} else if ($row->date_count > 1) {
												echo "Immersions";
											}
											?>
										</td>
										<td class="center">
											<?php echo $row->cat_title; ?>
										</td>
										<td class="center">
											<?php
											if ($row->firstname != '') {
												echo '<b>' . $row->firstname . '</b> (' . $row->lastname . ')';
											} else {
												echo 'Admin';
											}
											?>
										</td>
										<td class="center">
											<?php
											if ($allPrev == '1' || in_array('2', $Experience)) {
												$mode = ($row->status == '1') ? '0' : '1';
												if ($mode == '0') {
													?>
													<a title="Click to unpublish" class="tip_top"
													   href="javascript:confirm_status('admin/experience/change_experience_status/<?php echo $mode; ?>/<?php echo $row->experience_id; ?>'); "
													   onclick="email_unpublish('<?php echo $row->email; ?>,<?php echo $row->firstname; ?>')"><span
															class="badge_style b_done"><?php echo 'Publish'; ?></span></a>
													<?php
												} else {
													?>
													<a title="Click to publish" class="tip_top"
													   href="javascript:confirm_status('admin/experience/change_experience_status/<?php echo $mode; ?>/<?php echo $row->experience_id; ?>')"
													   onclick="email_publish('<?php echo $row->email; ?>,<?php echo $row->firstname; ?>')"><span
															class="badge_style"><?php echo "UnPublish"; ?></span></a>
													<?php
												}
											} else {
												?>
												<span
													class="badge_style b_done"><?php if ($row->status == '1') echo 'Publish'; else echo 'UnPublish'; ?></span>
											<?php } ?>
										</td>
										<td class="center">
											<?php echo $row->added_date; ?>
										</td>
										<td class="center">
											<?php if ($allPrev == '1' || in_array('2', $Experience)) { ?>
												<span><a class="action-icons c-edit"
														 href="admin/experience/add_experience_form_new/<?php echo $row->experience_id; ?>"
														 title="Edit">Edit</a></span>
												<!--<span><a class="action-icons1 c1-edit1" href="javascript:confirm_delete('admin/product/delete_product/<?php echo $row->id; ?>')" title="Calender">Delete</a></span>-->
											<?php } ?>
											<span><a class="action-icons c-suspend"
													 href="admin/experience/view_experience/<?php echo $row->experience_id; ?>"
													 title="View">View</a></span>
											<span>
		                                <a class="iframe cboxElement action-icons c-search"
										   href="https://maps.google.com/?q=<?php echo $row->latitude; ?>,<?php echo $row->longitude; ?>&amp;ie=UTF8&amp;t=m&amp;z=14&amp;ll=<?php echo $row->latitude; ?>,<?php echo $row->longitude; ?>&amp;output=embed"
										   title="Map">Map</a>
		                                </span>
											<?php if ($allPrev == '1' || in_array('3', $Experience)) { ?>
												<span><a class="action-icons c-delete"
														 href="javascript:confirm_delete('admin/experience/delete_experience/<?php echo $row->experience_id; ?>')"
														 title="Delete">Delete</a></span>
											<?php } ?>
											<?php if ($allPrev == '1' || in_array('2', $Experience)) { ?>
												<?php if ($row->featured == '0') { ?>
													<span id="feature_<?php echo $row->experience_id; ?>"><a
															class="c-unfeatured"
															href="javascript:ChangeFeaturedExperience('1','<?php echo $row->experience_id; ?>')"
															title="Click To Featured">Un-Featured</a></span>
												<?php } else { ?>
													<span id="feature_<?php echo $row->experience_id; ?>"><a
															class="c-featured"
															href="javascript:ChangeFeaturedExperience('0','<?php echo $row->experience_id; ?>')"
															title="Click To Un-Featured">Featured</a></span>
												<?php } ?>
											<?php } ?>
										</td>
									</tr>
									<?php
								}
							}
						}
						
						?>
						</tbody>
						<tfoot>
						<tr>
							<th class="center">
								<input name="checkbox_id[]" type="checkbox" value="on" class="checkall">
							</th>
							<th>
								Experience Name
							</th>
							<th><span class="tip_top">Experience Id</span></th>
							<th class="tip_top" title="Click to sort">
								Currency Type (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Host)
							</th>
							<th class="tip_top" title="Click to sort">
								Price (Admin)
							</th>
							<th class="tip_top" title="Click to sort">
								Experience Type
							</th>
							<th class="tip_top" title="Click to sort">
								Category Name
							</th>
							<th>
								Added By
							</th>
							<th>
								Status
							</th>
							<th>
								Experience Created On
							</th>
							<th>
								Action
							</th>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<ul class="pagination">
			<?php
			echo $links;
			?>
		</ul>
		<input type="hidden" name="statusMode" id="statusMode"/>
		<input type="hidden" name="SubAdminEmail" id="SubAdminEmail"/>
		</form>
	</div>
	<span class="clear"></span>
</div>
</div>
<script type="text/javascript">
	function search_category() {

		var city = $('#search_city').val();
		var status = $('#search_status').val();
		var checkin = $('#search_checkin').val();
		var checkout = $('#search_checkout').val();
		var id = $('#search_renters').val();
		window.location.href = "<?php echo base_url();?>admin/product/display_product_list?status=" + status + "&city=" + city + "&checkin=" + checkin + "&checkout=" + checkout + "&id=" + id;
		$_GET['status'], $_GET['city'], $_GET['checkin'], $_GET['checkout'], $_GET['id']
	}
</script>
<script type="text/javascript">
	function email_publish(email, firstname) {
		$.ajax(
			{
				type: 'POST',
				url: "<?php echo base_url();?>admin/experience/publish_mail",
				data: {'email': email, 'firstname': firstname},
				success: function (data) {

				}
			});
	}

	function email_unpublish(email, firstname) {
		$.ajax(
			{
				type: 'POST',
				url: "<?php echo base_url();?>admin/experience/unpublish_mail",
				data: {'email': email, 'firstname': firstname},
				success: function (data) {

				}
			});
	}
</script>
<script type="text/javascript">
	function experience_name_filter(){
		 $('#display_form').attr('action', 'admin/experience/experienceList');
		  $('#display_form').attr('method', 'GET');
		 $("#display_form").submit();
	}
	function experience_name_filter_reset(){
		window.location.href = "<?php echo base_url(); ?>admin/experience/experienceList";

	}
	
	/*  featured status change of experience */
	function ChangeFeaturedExperience(e, t) {
		$("#feature_" + t).html('<a class="c-loader" href="javascript:void(0);" title="Loading" >Loading</a>');
		var a = (e == '1') ? 'Featured' : 'Unfeatured',
			i = "feature_" + t,
			s = window.location.pathname,
			o = s.substring(s.lastIndexOf("/") + 1);
		$.ajax({
			type: "POST",
			url: BaseURL + "admin/experience/ChangeFeaturedExperience",
			data: {
				id: i,
				cpage: o,
				imgId: t,
				FtrId: e
			},
			dataType: "json",
			success: function (e) {

				$("#feature_" + t).remove()
			}
		}), "Featured" == a ? $("#feature_" + t).html('<a class="c-featured" href="javascript:ChangeFeaturedExperience(0,' + t + ')" title="Click To Un-Featured" >Featured</a>').show() : $("#feature_" + t).html('<a class="c-unfeatured" href="javascript:ChangeFeaturedExperience(1,' + t + ')" title="Click To Featured" >Un-Featured</a>').show()
	}
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>




