<div class="right_side overview schedule-experience form_container left_label listingInfo">


	<div class="dashboard_price_left">

		<h3><?php if ($this->lang->line('experience_schedule') != '') {
				echo stripslashes($this->lang->line('experience_schedule'));
			} else echo "Schedule your Timing "; ?></h3>

		<p><?php if ($this->lang->line('Atitleandsummary') != '') {
				echo stripslashes($this->lang->line('Atitleandsummary'));
			} else echo "You can adjust this time depending on the dates you're scheduled to host. Each experience must be at least 1 hour."; ?> </p>

	</div>


	<!---List of schedule---->
	<div class="add_new_form">

		<form onsubmit="return validate_form()" id="exp_schedule_form" name="exp_schedule_form"
			  action="<?php echo base_url() . "photos_listing/" . $listDetail->row()->id; ?>" method="post"
			  accept-charset="UTF-8">
			<div class="dashboard_price_right">


				<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
					   value="<?php echo $listDetail->row()->experience_id; ?>"/>
				<input type="hidden" class=" col-sm-2" id="dates_id" name="dates_id"/>


				<div class="margin_top_20 margin_bottom_20">
						<span class="text-center">
							<span id="form_action_msg_common"></span>
						</span>
				</div>
				<div class="basic-next">
					<button class="btn btn-primary" id="add_new" type="button">Add new</button>
				</div>


				<div class="overview_title new_schedule_div" style="display:none;">

					<h4 class="margin_top_20 margin_bottom_20"><label
							class="exp-reqlbl"><?php if ($this->lang->line('experience_Schedule') != '') {
								echo stripslashes($this->lang->line('experience_Schedule'));
							} else echo "New Schedule"; ?> <span class="req"> *</span></label></h4>

					<div class="exp-outerpanel">

						<div class="row">

							<?php if ($listDetail->row()->date_count > 1) { ?>


								<div class="col-md-4 col-xs-12 no-padding margin_bottom_20">
									<label class="field_title service_det_edit" for="datetimepicker1">From
										Date: </label>
									<input autocomplete="off" type="text" class="dev_tour_date col-sm-2" placeholder="yyyy-mm-dd"
										   id="datetimepicker1" onchange='affectTodate()'
										   class="checkin ui-datepicker-target" style="cursor:pointer;" name="from_date"
										   onclick="datepick();"/>
								</div>

								<div class=" col-md-4 col-xs-12 no-padding">
									<label class="field_title service_det_edit" for="to_date">To Date: </label>
									<input autocomplete="off" type="text" placeholder="yyyy-mm-dd" class=" col-sm-2" id="to_date"
										   name="to_date" readonly value=""/>
								</div>

							<?php } else {
								?>
								<div class="col-md-4 col-xs-12 no-padding margin_bottom_20">
									<label class="field_title service_det_edit" for="datetimepicker1">Choose
										date</label>
									<input autocomplete="off" type="text" class="dev_tour_date col-sm-2" id="datetimepicker1"
										   onclick="datepick();" onchange='affectTodate()' name="from_date"/>
									<input type="hidden" class=" col-sm-2" id="to_date" name="to_date" readonly
										   value=""/>
								</div>

								<?php
							}
							?>


							<input type="hidden" class=" col-sm-2" id="exp_currency" name="exp_currency"
								   value="<?php echo $listDetail->row()->currency; ?>" readonly/>
							<input type="hidden" class=" col-sm-2" id="price_val" name="price"
								   value="<?php echo $listDetail->row()->price; ?>" readonly/>

							<div class="exp-addicon  col-md-4 col-xs-12 no-padding margin_top_10">
								<label style="margin-top: 15px;"></label>
								<button type="button" class="btn btn-sm btn-default" id='cancel_btn' title="cancel"
										onclick="cancel_dates_form()">Cancel</span></button>
								<button type="button" class="btn btn-sm btn-success" id='add_btn' title="Add Date"
										onclick="add_dates()">Submit
								</button>
							</div>

						</div>

						<!--- Experiece Panel9-->

						<div class="popup-panel-exp" id='dev_add_date_timing'
							 style='display: none; margin-bottom: 15px;'>

							<div class="exp-addpanel">
								<div style="display: block;overflow: hidden;">
									<div class="col-md-6">
										<label>Date</label>
										<?php if ($listDetail->row()->date_count > 1) { ?>
											<input type="text" class="dev_multi_schedule_date col-sm-2"
												   id="schedule_date1" autocomplete="off" name="schedule_date[]"
												   onclick="setDatepickerHere();"/>
										<?php } else { ?>
											<input type="text"
												   class="dev_multi_schedule_date dev_schedule_date col-sm-2"
												   id="schedule_date1" name="schedule_date[]" readonly/>
											<?php
										} ?>
									</div>

								</div>
								<div class="col-md-6">
									<label>Start Time</label>
									<input type="text" class="dev_time" name="start_time[]" value="" required/>
								</div>
								<div class="col-md-6">
									<label>End Time</label>
									<input type="text" class="dev_time" name="end_time[]" value="" required/>
								</div>
								<div class="col-md-12 exp-full">
									<label>Title</label>
									<input type="text" class="" name="schedule_title[]" value="" required/>
								</div>
								<div class="col-md-12 exp-full">
									<label>Title in Arabic</label>
									<input type="text" class="" name="schedule_title_ar[]" value="" required/>
								</div>
								<div class="col-md-12">
									<label>Description</label>
									<textarea class="" id="description_id" name="schedule_description[]"
											  required>  </textarea>
								</div>
                                <div class="col-md-12">
									<label>Description in Arabic</label>
									<textarea class="" id="description_id_ar" name="schedule_description_ar[]"
											  required>  </textarea>
								</div>

							</div>

						</div>


						<div class="exp-addicon">
							<button title="save"
									style='display:none;width: 40px;padding-right:4px;font-size: 16px;background: #a61d55; color:#ffffff;'
									type="button" class="" id='save_timing_btn' onclick="save_timing()">save
							</button>
						</div>

						<!--- Experiece Panel End-->

						<div style="">
							<input type="button" class="filter-btn" id="update_btn" style="display: none; float: left;"
								   name="" value="Update" onclick="update_tab2()">
							<input type="reset" class="filter-btn" id="reset_btn" style="display: none; float: left;"
								   name="" value="Cancel" onclick="reset_reload()">

						</div>

					</div>


				</div>


			</div>


		</form>

	</div>

	<hr>

	<ul class="tab-areas2 col-md-12">

		<!---List of schedule---->
		<li>

			<div class="managlist_tabl" id="package_table">

				<table id="example" cellspacing="0" width="100%" border="1" class="table table-striped display">
					<thead>
					<tr>
						<th>Start Date</th>
						<th>End Date</th>
						<!--<th>Price</th>-->
						<th>Action</th>
					</tr>
					<thead>
					<tbody>
					<?php

					/*echo '<pre>';
                     print_r($date_details->result());
                    echo '</pre>';
                    */

					// exit();

					if ($date_details->num_rows() > 0) {
						$i = 1;
						foreach ($date_details->result() as $row) {

							/* check for booking exist for tha particular schedule if exist dont allow to edit & delete */


							$check_booking_entry = $this->experience_model->ExecuteQuery("select * from " . EXPERIENCE_ENQUIRY . " where prd_id='" . $row->experience_id . "' and checkin='" . date('Y-m-d', strtotime($row->from_date)) . "' and checkout='" . date('Y-m-d', strtotime($row->to_date)) . "'");
							//echo $this->db->last_query();
							?>
							<tr id="parent_<?php echo $row->id; ?>">

								<td><input type="hidden" id="from_date_<?php echo $row->id; ?>"
										   value="<?php echo $row->from_date; ?>"><?php echo $row->from_date; ?></td>
								<td><input type="hidden" id="to_date_<?php echo $row->id; ?>"
										   value="<?php echo $row->to_date; ?>"><?php echo $row->to_date; ?></td>

								<!--<td><?php echo $row->price; ?> </td>-->

								<td>

									<?php if ($check_booking_entry->num_rows() == 0)  //$listDetail->row()->status == '0'
									{
										if (date('Y-m-d', strtotime($row->from_date)) > date('Y-m-d'))    /* schedule once started  means no edit priviledge */ {

											?>

										<?php } ?>

										<?php
										$allow = 0;
										if ($row->time_count < $listDetail->row()->date_count) {
											$allow = 1;
										} ?>
										<input type="hidden" name="schedule_hours_<?php echo $row->id; ?>"
											   id="schedule_hours_<?php echo $row->id; ?>"
											   value="<?php echo $listDetail->row()->total_hours; ?>">

										<span class=""
											  onclick="get_new_timesheet('<?php echo $row->id; ?>','<?php echo $row->status; ?>','<?php echo $allow; ?>');"
											  title="Add Sheduled timings"><i
												class="fa fa-plus-square-o fa-lg cursor_pointer" aria-hidden="true"></i></span>&nbsp;&nbsp;

										<span class="" onclick="view_timesheet('<?php echo $row->id; ?>');"
											  title="View Sheduled timings"><i class="fa fa-eye fa-lg cursor_pointer"
																			   aria-hidden="true"></i> (<?php echo $row->time_count; ?>
											) </span>&nbsp;&nbsp;

										<span><a class=""
												 href="admin/experience/delete_date/<?php echo $row->id; ?>/<?php echo $row->experience_id; ?>"
												 title="Delete"><i class="fa fa-trash-o fa-lg cursor_pointer"
																   aria-hidden="true"></i> </a></span>&nbsp;&nbsp;

										<?php
										//echo $row->status;
										if ($row->status == 1) {
											$active_str = 'Inactive';
										} else {
											$active_str = 'Active';
										}
										?>
										<span class="" title="Make inactive"><a class="btn-sm"
																				href='javascript:void(0);'
																				id="status_<?php echo $row->id; ?>"
																				onclick="change_date_status('<?php echo $row->id; ?>',this);"><?php echo $active_str; ?> </a></span>&nbsp;&nbsp;

										<span class="" onclick="hide_child('<?php echo $row->id; ?>');"
											  style="display:none;" id="hide_icon_<?php echo $row->id; ?>" title="hide"><i
												class="fa fa-minus-square-o fa-lg cursor_pointer"
												aria-hidden="true"></i></span>&nbsp;&nbsp;

									<?php } ?>
									<!--  <span><a class="action-icons c-delete" onclick="javascript:delete_season_data('<?php //echo $row->season_id;
									?>','<?php //echo $row->product_id;
									?>','<?php //echo $row->date_from;
									?>','<?php //echo $row->date_to;
									?>');" title="Delete">Delete</a></span> -->


								</td>
							</tr>


							<?php
							$i++;
						}
					} else {
						?>
						<tr>
							<td colspan="6">No Activity Found..</td>
						</tr>
					<?php } ?>
					<tbody>

				</table>


			</div>

		</li>
	</ul>

	<?php //echo ($timing==0) ? 'class="disabled_exp"' : ''; ?>
	<?php

	if ($timing == 1) {

		?>
		<!-- Tour dates selection Ends  -->
		<div class="basic-next" id="next_button_div">
			<button class="btn btn-success continue" type="button"
					onclick="next_form(event,'tagline_tab')"><?php if ($this->lang->line('Continue') != '') {
					echo stripslashes($this->lang->line('Continue'));
				} else echo "Continue"; ?></button>
		</div>
		<?php
	}
	?>

