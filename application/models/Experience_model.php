<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to attribute management
 *
 * @author Teamtweaks
 *
 */
class Experience_model extends My_Model
{

	/* experience type  */
	public function view_experienceType_details()
	{
		$select_qry = "select * from " . EXPERIENCE_TYPE . " where status='Active' ORDER BY id DESC";
		$attributeList = $this->ExecuteQuery($select_qry);
		return $attributeList;
	}
	
	public function view_experienceType_details_manage()
	{
		$select_qry = "select * from " . EXPERIENCE_TYPE . " ORDER BY id DESC";
		$attributeList = $this->ExecuteQuery($select_qry);
		return $attributeList;
	}
	 public function hostcancelled_trip_site_map($host_id = '', $keyword)
	{
		$this->db->select('*');
		$this->db->from(EXP_COMMISSION_TRACKING . ' as c');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as re', 're.Bookingno = c.booking_no', 'left');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = re.prd_id', 'left');
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = re.user_id'); //get guest details
		$this->db->where('c.dispute_by = ', 'Host');
		$this->db->where('c.disputer_id = ', $host_id);
		$this->db->where('re.cancelled = ', 'yes');
		
		// if($type != '')
		// {
		// 	$this->db->where('c.rental_type = ', $type);
		// }
		if ($keyword != "") {
			$this->db->where("(p.veh_title LIKE '%$keyword%' OR p.veh_title_ph LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
		} 
		$this->db->group_by('c.id');
		$this->db->order_by('c.dateAdded', 'desc');
		return $this->db->get();
	}
	public function hostcancelled_trip($host_id = '', $keyword, $pageLimitStart, $searchPerPage)
	{
		//$Query = "select * from " . COMMISSION_TRACKING . " c JOIN " . VEHICLE_ENQUIRY . " re on re.Bookingno=c.booking_no JOIN " . USERS . " u on re.user_id=u.id  where  cancelled = 'yes' AND `user_id`='" . $customer_id . "'";
		$this->db->select('*,re.dateAdded as bookedDate,p.*,pp.product_image,u.firstname,u.email,re.user_currencycode,re.secDeposit,re.checkin,re.checkout,re.Bookingno,re.currency_cron_id,c.paid_cancel_amount,c.exp_cancel_percentage as cancel_percentage,c.subtotal');

		$this->db->from(EXP_COMMISSION_TRACKING	 . ' as c');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as re', 're.Bookingno = c.booking_no', 'left');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = re.prd_id', 'left');
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = re.user_id'); //get guest details
		$this->db->where('c.dispute_by = ', 'Host');
		$this->db->where('c.disputer_id = ', $host_id);
		$this->db->where('re.cancelled = ', 'yes');
		
		// if($type != '')
		// {
		// 	$this->db->where('c.rental_type = ', $type);
		// }
		if ($keyword != "") {
			$this->db->where("(p.veh_title LIKE '%$keyword%' OR p.veh_title_ph LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
		} 
		$this->db->group_by('c.id');
		$this->db->order_by('c.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $this->db->get();
	}
public function get_all_cancelled_users()
        {
            $this->db->select('*');
            $this->db->from(EXPERIENCE_ENQUIRY . ' as r');
            $this->db->join(USERS . ' as u', "r.user_id=u.id");
            $this->db->where('r.cancelled', 'Yes');
             $this->db->where('r.dispute_by', 'Host');
           // $this->db->group_by('r.user_id');
            return $query = $this->db->get_where();
        }
          public function get_all_commission_tracking($Bookingno)
	{
		$Query = "select * from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no JOIN " . USERS . " u on re.user_id=u.id  where  cancelled = 'yes' AND c.dispute_by = 'Host' AND `Bookingno`='" . $Bookingno . "'";
		return $this->ExecuteQuery($Query)->result();
	}
	public function edit_experienceType($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(EXPERIENCE_TYPE, $dataArr);
	}

	public function view_experienceType($condition = '')
	{
		return $this->db->get_where(EXPERIENCE_TYPE, $condition);
	}

	/* experience type   */
	/* experience */
	//view listing experience details
	public function get_exprience_view_details($limit = '', $limitstart)
	{
		$this->db->select('p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_TYPE . ' as extyp', 'extyp.id=p.type_id');
		$this->db->join(EXPERIENCE_ADDR . ' as expAdd', 'expAdd.experience_id=p.experience_id', "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id");
		$this->db->join(EXPERIENCE_PHOTOS . ' as rp', "rp.product_id=p.experience_id", "LEFT");
		$this->db->order_by('p.experience_id', 'desc');
		$this->db->group_by('p.experience_id');
		$this->db->where('p.status', '1');
		if ($limit != '') {
			$this->db->limit($limit, $limitstart);
		}
		return $query = $this->db->get();
		//echo $this->db->last_query();die;
	}

	//view listing experience details
	public function get_exprience_view_details_withFilter($condition = '')
	{
		$select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city from " . EXPERIENCE . " p  
		LEFT JOIN " . EXPERIENCE_TYPE . " extyp on extyp.id=p.type_id
		LEFT JOIN " . EXPERIENCE_ADDR . " expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN " . EXPERIENCE_PHOTOS . " rp on rp.product_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_DATES . " d on d.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_TIMING . " dt on dt.exp_dates_id=d.id 

		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_experiences($condition = '')
	{
		$select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city from " . EXPERIENCE . " p  
		LEFT JOIN " . EXPERIENCE_TYPE . " extyp on extyp.id=p.type_id
		LEFT JOIN " . EXPERIENCE_ADDR . " expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN " . EXPERIENCE_PHOTOS . " rp on rp.product_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_DATES . " d on d.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_TIMING . " dt on dt.exp_dates_id=d.id 

		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_exprience_view_details_all()
	{
		$this->db->select('p.*,extyp.experience_title as type_title,u.image as user_image,rp.product_image as product_image,expAdd.city');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_TYPE . ' as extyp', 'extyp.id=p.type_id');
		$this->db->join(EXPERIENCE_ADDR . ' as expAdd', 'expAdd.experience_id=p.experience_id', "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id");
		$this->db->join(EXPERIENCE_PHOTOS . ' as rp', "rp.product_id=p.experience_id", "LEFT");
		$this->db->order_by('p.experience_id', 'desc');
		$this->db->group_by('p.experience_id');
		$this->db->where('p.status', '1');
		return $query = $this->db->get();
	}

	public function get_popular_wishlistphoto($prod_id = '')
	{
		$popular_list_qry = "select *  from " . EXPERIENCE_PHOTOS . " where product_id=" . $prod_id;
		$productList = $this->ExecuteQuery($popular_list_qry);
		return $productList;
	}

	public function get_allthe_details($status, $city, $id, $limit_per_page, $start_index)
	{
		$whereCond = '';
		if ($status != '') {
			$whereCond = ' where p.status="' . $status . '" ';
		}
		if ($city != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' pa.city= "' . $city . '" ';
		}
		if ($id != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.user_id= "' . $id . '" ';
		}
		if ($whereCond != '') {
			$whereCond .= ' and (u.status="Active" or u.status="Inactive" or p.user_id=0)';
		} else {
			$whereCond = ' where (u.status="Active" or u.status="Inactive" or p.user_id=0)';
		}
		$groupby = 'group by p.experience_id';
		$select_qry = "select p.*,pa.city as city_name,et.id as et_id,et.experience_title as cat_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,ph.product_image as PImg,p.featured
		from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_PHOTOS . " ph on p.experience_id=ph.product_id
			 JOIN " . EXPERIENCE_TYPE . " et on et.id=p.type_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)
		" . $whereCond . " 
		" . $groupby . "  
		order by p.added_date desc
		limit 	" . $start_index . ", " . $limit_per_page . "
		";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}
	public function get_allthe_details_filt($status, $city, $id, $limit_per_page, $start_index, $name_filter)
	{
		$whereCond = '';
		if ($status != '') {
			$whereCond = ' where p.status="' . $status . '" ';
		}
		if ($city != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' pa.city= "' . $city . '" ';
		}
		if ($name_filter != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= " p.experience_title like '%". addslashes($name_filter)."%' ";
		}
		if ($id != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.user_id= "' . $id . '" ';
		}
		if ($whereCond != '') {
			$whereCond .= ' and u.status="Active" or u.status="Inactive" or p.user_id=0';
		} else {
			$whereCond = ' where u.status="Active" or u.status="Inactive" or p.user_id=0';
		}
		$groupby = 'group by p.experience_id';
		$select_qry = "select p.*,pa.city as city_name,et.id as et_id,et.experience_title as cat_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,ph.product_image as PImg,p.featured
		from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_PHOTOS . " ph on p.experience_id=ph.product_id
			 JOIN " . EXPERIENCE_TYPE . " et on et.id=p.type_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)
		" . $whereCond . " 
		" . $groupby . "  
		order by p.added_date desc
		limit 	" . $start_index . ", " . $limit_per_page . "
		";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_particular_details($fields = '', $table = '', $condition = '', $sortArr = '')
	{
		$this->db->select($fields);
		if ($sortArr != '' && is_array($sortArr)) {
			foreach ($sortArr as $sortRow) {
				if (is_array($sortRow)) {
					$this->db->order_by($sortRow['field'], $sortRow['type']);
				}
			}
		}
		return $this->db->get_where($table, $condition);
	}

	public function get_search_options($condition)
	{
		$select_qry = "select p.*,cit.name as city_name,cit.id as c_id,u.firstname,u.lastname from " . EXPERIENCE . " p
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . CITY . " cit on pa.city = cit.id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)" . $condition;
		$searchOption = $this->ExecuteQuery($select_qry);
		return $searchOption;
		echo $this->db->last_query();
		die;
	}

	public function view_experience_details($condition = '')
	{
		$select_qry = "select p.*,p.experience_id as id,p.experience_title as product_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,pa.lat as latitude,pa.lang as longitude,pa.city,pa.state,pa.country,pa.zip,pa.street as apt,pa.address,ph.product_image as PImg,p.featured from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_PHOTOS . " ph on p.experience_id=ph.product_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_dashboard_experience($condition = '', $Cont2 = '', $pageLimitStart, $searchPerPage)
	{
		$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,p.price,hs.payment_status,sched.id as date_id,u.id_verified');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', "pp.product_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_DATES . ' as sched', "sched.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_LISTING_PAYMENT . ' as hs', "hs.product_id=p.experience_id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->where_in('p.user_id', $condition);
		if ($Cont2 != '') {
			$this->db->where('p.status', $Cont2);
		}
		$this->db->group_by('p.experience_id');
		$this->db->order_by('p.experience_id', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get();
	}

	public function get_dashboard_experience_site_map($condition = '', $Cont2 = '')
	{
		$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,p.price,hs.payment_status,sched.id as date_id,u.id_verified');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', "pp.product_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_DATES . ' as sched', "sched.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_LISTING_PAYMENT . ' as hs', "hs.product_id=p.experience_id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->where_in('p.user_id', $condition);
		if ($Cont2 != '') {
			$this->db->where('p.status', $Cont2);
		}
		$this->db->group_by('p.experience_id');
		$this->db->order_by('p.experience_id', 'desc');
		return $query = $this->db->get();
	}

	public function get_dashboard_list($condition = '', $Cont2 = '')
	{
		$this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,hs.payment_status');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', "pp.product_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_LISTING_PAYMENT . ' as hs', "hs.product_id=p.experience_id", "LEFT");
		$this->db->where_in('p.user_id', $condition);
		if ($Cont2 != '') {
			$this->db->where('p.status', $Cont2);
		}
		$this->db->group_by('p.experience_id');
		$this->db->order_by('p.experience_id', 'desc');
		return $query = $this->db->get();
	}

	public function get_images($product_id)
	{
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id', $product_id);
		$this->db->order_by('imgPriority', 'asc');
		return $query = $this->db->get();
	}

	function view_product1($product_id = '')
	{
		$this->db->select('p.*,p.experience_title as product_title,p.experience_id as id,p.language_list,u.id as OwnerId,
		pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude,pa.city as cityname, pa.country as CountryName, pa.state as StateName');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->where('p.experience_id', $product_id);
		$this->db->group_by('p.experience_id');
		return $query = $this->db->get();
	}

	public function get_old_address($id)
	{
		$this->db->select('p.address, p.lat as latitude, p.lang as longitude, c.name as cityName, s.name as stateName, cn.name as countryName');
		$this->db->from(EXPERIENCE_ADDR . ' as p');
		$this->db->join(CITY . ' as c', "c.id=p.city", "LEFT");
		$this->db->join(STATE_TAX . ' as s', "s.id=p.state", "LEFT");
		$this->db->join(COUNTRY_LIST . ' as cn', "cn.id=p.country", "LEFT");
		$this->db->where('p.experience_id', $id);
		return $query = $this->db->get();
	}

	public function get_review($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		$this->db->where('p.review_type', '0');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
		$query = $this->db->get();
		return $query;
	}
	public function get_review_exp_host($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		$this->db->where('p.review_type', '1');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function get_review_similar($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function get_review_other($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id !=', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
		$query = $this->db->get();
		return $query;
	}

	public function get_review_tot($product_id)
	{
		$this->db->select('AVG( total_review ) as tot_tot, AVG( accuracy ) as tot_acc, AVG( communication ) as tot_com, AVG( cleanliness ) as tot_cln, AVG( location ) as tot_loc, AVG( checkin ) as tot_chk, AVG( value ) as tot_val');
		$this->db->from(EXPERIENCE_REVIEW);
		$this->db->where('product_id', $product_id);
		$query = $this->db->get();
		return $query;
	}

	public function get_cat_list($ids = '')
	{
		$this->db->where_in('id', explode(',', $ids));
		return $this->db->get(EXPERIENCE_TYPE);
	}

	public function view_payment_details($transId)
	{
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.experience_title,pd.experience_id as PrdID,pd.experience_title as prd_name');
		$this->db->from(EXPERIENCE_LISTING_PAYMENT . ' as p');
		$this->db->join(USERS . ' as u', 'p.host_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = p.product_id');
		$this->db->where('p.paypal_txn_id = "' . $transId . '"');
		$this->db->where('p.payment_status = "Paid"');
		$this->db->order_by("p.created", "desc");
		$PrdList = $this->db->get();
		return $PrdList;
	}

	/*Change status*/
	public function activeInactiveExperience($table = '', $column = '')
	{
		$data = $_POST['checkbox_id'];
		for ($i = 0; $i < count($data); $i++) {
			if ($data[$i] == 'on') {
				unset($data[$i]);
			}
		}
		$mode = $this->input->post('statusMode');
		$AdmEmail = strtolower($this->input->post('SubAdminEmail'));
		$json_admin_action_value = file_get_contents('fc_admin_action_settings.php');
		if ($json_admin_action_value != '') {
			$json_admin_action_result = unserialize($json_admin_action_value);
		}
		foreach ($json_admin_action_result as $valds) {
			$json_admin_action_result_Arr[] = $valds;
		}
		if (sizeof($json_admin_action_result) > 29) {
			unset($json_admin_action_result_Arr[1]);
		}
		$json_admin_action_result_Arr[] = array($AdmEmail, $mode, $table, $data, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR']);
		$file = 'fc_admin_action_settings.php';
		file_put_contents($file, serialize($json_admin_action_result_Arr));
		$this->db->where_in($column, $data);
		if (strtolower($mode) == 'delete') {
			$newdata = array('status' => '2');
			$condition = array('experience_id' => $product_id);
			$this->db->update(EXPERIENCE, $newdata);
			$this->db->update(EXPERIENCE_PHOTOS, array('status' => 'Delete'));
			$this->db->update(EXPERIENCE_ADDR, $newdata);
			$this->db->update(EXPERIENCE_DATES, $newdata);
			$this->db->update(EXPERIENCE_TIMING, $newdata);
			$this->db->update(EXPERIENCE_GUIDE_PROVIDES, $newdata);
		} else {
			$statusArr = array('status' => $mode);
			$this->db->update($table, $statusArr);
		}
	}

	/*********Single experience details*********/
	function view_experience_details_site_one($where1, $where_or, $where2)
	{
		$this->db->select('p.*,extyp.experience_title as type_title,
		pa.country,pa.state,pa.city,pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude, 
		u.firstname,u.created as user_created,u.response_rate,u.description as description1,u.phone_no,u.group,u.s_phone_no,u.about,u.email as RenterEmail,u.image as thumbnail, u.about, u.loginUserType,u.id_verified, pa.country as Country_name, pa.state as State_name,
		pa.city as CityName, u.host_status,u.status as host_login_status');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_TYPE . ' as extyp', "extyp.id=p.type_id", "LEFT");
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->where($where1);
		$this->db->or_where($where_or);
		$this->db->where($where2);
		$this->db->where(array("u.host_status" => '0'));
		$this->db->group_by('p.experience_id');
		return $query = $this->db->get();
	}

	public function view_product_details_distance_list($lat, $lon, $condition = '')
	{
		$aLong = $lon + 0.05;
		$bLong = $lon - 0.05;
		$aLat = $lat + 0.05;
		$bLat = $lat - 0.05;
		/*
		$whereNew = 'where (pa.lat < ' . $aLat . ' AND pa.lat > ' . $bLat . ' AND pa.lang < ' . $aLong . ' AND pa.lang >' . $bLong . ') AND ' . $condition;
		$select_qry = "select p.id,p.seourl, (select AVG(c.total_review) FROM fc_review c where c.product_id=p.id and c.status='Active') as rate, (select count(c.id) FROM fc_review c where c.product_id=p.id and c.status='Active') as num_reviewers, p.room_type, p.product_title, p.currency, pa.city as city_name, pa.lat as latitude, pa.lang as longitude, u.firstname, u.lastname, u.image as user_image, u.id as userId, ph.product_image as PImg, p.price
        FROM " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . REVIEW . " r on r.product_id=p.id
		LEFT JOIN " . USERS . " u on u.id=p.user_id " . $whereNew;
		*/
		$whereNew = 'where (pa.lat < ' . $aLat . ' AND pa.lat > ' . $bLat . ' AND pa.lang < ' . $aLong . ' AND pa.lang >' . $bLong . ') AND ' . $condition;
		$select_qry = "select p.experience_id as id, p.experience_title as product_title,(select AVG(c.total_review) FROM fc_experience_review c where c.review_type='0' and c.product_id=p.experience_id and c.status='Active') as rate, (select count(c.id) FROM fc_experience_review c where c.review_type='0' and c.product_id=p.experience_id and c.status='Active') as num_reviewers,  pa.city as city_name, pa.lat as latitude, pa.lang as longitude, u.firstname, u.lastname, u.image as user_image, u.id as userId, ph.product_image as PImg,p.price,p.currency
        FROM " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_PHOTOS . " ph on p.experience_id=ph.product_id
		LEFT JOIN fc_experience_dates d on d.experience_id=p.experience_id 
		LEFT JOIN " . USERS . " u on u.id=p.user_id " . $whereNew;
		//echo $select_qry; exit;
		$distanceList = $this->ExecuteQuery($select_qry);
		return $distanceList;
	}

	/* get available dates for booking */
	public function getAvailableDates($product_id, $date)
	{
		$this->db->select("d.*,exp.group_size,(select IFNULL(count(eq.date_id),0) from " . EXPERIENCE_ENQUIRY . " as eq where eq.date_id=d.id and eq.booking_status='" . Booked . "') as date_booked_count", FALSE);
		$this->db->from(EXPERIENCE_DATES . ' as d');
		$this->db->join(EXPERIENCE . ' as exp', "exp.experience_id=d.experience_id", "LEFT");
		$this->db->where('d.experience_id', $product_id);
		$this->db->where('d.from_date >', $date);
		$this->db->where('d.status ', '0');
		$this->db->where('exp.status ', '1');
		$this->db->order_by('d.id');
		return $query = $this->db->get();
	}

	/*  date schedule data  */
	public function getDateSchedule($dateId)
	{
		$this->db->select('d.*');
		$this->db->from(EXPERIENCE_TIMING . ' as d');
		$this->db->join(EXPERIENCE . ' as exp', "exp.experience_id=d.experience_id", "LEFT");
		$this->db->where('d.exp_dates_id ', $dateId);
		$this->db->where('d.status ', '1');
		$this->db->where('exp.status ', '1');
		$this->db->order_by('d.id');
		return $query = $this->db->get();
	}

	/* user booking details to send mail */
	public function getbookeduser_detail($id)
	{
		$this->db->reconnect();
		$this->db->select('rq.numofdates as noofdates,rq.checkin as checkin,rq.checkout as checkout,rq.renter_id as renter_id,rq.unitPerCurrencyUser,rq.user_currencycode,rq.currencycode,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.totalAmt,p.price,p.security_deposit,p.currency,p.user_id,u.email as email,u.user_name as name,p.experience_title as productname,p.experience_id as prd_id');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', "u.id=rq.user_id", "LEFT");
		$this->db->join(EXPERIENCE . ' as p', "p.experience_id=rq.prd_id", "LEFT");
		$this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");
		$this->db->where('rq.id', $id);
		$this->db->limit(15, 0);
		return  $query = $this->db->get();
		//echo $this->db->last_query();
	}

	public function getproductimage($prd_id)
	{
		$this->db->select('product_image');
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id', $prd_id);
		return $query = $this->db->get();
	}

	/************Booking experience Details***************/
	public function view_product_details_booking($condition = '')
	{
		//serviceFee
		$select_qry = "select p.*,p.experience_id as id,
						u.id as userid,u.user_name,u.email,u.phone_no,u.address,u.feature_product,u.image as userphoto,
						pa.lat as latitude,pa.lang as longitude,pa.address,pa.zip as post_code,
						c.name as city_name,(select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.review_type='0' and R.product_id= p.experience_id and R.status='Active') as num_reviewers ,(select AVG(c.total_review) FROM fc_experience_review c where c.review_type='0' and c.product_id=p.experience_id and c.status='Active') as rate,
						rq.checkin,rq.checkout,rq.NoofGuest,rq.numofdates,rq.serviceFee,rq.totalAmt,rq.Bookingno as Bookingno,rq.secDeposit,rq.currencycode as currency,rq.date_id,rq.unitPerCurrencyUser,rq.user_currencycode,rq.currency_cron_id,
						s.name as statename,s.meta_title as statemtitle,s.meta_keyword as statemkey,s.meta_description as statemdesc,s.seourl as stateurl,
						pp.product_image from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ADDR . " pa on pa.experience_id=p.experience_id
		LEFT JOIN " . CITY . " c on c.id=pa.city
		LEFT JOIN " . EXPERIENCE_ENQUIRY . " rq on rq.prd_id=p.experience_id
		LEFT JOIN " . STATE_TAX . " s on s.id=pa.state
		LEFT JOIN " . EXPERIENCE_PHOTOS . " pp on pp.product_id=p.experience_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	/************Booking User Details***************/
	public function view_user_details_booking($condition = '')
	{
		$select_qry = "select u.id as userid,u.user_name,u.email, u.phone_no, rq.NoofGuest,u.feature_product,u.image as userphoto,u.firstname,u.lastname,u.address as UserAddress,u.city as UserCity,u.state as UserState,u.country as UserCountry,u.postal_code as UserPostCode,rq.serviceFee,rq.totalAmt,rq.unitPerCurrencyUser,rq.user_currencycode
						 from " . EXPERIENCE . " p 
		LEFT JOIN " . EXPERIENCE_ENQUIRY . " rq on rq.prd_id=p.experience_id
		LEFT JOIN " . USERS . " u on (u.id=rq.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		//echo $select_qry;
		return $productList;
	}

	/*  add review */
	public function add_review($dataArr = '')
	{
		return $this->db->insert(EXPERIENCE_REVIEW, $dataArr);
	}

	/* get review details */
	function get_productreview_byyou($user_id = '', $pageLimitStart, $searchPerPage)
	{
		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->where('r.reviewer_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=r.reviewer_id", "LEFT");
		$this->db->order_by("r.dateAdded", "desc");
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get_where();
	}

	function get_productreview_byyou_site_map($user_id = '')
	{
		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->where('r.reviewer_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=r.reviewer_id", "LEFT");
		return $query = $this->db->get_where();
	}

	function get_productreview_aboutyou($user_id = '', $pageLimitStart, $searchPerPage)
	{

		//p.experience_title as product_title
		$langarray=language_dynamic_admin_enable_submit(array('p.experience_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

		$this->db->select('r.*,p.experience_title'.$langarray.',u.image,u.firstname');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->where('r.user_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=r.reviewer_id", "LEFT");
		$this->db->order_by("r.dateAdded", "desc");
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get_where();
	}

	function get_productreview_aboutyou_site_map($user_id = '')
	{
		$this->db->select('r.*,p.experience_title as product_title,u.image,u.firstname');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->where('r.user_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "r.product_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=r.reviewer_id", "LEFT");
		return $query = $this->db->get_where();
	}
	/* get review details ends */
	/* get dispute details starts */
	function get_productdispute_byyou($user_id = '', $pageLimitStart, $searchPerPage)
	{
		$langarray=language_dynamic_admin_enable_submit(array('p.experience_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

		//p.experience_title as product_title
		$this->db->select('d.*,p.experience_title'.$langarray.' ,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.user_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		$this->db->order_by('d.id', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get_where();
	}

	function get_productdispute_byyou_site_map($user_id = '')
	{
		$this->db->select('d.*,p.experience_title as product_title,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.user_id', $user_id);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		return $query = $this->db->get_where();
	}

	function get_productdispute_aboutyou($user_id = '', $pageLimitStart, $searchPerPage)
	{
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 0);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get_where();
	}

	function get_productdispute_aboutyou_site_map($user_id = '')
	{
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 0);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		return $query = $this->db->get_where();
	}

	/* get dispute details ends */
	/*get cancel booking dispute details*/
	function get_cancel_dispute($user_id = '', $pageLimitStart, $searchPerPage)
	{
		//print_r($user_id);exit;
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 1);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		$this->db->order_by('d.id', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $query = $this->db->get_where();
	}

	function get_cancel_dispute_site_map($user_id = '')
	{
		//print_r($user_id);exit;
		$this->db->select('d.*,p.experience_title as product_title,p.user_id,u.image');
		$this->db->from(EXPERIENCE_DISPUTE . ' as d');
		$this->db->where('d.disputer_id', $user_id);
		$this->db->where('d.cancel_status', 1);
		$this->db->join(EXPERIENCE . ' as p', "d.prd_id=p.experience_id");
		$this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
		return $query = $this->db->get_where();
	}
	/*End */
	/*  transaction diplay details */
	public function get_featured_transaction($email, $pageLimitStart, $searchPerPage)
	{
		//$this->db->select('CT.dateAdded, U.id as GestId, U.firstname,U.image, P.id as product_id,P.seourl, P.product_title, P.price, RQ.currencycode,RQ.Bookingno,RQ.currencyPerUnitSeller,RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currency_cron_id,RQ.subTotal,RQ.secDeposit, CT.total_amount as totalAmt, CT.guest_fee, CT.host_fee, CT.payable_amount');
		
		$langarray=language_dynamic_admin_enable_submit(array('P.experience_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";
//P.experience_title as product_title
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname,U.image, P.experience_id as product_id, P.experience_title'.$langarray.', P.price,P.currency,RQ.currencycode, RQ.Bookingno,RQ.subTotal,RQ.secDeposit,CT.total_amount as totalAmt, RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currencyPerUnitSeller,RQ.checkin,RQ.cancelled,RQ.dispute_by,RQ.date_id,RQ.checkout,RQ.currency_cron_id,CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(EXP_COMMISSION_TRACKING . ' as CT');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = CT.booking_no', 'LEFT');
		$this->db->join(EXPERIENCE . ' as P', 'P.experience_id = RQ.prd_id', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = RQ.user_id', 'LEFT');
		$this->db->where('CT.host_email', $email);
		$this->db->where('CT.paid_status', 'no');
		$this->db->order_by('CT.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_featured_transaction_site_map($email)
	{
		$this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.experience_id as product_id, P.experience_title as product_title, P.price,P.currency, RQ.Bookingno, CT.total_amount as totalAmt, RQ.unitPerCurrencyUser,RQ.user_currencycode,RQ.currencyPerUnitSeller,RQ.checkin,RQ.checkout,RQ.currency_cron_id,CT.guest_fee, CT.host_fee, CT.payable_amount');
		$this->db->from(EXP_COMMISSION_TRACKING . ' as CT');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = CT.booking_no', 'LEFT');
		$this->db->join(EXPERIENCE . ' as P', 'P.experience_id = RQ.prd_id', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = RQ.user_id', 'LEFT');
		$this->db->where('CT.host_email', $email);
		$this->db->where('CT.paid_status', 'no');
		$this->db->order_by('CT.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}

	public function get_completed_transaction($email, $pageLimitStart, $searchPerPage)
	{
		$this->db->select('CP.dateAdded, CP.transaction_id ,C.*,RE.currencycode,RE.user_currencycode,RE.currency_cron_id');
		$this->db->from(EXP_COMMISSION_PAID . ' as CP');
        $this->db->join(EXP_COMMISSION_TRACKING . ' as C', 'C.commission_paid_id=CP.id', 'LEFT');
        $this->db->join(EXPERIENCE_ENQUIRY . ' as RE', 'RE.Bookingno=C.booking_no', 'LEFT');
		$this->db->where('CP.host_email', $email);
		$this->db->order_by('CP.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $resultArr = $this->db->get();
	}

	public function get_completed_transaction_site_map($email)
	{
		$this->db->select('dateAdded, transaction_id ,amount');
		$this->db->from(EXP_COMMISSION_PAID . ' as CP');
		$this->db->where('CP.host_email', $email);
		$this->db->order_by('CP.dateAdded', 'desc');
		return $resultArr = $this->db->get();
	}

	/*  transaction diplay details  ends */
	/* my experience upcoming */
	public function booked_rental_trip($prd_id = '', $keyword, $pageLimitStart, $searchPerPage)
	{
		//print_r($prd_id);

		$langarray=language_dynamic_admin_enable_submit(array('p.experience_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";
//p.experience_title as product_name, as product_title
		$this->db->select('rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.experience_id,p.experience_title'.$langarray.' ,p.host_status,p.user_id,p.security_deposit,p.cancel_percentage, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price,p.group_size');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ', $prd_id);
		$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		if ($keyword != "") {
			$this->db->where("(p.experience_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
			//$this->db->or_like('u.firstname',$keyword);
			//$this->db->or_like('pn.address',pn.address);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		/* $this->db->get();
        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	public function booked_rental_trip_site_map($prd_id = '', $keyword)
	{
		//print_r($prd_id);
		$this->db->select('rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.host_status,p.user_id,p.security_deposit, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		//$this->db->join(PRODUCT_BOOKING.' as pb' , 'pb.product_id = rq.prd_id', 'left'); //pb.*,
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ', $prd_id);
		$this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);
		if ($keyword != "") {
			$this->db->where("(p.experience_title LIKE '%$keyword%' OR u.firstname LIKE '%$keyword%' OR pn.address LIKE '%$keyword%')");
			//$this->db->or_like('u.firstname',$keyword);
			//$this->db->or_like('pn.address',pn.address);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		/* $this->db->get();
        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	/*  my experience previous */
	function booked_rental_trip_prev($prd_id = '', $product_title, $pageLimitStart, $searchPerPage)
	{
		$langarray=language_dynamic_admin_enable_submit(array('p.experience_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";
		//as product_name, p.experience_title as product_title
		$this->db->select(' rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name,p.experience_id,  p.experience_title'.$langarray.' , u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');
		$this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE); //dec5 <= dec8
		if ($product_title != "") {
			$this->db->like('p.experience_title', $keyword);
			$this->db->or_like('u.firstname', $keyword);
			$this->db->or_like('pn.address', $keyword);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		/* $this->db->get();

        echo $this->db->last_query();die; */
		return $this->db->get();
	}

	function booked_rental_trip_prev_site_map($prd_id = '', $product_title)
	{
		$this->db->select(' rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name,  p.experience_title as product_name, p.experience_title as product_title, u.firstname,u.image, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.unitPerCurrencyUser,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');
		$this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");
		$this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');
		$this->db->join(USERS . ' as u', 'u.id = rq.renter_id');
		$this->db->where('rq.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE);
		if ($product_title != "") {
			$this->db->like('p.experience_title', $keyword);
			$this->db->or_like('u.firstname', $keyword);
			$this->db->or_like('pn.address', $keyword);
		} else {
			$this->db->where('rq.booking_status != "Enquiry"');
		}
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
	}

	/* experience trip review  */
	public function get_trip_review($bookingno = '', $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.bookingno', $bookingno);
		$this->db->where('p.review_type', '0');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}
	public	function get_trip_review_host($bookingno = '', $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.bookingno', $bookingno);
		$this->db->where('p.review_type', '1');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}

	public function get_trip_review_all($reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}

	function get_contents()
	{
		$this->db->select('*');
		$this->db->from(EXPERIENCE);
		$query = $this->db->get();
		return $result = $query->result();
	}

	function booked_rental_future($prd_id = '', $pageLimitStart, $searchPerPage)
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType,rq.renter_id, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', 'pa.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as rq', 'p.experience_id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) >= "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->limit($searchPerPage, $pageLimitStart);
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
		//echo $this->db->last_query();exit;
	}

	function booked_rental_future_site_map($prd_id = '')
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', 'pa.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as rq', 'p.experience_id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) >= "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
		//echo $this->db->last_query();exit;
	}

	function booked_rental_passed($prd_id = '', $pageLimitStart, $searchPerPage)
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', 'pa.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as rq', 'p.experience_id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) < "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		return $this->db->get();
	}

	function booked_rental_passed_site_map($prd_id = '')
	{
		$cur_date = date('Y-m-d');
		$this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', 'pa.experience_id = p.experience_id', 'left');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as rq', 'p.experience_id = rq.prd_id');
		$this->db->join(USERS . ' as u', 'u.id = rq.user_id');
		$this->db->where('p.user_id = ' . $prd_id);
		$this->db->where('DATE(rq.checkin) < "' . $cur_date . '"');
		$this->db->where('rq.renter_id = ' . $prd_id);
		$this->db->where('rq.booking_status != "Enquiry"');
		$this->db->group_by('rq.id');
		$this->db->order_by('rq.dateAdded', 'desc');
		return $this->db->get();
		//echo $this->db->last_query();die;
	}

	public function get_med_messages($userId, $pageLimitStart, $searchPerPage,$booking_nos='')
	{
		// $sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . "," . $searchPerPage . "";
		// $result = $this->db->query($sql);
		// return $result->result();


		$this->db->select("m.* ,u.firstname,u.lastname,u.image,pr.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count ",FALSE);
        $this->db->from(EXPERIENCE_MED_MSG . ' as m');
        $this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(EXPERIENCE . ' as pr', 'pr.experience_id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();

        return $result->result();

	}

	public function get_med_messages_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";
		$result = $this->db->query($sql);
		return $result->result();
	}

	/* Starred */
	public function get_med_messages_starred($userId, $pageLimitStart, $searchPerPage,$booking_nos='')
	{
		// $sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.msg_star_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . "," . $searchPerPage . "";
		// $result = $this->db->query($sql);
		// return $result->result();


		 $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(EXPERIENCE_MED_MSG . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','0');
        $this->db->where('m.msg_star_status','Yes');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();



        return $result->result();
	}

	public function get_med_messages_starred_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.msg_star_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";
		$result = $this->db->query($sql);
		return $result->result();
	}
	/* End Starred */ 
	/*Unread Message*/ 
	public function get_med_messages_unread($userId, $pageLimitStart, $searchPerPage,$booking_nos ='')
	{
		// $sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.msg_read='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . "," . $searchPerPage . "";
		// $result = $this->db->query($sql);
		// return $result->result();

		 $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(EXPERIENCE_MED_MSG . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','0');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();
		return $result->result();

		
	}
	public function get_med_messages_unread_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=0 AND m.msg_read='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";
		$result = $this->db->query($sql);
		return $result->result();
	}
	/*End Unread Message*/

	/*Archived Message*/
	public function get_med_messages_archived($userId, $pageLimitStart, $searchPerPage,$booking_nos= '')
	{
	

		 $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(EXPERIENCE_MED_MSG . ' as m');
        //$this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->where('m.msg_status','1');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userId);
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        if($searchPerPage!='' && $pageLimitStart!='') {
            $this->db->limit($searchPerPage, $pageLimitStart);
        }else{
            $this->db->limit($searchPerPage);
        }
        $result = $this->db->get();
        return $result->result();

	}
	public function get_med_messages_archived_site_map($userId)
	{
		$sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . EXPERIENCE_MED_MSG . " as ms," . EXPERIENCE . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . EXPERIENCE_MED_MSG . " as m , " . EXPERIENCE . " as p  WHERE m.productId=p.experience_id AND m.msg_status=1 AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";
		$result = $this->db->query($sql);
		return $result->result();
	}
	/*End Archived Message*/ 

	/*Pending Request*/
	public function get_med_messages_pending_request($userId, $pageLimitStart, $searchPerPage,$booking_nos = '')
	{
		// $sql = "SELECT m.* ,re.booking_status,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , ".RENTALENQUIRY." as re join " . PRODUCT . " as p join " . USERS . " as u  WHERE m.productId=p.id AND m.msg_status=0 AND m.user_archive_status='No' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;		$result = $this->db->query($sql);		return $result->result();
		// $sql = "SELECT m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p join " . USERS . " as u join " . RENTALENQUIRY . " as re   WHERE m.productId=p.id AND m.msg_status=0 AND m.user_archive_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc limit " . $pageLimitStart . ',' . $searchPerPage;	


		// $this->db->select('m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId . ' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		// $this->db->from(EXPERIENCE_MED_MSG . ' as m');
		// $this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		// $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		// $this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		// $this->db->where('m.msg_status', '0');
		// $this->db->where('m.receiverId', $userId);
		// $this->db->where('RQ.approval=','Pending');
		// $this->db->group_by('m.bookingNo');
		// $this->db->order_by('m.dateAdded', 'desc');
		// $this->db->limit($searchPerPage, $pageLimitStart);
		// $result = $this->db->get();
		// return $result->result();


		$this->db->select('m.* ,RQ.booking_status,RQ.approval,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(EXPERIENCE_MED_MSG . ' as m');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Pending');
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		$result = $this->db->get();
		return $result->result();
	}
	public function get_med_messages_pending_request_site_map($userId)
	{
		// $sql = "SELECT m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userId . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count from " . MED_MESSAGE . " as m , " . PRODUCT . " as p  WHERE m.productId=p.id AND  m.msg_status=0 AND m.user_archive_status='Yes' AND m.receiverId=" . $userId . " group by m.bookingNo order by m.dateAdded desc";		$result = $this->db->query($sql);		return $result->result();

		$this->db->select('m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId . ' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(EXPERIENCE_MED_MSG . ' as m');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Pending');
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$result = $this->db->get();
		return $result->result();
	}
	/*End Pending Request*/ 
	/*Reservations*/
	public function get_med_messages_reservations($userId, $pageLimitStart, $searchPerPage,$booking_nos= '')
	{
		// $this->db->select('m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId . ' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		// $this->db->from(EXPERIENCE_MED_MSG . ' as m');
		// $this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		// $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		// $this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		// $this->db->where('m.msg_status', '0');
		// $this->db->where('m.receiverId', $userId);
		// $this->db->where('RQ.approval=','Accept');

		// $this->db->or_where('RQ.approval=','Decline');
		//  if(!empty($booking_nos)) {
  //           $this->db->where_in('m.bookingNo', $booking_nos);
  //       }
		// $this->db->group_by('m.bookingNo');
		// $this->db->order_by('m.dateAdded', 'desc');
		// $this->db->limit($searchPerPage, $pageLimitStart);
		// $result = $this->db->get();
		// return $result->result();

		$this->db->select('m.* ,RQ.booking_status,RQ.approval,U.firstname,U.lastname,U.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(EXPERIENCE_MED_MSG . ' as m');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('(RQ.approval="Accept" or RQ.approval="Decline")');
		//$this->db->or_where('RQ.approval=','Decline');
        if(!empty($booking_nos)) {
            $this->db->where_in('m.bookingNo', $booking_nos);
        }
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$this->db->limit($searchPerPage, $pageLimitStart);
		$result = $this->db->get();
		return $result->result();

	}
	public function get_med_messages_reservations_site_map($userId)
	{
		$this->db->select('m.* ,p.user_id,(select IFNULL(count(ms.id),0)  from ' . EXPERIENCE_MED_MSG . ' as ms,' . EXPERIENCE . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.experience_id and ms.receiverId=' . $userId . ' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
		$this->db->from(EXPERIENCE_MED_MSG . ' as m');
		$this->db->join(EXPERIENCE_ENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
		$this->db->join(EXPERIENCE . ' as p', 'p.experience_id = m.productId', 'LEFT');
		$this->db->join(USERS . ' as U', 'U.id = m.receiverId', 'LEFT');
		$this->db->where('m.msg_status', '0');
		$this->db->where('m.receiverId', $userId);
		$this->db->where('RQ.approval=','Accept');
		$this->db->or_where('RQ.approval=','Decline');
		$this->db->group_by('m.bookingNo');
		$this->db->order_by('m.dateAdded', 'desc');
		$result = $this->db->get();
		return $result->result();
	}
	/*End Reservations*/ 
	public function get_booking_details($bookingNo)
	{
		$this->db->reconnect();
		$this->db->select('rq.id, rq.checkin, rq.checkout, rq.Bookingno, rq.subTotal, rq.serviceFee, rq.totalAmt, rq.NoofGuest, rq.renter_id, rq.secDeposit,rq.unitPerCurrencyUser,rq.user_currencycode, p.experience_title as product_title, p.currency');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(EXPERIENCE . ' as p', "p.experience_id=rq.prd_id", "left");
		$this->db->where('Bookingno', $bookingNo);
		return $query = $this->db->get();
	}

	/* wishlist */
	public function get_wishlistphoto($condition = '')
	{
		$this->db->select('product_image,product_id');
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id', $condition);
		return $query = $this->db->get();
	}

	public function get_experience_details_wishlist_one_category($condition = '')
	{
		$this->db->select('pa.city as name,p.experience_id, p.experience_title as product_name, p.currency, p.experience_title as product_title,  p.price, n.id as nid, n.notes, p.experience_id as id, pa.address, pa.zip as post_code');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', "pp.product_id=p.experience_id", "LEFT");
		$this->db->join(NOTES . ' as n', "n.experience_id=p.experience_id", "LEFT");
		$this->db->where_in('p.experience_id', $condition);
		$this->db->group_by('p.experience_id');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}

	public function get_product_details_wishlist($condition = '')
	{
		$this->db->select('pa.city as name, p.experience_title as product_name, pp.product_image, p.experience_id as id, p.experience_title as product_title, pa.country as Country_name,pa.state as State_name,pa.city as CityName');
		$this->db->from(EXPERIENCE . ' as p');
		$this->db->join(EXPERIENCE_ADDR . ' as pa', "pa.experience_id=p.experience_id", "LEFT");
		$this->db->join(EXPERIENCE_PHOTOS . ' as pp', "pp.product_id=p.experience_id", "LEFT");
		$this->db->where('p.experience_id', $condition);
		$this->db->where('p.status', '1');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}

	public function get_list_details_wishlist($condition = '')
	{
		$select_qry = "select id,name,product_id,experience_id,last_added from " . LISTS_DETAILS . " where user_id=" . $condition . "  or user_id=0";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_notes_added($Rental_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from(NOTES);
		$this->db->where('experience_id', $Rental_id);
		$this->db->where('user_id', $user_id);
		return $query = $this->db->get();
	}

	public function get_booked_exp_details($booked, $exp_id)
	{
		$this->db->select('*');
		$this->db->from(EXPERIENCE_ENQUIRY);
		$this->db->where($booked);
		$this->db->where('prd_id', $exp_id);
		return $query = $this->db->get();
	}

	public function update_wishlist($dataStr = '', $condition1 = '')
	{
		$last_added = '2';
		$sel_qry = "select experience_id,id from " . LISTS_DETAILS . " where user_id=" . $this->data['loginCheck'] . "";
		$ListVal = $this->ExecuteQuery($sel_qry);
		if ($ListVal->num_rows() > 0) {
			foreach ($ListVal->result() as $wlist) {
				$productArr = @explode(',', $wlist->experience_id);
				if (!empty($productArr)) {
					if (in_array($dataStr, $productArr)) {
						$conditi = array('id' => $wlist->id);
						//$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);
						$my_array = array_filter($productArr);
						$to_remove = (array)$dataStr;
						$result = array_diff($my_array, $to_remove);
						$resultStr = implode(',', $result);
						if ($resultStr != '') {
							$last_added = '2';
						} else {
							$last_added = '1';
						}
						//echo $last_added = '1';exit();
						$this->updateWishlistRentals(array('experience_id' => $resultStr, 'last_added' => $last_added), $conditi);
					}
				}
			}
		}
		if (!empty($condition1)) {
			foreach ($condition1 as $wcont) {
				$select_qry = "select experience_id from " . LISTS_DETAILS . " where id=" . $wcont . "";
				$productList = $this->ExecuteQuery($select_qry);
				$productIdArr = explode(',', $productList->row()->experience_id);
				if (!empty($productIdArr)) {
					if (!in_array($dataStr, $productIdArr)) {
						$select_qry = "update " . LISTS_DETAILS . " set experience_id= concat(experience_id,'," . $dataStr . "'),last_added ='" . $last_added . "' where id=" . $wcont . "";
						$productList = $this->ExecuteQuery($select_qry);
					}
				}
			}
		}
	}

	public function updateWishlistRentals($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(LISTS_DETAILS, $dataArr);
	}

	public function update_notes($dataArr = '', $condition = '')
	{
		if ($condition == '') {
			$this->db->insert(NOTES, $dataArr);
		} else {
			$this->db->where($condition);
			$this->db->update(NOTES, $dataArr);
		}
	}

	public function ChkWishlistProduct($productid = '', $userid)
	{
		$select_qry = 'SELECT id FROM ' . LISTS_DETAILS . ' WHERE user_id = ' . $userid . ' AND FIND_IN_SET(' . $productid . ' , experience_id)';
		return $rentalList = $this->ExecuteQuery($select_qry);
	}

	public function get_date_time_details($experience_id)
	{
		$sql = "select D.*,(select IFNULL(count(T.id),0) from " . EXPERIENCE_TIMING . " as T where T.exp_dates_id= D.id) as time_count from " . EXPERIENCE_DATES . " as D WHERE D.experience_id='" . $experience_id . "' group by D.id order by D.created_at desc";
		$res = $this->ExecuteQuery($sql);
		return $res;
	}

	public function get_data_minimum_stay()
	{
		$sql = "select C.* from " . LISTING_CHILD . " as C , " . LISTING_TYPES . " as T where T.id=C.parent_id and T.name='minimum_stay'";
		$res = $this->ExecuteQuery($sql);
		return $res;
	}

	/**get most viewed Experiences**/
	public function get_mostViewed_experiences()
	{
		$query = "SELECT e.*,u.firstname,ei.product_image
			FROM " . EXPERIENCE . " e 
			LEFT JOIN " . USERS . " u on u.id=e.user_id
			LEFt JOIN " . EXPERIENCE_PHOTOS . " ei on ei.product_id=e.experience_id
			WHERE e.status ='1' order by e.page_view_count desc limit 5";
		$result = $this->ExecuteQuery($query);
		return $result;
	}

	/**booked experiences count**/
	public function booked_experiences()
	{
		$query = "SELECT rq.*, u.email, u.firstname, u.address, rq.caltophone, rq.phone_no, u.postal_code, u.state, u.country, u.city,Py.status as status 
			FROM  " . EXPERIENCE_ENQUIRY . "  rq
			JOIN " . USERS . " as u ON rq.user_id = u.id 
			JOIN " . EXPERIENCE_BOOKING_PAYMENT . " as Py ON Py.EnquiryId = rq.id 
			WHERE Py.status = 'Paid' AND rq.booking_status = 'Booked'  ORDER BY rq.dateAdded desc";
		$result = $this->ExecuteQuery($query);
		return $result;
	}

	/**get count experiences of logged user**/
	public function get_experiences_list($user_id = '')
	{
		$this->db->select('e.*,ep.product_image');
		$this->db->from(EXPERIENCE . ' as e');
		$this->db->join(EXPERIENCE_PHOTOS . ' as ep', 'ep.product_id=e.experience_id', 'LEFT');
		$this->db->where('e.user_id', $user_id);
		$this->db->where('e.status', '1');
		$this->db->group_by('e.experience_id');
		$this->db->order_by('e.experience_id', 'desc');
		$this->db->limit(8,0);
		$query = $this->db->get();
		return $query;
	}

	/**get review received by logged user**/
	function get_experiences_review_aboutyou1($user_id = '')
	{
		$this->db->select('r.*,e.experience_title,u.image');
		$this->db->from(EXPERIENCE_REVIEW . ' as r');
		$this->db->where('r.user_id', $user_id);
		$this->db->join(EXPERIENCE . ' as e', "r.product_id=e.experience_id");
		$this->db->join(USERS . ' as u', "u.id=r.reviewer_id", "LEFT");
		return $query = $this->db->get_where();
	}
	//mnual_payment

	public function get_commission_track_id($id)
	{
		$Query = "select c.* , re.prd_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where c.booking_no='" . $id . "'";
		return $this->ExecuteQuery($Query);
	}

	public function get_unpaid_reviewcommission_tracking_details($sellerEmail, $id)
        {
            $Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.secDeposit,re.user_currencycode,re.currency_cron_id,re.subTotal from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0'  AND c.booking_no = '" . $id . "' AND  `host_email`='" . $sellerEmail . "'";
			//echo $Query; exit;
            return $this->ExecuteQuery($Query)->result_array();
        }
        public function get_unpaid_reviewcommission_tracking($sellerEmail, $id)
        { 
            $Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.secDeposit,re.user_currencycode,re.currency_cron_id,re.subTotal from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0' AND c.booking_no = '" . $id . "' AND  `host_email`='" . $sellerEmail . "'";
            return $this->ExecuteQuery($Query)->result_array();
        }


}

?>