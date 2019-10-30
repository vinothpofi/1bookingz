<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function getCountDetails($tableName = '', $fieldName = '', $whereCondition = array(), $rep_code = '')
	{
		
		if ($rep_code != '') {
			$sql = "select p.*,u.firstname,u.lastname from fc_product p LEFT JOIN fc_users u on (u.id=p.user_id) where u.status='Active' and u.group='Seller' and u.rep_code=" . '"' . $rep_code . '"' . " group by p.id order by p.created desc";
			$productList = $this->ExecuteQuery($sql);
			return $productList->num_rows();
		} else {
			$this->db->select($fieldName);
			$this->db->from($tableName);
			$this->db->where($whereCondition);
			//$this->db->where(JOB.".dateAdded >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
			$countQuery = $this->db->get()->result();
			//echo $this->db->last_query().'<br>';
			//echo $countQuery->num_rows();
			return count($countQuery);//->num_rows();
		}
	}

	function getRecentDetails($tableName = '', $fieldName = '', $userOrderBy = '', $userLimit = '', $whereCondition = array())
	{
		$this->db->select('*');
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->order_by($fieldName, $userOrderBy);
		$this->db->limit($userLimit);
		$countQuery = $this->db->get();
		return $countQuery->result_array();
	}

	function getTodayUsersCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		
		$countQuery = $this->db->get(); 

		return $countQuery->num_rows();
	}

	function getTodayPropertyCount($tableName = '', $fieldName = '', $whereCondition = array())
	{ 
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getTodayPropertyrepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{ 
		$this->db->select('fc_product.id');
		$this->db->from($tableName);
		$this->db->join('fc_users', 'fc_product.user_id = fc_users.id', 'LEFT');
		$this->db->where($whereCondition);
		$this->db->where("fc_product.created >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getTodayexperienceCount($tableName = '', $fieldName = '', $whereCondition = array())
	{ 
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->where("added_date >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getTodayexperiencerepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{ 
		$this->db->select('fc_experiences.experience_id');
		$this->db->from($tableName);
		$this->db->join('fc_users', 'fc_experiences.user_id = fc_users.id', 'LEFT');
		$this->db->where($whereCondition);
		$this->db->where("fc_experiences.added_date >= DATE_SUB(NOW(),INTERVAL 24 HOUR)", NULL, FALSE);
		//$this->db->like("created",date('Y-m-d', strtotime('-24 hours')));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	public function view_product_details($condition = '')
	{
		$select_qry = "select p.*,cit.name as city_name,cit.id as ci_it,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.user_name,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.latitude,pa.longitude,pb.datefrom as book_datefrom,pb.dateto as book_dateto,ph.product_image as PImg,p.featured from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " pb on pb.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . CITY . " cit on pa.city = cit.id  
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function view_experience_count($expcondition)
	{
		$groupby = 'group by p.experience_id';
		$select_qry = "select p.*,pa.city as city_name,et.id as et_id,et.experience_title as cat_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,ph.product_image as PImg,p.featured
		from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_PHOTOS . " ph on p.experience_id=ph.product_id
			 JOIN " . EXPERIENCE_TYPE . " et on et.id=p.type_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)
		" . $expcondition . " 
		" . $groupby . "		
		";
		/*echo $select_qry; exit;
		select p.*,pa.city as city_name,et.id as et_id,et.experience_title as cat_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,ph.product_image as PImg,p.featured from fc_experiences p LEFT JOIN fc_experience_address pa on pa.experience_id=p.experience_id LEFT JOIN fc_experience_photos ph on p.experience_id=ph.product_id JOIN fc_experience_type et on et.id=p.type_id LEFT JOIN fc_users u on (u.id=p.user_id) where u.status="Active" or p.user_id=0 group by p.experience_id
		*/
		$experienceList = $this->ExecuteQuery($select_qry);
		
		return $experienceList;
	}

	function getThisMonthCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		$this->db->where("created >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getThisMonthexperienceCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->join('fc_users as u','fc_experiences.user_id = u.id','LEFT');
		$this->db->where($whereCondition);
		$this->db->where('u.status' , 'Active');
		$this->db->where("added_date >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getThisMonthexperiencerepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select('fc_experiences.experience_id');
		$this->db->from($tableName);
		$this->db->join('fc_users as u','fc_experiences.user_id = u.id','LEFT');
		$this->db->where($whereCondition);
		$this->db->where('u.status' , 'Active');
		$this->db->where("fc_experiences.added_date >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getThisMonthPropertyCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		//$this->db->join('fc_users as u', 'fc_product.user_id = u.id', 'LEFT');
		$this->db->where($whereCondition);
		//$this->db->where('u.status' , 'Active');
		$this->db->where("fc_product.created >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getThisMonthPropertyrepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select('fc_product.id');
		$this->db->from($tableName);
		//$this->db->join('fc_users as u', 'fc_product.user_id = u.id', 'LEFT');
		$this->db->where($whereCondition);
		//$this->db->where('u.status' , 'Active');
		$this->db->where("fc_product.created >= DATE_SUB(NOW(),INTERVAL 30 DAY)", NULL, FALSE);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getLastYearCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->where($whereCondition);
		//date("Y");
		$this->db->like('created', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getLastYearexperienceCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		$this->db->join('fc_users as u','fc_experiences.user_id = u.id','LEFT');
		$this->db->where($whereCondition);
		$this->db->where('u.status' , 'Active');
		//date("Y");
		$this->db->like('added_date', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getLastYearexperiencerepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select('fc_experiences.experience_id');
		$this->db->from($tableName);
		$this->db->join('fc_users as u', 'fc_experiences.user_id = u.id', 'LEFT');
		$this->db->where($whereCondition);
		//date("Y");
		$this->db->like('fc_experiences.added_date', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getLastYearProertyCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select($fieldName);
		$this->db->from($tableName);
		//$this->db->join('fc_users as u', 'fc_product.user_id = u.id', 'LEFT');
		$this->db->where($whereCondition);
		//$this->db->where('u.status' , 'Active');
		//date("Y");
		$this->db->like('fc_product.created', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getLastYearProertyrepCount($tableName = '', $fieldName = '', $whereCondition = array())
	{
		$this->db->select('fc_product.id');
		$this->db->from($tableName);
		//$this->db->join('fc_users as u', 'fc_product.user_id = u.id', 'LEFT');
		$this->db->where($whereCondition);
		//$this->db->where('u.status' , 'Active');
		//date("Y");
		$this->db->like('fc_product.created', date("Y"));
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getDashboardOrderDetails()
	{
		$this->db->select('*,' . PAYMENT . '.id as orderId,' . PAYMENT . '.status as paymentStatus,' . PAYMENT . '.price as paymentPrice');
		$this->db->from(PAYMENT);
		$this->db->join(PRODUCT, PRODUCT . '.id=' . PAYMENT . '.product_id', 'inner');
		$this->db->join('fc_rentalsenquiry', 'fc_payment.EnquiryId = fc_rentalsenquiry.id', 'LEFT');
		$this->db->order_by(PAYMENT . '.id', 'desc');
		$this->db->limit(3);
		$orderQueryDashboard = $this->db->get();
		return $orderQueryDashboard->result_array();
		//$this->db->where($whereCondition);
	}

	function getDashboardexperienceOrderDetails()
	{
		$this->db->select('*,' . EXPERIENCE_BOOKING_PAYMENT . '.id as orderId,' . EXPERIENCE_BOOKING_PAYMENT . '.status as paymentStatus,' . EXPERIENCE_BOOKING_PAYMENT . '.price as paymentPrice,' . EXPERIENCE_ENQUIRY . '.Bookingno as Bookingno');
		$this->db->from(EXPERIENCE_BOOKING_PAYMENT);
		$this->db->join(EXPERIENCE, EXPERIENCE . '.experience_id=' . EXPERIENCE_BOOKING_PAYMENT . '.product_id', 'inner');
		$this->db->join(EXPERIENCE_ENQUIRY, EXPERIENCE_BOOKING_PAYMENT . '.EnquiryId =' .EXPERIENCE_ENQUIRY . '.id', 'inner');
		$this->db->order_by(EXPERIENCE_BOOKING_PAYMENT . '.id', 'desc');
		$this->db->limit(3);
		$orderQueryDashboard = $this->db->get();
		return $orderQueryDashboard->result_array();
		//$this->db->where($whereCondition);
	}

	function get_sub($rep_id)
	{
		$this->db->select('*');
		$this->db->from(SUBADMIN);
		$this->db->where('id', $rep_id);
		return $query = $this->db->get_where();
	}

	function get_seller($rep_un_sellerid)
	{
		$this->db->select('*');
		$this->db->from(USERS);
		$this->db->where('rep_code', $rep_un_sellerid);
		return $query = $this->db->get_where();
	}

	function totaluserscount()
	{
		$this->db->select('id');
		$this->db->from('fc_users');
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

	function getnormaluserscount()
	{
		$this->db->select('loginUserType');
		$this->db->from('fc_users');
		$this->db->where('loginUserType',normal);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	function getlinkedinuserscount()
	{
		$this->db->select('loginUserType');
		$this->db->from('fc_users');
		$this->db->where('loginUserType',linkedin);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	function getfacebookuserscount()
	{
		$this->db->select('loginUserType');
		$this->db->from('fc_users');
		$this->db->where('loginUserType',facebook);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}
	function getgoogleuserscount()
	{
		$this->db->select('loginUserType');
		$this->db->from('fc_users');
		$this->db->where('loginUserType',google);
		$countQuery = $this->db->get();
		return $countQuery->num_rows();
	}

} 

?>