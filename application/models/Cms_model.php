<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to cms management
 *
 * @author Teamtweaks
 *
 */
class Cms_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_all_details($table = '', $condition = '', $sortArr = '', $ignore_id = '')
	{
		//echo 'here'; exit;
		if ($sortArr != '' && is_array($sortArr)) {
			foreach ($sortArr as $sortRow) {
				if (is_array($sortRow)) {
					$this->db->order_by($sortRow['field'], $sortRow['type']);
				}
			}
		}
		return $this->db->get_where($table, $condition);
	}

	function booked_rental($prd_id = '')
	{
		$this->db->select('pb.*,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
	}

	function booked_rental_future($prd_id = '', $pageLimitStart, $searchPerPage)
	{
		$langarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

		$cur_date = date('Y-m-d');
		$this->db->select('pb.*,pa.zip as post_code,pa.address,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.product_title'.$langarray.',p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId,rq.renter_id, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno,rq.user_currencycode,rq.currency_cron_id,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.dval,pay.total_amt,pay.price as paid_amount,pay.currency_code,pay.coupon_code');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as pay', 'pay.EnquiryId = rq.id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) >= "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $this->db->get();
	}

	function booked_rental_future_site_map($prd_id = '')
	{
		$cur_date = date('Y-m-d');
		$this->db->select('pb.*,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) >= "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
	}
	
	function past_reservation_total_rows($prd_id = ''){
		$cur_date = date('Y-m-d');
		$this->db->select('pb.*,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) < "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();	
	}
	

	function booked_rental_passed($prd_id = '', $pageLimitStart, $searchPerPage)
	{
		$langarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

		$cur_date = date('Y-m-d');
		$this->db->select('pb.*,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.product_title'.$langarray.',p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.dispute_by,rq.cancelled,rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno,rq.user_currencycode,rq.currency_cron_id');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) < "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $this->db->get();
	}

	function booked_rental_trans($prd_id = '')
	{
		$filter_field = $this->uri->segment(2);
		$filter_value = $this->uri->segment(3);
		$booking_status = $this->uri->segment(4);
		$this->db->select('bookingId');
		$this->db->from(HOSTPAYMENT);
		$hostPaidResult = $this->db->get();
		$hostPaidIds = array();
		foreach ($hostPaidResult->result_array() as $hostPaidId) {
			$hostPaidIds[] = $hostPaidId['bookingId'];
		}
		$this->db->select('pb.*, pa.zip as post_code, pa.address, pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.product_name,p.home_type,p.product_title,p.price,p.currency, u.firstname,u.image, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.numofdates, rq.user_id as GestId, py.id as PaymentId, py.status as PaymentStatus, rq.totalAmt, rq.Bookingno');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', 'pa.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->join(COMMISSION_TRACKING . ' as cm', 'cm.host_email = u.email');
		$this->db->where('p.user_id = ' . $prd_id);
		if ($filter_field != '' && $filter_value != "") {
			$filter_value = str_replace("-", " ", $filter_value);
			if ($filter_field != 'created') {
				$this->db->where('py.' . $filter_field . ' = "' . $filter_value . '"');
			} else {
				$this->db->where(MONTH . '(py.' . $filter_field . ') = ' . $filter_value);
				$this->db->where(YEAR . '(py.' . $filter_field . ') = ' . date('Y'));
			}
		}
		if ($booking_status != '') {
			$this->db->where('rq.booking_status', $booking_status);
		}
		$this->db->where('py.status', 'Paid');
		if (!empty($hostPaidIds)) $this->db->where_not_in('rq.Bookingno', $hostPaidIds);
		$this->db->group_by('py.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$data['rental'] = $this->db->get();
		$this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
								c.name as country_name,
								s.name as state_name,
								ci.name as city_name,
								p.product_name,p.home_type,p.product_title,p.price,p.currency,
								u.firstname,u.image,
								rq.id as EnqId,rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.numofdates,rq.user_id as GestId,py.id as PaymentId,py.status as PaymentStatus');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = pb.product_id', 'left');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		if ($filter_field != '' && $filter_value != "") {
			$filter_value = str_replace("-", " ", $filter_value);
			if ($filter_field != 'created') {
				$this->db->where('py.' . $filter_field . ' = "' . $filter_value . '"');
			} else {
				$this->db->where(MONTH . '(py.' . $filter_field . ') = ' . $filter_value);
				$this->db->where(YEAR . '(py.' . $filter_field . ') = ' . date('Y'));
			}
		}
		$this->db->where('rq.booking_status', 'Booked');
		$this->db->where('py.status', 'Paid');
		$this->db->group_by('py.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$booked_rental_count = $this->db->get();
		$data['booked_rental_count'] = $booked_rental_count->num_rows();
		$this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
								c.name as country_name,
								s.name as state_name,
								ci.name as city_name,
								p.product_name,p.home_type,p.product_title,p.price,p.currency,
								u.firstname,u.image,
								rq.id as EnqId,rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.numofdates,rq.user_id as GestId,py.id as PaymentId,py.status as PaymentStatus');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = pb.product_id', 'left');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		if ($filter_field != '' && $filter_value != "") {
			$filter_value = str_replace("-", " ", $filter_value);
			if ($filter_field != 'created') {
				$this->db->where('py.' . $filter_field . ' = "' . $filter_value . '"');
			} else {
				$this->db->where(MONTH . '(py.' . $filter_field . ') = ' . $filter_value);
				$this->db->where(YEAR . '(py.' . $filter_field . ') = ' . date('Y'));
			}
		}
		$this->db->where('rq.booking_status', 'Pending');
		$this->db->where('py.status', 'Paid');
		$this->db->group_by('py.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$pending_rental_count = $this->db->get();
		$data['pending_rental_count'] = $pending_rental_count->num_rows();
		return $data;
	}

	/* Gross Earning */
	public function gross_earning()
	{
		$filter_field = $this->uri->segment(2);
		$filter_value = $this->uri->segment(3);
		$this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
								c.name as country_name,
								s.name as state_name,
								hp.amount, hp.txn_id, hp.txt_date,hp.txn_type,
								ci.name as city_name,
								p.product_name,p.home_type,p.product_title,p.price,p.currency,
								u.firstname,u.image,
								rq.id as EnqId,rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.numofdates,rq.user_id as GestId,py.id as PaymentId,py.status as PaymentStatus,rq.serviceFee,rq.totalAmt');
		$this->db->from(PRODUCT_BOOKING . ' as pb');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = pb.product_id', 'left');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.product_id');
		$this->db->join(RENTALENQUIRY . ' as rq', 'p.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		$this->db->join(HOSTPAYMENT . ' as hp', 'hp.bookingId = rq.Bookingno');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('rq.booking_status', 'Booked');
		if ($filter_field != '' && $filter_value != "") {
			if ($filter_field == 'year') {
				$this->db->where(YEAR . '(py.created) = ' . $filter_value);
			} else if ($filter_field == 'created') {
				$this->db->where(MONTH . '(py.created) = ' . $filter_value);
				$this->db->where(YEAR . '(py.created) = ' . date('Y'));
			}
		}
		$this->db->where('py.status', 'Paid');
		$this->db->group_by('py.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
	}
	/* Gross Earning End */
	/* booking the property details */
	function booking_rental($prd_id = '')
	{
		$this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
								c.name as country_name,
								s.name as state_name,
								ci.name as city_name,
								p.product_name,p.product_title,p.price,p.currency,
								u.firstname,u.image');
		$this->db->from(CALENDARBOOKING . ' as pb');
		//$this->db->from(PAYMENT.' as py');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = pb.PropId', 'left');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.PropId');
		$this->db->join(USERS . ' as u', 'u.id = p.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		return $this->db->get();
	}

	/*get date group by PropId */
	public function DategroupbyPropID($prd_id = '')
	{
		$this->db->select('the_date');
		$this->db->from(CALENDARBOOKING);
		$this->db->group_by('PropId');
		return $this->db->get();
	}

	public function get_cms_details()
	{
		$this->db->select('description');
		$this->db->from(CMS);
		$this->db->where('seourl', 'howitwork');
		return $this->db->get();
	}

	public function get_cmsbusiness_details()
	{
		$this->db->select('description');
		$this->db->from(CMS);
		$this->db->where('seourl', 'business-travel');
		return $this->db->get();
	}

	public function get_cmscontact_details()
	{
		$this->db->select('description');
		$this->db->from(CMS);
		$this->db->where('seourl', 'contact-us');
		return $this->db->get();
	}

	public function get_cms_learnmore()
	{
		$this->db->select('description');
		$this->db->from(CMS);
		$this->db->where('seourl', 'learn-more');
		return $this->db->get();
	}

	/* Enquiry Display  */
	function booking_Enquiry($prd_id = '')
	{
		$this->db->select('pb.*,pa.post_code,pa.address,pa.apt,
								c.name as country_name,
								s.name as state_name,
								ci.name as city_name,
								p.product_name,p.product_title,p.price,p.currency,
								u.firstname,u.image');
		$this->db->from(RENTALENQUIRY . ' as pb');
		//$this->db->from(PAYMENT.' as py');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = pb.prd_id', 'left');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = pb.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = p.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->order_by('pb.dateAdded');
		return $this->db->get();
	}

	public function booked_rental_trip($prd_id = '', $keyword, $pageLimitStart, $searchPerPage)
	{
		$this->db->select('rq.prd_id as product_id, rq.dispute_by,rq.cancelled, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.seourl,p.host_status,p.cancel_percentage,p.user_id,p.security_deposit, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,rq.currency_cron_id,rq.currencyPerUnitSeller,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.dval,pay.total_amt,pay.currency_code,pay.sumtotal');
		$this->db->from(RENTALENQUIRY . ' as rq');
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		$this->db->join(PAYMENT . ' as pay', 'pay.EnquiryId = rq.id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ', $prd_id);
		$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		if ($keyword != "") {
			$this->db->where("(p.product_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		//$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->order_by('rq.id', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $this->db->get();
	}

	public function booked_rental_trip_site_map($prd_id = '', $keyword)
	{
		//print_r($prd_id);
		$this->db->select('rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title,p.price,p.currency,p.host_status,p.user_id,p.security_deposit, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,rq.currencyPerUnitSeller,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.dval,pay.total_amt','pay.currency_code');
		$this->db->from(RENTALENQUIRY . ' as rq');
		//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		//$this->db->join(PAYMENT.' as pay' , 'pay.product_id = p.id','left');
		$this->db->join(PAYMENT . ' as pay', 'pay.EnquiryId = rq.id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ', $prd_id);
		$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		if ($keyword != "") {
			$this->db->where("(p.product_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
			//$this->db->or_like('u.firstname',$keyword);
			//$this->db->or_like('pn.address',pn.address);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		//$this->db->order_by('rq.id', 'desc');
		/* $this->db->get();
        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	/* My function */
	public function booked_rental_trip1($prd_id = '', $keyword)
	{
		$this->db->select('rq.*,rq.id as ID');
		$this->db->from(RENTALENQUIRY . ' as rq');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', 'pa.product_id = rq.prd_id');
		$this->db->join(LOCATIONS . ' as c', 'c.id = pa.country', 'left');
		$this->db->join(STATE_TAX . ' as s', 's.id = pa.state', 'left');
		$this->db->join(CITY . ' as ci', 'ci.id = pa.city', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		//$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded');
		$this->db->get();
		//echo $this->db->last_query();die;
		return $this->db->get();
		// $this->db->select('pb.*,pa.post_code,pa.address,pa.apt,pp.product_image,
		// c.name as country_name,
		// s.name as state_name,
		// ci.name as city_name,
		// p.product_name,p.product_title,p.price,p.currency,
		// u.firstname,u.image,
		// rq.booking_status,rq.checkin,rq.checkout,rq.dateAdded,rq.user_id as GestId,rq.renter_id');
		// $this->db->from(PRODUCT_BOOKING.' as pb');
		// $this->db->join(PRODUCT_ADDRESS.' as pa' , 'pa.product_id = pb.product_id','left');
		// $this->db->join(LOCATIONS.' as c' , 'c.id = pa.country','left');
		// $this->db->join(STATE_TAX.' as s' , 's.id = pa.state','left');
		// $this->db->join(CITY.' as ci' , 'ci.id = pa.city','left');
		// $this->db->join(PRODUCT.' as p' , 'p.id = pb.product_id','left');
		// $this->db->join(PRODUCT_PHOTOS.' as pp' , 'p.id = pp.product_id','left');
		// $this->db->join(RENTALENQUIRY.' as rq' , 'p.id = rq.prd_id');
		// $this->db->join(USERS.' as u' , 'u.id = rq.renter_id');
		// $this->db->where('rq.user_id = '.$prd_id);
		// $this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		// if($keyword !="")
		// {
		// $this->db->like('p.product_title',$keyword);
		// $this->db->or_like('u.firstname',$keyword);
		// $this->db->or_like('pa.address',$keyword);
		// }
		// $this->db->group_by('rq.id');
		// $this->db->order_by('rq.dateAdded');
		// $this->db->get();
		// echo $this->db->last_query();die;
		// return $this->db->get();
	}

	/* My function End */
	function booked_rental_trip_prev($prd_id = '', $product_title, $pageLimitStart, $searchPerPage)
	{
	$langarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

		$this->db->select(' rq.cancelled,rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title'.$langarray.',p.price,p.currency,p.seourl, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.user_currencycode,rq.currency_cron_id,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt','pay.currency_code');
		$this->db->from(RENTALENQUIRY . ' as rq');
		//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		$this->db->join(PAYMENT . ' as pay', 'pay.product_id = p.id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE);
		if ($product_title != "") {
			$this->db->like('p.product_title', $keyword);
			$this->db->or_like('u.firstname', $keyword);
			$this->db->or_like('pn.address', $keyword);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		/* $this->db->get();

        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	function booked_rental_trip_prev_site_map($prd_id = '', $product_title)
	{
		$list_valuelangarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($list_valuelangarray)>0) {
            $list_valuelangarray=",".implode(",",$list_valuelangarray);
        } else $list_valuelangarray="";
		$this->db->select(' rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title'.$list_valuelangarray.',p.price,p.currency, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt');
		$this->db->from(RENTALENQUIRY . ' as rq');
		//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		$this->db->join(PAYMENT . ' as pay', 'pay.product_id = p.id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE);
		if ($product_title != "") {
			$this->db->like('p.product_title', $keyword);
			$this->db->or_like('u.firstname', $keyword);
			$this->db->or_like('pn.address', $keyword);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		/* $this->db->get();

        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	public function get_dashboard_list($userId = '', $status = '', $pageLimitStart, $searchPerPage)
	{
		$this->db->select('p.*,pp.product_image,pa.lat as latitude,s.data as shedule,hs.payment_status,u.id_verified');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->join('schedule as s', "s.id=p.id", "LEFT");
		$this->db->join(HOSTPAYMENT . ' as hs', "hs.product_id=p.id", "LEFT");
		$this->db->join(USERS . ' as u', 'u.id = p.user_id', "LEFT");
		$this->db->where_in('p.user_id', $userId);
		if ($status != '') {
			$this->db->where('p.status', $status);
		}
		$this->db->group_by('p.id');
		$this->db->order_by('p.id', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get();
	}

	public function get_dashboard_list_site_map($condition = '', $Cont2 = '')
	{
		$this->db->select('p.*,pp.product_image,pa.lat as latitude,s.data as shedule,hs.payment_status,u.id_verified');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->join('schedule as s', "s.id=p.id", "LEFT");
		$this->db->join(HOSTPAYMENT . ' as hs', "hs.product_id=p.id", "LEFT");
		$this->db->join(USERS . ' as u', 'u.id = p.user_id', "LEFT");
		$this->db->where_in('p.user_id', $condition);
		if ($Cont2 != '') {
			$this->db->where('p.status', $Cont2);
		}
		$this->db->group_by('p.id');
		$this->db->order_by('p.id', 'desc');
		return $query = $this->db->get();
	}

	public function get_rental_list($user_id)
	{
		$this->db->select('*');
		$this->db->from(PRODUCT);
		$this->db->where('status', 'Publish');
		$this->db->where('user_id', $user_id);
		return $this->db->get();
	}

	public function get_countries()
	{
		$this->db->select('id,contid,country_code,name,seourl');
		$this->db->from(COUNTRY_LIST);
		$this->db->where('status', 'Active');
		$this->db->order_by('name', 'asc');
		return $this->db->get();
	}

	public function get_discussion($user_id)
	{
		$this->db->select('d.message,u.email');
		$this->db->from(DISCUSSION . ' as d');
		$this->db->join(USERS . ' as u', 'u.id = d.receiver_id', 'left');
		$this->db->where('d.receiver_id', $user_id);
		$this->db->order_by('d.id', 'desc');
		return $this->db->get();
	}

	public function get_all_discussion($user_id)
	{
		$this->db->from(DISCUSSION);
		$this->db->where('receiver_id', $user_id);
		$this->db->order_by('id', 'desc');
		$data['inbox'] = $this->db->get();
		$this->db->from(DISCUSSION);
		$this->db->where('sender_id', $user_id);
		$this->db->order_by('id', 'desc');
		$data['sent'] = $this->db->get();
		$this->db->select('sender_id,receiver_id');
		$this->db->from(DISCUSSION);
		$this->db->where('sender_id', $user_id);
		$this->db->or_where('receiver_id', $user_id);
		$users = $this->db->get()->result_array();
		$users_ids = array();
		foreach ($users as $user) {
			if (!in_array($user['sender_id'], $users_ids)) {
				$users_ids[] = $user['sender_id'];
			}
			if (!in_array($user['receiver_id'], $users_ids)) {
				$users_ids[] = $user['receiver_id'];
			}
		}
		if (count($users_ids) == 0) {
			$users_ids = array('0');
		}
		$this->db->select('id,firstname,lastname');
		$this->db->from(USERS);
		$this->db->where_in('id', $users_ids);
		$users_details = $this->db->get();
		foreach ($users_details->result() as $users_detail) {
			$userDetails[$users_detail->id] = $users_detail->firstname . ' ' . $users_detail->lastname;
		}
		$data['userDetails'] = $userDetails;
		return $data;
	}

	public function get_med_messages($userId, $pageLimitStart='', $searchPerPage='',$booking_nos='')
	{
        //$booking_nos=implode(',',$booking_nos);
        //$booking_nos="1,2";
		//$sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=0 AND m.receiverId=" . $userId . " and m.bookingNo in (".$booking_nos.") group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;

        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count ",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('m.receiverId', $userId);
        // $this->db->or_where('m.senderId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();

        return $result->result();
	}

	public function get_med_messages_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND  m.msg_status=0 AND  m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();
	}

	/*Starred Message*/ 
	public function get_med_messages_starred($userId, $pageLimitStart='', $searchPerPage='',$booking_nos='')
	{
		//$sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=0 AND m.msg_star_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;		$result = $this->db->query($sql);



        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('m.msg_star_status','Yes');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();



        return $result->result();
	}


	public function get_med_messages_starred_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND  m.msg_status=0 AND m.msg_star_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();
	}
	/*End Starred Message*/ 

	/*Unread Message*/ 
	public function get_med_messages_unread($userId, $pageLimitStart='', $searchPerPage='',$booking_nos='')
	{
		//$sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=0 AND m.msg_read='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;		$result = $this->db->query($sql);

        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','0');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();
		return $result->result();

	}
	public function get_med_messages_unread_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND m.msg_status=0 AND m.msg_read='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();
	}
	/*End Unread Message*/ 

	/*Archived Message*/
	public function get_med_messages_archived($userId, $pageLimitStart='', $searchPerPage='',$booking_nos='')
	{
		//$sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=1 AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;		$result = $this->db->query($sql);		return $result->result();

        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','1');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();
        return $result->result();

	}
	public function get_med_messages_archived_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND  m.msg_status=1 AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();
	}
	/*End Archived Message*/ 
	/*Pending Request*/
	public function get_med_messages_pending_request( $userId,$pageLimitStart='', $searchPerPage='',$booking_nos='')
	{
		// $sql = "SELECT m.* ,re.booking_status,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , ".RENTALENQUIRY." as re join " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=0 AND m.user_archive_status='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;		$result = $this->db->query($sql);		return $result->result();
		// $sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u join " . RENTALENQUIRY . " as re   WHERE m.productId=p.id AND m.msg_status=0 AND m.user_archive_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;	


		$this->db->select('m.* ,RQ.booking_status,RQ.approval,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . MED_MESSAGE . ' as ms,' . PRODUCT . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(MED_MESSAGE . ' as m');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Pending');
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		$result = $this->db->get();
		return $result->result();
	}
	public function get_med_messages_pending_request_site_map($userId)
	{
		// $sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND  m.msg_status=0 AND m.user_archive_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();

		$this->db->select('m.* ,RQ.booking_status,RQ.approval,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . MED_MESSAGE . ' as ms,' . PRODUCT . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(MED_MESSAGE . ' as m');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Pending');
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$result = $this->db->get();
		return $result->result();
	}
	/*End Pending Request*/ 

	/*Reservations*/
	public function get_med_messages_reservations($userId, $pageLimitStart='', $searchPerPage='',$booking_nos='')
	{

		$this->db->select('m.* ,RQ.booking_status,RQ.approval,U.firstname,U.lastname,U.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . MED_MESSAGE . ' as ms,' . PRODUCT . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(MED_MESSAGE . ' as m');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('(RQ.approval="Accept" or RQ.approval="Decline")');
		//$this->db->or_where('RQ.approval=','Decline');
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		$result = $this->db->get();
		return $result->result();
	}
	public function get_med_messages_reservations_site_map($userId)
	{
		$this->db->select('m.* ,RQ.booking_status,RQ.approval,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . MED_MESSAGE . ' as ms,' . PRODUCT . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(MED_MESSAGE . ' as m');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Accept');
		$this->db->or_where('RQ.approval=','Decline');
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$result = $this->db->get();
		return $result->result();
	}
	/*End Reservations*/ 
	public function get_featured_transaction($email, $pageLimitStart, $searchPerPage)
	{
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname,U.image, P.id as product_id,P.seourl, P.product_title, P.price, RQ.currencycode,RQ.Bookingno,RQ.currencyPerUnitSeller,RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currency_cron_id,RQ.cancelled,RQ.dispute_by,RQ.subTotal,RQ.prd_price,RQ.secDeposit, CT.total_amount as totalAmt, CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(COMMISSION_TRACKING . ' as CT');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = CT.booking_no', 'LEFT');
		$this->db->join(PRODUCT . ' as P', 'P.id = RQ.prd_id', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = RQ.user_id', 'LEFT');
		$this->db->where('CT.host_email', $email);
		$this->db->where('CT.paid_status', 'no');
		//$this->db->where('RQ.cancelled', 'No');
		$this->db->order_by('CT.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_featured_transaction_site_map($email)
	{
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.id as product_id, P.product_title, P.price, RQ.currencycode,RQ.Bookingno,RQ.currencyPerUnitSeller,RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.subTotal,RQ.secDeposit, CT.total_amount as totalAmt, CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(COMMISSION_TRACKING . ' as CT');
		$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = CT.booking_no', 'LEFT');
		$this->db->join(PRODUCT . ' as P', 'P.id = RQ.prd_id', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = RQ.user_id', 'LEFT');
		$this->db->where('CT.host_email', $email);
		$this->db->where('CT.paid_status', 'no');
        //$this->db->where('RQ.cancelled', 'No');
		$this->db->order_by('CT.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}

	public function get_completed_transaction($email, $pageLimitStart, $searchPerPage)
	{
		$this->db->select('CP.dateAdded, CP.transaction_id,CP.amount, C.*,RE.currencycode,RE.user_currencycode,RE.cancelled,RE.currency_cron_id');
        $this->db->from(COMMISSION_PAID . ' as CP');
		$this->db->join(COMMISSION_TRACKING . ' as C', 'C.commission_paid_id=CP.id', 'LEFT');
		$this->db->join(RENTALENQUIRY . ' as RE', 'RE.Bookingno=C.booking_no', 'LEFT');
		$this->db->where('CP.host_email', $email);
		//$this->db->where('RE.cancelled', 'No');
		$this->db->order_by('CP.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_completed_transaction_site_map($email)
	{
		$this->db->select('CP.dateAdded, CP.transaction_id ,CP.amount');
		$this->db->from(COMMISSION_PAID . ' as CP');
        $this->db->join(COMMISSION_TRACKING . ' as C', 'C.commission_paid_id=CP.id', 'LEFT');
        $this->db->join(RENTALENQUIRY . ' as RE', 'RE.Bookingno=C.booking_no', 'LEFT');
		$this->db->where('CP.host_email', $email);
        //$this->db->where('RE.cancelled', 'No');
		$this->db->order_by('CP.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}

	public function get_user_details($id)
	{
		$this->db->select('*');
		$this->db->from(USERS);
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function get_user_details_inv($id)
	{
		$this->db->reconnect();
		$Query = "SELECT *, pu.id,(select count(user_id) from " . PAYMENT . " where user_id=pu.id and status='Paid') as cnt ,(select count(host_id) from " . HOSTPAYMENT . " where host_id=pu.id and payment_status='paid') as cnt1 FROM " . INVITE . " pi left join " . USERS . " pu on pu.email=pi.email left join " . HOSTPAYMENT . " pa on pa.host_id=pu.id where pi.sender_id='" . $id . "' and pi.status='Active'";
		//echo $Query; exit;
		return $this->ExecuteQuery($Query);
	}

	public function get_all_details_email($row)
	{
		$this->db->select('*');
		$this->db->from(INVITE);
		$this->db->where('email', $row);
		$query = $this->db->get();
		return $query->result();
	}

	public function paid_details()
	{
		$this->db->select('*');
		$this->db->from(PAYMENT);
		$this->db->where('user_id', 298);
		$this->db->where('status', 'Paid');
		$query = $this->db->get();
		return $qq = $query->num_rows();
	}

	public function get_all_details_invite_pay($id)
	{
		$this->db->select('*');
		$this->db->from(INVITE_PAY);
		$this->db->where('sender_id', $id);
		$this->db->where('status', 'Active');
		$invitepay = $this->db->get();
		return $invitepay->result();
	}
	public function get_booking_no_from_messages($user_id,$con){
        $this->db->select('m.bookingNo');
        $this->db->from(MED_MESSAGE.' as m');
        if($con=='1'){
            /*stared*/
            //$this->db->where('m.msg_star_status','Yes');
            //$this->db->or_where('receiverId', $user_id);
        }
        if($con=='2'){
            /*unread*/
          //  $this->db->where('m.msg_status','0');
           // $this->db->where('m.msg_read','No');
        }
        $this->db->where('senderId', $user_id);
        $this->db->group_by('bookingNo');
        $invitepay = $this->db->get();
        //echo $this->db->last_query();
        return $invitepay->result();
    }
    public function msg_unread_counts_all($userId){
        //msg_unread_count
        $result=array();
        //all unread
        $this->db->select("(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count_total ",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('m.receiverId', $userId);
        $this->db->group_by('m.bookingNo');
        $result['all'] = $this->db->get()->num_rows();

        //starred

        $this->db->select("(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count_starred",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_star_status','Yes');
        $this->db->where('m.receiverId', $userId);
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');

        $result['starred'] = $this->db->get()->num_rows();

        //unread

        $this->db->select("(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count_unread",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','0');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userId);
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        $result['unread'] = $this->db->get()->num_rows();

        return $result;

    }
    public function get_cms_page_with_menu_details($lang='',$seourl='',$top_menu=''){
        $this->db->select('*');
        $this->db->from(CMS.' as c');
        $this->db->join(CMS_TOP_MENU . ' as cm', 'cm.top_menu_id=c.top_menu_id', 'LEFT');
        if($lang=='') {
            $this->db->where('c.lang_code', 'en');
        }else{
            $this->db->where('c.seourl', $seourl);
        }
        if($top_menu!=''){
            $this->db->where('c.top_menu_id', $top_menu);
        }
        $this->db->order_by('c.view_order', 'Asc');
        return $this->db->get();
    }

}
