<?php
$this->load->view('site/includes/header');
$this->load->view('site/includes/top_navigation_links');
$currency_result = $this->session->userdata('currency_result');?>
<section>
<div class="container">
<div class="loggedIn clear">
 <div class="width20">
  <?php $this->load->view('site/experience/ExperienceSideLinks'); ?>
  </div>
  <div class="width80">
     <div class="row">
        <div class="col-sm-12 tran_container">
            <ul class="nav nav-tabs">
                 <li <?php echo ($active==1) ? 'class="active"' : ""; ?>><a data-toggle="tab" href="#menu1">
                     <?php if ($this->lang->line('CompletedTransactions') != '') {   echo stripslashes($this->lang->line('CompletedTransactions')); } else echo "Completed Transactions"; ?>
                     </a>
                </li>
                <li <?php echo ($active==2) ? 'class="active"' : ""; ?> ><a data-toggle="tab" href="#menu2"><?php if ($this->lang->line('FutureTransactions') != '') {  echo stripslashes($this->lang->line('FutureTransactions')); } else echo "Future Transactions"; ?>
                </a></li>
            </ul>
        <div class="tab-content marginBottom2">
            <div id="menu1" class="tab-pane fade in <?php echo ($active==1) ? 'active' : ""; ?>">
                <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th><?php if ($this->lang->line('Date') != '') {   echo stripslashes($this->lang->line('Date')); } else echo "Date"; ?>
                    </th>
                    <th><?php if ($this->lang->line('Transaction_Method') != '') {  echo stripslashes($this->lang->line('Transaction_Method'));   } else echo "Transaction Method"; ?>
                    </th>
                    <th><?php if ($this->lang->line('BookingNo') != '') {    echo stripslashes($this->lang->line('BookingNo'));  } else echo "Booking No"; ?>
                    </th>
                    <th><?php if ($this->lang->line('TransactionId') != '') {   echo stripslashes($this->lang->line('TransactionId'));    } else echo "Transaction Id"; ?>
                    </th>
                    <th ><?php if ($this->lang->line('Amount') != '') {   echo stripslashes($this->lang->line('Amount'));   } else echo "Amount"; ?>
                    </th>
                </tr>
                <?php
                if (count($completed_transaction->result()) > 0)
                {
                    foreach ($completed_transaction->result() as $row)
                    { ?>
                        <tr>
                        <td>
                        <?php echo date('d-m-Y', strtotime($row->dateAdded)); ?>
                        </td>
                        <td>
                        <div><?php if ($row->payment_type == 'ON') echo 'Paypal'; else { if ($this->lang->line('via_bank') != '') {   echo stripslashes($this->lang->line('via_bank')); } else echo "Via Bank";     } ?>
                        </div>                                                    </td>
                        <td>
                        <div><?php   $bk_numbers=explode(',',$row->booking_no);
                        foreach ( $bk_numbers as $bkNum)
                        {
                            echo $bkNum . '<br>';
                        }
                        ?>
                        </div>
                        </td>
                        <td>
                        <div><?php echo $row->transaction_id; ?></div>
                        </td>
                        <td>
                        <?php
                        echo $currencySymbol;
                        $exp_currency_code=$row->user_currencycode;
                        if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id;}
                        $amountToHost = $row->payable_amount-$row->paid_cancel_amount;
                        if ($exp_currency_code != $this->session->userdata('currency_type'))
                        {
                        echo currency_conversion($exp_currency_code, $this->session->userdata('currency_type'),  $amountToHost,$currencyCronId);
                        /*currency_conversion($exp_currency_code, $this->session->userdata('currency_type'), $amountToHost); */
                        } else {
                            echo  $amountToHost;
                        }
                        ?>
                        </td>
                        </tr>
                        <?php }
                        } else { ?>
                        <tr>
                        <td colspan="5">
                        <p class="text-center text-danger"><?php if ($this->lang->line('NoTransactions') != '') {   echo stripslashes($this->lang->line('NoTransactions'));
                        } else echo "No Transactions"; ?></p>
                        </td>
                        </tr>
                        <?php } ?>
                        </table>
                    </div>
                        <div class=" col-lg-12 myPage">
                        <div class="myPagination left">
                        <?php echo $completedpaginationLink; ?>
                        </div>
                        </div>
                        </div>
                        <div id="menu2" class="tab-pane fade in <?php echo ($active==2) ? 'active' : ""; ?>">
                            <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                        <tr>
                        <th><?php if ($this->lang->line('Date') != '') {
                        echo stripslashes($this->lang->line('Date'));
                        } else echo "Date"; ?>
                        </th>
                        <th>
                        <?php if ($this->lang->line('Transaction_Method') != '') {   echo stripslashes($this->lang->line('Transaction_Method'));
                        } else echo "Transaction Method"; ?>
                        </th>
                        <th ><?php if ($this->lang->line('Amount') != '') {   echo stripslashes($this->lang->line('Amount'));  } else echo "Amount"; ?>
                        </th>
                        </tr>
                        <?php
                        if (count($featured_transaction->result()) > 0)
                        {
                        foreach ($featured_transaction->result() as $row)
                        {
                        $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                        $unitPerCurrencyUser = $row->unitPerCurrencyUser;
                        $user_currencycode = $row->user_currencycode;
                        if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id;}                                                ?>
                        <tr>
                        <td><?php echo date('d-m-Y', strtotime($row->dateAdded)); ?></td>
                        <td>
                        <div>
                        <?php if($row->image!='') { ?>       <!-- <img src="<?php echo base_url();?>images/users/<?php echo $row->image; ?>" width="100" height="100" alt="<?php echo $row->firstname;?>"> -->
                        <?php } else { ?>    <!-- <img src="<?php echo base_url();?>images/users/user-thumb.png" width="100" height="100" alt="<?php echo $row->firstname;?>"> -->
                        <?php } ?>
                        </div>
                        <div><?php echo $row->firstname; ?>
                        </div>
                        <div>
                            <?php 

                            $prod_tiltle=language_dynamic_enable("experience_title",$this->session->userdata('language_code'),$row);

                            echo anchor("view_experience/" . $prod_tiltle, $row->experience_title);
                             ?>
                                
                        </div>
                        <h5><?php    echo $currencySymbol . " ";
                        $currency = $row->currency;
                        if ($row->currency != $this->session->userdata('currency_type'))
                        {
                        /*if ($currency_result->$currency) {     $price = $row->price / $currency_result->$currency;  } else {	  $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->price,$row->currency_cron_id,$row->currency_cron_id);  }*/
                        $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->price,$row->currency_cron_id,$row->currency_cron_id);
                        echo ' ' . number_format($price, 2);
                        } else {
                        echo $row->price;
                        }
                        ?></h5>
                        <div><?php if ($this->lang->line('Booking No') != '') {    echo stripslashes($this->lang->line('Booking No'));    } else echo "Booking No" ?>
                        : <?php echo $row->Bookingno; ?></div>
                        <?php
                        if ($row->checkin != '0000-00-00 00:00:00' && $row->checkout != '0000-00-00 00:00:00') {   echo "<br>" . date('M d, Y', strtotime($row->checkin)) . " - " . date('M d, Y', strtotime($row->checkout)) . "<br>";     };
                        if ($row->date_id != '') {     $date_id = $row->date_id;
                        $TimesAre = $this->db->where('exp_dates_id', $date_id)->get(EXPERIENCE_TIMING);
                        $count = $TimesAre->num_rows();
                        echo "<p class='toggleSchedule'>Read Timings(" . $count . ")</p><div class='scheduleDetails' style='display:none;'>";
                        foreach ($TimesAre->result() as $sched)
                        { ?>
                        <div>
                        <?php   echo '<b>' . $sched->title . '</b><br>';
                        echo date('M d, Y', strtotime($sched->schedule_date));
                        echo '<div class="timings">' . date('H:i', strtotime($sched->start_time)) . ' - ' . date('H:i', strtotime($sched->end_time)) . '</div>';
                        ?>
                        </div>
                        <?php }
                        echo "</div>";
                        }   ?>
                        </td>
                        <td class="right">
                             <h3 class="cancelAlert"  style="color: red;"> <?php if($row->cancelled == 'Yes'){

                                if($row->dispute_by == 'Host')
                                {
                                     echo 'Cancelled By You'; 
                                }
                                else
                                {
                                      echo 'Cancelled By Guest'; 
                                }


                            } ?></h3>
                        <p><?php if ($this->lang->line('Total') != '') {    echo stripslashes($this->lang->line('Total'));   } else echo "Total"; ?>
                        <span class="number_s120">
                        <?php    echo $currencySymbol . " ";
                        $currency = $row->user_currencycode;
                        /*echo $row->user_currencycode.'|'.$this->session->userdata('currency_type');   */
                        if ($row->user_currencycode != $this->session->userdata('currency_type'))
                        {
                            /*if ($currency_result->$currency) {    $price = $row->totalAmt / $currency_result->$currency;   } else {    $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->totalAmt);   }*/
                            /*echo $row->totalAmt;*/
                            $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->subTotal,$currencyCronId);
                            echo ' ' . $price;
                            } else {
                            echo number_format($row->subTotal,2);
                            }
                            ?></span></p>
                            <p><?php if ($this->lang->line('ServiceFee') != '') {    echo stripslashes($this->lang->line('ServiceFee'));   } else echo "Service Fee"; ?> <span class="number_s120">
                                <?php  echo $currencySymbol . " ";
                                $currency = $row->user_currencycode;
                                if ($row->user_currencycode != $this->session->userdata('currency_type'))
                                {
                                    /*if ($currency_result->$currency) {     $price = $row->guest_fee / $currency_result->$currency;    } else {    $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->guest_fee);    }*/
                                    $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->guest_fee,$row->currency_cron_id,$row->currency_cron_id);
                                    echo ' ' . $price;
                                    } else {     echo number_format($row->guest_fee,2);     }
                                    ?></span>
                                    </p>
                                    <p><?php if ($this->lang->line('SecurityDeposit') != '') {     echo stripslashes($this->lang->line('SecurityDeposit'));  } else echo "Security Deposit"; ?>
                                    <span   class="number_s120">
                                    <?php     echo $currencySymbol . " ";    $currency = $row->user_currencycode;
                                    if ($row->user_currencycode != $this->session->userdata('currency_type')) {
                                    /*if ($currency_result->$currency) {     $price = $row->secDeposit / $currency_result->$currency;     } else {   $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->secDeposit);                    }*/
                                    $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->secDeposit,$currencyCronId);
                                    echo ' ' . $price;
                                    } else {
                                    echo number_format($row->secDeposit,2);
                                    }
                                    ?></span></p>
                                    <p><?php if ($this->lang->line('Net Amount') != '') {      echo stripslashes($this->lang->line('Net Amount'));       } else echo "Net Amount"; ?> <span class="number_s120">
                                    <?php     echo $currencySymbol . " ";         $currency = $row->user_currencycode;
                                    if ($row->user_currencycode != $this->session->userdata('currency_type'))
                                    {
                                    /* if ($currency_result->$currency) {     $price = $row->payable_amount / $currency_result->$currency;     } else {                $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->payable_amount);                                                                    }*/
                                    $price = currency_conversion($currency, $this->session->userdata('currency_type'), $row->totalAmt,$currencyCronId);
                                    echo ' ' . $price;            } else {        echo number_format($row->totalAmt, 2);        }  ?></span>
                                    </p>
                                    </td>
                                    </tr>
                                    <?php }
                                    } else { ?>
                                    <tr>
                                    <td colspan="4">
                                    <p class="text-center text-danger"><?php if ($this->lang->line('NoTransactions') != '') {      echo stripslashes($this->lang->line('NoTransactions'));        } else echo "No Transactions"; ?></p>
                                    </td>
                                    </tr>
                                    <?php } ?>
                                    </table>
                                </div>
                                    <div class="myPagination" id="page_numbers">
                                    <?php echo $featuredpaginationLink; ?>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </section>
                                    <script>
                                    $(document).on("click", ".toggleSchedule", function () {            $(this).next(".scheduleDetails").slideToggle();        });
                                    </script>
                                    <?php
                                    $this->load->view('site/includes/footer');
                                    ?>
