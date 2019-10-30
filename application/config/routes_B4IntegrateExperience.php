<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
/* Normal listings */
$route['default_controller'] = 'site/landing';
$route['all_listing'] = 'site/product/all_listing/$1';
$route['explore_listing'] = 'site/product/explore_listing/$1';
$route['property'] = "site/rentals/mapview/$1";
$route['create-wishlist-category'] = "site/rentals/rentalwishlistcategoryAdd";
$route['booking/(:any)'] = "site/rentals/rental_guest_booking";
$route['contact-us'] = "site/cms/contactus_businesstravel";
/*Open - Dashboard Links*/
$route['trips/upcoming'] = "site/cms/dashboard_trips";
$route['trips/upcoming/(:any)'] = "site/cms/dashboard_trips/$1";
$route['trips/previous'] = "site/cms/dashboard_trips_prve";
$route['trips/previous/(:any)'] = "site/cms/dashboard_trips_prve/$1";
$route['dashboard'] = "site/user_settings/index";
$route['dashboard/(:any)'] = "site/user_settings/index/$1";
$route['settings'] = "site/user_settings/display_user_settings";
$route['photo-video'] = "site/user/change_profile_photo";
$route['account-payout'] = "site/cms/dashboard_account_payout";
$route['account-trans'] = "site/cms/dashboard_account_trans";
$route['account-trans/(:any)'] = "site/cms/dashboard_account_trans/$1";
$route['account-trans/(:any)/(:any)/(:any)'] = "site/cms/dashboard_account_trans/$1/$2/$3";
$route['settings/password'] = "site/user_settings/password_settings";
$route['settings/preferences'] = "site/user_settings/preferences_settings";
$route['settings/notifications'] = "site/user_settings/notifications_settings";
$route['settings/notifications'] = "site/user_settings/notifications_settings";
$route['account-privacy'] = "site/cms/dashboard_account_privacy";
$route['account-security'] = "site/cms/dashboard_account_security";
$route['account-setting'] = "site/cms/dashboard_account_setting";
$route['your-wallet'] = "site/cms/dashboard_account_wallet";
$route['inbox'] = "site/cms/med_message";
$route['inbox/(:any)'] = "site/cms/med_message/$1";
$route['new_conversation/(:any)/(:any)'] = "site/cms/host_conversation/$1";
$route['verification'] = "site/user/verification";
$route['verification/(:any)'] = "site/user/verification/$1";
$route['invite'] = "site/cms/dashboard_invite";
$route['c/invite/(:any)'] = "site/cms/dashboard_invite_login";
$route['listing/(:any)'] = "site/cms/dashboard_listing/$1";
$route['listing/(:any)/(:any)'] = "site/cms/dashboard_listing/$1";
$route['order/(:any)'] = "site/order";
$route['order/(:any)/(:any)'] = "site/order";
$route['order/(:any)/(:any)/(:any)'] = "site/order";
$route['order/(:any)/(:any)/(:any)/(:any)'] = "site/order";
$route['host-payment-success/(:any)'] = "site/product/hostpayment_success/$1";
$route['display-review'] = "site/product/display_review";
$route['display-review/(:any)'] = "site/product/display_review/$1";
$route['display-review1'] = "site/product/display_review1";
$route['display-review1/(:any)'] = "site/product/display_review1/$1";
$route['display-dispute'] = "site/product/display_dispute";
$route['display-dispute/(:any)'] = "site/product/display_dispute/$1";
$route['display-dispute1'] = "site/product/display_dispute1";
$route['display-dispute1/(:any)'] = "site/product/display_dispute1/$1";
$route['cancel-booking-dispute'] = "site/product/display_dispute2";
$route['cancel-booking-dispute/(:any)'] = "site/product/display_dispute2/$1";
$route['display-dispute2'] = "site/product/cancel_booking_dispute";
$route['display-dispute2/(:any)'] = "site/product/cancel_booking_dispute/$1";
$route['listing-reservation'] = "site/cms/dashboard_listing_reservation";
$route['listing-reservation/(:any)'] = "site/cms/dashboard_listing_reservation/$1";
$route['listing-passed-reservation'] = "site/cms/dashboard_listing_pass_reservation";
$route['listing-passed-reservation/(:any)'] = "site/cms/dashboard_listing_pass_reservation";
$route['users/show/(:any)'] = "site/user_settings/user_profile";
$route['popular'] = "site/rentals/popular_list";
$route['user/(:any)/wishlists/(:any)/edit'] = "site/user/display_user_lists_edit";
$route['user/(:any)/wishlists/(:any)'] = "site/user/display_user_lists_home";
$route['users/(:any)/wishlists'] = "site/wishlists";
/*Close - Dashboard Links*/
/*Start -Cms Links*/
$route['pages/(:num)/(:any)'] = "site/cms/page_by_id";
$route['pages/(:any)'] = "site/cms";
$route['help'] = "site/help";
$route['help/(:any)'] = "site/help";
$route['help/(:any)/(:any)'] = "site/help";
$route['help/(:any)/(:any)/(:any)'] = "site/help";
$route['help/(:any)/(:any)/(:any)/(:any)'] = "site/help";
/*Close -Cms Links*/
/*Start- Language and Currency setting*/
$route['lang/(:any)'] = "site/product/language_change/$1";
$route['change-currency/(:any)'] = "site/product/change_currency/$1";
/*Close- Language and Currency setting*/
/* Login Routes */
$route['google-login'] = 'site/signupsignin/googleLogin';
$route['fb-login'] = 'site/signupsignin/FbLogin';
$route['fb-user-logout'] = 'site/signupsignin/Fblogout';
$route['user-logout'] = 'site/signupsignin/user_logout';
$route['linkedin-login'] = 'site/signupsignin/linkedInLogin';
/* Close-Login Routes */
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
/* Property Listing Module */
$route['list_space'] = 'site/product/list_space';
$route['list_values'] = 'site/mobile/list_values';
$route['rental/(:any)'] = 'site/landing/display_product_detail/$1';
$route['manage_listing/(:any)'] = "site/product/manage_listing/$1";
$route['price_listing/(:any)'] = "site/product/price_listing/$1";
$route['update_price_listing/(:any)'] = "site/product/update_price_listing/$1";
$route['overview_listing/(:any)'] = "site/product/overview_listing/$1";
$route['insert_overview_listing/(:any)'] = "site/product/insert_overview_listing/$1";
$route['extra_description/(:any)'] = "site/product/extra_description/$1";
$route['photos_listing/(:any)'] = "site/product/photos_listing/$1";
$route['photos_uploading'] = "site/product/photos_uploading";
$route['amenities_listing/(:any)'] = "site/product/amenities_listing/$1";
$route['space_listing/(:any)'] = "site/product/space_listing/$1";
$route['address_listing/(:any)'] = "site/product/address_listing/$1";
$route['cancel_policy/(:any)'] = "site/product/cancel_policy/$1";
$route['detail_list/(:any)'] = "site/product/detail_list/$1";
/* Exprience module */
$route['explore-experience'] = "site/experience/explore_experience/$1";
$route['experience/(:any)'] = "site/experience/dashboard_experience_listing";
$route['experience/(:any)/(:any)'] = "site/experience/dashboard_experience_listing";
$route['my_experience/upcoming'] = "site/experience/my_experience";
$route['my_experience/upcoming/(:any)'] = "site/experience/my_experience/$1";
$route['my_experience/previous'] = "site/experience/my_experience_prev";
$route['my_experience/previous/(:any)'] = "site/experience/my_experience_prev/$1";
$route['new_experience'] = "site/experience/new_experience";
$route['manage_experience'] = "site/experience/manage_experience";
$route['manage_experience/(:any)'] = "site/experience/manage_experience/$1";
$route['add_experience_new'] = "site/experience/add_experience_new";
$route['experience_language_details/(:any)'] = "site/experience/experience_language_details/$1";
$route['experience_organization_details/(:any)'] = "site/experience/experience_organization_details/$1";
$route['experience_title/(:any)'] = "site/experience/experience_title/$1";
$route['tagline_experience/(:any)'] = "site/experience/tagline_experience/$1";
$route['what_we_do/(:any)'] = "site/experience/what_we_do/$1";
$route['where_we_will_be/(:any)'] = "site/experience/where_we_will_be/$1";
$route['what_you_will_provide/(:any)'] = "site/experience/what_you_will_provide/$1";
$route['notes_to_guest/(:any)'] = "site/experience/notes_to_guest/$1";
$route['about_exp_host/(:any)'] = "site/experience/about_exp_host/$1";
$route['group_size/(:any)'] = "site/experience/group_size/$1";
$route['price/(:any)'] = "site/experience/price/$1";
$route['finishing_toches/(:any)'] = "site/experience/finishing_toches/$1";
$route['experience_details/(:any)'] = "site/experience/experience_details/$1";
$route['schedule_experience/(:any)'] = "site/experience/schedule_experience/$1";
$route['experience_image/(:any)'] = "site/experience/experience_image/$1";
$route['location_details/(:any)'] = "site/experience/location_details/$1";
$route['guest_requirement/(:any)'] = "site/experience/guest_requirement/$1";
$route['experience_cancel_policy/(:any)'] = "site/experience/experience_cancel_policy/$1";
$route['view_experience/(:any)'] = "site/experience/view_experience/$1";
$route['experience_booking/(:any)'] = "site/experience/experience_guest_booking";
$route['Experience_Order/(:any)'] = "site/Experience_Order";
$route['Experience_Order/(:any)/(:any)'] = "site/Experience_Order";
$route['Experience_Order/(:any)/(:any)/(:any)'] = "site/Experience_Order";
$route['Experience_Order/(:any)/(:any)/(:any)/(:any)'] = "site/Experience_Order";
$route['experience-reservation'] = "site/experience/dashboard_listing_reservation";
$route['experience-reservation/(:any)'] = "site/experience/dashboard_listing_reservation/$1";
$route['experience-passed-reservation'] = "site/experience/dashboard_listing_pass_reservation";
$route['experience-passed-reservation/(:any)'] = "site/experience/dashboard_listing_pass_reservation/$1";
$route['experience-transactions'] = "site/experience/dashboard_account_trans";
$route['experience-transactions/(:any)'] = "site/experience/dashboard_account_trans/$1";
$route['experience-review'] = "site/experience/display_review";
$route['experience-review/(:any)'] = "site/experience/display_review/$1";
$route['experience-review1/(:any)'] = "site/experience/display_review1/$1";
$route['experience-review1'] = "site/experience/display_review1";
$route['experience-dispute'] = "site/experience/display_dispute";
$route['experience-dispute/(:any)'] = "site/experience/display_dispute/$1";
$route['experience-dispute1'] = "site/experience/display_dispute1";
$route['experience-dispute1/(:any)'] = "site/experience/display_dispute1/$1";
$route['experience-cancel_booking_dispute'] = "site/experience/cancel_booking_dispute";
$route['experience-cancel_booking_dispute/(:any)'] = "site/experience/cancel_booking_dispute/$1";
$route['experience_inbox'] = "site/experience/med_message";
$route['experience_inbox/(:any)'] = "site/experience/med_message/$1";
$route['experience_conversation/(:any)/(:any)'] = "site/experience/host_conversation/$1";
$route['guide-payment-success/(:any)/(:any)'] = "site/experience/guidepayment_success/$1";
/*Admin Routes*/
$route['admin'] = "admin/adminlogin";




