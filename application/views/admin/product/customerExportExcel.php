<?php
header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Homestay_rentals_list".date('m-d-Y').".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('user_model');
?>
<?php
/*$XML = "Date\t". date('Y-m-d'). "\nTitle\t ".$this->config->item('site_title')." Renters Details List\n\n\tNo\tFirstName\tLastName\tEmail\tDate Registered\tDaily Alerts\tWeekly Alerts\tMonthly Alerts\tLast Login\tLogin IP\tStatus\n";
$file =$this->config->item('site_title')."_Order_details_". date("Y-m-d"). ".xls";
$sno = 1;
foreach($getCustomerDetails as $myrow) {
								$this->load->model('user_model');
								  $a = $this->user_model->get_users_alert_details($myrow['id'],'Daily');
								  $getAvalue= $a->num_rows();
								  $b = $this->user_model->get_users_alert_details($myrow['id'],'Weekly');
								  $getBvalue= $b->num_rows();
								  $c = $this->user_model->get_users_alert_details($myrow['id'],'Monthly');
								  $getCvalue= $c->num_rows();
	$XML.= "\t";
	$XML.= $sno. "\t";
	$XML.= $myrow[first_name]. "\t";
	$XML.= $myrow[last_name]. "\t";
	$XML.= $myrow[email]. "\t";
    $XML.= date('Y-m-d',strtotime($myrow[created])). "\t";
	$XML.= $getAvalue. "\t";
	$XML.= $getBvalue. "\t";
	$XML.= $getCvalue. "\t";
	$XML.= date('Y-m-d',strtotime($myrow[last_login_date])). "\t";
    $XML.= $myrow[last_login_ip]. "\t";
	$XML.= $myrow[status]. "\n";
	$sno=$sno+1;
	
}
		
echo $XML;*/
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">'. date('Y-m-d'). '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">'.$this->config->item('site_title').' Rental List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';	
		
$XML .= '<table border="1">
	<tr>
    	<th>S.No</th>
        <th>Rental Name</th>       
        <th>Rental Id</th>
		<th>Currency Type(Host)</th>
        <th>Rental Type</th>
        <th>Price(Host)</th>
		<th>Price(Admin)</th>
        
		<th>Added By</th>
        <th>Status</th>
        <th>Rental Created On</th>
    </tr>';
$sno = 1;
foreach($getCustomerDetails as $myrow) {

	
	$listings_hometype = $this->product_model->get_all_details('fc_listspace_values',array('id'=>$myrow[home_type])); 
								if($listings_hometype->row()->list_value == '' )  { 
								
							$property_type = '-'; } else {
							$property_type = ucfirst($listings_hometype->row()->list_value); }
								
								
								if($this->data['admin_currency_code'] != $myrow[currency] && ($myrow[currency]!='' || $myrow[currency]!='0'))
								{									$createdDate = date('Y-m-d',strtotime($myrow['created']));									$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;									if($gotCronId!='')									{										$price = currency_conversion($myrow['currency'], $this->data['admin_currency_code'], $myrow['price'],$gotCronId);										//convertCurrency($row->currency, $admin_currency_code, $row->price);									}									else									{										$price = currency_conversion($myrow['currency'], $this->data['admin_currency_code'], $myrow['price']);										//convertCurrency($row->currency, $admin_currency_code, $row->price);									}
									//$price = convertCurrency($myrow[currency],$this->data['admin_currency_code'],$myrow[price]);	
								}	
								else
								{	$price = $myrow[price]; }

									if($myrow[user_name]!='') { $username=$myrow[user_name]; } else { $username="Admin"; }

								 /* 
								 <td style="text-align:left">'.($myrow[user_name]=="")?"Admin":ucfirst($myrow[user_name]).'</td>
								 <td style="text-align:left">'.ucfirst($myrow[user_name]).'</td>
								 $a = $this->user_model->get_users_alert_details($myrow['id'],'Daily');
								  $getAvalue= $a->num_rows();
								  $b = $this->user_model->get_users_alert_details($myrow['id'],'Weekly');
								  $getBvalue= $b->num_rows();
								  $c = $this->user_model->get_users_alert_details($myrow['id'],'Monthly');
								  $getCvalue= $c->num_rows();*/
	$XML .='<tr>
    	<td style="text-align:left">'.$sno.'</td>
        <td style="text-align:left">'.ucfirst($myrow[product_title]).'</td>
		<td style="text-align:left">'.ucfirst($myrow[id]).'</td>
        <td style="text-align:left">'.ucfirst($myrow[currency]).'</td>
		
        <td style="text-align:left">'.$property_type.'</td>
		<td style="text-align:left">'.$this->db->select('*')->from('fc_currency')->where('currency_type = ', $myrow[currency])->get()->row()->currency_symbols.' '.ucfirst($myrow[price]).'</td>
        <td style="text-align:left">'.$admin_currency_symbol." ".$price.'</td>
       
        <td style="text-align:left">'.ucfirst($username).'</td>
        <td style="text-align:left">'.$myrow[status].'</td>
        <td style="text-align:left">'.$myrow[created].'</td>

    </tr>';
	$sno=$sno+1;

}
	$XML .='</table>';	
echo $XML;

    
    







?>
                                                               