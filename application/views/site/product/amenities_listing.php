<?php
$this->load->view('site/includes/header');
?>
<div class="manage_items manageDesc">
    <?php
    $this->load->view('site/includes/listing_head_side');
    ?>
    <div class="centeredBlock">
        <div class="content">
            <div class="">
                <div class="error-display" id="errordisplay" style="text-align: center; display: none;">
                    <p class="text center text-danger" id="danger"></p>
                    <p class="text center text-success" id="success"></p>
                </div>
            </div>
            <?php
            echo form_open("space_listing/" . $listDetail->row()->id, array('name' => 'amenities', 'onsubmit' => 'return validate_form();'));
            ?>

			
            <?php
            if ($listItems->num_rows() > 0) {
                foreach ($listItems->result() as $list) {
                    ?>
                    <div class="row checkboxList">
                        <h3><?php
                            if ($list->attribute_name != 'Extras') {
                                if($this->session->userdata('language_code') =='en')
                                    {
                                        $attribute_name = $list->attribute_name;
                                    }
                                    else
                                    {
                                        $cityAr='attribute_name_'.$this->session->userdata('language_code');
                                        if($list->$cityAr == '') { 
                                            $attribute_name=$list->attribute_name;
                                        }
                                        else{
                                            $attribute_name=$list->attribute_name_ar;
                                        }
                                    }
                                echo $attribute_name;
                            } ?>
                        </h3>
                        <p class="desc"><?php
                                  if($this->session->userdata('language_code') =='en')
                                    {
                                        $attribute_title = $list->attribute_title;
                                    }
                                    else
                                    {
                                        $cityAr='attribute_title_'.$this->session->userdata('language_code');
                                        if($list->$cityAr == '') { 
                                            $attribute_title=$list->attribute_title;
                                        }
                                        else{
                                            $attribute_title=$list->attribute_title_ar;
                                        }
                                    }
                         echo ucfirst($attribute_title); ?> </p>
                        <?php
                        if ($list->attribute_name != 'Extras') {
                            $list_name = $listDetail->row()->list_name;
                            $facility = (explode(",", $list_name));
                            $listValues = $this->product_model->get_all_details(LIST_VALUES, array('list_id' => $list->id,'status' => 'Active'));
                            if ($listValues->num_rows() > 0) {
                                foreach ($listValues->result() as $details) {
                                    ?>
                                    <div class="col-sm-6 form-group">
                                        <label>

                                              <span class="checkboxStyle">

                                                <input type="checkbox" class="hideTemp" name="list_name[]"
                                                       onclick="saveAmenitieslist();"
                                                       id="amenities-<?php echo $details->id; ?>" <?php if (in_array($details->id, $facility)) { ?>
                                                       checked="checked" <?php } ?>value="<?php echo $details->id; ?>"/>
                                                  <!-- <?php
                                                  $pernight = array('id' => 'amenities-' . $details->id, 'onclick' => 'saveAmenitieslist();', 'class' => 'hideTemp');
                                                  echo form_checkbox('list_name[]', $details->id, '<?php if (in_array($details->id,$facility)) ?>{}', $pernight);
                                                  ?>  -->

                                                <i class="fa fa-check" aria-hidden="true"></i>

                                              </span>
                                            <div class=""><?php
                                          //  print_r($listValues);
                                            if($this->session->userdata('language_code') =='en')
                                            {
                                                $list_value = $details->list_value;
                                            }
                                            else
                                            {

                                                $listAr='list_value_'.$this->session->userdata('language_code');
                                                if($list->$listAr == '') { 
                                                    $list_value=$details->list_value;
                                                }
                                                else{
                                                    $list_value=$details->list_value_ar;
                                                }
                                            }
                                               echo ucfirst($list_value);
                                            // echo $details->list_value; ?></div>
                                        </label>
                                    </div>
                                    <?php
                                }
                                ?>
                                <input type="hidden" name="countOfListVal" id="countOfListVal" value="Yes">
                            <?php } else { ?>
							
							
				 <?php if ($this->lang->line('no_amenities_in_list') != '') {
							$no_amenity= stripslashes($this->lang->line('no_amenities_in_list'));
					} else $no_amenity ="No Amenities in This List"; ?>
				
                                <div class='text-danger text-center'><?php echo $no_amenity; ?>....!</div>
                            <?php }
                        }
                        ?>
                    </div>
                    <?php
                }
            } else { ?>
			
			
			
					<?php if ($this->lang->line('the_listing_will_be') != '') {
							$the_listing= stripslashes($this->lang->line('the_listing_will_be'));
					} else $the_listing ="The listing will be previewed after activating it in the admin"; ?>
			
                <div class=''><?php echo $the_listing; ?>...!</div>
                <?php
            }
            ?>
            <div class="clear text-right">
			
			 <?php if ($this->lang->line('Next') != '') {
						$nxt= stripslashes($this->lang->line('Next'));
                } else $nxt= "Next"; ?>
				
                <?php
                $amntieattr = array('name' => '', 'value' => "$nxt", 'class' => 'submitBtn1', 'id' => '');
                echo form_submit($amntieattr);
                ?>
            </div>
            <input type="hidden" name="id" id="property_id" value="<?php echo $listDetail->row()->id; ?>"/>
            <?php echo form_close(); ?>
        </div>
        <div class="rightBlock">
            <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                <?php if ($this->lang->line('Your Amenities') != '') {
                    echo stripslashes($this->lang->line('Your Amenities'));
                } else echo "Your Amenities"; ?>
            </h2>
            <p>
                <?php if ($this->lang->line('amenities1_amenities_play') != '') {
                    echo stripslashes($this->lang->line('amenities1_amenities_play'));
                } else echo "Amenities play an important role for the guest to choose the property. List the special features provided to the guest."; ?>.
            </p>
            <p>
                <?php if ($this->lang->line('amenities2_example') != '') {
                    echo stripslashes($this->lang->line('amenities2_example'));
                } else echo "<b>Example</b>: Free wifi, dishwasher, hair dryer, free breakfast, etc."; ?>.
            </p> 
           <!--  <p>
                <?php if ($this->lang->line('This is for guest notice about the special features provided by you') != '') {
                    echo stripslashes($this->lang->line('This is for guest notice about the special features provided by you'));
                } else echo "This is for guest notice about the special features provided by you"; ?>.
            </p> -->
        </div>
    </div>
    <!-- script to save amenities -->
    <script type="text/javascript">
        function saveAmenitieslist() {
			
            var str = '';
            var id = $('#property_id').val();
            $("input[type=checkbox]").each(function () {
                if ($(this).is(':checked')) {
                    if ($(this).val() != 'on') {
                        str = str + ',' + $(this).val();
                    }
                }
            });
            if(str == ''){
                var atleast=$("#atleast").val();
                document.getElementById('errordisplay').style.display = 'block';
                    document.getElementById('danger').innerHTML = atleast;
                     
                    setTimeout(function () {
                        document.getElementById('danger').innerHTML = '';
                        document.getElementById('errordisplay').style.display = 'none';
                    }, 5000);
                    
                    return false;
            }
            $.ajax(
                {
                    type: 'POST',
                    url: '<?php echo base_url(); ?>' + 'site/product/saveAmenitieslist_ajax',
                    data: {'string': str, 'id': id},
                    success: function (data) {
                    }
                });
        }
    </script>
    <!-- script to validate form -->
	
	<?php 
			if ($this->lang->line('pls_check') != '') {
			  $atleast= stripslashes($this->lang->line('pls_check'));
			} else {
			   $atleast= "Please check at least one amenities";
			} 
	?>
	<input type="hidden" name="" id="atleast" value="<?php echo $atleast; ?>">
	
	
    <script>
        function validate_form() {
			//var totalCheckboxes = $('input:checkbox').length;
			//alert(totalCheckboxes); return false;
             $('.loading').show();
			var atleast=$("#atleast").val();
            var countOfList = $("#countOfListVal").val();
            if (countOfList == 'Yes') {
                var count = 0;
                var a = document.getElementsByName("list_name[]");
                for (var i = 0; i < a.length; i++) {
                    if (a[i].checked == true)
                        count++;
                }
                if (count == 0) {
                    document.getElementById('errordisplay').style.display = 'block';
                    document.getElementById('danger').innerHTML = atleast;
                     
                    setTimeout(function () {
                        document.getElementById('danger').innerHTML = '';
                        document.getElementById('errordisplay').style.display = 'none';
                    }, 5000);
                    $('.loading').hide();
                    return false;
                }
            }
        }
    </script>