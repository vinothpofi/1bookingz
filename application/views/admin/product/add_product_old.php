<style>
.widget_content .form_container ul.tab-areas3 li {
    float: left;
    width: 30%;
	margin-left:20px;
}
</style>
<?php
$imageUpload = $this->uri->segment(5, 0);
$this->load->view('admin/templates/header.php');
foreach ($listDetail->result() as $product_listing) {
	$product_list_values = $product_listing->listings;
}
foreach ($listValues->result() as $result) {
	$values = $result->listing_values;
}
foreach ($listchildValues->result() as $result) {
	$values1 = $result->id;
}
?>
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
if ($city == '') {
	$city = $location;
}
$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
$lang = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
$bedrooms = "";
$beds = "";
$bedtype = "";
$bathrooms = "";
$noofbathrooms = "";
$min_stay = "";
$accommodates = "";
$can_policy = "";
if ($listValues->num_rows() == 1) {
	$roombedVal = json_decode($listValues->row()->rooms_bed);
	$bedrooms = $roombedVal->bedrooms;
	$beds = $roombedVal->beds;
	$bedtype = $roombedVal->bedtype;
	$bathrooms = $roombedVal->bathrooms;
	$noofbathrooms = $roombedVal->noofbathrooms;
	$min_stay = $roombedVal->min_stay;
	$accommodates = $roombedVal->accommodates;
	$can_policy = $roombedVal->can_policy;
}
?>

<?php if ($lat != '' && $lang != '') { ?>
	<script>
		var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);

		var citymap = {};

		function initializeMapCircle() {

			/*Create the map.*/
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
								url: baseURL + 'site/product/get_location',
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

			/*Construct the circle for each value in citymap.*/
			/*Note: We scale the area of the circle based on the population.*/
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
				/*Add the circle for this city to the map.*/
				cityCircle = new google.maps.Circle(populationOptions);
			}
		}
	</script>
<?php } else { ?>
	<script>
		var myLatlng = new google.maps.LatLng(32, 72);
		var citymap = {};

		function initializeMapCircle() {

			/*Create the map.*/
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
								url: baseURL + 'site/product/get_location',
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

			/*Construct the circle for each value in citymap.
			Note: We scale the area of the circle based on the population.*/
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
				/*Add the circle for this city to the map.*/
				cityCircle = new google.maps.Circle(populationOptions);
			}
		}
	</script>
<?php } ?>
<script type="text/javascript">
	function list_amenities(evt) {
		if ($(evt).is(":checked")) {
			var am = $(evt).val();

			$.ajax({
				type: 'POST',
				url: baseURL + 'admin/product/get_sublist_values',
				data: {"list_value_id": am},
				dataType: 'json',
				success: function (response) {
					$(evt).parents('li').append(response.amenities);
				}
			});
		}
		else {
			$(evt).parents('li').find('ul').remove();
		}
	}


	function ImageAddClick() {
		var idval = $('#prdiii').val();

		$(".dragndrop1").colorbox({
			width: "1000px",
			height: "500px",
			href: baseURL + "admin/product/dragimageuploadinsert/?id=" + idval
		});
	}
</script>
<script type="text/javascript">
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
					/*don't know how to proceed to assign src to image tag*/
				}
				else {
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
</script>
<script type="text/javascript">
	function updateDatabase(newLat, newLng) {

		$('#latitude').val(newLat);
		$('#longitude').val(newLng);
		/*make an ajax request to a PHP file
        on our site that will update the database
        pass in our lat/lng as parameters*/

	}
</script>
</head>
<style>
	.form_container ul li {
		position: static;
	}

	#map_canvas {
		width: 50% !important;
	}
</style>
<script>
	$(document).ready(function () {
		$('.nxtTab').click(function () {

			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.next().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
		});
		$('.prvTab').click(function () {
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.prev().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
		});
		$('#tab2 input[type="checkbox"]').click(function () {
			var cat = $(this).parent().attr('class');
			var curCat = cat;
			var catPos = '';
			var added = '';
			var curPos = curCat.substring(3);
			var newspan = $(this).parent().prev();
			if ($(this).is(':checked')) {
				while (cat != 'cat1') {
					cat = newspan.attr('class');
					catPos = cat.substring(3);
					if (cat != curCat && catPos < curPos) {
						if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) {
							//Found it!
						} else {
							newspan.find('input[type="checkbox"]').attr('checked', 'checked');
							added += catPos + ',';
						}
					}
					newspan = newspan.prev();
				}
			} else {
				var newspan = $(this).parent().next();
				if (newspan.get(0)) {
					var cat = newspan.attr('class');
					var catPos = cat.substring(3);
				}
				while (newspan.get(0) && cat != curCat && catPos > curPos) {
					newspan.find('input[type="checkbox"]').attr('checked', this.checked);
					newspan = newspan.next();
					cat = newspan.attr('class');
					catPos = cat.substring(3);
				}
			}
		});
		<?php if($imageUpload != '0' && $imageUpload == 'image'){?>
		$('#nextImage').click();
		<?php } ?>
	});
</script>
<script language="javascript">
	function viewAttributes(Val) {

		if (Val == 'show') {
			document.getElementById('AttributeView').style.display = 'block';
		} else {
			document.getElementById('AttributeView').style.display = 'none';
		}
	}
</script>
<script>
	$(document).ready(function () {
		var i = 1;
		$('#add').click(function () {

			$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">' +
				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">' +
				'<span>List Name:</span>&nbsp;' +
				'<select name="attribute_name[]" onchange="javascript:loadListValues(this)" style="width:200px;color:gray;width:206px;" class="chzn-select">' +
				'<option value="">--Select--</option>' +
				<?php foreach ($atrributeValue->result() as $attrRow){
				if (strtolower($attrRow->attribute_name) != 'price'){
				?>
				'<option value="<?php echo $attrRow->id; ?>"><?php echo $attrRow->attribute_name; ?></option>' +
				<?php }} ?>
				'</select>' +
				'</div>' +
				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >' +
				'<span>List Value :</span>&nbsp;' +
				'<select name="attribute_val[]" style="width:200px;color:gray;width:206px;" class="chzn-select">' +
				'<option value="">--Select--</option>' +
				'</select>' +
				'</div>' +
				'</div>').fadeIn('slow').appendTo('.inputs');
			i++;
		});

		$('#remove').click(function () {
			$('.field:last').remove();
		});

		$('#reset').click(function () {
			$('.field').remove();
			$('#add').show();
			i = 0;
		});


		var j = 1;
		$('#addAttr').click(function () {
			$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">' +
				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">' +
				'<span>Attribute Name:</span>&nbsp;' +
				'<select name="product_attribute_name[]" style="width:200px;color:gray;width:206px;" class="chzn-select">' +
				'<option value="">--Select--</option>' +
				<?php foreach ($PrdattrVal->result() as $prdattrRow){ ?>
				'<option value="<?php echo $prdattrRow->id; ?>"><?php echo $prdattrRow->attr_name; ?></option>' +
				<?php } ?>
				'</select>' +
				'</div>' +
				'<div class="attribute_box attrInput" style="float: left;margin: 5px;" >' +
				'<span>Attribute Price :</span>&nbsp;' +
				'<input type="text" name="product_attribute_val[]" style="width:75px;color:gray;" class="chzn-select" />' +
				'</div>' +
				'</div>').fadeIn('slow').appendTo('.inputss');
			j++;
		});

		$('#removeAttr').click(function () {
			$('.field:last').remove();
		});


	});
</script>
<script>
	function runScript(event) {
		if (event.keyCode == 13) {
			var tb = document.getElementById("product_title");
			eval(tb.value);
			return false;
		}

		if (!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))) {
			event.returnValue = false;
			return;
		}
		event.returnValue = true;
	}
