


                <div class="widget_content1">
                    <table class="display display_tbl" id="subadmin_tbl">
                        <thead>
                        <tr>
                            <th class="tip_top" title="Click to sort">S No</th>
                            <th class="tip_top" title="Click to sort">Date</th>
                            <th class="tip_top" title="Click to sort">Transaction Id</th>
                            <th class="tip_top" title="Click to sort">Booking No</th>
                            <th>Host Email Id</th>
                            <th>Total Amount</th>
                            <th>Guest Service Fee</th>
                            <th>Host Service Fee</th>
                            <th>Net Profit</th>
                            <th>Amount to Host</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($showselectedDet->num_rows() > 0)
                        {
                            $i = 1;
                            foreach ($showselectedDet->result() as $row)
                            {
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="center">
                                        <?php echo date('d-m-Y', strtotime($row->dateAdded)); ?>
                                    </td>
                                    <td>
                                        <?php
                                        if($row->transaction_id!=''){
                                            echo $row->transaction_id;
                                        }else{
                                            echo "---";
                                        }
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php echo $row->booking_no; ?>
                                    </td>

                                    <td class="center">
                                        <?php echo $row->host_email; ?>
                                    </td>

                                    <td class="center">
                                        <?php
                                        $currencyPerUnitSeller = $row->currencyPerUnitSeller;
										if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id; }
										if ($admin_currency_code != $row->user_currencycode) 
										{												
											echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
											echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->total_amount,$currencyCronId);
										} 
										else
										{
											echo $admin_currency_symbol . ' ' . number_format($row->total_amount,2);
										}
                                        /*if ($admin_currency_code != $row->currencycode)
                                        {
                                            echo $admin_currency_symbol . ' ' . customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
                                        }
                                        else
                                        {
                                            echo $admin_currency_symbol . ' ' . $row->total_amount;
                                        }*/
                                        ?>
                                    </td>
                                    <td class="center">
                                        <?php
										if ($admin_currency_code != $row->user_currencycode) 
										{												
											echo $admin_currency_symbol . ' ' ;//. customised_currency_conversion($currencyPerUnitSeller, $row->guest_fee);
											echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->guest_fee,$currencyCronId);
										} 
										else
										{
											echo $admin_currency_symbol . ' ' . number_format($row->guest_fee,2);
										}
                                        /*if ($admin_currency_code != $row->currencycode)
                                        {
                                            echo $admin_currency_symbol . ' ' . customised_currency_conversion($currencyPerUnitSeller, $row->guest_fee);
                                        }
                                        else
                                        {
                                            echo $admin_currency_symbol . ' ' . $row->guest_fee;
                                        }*/
                                        ?>
                                    </td>

                                    <td class="center">
                                        <?php
										if ($admin_currency_code != $row->user_currencycode) 
										{												
											echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->host_fee);
											echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->host_fee,$currencyCronId);
										} 
										else
										{
											echo $admin_currency_symbol . ' ' . number_format($row->host_fee,2);
										}
                                        /*if ($admin_currency_code != $row->currencycode)
                                        {
                                            echo $admin_currency_symbol . ' ' . customised_currency_conversion($currencyPerUnitSeller, $row->host_fee);
                                        }
                                        else
                                        {
                                            echo $admin_currency_symbol . ' ' . $row->host_fee;
                                        }*/
                                        ?>
                                    </td>

                                    <td class="center">
                                        <?php
										$net_profit = round($row->guest_fee + $row->host_fee, 2);

										if ($admin_currency_code != $row->user_currencycode) 
										{												
											echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $net_profit);
											echo currency_conversion($row->user_currencycode, $admin_currency_code, $net_profit,$currencyCronId);
										} 
										else 
										{
											echo $admin_currency_symbol . ' ' . number_format($net_profit,2);
										}
                                        /*$net_profit = round($row->guest_fee + $row->host_fee, 2);

                                        if ($admin_currency_code != $row->currencycode)
                                        {
                                            echo $admin_currency_symbol . ' ' . customised_currency_conversion($currencyPerUnitSeller, $net_profit);
                                        }
                                        else
                                        {
                                            echo $admin_currency_symbol . ' ' . $net_profit;
                                        }*/
                                        ?>
                                    </td>

                                    <td class="center">
                                        <?php
										if ($admin_currency_code != $row->user_currencycode) 
										{
											echo $admin_currency_symbol . ' ';// . customised_currency_conversion($currencyPerUnitSeller, $row->payable_amount);
											echo currency_conversion($row->user_currencycode, $admin_currency_code, $row->payable_amount,$currencyCronId);
										} 
										else
										{
											echo $admin_currency_symbol . ' ' . number_format($row->payable_amount,2);
										}
                                        /*if ($admin_currency_code != $row->currencycode)
                                        {
                                            echo $admin_currency_symbol . ' ' . customised_currency_conversion($currencyPerUnitSeller, $row->payable_amount);
                                        }
                                        else
                                        {
                                            echo $admin_currency_symbol . ' ' . $row->payable_amount;
                                        }*/
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                $i++;
                            }
                        } else { ?>
                            <tr>
                                <td class="center">
                                    <?php echo "No Data in the Table"; ?>
                                </td>
                            </tr>

                   <?php    }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th class="tip_top" title="Click to sort">S No</th>
                            <th class="tip_top" title="Click to sort">Date</th>
                            <th class="tip_top" title="Click to sort">Transaction Id</th>
                            <th class="tip_top" title="Click to sort">Booking No</th>
                            <th>Host Email Id</th>
                            <th>Total Amount</th>
                            <th>Guest Service Fee</th>
                            <th>Host Service Fee</th>
                            <th>Net Profit</th>
                            <th>Amount to Host</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


