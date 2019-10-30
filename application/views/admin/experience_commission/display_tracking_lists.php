<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">-->
<link href="css/datepicker.css" rel="stylesheet">
<style>
input.p_approve.tipLeft.btn_small.btn_blue {
    padding-left: 15px !important;
}
</style>
	<script type="text/javascript">
		function checkHostPaypalEmail(id)
		 {
			paypalEmail = $("#hostPayPalEmail" + id).val();
			if (paypalEmail != 'no')
			{
				return true;
			}
			else
			 {
				alert('No Host Paypal Email.');
				return false;
			}
		}
	</script>

	<div id="content">
		<div class="grid_container">
			<?php
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
						<div style="float: right;line-height:40px;padding:0px 10px;height:39px;">
						</div>
					</div>
					<div class="widget_content">
						<form action="admin/experience_commission/display_commission_tracking_lists" method="POST">
							
							 <div class="form_grid_12 cmsn-tr-dteinput">
                                <?php
                                echo form_label('From Date <span class="req">*</span>', 'datefrom', $commonclass);
                                ?>
                                <div class="form_input">
                                   <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'datefrom',
                                        'autocomplete' => 'off',
                                         'id' => 'datepicker1',
                                         'placeholder' => 'DD/MM/YYY',
                                         'value' => $from_date_res == '' ? '' :date('d/m/Y',strtotime($from_date_res))
                                       
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="startDP2"></div>
                                </div>
                            </div>
                                <div class="form_grid_12 cmsn-tr-dteinput">
                                <?php
                                echo form_label('To Date <span class="req">*</span>', 'dateto', $commonclass);
                                ?>
                                <div class="form_input">
                                    
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'dateto',
                                        'autocomplete' => 'off',
                                         'id' => 'datepicker2',
                                         'placeholder' => 'DD/MM/YYY',
                                         'value' => $to_date_res == '' ? '' :date('d/m/Y',strtotime($to_date_res))
                                    ));
                                    ?>
                                    <div class="vf-datepicker" id="endDP2"></div>
                                    <div style="color:#DE5130;font-weight:600" id="tilldate_error"></div>
                                </div>
                            	</div>

                            	<div class="">
                            		<div class="cmmsn-trkng-btns">
                            			<input type="submit" class="btn" name="">
                            		</div>
                            		<div class="cmmsn-trkng-btns">
                            			<button style="margin-top: 33px;" type="button" class="btn" name="" onclick="resetfun();">Reset</button>
                            		</div>
                            	</div>

                            </div>
							
							
						</form>
						<table class="display display_tbl cmsn-trkng-tble" id="commission_tbl_exp">
							<thead>
							<tr>
								<th class="tip_top" title="Click to sort">SNo.</th>
								<th class="tip_top" title="Click to sort">Host Email Id</th>
								<th class="tip_top" title="Click to sort">Total orders</th>	
								<th class="tip_top" title="Click to sort">Total Amount</th>
								<th class="tip_top" title="Click to sort">Guest Service Amnt</th>
								<th class="tip_top" title="Click to sort">Cancellation Amount</th>
								<th class="tip_top" title="Click to sort">Actual Profit</th>
								<th class="tip_top" title="Click to sort">Amount to Host</th>
								<th class="tip_top" title="Click to sort">Paid</th>
								<th class="tip_top" title="Click to sort">Balance</th>
								<th>Experiences</th>
								<th>Options</th>
							</tr>
							</thead>
							<tbody>
							
							</tbody>
							<tfoot>
							<tr>
								<th class="tip_top" title="Click to sort">SNo.</th>
								<th class="tip_top" title="Click to sort">Host Email Id</th>
								<th class="tip_top" title="Click to sort">Total orders</th>
								<th class="tip_top" title="Click to sort">Total Amount</th>
								
								<th class="tip_top" title="Click to sort">Guest Service Amnt</th>
								<th class="tip_top" title="Click to sort">Cancellation Amount</th>
							
								<th class="tip_top" title="Click to sort">Actual Profit</th>
								<th class="tip_top" title="Click to sort">Amount to Host</th>
								<th class="tip_top" title="Click to sort">Paid</th>
								<th class="tip_top" title="Click to sort">Balance</th>
								<th>Experiences</th>
								<th>Options</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<input type="hidden" name="statusMode" id="statusMode"/>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script src="js/datepicker.js"></script>
<script>
	$('#datepicker1').datepicker({

				changeMonth: true,
				dateFormat: 'dd-mm-yy',

				numberOfMonths: 1,
				/*minDate: new Date($('#datetimepicker1').val()),
				maxDate: new Date($('#to_date').val()),*/
				//beforeShowDay: unavailable,

			});

$('#datepicker2').datepicker({

				changeMonth: true,
				dateFormat: 'dd-mm-yy',
				numberOfMonths: 1,
				minDate: new Date($('#datepicker1').val()),
				//maxDate: new Date($('#to_date').val()),
				

});
function resetfun(){
	window.location.href = "<?php echo base_url(); ?>admin/experience_commission/display_commission_tracking_lists";
}
</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var datefrom = '<?php echo $datefrom; ?>';
				var dateto = '<?php echo $dateto; ?>';
				
				var dataTable = $('#commission_tbl_exp').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						data: {dateto: dateto, datefrom: datefrom},
						url :"<?php echo base_url(); ?>admin/experience_commission/display_commission_tracking_lists_datatables", // json datasource
						type: "post",  // method  , by default get
						error: function(){  // error handling
							// $(".employee-grid-error").html("");
							// $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
							// $("#employee-grid_processing").css("display","none");
							
						}
					}
				} );
			} );
		</script>