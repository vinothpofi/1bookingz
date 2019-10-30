<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items">
	<?php
	$this->load->view('site/includes/listing_head_side');
	?>
	<div class="centeredBlock">
		<div class="content">
            <?php if ($this->session->flashdata('sErrMSG')) { ?>
                <div class="alert alert-success alert-dismissable">
                    <?php echo $this->session->flashdata('sErrMSG') ?>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div>
            <?php } ?>
			<div class="form-group">
				<h3><?php if ($this->lang->line('Overview') != '') {
						echo stripslashes($this->lang->line('Overview'));
					} else echo "Overview"; ?>
				</h3>
				<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
					<p class="text center text-danger" id="danger"></p>
					<p class="text center text-success" id="success"></p>
				</div>
				
				<div class="row">
					<div class="col-sm-12"><?php if ($this->lang->line('overview_subheading') != '') { echo stripslashes($this->lang->line('overview_subheading'));  } else { echo "Please fill the below mentioned property information."; } ?></div>
				</div>
				<?php
				echo form_open('insert_overview_listing/' . $listDetail->row()->id, array('name' => 'overviewlist', 'id' => 'overviewlist', 'onsubmit' => 'return validate_form();'));
				$hidden = array('type' => 'hidden', 'name' => 'id', 'id' => $listDetail->row()->id, 'value' => $listDetail->row()->id);
				echo form_input($hidden);
				?>
				<p>
					<?php if ($this->lang->line('Title') != '') {
						echo stripslashes($this->lang->line('Title'));
					} else echo "Title"; ?><span class="impt"> *</span>
					<small><?php if ($this->lang->line('max_err') != '') {
							echo stripslashes($this->lang->line('max_err'));
						} else echo "Maximum"; ?> 8 <?php if ($this->lang->line('max_wrds') != '') {
							echo stripslashes($this->lang->line('max_wrds'));
						} else echo "words"; ?>
					</small>
				</p>
				<?php if ($this->lang->line('enter_the_tittle') != '') {
							$ente_tit= stripslashes($this->lang->line('enter_the_tittle'));
						} else $ente_tit= "Enter the Title"; ?>
				<?php
				$title = array('id' => 'title', 'placeholder' => "$ente_tit");
				echo form_input('product_title', $listDetail->row()->product_title, $title);
				form_error('product_title');
				?>
				<span id="words_left_title" class="text-danger"></span>

                <!--In arabic -->
              
			</div>
			<div class="form-group">
				<p>
					<?php if ($this->lang->line('Summary') != '') {
						echo stripslashes($this->lang->line('Summary'));
					} else echo "Summary"; ?><span class="impt"> *</span>
					<small> <?php if ($this->lang->line('Maximum150words') != '') {
							echo stripslashes($this->lang->line('Maximum150words'));
						} else echo "Maximum 150 words"; ?>
					</small>
				</p>
				
				<?php if ($this->lang->line('enter_desc_canpolicy') != '') {
							$entr_desc= stripslashes($this->lang->line('enter_desc_canpolicy'));
						} else $entr_desc=  "Enter Your Description"; ?>
				
				<?php
				$description = array('name' => 'description', 'id' => 'summary', 'rows' => '5', 'placeholder' => "$entr_desc", 'value' => $listDetail->row()->description,'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'description');");
				echo form_textarea($description);
				?>
				<span id="words_left_summary" class="text-danger"></span>


				<!--In arabic dyna -->
                
				
				
			</div>
			<div class="form-group">
				  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>
				<p>
					<?php if ($this->lang->line('Title') != '') {
						echo stripslashes($this->lang->line('Title'));
					} else echo "Title"; ?> (<?php echo $data->name;?>)<span class="impt"> *</span>
					<small><?php if ($this->lang->line('max_err') != '') {
							echo stripslashes($this->lang->line('max_err'));
						} else echo "Maximum"; ?> 8 <?php if ($this->lang->line('max_wrds') != '') {
							echo stripslashes($this->lang->line('max_wrds'));
						} else echo "words"; ?>
					</small>
				</p>
				<?php if ($this->lang->line('enter_the_tittle') != '') {
							$ente_tit= stripslashes($this->lang->line('enter_the_tittle'));
						} else $ente_tit= "Enter the Title"; ?>
				<?php
				$title = array('required' => 'required','id' => 'title'.$data->lang_code, 'placeholder' => "$ente_tit",'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'product_title_".$data->lang_code."');");
                    echo form_input('product_title_'.$data->lang_code, $listDetail->row()->{'product_title_'.$data->lang_code}, $title);
                    form_error($dynlang[1]);
				?>
				<span id="words_left_title" class="text-danger"></span>


                    <p>
                        <?php if ($this->lang->line('Summary') != '') {
                            echo stripslashes($this->lang->line('Summary'));
                        } else echo "Summary"; ?> (<?php echo $data->name;?>)<span class="impt"> *</span>
                        <small> <?php if ($this->lang->line('Maximum150words') != '') {
                                echo stripslashes($this->lang->line('Maximum150words'));
                            } else echo "Maximum 150 words"; ?>
                        </small>
                    </p>

                    <?php if ($this->lang->line('enter_desc_canpolicy') != '') {
                                $entr_desc= stripslashes($this->lang->line('enter_desc_canpolicy'));
                            } else $entr_desc=  "Enter Your Description"; ?>

                    <?php
                    $description_ar = array('required' => 'required','name' => 'description_'.$data->lang_code, 'id' => 'summary', 'rows' => '5', 'placeholder' => "$entr_desc", 'value' => $listDetail->row()->{'description_'.$data->lang_code},'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'description_$data->lang_code');");
                    echo form_textarea($description_ar);
                    ?>
                    <span id="words_left_summary" class="text-danger"></span>
         




			<?php }
			} ?>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<p><?php if ($this->lang->line('request_to_book') != '') {
								echo stripslashes($this->lang->line('request_to_book'));
							} else echo "Request to Book"; ?>
						</p>
					</div>
					<div class="col-sm-6">
						<label class="switch">
							<?php
							$checked = FALSE;
							if ($listDetail->row()->request_to_book == 'Yes') {
								$checked = TRUE;
							}
							$booking = array('id' => 'req_id_y', 'onchange' => 'CheckStatus();');
							echo form_checkbox('request_to_book', 'Yes', $checked, $booking);
							?>
							<span class="sliderC round"></span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-sm-6">
						<p><?php if ($this->lang->line('instant_pay') != '') {
								echo stripslashes($this->lang->line('instant_pay'));
							} else echo "Instant Pay"; ?></p>
					</div>
					<div class="col-sm-6">
						<label class="switch">
							<?php
							$checked = FALSE;
							if ($listDetail->row()->instant_pay == 'Yes') {
								$checked = TRUE;
							}
							$instantpay = array('id' => 'instant_y', 'onchange' => 'CheckStatusTwo();');
							echo form_checkbox('instant_pay', 'Yes', $checked, $instantpay);
							?>
							<span class="sliderC round"></span>
						</label>

					</div>
					<?php
                       
                        if ($this->lang->line('note1') != '') { $note1= stripslashes($this->lang->line('note1')); }else $note1="Instant pay will show in property booking based on admin settings. ";
                        if ($this->lang->line('Current Status') != '') { $note2= stripslashes($this->lang->line('Current Status')); }else $note2="Current Status ";
                        if ($this->lang->line('Enabled') != '') { $ena= stripslashes($this->lang->line('Enabled')); }else $ena="Enabled ";
                        if ($this->lang->line('Disabled') != '') { $dis= stripslashes($this->lang->line('Disabled')); }else $dis="Disabled ";
                        ?>
					
				</div>
				<p><b><?php  if ($this->lang->line('note') != '') { echo stripslashes($this->lang->line('note')); }else echo "Note"; ?>:</b> <?php echo $node1; echo $note2;  if ($instant_pay->row()->status == '1') { echo '<b> '.$ena.'</b>'; }else{ echo '<b> '.$dis.'</b>';}?></p>
			</div>
			<div class="clear text-right">
			
			<?php
            if ($this->lang->line('nxt_new') != '') {
				  $nxt= stripslashes($this->lang->line('nxt_new'));
            }else $nxt="Next";
            ?>
			
				<?php
				$instantpay = array('class' => 'submitBtn1', 'id' => 'list_submit');
				echo form_submit('list_submit', "$nxt", $instantpay);
				?>
			</div>

            <?php /*
			<div class="clear"><br>
				<?php if ($listDetail->row()->space == "" || $listDetail->row()->guest_access == "" || $listDetail->row()->interact_guest == "" || $listDetail->row()->neighbor_overview == "" || $listDetail->row()->neighbor_around == "" || $listDetail->row()->house_rules == "") { ?>
					<p class="text-muted text-justify"><?php if ($this->lang->line('Wanttowrite') != '') {
							echo stripslashes($this->lang->line('Wanttowrite'));
					} else echo "Want to write even more? You can also"; ?> <a
							href="<?= base_url(); ?>detail_list/<?php echo $listDetail->row()->id; ?>"> <?php if ($this->lang->line('addadetaileddescription') != '') {
								echo stripslashes($this->lang->line('addadetaileddescription'));
							} else echo "add a detailed description"; ?></a> <?php if ($this->lang->line('toyourlisting') != '') {
							echo stripslashes($this->lang->line('toyourlisting'));
						} else echo "to your listing"; ?>.</p>
				<?php } ?>
			</div>

 */ ?>
		</div>
		<div class="rightBlock">
			<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
				<?php
				if ($this->lang->line('greatsummary') != '') {
					echo stripslashes($this->lang->line('greatsummary'));
				} else
					echo "A great summary";
				?></h2>
			<p>
				<?php
				if ($this->lang->line('overview1_title_of_your') != '') {
					echo stripslashes($this->lang->line('overview1_title_of_your'));
				} else
					echo "Title of your rental will be displayed for the listings.";
				?>
			</p>
			<p>
				<?php
				if ($this->lang->line('overview2_summaryis_used') != '') {
					echo stripslashes($this->lang->line('overview2_summaryis_used'));
				} else
					echo "A summary is used to describe your rentals and its features, etc.";
				?>
			</p><p>
				<?php
				if ($this->lang->line('overview3_booking_options') != '') {
					echo stripslashes($this->lang->line('overview3_booking_options'));
				} else
					echo "Booking options available for the guests. Request to Book allows guest to contact the host for booking the property.";
				?>
			</p><p>
				<?php
				if ($this->lang->line('overview4_through_instant_pay') != '') {
					echo stripslashes($this->lang->line('overview4_through_instant_pay'));
				} else
					echo "Through Instant Pay guests can immediately book the rental property.";
				?>
			</p>
			<!-- <p>
				<?php
				if ($this->lang->line('Agreattitleisunique') != '') {
					echo stripslashes($this->lang->line('Agreattitleisunique'));
				} else
					echo "A great summary is rich and exciting! It should cover the major features of your space and neighborhood in 250 characters or less.";
				?>
			</p>
			<p><strong>
					<?php
					if ($this->lang->line('example') != '') {
						echo stripslashes($this->lang->line('example'));
					} else
						echo "Example:";
					?>
				</strong>
			<p>
				<?php
				if ($this->lang->line('Ourcooland2') != '') {
					echo stripslashes($this->lang->line('Ourcooland2'));
				} else
					echo "Our Cool And Comfortable One Bedroom Apartment With Exposed Brick Has A True City Feeling!";
				?></p>
			<p>
				<?php
				if ($this->lang->line('Ourcooland3') != '') {
					echo stripslashes($this->lang->line('Ourcooland3'));
				} else
					echo "It Comfortably Fits Two And Is Centrally Located On A Quiet Street,
        Just Two Blocks From Washington Park.";
				?></p>
			<p>
				<?php
				if ($this->lang->line('Ourcooland4') != '') {
					echo stripslashes($this->lang->line('Ourcooland4'));
				} else
					echo "Enjoy A Gourmet Kitchen, Roof Access, And Easy Access To All Major Subway Lines!";
				?></p> -->
		</div>
	</div>
	<!--Script to validate form submiting-->
	<script type="text/javascript">
		function validate_form() {
			 $('.loading').show();
			var title = $("#title");
			var summary = $("#summary");
			var contents = summary.val();
			var title_contents = title.val();
			var words = contents.split(/\b\S+\b/g).length - 1;
			var title_words = title_contents.split(/\b\S+\b/g).length - 1;

			var req = $('input[name="request_to_book"]:checked').val();
			var instant = $('input[name="instant_pay"]:checked').val();
			if (req == 'no' && instant == null) {
				document.getElementById("errordisplay").style.display = "block";
				document.getElementById("danger").innerHTML = "<?php  if ($this->lang->line('err_choose_yes') != '') {
					echo stripslashes($this->lang->line('err_choose_yes'));
				} else {
					echo "Please Choose Yes";
				} ?>";
				return false;
			}
			else {
				document.getElementById("errordisplay").style.display = "none";
				document.getElementById("danger").innerHTML = "";
			}

			if (title.val() == "" || summary.val() == "") {
				 $('.loading').hide();
				document.getElementById("errordisplay").style.display = "block";
				document.getElementById("danger").innerHTML = "<?php if ($this->lang->line('exp_fill_all_fields') != '') {
					echo stripslashes($this->lang->line('exp_fill_all_fields'));
				} else echo "Please fill all mandatory fields"; ?>";
				setTimeout(function () {
					document.getElementById("danger").innerHTML = "";
					document.getElementById("errordisplay").style.display = "none";
				}, 2000);
				return false;
			}
			else {
				document.getElementById("errordisplay").style.display = "none";
				document.getElementById("danger").innerHTML = "";
			}
			if(title.val() != '')
			{	
				var test = 0;
				$.ajax({
				  type: "POST",
				  async: false, 
				  url: '<?php echo base_url().'site/product/check_title_exists';?>',
				  data: {'title':title.val(),'id':'<?php echo $listDetail->row()->id;?>'},
				  success: function(data){
					if(data==0)
					{
						test = 1;
						document.getElementById("errordisplay").style.display = "none";
						document.getElementById("danger").innerHTML = "";
						
					}
					else
					{
						test = 0;
						document.getElementById("errordisplay").style.display = "block";
						document.getElementById("danger").innerHTML = "Title Already Exists!";
						setTimeout(function () {
							document.getElementById("danger").innerHTML = "";
							document.getElementById("errordisplay").style.display = "none";
						}, 2000);
						
						//return false;
					}
					
				  }
				  
				});
				if(test==0) { return false; }
				//return test;
			}
			if (words > 150) {
				document.getElementById("errordisplay").style.display = "block";
				document.getElementById("danger").innerHTML = "Total of " + words + " words found! Summary should not exceed 150 words!";
				return false;
			}
			else {
				document.getElementById("errordisplay").style.display = "none";
				document.getElementById("danger").innerHTML = "";
			}

			if (title_words > 15) {
				document.getElementById("errordisplay").style.display = "block";
				document.getElementById("danger").innerHTML = "Total of " + title_words + " words found! Title should not exceed 15 words!";
				return false;
			}
			else {
				document.getElementById("errordisplay").style.display = "none";
				document.getElementById("danger").innerHTML = "";
			}

		}
	</script>
	<!--Script to find title word count-->
	<?php 
				if ($this->lang->line('You can add') != '') {
					$you_can= stripslashes($this->lang->line('You can add'));
				} else {
					$you_can= "You can add";
				} 
	?>
	<input type="hidden" name="u_can" id="you_can" value="<?php echo $you_can; ?>">
	 
	 <?php 
				if ($this->lang->line('more_words') != '') {
					$more_words= stripslashes($this->lang->line('more_words'));
				} else {
					$more_words= "more words";
				} 
	?>
	<input type="hidden" name="" id="more_words" value="<?php echo $more_words; ?>">
	
	<?php 
				if ($this->lang->line('words_reached') != '') {
					$words_reached= stripslashes($this->lang->line('words_reached'));
				} else {
					$words_reached= "Words Reached";
				} 
	?>
	<input type="hidden" name="" id="words_reached" value="<?php echo $words_reached; ?>">
	
	
	<script type="text/javascript">
		var wordLen1 = 8, len1;
		var err1 = $("#you_can").val();
		var err2 = $("#more_words").val();
		var err3 = $("#words_reached").val();

		$('#title').keydown(function (event) {
			console.log(event.keyCode);
			len1 = $('#title').val().split(/[\s]+/);
			if (len1.length > wordLen1) {
				if (event.keyCode == 46 || event.keyCode == 8) {
					
					/*Allow backspace and delete buttons*/
				}
				else if (event.keyCode < 36 || event.keyCode > 57) { /*all other buttons*/
					event.preventDefault();
					
				}
			}
			wordsLeft = (wordLen1) - len1.length;
			if (wordsLeft <= 0) {
				document.getElementById("words_left_title").innerHTML = "8 " + err3;
			}
			else {
				$("#words_left_title").html( err1 + " " + wordsLeft + " " + err2);
			}
		});
	</script>
	<!--Script to find description word count-->
	<script type="text/javascript">
		var wordLenSum = 150, lenSum = "";
		var err_desc = $("#you_can").val();
		var errwrds_desc = $("#words_reached").val();
		var more_wrds = $("#more_words").val();
		
		$('#summary').keydown(function (event) {
			lenSum = $('#summary').val().split(/[\s]+/);
			if (lenSum.length > wordLenSum) {
				if (event.keyCode == 46 || event.keyCode == 8) {
					/*Allow backspace and delete buttons*/
				}
				else if (event.keyCode < 48 || event.keyCode > 57) {   /*all other buttons*/
					event.preventDefault();
				}
			}
			wordsLeftSum = (wordLenSum) - lenSum.length;
			if (wordsLeftSum < 0) {
				document.getElementById("words_left_summary").innerHTML = "150 " + errwrds_desc;
			}
			else {
				$("#words_left_summary").html(err_desc +" " + wordsLeftSum + " " + more_wrds);
			}
		});
	</script>
	<!--Script to check request to book and instant pay status -->
	<script type="text/javascript">
		function CheckStatus() {
			var req = $('input[name="request_to_book"]:checked').val();
			var prd_id = "<?php echo $listDetail->row()->id; ?>";
			var instant = $('input[name="instant_pay"]:checked').val();
			if (req == 'yes' && instant == null) {
				boot_alert("<?php  if ($this->lang->line('err_choose_yes') != '') {
					echo stripslashes($this->lang->line('err_choose_yes'));
				} else {
					echo "Please Choose Yes";
				} ?>");
				return false;
			}

			if (req != 'yes') {
				$('#instant_y').prop('checked', true);
			}
		}

		function CheckStatusTwo() {
			var instant = $('input[name="instant_pay"]:checked').val();
			var prd_id = "<?php echo $listDetail->row()->id; ?>";
			if (instant != 'yes') {
				$('#req_id_y').prop('checked', true);
			}
		}
	</script>
