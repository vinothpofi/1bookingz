<p>
    <?php if ($this->lang->line('Booking_for') != '') {
        echo stripslashes($this->lang->line('Booking_for'));
    } else echo "Booking for";
        echo ' ' . $total_nights . ' ';
        if ($this->lang->line('night') != '') {
            echo stripslashes($this->lang->line('night'));
        } else echo "Night"; ?> <span class="right"><?php echo $currencySymbol;
            echo number_format($total_value,2); ?></span>
</p>
<p><?php if ($this->lang->line('service_fee') != '') {
        echo stripslashes($this->lang->line('service_fee'));
    } else echo "Service Fee"; ?> <span class="right"><?php echo $currencySymbol;
            echo number_format($taxString,2); ?></span></p>
<p><?php if ($this->lang->line('SecurityDeposit') != '') {
        echo stripslashes($this->lang->line('SecurityDeposit'));
    } else echo "Security Deposit"; ?> <span class="right"><?php echo $currencySymbol;
            echo number_format($securityDeposite_string,2); ?></span></p>
<div class="total"><?php if ($this->lang->line('Total') != '') {
        echo stripslashes($this->lang->line('Total'));
    } else echo "Total"; ?> <span class="right"><?php echo $currencySymbol;
            echo number_format($net_total_string,2); ?></span></div>
<?php
    //echo form_input(array('type' => 'hidden', 'id' => 'bookingtot_str', 'value' => $net_total_value));
    echo form_input(array('type' => 'hidden', 'id' => 'bookingtot_str', 'value' => $net_total_string));
    echo form_input(array('type' => 'hidden', 'id' => 'bookingtot', 'value' => $net_total_value));
    //echo form_input(array('type' => 'hidden', 'id' => 'subTotal', 'value' => $subTotal));
    echo form_input(array('type' => 'hidden', 'id' => 'subTotal', 'value' => $total_value));
    echo form_input(array('type' => 'hidden', 'id' => 'prd_price', 'value' => $prd_price));
    echo form_input(array('type' => 'hidden', 'id' => 'stax', 'value' => $taxString));
    echo form_input(array('type' => 'hidden', 'id' => 'total_nights', 'value' => $total_nights));
    echo form_input(array('type' => 'hidden', 'id' => 'secDeposit', 'value' => $securityDeposite_string));
    echo form_input(array('type' => 'hidden', 'id' => 'currencycode', 'value' => $currencycd));
    echo form_input(array('type' => 'hidden', 'id' => 'use_wallet_str', 'value' => ''));
    echo form_input(array('type' => 'hidden', 'id' => 'use_wallet', 'value' => ''));
    echo form_input(array('type' => 'hidden', 'id' => 'base_subtotal', 'value' => $base_subtotal));
    echo form_input(array('type' => 'hidden', 'id' => 'base_taxValue', 'value' => $base_taxValue));
    echo form_input(array('type' => 'hidden', 'id' => 'base_securityDeposite', 'value' => $base_securityDeposite));
?>
