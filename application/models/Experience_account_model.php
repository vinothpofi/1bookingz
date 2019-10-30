<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Experience_account_model extends My_Model
{

	public function view_newbooking_details()
	{
		$today = date('Y-m-d');
		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title as product_name,pd.experience_id as PrdID');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = rq.prd_id');
		//$this->db->where('rq.booking_status = "'.$status.'"');	
		$this->db->where('DATE(rq.checkin)>=', $today); /* malar- new booking checkin must be from today */
		$this->db->where("(rq.booking_status!='Booked')"); //malar-booked-property not booked
		$this->db->order_by("rq.dateAdded", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function view_newbooking_details_confirmed()
	{
	
		
		$today = date('Y-m-d');
		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title as product_name,pd.experience_id as PrdID,Py.status as status');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = rq.prd_id');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as Py', 'Py.EnquiryId = rq.id');
		$this->db->where('Py.status = "Paid"');
		$this->db->where('rq.booking_status', "Booked"); //malar-booked-property is booked(payment done)
		$this->db->where('DATE(rq.checkin)>=', $today); /* malar- new booking checkin must be from today - upcoming confirm booking */
		$this->db->order_by("rq.dateAdded", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function view_newbooking_detailsexp($status)
	{
		$today = date('Y-m-d');
		$this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title as product_name,pd.experience_id as PrdID');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = rq.prd_id');
		$this->db->where('rq.approval = "' . $status . '"');
		//$this->db->where('rq.booking_status',"Booked"); //malar-booked-property is booked(payment done)	
		$this->db->where('DATE(rq.checkout)<', $today);
		/* $today = date('Y-m-d');
		$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-6 days"))));
		$minvalue = $today.' 00:00:00';
		$maxvalue = $today.' 23:59:59';
		$this->db->where("rq.dateAdded =",$today);
		$this->db->where( "rq.dateAdded BETWEEN '$minvalue' AND '$maxvalue'", NULL, FALSE); */
		$PrdList = $this->db->get();
		//echo $this->db->last_query(); die;
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function view_newbooking_detailsexp_nw()
	{
		$today = date('Y-m-d'); 
		$this->db->select('rq.*,rq.id as cid,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title as  product_name,pd.experience_id as PrdID');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = rq.prd_id');
		//$this->db->where('rq.approval = "'.$status.'"'); // malar- commented - all expire list
		//$this->db->where('rq.booking_status',"Booked"); //malar-booked-property is booked(payment done)	
		$this->db->where('DATE(rq.checkout)<', $today);
		$this->db->order_by('rq.id', 'desc');
		/* $today = date('Y-m-d');
		$today =  date('Y-m-d',strtotime(date('Y-m-d', strtotime("-6 days"))));
		$minvalue = $today.' 00:00:00';
		$maxvalue = $today.' 23:59:59';
		$this->db->where("rq.dateAdded =",$today);
		$this->db->where( "rq.dateAdded BETWEEN '$minvalue' AND '$maxvalue'", NULL, FALSE); */
		$PrdList = $this->db->get();
		//echo $this->db->last_query(); die;
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

}

?>
