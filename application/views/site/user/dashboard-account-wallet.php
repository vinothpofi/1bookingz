<?php
$this->load->view('site/includes/header');
$currency_result = $this->session->userdata('currency_result');
?>
    <section class="dashboard-sec">
        <div class="container">
            <div class="loggedIn clear">
            <div class="row">
            <?php $this->load->view('site/includes/top_navigation_links'); ?>

                
                <div class="col-sm-12 col-md-9 col-lg-9 dashboard-right">
                    <?php
                    echo form_open('account-setting', array('onsubmit' => 'return validatePassword();'));
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading"><?php if ($this->lang->line('your_wallet') != '') {
                                echo stripslashes($this->lang->line('your_wallet'));
                            } else echo "Your Wallet"; ?></div>
                        <div class="panel-body">
                            <p class="text-danger text-center"
                               id="ErrorMsg"><?php echo $this->session->flashdata('errorMsg'); ?></p>
                            <p class="text-success text-center"><?php echo $this->session->flashdata('successMsg'); ?></p>
                            <?php
                            if ($userDetail->row()->totalReferalAmount > 0) {
                                if ($wallet_usage->row()->usedWallet != null) {
                                    $usedWallet = $wallet_usage->row()->usedWallet;
                                    $usedCurrency = $wallet_usage->row()->currency_code;
                                } else{
                                        $GetusedCurrency= $this->db->where('user_id', $userDetail->row()->id)->get(PAYMENT)->row();
                                        $usedCurrency=$GetusedCurrency->currency_code;
                                        $usedWallet = "0.00";
                                }
                                ?>
                                <table class="table table-bordered table-striped">
                                    <tr>
                                        <th><?php if ($this->lang->line('user') != '') {
                                                echo stripslashes($this->lang->line('user'));
                                            } else echo "User"; ?></th>
                                        <th><?php if ($this->lang->line('total_wallet_amount') != '') {
                                                echo stripslashes($this->lang->line('total_wallet_amount'));
                                            } else echo "Total Wallet Amount"; ?></th>
                                       
                                             <th><?php if ($this->lang->line('used_from_wallet') != '') {
                                                echo stripslashes($this->lang->line('used_from_wallet'));
                                            } else echo "Used from Wallet"; ?></th>
                                            
                                             <th><?php if ($this->lang->line('balance_in_wallet') != '') {
                                                echo stripslashes($this->lang->line('balance_in_wallet'));
                                            } else echo "Balance in Wallet"; ?></th>
                                            
                                    </tr>
                                    <tr>
                                        <td><?php echo $userDetail->row()->firstname . ' ' . $userDetail->row()->lastname; ?></td>
                                        <td>
                                            <?php
                                            $currency = $userDetail->row()->referalAmount_currency;
                                           // echo ' ' . number_format($price, 2);
                                            echo $currencySymbol;
                                            if ($currency != $this->session->userdata('currency_type')) {
                                                if ($currency_result->$currency) {
                                                    $cnt_referalAmnt = $userDetail->row()->totalReferalAmount / $currency_result->$currency;
                                                } else {
                                 $cnt_referalAmnt = currency_conversion($currency, $this->session->userdata('currency_type'), $userDetail->row()->totalReferalAmount);
                                                }
                                                echo ' ' . number_format($cnt_referalAmnt, 2);
                                            } else {
                                                echo $cnt_referalAmnt = $userDetail->row()->totalReferalAmount;
                                            }
                                            echo ' ' . number_format($this->session->userdata('currency_type'), 2); ?>
                                            
                                            
                                        </td>
                                        
                                        
                                         <td>
                                             <?php 
                                             $usedWallet = $wallet_used_amnt;
                                             echo $currencySymbol;
                                            if ('USD' != $this->session->userdata('currency_type')) {
                                                   $cnt_usedWallet =  currency_conversion('USD', $this->session->userdata('currency_type'), $usedWallet);
                         echo $cnt_usedWallet;
                                                   
                                            } else {
                        $cnt_usedWallet=$usedWallet;
                        echo $cnt_usedWallet;
                                            }
                                            echo ' ' . $this->session->userdata('currency_type'); 
                        ?>
                                        </td>
                                        
                                           <td>
                                                <?php 
          //                                       echo $currencySymbol . ' ';
             //                                    $balence_in=$cnt_referalAmnt - $cnt_usedWallet;
                            // echo ' ' . number_format($balence_in, 2);
             //                                    echo ' ' . $this->session->userdata('currency_type');
                                                ?>
                                                 <?php echo $currencySymbol;
                                            if ('USD' != $this->session->userdata('currency_type')) {
                                                   $bal_dWallet =  currency_conversion($usedCurrency, $this->session->userdata('currency_type'), $userDetail->row()->referalAmount);
                         echo $bal_dWallet;
                                                   
                                            } else {
                       $bal_dWallet = $userDetail->row()->referalAmount;
                        echo $bal_dWallet;
                                            }
                                            echo ' ' . $this->session->userdata('currency_type'); 
                        ?>
                                            </td>
                                    </tr>
                                </table>
                            <?php } else { ?>

                                <p class="text-center text-danger"><?php if ($this->lang->line('wallet_empty_message') != '') {
                                    echo stripslashes($this->lang->line('wallet_empty_message'));
                                } else echo "Your wallet Empty. Use invite friends for credit your wallet."; ?>

                                </p><?php } ?>
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