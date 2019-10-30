<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Bookingpayment_model extends My_Model
{

	public function view_newbooking_details()
	{
		$this->db->select('rq.*,u.email,u.firstname,u.address,u.accname,u.Acccountry,u.swiftcode,u.phone_no,u.accno as bank_no,u.bankname as bank_name,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.price,pd.id as PrdID, py.created as transaction_date, py.paypal_transaction_id as transaction_id, py.sell_id');
		$this->db->from(RENTALENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.renter_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
		$this->db->join(PAYMENT . ' as py', 'py.EnquiryId = rq.id');
		//$this->db->where('rq.booking_status = "'.$status.'"');	
		$this->db->where('py.status = "Paid"');
		$this->db->order_by("rq.dateAdded", "desc");
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function view_newbooking_detailsexp($status)
	{
		$this->db->select('rq.*,u.email,u.firstname,u.address,u.accname,u.Acccountry,u.swiftcode,u.phone_no,u.bank_no,u.bank_name,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.price,pd.id as PrdID');
		$this->db->from(RENTALENQUIRY . ' as rq');
		$this->db->join(USERS . ' as u', 'rq.user_id = u.id');
		$this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
		$this->db->where('rq.booking_status = "' . $status . '"');
		$today = date('Y-m-d');
		$this->db->where("rq.dateAdded <=", $today);
		$PrdList = $this->db->get();
		//echo '<pre>'; print_r($PrdList->result()); die;
		return $PrdList;
	}

	public function get_all_commission_tracking($rep_code = '',$fromdate = '',$todate='')
	{
		
		
		$Query = "select c.* ,pay.*, re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,cp.transaction_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no JOIN " . PAYMENT . " pay on pay.EnquiryId=re.id LEFT JOIN " . COMMISSION_PAID . " cp on cp.id=c.commission_paid_id";
		if ($rep_code != '') {
			$Query .= " JOIN " . USERS . " u on u.email=c.host_email and u.rep_code='$rep_code' ";
		}
		if ($fromdate != '' && $todate!='') {
			$fromdate = date('Y-m-d', strtotime($fromdate)); 
			$todate = date('Y-m-d', strtotime($todate)); 
			 $fromdate = $fromdate. ' 00:00:00';
	        $todate = $todate. ' 23:00:00';
			$Query .= " where c.dateAdded between '".$fromdate."' and '".$todate."' ";
			
           // $this->db->where('c.dateAdded <=', $todate);
		}
		//echo $Query; exit;
		return $this->ExecuteQuery($Query);
		
	}
//get_all_commission_tracking_selected
	public function get_all_commission_tracking_by_user($rep_code = '', $host,$fromdate = '',$todate='')
	{
		/*echo $fromdate;
		echo $todate;
		exit;*/

		if ($fromdate != '' && $todate!='') {
			$Fromdate = DateTime::createFromFormat('d-m-Y', $fromdate); 
	        $fromdate = $Fromdate->format('Y-m-d');

	        $Todate = DateTime::createFromFormat('d-m-Y', $todate); 
	        $todate = $Todate->format('Y-m-d');
        }	
        
		
		//$host = 'kumarkailash075@gmail.com';
		$this->db->select('c.*,pay.*, rq.prd_id,rq.currencyPerUnitSeller,rq.currencycode,rq.user_currencycode,rq.currency_cron_id,cp.transaction_id');
		$this->db->from(COMMISSION_TRACKING . ' as c');
		$this->db->join(RENTALENQUIRY . ' as rq', 'rq.Bookingno=c.booking_no','LEFT');
		$this->db->join(PAYMENT . ' as pay', 'pay.EnquiryId=rq.id');
		$this->db->join(COMMISSION_PAID . ' as cp', 'cp.id=c.commission_paid_id','LEFT');
		if ($rep_code != '') {
			$this->db->join(USERS . ' as u', 'u.rep_code="' . $rep_code . '"');
		}

		if ($fromdate != '' && $todate!='') {
			$this->db->where('c.dateAdded >=', $fromdate);
            $this->db->where('c.dateAdded <=', $todate);
		}

		$this->db->where('c.host_email = "' . $host . '"');
		$UserList = $this->db->get();
		return $UserList;
	}


	public function get_all_commission_tracking_selected($transaction_id){
        $Query = "select c.* , re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,cp.transaction_id from " . COMMISSION_TRACKING . " c JOIN " . RENTALENQUIRY . " re on re.Bookingno=c.booking_no LEFT JOIN " . COMMISSION_PAID . " cp on cp.id=c.commission_paid_id WHERE c.commission_paid_id=" .$transaction_id;
        return $this->ExecuteQuery($Query);

	}


}

?>
