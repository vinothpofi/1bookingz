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
			<h3><?php 
						if ($this->lang->line('basic_info') != '') {
                                echo stripslashes($this->lang->line('basic_info'));
                            } else echo "Basic Info";?>
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
			foreach ($listspace->result() as $value) {
				//print_r($value);
				$id = $value->id;
				$sql = "SELECT * FROM fc_listspace_values WHERE other='Yes' and listspace_id = " . $id;
				$inner = $this->db->query($sql);
				if ($inner->num_rows() > 0) {
					if ($value->attribute_seourl == 'propertytype') $type = 'home_type'; else if ($value->attribute_seourl == 'roomtype') $type = 'room_type';
					?>
					<div class="form-group">
						<p><?php 
						      // if($this->session->userdata('language_code') =='en')
            //                         {
            //                             $attr_name = $value->attribute_name;
            //                         }
            //                         else
            //                         {
            //                             $attrAr='attribute_name_'.$this->session->userdata('language_code');
            //                             if($value->$attrAr == '') { 
            //                                 $attr_name=$value->attribute_name;
            //                             }
            //                             else{
            //                                 $attr_name=$value->attribute_name_ar;
            //                             }
            //                         }
						$attr_name=language_dynamic_enable("attribute_name",$this->session->userdata('language_code'),$value);

                                   
                             //   echo ucfirst($attr_name).'--' ;, 'onChange' => "javascript:Detailview(this, " . $listDetail->row()->id . ",'" . $type . "')"
						echo ucfirst($attr_name); ?> <span class="impt">*</span></p>
						<?php
						$js = array('required' => 'required','disabled' => 'disabled');
						$options = array();
						//$options[""] = '';
						$selected = "";
						foreach ($inner->result() as $listvalues) {
							if ($pcount == 0) {
								$selected = trim($listDetail->row()->home_type);
							} else {
								$selected = trim($listDetail->row()->room_type);
							}
							        if($this->session->userdata('language_code') =='en')
                                    {
                                        $list_val = $listvalues->list_value;
                                    }
                                    else
                                    {
                                        $listAr='list_value_'.$this->session->userdata('language_code');
                                        if($listvalues->$listAr == '') { 
                                            $list_val=$listvalues->list_value;
                                        }
                                        else{
                                            $list_val=$listvalues->list_value_ar;
                                        }
                                    }
                                   
                               // echo ucfirst($list_val).'--' ;
							$options[$listvalues->id] = ucfirst($list_val);
						}
						echo form_dropdown('home_type', $options, $selected, $js);
						?>
					</div>
				<?php }
				$pcount++;
			}
			?>



			<div class="clear text-right">

				<input type="button" name="list_submit" value="<?php
			if ($this->lang->line('Continue') != '') {
				echo stripslashes($this->lang->line('Continue'));
			} else
				echo "Continue";
			?>" id="list_submit" class="submitBtn1" onclick="window.location.href='<?php echo base_url().'price_listing/'.$listDetail->row()->id; ?>'">
				  </form>
			</div>
		</div>
	</div>
	<div class="rightBlock">
		<h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
			<?php
			if ($this->lang->line('basic_info') != '') {
				echo stripslashes($this->lang->line('basic_info'));
			} else
				echo "basic_info";
			?></h2>
		<p>
			<?php
			if ($this->lang->line('basic_info1_gotsomespace') != '') {
				echo stripslashes($this->lang->line('basic_info1_gotsomespace'));
			} else
				echo "Got some space available for rent? Start earning by renting your free space.";
			?>
		</p>
		<p>
			<?php
			if ($this->lang->line('basic_info2_choosethetype') != '') {
				echo stripslashes($this->lang->line('basic_info2_choosethetype'));
			} else
				echo "Choose the type of Rentals property you are willing to rent and the Room types.";
			?>
		</p>
		<!-- <p><strong>
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
