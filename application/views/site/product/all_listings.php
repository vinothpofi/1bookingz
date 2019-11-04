<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
?>
<section style="overflow-x: hidden;">
	<?php echo form_open('all_listing', array('method' => 'post', 'id' => 'search_result_form'));
	if ($total_listings == '') {
		$total_listings = '0';
	}
	$data = array('type' => 'hidden', 'name' => 'total_listings', 'id' => 'total_listings', 'value' => $total_listings);
	echo form_input($data);
	
	$data = array('type' => 'hidden', 'id' => 'page_number', 'name' => 'page_number', 'value' => 1);
	echo form_input($data);
	echo form_close();
	?>
	<section class="loggedBg" style="display: none;">
		<div class="container">
			<ul class="loginMenu">
			
				<li><a href="<?php echo base_url(); ?>explore_listing" <?php if ($this->uri->segment(1) == 'explore_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('places_up') != '') { echo stripslashes($this->lang->line('places_up')); } else echo "PLACES"; ?></a></li>
				
				<li> <a href="<?php echo base_url(); ?>explore-experience" <?php if ($this->uri->segment(1) == 'explore-experience') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('EXPERIENCE') != '') { echo stripslashes($this->lang->line('EXPERIENCE')); } else echo strtoupper("EXPERIENCE"); ?></a></li>
				
				<li><a href="<?php echo base_url(); ?>all_listing" <?php if ($this->uri->segment(1) == 'all_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All')); } else echo "ALL"; ?></a> </li>
			</ul>
		</div>
	</section>
	<section>
	<div class="container" style="margin-top: 20px;">
        <div class="rowHead" style="margin: 20px 0px 0px;">
		<h3><?php if ($this->lang->line('Homes_around_world') != '') { echo stripslashes($this->lang->line('Homes_around_world')); } else echo "Homes around the world"; ?></h3>

        <!-- start -->
        <?php
        if ($this->lang->line('See All') != '') { $s=stripslashes($this->lang->line('See All')); } else $s= "See All";
        if ($product_count > 8) {
            echo '
					
						
						<a href="'.base_url().'explore_listing" class="seeAll" style="color: #a61d55;"> ' .$s.' ('.$product_count.') &gt; </a>
						
					
					';
        }
        ?>
        <!-- end -->
        </div>

        <div class="clearfix"></div>
			<div class="row listings card-section-bg explore-card-sec">
			<?php
				if ($product->num_rows() > 0) {
					foreach ($product->result_array() as $product_image) {
						/*print_r($newArr);;die;*/
						?>
						<div class="col-sm-6 col-md-4">
							<div class="card-section">
							<div class="owl-carousel show">
								<div class="item">
								<?php if ($this->session->userdata('fc_session_user_id')) {
									if($userDetails->row()->group == 'User'){
										if (in_array($product_image['id'], $newArr)) { ?>
											<div class="wishList_I yes" style="display: block;"></div>
										<?php } else {
											?>
											<div class="wishList_I" style="display: block;"
												 onclick="loadWishlistPopup('<?php echo $product_image['id']; ?>');"></div>
											<?php
										}
									}
								} else { ?>
									<div data-toggle="modal" data-target="#signIn" class="wishList_I normal_login_link"
										 style="display: block;"></div>
								<?php } ?>
								<a href="<?php echo base_url(); ?>rental/<?php echo $product_image['seourl']; ?>">
									<?php if (($product_image['product_image'] != '') && (file_exists('./images/rental/' . $product_image['product_image']))) {
										?>
										<div class="myPlace"
											 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $product_image['product_image']; ?>')"></div>
									<?php } else { ?>
										<div class="myPlace"
											 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div>
									<?php } ?>
								</a>
							</div>
							</div>
									<div class="bottom">
										<div class="loc">
										<?php 
										if ($product_image['list_value']!='' && $product_image['city']!=''){

											$prod_tiltle=language_dynamic_enable("list_value",$this->session->userdata('language_code'),(object)$product_image);
                                                           // echo ucfirst($prod_tiltle);

                                             echo "$prod_tiltle" . " . " .$product_image['city'];                 

											//echo $product_image['list_value'] . " . " .$product_image['city'];


										}else if ($product_image['list_value']!=''){
											echo $product_image['list_value'];
										}else if ($product_image['city']!=''){
											echo $product_image['city'];
										}
																				
										  ?></div>
										<h5><?php
										//	echo ucfirst($product_image['product_title']);

										$prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),(object)$product_image);
                                                            echo ucfirst($prod_tiltle);                                              
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
												?></span> <?php echo $this->session->userdata('currency_type');
												?>
												<?php if($product_image['instant_pay'] == 'Yes'){ ?><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="svg_instsant_pay" style="vertical-align: middle;"><g><path d="m29.8 12.6q0.4 0.5 0.1 1l-12 25.8q-0.3 0.6-1 0.6-0.1 0-0.3 0-0.4-0.2-0.6-0.5t-0.1-0.6l4.4-18.1-9 2.3q-0.1 0-0.3 0-0.4 0-0.7-0.2-0.4-0.4-0.3-0.9l4.5-18.4q0.1-0.3 0.4-0.5t0.6-0.2h7.3q0.4 0 0.7 0.2t0.3 0.7q0 0.2-0.1 0.4l-3.8 10.3 8.8-2.2q0.2 0 0.3 0 0.4 0 0.8 0.3z"></path></g></svg><?php } ?>
												<?php
                                            if($this->lang->line('per_night') != '') {
                                                $per= stripslashes($this->lang->line('per_night'));
                                            } else $per= "per night"; ?>
                                            <span style="font-size:14px;"><?php echo $per;  ?> </span>
                                        </div>
                                        <div class="bottom-text">
												<?php $desc_length = strlen($product_image['description']);
												if($desc_length > 100){
													$pro_description = character_limiter($product_image['description'],100);
												}else{
													$pro_description =  strip_tags($product_image['description']);
												} ?>
												
                                                <p>
                                                    <?php echo $pro_description; ?>
                                                </p>
                                        </div>
                                        <div class="bottom-icons">
										
											<?php $list_type_value = $this->product_model->get_listing_child(); 
												$finalsListing = json_decode($product_image['listings']);
												foreach ($finalsListing as $listingResult => $FinalValues) {
													$resultArr[$listingResult] = $FinalValues;		 
												} 
												
												if($list_type_value->num_rows() > 0){
													foreach($list_type_value->result() as $list_val){
														 if($resultArr[$list_val->parent_id] != ''){ 
														 $list_child_value = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $resultArr[$list_val->parent_id]));
															
															if($list_val->type == 'option'){ ?>
																<span class="<?= $list_val->name; ?>">
																	<?php echo stripslashes(ucfirst($list_child_value->row()->child_name)); ?>
																</span>
															
															<?php  } elseif($list_val->type == 'text') { ?>
																<span class="<?= $list_val->name; ?>">
																	<?php echo stripslashes(ucfirst($resultArr[$list_val->parent_id])); ?>
																</span>
															<?php }
															}else{ ?>
														
															  <span class="<?= $list_val->name; ?>"> 0</span>
														<?php  }?>
														<?php }
													}
												
											?>
													
                                                
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
	</div>
		
	</section>
	
	<!--Experinece All-->
	<?php /* <section>
		<div class="container" style="margin-top: 20px;">
            <div class="rowHead">
		<h3><?php if ($this->lang->line('Experiences_travelers') != '') { echo stripslashes($this->lang->line('Experiences_travelers')); } else echo "Experiences travelers love"; ?></h3>

                <?php
                if ($experience_count > 8) {
                    echo '
					
						<a class="seeAll" href="'.base_url().'explore-experience">See All ('.$experience_count.')&gt;</a>
						';
                }
                ?>

            </div>
            <div class="clearfix"></div>

			<div class="row listings">
			<?php
				if ($experience->num_rows() > 0) {
					foreach ($experience->result_array() as $product_image) {
						?>
						<div class="col-sm-4 col-md-3" style="margin-top: 20px;">
						<div class="owl-carousel show">
							<?php if ($this->session->userdata('fc_session_user_id')) {
								if (in_array($product_image['experience_id'], $newArr)) { ?>
									<div class="wishList_I yes" style="display: block;"></div>
								<?php } else {
									?>
									<div class="wishList_I" style="display: block;"
										 onclick="loadExperienceWishlistPopup('<?php echo $product_image['experience_id']; ?>');"></div>
									<?php
								}
							} else { ?>
								<div data-toggle="modal" data-target="#signIn" class="wishList_I"
									 style="display: block;"></div>
							<?php } ?>
							<a href="<?= base_url() . 'view_experience/' . $product_image['experience_id']; ?>">
								<?php if (($product_image['product_image'] != '') && (file_exists('./images/experience/' . trim($product_image['product_image'])))) {
									?>
									<div class="myPlace"
										 style="background-image: url('<?php echo base_url(); ?>images/experience/<?php echo trim($product_image['product_image']); ?>')"></div>
								<?php } else { ?>
									<div class="myPlace"
										 style="background-image: url('<?php echo base_url(); ?>images/experience/dummyProductImage.jpg')"></div>
								<?php } ?>
								<div class="bottom">
									<div class="loc">
									<?php 
									if ($product_image['type_title']!='' && $product_image['city']!=''){
											echo $product_image['type_title'] . " . " .$product_image['city'];
										}else if ($product_image['type_title']!=''){
											echo $product_image['type_title'];
										}else if ($product_image['city']!=''){
											echo $product_image['city'];
										}

									?>
									
									</div>
									<h5><?php
										//echo ucfirst($product_image['experience_title']);
									$prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),(object)$product_image);
                                                            echo ucfirst($prod_tiltle);
										
										?></h5>
									<div class="price"><span
											class="number_s"><?php if ($product_image['currency'] != '') {
												echo $this->session->userdata('currency_s');
											} else echo $this->session->userdata('currency_s');
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
											?></span> <span style="font-size:14px;"> <?php echo $this->session->userdata('currency_type'); ?> <?php if ($this->lang->line('per_person') != '') {
												echo stripslashes($this->lang->line('per_person'));
											} else echo "per person"; ?></span>
									</div>
									<div class="clear">
										<div class="starRatingOuter">
											<?php
											$avg_val = $num_reviewers = 0;
											if ($product_image['experience_id'] != '') {
												$id = $product_image['experience_id'];
												$res = $this->product_model->get_avg_review_experience($id);
												$avg_val = round($res->avg_val);
												$num_reviewers = $res->num_reviewers;
											}
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
	
		
	</section>  */?>
	<!--end experience all-->
	
	<!--city-->
	  <div id="property_listings">
	<?php if ($CityDetails->num_rows() > 0) {
    foreach ($CityDetails->result() as $CityRows) {
        $city_name = $CityRows->city;
        if ($CityRows->state != '') {
            $StateNameLi = "," . str_replace(' ', '+', $CityRows->state);
            $disState = $CityRows->state;
        } else {
            $StateNameLi = "";
            $disState = '';
        }
        if ($CityRows->country != '') {
            $CountryLi = "," . str_replace(' ', '+', $CityRows->country);
            $disCountry = $CityRows->country;
        } else {
            $CountryLi = "";
            $disCountry = "";
        }
		
		
		//for property
        if (count($CityName[$city_name]) > 0) { 
            ?>
            <section>
                
			
			<div class="container" style="margin-top: 20px;">

                <div class="rowHead">
				<h3><?php if ($this->lang->line('Home in') != '') {
                                    echo stripslashes($this->lang->line('Home in'));
                                } else echo "Home in"; ?>
                                <?php echo ucfirst($city_name); ?></h3>
                            <a href="<?= base_url(); ?>property?city=<?php echo $city_name . $StateNameLi . $CountryLi; ?>"
                               class="seeAll pull-right"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> <span class="icon">></span></a>
                </div>
                <div class="clearfix"></div>
				<div class="row listings card-section-bg explore-card-sec">
				<?php foreach ($CityName[$city_name] as $CityRowss) { ?>
						<div class="col-sm-6 col-md-4">
							<div class="card-section">
							<div class="owl-carousel show">
							<div class="item">
							  <a href="<?php echo base_url(); ?>rental/<?php echo $CityRowss->seourl; ?>">
                                        <?php
                                        $base = base_url();
                                        $url = getimagesize($base . 'images/rental/' . $CityRowss->product_image);
                                        if (!is_array($url)) {
                                            $img = "1"; //no
                                        } else {
                                            $img = "0";  //yes
                                        }
                                        if ($CityRowss->product_image != '' && $img == '0') { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $CityRowss->product_image; ?>')"></div>
                                        <?php } else { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div>
                                        <?php } ?>
                                    </a>
                                </div>
							</div>
                                        <div class="bottom">
                                           <div class="loc">
										   <?php  
											   
											   if ($CityRowss->list_value!='' && $CityRowss->city!=''){
												   echo $CityRowss->list_value . " . " . $CityRowss->city;
											   }else if ($CityRowss->list_value!=''){
												   echo $CityRowss->list_value;
											   }else if ($CityRowss->city!=''){
												   echo $CityRowss->city;
											   }
										?> </div>
                                            <h5><?php
                                           // print_r($CityRowss);
                                              //echo ucfirst($CityRowss->product_title_ar);
                                            $prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$CityRowss);
                                                            echo ucfirst($prod_tiltle);
												
                                                ?> </h5>
                                            <?php
                                            $avg_val = round($CityRowss->avg_val);
                                            $num_reviewers = $CityRowss->num_reviewers;
                                            ?>
                                            <div class="price"><span class="number_s"><?php 
                                                    if ($CityRowss->currency != $this->session->userdata('currency_type')) {
                                                        echo $currencySymbol;
                                                        $currency = $CityRowss->currency;
                                                        if ($currency_result->$currency) {
                                                            //$price = $CityRowss->price / $currency_result->$currency;
															$price = currency_conversion($currency, $this->session->userdata('currency_type'), $CityRowss->price);
                                                        } else {
                                                            $price = currency_conversion($currency, $this->session->userdata('currency_type'), $CityRowss->price);
                                                        }
                                                        echo number_format($price, 2);
                                                    } else {
                                                        echo $currencySymbol;
                                                        $price = $CityRowss->price;
                                                        echo number_format($price, 2);
                                                    } ?></span> <?php echo $this->session->userdata('currency_type'); ?>
                                                    <?php if($CityRowss->instant_pay == 'Yes'){ ?><svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="svg_instsant_pay" style="vertical-align: middle;"><g><path d="m29.8 12.6q0.4 0.5 0.1 1l-12 25.8q-0.3 0.6-1 0.6-0.1 0-0.3 0-0.4-0.2-0.6-0.5t-0.1-0.6l4.4-18.1-9 2.3q-0.1 0-0.3 0-0.4 0-0.7-0.2-0.4-0.4-0.3-0.9l4.5-18.4q0.1-0.3 0.4-0.5t0.6-0.2h7.3q0.4 0 0.7 0.2t0.3 0.7q0 0.2-0.1 0.4l-3.8 10.3 8.8-2.2q0.2 0 0.3 0 0.4 0 0.8 0.3z"></path></g></svg><?php } ?>
                                                <?php 
                                                if($this->lang->line('per_night') != '') {
                                                    $per= stripslashes($this->lang->line('per_night'));
                                                } else $per= "per night"; ?>
                                                <span style="font-size:14px;"><?php echo $per;  ?> </span>
                                            </div>
                                            <div class="bottom-text">
											 <?php $prod_desc=language_dynamic_enable("description",$this->session->userdata('language_code'),$CityRowss);
													$desc_length = strlen($prod_desc); ?>
											
                                                <p>
                                                <?php if($desc_length > 100){
													echo character_limiter($prod_desc,100);
												}else{
													echo strip_tags($prod_desc);
												} ?>
                                                </p>
                                        	</div>
											
                                        	<div class="bottom-icons">
										
											<?php $list_type_value = $this->product_model->get_listing_child(); 
												$finalsListing = json_decode($CityRowss->listings);
												foreach ($finalsListing as $listingResult => $FinalValues) {
													$resultArr[$listingResult] = $FinalValues;		 
												} 
												
												if($list_type_value->num_rows() > 0){
													foreach($list_type_value->result() as $list_val){
														 if($resultArr[$list_val->list_id] != ''){ 
														 $list_child_value = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $resultArr[$list_val->list_id]));
															
															if($list_val->type == 'option'){ ?>
																<span class="<?= $list_val->name; ?>">
																	<?php echo stripslashes(ucfirst($list_child_value->row()->child_name)); ?>
																</span>
															
															<?php  } elseif($list_val->type == 'text') { ?>
																<span class="<?= $list_val->name; ?>">
																	<?php echo stripslashes(ucfirst($resultArr[$list_val->list_id])); ?>
																</span>
															<?php }
															}else{ ?>
														
															  <span class="<?= $list_val->name; ?>"> 0</span>
														<?php  }?>
														<?php }
													}
												
											?>
													
                                                
                                        </div>
											
                                            <div class="clear">
                                                <div class="starRatingOuter">
                                                    <div class="starRatingInner"
                                                         style="width: <?php echo($avg_val * 20); ?>%;"></div>
                                                </div>
                                                <span
                                                        class="ratingCount"> <?php echo $num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
                                                        echo stripslashes($this->lang->line('Reviews'));
                                                    } else echo "Reviews"; ?> </span>
                                            </div>
                                        </div>
                                 </div>   
						</div>
					<?php } ?>
				 </div>
			   </div>
			  </section>
			  
			<?php } ?>
				
			  <!--end for property-->
			  
			  <!--for experience-->
			  <?php if (count($CityName_exp[$city_name]) > 0) { ?>

            <section>
              
				
				<div class="container" style="margin-top: 20px;">
                    <div class="rowHead">
					<h3><?php if ($this->lang->line('experience in') != '') {
                                    echo stripslashes($this->lang->line('experience in'));
                                } else echo "Experience in"; ?>
                                <?php echo ucfirst($city_name); ?></h3>
                            <a href="<?= base_url(); ?>explore-experience?city=<?php echo $city_name . $StateNameLi . $CountryLi; ?>"
                               class="seeAll pull-right"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> <span class="icon">></span></a>
                    </div>
                    <div class="clearfix"></div>
				<div class="row listings">
				<?php foreach ($CityName_exp[$city_name] as $Cityexp) { ?>
						<div class="col-sm-4 col-md-3" style="margin-top: 20px;">
							<div class="owl-carousel show">
								
							  <a href="<?php echo base_url(); ?>view_experience/<?php echo $Cityexp->experience_id; ?>">
                                        <?php
                                        $base = base_url();
                                        $url = getimagesize($base . 'images/experience/' . $Cityexp->product_image);
                                        if (!is_array($url)) {
                                            $img = "1"; //no
                                        } else {
                                            $img = "0";  //yes
                                        }
                                        if ($Cityexp->product_image != '' && $img == '0') { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/experience/<?php echo $Cityexp->product_image; ?>')"></div>
                                        <?php } else { ?>
                                            <div class="myPlace"
                                                 style="background-image: url('<?php echo base_url(); ?>images/experience/dummyProductImage.jpg')"></div>
                                        <?php } ?>
                                        <div class="bottom">
                                           <div class="loc">
										   <?php  
											   
											   if ($Cityexp->type_title!='' && $Cityexp->city!=''){
												   echo $Cityexp->type_title . " . " . $Cityexp->city;
											   }else if ($Cityexp->type_title!=''){
												   echo $Cityexp->type_title;
											   }else if ($Cityexp->city!=''){
												   echo $Cityexp->city;
											   }
										?> </div>
                                            <h5><?php
                                              //echo ucfirst($Cityexp->experience_title);

                                            $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),(object)$Cityexp);
                                                            echo ucfirst($prod_tiltle);
												
                                                ?> </h5>
                                            
                                            <div class="price"><span class="number_s"><?php 
                                                    if ($Cityexp->currency != $this->session->userdata('currency_type')) {
                                                        echo $currencySymbol;
                                                        $currency = $Cityexp->currency;
                                                        if ($currency_result->$currency) {
                                                            //$price = $Cityexp->price / $currency_result->$currency;
															$price = currency_conversion($currency, $this->session->userdata('currency_type'), $Cityexp->price);
                                                        } else {
                                                            $price = currency_conversion($currency, $this->session->userdata('currency_type'), $Cityexp->price);
                                                        }
                                                        echo number_format($price, 2);
                                                    } else {
                                                        echo $currencySymbol;
                                                        $price = $Cityexp->price;
                                                        echo number_format($price, 2);
                                                    } ?></span> <?php echo $this->session->userdata('currency_type'); ?>
                                                <?php if ($this->lang->line('per_person') != '') {
                                                    echo stripslashes($this->lang->line('per_person'));
                                                } else echo "per person"; ?>
                                            </div>
                                            <div class="clear">
                                                   <div class="starRatingOuter">
                                                    <div class="starRatingInner"
                                                         style="width: <?php echo($Cityexp->avg_val * 20); ?>%;"></div>
                                                </div>
                                                <span
                                                        class="ratingCount"> <?php echo $Cityexp->num_reviewers. " "; ?><?php if ($this->lang->line('Reviews') != '') {
                                                        echo stripslashes($this->lang->line('Reviews'));
                                                    } else echo "Reviews"; ?> </span>
                                            </div>
                                        </div>
                                    </a>
							</div>
						</div>
					<?php } ?>
				 </div>
			   </div>
			   
			  </section>
			  
			  <?php } ?>
			  
            <?php
        }
    }
 ?>
	</div>
	
		<div class="row">
			<div class="col-lg-12">
				<p class="text-center" id="ajax-load" style="display:none;"> <i class="fa fa-spin fa-spinner"></i> <?php if ($this->lang->line('loading') != '') {
												echo stripslashes($this->lang->line('loading'));
											} else echo "Loading"; ?> .. </p>
			</div>
		</div>
			
	<?php
	$this->load->view('site/includes/footer');
	?>
	<script>
		/*Scroll loading pages*/
		var page = $('#page_number').val();
		$(window).scroll(function () { 
			//console.log($(document).height());
			if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
				if (page <= <?php echo $total_pages; ?>) { 
				//alert('<?php echo $total_pages; ?>');
					loadMoreData(page);
				}
				page++;
			}
		});

		function loadMoreData(page) {  //console.log("Sds"+page);
			$.ajax(
				{
					url: '<?php echo base_url(); ?>all_listing?page=' + page,
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
