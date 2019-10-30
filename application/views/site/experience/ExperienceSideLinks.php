<ul class="sideBarMenu">

    <li><a class="<?php if (current_url() == base_url() . 'new_experience') echo "active"; ?>"

           href="<?php echo base_url(); ?>manage_experience"><?php if ($this->lang->line('NewExperience') != '') {

                echo stripslashes($this->lang->line('NewExperience'));

            } else echo "Add New Experience"; ?></a></li>

    <li><a class="<?php if (current_url() == base_url() . 'experience/all') echo "active"; ?>"

           href="<?php echo base_url(); ?>experience/all"><?php if ($this->lang->line('ManageExperiences') != '') {

                echo stripslashes($this->lang->line('ManageExperiences'));

            } else echo "Manage Experiences"; ?></a></li>

    <li><a class="<?php if (current_url() == base_url() . 'my_experience/upcoming') echo "active"; ?>"

           href="<?php echo base_url(); ?>my_experience/upcoming"><?php if ($this->lang->line('my_experience') != '') {

                echo stripslashes($this->lang->line('my_experience'));

            } else echo "My Experiences"; ?></a></li>

    <li><a class="<?php if (current_url() == base_url() . 'my_experience/previous') echo "active"; ?>"

           href="<?php echo base_url(); ?>my_experience/previous"><?php if ($this->lang->line('PreviousExperiences') != '') {

                echo stripslashes($this->lang->line('PreviousExperiences'));

            } else echo "Previous Experiences"; ?></a></li>

    <li>

        <a class="<?php if ((current_url() == base_url() . 'experience-reservation') || (current_url() == base_url() . 'experience-passed-reservation')) echo "active"; ?>"

           href="<?php echo base_url(); ?>experience-reservation"><?php if ($this->lang->line('ExperiencesReservation') != '') {

                echo stripslashes($this->lang->line('ExperiencesReservation'));

            } else echo "My Experiences Reservations"; ?>  </a></li>

    <li><a class="<?php if (current_url() == base_url() . 'experience-transactions') echo "active"; ?>"

           href="<?php echo base_url(); ?>experience-transactions"><?php if ($this->lang->line('TransactionHistory') != '') {

                echo stripslashes($this->lang->line('TransactionHistory'));

            } else echo "Transaction History"; ?></a></li>

    <li>

        <a class="<?php if ((current_url() == base_url() . 'experience-review') || (current_url() == base_url() . 'experience-review1')) echo "active"; ?>"

           href="<?php echo base_url(); ?>experience-review"><?php if ($this->lang->line('Reviews') != '') {

                echo stripslashes($this->lang->line('Reviews'));

            } else echo "Reviews"; ?></a></li>

    <li>

        <a class="<?php if ((current_url() == base_url() . 'experience-dispute') || (current_url() == base_url() . 'experience-dispute1') || (current_url() == base_url() . 'experience-cancel_booking_dispute')) echo "active"; ?>"

           href="<?php echo base_url(); ?>experience-dispute1"><?php if ($this->lang->line('cancel_booking') != '') {

                echo stripslashes($this->lang->line('cancel_booking'));

            } else echo "Cancel Booking"; ?></a></li>

   <!--  <li><a class="<?php if ((current_url() == base_url() . 'experience_inbox')) echo "active"; ?>"

           href="<?php echo base_url(); ?>experience_inbox"><?php if ($this->lang->line('My_Messages') != '') {

                echo stripslashes($this->lang->line('My_Messages'));

            } else echo "My Messages"; ?> <?php if($experience_msg_count>0){ ?><div class="badge"><?php echo $experience_msg_count; ?></div> <?php } ?></a></li> -->
            <li>
                  <a href="<?php echo base_url(); ?>host_cancelled_bookings_experience" <?php if ($this->uri->segment(1) == 'host_cancelled_bookings_experience') { ?> class="active" <?php } ?>><?php if ($this->lang->line('host_cancel') != '') {
                                    echo stripslashes($this->lang->line('host_cancel'));
                  } else echo "Host cancellation"; ?></a>
                
                </li>

</ul>