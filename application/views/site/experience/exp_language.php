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
            <h3><?php if ($this->lang->line('exp_which_language') != '') {
                    echo stripslashes($this->lang->line('exp_which_language'));
                } else echo "Which Language will you host in?"; ?>
            </h3>
            
            <div>
                <p class="text-danger error"
                   style="display: none;"><?php if ($this->lang->line('exp_fill_all_fields') != '') {
                        echo stripslashes($this->lang->line('exp_fill_all_fields'));
                    } else echo "Please fill all mandatory fields"; ?></p>
                <?php
                echo form_open('#', array('onsubmit' => 'return validate_form_new(event)', 'name' => 'overviewlist', 'id' => 'overviewlist'));
                $select = ($this->lang->line('select') != '') ? stripslashes($this->lang->line('select')) : 'Select';
                ?>
                <div class="form-group">
                    
                    <?php
                    $languages_known_user = explode(',', $listDetail->row()->language_list);
                    if (count($languages_known_user) > 0) { ?>
                        <ul class="languageList" id="knownLanguages">
                            <?php
                            foreach ($languages_known->result() as $language) {
                                if (in_array($language->language_code, $languages_known_user)) {
                                    ?>
                                    <li id="<?php echo $language->language_code; ?>"><?php echo $language->language_name; ?>
                                        <span onclick="delete_languages(this,<?php echo $language->language_code; ?>)">X</span>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    <?php } ?>
                    <div class="addLang" data-toggle="modal" data-target="#addLanguage"><span
                                class="number_s120">+</span><a
                                href="javascript:void(0)"> <?php if ($this->lang->line('AddMore') != '') {
                                echo stripslashes($this->lang->line('AddMore'));
                            } else echo "Add More"; ?></a></div>
                    <?php
                    echo form_input(array('type' => 'hidden', 'name' => 'experience_id', 'id' => 'experience_id', 'value' => $listDetail->row()->experience_id));
                    ?>
                </div>
                <div class="clear text-right">
                    <?php
                    echo form_button('', ($this->lang->line('Continue') != '') ? stripslashes($this->lang->line('Continue')) : 'Continue', array('id' => 'next-btn', 'class' => 'submitBtn1'));
                    ?>
                </div>
                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
    <div class="rightBlock">
        <h2><i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
            <?php if ($this->lang->line('switch_your_lang') != '') {
                echo stripslashes($this->lang->line('switch_your_lang'));
            } else echo "Switch to your Language"; ?></h2>
        <!-- <p><?php if ($this->lang->line('exp_great_summary') != '') {
                echo stripslashes($this->lang->line('exp_great_summary'));
            } else echo '"A new language is a new life". Are you flexible in more than one language? Please specify it. Make your guest comfort with their native language. With languages you can make your guest to feel they are at Home. Don’t miss out any of your guest.'; ?></p> -->
        <p><?php if ($this->lang->line('are_you_someone_who') != '') {
                echo stripslashes($this->lang->line('are_you_someone_who'));
            } else echo 'Are you someone who can speak a lot of native languages? Share your experience in a native language and make your guests comfortable as at home. Please specify the languages and gather more guests for your experience.'; ?></p>
    </div>
</div>
<!-- Add Language Modal -->
<div id="addLanguage" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="mHead"><?php if ($this->lang->line('SpokenLanguages') != '') {
                        echo stripslashes($this->lang->line('SpokenLanguages'));
                    } else echo "Spoken Languages"; ?></h2>
            </div>
            <div class="modal-body">
                <p><?php if ($this->lang->line('Whatlanguages') != '') {
                        echo stripslashes($this->lang->line('Whatlanguages'));
                    } else echo "What languages can you speak fluently? We have many international travelers who appreciate hosts who can speak their language."; ?></p>
                <div class="clear allLang">
                    <?php
                    $languages_knowns = explode(',', $listDetail->row()->language_list);
                    foreach ($languages_known->result() as $language) {
                        ?>
                        <label>

					<span class="checkboxStyle">

						<input type="checkbox" <?php if (in_array($language->language_code, $languages_knowns)) { ?> checked="checked" <?php } ?>
                               name="languages[]" value="<?php echo $language->language_code ?>" class="hideTemp"
                               alt="<?php echo $language->language_name; ?>">

		    			<i class="fa fa-check" aria-hidden="true"></i>

		    		</span>
                            <div class=""><?php echo $language->language_name; ?></div>
                        </label>
                        <?php
                    }
                    ?>
                </div>
                <input type="button" class="submitBtn1" id="language_ajax" data-dismiss="modal"
                       value="<?php if ($this->lang->line('Save') != '') {
                           echo stripslashes($this->lang->line('Save'));
                       } else echo "Save"; ?>" name="">
            </div>
        </div>
    </div>
</div>
<script>
    /*Adding languages to db*/
    $(function () {
        $('#language_ajax').click(function () {
            var languages = document.getElementsByName('languages[]');
            var expID = $("#experience_id").val();
            var languages_known = new Array();
            for (var i = 0; i < languages.length; i++) {
                if ($(languages[i]).is(':checked')) {
                    languages_known.push(languages[i].value);
                }
            }
            if (languages_known.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>site/experience/update_languages',
                    data: {languages_known: languages_known, experience_id: expID},
                    success: function (response) {
                        $('#knownLanguages').html(response.trim());
                    }
                });
            }
        })
    });
    /*Next button link*/
    $(document).ready(function () {
        $('#next-btn').click(function (e) {
            $('.loading').show();
            window.location.href = '<?php echo base_url() . "experience_organization_details/" . $id; ?>';
        });
    });

    /*Deleting known languages*/
    function delete_languages(elem, language_code) {
        lan_count = $("#knownLanguages li").length;
        if (lan_count == 1) {
            boot_alert("<?php if ($this->lang->line('exp_please_choose_one') != '') {
                echo stripslashes($this->lang->line('exp_please_choose_one'));
            } else echo "Please choose atleast one language";?>");
            return false;
        }
        var expID = $("#experience_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url()?>site/experience/delete_languages',
            data: {language_code: language_code, experience_id: expID},
            dataType: 'json',
            success: function (response) {
                if (response['status_code'] == 1) {
                    $(elem).closest('li').remove();
                    lan_count = $("#knownLanguages li").length;
                    if (lan_count == 0) {
                        $('#next-btn').hide();
                    } else {
                        $('#next-btn').show();
                    }
                }
            }
        });
    }
</script>