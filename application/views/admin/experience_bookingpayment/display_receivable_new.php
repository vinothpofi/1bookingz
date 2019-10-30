<?php 
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
	<div id="content">
		<div class="grid_container">
			<?php
			$attributes = array('id' => 'display_form');
			echo form_open('admin/order/change_order_status_global', $attributes)
			?>
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon blocks_images"></span>
						<h6><?php echo $heading ?></h6>
					</div>

                    <br>
                    <div class="name_filter">
					<div class="dataTables_filter" id="experience_name_filter"><label><strong>Select Date: </strong>
						<input placeholder="dd-MM-YYY" type="text" autocomplete="off" id="datepicker1" value="" name="fromdate">
						<input placeholder="dd-MM-YYY" type="text" autocomplete="off" id="datepicker2" value="" name="todate">
						<input type="button" onclick="experience_name_filters();" class="btn btn-block btn-success" value="Search" name="experience_name_filter_val">
						<input type="button" onclick="experience_name_filter_reset();" class="btn btn-block btn-success" value="Reset" name="experience_name_filter_val">
        </label></div>
				</div> 
                   <!--  <div>
                        <select name="transaction_id" id="tran_id" onChange="showRows_exp(this);" style="margin-left: 400px;">
                            <option>Select</option>
                            <?php foreach($commission_paid_transactionID->result() as $trns_id){ ?>
                            <option value="<?php echo $trns_id->id; ?>"><?php echo $trns_id->transaction_id; ?>
                                <?php  }  ?>
                        </select>
                    </div> -->
                    <br>


					<div class="widget_content">
						<table class="display display_tbl" id="exp_recievable_tbl">
							<thead>
							<tr>
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Date</th>
                                <th class="tip_top" title="Click to sort">Transaction ID</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th>Host Email Id</th>
								<th class="tip_top" title="Total amount with service fee and security fee in admin's currency">Total Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Service fee in admin's currency">Guest Service Fee&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th>Host Service Fee</th>
								<th class="tip_top" title="Sum of Guest service fee and Host servie fee in admin's currency">Net Profit&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Payable amount to host in admin's currency">Amount to Host&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
							</tr>
							</thead>
							<tbody>
							
							</tbody>
							<tfoot>
							<tr>
								<th>S No</th>
								<th>Date</th>
								<th>Transaction ID</th>
								<th>Booking No</th>
								<th>Host Email Id</th>
								<th>Total Amount</th>
								<th>Guest Service Fee</th>
								<th>Host Service Fee</th>
								<th>Net Profit</th>
								<th>Amount to Host</th>
							</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>

            <div id="selecteRow">
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
function experience_name_filters(){

	if($('#datepicker2').val()!='' && $('#datepicker1').val()!=''){
	     var id= '<?php echo $this->uri->segment(4);?>';
		 $('#display_form').attr('action', 'admin/experience_bookingpayment/display_receivable/'+id);
		  $('#display_form').attr('method', 'POST');
		 $("#display_form").submit();
		}
		else{
			alert("Please Select From and Todates");
		}
	}
		function experience_name_filter_reset(){
		var id= '<?php echo $this->uri->segment(4);?>';
		window.location.href = "<?php echo base_url(); ?>admin/experience_bookingpayment/display_receivable/"+id;

	}
    function showRows_exp(obj){
        var trans_id=obj.value;
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>admin/Experience_bookingpayment/getReceivable_exp',
            data:{trans_id:trans_id},
            success:function(data){
                $("#selecteRow").html(data);
                $(".widget_content").css('display','none');
            }
        });
    }

</script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

		<script type="text/javascript" language="javascript" >
			$(document).ready(function() {
				var todate = '<?php echo $todate; ?>';
				var fromdate = '<?php echo $fromdate; ?>';
				
				var dataTable = $('#exp_recievable_tbl').DataTable( {
					"processing": true,
					"serverSide": true,
					"ajax":{
						data: {todate: todate, fromdate: fromdate},
						url :"<?php echo base_url(); ?>admin/Experience_bookingpayment/display_receivable_datatables", // json datasource
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
<?php
$this->load->view('admin/templates/footer.php');
?>