</div>

<script>
	function change_timing_status(id, obj, exp_date_id) {
		$('.loading').show();

		//hide_other_divs();
		$('.new_schedule_div').hide();
		str = $(obj).html().trim();

		if (str == 'Active') {
			status = '0';//inactive
			//$(obj).html('Inactive');
		} else {
			status = '1';//active
			//	$(obj).html('Active');
		}

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/change_timing_status',
			data: 'id=' + id + '&status=' + status + '&exp_date_id=' + exp_date_id,
			dataType: 'html',
			success: function (data) {
				//alert(data);
				//return false;
				/*if(data==2){
					//alert(data+'l');
					$('#status_'+exp_date_id).html('Inactive');
					$(obj).html('Active');
					$('#form_action_msg_common').html('Sheduled time has been activated Successfully..!');
					$('#form_action_msg_common').fadeIn('slow', function () {
						$(this).delay(1000).fadeOut('slow',function(){
							$('#form_action_msg_common').html('');
						});
					});
				}else{
				*/
				if (data) {
					if (str == 'Active') {
						$(obj).html('Inactive');
						$('#form_action_msg_common').html('Sheduled time has been inactivated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});

					} else {
						$(obj).html('Active');
						$('#form_action_msg_common').html('Sheduled time has been activated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});
					}
				}
				$('.loading').hide();

				//}
			}
		});
	}

	function change_date_status(id, obj) {
		$('.loading').show();

		hide_other_divs();
		$('.new_schedule_div').hide();
		str = $(obj).html().trim();

		if (str == 'Active') {
			status = '1';//inactive
			//$(obj).html('Inactive');
		} else {
			status = '0';//active
			//	$(obj).html('Active');
		}

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/change_date_status',
			data: 'id=' + id + '&status=' + status,
			dataType: 'html',
			success: function (data) {
				//alert(data);
				//return false;

				if (data) {
					if (str == 'Active') {
						$(obj).html('Inactive');
						$('#form_action_msg_common').html('Sheduled date has been inactivated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});

					} else {
						$(obj).html('Active');
						$('#form_action_msg_common').html('Sheduled date has been activated Successfully..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});
					}
				}
				window.location.reload();
			}
		});
	}

	function all_form_reset() {
		$('form').each(function () {
			this.reset()
		});
	}

	function cancel_time_sheet_grand_child(id) {
		all_form_reset();
		$('#grand_child_edit_' + id).remove();
	}

	function edit_time_sheet(id, date_id) {
		 $('.loading').show();
		$('[id^=grand_child_edit_]').hide();
		if ($('#grand_child_edit_' + id).length > 0) {
			$('#grand_child_edit_' + id).show();
			return false;
		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/get_timesheets_for_edit',
			data: 'id=' + id,
			dataType: 'html',
			success: function (data) {
				if (data != '') {

					$('#first_child_' + id).after(data);

					$('#grand_child_edit_' + id).show();
					 $('.loading').hide();
					$('.dev_multi_schedule_date').each(function () {


						$(this).datepicker({

							changeMonth: true,
							dateFormat: 'yy-mm-dd',
							numberOfMonths: 1,
							minDate: new Date($('#from_date_' + date_id).val()),
							maxDate: new Date($('#to_date_' + date_id).val()),
							beforeShowDay: unavailable_new,

						});
					});

					$('.dev_time').timepicker({
						'minTime': '12:00am',
						'maxTime': '11:59pm',
						'timeFormat': 'H:i',
						'step': 60,

					});

				}
			}
		});

		$('#update_time_sheet_' + id).show();
		$("#timesheet_" + id + " input").prop("disabled", false);
		$("#timesheet_" + id + " textarea").prop("disabled", false);

	}

	function update_time_sheet(id, date_id) {
		$('.loading').show();
		var schedule_date = $('#time_sheet_' + id).find('input[name="schedule_date"]').val();
		var start_time = $('#time_sheet_' + id).find('input[name="start_time"]').val();
		var end_time = $('#time_sheet_' + id).find('input[name="end_time"]').val();
		var title = $('#time_sheet_' + id).find('input[name="title"]').val();
		var description = $('#time_sheet_' + id).find('textarea[name="description"]').val();

		//
		if (schedule_date == '' || start_time == '' || end_time == '' || title == '' || description == '') {
			$('.loading').hide();

			$('#edit_form_error_msg_' + id).html('Please fill all mandatory fields');
			$('#edit_form_error_msg_' + id).fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow', function () {
					$('#edit_form_error_msg_' + id).html('');
				});
			});
			return false;
		}

        hours_count = $('#schedule_hours_' + date_id).val();
        hours_count = $('#schedule_hours_' + date_id).val();
        var diff_start = start_time.replace(":", ".");
        var diff_end = end_time.replace(":", ".");
        if (parseInt(diff_end) <= parseInt(diff_start)) {
        	$('.loading').hide();

            $('#edit_form_error_msg_' + id).html('End time should be greater than start time');
            $('#edit_form_error_msg_' + id).fadeIn('slow', function () {
                $(this).delay(5000).fadeOut('slow', function () {
                    $('#edit_form_error_msg_' + id).html('');
                });
            });
            return false;
        }

		if (hours_count != '' && hours_count > 0) {
			var diff_start = start_time.replace(":", ".");
			var diff_end = end_time.replace(":", ".");
			diff = parseFloat(diff_end - diff_start);

			if (parseInt(hours_count) == parseInt(diff)) {
				//alert('same');
			} else {
				$('.loading').hide();

				//alert('not same');
				$('#edit_form_error_msg_' + id).html('Allowed time limit is ' + hours_count + ' hours ');
				$('#edit_form_error_msg_' + id).fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow', function () {
						$('#edit_form_error_msg_' + id).html('');
					});
				});
				return false;
			}

		}
		if (id != '' && id != null) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/update_timesheet',
				data: $('#time_sheet_' + id).serialize(),
				dataType: 'html',
				success: function (data) {
					if (data) {
						alert('Time schedule is updated successfully');
						window.location.reload();
					}
				}
			});
		}
	}

	function remove_time_sheet(id) {
		//alert(id);
		if (confirm('Are you sure to delete this scheduled timing?')) {
			$('#first_child_' + id).remove();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/delete_timesheet',
				data: "id=" + id,
				dataType: 'html',
				success: function (data) {
					alert('Time schedule has been removed successfully');
					window.location.reload();
				}
			});
		}
	}

	function hide_child(date_id) {

		$('.child_' + date_id).remove();
		hide_other_divs(date_id);
		//$('#next_button_div').show();
		continue_button_manage('show');
	}

	function cancel_time_sheet(date_id) {
		all_form_reset();
		$('#child_create_' + date_id).hide();
		//$('#next_button_div').show();
		continue_button_manage('show');
	}

	function hide_other_divs(date_id='') {
		$('#hide_icon_' + date_id).hide();
		all_form_reset();
		if (date_id == '') {
			$('[id^=child_create_]').hide();
			$('[id^=child_view_]').hide();

			$('[id^=grand_child_edit_]').hide();
			//$('#next_button_div').hide();
			continue_button_manage('hide');
		} else {
			$('[id^=grand_child_edit_]').hide();
			$('#child_create_' + date_id).hide();
			$('#child_view_' + date_id).hide();
			//$('#next_button_div').hide();
			continue_button_manage('hide');
		}
	}

	function get_new_timesheet(date_id, status, allow) {

		//show_hide_icon();
		$('#hide_icon_' + date_id).show();
		//$('#next_button_div').hide();
		$('.new_schedule_div').hide();
		continue_button_manage('hide');
		hide_other_divs();

		if (allow == 0) {
			$('#form_action_msg_common').html('Timings were scheduled for this date limits. Please add a new date');
			$('#form_action_msg_common').fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow', function () {
					$('#form_action_msg_common').html('');
				});
			});
			continue_button_manage('show');
			return false;

		}
		if (status == 1) {
			$('#form_action_msg_common').html('Please activate the scheduled date and add timings');
			$('#form_action_msg_common').fadeIn('slow', function () {
				$(this).delay(5000).fadeOut('slow', function () {
					$('#form_action_msg_common').html('');
				});
			});

			return false;
		}

		if ($('#child_create_' + date_id).length > 0) {
			$('#child_create_' + date_id).show();
			$('#child_view_' + date_id).hide();
			return false;
		}

		$('#child_create_' + date_id).show();

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/get_new_timesheet',
			data: "date_id=" + date_id,
			dataType: 'html',
			success: function (data) {

				$('#child_create_' + date_id).remove();

				if ($('#child_view_' + date_id).length > 0) {
					$('#child_view_' + date_id).hide();
					$('#child_view_' + date_id).after(data);
				} else {
					$('#parent_' + date_id).after(data);
				}

				$('.dev_time').timepicker({
					'minTime': '12:00am',
					'maxTime': '11:59pm',
					'timeFormat': 'H:i',
					'step': 60,

				});


				$('.dev_multi_schedule_date').each(function () {
					$(this).datepicker({

						changeMonth: true,
						dateFormat: 'yy-mm-dd',

						numberOfMonths: 1,
						minDate: new Date($('#from_date_' + date_id).val()),
						maxDate: new Date($('#to_date_' + date_id).val()),
						beforeShowDay: unavailable_add_new,

					});
				}); 


			}
		});
	}
	/*Assign time to hour*/
	// function assign_to_time_hour_edit(id, date_id) {


	// }
    function assign_to_time_hour(date_id, tim='') {
		hours_count = $('#schedule_hours_' + date_id).val();
		//alert(hours_count);
		//return false;

		var s_time = $('#new_time_sheet_' + date_id).find('input[name="start_time"]').val();
		var e_time = $('#new_time_sheet_' + date_id).find('input[name="end_time"]').val();
		var diff_start = s_time.replace(":", ".");
			var diff_end = e_time.replace(":", ".");
			if(e_time=='00:00') { e_time='24:00'; }	
		// if (parseInt(diff_end) <= parseInt(diff_start)) {
        //     $('.loading').hide();
        //     $('#new_form_error_msg_' + date_id).html('End time should be greater than start time');
        //     $('#new_form_error_msg_' + date_id).fadeIn('slow', function () {
        //         $(this).delay(5000).fadeOut('slow', function () {
        //             $('#new_form_error_msg_' + date_id).html('');
        //         });
        //     });
		// 	$('#end_time_' + date_id).val('');
        //     return false;
        // }
		
		if (hours_count != '' && hours_count > 0) {
			var diff_start = s_time.replace(":", ".");
			var diff_end = e_time.replace(":", ".");
			
			end_val = (parseFloat(diff_start) + parseFloat(hours_count)).toFixed(2); 
            end_val = (end_val).slice(-5); 
			diff = parseFloat(end_val - diff_start);
			//alert(end_val); return false;
			if (end_val < 24) {
				end_val = end_val.replace(".", ":");
                $('#end_time_' + date_id).val(end_val);
				//alert('same');
			} else {
				$('#end_time_' + date_id).val('');
				$('.loading').hide();
				$('#new_form_error_msg_' + date_id).html('Allowed time limit is ' + hours_count + ' hours ');
				$('#new_form_error_msg_' + date_id).fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow', function () {
						$('#new_form_error_msg_' + date_id).html('');
					});
				});
				return false;
			}


		}

	}

	function add_time_sheet(date_id) {	
	$('.loading').show();	 
		start_time = $('#start_time_' + date_id).val();
		end_time = $('#end_time_' + date_id).val();
		schedule_date = $('#schedule_date_' + date_id).val();
		title = $('#title_' + date_id).val();
		//title_ar = $('#title_ar_' + date_id).val();
		description = $('#description_' + date_id).val();
		//description_ar = $('#description_ar_' + date_id).val();		
		//$('#next_button_div').hide();
		continue_button_manage('hide');

		if (start_time == '' || end_time == '' || schedule_date == '' || title == '' || description == '') {
			//alert('Please fill all fields and proceed');
			$('.loading').hide();
			$('#new_form_error_msg_' + date_id).html('Please fill all mandatory fields');
			$('#new_form_error_msg_' + date_id).fadeIn('slow', function () {
				$(this).delay(1000).fadeOut('slow', function () {
					$('#new_form_error_msg_' + date_id).html('');
				});
			});
			return false;
		}


		hours_count = $('#schedule_hours_' + date_id).val();
		//alert(hours_count);
		//return false;

		var s_time = $('#new_time_sheet_' + date_id).find('input[name="start_time"]').val();
		var e_time = $('#new_time_sheet_' + date_id).find('input[name="end_time"]').val();
		var diff_start = s_time.replace(":", ".");
			var diff_end = e_time.replace(":", ".");
			if(e_time=='00:00') { e_time='24:00'; }	
		if (parseInt(diff_end) <= parseInt(diff_start)) {
            $('.loading').hide();
            $('#new_form_error_msg_' + date_id).html('End time should be greater than start time');
            $('#new_form_error_msg_' + date_id).fadeIn('slow', function () {
                $(this).delay(5000).fadeOut('slow', function () {
                    $('#new_form_error_msg_' + date_id).html('');
                });
            });
            return false;
        }
		
		if (hours_count != '' && hours_count > 0) {
			var diff_start = s_time.replace(":", ".");
			var diff_end = e_time.replace(":", ".");
			diff = parseFloat(diff_end - diff_start);
			//alert(diff); return false;
			if (parseInt(hours_count) == parseInt(diff)) {
				//alert('same');
			} else {
				//alert('not same');
				$('.loading').hide();
				$('#new_form_error_msg_' + date_id).html('Allowed time limit is ' + hours_count + ' hours ');
				$('#new_form_error_msg_' + date_id).fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow', function () {
						$('#new_form_error_msg_' + date_id).html('');
					});
				});
				return false;
			}


		}
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/add_timesheet',
			data: $('#new_time_sheet_' + date_id).serialize(),
			dataType: 'html',
			success: function (data) {
				if (data) {
					alert('Time schedule has been added successfully');
					//$('#next_button_div').hide();
					continue_button_manage('hide');
					window.location.reload();
				}
			}
		});

	}

	function view_timesheet(date_id) {
		//show_hide_icon();
		$('.loading').show();
		$('#hide_icon_' + date_id).show();
		hide_other_divs();
		$('.new_schedule_div').hide();
		if ($('#child_view_' + date_id).length > 0) {
			$('#child_view_' + date_id).show();
		}
		$('#child_view_' + date_id).show();

		if ($('.child_' + date_id).length > 0) {
			$('.loading').hide();
			return false;
		}

		if (date_id != '' && date_id != null) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/get_timesheets',
				data: "date_id=" + date_id,
				dataType: 'html',
				success: function (data) {
					//alert(data);
					//$(data).insertAfter('#parent_'+date_id);
					$('.loading').hide();
					$('#parent_' + date_id).after(data);
					//$('#child_'+date_id).html(data);
					$('.dev_time').timepicker({
						'minTime': '12:00am',
						'maxTime': '11:59pm',
						'timeFormat': 'H:i',
						'step': 60,

					});

				}
			});
		}
		return false;
	}

	function unavailable_add_new(date) {

		dateAr = [];
		$('.scheduled_date_exists').each(function () {
			//alert($(this).val());
			dateAr.push($(this).val());
		});
		var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		return [dateAr.indexOf(string) == -1];

	}

	function unavailable_new(date) {
		dateAr = [];
		$('.dev_multi_schedule_date_new').each(function () {
			//alert($(this).val());
			dateAr.push($(this).val());
		});
		var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		return [dateAr.indexOf(string) == -1];
	}

	function cancel_dates_form() {
		$('.new_schedule_div').hide();
		//$('#next_button_div').show();
		continue_button_manage('show');
	}

