<?php

$this->load->view('site/includes/header');

$product = $productDetails->row();

$listings_values = $product->listings;

$product_id = $product->id;

$currency_result = $this->session->userdata('currency_result');

?>
<style type="text/css">
/* timer */

/* @import url(https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,900,700italic,700,600italic,600,400italic);

body {
  font-family: 'Titillium Web', cursive;
  width: 800px;
  margin: 0 auto;
  text-align: center;
  color: white;
  background: #222;
  font-weight: 100;
} */

.timer_class {
  display: inline-block;
  line-height: 1;
  padding: 0px;
  font-size: 40px;
}

div#timer span {
  display: block;
  font-size: 10px;
  color: #000000;
} 

#days {
  font-size: 35px;
  color: #db4844;
}
#hours {
  font-size: 35px;
  color: #f07c22;
}
#minutes {
  font-size: 35px;
  color: #f6da74;
}
#seconds {
  font-size: 25px;
  color: #abcd58;
}
/* end of timer  */
	body:not(.preloader-site) header.posHeader.pageHeader {box-shadow: none;}
	body.iti-mobile header.posHeader.pageHeader {box-shadow: 0px 2px 4px -1px rgba(0,0,0,0.2),0px 4px 5px 0px rgba(0,0,0,0.14),0px 1px 10px 0px rgba(0,0,0,0.12);}
</style>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>css/daterangepicker.css"/>

<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>js/daterangepicker.js"></script>

<style type="text/css">

	.daterangepicker {

		position: absolute;

	}



	@media (max-width: 740px) {

		.daterangepicker {

			height: 320px;

			width: 280px;

		}

	}

</style>

<script>



    function init_slider(ind_number){

        //alert(ind_number);
        var slider = $('#slider');
        var duration = 250;

        var thumbnailSlider = $('#thumbnailSlider');

        /*carousel function for main slider*/

        slider.owlCarousel({
            loop: false,
            nav: true,
            items: 1,
            //startPosition:0
        }).on('changed.owl.carousel', function (e) {
            //alert(e.item.count);
            console.log(e.item.count);
            console.log(e.item.index);
            if (e.item.index == e.item.count - 1) {

                console.log("last");

                $(".fa-chevron-right").addClass("disable");

                $(".fa-chevron-left").removeClass("disable");

            }

            else if (e.item.index == 0) {

                $(".fa-chevron-right").removeClass("disable");

                $(".fa-chevron-left").addClass("disable");

                console.log("first");

            }

            else {

                $(".fa-chevron-right").removeClass("disable");

                $(".fa-chevron-left").removeClass("disable");

            }

            /*On change of main item to trigger thumbnail item*/

            thumbnailSlider.trigger('to.owl.carousel', [e.item.index, duration, true]);

        });

        /*carousel function for thumbnail slider*/

        thumbnailSlider.owlCarousel({

            loop: false,

            center: true,

            nav: false,

            responsive: {

                0: {

                    items: 3

                },

                600: {

                    items: 4

                },

                1000: {

                    items: 6

                }

            }

        }).on('click', '.owl-item', function () {
            slider.trigger('to.owl.carousel', [$(this).index(), duration, true]);
        }).on('changed.owl.carousel', function (e) {
            slider.trigger('to.owl.carousel', [e.item.index, duration, true]);
        });

        $('.slider-right').click(function () {
            slider.trigger('next.owl.carousel');
        });

        $('.slider-left').click(function () {
            slider.trigger('prev.owl.carousel');
        });

        if(ind_number!=null){
            //alert('greater')
            slider.trigger('to.owl.carousel', [ind_number]);
        }
    }
    $(document).ready(function(){
        init_slider(0);
    });

</script>

<div id="lightBox">

	

	<div class="outerBlock">

		<div class="closeLightBox">X</div>
		<div class="slider-container">

			<div id="slider" class="slider owl-carousel owl-theme lightBoxSlider">

				<?php

				$banner_background = 'dummyProductImage.jpg';

				if ($productImages->num_rows() > 0) {

					$i = 0;

					foreach ($productImages->result() as $images) {

						if ($images->product_image != "" && file_exists('images/rental/' . $images->product_image)) {

							$image_name = $images->product_image;

						} else {

							$image_name = 'dummyProductImage.jpg';

						}

						if ($i == 0) {

							$banner_background = $image_name;

						}

						?>

						<div class="item">

							<div class="content">

								<img src="<?php echo base_url(); ?>images/rental/<?php echo $image_name; ?>"

									 class="img-responsive">

							</div>

						</div>

						<?php

						$i++;

					}

				} else {

					?>

					<div class="item">

						<div class="content">

							<img src="<?php echo base_url(); ?>images/rental/dummyProductImage.jpg"

								 class="img-responsive">

						</div>

					</div>

					<?php

				} ?>

			</div>

			<!-- <div class="slider-controls">

				<a class="slider-left" href="javascript:;"><span><i class="fa fa-2x fa-chevron-left"></i></span></a>

				<a class="slider-right" href="javascript:;"><span><i

							class="fa fa-2x fa-chevron-right"></i></span></a>

			</div> -->

		</div>

		<!-- <div class="thumbnail-slider-container">

			<div id="thumbnailSlider" class="thumbnail-slider owl-carousel">

				<?php if ($productImages->num_rows() > 0) {

					foreach ($productImages->result() as $images) {

						if ($images->product_image != "" && file_exists('images/rental/' . $images->product_image)) {

							$image_name = $images->product_image;

						} else {

							$image_name = 'dummyProductImage.jpg';

						}

						?>

						<div class="item">

							<div class="content">

								<img src="<?php echo base_url(); ?>images/rental/<?php echo $image_name; ?>"

									 class="img-responsive">

							</div>

						</div>

						<?php

					}

				} else {

					?>

					<div class="item">

						<div class="content">

							<img src="<?php echo base_url(); ?>images/rental/dummyProductImage.jpg"

								 class="img-responsive">

						</div>

					</div>

					<?php

				} ?>

			</div>

		</div> -->

	</div>

</div>





<section style="display: none;">

	<!--<div class="container-fluid lightboxBanner" style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $banner_background; ?>')">

		<button class="viewPhotos"><?php if ($this->lang->line('view_photos') != '') {

								echo stripslashes($this->lang->line('view_photos'));

							} else echo "View Photos"; ?></button>

	</div>--->


    <div class="container-fluid lightboxBanner" style="cursor: pointer;">
        <?php
        $img_ar=$productImages->result_array();
        if ($productImages->num_rows() > 0) {
            for($i=0;$i<5;$i++){
                if (isset($img_ar[$i]['product_image'])){
                    if($img_ar[$i]['product_image']!= "" && file_exists('images/rental/' . $img_ar[$i]['product_image'])) {
                        ${"banner_background".$i} = $img_ar[$i]['product_image'];
                    }else{
						${"banner_background".$i} = 'dummyProductImage.jpg';
					}
                } else {
                    ${"banner_background".$i} = 'dummyProductImage.jpg';
                }
            }
        }

        //echo $banner_background0;

        ?>

        <div class="one bigDiv" onclick="init_slider(0)">
            <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background0; ?>">
        </div>
        <div class="two bigDiv">
            <div class="smallDiv">
                <div class="imgOne" onclick="init_slider(1)">
                    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background1; ?>">
                </div>
                <div class="imgTwo" onclick="init_slider(2)">
                    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background2; ?>">
                </div>
            </div>
            <div class="smallDiv">
                <div class="imgOne" onclick="init_slider(3)">
                    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background3; ?>">
                </div>
                <div class="imgTwo" onclick="init_slider(4)">
                    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background4; ?>">
                </div>
            </div>
        </div>


        <button class="viewPhotos"><?php if ($this->lang->line('view_photos') != '') {

                echo stripslashes($this->lang->line('view_photos'));

            } else echo "View Photos"; ?></button>

    </div>


</section>



<section>
	<div class="outer owl-thumb">
		<div id="big" class="owl-carousel owl-theme">
		  <div class="item lightboxBanner">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background0; ?>">
		  </div>
		  <div class="item lightboxBanner">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background1; ?>">
		  </div>
		  <div class="item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background2; ?>">
		  </div>
		  <div class="item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background3; ?>">
		  </div>
		  <div class="item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background4; ?>">
		  </div>		  
		</div>
		<div id="thumbs" class="owl-carousel owl-theme">
		  <div class="list-item item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background0; ?>">
		  </div>
		  <div class="list-item item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background1; ?>">
		  </div>
		  <div class="list-item item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background2; ?>">
		  </div>
		  <div class="list-item item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background3; ?>">
		  </div>
		  <div class="list-item item">
		    <img src="<?php echo base_url(); ?>images/rental/<?php echo $banner_background4; ?>">
		  </div>		 
		</div>
		</div>
</section>




