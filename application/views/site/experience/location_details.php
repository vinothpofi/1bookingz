<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items">
	<?php
	$this->load->view('site/experience/experience_head_side');
	$address = $Experience_address->row()->address;
	$street = $Experience_address->row()->address;
	$street1 = '';
	$area = $Experience_address->row()->area;
	$location = $Experience_address->row()->location;
	$city = $Experience_address->row()->city;
	$state = $Experience_address->row()->state;
	$country = $Experience_address->row()->country;
	$lat = $Experience_address->row()->lat;
	$long = $Experience_address->row()->lang;
	$zip = $Experience_address->row()->zip;
	?>
	<style>
		.pac-container {
			z-index: 99999;
		}
	</style>
	<div class="centeredBlock">
		<div class="content">
			<h3><?php if ($this->lang->line('Address') != '') {
					echo stripslashes($this->lang->line('Address'));
				} else echo "Address"; ?>
			</h3>
			<p><?php if ($this->lang->line('exp_let_guests_know') != '') {
					echo stripslashes($this->lang->line('exp_let_guests_know'));
				} else echo "Let guests know exactly where you will be meeting. The exact address wont be shared with guests untill the book"; ?></p>
			<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
				<p class="text center text-danger" id="danger"></p>
				<p class="text center text-success" id="success"></p>
			</div>
			<div class="text-right">
			
			  <?php if ($this->lang->line('AddAddress') != '') {
							$add_addr= stripslashes($this->lang->line('AddAddress'));
						} else $add_addr= "Add Address"; ?>
			
				<?php
				$instantpay = array('name' => '', 'value' => "+ $add_addr", 'data-toggle' => 'modal', 'data-target' => '#addAddress', 'class' => 'submitBtn1 marginBottom3', 'id' => 'add-address');
				echo form_submit($instantpay);
				?>
			</div>
			<?php
			if ($Experience_address->row()->lat != 0 && $Experience_address->row()->lang != 0) {
				?>
				<div id="map" style="width:100%; height:450px"></div>
				<script>
					var myLatlng = new google.maps.LatLng(<?php echo ($Experience_address->row()->lat != "") ? $Experience_address->row()->lat : "0.00";?>,<?php echo ($Experience_address->row()->lang != "") ? $Experience_address->row()->lang : "0.00";?>);

					function load_NewMap() { 
						/*Create the map.*/
						var mapOptions = {
							zoom: 15,
							center: myLatlng,
							mapTypeId: google.maps.MapTypeId.ROADMAP
						};

						var map = new google.maps.Map(document.getElementById('map'),
							mapOptions);

						var marker = new google.maps.Marker({
							position: myLatlng,
							draggable: true,
							map: map
						});

						google.maps.event.addListener(marker, 'dragend', function () {
							var newLatitude = this.position.lat();
							var newLongitude = this.position.lng();
							console.log(newLatitude);
							console.log(newLongitude);
							var pos = marker.getPosition();
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
											url: "<?php echo base_url(); ?>site/product/get_location",
											dataType: 'json',
											data: {address: address},
											success: function (json) {
												var street = json.street;
												var area = json.area;
												var location = json.location;
												$("#address").val(street + ' ' + area);
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
														product_id: '<?php echo $listDetail->row()->id; ?>'
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
					}

					load_NewMap();
				</script>
				<?php
			} ?>
			<div class="">
				<?php if ($Experience_address->row()->lat == '' || $Experience_address->row()->lang == '') {
					?>
					<p class="text-center"><?php if ($this->lang->line('ThislExpriencehas') != '') {
							echo stripslashes($this->lang->line('ThislExpriencehas'));
						} else echo "This experience has no address."; ?></p>
				<?php } ?>
			</div>
			<div class="clear text-right">
			
			<?php if ($this->lang->line('Continue') != '') {
							$continue= stripslashes($this->lang->line('Continue'));
						} else $continue= "Continue"; ?>
			
			
				<?php
				$listspacesubmit = array('id' => 'next-btn', 'class' => 'submitBtn1 marginTop1');
				($Experience_address->row()->lat != 0 && $Experience_address->row()->lang != 0) ? $listspacesubmit[""] = "" : $listspacesubmit["disabled"] = "true";
				echo form_submit('list_submit', $continue, $listspacesubmit);
				?>
			</div>
		</div>
	</div>
	<div class="rightBlock">
		<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			<?php if ($this->lang->line('YourAddressisPrivate') != '') {
				echo stripslashes($this->lang->line('YourAddressisPrivate'));
			} else echo "Your Address is Private"; ?>
		</h2>
		<p><?php if ($this->lang->line('Add_the_place_or_the_address') != '') {
				echo stripslashes($this->lang->line('Add_the_place_or_the_address'));
			} else echo "Add the place or the address where exactly you will meet your guests. The address will be shared with the guests only when they book your experience."; ?></p>
	<!-- <p><?php if ($this->lang->line('Itwillonly_new') != '') {
				echo stripslashes($this->lang->line('Itwillonly_new'));
			} else echo "We maintain integrity. Your address will be only shared with the Guests after a booking is confirmed."; ?></p> -->
	</div>
	<i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
</div>
<!-- EditPayout_M Modal -->
<div id="addAddress" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h2 class="mHead"><?php if ($this->lang->line('AddAddress') != '') {
							echo stripslashes($this->lang->line('AddAddress'));
						} else echo "Add Address"; ?></h2>
				
			</div>
			<div class="modal-body">
				<?= form_open('site/experience/insert_address', array('class' => 'formFields', 'id' => 'Experience_address')); ?>

				<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
				<input type="hidden" name="actual_link" value="<?php echo $actual_link; ?>">
				<div class="form-group">
					<label><?php if ($this->lang->line('Location') != '') {
							echo stripslashes($this->lang->line('Location'));
						} else echo "Location"; ?> <span class="impt"> *</span>
					</label>
					
					<?php if ($this->lang->line('Please Enter the Location') != '') {
							$enter_loc= stripslashes($this->lang->line('Please Enter the Location'));
						} else $enter_loc= "Please Enter the Location"; ?>
					
					
					<?php
					$modallocation = array('name' => 'address_location', 'id' => 'address_location', 'placeholder' => $enter_loc, 'required' => 'required', 'value' => $Experience_address->row()->address);
					echo form_input($modallocation);
					?>
					<span id="location_error" style="color:#f00;display:none;">*
						<?php
						if ($this->lang->line('charecters_only') != '') {
							echo stripslashes($this->lang->line('charecters_only'));
						} else {
							echo "Characters Only";
						}
						?>!</span>
				</div>
				<div class="form-group">
					<label><?php if ($this->lang->line('Country') != '') {
							echo stripslashes($this->lang->line('Country'));
						} else echo "Country"; ?> <span class="impt"> *</span>
					</label>
					
					<?php if ($this->lang->line('country_enter') != '') {
							$country_enter = stripslashes($this->lang->line('country_enter'));
						} else $country_enter =  "Please Enter the Country"; ?>
					
					<?php
					$modalcountry = array('name' => 'country', 'id' => 'country', 'placeholder' => $country_enter, 'required' => 'required', 'value' => $country);
					echo form_input($modalcountry);
					?>
					<span id="country_error" style="color:#f00;display:none;">*
						<?php
						if ($this->lang->line('charecters_only') != '') {
							echo stripslashes($this->lang->line('charecters_only'));
						} else {
							echo "Characters Only";
						}
						?>!
			</span>
				</div>
				<div class="form-group">
					<label><?php if ($this->lang->line('State') != '') {
							echo stripslashes($this->lang->line('State'));
						} else echo "State"; ?> <span class="impt"> *</span>
					</label>
					
					<?php if ($this->lang->line('Please Enter the State') != '') {
							$enter_state = stripslashes($this->lang->line('Please Enter the State'));
						} else $enter_state =  "Please Enter the State"; ?>
						
						
					<?php
					$modalstate = array('name' => 'state', 'placeholder' => $enter_state, 'id' => 'state', 'required' => 'required', 'value' => $state);
					echo form_input($modalstate);
					?>
					<span id="country_error" style="color:#f00;display:none;">*
						<?php
						if ($this->lang->line('charecters_only') != '') {
							echo stripslashes($this->lang->line('charecters_only'));
						} else {
							echo "Characters Only";
						}
						?>!
			</span>
				</div>
				<div class="form-group">
					<label><?php if ($this->lang->line('City') != '') {
							echo stripslashes($this->lang->line('City'));
						} else echo "City"; ?> <span class="impt"> *</span>
					</label>
					
					
					<?php if ($this->lang->line('Please Enter the City') != '') {
							$enter_city = stripslashes($this->lang->line('Please Enter the City'));
						} else $enter_city =  "Please Enter the City"; ?>
						
					
					<?php
					$modalcity = array('name' => 'city', 'placeholder' => $enter_city, 'required' => 'required', 'id' => 'city', 'value' => $city);
					echo form_input($modalcity);
					?>
					<span id="country_error" style="color:#f00;display:none;">*
						<?php
						if ($this->lang->line('charecters_only') != '') {
							echo stripslashes($this->lang->line('charecters_only'));
						} else {
							echo "Characters Only";
						}
						?>!
			</span>
				</div>
				<div class="form-group">
					<label><?php if ($this->lang->line('StreetAddress') != '') {
							echo stripslashes($this->lang->line('StreetAddress'));
						} else echo "Street Address"; ?>
					</label>
					
					<?php if ($this->lang->line('StreetAddress') != '') {
							$streetAddr = stripslashes($this->lang->line('StreetAddress'));
						} else $streetAddr =  "Street Address"; ?>
					
					<?php
					$addr = trim($street . ' ' . $street1);
					$modaladdress = array('name' => 'address', 'placeholder' => $streetAddr , 'id' => 'address', 'value' => $addr);
					echo form_input($modaladdress);
					?>
					<span id="address_error"
						  style="color:#f00;display:none;">*<?php if ($this->lang->line('charecters_and_numbers_only') != '') {
							echo stripslashes($this->lang->line('charecters_and_numbers_only'));
						} else echo "Characters and Numbers Only"; ?>!
			</span>
				</div>
				<div class="form-group">
					<label><?php if ($this->lang->line('ZIPCode') != '') {
							echo stripslashes($this->lang->line('ZIPCode'));
						} else echo "ZIP Code"; ?>
					</label>
					<?php if ($this->lang->line('digit_only') != '') {
							$digit_only= stripslashes($this->lang->line('digit_only'));
						} else $digit_only= "Digit Only"; ?>
					
					
					<?php
					$modalzipcode = array('placeholder' => "e.g. 941 35DD - 3 to $digit_only", 'id' => 'post_code', 'onkeypress' => 'return isNumberKey(event);');
					echo form_input('post_code', $zip, $modalzipcode);
					?>
					<span id="post_code_error"
						  style="color:#f00;display:none;">*<?php if ($this->lang->line('charecters_and_numbers_only') != '') {
							echo stripslashes($this->lang->line('charecters_and_numbers_only'));
						} else echo "Characters and Numbers Only"; ?>!
			</span>
				</div>
				<input type="hidden" name="product_id" value="<?php echo $listDetail->row()->id; ?>"/>
				<input type="hidden" name="latitude" id="latitude"
					   value="<?php echo $Experience_address->row()->lat; ?>"/>
				<input type="hidden" name="longitude" id="longitude"
					   value="<?php echo $Experience_address->row()->lang; ?>"/>
					   
					   <?php if ($this->lang->line('AddAddress') != '') {
							$add_addr= stripslashes($this->lang->line('AddAddress'));
						} else $add_addr= "Add Address"; ?>
					   
				<?php
				$instantpay = array('name' => '', 'value' => $add_addr, 'class' => 'submitBtn1', 'onclick' => 'return Address_Validation(this);');
				echo form_submit($instantpay);
				echo form_close();
				?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var autocomplete;
		var componentForm = {
			route: 'long_name',
			locality: 'long_name',
			administrative_area_level_1: 'long_name',
			country: 'long_name',
			postal_code: 'short_name'
		};

		function initAutocomplete() {
			autocomplete = new google.maps.places.Autocomplete(
				(document.getElementById('address_location')),
				{types: ['geocode']});
			autocomplete.addListener('place_changed', fillInAddress);
		}

		initAutocomplete();

		function isNumberKey(post_code) {
			var k;
			document.all ? k = e.keyCode : k = e.which;
			return ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || (k >= 48 && k <= 57));
		}

		$("#country").on('keyup', function (e) {
			var val = $(this).val();
			if (val.match(/[^a-zA-Z.\s]/g)) {
				document.getElementById("country_error").style.display = "inline";
				$("#country").focus();
				$("#country_error").fadeOut(5000);
				$(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
			}
		});
		$("#state").on('keyup', function (e) {
			var val = $(this).val();
			if (val.match(/[^a-zA-Z.\s]/g)) {
				document.getElementById("state_error").style.display = "inline";
				$("#state").focus();
				$("#state_error").fadeOut(5000);
				$(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
			}
		});
		$("#city").on('keyup', function (e) {
			var val = $(this).val();
			if (val.match(/[^a-zA-Z.\s]/g)) {
				document.getElementById("city_error").style.display = "inline";
				$("#city").focus();
				$("#city_error").fadeOut(5000);
				$(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
			}
		});
		$("#address").on('keyup', function (e) {
			var val = $(this).val();
			if (val.match(/[^a-zA-Z.\s1-9]/g)) {
				document.getElementById("address_error").style.display = "inline";
				$("#address").focus();
				$("#address_error").fadeOut(5000);
				$(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
			}
		});
		$("#post_code").on('keyup', function (e) {
			var val = $(this).val();
			if (val.match(/[^a-zA-Z.-\s0-9]/g)) {
				document.getElementById("post_code_error").style.display = "inline";
				$("#post_code").focus();
				$("#post_code_error").fadeOut(5000);
				$(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
			}
		});
		/*Next button*/
		$(document).ready(function () {
			$('#next-btn').click(function (e) {
				$('.loading').show();
				window.location.href = '<?php echo base_url() . "what_you_will_provide/" . $id; ?>';
			});
		});
	</script>
