<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');
?>
    <section>
        <div class="container">
            <div class="loggedIn clear">
                <div class="width20">
                    <?php $this->load->view('site/experience/ExperienceSideLinks'); ?>
                </div>
                <div class="width80">
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="table-responsive">
                               <table class="table  table-striped">
                     <tr>
                        <th width="10%"><?php if ($this->lang->line('BookedOn') != '') {  echo stripslashes($this->lang->line('BookedOn')); } else echo "Booked On"; ?></th>
                        <th width="20%"><?php if ($this->lang->line('Name') != '') { echo stripslashes($this->lang->line('Name')); } else echo "Name"; ?></th>
                        <th width="20%"><?php if ($this->lang->line('DatesandLocation') != '') { echo stripslashes($this->lang->line('DatesandLocation'));  } else echo "Dates and Location"; ?></th>
                        
                        <th width="10%"><?php if ($this->lang->line('cancellation_amount') != '') { echo stripslashes($this->lang->line('cancellation_amount')); } else echo "Cancellation Amount"; ?></th>
                        <th width="10%"><?php if ($this->lang->line('paid') != '') { echo stripslashes($this->lang->line('paid')); } else { echo "Paid"; }  echo '<a href="#" class="info-circle" data-toggle="tooltip" title="Total Booking amount with service fee and security fee." data-placement="top"><i class="fa fa-info-circle fa-lg"></i></a>'?></th>
                        <th width="10%"><?php if ($this->lang->line('balance') != '') { echo stripslashes($this->lang->line('balance')); } else echo "Balance"; ?></th>
 <th width="10%"><?php if ($this->lang->line('status') != '') { echo stripslashes($this->lang->line('status')); } else echo "Status"; ?></th>

                        
                     </tr>
                     <?php
            //print_r($bookedRental->result());
                        if ($cancelledRental->num_rows() > 0) {
            
                            foreach ($cancelledRental->result() as $row) {
                /*$paymentstatus = $this->vehicle_model->get_all_details(VEHICLE_PAYMENT, array('Enquiryid' => $row->cid));
  
                                $chkval = $paymentstatus->num_rows();
                                $status = $paymentstatus->row()->status;
                                $pr_details = $this->vehicle_model->get_all_details(USERS, array('id' => $row->user_id)); //to display the user is available or not.
                                $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                                $unitprice = $row->unitPerCurrencyUser;
                                */
                $user_currencycode = $row->user_currencycode;
                $currencyCronId = $row->currency_cron_id;
                                ?>
                     <tr>
                        <td><?php echo date('M d, Y', strtotime($row->bookedDate)); ?></td>
                        <td>
                            <?php
                            if($this->session->userdata('language_code')=='en')
                            {
                                $productTitle=$row->experience_title;
                            }
                            else
                            {
                                $titleNameField='experience_title_'.$this->session->userdata('language_code');
                                if($row->$titleNameField=='') {
                                    $productTitle=$row->experience_title;
                                }
                                else{
                                    $productTitle=$row->$titleNameField;
                                }
                            }

                            ?>
                           <?php
                              $imgSrc = 'dummyProductImage.jpg';
                              if ($row->product_image != "" && file_exists('./images/experience/' . $row->product_image)) {
                                  $imgSrc = $row->product_image;
                              }
                              echo img(base_url() . 'images/experience/' . $imgSrc);?>
                
                <a href="<?php echo base_url() ."view_experience/".$row->experience_id; ?>"> <?php echo ($productTitle != "") ? ucfirst($productTitle) : '---'; ?></a>
                        </td>
            <td>
              <?php 
              if ($row->checkin != '0000-00-00 00:00:00' && $row->checkout != '0000-00-00 00:00:00') {
                echo date('M d, Y', strtotime($row->checkin)) . " - " . date('M d, Y', strtotime($row->checkout));
              } ?>
                           
              <div>
                <?php
                if ($this->lang->line('booking_no') != '') {  echo stripslashes($this->lang->line('booking_no'));  } else { echo "Booking No"; } echo " : "; echo $row->booking_no; ?>
              </div>
                        </td>
                        <!--3-->
                       
                        <td>
              <?php
              if ($user_currencycode != $this->session->userdata('currency_type')) 
              {
                $Paid = changeCurrency($user_currencycode,$this->session->userdata('currency_type'),$row->paid_cancel_amount,$currencyCronId);
              } 
              else
              {
                $Paid = $row->paid_cancel_amount;
              }
              echo $currencySymbol . ' ' . $Paid;
              
              ?>
                        </td>
            <td>
              <?php
                if ($row->paid_canel_status == 1)
                {
                  if ($user_currencycode != $this->session->userdata('currency_type')) 
                  {
                    $Paid = changeCurrency($user_currencycode,$this->session->userdata('currency_type'),$row->paid_cancel_amount,$currencyCronId);
                  } 
                  else
                  {
                    $Paid = $row->paid_cancel_amount;
                  }
                  echo $currencySymbol . ' ' . $Paid;
                } 
                else
                {
                  echo $currencySymbol . '' . "0.00";
                }
              ?>
            </td>
            <td>
              <?php
              if ($row->paid_canel_status == 0)
              {
                if ($user_currencycode != $this->session->userdata('currency_type')) 
                {
                  $Paid = changeCurrency($user_currencycode,$this->session->userdata('currency_type'),$row->paid_cancel_amount,$currencyCronId);
                } 
                else
                {
                  $Paid = $row->paid_cancel_amount;
                }
                echo $currencySymbol . ' ' . $Paid;
                
              }
              else
              {
                echo $currencySymbol . '' . "0.00";
              }
              
              
              ?>
            </td>
            <td>
              <?php
              if ($row->paid_canel_status == 0)
              {
               if ($this->lang->line('pending') != '') { echo stripslashes($this->lang->line('pending')); } else echo "Pending"; 
                
              }
              else
              {
                 if ($this->lang->line('paid') != '') { echo stripslashes($this->lang->line('paid')); } else echo "Paid"; 
              }
              
              
              ?>
            </td>
          </tr>
                     <?php }
                        } else {
                            ?>
                     <tr>
                        <td colspan="8">
                           <p class="text-center text-danger"> <?php if ($this->lang->line('Youhavenocancellation') != '') { echo stripslashes($this->lang->line('Youhavenocancellation'));    } else echo "No cancellation is done by you"; ?> </p>
                        </td>
                     </tr>
                     <?php
                        } ?>
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