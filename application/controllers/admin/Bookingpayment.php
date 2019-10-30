<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Bookingpayment extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('account_model');
		$this->load->model('order_model');
		$this->load->model('bookingpayment_model');
		if ($this->checkPrivileges('Accounts', $this->privStatus) == FALSE)
		{
			redirect('admin');
		}
	} 

	/**
	 *
	 * This function loads the order list page
	 */
	public function index()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		} 
		else
		{
			redirect('admin/accounts/display_newbooking');
		}
	}

	/**
	 *
	 * This function loads the receivable and payable list page
	 */
	public function display_receivable()
	{

		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['fromdate']=$fromdate=$this->input->post('fromdate');
		    $this->data['todate']= $todate=$this->input->post('todate');
			//echo 'Data'.
			$this->data['heading'] = 'Receivable and Payable Payment';
			$this->data['newbookingList'] = $this->bookingpayment_model->view_newbooking_details();
			$condition = array('status' => 'Active', 'seo_tag' => 'host-listing');
			$service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
			$this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
			$condition = array('status' => 'Active', 'seo_tag' => 'guest-booking');
			$service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
			$this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
			/*without representative module*/

			/*with representative module*/
			$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');

			$uid = $this->uri->segment(4);
			if ($uid != '') 
			{
				//echo 'if';exit;
				$user = $this->product_model->get_all_details(USERS, array('id' => $uid));
				$this->data['commissionTracking'] = $this->bookingpayment_model->get_all_commission_tracking_by_user($rep_code, $user->row()->email,$fromdate,$todate);
				
			} 
			else 
			{
				//echo 'else'.$rep_code; exit;
				$this->data['commissionTracking'] = $this->bookingpayment_model->get_all_commission_tracking($rep_code,$fromdate,$todate);
				//print_r($this->data['commissionTracking']->result());
				//exit;
			}
			//echo $this->db->last_query();exit();
            $this->data['commission_paid_transactionID'] = $this->bookingpayment_model->get_all_details(COMMISSION_PAID,array());
			$this->load->view('admin/bookingpayment/display_receivable', $this->data);
		}
	}

	public function display_receivable_datatables()
	{
		if ($this->checkLogin('A') == '')
		{
			redirect('admin');
		} 
		else 
		{
			$admin_currency_code = $this->db->where('id', '1')->get(ADMIN)->row()->admin_currencyCode;
			$admin_currency_symbol = $this->db->where('currency_type', $admin_currency_code)->get(CURRENCY)->row()->currency_symbols;
			$requestData= $_REQUEST;
			$this->data['heading'] = 'Host List';
			$columns = array(
			// datatable column index  => database column name
				0 =>'transaction_id', 
				1 => 'booking_no',
				2=> 'host_email'
			);

			$fromdate=$this->input->post('fromdate');
		    $todate=$this->input->post('todate');
			//echo 'Data'.
			$this->data['heading'] = 'Receivable and Payable Payment';
			$this->data['newbookingList'] = $this->bookingpayment_model->view_newbooking_details();
			$condition1 = array('status' => 'Active', 'seo_tag' => 'host-listing');
			$service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition1);
			$this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
			$this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
			$condition1 = array('status' => 'Active', 'seo_tag' => 'guest-booking');
			$service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition1);
			$this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
			$this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
			/*without representative module*/

			/*with representative module*/
			$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');

			$uid = $this->input->post('uid');
			$host_det = $this->product_model->get_all_details(USERS, array('id' => $uid));
			$host = $host_det->row()->email;
			if ($uid != '') 
			{
				//echo 'if';exit;
				$user = $this->product_model->get_all_details(USERS, array('id' => $uid));
				
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
		$recievable_UserList = $this->db->get();
		
				
			} 
			else 
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
		//$this->db->query($Query);
		$recievable_UserList = $this->db->query($Query);
				
			}
