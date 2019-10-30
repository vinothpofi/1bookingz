<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * Landing page functions
 * @author Teamtweaks
 *
 */
class Landing_model extends My_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function facebook_login_check($fb_id, $data)
    {

        if ($fb_id != '') {
            $data1 = $this->db->select('fc_users')->where('f_id', $fb_id)->get();

            if ($data) {

                $this->session->set_userdata('email', $data[0]->email);
                $this->session->set_userdata('id', $data[0]->id);
                $this->session->set_userdata('f_id', $data[0]->f_id);
                return "success";
            }

        } else {
            return "error";
        }
    }

    function get_city_details($q)
    {
        $this->db->select('c.name,states_list.name as State,country_list.country_code,country_list.name as country_name');
        $this->db->from(CITY . ' as c');
        $this->db->join(STATE_TAX . ' as states_list', "states_list.id=c.stateid", "LEFT");
        $this->db->join(COUNTRY_LIST . ' as country_list', "country_list.id=states_list.countryid", "LEFT");
        $this->db->where('country_list.status', 'Active');
        $this->db->like('states_list.name', $q);
        $this->db->or_like('c.name', $q);

        $this->db->limit(30);
        $this->db->order_by('c.name', asc);
        $this->db->order_by('states_list.name', asc);

        $query = $this->db->get();
        $autocomplete = $query->result_array();
        return $autocomplete;
    }

    public function get_featured_lists()
    {
        $this->db->select("P.id,P.room_type,P.product_title, P.price,P.instantbook,P.description, P.accommodates, PP.product_image, PA.city, PA.state, PA.country,u.image,u.id as property_owner,(select IFNULL(count(R.id),0) from " . REVIEW . " as R where R.product_id= P.id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . REVIEW . " as Rw where Rw.product_id= P.id and Rw.status='Active') as avg_val", false);

        $this->db->from(PRODUCT . ' as P');
        $this->db->join(PRODUCT_PHOTOS . ' as PP', 'P.id = PP.product_id');
        $this->db->join(PRODUCT_ADDRESS_NEW . ' as PA', 'P.id = PA.productId');
        $this->db->join(USERS . ' as u', "u.id=P.user_id", "LEFT");
        $this->db->where('P.status', 'Publish');
        $this->db->where('P.featured = "Featured"');
        $this->db->order_by("P.created", desc);
        $this->db->group_by("P.id");
        return $result = $this->db->get();
    }

    public function get_prefooter()
    {
        $this->db->select('*');
        $this->db->from(PREFOOTER);
        $this->db->where('status','Active');
        $result = $this->db->get();
        return $result->result();
    }
    public function adv_result_result()
    {
        $this->db->select('*');
        $this->db->from(ADVERTISMENT);
        $this->db->where('status','Active');
        $result = $this->db->get();
        return $result->result();
    }

    public function facebook($data, $fb_id)
    {
        $email = $data['email'];
        $type = 'facebook';
        $this->db->where('f_id', $fb_id);
        $query = $this->db->get('fc_users');


        if ($query->num_rows() > 0) {
            $user_id = $query->row()->id;
            $this->session->set_userdata('session_user_email', $email);
            $this->session->set_userdata('fc_session_user_id', $user_id);
            $this->session->set_userdata('f_id', $fb_id);
            $this->session->set_userdata('facebook_in_login', $type);
            $condition = array('f_id' => $fb_id);
            $dataArr = array('f_id' => $fb_id, 'status' => 'Active', 'expired_date' => $expireddate, 'is_verified' => 'Yes', 'facebook' => 'Yes');
            $this->user_model->update_details(USERS, $dataArr, $condition);

            return true;
        } else {
             $deactivateMail = $this->db->query("SELECT * FROM `fc_users` WHERE `email` like '" . $email . "' AND status='Inactive' ORDER BY `id` DESC");
               

                    if ($deactivateMail->num_rows() > 0) {

                    return cancelled;
                 }
            $this->db->insert('fc_users', $data);
            $insert_id =  $this->db->insert_id();
            $data['id'] = $insert_id;
            $qry = $this->db->get_where('fc_users',$data);
            
            if ($qry->num_rows() > 0) {
                $this->session->set_userdata('session_user_email', $email);
                $this->session->set_userdata('fc_session_user_id', $table1_id = $insert_id);
                $this->session->set_userdata('f_id', $fb_id);
                $this->session->set_userdata('facebook_in_login', $type);
                return false;
            }
        }
    }

    public function get_social_media()
    {
        $this->db->select('*');
        $this->db->from(ADMIN_SETTINGS);
        return $result = $this->db->get();

    }

    public function get_exprience_view_details_withFilter($condition = '')
    {
        $select_qry = "select p.*,extyp.experience_title as type_title,d.from_date,u.image as user_image,rp.product_image as product_image,expAdd.city,(select IFNULL(count(R.id),0) from " . EXPERIENCE_REVIEW . " as R where R.product_id= p.experience_id and R.status='Active') as num_reviewers , (select IFNULL(avg(Rw.total_review),0) from " . EXPERIENCE_REVIEW . " as Rw where Rw.product_id= p.experience_id and Rw.status='Active') as avg_val from " . EXPERIENCE . " p  
		LEFT JOIN " . EXPERIENCE_TYPE . " extyp on extyp.id=p.type_id
		LEFT JOIN " . EXPERIENCE_ADDR . " expAdd on expAdd.experience_id=p.experience_id 
		LEFT JOIN " . EXPERIENCE_PHOTOS . " rp on rp.product_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_DATES . " d on d.experience_id=p.experience_id
		LEFT JOIN " . EXPERIENCE_TIMING . " dt on dt.exp_dates_id=d.id 

		LEFT JOIN " . USERS . " u on (u.id=p.user_id) " . $condition;
        $productList = $this->ExecuteQuery($select_qry);
        return $productList;

    }
    public function get_featured_cate_exp(){
        $this->db->select("et.*,count(e.experience_id) as total_experience_counts", false);
        $this->db->from(EXPERIENCE_TYPE . ' as et');
        $this->db->join(EXPERIENCE . ' as e', 'e.type_id = et.id');
        $this->db->join(EXPERIENCE_DATES . ' d', 'd  on d.experience_id=e.experience_id');
        $this->db->join(EXPERIENCE_TIMING . ' td', 'td.experience_id=e.experience_id');
        $this->db->where('et.featured = "1"');
        $this->db->where('td.status="1"');
        $this->db->where('e.status="1" and  d.from_date >"' . date('Y-m-d').'"');
        $this->db->order_by("et.dateAdded", desc);
        $this->db->group_by("et.id");
        return $result = $this->db->get();
    }
    public function get_featured_cate_exp_home(){
        $this->db->select("et.experience_id,");
        $this->db->from(EXPERIENCE . ' as et');
        $this->db->where(array('et.featured' => '1','et.status' => '1'));
        $this->db->limit(1);
        return $result = $this->db->get();
    }
}