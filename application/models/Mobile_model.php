<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/**

 * 

 * This model contains all db functions related to mobile Json management

 * @author Teamtweaks

 *

 */

class Mobile_model extends My_Model

{

  public function __construct(){

    parent::__construct();

  }

  /*

  * $table name of the table

  * $condition array of where conditions

  * $columnlist name of the coloums separated by comma(,) and enclosed with ` symbol.

  */

  public function get_column_details($table='',$condition='',$columnlist=''){

    $this->db->select($columnlist);

    $this->db->from($table);

    $this->db->where($condition);

    return $this->db->get();

  }

  public function insertUserQuick($firstname='',$lastname='',$email='',$pwd='',$expireddate,$key='',$firebase_token){

    $dataArr = array(

      'firstname' =>  $firstname,

      'lastname'  =>  $lastname,

      'user_name' =>  $firstname,

      'group'   =>  'User',

      'email'   =>  $email,

      'password'  =>  md5($pwd),

      'status'  =>  'Active',

      'expired_date'  =>  $expireddate,

      'is_verified'=> 'No',

      'created' =>  mdate($this->data['datestring'],time()),

      'through' => 'mobile',

      'mobile_key'=> $key,

      'firebase_token'=>$firebase_token

    );

    $this->simple_insert(USERS,$dataArr);

  }

  public function add_wishlist_category($dataArr=''){

      $this->db->insert(LISTS_DETAILS,$dataArr);

      return $this->db->insert_id();

  }

/* City details home page */

  public function Featured_city(){

    $this->db->select('u.*,u.seourl as cityurl,count(u.id) as NCount, st.name as state_name');

    $this->db->from(CITY.' as u');

    $this->db->join(STATE_TAX.' as st' , 'st.id = u.stateid','LEFT');

    $this->db->join(NEIGHBORHOOD.' as n' , 'u.id = n.neighborhoods','LEFT');

    $this->db->where('u.status','Active','u.featured','1');

    $this->db->where('u.featured','1');

    $this->db->group_by('u.id');

    $this->db->order_by('u.view_order');

    $city = $this->db->get();

    return $city;

  }

public function get_transaction_details($email){

    $this->db->select('c.*,r.currencycode as currency_code,TRIM(cr.currency_symbols) as currency_symbol,(
    CASE 
        WHEN r.cancelled = "Yes" && c.dispute_by = "Host" THEN "Cancelled by You"
        WHEN r.cancelled = "Yes" THEN "Cancelled by Guest"
        ELSE ""
    END) AS cancel_by',FALSE);

$this->db->from(RENTALENQUIRY.' as r');

$this->db->join(COMMISSION_TRACKING.' as c' , 'c.booking_no= r.Bookingno');

$this->db->join(CURRENCY.' as cr' , 'cr.currency_type= r.currencycode');

$this->db->where('c.host_email',$email);

$currency= $this->db->get();

return $currency;



}

  /* Inbox notification message */

  public function json_get_med_messages($userId)

  {

      $this->db->select("M.*,U.image,U.firstname,U.lastname,(select IFNULL(count(m2.id),0) from ".MED_MESSAGE." as m2, ".PRODUCT." as p where m2.bookingNo = M.bookingNo and m2.productId = p.id and m2.receiverId = ".$userId." and ((m2.receiverId = p.user_id and m2.host_msgread_status = 'No') or (m2.receiverId != p.user_id and m2.user_msgread_status = 'No'))) as msg_unread_count ",FALSE);

      $this->db->from(MED_MESSAGE .' as M');

      $this->db->join(USERS.' as U' , 'U.id = M.senderId','LEFT');

      $this->db->where('receiverId',$userId);

      if(!empty($bookingNo)){
          $this->db->where_in('bookingNo',$bookingNo);
      }


      $this->db->where('msg_status = ','0');

    $this->db->group_by('bookingNo');

    $this->db->order_by('dateAdded', 'desc');

    $resultArr = $this->db->get();

    //echo $this->db->last_query();die;

    return $resultArr;

    

  }

  /* Future Transaction */

  public function get_future_transaction($email)

  {

    $this->db->select('CT.dateAdded, U.id as GestId, U.firstname, P.id as product_id, P.product_title, P.price, RQ.Bookingno,RQ.user_currencycode,RQ.currency_cron_id, CT.total_amount as totalAmt, CT.guest_fee, CT.host_fee, CT.payable_amount,RQ.subTotal,RQ.secDeposit,RQ.cancelled,CT.dispute_by');

    $this->db->from(COMMISSION_TRACKING.' as CT');

    $this->db->join(RENTALENQUIRY.' as RQ' , 'RQ.Bookingno = CT.booking_no','LEFT');

    $this->db->join(PRODUCT.' as P' , 'P.id = RQ.prd_id','LEFT');

    $this->db->join(USERS.' as U' , 'U.id = RQ.user_id','LEFT');

    $this->db->where('CT.host_email',$email);

    $this->db->where('CT.paid_status','no');

    $this->db->order_by('CT.dateAdded', 'desc');

    return $resultArr = $this->db->get();

  }

  /* Completed Transaction */

  public function get_completed_transaction($email)

  {
    /*$this->db->select('dateAdded, transaction_id ,amount');

    $this->db->from(COMMISSION_PAID.' as CP');

    $this->db->where('CP.host_email',$email);

    //$this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");

    $this->db->order_by('CP.dateAdded', 'desc');

    return $resultArr = $this->db->get();*/

  $this->db->select('CP.dateAdded, CP.transaction_id,CP.amount,C.*,RE.currencycode,RE.user_currencycode,RE.currency_cron_id,RE.subTotal,RE.secDeposit,RE.Bookingno,C.booking_no');

  $this->db->join(COMMISSION_TRACKING . ' as C', 'C.commission_paid_id=CP.id', 'LEFT');

  $this->db->join(RENTALENQUIRY . ' as RE', 'RE.Bookingno=C.booking_no', 'LEFT');

  $this->db->where('CP.host_email', $email);

  $this->db->order_by('CP.dateAdded', 'desc');

  return $resultArr = $this->db->get(COMMISSION_PAID . ' as CP');

  }

  /* User Review ABout You */

  function get_productreview_aboutyou($user_id='')

  {

    //$this->db->select('r.review,u.email,r.total_review,u.image,u.loginUserType,u.user_name,r.dateAdded');

  $this->db->select('r.id as review_id,r.review,r.bookingno,u.email,r.total_review,u.image,u.loginUserType,u.user_name,r.dateAdded,r.reviewer_id,p.product_title as product_name,p.id as property_id,CONCAT(u.firstname,u.lastname) as reviewer_name', FALSE);

    $this->db->from(REVIEW.' as r');

    $this->db->where('r.user_id', $user_id);

    $this->db->join(PRODUCT.' as p',"r.product_id=p.id");

    $this->db->join(USERS.' as u',"u.id=r.reviewer_id", "LEFT");
      $this->db->order_by('r.id','desc');

    return $query = $this->db->get_where();

  }