<section class="rental">

	<div class="container">

		<div class="row">

			<div class="detailLeft details__nav">

				<div class="fixedHeader clear" style="display: none;">

					<div class="fixedContainer">

						<a href="#overview" class="current"> <?php if ($this->lang->line('about_listing') != '') {

								echo stripslashes($this->lang->line('about_listing'));

							} else echo "Overview"; ?></a>

						<a href="#reviews"> <span

								class="dot">.</span> <?php if ($this->lang->line('Reviews') != '') {

								echo stripslashes($this->lang->line('Reviews'));

							} else echo "Reviews"; ?></a>

						<a href="#host"> <span class="dot">.</span> <?php if ($this->lang->line('the_host') != '') {

								echo stripslashes($this->lang->line('the_host'));

							} else echo "The Host"; ?></a>

						<a href="#location"> <span

								class="dot">.</span> <?php if ($this->lang->line('list_Location') != '') {

								echo stripslashes($this->lang->line('list_Location'));

							} else echo "Location"; ?></a>

					</div>

				</div>

				<div class="title" style="display: block;">

					<div class="left" style="display: block;">
					<div class="title-section">
	             	<h2 id="overview"><?php 

	             	if($this->session->userdata('language_code') =='en')

                                    {

                                        $prod_tit = $product->product_title;

                                    }

                                    else

                                    {

                                        $prodAr='product_title_'.$this->session->userdata('language_code');

                                        if($product->$prodAr == '') { 

                                            $prod_tit=$product->product_title;

                                        }

                                        else{

                                            $prod_tit=$product->product_title_ar;

                                        }

                                    }

	             	                echo ucfirst($prod_tit); ?></h2>
	             	               
	             	           </div>
                        <div class="clearfix"></div>
						<div class="clear">

							<div class="colLeft catego loc">

								<?php if($this->session->userdata('language_code') =='en')

                                    {

                                        $cityname = $product->CityName;

                                    }

                                    else

                                    {

                                        $cityAr='name_'.$this->session->userdata('language_code');

                                        if($product->$cityAr == '') { 

                                            $cityname=$product->CityName;

                                        }

                                        else{

                                            $cityname=$product->name_ar;

                                        }

                                    }

                                   // echo $cityname;

                              //  echo ucfirst($cityname); 

								echo ucfirst($cityname) . ', ' . ucfirst($product->State_name) . ', ' . ucfirst($product->Country_name); ?>

							</div>
                            <div class="clearfix"></div>
                         <div class="product-detail-social">
							<div class="starRatingOuter">

								<div class="starRatingInner"

									 style="width: <?php echo (count($reviewData->result_array()) > 0) ? $reviewTotal->row()->tot_tot * 20 : 0; ?>%;"></div>

							</div>

							<div class="colLeft">

								<span

									class=""><?php echo count($reviewData->result_array()); ?></span> <?php if ($this->lang->line('Reviews') != '') {

									echo stripslashes($this->lang->line('Reviews'));

								} else echo "Reviews"; ?>

							</div>

							<div class="right">

								<?php

								$description = $product->experience_description;

								$url = base_url().$this->uri->uri_string();

								$url = urlencode($url);

								$facebook_share = 'http://www.facebook.com/sharer.php?u=' . $url;
								$twitter_share = 'https://twitter.com/share?url=' . $url;
								$google_share = 'https://plus.google.com/share?url=' . $url;

								?>

								<i class="fa fa-facebook" aria-hidden="true" style="cursor: pointer;"

								   onclick="window.location.href='<?= $facebook_share; ?>'"></i>

								<i class="fa fa-twitter" aria-hidden="true" style="cursor: pointer;"

								   onclick="window.location.href='<?= $twitter_share; ?>'"></i>

								<!-- <i class="fa fa-google-plus" aria-hidden="true" style="cursor: pointer;"
								   onclick="window.location.href='<?= $google_share; ?>'"></i> -->

								<i class="fa fa-pinterest" aria-hidden="true" style="cursor: pointer;"
								   onclick="window.location.href=''"></i>

							</div>

						</div>

						</div>

					</div>

					<!--<div class="right">

						<?php

						if ($product->thumbnail != "" && file_exists('./images/users/' . $product->thumbnail)) {

							$img = base_url() . "images/users/" . $product->thumbnail;

						} else {

							$img = base_url() . "images/users/profile.png";

						}

						?>

						<img src="<?php echo $img; ?>">

						<p><?php echo ($product->user_id > 0 && $product->user_id != '') ? ucfirst($product->firstname) : 'Administrator'; ?></p>

					</div>

                    -->

				</div>


			<div class="product-detail-tab">
				<ul class="nav nav-tabs">
				  <li class="active"><a data-toggle="tab" href="#description-tab">Description</a></li>
				  <li><a data-toggle="tab" href="#detail-tab">Details</a></li>
				  <li><a data-toggle="tab" href="#review-tab"><?php if ($this->lang->line('Reviews') != '') {

								echo stripslashes($this->lang->line('Reviews'));

							} else echo "Reviews"; ?></a></li>
				  <li><a data-toggle="tab" href="#host-tab"><?php if ($this->lang->line('the_host') != '') {

								echo stripslashes($this->lang->line('the_host'));

							} else echo "The Host"; ?></a></li>
				</ul>


				<div class="tab-content">
				  <div id="description-tab" class="tab-pane fade in active">
				   	<p>

					<?php

					                    /*if($_SESSION['language_code'] =='en')

                                                 {

                                                     $prod_desc = $product->description_ar;

                                                 }

                                                 else

                                                 {

                                                     $prod_Ar='description_'.$_SESSION['language_code'];

                                                    // echo $CityRowss->description_ar;

                                                     if($product->$prod_Ar == '') { 

                                                         $prod_desc=$product->description_ar;

                                                     }

                                                     else{

                                                        $prod_desc=$product->description_ar;

                                                    }

                                               }*/

		                        $prod_tiltle=language_dynamic_enable("description",$this->session->userdata('language_code'),$product);
		                        echo ucfirst($prod_tiltle);

                                            // echo ucfirst($prod_desc);

				                      //	echo nl2br(stripslashes($prod_desc));

					if ($product->video_url != '') {

						$url = $product->video_url;

						preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);

						$id = $matches[1];

						if ($id != '') {

							?>

							<iframe width="100%" height="350px"

									src="https://www.youtube.com/embed/<?php echo $id ?>?rel=0&showinfo=0&color=white&iv_load_policy=3">

							</iframe>

							<?php

						} else {

							?>

							<iframe width="100%" height="350px" src="<?php echo $product->video_url; ?>">

							</iframe>

							<?php

						}

					}

					?>

				</p>
				  </div>
				  
				  
				  
				
			<div id="detail-tab" class="tab-pane fade">

				<div class="features">

					<ul class="clear">

						<?php if ($product->home_type != '') { ?>

							<li>

                               <?php $getlistImage=$this->product_model->get_all_details(LISTSPACE_VALUES,array('id'=>$product->home_type));

                                $theImage=$getlistImage->row()->image;



                                if ($theImage !=''){ ?>

                                  <img src="<?php echo base_url(); ?>images/attribute/<?php echo $theImage; ?>" alt="g_img">

                                <?php }

                                 else {  ?>

                                    <img src="<?php echo base_url(); ?>images/attribute/default-list-img.png" alt="g_img">

                                <?php }

                                ?>



                                <?php echo ucfirst($listings_hometype) == 'list_value' ? 'Property Type Deleted' : ucfirst($listings_hometype); ?></li>

						<?php }

						if ($product->accommodates != '') { ?>

							<li><i class="fa fa-users"

								   aria-hidden="true"></i> <?php echo ucfirst($listingChild->row()->child_name); ?> <?php if ($this->lang->line('guest') != '') {

									echo stripslashes($this->lang->line('guest'));

								} else echo "Guests"; ?></li>

							<?php

							$finalsListing = json_decode($listings_values);

							foreach ($finalsListing as $listingResult => $FinalValues) {

								$resultArr[$listingResult] = $FinalValues;

								if (trim($FinalValues) != '') {

									$ind_val = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $FinalValues));

									$ind = $ind_val->row();

									if (!empty($ind)) {

										$valu = $ind->child_name;

									}

									if (strtolower($listingResult) == 'bedrooms') {

										?>

										<li><i class="fa fa-bed"

											   aria-hidden="true"></i> <?php echo stripslashes(ucfirst($valu)); ?> <?php if ($this->lang->line('bedrooms') != '') {

												echo stripslashes($this->lang->line('bedrooms'));

											} else echo "Bedrooms"; ?></li>

										<?php

									}

								}

							}

							?>

						<?php } ?>

					</ul>

				</div>

				

				<div class="divider"></div>

				<h4><?php if ($this->lang->line('The_Space') != '') {

						echo stripslashes($this->lang->line('The_Space'));

					} else echo "The Space"; ?> </h4>

				<div class="amenities">

					<ul class="row">

						<?php if ($product->bed_type != '') { ?>

							<li><label><?php if ($this->lang->line('bed_type') != '') {

										echo stripslashes($this->lang->line('bed_type'));

									} else echo "Bed type"; ?>

									:</label> <?php echo stripslashes(ucfirst($product->bed_type)); ?>

							</li>

						<?php }

						if ($product->home_type != '' && $getlistImage->row()->list_value != '') { ?>

							<li><label><?php  $prop_type_tiltle=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$prop_type_is);
 echo trim($prop_type_tiltle); ?>

									:</label> <?php 

 $list_value_tiltle_tit=language_dynamic_enable("list_value",$this->session->userdata('language_code'),$getlistImage->row());
 echo trim($list_value_tiltle_tit) == 'list_value' ? 'Property Type Deleted' : trim($list_value_tiltle_tit);
									// if($_SESSION['language_code'] == 'en'){ echo $getlistImage->row()->list_value; } else { echo $getlistImage->row()->list_value_ar; }

									?></li>

							<?php

						}

						//&& trim($room_type->row()->status) == 'Active'

						if ($product->room_type != '' && trim($room_type->row()->status) == 'Active') { ?>

							<li><label><?php $room_type_tiltle=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$room_type_is);
 echo trim($room_type_tiltle); ?>

									:</label> <?php 

 $list_value_tiltle=language_dynamic_enable("list_value",$this->session->userdata('language_code'),$room_type->row());
 echo trim($list_value_tiltle) == 'list_value' ? 'Room Type Deleted' : trim($list_value_tiltle);

									// if($_SESSION['language_code'] == 'en'){ echo trim($room_type->row()->list_value); }else { echo trim($room_type->row()->list_value_ar);} ?></li>

							<?php

						}

						if ($product->noofbathrooms != '') { ?>

							<li><label><?php if ($this->lang->line('no_of_bathrooms') != '') {

										echo stripslashes($this->lang->line('no_of_bathrooms'));

									} else echo "Number of bathrooms"; ?>

									:</label>  <?php if ($product->noofbathrooms != "") {

									echo $product->noofbathrooms;

								} else {

									echo "Nil";

								} ?></li>

							<?php

						}

						$finalsListing = json_decode($listings_values);

						foreach ($finalsListing as $listingResult => $FinalValues) {



							$resultArr[$listingResult] = $FinalValues;



							if (trim($FinalValues) != '') {

								$list_type = $this->product_model->get_all_details('fc_listing_types', array('id' => $listingResult));

								//echo $listingResult.'-'.$list_type->labelname ;

								//print_r($FinalValues);

								$list_type_value = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $FinalValues));

								?>

								<li><label><?php 
								 $labelname_title=language_dynamic_enable("labelname",$this->session->userdata('language_code'),$list_type->row());
							

							 echo ucfirst(str_replace("_", " ",$labelname_title));
								// if($_SESSION['language_code'] == 'en'){ 



								// 	echo ucfirst(str_replace("_", " ", $list_type->row()->labelname)); }

								// 	 else{

								// 	 echo ucfirst(str_replace("_", " ", $list_type->row()->labelname_ar)); }

									  ?>

										:</label>

									<?php

									if ($list_type_value->row()->child_name != "") {

										echo stripslashes(ucfirst($list_type_value->row()->child_name));

									} else {

										echo stripslashes(ucfirst($FinalValues));

									}

									?>

								</li>

								<?php

							}

						}

						?>

					</ul>

				</div>

				<?php

				$main = 0;

				if ($listItems->num_rows() > 0) {

					$sub_list = explode(',', $product->list_name);

					foreach ($listItems->result() as $list) {

						$list_name = $listDetail->row()->list_name;

						$facility = (explode(",", $list_name));

						$listValues = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => $list->id));

						if ($listValues->num_rows() > 0) {

							foreach ($listValues->result() as $details) {

								$key = $details->id;

								if (in_array($key, $sub_list)) {

									$arrayAvailable[] = $details;

								} else {

									$arrayNotAvailable[] = $details;

								}

							}

							$newAmenities = array_merge((array)$arrayAvailable, 							(array)$arrayNotAvailable);  //to avoid null arrays

							$ds = '';

							$show_more = false;

							$exist = 0;

							if (!empty($newAmenities)) {

								$mcount = 1;

								foreach ($newAmenities as $details) {

									$key = $details->id;

									if (in_array($key, $sub_list)) {

										if($_SESSION['language_code'] == 'en'){

										if ($mcount > 2 ) {

											$show_more = true;

											

											$ds .= '<li class="more"><i class="fa ' . $details->image . '" aria-hidden="true"></i> ' . $details->list_value . '</li>';

										} 

										else {

											$ds .= '<li><i class="fa ' . $details->image . '" aria-hidden="true"></i> ' . $details->list_value . '</li>';

										}

										$exist++;

									}

									else{

										if ($mcount > 2 ) {

											$show_more = true;

											

											$ds .= '<li class="more"><i class="fa ' . $details->image . '" aria-hidden="true"></i> ' . $details->list_value .$_SESSION['language_code'] .'</li>';

										} 

										else {

											$ds .= '<li><i class="fa ' . $details->image . '" aria-hidden="true"></i> ' . $details->list_value .$_SESSION['language_code']. '</li>';

										}

										$exist++;

									}

									}

									$mcount++;

								}

								$newAmenities = array();

								$arrayAvailable = array();

								$arrayNotAvailable = array();

								if ($exist > 0) {

									?>

									<div class="divider"></div>

									<h4><?php 
										 $attribute_name_title=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$list_type->row());
										  echo ucfirst($attribute_name_title);
									// if($_SESSION['language_code'] == 'en'){ echo ucfirst($list->attribute_name);} else{ echo ucfirst($list->attribute_name_ar); }

									 ?></h4>

									<div class="amenities">

										<ul class="row">

											<?php 

											echo $ds ;

											if ($show_more) {

												?>

												<a href="javascript:void(0)"

												   class="toggleMore"><?php if ($this->lang->line('more') != '') {

														echo stripslashes($this->lang->line('more'));

													} else echo "more"; ?></a>

												<?php

											}

											?>





										</ul>

									</div>

									<?php

								}

							}

						}

					}

				}

				?>

				<div class="divider"></div>

				<h4><?php if ($this->lang->line('prices') != '') {

						echo stripslashes($this->lang->line('prices'));

					} else echo "Prices"; ?></h4>

				<div class="amenities">

					<ul class="row">

						<?php if ($product->cancellation_policy != '') { ?>

							<li><?php if ($this->lang->line('Cancellation Policy') != '') {

									echo stripslashes($this->lang->line('Cancellation Policy'));

								} else echo "Cancellation Policy"; ?> : <a

									href="<?php echo base_url(); ?>pages/cancellation-policy"><?php echo ucfirst($product->cancellation_policy); ?></a>

							</li>

						<?php }

						if ($product->cancel_percentage != '') { ?>

							<li><?php if ($this->lang->line('Cancellation Percentage') != '') {

									echo stripslashes($this->lang->line('Cancellation Percentage'));

								} else echo "Cancellation Percentage"; ?> :

								<a href="<?php echo base_url(); ?>pages/cancellation-policy"><?php echo ucfirst(100-$product->cancel_percentage); ?>%</a>

								<?php if ($this->lang->line('of_subtotal_with') != '') {

									echo stripslashes($this->lang->line('of_subtotal_with'));

								} else echo "of Sub total With Security deposit"; ?>



                            </li>

						<?php }

						if ($product->security_deposit != '') { ?>

							<li><?php if ($this->lang->line('SecurityDeposit') != '') {

									echo stripslashes($this->lang->line('SecurityDeposit'));

								} else echo "Security Deposit"; ?> :

								<?php echo $currencySymbol;

								$currency = $product->currency;

								if ($product->currency != $this->session->userdata('currency_type')) {

									if ($currency_result->$currency) {

										$price = $product->security_deposit / $currency_result->$currency;

									} else {

										$price = currency_conversion($currency, $this->session->userdata('currency_type'), $product->security_deposit);

									}

									echo ' ' . number_format($price, 2);

								} else {

									echo ' ' . number_format($product->security_deposit, 2);

								}

								?><?php echo ' ' . $this->session->userdata('currency_type'); ?>

							</li>

						<?php } ?>

						<li></li>

					</ul>

				</div>

				<?php

				if ($product->space != "") {

					?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('the_space') != '') {

							echo stripslashes($this->lang->line('the_space'));

						} else echo "The Space"; ?></h4>

					<div>

						<p><?php 

						$space_val=language_dynamic_enable("space",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($space_val));

						//echo nl2br(stripslashes($product->space)); ?></p>

					</div>

					<?php

				}

				if ($product->other_thingnote != '') {

					?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('other_things_to_note') != '') {

							echo stripslashes($this->lang->line('other_things_to_note'));

						} else echo "Other things to note"; ?></h4>

					<div>

						<p><?php 
						$other_thingnote_val=language_dynamic_enable("other_thingnote",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($other_thingnote_val));

					//	echo nl2br(stripslashes($product->other_thingnote)); ?></p>

					</div>

				<?php }

				if ($product->house_rules != '') { ?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('house_rules') != '') {

							echo stripslashes($this->lang->line('house_rules'));

						} else echo "House Rules"; ?></h4>

					<div>

						<p><?php 
							$house_rules_val=language_dynamic_enable("house_rules",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($house_rules_val));

 //echo nl2br(stripslashes($product->house_rules)); ?></p>

					</div>

				<?php }

				if ($product->guest_access != "") { ?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('guest_access') != '') {

							echo stripslashes($this->lang->line('guest_access'));

						} else echo "Guest access"; ?></h4>



					<div>

						<p><?php 
						$guest_access_val=language_dynamic_enable("guest_access",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($guest_access_val));

						//echo nl2br(stripslashes($product->guest_access)); ?></p>

					</div>

				<?php }

				if ($product->interact_guest != "") { ?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('interaction_with_guest') != '') {

							echo stripslashes($this->lang->line('interaction_with_guest'));

						} else echo "Interaction with guest"; ?></h4>

					<div>

						<p><?php 

						$interact_guest_val=language_dynamic_enable("interact_guest",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($interact_guest_val));

					//	echo nl2br(stripslashes($product->interact_guest)); ?></p>

					</div>

				<?php }

				if ($product->neighbor_overview != "") { ?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('neighborhood') != '') {

							echo stripslashes($this->lang->line('neighborhood'));

						} else echo "Neighborhood"; ?></h4>

					<div>

						<p><?php 
							$neighbor_overview_val=language_dynamic_enable("neighbor_overview",$this->session->userdata('language_code'),$product);
 echo nl2br(stripslashes($neighbor_overview_val));


						//echo nl2br(stripslashes($product->neighbor_overview)); ?></p>

					</div>

				<?php }

				if ($this->lang->line('night') != '') {

					$Night = stripslashes($this->lang->line('night'));

				} else {

					$Night = "Night";

				}

				if ($this->lang->line('Nights') != '') {

					$Nights = stripslashes($this->lang->line('Nights'));

				} else {

					$Nights = "Nights";

				}

				if ($product->minimum_stay != 0) {

					$valu = '';

					if (trim($product->minimum_stay) != '') {

						$ind_val = $this->product_model->get_all_details(LISTING_CHILD, array('id' => $product->minimum_stay));

						$ind = $ind_val->row();

						if (!empty($ind)) {

							$valu = $ind->child_name;

						}

					}

					?>

					<div class="divider"></div>

					<h4><?php if ($this->lang->line('availability') != '') {

							echo stripslashes($this->lang->line('availability'));

						} else echo "Availability"; ?></h4>

					<div class="amenities">

						<ul class="row">

							<li><label><?php if ($this->lang->line('min_stay') != '') {

									echo stripslashes($this->lang->line('min_stay'));

								} else echo "Minimum Stay"; ?><span>:</span> </label> <?php echo $valu . " ";

								if ($product->minimum_stay == 1) {

									echo $Night;

								} else {

									echo $Nights;

								} ?></li>

						</ul>

					</div>
		
					<?php

				} ?></div>

				<div id="review-tab" class="tab-pane fade">
				  
				<?php if (count($reviewData->result_array()) == 0) { ?>

					<div class="divider"></div>

					<div class="clear" id="reviews">

						<div class="colLeft">

							<span class="number_s120">0</span> <?php if ($this->lang->line('reviews') != '') {

								echo stripslashes($this->lang->line('reviews'));

							} else echo "Reviews"; ?>

						</div>

						<div class="starRatingOuter2 colRight">

							<div class="starRatingInner2" style="width: 0%;"></div>

						</div>

					</div>

					<div>

						<p class="text-danger"><?php if ($this->lang->line('no_review_msg') != '') {

								echo stripslashes($this->lang->line('no_review_msg'));

							} else echo "No Reviews Yet"; ?></p>

						<small><?php if ($this->lang->line('review_msg_to_review') != '') {

								echo stripslashes($this->lang->line('review_msg_to_review'));

							} else echo "Stay here and you could give this host their first review! "; ?></small>

					</div>

				<?php } else {

					?>

					<div class="divider"></div>

					<div class="clear" id="reviews">

						<div class="colLeft">

							<span

								class="number_s120"><?php echo count($reviewData->result_array()); ?></span> <?php if ($this->lang->line('reviews') != '') {

								echo stripslashes($this->lang->line('reviews'));

							} else echo "Reviews"; ?>

						</div>

						<?php

                        $totl_product_reveiw=count($reviewData->result_array());

                        //echo round($reviewTotal->row()->tot_tot,0); ?>

						<div class="starRatingOuter2 colRight">

							<div class="starRatingInner2"

								 style="width: <?php echo $reviewTotal->row()->tot_tot * 20 ?>%;"></div>

						</div>

					</div>

					<div class="reviewList">

						<?php if ($reviewLists != '') {

						    //print_r($reviewLists->result_array());

							foreach ($reviewLists->result_array() as $review) { ?>

								<div class="reviewItems">

									<div class="top">

										<div class="left">

											<img

												src="<?php if ($review['image'] != '' && file_exists('./images/users/' . $review['image'])) {

													echo base_url() . 'images/users/' . $review['image'];

												} else {

													echo base_url() . '/images/users/profile.png';

												} ?>">

										</div>

										<div class="right">

											<div class="h7"><?php echo ucfirst($review['firstname']); ?></div>

											<p><?php echo date('jS F', strtotime($review['dateAdded'])); ?>

												<span

													class="number_s120"> <?php echo date('Y', strtotime($review['dateAdded'])); ?></span>

											</p>
                                            <p>
                                            <div class="starRatingOuter2">
                                            <div class="starRatingInner2" style="width: <?php echo ($review['total_review'] * 20); ?>%;"></div>
                                            </div>
                                            </p>

										</div>

									</div>

									<p><?php echo ucfirst($review['review']); ?> </p>

								</div>

							<?php }

						}

						if($totl_product_reveiw>5){
						    ?>
                            <button class="submitBtn" data-toggle="modal" data-target="#all_reviews" style="width:auto;">

                               <?php if ($this->lang->line('more') != '') {

                                    echo stripslashes($this->lang->line('more'));

                                } else echo "More"; ?>
                                <?php if ($this->lang->line('reviews') != '') {

                                    echo stripslashes($this->lang->line('reviews'));

                                } else echo "Reviews"; ?>

                            </button>
                        <?php
                        }
						?>

					</div>

					<?php

				} ?>
                <div class="divider"></div> </div>

				<div id="host-tab" class="tab-pane fade">				    
				  
				<div class="hostDetail">

					<div class="row">

						<div class="col-sm-8 left">

							<h3 id="host"><?php if ($this->lang->line('hosted_by') != '') {

									echo stripslashes($this->lang->line('hosted_by'));

								} else echo "Hosted by  ";

								if ($product->user_id > 0 && $product->user_id != '') {

									echo ' '.ucfirst($product->firstname);

								} else {

									echo 'Administrator';

								} ?> </h3>

							<p><?php

								if ($product->user_id > 0 && $product->user_id != '') {

									echo ($product->s_city != "") ? ucfirst($product->s_city) . ', ' : '';

									echo ($product->s_district != "") ? ucfirst($product->s_district) . ', ' : '';

									echo ($product->s_state != "") ? ucfirst($product->s_state) . '. ' : '';

									if ($this->lang->line('joined_in') != '') {

										echo stripslashes($this->lang->line('joined_in'));

									} else echo "Joined in ";

									echo ' '. date('F Y', strtotime($product->user_created));

								}

								?></p>

							<?php

							if ($product->user_id > 0 && $product->user_id != '') {

								?>

								<div class="clear">

									<div class="starRatingOuter1">
                                            <div class="starRatingInner1" style="width: <?php 
                                            $tot_rev = $host_review_rental->row()->total_review+$host_review_exprience->row()->total_review;
                                            echo ($tot_rev * 20); ?>%;"></div>
                                        </div>
									<a class="reRef">

										<span><?php echo $host_review_rental->num_rows() + $host_review_exprience->num_rows(); ?></span> <?php if ($this->lang->line('Reviews') != '') {

											echo stripslashes($this->lang->line('Reviews'));

										} else echo "Reviews"; ?>

									</a>

								</div>

								<?php

							}

							if ($product->user_id > 0 && $product->user_id != '') {

								if ($proof_verify->num_rows() > 0) {

									if ($proof_verify->row()->id_proof_status == 'Verified') { ?>

										<div class="verified">

											<img

												src="<?php echo base_url(); ?>images/verifiedIcon.png"> <?php if ($this->lang->line('verified_proof') != '') {

												echo stripslashes($this->lang->line('verified_proof'));

											} else echo "Verified Proof"; ?>

										</div>

									<?php } else {

										?>

										<div class="verified">

											<img

												src="<?php echo base_url(); ?>images/unverified150x50.png"> <?php if ($this->lang->line('unVerified_proof') != '') {

												echo stripslashes($this->lang->line('unVerified_proof'));

											} else echo "UnVerified Proof"; ?>

										</div>

										<?php

									}

								}

							} ?>
							<a data-toggle="modal" href="#message" class="contactHost"><?php if ($this->lang->line('contact_host') != '') {
						echo stripslashes($this->lang->line('contact_host'));
					} else {
						echo "Contact Host";
					} ?></a>
					 <div id="message" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h2 class="mHead"><?php if ($this->lang->line('Message to Host') != '') {
                                                echo stripslashes($this->lang->line('Message to Host'));
                                            } else echo "Message to Host"; ?></h2>
                                    </div>
                                    <div class="modal-body">
                                        <?php if ($this->lang->line('send_message_to_host') != '') {
                                            $sendMsg= stripslashes($this->lang->line('send_message_to_host'));
                                        } else $sendMsg= "Send Message to Host"; ?>

                                        <div>
                                            <?php
                                            echo form_open('site/product/add_discussion', array('id' => 'add_discussion'));
                                            echo form_input(array('name' => 'rental_id', 'id' => 'rental_id', 'type' => 'hidden','value'=>$productDetails->row()->id));
                                            echo form_input(array('name' => 'sender_id', 'id' => 'sender_id', 'type' => 'hidden','value'=>$loginCheck));
                                            echo form_input(array('name' => 'receiver_id', 'id' => 'receiver_id', 'type' => 'hidden','value'=>$product->user_id));
                                            echo form_input(array('name' => 'bookingno', 'id' => 'booking_id', 'type' => 'hidden'));
                                            echo form_input(array('name' => 'posted_by', 'value' => 'posted_by', 'type' => 'hidden','value'=>$loginCheck));
                                            echo form_input(array('name' => 'redirect', 'value' => $this->uri->segment(1) . '/' . $this->uri->segment(2), 'type' => 'hidden'));
                                            echo form_textarea(array('name' => 'message', 'placeholder' => "$sendMsg", 'id' => 'message-text', 'rows' => '7'));
                                            echo form_submit('', ($this->lang->line('Send') != '') ? stripslashes($this->lang->line('Send')) : 'Send', array('class' => 'btn btn-default'));
                                            echo form_close();
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

						</div>

						<div class="col-sm-4 right">

							<div class="hostImg">

								<?php

								$image = 'profile.png';

								if ($product->thumbnail != '' && file_exists('./images/users/' . $product->thumbnail)) {

									$image = $product->thumbnail;

								}

								?>

								<img src="<?php echo base_url(); ?>images/users/<?php echo $image; ?>">

							</div>

						</div>

					</div>



					<p><?php echo ucfirst($product->description1); ?></p>

					<ul class="langUL">

						<li><?php if ($this->lang->line('languages') != '') {

												echo stripslashes($this->lang->line('languages'));

											} else echo "Languages"; ?> : <span class="weight_500"><?php if ($known_langs->num_rows() > 0) {

									$i = 1;

									foreach ($known_langs->result() as $langs) {

										echo $langs->language_name;

										echo ($i == $known_langs->num_rows()) ? '.' : ',';

										$i++;

									}

								} else { ?><?php if ($this->lang->line('not_listed') != '') {

												echo stripslashes($this->lang->line('not_listed'));

											} else echo "Not Listed"; ?><?php } ?></span></li>



						<!--<li>Response rate: <span class="weight_500"><?php //echo $product->response_rate; ?>%</span>

						</li>-->





					</ul>

				</div> 
			</div>
		</div>
	</div>



	<div class="collapse-map">
		<a data-toggle="collapse" href="#location-map"><h3 id="location"><?php if ($this->lang->line('list_Location') != '') { echo stripslashes($this->lang->line('list_Location')); } else echo "Map"; ?></h3></a>

		<div class="collapse in" id="location-map"><div class="mapSection" id="map" style="height: 200px;"></div></div>
	</div>



