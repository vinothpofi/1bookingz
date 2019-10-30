<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<link rel="stylesheet" href="<?php echo base_url();?>css/localize/bootstrap-3.37.min.css">
<script src="<?php echo base_url();?>css/localize/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url();?>css/localize/bootstrap-3.3.7.min.js"></script>

<link rel="stylesheet" media="all" href="<?php echo base_url(); ?>css/font-awesome.css" type="text/css"/>

<?php
error_reporting(1);

$imageUpload = $this->uri->segment(5, 0);
$this->load->view('admin/templates/header.php');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<style type="text/css">
	/* Style the tab */
	div#driver_id_chzn {
    display: none !important;
}
select#driver_id{
    display: block !important;
}
#driver_fields{

}
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
</style>

<!---- for location ---->
<script type="text/javascript" src="<?php echo $protocol; ?>maps.google.com/maps/api/js?sensor=false"></script>
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
$json = file_get_contents($protocol."maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=$google_map_api");
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
				$("#longitude").val(newLongitude);

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
	<div class="widget_top" style="margin-top: 5px; margin-left: 11px; margin-bottom: -20px; width: 98%;">
		<span class="h_icon list"></span>
		<h6>Rentals</h6>
		<a class="suc-pay" href="admin/product/display_product_list/<?php echo $this->uri->segment(4,0); ?>">Back</a>
	</div>
		<div class="grid_12 margin_top_20">

			<input type="hidden" name="experience_id" id="experience_id" value="<?php echo $id; ?>">
			<!---vertical tab-->
			<div class="tab">

				<button class="tablinks <?php echo ($basics == 0) ? '' : ''; ?> " onclick="openContent(event, 'basics',this)" id="basic_tab">
					Basics<?php echo ($basics == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>

				<button class="tablinks <?php echo ($location_tab == 0) ? 'disabled_exp' : ''; ?> " onclick="openContent(event, 'location',this)" id="location_tab">
					Location<?php echo ($location_tab == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($price == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'price',this)" id="price_tab">
					Pricing<?php echo ($price == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
			

				<button class="tablinks <?php echo ($overview == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'overview',this)" id="overview_tab">
					Overview<?php echo ($overview == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($addtional_details == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'addtional_details',this)" id="addtional_details_tab">
					Additional Details<?php echo ($addtional_details == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($photos == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'photos',this)" id="photos_tab">
					Photos<?php echo ($photos == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($amenities == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'amenities',this)" id="amenities_tab">
					Amenities<?php echo ($amenities == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($listings == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'listing',this)" id="listing_tab">
					Listing <?php echo ($listings == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
				<button class="tablinks <?php echo ($cancel_policy == 0) ? 'disabled_exp' : ''; ?>" onclick="openContent(event, 'cancel_policy',this)" id="cancel_policy_tab">
					Cancellation Policy<?php echo ($cancel_policy == 1) ? '<i class="fa fa-check green pull-right" aria-hidden="true"></i>' : ''; ?>
				</button>
			</div>

			<div id="basics" class="tabcontent">
				<h3>Basics <br>  <small>Set the basic mandatory fields of your rentals.</small>
				</h3>

				<form id="basic_form" name="basic_form" method='post' class="form_container left_label listingInfo">
					<?php echo form_hidden('rental_type',$rental_type);?>
					<div class="dashboard_price_right margin_top_20">
						<div class="margin_top_20 margin_bottom_20">
							<span class="error text-center margin_top_20 margin_bottom_20" id="error_basic"> <small> * Please fill all mandatory fields</small> </span>
						</div>
						<ul class="tab-areas1">
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Rentals Owner Name <span class="req">*</span></label>
									<div class="form_input">
										<?php 
										
										if ($id != '' && $id != 0) { ?>
											<input type="hidden" name="org_current_user_id" id="org_current_user_id" value="<?php echo $product_details->row()->OwnerId; ?>">
										<?php } ?>
										<?php
										if (!empty($userdetails)) {
											echo '<select name="user_id" id="current_user_id">';
											?>
												<option value="">--Select--</option>
												<?php
												foreach ($userdetails->result() as $user_details) {
												?>
													<option  value="<?php echo $user_details->id; ?>" <?php if (!empty($product_details)) { if ($user_details->id == $product_details->row()->OwnerId) { echo 'selected="selected"';  } } ?>><?php echo ucfirst($user_details->firstname) . ' ' . ucfirst($user_details->lastname) . '----' . $user_details->email; ?></option>
												<?php
												}
											echo '</select>';
										} ?>
										<span id="owner_update" style="color:green"></span>
									</div>
								</div>
							</li>
							
								<?php

					//	print_r($property_type);
			if (count($property_type) > 0) {
				
				foreach ($property_type as $key => $types) {
					$attr_url = $this->db->select('attribute_seourl')->from('fc_listspace')->where('id',$key)->get()->row();
					
					?>
					<li>
					<div class="form_grid_12">
						<?php 
						if($attr_url->attribute_seourl == 'propertytype'){ ?>
									<label class="field_title" for="user_id"><?php echo $property_label[$key] ?><span class="req">*</span></label>
								<?php } else if($attr_url->attribute_seourl == 'roomtype'){?>
									<label class="field_title" for="user_id"><?php echo $property_label[$key] ?><span class="req">*</span></label>
								<?php } ?>
						<div class="form_input">
						
						<?php
						if($attr_url->attribute_seourl == 'propertytype'){
							if($listDetail->row()->home_type == '')
							{
								$types = array('0' => 'Select') + $types;
							}
							
							?><?php 
							$other_attr = 'id="propertytype"';
							echo form_dropdown('propertytype', $types,$listDetail->row()->home_type,$other_attr);
						}else if($attr_url->attribute_seourl == 'roomtype'){
							if($listDetail->row()->room_type == '')
							{
								$types = array('0' => 'Select') + $types;
							}
							
								?><?php 
								$roomtypeArr = explode(',',$listDetail->row()->room_type);

								$procedure_type_idattr = 'id="roomtype"';
							echo form_dropdown('roomtype', $types,$roomtypeArr,$procedure_type_idattr);
						}
						?>
					</div>
				</div>
				</li>
					<?php
				}
			}
			?>
							
							
							<li>
								<div class="basic-next"> 
									<button class="btn btn-success" type="button"  onclick="validate_form_basic(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
									echo stripslashes($this->lang->line('Save_and_Continue'));  } else echo "Save & Continue"; ?></button>
								</div>
							</li>
						</ul>
					</div>
				</form>
				<script>


				function validate_form_basic(e) {

					// $('.loading').show();

					current_user_id = $('#current_user_id').val();
					p_type = $('#propertytype').val();
					r_type = $('#roomtype').val();
					

					// other = $('#other').val();
					// procedure_type_id = $('#procedure_type_id').val();
					//alert(procedure_type_id);alert(other);return false;|| procedure_type_id == ''
					
					err = 0;
					
					if (current_user_id == '' || p_type == '0' || r_type == '0') {
						err = 1;
					}
				//	alert(err);return false;
					if (err == 1) {
						//$('.error').show();
						 $('.loading').hide();
						$('#error_basic').fadeIn('slow', function () {
							$(this).delay(5000).fadeOut('slow');
						});
						return false;
					} else {
						//return false;
					  <?php if($id!='') { ?>
						url_str = '<?php echo base_url() . "admin/manage_rentals/update_rentals_general".'/'.$id;?>';
						
						$.ajax({
							type: 'POST',
							url: url_str,
							data: $('#basic_form').serialize(),
							dataType: 'json',
							success: function (data) {
								// return false;
								if (data.status == 1) {
									exp_id = data.id;
									window.location.href = '<?php echo base_url() . "admin/manage_rentals/add_new_rentals/1/";?>' + exp_id + '#location_tab';
									$("#location_tab").removeClass("disabled_exp");
									document.getElementById("location_tab").click();
									$('.loading').hide();
								} else {
									$('.loading').hide();
									$('#error_basic').html('Rentals is not submitted. Please try again');
									$('#error_basic').fadeIn('slow', function () {
										$(this).delay(5000).fadeOut('slow');
									});
									return false;
								}
							}
						});
						<?php } else { ?>
						url_str = '<?php echo base_url() . "admin/manage_rentals/add_rentals_new";?>';

						$.ajax({
							type: 'POST',
							url: url_str,
							data: $('#basic_form').serialize(),
							dataType: 'json',
							success: function (data) {
								
								if (data.status == 1) {
									exp_id = data.id;
									window.location.href = '<?php echo base_url() . "admin/manage_rentals/add_new_rentals/1/";?>' + exp_id + '#location_tab';
									$("#location_tab").removeClass("disabled_exp");
									document.getElementById("location_tab").click();
									$('.loading').hide();
								} else {
									$('.loading').hide();
									$('#error_basic').html('Rentals is not submitted. Please try again');
									$('#error_basic').fadeIn('slow', function () {
										$(this).delay(5000).fadeOut('slow');
									});
									return false;
								}
							}
						});
						<?php } ?>

					}
				}



				/*function UpdateExp_Owner() {
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

				*/
			</script>
			</div>
			
			
			<!-- LOCATION -->
			<div id="location" class="tabcontent">
				<h3><?php if ($this->lang->line('Address') != '') { echo stripslashes($this->lang->line('Address'));  } else { echo "Address"; } ?></h3>

				<form id="exp_where_will_meet_form" name="exp_where_will_meet_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
					<input type="hidden" name="" id="edit_pro_id" value="<?php echo $this->uri->segment(5, 0); ?>">
					<input type="hidden" name="latitude" id="latitude" value="<?php if (!empty($product_details)) { echo $product_details->row()->latitude; } ?>">
					<input type="hidden" name="longitude" id="longitude" value="<?php if (!empty($product_details)) { echo $product_details->row()->longitude; } ?>">
					<?php echo form_hidden('rental_type',$rental_type);?>
					<div class="dashboard_price_right">
						<div class="exp_det_right">

							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_location"><small> * Please fill all mandatory fields</small></span>
							</div>

							<ul class="tab-areas2">
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="address">Location <span class="req">*</span></label>
										<div class="form_input">
											<input id="autocomplete-admin" name="address" onblur="getAddressDetails();" placeholder=""  onFocus="geolocate()" type="text"  value="<?php if (!empty($product_details)) { echo trim(stripslashes($product_details->row()->address));  } ?>" style="width:370px;" class="large tipTop"
											title="Enter your Location"><span id="location_error_valid"  style="color:#f00;display:none;"> Only Alphabets allowed!</span>
											<span id="location_error" style="color:red;"> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="country">Country<span class="req">*</span></label>
										<div class="form_input">
											<input placeholder="" id="country" name="country" type="text"  value="<?php if ($productAddressData->row()->country != '') echo $productAddressData->row()->country;  ?>" style="width:370px;" class="large tipTop"  title="Enter Country Name"><span id="country_error_valid"
											style="color:#f00;display:none;">Only Alphabets allowed!</span>
											<span id="country_error" style="color:red;"> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="state">State<span class="req">*</span></label>
										<div class="form_input" id="listCountryCnt">
											<input placeholder="" id="state" name="state" type="text"  value="<?php if ($productAddressData->row()->state != '') echo $productAddressData->row()->state; ?>"  style="width:370px;" class="large tipTop"  title="Enter State Name"><span id="state_error_valid"  style="color:#f00;display:none;">Only Alphabets allowed!</span>
											<span id="state_error" style="color:red;">  </span>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="city">City<span class="req">*</span></label>
										<div class="form_input" id="listStateCnt">
											<input id="city" name="city" type="text" value="<?php if ($productAddressData->row()->city != '') echo $productAddressData->row()->city;
											?>" style="width:370px;" class="large tipTop"  title="Enter City Name">
											<span id="city_error_valid"  style="color:#f00;display:none;">Only Alphabets allowed!</span>
											<span id="city_error" style="color:red;"> </span>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="apt">Street Address</label>
										<div class="form_input">
											<input type="text" name="apt" id="apt" tabindex="3" style="width:370px;"  class="large tipTop" title="Enter the Apt, Suite, Bldg" value="<?php if ($productAddressData->row()->street != '') echo $productAddressData->row()->street; ?>"/> 
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="post_code">Zip Code<span class="req">*</span></label>
										<div class="form_input">
											<input type="text" name="post_code" maxlength="11" id="post_code" tabindex="8" class="large tipTop"  title="Please enter the post code"
											value="<?php if ($productAddressData->row()->zip != '') echo $productAddressData->row()->zip; ?>" required/>
											<span id="post_code_error_valid"  style="color:#f00;display:none;">Only Alphabets allowed!</span>
											<span  id="post_code_length_error" style="color:red;"></span>
										</div>

										<!-- <div style="margin-left:30%;margin-top:10px;">
											<?php 
											if (!empty($product_details)) {  
												$in_address = trim(stripslashes($product_details->row()->address)); ?>
												<img id='map-image' border="0" alt="Greenwich, England"  src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>">

											<?php } ?>
											<div align="center" id="map-new" style="width: 600px; height: 300px; display:none"><p id='map-text' style="margin-top:150px;">Map will be displayed here</p></div>
										</div> -->
										<div id="map" style="width:1050px; height:250px"></div>
									<script
										src='<?php echo $protocol; ?>maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_developer_key'); ?>'>
											</script>
											<script type="text/javascript">
											function load() {
											oldlat = '';
											oldlng = '';
											if (oldlat == '') oldlat = '37.77264';
											if (oldlng == '') oldlng = '-122.40992';
											if (GBrowserIsCompatible()) {
												var map = new GMap2(document.getElementById("map"));
												map.addControl(new GSmallMapControl());
												map.addControl(new GMapTypeControl());
												var center = new GLatLng(oldlat, oldlng);
												map.setCenter(center, 15);
												geocoder = new GClientGeocoder();
												var marker = new GMarker(center, {draggable: true});
												map.addOverlay(marker);
												$("#latitude").val(center.lat().toFixed(5));
												$("#longitude").val(center.lng().toFixed(5));

												GEvent.addListener(marker, "dragend", function () {
													var point = marker.getPoint();
													map.panTo(point);
													$("#latitude").val(point.lat().toFixed(5));
													$("#longitude").val(point.lng().toFixed(5));

												});

											}
										}

										load();
										</script>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button"  onclick="validate_form_where_you_will_meet(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {  echo stripslashes($this->lang->line('Save_and_Continue'));  } else echo "Save & Continue"; ?></button>
										</div>
									</div>
								</li>

							</ul>
							<!-- end ul-->
						</div>
					</div>

				</form>
				<script type="text/javascript">
					function validate_form_where_you_will_meet() {
						$('.loading').show();	
						err = 0;
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


						if (location_data == '' || country == '' || state == '' || city == '' || post_code=='') {
							err = 1;
						}

						if (err == 1) {
							$('.loading').hide();
							$('#error_location').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
						} else {

							if (edit_pro_id != '' && edit_pro_id != '0') {
								$.ajax({
									type: 'post',
									url: baseURL + 'admin/manage_rentals/save_address',
									data: {
										'rental_type':'<?php echo $rental_type;?>',
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
										
   $('.add_new_item').hide();
 
											$("#price_tab").removeClass("disabled_exp");

											document.getElementById("price_tab").click();
											$('.loading').hide();
											$("#location_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
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
								// $("#map-image").hide();
								// $("#map-new").show();
								// initializeMapCircle();
								address = json.city + ',' + json.state + ',' + json.country;
										
											var map = new GMap2(document.getElementById("map"));
											map.addControl(new GSmallMapControl());
											map.addControl(new GMapTypeControl());
											if (geocoder) {
												geocoder.getLatLng(
													address,
													function (point) {
														if (!point) {
															alert("Address " + address + " not found");
															return false;
														} else {
															$("#latitude").val(point.lat().toFixed(5));
															$("#longitude").val(point.lng().toFixed(5));
															map.clearOverlays()
															map.setCenter(point, 14);
															var marker = new GMarker(point, {draggable: true});
															map.addOverlay(marker);

															GEvent.addListener(marker, "dragend", function () {
																var pt = marker.getPoint();
																map.panTo(pt);
																$("#latitude").val(pt.lat().toFixed(5));
																$("#longitude").val(pt.lng().toFixed(5));
															});

														}
													}
												);
											}

							}
						});
					}

					}


				</script>

			</div>
			<!--LOCATION-->


			<!--price_tab_cont-->

			<div id="price" class="tabcontent">
				<h3>Base Price</h3>
				<form id="price_form" name="price_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
				<div class="dashboard_price_right">
						<div class="exp_det_right">
				<ul class="tab-areas2">
					<li>
						<div class="form_grid_12">
							<label class="field_title" for="user_id">Currency<span class="req">*</span></label>
							<div class="form_input">
											 <?php
							                    $currencyattr = 'id="currency"';
							                    echo form_dropdown('currency', $currencytypes, $listDetail->row()->currency,$currencyattr);
							                    ?>
											
							</div>
						</div>
					</li>
					<li>
						<div class="form_grid_12">
							<label class="field_title" for="user_id">Price Per Night<span class="req">*</span></label>
							<div class="form_input">
								<input type="text" name="price" id="price" value="<?php echo $listDetail->row()->price; ?>">
		
								<span class="small_label"><span id="product_title_char_count"></span></span>
							</div>
						</div>
					</li>
					<li>
						<div class="form_grid_12">
							<div class="exp-pic">
								<button class="btn btn-success" type="button" onclick="validate_form_price(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
										echo stripslashes($this->lang->line('Save_and_Continue'));  } else { echo "Save & Continue"; } ?></button>
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
						var currency = $('#currency').val();

						var price = $('input[name="price"]').val();
						
						err = 0;

						if (price == '' || currency == '0') {

							err = 1;$('.loading').hide();
							$('#product_title_char_count').html('Please Fill Mandatory Data');
								$('#product_title_char_count').delay(5000).fadeOut('slow');
								$('#product_title_char_count').show();
								

						}
						
					
						if (err == 1) {
							
							return false;
						} else {
							url = '<?php echo base_url() . "admin/manage_rentals/add_price/" . $id;?>';
							$.ajax({
								type: 'POST',
								url: url,
								data: $('#price_form').serialize(),
								success: function (data) {
									//alert(data);
									if (data == 1) {

										$("#overview_tab").removeClass("disabled_exp");
										document.getElementById("overview_tab").click();
										$('.loading').hide();
											$("#price_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
										
										
									}
								}
							});
						}
					}
					</script>
			</div>
					
			<!-- OVERVIEW -->

			<div id="overview" class="tabcontent">
				<h3>Overview</h3>
				<form id="overview_form" name="overview_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
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
										<label class="field_title" for="user_id">Title <span class="req">*</span></label>
										<div class="form_input">
											<input name="product_title" value="<?php echo $listDetail->row()->product_title; ?>" id="product_title" class="exp_input" placeholder="Title In English" onchange = "check_product_exist()"/>
											<span id="prd_exist_msg" style="display: none;color: red;"> Title already exists</span>
											<span class="small_label"><span  id="product_title_char_count"></span></span>
										</div>
									</div>
								</li>
                                <li>
                                    <div class="form_grid_12">
                                        <label class="field_title" for="user_id">Summary<span class="req"><small style="text-transform: capitalize;">* Maximum 150 words</small></span></label>
                                        <div class="form_input">
                                            <textarea maxlength="200" name="description" id="description_over" class="exp_input" placeholder="Summary In English"><?php echo $listDetail->row()->description; ?></textarea>
                                            <?php
                                            $string = str_replace(' ', '', $listDetail->row()->description);
                                            $len = mb_strlen($string, 'utf8');
                                            $remaining = (200 - $len);
                                            ?>
                                            <span class="small_label"><span  id="description_char_count"></span> </span>
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

                                                    <label class="field_title" for="user_id">Title in (<?php echo $data->name; ?>)<span class="req">*</span></label>
                                                    <div class="form_input">
                                                        <input name="product_title_<?php echo $data->lang_code; ?>" value="<?php

                                                        echo $listDetail->row()->{"product_title_".$data->lang_code};

                                                        ?>" id="product_title_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="Title In <?php echo $data->name; ?>"/>

                                                        <span class="small_label"><span  id="product_title_<?php echo $data->lang_code; ?>_char_count"></span></span>
                                                    </div>

                                            </div>
                                        </li>
                                        <li>
                                            <div class="form_grid_12">

                                                    <label class="field_title" for="user_id">Summary in (<?php echo $data->name; ?>)<span class="req">*</span></label>
                                                    <div class="form_input">
                                                        <textarea maxlength="200" name="description_<?php echo $data->lang_code; ?>" id="description_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="Summary In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"description_".$data->lang_code}; ?></textarea>


                                                        <span class="small_label"><span  id="product_title_char_description_<?php echo $data->lang_code; ?>_count"></span></span>
                                                    </div>

                                            </div>
                                        </li>

                                <?php

                                    }
                                }

                                ?>

								<?php /*<li>
									<div class="form_grid_12">
										<?php  foreach(language_dynamic_enable("product_title", "") as $dynlang) { ?>
										<label class="field_title" for="user_id">Title in (<?php echo $dynlang[0]; ?>)<span class="req">*</span></label>
										<div class="form_input">
											<input name="<?php echo $dynlang[1]; ?>" value="<?php 

												echo $listDetail->row()->{$dynlang[1]}; 

											?>" id="<?php echo $dynlang[1]; ?>" class="exp_input" placeholder="Title In Arabic"/>
											
											<span class="small_label"><span  id="product_title_char_count"></span></span>
										</div>
									<?php } ?>
									</div>
								</li>

								<!-- <li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Summary In Arabic<span class="req">* Maximum 150 words</span></label>
										<div class="form_input">
											<textarea maxlength="200" name="description_ar" id="description_ar" class="exp_input" placeholder="Summary In Arabic"><?php echo $listDetail->row()->description_ar; ?></textarea>
											<?php
											$string = str_replace(' ', '', $listDetail->row()->description_ar);
											$len = mb_strlen($string, 'utf8');
											$remaining = (200 - $len);
											?>
											<span class="small_label"><span  id="description_char_count"></span> </span>
										</div>
									</div>
								</li> -->


								<li>
									<div class="form_grid_12">
										<?php  foreach(language_dynamic_enable("description", "") as $dynlang) { ?>
										<label class="field_title" for="user_id">Summary in (<?php echo $dynlang[0]; ?>)<span class="req">*</span></label>
										<div class="form_input">
											<textarea maxlength="200" name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>" class="exp_input" placeholder="Summary In <?php echo $dynlang[0]; ?>"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
											
											
											<span class="small_label"><span  id="product_title_char_count"></span></span>
										</div>
									<?php } ?>
									</div>
								</li>


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Request to Book<span class="req">*</span></label>
										<div class="form_input">
											<select name="request_to_book" id="request_to_book">
												<option value="Yes" <?php if($listDetail->row()->request_to_book=='Yes') { echo 'selected="selected"'; } ?>>yes</option>
												<option value="No"  <?php if($listDetail->row()->request_to_book=='No') { echo 'selected="selected"'; } ?>>No</option>
											</select>
										</div>
									</div>
								</li>

 */?>
 <li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Request to Book<span class="req">*</span></label>
										<div class="form_input">
											<select name="request_to_book" id="request_to_book">
												<option value="Yes" <?php if($listDetail->row()->request_to_book=='Yes') { echo 'selected="selected"'; } ?>>yes</option>
												<option value="No"  <?php if($listDetail->row()->request_to_book=='No') { echo 'selected="selected"'; } ?>>No</option>
											</select>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Instant Pay<span class="req">*</span></label>
										<div class="form_input">
											<select name="instant_pay" id="instant_pay">
												<option value="No"  <?php if($listDetail->row()->instant_pay=='No') { echo 'selected="selected"'; } ?>>No</option>
												<option value="Yes" <?php if($listDetail->row()->instant_pay=='Yes') { echo 'selected="selected"'; } ?>>yes</option>
												
											</select>

                                            <span class="small_label"><span  id="payment_err"></span> </span>

										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button" onclick="validate_form_overview(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
										echo stripslashes($this->lang->line('Save_and_Continue'));  } else { echo "Save & Continue"; } ?></button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</form>


			<script>

			function validate_form_overview(e) {

				
				$('.loading').show();
				var product_title = $('#product_title').val();
				//var product_title_ar = $('#product_title_ar').val();
				var description = $('#description_over').val();
			//	var description_ar = $('#description_ar').val();
				var request_to_book = $('#request_to_book').val();
				var instant_pay = $('#instant_pay').val();
				err = 0;

				if (product_title == '') {
					$('.loading').hide();
					err = 1;
					$('#product_title_char_count').html('Please Fill Mandatory Data');
						$('#product_title_char_count').delay(5000).fadeOut('slow');
						$('#product_title_char_count').show();
						

				}
				if (description == '') {
					$('.loading').hide();
					err = 1;
					$('#description_char_count').html('Please Fill Mandatory Data');
						$('#description_char_count').delay(5000).fadeOut('slow');
					$('#description_char_count').show();
				}

				if(request_to_book=='No' && instant_pay=='No'){
					$('.loading').hide();
                    err = 1;
                    $('#payment_err').html('Please Activate atleast one payment method');
                    $('#payment_err').delay(5000).fadeOut('slow');
                    $('#payment_err').show();
                }
			
				if (err == 1) {
					
					return false;
				} else {
					url = '<?php echo base_url() . "admin/manage_rentals/add_overview/" . $id;?>';
					$.ajax({
						type: 'POST',
						url: url,
						data: $('#overview_form').serialize(),
						success: function (data) {
							
							if (data == 1) {
								
								$("#addtional_details_tab").removeClass("disabled_exp");
								document.getElementById("addtional_details_tab").click();
								$('.loading').hide();
								$("#overview_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
							}
						}
					});
				}
			}
			</script>

			</div>
			<!-- OVERVIEW -->
			<!-- ADDITAIONAL DETAILS -->
			<div id="addtional_details" class="tabcontent">
				<h3>Additional Details</h3>
				<form id="addtional_details_form" name="addtional_details_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
					<div class="dashboard_price_right">
						<div class="exp_det_right">
							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_addition_det">
								<small>Other information you wish to share on your public listing page</small>
								<!--<small> * Please fill all mandatory fields</small>-->
							</span>
							</div>							
							<ul class="tab-areas2">
								<li>
									<div id="widget_tab" style="float:left">
										
									</div>
									<div class="widget_content">
										
											<ul>	
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">The Space </label>
														<div class="form_input">
															<?= form_textarea(array('name' => 'space', 'id' => 'space', 'rows' => '5', 'placeholder' => "what makes  your listing unique?", 'value' => $listDetail->row()->space)); ?>
														</div>
													</div>
												</li>

												
												
												
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Other things to note</label>									
														<div class="form_input">
															<textarea name="other_thingnote" cols="40" rows="3" id="other_thingnote" class="large tipTop" placeholder="Are there any other details you’d like to share ?" original-title="Are there any other details you’d like to share ?"><?php echo $listDetail->row()->other_thingnote; ?></textarea>
														</div>
													</div>
												</li>

												
<!-- arabic -->
												
												
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">HOUSE RULES </label>									
														<div class="form_input">
															<textarea name="house_rules" cols="40" rows="3" id="house_rules" class="large tipTop" placeholder="How do you expect your guests to behave ?" original-title="How do you expect your guests to behave ?"><?php echo $listDetail->row()->house_rules; ?></textarea>
														</div>
													</div>
												</li>											

												



												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Guest Access <span class="req">*</span></label>									
														<div class="form_input">
															<textarea name="guest_access" cols="40" rows="3" id="guest_access" class="large tipTop" placeholder="How do you expect your guests to behave ?" original-title="How do you expect your guests to behave ?" required><?php echo $listDetail->row()->guest_access; ?></textarea>
														</div>
													</div>
												</li>
												
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Interaction with guest</label>									
														<div class="form_input">
															<textarea name="interact_guest" cols="40" rows="3" id="interact_guest" class="large tipTop" placeholder="Interaction with guest" original-title="Interaction with guest"><?php echo $listDetail->row()->interact_guest; ?></textarea>
														</div>
													</div>
												</li>
												
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Neighborhood</label>									
														<div class="form_input">
															<textarea name="neighbor_overview" cols="40" rows="3" id="neighbor_overview" class="large tipTop" placeholder="Neighborhood" original-title="Neighborhood"><?php echo $listDetail->row()->neighbor_overview; ?></textarea>
														</div>
													</div>
												</li>

												
											
											</ul>
										
										
									</div>
								</li>
 <!-- language -->

								  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>

                                        <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">THE SPACE IN (<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="space_<?php echo $data->lang_code; ?>" id="space_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="space In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"space_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>

												 <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">OTHER THINGS TO NOTE IN(<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="other_thingnote_<?php echo $data->lang_code; ?>" id="other_thingnote_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="other thingnote In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"other_thingnote_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>



                                
												
                                         <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">HOUSE RULES IN (<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="house_rules_<?php echo $data->lang_code; ?>" id="house_rules_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="house rules In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"house_rules_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>
												 <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">GUEST ACCESS IN (<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="guest_access_<?php echo $data->lang_code; ?>" id="guest_access_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="guest access In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"guest_access_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>
												 <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">INTERACTION WITH GUEST
 (<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="interact_guest_<?php echo $data->lang_code; ?>" id="interact_guest_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="interact with guest In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"interact_guest_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>
												 <li style="margin-top: 35px;">
													<div class="form_grid_12">
														
														<label for="bankname" class="field_title">NEIGHBORHOOD (<?php echo $data->name; ?>)</label>
														<div class="form_input">
															 <textarea maxlength="200" name="neighbor_overview_<?php echo $data->lang_code; ?>" id="neighbor_overview_<?php echo $data->lang_code; ?>" class="exp_input" placeholder="neighbor overview In <?php echo $data->name; ?>"><?php echo $listDetail->row()->{"neighbor_overview_".$data->lang_code}; ?></textarea>
														</div>
												
													</div>
												</li>

                                <?php

                                    }
                                }

                                ?>



                               <!-- end of language -->
								
								
								
								
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button" onclick="validate_form_additionalDetails(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
										echo stripslashes($this->lang->line('Save_and_Continue'));  } else { echo "Save & Continue"; } ?></button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</form>


			<script>

			function validate_form_additionalDetails(e) {

				$('.loading').show();
				guest_access = $('#guest_access').val();
				space = $('#space').val();
				err = 0;

				if (guest_access == '') {
					err = 1;
				}
				err = 0;
				if (err == 1) {
					$('.loading').hide();
					$('#error_addition_det').fadeIn('slow', function () {
						$(this).delay(5000).fadeOut('slow');
					});
					return false;
				} else {
					url = '<?php echo base_url() . "admin/manage_rentals/add_addtionalDetail/" . $id;?>';
					$.ajax({
						type: 'POST',
						url: url,
						data: $('#addtional_details_form').serialize(),
						success: function (data) {
							if (data == 1) {
								$("#photos_tab").removeClass("disabled_exp");
								document.getElementById("photos_tab").click();
								$('.loading').hide();
								$("#addtional_details_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
							}
						}
					});
				}
			}
			</script>

			</div>
			<!-- OVERVIEW -->
			<!-- PHOTOS -->
			<div id="photos" class="tabcontent">
				<h3 class="margin_bottom_20">Add photos <br><small> Guests love photos that highlight the features of your space.

                        Please use an image that's at least 600px in width and 400px in height.</small></h3>
				<div class="margin_top_20 margin_bottom_20">
					<span class="error text-center" id="error_image"> <small> * Please fill all mandatory fields</small> </span>
				</div>
				<form id="exp_image_form" name="exp_image_form" method="post" accept-charset="UTF-8"
					  class="form_container left_label listingInfo">
					<ul class="tab-areas2">

						<li>
							<div class="form_grid_12">
								<label class="field_title" for="product_image">Image <span class="req">*</span></label>
								<span class="dragndrop1"><a href="javascript:void(0);" onclick="ImageAddClick();">Choose Image</a></span>
							</div>
						</li>

						<li>
							<div class="widget_content">
								<input type="hidden" name="imagecount" id="imagecount"   value="<?php echo $imgDetail->num_rows(); ?>"/>
								<?php
								///print_r($imgDetail->result_array()); exit;
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
											if (!empty($product_details)) {
												$this->session->set_userdata(array('product_image_' . $product_details->row()->id => $product_details->row()->image));
											
											
											foreach ($imgDetail->result() as $img) {

												if ($img != '') {

													?>
													<tr id="img_<?php echo $img->id ?>">
														<td class="center tr_select "><input type="hidden" name="imaged[]" value="<?php echo $img->product_image; ?>"/> <?php echo $j; ?> </td>
														<td class="center "><img src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "images/rental/" . $img->product_image; ?>"  height="80px" width="80px"/></td>
														<td class="center tr_select">
															<ul class="action_list" style="background:none;border-top:none;">
																<li style="width:100%; border-bottom: none;"><a  class="p_del tipTop" href="javascript:void(0)"  onClick="javascript:DeleteProductImage(<?php echo $img->id; ?>,<?php echo $product_details->row()->id; ?>);"  title="Delete this image">Remove</a></li>
															</ul>
														</td>
													</tr>
													<?php
													$j++;
												}
												$i++;
											}
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
								<label class="field_title">Video URL</label>
								<div class="form_input">
									<input type="text" <?php if (!empty($product_details)) { ?>value="<?php echo $product_details->row()->video_url; ?>"<?php } ?>  placeholder="Enter video link" class="title_overview" name="video_url" id="video_url" style="color:#000 !important;"/>
								</div>
							</div>
						</li>


						<li>
							<div class="form_grid_12">
								<div class="exp-pic">
									<button class="btn btn-success" type="button" onclick="form_dump_video_url(event)"><?php if ($this->lang->line('Save_and_Continue') != '') { echo stripslashes($this->lang->line('Save_and_Continue')); } else { echo "Save and Continue"; } ?></button>
								</div>
							</div>
						</li>
					</ul>
				</form>
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

						url = '<?php echo base_url() . "admin/manage_rentals/add_exp_video_url/" . $id;?>';

						$.ajax({
							type: 'POST',
							url: url,
							data: "video_url=" + video_url,
							success: function (data) {
								if (data == 1) {

									$("#amenities_tab").removeClass("disabled_exp");
									document.getElementById("amenities_tab").click();
									$('.loading').hide();
									$("#photos_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

								}
							}
						});
					} else {
						$("#amenities_tab").removeClass("disabled_exp");
						document.getElementById("amenities_tab").click();
						$('.loading').hide();
					}
				}

				function ImageAddClick() {
					var idval = $('#prdiii').val();
					$(".dragndrop1").colorbox({
						width: "1000px",
						height: "500px",
						href: baseURL + "admin/manage_rentals/dragimageuploadinsert/?id=<?php echo $id;?>" 
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
							url: baseURL + 'admin/manage_rentals/deleteProductImage',
							data: {'prdID': prdID},
							dataType: 'json',
							success: function (json) {


								$('#img_' + prdID).hide();
								$('#img_' + prdID).show().text('Done').delay(800).text('');
								//$('.loading').hide();
								location.reload();

							}
						});
					}
				}
			</script>
			</div>
		
			<!-- EOF PHOTOS -->
			
			<!-- AMENITIES -->
			<div id="amenities" class="tabcontent amenit-list">
				<h3>Amenities</h3>
				<form id="amenities_form" name="amenities_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
					<div class="dashboard_price_right">
						<div class="exp_det_right">
							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_notes">
								<small> * Please fill all mandatory fields</small>
							</span>
							</div>

							<ul class="tab-areas2">
								<?php
								if (!empty($product_details)) {
									$list_name = $product_details->row()->list_name;
									$facility = (explode(",", $list_name));
								}
								?>
								<?php if ($listNameCnt->num_rows() > 0) { ?>
										<?php
										foreach ($listNameCnt->result() as $listVals) {
											$listValues = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => $listVals->id));
											?>
											<?php if ($listValues->row()->list_value != "") { ?>
												<h3 style="text-transform: uppercase;"><?php echo $listVals->attribute_name; ?></h3>
											<?php } ?>
											<?php
											if ($listValues->num_rows() > 0) {
												foreach ($listValues->result() as $details) {
													?>
													<li>
														<label><input type="checkbox" class="checkbox_check" name="list_name[]" id="mostcommon<?php echo $details->id; ?>" <?php if (in_array($details->id, $facility)) { ?> checked="checked" <?php } ?> value="<?php echo $details->id; ?>"/> <span><?php echo $details->list_value; ?></span></label>
													</li>
													<?php
												}
											}
										}
										echo form_input([
											'type' => 'hidden',
											'id' => 'edit_pro_id',
											'value' => $this->uri->segment(4)
										]);
										?>
									
								<?php } ?>
							
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button" onclick="validate_amenities_form(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
										echo stripslashes($this->lang->line('Save_and_Continue'));  } else { echo "Save & Continue"; } ?></button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</form>


				<script>

				function validate_amenities_form(e) {
					$('.loading').show();
					url = '<?php echo base_url() . "admin/manage_rentals/add_amenities/" . $id;?>';
					var list_values = $("input[name='list_name[]']:checked").map(function () {
						return $(this).val();
					}).get();
							
							if(list_values == ''){
								$('.loading').hide();
								alert('You must Choose atleast One Amenities');
								return false;

							}
							
					$.ajax({
						type: 'POST',
						url: url,
						data: {'list_values': list_values, 'pro_id': '<?php echo $id;?>'},
						success: function (data) {
							if (data == 1) {
								$("#listing_tab").removeClass("disabled_exp");
								document.getElementById("listing_tab").click();
								$('.loading').hide();
								$("#amenities_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
							}
						}
					});
				}
				</script>

			</div>
			
			<!-- EOF AMENITIES -->
			<!-- LISTINGS -->
			<div id="listing" class="tabcontent">
				<h3>Listing</h3>
				<form id="listing_form" name="listing_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
					<div class="dashboard_price_right">
						<div class="exp_det_right">
							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_notes_listing">
								<small> * Please fill all mandatory fields</small>
							</span>
							</div>

							<ul class="tab-areas2">
								<?php
								$product_list_data = array();
								$product_list_decode = json_decode($listDetail->row()->listings);
								//echo 'product_list_decode'; print_r($product_list_decode);
								/*
								foreach ($product_list_decode as $product_list_name => $product_list_values) {

									$product_list_data[$product_list_name] = $product_list_values;

								}*/
								foreach ($listTypeValues->result() as $keys => $finals) {
									$name = $finals->name;
									$field_id = $finals->id;
									$selected = $product_list_values;
									$list_type = $finals->type;
									if ($name != 'can_policy') {
										$getChildValues = $this->product_model->get_all_details(LISTING_CHILD, array('parent_id' => $field_id));
										if ($list_type == 'option') {
											if ($getChildValues->num_rows() > 0) {
												?>
												<li>
												<div class="form_grid_12">
													<label class="field_title" for="confirm_email"><?php echo ucfirst(str_replace('_', ' ', $finals->labelname));
														if ($finals->name == 'minimum_stay' || $finals->name == 'accommodates') { ?> <span class="impt">*</span><?php } ?>
													</label>
													<div class="form_input">
														<select class="selectlist_option"   name="<?php echo $finals->name; ?>" data-id="<?php echo $listDetail->row()->id; ?>" data-alt="<?php echo $finals->id; ?>">
															<?php echo '<option value="">'; ?><?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
															<?php 
															foreach($product_list_decode as $product_list_name => $product_list_values)
															{
																$product_list_data[$product_list_name] = $product_list_values;
															} 
															foreach($listchildValues->result() as $val)
															{ 
																if($field_id == $val->parent_id)
																{
															?>
																	<option value="<?php echo $val->id; ?>"  <?php if (in_array($val->id, $product_list_data)) {  echo 'selected="selected"'; }   ?> ><?php echo $val->child_name;  ?></option>

															<?php 
																} 
															} ?>                                       
														</select>
													</div>
												</div>
												</li>
												<?php

											}

										} else {

											$labelField='name';
										?>
										<li>
										<div class="form_grid_12">
											<label class="field_title" for="confirm_email"><?php echo ucfirst(str_replace('_', ' ', $finals->$labelField));
												if ($finals->name == 'minimum_stay') { ?> <span  class="impt">*</span><?php } ?>
											</label>
											<div class="form_input">
											<?php
												echo form_input($finals->name, $product_list_data[$field_id], array('onchange' => "javascript:AdminDetailview(this," . $listDetail->row()->id . ",'" . $finals->id . "')"));
											?>
											</div>
										</div>
										</li>
										<?php
										}
									}
								} ?>
							
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button" onclick="validate_listing_form(event)"><?php if ($this->lang->line('Save_and_Continue') != '') {
										echo stripslashes($this->lang->line('Save_and_Continue'));  } else { echo "Save & Continue"; } ?></button>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</form>


				<script>
// $('select[name="minimum_stay"]').on('change', function(){    
//     var minimum_stay =$(this).val();    
// });
// $('select[name="accommodates"]').on('change', function(){    
//     var accommodates = $(this).val();    
// });
				function validate_listing_form(e) {
					$('.loading').show();

// 					setTimeout(function() {
//   $('.loading').fadeOut('fast');
// }, 30000);
 var minimum_stay = $("select[name='minimum_stay']").val();
 var accommodates = $("select[name='accommodates']").val();
 if(minimum_stay == '' || accommodates == ''){
							$('.loading').hide();
							$('#error_notes_listing').fadeIn('slow', function () {
								$(this).delay(5000).fadeOut('slow');
							});
							return false;
 }
					setTimeout(function() { $(".loading").hide(); }, 3000);

					/*url = '<?php echo base_url() . "admin/manage_rentals/add_listings/" . $id;?>';
					var list_values = $("input[name='list_name[]']:checked").map(function () {
						return $(this).val();
					}).get();
					
					$.ajax({
						type: 'POST',
						url: url,
						data: {'list_values': list_values, 'pro_id': '<?php echo $id;?>'},
						success: function (data) {
							if (data == 1) {
								//$("#cancel_policy_tab").removeClass("disabled_exp");
								//document.getElementById("cancel_policy_tab").click();
								//$("#listing_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');
							}
						}
					});*/

					$("#cancel_policy_tab").removeClass("disabled_exp");
					//$('.loading').hide();
					document.getElementById("cancel_policy_tab").click();

					$("#listing_tab").not(":has(i)").append('<i class="fa fa-check green pull-right" aria-hidden="true"></i>');

				}
				</script>

			</div>
			<!-- EOF LISTINGS -->
			<!-- CANCELLATION POLICY -->
			<div id="cancel_policy" class="tabcontent">
				<h3>Cancellation Policy</h3>
				<form id="exp_cancel_policy_form" name="exp_cancel_policy_form" method="post" accept-charset="UTF-8" class="form_container left_label listingInfo">
					<div class="dashboard_price_right">
						<div class="exp_det_right">
							<div class="margin_top_20 margin_bottom_20">
								<span class="error text-center" id="error_cancel_policy"><small> * Please fill all mandatory fields</small></span>
							</div>
							<ul class="tab-areas2">
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Cancellation Policy <span class="req">*</span></label>
										<div class="form_input">
											<select class="gends" name="cancel_policy" id="cancel_policy_1" onchange="show_val(this);">
												<option value="Flexible" <?php if (!empty($listDetail)) { if ($listDetail->row()->cancellation_policy == 'Flexible') { echo 'selected="selected"'; } } ?>>Flexible</option>
												<option value="Moderate" <?php if (!empty($listDetail)) { if ($listDetail->row()->cancellation_policy == 'Moderate') { echo 'selected="selected"'; } } ?>>Moderate</option>
												<option value="Strict" <?php if (!empty($listDetail)) { if ($listDetail->row()->cancellation_policy == 'Strict') { echo 'selected="selected"'; } } ?>>Strict </option>
											</select>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Security Deposit<span class="req">*</span></label>
										<div class="form_input">
											<input type="text" name="currency" id="can_currency" readOnly value="<?php echo $currentCurrency_type; ?>" style="width:10%;display:inline-block;">
											<input type="text" id="sec_deposit" name="sec_deposit" onchange="javascript:experienceDetailview(this,<?php echo $listDetail->row()->id; ?>,'security_deposit');" value="<?php echo ($listDetail->row()->security_deposit > 0) ? intval($listDetail->row()->security_deposit) : ''; ?>" style="width:78%;display:inline-block;">
										</div>
									</div>
								</li>
								<li>
									<div id="return_amount_percentage"
										 <?php if ($listDetail->row()->cancellation_policy == 'Strict'){ ?>style="display:none" <?php } ?>>
										<div class="form_grid_12">
											<label class="field_title" for="user_id">Return Amount<span class="req">*</span></label>
											<input type="text" maxlength="2" value="<?php echo $listDetail->row()->cancel_percentage; ?>" class="number_field required large tipTop" onkeypress="return check_for_num(event)" id="cancel_percentage" name="cancel_percentage" placeholder="Enter your return amount"/> % <span id="return_amount_error" style="color:red;font-size:12px;" class="error"></span>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Policy Desciption<span class="req">*</span></label>
										<div class="form_input">
											<textarea maxlength="250" onkeyup="char_count(this)" name="cancel_policy_des" id="cancel_policy_des"><?php echo $listDetail->row()->cancel_description; ?></textarea>
											<?php
											$string = str_replace(' ', '', $listDetail->row()->cancel_description);
											$len = mb_strlen($string, 'utf8');
											$remaining = (250 - $len);
											?>
											<span class="small_label"><span id="cancel_policy_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>
										</div>
									</div>
								</li>
								
								<li>
									<div class="form_grid_12">
										<?php  foreach(language_dynamic_enable("cancel_description", "") as $dynlang) { ?>
										<label class="field_title" for="user_id">Policy Desciption in (<?php echo $dynlang[0]; ?>)<span class="req">*</span></label>
										<div class="form_input">
											<textarea maxlength="250" onkeyup="char_count(this)" name="<?php echo $dynlang[1]; ?>" id="<?php echo $dynlang[1]; ?>"><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
											<?php
											$string = str_replace(' ', '', $listDetail->row()->{$dynlang[1]});
											$len = mb_strlen($string, 'utf8');
											$remaining = (250 - $len);
											?>
											
											<span class="small_label"><span id="cancel_policy_des_char_count"><?php echo $remaining; ?></span> characters remaining</span>
										</div>
									<?php } ?>
									</div>
								</li>
								<li>


									<h6  id="addseoLink">Want to <a href="javascript:showSeoDet();">add SEO tags?</a></h6>
								</li>
								<li class="seoDet" style="display:none">
									<h4>SEO Details</h4>
								</li>
								<!-- STARTING META TAGS -->
								<li class="seoDet" style="display:none">
									<div id="widget_tab" style="float:left">
										
									</div>
									<div class="widget_content">
										<div id="seoDet_en_tab" class="active_tab" style="active_tab">
											<ul>							
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Meta Title</label>									
														<div class="form_input">
															<textarea name="meta_title" cols="40" rows="3" id="meta_title" class="large tipTop" ><?php echo $listDetail->row()->meta_title; ?></textarea>
														</div>
													</div>
												</li>
												<li style="margin-top: 35px;">
													<?php  foreach(language_dynamic_enable("meta_title","") as $dynlang) {  ?>
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Meta Title in (<?php echo $dynlang[0];?>)</label>									
														<div class="form_input">
															<textarea name="<?php echo $dynlang[1]; ?>" cols="40" rows="3" id="<?php echo $dynlang[1]; ?>" class="large tipTop" ><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
														</div>
													</div>
												<?php } ?>
												</li>
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Meta Keyword</label>									
														<div class="form_input">
															<textarea name="meta_keyword" cols="40" rows="3" id="meta_keyword" class="large tipTop" ><?php echo $listDetail->row()->meta_keyword; ?></textarea>
														</div>
													</div>
												</li>
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<?php  foreach(language_dynamic_enable("meta_keyword","") as $dynlang) {  ?>
														<label for="bankname" class="field_title">Meta Keyword in (<?php echo $dynlang[0];?>)</label>									
														<div class="form_input">
															<textarea name="<?php echo $dynlang[1]; ?>" cols="40" rows="3" id="<?php echo $dynlang[1]; ?>" class="large tipTop" ><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
														</div>
													<?php } ?>
													</div>
												</li>
												<li style="margin-top: 35px;">
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Meta Description</label>									
														<div class="form_input">
															<textarea name="meta_description" cols="40" rows="3" id="meta_description" class="large tipTop" ><?php echo $listDetail->row()->meta_description; ?></textarea>
														</div>
													</div>
												</li>
												<li style="margin-top: 35px;">
													<?php  foreach(language_dynamic_enable("meta_description","") as $dynlang) {  ?>
													<div class="form_grid_12">
														<label for="bankname" class="field_title">Meta Description in (<?php echo $dynlang[0];?>)</label>									
														<div class="form_input">
															<textarea name="<?php echo $dynlang[1]; ?>" cols="40" rows="3" id="<?php echo $dynlang[1]; ?>" class="large tipTop" ><?php echo $listDetail->row()->{$dynlang[1]}; ?></textarea>
														</div>
													</div>
												<?php } ?>
												</li>
											</ul>
										</div>
										
									</div>
								</li>
								<!-- END OF META TAGS -->
								
								<li>
									<div class="form_grid_12">
										<div class="exp-pic">
											<button class="btn btn-success" type="button" onclick="validate_form_cancel_policy(event)">Save & Continue </button>
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
						//cancel_policy_ar = $('#cancel_policy_ar').val();
						sec_deposit = $('#sec_deposit').val();
						cancel_percentage = $('#cancel_percentage').val();
						// alert(cancel_percentage);return false;
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
							url = '<?php echo base_url() . "admin/manage_rentals/add_cancel_policy/" . $id;?>';

							$.ajax({
								type: 'POST',
								url: url,
								data: $('#exp_cancel_policy_form').serialize(),
								success: function (data) {
									if (data == 1) {
										alert('This rentals Added Successfully');
										$("#basic_tab").removeClass("disabled_exp");
										document.getElementById("basic_tab").click();
										$('.loading').hide();
									}
								}
							});
						}
					}
					function showSeoDet()
					{
						$('.seoDet').toggle();
						if($('.seoDet').is(':visible'))
						{
							$('#addseoLink').html('<a href="javascript:showSeoDet();">Hide SEO tags?</a>');
						}
						else
						{
							$('#addseoLink').html('Want to <a href="javascript:showSeoDet();">add SEO tags?</a>');
						}
					}
				</script>
			</div>
			<!-- EOF CANCELLATION POLICY -->
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
		$('#' + id + '_char_count').text(length);
	}

	$('#product_title_ph').keydown(function (event) {
		var wordLen1 = 8, len1;
		var err1 = 'you can add';
		var err2 = 'more words';
		var err3 = 'Words Reached';
		len1 = $('#product_title_ph').val().split(/[\s]+/);
		if (len1.length > wordLen1) {
		if (event.keyCode == 46 || event.keyCode == 8) {

		/*Allow backspace and delete buttons*/
		}
		else if (event.keyCode < 36 || event.keyCode > 57) { /*all other buttons*/
		event.preventDefault();

		}
		}
		wordsLeft = (wordLen1) - len1.length;
		if (wordsLeft <= 0) {
		document.getElementById("product_title_ph_char_count").innerHTML = "8 " + err3;
		}
		else {
		$("#product_title_ph_char_count").html( err1 + " " + wordsLeft + " " + err2);
		}
	});

	// $('#product_title').keydown(function (event) {
	// 	var wordLen1 = 8, len1;
	// 	var err1 = 'you can add';
	// 	var err2 = 'more words';
	// 	var err3 = 'Words Reached';
	// 	len1 = $('#product_title').val().split(/[\s]+/);
	// 	if (len1.length > wordLen1) {
	// 	if (event.keyCode == 46 || event.keyCode == 8) {

	// 	/*Allow backspace and delete buttons*/
	// 	}
	// 	else if (event.keyCode < 36 || event.keyCode > 57) { /*all other buttons*/
	// 	event.preventDefault();

	// 	}
	// 	}
	// 	wordsLeft = (wordLen1) - len1.length;
	// 	if (wordsLeft <= 0) {
	// 	document.getElementById("product_title_char_count").innerHTML = "8 " + err3;
	// 	}
	// 	else {
	// 	$("#product_title_char_count").html( err1 + " " + wordsLeft + " " + err2);
	// 	}
	// });

	$('#description_ph').keydown(function (event) {
		var wordLen1 = 150, len1;
		var err1 = 'you can add';
		var err2 = 'more words';
		var err3 = 'Words Reached';
		len1 = $('#description_ph').val().split(/[\s]+/);
		if (len1.length > wordLen1) {
		if (event.keyCode == 46 || event.keyCode == 8) {

		/*Allow backspace and delete buttons*/
		}
		else if (event.keyCode < 36 || event.keyCode > 57) { /*all other buttons*/
		event.preventDefault();

		}
		}
		wordsLeft = (wordLen1) - len1.length;
		if (wordsLeft <= 0) {
		document.getElementById("description_ph_char_count").innerHTML = "8 " + err3;
		}
		else {
		$("#description_ph_char_count").html( err1 + " " + wordsLeft + " " + err2);
		}
	});

	// $('#description').keydown(function (event) {
	// 	var wordLen1 = 150, len1;
	// 	var err1 = 'you can add';
	// 	var err2 = 'more words';
	// 	var err3 = 'Words Reached';
	// 	len1 = $('#description').val().split(/[\s]+/);
	// 	if (len1.length > wordLen1) {
	// 	if (event.keyCode == 46 || event.keyCode == 8) {

	// 	/*Allow backspace and delete buttons*/
	// 	}
	// 	else if (event.keyCode < 36 || event.keyCode > 57) { /*all other buttons*/
	// 	event.preventDefault();

	// 	}
	// 	}
	// 	wordsLeft = (wordLen1) - len1.length;
	// 	if (wordsLeft <= 0) {
	// 	document.getElementById("description_char_count").innerHTML = "8 " + err3;
	// 	}
	// 	else {
	// 	$("#description_char_count").html( err1 + " " + wordsLeft + " " + err2);
	// 	}
	// });

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

	$(document).ready(function(){
		$('.selectlist_option').change(function(){
			
			AdminDetailview($(this).val(),$(this).attr('data-id'),$(this).attr('data-alt'));
			
		});
		function AdminDetailview(evt,catID,chk){

			var title = evt;

			$.ajax({

				type:'post',

				url:baseURL+'site/product/Save_Listing_Details',

				data:{'catID':catID,'title':title,'chk':chk,'rental_type':'<?php echo $rental_type;?>'},

				complete:function(){

				//$('#imgmsg_'+catID).hide();

				//$('#imgmsg_'+catID).show().text('Saved');

				}

			});

		}
	});
	$( document ).ready(function() {
   $('.driver_fields').hide();
   $('.add_new_item').hide();
   $('.driver_fields_btn').hide();
   $('.add_new_proceds_btn').hide();
   $('.add_new_proced_item').hide();
   $('.addon_new_item').hide();
   $('.addon_new_item_btn').hide();
	$("#QuesError").hide();
	 $("#newdocError").hide('');
   
   
});
	function check_product_exist()
	{
		var prd = $('#product_title').val();
		//alert(prd)
		$.ajax({
			type : 'post',
			url : baseURL+'admin/product/check_product_exist',
			data : {prd : prd},
			success : function(data)
			{
				//alert(data);
				if(data == 1)
				{
					$('#prd_exist_msg').show();
					$('#product_title').val('');
					return false;
				}else{
					$('#prd_exist_msg').hide();
					return true;
				}
			}
		});
	}
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
