<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
 -->
 <link href="<?php echo base_url();?>css/localize/bootstrap3.2.min.css" rel="stylesheet">
<!-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
 -->
 <link href="<?php echo base_url();?>css/localize/font-awesome-4.2.css" rel="stylesheet">

<link href="<?php echo base_url();?>css/datepicker.css" rel="stylesheet">

 <!-- <script language="JavaScript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script> -->
 <script language="JavaScript"  src="<?php echo base_url();?>css/localize/jquery-1.10.js"></script>

<!-- <link href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" rel="Stylesheet"></link> -->


<link href="<?php echo base_url();?>css/localize/smoothnes-jquery.css" rel="Stylesheet"></link>


<!-- <script src='https://cdn.rawgit.com/pguso/jquery-plugin-circliful/master/js/jquery.circliful.min.js'></script> -->

<script src='<?php echo base_url();?>css/localize/jquery.circliful.js'></script>

<style>
.form_grid_12.col-sm-12 {
    margin-bottom: 10px;
}
.font_wrd{
	font-size: 14px;
}
div#suggesstion-box {
    overflow: auto;
    height: auto;
    width: 199px;
    left: 30%;
    top: 10px;
}
    .table_bottom{
        display: none;
    }
       .dataTables_filter {
  
    margin: 6px 0;
}
.blu {
    font-size: 13px;
    padding: 5px;
    color: #fff;
    border: #1e282c 1px solid;
    border-radius: 3px;
    margin-right: 5px;
    background: #1e282c;
}
#search_name
{
    padding: 6px 0 !important;
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
		<!-- <?php
		$attributes = array('id' => 'display_form','autocomplete'=>'off');
		echo form_open('admin/product/change_product_status_global', $attributes)
		?> -->
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<?php if($_GET['datefrom'] == ''){$datefrom = 'no';}else{$datefrom = $_GET['datefrom'];}
if($_GET['dateto'] == ''){$dateto = 'no';}else{$dateto = $_GET['dateto'];}
if($_GET['status_order'] == ''){$status_order = 'no';}else{$status_order = $_GET['status_order'];}
if($_GET['search_name'] == ''){$search_name = 'no';}else{$search_name = $_GET['search_name'];}

					 ?>
						 <?php if($this->uri->segment(3) != 'display_report_list') { ?>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						
						<div class="btn_30_light" style="height: 29px;">
							<a href="admin/reports/ExcelExport/<?php echo $this->uri->segment(3).'/'.$datefrom.'/'.$dateto.'/'.$status_order.'/'.$search_name.'/'; ?>" class="tipTop"
							   title="Click export all property list"><span class="icon cross_co"></span><span
									class="btn_link">Export All</span></a>
						</div>
					</div>
					<?php } ?>
				</div>
				

				<div class="name_filter">
					<div class="dataTables_filter row" style="width:100%" id="experience_name_filter">
						<div>
							<?php
		$attributes = array('id' => 'display_form','class'=>'form_container left_label','autocomplete'=>'off');
		echo form_open('admin/product/change_product_status_global', $attributes)
		?>
                           <ul class="dsply-rprt-li">
                           	<li>
                           	  <div class="form_grid_12">
                           	  	<label class="field_title"></label>
						<select name="search_type" class="font_wrd" id="type_id" style="float: left;">
						<option value="">--Select Type--</option>	
						<option value="1" <?php if($search_type_fetch==1){echo "selected";} ?>>Homes</option>
						<option value="2" <?php if($search_type_fetch==2){echo "selected";} ?>>Experience</option>
						<option value="3" <?php if($search_type_fetch==3){echo "selected";} ?>>Guest</option>
						<option value="4" <?php if($search_type_fetch==4){echo "selected";} ?>>Host</option>
						</select>
					</div>
                           	</li>
                           	<li>
                           		<div class="form_grid_12">
                           	    <?php
                           	    $commonclass = array('class' => 'field_title');
                                echo form_label('From Date <span class="req">*</span>', 'datefrom', $commonclass);
                                ?>
                                <div class="form_input">
                                    <span class="form-control frm_wdth" id="fromDisplay2" name="from"></span>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'hidden',
                                        'name' => 'datefrom',
                                        'id' => 'fromInput2',
                                       
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="startDP2"></div>
                                </div>
                            </div>
                           	</li>
                           	<li>
                           		<div class="form_grid_12">
                                <?php
                                $commonclass = array('class' => 'field_title');
                                echo form_label('To Date <span class="req">*</span>', 'dateto', $commonclass);
                                ?>
                                <div class="form_input">
                                    <span class="form-control frm_wdth" id="toDisplay2"></span>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'hidden',
                                        'name' => 'dateto',
                                        'id' => 'toInput2',
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="endDP2"></div>
                                    <div style="color:#DE5130;font-weight:600" id="tilldate_error"></div>
                                </div>
                            	</div>
                           	</li>
                           	<li>
                           		<div class="form_grid_12">
                           			<label class="field_title"></label>
                            		<select name="status_order" class="font_wrd" id="type_id" style="float: left;">
						<option value="">--Select Status--</option>	
						<option value="Publish" <?php if($_GET['status_order']=='Publish'){echo "selected";} ?>>Active</option>
						<option value="UnPublish" <?php if($_GET['status_order']=='UnPublish'){echo "selected";} ?>>InActive</option>			
						</select>
                            	</div>
                           	</li>
                           	<li>
                           		<div class="form_grid_12">
                           			<label class="field_title"></label>
                            		<?php echo form_input([

										'type'     => 'text',
										'id'       => 'search_name',

										'value'    => '',

										'placeholder' => 'Search By Name',

										'name' 	   => 'search_name',

										'class'    => 'checkall required large tipTop',

										'style'    => 'width:50%!important'

									]);	 ?>
									  <img style="display: none;" class="ajax-loader" src="<?php echo base_url()?>images/ajax-loader.gif"/>
<div id="suggesstion-box" style="position: relative;"></div>

                            </div>
                            	
                           	</li>
                           	<li>
                           		 <div class="form_grid_12">	
                           		 <label class="field_title"></label>	
						<input type="button" onclick="fetch_type_based_data();" class="btn_small btn_blue blue" value="Search" name="experience_name_filter_val">
						<input type="button" onclick="report_name_filter_reset();" class="btn_small btn_blue " value="Reset" name="experience_name_filter_val">	
					</div>
                           	</li>
                           </ul>
						<!-- <div class="form_grid_12 col-sm-12">
						<select name="search_type" class="font_wrd" id="type_id" style="float: left;">
						<option value="">--Select Type--</option>	
						<option value="1" <?php if($search_type_fetch==1){echo "selected";} ?>>Homes</option>
						<option value="2" <?php if($search_type_fetch==2){echo "selected";} ?>>Experience</option>
						<option value="3" <?php if($search_type_fetch==3){echo "selected";} ?>>Guest</option>
						<option value="4" <?php if($search_type_fetch==4){echo "selected";} ?>>Host</option>
						</select>
					</div> -->
						<!-- <div class="form_grid_12 col-sm-12">
                                <?php
                                echo form_label('From Date <span class="req">*</span>', 'datefrom', $commonclass);
                                ?>
                                <div class="form_input">
                                    <span class="form-control frm_wdth" id="fromDisplay2" name="from"></span>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'hidden',
                                        'name' => 'datefrom',
                                        'id' => 'fromInput2',
                                       
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="startDP2"></div>
                                </div>
                            </div> -->
                              <!-- <div class="form_grid_12 col-sm-12">
                                <?php
                                echo form_label('To Date <span class="req">*</span>', 'dateto', $commonclass);
                                ?>
                                <div class="form_input">
                                    <span class="form-control frm_wdth" id="toDisplay2"></span>
                                    <?php
                                    echo form_input(array(
                                        'type' => 'hidden',
                                        'name' => 'dateto',
                                        'id' => 'toInput2',
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="endDP2"></div>
                                    <div style="color:#DE5130;font-weight:600" id="tilldate_error"></div>
                                </div>
                            	</div> -->
                            	<!-- <div class="form_grid_12 col-sm-12">
                            		<select name="status_order" class="font_wrd" id="type_id" style="float: left;">
						<option value="">--Select Status--</option>	
						<option value="Publish" <?php if($_GET['status_order']=='Publish'){echo "selected";} ?>>Active</option>
						<option value="UnPublish" <?php if($_GET['search_type_fetch']=='UnPublish'){echo "selected";} ?>>InActive</option>			
						</select>
                            	</div> -->
                            	<!-- <div class="form_grid_12 col-sm-12">
                            		<?php echo form_input([

										'type'     => 'text',
										'id'       => 'search_name',

										'value'    => '',

										'placeholder' => 'Search By Name',

										'name' 	   => 'search_name',

										'class'    => 'checkall'

									]);	 ?>
									  <img style="display: none;" class="ajax-loader" src="<?php echo base_url()?>images/ajax-loader.gif"/>
<div id="suggesstion-box"></div>

                            </div>
                            	</div> -->
                           <!--  <div class="form_grid_12 col-sm-12">		
						<input type="button" onclick="fetch_type_based_data();" class="btn_small btn_blue blu" value="Search" name="experience_name_filter_val">
						<input type="button" onclick="report_name_filter_reset();" class="btn_small btn_blue " value="Reset" name="experience_name_filter_val">	
					</div> -->
						</label>
					</div>
					
				</div>
				
				<?php if ($productList->num_rows() > 0 ) { ?>
				<div class="widget_content">
					<table class="display display_tbl">
						<thead>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">Rental Id</th> -->
							<th class="tip_top" title="Click to sort">Rental Name</th>
							<th class="tip_top" title="Click to sort">Total Bookings</th>
							<th class="tip_top" title="Click to sort">Paid Bookings</th>
							<th class="tip_top" title="Click to sort">Pending Bookings</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
						</tr>
						</thead>
						<tbody>
						<?php
						if ($productList->num_rows() > 0) {
							foreach ($productList->result() as $row) {
								
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
								?>
								<tr>
									
									<!-- <td class="center">
										<?php echo $row->id; ?>
									</td> -->
									<td class="center">
										<?php echo $row->product_title != '' ? ucfirst($row->product_title) : 'Listing not completed';
										?>
									</td>
									<td>
										<?php echo $row->total_order; ?>
									</td>
									<td class="center">
										<?php echo $row->booked_pro_count; ?>
									</td>
									
									<td class="center">
										<?php echo $row->pending_pro_count; ?>
									</td>
	<td class="center">
										<?php echo $row->cacelled_pro_count; ?>
									</td>
									
									
								</tr>
								<?php
							}
						}
						?>
						</tbody>
						<tfoot>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">Rental Id</th> -->
							<th class="tip_top" title="Click to sort">Rental Name</th>
							<th class="tip_top" title="Click to sort">Total Bookings</th>
							<th class="tip_top" title="Click to sort">Paid Bookings</th>
							<th class="tip_top" title="Click to sort">Pending Bookings</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
						</tr>
						</tfoot>
					</table>
				</div>
				<?php }
				elseif($experienceList->num_rows() > 0) { ?>
					<div class="widget_content table-res">
					<table class="display display_tbl">
						<thead>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">
								Experience Id
							</th> -->
							<th class="tip_top" title="Click to sort">
								Experience Name
							</th>
							
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
							
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
								
									?>
									<tr>
										<!-- <td class="center">
											<?php echo $row->experience_id; ?>
										</td> -->
										<td class="center">
											<?php echo $row->experience_title != '' ? ucfirst($row->experience_title) : 'Listing not completed';
											?>
										</td>
										<td class="center">
											<?php echo $row->total_order; ?>
										</td>
										<td class="center">
											<?php echo $row->booked_pro_count; ?>
										</td>
										<td class="center">
											<?php echo $row->pending_pro_count; ?>
										</td>
										<td class="center">
										<?php echo $row->cacelled_pro_count; ?>
									</td>
										
									</tr>
									<?php
								
							}
						}
						
						?>
						</tbody>
						<tfoot>
						<tr>
							<!-- <th><span class="tip_top">Experience Id</span></th> -->
							<th>
								Experience Name
							</th>
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
							
						</tr>
						</tfoot>
					</table>
				</div>
				<?php  ?>

				<?php }
				elseif($usersList->num_rows() > 0) { ?>
					<div class="widget_content table-res">
					<table class="display display_tbl">
						<thead>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">
								Guest Id
							</th> -->
							<th class="tip_top" title="Click to sort">
								Guest Name
							</th>
							
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
							
						</tr>
						</thead>
						<tbody>
						<?php

						if ($usersList->num_rows() > 0) {
						//	print_r($usersList->result());exit;
							foreach ($usersList->result() as $row) {
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
							$exp_reportList =  $this->report_model->get_exp_det($row->email);
								
									?>
									<tr>
										<!-- <td class="center">
											<?php echo $row->user_id; ?>
										</td> -->
										<td class="center">
											<?php  echo $row->firstname != '' ||  $row->firstname != ''? $row->firstname.' '.$row->lastname: 'No Name'; ?>
										</td>
										
										<td class="center">
											<?php echo $row->total_order +  $exp_reportList->exp_total_order; ?>
										</td>
										<td class="center">
											<?php echo $row->booked_pro_count + $exp_reportList->booked_exp_count; ?>
										</td>
										<td class="center">
											<?php echo $row->pending_pro_count + $exp_reportList->pending_exp_count; ?>
										</td>
										<td class="center">
										<?php echo $row->cacelled_pro_count+$exp_reportList->cacelled_exp_count; ?>
									</td>

										
									</tr>
									<?php
								
							}
						}
						
						?>
						</tbody>
						<tfoot>
						<tr>
							<!-- <th><span class="tip_top">Guest Id</span></th> -->
							<th>
								Guest Name
							</th>
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
						</tr>
						</tfoot>
					</table>
				</div>
				<?php  ?>

				<?php }
				elseif($hostList->num_rows() > 0) { ?>
					<div class="widget_content table-res">
					<table class="display display_tbl">
						<thead>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">
								Host Id
							</th> -->
							<th class="tip_top" title="Click to sort">
								Host Name
							</th>
							
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
							
						</tr>
						</thead>
						<tbody>
						<?php

						if ($hostList->num_rows() > 0) {
					//print_r($experienceList->result());exit;
							foreach ($hostList->result() as $row) {
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
							$exp_reportList =  $this->report_model->get_exp_det($row->email);
									?>
									<tr>
										<!-- <td class="center">
											<?php echo $row->renter_id; ?>
										</td> -->
										<td class="center">
											<?php echo $row->firstname != '' ||  $row->firstname != '' ? $row->firstname.' '.$row->lastname : 'No Name'; ?>
										</td>
										
										<td class="center">
											<?php echo $row->total_order + $exp_reportList->exp_total_order; ?>
										</td>
										<td class="center">
											<?php echo $row->booked_pro_count+ $exp_reportList->booked_exp_count; ?>
										</td>
										<td class="center">
											<?php  echo $row->pending_pro_count + $exp_reportList->pending_exp_count; ?>
										</td>
											<td class="center">
										<?php echo $row->cacelled_pro_count+ $exp_reportList->cacelled_exp_count; ?>
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
								Host Name
							</th>
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">Canceled Bookings</th>
							
						</tr>
						</tfoot>
					</table>
				</div>
				<?php } else{?>
				<div class="widget_content table-res">
					<table class="display display_tbl">
						<thead>
						<tr>
							
							<!-- <th class="tip_top" title="Click to sort">
								Host Id
							</th> -->
							<th class="tip_top" title="Click to sort">
								Host Name
							</th>
							
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Canceled Bookings
							</th>
							
						</tr>
						</thead>
						<tbody>
						<tr class="center">
										<td>
											<?php echo "Sorry No Data Available"; ?>
										</td>
										
										
									</tr>
						</tbody>
						<tfoot>
						<tr><!-- 
							<th><span class="tip_top">Host Id</span></th> -->
							<th>
								Host Name
							</th>
							<th class="tip_top" title="Click to sort">
								Total Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Paid Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Pending Bookings
							</th>
							<th class="tip_top" title="Click to sort">
								Canceled Bookings
							</th>
							
						</tr>
						</tfoot>
					</table>
				</div>

				<?php } ?>

			</div>
		</div>
		<ul class="pagination">
		<?php
		echo $links;
		?>
		</ul>
		<?php
		// echo form_input(array(
		// 	'type' => 'hidden',
		// 	'id' => 'statusMode',
		// 	'name' => 'statusMode'
		// ));
		// echo form_input(array(
		// 	'type' => 'hidden',
		// 	'id' => 'SubAdminEmail',
		// 	'name' => 'SubAdminEmail'
		// ));
		echo form_close();
		?>
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
	function email_publish(email, firstname, product_title) {
		var email = email;
		var firstname = firstname;
		var product_title = product_title;

		$.ajax(
			{
				type: 'POST',
				url: "<?php echo base_url();?>admin/product/publish_mail",
				data: {'email': email, 'firstname': firstname, 'product_title': product_title},
				success: function (data) {

				}
			});
	}

	function email_unpublish(email, firstname, product_title) {
		var email = email;
		var firstname = firstname;
		var product_title = product_title;

		$.ajax(
			{
				type: 'POST',
				url: "<?php echo base_url();?>admin/product/unpublish_mail",
				data: {'email': email, 'firstname': firstname, 'product_title': product_title},
				success: function (data) {

				}
			});
	}
	function report_name_filter(){

		 $('#display_form').attr('action', 'admin/reports/display_report_list');
		  $('#display_form').attr('method', 'GET');
		 $("#display_form").submit();
	}
	function report_name_filter_reset(){
		window.location.href = "<?php echo base_url(); ?>admin/reports/display_report_list";
	}

	function fetch_type_based_data()
	{
		 var type_id =  $('#type_id').val();
		 if(type_id == '')
		 {
		 	alert('please Select Type');
		 	return false;
		 }
		 else if(type_id == 1)
		 {
		 	$('#display_form').attr('action', 'admin/reports/ajax_fetch_type_based_rental_data');
		 	$('#display_form').attr('method', 'GET');
		 }
		 else if(type_id == 2)
		 {
		 	$('#display_form').attr('action', 'admin/reports/ajax_fetch_type_based_experience_data');
		 	$('#display_form').attr('method', 'GET');
		 }
		 else if(type_id == 3)
		 {
		 	$('#display_form').attr('action', 'admin/reports/ajax_fetch_type_based_guest_data');
		 	$('#display_form').attr('method', 'GET');
		 }
		 else if(type_id == 4)
		 {
		 	$('#display_form').attr('action', 'admin/reports/ajax_fetch_type_based_host_data');
		 	$('#display_form').attr('method', 'GET');
		 }
		 $("#display_form").submit();

			// $.ajax(
			// {
			// 	type: 'POST',
			// 	url: "<?php //echo base_url();?>admin/reports/ajax_fetch_type_based_data",
			// 	data: {'type_id': type_id},
			// 	success: function (data) {
			// 		$('#response').html(data);
			// 	}
			// });
	}
</script>
<script src="js/datepicker.js"></script>
<script>
    var _unavailable = [];
    var _onrequest = [];
    _unavailable.push('2014-10-23');
    _unavailable.push('2014-10-24');
    _unavailable.push('2014-10-25');
    _unavailable.push('2014-10-26');
    _unavailable.push('2014-10-27');
    _unavailable.push('2014-10-28');
    _unavailable.push('2014-10-29');
    _unavailable.push('2014-10-30');
    _unavailable.push('2014-10-31');
    _unavailable.push('2015-03-03');
    _unavailable.push('2015-03-04');
    _unavailable.push('2015-03-05');
    _unavailable.push('2015-03-06');
    _unavailable.push('2014-09-04');
    _unavailable.push('2014-09-05');
    _unavailable.push('2014-09-06');
    _unavailable.push('2014-09-07');
    _unavailable.push('2014-09-08');
    _unavailable.push('2014-09-09');
    _unavailable.push('2014-09-10');
    _unavailable.push('2014-09-11');
    _unavailable.push('2014-09-12');
    _unavailable.push('2014-09-13');
    _unavailable.push('2014-09-16');
    _unavailable.push('2014-09-17');
    _unavailable.push('2014-09-18');
    _unavailable.push('2014-09-19');
    _unavailable.push('2014-09-20');
    _unavailable.push('2014-09-21');
    _unavailable.push('2014-08-22');
    _unavailable.push('2014-08-23');
    _unavailable.push('2014-08-24');
    _unavailable.push('2014-07-01');
    _unavailable.push('2014-07-02');
    _unavailable.push('2014-07-03');
    _unavailable.push('2014-07-04');
    _unavailable.push('2014-07-05');
    _unavailable.push('2014-07-06');
    _unavailable.push('2014-07-07');
    _unavailable.push('2014-07-08');
    _unavailable.push('2014-07-09');
    _unavailable.push('2014-07-10');
    _unavailable.push('2014-07-11');
    _unavailable.push('2014-07-12');
    _unavailable.push('2014-07-13');
    _unavailable.push('2014-07-14');
    _unavailable.push('2014-07-15');
    _unavailable.push('2014-07-16');
    _unavailable.push('2014-07-17');
    _unavailable.push('2014-07-18');
    _unavailable.push('2014-07-19');
    _unavailable.push('2014-07-20');
    _unavailable.push('2014-07-21');
    _unavailable.push('2014-07-22');
    _unavailable.push('2014-07-23');
    _unavailable.push('2014-07-24');
    _unavailable.push('2014-07-25');
    _unavailable.push('2014-07-26');
    _unavailable.push('2014-07-27');
    _unavailable.push('2014-07-28');
    _unavailable.push('2014-07-29');
    _unavailable.push('2014-07-30');
    _unavailable.push('2014-07-31');
    _unavailable.push('2014-08-01');
    _unavailable.push('2014-08-02');
    _unavailable.push('2014-08-03');
    _unavailable.push('2014-08-04');
    _unavailable.push('2014-08-05');
    _unavailable.push('2014-08-06');
    _unavailable.push('2014-08-07');
    _unavailable.push('2014-08-08');
    _unavailable.push('2014-08-09');
    _unavailable.push('2014-08-10');
    _unavailable.push('2014-08-11');
    _unavailable.push('2014-08-12');
    _unavailable.push('2014-08-13');
    _unavailable.push('2014-08-14');
    _unavailable.push('2014-08-15');
    _unavailable.push('2014-08-16');
    _unavailable.push('2014-08-17');
    _unavailable.push('2014-08-18');
    _unavailable.push('2014-08-19');
    _unavailable.push('2014-08-20');
    _unavailable.push('2014-08-21');
    _unavailable.push('2014-12-30');
    _unavailable.push('2014-12-31');
    _unavailable.push('2015-01-01');
    _unavailable.push('2015-01-02');
    _unavailable.push('2015-01-03');
    _unavailable.push('2015-01-25');
    _unavailable.push('2015-01-26');
    _unavailable.push('2015-01-27');
    _unavailable.push('2015-01-28');
    _unavailable.push('2015-01-29');
    _unavailable.push('2015-01-30');
    _unavailable.push('2015-01-31');
    _unavailable.push('2015-02-01');
    _unavailable.push('2015-02-02');
    _unavailable.push('2015-02-03');
    _unavailable.push('2014-08-25');
    _unavailable.push('2014-08-26');
    _unavailable.push('2014-08-27');
    now = new Date();
    ny = now.getFullYear();
    nm = now.getMonth() + 1;
    nD = now.getDate();
    var dp2 = new VF_datepicker();
    dp2.datepicker({
        minDate: 0,
        'name': 'form2',
        'start': '',
        'end': null,
        'monthNames': ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        'dayNames': ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
        'startCtrl': $('#fromDisplay2'),
        'endCtrl': $('#toDisplay2'),
        'startDisplay': $('#fromDisplay2'),
        'endDisplay': $('#toDisplay2'),
        'startInput': $('#fromInput2'),
        'endInput': $('#toInput2'),
        'startDP': $('#startDP2'),
        'endDP': $('#endDP2'),
        'clearTxt': 'Clear dates',
        'unavailable': _unavailable,
        'onrequest': _onrequest,
        'displayFrom': function (from, to) {
        },
        'displayTo': function (from, to) {
        },
        'fromChosen': function (from, to) {
        },
        'toChosen': function (from, to) {
        },
        'hideFrom': function (from, to) {
        },
        'hideTo': function (from, to) {
        },
    });
</script>

   <script type="text/javascript">
   	$(document).ready(function(){
var search_type_fetch = '<?php echo $search_type_fetch; ?>';

        $("#search_name").keyup(function(){
        	//alert(search_type_fetch);
        	if(search_type_fetch == 1)
           { $.ajax({
           		type: "POST",
           		url: "<?php echo base_url()?>ajax_autocomplete_name",
           		data: {term: $(this).val()},
           		beforeSend: function(){
           			$('.ajax-loader').show();
           		},
           		success: function(data){
           			$('.ajax-loader').hide();
           			$("#suggesstion-box").show();
           			$("#suggesstion-box").html(data);
           			$("#search-box").css("background","#FFF");
           		}
           		});}
      else if(search_type_fetch == 2)
           { $.ajax({
           		type: "POST",
           		url: "<?php echo base_url()?>ajax_autocomplete_name_exp",
           		data: {term: $(this).val()},
           		beforeSend: function(){
           			$('.ajax-loader').show();
           		},
           		success: function(data){
           			$('.ajax-loader').hide();
           			$("#suggesstion-box").show();
           			$("#suggesstion-box").html(data);
           			$("#search-box").css("background","#FFF");
           		}
           		});}
       else if(search_type_fetch == 3)
           { $.ajax({
           		type: "POST",
           		url: "<?php echo base_url()?>ajax_autocomplete_name_guest",
           		data: {term: $(this).val()},
           		beforeSend: function(){
           			$('.ajax-loader').show();
           		},
           		success: function(data){
           			$('.ajax-loader').hide();
           			$("#suggesstion-box").show();
           			$("#suggesstion-box").html(data);
           			$("#search-box").css("background","#FFF");
           		}
           		});}
       else if(search_type_fetch == 4)
           { $.ajax({
           		type: "POST",
           		url: "<?php echo base_url()?>ajax_autocomplete_name_host",
           		data: {term: $(this).val()},
           		beforeSend: function(){
           			$('.ajax-loader').show();
           		},
           		success: function(data){
           			$('.ajax-loader').hide();
           			$("#suggesstion-box").show();
           			$("#suggesstion-box").html(data);
           			$("#search-box").css("background","#FFF");
           		}
           		});}


        });
    });
   


</script>
<script type="text/javascript">
	 function selectCountry(val_is = '') {
    	//alert(val_is);
$("#search_name").val(val_is);
$("#suggesstion-box").hide();
}


</script>
<?php
$this->load->view('admin/templates/footer.php');
?>




