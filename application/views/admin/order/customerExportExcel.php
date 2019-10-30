<?php
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Finance_paid_list_" . date('m-d-Y') . ".xls");
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
        <td colspan="3" align="left">' . $this->config->item('site_title') . ' Finance ' . $status . ' List</td>
        
	</tr>
	<tr>
    	<td colspan="11">&nbsp;</td>
	</tr>
	</table>';

$XML .= '<table border="1">
	<tr>
			<th>S no</th>
			<th>User Email</th> 
			<th>Payment Date</th>
			<th>Booking No</th>
			<th>Total</th>';
if ($status == "Paid") 
{
	$XML .= '<th>Payment Type</th>';
}
$XML .= '<th>Status</th>
    </tr>';
$sno = 1;
$admin_currency_code = $this->db->where('id', '1')->get(ADMIN)->row()->admin_currencyCode;
foreach ($getCustomerDetails as $myrow) 
{
	$currencyPerUnitSeller = $myrow['currencyPerUnitSeller'];

	if ($admin_currency_code != $myrow['currency_code'] && $myrow['currency_code'] != '0' && $myrow['currency_code'] != '') 
	{
		$amount = currency_conversion($myrow['currency_code'], $admin_currency_code, $myrow['total'],$myrow['currency_cron_id']);
		/*if ($currencyPerUnitSeller > 0)
		{
			$amount = customised_currency_conversion($currencyPerUnitSeller, $myrow['total']);
		}
		else
		{
			$amount = convertCurrency($myrow['currency_code'], $admin_currency_code, $myrow['total']);
		}*/
	} 
	else
	{
		$amount = $myrow['total'];
	}

	$bookedstatus = ($myrow[status] == "Pending") ? "Failed" : $myrow[status];
	$ptype = ($myrow[payment_type] == "Credit Cart") ? "Credit Card" : $myrow[payment_type];
	$XML .= '<tr>
    	<td style="text-align:left">' . $sno . '</td>
		<td style="text-align:left">' . ucfirst($myrow[email]) . '</td>
		<td style="text-align:left">' . date('m-d-Y', strtotime($myrow[created])) . '</td>
		<td style="text-align:left">' . ucfirst($myrow[bookingno]) . '</td>
        <td style="text-align:left">' . $admin_currency_symbol . $amount . '</td>';

	if ($bookedstatus == "Paid") 
	{
		$XML .= '<td style="text-align:left">' . ucfirst($myrow[payment_type]) . '</td>';
	}
	$XML .= '<td style="text-align:left">' . $bookedstatus . '</td>
    </tr>';
	$sno = $sno + 1;
}
$XML .= '</table>';
echo $XML;
?>
