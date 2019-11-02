<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to product management
 *
 * @author Teamtweaks
 *
 */
class Product_model extends My_Model
{

	/**
	 *
	 *
	 * common update code
	 */
	/************* facility details ***************************/
	/*function to insert property image*/
	function insert_property_images($table = '', $insertdata = '', $condition = '')
	{
		$this->db->insert($table, $insertdata, $condition);
		$query = $this->db->affected_rows();
		if ($query == 1) {
			echo '<p class="text-center text-success" id="success">image was successfully uploaded!</p>';
		} else {
			echo '<p class="text-center text-danger" id="danger">Error in uploading </p>';
		}
	}
public function get_all_cancelled_users()
        {
            $this->db->select('*');
            $this->db->from(RENTALENQUIRY . ' as r');
            $this->db->join(USERS . ' as u', "r.user_id=u.id");
            $this->db->where('r.cancelled', 'Yes');
           // $this->db->group_by('r.user_id');
            return $query = $this->db->get_where();
        }

        public function hostcancelled_trip_site_map($prd_id = '', $keyword)
	{
		$this->db->select('*');
		$this->db->from(COMMISSION_TRACKING . ' as c');
		$this->db->join(RENTALENQUIRY . ' as re', 're.Bookingno = c.booking_no', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = re.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
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
		$this->db->select('*,re.dateAdded as bookedDate,p.*,pp.product_image,p.seourl,u.firstname,u.email,re.user_currencycode,re.secDeposit,re.checkin,re.checkout,re.Bookingno,re.currency_cron_id,c.paid_cancel_amount,c.cancel_percentage,c.subtotal');

		$this->db->from(COMMISSION_TRACKING . ' as c');
		$this->db->join(RENTALENQUIRY . ' as re', 're.Bookingno = c.booking_no', 'left');
		$this->db->join(PRODUCT . ' as p', 'p.id = re.prd_id', 'left');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pn', 'pn.productId = p.id', 'left');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', 'p.id = pp.product_id', 'left');
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
        public function get_all_commission_tracking($customer_id)
	{
		$Query = "select * from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no JOIN " . USERS . " u on re.user_id=u.id  where  cancelled = 'yes' AND c.dispute_by = 'Host' AND `Bookingno`='" . $customer_id . "'";
		return $this->ExecuteQuery($Query)->result();
	}
	 public function get_all_commission_tracking_user($booking_no)
	{
		$Query = "select * from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no JOIN " . USERS . " u on re.user_id=u.id JOIN ".PAYMENT." p on re.id = p.EnquiryId where  cancelled = 'yes' AND c.dispute_by != 'Host' AND c.dispute_by != 'Host' AND `Bookingno`='" . $booking_no . "'";
		return $this->ExecuteQuery($Query)->result();
	}
	public function get_commission_track_id($id)
	{
		$Query = "select c.* , re.prd_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where c.booking_no='" . $id . "'";
		return $this->ExecuteQuery($Query);
	}
	public function get_unpaid_reviewcommission_tracking_details($sellerEmail, $id)
        {
            $Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.secDeposit,re.user_currencycode,re.currency_cron_id,re.subTotal from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0'  AND c.booking_no = '" . $id . "' AND  `host_email`='" . $sellerEmail . "'";
			//echo $Query; exit;
            return $this->ExecuteQuery($Query)->result_array();
        }
        public function get_unpaid_reviewcommission_tracking($sellerEmail, $id)
        { 
            $Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.secDeposit,re.user_currencycode,re.currency_cron_id,re.subTotal from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_canel_status = '0' AND c.booking_no = '" . $id . "' AND  `host_email`='" . $sellerEmail . "'";
            return $this->ExecuteQuery($Query)->result_array();
        }

	function getCommonFacilityDetails()
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'Active');
		$this->db->where(LIST_VALUES . '.list_id', '1');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	function getPropertyType()
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'Active');
		$this->db->where(LIST_VALUES . '.list_id', '7');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	function getExtraFacilityDetails()
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'Active');
		$this->db->where(LIST_VALUES . '.list_id', '4');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	function getSpecialFeatureFacilityDetails()
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'Active');
		$this->db->where(LIST_VALUES . '.list_id', '5');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	function getHomeSafetyFacilityDetails()
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'Active');
		$this->db->where(LIST_VALUES . '.list_id', '6');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	/** Get Membership Package Plan **/
	function getMembershipPackage()
	{
		/* 	$this->db->select(FANCYYBOX.'.*');
        $this->db->from(FANCYYBOX);
        $this->db->where(FANCYYBOX.'.status','Publish');

        $query = $this->db->get();
        //$resultContent = $query();
        return $query; */
	}

	function getrentalPhotoDetails($condition = '')
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . '.status', 'active');
		$this->db->where(LIST_VALUES . '.list_id', '1');
		$query = $this->db->get();
		$resultContent = $query->result_array();
		return $resultContent;
	}

	public function coupondetails($condition = '')
	{
		$this->db->select(LIST_VALUES . '.*');
		$this->db->from(LIST_VALUES);
		$this->db->where(LIST_VALUES . 'code', $condition);
	}

	public function add_product($dataArr = '')
	{
		$this->db->insert(PRODUCT, $dataArr);
	}

	public function add_subproduct_insert($dataArr = '')
	{
		$this->db->insert(SUBPRODUCT, $dataArr);
	}

	public function edit_product($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(PRODUCT, $dataArr);
	}

	public function edit_subproduct_update($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(SUBPRODUCT, $dataArr);
	}

	public function view_product($condition = '')
	{
		return $this->db->get_where(PRODUCT, $condition);
	}

	public function get_allthe_details($status, $city, $checkin, $checkout, $id, $rep_code = '', $limit_per_page, $start_index)
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
		if ($checkin != '' && $checkout != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= 'p.datefrom >="' . $checkin . '" AND p.dateto<="' . $checkout . '"';
		} elseif ($checkin != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.datefrom >= "' . $checkin . '" ';
		} elseif ($checkout != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.dateto <= "' . $checkout . '" ';
		}
		$groupby = '';
		if ($id != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.user_id= "' . $id . '" ';
		}
		if ($rep_code != '') {
			if ($whereCond != '') {
				$whereCond .= ' and u.status="Active"';
			} else {
				$whereCond = ' where u.status="Active"';
			}
			$whereCond .= ' and u.rep_code="' . $rep_code . '"';
		}
		$groupby = 'group by p.id';
		$select_qry = "select p.*,pa.city as city_name,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,pb.datefrom as book_datefrom,pb.dateto as book_dateto,ph.product_image as PImg,p.featured,cur.currency_symbols from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " pb on pb.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)
		LEFT JOIN " . CURRENCY . " cur on (cur.currency_type=p.currency)
		" . $whereCond . " 
		" . $groupby . "  
		order by p.created desc
		limit 	" . $start_index . ", " . $limit_per_page . "
		";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public function get_allthe_details_filt($status, $city, $checkin, $checkout, $id, $rep_code = '', $limit_per_page, $start_index, $name_filter)
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
			$whereCond .= "p.product_title like '%".$name_filter."%'";
		}
		if ($checkin != '' && $checkout != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= 'p.datefrom >="' . $checkin . '" AND p.dateto<="' . $checkout . '"';
		} elseif ($checkin != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.datefrom >= "' . $checkin . '" ';
		} elseif ($checkout != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.dateto <= "' . $checkout . '" ';
		}
		$groupby = '';
		if ($id != '') {
			if ($whereCond != '') {
				$whereCond .= ' and ';
			} else {
				$whereCond = ' where ';
			}
			$whereCond .= ' p.user_id= "' . $id . '" ';
		}
		if ($rep_code != '') {
			if ($whereCond != '') {
				$whereCond .= ' and u.status="Active"';
			} else {
				$whereCond = ' where u.status="Active"';
			}
			$whereCond .= ' and u.rep_code="' . $rep_code . '"';
		}
		$groupby = 'group by p.id';
		$select_qry = "select p.*,pa.city as city_name,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.lat as latitude,pa.lang as longitude,pb.datefrom as book_datefrom,pb.dateto as book_dateto,ph.product_image as PImg,p.featured,cur.currency_symbols from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " pb on pb.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)
		LEFT JOIN " . CURRENCY . " cur on (cur.currency_type=p.currency)
		" . $whereCond . " 
		" . $groupby . "  
		order by p.created desc
		limit 	" . $start_index . ", " . $limit_per_page . "
		";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	function get_contents()
	{
		$this->db->select('*');
		$this->db->from('fc_product');
		$query = $this->db->get();
		return $result = $query->result();
	}

	public
	function view_product_details1($condition = '')
	{
		$select_qry = "select p.*,u.firstname,u.lastname,u.image as user_image,u.feature_product,pa.latitude,pa.longitude,pb.datefrom,pb.dateto,ph.product_image as PImg,p.featured from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " pb on pb.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function get_particular_details($fields = '', $table = '', $condition = '', $sortArr = '')
	{
		//echo "<pre>";print_r($condition);
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

	public
	function get_search_options($condition)
	{
		$select_qry = "select p.*,cit.name as city_name,cit.id as c_id,u.firstname,u.lastname from " . PRODUCT . " p
		LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
		LEFT JOIN " . CITY . " cit on pa.city = cit.id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id)" . $condition;
		$searchOption = $this->ExecuteQuery($select_qry);
		return $searchOption;
	}

	/*Getting similar listings*/
	public
	function view_product_details_distance_list($lat, $lon, $condition = '')
	{
		$list_valuelangarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($list_valuelangarray)>0) {
            $list_valuelangarray=",".implode(",",$list_valuelangarray);
        } else $list_valuelangarray="";
		
		$listdesc_valuelangarray=language_dynamic_admin_enable_submit(array('p.description'),2); //Need to Update here
        if(count($listdesc_valuelangarray)>0) {
            $listdesc_valuelangarray=",".implode(",",$listdesc_valuelangarray);
        } else $listdesc_valuelangarray="";
		
		$aLong = $lon + 0.05;
		$bLong = $lon - 0.05;
		$aLat = $lat + 0.05;
		$bLat = $lat - 0.05;
		$whereNew = 'where (pa.lat < ' . $aLat . ' AND pa.lat > ' . $bLat . ' AND pa.lang < ' . $aLong . ' AND pa.lang >' . $bLong . ') AND ' . $condition;
		$select_qry = "select p.id,p.product_title".$list_valuelangarray.",p.description".$listdesc_valuelangarray.",p.seourl, (select AVG(c.total_review) FROM fc_review c where c.review_type='0' and c.product_id=p.id and c.status='Active') as rate, (select lc.child_name from " . LISTING_CHILD . " as lc where lc.id=p.accommodates) as guestcapacity ,(select count(c.id) FROM fc_review c where c.review_type='0' and c.product_id=p.id and c.status='Active') as num_reviewers, p.room_type, p.product_title, p.currency, pa.city as city_name, pa.lat as latitude, pa.lang as longitude,p.listings, u.firstname, u.lastname, u.image as user_image, u.id as userId, ph.product_image as PImg, p.price
        FROM " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . REVIEW . " r on r.product_id=p.id
		LEFT JOIN " . USERS . " u on u.id=p.user_id " . $whereNew;
		$distanceList = $this->ExecuteQuery($select_qry);
		return $distanceList;
	}

	public
	function get_featured_details($pid = '0')
	{
		$Query = "select p.*,u.firstname,u.lastname,u.image,u.feature_product from " . PRODUCT . " p LEFT JOIN " . USERS . " u on u.id=p.user_id where p.seller_product_id=" . $pid . " and p.status='Publish'";
		$productList = $this->ExecuteQuery($Query);
		$productList->mode = 'sell_product';
		if ($productList->num_rows() != 1) {
			$Query = "select p.*,u.firstname,u.lastname,u.image,u.feature_product from " . USER_PRODUCTS . " p LEFT JOIN " . USERS . " u on u.id=p.user_id where p.seller_product_id=" . $pid . " and p.status='Publish'";
			$productList = $this->ExecuteQuery($Query);
			$productList->mode = 'user_product';
		}
		return $productList;
	}

	public
	function get_wants_product($wantList)
	{
		$productList = '';
		if ($wantList->num_rows() == 1) {
			$productIds = array_filter(explode(',', $wantList->row()->product_id));
			$this->db->where_in('p.seller_product_id', $productIds);
			$this->db->where('p.status', 'Publish');
			$this->db->select('p.*,u.firstname,u.lastname,u.image,u.feature_product');
			$this->db->from(PRODUCT . ' as p');
			$this->db->join(USERS . ' as u', 'u.id=p.user_id');
			$productList = $this->db->get();
		}
		return $productList;
	}

	public
	function get_notsell_wants_product($wantList)
	{
		$productList = '';
		if ($wantList->num_rows() == 1) {
			$productIds = array_filter(explode(',', $wantList->row()->product_id));
			$this->db->where_in('p.seller_product_id', $productIds);
			$this->db->where('p.status', 'Publish');
			$this->db->select('p.*,u.firstname,u.lastname,u.image,u.feature_product');
			$this->db->from(USER_PRODUCTS . ' as p');
			$this->db->join(USERS . ' as u', 'u.id=p.user_id');
			$productList = $this->db->get();
		}
		return $productList;
	}

	public
	function view_notsell_product_details($condition = '')
	{
		$select_qry = "select p.*,u.firstname,u.lastname,u.image,u.feature_product from " . USER_PRODUCTS . " p LEFT JOIN " . USERS . " u on u.id=p.user_id " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function view_atrribute_details()
	{
		$select_qry = "select * from " . ATTRIBUTE . " where status='Active'";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_subproduct_details($prdId = '')
	{
		$select_qry = "select * from " . SUBPRODUCT . " where product_id = '" . $prdId . "'";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_subproduct_details_join($prdId = '')
	{
		$select_qry = "select a.*,b.attr_name from " . SUBPRODUCT . " a join " . PRODUCT_ATTRIBUTE . " b on a.attr_id = b.id where a.product_id = '" . $prdId . "'";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_shopping_cart_subproduct_val($userid = '', $prdId = '')
	{
		$select_qry = "select quantity,attribute_values from " . SHOPPING_CART . " where product_id = '" . $prdId . "' and user_id='" . $userid . "'";
		return $shopAttrList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_product_atrribute_details()
	{
		$select_qry = "select * from " . PRODUCT_ATTRIBUTE . " where status='Active'";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_category_details()
	{
		$select_qry = "select * from " . CATEGORY . " where rootID=0";
		$categoryList = $this->ExecuteQuery($select_qry);
		$catView = '';
		$Admpriv = 0;
		$SubPrivi = '';
		foreach ($categoryList->result() as $CatRow) {
			$catView .= $this->view_category_list($CatRow, '1');
			$sel_qry = "select * from " . CATEGORY . " where rootID='" . $CatRow->id . "'  ";
			$SubList = $this->ExecuteQuery($sel_qry);
			foreach ($SubList->result() as $SubCatRow) {
				$catView .= $this->view_category_list($SubCatRow, '2');
				$sel_qry1 = "select * from " . CATEGORY . " where rootID='" . $SubCatRow->id . "'  ";
				$SubList1 = $this->ExecuteQuery($sel_qry1);
				foreach ($SubList1->result() as $SubCatRow1) {
					$catView .= $this->view_category_list($SubCatRow1, '3');
					$sel_qry2 = "select * from " . CATEGORY . " where rootID='" . $SubCatRow1->id . "'  ";
					$SubList2 = $this->ExecuteQuery($sel_qry2);
					foreach ($SubList2->result() as $SubCatRow2) {
						$catView .= $this->view_category_list($SubCatRow2, '4');
					}
				}
			}
		}
		return $catView;
	}

	public
	function view_category_list($CatRow, $val)
	{
		$SubcatView = '';
		$SubcatView .= '<span class="cat' . $val . '"><input name="category_id[]" class="checkbox" type="checkbox" value="' . $CatRow->id . '" tabindex="7"><strong>' . $CatRow->cat_name . ' &nbsp;</strong></span>';
		return $SubcatView;
	}

	public
	function get_category_details($catList = '')
	{
		$catListArr = explode(',', $catList);
		$select_qry = "select * from " . CATEGORY . " where rootID=0";
		$categoryList = $this->ExecuteQuery($select_qry);
		$catView = '';
		$Admpriv = 0;
		$SubPrivi = '';
		foreach ($categoryList->result() as $CatRow) {
			$catView .= $this->get_category_list($CatRow, '1', $catListArr);
			$sel_qry = "select * from " . CATEGORY . " where rootID='" . $CatRow->id . "'  ";
			$SubList = $this->ExecuteQuery($sel_qry);
			foreach ($SubList->result() as $SubCatRow) {
				$catView .= $this->get_category_list($SubCatRow, '2', $catListArr);
				$sel_qry1 = "select * from " . CATEGORY . " where rootID='" . $SubCatRow->id . "'  ";
				$SubList1 = $this->ExecuteQuery($sel_qry1);
				foreach ($SubList1->result() as $SubCatRow1) {
					$catView .= $this->get_category_list($SubCatRow1, '3', $catListArr);
					$sel_qry2 = "select * from " . CATEGORY . " where rootID='" . $SubCatRow1->id . "'  ";
					$SubList2 = $this->ExecuteQuery($sel_qry2);
					foreach ($SubList2->result() as $SubCatRow2) {
						$catView .= $this->get_category_list($SubCatRow2, '4', $catListArr);
					}
				}
			}
		}
		return $catView;
	}

	public
	function get_category_list($CatRow, $val, $catListArr = '')
	{
		$SubcatView = '';
		if (in_array($CatRow->id, $catListArr)) {
			$checkStr = 'checked="checked"';
		} else {
			$checkStr = '';
		}
		$SubcatView .= '<span class="cat' . $val . '"><input name="category_id[]" ' . $checkStr . ' class="checkbox" type="checkbox" value="' . $CatRow->id . '" tabindex="7"><strong>' . $CatRow->cat_name . ' &nbsp;</strong></span>';
		return $SubcatView;
	}

	public
	function get_cat_list($ids = '')
	{
		$this->db->where_in('id', explode(',', $ids));
		return $this->db->get(CATEGORY);
	}

	public
	function get_city_meta_details($cityname = '')
	{
		$this->db->where('name', trim($cityname));
		return $this->db->get(CITY);
	}

	public
	function get_top_users_in_category($cat = '')
	{
		$productArr = array();
		$userArr = array();
		$userCountArr = array();
		$condition = " where p.category_id like '" . $cat . ",%' AND p.status = 'Publish' OR p.category_id like '%," . $cat . "' AND p.status = 'Publish' OR p.category_id like '%," . $cat . ",%' AND p.status = 'Publish' OR p.category_id='" . $cat . "' AND p.status = 'Publish'";
		$productDetails = $this->view_product_details($condition);
		if ($productDetails->num_rows() > 0) {
			foreach ($productDetails->result() as $productRow) {
				if (!in_array($productRow->id, $productArr)) {
					array_push($productArr, $productRow->id);
					if ($productRow->user_id != '') {
						if (!in_array($productRow->user_id, $userArr)) {
							array_push($userArr, $productRow->user_id);
							$userCountArr[$productRow->user_id] = 1;
						} else {
							$userCountArr[$productRow->user_id]++;
						}
					}
				}
			}
		}
		arsort($userCountArr);
		return $userCountArr;
	}

	public
	function view_product_details($condition = '')
	{
		//$select_qry = "select p.*,u.firstname,u.lastname,u.image as user_image,u.feature_product,pa.latitude,pa.longitude,pb.datefrom,pb.dateto,ph.product_image as PImg,p.featured from ".PRODUCT." p
		$select_qry = "select p.*,cit.name as city_name,cit.id as ci_it,u.firstname,u.lastname,u.image as user_image,u.feature_product,u.user_name,u.phone_no,u.email,u.address,u.address2,u.city as addr3,pa.latitude,pa.longitude,pb.datefrom as book_datefrom,pb.dateto as book_dateto,ph.product_image as PImg,p.featured from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " pb on pb.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " ph on p.id=ph.product_id
		LEFT JOIN " . CITY . " cit on pa.city = cit.id  
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		//echo $select_qry;die;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
		//echo "<pre>";print_r($productList->result());
		//echo $this->db->last_query(); die;
	}

	public
	function get_recent_like_users($pid = '', $limit = '10', $sort = 'desc')
	{
		$Query = 'select pl.*, p.product_name, p.likes, u.firstname, u.lastname,u.image from ' . PRODUCT_LIKES . ' pl 
					JOIN ' . PRODUCT . ' p on p.seller_product_id=pl.product_id 
					JOIN ' . USERS . ' u on u.id=pl.user_id and u.status="Active"
					where pl.product_id="' . $pid . '" order by pl.id ' . $sort . ' limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public
	function get_recent_user_likes($uid = '', $pid = '', $limit = '3', $sort = 'desc')
	{
		$condition = '';
		if ($pid != '') {
			$condition = ' and pl.product_id != "' . $pid . '" ';
		}
		$Query = 'select pl.*,u.lastname,u.firstname,u.image,p.product_name,p.id as PID,p.created,p.sale_price,p.image from ' . PRODUCT_LIKES . ' pl
					JOIN ' . USERS . ' u on u.id=pl.user_id 
					JOIN ' . PRODUCT . ' p on p.seller_product_id=pl.product_id
					JOIN ' . USERS . ' u1 on u1.id=p.user_id and u1.group="Seller" and u1.status="Active"
					where pl.user_id = "' . $uid . '" ' . $condition . ' order by pl.id ' . $sort . ' limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public
	function get_like_user_full_details($pid = '0')
	{
		$Query = "select u.* from " . PRODUCT_LIKES . ' p
					JOIN ' . USERS . ' u on u.id=p.user_id
					where p.product_id=' . $pid;
		return $this->ExecuteQuery($Query);
	}

	public
	function getCategoryValues($selVal, $whereCond)
	{
		$sel = 'select ' . $selVal . ' from ' . CATEGORY . ' c LEFT JOIN ' . CATEGORY . ' sbc ON c.id = sbc.rootID ' . $whereCond . ' ';
		return $this->ExecuteQuery($sel);
	}

	public
	function getCategoryResults($selVal, $whereCond)
	{
		$sel = 'select ' . $selVal . ' from ' . CATEGORY . ' ' . $whereCond . ' ';
		return $this->ExecuteQuery($sel);
	}

	public
	function searchShopyByCategory($whereCond)
	{
		$sel = 'select p.* from ' . PRODUCT . ' p 
		 		LEFT JOIN ' . USERS . ' u on u.id=p.user_id 
		 		' . $whereCond . ' ';
		return $this->ExecuteQuery($sel);
	}

	public
	function add_user_product($uid = '')
	{
		$seller_product_id = mktime();
		$checkId = $this->check_product_id($seller_product_id);
		while ($checkId->num_rows() > 0) {
			$seller_product_id = mktime();
			$checkId = $this->check_product_id($seller_product_id);
		}
		$dataArr = array('product_name' => $this->input->post('name'), 'seourl' => url_title($this->input->post('name'), '-'), 'web_link' => $this->input->post('link'), 'category_id' => $this->input->post('category'), 'excerpt' => $this->input->post('note'), 'image' => $this->input->post('image'), 'user_id' => $uid, 'seller_product_id' => $seller_product_id);
		$this->simple_insert(USER_PRODUCTS, $dataArr);
		return $seller_product_id;
	}

	public
	function check_product_id($pid = '')
	{
		$checkId = $this->get_all_details(USER_PRODUCTS, array('seller_product_id' => $pid));
		if ($checkId->num_rows() == 0) {
			$checkId = $this->get_all_details(PRODUCT, array('seller_product_id' => $pid));
		}
		return $checkId;
	}

	public
	function get_products_by_category($categoryid = '', $sort = 'desc')
	{
		$Query = "select p.*,u.lastname,u.firstname,u.image from " . PRODUCT . " p
			LEFT JOIN " . USERS . " u on u.id=p.user_id
			where p.status='Publish' and FIND_IN_SET('" . $categoryid . "',p.category_id) order by p.`created` " . $sort;
		return $this->ExecuteQuery($Query);
	}

	public
	function view_product_comments_details($condition = '')
	{
		$select_qry = "select p.product_name,c.product_id,u.firstname,u.lastname,u.image,c.comments ,u.email,c.id,c.status,c.user_id as CUID
		from " . PRODUCT_COMMENTS . " c 
		LEFT JOIN " . USERS . " u on u.id=c.user_id 
		LEFT JOIN " . PRODUCT . " p on p.seller_product_id=c.product_id " . $condition;
		$productComment = $this->ExecuteQuery($select_qry);
		return $productComment;
	}

	public
	function Update_Product_Comment_Count($product_id)
	{
		$Query = "UPDATE " . PRODUCT . " SET comment_count=(comment_count + 1) WHERE seller_product_id='" . $product_id . "'";
		$this->ExecuteQuery($Query);
	}

	public
	function Update_Product_Comment_Count_Reduce($product_id)
	{
		$Query = "UPDATE " . PRODUCT . " SET comment_count=(comment_count - 1) WHERE seller_product_id='" . $product_id . "'";
		return $this->ExecuteQuery($Query);
	}

	public
	function get_products_search_results($search_key = '', $limit = '5')
	{
		$Query = 'select p.* from ' . PRODUCT . ' p 
				LEFT JOIN ' . USERS . ' u on u.id=p.user_id
				where p.product_name like "%' . $search_key . '%" and p.status="Publish" and p.quantity>0 and u.status="Active" and u.group="Seller"
				or p.product_name like "%' . $search_key . '%" and p.status="Publish" and p.quantity>0 and p.user_id=0
				limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public
	function get_user_search_results($search_key = '', $limit = '5')
	{
		$Query = 'select * from ' . USERS . ' where full_name like "%' . $search_key . '%" and status="Active" OR user_name like "%' . $search_key . '%" and status="Active" limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public
	function get_product_full_details($pid = '0')
	{
		$Query = "select p.*,u.firstname,u.lastname,u.image,u.feature_product,u.email,u.email_notifications,u.notifications from " . PRODUCT . " p JOIN " . USERS . " u on u.id=p.user_id where p.seller_product_id='" . $pid . "'";
		$productDetails = $this->ExecuteQuery($Query);
		if ($productDetails->num_rows() == 0) {
			$Query = "select p.*,u.firstname,u.lastname,u.image,u.feature_product,u.email,u.email_notifications,u.notifications from " . USER_PRODUCTS . " p JOIN " . USERS . " u on u.id=p.user_id where p.seller_product_id='" . $pid . "'";
			$productDetails = $this->ExecuteQuery($Query);
			$productDetails->prodmode = 'user';
		} else {
			$productDetails->prodmode = 'seller';
		}
		return $productDetails;
	}

	public
	function get_user_created_lists($pid = '0')
	{
		$Query = "select * from " . LISTS_DETAILS . " where FIND_IN_SET('" . $pid . "',product_id)";
		return $this->ExecuteQuery($Query);
	}

	function view_product1($product_id = '')
	{
		$this->db->select('p.*,u.id as OwnerId,
		pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude,p.datefrom as DATEFROM,p.dateto as DateTo, pf.feature, pf.google_map, pf.add_feature, pf.rentals_policy, pf.trams_condition, pf.confirm_email, pf.order_email, pf.invoice_template, pb.datefrom, pb.dateto, pb.expiredate, pa.city as cityname,pa.street, pa.country as CountryName, pa.state as StateName');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->join(PRODUCT_FEATURES . ' as pf', "pf.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_BOOKING . ' as pb', "pb.product_id=p.id", "LEFT");
		$this->db->where('p.id', $product_id);
		$this->db->group_by('p.id');
		//echo $this->db->last_query(); die;
		return $query = $this->db->get();
	}

	/************Product Listing***************/
	public function view_product_details_site($condition = '')
	{
		$langarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

        $descriptionlangarray=language_dynamic_admin_enable_submit(array('p.description'),2); //Need to Update here
        if(count($descriptionlangarray)>0) {
            $descriptionlangarray=",".implode(",",$descriptionlangarray);
        } else $descriptionlangarray="";

        $spacelangarray=language_dynamic_admin_enable_submit(array('p.space'),2); //Need to Update here
        if(count($spacelangarray)>0) {
            $spacelangarray=",".implode(",",$spacelangarray);
        } else $spacelangarray="";

        $other_thingnotelangarray=language_dynamic_admin_enable_submit(array('p.other_thingnote'),2); //Need to Update here
        if(count($other_thingnotelangarray)>0) {
            $other_thingnotelangarray=",".implode(",",$other_thingnotelangarray);
        } else $other_thingnotelangarray="";

        $house_ruleslangarray=language_dynamic_admin_enable_submit(array('p.house_rules'),2); //Need to Update here
        if(count($house_ruleslangarray)>0) {
            $house_ruleslangarray=",".implode(",",$house_ruleslangarray);
        } else $house_ruleslangarray="";

        $guest_accesslangarray=language_dynamic_admin_enable_submit(array('p.guest_access'),2); //Need to Update here
        if(count($guest_accesslangarray)>0) {
            $guest_accesslangarray=",".implode(",",$guest_accesslangarray);
        } else $guest_accesslangarray="";

        $interact_guestlangarray=language_dynamic_admin_enable_submit(array('p.interact_guest'),2); //Need to Update here
        if(count($interact_guestlangarray)>0) {
            $interact_guestlangarray=",".implode(",",$interact_guestlangarray);
        } else $interact_guestlangarray="";

        $neighbor_overviewlangarray=language_dynamic_admin_enable_submit(array('p.neighbor_overview'),2); //Need to Update here
        if(count($neighbor_overviewlangarray)>0) {
            $neighbor_overviewlangarray=",".implode(",",$neighbor_overviewlangarray);
        } else $neighbor_overviewlangarray="";

			$cancel_descriptionlangarray=language_dynamic_admin_enable_submit(array('p.cancel_description'),2); //Need to Update here
        if(count($cancel_descriptionlangarray)>0) {
            $cancel_descriptionlangarray=",".implode(",",$cancel_descriptionlangarray);
        } else $cancel_descriptionlangarray="";

        $meta_titlelangarray=language_dynamic_admin_enable_submit(array('p.meta_title'),2); //Need to Update here
        if(count($meta_titlelangarray)>0) {
            $meta_titlelangarray=",".implode(",",$meta_titlelangarray);
        } else $meta_titlelangarray="";

        $meta_keywordlangarray=language_dynamic_admin_enable_submit(array('p.meta_keyword'),2); //Need to Update here
        if(count($meta_keywordlangarray)>0) {
            $meta_keywordlangarray=",".implode(",",$meta_keywordlangarray);
        } else $meta_keywordlangarray="";

        $meta_descriptionlangarray=language_dynamic_admin_enable_submit(array('p.meta_description'),2); //Need to Update here
        if(count($meta_descriptionlangarray)>0) {
            $meta_descriptionlangarray=",".implode(",",$meta_descriptionlangarray);
        } else $meta_descriptionlangarray="";


		$select_qry = "select p.product_name,p.cancel_percentage,p.product_title".$langarray.",p.id,p.seourl,p.price,p.price_range,p.description".$descriptionlangarray.",p.user_id,p.list_name,p.list_value,p.comment_count,p.status,p.home_type,p.room_type,p.currency,p.instant_pay,p.request_to_book,p.space".$spacelangarray.",p.other_thingnote".$other_thingnotelangarray.",p.house_rules".$house_ruleslangarray.",p.guest_access".$guest_accesslangarray.",p.interact_guest".$interact_guestlangarray.",p.listings,p.cancellation_policy,p.security_deposit,p.cancel_description".$cancel_descriptionlangarray.",p.neighbor_overview".$neighbor_overviewlangarray.",p.meta_title".$meta_titlelangarray.",p.meta_keyword".$meta_keywordlangarray.",p.meta_description".$meta_descriptionlangarray.",p.order,p.contact_count,
						u.id as userid,
						pa.latitude,pa.longitude,pa.city,
						c.name as city_name,c.meta_title as pdt_meta_title ,c.meta_keyword as pdt_meta_kwd,c.meta_description as pdt_meta_desc,c.seourl as cityurl,
						
						s.name as statename,s.meta_title as statemtitle,s.meta_keyword as statemkey,s.meta_description as statemdesc,s.seourl as stateurl
						from " . PRODUCT . " p 
						LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
						LEFT JOIN " . CITY . " c on c.id=pa.city
						LEFT JOIN " . STATE_TAX . " s on s.id=pa.state
						LEFT JOIN " . PRODUCT_BOOKING . " b on b.product_id=p.id
						
						LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		//pp.product_image ,LEFT JOIN ".PRODUCT_PHOTOS." pp on pp.product_id=p.id
		$productList = $this->ExecuteQuery($select_qry);
		//	echo $this->db->last_query(); die;
		return $productList;
	}

	public
	function product_details($Cont2)
	{
		// 		echo($Cont2);die;
		$this->db->select('p.*,pp.product_image');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		if ($Cont2 != '') {
			$this->db->where('p.status', $Cont2);
		}
		$this->db->group_by('p.id');
		$this->db->order_by('p.id', 'desc');
		return $query = $this->db->get();
		/*//$product_qry = "select image from ".PRODUCT." ";
        //$product_qry1 = $this->ExecuteQuery($product_qry);
        //return $product_qry1->result();
        $this->db->select('p.*,pp.product_image,c.latitude,s.data as shedule');
        $this->db->from(PRODUCT.' as p');
        $this->db->join(PRODUCT_ADDRESS.' as pa',"pa.product_id=p.id","LEFT");
        $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");
        $this->db->join(CITY.' as c',"c.id=pa.city","LEFT");
        $this->db->join('schedule as s',"s.id=p.id","LEFT");
        $this->db->where_in('p.user_id',$condition);
        if($Cont2!=''){
            $this->db->where('p.status',$Cont2);
        }
        $this->db->group_by('p.id');
        $this->db->order_by('p.id','desc');

        return $query = $this->db->get();*/
	}

	public
	function Display_product_image_details()
	{
		$select_qry = "select product_id,product_image from " . PRODUCT_PHOTOS . " group by product_id order by imgPriority desc";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function view_cities($text)
	{
		/*$select_qry = "select c.name,s.name as state_name,l.name as country_name from ".CITY." c
                LEFT JOIN ".STATE_TAX." as s on s.id=c.stateid
                LEFT JOIN ".LOCATIONS." as l on l.id=c.countryid
                where c.name LIKE '".$text."%' order by c.name asc";
        $cityList = $this->ExecuteQuery($select_qry);
        return $cityList->result();*/
		$this->db->select('c.name,states_list.name as State,country_list.country_code,country_list.name as country_name');
		$this->db->from(CITY . ' as c');
		/* $this->db->join(PRODUCT_ADDRESS.' as pa',"pa.city=c.id","LEFT");
        $this->db->join(PRODUCT.' as p',"pa.product_id=p.id and p.status='Publish'","LEFT"); */
		$this->db->join(STATE_TAX . ' as states_list', "states_list.id=c.stateid", "LEFT");
		$this->db->join(COUNTRY_LIST . ' as country_list', "country_list.id=states_list.countryid", "LEFT");
		$this->db->like('states_list.name', $text);
		$this->db->or_like('c.name', $text);
		$this->db->limit(30);
		$this->db->where('country_list.status', 'Active');
		//$this->db->group_by('pa.city');
		$this->db->order_by('c.name', asc);
		$this->db->order_by('states_list.name', asc);
		$query = $this->db->get();
		//echo $this->db->last_query();  die;
		$autocomplete = $query->result_array();
		return $autocomplete;
	}

	function get_contactAll_details($rep_code = '')
	{
		if ($rep_code != '') {
			$Query = "SELECT p.product_title, count( pa.product_id ) AS productcount
			FROM " . PRODUCT . " AS p, " . PAYMENT . "  AS pa, " . USERS . " As u
			WHERE p.id = pa.product_id and p.user_id=u.id and u.group='Seller' and u.rep_code='$rep_code'
			GROUP BY pa.product_id
			ORDER BY pa.id
			LIMIT 0 , 30";
		} else {
			$Query = "SELECT p.product_title, count( pa.product_id ) AS productcount
			FROM " . PRODUCT . " AS p, " . PAYMENT . "  AS pa
			WHERE p.id = pa.product_id
			GROUP BY pa.product_id
			ORDER BY pa.id
			LIMIT 0 , 30";
		}
		return $this->ExecuteQuery($Query);
	}

	public function get_property_booking_graph($rep_code = ''){

		//GROUP_CONCAT(CONCAT_WS(', ', contactLastName, contactFirstName) SEPARATOR ';')

        if ($rep_code != '') {
            $Query = "SELECT p.product_title, count( pa.product_id ) AS productcount
			FROM " . PRODUCT . " AS p, " . PAYMENT . "  AS pa, " . USERS . " As u
			WHERE p.id = pa.product_id and p.user_id=u.id and u.group='Seller' and u.rep_code='$rep_code'
			GROUP BY pa.product_id
			ORDER BY pa.id
			LIMIT 0 , 30";
        } else {
            $Query = "select GROUP_CONCAT(CONCAT('[\"',p.product_title,count( DISTINCT pa.product_id ),'\"]') separator ',') as count_string
			FROM " . PAYMENT . " AS pa, " . PRODUCT . "  AS p
			WHERE p.id = pa.product_id
			GROUP BY pa.product_id
			ORDER BY pa.id
			LIMIT 0 , 30";
        }
        return $this->ExecuteQuery($Query);
	}


	public
	function get_BookedProperties($rep_code = '')
	{
		$this->db->select('p.id as prd_id,p.product_title,re.booking_status');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(RENTALENQUIRY . ' as re', ' re.prd_id=p.id');
		$this->db->join(USERS . ' as u', ' u.id=p.user_id');
		if ($rep_code != '') {
			$this->db->where('re.booking_status', 'Booked');
			$this->db->where('u.rep_code', $rep_code);
		} else {
			$this->db->where('re.booking_status', 'Booked');
		}
		$query = $this->db->get();
		return $query;
	}

	function get_contactAllSeller_details($rep_code = '')
	{
		if ($rep_code != '') {
			$Query = "SELECT u.firstname,count( p.id ) AS productcount
			FROM " . PRODUCT . " AS p, " . USERS . "  AS u
			WHERE u.id = p.user_id and p.status='Publish' and u.status='Active' and u.group='Seller' and u.rep_code='$rep_code'
			GROUP BY u.id
			ORDER BY productcount DESC
			LIMIT 0 , 30";
		} else {
			$Query = "SELECT u.firstname,count( p.id ) AS productcount
			FROM " . PRODUCT . " AS p, " . USERS . "  AS u
			WHERE u.id = p.user_id and p.status='Publish' and u.status='Active'
			GROUP BY u.id
			ORDER BY productcount DESC
			LIMIT 0 , 30";
		}
		$dashboard = $this->ExecuteQuery($Query);
		return $dashboard;
	}

	/**Start -  To Get Active & Inactive host**/
	function get_contactAllSeller_detailsBoth($rep_code = '')
	{
		if ($rep_code != '') {
			$Query = "SELECT u.firstname,u.status,count( p.id ) AS productcount
			FROM " . PRODUCT . " AS p, " . USERS . "  AS u
			WHERE u.id = p.user_id and p.status='Publish' and u.group='Seller' and u.rep_code='$rep_code'
			GROUP BY u.id
			ORDER BY productcount DESC
			LIMIT 0 , 30";
		} else {
			$Query = "SELECT u.firstname,u.status,count( p.id ) AS productcount
			FROM " . PRODUCT . " AS p, " . USERS . "  AS u
			WHERE u.id = p.user_id and p.status='Publish' 
			GROUP BY u.id
			ORDER BY productcount DESC
			LIMIT 0 , 30";
		}
		$dashboard = $this->ExecuteQuery($Query);
		return $dashboard;
	}

	/**End -  To Get Active & Inactive host **/
	public
	function getPublishedProeprties($rep_code = '')
	{
		$this->db->select('*');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(USERS . ' as u', 'u.id=p.user_id');
		if ($rep_code != '') {
			$this->db->where('u.rep_code', $rep_code);
			$this->db->where('p.status', 'Publish');
		} else {
			$this->db->where('p.status', 'Publish');
		}
		$query = $this->db->get();
		return $query;
	}

	/************Product Listing***************/
	public
	function view_product_details_sitemapview($search, $Start, $searchPerPage)
	{
		$select_qry = "select p.id,p.instant_pay,p.price,p.seourl,p.product_title,p.listings,p.description,p.currency,
						u.id as userid,u.user_name,u.feature_product,u.image as userphoto,
						pa.lat as latitude,pa.lang as longitude,pa.address,
						pa.city as city_name,
						pa.state as statename,lsv.list_value,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where R.review_type='0' and R.product_id= p.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.review_type='0' and Rw.product_id= p.id and Rw.status='Active') as avg_val from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) LEFT JOIN ".LISTSPACE_VALUES." lsv on lsv.id=p.home_type where " . $search . "  p.status='Publish' group by p.id order by p.created desc limit " . $Start . "," . $searchPerPage;
		//echo $select_qry; exit;
		$productList = $this->ExecuteQuery($select_qry);
		/*print_r($select_qry);exit;*/
		return $productList;
	}

	public function get_total_pages_for_search($search)
	{
		$select_qry = "SELECT count(*) FROM " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id
		where " . $search . "  p.status='Publish' group by p.id order by p.created desc ";
		//echo $select_qry; exit;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList->num_rows();
	}

	/************Product Listing***************/
	public
	function view_product_details_booking($condition = '')
	{
		$select_qry = "select p.*,
						u.id as userid,u.user_name,u.firstname,u.email,u.phone_no,u.address,u.feature_product,u.image as userphoto,
						pa.latitude,pa.longitude,pa.address,pa.post_code,rq.base_billing_val,rq.currencycode,rq.subTotal,
						c.name as city_name,(select AVG(c.total_review) FROM fc_review c where c.review_type='0' and c.product_id=p.id and c.status='Active') as rate, (select count(c.id) FROM fc_review c where c.review_type='0' and c.product_id=p.id and c.status='Active') as num_reviewers,
						rq.checkin,rq.checkout,rq.NoofGuest,rq.numofdates,rq.serviceFee,rq.totalAmt,rq.Bookingno as Bookingno,rq.secDeposit,rq.choosed_option,rq.user_currencycode,rq.unitPerCurrencyUser,
						s.name as statename,s.meta_title as statemtitle,s.meta_keyword as statemkey,s.meta_description as statemdesc,s.seourl as stateurl,
						pp.product_image from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS . " pa on pa.product_id=p.id
		LEFT JOIN " . CITY . " c on c.id=pa.city
		LEFT JOIN " . RENTALENQUIRY . " rq on rq.prd_id=p.id
		LEFT JOIN " . STATE_TAX . " s on s.id=pa.state
		LEFT JOIN " . PRODUCT_BOOKING . " b on b.product_id=p.id
		LEFT JOIN " . PRODUCT_PHOTOS . " pp on pp.product_id=p.id
		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	/************Booking User Details***************/
	public
	function view_user_details_booking($condition = '')
	{
		$select_qry = "select u.id as userid,u.user_name,u.email, u.phone_no, rq.NoofGuest,u.feature_product,u.image as userphoto,u.firstname,u.lastname,u.address as UserAddress,u.city as UserCity,u.state as UserState,u.country as UserCountry,u.postal_code as UserPostCode,rq.serviceFee,rq.totalAmt,rq.unitPerCurrencyUser,rq.user_currencycode
						 from " . PRODUCT . " p 
		LEFT JOIN " . RENTALENQUIRY . " rq on rq.prd_id=p.id
		LEFT JOIN " . PRODUCT_BOOKING . " b on b.product_id=p.id
		LEFT JOIN " . USERS . " u on (u.id=rq.user_id) " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function Display_product_image_details_all()
	{
		$select_qry = "select product_id,count(product_image) as count_image from " . PRODUCT_PHOTOS . " group by product_id order by imgPriority asc";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	/*Count total reviews for  host only rentals*/
	public
	function get_host_review_rentals($host_id = "")
	{
		return $this->db->select('(select AVG(c.total_review) FROM fc_review c where c.review_type="0" and c.product_id=p.id and c.status="Active") as rate,fc_review.*')->join(PRODUCT . ' as p','p.id=' . REVIEW . '.product_id')->where(REVIEW.'.status','Active')->where(REVIEW.'.review_type','0')->where('p.user_id', $host_id)->get(REVIEW);
	}

	/*Count total reviews for  host only Exprience*/
	public
	function get_host_review_exprience($host_id = "")
	{
		return $this->db->select('(select AVG(c.total_review) FROM fc_experience_review c where c.review_type="0" and c.product_id=p.experience_id and c.status="Active") as rate,fc_experience_review.*')->join(EXPERIENCE. ' as p', 'p.experience_id=' . EXPERIENCE_REVIEW . '.product_id')->where(EXPERIENCE_REVIEW.'.review_type','0')->where('p.user_id', $host_id)->where(EXPERIENCE_REVIEW.'.status','Active')->get(EXPERIENCE_REVIEW);
	}

	/* geting known languages */
	public
	function get_known_langs($langcodes)
	{
		$langcodes = explode(',', $langcodes);
		return $this->db->or_where_in('language_code', $langcodes)->get(LANGUAGES_KNOWN);
	}

	/*********Single Product details*********/
	function view_product_details_site_one($where1, $where_or, $where2)
	{
		$this->db->select('p.*,
		pa.country,pa.state,pa.city,pa.zip as post_code,pa.address,pa.lat as latitude,pa.lang as longitude, 
		pf.feature,pf.google_map,pf.add_feature,pf.rentals_policy,pf.trams_condition,pf.confirm_email,pf.order_email,pf.invoice_template,
		pb.datefrom,pb.dateto,pb.expiredate,u.languages_known,u.firstname,u.created as user_created,u.id as user_id,u.s_city,u.s_district,u.s_state,u.response_rate,u.description as description1,u.phone_no,u.group,u.s_phone_no,u.about,u.email as RenterEmail,u.image as thumbnail, u.about, u.loginUserType, pa.country as Country_name, pa.state as State_name,
		pa.city as CityName, c.child_name, u.host_status,u.status as host_login_status,u.id_verified');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_FEATURES . ' as pf', "pf.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_BOOKING . ' as pb', "pb.product_id=p.id", "LEFT");
		$this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
		$this->db->join(LISTING_CHILD . ' as c', "c.id=p.minimum_stay", "LEFT");
		$this->db->where($where1);
		$this->db->or_where($where_or);
		$this->db->where($where2);
		$this->db->group_by('p.id');
		return $query = $this->db->get();
	}

	/**********For getting image*******/
	public
	function get_images($product_id = '')
	{
		return $data = $this->db->where('product_id', $product_id)->get('fc_rental_photos');
	}

	public
	function get_trip_review($bookingno = '', $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.bookingno', $bookingno);
		$this->db->where('p.review_type', '0');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}

	public
	function get_trip_review_all($reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}
	public	function get_trip_review_host($bookingno = '', $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.bookingno', $bookingno);
		$this->db->where('p.review_type', '1');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$query = $this->db->get();
		return $query;
	}

	public
	function get_review($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
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
	public
	function get_review_hosts($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
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
	public
	function get_review_lists($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		$this->db->where('p.review_type', '0');
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
        $this->db->limit(5);
		$query = $this->db->get();
		return $query;
	}
	public function get_review_lists_more($product_id,$tot_reviews){
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
        $this->db->limit($tot_reviews,5);
		$query = $this->db->get();
		return $query;
	}

	public
	function get_review_other($product_id, $reviewer_id = '')
	{
		$this->db->select('p.*,u.firstname,u.lastname,u.image');
		$this->db->from(REVIEW . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");
		$this->db->where('p.product_id', $product_id);
		if ($reviewer_id != '') {
			$this->db->where('p.reviewer_id !=', $reviewer_id);
		}
		$this->db->where('p.status', 'Active');
		$this->db->order_by('p.dateAdded', 'desc');
		$query = $this->db->get();
		return $query;
		//echo $this->db->last_query();die;
	}

	public
	function get_review_tot($product_id)
	{
		$this->db->select('AVG( total_review ) as tot_tot, AVG( accuracy ) as tot_acc, AVG( communication ) as tot_com, AVG( cleanliness ) as tot_cln, AVG( location ) as tot_loc, AVG( checkin ) as tot_chk, AVG( value ) as tot_val');
		$this->db->from(REVIEW);
		$this->db->where('product_id', $product_id);
		$this->db->where('review_type', '0');
		$this->db->where('status', 'Active');
		$query = $this->db->get();
		//echo $this->db->last_query();
		//exit;
		return $query;
	}

	public
	function getRentalAttribute($uid)
	{
		$select_qry = "SELECT a.id,a.list_value,b.attribute_name FROM `fc_list_values` a JOIN `fc_attribute` b on a.list_id = b.id WHERE FIND_IN_SET('" . $uid . "', a.products)";
		return $attList = $this->ExecuteQuery($select_qry);
	}

	public
	function get_total_records_CityCount($condition = '')
	{
		$select_qry = "select COUNT(p.id) as total from " . PRODUCT . " p 
		JOIN " . PRODUCT_ADDRESS . " c on c.product_id=p.id " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function get_product_details_wishlist($condition = '')
	{
		$this->db->select('pa.city as name, p.product_name, pp.product_image, p.id, p.product_title, pa.country as Country_name,pa.state as State_name,pa.city as CityName');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->where('p.id', $condition);
		$this->db->where('p.status', 'Publish');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}

	public
	function get_notes_added($Rental_id, $user_id)
	{
		$this->db->select('*');
		$this->db->from(NOTES);
		$this->db->where('product_id', $Rental_id);
		$this->db->where('user_id', $user_id);
		return $query = $this->db->get();
	}

	public
	function get_all_product_details()
	{
		$this->db->select('c.name,p.product_name,p.product_title_ar,pp.product_image,p.id');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS . ' as pa', "pa.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->join(CITY . ' as c', "c.id=pa.city", "LEFT");
		$this->db->where('p.status', 'Publish');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}
    public function get_list()
    {
    	$sel_list = $this->db->query("SELECT * FROM fc_listspace_values");
    	return $sel_list;
    }
    public function get_prod_list()
    {
    	$sel_list = $this->db->query("SELECT * FROM fc_product");
    	return $sel_list->result();
    }
    public function get_list_types($id)
    {
    	$sel_list = $this->db->query("SELECT * FROM fc_listing_types WHERE id='".$id."' ");
    	return $sel_list->result();
    }

	public
	function get_review_rating($condition = '')
	{
		$list_valuelangarray=language_dynamic_admin_enable_submit(array('lsv.list_value'),2); //Need to Update here
        if(count($list_valuelangarray)>0) {
            $list_valuelangarray=",".implode(",",$list_valuelangarray);
        } else $list_valuelangarray="";

		$select_qry = "SELECT p.*,pa.city,lsv.list_value".$list_valuelangarray.",u.image as user_image,AVG(r.total_review ) as rate,rp.product_image as product_image FROM " . PRODUCT . " p 
			JOIN " . USERS . " u on u.id=p.user_id
			LEFT JOIN " . REVIEW . " r on r.product_id=p.id 
			LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id 
			LEFT JOIN " . LISTSPACE_VALUES . " lsv on lsv.id=p.home_type 
			LEFT JOIN " . PRODUCT_PHOTOS . " rp on rp.product_id=p.id" . $condition;
		$prdList = $this->ExecuteQuery($select_qry);
		return $prdList;
	}

	public
	function get_total_popular_list()
	{
		$select_qry = "SELECT p.id FROM " . PRODUCT . " p 
			LEFT JOIN " . REVIEW . " r on r.product_id=p.id WHERE p.status = 'Publish' AND p.featured ='Featured'";
		$prdList = $this->ExecuteQuery($select_qry);
		return $prdList->num_rows();
	}
	public
	function get_total_popular_list_home()
	{
        $this->db->select("et.seourl");
        $this->db->from(PRODUCT . ' as et');
        $this->db->where(array('et.featured' => 'featured','et.status' => 'Publish'));
        $this->db->limit(1);
        return $result = $this->db->get();
    
	}
	public
	function get_populars($condition = '')
	{
		$select_qry = "SELECT p.*,u.image as user_image,AVG(r.total_review ) as rate,rp.product_image as product_image FROM " . PRODUCT . " p 
			JOIN " . USERS . " u on u.id=p.user_id
			LEFT JOIN " . REVIEW . " r on r.product_id=p.id 
			LEFT JOIN " . PRODUCT_PHOTOS . " rp on rp.product_id=p.id" . $condition;
		$prdList = $this->ExecuteQuery($select_qry);
		return $prdList;
	}
	
	
	public
	function get_all_properties_all()
	{
		$this->db->select('p.*,lsv.list_value,pa.city,u.image as user_image,  (select AVG(c.total_review) FROM fc_review c where c.review_type="0" and c.product_id=p.id and c.status="Active") as rate, (select count(c.id) FROM fc_review c where c.review_type="0" and c.product_id=p.id and c.status="Active") as num_reviewers,rp.product_image as product_image');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.user_id");
		$this->db->join(REVIEW . ' as r', "r.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as rp', "rp.product_id=p.id", "LEFT");
		$this->db->join(LISTSPACE_VALUES . ' as lsv', "lsv.id=p.home_type", "LEFT");
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->where('p.status', 'Publish');
		$this->db->group_by('p.id');
		$this->db->order_by('p.created', 'desc');
		$this->db->limit(8);
		return $query = $this->db->get();
		//echo $this->db->last_query();exit;
	}
	

	public
	function get_all_properties($start = "", $perPage = "",$user_id_is ="")
	{
		$list_valuelangarray=language_dynamic_admin_enable_submit(array('lsv.list_value'),2); //Need to Update here
        if(count($list_valuelangarray)>0) {
            $list_valuelangarray=",".implode(",",$list_valuelangarray);
        } else $list_valuelangarray="";

		$this->db->select('p.*,lsv.list_value'.$list_valuelangarray.',pa.city,u.image as user_image,  (select AVG(c.total_review) FROM fc_review c where c.review_type="0" and c.product_id=p.id and c.status="Active") as rate, (select count(c.id) FROM fc_review c where c.review_type="0" and c.product_id=p.id and c.status="Active") as num_reviewers,rp.product_image as product_image');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.user_id");
		$this->db->join(REVIEW . ' as r', "r.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as rp', "rp.product_id=p.id", "LEFT");
		$this->db->join(LISTSPACE_VALUES . ' as lsv', "lsv.id=p.home_type", "LEFT");
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->where('p.status', 'Publish');
		if($user_id_is != ''){
			$this->db->where('p.user_id', $user_id_is);
		}
		$this->db->group_by('p.id');
		$this->db->order_by('p.created', 'desc');
		$this->db->limit($perPage, $start);
		return $query = $this->db->get();
	}

	public
	function get_product_id($seourl)
	{
		$pro_det = $this->db->select('id')->where('seourl', $seourl)->get(PRODUCT);
		return $pro_det->row()->id;
	}

	public
	function get_wish_list_detail($condition = '')
	{
		$this->db->select('ls.id,ls.name,ls.product_id');
		$this->db->from(LISTS_DETAILS . " as ls");
		$this->db->join(PRODUCT . ' as p', "p.id=ls.product_id");
		$this->db->where('ls.user_id', $condition);
		$productList = $this->db->get();
		return $productList;
	}

	public
	function get_list_details_wishlist($condition = '')
	{
		$query = 'SELECT * FROM ' . LISTS_DETAILS . ' WHERE user_id=' . $condition;
		return $this->db->query($query);
	}

	public
	function get_list_details_wishlistShow($condition = '', $pageLimitStart = '', $perpage = "")
	{
		$this->db->select('*');
		$this->db->from(LISTS_DETAILS);
		$this->db->where('user_id', $condition);
		if ($perpage != "") {
			$this->db->limit($perpage);
			$this->db->offset($pageLimitStart);
		}
		$productList = $this->db->get();
		//echo $this->db->last_query();exit;
		return $productList;
	}

	public
	function get_wishlist($condition = '', $start, $perpage)
	{
		$this->db->select('*');
		$this->db->from(LISTS_DETAILS);
		$this->db->where('user_id', $condition);
		$this->db->limit($perpage, $start);
		$productList = $this->db->get();
		return $productList;
	}

	public
	function get_popular_wishlist($limit = '3')
	{
		$popular_list_qry = "select *  from " . LISTS_DETAILS . " order by id desc limit " . $limit;
		$productList = $this->ExecuteQuery($popular_list_qry);
		return $productList;
	}

	public
	function get_popular_wishlistphoto($prod_id = '')
	{
		//echo($prod_id);die;
		$popular_list_qry = "select *  from " . PRODUCT_PHOTOS . " where product_id=" . $prod_id;
		$productList = $this->ExecuteQuery($popular_list_qry);
		return $productList;
	}

	/*Check for category already founds*/
	public
	function check_users_lists($wishuser_id, $wishcatname)
	{
		return $this->db->query("SELECT * FROM `fc_lists` WHERE `name` like '" . $wishcatname . "' AND `user_id` = $wishuser_id ");
	}

	public
	function add_wishlist_category($dataArr = '')
	{
		$this->db->insert(LISTS_DETAILS, $dataArr);
		return $this->db->insert_id();
	}

	public
	function update_notes($dataArr = '', $condition = '')
	{
		if ($condition == '') {
			$this->db->insert(NOTES, $dataArr);
		} //return $this->db->insert_id();
		else {
			$this->db->where($condition);
			$this->db->update(NOTES, $dataArr);
		}
	}

	public
	function update_wishlist($dataStr = '', $condition1 = '')
	{
		$query = "select product_id,id from " . LISTS_DETAILS . " where user_id=" . $this->data['loginCheck'] . "";
		$ListVal = $this->ExecuteQuery($query);
		if ($ListVal->num_rows() > 0) {
			foreach ($ListVal->result() as $wishlist) {
				$productArr = @explode(',', $wishlist->product_id);
				if (!empty($productArr)) {
					if (in_array($dataStr, $productArr)) {
						$condition = array('id' => $wishlist->id);
						$my_array = array_filter($productArr);
						$to_remove = (array)$dataStr;
						$result = array_diff($my_array, $to_remove);
						$resultStr = implode(',', $result);
						$this->updateWishlistRentals(array('product_id' => $resultStr, 'last_added' => '1'), $condition);
					}
				}
			}
		}
		if (!empty($condition1)) {
			foreach ($condition1 as $wcont) {
				$select_qry = "select product_id from " . LISTS_DETAILS . " where id=" . $wcont . "";
				$productList = $this->ExecuteQuery($select_qry);
				$productIdArr = explode(',', $productList->row()->product_id);
				if (!empty($productIdArr)) {
					if (!in_array($dataStr, $productIdArr)) {
						$select_qry = "update " . LISTS_DETAILS . " set product_id=concat(product_id,'," . $dataStr . "') where id=" . $wcont . "";
						$productList = $this->ExecuteQuery($select_qry);
					}
				}
			}
		}
	}

	public
	function updateWishlistRentals($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(LISTS_DETAILS, $dataArr);
	}

	public
	function get_product_details_wishlist_one_category($condition = '')
	{
		$this->db->select('pa.city as name,p.seourl, p.product_name, p.currency, p.product_title, p.room_type, p.accommodates, p.bedrooms, p.bathrooms, p.price, n.id as nid, n.notes, p.id, pa.address, pa.zip as post_code,ls.list_value,lc.child_name,lcs.child_name as bed');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->join(LISTSPACE_VALUES . ' as ls', "ls.id=p.room_type", "LEFT");
		$this->db->join(LISTING_CHILD . ' as lcs', "lcs.id=p.bedrooms", "LEFT");
		$this->db->join(LISTING_CHILD . ' as lc', "lc.id=p.bathrooms", "LEFT");
		$this->db->join(NOTES . ' as n', "n.product_id=p.id", "LEFT");
		$this->db->where_in('p.id', $condition);
		$this->db->where('p.status', 'Publish');
		$this->db->group_by('p.id');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}

	public
	function get_wishlistphoto($condition = '')
	{
		$this->db->select('product_image,product_id');
		$this->db->from(PRODUCT_PHOTOS);
		$this->db->where('product_id', $condition);
		return $query = $this->db->get();
	}

	public
	function alldeletewishlist_details($lid = '')
	{
		$this->db->where('id', $lid);
		$this->db->delete(LISTS_DETAILS);
		//return $query = $this->db->get();
	}

	public
	function ChkWishlistProduct($productid = '', $userid)
	{
		$select_qry = 'SELECT id FROM ' . LISTS_DETAILS . ' WHERE user_id = ' . $userid . ' AND FIND_IN_SET(' . $productid . ' , product_id)';
		return $rentalList = $this->ExecuteQuery($select_qry);
		//return $rentalList->result();
	}

	public
	function edit_rentalbooking($dataArr = '', $condition = '')
	{
		$this->db->where($condition);
		$this->db->update(RENTALENQUIRY, $dataArr);
	}

	public
	function add_review($dataArr = '')
	{
		return $this->db->insert(REVIEW, $dataArr);
	}

	public
	function get_RentalInQueryDetails($eqid)
	{
		$this->db->select('r.*,p.product_title,u.firstname,u.lastname,u.email');
		$this->db->from(RENTALENQUIRY . ' as r');
		$this->db->join(PRODUCT . ' as p', "r.prd_id=p.id", "LEFT");
		$this->db->join(USERS . ' as u', "r.user_id=u.id", "LEFT");
		$this->db->where('p.status', 'Publish');
		$this->db->where('r.id', $eqid);
		return $query = $this->db->get();
	}

	public
	function get_PriceMaxMin($condition = '')
	{
		$select_qry = ' select MAX(p.price) as MaxPrice,MIN(p.price) as MinPrice from ' . PRODUCT . ' p
		LEFT JOIN ' . PRODUCT_ADDRESS_NEW . ' pa on pa.productId=p.id where ' . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function get_PriceMaxMin_new()
	{
		$select_qry = ' select MAX(p.price) as MaxPrice,MIN(p.price) as MinPrice from ' . PRODUCT . ' p WHERE p.status = "Publish"';
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	/************Product Search price in rental list page***************/
	public
	function searchRentalPriceMaxMin($condition = '')
	{
		$select_qry = "select MAX(p.price) as SMaxPrice,MIN(p.price) as SMinPrice from " . PRODUCT . " p 
		LEFT JOIN " . PRODUCT_ADDRESS_NEW . " pa on pa.productId=p.id " . $condition;
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function searchRentalPriceMaxMin_new()
	{
		$select_qry = "select MAX(p.price) as SMaxPrice,MIN(p.price) as SMinPrice from " . PRODUCT . " p WHERE p.status = 'Publish'";
		$productList = $this->ExecuteQuery($select_qry);
		return $productList;
	}

	public
	function get_membership_order_details($userid)
	{
		$this->db->select('u.firstname,u.lastname,a.name,a.price,a.valid_date,u.email,u.member_purchase_date,u.member_pakage');
		$this->db->from(USERS . ' as u');
		$this->db->join(FANCYYBOX . ' as a', "u.member_pakage=a.id");
		$this->db->where('u.id', $userid);
		return $query = $this->db->get();
	}

	public
	function get_city_and_neighborhood_name($condition = '')
	{
		$this->db->select('a.name,b.name as cityname');
		$this->db->from(NEIGHBORHOOD . ' as a');
		$this->db->join(CITY . ' as b');
		//$this->db->group_by('p.id');
		$this->db->where($condition);
		$city = $this->db->get();
		//echo $this->db->last_query();die;
		return $city;
	}

	public
	function get_cat_subcat()
	{
		//$sec_category=array();
		$this->db->select('*');
		$this->db->from(ATTRIBUTE);
		$this->db->where('status', 'Active');
		#$this->db->where_in('attribute_seourl',array('amenities','propertytype'));
		$property_attributs = $this->db->get()->result();
		foreach ($property_attributs as $property_attribute) {
			$this->db->select('*');
			$this->db->from(LIST_VALUES);
			$this->db->where('list_id', $property_attribute->id);
			$this->db->where('status', 'Active');
			$list_values = $this->db->get()->result_array();
			$sec_category[$property_attribute->id] = $list_values;
			/* foreach($list_values as $list_value)
    {
    $this->db->select('*');
    $this->db->from(LIST_SUB_VALUES);
    $this->db->where('list_value_id',$list_value->id);
    $this->db->where('status','Active');
    $list_sub_values=$this->db->get()->result();
    $third_category[$list_value->id]=$list_sub_values;
    } */
		}
		$data['main_cat'] = $property_attributs;
		$data['sec_category'] = $sec_category;
		//$data['third_category']=$third_category;
		return $data;
	}

	public
	function amenities_main_sub_category($list_name)
	{
		$this->db->select('*');
		$this->db->from(ATTRIBUTE);
		$this->db->where('status', 'Active');
		//$this->db->where_in('id',array(1,4,5,6));
		$property_attributes = $this->db->get()->result();
		foreach ($property_attributes as $property_attribute) {
			$this->db->select('*');
			$this->db->from(LIST_VALUES);
			$this->db->where_in('list_id', $property_attribute->id);
			$sub_category = $this->db->get();
			$data[$property_attribute->id] = $sub_category;
			//$data['subcategory']=$sub_category;
		}
		return $data;
	}

	/*code for getting country list - start*/
	public
	function get_country_list()
	{
		$this->db->select('id, name, country_mobile_code as code');
		$this->db->from(LOCATIONS);
		$countryList = $this->db->get()->result();
		return $countryList;
	}

	/* after payment confirmation mail */
	public
	function view_payment_details($transId)
	{
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,pd.product_title as prd_name');
		$this->db->from(HOSTPAYMENT . ' as p');
		$this->db->join(USERS . ' as u', 'p.host_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = p.product_id');
		$this->db->where('p.paypal_txn_id = "' . $transId . '"');
		$this->db->where('p.payment_status = "Paid"');
		$this->db->order_by("p.created", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	public function view_pmtDet_byBookingId($bookingId)
	{
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,pd.product_title as prd_name,pd.currency');
		$this->db->from(HOSTPAYMENT . ' as p');
		$this->db->join(USERS . ' as u', 'p.host_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = p.product_id');
		$this->db->where('p.bookingId = "' . $bookingId . '"');
		$this->db->where('p.payment_status = "Paid"');
		$this->db->order_by("p.created", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}
	public
	function getCurrency()
	{
		$this->db->select(CURRENCY . '.*');
		$this->db->from(CURRENCY);
		$this->db->where(CURRENCY . '.status', 'Active');
		$query = $this->db->get();
		//$resultContent = $query->result_array();
		return $query;
	}

	public
	function get_old_address($id)
	{
		$this->db->select('p.address, p.latitude, p.longitude, c.name as cityName, s.name as stateName, cn.name as countryName');
		$this->db->from(PRODUCT_ADDRESS . ' as p');
		$this->db->join(CITY . ' as c', "c.id=p.city", "LEFT");
		$this->db->join(STATE_TAX . ' as s', "s.id=p.state", "LEFT");
		$this->db->join(COUNTRY_LIST . ' as cn', "cn.id=p.country", "LEFT");
		$this->db->where('p.product_id', $id);
		return $query = $this->db->get();
	}

	public
	function get_all_values()
	{
		$this->db->select('*');
		$this->db->from(LISTINGS);
		$query = $this->db->get();
		return $query->result();
	}

	public
	function get_all_value()
	{
		$this->db->select('*');
		$this->db->from(LISTING_TYPES);
		$query = $this->db->get();
		return $query->result();
	}

	public
	function update_all_datas($result, $catID)
	{
		$this->db->where('id', $catID);
		$this->db->update(PRODUCT, $result);
	}

	public
	function get_all_price($PriceMin)
	{
		$this->db->select('*');
		$this->db->from(PRODUCT);
		$this->db->where('price', $PriceMin);
		$query = $this->db->get();
		return $query->result();
		//echo $query;
		//die;
	}

	/*code for getting country list - end*/
	public
	function totalprd($col_price)
	{
		$this->db->select(COUNT('price'));
		$this->db->from(PRODUCT);
		$this->db->where('price', $col_price);
		$this->db->group_by('price');
		return $num_rows = $this->db->count_all_results();
		/*
        select COUNT(price) from fc_product WHERE price =3500.00
        $select_qry = "select COUNT(price) from ".PRODUCT." price =".$col_price;
        $productLists = $this->ExecuteQuery($select_qry);
        return $productLists;*/
	}

	/*code for getting country list - end*/
	/*Code for Load more Pagination in places*/
	public
	function get_places($start, $perpage)
	{
		$this->db->select('p.*,u.image as user_image,AVG(r.total_review ) as rate,count(r.id) as num_reviewers,rp.product_image as product_image');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(USERS . ' as u', "u.id=p.user_id");
		$this->db->join(REVIEW . ' as r', "r.product_id=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as rp', "rp.product_id=p.id", "LEFT");
		$this->db->where('p.status', 'Publish');
		$this->db->group_by('p.id');
		$this->db->order_by('p.created', 'desc');
		$this->db->limit($perpage, $start);
		return $this->db->get();
		// $select_qry = "select p.*,u.image as user_image,(select IFNULL(count(R.id),0) from ".REVIEW." as R where R.product_id= p.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from ".REVIEW." as Rw where Rw.product_id= p.id and Rw.status='Active') as avg_val,rp.product_image as product_image from ".PRODUCT." p
		// LEFT JOIN ".USERS." u on u.id=p.user_id
		// LEFT JOIN ".PRODUCT_PHOTOS." rp on rp.product_id=p.id ".$condition;
		// //echo $select_qry;
		// $productList = $this->ExecuteQuery($select_qry);
		// return $productList;
	}

	/**get Properties Wishlist data**/
	public
	function get_products_wishlist($condition = '')
	{
		$this->db->select('pa.city as name, p.product_name, p.currency, p.product_title, p.room_type, p.accommodates, p.bedrooms, p.bathrooms, p.price, n.id as nid, n.notes, p.id, pa.address, pa.zip as post_code');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_ADDRESS_NEW . ' as pa', "pa.productId=p.id", "LEFT");
		$this->db->join(PRODUCT_PHOTOS . ' as pp', "pp.product_id=p.id", "LEFT");
		$this->db->join(NOTES . ' as n', "n.product_id=p.id", "LEFT");
		$this->db->where_in('p.id', $condition);
		$this->db->where('p.status', 'Publish');
		$this->db->group_by('p.id');
		$this->db->order_by('pp.imgPriority', 'asc');
		return $query = $this->db->get();
	}

	public
	function get_product_wishlistImage($condition = '')
	{
		$this->db->select('product_image,product_id');
		$this->db->from(PRODUCT_PHOTOS);
		$this->db->where('product_id', $condition);
		$this->db->group_by('product_id');
		return $query = $this->db->get();
	}

	/**get Properties Wishlist data End **/
	/**get Experiences Wishlist data **/
	public
	function get_experiences_wishlistImage($condition = '')
	{
		$this->db->select('product_image,product_id');
		$this->db->from(EXPERIENCE_PHOTOS);
		$this->db->where('product_id', $condition);
		$this->db->group_by('product_id');
		return $query = $this->db->get();
	}

	public
	function get_experiences_wishlist($condition = '')
	{
		$this->db->select('*');
		$this->db->from(EXPERIENCE . ' as e');
		$this->db->where_in('e.experience_id', $condition);
		$this->db->where('e.status', '1');
		$this->db->group_by('e.experience_id');
		return $query = $this->db->get();
	}

	/**get Experiences Wishlist data End **/
	public
	function get_coupon_details($code = '', $product_id = '')
	{
		$Query="SELECT * FROM fc_couponcards WHERE  FIND_IN_SET ('".$product_id."',product_id) AND code = '". $code."' AND status = 'Active'";
		return $this->ExecuteQuery($Query);
	}
	
	public function get_coupon_available($cur_date){
		
		$Query = "select c.* from ".COUPONCARDS. " c  where  ('".$cur_date."' between c.datefrom and c.dateto or (c.dateto ='".$cur_date."') or (c.datefrom ='".$cur_date."')  ) and status='Active'";
	   return $this->ExecuteQuery($Query);
		
		
	}
	
	public function get_guest_capacity(){
		
		$Query="SELECT * FROM ".LISTING_CHILD. " WHERE parent_id=31 ORDER BY child_name + 0 desc Limit 1";
		return $this->ExecuteQuery($Query);
	
	}
	public function booked_listings($pick_date='',$drop_date='')
    {
        $DateStart = date("Y-m-d", strtotime($pick_date));
        $DateEnd = date("Y-m-d", strtotime($drop_date));

        $product_restrick_id=array();

        $BookedArr = array();

        $schedule_Dates1 = $this->db->select('id,data')->get(SCHEDULE);
        $schedules = $schedule_Dates1->result();

		if($DateStart!='' && $DateEnd!='') {
			foreach ($schedules as $schedules) {
				$p_id=$schedules->id;
				$parse_schedule = json_decode($schedules->data, true);
				foreach ($parse_schedule as $key => $val) {
					$she_date = date('Y-m-d', strtotime($key));
					if (($val['status'] == 'booked' || $val['status'] == 'unavailable') && (date('Y-m-d') < $she_date) && (($she_date >= $DateStart) && ($she_date <= $DateEnd))) {
						$BookedArr[] = "'" . date('m/d/Y', strtotime($key)) . "'";
                        $product_restrick_id[]=$p_id;
					}
				}
			}
		}
        return array_unique($product_restrick_id);
	}
	 public function booked_dates($pick_date='',$drop_date='',$p_id_is)
    {
        $DateStart = date("Y-m-d", strtotime($pick_date));
        $DateEnd = date("Y-m-d", strtotime($drop_date));

        $product_restrick_id=array();

        $schedule_Dates1 = $this->db->select('id,data')->where('id', $p_id_is)->get(SCHEDULE);
        $schedules = $schedule_Dates1->result();

		if($DateStart!='' && $DateEnd!='') {
			foreach ($schedules as $schedules) {
				$p_id=$schedules->id;
				$parse_schedule = json_decode($schedules->data, true);
				foreach ($parse_schedule as $key => $val) {
					$she_date = date('Y-m-d', strtotime($key));
					if ($val['status'] == 'booked' && (($she_date >= $DateStart) && ($she_date <= $DateEnd))) {
						
                        $product_restrick_id[]=$p_id;
					}
				}
			}
		}
        return array_unique($product_restrick_id);
    }
	
}

?>
