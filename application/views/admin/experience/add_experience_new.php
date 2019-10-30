<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<link rel="stylesheet" href="<?php echo base_url();?>css/localize/bootstrap-3.37.min.css">
	<script src="<?php echo base_url();?>css/localize/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url();?>css/localize/bootstrap-3.3.7.min.js"></script>

<link rel="stylesheet" media="all" href="<?php echo base_url(); ?>css/font-awesome.css" type="text/css"/>

<?php
error_reporting(1);

$imageUpload = $this->uri->segment(5, 0);
$this->load->view('admin/templates/header.php');
?>
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
		width: 80%;
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
	.ui-datepicker select.ui-datepicker-month, .ui-datepicker select.ui-datepicker-year{color: #444;}


    .modal-backdrop {
        z-index: 1040 !important;
        position: inherit;
    }
    .modal-dialog {
        z-index: 1100 !important;
    }
</style>

<!---- for location ---->
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<?php
if (!empty($product_details)) {
	$address = trim(stripslashes($product_details->row()->address));
	$lat = $product_details->row()->latitude;
	$long = $product_details->row()->longitude;

} else {
	$address = "";
	$lat = '';
	$long = '';
}
$street = '';
$street1 = '';
$area = '';
$location = '';
$city = '';
$state = '';
$country = '';

$zip = '';
$address = str_replace(" ", "+", $address);
$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
$json = json_decode($json);
//echo '<pre>';print_r($json);die;
$newAddress = $json->{'results'}[0]->{'address_components'};
foreach ($newAddress as $nA) {
	if ($nA->{'types'}[0] == 'route') $street = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'sublocality_level_2') $street1 = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'sublocality_level_1') $area = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'locality') $location = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'administrative_area_level_2') $city = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'administrative_area_level_1') $state = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'country') $country = $nA->{'long_name'};
	if ($nA->{'types'}[0] == 'postal_code') $zip = $nA->{'long_name'};
}
if ($city == '')
	$city = $location;

$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

?>
<?php
$bedrooms = "";
$beds = "";
$bedtype = "";
$bathrooms = "";
$noofbathrooms = "";
$min_stay = "";
$accommodates = "";
$can_policy = "";


?>
<?php if ($lat != '' && $lang != '') { ?>
	<script>
		var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
		// var myLatlng;

		var citymap = {};

		function initializeMapCircle() {


			var cityCircle;

			var mapOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.TERRAIN
			};


			var map = new google.maps.Map(document.getElementById('map-new'),
				mapOptions);

			var marker = new google.maps.Marker({
				position: myLatlng,
				draggable: true,
				map: map
			});

			google.maps.event.addListener(marker, 'dragend', function () {
				var newLatitude = this.position.lat();
				var newLongitude = this.position.lng();

				var pos = marker.getPosition();

				geocoder = new google.maps.Geocoder();
				geocoder = new google.maps.Geocoder();
				geocoder.geocode
				({
						latLng: pos
					},
					function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							var address = results[0].formatted_address;
							$("#address_location").val(address);
							$.ajax({
								type: 'post',
								url: baseURL + 'site/experience/get_location',
								dataType: 'json',
								data: {address: address},
								success: function (json) {
									alert(json);
									var street = json.street;
									var area = json.area;


									$("#apt").val(street + ' ' + area);
									var location = json.location;
									$("#autocomplete-admin").val(location);
									var city = json.city;
									$("#city").val(city);
									var state = json.state;
									$("#state").val(state);
									var country = json.country;
									$("#country").val(country);

									$.ajax({
										type: 'POST',
										url: '<?php echo base_url()?>site/experience/save_lat_lng',
										data: {
											latitude: newLatitude,
											longitude: newLongitude,
											area: area,
											street: street,
											location: location,
											address: address,
											city: city,
											state: state,
											country: country,
											experience_id: '<?php echo $listDetail->row()->id; ?>'
										},
										success: function (response) {
										},
										error: function (request, status, error) {
										}
									});
								},
								complete: function () {

								}
							});


						}
						else {
							console.log('Cannot determine address at this location.');
						}
					}
				);
			});


			for (var city in citymap) {
				var populationOptions = {
					strokeColor: '#FF0000',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#FF0000',
					fillOpacity: 0.35,
					map: map,
					center: citymap[city].center,
					radius: Math.sqrt(citymap[city].population) * 100
				};

				cityCircle = new google.maps.Circle(populationOptions);
			}
		}

	</script>
<?php } else { ?>
	<script>
		var myLatlng = new google.maps.LatLng(32, 72);


		var citymap = {};

		function initializeMapCircle() {


			var cityCircle;

			var mapOptions = {
				zoom: 12,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.TERRAIN
			};


			var map = new google.maps.Map(document.getElementById('map-new'),
				mapOptions);

			var marker = new google.maps.Marker({
				position: myLatlng,
				draggable: true,
				map: map
			});

			google.maps.event.addListener(marker, 'dragend', function () {
				var newLatitude = this.position.lat();
				var newLongitude = this.position.lng();

				$("#latitude").val(newLatitude);
				$("#longitude").val(longitude);

				var pos = marker.getPosition();

				geocoder = new google.maps.Geocoder();
				geocoder = new google.maps.Geocoder();
				geocoder.geocode
				({
						latLng: pos
					},
					function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							var address = results[0].formatted_address;
							$("#address_location").val(address);
							$.ajax({
								type: 'post',
								url: baseURL + 'site/experience/get_location',
								dataType: 'json',
								data: {address: address},
								success: function (json) {

									var street = json.street;
									var area = json.area;
									$("#apt").val(street + ' ' + area);

									var location = json.location;
									$("#autocomplete-admin").val(location);
									var city = json.city;
									$("#city").val(city);
									var state = json.state;
									$("#state").val(state);
									var country = json.country;
									$("#country").val(country);
									$.ajax({
										type: 'POST',
										url: '<?php echo base_url()?>site/experience/save_lat_lng',
										data: {
											latitude: newLatitude,
											longitude: newLongitude,
											area: area,
											street: street,
											location: location,
											address: address,
											city: city,
											state: state,
											country: country
										},
										success: function (response) {
										},
										error: function (request, status, error) {
										}
									});
								},
								complete: function () {

								}
							});


						}
						else {
							console.log('Cannot determine address at this location.');
						}
					}
				);
			});


			for (var city in citymap) {
				var populationOptions = {
					strokeColor: '#FF0000',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#FF0000',
					fillOpacity: 0.35,
					map: map,
					center: citymap[city].center,
					radius: Math.sqrt(citymap[city].population) * 100
				};

				cityCircle = new google.maps.Circle(populationOptions);
			}
		}

	</script>
<?php } ?>


