<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *

 */
class Experience_review_model extends My_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function get_all_review_details()
	{
		$this->db->select('r.*, p.experience_id as product_id, p.experience_title as product_title');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id", "LEFT");
		$this->db->order_by('r.dateAdded', 'desc');
		return $query = $this->db->get();
	}

	function get_review_details($review_id = '')
	{
		$this->db->select('r.*,p.experience_title as product_title,u.user_name');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id", "LEFT");
		$this->db->join(USERS . ' as u', "r.email=u.email", "LEFT");
		$this->db->where('r.id', $review_id);
		return $query = $this->db->get_where();
	}

}
