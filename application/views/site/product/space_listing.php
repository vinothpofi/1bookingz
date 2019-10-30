<?php
$this->load->view('site/includes/header');
if ($this->lang->line('select') != '') {
	$SelectLabel = stripslashes($this->lang->line('select'));
} else $SelectLabel = "Select";
?>
<div class="manage_items">
	<div class="toggleMenuD">
		<div class="bar1"></div>
		<div class="bar2"></div>
		<div class="bar3"></div>
	</div>
	<?php
	$this->load->view('site/includes/listing_head_side');
	foreach ($listValues->result() as $result) {
		$values = $result->listing_values;
	}
	$roombedVal = json_decode($values);
	$product_list_decode = json_decode($listDetail->row()->listings);
	foreach ($product_list_decode as $product_list_name => $product_list_values) {
		$product_list_data[$product_list_name] = $product_list_values;
	}
	?>
	<div class="centeredBlock">
		<div class="content">
			<h3><?php if ($this->lang->line('ListingInfo') != '') {
					echo stripslashes($this->lang->line('ListingInfo'));
				} else echo "Listing Info"; ?>
			</h3>
			<p><?php if ($this->lang->line('Basicinformationabout') != '') {
					echo stripslashes($this->lang->line('Basicinformationabout'));
				} else echo "Basic information about your listing."; ?>
			</p>
			<div class="error-display" id="errordisplay" style="text-align: center; display: none;">
				<p class="text center text-danger" id="danger"></p>
				<p class="text center text-success" id="success"></p>
			</div>

			  <form name="space_listing" method="post"  accept-charset="UTF-8" id="listForm" >
			  <?php
			$pcount = 0;
			
			foreach ($listTypeValues->result() as $keys => $finals) {
				$name = $finals->name;
				$field_id = $finals->id;
				$selected = $product_list_values;
				$list_type = $finals->type;
				if ($name != 'can_policy') {
					$getChildValues = $this->product_model->get_all_details(LISTING_CHILD, array('parent_id' => $field_id));
					if ($list_type == 'option') {

						if ($getChildValues->num_rows() > 0) {

							?>
							<div class="form-group">
								<?php //print_r($finals->labelname) ?>
								<p><?php
                                    if($this->session->userdata('language_code') =='en')
                                    {
                                        $label_name = $finals->labelname;
                                    }
                                    else
                                    {
                                        $listAr='labelname_'.$this->session->userdata('language_code');
                                        if($finals->$listAr == '') { 
                                            $label_name=$finals->labelname;
                                        }
                                        else{
                                            $label_name=$finals->labelname_ar;
                                        }
                                    }
                                   
                                 // echo ucfirst($label_name).'--' ;
								 echo ucfirst(str_replace('_', ' ', $label_name));
									if ($finals->name == 'minimum_stay' || $finals->name == 'accommodates') { ?> <span
										class="impt">*</span><?php } ?>
								</p>



								<select class="select_option"   name="<?php echo $finals->name; ?>"  onchange="javascript:Detaillist(this,<?php echo $listDetail->row()->id; ?>,'<?php echo $finals->id; ?>');">

                            		 <?php

										 echo '<option value="">';
									 ?> <?php if($this->lang->line('select') != '') { echo stripslashes($this->lang->line('select')); } else echo "Select"; ?></option>
                            	<?php
                            	  foreach($product_list_decode as $product_list_name => $product_list_values)
									{

									 $product_list_data[$product_list_name] = $product_list_values;

									  }
                                print_r($product_list_values);
							   foreach($listchildValues->result() as $val){


							   	if($field_id == $val->parent_id){
							   		//print_r($val);exit;
                            	?>
                                      
								 <option value="<?php echo $val->id; ?>"  <?php if (in_array($val->id, $product_list_data)) {  echo 'selected="selected"'; }   ?> ><?php if($_SESSION['language_code']=="en")
                           { echo $val->child_name; } else{ echo $val->child_name; } ?></option>
								<?php } } ?>
                                  </select>


							</div>
							<?php
						}
					} else {
						?>
						<div class="form-group">
							<p><?php 
							if($this->session->userdata('language_code') =='en')
                                    {
                                        $label_name = $finals->labelname;
                                    }
                                    else
                                    {
                                        $listAr='labelname_'.$this->session->userdata('language_code');
                                        if($finals->$listAr == '') { 
                                            $label_name=$finals->labelname;
                                        }
                                        else{
                                            $label_name=$finals->labelname_ar;
                                        }
                                    }
							      echo ucfirst(str_replace('_', ' ', $label_name));
								if ($finals->name == 'minimum_stay') { ?> <span
									class="impt">*</span><?php } ?>
							</p>
							<?php


							echo form_input($finals->name, $product_list_data[$field_id], array('onchange' => "javascript:Detaillist(this," . $listDetail->row()->id . ",'" . $finals->id . "')"));
							?>
						</div>
						<?php
					}
				}
			} ?>



			<div class="clear text-right">

				<input type="button" name="list_submit" value="<?php
			if ($this->lang->line('Continue') != '') {
				echo stripslashes($this->lang->line('Continue'));
			} else
				echo "Continue";
			?>" id="list_submit" class="submitBtn1" onclick="checkMinimumStay();">
				  </form>
			</div>
		</div>
	</div>
	<div class="rightBlock">
		<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			<?php
			if ($this->lang->line('Listing') != '') {
				echo stripslashes($this->lang->line('Listing'));
			} else
				echo "Listing";
			?></h2>
		<p>
			<?php
			if ($this->lang->line('spacelisting1_help_guests') != '') {
				echo stripslashes($this->lang->line('spacelisting1_help_guests'));
			} else
				echo "Help guests to know a little more about your rental by listing basic information.";
			?>
		</p>
		<p>
			<?php
			if ($this->lang->line('spacelisting2_what_type_of') != '') {
				echo stripslashes($this->lang->line('spacelisting2_what_type_of'));
			} else
				echo "What type of Space you are providing, the room types, minimum days required to book the property, any other special requirements like party hall provided, etc.";
			?>
		</p>
		<p>
			<?php
			if ($this->lang->line('spacelisting3_if_host_wish') != '') {
				echo stripslashes($this->lang->line('spacelisting3_if_host_wish'));
			} else
				echo "If a host wish to add additional information, a special request has to be made with the admin.";
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
	<i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
</div>
	<?php
			if ($this->lang->line('exp_fill_all_fields') != '') {
			   $pls_fill= stripslashes($this->lang->line('exp_fill_all_fields'));
			} else {
			   $pls_fill= "Please fill all mandatory fields";
			}
	?>
	<input type="hidden" name="" id="pls_fill" value="<?php echo $pls_fill; ?>">
<script>
	function checkMinimumStay() {
		var pls_fill=$("#pls_fill").val();
		var guest_capacity = $('#listForm').find('select[name="accommodates"]').val();
		var minimum_stayVal = $('#listForm').find('select[name="minimum_stay"]').val();
        var homeType = $('#listForm').find('select[name="home_type"]').val();
		if (minimum_stayVal == "") {
			boot_alert(pls_fill);
			return false;
		} else if (homeType == "") {
			boot_alert(pls_fill);
		} else if (guest_capacity == "") {
			boot_alert(pls_fill);
		} else {
			  $('.loading').show();
			window.location.href = "<?php echo base_url() . "address_listing/" . $listDetail->row()->id;?>"
		}
	}
</script>
