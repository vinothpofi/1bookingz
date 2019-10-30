<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items">
	<?php
	$this->load->view('site/includes/listing_head_side');
	?>
	<div class="centeredBlock">
		<div class="content">
			<div class="form-group">
				<h3><?php if ($this->lang->line('detail_list') != '') {
						echo stripslashes($this->lang->line('detail_list'));
					} else echo "Details"; ?></h3>
				<h5><?php if ($this->lang->line('detail_list_description') != '') {
						echo stripslashes($this->lang->line('detail_list_description'));
					} else echo "A description of your space displayed on your public listing page"; ?>.</h5>
				<?php
				echo form_open('extra_description/' . $listDetail->row()->id, array('name' => 'overviewlist', 'id' => 'overviewlist', 'onsubmit' => 'loader();'));//, 'onsubmit' => 'return validate_form();'
				?>
				<p><?php if ($this->lang->line('The_Space') != '') {
						echo stripslashes($this->lang->line('The_Space'));
					} else echo "The Space"; ?>
				</p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'space')", 'onkeyup' => "count_characters(this,'space')", 'name' => 'space', 'id' => 'space', 'rows' => '5', 'placeholder' => ($this->lang->line('the_space_place') != '') ? stripslashes($this->lang->line('the_space_place')) : "what makes  your listing unique?", 'value' => $listDetail->row()->space)); ?>
				<span id="chars_left_space" class="text-danger"></span>
			</div>
			<!--Language dynamic-->
            <?php  foreach(language_dynamic_enable("space","") as $dynlang) {  ?>
                <div class="form-group">
                    <p><?php if ($this->lang->line('The_Space') != '') {
                            echo stripslashes($this->lang->line('The_Space'));
                        } else echo "The Space"; ?> (<?php echo $dynlang[0];?>)
                    </p>
                    <?= form_textarea(array('onpaste' => "count_characters(this,'$dynlang[1]')", 'onkeyup' => "count_characters(this,'$dynlang[1]')", 'name' => $dynlang[1], 'id' => 'space', 'rows' => '5', 'placeholder' => ($this->lang->line('the_space_place') != '') ? stripslashes($this->lang->line('the_space_place')) : "what makes  your listing unique?", 'value' => $listDetail->row()->{$dynlang[1]})); ?>
                    <span id="chars_left_<?php echo $dynlang[1];?>" class="text-danger"></span>
                </div>
            <?php } ?>
            <!--End Language dynamic-->
			<div class="form-group">
				<h3><?php if ($this->lang->line('detail_list_extra_detail') != '') {
						echo stripslashes($this->lang->line('detail_list_extra_detail'));
					} else echo "Extra Details"; ?></h3>
				<h5><?php if ($this->lang->line('detail_list_public_listing') != '') {
						echo stripslashes($this->lang->line('detail_list_public_listing'));
					} else echo "Other information you wish to share on your public listing page"; ?>. </h5>
				<p><?php if ($this->lang->line('other_things_to_note') != '') {
						echo stripslashes($this->lang->line('other_things_to_note'));
					} else echo "Other Things to Note"; ?></p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'other_thingnote')", 'onkeyup' => "count_characters(this,'other_thingnote')", 'name' => 'other_thingnote', 'id' => 'other_thingnote', 'rows' => '5', 'placeholder' => ($this->lang->line('other_things_to_note') != '') ? stripslashes($this->lang->line('other_things_to_note')) : "Other things to note", 'value' => $listDetail->row()->other_thingnote)); ?>
				<span id="chars_left_other_thingnote" class="text-danger"></span>
			</div>
			
			<div class="form-group">
				<p><?php if ($this->lang->line('house_rules') != '') {
						echo stripslashes($this->lang->line('house_rules'));
					} else echo "House Rules"; ?></p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'house_rules')", 'onkeyup' => "count_characters(this,'house_rules')", 'name' => 'house_rules', 'id' => 'house_rules', 'rows' => '5', 'placeholder' => ($this->lang->line('house_rules') != '') ? stripslashes($this->lang->line('house_rules')) : "House rules", 'value' => $listDetail->row()->house_rules)); ?>
				<span id="chars_left_house_rules" class="text-danger"></span>
			</div>			




			<div class="form-group">
				<p><?php if ($this->lang->line('guest_access') != '') {
						echo stripslashes($this->lang->line('guest_access'));
					} else echo "Guest access"; ?></p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'guest_access')", 'onkeyup' => "count_characters(this,'guest_access')", 'name' => 'guest_access', 'id' => 'guest_access', 'rows' => '5', 'placeholder' => ($this->lang->line('guest_access') != '') ? stripslashes($this->lang->line('guest_access')) : "Guest access", 'value' => $listDetail->row()->guest_access)); ?>
				<span id="chars_left_guest_access" class="text-danger"></span>
			</div>

	

			<div class="form-group">
				<p><?php if ($this->lang->line('interaction_with_guest') != '') {
						echo stripslashes($this->lang->line('interaction_with_guest'));
					} else echo "Interaction with guest"; ?></p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'interact_guest')", 'onkeyup' => "count_characters(this,'interact_guest')", 'name' => 'interact_guest', 'id' => 'interact_guest', 'rows' => '5', 'placeholder' => ($this->lang->line('interaction_with_guest') != '') ? stripslashes($this->lang->line('interaction_with_guest')) : "Interaction with guest", 'value' => $listDetail->row()->interact_guest)); ?>
				<span id="chars_left_interact_guest" class="text-danger"></span>
			</div>		


			

			<div class="form-group">
				<p><?php if ($this->lang->line('neighborhood') != '') {
						echo stripslashes($this->lang->line('neighborhood'));
					} else echo "Neighborhood"; ?></p>
				<?= form_textarea(array('onpaste' => "count_characters(this,'neighbor_overview')", 'onkeyup' => "count_characters(this,'neighbor_overview')", 'name' => 'neighbor_overview', 'id' => 'neighbor_overview', 'rows' => '5', 'placeholder' => ($this->lang->line('neighborhood') != '') ? stripslashes($this->lang->line('neighborhood')) : "Neighborhood", 'value' => $listDetail->row()->neighbor_overview)); ?>
				<span id="chars_left_neighbor_overview" class="text-danger"></span>
			</div>

			
