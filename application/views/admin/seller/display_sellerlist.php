<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/seller/change_seller_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
							<?php
							if ($allPrev == '1' || in_array('3', $Host)) 
							{
								?>
								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Active','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to active records"><span
											class="icon accept_co"></span><span class="btn_link">Active</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Inactive','<?php echo $subAdminMail; ?>');"
									   class="tipTop"
									   title="Select any checkbox and click here to inactive records"><span
											class="icon delete_co"></span><span class="btn_link">Inactive</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="javascript:void(0)"
									   onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
									   class="tipTop" title="Select any checkbox and click here to delete records"><span
											class="icon cross_co"></span><span class="btn_link">Delete</span>
									</a>
								</div>

								<div class="btn_30_light" style="height: 29px;">
									<a href="admin/seller/customerExcelExport" class="tipTop"
									   title="Click Export All Host Details"><span class="icon cross_co"></span><span
											class="btn_link">Export All User</span>
									</a>
								</div>
							<?php 
							} ?>
						</div>

					</div>
					<div class="widget_content">
						<table class="display" id="renter_tbl">
							<thead>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
											'id'=>'mass_select_all',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								</th>
								<th class="tip_top" title="Click to sort">First Name</th>
								<th class="tip_top" title="Click to sort Last name">Last Name</th>
								<th class="tip_top" title="Click to sort">Email-ID</th>
								<th class="tip_top" title="Click to sort">Verify</th>
								<th class="tip_top" title="Click to sort">Login User Type</th>
								<th class="tip_top" title="Click to sort"> Host Created Date</th>
								<th class="tip_top" title="Click to sort"> Last Login Date</th>
								<th class="tip_top" title="Click to sort"> Last Login IP</th>
								<th class="tip_top" title="Click to sort"> ID Proof Status</th>
								<th class="tip_top" title="Click to sort">Status</th>
								<th width="12%"> Action</th>
							</tr>
							</thead>
							<tbody>
							
							</tbody>
							<tfoot>
							<tr>
								<th class="center">
									<?php
										echo form_input([
											'type'     => 'checkbox',
									        'value'    => 'on',
									        'name' 	   => 'checkbox_id[]',
									        'class'    => 'checkall'
									        ]);	
									?>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Email-ID</th>
								<th>Verify</th>
								
								<th>Login User Type</th>
								<th>Host Created Date</th>
								<th>Last Login Date</th>
								<th>Last Login IP</th>
								<th>ID Proof Status</th>
								<th>Status</th>								
								<th>Action</th>
							</tr>
							</tfoot>
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

				echo form_input([
					'type'     => 'hidden',
					'id'       => 'SubAdminEmail',
					'name' 	   => 'SubAdminEmail'
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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var dataTable = $('#renter_tbl').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url(); ?>admin/Seller/display_seller_list_datatables", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							// $(".employee-grid-error").html("");
							// $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							// $("#employee-grid_processing").css("display","none");
							
						}
					},
					'columnDefs': [
         {
            'targets': [0],
            'orderable': false,
         }
      ]
				} );
			} );

			$('body').on('change', '#mass_select_all', function() {
   var rows, checked;
   rows = $('#renter_tbl').find('tbody tr');
   checked = $(this).prop('checked');
   $.each(rows, function() {
      var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
   });
 });
		</script>