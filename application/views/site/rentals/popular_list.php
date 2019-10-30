<?php
$this->load->view('site/includes/header');
$data = array('type' => 'hidden', 'id' => 'page_number', 'name' => 'page_number', 'value' => 1);
echo form_input($data);
?>
<section class="loggedBg">
	<div class="container">
		<ul class="loginMenu">
			<li>
				<a href="<?php echo base_url(); ?>popular" <?php if ($this->uri->segment(1) == 'popular') { ?> class="active" <?php } ?>><?php if ($this->lang->line('popular') != '') {
						echo stripslashes($this->lang->line('popular'));
					} else echo "Popular"; ?></a></li>
			<?php if ($loginCheck != '') { ?>
				<li>
					<a href="<?php echo base_url(); ?>users/<?php echo $loginCheck; ?>/wishlists" <?php if ($this->uri->segment(3) == 'wishlists') { ?> class="active" <?php } ?>><?php if ($this->lang->line('MyWishLists') != '') {
							echo stripslashes($this->lang->line('MyWishLists'));
						} else echo "My Wish Lists"; ?></a></li>
			<?php } ?>
		</ul>
	</div>
</section>
<section class="popularListing">	
	<div class="container " style="margin-top: 40px;">
		<div class="row listings" id="popular_listings">
			<?php if ($product->num_rows() > 0) {				
				foreach ($product->result_array() as $product_image) { ?>
					<div class="col-sm-4 col-md-3">
						<div class="owl-carousel show">
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
								<?php
								$imgSrc = 'dummyProductImage.jpg';
								if (($product_image['product_image'] != '') && (file_exists('./images/rental/' . $product_image['product_image']))) {
									$imgSrc = $product_image['product_image'];
								}
								?>
								<div class="myPlace"
									 style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $imgSrc; ?>')"></div>
								<div class="bottom">
									<div class="loc"><?php 

									$list_value_val=language_dynamic_enable("list_value",$this->session->userdata('language_code'),$product_image);
 echo ucfirst($list_value_val.' ');
 $city_val=language_dynamic_enable("city",$this->session->userdata('language_code'),$product_image);
 echo ucfirst($city_val);

								// 	if($this->session->userdata('language_code') =='en'){
								// 		if ($product_image['list_value']!=''){
								// 		echo $product_image['list_value']." . ";
								// 	}
								// 	echo $product_image['city']; 
								// 	}
								// 	// elseif($this->session->userdata('language_code') =='ar'){
								// 	// 	if ($product_image['list_value_ar']!=''){
								// 	// 	echo $product_image['list_value_ar']." . ";
								// 	// }else{
								// 	// 	$product_image['list_value']." . ";
								// 	// }
								// 	// echo $product_image['city'];

								// 	// }
								// 	else{
								// 			if ($product_image['list_value']!='' && $product_image['city']!=''){
								// 			echo $product_image['list_value_'.$_SESSION['language_code']] . " . " .$product_image['city'];
								// 		}else if ($product_image['list_value']!=''){
								// 			echo $product_image['list_value'];
								// 		}else if ($product_image['city']!=''){
								// 			echo $product_image['city'];
								// 		}

								// }


									?></div>
									<h5><?php 

									$prod_tit=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$product_image);
 echo $prod_tit;

                                // if($this->session->userdata('language_code') =='en')
                                //     {
                                //       //  $prod_tit = $product_image['product_title'];
                                //         $prod_tit=language_dynamic_enable("product_title",$this->session->userdata('language_code'),(object)$product_image);                                            
                                //     }
                                //     else
                                //     {
                                //         $prodAr='product_title_'.$this->session->userdata('language_code');
                                //         if($product_image[$prodAr] == '') { 
                                //             $prod_tit=$product_image['product_title'];
                                //         }
                                //         else{
                                //             $prod_tit=$product_image['product_title_'.$this->session->userdata('language_code')];
                                //         }
                                //     }
                                //    // echo $cityname;
                                // echo ucfirst($prod_tit);
									 //echo $product_image['product_title']; ?></h5>
									<div class="price"><span class="number_s"><?php
											echo $this->session->currency_s;
											if ($product_image['currency'] != '') {
												if ($product_image['currency'] != $this->session->userdata('currency_type')) {
													$list_currency = $product_image['currency'];
													if ($currency_result->$list_currency) {
														$price = $product_image['price'] / $currency_result->$list_currency;
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
											?></span></div>
									<div class="clear">
										<div class="starRatingOuter">
											<?php
											$tot_rev = 0;
											$reviewers = 0;
											if ($product_image['id'] != '') {
												$result = $this->db->select('AVG(total_review) as tot_rev')->where(array('product_id' => $product_image['id'],'review_type'=>'0', 'status' => 'Active'))->get(REVIEW);
												$result1 = $this->db->select('id')->where(array('product_id' => $product_image['id'],'review_type'=>'0', 'status' => 'Active'))->get(REVIEW);
												$tot_rev = $result->row()->tot_rev;
												$reviewers = $result1->num_rows();
											}
											?>
											<div class="starRatingInner"
												 style="width: <?php echo $tot_rev * 20 ?>%;">
											</div>
										</div>
										<span
											class="ratingCount"> <?php echo $reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
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
				<p class="text-danger text-center">
				
				<?php if ($this->lang->line('no_popular_found') != '') {
												echo stripslashes($this->lang->line('no_popular_found'));
											} else echo "No Popular rental found"; ?>
				!</p>
				<?php
			} ?>
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
<script>
	/*Scroll loading pages*/
	var page = $('#page_number').val();
	$(window).scroll(function () {
		if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
			if (page <= <?php echo $total_pages; ?>) {
				loadMoreData(page);
			}
			page++;
		}
	});

	function loadMoreData(page) {
		$.ajax(
			{
				url: '<?php echo base_url(); ?>popular?page=' + page,
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
				$("#popular_listings").append(data);
			})
			.fail(function (jqXHR, ajaxOptions, thrownError) {
				boot_alert('server not responding...');
			});
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
