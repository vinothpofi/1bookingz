<?php

    $url = $this->uri->segment(1);

    if ($steps_disable == 1) {

        $dis_class = 'disabled_exp';

    } else {

        $dis_class = '';

    }

?>

<div class="leftSlideBlock">

    <ul>

        <li class="heading">

            <?php if ($this->lang->line('list_Basics') != '') {

                echo stripslashes($this->lang->line('list_Basics'));

            } else echo "Basics"; ?>

        </li>

        <li><a <?php if ($url == 'manage_experience') echo 'class="active"'; ?>

                    href="<?php echo base_url() . "manage_experience/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Basics') != '') {

                     echo stripslashes($this->lang->line('list_Basics'));
                     //   echo "Basic Info1";

                } else echo "Basic Info"; ?><span

                        class="pull-right"><?php if ($basics != 1) {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a>

        </li>

        <li><a <?php if ($url == 'experience_language_details') echo 'class="active"';

                if ($language != 0) { ?>

                    href="<?php echo base_url() . "experience_language_details/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('experience_language_details') != '') {

                    echo stripslashes($this->lang->line('experience_language_details'));

                } else echo "Language"; ?><span

                        class="pull-right"><?php if ($language != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a>

        </li>

        <li><a <?php if ($url == 'experience_organization_details') echo 'class="active"';

                if ($organization != 0) { ?>

                    href="<?php echo base_url() . "experience_organization_details/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('experience_organization_details') != '') {

                    echo stripslashes($this->lang->line('experience_organization_details'));

                } else echo "Organization"; ?><span

                        class="pull-right"><?php if ($organization != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'experience_details') echo 'class="active"';

                if ($exp_title != 0) { ?>

                    href="<?php echo base_url() . "experience_details/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('experience_title') != '') {

                    echo stripslashes($this->lang->line('experience_title'));

                } else echo "Experience Title"; ?><span

                        class="pull-right"><?php if ($exp_title != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'schedule_experience') echo 'class="active"';

                if ($timing != 0) { ?>

                    href="<?php echo base_url() . "schedule_experience/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('schedule_experience') != '') {

                    echo stripslashes($this->lang->line('schedule_experience'));

                } else echo "Timing"; ?><span

                        class="pull-right"><?php if ($timing != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'tagline_experience') echo 'class="active"';

                if ($tagline != 0) { ?>

                    href="<?php echo base_url() . "tagline_experience/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('tagline_experience') != '') {

                    echo stripslashes($this->lang->line('tagline_experience'));

                } else echo "Tag-line"; ?><span

                        class="pull-right"><?php if ($tagline != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'experience_image') echo 'class="active"';

                if ($photos != 0) { ?>

                    href="<?php echo base_url() . "experience_image/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('photos') != '') {

                    echo stripslashes($this->lang->line('photos'));

                } else echo "Photos"; ?><span

                        class="pull-right"><?php if ($photos != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'what_we_do') echo 'class="active"';

                if ($what_we_do != 0) { ?>

                    href="<?php echo base_url() . "what_we_do/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('exp_what_you_will') != '') {

                    echo stripslashes($this->lang->line('exp_what_you_will'));

                } else echo "What you will do?"; ?><span

                        class="pull-right"><?php if ($what_we_do != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'where_we_will_be') echo 'class="active"';

                if ($where_will_be != 0) { ?>

                    href="<?php echo base_url() . "where_we_will_be/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if($this->lang->line('where_you_will') != '') {

                    echo stripslashes($this->lang->line('where_you_will'));

                } else echo "Where you will be?"; ?><span

                        class="pull-right"><?php if ($where_will_be != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'location_details') echo 'class="active"';

                if ($where_will_meet != 0) { ?>

                    href="<?php echo base_url() . "location_details/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('where_wil_meet') != '') {

                    echo stripslashes($this->lang->line('where_wil_meet'));

                } else echo "Where we'll meet"; ?><span

                        class="pull-right"><?php if ($where_will_meet != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'what_you_will_provide') echo 'class="active"';

                if ($what_will_provide != 0) { ?>

                    href="<?php echo base_url() . "what_you_will_provide/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('what_you_will_provide') != '') {

                    echo stripslashes($this->lang->line('what_you_will_provide'));

                } else echo "What you will provide"; ?><span

                        class="pull-right"><?php if ($what_will_provide != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'notes_to_guest') echo 'class="active"';

                if ($notes != 0) { ?>

                    href="<?php echo base_url() . "notes_to_guest/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('notes_to_guest') != '') {

                    echo stripslashes($this->lang->line('notes_to_guest'));

                } else echo "Notes"; ?><span

                        class="pull-right"><?php if ($notes != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'about_exp_host') echo 'class="active"';

                if ($about_you != 0) { ?>

                    href="<?php echo base_url() . "about_exp_host/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('about_exp_host') != '') {

                    echo stripslashes($this->lang->line('about_exp_host'));

                } else echo "About you"; ?><span

                        class="pull-right"><?php if ($about_you != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'guest_requirement') echo 'class="active"';

                if ($guest_req != 0) { ?>

                    href="<?php echo base_url() . "guest_requirement/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('guest_requirement') != '') {

                    echo stripslashes($this->lang->line('guest_requirement'));

                } else echo "Guest Requirements"; ?><span

                        class="pull-right"><?php if ($guest_req != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'group_size') echo 'class="active"';

                if ($group_size != 0) { ?>

                    href="<?php echo base_url() . "group_size/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('group_size') != '') {

                    echo stripslashes($this->lang->line('group_size'));

                } else echo "Group Size"; ?><span

                        class="pull-right"><?php if ($group_size != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>





        <li><a <?php if ($url == 'price') echo 'class="active"';

                if ($price != 0) { ?>

                    href="<?php echo base_url() . "price/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('Price') != '') {

                    echo stripslashes($this->lang->line('Price'));

               } else echo "Price"; ?> <span

                        class="pull-right"><?php if ($price != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>

        <li><a <?php if ($url == 'experience_cancel_policy') echo 'class="active"';

                if ($cancel_policy != 0) { ?>

                    href="<?php echo base_url() . "experience_cancel_policy/" . $listDetail->row()->id; ?>" <?php } else {

                    echo 'href="#"';

                } ?>><?php if ($this->lang->line('list_Cancellation') != '') {

                    echo stripslashes($this->lang->line('list_Cancellation'));

                } else echo "Cancellation Policy"; ?><span

                        class="pull-right"><?php if ($cancel_policy != '1') {

                        ?>

                        <i class="fa fa-times" aria-hidden="true"></i>

                        <?php

                    } else {

                        ?>

                        <i class="fa fa-check" aria-hidden="true"></i>

                        <?php

                    } ?>

                </span>

            </a></li>



    </ul>

</div>