<?php
$this->load->view('admin/templates/header.php');
?>
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

	<link rel="stylesheet" href="<?php echo base_url();?>css/localize/bootstrap-3.37.min.css">
	<script src="<?php echo base_url();?>css/localize/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url();?>css/localize/bootstrap-3.3.7.min.js"></script>

	<link rel="stylesheet" media="all" href="<?php echo base_url(); ?>css/font-awesome.css" type="text/css"/>
<?php echo $map['js']; ?>
	<style type="text/css">
		/* Style the tab */
		div.tab {
			float: left;
			border: 1px solid #ccc;
			background-color: #f1f1f1;
			width: 20%;
			/* height: auto;*/
			height: 600px;
			overflow-y: auto;
		}

		/* Style the buttons inside the tab */
		div.tab button {
			display: block;
			background-color: inherit;
			color: black;
			padding: 22px 16px;
			width: 100%;
			border: none;
			outline: none;
			text-align: left;
			cursor: pointer;
			transition: 0.3s;
		}

		/* Change background color of buttons on hover */
		div.tab button:hover {
			background-color: #ddd;
		}

		/* Create an active/current "tab button" class */
		div.tab button.active {
			background-color: #ccc;
		}

		/* Style the tab content */
		.tabcontent {
			float: left;
			padding: 0px 12px;
			border: 1px solid #ccc;
			width: 70%;
			border-left: none;
			/*height: 300px;*/
			height: auto;

		}

		.margin_top_20 {
			margin-top: 20px;
		}

		.margin_top_10 {
			margin-top: 10px;
		}

		.margin_bottom_20 {
			margin-bottom: 20px;
		}

		.error {
			color: red;
			display: none;
		}

		.disabled_exp {
			/*cursor:not-allowed;*/
			opacity: 0.5;
		}

		.disabled_exp:hover {
			opacity: 0.5;
			color: #000 !important;
			/*background: #a61d55 !important;*/
			cursor: default !important;
		}

		.disabled_exp span:hover {
			color: #000 !important;
			background: none;
		}

		.cursor_pointer {
			cursor: pointer;
		}

		.input_class {
			height: auto !important;
			/*padding:3px !important;*/
		}

		.small_label {
			color: #acacac;
			font-size: 12px;
			width: 100%;
		}

		#form_action_msg_common {
			color: #f2750b;
			font-size: 14px;
		}

		.error_msg {
			color: #f2750b;
			font-size: 14px;
			margin-bottom: 10px;
			text-align: center;
		}

		.dashboard_price_main .square_box {
			padding: 20px;
			border: 1px solid rgba(249, 238, 238, 0.5) !important;
		}

		table.display td input {
			height: auto !important;
			padding: 2px !important;
		}

		.green {
			color: green;
			font-weight: bold;
		}
	</style>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12 margin_top_20">

				<div class="col-md-12 text-right">
					<div class="form_input">
						<br>
						<a href="admin/experience/experienceList" class="tipLeft btn btn-primary"
						   title="Go to experience list"><span class="">Back</span></a>
					</div>
				</div>

				<!----new---tab---->

				<div class="tab">

					<button class="tablinks <?php echo ($basics == 0) ? '' : ''; ?> "
							onclick="openContent(event, 'basics',this)" id="basic_tab">
						Basics<?php echo ($basics == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($language == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'language',this)" id="language_tab">
						Language<?php echo ($language == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($organization == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'organization',this)" id="organization_tab">
						Organization<?php echo ($organization == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($exp_title == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'exp_title',this)" id="experience_title_tab">Experience
						Title<?php echo ($exp_title == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($timing == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'timing',this)" id="timing_tab">
						Timing<?php echo ($timing == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($tagline == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'tagline',this)" id="tagline_tab">
						Tagline<?php echo ($tagline == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($photos == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'photos',this)" id="photos_tab">
						Photos<?php echo ($photos == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($what_we_do == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'what_we_do',this)" id="what_we_do_tab">What we'll
						do<?php echo ($what_we_do == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($where_will_be == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'where_will_be',this)" id="where_will_be_tab">Where we'll
						be<?php echo ($where_will_be == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($where_will_meet == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'where_will_meet',this)" id="where_will_meet_tab">Where we'll
						meet<?php echo ($where_will_meet == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($what_will_provide == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'what_you_will_provide',this)" id="what_you_will_provide_tab">
						What you'll
						provide<?php echo ($what_will_provide == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($notes == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'notes',this)" id="notes_tab">
						Notes<?php echo ($notes == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>
					<button class="tablinks <?php echo ($about_you == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'about_you',this)" id="about_you_tab">About
						Host<?php echo ($about_you == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>


					<button class="tablinks <?php echo ($guest_req == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'guest_req',this)" id="guest_req_tab">Guest
						Requirements<?php echo ($guest_req == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($group_size == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'group_size',this)" id="group_size_tab">Group
						size<?php echo ($group_size == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

					<button class="tablinks <?php echo ($price == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'price_content',this)" id="price_tab">
						Price<?php echo ($price == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>
					<button class="tablinks <?php echo ($cancel_policy == 0) ? 'disabled_exp' : ''; ?>"
							onclick="openContent(event, 'cancel_policy',this)" id="cancel_policy_tab">Cancellation
						Policy<?php echo ($cancel_policy == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>
				</div>


				<div id="basics" class="tabcontent">
					<h3>Basics
						<br>
						<small>Set the basic mandatory fields of your experience.</small>

					</h3>

					<form id="basic_form" name="basic_form" method='post' class="form_container left_label listingInfo">
						<div class="dashboard_price_right margin_top_20">

							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center margin_top_20 margin_bottom_20" id="error_basic">
								<small> * Please fill all mandatory fields</small>
								</span>
							</div>
							<ul class="tab-areas1">

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Experience Owner Name <span
												class="req">*</span></label>
										<div class="form_input">
											<?php
											if (!empty($userdetails)) {
												foreach ($userdetails->result() as $user_details) {


													?>

													<?php if ($user_details->id == $product_details->row()->user_id) {
														echo ucfirst($user_details->firstname) . ' ' . ucfirst($user_details->lastname);
													}


												}
											} ?>


										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="product_name">Title </label>
										<div class="form_input">
											<?php
											if ($product_details->row()->product_title != '') {
												echo $product_details->row()->product_title;
											} else {
												echo 'Not available';
											}
											?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Experience Type <span
												class="req">*</span></label>
										<div class="form_input">
											<?php
											if (!empty($catList)) {

												foreach ($catList->result() as $cat) {

													echo ucfirst($cat->experience_title);
												}
											} ?>

										</div>
									</div>
								</li>


							</ul>


						</div>

					</form>

				</div><!---basic tab--->

				<div id="language" class="tabcontent" style="display: none;">
					<h3>Language</h3>
					<form id="lang_form" name="lang_form" method='post' class="form_container left_label listingInfo">
						<ul class="tab-areas1">
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_email">Languages support:</label>
									<div class="form_input">

										<?php
										if (!empty($languages_list)) {
											if ($languages_list->num_rows() > 0) {
												$j = 1;
												foreach ($languages_list->result() as $langs) {
													echo ucfirst($langs->language_name);

													if ($j != $languages_list->num_rows())
														echo ', ';

													$j++;
												}

											} else echo "Not yet Added";
										} else {
											echo "Not yet Added";
										}
										?>
									</div>
								</div>
							</li>


						</ul>
					</form>

				</div><!--lan--content---->

				<div id="organization" class="tabcontent form_container left_label listingInfo" style="display: none;">
					<h3>Tell us about the organization you represent<br>
						<!--<small>Please provide the organization . So we can verify your organization.</small>-->
						<small>If you represent to specific organization, give that organization details</small>
					</h3>

					<ul class="tab-areas1">
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="user_id">Organization name <span
										class="req">*</span></label>
								<div class="form_input">
									<?php echo $listDetail->row()->organization; ?>

								</div>
							</div>
						</li>


						<li>
							<div class="form_grid_12">
								<label class="field_title" for="user_id">About your Organization <span
										class="req">*</span></label>
								<div class="form_input">

									<?php echo $listDetail->row()->organization_des; ?>

								</div>
							</div>
						</li>

					</ul>

				</div><!--org--content---->


				<div id="exp_title" class="tabcontent form_container left_label listingInfo" style="display: none;">
					<h3>Experience Title <br>
						<small>Title displayed on your public experience page.</small>
					</h3>
					</h3>

					<ul class="tab-areas1">
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">Experience Title</label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->experience_title); ?>
								</div>
							</div>
						</li>

					</ul>

				</div><!--exptitle--content---->

				<div id="timing" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('exp_set_your_time') != '') {
							echo stripslashes($this->lang->line('exp_set_your_time'));
						} else echo "Schedule your Experience"; ?></h3>

					<p><?php if ($this->lang->line('Atitleandsummary') != '') {
							echo stripslashes($this->lang->line('Atitleandsummary'));
						} else echo "You can adjust this time depending on the dates you're scheduled to host. Each experience must be at least 1 hour."; ?> </p>

					<ul class="tab-areas">
						<li class="">
							<?php /* <label class="exp-reqlbl"><?php if($this->lang->line('experience_Schedule') != '') { echo stripslashes($this->lang->line('experience_Schedule')); } else echo "Schedule";?> <span class="req"> *</span></label><br>
									
									*/ ?>

							<div class="exp-outerpanel">


								<div class="grid_12">
									<div class="widget_wrap">


										<div class="widget_content">
											<table class="display display_tbl" id="subadmin_tbl">
												<thead>
												<tr>

													<th class="tip_top" title="Click to sort">
														From Date
													</th>
													<th class="tip_top" title="Click to sort">
														To Date
													</th>
													<th class="tip_top" title="Click to sort">
														Status
													</th>

													<th class="tip_top" title="Click to sort">
														Created On
													</th>
													<th class="tip_top" title="Click to sort">
														Action
													</th>

												</tr>
												</thead>
												<tbody>
												<?php
												if ($date_details->num_rows() > 0) {
													//print_r($experienceList->result());exit;
													foreach ($date_details->result() as $row) {


														if ($row->status != '2') {
															?>
															<tr>

																<td class="center">
																	<?php echo ucfirst($row->from_date);

																	?>
																</td>
																<td class="center">

																	<?php echo $row->to_date; ?>

																</td>

																<td class="center">
																	<?php {
																		?>
																		<span
																			class=""><?php if ($row->status == '1') echo 'Active'; else echo 'InActive'; ?></span>
																	<?php } ?>
																</td>
																<td class="center">
																	<?php echo $row->created_at; ?>
																</td>
																<td>
																			<span class=""
																				  onclick="show_details('<?php echo $row->id; ?>')"
																				  style="cursor:pointer;"><u>View Details</u>
																			</span>
																	<br>


																</td>

															</tr>


															<tr id="show_schedule_<?php echo $row->id; ?>"
																style="display:none">


																<td colspan="5">
																	<!-- Show schedules  -->

																	<table class="table table-striped">
																		<thead>
																		<tr>
																			<th>Scheduled Date</th>
																			<th>Time</th>
																			<th>Title</th>
																			<th>Description</th>
																			<th>status</th>
																		</tr>
																		</thead>
																		<tbody>


																		<?php

																		$schedList = $this->experience_model->get_all_details(EXPERIENCE_TIMING, array('exp_dates_id' => $row->id));

																		if ($schedList->num_rows() > 0) {
																			foreach ($schedList->result() as $sched) {
																				//if($sced->status!='2'){
																				?>
																				<tr>
																					<td><span
																							id='sched_start_time'> <?php echo $sched->start_time; ?>
																					</td>

																					<td><span
																							id='sched_end_time'><?php echo $sched->end_time; ?></span>
																					</td>
																					<td><span
																							id='sched_title'><?php echo $sched->title; ?></span>
																					</td>
																					<td><span
																							id='sched_description'><?php echo $sched->description; ?></span>
																					</td>
																					<td><span
																							id='sched_description'><?php if ($sched->status == '1') echo 'Active'; else echo 'Inactive'; ?></span>
																					</td>
																				</tr>
																				<?php //}
																			}
																		} else {
																			echo "Schedule Not Done.";
																		} ?>

																		</tbody>
																	</table>


																	<!-- Show schedules  -->
																</td>


															</tr>


															<?php

															?>


															<?php


														}
													}
												}
												?>
												</tbody>

											</table>
										</div>
									</div>
								</div>

							</div>

						</li>
					</ul>

				</div><!--timing--content---->


				<div id="photos" class="tabcontent form_container left_label listingInfo" style="display: none;">
					<h3 class="margin_bottom_20">Add photos for your experience

						<br>
						<small>Choose photos thae showcase the location and what guests will be doing</small>
					</h3>
					<ul class="tab-areas2">


						<li>
							<div class="widget_content">
								<?php
								//echo "<pre>";print_r($imgDetail->result_array());

								if (!empty($imgDetail->result_array())) {

									?>
									<table class="display display_tbl" id="image_tbl">
										<thead>
										<tr align="center">
											<th> Sno</th>
											<th> Image</th>

										</tr>
										</thead>
										<tbody>
										<?php

										$i = 0;
										$j = 1;
										$this->session->set_userdata(array('product_image_' . $product_details->row()->id => $product_details->row()->image));

										foreach ($imgDetail->result() as $img) {

											if ($img != '') {
												?>
												<tr id="img_<?php echo $img->id ?>">
													<td class="center tr_select "><input type="hidden" name="imaged[]"
																						 value="<?php echo $img->product_image; ?>"/>
														<?php echo $j; ?> </td>
													<td class="center "><img
															src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "images/experience/" . $img->product_image; ?>"
															height="80px" width="80px"/></td>

												</tr>
												<?php
												$j++;
											}
											$i++;
										}

										?>
										</tbody>
										<tfoot>
										<tr align="center">
											<th> Sno</th>
											<th> Image</th>

										</tr>
										</tfoot>

									</table>
								<?php } else { ?>
									No Photos uploaded.
								<?php } ?>
							</div>
						</li>

						<li>

							<div class="form_grid_12">
								<label class="field_title"><?php if ($this->lang->line('Video URL') != '') {
										echo stripslashes($this->lang->line('Video URL'));
									} else echo "Video URL"; ?></label>

								<div class="form_input">
									<?php echo $listDetail->row()->video_url; ?>
								</div>
							</div>


						</li>

					</ul>

				</div><!--exptitle--content---->


				<div id="what_we_do" class="tabcontent form_container left_label listingInfo" style="display: none;">
					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Mention what you'll do"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Describe in detail what you'll be doing with your guests. The more information you can give, the better."; ?> </p>

					<ul class="tab-areas1">
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">What you'll do</label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->experience_description); ?>
								</div>
							</div>
						</li>

					</ul>

				</div><!--do--content---->

				<div id="where_will_be" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Mention where you'll be"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Name all the locations you'll visit. Give guests a glimpse of why they're meaningful."; ?> </p>

					<ul class="tab-areas1">
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">Mention where you'll be</label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->location_description); ?>
								</div>
							</div>
						</li>

					</ul>

				</div><!--be--content---->

				<div id="where_will_meet" class="tabcontent form_container left_label listingInfo"
					 style="display: none;">

					<h3><?php if ($this->lang->line('Address') != '') {
							echo stripslashes($this->lang->line('Address'));
						} else echo "Address"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Let guests know exactly where you'll be meeting. The exact address wont't be shared with guests untill the book."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="country">Country:</label>
								<div class="form_input">

									<?php echo ucfirst($product_details->row()->country); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="state">State:</label>
								<div class="form_input" id="listCountryCnt">

									<?php echo ucfirst($product_details->row()->state); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="city">City:</label>
								<div class="form_input" id="listStateCnt">

									<?php echo ucfirst($product_details->row()->city); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="post_code">ZIP CODE :</label>
								<div class="form_input">
									<?php echo trim(stripslashes($product_details->row()->zip)); ?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="address">Apt, Suite, Bldg.(optional)</label>
								<div class="form_input">
									<?php
									if ($product_details->row()->apt != '') {
										echo trim(stripslashes($product_details->row()->apt));
									} else {
										echo 'Not available';
									}
									?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="address">Address</label>
								<div class="form_input">
									<?php echo trim(stripslashes($product_details->row()->address)); ?>
								</div>
							</div>
						</li>

					</ul>

				</div><!--loc--content---->

				<div id="where_will_meet" class="tabcontent form_container left_label listingInfo"
					 style="display: none;">

					<h3><?php if ($this->lang->line('Address') != '') {
							echo stripslashes($this->lang->line('Address'));
						} else echo "Address"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Let guests know exactly where you'll be meeting. The exact address wont't be shared with guests untill the book."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="country">Country:</label>
								<div class="form_input">

									<?php echo ucfirst($product_details->row()->country); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="state">State:</label>
								<div class="form_input" id="listCountryCnt">

									<?php echo ucfirst($product_details->row()->state); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="city">City:</label>
								<div class="form_input" id="listStateCnt">

									<?php echo ucfirst($product_details->row()->city); ?>

								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="post_code">ZIP CODE :</label>
								<div class="form_input">
									<?php echo trim(stripslashes($product_details->row()->zip)); ?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="address">Apt, Suite, Bldg.(optional)</label>
								<div class="form_input">
									<?php
									if ($product_details->row()->apt != '') {
										echo trim(stripslashes($product_details->row()->apt));
									} else {
										echo 'Not available';
									}
									?>
								</div>
							</div>
						</li>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="address">Address</label>
								<div class="form_input">
									<?php echo trim(stripslashes($product_details->row()->address)); ?>
								</div>
							</div>
						</li>

					</ul>

				</div><!--loc--content---->

				<div id="what_you_will_provide" class="tabcontent form_container left_label listingInfo"
					 style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Confirm what you'll provide"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "On this page, you can ass additional details about what you are providing. For example, you can let your guests know that you accomodate vegetarians.."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<div class="widget_wrap">
									<?php if ($guide_provides->num_rows() > 0) { ?>
										<table class="display display_tbl">
											<thead>
											<tr>
												<th>S.No.</th>
												<th>Title</th>
												<th>Detailed Title</th>
												<th>Quantity</th>
												<th>Description</th>
											</tr>
											</thead>
											<tbody>

											<?php
											$i = 1;
											foreach ($guide_provides->result() as $kit) {
												?>

												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $kit->kit_title; ?></td>
													<td><?php echo $kit->kit_detailed_title; ?></td>
													<td><?php if ($kit->kit_count > 0) echo $kit->kit_count; else echo '-'; ?></td>
													<td><?php echo $kit->kit_description; ?></td>
												</tr>

												<?php
												$i++;
											}
											?>
											</tbody>
										</table>
										<?php


									} else echo "Not yet Added";
									?>
								</div>
							</div>
						</li>


					</ul>

				</div><!--loc--content---->

				<div id="notes" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "What else should guests know?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Mention anything that guests will have to bring eith them or arrange on their own, like transportation."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">Add notes</label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->note_to_guest); ?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="about_you" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "What else should guests know?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Mention anything that guests will have to bring eith them or arrange on their own, like transportation."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">About Host </label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->about_host); ?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="guest_req" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Have any guest requirements?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Mention anything that guests will have to bring eith them or arrange on their own, like transportation."; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">Guest requirements</label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->guest_requirement); ?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="group_size" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Maximum number of guests?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "What's the number of guests you can accommodate?"; ?> </p>

					<ul>
						<li>
							<div class="form_grid_12">
								<label class="field_title" for="confirm_email">Group size </label>
								<div class="form_input">
									<?php echo ucfirst($product_details->row()->group_size); ?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="price_content" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Set a price per guest"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "The price of your experience is entirely up to you. Play with the calculator to see how much you'd earn depending on the number of guests."; ?> </p>

					<ul>

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="price">Price per person </label>
								<div class="form_input">
									<?php
									if ($product_details->row()->price != '') {
										echo $product_details->row()->price . "  " . $product_details->row()->currency;
									} else {
										echo 'Not available';
									}
									?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="price_content" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Set a price per guest"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "The price of your experience is entirely up to you. Play with the calculator to see how much you'd earn depending on the number of guests."; ?> </p>

					<ul>

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="price">Price per person </label>
								<div class="form_input">
									<?php
									if ($product_details->row()->price != '') {
										echo $product_details->row()->price . "  " . $product_details->row()->currency;
									} else {
										echo 'Not available';
									}
									?>
								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="cancel_policy" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Cancellation Policy"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Cancel policy support to experiences."; ?> </p>

					<ul>

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="price">Cancellation Policy</label>
								<div class="form_input">
									<select class="gends" name="cancel_policy" id="cancel_policy_1">

										<option value="Flexible" <?php if (!empty($listDetail)) {
											if ($listDetail->row()->cancel_policy == 'Flexible') {
												echo 'selected="selected"';
											}
										} ?>>Flexible
										</option>
										<option value="Moderate" <?php if (!empty($listDetail)) {
											if ($listDetail->row()->cancel_policy == 'Moderate') {
												echo 'selected="selected"';
											}
										} ?>>Moderate
										</option>
										<option value="Strict" <?php if (!empty($listDetail)) {
											if ($listDetail->row()->cancel_policy == 'Strict') {
												echo 'selected="selected"';
											}
										} ?>>Strict
										</option>
									</select>

								</div>
							</div>
						</li>

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="price">Security Deposit</label>
								<div class="form_input">


									<?php echo $product_details->row()->security_deposit . "  " . $product_details->row()->currency; ?>

								</div>
							</div>
						</li>
					</ul>

				</div><!--loc--content---->

				<div id="tagline" class="tabcontent form_container left_label listingInfo" style="display: none;">

					<h3>Write a tagline <br>
						<small>Clearly describe your in one short,catchy sentence. Start with a verb that tells guests
							what they will do.
						</small>
					</h3>

					<ul>

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="price">Write your tagline here</label>
								<div class="form_input">
									<?php echo $product_details->row()->exp_tagline; ?>

								</div>
							</div>
						</li>

					</ul>

				</div><!--loc--content---->


				<!----new---tab---->


				<script>
					function openContent(evt, div_id, obj) {

						var i, tabcontent, tablinks;
						tabcontent = document.getElementsByClassName("tabcontent");
						for (i = 0; i < tabcontent.length; i++) {
							tabcontent[i].style.display = "none";
						}
						tablinks = document.getElementsByClassName("tablinks");
						for (i = 0; i < tablinks.length; i++) {
							tablinks[i].className = tablinks[i].className.replace(" active", "");
						}
						evt.currentTarget.className += " active";

						document.getElementById(div_id).style.display = "block";
						/*tab_id=obj.id;
                        ur=window.location.href.split('#')[0]
                        newHREF=ur+'#'+tab_id;
                        history.pushState('', 'Experience', newHREF);

                        */
					}
				</script>

			</div>
		</div>
		<span class="clear"></span>
	</div>
	</div>

	<script>
		function show_details(id) {
			$('#show_schedule_' + id).toggle();
			return false;
		}
	</script>


<?php
$this->load->view('admin/templates/footer.php');
?>
