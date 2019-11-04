<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to user management
 * @author Teamtweaks
 *
 */
class User_model extends My_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     *
     * Getting Users details
     * @param String $condition
     */
    public function get_users_details($condition = '')
    {
        $Query = "select id,firstname,lastname,status,image,email from " . USERS . " " . $condition;
        return $this->ExecuteQuery($Query);
    }
	//insertUserQuick($firstname, $lastname, $email, $pwd, $confirm_password, $expireddate, $birth_day, $birth_month, $birth_year,$invite_reference);
	/*Array
(
    [firstname] => web 
    [lastname] => nagoor
    [user_name] => web 
    [loginUserType] => 9bf31c7ff062936a96d3c8bd1f8f2ff3
    [group] => User
    [email] => nagoorwebdev@gmail.com
    [referid] => 0
    [image] => 
    [confirm_password] => Na123456
    [password] => 8b526ddeae551f481ddb05393191fd83
    [status] => Active
    [expired_date] => 2018-05-11
    [is_verified] => No
    [created] => 2018-04-26 12:19:42
)*/
    public function insertUserQuick($firstname = '', $lastname = '',$email = '', $pwd = '', $confirm_password, $expireddate, $login_type, $dob_date, $dob_month, $dob_year, $invite_reference = '0', $rep_code,$phone_number='')
    {
        $this->db->reconnect();
        if ($rep_code != '') {
            $rep_code_l = 'Seller';
        } else {
            $rep_code_l = 'User';
        }
        $dataArr = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'user_name' => $firstname,
            'loginUserType' => $login_type,
            'phone_no'=> $phone_number,
            'group' => $rep_code_l,
            'email' => $email,
            'referid' => $invite_reference,
            'image' => '',
            'confirm_password' => $confirm_password,
            'password' => $pwd,
            'status' => 'Active',
            'expired_date' => $expireddate,
            'is_verified' => 'No',
            'created' => mdate($this->data['datestring'], time())
        );
	
        $b_date_arr = array();
        if ($dob_date != "" && $dob_month != "" && $dob_year != "") {
            $b_date_arr = array(
                'dob_date' => $dob_date,
                'dob_month' => $dob_month,
                'dob_year' => $dob_year);
        }
        $dataArr = array_merge($dataArr, $b_date_arr);
        $this->simple_insert(USERS, $dataArr);
        if ($this->session->userdata('inviterID') != '') {
            $this->session->unset_userdata('inviterID');
        }
    }

     public function insertUserQuick_user($firstname = '', $lastname = '', $phone_number,$email = '', $pwd = '', $confirm_password, $expireddate, $login_type, $dob_date, $dob_month, $dob_year, $invite_reference = '0', $rep_code,$acc_group_type='',$business_name='',$license_no='',$business_addr='')
    {
        $this->db->reconnect();
        /* if ($rep_code != '') {
            $rep_code_l = 'Seller';
        } else {
            $rep_code_l = 'User';
        } */
		
		if($acc_group_type == 'Seller'){
			$rep_code_l = 'Seller';
		} else if($acc_group_type == 'User') {
			$rep_code_l = 'User'; 
		} else {
			$rep_code_l = 'User'; 
		}
        $dataArr = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'user_name' => $firstname,
            'loginUserType' => $login_type,
            'phone_no'=> $phone_number,
            'group' => $rep_code_l,
            'email' => $email,
            'referid' => $invite_reference,
            'image' => '',
            'confirm_password' => $confirm_password,
            'password' => $pwd,
            'status' => 'Active',
            'expired_date' => $expireddate,
            'is_verified' => 'No',
            'business_name' => $business_name,
            'business_address' => $business_addr,
            'license_number' => $license_no,
            'created' => mdate($this->data['datestring'], time())
        );
    
        $b_date_arr = array();
        if ($dob_date != "" && $dob_month != "" && $dob_year != "") {
            $b_date_arr = array(
                'dob_date' => $dob_date,
                'dob_month' => $dob_month,
                'dob_year' => $dob_year);
        }
        $dataArr = array_merge($dataArr, $b_date_arr);
        $this->simple_insert(USERS, $dataArr);
        if ($this->session->userdata('inviterID') != '') {
            $this->session->unset_userdata('inviterID');
        }
    }

    public function insertUserQuick_social($fullname = '', $username = '', $email = '', $pwd = '', $thumbnail)
    {
        $this->db->reconnect();
        if ($thumbnail != '')
            $thumbnail = $thumbnail;
        else
            $thumbnail = '';
        $getReferalUserId = $this->session->userdata('inviterID');
        $expireddate = date('Y-m-d', strtotime('+15 days'));
        /* get Referal user id end */
        $dataArr = array(
            'full_name' => $fullname,
            'user_name' => $username,
            'firstname' => $fullname,
            'lastname' => $username,
            'group' => 'User',
            'email' => $email,
            'password' => md5($pwd),
            'status' => 'Inactive',
            'expired_date' => $expireddate,
            'is_verified' => 'No',
            'thumbnail' => $thumbnail,
            'image' => $thumbnail,
            'referId' => $getReferalUserId,
            'created' => mdate($this->data['datestring'], time()),
            'email_notifications' => implode(',', $this->data['emailArr']),
            'notifications' => implode(',', $this->data['notyArr'])
        );
        $this->simple_insert(USERS, $dataArr);
        if ($this->session->userdata('inviterID') != '') {
            $this->session->unset_userdata('inviterID');
        }
    }

    public function updateUserQuick($fullname = '', $username = '', $email = '', $pwd = '')
    {
        $this->db->reconnect();
        $dataArr = array(
            'full_name' => $fullname,
            'user_name' => $fullname,
            'password' => md5($pwd)
        );
        $conditionArr = array('email' => $email);
        $this->update_details(USERS, $dataArr, $conditionArr);
    }

    public function updategiftcard($table = '', $temp_id = '', $user_id = '')
    {
        $this->db->reconnect();
        $dataArr = array('user_id' => $user_id,);
        $conditionArr = array('user_id' => $temp_id);
        $this->update_details($table, $dataArr, $conditionArr);
    }

    public function get_purchase_details($uid = '0')
    {
        $Query = "select p.*,u.firstname from " . PAYMENT . " p JOIN " . USERS . " u on u.id=p.user_id where p.user_id='" . $uid . "' group by p.dealCodeNumber order by created desc";
        return $this->ExecuteQuery($Query);
    }

    public function get_like_details_fully($uid = '0')
    {
        $Query = 'select p.*,u.firstname,u.lastname from ' . PRODUCT_LIKES . ' pl
   					JOIN ' . PRODUCT . ' p on pl.product_id=p.seller_product_id
   					LEFT JOIN ' . USERS . ' u on p.user_id=u.id
   					where pl.user_id=' . $uid . ' and p.status="Publish" order by pl.time desc';
        return $this->ExecuteQuery($Query);
    }

    public function get_like_details_fully_user_products($uid = '0')
    {
        $Query = 'select p.*,u.firstname,u.lastname from ' . PRODUCT_LIKES . ' pl
   					JOIN ' . USER_PRODUCTS . ' p on pl.product_id=p.seller_product_id
   					LEFT JOIN ' . USERS . ' u on p.user_id=u.id
   					where pl.user_id=' . $uid . ' and p.status="Publish" order by pl.time desc';
        return $this->ExecuteQuery($Query);
    }

    public function get_activity_details($uid = '0', $limit = '5', $sort = 'desc')
    {
        $Query = 'select a.*,p.product_name,p.id as productID,up.product_name as user_product_name,u.firstname,u.lastname from ' . USER_ACTIVITY . ' a
   					LEFT JOIN ' . PRODUCT . ' p on a.activity_id=p.seller_product_id
   					LEFT JOIN ' . USER_PRODUCTS . ' up on a.activity_id=up.seller_product_id
   					LEFT JOIN ' . USERS . ' u on a.activity_id=u.id
   					where a.user_id=' . $uid . ' order by a.activity_time ' . $sort . ' limit ' . $limit;
        return $this->ExecuteQuery($Query);
    }

    public function get_list_details($tid = '0', $uid = '0')
    {
        $Query = 'select l.*,c.cat_name from ' . LISTS_DETAILS . ' l
   					LEFT JOIN ' . CATEGORY . ' c on l.category_id=c.id
   					where l.user_id=' . $uid . ' and l.product_id=' . $tid . ' or l.user_id=' . $uid . ' and l.product_id like "' . $tid . ',%" or l.user_id=' . $uid . ' and l.product_id like "%,' . $tid . '" or l.user_id=' . $uid . ' and l.product_id like "%,' . $tid . ',%"';
        return $this->ExecuteQuery($Query);
    }

    public function get_search_user_list($search_key = '', $uid = '0')
    {
        $Query = 'select * from ' . USERS . ' where
   					`full_name` like "%' . $search_key . '%" and `id` != "' . $uid . '" and `status` = "Active"
   					or 
   					`user_name` like "%' . $search_key . '%" and `id` != "' . $uid . '" and `status` = "Active"';
        return $this->ExecuteQuery($Query);
    }

    public function social_network_login_check($apiId = '')
    {
        $twitterQuery = "select api_id from " . USERS . " where api_id=" . $apiId . " AND status='Active'";
        $twitterQueryDetails = mysql_query($twitterQuery);
        $twitterFetchDetails = mysql_fetch_row($twitterQueryDetails);
        return $twitterCountById = mysql_num_rows($twitterQueryDetails);
    }

    public function get_social_login_details($apiId = '')
    {
        $twitterQuery = "select * from " . USERS . " where api_id=" . $apiId . " AND status='Active'";
        $twitterQueryDetails = mysql_query($twitterQuery);
        return $twitterFetchDetails = mysql_fetch_assoc($twitterQueryDetails);
        //return $twitterCountById = mysql_num_rows($twitterQueryDetails);
    }

    public function googleLoginCheck($email = '')
    {
        // echo $email;die;
        $this->db->select('id');
        $this->db->from(USERS);
        $this->db->where('email', $email);
        $this->db->where('status', 'Active');
        $googleQuery = $this->db->get();
        return $googleResult = $googleQuery->num_rows();
    }

    public function google_user_login_details($email = '')
    {
        $this->db->select('*');
        $this->db->from(USERS);
        $this->db->where('email', $email);
        $this->db->where('status', 'Active');
        $googleQuery1 = $this->db->get();
        return $googleResult1 = $googleQuery1->row_array();
    }

    public function getReferalUserId()
    {
        $referenceName = $this->session->userdata('referenceName');
        $referenceId = '';
        if ($referenceName != '') {
            $this->db->select('id');
            $this->db->from(USERS);
            $this->db->where('user_name', $referenceName);
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
        //echo $this->session->userdata('fc_session_user_id');die;
        $this->db->select('full_name,user_name,email,image');
        $this->db->from(USERS);
        $this->db->where('referId', $this->session->userdata('fc_session_user_id'));
        if ($perpage != '') {
            $this->db->limit($perpage, $start);
        }
        $this->db->order_by('id', 'desc');
        $referQuery = $this->db->get();
        return $referResult = $referQuery->result_array();
    }

    public function get_userlike_products($uid = '0', $limit = '5')
    {
        $Query = "select pl.*,p.id as pid,p.product_name,p.image from " . PRODUCT_LIKES . ' pl 
					JOIN ' . PRODUCT . ' p on pl.product_id=p.seller_product_id 
					where pl.user_id=' . $uid . ' limit ' . $limit;
        return $this->ExecuteQuery($Query);
    }

    public function get_user_orders_list($uid = '0')
    {
        $Query = "select *, sum(sumtotal) as TotalPrice from " . PAYMENT . ' where sell_id=' . $uid . ' and status="Paid" group by dealCodeNumber order by created desc';
        return $this->ExecuteQuery($Query);
    }

    public function get_subscriptions_list($uid = '0')
    {
        $Query = "select * from " . FANCYYBOX_USES . ' where user_id=' . $uid . ' group by invoice_no order by created desc';
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
        $this->db->join(USERS . ' as u', 'p.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = p.product_id');
        $this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
        $this->db->where('p.user_id = "' . $uid . '" and p.dealCodeNumber="' . $dealCode . '"');
        return $this->db->get();
    }

    public function get_order_list($uid = '0', $dealCode = '0')
    {
        $this->db->select('p.*,u.email,u.firstname,u.address,u.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,pd.image,pAr.attr_name');
        $this->db->from(PAYMENT . ' as p');
        $this->db->join(USERS . ' as u', 'p.user_id = u.id');
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
        $this->db->join(USERS . ' as u', "u.id=p.user_id", "LEFT");
        $this->db->where('p.id', $where1);
        return $query = $this->db->get();
    }

    function export_user_details($table, $fields_wanted)
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
        $query .= ' FROM ' . $table . ' WHERE `group` ="User" AND `email` !=""';
        //echo $query;die;
        $data['users_detail'] = $this->ExecuteQuery($query);
        return $data;
    }

    public function getbookeduser_detail($id)
    {
        $this->db->reconnect();
        $this->db->select('rq.currencycode,rq.user_currencycode,rq.subTotal,rq.numofdates as noofdates,rq.checkin as checkin,rq.checkout as checkout,rq.renter_id as renter_id,rq.totalAmt,p.price as price,u.email as email,u.user_name as name,p.product_title as productname,p.id as prd_id,rq.totalAmt,rq.serviceFee');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', "u.id=rq.user_id", "LEFT");
        $this->db->join(PRODUCT . ' as p', "p.id=rq.prd_id", "LEFT");
        $this->db->where('rq.id', $id);
        $this->db->limit(15, 0);
        return $query = $this->db->get();
		//echo $this->db->last_query();
    }

    public function get_booking_details($bookingNo)
    {
        $this->db->reconnect();
$langarray=language_dynamic_admin_enable_submit(array('p.product_title'),2); //Need to Update here
        if(count($langarray)>0) {
            $langarray=",".implode(",",$langarray);
        } else $langarray="";

        $this->db->select('rq.user_currencycode,rq.id, rq.checkin, rq.checkout, rq.Bookingno, rq.subTotal, rq.serviceFee, rq.totalAmt, rq.NoofGuest, rq.renter_id, rq.secDeposit, p.product_title'.$langarray.', p.currency,rq.choosed_option');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(PRODUCT . ' as p', "p.id=rq.prd_id", "left");
        $this->db->where('Bookingno', $bookingNo);
        return $query = $this->db->get();
    }

    public function getproductimage($prd_id)
    {
        $this->db->select('product_image');
        $this->db->from(PRODUCT_PHOTOS);
        $this->db->where('product_id', $prd_id);
        return $query = $this->db->get();
    }

    /**
     * @return number
     * Retrieve unread messages count for header
     * use current user login from table fc_med_messages
     **/
    public function get_unread_messages_count($user_id)
    {
        $this->db->select('*');
        $this->db->from(MED_MESSAGE);
        $this->db->where('receiverId', $user_id);
        $this->db->where('msg_read', 'No');
        //$this->db->where('admin_id ','0');
        $this->db->group_by('bookingNo');
        $result = $this->db->get()->num_rows();
        return $result;
    }

    public function get_unread_messages_count_admin()
    {
        $this->db->select('*');
        $this->db->from(MED_MESSAGE);
        $this->db->where('msg_read', 'No');
        // $this->db->where('admin_id !=','0');
        $this->db->group_by('bookingNo');
        $result = $this->db->get()->num_rows();
        return $result;
    }

    public function get_all_users($user_id)
    {
        $Query = "select * from fc_users where id = $user_id";
        return $this->ExecuteQuery($Query);
    }

    public function update_user($code, $user_id)
    {
        $Query = "UPDATE fc_users SET verify_code = '.$code.', id_verified = 'yes' where id = $user_id";
        return $this->ExecuteQuery($Query);
    }

    public function get_all_user_details_Proof($condition)
    {
        $this->db->select('u.*,uid.id_proof_status');
        $this->db->from(USERS . ' as u');
        $this->db->join(ID_PROOF . ' as uid', "uid.user_id=u.id", "left");
        $this->db->where($condition);
        return $query = $this->db->get();
    }

    Public function get_user_type()
    {
        $this->db->select('*');
        $this->db->from('fc_users');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_rep_details($rep_code)
    {
        $this->db->select('*');
        $this->db->from(SUBADMIN);
        $this->db->where('admin_rep_code', $rep_code);
        $query = $this->db->get();
        return $query->result();
    }

    /**   get_unread_messages_count end **/
    public function get_user_details($table = '', $condition1 = '', $page = "", $limit = "")
    {
        $this->db->where($condition1);
        $this->db->limit($page, $limit);
        $this->db->order_by("id", "desc");
        return $query = $this->db->get($table);
        //echo $this->db->last_query(); exit;
    }

    /*check user email exist */
    function check_user_email_exist($email_id, $group)
    {
        $query = $this->db->select('*')->from(USERS)->where('email', $email_id)->where('group', $group)->get();
        return $query;
    }

    public function coupon_data($pageLimitStart, $searchPerPage)
    {
        $cur_date = date('Y-m-d');
        $couponQ = "select c.* from " . COUPONCARDS . " c  where  ('" . $cur_date . "' between c.datefrom and c.dateto or (c.dateto ='" . $cur_date . "') or (c.datefrom ='" . $cur_date . "')  ) and status='Active' order by c.id desc limit " . $pageLimitStart . "," . $searchPerPage . "";
        return $this->ExecuteQuery($couponQ);
    }

    public function coupon_data_site_map()
    {
        $cur_date = date('Y-m-d');
        $couponQ = "select c.* from " . COUPONCARDS . " c  where  ('" . $cur_date . "' between c.datefrom and c.dateto or (c.dateto ='" . $cur_date . "') or (c.datefrom ='" . $cur_date . "')  ) and status='Active'";
        return $this->ExecuteQuery($couponQ);
    }
     public function get_conversation_details($bookingNo){

        $query = $this->db;
        $query->select('m.*,s.firstname as sender_name,r.firstname as receiver_name,s.image as sender_image,r.image as receiver_image',FALSE);
        $query->from(MED_MESSAGE .' as m');
        $query->join(USERS . ' as s', "s.id=m.senderId", "LEFT");
        $query->join(USERS . ' as r', "r.id=m.receiverId", "LEFT");
        $query->where('m.bookingNo', $bookingNo);
        $this->db->order_by('m.id', 'asc');
        return $query->get();
    }

}
