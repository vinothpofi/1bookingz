<?php
$this->load->view('admin/templates/header.php');
//echo "<pre>"; print_r($listings->result());die;
foreach ($listings->result() as $listings_field) {
	$listing_field_name = $listings_field->listing_values;
}
$json_finals = json_decode($listing_field_name);
foreach ($json_finals as $field_name => $values_list) {
	$dataArr[$field_name] = $values_list;
}
?>
<?php echo $map['js']; ?>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>View Rental</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Rental General Information</a></li>
							<!--<li><a href="#tab2">Category</a></li>-->
							<li><a href="#tab3">Images</a></li>
							<li><a href="#tab4">Amenities</a></li>
							<li><a href="#tab5">Address & Availability Information</a></li>
							<li><a href="#tab6">Listing</a></li>
							<li><a href="#tab7">Detailed description</a></li>
							<li><a href="#tab8">SEO</a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php
					$attributes = array('class' => 'form_container left_label', 'id' => 'addproduct_form');
					echo form_open('admin', $attributes);
					$options = '';
					$list_names = $product_details->row()->list_name;
					$list_names_arr = explode(',', $list_names);
					$list_values = $product_details->row()->list_value;
					$list_values_arr = explode(',', $list_values);
					$imgArr = explode(',', $product_details->row()->image);
					?>
					<div id="tab1">
						<ul>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="user_id">Rental Owner Name <span
											class="req">*</span></label>
									<div class="form_input">
										<?php
										if (!empty($userdetails)) {
											foreach ($userdetails->result() as $user_details) {
												?>
												<?php if ($user_details->id == $product_details->row()->OwnerId) {
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
									<label class="field_title" for="description">Summary</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->description != '') {
											echo $product_details->row()->description;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="price">Price per Night</label>
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
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="depositAmount">Deposit Amount</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->security_deposit != '' && $product_details->row()->security_deposit != '0' && $product_details->row()->security_deposit != '0.00') {
											echo $product_details->row()->security_deposit;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="cancellationPolicy"> Cancellation Policy</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->cancellation_policy != '') {
											echo $product_details->row()->cancellation_policy;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="returnAmount"> Return Amount</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->cancel_percentage != '' && $product_details->row()->cancel_percentage != '0' && $product_details->row()->cancel_percentage != '0.00') {
											echo $product_details->row()->cancel_percentage;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="Description"> Description</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->cancel_description != '') {
											echo $product_details->row()->cancel_description;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Status </label>
									<div class="form_input">
										<?php
										if ($product_details->row()->status != '') {
											echo $product_details->row()->status;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Video URL </label>
									<div class="form_input">
										<?php
										if ($product_details->row()->video_url != '') {
											echo $product_details->row()->video_url;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="admin_name">Request to Book </label>
									<div class="form_input">
										<?php
										if ($product_details->row()->request_to_book != '') {
											echo $product_details->row()->request_to_book;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<?php if ($instant_pay->row()->status == '1') { ?>
								<li>
									<div class="form_grid_12">
										<label class="field_title" for="admin_name">Instant Pay </label>
										<div class="form_input">
											<?php
											if ($product_details->row()->instant_pay != '') {
												echo $product_details->row()->instant_pay;
											} else {
												echo 'Not available';
											}
											?>
										</div>
									</div>
								</li>
							<?php } ?>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental list"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab3">
						<ul>
							<li>
								<div class="widget_content">
									<table class="display display_tbl image_tbl_box" id="image_tbl">
										<thead>
										<tr>
											<th class="center"> Sno</th>
											<th class="center"> Image</th>
										</tr>
										</thead>
										<tbody>
										<?php
										if (count($imgArr) > 0) {
											$i = 0;
											$j = 1;
											$this->session->set_userdata(array('product_image_' . $product_details->row()->id => $product_details->row()->image));
											if ($imgDetail->num_rows() > 0) {
												foreach ($imgDetail->result() as $img) {
													if ($img != '') {
														?>
														<tr id="img_<?php echo $i ?>">
															<td class="center tr_select ">
																<input type="hidden" name="imaged[]"
																	   value="<?php echo $img->product_image; ?>"/>
																<?php echo $j; ?>
															</td>
															<td class="center">
																<img
																	src="<?php if (strpos($img->product_image, 's3.amazonaws.com') > 1) echo $img->product_image; else echo base_url() . "images/rental/" . $img->product_image; ?>"
																	height="80px" width="80px"/>
															</td>
														</tr>
														<?php
														$j++;
													}
													$i++;
												}
											} else { ?>
												<tr>
													<td class="center tr_select " colspan="2">No Images
														uploaded...!
													</td>
												</tr>
											<?php }
										}
										?>
										</tbody>
										<tfoot>
										<tr>
											<th class="center"> Sno</th>
											<th> Image</th>
										</tr>
										</tfoot>
									</table>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental List"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab4">
						<?php
						$list_name = $product_details->row()->list_name;
						$facility = (explode(",", $list_name));
						?>
						<?php if ($listNameCnt->num_rows() > 0) { ?>
							<ul class="tab-areas3">
								<?php
								foreach ($listNameCnt->result() as $listVals) {
									$listValues = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => $listVals->id));
									?>
									<?php if ($listValues->row()->list_value != "") { ?>
										<h3><?php echo $listVals->attribute_name; ?></h3>
									<?php } ?>
									<p><?php echo $listVals->attribute_title; ?> </p>
									<?php
									if ($listValues->num_rows() > 0) {
										foreach ($listValues->result() as $details) {
											?>
											<li>
												<input type="checkbox" class="checkbox_check" disabled="disabled"
													   name="list_name[]"
													   id="mostcommon<?php echo $details->id; ?>" <?php if (in_array($details->id, $facility)) { ?> checked="checked" <?php } ?>
													   value="<?php echo $details->id; ?>" disabled/>
												<span><?php echo $details->list_value; ?></span>
											</li>
											<?php
										}
									}
								}
								?>
							</ul>
						<?php } ?>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input"><a href="admin/product/display_product_list"
															   class="tipLeft" title="Go to Rental List"><span
												class="badge_style b_done">Back</span></a></div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab5">
						<ul>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="address">Location</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->address != '') {
											echo trim(stripslashes($product_details->row()->address));
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="country">Country:</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->CountryName != '') {
											echo ucfirst($product_details->row()->CountryName);
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="state">State:</label>
									<div class="form_input" id="listCountryCnt">
										<?php
										if ($product_details->row()->StateName != '') {
											echo ucfirst($product_details->row()->StateName);
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="city">City:</label>
									<div class="form_input" id="listStateCnt">
										<?php
										if ($product_details->row()->cityname != '') {
											echo ucfirst($product_details->row()->cityname);
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="address">Street Address</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->street != '') {
											echo trim(stripslashes($product_details->row()->street));
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="post_code">ZIP CODE :</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->post_code != '') {
											echo trim(stripslashes($product_details->row()->post_code));
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental List"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab6">
						<ul>
							<h4>Listing Info:</h4>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_email"><?php echo $p_listSpace->row()->attribute_name; ?></label>
									<div class="form_input">
										<?php
										if ($listings_hometype->row()->list_value != '') {
											echo ucfirst($listings_hometype->row()->list_value);
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="confirm_email"><?php echo $r_listSpace->row()->attribute_name; ?></label>
									<div class="form_input">
										<?php
										if ($listings_roomtype->row()->list_value != '') {
											echo ucfirst($listings_roomtype->row()->list_value);
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<?php $json_values = json_decode($product_details->row()->listings);
							foreach ($json_values as $list_Name => $listing_Values) {
								$listArr[$list_Name] = $listing_Values;
								$Name = str_replace('_', ' ', $list_Name);
								if ($Name != '30') {
									?>
									<li>
										<div class="form_grid_12">
											<?php $listTypeValuesShow = $this->product_model->get_all_details(LISTING_TYPES, array('id' => $Name, 'status' => 'Active')); ?>
											<label class="field_title"
												   for="order_email"><?php echo $listTypeValuesShow->row()->labelname; ?></label>
											<div class="form_input">
												<?php //echo ucfirst($listing_Values);
												$listchildValues_child = $this->product_model->get_all_details('fc_listing_child', array('id' => $listing_Values));
												echo $listchildValues_child->row()->child_name;
												if ($listchildValues_child->row()->child_name == '') {
													echo ucfirst($listing_Values);
												}
												// if($Name == 'minimum stay'){ echo ucfirst($product_details->row()->minimum_stay); }
												if ($Name == 'minimum stay') {
													$miminum_stay_id = $product_details->row()->minimum_stay;
													$listchildValues_minimum = $this->product_model->get_all_details('fc_listing_child', array('id' => $miminum_stay_id));
													echo $listchildValues_minimum->row()->child_name;
												}
												?>
											</div>
										</div>
									</li>
								<?php }
							}
							$get_minimumStay = $this->product_model->get_all_details(LISTING_TYPES, array('status' => 'Active', 'id' => '30'));
							?>
							<li>
								<div class="form_grid_12">
									<label class="field_title"
										   for="order_email"><?php echo $get_minimumStay->row()->labelname; ?></label>
									<div class="form_input">
										<?php
										$miminum_stay_id = $product_details->row()->minimum_stay;
										$listchildValues_minimum = $this->product_model->get_all_details('fc_listing_child', array('id' => $miminum_stay_id));
										if ($listchildValues_minimum->row()->child_name != '') {
											echo $listchildValues_minimum->row()->child_name;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental List"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab7">
						<ul>
							<h3>Details</h3>
							<p>A description of your space displayed on your public listing page. </p>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="space">The Space</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->space != '') {
											echo $product_details->row()->space;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<h3>Extra Details</h3>
							<p>Other information you wish to share on your public listing page. </p>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="other_thingnote">Other Things to Note</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->other_thingnote != '') {
											echo $product_details->row()->other_thingnote;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="house_rules">House Rules</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->house_rules != '') {
											echo $product_details->row()->house_rules;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="guest_access">Guest Access</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->guest_access != '') {
											echo $product_details->row()->guest_access;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="interact_guest">Interaction with Guests</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->interact_guest != '') {
											echo $product_details->row()->interact_guest;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="interact_guest">NEIGHBORHOOD</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->neighbor_overview != '') {
											echo $product_details->row()->neighbor_overview;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input" style="margin:0px;width:100%;">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental List"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div id="tab8">
						<ul>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="meta_title">Meta Title</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->meta_title != '') {
											echo $product_details->row()->meta_title;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="meta_tag">Meta Keyword</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->meta_keyword != '') {
											echo $product_details->row()->meta_keyword;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="meta_description">Meta Description</label>
									<div class="form_input">
										<?php
										if ($product_details->row()->meta_description != '') {
											echo $product_details->row()->meta_description;
										} else {
											echo 'Not available';
										}
										?>
									</div>
								</div>
							</li>
						</ul>
						<ul>
							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<a href="admin/product/display_product_list" class="tipLeft"
										   title="Go to Rental List"><span class="badge_style b_done">Back</span></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					</form>
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
