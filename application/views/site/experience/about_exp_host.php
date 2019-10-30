<?php$this->load->view('site/includes/header');$disabled = 'false';$exp_type = $listDetail->row()->exp_type;?><div class="manage_items">    <div class="toggleMenuD">        <div class="bar1"></div>        <div class="bar2"></div>        <div class="bar3"></div>    </div>    <?php    $this->load->view('site/experience/experience_head_side');    ?>    <div class="centeredBlock">        <div class="content">            <h3><?php if ($this->lang->line('exp_write_your_bio') != '') {                    echo stripslashes($this->lang->line('exp_write_your_bio'));                } else echo "Write your bio"; ?></h3>            <p><?php if ($this->lang->line('exp_describe_yourself') != '') {                    echo stripslashes($this->lang->line('exp_describe_yourself'));                } else echo "Describe yourself and tell guests how came to be passionate about hosting this experience."; ?> </p>            <div>                <p class="text-danger error"                   style="display: none;"><?php if ($this->lang->line('exp_fill_all_fields') != '') {                        echo stripslashes($this->lang->line('exp_fill_all_fields'));                    } else echo "Please fill all mandatory fields"; ?></p>                <?php                echo form_open('#', array('onsubmit' => 'return validate_form_new(event)', 'name' => 'overviewlist', 'id' => 'overviewlist'));                echo form_input(array('type' => 'hidden', 'name' => 'experience_id', 'id' => 'experience_id', 'value' => $listDetail->row()->experience_id));                ?>                <div class="form-group">                    <p><?php if ($this->lang->line('about_host') != '') {                            echo stripslashes($this->lang->line('about_host'));                        } else echo "About you"; ?><span class="impt"> *</span></p>                    <?= form_textarea('about_host', $listDetail->row()->about_host, array('id' => 'about_host', 'placeholder' => ($this->lang->line('about_host') != '') ? stripslashes($this->lang->line('about_host')) : "About you", 'onkeyup' => 'char_count(this)', 'maxlength' => 250)); ?>                    <p>                        <?php                        $string = str_replace(' ', '', $listDetail->row()->about_host);                        $len = mb_strlen($string, 'utf8');                        $remaining = (250 - $len);                        ?>                        <span id="about_host_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {                            echo stripslashes($this->lang->line('exp_characters_remaining'));                        } else echo "characters remaining"; ?></p>                    <!-- In Arabic dynamic --->                     <?php  foreach(language_dynamic_enable("about_host", "") as $dynlang) { ?>                           <p><?php if ($this->lang->line('about_host') != '') {                            echo stripslashes($this->lang->line('about_host'));                        } else echo "About you"; ?>(<?php echo $dynlang[0]; ?>) <span class="impt"> *</span></p>                    <?= form_textarea($dynlang[1], $listDetail->row()->{$dynlang[1]}, array('id' => 'about_host_ar', 'placeholder' => ($this->lang->line('about_host') != '') ? stripslashes($this->lang->line('about_host')) : "About you", 'onkeyup' => 'char_count(this)', 'maxlength' => 250)); ?>                    <p>                        <?php                        $string = str_replace(' ', '', $listDetail->row()->about_host_ar);                        $len = mb_strlen($string, 'utf8');                        $remaining = (250 - $len);                        ?>                        <span id="about_host_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {                            echo stripslashes($this->lang->line('exp_characters_remaining'));                        } else echo "characters remaining"; ?></p>                    <?php } ?>                </div>                <div class="clear text-right">                    <?php                    echo form_submit('', ($this->lang->line('Save_and_Continue') != '') ? stripslashes($this->lang->line('Save_and_Continue')) : 'Save & Continue', array('class' => 'submitBtn1'));                    ?>                </div>                <?php                echo form_close();                ?>            </div>        </div>    </div>    <div class="rightBlock">        <h2><i class="fa fa-lightbulb-o"               aria-hidden="true"></i><?php if ($this->lang->line('experience_details_footnotes') != '') {                echo stripslashes($this->lang->line('experience_details_footnotes'));            } else echo "Add Footnotes "; ?></h2>        <p><?php if ($this->lang->line('Let_your_guests_know') != '') {                echo stripslashes($this->lang->line('Let_your_guests_know'));            } else echo "Let your guests know a little more about you by telling a few words on yourself. "; ?></p>       <!--   <p><?php if ($this->lang->line('exp_great_summary_footnotes') != '') {                echo stripslashes($this->lang->line('exp_great_summary_footnotes'));            } else echo "Always ensure that you should be transparent to your guest. Even more explicitly describe your prerequisites to the guest to build credibility in you. "; ?></p>        <p><strong><?php if ($this->lang->line('example') != '') {                    echo stripslashes($this->lang->line('example'));                } else echo "Example "; ?>: </strong><?php if ($this->lang->line('exp_adddtionals_footnotes') != '') {                echo stripslashes($this->lang->line('exp_adddtionals_footnotes'));            } else echo "Passenger to bring: sneakers, wind jacket, long trousers, and sunglasses. The time may change depending on the weather conditions."; ?>        </p> -->    </div></div><script>    /*Next button link*/    $(document).ready(function () {        $('#next-btn').click(function (e) {            window.location.href = '<?php echo base_url() . "guest_requirement/" . $id; ?>';        });    });    /*Character count */    function char_count(obj) {        value_str = obj.value.trim();        var length = value_str.length;        var maxlength = $(obj).attr('maxlength');        var id = obj.id;        var length = maxlength - length;        $('#' + id + '_char_count').text(length);    }    /*Submitting Form*/    function validate_form_new(e) {        about_host = $('#about_host').val();        err = 0;        if (about_host == '') {            err = 1;        }        if (err == 1) {            $('.error').fadeIn('slow', function () {                $(this).delay(5000).fadeOut('slow');            });            return false;        } else {            $('.loading').show();            url = '<?php echo base_url() . "site/experience/add_about_exp_host/" . $id;?>';            $('#overviewlist').attr('method', 'post');            $('#overviewlist').attr('action', url).submit();        }    }</script>