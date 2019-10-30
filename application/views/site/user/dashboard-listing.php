<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
    <section>
        <div class="container">
            <div class="loggedIn clear">
                <div class="width20">
                    <ul class="sideBarMenu">
                        <li>
                            <a href="<?php echo base_url(); ?>listing/all" <?php if ($this->uri->segment(1) == 'listing') { ?> class="active" <?php } ?>><?php if ($this->lang->line('ManageListings') != '') {
                                    echo stripslashes($this->lang->line('ManageListings'));
                                } else echo "Manage Listings"; ?></a></li>
                        <li>
                            <a href="<?php echo base_url(); ?>listing-reservation" <?php if ($this->uri->segment(1) == 'listing-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('YourReservations') != '') {
                                    echo stripslashes($this->lang->line('YourReservations'));
                                } else echo "Your Reservations"; ?></a></li>
								
								 <li>
									<a href="<?php echo base_url(); ?>listing-passed-reservation" <?php if ($this->uri->segment(1) == 'listing-passed-reservation') { ?> class="active" <?php } ?>><?php if ($this->lang->line('ViewPastReserv') != '') {
                                    echo stripslashes($this->lang->line('ViewPastReserv'));
									} else echo "View Past Reservation History"; ?></a>
								
								</li>
                                 <li>
                  <a href="<?php echo base_url(); ?>host_cancelled_bookings" <?php if ($this->uri->segment(1) == 'host_cancelled_bookings') { ?> class="active" <?php } ?>><?php if ($this->lang->line('host_cancel') != '') {
                                    echo stripslashes($this->lang->line('host_cancel'));
                  } else echo "Host cancellation"; ?></a>
                
                </li>
					<li>
                        <a href="<?php echo base_url(); ?>display-dispute" <?php if (in_array($this->uri->segment(1), $disputeLinks)) { ?> class="active" <?php } ?>><?php if ($this->lang->line('Dispute/Cancel') != '') {
                                echo stripslashes($this->lang->line('Dispute/Cancel'));
                            } else echo "Dispute/Cancel"; ?> <span class="badge" title="dispute count"><?php if($tot_dispute_count_is != 0) {echo ' '.$tot_dispute_count_is;} ?></span></a></li>			
                    </ul>
                </div>
                <div class="width80">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="searchTable clear">
                                <form class="clear">
                                    <?php
                                    if ($this->lang->line('Showalllistings') != '') {
                                        $all = stripslashes($this->lang->line('Showalllistings'));
                                    } else $all = "Show all listings";
                                    if ($this->lang->line('Showactive') != '') {
                                        $active = stripslashes($this->lang->line('Showactive'));
                                    } else $active = "Show active";
                                    if ($this->lang->line('Showhidden') != '') {
                                        $hidden = stripslashes($this->lang->line('Showhidden'));
                                    } else $hidden = "Show hidden";
                                    ?>
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" type="button" data-toggle="dropdown">
                                            <?php if ($this->uri->segment(2) == 'all') {
                                                echo $all;
                                            } elseif ($this->uri->segment(2) == 'Publish') {
                                                echo $active;
                                            } else {
                                                echo $hidden;
                                            } ?>
                                        </button>
                                        <ul class="dropdown-menu listings msg">
                                            <div class="dropdownIcon"></div>
                                            <a href="<?php echo base_url(); ?>listing/all">
                                                <li class="listings_R">
                                                    <div><h6><?php echo $all; ?></h6></div>
                                                </li>
                                            </a>
                                            <a href="<?php echo base_url(); ?>listing/Publish">
                                                <li class="listings_R">
                                                    <div><h6><?php echo $active; ?></h6></div>
                                                </li>
                                            </a>
                                            <a href="<?php echo base_url(); ?>listing/UnPublish">
                                                <li class="listings_R">
                                                    <div><h6><?php echo $hidden; ?></h6></div>
                                                </li>
                                            </a>
                                        </ul>
                                    </div>
                                </form>
                            </div>
                            <div class="table-responsive">
                            <table class="table  table-striped leftAlign">
                                <tr>
								
								
                                    <th width="5%"><?php if ($this->lang->line('S.no') != '') {
                                        echo stripslashes($this->lang->line('S.no'));
                                    } else echo "S.no"; ?></th>
                                    <th width="10%"><?php if ($this->lang->line('single_img') != '') {
                                       echo stripslashes($this->lang->line('single_img'));
                                    } else echo "Image"; ?></th>
                                    <th width="30%"><?php if ($this->lang->line('Title') != '') {
                                        echo stripslashes($this->lang->line('Title'));
                                    } else echo "Title"; ?></th>
                                    <th width="5%"><?php if ($this->lang->line('Action') != '') {
                                        echo stripslashes($this->lang->line('Action'));
                                    } else echo "Action"; ?></th>
                                </tr>
                                <?php
                                if ($rentalDetail->num_rows() > 0) {
                                    $i = 1;
                                    foreach ($rentalDetail->result() as $row) {
                                        $total_steps = 8;
                                        if ($row->product_title != "") {
                                            $total_steps--;
                                        }
                                        if ($row->price != "0.00") {
                                            $total_steps--;
                                        }
                                        if ($row->calendar_checked != "") {
                                            $total_steps--;
                                        }
                                        if ($row->product_image != "") {
                                            $total_steps--;
                                        }
                                        if ($row->list_name != "") {
                                            $total_steps--;
                                        }
                                        if ($row->latitude != "") {
                                            $total_steps--;
                                        }
                                        if ($row->listings != "") {
                                            $total_steps--;
                                        }
                                        if ($row->cancellation_policy != "") {
                                            $total_steps--;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $i;
                                                $i++; ?></td>
                                            <td>
                                                <?php
                                                $ImagePath = 'dummyProductImage.jpg';
                                                if ($row->product_image != "" && file_exists('./images/rental/' . $row->product_image)) {
                                                    $ImagePath = $row->product_image;
                                                }
                                                echo img(base_url() . 'images/rental/' . $ImagePath, TRUE, array());
                                                ?></td>
                                            <td>
                                                <div>
                                                    <?php 
                                                        /*echo ($row->product_title != "") ? ucfirst($row->product_title) : '---'; */
                                                        $prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$row);
                                                            echo ucfirst($prod_tiltle);
                                                    ?>
                                                        
                                                    </div>
                                                <a href="<?php echo base_url() . "price_listing/" . $row->id; ?>"><?php if ($this->lang->line('ManageListingand') != '') {
                                                        echo stripslashes($this->lang->line('ManageListingand'));
                                                    } else echo "Manage Listing and Calendar"; ?></a>
                                                <?php
                                                if ($row->id_verified == "No") {
                                                    ?>
                                                    <p>
                                                        <?php if ($this->lang->line('Please') != '') {
                                                        $please= stripslashes($this->lang->line('Please'));
                                                    } else $please= "Please";
                                                    if ($this->lang->line('verify your email id') != '') {
                                                        $verify= stripslashes($this->lang->line('verify your email id'));
                                                    } else $verify= "verify your email id";
                                                    if ($this->lang->line('and allow guest to book your property.') != '') {
                                                        $last= stripslashes($this->lang->line('and allow guest to book your property.'));
                                                    } else $last= "and allow guest to book your property."; ?>
                                                        <small> <?php echo $please; ?> <u><a
                                                                        href="<?php echo base_url(); ?>verification"><?php echo $verify; ?></a></u> <?php echo $last; ?>
                                                        </small>
                                                    </p>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($total_steps != 0) { ?>
                                                    <a href="<?php echo base_url() . "manage_listing/" . $row->id; ?>"><?php echo $total_steps . ' '; ?><?php if ($this->lang->line('stepstolist') != '') {
                                                            echo stripslashes($this->lang->line('stepstolist'));
                                                        } else echo "steps to list"; ?></a>
                                                <?php } else {
                                                    if ($row->status == 'Publish' && $total_steps == 0) { ?>
                                                        <div><?php if ($this->lang->line('Listed') != '') {
                                                                echo stripslashes($this->lang->line('Listed'));
                                                            } else echo "Listed"; ?></div>
                                                    <?php } elseif ($row->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Inactive') { ?>
                                                        <div>Pending Approval</div>
                                                    <?php } elseif ($row->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active' && $row->payment_status == 'paid') { ?>
                                                        <div><?php if ($this->lang->line('Pending') != '') {
                                                                echo stripslashes($this->lang->line('Pending'));
                                                            } else echo "Pending"; ?></div>
                                                    <?php } elseif ($row->status == 'UnPublish' && $total_steps == 0 && $hosting_commission_status->row()->status == 'Active') { ?>
                                                        <a class="btn blue"
                                                           href="<?php echo base_url(); ?>site/product/redirect_base/payment/<?php echo $row->id; ?>"><?php if ($this->lang->line('Pay') != '') {
                                                                echo stripslashes($this->lang->line('Pay'));
                                                            } else echo "Pay"; ?></a>
                                                    <?php }
                                                } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="4"><h2
                                                    class="text-center"><?php if ($this->lang->line('Youdonthave') != '') {
                                                    echo stripslashes($this->lang->line('Youdonthave'));
                                                } else echo "You don't have any listings!"; ?></h2>
                                            <p class="text-center"><?php if ($this->lang->line('Listingyourexperience') != '') {
                                                    echo stripslashes($this->lang->line('Listingyourexperience'));
                                                } else echo "Listing your experience on homestay is an easy way to expose any experience you have."; ?> </p>
                                            <p class="text-center"> <?php if ($this->lang->line('Youllalso') != '') {
                                                    echo stripslashes($this->lang->line('Youllalso'));
                                                } else echo "You will also get to meet interesting travelers around the world!"; ?></p>
                                            <div class="text-center"><a class="list_spaceds submitBtn1"
                                                                        href="<?= base_url(); ?>list_space"><?php if ($this->lang->line('Postanew') != '') {
                                                        echo stripslashes($this->lang->line('Postanew'));
                                                    } else echo "Post a new listing"; ?></a></div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        </div>
                        <div class="col-lg-12 myPage" >
                            <div class="myPagination" id="page_numbers">
                                <?php
                                echo $paginationLink;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
$this->load->view('site/includes/footer');
?>
