<?php$this->load->view('site/includes/header');$this->load->view('site/includes/top_navigation_links');$currency_result = $this->session->userdata('currency_result');?>    <section>        <div class="container">            <div class="loggedIn clear">                <div class="width20">                    <?php $this->load->view('site/experience/ExperienceSideLinks'); ?>                </div>                <div class="width80">                    <div class="row">                        <div class="col-sm-12 tran_container">                            <ul class="nav nav-tabs">                                <li><a data-toggle="tab"                                       onclick="window.location.href='<?php echo base_url(); ?>experience-dispute1'"                                       style="cursor: pointer;"><?php if ($this->lang->line('cancel_booking_by_you') != '') {                                            echo stripslashes($this->lang->line('cancel_booking_by_you'));                                        } else echo "Cancel booking by you"; ?></a></li>                                <li class="active"><a data-toggle="tab"                                                      style="cursor: pointer;"><?php if ($this->lang->line('cancel_booking') != '') {                                            echo stripslashes($this->lang->line('cancel_booking'));                                        } else echo "Cancel  booking"; ?></a></li>                            </ul>                            <div class="tab-content marginBottom2">                                <div id="menu1" class="tab-pane fade in active">                                    <?php                                    $count = $Canceldisputebooking->num_rows();                                    if ($count > 0) {                                        foreach ($Canceldisputebooking->result() as $review) {                                            ?>                                            <div class="tableRow reviewList_1">                                                <div class="left">                                                    <?php                                                    if ($review->image != '' && file_exists('./images/users/' . $review->image)) {                                                        $imgSource = "images/users/" . $review->image;                                                    } else {                                                        $imgSource = "images/users/profile.png";                                                    }                                                    echo img($imgSource, TRUE, array('class' => 'userIcon'));                                                    ?>                                                </div>                                                <div class="right">                                                    <div class="clear">                                                        <div class="colLeft">                                                        </div>                                                        <div class="colRight">                                                            Dispute                                                            at <?php echo anchor('view_experience/' . $review->prd_id, $review->product_title); ?>                                                            for Booking No: <?php echo $review->booking_no; ?>                                                        </div>                                                    </div>                                                    <div class="content">                                                        <?php echo $review->message; ?>                                                    </div>                                                    <div class="colRight">                                                    <div class="email"><?php //echo $review->email; ?>                                                         <?php if ($this->lang->line('created_at') != '') {                                                            echo stripslashes($this->lang->line('created_at'));                                                        } else echo "Cancelled At"; ?>                                                         <?php //echo ucfirst($review->firstname." ".$reveiw->lastname); ?>                                                        - <?php echo date('d-m-Y', strtotime($review->created_date)); ?></div>                                                </div>                                                    <div class="">                                                    <div class="btn-group">                                                        <?php                                                        //echo $review->status;                                                        if ($review->status == 'Pending') {                                                            ?>                                                            <button type="button" class="submitBtn1"                                                                    onclick="window.location.href='<?php echo base_url()."site/experience/accept_dispute/".$review->id.'/'.$review->booking_no;?>'""><?php if ($this->lang->line('Accept') != '') {                                                                    echo stripslashes($this->lang->line('Accept'));                                                                } else echo "Accept"; ?></button>                                                            <button type="button" class="submitBtn"                                                                    onclick="window.location.href='<?php echo base_url()."site/experience/reject_dispute/".$review->id.'/'.$review->booking_no;?>'""><?php if ($this->lang->line('reject') != '') {                                                                    echo stripslashes($this->lang->line('reject'));                                                                } else echo "Reject"; ?></button>                                                        <?php } elseif ($review->status == 'Accept') { ?>                                                            <button style="cursor: none;" type="button" class="submitBtn1"><?php if ($this->lang->line('Canceled') != '') {                                                                    echo stripslashes($this->lang->line('Canceled'));                                                                } else echo "Canceled"; ?></button>                                                            <?php                                                        } else {                                                            ?>                                                            <button style="cursor: none;" class="submitBtn1"                                                                type="button"><?php if ($this->lang->line('rejected') != '') {                                                                    echo stripslashes($this->lang->line('rejected'));                                                                } else echo "Rejected"; ?></button>                                                        <?php }                                                        ?>                                                    </div>                                                </div>                                                                                                    </div>                                            </div>                                            <?php                                        } ?>                                        <div class="myPagination left">                                            <?php echo $paginationLink; ?>                                        </div>                                        <?php                                    } else {                                        ?>                                        <div class="tableRow reviewList_1">                                            <p class="text-danger text-center"><?php                                                if ($this->lang->line('anything_to_cancel') != '') {                                                    $anything_to = stripslashes($this->lang->line('anything_to_cancel'));                                                } else {                                                    $anything_to = "You did not book anything to cancel!";                                                }                                                echo $anything_to;                                                ?></p>                                        </div>                                        <?php                                    }                                    ?>                                </div>                            </div>                        </div>                    </div>                </div>            </div>        </div>    </section><?php$this->load->view('site/includes/footer');?>