<div class="form-group">
	  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?> 

                                        <p><?php if ($this->lang->line('other_things_to_note') != '') {
						echo stripslashes($this->lang->line('other_things_to_note'));
					} else echo "Other Things to Note"; ?>(<?php echo $data->name; ?>)</p>
			 <?= form_textarea(array('onpaste' => "count_characters(this,other_thingnote_$data->lang_code)", 'onkeyup' => "count_characters(this,other_thingnote_$data->lang_code)", 'name' => 'other_thingnote_'.$data->lang_code, 'id' => 'other_thingnote_'.$data->lang_code, 'rows' => '5', 'placeholder' => ($this->lang->line('other_things_to_note') != '') ? stripslashes($this->lang->line('other_things_to_note')) : "other things to note", 'value' => $listDetail->row()->{'other_thingnote_'.$data->lang_code})); ?>
                <span id="chars_left_<?php echo 'other_thingnote_'.$data->lang_code;?>" class="text-danger"></span>

                <p><?php if ($this->lang->line('house_rules') != '') {
                            echo stripslashes($this->lang->line('house_rules'));
                        } else echo "House Rules"; ?> (<?php echo $data->name;?>)</p>
                    <?= form_textarea(array('onpaste' => "count_characters(this,house_rules_$data->lang_code)", 'onkeyup' => "count_characters(this,house_rules_$data->lang_code)", 'name' => 'house_rules_'.$data->lang_code, 'id' => 'house_rules_'.$data->lang_code, 'rows' => '5', 'placeholder' => ($this->lang->line('house_rules') != '') ? stripslashes($this->lang->line('house_rules')) : "House rules", 'value' => $listDetail->row()->{'house_rules_'.$data->lang_code})); ?>
                    <span id="chars_left_<?php echo 'house_rules_'.$data->lang_code;?>" class="text-danger"></span>

                      <p><?php if ($this->lang->line('guest_access') != '') {
                            echo stripslashes($this->lang->line('guest_access'));
                        } else echo "Guest Access"; ?> (<?php echo $data->name;?>)</p>
                    <?= form_textarea(array('onpaste' => "count_characters(this,guest_access_$data->lang_code)", 'onkeyup' => "count_characters(this,guest_access_$data->lang_code)", 'name' => 'guest_access_'.$data->lang_code, 'id' => 'guest_access_'.$data->lang_code, 'rows' => '5', 'placeholder' => ($this->lang->line('guest_access') != '') ? stripslashes($this->lang->line('guest_access')) : "Guest Access", 'value' => $listDetail->row()->{'guest_access_'.$data->lang_code})); ?>
                    <span id="chars_left_<?php echo 'guest_access_'.$data->lang_code;?>" class="text-danger"></span>

                     <p><?php if ($this->lang->line('interact_guest') != '') {
                            echo stripslashes($this->lang->line('interact_guest'));
                        } else echo "Interaction With Guest"; ?> (<?php echo $data->name;?>)</p>
                    <?= form_textarea(array('onpaste' => "count_characters(this,interact_guest_$data->lang_code)", 'onkeyup' => "count_characters(this,interact_guest_$data->lang_code)", 'name' => 'interact_guest_'.$data->lang_code, 'id' => 'interact_guest_'.$data->lang_code, 'rows' => '5', 'placeholder' => ($this->lang->line('interact_guest') != '') ? stripslashes($this->lang->line('interact_guest')) : "Interaction With Guest", 'value' => $listDetail->row()->{'interact_guest_'.$data->lang_code})); ?>
                    <span id="chars_left_<?php echo 'interact_guest_'.$data->lang_code;?>" class="text-danger"></span>

                     <p><?php if ($this->lang->line('neighborhood') != '') {
                            echo stripslashes($this->lang->line('neighborhood'));
                        } else echo "Neighborhood"; ?> (<?php echo $data->name;?>)</p>
                    <?= form_textarea(array('onpaste' => "count_characters(this,neighbor_overview_$data->lang_code)", 'onkeyup' => "count_characters(this,neighbor_overview_$data->lang_code)", 'name' => 'neighbor_overview_'.$data->lang_code, 'id' => 'neighbor_overview_'.$data->lang_code, 'rows' => '5', 'placeholder' => ($this->lang->line('neighborhood') != '') ? stripslashes($this->lang->line('neighborhood')) : "Neighborhood", 'value' => $listDetail->row()->{'neighbor_overview_'.$data->lang_code})); ?>
                    <span id="chars_left_<?php echo 'neighbor_overview_'.$data->lang_code;?>" class="text-danger"></span>

                                <?php

                                    }
                                }

                                ?>