</div>

			<div class="toggleBooking">

				<div class="price_B">

					<h5 class="price"><span

							class="number_s150"><?php

							echo $this->session->userdata('currency_s');

							if ($product->currency != $this->session->userdata('currency_type')) {

								$list_currency = $product->currency;

								if ($currency_result->$list_currency) {

									$price = $product->price / $currency_result->$list_currency;



								} else {



									$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $product->price);



								}

								echo number_format($price, 2);

							} else {

																$price = $product->price;

								echo number_format($price, 2);

							}

							$globalPrice = $price;

							?></span> <?php if ($this->lang->line('per_night') != '') {

							echo stripslashes($this->lang->line('per_night'));

						} else echo "per night"; ?></h5>





					<div class="clear">

						<div class="starRatingOuter">

							<div class="starRatingInner"

								 style="width: <?php echo (count($reviewData->result_array()) > 0) ? $reviewTotal->row()->tot_tot * 20 : 0; ?>%;"></div>

						</div>

						<span

							class="reviewCount"><?php echo count($reviewData->result_array()) . " "; ?><?php if ($this->lang->line('reviews') != '') {

								echo stripslashes($this->lang->line('reviews'));

							} else echo "Reviews"; ?></span>

					</div>

				</div>

				<div class="request_B">

					<button type="button" class="submitBtn tRB"><?php if ($this->lang->line('book_now') != '') {

								echo stripslashes($this->lang->line('book_now'));

							} else echo "Book Now"; ?></button>

				</div>







			</div>

			<div class="detailRight toggleRequestBook">
				<!-- <h3 class="booking-title">Book Property</h3> -->

				<div class="bookingBlock">

					<button type="button" class="tRB close">&times;</button>

						 <h5 class="price"><span class="number_s150">

						<?php

						echo $this->session->userdata('currency_s');



						if ($product->currency != $this->session->userdata('currency_type')) {

							$list_currency = $product->currency;

							//echo 'list currency'.$list_currency.'<br>';

							if ($currency_result->$list_currency) {

								//$price = $product->price / $currency_result->$list_currency;

								//echo number_format($price, 2);

								echo changeCurrency($list_currency,$this->session->userdata('currency_type'),$product->price);

							} else {

								echo changeCurrency($list_currency,$this->session->userdata('currency_type'),$product->price);

								//$priceCon = currency_conversion($list_currency, $this->session->userdata('currency_type'), $product->price);

								//echo $priceCon; //already formatted

							}

						} else {

							$priceEx = $product->price;

							echo number_format($priceEx, 2);

						}

						?></span> <?php if ($this->lang->line('per_night') != '') {

						echo stripslashes($this->lang->line('per_night'));

						} else echo "per night"; ?></h5>

					<!-- <div class="clear">

						<div class="starRatingOuter">

							<div class="starRatingInner"

								 style="width: <?php echo (count($reviewData->result_array()) > 0) ? $reviewTotal->row()->tot_tot * 20 : 0; ?>%;"></div>

						</div>

						<a href="#reviews"><span

							class="reviewCount"><?php echo count($reviewData->result_array()) . " "; ?><?php if ($this->lang->line('reviews') != '') {

								echo stripslashes($this->lang->line('reviews'));

							} else echo "Reviews"; ?></span></a>

					</div> -->

					<div class="divider"></div> 



					<ul class="coupon-detail">

						<?php $productAr = explode(',', $couponData->row()->product_id);
                        $coupon_date_to = "";
						if($couponData->num_rows()>0) {

							?>

							<?php

							$count=0;

							$coupon_result='';

							foreach ($couponData->result() as $coupon) {

								$productAr = explode(',', $coupon->product_id);

								if(in_array($product_id, $productAr)){

									$type = $coupon->price_type !=1 ?'%':'flat';

									$count++;
                                    $coupon_date_to = $coupon->dateto;
									$qty=$coupon->quantity;

									$purchaseCount=$coupon->purchase_count;

									$remining=$qty-$purchaseCount;

								?>

			                	<?php

                                   if($this->lang->line('code') !=''){ $code = stripslashes($this->lang->line('code'));} else { $code = "Code"; }

                                   if($this->lang->line('time_limit') !=''){ $time_limt = stripslashes($this->lang->line('time_limit'));} else { $time_limt = "Time Limit"; }

								if ($coupon->price_type==1){

									$couponPrice= convertCurrency("USD",$this->session->userdata('currency_type'),$coupon->price_value);

								}else{

									$couponPrice=$coupon->price_value;

								}



				                	$coupon_result .='<div class="coupon-info"> <label>'. $code.' : </label><span>' .$coupon->code.' ('.$couponPrice.' '.$type.')'.'</span></div><div class="coupon-info"><label>'.$time_limt.' : </label> <span>'. $coupon->datefrom .' to '.$coupon->dateto.'</span></div>';

								?>



	                	<?php 		}

	                	 		}



                                 if($this->lang->line('Available coupon') != '')

                                 {

                                 	$avai=stripslashes($this->lang->line('Available coupon'));

                                 }else $avai="Available coupon";

								if($remining>0){ //preetha - to display only if count of coupon is exist

									if($count!=0)

										echo '<h4> ' .$avai.'</h4><div class="coupon-result">'.$coupon_result.'</div>';
										echo '<div id="timer" class="timer_class">
  <div id="days" class="timer_class"></div>
  <div id="hours" class="timer_class"></div>
  <div id="minutes" class="timer_class"></div>
  <div id="seconds" class="timer_class"></div>
</div>';

								}

	                		



	                		?>
							
<?php } ?>

	                	</ul>





					<h4 class="text-center text-danger" id="BookingError"></h4>

					<div class="clear chkInOut">

						<div class="colLeft">

							<p><?php if ($this->lang->line('check_in') != '') {

									echo stripslashes($this->lang->line('check_in'));

								} else echo "check in"; ?></p>

							<?php

							echo form_input('checkIn', $this->session->userdata('checkIn'), array('autocomplete' => 'off','placeholder' => 'dd-mm-yyyy', 'id' => 'checkIn',"readonly"=>"readonly"));

							?>

						</div>

						<div class="colLeft">

							<p><?php if ($this->lang->line('check_out') != '') {

									echo stripslashes($this->lang->line('check_out'));

								} else echo "check out"; ?></p>

							<?php

							echo form_input('checkOut', $this->session->userdata('checkOut'), array('autocomplete' => 'off','placeholder' => 'dd-mm-yyyy', 'id' => 'checkOut',"readonly"=>"readonly"));

							?>

						</div>

					</div>

					<div>

						<p><?php if ($this->lang->line('guest_s') != '') {

									echo stripslashes($this->lang->line('guest_s'));

								} else echo "Guest"; ?></p>



						<div class="selectGuest">

							<button class="showResult" type="button">

								<input type="text" readonly class="number_s120 guestCount"

									   value="1" id="number_of_guests"> <?php if ($this->lang->line('Guest') != '') {

									echo stripslashes($this->lang->line('Guest'));

								} else echo "Guest"; ?>

								<span class="arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>

							</button>

							<div class="guestInfo">

								<div class="rowB clear">

									<div class="leftBlock">

										<h5><?php if ($this->lang->line('Guest') != '') {

												echo stripslashes($this->lang->line('Guest'));

											} else echo "Guest"; ?></h5>

									</div>

                                    <?php

                                    if ($product->accommodates!=''){

                                        $get_num_ofGuest=$this->product_model->get_selected_fields_records('child_name',LISTING_CHILD," Where id =".$product->accommodates);

                                        $NumGuest=$get_num_ofGuest->row()->child_name;

                                    }else{

                                        $NumGuest=1;

                                    }

                                    ?>

									<div class="rightBlock">

										<div class="countBlock">

												<span class="dec" style="display: none;"

													  onclick="affectGuestCount('decrease', this);chckNumGuestDec();"> - </span>

											<input type="text" name="" readonly="" value="1" class="guestVal">

											<span class="inc" onclick="affectGuestCount('increase'); chckNumGuestInc();" style="<?php if ($NumGuest==1) { echo "display:none"; } else { echo "display:block"; }?>" > + </span>

										</div>

									</div>

								</div>

								<p><?php echo $NumGuest; ?> <?php if ($this->lang->line('guest_maximum_infant') != '') {

												echo stripslashes($this->lang->line('guest_maximum_infant'));

											} else echo "guests maximum. Infants don’t count toward the number of guests"; ?> .</p>





							</div>

						</div>

						<div class="feeList" id="FeesList">

						</div>

						<?php

						if ($productDetails->row()->id_verified == "Yes") {

							if($host_status == 'Active')
							{
								if($pay_option->row()->request_to_book == 'Yes'){
							if ($this->lang->line('book_now') != '') {

								$bookNovBtn = stripslashes($this->lang->line('book_now'));

							} else {

								$bookNovBtn = "Request to Book";

							}

							if ($this->session->userdata('fc_session_user_id')) {

								echo form_button('bookNow', $bookNovBtn, array("id" => "req_book_btn","class" => "submitBtn", "onclick" => "validate_booking_form('book_now')"));

							} else {

								//echo form_button('bookNow', $bookNovBtn, array('class' => 'submitBtn','onclick'=>'set_signup_and_login_links_req();'));
								?>
								<button class="submitBtn" onclick="set_signup_and_login_links_req();"><i id="spin_req" style="display: none;" class="fa fa-spinner fa-spin"></i><i

										class="fa fa-heart-o"></i> <?php echo $bookNovBtn ?></button>
								<?php

							}
						}

						}
						else{
							?>
							<p class="text-center text-danger"><?php if ($this->lang->line('host_is_not_avail') != '') {

												echo stripslashes($this->lang->line('host_is_not_avail'));

											} else echo "Host is not Available"; ?> ..!</p><?php

						}

						} else {

							?>

							<p class="text-center text-danger"><?php if ($this->lang->line('host_is_not_verified') != '') {

												echo stripslashes($this->lang->line('host_is_not_verified'));

											} else echo "Host is not verified Yet"; ?> ..!</p>

							<?php

						}

						?>

					</div>



					<?php

					if ($productDetails->row()->id_verified != "No") {

if($host_status != 'Inactive')
							{
						if ($pay_option->row()->instant_pay == 'Yes' && $instant_pay->row()->status == '1') {

							if (!$this->session->userdata('fc_session_user_id')) {

								?>

								<div class="divider"></div>

								<button class="submitBtn" onclick="set_signup_and_login_links_instant();"><i id="spin_in" style="display: none;" class="fa fa-spinner fa-spin"></i><i

										class="fa fa-heart-o"></i> <?php if ($this->lang->line('instant_pay') != '') {

										echo stripslashes($this->lang->line('instant_pay'));

									} else echo "Instant Pay"; ?></button>

								<?php

							} else {

								?>

								<div class="divider"></div>

								<?php

								if ($this->lang->line('instant_pay') != '') {

									$bookNovBtn = stripslashes($this->lang->line('instant_pay'));

								} else {

									$bookNovBtn = "Instant pay";

								}

								echo form_button('bookNow', $bookNovBtn, array('id' => 'instant_pay_button',"class" => "submitBtn", "onclick" => "validate_booking_form('instant_pay')"));

							}

						}
						}
						

					}

					?>

					<!-- <div class="divider"></div>

					<div class="expRow">

						<div class="left">

							<?php

							$description = $product->experience_description;

							$url = base_url().$this->uri->uri_string();

							$url = urlencode($url);

							$facebook_share = 'http://www.facebook.com/sharer.php?u=' . $url;
							$twitter_share = 'https://twitter.com/share?url=' . $url;
							$google_share = 'https://plus.google.com/share?url=' . $url;

							?>

							<i class="fa fa-facebook" aria-hidden="true" style="cursor: pointer;"

							   onclick="window.location.href='<?= $facebook_share; ?>'"></i>

							<i class="fa fa-twitter" aria-hidden="true" style="cursor: pointer;"

							   onclick="window.location.href='<?= $twitter_share; ?>'"></i>

							<i class="fa fa-google-plus" aria-hidden="true" style="cursor: pointer;"
							   onclick="window.location.href='<?= $google_share; ?>'"></i>

						</div>

						<div class="right">

							<?php if ($loginCheck == '') { ?>

								<a data-toggle="modal" data-target="#signIn"

								   class="wishList" href="#"><?php if ($this->lang->line('header_add_list') != '') {

										echo stripslashes($this->lang->line('header_add_list'));

									} else echo "Save to Wish List"; ?><i class="fa fa-heart-o"

																		  aria-hidden="true"></i></a>

								<?php

							} else {

								if (!in_array($product->id, $newArr)) {

									?>

									<a onclick="loadWishlistPopup('<?php echo $product->id; ?>');"

									   class="wishList" href="#"><i class="fa fa-heart-o"

																			  aria-hidden="true"></i> <?php if ($this->lang->line('header_add_list') != '') {

											echo stripslashes($this->lang->line('header_add_list'));

										} else echo "Save to Wish List"; ?></a>

									<?php

								}else{ ?>
									<a class="wishList" style="text-decoration: none;"><i class="fa fa-heart" aria-hidden="true"></i> <?php if ($this->lang->line('header_added_list') != '') {
											echo stripslashes($this->lang->line('header_added_list'));
										} else {echo "Saved to Wish List";} ?></a>
									<?php
								}

							} ?>

						</div>

					</div>

				<?php if ($product->likes > 0) { ?>

						<p><?php if ($this->lang->line('people_are') != '') { echo stripslashes($this->lang->line('people_are')); } else echo "People are eyeing this"; ?>  <?php if ($this->lang->line('listing_over') != '') { echo stripslashes($this->lang->line('listing_over')); } else echo "Listing. Over"; ?> <?php echo $product->likes; ?> <?php if ($this->lang->line('viewed_it') != '') { echo stripslashes($this->lang->line('viewed_it')); } else echo "people have viewed it"; ?>.</p>

				<?php } ?> -->

				</div>

			</div>

		</div>







		<div class="centeredBtm">
			

			<?php if ($DistanceQryArr->num_rows() > 0) { ?>

				<div class="similarHead">

					<h3><?php if ($this->lang->line('similar_listings') != '') {

							echo stripslashes($this->lang->line('similar_listings'));

						} else echo "Similar Listings"; ?></h3>

				</div>

				<div class="owl-carousel owl-theme experience-carousel bottomSpace">

					<?php foreach ($DistanceQryArr->result() as $similar_Rentals) {

						?>

						<div class="item">
							 <div class="card-section">
                                <div class="owl-carousel show">
                                	<div class="item" >
							<?php if ($this->session->userdata('fc_session_user_id')) {

								if (in_array($similar_Rentals->id, $newArr)) { ?>

									<div class="wishList_I yes"></div>

								<?php } else {

									?>

									<div class="wishList_I"

										 onclick="loadWishlistPopup('<?php echo $similar_Rentals->id; ?>');"></div>

									<?php

								}

							} else { ?>

								<a data-toggle="modal" data-target="#signIn" class="wishList_I"></a>

							<?php } ?>

							<a href="<?php echo base_url(); ?>rental/<?php echo $similar_Rentals->seourl; ?>">

								<?php if (($similar_Rentals->PImg != '') && (file_exists('./images/rental/' . $similar_Rentals->PImg))) {

									?>

									<div class="myPlace"

										 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $similar_Rentals->PImg; ?>')"></div>

								<?php } else { ?>

									<div class="myPlace"

										 style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div>

								<?php } ?>
							</a>
							</div>
						</div>

								<div class="bottom">

									<div class="loc">hh<?php 

									if($this->session->userdata('language_code') =='en')

                                    {

                                        $prod_tit = $similar_Rentals->city_name;

                                    }

                                    else

                                    {

                                    	if($similar_Rentals->city_name == $product->product_title){

                                        $prodAr='product_title_'.$this->session->userdata('language_code');

                                        if($similar_Rentals->$prodAr == '') { 

                                            $prod_tit=$similar_Rentals->city_name;

                                        }

                                        else{

                                            $prod_tit=$similar_Rentals->name_ar;

                                        }

                                    }

                                    } 

                                    echo ucfirst($prod_tit);

									//echo ucfirst($similar_Rentals->city_name); ?></div>

									<h5><?php 

									if($this->session->userdata('language_code') =='en')

                                    {

                                        $prod_tit = $similar_Rentals->product_title;

                                    }

                                    else

                                    {

                                        $prodAr='product_title_'.$this->session->userdata('language_code');

                                        if($similar_Rentals->$prodAr == '') { 

                                            $prod_tit=$similar_Rentals->product_title;

                                        }

                                        else{

                                            $prod_tit=$similar_Rentals->product_title_ar;

                                        }

                                    }

	             	                echo ucfirst($prod_tit); 

									//echo ucfirst($similar_Rentals->product_title); ?></h5>

									<div class="price">

                                            <span class="number_s">

                                                <?php 

												echo $this->session->userdata('currency_s');

												if ($similar_Rentals->currency != $this->session->userdata('currency_type')) {

													$list_currency = $similar_Rentals->currency;

													if ($currency_result->$list_currency) {

														$price = $similar_Rentals->price / $currency_result->$list_currency;

													} else {

														$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $similar_Rentals->price);

													}

													echo number_format($price, 2);

												} else {

													$priceEx = $similar_Rentals->price;

													echo number_format($priceEx, 2);

												}

												?>

                                            </span>

									</div>

									<div class="bottom-text">
                                                <p>
												  dsds
                                                </p>
                                    </div>
                                    <div class="bottom-icons">
                                        <span class="guest-limit">3</span>
                                    </div>

									<div class="clear">

										<?php

										$avg_val = round($similar_Rentals->rate);

										$num_reviewers = $similar_Rentals->num_reviewers;

										?>

										<div class="starRatingOuter">

											<div class="starRatingInner"

												 style="width: <?php echo($avg_val * 20); ?>%;"></div>

										</div>

										<span

											class="ratingCount"><?php echo $num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {

												echo stripslashes($this->lang->line('Reviews'));

											} else echo "Reviews"; ?></span>

									</div>

								</div>

							</div></div>

						<?php

					} ?>

				</div>

			<?php } ?>

		</div>

	</div>

