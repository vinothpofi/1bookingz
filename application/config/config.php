<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$config['index_page'] = '';
$config['uri_protocol']	= 'REQUEST_URI';
$config['url_suffix'] = '';
$config['language']	= 'english';
$config['charset'] = 'UTF-8';
$config['enable_hooks'] = FALSE;
$config['subclass_prefix'] = 'MY_';
$config['composer_autoload'] = FALSE;
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';
$config['allow_get_array'] = TRUE;
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';
$config['error_views_path'] = '';
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;
$config['encryption_key'] = '';
$config['sess_driver'] = 'files';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_expiration'] = 7200;
$config['sess_save_path'] = FCPATH . 'application/cache/sessions/';
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;
$config['sess_regenerate_destroy'] = FALSE;
$config['cookie_prefix']	= '';
$config['cookie_domain']	= '';
$config['cookie_path']		= '/';
$config['cookie_secure']	= FALSE;
$config['cookie_httponly'] 	= FALSE;
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = FALSE;
$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_test_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';
$config['site_pagination_per_page'] = '8';
$config['admin_name'] = 'admin';

/*Loading admin settings*/
foreach (glob("commonsettings/*.php") as $filename)
{
	if (is_file($filename))
	{
	    require_once $filename;
	}
}

//$config['adminPrev'] = array('Members','Host','Properties','Finance','List','Accounts','BookingStatus','Experience','ExperienceFinance','ExperienceAccounts','ExperienceBookingStatus','ExperienceCommission','ListSpace','Listing','Couponcode','Newsletter','ManageCountry','Pages','City','Commission','PaymentGateway','Language','Slider','Prefooter','Backup','Review','Currency','ContactUs','Dispute','Help');

$config['adminPrev'] = array('Members','Host','Rentals','Rental Transaction','Amenities','Rental Booking Status','Experience','Experience Transaction','Experience Booking Status','Rental Types','Features','Coupon code','Newsletter','Manage Country','Pages','City','Commission','Payment Gateway','Language','Banner','Prefooter','Backup','Review','Dispute','Currency','Enquiries','FAQ Management','Reports');