</script>
<script src="js/addProperty.js"></script>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<?php if (!empty($product_details)) { ?>
						<h6>Edit Rental</h6>
					<?php } else { ?>
						<h6>Add New Rental</h6>
					<?php } ?>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Rental General Information</a></li>
							<li><a href="#tab2">Images</a></li>
							<li><a href="#tab3">Amenities</a></li>
							<li><a href="#tab4">Address & Availability Information</a></li>
							<li><a href="#tab5">Listing</a></li>
							<li><a href="#tab6">Detailed description</a></li>
							<li><a href="#tab7">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label listingInfo', 'id' => 'addproduct_form1111', 'enctype' => 'multipart/form-data', 'onkeypress' => 'return event.keyCode != 13;', 'accept-charset' => 'UTF-8');
					echo form_open('admin/product/UpdateProduct', $attributes);
					$ltvalue = "";
					if ($productOldAddress->row()->latitude != '') {
						$ltvalue = $productOldAddress->row()->latitude;
					} else {
						$ltvalue = $lat;
					}
					echo form_input([
						'type' => 'hidden',
						'name' => 'latitude',
						'id' => 'latitude',
						'value' => $ltvalue
					]);
					$lonvalue = "";
					if ($productOldAddress->row()->longitude != '') {
						$lonvalue = $productOldAddress->row()->longitude;
					} else {
						$lonvalue = $lang;
					}
					echo form_input([
						'type' => 'hidden',
						'name' => 'longitude',
						'id' => 'longitude',
						'value' => $lonvalue
					]);
					$prdvalue = "";
					if (!empty($product_details)) {
						$prdvalue = trim(stripslashes($product_details->row()->id));
					} else {
						$prdvalue = 0;
					}
					echo form_input(array(
						'type' => 'hidden',
						'name' => 'prdiii',
						'id' => 'prdiii',
						'value' => $prdvalue
					));
					if (!empty($product_details)) {
						$status = $product_details->row()->status;
						if ($status == 'UnPublish') { ?>
							<h4 style="color:red"> By default The Rental Is UnPublished. <br>Please Make It Publish once You Completed All The Forms...!</h4>
							<br>
							<?php
						}
					} ?>
					<div id="tab1">
						<ul class="tab-areas1">
							<li>
								<div class="form_grid_12">
									<?php
									$commonclass = array('class' => 'field_title');
									echo form_label('Rental Owner Name <span class="req">*</span>', 'user_id', $commonclass);
									?>
									<div class="form_input wdth_slct">
										<?php
										if (!empty($userdetails)) {
											$ownrnme = array();
											
											$ownrnme[''] = '--Select--';
											foreach ($userdetails->result() as $user_details) {
												$ownrnme[$user_details->id] = ucfirst($user_details->firstname) . ' ' . ucfirst($user_details->lastname) . '----' . $user_details->email;
											}
											
											$ownrattr = array(
												'id' => 'current_user_id'
											);
											
											
											if (!empty($product_details)) {
												echo form_dropdown('user_id', $ownrnme, $product_details->row()->user_id, $ownrattr);
											}else{
												echo form_dropdown('user_id', $ownrnme, $ownrattr);
											}
										}
										
										
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Title <span class="req">*</span>', 'product_title', $commonclass);
									?>
									<div class="form_input">
										<?php
										$titlvalue = "";
										if (!empty($product_details)) {
											$Valid = trim(stripslashes($product_details->row()->id));
											$titlvalue = trim(stripslashes($product_details->row()->product_title));
										} else {
											$Valid = 0;
										}
										echo form_input(array(
											'type' => 'text',
											'name' => 'product_title',
											'id' => 'product_title',
											'onchange' => "javascript:AdminDetailview(this,document.getElementById('" . prdiii . "').value,'" . title . "');",
											'class' => 'required large tipTop',
											'tabindex' => '1',
											'title' => 'Please enter the Rental name',
											'onkeydown' => 'return (event.keyCode!=13);',
											'value' => $titlvalue
										));
										$prdterr = array('class' => 'error', 'id' => 'product_title_error');
										echo form_label('Maximum 8 Words', '', $prdterr);
										?>
										<span id="title_error" style="color:red;font-size:12px;" class="error"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Title (Arabic) <span class="req">*</span>', 'product_title_ar', $commonclass);
									?>
									<div class="form_input">
										<?php
										$titlvalue_ar = "";
										if (!empty($product_details)) {
											$Valid = trim(stripslashes($product_details->row()->id));
											$titlvalue = trim(stripslashes($product_details->row()->product_title_ar));
										} else {
											$Valid = 0;
										}
										echo form_input(array(
											'type' => 'text',
											'name' => 'product_title_ar',
											'id' => 'product_title_ar',
											'onchange' => "javascript:AdminDetailview(this,document.getElementById('" . prdiii . "').value,'" . title . "');",
											'class' => 'required large tipTop',
											'tabindex' => '1',
											'title' => 'Please enter the Rental name in Arabic',
											'onkeydown' => 'return (event.keyCode!=13);',
											'value' => $titlvalue_ar
										));
										$prdterr = array('class' => 'error', 'id' => 'product_title_ar_error');
										echo form_label('Maximum 8 Words', '', $prdterr);
										?>
										<span id="title_error" style="color:red;font-size:12px;" class="error"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Summary <span class="req">*</span>', 'description', $commonclass);
									?>
									<div class="form_input">                                <?php
										$smmrvalue = "";
										if (!empty($product_details)) {
											$smmrvalue = trim(stripslashes($product_details->row()->description));
										}
										$smmryattr = array(
											'name' => 'description',
											'id' => 'description',
											'tabindex' => '2',
											'class' => 'large tipTop dscptn_wdth',
											'rows' => 2,
											'title' => 'Please enter the Rental description',
											'value' => $smmrvalue
										);
										echo form_textarea($smmryattr);
										?>
										<span id="summary_error" style="color:red;font-size:12px;" class="error"></span>
										<?php
										$smmrerr = array('class' => 'error', 'id' => 'description_length_error', 'style' => 'display:none;');
										echo form_label('Only 150 words are allowed', '', $smmrerr);
										?>
										</br></br>
										<small>Maximum 150 words</small>
										<br><span class="words-left"> </span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Summary (Arabic) <span class="req">*</span>', 'description_ar', $commonclass);
									?>
									<div class="form_input">                                <?php
										$smmrvalue_ar = "";
										if (!empty($product_details)) {
											$smmrvalue = trim(stripslashes($product_details->row()->description_ar));
										}
										$smmryattr = array(
											'name' => 'description_ar',
											'id' => 'description_ar',
											'tabindex' => '2',
											'class' => 'large tipTop dscptn_wdth',
											'rows' => 2,
											'title' => 'Please enter the Rental description',
											'value' => $smmrvalue_ar
										);
										echo form_textarea($smmryattr);
										?>
										<span id="summary_error" style="color:red;font-size:12px;" class="error"></span>
										<?php
										$smmrerr_ar = array('class' => 'error', 'id' => 'description_length_ar_error', 'style' => 'display:none;');
										echo form_label('Only 150 words are allowed', '', $smmrerr_ar);
										?>
										</br></br>
										<small>Maximum 150 words</small>
										<br><span class="words-left"> </span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Currency <span class="req">*</span>', 'currency', $commonclass);
									?>
									<div class="form_input wdth_slct">
										<?php
										if (!empty($currencyList)) {
											$currny = array();
											$slctcurr = "";
											$currny[''] = '--Select--';
											foreach ($currencyList->result() as $currencies) {
												$currny[$currencies->currency_type] = $currencies->currency_type;
											}
											if (!empty($product_details)) {
												if ($currencies->currency_type == $product_details->row()->currency) {
													$slctcurr = $product_details->row()->currency;
												}
											}
											$currattr = array(
												'id' => 'currency'
											);
											echo form_dropdown('currency', $currny, (!empty($product_details)) ? $product_details->row()->currency : '', $currattr);
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Price per night <span class="req">*</span>', 'price', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_label('<span class="req"></span>', 'price');
										$perpriceval = "";
										if (!empty($product_details)) {
											$perpriceval = trim(stripslashes($product_details->row()->price));
										}
										echo form_input([
											'type' => 'text',
											'name' => 'price',
											'id' => 'price',
											'tabindex' => '3',
											'class' => 'tipTop required large',
											'onkeypress' => 'return validateFloatKeyPress(this,event);',
											'title' => 'Please enter the Rental price',
											'value' => $perpriceval
										]);
										$priceerr = array('class' => 'error', 'id' => 'price_error_valid', 'style' => 'display:none;');
										echo form_label('Only Numbers are allowed', '', $priceerr);
										$hiddnprcvl = "";
										if (!empty($product_details)) {
											$hiddnprcvl = trim(stripslashes($product_details->row()->price));
										}
										echo form_input([
											'type' => 'hidden',
											'id' => 'hidden_price',
											'style' => 'width:295px',
											'class' => 'required large tipTop',
											'title' => 'Please enter the Rental price',
											'value' => $hiddnprcvl
										]);
										?>
										<span id="price_error" style="color:red;font-size:12px;" class="error"></span>
										</br></br>
										<small>Set The Default Nightly Price Guests Will See For Your Listing
										</small>
									</div>
								</div>
							</li>
							<li style="display:none;">
								<div class="form_grid_12">
									<?php
									echo form_label('Long-Term Prices', 'price_perweek');
									?>
									<div class="form_input">
										<?php
										$prcwk = "";
										$prcmnt = "";
										if (!empty($product_details)) {
											$prcwk = trim(stripslashes($product_details->row()->price_perweek));
											$prcmnt = trim(stripslashes($product_details->row()->price_permonth));
										}
										echo form_input([
											'type' => 'hidden',
											'name' => 'price_perweek',
											'id' => 'price_perweek',
											'placeholder' => 'Per Week',
											'class' => 'large tipTop',
											'tabindex' => '10',
											'title' => 'Please enter the Rental Price Per Week',
											'value' => $prcwk,
											'onchange' => "javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_perweek');"
										]);
										echo form_input([
											'type' => 'hidden',
											'name' => 'price_permonth',
											'id' => 'price_permonth',
											'placeholder' => 'Per Month',
											'class' => 'large tipTop',
											'tabindex' => '11',
											'title' => 'Please enter the Rental Price Per Month',
											'value' => $prcmnt,
											'onchange' => "javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price_permonth');"
										]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Deposit Amount <span class="req">*</span>', 'price', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_label('<span class="req"></span>', 'price');
										$scrdptval = "";
										if (!empty($product_details)) {
											if ($product_details->row()->security_deposit != '') {
												$scrdptval = trim(stripslashes($product_details->row()->security_deposit));
											}
										}
										echo form_input([
											'type' => 'text',
											'name' => 'security_deposit',
											'id' => 'security_deposit',
											'style' => 'width: 379px;',
											'class' => 'required large tipTop',
											'tabindex' => '4',
											'title' => 'Please enter the deposit amount',
											'value' => $scrdptval
										]);
										?>
										<?php
										$smmrerr = array('class' => 'error', 'id' => 'security_deposit_error', 'style' => 'font-size:12px;display:none;');
										echo form_label('Only
													Numbers are allowed', '', $smmrerr);
										?>
										<span id="security_deposit_error" style="color:red;font-size:12px;"
											  class="error"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Cancellation Policy <span class="req">*</span>', 'user_id', $commonclass);
									?>
									<div class="form_input wdth_slct">
										<?php
										$plcy = array();
										$slctplcy = "";
										if (!empty($product_details)) {
											$slctplcy = $product_details->row()->cancellation_policy;
										}
										$plcy = array(
											'' => '--Select--',
											'Flexible' => 'Flexible',
											'Moderate' => 'Moderate',
											'Strict' => 'Strict'
											//'No Refund' => 'No Refund'
										);
										$plcyattr = array(
											'id' => 'cancellation_policy',
											'class' => 'gends',
											'onchange' => 'show_val(this);'
										);
										echo form_dropdown('cancellation_policy', $plcy, $slctplcy, $plcyattr);
										?>
									</div>
								</div>
							</li>
							<li>
								<div id="return_amount_percentage" <?php if (!empty($product_details)){
								if ($product_details->row()->cancellation_policy == 'Strict'){ ?>style="display:none" <?php }
								} ?>>
									<div class="form_grid_12">
										<?php
										echo form_label('Return Amount <span class="req">*</span>', 'user_id', $commonclass);
										echo form_input([
											'type' => 'text',
											'name' => 'cancel_percentage',
											'id' => 'return_amount',
											'style' => 'width:35% !important;',
											'class' => 'number_field2 required large tipTop',
											'maxlength' => '2',
											'title' => 'Enter your return amount',
											'onkeypress' => 'return check_for_num(event);',
											'placeholder' => 'Enter your return amount',
											'onchange' => "javascript:Detailview(this, " . $listDetail->row()->id . ",'cancel_percentage');",
											'value' => $listDetail->row()->cancel_percentage
										]);
										?>
										%
										<span id="return_amount_error" style="color:red;font-size:12px;"
											  class="error"></span>
									</div>
								</div>
							<li>
								<div id="cancel_description">
									<div class="form_grid_12">
										<?php
										echo form_label('Description <span class="req">*</span>', 'user_id', $commonclass);
										$plcydescattr = array(
											'name' => 'cancel_description',
											'id' => 'can_description',
											'tabindex' => '2',
											'style' => 'width:35%;',
											'class' => 'large tipTop',
											'rows' => '2',
											'title' => 'Enter your description" name="cancel_description',
											'placeholder' => 'Enter your description',
											'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'cancel_description');",
											'required' => 'required',
											'value' => $listDetail->row()->cancel_description
										);
										echo form_textarea($plcydescattr);
										?>
										<span id="can_description_error" style="color:red;font-size:12px;"
											  class="error"></span>
									</div>
								</div>
							</li>
							<li>
								<div id="cancel_description_ar">
									<div class="form_grid_12">
										<?php
										echo form_label('Description (Arabic) <span class="req">*</span>', 'user_id', $commonclass);
										$plcydescattr = array(
											'name' => 'cancel_description_ar',
											'id' => 'can_description_ar',
											'tabindex' => '2',
											'style' => 'width:35%;',
											'class' => 'large tipTop',
											'rows' => '2',
											'title' => 'Enter your description in Arabic" name="cancel_description_ar',
											'placeholder' => 'Enter your description in Arabic',
											'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'cancel_description_ar');",
											'required' => 'required',
											'value' => $listDetail->row()->cancel_description_ar
										);
										echo form_textarea($plcydescattr);
										?>
										<span id="can_description_error" style="color:red;font-size:12px;"
											  class="error"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Video URL ', 'admin_name', $commonclass);
									?>
									<div class="form_input">
										<?php
										$urlval = "";
										if (!empty($product_details)) {
											$urlval = trim(stripslashes($product_details->row()->video_url));
										}
										echo form_input([
											'type' => 'url',
											'name' => 'video_url',
											'id' => 'video_url',
											'style' => 'width:295px',
											'class' => 'large tipTop vdo_hght',
											'tabindex' => '5',
											'title' => 'Please enter the Video URL',
											'value' => $urlval
										]);
										?>
										<br><br>
										<?php
										echo form_label('Example:
													https://www.youtube.com/watch?v=u0PKS0nr63k', '');
										?>
										<br><br>
										<?php
										echo form_label('Go to Youtube video', '');
										?>
										<br><br>
										<?php
										echo form_label('Now Copy URL Link', '');
										?>
										<br><br>
										<?php
										echo form_label('Paste above Video Input', '');
										?>
									</div>
								</div>
							</li>
							<?php
							$prd_id = $this->uri->segment(4);
							if ($prd_id == '') { ?>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Request to Book <span class="req">*</span>', 'admin_name', $commonclass);
										?>
										<div class="form_input">
											<?php
											echo form_input([
												'type' => 'radio',
												'name' => 'request_to_book',
												'id' => 'req_id_y',
												'checked' => 'checked',
												'tabindex' => '11',
												'onChange' => 'CheckStatus()',
												'value' => 'Yes'
											]);
											echo 'Yes';
											$chkbook = "";
											if (!empty($product_details)) {
												if ($product_details->row()->request_to_book == 'No') {
													$chkbook = checked;
												}
											}
											echo form_input([
												'type' => 'radio',
												'name' => 'request_to_book',
												'id' => 'req_id_n',
												'tabindex' => '11',
												'onChange' => 'CheckStatus()',
												'value' => 'No',
												$chkbook => $chkbook
											]);
											echo 'No';
											?>
										</div>
									</div>
								</li>
								<?php
							} else { ?>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label('Request to Book <span class="req">*</span>', 'admin_name', $commonclass);
										?>
										<div class="form_input">
											<?php
											$chkbooky = "";
											$chkbookn = "";
											if (!empty($product_details)) {
												if ($product_details->row()->request_to_book == 'No') {
													$chkbookn = checked;
												}
												if ($product_details->row()->request_to_book == 'Yes') {
													$chkbooky = checked;
												}
											}
											echo form_input([
												'type' => 'radio',
												'name' => 'request_to_book',
												'id' => 'req_id_y',
												'checked' => 'checked',
												'tabindex' => '11',
												'onChange' => 'CheckStatus()',
												'value' => 'Yes',
												$chkbooky => $chkbooky
											]);
											echo 'Yes';
											echo form_input([
												'type' => 'radio',
												'name' => 'request_to_book',
												'id' => 'req_id_n',
												'tabindex' => '11',
												'onChange' => 'CheckStatus()',
												'value' => 'No',
												$chkbookn => $chkbookn
											]);
											echo 'No';
											?>
										</div>
									</div>
								</li>
							<?php }
							$filderr = array('class' => 'error', 'id' => 'req_error', 'style' => 'font-size:12px;display:none;');
							echo form_label('Please
										Choose The Field', '', $filderr);
							
							//if ($instant_pay->row()->status == '1') {
								$prd_id = $this->uri->segment(4);
								if ($prd_id == '') { ?>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Instant Pay <span class="req">*</span>', 'admin_name', $commonclass);
											?>
											<div class="form_input">
												<?php
												$chkpay = "";
												if (!empty($product_details)) {
													if ($product_details->row()->instant_pay == 'Yes') {
														$chkpay = checked;
													}
												}
												echo form_input([
													'type' => 'radio',
													'name' => 'instant_pay',
													'id' => 'instant_y',
													'tabindex' => '11',
													'onChange' => 'CheckStatusTwo()',
													'value' => 'Yes',
													$chkpay => $chkpay
												]);
												echo 'Yes';
												echo form_input([
													'type' => 'radio',
													'name' => 'instant_pay',
													'id' => 'instant_n',
													'tabindex' => '11',
													'onChange' => 'CheckStatus()',
													'value' => 'No',
													'checked' => 'checked'
												]);
												echo 'No';
												?>
											</div>
										</div>
									</li>
									<?php
								} else { ?>
									<li>
										<div class="form_grid_12">
											<?php
											echo form_label('Instant Pay <span class="req">*</span>', 'admin_name', $commonclass);
											?>
											<div class="form_input">
												<?php
												$chkpayy = "";
												$chkpayn = "";
												if (!empty($product_details)) {
													if ($product_details->row()->instant_pay == 'Yes') {
														$chkpayy = checked;
													}
													if ($product_details->row()->instant_pay == 'No') {
														$chkpayn = checked;
													}
												}
												echo form_input([
													'type' => 'radio',
													'name' => 'instant_pay',
													'id' => 'instant_y',
													'tabindex' => '11',
													'onChange' => 'CheckStatusTwo()',
													'value' => 'Yes',
													$chkpayy => $chkpayy
												]);
												echo 'Yes';
												echo form_input([
													'type' => 'radio',
													'name' => 'instant_pay',
													'id' => 'instant_n',
													'tabindex' => '11',
													'onChange' => 'CheckStatusTwo()',
													'value' => 'No',
													$chkpayn => $chkpayn
												]);
												echo 'No';
												?>
												<p><b>Note:</b> Instant pay will show in property booking based on admin settings. Current Status <?php if ($instant_pay->row()->status == '1') { echo '<b>Enabled</b>'; }else{ echo '<b>Disabled</b>';}?></p>
											</div>
										</div>
									</li>
								<?php }
							//}
							$infilderr = array('class' => 'error', 'id' => 'instatnt_error', 'style' => 'font-size:12px;display:none;');
							echo form_label('Please Choose The Field', '', $infilderr);
							?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue',
											'tabindex' => '9',
											'id' => 'nextImage',
											'value' => 'Save and Next',
											'onclick' => 'save_tab1();'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab2">
						<ul class="tab-areas2">
							<li>
								<div class="form_grid_12">
									<center>
										<br><br><b>&nbsp Add Photos</b>
										<p>Guests love photos that highlight the features of your space.</p>
										<p style="color:red">Please use an image that's at least 600px in width and 400px in height.</p>
									</center>
									<?php
									echo form_label('Rental Image <span class="req">*</span>', 'product_image', $commonclass);
									?>
									<br>
									<div class="dragndrop1">
										<a href="javascript:void(0);" onclick="ImageAddClick();">Choose Image
										</a>
									</div>
								</div>
							</li>
							<li>
								<div class="widget_content">
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
										if (!empty($imgDetail) && !empty($product_details)) {
											$i = 0;
											$j = 1;
											$this->session->set_userdata(array('product_image_' . $product_details->row()->id => $product_details->row()->image));
											foreach ($imgDetail->result() as $img) {
												if ($img != '') {
													?>
													<tr id="img_<?php echo $img->id ?>">
														<td class="center tr_select ">
															<?php
															echo form_input([
																'type' => 'hidden',
																'name' => 'imaged[]',
																'value' => $img->product_image
															]);
															echo $j; ?>
														</td>
														<td class="center ">
															<img
																src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "images/rental/" . $img->product_image; ?>"
																height="80px" width="80px"/>
														</td>
														<td class="center tr_select">
															<ul class="action_list"
																style="background:none;border-top:none;">
																<li style="width:100%;">
																	<a class="p_del tipTop" href="javascript:void(0)"
																	   onClick="javascript:DeleteProductImage(<?php echo $img->id; ?>,<?php echo $product_details->row()->id; ?>);"
																	   title="Delete this image">Remove
																	</a>
																</li>
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
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue prvTab',
											'value' => 'Previous',
											'tabindex' => '9'
										]);
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue',
											'value' => 'Save and Next',
											'tabindex' => '9',
											'id' => 'nextImage_up',
											'onclick' => 'img();'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab3">
						<?php
						if (!empty($product_details)) {
							$list_name = $product_details->row()->list_name;
							$facility = (explode(",", $list_name));
						}
						?>
						<?php if ($listNameCnt->num_rows() > 0) { ?>
							<ul class="tab-areas3">
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
												<input type="checkbox" class="checkbox_check" name="list_name[]"
													   id="mostcommon<?php echo $details->id; ?>" <?php if (in_array($details->id, $facility)) { ?> checked="checked" <?php } ?>
													   value="<?php echo $details->id; ?>"/>
												<span><?php echo $details->list_value; ?></span>
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
								<li class="btnsa">
									<div class="form_grid_12">
										<div class="form_input" style="margin:0px;width:100%;">
											<?php
											echo form_input([
												'type' => 'button',
												'class' => 'btn_small btn_blue prvTab',
												'value' => 'Previous',
												'tabindex' => '9'
											]);
											echo form_input([
												'type' => 'button',
												'class' => 'btn_small btn_blue nxtTab',
												'value' => 'Save and next',
												'tabindex' => '9',
												'onclick' => 'save_tab3();'
											]);
											?>
										</div>
									</div>
								</li>
							</ul>
						<?php } ?>
					</div>
					<div id="tab4">
						<ul id="AttributeView">
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Location <span class="req">*</span>', 'address', $commonclass);
									?>
									<div class="form_input">
										<?php
										$addrval = "";
										if (!empty($product_details)) {
											$addrval = trim(stripslashes($product_details->row()->address));
										}
										echo form_input([
											'type' => 'text',
											'name' => 'address',
											'id' => 'autocomplete-admin',
											'style' => 'width:370px;',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Enter Your Location',
											'onChange' => 'getAddressDetails();',
											'onFocus' => 'geolocate()',
											'value' => $addrval
										]);
										$locerr = array('class' => 'error', 'id' => 'location_error_valid', 'style' => 'font-size:12px;display:none;');
										echo form_label('Only Alphabets
											are allowed', '', $locerr);
										?>
										<span id="location_error" style="color:red;font-size:12px;" class="error">
                                 		</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Country <span class="req">*</span>', 'country', $commonclass);
									?>
									<div class="form_input">
										<?php
										$cntval = "";
										if ($productAddressData->row()->country != '') {
											$cntval = $productAddressData->row()->country;
										}
										echo form_input([
											'type' => 'text',
											'name' => 'country',
											'id' => 'country',
											'style' => 'width:370px;',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Enter Country Name',
											'value' => $cntval
										]);
										$cnterr = array('class' => 'error', 'id' => 'country_error_valid', 'style' => 'font-size:12px;display:none;');
										echo form_label('Only Alphabets
											are allowed', '', $cnterr);
										?>
										<span id="country_error" style="color:red;font-size:12px;" class="error">
                                 		</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('State <span class="req">*</span>', 'state', $commonclass);
									?>
									<div class="form_input" id="listCountryCnt">
										<?php
										$steval = "";
										if ($productAddressData->row()->state != '') {
											$steval = $productAddressData->row()->state;
										}
										echo form_input([
											'type' => 'text',
											'name' => 'state',
											'id' => 'state',
											'style' => 'width:370px;',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Enter State Name',
											'value' => $steval
										]);
										$steerr = array('class' => 'error', 'id' => 'state_error_valid', 'style' => 'font-size:12px;display:none;');
										echo form_label('Only Alphabets
											are allowed', '', $steerr);
										?>
										<span id="state_error" style="color:red;font-size:12px;" class="error">
                                 </span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('City <span class="req">*</span>', 'city', $commonclass);
									?>
									<div class="form_input" id="listStateCnt">
										<?php
										$ctyval = "";
										if ($productAddressData->row()->city != '') {
											$ctyval = $productAddressData->row()->city;
										}
										echo form_input([
											'type' => 'text',
											'name' => 'city',
											'id' => 'city',
											'style' => 'width:370px;',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Enter City Name',
											'value' => $ctyval
										]);
										$ctyerr = array('class' => 'error', 'id' => 'city_error_valid', 'style' => 'font-size:12px;display:none;');
										echo form_label('Only Alphabets
											are allowed', '', $ctyerr);
										?>
										<span id="city_error" style="color:red;font-size:12px;" class="error">
                                 		</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Street Address', 'apt', $commonclass);
									?>
									<div class="form_input">
										<?php
										$aptval = "";
										if ($productAddressData->row()->street != '') {
											$aptval = $productAddressData->row()->street;
										}
										echo form_input([
											'type' => 'text',
											'name' => 'apt',
											'id' => 'apt',
											'style' => 'width:370px;',
											'class' => 'tipTop large',
											'tabindex' => '3',
											'title' => 'Enter Street Address',
											'value' => $aptval
										]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Zip Code', 'post_code', $commonclass);
									?>
									<div class="form_input">
										<?php
										$zpval = "";
										if ($productAddressData->row()->zip != '') {
											$zpval = $productAddressData->row()->zip;
										}
										echo form_input([
											'type' => 'text',
											'name' => 'post_code',
											'id' => 'post_code',
											'pattern' => '[A-Za-z1-9\s-]{3,11}',
											'class' => 'tipTop large',
											'maxlength' => '11',
											'title' => 'Enter the Zip code',
											'value' => $zpval
										]);
										$zperr = array('class' => 'error', 'id' => 'post_code_error_valid', 'style' => 'color:#f00;display:none;font-size:12px;');
										echo form_label('Numbers are allowed', '', $zperr);
										?>
										<span id="post_code_length_error" style="color:red;">	
										</span>
									</div>
									<div style="margin-left:30%;margin-top:10px;">
										<?php if (!empty($product_details)) {
											$in_address = trim(stripslashes($product_details->row()->address)); ?>
											<img id='map-image' border="0" alt="Greenwich, England"
												 src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>">
										<?php } ?>
										<div align="center" id="map-new"
											 style="width: 600px; height: 300px; display:none">
											<p id='map-text' style="margin-top:150px;">Map will be displayed
												here</p>
										</div>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input" style="margin:0px;width:100%;">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue prvTab',
											'tabindex' => '9',
											'value' => 'Previous'
										]);
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue',
											'tabindex' => '9',
											'value' => 'Save and Next',
											'id' => 'nextlist',
											'onclick' => 'save_tab4(); email_publish();'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab5">
						<ul>
							<h4>Listing Info:</h4>
							<?php
							foreach ($listSpace->result() as $listresult) {
								$name = $listresult->attribute_name;
								$id = $listresult->id;
								?>
								<li>
									<div class="form_grid_12">
										<?php
										echo form_label($name . '<span class="req">*</span>', 'confirm_email', $commonclass);
										?>
										<div class="form_input">

											<?php if (!empty($product_details) && $product_details->num_rows() != 0) {
												$sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = ' . $id;
												$inner = $this->db->query($sql);
												if ($inner->num_rows() > 0) {
													
													?>
													<select
														name="<?php if ($listresult->attribute_seourl == 'propertytype') echo 'home_type'; else if ($listresult->attribute_seourl == 'roomtype') echo 'room_type'; ?>"
														id="home_type1"
														onchange="javascript:Detailview_admin(this,<?php echo $product_details->row()->id; ?>,'<?php if ($listresult->attribute_seourl == 'propertytype') echo 'home_type'; else if ($listresult->attribute_seourl == 'roomtype') echo 'room_type'; ?>');"
														autocomplete="off">
														<option value="">--Select--</option>
														<?php
														foreach ($inner->result() as $listvalues) {
															if ($pcount == 0) {
																?>
																<option
																	value="<?php echo $listvalues->id; ?>" <?php if ($listresult->attribute_seourl == 'propertytype') {
																	if (trim($listvalues->id) == trim($product_details->row()->home_type)) {
																		echo 'selected="selected"';
																	}
																} else if ($listresult->attribute_seourl == 'roomtype') {
																	if (trim($listvalues->id) == trim($product_details->row()->room_type)) {
																		echo 'selected="selected"';
																	}
																} ?> ><?php echo $listvalues->list_value; ?></option>
															<?php } else { ?>
																<option
																	value="<?php echo $listvalues->id; ?>" <?php if ($listvalues->id == $product_details->row()->room_type) echo 'selected="selected"'; ?> ><?php echo $listvalues->list_value; ?></option>
																<?php
															}
														} ?>
													</select>
												<?php }
												
												
											} else {
												
												
												$sql = 'SELECT * FROM fc_listspace_values WHERE listspace_id = ' . $id;
												$inner = $this->db->query($sql);
												if ($inner->num_rows() > 0) {
													?>
													<select
														name="<?php if ($listresult->attribute_seourl == 'propertytype') echo 'home_type'; else if ($listresult->attribute_seourl == 'roomtype') echo 'room_type'; ?>"
														id="home_type2"
														onchange="javascript:Detailview_admin(this,document.getElementById('prdiii').value,'<?php if ($listresult->attribute_seourl == 'propertytype') echo 'home_type'; else if ($listresult->attribute_seourl == 'roomtype') echo 'room_type'; ?>');"
														autocomplete="off">
														<option value="">Select</option>
														<?php
														foreach ($inner->result() as $listvalues) {
															if ($pcount == 0) {
																?>
																<option
																	value="<?php echo $listvalues->id; ?>"><?php echo $listvalues->list_value; ?></option>
															<?php } else { ?>
																<option
																	value="<?php echo $listvalues->id; ?>"><?php echo $listvalues->list_value; ?></option>
																<?php
															}
														} ?>
													</select>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</li>
							<?php } ?>

							<?php
							$product_list_decode = json_decode($listDetail->row()->listings);
							foreach ($product_list_decode as $product_list_name => $product_list_values) {
								$product_list_data[$product_list_name] = $product_list_values;
							}
							$roombedVal = $values1;
							foreach ($roombedVal as $key => $value) {
								$listing_keys[$key] = $key;
								$listing_values[$key] = $value;
							}
							$i = 1;
							foreach ($listTypeValues->result() as $keys => $finals) {
								$name = $finals->name;
								$field_id = $finals->id;
                                $getChildValues=$this->product_model->get_selected_fields_records('id,parent_id,child_name,child_name_arabic,status',LISTING_CHILD,' where parent_id= '.$field_id.' order by child_name + 0 ASC');

                                if ($name != 'can_policy') {
									$list_type = $finals->type;
									if ($list_type == 'option') {
										?>
										<li  style="<?php if ($getChildValues->num_rows() > 0) {
											echo "display:block";
										} else {
											echo "display:none";
										} ?>">
									<?php } else { ?>
										<li>
									<?php } ?>
									<div class="form_grid_12">
										<label class="field_title" for="confirm_email"><?php
											if ($list_type == 'option') {
												if ($getChildValues->num_rows() > 0) {
													echo str_replace('_', ' ', $finals->labelname);
												}
											} else {
												echo str_replace('_', ' ', $finals->labelname);
											}
											if ($name == 'minimum_stay') { ?>
												<span class="req"> *</span><?php } ?></label>
										<div class="form_input">
											<?php
											if ($list_type == 'option') {
												if ($getChildValues->num_rows() > 0) {
													?>
													<!--saves as ID -->
													<select name="<?php
													?>" id="home_type3" class="valid <?php echo $name; ?>"
															onchange="javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'<?php echo $field_id; ?>');">
														<option value="">Select</option>
														<?php
														foreach ($getChildValues->result() as $val) {
															if ($field_id == $val->parent_id) {
																?>
																<option
																	value="<?php echo $val->id; ?>" <?php if (in_array($val->id, $product_list_data)) {
																	echo 'selected="selected"';
																} ?> ><?php echo $val->child_name; ?></option>
															<?php }
														} ?>
													</select>
												<?php }
											} else {

                                                ?>
												<div class="textClass">
													<?php
													echo form_input([
														'type' => 'text',
														'onchange' => "javascript:DetaillistAdmin(this,document.getElementById('prdiii').value,'" . $field_id . "');",
														'class' => 'text_size tipTop',
														'tabindex' => '1',
														'title' => 'Enter' . str_replace('_', ' ', $name),
														'value' => $product_list_data[$field_id]
													]);
													?>
												</div>
												<?php
											} ?>
										</div>
									</div>
									</li>
								<?php }
								$i++;
							} ?>
							<li>
								<div class="form_grid_12">
									<div class="form_input" style="margin:0px;width:100%;">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue prvTab',
											'tabindex' => '9',
											'value' => 'Previous'
										]);
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue ',
											'tabindex' => '9',
											'value' => 'Save and Next',
											'id' => 'nextdes',
											'onclick' => 'save_tab5();'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab6">
						<ul>
							<h3>Details</h3>
							<p>A description of your space displayed on your public listing page. </p>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('The Space', 'space', $commonclass);
									?>
									<div class="form_input">
										<?php
										$spval = "";
										if (!empty($product_details)) {
											$spval = trim(stripslashes($product_details->row()->space));
										}
										$spdescattr = array(
											'name' => 'space',
											'id' => 'space',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'What makes your listing unique?',
											'title' => 'what makes  your listing unique ?',
											'value' => $spval,
                                            'onkeyup' => "count_characters_admin(this,'space')",
                                            'onpaste' => "count_characters_admin(this,'space')"
										);
										echo form_textarea($spdescattr);
										?>
                                        <span id="chars_left_space" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
							<h3>Extra Details</h3>
							<p>Other information you wish to share on your public page. </p>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Other Things to
										Note', 'other_thingnote', $commonclass);
									?>
									<div class="form_input">
										<?php
										$othrval = "";
										if (!empty($product_details)) {
											$othrval = trim(stripslashes($product_details->row()->other_thingnote));
										}
										$othrattr = array(
											'name' => 'other_thingnote',
											'id' => 'other_thingnote',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'Are there any other details you’d like to share ?',
											'title' => 'Are there any other details you’d like to share ?',
											'value' => $othrval,
                                            'onkeyup' => "count_characters_admin(this,'other_thingnote')",
                                            'onpaste' => "count_characters_admin(this,'other_thingnote')"
										);
										echo form_textarea($othrattr);
										?>
                                        <span id="chars_left_other_thingnote" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('House Rules', 'house_rules', $commonclass);
									?>
									<div class="form_input">
										<?php
										$husval = "";
										if (!empty($product_details)) {
											$husval = trim(stripslashes($product_details->row()->house_rules));
										}
										$husvalattr = array(
											'name' => 'house_rules',
											'id' => 'house_rules',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'How do you expect your guests to behave ?',
											'title' => 'How do you expect your guests to behave ?',
											'value' => $husval,
                                            'onpaste' => "count_characters_admin(this,'house_rules')",
                                            'onkeyup' => "count_characters_admin(this,'house_rules')"
										);
										echo form_textarea($husvalattr);
										?>
                                        <span id="chars_left_house_rules" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Guest Access', 'house_rule', $commonclass);
									?>
									<div class="form_input">
										<?php
										$gstval = "";
										if (!empty($product_details)) {
											$gstval = trim(stripslashes($product_details->row()->guest_access));
										}
										$gstvalattr = array(
											'name' => 'guest_access',
											'id' => 'guest_access',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'How do you expect your guests to behave ?',
											'title' => 'How do you expect your guests to behave ?',
											'value' => $gstval,
                                            'onpaste' => "count_characters_admin(this,'guest_access')",
                                            'onkeyup' => "count_characters_admin(this,'guest_access')"
										);
										echo form_textarea($gstvalattr);
										?>
                                        <span id="chars_left_guest_access" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Interaction with Guest', 'house_rule', $commonclass);
									?>
									<div class="form_input">
										<?php
										$intrval = "";
										if (!empty($product_details)) {
											$intrval = trim(stripslashes($product_details->row()->interact_guest));
										}
										$intrvalattr = array(
											'name' => 'interact_guest',
											'id' => 'interact_guest',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'Interaction with guest',
											'title' => 'Interaction with guest',
											'value' => $intrval,
                                            'onpaste' => "count_characters_admin(this,'interact_guest')",
                                            'onkeyup' => "count_characters_admin(this,'interact_guest')"
										);
										echo form_textarea($intrvalattr);
										?>
                                        <span id="chars_left_interact_guest" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Neighborhood', 'house_rule', $commonclass);
									?>
									<div class="form_input">
										<?php
										$nighval = "";
										if (!empty($product_details)) {
											$nighval = trim(stripslashes($product_details->row()->neighbor_overview));
										}
										$nighvalattr = array(
											'name' => 'neighbor_overview',
											'id' => 'neighbor_overview',
											'tabindex' => '13',
											'style' => 'width:370px;height:100px;',
											'class' => 'large tipTop',
											'rows' => '3',
											'placeholder' => 'Neighborhood',
											'title' => 'Neighborhood',
											'value' => $nighval,
                                            'onpaste' => "count_characters_admin(this,'neighbor_overview')",
                                            'onkeyup' => "count_characters_admin(this,'neighbor_overview')"
										);
										echo form_textarea($nighvalattr);
										?>
                                        <span id="chars_left_neighbor_overview" class="text-danger-ad"></span>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input" style="margin:0px;width:100%;">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue prvTab',
											'tabindex' => '9',
											'value' => 'Previous'
										]);
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue ',
											'tabindex' => '9',
											'value' => 'Save and Next',
											'id' => 'nextseo',
											'onclick' => 'save_tab6();'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab7">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Title', 'meta_title', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mttl = "";
										if (!empty($product_details)) {
											$mttl = trim(stripslashes($product_details->row()->meta_title));
										}
										echo form_input([
											'type' => 'text',
											'name' => 'meta_title',
											'id' => 'meta_title',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Please enter the page meta title',
											'value' => $mttl
										]);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Title in Arabic', 'meta_title_ar', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mttl_ar = "";
										if (!empty($product_details)) {
											$mttl_ar = trim(stripslashes($product_details->row()->meta_title_ar));
										}
										echo form_input([
											'type' => 'text',
											'name' => 'meta_title_ar',
											'id' => 'meta_title_ar',
											'class' => 'tipTop large',
											'tabindex' => '1',
											'title' => 'Please enter the page meta title',
											'value' => $mttl_ar
										]);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Keywords', 'description', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mtwrdtl = "";
										if (!empty($product_details)) {
											$mtwrdtl = trim(stripslashes($product_details->row()->meta_keyword));
										}
										$keywrdattr = array(
											'name' => 'meta_keyword',
											'id' => 'meta_keyword',
											'tabindex' => '13',
											'class' => 'large tipTop',
											'style' => 'width:370px;height:150px;',
											'title' => 'Please enter the keyword',
											'value' => $mtwrdtl
										);
										echo form_textarea($keywrdattr);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Keywords in arabic', 'description_ar', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mtwrdtl = "";
										if (!empty($product_details)) {
											$mtwrdtl_ar = trim(stripslashes($product_details->row()->meta_keyword_ar));
										}
										$keywrdattr = array(
											'name' => 'meta_keyword_ar',
											'id' => 'meta_keyword_ar',
											'tabindex' => '13',
											'class' => 'large tipTop',
											'style' => 'width:370px;height:150px;',
											'title' => 'Please enter the keyword',
											'value' => $mtwrdtl_ar
										);
										echo form_textarea($keywrdattr);
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Description', 'meta_description', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mtwrdesc = "";
										if (!empty($product_details)) {
											$mtwrdesc = trim(stripslashes($product_details->row()->meta_keyword));
										}
										$descattr = array(
											'name' => 'meta_description',
											'id' => 'meta_description',
											'tabindex' => '3',
											'class' => 'large tipTop',
											'style' => 'width:370px;height:150px;',
											'title' => 'Please enter the meta description',
											'value' => $mtwrdesc
										);
										echo form_textarea($descattr);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Description in Arabic', 'meta_description_ar', $commonclass);
									?>
									<div class="form_input">
										<?php
										$mtwrdesc_ar = "";
										if (!empty($product_details)) {
											$mtwrdesc_ar = trim(stripslashes($product_details->row()->meta_keyword_ar));
										}
										$descattr_ar = array(
											'name' => 'meta_description_ar',
											'id' => 'meta_description_ar',
											'tabindex' => '3',
											'class' => 'large tipTop',
											'style' => 'width:370px;height:150px;',
											'title' => 'Please enter the meta description',
											'value' => $mtwrdesc_ar
										);
										echo form_textarea($descattr_ar);
										?>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input([
											'type' => 'button',
											'class' => 'btn_small btn_blue prvTab',
											'tabindex' => '9',
											'value' => 'Previous'
										]);
										echo form_input([
											'type' => 'submit',
											'class' => 'btn_small btn_blue ',
											'tabindex' => '9',
											'value' => 'Save'
										]);
										?>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<input type="hidden" name="userID" value="<?php if ($loginID != '') {
						echo $loginID;
					} else {
						echo '0';
					} ?>"/>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>
<style>
	.text_size {
		width: 188px !important;
	}
</style>
<script type="text/javascript">
	function DealPriceInsert(value, title) {
		var pid = document.getElementById('prdiii').value;

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/product/DealPriceInsert',
			data: {val: value, product_id: pid, title: title},
			success: function (msg) {
			}
		})
	}
</script>
<script>
	/*This example displays an address form, using the autocomplete feature
	of the Google Places API to help users fill in the information.*/

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
		/*Create the autocomplete object, restricting the search
		to geographical location types.
*/
		autocomplete = new google.maps.places.Autocomplete(
			/** @type {HTMLInputElement} */(document.getElementById('autocomplete-admin')),
			{types: ['geocode']});
		/*	When the user selects an address from the dropdown,
            populate the address fields in the form.*/
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			fillInAddress();
		});
	}

	initializeMap();


	function fillInAddress() {
		/*	Get the place details from the autocomplete object.*/
		var place = autocomplete.getPlace();

		for (var component in componentForm) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		}

		/*Get each component of the address from the place details
		and fill the corresponding field on the form.*/
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

	/*[END region_geolocation]*/


	function getAddressDetails() {
		var address = $('#autocomplete-admin').val();
		
		$.ajax({
			type: 'POST',
			url: baseURL + 'site/product/get_location',
			data: {"address": address},
			dataType: 'json',
			success: function (json) {
				console.log(json);
				
				$('#country').val(json.country);
				$('#state').val(json.state);
				$('#city').val(json.city);
				$('#post_code').val(json.zip);
				$('#apt').val(json.area);
				$('#latitude').val(json.lat);
				$('#longitude').val(json.lang);
				//alert(json.city+', '+json.state+', '+json.country);
				$('#autocomplete-admin').val(json.city+', '+json.state+', '+json.country);
				myLatlng = new google.maps.LatLng(json.lat, json.lang);

				citymap['chicago'] = {
					center: myLatlng,
					population: 200
				};
				$("#map-image").hide();
				$("#map-new").show();
				initializeMapCircle();

			}
		});

	}
