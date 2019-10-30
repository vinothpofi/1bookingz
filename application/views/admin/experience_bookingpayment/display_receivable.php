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
					<div class="dataTables_filter date-wise-filter" id="experience_name_filter"><label><strong>Select Date: </strong>
						<input placeholder="dd-MM-YYY" type="text" autocomplete="off" id="datepicker1" value="" name="fromdate">
						<input placeholder="dd-MM-YYY" type="text" autocomplete="off" id="datepicker2" value="" name="todate">
						<input type="button" onclick="experience_name_filters();" class="btn btn-block btn-success" value="Search" name="experience_name_filter_val">
						<input type="button" onclick="experience_name_filter_reset();" class="btn btn-block btn-success" value="Reset" name="experience_name_filter_val">
        </label></div>

        		    <div class="select-filter">
                        <select name="transaction_id" id="tran_id" onChange="showRows_exp(this);">
                            <option>Select</option>
                            <?php foreach($commission_paid_transactionID->result() as $trns_id){ ?>
                            <option value="<?php echo $trns_id->id; ?>"><?php echo $trns_id->transaction_id; ?>
                                <?php  }  ?>
                        </select>
                    </div>

				</div> 
                   
                    <br>


					<div class="widget_content table-div">
						<table class="display display_tbl" id="subadmin_tbl">
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
							<?php
							if ($commissionTracking->num_rows() > 0)
							{
								$i = 1;
								foreach ($commissionTracking->result() as $row)
								{
									$totlessDays = $this->config->item ('cancel_hide_days_experience');
                        
									$minus_checkin =  strtotime("-".$totlessDays."days",strtotime($row->checkin));
							
									$checkinBeforeDay = date('Y-m-d',$minus_checkin);
								
									$current_date = date('Y-m-d');
									
									if($checkinBeforeDay <= $current_date){	
									?>
									<tr>
										<td class="center">
											<?php echo $i; ?>
										</td>
										<td class="center">
											<?php echo date('d-m-Y', strtotime($row->dateAdded)); ?>
										</td>

                                        <td>
                                            <?php
                                            if ($row->transaction_id!=''){
                                                echo $row->transaction_id;
                                            }else{
                                                echo "---";
                                            }

                                            ?>
                                        </td>
										<td class="center">
											<?php echo $row->booking_no; ?>
										</td>

										<td class="center">
											<?php echo $row->host_email; ?>
										</td>
										<td class="center" style="text-align:right">
											<?php

											$currencyPerUnitSeller = $row->currencyPerUnitSeller;
											if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id; }
											if ($admin_currency_code != $row->user_currencycode) 
											{												
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
												echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->total_amount,$currencyCronId);
											} 
											else 
											{
												echo $admin_currency_symbol . ' ' . number_format($row->total_amount,2);
											}
											?>
										</td>
										<td class="center" style="text-align:right">
											<?php
											if ($admin_currency_code != $row->user_currencycode) 
											{												
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->guest_fee);
												echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->guest_fee,$currencyCronId);
											} 
											else 
											{
												echo $admin_currency_symbol . ' ' . number_format($row->guest_fee,2);
											}
											?>
										</td>
										<td class="center" style="text-align:right">
											<?php 
											if ($admin_currency_code != $row->user_currencycode) 
											{												
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->host_fee);
												echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->host_fee,$currencyCronId);
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . number_format($row->host_fee,2);
											}
											?>
										</td>
										<td class="center" style="text-align:right">
											<?php 

											$net_profit = round($row->guest_fee + $row->host_fee, 2);

											if ($admin_currency_code != $row->user_currencycode) 
											{												
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $net_profit);
												echo currency_conversion($row->user_currencycode, $admin_currency_code, $net_profit,$currencyCronId);
											} 
											else 
											{
												echo $admin_currency_symbol . ' ' . number_format($net_profit,2);
											}
											?>
										</td>

										<td class="center" style="text-align:right">
											<?php 

											if ($admin_currency_code != $row->user_currencycode)
											{												
												echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->payable_amount);
												echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->payable_amount,$currencyCronId);
											} 
											else
											{
												echo $admin_currency_symbol . ' ' . number_format($row->payable_amount,2);
											}
											?>
										</td>
									</tr>
									<?php
									$i++;
									}
								}
							}
							?>
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
					 <div id="selecteRow">
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
		if(trans_id != 'Select'){
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
    }

</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
