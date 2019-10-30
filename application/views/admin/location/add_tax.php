<?php
$this->load->view('admin/templates/header.php');
 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Add New State</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Content</a></li>
							<li><a href="#tab2">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'commentForm', 'accept-charset' => 'UTF-8', 'onsubmit' => 'return validate();');
					echo form_open('admin/location/insertEditTax', $attributes)
					?>
					<div id="tab1">
						<ul>
							<li>
								<div class="form_grid_12">
									<?php
										$commonclass = array('class' => 'field_title');

										echo form_label('Country Name<span class="req">*</span>','country_id', $commonclass);	
									?>
									<div class="form_input">
										<?php
											$cntry=array();
											$cntry[''] = '--Select--';
											foreach ($countryDisplay as $row)
											{
												$cntry[$row['id']]=$row['name'];
											}	 

											$cntryattr = array(
												    'id'     		   => 'country_id',
												    'class'	 		   => 'chzn-select required',
												    'tabindex' 		   => '-1',
												    'style'	   		   => 'width: 375px; display: none;',
												    'data-placeholder' => 'Please select the country name'
											);

											echo form_dropdown('country_id', $cntry, '', $cntryattr);
										?>
										<span id="country_id_valid" style="color:#f00;display:none;">Please select the country name
										</span>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('State Name<span class="req">*</span>','state_name', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'state_name',
									            'style'   	  => 'width:295px',
									            'id'          => 'state_name',
												'tabindex'	  => '1',
												'class'		  => 'tipTop',
												'title'		  => 'Please enter the state name',
												'onblur'	  => 'javascript:showAddress(this);'
									        ]);
									    ?>
									    <span id="name_valid" style="color:#f00;display:none;">Only Characters are allowed!
									    </span>
										<span id="state_name_valid" style="color:#f00;display:none;">Please select the State Name
										</span>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
											echo form_input([
												'type'        => 'hidden',      
									            'name' 	      => 'latitude',
									            'id'          => 'latitude',
									        ]);

									        echo form_input([
												'type'        => 'hidden',      
									            'name' 	      => 'longitude',
									            'id'          => 'longitude',
									        ]);
									?>
									<div id="map" style="width:1050px; height:250px"></div>
									<script
										src='<?php echo $protocol; ?>maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo $this->config->item('google_developer_key'); ?>'>
									</script>
									
									<script>
										function load() 
										{
											oldlat = '';
											oldlng = '';
											if (oldlat == '') oldlat = '37.77264';
											if (oldlng == '') oldlng = '-122.40992';
											if (GBrowserIsCompatible()) {
												var map = new GMap2(document.getElementById("map"));
												map.addControl(new GSmallMapControl());
												map.addControl(new GMapTypeControl());
												var center = new GLatLng(oldlat, oldlng);
												map.setCenter(center, 6);
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

										function showAddress(evt) 
										{
											var country = $(evt).parents('li').prev().find('select option:selected').text();
											var state = $(evt).val();
											address = state + ',' + country;
											var map = new GMap2(document.getElementById("map"));
											map.addControl(new GSmallMapControl());
											map.addControl(new GMapTypeControl());
											if (geocoder) {
												geocoder.getLatLng(
													address,
													function (point) 
													{
														if (!point) 
														{
															alert("Address " + address + " not found");
															return false;
														} 
														else 
														{
															$("#latitude").val(point.lat().toFixed(5));
															$("#longitude").val(point.lng().toFixed(5));
															map.clearOverlays()
															map.setCenter(point, 6);
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
										echo form_label('State Code<span class="req">*</span>','state_code', $commonclass);	
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
									            'name' 	      => 'state_code',
									            'style'   	  => 'width:295px',
									            'id'          => 'state_code',
												'tabindex'	  => '1',
												'class'		  => 'tipTop',
												'title'		  => 'Please enter the state code'
									        ]);
									    ?>
										<span id="state_code_valid_num" style="color:#f00;display:none;">Special Characters Not Allowed!
										</span>
										<span id="state_code_valid" style="color:#f00;display:none;">State Code is Required
										</span>
									</div>
								</div>
							</li>
							
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Status <span class="req">*</span>','admin_name', $commonclass);	
									?>
									<div class="form_input">
										<div class="active_inactive">
											<input type="checkbox" tabindex="8" name="status" checked="checked" id="active_inactive_active" class="active_inactive"/>
										</div>
									</div>
								</div>
							</li>
							<?php
								echo form_input([
									'type'        => 'hidden',      
									'name' 	      => 'tax_id',
									'value'	  	  => ''
								]);
							?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'submit',      
												'class' 	  => 'btn_small btn_blue',
												'tabindex'	  => '4',
												'value'	 	  => 'Submit'
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
										echo form_label('Meta Title','meta_title', $commonclass);
									?>
									<div class="form_input">
										<?php
											echo form_input([
												'type'        => 'text',      
												'class' 	  => 'large tipTop',
												'tabindex'	  => '1',
												'name'	 	  => 'meta_title',
												'id'		  => 'meta_title',
												'title'		  => 'Please enter the page meta title'
											]);
										?>
									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Meta Keyword','meta_tag', $commonclass);
									?>
									<div class="form_input">
										<?php
			                    		$keywrdattr = array(
			                    			'name'		=> 'meta_keyword',
			                    			'id' 		=> 'meta_keyword',
			                    			'tabindex'  => '2',
			                    			'class' 	=> 'large tipTop',
			                    			'rows'		=> '2',
			                    			'title' 	=> 'Please enter the page meta keyword'
			                    		);
			                    		echo form_textarea($keywrdattr);
			                    		?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<?php
										echo form_label('Meta Description','meta_description', $commonclass);
									?>
									<div class="form_input">
										<?php
			                    		$descattr = array(
			                    			'name'		=> 'meta_description',
			                    			'id' 		=> 'meta_description',
			                    			'tabindex'  => '3',
			                    			'class' 	=> 'large tipTop',
			                    			'rows'		=> '2',
			                    			'title' 	=> 'Please enter the meta description'
			                    		);
			                    		echo form_textarea($descattr);
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
												'type'      => 'submit', 
									            'class'     => 'btn_small btn_blue',
									            'tabindex'	=> '4',
												'value'	    => 'Submit'
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

<?php
$this->load->view('admin/templates/footer.php');
?>

<script>	

	$("#state_code").on('keyup', function (e) 
	{
		var val = $(this).val();
		if (val.match(/[^a-zA-Z.-\s0-9]/g))
		{
			document.getElementById("state_code_valid_num").style.display = "inline";
			$("#state_code_valid_num").fadeOut(5000);
			$("#state_code").focus();
			$(this).val(val.replace(/[^a-zA-Z\s0-9]/g, ''));
		}
	});

</script>
<!-- script to validate form inputs -->
<script>
	function validate() 
	{
		if ($('#country_id option:selected').val() == '') 
		{
			document.getElementById("country_id_valid").style.display = "inline";
			$("#country_id").focus();
			$("#country_id_valid").fadeOut(5000);
			return false;
		}

		if ($('#state_name').val() == '') 
		{
			document.getElementById("state_name_valid").style.display = "inline";
			$("#state_name").focus();
			$("#state_name_valid").fadeOut(5000);
			return false;
		}

		if ($('#state_code').val() == '') 
		{
			document.getElementById("state_code_valid").style.display = "inline";
			$("#state_code").focus();
			$("#state_code_valid").fadeOut(5000);
			return false;
		}
	}

	$(".chzn-select").chosen({rtl: true});
</script>