</section>

<section>

    <div id="all_reviews" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h2>
                    <?php if ($this->lang->line('Reviews') != '') {
                    echo stripslashes($this->lang->line('Reviews'));
                    } else echo "Reviews"; ?>
                </h2>
                <div class="reviewList">

                    <?php if ($reviewListsMore != '') {

                        foreach ($reviewListsMore->result_array() as $review) { ?>

                            <div class="reviewItems">

                                <div class="top">
                                    <div class="left">
                                        <img src="<?php if ($review['image'] != '' && file_exists('./images/users/' . $review['image'])) {
                                                    echo base_url() . 'images/users/' . $review['image'];
                                                } else {
                                                    echo base_url() . '/images/users/profile.png';
                                                } ?>">
                                    </div>

                                    <div class="right">

                                        <div class="h7"><?php echo ucfirst($review['firstname']); ?></div>

                                        <p><?php echo date('jS F', strtotime($review['dateAdded'])); ?>

                                            <span class="number_s120"> <?php echo date('Y', strtotime($review['dateAdded'])); ?></span>
                                        </p>
                                        <p>
                                        <div class="starRatingOuter2">
                                            <div class="starRatingInner2" style="width: <?php echo ($review['total_review'] * 20); ?>%;"></div>
                                        </div>
                                        </p>
                                    </div>
                                </div>

                                <p><?php echo ucfirst($review['review']); ?> </p>

                            </div>

                        <?php }

                    }

                    ?>

                </div>


                </div>
            </div>
        </div>
    </div>


	<input type="hidden" value="<?php echo $product->price; ?>" id="price"/>

	<input type="hidden" value="<?php echo $product->price; ?>" id="Global_Price"/>

	<input type="hidden" value="<?php echo $product->user_id; ?>" id="ownerid"/>

	<input type="hidden" id="login_userid" name="login_userid" value="<?php echo $loginCheck; ?>"/>

	<input type="hidden" value="793959" name="hosting_id" id="hosting_id">

	<input type="hidden" name="renter_id" id="renter_id" value="<?php echo $product->user_id; ?>"/>

	<input type="hidden" name="prd_id" id="prd_id" value="<?php echo $product->id; ?>"/>

	<input type="hidden" name="cancel_percentage" id="cancel_percentage"

		   value="<?php echo $product->cancel_percentage; ?>"/>

	<input type="hidden" value="" id="results"/>

	<input type="hidden" value="" id="resultsContact"/>

	<input type="hidden" value="<?php echo $this->session->userdata('currency_type'); ?>" name="user_currencyCode"

		   id="user_currencyCode">

	<input type="hidden" value="<?php echo $product->accommodates; ?>" id="RentalGuest"/>

