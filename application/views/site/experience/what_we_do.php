<?php$this->load->view('site/includes/header');$disabled = 'false';$exp_type = $listDetail->row()->exp_type;?><div class="manage_items">    <div class="toggleMenuD">        <div class="bar1"></div>        <div class="bar2"></div>        <div class="bar3"></div>    </div>    <?php    $this->load->view('site/experience/experience_head_side');    ?>    <div class="centeredBlock">        <div class="content">            <h3><?php if ($this->lang->line('exp_mention_what') != '') {                    echo stripslashes($this->lang->line('exp_mention_what'));                } else echo "Mention what you will do"; ?></h3>            <p><?php if ($this->lang->line('exp_describe_in_detail') != '') {                    echo stripslashes($this->lang->line('exp_describe_in_detail'));                } else echo "Describe in detail what you wil  be doing with your guests. The more information you can give, the better."; ?> </p>            <div>                <p class="text-danger error"                   style="display: none;"><?php if ($this->lang->line('exp_fill_all_fields') != '') {                        echo stripslashes($this->lang->line('exp_fill_all_fields'));                    } else echo "Please fill all mandatory fields"; ?></p>                <?php                echo form_open('#', array('onsubmit' => 'return validate_form_new(event)', 'name' => 'overviewlist', 'id' => 'overviewlist'));                echo form_input(array('type' => 'hidden', 'name' => 'experience_id', 'id' => 'experience_id', 'value' => $listDetail->row()->experience_id));                ?>                <div class="form-group">                    <p><?php if ($this->lang->line('exp_what_you_will') != '') {                            echo stripslashes($this->lang->line('exp_what_you_will'));                        } else echo "What you will do"; ?><span class="impt"> *</span></p>                    <?= form_textarea('what_we_do', $listDetail->row()->what_we_do, array('id' => 'what_we_do', 'placeholder' => ($this->lang->line('exp_what_you_will') != '') ? stripslashes($this->lang->line('exp_what_you_will')) : "What you will do", 'onkeyup' => 'char_count(this)', 'maxlength' => 250)); ?>                    <p>                        <?php                        $string = str_replace(' ', '', $listDetail->row()->experience_description);                        $len = mb_strlen($string, 'utf8');                        $remaining = (250 - $len);                        ?>                        <span id="what_we_do_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {                            echo stripslashes($this->lang->line('exp_characters_remaining'));                        } else echo "characters remaining"; ?></p>            <!-- arabic -->            <?php  foreach(language_dynamic_enable("what_we_do", "") as $dynlang) { ?>                    <p><?php if ($this->lang->line('exp_what_you_will') != '') {                            echo stripslashes($this->lang->line('exp_what_you_will'));                        } else echo "What you will do"; ?> (<?php echo $dynlang[0]; ?>)<span class="impt"> *</span></p>                    <?= form_textarea($dynlang[1], $listDetail->row()->{$dynlang[1]}, array('id' => 'what_we_do_ar', 'placeholder' => ($this->lang->line('exp_what_you_will') != '') ? stripslashes($this->lang->line('exp_what_you_will')) : "What you will do", 'onkeyup' => 'char_count(this)', 'maxlength' => 250)); ?>                    <p>                        <?php                        $string = str_replace(' ', '', $listDetail->row()->experience_description);                        $len = mb_strlen($string, 'utf8');                        $remaining = (250 - $len);                        ?>                        <span id="what_we_do_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {                            echo stripslashes($this->lang->line('exp_characters_remaining'));                        } else echo "characters remaining"; ?></p>                 <?php } ?>                       </div>                <div class="clear text-right">                    <?php                    echo form_submit('', ($this->lang->line('Save_and_Continue') != '') ? stripslashes($this->lang->line('Save_and_Continue')) : 'Save & Continue', array('class' => 'submitBtn1'));                    ?>                </div>                <?php                echo form_close();                ?>            </div>        </div>    </div>    <div class="rightBlock">        <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>            <?php if ($this->lang->line('uncover_details') != '') {                echo stripslashes($this->lang->line('uncover_details'));            } else echo "Uncover your Experience"; ?></h2>        <p><?php if ($this->lang->line('Describe_what_you_will') != '') {                echo stripslashes($this->lang->line('Describe_what_you_will'));            } else echo "Describe what you will do for your guests in the experience listed. Give an idea about your experience to the guests before they can book your experience. Mention the to-do which will be done in your experience and what you will provide as a host."; ?></p>               <!-- <p><?php if ($this->lang->line('exp_great_summary_uncover') != '') {                echo stripslashes($this->lang->line('exp_great_summary_uncover'));            } else echo "If you’re a volunteer, employee, or board member of a registered nonprofit, you can create an experience that brings people closer to your work and encourages themes to become advocates for your cause. Give an overview description of what your guests will be doing on this experience. It is important guests know what they’re getting into.."; ?></p>        <p><strong><?php if ($this->lang->line('example') != '') {                    echo stripslashes($this->lang->line('example'));                } else echo "Example"; ?>: </strong><?php if ($this->lang->line('exp_additionally_uncover') != '') {                echo stripslashes($this->lang->line('exp_additionally_uncover'));            } else echo "We'll bike to five foodie destinations to taste a variety of typical Dutch foods. Along the way, we'll discover the secret places of Amsterdam East—an up-and-coming area full of design shops. I'll lead you to surprising and beautiful eateries beloved by locals. At each spot we'll be welcomed by the owners and treated to delicious breads, cheeses, smoked mackerel, and more. We end the tour at the brewery 't IJ."; ?>        </p> -->    </div></div><script>    /*Next button link*/    $(document).ready(function () {        $('#next-btn').click(function (e) {            window.location.href = '<?php echo base_url() . "where_we_will_be/" . $id; ?>';        });    });    /*Character count */    function char_count(obj) {        value_str = obj.value.trim();        var length = value_str.length;        var maxlength = $(obj).attr('maxlength');        var id = obj.id;        var length = maxlength - length;        $('#' + id + '_char_count').text(length);    }    /*Submitting Form*/    function validate_form_new(e) {        what_we_do = $('#what_we_do').val();        what_we_do_ar = $('#what_we_do_ar').val();        err = 0;        if (what_we_do == '' || what_we_do_ar == '') {            err = 1;        }        if (err == 1) {            $('.error').fadeIn('slow', function () {                $(this).delay(5000).fadeOut('slow');            });            return false;        } else {            $('.loading').show();            url = '<?php echo base_url() . "site/experience/add_what_we_do/" . $id;?>';            $('#overviewlist').attr('method', 'post');            $('#overviewlist').attr('action', url).submit();        }    }</script>