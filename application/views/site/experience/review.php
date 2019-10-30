<?php$this->load->view('site/includes/header');$this->load->view('site/includes/top_navigation_links');$currency_result = $this->session->userdata('currency_result');?>    <section>        <div class="container">            <div class="loggedIn clear">                <div class="width20">                    <?php $this->load->view('site/experience/ExperienceSideLinks'); ?>                </div>                <div class="width80">                    <div class="row">                        <div class="col-sm-12">                            <ul class="nav nav-tabs">                                <li class="active"><a data-toggle="tab"                                                      href="#menu1"><?php if ($this->lang->line('ReviewsAboutYou') != '') {                                            echo stripslashes($this->lang->line('ReviewsAboutYou'));                                        } else echo "Reviews About You"; ?></a></li>                                <li><a data-toggle="tab"                                       onclick="window.location.href='<?php echo base_url(); ?>experience-review1'"                                       href="<?php echo base_url(); ?>display-review1"><?php if ($this->lang->line('ReviewsbyYou') != '') {                                            echo stripslashes($this->lang->line('ReviewsbyYou'));                                        } else echo "Reviews by You"; ?></a></li>                            </ul>                            <div class="tab-content marginBottom2">                                <div id="menu1" class="tab-pane fade in active">                                    <?php                                    $count = $ReviewDetails->num_rows();                                    if ($count > 0) {                                        foreach ($ReviewDetails->result() as $review) {                                            ?>                                            <div class="tableRow reviewList_1">                                                <div class="left">                                                    <?php                                                    if ($review->image != '' && file_exists('./images/users/' . $review->image)) {                                                        $imgSource = "images/users/" . $review->image;                                                    } else {                                                        $imgSource = "images/users/profile.png";                                                    }                                                    echo img($imgSource, TRUE, array('class' => 'userIcon'));                                                    ?>                                                </div>                                                <div class="right">                                                    <div class="clear">                                                        <div class="colLeft">                                                            <div class="starRatingOuter1">                                                                <div class="starRatingInner1"                                                                     style="width: <?php echo $review->total_review * 20 ?>%;"></div>                                                            </div>                                                        </div>                                                        <div class="colRight">                                                            at <?php                                                            $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),$review);                                                             /*echo anchor('rental/' . $review->seourl, $review->product_title);*/                                                             echo anchor('view_experience/' . $review->product_id, $prod_tiltle);                                                              ?>                                                            for Booking No: <?php echo $review->bookingno; ?>                                                        </div>                                                    </div>                                                    <div class="content">                                                        <?php echo nl2br($review->review); ?>                                                    </div>                                                    <div class="content">                                                    <?php if($review->review_type == '0'){$for_rev = 'Experience';}else{$for_rev = 'Host';} ?>                                                    <span class="badge"><?php echo $for_rev; ?></span>                                                </div>                                                    <div class="colRight">                                                        <div class="email"><?php //echo $review->email; ?>                                                        <?php if ($this->lang->line('Reviewsat') != '') {                                            echo stripslashes($this->lang->line('Reviewsat'));                                        } else echo "reviewed At"; ?>                                                            - <?php echo date('d-m-Y', strtotime($review->dateAdded)); ?></div>                                                    </div>                                                </div>                                            </div>                                            <?php                                        } ?>                                        <div class="myPagination left">                                            <?php echo $paginationLink; ?>                                        </div>                                        <?php                                    } else {                                        ?>                                        <div class="tableRow reviewList_1">                                            <p class="text-danger text-center"><?php                                                if ($this->lang->line('no_past_reviews') != '') {                                                    echo stripslashes($this->lang->line('no_past_reviews'));                                                } else {                                                    echo "No past reviews found!";                                                }                                                ?></p>                                        </div>                                        <?php                                    }                                    ?>                                </div>                            </div>                        </div>                    </div>                </div>            </div>        </div>    </section><?php$this->load->view('site/includes/footer');?>