</script>
<script type="text/javascript">
	function CheckStatus() {
		var req = $('input[name="request_to_book"]:checked').val();
		if (req == 'No') {
			$('#instant_y').attr('checked', true);
		}
	}

	function CheckStatusTwo() {
		var instant = $('input[name="instant_pay"]:checked').val();
		if (instant == 'No') {
			$('#req_id_y').attr('checked', true);
		}
	}
</script>
<script type="text/javascript">
	$('#addproduct_form1111').validate();

	$('input#price').blur(function () {
		var num = parseFloat($(this).val());
		var cleanNum = num.toFixed(2);

		if (num / cleanNum < 1) {
			$('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
		}
	});
</script>
<!-- script for validating form Rental general info -->
<script type="text/javascript">
	function save_tab1() {
		var user_id = $('[name="user_id"]').val();
		//$('#current_user_id :selected').val();
		//alert(user_id); return false;
		var pro_id = $('#prdiii').val();
		var price = $('#price').val();
		var security_deposit = $('#security_deposit').val();
		var currency = $('#currency').val();
		var video_url = $('#video_url').val();
		var cancellation_policy = $('#cancellation_policy :selected').val();
		if (cancellation_policy == 'Strict') {
			var return_amount = '100';
		}
		else {
			var return_amount = $('#return_amount').val();
		}
		var can_description = $('#can_description').val();
		var product_title = $('#product_title').val();
		var product_summary = $('#description').val();
		var req = $('input[name="request_to_book"]:checked').val();
		var instant = $('input[name="instant_pay"]:checked').val();
		var status = 'Publish';

		if ($.trim(cancellation_policy) != "" && $.trim(product_title) != "" && $.trim(product_summary) != "" && $.trim(req) != "" && $.trim(price) != "" && $.trim(can_description) != "") {
			$("#nextImage").addClass("nxtTab_img");
			validateFormSection();
		}
		else {

			alert("Save by filling all mandatory fields and proceed to Next");
		}

		if (cancellation_policy == 'Flexible') {
			if (return_amount == '') {
				$("#return_amount_error").text("Enter the return amount");
				return false;
			} else if (can_description == '') {
				$("#can_description_error").text("Enter the cancel description");
				return false;
			} else {
				$("#return_amount_error").text("");
				$("#can_description_error").text("");
			}
		}
		if (cancellation_policy == 'Moderate') {
			if (return_amount == '') {
				$("#return_amount_error").text("Enter the return amount");
				return false;
			} else if (can_description == '') {
				$("#can_description_error").text("Enter the cancel description");
				return false;
			} else {
				$("#return_amount_error").text("");
				$("#can_description_error").text("");
			}
		}
		if (cancellation_policy == 'Strict') {
			if (can_description == '') {
				$("#can_description_error").text("Enter the cancel description");
				return false;
			} else {
				$("#can_description_error").text("");
			}
		}

		if (product_title == '') {
			$("#title_error").text("Enter your Rental title");
			$("#product_title").focus();

			return false;
		} else {
			$("#title_error").text("");
		}
		if (product_summary == '') {
			$("#summary_error").text("Enter your Rental summary");
			$("#description").focus();
			return false;
		} else {
			$("#summary_error").text("");
		}

		if (req != 'No' && req != 'Yes') {
			$("#req_error").text("Choose Your Option");
			$("#request_to_book").focus();
			return false;
		} else {
			$("#req_error").text("");
		}

		if (price == '') {
			$("#price_error").text("Enter your Rental price");
			$("#price").focus();
			return false;
		} else {
			var cleanNum = (parseFloat(price)).toFixed(2);

			if (parseFloat(price) / cleanNum != 1) {
				$('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
				return false;
			} else {
				$("#price_error").text("");
			}
		}
		if (security_deposit != '') {
			var cleanNum = (parseFloat(security_deposit)).toFixed(2);

			if (parseFloat(security_deposit) / cleanNum != 1) {
				$('#security_deposit_error').text('Please enter only 2 decimal places, we have truncated extra points');
				$("#price").focus();
				return false;
			} else {
				$("#security_deposit_error").text("");
			}
		}

		if (pro_id != '' && pro_id != '0') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/product/savetab1',
				data: {
					'user_id': user_id,
					'pro_id': pro_id,
					'price': price,
					'security_deposit': security_deposit,
					'cancellation_policy': cancellation_policy,
					'cancel_description': can_description,
					'cancel_percentage': return_amount,
					'status': status,
					'currency': currency,
					'product_summary': product_summary,
					'req': req,
					'instant': instant,
					'video_url': video_url
				},
				dataType: 'json',
				success: function (json) {


					if ($.trim(cancellation_policy) != "" && $.trim(product_title) != "" && $.trim(product_summary) != "" && $.trim(req) != "" && $.trim(price) != "" && $.trim(can_description) != "") {
						alert('Added Successfully');
					}

					var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '/' + json.resultval;
					window.history.pushState({path: newurl}, '', newurl);

				}
			});
		} else {
			alert('Rental not valid');
		}

	}
