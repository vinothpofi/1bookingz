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
                                                <?php /*echo $currencySymbol; */
                                                if ($this->lang->line('Coupon_Used') != '') {
                                                        $coupon = stripslashes($this->lang->line('Coupon_Used'));
                                                    } else $coupon = "Coupon Used";
                                                if ($row->is_coupon_used == 'Yes') {
                                                    echo '<p class="text-success">'.$coupon.': ' . $row->coupon_code . '</p>';
                                                    echo '<p style="text-decoration: ;">'. " " . number_format($row->paid_amount * $this->session->userdata(    'currency_r'), 2) . '</p>';
                                                    /*echo '<p style="text-decoration: line-through;">' . strtoupper($currencySymbol) . " " . number_format($row->total_amt * $this->session->userdata('currency_r'), 2) . '</p>';*/
                                                } else {
                                                    foreach ($result as $product) {
                                                    }
                                                    $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                                                    $totalAmount = ($row->subTotal + $row->serviceFee + $row->secDeposit);
                                                    $currency = $row->currency;//INR
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
                                               // prin;exit();
                                                $paymentstatus = $this->cms_model->get_all_details(PAYMENT, array('Enquiryid' => $row->EnqId));
                                                //print_r($paymentstatus->row());
                                                //echo $paymentstatus->num_rows();
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
                                                            <?php 
                                                            $time_val = date('Y-m-d');
                                                            $checkinBeforeDay = date('Y-m-d', $row->checkin);
                                                            //  if ($time_val <= $checkinBeforeDay) 
                                                            // {
                                                            $dis_details = $this->product_model->get_all_details(DISPUTE, array('user_id' => $row->GestId, 'prd_id' => $row->product_id, 'booking_no' => $row->Bookingno,'dispute_by'=>'Host'));
                                                            //print_r($row);exit();
                                                            //echo $this->db->last_query();
                                                            if ($dis_details->num_rows() == 0) {
                                                                $time_val = date('Y-m-d');
                                                                $check_in = date("Y-m-d", strtotime($row->checkin));
                                                                $check_out = date("Y-m-d", strtotime($row->checkout));
                                                                //echo $time_val.'/'.$check_in;
                                                                 $admin = $this->user_model->get_all_details(ADMIN_SETTINGS, array('id' => '1'));

                                                    $cancel_hide_days_experience_host = $admin->row()->cancel_hide_days_property_host;
                                                   $req_date = '-'.$cancel_hide_days_experience_host.' days';

                                                  $cancel_hide_days = date('Y-m-d', strtotime($req_date, strtotime($row->checkin)));
                                                                if($time_val < $cancel_hide_days && $row->is_coupon_used != 'Yes'  && $row->is_wallet_used != 'Yes')
                                                                {
                                                            ?>

                                                            <p><a data-toggle="modal" href="#host_cancel_booking_<?php echo $row->Bookingno; ?>">Cancel</a></p>

                                                        <?php// } ?>
<div id="host_cancel_booking_<?php echo $row->Bookingno; ?>"  class="modal2Col modal fade"  role="dialog">
                                                                  <div class="modal-dialog">
                                                                     <!-- Modal content-->
                                                                     <div class="modal-content">
                                                                        <div class="modal-header">
                                                                           <button type="button" class="close" data-dismiss="modal"> &times; </button>
                                                                           <h2> <?php if ($this->lang->line('cancel_booking') != '') {  echo stripslashes($this->lang->line('cancel_booking'));  } else echo "Cancel Booking"; ?></h2>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                           <div class="tableRow">
                                                                              <!-- <div class="left">
                                                                                 <img src="<?php echo ($row->veh_image != "" && file_exists('./images/vehicles/' . $row->veh_image)) ? base_url() . 'images/vehicles/' . $row->veh_image : base_url() . "images/vehicles/dummyProductImage.jpg"; ?>"
                                                                                    class="propIcon">
                                                                              </div> -->
                                                                              <div class="right">
                                                                                 <div class="clear">
                                                                                     <?php
                                                                                     if($this->session->userdata('language_code')=='en')
                                                                                     {
                                                                                         $productTitle=$row->product_title;
                                                                                     }
                                                                                     else
                                                                                     {
                                                                                         $titleNameField='product_title_'.$this->session->userdata('language_code');
                                                                                         if($row->$titleNameField=='') {
                                                                                             $productTitle=$row->product_title;
                                                                                         }
                                                                                         else{
                                                                                             $productTitle=$row->$titleNameField;
                                                                                         }
                                                                                     }
                                                                                     $pdt_title=($productTitle != "") ? ucfirst($productTitle) : '---';
                                                                                     ?>
                                                                                    <h5><?php echo $pdt_title; ?></h5>
                                                                                    <div class="address">
                                                                                       <?php echo ucfirst($row->address); ?>
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="content">
                                                                                    <?php
                                                                                    //print_r($row);
                                                                                       echo form_open('site/product/host_cancel_booking', array('id' => 'CancelFormSubmit_'.$row->Bookingno));
                                                                                       echo form_hidden('prd_id', $row->product_id);
                                                                                       // echo form_hidden('vehicle_type', $row->vehicle_type);
                                                                                       echo form_hidden('user_id', $row->GestId);
                                                                                       echo form_hidden('Bookingno', $row->Bookingno);
                                                                                       echo form_hidden('cancellation_percentage', '0');
                                                                                       echo form_hidden('disputer_id', $row->renter_id);
                                                                                       echo form_hidden('email', $Host_Details->email);
                                                                                       echo form_hidden('trip_url', $this->uri->segment(1));
                                                                                     //  echo form_textarea('message', '');
                                                                                       
                                                                                        echo form_textarea(array('name' => 'message', 'id' => 'cancel_message_'.$row->Bookingno, 'rows' => '5', 'maxlength' => '300','required'=>'required'));
                                                                                       ?>
                                                                                 </div>
                                                                                 
                                                                                 <?php if ($this->lang->line('cancel_booking') != '') { $can_bk= stripslashes($this->lang->line('cancel_booking')); }  else { $can_bk= "Cancel Booking"; }  ?>
                                                                              
                                                                                 <div class="colRight">
                                                                                    <?php
                                                                                       echo form_button('', "$can_bk", array('onClick' => 'add_cancel(\''.$row->Bookingno.'\');','class' => 'submitBtn1'));
                                                
                                                                                       echo form_close();
                                                                                       ?>
                                                                                 </div>
                                                                                 
                                                                                 
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                               </div>

                                                           <?php } } else{ ?>
                                                            <p><a data-toggle="modal" href="#host_cancel_booking_<?php echo $row->Bookingno; ?>"><?php if ($this->lang->line('cancell_by_host') != '') { echo stripslashes($this->lang->line('cancell_by_host')); } else echo "Cancelled By Host"; ?> </a></p>
                                                           <?php }?>

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
                                                if ($this->lang->line('no_upcoming_reservations') != '') {
                                                    echo stripslashes($this->lang->line('no_upcoming_reservations'));
                                                } else echo "You have no upcoming reservations.";
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
        <script>
    function add_cancel(booking_no){
        if ($('textarea#cancel_message_'+booking_no).val() == '') {
            alert('Please enter Message!');
            $('#cancel_message_'+booking_no).focus();
        return false;
        }else{
            $('#CancelFormSubmit_'+booking_no).submit();
        }
    }
    </script>
<?php
$this->load->view('site/includes/footer');
?>