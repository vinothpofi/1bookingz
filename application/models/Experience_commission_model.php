<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class Experience_commission_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_commission_tracking($sellerEmails)
	{
		$Query = "select c.* ,ed.booking_no,ed.status as dis_status, re.prd_id,re.currencycode,re.secDeposit,re.renter_id,re.currencyPerUnitSeller,re.cancelled,re.Bookingno,re.checkin,re.user_currencycode,re. currency_cron_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . EXPERIENCE_DISPUTE . " ed on ed.booking_no=c.booking_no where `host_email`='" . $sellerEmails . "'";
		//print_r($Query);
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_all_commission_tracking_with_date($sellerEmails,$from_date,$to_date)
	{
		$Query = "select c.* ,ed.booking_no,ed.status as dis_status, re.prd_id,re.currencycode,re.secDeposit,re.renter_id,re.currencyPerUnitSeller,re.cancelled,re.Bookingno,re.checkin,re.user_currencycode,re. currency_cron_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . EXPERIENCE_DISPUTE . " ed on ed.booking_no=c.booking_no where `host_email`='" . $sellerEmails . "' AND (c.dateAdded BETWEEN '".$from_date."' AND '".$to_date."')";
		//print_r($Query);
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_paid_details($sellerEmails)
	{
		//total_amount
		$Query = "select c.* , re.prd_id,re.currencycode,re.subtotal,re.currencyPerUnitSeller,re.cancelled,re.exp_cancel_percentage,re.user_currencycode,re.currency_cron_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where paid_status = 'yes' AND `host_email`='" . $sellerEmails . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_commission_track_id($id)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where c.id='" . $id . "'";
		return $this->ExecuteQuery($Query);
	}

	public function get_unpaid_commission_tracking($sellerEmail)
	{
	
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.checkin,re.cancelled,re.user_currencycode,re.currency_cron_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_status = 'no' AND  `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_rep_details_commison($email)
	{
		$this->db->select('*');
		$this->db->where('renter_id', $email);
		$this->db->from(EXP_COMMISSION_TRACKING . ' as c');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as r', "r.Bookingno=c.booking_no");
		return $query = $this->db->get();
	}

	public function get_all_product_details($condition)
	{
		$this->db->select('*,r.exp_cancel_percentage as enq_cancel_per,IFNULL(dis.dispute_by,"") as cancelled_by',FALSE);
		$this->db->from(EXP_COMMISSION_TRACKING . ' as c');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as r', "r.Bookingno=c.booking_no");
		$this->db->join(USERS . ' as u', "u.id=r.user_id");
		$this->db->join(EXPERIENCE . ' as p', "p.experience_id=r.prd_id", "left");
        $this->db->join(EXPERIENCE_DISPUTE . ' as dis', "dis.booking_no=r.Bookingno","LEFT");
		$this->db->where($condition);
		//$this->db->group_by("r.user_id");
		return $query = $this->db->get();
	}
	public function get_commission_tracking_list($sellerEmails)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.cancelled,re.checkin,re.user_currencycode,re.currency_cron_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where  `host_email`='" . $sellerEmails . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

}