  /* User Review By You */

  function get_productreview_byyou($user_id='')

  {

      //$this->db->select('r.review,u.email,r.total_review,u.image,u.loginUserType,r.dateAdded');

      $this->db->select('r.id as review_id,r.review,r.bookingno,u.email,r.total_review,u.image,u.loginUserType,r.dateAdded,r.reviewer_id,r.user_id,p.product_title as product_name,p.id as property_id,CONCAT(u.firstname,u.lastname) as reviewer_name', FALSE);

      $this->db->from(REVIEW . ' as r');

      $this->db->where('r.reviewer_id', $user_id);

      $this->db->join(PRODUCT . ' as p', "r.product_id=p.id");

      $this->db->join(USERS . ' as u', "u.id=r.user_id", "LEFT");
      $this->db->order_by('r.id', 'desc');

      return $query = $this->db->get_where();

  }

  /* dispute By You */

    function get_productdispute_byyou($user_id = '')

    {

        $this->db->select('d.message,d.booking_no,u.image,rq.checkout,u.email,u.loginUserType,d.created_date,d.id,d.email,d.status,p.product_title,u2.user_name');

        $this->db->from(DISPUTE . ' as d');

        $this->db->where('d.user_id', $user_id);
        $this->db->where('d.cancel_status', 0);
        $this->db->where('d.dispute_by', '');

        $this->db->join(PRODUCT . ' as p', "d.prd_id=p.id");
        $this->db->join(RENTALENQUIRY . ' as rq', 'rq.Bookingno = d.booking_no');

        $this->db->join(USERS . ' as u', "u.id=d.user_id", "LEFT");
        $this->db->join(USERS . ' as u2', "u2.id=d.disputer_id", "LEFT");
        $this->db->order_by('d.id', 'desc');

        return $query = $this->db->get_where();

  }

  /* dispute about You */

    function get_productdispute_aboutyou($user_id='')

    {

        $this->db->select('d.message,d.booking_no,rq.checkout,u.image,u.email,u.loginUserType,d.created_date,d.id,d.status,p.product_title,u.user_name');

        $this->db->from(DISPUTE.' as d');

        $this->db->where('d.disputer_id', $user_id);

        $this->db->where('d.cancel_status', 0);

        $this->db->where('d.dispute_by', '');

        $this->db->join(PRODUCT.' as p',"d.prd_id=p.id");

        $this->db->join(RENTALENQUIRY.' as rq','rq.Bookingno = d.booking_no');

        $this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");

        $this->db->join(USERS.' as u2',"u2.id=d.disputer_id", "LEFT");

        $this->db->order_by('d.id','desc');

        return $query = $this->db->get_where();

    }

  

  public function edit_rentalbooking($dataArr='',$condition=''){

    //$this->db->cache_on();

      $this->db->where($condition);

      $this->db->update(RENTALENQUIRY,$dataArr);

  }

  

  public function get_booking_details($bookingNo){

   

    $this->db->reconnect();

    $this->db->select('rq.id, rq.checkin, rq.checkout, rq.Bookingno, rq.subTotal, rq.serviceFee, rq.totalAmt, rq.NoofGuest, rq.renter_id, rq.secDeposit, p.product_title, p.currency,rq.user_id,rq.prd_id,u.user_name as requester_name,u.loginUserType as requester_login_type,u.image as  requester_image,r.user_name as host_name,r.loginUserType as host_login_type,r.image as  host_image,rq.totalAmt,rq.approval,rq.currencycode,u.created');

    $this->db->from(RENTALENQUIRY.' as rq');

    $this->db->join(PRODUCT.' as p',"p.id=rq.prd_id","left");

    $this->db->join(USERS.' as u',"u.id=rq.user_id","LEFT");

    $this->db->join(USERS.' as r',"r.id=rq.renter_id","LEFT");

    $this->db->where('Bookingno', $bookingNo);

    return $query = $this->db->get();

  }

  public function get_dashboard_list($condition = '',$Cont2 = ''){

  

    $this->db->select('p.*,pp.product_image,pa.lat as latitude,s.data as shedule,hs.payment_status,pa.address');

    $this->db->from(PRODUCT.' as p');

    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");

    $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");

    $this->db->join('schedule as s',"s.id=p.id","LEFT");

    $this->db->join(HOSTPAYMENT.' as hs',"hs.product_id=p.id","LEFT");

    $this->db->where_in('p.user_id',$condition);

    if($Cont2!=''){

      $this->db->where('p.status',$Cont2);

    }

    $this->db->group_by('p.id');

    $this->db->order_by('p.id','desc');

    

    return $query = $this->db->get();

      

  }

  public function get_list_details_wishlist($condition = ''){

    

     $select_qry = "select id,name,product_id,experience_id from ".LISTS_DETAILS." where user_id=".$condition."  or user_id=0"; 

    $productList = $this->ExecuteQuery($select_qry);

    //echo $this->db->last_query(); die;

    return $productList;

  }

  public function get_product_details_wishlist_one_category($condition = ''){

    $this->db->select('pa.city as name, p.product_name, p.currency, p.product_title, p.room_type, p.bedrooms, p.bathrooms, p.accommodates, p.price,p.user_id, n.id as nid, n.notes, p.id, pa.address, pa.zip as post_code,p.currency');

    $this->db->from(PRODUCT.' as p');

    $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");

    $this->db->join(PRODUCT_PHOTOS.' as pp',"pp.product_id=p.id","LEFT");

    $this->db->join(NOTES.' as n',"n.product_id=p.id","LEFT");

    $this->db->where_in('p.id',$condition);

    $this->db->where('p.status','Publish');

    $this->db->group_by('p.id');

    $this->db->order_by('pp.imgPriority','asc');

    return $query = $this->db->get();

  }

  public function get_wishlistphoto($condition = '')

  {

    $this->db->select('product_image,product_id');

    $this->db->from(PRODUCT_PHOTOS);

    $this->db->where('product_id',$condition);

    return $query = $this->db->get();

  }

  /* booking mail functionality */

  public function getbookeduser_detail($id) {

    //$this->db->cache_on();

    //$this->db->reconnect();

      $this->db->select('rq.Bookingno,rq.numofdates as noofdates,rq.checkin as checkin,rq.checkout as checkout,rq.renter_id as renter_id,rq.user_currencycode,rq.currencycode,rq.totalAmt,p.price as price,u.email as email,u.user_name as name,p.product_title as productname,p.id as prd_id');

    $this->db->from(RENTALENQUIRY.' as rq');    

    $this->db->join(USERS.' as u',"u.id=rq.user_id","LEFT");

    $this->db->join(PRODUCT.' as p',"p.id=rq.prd_id","LEFT");

    $this->db->where('rq.id',$id);

    $this->db->limit(15, 0);

    return $query = $this->db->get();

  }



