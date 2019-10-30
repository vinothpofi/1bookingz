<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Edit City Name</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Content</a></li>
							<li><a href="#tab2">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'onsubmit' => 'return validate();');
					echo form_open('admin/city/insertEditcity', $attributes);
					echo form_input(array(
						'type' => 'hidden',
						'id' => 'City_address',
						'name' => 'City_address'
					));
					?>
					<div id="tab1">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
									$commonclass = array('class' => 'field_title');
									echo form_label('Country Name <span class="req">*</span>', 'countryid', $commonclass);
									?>
									<div class="form_input">
										<?php
										$cntry = array();
										$cntry[''] = '--Select--';
										foreach ($countryDisplay->result() as $row) {
											$cntry[$row->id] = $row->name;
										}
										$cntryattr = array(
											'id' => 'countryid',
											'class' => 'chzn-select required',
											'tabindex' => '1',
											'style' => 'width: 375px; display: none;',
											'data-placeholder' => 'Please select the country'
										);
										echo form_dropdown('countryid', $cntry, $city_details->row()->countryid, $cntryattr);
										?>
										<span id="countryid_valid" style="color:#f00;display:none;">Please select the country name</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('State Name <span class="req">*</span>', 'countryid', $commonclass);
									?>
									<div class="form_input">
										<select class="chzn-select required" name="stateid" id="stateid" tabindex="-1"
												style="width: 375px; display: none;"
												data-placeholder="Please select the state name">
											<option value="">--Select--</option>
											<?php foreach ($stateDisplay as $row) { ?>
												<option
													value="<?php echo $row['id']; ?>" <?php if ($city_details->row()->stateid == $row['id']) {
													echo 'selected="selected"';
												} ?>><?php echo $row['name']; ?></option>
											<?php } ?>
										</select>
										<span id="stateid_valid" style="color:#f00;display:none;">Please select the State name</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('City Name <span class="req">*</span>', 'name', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'name',
											'maxlenght' => '20',
											'style' => 'width:295px',
											'value' => $city_details->row()->name,
											'id' => 'name',
											'onblur' => 'javascript:showAddress(this);',
											'tabindex' => '1',
											'class' => 'required tipTop',
											'title' => 'Please enter the city'
										));
										?>
										<span id="name_valid" style="color:#f00;display:none;">		Only Characters allowed
									    </span>
									</div>
								</div>
							</li>
							<!-- <li>
								<div class="form_grid_12">
									<?php
									echo form_label('City Name (Arabic) <span class="req">*</span>', 'name_ar', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'name' => 'name_ar',
											'style' => 'width:295px',
											'maxlenght' => '10',
											'value' => $city_details->row()->name_ar,
											'id' => 'name_ar',
											'onblur' => 'javascript:showAddress(this);',
											'tabindex' => '1',
											'class' => 'required tipTop',
											'title' => 'Please enter the city in Arabic'
										));
										?>
										<span id="name_ar_valid" style="color:#f00;display:none;">		Only Characters allowed
									    </span>
									</div>
								</div>
							</li> -->
							<li>
								<div class="form_grid_12">
									<?php
									echo form_input(array(
										'type' => 'hidden',
										'id' => 'latitude',
										'name' => 'latitude',
										'value' => $city_details->row()->latitude
									));
									echo form_input(array(
										'type' => 'hidden',
										'id' => 'longitude',
										'name' => 'longitude',
										'value' => $city_details->row()->longitude
									));
									?>
									<div id="map" style="width:1050px; height:250px"></div>
									<script
										src='<?php echo $protocol; ?>maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_developer_key'); ?>'>
									</script>
									<script>
										function load() {
											oldlat = '<?php echo $city_details->row()->latitude;?>';
											oldlng = '<?php echo $city_details->row()->longitude;?>';
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

										function showAddress(evt) {
											var country = $(evt).parents('li').prev().prev().find('select option:selected').text();
											var state = $(evt).parents('li').prev().find('select option:selected').text();
											var city = $(evt).val();
											address = city + ',' + state + ',' + country;
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
														}
														else {
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
									</script>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('image <small>(Maximum width 2000px)</small> <span class="req">*</span>', 'citythumb', $commonclass);
									?>
									<div class="form_input">
										<?php if ($city_details->row()->citythumb != '') {
											echo form_input(array(
												'type' => 'file',
												'name' => 'citythumb',
												'onchange' => 'Upload(this.id);',
												'id' => 'citythumb',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please select the thumb image'
											));
										} else {
											echo form_input(array(
												'type' => 'file',
												'name' => 'citythumb',
												'onchange' => 'Upload(this.id);',
												'id' => 'citythumb',
												'required' => 'required',
												'tabindex' => '5',
												'class' => 'large tipTop',
												'title' => 'Please select the thumb image'
											));
										} ?>
									</div>
									<?php
									$imgerr1 = array('class' => 'error', 'id' => 'image_valid_error', 'style' => 'font-size:12px;display:none;');
									echo form_label('Maximum width 2000Px.', '', $imgerr1);
									$imgerr2 = array('class' => 'error', 'id' => 'image_type_error', 'style' => 'font-size:12px;display:none;');
									echo form_label('Please select a valid Image file.', '', $imgerr2);
									?>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('image image', '', $commonclass);
									?>
									<div class="form_input">
										<?php
										$base = base_url();
										$url = getimagesize($base . 'images/city/' . $city_details->row()->citythumb);
										if (!is_array($url)) {
											$img = "1";
										} else {
											$img = "0";
										}
										/*To Check whether the image is exist in Local Directory*/
										if ($city_details->row()->citythumb != '' && $img == '0') { ?>
											<img src="images/city/<?php echo $city_details->row()->citythumb; ?>"
												 width="50px" height="50px"/>
											<?php
										} else {
											echo "Upload new Image..!";
										} ?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Featured City', 'featured', $commonclass);
									?>
									<div class="form_input">
										<div class="yes_no">
											<input type="checkbox" tabindex="7" name="featured"
												   id="active_inactive_active"
												   class="active_inactive" <?php if ($city_details->row()->featured == '1') {
												echo 'checked="checked"';
											} ?> />
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Status <span
											class="req">*</span>', 'admin_name', $commonclass);
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="7" name="status"
												   id="active_inactive_active"
												   class="active_inactive" <?php if ($city_details->row()->status == 'Active') {
												echo 'checked="checked"';
											} ?> />
										</div>
									</div>
								</div>
							</li>
							<?php
							echo form_input(array(
								'type' => 'hidden',
								'name' => 'city_id',
								'value' => $city_details->row()->id
							));
							?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'submit',
											'value' => 'Submit',
											'tabindex' => '4',
											'class' => 'btn_small btn_blue'
										));
										?>
										<a href="<?php echo base_url(); ?>admin/city/display_city_list">
											<button class="btn_small btn_blue" type="button">Back</button>
										</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab2">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Title ', 'meta_title', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input(array(
											'type' => 'text',
											'id' => 'meta_title',
											'name' => 'meta_title',
											'class' => 'large tipTop',
											'tabindex' => '1',
											'value' => $city_details->row()->meta_title,
											'title' => 'Please enter the page meta title'
										));
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('Meta Keyword ', 'meta_tag', $commonclass);
									?>
									<div class="form_input">
										<?php
										$descattr = array(
											'id' => 'meta_keyword',
											'tabindex' => '2',
											'class' => 'large tipTop',
											'title' => 'Please enter the page meta keyword'
										);
										echo form_textarea('meta_keyword', $city_details->row()->meta_keyword, $descattr);
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
										$descattr2 = array(
											'id' => 'meta_description',
											'tabindex' => '3',
											'class' => 'large tipTop',
											'title' => 'Please enter the meta description',
											'value' => $city_details->row()->meta_description
										);
										echo form_textarea('meta_description', '', $descattr2);
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
										echo form_input(array(
											'type' => 'submit',
											'class' => 'btn_small btn_blue',
											'value' => 'Submit',
											'tabindex' => '4'
										));
										?>
										<a href="<?php echo base_url(); ?>admin/city/display_city_list">
											<button class="btn_small btn_blue" type="button">Back</button>
										</a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>