</script>
<script type="text/javascript">
	function save_tab3() {

		var pro_id = $('#prdiii').val();
		var edit_pro_id = $('#edit_pro_id').val();
		var list_values = $("input[name='list_name[]']:checked")
			.map(function () {
				return $(this).val();
			}).get();

		if (pro_id != '' && pro_id != '0') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/product/savetab3',
				data: {'list_values': list_values, 'pro_id': pro_id, 'edit_pro_id': edit_pro_id},
				dataType: 'json',
				success: function (json) {

					if (json.resultval == 'Updated') {
						alert('Added Successfully');
					} else if (json.resultval == 'NoVal') {

					}

				}
			});
		} else {
			alert('Rental not valid');
		}

	}
</script>
<script type="text/javascript">
	function save_tab4() {
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


		if (location_data == '') {
			$("#location_error").text("Enter your location");
			$("#autocomplete-admin").focus();
			return false;
		} else {
			$("#location_error").text("");
		}
		if (country == '') {
			$("#country_error").text("Enter your country");
			$("#country").focus();
			return false;
		} else {
			$("#country_error").text("");
		}
		if (state == '') {
			$("#state_error").text("Enter your state");
			$("#state").focus();
			return false;
		} else {
			$("#state_error").text("");
		}
		if (city == '') {
			$("#city_error").text("Enter your city");
			$("#city").focus();
			return false;
		} else {
			$("#city_error").text("");
		}
		if (post_code != '') {
			if (post_code.length < 3) {
				$("#post_code_length_error").text("Enter Valid Zipcode");
				return false;
			}
		} else {
			$("#post_code_length_error").text("");
		}
		if (pro_id != '' && pro_id != '0') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/product/savetab4',
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
						alert('Added Successfully');
						$("#tab4").load(location.href + " #tab4");
					}

				}
			});
		} else {
			alert('Rental not valid');
		}

		if ($.trim(location_data) != "" && $.trim(country) != "" && $.trim(state) != "" && $.trim(city) != "") {
			$("#nextlist").addClass("nxtTab_list");
			validateFormSection_listing();
		}
		else {
			alert("Save by filling all mandatory fields and proceed to Next");
		}


	}
</script>
<script type="text/javascript">
	function save_tab5() {
		var error = 0;
		var error1 = 0;
		var pro_id = $('.minimum_stay').val();


		$(".listingInfo select").each(function (index) {
			if ($(this).val() == '' && $(this).attr("name") == "home_type") {
				error++;
			}
			else if ($(this).val() == '' && $(this).attr("name") == "room_type") {
				error++;
			}


			else if (pro_id == '') {
				error++;
			}

		});


		if (error > 0 || error1 > 0) {
			alert("Please fill all the mandatory fields");
		}
		else {
			alert("Added Successfully");
			$("#nextdes").addClass("nxtTab_descrip");
			validateFormSection_des();
		}


	}
</script>
<script type="text/javascript">
	function save_tab6() {
		var pro_id = $('#prdiii').val();
		var edit_pro_id = $('#edit_pro_id').val();
		var space = $('#space').val();
		var other_thingnote = $('#other_thingnote').val();
		var house_rules = $('#house_rules').val();
		var neighbor_overview = $('#neighbor_overview').val();
		var interact_guest = $('#interact_guest').val();
		var guest_access = $('#guest_access').val();
		if (pro_id != '' && pro_id != '0') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/product/savetab6',
				data: {
					'pro_id': pro_id,
					'edit_pro_id': edit_pro_id,
					'space': space,
					'other_thingnote': other_thingnote,
					'house_rules': house_rules,
					'neighbor_overview': neighbor_overview,
					'interact_guest': interact_guest,
					'guest_access': guest_access
				},
				dataType: 'json',
				success: function (json) {

					if (json.resultval == 'Updated') {
						alert('Added Successfully');
						$("#nextseo").addClass("nxtTab_seo");
						validateFormSection_seo();

					}

				}
			});

		} else {
			alert('Rental not valid');
		}
	}
</script>
<script type="text/javascript">
	var wordLen = 150,
		len;
	var wordLen1 = 0;

	$('#description').change(function (event) {
		len = $('#description').val().split(/[\s]+/);
		if (len.length > wordLen) {
			if (event.keyCode == 46 || event.keyCode == 8) {/*Allow backspace and delete buttons*/
			} else if (event.keyCode < 48 || event.keyCode > 57) {
				event.preventDefault();
			}
		}

		wordsLeft = (wordLen) - len.length;

		if (wordsLeft == 0) {

			$('.words-left').html('You Can not Type More then 150 Words...!');
		}
	});
</script>
<script>
	var maxWords = 150;


	jQuery('#description').change(function () {
		var words = $(this).val().split(/\b[\s,\.-:;]*/);
		// console.log(words.length);
		if (words.length > maxWords) {
			words.splice(maxWords);
			$(this).val(words.join(""));
			alert("You've reached the maximum allowed words. Extra words removed.");
		}

	});
</script>
<script>
	$("#price").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9.\s]/g)) {
			document.getElementById("price_error_valid").style.display = "inline";
			$("#price_error_valid").fadeOut(5000);
			$("#price").focus();
			$(this).val(val.replace(/[^0-9.\s]/g, ''));
		}
	});


	$("#security_deposit").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9.\s]/g)) {
			document.getElementById("security_deposit_error").style.display = "inline";
			$("#security_deposit_error").fadeOut(5000);
			$("#security_deposit").focus();
			$(this).val(val.replace(/[^0-9.\s]/g, ''));
		}
	});


	$("#post_code").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^a-zA-Z.-\s1-9]/g)) {
			document.getElementById("post_code_error_valid").style.display = "inline";
			$("#post_code").focus();
			$("#post_code_error_valid").fadeOut(5000);
			$(this).val(val.replace(/[^0-9\s]/g, ''));
		}
	});
</script>
<script>
	function img() {
		<?php if (!empty($imgDetail) && !empty($product_details)) {
		$this->session->set_userdata(array('product_image_' . $product_details->row()->id => $product_details->row()->image));
		foreach ($imgDetail->result() as $img) {
		}
	}
		$countimg = count($img->product_image);
		?>


		var count = <?php echo $countimg; ?>;
		if (count == 0) {
			alert("Please Upload Image");
		} else {
			$("#nextImage_up").addClass("nxtTab_amenities");
			validateFormSection_amenities();
		}

	}
</script>
<script>
	function validateFormSection() {
		var cur = $('.nxtTab_img').parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	}

	function validateFormSection_amenities() {
		var cur = $('.nxtTab_amenities').parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	}

	function validateFormSection_listing() {
		var cur = $('.nxtTab_list').parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	}

	function validateFormSection_des() {
		var cur = $('.nxtTab_descrip').parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	}

	function validateFormSection_seo() {
		var cur = $('.nxtTab_seo').parent().parent().parent().parent().parent();
		cur.hide();
		cur.next().show();
		var tab = cur.parent().parent().prev();
		tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
	}
</script>
<script type="text/javascript">
	function validateFloatKeyPress(el, evt) {

		var charCode = (evt.which) ? evt.which : event.keyCode;
		var number = el.value.split('.');
		if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
			return false;
		}

		if (number.length > 1 && charCode == 46) {
			return false;
		}

		var caratPos = getSelectionStart(el);
		var dotPos = el.value.indexOf(".");
		if (caratPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
			alert("Afer decimel two digits only allowed!");
			return false;
		}
		return true;
	}

	function getSelectionStart(o) {
		if (o.createTextRange) {
			var r = document.selection.createRange().duplicate()
			r.moveEnd('character', o.value.length)
			if (r.text == '') return o.value.length
			return o.value.lastIndexOf(r.text)
		} else return o.selectionStart
	}
</script>
<script>
	function email_publishh() {
		var pro_id = $('#prdiii').val();
		$.ajax(
			{
				type: 'POST',
				url: "<?php echo base_url();?>admin/product/checkproperty_finish",
				data: {'pro_id': pro_id},
				success: function (data) {

				}
			});
	}
</script>
<script>
	function show_val(cancel_value) {
		if (cancel_value.value == 'Flexible') {

			$('#return_amount').attr('readonly', false);
			$('#return_amount_percentage').show();
			$('#cancel_description').show();
		}
		else if (cancel_value.value == 'Moderate') /*Only 50% amount to guest*/
		{
			$('#return_amount').val('50');
			$('#return_amount').attr('readonly', 'true');
			$('#return_amount_percentage').show();
			$('#cancel_description').show();
		}
		else if (cancel_value.value == 'Strict') /*Except Guest fee amount to Guest*/
		{
			$('#return_amount').val('100');
			$('#return_amount').attr('readonly', 'true');
			$('#return_amount_percentage').show();
			$('#cancel_description').show();

		} else if (cancel_value.value == 'No Refund') { /*No CashBack to Guest*/
			$('#return_amount').val('0');
			$('#return_amount').attr('readonly', 'true');
			$('#return_amount_percentage').show();
			$('#cancel_description').show();

		} else {
			$('#return_amount_percentage').hide();
			$('#cancel_description').hide();
		}
	}
</script>
<script>
	$(document).ready(function () {
		$(".number_field2").keydown(function (e) {

			if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

				(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||

				(e.keyCode >= 35 && e.keyCode <= 40)) {

				return;
			}
			/*Ensure that it is a number and stop the keypress*/
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	});

	/*Save title*/
	function AdminDetailview(evt, catID, chk) {
		var title = evt.value;
		if (catID == 0) {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/product/saveAdminDetailPage',
				data: {'title': title, 'chk': chk, 'catID': catID},
				dataType: 'json',
				success: function (json) {
					console.log(json);
					$('#prdiii').val(json.resultval);
					$('#imgmsg_' + catID).hide();
					$('#imgmsg_' + catID).show().text('Done').delay(800).text('');
				}
			});
		}
		else {
			window.location.hash;
		}
	}
</script>

<script>
    function count_characters_admin(data, update_field){
        var contents = data.value;
        var characters = contents.length;
        if (characters > 250) {
            var split_by_uncerscore = update_field.replace("_", " ");
            $("#chars_left_" + update_field).html("The " + split_by_uncerscore + " should not exceed 250 Characters!");
            return false;
        }
        else {
            var chars_remaining = 250 - parseInt(characters);
            if (parseInt(chars_remaining) > 0) {
                $("#chars_left_" + update_field).html("You can add " + chars_remaining + " more characters!");
            }
            else if (parseInt(chars_remaining) <= 0) {
                $("#chars_left_" + update_field).html("You reached the character limit!!");
                return false;
            }
            Detailview_description(data,'<?php echo $listDetail->row()->id; ?>', update_field);
        }

    }
</script>

<!--Script to find title word count-->
	<script type="text/javascript">
		var wordLen1 = 8, len1;
		$('#product_title').keydown(function (event) {
			
			len1 = $('#product_title').val().split(/[\s]+/);
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
				document.getElementById("product_title_error").innerHTML = "8 Words Reached";
				
			}
			else {
				$("#product_title_error").html("You can add " + wordsLeft + " more words!");
			}
		});
	</script>

<?php
$this->load->view('admin/templates/footer.php');
?>
