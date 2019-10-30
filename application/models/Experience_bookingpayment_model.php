<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Experience_bookingpayment_model extends My_Model
{

	public function view_newbooking_details()
	{
		$this->db->select('rq.*,u.email,u.firstname,u.address,u.accname,u.Acccountry,u.swiftcode,u.phone_no,u.accno as bank_no,u.bankname as bank_name,u.postal_code,u.state,u.country,u.city,pd.experience_title as product_name,pd.price,pd.experience_id as PrdID, py.created as transaction_date, py.paypal_transaction_id as transaction_id, py.sell_id');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.renter_id = u.id');
		$this->db->join(EXPERIENCE . ' as pd', 'pd.experience_id = rq.prd_id');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		//$this->db->where('rq.booking_status = "'.$status.'"');	
		$this->db->where('py.status = "Paid"');
		$this->db->order_by("rq.dateAdded", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function view_userbooking_details($uid,$fromdate,$todate)
	{
		if ($fromdate != '' && $todate!='') {
			$Fromdate = DateTime::createFromFormat('d-m-Y', $fromdate); 
	        $fromdate = $Fromdate->format('Y-m-d');

	        $Todate = DateTime::createFromFormat('d-m-Y', $todate); 
	        $todate = $Todate->format('Y-m-d');
	        $fromdate = $fromdate. ' 00:00:00';
	        $todate = $todate. ' 23:00:00';
        }
      //  echo  $fromdate;
        if ($fromdate != '' && $todate!='') {
			
            $wherecond = "c.dateAdded between '".$fromdate."' and '".$todate."' ";

		}
		else{
			 $wherecond = '';
		}
		$this->db->select('c.*,re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,u.email,c.booking_no,cp.transaction_id');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as re');
		$this->db->join(USERS . ' as u', 're.renter_id = u.id');
		$this->db->join(EXP_COMMISSION_TRACKING . ' as c', 're.Bookingno=c.booking_no');
		$this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as py', 'py.EnquiryId = re.id');
        $this->db->join(EXP_COMMISSION_PAID . ' as cp', 'cp.id=c.commission_paid_id'," LEFT");
       	$this->db->where('py.status = "Paid"');
		$this->db->where('py.sell_id =', $uid);
		if($wherecond != ''){
		$this->db->where($wherecond);}
		$this->db->order_by("re.dateAdded", "desc");
		$UserList = $this->db->get();
		
		return $UserList;
	}

	public function view_newbooking_detailsexp($status)
	{
		$this->db->select('rq.*,u.email,u.firstname,u.address,u.accname,u.Acccountry,u.swiftcode,u.phone_no,u.bank_no,u.bank_name,u.postal_code,u.state,u.country,u.city,pd.experience_title as product_name,pd.price,pd.experience_id as PrdID');
		$this->db->from(EXPERIENCE_ENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.experience_id = rq.prd_id');
		$this->db->where('rq.booking_status = "' . $status . '"');
		$today = date('Y-m-d');
		$this->db->where("rq.dateAdded <=", $today);
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function get_all_commission_tracking()
	{

		$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,cp.transaction_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . EXP_COMMISSION_PAID . " cp on cp.id=c.commission_paid_id order by c.id desc ";
		return $this->ExecuteQuery($Query);
	}
	public function get_all_commission_tracking_filt($fromdate,$todate)
	{
		if ($fromdate != '' && $todate!='') {
			$Fromdate = DateTime::createFromFormat('d-m-Y', $fromdate); 
	        $fromdate = $Fromdate->format('Y-m-d');

	        $Todate = DateTime::createFromFormat('d-m-Y', $todate); 
	        $todate = $Todate->format('Y-m-d');
	        $fromdate = $fromdate. ' 00:00:00';
	        $todate = $todate. ' 23:00:00';
        }
      //  echo  $fromdate;
        if ($fromdate != '' && $todate!='') {
			
            $wherecond = "where c.dateAdded between '".$fromdate."' and '".$todate."' ";

		}
		else{
			 $wherecond = '';
		}
		$Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,cp.transaction_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . EXP_COMMISSION_PAID . " cp on cp.id=c.commission_paid_id ".$wherecond."order by c.id desc ";
//		echo $Query ;exit();

		return $this->ExecuteQuery($Query);
	}


	public function get_all_commission_tracking_selected($transaction_id){
		
        $Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,cp.transaction_id from " . EXP_COMMISSION_TRACKING . " c JOIN " . EXPERIENCE_ENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . EXP_COMMISSION_PAID . " cp on cp.id=c.commission_paid_id WHERE c.commission_paid_id=" .$transaction_id;
        return $this->ExecuteQuery($Query);

	}

}

?>
