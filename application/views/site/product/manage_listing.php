<?php
$this->load->view('site/includes/header');
?>
<link rel="stylesheet" href="<?= base_url(); ?>css/datepickk.min.css">
<script src="<?= base_url(); ?>js/datepickk.min.js"></script>
<style>
    #Datepickk .d-week {
        background-color: #484848;
    }

    .btn-success {
        background: #048b90 !important;
    }

    #Datepickk .d-table input + label:before {
        background-color: #1a8e9c;
        color: #fff;
    }

    #Datepickk .d-tables.range:not(.before) input:not(.single):checked + label ~ label:not(.hidden):before {
        background-color: rgba(4, 139, 147, .5);
    }

    #Datepickk .d-tables.range:not(.before) input:not(.single):checked ~ input:checked + label:before {
        background-color: #048ea9;
    }

    #Datepickk .d-table input:disabled + label:after {
        display: none;
    }

    #Datepickk .d-header {
        background-color: #dddddd;
        color: #1b363f;
    }
</style>
<div class="manage_items">
    <div class="toggleMenuD">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
    </div>
    <?php
    $this->load->view('site/includes/listing_head_side');
    ?>
    <div class="centeredBlock m-middle-blk">
        <div class="content">
            <?php if ($this->session->flashdata('sErrMSG')) { ?>
                <!-- <div class="alert alert-success alert-dismissable">
                    <?php echo $this->session->flashdata('sErrMSG') ?>
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                </div> -->
                <?php
            }
            if ($bookedDates->num_rows() > 0) {
                $decodedArr = json_decode($bookedDates->row()->data);
                //echo '<pre>';print_r($decodedArr);
                $dateOnlyArr = array();
                $AvailableArr = array();
                $UnAvailableArr = array();
                foreach ($decodedArr as $key => $value) {
                    // if ($value->status == 'available') {
                    //     array_push($AvailableArr, date('Y,m,d', strtotime("0 month", strtotime($key))));
                    // } elseif ($value->status == 'booked') {
                    //     array_push($dateOnlyArr, date('Y,m,d', strtotime("0 month", strtotime($key))));
                    // } else {
                    //     array_push($UnAvailableArr, date('Y,m,d', strtotime("0 month", strtotime($key))));
                    // }
                                                            if ($value->status == 'available') {
                                                                array_push($AvailableArr, date('Y-m-d', strtotime($key)));
                                                            } elseif ($value->status == 'booked') {
                                                                array_push($dateOnlyArr, date('Y-m-d', strtotime($key)));
                                                            } else {
                                                                array_push($UnAvailableArr, date('Y-m-d', strtotime($key)));
                                                            }
                }
            }
            // echo "<pre>";
            // print_r($UnAvailableArr);
            ?>
            <?php if ($this->lang->line('Whenisyourlisting') != '') {  $calendHead =  stripslashes($this->lang->line('Whenisyourlisting'));  } else  { $calendHead = "When is your listing available?"; }  ?>
            
            <?php
            if ($listDetail->row()->status != 'Publish') {
				if ($listDetail->row()->calendar_checked == '') { ?>
					<script>$(document).ready(function(){ $("#calendar1").attr('checked', true).trigger('click'); });</script>
			<?php } 
                   
			$always = FALSE;
			$sometimes = FALSE;
			if ($listDetail->row()->calendar_checked == 'always') {  $always = TRUE; }
			if ($listDetail->row()->calendar_checked == 'sometimes') { $sometimes = TRUE; }
                }
                ?>
				<fieldset class="form-group">
					<legend><h3><?php echo $calendHead;?></h3></legend>
					<!-- <div class="form-check">
						<label class="form-check-label">
							<?php 
                                 if ($this->lang->line('Fixed price for all seasons') != '') {   $fix = stripslashes($this->lang->line('Fixed price for all seasons'));  } else { $fix = "Fixed price for all seasons"; }
                                 if ($this->lang->line('Seasonal Price') != '') {   $sp = stripslashes($this->lang->line('Seasonal Price'));  } else { $sp = "Seasonal Price"; } 
                            echo form_radio('calander', $listDetail->row()->id, $always, array('onclick' => "CalanderUpdate(this,'always','calendar_checked');",'checked'=>'checked','id'=>'calendar1','class'=>'form-check-input')); 
							if ($this->lang->line('Always') != '') {   echo stripslashes($this->lang->line('Always'));  } else { echo "Always"; } echo ' - <span style="font-size:14px;">' .$fix.'</span>';
							?>
						</label>
					</div> -->
					<!-- <div class="form-check">
						<label class="form-check-label">
						<?php  echo ' ' . form_radio('calander', $listDetail->row()->id, $sometimes, array('class'=>'form-check-input','onclick' => "CalanderUpdate_some(this,'sometimes','calendar_checked');"));
						if ($this->lang->line('Sometimes') != '') {  echo stripslashes($this->lang->line('Sometimes'));  } else { echo "Sometimes"; } echo ' - <span  style="font-size:14px;">'.$sp.'</span>';?>
						</label>
					</div> -->
				</fieldset>
				<?php /* 
                <div id="calander_choosed_radios">
					<?php if ($listDetail->row()->calendar_checked == '') { ?>
					<script>$(document).ready(function(){ $("#calendar1").attr('checked', true).trigger('click'); });</script>
					<?php } ?>
                    <?php
                    $always = FALSE;
                    $sometimes = FALSE;
                    if ($listDetail->row()->calendar_checked == 'always') {
                        $always = TRUE;
                    };
                    if ($listDetail->row()->calendar_checked == 'sometimes') {
                        $sometimes = TRUE;
                    };
                    echo "<label class=''>";
                    echo form_radio('calander', $listDetail->row()->id, $always, array('onclick' => "CalanderUpdate(this,'always','calendar_checked');",'checked'=>'checked','id'=>'calendar1'));
                    if ($this->lang->line('Always') != '') {   echo stripslashes($this->lang->line('Always'));  } else { echo "Always"; } 
                    echo "</label>&nbsp;";
                    echo "<label class=''>";
                   
                    echo "</label>";
                    ?>
                </div> */ ?>
               
            <div id="calander_listing" style="display:<?= ($listDetail->row()->calendar_checked == '')?"none":"block"; ?>;">
                <div id="demoPicker" style="height:600px;width:100%;"></div>
            </div>
			
			<?php
            if ($this->lang->line('nxt_new') != '') {
                $nxt= stripslashes($this->lang->line('nxt_new'));
            }else $nxt="Next";
		
            ?>
            <?php
            echo "<div class='marginTop_2 text-center'>";
            $listspacesubmit = array('id' => 'list_submit', 'class' => 'submitBtn1 pull-right', "onclick" => "inloader();");
            echo form_button('list_submit',"$nxt", $listspacesubmit);
            echo "</div>";
            ?>

        </div>
    </div>
    <div class="rightBlock">
        <h2><i class="fa fa-lightbulb-o" aria-hidden="true"></i>
            <?php
            if ($this->lang->line('Usethecalendarto') != '') {
                echo stripslashes($this->lang->line('Usethecalendarto'));
            } else echo "Use the calendar to";
            ?></h2>
        <p>
            <?php
            if ($this->lang->line('calendar_select_the_dates') != '') {
                echo stripslashes($this->lang->line('calendar_select_the_dates'));
            } else echo "Select the dates your listing Rental Property is available in the calendar along with the price.";
            ?>
        </p>  
        <p>
            <?php
            if ($this->lang->line('calendar2_set_differentpricing') != '') {
                echo stripslashes($this->lang->line('calendar2_set_differentpricing'));
            } else echo "Set different pricing for different dates for your property for occasions, special days, etc.";
            ?>
        </p> 
        <!-- <p>
            <?php
            if ($this->lang->line('Setcustom') != '') {
                echo stripslashes($this->lang->line('Setcustom'));
            } else echo "Fix your available calandar dates for your listed rental properties.";
            ?>
        </p>
        <p>
            <?php
            if ($this->lang->line('Markdates') != '') {
                echo stripslashes($this->lang->line('Markdates'));
            } else echo "set different pricing for seasonal occasions and check your all property reservation at one place.";
            ?>
        </p> -->
        
    </div>
    <i class="fa fa-lightbulb-o toggleNotes" aria-hidden="true"></i>
