<div class="propertyListHeader">
	<?php		
	$this->load->view('site/includes/header');
	$currency_result = $this->session->userdata('currency_result');
	?>
	<link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker.css"/>
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/daterangepicker.js"></script>
	<style type="text/css">
		/* .daterangepicker {
			top: 135px !important;
		} */
		.experience .listings {
			margin-top: 10px;
		}
        #search_result_form {display: block;}
        .propertyListHeader {position: relative;}
	</style>
	<?php
	echo form_open('explore-experience', array('method' => 'POST', 'id' => 'search_result_form'));
	/*Total pages to load*/
	$data = array(
		'type' => 'hidden',
		'id' => 'page_number',
		'name' => 'page_number',
		'value' => 1
	);
	echo form_input($data);
	/*Close total pages */
	?>
    <section class="loggedBg">
        <div class="container">
            <ul class="loginMenu">
                <li><a href="<?php echo base_url(); ?>explore_listing" <?php if ($this->uri->segment(1) == 'explore_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('places_up') != '') { echo stripslashes($this->lang->line('places_up')); } else echo "PLACES"; ?></a></li>
                <li><a href="<?php echo base_url(); ?>explore-experience" <?php if ($this->uri->segment(1) == 'explore-experience') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('EXPERIENCE') != '') { echo stripslashes($this->lang->line('EXPERIENCE')); } else echo strtoupper("EXPERIENCE"); ?></a></li>
				<li><a href="<?php echo base_url(); ?>all_listing" <?php if ($this->uri->segment(1) == 'all_listing') { ?> class="active" <?php } ?>> <?php if ($this->lang->line('All') != '') { echo stripslashes($this->lang->line('All')); } else echo strtoupper("All"); ?></a></li>
            </ul>
        </div>
    </section>

	<section>
		<div class="container bordered experience ">
			<div class="filterBlock clear">
				<div class="backDrop"></div>
				<div class="filterBtn">
					<?php
					$checkin = "";
					$checkout =  "";

					if ($this->lang->line('dates') != '') {
							$chosed_date =  stripslashes($this->lang->line('dates'));
						} else $chosed_date =  "Dates"; 
					if ($this->input->post('checkin') != "") {
						$checkin = $this->input->post('checkin');
					}
					if ($this->input->post('checkout') != "") {
						$checkout = $this->input->post('checkout');
					}
					if ($checkin != "" AND $checkout != "") {
						$chosed_date = date('M-d', strtotime($checkin)) . ' - ' . date('M-d', strtotime($checkout));
					}
					?>
					<button type="button" class="toggleBtn" id="config-demo"><?php echo $chosed_date; ?></button>
					<?php
					echo form_input(array('type' => 'hidden', 'value' => $checkin, 'name' => 'checkin', 'id' => 'exprience_checkin'));
					echo form_input(array('type' => 'hidden', 'value' => $checkout, 'name' => 'checkout', 'id' => 'exprience_checkout'));
					echo form_input(array('type' => 'hidden', 'value' => $minLat, 'name' => 'minLat', 'id' => 'minLat'));
					echo form_input(array('type' => 'hidden', 'value' => $maxLat, 'name' => 'maxLat', 'id' => 'maxLat'));
					echo form_input(array('type' => 'hidden', 'value' => $minLong, 'name' => 'minLong', 'id' => 'minLong'));
					echo form_input(array('type' => 'hidden', 'value' => $maxLong, 'name' => 'maxLong', 'id' => 'maxLong'));
					?>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn filterToggle"><?php if ($this->lang->line('Type') != '') {
							echo stripslashes($this->lang->line('Type'));
						} else echo "Type"; ?> <span class="homeTypeCount"></span></button>
					<div class="openFilter trashHometype">
						<div class="homeType">
							<?php if ($_POST['category'] != '') {
								if (in_array(1, $_POST['category'])) {
									$checked = 'true';
								} else {
									$checked = '';
								}
							} ?>
							<label>
		        			<span class="checkboxStyle">
                                <?php echo form_checkbox('category[]', '1', $checked, array("class" => "hideTemp")); ?>
								<i class="fa fa-check" aria-hidden="true"></i>
			        		</span>
								<div class="checkboxRight">
									<div><?php if ($this->lang->line('immersions') != '') {
											echo stripslashes($this->lang->line('immersions'));
										} else echo "Immersions"; ?></div>
									<p class="reduceFont"><?php if ($this->lang->line('happen_over_days') != '') {
											echo stripslashes($this->lang->line('happen_over_days'));
										} else echo "Happen over multiple days"; ?></p>
								</div>
							</label>
							<?php if ($_POST['category'] != '') {
								if (in_array(2, $_POST['category'])) {
									$checked = 'true';
								} else {
									$checked = '';
								}
							}
							?>
							<label>
		        			<span class="checkboxStyle">
                                <?php echo form_checkbox('category[]', '2', $checked, array("class" => "hideTemp")); ?>
								<i class="fa fa-check" aria-hidden="true"></i>
			        		</span>
								<div class="checkboxRight">
									<div><?php if ($this->lang->line('experiences') != '') {
											echo stripslashes($this->lang->line('experiences'));
										} else echo "Experiences"; ?></div>
									<p class="reduceFont"><?php if ($this->lang->line('last_two_hours') != '') {
											echo stripslashes($this->lang->line('last_two_hours'));
										} else echo "Last 2 or more hours"; ?></p>
								</div>
							</label>
						</div>
						<div class="appCanl clear">
							<button type="submit" class="applyBtn btn btn-sm btn-success"
									type="button"><?php if ($this->lang->line('Apply') != '') {
									echo stripslashes($this->lang->line('Apply'));
								} else echo "Apply"; ?></button>

							<button class="cancelBtn btn btn-sm btn-default" type="button"><span
									class="cancel"><?php if ($this->lang->line('Cancel') != '') {
									echo stripslashes($this->lang->line('Cancel'));
								} else echo "Cancel"; ?></button>

						</div>
					</div>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn"><?php if ($this->lang->line('category') != '') {
							echo stripslashes($this->lang->line('category'));
						} else echo "Category"; ?></button>
					<div class="openFilter categoriesBlock category__block">
						<div class="checkList">
							<div class="row">
								<?php if ($experienceType->num_rows() > 0) {
									foreach ($experienceType->result() as $type) {
										if ($_POST['type_id'] != '') {
											$checked = '';
											if (in_array($type->id, $_POST['type_id'])) {
												$checked = 'true';
											}
										}
										?>
										<div class="chkboxStyle">
											<label>
                                                <span class="checkboxStyle">
                                                    <?php echo form_checkbox('type_id[]', $type->id, $checked, array("class" => "hideTemp")); ?>
													<i class="fa fa-check" aria-hidden="true"></i>
                                                </span>
												<div class=""><?php echo ucfirst($type->experience_title); ?></div>
											</label>
										</div>
										<?php
									}
								} else {
									echo "No Category Added...!";
								} ?>
								<div class="appCanl clear cat">
									<button type="submit" class="applyBtn btn btn-sm btn-success"
											type="button"><?php if ($this->lang->line('Apply') != '') {
											echo stripslashes($this->lang->line('Apply'));
										} else echo "Apply"; ?></button>
									<button class="cancelBtn btn btn-sm btn-default"
											type="button"><?php if ($this->lang->line('Cancel') != '') {
											echo stripslashes($this->lang->line('Cancel'));
										} else echo "Cancel"; ?></button>
								</div>
							</div>
						</div>
						<div class="appendHometype"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php echo form_close(); ?>
