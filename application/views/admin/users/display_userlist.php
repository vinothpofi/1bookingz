<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
		
<style>
	.halaman 
	{
		margin: 30px;
		font-size: 11px;
	}

	.halaman a 
	{

		padding: 3px;
		background: #990000;
		-moz-border-radius: 20px;
		-webkit-border-radius: 10x;
		border: 1px solid #gray;
		font-size: 15px;
		font-weight: bold;
		color: #FFF;
		text-decoration: none;
	}
</style>


<div id="content">
	<div class="grid_container">
		<?php
		$attributes = array('id' => 'display_form');
		echo form_open('admin/users/change_user_status_global', $attributes)
		?>
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon blocks_images"></span>
					<h6><?php echo $heading ?></h6>
					<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						<?php if ($allPrev == '1' || in_array('2', $Members)) 
						{ ?>
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
							<?php
						}

						if ($allPrev == '1' || in_array('3', $Members)) 
						{
							?>
							<div class="btn_30_light" style="height: 29px;">
								<a href="javascript:void(0)"
								   onclick="return checkBoxValidationAdmin('Delete','<?php echo $subAdminMail; ?>');"
								   class="tipTop" title="Select any checkbox and click here to delete records"><span
										class="icon cross_co"></span><span class="btn_link">Delete</span>
								</a>
							</div>
						<?php } ?>

						<div class="btn_30_light" style="height: 29px;">
							<a href="admin/users/export_user_details" class="tipTop"
							   title="Click Export All User Details"><span class="icon cross_co"></span><span
									class="btn_link">Export All User</span>
							</a>
						</div>
					</div>
				</div>

				<div class="widget_content table-responsive">
					<table class="display" id="userListTbl">
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
							<th class="tip_top" title="Click to sort">Last Name</th>
							<th class="tip_top" title="Click to sort">Email-ID</th>
							<!-- <th class="tip_top" title="Click to sort">image</th> -->
							<th class="tip_top" title="Click to sort">Verify</th>
							<th class="tip_top" title="Click to sort">Login User Type</th>
							<th class="tip_top" title="Click to sort">User Created On</th>
							<th class="tip_top" title="Click to sort">Last Login Date</th>
							<th class="tip_top" title="Click to sort">Last Login IP</th>
							<th class="tip_top" title="Click to sort">Status</th>
							<th width="12%">Action</th>
						</tr>
						</thead>
						
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
							</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email-ID</th>
							<!-- <th>image</th> -->
							<th>Verify</th>
							<th>Login User Type</th>
							<th>User Created On</th>
							<th>Last Login Date</th>
							<th>Last Login IP</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
		<center>
			<div style="clear:both;"></div>
			<div class="halaman">
				<ul class="pagination">
					<?php echo $links; ?>
				</ul>
			</div>
		</center>
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
				var dataTable = $('#userListTbl').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						url :"<?php echo base_url(); ?>admin/users/display_user_list_datatables", // json datasource
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
   rows = $('#userListTbl').find('tbody tr');
   checked = $(this).prop('checked');
   $.each(rows, function() {
      var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
   });
 });
		</script>