</section>
<!-- <script>
	  $(window).scroll(function() {

    if ($(this).scrollTop()>10)
     {
        $('.daterangepicker ').hide();
        document.activeElement.blur();
   
        // $('.chkInOut .colLeft input:focus').css('outline','0'); 

        // $('.chkInOut .colLeft input').css('caret-color','transparent');
        
     }
    else
     {
      $('.daterangepicker ').show();
      $('.chkInOut .colLeft input:focus').css('outline','-webkit-focus-ring-color auto 5px');
      // $('.chkInOut .colLeft input').css('caret-color','#444','opacity','.7');
     }
 });
</script> -->
<!-- <script>
	$(document).ready(function() { $('body').on('scroll', function() { 
	$('.chkInOut .colLeft input:focus').blur(); 
    }); 
});
	$('.chkInOut .colLeft input').result(function(){
    $(this).next('input').focus();
})
</script> -->
<!-- <script>
	 $(window).scroll(function() {

    if ($(this).scrollTop()>0)
     {
     	$('.chkInOut .colLeft input').focusout();
     	$('.chkInOut .colLeft input:focus').focusin();
     }
     else{
     	

     }
 });
</script> -->


<!-- <script>

$(document).ready(function(){
    $(".chkInOut .colLeft input").click(function(){
  	$('.chkInOut .colLeft input').css('caret-color','#444','opacity','.5').show();

  });
});
</script>
 -->


  


