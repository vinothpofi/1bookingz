<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *

 */
class Experience_dispute_model extends My_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function get_all_exp_dispute_details()
	{
		$this->db->select('ed.*,ed.email as d_email,e.experience_id as experience_id, e.experience_title,u.email,eq.checkin,eq.checkout');
		$this->db->from('fc_experience_dispute' . ' as ed');
		$this->db->join('fc_experiences' . ' as e', "ed.prd_id=e.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_ENQUIRY . ' as eq', "eq.Bookingno=ed.booking_no", "LEFT");
		$this->db->join('fc_users' . ' as u', "u.id = ed.user_id", "LEFT");
		$this->db->order_by('ed.id', 'desc');
		$this->db->where('ed.cancel_status', 1);
		$this->db->group_by('ed.id');
		return $query = $this->db->get();
	}

	function get_exp_dispute_details($booking_no = '')
	{
		$this->db->select('ed.*,e.experience_title,u.user_name,u.email,mm.senderId as med_senderid,mm.receiverId as med_receiverid,e.user_id as host_id,eq.checkin,eq.checkout');
		$this->db->from('fc_experience_dispute' . ' as ed');
		$this->db->join('fc_experiences' . ' as e', "ed.prd_id=e.experience_id", "LEFT");
        $this->db->join(EXPERIENCE_ENQUIRY . ' as eq', "eq.Bookingno=ed.booking_no", "LEFT");
		$this->db->join('fc_users' . ' as u', "ed.user_id=u.id", "LEFT");
		$this->db->join('fc_experience_med_message' . ' as mm', "mm.bookingNo=ed.booking_no", "LEFT");
		$this->db->where('ed.booking_no', $booking_no);
		return $query =  $this->db->get_where();
		//echo $this->db->last_query();
		//exit;
	}

	function get_all_expdispute_cancel_booking()
	{
		$this->db->select('ed.*, e.experience_id as experience_id, e.experience_title,u.email');
		$this->db->from('fc_experience_dispute' . ' as ed');
		$this->db->join('fc_experiences' . ' as e', "ed.prd_id=e.experience_id", "LEFT");
		$this->db->join('fc_users' . ' as u', "u.id = ed.user_id", "LEFT");
		$this->db->order_by('ed.created_date', 'desc');
		$this->db->where('ed.cancel_status', 1);
		$this->db->group_by('ed.id');
		return $query = $this->db->get();
	}

	function get_cancel_dispute_details($booking_no = '')
	{
		$this->db->select('ed.*,e.experience_title,u.user_name,u.email,mm.senderId as med_senderid,mm.receiverId as med_receiverid,e.user_id as host_id');
		$this->db->from('fc_experience_dispute' . ' as ed');
		$this->db->join('fc_experiences' . ' as e', "ed.prd_id=e.experience_id", "LEFT");
		$this->db->join('fc_users' . ' as u', "u.id=ed.user_id", "LEFT");
		$this->db->join('fc_experience_med_message' . ' as mm', "mm.bookingNo=ed.booking_no", "LEFT");
		$this->db->where('ed.booking_no', $booking_no);
		return $query = $this->db->get_where();
	}

}
