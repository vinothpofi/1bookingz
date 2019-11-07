<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to seller requests
 * @author Teamtweaks
 *
 */
class Seller_model extends My_Model
{
	public function __construct() 
	{
		parent::__construct();
	}
	
	/**
    * 
    * Getting Sellers details
    * @param String $condition
    */
   public function get_sellers_details($condition=''){
   		$Query = " select * from ".USERS." ".$condition;
   		return $this->ExecuteQuery($Query);
   }
   
   public function get_all_seller_details_admin($userid){
	   
		$this->db->select('u.*,b.user_id,b.id_verified');
		$this->db->from(USERS.' as u');
		//$this->db->join(FANCYYBOX.' as a',"u.member_pakage=a.id","left");
		$this->db->join(REQUIREMENTS.' as b',"u.id=b.user_id","left");
		$this->db->where('group','Seller');
		return $query = $this->db->get();
	}
	
	public function get_all_seller_details_Proof($condition){
	  
		$this->db->select('u.*,uid.id_proof_status');
		$this->db->from(USERS.' as u');
		$this->db->join(ID_PROOF.' as uid',"uid.user_id=u.id","left");
		$this->db->where($condition);
		$this->db->order_by('id','desc');
		return $query = $this->db->get();	
	}

	public function get_sub($rep_id)
	{
		$this->db->select('*');
		$this->db->from(SUBADMIN);
		$this->db->where('id',$rep_id);
		return $query = $this->db->get_where();
	}
	public function get_rep_all_details()
	{
		$this->db->select('*');
		$this->db->from(SUBADMIN);
		$this->db->where('admin_rep_type','Representative');
		$query = $this->db->get();
	    return $query->result();
	}
	public function check_seller_email_exist($email_id){
		$sql = "select * from ".USERS." where email='".$email_id."'";
		$res=$this->ExecuteQuery($sql);
		return $res;
	}
	
}