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
										if ($product_image['list_value']!=''){

											$prod_tiltle=language_dynamic_enable("list_value",$this->session->userdata('language_code'),(object)$product_image);
                                            echo ucfirst($prod_tiltle);
											//echo $product_image['list_value']." . ";
										}
										echo $product_image['city']; ?>
								</div>						
						<h5>

							<?php 
								$prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),(object)$product_image);
                                                            echo ucfirst($prod_tiltle);							
							//echo $product_image['product_title']; 

							?>
								
						</h5>

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
									$result = $this->db->select('AVG(total_review) as tot_rev')->where(array('product_id' => $product_image['id'], 'status' => 'Active'))->get(REVIEW);
									$result1 = $this->db->select('id')->where(array('product_id' => $product_image['id'], 'status' => 'Active'))->get(REVIEW);
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
} ?>
