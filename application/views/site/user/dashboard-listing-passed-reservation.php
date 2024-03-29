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
                                } else echo "Your Reservations"; ?></a>
								</li>
								
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
                            <div class="table-responsive">
                            <table class="table  table-striped leftAlign">
                                <tr>
                                    <th width="5%"><?php if ($this->lang->line('UserName') != '') {
                                            echo stripslashes($this->lang->line('UserName'));
                                        } else echo "User Name"; ?></th>
                                    <th width="30%"><?php if ($this->lang->line('DatesandLocation') != '') {
                                            echo stripslashes($this->lang->line('DatesandLocation'));
                                        } else echo "Dates and Location"; ?></th>
                                    <th width="10%"><?php if ($this->lang->line('Amount') != '') {
                                            echo stripslashes($this->lang->line('Amount'));
                                        } else echo "Amount"; ?></th>
                                    <th width="5%"><?php if ($this->lang->line('PaymentStatus') != '') {
                                            echo stripslashes($this->lang->line('PaymentStatus'));
                                        } else echo "Payment Status"; ?></th>
                                    <th width="5%"><?php if ($this->lang->line('Approval') != '') {
                                            echo stripslashes($this->lang->line('Approval'));
                                        } else echo "Approval"; ?></th>
                                </tr>
                                <?php
                                if ($bookedRental->num_rows() > 0) {
                                    foreach ($bookedRental->result() as $row) {     
                                        ?>
                                        <tr>
                                            <td><img src="<?php
                                                echo ($row->image != "" && file_exists('./images/users/' . $row->image)) ? base_url() . 'images/users/' . $row->image : base_url() . 'images/users/profile.png';
                                                ?>" class="userIcon"/><br/><a
                                                        target="_blank"
                                                        href="users/show/<?php echo $row->GestId; ?>"
                                                        style="float:left;  "><?php echo $row->firstname; ?></a>
                                            </td>
                                            <td class="nw-lite"> <?php if ($row->checkin != '0000-00-00 00:00:00' && $row->checkout != '0000-00-00 00:00:00') {
                                                    echo "<br>" . date('M d', strtotime($row->checkin)) . " - " . date('M d, Y', strtotime($row->checkout)) . "<br>";
                                                      
                                                        $prod_tiltle=language_dynamic_enable("product_title",$this->session->userdata('language_code'),$row);                                     
                                                    echo "<a href='" . base_url() . "rental/" . $row->product_id . "'>" . $prod_tiltle . "</a><br>";
                                                    echo $row->address . "<br>";
                                                    if ($this->lang->line('booking_no') != '') {
                                                        echo stripslashes($this->lang->line('booking_no'));
                                                    } else echo "Booking No";
                                                    echo " : " . $row->Bookingno;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo $currencySymbol; ?>
                                                <?php
                                                if ($row->is_coupon_used == 'Yes') {
                                                    echo '<p class="text-success">Coupon: ' . $row->coupon_code . '</p>';
                                                    echo '<p style="text-decoration: ;">' . strtoupper($currencySymbol) . " " . number_format($row->discount * $this->session->userdata('currency_r'), 2) . '</p>';
                                                    echo '<p style="text-decoration: line-through;">' . strtoupper($currencySymbol) . " " . number_format($row->total_amt * $this->session->userdata('currency_r'), 2) . '</p>';
                                                } else {
                                                    foreach ($result as $product) {
                                                    }
                                                    $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                                                    $totalAmount = ($row->subTotal + $row->serviceFee + $row->secDeposit);
                                                    $currency = $row->currency;
                                                    if ($row->user_currencycode != $this->session->userdata('currency_type')) {
                                                        if ($currency_result->$currency) {
                                                            $price = $totalAmount / $currency_result->$currency;
                                                        } else {
                                                            $price = currency_conversion($row->user_currencycode, $this->session->userdata('currency_type'), $totalAmount);
                                                        }
                                                        echo ' ' . number_format($price, 2);
                                                    } else {
                                                        echo number_format($totalAmount, 2);
                                                    }
                                                }
                                                ?>
                                                <?php echo $this->session->userdata('currency_type'); ?>
                                            </td>
                                            <td>
                                                <?php
                                                $paymentstatus = $this->cms_model->get_all_details(PAYMENT, array('Enquiryid' => $row->EnqId));
                                                $chkval = $paymentstatus->num_rows();
                                                if ($chkval == 1) {
                                                    ?>
                                                    <p><a href="javascript:void(0);" title="Edit Enquiry">
                                                            <?php
                                                            if ($this->lang->line('paid') != '') {
                                                                echo stripslashes($this->lang->line('paid'));
                                                            } else echo "Paid";
                                                            ?></a></p>
                                                    <p>
                                                        <a href="<?php echo base_url(); ?>site/user/invoice/<?php echo $row->Bookingno; ?>"
                                                           target="_blank"><?php if ($this->lang->line('Confirmation') != '') {
                                                                echo stripslashes($this->lang->line('Confirmation'));
                                                            } else echo "Confirmation"; ?></a></p>
                                                           <?php  if($row->cancelled == 'Yes' && $row->dispute_by == 'Host')
                                                           {  ?>
                                                            <p><a href="javascript:void(0);" title="Edit Enquiry">
                                                                                                                       <?php
                                                                                                                       if ($this->lang->line('cancell_by_host') != '') {
                                                                                                                           echo stripslashes($this->lang->line('cancell_by_host'));
                                                                                                                       } else echo "Cancelled By Host";
                                                                                                                       ?></a></p><?php } 

else if($row->cancelled == 'Yes' ){ ?>

    <p><a href="javascript:void(0);" title="Edit Enquiry">
                                                                                                                       <?php
                                                                                                                       if ($this->lang->line('cancelled') != '') {
                                                                                                                           echo stripslashes($this->lang->line('cancelled'));
                                                                                                                       } else echo "Cancelled";
                                                                                                                   ?></a></p> <?php   

}

                                                                                                                       ?>
                                                                                                                     
                                                <?php } else {
                                                    if ($this->lang->line('Pending') != '') {
                                                        echo stripslashes($this->lang->line('Pending'));
                                                    } else echo "Pending";
                                                } ?>
                                            </td>
                                            <td>
                                                <?php if ($row->approval == 'Pending') {
                                                    if ($this->lang->line('approval_pending') != '') {
                                                        echo stripslashes($this->lang->line('approval_pending'));
                                                    } else echo "Approval Pending";
                                                } else {
                                                    if ($this->lang->line('Accepted') != '') {
                                                        $accepted = stripslashes($this->lang->line('Accepted'));
                                                    } else {
                                                        $accepted = "Accepted";
                                                    }
                                                    if ($this->lang->line('Declined') != '') {
                                                        $declined = stripslashes($this->lang->line('Declined'));
                                                    } else {
                                                        $declined = "Declined";
                                                    }
                                                    ?>
                                                    <?php echo ($row->approval == 'Accept') ? "$accepted" : "$declined"; ?>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">
                                            <h4 class="text-center"><?php
                                                if ($this->lang->line('no_past_reservation') != '') {
                                                    echo stripslashes($this->lang->line('no_past_reservation'));
                                                } else echo "No Past Reservation History";
                                                ?></h4>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        </div>
                        <div class="col-lg-12 myPage">
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