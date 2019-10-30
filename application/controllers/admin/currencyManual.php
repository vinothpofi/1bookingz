<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**  
 * 
 * This controller contains the functions related to user management 
 * @author Teamtweaks
 *
 */

class CurrencyManual extends MY_Controller {

	function __construct(){
        parent::__construct();
		$this->load->helper(array('cookie','date','form'));
		$this->load->library(array('encrypt','form_validation'));		
		$this->load->model('slider_model');
		if ($this->checkPrivileges('Slider',$this->privStatus) == FALSE){
			redirect('admin');
		}
		if ($this->lang->line('Manual_currency') != '') 
		{ 
			$this->data['mytitle'] = stripslashes($this->lang->line('Manual_currency')); 
		} 
		else 
		{
			$this->data['mytitle'] = "Manual Currency Update";
		}
		
    }
    
    /**
     * 
     * This function loads the users list page
     */
    public function index(){
        if ($this->checkLogin('A') == ''){
            redirect('admin');
        }else {
            $this->db->select('*');
            $this->db->from('fc_currency_cron');
            $this->db->order_by('curren_id','desc');
            $this->db->limit(1);
            $results = $this->db->get()->row();
            $resultArray = json_decode($results->currency_values,true);

            $currencyCodeArray =array();
            $get_currency_symbol = $this->db->select('currency_type')->from('fc_currency')->order_by('currency_type','ASC')->distinct()->get()->result_array();
            foreach($get_currency_symbol as $curr)
            {
                $currencyCodeArray[]=$curr['currency_type'];
            }
            $table = '
			<div style="overflow-x: scroll;">
			<table class="display data_table" style="width:164%;">
				<thead>
				<tr>
					<th></th>';
               foreach($currencyCodeArray as $cca)
            {
                $table .= '
					<th>'.$cca.'</th>';
            }
            $table .= '
				</tr>
			</thead>
				<tbody>';
            foreach($currencyCodeArray as $cca)
            {
                $table .= '
				
				<tr>
					<td><strong>1 '.$cca.'</strong></td>
					';
                $i=0;
                foreach($currencyCodeArray as $newcca)
                {
                    foreach($resultArray as $iteration1)
                    {
                        foreach($iteration1 as $iteration2)
                        {
                            if($iteration2['from']==$cca)
                            {

                                if($iteration2['rates'][$newcca] !='') {
                                    $val = $iteration2['rates'][$newcca];
                                }else{
                                    $val = '0.00';
                                }
                                if($newcca == $cca){
                                    $table .= '
						<td><input type="text" readonly name="' . $cca . '[' . $newcca . ']" value="' . $val . '" /></td>
						';
                                }else{
                                    $table .= '
						<td><input type="text" name="' . $cca . '[' . $newcca . ']" title="1 ' . $cca . ' - 1 ' . $newcca . '" value="' . $val . '" /></td>
						';
                                }
                            }
                        }
                    }
                    $i++;
                }
                $table .= '
				</tr>';
            }
            $table .= '</tbody>
			<tfoot>
				<tr>
					<th></th>';
            foreach($currencyCodeArray as $cca)
            {
                $table .= '
					<th>'.$cca.'</th>';
            }
            $table .= '
				</tr>
			</tfoot>
			</table>
			</div>';
            $this->data['table'] = $table;
            $this->data['heading'] = $this->data['mytitle'];
            $this->data['action'] = site_url('admin/currencyManual/updateCurrency');
            $this->data['manualStatus'] = $this->slider_model->get_all_details('fc_admin_settings', array('id'=>'1'))->row();
            $this->load->view('admin/currencyManual/manual_currency',$this->data);
        }
    }
	public function updateCurrency()
	{
		$gotCurrencyValues = $this->input->post();
		foreach($gotCurrencyValues as $key=>$gcv)
		{
			if($key!='DataTables_Table_0_length')
			{
				$currencyArray['result']='success';
				$currencyArray['timestamp']=time();
				$currencyArray['from']=$key;
				$currencyArray['rates']=$gcv;
				$currency_data[] = $currencyArray;
			}
		}
		$currencydata["currency_data"]=$currency_data;
		$checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date',date('Y-m-d'))->get()->row(); 
		$data = array('admin_update' => '1','currency_values' => json_encode($currencydata),'created_date'=>date('Y-m-d'));
		if(count($checkTodayUpdated) > 0)
		{
			$this->db->where('created_date', date('Y-m-d'));
			$this->db->update('fc_currency_cron', $data);
		}
		else
		{
			$this->db->insert('fc_currency_cron', $data);
		}
		$this->setErrorMessage('success', 'Values are saved successfully');
        redirect('admin/currencyManual');
	
	}
	public function round_up ($value, $places=0) {
	  if ($places < 0) { $places = 0; }
	  $mult = pow(10, $places);
	  return ceil($value * $mult) / $mult;
	}
	public function cronFunction()
	{
		$manualUpdateStatus = $this->db->select('manual_currency_status')->where('id','1')->get('fc_admin')->row()->manual_currency_status;
		if($manualUpdateStatus==1) {
			$checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date',date('Y-m-d'))->get()->row(); 
			if(count($checkTodayUpdated) > 0)
			{
				
			}
			else
			{
				$result = $this->db->select('*')->from('fc_currency_cron')->order_by('curren_id','desc')->limit(1)->get()->row(); 
				$data = array('cron_update' => '1','currency_values' => json_encode($result->currency_values),'created_date'=>date('Y-m-d'));
				$this->db->insert('fc_currency_cron', $data);
				$this->setErrorMessage('success', 'Values are saved successfully');
				redirect('admin/currencyManual');
			}
		}
		else
		{
			$checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date',date('Y-m-d'))->get()->row(); 
			if(count($checkTodayUpdated) > 0)
			{
				
			}
			else
			{
				$exchangeRateApi = $this->db->where('id', '1')->get(ADMIN)->row()->exchange_rate_api;
				$currencyArr = array();
				$get_currency_symbol = $this->db->select('*')->from('fc_currency')->get();
				foreach($get_currency_symbol->result() as $sym){
					
					$currencyArr[] = json_decode(file_get_contents('https://v3.exchangerate-api.com/bulk/'.$exchangeRateApi.'/'.$sym->currency_type.''));
				}
				$json_encode = json_encode(array("currency_data" => $currencyArr));
				$dataArr = array('currency_values'=>$json_encode,'created_date'=>date('Y-m-d'),'cron_update' => '1');
				$this->db->insert('fc_currency_cron', $dataArr);
				$this->setErrorMessage('success', 'Values are saved successfully');
				redirect('admin/currencyManual');
			}
		}
	}
	public function apiCurrencyFun($status)
	{
		$exchangeRateApi = $this->db->where('id', '1')->get(ADMIN)->row()->exchange_rate_api;
		$currencyArr = array();
		$get_currency_symbol = $this->db->select('*')->from('fc_currency')->get();
		foreach($get_currency_symbol->result() as $sym){
			
			$currencyArr[] = json_decode(file_get_contents('https://v3.exchangerate-api.com/bulk/'.$exchangeRateApi.'/'.$sym->currency_type.''));
		}
		$json_encode = json_encode(array("currency_data" => $currencyArr));
		$dataArr = array('currency_values'=>$json_encode,'created_date'=>date('Y-m-d'),$status => '1');
		$checkTodayUpdated = $this->db->select('*')->from('fc_currency_cron')->where('created_date',date('Y-m-d'))->get()->row(); 
		if(count($checkTodayUpdated) > 0)
		{
			$this->db->where('created_date', date('Y-m-d'));
			$this->db->update('fc_currency_cron', $dataArr);
		}
		else
		{
			$this->db->insert('fc_currency_cron', $dataArr);
		}
		$this->setErrorMessage('success', 'Values are saved successfully');
        redirect('admin/currencyManual');
	}
	public function getPriceDet()
	{
		
		//print_r($currencyCodeArray);
		//exit;
		
		/*$currencyCodeArray =array();
		$get_currency_symbol = $this->db->select('currency_type')->from('fc_currency')->where('status','Active')->get()->result_array();
		foreach($get_currency_symbol as $curr)
		{
			$currencyCodeArray[]=$curr['currency_type'];
		}
		$this->db->select('*');
		$this->db->from('fc_currency_cron');
		$this->db->order_by('curren_id','desc');
		$this->db->limit(1);
		$results = $this->db->get()->row(); 
		$resultArray = json_decode($results->currency_values,true);
		foreach($resultArray as $iteration1)
		{
			foreach($iteration1 as $iteration2)
			{
				if($iteration2['from']=='USD')
				{
					echo '
					<div class="container">
						<h2>Currency conversion From '.$iteration2['from'].'</h2>
					';
					foreach($iteration2['rates'] as $currencyType=>$val)
					{
						if(in_array($currencyType,$currencyCodeArray))
						{
							//echo $currencyType.' == '.$val.'<bR>';
							echo '
							<li>
								<div class="form_grid_12">
									<label for="'.$currencyType.'" class="field_title">'.$currencyType.'</label>
									<div class="form_input">
										<input type="text" name="'.$currencyType.'" style="width:150px" maxlength="15" id="'.$currencyType.'" class="required tipTop" original-title="Please enter the '.$currencyType.' name" placeholder="tipTop" original-title="Please enter the '.$currencyType.' name" value="'.$val.'">
									</div>
								</div>
							</li>
							';
						}
					}
					echo 
					'
					</div><!-- CONTAINER END -->
					';
					exit;
				}
			}
		}*/
	}
}
/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */