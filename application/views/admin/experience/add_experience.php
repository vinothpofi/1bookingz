<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

<link rel="stylesheet" href="<?php echo base_url();?>css/localize/bootstrap-3.37.min.css">
	<script src="<?php echo base_url();?>css/localize/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url();?>css/localize/bootstrap-3.3.7.min.js"></script>
<script type="text/javascript">
	function isNumber(evt)
	{
		evt = (evt) ? evt : window.event;
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode > 31 && (charCode < 48 || charCode > 57)) 
		{
			return false;
		}
		return true;
	}
</script>
<?php
error_reporting(1);
$imageUpload = $this->uri->segment(5, 0);
$this->load->view('admin/templates/header.php');
?>
<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=false"></script>
<?php
if (!empty($product_details)) 
{
	$address = trim(stripslashes($product_details->row()->address));
	$lat = $product_details->row()->latitude;
	$long = $product_details->row()->longitude;

} 
else 
{
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

foreach ($newAddress as $nA) 
{
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
{
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
 
if ($lat != '' && $lang != '') 
{ ?>
	<script>
		var myLatlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
		var citymap = {};

		function initializeMapCircle() 
		{
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

			google.maps.event.addListener(marker, 'dragend', function () 
			{
				var newLatitude = this.position.lat();
				var newLongitude = this.position.lng();

				var pos = marker.getPosition();

				geocoder = new google.maps.Geocoder();
				geocoder = new google.maps.Geocoder();
				geocoder.geocode
				({
						latLng: pos
					},
					function (results, status) 
					{
						if (status == google.maps.GeocoderStatus.OK) 
						{
							var address = results[0].formatted_address;
							$("#address_location").val(address);
							$.ajax({
								type: 'post',
								url: baseURL + 'site/experience/get_location',
								dataType: 'json',
								data: {address: address},
								success: function (json) 
								{
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
										data: 
										{
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
										success: function (response) 
										{
										},
										error: function (request, status, error) 
										{
										}
									});
								},
								complete: function () 
								{

								}
							});
						}
						else 
						{
							console.log('Cannot determine address at this location.');
						}
					}
				);
			});

			/* Construct the circle for each value in citymap.*/
			/* Note: We scale the area of the circle based on the population.*/
			for (var city in citymap) 
			{
				var populationOptions = 
				{
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
<?php 
} 
else 
{ ?>
	<script>
		var myLatlng = new google.maps.LatLng(32, 72);
		var citymap = {};

		function initializeMapCircle() 
		{
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

			google.maps.event.addListener(marker, 'dragend', function () 
			{
				var newLatitude = this.position.lat();
				var newLongitude = this.position.lng();

				var pos = marker.getPosition();

				geocoder = new google.maps.Geocoder();
				geocoder = new google.maps.Geocoder();
				geocoder.geocode
				({
						latLng: pos
					},
					function (results, status) 
					{
						if (status == google.maps.GeocoderStatus.OK) 
						{
							var address = results[0].formatted_address;
							$("#address_location").val(address);
							$.ajax({
								type: 'post',
								url: baseURL + 'site/experience/get_location',
								dataType: 'json',
								data: {address: address},
								success: function (json) 
								{
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
										success: function (response) 
										{
										},
										error: function (request, status, error) 
										{
										}
									});
								},
								complete: function () 
								{

								}
							});
						}
						else 
						{
							console.log('Cannot determine address at this location.');
						}
					}
				);
			});

			/*Construct the circle for each value in citymap.
			Note: We scale the area of the circle based on the population.*/
			for (var city in citymap) 
			{
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

<script type="">
	function affectDateCount(category) 
	{
		if (category == '2') 
		{
			$("#date_count").val('1');
			$("#date_count").attr('readonly', 'readonly');
		} 
		else if (category == '1') 
		{
			$("#date_count").removeAttr('readonly');
		}
	}
</script>

<script type="text/javascript">

	$('input#price').blur(function () 
	{
		var num = parseFloat($(this).val());
		var cleanNum = num.toFixed(2);		
		if (num / cleanNum < 1) 
		{
			$('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
		}
	});
</script>
<!-- Script to validate inputs -->
<script type="text/javascript">
	function save_tab1()
	{
		var user_id = $('#current_user_id :selected').val();
		var type_id = $('#type_id').val();
		var pro_id = $('#prdiii').val();
		var price = $('#price').val();
		var security_deposit = $('#security_deposit').val();
		var currency = $('#currency').val();
		var cancellation_policy = $('#cancellation_policy :selected').val();
		var product_title = $('#product_title').val();
		var date_count = $('#date_count').val();

		var status = '1';
		if (product_title == '') 
		{
			$("#title_error").text("Enter your property title");
			return false;
		} 
		else 
		{
			$("#title_error").text("");
		}

		if (price == '') 
		{
			$("#price_error").text("Enter your Experience price");
			return false;
		} 
		else 
		{
			var cleanNum = (parseFloat(price)).toFixed(2);
			if (parseFloat(price) / cleanNum != 1) 
			{
				$('#price_error').text('Please enter only 2 decimal places, we have truncated extra points');
				return false;
			} 
			else 
			{
				$("#price_error").text("");
			}
		}

		if (security_deposit != '') 
		{
			var cleanNum = (parseFloat(security_deposit)).toFixed(2);

			if (parseFloat(security_deposit) / cleanNum != 1) 
			{
				$('#security_deposit_error').text('Please enter only 2 decimal places, we have truncated extra points');
				return false;
			} 
			else 
			{
				$("#security_deposit_error").text("");
			}
		}

		if (type_id == '') 
		{
			$("#type_id_error").text("Enter your Experience Type");
			return false;
		} 
		else 
		{
			$("#type_id_error").text("");
		}

		if (date_count == '')
		{
			$("#date_count_error").text("Enter date count");
			return false;
		} 
		else 
		{
			$("#date_count_error").text("");
		}

		if (pro_id != '' && pro_id != '0') 
		{
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/experience/savetab1',
				data: {
					'user_id': user_id,
					'experience_title': product_title,
					'pro_id': pro_id,
					'date_count': date_count,
					'type_id': type_id,
					'price': price,
					'security_deposit': security_deposit,
					'cancellation_policy': cancellation_policy,
					'status': status,
					'currency': currency
				},
				dataType: 'json',
				success: function (json) 
				{		
					if (json.resultval == 'Updated') 
					{
						alert('Added Successfully');
					}
				}
			});
		}
	}
</script>

<script type="text/javascript">


	function ImageAddClick() {
		var idval = $('#prdiii').val();
//alert(idval);
		$(".dragndrop1").colorbox({
			width: "1000px",
			height: "500px",
			href: baseURL + "admin/experience/dragimageuploadinsert/?id=" + idval
		});
	}
</script>


<script type="text/javascript">
	function delimage(val) 
	{
		$('#row' + val).remove();
	}

	$(function () 
	{
		/* product Add images dynamically */
		var i = 1;

		$('#add').click(function () 
		{
			$('<div id="row' + i + '" class="control-group field"><input type="text" class="small tipTop" name="imgtitle[]"  maxlength="25"  placeholder="Caption" /> <input class="small tipTop"  placeholder="Priority" name="imgPriority[]" type="text"><div class="uploader" id="uniform-productImage" style=""><input type="file" class="large tipTop" name="product_image[]" id="product_image" onchange="Test.UpdatePreview(this,' + i + ')" style="opacity: 0;"><span class="filename" style="-moz-user-select: none;">No file selected</span><span class="action" style="-moz-user-select: none;">Choose File</span></div><img style="display: inline-block; margin: 0 10px; position: relative;top: 13px;" class="img' + i + '" width="150" height="150" alt="" src="images/noimage.jpg"><a href="javascript:void(0);" onclick="return delimage(' + i + ');"><div class="rmv_btn">Remove</div></a></div></div><br />').fadeIn('slow').appendTo('.imageAdd');
			i++;
		});

		Test = {
			UpdatePreview: function (obj, ival) 
			{
				/*if IE < 10 doesn't support FileReader*/
				if (!window.FileReader) 
				{
					/*don't know how to proceed to assign src to image tag*/
				} 
				else
				{
					var reader = new FileReader();
					var target = null;

					reader.onload = function (e) 
					{
						target = e.target || e.srcElement;

						$(".img" + ival).prop("src", target.result);
					};
					reader.readAsDataURL(obj.files[0]);
				}
			}
		};

		$('#remove').click(function () 
		{
			if (i > 0) 
			{
				$('.field:last').remove();
				i--;
			}
		});

		$('#reset').click(function () 
		{
			$('.field').remove();
			$('.field').remove();
			$('#add').show();
			i = 0;
		});

		$('#add').click(function () 
		{
			if (i > 15) 
			{
				$('#add').hide();
			}
		});
	});
	/* end */
</script>

<script type="text/javascript">
	function updateDatabase(newLat, newLng) 
	{
		$('#latitude').val(newLat);
		$('#longitude').val(newLng);
		/* make an ajax request to a PHP file
		 on our site that will update the database
		 pass in our lat/lng as parameters*/
	}
</script>
</head>

<style>
	.form_container ul li 
	{
		position: static;
	}

	#map_canvas 
	{
		width: 50% !important;
	}
</style>

<script>
	$(document).ready(function () 
	{
		$('.nxtTab').click(function () 
		{
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.next().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
		});

		$('.prvTab').click(function () 
		{
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.prev().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
		});

		$('#tab2 input[type="checkbox"]').click(function ()
		{
			var cat = $(this).parent().attr('class');
			var curCat = cat;
			var catPos = '';
			var added = '';
			var curPos = curCat.substring(3);
			var newspan = $(this).parent().prev();

			if ($(this).is(':checked')) 
			{
				while (cat != 'cat1') 
				{
					cat = newspan.attr('class');
					catPos = cat.substring(3);
					if (cat != curCat && catPos < curPos) 
					{
						if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0)
						{
							/*Found it!*/
						} 
						else 
						{
							newspan.find('input[type="checkbox"]').attr('checked', 'checked');
							added += catPos + ',';
						}
					}
					newspan = newspan.prev();
				}
			} 
			else 
			{
				var newspan = $(this).parent().next();
				if (newspan.get(0)) 
				{
					var cat = newspan.attr('class');
					var catPos = cat.substring(3);
				}

				while (newspan.get(0) && cat != curCat && catPos > curPos) 
				{
					newspan.find('input[type="checkbox"]').attr('checked', this.checked);
					newspan = newspan.next();
					cat = newspan.attr('class');
					catPos = cat.substring(3);
				}
			}
		});

		<?php if($imageUpload != '0' && $imageUpload == 'image')
		{?>
		$('#nextImage').click();
		<?php 
		} ?>
	});
</script>

<script language="javascript">
	function viewAttributes(Val) 
	{
		if (Val == 'show') 
		{
			document.getElementById('AttributeView').style.display = 'block';
		} 
		else 
		{
			document.getElementById('AttributeView').style.display = 'none';
		}

	}
</script>

<script>
	$(document).ready(function () 
	{		
		var i = 1;

		$('#add').click(function () 
		{
			$('<div style="float: left; margin: 12px 10px 10px; width:85%;" class="field">' +
				'<div class="image_text" style="float: left;margin: 5px;margin-right:50px;">' +
				'<span>List Name:</span>&nbsp;' +
				'<select name="attribute_name[]" onchange="javascript:loadListValues(this)" style="width:200px;color:gray;width:206px;" class="chzn-select">' +
				'<option value="">--Select--</option>' +
				<?php foreach ($atrributeValue->result() as $attrRow)
				{
				if (strtolower($attrRow->attribute_name) != 'price')
				{
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

		$('#remove').click(function () 
		{
			$('.field:last').remove();
		});

		$('#reset').click(function () 
		{
			$('.field').remove();
			$('#add').show();
			i = 0;
		});


		var j = 1;
		$('#addAttr').click(function () 
		{
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

		$('#removeAttr').click(function () 
		{
			$('.field:last').remove();
		});
	});
</script>

<script>
	function runScript(event) 
	{
		if (!((event.keyCode >= 65) && (event.keyCode <= 90) || (event.keyCode >= 97) && (event.keyCode <= 122) || (event.keyCode >= 48) && (event.keyCode <= 57))) 
		{
			event.returnValue = false;
			return;
		}
		event.returnValue = true;
	}
</script>

<script src="js/admin/addExperience.js"></script>

<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top"><span class="h_icon list"></span>
					<?php echo $this->config->item('google_map_api'); ?>
					<?php if (!empty($product_details)) { ?>
						<h6>Edit Property</h6>
					<?php } else { ?><h6>Add New Property</h6><?php } ?>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">General Information</a></li>
							<li><a href="#tab2">Images</a></li>
							<li><a href="#tab3">Schdules</a></li>
							<li><a href="#tab4">Address & Availability Information</a></li>
							<li><a href="#tab5">Experience Details </a></li>
							<li><a href="#tab6">Group & Guest Deatils</a></li>
							<li><a href="#tab7">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$formattr = array('class' => 'form_container left_label listingInfo', 'id' => 'addproduct_form1111', 'enctype' => 'multipart/form-data', 'onkeypress' => 'return event.keyCode != 13;', 'accept-charset' => 'UTF-8');
					echo form_open_multipart('admin/experience/UpdateExperience', $formattr)
					?>						
						<input type="hidden" name="latitude" id="latitude"
							   value="<?php if ($productOldAddress->row()->latitude != '') echo $productOldAddress->row()->latitude; else echo $lat; ?>"/>
						<input type="hidden" name="longitude" id="longitude"
							   value="<?php if ($productOldAddress->row()->longitude != '') echo $productOldAddress->row()->longitude;
							   echo $lang; ?>"/>
						<input type="hidden" name="prdiii" id="prdiii" value="<?php if (!empty($product_details)) {
							echo trim(stripslashes($product_details->row()->id));
						} else {
							echo "0";
						} ?>"/>
						<div id="tab1">
							<ul class="tab-areas1">
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Experience Owner Name <span
												class="req">*</span></label>
										<div class="form_input">
											<?php
											if (!empty($userdetails)) {
												echo '<select name="user_id" id="current_user_id">';
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


										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="product_title">Title <span class="req">*</span></label>
										<div class="form_input">
											<?php if (!empty($product_details)) {
												$Valid = trim(stripslashes($product_details->row()->id));
											} else {
												$Valid = 0;
											} ?>
											<input name="product_title" id="product_title" type="text" tabindex="1"
												   class="required large tipTop" title="Please enter the Property name"
												   onkeypress="//return runScript(event);"
												   onkeydown=" return (event.keyCode!=13);"
												   value="<?php if (!empty($product_details)) {
													   echo trim(stripslashes($product_details->row()->product_title));
												   } ?>"/><span id="product_title_error"
																style="color:#f00;display:none;"> Special Characters are not allowed!</span>
											<span id="title_error" style="color:red;"></span>
										</div>

									</div>
								</li>


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Experience Category <span
												class="req">*</span></label>
										<div class="form_input">
											<?php if (empty($product_details)) { ?>
												<select style="" class="other-opt" onblur="affectDateCount(this.value)"
														onchange="affectDateCount(this.value)" id="home_type_new"
														name="experience_category" required>

													<option value="">--<?php if ($this->lang->line('select') != '') {
															echo stripslashes($this->lang->line('select'));
														} else echo "select"; ?>--
													</option>


													<option value="1">Immersions</option>
													<option value="2">Experiences</option>

												</select>
												<span id="category_id_error" style="color:red;"></span>
											<?php } else { ?>
												<span
													class=""><?php if ($product_details->row()->date_count > 1) echo "Immersions"; else echo "Experience"; ?></span>
											<?php } ?>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Experience Type <span
												class="req">*</span></label>
										<div class="form_input">
											<select class="gends" id="type_id" name="type_id">
												<option value=""><?php if ($this->lang->line('select') != '') {
														echo stripslashes($this->lang->line('select'));
													} else echo "Select"; ?></option>
												<?php
												foreach ($experienceTypeList->result() as $type) { ?>
													<option
														value="<?php echo $type->id; ?>" <?php if (!empty($product_details)) {
														if (trim($type->id) == trim($product_details->row()->type_id)) echo 'selected="selected"';
													} ?> ><?php echo ucfirst($type->experience_title); ?></option>
													<?php
												}
												?>


											</select>
											<span id="type_id_error" style="color:red;"></span>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="date_count">Date Count <span
												class="req">*</span></label>
										<div class="form_input">
											<label class="" for="date_count"><span class="req"></span></label>
											<?php if (empty($product_details)) { ?>
												<input class="select-bor" style="width:50%" type="number" min="1"
													   name='date_count' id='date_count' placeholder="Enter Date Count"
													   onchange="javascript:experienceAdminDetailview(this,document.getElementById('prdiii').value,'date_count');"/>

												<span id="date_count_error" style="color:red;"></span>
											<?php } else { ?>
												<span class=""><?php echo $product_details->row()->date_count; ?></span>
												<input class="select-bor" style="width:50%" type="hidden" min="1"
													   name='date_count' id='date_count'
													   value='<?php echo $product_details->row()->date_count; ?>'
													   placeholder="Enter Date Count"/>
											<?php } ?>
										</div>

									</div>
								</li>


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="currency">Currency <span
												class="req">*</span></label>
										<div class="form_input">
											<?php
											if (!empty($currencyList)) {
												echo '<select name="currency" id="currency">';
												foreach ($currencyList->result() as $currencies) {


													?>

													<option
														value="<?php echo $currencies->currency_type; ?>" <?php if (!empty($product_details)) {
														if ($currencies->currency_type == $product_details->row()->currency) {
															echo 'selected="selected"';
														}
													} ?>><?php echo $currencies->currency_type; ?></option>

													<?php
												}
												echo '</select>';
											} ?>


										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="price">Price<span class="req">*</span></label>
										<div class="form_input">
											<label class="" for="price"><span class="req"></span></label>
											<input type="text" onkeypress="return isNumber(event)" name="price"
												   id="price" tabindex="9" class="required large tipTop"
												   title="Please enter the property price"
												   value="<?php if (!empty($product_details)) {
													   echo trim(stripslashes($product_details->row()->price));
												   } ?>"
												   onchange="javascript:PriceInsert(this.value,document.getElementById('prdiii').value,'price');"/><span
												id="price_error_valid" style="color:#f00;display:none;"> Only Numbers are not allowed!</span>

											<span id="price_error" style="color:red;"></span>
										</div>

									</div>
								</li>


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Deposit Amount</label>
										<div class="form_input">
											<label class="" for="price"><span class="req"></span></label>
											<input type="text" class="required large tipTop" name="security_deposit"
												   title="Please enter the deposit amount" id="security_deposit"
												   style="  width: 379px;" value="<?php if (!empty($product_details)) {
												if ($product_details->row()->security_deposit != '') {
													echo trim(stripslashes($product_details->row()->security_deposit));
													//echo $product_details->row()->security_deposit;
												}
											} ?>"><span id="security_deposit_error_valid"
														style="color:#f00;display:none;"> Only Numbers are not allowed!</span>
											<span id="security_deposit_error" style="color:red;"></span>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="user_id">Cancellation Policy <span
												class="req">*</span></label>
										<div class="form_input">
											<select class="gends" id="cancellation_policy" name="cancellation_policy">


												<option value="Flexible" <?php if (!empty($product_details)) {
													if ($product_details->row()->cancel_policy == 'Flexible') {
														echo 'selected="selected"';
													}
												} ?>>Flexible
												</option>
												<option value="Moderate" <?php if (!empty($product_details)) {
													if ($product_details->row()->cancel_policy == 'Moderate') {
														echo 'selected="selected"';
													}
												} ?>>Moderate
												</option>
												<option value="Strict" <?php if (!empty($product_details)) {
													if ($product_details->row()->cancel_policy == 'Strict') {
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
										<label class="field_title" for="admin_name">Status <span
												class="req">*</span></label>
										<div class="form_input">
											<div class="publish_unpublish">
												<input type="checkbox" tabindex="11" name="status" checked="checked"
													   id="publish_unpublish_publish" class="publish_unpublish"/>
											</div>
										</div>
									</div>
								</li>


								<li>
									<div class="form_grid_12">
										<div class="exp-button">
											<input type="button" class="btn_small btn_blue nxtTab" id="nextImage"
												   tabindex="9" value="Next"/>
											<input type="button" class="btn_small btn_blue" value="Save"
												   onclick="save_tab1();"/>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div id="tab2">
							<ul class="tab-areas2">
								<li>


									<?php //include('img_upload.php'); ?>

									<div class="form_grid_12">
										<label class="field_title" for="product_image">Experience Image <span
												class="req">*</span></label>


										<span class="dragndrop1"><a href="javascript:void(0);"
																	onclick="ImageAddClick();">Choose Image</a></span>
									</div>
								</li>
								<li>
									<div class="widget_content">
										<table class="display display_tbl" id="image_tbl">
											<thead>
											<tr align="center">
												<th> Sno</th>
												<th> Image</th>
												<!--<th> Position </th>-->
												<th> Action</th>
											</tr>
											</thead>
											<tbody>
											<?php
											// echo "<pre>";print_r($imgDetail->result_array());
											if (!empty($imgDetail) && !empty($product_details)) {
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
																	src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "server/php/experience/" . $img->product_image; ?>"
																	height="80px" width="80px"/></td>
															<td class="center tr_select">
																<ul class="action_list"
																	style="background:none;border-top:none;">
																	<li style="width:100%; border-bottom: none;"><a
																			class="p_del tipTop"
																			href="javascript:void(0)"
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
											}
											?>
											</tbody>
											<tfoot>
											<tr align="center">
												<th> Sno</th>
												<th> Image</th>
												<!--<th> Position </th>-->
												<th> Action</th>
											</tr>
											</tfoot>
										</table>
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
										<div class="exp-button">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<input type="button" class="btn_small btn_blue nxtTab" tabindex="9"
												   value="Next"/>
										</div>
									</div>
								</li>
							</ul>
						</div>

						<div id="tab3">

							<ul class="1tab-areas3">


								<input type="hidden" name="" id="edit_pro_id"
									   value="<?php echo $this->uri->segment(4); ?>">

								<li>

									<input type="hidden" class=" col-sm-2" id="experience_id" name="experience_id"
										   value="<?php echo $product_details->row()->experience_id; ?>"/>
									<input type="hidden" class=" col-sm-2" id="dates_id" name="dates_id"/>

									<div class="form_grid_12">
										<label class="field_title" style="width: 30%;" for="user_id">Schedule <span
												class="req">*</span></label>
										<div class="form_input">
											<?php if ($product_details->row()->date_count > 1) { ?>


												<div class="col-md-4 col-xs-12 no-padding">
													<label class="field_title service_det_edit" for="datetimepicker1">From
														Date: </label>
													<input type="text" class="dev_tour_date col-sm-2"
														   id="datetimepicker1" onclick="datepick();" name="from_date"/>
												</div>

												<div class=" col-md-4 col-xs-12 no-padding">
													<label class="field_title service_det_edit" for="to_date">To
														Date: </label>
													<input type="text" class=" col-sm-2" id="to_date" name="to_date"
														   readonly value=""/>
												</div>
												<!--
									<div class=" col-md-4 col-xs-12 no-padding">
										<label class="field_title service_det_edit" for="to_date">Price: </label>

										<input type="text" class=" col-sm-2"  id="price" name="price"  value=""/>
									</div>

									-->


											<?php } else {
												?>
												<div class="col-md-4 col-xs-12 no-padding">
													<label class="field_title service_det_edit" for="datetimepicker1">Date: </label>
													<input type="text" class="dev_tour_date col-sm-2"
														   id="datetimepicker1" onclick="datepick();"
														   onchange='affectTodate()' name="from_date"/>
													<input type="hidden" class=" col-sm-2" id="to_date" name="to_date"
														   readonly value=""/>
												</div>
												<!--
		                        	<div class=" col-md-4 col-xs-12 no-padding">
										<label class="field_title service_det_edit" for="to_date">Price: </label>

										<input type="text" class=" col-sm-2"  id="price" name="price"  value="<?php //echo $product_details->row()->price;  ?>" readonly/>
									</div>
									-->


												<?php
											} ?>

										</div>
									</div>


									<!--- Experiece Panel 1-->
								<li class="popup-panel-exp" id='dev_add_date_timing' style='display: none;'>
									<ul>
										<li>
											<div class="form_grid_12">
												<label class="field_title" for="user_id">Date<span class="req">*</span></label>
												<div class="form_input">
													<?php if ($product_details->row()->date_count > 1) { ?>
														<input type="text" class="dev_multi_schedule_date col-sm-2"
															   id="schedule_date1" onkeypress="return isNumber(event)"
															   name="schedule_date[]" onclick="setDatepickerHere();"/>
													<?php } else { ?>
														<input type="text"
															   class="dev_tour_date dev_schedule_date col-sm-2"
															   id="schedule_date1" name="schedule_date[]" readonly/>
														<?php
													} ?>
												</div>
											</div>
										</li>

										<li>
											<div class="form_grid_12">
												<label class="field_title" for="user_id">Start Time<span
														class="req">*</span></label>
												<div class="form_input">
													<input type="text" class="dev_time" name="start_time[]"
														   onkeypress="return isNumber(event)" value="" required/>
												</div>
											</div>
										</li>
										<li>
											<div class="form_grid_12">
												<label class="field_title" for="user_id">End Time <span
														class="req">*</span></label>
												<div class="form_input">
													<input type="text" class="dev_time" name="end_time[]"
														   onkeypress="return isNumber(event)" value="" required/>
												</div>
											</div>
										</li>
										<li>

											<div class="form_grid_12">
												<label class="field_title" for="user_id">Title <span
														class="req">*</span></label>
												<div class="form_input">
													<input type="text" class="" name="schedule_title[]" value=""
														   required/>
												</div>
											</div>
										</li>
										<li>
											<div class="form_grid_12">
												<label class="field_title" for="user_id">Description <span
														class="req">*</span></label>
												<div class="form_input">
													<textarea class="" required
															  name="schedule_description[]"></textarea>
												</div>
											</div>
										</li>
										<li class="exp-button">

											<button type="button" class="btn_small" id='add_timing_btn_1'
													onclick="add_timing_row(1)"><i class="fa fa-plus-circle"
																				   aria-hidden="true"></i>Add New
											</button>
										</li>
									</ul>
								</li>

								<?php for ($i = 1; $i < 50; $i++) {
									?>
									<div id="dev_new_timing<?php echo $i; ?>"></div>

									<?php
								} ?>

								<li class="exp-button">
									<button style='display:  none; clear: both;' type="button" class="btn_small"
											id='save_timing_btn' onclick="save_timing()">Save Timing
									</button>
								</li>
								<!--- Experiece Panel End-->

								<li class="she-add-date">
									<button type="button" class="btn_small" id='add_btn' title="Add Date"
											onclick="add_dates()"><i class="fa fa-plus-circle" aria-hidden="true"></i>Add
										Date
									</button>
								</li>

								<li class="exp-button">
									<input type="button" class="filter-btn btn_small" id="update_btn"
										   style="display: none" name="" value="Update Date" onclick="update_tab2()">
									<input type="reset" class="filter-btn btn_small" id="reset_btn"
										   style="display: none;" name="" value="Cancel" onclick="reset_reload()">

								</li>


								</li>

								<li>
									<table id="example" cellspacing="0" width="100%" border="1"
										   class="table table-striped display">
										<thead>
										<tr>
											<th>Start Date</th>
											<th>End Date</th>
											<!--<th>Price</th>-->

											<th>Action</th>
										</tr>


										</thead>
										<tbody>
										<?php
										// print_r($listchildvalues->result());
										// exit();
										if ($date_details->num_rows() > 0) {
											$i = 1;
											foreach ($date_details->result() as $row) {
												/* check for booking exist for tha particular schedule if exist dont allow to edit & delete */

												//$check_booking_entry = $this->experience_model->ExecuteQuery("select * from ".EXPERIENCE_ENQUIRY." where 	prd_id='".$row->experience_id."' and checkin='".$row->from_date."' and checkout='".$row->end_date."'");

												$check_booking_entry = $this->experience_model->ExecuteQuery("select * from " . EXPERIENCE_ENQUIRY . " where prd_id='" . $row->experience_id . "' and checkin='" . date('Y-m-d', strtotime($row->from_date)) . "' and checkout='" . date('Y-m-d', strtotime($row->to_date)) . "'");
												?>
												<tr>

													<td><?php echo $row->from_date; ?></td>
													<td><?php echo $row->to_date; ?></td>

													<!--<td><?php echo $row->price; ?> </td>-->

													<td>

														<?php if ($check_booking_entry->num_rows() == 0)  //$product_details->row()->status == '0'
														{
															if (date('Y-m-d', strtotime($row->from_date)) > date('Y-m-d'))    /* schedule once started  means no edit priviledge */ {
																?>
																<span class="action-icons c-edit"
																	  onclick="javascript:get_activity_data('<?php echo $row->experience_id; ?>','<?php echo $row->id; ?>','<?php echo $row->from_date; ?>','<?php echo $row->to_date; ?>','<?php echo $row->price; ?>');"
																	  title="Edit"
																	  style="cursor: pointer;"><?php if ($this->lang->line('back_Edit') != '') {
																		echo stripslashes($this->lang->line('back_Edit'));
																	} else echo "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>"; ?></span>
																<span style="vertical-align: top;"> | </span>

															<?php } ?>
															<span><a class="action-icons c-delete"
																	 href="admin/experience/delete_date/<?php echo $row->id; ?>/<?php echo $row->experience_id; ?>"
																	 title="Delete"><i
																		class="fa fa-trash-o delete-icon fa-lg"
																		aria-hidden="true"></i> </a></span>
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
										</tbody>

									</table>


								</li>

								<li class="btnsa" style="text-align: center;">
									<div class="form_grid_12">
										<div class="form_input" style="margin:0px;width:100%;">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<input type="button" class="btn_small btn_blue nxtTab" tabindex="9"
												   value="Next"/>
											<?php /* <input type="button" class="btn_small btn_blue" value="Save" onclick="save_tab3();" />
								*/ ?>
										</div>
									</div>
								</li>
							</ul>

						</div>


						<div id="tab4">
							<ul id="AttributeView">
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="address">Location <span
												class="req">*</span></label>
										<div class="form_input">
											<input id="autocomplete-admin" name="address" onblur="getAddressDetails();"
												   placeholder="" onFocus="geolocate()" type="text"
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
												   value="<?php if ($productAddressData->row()->country != '') echo $productAddressData->row()->country; //echo $country;?>"
												   style="width:370px;" class="large tipTop" title="Enter Country Name"><span
												id="country_error_valid" style="color:#f00;display:none;">Only Alphabets allowed!</span>
											<span id="country_error" style="color:red;">
					</span>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="state">State<span class="req">*</span></label>
										<div class="form_input" id="listCountryCnt">
											<input placeholder="" id="state" name="state" type="text"
												   value="<?php if ($productAddressData->row()->state != '') echo $productAddressData->row()->state; //echo $state;?>"
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
												   //echo $city;?>" style="width:370px;" class="large tipTop"
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
												class="req"></span></label>
										<div class="form_input">
											<?php // echo "<pre>"; print_r($productAddressData->result()); ?>
											<input type="text" name="post_code" id="post_code" tabindex="8"
												   class="large tipTop" title="Please enter the post code"
												   value="<?php if ($productAddressData->row()->zip != '') echo $productAddressData->row()->zip; // echo $zip;?>"/><span
												id="post_code_error_valid" style="color:#f00;display:none;">Only Alphabets allowed!</span><span
												id="post_code_length_error" style="color:red;"></span>
										</div>

										<div style="margin-left:30%;margin-top:10px;">
											<?php if (!empty($product_details)) {
												$in_address = trim(stripslashes($product_details->row()->address)); ?>
												<img id='map-image' border="0" alt="Greenwich, England"
													 src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>">
												<!--<img id='map-image' border="0" alt="Greenwich, England" src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $in_address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $in_address; ?>">
				<img id='map-image' border="0" alt="Greenwich, England" src="http://maps.googleapis.com/maps/api/staticmap?center=Albany,+NY&zoom=13&scale=false&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7CAlbany,+NY" alt="Google Map of Albany, NY">-->
											<?php } ?>
											<div align="center" id="map-new"
												 style="width: 600px; height: 300px; display:none"><p id='map-text'
																									  style="margin-top:150px;">
													Map will be displayed here</p></div>

										</div>

									</div>
								</li>


							</ul>
							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input exp-button" style="margin:0px;width:100%;">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<input type="button" class="btn_small btn_blue nxtTab" tabindex="9"
												   value="Next"/>
											<input type="button" class="btn_small btn_blue" value="Save"
												   onclick="save_tab4();"/>
										</div>
									</div>
								</li>
							</ul>
						</div>


						<div id="tab5">
							<ul>

								<h3>Experience Details</h3>
								<p>A description of your experience displayed on your public listing page. </p>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="space">The Experience Description</label>
										<div class="form_input">
											<textarea name="experience_description" id="experience_description"
													  tabindex="13" style="width:370px;height:100px;"
													  class="large tipTop"
													  title="what makes  your listing unique ?"><?php if (!empty($product_details)) {
													echo trim(stripslashes($product_details->row()->experience_description));
												} ?></textarea>
										</div>

									</div>

								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="short_description">The Experience
											subtitle</label>
										<div class="form_input">
											<textarea name="short_description" id="short_description" tabindex="13"
													  style="width:370px;height:100px;" class="large tipTop"
													  title="what makes  your listing unique ?"><?php if (!empty($product_details)) {
													echo trim(stripslashes($product_details->row()->short_description));
												} ?></textarea>
										</div>

									</div>

								</li>


								<li>
									<div class="form_grid_12">
										<label class="field_title" for="location_description">The Location
											Description</label>
										<div class="form_input">
											<textarea name="location_description" id="location_description"
													  tabindex="13" style="width:370px;height:100px;"
													  class="large tipTop"
													  title="what makes  your listing unique ?"><?php if (!empty($product_details)) {
													echo trim(stripslashes($product_details->row()->location_description));
												} ?></textarea>
										</div>

									</div>

								</li>


								<li>

									<span class="my-edit-lbl"
										  for="emailaddress"><h3><?php echo "Language"; ?></h3></span>
									<div class="exp-admin-lang">
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
										$languages_known_user = explode(',', $product_details->row()->language_list);
										if (count($languages_known_user) > 0) { ?>
											<ul class="inner_language">
												<?php
												foreach ($languages_known->result() as $language) {
													if (in_array($language->language_code, $languages_known_user)) { ?>
														<li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name; ?>
															<small>
																<a class="text-normal" href="javascript:void(0);"
																   onclick="delete_languages(this,'<?php echo $language->language_code; ?>')">x</a>
															</small>
														</li>
													<?php }
												} ?>
											</ul>
										<?php } ?>
									</div>

								</li>

								<li>


									<h3 style="padding: 0 9px; margin-top: 0px;">Guide Provides</h3>
									<input type="hidden" class=" col-sm-2" id="kit_id" name="kit_id"/>
									<div class="form_grid_12">
										<label class="field_title" for="main_title">Main Title:<span class="req"></span></label>
										<div class="form_input">

											<input type="text" class=" " id="main_title" name="main_title"/>
										</div>
									</div>
								</li>
								<li>

									<div class="form_grid_12">
										<label class="field_title" for="detailed_title">Detailed Title:<span
												class="req"></span></label>
										<div class="form_input">

											<input type="text" class=" col-sm-2" id="detailed_title"
												   name="detailed_title" value=""/>
										</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title service_det_edit" for="kit_count">Count: </label>
										<div class="form_input">
											<input type="text" class=" col-sm-2" id="kit_count" name="kit_count"
												   value=""/>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title service_det_edit"
											   for="kit_description">description </label>
										<div class="form_input">
											<textarea class="title_overview" id="kit_description"
													  placeholder="Description the kit contains" rows="8"
													  name="kit_description" id="kit_description"
													  style="color:#000 !important;min-width:100%;max-width:100%;"></textarea>
										</div>
									</div>
								</li>
								<li>


									<div class="exp-button">
										<button type="button" class="next_button btn_small" id='add_kit_btn'
												onclick="add_kit()" style="width:100px;">Add
										</button>
										<input type="button" class="filter-btn" id="update_kit_btn"
											   style="display: none;" name="" value="Update"
											   onclick="update_kit_tab2()">
										<input type="reset" class="filter-btn" id="reset_kit_btn" style="display: none;"
											   name="" value="Cancel" onclick="reset_reload()">
									</div>

								</li>

								<li>

									<div class="webform" method="post" id="hourly">
										<div class="managlist_tabl" id="package_table">
											<table id="example" cellspacing="0" width="100%" border="1"
												   class="table table-striped display">
												<thead>
												<tr>
													<th>Title</th>
													<th>Details</th>
													<th>Count</th>
													<th>Description</th>
													<th>Action</th>
												</tr>


												</thead>
												<tbody>
												<?php
												// print_r($listchildvalues->result());
												// exit();
												if ($guide_provides->num_rows() > 0) {
													$i = 1;
													foreach ($guide_provides->result() as $row) {


														?>
														<tr>

															<td><?php echo $row->kit_title; ?></td>
															<td><?php echo $row->kit_detailed_title; ?></td>

															<td><?php echo $row->kit_count; ?> </td>
															<td><?php echo $row->kit_description; ?></td>
															<td>

																<?php // if($product_details->row()->status == '0') {

																$descrpt = str_replace("'", '`', $row->kit_description);
																?>
																<span class="action-icons c-edit"
																	  onclick="get_kit_data('<?php echo $row->id; ?>','<?php echo $row->kit_title; ?>','<?php echo $row->kit_detailed_title; ?>','<?php echo $row->kit_count; ?>','<?php echo $descrpt; ?>');"
																	  title="Edit"
																	  style="cursor: pointer;"><?php if ($this->lang->line('back_Edit') != '') {
																		echo stripslashes($this->lang->line('back_Edit'));
																	} else echo "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>"; ?></span>
																|


																<span><a class="action-icons c-delete"
																		 href="admin/experience/delete_kit_package/<?php echo $row->id; ?>/<?php echo $row->product_id; ?>"
																		 title="Delete"><i
																			class="fa fa-trash-o delete-icon fa-lg"
																			aria-hidden="true"></i> </a></span>
																<?php // }
																?>
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
												</tbody>

											</table>


										</div>

									</div>
									<!-- Kit content selection Ends  -->

								</li>

								<li>
									<div class="form_grid_12">
										<div class="form_input exp-button" style="margin:0px;width:100%;">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<input type="button" class="btn_small btn_blue nxtTab" tabindex="9"
												   value="Next"/>
											<input type="button" class="btn_small btn_blue" value="Save"
												   onclick="save_tab5();"/>
										</div>
									</div>
								</li>
							</ul>
						</div>

						<div id="tab6">
							<ul>


								<h3>Guest & Guide Details </h3>
								<p></p>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="confirm_email">About Group Size </label>
										<div class="form_input">
											<textarea name="group_size" id="space" tabindex="13"
													  style="width:370px;height:100px;" class="large tipTop"
													  title="what makes  your listing unique ?"><?php if (!empty($product_details)) {
													echo trim(stripslashes(ucfirst($product_details->row()->group_size)));
												} ?></textarea>

										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="confirm_email">Guest requirements </label>
										<div class="form_input">
											<textarea name="guest_requirement" id="guest_requirement" tabindex="13"
													  style="width:370px;height:100px;" class="large tipTop"
													  title="what makes  your listing unique ?"><?php if (!empty($product_details)) {
													echo trim(stripslashes(ucfirst($product_details->row()->guest_requirement)));
												} ?></textarea>
										</div>
									</div>
								</li>


							</ul>
							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input exp-button" style="margin:0px;width:100%;">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<input type="button" class="btn_small btn_blue nxtTab" tabindex="9"
												   value="Next"/>
											<input type="button" class="btn_small btn_blue" value="Save"
												   onclick="save_tab6();"/>
										</div>
									</div>
								</li>
							</ul>
						</div>

						<div id="tab7">
							<ul>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="meta_title">Meta Title<span class="req">*</span></label>
										<div class="form_input">
											<input name="meta_title" id="meta_title" type="text" tabindex="1"
												   class="required large tipTop"
												   title="Please enter the page meta title"
												   value="<?php if (!empty($product_details)) {
													   echo trim(stripslashes($product_details->row()->meta_title));
												   } ?>"/>
										</div>
									</div>
								</li>

								<li>
									<div class="form_grid_12">
										<label class="field_title" for="description">Keywords<span class="req">*</span></label>
										<div class="form_input">

											<textarea name="meta_keyword" id="meta_keywords" tabindex="13"
													  style="width:370px;height:150px;" class="required large tipTop"
													  title="Please enter the keywords"><?php if (!empty($product_details)) {
													echo trim(stripslashes($product_details->row()->meta_keyword));
												} ?></textarea>
										</div>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="description">Meta Description<span
												class="req">*</span></label>
										<div class="form_input">
											<textarea name="meta_description" id="meta_description" tabindex="13"
													  style="width:370px;height:150px;" class="required large tipTop"
													  title="Please enter the meta description"> <?php if (!empty($product_details)) {
													echo trim(stripslashes($product_details->row()->meta_description));
												} ?></textarea>
										</div>
									</div>
								</li>


							</ul>
							<ul>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<input type="button" class="btn_small btn_blue prvTab" tabindex="9"
												   value="Previous"/>
											<button type="submit" class="btn_small btn_blue" tabindex="4">
												<span>Submit</span></button>
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
						</li>
					</form>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span></div>
</div>


<?php
$this->load->view('admin/templates/footer.php');
?>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">
					<a class="close" aria-hidden="true" data-dismiss="modal" type="button"><i class="fa fa-times"
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
												name="languages[]" value="<?php echo $language->language_code; ?>"
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
												name="languages[]" value="<?php echo $language->language_code ?>"
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


<script type="text/javascript">


	$(function () {

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
				// alert(languages_known);
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url()?>site/experience/update_languages',
					data: {languages_known: languages_known, experience_id: expID},
					success: function (response) {
						//alert(response);
						$('.inner_language').html(response.trim());
					}
				});

			}
		});
	});

	function delete_languages(elem, language_code) {
		var expID = $("#experience_id").val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>site/experience/delete_languages',
			data: {language_code: language_code, experience_id: expID},
			dataType: 'json',
			success: function (response) {
				if (response['status_code'] == 1) {
					$(elem).closest('li').remove();
					//window.location.reload(true);
				}
			}
		});
	}

</script>


<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="js/jquery.timepicker.css"/>

<script type="text/javascript" src="js/jquery.datePicker.js"></script>

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
		/*
	$('.dev_multi_schedule_date').datepicker({
		changeMonth: true,
		dateFormat: 'yy-mm-dd',
		numberOfMonths: 1,
		minDate:0
	});
	*/
	}

	function datepick() {
		//datepicker
		$('.dev_tour_date').datepicker({
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			minDate: 0,
			onSelect: function (selected) {
				//alert(selected);
				//var selectedDate = new Date(selected);
				/*var tomorrow = new Date();
	        date_count = Number(<?php echo $product_details->row()->date_count; ?>);
			selectedDate.setDate(selectedDate.getDate() + date_count);
	        //var endDate = selected;
	       // alert(selectedDate.getDate() );
	      	$("#to_date").val(selectedDate);

	      	*/
				date_count = Number(<?php echo $product_details->row()->date_count; ?>);

				if (date_count == 1) {
					$(".dev_schedule_date").val(selected);
				}

				$.ajax({
					type: 'POST',
					url: '<?php echo base_url()?>site/experience/todateCalculate',
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

	/* edit existing dates  ends */


</script>


<script type="text/javascript">


	//Add new Date
	function add_dates() {

		var from_date = $("#datetimepicker1").val();
		var to_date = $("#to_date").val();
		//var price 			= $("#price").val();
		var experience_id = $("#experience_id").val();
		//var dev_exp_currency= $("#currency").val();

		if (from_date != '' && to_date != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>site/experience/saveDates',
				//data:{from_date:from_date,to_date:to_date,price:price,experience_id:experience_id,currency:dev_exp_currency},

				data: {from_date: from_date, to_date: to_date, experience_id: experience_id},
				dataType: 'json',
				success: function (data) {
					if (data.case == 1) {
						//$("div.added").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");

						$('#dates_id').val(data.date_id);


						$('#add_btn').css('display', 'none');
						$('#dev_add_date_timing').css('display', 'block');
						$('#save_timing_btn').css('display', 'inline-block');
						setDatepickerHere();//set datepicker
						//save_timing();
						//window.location.reload();
					}
					else if (data.case == 2) {
						//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");


						window.location.reload();
					}
					else if (data.case == 3) {
						alert('Already Exists');
					}
					else if (data.case == 4) {
						alert('Not Valid Times');
						$('#datetimepicker1').val('');
						$('#to_date').val('');
					}
				}
			});
		}
		else {
			/*if( price!='' || dev_exp_currency!='' )
			alert('Please fill price/currency in Basic Details .');
		else*/
			alert('Please fill all data');
		}
	}

	/* add timing of new dates */
	function add_timing_row(rowID) {
		date_count = Number(<?php echo $product_details->row()->date_count; ?>);
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
				$('.dev_time').timepicker({
					'minTime': '12:00am',
					'maxTime': '11:59pm',
					'timeFormat': 'H:i',
					'step': 60,
				});
				setDatepickerHere();//set datepicker
			}
		});
	}

	/* add timing of new dates  ends*/



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
		schedule_description = $("textarea[name='schedule_description[]']").map(function () {
			return $(this).val();
		}).get();
		//alert(schedule_description);
		//alert(schedule_date);
		error = error_in_mandatory = error_time = error_time_des = 0;
		//alert(schedule_date);
		for (i = 0; i < start_time.length; i++) {
			if (schedule_title[i] == '') {
				error = error + 1;
			}
			if (schedule_description[i] == '') {
				error_time_des = error_time_des + 1;
			}
			if (start_time[i] == '' || end_time[i] == '' || schedule_date[i] == '') {
				error_in_mandatory = error_in_mandatory + 1;
			}
			//alert(start_time[i]>end_time[i]);
			if (start_time[i] > end_time[i]) {
				error_time = error_time + 1;
			}
		}
		if (error == 0 && error_in_mandatory == 0 && error_time == 0 && error_time_des == 0) {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>site/experience/save_date_schedule_timing',
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
					//window.location.reload(true);

					//$("#experience_id").val(response);

					if (data.case == 1) {
						alert('Invalid Schedule Periods.');
						window.location.reload();
					}
					else if (data.case == 2) {
						alert("Schedule Period saved successfully.");
						window.location.reload();
					}
				}
			});
		} else {
			if (error > 0) {
				alert('Title is required');
			}
			if (error_time_des > 0) {
				alert('Description is required');
			}
			else if (error_in_mandatory > 0) {
				alert('Please fill all fields.');
			} else if (error_time >= 0) {
				alert('Start time should be less than end time.');
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
				url: '<?php echo base_url()?>site/experience/delete_timing_row',
				data: {row_id: row_id},
				success: function (response) {
					//alert(response);
					window.location.reload(true);


				}
			});
		} else {

		}

	}

	/* edit existing dates  starts */
	function get_activity_data(exp_id, date_id, start_date, end_date, price) {

		$('#dates_id').val(date_id);
		$('#datetimepicker1').val(start_date);
		$('#to_date').val(end_date);
		//$('#price').val(price);


		//$('#child_price').val(child_price);

		$('#add_btn').hide();


		$('#dev_add_date_timing').css('display', 'block');
		$('#save_timing_btn').css('display', 'none');
		//$('#save_timing_btn').css('display','inline-block');

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>admin/experience/get_timing',
			data: {experience_id: exp_id, date_id: date_id},
			success: function (response) {
				$('#dev_add_date_timing').html(response);
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
		//var price 			= $('#price').val();
		var experience_id = $('#experience_id').val();
		//var dev_exp_currency= $("#dev_exp_currency").val();

		if (from_date != '' && to_date != '' && price != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>site/experience/updateDates',
				//data:{date_id:date_id,from_date:from_date,to_date:to_date,price:price,experience_id:experience_id,currency:dev_exp_currency},
				data: {date_id: date_id, from_date: from_date, to_date: to_date, experience_id: experience_id},
				dataType: 'json',
				success: function (data) {
					//alert(data.case);
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
						schedule_description = $("input[name='schedule_description[]']").map(function () {
							return $(this).val();
						}).get();
						error = error_in_mandatory = error_time = error_time_des = 0;
						// alert(schedule_description);
						for (i = 0; i < start_time.length; i++) {
							if (schedule_title[i] == '') {
								error = error + 1;
							}
							if (schedule_description[i] == '') {
								error_time_des = error_time_des + 1;
							}
							if (start_time[i] == '' || end_time[i] == '' || schedule_date[i] == '') {
								error_in_mandatory = error_in_mandatory + 1;
							}
							//alert(start_time[i]>end_time[i]);
							if (start_time[i] > end_time[i]) {
								error_time = error_time + 1;
							}
						}
						if (error == 0 && error_in_mandatory == 0 && error_time == 0 && error_time_des == 0) {
							$.ajax({
								type: 'POST',
								url: '<?php echo base_url()?>site/experience/save_date_schedule_timing',
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
							if (error > 0) {
								alert('Title is required');
							} else if (error_time_des > 0) {
								alert('Description is required');
							}
							else if (error_in_mandatory > 0) {
								alert('Please fill all fields.');
							} else if (error_time >= 0) {
								alert('Start time should be less than end time.');
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
						alert('Already Exists');
					}
					else if (data.case == 4) {
						alert('Not Valid Times');
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


	//Add new kit
	function add_kit() {

		var main_title = $("#main_title").val();
		var detailed_title = $("#detailed_title").val();
		var kit_description = $("#kit_description").val();
		var kit_count = $("#kit_count").val();
		var experience_id = $("#experience_id").val();

		if (main_title != '' && detailed_title != '' && kit_description != '') {
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url()?>site/experience/saveKit',
				data: {
					main_title: main_title,
					kit_count: kit_count,
					detailed_title: detailed_title,
					kit_description: kit_description,
					experience_id: experience_id
				},
				dataType: 'json',
				success: function (data) {
					if (data.case == 1) {
						//$("div.added").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");
						window.location.reload();
					}
					else if (data.case == 2) {
						//$("div.updated").fadeIn(300).delay(1500).fadeOut(400);
						//$("#package_table").load(location.href + " #package_table");
						window.location.reload();
					}
					else if (data.case == 3) {
						alert('Already Exists');
					}
					else if (data.case == 4) {
						alert('Not Valid Times');
						$('#main_title').val('');
						$('#detailed_title').val('');
						$('#kit_description').val('');
					}
				}
			});
		}
		else {
			alert('Please fill all data');
		}
	}


	/* edit existing kit content  starts */
	function get_kit_data(kit_id, kit_title, kit_detailed_title, kit_count, kit_description) {

		$('#kit_id').val(kit_id);
		$('#main_title').val(kit_title);
		$('#detailed_title').val(kit_detailed_title);
		$('#kit_count').val(kit_count);
		$('#kit_description').val(kit_description);


		//$('#child_price').val(child_price);

		$('#add_kit_btn').hide();
		$('#update_kit_btn').show();
		$('#reset_kit_btn').show();

	}

	function update_kit_tab2() {
		var kit_id = $('#kit_id').val();
		var main_title = $('#main_title').val();
		var detailed_title = $('#detailed_title').val();
		var kit_count = $('#kit_count').val();
		var kit_description = $('#kit_description').val();
		var experience_id = $('#experience_id').val();

		if (main_title == '' || detailed_title == '' || kit_count == '' || kit_description == '') {
			alert('Please Fill All Values');
		}

		else {
			$.ajax
			({
				url: '<?php echo base_url(); ?>site/experience/update_kit',
				type: 'POST',
				data: {
					kit_id: kit_id,
					main_title: main_title,
					detailed_title: detailed_title,
					kit_count: kit_count,
					experience_id: experience_id,
					kit_description: kit_description
				},
				dataType: 'json',
				success: function (data) {
					//alert(data.case);
					if (data.case == 1) {
						$("div.added").fadeIn(300).delay(5500).fadeOut(400);
						$("#package_table").load(location.href + " #package_table");
						window.location.reload();
					}
					else if (data.case == 2) {
						$("div.updated").fadeIn(300).delay(2500).fadeOut(400);
						$("#package_table").load(location.href + " #package_table");
						window.location.reload();
					}
					else if (data.case == 3) {
						alert('Already Exists');
					}

				}
			});
		}

	}


</script>


<style>
	.text_size {
		width: 188px !important;
	}
</style>


<script>
	// This example displays an address form, using the autocomplete feature
	// of the Google Places API to help users fill in the information.

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
		// Create the autocomplete object, restricting the search
		// to geographical location types.

		autocomplete = new google.maps.places.Autocomplete(
			/** @type {HTMLInputElement} */(document.getElementById('autocomplete-admin')),
			{types: ['geocode']});
		// When the user selects an address from the dropdown,
		// populate the address fields in the form.
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			fillInAddress();
		});
	}

	// [START region_fillform]
	function fillInAddress() {
		// Get the place details from the autocomplete object.
		var place = autocomplete.getPlace();

		for (var component in componentForm) {
			document.getElementById(component).value = '';
			document.getElementById(component).disabled = false;
		}

		// Get each component of the address from the place details
		// and fill the corresponding field on the form.
		for (var i = 0; i < place.address_components.length; i++) {
			var addressType = place.address_components[i].types[0];
			if (componentForm[addressType]) {
				var val = place.address_components[i][componentForm[addressType]];
				document.getElementById(addressType).value = val;
			}
		}
	}

	// [END region_fillform]

	// [START region_geolocation]
	// Bias the autocomplete object to the user's geographical location,
	// as supplied by the browser's 'navigator.geolocation' object.
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

	// [END region_geolocation]


	function getAddressDetails() {
		var address = $('#autocomplete-admin').val();

		//alert(address);

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
				initializeMapCircle();

			}
		});

	}


</script>

<script type="text/javascript">
	$('#addproduct_form1111').validate();

</script>

<script type="text/javascript">
	/*
		         		function save_tab3(){
		         			var pro_id = window.location.hash.substr(1);
		         			var edit_pro_id = $('#edit_pro_id').val();
		         			var list_values = $("input[name='list_name[]']:checked")
              					.map(function(){return $(this).val();}).get();


              						$.ajax({
									type:'post',
									url:baseURL+'admin/product/savetab3',
									data:{'list_values':list_values,'pro_id':pro_id,'edit_pro_id':edit_pro_id},
									dataType:'json',
									success:function(json){


											// $('#prdiii').val(json.resultval);
											// $('#imgmsg_'+catID).hide();
											// $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
											//window.location.href = "admin/product/edit_product_form/"+json.resultval;
											//alert(json.resultval);
											//window.location.hash=json.resultval;
											if(json.resultval == 'Updated'){
												alert('Added Successfully');

											}

									}
								});

		         		}

		         		*/
</script>
<script type="text/javascript">
	function save_tab4() {
		//var pro_id = window.location.hash.substr(1);
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
		//alert(location);
		if (location_data == '') {
			$("#location_error").text("Enter your location");
			return false;
		} else {
			$("#location_error").text("");
		}
		if (country == '') {
			$("#country_error").text("Enter your country");
			return false;
		} else {
			$("#country_error").text("");
		}
		if (state == '') {
			$("#state_error").text("Enter your state");
			return false;
		} else {
			$("#state_error").text("");
		}
		if (city == '') {
			$("#city_error").text("Enter your city");
			return false;
		} else {
			$("#city_error").text("");
		}
		if (post_code.length < 6) {
			$("#post_code_length_error").text("Enter Valid Zipcode");
			return false;
		} else {
			$("#post_code_length_error").text("");
		}
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


					// $('#prdiii').val(json.resultval);
					// $('#imgmsg_'+catID).hide();
					// $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
					//window.location.href = "admin/product/edit_product_form/"+json.resultval;
					//alert(json.resultval);
					//window.location.hash=json.resultval;
					if (json.resultval == 'Updated') {
						alert('Added Successfully');
						$("#tab4").load(location.href + " #tab4");
					}

				}
			});
		}

	}
</script>

<script type="text/javascript">
	function save_tab5() {

		//var pro_id 		= window.location.hash.substr(1);
		var pro_id = $('#prdiii').val();
		var edit_pro_id = $('#edit_pro_id').val();
		var experience_description = $('#experience_description').val();
		var short_description = $('#short_description').val();
		var location_description = $('#location_description').val();
		error = 0;
		if (experience_description == '' || location_description == '' || short_description == '') {

			error = 1;
		}


		if (error == 1) {
			alert("Please fill all the mandatory fields");
		}
		else {
			if (pro_id != '' && pro_id != '0') {
				$.ajax({
					type: 'post',
					url: baseURL + 'admin/experience/savetab5',
					data: {
						'pro_id': pro_id,
						'edit_pro_id': edit_pro_id,
						'experience_description': experience_description,
						'short_description': short_description,
						'location_description': location_description
					},
					dataType: 'json',
					success: function (json) {


						// $('#prdiii').val(json.resultval);
						// $('#imgmsg_'+catID).hide();
						// $('#imgmsg_'+catID).show().text('Done').delay(800).text('');
						//window.location.href = "admin/product/edit_product_form/"+json.resultval;
						//alert(json.resultval);
						//window.location.hash=json.resultval;
						if (json.resultval == 'Updated') {
							alert('Added Successfully');

						}

					}
				});

			}
		}


	}
</script>

<script type="text/javascript">
	function save_tab6() {
		//var pro_id = window.location.hash.substr(1);
		var pro_id = $('#prdiii').val();
		var edit_pro_id = $('#edit_pro_id').val();
		var space = $('#space').val();
		var guest_requirement = $('#guest_requirement').val();
		if (pro_id != '' && pro_id != '0') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/experience/savetab6',
				data: {
					'pro_id': pro_id, 'edit_pro_id': edit_pro_id, 'space': space, 'guest_requirement': guest_requirement
				},
				dataType: 'json',
				success: function (json) {

					if (json.resultval == 'Updated') {
						alert('Added Successfully');

					}

				}
			});
		}

	}


</script>

<script type="text/javascript">
	$(document).ready(function () {
		datepick();
		//setDatepickerHere();
	});
</script>

<script>
	$("#product_title").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^a-zA-Z0-9.,|-\s()&/]/g)) {
			document.getElementById("product_title_error").style.display = "inline";
			$("#product_title_error").fadeOut(5000);
			$("#product_title").focus();
			$(this).val(val.replace(/[^a-zA-Z0-9.,|-\s()&/]/g, ''));
		}
	});

	$("#price").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9.\s]/g)) {
			document.getElementById("price_error_valid").style.display = "inline";
			$("#price").focus();
			$("#price_error_valid").fadeOut(5000);
			$(this).val(val.replace(/[^0-9.\s]/g, ''));
		}
	});

	$("#security_deposit").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9.\s]/g)) {
			document.getElementById("security_deposit_error_valid").style.display = "inline";
			$("#security_deposit").focus();
			$("#security_deposit_error_valid").fadeOut(5000);
			$(this).val(val.replace(/[^0-9.\s]/g, ''));
		}
	});

	/* $("#autocomplete-admin").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z-,\s]/g)) {
	   document.getElementById("location_error_valid").style.display = "inline";
	   $("#autocomplete-admin").focus();
	   $("#location_error_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z-,\s]/g, ''));
   }
});

$("#country").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z,\s]/g)) {
	   document.getElementById("country_error_valid").style.display = "inline";
	   $("#country").focus();
	   $("#country_error_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z,\s]/g, ''));
   }
});


$("#state").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z\s]/g)) {
	   document.getElementById("state_error_valid").style.display = "inline";
	   $("#state").focus();
	   $("#state_error_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
   }
});

$("#city").on('keyup', function(e) {
    var val = $(this).val();
   if (val.match(/[^a-zA-Z\s]/g)) {
	   document.getElementById("city_error_valid").style.display = "inline";
	   $("#city").focus();
	   $("#city_error_valid").fadeOut(5000);
       $(this).val(val.replace(/[^a-zA-Z\s]/g, ''));
   }
}); */

	$("#post_code").on('keyup', function (e) {
		var val = $(this).val();
		if (val.match(/[^0-9\s]/g)) {
			document.getElementById("post_code_error_valid").style.display = "inline";
			$("#post_code").focus();
			$("#post_code_error_valid").fadeOut(5000);
			$(this).val(val.replace(/[^0-9\s]/g, ''));
		}
	});


</script>

