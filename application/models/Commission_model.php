<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class Commission_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 *
	 * Getting commisions details
	 * @param String $condition
	 */
	public function get_commisions_details($condition = '')
	{
		$Query = " select * from " . COMMISSION . " " . $condition;
		return $this->ExecuteQuery($Query);
	}

	public function insertcommissionQuick($firstname = '', $lastname = '', $email = '', $pwd = '', $news_signup = 'no', $expireddate)
	{
		$getReferalcommissionId = $this->getReferalcommissionId();
		/* get Referal commission id end */
		$dataArr = array(
			'firstname' => $firstname,
			'lastname' => $lastname,
			'commission_name' => $firstname,
			'group' => 'commission',
			'email' => $email,
			'referId' => $getReferalcommissionId,
			'password' => md5($pwd),
			'status' => 'Inactive',
			'expired_date' => $expireddate,
			'is_verified' => 'No',
			'created' => mdate($this->data['datestring'], time()),
			'email_notifications' => implode(',', $this->data['emailArr']),
			'notifications' => implode(',', $this->data['notyArr'])
		);
		$this->simple_insert(COMMISSION, $dataArr);
		if ($this->session->commissiondata('referenceName') != '') {
			$this->session->unset_commissiondata('referenceName');
		}
	}

	public function insertcommissionQuick_social($fullname = '', $commissionname = '', $email = '', $pwd = '', $thumbnail)
	{
		if ($thumbnail != '')
			$thumbnail = $thumbnail;
		else
			$thumbnail = '';
		/* get Referal commission id start */
		$getReferalcommissionId = $this->getReferalcommissionId();
		$expireddate = date('Y-m-d', strtotime('+15 days'));
		/* get Referal commission id end */
		$dataArr = array(
			'full_name' => $fullname,
			'commission_name' => $commissionname,
			'firstname' => $fullname,
			'lastname' => $commissionname,
			'group' => 'commission',
			'email' => $email,
			'password' => md5($pwd),
			'status' => 'Inactive',
			'expired_date' => $expireddate,
			'is_verified' => 'No',
			'thumbnail' => $thumbnail,
			'image' => $thumbnail,
			'referId' => $getReferalcommissionId,
			'created' => mdate($this->data['datestring'], time()),
			'email_notifications' => implode(',', $this->data['emailArr']),
			'notifications' => implode(',', $this->data['notyArr'])
		);
		$this->simple_insert(COMMISSION, $dataArr);
		if ($this->session->commissiondata('referenceName') != '') {
			$this->session->unset_commissiondata('referenceName');
		}
	}

	public function updatecommissionQuick($fullname = '', $commissionname = '', $email = '', $pwd = '')
	{
		$dataArr = array(
			'full_name' => $fullname,
			'commission_name' => $fullname,
			'password' => md5($pwd)
		);
		$conditionArr = array('email' => $email);
		$this->update_details(COMMISSION, $dataArr, $conditionArr);
	}

	public function updategiftcard($table = '', $temp_id = '', $commission_id = '')
	{
		$dataArr = array('commission_id' => $commission_id,);
		$conditionArr = array('commission_id' => $temp_id);
		$this->update_details($table, $dataArr, $conditionArr);
	}

	public function get_purchase_details($uid = '0')
	{
		$Query = "select p.*,u.firstname from " . PAYMENT . " p JOIN " . COMMISSION . " u on u.id=p.commission_id where p.commission_id='" . $uid . "' group by p.dealCodeNumber order by created desc";
		return $this->ExecuteQuery($Query);
	}

	public function get_like_details_fully($uid = '0')
	{
		$Query = 'select p.*,u.firstname,u.lastname from ' . PRODUCT_LIKES . ' pl
   					JOIN ' . PRODUCT . ' p on pl.product_id=p.seller_product_id
   					LEFT JOIN ' . COMMISSION . ' u on p.commission_id=u.id
   					where pl.commission_id=' . $uid . ' and p.status="Publish" order by pl.time desc';
		return $this->ExecuteQuery($Query);
	}

	public function get_like_details_fully_commission_products($uid = '0')
	{
		$Query = 'select p.*,u.firstname,u.lastname from ' . PRODUCT_LIKES . ' pl
   					JOIN ' . commission_PRODUCTS . ' p on pl.product_id=p.seller_product_id
   					LEFT JOIN ' . COMMISSION . ' u on p.commission_id=u.id
   					where pl.commission_id=' . $uid . ' and p.status="Publish" order by pl.time desc';
		return $this->ExecuteQuery($Query);
	}

	public function get_activity_details($uid = '0', $limit = '5', $sort = 'desc')
	{
		$Query = 'select a.*,p.product_name,p.id as productID,up.product_name as commission_product_name,u.firstname,u.lastname from ' . commission_ACTIVITY . ' a
   					LEFT JOIN ' . PRODUCT . ' p on a.activity_id=p.seller_product_id
   					LEFT JOIN ' . commission_PRODUCTS . ' up on a.activity_id=up.seller_product_id
   					LEFT JOIN ' . COMMISSION . ' u on a.activity_id=u.id
   					where a.commission_id=' . $uid . ' order by a.activity_time ' . $sort . ' limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_list_details($tid = '0', $uid = '0')
	{
		$Query = 'select l.*,c.cat_name from ' . LISTS_DETAILS . ' l
   					LEFT JOIN ' . CATEGORY . ' c on l.category_id=c.id
   					where l.commission_id=' . $uid . ' and l.product_id=' . $tid . ' or l.commission_id=' . $uid . ' and l.product_id like "' . $tid . ',%" or l.commission_id=' . $uid . ' and l.product_id like "%,' . $tid . '" or l.commission_id=' . $uid . ' and l.product_id like "%,' . $tid . ',%"';
		return $this->ExecuteQuery($Query);
	}

	public function get_search_commission_list($search_key = '', $uid = '0')
	{
		$Query = 'select * from ' . COMMISSION . ' where
   					`full_name` like "%' . $search_key . '%" and `id` != "' . $uid . '" and `status` = "Active"
   					or 
   					`commission_name` like "%' . $search_key . '%" and `id` != "' . $uid . '" and `status` = "Active"';
		return $this->ExecuteQuery($Query);
	}

	public function social_network_login_check($apiId = '')
	{
		$twitterQuery = "select api_id from " . COMMISSION . " where api_id=" . $apiId . " AND status='Active'";
		$twitterQueryDetails = mysql_query($twitterQuery);
		$twitterFetchDetails = mysql_fetch_row($twitterQueryDetails);
		return $twitterCountById = mysql_num_rows($twitterQueryDetails);
	}

	public function get_social_login_details($apiId = '')
	{
		$twitterQuery = "select * from " . COMMISSION . " where api_id=" . $apiId . " AND status='Active'";
		$twitterQueryDetails = mysql_query($twitterQuery);
		return $twitterFetchDetails = mysql_fetch_assoc($twitterQueryDetails);
		//return $twitterCountById = mysql_num_rows($twitterQueryDetails);
	}

	public function googleLoginCheck($email = '')
	{
		// echo $email;die;
		$this->db->select('id');
		$this->db->from(COMMISSION);
		$this->db->where('email', $email);
		$this->db->where('status', 'Active');
		$googleQuery = $this->db->get();
		return $googleResult = $googleQuery->num_rows();
	}

	public function google_commission_login_details($email = '')
	{
		$this->db->select('*');
		$this->db->from(COMMISSION);
		$this->db->where('email', $email);
		$this->db->where('status', 'Active');
		$googleQuery1 = $this->db->get();
		return $googleResult1 = $googleQuery1->row_array();
	}

	public function getReferalcommissionId()
	{
		$referenceName = $this->session->commissiondata('referenceName');
		$referenceId = '';
		if ($referenceName != '') {
			$this->db->select('id');
			$this->db->from(COMMISSION);
			$this->db->where('commission_name', $referenceName);
			$referQuery = $this->db->get();
			$referResult = $referQuery->row_array();
			if (!empty($referResult)) {
				return $referenceId = $referResult['id'];
			} else {
				return $referenceId = '';
			}
		} else {
			return $referenceId = '';
		}
	}

	public function getReferalList($perpage = '', $start = '')
	{
		//echo $this->session->commissiondata('fc_session_commission_id');die;
		$this->db->select('full_name,commission_name,email,image');
		$this->db->from(COMMISSION);
		$this->db->where('referId', $this->session->commissiondata('fc_session_commission_id'));
		if ($perpage != '') {
			$this->db->limit($perpage, $start);
		}
		$this->db->order_by('id', 'desc');
		$referQuery = $this->db->get();
		return $referResult = $referQuery->result_array();
	}

	public function get_commissionlike_products($uid = '0', $limit = '5')
	{
		$Query = "select pl.*,p.id as pid,p.product_name,p.image from " . PRODUCT_LIKES . ' pl 
					JOIN ' . PRODUCT . ' p on pl.product_id=p.seller_product_id 
					where pl.commission_id=' . $uid . ' limit ' . $limit;
		return $this->ExecuteQuery($Query);
	}

	public function get_commission_orders_list($uid = '0')
	{
		$Query = "select *, sum(sumtotal) as TotalPrice from " . PAYMENT . ' where sell_id=' . $uid . ' and status="Paid" group by dealCodeNumber order by created desc';
		return $this->ExecuteQuery($Query);
	}

	public function get_subscriptions_list($uid = '0')
	{
		$Query = "select * from " . FANCYYBOX_USES . ' where commission_id=' . $uid . ' group by invoice_no order by created desc';
		return $this->ExecuteQuery($Query);
	}

	public function get_gift_cards_list($email = '')
	{
		$Query = "select * from " . GIFTCARDS . ' where recipient_mail=\'' . $email . '\' order by created desc';
		return $this->ExecuteQuery($Query);
	}

	public function get_purchase_list($uid = '0', $dealCode = '0')
	{
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,pd.image,pAr.attr_name');
		$this->db->from(PAYMENT . ' as p');
		$this->db->join(COMMISSION . ' as u', 'p.commission_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = p.product_id');
		$this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
		$this->db->where('p.commission_id = "' . $uid . '" and p.dealCodeNumber="' . $dealCode . '"');
		return $this->db->get();
	}

	public function get_order_list($uid = '0', $dealCode = '0')
	{
		$this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,pd.image,pAr.attr_name');
		$this->db->from(PAYMENT . ' as p');
		$this->db->join(COMMISSION . ' as u', 'p.commission_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = p.product_id');
		$this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
		$this->db->where('p.sell_id = "' . $uid . '" and p.dealCodeNumber="' . $dealCode . '"');
		return $this->db->get();
	}

	/*********Single Rental details*********/
	function view_product_details_email($where1)
	{
		$this->db->select('p.product_title,pa.product_image,u.email,u.phone_no');
		$this->db->from(PRODUCT . ' as p');
		$this->db->join(PRODUCT_PHOTOS . ' as pa', "pa.product_id=p.id", "LEFT");
		$this->db->join(COMMISSION . ' as u', "u.id=p.commission_id", "LEFT");
		$this->db->where('p.id', $where1);
		return $query = $this->db->get();
	}

	function export_commission_details($table, $fields_wanted)
	{
		$query = 'SELECT ';
		foreach ($fields_wanted as $field) {
			if ($field == 'created') {
				$query .= 'DATE(' . $field . ') AS created' . ',';
			} else {
				$query .= $field . ',';
			}
		}
		$query = substr($query, 0, -1);
		$query .= ' FROM ' . $table . ' WHERE `group` ="commission" AND `status` ="Active"';
		//echo $query;die;
		$data['COMMISSION_detail'] = $this->ExecuteQuery($query);
		return $data;
	}

	public function get_total_order_amount($sid = '0')
	{
		$Query = "select sum(pr.sumTotal) as TotalAmt,sum(pr.sumTax) as TaxAmt, count(pr.sumTotal) as orders from (
			select p.dealCodeNumber, sum(p.sumtotal) as sumTotal ,sum(p.tax) as sumTax ,u.full_name from fc_users u
			JOIN fc_payment p on p.sell_id=u.id
			where u.id='" . $sid . "' and p.status='Paid' group by p.dealCodeNumber
			) pr";
		return $this->ExecuteQuery($Query);
	}

	public function get_total_paid_details($sid = '0')
	{
		$Query = "select sum(amount) as totalPaid from " . VENDOR_PAYMENT . " where `status`='success' and `vendor_id`='" . $sid . "' group by `vendor_id`";
		return $this->ExecuteQuery($Query);
	}

	//from fc_users u JOIN fc_payment p on p.sell_id=u.id
	public function get_all_commission_tracking($sellerEmails)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.secDeposit,re.renter_id,re.cancelled,re.currencyPerUnitSeller, re.checkin,re.id as EnquiryId,re.user_currencycode,re. currency_cron_id,re.Bookingno from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  `host_email`='" . $sellerEmails . "'";
		//print_r($this->ExecuteQuery($Query)->result_array());
		//exit;
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_all_commission_tracking_with_date($sellerEmails,$from_date,$to_date)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.secDeposit,re.renter_id,re.cancelled,re.currencyPerUnitSeller, re.checkin,re.id as EnquiryId,re.user_currencycode,re. currency_cron_id,re.Bookingno from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  `host_email`='" . $sellerEmails . "' AND (c.dateAdded BETWEEN '".$from_date."' AND '".$to_date."')";
		//print_r($this->ExecuteQuery($Query)->result_array());
		//exit;
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_unpaid_commission_tracking($sellerEmail)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.cancelled,re.checkin,re.user_currencycode,re.currency_cron_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_status = 'no' AND  `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_commission_track_id($id)
	{
		$Query = "select c.* , re.prd_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where c.id='" . $id . "'";
		return $this->ExecuteQuery($Query);
	}

	public function get_payable_details($sellerEmail)
	{
		$Query = "select host_email, sum(payable_amount) as payable_amount from " . COMMISSION_TRACKING . " where paid_status = 'no' AND `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query);
	}

	public function get_paid_details($sellerEmails)
	{
		/* $Query = "select sum(amount) as paid_amount from ".COMMISSION_PAID." where  host_email ='".$sellerEmail."'"; */
		$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.subtotal,re.cancelled,re.cancel_percentage,re.user_currencycode,re.currency_cron_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where paid_status = 'yes' AND `host_email`='" . $sellerEmails . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_all_rep_details()
	{
		$this->db->select('*');
		$this->db->from(COMMISSION_TRACKING);
		$getdata = $this->db->get();
		foreach ($getdata as $key => $value) {
			$getvalue[] = $value;
		}
		return $getvalue;
	}

	public function get_rep_details($sellerEmail)
	{
		$this->db->select('*');
		$this->db->from(USERS);
		$this->db->where('email', $sellerEmail);
		return $query = $this->db->get();
	}

	public function get_rep_details_commison($email)
	{
		$this->db->select('*,r.cancel_percentage as enq_cancel_per',FALSE);
		$this->db->where('renter_id', $email);
		$this->db->from(RENTALENQUIRY . ' as r');
		$this->db->join(COMMISSION_TRACKING . ' as c', "c.booking_no=r.Bookingno");
		return $query = $this->db->get();
	}

	public function get_repcode_details($sellerEmail)
	{
		$this->db->select('*');
		$this->db->from(USERS);
		$this->db->where('email', $sellerEmail);
		return $query = $this->db->get();
	}

	public function get_all_commission_trackings($sellerEmail)
	{
		$Query = "select c.* , re.prd_id from " . COMMISSION_REP_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_paid_detailss($sellerEmail)
	{
		$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode from " . COMMISSION_REP_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where paid_status = 'yes' AND `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_commission_track_ids($id)
	{
		$Query = "select c.* , re.prd_id from " . COMMISSION_REP_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where c.id='" . $id . "'";
		return $this->ExecuteQuery($Query);
	}

	public function get_unpaid_commission_trackings($sellerEmail)
	{
		$Query = "select c.* , re.prd_id from " . COMMISSION_REP_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  c.paid_status = 'no' AND  `host_email`='" . $sellerEmail . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}

	public function get_all_product_details($condition)
	{
		$this->db->select('*,r.cancel_percentage as enq_cancel_per,IFNULL(dis.dispute_by,"") as cancelled_by',FALSE);
		$this->db->from(RENTALENQUIRY . ' as r');
		$this->db->join(COMMISSION_TRACKING . ' as c', "c.booking_no=r.Bookingno");
		$this->db->join(USERS . ' as u', "u.id=r.user_id");
		$this->db->join(PRODUCT . ' as p', "p.id=r.prd_id", "left");
		$this->db->join(PAYMENT . ' as pay', "pay.EnquiryId=r.id");
		$this->db->join(DISPUTE . ' as dis', "dis.booking_no=r.Bookingno","LEFT");
		$this->db->where($condition);
		return $query = $this->db->get();
	}		
	public function get_user_det_rep($rep_code){		
		$this->db->select('id,email,firstname,lastname');		
		$this->db->from(USERS);		
		$this->db->where('status','Active');		
		$this->db->where('rep_code',$rep_code);		
		$this->db->order_by('id','desc');		
		return $query = $this->db->get();		
	}		
	public function get_user_det(){		
		$this->db->select('id,email,firstname,lastname');		
		$this->db->from(USERS);		
		$this->db->where(array('status'=>'Active' ,'email !=' => ''));		
		$this->db->order_by('id','desc');		
		return $query = $this->db->get();	
	}
	public function get_commission_tracking_list($sellerEmails)
	{
		$Query = "select c.* , re.prd_id,re.currencycode,re.currencyPerUnitSeller,re.cancelled,re.checkin,re.user_currencycode,re.currency_cron_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no where  `host_email`='" . $sellerEmails . "'";
		return $this->ExecuteQuery($Query)->result_array();
	}
	

}