<div id="content">
	<div class="grid_container">
		<div class="grid_12 margin_top_20">

			<input type="hidden" name="experience_id" id="experience_id" value="<?php echo $id; ?>">
			<!---vertical tab-->
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
						onclick="openContent(event, 'what_we_do',this)" id="what_we_do_tab">What you will
					do<?php echo ($what_we_do == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

				<button class="tablinks <?php echo ($where_will_be == 0) ? 'disabled_exp' : ''; ?>"
						onclick="openContent(event, 'where_will_be',this)" id="where_will_be_tab">Where you will
					be<?php echo ($where_will_be == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

				<button class="tablinks <?php echo ($where_will_meet == 0) ? 'disabled_exp' : ''; ?>"
						onclick="openContent(event, 'where_will_meet',this)" id="where_will_meet_tab">Where we'll
					meet<?php echo ($where_will_meet == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>

				<button class="tablinks <?php echo ($what_will_provide == 0) ? 'disabled_exp' : ''; ?>"
						onclick="openContent(event, 'what_you_will_provide',this)" id="what_you_will_provide_tab">What
					you'll
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

				<button class="tablinks <?php echo ($seo == 0) ? 'disabled_exp' : ''; ?>"
						onclick="openContent(event, 'seo',this)" id="seo_tab">
					SEO<?php echo ($seo == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?></button>
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

										<?php if ($id != '' && $id != 0) { ?>
											<input type="hidden" name="org_current_user_id" id="org_current_user_id"
												   value="<?php echo $product_details->row()->OwnerId; ?>">
										<?php } ?>


										<?php
										if (!empty($userdetails)) {
											echo '<select name="user_id" id="current_user_id">';
											?>
											<option value="">--Select--</option>
											<?php
											foreach ($userdetails->result() as $user_details) {


												?>

												<option
													value="<?php echo $user_details->id; ?>" <?php if (!empty($product_details)) {
													if ($user_details->id == $product_details->row()->OwnerId) {
														echo 'selected="selected"';
													}
												} ?>><?php echo ucfirst($user_details->firstname) . ' ' . ucfirst($user_details->lastname) . '----' . $user_details->email; ?></option>

												<?php
											}
											echo '</select>';
										} ?>

										<span id="owner_update" style="color:green"></span>
									</div>
								</div>
							</li>


							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Experience Type <span class="req">*</span></label>
									<div class="form_input">


										<?php
										$exp_type = $listDetail->row()->exp_type;
										$disab = '';
										$reaOnly = '';
										if ($exp_type != '') {
											$disab = 'disabled="true"';
											$reaOnly = "readOnly";
										}
										?>

										<div class="select margin_bottom_20">
											<select name="experience_type" id="experience_type" class=""
													onchange="change_date_or_time(this.value)" <?php echo $disab; ?> >
												<option value="">--Select--</option>
												<option value="1" <?php echo ($exp_type == 1) ? "selected" : ""; ?>>
													Immersions
												</option>
												<option value="2" <?php echo ($exp_type == 2) ? "selected" : ""; ?>>
													Experiences
												</option>
											</select>
										</div>

									</div>
								</div>
							</li>

							<?php
							if ($listDetail->row()->exp_type == 1) {
								$sty = "block;";
							} else {
								$sty = "none;";
							}
							?>

							<li style="display:<?php echo $sty; ?>" class="date_count_div">
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Number of days <span
											class="req">*</span></label>
									<div class="form_input">
										<div id="days_error" style="color:red"></div>
										<input name="total_count_date" onchange="change_min(this.value, 2)"
											   id="total_count_date" type="text" class="exp_input number_field"
											   value="<?php echo $listDetail->row()->date_count; ?>" <?php echo $reaOnly; ?>>

									</div>
								</div>
							</li>
							<?php

							if ($listDetail->row()->exp_type == 1) {
								$st = "none;";
							} else {
								$st = "block;";
							}
							?>
							<li style="display:<?php echo $st; ?>" class="hour_count_div">
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Total Hours <span
											class="req">*</span></label>
									<div class="form_input">
										<input name="total_count_time" onkeyup="hourValidation();" id="total_count_time"
											   type="text" class="exp_input number_field"
											   value="<?php echo $listDetail->row()->total_hours; ?>" <?php echo $reaOnly; ?>>
										<span id="entered_hour_err" style="color:green"></span>

									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Experience Category <span
											class="req">*</span></label>
									<input type="hidden" id="org_type_id" name="org_type_id"
										   value="<?php echo $listDetail->row()->type_id; ?>">
									<div class="form_input">
										<div class="select">
											<select name="type_id" id="type_id">
												<option value=""><?php if ($this->lang->line('select') != '') {
														echo stripslashes($this->lang->line('select'));
													} else echo "Select"; ?></option>
												<?php
												foreach ($experienceTypeList->result() as $type) { ?>
													<option
														value="<?php echo $type->id; ?>" <?php if (trim($type->id) == trim($listDetail->row()->type_id)) echo 'selected="selected"'; ?> ><?php echo ucfirst($type->experience_title); ?></option>
													<?php
												}
												?>
											</select>
											<span id="cat_update" style="color:green"></span>
											<input type="hidden" id="id" name="id"
												   value="<?php echo $listDetail->row()->id; ?>"/>

										</div>
									</div>
								</div>
							</li>

							<li>


								<?php
								if (!isset($exp_type)) {
									if ($exp_type == '') {
										?>
										<div class="basic-next">
											<button class="btn btn-success" type="button"
													onclick="validate_form_basic(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
													echo stripslashes($this->lang->line('Save_and_Continue'));
												} else echo "Save & Continue"; ?></button>
										</div>
										<?php
									}
								} else {
									//echo $id;
									if ($id != 0) {
										?>
										<div class="basic-next">
											<button class="btn btn-success" type="button"
													onclick="next_form(event,'language_tab')"><?php if ($this->lang->line('Continue') != '') {
													echo stripslashes($this->lang->line('Continue'));
												} else echo "Continue"; ?></button>
										</div>
										<?php
									}
								}
								?>

							</li>

						</ul>


					</div>

				</form>

			</div>
			<script>

				function isNumber(evt) {
					evt = (evt) ? evt : window.event;
					var charCode = (evt.which) ? evt.which : evt.keyCode;
					if (charCode > 31 && (charCode < 48 || charCode > 57)) {
						return false;
					}
					return true;
				}

				/** to Avoide hour entereing more then 24**/
				function hourValidation() {
					var entered_hour = $("#total_count_time").val();
					if (entered_hour > 24) {
						$("#entered_hour_err").html('Total hours Shoule be below 24');
						$("#total_count_time").val('');
						$('#entered_hour_err').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#entered_hour_err').html('');
							});
						});
					}
				}


				function change_date_or_time(type) {
					if (type == 2) {
						$('.date_count_div').hide();
						$('#total_count_date').val('');
						$('.hour_count_div').show();
					} else {
						$('.date_count_div').show();
						$('.hour_count_div').hide();

					}
				}

				function validate_form_basic(e) {

					experience_type = $('#experience_type').val();
					type_id = $('#type_id').val();
					current_user_id = $('#current_user_id').val();
					err = 0;
					if (experience_type != '') {
						if (experience_type == 2) {
							count = $('#total_count_time').val();
						} else {
							count = $('#total_count_date').val();
							if (count < 2) {
								$('#days_error').html('Number of Days should be atleast 2..!');
								return false;

							} else {
								$('#days_error').html('');
							}
						}
						if (count == '') {
							err = 1;

						}
					} else {
						err = 1;
					}

					if (type_id == '' || current_user_id == '') {
						err = 1;
					}

					if (err == 1) {
						//$('.error').show();
						$('#error_basic').fadeIn('slow', function () {
							$(this).delay(5000).fadeOut('slow');
						});
						return false;
					} else {
						//return false; 

						url_str = '<?php echo base_url() . "admin/experience/add_experience_new";?>';

						$.ajax({
							type: 'POST',
							url: url_str,
							data: $('#basic_form').serialize(),
							dataType: 'json',
							success: function (data) {
								if (data.status == 1) {
									exp_id = data.id;
									window.location.href = '<?php echo base_url() . "admin/experience/add_experience_form_new/";?>' + exp_id + '#language_tab';
									$("#language_tab").removeClass("disabled_exp");
									document.getElementById("language_tab").click();
								} else {
									$('#error_basic').html('Experience is not submitted. Pealse try again');
									$('#error_basic').fadeIn('slow', function () {
										$(this).delay(5000).fadeOut('slow');
									});
									return false;
								}
							}
						});

					}
				}


				$(function () {

					experience_id = $('#experience_id').val();
					$(document).on('change', '#type_id', function () {
						//alert(experience_id);
						if (experience_id != '' && experience_id != 0) {
							UpdateExp_Category();
						}
					});
					$(document).on('change', '#current_user_id', function () {
						//alert(experience_id);
						if (experience_id != '' && experience_id != 0) {
							UpdateExp_Owner();
						}
					});
				});


				function UpdateExp_Owner() {
					var user_id = $("#current_user_id").val();
					var exp_id = $("#experience_id").val();

					if (user_id != '' && exp_id != '') {
						$.ajax({
							type: 'POST',
							data: {'user_id': user_id, 'exp_id': exp_id},
							url: 'admin/experience/UpdateExp_Owner',
							success: function (data) {
								data = data.trim();
								if (data == 'success') {
									$("#owner_update").html('Experience Category is Updated..!');
									$('#owner_update').fadeIn('slow', function () {
										$(this).delay(1000).fadeOut('slow', function () {
											$('#owner_update').html('');
										});
									});
								} else {
									org_current_user_id = $("#org_current_user_id").val();
									$("#current_user_id").val(org_current_user_id);
									$("#owner_update").html('<span style="color: red;">Sorry,Booking happend on this experience!</span>');
									$('#owner_update').fadeIn('slow', function () {
										$(this).delay(1000).fadeOut('slow', function () {
											$('#owner_update').html('');
										});
									});
								}
							}
						});
					} else {
						$("#owner_update").html('<span style="color: red;">Please Choose user..!</span>');
						$('#owner_update').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#owner_update').html('');
							});
						});
					}

				}

				function UpdateExp_Category() {
					var category = $("#type_id").val();
					var exp_id = $("#experience_id").val();

					if (category != '' && exp_id != '') {
						$.ajax({
							type: 'POST',
							data: {'category_id': category, 'exp_id': exp_id},
							url: 'admin/experience/UpdateExp_Category',
							success: function (data) {
								data = data.trim();
								if (data == 'success') {
									$("#cat_update").html('Experience Category is Updated..!');
									$('#cat_update').fadeIn('slow', function () {
										$(this).delay(1000).fadeOut('slow', function () {
											$('#cat_update').html('');
										});
									});
								} else {
									org_type_id = $("#org_type_id").val();
									$("#type_id").val(org_type_id);
									$("#cat_update").html('<span style="color: red;">Sorry,Booking happend on this experience!</span>');
									$('#cat_update').fadeIn('slow', function () {
										$(this).delay(1000).fadeOut('slow', function () {
											$('#cat_update').html('');
										});
									});
								}
							}
						});
					} else {
						$("#cat_update").html('<span style="color: red;">Please Choose Category..!</span>');
						$('#cat_update').fadeIn('slow', function () {
							$(this).delay(1000).fadeOut('slow', function () {
								$('#cat_update').html('');
							});
						});
					}

				}


			</script>

			<?php
			if ($id != '' && $id != '0') { ?>

				<div id="language" class="tabcontent">
					<h3>Language
						<br>
						<small>What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language.
						</small>
					</h3>

					<form id="lang_form" name="lang_form" method='post' class="form_container left_label listingInfo">
						<ul class="tab-areas1">
							<li>


								<div class="exp-admin-lang">
									<?php
									$languages_known_user = explode(',', $product_details->row()->language_list);
									if (count($languages_known_user) > 0) { ?>
										<ul class="inner_language">
											<?php
											foreach ($languages_known->result() as $language) {
												if (in_array($language->language_code, $languages_known_user)) { ?>
													<li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name; ?>
														<small>
															<span class="text-normal remove cursor_pointer"
																  href="javascript:void(0);"
																  onclick="delete_languages(this,'<?php echo $language->language_code; ?>')"> <i
																	class="fa fa-times" aria-hidden="true"></i></span>
														</small>
													</li>
												<?php }
											} ?>


										</ul>
									<?php } ?>

                        <span class="no-numbr">


                        <ul>
                            <?php if ($product_details->row()->language_list == '') { ?>
								<li><?php if ($this->lang->line('None') != '') {
										echo stripslashes($this->lang->line('None'));
									} else echo "None"; ?> </li>
							<?php } ?>
							<li> <span
									style="width:100%; padding-right: 10px;"><?php if ($this->lang->line('Addlanguages') != '') {
										echo stripslashes($this->lang->line('Addlanguages'));
									} else echo "Add languages you speak."; ?></span> <a data-toggle="modal"
																						 href="#myModal"
																						 class="multiselect-add-more btn_small"><i
										class="fa fa-plus"></i> <?php if ($this->lang->line('AddMore') != '') {
										echo stripslashes($this->lang->line('AddMore'));
									} else echo "Add More"; ?></a></li>

                        </ul>


                        </span>
                        <?php
								if ($id != 0) {
									?>
									<div class="lang-next" style="float: left;">
										<button class="btn btn-success" id="lang_btn" type="button"
												onclick="next_form(event,'organization_tab')"><?php if ($this->lang->line('Continue') != '') {
												echo stripslashes($this->lang->line('Continue'));
											} else echo "Continue"; ?></button>
									</div>
									<?php
								}
								?>
									<!-- <?php
									$languages_known_user = explode(',', $product_details->row()->language_list);
									if (count($languages_known_user) > 0) { ?>
										<ul class="inner_language">
											<?php
											foreach ($languages_known->result() as $language) {
												if (in_array($language->language_code, $languages_known_user)) { ?>
													<li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name; ?>
														<small>
															<span class="text-normal remove cursor_pointer"
																  href="javascript:void(0);"
																  onclick="delete_languages(this,'<?php echo $language->language_code; ?>')"> <i
																	class="fa fa-times" aria-hidden="true"></i></span>
														</small>
													</li>
												<?php }
											} ?>


										</ul>
									<?php } ?> -->


								</div>
								
							</li>

						</ul>
					</form>

					<!-- Modal -->
					<div id="myModal" class="modal fade" role="dialog">
						<div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">

									<h4 class="modal-title">
										<a class="close" data-dismiss="modal" type="button"><i class="fa fa-times"
																							   aria-hidden="true"></i>
										</a>
										<?php if ($this->lang->line('SpokenLanguages') != '') {
											echo stripslashes($this->lang->line('SpokenLanguages'));
										} else echo "Spoken Languages"; ?>
									</h4>
								</div>
								<div class="modal-body">

									<div class="panel-body">
										<p><?php if ($this->lang->line('Whatlanguages') != '') {
												echo stripslashes($this->lang->line('Whatlanguages'));
											} else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language."; ?></p>
										<div class="row-fluid row">
											<div class="span6 col-6">
												<?php $languages_knowns = explode(',', $product_details->row()->language_list); ?>
												<?php $i = 1;
												foreach ($languages_known->result() as $language) {
													if ($i % 2 == 1) { ?>
														<ul>
															<li>
																<input
																	type="checkbox" <?php if (in_array($language->language_code, $languages_knowns)) { ?> checked="checked" <?php } ?>
																	name="languages[]"
																	value="<?php echo $language->language_code; ?>"
																	alt="<?php echo $language->language_name; ?>">
																<label><?php echo $language->language_name; ?></label>
															</li>
														</ul>
													<?php }
													$i++;
												} ?>
											</div>
											<div class="span6 col-6">
												<?php $languages_knowns = explode(',', $product_details->row()->language_list); ?>
												<?php $i = 1;
												foreach ($languages_known->result() as $language) {
													if ($i % 2 == 0) { ?>
														<ul>
															<li>
																<input
																	type="checkbox" <?php if (in_array($language->language_code, $languages_knowns)) { ?> checked="checked" <?php } ?>
																	name="languages[]"
																	value="<?php echo $language->language_code ?>"
																	alt="<?php echo $language->language_name ?>">
																<label><?php echo $language->language_name ?></label>
															</li>
														</ul>
													<?php }
													$i++;
												} ?>
											</div>
										</div>
									</div>
									<div class="panel-footer language-popup exp-button">

										<button class="btn btn-primary" data-dismiss="modal" type="button"
												id="language_ajax"> <?php if ($this->lang->line('Save') != '') {
												echo stripslashes($this->lang->line('Save'));
											} else echo "Save"; ?> </button>
										<a class="btn btn-default" data-dismiss="modal"
										   type="button"><?php if ($this->lang->line('Close') != '') {
												echo stripslashes($this->lang->line('Close'));
											} else echo "Close"; ?></a>

									</div>


								</div>
							</div>

						</div>
					</div>
					<!--modal-ends-->
				</div>
				<!--language-content-->

				<script type="text/javascript">


					$(function () {
						lan_count = $(".inner_language li").length;
						if (lan_count == 0) {
							$('#lang_btn').hide();
						} else {
							$('#lang_btn').show();
						}
						$('#language_ajax').click(function () {

							var languages = document.getElementsByName('languages[]');
							var expID = $("#experience_id").val();
							var languages_known = new Array();
							for (var i = 0; i < languages.length; i++) {
								if ($(languages[i]).is(':checked')) {
									languages_known.push(languages[i].value);
								}
							}

							if (languages_known.length > 0) {

								$('#lang_btn').show();
								$.ajax({
									type: 'POST',
									url: '<?php echo base_url()?>site/experience/update_languages',
									data: {languages_known: languages_known, experience_id: expID},
									success: function (response) {
										$('.inner_language').html(response.trim());

										window.location.reload();
									}
								});

							} else {
								$('#lang_btn').hide();
							}
						})
					});

					function reset_check_boxes() {
						var languages = document.getElementsByName('languages[]');

						$('#myModal').find('input:checkbox').prop('checked', false);
					}

					function delete_languages(elem, language_code) {


						lan_count = $(".inner_language li").length;
						if (lan_count == 1) {
							alert('Please choose atleast one language');
							return false;
						}
						var expID = $("#experience_id").val();
						$.ajax({
							type: 'POST',
							url: '<?php echo base_url()?>site/experience/delete_languages',
							data: {language_code: language_code, experience_id: expID},
							dataType: 'json',
							success: function (response) {

								if (response['status_code'] == 1) {
									$(elem).closest('li').remove();

									lan_count = $(".inner_language li").length;
									if (lan_count == 0) {
										$('#lang_btn').hide();
									} else {
										$('#lang_btn').show();
									}

								}
							}
						});
					}

					function reset_reload() {
						window.location.reload();
					}

				</script>

				<div id="organization" class="tabcontent">
					<h3>Tell us about the organization you represent<br>
						<!--<small>You will write your descriptions in this language and guests will expect you to speak it
							during experiences.
						</small>-->
						<small>If you represent to specific organization, give that organization details</small>
					</h3>

					<form id="organization_form" name="organization_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<div class="dashboard_price_right">
							<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_org">
								<small> * Please fill all mandatory fields</small>
							</span>
							</div>

							<ul>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Organization name <span
												class="req">*</span></label>
										<div class="form_input">
											<input name="organization" id="organization_in" type="text" class="exp_input"   value="<?php echo $listDetail->row()->organization; ?>"
												   maxlength="20" onkeyup="char_count(this)">

											<?php
											$string = str_replace(' ', '', $listDetail->row()->organization);
											$len = mb_strlen($string, 'utf8');
											$remaining = (20 - $len);
											?>
											<span class="small_label"><span
													id="organization_in_char_count"><?php echo $remaining; ?></span> characters remaining</span>

										</div>
									</div>
								</li>


								


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">About your Organization <span
												class="req">*</span></label>
										<div class="form_input">

											<textarea name="organization_des" maxlength="250" id="organization_des"
													  type="text" class="exp_input"
													  placeholder="About your organization"
													  onkeyup="char_count(this)"><?php echo $listDetail->row()->organization_des; ?></textarea>

											<?php
											$string = str_replace(' ', '', $listDetail->row()->organization_des);
											$len = mb_strlen($string, 'utf8');
											$remaining = (250 - $len);
											?>
											<span class="small_label"><span
													id="organization_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>


										</div>
									</div>
								</li>

								  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>


								<li>
									<div class="form_grid_12">
										<?php  //foreach(language_dynamic_enable("organization", "") as $dynlang) { ?>
										<label class="field_title" for="user_id">Organization name (<?php echo $data->name; ?>) <span
												class="req">*</span></label>
										<div class="form_input">
											<input name="<?php echo 'organization_'.$data->lang_code; ?>" id="<?php echo 'organization_'.$data->lang_code; ?>" type="text" class="exp_input"   value="<?php echo $listDetail->row()->{'organization_'.$data->lang_code}; ?>"
												   maxlength="20" onkeyup="char_count(this)">

											<?php
											$string = str_replace(' ', '', $listDetail->row()->{'organization_'.$data->lang_code});
											$len = mb_strlen($string, 'utf8');
											$remaining = (20 - $len);
											?>
											<span class="small_label"><span
													id="organization_in_char_count"><?php echo $remaining; ?></span> characters remaining</span>

										</div>
									<?php// } ?>
									</div>
								</li>
									<li>
									<div class="form_grid_12">
										<?php // foreach(language_dynamic_enable("organization_des", "") as $dynlang) { ?>
										<label class="field_title" for="user_id">About your Organization (<?php echo $data->name; ?>) <span
												class="req">*</span></label>
										<div class="form_input">

											<textarea name="<?php echo 'organization_des_'.$data->lang_code;?>" maxlength="250" id="<?php echo 'organization_des_'.$data->lang_code; ?>"
													  type="text" class="exp_input"
													  placeholder="About your organization in <?php echo $data->name; ?>"
													  onkeyup="char_count(this)"><?php echo $listDetail->row()->{'organization_des_'.$data->lang_code}; ?></textarea>

											<?php
											$string = str_replace(' ', '', $listDetail->row()->{'organization_des_'.$data->lang_code});
											$len = mb_strlen($string, 'utf8');
											$remaining = (250 - $len);
											?>
											<span class="small_label"><span
													id="organization_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>
										</div>
									<?php //} ?>
									</div>
								</li>
<?php }} ?>
								<li>

									<div class="exp-pic">

										<button type="button" class="btn btn-default"
												onclick="next_form(event,'experience_title_tab')"><?php if ($this->lang->line('Skip') != '') {
												echo stripslashes($this->lang->line('Skip'));
											} else echo "Skip"; ?></button>

										<button class="btn btn-success" type="button"
												onclick="validate_form_organization(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
												echo stripslashes($this->lang->line('Save_and_Continue'));
											} else echo "Save & Continue"; ?></button>

									</div>

								</li>

							</ul>

						</div>


					</form>

				</div>
				<!---organization content-->


				<script>
					function validate_form_organization(e) {
						$('.loading').show();
						organization = $('#organization_in').val();
						//organization_ar = $('#organization_in_ar').val();
						organization_des = $('#organization_des').val();
						//organization_des_ar = $('#organization_des_ar').val();
						err = 0;

						if (organization == '' || organization_des == '') {
							err = 1;
						}

						if (err == 1) {
							$('.loading').hide();
							$('#error_org').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
						} else {

							url = '<?php echo base_url() . "admin/experience/add_org_details/" . $id;?>';

							$.ajax({
								type: 'POST',
								url: url,
								data: $('#organization_form').serialize(),
								success: function (data) {

									if (data == 1) {
										$("#experience_title_tab").removeClass("disabled_exp");
										document.getElementById("experience_title_tab").click();
										$('.loading').hide();
										$("#organization_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

									}
								}
							});

						}
					}
				</script>


				<div id="exp_title" class="tabcontent">
					<h3>Experience Title <br>
						<small>Title displayed on your public experience page.</small>
					</h3>
					<form id="exp_title_form" name="exp_title_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_exp_title">
								<small> * Please fill all mandatory fields</small>
							</span>
						</div>

						<ul>

							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Experience Title <span class="req">*</span></label>
									<div class="form_input">

										<input name="experience_title"
											   id="experience_title" type="text" class="exp_input"
											   value="<?php echo $listDetail->row()->experience_title; ?>">
                                        <span id="words_left_title" class="small_label"></span>
									</div>
								</div>
							</li>



								<li>
								<div class="form_grid_12">
									<?php  foreach(language_dynamic_enable("experience_title", "") as $dynlang) { ?>
									<label class="field_title" for="user_id">Experience Title in (<?php echo $dynlang[0]; ?>) <span class="req">*</span></label>
									<div class="form_input">

										<input name="<?php echo $dynlang[1]; ?>"
											   id="<?php echo $dynlang[1]; ?>" type="text" class="exp_input"
											   value="<?php echo $listDetail->row()->{$dynlang[1]}; ?>">
                                        <span id="words_left_title" class="small_label"></span>
									</div>
								<?php } ?>
								</div>
							</li>




							<li>

								<div class="exp-pic">

									<button class="btn btn-success" type="button"
											onclick="validate_form_exp_title(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
											echo stripslashes($this->lang->line('Save_and_Continue'));
										} else echo "Save & Continue"; ?></button>

								</div>

							</li>

						</ul>


					</form>
				</div>
				<!---exp-title content-->

				<script>

					function validate_form_exp_title(e) {
						$('.loading').show();
						experience_title = $('#experience_title').val();
						//experience_title_ar = $('#experience_title_ar').val();
						err = 0;
						if (experience_title == '') {
							err = 1;
						}

						if (err == 1) {
							$('.loading').hide();
							$('#error_exp_title').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
						} else {

							url = '<?php echo base_url() . "admin/experience/add_exp_details/" . $id;?>';

							$.ajax({
								type: 'POST',
								url: url,
								data: $('#exp_title_form').serialize(),
								success: function (data) {
									if (data == 1) {
										$("#timing_tab").removeClass("disabled_exp");
										document.getElementById("timing_tab").click();
										$('.loading').hide();
										$("#experience_title_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

									}
								}
							});

						}
					}

				</script>


				<div id="timing" class="tabcontent">

					<?php
					$this->load->view('admin/experience/schedule_experience.php');
					?>

				</div><!---timing-content-->

				<div id="tagline" class="tabcontent">
					<h3>Write a tagline <br>
						<small>Clearly describe your in one short,catchy sentence. Start with a verb that tells guests
							what they will do.
						</small>
					</h3>
					<form id="exp_tagline_form" name="exp_tagline_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_tagline">
								<small> * Please fill all mandatory fields</small>
							</span>
						</div>

						<ul>

							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Write your tagline here <span
											class="req">*</span></label>
									<div class="form_input">

										<input name="exp_tagline" maxlength="60" onkeyup="char_count(this)"
											   id="exp_tagline_in" type="text" class="exp_input"
											   value="<?php echo $listDetail->row()->exp_tagline; ?>">
										<?php
										$string = str_replace(' ', '', $listDetail->row()->exp_tagline);
										$len = mb_strlen($string, 'utf8');
										$remaining = (60 - $len);
										?>
										<span class="small_label"><span
												id="exp_tagline_in_char_count"><?php echo $remaining; ?></span> characters remaining</span>
									</div>
								</div>
							</li>



							<li>
								<div class="form_grid_12">
									<?php  foreach(language_dynamic_enable("exp_tagline", "") as $dynlang) { ?>

									<label class="field_title" for="user_id">Write your tagline here in (<?php echo $dynlang[0]; ?>) <span
											class="req">*</span></label>
									<div class="form_input">

										<input name="<?php echo $dynlang[1]; ?>" maxlength="60" onkeyup="char_count(this)"
											   id="<?php echo $dynlang[1]; ?>" type="text" class="exp_input"
											   value="<?php echo $listDetail->row()->{$dynlang[1]}; ?>">
										<?php
										$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
										$len = mb_strlen($string, 'utf8');
										$remaining = (60 - $len);
										?>
										<span class="small_label"><span
												id="exp_tagline_in_char_count"><?php echo $remaining; ?></span> characters remaining</span>
									</div>
								<?php } ?>
								</div>
							</li>




							<li>

								<div class="exp-pic">

									<button class="btn btn-success" type="button"
											onclick="validate_form_tagline(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
											echo stripslashes($this->lang->line('Save_and_Continue'));
										} else echo "Save & Continue"; ?></button>

								</div>

							</li>

						</ul>

					</form>
				</div><!---taline content-->
				<script>

					function validate_form_tagline(e) {

						$('.loading').show();
						exp_tagline = $('#exp_tagline_in').val();
						//exp_tagline_ar = $('#exp_tagline_in_ar').val();

						err = 0;
						if (exp_tagline == '') {
							err = 1;
						}

						if (err == 1) {
							$('.loading').hide();
							$('#error_tagline').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
						} else {

							url = '<?php echo base_url() . "admin/experience/add_tagline_experience/" . $id;?>';

							$.ajax({
								type: 'POST',
								url: url,
								data: $('#exp_tagline_form').serialize(),
								success: function (data) {
									if (data == 1) {
										$("#photos_tab").removeClass("disabled_exp");
										document.getElementById("photos_tab").click();
										$('.loading').hide();
										$("#tagline_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

									}
								}
							});

						}
					}

				</script>


				<div id="photos" class="tabcontent">
					<h3 class="margin_bottom_20">Add photos for your experience

						<br>
						<small>Choose photos that showcase the location and what guests will be doing. Photos must be at
							least 576 x 928 pixels.
						</small>
					</h3>
					<div class="margin_top_20 margin_bottom_20">
						<span class="error text-center" id="error_image">
						<small> * Please fill all mandatory fields</small>
						</span>
					</div>
					<form id="exp_image_form" name="exp_image_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<ul class="tab-areas2">

							<li>


								<input type="hidden" name="prdiii" id="prdiii"
									   value="<?php if (!empty($product_details)) {
										   echo trim(stripslashes($product_details->row()->id));
									   } else {
										   echo "0";
									   } ?>"/>

								<div class="form_grid_12">
									<label class="field_title" for="product_image">Experience Image <span
											class="req">*</span></label>
									<span class="dragndrop1"><a href="javascript:void(0);" onclick="ImageAddClick();">Choose Image</a></span>
								</div>
							</li>

							<li>
								<div class="widget_content">

									<input type="hidden" name="imagecount" id="imagecount"
										   value="<?php echo $imgDetail->num_rows(); ?>"/>
									<?php


									if (!empty($imgDetail->result_array())) {

										?>
										<table class="display display_tbl" id="image_tbl">
											<thead>
											<tr align="center">
												<th> Sno</th>
												<th> Image</th>
												<th> Action</th>
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
														<td class="center tr_select "><input type="hidden"
																							 name="imaged[]"
																							 value="<?php echo $img->product_image; ?>"/>
															<?php echo $j; ?> </td>
														<td class="center "><img
																src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "images/experience/" . $img->product_image; ?>"
																height="80px" width="80px"/></td>
														<td class="center tr_select">
															<ul class="action_list"
																style="background:none;border-top:none;">
																<li style="width:100%; border-bottom: none;"><a
																		class="p_del tipTop" href="javascript:void(0)"
																		onClick="javascript:DeleteProductImage(<?php echo $img->id; ?>,<?php echo $product_details->row()->id; ?>);"
																		title="Delete this image">Remove</a></li>
															</ul>
														</td>
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
												<th> Action</th>
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
										<input type="text" value="<?php echo $listDetail->row()->video_url; ?>"
											   placeholder="<?php if ($this->lang->line('video_url') != '') {
												   echo stripslashes($this->lang->line('video_url'));
											   } else echo "Enter video link"; ?>" class="title_overview"
											   onchange="javascript:experienceDetailview(this,<?php echo $product_details->row()->id; ?>,'video_url');"
											   name="video_url" id="video_url" style="color:#000 !important;"/>
									</div>
								</div>


							</li>


							<li>
								<div class="form_grid_12">
									<div class="exp-pic">

										<button class="btn btn-success" type="button"
												onclick="form_dump_video_url(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
												echo stripslashes($this->lang->line('Save_and_Continue'));
											} else echo "Save and Continue"; ?></button>

									</div>
								</div>
							</li>
						</ul>

					</form>

				</div>
				<!--photos-content-->

				<script type="text/javascript">

					function form_dump_video_url(e) {
						$('.loading').show();
						video_url = $('#video_url').val();
						imagecount = $('#imagecount').val();

						if (imagecount == 0) {
							$('.loading').hide();
							$('#error_image').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
						}


						err = 0;
						if (video_url != '') {

							url = '<?php echo base_url() . "admin/experience/add_exp_video_url/" . $id;?>';

							$.ajax({
								type: 'POST',
								url: url,
								data: "video_url=" + video_url,
								success: function (data) {
									if (data == 1) {

										$("#what_we_do_tab").removeClass("disabled_exp");
										document.getElementById("what_we_do_tab").click();
										$('.loading').hide();
										$("#photos_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

									}
								}
							});
						} else {
							$("#what_we_do_tab").removeClass("disabled_exp");
							document.getElementById("what_we_do_tab").click();
							setTimeout(function() { $(".loading").hide(); }, 500);
						}
					}

					function ImageAddClick() {

						var idval = $('#prdiii').val();
//alert(idval);
						$(".dragndrop1").colorbox({
							width: "1000px",
							height: "500px",
							href: baseURL + "admin/experience/dragimageuploadinsert/?id=" + idval
						});
					}

					function delimage(val) {
						$('#row' + val).remove();
					}

					$(function () {


						/* product Add images dynamically */
						var i = 1;


						$('#add').click(function () {

							$('<div id="row' + i + '" class="control-group field"><input type="text" class="small tipTop" name="imgtitle[]"  maxlength="25"  placeholder="Caption" /> <input class="small tipTop"  placeholder="Priority" name="imgPriority[]" type="text"><div class="uploader" id="uniform-productImage" style=""><input type="file" class="large tipTop" name="product_image[]" id="product_image" onchange="Test.UpdatePreview(this,' + i + ')" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div><img style="display: inline-block; margin: 0 10px; position: relative;top: 13px;" class="img' + i + '" width="150" height="150" alt="" src="images/noimage.jpg"><a href="javascript:void(0);" onclick="return delimage(' + i + ');"><div class="rmv_btn">Remove</div></a></div></div><br />').fadeIn('slow').appendTo('.imageAdd');
							i++;
						});

						Test = {
							UpdatePreview: function (obj, ival) {

								if (!window.FileReader) {

								} else {
									var reader = new FileReader();
									var target = null;

									reader.onload = function (e) {
										target = e.target || e.srcElement;

										$(".img" + ival).prop("src", target.result);
									};
									reader.readAsDataURL(obj.files[0]);
								}
							}
						};

						$('#remove').click(function () {

							if (i > 0) {
								$('.field:last').remove();
								i--;
							}
						});

						$('#reset').click(function () {

							$('.field').remove();
							$('.field').remove();
							$('#add').show();
							i = 0;


						});

						$('#add').click(function () {
							if (i > 15) {
								$('#add').hide();

							}
						});
					});

					/* end */
					function DeleteProductImage(prdID, Id) {
						$('.loading').show();
						imagecount = $('#imagecount').val();
						if (imagecount == 1) {
							$('.loading').hide();
							alert("Image are mandatory. so need one or more image");
							return false;
						} else {
							$.ajax({
								type: 'post',
								url: baseURL + 'admin/experience/deleteProductImage',
								data: {'prdID': prdID},
								dataType: 'json',
								success: function (json) {


									$('#img_' + prdID).hide();
									$('#img_' + prdID).show().text('Done').delay(800).text('');

									location.reload();

								}
							});
						}
					}
				</script>


				<div id="what_we_do" class="tabcontent">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Mention what you'll do"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Describe in detail what you'll be doing with your guests. The more information you can give, the better."; ?> </p>


					<form id="exp_what_we_do_form" name="exp_what_we_do_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">
								<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_what_we_do">
								<small> * Please fill all mandatory fields</small>
								</span>
								</div>
								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">What you'll do <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)" name="what_we_do"
														  id="what_we_do_add" class="exp_input"
														  placeholder="What you'll do"><?php echo $listDetail->row()->what_we_do; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->experience_description);
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="what_we_do_add_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>

									<li>

										<div class="form_grid_12">
											<?php  foreach(language_dynamic_enable("what_we_do", "") as $dynlang) { ?>
											<label class="field_title" for="user_id">What you'll do (<?php echo $dynlang[0]; ?>) <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)" name="<?php echo $dynlang[1]; ?>"
														  id="<?php echo $dynlang[1]; ?>" class="exp_input"
														  placeholder="What you'll do"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="what_we_do_add_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>

										<?php } ?>
										</div>

									</li>


									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_what_we_do(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_what_we_do(e) {
							$('.loading').show();
							what_we_do = $('#what_we_do_add').val();
							//what_we_do_ar = $('#what_we_do_ar').val();
							err = 0;

							if (what_we_do == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_what_we_do').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_what_we_do/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_what_we_do_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#where_will_be_tab").removeClass("disabled_exp");
											document.getElementById("where_will_be_tab").click();
											$('.loading').hide();
											$("#what_we_do_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

										}
									}
								});
							}
						}

					</script>
				</div> <!--what we do content-->

				<div id="where_will_be" class="tabcontent">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Mention where you'll be"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Name all the locations you'll visit. Give guests a glimpse of why they're meaningful."; ?> </p>


					<form id="exp_where_will_be_form" name="exp_where_will_be_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
						<span class="error text-center" id="error_where_will_be">
						<small> * Please fill all mandatory fields</small>
						</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Mention where you'll be <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="location_description" id="location_description"
														  class="exp_input"
														  placeholder="where you'll be"><?php echo $listDetail->row()->location_description; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->location_description);
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="location_description_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>


									<li>

										<div class="form_grid_12">
											<?php  foreach(language_dynamic_enable("location_description", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Mention where you'll be (<?php echo $dynlang[0]; ?>)<span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>"
														  class="exp_input"
														  placeholder="where you'll be"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="location_description_char_count_ar"><?php echo $remaining; ?></span> characters remaining</span>
											</div>
										<?php } ?>

										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_where_you_will_be(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_where_you_will_be(e) {
							$('.loading').show();
							location_description = $('#location_description').val();
							//location_description_ar = $('#location_description_ar').val();
							err = 0;

							if (location_description == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_where_will_be').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_where_we_will_be/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_where_will_be_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#where_will_meet_tab").removeClass("disabled_exp");
											document.getElementById("where_will_meet_tab").click();
											$('.loading').hide();
											$("#where_will_be_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										}
									}
								});
							}
						}

					</script>


				</div> <!--where_will_be do content-->

				<div id="where_will_meet" class="tabcontent">

					<h3><?php if ($this->lang->line('Address') != '') {
							echo stripslashes($this->lang->line('Address'));
						} else echo "Address"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Let guests know exactly where you'll be meeting. The exact address wont't be shared with guests untill the book."; ?> </p>

					<form id="exp_where_will_meet_form" name="exp_where_will_meet_form" method="post"
						  accept-charset="UTF-8" class="form_container left_label listingInfo">
						<input type="hidden" name="" id="edit_pro_id" value="<?php echo $id; ?>">
						<input type="hidden" name="latitude" id="latitude" value="">
						<input type="hidden" name="longitude" id="longitude" value="">

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_where_will_meet">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">
									<li>
										<div class="form_grid_12">
											<label class="field_title" for="address">Location <span class="req">*</span></label>
											<div class="form_input">
												<input id="autocomplete-admin" name="address"
													   onblur="getAddressDetails();" placeholder=""
													   onFocus="geolocate()" type="text"
													   value="<?php if (!empty($product_details)) {
														   echo trim(stripslashes($product_details->row()->address));
													   } ?>" style="width:370px;" class="large tipTop"
													   title="Enter your Location"><span id="location_error_valid"
																						 style="color:#f00;display:none;"> Only Alphabets allowed!</span>
												<span id="location_error" style="color:red;">
					</span>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<label class="field_title" for="country">Country<span
													class="req">*</span></label>
											<div class="form_input">
												<input placeholder="" id="country" name="country" type="text"
													   value="<?php if ($productAddressData->row()->country != '') echo $productAddressData->row()->country; //echo $country;
													   ?>" style="width:370px;" class="large tipTop"
													   title="Enter Country Name"><span id="country_error_valid"
																						style="color:#f00;display:none;">Only Alphabets allowed!</span>
												<span id="country_error" style="color:red;">
					</span>
											</div>
										</div>
									</li>

									<li>
										<div class="form_grid_12">
											<label class="field_title" for="state">State<span
													class="req">*</span></label>
											<div class="form_input" id="listCountryCnt">
												<input placeholder="" id="state" name="state" type="text"
													   value="<?php if ($productAddressData->row()->state != '') echo $productAddressData->row()->state; ?>"
													   style="width:370px;" class="large tipTop"
													   title="Enter State Name"><span id="state_error_valid"
																					  style="color:#f00;display:none;">Only Alphabets allowed!</span>
												<span id="state_error" style="color:red;">
					</span>
											</div>
										</div>
									</li>

									<li>
										<div class="form_grid_12">
											<label class="field_title" for="city">City<span class="req">*</span></label>
											<div class="form_input" id="listStateCnt">
												<input id="city" name="city" type="text"
													   value="<?php if ($productAddressData->row()->city != '') echo $productAddressData->row()->city;
													   ?>" style="width:370px;" class="large tipTop"
													   title="Enter City Name"><span id="city_error_valid"
																					 style="color:#f00;display:none;">Only Alphabets allowed!</span>
												<span id="city_error" style="color:red;">
					</span>
											</div>
										</div>
									</li>

									<li>
										<div class="form_grid_12">
											<label class="field_title" for="apt">Street Address</label>
											<div class="form_input">
												<input type="text" name="apt" id="apt" tabindex="3" style="width:370px;"
													   class="large tipTop" title="Enter the Apt, Suite, Bldg"
													   value="<?php if ($productAddressData->row()->street != '') echo $productAddressData->row()->street; ?>"/>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<label class="field_title" for="post_code">Zip Code<span
													class="req">*</span></label>
											<div class="form_input">

												<input type="text" name="post_code" maxlength="11" id="post_code"
													   tabindex="8" class="large tipTop"
													   title="Please enter the post code"
													   value="<?php if ($productAddressData->row()->zip != '') echo $productAddressData->row()->zip; // echo $zip;
													   ?>"/><span id="post_code_error_valid"
																  style="color:#f00;display:none;">Only Alphabets allowed!</span><span
													id="post_code_length_error" style="color:red;"></span>
											</div>

											<div style="margin-top:10px;">
												
												
												<div align="center" id="map-new"
													 style="width: 600px; height: 300px; display:block"><h1 id='map-text' style="color:red;margin-top:150px;">
														Map will be displayed here</h1></div>

											</div>

										</div>
									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_where_you_will_meet(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>

							</div>
						</div>

					</form>
					<script type="text/javascript">
						function validate_form_where_you_will_meet() {
							$('.loading').show();
							err = 0;

							var pro_id = $('#prdiii').val();

							var edit_pro_id = $('#edit_pro_id').val();
							var location = $('#autocomplete-admin').val();
							var country = $('#country').val();
							var state = $('#state').val();
							var city = $('#city').val();
							var apt = $('#apt').val();
							var post_code = $('#post_code').val();
							var latitude = $('#latitude').val();
							var longitude = $('#longitude').val();
							var location_data = $('#autocomplete-admin').val();


							if (location_data == '' || country == '' || state == '' || city == '') {
								err = 1;
							}

							if (err == 1) {
								$('.loading').hide();
								$('#error_where_will_meet').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {

								if (pro_id != '' && pro_id != '0') {
									$.ajax({
										type: 'post',
										url: baseURL + 'admin/experience/savetab4',
										data: {
											'pro_id': pro_id,
											'edit_pro_id': edit_pro_id,
											'location': location,
											'country': country,
											'state': state,
											'city': city,
											'apt': apt,
											'post_code': post_code,
											'latitude': latitude,
											'longitude': longitude
										},
										dataType: 'json',
										success: function (json) {

											if (json.resultval == 'Updated') {
												$("#what_you_will_provide_tab").removeClass("disabled_exp");
												document.getElementById("what_you_will_provide_tab").click();
												$('.loading').hide();
												$("#where_will_meet_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
											}
										}
									});
								}

							}

						}


						var placeSearch, autocomplete;
						var componentForm = {
							street_number: 'short_name',
							route: 'long_name',
							locality: 'long_name',
							administrative_area_level_1: 'short_name',
							country: 'long_name',
							postal_code: 'short_name'
						};


						function initializeMap() {


							autocomplete = new google.maps.places.Autocomplete(
								/** @type {HTMLInputElement} */(document.getElementById('autocomplete-admin')),
								{types: ['geocode']});

							google.maps.event.addListener(autocomplete, 'place_changed', function () {
								fillInAddress();
							});
						}


						function fillInAddress() {

							var place = autocomplete.getPlace();

							for (var component in componentForm) {
								document.getElementById(component).value = '';
								document.getElementById(component).disabled = false;
							}


							for (var i = 0; i < place.address_components.length; i++) {
								var addressType = place.address_components[i].types[0];
								if (componentForm[addressType]) {
									var val = place.address_components[i][componentForm[addressType]];
									document.getElementById(addressType).value = val;
								}
							}
						}

						function geolocate() {
							if (navigator.geolocation) {
								navigator.geolocation.getCurrentPosition(function (position) {
									var geolocation = new google.maps.LatLng(
										position.coords.latitude, position.coords.longitude);
									var circle = new google.maps.Circle({
										center: geolocation,
										radius: position.coords.accuracy
									});
									autocomplete.setBounds(circle.getBounds());
								});
							}
						}

						getAddressDetails();
						function getAddressDetails() {

							var address = $('#autocomplete-admin').val();

							if(address != ''){
							$.ajax({
								type: 'POST',
								url: baseURL + 'site/experience/get_location',
								data: {"address": address},
								dataType: 'json',
								success: function (json) {
									$('#country').val(json.country);
									$('#state').val(json.state);
									$('#city').val(json.city);
									$('#post_code').val(json.zip);
									$('#apt').val(json.area);
									$('#latitude').val(json.lat);
									$('#longitude').val(json.lang);

									myLatlng = new google.maps.LatLng(json.lat, json.lang);

									citymap['chicago'] = {
										center: myLatlng,
										population: 200
									};
									$("#map-image").hide();
									$("#map-new").show();
									$('#map_old').hide();
									initializeMapCircle();

								}
							});
						}else{
								$.ajax({
								type: 'POST',
								url: baseURL + 'site/experience/get_location',
								data: {"address": 'Las vegas'},
								dataType: 'json',
								success: function (json) {
								

									myLatlng = new google.maps.LatLng(json.lat, json.lang);

									citymap['chicago'] = {
										center: myLatlng,
										population: 200
									};
									$("#map-image").hide();
									$("#map-new").show();
									$('#map_old').hide();
									initializeMapCircle();

								}
							});
						}

						}


					</script>

				</div><!--where will meet-->

				<div id="what_you_will_provide" class="tabcontent">

					<?php
					$this->load->view('admin/experience/what_you_will_provide.php');
					?>
				</div><!-- what you will provide content-->

				<div id="notes" class="tabcontent">


					<h3>Is there anything you’d like guests to know before booking?</h3>

					<h3 style="display:none"><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "What else should guests know?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Mention anything that guests will have to bring eith them or arrange on their own, like transportation."; ?> </p>


					<form id="exp_notes_form" name="exp_notes_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
						<span class="error text-center" id="error_notes">
						<small> * Please fill all mandatory fields</small>
						</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Add notes <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="200" onkeyup="char_count(this)"
														  name="note_to_guest" id="note_to_guest" class="exp_input"
														  placeholder="Notes to guests"><?php echo $listDetail->row()->note_to_guest; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->note_to_guest);
												$len = mb_strlen($string, 'utf8');
												$remaining = (200 - $len);
												?>
												<span class="small_label"><span
														id="note_to_guest_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">

											<?php  foreach(language_dynamic_enable("note_to_guest", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Add notes in (<?php echo $dynlang[0]; ?>) <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="200" onkeyup="char_count(this)"
														  name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>" class="exp_input"
														  placeholder="Notes to guests in <?php echo $dynlang[0]; ?>"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (200 - $len);
												?>
												<span class="small_label"><span
														id="note_to_guest_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>

										<?php } ?>


										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_notes(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_notes(e) {
							$('.loading').show();
							note_to_guest = $('#note_to_guest').val();
							//note_to_guest_ar = $('#note_to_guest_ar').val();
							err = 0;

							if (note_to_guest == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_notes').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_note_to_guest/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_notes_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#about_you_tab").removeClass("disabled_exp");
											document.getElementById("about_you_tab").click();
											$('.loading').hide();
											$("#notes_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										}
									}
								});
							}
						}

					</script>

				</div><!---notes div-->


				<div id="about_you" class="tabcontent">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Write Host's bio"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Describe about host and tell guests how came to be passionate about hosting this experience."; ?> </p>


					<form id="exp_about_host_form" name="exp_about_host_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_about_host">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">About Host <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)" name="about_host"
														  id="about_host" class="exp_input"
														  placeholder="About Host"><?php echo $listDetail->row()->about_host; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->about_host);
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="about_host_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">
											
											<?php  foreach(language_dynamic_enable("about_host", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">About Host in (<?php echo $dynlang[0]; ?>)<span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)" name="<?php echo $dynlang[1]; ?>"
														  id="<?php echo $dynlang[1]; ?>" class="exp_input"
														  placeholder="About Host"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="about_host_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>
										<?php } ?>

										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_about_host(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_about_host(e) {
							$('.loading').show();
							about_host = $('#about_host').val();
							//about_host_ar = $('#about_host_ar').val();
							err = 0;

							if (about_host == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_about_host').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_about_host/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_about_host_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#guest_req_tab").removeClass("disabled_exp");
											document.getElementById("guest_req_tab").click();
											$('.loading').hide();
											$("#about_you_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										}
									}
								});
							}
						}

					</script>


				</div><!--about_you_content-->


				<div id="guest_req" class="tabcontent">


					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Have any guest requirements?"; ?></h3>

					<p>Mention anything that guests will have to bring with them or arrange on their own, like
						transportation. </p>


					<form id="exp_guest_req_form" name="exp_guest_req_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_guest_req">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Guest requirements <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="guest_requirement" id="guest_requirement"
														  class="exp_input"
														  placeholder="Details about Guest Requirement"><?php echo $listDetail->row()->guest_requirement; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->guest_requirement);
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="guest_requirement_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">

											<?php  foreach(language_dynamic_enable("guest_requirement", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Guest requirements in (<?php echo $dynlang[0]; ?>) <span
													class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>"
														  class="exp_input"
														  placeholder="Details about Guest Requirement"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>
												<span class="small_label"><span
														id="guest_requirement_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>
										<?php } ?>

										</div>

									</li>


									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_guest_req(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_guest_req(e) {
							$('.loading').show();
							guest_requirement = $('#guest_requirement').val();
							//guest_requirement_ar = $('#guest_requirement_ar').val();
							err = 0;

							if (guest_requirement == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_guest_req').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_guest_requirement/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_guest_req_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#group_size_tab").removeClass("disabled_exp");
											document.getElementById("group_size_tab").click();
											$('.loading').hide();
											$("#guest_req_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										}
									}
								});
							}
						}

					</script>

				</div><!--guest_requ_div-->


				<div id="group_size" class="tabcontent">


					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Maximum number of guests?"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "How Many number of guests you can accommodate?"; ?> </p>


					<form id="exp_group_size_form" name="exp_group_size_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_group_size">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title number" for="user_id">Group size <span
													class="req">*</span></label>
											<div class="form_input">
												<input class="title_overview number_field"
													   placeholder="<?php if ($this->lang->line('group_size') != '') {
														   echo stripslashes($this->lang->line('group_size'));
													   } else echo "Group size"; ?>" name="group_size"
													   id="group_size_add"
													   value="<?php echo $listDetail->row()->group_size; ?>"
													   maxlength="2">


											</div>


										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_group_size(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_group_size(e) {
							$('.loading').show();
							group_size = $('#group_size_add').val();
							err = 0;

							if (group_size == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_group_size').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_group_size/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_group_size_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#price_tab").removeClass("disabled_exp");
											document.getElementById("price_tab").click();
											$('.loading').hide();
											$("#group_size").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										}
									}
								});
							}
						}

					</script>

				</div><!-- group size-->

				<div id="price_content" class="tabcontent">

					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Set a price per guest"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "The price of your experience is entirely up to you. Play with the calculator to see how much you'd earn depending on the number of guests."; ?> </p>


					<form id="exp_price_form" name="exp_price_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_price">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Choose currency <span
													class="req">*</span></label>
											<div class="form_input">

												<select name="currency" id="currency_add"
														style="width:128px;display:inline-block;padding: 10px;height: 45px;">

													<option value="">Select Currency</option>

													<?php foreach ($currentCurrency_all as $currency) {
														$sel = '';
														if ($currency->currency_type == $listDetail->row()->currency) {
															$sel = "selected";
														}
														?>
														<option
															value="<?php echo $currency->currency_type; ?>" <?php echo $sel; ?>><?php echo $currency->currency_type; ?></option>
													<?php } ?>

												</select>

											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Price per person <span class="req">*</span></label>
											<div class="form_input">
												<input class="title_overview number_field"
													   style="width:50%;display:inline-block;"
													   placeholder="<?php if ($this->lang->line('price') != '') {
														   echo stripslashes($this->lang->line('price'));
													   } else echo "Price"; ?>" name="price" id="price_add"
													   value="<?php echo ($listDetail->row()->price > 0) ? intval($listDetail->row()->price) : ''; ?>"
													   maxlength="10">
											</div>


										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_price(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
														echo stripslashes($this->lang->line('Save_and_Continue'));
													} else echo "Save & Continue"; ?></button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_price(e) {
							$('.loading').show();
							price = $('#price_add').val();
							currency = $('#currency_add').val();
							err = 0;

							if (price == '' || currency == '') {
								err = 1;
							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_price').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_price/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_price_form').serialize(),
									success: function (data) {

										if (data == 1) {
											$("#can_currency").val(currency);
											$("#cancel_policy_tab").removeClass("disabled_exp");
											document.getElementById("cancel_policy_tab").click();
											$('.loading').hide();
											$("#price_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

										}
									}
								});
							}
						}

					</script>
				</div><!--price_tab_cont-->

				<div id="cancel_policy" class="tabcontent">


					<h3><?php if ($this->lang->line('experience_details') != '') {
							echo stripslashes($this->lang->line('experience_details'));
						} else echo "Cancellation Policy"; ?></h3>

					<p><?php if ($this->lang->line('Aexperiencetitleandsummary') != '') {
							echo stripslashes($this->lang->line('Aexperiencetitleandsummary'));
						} else echo "Cancel policy support to experiences."; ?> </p>


					<form id="exp_cancel_policy_form" name="exp_cancel_policy_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">

						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>

						<div class="dashboard_price_right">
							<div class="exp_det_right">

								<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center" id="error_cancel_policy">
							<small> * Please fill all mandatory fields</small>
							</span>
								</div>

								<ul class="tab-areas2">

									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Cancellation Policy <span
													class="req">*</span></label>
											<div class="form_input">

												<select class="gends" name="cancel_policy" id="cancel_policy_1"
														onchange="show_val(this);">

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
													
													<!--<option value="No Return" <?php //if (!empty($listDetail)) {
														//if ($listDetail->row()->cancel_policy == 'No Return') {
															//echo 'selected="selected"';
														//}
													//} ?>>No Return
													</option>-->
													
												</select>

											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Security Deposit<span
													class="req">*</span></label>
											<div class="form_input">
												<input type="text" name="currency" id="can_currency" readOnly
													   value="<?php echo $currentCurrency_type; ?>"
													   style="width:10%;display:inline-block;">

												<input type="text" id="sec_deposit" name="sec_deposit"
													   onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'security_deposit');"
													   value="<?php echo ($listDetail->row()->security_deposit > 0) ? intval($listDetail->row()->security_deposit) : ''; ?>"
													   style="width:30%;display:inline-block;">
											</div>


										</div>

									</li>
									<li>
										<div id="return_amount_percentage"
											 <?php if ($listDetail->row()->cancel_policy == 'Strict'){ ?>style="display:none" <?php } ?>>
											<div class="form_grid_12">
												<label class="field_title" for="user_id">Return Amount<span class="req">*</span></label>

												<input type="text" maxlength="2"
													   value="<?php echo $listDetail->row()->cancel_percentage; ?>"
													   class="number_field required large tipTop"
													   onkeypress="return check_for_num(event)" id="cancel_percentage"
													   name="cancel_percentage" placeholder="Enter your return amount"/>
												%
												<span id="return_amount_error" style="color:red;font-size:12px;"
													  class="error"></span>
											</div>

										</div>
									</li>
									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Policy Desciption<span class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="cancel_policy_des"
														  id="cancel_policy_des"><?php echo $listDetail->row()->cancel_policy_des; ?></textarea>

												<?php
												$string = str_replace(' ', '', $listDetail->row()->cancel_policy_des);
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>

												<span class="small_label"><span
														id="cancel_policy_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>


										</div>

									</li>
									<li>

										<div class="form_grid_12">

											<?php  foreach(language_dynamic_enable("cancel_policy_des", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Policy Desciption in (<?php echo $dynlang[0]; ?>)<span class="req">*</span></label>
											<div class="form_input">
												<textarea maxlength="250" onkeyup="char_count(this)"
														  name="<?php echo $dynlang[1]; ?>"
														  id="<?php echo $dynlang[1]; ?>"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>

												<?php
												$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
												$len = mb_strlen($string, 'utf8');
												$remaining = (250 - $len);
												?>

												<span class="small_label"><span
														id="cancel_policy_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>
											</div>

										<?php } ?>

										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">

												<button class="btn btn-success" type="button"
														onclick="validate_form_cancel_policy(event)">Save & Continue
												</button>

											</div>
										</div>
									</li>

								</ul>


							</div>

						</div>


					</form>


					<script>

						function validate_form_cancel_policy(e) {
							$('.loading').show();
							cancel_policy_1 = $('#cancel_policy_1').val();
							cancel_policy_des = $('#cancel_policy_des').val();
							//cancel_policy_des_ar = $('#cancel_policy_des_ar').val();
							sec_deposit = $('#sec_deposit').val();
							cancel_percentage = $('#cancel_percentage').val();
							err = 0;

							if (sec_deposit == '' || cancel_policy_1 == '' || cancel_policy_des == '') {
								err = 1;
							}
							if (cancel_policy_1 == 'Flexible' || cancel_policy_1 == 'Moderate') {
								if (cancel_percentage == '') {
									err = 1;
								}

							}
							if (err == 1) {
								$('.loading').hide();
								$('#error_cancel_policy').fadeIn('slow', function () {
									$(this).delay(5000).fadeOut('slow');
								});
								return false;
							} else {
								url = '<?php echo base_url() . "admin/experience/add_cancel_policy/" . $id;?>';

								$.ajax({
									type: 'POST',
									url: url,
									data: $('#exp_cancel_policy_form').serialize(),
									success: function (data) {

										if (data == 1) {


											$("#seo_tab").removeClass("disabled_exp");
											document.getElementById("seo_tab").click();
											$('.loading').hide();
											$("#cancel_policy_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');


										}
									}
								});
							}
						}

					</script>


				</div>

				<!--SEO -->
				<div id="seo" class="tabcontent">
					<h3>SEO</h3>

					<form id="exp_seo_form" name="exp_seo_form" method="post" accept-charset="UTF-8"
						  class="form_container left_label listingInfo">
						<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
							   value="<?php echo $listDetail->row()->experience_id; ?>"/>
						<div class="dashboard_price_right">
							<div class="exp_det_right">
								<div class="margin_top_20 margin_bottom_20">
               <span class="error text-center" id="error_seo">
               <small> * Please fill all mandatory fields</small>
               </span>
								</div>
								<ul class="tab-areas2">
									<li>
										<div class="form_grid_12">
											<label class="field_title" for="user_id">Meta Title </label>
											<div class="form_input">
												<input name="meta_title" id="meta_title" type="text" tabindex="1"
													   class="required large tipTop"
													   title="Please enter the page meta title"
													   value="<?php if (!empty($listDetail)) {
														   echo trim(stripslashes($listDetail->row()->meta_title));
													   } ?>"/>
											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">

											<?php  foreach(language_dynamic_enable("meta_title", "") as $dynlang) { ?>										
											<label class="field_title" for="user_id">Meta Title In (<?php echo $dynlang[0]; ?>) </label>
											
											<div class="form_input">
												<input name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>" type="text" tabindex="1"
													   class="required large tipTop"
													   title="Please enter the page meta title"
													   value="<?php if (!empty($listDetail)) {
														   echo trim(stripslashes($listDetail->row()->{$dynlang[1]}));
													   } ?>"/>
											</div>
										<?php } ?>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											<label class="field_title" for="user_id">Keywords</label>
											<div class="form_input">

												<textarea name="meta_keyword" id="meta_keywords" tabindex="13"
														  style="width:370px;height:150px;"
														  class="required large tipTop"
														  title="Please enter the keywords"><?php if (!empty($listDetail)) {
														echo trim(stripslashes($listDetail->row()->meta_keyword));
													} ?></textarea>

											</div>
										</div>
									</li>
									<li>
										<div class="form_grid_12">
											
											<?php  foreach(language_dynamic_enable("meta_keyword", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Keywords In (<?php echo $dynlang[0]; ?>)</label>
											<div class="form_input">

												<textarea name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>" tabindex="13"
														  style="width:370px;height:150px;"
														  class="required large tipTop"
														  title="Please enter the keywords"><?php if (!empty($listDetail)) {
														echo trim(stripslashes($listDetail->row()->{$dynlang[1]}));
													} ?></textarea>

											</div>
										<?php } ?>
										</div>
									</li>
									<li>

										<div class="form_grid_12">
											<label class="field_title" for="user_id">Meta Description</label>
											<textarea name="meta_description" id="meta_description" tabindex="13"
													  style="width:370px;height:150px;" class="required large tipTop"
													  title="Please enter the meta description"> <?php if (!empty($listDetail)) {
													echo trim(stripslashes($listDetail->row()->meta_description));
												} ?></textarea>
										</div>

									</li>
									<li>

										<div class="form_grid_12">

											<?php  foreach(language_dynamic_enable("meta_description", "") as $dynlang) { ?>

											<label class="field_title" for="user_id">Meta Description in (<?php echo $dynlang[0]; ?>)</label>
											<textarea name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>" tabindex="13"
													  style="width:370px;height:150px;" class="required large tipTop"
													  title="Please enter the meta description"> <?php if (!empty($listDetail)) {
													echo trim(stripslashes($listDetail->row()->{$dynlang[1]}));
												} ?></textarea>

											<?php } ?>
										</div>

									</li>

									<li>
										<div class="form_grid_12">
											<div class="exp-pic">
												<button class="btn btn-success" type="button"
														onclick="validate_form_seo(event)"><?php if ($this->lang->line('Save and Activate') != '') {
														echo stripslashes($this->lang->line('Save and Activate Experience'));
													} else echo "Save and Activate Experience"; ?></button>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</form>
					<script>
						function validate_form_seo(e) {
							$('.loading').show();
							meta_tittle = $('#meta_title').val();
							///meta_tittle_ar = $('#meta_title_ar').val();
							meta_keywrds = $('#meta_keywords').val();
							//meta_keywrds_ar = $('#meta_keywords_ar').val();
							meta_description = $('#meta_description').val();
							//meta_description_ar = $('#meta_description_ar').val();


							url = '<?php echo base_url() . "admin/experience/add_seo/" . $id;?>';
							$.ajax({
								type: 'POST',
								url: url,
								data: $('#exp_seo_form').serialize(),
								success: function (data) {
									if (data == 1) {

										alert('This experience Added Successfully');
										$("#basic_tab").removeClass("disabled_exp");
										document.getElementById("basic_tab").click();
										$('.loading').hide();
									}
								}
							});


						}


					</script>
				</div>

				<!--SEO Ends-->


				<!---vertical tab- ends -->

			<?php } ?>

		</div>
		<span class="clear"></span>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function () {
		tab_id = window.location.hash;
		ur = window.location.href.split('#')[0];
		div_id = tab_id.replace('#', '');
		;
		newHREF = ur + tab_id;
		id = '<?php echo $id; ?>';

		if ((div_id != '') && (id != '' && id != '0')) {
			$('#' + div_id).removeClass('disabled_exp');
			document.getElementById(div_id).click();
		}
	});

	function openContent(evt, div_id, obj) {

		has = $(obj).hasClass("disabled_exp");
		if (has == true) {
			div_id = 'basic_tab';

			tab_id = div_id;
			ur = window.location.href.split('#')[0];
			newHREF = ur + '#' + tab_id;


			return false;
		}

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


		tab_id = obj.id;
		ur = window.location.href.split('#')[0]
		newHREF = ur + '#' + tab_id;
		history.pushState('', 'Experience', newHREF);
	}


	function next_form(e, div_id) {
		$(".loading").show();
		setTimeout(function() { $(".loading").hide(); }, 500);
		$("#" + div_id).removeClass("disabled_exp")
		document.getElementById(div_id).click();

		return false;
	}

	$(document).ready(function () {
		$('.disabled_exp').blur();
		$(".disabled_exp").click(function (event) {
			preventClick = true
			event.preventDefault();
		});

		$(".number_field").keydown(function (e) {

			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||

				(e.keyCode >= 35 && e.keyCode <= 40)) {

				return;
			}

			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});

		tab_id = window.location.hash;

		if (tab_id == '') {
			$('#basic_tab').removeClass('disabled_exp');
			document.getElementById("basic_tab").click();
		} else {

			t_id = tab_id.replace('#', '');
			$(tab_id).removeClass('disabled_exp');
			document.getElementById(t_id).click();

		}

		lan_count = $(".inner_language li").length;
		if (lan_count == 0) {
			$('#lang_btn').hide();
		} else {
			$('#lang_btn').show();
		}
	});

	function char_count(obj) {
		value_str = obj.value.trim();
		var length = value_str.length;
		var maxlength = $(obj).attr('maxlength');
		var id = obj.id;
		var length = maxlength - length;
		//console.log(id);
		$('#' + id + '_char_count').text(length);
	}

	function continue_button_manage(status) {
		if (status == "show") {
			$('.continue').removeClass('disabled_exp');
		} else {
			$('.continue').addClass('disabled_exp');
		}
	}


	$("#post_code").on('keyup', function (e) {
		var val = $(this).val();

	});