  public function update_wishlist($userid='',$dataStr='',$condition1=''){

    

    $sel_qry = "select product_id,id from ".LISTS_DETAILS." where user_id=".$userid."";

    $ListVal = $this->ExecuteQuery($sel_qry);

    

    if($ListVal->num_rows() > 0){

      //exit("if");

      foreach($ListVal->result() as $wlist){

      $productArr=@explode(',',$wlist->product_id);

        if(!empty($productArr)){

          if(in_array($dataStr,$productArr)){

          $conditi = array('id' => $wlist->id);

            //$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);

            $my_array = array_filter($productArr);

            $to_remove =(array)$dataStr;

            $result = array_diff($my_array, $to_remove);

            

            $resultStr =implode(',',$result);



            /* $newdata = array('fav'=>0);

            $condition = array('id'=>$dataStr);

            $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );

            */

            $this->updateWishlistRentals(array('product_id' =>$resultStr),$conditi);

          }

        }

      }

    }

    

    if(!empty($condition1)){

      //exit("else");

      //foreach($condition1 as $wcont){

        $select_qry = "select product_id from ".LISTS_DETAILS." where id=".$condition1."";

        $productList = $this->ExecuteQuery($select_qry);

        $productIdArr=explode(',',$productList->row()->product_id);

    

        if(!empty($productIdArr)){

          if(!in_array($dataStr,$productIdArr)){

            $select_qry = "update ".LISTS_DETAILS." set product_id=concat(product_id,',".$dataStr."') where id=".$condition1."";

            $productList = $this->ExecuteQuery($select_qry);

            /* $newdata = array('fav'=>1);

            $condition = array('id'=>$dataStr);

            $this->mobile_model->update_details ( PRODUCT, $newdata, $condition );

            */

          }

        }

      //}

    }

  }



  public function updateWishlistRentals($dataArr='',$condition=''){

   

      $this->db->where($condition);

      $this->db->update(LISTS_DETAILS,$dataArr);

  }



  public function update_wishlist_property($property_id='',$user_id='',$wishlist_id='')

  {

    $select_qry = "select product_id from ".LISTS_DETAILS." where id=".$wishlist_id."";

    $productList = $this->ExecuteQuery($select_qry);

    $productIdArr=explode(',',$productList->row()->product_id);



    if(!empty($productIdArr))

    {

      if(!in_array($property_id,$productIdArr))

      {

        $select_qry = "update ".LISTS_DETAILS." set product_id=concat(product_id,',".$property_id."') where id=".$wishlist_id."";

        $productList = $this->ExecuteQuery($select_qry);



        $select_pro_qry = "update ".PRODUCT." set fav=1 where id=".$property_id."";

        $productwishList = $this->ExecuteQuery($select_pro_qry);

      }

    }

  }

  /* REMOVE WISHLIST PROPERTY */

  public function remove_wishlist_property ($property_id='',$user_id='',$wishlist_id='')

  {



    //$sel_qry = "select product_id,id from ".LISTS_DETAILS." where id=".$wishlist_id."";

    $sel_qry = "select product_id,id from ".LISTS_DETAILS." where find_in_set(".$property_id.",product_id)";

    $ListVal = $this->ExecuteQuery($sel_qry);

    

    if($ListVal->num_rows() > 0){

      //exit("if");

      foreach($ListVal->result() as $wlist){

      $productArr=@explode(',',$wlist->product_id);

        if(!empty($productArr)){

          if(in_array($property_id,$productArr)){

          $conditi = array('id' => $wlist->id);

            //$WishListCatArr = @explode(',',$this->data['WishListCat']->row()->product_id);

            $my_array = array_filter($productArr);

            $to_remove =(array)$property_id;

            $result = array_diff($my_array, $to_remove);

            

            $resultStr =implode(',',$result);

            $select_pro_qry = "update ".PRODUCT." set fav=0 where id=".$property_id."";

            $productwishList = $this->ExecuteQuery($select_pro_qry);



            $this->updateWishlistRentals(array('product_id' =>$resultStr),$conditi);

          }

        }

      }

    }

  }

  /* Add Review */

  public function add_review($dataArr=''){

    return $this->db->insert(REVIEW,$dataArr);

  }



  /* ADD Dispute */

  public function add_dispute($dataArr=''){

    return $this->db->insert(DISPUTE,$dataArr);

  }

  /* Get Your Dispute */

