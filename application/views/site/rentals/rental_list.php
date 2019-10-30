<link rel="shortcut icon" type="image/x-icon"
         href="<?= base_url(); ?>images/logo/<?php echo $this->config->item('fevicon_image'); ?>">
<div class="loading"></div>
<div class="propertyListHeader">
    <?php
	$this->load->view('site/includes/header');
	?>
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery-ui1.12.1.css">
	<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>css/daterangepicker.css"/>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/daterangepicker.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-ui1.12.1.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.touch-punch.min0.2.3.js"></script>
	<style type="text/css">
		footer {
			display: none;
			z-index: 12;
			position: fixed;
			bottom: 0px;
			width: 100%;
		}
@import url(https://fonts.googleapis.com/css?family=Droid+Sans);
.guestInfo .rightBlock span{border-radius: 37%; width: 50px;height: 27px;}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?php echo base_url();?>images/map_loader.gif') 50% 50% no-repeat rgb(255,255,255);
}
.loading {
  position: fixed;
  z-index: 999;
  height: 2em;
  width: 2em;
  overflow: show;
  margin: auto;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}

/* Transparent Overlay */
.loading:before {
  content: '';
  display: block;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
    background: radial-gradient(rgba(20, 20, 20,.5), rgba(0, 0, 0, .5));

  background: -webkit-radial-gradient(rgba(20, 20, 20,.5), rgba(0, 0, 0,.5));
}

/* :not(:required) hides these rules from IE9 and below */
.loading:not(:required) {
  /* hide "loading..." text */
  font: 0/0 a;
  color: transparent;
  text-shadow: none;
  background-color: transparent;
  border: 0;
}

.loading:not(:required):after {
  content: '';
  display: block;
  font-size: 10px;
  width: 1em;
  height: 1em;
  margin-top: -0.5em;
  -webkit-animation: spinner 1500ms infinite linear;
  -moz-animation: spinner 1500ms infinite linear;
  -ms-animation: spinner 1500ms infinite linear;
  -o-animation: spinner 1500ms infinite linear;
  animation: spinner 1500ms infinite linear;
  border-radius: 0.5em;
  -webkit-box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
box-shadow: rgba(255,255,255, 0.75) 1.5em 0 0 0, rgba(255,255,255, 0.75) 1.1em 1.1em 0 0, rgba(255,255,255, 0.75) 0 1.5em 0 0, rgba(255,255,255, 0.75) -1.1em 1.1em 0 0, rgba(255,255,255, 0.75) -1.5em 0 0 0, rgba(255,255,255, 0.75) -1.1em -1.1em 0 0, rgba(255,255,255, 0.75) 0 -1.5em 0 0, rgba(255,255,255, 0.75) 1.1em -1.1em 0 0;
}