</script>


<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css"/>


<script type="text/javascript">

	function checkSpcialChar(event) {

		if (!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))) {
			event.returnValue = false;
			return;
		}
		event.returnValue = true;
	}

</script>

<script type="text/javascript">
	function validate_form() {
		var title = $("#title");
		var summary = $("#summary");
		var contents = summary.val();
		var words = contents.split(/\b\S+\b/g).length - 1;
		if (title.val() == "") {
			alert("Please enter Title");
			return false;
		}
		else if (summary.val() == "") {
			alert("Please enter summary");
			return false;
		}
		if (words > 150) {
			alert("Total of " + words + "words found! Summary should not exceed 150 words!");
			return false;
		}

	}
</script>


<script>
	function unavailable(date) {
		dateAr = [];
		$('.dev_multi_schedule_date').each(function () {

			dateAr.push($(this).val());


		});
		var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
		return [dateAr.indexOf(string) == -1];
	}

	function setDatepickerHere() {



		/*
        $('.dev_multi_schedule_date').datepicker({
            changeMonth: true,
            dateFormat: 'yy-mm-dd',
            numberOfMonths: 1,
            minDate:0
        });
        */
		// $('.dev_multi_schedule_date').each(function(){
		// 	    $(this).datepicker({
		// 	    	changeMonth: true,
		// 			dateFormat: 'yy-mm-dd',
		// 			numberOfMonths: 1,
		// 			minDate: new Date($('#datetimepicker1').val()),
		// 			maxDate :new Date($('#to_date').val()),
		// 	    });
		// 	});
		$('.dev_multi_schedule_date').each(function () {


			$(this).datepicker({

				changeMonth: true,
				dateFormat: 'yy-mm-dd',

				numberOfMonths: 1,
				minDate: new Date($('#datetimepicker1').val()),
				maxDate: new Date($('#to_date').val()),
				beforeShowDay: unavailable,

			});
		});


	}


	function datepick() {
		//datepicker
		// alert("aa");

		$('.dev_tour_date').datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			minDate: 0,
			onSelect: function (selected) {
				//alert(selected);
				//var selectedDate = new Date(selected);
				/*var tomorrow = new Date();
                date_count = Number(<?php echo $listDetail->row()->date_count; ?>);
			selectedDate.setDate(selectedDate.getDate() + date_count);
	        //var endDate = selected;
	       // alert(selectedDate.getDate() );
	      	$("#to_date").val(selectedDate);

	      	*/

				date_count = Number(<?php echo $listDetail->row()->date_count; ?>);

				if (date_count == 1) {
					$(".dev_schedule_date").val(selected);
				}

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url()?>admin/experience/todateCalculate',
					data: {from_date: selected, date_count: date_count},
					success: function (response) {

						$("#to_date").val(response.trim());
						//window.location.reload(true);

					}
				});

			}
		});


	}


	//Timepicker
	$('.dev_time').timepicker({
		'minTime': '12:00am',
		'maxTime': '11:59pm',
		'timeFormat': 'H:i',
		'step': 60,

	});


	//Add new Date
	function add_dates() {

//alert("addNEwDate");
//save_timing();
//return false;
		$('.loading').show();
		var from_date = $("#datetimepicker1").val();
		var to_date = $("#to_date").val();
		var price = $("#price_val").val();
		var experience_id = '<?php echo $id; ?>';
		var dev_exp_currency = $("#dev_exp_currency").val();


		if (from_date != '' && to_date != '' && price != '') {

			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/saveDates',
				data: {
					from_date: from_date,
					to_date: to_date,
					price: price,
					experience_id: experience_id,
					currency: dev_exp_currency
				},
				dataType: 'json',
				success: function (data) {
					if (data.case == 1) {
						//$("div.added").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");

						$('#dates_id').val(data.date_id);
						$('#add_btn').css('display', 'none');


						/*$('#dev_add_date_timing').css('display','block');
                         $('#save_timing_btn').css('display','block');
                        */

						setDatepickerHere();//set datepicker
						//alert('Date has been added Successfully');
						$('#form_action_msg_common').html('Sheduled date has been added Successfully');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});

						window.location.reload();

						//save_timing();

					} else if (data.case == 2) {
						//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");


						window.location.reload();
					}
					else if (data.case == 3) {
						$('.loading').hide();

						//alert('Sheduled date exists Already..! ');
						$('#form_action_msg_common').html('Sheduled date exists Already..! ');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});
					}
					else if (data.case == 4) {
						$('.loading').hide();

						alert('Not Valid Times');
						$('#datetimepicker1').val('');
						$('#to_date').val('');
					}
				}
			});

		} else {
			if (price != '') {
				//alert('Please Choose From Date.');
				//alert('Please fill price/currency in Basic Details .');
				$('#form_action_msg_common').html('Please Choose Scheduled Date');
				$('#form_action_msg_common').fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow', function () {
						$('#form_action_msg_common').html('');
					});
				});
			}
			else {
				//alert('Please fill all data');
				$('#form_action_msg_common').html('Please fill all data');
				$('#form_action_msg_common').fadeIn('slow', function () {
					$(this).delay(5000).fadeOut('slow', function () {
						$('#form_action_msg_common').html('');
					});
				});
			}
			$('.loading').hide();
			
		}
	}

	/* add timing of new dates */
	function add_timing_row(rowID) {
		date_count = Number(<?php echo $listDetail->row()->date_count; ?>);
		from_date = $('#datetimepicker1').val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/add_timing_row',
			data: {rowID: rowID, date_count: date_count, from_date: from_date},
			success: function (response) {
				$("#add_timing_btn_" + rowID).css('display', 'none');
				$("#dev_new_timing" + rowID).addClass("popup-panel-exp");
				$("#dev_new_timing" + rowID).html(response);


				//window.location.reload(true);
				//add timepicker
				$('.dev_time').timepicker({
					'minTime': '12:00am',
					'maxTime': '11:59pm',
					'timeFormat': 'H:i',
					'step': 60,
				});

				setDatepickerHere();//add datepicker to edit rows	

			}
		});
	}

	/* add timing of new dates  ends*/
	function add_scheduled_date() {
		schedule_date = $("input[name='schedule_date[]']").map(function () {
			return $(this).val();
		}).get();
		experience_id = $('#experience_id').val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/add_timing_row',
			data: {schedule_date: schedule_date, experience_id: experience_id},
			success: function (response) {

			}
		});

	}

	/* save timing starts */
	function save_timing() {

		experience_id = $('#experience_id').val();
		dates_id = $('#dates_id').val();
		start_time = $("input[name='start_time[]']").map(function () {
			return $(this).val();
		}).get();
		end_time = $("input[name='end_time[]']").map(function () {
			return $(this).val();
		}).get();
		schedule_date = $("input[name='schedule_date[]']").map(function () {
			return $(this).val();
		}).get();

		schedule_title = $("input[name='schedule_title[]']").map(function () {
			return $(this).val();
		}).get();
		schedule_title_ar = $("input[name='schedule_title_ar[]']").map(function () {
			return $(this).val();
		}).get();
		schedule_description = $("textarea[name='schedule_description[]']").map(function () {
			return $(this).val();
		}).get();
		schedule_description_ar = $("textarea[name='schedule_description_ar[]']").map(function () {
			return $(this).val();
		}).get();

		error = error_in_mandatory = error_schd_date = error_time = 0;
		wrongTimingID = [];

		//alert(schedule_date);

		for (i = 0; i < schedule_date.length; i++) {
			if (schedule_date[i] == '0000-00-00' || schedule_date[i] == '')
				error_schd_date += 1;
		}

		for (i = 0; i < start_time.length; i++) {
			if (schedule_title[i] == '') {
				error = error + 1;
			}
			if (start_time[i] == '' || end_time[i] == '' || schedule_date[i] == '') {
				error_in_mandatory = error_in_mandatory + 1;
			}
			//alert(start_time[i]>end_time[i]);
			if (start_time[i] > end_time[i]) {
				error_time = error_time + 1;
				wrongTimingID.push(i + 1);
			}
		}

		if (error == 0 && error_in_mandatory == 0 && error_time == 0 && error_schd_date == 0) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/save_date_schedule_timing',
				data: {
					experience_id: experience_id,
					dates_id: dates_id,
					start_time: start_time,
					end_time: end_time,
					schedule_date: schedule_date,
					schedule_title: schedule_title,
					schedule_title_ar: schedule_title_ar,
					schedule_description: schedule_description,
					schedule_description_ar: schedule_description_ar
				},
				dataType: 'json',
				success: function (data) {
					//alert(response);
					//window.location.reload(true);

					//$("#experience_id").val(response);

					if (data.case == 1) {
						alert('Invalid Schedule Periods.');
						window.location.reload();
					} else if (data.case == 2) {
						alert("Schedule Period saved successfully.");
						window.location.reload();
					}


				}
			});
		} else {
			if (error_schd_date > 0) {
				alert('schedule date required.');
			}
			if (error > 0) {
				alert('title is required');
			}
			else if (error_in_mandatory > 0) {
				alert('Please fill all fields.');
			} else if (error_time >= 0) {
				alert('Start time should be less than end time in following schedules: ' + wrongTimingID);
			}
		}
	}

	/* save timing ends */

	/* delete timing row */
	function delete_timing_row(row_id) {
		var r = confirm("Are you sure,Do you want to delete this schedule?");
		if (r == true) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/delete_timing_row',
				data: {row_id: row_id},
				success: function (response) {
					//alert(response);
					window.location.reload(true);


				}
			});
		} else {

		}
	}

	function hide_edit(date_id) {
		$('#dev_add_date_timing_' + date_id).hide();
	}

	/* edit existing dates  starts */
	function get_activity_data(exp_id, date_id, start_date, end_date, price) {

		$('#dates_id').val(date_id);
		$('#datetimepicker1').val(start_date);
		$('#to_date').val(end_date);
		$('#price').val(price);


		//$('#child_price').val(child_price);

		$('#add_btn').hide();


		$('#dev_add_date_timing').css('display', 'block');
		$('#save_timing_btn').css('display', 'none');
		//$('#save_timing_btn').css('display','block');

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/get_timing',
			data: {experience_id: exp_id, date_id: date_id},
			success: function (response) {
				$('#dev_add_date_timing_' + date_id).show();
				$('#dev_add_date_timing_' + date_id).html(response);
				$('.dev_time').timepicker({
					'minTime': '12:00am',
					'maxTime': '11:59pm',
					'timeFormat': 'H:i',
					'step': 60,
				});
				setDatepickerHere();//add datepicker to edit rows	
			}
		});


		$('#update_btn').show();
		$('#reset_btn').show();

	}

	function update_tab2() {
		var date_id = $('#dates_id').val();
		var from_date = $('#datetimepicker1').val();
		var to_date = $('#to_date').val();
		var price = $('#price').val();
		var experience_id = $('#experience_id').val();
		var dev_exp_currency = $("#dev_exp_currency").val();

		//alert(dev_exp_currency);
		//return false;

		if (from_date != '' && to_date != '' && (from_date)) {


			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>admin/experience/updateDates',
				data: {
					date_id: date_id,
					from_date: from_date,
					to_date: to_date,
					price: price,
					experience_id: experience_id,
					currency: dev_exp_currency
				},
				dataType: 'json',
				success: function (data) {
					if (data.case == 1) {


						experience_id = $('#experience_id').val();
						dates_id = $('#dates_id').val();
						start_time = $("input[name='start_time[]']").map(function () {
							return $(this).val();
						}).get();
						end_time = $("input[name='end_time[]']").map(function () {
							return $(this).val();
						}).get();
						schedule_date = $("input[name='schedule_date[]']").map(function () {
							return $(this).val();
						}).get();

						schedule_title = $("input[name='schedule_title[]']").map(function () {
							return $(this).val();
						}).get();
						schedule_description = $("textarea[name='schedule_description[]']").map(function () {
							return $(this).val();
						}).get();
						error = error_in_mandatory = error_time = error_schd_date = 0;
						wrongTimingID = [];
						//alert(schedule_date);
						for (i = 0; i < schedule_date.length; i++) {
							if (schedule_date[i] == '0000-00-00' || schedule_date[i] == '')
								error_schd_date += 1;
						}
						for (i = 0; i < start_time.length; i++) {
							if (schedule_title[i] == '') {
								error = error + 1;
							}
							if (start_time[i] == '' || end_time[i] == '' || schedule_date[i] == '') {
								error_in_mandatory = error_in_mandatory + 1;
							}
							//alert(start_time[i]>end_time[i]);
							if (start_time[i] > end_time[i]) {
								error_time = error_time + 1;
								wrongTimingID.push(i + 1);
							}
						}
						if (error == 0 && error_in_mandatory == 0 && error_time == 0 && error_schd_date == 0) {
							$.ajax({
								type: 'POST',
								url: '<?php echo base_url()?>admin/experience/save_date_schedule_timing',
								data: {
									experience_id: experience_id,
									dates_id: dates_id,
									start_time: start_time,
									end_time: end_time,
									schedule_date: schedule_date,
									schedule_title: schedule_title,
									schedule_description: schedule_description
								},
								success: function (response) {
									//alert(response);
									save_timing(); // save timings
									window.location.reload(true);


								}
							});
						} else {

							$('#form_action_msg_common').html('Sheduled date exists Already..!');
							$('#form_action_msg_common').fadeIn('slow', function () {
								$(this).delay(1000).fadeOut('slow', function () {
									$('#form_action_msg_common').html('');
								});
							});

							if (error_schd_date > 0) {
								alert('schedule date required.');
							}
							if (error > 0) {
								alert('title is required');
							}
							else if (error_in_mandatory > 0) {
								alert('Please fill all fields.');
							} else if (error_time >= 0) {
								alert('Start time should be less than end time in following schedules: ' + wrongTimingID);
							}
						}


						//window.location.reload();
					}
					else if (data.case == 2) {
						//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");


						window.location.reload();
					}
					else if (data.case == 3) {
						//alert('Sheduled date exists Already..!');
						$('#form_action_msg_common').html('Sheduled date exists Already..!');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});
					}
					else if (data.case == 4) {
						//alert('Not Valid Times');

						$('#form_action_msg_common').html('Not Valid Times');
						$('#form_action_msg_common').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#form_action_msg_common').html('');
							});
						});

						$('#datetimepicker1').val('');
						$('#to_date').val('');
					}
				}
			});
		}

		else {
			alert('Please Fill All Values');
		}

	}

	function reset_reload() {
		window.location.reload();
	}

	/* edit existing dates  ends */

	function Detailview(catID, title, chk) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/product/saveDetailPage',
			data: {catID: catID, title: title, chk: chk},
			success: function (response) {
				window.location.reload(true);
			}
		})
	}

