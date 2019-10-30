<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
<section>
    <div class="container">
        <div class="loggedIn clear">
            <div class="width20">
                        <?php 
                            $this->load->view('site/includes/experience_message_sidebar');
                         ?>   
            </div>
            <div class="width80">
                <div class="table-responsive">
                <table class="table table-striped leftAlign msgListing">
                    <tr>
                        <th width="5%"><?php if ($this->lang->line('S.no') != '') {
                                echo stripslashes($this->lang->line('S.no'));
                            } else echo "S.no"; ?></th>
                        <th width="10%"><?php if ($this->lang->line('user') != '') {
                                echo stripslashes($this->lang->line('user'));
                            } else echo "User"; ?></th>
                        <th width="30%"><?php if ($this->lang->line('Date') != '') {
                                echo stripslashes($this->lang->line('Date'));
                            } else echo "Date"; ?></th>
                        <th width="50%"><?php if ($this->lang->line('Subject') != '') {
                                echo stripslashes($this->lang->line('Subject'));
                            } else echo "Subject"; ?></th>
                        <th width="5%"><?php if ($this->lang->line('Action') != '') {
                                echo stripslashes($this->lang->line('Action'));
                            } else echo "Action"; ?></th>
                    </tr>
                    <?php
                    $i = 1;
                    if (!empty($med_messages)) {
                        foreach ($med_messages as $med_message) {
                            ?>
                            <tr>
                            <td><?php echo $i;
                                $i++; ?></td>
                            <td>
                                <?php
                                $imageSrc = 'profile.png';
                                if ($med_message->image != "" && file_exists('./images/users/' . $med_message->image)) {
                                    $imageSrc = $med_message->image;
                                }
                                echo img('images/users/' . $imageSrc, TRUE, array('class' => 'user'));
                                ?>
                            </td>
                            <td>
                                <!--<div><?php /*echo ucfirst($med_message->firstname . ' ' . $med_message->lastname); */ ?></div>-->
                                <div class="date"><?php echo date('d-m-Y', strtotime($med_message->dateAdded)); ?></div>
                            </td>
                            <td><?php echo ucfirst($med_message->subject); ?><?php echo ($med_message->msg_unread_count > 0) ? ' (' . $med_message->msg_unread_count . ')' : '';
                                if (($med_message->status == 'Pending') && ($med_message->user_id == $luser_id)) {
                                    echo '<p class="text-danger">There is a booking request for you</p>';
                                } ?></td>
                            <td>
                                <!-- =============================== -->
                                <a href="<?php echo base_url(); ?>experience_conversation/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>">
                                    <i class="fa fa-eye" aria-hidden="true"></i> </a>
                                <!-- =============================== --> 
                                <?php if ($med_message->msg_star_status == 'No') { ?>
                                        <a href="<?php echo base_url(); ?>experience-change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/0" title="Not Starred"><i class="fa fa-star-o" aria-hidden="true"></i></a>
                                <!-- =============================== -->
                                        <?php }else if($med_message->msg_star_status == 'Yes'){ ?>
                                            <a href="<?php echo base_url(); ?>experience-change-star-status/<?php echo $med_message->bookingNo; ?>/<?php echo $med_message->id; ?>/1" title="Starred"><i class="fa fa-star" aria-hidden="true"></i></a>
                                <!-- =============================== -->

                                <?php } //if ($med_message->msg_read == 'Yes') { ?>
                                    <a href="site/experience/delete_conversation_details_msg/<?php echo $med_message->id; ?>" title="Archive">
                                        <i class="fa fa-archive" aria-hidden="true"></i> </a>
                                <?php //} ?>
                                <!-- =============================== -->
                            </td>
                            </tr><?php
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5"><p
                                        class="text-danger text-center"><?php if ($this->lang->line('NoMessage') != '') {
                                        echo stripslashes($this->lang->line('NoMessage'));
                                    } else echo "There is no message(s) in inbox"; ?></p></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            </div>
        </div>
    </div>
</section><div class="myPagination" id="page_numbers">    <?php    echo $paginationLink;    ?></div>
<?php
$this->load->view('site/includes/footer');
?>
