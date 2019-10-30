<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to Cart Page
 * @author Teamtweaks
 *
 */
class Account_model extends My_Model
{

    public function view_newbooking_details()
    {
        $today = date('Y-m-d');
        $this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', 'rq.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
        $this->db->where('DATE(rq.checkin)>=', $today); /* malar- new booking checkin must be from today */
        $this->db->where("(rq.booking_status!='Booked')"); /*malar-booked-property not booked*/
        $this->db->order_by("rq.dateAdded", "desc");
        $PrdList = $this->db->get();
        return $PrdList;
    }

    public function view_newbooking_details_confirmed()
    {
        $today = date('Y-m-d');
        $this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,Py.status as status,Py.dval,Py.total_amt,Py.is_coupon_used,Py.discount,Py.currency_code,cu.currency_symbols,Py.is_wallet_used,Py.wallet_Amount');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', 'rq.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
        $this->db->join(PAYMENT . ' as Py', 'Py.EnquiryId = rq.id');
        $this->db->join(CURRENCY . ' as cu', 'cu.currency_type = rq.currencycode');
        $this->db->where('Py.status = "Paid"');
        $this->db->where(array('rq.booking_status'=> "Booked",'rq.cancelled'=> "No")); //malar-booked-property is booked(payment done)
        $this->db->where('DATE(rq.checkin)>=', $today); /* malar- new booking checkin must be from today - upcoming confirm booking */
        $this->db->order_by("rq.dateAdded", "desc");
        $PrdList = $this->db->get();
        return $PrdList;
    }
     public function view_newbooking_details_cancelled()
    {
        $today = date('Y-m-d');
        $this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID,Py.status as status,Py.dval,Py.total_amt,Py.is_coupon_used,Py.discount,Py.currency_code,cu.currency_symbols');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', 'rq.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
        $this->db->join(PAYMENT . ' as Py', 'Py.EnquiryId = rq.id');
        $this->db->join(CURRENCY . ' as cu', 'cu.currency_type = rq.currencycode');
        $this->db->where('Py.status = "Paid"');
        $this->db->where('rq.cancelled', "Yes"); //malar-booked-property is booked(payment done)
       // $this->db->where('DATE(rq.checkin)>=', $today); /* malar- new booking checkin must be from today - upcoming confirm booking */
        $this->db->order_by("rq.dateAdded", "desc");
        $PrdList = $this->db->get();
        return $PrdList;
    }

    public function view_newbooking_detailsexp($status)
    {
        $today = date('Y-m-d');
        $this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', 'rq.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
        $this->db->where('rq.approval = "' . $status . '"');
        $this->db->where('DATE(rq.checkout)<', $today);
        $PrdList = $this->db->get();
        return $PrdList;
    }

    public function view_newbooking_detailsexp_nw()
    {
        $today = date('Y-m-d');
        $this->db->select('rq.*,u.email,u.firstname,u.address,rq.caltophone,rq.phone_no,u.postal_code,u.state,u.country,u.city,pd.product_name,pd.id as PrdID');
        $this->db->from(RENTALENQUIRY . ' as rq');
        $this->db->join(USERS . ' as u', 'rq.user_id = u.id');
        $this->db->join(PRODUCT . ' as pd', 'pd.id = rq.prd_id');
        $this->db->where('DATE(rq.checkout)<', $today);
        $PrdList = $this->db->get();
        return $PrdList;
    }

}

?>