<!-- <script >
	$(window).scroll(function(){
    if($(this).scrollTop()>0 && !$("input,textarea").is(":focus")){
        $('.daterangepicker').fadeIn()
    }else{
        $('.daterangepicker').fadeOut()
    }
});
</script> -->
<!-- <script>
	$(window).scroll(function(){
    if($(this).scrollTop()>0){
        $('.daterangepicker').fadeIn()
    }else{
        $('.daterangepicker').fadeOut()
    }
});
$('form').delegate(':input', 'focus', function() {
    $('.daterangepicker').hide();
})
.delegate(':input', 'blur', function() {
    $('.daterangepicker').show();
});
</script> -->

<script>

	$(document).ready(function () {

		$('.experience-carousel').owlCarousel({

			loop: true,

			margin: 10,

			responsiveClass: true,

			responsive: {

				0: {

					items: 1,

					nav: true

				},

				480: {

					items: 2,

					nav: false

				},

				800: {

					items: 3,

					nav: false

				},

				1200: {

					items: 3,

					nav: true,

					loop: false,

					margin: 16

				}

			}

		});

		$(".wishList_I, .wishList_I.yes").show();

		updateConfig();

		$(document).ready(function(){


  		
  		var checkIn = '<?php echo $this->session->userdata('checkIn');?>';

  		

  		if(checkIn != ''){
  			getQuote();
  		  		}
  		//   		else if(book_type == 'hr'){
  		//   			DateBetween();
  		//   			    $("#hours").trigger("click");
  		//   		}
});

		var BookedDates = [<?= $booked_Dates; ?>];


		var date = new Date();
		var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		var tomorow = new Date(date.getFullYear(), date.getMonth(), (date.getDate()+1));
		function updateConfig() {

			var check_date_is = $('#checkIn').val();
			var checkout_date_is = $('#checkOut').val();
			var options = {
				format: 'DD-MM-YYYY',
				singleDatePicker: true,
				autoUpdateInput: false,
				startDate: ((check_date_is!=null && check_date_is!='') ? check_date_is : today),
                locale: {
				format: 'DD-MM-YYYY'
				},
				minDate: new Date(),
				isInvalidDate: function (date) {
					var formatted = date.format('MM/DD/YYYY');
					return BookedDates.indexOf(formatted) > -1;

				}
			};

			var options2 = {
                format: 'DD-MM-YYYY',
                singleDatePicker: true,
                autoUpdateInput: false,
                minDate: new Date(),
                startDate: ((checkout_date_is!=null && checkout_date_is!='') ? checkout_date_is : today),
				locale: {
				format: 'DD-MM-YYYY'
				},
				isInvalidDate: function (date) {
                    var formatted = date.format('MM/DD/YYYY');
					return BookedDates.indexOf(formatted) > -1;
				}
			};

			chkInDate = '';
			chkInDate1 = '';

			$('#checkIn').daterangepicker(options, function (start, end, label) {
				$('#checkIn').val(start.format('DD-MM-YYYY'));
				$('#checkOut').val('');
				chkInDate = start.format('MM-DD-YYYY');
				$('#FeesList').html('');
				//getQuote();
			});

			$('#checkOut').daterangepicker(options2, function (start, end, label) {
				$('#checkOut').val(start.format('DD-MM-YYYY'));
			});
/*
			$('#checkIn').on('apply.daterangepicker', function (ev, picker) {
				chkoutFunction();
                $('#checkOut').val('');
				$('#FeesList').html('');
				$('#checkOut').val(picker.startDate.format('DD-MM-YYYY'));
				$('#checkOut').trigger('click');
				getQuote();

			});
			 Berr=0;
			$('#checkOut').on('apply.daterangepicker', function (ev, picker) {
				$(this).val(picker.startDate.format('DD-MM-YYYY'));
				getQuote();

			});*/


			///////////////////////////

            $('#checkIn').daterangepicker(options, function (start, end, label) {
                $('#checkIn').val(start.format('DD-MM-YYYY'));
                $('#checkOut').val('');
                chkInDate = start.format('MM-DD-YYYY');
                //getQuote();
                $('#FeesList').html('');
            });
            $('#checkIn').on('apply.daterangepicker', function (ev, picker) {

                $('#checkOut').val('');
                chkoutFunction();
                $('#FeesList').html('');
                $('#checkOut').val(picker.startDate.format('DD-MM-YYYY'));
                $('#checkOut').trigger('click');
                getQuote();

            });
            Berr=0;
            $('#checkOut').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
                //getQuote();
                //check_unavail_booked_dates();
                valid_dates=check_unavail_booked_dates();
                if(parseInt(valid_dates)==0){
                    getQuote();
                }
            });
			///////////////////////////

			 function fixDigit(val){
            return val.toString().length === 1 ? "0" + val : val;
        }
        function check_unavail_booked_dates(){
            Berr=0;
            p_date=$('#checkIn').val();
            d_date=$('#checkOut').val();
            var BerrCount=0;
            if(p_date!='' && d_date!='') {
                p_date_arr = p_date.split('-');
                p_date_new = p_date_arr[2] + '-' + p_date_arr[1] + '-' + p_date_arr[0];
                d_date_arr = d_date.split('-');
                d_date_new = d_date_arr[2] + '-' + d_date_arr[1] + '-' + d_date_arr[0];
                //alert(p_date_new + '||' + d_date_new)

                var BookedDates_check = [<?= $booked_Dates; ?>];
                var startDate = new Date(p_date_new); //YYYY-MM-DD
                var endDate = new Date(d_date_new); //YYYY-MM-DD

                var getDateArray = function (start, end) {
                    var arr = new Array();
                    var dt = new Date(start);
                    while (dt <= end) {
                        tt = new Date(dt)
                        ttd = fixDigit(tt.getMonth() + 1) + '/' + fixDigit(tt.getDate()) + '/' + tt.getFullYear();
                        arr.push(ttd);
                        if($.isArray(BookedDates_check)==true){
                            //alert('is_array');
                            if($.inArray( ttd, BookedDates_check ) > - 1){
                                Berr++;
                            }
                        }
                        dt.setDate(dt.getDate() + 1);
                    }
                    return Berr;
                }
                var BerrCount = getDateArray(startDate, endDate);
            }
            if(parseInt(BerrCount)>0){
                $('#FeesList').html('');
                $('#instant_pay_button').prop('disabled', true);
                 $('#req_book_btn').prop('disabled', true);
                $('#BookingError').html('<?php if ($this->lang->line('some_of_dates') != '') { echo stripslashes($this->lang->line('some_of_dates')); } else echo "Some of the selected Dates are Unavailable"; ?>');
            }else{
                $('#BookingError').html('');
                $('#instant_pay_button').prop('disabled', false);
                 $('#req_book_btn').prop('disabled', false);
            }
            //alert('date exists count=='+BerrCount);
            return BerrCount;
        }


			function chkoutFunction() {

				$('#checkOut').daterangepicker({

					"format": 'MM-DD-YYYY',

					"singleDatePicker": true,

					"autoUpdateInput": false,

					"minDate": chkInDate,

					isInvalidDate: function (date) {

						var formatted = date.format('MM/DD/YYYY');

						return BookedDates.indexOf(formatted) > -1;

					}

				}, function (start, end, label) {

					$('#checkOut').val(start.format('DD-MM-YYYY'));

					//getQuote();
					valid_dates=check_unavail_booked_dates();
                if(parseInt(valid_dates)==0){
                    getQuote();
                }

				});

			}

		}



		var yOffset = $(".bookingBlock").offset().top;

		var yOffset1 = $(".mapSection").offset().top - $(".bookingBlock").innerHeight() - 55;

		$(window).scroll(function () {

			console.log($(".bookingBlock").innerHeight());

			if (window.outerWidth > 1200) {

				if ($(window).scrollTop() > yOffset && $(window).scrollTop() < yOffset1) {

					$(".bookingBlock").addClass("active");

				}

				else if ($(window).scrollTop() > yOffset1) {

					$(".bookingBlock").removeClass("active");

				}

				else {

					$(".bookingBlock").removeClass("active");

				}

			}

		});





		$(window).scroll(function () {

			var scrollPos = $(document).scrollTop();

			$('.fixedContainer a').each(function () {

				var currLink = $(this);

				var refElement = $(currLink.attr("href"));

				if (refElement.offset().top - 70 <= scrollPos && scrollPos <= (refElement.offset().top - 70 + refElement.height())) {

					refElement.addClass("current");

					var activeClass = "a[href='#" + refElement.attr("id") + "']";

					$('.fixedContainer a').removeClass("current");

					$(activeClass).addClass("current");

				}

			});

			$('#checkIn').data('daterangepicker').hide();
			$('#checkOut').data('daterangepicker').hide();

		});



	});



	function affectGuestCount(mode, select) {

		$existVAl = Number($(".guestCount").val());
		$newVAl = parseInt($existVAl) + 1;
		//alert($existVAl);
		

if($existVAl == 2){
			$('.dec').hide();
			$(".guestCount").val($existVAl - 1);
		}else{
$('.dec').show();
if (mode == 'decrease') {
			
			
			if ($existVAl != 0 && $(select).next().val() != 0) {

				$(".guestCount").val($existVAl - 1);

			}
			
		
		

			

		}
			}

		if (mode == 'increase') {
			$('.dec').show();
			$(".guestCount").val($existVAl + 1);

		}

		

	}



	function chckNumGuestInc(){

        $existValue = Number($(".guestCount").val());

        var NumOfGuest='<?php echo $NumGuest; ?>';

        if ( $existValue==NumOfGuest){

            $(".inc").css('display','none');

        }else{

            $(".inc").css('display','block');

        }

    }



    function chckNumGuestDec() {

        $(".inc").css('display','block');

    }



	/*Showing location map*/

	function initMap() {

		var myLatLng = {lat: <?php echo $product->latitude;?>, lng: <?php echo $product->longitude;?>};

		var map = new google.maps.Map(document.getElementById('map'), {

			zoom: 13,

			center: myLatLng

		});

		var marker = new google.maps.Marker({

			position: myLatLng,

			map: map,

			title: '<?php echo addslashes($product->product_title); ?>'

		});

	}



	initMap();



	/* Booking form */

	

	function validate_booking_form(option_choosed="book_now") {

		// var option_choosed="book_now";
		$('.loading').show();
		var diffDays = $('#total_nights').val();

		var rentguest = jQuery.trim($('#RentalGuest').val());

		var NoofGuest = parseInt(jQuery.trim($("#number_of_guests").val()));

		if ($('#checkIn').val() == "") {
			$('.loading').hide();
			$('#checkIn').focus();

			return false;

		} else if ($('#checkOut').val() == "") {
			$('.loading').hide();
			$('#checkOut').focus();

			return false;

		} else if ($('#ownerid').val() == $('#login_userid').val()) {
			$('.loading').hide();
			$('#BookingError').html("<?php if ($this->lang->line('You_have_no_permission') != '') {

				echo stripslashes($this->lang->line('You_have_no_permission'));

			} else echo "You have no permission";?>");

			return false;

		} else if ('<?php echo $productDetails->row()->child_name;?>' > parseInt(diffDays)) {
			$('.loading').hide();
			$('#BookingError').html("<?php if ($this->lang->line("Minimum_Stay_Shoud_be") != "") {

				echo stripslashes($this->lang->line("Minimum_Stay_Shoud_be"));

			} else echo "Minimum Stay Shoud be "; ?>" +" "+ <?php echo $productDetails->row()->child_name;?>+

				' <?php if ($this->lang->line('Nights') != '') {

					echo stripslashes($this->lang->line('Nights'));

				} else echo "Nights";?>'

			);

			return false;

		}

		else if ('<?php echo $productDetails->row()->host_status;?>' == 1 || '<?php echo $productDetails->row()->host_login_status;?>' == 'Inactive') {
			$('.loading').hide();
			$('#BookingError').html("<?php if ($this->lang->line('Host_is_removed') != '') {

				echo stripslashes($this->lang->line('Host_is_removed'));

			} else echo "Host is removed so booking is not available";?>");

			return false;

		} else if (NoofGuest > parseInt(rentguest)) {
			$('.loading').hide();
			$('#BookingError').html('<?php if ($this->lang->line('Maximum_number_of_guests_is') != '') {

				echo stripslashes($this->lang->line('Maximum_number_of_guests_is'));

			} else echo "Maximum number of guests is";?> ' + parseInt(rentguest));

			return false;

		} else {
			
			$('#BookingError').html('');

			var totalamt = $('#bookingtot').val();
			var prd_price = $('#prd_price').val();

			var servicefee = $('#stax').val();

			var subTotal = $("#subTotal").val();

			var currencycode = $("#currencycode").val();

			var user_currencyCode = $("#user_currencyCode").val();

			var secDeposit = $("#secDeposit").val();

			var walletAmount = '0.00';

			var checkin = $("#checkIn").val();

			var checkout = $("#checkOut").val();

			var cancel_percentage = $("#cancel_percentage").val();

			var prd_id = $("#prd_id").val();

			var renter_id = $("#renter_id").val();

			if (totalamt != '') {

				$.post("<?php echo base_url(); ?>site/user/rentalEnquiry_booking", {

					"checkin": checkin,

					"checkout": checkout,

					'numofdates': diffDays,

					"NoofGuest": NoofGuest,

					"cancel_percentage": cancel_percentage,

					"prd_id": prd_id,

					"renter_id": renter_id,
                    "price":prd_price,
					"serviceFee": servicefee,

					"totalAmt": totalamt,

					"subTotal": subTotal,

					"secDeposit": secDeposit,

					"walletAmount": walletAmount,

					"currencycode": currencycode,

					"user_currencyCode": user_currencyCode,

					"choosed_option": option_choosed,

					'base_subtotal': $('#base_subtotal').val(),

                    'base_taxValue': $('#base_taxValue').val(),
                    
                    'base_securityDeposite': $('#base_securityDeposite').val(),

				}, function (data, status) {

					var result = JSON.parse(data);

					if (result['message'] == 'Rental date already booked') {
						$('.loading').hide();
						$('#BookingError').html('<?php if ($this->lang->line('Rental date already booked') != '') {

							echo stripslashes($this->lang->line('Rental date already booked'));

						} else echo "Rental date already booked";?>');

					}

					else {

						window.location.href = baseURL + 'booking/' + $('#prd_id').val();

					}

				});

				return false;

			}

		}

	}



	/*Getting quote result*/

	function getQuote() {

		var checkIn = $('#checkIn');

		var checkOut = $('#checkOut');

		if (checkIn.val() == "") {

			checkIn.focus();

			return false;

		} else if (checkOut.val() == "") {

			checkOut.focus();

			return false;

		} else {

			$('.submitBtn').attr('disabled', true);

			$('#FeesList').html('<p class="text-center" style="margin:10px 0px;"><i class="fa fa-spinner fa-spin"></i> Loading...</p>');

			$.post("<?php echo base_url(); ?>site/product/ajaxdateCalculate",

				{

					checkIn: checkIn.val(),

					checkOut: checkOut.val(),

					price: '<?php echo $product->price; ?>',

					pid: '<?php echo $product->id; ?>'

				},

				function (data) {

					$('.submitBtn').attr('disabled', false);

					$('#FeesList').html(data);

				});

		}

	}
	function set_signup_and_login_links_req(){
		$('#spin_req').show();
		set_signup_and_login_links();
		setTimeout(function() { $("#spin_req").hide(); }, 2000);
	}
	function set_signup_and_login_links_instant(){
		$('#spin_in').show();
		set_signup_and_login_links();
		setTimeout(function() { $("#spin_in").hide(); }, 2000);
	}
	function set_signup_and_login_links(){
 	<?php $this->session->unset_userdata('checkIn');$this->session->unset_userdata('checkOut');?>
var checkIn = $('#checkIn').val();
var checkOut = $('#checkOut').val();

//alert(checkIn);
if(checkIn != '' && checkOut != ''){
	
	//alert(book_type);
 $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>site/user/set_session_ques',
                data: {'checkIn' :checkIn,'checkOut' :checkOut},
                
                success: function (data) {

                        $('#signIn').modal('show');
                        $('#spin').hide();
                       // alert('<?php echo $this->session->userdata('checkIn'); ?>')
                       // alert(data);
                }
            });
 }
 else{
 	//alert('dd');
 	 $('#signIn').modal('show');
 }

  }


    /* Check Coupon Timer fucntionality to show condition */
    if('<?php echo $coupon_date_to; ?>' == '')
    {
        var date="";
    }else{
        setInterval(function() { makeTimer(); }, 1000);
    }

