<?php
$this->load->view('admin/templates/header.php');
?>
<div id="content">
    <div class="grid_container">
        <div class="grid_12">
            <div class="widget_wrap">
                <div class="widget_top">
                    <span class="h_icon list"></span>
                    <h6><?php echo $heading; ?></h6>
                </div>
                <div class="widget_content">
                    <?php
                    $attributes = array('class' => 'form_container left_label', 'id' => 'regitstraion_form', 'accept-charset' => 'UTF-8');
                    echo form_open('admin/adminlogin/save_smtp_settings', $attributes)
                    ?>
                    <ul>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Protocol', 'smtp_protocol', array('class' => 'field_title'));
                                ?>
                                <div class="form_input">
                                    <?php
                                    $protocolattr = array(
                                        'name' => 'protocol',
                                        'id' => 'smtp_protocol',
                                        'tabindex' => '1',
                                        'class' => 'large tipTop',
                                        'title' => 'Please enter the smtp host',
                                        'value' => $this->config->item('protocol')
                                    );
                                    echo form_input($protocolattr);
                                    echo form_label('Special Characters are not allowed!', '', array('class' => 'error', 'id' => 'smtp_protocol_error', 'style' => 'display:none;'));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('SMTP Host', 'smtp_host', array('class' => 'field_title'));
                                ?>
                                <div class="form_input">
                                    <?php
                                    $smtpattr = array(
                                        'name' => 'smtp_host',
                                        'id' => 'smtp_host',
                                        'tabindex' => '1',
                                        'class' => 'large tipTop',
                                        'title' => 'Please enter the smtp host',
                                        'value' =>$this->config->item('smtp_host')
                                    );
                                    echo form_input($smtpattr);
                                    echo form_label('Special Characters are not allowed!', '', array('class' => 'error', 'id' => 'smtp_host_error', 'style' => 'display:none;'));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('SMTP Port', 'smtp_port', array('class' => 'field_title'));
                                ?>
                                <div class="form_input">
                                    <?php
                                    $smtpportattr = array(
                                        'name' => 'smtp_port',
                                        'id' => 'smtp_port',
                                        'tabindex' => '1',
                                        'class' => 'large tipTop',
                                        'title' => 'Please enter the smtp port',
                                        'value' => $this->config->item('smtp_port')
                                    );
                                    echo form_input($smtpportattr);
                                    echo form_label('Special Characters are not allowed!', '', array('class' => 'error', 'id' => 'smtp_port_error', 'style' => 'display:none;'));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('SMTP Email', 'smtp_email', array('class' => 'field_title'));
                                ?>
                                <div class="form_input">
                                    <?php
                                    echo form_input(array(
                                        'type' => 'email',
                                        'name' => 'smtp_user',
                                        'id' => 'smtp_user',
                                        'tabindex' => '1',
                                        'class' => 'large tipTop',
                                        'title' => 'Please enter the smtp email id',
                                        'value' => $this->config->item('smtp_user')
                                    ));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('SMTP Password', 'smtp_pass', array('class' => 'field_title'));
                                ?>
                                <div class="form_input">
                                    <?php
                                    $smtpportattr = array(
                                        'name' => 'smtp_pass',
                                        'id' => 'smtp_pass',
                                        'tabindex' => '1',
                                        'class' => 'large tipTop',
                                        'title' => 'Please enter the smtp password',
                                        'value' => $this->config->item('smtp_pass')
                                    );
                                    echo form_password($smtpportattr);
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <div class="form_input">
                                    <?php
                                    if($site_status_val == 1){
                                    $smtpportattr = array(
                                        'class' => 'btn_small btn_blue',
                                        'value' => 'Save'
                                    );
                                    echo form_submit($smtpportattr);
                                    }elseif($site_status_val == 2){
                                    ?>
                                    <button type="button" class="btn_small btn_blue" onclick="alert('Cannot Submit on Demo Mode')">Save</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <?php form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <span class="clear"></span>
</div>
</div>
<?php
$this->load->view('admin/templates/footer.php');
?>
<!-- Script to validate inputs -->
<script>
    $("#smtp_protocol").on('keyup', function (e) {
        var val = $(this).val();
        if (val.match(/[^a-zA-Z.:,-\s/]/g)) {
            document.getElementById("smtp_protocol_error").style.display = "inline";
            $("#smtp_protocol_error").fadeOut(5000);
            $(this).val(val.replace(/[^a-zA-Z.:,-\s/]/g, ''));
        }
    });

   /* $("#smtp_host").on('keyup', function (e) {
        var val = $(this).val();
        if (val.match(/[^a-zA-Z.:,-\s/]/g)) {
            document.getElementById("smtp_host_error").style.display = "inline";
            $("#smtp_host_error").fadeOut(5000);
            $(this).val(val.replace(/[^a-zA-Z.:,-\s/]/g, ''));
        }
    });*/

    $("#smtp_port").on('keyup', function (e) {
        var val = $(this).val();
        if (val.match(/[^0-9-.\s]/g)) {
            document.getElementById("smtp_port_error").style.display = "inline";
            $("#smtp_port_error").fadeOut(5000);
            $(this).val(val.replace(/[^0-9-.\s]/g, ''));
        }
    });
</script>
