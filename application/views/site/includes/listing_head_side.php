<?php $url = $this->uri->segment(1); ?>
<div class="leftSlideBlock">
    <ul>
        <li class="heading">
            <?php if ($this->lang->line('list_Basics') != '') {
                echo stripslashes($this->lang->line('list_Basics'));
            } else echo "Basics"; ?>
        </li>
        <?php
        if ($url != 'list_space') {
            ?>
            <li><a <?php if ($url == 'basic_info') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "basic_info/" . $listDetail->row()->id; ?>"><?php 
						if ($this->lang->line('basic_info') != '') {
                                echo stripslashes($this->lang->line('basic_info'));
                            } else echo "Basic Info";?>
                    <span class="pull-right">
                    <i class="fa fa-check" aria-hidden="true"></i>
                </span>
                </a></li>
            <li><a <?php if ($url == 'price_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "price_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Pricing') != '') {
                        echo stripslashes($this->lang->line('list_Pricing'));
                   } else echo "Pricing"; ?><span
                            class="pull-right"><?php if ($Steps_count2 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a>
            </li>
            <li><a <?php if ($url == 'manage_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "manage_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Calendar') != '') {
                        echo stripslashes($this->lang->line('list_Calendar'));
                    } else echo "Calendar"; ?><span
                            class="pull-right"><?php if ($listDetail->row()->calendar_checked == '') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a>
            </li>
            
            <li class="heading"><?php if ($this->lang->line('decs_new') != '') {
                    echo stripslashes($this->lang->line('decs_new'));
                } else echo "Description"; ?> </li>
            <li><a <?php if ($url == 'overview_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "overview_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Overview') != '') {
                        echo stripslashes($this->lang->line('list_Overview'));
                    } else echo "Overview"; ?><span
                            class="pull-right"><?php if ($Steps_count1 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <?php if ($listDetail->row()->space != "" || $listDetail->row()->guest_access != "" || $listDetail->row()->interact_guest != "" || $listDetail->row()->neighbor_overview != "" || $listDetail->row()->neighbor_around != "" || $listDetail->row()->house_rules != "" || $url == 'detail_list') { ?>

                <li><a <?php if ($url == 'detail_list') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "detail_list/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Details') != '') {
                        echo stripslashes($this->lang->line('list_Details'));
                    } else echo "Details"; ?><span
                            class="pull-right"><?php if ($listDetail->row()->space != "" || $listDetail->row()->guest_access != "" || $listDetail->row()->interact_guest != "" || $listDetail->row()->neighbor_overview != "" || $listDetail->row()->neighbor_around != "" || $listDetail->row()->house_rules != "") {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li><?php } ?>
            <li><a <?php if ($url == 'photos_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "photos_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Photos') != '') {
                        echo stripslashes($this->lang->line('list_Photos'));
                   } else echo "Photos"; ?><span
                            class="pull-right"><?php if ($Steps_count4 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <li class="heading"><?php if ($this->lang->line('list_Settings') != '') {
                    echo stripslashes($this->lang->line('list_Settings'));
                } else echo "Settings"; ?></li>
            <li><a <?php if ($url == 'amenities_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "amenities_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Amenities') != '') {
                        echo stripslashes($this->lang->line('list_Amenities'));
                    } else echo "Amenities"; ?>
                    <span
                            class="pull-right"><?php if ($Steps_count5 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <li><a <?php if ($url == 'space_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "space_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Listing') != '') {
                        echo stripslashes($this->lang->line('list_Listing'));
                    } else echo "Listing"; ?>
                    <span
                            class="pull-right"><?php if ($Steps_count7 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <li><a <?php if ($url == 'address_listing') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "address_listing/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Location') != '') {
                        echo stripslashes($this->lang->line('list_Location'));
                    } else echo "Location"; ?><span
                            class="pull-right"><?php if ($Steps_count6 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <li><a <?php if ($url == 'cancel_policy') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "cancel_policy/" . $listDetail->row()->id; ?>"><?php if ($this->lang->line('list_Cancellation') != '') {
                        echo stripslashes($this->lang->line('list_Cancellation'));
                    } else echo "Cancellation Policy"; ?>
                    <span
                            class="pull-right"><?php if ($Steps_count8 == '1') {
                            ?>
                            <i class="fa fa-times" aria-hidden="true"></i>
                            <?php
                        } else {
                            ?>
                            <i class="fa fa-check" aria-hidden="true"></i>
                            <?php
                        } ?>

                </span>
                </a></li>
            <?php
            if ($Steps_tot == 0 || ($Steps_tot == 1 && $Steps_count3 == 1)) {
                if ($hosting_commission_status->row()->status == 'Inactive') {
                    $payment_url = base_url() . 'site/product/redirect_base/completed/' . $listDetail->row()->id;
                } else {
                  //  $payment_url = base_url() . 'site/product/redirect_base/payment/' . $listDetail->row()->id;
                     $payment_url = base_url() . 'listing/all';
                    
                }
                ?>
                <li><a class="active listed" href="<?php
                    if ($listDetail->row()->status != 'Publish') {
                        echo $payment_url;
                    } else {
                        echo 'javascript:void(0);';
                    }
                    ?>">
                        <?php if ($listDetail->row()->status != 'Publish') {
                            if ($this->lang->line('List Space') != '') {
                                echo stripslashes($this->lang->line('List Space'));
                            } else echo "List Space";
                        } else {
                            if ($this->lang->line('Listed') != '') {
                                echo stripslashes($this->lang->line('Listed'));
                            } else echo "Listed";
                        } ?>
                    </a></li>
            <?php }
        } else {
            ?>
            <li><a <?php if ($url == 'list_space') echo 'class="active"'; ?>
                        href="<?php echo base_url() . "list_space"; ?>"><?php 
						if ($this->lang->line('basic_info') != '') {
                                echo stripslashes($this->lang->line('basic_info'));
                            } else echo "Basic Info";?>
                    <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Pricing') != '') {
                        echo stripslashes($this->lang->line('list_Pricing'));
                    } else echo "Pricing"; ?><span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a>
            </li>
             <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Calendar') != '') {
                        echo stripslashes($this->lang->line('list_Calendar'));
                    } else echo "Calendar"; ?><span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a>
            </li>
            <li class="heading"><?php if ($this->lang->line('decs_new') != '') {
                    echo stripslashes($this->lang->line('decs_new'));
                } else echo "Description"; ?></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Overview') != '') {
                        echo stripslashes($this->lang->line('list_Overview'));
                    } else echo "Overview"; ?>
                    <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Photos') != '') {
                        echo stripslashes($this->lang->line('list_Photos'));
                    } else echo "Photos"; ?>
                    <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <li class="heading"><?php if ($this->lang->line('list_Settings') != '') {
                    echo stripslashes($this->lang->line('list_Settings'));
                } else echo "Settings"; ?></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Amenities') != '') {
                        echo stripslashes($this->lang->line('list_Amenities'));
                    } else echo "Amenities"; ?>
                    <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Listing') != '') {
                        echo stripslashes($this->lang->line('list_Listing'));
                    } else echo "Listing"; ?>
                    <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <li><a href="javascript:void(0);"><?php if ($this->lang->line('list_Location') != '') {
                        echo stripslashes($this->lang->line('list_Location'));
                    } else echo "Location"; ?>
                    <span class="pull-right">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </span>
                </a></li>
            <li><a href="javascript:void(0);""><?php if ($this->lang->line('list_Cancellation') != '') {
                    echo stripslashes($this->lang->line('list_Cancellation'));
                } else echo "Cancellation Policy"; ?>
                <span class="pull-right">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </span>
                </a></li>
            <?php
        }
        ?>
    </ul>
</div>