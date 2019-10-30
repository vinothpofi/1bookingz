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
$route['rental/(:any)'] = 'site/landing/display_product_detail/$1';
$route['manage_listing/(:any)'] = "site/product/manage_listing/$1";
$route['price_listing/(:any)'] = "site/product/price_listing/$1";
$route['update_price_listing/(:any)'] = "site/product/update_price_listing/$1";
$route['overview_listing/(:any)'] = "site/product/overview_listing/$1";
$route['insert_overview_listing/(:any)'] = "site/product/insert_overview_listing/$1";
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
