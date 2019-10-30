<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Bookings_model extends My_Model
{
	public function booked_rental_trip($prd_id = '', $keyword)
	{
		$this->db->select('pb.*, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.product_name,p.product_title,p.price,p.currency, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.serviceFee, rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno');
		$this->db->from(RENTALENQUIRY . ' as rq');
		$this->db->join(PRODUCT_BOOKING . ' as pb', 'pb.product_id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = pb.product_id', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = rq.prd_id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		if ($keyword != "") {
			$this->db->like('p.product_title', $keyword);
			$this->db->or_like('u.firstname', $keyword);
			$this->db->or_like('pn.address', $keyword);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
	}

	public function get_trip_review_all($reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}

	public function get_trip_review($bookingno = '', $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.bookingno', $bookingno);
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}
}

?>
