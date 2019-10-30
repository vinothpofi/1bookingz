<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Experience_bookingpayment extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model('experience_bookingpayment_model');
        if ($this->checkPrivileges('Accounts', $this->privStatus) == FALSE) {
            redirect('admin');
        }
    }

    /**
     *
     * This function loads the order list page
     */
    public function index()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            redirect('admin/experience_bookingpayment/display_receivable');
        }
    }

    /**
     *
     * This function loads receivable and payable payment list page
     */
    public function display_receivable()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Receivable and Payable Payment';
            $this->data['fromdate']=$fromdate=$this->input->post('fromdate');
            $this->data['todate']= $todate=$this->input->post('todate');
           
//echo $this->db->last_query();exit();
         //   $this->data['commission_paid_transactionID'] = $this->experience_bookingpayment_model->get_all_details(EXP_COMMISSION_PAID,array());
            $this->load->view('admin/experience_bookingpayment/display_receivable', $this->data);
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
             if ($uid != '') {
                $this->db->select('c.*,re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,u.email,c.booking_no,cp.transaction_id');
        $this->db->from(EXPERIENCE_ENQUIRY . ' as re');
        $this->db->join(USERS . ' as u', 're.renter_id = u.id');
        $this->db->join(EXP_COMMISSION_TRACKING . ' as c', 're.Bookingno=c.booking_no');
        $this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as py', 'py.EnquiryId = re.id');
        $this->db->join(EXP_COMMISSION_PAID . ' as cp', 'cp.id=c.commission_paid_id'," LEFT");
        $this->db->where('py.status = "Paid"');
        $this->db->where('py.sell_id =', $uid);
        $this->db->order_by("re.dateAdded", "desc");
        $UserList = $this->db->get();
                
                
            } else {
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
//      echo $Query ;exit();

        $UserList = $this->db->query($Query);
         }

         $totalData = $UserList->num_rows();
            $totalFiltered = $totalData;

        if( !empty($requestData['search']['value']) ) {   
                $condition.=" AND ( transaction_id LIKE '".$requestData['search']['value']."%' ";    
                $condition.=" OR booking_no LIKE '".$requestData['search']['value']."%' ";
                $condition.=" OR host_email LIKE '".$requestData['search']['value']."%' )";
            }

          if ($uid != '') {
                $this->db->select('c.*,re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,u.email,c.booking_no,cp.transaction_id');
        $this->db->from(EXPERIENCE_ENQUIRY . ' as re');
        $this->db->join(USERS . ' as u', 're.renter_id = u.id');
        $this->db->join(EXP_COMMISSION_TRACKING . ' as c', 're.Bookingno=c.booking_no');
        $this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as py', 'py.EnquiryId = re.id');
        $this->db->join(EXP_COMMISSION_PAID . ' as cp', 'cp.id=c.commission_paid_id'," LEFT");
        $this->db->where('py.status = "Paid"');
        $this->db->where('py.sell_id =', $uid);
        $this->db->where($condition);
        $this->db->order_by("re.dateAdded", "desc");
        $UserList = $this->db->get();
                
                
            } else {
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
//      echo $Query ;exit();

        $UserList = $this->db->query($Query);
         }

         $UserList = $recievable_UserList->num_rows();
         $order_is =" ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']."  ";
            $limit_is = "".$requestData['start']." ,".$requestData['length']."   ";
          if ($uid != '') {
                $this->db->select('c.*,re.prd_id,re.currencyPerUnitSeller,re.currencycode,re.user_currencycode,re.currency_cron_id,re.checkin,u.email,c.booking_no,cp.transaction_id');
        $this->db->from(EXPERIENCE_ENQUIRY . ' as re');
        $this->db->join(USERS . ' as u', 're.renter_id = u.id');
        $this->db->join(EXP_COMMISSION_TRACKING . ' as c', 're.Bookingno=c.booking_no');
        $this->db->join(EXPERIENCE_BOOKING_PAYMENT . ' as py', 'py.EnquiryId = re.id');
        $this->db->join(EXP_COMMISSION_PAID . ' as cp', 'cp.id=c.commission_paid_id'," LEFT");
        $this->db->where('py.status = "Paid"');
        $this->db->where('py.sell_id =', $uid);
        $this->db->where($condition);
        $this->db->order_by($order_is);
        $this->db->limit($limit_is);
        $this->db->order_by("re.dateAdded", "desc");
        $UserList = $this->db->get();
                
                
            } else {
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
//      echo $Query ;exit();
        $Query.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $UserList = $this->db->query($Query);
         }