</script>
<script>
	function show_val(cancel_value) {


		if (cancel_value.value == 'Flexible') {
			$('#return_amount_percentage').show();
			$('#cancel_percentage').val('<?php  echo $listDetail->row()->cancel_percentage; ?>');
			$("#cancel_percentage").attr("readonly", false);
		}
		else if (cancel_value.value == 'Moderate') {
			$('#return_amount_percentage').show();
			$('#cancel_percentage').val('50');
			$("#cancel_percentage").attr("readonly", false);

		}
		else if (cancel_value.value == 'No Return') {
			$('#return_amount_percentage').hide();
			$('#cancel_percentage').val('0');


		}
		else if (cancel_value.value == 'Strict') {
			$('#return_amount_percentage').show();
			$('#cancel_percentage').val('99');
			$("#cancel_percentage").attr("readonly", false);
		}
		else {
			$('#return_amount_percentage').hide();
		}
	}
</script>

<script>
    var wordLen1 = 8, len1;
    $('#experience_title').keydown(function (event) {
        len1 = $('#experience_title').val().split(/[\s]+/);
        if (len1.length > wordLen1) {
            if (event.keyCode == 46 || event.keyCode == 8) {
                /*Allow backspace and delete buttons*/
            }
            else if (event.keyCode < 48 || event.keyCode > 57) { /*all other buttons*/
                event.preventDefault();
            }
        }
        wordsLeft = (wordLen1) - len1.length;
        if (wordsLeft <= 0) {
            document.getElementById("words_left_title").innerHTML = "8 Words Reached";
        }
        else {
            $("#words_left_title").html("You can add " + wordsLeft + " more words!");
        }
    });
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