<!-- To load States Based on the Countires Choose Already...!-->
<script type="text/javascript">
	window.addEventListener('load',
		function () {

			<?php if ($city_details->row()->stateid != '0')
			{
			}
			else
			{?>

			var cid = $("#countryid").val();
			var $evt = $("#countryid");
			if (cid != '') {
				$.ajax({
					type: 'post',
					url: baseURL + 'admin/city/load_states',
					data: {cid: cid, action: 1},
					dataType: 'json',
					success: function (json) {
						if (json && json.success == 1) {
							$evt.parents('li').next().find('.form_input').html(json.states_list);
							$(".chzn-select").chosen();
						}
					},
					error: function (a, b, c) {
						alert(c);
					},
					complete: function () {
					}
				});
			}
			<?php
			} ?>

		}, false);
</script>
<script type="text/javascript">
	$(function () {
		$("select#countryid").change(function () {
			var cid = $(this).val();
			var $evt = $(this);
			if (cid != '') {
				$.ajax({
					type: 'post',
					url: baseURL + 'admin/city/load_states',
					data: {cid: cid, action: 1},
					dataType: 'json',
					success: function (json) {
						if (json && json.success == 1) {
							$evt.parents('li').next().find('.form_input').html(json.states_list);
							$(".chzn-select").chosen();
						}
					},
					error: function (a, b, c) {
						alert(c);
					},
					complete: function () {
					}
				});
			}
		});
	});
</script>
<script type="text/javascript">
	$('#commentForm').validate();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script>
	function Upload(files) {
		var fileUpload = document.getElementById("citythumb");

		var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.jpeg|.gif)$");
		if (regex.test(fileUpload.value.toLowerCase())) {

			if (typeof (fileUpload.files) != "undefined") {
				var reader = new FileReader();
				reader.readAsDataURL(fileUpload.files[0]);
				reader.onload = function (e) {

					var image = new Image();
					image.src = e.target.result;

					image.onload = function () {
						var height = this.height;
						var width = this.width;

						if (parseInt(width) > 2000) {
							document.getElementById("image_valid_error").style.display = "inline";
							$("#image_valid_error").fadeOut(9000);
							$("#citythumb").val('');
							$(".filename").text('No file selected');
							$("#citythumb").focus();
							return false;
						}
						return true;
					};
				}
			}
			else {
				alert("This browser does not support HTML5.");
				$("#citythumb").val('');
				return false;
			}
		}
		else {
			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(9000);
			$("#citythumb").val('');
			$("#citythumb").focus();
			return false;
		}
	}

	function validate() {

		var country = $("#countryid").val();
		var state = $('select[name="stateid"]').val();
		var city = $("#name").val();
		var img = $('input[type="file"]').val();

		<?php if ($city_details->row()->citythumb != '') { ?>
		if (country == "" || state == "undefined" || state == "" || state == null || city == '') {
			alert("Please Fill All Mandatory Fields");
			return false;
		}
		else {

		}

		<?php
		}
		else
		{ ?>
		if (country == "" || state == "undefined" || state == "" || state == null || city == '' || img == '') {
			alert("Please Fill All Mandatory Fields");
			return false;
		}
		else {

		}
		<?php } ?>

	}
</script>