</script>

<script type="text/javascript">
	$(document).ready(function () {
		datepick();
		//setDatepickerHere();
	});
</script>

<script type="text/javascript">
	function isNumber(evt) {
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}
		return true;
	}
</script>


<script>
	$(document).ready(function () {
		$(document).on("click", ".btn1", function () {
			$(this).parent().parent().parent().removeClass("popup-panel-exp");
			$(this).parent().parent(".removeBlock").remove();
		});


	});

	$(document).ready(function () {
		$('#next-btn').click(function (e) {
			has = $(this).hasClass("disabled_exp");
			if (has == false) {
				window.location.href = '<?php echo base_url() . "tagline_experience/" . $id; ?>';
			}
		});
		$('#add_new').click(function (e) {
			hide_other_divs();
			$('.new_schedule_div').show();

		});
	});
</script>

<script>
    function word_count(obj){
        var id = obj.id;
        var wordLen1 = 10, len1;
        len1 = $('#'+id).val().split(/[\s]+/);
        if (len1.length > wordLen1) {
            if (event.keyCode == 46 || event.keyCode == 8) {
            }
            else if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
            }
        }
        wordsLeft = (wordLen1) - len1.length;
        if (wordsLeft <= 0) {
            $('#' + id + '_char_count').text("10 Words Reached");
            return false;
        }
        else {
            $('#' + id + '_char_count').html("You can add " + wordsLeft + " more words!");
        }
    }

    function description_count(obj1){
        var id_desc = obj1.id;
        var wordLen_desc = 50, len_desc;
        len_desc = $('#'+id_desc).val().split(/[\s]+/);
        if (len_desc.length > wordLen_desc) {
            if (event.keyCode == 46 || event.keyCode == 8) {
            }
            else if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
            }
        }
        wordsLeft_desc = (wordLen_desc) - len_desc.length;
        if (wordsLeft_desc <= 0) {
            $('#' + id_desc + '_char_count').text("50 Words Reached");
            return false;
        }
        else {
            $('#' + id_desc + '_char_count').html("You can add " + wordsLeft_desc + " more words!");
        }
    }
</script>
