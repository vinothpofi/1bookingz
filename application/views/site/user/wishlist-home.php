<?php
$this->load->view('site/includes/header');
$data = array('type' => 'hidden', 'id' => 'page_number', 'name' => 'page_number', 'value' => 1);
echo form_input($data);
if (!empty($WishlistUserDetails)) {
	$wuser = $WishlistUserDetails->row();
}
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
<section>
	<div class="container-fluid" style="margin-top: 20px;">
		<?php
		if ($this->session->fc_session_user_id != "") {
			?>
			<div class="row">
				<div class="col-lg-12 form-group text-right">
					<button class="submitBtn1" data-toggle="modal"
							href="#CreateWishlist"><?php if ($this->lang->line('Createnewwishlist') != '') {
							echo stripslashes($this->lang->line('Createnewwishlist'));
						} else echo "Create New Wishlist"; ?></button>
				</div>
				<div class="col-lg-6 col-xs-12 ">
					<div>
						<p><img
								src="<?= base_url(); ?>images/users/<?= ($wuser->image != '' && file_exists('./images/users/' . $wuser->image)) ? $wuser->image : 'profile.png'; ?>"
								class="img img-circle" width="70" height="70">
							<?php if ($this->lang->line('wish_list_count') != '') {
								echo stripslashes($this->lang->line('wish_list_count'));
							} else echo "Wishlists:"; ?>
							<?php echo $total_wishList; ?></p>
					</div>
				</div>
			</div>
			<div class="row listings" id="wishlist_listings">
				<?php
				if ($WishListCat->num_rows() > 0) {

					foreach ($WishListCat->result() as $wlist) {
                        $imagePathArray = array();
					    if(!empty($wlist)){
						if ($wlist->last_added != '0') {
                            $CountExperience = 0;
                            //UNPUBLISHED PRODUCTS.
                            $products = explode(',', $wlist->product_id);
                            $productnewArray = array();

                            foreach ($products as $produc) {
                                if ($produc != '') {
                                    $unPublishquery = $this->db->query("SELECT id FROM fc_product WHERE status='UnPublish' AND id = '" . $produc . "'");
                                    if ($unPublishquery->num_rows() > 0) {
                                    } else {
                                        array_push($productnewArray, $produc);
                                        $CountProduct = $this->shop->get_all_details(PRODUCT, array('id' => $produc))->num_rows();
                                        if ($CountProduct > 0) {
                                            $ProductsImg = $this->shop->get_all_details(PRODUCT_PHOTOS, array('product_id' => $produc));
                                            if ($ProductsImg->row()->product_image != '' && file_exists('./images/rental/' . $ProductsImg->row()->product_image)) {
                                                $imgPath = base_url() . 'images/rental/' . $ProductsImg->row()->product_image;
                                                array_push($imagePathArray, $imgPath);
                                            }
                                        }
                                    }
                                }
                            }

                            //print_r($imagePathArray);

                            $productsNotEmy = array_filter($productnewArray);
                            $CountProduct1 = count($productsNotEmy);
                            //if ($experienceExistCount > 0) {
                            $experiences = explode(',', $wlist->experience_id);
                            //UNPUBLISHED EXPERIENCE.
                            $experiencenewArray = array();
                            foreach ($experiences as $xperience) {
                                if ($xperience != '') {
                                    $unPublishExpquery = $this->db->query("SELECT experience_id FROM fc_experiences WHERE status='0' AND experience_id = '" . $xperience . "'");
                                    if ($unPublishExpquery->num_rows() > 0) {
                                    } else {
                                        array_push($experiencenewArray, $xperience);
                                        $CountProduct = $this->shop->get_all_details(EXPERIENCE, array('experience_id' => $xperience))->num_rows();
                                        if ($CountProduct > 0) {
                                            $ProductsImg = $this->shop->get_all_details(EXPERIENCE_PHOTOS, array('product_id' => $xperience));
                                            if ($ProductsImg->row()->product_image != '' && file_exists('./images/experience/' . $ProductsImg->row()->product_image)) {
                                                $imgPath = base_url() . 'images/experience/' . $ProductsImg->row()->product_image;
                                                array_push($imagePathArray, $imgPath);
                                            }
                                        }
                                    }
                                }
                            }
                            $experienceNotEmy = array_filter($experiencenewArray);
                            $CountExperience = count($experienceNotEmy);
                            //}
                            $totCount = $CountProduct1 + $CountExperience;

                            if($totCount>0) {
                                if (count($imagePathArray) > 0) {
                                    $imgPath = $imagePathArray[array_rand($imagePathArray, 1)];
                                } else {
                                    $imgPath = base_url() . 'images/empty-wishlist.jpg';
                                }
                            }else{
                                $imgPath = base_url() . 'images/empty-wishlist.jpg';
                            }
                            ?>
                            <div class="col-sm-6 col-md-3 col-xs-12">
                                <div class="owl-carousel show">
                                    <a href="<?php echo base_url(); ?>user/<?php echo $loginCheck; ?>/wishlists/<?php echo $wlist->id; ?>">
                                        <div class="myPlace"
                                             style="background-image: url('<?php echo $imgPath; ?>')"></div>
                                        <div class="bottom">
                                            <div class="loc">
                                                <?php
                                                $prod_tiltle = language_dynamic_enable("name", $this->session->userdata('language_code'), $wlist);
                                                echo ucfirst($prod_tiltle);
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
                        }
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
												?>												
											</div>
											<a><i class="fa fa-heart"
												  aria-hidden="true"></i>
												0 <?php if ($this->lang->line('Listings') != '') {
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
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="text-center" id="ajax-load" style="display:none;">Loading .. </p>
				</div>
			</div>
			<?php
		} else {
			?>
			<div class="row">
				<div class="col-lg-12">
					<p class="text-center text-danger">Login to view the wish lists <a data-toggle="modal"
																					   data-target="#signIn">Click
							Here!</a></p>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</section>
<!--Create wish list Modal-->
<div id="CreateWishlist" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="signUpIn">
					<div class="SignupBlock" style="display: block;">
						<div class="image_box">
							<p class="text-center text-danger" id="wishlist_warn_cat"></p>
						</div>
						<h5><?php if ($this->lang->line('WishListName') != '') {
								echo stripslashes($this->lang->line('WishListName'));
							} else echo "Wish List Name"; ?>
						</h5>
						<div class="image_box">
							<?php echo form_input('list_name', '', array("id" => "wishlist_name", "placeholder" => ($this->lang->line('WishListName') != '') ? stripslashes($this->lang->line('WishListName')) : "Wish List Name")); ?>
							<i class="fa fa-heart-o" aria-hidden="true"></i>
						</div>

						<div class="image_box">
							<h5><?php if ($this->lang->line('Who can see this Tittle?') != '') {
										echo stripslashes($this->lang->line('Who can see this Tittle?'));
									} else echo "Who can see this Tittle?"; ?></h5>
							<select id="wish_select" name="wish_select">
								<option value="0"> <?php if ($this->lang->line('Everyone') != '') {
										echo stripslashes($this->lang->line('Everyone'));
									} else echo "Everyone"; ?> </option>
								<option value="1"> <?php if ($this->lang->line('Only_Me') != '') {
										echo stripslashes($this->lang->line('Only_Me'));
									} else echo "Only Me"; ?> </option>
							</select>
						</div>
						<a href="javascript:void(0);" onclick="return Create_WishListCat();"
						   class="email"> <?php if ($this->lang->line('Save') != '') {
								echo stripslashes($this->lang->line('Save'));
							} else echo "Save"; ?></a>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>

	</div>
</div>
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
				url: '<?php echo base_url(); ?>site/wishlists?page=' + page,
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
				$("#wishlist_listings").append(data);
			})
			.fail(function (jqXHR, ajaxOptions, thrownError) {
				boot_alert('server not responding...');
			});
	}

	/*Creating wishlist*/
	function Create_WishListCat() {
		var list_name = $("#wishlist_name").val();
		var select = $("#wish_select").val();
		if (list_name == "") {
			$("#wishlist_warn_cat").html("<?php if ($this->lang->line('Please_enter_wishlist_category') != '') {
				echo stripslashes($this->lang->line('Please_enter_wishlist_category'));
			} else echo "Please enter wishlist category";?>");
			return false;
		} else {
			$("#wishlist_warn_cat").html("");
			$.ajax({
				type: 'POST',
				url: '<?= base_url(); ?>site/rentals/rentalwishlistcategoryAdd',
				data: {"list_name": list_name, "whocansee": select},
				dataType: 'json',
				success: function (json) {
					if (json.result == '0') {
						window.location.reload();
					}
					if (json.result == '1') {
						$("#wishlist_warn_cat").html("<?php if ($this->lang->line('This_category_already_exists') != '') {
							echo stripslashes($this->lang->line('This_category_already_exists'));
						} else echo "This category already exists";?>");
					}
					return false;
				}
			});
		}
		return false;
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
