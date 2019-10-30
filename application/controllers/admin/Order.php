<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Order extends MY_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('cookie', 'date', 'form'));
		$this->load->helper('currency_helper');
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('order_model');
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
			redirect('admin/order/display_order_list');
		}
	}

	/**
	 *
	 * This function loads the order list page
	 */
	public function display_order_paid()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Successful payment list';
			$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
			if ($rep_code != '') {
				$condition = ' and h.rep_code="' . $rep_code . '"';
			} else {
				$condition = '';
			}
			$this->data['orderList'] = $this->order_model->view_order_details('Paid', $condition, $rep_code);
			$this->load->view('admin/order/display_orders', $this->data);
		}
	}

	/**
	 *
	 * This function loads the Failed payment list page
	 */
	public function display_order_pending()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Failed payment list';
			$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
			if ($rep_code != '') {
				$condition = ' and h.rep_code="' . $rep_code . '"';
			} else {
				$condition = '';
			}
			$this->data['orderList'] = $this->order_model->view_order_details('Pending', $condition, $rep_code);
			//echo $this->db->last_query(); exit;
			$this->load->view('admin/order/display_orders_pending', $this->data);
		}
	}

	public function display_cod()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Order List';
			$this->data['orderList'] = $this->order_model->view_order_cod('Pending');
			$this->load->view('admin/order/display_cod', $this->data);
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
			} else {
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
					$this->data ['seller_details'] = $this->order_model->get_all_details(USERS, array(
						'id' => $sid
					));
				} elseif ($view_mode == 'seller') {
					$this->data ['user_details'] = $this->order_model->get_all_details(USERS, array(
						'id' => $uid
					));
					$this->data ['seller_details'] = $this->data ['userDetails'];
				}
				foreach ($order_details->result() as $order_details_row) {
					$this->data ['prod_details'] [$order_details_row->product_id] = $this->order_model->get_all_details(PRODUCT, array(
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
				$this->data ['order_comments'] = $this->order_model->get_all_details(REVIEW_COMMENTS, array(
					'deal_code' => $dealCode
				), $sortArr);
				$this->load->view('admin/order/display_order_reviews', $this->data);
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
			$this->data['ViewList'] = $this->order_model->view_orders($user_id, $deal_id);
			$this->load->view('admin/order/view_orders', $this->data);
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
			$old_order_details = $this->order_model->get_all_details(PRODUCT, array('id' => $order_id));
			$this->update_old_list_values($order_id, array(), $old_order_details);
			$this->update_user_order_count($old_order_details);
			$this->order_model->commonDelete(PRODUCT, $condition);
			$this->setErrorMessage('success', 'Order deleted successfully');
			redirect('admin/order/display_order_list');
		}
	}

	/**
	 *
	 * This function shows order details and comments
	 */
	public function order_review()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$dealCode = $this->uri->segment(4, 0);
			$this->db->select('p.*,pAr.attr_name,pr.product_title,rq.prd_price,pr.price,pr.currency,rq.Bookingno,rq.secDeposit,rq.checkin,rq.NoofGuest,rq.subTotal,rq.serviceFee,rq.checkout,rq.numofdates,rq.currencyPerUnitSeller,pi.product_image,rq.currency_cron_id,rq.user_currencycode,rq.dateAdded');
			$this->db->from(PAYMENT . ' as p');
			$this->db->join(PRODUCT_ATTRIBUTE . ' as pAr', 'pAr.id = p.attribute_values', 'left');
			$this->db->join(RENTALENQUIRY . ' as rq', 'rq.id = p.EnquiryId', 'left');
			$this->db->join(PRODUCT . ' as pr', 'pr.id = p.product_id', 'left');
			$this->db->join(PRODUCT_PHOTOS . ' as pi', 'pi.product_id = p.product_id', 'left');
			$this->db->where('p.status = "Paid" and p.dealCodeNumber = "' . $dealCode . '"');
			$this->db->group_by("p.product_id");
			$order_details = $this->db->get();
			if ($order_details->num_rows() == 0) {
				show_404();
			} else {
				foreach ($order_details->result() as $order_details_row) {
					$this->data['prod_details'][$order_details_row->product_id] = $this->order_model->get_all_details(PRODUCT, array('id' => $order_details_row->product_id));
				}
				$this->data['order_details'] = $order_details;
				$this->data['heading'] = 'View Order Comments';
				$sortArr1 = array('field' => 'date', 'type' => 'desc');
				$sortArr = array($sortArr1);
				$this->data['order_comments'] = $this->order_model->get_all_details(REVIEW_COMMENTS, array('deal_code' => $dealCode), $sortArr);
				$this->data['sesson_price'] = $this->order_model->get_all_details(SCHEDULE, array('id' => $order_details_row->product_id));
				
				$checkin_date = explode(' ', $order_details->row()->checkin);
				$checkin_date_is = $checkin_date['0'];
				$data = json_decode($this->data['sesson_price']->row()->data, true);
				
				foreach ($data as $key => $entry) {
            	if ($key == $checkin_date_is && $key <= $checkin_date_is) {
                if($entry['status'] == 'available')
				{
					$this->data['sesson_price_is'] = $entry['price'];
				}
                
            	}
		}
		
				$this->load->view('admin/order/display_order_reviews', $this->data);
			}
		}
	}

	/**
	 *
	 * This function upload review comments
	 */
	public function post_order_comment()
	{
		if ($this->checkLogin('A') != '') {
			$product_id = $this->input->post('product_id');
			$comment_from = $this->input->post('comment_from');
			$commentor_id = $this->input->post('commentor_id');
			$deal_code = $this->input->post('deal_code');
			$comment = $this->input->post('comment');
			$data = array('date' => date("Y-m-d H:i:s"),'product_id' => $product_id,'comment_from' => $comment_from,'commentor_id' => $commentor_id,'deal_code' => $deal_code,'comment' => $comment);
			$this->order_model->simple_insert(REVIEW_COMMENTS,$data);
		}
	}

	/**
	 *
	 * Function to export paid and failed
	 * order details
	 */
	public function customerExcelExport()
	{
		$status = $this->uri->segment(4);
		$sortArr = array('field' => 'id', 'type' => 'desc');
		$condition = array();
		$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
		if ($rep_code != '') {
			$condition = ' and h.rep_code="' . $rep_code . '"';
		} else {
			$condition = '';
		}
		$UserDetails = $this->order_model->view_order_detailsexcel($status, $condition, $rep_code);
		$data['getCustomerDetails'] = $UserDetails->result_array();
		//print_r($data['getCustomerDetails']); 
		
		//exit;
		$data['status'] = ($status == "Pending") ? 'Failed' : $status;
		$data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
		$data['admin_currency_code'] = $this->data['admin_currency_code'];
		$this->load->view('admin/order/customerExportExcel', $data);
	}

	/**
	 *
	 * Function to export finance listing list
	 */
	public function customerExcelExportlist()
	{
		$sortArr = array('field' => 'id', 'type' => 'desc');
		$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
		if ($rep_code != '') {
			$condition = ' and u.rep_code="' . $rep_code . '"';
		} else {
			$condition = '';
		}
		$UserDetails = $this->order_model->view_host_detailsexcel($condition);
		$data['getCustomerDetails'] = $UserDetails->result_array();
		$data['admin_currency_symbol'] = $this->data['admin_currency_symbol'];
		$data['admin_currency_code'] = $this->data['admin_currency_code'];
		$this->load->view('admin/order/hostExportExcel', $data);
	}

	/* Confirm booking in COD */
	public function displayconfirm_booking()
	{
		$id = $this->uri->segment(4);
		$excludeArr = array();
		$condition = array('id' => $id);
		$dataArr = array('status' => 'Paid');
		$this->order_model->commonInsertUpdate(PAYMENT, 'update', $excludeArr, $dataArr, $condition);
		redirect('admin/order/display_cod');
	}

	/**
	 *
	 *function to display listing payment orders
	 */
	public function display_listing_order()
	{
		if ($this->checkLogin('A') == '') {
			redirect('admin');
		} else {
			$this->data['heading'] = 'Rental Listing Payment';
			$rep_code = ltrim($this->session->userdata('fc_session_admin_rep_code'), '0');
			if ($rep_code != '') {
				$condition = ' and u.rep_code="' . $rep_code . '"';
			} else {
				$condition = '';
			}
			$this->data['listingorderList'] = $this->order_model->view_listingorder_details('Paid', $condition);
			$this->load->view('admin/order/display_listing_orders', $this->data);
		}
	}
}

/* End of file order.php */
/* Location: ./application/controllers/admin/order.php */
