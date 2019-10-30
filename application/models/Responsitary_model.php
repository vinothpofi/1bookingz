<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to sub-admin management
 * @author Teamtweaks
 *
 */
class Responsitary_model extends My_Model
{
	public function add_edit_responsitary($dataArr='',$condition=''){
		if ($condition['id'] != ''){
			$this->db->where($condition);
			$this->db->update(RESPONSITARY,$dataArr);
		}else {
			$this->db->insert(RESPONSITARY,$dataArr);
		}
	}
}