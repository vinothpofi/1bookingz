<?php$this->load->view('admin/templates/header.php');?>    <div id="content">        <div class="grid_container">            <div class="grid_12">                <div class="widget_wrap">                    <div class="widget_top">                        <span class="h_icon list"></span>                        <h6><?php echo $heading; ?></h6>                    </div>                    <div class="widget_content">                        <?php                        $attributes = array('class' => 'form_container left_label', 'id' => 'add_vendor_payment_form');                        echo form_open_multipart('admin/commission/add_vendor_payment_manual', $attributes)                        ?>                        <ul>                            <?php                            echo form_input(array(                                'type' => 'hidden',                                'name' => 'hostEmail',                                'value' => $hostEmail                            ));                            ?>                            <li>                                <div class="form_grid_12">                                    <?php                                    $commonclass = array('class' => 'field_title');                                    echo form_label('Transaction Id <span class="req">*</span>', 'transaction_id', $commonclass);                                    ?>                                    <div class="form_input">                                        <?php                                        echo form_input(array(                                            'type' => 'text',                                            'name' => 'transaction_id',                                            'id' => 'transaction_id',                                            'tabindex' => '1',                                            'class' => 'required tipTop large',                                            'title' => 'Please enter the transaction id'                                        ));                                        ?>                                    </div>                                </div>                            </li>                            <li>                                <div class="form_grid_12">                                    <?php                                    echo form_label('Amount<span class="req">*</span>', 'amount', $commonclass);                                    ?>                                    <div class="form_input">                                        <?php                                        echo form_input(array(                                            'type' => 'text',                                            'name' => 'amount',                                            'tabindex' => '3',                                            'readonly' => 'readonly',                                            'class' => 'required number large tipTop',                                            'title' => 'Please enter the amount',                                            'value' => number_format($payableAmount, 2, '.', '')                                        ));                                        ?>                                        <span class="input_instruction green">Balance amount is <?php echo $admin_currency_symbol . number_format($payableAmount, 2, '.', ''); ?></span>                                    </div>                                </div>                            </li>                            <li>                                <?php                                echo form_input(array(                                    'type' => 'hidden',                                    'name' => 'balance_due',                                    'value' => $hostEmail                                ));                                ?>                                <div class="form_grid_12">                                    <div class="form_input">                                        <?php                                        echo form_input(array(                                            'type' => 'submit',                                            'class' => 'btn_small btn_blue',                                            'value' => 'ADD PAYMENT',                                            'tabindex' => '4'                                        ));                                        ?>                                        <a href="<?php echo base_url() . "admin/commission/display_commission_tracking_lists"; ?>">                                            <button type="button" class="btn_small btn_blue" tabindex="4">                                                <span>Cancel</span></button>                                        </a>                                    </div>                                </div>                            </li>                        </ul>                        <?php echo form_close(); ?>                    </div>                </div>            </div>        </div>        <span class="clear"></span>    </div>    </div>    <!-- script for form validation -->    <script type="text/javascript">        $('#add_vendor_payment_form').validate();    </script><?php$this->load->view('admin/templates/footer.php');?>