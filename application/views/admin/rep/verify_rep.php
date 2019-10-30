<style type="text/css">
	.table-pad td {
		padding: 5px;
		text-align: center;
		vertical-align: middle;
	}

	.table-pad td img {
		height: 100px;
		width: 100px;
	}
</style>
<?php
$this->load->view('admin/templates/header.php');
?>
<script>
	$(document).ready(function () {
		$('.nxtTab').click(function () {
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.next().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().next().find('a').addClass('active_tab');
		});
		$('.prvTab').click(function () {
			var cur = $(this).parent().parent().parent().parent().parent();
			cur.hide();
			cur.prev().show();
			var tab = cur.parent().parent().prev();
			tab.find('a.active_tab').removeClass('active_tab').parent().prev().find('a').addClass('active_tab');
		});
		$('#tab2 input[type="checkbox"]').click(function () {
			var cat = $(this).parent().attr('class');
			var curCat = cat;
			var catPos = '';
			var added = '';
			var curPos = curCat.substring(3);
			var newspan = $(this).parent().prev();
			if ($(this).is(':checked')) {
				while (cat != 'cat1') {
					cat = newspan.attr('class');
					catPos = cat.substring(3);
					if (cat != curCat && catPos < curPos) {
						if (jQuery.inArray(catPos, added.replace(/,\s+/g, ',').split(',')) >= 0) {
							//Found it!
						} else {
							newspan.find('input[type="checkbox"]').attr('checked', 'checked');
							added += catPos + ',';
						}
					}
					newspan = newspan.prev();
				}
			} else {
				var newspan = $(this).parent().next();
				if (newspan.get(0)) {
					var cat = newspan.attr('class');
					var catPos = cat.substring(3);
				}
				while (newspan.get(0) && cat != curCat && catPos > curPos) {
					newspan.find('input[type="checkbox"]').attr('checked', this.checked);
					newspan = newspan.next();
					cat = newspan.attr('class');
					catPos = cat.substring(3);
				}
			}
		});

	});

	function calc() {
		alert("Calc");
		if (document.getElementById('checkbox1').checked) {
			alert("checked");
		}
	}
</script>
<div id="content">
	<div class="grid_container">
		<div class="grid_12">
			<div class="widget_wrap">
				<div class="widget_top">
					<span class="h_icon list"></span>
					<h6>Verify Host's Proof</h6>
					<div id="widget_tab">
						<ul>
							<li><a href="#tab1" class="active_tab">Verify Host </a></li>
						</ul>
					</div>
				</div>
				<div class="widget_content">
					<?php if ($userDetails->num_rows() > 0) { ?>
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'verify_user_form', 'enctype' => 'multipart/form-data');
						$hidden = array('user_type' => $user_type, 'user_id' => $user_id);
						echo form_open('admin/users/update_proof_file/', $attributes, $hidden);
						?>
						<div id="tab1">
							<ul>
								<?php //print_r($userDetails->result()); exit;  ?>
								<li>
									<div class="form_grid_12">
										<table border="1px" height="60%" width="100%" class="table-pad">
											<thead>
											<tr>
												<th width="120px">Proof Name</th>
												<th>File</th>
												<th width="100px">Status</th>
												<th>Comments</th>
											</tr>
											</thead>
											<tbody>
											<?php
											//print_r($userDetails->result());
											$img_type = array('gif', 'jpg', 'png', 'bmp', 'jpeg');
											$doc_type = array('doc', 'docx');
											$pdf_type = 'pdf';
											foreach ($userDetails->result() as $proof) {
												$file_ar = explode('.', $proof->proof_file);
												$file_ext = $file_ar[1];
												$proof_title = '';
												if ($proof->proof_type == '1')
													$proof_title = "Passport";
												elseif ($proof->proof_type == '2')
													$proof_title = "Voter ID";
												elseif ($proof->proof_type == '3')
													$proof_title = "Driving Licence";
												if ($proof->proof_status == 'P')
													$proof_status = 'Not Verified';
												elseif ($proof->proof_status == 'CL')
													$proof_status = 'Cancelled';
												elseif ($proof->proof_status == 'V')
													$proof_status = 'Verified';
												else
													$proof_status = 'Not Done';
												?>
												<tr>
													<td><?php echo $proof_title; ?><input type='hidden' name="proofID[]"
																						  value="<?php echo $proof->id; ?>">
													</td>
													<td>
														<?php
														if (in_array($file_ext, $img_type)) {
															?><a
															href='<?php echo ID_PROOF_PATH . $proof->proof_file; ?>'
															target='_blank'>
															<img src="<?php echo ID_PROOF_PATH . $proof->proof_file; ?>"
																 width='100'/></a>
															<?php
														} elseif (in_array($file_ext, $doc_type)) {
															?><a
															href='<?php echo ID_PROOF_PATH . $proof->proof_file; ?>'
															target='_blank'>
																<img src="images/uploadimg/document_thumb.png"
																	 width='100'/> </a>
															<?php
														} elseif ($file_ext == $pdf_type) {
															?><a
															href='<?php echo ID_PROOF_PATH . $proof->proof_file; ?>'
															target='_blank'>
																<img src="images/uploadimg/pdf_thumb.jpg" width='100'/>
															</a>
															<?php
														}
														?>
													</td>
													<td>
														<div class="active_inactive">
															<!--
														<input type="checkbox" name="status[<?php //echo $proof->id; ?>]" <?php // if ($proof->proof_status == 'V'){echo 'checked="checked"';}?> id="active_inactive_active" class="active_inactive" />
														-->
															<label for="verified_<?php echo $proof->id; ?>">
																<input type="radio"
																	   name='proof_status[<?php echo $proof->id; ?>]'
																	   id='verified_<?php echo $proof->id; ?>'
																	   value='V' <?php if ($proof->proof_status == 'V') echo "checked"; ?> ></radio>
																<b> Verified</b>
															</label>
															<label for="unverified_<?php echo $proof->id; ?>">
																<input type="radio"
																	   name='proof_status[<?php echo $proof->id; ?>]'
																	   id='unverified_<?php echo $proof->id; ?>'
																	   value='P' <?php if ($proof->proof_status == 'P') echo "checked"; ?> ></radio>
																<b> Unverified </b>
															</label>
															<label for="cancelled_<?php echo $proof->id; ?>">
																<input type="radio"
																	   name='proof_status[<?php echo $proof->id; ?>]'
																	   id='cancelled_<?php echo $proof->id; ?>'
																	   value="CL" <?php if ($proof->proof_status == 'CL') echo "checked"; ?> ></radio>
																<b> Cancelled</b>
															</label>
														</div>
													</td>
													<td><textarea name="comments[<?php echo $proof->id; ?>]"
																  id="comments_<?php echo $proof->id; ?>"
																  rows='3'><?php echo $proof->proof_comments; ?></textarea>
													</td>
												</tr>
												<?php
											}
											?>
											</tbody>
										</table>
									</div>
								</li>
								<li>
									<div class="form_grid_12">
										<div class="form_input">
											<input type="submit" class="btn_small btn_blue nxtTab" name="submit"
												   tabindex="9" value="Submit"/>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<?php echo form_close(); ?>
					<?php } else
						echo "<h4>Proof not found.</h4><br><br>";
					?>
				</div>
			</div>
		</div>
	</div>
	<span class="clear"></span>
</div>
</div>
<script>
	$('#addseller_form').validate();
</script>
<?php
$this->load->view('admin/templates/footer.php');
?>