</div>

			<div class="clear text-right">
			 <?php 
				if ($this->lang->line('Next') != '') 
				{
					$nxt= stripslashes($this->lang->line('Next'));
				} else { 
					$nxt= "Next"; 
				}
				echo form_submit('list_submit', $nxt, array('class' => 'submitBtn1', 'id' => 'list_submit'));
				?>
			
				<?php //anchor('photos_listing/' . $this->uri->segment(2), "$nxt", array('class' => 'submitBtn1')); ?>

			</div>
		</div>
		<div class="rightBlock">
			<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
				<?php if ($this->lang->line('detail_list_about_space') != '') {
					echo stripslashes($this->lang->line('detail_list_about_space'));
				} else echo "About your space"; ?></h2>

			<p><?php if ($this->lang->line('detail_list1_describe_the_unique') != '') {
					echo stripslashes($this->lang->line('detail_list1_describe_the_unique'));
				} else echo "Describe the unique details about your rentals and grab the attention of the guests."; ?></p>

			<p><?php if ($this->lang->line('detail_list2_what_arethe') != '') {
					echo stripslashes($this->lang->line('detail_list2_what_arethe'));
				} else echo "What are the things guests need to note?"; ?></p>

			<p><?php if ($this->lang->line('detail_list3_what_arehouse') != '') {
					echo stripslashes($this->lang->line('detail_list3_what_arehouse'));
				} else echo "What are House rules guests must follow during the stay?"; ?></p>

			<p><?php if ($this->lang->line('detail_list4_list_the_things') != '') {
					echo stripslashes($this->lang->line('detail_list4_list_the_things'));
				} else echo "List the things guests have access to in your property. <br><b>Example:</b> Access to Wifi, dishwasher, etc. "; ?></p>

			<p><?php if ($this->lang->line('detail_list5_interact_with_the') != '') {
					echo stripslashes($this->lang->line('detail_list5_interact_with_the'));
				} else echo "Interact with the guest by giving additional information about your property.<br><b> Example</b>: caretaker available, etc. "; ?></p>
				
			<p><?php if ($this->lang->line('detail_list6_let_know_guests') != '') {
					echo stripslashes($this->lang->line('detail_list6_let_know_guests'));
				} else echo "Let your guests know how is the neighbourhood of your property. Restaurants, Malls, Gym availability, etc."; ?></p>

			<!-- <p><?php if ($this->lang->line('detail_list_unique') != '') {
					echo stripslashes($this->lang->line('detail_list_unique'));
				} else echo "What makes your listing unique?"; ?></p>
			<p><?php if ($this->lang->line('detail_list_comfortably') != '') {
				echo stripslashes($this->lang->line('detail_list_comfortably'));
			} else echo "How many people does your listing comfortably fit?"; ?><p> -->
		</div>
	</div>
	
	<?php 
				if ($this->lang->line('You can add') != '') {
					$you_can= stripslashes($this->lang->line('You can add'));
				} else {
					$you_can= "You can add";
				} 
	?>
	<input type="hidden" name="u_can" id="you_can" value="<?php echo $you_can; ?>">
	
	<?php 
			if ($this->lang->line('more_charecters') != '') {
				$more_char= stripslashes($this->lang->line('more_charecters'));
			} else {
				$more_char= "more characters";
			} 
	?>
	<input type="hidden" name="" id="more_char" value="<?php echo $more_char; ?>">
	<?php 
			if ($this->lang->line('u_reached_the') != '') {
				$u_reached= stripslashes($this->lang->line('u_reached_the'));
			} else {
			   $u_reached= "You reached the character limit";
			} 
	?>
	<input type="hidden" name="" id="u_reached" value="<?php echo $u_reached; ?>">
	
	<?php 
			if ($this->lang->line('single_the') != '') {
				$the= stripslashes($this->lang->line('single_the'));
			} else {
			   $the= "The";
			} 
	?>
	<input type="hidden" name="" id="the" value="<?php echo $the; ?>">
	
	<?php 
			if ($this->lang->line('shouldnt_exceed') != '') {
				$not_exceed= stripslashes($this->lang->line('shouldnt_exceed'));
			} else {
			   $not_exceed= "should not exceed";
			} 
	?>
	<input type="hidden" name="" id="not_exceed" value="<?php echo $not_exceed; ?>">
	
	<?php 
			if ($this->lang->line('single_char') != '') {
			  $char= stripslashes($this->lang->line('single_char'));
			} else {
			   $char= "Characters";
			} 
	?>
	<input type="hidden" name="" id="char" value="<?php echo $char; ?>">
	
	
	<!--Script to validate form submiting-->
	<script type="text/javascript">
		function count_characters(data, update_field) {
			var err1=$("#you_can").val();
			var more_char=$("#more_char").val();
			var u_reached=$("#u_reached").val();
			var the=$("#the").val();
			var not_exceed=$("#not_exceed").val();
			var charrec=$("#char").val();
			
			var contents = data.value;
			var characters = contents.length;
			if (characters > 250) {
				var split_by_uncerscore = update_field.replace("_", " ");
				$("#chars_left_" + update_field).html( the + " " + split_by_uncerscore + not_exceed +"  250 " + charrec);
				return false; 
			}
			else {
				var chars_remaining = 250 - parseInt(characters);
				if (parseInt(chars_remaining) > 0) {
					$("#chars_left_" + update_field).html(err1 + " " + chars_remaining + " " + more_char);
				}
				else if (parseInt(chars_remaining) <= 0) {
					$("#chars_left_" + update_field).html( u_reached );
					return false;
				}
				Detailview_admin(data,<?php echo $listDetail->row()->id; ?>, update_field);
			}
		}
	</script>
