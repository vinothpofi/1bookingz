<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
	<?php echo form_open('explore_listing', array('method' => 'post', 'id' => 'search_result_form'));
	if ($total_listings == '') {
		$total_listings = '0';
	}
	$data = array('type' => 'hidden', 'name' => 'total_listings', 'id' => 'total_listings', 'value' => $total_listings);
	echo form_input($data);
	echo form_close();
	$data = array('type' => 'hidden', 'id' => 'page_number', 'name' => 'page_number', 'value' => 1);
	echo form_input($data);
	?>
	<section class="loggedBg">
		<div class="container">
			<ul class="loginMenu">
			
				<li>
					<a href="<?php echo base_url(); ?>explore_listing" <?php if ($this->uri->segment(1) == 'explore_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('places_up') != '') {
							echo stripslashes($this->lang->line('places_up'));
						} else echo "PLACES"; ?></a></li>
				<li>
					<a href="<?php echo base_url(); ?>explore-experience" <?php if ($this->uri->segment(1) == 'explore-experience') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('EXPERIENCE') != '') {
							echo stripslashes($this->lang->line('EXPERIENCE'));
						} else echo strtoupper("EXPERIENCE"); ?></a></li>
						
				<li>
					<a href="<?php echo base_url(); ?>all_listing" <?php if ($this->uri->segment(1) == 'all_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('All') != '') {
							echo stripslashes($this->lang->line('All'));
						} else echo "ALL"; ?></a>
				</li>
			</ul>
		</div>
	</section>
	<section>
		<div class="container" style="margin-top: 20px;">
			<div class="row listings card-section-bg" id="property_listings">
				<?php
				if ($product->num_rows() > 0) {
					foreach ($product->result_array() as $product_image) {
						/*print_r($newArr);;die;*/
						//print_r($product_image);
						?>
						<div class="col-sm-4 col-md-4">
							<div class="owl-carousel show">
								<div class="item">
								<?php if ($this->session->userdata('fc_session_user_id')) {
									if (in_array($product_image['id'], $newArr)) { ?>
										<div class="wishList_I yes" style="display: block;"></div>
									<?php } else {
										?>
										<div class="wishList_I" style="display: block;"
											 onclick="loadWishlistPopup('<?php echo $product_image['id']; ?>');"></div>
										<?php
									}
								} else { ?>
									<div data-toggle="modal" data-target="#signIn" class="wishList_I"
										 style="display: block;"></div>
								<?php } ?>
								<a href="<?php echo base_url(); ?>rental/<?php echo $product_image['seourl']; ?>">
									<?php if (($product_image['product_image'] != '') && (file_exists('./images/rental/' . $product_image['product_image']))) {
										?>
										<div class="card-image"><div class="myPlace"
											 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $product_image['product_image']; ?>')"></div></div>
									<?php } else { ?>
										<div class="card-image"><div class="myPlace"
											 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div></div>
									<?php } ?>
									<div class="bottom">
										<div class="loc" style="display: none;">
										<?php 
										// if($_SESSION['language_code'] == 'en'){
										// if ($product_image['list_value']!='' && $product_image['city']!=''){
										// 	echo $product_image['list_value'] . " . " .$product_image['city'];
										// }else if ($product_image['list_value']!=''){
										// 	echo $product_image['list_value'];
										// }else if ($product_image['city']!=''){
										// 	echo $product_image['city'];
										// }
										// 	}
										// 	elseif($_SESSION['language_code']=='ar')	
										// 	{
										// 		if ($product_image['list_value_ar']!='' && $product_image['city']!=''){
										// 	echo $product_image['list_value_ar'] . " . " .$product_image['city'];
										// }else if ($product_image['list_value_ar']!=''){
										// 	echo $product_image['list_value_ar'];
										// }else if ($product_image['city']!=''){
										// 	echo $product_image['city'];
										// }
										// 	}
										// 	else{
										// 		if ($product_image['list_value']!='' && $product_image['city']!=''){
										// 	echo $product_image['list_value'] . " . " .$product_image['city'];
										// }else if ($product_image['list_value']!=''){
										// 	echo $product_image['list_value'];
										// }else if ($product_image['city']!=''){
										// 	echo $product_image['city'];
										// }
										// 	}	
										// if($_SESSION['language_code'] == 'en'){			
										// 		if ($product_image['list_value']!='' && $product_image['city']!=''){
										// 	echo $product_image['list_value'] . " . " .$product_image['city'];
										// }else if ($product_image['list_value']!=''){
										// 	echo $product_image['list_value'.$_SESSION['language_code']];
										// }else if ($product_image['city']!=''){
										// 	echo $product_image['city'];
										// }	
										// }
										// else{
										// 		if ($product_image['list_value']!='' && $product_image['city']!=''){
										// 	echo $product_image['list_value_'.$_SESSION['language_code']] . " . " .$product_image['city'];
										// }else if ($product_image['list_value']!=''){
										// 	echo $product_image['list_value'];
										// }else if ($product_image['city']!=''){
										// 	echo $product_image['city'];
										// }
										// }	

															$list_value_val=language_dynamic_enable("list_value",$this->session->userdata('language_code'),$product_image);
 echo ucfirst($list_value_val.' ');
 $city_val=language_dynamic_enable("city",$this->session->userdata('language_code'),$product_image);
 echo ucfirst($city_val);		
										  ?></div>
										<h5><?php

										      // if($_SESSION['language_code'] =='en')
                //                                  {
                //                                      $prod_tiltle = $product_image['product_title'];
                //                                  }
                //                                  else
                //                                  {
                //                                      $prod_Ar='product_title_'.$_SESSION['language_code'];
                //                                      if($product_image[$prod_Ar] == '') { 
                //                                          $prod_tiltle=$product_image['product_title'];
                //                                      }
                //                                      else{
                //                                         $prod_tiltle=$product_image['product_title_'.$_SESSION['language_code']];
                //                                     }
                                                
                //                                }
                //                                echo ucfirst($prod_tiltle);
										$prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$product_image);
 echo ucfirst($prod_tiltle);

											//echo ucfirst($product_image['product_title']);
											
											?></h5>
										<div class="price"><span
												class="number_s"><?php if ($product_image['currency'] != '') {
													echo $this->session->userdata('currency_s');
												} else {
													echo $this->session->userdata('currency_s');
												}
												
												$cur_Date = date('Y-m-d');
												if ($product_image['currency'] != '') {
													if ($product_image['currency'] != $this->session->userdata('currency_type')) {
														$list_currency = $product_image['currency'];
														if ($currency_result->$list_currency) {
															//$price = $product_image['price'] / $currency_result->$list_currency;
															$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $product_image['price']);
														} else {
															$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $product_image['price']);
														}
														echo number_format($price, 2);
													} else {
														$priceEx = $product_image['price'];
														echo number_format($priceEx, 2);
													}
												} else {
													$priceEx1 = $product_image['price'];
													echo number_format($priceEx1, 2);
												}

												if($this->lang->line('per_night') != '') {
                            $per= stripslashes($this->lang->line('per_night'));
                        } else $per= "Per night"; ?>
                                                 </span> <?php if($product_image['instant_pay'] == 'Yes'){ ?><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="svg_instsant_pay" style="vertical-align: middle;"><g><path d="m29.8 12.6q0.4 0.5 0.1 1l-12 25.8q-0.3 0.6-1 0.6-0.1 0-0.3 0-0.4-0.2-0.6-0.5t-0.1-0.6l4.4-18.1-9 2.3q-0.1 0-0.3 0-0.4 0-0.7-0.2-0.4-0.4-0.3-0.9l4.5-18.4q0.1-0.3 0.4-0.5t0.6-0.2h7.3q0.4 0 0.7 0.2t0.3 0.7q0 0.2-0.1 0.4l-3.8 10.3 8.8-2.2q0.2 0 0.3 0 0.4 0 0.8 0.3z"></path></g></svg><?php } ?><span style="font-size:14px;"><?php echo $per;  ?> </span> 
												
										</div>
										<div class="bottom-text">
                                                <p>
                                                    Lorem ipsum dolor sit amet, in elit nominati usu. Mei ea vivendo maluisset, hinc graece facilisis pr [more]
                                                </p>
                                        </div>
                                        <div class="bottom-icons">
                                                <span class="user-limit">8</span>
                                        </div>
										<div class="clear">
											<div class="starRatingOuter">
												<?php
												$avg_val = round($product_image['rate']);
												$num_reviewers = $product_image['num_reviewers'];
												?>
												<div class="starRatingInner"
													 style="width: <?php echo($avg_val * 20); ?>%;"></div>
											</div>
											<span
												class="ratingCount"><?php echo $num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
													echo stripslashes($this->lang->line('Reviews'));
												} else echo "Reviews"; ?></span>
										</div>
									</div>
								</a>
							</div>
							</div>
						</div>
					<?php }
				} else {
					?>
					<div class="col-sm-12 col-md-12">
						<p class="text-center text-danger"><?php if ($this->lang->line('no_more_rentals') != '') {
													echo stripslashes($this->lang->line('no_more_rentals'));
												} else echo "No more rentals found"; ?> !</p>
					</div>
					<?php
				}
				?>
				
				
				
				
				
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="text-center" id="ajax-load" style="display:none;"><?php if ($this->lang->line('loading') != '') {
													echo stripslashes($this->lang->line('loading'));
												} else echo "Loading"; ?> .. </p>
				</div>
			</div>
		</div>
	</section>
	<?php
	$this->load->view('site/includes/footer');
	?>
	<script>
		/*Scroll loading pages*/
		var page = $('#page_number').val();
		
		$(window).scroll(function () { 
			if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
				if (page <= <?php echo $total_pages; ?>) {  
				//alert('<?php echo $total_pages; ?>');
					loadMoreData(page);
				}
				page++;
			}
		});

		function loadMoreData(page) { 
			$.ajax(
				{
					url: '<?php echo base_url(); ?>explore_listing?page=' + page,
					type: "get",
					beforeSend: function () {
						$('#ajax-load').show();
					}
				})
				.done(function (data) {
					if (data == "") {
						$('#ajax-load').html("No more records found");
						return;
					}
					$('#ajax-load').hide();
					$("#property_listings").append(data);
				})
				.fail(function (jqXHR, ajaxOptions, thrownError) {
					boot_alert('server not responding...');
				});
		}

		/*End scroll loading*/
	</script>
