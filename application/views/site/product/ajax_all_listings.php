<!--city-->
	<?php $currency_result = $this->session->userdata('currency_result');
	 if ($CityDetails->num_rows() > 0) {
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
			
			<div class="container" ><!--container-fluid-->

                <div class="rowHead">
                <h3><?php if ($this->lang->line('Home in') != '') {
                                    echo stripslashes($this->lang->line('Home in'));
                                } else echo "Home in"; ?>
                                <?php echo ucfirst($city_name); ?></h3>
                            <a href="<?= base_url(); ?>property?city=<?php echo urlencode($city_name . $StateNameLi . $CountryLi); ?>"
                               class="seeAll text-danger pull-right" style="color: #a61d55;"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> (<?php echo $CityNameCount[$city_name];?>)<span class="icon">></span></a>

                </div>
                <div class="clearfix"></div>

				<div class="row listings card-section-bg">
				<?php foreach ($CityName[$city_name] as $CityRowss) { ?>
						<div class="col-sm-4 col-md-4">
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
                                                 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg"></div>
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
                                              echo ucfirst($CityRowss->product_title);
												
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
                                                    } ?></span> <?php echo $this->session->userdata('currency_type'); ?><span style="font-size:14px;"><?php if ($this->lang->line('per_night') != '') {
                                                echo stripslashes($this->lang->line('per_night'));
                                            } else echo "per night"; ?></span>
                                            </div>
                                            <div class="bottom-text">
												<?php $desc_length = strlen($CityRowss->description);
												if($desc_length > 100){
													$pro_description = character_limiter($CityRowss->description,100);
												}else{
													$pro_description =  strip_tags($CityRowss->description);
												} ?>
												
                                                <p>
                                                    <?php echo $pro_description; ?>
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
                
				
				<div class="container" style="margin-top: 20px;"><!--container-fluid-->
                    <div class="rowHead">
                    <h3><?php if ($this->lang->line('experience in') != '') {
                                    echo stripslashes($this->lang->line('experience in'));
                                } else echo "Experience in"; ?>
                                <?php echo ucfirst($city_name); ?></h3>
                            <a href="<?= base_url(); ?>explore-experience?city=<?php echo $city_name . $StateNameLi . $CountryLi; ?>"
                               class="seeAll text-danger pull-right" style="    color: #a61d55;"><?php if ($this->lang->line('See_all') != '') {
                                    echo stripslashes($this->lang->line('See_all'));
                                } else echo "See all"; ?> (<?php echo $CityName_exp_count[$city_name];?>) <span class="icon">></span></a>

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
                                            $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),$Cityexp);
                                                           // echo ucfirst($prod_tiltle);
                                             echo ucfirst($prod_tiltle);
                                              //echo ucfirst($Cityexp->experience_title);
												
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
                                                    } ?></span> <?php echo $this->session->userdata('currency_type'); ?><span style="font-size:14px;"><?php if ($this->lang->line('per_person') != '') {
                                                echo stripslashes($this->lang->line('per_person'));
                                            } else echo "per person"; ?></span>
                                            </div>
                                            <div class="clear">
                                                <div class="starRatingOuter">
                                                   
                                                </div>
                                                <span>
                                                        </span>
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