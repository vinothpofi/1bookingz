<?php
$this->load->view('admin/templates/header.php');
extract($privileges);
?>
<style>
	.dataTables_filter{width: 52%; float: left;}
	.dataTables_filter input.btn{ margin-top: 0px; }
	select.search_cls{float: right; margin-left: 0px; margin-bottom: 10px;}
	.dataTables_filter input{padding: 5px 10px 5px 22px ;}
</style>
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
					<div class="dataTables_filter date-wise-filter" id="experience_name_filter"><label><strong>Select Date: </strong>
						<input placeholder="dd-MM-YYY" autocomplete="off" type="text" id="datepicker1" value="" name="fromdate">
						<input placeholder="dd-MM-YYY" autocomplete="off" type="text" id="datepicker2" value="" name="todate">
						<input type="button" onclick="experience_name_filter();" class="btn btn-block btn-success" value="Search" name="experience_name_filter_val">
						<input type="button" onclick="experience_name_filter_reset();" class="btn btn-block btn-success" value="Reset" name="experience_name_filter_val">
        </label></div>
				</div>                    <div>
                        <!-- <select name="transaction_id" id="tran_id" onChange="showRows(this);" class="search_cls">
                            <option>Select transaction id</option>
                            <?php foreach($commission_paid_transactionID->result() as $trns_id){ ?>
                            <option value="<?php echo $trns_id->id; ?>"><?php echo $trns_id->transaction_id; ?>
                                <?php  }  ?>
                        </select> -->
                    </div>
<br>


					<div class="widget_content table-responsive table-div">
						<table class="display display_tbl" id="rental_recievable">
							<thead>
							<tr>
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Date</th>
                                <th class="tip_top" title="Click to sort">Transaction Id</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th>Host Email Id</th>
								<th class="tip_top" title="Total amount with service fee and security fee in admin's currency">Total Paid Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Wallet Amount">Coupon Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Coupon Amount">Wallet Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Service fee in admin's currency">Guest Service Fee&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th>Host Service Fee</th>
								<th class="tip_top" title="Sum of Guest service fee and Host servie fee in admin's currency">Net Profit&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Payable amount to host in admin's currency">Amount to Host&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
							</tr>
							</thead>
							
							<tfoot>
							<tr>
								<th class="tip_top" title="Click to sort">S No</th>
								<th class="tip_top" title="Click to sort">Date</th>
								<th class="tip_top" title="Click to sort">Transaction Id</th>
								<th class="tip_top" title="Click to sort">Booking No</th>
								<th>Host Email Id</th>
								<th>Total Paid Amount</th>
								<th class="tip_top" title="Coupon Amount">Coupon Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
								<th class="tip_top" title="Wallet Amount">Wallet Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
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

function experience_name_filter(){

	if($('#datepicker2').val()!='' && $('#datepicker1').val()!=''){
	     var id= '<?php echo $this->uri->segment(4);?>';
		 $('#display_form').attr('action', 'admin/bookingpayment/display_receivable/'+id);
		  $('#display_form').attr('method', 'POST');
		 $("#display_form").submit();
		}
		else{
			alert("Please Select From and Todates");
		}
	}
		function experience_name_filter_reset(){
		var id= '<?php echo $this->uri->segment(4);?>';
		window.location.href = "<?php echo base_url(); ?>admin/bookingpayment/display_receivable/"+id;

	}


function showRows(obj){
        var trans_id=obj.value;
        $.ajax({
            type:'POST',
            url:'<?php echo base_url(); ?>admin/bookingpayment/getReceivable',
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
				var uid = '<?php echo $this->uri->segment(4); ?>';
				
				var dataTable = $('#rental_recievable').DataTable( {
					"processing": true,
					"serverSide": true,
					"searching": true,
					"ajax":{
						data: {todate: todate, fromdate: fromdate,uid: uid},
						url :"<?php echo base_url(); ?>admin/Bookingpayment/display_receivable_datatables", // json datasource
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