    public function get_trip_dispute($bookingno='',$disputer_id='')
    {

        $this->db->select('d.*,u.firstname,u.lastname,u.image,p.product_title,pa.address,pa.city,pa.state,pa.country');
        $this->db->from(DISPUTE.' as d');
        $this->db->join(USERS.' as u',"u.id=d.user_id","LEFT");
        $this->db->join(PRODUCT.' as p',"p.id=d.prd_id","LEFT");
        $this->db->join(PRODUCT_ADDRESS_NEW.' as pa',"pa.productId=p.id","LEFT");
        $this->db->where('d.booking_no',$bookingno);
        if($disputer_id !='')
        {
            $this->db->where('d.user_id',$disputer_id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_trip_review($bookingno='',$reviewer_id='')

    {

        $this->db->select('p.*,u.firstname,u.lastname,u.image,prd.product_title');

        $this->db->from(REVIEW.' as p');

        $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");
        $this->db->join(PRODUCT.' as prd',"prd.id=p.product_id","LEFT");

        $this->db->where('p.bookingno',$bookingno);

        if($reviewer_id !='')

        {

            $this->db->where('p.reviewer_id',$reviewer_id);

        }

        $query = $this->db->get();

        return $query;

    }

  /* PROPERTY DETAILS REVIEW DETAILS */

    public function get_review($prodID,$reviewer_id='')

    {

        $this->db->select('p.*,u.id,u.firstname,u.lastname,u.image');

        $this->db->from(REVIEW.' as p');

        $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");

        $this->db->where('p.product_id',($prodID));

        if($reviewer_id !='')

        {

            $this->db->where('p.reviewer_id',$reviewer_id);

        }

        $this->db->where('p.status','Active');

        $this->db->order_by(DATE_FORMAT('%Y-%m-%d','p.dateAdded'),'desc');

        /* $this->db->get();
         echo $this->db->last_query();die;*/
        return $query = $this->db->get();


        //echo $this->db->last_query();die;

    }

    /* PROPERTY DETAILS REVIEW DETAILS */

    public function get_review_tot($product_id)

    {

        /*$this->db->cache_on(); Hide for updated details want to show*/

        $this->db->select('AVG(total_review) as tot_tot, AVG(accuracy) as tot_acc, AVG(communication) as tot_com, AVG(cleanliness) as tot_cln, AVG(location) as tot_loc, AVG(checkin) as tot_chk, AVG(value) as tot_val,product_id,status,total_review,accuracy,communication,cleanliness,location,checkin,value');

        $this->db->from(REVIEW);

        $this->db->where('product_id',$product_id);
        $this->db->where('status','Active');

        $query = $this->db->get();

        return $query;

    }



  public function get_exprience_view_details_withFilters($condition='')

  {

    $select_qry = "select p.experience_id,p.experience_title,expAdd.city,cur.currency_symbols,p.price,p.exp_type,extyp.experience_title as type_title,d.from_date,(SELECT Count(rw.id) FROM fc_experience_review rw WHERE rw.product_id=p.experience_id) as review_count,(SELECT AVG(rw.total_review) FROM fc_experience_review rw WHERE rw.product_id=p.experience_id) as review_avg,rp.product_image as product_image from ".EXPERIENCE." p  

    LEFT JOIN ".EXPERIENCE_TYPE." extyp on extyp.id=p.type_id

    LEFT JOIN ".fc_currency." cur on cur.currency_type=p.currency    

    LEFT JOIN ".EXPERIENCE_ADDR." expAdd on expAdd.experience_id=p.experience_id 

    LEFT JOIN ".EXPERIENCE_PHOTOS." rp on rp.product_id=p.experience_id

    LEFT JOIN ".EXPERIENCE_DATES." d on d.experience_id=p.experience_id

    LEFT JOIN ".EXPERIENCE_TIMING." dt on dt.exp_dates_id=d.id ".$condition;   

    $productList = $this->ExecuteQuery($select_qry);

    return $productList;

    

  }



  public function view_experience_details_mobile($where1,$where_or,$where2)

  {

    //$this->db->cache_on();

    $this->db->select('p.experience_id,p.exp_type,p.experience_title,p.exp_tagline,p.currency,p.price,p.user_id,p.type_id,p.date_count,p.total_hours,p.experience_description,p.note_to_guest,p.about_host,p.location_description,p.group_size,p.guest_requirement,p.cancel_policy,p.cancel_percentage,p.video_url,p.page_view_count,p.language_list,p.kit_content,extyp.experience_title as exp_title, 

    u.firstname,u.group,u.image as thumbnail,u.id_verified, pa.address as exp_address, pa.lat as exp_lat, pa.lang as exp_lang,pa.city as exp_city,d.from_date as exp_fromdate,d.to_date as exp_todate');

    $this->db->from(EXPERIENCE.' as p');

    $this->db->join(EXPERIENCE_TYPE.' as extyp',"extyp.id=p.type_id","LEFT");

    $this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");

    $this->db->join(EXPERIENCE_DATES.' as d',"d.experience_id=p.experience_id","LEFT");

    $this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");

    $this->db->where($where1);

    $this->db->or_where($where_or);

    $this->db->where($where2);

    $this->db->where(array("u.host_status"=>'0'));

    $this->db->group_by('p.experience_id');

    return $query = $this->db->get();

    

  }



  public function view_experience_photos_mobile($exper_id)

  {

    $this->db->select('product_image');

    $this->db->from(fc_experience_photos);

    $this->db->where('product_id',$exper_id);

    /*$this->db->where('status','Active');*/

    return $query = $this->db->get();

  }



  public function get_known_language($lancode)

  {

    $this->db->select('language_name');

    $this->db->from(fc_languages_known);

    $this->db->where('language_code',$lancode);

    return $query = $this->db->get();

  }



  public function get_all_equipment_details($exper_id)

  {

    $this->db->select('p.kit_title,p.kit_detailed_title,p.kit_count,p.kit_description');

    $this->db->from(fc_exp_kit_contents.' as p');

    $this->db->where('experience_id',$exper_id);

    $this->db->where('status','1');

    return $query = $this->db->get();

  }



  public function get_exp_review($product_id,$reviewer_id='')

  {    

    $this->db->select('p.review,p.dateAdded,p.total_review,u.firstname,u.lastname,u.image,(SELECT Count(rw.id) FROM fc_experience_review rw WHERE rw.product_id='.$product_id.') as total_review_count,(SELECT AVG(rw.total_review) FROM fc_experience_review rw WHERE rw.product_id='.$product_id.') as review_avg');

    $this->db->from(EXPERIENCE_REVIEW.' as p');

    $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");

    $this->db->where('p.product_id',$product_id);

    if($reviewer_id !='')

    {

    $this->db->where('p.reviewer_id',$reviewer_id);

    }

    $this->db->where('p.status','Active');

    $this->db->order_by('p.dateAdded','desc');

    $query = $this->db->get();

    return $query;   

  }



   public function update_wishlist_experience($experience_id='',$user_id='',$wishlist_id='')

  {

    $select_qry = "select experience_id from ".LISTS_DETAILS." where id=".$wishlist_id."";

    $experienceList = $this->ExecuteQuery($select_qry);

    $experienceIdArr=explode(',',$experienceList->row()->experience_id);



    if(!empty($experienceIdArr))

    { 

      if(!in_array($experience_id,$experienceIdArr))

      { 

        $select_qry = "update ".LISTS_DETAILS." set experience_id=concat(experience_id,',".$experience_id."') where id=".$wishlist_id."";

        $experienceList = $this->ExecuteQuery($select_qry);

       /* $select_pro_qry = "update ".PRODUCT." set fav=1 where id=".$experience_id."";

        $experiencewishList = $this->ExecuteQuery($select_pro_qry);*/ 

      }

    }

  }



  public function get_list_details_wishlist_experience($condition = ''){

    

     $select_qry = "select id,name,experience_id from ".LISTS_DETAILS." where user_id=".$condition."  or user_id=0"; 

    $productList = $this->ExecuteQuery($select_qry);

    return $productList;

  }



  public function get_experience_details_wishlist_one_category($condition = '')

  {

    $this->db->select('pa.city as name,p.experience_id, p.currency, p.user_id, p.experience_title as experience_title,  p.price, n.notes as review_content, pa.address');

    $this->db->from(EXPERIENCE.' as p');

    $this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");

    $this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");

    $this->db->join(NOTES.' as n',"n.experience_id=p.experience_id","LEFT");

    $this->db->where_in('p.experience_id',$condition);

    $this->db->group_by('p.experience_id');

    $this->db->order_by('pp.imgPriority','asc');

    return $query = $this->db->get();



  }

  

  public function get_wishlist_experience_photo($condition = '')

  {

    $this->db->select('product_image,product_id');

    $this->db->from(fc_experience_photos);

    $this->db->where('product_id',$condition);

    return $query = $this->db->get();

  }



  /* REMOVE WISHLIST EXPERIENCE */

  public function remove_wishlist_experience ($experience_id='',$user_id='',$wishlist_id='')

  {



    $sel_qry = "select experience_id,id from ".LISTS_DETAILS." where find_in_set(".$experience_id.",experience_id)";

    $ListVal = $this->ExecuteQuery($sel_qry);

    

    if($ListVal->num_rows() > 0)

    {     

      foreach($ListVal->result() as $wlist)

      {

        $productArr = explode(',',$wlist->experience_id);

        if(!empty($productArr))

        {

          if(in_array($experience_id,$productArr))

          {

            $conditi = array('id' => $wlist->id);            

            $my_array = array_filter($productArr);

            $to_remove =(array)$experience_id;

            $result = array_diff($my_array, $to_remove);            

            $resultStr =implode(',',$result);           

            $this->updateWishlistRentals(array('experience_id' =>$resultStr),$conditi);

          }

        }

      }

    }

  }



  /* get available dates for booking */

  public function getAvailableDates($product_id,$date)

  { 

    $this->db->select("d.id,exp.group_size,(select IFNULL(count(eq.date_id),0) from ".EXPERIENCE_ENQUIRY." as eq where eq.date_id=d.id and eq.booking_status='".Booked."') as date_booked_count",FALSE);

    $this->db->from(EXPERIENCE_DATES.' as d');

    $this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");

    $this->db->where('d.experience_id',$product_id);

    $this->db->where('d.from_date >',$date);

    $this->db->where('d.status','0');

    $this->db->where('exp.status','1');

    $this->db->order_by('d.id');



    return $query = $this->db->get(); /*echo $this->db->last_query(); exit;*/

  }

  

  

  /*  date schedule data  */

  public function getDateSchedule($dateId)

  {

    $this->db->select('d.schedule_date,d.start_time,d.end_time,d.title');

    $this->db->from(EXPERIENCE_TIMING.' as d');

    $this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");

    $this->db->where('d.exp_dates_id ',$dateId);

    $this->db->where('d.status ','1');

    $this->db->where('exp.status ','1');

    $this->db->order_by('d.id');

    return $query = $this->db->get();   

  }





  public function get_experience_booking_dates($exp_id)

  {

    $this->db->select('d.id,d.experience_id ,d.from_date,d.to_date,exp.user_id,exp.date_count,exp.cancel_percentage,exp.security_deposit,exp.currency,exp.price');

    $this->db->from(EXPERIENCE_DATES.' as d');

    $this->db->join(EXPERIENCE.' as exp',"exp.experience_id=d.experience_id","LEFT");

    $this->db->where('d.experience_id',$exp_id);

    $this->db->where('d.status ','0');//active

    $this->db->where('exp.status ','1');

    $this->db->order_by('d.id');



    return $query = $this->db->get();



  }



  public function get_experience_payment_details($UserNo,$EnquiryId)

  {

    $this->db->select('*');

    $this->db->from(EXPERIENCE_BOOKING_PAYMENT);

    $this->db->where('user_id',$UserNo);

    $this->db->where('EnquiryId',$EnquiryId);

    $this->db->where('status ','Paid');



    return $query = $this->db->get();



  }



  public function edit_experiencebooking($dataArr='',$condition='')

  {

      $this->db->where($condition);

      $this->db->update(EXPERIENCE_ENQUIRY,$dataArr);

  }

  



  public function PaymentSuccess($userid='', $randomId='' ,$transId = '', $payerMail = '')

  {    

  

    $paymtdata = array(

        'randomNo' => $randomId,

        'fc_session_user_id' => $userid,

    );

    $this->session->set_userdata($paymtdata);



    /* referal user commission payment starts */

    $referred_user = $this->order_model->get_all_details(USERS,array('id'=>$userid));

    $refered_user = $referred_user->row()->referId;



    $user_booked = $this->order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('user_id'=>$userid,'status'=>'Paid'));

    

    if($user_booked->num_rows()==0)

    {

      $booked_data_Q = $this->order_model->get_all_details(EXPERIENCE_BOOKING_PAYMENT,array('user_id'=>$userid,'dealCodeNumber'=>$randomId));

      

      $totalAmount = $booked_data_Q->row()->total;

      $currencyCode = $booked_data_Q->row()->currency_code;

      //Commission percent

      $book_commission_query = 'SELECT * FROM '.COMMISSION.' WHERE seo_tag = "guest_invite_accept" AND status="Active"';

        $book_commission = $this->order_model->ExecuteQuery($book_commission_query);

       

        if($book_commission->num_rows()>0){

          if($book_commission->row()->promotion_type=='flat'){

            $referal_commission = round($totalAmount - $book_commission->row()->commission_percentage,2);

          }else{

            $commission = round(($book_commission->row()->commission_percentage/100) ,2);

            $referal_commission = ($totalAmount * $commission);

          }

        //echo $book_commission->row()->commission_percentage.'--'.$referal_commission;



          //Commission amount currency conversion

          if($currencyCode!='USD')

          {

            $referal_commission = convertCurrency($currencyCode,'USD',$referal_commission);

          }

          



          //referred user existing data

          $referred_userData = $this->order_model->get_all_details(USERS,array('id'=>$refered_user));

          $existAmount = $referred_userData->row()->referalAmount;

        $exit_totalReferalAmount = $referred_userData->row()->totalReferalAmount;

        

          $existAmountCurrenctCode =  $referred_userData->row()->referalAmount_currency;

          if($existAmountCurrenctCode!='USD')

          {

            $existAmount = convertCurrency($existAmountCurrenctCode,'USD',$existAmount);

          $exit_totalReferalAmount = convertCurrency($existAmountCurrenctCode,'USD',$exit_totalReferalAmount);

          

          }



          $tot_commission = $existAmount + $referal_commission;

        $new_totalReferalAmount  = $exit_totalReferalAmount + $referal_commission;



        $inputArr_ref = array('totalReferalAmount'=>$new_totalReferalAmount,'referalAmount'=> $tot_commission,'referalAmount_currency'=> 'USD');

        $this->order_model->update_details(USERS,$inputArr_ref,array('id' =>$refered_user));

        //echo $this->db->last_query();exit;

      }

    }    



    //Update Payment Table  

      $condition1 = array( 'user_id' => $userid, 'dealCodeNumber' => $randomId);

      if($payerMail != ''){

        $dataArr1 = array('status' => 'Paid','shipping_status' => 'Processed', 'paypal_transaction_id' => $transId, 'payer_email' => $payerMail,'payment_type' => 'Paypal');      

      }else{

      

        $dataArr1 = array('status' => 'Paid','shipping_status' => 'Processed', 'paypal_transaction_id' => $transId, 'payment_type' => 'Credit Cart' );

      }

      

      $this->order_model->update_details(EXPERIENCE_BOOKING_PAYMENT,$dataArr1,$condition1);

            

        

    $paymtdata = array('randomNo' => '','EnquiryId' => '');

    $this->session->unset_userdata($paymtdata); 

    

    return 'Success';

  }

  



  public function view_experienceType_details(){

    $select_qry = "select id,experience_title from ".EXPERIENCE_TYPE." ORDER BY id DESC";

    $attributeList = $this->ExecuteQuery($select_qry);

    return $attributeList;

      

  }



  public function view_experience_details($condition = '')

  {

    $select_qry = "select p.*,p.experience_id as id,p.experience_title as product_title,u.firstname,u.lastname,u.image as user_image,u.feature_product,pa.lat as latitude,pa.lang as longitude,pa.city,pa.state,pa.country,pa.zip,pa.street as apt,pa.address,p.featured from ".EXPERIENCE." p 

    LEFT JOIN ".EXPERIENCE_ADDR." pa on pa.experience_id=p.experience_id

    LEFT JOIN ".USERS." u on (u.id=p.user_id) ".$condition;

    $productList = $this->ExecuteQuery($select_qry);

    

    return $productList;    

  }



  public function get_date_time_details($experience_id){



    $sql="select D.id as date_id,D.from_date,D.to_date,D.status,E.exp_type,(select IFNULL(count(T.id),0) from ".EXPERIENCE_TIMING." as T where T.exp_dates_id= D.id) as time_count from ".EXPERIENCE_DATES." as D left join ".EXPERIENCE." as E on D.experience_id = E.experience_id WHERE D.experience_id='".$experience_id."' group by D.id order by D.created_at desc";

    $res=$this->ExecuteQuery($sql);

    return $res;    

  }



  public function get_images($product_id)

  {

    $this->db->from(EXPERIENCE_PHOTOS);

    $this->db->where('product_id',$product_id);

    $this->db->order_by('imgPriority','asc');

  

    return $query = $this->db->get();      

  }

  

  public function get_exp_details($product_id){



    $this->db->select("d.experience_title,d.experience_id,ep.product_image,ea.address");

    $this->db->from(EXPERIENCE.' as d');

    $this->db->join(EXPERIENCE_PHOTOS.' as ep',"ep.product_id=d.experience_id","LEFT");

    $this->db->join(EXPERIENCE_ADDR.' as ea',"ea.experience_id=d.experience_id","LEFT");

    $this->db->where('d.experience_id',$product_id);

    return $query = $this->db->get();

  }

  

  public function booked_rental_trip($userId = '')

  {

    $this->db->select('rq.id as booking_id,rq.prd_id as product_id, pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name, p.experience_title as product_name,p.experience_id,p.experience_title as product_title,p.host_status,p.user_id,p.security_deposit,p.cancel_percentage, u.firstname,u.image, g.email, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.serviceFee, rq.totalAmt,rq.secDeposit, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno,rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,rq.currency_cron_id,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price,p.group_size');

    $this->db->from(EXPERIENCE_ENQUIRY . ' as rq');

    $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');

    $this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');

    $this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");

    $this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');

    $this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');

    $this->db->join(USERS . ' as u', 'u.id = rq.renter_id');    

    $this->db->join(USERS . ' as g', 'g.id = ' . $userId);

    $this->db->where('rq.user_id = ', $userId);

    $this->db->where('DATE(rq.checkout) > ', date('"Y-m-d H:i:s"'), FALSE);

    $this->db->where('rq.booking_status != "Enquiry"');

    $this->db->group_by('rq.id');

    $this->db->order_by('rq.dateAdded', 'desc');       

    return $this->db->get();

  }

  

  /* experience trip review  */

  public function get_exp_trip_review($bookingno = '', $reviewer_id = '')

  {

    $this->db->select('p.*,u.firstname,u.lastname,u.image');

    $this->db->from(EXPERIENCE_REVIEW . ' as p');

    $this->db->join(USERS . ' as u', "u.id=p.reviewer_id", "LEFT");

    $this->db->where('p.bookingno', $bookingno);

    if ($reviewer_id != '') {

      $this->db->where('p.reviewer_id', $reviewer_id);

    }

    $query = $this->db->get();

    return $query;

  }



  /*  my experience previous */

  function booked_rental_trip_prev($userId = '')

  {

    $this->db->select('rq.id as booking_id,rq.prd_id as product_id,pn.zip as post_code,pn.address as prd_address, pn.street as apt, pp.product_image, pn.country as country_name, pn.state as state_name, pn.city as city_name,p.experience_id, p.cancel_percentage,  p.experience_title as product_name, p.experience_title as product_title, u.firstname,u.image, g.email, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.renter_id, rq.subTotal, rq.secDeposit, rq.serviceFee, , rq.totalAmt, rq.approval as approval, rq.id as cid, rq.Bookingno as bookingno, rq.walletAmount,rq.unitPerCurrencyUser,rq.date_id,rq.user_currencycode,pay.is_wallet_used,pay.is_coupon_used,pay.discount,pay.total_amt,p.currency, p.price');

    $this->db->from(EXPERIENCE_ENQUIRY . ' as rq');

    $this->db->join(EXPERIENCE . ' as p', 'p.experience_id = rq.prd_id', 'left');

    $this->db->join(EXPERIENCE_DATES . ' as d', "d.id=rq.date_id", "LEFT");

    $this->db->join(EXPERIENCE_ADDR . ' as pn', 'pn.experience_id = p.experience_id', 'left');

    $this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'p.experience_id = pp.product_id', 'left');

    $this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as pay', 'pay.product_id = p.experience_id', 'left');

    $this->db->join(USERS . ' as u', 'u.id = rq.renter_id');

    $this->db->join(USERS . ' as g', 'g.id = ' . $userId);

    $this->db->where('rq.user_id = ' . $userId);

    $this->db->where('DATE(rq.checkout) <= ', date('"Y-m-d H:i:s"'), FALSE); 

    $this->db->where('rq.booking_status != "Enquiry"');   

    $this->db->group_by('rq.id');

    $this->db->order_by('rq.dateAdded', 'desc');

    return $this->db->get();

  }



  /*  add review */

  public function add_exp_review($dataArr = '')

  {

    return $this->db->insert(EXPERIENCE_REVIEW, $dataArr);

  }



  public function get_expreview($bookingNo='',$reviewer_id='')

  { 

    $this->db->select('p.*,u.firstname,u.lastname,u.image');

    $this->db->from(fc_experience_review.' as p');

    $this->db->join(USERS.' as u',"u.id=p.reviewer_id","LEFT");

    $this->db->where('p.bookingno',$bookingNo);

    if($reviewer_id !='')

    {

      $this->db->where('p.reviewer_id',$reviewer_id);

    }

    $query = $this->db->get();

    return $query;

  }



  public function get_expdispute($booking_no='',$user_id='')

  {

    $this->db->select('d.*,u.experience_title,ad.address,pp.product_image');

    $this->db->from(fc_experience_dispute.' as d');

    $this->db->join(EXPERIENCE.' as u',"u.experience_id=d.prd_id","LEFT");

    $this->db->join(EXPERIENCE_ADDR.' as ad',"ad.experience_id=u.experience_id","LEFT");

    $this->db->join(EXPERIENCE_PHOTOS . ' as pp', 'pp.product_id=u.experience_id', 'left');

    $this->db->where('d.booking_no',$booking_no);

    $this->db->where('d.user_id',$user_id);

    $query = $this->db->get()->row();

    return $query;

  }



  /* user booking details to send mail */

  public function getexpbookeduser_detail($id)

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



    public function get_dashboard_experience_lists($userId)

  {  



    $this->db->select('p.*,p.experience_id as id,pp.product_image,pa.lat as latitude,p.price,hs.payment_status,sched.id as date_id,u.id,u.user_name,u.id_verified,u.email');   



    $this->db->from(EXPERIENCE.' as p');



    $this->db->join(EXPERIENCE_ADDR.' as pa',"pa.experience_id=p.experience_id","LEFT");



    $this->db->join(EXPERIENCE_PHOTOS.' as pp',"pp.product_id=p.experience_id","LEFT");



    $this->db->join(EXPERIENCE_DATES.' as sched',"sched.experience_id=p.experience_id","LEFT");



    $this->db->join(EXPERIENCE_LISTING_PAYMENT.' as hs',"hs.product_id=p.experience_id","LEFT");



    $this->db->join(USERS.' as u',"u.id=p.user_id","LEFT");    



    $this->db->where_in('p.user_id',$userId);



    $this->db->group_by('p.experience_id');



    $this->db->order_by('p.experience_id','desc');    



    return $query = $this->db->get();   



  }

  

  function get_reservation_list($userId)

  {



    $cur_date = date('Y-m-d');



    $this->db->select('p.*,p.experience_id as product_id,pa.zip as post_code,pa.address,pa.street as apt, pa.country as country_name, pa.state as state_name, pa.city as city_name, p.experience_title as product_name,p.experience_title as product_title,p.price,p.currency,p.security_deposit, u.firstname, u.image, u.loginUserType, rq.id as EnqId, rq.booking_status, rq.checkin, rq.checkout, rq.dateAdded, rq.user_id as GestId, rq.numofdates as noofdates, rq.NoofGuest as NoofGuest, rq.approval as approval,rq.subTotal,rq.unitPerCurrencyUser,rq.user_currencycode,rq.serviceFee,rq.secDeposit,rq.totalAmt,rq.Bookingno as Bookingno, rq.date_id');



    $this->db->from(EXPERIENCE.' as p');



    $this->db->join(EXPERIENCE_ADDR.' as pa' , 'pa.experience_id = p.experience_id','left');      



    $this->db->join(EXPERIENCE_ENQUIRY.' as rq' , 'p.experience_id = rq.prd_id');



    $this->db->join(USERS.' as u' , 'u.id = rq.user_id');



    $this->db->where('p.user_id = '.$userId);



    $this->db->where('DATE(rq.checkin) >= "'.$cur_date.'"');



    $this->db->where('rq.renter_id = '.$userId);



    $this->db->where('rq.booking_status != "Enquiry"');



    $this->db->group_by('rq.id');



    $this->db->order_by('rq.dateAdded','desc');



    return $this->db->get(); 

  }

  

  public function get_time_count_details($experience_id,$exp_dates_id){



    $sql="select D.id as date_id,D.from_date,D.to_date,D.status,E.exp_type,E.date_count,E.total_hours,(select IFNULL(count(T.id),0) from ".EXPERIENCE_TIMING." as T where T.exp_dates_id= D.id) as time_count from ".EXPERIENCE_DATES." as D left join ".EXPERIENCE." as E on D.experience_id = E.experience_id WHERE D.experience_id='".$experience_id."' AND D.id='".$exp_dates_id."' group by D.id order by D.created_at desc";

    $res=$this->ExecuteQuery($sql);

    return $res;    

  }

  

  public function get_time_sheet($experience_id,$exp_dates_id)

  {

     $this->db->select('schedule_date');  

     $this->db->from(EXPERIENCE_TIMING); 

     $this->db->where('exp_dates_id',$exp_dates_id);

     return $query = $this->db->get();

  }

    

    public function edit_expbooking($dataArr='',$condition=''){

      $this->db->where($condition);

      $this->db->update(EXPERIENCE_ENQUIRY,$dataArr);

  }

    /* cancellation about You */
    function get_productcancellation_aboutyou($user_id='',$rental_type='')
    {
        $this->db->select('d.id,d.status,d.message,d.booking_no,u.image,u.email,u.loginUserType,d.created_date,p.product_title,u.user_name,rq.checkin,rq.checkout');
        $this->db->from(DISPUTE.' as d');
        $this->db->where('d.disputer_id', $user_id);
        $this->db->where('d.cancel_status', 1);
        //$this->db->where('d.dispute_by', '');
        $this->db->join(RENTALENQUIRY . ' as rq', "rq.Bookingno=d.booking_no", 'left');
        $this->db->join(PRODUCT.' as p',"d.prd_id=p.id");
        $this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");
        $this->db->order_by('d.id','desc');
        return $query = $this->db->get_where();
    }
    /* cancellation By You */
    function get_productcancellation_byyou($user_id='',$rest_type='')
    {
        $this->db->select('d.id,d.status,d.message,d.booking_no,u.image,u.email,u.loginUserType,d.created_date,d.email,p.product_title,host.full_name,rq.checkin');
        $this->db->from(DISPUTE.' as d');
        $this->db->where('d.user_id', $user_id);
        $this->db->where('d.cancel_status', 1);
        $this->db->join(PRODUCT.' as p',"d.prd_id=p.id");
        $this->db->join(USERS.' as u',"u.id=d.user_id", "LEFT");
        $this->db->join(USERS.' as host',"host.id=d.disputer_id", "LEFT");
        $this->db->join(RENTALENQUIRY.' as rq','rq.Bookingno = d.booking_no');
        $this->db->order_by('d.id','desc');
        return $query = $this->db->get_where();
    }

    public function add_cancellation($dataArr=''){

        return $this->db->insert(DISPUTE,$dataArr);

    }

    public function get_cancel_pending_count($userid)
    {
        $this->db->select('count(*) as pending_count');
        $this->db->from(DISPUTE);
        $this->db->where('status','pending');
        $this->db->where('user_id',$userid);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function get_host_calcelled_bookings($host_id)
    {
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
        $this->db->group_by('c.id');
        $this->db->order_by('c.dateAdded', 'desc');
        return $this->db->get();
    }

    public function get_coupon_available($curr_date){

        $Query = "select c.* from ".COUPONCARDS. " c where  ('".$curr_date."' between c.datefrom and c.dateto or (c.dateto ='".$curr_date."') or (c.datefrom ='".$curr_date."') ) and status='Active'";
        return $this->ExecuteQuery($Query);

    }

    public function get_coupon_details($code='',$prd_id)
    {
        $query = "SELECT * FROM fc_couponcards WHERE FIND_IN_SET('".$prd_id."',product_id) AND code = '".$code."' AND status = 'Active' ";
        return $this->ExecuteQuery($query);
    }

    /*Unread Message*/
    public function get_inbox_unread_message($userid,$bookingno = '')
    {
        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userid . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.senderId', 'LEFT');
        $this->db->where('m.msg_status','0');
        $this->db->where('m.msg_read','No');
        $this->db->where('m.receiverId', $userid);
        if(!empty($bookingno)){
            $this->db->where_in('m.bookingNo',$bookingno);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        return  $this->db->get();
    }

    /*Over All Unread Message count*/
    public function overAll_unread_count($userid)
    {
        $this->db->select('m.*');
        $this->db->from(MED_MESSAGE .' as m');
        $this->db->join(PRODUCT . ' as p','p.id=m.productId','LEFT');
        $this->db->where('m.receiverId',$userid);
        $this->db->where("((m.receiverId=p.user_id and m.host_msgread_status='No') or (m.receiverId!=p.user_id and m.user_msgread_status='No'))");
        $this->db->where('m.msg_status',0);

        $sql = $this->db->get();
        return $sql->num_rows();
    }

    public function get_inbox_reservation_message($userid,$bookingno = '')
    {
        $this->db->select("m1.*,rq.booking_status,rq.approval,u.firstname,u.lastname,u.image,p1.user_id,(select IFNULL(count(m2.id),0) from ".MED_MESSAGE." as m2, ".PRODUCT." as p2 where m2.bookingNo = m1.bookingNo and m2.productId=p2.id and m2.receiverId = ".$userid." and ( ( m2.receiverId=p2.user_id and m2.host_msgread_status='No' ) or (m2.receiverId!=p2.user_id and m2.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE ." as m1");
        $this->db->join(RENTALENQUIRY . ' as rq','rq.Bookingno = m1.bookingNo','LEFT');
        $this->db->join(PRODUCT ." as p1","m1.productId = p1.id","LEFT");
        $this->db->join(USERS ." as u","u.id = m1.senderId",'LEFT');
        $this->db->join(USERS ." as u2","u2.id = m1.receiverId",'LEFT');
        $this->db->where('m1.msg_status',"0");
        $this->db->where('m1.receiverId',$userid);
        if(!empty($bookingno)){
            $this->db->where_in('m1.bookingNo',$bookingno);
        }
        $this->db->where('(rq.approval = "Accept" or rq.approval = "Decline" )');
        $this->db->group_by('m1.bookingNo');
        $this->db->order_by('m1.dateAdded','desc');

        return $this->db->get();
    }

    public function get_pending_request_message($userid,$bookingno = '')
    {
        $this->db->select('m.* ,RQ.booking_status,RQ.approval,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from ' . MED_MESSAGE . ' as ms,' . PRODUCT . ' as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=' . $userid .' and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status="No" ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status="No"))) as msg_unread_count',FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(RENTALENQUIRY . ' as RQ', 'RQ.Bookingno = m.bookingNo', 'LEFT');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.senderId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('RQ.approval=','Pending');
        $this->db->where('m.receiverId', $userid);
        if(!empty($bookingno)){
            $this->db->where_in('m.bookingNo',$bookingno);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');

        return $this->db->get();
    }

    /*Starred Message*/
    public function get_inbox_starred_message($userid,$bookingno ='')
    {
        $this->db->select("m.* ,u2.firstname,u2.lastname,u2.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userid . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.receiverId', 'LEFT');
        $this->db->join(USERS . ' as u2', 'u2.id = m.senderId', 'LEFT');
        $this->db->where('m.msg_status', '0');
        $this->db->where('m.msg_star_status','Yes');
        $this->db->where('m.receiverId', $userid);
        if(!empty($bookingno)){
            $this->db->where_in('m.bookingNo',$bookingno);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        /* $query = $this->db->get();
         $this->db->last_query($query);exit;*/
        return $this->db->get();
    }

    public function get_inbox_archive_message($userid,$bookingno = '')
    {
        $this->db->select("m.* ,u.firstname,u.lastname,u.image,p.user_id,(select IFNULL(count(ms.id),0)  from " . MED_MESSAGE . " as ms," . PRODUCT . " as pr where ms.bookingNo= m.bookingNo and ms.productId=pr.id and ms.receiverId=" . $userid . " and ( ( ms.receiverId=pr.user_id and ms.host_msgread_status='No' ) or (ms.receiverId!=pr.user_id and ms.user_msgread_status='No'))) as msg_unread_count",FALSE);
        $this->db->from(MED_MESSAGE . ' as m');
        $this->db->join(PRODUCT . ' as p', 'p.id = m.productId', 'LEFT');
        $this->db->join(USERS . ' as u', 'u.id = m.senderId', 'LEFT');
        $this->db->where('m.msg_status', '1');/*archive message status*/
        $this->db->where('m.receiverId', $userid);
        if(!empty($bookingno)){
            $this->db->where_in('m.bookingNo',$bookingno);
        }
        $this->db->group_by('m.bookingNo');
        $this->db->order_by('m.dateAdded', 'desc');
        return $this->db->get();
    }

    /*Get cancellation ABOUT YOU pending count except expired pending*/
    public function cancellation_aboutYou_count($userid)
    {
        $this->db->select('d.*','rq.checkin','rq.Bookingno');
        $this->db->from(DISPUTE . ' as d');
        $this->db->join(RENTALENQUIRY .' as rq','rq.Bookingno = d.booking_no','LEFT');
        $this->db->where('d.disputer_id',$userid);
        $this->db->where('d.status','Pending');
        $this->db->where('d.cancel_status',1);
        $this->db->where('rq.checkin >',date("Y-m-d"));/* before checkin condition*/
        return $this->db->get();
    }

    /*Get cancellation BY YOU pending count except expired pending date*/
    public function cancel_byYou_count($userid)
    {
        $this->db->select('d.*','rq.checkin','rq.Bookingno');
        $this->db->from(DISPUTE . ' as d');
        $this->db->join(RENTALENQUIRY .' as rq','rq.Bookingno = d.booking_no','LEFT');
        $this->db->where('d.user_id',$userid);
        $this->db->where('d.status','Pending');
        $this->db->where('d.cancel_status',1);
        $this->db->where('rq.checkin >',date("Y-m-d"));/* before checkin condition*/
        return $this->db->get();

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