/*Mobile Controllers*/
$route['json/currency_values'] = "site/mobile/currency_values"; // done
$route['android/(:any)'] = "site/mobile/mobilePages";
$route['ios/(:any)'] = "site/mobile/mobilePages";
$route['json/list_values'] = "site/Mobile/list_values"; // Done
$route['list_values'] = "site/Mobile/list_values"; 
$route['json/listing_type_values'] = "site/mobile/listing_type_values"; // Done
$route['json/discover'] = "site/mobile/discoverfeatured"; //Doubt
$route['json/rental-list'] = "site/mobile/rental_list"; //  Done.
$route['json/add_remove_wishlist_property'] = "site/mobile/mobile_add_remove_wishlist_property"; //Done

$route['json/create_wishlist'] = "site/mobile/mobile_create_wishlist"; //Done
$route['json/add_wishlist_property'] = "site/mobile/mobile_add_wishlist_property"; //done
$route['json/remove_wishlist_property'] = "site/mobile/mobile_remove_wishlist_property"; //done

$route['json/mobile_wishlist'] = "site/mobile/mobile_wishlist"; //Done
$route['json/mobile_wishlistview'] = "site/mobile/mobile_wishlistview"; //Done
$route['json/mobile_listvalue'] = "site/mobile/mobile_list_value"; // Pend add property
$route['json/mobile_update_list'] = "site/mobile/mobile_update_list"; // Pend
$route['json/mobile_listview'] = "site/mobile/mobile_listview"; //Done
$route['json/save_cancel_policy'] = "site/mobile/save_cancel_policy"; // later want to check
$route['json/rental_detail'] = "site/mobile/rental_detail"; // Done
$route['json/search_detail'] = "site/mobile/search_detail"; //city or state auto_suggest api
$route['json/mobile_signup'] = "site/mobile/mobile_signup"; // use it for FB and G+
$route['json/mobile_login'] = "site/mobile/mobile_login"; // Done
$route['json/mobile_forgotpsd'] = "site/mobile/mobile_forgotpsd";
$route['json/search_filter'] = "site/mobile/search_filter"; //dummy no controller
$route['json/created_property_status'] = "site/mobile/product_edit"; // Done property edit 
$route['json/mobile_updateprofile'] = "site/mobile/mobile_updateprofile"; // Done user profile update

