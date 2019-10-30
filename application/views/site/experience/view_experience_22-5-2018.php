<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
$product = $productDetails->row();
?>
<section>
	<div class="container experiencePage">
		<div class="row">
			<div class="detailLeft">
				<h2 class="text-capitalize"><?php echo $product->experience_title; ?></h2>
				<p><a href="#goToLoc"
					  class="medium_W goToLoc"><?= $product->city; ?></a> <?php if ($product->exp_tagline != '') {
						echo ' . ' . $product->exp_tagline;
					} ?></p>
				<div class="divider"></div>
				<div class="title" id="overview">
					<div class="left">
						<div class="text-capitalize"><?php echo $product->type_title; ?></div>
						<div><?php if ($this->lang->line('hosted_by') != '') { echo stripslashes($this->lang->line('hosted_by')); } else echo "Hosted by"; ?>				
						<a href="<?php echo ($product->user_id > 0 && $product->user_id != '') ? base_url() . 'users/show/' . $product->user_id : '#'; ?>" target="_blank"><?php echo ($product->user_id > 0 && $product->user_id != '') ? $product->firstname : 'Administrator'; ?></a>
						</div>
					</div>
					<div class="right">
						<img
							src="<?php if ($product->thumbnail != "" && file_exists('./images/users/' . $product->thumbnail)) {
								echo base_url() . 'images/users/' . $product->thumbnail;
							} else {
								echo base_url() . 'images/users/profile.png';
							} ?>">
					</div>
				</div>
				
				<?php if ($this->lang->line('Days') != '') { $days= stripslashes($this->lang->line('Days')); } else $days= "Days"; ?>
				
				<?php if ($this->lang->line('hours') != '') { $hours= stripslashes($this->lang->line('hours')); } else $hours= "Hours"; ?>
				
				<?php if ($this->lang->line('hour') != '') { $hour= stripslashes($this->lang->line('hour')); } else $hour= "Hour"; ?>
				
				<div class="exp features">
					<ul class="clear">
						<li><i class="fa fa-clock-o"
							   aria-hidden="true"></i> <?php if ($product->date_count > 1) {
								echo $product->date_count . " $days";
							} else {
								echo $product->total_hours;
								echo ($product->total_hours > 1) ? " $hours "  : " $hour";
							}
							?></li>
						<?php if ($kit_content->num_rows() > 0) { ?>
							<li><i class="fa fa-bookmark" aria-hidden="true"></i>
								<?php
								$i = 1;
								foreach ($kit_content->result() as $kit) {
									if ($kit->kit_count > 0) echo $kit->kit_count . ' ';
									echo $kit->kit_title;
									echo ($i == $kit_content->num_rows()) ? '.' : ', ';
									$i++;
								}
								?>
							</li>
							<?php
						}
						?>
						
						
						<?php if ($this->lang->line('not_done') != '') { $not_done= stripslashes($this->lang->line('not_done')); } else $not_done= "Not done"; ?>
											
						
						<li><i class="fa fa-comments-o" aria-hidden="true"></i> <?php if ($this->lang->line('offered_in') != '') { echo stripslashes($this->lang->line('offered_in'));
											} else echo "Offered in"; ?>
							<?php
							if ($product->language_list != '') {
								$i = 1;
								if ($language_list->num_rows() > 0) {
									foreach ($language_list->result() as $language) {
										echo $language->language_name;
										echo ($i != $language_list->num_rows()) ? ', ' : '.';
										$i++;
									}
								}
							} else echo "$not_done"; ?>
						</li>
						<?php if ($product->page_view_count > 0) { ?>
							<li><i class="fa fa-eye" aria-hidden="true"></i><?php if ($this->lang->line('people_are') != '') { echo stripslashes($this->lang->line('people_are')); } else echo "People are eyeing this"; ?>
								<?php if ($this->lang->line('experience_over') != '') { echo stripslashes($this->lang->line('experience_over')); } else echo "experience. Over"; ?> <?php echo $product->page_view_count . " "; ?><?php if ($this->lang->line('viewed_it') != '') { echo stripslashes($this->lang->line('viewed_it')); } else echo "people have viewed it"; ?>.</p>
							</li>						
							
							
						<?php } ?>
					</ul>
				</div>
				<div class="divider"></div>
				<h5>About Organization</h5>
				<div style="margin-bottom:5px;"><?php echo $product->organization;?></div>
				<div><?php echo $product->organization_des;?></div>
				<div class="divider"></div>
				<h5><?php if ($this->lang->line('about_your_host') != '') { echo stripslashes($this->lang->line('about_your_host')); } else echo "About your host"; ?> , <?php echo ($product->user_id > 0 && $product->user_id != '') ? $product->firstname : 'Administrator'; ?></h5>
				<div><?php if ($product->about_host != '') echo $product->about_host; else echo 'Not Yet Added'; ?></div>
				<div class="divider"></div>
				<h5><?php if ($this->lang->line('what_we_will') != '') { echo stripslashes($this->lang->line('what_we_will')); } else echo "What we’ll do"; ?></h5>
				<div><?php if ($product->experience_description != '') echo $product->experience_description; else echo 'Not Yet Added'; ?></div>
				<div class="divider"></div>
				<?php if ($this->lang->line('not_applicable') != '') { $not_applicable=stripslashes($this->lang->line('not_applicable')); } else $not_applicable="Not Applicable"; ?>
				<div class="expProvide">
					<h5><?php if ($this->lang->line('what_will_provide') != '') { echo stripslashes($this->lang->line('what_will_provide')); } else echo "What I’ll provide"; ?></h5>
					<?php if ($kit_content->num_rows() > 0) {
						foreach ($kit_content->result() as $kit) {
							if ($kit->kit_count > 0) echo "<div>";
							echo $kit->kit_count . ' - ';
							echo $kit->kit_detailed_title . '</div>';
							echo '<p class="reduceFont">' . $kit->kit_description . '</p>';
						}
					} else {
						echo "$not_applicable";
					} ?>
				</div>
				<div class="divider"></div>
				<h5><?php if ($this->lang->line('notes_to_guest') != '') { echo stripslashes($this->lang->line('notes_to_guest')); } else echo "Notes"; ?></h5>
				<div><?php if ($product->note_to_guest != '') echo $product->note_to_guest; else echo 'Not Yet Added'; ?></div>
				<div id="goToLoc" class="divider"></div>
				<h5><?php if ($this->lang->line('where_we_will') != '') { echo stripslashes($this->lang->line('where_we_will')); } else echo "Where we’ll be"; ?></h5>
				<div
					class="marginBottom2"><?php if ($product->location_description != '') echo $product->location_description; else echo 'Not Yet Added'; ?></div>
				<h5><?php if ($this->lang->line('cancellation_percen') != '') { echo stripslashes($this->lang->line('cancellation_percen')); } else echo "Cancellation Percentage"; ?></h5>
				<div
					class="marginBottom2"><?php if ($product->cancel_percentage != '') echo 100-$product->cancel_percentage; else echo '0'; ?>
					% <?php if ($this->lang->line('of_subtotal_with') != '') { echo stripslashes($this->lang->line('of_subtotal_with')); } else echo "of Sub total With Security deposit"; ?>.
				</div>
				<div>
					<img id="map-image" border="0" alt="<?php echo $productDetails->row()->address; ?>"
						 src="https://maps.googleapis.com/maps/api/staticmap?center=<?php echo $productDetails->row()->address; ?>&zoom=13&size=600x300&maptype=roadmap&sensor=false&format=png&visual_refresh=true&markers=size:mid%7Ccolor:red%7C<?php echo $productDetails->row()->address; ?>"
						 width="100%">
				</div>				
				
				<?php if ($datesList->num_rows() > 0) { ?>
					<h5><?php if ($this->lang->line('upcoming_availability') != '') { echo stripslashes($this->lang->line('upcoming_availability')); } else echo "Upcoming availability"; ?></h5>
					<div class="upcomingDates">
						<?php
						foreach ($datesList->result() as $date) {
							$dateId = $date->id;
							$schedule = $datesSchedule[$dateId];
							$available_slots = ($date->group_size - $date->date_booked_count);
							if ($schedule->num_rows() > 0 && $available_slots > 0) {
								?>
								<div class="dateList">
									<div class="left">
										<p><?php
											if ($product->date_count > 1) {
												echo date('D, dS Y', strtotime($date->from_date)) . '- ' . date('D,dS Y', strtotime($date->to_date));
											} else {
												echo date('D, dS Y', strtotime($date->from_date));
											}
											?></p>
										<?php if ($date->price != '') { ?>
											<div class="time"><span
													class="number_s120"><?php echo $currencySymbol;
													if ($productDetails->row()->currency != $this->session->userdata('currency_type')) {
														$list_currency = $productDetails->row()->currency;
														if ($currency_result->$list_currency) {
															//$price = $productDetails->row()->price / $currency_result->$list_currency;
															$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
														} else {
															$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
														}
														echo number_format($price, 2);
													} else {
														echo $productDetails->row()->price;
													}
													?></span>
												<?php if ($this->lang->line('perperson') != '') {
													echo stripslashes($this->lang->line('perperson'));
												} else echo "per person"; ?>
												<p class='toggleSchedule_p' style="margin-top: 10px;"><a>
												
												<?php if ($this->lang->line('read_schedules') != '') {
													echo stripslashes($this->lang->line('read_schedules'));
												} else echo "Read Schedules"; ?>
												</a>
													<small> - <?php echo $available_slots; ?> 
													<?php if ($this->lang->line('slots_available') != '') {
													echo stripslashes($this->lang->line('slots_available'));
												} else echo "slots available"; ?>													
													</small>
												</p>
												<div class='scheduleDetails' style="display: none;">

													<?php

													foreach ($schedule->result() as $sched) {
														echo '<b>' . $sched->title . '</b><br>';
														echo date('D, dS Y', strtotime($sched->schedule_date));
														echo '<div class="time"><span class="number_s120">' . date('H:i', strtotime($sched->start_time)) . ' - ' . date('H:i', strtotime($sched->end_time)) . '</span></div>';
													}
													?>
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<div class="right">
										<input type="hidden" id="user_id" value="<?php echo $loginCheck; ?>">
										<input type="hidden" id="renter_id" value="<?php echo $productDetails->row()->user_id; ?>">
										<a <?php if ($loginCheck == '') { ?>data-toggle="modal"
										   data-target="#signIn" <?php
										   }else if ($productDetails->row()->id_verified != "No"){ ?>onclick="bookNow(<?php echo $dateId; ?>);"<?php } else { echo 'onclick=""'; } ?>
										   href="#" class="choose"><?php if ($this->lang->line('choose') != '') {
													echo stripslashes($this->lang->line('choose'));
												} else echo "Choose"; ?></a>
									</div>	
								</div>
								<div class="divider"></div>
								<?php
							}
						}
						if ($datesList->num_rows() > 4 && $productDetails->row()->id_verified != "No") {
							?>
							<a href="#" data-toggle="modal" data-target="#availableDates"><?php if ($this->lang->line('see_all_dates') != '') {
													echo stripslashes($this->lang->line('see_all_dates'));
												} else echo "See all available
								dates"; ?></a>
							<div class="divider"></div>
						<?php } ?>
					</div>
					<?php
				}
				?>
				<a href="<?php echo base_url() . 'users/show/' . $product->user_id; ?>"
				   target='_blank'><?php if ($this->lang->line('contact_host') != '') {
						echo stripslashes($this->lang->line('contact_host'));
					} else {
						echo "Contact Host";
					} ?></a>
				<div class="divider"></div>
				<h3 class="clear" id="reviews">
					<div class="colLeft">
						<span class="number_s120"><?= $user_reviewData->num_rows(); ?></span> <?php if ($this->lang->line('reviews') != '') {
						echo stripslashes($this->lang->line('reviews'));
					} else {
						echo "Reviews";
					} ?>
					</div>
					<div class="starRatingOuter2">
						<?php
						$Review_star = 0;
						if ($user_reviewData->num_rows() > 0) {
							foreach ($user_reviewData->result() as $review) {
								$Review_star = $Review_start + $review->total_review;
							}
							$Review_star=$Review_star/$user_reviewData->num_rows();
						}
						?>
						<div class="starRatingInner2" style="width: <?php echo($Review_star * 20); ?>%;"></div>
					</div>
				</h3>
				<?php
				if ($user_reviewData->num_rows() > 0) {
					foreach ($user_reviewData->result() as $review) {
						?>
						<div class="reviewList">
							<div class="reviewItems">
								<div class="top">
									<div class="left">
										<img
											src="<?= base_url(); ?>images/users/<?= ($review->image != '' && file_exists('./images/users/' . $review->image)) ? $review->image : 'profile.png'; ?>">
									</div>
									<div class="right">
										<div
											class="h7"><?php echo $review->firstname . ' ' . $review->lastname; ?></div>
										<p><?php echo date('F', strtotime($review->dateAdded)); ?> <span
												class="number_s120"><?php echo date('Y', strtotime($review->dateAdded)); ?></span>
										</p>
									</div>
								</div>
								<p><?php echo nl2br($review->review); ?></p>
							</div>
						</div>
						<?php
					}
				}
				?>
				<div class="divider"></div>
				<h5><?php if ($this->lang->line('group_size') != '') {
						echo stripslashes($this->lang->line('group_size'));
					} else {
						echo "Group size";
					} ?></h5>
				<div><?php
					$total_slot = $product->group_size - $booked_experience->num_rows();
					echo $product->group_size . " per Experience schedule";
					?></div>
				<div class="divider"></div>
				<h5><?php if ($this->lang->line('guest_requirement') != '') {
						echo stripslashes($this->lang->line('guest_requirement'));
					} else {
						echo "Guest Requirements";
					} ?></h5>
				<div><?php if ($product->guest_requirement != '') echo $product->guest_requirement; else echo 'Not Yet Added'; ?></div>
				<div class="divider"></div>
				<h5><?php echo $product->cancel_policy; ?> <?php if ($this->lang->line('Cancellation Policy') != '') {
						echo stripslashes($this->lang->line('Cancellation Policy'));
					} else {
						echo "Cancellation Policy";
					} ?></h5>
						
				<div><?php if ($product->cancel_policy != '') { ?>  <?php if ($this->lang->line('any_trip_or_expe_can') != '') {
						echo stripslashes($this->lang->line('any_trip_or_expe_can'));
					} else {
						echo "Any trip or experience can be canceled. See";//data-toggle="tooltip" data-placement="top" data-original-title="Waiting for Admin approval"
					} ?>    
				<a href="<?php echo base_url(); ?>pages/cancellation-policy " target="_blank"><?php if ($this->lang->line('Cancellation Policy') != '') {
						echo stripslashes($this->lang->line('Cancellation Policy'));
					} else {
						echo "Cancellation Policy";
					} ?></a> 
				<?php } else { ?>  <?php if ($this->lang->line('not_yet_added') != '') {
						echo stripslashes($this->lang->line('not_yet_added'));
					} else {
						echo "Not Yet Added";
					} ?> <?php } ?></a></div>
					
					<!-- STARTING SIMILAR EXPERIENCE -->
					<div class="centeredBtm">
						<?php /* <h3 id="location"><?php if ($this->lang->line('list_Location') != '') { echo stripslashes($this->lang->line('list_Location')); } else echo "Location"; ?></h3>
						<div class="row mapSection" id="map" style="height: 350px;"></div> */ ?>
						<?php if ($DistanceQryArr->num_rows() > 0) { ?>
							<div class="similarHead">
								<h3><?php if ($this->lang->line('similar_listings') != '') { echo stripslashes($this->lang->line('similar_listings')); } else { echo "Similar Listings"; } ?></h3>
							</div>
							<div class="owl-carousel owl-theme listing-carousel bottomSpace">
								<?php 
								//print_r($DistanceQryArr->result());
								foreach ($DistanceQryArr->result() as $similar_Rentals) 
								{
								?>
									<div class="item">
										<?php if ($this->session->userdata('fc_session_user_id')) 
										{
											if (in_array($similar_Rentals->id, $newArr)) {
												echo '<div class="wishList_I yes"></div>';
											} 
											else 
											{
											?>
											<div class="wishList_I" onclick="loadExperienceWishlistPopup('<?php echo $similar_Rentals->id; ?>');"></div>
											<?php
											}
										} 
										else 
										{
											echo '<a data-toggle="modal" data-target="#signIn" class="wishList_I"></a>';
										} ?>
										<a href="<?php echo base_url(); ?>view_experience/<?php echo $similar_Rentals->id; ?>">
											<?php if (($similar_Rentals->PImg != '') && (file_exists('./images/experience/' . $similar_Rentals->PImg))) { ?>
												<div class="myPlace" style="background-image: url('<?php echo base_url(); ?>images/experience/<?php echo $similar_Rentals->PImg; ?>')"></div>
											<?php } else { ?>
												<div class="myPlace" style="background-image: url('<?php echo base_url(); ?> images/rental/dummyProductImage.jpg')"></div>
											<?php } ?>
											<div class="bottom">
												<div class="loc"><?php echo ucfirst($similar_Rentals->city_name); ?></div>
												<h5><?php echo ucfirst($similar_Rentals->product_title); ?></h5>
												<div class="price">
													<span class="number_s">
													<?php
													echo $this->session->userdata('currency_s');
													if ($similar_Rentals->currency != $this->session->userdata('currency_type')) 
													{
														$list_currency = $similar_Rentals->currency;
														/*if ($currency_result->$list_currency) 
														{
															$price = $similar_Rentals->price / $currency_result->$list_currency;
														} else {
															$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $similar_Rentals->price);
														}*/
														$price = currency_conversion($list_currency, $this->session->userdata('currency_type'), $similar_Rentals->price);
														echo number_format($price, 2);
													} else {
														$priceEx = $similar_Rentals->price;
														echo number_format($priceEx, 2);
													}
													?>
													</span>
												</div>
												<div class="clear">
												<?php
												$avg_val = round($similar_Rentals->rate);
												$num_reviewers = $similar_Rentals->num_reviewers;
												?>
												<div class="starRatingOuter">
													<div class="starRatingInner" style="width: <?php echo($avg_val * 20); ?>%;"></div>
												</div>
												<span class="ratingCount"><?php echo $num_reviewers . " "; ?><?php if ($this->lang->line('Reviews') != '') {
												echo stripslashes($this->lang->line('Reviews')); } else { echo "Reviews"; } ?></span>
												</div>
											</div>
										</a>
									</div>
								<?php
								} ?>
							</div>
						<?php } ?>
					</div>
					<!-- END OF SIMILAR EXPERIENCE -->
					
			</div>
			<div class="detailRight">
				<div class="bookingBlock">
					<div class="owl-carousel owl-theme listing-carousel exp">

                        <?php  if($product->video_url != ''){

							$url = $product->video_url;
							preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
		    				$id = $matches[1];
		    				if($id != ''){
							?>
							<iframe width="100%" height="350px" src="https://www.youtube.com/embed/<?php echo $id ?>?autoplay=1">
							</iframe>
							<?php }else{ ?>
							<iframe width="100%" height="350px" src="<?php echo $product->video_url."?autoplay=1";?>">
							</iframe>
							<?php } } else {
						if (count($productImages->result_array()) > 0) {
                            foreach ($productImages->result_array() as $product_image) {
                                ?>
                                <div class="item">
                                    <a href="#">
                                        <div class="myPlace"
                                             style="background-image: url('<?php if (($product_image['product_image'] != '') && (file_exists('./images/experience/' . $product_image['product_image']))) {
                                                 echo base_url() . 'images/experience/' . $product_image['product_image'];
                                             } else {
                                                 echo base_url() . 'images/experience/dummyProductImage.jpg';
                                             } ?>')"></div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
						} //videoEnd
						?>
					</div>
					<div class="expRow">
						<div class="left">
							<h5 class="price"><span class="number_s120"><?php echo $currencySymbol;
									if ($productDetails->row()->currency != $this->session->userdata('currency_type')) {
										$list_currency = $productDetails->row()->currency;
										if ($currency_result->$list_currency) {
											//$price = $productDetails->row()->price / $currency_result->$list_currency;
											$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
										} else {
											$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
										}
										echo number_format($price, 2);
									} else {
										echo $productDetails->row()->price;
									}
									?></span> <?php if ($this->lang->line('perperson') != '') {
						echo stripslashes($this->lang->line('perperson'));
					} else {
						echo "per person";
					} ?></h5>		
							<div class="clear">
								<div class="starRatingOuter">
									<?php
										$Review_star = 0;
										if ($user_reviewData->num_rows() > 0) {
											foreach ($user_reviewData->result() as $review) {
												$Review_star = $Review_start + $review->total_review;
											}
											$Review_star=$Review_star/$user_reviewData->num_rows();
										}
										?>
									<div class="starRatingInner"
										 style="width: <?php echo($Review_star * 20); ?>%;"></div>
								</div>
								
					<?php if ($this->lang->line('Reviews') != '') {
						$reviews= stripslashes($this->lang->line('Reviews'));
					} else {
						$reviews= "Reviews";
					} ?>
					
					<?php if ($this->lang->line('Review') != '') {
						$review= stripslashes($this->lang->line('Review'));
					} else {
						$review= "review";
					} ?>		
								<span class="reviewCount"><?= $user_reviewData->num_rows(); echo " $review"; ?><?php /* if ($num_reviewers > 0) {
										echo $num_reviewers;
										echo ($num_reviewers > 1) ? "$reviews" : " $review";
									} else {
										echo "0 $review";
									} */?></span>
							</div>
						</div>
						<?php

						if ($productDetails->row()->id_verified != "No") {
							?>
							<div class="right">
								<button type="button" class="submitBtn tRB" data-toggle="modal"
										data-target="#availableDates"><?php if ($this->lang->line('see_dates') != '') {
								echo stripslashes($this->lang->line('see_dates'));
							} else {
								echo "See Dates";
							} ?>
								</button>
							</div>
						<?php } else {
							?>
							<div class="right">
								<button class="submitBtn tRB"><?php if ($this->lang->line('host_is_not_verified') != '') {
								echo stripslashes($this->lang->line('host_is_not_verified'));
							} else {
								echo "Host is not verified Yet`";
							} ?></button>
							</div>
							<?php
						} ?>
					</div>
					
					<div class="divider"></div>
					<div class="expRow">
						<div class="left">
							<?php
							$description = $product->experience_description;
							$url = base_url() . 'view_experience/' . $product->experience_id;
							$url = urlencode($url);
							$facebook_share = 'http://www.facebook.com/sharer.php?u=' . $url;
							$twitter_share = 'https://twitter.com/share?url=' . $url ;
							?>
							<i target="_blank" class="fa fa-facebook" aria-hidden="true" style="cursor: pointer;"
							   onclick="window.open('<?= $facebook_share; ?>','_blank');" -onclick="window.location.href='<?= $facebook_share; ?>'"></i>
							<i class="fa fa-twitter" aria-hidden="true" style="cursor: pointer;"
							   onclick="window.open('<?= $twitter_share; ?>','_blank');" -onclick="window.location.href='<?= $twitter_share; ?>'"></i>
							<i class="fa fa-google-plus" aria-hidden="true" style="cursor: pointer;"
							   onclick="window.open('https://plus.google.com/share?url={<?= $url; ?>}','_blank');" -onclick="window.location.href='https://plus.google.com/share?url={<?= $url; ?>}'"></i>
						</div>
						<div class="right">
							<?php if ($loginCheck == '') { ?>
								<a data-toggle="modal" data-target="#signIn"
								   class="wishList"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php if ($this->lang->line('header_add_list') != '') {
										echo stripslashes($this->lang->line('header_add_list'));
									} else echo "Save to Wish List"; ?></a>
								<?php
							} else {
								if (!in_array($product->experience_id, $newArr)) {
									?>
									<a onclick="loadExperienceWishlistPopup('<?php echo $product->experience_id;/*$product_image['experience_id'];*/ ?>');"
									   class="wishList"><i class="fa fa-heart-o" aria-hidden="true"></i> <?php if ($this->lang->line('header_add_list') != '') {
											echo stripslashes($this->lang->line('header_add_list'));
										} else echo "Save to Wish List"; ?></a>
									<?php
								}
							} ?>
						</div>
					</div>
					<div class="divider noMarginBottom"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Available Dates Modal -->
<div id="availableDates" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<h2><?php if ($this->lang->line('When_do_you_want_to_go') != '') {
						echo stripslashes($this->lang->line('When_do_you_want_to_go'));
					} else echo "When do you want to go?"; ?></h2>
				<p class="marginBottom3"><?php if ($this->lang->line('trycontacthost') != '') {
						echo stripslashes($this->lang->line('trycontacthost'));
					} else echo "If you can’t find the dates you want, try contacting the host"; ?></p>
				<div class="upcomingDates">
					<?php
					if ($datesList->num_rows() > 0) {
						$j = 1;
						foreach ($datesList->result() as $date) {
							$dateId = $date->id;
							$schedule = $datesSchedule[$dateId];
							$available_slots = ($date->group_size - $date->date_booked_count);
							if ($schedule->num_rows() > 0 && $available_slots > 0) {
								?>
								<div class="dateList">
									<div class="left">
										<p><?php
											if ($product->date_count > 1) {
												echo date('M D, dS Y', strtotime($date->from_date)) . ' - ' . date('M D,dS Y', strtotime($date->to_date));
											} else {
												echo date('M D, dS Y', strtotime($date->from_date));
											}
											?></p>
										<?php if ($date->price != '') { ?>
											<div class="time"><span
													class="number_s120"><?php echo $currencySymbol;
													if ($productDetails->row()->currency != $this->session->userdata('currency_type')) {
														$list_currency = $productDetails->row()->currency;
														if ($currency_result->$list_currency) {
															//$price = $productDetails->row()->price / $currency_result->$list_currency;
															$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
														} else {
															$price = currency_conversion($list_currency, $this->session->currency_type, $productDetails->row()->price);
														}
														echo number_format($price, 2);
													} else {
														echo $productDetails->row()->price;
													}
													?></span>
												<?php if ($this->lang->line('perperson') != '') {
													echo stripslashes($this->lang->line('perperson'));
												} else echo "per person"; ?>
												<p class='toggleSchedule_p' style="margin-top: 10px;"><a><?php if ($this->lang->line('read_schedules') != '') {
													echo stripslashes($this->lang->line('read_schedules'));
												} else echo "Read Schedules"; ?></a>	
													<small> - <?php echo $available_slots; ?> <?php if ($this->lang->line('slots_available') != '') {
													echo stripslashes($this->lang->line('slots_available'));
												} else echo "slots available"; ?>
													</small>
												</p>
												<div class='scheduleDetails' style="display: none;">
													<?php
													foreach ($schedule->result() as $sched) {
														echo '<b>' . $sched->title . '</b><br>';
														echo date('D, dS Y', strtotime($sched->schedule_date));
														echo '<div class="time"><span class="number_s120">' . date('H:i', strtotime($sched->start_time)) . ' - ' . date('H:i', strtotime($sched->end_time)) . '</span></div>';
													}
													?>
												</div>
											</div>
											<?php
										}
										?>
									</div>
									<div class="right">
										<input type="hidden" id="user_id" value="<?php echo $loginCheck; ?>">
										<input type="hidden" id="renter_id"
											   value="<?php echo $productDetails->row()->user_id; ?>">
										<a <?php if ($loginCheck == '') { ?>data-toggle="modal"
										   data-target="#signIn" <?php } else { ?>onclick="bookNow(<?php echo $dateId; ?>);"<?php } ?>
										   href="#" class="choose"><?php if ($this->lang->line('choose') != '') {
													echo stripslashes($this->lang->line('choose'));
												} else echo "Choose"; ?></a>
										   
										   
									</div>
									
									<?php if ($this->lang->line('no_dates') != '') {
													$no_dates = stripslashes($this->lang->line('no_dates'));
												} else $no_dates= "No Dates"; ?>
												
												
								</div>
								<?php
								if ($j != $datesList->num_rows()) {
									?>
									<div class="divider"></div>
									<?php
								}
							}
							$j++;
						}
					} else {
						echo "<p class='text-center text-danger'>$no_dates.</p>";
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
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
		$(".showResult").click(function () {
			$(this).next(".guestInfo").toggle();
			$(this).children(".arrow").toggleClass("active");
		});
		$(document).on("click", ".tRB", function () {
			$(".toggleRequestBook").slideToggle(300);
		});
		var yOffset = $(".bookingBlock").offset().top;
		var yOffset1 = $("footer").offset().top - $(".bookingBlock").innerHeight() - 55;
		$(window).scroll(function () {
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
	});

	function affectGuestCount(mode, select) {
		$existVAl = Number($(".guestCount").val());
		if (mode == 'increase') {
			$(".guestCount").val($existVAl + 1);
		}
		if (mode == 'decrease') {
			if ($existVAl != 0 && $(select).next().val() != 0) {
				$(".guestCount").val($existVAl - 1);
			}
		}
	}

	$(document).on("click", ".toggleSchedule_p", function () {
		$(this).next(".scheduleDetails").slideToggle();
	});

	/*Book the experience*/
	function bookNow(date_id) {

		var user_id = $('#user_id').val();
		var renter_id = $('#renter_id').val();
		if (user_id == renter_id) {
			boot_error_alert("Booking not allowed.");
			return false;
		} else {
			window.location = "<?php echo base_url() . 'site/experience/experience_booking_enquiry/'?>" + date_id;
		}
	}
	function boot_error_alert(message){
		$("#model-alert-error").modal();
		$("#alert_message_content_error").text(message);
	}


	
</script>
<?php
$this->load->view('site/includes/footer');
?>
