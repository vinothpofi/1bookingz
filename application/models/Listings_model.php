<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to listings management
 * @author Teamtweaks
 *
 */
class Listings_model extends My_Model{
	public function __construct(){
		parent::__construct();
	}
	public function get_all_values()
	{
	$this->db->select('*');
	$this->db->from(LISTINGS);
	$query = $this->db->get();
	return $query->result();
	}
	public function get_all_data()
	{
	$this->db->select('*');
	$this->db->from(LISTING_TYPES);
	$this->db->order_by('id','DESC');
	$query = $this->db->get();
	return $query->result();
	}
	public function simple_updates($condition,$id)
	{
	$this->db->where('id',$id);
	$this->db->update(LISTING_TYPES,$condition); 

	}
	public function delete_listing($id)
	{
	$this->db->where('id',$id);
	return $this->db->delete(LISTING_TYPES);
}
public function get_all_datas($id)
	{
	$this->db->select('*');
	$this->db->from(LISTING_TYPES);
	$this->db->where('id',$id);
	$query = $this->db->get();
	return $query->result();
	}

	public function get_listing_childValues($parent_id=''){
        $query="Select lc.*,lc.id as child_id,lt.*,(select count(p.id) from fc_product p where p.accommodates = child_id or p.minimum_stay = child_id) as child_used FROM fc_listing_child as lc JOIN fc_listing_types as lt on lt.id = lc.parent_id WHERE parent_id=".$parent_id." ORDER BY child_name + 0 ASC";
        return $this->ExecuteQuery($query);
    }

    public function get_listing_childValues_view($parent_id=''){
        $query="select lc.*,lc.id as child_id,lt.*,(select count(p.id) from fc_product p where p.accommodates = child_id or p.minimum_stay = child_id) as child_used  FROM fc_listing_child as lc JOIN fc_listing_types as lt on lt.id = lc.parent_id WHERE parent_id=".$parent_id." ORDER BY child_name + 0 ASC";
        return $this->ExecuteQuery($query);
    }
}