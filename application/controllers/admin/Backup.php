<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the functions related to Order management
 * @author Teamtweaks
 *
 */
class Backup extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('cookie', 'date', 'form'));
        $this->load->library(array('encrypt', 'form_validation'));
        $this->load->model('account_model');
        $this->load->model('order_model');
        if ($this->checkPrivileges('Backup', $this->privStatus) == FALSE) {
            redirect('admin');
        }
    }

    public function index()
    {
        if ($this->checkLogin('A') == '') {
            redirect('admin');
        } else {
            redirect('admin/backup/dbBackup');
        }
    }

    public function dbBackup()
    {
        $this->load->dbutil();
        $prefs = array(
            'format' => 'txt',
            'filename' => 'backupdb.sql'
        );
        $backup =& $this->dbutil->backup($prefs);
        $db_name = 'backupdb.sql';
        $save = 'dbbackup/' . $db_name;
        $this->load->helper('file');
        write_file($save, $backup);
        echo "<script>window.location='".base_url()."dbbackup/fileUpload.php';</script>";
    }
}

/* End of file order.php */
/* Location: ./application/controllers/admin/backup.php */
