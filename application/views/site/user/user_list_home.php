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
	<div class="container userWishlist" style="margin-top: 20px;">
		<?php
		if ($this->session->fc_session_user_id != "") {
			?>
			<div class="row">
				<div class="col-lg-1">
					<p><img
							src="<?= base_url(); ?>images/users/<?= ($wuser->image != '' && file_exists('./images/users/' . $wuser->image)) ? $wuser->image : 'profile.png'; ?>"
							class="img img-circle" width="70" height="70">
					</p>
				</div>
				<div class="col-lg-11">
					<p class="text-capitalize">
						<?php echo ucfirst($userDetails->row()->firstname); ?><br>
						<?php if ($this->lang->line('WishListName') != '') {
							echo stripslashes($this->lang->line('WishListName'));
						} else echo "Wish-list name";
						echo ' : ' . $list_details->row()->name; ?><br>
						<a data-toggle="modal" data-target="#EditWishlist" href="#"> <?php if ($this->lang->line('Edit') != '') {
							   echo stripslashes($this->lang->line('Edit'));
						   } else echo "Edit"; ?> </a> .
						<a href="<?= base_url(); ?>site/user/DeleteallWishList/<?php echo $list_details->row()->id; ?>"
						   onclick="return confirm('<?php if ($this->lang->line('Are_you_sure') != '') {
							   echo stripslashes($this->lang->line('Are_you_sure'));
						   } else echo "Are you sure"; ?>?')"> <?php if ($this->lang->line('Delete') != '') {
							   echo stripslashes($this->lang->line('Delete'));
						   } else echo "Delete"; ?> </a>
					</p>
				</div>
				
				
				
				
				<div class="col-lg-12">
					<br>
				</div>
			</div>
			<div class="row listings" id="wishlist_listings">
				<div class="col-md-12 col-sm-12 col-xs-12 ">
					<h3><?php if ($this->lang->line('wish_list_for_prop') != '') {
							   echo stripslashes($this->lang->line('wish_list_for_prop'));
						   } else echo "Wish List For Properties"; ?> </h3>
					
				</div>
				<?php
				if ($totalProducts > 0) {
					if ($product_details->num_rows() > 0) {
						foreach ($product_details->result() as $productRow) {
							$imgArr = $productRow->product_image;
							$img = 'dummyProductImage.jpg';
							if ($imgArr != '' && file_exists('./images/rental' . $imgArr)) {
								$img = $imgArr;
							}
							?>
							<div class="row wishlistListing">
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
									<div id="myCarousel_<?= $productRow->id; ?>" class="carousel slide"
										 data-ride="carousel">
										<ul class="carousel-inner">
											<?php
											$count = 0;
											foreach ($wishlist_image[$productRow->id]->result() as $product_image) {
												if ($product_image->product_image != '' && file_exists('./images/rental/' . $product_image->product_image)) {
													?>
													<li style="height:250px;background-size:cover;background-image: url('<?php echo base_url() . "images/rental/" . $product_image->product_image; ?>')"
														class="item <?php if ($count == 0) { ?>active<?php } ?>"></li>
													<?php
												} else {
													?>
													<li style="height:250px;background-size:cover;background-image: url('<?php echo base_url(); ?>images/rental/dummyProductImage.jpg')"
														class="item <?php if ($count == 0) { ?>active<?php } ?>"></li>
													<?php
												}
												$count++;
											}
											?>
										</ul>
										<?php
										if ($count > 1) {
											?>
											<a class="left carousel-control" href="#myCarousel_<?= $productRow->id; ?>"
											   data-slide="prev">
												<span class="fa fa-chevron-left"></span>
												<span class="sr-only"><?php if ($this->lang->line('previous') != '') {
							   echo stripslashes($this->lang->line('previous'));
						   } else echo "Previous"; ?></span>
											</a>
											<a class="right carousel-control" href="#myCarousel_<?= $productRow->id; ?>"
											   data-slide="next">
												<span class="fa fa-chevron-right"></span>
												<span class="sr-only"><?php if ($this->lang->line('Next') != '') {
							   echo stripslashes($this->lang->line('Next'));
						   } else echo "Next"; ?></span>
											</a>
											<ol class="carousel-indicators">
												<?php for ($i = 0; $i < $count; $i++) {
													?>
													<li data-target="#myCarousel_<?= $productRow->id; ?>"
														data-slide-to="<?= $i; ?>"<?php if ($i == 0) { ?> class="active" <?php } ?>></li>
													<?php
												} ?>
											</ol>
											<?php
										}
										?>
									</div>
								</div>
								<div class="col-md-8 col-sm-8 col-xs-12">
									
									<div class="row  wishlist-dtl-sec">
										<div class="col-lg-8 col-md-8 col-sm-8">
											<h3 class="firstCaps wishTitle"><a
											href="<?= base_url(); ?>rental/<?php echo $productRow->seourl; ?>"><?php echo $productRow->product_title; ?></a>
									</h3>
											<p>
												<?php echo $productRow->address . ',' . $productRow->name . ',' . $productRow->post_code; ?>
											</p>

										</div>
										<div class="col-lg-4 col-md-4 col-sm-4">
											<p class="mywish">
												<b class="price_S number_s ">
													<?php echo $currencySymbol;
													if ($productRow->currency != $this->session->userdata('currency_type')) {
														echo number_format(currency_conversion($productRow->currency, $this->session->userdata('currency_type'), $productRow->price), 2);
													} else {
														$price_wish = $productRow->price;
														echo number_format($price_wish, 2);
													} ?></b><br>
												<?php
												echo $this->session->userdata('currency_type'); ?></p>
										</div>
									</div>
									<div class="row">
										<!-- <div class="col-sm-2">
											<img class="img img-circle wish_user"
												 alt="<?php echo ucfirst($userDetails->firstname); ?>"
												 src="<?php if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
													 echo base_url() . 'images/users/' . $userDetails->row()->image;
												 } else {
													 echo base_url() . 'images/users/profile.png';
												 } ?>" height="80">
										</div> -->
										<div class="col-sm-12 col-xs-12">
											<textarea class="form-control" rows="3" id="adeds-note"
													  onblur="return notes_reload(this);" placeholder="Enter Description"
													  nid="<?php echo $productRow->nid; ?>"><?php echo $productRow->notes; ?></textarea>
										</div>
									</div>

									<div class="row">
										<?php if($_SESSION['language_code'] == 'en') { ?><!-- lang english -->
										<div class=" wishBot">
										<div class="col-md-6">
											<a href="<?= base_url(); ?>/rental/<?php echo $productRow->seourl; ?>"
										   class="submitBtn1"><?php if ($this->lang->line('Book Now') != '') {
													echo stripslashes($this->lang->line('Book Now'));
												} else echo "Book Now"; ?></a>
										</div>
												
												
										
										<div class="col-md-6 text-right chRem">
											<a href="javascript:void(0)" class="btn"
												onclick="loadWishlistPopup(<?php echo $productRow->id; ?>)"><?php if ($this->lang->line('change') != '') {
												echo stripslashes($this->lang->line('change'));
											} else echo "change"; ?></a>
											<a href="javascript:void(0)" class="btn"
													onclick="return DeleteExperinceWishList('<?php echo $productRow->id; ?>','<?php echo $list_details->row()->id; ?>')"><?php if ($this->lang->line('Remove') != '') {
													echo stripslashes($this->lang->line('Remove'));
												} else echo "Remove"; ?></a>
										</div>
										
									</div>
								<?php } else{ ?> <!-- lang arabic -->
                                                <div class=" wishBot">
										<div class="col-md-pull-2 col-sm-pull-2 col-md-6 col-sm-6 col-xs-6">
											<a href="<?= base_url(); ?>/rental/<?php echo $productRow->seourl; ?>"
										   class="submitBtn1"><?php if ($this->lang->line('Book Now') != '') {
													echo stripslashes($this->lang->line('Book Now'));
												} else echo "Book Now"; ?></a>
										</div>
												
												
										
										<div class="col-md-6 col-sm-6 col-xs-6 text-left chRem">
											<a href="javascript:void(0)" class="btn"
												onclick="loadWishlistPopup(<?php echo $productRow->id; ?>)"><?php if ($this->lang->line('change') != '') {
												echo stripslashes($this->lang->line('change'));
											} else echo "change"; ?></a>
											<a href="javascript:void(0)" class="btn"
													onclick="return DeleteExperinceWishList('<?php echo $productRow->id; ?>','<?php echo $list_details->row()->id; ?>')"><?php if ($this->lang->line('Remove') != '') {
													echo stripslashes($this->lang->line('Remove'));
												} else echo "Remove"; ?></a>
										</div>
										
									</div>
								<?php } ?>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12"><br></div>
							<?php
						}
					}
				} else {
					?>
					<div class="col-md-12"><p class="text-danger"><?php if ($this->lang->line('no_wish_prop') != '') {
													echo stripslashes($this->lang->line('no_wish_prop'));
												} else echo "No Wish List For Properties"; ?>!</p><br></div>
					<?php
				} ?>
				
				
			</div>
			<div class="row listings" id="wishlist_listings">
				<div class="">
					<h3>
					<?php if ($this->lang->line('wish_list_exp') != '') {
													echo stripslashes($this->lang->line('wish_list_exp'));
												} else echo "Wish List For Experience"; ?> </h3>
				</div>
				
				
				
				<?php
				if ($totalExperience > 0) {
					if ($experience_details->num_rows() > 0) {
						foreach ($experience_details->result() as $productRow) {
							$imgArr = $productRow->product_image;
							$img = 'dummyProductImage.jpg';
							if ($imgArr != '' && file_exists('./images/rental' . $imgArr)) {
								$img = $imgArr;
							}
							?>
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sm-4">
									<div id="transition-timer-carousel my_crsl"
										 class="carousel slide transition-timer-carousel" data-ride="carousel">
										<ul class="carousel-inner">
											<?php
											$count = 0;
											foreach ($wishlist_ExpImage[$productRow->id]->result() as $product_image) {
												if ($product_image->product_image != '' && file_exists('./images/experience/' . $product_image->product_image)) {
													?>
													<li style="height:250px;background-image: url('<?php echo base_url() . "images/experience/" . $product_image->product_image; ?>')"
														class="item <?php if ($count == 0) { ?>active<?php } ?>"></li>
													<?php
												} else {
													?>
													<li style="height:250px;background-image: url('<?php echo base_url(); ?>images/experience/dummyProductImage.jpg')"
														class="item <?php if ($count == 0) { ?>active<?php } ?>"></li>
													<?php
												}
												$count++;
											}
											?>
										</ul>
									</div>
								</div>
								<div class="col-md-8 col-sm-12">
									<h3 class="firstCaps wishTitle"><a
											href="<?= base_url(); ?>view_experience/<?php echo $productRow->id; ?>"><?php echo $productRow->product_title; ?></a>
									</h3>
									<div class="row">
										<div class="col-md-8">
											<p>
												<?php echo $productRow->address; ?>
											</p>
										</div>
										<div class="col-md-4">
											<p class="text-right mywish">
												<b class="price_S number_s ">
													<?php echo $currencySymbol;
													if ($productRow->currency != $this->session->userdata('currency_type')) {
														echo number_format(currency_conversion($productRow->currency, $this->session->userdata('currency_type'), $productRow->price), 2);
													} else {
														$price_wish = $productRow->price;
														echo number_format($price_wish, 2);
													} ?></b><br>
												<?php
												echo $this->session->userdata('currency_type'); ?></p>
										</div>
									</div>
									<div class="col-md-12">
										<div class="col-sm-2">
											<img class="img img-circle wish_user"
												 alt="<?php echo ucfirst($userDetails->firstname); ?>"
												 src="<?php if ($userDetails->row()->image != '' && file_exists('./images/users/' . $userDetails->row()->image)) {
													 echo base_url() . 'images/users/' . $userDetails->row()->image;
												 } else {
													 echo base_url() . 'images/users/profile.png';
												 } ?>" height="80">
										</div>
										<div class="col-sm-10">
									<textarea class="form-control" rows="3" id="adeds-note"
											  onblur="return notes_reload(this);" placeholder="Enter Description"
											  nid="<?php echo $productRow->nid; ?>"><?php echo $productRow->notes; ?></textarea>
										</div>
									</div>
									<div class="col-md-2">
										<br>
									</div>
									<div class="col-md-10">
										<div class="col-md-6">
										<a href="<?= base_url(); ?>/view_experience/<?php echo $productRow->id; ?>"
										   class="btn submitBtn1"><?php if ($this->lang->line('Book Now') != '') {
													echo stripslashes($this->lang->line('Book Now'));
												} else echo "Book Now"; ?></a>
										</div>

										<div class="col-md-6 text-right chRem">
										<a href="javascript:void(0)" class="btn"
												onclick="loadExperienceWishlistPopup(<?php echo $productRow->id; ?>)"><?php if ($this->lang->line('change') != '') {
												echo stripslashes($this->lang->line('change'));
											} else echo "change"; ?></a>
										<a href="javascript:void(0)" class="btn"
												onclick="return DeleteExperinceWishList('<?php echo $productRow->id; ?>','<?php echo $list_details->row()->id; ?>')"><?php if ($this->lang->line('Remove') != '') {
												echo stripslashes($this->lang->line('Remove'));
											} else echo "Remove"; ?></a>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12"><br></div>
							<?php
						}
					}
				} else {
					?>
					<div class="col-md-12"><p class="text-danger"><?php if ($this->lang->line('no_wish_list_exp') != '') {
													echo stripslashes($this->lang->line('no_wish_list_exp'));
												} else echo "No Wish List For Experience"; ?> !</p><br></div>
					
					
					<?php
				} ?>
			</div>
			<?php
		} else {
			?>
			
			
												
			<p class="text-center text-danger"><?php if ($this->lang->line('login_to_view') != '') {
													echo stripslashes($this->lang->line('login_to_view'));
												} else echo "Login to view wish-list"; ?> <a data-toggle="modal" data-target="#signIn" href="#"><?php if ($this->lang->line('Click here') != '') {
													echo stripslashes($this->lang->line('Click here'));
												} else echo "Click here"; ?> !</a></p>
			<?php
		}
		?>
		
		
	</div>