function makeTimer() {
var date="<?php echo date('d M Y',strtotime($coupon->dateto)); ?>";
//alert(date);
	//		var endTime = new Date("29 April 2018 9:56:00 GMT+01:00");	
	var dd = "<?php echo date('d M Y',strtotime($coupon->dateto)); ?> 23:59:59 GMT+0530 (India Standard Time)";
	//alert(dd);	return false;
		var endTime = new Date(dd);		
		
			endTime = (Date.parse(endTime) / 1000);

			var now = new Date();
			
			now = (Date.parse(now) / 1000);

			var timeLeft = endTime - now;

			var days = Math.floor(timeLeft / 86400); 
			var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
			var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
			var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
			if (hours < "10") { hours = "0" + hours; }
			if (minutes < "10") { minutes = "0" + minutes; }
			if (seconds < "10") { seconds = "0" + seconds; }

			$("#days").html(days + "<span>Days</span>");
			$("#hours").html(hours + "<span>Hours</span>");
			$("#minutes").html(minutes + "<span>Minutes</span>");
			$("#seconds").html(seconds + "<span>Seconds</span>");		

	}
//makeTimer();
setInterval(function() { makeTimer(); }, 1000);
 $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if(scroll >= 100){$(".posHeader").addClass("fixedHeader");}
        else {$(".posHeader").removeClass("fixedHeader");}
        //Goto Top
        if(scroll >= 500){$(".gotoTop").css("opacity","1");}
        else{$(".gotoTop").css("opacity","0");}

    });
