<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * This model contains all db functions related to sub-admin management
 * @author Teamtweaks
 *
 */
class Subadmin_model extends My_Model
{
	public function add_edit_subadmin($dataArr='',$condition=''){
		if ($condition['id'] != ''){
			$this->db->where($condition);
			$this->db->update(SUBADMIN,$dataArr);
		}else {
			$this->db->insert(SUBADMIN,$dataArr);
		}
	}

	function export_rep_details($table,$fields_wanted){
		$query='SELECT ';
		foreach($fields_wanted as $field)
		{
		if($field=='created')
		{
		$query .='DATE('.$field.') AS created'.',';
		}
		else{
		$query .=$field.',';
		}
		}
		$query=substr($query,0,-1);
		$query .=' FROM '.$table.' WHERE `admin_rep_type` ="Representative"';
		$data['rep_detail']=$this->ExecuteQuery($query);
		
		return $data;
	}
	
	function get_rep_details_with_host(){
		$sql="select s.*,(select IFNULL(count(ur.id),0) from ".USERS." as ur where ur.rep_code= s.admin_rep_code) as host_count from ".SUBADMIN." as s, fc_users as u WHERE s.admin_rep_type='Representative' group by s.admin_rep_code order by s.created desc";
		$res=$this->ExecuteQuery($sql);
		return $res;
	}
	/*check subadmin email exist */
	function check_subadmin_email_exist($email_id){
		$sql = "select * from ".SUBADMIN." where email='".$email_id."'";
		$res=$this->ExecuteQuery($sql);
		return $res;
	}
	/*check subadmin/rep login name exist */
	function check_subadmin_loginname_exist($admin_name){
		$sql = "select * from ".SUBADMIN." where admin_name='".$admin_name."'";
		$res=$this->ExecuteQuery($sql);
		return $res;
	}
	
	
}