/* Animation */

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-moz-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@-o-keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes spinner {
  0% {
    -webkit-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -ms-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

    header.posHeader.fixedHeader {height: 80px;}
    header.posHeader.fixedHeader nav.navbar {padding: 15px;}
    .listingRow {margin-top: 80px;}
    @media (min-width: 320px) and (max-width: 480px){
    	.listingRow{margin-top: 104px;}
    	.guestFilter, .openFilter.moreFilter, .categoriesBlock{top: 155px;}
    }

	</style>
	<?php
	echo form_open('property', array('method' => 'POST', 'id' => 'search_result_form'));
	$checkin = "";
	$checkout = "";
	$chosed_date = "Dates";
	if ($this->input->post('checkin') != "") {
		$checkin = $this->input->post('checkin');
	}
	if ($this->input->post('checkout') != "") {
		$checkout = $this->input->post('checkout');
	}
	if ($checkin != "" AND $checkout != "") {
		$chosed_date = date('M-d', strtotime($checkin)) . ' - ' . date('M-d', strtotime($checkout));
	}
	echo form_input(array('type' => 'hidden', 'value' => $checkin, 'name' => 'checkin', 'id' => 'exprience_checkin'));
	echo form_input(array('type' => 'hidden', 'value' => '1', 'name' => 'guests', 'id' => 'total_guests'));
	echo form_input(array('type' => 'hidden', 'value' => $checkout, 'name' => 'checkout', 'id' => 'exprience_checkout'));
	echo form_input(array('type' => 'hidden', 'value' => $this->input->get('city'), 'name' => 'city', 'id' => 'searched_city'));
	echo form_input(array('type' => 'hidden', 'value' => '', 'name' => 'min_max_amount', 'id' => 'min_max_amount'));
	echo form_input(array('type' => 'hidden', 'value' => 'ajax_call', 'name' => 'request_type', 'id' => 'request_type'));
	echo form_input(array('type' => 'hidden', 'value' => '1', 'name' => 'page_number', 'id' => 'page_number'));
	echo form_input(array('type' => 'hidden', 'value' => $minLat, 'name' => 'minLat', 'id' => 'minLat'));
	echo form_input(array('type' => 'hidden', 'value' => $minLong, 'name' => 'minLong', 'id' => 'minLong'));
	echo form_input(array('type' => 'hidden', 'value' => $maxLat, 'name' => 'maxLat', 'id' => 'maxLat'));
	echo form_input(array('type' => 'hidden', 'value' => $maxLong, 'name' => 'maxLong', 'id' => 'maxLong'));
	echo form_input(array('type' => 'hidden', 'value' => $lat, 'name' => 'lat', 'id' => 'lat'));
	echo form_input(array('type' => 'hidden', 'value' => $long, 'name' => 'long', 'id' => 'long'));
	?>
	<section>
		<div class="container-fluid bordered">
			<div class="filterBlock clear">
				<div class="backDrop"></div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn" id="config-demo"><?php if ($this->lang->line('dates') != '') {
							echo stripslashes($this->lang->line('dates'));
						} else echo "Dates"; ?></button>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn">
						<input type="text" id='guestCount' value="1" readonly="">
						<?php if ($this->lang->line('guest_s') != '') {
							echo stripslashes($this->lang->line('guest_s'));
						} else echo "Guest"; ?>
					</button>
					<div class="openFilter guestFilter open__filter">
						<div class="guestInfo">
							<div class="rowB clear">
								<div class="leftBlock">
									<p><?php if ($this->lang->line('guest_s') != '') {
											echo stripslashes($this->lang->line('guest_s'));
										} else echo "Guest"; ?></p>
								</div>
								<div class="rightBlock">
									<div class="countBlock">
										<span class="decr" onclick="affectGuestCount('decrease'); chckNumGuestDecS()"> - </span>
										<?php echo form_input('', '1', array('class' => 'guestVal','readonly' => 'readonly')); ?>
										<span class="inc" onclick="affectGuestCount('increase'); chckNumGuestIncS();"> + </span>
									</div>
								</div>
							</div>
							<div class="appCanl clear">
								<button class="applyBtn btn btn-sm btn-success"
										onclick="javascript:reset_page_number();" type="button"><?php if ($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?>
								</button>
								<button class="cancelBtn btn btn-sm btn-default" type="button"><?php if ($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
							</div>
						</div>
					</div>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn">
						<input type="text" id='guestCount' value="1" readonly="">
						<?php if ($this->lang->line('instsant_pay') != '') {
							echo stripslashes($this->lang->line('instsant_pay'));
						} else echo "Instsant Pay"; ?>
					</button>
					<div class="openFilter guestFilter open__filter">
						<div class="guestInfo">
							<div class="rowB clear">
								<div class="leftBlock">
									<div class="_3-w9c"><small>Listings you can book without waiting for host approval.</small></div>
								</div>
								<div class="rightBlock">
									<div class="countBlock">
										<label class="switch">
										<?php 
										$checked = FALSE;
										echo form_checkbox('instant_pay', 'Yes', $checked, $instantpay);
							?>
							<span class="sliderC round"></span>
</label>
									</div>
								</div>
							</div>
							<div class="appCanl clear">
								<button class="applyBtn btn btn-sm btn-success"
										onclick="javascript:reset_page_number();" type="button"><?php if ($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?>
								</button>
								<button class="cancelBtn btn btn-sm btn-default" type="button"><?php if ($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
							</div>
						</div>
					</div>
				</div>
				<div class="filterBtn">
					<button type="button"
							class="toggleBtn filterToggle"><?php $room_type_tiltle=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$room_type_is);
 echo trim($room_type_tiltle); ?> <span class="homeTypeCount"></span></button>
					<div class="openFilter trashHometype">
						<div class="homeType">
							<span class="ToAppendHometypeContent">
							<?php
							$room_count = 0;
if(!empty($roomType)){
							foreach ($roomType->result() as $room_data) {
								if ($room_count < 3) {
									?>
									<label>
                                        <span class="checkboxStyle">
                                            <?php echo form_checkbox('room_type[]', $room_data->id, '', array('class' => 'hideTemp')); ?>
											<i class="fa fa-check" aria-hidden="true"></i>
                                        </span>
										<div class="checkboxRight">
											<div><?php echo $room_data->list_value; ?></div>
										</div>
									</label>
									<?php
								}
							}
						}
							?>
								</span>
						</div>
						<div class="appCanl clear">
							<button class="applyBtn btn btn-sm btn-success" onclick="javascript:reset_page_number();"
									type="button"><?php if ($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?>
							</button>
							<button class="cancelBtn btn btn-sm btn-default" type="button"><?php if ($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
						</div>
					</div>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn filterToggle"><?php if ($this->lang->line('Price') != '') {
							echo stripslashes($this->lang->line('Price'));
						} else echo "Price"; ?></button>
					<div class="openFilter trashPrice" >
						<div class="trashPrice">
							<div class="priceRange">
								<input type="text" id="amount" readonly>
								<p class="reduceFont"><?php if ($this->lang->line('the_average_nightly') != '') { echo stripslashes($this->lang->line('the_average_nightly')); } else echo "The average nightly price is"; ?> <span
										class="number_s"><?php echo $currencySymbol . ' ' . number_format($average, 2); ?>
										.</span>
								</p>


								<div id="slider-range"></div>
							</div>
							<div class="appCanl clear">
								<button class="applyBtn btn btn-sm btn-success"
										onclick="javascript:reset_page_number();" type="button"><?php if ($this->lang->line('Apply') != '') { echo stripslashes($this->lang->line('Apply')); } else echo "Apply"; ?>
								</button>
								<button class="cancelBtn btn btn-sm btn-default" type="button"><?php if ($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
							</div>
						</div>
					</div>
				</div>
				<div class="filterBtn">
					<button type="button" class="toggleBtn"><?php if ($this->lang->line('more_filters') != '') {
							echo stripslashes($this->lang->line('more_filters'));
						} else echo "More Filters"; ?></button>
					<div class="openFilter moreFilter open__filter home__type">
						<div class="appendPriceRange"></div>
						<div class="appendHometype"></div>
						<h5><?php $prop_type_tiltle=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$prop_type_is);
 echo trim($prop_type_tiltle);  ?></h5>
						<div class="checkList">
							<div class="row">
								<?php
								$i = 1;
								foreach ($propertyTypes->result() as $tmp) {
									?>
									<div class="listingResult col-sm-12 <?php echo ($i > 3) ? 'toggleCheckbox' : ''; ?>">
										<label>
                                            <span class="checkboxStyle">
                                                <?php echo form_checkbox('property_type[]', trim($tmp->id), '', array('class' => 'hideTemp')); ?>
												<i class="fa fa-check" aria-hidden="true"></i>
                                            </span>
											<div class=""><?php echo $tmp->list_value; ?></div>
										</label>
									</div>
									<?php
									$i++;
								}
								if ($propertyTypes->num_rows() > 4) {
									?>
									<a href="#" class="allcheckBox"><?php if ($this->lang->line('see_all_amenities') != '') {
							echo stripslashes($this->lang->line('see_all_amenities'));
						} else echo "See all amenities"; ?> <span class="arrow"> > </span>
									</a>
									<?php
								}
								?>
							</div>


						</div>
						<?php
						foreach ($main_cat as $category) {
							$sec_categ_loop_count = count($sec_category[$category->id]);
							if ($sec_categ_loop_count != 0 && $category->id != 12) {
								?>
								<div class="divider"></div>
								<h5><?php echo ucfirst($category->attribute_name); ?></h5>
								<div class="checkList">
									<div class="row">
										<?php
										$sub_cats = 1;
										foreach ($sec_category[$category->id] as $subcat) {
											if ($subcat['list_value'] != '') {
												?>
												<div
													class="listingResult col-sm-12 <?php echo ($sub_cats > 4) ? 'toggleCheckbox' : ''; ?>">
													<label>
                                                <span
													class="checkboxStyle <?php echo ($list_value_loop > 4) ? 'toggleCheckbox' : ''; ?>">
                                                    <?php echo form_checkbox('listvalue[]', $subcat['id'], '', array('class' => 'hideTemp')); ?>
													<i class="fa fa-check" aria-hidden="true"></i>
                                                </span>
														<div class=""><?php echo $subcat['list_value']; ?></div>
													</label>
												</div>
												<?php
											}
											$sub_cats++;
										}
										if (count($sec_category[$category->id]) > 4) {
											?>
											<a href="#" class="allcheckBox"><?php if ($this->lang->line('see_all_house_rules') != '') { echo stripslashes($this->lang->line('see_all_house_rules')); } else echo "See all house rules"; ?>
                                                <span class="arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
											</a>
										<?php } ?>
									</div>
								</div>
								<?php
							}
						}
						?>



						<div class="divider"></div>
						<div class="ApplyBottom">
							<button class="cancelFilter" type="button"><?php if ($this->lang->line('Cancel') != '') { echo stripslashes($this->lang->line('Cancel')); } else echo "Cancel"; ?></button>
							<button class="seeHomes applyBtn" type="button" onclick="javascript:reset_page_number();">
								<?php if ($this->lang->line('see_homes') != '') { echo stripslashes($this->lang->line('see_homes')); } else echo "See Homes"; ?>
							</button>



						</div>
					</div>
				</div>
				<div class="filterBtn"><button onclick="window.location.reload();" type="button" class="toggleBtn"><?php if ($this->lang->line('reset') != '') {
							echo stripslashes($this->lang->line('reset'));
						} else echo "Reset Filters"; ?></button></div>
			</div>
		</div>
	</section>
	<?php echo form_close(); ?>
</div>
<section class="proListing">
	<div class="container-fluid">
		<div class="listingRow">
			<div class="propertyListing">
				<div class="row" id="property_listing">
				</div>
				<div>
					<div id="ajax-load" style="display:none;">
						<p class="text-center"><i class="fa fa-spinner fa-spin"></i> <?php if ($this->lang->line('loading') != '') { echo stripslashes($this->lang->line('loading')); } else echo "Loading"; ?>...</p>
					</div>
					<div class="myPagination" id="page_numbers">
						<?php
						echo $pages;
						?>
					</div>
					<div class="text-center h7">
						<span class="number_s120" id="num_of_results_showing">
							<?php
							//print_r($totalShowed);
							//print_r($productList);
							 if ($totalShowed > 0) {
								echo $Start + 1; ?> – <?php echo $Start + $totalShowed;
							} else {
								echo 0;
							} ?>  </span> <?php if ($this->lang->line('of') != '') { echo stripslashes($this->lang->line('of')); } else echo "of"; ?>
						<span class="number_s120" id="total_results">
							<?php echo $total_pages; ?>
						</span> <?php if ($this->lang->line('rentals') != '') { echo stripslashes($this->lang->line('rentals')); } else echo "Rentals"; ?>
					</div>


				</div>
				<div class="mapListing">
					<div id="map_result" style="height: 100%;">
					</div>
				</div>
			</div>
		</div>
</section>
<button class="toggleFooter"><i class="fa fa-globe" aria-hidden="true"></i> <?php if ($this->lang->line('language_currency') != '') { echo stripslashes($this->lang->line('language_currency')); } else echo "Language and Currency"; ?></button>
<?php
$this->load->view('site/includes/footer');
?>
<script>
    var markers = [];
	$(document).ready(function () {
	 $('.loading').fadeOut();
		// $('.loading').show();
		function carouselFunc() {
			$('.listing-carousel').owlCarousel({
				loop: true,
				margin: 10,
				responsiveClass: true,
				responsive: {
					0: {
						items: 1,
						nav: true
					},
					480: {
						items: 1,
						nav: true
					},
					800: {
						items: 1,
						nav: true
					},
					1200: {
						items: 1,
						nav: true,
						loop: true,
						margin: 16
					}
				}
			});
		}

		carouselFunc();

		$(".wishList_I, .wishList_I.yes").show();


		$("body").click(function (e) {
			if ($(e.target).is(".applyBtn")) {
				$(".filterBtn.active").addClass("chooseFilter");
			}
			if (!$(e.target).closest(".filterBtn.active").length == 1 && !$(e.target).closest(".daterangepicker").length == 1 && !$(e.target).closest(".next.available, .prev.available").length == 1) {
				console.log($(e.target.length));
				$(".backDrop").hide();
				$(".filterBtn").removeClass("active");
			}
			if ($(e.target).is(".cancelBtn, .applyBtn, .cancelFilter, .seeHomes")) {
				$(".filterBtn").removeClass("active");
				$(".backDrop").hide();
			}
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
			$('body').addClass("date__picker");

		});

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
				get_filter_result();
			});
		}


		$(document).on("click", ".allcheckBox", function () {
			$(this).children(".arrow").toggleClass("active");
			$(this).prevAll(".toggleCheckbox").slideToggle(200);
		});


	});


	function affectGuestCount(mode, select) {
		$existVAl = Number($(".guestVal").val());
		if (mode == 'increase') {

			$("#guestCount").show();
			if ($existVAl < <?php echo $accommodates; ?>) {
				$("#guestCount").val($existVAl + 1);
				$(".guestVal").val($existVAl)
				$("#total_guests").val($existVAl + 1);
			}
		}
		if (mode == 'decrease') {
			if ($existVAl !=1  && $(select).next().val() != 1) {
				$("#guestCount").val($existVAl - 1);
				$(".guestVal").val($existVAl - 1)
				$("#total_guests").val($existVAl - 1);
			}
		}
	}



	function chckNumGuestIncS(){
        $existValue = Number($(".guestVal").val());
         var NumOfGuest='<?php echo $accommodates; ?>';
        if ($existValue==NumOfGuest){
            $(".inc").css('display','none');
        }else{
            $(".inc").css('display','block');
        }
    }

	 function chckNumGuestDecS() {
        $(".inc").css('display','block');
    }


	$("input[name='homeType']").change(function () {
		var homeTypeLen = $("input[name='homeType']:checked").length;

		if (homeTypeLen > 0) {
			$(".homeTypeCount").html(homeTypeLen);
			$(".homeTypeCount").show();
		}
		else {
			$(".homeTypeCount").hide();
		}
	});

	$(window).on("resize", function () {
		if (screen.width < 768) {
			$(".trashPrice").html('');
			$(".appendPriceRange").html('<h5> Price Range</h5> <div class="priceRange"><input type="text" id="amount" readonly><p class="reduceFont">The average nightly price is <span class="number_s"><?php echo $currencySymbol . " " . number_format($average, 2); ?>.</span></p><div id="slider-range"></div></div> <div class="divider"></div>');
			var HomeType = $('.ToAppendHometypeContent').html();
			$(".appendHometype").html('<h5> Home Type</h5> <div class="homeType">' + HomeType + '</div><div class="divider"></div>');
			$("#slider-range").slider({
				range: true,
				min: <?php echo round($minimum_price,2); ?>,
			max: <?php echo round($maximum_price,2); ?>,
				values: [<?php echo round($minimum_price, 2); ?>, <?php echo round($maximum_price, 2); ?>],
				slide: function (event, ui) {
					$("#amount").val("<?php echo $currencySymbol; ?>" + ui.values[0] + " - <?php echo $currencySymbol; ?>" + Math.ceil(ui.values[1]));
					$("#min_max_amount").val(ui.values[0] + "-" + ui.values[1]);
				}
			});
		}
		$("#slider-range").slider({
			range: true,
			min: <?php echo round($minimum_price,2); ?>,
			max: <?php echo round($maximum_price,2); ?>,
			values: [<?php echo round($minimum_price, 2); ?>, <?php echo round($maximum_price, 2); ?>],
			slide: function (event, ui) {
				$("#amount").val("<?php echo $currencySymbol; ?>" + ui.values[0] + " - <?php echo $currencySymbol; ?>" + Math.ceil(ui.values[1]));
				$("#min_max_amount").val(ui.values[0] + "-" + ui.values[1]);
			}
		});

	}).resize();

	/*============== Start of map related functions =============*/
	/*Intilizing*/
	var locations = [<?php echo $productList; ?>];
	var map_mode =[{elementType: 'geometry', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
            {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
            {
              featureType: 'administrative.locality',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'geometry',
              stylers: [{color: '#263c3f'}]
            },
            {
              featureType: 'poi.park',
              elementType: 'labels.text.fill',
              stylers: [{color: '#6b9a76'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry',
              stylers: [{color: '#38414e'}]
            },
            {
              featureType: 'road',
              elementType: 'geometry.stroke',
              stylers: [{color: '#212a37'}]
            },
            {
              featureType: 'road',
              elementType: 'labels.text.fill',
              stylers: [{color: '#9ca5b3'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry',
              stylers: [{color: '#746855'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'geometry.stroke',
              stylers: [{color: '#1f2835'}]
            },
            {
              featureType: 'road.highway',
              elementType: 'labels.text.fill',
              stylers: [{color: '#f3d19c'}]
            },
            {
              featureType: 'transit',
              elementType: 'geometry',
              stylers: [{color: '#2f3948'}]
            },
            {
              featureType: 'transit.station',
              elementType: 'labels.text.fill',
              stylers: [{color: '#d59563'}]
            },
            {
              featureType: 'water',
              elementType: 'geometry',
              stylers: [{color: '#17263c'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.fill',
              stylers: [{color: '#515c6d'}]
            },
            {
              featureType: 'water',
              elementType: 'labels.text.stroke',
              stylers: [{color: '#17263c'}]
            }];
            var hr = (new Date()).getHours();
            if(hr < 18){
            	map_mode = [];
            }
            
	var myOptions = {
		zoom: 6,
		zoomControlOptions: {
			position: google.maps.ControlPosition.RIGHT_CENTER
		},
		center: new google.maps.LatLng(<?php echo $lat; ?>, <?php echo $long; ?>),
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		styles:map_mode

	}
	var map = new google.maps.Map(document.getElementById("map_result"), myOptions);
	var sw = new google.maps.LatLng(<?php echo $minLat;?>, <?php echo $minLong;?>);
	var ne = new google.maps.LatLng(<?php echo $maxLat;?>, <?php echo $maxLong;?>);
	var bounds = new google.maps.LatLngBounds(sw, ne);
	/*Remove the below comment to initially fit the boundary of search location.Note : it will trigger the ajax function for first time.*/
	map.fitBounds(bounds);
	google.maps.event.addListener(map, 'dragend', function () {
		var bounds = map.getBounds();
		getBounds(bounds);
		get_filter_result();
	});
	google.maps.event.addListener(map, 'zoom_changed', function () {
		var bounds = map.getBounds();
		getBounds(bounds);
		get_filter_result();
	});
	/*calling Set marker  function*/
	var markers_map = [];
	setMarkers(map, locations);
	/*Close of -map intilization*/
    /*Loading wishlist form for experience*/

	/*Settting marker for result*/

	function setMarkers(map, locations) {
		
        remove_marker();
		if (locations.length > 0) {
			$('#property_listing').html('');
			var svg_is = '<svg fill="currentColor" preserveAspectRatio="xMidYMid meet" height="1em" width="1em" viewBox="0 0 40 40" class="svg_instsant_pay" style="vertical-align: middle;"><g><path d="m29.8 12.6q0.4 0.5 0.1 1l-12 25.8q-0.3 0.6-1 0.6-0.1 0-0.3 0-0.4-0.2-0.6-0.5t-0.1-0.6l4.4-18.1-9 2.3q-0.1 0-0.3 0-0.4 0-0.7-0.2-0.4-0.4-0.3-0.9l4.5-18.4q0.1-0.3 0.4-0.5t0.6-0.2h7.3q0.4 0 0.7 0.2t0.3 0.7q0 0.2-0.1 0.4l-3.8 10.3 8.8-2.2q0.2 0 0.3 0 0.4 0 0.8 0.3z"></path></g></svg>';
            var lat_lang_inc= 0.0000;
			for (var i = 0; i < locations.length; i++) {
				var location = locations[i];
				//console.log(location[10]);

                location[1]= parseFloat(Number(location[1])).toFixed(4);
                location[2]= parseFloat(Number(location[2])).toFixed(4);
                if(i != 0){
                    location[1] = parseFloat(Number(location[1]))+lat_lang_inc;
                    location[2] = parseFloat(Number(location[2]))+lat_lang_inc;
                    location[1]= location[1].toFixed(4);
                    location[2]= location[2].toFixed(4);
                }
                if(location[12] != 'Yes'){
                	svg_is = '';
                }
                lat_lang_inc= lat_lang_inc+0.0111;

				var coords = new google.maps.LatLng(location[1], location[2]);
				var contentString = '<div class="listingResult col-md-4 col-sm-4">\n';
				if (location[10] != "") {
					contentString += '		<div class="wishList_I" ' + location[10] + ' style="display:block;"></div>\n';
				} else {
					contentString += '		<div class="wishList_I yes" style="display:block;"></div>\n';
				}
				contentString += '                               <div class="owl-carousel show owl-theme listing-carousel">\n';
				var images = location[8].split(',');
				images.forEach(function (image) {
					contentString +=
						'                                    <div class="item">\n' +
						'                                        <a href="<?php echo base_url();?>rental/' + location[9] + '">\n' +
						'                                            <div class="myPlace" style="background-image: url(\'<?php echo base_url(); ?>images/rental/' + image + '\')"></div>\n' +
						'                                        </a>\n' +
						'                                    </div>\n' +
						'\n';
				});
				contentString += ' ' +
					'                                </div>\n' +
					'                                <div class="bottom">\n' +
					'                                    <div class="loc">' + location[11] + location[4] + '</div>\n' +
					'                                    <h5>' + location[0] + '</h5>\n' +
					'                                    <div class="price"><span class="number_s"> <?php echo $currencySymbol; ?>' + location[7] + ' </span>'+svg_is+'</div>\n' +
					'                                    <div class="clear">\n' +
					'                                        <div class="starRatingOuter">\n' +
					'                                            <div class="starRatingInner" style="width: ' + location[6] + '%;"></div>\n' +
					'                                        </div>\n' +
					'                                        <span class="ratingCount">' + location[5] + '</span>\n' +
					'                                    </div>\n' +
					'                                </div>\n' +
					'                            </div>';


				var contentStringMap = '<div class="listingResult sliderInMap">\n';
				if (location[10] != "") {
					contentStringMap += '		<div class="wishList_I" ' + location[10] + ' style="display:block;"></div>\n';
				} else {
					contentStringMap += '		<div class="wishList_I yes" style="display:block;"></div>\n';
				}

image=(images[0]) ? images[0] : '';
				contentStringMap += '                               <div class="owl-carousel show owl-theme">\n';
				// images.forEach(function (image) {
					contentStringMap +=
						'                                    <div class="item">\n' +
						'                                        <a href="<?php echo base_url();?>rental/' + location[9] + '">\n' +
						'                                            <div class="myPlace" style="background-image: url(\'<?php echo base_url(); ?>images/rental/' + image + '\')"></div>\n' +
						'                                        </a>\n' +
						'                                    </div>\n' +
						'\n';
				/*});*/
				contentStringMap += ' ' +
					'\n' +
					'                                </div>\n' +
					'                                <div class="bottom">\n' +
					'                                    <div class="loc">' + location[11] +  location[4] + '</div>\n' +
					'                                    <h5>' + location[0] + '</h5>\n' +
					'                                    <div class="price"><span class=""> <?php echo $currencySymbol; ?>' + location[7] + ' </span></div>\n' +
					'                                    <div class="clear">\n' +
					'                                        <div class="starRatingOuter">\n' +
					'                                            <div class="starRatingInner" style="width: ' + location[6] + '%;"></div>\n' +
					'                                        </div>\n' +
					'                                        <span class="ratingCount">' + location[5] + '</span>\n' +
					'                                    </div>\n' +
					'                                </div>\n' +
					'                            </div>';

				$('#property_listing').append(contentString);
				var price_width = getTextWidth(location[7], "bold 12pt arial");
				var infowindow = new google.maps.InfoWindow({content: contentStringMap, maxWidth: 300});

				carouselFunc();
				google.maps.event.addListener(infowindow, 'domready', function () {
					//infowindow.close();
					var iwOuter = $('.gm-style-iw');
					var iwBackground = iwOuter.prev();
					iwBackground.children(':nth-child(2)').css({'display': 'none'});
					iwBackground.children(':nth-child(4)').css({'display': 'none'});
					
				});


				var marker = new google.maps.Marker({
					position: coords,
					map: map,
					label: {
						text: '<?php echo $currencySymbol; ?> ' + location[7],
						color: 'white'
					},
					icon: {
						url: '<?php echo base_url(); ?>images/mapIcons/price-label.png',
						scaledSize: new google.maps.Size(price_width, 35)
					},
					title: location[0],
					zIndex: location[3]
				});
				markers_map.push(marker);
                var lastOpenedInfoWindow = '';
				google.maps.event.addListener(marker, 'click',
					function (infowindow, marker) {
						return function () {
                            closeLastOpenedInfoWindow();
                            infowindow.open(map, marker);
                            lastOpenedInfoWindow = infowindow;
                            // carouselFunc();

						};
					}(infowindow, marker)
				);

                function closeLastOpenedInfoWindow() {
                   // $(".ui-tooltip").is(":visible").find('').hide();
                    if (lastOpenedInfoWindow) {
                        lastOpenedInfoWindow.close();
                    }
                }

				google.maps.event.addListener(map, "click",
					function (infowindow, marker) {
						return function () {
							infowindow.close();
						};
					}(infowindow, marker)
				);

			}
		} else {
            
			 <?php if ($this->lang->line('No rentals Found') != '') { $rentals=stripslashes($this->lang->line('No rentals Found')); } else $rentals= "No rentals Found" ; ?>
			$('#property_listing').html('');
			$('#property_listing').append('<p class="text-danger text-center"> <?php echo $rentals ?></p>')
		}


	}
    function remove_marker() {
        for(i=0; i<markers_map.length; i++){
            markers_map[i].setMap(null);
        }
    }
	/*Close of setmarker function*/

	/*Getting text width for marker label*/
	function getTextWidth(text, font) {
		var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
		var context = canvas.getContext("2d");
		context.font = font;
		var metrics = context.measureText(text);
		return Math.round(metrics.width) + 15;
	}

	/*Reset pagenumber for every page request(for fetching correct result)*/
	function reset_page_number() {
		$('#page_number').val(1);
		get_filter_result()
	}

	/*Ajax function for getting filter result*/
	var mapIntilized = 0;

	function get_filter_result() {
		
		/*This condition is to remove 1st unwanted ajax call. because set bounds trigger map dragend option..*/
		if (mapIntilized != 0) {
			$.ajax(
				{
					url: '<?php echo base_url(); ?>property',
					data: $("#search_result_form").serialize(),
					type: 'post',
					beforeSend: function () {
						$('#property_listing').html('');
						$('#ajax-load').show();
					}
				})
				.done(function (data) {
					/*console.log(data);*/
					var locations = JSON.parse(data);
					$('#page_numbers').html(locations.pages);
					$('#num_of_results_showing').html(locations.Start);
					$('#total_results').html(locations.searchPerPage);
					setMarkers(map, locations.property);
					$('#ajax-load').hide();
				});
		}
		mapIntilized++;
	}

	/*Getting map boundary for ajax request*/
	function getBounds(bounds) {
		$('#minLat').val(bounds.getSouthWest().lat());
		$('#minLong').val(bounds.getSouthWest().lng());
		$('#maxLat').val(bounds.getNorthEast().lat());
		$('#maxLong').val(bounds.getNorthEast().lng());
		$('#cLat').val(bounds.getCenter().lat());
		$('#cLong').val(bounds.getCenter().lng());
	}

	/*============== End for map related functions =============*/

	function carouselFunc() {
		$('.listing-carousel').owlCarousel({
			loop: true,
			margin: 10,
			responsiveClass: true,
			responsive: {
				0: {
					items: 1,
					nav: true
				},
				480: {
					items: 1,
					nav: true
				},
				800: {
					items: 1,
					nav: true
				},
				1200: {
					items: 1,
					nav: true,
					loop: true,
					margin: 16
				}
			}
		});
	}

	function create_page(page_number) {
		$('#page_number').val(page_number);
		get_filter_result();
	}

	$('.range_inputs .applyBtn').click(function () {
		boot_alert("The paragraph was clicked.");
	});

</script>