</div>
<!--Make available and un available dates-->
<div id="DateMaker" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button id="close_btn" type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="signUpIn">
                    <div class="SignupBlock" style="display: block;">
                        <div class="image_box">
                            <p class="text-center text-danger" id="wishlist_warn_cat"></p>
                        </div>
						
                        <h5><?php
						if ($this->lang->line('Start Date') != '') {
							echo stripslashes($this->lang->line('Start Date'));
						} else echo "Start Date";
						?></h5>
                        <div class="image_box">
                            <input type="text" id="StartDate" value="" readonly>
                        </div>
                        <h5><?php
							if ($this->lang->line('End Date') != '') {
								echo stripslashes($this->lang->line('End Date'));
							} else echo "End Date";
							?></h5>
                        <div class="image_box">
                            <input type="text" id="EndDate" value="" readonly>
                            <input type="hidden" id="ProductId" value="<?= $this->uri->segment(2); ?>" readonly>
                        </div>
                        <div class="image_box">
						
                            <h5><?php
							if ($this->lang->line('Status') != '') {
								echo stripslashes($this->lang->line('Status'));
							} else echo "Status";
							?></h5>
							<h4 id="select_err" style="display: none;color: red;"></h4>
                            <select id="status" name="status">
                                <option value="0"> <?php
                            if ($this->lang->line('select') != '') {
                                echo stripslashes($this->lang->line('select'));
                            } else echo "Select";
                            ?></option>
                                <option value="available"> <?php
							if ($this->lang->line('Available') != '') {
								echo stripslashes($this->lang->line('Available'));
							} else echo "Available";
							?></option>
							
                                <option value="booked"> <?php
							if ($this->lang->line('Booked') != '') {
								echo stripslashes($this->lang->line('Booked'));
							} else echo "Booked";
							?></option>
							
							
                                <option value="unavailable"> <?php
							if ($this->lang->line('Un_Available') != '') {
								echo stripslashes($this->lang->line('Un_Available'));
							} else echo "Unavailable";
							?></option>
                            </select>
                        </div>

                        <h5 class="pric"><?php
							if ($this->lang->line('single_price') != '') {
								echo stripslashes($this->lang->line('single_price'));
							} else echo "Price";
							?></h5>
                        <div class="image_box pric" style="display: block;">
                            <h5 id="price_err" style="display: none;color: red;"></h5>
                             <div class="input-group">                                <input required="required" type="text" class="form-control number" value="<?php echo $listDetail->row()->price; ?>" id="Price" placeholder="Enter price">                                <span class="input-group-addon">								<?php if($listDetail->row()->currency != ''){									$currency_type=$listDetail->row()->currency;								?>									<span><?php echo $currency_type; ?></span>								<?php } else { ?>											<span>USD</span>								<?php } ?>								</span>                            </div>                            <p class="text-danger" id="priceError"></p>
                        </div>
                        <div class="image_box">
                            <div class="text-right">
							
                                <button class="btn btn-lg btn-danger" onclick="javascript:ResetChoosedDates();"><?php
							if ($this->lang->line('Reset') != '') {
								echo stripslashes($this->lang->line('Reset'));
							} else echo "Reset";
							?>
                                </button>
                                <button class="btn btn-lg" data-dismiss="modal"><?php
							if ($this->lang->line('Cancel') != '') {
								echo stripslashes($this->lang->line('Cancel'));
							} else echo "Cancel";
							?></button>
							
                                <button class="btn btn-lg btn-success" id="calandar_button" onclick="javascript:SaveAvailableDate_call();"><i id="spins" style="display: none;" class="fa fa-spinner fa-spin"></i><?php
							if ($this->lang->line('Save') != '') {
								echo stripslashes($this->lang->line('Save'));
							} else echo "Save";
							?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function SaveAvailableDate_call(){
         var StartDate = $("#StartDate").val();
         var todaate = '<?php echo date("Y-m-d"); ?>';
         var status = $("#status").val();
         // alert(new Date(StartDate));
         // alert(new Date(todaate));
         if(new Date(StartDate) < new Date(todaate))
         {
            alert('<?php if ($this->lang->line('no_past_dates') != '') {
                echo stripslashes($this->lang->line('no_past_dates'));
            } else {
                echo "Sorry You Cant Modify Past Dates";
            } ?>');
            $( "#close_btn" ).trigger( "click" );
             location.reload();
            return false;
         }
        // return false;
        $('#spins').show();
        $('#calandar_button').prop('disabled', true);
        var price_is = $('#Price').val(); 
        if(price_is == ''){
             $('#calandar_button').prop('disabled', false);
            $('#spins').hide();
            $('#price_err').show();
            $('#price_err').html('<?php if ($this->lang->line('ener_price') != '') {
                echo stripslashes($this->lang->line('ener_price'));
            } else {
                echo "Please Enter Price";
            } ?>');
            location.reload();
            return false;
        }
         else if(price_is <= '0'){
              $('#calandar_button').prop('disabled', false);
            $('#spins').hide();
            $('#price_err').show();
             $('#price_err').html('<?php if ($this->lang->line('zero_not_allowed') != '') {
                echo stripslashes($this->lang->line('zero_not_allowed'));
            } else {
                echo "Zero & Negatives Not Allowed";
            } ?>');
            return false;
         }
         else if(status == '0'){
              $('#calandar_button').prop('disabled', false);
            $('#spins').hide();
            $('#select_err').show();
             $('#select_err').html('<?php if ($this->lang->line('select_status') != '') {
                echo stripslashes($this->lang->line('select_status'));
            } else {
                echo "Select Status";
            } ?>');
            return false;
         }
        else{
            $('#price_err').hide();
             SaveAvailableDate();
        }
       
    }
    var BookedDates = [<?php
        $i = 1;
        if (!empty($dateOnlyArr)) {
            foreach ($dateOnlyArr as $dates) {
                echo 'new Date(' . (strtotime($dates)*1000) . ')';
                echo ($i == count($dateOnlyArr)) ? '' : ',';
                $i++;
            }
        }
        ?>];
    var datepicker = new Datepickk({
        container: document.querySelector('#demoPicker'),
        inline: true,
        range: true,
        disabledDates: BookedDates
    });
    /*Start Creating highlight*/
    var Bookedhighlight = {
        dates: [
            <?php
            $i = 1;
            if (!empty($dateOnlyArr)) {
                foreach ($dateOnlyArr as $dates) {
                    $date='new Date('.(strtotime($dates)*1000).')';
                    echo '{ start: new Date(' . $date . '),end: new Date(' . $date . ')}';
                    echo ($i == count($dateOnlyArr)) ? '' : ',';
                    $i++;
                }
            }
            ?>
        ],
        backgroundColor: '#048b90',
        color: '#ffffff',
        legend: 'Booked'
    };
    var AvailableHighlight = {
        dates: [
            <?php
            $i = 1;
            if (!empty($AvailableArr)) {
                foreach ($AvailableArr as $dates) {
                    $date='new Date('.(strtotime($dates)*1000).')';
                    echo '{ start: new Date(' . $date . '),end: new Date(' . $date . ')}';
                    echo ($i == count($AvailableArr)) ? '' : ',';
                    $i++;
                }
            }
            ?>
        ],
        backgroundColor: '#E99C00',
        color: '#ffffff',
        legend: 'Special Price'
    };
    var UnAvailableHighlight = {
        dates: [
            <?php
            $i = 1;
            if (!empty($UnAvailableArr)) {
                foreach ($UnAvailableArr as $dates) {
                    $date='new Date('.(strtotime($dates)*1000).')';
                    echo '{ start: new Date(' . $date . '),end: new Date(' . $date . ')}';
                    echo ($i == count($UnAvailableArr)) ? '' : ',';
                    $i++;
                }
            }
            ?>
        ],
        backgroundColor: '#ff5a60',
        color: '#ffffff',
        legend: 'Un-Available'
    };
   // alert(JSON.stringify(UnAvailableHighlight));
    /*Close- heighlight*/
    /*Start Tooltip making*/
    <?php
    if (count($decodedArr) > 0) {
    $i = 0;
    foreach ($decodedArr as $key => $value) {
    if ($value->price != '') {
    ?>
    //alert(<?= (strtotime(date('Y,m,d', strtotime($key)))*1000); ?>)
    var tooltip<?= $i ?> = {
        date: new Date(<?= strtotime($key)*1000; ?>),
        text: /*'Price: <?= $value->price." ".$listDetail->row()->currency; ?>'*/
            '<?= $value->status != 'booked' ? "Price: ".$value->price." ".$listDetail->row()->currency : "Booked"; ?>'
    };
    <?php
    $i++;
    }
    }
    $tootlTip = "";
    for ($k = 0; $k < $i; $k++) {
        $tootlTip .= 'tooltip' . $k;
        if ($k != $i) {
            $tootlTip .= ',';
        }
    }
    ?>
    datepicker.tooltips = [<?= $tootlTip; ?>];
    <?php
    }
    ?>
    /*Close Tooltip making*/
    datepicker.highlight = [Bookedhighlight, AvailableHighlight, UnAvailableHighlight];
    var AlreadyFound = '<?= $bookedDates->row()->data;?>';
    var base_url = '<?= base_url(); ?>';

    function CalanderUpdate_always(){
      // alert('always');
        $('.pric').hide();
        CalanderUpdate(this,'always','calendar_checked');
    }
function CalanderUpdate_some1()
    {
       // alert('Some');
         $('.pric').show();
        CalanderUpdate(this,'sometimes','calendar_checked');
    }
    function inloader()
    {
         $('.loading').show();
          var listDetailid = '<?= $listDetail->row()->id;?>';
          var base_url = '<?= base_url(); ?>';
        window.location.href=base_url+"overview_listing/"+listDetailid;
    }
    $('.number').keypress(function(event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
</script>
<script src="<?= base_url(); ?>js/ManageListingCalander.js"></script>