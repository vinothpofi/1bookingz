<?php
$currentUrl = $this->uri->segment(2, 0);
$currentPage = $this->uri->segment(3, 0);
if ($currentUrl == '') {
    $currentUrl = 'dashboard';
}
if ($currentPage == '') {
    $currentPage = 'dashboard';
}
?>
<style type="text/css">
    .sideBarIcon {width: 40px;height: 40px;position: absolute;right: 0;}
    /*.sideBarIcon svg {width: 100%;height: 100%;}*/
    /*.sideBarIcon svg path {stroke: #fff;stroke-width: 60px;stroke-linecap: round;stroke-linejoin: round;fill: transparent;}*/
    .sideBarIcon button  {width: 40px;height: 45px;position: relative;margin: 0px auto;-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);padding: unset;-o-transform: rotate(0deg);transform: rotate(0deg);-webkit-transition: .5s ease-in-out;-moz-transition: .5s ease-in-out;-o-transition: .5s ease-in-out;transition: .5s ease-in-out;cursor: pointer;background: #152239;line-height: 1;border-color: transparent;}
    .sideBarIcon button div {display: block;position: absolute;height: 3px;width: 70%;background: #ffffff;opacity: 1;-webkit-transform: rotate(0deg);-moz-transform: rotate(0deg);-o-transform: rotate(0deg);transform: rotate(0deg);-webkit-transition: .25s ease-in-out;-moz-transition: .25s ease-in-out;-o-transition: .7s ease-in-out;transition: .25s ease-in-out;left: 1px;}
    .sideBarIcon button div:first-child {top: 8px;}
    .sideBarIcon button div:nth-child(2) {top: 15px;}
    .sideBarIcon button div:last-child {top: 22px;}
    /*not active*/
    .sideBarIcon button:not(.active) div:first-child {transform: rotateZ(34deg) translate(12px,-4px);width: 40%;}
    .sideBarIcon button:not(.active) div:last-child {top: 22px;transform: rotateZ(-40deg) translate(12px,6px);width: 40%;}
</style>

<script type="text/javascript">
    $(document).ready(function(){
        $("#left_bar #sidebar ul.sidenav li a:first-child").addClass('chk');
        var sideBarSess = localStorage.getItem("sideBarSession");
        if(sideBarSess == 'active'){
            $("#left_bar").addClass("sideIn");
            $("#container").addClass("active");
            $(".sideBarIcon button").addClass("active");
        }else if(sideBarSess == 'inActive'){
            $("#left_bar").removeClass("sideIn");
            $("#container").removeClass("active");
            $(".sideBarIcon button").removeClass("active");
            $("#left_bar:not(.sideIn) #sidebar ul li ul.acitem").css('display', 'none');
        }
        // $("#left_bar").addClass("sideIn");
        // $("#container").addClass("active");
        // $(".sideBarIcon button").addClass("active");
        $(".sideBarIcon button").click(function(){
            if($(this).hasClass('active')){
                $("#container").removeClass("active");
                $(this).removeClass('active');
                $("#left_bar").removeClass("sideIn");
                $("#left_bar #sidebar ul li ul.acitem").css('display', 'none');
                localStorage.setItem("sideBarSession", "inActive");
            }else {
                $("#container").addClass("active");
                $(this).addClass('active');
                $("#left_bar").addClass("sideIn");
                checkActiveMenu();
                localStorage.setItem("sideBarSession", "active");
            }
        });
        /*Hover*/
        $("#left_bar #sidebar").hover(function() {
                $("#left_bar").not(".sideIn").addClass("hoverActive");
            }, function() {
                $("#left_bar").not(".sideIn").delay("easy").removeClass("hoverActive");
                $("#left_bar:not(.sideIn) #sidebar ul li ul.acitem").css('display', 'none');
            }
        );
        function checkActiveMenu(){
            $("#left_bar #sidebar ul.sidenav li").each(function(i){
                var s = $(this + ":nth-child("+i+") a:first-child");
                // s.css('display','none');
                // if(s.hasClass('active')){
                // console.log($(this+" a").attr('href'));
                // 	console.log('Successful');
                // }else {
                // 	console.log('UnSuccessful');
                // }
            });
        }
    });
</script>
<div id="left_bar" class="sideIn">
    <div class="logoDiv" style="">
        <div class="logo">
            <img src="images/logo/<?php echo $logo; ?>" alt="<?php echo $siteTitle; ?>" height="38px"
                 title="<?php echo $siteTitle; ?>" style="float: left;">
            <span style="float: left;line-height: 15px;font-size: 16px;padding: 10px;color: #fff;font-weight: bold;">HomestayDNN</span>
            <div class="sideBarIcon" >
                <button class=" active">
                    <div class="icon-bar"></div>
                    <div class="icon-bar"></div>
                    <div class="icon-bar"></div>
                </button>
                <!-- <svg width="100" height="100">
                <circle cx="50" cy="50" r="40" stroke="green" stroke-width="4" fill="yellow" />
                </svg> -->
                <!--             	<svg width="100" height="100">
                                    <path id="pathA" d="M 300 500 L 700 500" stroke="white" style="stroke-dashoffset: 800; stroke-dasharray: 400, 480, 240;"></path>
                                    <path id="pathB" d="M 300 500 L 700 500" stroke="white" style="stroke-dashoffset: 800; stroke-dasharray: 400, 480, 240;"></path>
                                    <path id="pathC" d="M 300 500 L 700 500" stroke="white" style="stroke-dashoffset: 800; stroke-dasharray: 400, 480, 240;"></path>
                                </svg> -->
            </div>
        </div>
    </div>
    <div id="sidebar">
        <div id="secondary_nav">
            <ul id="sidenav" class="accordion_mnu collapsible">
                <li>
                    <a href="<?php echo base_url(); ?>admin/dashboard/admin_dashboard" <?php if ($currentUrl == 'dashboard') {
                        echo 'class="active"';
                    } ?>><span class="nav_icon computer_imac"></span> Dashboard
                    </a>
                </li>


                <?php extract($privileges);
                if ($allPrev == '1') { ?>
                    <li>
                        <a href="<?php echo base_url(); ?>admin/adminlogin/display_admin_list" <?php if ($currentUrl == 'adminlogin') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon admin_user"></span> Admin<span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'adminlogin' || $currentUrl == 'sitemap') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="<?php echo base_url(); ?>admin/adminlogin/display_admin_list" <?php if ($currentPage == 'display_admin_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Admin Users List
                                </a>
                            </li>
                            <li>
                                <a href="admin/adminlogin/change_admin_password_form" <?php if ($currentPage == 'change_admin_password_form') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Change Password
                                </a>
                            </li>
                            <li>
                                <a href="admin/adminlogin/admin_global_settings_form" <?php if ($currentPage == 'admin_global_settings_form') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Settings
                                </a>
                            </li>
                            <li>
                                <a href="admin/adminlogin/admin_smtp_settings" <?php if ($currentPage == 'admin_smtp_settings') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>SMTP Settings
                                </a>
                            </li>
                            <li>
                                <a href="admin/sitemap/create_sitemap" <?php if ($currentPage == 'create_sitemap') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Sitemap Creation
                                </a>
                            </li>														<li>								<a href="admin/adminlogin/update_advertisement" <?php if ($currentPage == 'update_advertisement') {									echo 'class="active"';								} ?>><span class="list-icon">&nbsp;</span>Advertisement Update								</a>							</li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo base_url(); ?>admin/subadmin/display_sub_admin" <?php if ($currentUrl == 'subadmin') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon user"></span> Sub-Admin<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'subadmin') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/subadmin/display_subadmin_dashboard" <?php if ($currentPage == 'display_subadmin_dashboard') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="admin/subadmin/display_sub_admin" <?php if ($currentPage == 'display_sub_admin') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Sub-Admin List
                                </a>
                            </li>
                            <li>
                                <a href="admin/subadmin/add_sub_admin_form" <?php if ($currentPage == 'add_sub_admin_form') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Add New Sub-Admin
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!---Rep -->
                <?php }
                if ($allPrev == '1') { ?>
                    <li>
                        <a href="admin/rep/display_rep_dashboard" <?php if ($currentUrl == 'rep') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon users"></span>Representatives<span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'rep') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/rep/display_rep_dashboard" <?php if ($currentPage == 'display_rep_dashboard') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="admin/rep/display_rep_list" <?php if ($currentPage == 'display_rep_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rep. List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Members)) { ?>
                                <li>
                                    <a href="admin/rep/add_rep_form" <?php if ($currentPage == 'add_rep_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Rep.
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="admin/rep/export_rep_details" <?php if ($currentPage == 'export_rep_details') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Rep. List
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php }
                if ((isset($Members) && is_array($Members)) && in_array('0', $Members) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/users/display_user_dashboard" <?php if ($currentUrl == 'users') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon users"></span>Guest<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'users') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/users/display_user_dashboard" <?php if ($currentPage == 'display_user_dashboard') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="admin/users/display_user_list" <?php if ($currentPage == 'display_user_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Guest List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Members)) { ?>
                                <li>
                                    <a href="admin/users/add_user_form" <?php if ($currentPage == 'add_user_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Guest
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="admin/users/export_user_details" <?php if ($currentPage == 'export_user_details') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Guest List
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }
                if ((isset($Host) && is_array($Host)) && in_array('0', $Host) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/seller/display_seller_dashboard" <?php if ($currentUrl == 'seller') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon users_2"></span>Host<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'seller') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/seller/display_seller_dashboard" <?php if ($currentPage == 'display_seller_dashboard') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="admin/seller/display_seller_list" <?php if ($currentPage == 'display_seller_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Host List
                                </a>
                            </li>
                            <li>
                                <a href="admin/seller/display_archieve_seller" <?php if ($currentPage == 'display_archieve_seller') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Host Archive List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Host)) { ?>
                                <li>
                                    <a href="admin/seller/add_seller_form" <?php if ($currentPage == 'add_seller_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Host
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/seller/customerExcelExport" <?php if ($currentPage == 'customerExcelExport') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Export Host List
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>

                <?php } ?>

                <?php if ((isset($RentalTypes) && is_array($RentalTypes)) && in_array('0', $RentalTypes) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/listattribute/display_attribute_listspace" <?php if ($currentUrl == 'listattribute') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>Rental Types&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Property Types"></i><span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'listattribute') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/listattribute/display_attribute_listspace" <?php if ($currentPage == 'display_attribute_listspace') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Type
                                </a>
                            </li>
                            <li>
                                <a href="admin/listattribute/display_listspace_values" <?php if ($currentPage == 'display_listspace_values') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Type Values
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $ListSpace)) { ?>
                                <li style="display:none">
                                    <a href="admin/listattribute/add_attribute_listform" <?php if ($currentPage == 'add_attribute_listform') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Rental Type</a>
                                </li>
                                <li>
                                    <a href="admin/listattribute/add_listspace_value_form" <?php if ($currentPage == 'add_listspace_value_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Rental Type Values
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>



                <?php if ((isset($Amenities) && is_array($Amenities)) && in_array('0', $Amenities) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/attribute/display_attribute_list" <?php if ($currentUrl == 'attribute') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon cog_3"></span> Amenities &nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Facilities of property like car parking, smoke detector etc.."></i><span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'attribute') {
                            echo 'style="display: block;"';

                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/attribute/display_attribute_list" <?php if ($currentPage == 'display_attribute_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Amenities
                                </a>
                            </li>
                            <li>
                                <a href="admin/attribute/display_list_values" <?php if ($currentPage == 'display_list_values') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Amenities Values
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $List)) { ?>
                                <li>
                                    <a href="admin/attribute/add_attribute_form" <?php if ($currentPage == 'add_attribute_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Amenities
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/attribute/add_list_value_form" <?php if ($currentPage == 'add_list_value_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Amenities Value
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>

                <?php } ?>

                <?php if ((isset($Features) && is_array($Features)) && in_array('0', $Features) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/listings/display_attribute_list" <?php if ($currentUrl == 'listings') {
                            echo 'class="active"';
                        } ?>>
                            <span class="nav_icon folder"></span>Features&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Property Attributes"></i>
                            <span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'listings') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>


                            <li>
                                <a href="admin/listings/attribute_values" <?php if ($currentPage == 'attribute_values') {
                                    echo 'class="active"';
                                } ?>>
                                    <span class="list-icon">&nbsp;</span>Features Types
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Listing)) { ?>
                                <li>
                                    <a href="admin/listings/add_new_attribute" <?php if ($currentPage == 'add_new_attribute') {
                                        echo 'class="active"';
                                    } ?>>
                                        <span class="list-icon">&nbsp;</span>Add New Features
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Rentals) && is_array($Rentals)) && in_array('0', $Rentals) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/product/display_rental_dashboard" <?php if (($currentUrl == 'product'&& $currentPage != 'cancel_booking_payment') || $currentUrl == 'comments' ) {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>Property Rentals&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage Properties"></i><span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if (($currentUrl == 'product' && $currentPage != 'cancel_booking_payment') || $currentUrl == 'comments' ) {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/product/display_rental_dashboard" <?php if ($currentPage == 'display_rental_dashboard') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="admin/product/display_product_list" <?php if ($currentPage == 'display_product_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Property Rental List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Properties)) { ?>
                                <li>
                                    <a href="admin/manage_rentals/add_new_rentals" <?php if ($currentPage == 'add_product_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add New Property Rental
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/product/customerExcelExport" <?php if ($currentPage == 'display_user_product_list') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Export Property Rental List
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }
                if ((isset($RentalTransaction) && is_array($RentalTransaction)) && in_array('0', $RentalTransaction) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/order/display_order_paid" <?php if ($currentUrl == 'bookingpayment' || $currentUrl == 'order' || $this->uri->segment(1, 0) == 'order-review') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon coverflow"></span> Rental Transaction&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Property Transaction"></i><span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'bookingpayment' || $currentUrl == 'order' || $this->uri->segment(1, 0) == 'order-review') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/order/display_order_paid" <?php if ($currentPage == 'display_order_paid') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Successful Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/order/display_order_pending" <?php if ($currentPage == 'display_order_pending') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Failed Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/order/display_listing_order" <?php if ($currentPage == 'display_listing_order') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Listing Payment<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage guest listed property"></i>
                                </a>
                            </li>

                            <li>
                                <a href="admin/bookingpayment/display_receivable" <?php if ($currentPage == 'display_receivable') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Receivable & Payable
                                </a>
                            </li>

                            <li>
                                <a href="admin/order/customerExcelExport/Paid" <?php if ($currentPage == 'customerExcelExport') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Successful Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/order/customerExcelExport/Pending" <?php if ($currentPage == 'customerExcelExport') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Failed Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/order/customerExcelExportlist" <?php if ($currentPage == 'customerExcelExport') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Rental Listing

                                </a>
                            </li>

                            <li>
                                <a href="admin/bookingpayment/customerExcelExportReceivable" <?php if ($currentPage == 'customerExcelExportReceivable') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Exp Receivable & Payable
                                </a>
                            </li>



                        </ul>
                    </li>
                <?php } ?>




                <?php if ((isset($RentalBookingStatus) && is_array($RentalBookingStatus)) && in_array('0', $RentalBookingStatus) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/attribute/display_attribute_list" <?php if ($currentUrl == 'account') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon cog_3"></span> Rental Booking Status&nbsp;<i class="fa fa-info-circle fa-lg tipRight" original-title="Manage property booking and listing"></i><span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'account') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>

                            <li>
                                <a href="admin/account/display_newbooking" <?php if ($currentPage == 'display_newbooking') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>New Booking
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $BookingStatus)) { ?>
                                <li>
                                    <a href="admin/account/display_book_confirmed" <?php if ($currentPage == 'display_book_confirmed') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Completed Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/account/display_book_concelled" <?php if ($currentPage == 'display_book_concelled') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Canceled Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/account/display_book_expired" <?php if ($currentPage == 'display_book_expired') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Expired Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/account/customerExcelExportNewBooking/enquiry" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Export New Booking</a>
                                </li>
                                <li>
                                    <a href="admin/account/customerExcelExportNewBooking/booked" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Exp Completed Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/account/customerExcelExportExpired" <?php if ($currentPage == 'customerExcelExportExpired') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Exp Expired Booking</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }

                if ((isset($Experience) && is_array($Experience)) && in_array('0', $Experience) || $allPrev == '1') {
                    ?>
                    <li>
                        <a href=""<?php if ($currentUrl == 'experience') {
                            echo 'class="active"';
                        } ?> ><span class="nav_icon book"></span> Experience <span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'experience') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?> >

                            <li>
                                <a href="<?php echo 'admin/experience/experienceTypeList'; ?>" <?php if ($currentPage == 'experieceTypeList') {
                                    echo 'class="active"';
                                } ?>> Experience Type List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Experience)) { ?>
                                <li>
                                    <a href="<?php echo 'admin/experience/addExperienceType_from'; ?>" <?php if ($currentPage == 'addExperienceType_from') {
                                        echo 'class="active"';
                                    } ?>> Add Experience Type
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="<?php echo 'admin/experience/experienceList'; ?>" <?php if ($currentPage == 'experienceList') {
                                    echo 'class="active"';
                                } ?>> Experience List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Experience)) { ?>
                                <li>
                                    <a href="<?php echo 'admin/experience/add_experience_form_new'; ?>" <?php if ($currentPage == 'addExperiece') {
                                        echo 'class="active"';
                                    } ?>> Add Experience
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                }



                if ((isset($ExperienceTransaction) && is_array($ExperienceTransaction)) && in_array('0', $ExperienceTransaction) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/experience_order/display_order_paid" <?php if ($currentUrl == 'experience_order' || $this->uri->segment(1, 0) == 'experience_order-review') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon coverflow"></span> Experience Transaction<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl =='experience_bookingpayment' || $currentUrl == 'experience_order' || $this->uri->segment(1, 0) == 'experience_order-review') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/experience_order/display_order_paid" <?php if ($currentPage == 'display_order_paid') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Successful Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_order/display_order_pending" <?php if ($currentPage == 'display_order_pending') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Failed Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_order/display_listing_order" <?php if ($currentPage == 'display_listing_order') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experience Listing Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_bookingpayment/display_receivable" <?php if ($currentPage == 'display_receivable') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Receivable & Payable
                                </a>
                            </li>

                            <li>
                                <a href="admin/experience_order/customerExcelExport/Paid" <?php if ($currentPage == 'customerExcelExport') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Successful Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_order/customerExcelExport/Pending" <?php if ($currentPage == 'customerExcelExport') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Failed Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_order/customerExcelExportlist" <?php if ($currentPage == 'customerExcelExportlist') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Export Experience Listing
                                </a>
                            </li>

                            <li>
                                <a href="admin/experience_bookingpayment/customerExcelExportReceivable" <?php if ($currentPage == 'customerExcelExportReceivable') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Exp Receivable & Payable
                                </a>
                            </li>

                        </ul>
                    </li>
                <?php } ?>


                <?php
                if ((isset($ExperienceBookingStatus) && is_array($ExperienceBookingStatus)) && in_array('0', $ExperienceBookingStatus) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/experience_account/display_attribute_list" <?php if ($currentUrl == 'experience_account') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon cog_3"></span>Experience Booking Status<span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'experience_account') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>

                            <li>
                                <a href="admin/experience_account/display_newbooking" <?php if ($currentPage == 'display_newbooking') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>New Booking
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $BookingStatus)) { ?>
                                <li>
                                    <a href="admin/experience_account/display_book_confirmed" <?php if ($currentPage == 'display_book_confirmed') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Upcom. Completed Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/experience_account/display_book_expired" <?php if ($currentPage == 'display_book_expired') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Expired Booking</a>
                                </li>
                                <li>
                                    <a href="admin/experience_account/customerExcelExportNewBooking/enquiry" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Export New Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/experience_account/customerExcelExportNewBooking/booked" <?php if ($currentPage == 'customerExcelExportNewBooking') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Exp Completed Booking
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/experience_account/customerExcelExportExpired" <?php if ($currentPage == 'customerExcelExportExpired') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Exp Expired Booking
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((isset($Reports) && is_array($Reports)) && in_array('0', $Reports) || $allPrev == '1') {
                ?>
                <li>
                    <a href="admin/reports/display_report_list" <?php if ($currentUrl == 'reports') {
                        echo 'class="active"';
                    } ?>><span class="nav_icon cog_3"></span>Reports<span
                                class="up_down_arrow">&nbsp;</span>
                    </a>
                </li>
                <?php } ?>

                <?php if ((isset($Commission) && is_array($Commission)) && in_array('0', $Commission) || $allPrev == '1') {
                    ?>
                    <li>
                        <a href="#" <?php if ($currentUrl == 'commission' || $currentUrl == 'experience_commission') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>Commissions<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'commission' || $currentUrl == 'experience_commission') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>

                            <?php if ($allPrev == '1') { ?>
                                <li>
                                    <a href="admin/commission/display_commission_list" <?php if ($currentPage == 'display_commission_list') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Commission List
                                    </a>
                                </li>
                            <?php } ?>

                            <li>
                                <a href="admin/commission/display_commission_tracking_lists" <?php if ($currentPage == 'display_commission_tracking_lists' && $currentUrl == 'commission') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Commission Tracking
                                </a>
                            </li>

                            <li>
                                <a href="admin/commission/display_wallet_payments_list" <?php if ($currentPage == 'display_wallet_payments_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Wallet Payments
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_commission/display_commission_tracking_lists" <?php if ($currentPage == 'display_commission_tracking_lists' && $currentUrl == 'experience_commission') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experience Commission Tracking</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <?php if ((isset($Review) && is_array($Review)) && in_array('0', $Review) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/review/display_review_list" <?php if ($currentUrl == 'experience_review' || $currentUrl == 'review' || $this->uri->segment(1, 0) == 'experience_review') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span> Review <span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'experience_review' || $currentUrl == 'review' || $this->uri->segment(1, 0) == 'experience_review') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/review/display_review_list" <?php if ($currentPage == 'display_review_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Review List
                                </a>
                            </li>
                            <?php //if ($experienceExistCount > 0) { ?>
                            <li>
                                <a href="admin/experience_review/display_experience_review_list" <?php if ($currentPage == 'display_experience_review_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experience Review List
                                </a>
                            </li>
                            <?php //} ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Dispute) && is_array($Dispute)) && in_array('0', $Dispute) || $allPrev == '1') { ?>
                    <li><a href="admin/dispute/display_review_list" <?php if ($currentUrl == 'dispute' || $currentUrl == 'experience_dispute' || $currentPage == 'cancel_booking_payment' || $currentPage == 'cancel_booking_payment') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span> Dispute/Cancellation <span class="up_down_arrow">&nbsp;</span></a>
                        <ul class="acitem" <?php if ($currentUrl == 'dispute' || $currentUrl == 'experience_dispute' || $currentPage == 'cancel_booking_payment') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/dispute/display_dispute_list" <?php if ($currentPage == 'display_dispute_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Dispute List
                                </a>
                            </li>
                            <li>
                                <a href="admin/dispute/cancel_booking_list" <?php if ($currentPage == 'cancel_booking_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Cancel Booking Lists
                                </a>
                            </li>
                            <li>
                                <a href="admin/dispute/cancel_booking_payment" <?php if ($currentPage == 'cancel_booking_payment' && $currentUrl == 'dispute' ) {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Cancellation Payment</a>
                            </li>
                            <li>
                                <a href="admin/product/cancel_booking_payment" <?php if ($currentPage == 'cancel_booking_payment' && $currentUrl == 'product'  ) {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Rental Host Cancellation Payment</a>
                            </li>
                            <li>
                                <a href="admin/experience_dispute/display_experience_dispute_list" <?php if ($currentPage == 'display_experience_dispute_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experience Cancel Booking Lists
                                </a>
                            </li>
                            <li>
                                <a href="admin/dispute/cancel_experience_booking_payment" <?php if ($currentPage == 'cancel_experience_booking_payment') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experience Cancellation Payment
                                </a>
                            </li>
                            <li>
                                <a href="admin/experience_dispute/cancel_booking_payment" <?php if ($currentPage == '') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Experiance Host Cancellation Payment</a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>




                <?php if ((isset($Couponcode) && is_array($Couponcode)) && in_array('0', $Couponcode) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/couponcards/display_couponcards" <?php if ($currentUrl == 'couponcards') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon record"></span> Coupon Codes<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'couponcards') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/couponcards/display_couponcards" <?php if ($currentPage == 'display_couponcards') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Coupon code List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Couponcode)) { ?>
                                <li>
                                    <a href="admin/couponcards/add_couponcard_form" <?php if ($currentPage == 'add_couponcard_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Coupon code
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($PaymentGateway) && is_array($PaymentGateway)) && in_array('0', $PaymentGateway) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/paygateway/display_gateway" <?php if ($currentUrl == 'paygateway') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon shopping_cart_2"></span> Payment Gateway
                        </a>
                    </li>
                    <?php
                } ?>

                <?php if ((isset($Currency) && is_array($Currency)) && in_array('0', $Currency) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/currency/display_currency_list" <?php if ($currentUrl == 'currency') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon globe"></span> Manage Currency<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'currency') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/currency/display_currency_list" <?php if ($currentPage == 'display_currency_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Currency List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Currency)) { ?>
                                <li>
                                    <a href="admin/currency/add_currency_form" <?php if ($currentPage == 'add_currency_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add currency
                                    </a>
                                </li>
                            <?php } ?>
                            <li>
                                <a href="admin/currency/currencyConversion" <?php if ($currentPage == 'currencyConversion') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Currency Conversion
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Language) && is_array($Language)) && in_array('0', $Language) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/multilanguage" <?php if ($currentUrl == 'multilanguage') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon cog_3"></span> Manage Language
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'multilanguage') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/multilanguage/display_language_list" <?php if ($currentPage == 'display_language_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Site Language
                                </a>
                            </li>
                            <li>
                                <a href="admin/multilanguage/display_user_language" <?php if ($currentPage == 'display_user_language') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>User Language
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }  ?>

                <?php if ((isset($ManageCountry) && is_array($ManageCountry)) && in_array('0', $ManageCountry) || $allPrev == '1') { ?>
                    <li><a href="admin/location/display_location_list" <?php if ($currentUrl == 'location') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon globe"></span> Manage Country<span
                                    class="up_down_arrow">&nbsp;</span></a>
                        <ul class="acitem" <?php if ($currentUrl == 'location') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/location/display_location_list" <?php if ($currentPage == 'display_location_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Country List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $ManageCountry)) { ?>
                                <li><a href="admin/location/add_tax_form" <?php if ($currentPage == 'add_tax_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add State</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($City) && is_array($City)) && in_array('0', $City) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/city/display_city_list" <?php if ($currentUrl == 'city') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon record"></span> Manage City<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'city') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/city/display_city_list" <?php if ($currentPage == 'display_city_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>City List
                                </a>
                            </li>
                            <li>
                                <a href="admin/city/display_featured_cities" <?php if ($currentPage == 'display_featured_cities') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Featured City List
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Pages) && is_array($Pages)) && in_array('0', $Pages) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/cms/display_cms" <?php if ($currentUrl == 'cms') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon documents"></span> Manage Static Pages<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'cms') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/cms/display_cms" <?php if ($currentPage == 'display_cms') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>List of pages
                                </a>
                            </li>
                            <li>
                                <a href="admin/cms/display_top_menu" <?php if ($currentPage == 'display_top_menu') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Footer Top Menu
                                </a>
                            </li>

                            <?php if ($allPrev == '1' || in_array('1', $Pages)) { ?>
                                <li>
                                    <a href="admin/cms/add_cms_form" <?php if ($currentPage == 'add_cms_form') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Main Page
                                    </a>
                                </li>
                                <li>
                                    <a href="admin/cms/add_lang_page" <?php if ($currentPage == 'add_lang_page') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Language Page
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Newsletter) && is_array($Newsletter)) && in_array('0', $Newsletter) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/newsletter/display_newsletter" <?php if ($currentUrl == 'newsletter') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon mail"></span> Newsletter Template<span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'newsletter') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/newsletter/display_subscribers_list" <?php if ($currentPage == 'display_subscribers_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Subscription List
                                </a>
                            </li>
                            <li>
                                <a href="admin/newsletter/display_subscriber_newsletter" <?php if ($currentPage == 'display_subscriber_newsletter') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Subscriber Template List
                                </a>
                            </li>
                            <li>
                                <a href="admin/newsletter/display_newsletter" <?php if ($currentPage == 'display_newsletter') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Email Template List
                                </a>
                            </li>
                            <?php if ($allPrev == '1' || in_array('1', $Newsletter)) { ?>
                                <li>
                                    <a href="admin/newsletter/add_newsletter" <?php if ($currentPage == 'add_newsletter') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Add Email Template</a>
                                </li>
                                <li><a href="admin/newsletter/mass_email" <?php if ($currentPage == 'mass_email') {
                                        echo 'class="active"';
                                    } ?>><span class="list-icon">&nbsp;</span>Mass E-Mail Campaigns
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>


                <?php if ((isset($Banner) && is_array($Banner)) && in_array('0', $Banner) || $allPrev == '1'){

                    $slider_count = $this->db->where('status','Active')->get('fc_slider');;
                    $slider_count =  $slider_count->num_rows();
                    ?>
                    <li><a href="#" <?php if($currentUrl=='slider' || $currentUrl=='comments'){ echo 'class="active"';} ?>><span class="nav_icon folder"></span> Banner<span class="up_down_arrow">&nbsp;</span></a>
                        <ul class="acitem" <?php if($currentUrl=='slider' || $currentUrl=='comments'){ echo 'style="display: block;"';}else{ echo 'style="display: none;"';} ?>>
                            <li ><a href="admin/slider/display_slider_list" <?php if($currentPage=='display_slider_list'){ echo 'class="active"';} ?>><span class="list-icon">&nbsp;</span>Banner List</a></li>
                            <?php if ($allPrev == '1' || in_array('1', $Slider)){ ?>
                                <li style="display: none;"><?php if($slider_count >= 4 ){echo '<a>Cant Add Banner(Max: 4 Only)</a>';}
                                    else{?>
                                    <a href="admin/slider/add_slider_form" <?php if($currentPage=='add_slider_form'){ echo 'class="active"';} ?>><span class="list-icon">&nbsp;</span>Add Banner</a><?php } ?>

                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }  if ((isset($Prefooter) && is_array($Prefooter)) && in_array('0', $Prefooter) || $allPrev == '1'){ ?>

                    <li>
                        <a href="#" <?php if ($currentUrl == 'prefooter' || $currentUrl == 'comments') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>Prefooter<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'prefooter' || $currentUrl == 'comments') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/prefooter/display_prefooter_list" <?php if ($currentPage == 'display_prefooter_list') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Prefooter List
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }
                if ((isset($Backup) && is_array($Backup)) && in_array('0', $Backup) || $allPrev == '1') { ?>
                    <li>
                        <a href="#" <?php if ($currentUrl == 'dropbox') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>Backup<span class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'dropbox') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/backup/dbBackup" <?php if ($currentPage == 'add_prefooter_form') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Database Backup
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>



                <?php if ((isset($Enquiries) && is_array($Enquiries)) && in_array('0', $Enquiries) || $allPrev == '1') { ?>
                    <li>
                        <a href="admin/contact_us/display_contactus"><span class="nav_icon globe"></span> Enquiries
                        </a>
                    </li>
                <?php }

                if ((isset($FAQManagement) && is_array($FAQManagement)) && in_array('0', $FAQManagement) || $allPrev == '1') { ?>

                    <li>
                        <a href="#" <?php if ($currentUrl == 'help' || $currentUrl == 'help') {
                            echo 'class="active"';
                        } ?>><span class="nav_icon folder"></span>FAQ Management<span
                                    class="up_down_arrow">&nbsp;</span>
                        </a>
                        <ul class="acitem" <?php if ($currentUrl == 'help' || $currentUrl == 'help') {
                            echo 'style="display: block;"';
                        } else {
                            echo 'style="display: none;"';
                        } ?>>
                            <li>
                                <a href="admin/help/display_main_menu" <?php if ($currentPage == 'display_main_menu') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Categories
                                </a>
                            </li>
                            <li>
                                <a href="admin/help/display_sub_menu" <?php if ($currentPage == 'display_sub_menu') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>Sub topic
                                </a>
                            </li>
                            <li>
                                <a href="admin/help/question_and_ans" <?php if ($currentPage == 'question_and_ans') {
                                    echo 'class="active"';
                                } ?>><span class="list-icon">&nbsp;</span>FAQ
                                </a>
                            </li>

                        </ul>
                    </li>

                <?php } ?>
                <!-- MANUAL CURRENCY UPDATE -->
                <?php
                $manualUpdateStatus = $this->db->select('manual_currency_status')->where('id','1')->get('fc_admin')->row()->manual_currency_status;
                if($manualUpdateStatus==1) { ?>
                    <li><a href="admin/CurrencyManual" <?php if($currentUrl=='CurrencyManual'){ echo 'class="active"';} ?>><span class="nav_icon folder"></span> Manual Currency Update</a></li>
                <?php } ?>
                <!-- END OF MANUAL CURRENCY UPDATE -->
            </ul>
        </div>
    </div>
</div>


