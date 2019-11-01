<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class City_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function UpdateActiveStatus($table = '', $data = '')
	{
		$query = $this->db->get_where($table, $data);
		return $result = $query->result_array();
	}

	public function SelectAllCountry($condition = '')
	{
		//print_r($OrderAsc);die;
		$this->db->select('*');
		$this->db->from(STATE_TAX);
		if (!empty($condition)) {
			$this->db->where($condition);
		}
		//$this->db->where('status','Active');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
//echo $this->db->last_query();die;
		return $result = $query->result_array();
	}

	public function SelectAllPrimaryCities()
	{
		$this->db->select('id,name');
		$this->db->from(CITY);
		$this->db->where('status', 'Active');
		$this->db->where('featured', '1');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get();
//echo $this->db->last_query();die;
		return $result = $query->result_array();
	}

	public function State_city()
	{
		$this->db->select('p.*,u.name,u.status,u.description,u.citylogo,u.citythumb,u.seourl as cityurl');
		$this->db->from(STATE_TAX . ' as p');
		$this->db->join(CITY . ' as u', 'p.id = u.stateid');
		$this->db->group_by('p.id');
		$city = $this->db->get();
		//echo $this->db->last_query();
		//	return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}

	public function Featured_city()
	{
		$this->db->select('u.*,u.seourl as cityurl,count(u.id) as NCount, st.name as state_name,c.name as country');
		$this->db->from(CITY . ' as u');
		$this->db->join(STATE_TAX . ' as st', 'st.id = u.stateid', 'LEFT');
		$this->db->join(LOCATIONS . ' as c', 'c.id = st.countryid', 'LEFT');
		$this->db->join(NEIGHBORHOOD . ' as n', 'u.id = n.neighborhoods', 'LEFT');
		$this->db->where('u.status', 'Active');
		$this->db->where('u.featured', '1');
		$this->db->group_by('u.id');
		$this->db->order_by('u.name', 'asc');
		$city = $this->db->get();
		//echo $this->db->last_query();die;
		//	return $result =$query->result_array();
	     // echo "<pre>";print_r($city);die;
      
		return $city;
	}
	
	public function get_all_city()
	{
		$this->db->select('u.*,u.seourl as cityurl,count(u.id) as NCount, st.name as state_name,c.name as country');
		$this->db->from(CITY . ' as u');
		$this->db->join(STATE_TAX . ' as st', 'st.id = u.stateid', 'LEFT');
		$this->db->join(LOCATIONS . ' as c', 'c.id = st.countryid', 'LEFT');
		$this->db->join(NEIGHBORHOOD . ' as n', 'u.id = n.neighborhoods', 'LEFT');
		$this->db->where('u.status', 'Active');
		$this->db->where('u.featured', '1');
		$this->db->group_by('u.id');
		$this->db->order_by('u.name','asc');
		//$this->db->limit(180);
		$city = $this->db->get();
		//echo $this->db->last_query();die;
		//return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}

	public function Featured_city1()
	{
		$this->db->select(CITY . '.*,' . CITY . '.seourl as cityurl');
		$this->db->from(CITY);
		//$this->db->where('u.status','Active','u.featured','1');
		//$this->db->where('u.featured','1');
		//$this->db->join(STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid');
		//	$this->db->join(COUNTRY_LIST,COUNTRY_LIST.'.id = '.STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid');
		//$this->db->where('.COUNTRY_LIST,COUNTRY_LIST.'.id NOT IN ('.STATE_TAX,STATE_TAX.'.id = '.CITY.'.stateid')', NULL, FALSE);
		$city = $this->db->get();
		//echo $this->db->last_query();
		//	return $result =$query->result_array();
		//echo "<pre>";print_r($result);die;
		return $city;
	}

	public function FeaturedExperice()
	{
		$this->db->select('*');
		$this->db->from(EXPERIENCE);
		$this->db->where('featured', '1');
		$featured_experice = $this->db->get();
		return $featured_experice;
	}

	public function featured_all($cat_type_id)
	{
		// $sel_featuredExp = "select exp.*,et.experience_title,et.id as e_type_id from ".EXPERIENCE." as exp left join ".EXPERIENCE_PHOTOS." as ph on ph.product_id=exp.experience_id inner join ". EXPERIENCE_TYPE . " as et on et.id= where exp.status='1' and exp.type_id= ".$cat_type_id . " group by exp.experience_id order by exp.added_date desc ";
		// $featuredExperiences = $this->ExecuteQuery($sel_featuredExp);
		// return $featuredExperiences;
	}

	public function CityCountDisplay($SelValue = '', $condition = '', $dbname = '')
	{
		$this->db->select($SelValue);
		$this->db->from($dbname);
		$this->db->group_by($condition);
		$cityCount = $this->db->get();
		return $cityCount;
	}

	public function cityall($city_name, $country, $state_name = "", $addressLatLong)
	{  
		$product_titlelangarray=language_dynamic_admin_enable_submit(array('b.product_title'),2); //Need to Update here
        if(count($product_titlelangarray)>0) {
            $product_titlelangarray=",".implode(",",$product_titlelangarray);
        } else $product_titlelangarray="";

        $list_valuelangarray=language_dynamic_admin_enable_submit(array('lsv.list_value'),2); //Need to Update here
        if(count($list_valuelangarray)>0) {
            $list_valuelangarray=",".implode(",",$list_valuelangarray);
        } else $list_valuelangarray="";

		
		//return $list_valuelangarray.$product_titlelangarray;
		if ($addressLatLong['minLat'] != "" && $addressLatLong['maxLat'] != "" && $addressLatLong['minLong'] != "" && $addressLatLong['maxLong'] != "") {
			$latLongQuery = '(a.lat BETWEEN "' . $addressLatLong['minLat'] . '" AND "' . $addressLatLong['maxLat'] . '" ) AND (a.lang BETWEEN "' . $addressLatLong['minLong'] . '" AND "' . $addressLatLong['maxLong'] . '" )';
			$SQL_QUERY = "SELECT a.id as cityid,a.city,b.seourl,a.state,a.country,b.id,b.product_title,b.product_title".$product_titlelangarray.",b.description,b.description".$product_titlelangarray.",b.price,b.instant_pay,b.currency,lsv.list_value".$list_valuelangarray.",c.product_id,c.product_image,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where R.review_type='0' and R.product_id= b.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= b.id and Rw.status='Active') as avg_val FROM " . PRODUCT_ADDRESS_NEW . " a INNER JOIN " . PRODUCT . " b on b.id = a.productId LEFT JOIN " . PRODUCT_PHOTOS . " c on c.product_id = b.id LEFT JOIN ".LISTSPACE_VALUES." lsv on lsv.id=b.home_type where $latLongQuery AND b.status='Publish' group by c.product_id ORDER BY b.id ASC LIMIT 0,8";
		} else {
			$SQL_QUERY = "SELECT a.id as cityid,a.city,b.seourl,a.state,a.country,b.id,b.listings,b.product_title,b.product_title".$product_titlelangarray.",b.description,b.description".$product_titlelangarray.",b.price,b.instant_pay,b.currency,lsv.list_value".$list_valuelangarray.",c.product_id,c.product_image,(select lc.child_name from " . LISTING_CHILD . " as lc where lc.id=b.accommodates) as guestcapacity ,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where R.review_type='0' and R.product_id= b.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= b.id and Rw.status='Active') as avg_val FROM " . PRODUCT_ADDRESS_NEW . " a INNER JOIN " . PRODUCT . " b on b.id = a.productId LEFT JOIN " . PRODUCT_PHOTOS . " c on c.product_id = b.id LEFT JOIN ".LISTSPACE_VALUES." lsv on lsv.id=b.home_type where LOWER(a.city) LIKE LOWER('" . $city_name . "%') AND LOWER(a.country) LIKE LOWER('" . $country . "%') AND b.status='Publish' group by c.product_id ORDER BY b.id ASC LIMIT 0,8";
			
			//echo $SQL_QUERY; exit;
		}
		$city_list = $this->ExecuteQuery($SQL_QUERY);
		return $city_list;
	}
	
	
	
	public function cityall_listing($city_name,$perPage,$start)
	{  
		$this->db->reconnect();
		$langarray=language_dynamic_admin_enable_submit(array('b.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";
		
		$langarray_desc=language_dynamic_admin_enable_submit(array('b.description'),2); //Need to Update here
        if(count($langarray_desc)>0) {
            $langarray_desc=",".implode(",",$langarray_desc);
        } else $langarray_desc="";

			$SQL_QUERY = "SELECT a.id as cityid,a.city,b.seourl,b.instant_pay,a.state,a.country,b.id,b.product_title'.$langarray.',b.description'.$langarray_desc.',b.price,b.currency,lsv.list_value,c.product_id,c.product_image,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where  R.review_type='0' and  R.product_id= b.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= b.id and Rw.status='Active') as avg_val FROM " . PRODUCT_ADDRESS_NEW . " a INNER JOIN " . PRODUCT . " b on b.id = a.productId LEFT JOIN " . PRODUCT_PHOTOS . " c on c.product_id = b.id LEFT JOIN ".LISTSPACE_VALUES." lsv on lsv.id=b.home_type where LOWER(a.city) LIKE LOWER('" . $city_name . "%') AND b.status='Publish' group by c.product_id LIMIT 0,8";
			
			//echo $SQL_QUERY; exit;
		
		$city_list = $this->ExecuteQuery($SQL_QUERY);
		return $city_list;
	}
	public function cityall_listing_count($city_name)
	{  
			$SQL_QUERY = "SELECT a.id as cityid,a.city,b.seourl,a.state,a.country,b.id,b.product_title,b.price,b.currency,lsv.list_value,c.product_id,c.product_image,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where R.product_id= b.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.product_id= b.id and Rw.status='Active') as avg_val FROM " . PRODUCT_ADDRESS_NEW . " a INNER JOIN " . PRODUCT . " b on b.id = a.productId LEFT JOIN " . PRODUCT_PHOTOS . " c on c.product_id = b.id LEFT JOIN ".LISTSPACE_VALUES." lsv on lsv.id=b.home_type where LOWER(a.city) LIKE LOWER('" . $city_name . "%') AND b.status='Publish' group by c.product_id";
			
			//echo $SQL_QUERY; exit;
		
		$city_list = $this->ExecuteQuery($SQL_QUERY);
		return $city_list;
	}
	public function cityall_listing_exp($city_name,$perPage,$start)
	{  
			$SQL_QUERY = "select p.*,(select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.review_type='0' and R.product_id= p.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . EXPERIENCE_REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= p.experience_id and Rw.status='Active') as avg_val,extyp.experience_title as type_title,d.from_date,rp.product_image as product_image,a.city from " . EXPERIENCE . " p  
			LEFT JOIN " . EXPERIENCE_TYPE . " extyp on extyp.id=p.type_id
			LEFT JOIN " . EXPERIENCE_ADDR . " a on a.experience_id=p.experience_id 
			LEFT JOIN " . EXPERIENCE_PHOTOS . " rp on rp.product_id=p.experience_id
			LEFT JOIN " . EXPERIENCE_DATES . " d on d.experience_id=p.experience_id
			LEFT JOIN " . EXPERIENCE_TIMING . " dt on dt.exp_dates_id=d.id where d.from_date > '".date('Y-m-d')."' and extyp.status='Active' and p.status='1' and LOWER(a.city) LIKE LOWER('" . $city_name . "%') AND EXISTS
			( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
			)  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id ) GROUP BY p.experience_id LIMIT 0,8";
		$city_list = $this->ExecuteQuery($SQL_QUERY);
		return $city_list;
	}
	public function cityall_listing_exp_count($city_name)
	{  
			$SQL_QUERY = "select p.*,extyp.experience_title as type_title,d.from_date,rp.product_image as product_image,a.city from " . EXPERIENCE . " p  
			LEFT JOIN " . EXPERIENCE_TYPE . " extyp on extyp.id=p.type_id
			LEFT JOIN " . EXPERIENCE_ADDR . " a on a.experience_id=p.experience_id 
			LEFT JOIN " . EXPERIENCE_PHOTOS . " rp on rp.product_id=p.experience_id
			LEFT JOIN " . EXPERIENCE_DATES . " d on d.experience_id=p.experience_id
			LEFT JOIN " . EXPERIENCE_TIMING . " dt on dt.exp_dates_id=d.id where d.from_date > '".date('Y-m-d')."' and extyp.status='Active' and p.status='1' and LOWER(a.city) LIKE LOWER('" . $city_name . "%') AND EXISTS
			( select c.id FROM fc_experience_dates c where c.status='0' and c.experience_id=p.experience_id
			)  AND EXISTS (select count(td.id) FROM fc_experience_time_sheet td where td.status='1' and td.experience_id=p.experience_id ) GROUP BY p.experience_id";
		$city_list = $this->ExecuteQuery($SQL_QUERY);
		return $city_list;
	}

	public function get_city_list($start,$perPage) {
	//$this->db->distinct();
	/*$this->db->select('city,state,country');
	$this->db->from('fc_product_address_new');
	$this->db->group_by('fc_product_address_new.city');
	$this->db->where('city <> ', '');
	$this->db->where('city is NOT NULL', NULL, FALSE);
	$this->db->limit($perPage,$start);
	$query = $this->db->get();*/
	
	$query = $this->db->query("SELECT `city`, `state`, `country` FROM `fc_product_address_new` WHERE `city` <> '' AND city is NOT NULL GROUP BY `fc_product_address_new`.`city` UNION  SELECT `city`, `state`, `country` FROM `fc_experience_address` WHERE `city` <> '' AND city is NOT NULL GROUP BY `fc_experience_address`.`city`  LIMIT ".$start.",".$perPage);
	//echo $this->db->last_query(); exit;
    return $query;
	}

	public function get_city_list_count() {
	//$this->db->distinct();
	/*$this->db->select('city,state,country');
	$this->db->from('fc_product_address_new');
	$this->db->group_by('fc_product_address_new.city');
	$this->db->where('city <> ', '');
	$this->db->where('city is NOT NULL', NULL, FALSE);
	$query = $this->db->get();*/
	$query = $this->db->query("SELECT `city`, `state`, `country` FROM `fc_product_address_new` WHERE `city` <> '' AND city is NOT NULL GROUP BY `fc_product_address_new`.`city` UNION  SELECT `city`, `state`, `country` FROM `fc_experience_address` WHERE `city` <> '' AND city is NOT NULL GROUP BY `fc_experience_address`.`city`  ");
    return $query;
	}
}
