<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This model contains all db functions related to admin management
 * @author Teamtweaks
 *
 */
class Admin_model extends My_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function add_edit_subadmin($dataArr = '', $condition = '')
	{
		if ($condition['id'] != '') {
			$this->db->where($condition);
			$this->db->update(ADMIN, $dataArr);
		} else {
			$this->db->insert(ADMIN, $dataArr);
		}
	}

	/**
	 *
	 * This function save the admin details in a file
	 */
	public function saveAdminSettings()
	{
		$getAdminSettingsDetails = $this->getAdminSettings();
		$config = '<?php ';
		foreach ($getAdminSettingsDetails->row() as $key => $val) {
			$value = addslashes($val);
			$config .= "\n\$config['$key'] = '$value'; ";
		}
		$config .= "\n\$config['message_pagination_per_page'] = '10'; ";
		$config .= "\n\$config['base_url'] = '" . base_url() . "'; ";
		$config .= ' ?>';
		$file = realpath('commonsettings/fc_admin_settings.php');
		file_put_contents($file, $config);
		$this->set_social_media_login_settings();
	}

	public function set_social_media_login_settings()
	{
		$FB_admin_settings = $this->db->select('facebook_app_id,facebook_app_secret')->get(ADMIN_SETTINGS);
		$linked_admin_settings = $this->db->select('linkedin_app_id,linkedin_app_key')->get(ADMIN_SETTINGS);
		$google_admin_settings = $this->db->select('google_client_id,google_client_secret,google_redirect_url')->get(ADMIN_SETTINGS);
		$config = '<?php ';
		if ($FB_admin_settings->num_rows() > 0) {
			$facebook_app_secret = $FB_admin_settings->row()->facebook_app_secret;
			$facebook_app_id = $FB_admin_settings->row()->facebook_app_id;
			$config .= "\n\$config['facebook_app_id'] = '$facebook_app_id'; ";
			$config .= "\n\$config['facebook_app_secret'] = '$facebook_app_secret'; ";
			$config .= "\n\$config['facebook_login_type'] = 'web'; ";
			$config .= "\n\$config['facebook_login_redirect_url'] = 'fb-login'; ";
			$config .= "\n\$config['facebook_logout_redirect_url'] = 'fb-logout'; ";
			$config .= "\n\$config['facebook_permissions'] = array('email'); ";
			$config .= "\n\$config['facebook_graph_version'] = 'v2.6'; ";
			$config .= "\n\$config['facebook_auth_on_load'] = 'TRUE'; ";
		}
		$config .= ' ?>';
		$file = realpath('application/config/facebook.php');
		file_put_contents($file, $config);
		$config = '<?php ';
		if ($google_admin_settings->num_rows() > 0) {
			$google_client_id = $google_admin_settings->row()->google_client_id;
			$google_client_secret = $google_admin_settings->row()->google_client_secret;
			$google_redirect_url = $google_admin_settings->row()->google_redirect_url;
			$config .= "\n\$config['google']['client_secret']  = '$google_client_secret'; ";
			$config .= "\n\$config['google']['client_id']  = '$google_client_id'; ";
			$config .= "\n\$config['google']['redirect_uri'] = '$google_redirect_url';";
			$config .= "\n\$config['google']['application_name'] = ''; ";
			$config .= "\n\$config['google']['api_key']  = ''; ";
			$config .= "\n\$config['google']['scopes'] = array(); ";
		}
		$config .= ' ?>';
		$file = realpath('application/config/google.php');
		file_put_contents($file, $config);
		$config = '<?php ';
		if ($linked_admin_settings->num_rows() > 0) {
			$linkedin_app_id = $linked_admin_settings->row()->linkedin_app_id;
			$linkedin_app_key = $linked_admin_settings->row()->linkedin_app_key;
			$config .= "\n\$config['linkedin_api_key'] = '$linkedin_app_id'; ";
			$config .= "\n\$config['linkedin_api_secret'] = '$linkedin_app_key'; ";
			$config .= "\n\$config['linkedin_redirect_url'] = 'linkedin-login'; ";
			$config .= "\n\$config['linkedin_scope'] = 'r_basicprofile r_emailaddress'; ";
		}
		$config .= ' ?>';
		$file = realpath('application/config/linkedin.php');
		file_put_contents($file, $config);
	}

	/**
	 *
	 * This function is to get Active Countries to set admin country
	 */
	public function getActiveCountries()
	{
		$this->db->select('id,name');
		$this->db->from(LOCATIONS);
		$this->db->where('status', 'Active');
		$this->db->order_by('name');
		$query = $this->db->get();
		return $query;
	}		

	public function get_adv_result(){		$this->db->select('*');        $this->db->from(ADVERTISMENT);        $Query = $this->db->get();        return $Query;	}
}