</section>
<!--Edit wish list Modal-->
<div id="EditWishlist" class="modal fade" role="dialog">
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
							<?php echo form_input('list_name', $list_details->row()->name, array("id" => "wishlist_name", "placeholder" => ($this->lang->line('WishListName') != '') ? stripslashes($this->lang->line('WishListName')) : "Wish List Name")); ?>
							<i class="fa fa-heart-o" aria-hidden="true"></i>
						</div>
						<div class="image_box">
						
						
							
							<h5><?php if ($this->lang->line('who_can_se_tit') != '') {
								echo stripslashes($this->lang->line('who_can_se_tit'));
							} else echo "Who can see this Tittle"; ?> ?</h5>
							
							
							<select id="wish_select" name="wish_select">
								<option
									<?php if ($list_details->row()->whocansee == 'Everyone'){ ?>selected="selected"<?php } ?>
									value="0"> <?php if ($this->lang->line('Everyone') != '') {
										echo stripslashes($this->lang->line('Everyone'));
									} else echo "Everyone"; ?> </option>
								<option
									<?php if ($list_details->row()->whocansee == 'Only me'){ ?>selected="selected"<?php } ?>
									value="1"> <?php if ($this->lang->line('Only_Me') != '') {
										echo stripslashes($this->lang->line('Only_Me'));
									} else echo "Only Me"; ?> </option>
							</select>
						</div>
						<input type="hidden" id="list_id" value="<?php echo $list_details->row()->id; ?>"/>
						<a href="javascript:void(0);" onclick="return Edit_WishListCat();"
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
	function Edit_WishListCat() {
		var list_name = $("#wishlist_name").val();
		var list_id = $("#list_id").val();
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
				data: {"list_name": list_name, "whocansee": select, "list_id": list_id},
				dataType: 'json',
				success: function (json) {
					if (json.result == '5') {
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

	function notes_reload(evt) {
		var nid = $(evt).attr("nid");
		var notes = $(evt).val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url(); ?>site/rentals/edit_notes',
			data: {"nid": nid, "notes": notes},
			dataType: 'json',
			success: function (json) {
				if (json.result == '1') {
					//window.location.reload();
				}
				return false;
			}
		});
	}

	/*Delete Rentals from wishlist*/
	function DeleteExperinceWishList(e, t) {
		var a = window.confirm("Are you sure delete the wish list?");
		if (!a) return !1;
		var i = "wish_" + e,
			s = window.location.pathname,
			o = s.substring(s.lastIndexOf("/") + 1);
		$.ajax({
			type: "POST",
			url: BaseURL + "site/experience/DeleteWishList",
			data: {
				pid: e,
				cpage: o,
				wid: t
			},
			dataType: "json",
			success: function (e) {
				"0" == e.result && ($("#" + i).remove(), boot_alert("Wish list deleted successfully"), window.location.reload()), "1" == e.result && ($("#" + i).remove(), boot_alert("Wish list deleted successfully"), window.location.reload())
			}
		})
	}
</script>
<?php
$this->load->view('site/includes/footer');
?>
