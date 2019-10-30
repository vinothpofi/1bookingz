<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



/**

 *

 * This model contains all db functions related to user management

 * @author Teamtweaks

 *

 */

class Currency_model extends My_Model

{



	public function __construct()

	{

		parent::__construct();

	}

	public function get_currency_cron_data($id)
	{

		$this->db->select('*');

		$this->db->from('fc_currency_cron');

		$this->db->order_by('curren_id','desc');

		if($id != ''){

			$this->db->where('curren_id =',$id);

		}else{
			$this->db->limit(1);
		}
		return $this->db->get()->row(); 

	}

}

