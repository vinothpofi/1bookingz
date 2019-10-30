<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Experience_order extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model('experience_order_model');
        if ($this->checkPrivileges('Finance', $this->privStatus) == FALSE) {
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
            redirect('admin/experience_order/display_order_list');
        }
    }

    /**
     *
     * This function loads the paid payment list page
     */
    public function display_order_paid()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Successful payment list';
            $this->data['orderList'] = $this->experience_order_model->view_order_details('Paid');
            $this->load->view('admin/experience_order/display_orders', $this->data);
        }
    }

    /**
     *
     * This function loads failed payment list page
     */
    public function display_order_pending()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Failed payment list';
            $this->data['orderList'] = $this->experience_order_model->view_order_details('Pending');
            $this->load->view('admin/experience_order/display_orders_pending', $this->data);
        }
    }

    public function display_cod()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Order List';
            $this->data['orderList'] = $this->experience_order_model->view_order_cod('Pending');
            $this->load->view('admin/experience_order/display_cod', $this->data);
        }
    }

    public function display_order_reviews()
    {
        $uid = $this->uri->segment(2, 0);
        $sid = $this->uri->segment(3, 0);
        $dealCode = $this->uri->segment(4, 0);
        if ($uid == $this->checkLogin('U')) {
            $view_mode = 'user';
        } else if ($sid == $this->checkLogin('U')) {
            $view_mode = 'seller';
        } else {
            $view_mode = '';
        }
        if ($view_mode != '') {
            show_404();
        } else {
            if ($view_mode == 'seller') {
                $this->db->select('p.*,pAr.attr_name');
                $this->db->from(PAYMENT . ' as p');
                $this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
                $this->db->where('p.sell_id = "' . $sid . '" and p.status = "Paid" and p.dealCodeNumber = "' . $dealCode . '"');
                $order_details = $this->db->get();
                // $order_details = $this->user_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$dealCode,'status'=>'Paid','sell_id'=>$sid));
            } else {
                // $order_details = $this->user_model->get_all_details(PAYMENT,array('dealCodeNumber'=>$dealCode,'status'=>'Paid'));
                $this->db->select('p.*,pAr.attr_name');
                $this->db->from(PAYMENT . ' as p');
                $this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
                $this->db->where("p.status = 'Paid' and p.dealCodeNumber = '" . $dealCode . "'");
                $order_details = $this->db->get();
            }
            if ($order_details->num_rows() == 0) {
                show_404();
            } else {
                if ($view_mode == 'user') {
                    $this->data ['user_details'] = $this->data ['userDetails'];
                    $this->data ['seller_details'] = $this->experience_order_model->get_all_details(USERS, array(
                        'id' => $sid
                    ));
                } elseif ($view_mode == 'seller') {
                    $this->data ['user_details'] = $this->experience_order_model->get_all_details(USERS, array(
                        'id' => $uid
                    ));
                    $this->data ['seller_details'] = $this->data ['userDetails'];
                }
                foreach ($order_details->result() as $order_details_row) {
                    $this->data ['prod_details'] [$order_details_row->product_id] = $this->experience_order_model->get_all_details(PRODUCT, array(
                        'id' => $order_details_row->product_id
                    ));
                }
                $this->data ['view_mode'] = $view_mode;
                $this->data ['order_details'] = $order_details;
                $sortArr1 = array(
                    'field' => 'date',
                    'type' => 'desc'
                );
                $sortArr = array(
                    $sortArr1
                );
                $this->data ['order_comments'] = $this->experience_order_model->get_all_details(REVIEW_COMMENTS, array(
                    'deal_code' => $dealCode
                ), $sortArr);
                $this->load->view('admin/experience_order/display_order_reviews', $this->data);
            }
        }
    }

    public function subviewDetails()
    {
        echo $this->input->post('dealId');
    }


    /**
     *
     * This function loads the order view page
     */
    public function view_order()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'View Order';
            $user_id = $this->uri->segment(4, 0);
            $deal_id = $this->uri->segment(5, 0);
            $this->data['ViewList'] = $this->experience_order_model->view_orders($user_id, $deal_id);
            $this->load->view('admin/experience_order/view_orders', $this->data);
        }
    }

    /**
     *
     * This function delete the order record from db
     */
    public function delete_order()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $order_id = $this->uri->segment(4, 0);
            $condition = array('id' => $order_id);
            $old_order_details = $this->experience_order_model->get_all_details(PRODUCT, array('id' => $order_id));
            $this->update_old_list_values($order_id, array(), $old_order_details);
            $this->update_user_order_count($old_order_details);
            $this->experience_order_model->commonDelete(PRODUCT, $condition);
            $this->setErrorMessage('success', 'Order deleted successfully');
            redirect('admin/experience_order/display_order_list');
        }
    }

    /**
     *
     * Function to load experience order details and comments
     */
    public function order_review()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $dealCode = $this->uri->segment(4, 0);
			
            $this->db->select('p.*,pr.experience_title as product_title,pr.currency,rq.Bookingno,rq.checkin,rq.NoofGuest,rq.subTotal,rq.serviceFee,rq.secDeposit,rq.checkout,rq.numofdates,rq.currencyPerUnitSeller,rq.currencycode,pi.product_image,rq.currency_cron_id,rq.user_currencycode');
            $this->db->from(EXPERIENCE_BOOKING_PAYMENT . ' as p');
            $this->db->join(EXPERIENCE_ENQUIRY . ' as rq', 'rq.id = p.EnquiryId', 'left');
            $this->db->join(EXPERIENCE . ' as pr', 'pr.experience_id = p.product_id', 'left');
            $this->db->join(EXPERIENCE_PHOTOS . ' as pi', 'pi.product_id = p.product_id', 'left');
            $this->db->where('p.status = "Paid" and p.dealCodeNumber = "' . $dealCode . '" group by p.product_id');
            $order_details = $this->db->get();
            if ($order_details->num_rows() == 0) {
                show_404();
            } else {
                foreach ($order_details->result() as $order_details_row) {
                    $this->data['prod_details'][$order_details_row->product_id] = $this->experience_order_model->get_all_details(EXPERIENCE, array('experience_id' => $order_details_row->product_id));
                }
                $this->data['order_details'] = $order_details;
                $this->data['heading'] = 'View Order Comments';
                $sortArr1 = array('field' => 'date', 'type' => 'desc');
                $sortArr = array($sortArr1);
                $this->data['order_comments'] = $this->experience_order_model->get_all_details(EXPERIENCE_REVIEW_COMMENTS, array('deal_code' => $dealCode), $sortArr);
                $this->load->view('admin/experience_order/display_order_reviews', $this->data);
            }
        }
    }

    /**
     *
     * Function to post experience comments
     */
    public function post_order_comment()
    {
        if ($this->checkLogin('A') != '') {
            $this->experience_order_model->commonInsertUpdate(EXPERIENCE_REVIEW_COMMENTS, 'insert', array(), array(), '');
        }
    }

    /**
     *
     * Function to export paid and failed financial list details
     */
    public function customerExcelExport()
    {
        $status = $this->uri->segment(4);
        $sortArr = array('field' => 'id', 'type' => 'desc');
        $condition = array();
        $UserDetails = $this->experience_order_model->view_order_detailsexcel($status);
        $data['getCustomerDetails'] = $UserDetails->result_array();
        $data['status'] = ($status == "Pending") ? 'Failed' : $status;
        $data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
        $data['admin_currency_code'] = $this->data['admin_currency_code'];
        $this->load->view('admin/experience_order/customerExportExcel', $data);
    }

    /**
     *
     * Function to export finance listing list details
     */
    public function customerExcelExportlist()
    {
        $UserDetails = $this->experience_order_model->view_host_detailsexcel();
        $data['getCustomerDetails'] = $UserDetails->result_array();
        $data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
        $data['admin_currency_code'] = $this->data['admin_currency_code'];
        $this->load->view('admin/experience_order/hostExportExcel', $data);
    }


    /* Confirm booking in COD */
    public function displayconfirm_booking()
    {
        $id = $this->uri->segment(4);
        $excludeArr = array();
        $condition = array('id' => $id);
        $dataArr = array('status' => 'Paid');
        $this->experience_order_model->commonInsertUpdate(PAYMENT, 'update', $excludeArr, $dataArr, $condition);
        redirect('admin/experience_order/display_cod');
    }


    /**
     *
     * Function to load listing payments page
     */
    public function display_listing_order()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            $this->data['heading'] = 'Listing Payment';
            $this->data['listingorderList'] = $this->experience_order_model->view_listingorder_details('Paid');
            $this->load->view('admin/experience_order/display_listing_orders', $this->data);
        }
    }


}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */