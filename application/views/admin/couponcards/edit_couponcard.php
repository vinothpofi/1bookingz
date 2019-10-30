<?php
$this->load->view('admin/templates/header.php');
?>

<style type="text/css">
    .hide-date {
        pointer-events: none;
        color: #ddd;
    }
</style>
<script language="javascript">
    function coupon_proudct(val) {
        if (val == 'category') {
            document.getElementById('shipping').style.display = 'block';
            document.getElementById('category').style.display = 'block';
            document.getElementById('product').style.display = 'none';
        }
        else if (val == 'product') {
            document.getElementById('shipping').style.display = 'block';
            document.getElementById('category').style.display = 'none';
            document.getElementById('product').style.display = 'block';
        }
        else if (val == 'shipping') {
            document.getElementById('shipping').style.display = 'none';
            document.getElementById('category').style.display = 'none';
            document.getElementById('product').style.display = 'none';
        }
        else {
            document.getElementById('shipping').style.display = 'block';
            if(document.getElementById('category')!=null && document.getElementById('product')!=null) {
                document.getElementById('category').style.display = 'none';
                document.getElementById('product').style.display = 'none';
            }
        }
    }
</script>
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
                    $attributes = array('class' => 'form_container left_label', 'id' => 'edituser_form', 'onsubmit' => 'return validateform();','accept-charset' => 'UTF-8');
                    echo form_open('admin/couponcards/insertEditCouponcard', $attributes)
                    ?>
                    <ul>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                $commonclass = array('class' => 'field_title');
                                echo form_label('Coupon Name <span class="req">*</span>', 'user_name', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'coupon_name',
                                        'id' => 'coupon_name',
                                        'class' => 'tipTop required small',
                                        'tabindex' => '1',
                                        'title' => 'Please Enter the Coupon Name',
                                        'value' => $couponcard_details->row()->coupon_name,
										'readonly' => 'readonly'
                                    ));
                                    ?>
                                    <span id="coupon_name_valid" style="color:#f00;display:none;">Only Characters are allowed!
									</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Coupon code <span class="req">*</span>', 'user_name', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'code',
                                        'id' => 'code',
                                        'class' => 'tipTop required small',
                                        'tabindex' => '2',
                                        'title' => 'Please Enter the Coupon Code',
                                        'value' => $couponcard_details->row()->code,
                                        'readonly' => 'readonly'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Max No. of Coupons <span class="req">*</span>', 'group', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'quantity',
                                        'id' => 'quantity',
                                        'class' => 'tipTop required small',
                                        'tabindex' => '3',
                                        'title' => 'Please Enter max no of coupons applied count from the customer while booking',
                                        'value' => $couponcard_details->row()->quantity,
										'readonly' => 'readonly'
                                    ));
                                    ?>
                                    <span id="quantity_valid" style="color:#f00;display:none;"> 	Only Numbers are allowed!
									</span>
                                </div>
                            </div>
                        </li>

                        <input type="hidden" name="selected_product_ids" value="<?php echo $couponcard_details->row()->product_id; ?>" id="selected_product_ids">
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Coupon Valid From <span class="req">*</span>', 'datefrom', $commonclass);
                                ?>
                                <div class="form_input">

                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'style' => 'width:15%;',
                                        'class'=>'small',
                                        'required'=>'required',
                                        'name' => 'datefrom',
                                        'id' => 'datetimepicker1',
                                        'class'=>'form-control',
                                        'value' => $couponcard_details->row()->datefrom,
                                        'onchange'=>'check_product_coupon_date_exist();'

                                    ));
                                    ?>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Coupon Valid Till <span class="req">*</span>', 'dateto', $commonclass);
                                ?>
                                <div class="form_input">

                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'class'=>'small',
                                        'style' => 'width:15%;',
                                        'name' => 'dateto',
                                        'id' => 'datetimepicker2',
                                        'required'=>'required',
                                        'class'=>'form-control',
                                       // 'onchange'=>'getproduct();',
                                        'value' => $couponcard_details->row()->dateto,
                                        'onchange'=>'check_product_coupon_date_exist();'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Select a Coupon Type <span class="label_intro">Select this field, Coupon will be  applied for product.</span>', '', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    $cpntype = array();
                                    $cpntype = array(
                                        '' => 'None',
                                        'Advertisement' => 'Advertisement',
                                        'Birthday Card' => 'Birthday Card',
                                        'Business Travel' => 'Business Travel',
                                        'Gift Card' => 'Gift Card',
                                        'Promotion' => 'Promotion',
                                        'Staff' => 'Staff'
                                    );
                                    $cpnattr = array(
                                        'data-placeholder' => 'Select a Coupon Type',
                                        'style' => 'width:300px',
                                        'class' => 'chzn-select-deselect',
                                        'tabindex' => '13',
                                        'onchange' => 'coupon_proudct(this.value);'
                                    );
                                    echo form_dropdown('coupon_type', $cpntype, $couponcard_details->row()->coupon_type, $cpnattr);
                                    ?>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul id="shipping" style="display:block;">
					<input type="hidden" name="price_type" value="2" />
                       <?php /* <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Discount Type <span class="req">*</span>', 'full_name', $commonclass);
                                ?>
                                <div class="form_input">
                                    <div class="flat_percentage">
                                        <?php
                                        $pricetype = FALSE;
                                        if ($couponcard_details->row()->price_type == '1') {
                                            $pricetype = TRUE;
                                        }
                                        echo form_checkbox('price_type','1',$pricetype,array('class' => 'Flat_Percentage','tabindex' => '1'));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li> */ ?>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Price Value <span class="req">*</span>', 'user_name', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    echo form_input(array(
                                        'type' => 'text',
                                        'name' => 'price_value',
                                        'id' => 'price_value',
                                        'tabindex' => '2',
                                        'title' => 'Please enter the price value',
                                        'class' => 'required small tipTop',
                                        'value' => $couponcard_details->row()->price_value,
										'readonly' => 'readonly'
										
                                    )).'%';
                                    ?>
                                    <span
                                            id="price_value_valid" style="color:#f00;display:none;">Only Numbers are allowed!
									</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul>
                        <li>
                            <div class="form_grid_12">
                                <?php
                                echo form_label('Description', 'email', $commonclass);
                                ?>
                                <div class="form_input">
                                    <?php
                                    $descattr = array(
                                        'id' => 'description',
                                        'rows' => 4,
                                        'class' => 'small tipTop',
                                        'tabindex' => '4',
                                        'title' => 'Please enter the description'
                                    );
                                    echo form_textarea('description', $couponcard_details->row()->description, $descattr);
                                    ?>
                                    </br></br>
                                    <small>Maximum 150 words</small>
                                    <br><span class="words-left"> </span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="form_grid_12">
                                <label class="field_title" for="property">Property </label>
                                <div id="property_ajax" class="form_input">
                                    <?php
                                    $selectedProperty = explode(',', $couponcard_details->row()->product_id);
                                    if ($hostDetails->num_rows() > 0) {
                                        ?>
                                        <select name="product_id[]" multiple id="property">
                                            <?php
                                            foreach ($hostDetails->result() as $host) {
                                                $hostid = $host->id;
                                                if ($productDetails[$hostid]->num_rows() > 0) {
                                                    ?>
                                                    <optgroup
                                                            label="<?php echo $host->firstname . ' ' . $host->lastname; ?>">
                                                        <?php
                                                        foreach ($productDetails[$hostid]->result() as $product) {
                                                            ?>
															
                                                            <option
                                                                     value="<?php echo $product->id; ?>" <?php if (in_array($product->id, $selectedProperty)) echo "selected"; ?> ><?php echo $product->product_title . ' ' . $product->city . ',' . $product->state; ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </optgroup>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div style="color:#DE5130;font-weight:600" id="property_error"></div>
                                <div style="color:#DE5130;font-weight:600" id="property_exists_error"></div>
                                <input type="hidden" value="0" id="property_exist_val">
                            </div>
                        </li>
                        <div class="form_grid">
                            <div class="form_input button_class">
                                <?php
                                echo form_input(array(
                                    'type' => 'submit',
                                    'value' => 'Update',
                                    'tabindex' => '4',
                                    'class' => 'btn_small btn_blue'
                                ));
                                ?>
                                <a href="<?php echo base_url() . 'admin/couponcards/display_couponcards'; ?>">
                                    <button type="button" class="btn_small btn_blue" tabindex="4"><span>Back</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                        </li>
                    </ul>
                    <?php
                    echo form_input(array(
                        'type' => 'hidden',
                        'name' => 'coupon_id',
                        'id' => 'coupon_id',
                        'value' => $couponcard_details->row()->id
                    ));
                    echo form_close();
                    ?>
                </div>
            </div>
        </div>
    </div>
    <span class="clear"></span>
</div>
</div>
<script type="text/javascript">
    $('#edituser_form').validate();

</script>
<link href="<?php echo base_url(); ?>js/multipleSelect/jquery.multiselect.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url(); ?>js/multipleSelect/jquery.multiselect.js"></script>
<script>
    $('#property').multiselect({
        columns: 4,
        placeholder: 'Select Property',
        search: true,
        selectAll: true
    });
</script>
<style>
    body {
        font-family: 'Open Sans' Arial, Helvetica, sans-serif
    }

    ul, li {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .label {
        color: #000;
        font-size: 16px;
    }

    .ms-options {
        position: relative !important;
    }
</style>
<?php
$this->load->view('admin/templates/footer.php');
?>
<script>
    $("#quantity").on('keyup', function (e) {
        var val = $(this).val();
        if (val.match(/[^0-9\s]/g)) {
            document.getElementById("quantity_valid").style.display = "inline";
            $("#quantity").focus();
            $("#quantity_valid").fadeOut(5000);
            $(this).val(val.replace(/[^0-9\s]/g, ''));
        }
    });
    $("#price_value").on('keyup', function (e) {
        var val = $(this).val();
        if (val.match(/[^0-9.\s]/g)) {
            document.getElementById("price_value_valid").style.display = "inline";
            $("#price_value").focus();
            $("#price_value_valid").fadeOut(5000);
            $(this).val(val.replace(/[^0-9.\s]/g, ''));
        }
    });
</script>
<script type="text/javascript">
    var wordLen = 150,
        len;
    $('#description').keydown(function (event) {
        len = $('#description').val().split(/[\s]+/);
        if (len.length > wordLen) {
            if (event.keyCode == 46 || event.keyCode == 8) {
                /*Allow backspace and delete buttons*/
            }
            else if (event.keyCode < 48 || event.keyCode > 57) {
                /*all other buttons*/
                event.preventDefault();
            }
        }
        wordsLeft = (wordLen) - len.length;
        if (wordsLeft == 0) {
            $('.words-left').html('You Can not Type More then 150 Words...!');
        }
    });

    function validateform(){

        var todate = $('#datetimepicker2').val();
        if(todate == ''){
            $('#tilldate_error').html('This field was required');
            return false;
        }else{
            $('#tilldate_error').html(' ');
        }
        var property = $('#property').val();
        var property_exist_val = $('#property_exist_val').val();
        if(property === null){
            $('#property_error').html('This field was required');
            return false;
        }else{
            $('#property_error').html(' ');
        }

        if(parseInt(property_exist_val)==1){
            return false;
        }else{
            $('#property_exists_error').html('');
        }

    }
    var start_date = '<?php echo $couponcard_details->row()->datefrom;?>';
    var end_date = '<?php echo $couponcard_details->row()->dateto;?>';
    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    var tomorow = new Date(date.getFullYear(), date.getMonth(), (date.getDate()+1));
    $(function() {
        $( "#datetimepicker1" ).datepicker({
            defaultDate: "+1w",
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            numberOfMonths: 1,
            minDate: start_date,
           // maxDate: end_date,
            onClose: function( selectedDate ) {
                $( "#datetimepicker2" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#datetimepicker2" ).datepicker({
            defaultDate: "+1w",
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            numberOfMonths: 1,
            minDate: tomorow,
            //maxDate: end_date,
            onClose: function( selectedDate ) {
                $( "#datetimepicker1" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
    //$('#adduser_form').validate();

    function check_product_coupon_date_exist(){
        //alert();
        var datefrom = $('#datetimepicker1').val();
        var todate = $('#datetimepicker2').val();
        var selected_product_ids = $('#selected_product_ids').val();
        var coupon_id = $('#coupon_id').val();

        if(datefrom!=''){

            $.post("<?php echo base_url();?>admin/couponcards/check_product_coupon_date_exist",
                {
                    datefrom : datefrom,
                    todate : todate,
                    selected_product_ids : selected_product_ids,
                    coupon_id : coupon_id
                },
                function (data){
                if(data.trim()!=''){
                    $('#property_exists_error').html(data);
                    $('#property_exist_val').val(1);
                }else{
                    $('#property_exists_error').html('');
                    $('#property_exist_val').val(0);
                }
                });
        }
    }
</script>

