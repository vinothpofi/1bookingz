<?php
header("Content-type: application/octet-stream");
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
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Listing Payment</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	<th>No</th>
		
        <th>Host Email</th> 
        <th>Property Title</th> 
		<th>Payment Date</th>
		<th>Total(Host)</th>
		<th>Total(Admin)</th>
		<th>Commission</th>
		<th>Payable amount(Host)</th>
		<th>Payable amount(Admin)</th>
		<th>Transaction(ID)</th>
		<th>Payment Type</th>
        <th>Status</th>
    </tr>';
$sno = 1;
foreach ($getCustomerDetails as $myrow) 
{
	if ($this->data['admin_currency_code'] != $myrow['currency_code_host']) 
	{
		//$currencyPerUnitSeller = $myrow['unitPerCurrencyHost'];
		//$amount = customised_currency_conversion($currencyPerUnitSeller, $myrow['amount']);
		$createdDate = date('Y-m-d',strtotime($myrow['created']));
		$gotCronId = $this->db->select('curren_id')->where('created_date',$createdDate)->get('fc_currency_cron')->row()->curren_id;
		if($gotCronId!='')
		{
			$amount = currency_conversion($myrow['currency_code_host'], $this->data['admin_currency_code'], $myrow['amount'],$gotCronId);
		}
		else
		{
			$amount = currency_conversion($myrow['currency_code_host'], $this->data['admin_currency_code'], $myrow['amount']);
		}
	}
	else
	{
		$amount = $myrow['amount'];
	}

	$bookedstatus = ($myrow[status] == "Pending") ? "Failed" : $myrow[status];
	if ($myrow['paypal_txn_id'] != '') 
	{
		$tran_id = $myrow['paypal_txn_id'];
	} 
	else 
	{
		$tran_id = "---";
	}

	$unitPerCurrencyHost = $myrow['unitPerCurrencyHost'];

	if ($this->data['admin_currency_code'] != $myrow['currency_code_host']) 
	{
		//$theHostingPrice = $myrow[hosting_price] * $myrow['unitPerCurrencyHost'];
		//$hostingPrice = $theHostingPrice . " " . $myrow['currency_code_host'];
		if($gotCronId!='')
		{
			$hostingPrice = currency_conversion($this->data['admin_currency_code'],$myrow['currency_code_host'], $myrow[hosting_price],$gotCronId);
		}
		else
		{
			$hostingPrice = currency_conversion($this->data['admin_currency_code'],$myrow['currency_code_host'], $myrow[hosting_price]);
		}
	} 
	else
	{
		$hostingPrice = $admin_currency_symbol . ' ' . $myrow[hosting_price];
	}

	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
		<td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
		 <td style="text-align:left">' . ucfirst($myrow[prd_name]) . '</td>
		 <td style="text-align:left">' . date('m-d-Y', strtotime($myrow[created])) . '</td>
		 
		<td style="text-align:left">' . ucfirst($myrow[amount]) . " " . ucfirst($myrow[currency_code_host]) . '</td>
		 <td style="text-align:left">' . $admin_currency_symbol . $amount . '</td>
		<td style="text-align:left">' . ucfirst($myrow[commission]) . "(" . ucfirst($myrow[commission_type]) . ")" . '</td>
		<td style="text-align:left">' . $hostingPrice . '</td>
		
		<td style="text-align:left">' . $admin_currency_symbol . " " . $myrow['hosting_price'] . '</td>
		<td style="text-align:left">' . $tran_id . '</td>
        <td style="text-align:left">' . ucfirst($myrow[payment_type]) . '</td>
        <td style="text-align:left">Paid</td>
    </tr>';
	$sno = $sno + 1;
}
$XML .= '</table>';
echo $XML;
?>
