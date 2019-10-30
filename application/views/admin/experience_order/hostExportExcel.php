<?php
header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Finance_listing_list_" . date('m-d-Y') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('user_model');


?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Finance Host List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	<th>No</th>
		<th>Host Email</th>
        <th>Propert Title</th> 
		<th>Payment Date</th>		
		<th>Total(Host)</th>
		<th>Total(Admin)</th>
		<th>Commission</th>
		<th>Payable Amount(Host)</th>
		<th>Payable Amount(Admin)</th>
		<th>Transaction ID</th>
		<th>Payment Type</th>    
        <th>Status</th>
    </tr>';
$sno = 1;
$admin_currency_code = $this->db->where('id', '1')->get(ADMIN)->row()->admin_currencyCode;
foreach ($getCustomerDetails as $myrow) {

	$bookedstatus = ($myrow[status] == "Pending") ? "Failed" : $myrow[status];

	$currencyPerUnitSeller = $myrow['unitPerCurrencyHost'];
	if ($admin_currency_code != $myrow['currency_code_host'])
	{
		$createdDate = date('Y-m-d',strtotime($myrow['created']));
		$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
		if($gotCronId==0) { $gotCronId='';}
		$amount = currency_conversion($myrow['currency_code_host'], $admin_currency_code, $myrow['price'],$gotCronId);
	} 
	else
	{
		$amount = $myrow['price'];
	}
	/*
        if($admin_currency_code!=$myrow['currency_code'] && $myrow['currency_code'] !='0' && $myrow['currency_code'] !=''){
            //echo convertCurrency($row->currency_code,$admin_currency_code,$row->total);
            $amount=customised_currency_conversion($currencyPerUnitSeller,$myrow['price']);
        }else
            $amount=$myrow['price']; */

	/*if ($admin_currency_code != $myrow['currency_code_host'] && $myrow['currency_code_host'] != '0' && $myrow['currency_code_host'] != '') {
		$amount = customised_currency_conversion($currencyPerUnitSeller, $myrow['price']);
	} else
		$amount = $myrow['price'];

 */
	/* if($admin_currency_code!=$myrow[currency_code_host]){
									
		$admin_price = $admin_currency_symbol.' '.customised_currency_conversion($unitPerCurrencyHost,$myrow[hosting_price]);
	}else
		$admin_price = $admin_currency_symbol." ".$myrow[hosting_price]; */


	/*if ($admin_currency_code != $myrow['currency_code_host']) {
		$theHostingPrice = $myrow[hosting_price] * $currencyPerUnitSeller;
	} else
		$theHostingPrice = $myrow[hosting_price];
	*/
	if ($admin_currency_code != $myrow['currency_code_host'])
	{
		$createdDate = date('Y-m-d',strtotime($myrow['created']));
		$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
		if($gotCronId==0) { $gotCronId='';}
		$theHostingPrice = currency_conversion($admin_currency_code,$myrow['currency_code_host'], $myrow[hosting_price],$gotCronId);
		
	} 
	else
	{
		$theHostingPrice = $myrow[hosting_price];
	}

	/*if($admin_currency_code!=$myrow['currency_code']){
		$amount = convertCurrency($myrow['currency_code'],$admin_currency_code,$myrow['amount']);
	}else
		$amount =  $myrow['amount'];
	
	*/
	if ($myrow[paypal_txn_id] != '') {
		$Trans_id = $myrow[paypal_txn_id];
	} else {
		$Trans_id = "---";
	}


	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
		<td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[prd_name]) . '</td>
		<td style="text-align:left">' . date('m-d-Y', strtotime($myrow[created])) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[price]) . " " . ucfirst($myrow[currency_code_host]) . '</td>
		<td style="text-align:left">' . $admin_currency_symbol . $amount . '</td>
		<td style="text-align:left">' . ucfirst($myrow[commission]) . "(" . ucfirst($myrow[commission_type]) . ")" . '</td>
		
		<td style="text-align:left">' . ucfirst($theHostingPrice) . " " . ucfirst($myrow[currency_code_host]) . '</td>
		<td style="text-align:left">' . $admin_currency_symbol . " " . $myrow[hosting_price] . '</td>
        <td style="text-align:left">' . $Trans_id . '</td>
        <td style="text-align:left">' . ucfirst($myrow[payment_type]) . '</td>
        <td style="text-align:left">Paid</td>
    </tr>';
	$sno = $sno + 1;


}
$XML .= '</table>';
echo $XML;


?>