$route['json/mobile_chat'] = "site/mobile/mobile_chat"; // want to work for discussion chat
$route['json/mobile_viewchat'] = "site/mobile/mobile_viewchat"; // want to work for discussion chat
$route['json/mobile_detailchat'] = "site/mobile/mobile_detailchat";  // want to work for discussion chat
$route['json/mobile_listspacetype'] = "site/mobile/mobile_listspacetype"; // Done Property Type
$route['json/mobile_roomtype'] = "site/mobile/mobile_roomtype"; // Done Room type values
$route['json/mobile_price_calculation'] = "site/mobile/mobile_price_calculation"; // price calc
$route['json/mobile_host_request'] = "site/mobile/mobile_host_request"; //Done book property rental
$route['json/mobile_your_trips'] = "site/mobile/mobile_your_trips"; // Done 
//$route['json/mobile_previous_trips'] = "site/mobile/mobile_previous_trips"; // Done 
//$route['json/mobile_your_reservation'] = "site/mobile/mobile_your_reservation"; //Done
$route['json/mobile_host_approval'] = "site/mobile/host_approval"; // Host Approved the booking
$route['json/mobile_host_decline'] = "site/mobile/host_decline"; // Host Decline the booking
$route['json/mobile_send_message'] = "site/mobile/send_message"; // send message the booking
$route['json/host_unlist_list'] = "site/mobile/host_unlist_list";
$route['json/host_delete_list'] = "site/mobile/host_delete_list"; // Delete property
$route['json/mobile_delete_image'] = "site/mobile/mobile_delete_image"; //delete property img
$route['json/transaction_history'] = "site/mobile/transaction_history";
$route['json/add_to_favourite'] = "site/mobile/add_to_favourite";
$route['json/remove_from_favourite'] = "site/mobile/remove_from_favourite";
$route['json/credit_card_form'] = "site/mobilecart/credit_card_form";
$route['mobile/success/(:any)'] = "site/mobilecart/pay_success";
$route['mobile/failed/(:any)'] = "site/mobilecart/pay_failed";
$route['mobile/payment/(:any)'] = "site/mobilecart/payment_return";
$route['json/property_image_delete'] = "site/mobile/mobile_propertyimage_delete";
//$route['mailsend'] = "site/contactform/index";
//$route['info'] = "site/contactform/info";
$route['json/inbox'] = "site/mobile/json_med_message"; // Done working
/**************************************10-06-2016****************************/
$route['json/property_values'] = "site/mobile/property_values";
$route['json/booking_values'] = "site/mobile/booking_values";
$route['json/custom_values'] = "site/mobile/custom_values";
//$route['json/quickSignup'] = "site/user/quickSignup";
//$route['json/quickSignupUpdate'] = "site/user/quickSignupUpdate";
//$route['json/registerUser1'] = "site/user/registerUser1";
//$route['json/registerUser'] = "site/user/registerUser";
//$roure['json/mlogin_user'] = "site/user/mlogin_user";
//$route['json/send_email_confirmation'] = "site/user/send_email_confirmation";
//$route['json/send_confirm_mail'] = "site/user/send_confirm_mail";
//$route['json/login_user'] = "site/user/login_user";
//$route['json/logout'] = "site/user/logout_user";
//$route['json/paypaldetail'] = "site/user/paypaldetail";
//$route['json/rentalEnquiry'] = "site/user/rentalEnquiry";
//$route['json/rentalEnquiry_booking'] = "site/user/rentalEnquiry_booking";
//$route['json/forgot_password_user'] = "site/user/forgot_password_user";
/*$route['json/add_follow'] = "site/user/add_follow";
$route['json/remove_fancy_item'] = "site/user/remove_fancy_item";
$route['json/delete_follow'] = "site/user/delete_follow";
$route['json/add_list_when_fancyy'] = "site/user/add_list_when_fancyy";
$route['json/add_item_to_lists'] = "site/user/add_item_to_lists";
$route['json/remove_item_from_lists'] = "site/user/remove_item_from_lists";
$route['json/add_want_tag'] = "site/user/add_want_tag";
$route['json/create_list'] = "site/user/create_list";
$route['json/list_space'] = "site/product/list_space";*/
/*Mobile Controllers*/

