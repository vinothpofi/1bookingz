<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items">
	<?php
	$this->load->view('site/includes/listing_head_side');
	$address = $rental_address->row()->address;
	$street = $rental_address->row()->address;
	$street1 = '';
	$area = $rental_address->row()->area;
	$location = $rental_address->row()->location;
	$city = $rental_address->row()->city;
	$state = $rental_address->row()->state;
	$country = $rental_address->row()->country;
	$lat = $rental_address->row()->lat;
	$long = $rental_address->row()->lang;
	$zip = $rental_address->row()->zip;
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
			<p><?php if ($this->lang->line('Yourexactaddress') != '') {
					echo stripslashes($this->lang->line('Yourexactaddress'));
				} else echo "Your exact address is private and only shared with guests after a reservation is confirmed.However the host are responsible to provide the exact road name of the accommodations in order for guest to be able to plan for their trip smoothly."; ?>
			</p>
			<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
				<p class="text center text-danger" id="danger"></p>
				<p class="text center text-success" id="success"></p>
			</div>
			
			
			
			<?php if ($this->lang->line('AddAddress') != '') {
					$add_add= stripslashes($this->lang->line('AddAddress'));
				} else $add_add= "Add Address"; ?>
			
			<div class="text-right">
				<?php
				$instantpay = array('name' => '', 'value' => " + $add_add", 'data-toggle' => 'modal', 'data-target' => '#addAddress', 'class' => 'submitBtn1 marginBottom3', 'id' => '');
				echo form_submit($instantpay);
				?>
			</div>
			<?php
			if ($rental_address->row()->lat != 0 && $rental_address->row()->lang != 0) {
				?>
				<div id="map" style="width:100%; height:450px"></div>
				<?php
			} ?>
			<!-- Script to intialize google map -->
			<script>
				<?php if ($rental_address->row()->lat != 0 && $rental_address->row()->lang != 0) { ?>
				var myLatlng = new google.maps.LatLng(<?php echo $rental_address->row()->lat;?>,<?php echo $rental_address->row()->lang;?>);

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
										url: baseURL + 'site/product/get_location',
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
												url: '<?php echo base_url()?>site/product/save_lat_lng',
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

				$(function () {
					load_NewMap();
				});
				<?php } ?>
			</script>
			<div class="">
				<?php if ($rental_address->row()->lat == '' || $rental_address->row()->lang == '') {
					?>
					<p class="text-center"><?php if ($this->lang->line('Thislistinghas') != '') {
							echo stripslashes($this->lang->line('Thislistinghas'));
						} else echo "This listing has no address."; ?></p>
				<?php } ?>
			</div>
			<div class="clear text-right">
				<br>
				<?php
					if ($this->lang->line('Continue') != '') {
						$contine= stripslashes($this->lang->line('Continue'));
					} else
						$contine= "Continue";
				?>
				
				<?php
				$listspacesubmit = array('id' => 'list_submit', 'class' => 'submitBtn1','onclick'=>'inloader();');

				//echo anchor('', "$contine", $listspacesubmit);
				?>
				<a style="cursor: pointer;" id="list_submit" class="submitBtn1" onclick="inloader();">Continue</a>
			</div>
		</div>
	</div>
	<div class="rightBlock">
		<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			<?php if ($this->lang->line('YourAddressisPrivate') != '') {
				echo stripslashes($this->lang->line('YourAddressisPrivate'));
			} else echo "Your Address is Private"; ?>
		</h2>
		<p>
			<?php if ($this->lang->line('addresslisting1_give_the_exact') != '') {
				echo stripslashes($this->lang->line('addresslisting1_give_the_exact'));
			} else echo "Give the exact location and address of your property rentals for the guests to locate your address without any trouble."; ?>
		</p>
		<p>
			<?php if ($this->lang->line('addresslisting2_however_the_location') != '') {
				echo stripslashes($this->lang->line('addresslisting2_however_the_location'));
			} else echo "However, the location will be shared only when the reservation is confirmed."; ?>
		</p>
		<!-- <p>
			<?php if ($this->lang->line('Itwillonly') != '') {
				echo stripslashes($this->lang->line('Itwillonly'));
			} else echo "It will only be shared with guests after a reservation is confirmed."; ?>
		</p> -->
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
				
				<h2 class="mHead"><?php echo $add_add; ?></h2>
			</div>
			<div class="modal-body">
				<form name="rental_address" class="formFields" id="rental_address" method="post"
					  action="<?= base_url(); ?>site/product/insert_address" accept-charset="UTF-8">
					<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
					<input type="hidden" name="actual_link" value="<?php echo $actual_link; ?>">
					<div class="form-group">
						<label><?php if ($this->lang->line('Location') != '') {
								echo stripslashes($this->lang->line('Location'));
							} else echo "Location"; ?> <span class="impt"> *</span>
						</label>
						
						
						<?php if ($this->lang->line('Please Enter the Location') != '') {
								$pls_entr= stripslashes($this->lang->line('Please Enter the Location'));
							} else $pls_entr= "Please Enter the Location"; ?>
						<?php
						$modallocation = array('name' => 'address_location', 'id' => 'address_location', 'placeholder' => "$pls_entr", 'required' => 'required', 'value' => $rental_address->row()->address);
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
						
						<?php if ($this->lang->line('Please Enter the County') != '') {
								$pls_entr_con= stripslashes($this->lang->line('Please Enter the County'));
							} else $pls_entr_con= "Please Enter the County"; ?>
					

						<?php
						$modalcountry = array('name' => 'country', 'id' => 'country', 'placeholder' => "$pls_entr_con", 'required' => 'required', 'value' => $country);
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
						
						
						
						<?php if ($this->lang->line('Please Enter the Stat') != '') {
								$pls_entr_st= stripslashes($this->lang->line('Please Enter the Stat'));
							} else $pls_entr_st= "Please Enter the Stat"; ?>
						
						<?php
						$modalstate = array('name' => 'state', 'placeholder' => "$pls_entr_st", 'id' => 'state', 'required' => 'required', 'value' => $state);
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
								$entr_city= stripslashes($this->lang->line('Please Enter the City'));
							} else $entr_city="Please Enter the City"; ?>
							
						<?php
						$modalcity = array('name' => 'city', 'placeholder' => "$entr_city", 'required' => 'required', 'id' => 'city', 'value' => $city);
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
						<label>
						<?php if ($this->lang->line('StreetAddress') != '') {
								echo  stripslashes($this->lang->line('StreetAddress'));
							} else echo "Street Address"; ?>
						</label>
						
						<?php if ($this->lang->line('StreetAddress') != '') {
								$str_addr= stripslashes($this->lang->line('StreetAddress'));
							} else $str_addr= "Street Address"; ?>
						<?php
						$addr = trim($street . ' ' . $street1);
						$modaladdress = array('name' => 'address', 'placeholder' => "$str_addr", 'id' => 'address', 'value' => $addr);
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
								$dt_only= stripslashes($this->lang->line('digit_only'));
							} else $dt_only= "Digit Only"; ?>
						
						
						<?php
						$modalzipcode = array('placeholder' => "e.g. 941 35DD - 3 to 10 $dt_only", 'pattern'=> '[A-Za-z0-9\s-]{3,11}', 'maxlength'=>'11', 'id' => 'post_code', 'onkeypress' => 'return isNumberKey(event);');
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
						   value="<?php echo $rental_address->row()->lat; ?>"/>
					<input type="hidden" name="longitude" id="longitude"
						   value="<?php echo $rental_address->row()->lang; ?>"/>
					<?php
					$instantpay = array('name' => '', 'value' => "$add_add", 'class' => 'submitBtn1', 'onclick' => 'return Address_Validation(this);');
					echo form_submit($instantpay);
					?>
				</form>
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
  function inloader()
		{
			 $('.loading').show();
			// 'cancel_policy/' . $this->uri->segment(2)
			 var listDetailid = '<?= $this->uri->segment(2);?>';
          var base_url = '<?= base_url(); ?>';
        window.location.href=base_url+"cancel_policy/"+listDetailid;

		}
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
	</script>
