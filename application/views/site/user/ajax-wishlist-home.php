<?php
if ($WishListCat->num_rows() > 0) {
	foreach ($WishListCat->result() as $wlist) {
		if ($wlist->last_added != '0') {
			$CountExperience = 0;
			$products = explode(',', $wlist->product_id);
			$productsNotEmy = array_filter($products);
			$CountProduct1 = count($productsNotEmy);
			if ($experienceExistCount > 0) {
				$experiences = explode(',', $wlist->experience_id);
				$experienceNotEmy = array_filter($experiences);
				$CountExperience = count($experienceNotEmy);
			}
			$totCount = $CountProduct1 + $CountExperience;
			$imgPath = base_url() . 'images/empty-wishlist.jpg';
			if ($wlist->last_added == '1') {
				$CountProduct = $this->shop->get_all_details(PRODUCT, array('id' => end($productsNotEmy)))->num_rows();
				if ($CountProduct > 0) {
					$ProductsImg = $this->shop->get_all_details(PRODUCT_PHOTOS, array('product_id' => end($productsNotEmy)));
					if ($ProductsImg->row()->product_image != '' && file_exists('./images/rental/' . $ProductsImg->row()->product_image)) {
						$imgPath = base_url() . 'images/rental/' . $ProductsImg->row()->product_image;
					} else {
						$imgPath = base_url() . 'images/rental/dummyProductImage.jpg';
					}
				}
			} else if ($experienceExistCount > 0) {
				if ($wlist->last_added == '2') {
					$CountProduct = $this->shop->get_all_details(EXPERIENCE, array('experience_id' => end($experienceNotEmy)))->num_rows();
					if ($CountProduct > 0) {
						$ProductsImg = $this->shop->get_all_details(EXPERIENCE_PHOTOS, array('product_id' => end($experienceNotEmy)));
						if ($ProductsImg->row()->product_image != '' && file_exists('./images/experience/' . $ProductsImg->row()->product_image)) {
							$imgPath = base_url() . 'images/experience/' . $ProductsImg->row()->product_image;
						} else {
							$imgPath = base_url() . 'images/experience/dummyProductImage.jpg';
						}
					}
				}
			}
			?>
			<div class="col-sm-6 col-md-3">
				<div class="owl-carousel show">
					<a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $wlist->id; ?>">
						<div class="myPlace"
							 style="background-image: url('<?php echo $imgPath; ?>')"></div>
						<div class="bottom">
							<div class="loc">
								<?php 
									$prod_tiltle=language_dynamic_enable("name",$this->session->userdata('language_code'),$wlist);
                                         echo ucfirst($prod_tiltle);
									//echo $wlist->name; 
									//echo $wlist->name; 
								?>								
							</div>
							<a><i class="fa fa-heart"
								  aria-hidden="true"></i> <?php echo $totCount . " "; ?><?php if ($this->lang->line('Listings') != '') {
									echo stripslashes($this->lang->line('Listings'));
								} else echo "Listings"; ?></span></a>
						</div>
					</a>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="col-sm-6 col-md-3">
				<div class="owl-carousel show">
					<a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $wlist->id; ?>">
						<div class="myPlace"
							 style="background-image: url('<?= base_url(); ?>images/empty-wishlist.jpg')"></div>
						<div class="bottom">
							<div class="loc">
								<?php 
									$prod_tiltle=language_dynamic_enable("name",$this->session->userdata('language_code'),$wlist);
                                            echo ucfirst($prod_tiltle);
									//echo $wlist->name; 
									//echo $wlist->name; 
									//echo $wlist->name; 
								?>								
							</div>
							<a><i class="fa fa-heart"
								  aria-hidden="true"></i> 0 <?php if ($this->lang->line('Listings') != '') {
									echo stripslashes($this->lang->line('Listings'));
								} else echo "Listings"; ?></span></a>
						</div>
					</a>
				</div>
			</div>
			<?php
		}
	}
}
?>