/*24.6.2016*/
/*$route['json/mobile_product_get/(:any)'] = "site/user/jsonproductget/$1";
$route['json/mobile_booking_get/(:any)'] = "site/user/jsonbookingget/$1";
$route['json/mobile_listing/(:any)'] = "site/user/json_dashboard_listing/$1"; // manage listing
*/
/*27.6.2016*/
//$route['json/inbox'] = "site/user/json_med_message";
/*$route['json/dashboard'] = "site/user/json_dashboard"; 
$route['json/listing-reservation'] = "site/user/json_dashboard_listing_reservation";
*/

/*28.6.2016*/
/*$route['json/mobile_add_space'] = "site/product/mobile_add_space";
$route['json/manage_listing/(:any)'] = "site/product/json_manage_listing/$1";
$route['json/price_listing/(:any)'] = "site/product/json_price_listing/$1";*/

/*29.6.2016*/
//$route['json/property'] = "site/rentals/json_mapview/$1";

/*******8/7/2016*********/
$route['json/logout'] = "site/user/json_logout_user";
// vinod 
$route['json/property_home'] = "site/mobile/home_property_info";
$route['json/language_list'] = "site/mobile/mobile_lang_list"; 
$route['json/mobile_add_property_step1'] = "site/mobile/mobile_add_property_step1";
$route['json/mobile_add_property_step2'] = "site/mobile/mobile_add_property_step2";
$route['json/mobile_add_property_step3'] = "site/mobile/mobile_add_property_step3";
$route['json/mobile_add_property_step4'] = "site/mobile/mobile_add_property_step4";
$route['json/mobile_add_property_step5'] = "site/mobile/mobile_add_property_step5";
$route['json/mobile_add_property_step6'] = "site/mobile/mobile_add_property_step6";
$route['json/mobile_add_property_step7'] = "site/mobile/mobile_add_property_step7";
$route['json/mobile_add_property_step8'] = "site/mobile/mobile_add_property_step8";
$route['json/mobile_add_property_step9'] = "site/mobile/mobile_add_property_step9";

$route['json/mobile_get_currency_symbol'] = "site/mobile/mobile_get_currency_symbol";
$route['json/mobile_transaction_history'] = "site/mobile/mobile_transaction_history";
$route['json/mobile_user_details'] = "site/mobile/json_user_details";
$route['json/mobile_user_account_details'] = "site/mobile/json_user_account";
$route['json/mobile_updateaccount'] = "site/mobile/mobile_update_account"; // Done user account update
$route['json/inbox_conversation'] = "site/mobile/json_inbox_conversation";
$route['json/inbox_conversation1'] = "site/mobile/json_inbox_conversation1";
$route['json/rest_password'] = "site/mobile/mobile_reset_password";
$route['json/more_abt_host'] = "site/mobile/mobile_about_host";


//payment gateway
$route['json/trip_pay_by_credit_card'] = "site/mobilecart/PaymentCredit";
$route['json/trip_pay_by_stripe'] = "site/mobilecart/UserPaymentCreditStripe";
$route['json/trip_pay_by_paypal'] = "site/mobilecart/PaymentProcess";
$route['json/listing_pay_by_stripe'] = "site/mobilecart/HostPaymentCredit";
$route['json/listing_pay_by_paypal'] = "site/mobilecart/HostPayment";

$route['json/pay_by_paypal'] = "site/mobilecart/PaymentProcess";
$route['mobilecart/(:any)'] = "site/mobilecart";
$route['mobile-host-payment-success/(:any)'] = "site/mobilecart/hostpayment_success/$1";
$route['json/list_paypal_success'] = "site/mobilecart/host_paypal_success";
$route['json/trip_paypal_success'] = "site/mobilecart/trip_paypal_success";

