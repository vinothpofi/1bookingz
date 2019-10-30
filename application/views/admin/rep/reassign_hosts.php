<?php
$this->load->view('admin/templates/header.php');
?>
	<div id="content">
		<div class="grid_container">
			<div class="grid_12">
				<div class="widget_wrap">
					<div class="widget_top">
						<span class="h_icon list"></span>
						<h6><?php echo $heading ?></h6>
					</div>
					<div class="widget_content">
						<?php
						$attributes = array('class' => 'form_container left_label', 'id' => 'reassignHost_form');
						echo form_open('admin/rep/reassign_hosts_to_other_rep_form', $attributes)
						?>
						<ul>

							<li id='repcode'>
								<div class="form_grid_12">
									<label class="field_title" for="Code">Current Rep. Code </label>
									<div class="form_input">
										<?php echo $rep_code; ?>
										<input type="hidden" name="current_rep_code" value="<?php echo $rep_code; ?>">
										<input type="hidden" name="rep_id" value="<?php echo $rep_id; ?>">

									</div>

								</div>
							</li>


							<li>
								<div class="form_grid_12">
									<?php
									/*echo '<pre>';
										print_r($sellersList->result());
										echo '</pre>';
										*/
									?>
									<label class="field_title" for="Code">Select Representative</label>
									<div class="form_input">

										<select name="rep_code" required>
											<option value="">Select Rep Code</option>
											<?php
											foreach ($rep_details->result() as $row_rep) {

												echo '<option value="' . $row_rep->admin_rep_code . '">' . $row_rep->admin_rep_code . '</option>';
											}
											?>
										</select>

									</div>
								</div>
							</li>
							<li>
								<div class="form_grid_12">
									<label class="field_title" for="Hosts">Hosts</label>
									<div class="form_input">
										<?php

										foreach ($sellersList->result() as $row) {
											?>

											<input type="checkbox" name="host[]" id="host[]"
												   value="<?php echo $row->id; ?>"/> <?php echo $row->firstname . "&nbsp;" . $row->lastname; ?>

											<br>
											<?php
										}
										?>

									</div>
								</div>
							</li>

							<li>
								<div class="form_grid_12">
									<div class="form_input">
										<!--<a href="admin/rep/display_rep_list" class="pull-right"><span class="badge_style b_done">Cancel</span></a>-->

										<button type="submit" class="btn_small btn_blue" tabindex="15">
											<span>Submit</span></button>
									</div>

								</div>


							</li>


						</ul>
						</form>


						<!-- Start  Representative Text box-->


						<script type="text/javascript">
							/* $(function () {
                                $("input[name='rep_type']").click(function () {

                                    if ($("#rep_type_representative").is(":checked")) {

                                        var radioValue = $("input[name='rep_type']:checked").val();
                                          if(radioValue){
                                        alert("Your are a - " + radioValue);
                                    }
                                        $("#repcode").show();
                                    } else {

                                        var radioValue = $("input[name='rep_type']:checked").val();
                                          if(radioValue){
                                        alert("Your are a - " + radioValue);
                                         }
                                        $("#repcode").hide();


                                    }
                                });
                            }); */
						</script>

						<!-- End  Representative Text box-->
					</div>
				</div>
			</div>
		</div>
		<span class="clear"></span>
	</div>
	</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
