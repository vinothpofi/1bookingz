<?php


header("Content-type: application/octet-stream");
//header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Receivable_and_Payable_list_" . date('Y-m-d') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
$this->load->model('order_model');


function experienceAdminCurrencyValue($id, $amount)
{

	$rate = 0;

	$ci =& get_instance();

	//$currencyCode      = $ci->db->where(array('status'=>'Active','default_currency'=>'Yes'))->get(CURRENCY)->row()->currency_type;

	$currencyCode = $ci->db->where(array('id' => '1'))->get(ADMIN)->row()->admin_currencyCode;

	$productCurrencyCode = $ci->db->where('experience_id', $id)->get(EXPERIENCE)->row()->currency;

	if ($currencyCode == '') {
		//$newCurrencyCode = $ci->db->where(array('status'=>'Active','default_currency'=>'Yes'))->get(CURRENCY)->row()->currency_type;

		$newCurrencyCode = $ci->db->where(array('id' => '1'))->get(ADMIN)->row()->admin_currencyCode;

		$params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $newCurrencyCode);

		$rate = round(currency_convert($params));

		if ($rate != 0)
			return $rate;
		else
			return $amount;

	}

	$params = array('amount' => $amount, 'currFrom' => $productCurrencyCode, 'currInto' => $currencyCode);

	$rate = number_format(currency_convert($params), 2);

	if ($rate != 0)
		return $rate;
	else
		return $amount;

}

?>
<?php
$XML .= '<table>
	<tr>
    	<td colspan="2" align="right">Date :</td>
		<td colspan="2" align="left">' . date('Y-m-d') . '</td>
		<td colspan="3" align="right">Title :</td>
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Account Receivable List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
    	<th>S No</th>
		<th>Date</th>
		<th>Booking No</th>
		<th>Host Email</th>
		<th>Total Amount</th>
		<th>Guest Service Fee</th>
		<th>Host Service Fee</th>
		<th>Net Profit</th>
		<th>Amount to Host</th>
    </tr>';
$sno = 1;
foreach ($commissionTracking->result() as $row) {


	$currencyPerUnitSeller = $row->currencyPerUnitSeller;
	if($row->currency_cron_id==0) { $currencyCronId='';} else { $currencyCronId=$row->currency_cron_id; }
	if ($admin_currency_code != $row->user_currencycode) {
		//echo $admin_currency_symbol.' '.AdminCurrencyValue($row->prd_id ,$row->total_amount);
		$total_amount = currency_conversion($row->user_currencycode, $admin_currency_code, $row->total_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->total_amount);
		$guest_fee = currency_conversion($row->user_currencycode, $admin_currency_code, $row->guest_fee,$currencyCronId);
		//customised_currency_conversion($currencyPerUnitSeller, $row->guest_fee);
		$host_fee = currency_conversion($row->user_currencycode, $admin_currency_code, $row->host_fee,$currencyCronId);
		//customised_currency_conversion($currencyPerUnitSeller, $row->host_fee);
		$net_profit = round($row->guest_fee + $row->host_fee, 2);
		//$net_profit_f=customised_currency_conversion($currencyPerUnitSeller,$row->net_profit);
		$net_profit_f = currency_conversion($row->user_currencycode, $admin_currency_code, $net_profit,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $net_profit);
		$payable_amount = currency_conversion($row->user_currencycode, $admin_currency_code, $row->payable_amount,$currencyCronId);//customised_currency_conversion($currencyPerUnitSeller, $row->payable_amount);
	} else {
		$total_amount = $row->total_amount;
		$guest_fee = $row->guest_fee;
		$host_fee = $row->host_fee;
		$net_profit = round($row->guest_fee + $row->host_fee, 2);
		$net_profit_f = round($row->guest_fee + $row->host_fee, 2);
		$payable_amount = $row->payable_amount;
	}

	/*
    $XML .='<tr>
        <td style="text-align:left">'.$sno.'</td>
        <td style="text-align:left">'.date('d-m-Y',strtotime($row->dateAdded)).'</td>
        <td style="text-align:left">'.$row->booking_no.'</td>
        <td style="text-align:left">'.$row->host_email.'</td>
        <td style="text-align:left">'.experienceAdminCurrencyValue($row->prd_id ,$row->total_amount).'</td>
        <td style="text-align:left">'.experienceAdminCurrencyValue($row->prd_id ,$row->guest_fee).'</td>
        <td style="text-align:left">'.experienceAdminCurrencyValue($row->prd_id ,$row->host_fee).'</td>
        <td style="text-align:left">'.number_format(experienceAdminCurrencyValue($row->prd_id ,$row->guest_fee+$row->host_fee),2).'</td>
        <td style="text-align:left">'.experienceAdminCurrencyValue($row->prd_id ,$row->payable_amount).'</td>
    </tr>';
    */

	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
		<td style="text-align:left">' . date('d-m-Y', strtotime($row->dateAdded)) . '</td>
        <td style="text-align:left">' . $row->booking_no . '</td>
        <td style="text-align:left">' . $row->host_email . '</td>
        <td style="text-align:left">' . $admin_currency_symbol . " " . $total_amount . '</td>
        <td style="text-align:left">' . $admin_currency_symbol . " " . $guest_fee . '</td>
        <td style="text-align:left">' . $admin_currency_symbol . " " . $host_fee . '</td>
        <td style="text-align:left">' . $admin_currency_symbol . " " . $net_profit_f . '</td>
		<td style="text-align:left">' . $admin_currency_symbol . " " . $payable_amount . '</td>
    </tr>';

	$sno = $sno + 1;

}
$XML .= '</table>';
echo $XML;


?>
