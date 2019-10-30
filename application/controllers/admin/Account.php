<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Account extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model('account_model');
        $this->load->model('order_model');
        if ($this->checkPrivileges('BookingStatus', $this->privStatus) == FALSE) {
            redirect('admin');
        }
    }

    /**
     *
     * This function loads the booking list page
     */
    public function index()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            redirect('admin/accounts/display_newbooking');
        }
    }

    /**
     *
     * This function loads the booking list page
     */
    public function display_newbooking()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'New Booking List';
            $this->data['newbookingList'] = $this->account_model->view_newbooking_details();
            $this->load->view('admin/accounts/display_newbooking', $this->data);
        }
    }

    /**
     *
     * This function loads the completed booking list page
     */
    public function display_book_confirmed()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Completed Booking List';
            $this->data['newbookingList'] = $this->account_model->view_newbooking_details_confirmed();
            $this->load->view('admin/accounts/display_book_confirmed', $this->data);
        }
    }
     public function display_book_concelled()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Canceled Booking List';
            $this->data['newbookingList'] = $this->account_model->view_newbooking_details_cancelled();
            $this->load->view('admin/accounts/display_book_canceled', $this->data);
        }
    }

    /**
     *
     * This function loads the expired booking list page
     */
    public function display_book_expired()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Expired Booking List';
            $this->data['newbookingList'] = $this->account_model->view_newbooking_detailsexp_nw();
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

    /**
     *
     * This function to export new and completed booking details
     */
    public function customerExcelExportNewBooking()
    {
        $status = $this->uri->segment(4);
        $condition = array();
        if ($status == 'enquiry')
            $UserDetails = $this->account_model->view_newbooking_details();
        elseif ($status == 'booked')
            $UserDetails = $this->account_model->view_newbooking_details_confirmed();
        elseif ($status == 'expiry')
            $UserDetails = $this->account_model->view_newbooking_detailsexp_nw();
        $data['getCustomerDetails'] = $UserDetails->result_array();
        if ($status == "booked") {
            $status = "Completed";
        }
        $data['title'] = ucfirst($status) . "_booking_";
        $data['status'] = ucfirst($status);
        $data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
        $data['admin_currency_code'] = $this->data['admin_currency_code'];
        $this->load->view('admin/accounts/customerExportExcelNewBooking', $data);
    }

    /**
     *
     * This function to export expired booking details
     */
    public function customerExcelExportExpired()
    {
        $status = "Expired_booking";
        $condition = array();
        $UserDetails = $this->account_model->view_newbooking_detailsexp_nw();
        $data['getCustomerDetails'] = $UserDetails->result_array();
        $data['title'] = ucfirst($status);
        $data['status'] = $status;
        $data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
        $data['admin_currency_code'] = $this->data['admin_currency_code'];
        $this->load->view('admin/accounts/customerExportExcelexpired', $data);
    }
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */