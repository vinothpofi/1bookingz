<?php
$this->load->view('admin/templates/header.php');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<style>
	.uploader {
		overflow: visible !important;
	}

	.uploader label.error {
		left: 200px;
		position: absolute;
		width: 150px;
	}
</style>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New City</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Content</a></li>
							<li><a href="#tab2">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8', 'onsubmit' => 'return checkValue();');
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
											'data-placeholder' => 'Please select the country',
											'onchange' => 'javascript:load_states(this);'
										);
										echo form_dropdown('countryid', $cntry, '', $cntryattr);
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
										<?php
										$state = array();
										$state[''] = '--Select--';
										foreach ($stateDisplay as $row) {
											$cntry[$row['id']] = $row['name'];
										}
										$stateattr = array(
											'id' => 'stateid',
											'class' => 'chzn-select required',
											'tabindex' => '1',
											'style' => 'width: 375px; display: none;',
											'data-placeholder' => 'Please select the state name'
										);
										echo form_dropdown('stateid', $state, '', $stateattr);
										?>
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
										echo form_input([
											'type' => 'text',
											'name' => 'name',
											'maxlenght' => '10',
											'style' => 'width:295px',
											'id' => 'name',
											'onblur' => 'javascript:showAddress(this);',
											'tabindex' => '1',
											'class' => 'tipTop',
											'title' => 'Please enter the city'
										]);
										?>
										<span id="name_valid"
											  style="color:#f00;display:none;">Only Characters allowed</span>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_input([
										'type' => 'hidden',
										'id' => 'latitude',
										'name' => 'latitude',
										'value' => ''
									]);
									echo form_input([
										'type' => 'hidden',
										'id' => 'longitude',
										'name' => 'longitude',
										'value' => ''
									]);
									?>
									<div id="map" style="width:1050px; height:250px"></div>
									<script
										src='<?php echo $protocol; ?>maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_developer_key'); ?>'></script>
									<script>
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

										function showAddress(evt) {
											var country = $(evt).parents('li').prev().prev().find('select option:selected').text();
											var state = $(evt).parents('li').prev().find('select option:selected').text();
											var city = $(evt).val();
											address = city + ',' + state + ',' + country;
											$("#City_address").val(address);
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
									</script>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
									echo form_label('image <small>(Maximum width 2000px)</small> <span class="req">*</span>', 'citythumb', $commonclass);
									?>
									<div class="form_input">
										<?php
										echo form_input([
											'type' => 'file',
											'name' => 'citythumb',
											'onchange' => 'Upload(this.id);',
											'id' => 'citythumb',
											'required' => 'required',
											'tabindex' => '5',
											'class' => 'large tipTop',
											'title' => 'Please select the thumb image'
										]);
										?>
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
									echo form_label('Featured City', 'featured', $commonclass);
									?>
									<div class="form_input">
										<div class="yes_no">
											<input type="checkbox" tabindex="7" name="featured"
												   id="active_inactive_active"
												   class="active_inactive"/>
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
											<input type="checkbox" tabindex="8" name="status" checked="checked"
												   id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>
							<?php
							echo form_input([
								'type' => 'hidden',
								'name' => 'city_id',
								'value' => ''
							]);
							echo form_input([
								'type' => 'hidden',
								'name' => 'neighborhoods',
								'value' => '0'
							]);
							?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
										echo form_input([
											'type' => 'submit',
											'value' => 'Submit',
											'tabindex' => '4',
											'class' => 'btn_small btn_blue'
										]);
										?>
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
										echo form_input([
											'type' => 'text',
											'id' => 'meta_title',
											'name' => 'meta_title',
											'class' => 'large tipTop',
											'tabindex' => '1',
											'title' => 'Please enter the page meta title'
										]);
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
										echo form_textarea('meta_keyword', '', $descattr);
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
											'title' => 'Please enter the meta description'
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
										echo form_input([
											'type' => 'submit',
											'class' => 'btn_small btn_blue',
											'value' => 'Submit',
											'tabindex' => '4'
										]);
										?>
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
<script type="text/javascript">
	$(".action").live("click", function (event) {

		event.preventDefault();

		var file_upload_id = $(this).prev().prev().attr('id');

		$('#' + file_upload_id).click();

	});
</script>
<!-- To load States Based on the Countires Choose Already...!-->
<script type="text/javascript">
	function load_states(evt) {
		var cid = $(evt).val();
		if (cid != '') {
			$.ajax({
				type: 'post',
				url: baseURL + 'admin/city/load_states',
				data: {cid: cid, action: 2},
				dataType: 'json',
				success: function (json) {
					if (json && json.success == 1) {
						$(evt).parents('li').next().find('.form_input').html(json.states_list);
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
	}

	/*function to upload image*/
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
			} else {
				alert("This browser does not support HTML5.");
				$("#citythumb").val('');
				return false;
			}
		} else {

			document.getElementById("image_type_error").style.display = "inline";
			$("#image_type_error").fadeOut(9000);
			$("#citythumb").val('');
			$("#citythumb").focus();
			return false;
		}
	}
</script>
<!-- script to validate form inputs -->
<script type="text/javascript">
	$('#commentForm').validate();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script>
	function checkValue() {
		var country = $("#countryid").val();
		var state = $('select[name="stateid"]').val();
		var city = $("#name").val();
		var img = $('input[type="file"]').val();
		if (country == "" || state == "undefined" || state == "" || state == null || city == '' || img == '') {
			alert("Please Fill All Mandatory Fields");
			return false;
		} else {

		}
	}
</script>
