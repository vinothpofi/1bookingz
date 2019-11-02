<!-- <h3>Rentals</h3> -->
<ul class="sideBarMenu">
                        <li>
                            <a href="<?php echo base_url(); ?>inbox" <?php if ($this->uri->segment(1) == 'inbox') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_all_messages') != '') {
                                echo stripslashes($this->lang->line('front_all_messages'));
                            } else echo "All Messages"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>msg-starred" <?php if ($this->uri->segment(1) == 'msg-starred') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_starred') != '') {
                                    echo stripslashes($this->lang->line('front_starred'));
                                } else echo "Starred"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>msg-unread" <?php if ($this->uri->segment(1) == 'msg-unread') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_unread') != '') {
                                    echo stripslashes($this->lang->line('front_unread'));
                                } else echo "Unread"; ?> <div class="badge"> <?php echo $property_msg_count; ?></div> </a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>msg-reservation" <?php if ($this->uri->segment(1) == 'msg-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_reservations') != '') {
                                    echo stripslashes($this->lang->line('front_reservations'));
                                } else echo "Reservations"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>msg-pending-request" <?php if ($this->uri->segment(1) == 'msg-pending-request') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_pending_requests') != '') {
                                    echo stripslashes($this->lang->line('front_pending_requests'));
                                } else echo "Pending Requests"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>msg-archived" <?php if ($this->uri->segment(1) == 'msg-archived') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_archived') != '') {
                                    echo stripslashes($this->lang->line('front_archived'));
                                } else echo "Archived"; ?></a></li>
</ul>
<!-- <h3>Experience</h3>
<ul class="sideBarMenu">
                        <li>
                            <a href="<?php echo base_url(); ?>experience_inbox" <?php if ($this->uri->segment(1) == 'experience_inbox') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_all_messages') != '') {
                                echo stripslashes($this->lang->line('front_all_messages'));
                            } else echo "All Messages"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>experience-msg-starred" <?php if ($this->uri->segment(1) == 'experience-msg-starred') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_starred') != '') {
                                    echo stripslashes($this->lang->line('front_starred'));
                                } else echo "Starred"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>experience-msg-unread" <?php if ($this->uri->segment(1) == 'experience-msg-unread') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_unread') != '') {
                                    echo stripslashes($this->lang->line('front_unread'));
                                } else echo "Unread"; ?> <?php if($experience_msg_count>0){ ?><div class="badge"><?php echo $experience_msg_count; ?></div> <?php } ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>experience-msg-reservation" <?php if ($this->uri->segment(1) == 'experience-msg-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_reservations') != '') {
                                    echo stripslashes($this->lang->line('front_reservations'));
                                } else echo "Reservations"; ?></a></li>
                       
                        <li>
                            <a href="<?php echo base_url(); ?>experience-msg-archived" <?php if ($this->uri->segment(1) == 'experience-msg-archived') { ?> class="active" <?php } ?>><?php if ($this->lang->line('front_archived') != '') {
                                    echo stripslashes($this->lang->line('front_archived'));
                                } else echo "Archived"; ?></a></li>
</ul> -->