</script>

<script type="text/javascript">
	$(document).ready(function() {
  var bigimage = $("#big");
  var thumbs = $("#thumbs");
  //var totalslides = 10;
  var syncedSecondary = true;

  bigimage
    .owlCarousel({
    items: 1,
    slideSpeed: 2000,
    nav: true,
    autoplay: false,
    dots: false,
    loop: false,
    responsiveRefreshRate: 200,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ]
  })
    .on("changed.owl.carousel", syncPosition);

  thumbs
    .on("initialized.owl.carousel", function() {
    thumbs
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: 10,
    dots: true,
    nav: true,
    navText: [
      '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
      '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
    ],
    smartSpeed: 200,
    slideSpeed: 500,
    slideBy: 4,
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);

  function syncPosition(el) {
    //if loop is set to false, then you have to uncomment the next line
    //var current = el.item.index;

    //to disable loop, comment this block
    var count = el.item.count - 1;
    var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

    if (current < 0) {
      current = count;
    }
    if (current > count) {
      current = 0;
    }
    //to this
    thumbs
      .find(".owl-item")
      .removeClass("current")
      .eq(current)
      .addClass("current");
    var onscreen = thumbs.find(".owl-item.active").length - 1;
    var start = thumbs
    .find(".owl-item.active")
    .first()
    .index();
    var end = thumbs
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
      thumbs.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
      thumbs.data("owl.carousel").to(current - onscreen, 100, true);
    }
  }

  function syncPosition2(el) {
    if (syncedSecondary) {
      var number = el.item.index;
      bigimage.data("owl.carousel").to(number, 100, true);
    }
  }

  thumbs.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = $(this).index();
    bigimage.data("owl.carousel").to(number, 300, true);
  });
});

</script>

<?php

$this->load->view('site/includes/footer');

?>