// print_r($recievable_UserList->result());exit;
			

			$totalData = $recievable_UserList->num_rows();
			$totalFiltered = $totalData;

			if( !empty($requestData['search']['value']) ) {   
				$condition.=" ( transaction_id LIKE '".$requestData['search']['value']."%' ";    
				$condition.=" OR c.booking_no LIKE '".$requestData['search']['value']."%' ";
				$condition.=" OR c.host_email LIKE '".$requestData['search']['value']."%' )";
			}
			else{
				$condition = '';
			}
			//echo $condition;exit;
			if ($uid != '') 
			{
				//echo 'if';exit;
				$user = $this->product_model->get_all_details(USERS, array('id' => $uid));
				
		if ($fromdate != '' && $todate!='') {
			$Fromdate = DateTime::createFromFormat('d-m-Y', $fromdate); 
	        $fromdate = $Fromdate->format('Y-m-d');

	        $Todate = DateTime::createFromFormat('d-m-Y', $todate); 
	        $todate = $Todate->format('Y-m-d');
        }	
        
		
		
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
		if( !empty($requestData['search']['value']) ) {
		$this->db->where($condition);
		}
		$recievable_UserList = $this->db->get();
		
				
			} 
			else 
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
			$Query .= " where c.dateAdded between '".$fromdate."' and '".$todate."' '".$condition."'";
			
           // $this->db->where('c.dateAdded <=', $todate);
		}
		//echo $Query; exit;
		$recievable_UserList = $this->db->query($Query);
				
			}

			$totalFiltered = $recievable_UserList->num_rows();

			$order_is =" ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  ";
			$limit_is = "".$requestData['start']." ,".$requestData['length']."   ";
			if ($uid != '') 
			{
				//echo 'if';exit;
				$user = $this->product_model->get_all_details(USERS, array('id' => $uid));
				
		if ($fromdate != '' && $todate!='') {
			$Fromdate = DateTime::createFromFormat('d-m-Y', $fromdate); 
	        $fromdate = $Fromdate->format('Y-m-d');

	        $Todate = DateTime::createFromFormat('d-m-Y', $todate); 
	        $todate = $Todate->format('Y-m-d');
        }	
        
		
		
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
		if( !empty($requestData['search']['value']) ) {
		$this->db->where($condition);
		}
		$this->db->order_by($order_is);
		$this->db->limit($limit_is);
		$recievable_UserList = $this->db->get();
		
				
			} 
			else 
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
			$Query .= " where c.dateAdded between '".$fromdate."' and '".$todate."' '".$condition."'";

			//echo "string";
           // $this->db->where('c.dateAdded <=', $todate);
		}
		$Query.=" ORDER BY  ". /*$columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir'] .*/"c.dateAdded desc  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
	//	echo $Query; exit;
		$recievable_UserList = $this->db->query($Query);
				
			}

			$data = array(); 
			$i=1;
			foreach ($recievable_UserList->result() as $row) {
				$nestedData=array(); 
				
				if($row->transaction_id!=''){
                   $traansaction_id =  $row->transaction_id;
                }else{
                   $traansaction_id = "---";
                }

                $currencyPerUnitSeller = $row->currencyPerUnitSeller;
				if($row->currency_cron_id==0) { 
					$currencyCronId='';
				} else { 
					$currencyCronId=$row->currency_cron_id; 
				}
				if ($admin_currency_code != $row->user_currencycode) {												
				
					$amount_is = $admin_currency_symbol . ' '. currency_conversion($row->user_currencycode, $admin_currency_code, $row->sumtotal,$currencyCronId);
				}else{
					$amount_is = $admin_currency_symbol . ' ' . number_format($row->sumtotal,2);
				}

				if($row->is_coupon_used == 'Yes' ){
					$Coupon_amt = $row->total_amt - $row->discount;
					$currencyPerUnitSeller = $row->currencyPerUnitSeller;
				if($row->currency_cron_id==0) {
					$currencyCronId='';
				} else {
					$currencyCronId=$row->currency_cron_id; 
				}
					if ($admin_currency_code != $row->user_currencycode) {		
						$Coupon_amt_is =  $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $Coupon_amt,$currencyCronId);
					}else{
						$Coupon_amt_is = $admin_currency_symbol . ' ' . number_format($Coupon_amt,2);
					}
				}else{
					$Coupon_amt_is = $admin_currency_symbol . ' 0.00';
				}
				if($row->is_wallet_used == 'Yes' ){
					$currencyPerUnitSeller = $row->currencyPerUnitSeller;
					if($row->currency_cron_id==0) {
						$currencyCronId='';
					} else { 
						$currencyCronId=$row->currency_cron_id; 
					}
					if ($admin_currency_code != $row->user_currencycode) {
						$wallet_used_is = $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->wallet_Amount,$currencyCronId);
					} else{
							$wallet_used_is = $admin_currency_symbol . ' ' . number_format($row->wallet_Amount,2);
					}
				}else{
					$wallet_used_is = $admin_currency_symbol . ' 0.00';
				}

				if ($admin_currency_code != $row->user_currencycode) {											
					
					$guest_fee_data = $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->guest_fee,$currencyCronId);
				}else{
					$guest_fee_data = $admin_currency_symbol . ' ' . number_format($row->guest_fee,2);
				}

				if ($admin_currency_code != $row->user_currencycode) {												
					
					$host_fee_data = $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->host_fee,$currencyCronId);
				}else{
					$host_fee_data = $admin_currency_symbol . ' ' . number_format($row->host_fee,2);
				}

				$net_profit = round($row->guest_fee + $row->host_fee, 2);
				if ($admin_currency_code != $row->user_currencycode) {												
					
					$net_profit_data = $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $net_profit,$currencyCronId);
				}else{
					$net_profit_data = $admin_currency_symbol . ' ' . number_format($net_profit,2);
				}

				if ($admin_currency_code != $row->user_currencycode){
					$pay_amy_data = $admin_currency_symbol . ' ' . currency_conversion($row->user_currencycode, $admin_currency_code, $row->payable_amount,$currencyCronId);
				} else {
				$pay_amy_data = $admin_currency_symbol . ' ' . number_format($row->payable_amount,2);
				}

				$nestedData[] = $i;
				$nestedData[] = date('d-m-Y', strtotime($row->dateAdded));
				$nestedData[] = $traansaction_id;
				$nestedData[] = $row->booking_no;
				
				$nestedData[] = $row->host_email;
				$nestedData[] = $amount_is;
				$nestedData[] = $Coupon_amt_is;
				$nestedData[] = $wallet_used_is;
				$nestedData[] = $guest_fee_data;
				$nestedData[] = $host_fee_data;
				$nestedData[] = $net_profit_data;
				$nestedData[] = $pay_amy_data;
				$data[] = $nestedData;
				$i++;
			}
			// print_r( $data);exit;
			$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
			);

			echo json_encode($json_data);
			
            
			
		}

	}

    public function getReceivable(){
    $transaction_id=$this->input->post('trans_id');
        $this->data['showselectedDet'] = $this->bookingpayment_model->get_all_commission_tracking_selected($transaction_id);
        $this->load->view('admin/bookingpayment/display_receivable_selected', $this->data);
    }

	public function display_payable()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} else {

			$this->data['heading'] = 'Payable Payment';
			$this->data['newbookingList'] = $this->bookingpayment_model->view_newbooking_details();
			$condition = array('status' => 'Active', 'seo_tag' => 'host-listing');
			$service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
			$this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
			$condition = array('status' => 'Active', 'seo_tag' => 'guest-booking');
			$service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
			$this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
			$this->load->view('admin/bookingpayment/display_payable', $this->data);
		}
	}
	
	/*
	 *
	 *Function to export customer payment details
	 */
	public function customerExcelExportReceivable()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else
		{
			$this->data['heading'] = 'Receivable Payment';
			$this->data['newbookingList'] = $this->bookingpayment_model->view_newbooking_details('Booked');

			$condition = array('status' => 'Active', 'seo_tag' => 'host-listing');
			$service_tax_host = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
			$this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
			$condition = array('status' => 'Active', 'seo_tag' => 'guest-booking');
			$service_tax_guest = $this->product_model->get_all_details(COMMISSION, $condition);
			$this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
			$this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
			$this->data['commissionTracking'] = $this->bookingpayment_model->get_all_commission_tracking();

			$this->load->view('admin/bookingpayment/customerExcelExportReceivable', $this->data);
		}
	}

	public function customerExcelExportPayable()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Payable Payment';
			$this->data['newbookingList'] = $this->bookingpayment_model->view_newbooking_details('Booked');
			$service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE status="Active"';
			$this->data['service_tax'] = $this->product_model->ExecuteQuery($service_tax_query)->result_array();
			//echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
			$this->load->view('admin/bookingpayment/customerExcelExportPayable', $this->data);
		}
	}


	public function display_book_confirmed()
	{
		if ($this->checkLogin('A') == '') 
		{
			redirect('admin');
		} 
		else 
		{
			$this->data['heading'] = 'Confirm Booking List';
			$this->data['newbookingList'] = $this->account_model->view_newbooking_details('Booked');
			$this->load->view('admin/accounts/display_book_confirmed', $this->data);
		}
	}


	public function display_book_expired()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Expired Booking List';
			$this->data['newbookingList'] = $this->account_model->view_newbooking_detailsexp('Booked');
			//echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
			$this->load->view('admin/accounts/display_book_expired', $this->data);
		}
	}

	public function display_order_pending()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Order List';
			$this->data['orderList'] = $this->order_model->view_order_details('Pending');
			$this->load->view('admin/order/display_orders_pending', $this->data);
		}
	}

	public function customerExcelExportNewBooking()
	{
		$status = $this->uri->segment(4);
		$condition = array();
		$UserDetails = $this->account_model->view_newbooking_details(ucfirst($status));
		$data['getCustomerDetails'] = $UserDetails->result_array();
		if ($status == "booked") {
			$status = "Completed";
		}
		$data['title'] = ucfirst($this->config->item('email_title')) . " " . ucfirst($status);
		$data['status'] = ucfirst($status);
		$this->load->view('admin/accounts/customerExportExcelNewBooking', $data);
	}

	public function customerExcelExportExpired()
	{
		$status = "Expired booking";
		$condition = array();
		$UserDetails = $this->account_model->view_newbooking_detailsexp('Booked');
		$data['getCustomerDetails'] = $UserDetails->result_array();
		$data['title'] = ucfirst($this->config->item('email_title')) . " " . ucfirst($status);
		$data['status'] = $status;
		$this->load->view('admin/accounts/customerExportExcelexpired', $data);
	}


	public function hostpayable()
	{


		//VENDOR_PAYMENT
		$checkVendorBooking = $this->account_model->get_all_details(VENDOR_PAYMENT, array('bookingId' => $this->input->post('BookNo')));
		$checkBooking = $this->account_model->get_all_details(HOSTPAYMENT, array('bookingId' => $this->input->post('BookNo')));
		// echo '<pre>'; print_r($checkBooking->result_array());

		$excludeArr = array('bookingId', 'product_id', 'host_id', 'amount', 'txn_id', 'txt_date', 'txn_type', 'payment_status');
		$condition = array();
		$dataArr = array(
			'bookingId' => $this->input->post('BookNo'),
			'product_id' => $this->input->post('Prdid'),
			'host_id' => $this->input->post('hostid'),
			'amount' => $this->input->post('netamt'),
			'txn_id' => $this->input->post('transid'),
			'txt_date' => $this->input->post('transdate'),
			'txn_type' => $this->input->post(transtype),
			'payment_status' => 'Paid'
		);
		$vendorDataArr = array(
			'transaction_id' => $this->input->post('transid'),
			'date' => $this->input->post('transdate'),
			'payment_type' => $this->input->post(transtype),
			'amount' => $this->input->post('netamt'),
			'vendor_id' => $this->input->post('hostid'),
			'bookingId' => $this->input->post('BookNo'),
			'status' => 'success'
		);
		if ($checkVendorBooking->num_rows() == 0) {
			$this->account_model->simple_insert(VENDOR_PAYMENT, $vendorDataArr);
		} else {
			$this->account_model->update_details(VENDOR_PAYMENT, $vendorDataArr, array('bookingId' => $this->input->post('BookNo')));
		}
		if ($checkBooking->num_rows() == 0) {
			$this->account_model->simple_insert(HOSTPAYMENT, $dataArr);
			echo json_encode('Transaction has been completed');
		} else {
			$this->account_model->update_details(HOSTPAYMENT, $dataArr, array('bookingId' => $this->input->post('BookNo')));
			//echo $this->db->last_query();
			echo json_encode('Transaction has been updated');
		}

	}


}

/* End of file order.php */
/* Location: ./application/controllers/admin/bookingpayment.php */