print_r($UserList->result());exit;
         $data = array(); 
            $i=1;
            foreach ($UserList->result() as $row) {
                $nestedData=array(); 
                
                if($row->transaction_id!=''){
                   $traansaction_id =  $row->transaction_id;
                }else{
                   $traansaction_id = "---";
                }

                // $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                // if($row->currency_cron_id==0) { 
                //     $currencyCronId='';
                // } else { 
                //     $currencyCronId=$row->currency_cron_id; 
                // }
                // if ($admin_currency_code != $row->user_currencycode) {                                              
                
                //     $amount_is = $admin_currency_symbol . ' '. currency_conversion($row->user_currencycode, $admin_currency_code, $row->sumtotal,$currencyCronId);
                // }else{
                //     $amount_is = $admin_currency_symbol . ' ' . number_format($row->sumtotal,2);
                // }

                $currencyPerUnitSeller = $row->currencyPerUnitSeller;
                 if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id; }
                 if ($admin_currency_code != $row->user_currencycode) 
                 {                                               
                ;// . customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
                 $amount_is =  $admin_currency_symbol . ' '. currency_conversion($row->user_currencycode, $admin_currency_code, $row->total_amount,$currencyCronId);
                 }  else 
                 {
                 $amount_is = $admin_currency_symbol . ' ' . number_format($row->total_amount,2);
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

public function getReceivable_exp(){
    $transaction_id=$this->input->post('trans_id');
    $this->data['showselectedDet'] = $this->experience_bookingpayment_model->get_all_commission_tracking_selected($transaction_id);
   $this->load->view('admin/Experience_bookingpayment/experience_display_receivable_selected', $this->data);
}


    public function display_payable()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Payable Payment';
            $this->data['newbookingList'] = $this->experience_bookingpayment_model->view_newbooking_details();
            $condition = array('status' => 'Active', 'seo_tag' => 'experience_listing');
            $service_tax_host = $this->experience_bookingpayment_model->get_all_details(COMMISSION, $condition);
            $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
            $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
            $condition = array('status' => 'Active', 'seo_tag' => 'experience_booking');
            $service_tax_guest = $this->experience_bookingpayment_model->get_all_details(COMMISSION, $condition);
            $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
            $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
            $this->load->view('admin/bookingpayment/display_payable', $this->data);
        }
    }

    /**
     *
     * This function to export experience account details
     */
    public function customerExcelExportReceivable()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Receivable Payment';
            $this->data['newbookingList'] = $this->experience_bookingpayment_model->view_newbooking_details('Booked');
            $condition = array('status' => 'Active', 'seo_tag' => 'experience_listing');
            $service_tax_host = $this->experience_bookingpayment_model->get_all_details(COMMISSION, $condition);
            $this->data['host_tax_type'] = $service_tax_host->row()->promotion_type;
            $this->data['host_tax_value'] = $service_tax_host->row()->commission_percentage;
            $condition = array('status' => 'Active', 'seo_tag' => 'experience_booking');
            $service_tax_guest = $this->experience_bookingpayment_model->get_all_details(COMMISSION, $condition);
            $this->data['guest_tax_type'] = $service_tax_guest->row()->promotion_type;
            $this->data['guest_tax_value'] = $service_tax_guest->row()->commission_percentage;
            $this->data['commissionTracking'] = $this->experience_bookingpayment_model->get_all_commission_tracking();
            $this->load->view('admin/experience_bookingpayment/customerExcelExportReceivable', $this->data);
        }
    }

    public function customerExcelExportPayable()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Payable Payment';
            $this->data['newbookingList'] = $this->experience_bookingpayment_model->view_newbooking_details('Booked');
            $service_tax_query = 'SELECT * FROM ' . COMMISSION . ' WHERE status="Active"';
            $this->data['service_tax'] = $this->experience_bookingpayment_model->ExecuteQuery($service_tax_query)->result_array();
            //echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
            $this->load->view('admin/bookingpayment/customerExcelExportPayable', $this->data);
        }
    }


    public function display_book_confirmed()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Confirm Booking List';
            $this->data['newbookingList'] = $this->experience_bookingpayment_model->view_newbooking_details('Booked');
            //echo '<pre>'; print_r($this->data['newbookingList']->result_array()); die;
            $this->load->view('admin/accounts/display_book_confirmed', $this->data);
        }
    }


    public function display_book_expired()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Expired Booking List';
            $this->data['newbookingList'] = $this->experience_bookingpayment_model->view_newbooking_detailsexp('Booked');
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
            $this->data['orderList'] = $this->experience_bookingpayment_model->view_order_details('Pending');
            $this->load->view('admin/order/display_orders_pending', $this->data);
        }
    }

    public function customerExcelExportNewBooking()
    {
        $status = $this->uri->segment(4);
        $condition = array();
        $UserDetails = $this->experience_bookingpayment_model->view_newbooking_details(ucfirst($status));
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
        $UserDetails = $this->experience_bookingpayment_model->view_newbooking_detailsexp('Booked');
        $data['getCustomerDetails'] = $UserDetails->result_array();
        $data['title'] = ucfirst($this->config->item('email_title')) . " " . ucfirst($status);
        $data['status'] = $status;
        $this->load->view('admin/accounts/customerExportExcelexpired', $data);
    }


    public function hostpayable()
    {
        //VENDOR_PAYMENT
        $checkVendorBooking = $this->experience_bookingpayment_model->get_all_details(VENDOR_PAYMENT, array('bookingId' => $this->input->post('BookNo')));
        $checkBooking = $this->experience_bookingpayment_model->get_all_details(HOSTPAYMENT, array('bookingId' => $this->input->post('BookNo')));
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
            $this->experience_bookingpayment_model->simple_insert(VENDOR_PAYMENT, $vendorDataArr);
        } else {
            $this->experience_bookingpayment_model->update_details(VENDOR_PAYMENT, $vendorDataArr, array('bookingId' => $this->input->post('BookNo')));
        }
        if ($checkBooking->num_rows() == 0) {
            $this->experience_bookingpayment_model->simple_insert(HOSTPAYMENT, $dataArr);
            echo json_encode('Transaction has been completed');
        } else {
            $this->experience_bookingpayment_model->update_details(HOSTPAYMENT, $dataArr, array('bookingId' => $this->input->post('BookNo')));
            //echo $this->db->last_query();
            echo json_encode('Transaction has been updated');
        }
    }


}

/* End of file order.php */
/* Location: ./application/controllers/admin/bookingpayment.php */