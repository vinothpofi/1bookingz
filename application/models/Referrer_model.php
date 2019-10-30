<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */

class Referrer_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function get_referrer_details()
	{
		$this->db->select('*');
		$this->db->from(REFERRER);
		$query = $this->db->get();
		return $query;
	}
	
}	
	