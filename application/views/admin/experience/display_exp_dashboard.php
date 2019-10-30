<?php
$this->load->view('admin/templates/header.php');
?>

<?php

$activeExp = $inActiveExp = 0;
foreach ($ExpDetails->result() as $exp) {

	if ($exp->status == '1') {
		$activeExp++;
	} else if ($exp->status == '0') {
		$inActiveExp++;
	}

}


?>

	<script type="text/javascript">
		/*=================
        CHART 5
        ===================*/
		$(function () {
			plot2 = jQuery.jqplot('chart6',
				[[['Active',<?php echo $activeExp; ?>], ['Inactive', <?php echo $inActiveExp; ?>]]],
				{
					title: ' ',
					seriesDefaults: {
						shadow: false,
						renderer: jQuery.jqplot.PieRenderer,
						rendererOptions: {
							startAngle: 180,
							sliceMargin: 4,
							showDataLabels: true
						}
					},
					grid: {
						borderColor: '#ccc',     // CSS color spec for border around grid.
						borderWidth: 2.0,           // pixel width of border around grid.
						shadow: false               // draw a shadow for grid.
					},
					legend: {show: true, location: 'w'}
				}
			);
		});

	</script>

	<div id="content">
		<div class="grid_container">

			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6>Experiences Dashboard</h6>
					</div>
					<div class="widget_content">
						<?php if ($ExpDetails->num_rows() > 0) { ?>
							<h4><?php echo $ExpDetails->num_rows(); ?> Experiences in this site</h4>
						<?php } else { ?>
							<h4>No Experiences </h4>
						<?php } ?>


						<div id="chart6" class="chart_block">
						</div>
					</div>


					<div class="views_s">
						<div class="block_label">
							Booked Experience<span><?php echo $BookedCount->num_rows(); ?></span>
						</div>
						<span class="badge_icon bank_sl"></span>
					</div>

					<div class="views_s">
						<div class="block_label">
							Active Experience<span><?php echo $activeExp; ?></span>
						</div>
						<span class=""></span>
					</div>


					<div class="views_s">
						<div class="block_label">
							In active Experience<span><?php echo $inActiveExp; ?></span>
						</div>
						<span class=""></span>
					</div>


				</div>
			</div>


			<div class="grid_6">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon image_1"></span>
						<h6>Most viewed Experiences</h6>
					</div>
					<div class="widget_content">
						<table class="wtbl_list">
							<thead>
							<tr>
								<th>
									Host
								</th>

								<th>
									Experience Type
								</th>
								<th>
									Experience Tittle
								</th>

								<th>
									Experience Image
								</th>

								<th>
									Prices
								</th>

							</tr>
							</thead>
							<tbody>
							<?php
							if ($MostViewed->num_rows() > 0) {

								foreach ($MostViewed->result() as $result) {

									?>
									<tr class="tr_even">

										<td>
											<?php echo $result->firstname; ?>
										</td>
										<td>
											<?php
											$type = $result->exp_type;
											if ($type == '1') {
												$type_is = 'Immersions';
											} else {
												$type_is = 'Experiences';
											}

											echo $type_is; ?>
										</td>

										<td>
											<?php echo ucfirst($result->experience_title); ?>
										</td>

										<td>
											<div class="widget_thumb">

												<?php
												$base = base_url();
												$url = getimagesize($base . 'server/php/experience/' . $result->product_image);
												if (!is_array($url)) {
													$img = "1"; //no
												} else {
													$img = "0";  //yes
												}
												//To Check whether the image is exist in Local Directory..
												?>



												<?php if ($result->product_image != '' && $img == '0') { ?>
													<img width="40px" height="40px"
														 src="<?php echo base_url(); ?>server/php/experience/<?php echo $result->product_image; ?>"/>
												<?php } else { ?>
													<img width="40px" height="40px"
														 src="<?php echo base_url(); ?>server/php/experience/dummyProductImage.jpg"/>
												<?php } ?>
											</div>
										</td>

										<td>
											<?php echo $result->price . " " . "(" . $result->currency . ")" ?>
										</td>

									</tr>
									<?php

								}
							} else {
								?>
								<tr>
									<td colspan="5" align="center">No Most Viewed Experiences</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


		</div>
	</div>

<?php
$this->load->view('admin/templates/footer.php');
?>
