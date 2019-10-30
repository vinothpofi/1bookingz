<?php

$this->load->view('admin/templates/header.php');

extract($privileges);

?>

    <div id="content">

        <div class="grid_container">

            <?php

            $attributes = array('id' => 'display_form');

            echo form_open('admin/order/change_order_status_global', $attributes)

            ?>

            <div class="grid_12">

                <div class="widget_wrap">

                    <div class="widget_top">

                        <span class="h_icon blocks_images"></span>

                        <h6><?php echo $heading ?></h6>

                    </div>

                    <div class="widget_content">

                        <table class="display display_tbl" id="subadmin_tbl">

                            <thead>

                            <tr>

                                <th class="center">

                                    <?php

                                    echo form_input([

                                        'type' => 'checkbox',

                                        'value' => 'on',

                                        'name' => 'checkbox_id[]',

                                        'class' => 'checkall'

                                    ]);

                                    ?>

                                </th>

                                <th class="tip_top" title="Click to sort">S No</th>

                                <th class="tip_top" title="Click to sort">Booking No</th>

                                <th class="tip_top" title="Click to sort">Date Added</th>

                                <th class="tip_top" title="Total booking amount in host's currency">Amount (Host) <i
                                            class="fa fa-info-circle"></i></th>

                                <th class="tip_top" title="Total booking amount in admin's currency">Amount (Admin) <i
                                            class="fa fa-info-circle"></i></th>

                                <th>Guest Email ID</th>

                                <th>Host Email ID</th>

                                <th class="tip_top" title="Click to sort">Booking Status</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php

                            /*echo '<pre>';
                            print_r($newbookingList->result());
                            echo '</pre>';
                            */
                            //is_wallet_used
                            if ($newbookingList->num_rows() > 0) {

                                $i = 1;

                                foreach ($newbookingList->result() as $row) {
                                    if ($row->currency_cron_id == 0) {
                                        $currencyCronId = '';
                                    } else {
                                        $currencyCronId = $row->currency_cron_id;
                                    }
                                    ?>

                                    <tr>

                                        <td class="center tr_select <?php echo $row->currency_cron_id; ?>">

                                            <?php

                                            echo form_input([

                                                'type' => 'checkbox',

                                                'value' => $row->id,

                                                'name' => 'checkbox_id[]',

                                                'class' => 'check'

                                            ]);

                                            ?>

                                        </td>

                                        <td class="center"><?php echo $i; ?></td>

                                        <td class="center"><?php echo $row->Bookingno; ?></td>

                                        <td class="center">

                                            <?php echo date('d-m-Y', strtotime($row->dateAdded)); ?>

                                        </td>

                                        <td class="center <?php echo $row->user_currencycode; ?>">

                                            <?php

                                            $hostCurrency = $row->currency_symbols;
                                            if ($row->user_currencycode != $row->currencycode) {
                                                echo $hostCurrency . currency_conversion($row->user_currencycode, $row->currencycode, $row->totalAmt, $currencyCronId) . "<br>";
                                            } else {
                                                echo $hostCurrency . $row->totalAmt . "<br>";
                                            }


                                            /*if ($row->is_coupon_used == 'Yes') {
                                                $couponPrice = ($row->total_amt - $row->discount);
                                                if ($row->user_currencycode != $admin_currency_code) {

                                                    $couponPriceC = $hostCurrency . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $couponPrice, $currencyCronId);//. convertCurrency($admin_currency_code,$row->currencycode,$couponPrice);

                                                } else {
                                                    $couponPriceC = $hostCurrency . " " . $couponPrice;
                                                    echo "Coupon : " . $couponPriceC;
                                                }
                                            }*/

                                            ?>

                                        </td>

                                        <td class="center">

                                            <?php

                                            $expID = $row->prd_id;

                                            $unitPerCurrencyUser = $row->currencyPerUnitSeller;

                                            if ($admin_currency_code != $row->user_currencycode) {

                                                echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->totalAmt, $currencyCronId);//customised_currency_conversion($unitPerCurrencyUser,$row->totalAmt);
                                            } else {
                                                echo $admin_currency_symbol . ' ' . $row->totalAmt;
                                            }
                                            if ($row->is_coupon_used == 'Yes') {

                                                $couponPrice = ($row->total_amt - $row->discount);
                                                if ($admin_currency_code != $row->user_currencycode) {
                                                    echo "<br> Coupon :  " . $admin_currency_symbol . " " . currency_conversion($row->user_currencycode, $admin_currency_code, $couponPrice, $currencyCronId);// customised_currency_conversion($unitPerCurrencyUser,$couponPrice);
                                                } else {
                                                    echo "<br> Coupon :  " . $admin_currency_symbol . " " . $couponPrice;
                                                }
                                            }
                                            if ($row->is_wallet_used == 'Yes') {

                                                $walletPrice = ($row->wallet_Amount);
                                                if ($admin_currency_code != $row->user_currencycode) {
                                                    echo "<br> Wallet : " . $admin_currency_symbol . " " . currency_conversion($row->user_currencycode, $admin_currency_code, $walletPrice, $currencyCronId);// customised_currency_conversion($unitPerCurrencyUser,$couponPrice);
                                                } else {
                                                    echo "<br> Wallet : " . $admin_currency_symbol . " " . $walletPrice;
                                                }
                                            }

                                            ?>

                                        </td>

                                        <td class="center">

                                            <?php echo $row->email; ?>

                                        </td>

                                        <td class="center">

                                            <?php

                                            $hostemail = $this->account_model->get_all_details(USERS, array('id' => $row->renter_id));

                                            echo $hostemail->row()->email;

                                            ?>

                                        </td>

                                        <td class="center">

                                            <span class="badge_style b_done"><?php echo ($row->status == "Paid") ? "Booked" : "Pending"; ?></span>

                                        </td>

                                    </tr>

                                    <?php

                                    $i++;

                                }

                            }

                            ?>

                            </tbody>

                            <tfoot>

                            <tr>

                                <th class="center">

                                    <?php

                                    echo form_input([

                                        'type' => 'checkbox',

                                        'value' => 'on',

                                        'name' => 'checkbox_id[]',

                                        'class' => 'checkall'

                                    ]);

                                    ?>

                                </th>

                                <th class="tip_top" title="Click to sort">S No</th>

                                <th class="tip_top" title="Click to sort">Booking No</th>

                                <th class="tip_top" title="Click to sort">Date Added</th>

                                <th>Amount (Host)</th>

                                <th class="tip_top" title="Click to sort">Amount (Admin)</th>

                                <th>Guest Email ID</th>

                                <th>Host Email ID</th>

                                <th class="tip_top" title="Click to sort">Booking Status</th>

                            </tr>

                            </tfoot>

                        </table>

                    </div>

                </div>

            </div><?php

            echo form_input([

                'type' => 'hidden',

                'id' => 'statusMode',

                'name' => 'statusMode'

            ]);


            echo form_input([

                'type' => 'hidden',

                'id' => 'SubAdminEmail',

                'name' => 'SubAdminEmail'

            ]);


            echo form_close();

            ?>

        </div>

        <span class="clear"></span>

    </div>

    </div>

<?php

$this->load->view('admin/templates/footer.php');

?>