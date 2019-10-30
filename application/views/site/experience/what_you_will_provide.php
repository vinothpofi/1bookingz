<?php
$this->load->view('site/includes/header');
$disabled = 'false';
$exp_type = $listDetail->row()->exp_type;
?>
<div class="manage_items">
    <div class="toggleMenuD">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
    <?php
    $this->load->view('site/experience/experience_head_side');
    ?>
    <div class="centeredBlock">
        <div class="content">
            <h3><?php if ($this->lang->line('comfirm_what_will_provide') != '') {
                    echo stripslashes($this->lang->line('comfirm_what_will_provide'));
                } else echo "Confirm what you'll provide"; ?></h3>
            <p><?php if ($this->lang->line('comfirm_what_will_provide_summary') != '') {
                    echo stripslashes($this->lang->line('comfirm_what_will_provide_summary'));
                } else echo "On this page, you can ass additional details about what you are providing. For example, you can let your guests know that you accomodate vegetarians.."; ?></p>
            <div>
                <?php
                echo form_open('#', array('onsubmit' => 'return validate_form_new(event)', 'name' => 'overviewlist', 'id' => 'overviewlist'));
                echo form_input(array('type' => 'hidden', 'name' => 'experience_id', 'id' => 'experience_id', 'value' => $listDetail->row()->experience_id));
                echo form_input(array('type' => 'hidden', 'name' => 'kit_id', 'id' => 'kit_id'));
                ?>
                <div class="clear text-right">
                    <button type="button" class="submitBtn1" id='add_btn_new' onclick="add_new_item()">
                        + <?php if ($this->lang->line('exp_add_new_item') != '') {
                            echo stripslashes($this->lang->line('exp_add_new_item'));
                        } else echo "Add new item"; ?></button>
                    <br><br>
                </div>
                <div class="form-group">
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th><?php if ($this->lang->line('exp_item') != '') {
                                    echo stripslashes($this->lang->line('exp_item'));
                                } else echo "Item"; ?></th>
                            <th><?php if ($this->lang->line('detail_list') != '') {
                                    echo stripslashes($this->lang->line('detail_list'));
                                } else echo "Details"; ?></th>
                            <th><?php if ($this->lang->line('exp_quantity') != '') {
                                    echo stripslashes($this->lang->line('exp_quantity'));
                                } else echo "Quantity"; ?></th>
                            <th><?php if ($this->lang->line('list_Description') != '') {
                                    echo stripslashes($this->lang->line('list_Description'));
                                } else echo "Description"; ?></th>
                            <th><?php if ($this->lang->line('Action') != '') {
                                    echo stripslashes($this->lang->line('Action'));
                                } else echo "Action"; ?></th>
                        </tr>
                        <?php
                        if ($guide_provides->num_rows() > 0) {
                            foreach ($guide_provides->result() as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row->kit_title; ?></td>
                                    <td><?php echo $row->kit_detailed_title; ?></td>
                                    <td><?php echo $row->kit_count; ?> </td>
                                    <td><?php echo $row->kit_description; ?></td>
                                    <td>
                                        <p>
                                          <?php  if($lang_count != 0) {?>
                                            <span class="action-icons c-edit"
                                                 onclick="javascript:get_activity_data_dynamic('<?php echo $row->id; ?>','<?php echo $row->kit_title; ?>','<?php 
                                                 foreach(language_dynamic_enable("kit_title", "") as $dynlang) {echo $row->{$dynlang[1]};} ?>','<?php echo $row->kit_detailed_title; ?>','<?php 
                                                 foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) {echo $row->{$dynlang[1]};} ?>','<?php echo $row->kit_count; ?>','<?php echo $row->kit_description; ?>','<?php 
                                                 foreach(language_dynamic_enable("kit_description", "") as $dynlang) {echo $row->{$dynlang[1]};} ?>');"

                                                 title="Edit"
                                                 style="cursor: pointer;"><a><?php if ($this->lang->line('back_Edit') != '') {
                                                        echo stripslashes($this->lang->line('back_Edit'));
                                                    } else echo "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>"; ?></a></span>
                                                     <?php  }else {?>
                                                         <span class="action-icons c-edit"
                                                 onclick="javascript:get_activity_data('<?php echo $row->id; ?>','<?php echo $row->kit_title; ?>','<?php echo $row->kit_detailed_title; ?>','<?php echo $row->kit_count; ?>','<?php echo $row->kit_description; ?>');"

                                                 title="Edit"
                                                 style="cursor: pointer;"><a><?php if ($this->lang->line('back_Edit') != '') {
                                                        echo stripslashes($this->lang->line('back_Edit'));
                                                    } else echo "<i class='fa fa-pencil-square-o' aria-hidden='true'></i>"; ?></a></span>
                                                          <?php  }?>
                                            |
                                            <span><a class="action-icons c-delete"
                                                     href="<?= base_url(); ?>site/experience/delete_kit_package/<?php echo $row->id; ?>/<?php echo $row->experience_id; ?>"
                                                     title="Delete"><i class="fa fa-trash-o delete-icon fa-lg"
                                                                       aria-hidden="true"></i> </a></span>
                                        </p>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5">
                                    <p class="text-center text-danger"><?php if ($this->lang->line('exp_no_items_added') != '') {
                                            echo stripslashes($this->lang->line('exp_no_items_added'));
                                        } else echo "No Items added.."; ?></p>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
                </div>
                </div>
            </div>
            <div class="row add_new_item" style="display:none;">
                <p class="text-danger error text-center"
                   style="display: none;"><?php if ($this->lang->line('exp_fill_all_fields') != '') {
                        echo stripslashes($this->lang->line('exp_fill_all_fields'));
                    } else echo "Please fill all mandatory fields"; ?></p>
                <p class="text-danger text-center" id="customError"></p>
                <div class="form-group">
                    <div class="col-md-4">
                        <p><?php if ($this->lang->line('exp_item') != '') {
                                echo stripslashes($this->lang->line('exp_item'));
                            } else echo "Item"; ?> <span class="impt">*</span></p>
                        <?= form_input('kit_title', '', array('id' => 'kit_title', 'maxlength' => '60', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_title_char_count">60</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>

                   

                    </div>
                    <div class="col-md-4">
                        <p><?php if ($this->lang->line('exp_about_item') != '') {
                                echo stripslashes($this->lang->line('exp_about_item'));
                            } else echo "About Item"; ?> <span class="impt">*</span></p>
                        <?= form_input('kit_detailed_title', '', array('id' => 'kit_detailed_title', 'maxlength' => '60', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_detailed_title_char_count">60</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>

                       
                    </div>
                    <div class="col-md-4">
                        <p><?php if ($this->lang->line('exp_quantity') != '') {
                                echo stripslashes($this->lang->line('exp_quantity'));
                            } else echo "Quantity"; ?></p>
                        <?= form_input('kit_count', '', array('id' => 'kit_count', 'maxlength' => '5', 'onkeypress' => 'return isNumberKey(event);', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_count_char_count">5</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>
                    </div>
                    <div class="col-md-12">
                        <p><?php if ($this->lang->line('list_Description') != '') {
                                echo stripslashes($this->lang->line('list_Description'));
                            } else echo "Description"; ?></p>
                        <?= form_textarea('kit_description', '', array('id' => 'kit_description', 'maxlength' => '150', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_description_char_count">150</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>
                        
  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>

                             <?php  //foreach(language_dynamic_enable("kit_title", "") as $dynlang) { ?>
                        <p><?php if ($this->lang->line('exp_item') != '') {
                                echo stripslashes($this->lang->line('exp_item'));
                            } else echo "Item"; ?> (<?php echo $data->name; ?>) <span class="impt">*</span></p>
                        <?= form_input('kit_title_'.$data->lang_code, '', array('id' => 'kit_title_'.$data->lang_code, 'maxlength' => '60', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_title_fr_char_count">60</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>
                        <?php //} ?>


                             <?php // foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) { ?>    
                        <p><?php if ($this->lang->line('exp_about_item') != '') {
                                echo stripslashes($this->lang->line('exp_about_item'));
                            } else echo "About Item"; ?> In (<?php echo $data->name; ?>) <span class="impt">*</span></p>
                        <?= form_input('kit_detailed_title_'.$data->lang_code, '', array('id' =>'kit_detailed_title_'.$data->lang_code, 'maxlength' => '60', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_detailed_title_char_count">60</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>
                    <?php //} ?>
                     
                      <?php  //foreach(language_dynamic_enable("kit_description", "") as $dynlang) { ?>
                       <p><?php if ($this->lang->line('list_Description') != '') {
                                echo stripslashes($this->lang->line('list_Description'));
                            } else echo "Description"; ?>In (<?php echo $data->name; ?>)</p>
                        <?= form_textarea('kit_description_'.$data->lang_code, '', array('id' => 'kit_description_'.$data->lang_code, 'maxlength' => '150', 'onkeyup' => 'char_count(this)')); ?>
                        <p>
                            <span id="kit_description_char_count">150</span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                                echo stripslashes($this->lang->line('exp_characters_remaining'));
                            } else echo "characters remaining"; ?></p>
                     <?php }}?>

                    </div>
                    <div class="col-md-12 text-right">
					
					<?php if ($this->lang->line('exp_update') != '') {
                                $update= stripslashes($this->lang->line('exp_update'));
                            } else $update= "Update"; ?>
					
                        <?php
                        echo form_button('', ($this->lang->line('Submit') != '') ? stripslashes($this->lang->line('Submit')) : 'Submit', array('class' => 'submitBtn1', 'id' => 'add_btn', 'onclick' => 'add_kit()'));
                        echo form_button('', $update, array('class' => 'submitBtn1', 'id' => 'update_btn', 'onclick' => 'update_tab2()', 'style' => 'display:none;'));
                        echo form_button('', ($this->lang->line('Cancel') != '') ? stripslashes($this->lang->line('Cancel')) : 'Cancel', array('class' => 'submitBtn1', 'id' => 'reset_btn', 'onclick' => 'reset_reload()'));
                        ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="divider"></div>
                </div>
            </div>
            <div class="clear text-right">
                <?php
                echo form_button('', ($this->lang->line('Continue') != '') ? stripslashes($this->lang->line('Continue')) : 'Continue', array('class' => ($what_will_provide == 0) ? "disabled_exp submitBtn1 continue" : 'submitBtn1 continue', 'id' => 'next-btn'));
                ?>
            </div>
            <?php
            echo form_close();
            ?>
        </div>
   <!--  </div> -->
    <div class="rightBlock">
        <h2><i class="fa fa-lightbulb-o"
               aria-hidden="true"></i><?php if ($this->lang->line('experience_details_hospitality') != '') {
                echo stripslashes($this->lang->line('experience_details_hospitality'));
            } else echo "What kind of hospitality you offer?"; ?></h2>
        <p><?php if ($this->lang->line('Let_your_guests_know_what') != '') {
                echo stripslashes($this->lang->line('Let_your_guests_know_what'));
            } else echo "Let your guests know what their host will be providing them during the experience days. Give your guests the best experience to make it memorable."; ?></p> 
       <!--  <p><?php if ($this->lang->line('exp_great_summary_hospitality') != '') {
                echo stripslashes($this->lang->line('exp_great_summary_hospitality'));
            } else echo "Let your guests know if you’ll be including anything for this experience. To make your experience a memorable one, you can provide meal, drink, transportation, accommodations etc for your guest as a part of refreshment."; ?></p>
        <p><strong> <?php if ($this->lang->line('example') != '') {
                    echo stripslashes($this->lang->line('example'));
                } else echo "Example"; ?>:</strong><?php if ($this->lang->line('Itwillonly_hospitality') != '') {
                echo stripslashes($this->lang->line('Itwillonly_hospitality'));
            } else echo "Snack, Paragliding equipment "; ?>   </p> -->
    </div>
</div>
<script>
    /*Next button link*/
    $(document).ready(function () {
        $('#next-btn').click(function (e) {
            has = $(this).hasClass("disabled_exp");
            if (has == false) {
                window.location.href = '<?php echo base_url() . "notes_to_guest/" . $id; ?>';
            }
        });
    });

    /*Character count */
    function char_count(obj) {
        value_str = obj.value.trim();
        var length = value_str.length;
        var maxlength = $(obj).attr('maxlength');
        var id = obj.id;
        var length = maxlength - length;
        $('#' + id + '_char_count').text(length);
    }

    /*Add new button click*/
    function add_new_item() {
        $('.add_new_item').show();
        $('.loading').show();
        setTimeout(function() { $(".loading").hide(); }, 300);
        continue_button_manage('hide');
        document.getElementById("overviewlist").reset();
    }

    /*Continue button*/
    function continue_button_manage(status) {
        if (status == "show") {
            $('.continue').removeClass('disabled_exp');
        } else {
            $('.continue').addClass('disabled_exp');
        }
    }

    /*Check for only number*/
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    /*add item close button*/
    function reset_reload() {
        $('.add_new_item').hide();
        continue_button_manage('show');
    }

    /*Add kit to db*/
   function add_kit() {
       /* var main_title = $("#main_title").val();
        var main_title_ar = $("#main_title_ar").val();
        var detailed_title = $("#detailed_title").val();
        var detailed_title_ar = $("#detailed_title_ar").val();
        var kit_description = $("#kit_description").val();
        var kit_description_ar = $("#kit_description_ar").val();
        var kit_count = $("#kit_count").val();
        var experience_id = $("#experience_id").val();*/
        var kit_title = $("#kit_title").val();
         var kit_detailed_title = $("#kit_detailed_title").val();
          var kit_description = $("#kit_description").val();
           var kit_count = $("#kit_count").val();
        
        $('.loading').show();
         var experience_id = $("#experience_id").val();
         //alert(experience_id);
        if (kit_title != '' && kit_detailed_title != '') {            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>site/experience/saveKit',
                data: $('#overviewlist').serialize(),
                /*data: {
                    main_title: main_title,
                    main_title_ar: main_title_ar,
                    kit_count: kit_count,
                    detailed_title: detailed_title,
                    detailed_title_ar: detailed_title_ar,
                    kit_description: kit_description,
                    kit_description_ar: kit_description_ar,
                    experience_id: experience_id
                },*/
                dataType: 'json',
                success: function (data) {
                    if (data.case == 1) {
                        window.location.reload();
                    }
                    else if (data.case == 2) {
                        window.location.reload();
                    }
                    else if (data.case == 3) {
                        $('.loading').hide();
                        $("#customError").html('Already Exists');
                    }
                    else if (data.case == 4) {
                        $('.loading').hide();
                        $("#customError").html('Not Valid Times');
                        $('#kit_title').val('');

                       
 $('#<?php foreach(language_dynamic_enable("kit_title", "") as $dynlang) {echo $dynlang[1];}  ?>').val('');

                        $('#kit_detailed_title').val('');
                        //$('#detailed_title').val('');
 $('#<?php foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) {echo $dynlang[1];}  ?>').val('');
                        $('#kit_description').val('');
                        
 $('#<?php foreach(language_dynamic_enable("kit_description", "") as $dynlang) {echo $dynlang[1];}  ?>').val('');
                    }
                }
            });
        }
        else {
             $('.loading').hide();
            $('.error').fadeIn('slow', function () {
                $(this).delay(5000).fadeOut('slow');
            });
            return false;
        }
    }
     
  
    <?php  if($lang_count != 0) {?>
    /*Edit added kit*/
    function get_activity_data_dynamic(kit_id, kit_title,<?php foreach(language_dynamic_enable("kit_title", "") as $dynlang) {echo $dynlang[1];}  ?>, kit_detailed_title, <?php foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) {echo $dynlang[1];}  ?>, kit_count, kit_description,<?php foreach(language_dynamic_enable("kit_description", "") as $dynlang) {echo $dynlang[1];}  ?> ) {
        $('.loading').show();
        setTimeout(function() { $(".loading").hide(); }, 500);
        $('.add_new_item').show();
        continue_button_manage('hide');
        $('#kit_id').val(kit_id);
        $('#kit_title').val(kit_title);              
        $('#<?php foreach(language_dynamic_enable("kit_title", "") as $dynlang) {echo $dynlang[1];}  ?>').val(<?php foreach(language_dynamic_enable("kit_title", "") as $dynlang) {echo $dynlang[1];}  ?>);
        $('#kit_detailed_title').val(kit_detailed_title);
        $('#<?php foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) {echo $dynlang[1];}  ?>').val(<?php foreach(language_dynamic_enable("kit_detailed_title", "") as $dynlang) {echo $dynlang[1];}  ?>);
        $('#kit_count').val(kit_count);
        $('#kit_description').val(kit_description);
        $('#<?php foreach(language_dynamic_enable("kit_description", "") as $dynlang) {echo $dynlang[1];}  ?>').val(<?php foreach(language_dynamic_enable("kit_description", "") as $dynlang) {echo $dynlang[1];}  ?>);
        $('#add_btn').hide();
        $('#update_btn').show();
        $('#reset_btn').show();
    }
   
<?php } else {?>
  
function get_activity_data(kit_id, kit_title, kit_detailed_title, kit_count, kit_description ) {
        $('.loading').show();
        setTimeout(function() { $(".loading").hide(); }, 500);
        $('.add_new_item').show();
        continue_button_manage('hide');
        $('#kit_id').val(kit_id);
        $('#kit_title').val(kit_title);              
        
        $('#kit_detailed_title').val(kit_detailed_title);
       
        $('#kit_count').val(kit_count);
        $('#kit_description').val(kit_description);
       
        $('#add_btn').hide();
        $('#update_btn').show();
        $('#reset_btn').show();
    }
  <?php } ?>

    /*Update edited form*/
    function update_tab2() {
         $('.loading').show();
       
        if (kit_title == '' || kit_detailed_title == '') {
             $('.loading').hide();
            $('.error').fadeIn('slow', function () {
                $(this).delay(5000).fadeOut('slow');
            });
            return false;
        }
        else {
            $.ajax
            ({
                url: '<?php echo base_url(); ?>site/experience/update_kit',
                type: 'POST',
                 data: $('#overviewlist').serialize(),
               
                dataType: 'json',
                success: function (data) {
                    $("#customError").html(data);
                    if (data.case == 1) {
                      
                        $("div.added").fadeIn(300).delay(5500).fadeOut(400);
                        $("#package_table").load(location.href + " #package_table");
                        window.location.reload();
                    }
                    else if (data.case == 2) {
                        $("div.updated").fadeIn(300).delay(2500).fadeOut(400);
                        $("#package_table").load(location.href + " #package_table");
                        window.location.reload();
                    }
                    else if (data.case == 3) {
                         $('.loading').hide();
                        $("#customError").html('Already Exists');
                    }
                }
            });
        }
    }
</script>