</div>
<section>
	<div class="container experience">
		<div class="row listings" id="property_listings">
			<?php				
			if ($product->num_rows() > 0) {
				//print_r($product->result_array());
				foreach ($product->result_array() as $product_image) {
					?>
					<div class="col-sm-4 col-md-3" style='margin-top:25px;'>
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

										$prod_tiltle=language_dynamic_enable("type_title",$this->session->userdata('language_code'),(object)$product_image);
                                            //echo ucfirst($prod_tiltle);

                                            echo $prod_tiltle. "  " .$product_image['city'];
											/*echo $product_image['type_title'] . " . " .$product_image['city'];*/
										}else if ($product_image['type_title']!=''){
											echo $product_image['type_title'];
										}else if ($product_image['city']!=''){
											echo $product_image['city'];
										}

									?>

									</div>
									<h5><?php
									//	echo ucfirst($product_image['experience_title']);
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
											?></span><span style="font-size:14px;"><?php if ($this->lang->line('per_person') != '') {
												echo stripslashes($this->lang->line('per_person'));
											} else echo "per person"; ?></span>
									</div>
									<div class="clear">
										<div class="starRatingOuter">
											<?php
											$avg_val = $num_reviewers = 0;
											if ($product_image['experience_id'] != '') {
												$id = $product_image['experience_id'];
												$res = $controller->get_review_exp($id);
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
					<p class="text-center text-danger" style="margin:35px;"><?php if ($this->lang->line('No more experience found!') != '') { echo stripslashes($this->lang->line('No more experience found!'));} else echo "No more experience found!"; ?></p>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>
<section>
	<div class="container">
		<div class="row">
			<p id="ajax-load" style="display: none;"> Loading</p>
		</div>
	</div>
</section>
<?php
$this->load->view('site/includes/footer');
?>
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
					items: 4,
					nav: true,
					loop: false,
					margin: 16
				}
			}
		});
	});

	$(document).on("click", ".toggleBtn", function () {
		$(".backDrop").toggle();

		if ($(this).is("#config-demo") && $(this).parent(".filterBtn").hasClass("active")) {

			$(".daterangepicker").hide();
		}
		else if ($(this).is("#config-demo")) {
			$(".daterangepicker").show();
		}
		$(".filterBtn").not($(this).parent(".filterBtn")).removeClass("active");
		$(this).parent(".filterBtn").toggleClass("active");

	});


	$("body").click(function (e) {

		if ($(e.target).is(".applyBtn")) {
			$(".filterBtn.active").addClass("chooseFilter");
		}

		if (!$(e.target).closest(".filterBtn.active").length == 1 && !$(e.target).closest(".daterangepicker").length == 1 && !$(e.target).closest(".next.available, .prev.available").length == 1) {

			$(".backDrop").hide();
			$(".filterBtn").removeClass("active");
		}
		if ($(e.target).is(".cancelBtn, .applyBtn, .cancelFilter, .seeHomes")) {
			$(".filterBtn").removeClass("active");
			$(".backDrop").hide();
		}

	});

	$(window).on("resize", function () {
		if (screen.width < 768) {

			$(".trashHometype").html('');
			$(".appendHometype").html('<div class="divider"></div> <h5> Type</h5> <div class="homeType"><label>	     			<span class="checkboxStyle">     				<input type="checkbox" name="homeType" class="hideTemp">		<i class="fa fa-check" aria-hidden="true"></i>			        		</span>			        		<div class="checkboxRight">			        			<div>Entire place</div> <p class="reduceFont">Have a place to yourself</p>			        		</div>		        		</label>			<label>		        			<span class="checkboxStyle">		        				<input type="checkbox" name="homeType" class="hideTemp"><i class="fa fa-check" aria-hidden="true"></i></span>			        		<div class="checkboxRight"><div>Private room</div>			        			<p class="reduceFont">Have your own room and share some common spaces</p>			        		</div></label><label>     			<span class="checkboxStyle">		        				<input type="checkbox" name="homeType" class="hideTemp">			        			<i class="fa fa-check" aria-hidden="true"></i></span>			        		<div class="checkboxRight"><div>Shared room</div><p class="reduceFont">Stay in a shared space, like a common room</p> </div></label></div> <div class="divider"></div>');


		}
	}).resize();

	updateConfig();

	function updateConfig() {
		var options = {
			"startDate": "<?php echo date('d-m-y', strtotime($checkin)); ?>",
			"endDate": "<?php echo date('d-m-y', strtotime($checkout)); ?>",
			"minDate": new Date(),
			"locale": {
				format: 'DD-MM-YYYY'
			}
		};

		$('#config-demo').daterangepicker(options, function (start, end, label) {
			$('#config-demo').text(start.format('MMM-DD') + ' - ' + end.format('MMM-DD'));
			$("#exprience_checkin").val(start.format('YYYY-MM-DD'));
			$("#exprience_checkout").val(end.format('YYYY-MM-DD'));
			$("#search_result_form").submit();
		});
	}

	/*Scroll loading pages*/
	var page = $('#page_number').val();
	$(window).scroll(function () {
		if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
			if (page <= <?php echo $total_pages; ?>) {
				loadMoreData(page);
			}
			page++;
			$('#page_number').val(page);
		}
	});

	function loadMoreData(page) {
		$.ajax(
			{
				url: '<?php echo base_url(); ?>explore-experience?page=' + page,
				data: $("#search_result_form").serialize(),
				type: 'post',
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