$route['json/add_review'] = "site/mobile/mobile_add_review";
$route['json/add_dispute'] = "site/mobile/mobile_add_dispute";
$route['json/your_review'] = "site/mobile/mobile_your_review";
$route['json/your_dispute'] = "site/mobile/mobile_your_dispute";

$route['json/trust_verification_validator'] = "site/mobile/trust_verification_validator";$route['json/trust_verification'] = "site/mobile/trust_verification";$route['json/your_review'] = "site/mobile/mobile_your_review";


$route['json/test_api'] = "site/mobile/test_api"; // done
$route['json/test_api_static'] = "site/mobile/test_api_static"; // done
$route['json/test_api_get'] = "site/mobile/test_api_get"; // done
$route['json/test_api_post'] = "site/mobile/test_api_post"; // done
$route['json/test_page'] = "site/mobile/test_page"; // done

$route['load_places_pagination'] = "site/product/load_places_pagination"; // done
$route['load_experience_pagination'] = "site/experience/load_experience_pagination";
$route['load_popular_pagination'] = "site/rentals/load_popular_pagination";
$route['load_wishlist_pagination'] = "site/wishlists/load_wishlist_pagination";

/*Mobile Controllers for Experience*/
$route['json/explore_experience'] = "site/mobile/explore_experience/$1";
$route['json/explore_experience/(:any)']  = "site/mobile/explore_experience/$1";
$route['json/view_experience_details']  = "site/mobile/view_experience_details";
$route['json/add_wishlist_experience'] = "site/mobile/mobile_add_wishlist_experience";
$route['json/remove_wishlist_experience'] = "site/mobile/mobile_remove_wishlist_experience";
$route['json/experience_paypal_success'] = "site/mobilecart/experience_paypal_success";

$route['facebooklogin'] = "site/landing/facebooklogin";
/**********************************/
/* End of file routes.php */
/* Location: ./application/config/routes.php */