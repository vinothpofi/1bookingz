<script type="text/javascript">
    $('#subadmin_tbl2').dataTable({   

         "aoColumnDefs": [

                            //{ "bSortable": false, "aTargets": [ 0 ,-1 ] }

                        ],

                        // "aaSorting": [[2, 'desc']],

        "sPaginationType": "full_numbers",

        "iDisplayLength": 100,

        "oLanguage": {

            "sLengthMenu": "<span class='lenghtMenu'> _MENU_</span><span class='lengthLabel'>Entries per page:</span>", 

        },

         "sDom": '<"table_top"fl<"clear">>,<"table_content"t>,<"table_bottom"p<"clear">>'

         

        });
</script>
<div class="widget_content1 table-div">
    <table class="display display_tbl" id="subadmin_tbl2">
        <thead>
        <tr>
            <th class="tip_top" title="Click to sort">S No</th>
            <th class="tip_top" title="Click to sort">Date</th>
            <th class="tip_top" title="Click to sort">Transaction ID</th>
            <th class="tip_top" title="Click to sort">Booking No</th>
            <th>Host Email Id</th>
            <th class="tip_top" title="Total amount with service fee and security fee in admin's currency">Total Amount&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
            <th class="tip_top" title="Service fee in admin's currency">Guest Service Fee&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
            <th>Host Service Fee</th>
            <th class="tip_top" title="Sum of Guest service fee and Host servie fee in admin's currency">Net Profit&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
            <th class="tip_top" title="Payable amount to host in admin's currency">Amount to Host&nbsp;<i class="fa fa-info-circle fa-lg tipTop"></i></th>
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
                        if ($row->transaction_id!=''){
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
                            echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->total_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
                        }
                        else
                        {
                            echo $admin_currency_symbol . ' ' . $row->total_amount;
                        }
                        ?>
                    </td>
                    <td class="center">
                        <?php
                        if ($admin_currency_code != $row->user_currencycode)
                        {
                            echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->guest_fee,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->guest_fee);
                        }
                        else
                        {
                            echo $admin_currency_symbol . ' ' . $row->guest_fee;
                        }
                        ?>
                    </td>
                    <td class="center">
                        <?php
                        if ($admin_currency_code != $row->user_currencycode)
                        {
                            echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->host_fee,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->host_fee);
                        }
                        else
                        {
                            echo $admin_currency_symbol . ' ' . $row->host_fee;
                        }
                        ?>
                    </td>
                    <td class="center">
                        <?php

                        $net_profit = round($row->guest_fee + $row->host_fee, 2);

                        if ($admin_currency_code != $row->user_currencycode)
                        {
                            echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $net_profit,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $net_profit);
                        }
                        else
                        {
                            echo $admin_currency_symbol . ' ' . $net_profit;
                        }
                        ?>
                    </td>

                    <td class="center">
                        <?php

                        if ($admin_currency_code != $row->user_currencycode)
                        {
                            echo $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->payable_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->payable_amount);
                        }
                        else
                        {
                            echo $admin_currency_symbol . ' ' . $row->payable_amount;
                        }
                        ?>
                    </td>
                </tr>
                <?php
                $i++;
            }
        }else { ?>

            <tr>
                <td class="center">
                  <?php echo "No Data In the table"; ?>
                </td>
            </tr>

        <?php }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th>S No</th>
            <th>Date</th>
            <th>Transaction ID</th>
            <th>Booking No</th>
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







