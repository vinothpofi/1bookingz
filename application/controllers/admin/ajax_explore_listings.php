<?php
$currency_result = $this->session->userdata('currency_result');
if ($product->num_rows() > 0) {
    foreach ($product->result_array() as $product_image) {
        ?>
        <div class="col-sm-6 col-md-3" style='margin-top:10px;margin-bottom:10px'>
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
                <?php if (($product_image['product_image'] != '') && (file_exists('./images/rental/' . $product_image['product_image']))) {
                        ?>
                        <div class="myPlace"
                             style="background-image: url('<?php echo base_url(); ?>images/rental/<?php echo $product_image['product_image']; ?>')"></div>
                    <?php } else { ?>
                        <div class="myPlace"
                             style="background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"></div>
                    <?php } ?>
                    <div class="bottom">
                      <div class="loc">
										<?php 
										if ($product_image['list_value']!='' && $product_image['city']!=''){
											echo $product_image['list_value'] . " . " .$product_image['city'];
										}else if ($product_image['list_value']!=''){
											echo $product_image['list_value'];
										}else if ($product_image['city']!=''){
											echo $product_image['city'];
										}
																				
										  ?></div>
                        <h5><?php
                            echo ucfirst($product_image['product_title']);
                            
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
                                        echo number_format($price,2);
                                    } else {
                                        $priceEx = $product_image['price'];
                                        echo number_format($priceEx, 2);
                                    }
                                } else {
                                    $priceEx1 = $product_image['price'];
                                    echo number_format($priceEx1, 2);
                                }
								echo ' <span style="font-size:14px;">Per night</span>';
                                ?></span>
                        </div>
                        <div class="clear">
                            <div class="starRatingOuter">
                                <?php
                                $avg_val = round($product_image['rate']);
                                $num_reviewers = $product_image['num_reviewers'];
                                ?>
                                <div class="starRatingInner" style="width: <?php echo($avg_val * 20); ?>%;"></div>
                            </div>
                            <span class="ratingCount"><?php echo $num_reviewers . " "; ?> <?php if ($this->lang->line('Reviews') != '') {
                                    echo stripslashes($this->lang->line('Reviews'));
                                } else echo "Reviews"; ?></span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php }
}else{
    ?>
    <div class="row">
        <div class="col-md-12">
            <p class="text-center text-danger">No more listings found!</p>
        </div>
    </div>
<?php
}
?>
