<?php
    $this->load->view('site/includes/header');
?>
<div class="manage_items">
    <?php
        $this->load->view('site/includes/listing_head_side');
    ?>
     <div class="centeredBlock">
        <div class="content">
            <p>
                <?php if ($this->lang->line('Pleaseselectyour') != '') {
                    echo stripslashes($this->lang->line('Pleaseselectyour'));
                } else echo "Please select your cancellation policy. You can read more about the cancellation policy"; ?>
                <a target="_blank"
                   href="<?php echo base_url().'pages/' . $cancellation_policy->row()->seourl; ?>"><?php if ($this->lang->line('here') != '') {
                        echo stripslashes($this->lang->line('here'));
                    } else echo "here"; ?> </a>
            </p>

            <div class="error-display" id="errordisplay" style="text-align: center; display: none;">
                <p class="text center text-danger" id="danger"></p>
                <p class="text center text-success" id="success"></p>
            </div>

            <?php
                echo form_open('insert_cancel_policy/' . $listDetail->row()->id, array('id' => 'contact_form','onsubmit'=>'loader();'));
            ?>

            <div class="form-group">
                <p><?php if ($this->lang->line('CancellationPolicy') != '') {
                        echo stripslashes($this->lang->line('CancellationPolicy'));
                    } else echo "Cancellation Policy"; ?><span class="impt">*</span>
                </p>
                <?php
				
                    $js = array('required' => 'required','id'=>'cancellation_policy', 'onChange' => "javascript:Detailview(this, " . $listDetail->row()->id . ",'cancellation_policy'),show_val(this);");
                    echo form_dropdown('cancellation_policy', $policy_type, $listDetail->row()->cancellation_policy, $js);
                ?>
            </div>

            <div class="form-group">
                <p>
                    <?php if ($this->lang->line('return_amount_property') != '') {
                        echo stripslashes($this->lang->line('return_amount_property'));
                    } else echo "Return Amount"; ?><span class="impt">*</span>
                </p>
                <?php
                    $disabled='FALSE';
                    if($listDetail->row()->cancellation_policy!='Flexible'){
                        $disabled='TRUE';
                    }
                    $retamntattr = array('name' => 'return_amount', 'id' => 'return_amount', 'value' => $listDetail->row()->cancel_percentage, 'onkeypress' => 'return check_for_num(event)', 'onchange' => "javascript:Detailview(this, " . $listDetail->row()->id . ",'cancel_percentage')", 'placeholder' => 'Enter your return amount', 'maxlength' => '2', 'required' => 'required','readonly'=>$disabled);
                    echo form_input($retamntattr); /*echo "<span >%</span>";*/
                ?>%
            </div>

            <div class="form-group">
                <p>
                    <?php if ($this->lang->line('description_can_property') != '') {
                        echo stripslashes($this->lang->line('description_can_property'));
                    } else echo "Description"; ?><span class="impt">*</span>
                </p>
				
				
				<?php if ($this->lang->line('enter_desc_canpolicy') != '') {
                        $en_desc= stripslashes($this->lang->line('enter_desc_canpolicy'));
                    } else $en_desc= "Enter your description"; ?>
				
                <?php
                    $descattr = array('name' => 'cancel_description', 'id' => 'cancel_description', 'value' => $listDetail->row()->cancel_description, 'placeholder' => "$en_desc", 'required' => 'required', 'rows' => '3');
                    echo form_textarea($descattr);
                ?>

           
                <!--Language dynamic-->
                <?php  foreach(language_dynamic_enable("cancel_description","") as $dynlang) {  ?>

                    <p>
                        <?php if ($this->lang->line('description_can_property') != '') {
                            echo stripslashes($this->lang->line('description_can_property'));
                        } else echo "Description"; ?> (<?php echo $dynlang[0];?>)<span class="impt">*</span>
                    </p>
                    <?php if ($this->lang->line('enter_desc_canpolicy') != '') {
                        $en_desc= stripslashes($this->lang->line('enter_desc_canpolicy'));
                    } else $en_desc= "Enter your description"; ?>

                    <?php
                    $descattr_ar = array('name' => $dynlang[1], 'id' => $dynlang[1], 'value' => $listDetail->row()->{$dynlang[1]}, 'onchange' => "javascript:Detailview(this, " . $listDetail->row()->id . ",'".$dynlang[1]."')", 'placeholder' => "$en_desc", 'required' => 'required', 'rows' => '3');
                    echo form_textarea($descattr_ar);
                    ?>


                <?php } ?>
                <!--End Language dynamic-->
            </div>

            <p>
                <?php if ($this->lang->line('SecurityDeposit') != '') {
                    echo stripslashes($this->lang->line('SecurityDeposit'));
                } else echo "Security Deposit"; ?>
            </p>
            <div class="currencyTxt form-group">
                <?php
                    $secdepattr = array('name' => 'security_deposit', 'id' => 'price', 'value' => $listDetail->row()->security_deposit, 'onkeypress' => 'return check_for_num(event)', 'maxlength' => '5');
                    echo form_input($secdepattr);                 ?>
					<?php if($listDetail->row()->currency != ''){
						$currency_type=$listDetail->row()->currency;
						$currency_symbol_query='SELECT * FROM '.CURRENCY.' WHERE currency_type="'.$currency_type.'"';
						$currency_symbol=$this->product_model->ExecuteQuery($currency_symbol_query);
						if($currency_symbol->num_rows() > 0)
						{
							$currency_sym = $currency_symbol->row()->currency_symbols;
						}
						else{
							$currency_sym = '$';
						}
								?>
								<span><?php echo $currency_sym; ?></span><?php } else {  ?><span>$</span><?php } ?>
            </div>
			<?php if ($listDetail->row()->meta_title == "" && $listDetail->row()->meta_keyword == "" && $listDetail->row()->meta_description == "") { ?>
				<div class="form-group" id="ShowSeo">
					<div class="col-md-12">
						<p><?php if ($this->lang->line('Want to add SEO tags') != '') {
								echo stripslashes($this->lang->line('Want to add SEO tags'));
							} else echo "Want to add SEO tags"; ?>?&nbsp;<a style="cursor: pointer;"
								onclick="show_block_cate()"><?php if ($this->lang->line('You can add') != '') {
									echo stripslashes($this->lang->line('You can add'));
								} else echo "You can add"; ?></a>.</p>
					</div>
				</div>
				<?php
			}
			?>
			<div id="SEOContainer" class="form-group"
				 <?php if ($listDetail->row()->meta_title == "" && $listDetail->row()->meta_keyword == "" && $listDetail->row()->meta_description == ""){ ?>style="display: none;"<?php } ?>>
				<div class="col-md-12">
	
					<h5 class="text-capitalize text-center"><?php if ($this->lang->line('seo_det') != '') {
									echo stripslashes($this->lang->line('seo_det'));
								} else echo "SEO Details"; ?></h5>
				</div>
				<div class="col-md-12">
					<p><?php if ($this->lang->line('Meta Title') != '') {
                            echo stripslashes($this->lang->line('Meta Title'));
                        } else echo "Meta Title"; ?></p>
                    <?= form_input('meta_title', $listDetail->row()->meta_title, array('id' => 'meta_title', 'placeholder' => ($this->lang->line('Meta Title') != '') ? stripslashes($this->lang->line('Meta Title')) : "Meta Title", 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_title');")); ?>
               
				</div>
				<div class="col-md-12">
					<p><?php if ($this->lang->line('keywords') != '') {
                            echo stripslashes($this->lang->line('keywords'));
                        } else echo "keywords"; ?></p>
                        
                        
                        <?php if ($this->lang->line('keywords') != '') {
                            $keywrds= stripslashes($this->lang->line('keywords'));
                        } else $keywrds= "keywords"; ?>
                        
                    <?= form_textarea('meta_keyword', $listDetail->row()->meta_keyword, array('id' => 'meta_keyword', 'placeholder' => "$keywrds", 'onkeyup' => 'char_count(this)', 'maxlength' => 150, 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_keyword');")); ?>
                    <p class="text-danger">
                        <?php
                        $string = str_replace(' ', '', $listDetail->row()->meta_keyword);
                        $len = mb_strlen($string, 'utf8');
                        $remaining = (150 - $len);
                        ?>
                        <span id="meta_keyword_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                            echo stripslashes($this->lang->line('exp_characters_remaining'));
                        } else echo "characters remaining"; ?></p>
       
				</div>
				<div class="col-md-12">
					<p><?php if ($this->lang->line('MetaDescription') != '') {
                            echo stripslashes($this->lang->line('MetaDescription'));
                        } else echo "Meta Description"; ?></p>
                    <?= form_textarea('meta_description', $listDetail->row()->meta_description, array('id' => 'meta_description', 'placeholder' => ($this->lang->line('MetaDescription') != '') ? stripslashes($this->lang->line('MetaDescription')) : "Meta Description", 'onkeyup' => 'char_count(this)', 'maxlength' => 150, 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_description');")); ?>
                    <p class="text-danger">
                        <?php
                        $string = str_replace(' ', '', $listDetail->row()->meta_description);
                        $len = mb_strlen($string, 'utf8');
                        $remaining = (150 - $len);
                        ?>
                        <span id="meta_description_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                            echo stripslashes($this->lang->line('exp_characters_remaining'));
                        } else echo "characters remaining"; ?></p>
                
				</div>

                  <?php
                                $dyn_lan=language_dynamic_enable_for_fields();

                                //print_r($dyn_lan);

                                if(!empty($dyn_lan)){
                                    foreach ($dyn_lan as $key=>$data){
                                        ?>
    <div class="col-md-12">
                    <p><?php if ($this->lang->line('Meta Title') != '') {
                            echo stripslashes($this->lang->line('Meta Title'))."(".$data->name.")";
                        } else echo "Meta Title (".$data->name.")"; ?></p>
                    <?= form_input('meta_title_'.$data->lang_code, $listDetail->row()->{'meta_title_'.$data->lang_code}, array('id' => 'meta_title_'.$data->lang_code, 'placeholder' => ($this->lang->line('Meta Title') != '') ? stripslashes($this->lang->line('Meta Title'))."(".$data->name.")" : "Meta Title(".$data->name.")", 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_title_$data->lang_code');")); ?>
               
                </div>

                                        <div class="col-md-12">
                    <p><?php if ($this->lang->line('keywords') != '') {
                            echo stripslashes($this->lang->line('keywords'))."(".$data->name.")";
                        } else echo "keywords (".$data->name.")"; ?></p>
                        
                        
                       
                        
                    <?= form_textarea('meta_keyword_'.$data->lang_code, $listDetail->row()->{'meta_keyword_'.$data->lang_code}, array('id' => 'meta_keyword_'.$data->lang_code, 'placeholder' => "$keywrds", 'onkeyup' => 'char_count(this)', 'maxlength' => 150, 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_keyword_$data->lang_code');")); ?>
                    <p class="text-danger">
                        <?php
                        $string = str_replace(' ', '', $listDetail->row()->{'meta_keyword_'.$data->lang_code});
                        $len = mb_strlen($string, 'utf8');
                        $remaining = (150 - $len);
                        ?>
                        <span id="meta_keyword_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                            echo stripslashes($this->lang->line('exp_characters_remaining'));
                        } else echo "characters remaining"; ?></p>
       
                </div>

                                            <div class="col-md-12">
                    <p><?php if ($this->lang->line('MetaDescription') != '') {
                            echo stripslashes($this->lang->line('MetaDescription'))."(".$data->name.")";
                        } else echo "Meta Description (".$data->name.")"; ?></p>
                    <?= form_textarea('meta_description_'.$data->lang_code, $listDetail->row()->{'meta_description_'.$data->lang_code}, array('id' => 'meta_description_'.$data->lang_code, 'placeholder' => ($this->lang->line('MetaDescription') != '') ? stripslashes($this->lang->line('MetaDescription'))."(".$data->name.")" : "Meta Description(".$data->name.")", 'onkeyup' => 'char_count(this)', 'maxlength' => 150, 'onchange' => "javascript:Detailview(this," . $listDetail->row()->id . ",'meta_description_$data->lang_code');")); ?>
                    <p class="text-danger">
                        <?php
                        $string = str_replace(' ', '', $listDetail->row()->meta_description);
                        $len = mb_strlen($string, 'utf8');
                        $remaining = (150 - $len);
                        ?>
                        <span id="meta_description_char_count"><?= $remaining; ?></span> <?php if ($this->lang->line('exp_characters_remaining') != '') {
                            echo stripslashes($this->lang->line('exp_characters_remaining'));
                        } else echo "characters remaining"; ?></p>
                
                </div>

                                    <?php }} ?>
			</div>
            <div class="clear text-right">
			
			<?php if ($this->lang->line('Save') != '') {
							$save= stripslashes($this->lang->line('Save'));
						} else $save= "Save"; ?>
			
                <?php
                    $Save = array('id' => 'Save', 'class' => 'submitBtn1', 'onClick' => 'checkSelect();');
                    echo form_submit('list_submit', "$save", $Save);
                ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>

    <div class="rightBlock">
        <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
            <?php if ($this->lang->line('Cancellation') != '') {
                echo stripslashes($this->lang->line('Cancellation'));
            } else echo "Cancellation"; ?>
        </h2>
        <!-- <p>
            <?php if ($this->lang->line('It will only be shared with guests after a reservation is confirmed') != '') {
                echo stripslashes($this->lang->line('It will only be shared with guests after a reservation is confirmed'));
            } else echo "It will only be shared with guests after a reservation is confirmed"; ?>.
        </p> -->
        <p>
            <?php if ($this->lang->line('cancellation1_there_can_be') != '') {
                echo stripslashes($this->lang->line('cancellation1_there_can_be'));
            } else echo "There can be always a change in plans. Help the guests by providing cancelation policy which can help the guests to cancel or modify the bookings."; ?>
        </p> 
        <p>
            <?php if ($this->lang->line('cancellation2_cancel_policy') != '') {
                echo stripslashes($this->lang->line('cancellation2_cancel_policy'));
            } else echo "Cancellation Policy are of three types. Choose the one which will best suit you:"; ?>
        </p> 
        <p><b> <?php if ($this->lang->line('Flexible') != '') {
                echo stripslashes($this->lang->line('Flexible'));
            } else echo "Flexible"; ?></b></p>
        <p>
            <?php if ($this->lang->line('cancellation3_flexible') != '') {
                echo stripslashes($this->lang->line('cancellation3_flexible'));
            } else echo "The percentage of the amount refunded to guests after some basic deductions. In flexible cancellation, the host can set any cancellation percentage. It could be a 10% or 20% or any percentage of cancellation charges."; ?>.
        </p><p><b> <?php if ($this->lang->line('Strict') != '') {
                echo stripslashes($this->lang->line('Strict'));
            } else echo "Strict"; ?></b></p>
        <p>
            <?php if ($this->lang->line('cancellation4_strict') != '') {
                echo stripslashes($this->lang->line('cancellation4_strict'));
            } else echo "99% refund policy fixed by admin, who will refund only 1% after deducting 99% of the amount. Only the security deposit will be refunded in full to the guests."; ?>
        </p>
        <p><b> <?php if ($this->lang->line('Moderate') != '') {
                echo stripslashes($this->lang->line('Moderate'));
            } else echo "Moderate"; ?></b></p>
        <p>
            <?php if ($this->lang->line('cancellation5_moderate') != '') {
                echo stripslashes($this->lang->line('cancellation5_moderate'));
            } else echo " 50% refund amount to the guests. 50% of the subtotal amount along with the security deposit."; ?>
        </p>
        <p><b> <?php if ($this->lang->line('SEO') != '') {
                echo stripslashes($this->lang->line('SEO'));
            } else echo "SEO"; ?></b></p>
        <p>
            <?php if ($this->lang->line('cancellation6_SEO') != '') {
                echo stripslashes($this->lang->line('cancellation6_SEO'));
            } else echo "SEO is the Search Engine Optimization. Once you become a host, one might want to increase the traffic of your property."; ?>.
        </p> 
        <p>
            <?php if ($this->lang->line('cancellation6_SEO_give') != '') {
                echo stripslashes($this->lang->line('cancellation6_SEO_give'));
            } else echo "Give the Meta Title and Meta Description to increase the search results in Google page."; ?>
        </p>
    </div>
    <i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
</div>


<script type="text/javascript">

     function check_for_num(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        //alert(charCode);
        if(charCode != '46'){
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
    }
        return true;
    }
	//$('#return_amount').attr('readonly', false);
     if(($('#cancellation_policy').val() == 'Moderate') || ($('#cancellation_policy').val() == 'Strict'))
        {
            $('#return_amount').attr('readonly', true);
        }else{
            $('#return_amount').attr('readonly', false);
        }
	$(document).ready(function(){
		<?php if($listDetail->row()->cancellation_policy==''){ ?>
		$('#cancellation_policy').trigger('change');
		<?php } ?>
	});
    function show_val(cancel_value) {
        if (cancel_value.value == 'Flexible') {
            $('#return_amount').val('0');
            $('#return_amount').attr('readonly', false);
            $('#return_amount').trigger("change");
            $('#return_amount_percentage').show();
            $('#cancel_description').show();
        }
        else if (cancel_value.value == 'Moderate') {
            $('#return_amount').val('50');
            /*update the onchange vaues in trigger concept*/
            $('#return_amount').trigger("change");
            $('#return_amount').attr('readonly', true);
            $('#return_amount_percentage').show();
            $('#cancel_description').show();
        }
        else if (cancel_value.value == 'Strict') {
            $('#return_amount').val('99');
            $('#return_amount').trigger("change");
            $('#return_amount').attr('readonly', true);
            $('#return_amount_percentage').show();
            $('#cancel_description').show();

        }
        else if (cancel_value.value == 'No Refund') {
            $('#return_amount').val('0');
            $('#return_amount').trigger("change");
            $('#return_amount').attr('readonly', 'true');
            $('#return_amount_percentage').show();
            $('#cancel_description').show();
        }
        else {
            $('#return_amount_percentage').hide();
            $('#cancel_description').hide();
        }
    }

</script>

<script>
    $(document).ready(function () {
        $(".number_field").keydown(function (e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    });
	/*Show hide the Seo Option*/
	function show_block_cate() {
		$("#ShowSeo").hide();
		$("#SEOContainer").show();
	}
	/*Character count */
	function char_count(obj) {
		value_str = obj.value.trim();
		var length = value_str.length;
		var maxlength = $(obj).attr('maxlength');
		var id = obj.id;
		var length = maxlength - length;
		$('#' + id + '_char_count').text(length);
	}
</script>
