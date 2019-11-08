<?php$this->load->view('site/includes/header');$this->load->view('site/includes/top_navigation_links');$currency_result = $this->session->userdata('currency_result');?>    <section>        <div class="container">            <div class="loggedIn clear">                <div class="width20">                    <ul class="sideBarMenu">                        <li>                            <a href="<?php echo base_url(); ?>settings" <?php if ($this->uri->segment(1) == 'settings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('EditProfile') != '') {                                    echo stripslashes($this->lang->line('EditProfile'));                                } else echo "Edit Profile"; ?></a></li>                        <li>                            <a href="<?php echo base_url(); ?>photo-video" <?php if ($this->uri->segment(1) == 'photo-video') { ?> class="active" <?php } ?>><?php if ($this->lang->line('photos') != '') {                                    echo stripslashes($this->lang->line('photos'));                                } else echo "Photos"; ?></a></li>                        <li>                            <a href="<?php echo base_url(); ?>verification" <?php if ($this->uri->segment(1) == 'verification') { ?> class="active" <?php } ?>><?php if ($this->lang->line('TrustandVerification') != '') {                                    echo stripslashes($this->lang->line('TrustandVerification'));                                } else echo "Trust and Verification"; ?></a></li>														<?php $review_link = ''; if(!empty($userDetails)) { if($userDetails->row()->group == 'Seller') { $review_link = 'display-review'; }else if($userDetails->row()->group == 'User'){  $review_link = 'display-review1'; } } ?>                        <li>                            <a href="<?php echo base_url().$review_link; ?>" <?php if ($this->uri->segment(1) == 'display-review') { ?> class="active" <?php } ?>><?php if ($this->lang->line('Reviews') != '') {                                    echo stripslashes($this->lang->line('Reviews'));                                } else echo "Reviews"; ?></a></li>								                        <?php 						$dispute_link = ''; if(!empty($userDetails)) { if($userDetails->row()->group == 'Seller') { $dispute_link = 'display-dispute'; }else if($userDetails->row()->group == 'User'){  $dispute_link = 'display-dispute1'; } } 						$disputeLinks = array('display-dispute', 'display-dispute1', 'cancel-booking-dispute', 'display-dispute2'); ?>                         <li>                            <a href="<?php echo base_url().$dispute_link; ?>" <?php if (in_array($this->uri->segment(1), $disputeLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute/Cancel') != '') {                                    echo stripslashes($this->lang->line('Dispute/Cancel'));                                } else echo "Dispute/Cancel"; ?> <span class="badge"><?php if($tot_dispute_count_is != 0) {echo ' '.$tot_dispute_count_is;} ?></span></a></li>                        <li>                            <a href="users/show/<?php echo $userDetails->row()->id; ?>"><?php if ($this->lang->line('ViewProfile') != '') {                                    echo stripslashes($this->lang->line('ViewProfile'));                                } else echo "View Profile"; ?></a></li>                    </ul>                </div>                <div class="width80">                    <div class="row">                        <div class="col-sm-12">						                            <ul class="nav nav-tabs responsiveNav">														<?php if($userDetails->row()->group == 'Seller') { ?>                                <li><a data-toggle="tab"                                       onclick="window.location.href='<?php echo base_url(); ?>display-dispute'"                                       href="<?php echo base_url(); ?>display-dispute"><?php if ($this->lang->line('Dispute_About_You') != '') {                                            echo stripslashes($this->lang->line('Dispute_About_You'));                                        } else echo "Dispute About You"; ?><span class="badge"><?php if($dispute_count != 0){echo ' '.$dispute_count;} ?></span></a></li>                            <?php } ?>  														<?php if($userDetails->row()->group == 'User') { ?>							   <li class="active"><a data-toggle="tab"                                                      href="#menu1"><?php if ($this->lang->line('Dispute_By_You') != '') {                                            echo stripslashes($this->lang->line('Dispute_By_You'));                                        } else echo "Dispute By You"; ?></a></li>							<?php } ?>                                 							   <li><a data-toggle="tab"                                       onclick="window.location.href='<?php echo base_url(); ?>cancel-booking-dispute'"                                       href="<?php echo base_url(); ?>cancel-booking-dispute"><?php if ($this->lang->line('cancel_booking_by_you') != '') {                                            echo stripslashes($this->lang->line('cancel_booking_by_you'));                                        } else echo "Cancel booking by you"; ?></a></li>                                <li><a data-toggle="tab"                                       onclick="window.location.href='<?php echo base_url(); ?>display-dispute2'"                                       href="<?php echo base_url(); ?>display-dispute2"><?php if ($this->lang->line('cancel_booking') != '') {                                            echo stripslashes($this->lang->line('cancel_booking'));                                        } else echo "Cancel booking"; ?><span class="badge"><?php if($cancel_count != 0){echo ' '.$cancel_count;} ?></span></a></li>                                        <li>                                            <?php                                            // $genderattr = array(                                            //         'id'     => 'dispute_status',                                            //         'class'  => 'large tipTop',                                            //         'title'  => 'Please filter the gender',                                            //          'style'  => 'color: #a61d55'                                            // );                                            // $gender = array();                                            // $gender = array('')                                            // echo form_dropdown('dispute_status', $gender, '', $genderattr);// echo $state;exit();                                             ?>                        </li>                            </ul>                            <div class="tab-content marginBottom2">                                <div id="menu1" class="tab-pane fade in active">                                     <select style="color: #a61d55;" id="dispute_status" onchange="dispute_status_filter(this.value)";>                                        <option value=""><?php if ($this->lang->line('select_state') != '') {                                                echo stripslashes($this->lang->line('select_state'));                                            } else echo "Search The Status"; ?></option>                                        <option value="Processing" <?php if($state == 'Processing'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('processing') != '') {                                                echo stripslashes($this->lang->line('processing'));                                            } else echo "Processing"; ?></option>                                        <option value="Completed" <?php if($state == 'Completed'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('completed') != '') {                                                echo stripslashes($this->lang->line('completed'));                                            } else echo "Completed"; ?></option>                                        <option value="Rejected" <?php if($state == 'Rejected'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('rejected') != '') {                                                echo stripslashes($this->lang->line('rejected'));                                            } else echo "Rejected"; ?></option>                                        <option value="Pending" <?php if($state == 'Pending'): ?> selected="selected"<?php endif; ?>><?php if ($this->lang->line('Pending') != '') {                                                echo stripslashes($this->lang->line('Pending'));                                            } else echo "Pending"; ?></option>                                    </select>                                    <?php                                    $count = $DisputeDetails->num_rows();                                   // print_r($DisputeDetails->result());exit();                                    if ($count > 0) {                                        ?>                                                                       <?php                                        foreach ($DisputeDetails->result() as $review) {                                            ?>                                            <div class="tableRow reviewList_1">                                                <div class="left">                                                    <?php                                                    if ($review->image != '' && file_exists('./images/users/' . $review->image)) {                                                        $imgSource = "images/users/" . $review->image;                                                    } else {                                                        $imgSource = "images/users/profile.png";                                                    }                                                    echo img($imgSource, TRUE, array('class' => 'userIcon'));                                                    ?>                                                </div>                                                <div class="right">                                                    <div class="clear">                                                        <div class="colLeft">                                                        </div>                                                        <div class="colRight">                                                            Dispute                                                            at <?php echo anchor('rental/' . $review->seourl, $review->product_title); ?>                                                            for Booking No: <?php echo $review->booking_no; ?>                                                        </div>                                                    </div>                                                    <div class="content">                                                        <?php echo $review->message; ?>                                                    </div>                                                    <div class="colRight">                                                        <div class="email"><?php //echo $review->email; ?>                                                            <?php if ($this->lang->line('to') != '') {                                                                echo stripslashes($this->lang->line('to'));                                                            } else echo "to"; ?>                                                            <?php echo ucfirst($review->firstname." ".$reveiw->lastname); ?>                                                            - <?php echo date('d-m-Y', strtotime($review->created_date)); ?></div>                                                    </div>                                                    <div class="">                                                    <div class="btn-group">                                                        <?php                                                        $checkin = $review->checkin;                                                            $checkout = $review->checkout;                                                            if (strtotime(date('Y-m-d')) > strtotime(date($checkout))) { ?>                                                                 <br>                                                                <span class="badge"><?php if ($this->lang->line('expired') != '') {                                                                        echo stripslashes($this->lang->line('expired'));                                                                    } else echo "Pending Request Expired"; ?>                                                                </span>                                                              <?php  }else{?>                                                         <button type="button" class="submitBtn1">                                                                <?php echo $review->status; ?>                                                            </button>                                                        <?php }  ?>                                                        </div>                                                </div>                                            </div>                                                </div>                                            </div>                                            <?php                                        } ?>                                        <div class="myPagination left">                                            <?php echo $paginationLink; ?>                                        </div>                                        <?php                                    } else {                                        ?>                                        <div class="tableRow reviewList_1">                                            <p class="text-danger text-center"><?php                                                if ($this->lang->line('no_dispute_byyou') != '') {                                                    echo stripslashes($this->lang->line('no_dispute_byyou'));                                                } else {                                                    echo "No dispute by you!";                                                }                                                ?></p>                                        </div>                                        <?php                                    }                                    ?>                                </div>                            </div>                        </div>                    </div>                </div>            </div>        </div>    </section>    <script type="text/javascript">        function  dispute_status_filter(state) {        //alert(state);        if(state == 'Processing'){            enurl = '0';        }        if(state == 'Completed'){            enurl = '1';        }        if(state == 'Rejected'){            enurl = '2';        }        if(state == 'Pending'){            enurl = '3';        }        if(state == ''){            window.location.href = baseURL + 'display-dispute1';        }        window.location.href = baseURL + 'display-dispute1-filter/' + enurl;    }    </script><?php$this->load->view('site/includes/footer');?>